<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mahasiswas')->insert(
            [
            'Nama' => 'Gilang Setyawan',
            'Nim' => '2041720059',
            'kelas_id' => 1,
            'foto' => 'background.jpg',
            'Email' => 'gilangsetyawan3432@gmail.com',
            'Jurusan' => 'Teknologi Informasi',
            'No_Handphone' => '085707011668',
            'TanggalLahir' => '2002-04-29'
            ]
        );
    }
}