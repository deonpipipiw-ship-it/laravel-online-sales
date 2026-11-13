@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="card">
    <h1>Edit Produk</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label>Kategori
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
        <label>SKU
            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required>
        </label>
        <label>Nama Produk
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
        </label>
        <label>Deskripsi
            <textarea name="description">{{ old('description', $product->description) }}</textarea>
        </label>
        <label>Harga (Rp)
            <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0">
        </label>
        <label>Stok
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
        </label>
        <label>Gambar Produk Saat Ini
            @if($product->image)
                <br><img src="{{ asset('storage/' . $product->image) }}" width="100"><br>
            @else
                <span> (Belum ada gambar)</span><br>
            @endif
            <input type="file" name="image" accept="image/*">
        </label>
        <label>
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}> Aktifkan Produk
        </label>
        <button class="btn" type="submit">Perbarui Produk</button>
        <a href="{{ route('admin.products.index') }}">Batal</a>
    </form>
</div>
@endsection
