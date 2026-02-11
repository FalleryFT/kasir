@extends('layouts.main')

@section(section: 'title', content: 'Management Diskon')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-3">
                    <a href="{{ route('diskon.create') }}" class="btn btn-primary">
                        Tambah Diskon
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped w-100" id="diskon-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produk</th>
                                <th>Diskon (%)</th>
                                <th>Berlaku Sampai</th>
                                <th>Status</th>
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
        $('#diskon-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '',
            columns: [
                { data: 'diskonid', name: 'diskonid' },
                { data: 'produk.nama_produk', name: 'produk.nama_produk', defaultContent: 'Produk tidak ditemukan' },
                { data: 'diskon', name: 'diskon' },
                { data: 'berlaku_sampai', name: 'berlaku_sampai' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                {
                    data: 'diskonid',
                    name: '_',
                    orderable: false,
                    searchable: false,
                    class: 'text-right nowrap',
                    render: function (data, type, row) {
                        return `
                            <a href="/diskon/${data}" class="btn btn-info btn-icon mr-2" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/diskon/${data}/edit" class="btn btn-warning btn-icon mr-2" title="Edit">
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
                url: '/diskon/' + id,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    alert('Diskon berhasil dihapus!');
                    $('#diskon-table').DataTable().ajax.reload();
                },
                error: function () {
                    alert('Gagal menghapus diskon!');
                }
            });
        }
    }
</script>
@endpush
