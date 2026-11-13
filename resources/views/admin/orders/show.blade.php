@extends('layouts.admin')
@section('title', $order->code)

@section('content')
<h1>{{ $order->code }}</h1>
<div class="grid">
    <div class="card">
        <h3>Pelanggan</h3>
        <p>{{ $order->user->name }}<br>{{ $order->recipient_name }}<br>{{ $order->phone }}</p>
        <p>{{ $order->address }}</p>
    </div>
    <div class="card">
        <h3>Pengiriman</h3>
        <p>{{ $order->shipping_courier }} - {{ $order->shipping_service }}<br>{{ $order->shipping_eta }}</p>
        <p>Status: <strong>{{ strtoupper($order->status) }}</strong></p>
    </div>
</div>

<div class="card">
    <div class="table-scroll">
        <table>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>Rp{{ number_format($item->price, 2, ',', '.') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp{{ number_format($item->subtotal, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <p>Subtotal: Rp{{ number_format($order->subtotal, 2, ',', '.') }}</p>
    <p>Ongkir: Rp{{ number_format($order->shipping_cost, 2, ',', '.') }}</p>
    <h3>Total: Rp{{ number_format($order->grand_total, 2, ',', '.') }}</h3>
</div>

<div class="card">
    <h3>Aksi Admin</h3>
    @if($order->status === 'pending')
        <form style="display:inline" method="POST" action="{{ route('admin.orders.confirm', $order) }}">
            @csrf
            @method('PATCH')
            <button class="btn">Validasi Pesanan</button>
        </form>
    @endif

    @if(in_array($order->status, ['pending', 'confirmed']))
        <form style="display:inline" data-confirm="Batalkan pesanan dan kembalikan stok?" method="POST" action="{{ route('admin.orders.cancel', $order) }}">
            @csrf
            @method('PATCH')
            <button class="btn btn-danger">Batalkan &amp; Kembalikan Stok</button>
        </form>
    @endif

    @if(in_array($order->status, ['confirmed', 'processed', 'shipped']))
        <form class="row" method="POST" action="{{ route('admin.orders.status', $order) }}">
            @csrf
            @method('PATCH')
            <select name="status">
                @if($order->status === 'confirmed')
                    <option value="processed">Processed</option>
                @elseif($order->status === 'processed')
                    <option value="shipped">Shipped</option>
                @elseif($order->status === 'shipped')
                    <option value="completed">Completed</option>
                @endif
            </select>
            <button class="btn">Update Status</button>
        </form>
    @endif
</div>
@endsection
