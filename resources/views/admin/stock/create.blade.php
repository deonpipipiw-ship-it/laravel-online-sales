@extends('layouts.admin')
@section('title', 'Barang Masuk')

@section('content')
<h1>Barang Masuk / Penyetokan</h1>
<div class="card">
    <form method="POST" action="{{ route('admin.stock.store') }}">
        @csrf
        <label>Produk
            <select name="product_id" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->sku }} - {{ $product->name }} (stok {{ $product->stock }})</option>
                @endforeach
            </select>
        </label>
        <label>Jumlah
            <input class="input" type="number" min="1" name="quantity" required>
        </label>
        <label>Harga Beli per Unit
            <input class="input" type="number" min="0" step="0.01" name="unit_cost">
        </label>
        <label>Referensi / No. Faktur
            <input class="input" name="reference">
        </label>
        <label>Tanggal Masuk
            <input class="input" type="datetime-local" name="movement_at" value="{{ now()->format('Y-m-d\TH:i') }}" required>
        </label>
        <label>Catatan
            <textarea class="input" name="note"></textarea>
        </label>
        <button class="btn">Simpan Barang Masuk</button>
    </form>
</div>
@endsection
