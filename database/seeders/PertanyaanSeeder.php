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
            // Sumber: Permendiknas No.16 Tahun 2007 — Standar Kualifikasi
            //         Akademik dan Kompetensi Guru (Tabel 3: Kompetensi Inti
            //         Guru Mata Pelajaran SD/MI, SMP/MTs, SMA/MA, SMK/MAK)
            // Perspektif: Siswa mengamati guru di dalam dan luar kelas
            // Bahasa: Santai & akrab (kamu/aku), cocok untuk siswa SMP/SMA
            // Skala: 1–5 (Sangat Tidak Setuju → Sangat Setuju)
            // ══════════════════════════════════════════════════════════════════

            // ── Kompetensi Pedagogik ───────────────────────────────────────
            // KI 1: Menguasai karakteristik peserta didik
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru memahami kemampuan dan kesulitan belajar tiap siswa, sehingga cara mengajarnya terasa pas buat aku.',
            ],
            // KI 2: Menguasai teori belajar & prinsip pembelajaran
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru menggunakan berbagai cara mengajar (diskusi, demonstrasi, kerja kelompok, dll) — tidak hanya ceramah terus.',
            ],
            // KI 3: Mengembangkan kurikulum
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru menyampaikan tujuan pembelajaran dengan jelas di awal pelajaran, jadi aku tahu apa yang akan dipelajari.',
            ],
            // KI 4: Menyelenggarakan pembelajaran yang mendidik
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Guru menggunakan media atau alat bantu belajar (gambar, video, alat peraga, dll) saat mengajar di kelas.',
            ],
            // KI 5: Memanfaatkan TIK untuk kepentingan pembelajaran
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 5,
                'teks_pertanyaan' => 'Guru memanfaatkan teknologi (laptop, proyektor, internet, atau aplikasi belajar) untuk mendukung kegiatan belajar di kelas.',
            ],
            // KI 6: Memfasilitasi pengembangan potensi peserta didik
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 6,
                'teks_pertanyaan' => 'Guru memberi kesempatan kepada aku untuk berpendapat, berkreasi, dan mengembangkan potensi diri dalam belajar.',
            ],
            // KI 7: Berkomunikasi secara efektif, empatik, dan santun
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 7,
                'teks_pertanyaan' => 'Guru berkomunikasi dengan cara yang ramah, mudah aku mengerti, dan tidak membuat aku takut untuk bertanya.',
            ],
            // KI 8: Menyelenggarakan penilaian & evaluasi
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 8,
                'teks_pertanyaan' => 'Penilaian atau ulangan yang diberikan guru terasa adil dan sesuai dengan materi yang sudah diajarkan.',
            ],
            // KI 9: Memanfaatkan hasil penilaian untuk pembelajaran
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 9,
                'teks_pertanyaan' => 'Guru memberikan umpan balik atas hasil ulangan atau tugas aku, dan menyediakan remedial atau pengayaan bagi yang membutuhkan.',
            ],
            // KI 10: Melakukan tindakan reflektif
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 10,
                'teks_pertanyaan' => 'Guru mau memperbaiki cara mengajarnya jika ada yang belum aku dan teman-teman pahami — tidak buru-buru lanjut ke materi berikutnya.',
            ],

            // ── Kompetensi Kepribadian ─────────────────────────────────────
            // KI 11: Bertindak sesuai norma agama, hukum, sosial, budaya
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru menghargai semua siswa tanpa membeda-bedakan suku, agama, jenis kelamin, atau latar belakang keluarga.',
            ],
            // KI 12: Menampilkan diri sebagai pribadi jujur & berakhlak mulia
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru jujur dan konsisten — apa yang beliau perintahkan kepada kami juga beliau lakukan sendiri.',
            ],
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru bisa menjadi teladan bagi aku dan teman-teman dalam berperilaku baik di sekolah maupun di luar sekolah.',
            ],
            // KI 13: Menampilkan diri sebagai pribadi yang mantap & berwibawa
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Guru tampil tenang, sabar, dan berwibawa — tidak mudah marah atau emosi meskipun suasana kelas sedang ramai.',
            ],
            // KI 14: Etos kerja, tanggung jawab, rasa bangga menjadi guru
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 5,
                'teks_pertanyaan' => 'Guru datang ke kelas tepat waktu dan sungguh-sungguh dalam mengajar — terlihat bahwa beliau bangga dengan profesinya.',
            ],
            // KI 15: Menjunjung tinggi kode etik profesi guru
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 6,
                'teks_pertanyaan' => 'Guru berperilaku sesuai etika profesi: tidak mempermalukan siswa di depan umum, tidak pilih kasih, dan menjaga martabat sebagai pendidik.',
            ],

            // ── Kompetensi Sosial ──────────────────────────────────────────
            // KI 16: Bersikap inklusif, objektif, tidak diskriminatif
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru bersikap terbuka dan tidak diskriminatif kepada semua siswa — baik yang pintar maupun yang kurang, semua diperlakukan adil.',
            ],
            // KI 17: Berkomunikasi efektif dengan orang tua & masyarakat
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru melibatkan orang tua atau wali dalam proses belajarku — misalnya memberi kabar tentang perkembangan atau kesulitan belajarku.',
            ],
            // KI 18: Beradaptasi di tempat bertugas
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru mampu menyesuaikan diri dengan kondisi dan budaya di lingkungan sekolah kami, sehingga suasana belajar terasa nyaman.',
            ],
            // KI 19: Berkomunikasi dengan komunitas profesi
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Guru bersedia membantu aku dan teman-teman saat mengalami kesulitan — tidak membiarkan kami bingung sendirian tanpa bimbingan.',
            ],

            // ── Kompetensi Profesional ─────────────────────────────────────
            // KI 20: Menguasai materi, struktur, konsep, pola pikir keilmuan
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru benar-benar menguasai materi pelajarannya — kalau aku tanya di luar buku pun, beliau bisa menjelaskan dengan baik.',
            ],
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru sering mengaitkan materi pelajaran dengan contoh nyata atau kejadian sehari-hari, sehingga lebih mudah aku pahami.',
            ],
            // KI 21: Menguasai standar kompetensi & kompetensi dasar
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Materi yang disampaikan guru sesuai dengan pelajaran yang ada di kurikulum — tidak keluar jalur atau tidak relevan.',
            ],
            // KI 22: Mengembangkan materi pembelajaran secara kreatif
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Guru menyajikan materi secara kreatif dan menarik — pelajaran terasa menyenangkan dan tidak membosankan.',
            ],
            // KI 23–24: Pengembangan keprofesian berkelanjutan & TIK
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 5,
                'teks_pertanyaan' => 'Guru tampak selalu belajar dan mengikuti perkembangan — cara mengajar dan materi yang disampaikan terasa selalu up to date.',
            ],


            // ══════════════════════════════════════════════════════════════════
            // PERTANYAAN UNTUK GURU TEMAN SEJAWAT (PEER ASSESSMENT)
            // Sumber: Lampiran MP1 — Instrumen Penilaian Kinerja Guru
            //         oleh Teman Sejawat (Buku 2 PKG Kemendikbud)
            // 3 Komponen: 1) Perilaku Guru Sehari-hari  (11 item)
            //             2) Hubungan dengan Teman Sejawat (10 item)
            //             3) Perilaku Profesional Guru  ( 9 item)
            // Skala: TP=0 (Tidak Pernah), KD=1 (Kadang-kadang), SR=2 (Sering)
            // Teks: VERBATIM dari instrumen resmi MP1
            // ══════════════════════════════════════════════════════════════════

            // ── Komponen 1: Perilaku Guru Sehari-hari (MP1 No.1–11) ────────
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru mentaati peraturan yang berlaku di sekolah.',
            ],
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru bekerja sesuai jadwal yang ditetapkan.',
            ],
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru berpakaian rapi dan/atau sopan.',
            ],
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Guru rajin mengikuti upacara bendera.',
            ],
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 5,
                'teks_pertanyaan' => 'Guru berperilaku baik terhadap saya dan guru lain.',
            ],
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 6,
                'teks_pertanyaan' => 'Guru bersedia menerima kritik dan saran dari saya atau guru lain.',
            ],
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 7,
                'teks_pertanyaan' => 'Guru dapat menjadi teladan bagi saya dan teman-teman.',
            ],
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 8,
                'teks_pertanyaan' => 'Guru pandai mengendalikan diri.',
            ],
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 9,
                'teks_pertanyaan' => 'Guru ikut aktif menjaga lingkungan sekolah bebas dari asap rokok.',
            ],
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 10,
                'teks_pertanyaan' => 'Guru berpartisipasi aktif dalam kegiatan ekstrakurikuler.',
            ],
            [
                'kategori'        => 'perilaku_harian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 11,
                'teks_pertanyaan' => 'Guru berpartisipasi aktif dalam kegiatan peningkatan prestasi sekolah.',
            ],

            // ── Komponen 2: Hubungan Guru dengan Teman Sejawat (MP1 No.1–10)
            [
                'kategori'        => 'hubungan_sejawat',
                'untuk_penilai'   => 'guru',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru bersikap ramah kepada saya atau orang lain.',
            ],
            [
                'kategori'        => 'hubungan_sejawat',
                'untuk_penilai'   => 'guru',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru berbahasa santun kepada saya atau orang lain.',
            ],
            [
                'kategori'        => 'hubungan_sejawat',
                'untuk_penilai'   => 'guru',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru memberi motivasi kepada saya atau teman-teman guru lain.',
            ],
            [
                'kategori'        => 'hubungan_sejawat',
                'untuk_penilai'   => 'guru',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Guru pandai berkomunikasi secara lisan atau tertulis.',
            ],
            [
                'kategori'        => 'hubungan_sejawat',
                'untuk_penilai'   => 'guru',
                'urutan'          => 5,
                'teks_pertanyaan' => 'Guru memotivasi diri dan rekan sejawat secara aktif dan kreatif dalam melaksanakan proses pendidikan.',
            ],
            [
                'kategori'        => 'hubungan_sejawat',
                'untuk_penilai'   => 'guru',
                'urutan'          => 6,
                'teks_pertanyaan' => 'Guru menciptakan suasana kekeluargaan di dalam dan luar sekolah.',
            ],
            [
                'kategori'        => 'hubungan_sejawat',
                'untuk_penilai'   => 'guru',
                'urutan'          => 7,
                'teks_pertanyaan' => 'Guru mudah bekerjasama dengan saya atau guru lainnya.',
            ],
            [
                'kategori'        => 'hubungan_sejawat',
                'untuk_penilai'   => 'guru',
                'urutan'          => 8,
                'teks_pertanyaan' => 'Guru bersedia diajak berdiskusi tentang segala hal terkait kepentingan peserta didik dan sekolah.',
            ],
            [
                'kategori'        => 'hubungan_sejawat',
                'untuk_penilai'   => 'guru',
                'urutan'          => 9,
                'teks_pertanyaan' => 'Guru bersedia membantu menyelesaikan masalah saya dan guru lainnya.',
            ],
            [
                'kategori'        => 'hubungan_sejawat',
                'untuk_penilai'   => 'guru',
                'urutan'          => 10,
                'teks_pertanyaan' => 'Guru menghargai kemampuan saya dan guru lainnya.',
            ],

            // ── Komponen 3: Perilaku Profesional Guru (MP1 No.1–9) ─────────
            [
                'kategori'        => 'profesional_guru',
                'untuk_penilai'   => 'guru',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru memiliki kreativitas dalam pembelajaran.',
            ],
            [
                'kategori'        => 'profesional_guru',
                'untuk_penilai'   => 'guru',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru memiliki pengetahuan dan keterampilan Teknologi Informasi (TI) yang memadai.',
            ],
            [
                'kategori'        => 'profesional_guru',
                'untuk_penilai'   => 'guru',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru memiliki perangkat pembelajaran yang lengkap.',
            ],
            [
                'kategori'        => 'profesional_guru',
                'untuk_penilai'   => 'guru',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Guru ada di sekolah meskipun tidak mengajar di kelas.',
            ],
            [
                'kategori'        => 'profesional_guru',
                'untuk_penilai'   => 'guru',
                'urutan'          => 5,
                'teks_pertanyaan' => 'Guru memulai pembelajaran tepat waktu.',
            ],
            [
                'kategori'        => 'profesional_guru',
                'untuk_penilai'   => 'guru',
                'urutan'          => 6,
                'teks_pertanyaan' => 'Guru mengakhiri pembelajaran tepat waktu.',
            ],
            [
                'kategori'        => 'profesional_guru',
                'untuk_penilai'   => 'guru',
                'urutan'          => 7,
                'teks_pertanyaan' => 'Guru memberikan tugas kepada peserta didik apabila berhalangan hadir untuk mengajar.',
            ],
            [
                'kategori'        => 'profesional_guru',
                'untuk_penilai'   => 'guru',
                'urutan'          => 8,
                'teks_pertanyaan' => 'Guru memberi informasi kepada saya atau guru lain jika berhalangan hadir untuk mengajar.',
            ],
            [
                'kategori'        => 'profesional_guru',
                'untuk_penilai'   => 'guru',
                'urutan'          => 9,
                'teks_pertanyaan' => 'Guru memperlakukan peserta didik dengan penuh kasih sayang.',
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
            ['Penilai', 'Kategori / Komponen', 'Jumlah', 'Sumber'],
            [
                ['Siswa', 'pedagogik (KI 1–10)',              '10 soal', 'Permendiknas 16/2007 Tabel 3'],
                ['Siswa', 'kepribadian (KI 11–15)',           ' 6 soal', 'Permendiknas 16/2007 Tabel 3'],
                ['Siswa', 'sosial (KI 16–19)',                ' 4 soal', 'Permendiknas 16/2007 Tabel 3'],
                ['Siswa', 'profesional (KI 20–24)',           ' 5 soal', 'Permendiknas 16/2007 Tabel 3'],
                ['---',   '---',                              '---',     '---'],
                ['Guru',  'perilaku_harian (Komp.1 MP1)',     '11 soal', 'Instrumen MP1 PKG — verbatim'],
                ['Guru',  'hubungan_sejawat (Komp.2 MP1)',    '10 soal', 'Instrumen MP1 PKG — verbatim'],
                ['Guru',  'profesional_guru (Komp.3 MP1)',    ' 9 soal', 'Instrumen MP1 PKG — verbatim'],
            ]
        );
        $this->command->info("Total siswa: {$siswaCount} soal | Total guru sejawat: {$guruCount} soal");
        $this->command->warn('⚠  Kategori guru: perilaku_harian | hubungan_sejawat | profesional_guru');
        $this->command->warn('   Pastikan kolom kategori di tabel pertanyaan mendukung string (bukan enum terbatas).');
    }
}
