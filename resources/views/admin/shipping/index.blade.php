@extends('layouts.admin')
@section('title', 'Ekspedisi')

@section('content')
<h1>Layanan Ekspedisi</h1>
<div class="card">
    <form method="POST" action="{{ route('admin.shipping.store') }}">
        @csrf
        <div class="row">
            <label>Kurir
                <input class="input" name="courier" required>
            </label>
            <label>Layanan
                <input class="input" name="service" required>
            </label>
            <label>Estimasi
                <input class="input" name="eta">
            </label>
            <label>Biaya
                <input class="input" type="number" step="0.01" name="cost" min="0" required>
            </label>
            <label>
                <input type="checkbox" name="is_active" value="1" checked> Aktif
            </label>
            <button class="btn">Tambah</button>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-scroll">
        <table>
            <tr>
                <th>Kurir</th>
                <th>Layanan</th>
                <th>ETA</th>
                <th>Biaya</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->courier }}</td>
                <td>{{ $service->service }}</td>
                <td>{{ $service->eta }}</td>
                <td>Rp{{ number_format($service->cost, 2, ',', '.') }}</td>
                <td>{{ $service->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                <td>
                    <details>
                        <summary>Ubah layanan</summary>
                        <form style="display:block;min-width:260px" method="POST" action="{{ route('admin.shipping.update', $service) }}">
                            @csrf
                            @method('PUT')
                            <label>Kurir <input name="courier" value="{{ $service->courier }}" required></label>
                            <label>Layanan <input name="service" value="{{ $service->service }}" required></label>
                            <label>Estimasi <input name="eta" value="{{ $service->eta }}"></label>
                            <label>Biaya <input name="cost" type="number" min="0" step="0.01" value="{{ $service->cost }}" required></label>
                            <label><input type="checkbox" name="is_active" value="1" @checked($service->is_active)> Aktif</label>
                            <button class="btn">Simpan Perubahan</button>
                        </form>
                    </details>
                    <form method="POST" action="{{ route('admin.shipping.destroy', $service) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Nonaktifkan</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
