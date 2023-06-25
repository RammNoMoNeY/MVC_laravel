<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Memanggil seluruh data dari table student
        $students = Student::all();

        return view('student.index', ['students' => $students ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'nim' => 'required|unique:students,nim',
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required',
            'foto' => 'required'
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',
            'foto.required' => 'foto TIDAK ADA'
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('public/foto');
            $foto = basename($foto);
        } else {
            $foto = null;
        }
        
        $students = new Student();
        $students->nim = $request->nim;
        $students->nama = $request->nama;
        $students->email = $request->email;
        $students->prodi = $request->prodi;

        $students->foto = $foto ? 'foto/' . $foto : null;

            if ( $students->save() ) {
                    return redirect('/student')->with([
                        'notifikasi' => 'Data Berhasil disimpan !',
                        'type' => 'success'
            ]);
                } else {
                    return redirect()->back()->with([
                        'notifikasi' => 'Data gagal disimpan !',
                        'type' => 'error'
            ]);

            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $student = Student::where(['nim' => $id ]);

        if ( $student->count() < 1 ) {
            return redirect('/student')->with([
                'notifikasi' => 'Data siswa tidak ditemukan !',
                'type' => 'error'

            ]); 
        }

        return view('student.edit', ['student' => $student->first() ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::where('nim', $id);
        //ddd($request->old_nim, $request->nim);
        if ($student->count() != 1) {
            return redirect()->back()->with([
                'notifikasi' => 'Data mahasiswa tidak ditemukan !',
                'type' => 'error'
            ]);
        }

        $student = $student->first();

        $validatedData = $request->validate([
            'nim' => [
                'required',
                'unique:students,nim,' . $request->old_nim . ',nim',
            ],
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required'
            ], [                
                'nim.required' => 'NIM harus diisi.',
                'nim.unique' => 'NIM sudah digunakan.',
                'nama.required' => 'Nama harus diisi.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'prodi.required' => 'Program studi harus diisi.'
            ]);

            // Cek ganti Foto
            if ($request->ganti_foto == 1) {
                $request->validate([
                    'foto' => 'required'
                ], [
                    'foto.required' => 'Foto harus diupload.',
                ]);

            //
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto')->store('public/foto');
                $foto = basename($foto);
                $foto = 'foto/' . $foto;
            } else {
                $foto = null;
            }

        } else {
            $foto = $student->foto;
        }
        // Foto lama
            $old_foto = $student->foto;

            $student->nim = $request->nim;
            $student->nama = $request->nama;
            $student->email = $request->email;
            $student->prodi = $request->prodi;

            $student->foto = $foto ?? null;

            if ($student->save()) {

                // Hapus file foto lama jika ada dan jika ganti foto 
                if ($request->ganti_foto == 1) {

                    if (!empty($old_foto) && Storage::exists($old_foto)) {
                        Storage::delete($old_foto);
                    }
                }

                return redirect('/student')->with([
                    'notifikasi' => 'Data Berhasil diedit !',
                    'type' => 'success'
                    ]);
                
                } else {

                return redirect()->back()->with([
                    'notifikasi' => 'Data gagal diedit !',
                    'type' => 'error'
                    ]);
                }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $student = Student::where(['nim' => $id]);

        if ($student->count() != 1) {
            return redirect()->back()->with([
                'notifikasi' => 'Data mahasiswa tidak ditemukan !',
                'type' => 'error'
            ]);
        }

        $student = $student->first();

        $foto_siswa = $student->foto;

        if ($student->delete()) {
            
            if (!empty($foto_siswa) && Storage::exists($foto_siswa)) {
                Storage::delete($foto_siswa);
            }

            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil dihapus !',
                'type' => 'success'
            ]);
            } else {
                return redirect()->back()->with([
                    'notifikasi' => 'Data gagal dihapus !',
                    'type' => 'error'
                ]);
            }

    }

    public function download(string $id)
    {
        $student = Student::where('nim', $id)->firstOrfail();
        $file_path = public_path('storage/' . $student->foto);

        if (!file_exists($file_path)) {
            abort(404, 'File tidak ditemukan');
        }
        $file_name = 'foto-' . $student->nim . '.' . pathinfo($file_path, PATHINFO_EXTENSION);

        // var_dump($file_path);

        return response()->download($file_path, $file_name);
    }

    public function preview(string $id)
    {
        $student = Student::where('nim', $id)->firstOrfail();
        $file_path = public_path('storage/' . $student->foto);

        if (!file_exists($file_path)) {
            abort(404, 'File tidak ditemukan');
        }
    
        // var_dump($file_path);

        return response()->file($file_path);
    }
    // PDF
    public function pdf()
    {
        // Get the student data
        $students = Student::all();

        // Load the HTML template
        $html = View('student.pdf', compact('students'))->render();

        // Instantiate the Dompdf class
        $dompdf = new Dompdf();

        // Set options for Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', public_path());
        $dompdf->setOptions($options);

        // Load the HTML into Dompdf
        $dompdf->loadHtml($html);

        // Render the PDF
        $dompdf->render();

        // return pdf
        return $dompdf->stream('student.pdf');
    }

}
