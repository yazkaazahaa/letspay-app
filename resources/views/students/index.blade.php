<!DOCTYPE html>
<html>
<head>
    <title>Let'sPay - Data Siswa</title>

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

    <h1>Data Siswa Les Privat</h1>

    <a href="{{ route('students.create') }}">
        + Tambah Siswa
    </a>

    <br><br>

    @if(session('success'))
        <p style="color:green;">
            {{ session('success') }}
        </p>
    @endif

    @if($databaseError)
        <p style="color:#9f1239; background:#ffe4e6; padding:10px; border-radius:6px;">
            {{ $databaseError }}
        </p>
    @endif

    <table border="1" cellpadding="10">
        <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Wali</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Biaya</th>
            <th>Aksi</th>
        </tr>

        @forelse($students as $student)
        <tr>
            <td>{{ $student->nama_siswa }}</td>
            <td>{{ $student->kelas }}</td>
            <td>{{ $student->nama_wali }}</td>
            <td>{{ $student->no_hp_wali }}</td>
            <td>{{ $student->alamat }}</td>
            <td>{{ $student->biaya_bulanan }}</td>
            <td>

                <a href="{{ route('students.edit', $student->id) }}">
                    Edit
                </a>

                <form action="{{ route('students.destroy', $student->id) }}"
                      method="POST"
                      style="display:inline;">

                    @csrf
                    @method('DELETE')

                    <button type="submit">
                        Hapus
                    </button>

                </form>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;">
                Belum ada data siswa.
            </td>
        </tr>
        @endforelse

    </table>

</body>
</html>
