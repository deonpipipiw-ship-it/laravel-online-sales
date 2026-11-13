@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="card">
    <h1>Dashboard Admin</h1>
    <p>Selamat datang di panel kelola toko online.</p>
    <div style="display:flex; gap:10px; margin-top:20px; flex-wrap:wrap;">
        <a class="btn" href="{{ route('admin.categories.index') }}">Kelola Kategori</a>
        <a class="btn" href="{{ route('admin.products.index') }}">Kelola Produk</a>
        <a class="btn" href="{{ route('admin.stock.index') }}">Stok &amp; Barang Masuk</a>
        <a class="btn" href="{{ route('admin.shipping.index') }}">Kelola Ekspedisi</a>
    </div>
</div>
@endsection
