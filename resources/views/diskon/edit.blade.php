@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Edit Diskon</h2>
    <form action="{{ route('diskon.update', $diskon->diskonid) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="produkid" class="form-label">Produk</label>
            <select name="produkid" id="produkid" class="form-control" required>
                <option value="">Pilih Produk</option>
                @foreach ($produk as $p)
                    <option value="{{ $p->id }}" {{ $p->id == $diskon->produkid ? 'selected' : '' }}>{{ $p->nama_produk }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="diskon" class="form-label">Berlaku Sampai</label>
            <input type="date" name="berlaku_sampai" id="berlaku_sampai" class="form-control" value="{{ $diskon->berlaku_sampai }}">
        </div>
        <div class="mb-3">
            <label for="diskon" class="form-label">Diskon (%)</label>
            <input type="number" name="diskon" id="diskon" class="form-control" min="0" max="100" value="{{ $diskon->diskon }}" required>
        </div>
        <button type="submit" class="btn btn-icon icon-left btn-success"><i class="fas fa-check"></i> Update</button>
        <a href="{{ route('diskon.index') }}" class="btn btn-icon icon-left btn-light"><i class="fas fa-times"></i> Batal</a>
    </form>
</div>
@endsection
