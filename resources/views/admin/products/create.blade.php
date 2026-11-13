@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="card">
    <h1>Tambah Produk Baru</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <label>Kategori
            <select name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
        <label>SKU
            <input type="text" name="sku" value="{{ old('sku') }}" required>
        </label>
        <label>Nama Produk
            <input type="text" name="name" value="{{ old('name') }}" required>
        </label>
        <label>Deskripsi
            <textarea name="description">{{ old('description') }}</textarea>
        </label>
        <label>Harga (Rp)
            <input type="number" name="price" value="{{ old('price') }}" required min="0">
        </label>
        <label>Stok
            <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0">
        </label>
        <label>Gambar Produk
            <input type="file" name="image" accept="image/*">
        </label>
        <label>
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}> Aktifkan Produk
        </label>
        <button class="btn" type="submit">Simpan Produk</button>
        <a href="{{ route('admin.products.index') }}">Batal</a>
    </form>
</div>
@endsection
