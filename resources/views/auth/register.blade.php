@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="card auth-card">
    <span class="eyebrow">MULAI DARI SINI</span>
    <h1>Buat akun belanja</h1>
    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <label>Nama lengkap
            <input name="name" value="{{ old('name') }}" maxlength="120" autocomplete="name" required>
        </label>
        <label>Email
            <input type="email" name="email" value="{{ old('email') }}" autocomplete="username" required>
        </label>
        <label>Password
            <input type="password" name="password" minlength="8" autocomplete="new-password" required>
            <span class="muted">Minimal 8 karakter.</span>
        </label>
        <label>Ulangi password
            <input type="password" name="password_confirmation" autocomplete="new-password" required>
        </label>
        <button class="btn">Buat Akun</button>
    </form>
    <p class="muted" style="margin-top:20px">Sudah punya akun? <a href="{{ route('login') }}"><strong>Masuk</strong></a></p>
</div>
@endsection
