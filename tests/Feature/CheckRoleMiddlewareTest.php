<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_cannot_access_admin_page(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);
        $response = $this->actingAs($siswa)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_siswa_cannot_access_guru_page(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);
        $response = $this->actingAs($siswa)->get('/guru/kuesioner');
        $response->assertStatus(403);
    }

    public function test_siswa_cannot_access_kepala_page(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);
        $response = $this->actingAs($siswa)->get('/kepala/dashboard');
        $response->assertStatus(403);
    }

    public function test_guru_cannot_access_admin_page(): void
    {
        $userGuru = User::factory()->create(['role' => 'guru']);
        Guru::create(['user_id' => $userGuru->id, 'nama' => $userGuru->name, 'nip' => '111', 'mata_pelajaran' => 'Math']);
        $response = $this->actingAs($userGuru)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_guru_cannot_access_siswa_page(): void
    {
        $userGuru = User::factory()->create(['role' => 'guru']);
        Guru::create(['user_id' => $userGuru->id, 'nama' => $userGuru->name, 'nip' => '112', 'mata_pelajaran' => 'Math']);
        $response = $this->actingAs($userGuru)->get('/siswa/kuesioner');
        $response->assertStatus(403);
    }

    public function test_admin_cannot_access_guru_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/guru/kuesioner');
        $response->assertStatus(403);
    }

    public function test_admin_cannot_access_siswa_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/siswa/kuesioner');
        $response->assertStatus(403);
    }

    public function test_guest_redirected_to_login_on_protected_route(): void
    {
        $response = $this->get('/admin/users');
        $response->assertRedirect('/login');
    }

    public function test_guest_redirected_to_login_on_guru_route(): void
    {
        $response = $this->get('/guru/kuesioner');
        $response->assertRedirect('/login');
    }

    public function test_guest_redirected_to_login_on_siswa_route(): void
    {
        $response = $this->get('/siswa/kuesioner');
        $response->assertRedirect('/login');
    }
}