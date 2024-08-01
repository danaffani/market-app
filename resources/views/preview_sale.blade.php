@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Preview Penjualan</h1>

    <h2>Keranjang:</h2>
    <table class="table table-striped table-bordered mb-4">
        <thead class="thead-light">
            <tr>
                <th>Nama Item</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="cart-body">
            <!-- Cart items will be dynamically added here -->
        </tbody>
    </table>
    <h3 id="total-label">Total: 0</h3>
    <button id="sell-button" class="btn btn-primary" onclick="completeSale()">Jual</button>

    <h2>List Barang:</h2>
    <table id="preview" class="table table-striped table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Nama Item</th>
                <th>Jumlah Tersedia</th>
                <th>Atur Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->available_amount }}</td>
                <td>
                    <div class="input-group">
                        <button class="btn btn-secondary btn-sm"
                            onclick="decreaseQuantity(this)"
                            onmousedown="startDecrease(this)" 
                            onmouseup="stopChange()" 
                            onmouseleave="stopChange()">-</button>
                        <span class="quantity-display mx-2" data-id="{{ $item->id }}" data-price="{{ $item->price }}">0</span>
                        <button class="btn btn-secondary btn-sm"
                            onclick="increaseQuantity(this)"
                            onmousedown="startIncrease(this)" 
                            onmouseup="stopChange()" 
                            onmouseleave="stopChange()">+</button>
                    </div>
                </td>
                <td>
                    <button onclick="addToCart('{{ $item->name }}', this)" class="btn btn-primary btn-sm">Tambah ke Keranjang</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function addToCart(itemName, button) {
    const quantityDisplay = button.closest('tr').querySelector('.quantity-display');
    const quantity = parseInt(quantityDisplay.innerText);
    const price = parseFloat(quantityDisplay.dataset.price);

    if (quantity > 0) {
        const cartBody = document.getElementById('cart-body');
        let existingRow = Array.from(cartBody.rows).find(row => row.cells[0].innerText === itemName);

        if (existingRow) {
            // Update the quantity and subtotal if the item already exists in the cart
            const currentQuantity = parseInt(existingRow.cells[1].innerText);
            existingRow.cells[1].innerText = currentQuantity + quantity;
            const newSubtotal = (currentQuantity + quantity) * price;
            existingRow.cells[3].innerText = newSubtotal.toFixed(2);
        } else {
            // Add new row if the item does not exist in the cart
            const newRow = document.createElement('tr');
            const subtotal = quantity * price;
            newRow.innerHTML = `
                <td data-id="${quantityDisplay.dataset.id}">${itemName}</td>
                <td>${quantity}</td>
                <td>${price.toFixed(2)}</td>
                <td>${subtotal.toFixed(2)}</td>
                <td><button onclick="removeFromCart(this)" class="btn btn-danger btn-sm">Remove</button></td>
            `;
            cartBody.appendChild(newRow);
        }
        quantityDisplay.innerText = 0; // Reset quantity display
        updateTotal();
    } else {
        alert('Please select a quantity greater than 0.');
    }
}

function removeFromCart(button) {
    const row = button.closest('tr');
    row.remove();
    updateTotal();
}

function updateTotal() {
    const cartBody = document.getElementById('cart-body');
    let total = 0;
    Array.from(cartBody.rows).forEach(row => {
        const subtotal = parseFloat(row.cells[3].innerText);
        total += subtotal;
    });
    document.getElementById('total-label').innerText = `Total: ${total.toFixed(2)}`;
}

function completeSale() {
    const cartBody = document.getElementById('cart-body');
    const sales = [];

    Array.from(cartBody.rows).forEach(row => {
        const itemId = row.cells[0].dataset.id; // Get the item ID from the data attribute
        const quantity = parseInt(row.cells[1].innerText);

        sales.push({ id: itemId, quantity: quantity });
    });

    // Send the sales data to the server
    fetch('/sales/complete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ sales: sales })
    })
    .then(response => {
        if (response.ok) {
            window.location.reload(); // Refresh the page after successful sale
        } else {
            alert('Error completing sale');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

let interval; // Variable to hold the interval ID

function increaseQuantity(button) {
    const quantityDisplay = button.parentElement.querySelector('.quantity-display');
    const availableAmount = parseInt(button.closest('tr').cells[1].innerText); // Get available amount
    let currentQuantity = parseInt(quantityDisplay.innerText);
    
    if (currentQuantity < availableAmount) {
        currentQuantity++;
        quantityDisplay.innerText = currentQuantity;
    }
}

function decreaseQuantity(button) {
    const quantityDisplay = button.parentElement.querySelector('.quantity-display');
    let currentQuantity = parseInt(quantityDisplay.innerText);
    
    if (currentQuantity > 0) {
        currentQuantity--;
        quantityDisplay.innerText = currentQuantity;
    }
}

// Function to start increasing quantity
function startIncrease(button) {
    interval = setInterval(() => {
        increaseQuantity(button);
    }, 100); // Adjust the speed by changing the interval (in milliseconds)
}

// Function to start decreasing quantity
function startDecrease(button) {
    interval = setInterval(() => {
        decreaseQuantity(button);
    }, 100); // Adjust the speed by changing the interval (in milliseconds)
}

// Function to stop the interval
function stopChange() {
    clearInterval(interval);
}
</script>
@endsection