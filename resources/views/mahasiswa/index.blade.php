@extends('mahasiswa.layout') @section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="float-right my-2">
                <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <form action="/mahasiswa">
            <div class="input-group mb-3 mt-3">
                <input type="text" class="form-control" placeholder="Masukkan Nama Mahasiswa" name="search"
                    value="{{ request('search') }}">
                <button class="btn btn-outline-success" type="submit" id="button-addon2">Cari</button>
            </div>
        </form>
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Foto</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No_Handphone</th>
            <th>Email</th>
            <th>Tanggal Lahir</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($paginate as $Mahasiswa)
            <tr>

                <td>{{ $Mahasiswa->Nim }}</td>
                <td>{{ $Mahasiswa->Nama }}</td>
                <td><img src="{{ asset('storage/'.$Mahasiswa -> Foto) }}" alt="" height="150px" width="150px" class="rounded"style="object-fit: cover"></td>
                <td>{{ $Mahasiswa->kelas->nama_kelas }}</td>
                <td>{{ $Mahasiswa->Jurusan }}</td>
                <td>{{ $Mahasiswa->No_Handphone }}</td>
                <td>{{ $Mahasiswa->Email }}</td>
                <td>{{ $Mahasiswa->TanggalLahir }}</td>
                <td>
                    <form action=" {{ route('mahasiswa.destroy', $Mahasiswa->Nim) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('mahasiswa.show', $Mahasiswa->Nim) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('mahasiswa.edit', $Mahasiswa->Nim) }}">Edit</a>
                        <a class="btn btn-warning" href="/mahasiswa/nilai/{{ $Mahasiswa->Nim }}">Nilai</a>
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                        
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{$paginate->links('pagination::bootstrap-4')}}
@endsection