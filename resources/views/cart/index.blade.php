@extends('layouts.app')
@section('title', 'Keranjang')

@section('content')
<h1>Keranjang</h1>

@if($items->isEmpty())
    <div class="card">
        Keranjang kosong. <a href="{{ route('shop.index') }}">Belanja sekarang.</a>
    </div>
@else
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item['product']->name }}</td>
                    <td>Rp{{ number_format($item['product']->price, 2, ',', '.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.update', $item['product']) }}">
                            @csrf
                            @method('PATCH')
                            <input style="width:70px" type="number" name="quantity" min="1" max="{{ $item['product']->stock }}" value="{{ $item['quantity'] }}">
                            <button>Update</button>
                        </form>
                    </td>
                    <td>Rp{{ number_format($item['lineTotal'], 2, ',', '.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.destroy', $item['product']) }}">
                            @csrf
                            @method('DELETE')
                            <button>Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card" style="margin-top:18px">
        <h3>Subtotal: Rp{{ number_format($subtotal, 2, ',', '.') }}</h3>
        @if(Route::has('checkout.index'))
            <a class="btn" href="{{ route('checkout.index') }}">Lanjut Checkout</a>
        @endif
    </div>
@endif
@endsection
