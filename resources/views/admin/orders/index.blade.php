@extends('layouts.admin')
@section('title', 'Transaksi')

@section('content')
<h1>Transaksi</h1>
<div class="card">
    <form class="row" method="GET">
        <input class="input" style="max-width:280px" name="q" value="{{ request('q') }}" placeholder="Kode / pelanggan">
        <select name="status">
            <option value="">Semua status</option>
            @foreach(['pending', 'confirmed', 'processed', 'shipped', 'completed', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button class="btn">Filter</button>
    </form>
</div>

<div class="card">
    <div class="table-scroll">
        <table>
            <tr>
                <th>Kode</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th></th>
            </tr>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->code }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->ordered_at->format('d-m-Y H:i') }}</td>
                <td>Rp{{ number_format($order->grand_total, 2, ',', '.') }}</td>
                <td>{{ strtoupper($order->status) }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}">Detail</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    {{ $orders->links() }}
</div>
@endsection
