@extends('layout/admin')

@push('title', 'Create')

@section('content')

              <!-- <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item me-3 me-lg-0">
                  <a class="nav-link" href="#!">
                    <i class="fas fa-shopping-cart"></i>
                  </a>
                </li>
                <li class="nav-item me-3 me-lg-0">
                  <a class="nav-link" href="#!">
                    <i class="fab fa-twitter"></i>
                  </a>
                </li>
                <li class="nav-item me-3 me-lg-0">
                  <a class="nav-link" href="#!">
                    <i class="fab fa-instagram"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav> -->
        <!-- end Navbar -->

    <div class="container">
    <div class="card">
    <div class="card-header">
      <center><a class="title">Tambah Mahasiswa</a></center>

      <form action="/student/add" method="POST" enctype="multipart/form-data"> 
      @csrf

    <div class="card-body">
        @if(session('notifikasi'))
        <div class="form-group">
            <div class="alert alert-{{ session('type') }}">
                {{ session('notifikasi') }}

    </div>
    </div>
    </div>
      @endif
    
    <!-- Kolom input -->
    <div class="form-group">
    <label for="nama">NIM <b class="text-danger">*</b></label>
    <input required placeholder="Masukkan NIM" type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}">
    @error('nim')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    </div>

    <div class="form-group">
    <label for="nama">Nama <b class="text-danger">*</b></label>
    <input required placeholder="Masukkan Nama" type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
    @error('nama')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    </div>
    <div class="form-group">
    <label for="nama">E-Mail <b class="text-danger">*</b></label>
    <input required placeholder="Masukkan E-Mail" type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
    @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    <div class="form-group">
        <label for="nama">Prodi <b class="text-danger">*</b></label>
        <select required id="prodi" name="prodi" class="form-control @error('prodi') is-invalid @enderror" required>
        <option value="">*Pilih Prodi</option>
        <option>Teknik Informatika</option>
        <option>Geomatika</option>
        <option>Animasi</option>
        <option>Teknik Multimedia Dan Jaringan</option>
        <option>Rekayasa Keamanan Siber</option>
        <option>Rekayasa Perangkat Lunak</option>
        </select>
        @error('prodi')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        </div>

        <div class="form-group">
          <label for="nama">Foto <b class="text-danger">*</b></label>
          <input required placeholder="Upload Foto" type="file" accept="image/png, image/jpg, img/jpeg" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror">
          @error('foto')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        </div>

        <div class="card-footer">
        <a href="/student" class="btn btn-outline-danger">Batal</a>
        <button type="reset" class="btn btn-outline-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-success">Simpan</button>
        </div>
            </div>

        <!-- Copyright -->
        <footer class="fixed-bottom">
          <div id="container">
            <div id="header">
              <div id="body">
        <!--<p class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);"> © 2023 Copyright
        </p>-->
          </div>
          </div>
        </div>
      </div>

        <!-- Copyright -->

        </footer>
            </form>
        </div>
      </div>
    </div>
@endsection

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"  crossorigin="anonymous"></script>