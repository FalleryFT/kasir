@extends('layouts.main')

@section('content')
<div class="container ">
    <h2>Edit Produk</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produk.update', $produk->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kode_produk" class="form-label">Kode Produk</label>
            <input type="text" name="kode_produk" class="form-control" value="{{ $produk->kode_produk }}" required>
        </div>

        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
        </div>

        <div class="mb-3">
            <label for="kategoriid" class="form-label">Kategori</label>
            <select name="kategoriid" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id }}" {{ $produk->kategoriid == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="harga_beli" class="form-label">Harga Beli (Terbaru)</label>
            <input type="number" name="harga_beli" class="form-control" value="{{ $produk->harga_beli }}" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ $produk->stock }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
            <input type="date" name="tanggal_kadaluarsa" class="form-control" value="{{ $produk->tanggal_kadaluarsa }}" required>
        </div>

        <button type="submit" class="btn btn-icon icon-left btn-success"><i class="fas fa-check"></i> Update</button>
        <a href="{{ route('produk.index') }}" class="btn btn-icon icon-left btn-light"><i class="fas fa-times"></i> Batal</a>
    </form>
</div>
@endsection