@extends('layouts.app')

@section('content')
<h1>Edit Barang</h1>
<form action="{{ route('items.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="name">Nama Barang:</label>
    <input type="text" id="name" name="name" value="{{ $item->name }}" required>

    <label for="price">Harga Satuan:</label>
    <input type="number" id="price" name="price" value="{{ number_format($item->price, 0, ',', '.') }}" required>

    <label for="available_amount">Jumlah Barang:</label>
    <input type="number" id="available_amount" name="available_amount" value="{{ $item->available_amount }}" required>

    <button type="submit">Update</button>
</form>
@endsection