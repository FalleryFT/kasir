@extends('layouts.main')

@section('content')
<div class="container col-8 p-2 rounded">
    <h2>Detail Pengguna</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Username</th>
            <td>{{ $user->username }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ $user->role }}</td>
        </tr>
        <tr>
            <th>Dibuat Oleh</th>
            <td>{{ $user->created_by ?? '-' }}</td>
        </tr>
        <tr>
            <th>Diupdate Oleh</th>
            <td>{{ $user->updated_by ?? '-' }}</td>
        </tr>
        <tr>
            <th>Dibuat Pada</th>
            <td>{{ $user->created_at }}</td>
        </tr>
        <tr>
            <th>Diupdate Pada</th>
            <td>{{ $user->updated_at }}</td>
        </tr>
    </table>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
