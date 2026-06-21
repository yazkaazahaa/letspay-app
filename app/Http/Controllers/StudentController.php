<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;


class StudentController extends Controller
{
    public function index()
    {
        $students = collect();
        $databaseError = null;

        try {
            if (Schema::hasTable('students')) {
                $students = Student::latest()->get();
            } else {
                $databaseError = 'Tabel students belum tersedia. Jalankan migration database production terlebih dahulu.';
            }
        } catch (\Throwable $e) {
            Log::error('Gagal memuat data siswa: ' . $e->getMessage());
            $databaseError = 'Data siswa belum bisa dimuat. Periksa koneksi database di Vercel.';
        }

        return view('students.index', compact('students', 'databaseError'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'nama_wali' => 'required',
            'no_hp_wali' => 'required',
            'alamat' => 'required',
            'biaya_bulanan' => 'required|numeric',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'nama_wali' => 'required',
            'no_hp_wali' => 'required',
            'alamat' => 'required',
            'biaya_bulanan' => 'required|numeric',
        ]);

        $student->update($request->only([
            'nama_siswa',
            'kelas',
            'nama_wali',
            'no_hp_wali',
            'alamat',
            'biaya_bulanan',
            'tanggal_jatuh_tempo',
        ]));

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil diupdate');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}
