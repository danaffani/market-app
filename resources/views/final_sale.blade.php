@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Final Penjualan</h1>
    <table class="table table-striped table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Nama Item</th>
                <th>Jumlah Dijual</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->item->name }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ $sale->item->price }}</td>
                <td>{{ $sale->total_price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h2>Total: {{ $total }}</h2>
    <form action="{{ route('sales.complete') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Jual</button>
    </form>
    <a href="{{ route('preview_sale') }}" class="btn btn-secondary">Back</a>
</div>
@endsection