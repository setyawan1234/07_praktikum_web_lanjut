<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Mahasiswa_Matakuliah;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;
use PDF;
class MahasiswaController extends Controller
{

    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        
        $mahasiswas = Mahasiswa::with('kelas')->get(); // Mengambil semua isi tabel
        $paginate = Mahasiswa::orderBy('id', 'desc');
        if (request('search')) {
            $paginate->where('nama', 'like', '%' . request('search') . '%')
                ->orWhere('nim', 'like', '%' . request('search') . '%');
        }
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswas,'paginate'=>$paginate->paginate(3)]);
        
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create',['kelas'=>$kelas]);
    }

    public function store(Request $request)
    {
        //melakukan validasi data
        $validateData = $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'kelas_id' => 'required',
            'Jurusan' => 'required',
            'Foto' => 'required',
            'TanggalLahir'=>'required',
            'No_Handphone'=>'required',
            'Email'=>'required'
        ]);
        if ($request->file('Foto')) {
            $validateData['Foto'] = $request->file('Foto')->store('images', 'public');
        }
        Mahasiswa::create($validateData);
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil ditambahkan');

        //fungsi eloquent untuk menambah data
        // Mahasiswa::create($request->all());

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
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


    public function update(Request $request,Mahasiswa $mahasiswa)
    {
        $validateData = $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'kelas_id' => 'required',
            'Jurusan' => 'required',
            'Foto' => 'required',
            'TanggalLahir'=>'required',
            'No_Handphone'=>'required',
            'Email'=>'required'
        ]);
        if ($mahasiswa->Foto && file_exists(storage_path('app/public/' . $mahasiswa->Foto))) {
            Storage::delete('public/' . $mahasiswa->Foto);
        }
        $foto = $request->file('Foto')->store('images', 'public');
        $validateData['Foto'] = $foto;
        Mahasiswa::where('id', $mahasiswa->id)->update($validateData);
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::where('id',$mahasiswa->id)->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function search(Request $request)
    {
        $keyword = $request->search;
        $mahasiswas = Mahasiswa::where('Nama', 'like', "%" . $keyword . "%")->paginate(5);
        return view('mahasiswa.index', compact('mahasiswas'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function khs($Nim)
    {
        $mahasiswas = Mahasiswa::where('nim', $Nim)->first();
        return view('mahasiswa.nilai', ['mahasiswas' => $mahasiswas]);
    }

    public function cetak_pdf(Mahasiswa $mahasiswa)
    {
        $nilai = Mahasiswa_Matakuliah::where('mahasiswa_id',$mahasiswa->id)->get();
        $pdf = PDF::loadview('mahasiswa.pdf', ['mahasiswa' => $mahasiswa,'nilai1'=>$nilai]);
        return $pdf->stream();
    }
}