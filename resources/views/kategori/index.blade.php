@extends('layouts.main')

@section(section: 'title', content: 'Management Kategori')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-3">
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                        Tambah Kategori
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped w-100" id="kategori-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode Kategori</th>
                                <th>Nama Kategori</th>
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
        $(function () {
            $('#kategori-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'kode_kategori', name: 'kode_kategori' },
                    { data: 'nama_kategori', name: 'nama_kategori' },
                    {
                        data: 'id',
                        name: '_',
                        orderable: false,
                        searchable: false,
                        class: 'text-right nowrap',
                        render: function (data, type, row) {
                            return `
                                <a href="/kategori/${data}" class="btn btn-info btn-icon mr-2" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="/kategori/${data}/edit" class="btn btn-warning btn-icon mr-2" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="destroy(${data})" class="btn btn-danger btn-icon mr-2" title="Hapus">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            `;
                        }
                    }
                ]
            });
        });

        function destroy(id) {
            if (confirm('Yakin ingin menghapus?')) {
                $.ajax({
                    url: '/kategori/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        alert('Kategori berhasil dihapus!');
                        $('#kategori-table').DataTable().ajax.reload();
                    },
                    error: function () {
                        alert('Gagal menghapus kategori!');
                    }
                });
            }
        }
    </script>
@endpush