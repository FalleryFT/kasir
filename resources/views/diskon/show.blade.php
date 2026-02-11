@extends('layouts.main')

@section('content')
<div class="container col-8 p-2 rounded">
    <h2>Detail Diskon</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID Diskon</th>
            <td>{{ $diskon->diskonid }}</td>
        </tr>
        <tr>
            <th>Nama Produk</th>
            <td>{{ $diskon->produk->nama_produk }}</td>
        </tr>
        <tr>
            <th>Kode Produk</th>
            <td>{{ $diskon->produk->kode_produk }}</td>
        </tr>
        <tr>
            <th>Diskon (%)</th>
            <td>{{ $diskon->diskon }}%</td>
        </tr>
        <tr>
            <th>Berlaku Sampai</th>
            <td>{{ $diskon->berlaku_sampai ? date('d M Y', strtotime($diskon->berlaku_sampai)) : '-' }}</td>
        </tr>
        <tr>
            <th>Harga Awal</th>
            <td>Rp {{ number_format($diskon->produk->harga_jual, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Harga Setelah Diskon</th>
            <td>Rp {{ number_format($diskon->produk->harga_jual * (1 - $diskon->diskon / 100), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Dibuat Oleh</th>
            <td>{{ $diskon->created_by ?? '-' }}</td>
        </tr>
        <tr>
            <th>Diupdate Oleh</th>
            <td>{{ $diskon->updated_by ?? '-' }}</td>
        </tr>
    </table>
    <a href="{{ route('diskon.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
