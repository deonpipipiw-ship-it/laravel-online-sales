@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="card">
    <h1>Selamat Datang di Ruang Belanja</h1>
    <p>Silakan <a href="{{ route('login') }}">Masuk</a> atau <a href="{{ route('register') }}">Daftar</a> untuk mulai berbelanja.</p>
</div>
@endsection
