@extends('layouts.main')

@section('content')
<div class="container col-8 p-2 rounded">
    <h2>Detail Kategori</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $kategori->id }}</td>
        </tr>
        <tr>
            <th>Kode Kategori</th>
            <td>{{ $kategori->kode_kategori }}</td>
        </tr>
        <tr>
            <th>Nama Kategori</th>
            <td>{{ $kategori->nama_kategori }}</td>
        </tr>
        <tr>
            <th>Dibuat Oleh</th>
            <td>{{ $kategori->created_by ?? '-' }}</td>
        </tr>
        <tr>
            <th>Diupdate Oleh</th>
            <td>{{ $kategori->updated_by ?? '-' }}</td>
        </tr>
        <tr>
            <th>Dibuat Pada</th>
            <td>{{ $kategori->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Diupdate Pada</th>
            <td>{{ $kategori->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>
    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
