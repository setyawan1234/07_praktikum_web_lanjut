<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table="mahasiswas"; // Eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswas
    protected $primaryKey = 'nim'; // Memanggil isi DB Dengan primarykey

    protected $fillable = [
        'Nim',
        'Nama',
        'Email',
        'TanggalLahir',
        'kelas_id',
        'Jurusan',
        'No_Handphone',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }


}