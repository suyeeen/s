name: CI/CD Pipeline - STQM

on:
  push:
    branches: [ main ]
  pull_request:
    branches: [ main ]

concurrency:
  group: ${{ github.workflow }}-${{ github.ref }}
  cancel-in-progress: true

jobs:

  test:
    name: Run Tests
    runs-on: ubuntu-latest
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: secret
          MYSQL_DATABASE: stqm_testing
        ports:
          - 3306:3306
        options: >-
          --health-cmd="mysqladmin ping"
          --health-interval=10s
          --health-timeout=5s
          --health-retries=3
    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Setup PHP 8.3
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          extensions: pdo, pdo_mysql, mbstring, zip, gd, bcmath, exif, pcntl
          coverage: xdebug

      - name: Cache Composer dependencies
        uses: actions/cache@v4
        with:
          path: vendor
          key: composer-${{ hashFiles('composer.lock') }}
          restore-keys: composer-

      - name: Copy environment file
        run: cp .env.example .env

      - name: Install Composer dependencies
        run: composer install --no-interaction --prefer-dist --optimize-autoloader

      - name: Generate application key
        run: php artisan key:generate --ansi

      - name: Run database migrations
        env:
          DB_CONNECTION: mysql
          DB_HOST: 127.0.0.1
          DB_PORT: 3306
          DB_DATABASE: stqm_testing
          DB_USERNAME: root
          DB_PASSWORD: secret
        run: php artisan migrate --force

      - name: Run PHPUnit tests
        env:
          DB_CONNECTION: mysql
          DB_HOST: 127.0.0.1
          DB_PORT: 3306
          DB_DATABASE: stqm_testing
          DB_USERNAME: root
          DB_PASSWORD: secret
        run: php artisan test --coverage-text --min=50

  security:
    name: Security Scan
    runs-on: ubuntu-latest
    needs: test
    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Run Trivy security scan
        uses: aquasecurity/trivy-action@master
        with:
          scan-type: fs
          scan-ref: .
          severity: CRITICAL,HIGH
          exit-code: 0

  build:
    name: Build Docker Image
    runs-on: ubuntu-latest
    needs: security
    if: github.ref == 'refs/heads/main'
    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Set up Docker Buildx
        uses: docker/setup-buildx-action@v3

      - name: Build Docker image
        uses: docker/build-push-action@v5
        with:
          context: .
          push: false
          tags: stqm-app:latest
          cache-from: type=gha
          cache-to: type=gha,mode=max

      - name: Scan Docker image with Trivy
        uses: aquasecurity/trivy-action@master
        with:
          image-ref: stqm-app:latest
          severity: CRITICAL
          exit-code: 0

  deploy:
    name: Deploy to VPS
    runs-on: ubuntu-latest
    needs: [test, build]
    if: github.ref == 'refs/heads/main' && github.event_name == 'push'
    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Deploy via SSH
        uses: appleboy/ssh-action@v1.0.3
        with:
          host: ${{ secrets.VPS_HOST }}
          username: ${{ secrets.VPS_USER }}
          key: ${{ secrets.VPS_SSH_KEY }}
          port: 22
          command_timeout: 40m
          script: |
            cd /var/www/s

            echo "Pull kode terbaru..."
            git pull origin main || { echo "Git pull gagal!"; exit 1; }

            echo "Rebuild container..."
            docker-compose down
            docker-compose up -d --build || {
              echo "Deploy gagal! Rolling back..."
              docker-compose down
              git reset --hard HEAD~1
              docker-compose up -d --build
              exit 1
            }

            echo "Migrate dan cache..."
            docker-compose exec -T app php artisan migrate --force
            docker-compose exec -T app php artisan config:cache
            docker-compose exec -T app php artisan route:cache
            docker-compose exec -T app php artisan view:cache
            docker-compose exec -T app php artisan storage:link
            docker-compose exec -T -u root app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

            echo "Deploy selesai: $(date)"

  healthcheck:
    name: Health Check
    runs-on: ubuntu-latest
    needs: deploy
    if: github.ref == 'refs/heads/main' && github.event_name == 'push'
    steps:
      - name: Wait for app to start
        run: sleep 15

      - name: Check HTTP response
        run: |
          STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://${{ secrets.VPS_HOST }}:8080)
          echo "HTTP Status: $STATUS"
          if [ "$STATUS" != "200" ] && [ "$STATUS" != "302" ]; then
            echo "Health check gagal! Status: $STATUS"
            exit 1
          fi
          echo "App sehat! Status: $STATUS"

      - name: Check container status
        uses: appleboy/ssh-action@v1.0.3
        with:
          host: ${{ secrets.VPS_HOST }}
          username: ${{ secrets.VPS_USER }}
          key: ${{ secrets.VPS_SSH_KEY }}
          port: 22
          script: |
            docker-compose -f /var/www/s/docker-compose.yml ps
            echo "Container status checked"

  notify:
    name: Notify
    runs-on: ubuntu-latest
    needs: [deploy, healthcheck]
    if: always() && github.ref == 'refs/heads/main' && github.event_name == 'push'
    steps:
      - name: Notify deploy success
        if: needs.deploy.result == 'success' && needs.healthcheck.result == 'success'
        uses: appleboy/telegram-action@master
        with:
          to: ${{ secrets.TELEGRAM_CHAT_ID }}
          token: ${{ secrets.TELEGRAM_TOKEN }}
          message: |
            Deploy STQM Berhasil!
            Branch: ${{ github.ref_name }}
            Commit: ${{ github.event.head_commit.message }}
            By: ${{ github.actor }}
            URL: http://${{ secrets.VPS_HOST }}:8080

      - name: Notify deploy failed
        if: needs.deploy.result == 'failure' || needs.healthcheck.result == 'failure'
        uses: appleboy/telegram-action@master
        with:
          to: ${{ secrets.TELEGRAM_CHAT_ID }}
          token: ${{ secrets.TELEGRAM_TOKEN }}
          message: |
            Deploy STQM GAGAL!
            Branch: ${{ github.ref_name }}
            Commit: ${{ github.event.head_commit.message }}
            By: ${{ github.actor }}
            Cek: https://github.com/suyeeen/s_STQM/actions