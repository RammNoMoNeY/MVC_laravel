<!DOCTYPE html>
<html>
    <head>
        {{-- Include css --}}
        <link href="{{ asset('/css/sb-admin-2.min.css') }}" rel="stylesheet">
    </head>

    <body>
        
        <h3>Data Mahasiswa</h3>
        <hr>

        <table class="table table-bordered table-hover">
            <thead>
              <td>NO.</td>
              <td>NIM</td>
              <td>Nama</td>
              <td>Prodi</td>
          </thead>

          <tbody>
            @forelse ( $student as $key => $value)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $value->nim }}</td>
                <td>{{ $value->nama }}</td>
                <td>{{ $value->prodi }}</td>
            </tr>
            @empty
            <tr>
                <td>Tidak ada data yang ditemukan !</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        
    </body>
</html>