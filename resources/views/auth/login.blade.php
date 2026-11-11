@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="card auth-card">
    <span class="eyebrow">SELAMAT DATANG KEMBALI</span>
    <h1>Masuk ke akunmu</h1>
    <p class="muted" style="text-align:left">Lanjutkan belanja dan pantau pesanan dengan mudah.</p>
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <label>Email
            <input type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
        </label>
        <label>Password
            <input type="password" name="password" autocomplete="current-password" required>
        </label>
        <button class="btn">Masuk</button>
    </form>
    <p class="muted" style="margin-top:20px">Belum punya akun? <a href="{{ route('register') }}"><strong>Daftar di sini</strong></a></p>
</div>
@endsection
