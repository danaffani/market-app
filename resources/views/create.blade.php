@extends('layouts.app')

@section('content')
<h1>Tambah Barang</h1>
<form action="{{ route('items.store') }}" method="POST">
    @csrf
    <label for="name">Nama Barang:</label>
    <input type="text" id="name" name="name" required>

    <label for="price">Harga Satuan:</label>
    <input type="number" id="price" name="price" required>

    <label for="available_amount">Jumlah Barang:</label>
    <input type="number" id="available_amount" name="available_amount" required>

    <button type="submit">Tambah</button>
</form>
@endsection