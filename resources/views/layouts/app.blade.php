<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Belanja kebutuhan sehari-hari dengan pilihan produk, stok yang jelas, dan pengiriman yang mudah.">
    <title>@yield('title', 'Katalog') - Ruang Belanja</title>
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
</head>
<body>
    <div class="top-note">Pilihan sederhana. Belanja lebih nyaman.</div>
    <header class="site-header">
        <nav class="container nav" aria-label="Navigasi utama">
            <a class="brand" href="{{ route('shop.index') }}">
                <span class="brand-mark" aria-hidden="true"></span>ruangbelanja <span style="color:#7aa487">.</span>
            </a>
            <a href="{{ route('shop.index') }}" @if(request()->routeIs('shop.*')) aria-current="page" @endif>Jelajahi Produk</a>
            @auth
                @if(Route::has('cart.index'))
                    <a href="{{ route('cart.index') }}" @if(request()->routeIs('cart.*')) aria-current="page" @endif>Keranjang ({{ array_sum(session('cart', [])) }})</a>
                @endif
                @if(Route::has('orders.index'))
                    <a href="{{ route('orders.index') }}" @if(request()->routeIs('orders.*')) aria-current="page" @endif>Pesanan</a>
                @endif
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                @endif
                <span class="account">Halo, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button class="btn-light">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}">Masuk</a>
                <a class="btn" href="{{ route('register') }}">Daftar</a>
            @endauth
        </nav>
    </header>
    <main class="container">
        @yield('content')
    </main>
    <footer class="container footer">
        <strong>ruangbelanja.</strong>
        <span>Proyek praktikum Laravel - Admin & Pelanggan</span>
        <span>Belanja dengan informasi yang jelas.</span>
    </footer>
    <script src="{{ asset('js/store.js') }}" defer></script>
</body>
</html>