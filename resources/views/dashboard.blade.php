<!DOCTYPE html>
<html>
<head>
    <title>Let'sPay - Dashboard</title>

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

<h1>Dashboard Let'sPay</h1>

<p>Bulan: {{ $bulanIni }} {{ $tahunIni }}</p>

<hr>

<h3>Total Siswa</h3>
<p>{{ $totalStudents }}</p>

</body>
</html>