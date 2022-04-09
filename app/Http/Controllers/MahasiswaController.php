<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kelas;
class MahasiswaController extends Controller
{

    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswas = Mahasiswa::with('kelas')->get(); // Mengambil semua isi tabel
        $paginate = Mahasiswa::orderBy('id', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswas,'paginate'=>$paginate]);
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create',['kelas'=>$kelas]);
    }

    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([ 'Nim' => 'required', 'Nama' => 'required','Email' => 'required',
        'TanggalLahir' => 'required', 'kelas_id' => 'required','Jurusan' => 'required', 'No_Handphone' => 'required',
        ]);

        // $mahasiswas = new Mahasiswa;
        // $mahasiswas->Nim = $request->get('Nim');
        // $mahasiswas->Nama = $request->get('Nama');
        // $mahasiswas->Email = $request->get('Email');
        // $mahasiswas->TanggalLahir = $request->get('TanggalLahir');
        // $mahasiswas->Jurusan = $request->get('Jurusan');
        // $mahasiswas->No_Handphone = $request->get('No_Handphone');
        // $mahasiswas->save();

        // $kelas = new kelas;
        // $kelas->id = $request->get('Kelas');

        // //fungsi eloquent untuk menambah data dengan relasi belongsTo
        // $mahasiswas->kelas()->associate($kelas);
        // $mahasiswas->save();

        // //jika data berhasil ditambahkan, akan kembali ke halaman utama
        // return redirect()->route('mahasiswa.index')
        // ->with('success','Mahasiswa berhasil ditambahkan');
        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $mahasiswas = Mahasiswa::with('kelas')->where('Nim',$Nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa'=>$mahasiswas]);

    }


    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim',$Nim)->first();
        $kelas = kelas::all();
        return view('mahasiswa.edit',compact('Mahasiswa','kelas'));

    }


    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //melakukan validasi data
        $validateData = $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'kelas_id' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'No_Handphone' => 'required',
            'TanggalLahir' => 'required',
        ]);
        Mahasiswa::where('id', $mahasiswa->id)->update($validateData);
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil diubah');

    }

    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Dihapus');

    }
    public function search(Request $request)
    {
        $keyword = $request->search;
        $mahasiswas = Mahasiswa::where('Nama', 'like', "%" . $keyword . "%")->paginate(5);
        return view('mahasiswa.index', compact('mahasiswas'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
}