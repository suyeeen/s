<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Absensi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AbsensiImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public int   $berhasil = 0;
    public int   $duplikat = 0;
    public int   $gagal    = 0;
    public int   $diupdate = 0;
    public array $logGagal = [];
    public array $preview  = [];

    private bool $dryRun;
    private int  $adminId;

    /** Mapping nama/nip → guru untuk efisiensi */
    private Collection $guruList;

    public function __construct(bool $dryRun = false, int $adminId = 0)
    {
        $this->dryRun  = $dryRun;
        $this->adminId = $adminId;
        $this->guruList = Guru::select('id', 'nama', 'nip')->get();
    }

    public function chunkSize(): int
    {
        return 200;
    }

    public function collection(Collection $rows)
    {
        $namaBulan = [
            'januari' => 1,
            'februari' => 2,
            'maret' => 3,
            'april' => 4,
            'mei' => 5,
            'juni' => 6,
            'juli' => 7,
            'agustus' => 8,
            'september' => 9,
            'oktober' => 10,
            'november' => 11,
            'desember' => 12,
        ];

        foreach ($rows as $index => $row) {
            $baris = $index + 2;

            // Ambil nilai kolom
            $namaCari  = trim($row['nama_guru'] ?? $row['nama'] ?? '');
            $nipCari   = trim((string)($row['nip'] ?? ''));
            $bulanRaw  = strtolower(trim((string)($row['bulan'] ?? '')));
            $tahun     = (int)($row['tahun'] ?? 0);
            $hadir     = (int)($row['jumlah_hadir']     ?? 0);
            $izin      = (int)($row['jumlah_izin']      ?? 0);
            $sakit     = (int)($row['jumlah_sakit']     ?? 0);
            $alpha     = (int)($row['jumlah_alpha']     ?? 0);
            $terlambat = (int)($row['jumlah_terlambat'] ?? 0);
            $hariKerja = (int)($row['total_hari_kerja'] ?? 0);

            $errors = [];

            // ── Cari guru ────────────────────────────────────────────
            $guru = null;

            // 1. Prioritas: cocokkan NIP dulu (lebih akurat)
            if ($nipCari !== '') {
                $guru = $this->guruList->firstWhere('nip', $nipCari);
            }

            // 2. Fallback: cocokkan nama (case-insensitive)
            if (!$guru && $namaCari !== '') {
                $guru = $this->guruList->first(
                    fn($g) => strtolower(trim($g->nama)) === strtolower($namaCari)
                );
                // Fuzzy: cari yang nama-nya mengandung keyword
                if (!$guru) {
                    $guru = $this->guruList->first(
                        fn($g) => str_contains(strtolower($g->nama), strtolower($namaCari))
                            || str_contains(strtolower($namaCari), strtolower($g->nama))
                    );
                }
            }

            if (!$guru) {
                $errors[] = "Guru '{$namaCari}' (NIP: {$nipCari}) tidak ditemukan di database";
            }

            // ── Validasi bulan ────────────────────────────────────────
            $bulanAngka = 0;
            if (is_numeric($bulanRaw)) {
                $bulanAngka = (int)$bulanRaw;
            } elseif (isset($namaBulan[$bulanRaw])) {
                $bulanAngka = $namaBulan[$bulanRaw];
            }

            if ($bulanAngka < 1 || $bulanAngka > 12) {
                $errors[] = "Bulan '{$bulanRaw}' tidak valid (isi angka 1-12 atau nama bulan)";
            }

            // ── Validasi tahun ────────────────────────────────────────
            if ($tahun < 2000 || $tahun > date('Y') + 1) {
                $errors[] = "Tahun '{$tahun}' tidak valid";
            }

            // ── Validasi hari kerja ───────────────────────────────────
            if ($hariKerja < 1) {
                $errors[] = "Total hari kerja minimal 1";
            }

            if (!empty($errors)) {
                $this->gagal++;
                $this->logGagal[] = [
                    'baris'  => $baris,
                    'nama'   => $namaCari ?: '(kosong)',
                    'nip'    => $nipCari  ?: '-',
                    'alasan' => implode('; ', $errors),
                ];
                continue;
            }

            // ── Mode preview (dry run) ────────────────────────────────
            if ($this->dryRun) {
                $sudahAda = Absensi::where('guru_id', $guru->id)
                    ->where('bulan', $bulanAngka)
                    ->where('tahun', $tahun)
                    ->where('diinput_admin', true)
                    ->exists();

                $persen = $hariKerja > 0
                    ? round(($hadir + $terlambat) / $hariKerja * 100, 1)
                    : 0;

                $this->preview[] = [
                    'baris'      => $baris,
                    'guru'       => $guru->nama,
                    'nip'        => $guru->nip,
                    'periode'    => $bulanAngka . '/' . $tahun,
                    'hadir'      => $hadir,
                    'izin'       => $izin,
                    'sakit'      => $sakit,
                    'alpha'      => $alpha,
                    'terlambat'  => $terlambat,
                    'hari_kerja' => $hariKerja,
                    'persen'     => $persen,
                    'status'     => $sudahAda ? 'update' : 'baru',
                ];
                continue;
            }

            // ── Simpan ke database ────────────────────────────────────
            $existing = Absensi::where('guru_id', $guru->id)
                ->where('bulan', $bulanAngka)
                ->where('tahun', $tahun)
                ->where('diinput_admin', true)
                ->first();

            $payload = [
                'guru_id'          => $guru->id,
                'bulan'            => $bulanAngka,
                'tahun'            => $tahun,
                'tanggal'          => date('Y-m-d', mktime(0, 0, 0, $bulanAngka, 1, $tahun)),
                'jumlah_hadir'     => $hadir,
                'jumlah_izin'      => $izin,
                'jumlah_sakit'     => $sakit,
                'jumlah_alpha'     => $alpha,
                'jumlah_terlambat' => $terlambat,
                'total_hari_kerja' => $hariKerja,
                'status'           => 'hadir',
                'diinput_admin'    => true,
                'admin_id'         => $this->adminId,
            ];

            if ($existing) {
                $existing->update($payload);
                $this->diupdate++;
            } else {
                Absensi::create($payload);
                $this->berhasil++;
            }
        }
    }
}
