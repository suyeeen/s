<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_users_page(): void
    {
        $response = $this->actingAs($this->admin())->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_siswa_user(): void
    {
        $response = $this->actingAs($this->admin())->post('/admin/users', [
            'name'     => 'Budi Santoso',
            'email'    => 'budi@sekolah.ac.id',
            'role'     => 'siswa',
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'budi@sekolah.ac.id', 'role' => 'siswa']);
        $this->assertDatabaseHas('siswa', ['nama' => 'Budi Santoso']);
    }

    public function test_admin_can_create_guru_user_and_guru_profile_created(): void
    {
        $response = $this->actingAs($this->admin())->post('/admin/users', [
            'name'     => 'Siti Rahma',
            'email'    => 'siti@sekolah.ac.id',
            'role'     => 'guru',
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'siti@sekolah.ac.id', 'role' => 'guru']);
        $this->assertDatabaseHas('guru', ['nama' => 'Siti Rahma']);
    }

    public function test_create_user_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'duplikat@sekolah.ac.id']);

        $response = $this->actingAs($this->admin())->post('/admin/users', [
            'name'     => 'User Lain',
            'email'    => 'duplikat@sekolah.ac.id',
            'role'     => 'siswa',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_admin_can_update_user(): void
    {
        $user = User::factory()->create(['role' => 'siswa', 'name' => 'Nama Lama']);

        $response = $this->actingAs($this->admin())->put('/admin/users/' . $user->id, [
            'name'  => 'Nama Baru',
            'email' => $user->email,
            'role'  => 'siswa',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Nama Baru']);
    }

    public function test_admin_can_delete_user(): void
    {
        $user = User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($this->admin())->delete('/admin/users/' . $user->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_create_user_fails_with_invalid_role(): void
    {
        $response = $this->actingAs($this->admin())->post('/admin/users', [
            'name'     => 'Test',
            'email'    => 'test@test.com',
            'role'     => 'superadmin',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('role');
    }
}