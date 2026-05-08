<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        $pertanyaan = [

            // ══════════════════════════════════════════════════════════════════
            // PERTANYAAN UNTUK SISWA
            // Sumber: Permendiknas No.16/2007 Tabel 3
            // Disesuaikan dengan sudut pandang siswa SMA/SMP
            // ══════════════════════════════════════════════════════════════════

            // ── Pedagogik (untuk siswa) ────────────────────────────────────
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 1,
                'teks_pertanyaan' => 'Guru menyampaikan materi pelajaran dengan cara yang mudah saya pahami.',
            ],
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 2,
                'teks_pertanyaan' => 'Guru menggunakan contoh nyata dan media yang membantu saya memahami materi pelajaran.',
            ],
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 3,
                'teks_pertanyaan' => 'Guru memberikan kesempatan kepada saya untuk bertanya dan menjawab pertanyaan selama pembelajaran.',
            ],
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 4,
                'teks_pertanyaan' => 'Guru memanfaatkan teknologi (komputer, proyektor, internet) untuk mendukung pembelajaran.',
            ],
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 5,
                'teks_pertanyaan' => 'Guru memberikan penilaian yang adil dan objektif terhadap hasil belajar saya.',
            ],
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 6,
                'teks_pertanyaan' => 'Guru memberikan tugas dan latihan yang membantu saya memahami materi lebih dalam.',
            ],
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 7,
                'teks_pertanyaan' => 'Guru mendorong saya untuk mengembangkan potensi dan kreativitas dalam belajar.',
            ],

            // ── Kepribadian (untuk siswa) ──────────────────────────────────
            [
                'kategori'       => 'kepribadian',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 1,
                'teks_pertanyaan' => 'Guru bersikap adil kepada semua siswa tanpa membeda-bedakan latar belakang.',
            ],
            [
                'kategori'       => 'kepribadian',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 2,
                'teks_pertanyaan' => 'Guru berperilaku jujur dan menjadi teladan yang baik bagi saya sebagai siswa.',
            ],
            [
                'kategori'       => 'kepribadian',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 3,
                'teks_pertanyaan' => 'Guru bersikap sabar dan tenang dalam menghadapi berbagai situasi di kelas.',
            ],
            [
                'kategori'       => 'kepribadian',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 4,
                'teks_pertanyaan' => 'Guru hadir dan masuk kelas tepat waktu sesuai jadwal yang telah ditentukan.',
            ],

            // ── Sosial (untuk siswa) ───────────────────────────────────────
            [
                'kategori'       => 'sosial',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 1,
                'teks_pertanyaan' => 'Guru berkomunikasi dengan saya secara ramah, sopan, dan mudah dipahami.',
            ],
            [
                'kategori'       => 'sosial',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 2,
                'teks_pertanyaan' => 'Guru peduli terhadap kesulitan belajar yang saya hadapi dan memberikan bantuan.',
            ],
            [
                'kategori'       => 'sosial',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 3,
                'teks_pertanyaan' => 'Guru menciptakan suasana kelas yang nyaman dan menyenangkan untuk belajar.',
            ],

            // ── Profesional (untuk siswa) ──────────────────────────────────
            [
                'kategori'       => 'profesional',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 1,
                'teks_pertanyaan' => 'Guru menguasai materi pelajaran yang diajarkan dengan baik dan mendalam.',
            ],
            [
                'kategori'       => 'profesional',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 2,
                'teks_pertanyaan' => 'Guru menyampaikan materi sesuai dengan kurikulum dan tujuan pembelajaran.',
            ],
            [
                'kategori'       => 'profesional',
                'untuk_penilai'  => 'siswa',
                'urutan'         => 3,
                'teks_pertanyaan' => 'Guru mengaitkan materi pelajaran dengan kehidupan nyata sehingga mudah dipahami.',
            ],

            // ══════════════════════════════════════════════════════════════════
            // PERTANYAAN UNTUK GURU TEMAN SEJAWAT (PEER ASSESSMENT)
            // Sumber: Lampiran MP1 Buku 2 Pedoman PKG Kemendikbud
            // Menilai 4 aspek: Perilaku, Hubungan Sejawat, Profesional, Pembelajaran
            // ══════════════════════════════════════════════════════════════════

            // ── Kepribadian: Perilaku Sehari-hari (Lampiran MP1 Aspek A) ───
            [
                'kategori'       => 'kepribadian',
                'untuk_penilai'  => 'guru',
                'urutan'         => 1,
                'teks_pertanyaan' => 'Guru hadir di sekolah dan masuk kelas tepat waktu sesuai jadwal yang telah ditetapkan.',
            ],
            [
                'kategori'       => 'kepribadian',
                'untuk_penilai'  => 'guru',
                'urutan'         => 2,
                'teks_pertanyaan' => 'Guru berpakaian rapi, bersih, dan sopan sesuai dengan norma dan aturan yang berlaku di sekolah.',
            ],
            [
                'kategori'       => 'kepribadian',
                'untuk_penilai'  => 'guru',
                'urutan'         => 3,
                'teks_pertanyaan' => 'Guru memberikan tugas kepada peserta didik apabila berhalangan hadir untuk mengajar.',
            ],
            [
                'kategori'       => 'kepribadian',
                'untuk_penilai'  => 'guru',
                'urutan'         => 4,
                'teks_pertanyaan' => 'Guru menjalankan ibadah sesuai dengan agama dan kepercayaan yang dianutnya dengan konsisten.',
            ],
            [
                'kategori'       => 'kepribadian',
                'untuk_penilai'  => 'guru',
                'urutan'         => 5,
                'teks_pertanyaan' => 'Guru bersikap jujur, terbuka, dan bertanggung jawab dalam melaksanakan tugas sebagai pendidik.',
            ],

            // ── Sosial: Hubungan dengan Teman Sejawat (Lampiran MP1 Aspek B)
            [
                'kategori'       => 'sosial',
                'untuk_penilai'  => 'guru',
                'urutan'         => 1,
                'teks_pertanyaan' => 'Guru bersikap ramah, santun, dan terbuka dalam berkomunikasi dengan sesama rekan guru.',
            ],
            [
                'kategori'       => 'sosial',
                'untuk_penilai'  => 'guru',
                'urutan'         => 2,
                'teks_pertanyaan' => 'Guru memberikan informasi kepada rekan guru lain jika berhalangan hadir untuk mengajar.',
            ],
            [
                'kategori'       => 'sosial',
                'untuk_penilai'  => 'guru',
                'urutan'         => 3,
                'teks_pertanyaan' => 'Guru bersedia membantu rekan guru yang mengalami kesulitan dalam melaksanakan tugas mengajar.',
            ],
            [
                'kategori'       => 'sosial',
                'untuk_penilai'  => 'guru',
                'urutan'         => 4,
                'teks_pertanyaan' => 'Guru memperlakukan peserta didik dengan penuh kasih sayang tanpa membeda-bedakan latar belakang.',
            ],
            [
                'kategori'       => 'sosial',
                'untuk_penilai'  => 'guru',
                'urutan'         => 5,
                'teks_pertanyaan' => 'Guru aktif berpartisipasi dalam kegiatan kolektif sekolah seperti rapat, upacara, dan kegiatan bersama.',
            ],

            // ── Profesional: Perilaku Profesional (Lampiran MP1 Aspek C) ───
            [
                'kategori'       => 'profesional',
                'untuk_penilai'  => 'guru',
                'urutan'         => 1,
                'teks_pertanyaan' => 'Guru menguasai materi pelajaran yang diampu secara mendalam dan mampu menjelaskan dengan baik.',
            ],
            [
                'kategori'       => 'profesional',
                'untuk_penilai'  => 'guru',
                'urutan'         => 2,
                'teks_pertanyaan' => 'Guru aktif mengikuti kegiatan pengembangan profesi seperti pelatihan, seminar, MGMP, atau KKG.',
            ],
            [
                'kategori'       => 'profesional',
                'untuk_penilai'  => 'guru',
                'urutan'         => 3,
                'teks_pertanyaan' => 'Guru mengembangkan inovasi dan kreativitas dalam metode dan media pembelajaran.',
            ],
            [
                'kategori'       => 'profesional',
                'untuk_penilai'  => 'guru',
                'urutan'         => 4,
                'teks_pertanyaan' => 'Guru memanfaatkan teknologi informasi untuk mendukung dan meningkatkan kualitas pembelajaran.',
            ],

            // ── Pedagogik: Pelaksanaan Pembelajaran (Lampiran MP1 Aspek D) ─
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'guru',
                'urutan'         => 1,
                'teks_pertanyaan' => 'Guru menyusun Rencana Pelaksanaan Pembelajaran (RPP) sebelum melaksanakan kegiatan mengajar.',
            ],
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'guru',
                'urutan'         => 2,
                'teks_pertanyaan' => 'Guru melaksanakan pembelajaran secara terstruktur dan sistematis sesuai tujuan yang telah ditetapkan.',
            ],
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'guru',
                'urutan'         => 3,
                'teks_pertanyaan' => 'Guru melakukan penilaian hasil belajar peserta didik secara objektif dan berkesinambungan.',
            ],
            [
                'kategori'       => 'pedagogik',
                'untuk_penilai'  => 'guru',
                'urutan'         => 4,
                'teks_pertanyaan' => 'Guru melakukan refleksi dan evaluasi terhadap proses pembelajaran yang telah dilaksanakan.',
            ],
        ];

        // ── Hapus data lama ───────────────────────────────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('jawaban')->delete();
        DB::table('pertanyaan')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ── Insert data baru ──────────────────────────────────────────────────
        foreach ($pertanyaan as $p) {
            DB::table('pertanyaan')->insert([
                'teks_pertanyaan' => $p['teks_pertanyaan'],
                'kategori'        => $p['kategori'],
                'untuk_penilai'   => $p['untuk_penilai'],
                'urutan'          => $p['urutan'],
                'bobot'           => 1.00,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        $siswaCount = collect($pertanyaan)->where('untuk_penilai', 'siswa')->count();
        $guruCount  = collect($pertanyaan)->where('untuk_penilai', 'guru')->count();

        $this->command->info('✅ ' . count($pertanyaan) . ' pertanyaan berhasil di-seed.');
        $this->command->table(
            ['Penilai', 'Kategori', 'Jumlah Soal', 'Sumber'],
            [
                ['Siswa', 'Pedagogik',   '7 soal', 'Permendiknas 16/2007 (sudut pandang siswa)'],
                ['Siswa', 'Kepribadian', '4 soal', 'Permendiknas 16/2007 (sudut pandang siswa)'],
                ['Siswa', 'Sosial',      '3 soal', 'Permendiknas 16/2007 (sudut pandang siswa)'],
                ['Siswa', 'Profesional', '3 soal', 'Permendiknas 16/2007 (sudut pandang siswa)'],
                ['---',   '---',         '---',    '---'],
                ['Guru',  'Kepribadian', '5 soal', 'Lampiran MP1 PKG Kemendikbud (Aspek A)'],
                ['Guru',  'Sosial',      '5 soal', 'Lampiran MP1 PKG Kemendikbud (Aspek B)'],
                ['Guru',  'Profesional', '4 soal', 'Lampiran MP1 PKG Kemendikbud (Aspek C)'],
                ['Guru',  'Pedagogik',   '4 soal', 'Lampiran MP1 PKG Kemendikbud (Aspek D)'],
            ]
        );
        $this->command->info("Total siswa: {$siswaCount} soal | Total guru sejawat: {$guruCount} soal");
    }
}
