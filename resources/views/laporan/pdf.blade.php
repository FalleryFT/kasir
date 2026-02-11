<!DOCTYPE html>
<html>
<head>
    <center><title>Laporan Penjualan</title></center>
</head>
<body>
    <h1>Laporan Penjualan</h1>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Pelanggan</th>
                <th>Tanggal & Waktu</th>
                <th>Tipe</th>
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Poin Digunakan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
            <tr>
                <td>{{ $item->laporanid }}</td>
                <td>{{ $item->user->username ?? 'Tidak Ada' }}</td>
                <td>{{ $item->pelanggan->nama_pelanggan ?? 'Bukan Member' }}</td>
                <td>{{ $item->tanggal_waktu }}</td>
                <td>{{ $item->tipe }}</td>
                <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                <td>{{ number_format($item->diskonRp, 0, ',', '.') }}</td>
                <td>{{ $item->poin_use ?? 0 }}</td>
                <td>{{ number_format($item->hargatotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
