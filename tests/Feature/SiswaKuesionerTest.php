<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kuesioner;
use App\Models\Pertanyaan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaKuesionerTest extends TestCase
{
    use RefreshDatabase;

    private function buatSiswa(): array
    {
        $user  = User::factory()->create(['role' => 'siswa']);
        $siswa = Siswa::create(['user_id' => $user->id, 'nama' => $user->name, 'kelas' => 'X-A']);
        return [$user, $siswa];
    }

    private function buatGuru(): Guru
    {
        $userGuru = User::factory()->create(['role' => 'guru']);
        return Guru::create([
            'user_id'        => $userGuru->id,
            'nama'           => $userGuru->name,
            'nip'            => uniqid(),
            'mata_pelajaran' => 'Matematika',
        ]);
    }

    private function buatPertanyaan(int $jumlah = 3): array
    {
        $hasil    = [];
        $kategori = ['pedagogik', 'profesional', 'sosial'];
        for ($i = 0; $i < $jumlah; $i++) {
            $hasil[] = Pertanyaan::create([
                'teks_pertanyaan' => 'Pertanyaan ' . ($i + 1),
                'kategori'        => $kategori[$i % 3],
                'bobot'           => 1.00,
                'urutan'          => $i + 1,
                'untuk_penilai'   => 'siswa',
            ]);
        }
        return $hasil;
    }

    public function test_siswa_can_view_kuesioner_page(): void
    {
        [$user] = $this->buatSiswa();
        $response = $this->actingAs($user)->get('/siswa/kuesioner');
        $response->assertStatus(200);
    }

    public function test_siswa_can_submit_kuesioner(): void
    {
        [$user, $siswa] = $this->buatSiswa();
        $guru           = $this->buatGuru();
        $pertanyaan     = $this->buatPertanyaan(3);

        $jawaban = [];
        foreach ($pertanyaan as $p) {
            $jawaban[$guru->id][$p->id] = 4;
        }

        $response = $this->actingAs($user)->post('/siswa/kuesioner/submit', [
            'guru_ids' => [$guru->id],
            'jawaban'  => $jawaban,
        ]);

        $response->assertRedirect('/siswa/kuesioner');
        $this->assertDatabaseHas('kuesioner', [
            'guru_id'  => $guru->id,
            'siswa_id' => $siswa->id,
            'tipe'     => 'siswa',
        ]);
    }

    public function test_jawaban_tersimpan_setelah_submit(): void
    {
        [$user, $siswa] = $this->buatSiswa();
        $guru           = $this->buatGuru();
        $pertanyaan     = $this->buatPertanyaan(2);

        $jawaban = [];
        foreach ($pertanyaan as $p) {
            $jawaban[$guru->id][$p->id] = 3;
        }

        $this->actingAs($user)->post('/siswa/kuesioner/submit', [
            'guru_ids' => [$guru->id],
            'jawaban'  => $jawaban,
        ]);

        $kuesioner = Kuesioner::where('siswa_id', $siswa->id)->where('guru_id', $guru->id)->first();
        $this->assertNotNull($kuesioner);
        $this->assertCount(2, $kuesioner->jawaban);
    }

    public function test_submit_gagal_tanpa_guru_ids(): void
    {
        [$user] = $this->buatSiswa();
        $response = $this->actingAs($user)->post('/siswa/kuesioner/submit', [
            'jawaban' => [],
        ]);
        $response->assertSessionHasErrors();
    }

    public function test_siswa_tidak_bisa_menilai_guru_yang_sama_dua_kali(): void
    {
        [$user, $siswa] = $this->buatSiswa();
        $guru           = $this->buatGuru();
        $pertanyaan     = $this->buatPertanyaan(2);

        $jawaban = [];
        foreach ($pertanyaan as $p) {
            $jawaban[$guru->id][$p->id] = 5;
        }

        $payload = ['guru_ids' => [$guru->id], 'jawaban' => $jawaban];

        $this->actingAs($user)->post('/siswa/kuesioner/submit', $payload);
        $response = $this->actingAs($user)->post('/siswa/kuesioner/submit', $payload);

       $response->assertRedirect();
$response->assertSessionHas('error');
        $this->assertEquals(1, Kuesioner::where('siswa_id', $siswa->id)->where('guru_id', $guru->id)->count());
    }
}