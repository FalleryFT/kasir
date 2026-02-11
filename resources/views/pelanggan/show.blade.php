@extends('layouts.main')

@section('content')
<div class="container col-8 p-2 rounded">
    <h2>Detail Pelanggan</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $pelanggan->id }}</td>
        </tr>
        <tr>
            <th>Nama Pelanggan</th>
            <td>{{ $pelanggan->nama_pelanggan }}</td>
        </tr>
        <tr>
            <th>Tipe</th>
            <td>{{ $pelanggan->tipe }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $pelanggan->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <th>No. Telepon</th>
            <td>{{ $pelanggan->notelp }}</td>
        </tr>
        <tr>
            <th>Poin</th>
            <td>{{ $pelanggan->poin }}</td>
        </tr>
        <tr>
            <th>Dibuat Oleh</th>
            <td>{{ $pelanggan->created_by ?? '-' }}</td>
        </tr>
        <tr>
            <th>Diupdate Oleh</th>
            <td>{{ $pelanggan->updated_by ?? '-' }}</td>
        </tr>
    </table>
    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
