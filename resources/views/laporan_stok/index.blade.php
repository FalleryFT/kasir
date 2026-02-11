@extends('layouts.main')

@section('title', 'Laporan Stok Barang')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="GET" action="{{ route('laporan_stok.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="start_date">Dari Tanggal</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date">Sampai Tanggal</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary mt-4">Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="text-right">
                        <a href="{{ route('laporan_stok.export_pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-primary btn-icon" title="Export PDF">
                            <i class="fas fa-file-pdf"></i> Cetak
                        </a>     
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="laporan-stok-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Stok Sebelumnya</th>
                                    <th>Stok Setelah</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_script')
    <script>
        $(function() {
            $('#laporan-stok-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'produk.nama_produk',
                        name: 'produk.nama_produk'
                    },
                    {
                        data: 'produk.kategori.nama_kategori',
                        name: 'produk.kategori.nama_kategori'
                    },
                    {
                        data: 'stok_sebelumnya',
                        name: 'stok_sebelumnya'
                    },
                    {
                        data: 'stok_setelah',
                        name: 'stok_setelah'
                    },
                    {
                        data: 'tanggal_laporan',
                        name: 'tanggal_laporan'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'id',
                        name: '_',
                        orderable: false,
                        searchable: false,
                        class: 'text-right nowrap',
                        render: function(data, type, row) {
                            return `
                                <button onclick="destroy(${data})" class="btn btn-danger btn-icon" title="Hapus">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            `;
                        }
                    }
                ]
            });
        });

        function destroy(id) {
            if (confirm('Yakin ingin menghapus laporan ini?')) {
                $.ajax({
                    url: '/laporan_stok/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Laporan berhasil dihapus!');
                        $('#laporan-stok-table').DataTable().ajax.reload();
                    },
                    error: function() {
                        alert('Gagal menghapus laporan!');
                    }
                });
            }
        }
    </script>
@endpush
