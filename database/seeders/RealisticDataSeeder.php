<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\JadwalKuliah;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RealisticDataSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('12345678');

        // 1. Data Prodi & Kelas (10 Kelas)
        $prodiList = [
            'Sistem Informasi', 'Teknologi Informasi', 'Sistem Komputer',
            'Bisnis Digital', 'Teknologi Informatika',
            'Sistem Informasi', 'Teknologi Informasi', 'Sistem Komputer',
            'Bisnis Digital', 'Teknologi Informatika'
        ];

        $namaKelasList = [
            'BD243', 'BC243', 'BD244', 'BD245', 'SI243',
            'TI243', 'SK243', 'BD246', 'TI244', 'SI244'
        ];

        $kelasList = [];
        foreach ($prodiList as $i => $prodi) {
            $kelasList[] = Kelas::create([
                'nama_kelas' => $namaKelasList[$i],
            ]);
        }

        // 2. Data Mata Kuliah (10 MK Bidang Teknologi)
        $mkNames = [
            'Pemrograman Web', 'Struktur Data', 'Kecerdasan Buatan',
            'Jaringan Komputer', 'Basis Data', 'Rekayasa Perangkat Lunak',
            'Sistem Operasi', 'Pemrograman Mobile', 'Keamanan Siber',
            'Analisis Algoritma'
        ];

        $mkList = [];
        foreach ($mkNames as $i => $namaMk) {
            $mkList[] = MataKuliah::create([
                'kode_mk' => 'TI' . (100 + $i),
                'nama_mk' => $namaMk,
                'sks' => rand(2, 4),
            ]);
        }

        // 3. Data Dosen (10 Dosen)
        $dosenNames = [
            'Budi Santoso', 'Siti Aminah', 'Ahmad Rizal', 'Dewi Lestari',
            'Hendra Wijaya', 'Rina Marlina', 'Agus Supriyanto', 'Dina Fitriani',
            'Iwan Gunawan', 'Eka Putri'
        ];

        $dosenList = [];
        foreach ($dosenNames as $i => $name) {
            $emailName = strtolower(explode(' ', $name)[0]) . $i; // e.g. budi0@mail.com
            $user = User::create([
                'name' => $name,
                'email' => $emailName . '@mail.com',
                'password' => $password,
                'role' => 'dosen',
            ]);

            $dosenList[] = Dosen::create([
                'user_id' => $user->id,
                'nidn' => '00112233' . $i,
            ]);
        }

        // 4. Data Mahasiswa (10 per Kelas -> 100 total)
        $requiredNames = [
            'Abirama', 'De Adi', 'Darmayasa Tangkas', 'Ezra', 'Yanik', 
            'Adi Saputra', 'Angga Saputra', 'Annisa', 'Theo'
        ];

        $otherNames = [
            'Bagus', 'Candra', 'Dian', 'Eko', 'Fajar', 'Gilang', 'Hadi', 'Indra', 'Joko', 'Kevin',
            'Lutfi', 'Mamat', 'Novan', 'Oka', 'Putra', 'Qori', 'Rizky', 'Surya', 'Tito', 'Umar',
            'Vicky', 'Wawan', 'Xaver', 'Yusuf', 'Zain', 'Andi', 'Bima', 'Cipto', 'Dodi', 'Edi',
            'Ferry', 'Gede', 'Hari', 'Iwan', 'Jaya', 'Kadek', 'Lia', 'Maya', 'Nia', 'Olin',
            'Putri', 'Qonita', 'Rani', 'Sari', 'Tari', 'Uli', 'Vina', 'Widi', 'Xena', 'Yani',
            'Zara', 'Arya', 'Bayu', 'Citra', 'Deni', 'Erwin', 'Fikri', 'Gusti', 'Hendra', 'Irfan',
            'Jamil', 'Kiki', 'Lukman', 'Rina', 'Nina', 'Mila', 'Raka', 'Sandi', 'Toni', 'Rangga',
            'Satria', 'Yudha', 'Zaky', 'Farhan', 'Naufal', 'Aldo', 'Rico', 'Guntur', 'Rizal', 'Wahyu',
            'Dika', 'Sifa', 'Miftah', 'Rian', 'Fandi', 'Andre', 'Vino', 'Reza', 'Bintang', 'Dimas',
            'Edo'
        ];

        // Ensure we have exactly 100 names
        $allNames = array_merge($requiredNames, array_slice($otherNames, 0, 91));
        shuffle($allNames); // Shuffle so the required names are distributed

        $mahasiswaList = [];
        $nimCounter = 240030000;
        $nameIndex = 0;

        foreach ($kelasList as $kelasIndex => $kelas) {
            $prodi = $prodiList[$kelasIndex];
            
            for ($j = 0; $j < 10; $j++) {
                $nim = (string)$nimCounter++;
                $studentName = $allNames[$nameIndex++];

                $user = User::create([
                    'name' => $studentName,
                    'email' => $nim . '@mail.com',
                    'password' => $password,
                    'role' => 'mahasiswa',
                ]);

                $mahasiswaList[] = Mahasiswa::create([
                    'user_id' => $user->id,
                    'prodi' => $prodi,
                    'nim' => $nim,
                    'kelas_id' => $kelas->id,
                ]);
            }
        }

        // 5. Data Jadwal Kuliah (Beberapa variasi)
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jamList = ['08:00', '10:00', '13:00', '15:00'];

        foreach ($mkList as $mkIndex => $mk) {
            for ($k = 0; $k < 2; $k++) {
                $dosen = $dosenList[array_rand($dosenList)];
                $kelas = $kelasList[array_rand($kelasList)];
                $hari = $hariList[array_rand($hariList)];
                $jamMulai = $jamList[array_rand($jamList)];
                $jamSelesai = date('H:i', strtotime($jamMulai . ' + 2 hours'));

                $jadwal = JadwalKuliah::create([
                    'dosen_id' => $dosen->id,
                    'mata_kuliah_id' => $mk->id,
                    'kelas_id' => $kelas->id,
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                ]);

                // Create 16 sessions
                for ($i = 1; $i <= 16; $i++) {
                    \App\Models\SesiPresensi::create([
                        'jadwal_kuliah_id' => $jadwal->id,
                        'pertemuan' => $i,
                        'qr_token' => Str::random(40),
                        'status' => 'ditutup',
                    ]);
                }
            }
        }
    }
}
