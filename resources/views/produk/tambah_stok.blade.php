@extends('layouts.main')

@section('content')
<div class="container ">
    <h2>Tambah Stok Produk</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produk.proses-tambah-stok') }}" method="POST" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="produk_id" class="form-label">Produk</label>
            <select name="produk_id" class="form-control" required>
                <option value="">-- Pilih Produk --</option>
                @foreach ($produk as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian (Jangan di isi jika tidak berubah)</label>
            <input type="date" name="tanggal_pembelian" class="form-control" >
        </div>

        <div class="mb-3">
            <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa (Jangan di isi jika tidak berubah)</label>
            <input type="date" name="tanggal_kadaluarsa" class="form-control">
        </div>

        <div class="mb-3">
            <label for="stok_tambahan" class="form-label">Jumlah Stok Tambahan</label>
            <input type="number" name="stok_tambahan" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-icon icon-left btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy-fill" viewBox="0 0 16 16">
                <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z"/>
                <path d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z"/>
            </svg> Simpan
        </button>
        <a href="{{ route('produk.index') }}" class="btn btn-icon icon-left btn-light">
            <i class="fas fa-times"></i> Batal
        </a>
    </form>
</div>
@endsection
