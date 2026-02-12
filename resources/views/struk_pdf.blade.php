<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #invoice,
            #invoice * {
                visibility: visible;
            }

            #invoice {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body style="font-family: 'Poppins', sans-serif; background-color: #f5f5f5;">
    <div class="container mt-3 py-3" id="invoice">
        <div class="text-center mb-4">
            <h2>Invoice Pembelanjaan</h2>
            <p>{{ date('d-m-Y H:i:s', strtotime($struk->tanggal_penjualan)) }}</p>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Nama Kasir:</strong> {{ $struk->created_by }}</p>
                <p><strong>Nama Pelanggan:</strong> {{ $struk->pelanggan->nama_pelanggan ?? 'Non Member' }}</p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Tipe Pelanggan:</strong> {{ $struk->pelanggan->tipe ?? 'Reguler' }}</p>
            </div>
        </div>

        <h4>Daftar Barang Belanjaan</h4>
        <div class="table-responsive mb-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($struk->details as $detail)
                        <tr>
                            <td>{{ $detail->produk->nama ?? 'Produk Dihapus' }}</td>
                            <td>{{ number_format($detail->harga_satuan) }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>{{ number_format($detail->subtotal) }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <p><strong>Subtotal Harga:</strong> Rp {{ number_format($struk->subtotal, 0, ',', '.') }}</p>
                <p><strong>Diskon:</strong> Rp {{ number_format($struk->diskon, 0, ',', '.') }}</p>
                <p><strong>Poin Membership Digunakan:</strong> Rp
                    {{ number_format($struk->poin_digunakan, 0, ',', '.') }}</p>
                <p><strong>PPN (12%):</strong> Rp {{ number_format($struk->pajak, 0, ',', '.') }}</p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Total Pembayaran:</strong> Rp {{ number_format($struk->total_pembayaran, 0, ',', '.') }}</p>
                <p><strong>Jumlah Uang yang Dibayar:</strong> Rp {{ number_format($struk->jumlah_bayar, 0, ',', '.') }}
                </p>
                <p><strong>Kembalian:</strong> Rp {{ number_format($struk->kembalian, 0, ',', '.') }}</p>
                @if(in_array($struk->pelanggan->tipe ?? 'Reguler', ['VIP', 'VVIP']))
                    <p><strong>Poin Membership Didapat:</strong> {{ number_format($struk->poin_didapat, 0, ',', '.') }} Poin
                    </p>
                @endif
            </div>
        </div>

        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-info text-white">Cetak Struk</button>
            <a href="{{ route('kasir.index') }}" class="btn btn-warning text-white">Kembali ke Kasir</a>
        </div>
    </div>
</body>

</html>