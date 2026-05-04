<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        $pertanyaan = [

            // ══════════════════════════════════════════════════════
            // KOMPETENSI PEDAGOGIK
            // Sumber: Permendiknas No.16/2007 Tabel 3, Butir 1-10
            // ══════════════════════════════════════════════════════

            [
                'kategori' => 'pedagogik',
                'urutan'   => 1,
                'teks_pertanyaan' => 'Guru memahami karakteristik peserta didik dari aspek fisik, intelektual, sosial-emosional, moral, spiritual, dan latar belakang sosial-budaya.',
            ],
            [
                'kategori' => 'pedagogik',
                'urutan'   => 2,
                'teks_pertanyaan' => 'Guru mengidentifikasi potensi peserta didik dan memberikan kegiatan pembelajaran untuk mendorong pencapaian prestasi secara optimal.',
            ],
            [
                'kategori' => 'pedagogik',
                'urutan'   => 3,
                'teks_pertanyaan' => 'Guru menguasai teori belajar dan menerapkan berbagai pendekatan, strategi, metode, serta teknik pembelajaran yang mendidik secara kreatif.',
            ],
            [
                'kategori' => 'pedagogik',
                'urutan'   => 4,
                'teks_pertanyaan' => 'Guru mengembangkan kurikulum dengan menentukan tujuan, pengalaman belajar, dan materi pembelajaran yang sesuai dengan mata pelajaran yang diampu.',
            ],
            [
                'kategori' => 'pedagogik',
                'urutan'   => 5,
                'teks_pertanyaan' => 'Guru menyelenggarakan pembelajaran yang mendidik di kelas dengan menggunakan media dan sumber belajar yang relevan dengan karakteristik peserta didik.',
            ],
            [
                'kategori' => 'pedagogik',
                'urutan'   => 6,
                'teks_pertanyaan' => 'Guru memanfaatkan teknologi informasi dan komunikasi untuk kepentingan pembelajaran yang diampu.',
            ],
            [
                'kategori' => 'pedagogik',
                'urutan'   => 7,
                'teks_pertanyaan' => 'Guru berkomunikasi secara efektif, empatik, dan santun dengan peserta didik dalam bahasa yang khas selama interaksi pembelajaran berlangsung.',
            ],
            [
                'kategori' => 'pedagogik',
                'urutan'   => 8,
                'teks_pertanyaan' => 'Guru menyelenggarakan penilaian dan evaluasi proses serta hasil belajar secara berkesinambungan dengan menggunakan berbagai instrumen penilaian.',
            ],
            [
                'kategori' => 'pedagogik',
                'urutan'   => 9,
                'teks_pertanyaan' => 'Guru memanfaatkan hasil penilaian dan evaluasi untuk menentukan ketuntasan belajar, merancang program remedial, serta meningkatkan kualitas pembelajaran.',
            ],
            [
                'kategori' => 'pedagogik',
                'urutan'   => 10,
                'teks_pertanyaan' => 'Guru melakukan tindakan reflektif terhadap pembelajaran yang telah dilaksanakan dan memanfaatkan hasilnya untuk perbaikan serta pengembangan pembelajaran.',
            ],

            // ══════════════════════════════════════════════════════
            // KOMPETENSI KEPRIBADIAN
            // Sumber: Permendiknas No.16/2007 Tabel 3, Butir 11-15
            // ══════════════════════════════════════════════════════

            [
                'kategori' => 'kepribadian',
                'urutan'   => 1,
                'teks_pertanyaan' => 'Guru bertindak sesuai dengan norma agama, hukum, sosial, dan kebudayaan nasional Indonesia, serta menghargai peserta didik tanpa membedakan suku, agama, gender, dan latar belakang.',
            ],
            [
                'kategori' => 'kepribadian',
                'urutan'   => 2,
                'teks_pertanyaan' => 'Guru menampilkan diri sebagai pribadi yang jujur, berakhlak mulia, berperilaku yang mencerminkan ketakwaan, dan dapat diteladani oleh peserta didik dan masyarakat.',
            ],
            [
                'kategori' => 'kepribadian',
                'urutan'   => 3,
                'teks_pertanyaan' => 'Guru menampilkan diri sebagai pribadi yang mantap, stabil, dewasa, arif, dan berwibawa dalam setiap situasi di lingkungan sekolah maupun masyarakat.',
            ],
            [
                'kategori' => 'kepribadian',
                'urutan'   => 4,
                'teks_pertanyaan' => 'Guru menunjukkan etos kerja yang tinggi, tanggung jawab profesional, rasa bangga menjadi guru, percaya diri, dan bekerja secara mandiri.',
            ],
            [
                'kategori' => 'kepribadian',
                'urutan'   => 5,
                'teks_pertanyaan' => 'Guru memahami, menerapkan, dan berperilaku sesuai dengan kode etik profesi guru dalam setiap aspek pelaksanaan tugasnya.',
            ],

            // ══════════════════════════════════════════════════════
            // KOMPETENSI SOSIAL
            // Sumber: Permendiknas No.16/2007 Tabel 3, Butir 16-19
            // ══════════════════════════════════════════════════════

            [
                'kategori' => 'sosial',
                'urutan'   => 1,
                'teks_pertanyaan' => 'Guru bersikap inklusif, bertindak objektif, dan tidak bersikap diskriminatif terhadap peserta didik, teman sejawat, maupun orang tua karena perbedaan agama, suku, jenis kelamin, atau status sosial-ekonomi.',
            ],
            [
                'kategori' => 'sosial',
                'urutan'   => 2,
                'teks_pertanyaan' => 'Guru berkomunikasi secara efektif, empatik, dan santun dengan sesama pendidik, tenaga kependidikan, orang tua peserta didik, dan masyarakat.',
            ],
            [
                'kategori' => 'sosial',
                'urutan'   => 3,
                'teks_pertanyaan' => 'Guru beradaptasi dengan lingkungan tempat bertugas dan melaksanakan berbagai program untuk mengembangkan serta meningkatkan kualitas pendidikan di lingkungan sekolah.',
            ],
            [
                'kategori' => 'sosial',
                'urutan'   => 4,
                'teks_pertanyaan' => 'Guru berkomunikasi dengan teman sejawat, komunitas ilmiah, dan profesi lain melalui berbagai media dalam rangka meningkatkan kualitas pembelajaran dan mengkomunikasikan hasil inovasi.',
            ],
            [
                'kategori' => 'sosial',
                'urutan'   => 5,
                'teks_pertanyaan' => 'Guru mengikutsertakan orang tua peserta didik dan masyarakat dalam program pembelajaran serta dalam mengatasi kesulitan belajar peserta didik.',
            ],

            // ══════════════════════════════════════════════════════
            // KOMPETENSI PROFESIONAL
            // Sumber: Permendiknas No.16/2007 Tabel 3, Butir 20-24
            // ══════════════════════════════════════════════════════

            [
                'kategori' => 'profesional',
                'urutan'   => 1,
                'teks_pertanyaan' => 'Guru menguasai materi, struktur, konsep, dan pola pikir keilmuan yang mendukung mata pelajaran yang diampu secara luas dan mendalam.',
            ],
            [
                'kategori' => 'profesional',
                'urutan'   => 2,
                'teks_pertanyaan' => 'Guru memahami standar kompetensi, kompetensi dasar, dan tujuan pembelajaran mata pelajaran yang diampu sesuai kurikulum yang berlaku.',
            ],
            [
                'kategori' => 'profesional',
                'urutan'   => 3,
                'teks_pertanyaan' => 'Guru mengembangkan materi pembelajaran yang diampu secara kreatif dan integratif sesuai dengan tingkat perkembangan peserta didik.',
            ],
            [
                'kategori' => 'profesional',
                'urutan'   => 4,
                'teks_pertanyaan' => 'Guru mengembangkan keprofesionalan secara berkelanjutan dengan melakukan refleksi kinerja, penelitian tindakan kelas, dan mengikuti perkembangan ilmu pengetahuan.',
            ],
            [
                'kategori' => 'profesional',
                'urutan'   => 5,
                'teks_pertanyaan' => 'Guru memanfaatkan teknologi informasi dan komunikasi untuk berkomunikasi dan mengembangkan diri dalam rangka peningkatan keprofesionalan.',
            ],
        ];

        // ── Hapus data lama dengan disable foreign key check ─────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('jawaban')->delete();     // hapus jawaban dulu (child)
        DB::table('pertanyaan')->truncate(); // baru truncate pertanyaan (parent)
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ── Insert data baru ──────────────────────────────────────────────────
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

        $this->command->info('✅ ' . count($pertanyaan) . ' pertanyaan sesuai Permendiknas No.16/2007 berhasil di-seed.');
        $this->command->table(
            ['Kategori', 'Jumlah Soal', 'Referensi'],
            [
                ['Pedagogik',   '10 soal', 'Butir 1–10'],
                ['Kepribadian', '5 soal',  'Butir 11–15'],
                ['Sosial',      '5 soal',  'Butir 16–19'],
                ['Profesional', '5 soal',  'Butir 20–24'],
            ]
        );
    }
}
