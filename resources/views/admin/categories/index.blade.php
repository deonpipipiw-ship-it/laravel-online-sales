@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="card">
    <h1>Kelola Kategori</h1>

    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.categories.store') }}" style="margin-bottom: 20px;">
        @csrf
        <label>Nama Kategori Baru
            <input type="text" name="name" required placeholder="Contoh: Pakaian, Elektronik">
        </label>
        <button class="btn" type="submit">Tambah Kategori</button>
    </form>

    <table border="1" cellpadding="8" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Slug</th>
                <th>Jumlah Produk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display:inline;" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:red;">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
