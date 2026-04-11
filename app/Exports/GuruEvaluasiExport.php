<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuruEvaluasiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Guru::with('clusterTerakhir')
            ->leftJoin('hasil_clustering', 'guru.id', '=', 'hasil_clustering.guru_id')
            ->select(
                'guru.nama',
                'guru.nip',
                'guru.mata_pelajaran',
                'hasil_clustering.cluster',
                'hasil_clustering.label_cluster',
                'hasil_clustering.nilai_rata_rata'
            )
            ->get();
    }

    public function headings(): array
    {
        return ['Nama', 'NIP', 'Mata Pelajaran', 'Cluster', 'Label', 'Nilai Rata-rata'];
    }
}
