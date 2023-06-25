<?php

use Illuminate\Support\Facades\Route;

// Include Student Controller
use App\Http\Controllers\StudentController;
// untuk Register
use App\Http\Controllers\AuthController;

use RealRashid\SweetAlert\Facades\Alert;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    Alert::success('WELCOME', 'Ok');

    return view('welcome');
});

// akses halaman awal student    
Route::get('/', function () {
    return redirect('/student');
});

Route::get('/student', [StudentController::class, 'index'])
    ->name('student.index')->middleware('auth');

// buat data
Route::get('/student/add', [StudentController::class, 'create'])
    ->name('student.create')->middleware('auth');
Route::post('/student/add', [StudentController::class, 'store'])
    ->name('student.store')->middleware('auth');

Route::get('/student/{id}', [StudentController::class, 'show'])
    ->name('student.show')->middleware('auth');

Route::get('/student/edit/{id}', [StudentController::class, 'edit'])
    ->name('student.edit')->middleware('auth');
Route::PUT('/student/edit/{id}', [StudentController::class, 'update'])
    ->name('student.update')->middleware('auth');

Route::DELETE('/student/delete/{id}', [StudentController::class, 'destroy'])
    ->name('student.destroy')->middleware('auth');

Route::get('/student/download/{id}', [StudentController::class, 'download'])
    ->name('student.download')->middleware('auth');

Route::get('/student/preview/{id}', [StudentController::class, 'preview'])
    ->name('student.preview')->middleware('auth');
//PDF
Route::get('/student/pdf', [StudentController::class, 'pdf'])
    ->name('student.pdf')->middleware('auth');

//Register, Login & logout

Route::get('/register', [AuthController::class, 'halaman_register'])
->name('register.index')->middleware('guest');

//Rout Proses register
Route::post('/register', [AuthController::class, 'proses_register'])
    ->name('register.process')->middleware('guest');

//untuk halaman login
Route::get('/login', [AuthController::class, 'halaman_login'])
    ->name('login')->middleware('guest');

//untuk proses login
Route::post('/login', [AuthController::class, 'proses_login'])
    ->name('login.process')->middleware('guest');

// proses Logout
Route::post('/logout', [AuthController::class, 'proses_logout'])
    ->name('logout')->middleware('auth');