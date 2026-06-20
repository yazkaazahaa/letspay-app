<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

// Mengalihkan halaman utama langsung ke rute dashboard sesuai instruksi tugas
Route::get('/', function () {
    return redirect('/dashboard');
});

// Registrasi rute resource sesuai method controller yang tersedia
Route::resource('students', StudentController::class)->except(['show']);
Route::resource('payments', PaymentController::class)->only(['index', 'store', 'update', 'destroy']);

// Rute dashboard utama dengan proteksi error handling basis data cloud
Route::get('/dashboard', function () {
    
    // Inisialisasi nilai awal aman agar tidak memicu crash jika tabel kosong
    $totalStudents = 0;
    $lunas = 0;
    $belum = 0;

    $bulanIni = date('F');
    $tahunIni = date('Y');

    try {
        // Melakukan pengecekan apakah tabel fisik sudah terbentuk di Supabase
        if (Schema::hasTable('students')) {
            $totalStudents = Student::count();
        }

        if (Schema::hasTable('payments')) {
            $lunas = Payment::where('bulan', $bulanIni)
                ->where('tahun', $tahunIni)
                ->where('status', 'Lunas')
                ->count();

            $belum = Payment::where('bulan', $bulanIni)
                ->where('tahun', $tahunIni)
                ->where('status', 'Belum Lunas')
                ->count();
        }
    } catch (\Exception $e) {
        // Jika koneksi database sempat mengalami jeda serverless, tangkap dan biarkan bernilai 0
        Log::error("Koneksi database Supabase bermasalah: " . $e->getMessage());
    }

    return view('dashboard', compact(
        'totalStudents',
        'lunas',
        'belum',
        'bulanIni',
        'tahunIni'
    ));
});
