<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .heading {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .tanggal {
            text-align: center;
            font-size: 14px;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="heading">{{ $heading }}</div>
    <div class="tanggal">{{ $date }}</div>
    <hr>
    <p class="text-center">Jurusan : {{ $jurusan }}</p>
    <p class="text-center">Tahun : {{ $tahun }}</p>
    <table>
        <thead>
            <tr>
                <th width="5%" style="text-align: center">No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Sub Total</th>
                <th>Jenis Anggaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
            <tr>
                <td style="text-align: center">{{ $key + 1 }}</td>
                <td>{{ $item->no_inventaris }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ 'Rp ' . number_format($item->sub_total, 0, ',', '.') }}</td>
                <td>{{ $item->anggaran->jenis_anggaran }} - {{ $item->anggaran->tahun }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
