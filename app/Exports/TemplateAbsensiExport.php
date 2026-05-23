<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TemplateAbsensiExport implements FromArray, WithStyles, ShouldAutoSize, WithTitle
{
    private array $data;

    public function __construct()
    {
        // Header
        $this->data = [
            // Baris 1: header kolom
            [
                'nama_guru',
                'nip',
                'bulan',
                'tahun',
                'jumlah_hadir',
                'jumlah_izin',
                'jumlah_sakit',
                'jumlah_alpha',
                'jumlah_terlambat',
                'total_hari_kerja',
            ],
        ];

        // Baris 2-4: contoh data
        $contoh = [
            ['Dewi Rahayu, M.Pd', '196501011990031005', '1',    '2026', '18', '2', '1', '0', '1', '22'],
            ['Ahmad Fauzi, S.Pd', '197203051998021003', '2',    '2026', '17', '1', '2', '0', '2', '22'],
            ['Siti Aminah',       '198004152005012010', 'Maret', '2026', '20', '0', '1', '1', '0', '22'],
        ];

        foreach ($contoh as $c) {
            $this->data[] = $c;
        }

        // Baris kosong pembatas
        $this->data[] = [];

        // FIX: Hindari string diawali '=' agar tidak dianggap formula oleh PhpSpreadsheet
        $this->data[] = ['** PANDUAN PENGISIAN **'];
        $this->data[] = ['Kolom nama_guru', ': Isi nama lengkap guru sesuai data sistem'];
        $this->data[] = ['Kolom nip',       ': Isi NIP guru (jika ada). Jika tidak ada, kosongkan'];
        $this->data[] = ['Kolom bulan',     ': Isi angka 1-12 atau nama bulan (Januari, Februari, dst)'];
        $this->data[] = ['Kolom tahun',     ': Isi tahun (contoh: 2026)'];
        $this->data[] = ['Kolom jumlah_*',  ': Isi jumlah hari per status dalam bulan tersebut'];
        $this->data[] = ['total_hari_kerja', ': Total hari kerja efektif (biasanya 20-23 hari)'];
        $this->data[] = [];

        // FIX: Hindari string diawali '=' agar tidak dianggap formula oleh PhpSpreadsheet
        $this->data[] = ['** DAFTAR GURU DI SISTEM **'];
        $this->data[] = ['nama_guru', 'nip'];

        // Ambil daftar guru dari database
        $guruList = Guru::select('nama', 'nip')->orderBy('nama')->get();
        foreach ($guruList as $guru) {
            $this->data[] = [$guru->nama, $guru->nip ?? '-'];
        }
    }

    public function array(): array
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Template Absensi';
    }

    public function styles(Worksheet $sheet)
    {
        $hijau     = '1A7A4A';
        $hijauMuda = 'E8F5EE';

        // Header row 1
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $hijau]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Baris contoh
        $sheet->getStyle('A2:J4')->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $hijauMuda]],
        ]);

        // Border untuk area data
        $sheet->getStyle('A1:J4')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Baris panduan
        $panduanStart = 7;
        $sheet->getStyle("A{$panduanStart}")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '333333']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF3CD']],
        ]);

        // Freeze baris header
        $sheet->freezePane('A2');

        return [];
    }
}
