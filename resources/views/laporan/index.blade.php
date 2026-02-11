@extends('layouts.main')

@section('title', 'Laporan Penjualan')

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

                    <form method="GET" action="{{ route('laporan.index') }}" class="mb-3">
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
                        <a href="{{ route('laporan_penjualan_export_pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-primary btn-icon" title="Export PDF">
                            <i class="fas fa-file-pdf"></i> Cetak
                        </a>                        
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="laporan-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Tipe</th>
                                    <th>Subtotal</th>
                                    <th>Diskon</th>
                                    <th>Poin Digunakan</th>
                                    <th>Total Harga</th>
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
            $('#laporan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '',
                columns: [{
                        data: 'laporanid',
                        name: 'laporanid'
                    },
                    {
                        data: 'user.username',
                        name: 'user.username',
                        defaultContent: 'Tidak Ada'
                    },
                    {
                        data: 'pelanggan.nama_pelanggan',
                        name: 'pelanggan.nama_pelanggan',
                        defaultContent: 'Bukan Member'
                    },
                    {
                        data: 'tanggal_waktu',
                        name: 'tanggal_waktu'
                    },
                    {
                        data: 'tipe',
                        name: 'tipe'
                    },
                    {
                        data: 'subtotal',
                        name: 'subtotal',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                    },
                    {
                        data: 'diskonRp',
                        name: 'diskonRp',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                    },
                    {
                        data: 'poin_use',
                        name: 'poin_use',
                        defaultContent: 0
                    },
                    {
                        data: 'hargatotal',
                        name: 'hargatotal',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                    },
                    {
                        data: 'laporanid',
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
                    url: '/laporan/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Laporan berhasil dihapus!');
                        $('#laporan-table').DataTable().ajax.reload();
                    },
                    error: function() {
                        alert('Gagal menghapus laporan!');
                    }
                });
            }
        }
    </script>
@endpush
