<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        $pertanyaan = [
            // ─── PEDAGOGIK (10 soal) ──────────────────────────────────────────
            ['kategori' => 'pedagogik', 'urutan' => 1,
             'teks_pertanyaan' => 'Guru menguasai karakteristik peserta didik dari aspek fisik, moral, sosial, kultural, emosional, dan intelektual.'],
            ['kategori' => 'pedagogik', 'urutan' => 2,
             'teks_pertanyaan' => 'Guru menguasai teori belajar dan prinsip-prinsip pembelajaran yang mendidik.'],
            ['kategori' => 'pedagogik', 'urutan' => 3,
             'teks_pertanyaan' => 'Guru mengembangkan kurikulum yang terkait dengan mata pelajaran yang diampu.'],
            ['kategori' => 'pedagogik', 'urutan' => 4,
             'teks_pertanyaan' => 'Guru menyelenggarakan pembelajaran yang mendidik.'],
            ['kategori' => 'pedagogik', 'urutan' => 5,
             'teks_pertanyaan' => 'Guru memanfaatkan teknologi informasi dan komunikasi untuk kepentingan pembelajaran.'],
            ['kategori' => 'pedagogik', 'urutan' => 6,
             'teks_pertanyaan' => 'Guru memfasilitasi pengembangan potensi peserta didik untuk mengaktualisasikan berbagai potensi yang dimiliki.'],
            ['kategori' => 'pedagogik', 'urutan' => 7,
             'teks_pertanyaan' => 'Guru berkomunikasi secara efektif, empatik, dan santun dengan peserta didik.'],
            ['kategori' => 'pedagogik', 'urutan' => 8,
             'teks_pertanyaan' => 'Guru menyelenggarakan penilaian dan evaluasi proses dan hasil belajar.'],
            ['kategori' => 'pedagogik', 'urutan' => 9,
             'teks_pertanyaan' => 'Guru memanfaatkan hasil penilaian dan evaluasi untuk kepentingan pembelajaran.'],
            ['kategori' => 'pedagogik', 'urutan' => 10,
             'teks_pertanyaan' => 'Guru melakukan tindakan reflektif untuk peningkatan kualitas pembelajaran.'],

            // ─── KEPRIBADIAN (5 soal) ─────────────────────────────────────────
            ['kategori' => 'kepribadian', 'urutan' => 1,
             'teks_pertanyaan' => 'Guru bertindak sesuai dengan norma agama, hukum, sosial, dan kebudayaan nasional Indonesia.'],
            ['kategori' => 'kepribadian', 'urutan' => 2,
             'teks_pertanyaan' => 'Guru menampilkan diri sebagai pribadi yang jujur, berakhlak mulia, dan teladan bagi peserta didik dan masyarakat.'],
            ['kategori' => 'kepribadian', 'urutan' => 3,
             'teks_pertanyaan' => 'Guru menampilkan diri sebagai pribadi yang mantap, stabil, dewasa, arif, dan berwibawa.'],
            ['kategori' => 'kepribadian', 'urutan' => 4,
             'teks_pertanyaan' => 'Guru menunjukkan etos kerja, tanggung jawab yang tinggi, rasa bangga menjadi guru, dan rasa percaya diri.'],
            ['kategori' => 'kepribadian', 'urutan' => 5,
             'teks_pertanyaan' => 'Guru menjunjung tinggi kode etik profesi guru.'],

            // ─── SOSIAL (5 soal) ──────────────────────────────────────────────
            ['kategori' => 'sosial', 'urutan' => 1,
             'teks_pertanyaan' => 'Guru bersikap inklusif, bertindak objektif, serta tidak diskriminatif karena pertimbangan jenis kelamin, agama, ras, kondisi fisik, latar belakang keluarga, dan status sosial ekonomi.'],
            ['kategori' => 'sosial', 'urutan' => 2,
             'teks_pertanyaan' => 'Guru berkomunikasi secara efektif, empatik, dan santun dengan sesama pendidik, tenaga kependidikan, orang tua, dan masyarakat.'],
            ['kategori' => 'sosial', 'urutan' => 3,
             'teks_pertanyaan' => 'Guru beradaptasi di tempat bertugas di seluruh wilayah Republik Indonesia yang memiliki keragaman sosial budaya.'],
            ['kategori' => 'sosial', 'urutan' => 4,
             'teks_pertanyaan' => 'Guru berkomunikasi dengan komunitas profesi sendiri dan profesi lain secara lisan dan tulisan atau bentuk lain.'],
            ['kategori' => 'sosial', 'urutan' => 5,
             'teks_pertanyaan' => 'Guru aktif dalam kegiatan sosial kemasyarakatan di lingkungan sekitar.'],

            // ─── PROFESIONAL (5 soal) ─────────────────────────────────────────
            ['kategori' => 'profesional', 'urutan' => 1,
             'teks_pertanyaan' => 'Guru menguasai materi, struktur, konsep, dan pola pikir keilmuan yang mendukung mata pelajaran yang diampu.'],
            ['kategori' => 'profesional', 'urutan' => 2,
             'teks_pertanyaan' => 'Guru menguasai standar kompetensi dan kompetensi dasar mata pelajaran yang diampu.'],
            ['kategori' => 'profesional', 'urutan' => 3,
             'teks_pertanyaan' => 'Guru mengembangkan materi pembelajaran yang diampu secara kreatif.'],
            ['kategori' => 'profesional', 'urutan' => 4,
             'teks_pertanyaan' => 'Guru mengembangkan keprofesionalan secara berkelanjutan dengan melakukan tindakan reflektif.'],
            ['kategori' => 'profesional', 'urutan' => 5,
             'teks_pertanyaan' => 'Guru memanfaatkan teknologi informasi dan komunikasi untuk mengembangkan diri.'],
        ];

        foreach ($pertanyaan as $p) {
            DB::table('pertanyaan')->insert([
                'teks_pertanyaan' => $p['teks_pertanyaan'],
                'kategori'        => $p['kategori'],
                'urutan'          => $p['urutan'],
                'bobot'           => 1.00,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        $this->command->info('✅ ' . count($pertanyaan) . ' pertanyaan berhasil di-seed.');
    }
}

