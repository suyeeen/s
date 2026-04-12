<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Halaman '/' redirect ke login jika belum login
     */
    public function test_homepage_redirects_to_login_if_not_authenticated(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    /**
     * Halaman login dapat diakses
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * User dengan role admin diarahkan ke halaman admin setelah login
     */
    public function test_admin_is_redirected_to_admin_page_after_login(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/');

        $response->assertRedirect('/admin/users');
    }

    /**
     * User dengan role guru diarahkan ke halaman kuesioner guru
     */
    public function test_guru_is_redirected_to_guru_kuesioner(): void
    {
        $guru = User::factory()->create(['role' => 'guru']);

        $response = $this->actingAs($guru)->get('/');

        $response->assertRedirect('/guru/kuesioner');
    }

    /**
     * User dengan role siswa diarahkan ke halaman kuesioner siswa
     */
    public function test_siswa_is_redirected_to_siswa_kuesioner(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($siswa)->get('/');

        $response->assertRedirect('/siswa/kuesioner');
    }

    /**
     * Halaman yang butuh auth tidak bisa diakses tanpa login
     */
    public function test_admin_page_requires_authentication(): void
    {
        $response = $this->get('/admin/users');

        $response->assertRedirect('/login');
    }
}
