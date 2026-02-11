@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Edit Pelanggan</h2>
    <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" name="nama_pelanggan" value="{{ $pelanggan->nama_pelanggan }}" required>
        </div>

        <div class="mb-3">
            <label>Tipe</label>
            <select name="tipe" class="form-control" required>
                <option value="Reguler" {{ $pelanggan->tipe == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                <option value="VIP" {{ $pelanggan->tipe == 'VIP' ? 'selected' : '' }}>VIP</option>
                <option value="VVIP" {{ $pelanggan->tipe == 'VVIP' ? 'selected' : '' }}>VVIP</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat">{{ $pelanggan->alamat }}</textarea>
        </div>
        <div class="mb-3">
            <label for="notelp" class="form-label">No. Telp</label>
            <input type="text" class="form-control" name="notelp" value="{{ $pelanggan->notelp }}" required>
        </div>
        <div class="mb-3">
            <label for="poin" class="form-label">Poin</label>
            <input type="number" class="form-control" name="poin" value="{{ $pelanggan->poin }}">
        </div>
        <button type="submit" class="btn btn-icon icon-left btn-success"><i class="fas fa-check"></i> Update</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-icon icon-left btn-light"><i class="fas fa-times"></i> Batal</a>
    </form>
</div>
@endsection
