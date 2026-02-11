@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Edit User</h2>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
        </div>
        <div class="mb-3">
            <label>Password (Kosongkan jika tidak ingin di ubah)</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" >
                <button type="button" class="btn" onclick="togglePassword('password', 'togglePasswordIcon1')">
                    <i id="togglePasswordIcon1" class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        
        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" >
                <button type="button" class="btn" onclick="togglePassword('password_confirmation', 'togglePasswordIcon2')">
                    <i id="togglePasswordIcon2" class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
            </select>
        </div>
        <button type="submit"class="btn btn-icon icon-left btn-success"><i class="fas fa-check"></i> Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-icon icon-left btn-light"><i class="fas fa-times"></i> Batal</a>
    </form>
</div>

<script>
        function togglePassword(inputId, iconId) {
            let passwordField = document.getElementById(inputId);
            let icon = document.getElementById(iconId);
    
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Alert untuk error
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}'
        });
    @endif
</script>
@endsection
