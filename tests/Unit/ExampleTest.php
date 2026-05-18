<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_admin(): void
    {
        $user = User::factory()->make(['role' => 'admin']);
        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isGuru());
        $this->assertFalse($user->isSiswa());
        $this->assertFalse($user->isKepsek());
    }

    public function test_user_is_guru(): void
    {
        $user = User::factory()->make(['role' => 'guru']);
        $this->assertTrue($user->isGuru());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isSiswa());
        $this->assertFalse($user->isKepsek());
    }

    public function test_user_is_siswa(): void
    {
        $user = User::factory()->make(['role' => 'siswa']);
        $this->assertTrue($user->isSiswa());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isGuru());
        $this->assertFalse($user->isKepsek());
    }

    public function test_user_is_kepsek(): void
    {
        $user = User::factory()->make(['role' => 'kepsek']);
        $this->assertTrue($user->isKepsek());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isGuru());
        $this->assertFalse($user->isSiswa());
    }

    public function test_user_has_required_attributes(): void
    {
        $user = User::factory()->make([
            'name'  => 'Budi Santoso',
            'email' => 'budi@sekolah.ac.id',
            'role'  => 'guru',
        ]);
        $this->assertEquals('Budi Santoso', $user->name);
        $this->assertEquals('budi@sekolah.ac.id', $user->email);
        $this->assertEquals('guru', $user->role);
    }

    public function test_unknown_role_returns_false_for_all_helpers(): void
    {
        $user = User::factory()->make(['role' => 'unknown']);
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isGuru());
        $this->assertFalse($user->isSiswa());
        $this->assertFalse($user->isKepsek());
    }

    public function test_user_password_is_hashed(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret123')]);
        $this->assertNotEquals('secret123', $user->password);
        $this->assertTrue(Hash::check('secret123', $user->password));
    }
}