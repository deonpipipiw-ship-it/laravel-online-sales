@extends('layouts.app')
@section('title', 'Pilihan untuk keseharian')

@section('content')
<section class="hero">
    <div>
        <span class="eyebrow">PILIHAN UNTUK KESEHARIAN</span>
        <h1>Hal kecil yang bikin<br>harimu lebih nyaman.</h1>
        <p>Temukan kebutuhan rumah, aksesori, dan elektronik pilihan. Harga jelas, stok tersedia, siap menemani aktivitasmu.</p>
        <div class="hero-bottom">
            <span>Informasi stok langsung</span>
            <span>Pilihan ekspedisi</span>
            <span>Riwayat pesanan lengkap</span>
        </div>
    </div>
    <div class="hero-art" aria-hidden="true"></div>
</section>

<div class="section-heading">
    <h2>Temukan pilihanmu</h2>
    <span class="muted">{{ $products->total() }} produk ditemukan</span>
</div>

<div class="card filters">
    <form method="GET">
        <div class="row">
            <label style="flex:2">Cari produk
                <input name="q" value="{{ request('q') }}" placeholder="Nama produk atau SKU">
            </label>
            <label>Kategori
                <select name="category">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>
            <label>Urutkan
                <select name="sort">
                    <option value="">Terbaru</option>
                    @foreach(['price_asc' => 'Harga termurah', 'price_desc' => 'Harga termahal', 'name' => 'Nama A-Z'] as $value => $label)
                        <option value="{{ $value }}" @selected(request('sort') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
        </div>
        <div class="row">
            <label>Harga minimum
                <input type="number" min="0" step="0.01" name="min_price" value="{{ request('min_price') }}" placeholder="Rp 0">
            </label>
            <label>Harga maksimum
                <input type="number" min="0" step="0.01" name="max_price" value="{{ request('max_price') }}" placeholder="Tanpa batas">
            </label>
            <label>
                <input type="checkbox" name="ready" value="1" @checked(request('ready'))> Stok tersedia
            </label>
            <div class="filter-actions">
                <button class="btn">Terapkan Filter</button>
                <a class="search-reset" href="{{ route('shop.index') }}">Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="grid product-grid">
    @forelse($products as $product)
        <article class="card product-card">
            <a href="{{ route('shop.show', $product->slug) }}">
                @if($product->image)
                    <img class="thumb" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                @else
                    <div class="thumb product-placeholder" aria-hidden="true"></div>
                @endif
            </a>
            <div class="product-info">
                <span class="muted">{{ $product->category->name }}</span>
                <h3><a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a></h3>
                <p class="price">Rp{{ number_format($product->price, 2, ',', '.') }}</p>
                <p class="stock {{ $product->stock === 0 ? 'empty' : '' }}">
                    {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Stok habis' }}
                </p>
                <a class="btn btn-light" href="{{ route('shop.show', $product->slug) }}">Lihat Produk</a>
            </div>
        </article>
    @empty
        <div class="empty-state">
            <h3>Belum ada produk yang cocok</h3>
            <p class="muted">Coba kata kunci lain atau reset filter pencarian.</p>
            <a class="btn-light" href="{{ route('shop.index') }}">Lihat semua produk</a>
        </div>
    @endforelse
</div>

{{ $products->links() }}
@endsection
