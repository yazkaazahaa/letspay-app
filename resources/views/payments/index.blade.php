<!DOCTYPE html>
<html>
<head>
    <title>Let'sPay - Pembayaran</title>

    <style>
    body {
        font-family: Arial;
        background: #f7f2f2;
        margin: 0;
        padding: 20px;
        color: #2c1b1b;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }

    th {
        background: #5c1a1b;
        color: white;
        padding: 10px;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    a {
        color: #5c1a1b;
        text-decoration: none;
        font-weight: bold;
    }

    button {
        background: #5c1a1b;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 5px;
    }

    button:hover {
        background: #7a2324;
    }

    .card {
        background: white;
        padding: 15px;
        margin: 10px 0;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    h1, h3 {
        color: #5c1a1b;
    }

    input, select, textarea {
        padding: 8px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>
</head>
<body>

@include('layouts.navbar')

    <h1>Data Pembayaran Les </h1>

    <form method="GET" action="{{ route('payments.index') }}">
        <select name="bulan">
            <option>Januari</option>
            <option>Februari</option>
            <option>Maret</option>
            <option>April</option>
            <option>Mei</option>
            <option>Juni</option>
            <option>Juli</option>
            <option>Agustus</option>
            <option>September</option>
            <option>Oktober</option>
            <option>November</option>
            <option>Desember</option>
        </select>

        <input type="number" name="tahun" value="{{ $tahun }}">

        <button type="submit">Filter</button>
    </form>

    <br>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @if($databaseError)
        <p style="color:#9f1239; background:#ffe4e6; padding:10px; border-radius:6px;">
            {{ $databaseError }}
        </p>
    @endif

    <h3>Tambah Pembayaran</h3>

    <form method="POST" action="{{ route('payments.store') }}">
        @csrf

        <select name="student_id">
            @forelse($students as $student)
                <option value="{{ $student->id }}">
                    {{ $student->nama_siswa }}
                </option>
            @empty
                <option value="">Belum ada siswa</option>
            @endforelse
        </select>

        <input type="text" name="bulan" placeholder="Bulan (Juni)">
        <input type="number" name="tahun" placeholder="Tahun">

        <select name="status">
            <option value="Lunas">Lunas</option>
            <option value="Belum Lunas">Belum Lunas</option>
        </select>

        <button type="submit" @if($students->isEmpty()) disabled @endif>Simpan</button>
    </form>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>Nama</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        @forelse($payments as $payment)
        <tr>
            <td>{{ $payment->student->nama_siswa ?? 'Siswa tidak ditemukan' }}</td>
            <td>{{ $payment->bulan }}</td>
            <td>{{ $payment->tahun }}</td>
            <td>{{ $payment->status }}</td>
            <td>

                <form action="{{ route('payments.update', $payment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="status"
                           value="{{ $payment->status == 'Lunas' ? 'Belum Lunas' : 'Lunas' }}">

                    <button type="submit">
                        Toggle Status
                    </button>
                </form>

                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit">Hapus</button>
                </form>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;">
                Belum ada data pembayaran untuk periode ini.
            </td>
        </tr>
        @endforelse

    </table>

</body>
</html>
