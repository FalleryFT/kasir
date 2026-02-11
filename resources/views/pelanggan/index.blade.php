@extends('layouts.main')

@section(section: 'title', content: 'Management Pelanggan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-3">
                    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
                        Tambah Pelanggan
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped w-100" id="table-pelanggan">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pelanggan</th>
                                <th>Tipe</th>
                                <th>Alamat</th>
                                <th>No. Telp</th>
                                <th>Poin</th>
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
        var dataTable;
        $(function () {
            dataTable = $('#table-pelanggan').DataTable({
                processing: true,
                serverSide: true,
                ajax: '',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nama_pelanggan', name: 'nama_pelanggan' },
                    { data: 'tipe', name: 'tipe' },
                    { data: 'alamat', name: 'alamat', defaultContent: '-' },
                    { data: 'notelp', name: 'notelp' },
                    { data: 'poin', name: 'poin' },
                    {
                        data: 'id', name: '_', orderable: false, searchable: false, class: 'text-right nowrap',
                        render: function (data, type, row) {
                            let html = `<a href="/pelanggan/${data}" class="btn btn-info btn-icon mr-2" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>`;
                            html += `<a href="/pelanggan/${data}/edit" class="btn btn-warning btn-icon mr-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>`;
                            html += `<button onclick="destroy(${data})" class="btn btn-danger btn-icon" title="Hapus">
                                        <i class="far fa-trash-alt"></i>
                                    </button>`;
                            return html;
                        }
                    }
                ]
            });
        });


        function destroy(id) {
            if (confirm('Yakin ingin menghapus?')) {
                $.ajax({
                    url: '/pelanggan/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        alert('Pelanggan berhasil dihapus!');
                        $('#pelanggan-table').DataTable().ajax.reload();
                    },
                    error: function () {
                        alert('Gagal menghapus Pelanggan!');
                    }
                });
            }
        }
    </script>
@endpush
