<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * PertanyaanSeeder
 * ══════════════════════════════════════════════════════════════════════════════
 * Versi ringkas untuk kuesioner SISWA — dari 25 soal menjadi 12 soal.
 * Alasan: mengurangi respondent fatigue (kelelahan responden) terutama
 * bagi siswa yang harus menilai banyak guru sekaligus.
 *
 * SISWA  : 12 soal — diadaptasi dari Permendiknas No.16 Tahun 2007, Tabel 3
 *          (Standar Kompetensi Guru Mata Pelajaran SD/MI, SMP/MTs, SMA/MA)
 *          Dipilih 1 soal representatif per indikator utama, proporsional
 *          dari 4 kompetensi: Pedagogik (4), Kepribadian (3), Sosial (2),
 *          Profesional (3).
 *
 * GURU   : 30 soal — TIDAK BERUBAH, verbatim dari Lampiran MP1 PKG Kemendikbud.
 *          Komponen: Perilaku Harian (11), Hubungan Sejawat (10),
 *          Profesional Guru (9).
 *
 * CATATAN: Seeder ini menghapus data lama (jawaban & pertanyaan) lalu
 *          mengisi ulang. Pastikan backup sudah dilakukan sebelumnya.
 *          Jalankan dengan perintah:
 *              php artisan db:seed --class=PertanyaanSeeder
 * ══════════════════════════════════════════════════════════════════════════════
 */
class PertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        $pertanyaan = [

            // ══════════════════════════════════════════════════════════════════
            // PERTANYAAN UNTUK SISWA — VERSI RINGKAS (12 soal)
            // Sumber  : Permendiknas No.16 Tahun 2007, Tabel 3
            // Adaptasi: Dipilih 1 butir paling representatif per indikator
            //           utama. Bahasa disesuaikan agar santai dan mudah
            //           dipahami siswa SMP/SMA tanpa menggeser konstruk.
            // Skala   : 1–5 Likert (Sangat Tidak Setuju → Sangat Setuju)
            // ══════════════════════════════════════════════════════════════════

            // ── Kompetensi Pedagogik (4 soal) ─────────────────────────────
            // Mewakili KI 1 & 2: karakteristik peserta didik + metode belajar
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru menggunakan berbagai cara mengajar (diskusi, kelompok, demonstrasi, dll) sehingga pelajaran tidak terasa membosankan.',
            ],
            // Mewakili KI 3 & 4: kurikulum + penyelenggaraan pembelajaran
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru menyampaikan tujuan belajar di awal pelajaran dan menggunakan alat bantu (gambar, video, alat peraga) saat mengajar.',
            ],
            // Mewakili KI 7: komunikasi efektif, empatik, santun
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru berkomunikasi dengan cara yang ramah dan mudah dimengerti, sehingga aku tidak takut untuk bertanya.',
            ],
            // Mewakili KI 8 & 9: penilaian, evaluasi, dan tindak lanjutnya
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Ulangan atau tugas yang diberikan guru terasa adil, dan guru memberikan penjelasan setelah hasil penilaian dibagikan.',
            ],

            // ── Kompetensi Kepribadian (3 soal) ───────────────────────────
            // Mewakili KI 11: norma agama, hukum, sosial, budaya
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru menghargai semua siswa tanpa membeda-bedakan suku, agama, jenis kelamin, atau latar belakang keluarga.',
            ],
            // Mewakili KI 12 & 13: jujur, berakhlak mulia, mantap, berwibawa
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru bisa menjadi teladan — jujur, sabar, dan tidak mudah marah meskipun suasana kelas sedang ramai.',
            ],
            // Mewakili KI 14 & 15: etos kerja, tanggung jawab, kode etik
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru selalu hadir tepat waktu, sungguh-sungguh mengajar, dan tidak pernah mempermalukan siswa di depan kelas.',
            ],

            // ── Kompetensi Sosial (2 soal) ────────────────────────────────
            // Mewakili KI 16 & 17: inklusif, tidak diskriminatif, komunikasi
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru bersikap adil kepada semua siswa dan mau berkomunikasi dengan orang tua tentang perkembangan belajar kami.',
            ],
            // Mewakili KI 18 & 19: adaptasi lingkungan + bantu kesulitan siswa
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru bersedia membantu saat aku atau teman-teman kesulitan, dan suasana belajar terasa nyaman di kelas beliau.',
            ],

            // ── Kompetensi Profesional (3 soal) ───────────────────────────
            // Mewakili KI 20: penguasaan materi dan contoh nyata
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru benar-benar menguasai materi pelajarannya dan sering mengaitkan dengan contoh nyata di kehidupan sehari-hari.',
            ],
            // Mewakili KI 21 & 22: standar kompetensi + materi kreatif
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Materi yang diajarkan guru sesuai kurikulum dan disajikan secara kreatif sehingga pelajaran terasa menyenangkan.',
            ],
            // Mewakili KI 23 & 24: pengembangan diri dan pemanfaatan TIK
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru tampak terus berkembang — cara mengajar dan materi yang disampaikan selalu terasa segar dan mengikuti perkembangan zaman.',
            ],


            // ══════════════════════════════════════════════════════════════════
            // PERTANYAAN UNTUK GURU TEMAN SEJAWAT — TIDAK BERUBAH (30 soal)
            // Sumber: Lampiran MP1 — Instrumen Penilaian Kinerja Guru
            //         oleh Teman Sejawat (Buku 2 PKG Kemendikbud)
            // Teks  : VERBATIM dari instrumen resmi MP1
            // Skala : TP=0 (Tidak Pernah) | KD=1 (Kadang-kadang) | SR=2 (Sering)
            // ══════════════════════════════════════════════════════════════════

            // ── Komponen 1: Perilaku Guru Sehari-hari (11 butir) ──────────
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

            // ── Komponen 2: Hubungan Guru dengan Teman Sejawat (10 butir) ─
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

            // ── Komponen 3: Perilaku Profesional Guru (9 butir) ───────────
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

        // ── Hapus data lama lalu insert baru ─────────────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('jawaban')->delete();
        DB::table('pertanyaan')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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

        // ── Ringkasan output di terminal ──────────────────────────────────────
        $siswaCount = collect($pertanyaan)->where('untuk_penilai', 'siswa')->count();
        $guruCount  = collect($pertanyaan)->where('untuk_penilai', 'guru')->count();

        $this->command->info('');
        $this->command->info('✅ PertanyaanSeeder — ' . count($pertanyaan) . ' pertanyaan berhasil di-seed.');
        $this->command->info('');
        $this->command->table(
            ['Penilai', 'Kategori / Komponen', 'Jumlah', 'Sumber'],
            [
                ['Siswa', 'pedagogik    (KI 1–10)',          '4 soal',  'Permendiknas 16/2007 — adaptasi'],
                ['Siswa', 'kepribadian  (KI 11–15)',         '3 soal',  'Permendiknas 16/2007 — adaptasi'],
                ['Siswa', 'sosial       (KI 16–19)',         '2 soal',  'Permendiknas 16/2007 — adaptasi'],
                ['Siswa', 'profesional  (KI 20–24)',         '3 soal',  'Permendiknas 16/2007 — adaptasi'],
                ['---',   '---',                             '---',     '---'],
                ['Guru',  'perilaku_harian   (Komp.1 MP1)', '11 soal', 'MP1 PKG — verbatim'],
                ['Guru',  'hubungan_sejawat  (Komp.2 MP1)', '10 soal', 'MP1 PKG — verbatim'],
                ['Guru',  'profesional_guru  (Komp.3 MP1)', ' 9 soal', 'MP1 PKG — verbatim'],
            ]
        );
        $this->command->info("Total siswa  : {$siswaCount} soal");
        $this->command->info("Total guru   : {$guruCount} soal");
        $this->command->info('');
        $this->command->warn('⚠  Seeder ini menghapus tabel jawaban dan pertanyaan lama.');
        $this->command->warn('   Pastikan backup sudah dilakukan sebelum menjalankan perintah ini.');
    }
}
