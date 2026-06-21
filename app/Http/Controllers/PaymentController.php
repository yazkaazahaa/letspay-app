<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('F');
        $tahun = $request->tahun ?? date('Y');
        $payments = collect();
        $students = collect();
        $databaseError = null;

        try {
            if (Schema::hasTable('payments')) {
                $payments = Payment::with('student')
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->latest()
                    ->get();
            } else {
                $databaseError = 'Tabel payments belum tersedia. Jalankan migration database production terlebih dahulu.';
            }

            if (Schema::hasTable('students')) {
                $students = Student::orderBy('nama_siswa')->get();
            } else {
                $databaseError = $databaseError ?? 'Tabel students belum tersedia. Jalankan migration database production terlebih dahulu.';
            }
        } catch (\Throwable $e) {
            Log::error('Gagal memuat data pembayaran: ' . $e->getMessage());
            $databaseError = 'Data pembayaran belum bisa dimuat. Periksa koneksi database di Vercel.';
        }

        return view('payments.index', compact('payments', 'students', 'bulan', 'tahun', 'databaseError'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'status' => 'required'
        ]);

        Payment::create($request->all());

        return redirect()->route('payments.index', [
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        ])->with('success', 'Pembayaran berhasil ditambahkan');
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $payment->update($request->only('status', 'tanggal_bayar'));

        return back()->with('success', 'Pembayaran diupdate');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return back()->with('success', 'Pembayaran dihapus');
    }
}
