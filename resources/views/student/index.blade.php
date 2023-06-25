@extends('layout/admin')

@push('title', 'Student')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
  <div class="card-header">
     <center><a class="title"><b>Data Mahasiswa</b></a></center>
  </div>
  
<!--<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto">
      <li class="nav-item">
        <a class="nav-link" href="/student/add">TAMBAH DATA</a>
      </li>
    </ul>-->
  
    <div class="card-body">
      <!--Sweetalert-->
      @if(session('notifikasi'))
      <div class="alert alert-{{ session('type') }}">
          {{ session('notifikasi') }}
      </div>
      @endif
  
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
                <thead>
                  <td>NO.</td>
                  <td>NIM</td>
                  <td>Nama</td>
                  <td>Prodi</td>
                  <td>Foto</td>
                  <td>Tombol</td>
              </thead>
              
                <tbody>
      
                  @forelse ( $students as $index => $data )
                  <tr>
                      <td>{{ $index+1 }}</td>
                      <td>{{ $data->nim }}</td>
                      <td>{{ $data->nama }}</td>
                      <td>{{ $data->prodi }}</td>
      
                      {{-- Link --}}
                    <td>
                      <img class="img-fluid" src="{{ asset('storage/' .$data->foto ) }}">
                    </td>
  
                      <!-- Button -->  
                      <td>
                        <a href="student/edit/{{ $data->nim }}" class="btn  btn-sm btn-outline-primary mr-1"><i class="bi bi-search"></i>Edit</a>
                        
                        <form method="POST" action="/student/delete/{{ $data->nim }}">
                            @csrf 
                            @method('DELETE')
                          <button type="submit" class="btn  btn-sm btn-outline-danger mr-1">Hapus</button>
                        </form>
                
                        <a href="/student/download/{{ $data->nim }}" class="btn btn-sm btn-outline-primary mr-1"><i class="bi bi-download"></i>Download</a>

                        <a href="/student/preview/{{ $data->nim }}" class="btn btn-sm btn-outline-info mr-1"><i class="bi bi-eye"></i>Preview</a>
                      </td>
                  </tr>
                    @empty
  
                    <tr>
                        <td colspan="5">Tidak ada data untuk ditampilkan !</td>
                    </tr>
                    @endforelse
                </tbody>
          </table>
        </div> 
    </div>
</div>  
@endsection