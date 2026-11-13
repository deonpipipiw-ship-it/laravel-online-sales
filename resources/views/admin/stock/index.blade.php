@extends('layouts.admin')
@section('title', 'Stok')

@section('content')
<div class="row" style="justify-content:space-between">
    <h1>Histori Stok</h1>
    <a class="btn" href="{{ route('admin.stock.create') }}">Barang Masuk</a>
</div>

<div class="card">
    <form class="row" method="GET">
        <label>Produk
            <select name="product_id">
                <option value="">Semua</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>{{ $product->name }}</option>
                @endforeach
            </select>
        </label>
        <label>Tipe
            <select name="type">
                <option value="">Semua</option>
                <option value="IN" @selected(request('type') === 'IN')>IN</option>
                <option value="OUT" @selected(request('type') === 'OUT')>OUT</option>
            </select>
        </label>
        <button class="btn">Filter</button>
    </form>
</div>

<div class="card">
    <div class="table-scroll">
        <table>
            <tr>
                <th>Waktu</th>
                <th>Produk</th>
                <th>Tipe</th>
                <th>Qty</th>
                <th>Referensi</th>
                <th>User</th>
            </tr>
            @foreach($movements as $movement)
            <tr>
                <td>{{ $movement->movement_at->format('d-m-Y H:i') }}</td>
                <td>{{ $movement->product->name }}</td>
                <td>{{ $movement->type }}</td>
                <td>{{ $movement->quantity }}</td>
                <td>{{ $movement->reference }}</td>
                <td>{{ $movement->user?->name }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    {{ $movements->links() }}
</div>
@endsection
