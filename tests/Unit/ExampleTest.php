<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test method isAdmin() pada model User
     */
    public function test_user_is_admin(): void
    {
        $user = User::factory()->make(['role' => 'admin']);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isGuru());
        $this->assertFalse($user->isSiswa());
        $this->assertFalse($user->isKepsek());
    }

    /**
     * Test method isGuru() pada model User
     */
    public function test_user_is_guru(): void
    {
        $user = User::factory()->make(['role' => 'guru']);

        $this->assertTrue($user->isGuru());
        $this->assertFalse($user->isAdmin());
    }

    /**
     * Test method isSiswa() pada model User
     */
    public function test_user_is_siswa(): void
    {
        $user = User::factory()->make(['role' => 'siswa']);

        $this->assertTrue($user->isSiswa());
        $this->assertFalse($user->isAdmin());
    }

    /**
     * Test method isKepsek() pada model User
     */
    public function test_user_is_kepsek(): void
    {
        $user = User::factory()->make(['role' => 'kepsek']);

        $this->assertTrue($user->isKepsek());
        $this->assertFalse($user->isGuru());
    }

    /**
     * Test User memiliki atribut name, email, role
     */
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
}
