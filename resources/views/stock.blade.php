@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Stok Barang</h1>
    <table class="table table-striped table-bordered">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nama Item</th>
                <th>Jumlah Tersedia</th>
                <th>Jumlah Terjual</th>
                <th>Harga Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->available_amount }}</td>
                <td>{{ $item->sold_amount }}</td>
                <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Del</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('items.create') }}" class="btn btn-success mb-3">Tambah Barang</a>
</div>
@endsection