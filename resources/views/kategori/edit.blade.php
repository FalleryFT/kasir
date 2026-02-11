@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Edit Kategori</h2>
    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Kode Kategori</label>
            <input type="text" name="kode_kategori" id="nama_kategori" class="form-control" value="{{ $kategori->kode_kategori }}" required>
        </div>
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="{{ $kategori->nama_kategori }}" required>
        </div>
        <button type="submit" class="btn btn-icon icon-left btn-success"><i class="fas fa-check"></i> Update</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-icon icon-left btn-light"><i class="fas fa-times"></i> Batal</a>
    </form>
</div>
@endsection
