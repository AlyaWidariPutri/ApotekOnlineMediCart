@extends('fe.master')

@push('styles')
<style>
    /* Cart Page Styles */
    .cart-section {
        padding: 80px 0;
    }
    
    .cart-table-wrap {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .cart-table th {
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #eee;
        font-weight: 600;
    }
    
    .cart-table td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #eee;
    }
    
    .product-image img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .product-remove button {
        background: none;
        border: none;
        color: #ff6b6b;
        font-size: 1.2rem;
        cursor: pointer;
    }
    
    .product-quantity input {
        width: 60px;
        padding: 8px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .total-section {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .total-table {
        width: 100%;
        margin-bottom: 20px;
    }
    
    .total-table td {
        padding: 10px 0;
    }
    
    .total-table tr:last-child td {
        font-weight: 600;
        font-size: 1.1rem;
        color: #F28123;
    }
    
    .cart-buttons {
        display: flex;
        gap: 8px;
        margin-top: 20px;
    }
    
    .boxed-btn {
        display: inline-block;
        padding: 12px 25px;
        background: #F28123;
        color: #fff;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        text-align: center;
        flex: 1;
    }
    
    .boxed-btn:hover {
        background: #051922;
        transform: translateY(-3px);
    }
    
    .boxed-btn.black {
        background: #051922;
    }
    
    .boxed-btn.black:hover {
        background: #F28123;
    }
    
    .empty-cart {
        text-align: center;
        padding: 50px 0;
    }
    
    .empty-cart i {
        font-size: 5rem;
        color: #F28123;
        margin-bottom: 20px;
    }
    
    .empty-cart h3 {
        margin-bottom: 15px;
    }
    
    .empty-cart p {
        margin-bottom: 25px;
        color: #666;
    }
</style>
@endpush

@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Always Healthy Pharmacy</p>
                    <h1>Shopping Cart</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- cart -->
<div class="cart-section mt-150 mb-150">
    <div class="container">
        @if($keranjang->count() > 0)
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th class="product-remove"></th>
                                <th class="product-image">Product</th>
                                <th class="product-name">Medicine Name</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keranjang as $item)
                            <tr>
                                <td class="product-remove">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                                <td class="product-image">
                                    <img src="{{ asset($item->obat->foto1 ? 'storage/'.$item->obat->foto1 : 'assets/fe/img/products/default.jpg') }}" alt="{{ $item->obat->nama_obat }}">
                                </td>
                                <td class="product-name">{{ $item->obat->nama_obat }}</td>
                                <td class="product-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="product-quantity">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" 
                                               name="jumlah_order" 
                                               value="{{ $item->jumlah_order }}" 
                                               min="1" 
                                               max="{{ $item->obat->stok }}"
                                               onchange="this.form.submit()">
                                    </form>
                                    <small class="text-muted">Stock: {{ $item->obat->stok }}</small>
                                </td>
                                <td class="product-total">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="total-section">
                    <table class="total-table">
                        <thead>
                            <tr>
                                <th>Order Summary</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Subtotal: </strong></td>
                                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                            {{-- <tr>
                                <td><strong>Shipping Fee: </strong></td>
                                <td>Rp 0</td>
                            </tr> --}}
                            <tr>
                                <td><strong>Total: </strong></td>
                                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="cart-buttons">
                        <a href="{{ route('shop.index') }}" class="boxed-btn">Continue Shopping</a>
                        <a href="{{ route('checkout.index') }}" class="boxed-btn black">Checkout your Cart</a>
                    </div>
                    
                    <!-- Stock Validation -->
                    @if($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3>Your Cart is Empty</h3>
            <p>You haven't added any products to your cart yet</p>
            <a href="{{ route('shop.index') }}" class="boxed-btn">Start Shopping</a>
        </div>
        @endif
    </div>
</div>
<!-- end cart -->
@endsection