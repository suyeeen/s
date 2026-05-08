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
            // Sumber: Permendiknas No.16/2007 — Standar Kualifikasi Akademik
            //         dan Kompetensi Guru (Tabel 3: Kompetensi Inti Guru)
            // Bahasa: Santai & akrab, sudut pandang siswa SMP/SMA
            //         (gunakan "kamu/aku", hindari istilah teknis)
            // ══════════════════════════════════════════════════════════════════

            // ── Pedagogik (untuk siswa) ────────────────────────────────────
            // Merujuk pada: Kompetensi 1–4 Permendiknas 16/2007
            // (memahami karakteristik peserta didik, merancang & melaksanakan
            //  pembelajaran, memanfaatkan TIK, mengevaluasi hasil belajar)
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru menjelaskan materi dengan cara yang mudah aku pahami, bukan cuma baca buku.',
            ],
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru pakai contoh nyata atau media (gambar, video, alat peraga) biar materi lebih gampang masuk.',
            ],
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru kasih kesempatan buat aku bertanya atau menjawab saat pelajaran, bukan cuma ceramah terus.',
            ],
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Guru memanfaatkan teknologi (laptop, proyektor, atau aplikasi) untuk bantu belajar di kelas.',
            ],
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 5,
                'teks_pertanyaan' => 'Nilai atau penilaian yang aku dapat terasa adil dan sesuai dengan usaha belajar aku.',
            ],
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 6,
                'teks_pertanyaan' => 'Tugas yang diberikan guru membantu aku makin paham materi, bukan sekadar mengisi waktu.',
            ],
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 7,
                'teks_pertanyaan' => 'Guru mendorong aku untuk berani berpendapat, berkreasi, dan berpikir sendiri dalam belajar.',
            ],

            // ── Kepribadian (untuk siswa) ──────────────────────────────────
            // Merujuk pada: Kompetensi 5–7 Permendiknas 16/2007
            // (bertindak sesuai norma, menampilkan diri sebagai pribadi
            //  berakhlak mulia, berwibawa, dan menjadi teladan)
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru bersikap adil ke semua siswa — nggak pilih kasih karena latar belakang atau kedekatan.',
            ],
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Guru jujur dan bisa jadi contoh yang baik — tidak pernah menyuruh hal yang beliau sendiri tidak lakukan.',
            ],
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru tetap sabar dan nggak mudah marah meskipun situasi kelas lagi ramai atau ada masalah.',
            ],
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Guru selalu masuk kelas tepat waktu dan tidak sering meninggalkan kelas tanpa alasan jelas.',
            ],

            // ── Sosial (untuk siswa) ───────────────────────────────────────
            // Merujuk pada: Kompetensi 8–9 Permendiknas 16/2007
            // (berkomunikasi secara efektif, empatik, dan santun;
            //  beradaptasi di tempat bertugas)
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru ngobrol sama aku dengan cara yang ramah, sopan, dan mudah aku mengerti.',
            ],
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Kalau aku kesulitan belajar, guru mau bantu dan tidak membiarkan aku bingung sendirian.',
            ],
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Suasana kelas terasa nyaman dan menyenangkan ketika guru ini mengajar.',
            ],

            // ── Profesional (untuk siswa) ──────────────────────────────────
            // Merujuk pada: Kompetensi 10–11 Permendiknas 16/2007
            // (menguasai materi, struktur, konsep keilmuan yang mendukung
            //  mata pelajaran; mengembangkan materi secara kreatif)
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Guru benar-benar ngerti materi yang diajarkan — kalau aku tanya, beliau bisa jawab dengan jelas.',
            ],
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Materi yang disampaikan guru sesuai dengan yang ada di pelajaran dan tujuan belajar kami.',
            ],
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'siswa',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Guru sering mengaitkan materi pelajaran dengan kejadian nyata di kehidupan sehari-hari, jadi lebih relevan.',
            ],


            // ══════════════════════════════════════════════════════════════════
            // PERTANYAAN UNTUK GURU TEMAN SEJAWAT (PEER ASSESSMENT)
            // Sumber: Lampiran MP1 — Buku 2 Pedoman PKG Kemendikbud
            //         (Format Penilaian Kinerja Guru oleh Teman Sejawat)
            // 4 Aspek: A) Perilaku Sehari-hari  B) Hubungan dengan Teman
            //          C) Perilaku Profesional   D) Pelaksanaan Pembelajaran
            // Bahasa: Profesional, kolegal, sesama rekan guru
            //         (gunakan "Bapak/Ibu Guru" atau "beliau")
            // ══════════════════════════════════════════════════════════════════

            // ── Aspek A: Perilaku Sehari-hari (Lampiran MP1 No.1–5) ────────
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Bapak/Ibu Guru selalu hadir di sekolah dan masuk kelas tepat sesuai jadwal yang ditetapkan.',
            ],
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Bapak/Ibu Guru berpenampilan rapi, bersih, dan sopan yang mencerminkan profesionalisme sebagai pendidik.',
            ],
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Ketika berhalangan hadir mengajar, beliau selalu meninggalkan tugas atau materi bagi peserta didik.',
            ],
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Bapak/Ibu Guru menjalankan ibadah sesuai keyakinannya secara konsisten dan menjadi teladan bagi warga sekolah.',
            ],
            [
                'kategori'        => 'kepribadian',
                'untuk_penilai'   => 'guru',
                'urutan'          => 5,
                'teks_pertanyaan' => 'Beliau menunjukkan sikap jujur, terbuka, dan bertanggung jawab dalam menjalankan tugas sebagai pendidik.',
            ],

            // ── Aspek B: Hubungan dengan Teman Sejawat (Lampiran MP1 No.6–10)
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'guru',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Bapak/Ibu Guru bersikap ramah, santun, dan terbuka saat berkomunikasi dengan sesama rekan pendidik.',
            ],
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'guru',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Beliau selalu menginformasikan kepada rekan sejawat jika berhalangan hadir, sehingga tidak mengganggu kegiatan belajar.',
            ],
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'guru',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Bapak/Ibu Guru bersedia meluangkan waktu untuk membantu rekan yang mengalami kesulitan dalam tugas mengajar.',
            ],
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'guru',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Beliau memperlakukan peserta didik dengan penuh kasih sayang tanpa membeda-bedakan latar belakang sosial atau kemampuan akademik.',
            ],
            [
                'kategori'        => 'sosial',
                'untuk_penilai'   => 'guru',
                'urutan'          => 5,
                'teks_pertanyaan' => 'Bapak/Ibu Guru aktif berpartisipasi dalam kegiatan kolektif sekolah seperti rapat, upacara, dan program bersama.',
            ],

            // ── Aspek C: Perilaku Profesional (Lampiran MP1 No.11–14) ──────
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'guru',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Bapak/Ibu Guru menguasai bidang studi yang diampu secara mendalam dan mampu menjelaskannya dengan tepat kepada peserta didik.',
            ],
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'guru',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Beliau aktif mengikuti kegiatan pengembangan keprofesian berkelanjutan (PKB) seperti pelatihan, seminar, MGMP, atau KKG.',
            ],
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'guru',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Bapak/Ibu Guru senantiasa mengembangkan inovasi dalam metode dan media pembelajaran demi meningkatkan kualitas pengajaran.',
            ],
            [
                'kategori'        => 'profesional',
                'untuk_penilai'   => 'guru',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Beliau memanfaatkan teknologi informasi dan komunikasi secara efektif untuk mendukung proses pembelajaran.',
            ],

            // ── Aspek D: Pelaksanaan Pembelajaran (Lampiran MP1 No.15–18) ──
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'guru',
                'urutan'          => 1,
                'teks_pertanyaan' => 'Bapak/Ibu Guru menyusun Rencana Pelaksanaan Pembelajaran (RPP) sebelum mengajar dan sesuai dengan kurikulum yang berlaku.',
            ],
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'guru',
                'urutan'          => 2,
                'teks_pertanyaan' => 'Beliau melaksanakan pembelajaran secara terstruktur: ada kegiatan pembuka, inti, dan penutup yang jelas dan terarah.',
            ],
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'guru',
                'urutan'          => 3,
                'teks_pertanyaan' => 'Bapak/Ibu Guru melakukan penilaian hasil belajar peserta didik secara objektif, berkesinambungan, dan beragam.',
            ],
            [
                'kategori'        => 'pedagogik',
                'untuk_penilai'   => 'guru',
                'urutan'          => 4,
                'teks_pertanyaan' => 'Beliau melakukan refleksi dan evaluasi setelah mengajar sebagai bahan perbaikan pembelajaran ke depan.',
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
            ['Penilai', 'Kategori', 'Jumlah Soal', 'Sumber & Bahasa'],
            [
                ['Siswa', 'Pedagogik',   '7 soal', 'Permendiknas 16/2007 Komp.1–4 | Bahasa santai siswa'],
                ['Siswa', 'Kepribadian', '4 soal', 'Permendiknas 16/2007 Komp.5–7 | Bahasa santai siswa'],
                ['Siswa', 'Sosial',      '3 soal', 'Permendiknas 16/2007 Komp.8–9 | Bahasa santai siswa'],
                ['Siswa', 'Profesional', '3 soal', 'Permendiknas 16/2007 Komp.10–11 | Bahasa santai siswa'],
                ['---',   '---',         '---',    '---'],
                ['Guru',  'Kepribadian', '5 soal', 'Lampiran MP1 PKG Aspek A | Bahasa profesional guru'],
                ['Guru',  'Sosial',      '5 soal', 'Lampiran MP1 PKG Aspek B | Bahasa profesional guru'],
                ['Guru',  'Profesional', '4 soal', 'Lampiran MP1 PKG Aspek C | Bahasa profesional guru'],
                ['Guru',  'Pedagogik',   '4 soal', 'Lampiran MP1 PKG Aspek D | Bahasa profesional guru'],
            ]
        );
        $this->command->info("Total siswa: {$siswaCount} soal | Total guru sejawat: {$guruCount} soal");
    }
}
