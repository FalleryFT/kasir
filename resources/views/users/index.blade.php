@extends('layouts.main')

@section(section: 'title', content: 'Management Users')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-3">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        Tambah User
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped w-100" id="table-users">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
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
            dataTable = $('#table-users').DataTable({
                processing: true,
                serverSide: true,
                ajax: '',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'email', name: 'email' },
                    { data: 'username', name: 'username' },
                    { data: 'role', name: 'role' },
                    {
                        data: 'id', name: '_', orderable: false, searchable: false, class: 'text-right nowrap',
                        render: function (data, type, row) {
                            let html;
                            html = `<a href="/users/${data}" class="btn btn-info btn-icon mr-2" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>`;
                            html += `<a href="/users/${data}/edit" class="btn btn-warning btn-icon mr-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>`;
                            html += `<button onclick="destroy(${data})" class="btn btn-danger btn-icon mr-2" title="Hapus">
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
                    url: '/users/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        alert('User berhasil dihapus!');
                        $('#users-table').DataTable().ajax.reload();
                    },
                    error: function () {
                        alert('Gagal menghapus User!');
                    }
                });
            }
        }
    </script>
@endpush
