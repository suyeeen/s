<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kuesioner;
use App\Models\Pertanyaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruTest extends TestCase
{
    use RefreshDatabase;

    private function buatGuru(?string $nip = null): array
    {
        $user = User::factory()->create(['role' => 'guru']);
        $guru = Guru::create([
            'user_id'        => $user->id,
            'nama'           => $user->name,
            'nip'            => $nip ?? uniqid(),
            'mata_pelajaran' => 'IPA',
        ]);
        return [$user, $guru];
    }

    private function buatPertanyaanGuru(int $jumlah = 2): array
    {
        $hasil = [];
        for ($i = 0; $i < $jumlah; $i++) {
            $hasil[] = Pertanyaan::create([
                'teks_pertanyaan' => 'Pertanyaan guru ' . ($i + 1),
                'kategori'        => 'pedagogik',
                'bobot'           => 1.00,
                'urutan'          => $i + 1,
                'untuk_penilai'   => 'guru',
            ]);
        }
        return $hasil;
    }

    public function test_guru_can_view_absensi_page(): void
    {
        [$user] = $this->buatGuru();
        $response = $this->actingAs($user)->get('/guru/absensi');
        $response->assertStatus(200);
    }

    public function test_guru_dapat_scan_rfid_untuk_absensi(): void
    {
        [$user, $guru] = $this->buatGuru();
        $response = $this->actingAs($user)->post('/guru/absensi/scan');
        $response->assertRedirect();
        $this->assertDatabaseHas('absensi', ['guru_id' => $guru->id]);
    }

    public function test_guru_tidak_bisa_absen_dua_kali_sehari(): void
    {
        [$user, $guru] = $this->buatGuru();

        $this->actingAs($user)->post('/guru/absensi/scan');
        $response = $this->actingAs($user)->post('/guru/absensi/scan');

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertEquals(1, Absensi::where('guru_id', $guru->id)->count());
    }

    public function test_guru_can_view_profil_page(): void
    {
        [$user] = $this->buatGuru();
        $response = $this->actingAs($user)->get('/guru/profil');
        $response->assertStatus(200);
    }

    public function test_guru_can_view_kuesioner_page(): void
    {
        [$user] = $this->buatGuru();
        $response = $this->actingAs($user)->get('/guru/kuesioner');
        $response->assertStatus(200);
    }

    public function test_guru_dapat_submit_kuesioner_peer(): void
    {
        [$userPenilai, $guruPenilai] = $this->buatGuru('NIP001');
        [$userDinilai, $guruDinilai] = $this->buatGuru('NIP002');
        $pertanyaan = $this->buatPertanyaanGuru(2);

        $jawaban = [];
        foreach ($pertanyaan as $p) {
            $jawaban[$guruDinilai->id][$p->id] = 1;
        }

        $response = $this->actingAs($userPenilai)->post('/guru/kuesioner/submit', [
            'guru_ids' => [$guruDinilai->id],
            'jawaban'  => $jawaban,
        ]);

        $response->assertRedirect('/guru/kuesioner');
        $this->assertDatabaseHas('kuesioner', [
            'guru_id'         => $guruDinilai->id,
            'penilai_guru_id' => $guruPenilai->id,
            'tipe'            => 'guru',
        ]);
    }
}