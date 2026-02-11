<!DOCTYPE html>
<html>
<head>
    <center><title>Laporan Stok Barang</title></center>
</head>
<body>
    <h2>Laporan Stok Barang</h2>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Stok Sebelumnya</th>
                <th>Stok Setelah</th>
                <th>Tanggal Laporan</th>
                <th>Dibuat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporanStok as $laporan)
            <tr>
                <td>{{ $laporan->id }}</td>
                <td>{{ $laporan->produk->nama_produk }}</td>
                <td>{{ $laporan->produk->kategori->nama_kategori }}</td>
                <td>{{ $laporan->stok_sebelumnya }}</td>
                <td>{{ $laporan->stok_setelah }}</td>
                <td>{{ $laporan->tanggal_laporan }}</td>
                <td>{{ $laporan->created_by }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
