@extends('fe.master')

@section('title', $product->nama_obat)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('assets/fe/css/product-detail.css') }}">
<style>
    /* Fix untuk navbar fixed */
    body {
        padding-top: 80px;
        background-color: #f5f5f5;
    }
    
    /* Product Detail Main Section */
    .single-product {
        padding: 40px 0 60px;
    }
    
    .product-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    /* ========== BACK BUTTON MODERN & CLEAN ========== */
    .back-nav {
        margin-bottom: 20px;
    }
    
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: transparent;
        border: none;
        padding: 10px 0;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        color: #666;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .back-button i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }
    
    .back-button span {
        position: relative;
    }
    
    .back-button span::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: #F28123;
        transition: width 0.3s ease;
    }
    
    .back-button:hover {
        color: #F28123;
    }
    
    .back-button:hover i {
        transform: translateX(-4px);
    }
    
    .back-button:hover span::after {
        width: 100%;
    }
    
    /* ========== IMAGE SLIDER STYLES ========== */
    .product-gallery {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background: #f5f5f5;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .swiper {
        width: 100%;
        height: 100%;
    }
    
    .product-swiper {
        width: 100%;
        height: 100%;
    }
    
    .product-swiper .swiper-slide {
        text-align: center;
        background: #f8f8f8;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .product-swiper .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
    }
    
    /* Navigation Buttons */
    .swiper-button-next,
    .swiper-button-prev {
        background: rgba(255,255,255,0.9);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        color: #F28123;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 16px;
        font-weight: bold;
    }
    
    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background: #F28123;
        color: white;
    }
    
    /* Pagination Dots */
    .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        background: #ddd;
        opacity: 1;
    }
    
    .swiper-pagination-bullet-active {
        background: #F28123;
        width: 20px;
        border-radius: 4px;
    }
    
    /* Single Image (no slide) */
    .single-product-img {
        text-align: center;
        background: #f8f8f8;
        border-radius: 16px;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .single-product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* ========== PRODUCT INFO STYLES ========== */
    .product-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
        line-height: 1.3;
    }
    
    /* Category Badge WITH IMAGE */
    .category-info {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f0f0f0;
        padding: 5px 12px 5px 8px;
        border-radius: 30px;
        font-size: 0.8rem;
        color: #555;
        margin-bottom: 15px;
    }
    
    .category-img {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .category-name {
        font-weight: 500;
    }
    
    /* Prescription Badge */
    .prescription-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff3e0;
        color: #e65100;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        margin-left: 10px;
    }
    
    /* Price Section - Highlighted */
    .price-section {
        margin: 20px 0;
        padding: 12px 0;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }
    
    .price-label {
        font-size: 0.8rem;
        color: #888;
        margin-bottom: 4px;
        letter-spacing: 0.5px;
    }
    
    .product-price-wrapper {
        display: flex;
        align-items: baseline;
        gap: 4px;
        flex-wrap: wrap;
    }
    
    .currency-symbol {
        font-size: 1.1rem;
        font-weight: 600;
        color: #F28123;
    }
    
    .product-price-large {
        font-size: 2rem;
        font-weight: 800;
        color: #F28123;
        line-height: 1;
    }
    
    .price-unit {
        font-size: 0.75rem;
        color: #999;
        margin-left: 4px;
    }
    
    /* ========== WEIGHT SECTION - NEW & ATTRACTIVE ========== */
    .weight-section {
        margin: 15px 0;
        padding: 12px 16px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .weight-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .weight-icon {
        width: 48px;
        height: 48px;
        background: #F28123;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        box-shadow: 0 4px 12px rgba(242, 129, 35, 0.3);
    }
    
    .weight-details {
        display: flex;
        flex-direction: column;
    }
    
    .weight-label {
        font-size: 0.7rem;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .weight-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        line-height: 1.2;
    }
    
    .weight-value span {
        font-size: 0.8rem;
        font-weight: 400;
        color: #888;
    }
    
    .weight-badge {
        background: white;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #F28123;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    
    .weight-badge i {
        margin-right: 5px;
    }
    
    /* Info Cards Grid */
    .info-cards {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin: 20px 0;
    }
    
    .info-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 12px;
        text-align: center;
        transition: all 0.3s;
    }
    
    .info-card:hover {
        transform: translateY(-3px);
        background: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .info-card i {
        font-size: 1.3rem;
        color: #F28123;
        margin-bottom: 8px;
        display: block;
    }
    
    .info-card .info-label {
        font-size: 0.7rem;
        color: #888;
        margin-bottom: 4px;
    }
    
    .info-card .info-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
    }
    
    /* Stock Info */
    .stock-info {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 12px 0;
        font-size: 0.85rem;
    }
    
    .stock-badge {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
    }
    
    .stock-badge.low-stock {
        background: #fff3e0;
        color: #e65100;
    }
    
    /* Product Description */
    .product-description {
        margin: 20px 0;
        line-height: 1.6;
        color: #555;
        font-size: 0.88rem;
    }
    
    .product-description h4 {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    
    /* ========== ADD TO CART - CLEAN VERSION ========== */
    .cart-action {
        margin: 20px 0;
    }
    
    /* Clean Quantity Selector */
    .quantity-clean {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .qty-clean-control {
        display: flex;
        align-items: center;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background: white;
    }
    
    .qty-clean-btn {
        background: white;
        border: none;
        width: 40px;
        height: 44px;
        font-size: 1.2rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        color: #666;
        border-radius: 8px;
    }
    
    .qty-clean-btn:hover {
        background: #F28123;
        color: white;
    }
    
    .quantity-clean-input {
        width: 55px;
        text-align: center;
        border: none;
        padding: 10px 0;
        font-size: 1rem;
        font-weight: 500;
        background: white;
    }
    
    .quantity-clean-input:focus {
        outline: none;
    }
    
    .stock-info-text {
        font-size: 0.8rem;
        color: #888;
    }
    
    /* Add to Cart Button */
    .btn-add-to-cart {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #F28123;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s;
        cursor: pointer;
        width: 100%;
        box-shadow: 0 2px 8px rgba(242, 129, 35, 0.2);
    }
    
    .btn-add-to-cart i {
        font-size: 1rem;
    }
    
    .btn-add-to-cart:hover {
        background: #051922;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .btn-add-to-cart:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Product Meta */
    .product-meta {
        margin: 20px 0;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
    
    .product-meta p {
        margin-bottom: 6px;
        font-size: 0.78rem;
        color: #666;
    }
    
    .product-meta i {
        width: 22px;
        color: #F28123;
    }
    
    /* Share Section */
    .product-social {
        margin-top: 20px;
    }
    
    .product-social h4 {
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }
    
    .social-share {
        display: flex;
        gap: 10px;
        padding-left: 0;
        list-style: none;
        margin: 0;
    }
    
    .social-share a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        background: #f0f0f0;
        border-radius: 50%;
        color: #555;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    
    .social-share a:hover {
        background: #F28123;
        color: white;
        transform: translateY(-3px);
    }
    
    /* Shipping Info Banner */
    .shipping-info-banner {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        border-radius: 12px;
        padding: 12px 16px;
        margin: 15px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .shipping-info-banner i {
        font-size: 1.3rem;
        color: #2e7d32;
    }
    
    .shipping-info-banner .shipping-text {
        font-size: 0.75rem;
        color: #1b5e20;
    }
    
    .shipping-info-banner .shipping-text strong {
        font-size: 0.85rem;
    }
    
    /* ========== RELATED PRODUCTS ========== */
    .more-products {
        padding: 60px 0;
        background-color: #f9f9f9;
        margin-top: 40px;
    }
    
    .section-title {
        margin-bottom: 40px;
    }
    
    .section-title h3 {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .section-title h3 span.orange-text {
        color: #F28123;
    }
    
    .section-title p {
        color: #666;
        font-size: 0.85rem;
    }
    
    .single-product-item {
        background: #fff;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    
    .single-product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .product-image {
        margin-bottom: 15px;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 1 / 1;
        background: #f5f5f5;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    
    .single-product-item:hover .product-image img {
        transform: scale(1.05);
    }
    
    .single-product-item h3 {
        font-size: 0.95rem;
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
    }
    
    .related-price {
        color: #F28123;
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 12px;
    }
    
    .cart-btn {
        display: inline-block;
        background: #F28123;
        color: #fff;
        padding: 6px 18px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.75rem;
        transition: all 0.3s;
    }
    
    .cart-btn:hover {
        background: #051922;
        color: #fff;
        transform: translateY(-2px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .product-card {
            padding: 20px;
        }
        .product-title {
            font-size: 1.3rem;
            margin-top: 15px;
        }
        .product-price-large {
            font-size: 1.6rem;
        }
        .btn-add-to-cart {
            padding: 12px 20px;
        }
        .qty-clean-btn {
            width: 36px;
            height: 40px;
        }
        .weight-section {
            flex-direction: column;
            align-items: flex-start;
        }
        .info-cards {
            grid-template-columns: repeat(2, 1fr);
        }
    }
}
</style>
@endpush

@section('content')
<!-- Product Detail Section -->
<section class="single-product">
    <div class="container">
        <!-- BACK BUTTON -->
        <div class="back-nav">
            <a href="{{ route('shop.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali Lihat Produk</span>
            </a>
        </div>
        
        <div class="product-card">
            <div class="row align-items-start">
                <!-- GALLERY COLUMN -->
                <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                    @php
                        $photos = [];
                        if($product->foto1) $photos[] = $product->foto1;
                        if($product->foto2) $photos[] = $product->foto2;
                        if($product->foto3) $photos[] = $product->foto3;
                        if($product->foto4) $photos[] = $product->foto4;
                        if($product->foto5) $photos[] = $product->foto5;
                    @endphp

                    @if(count($photos) > 1)
                        <div class="product-gallery">
                            <div class="swiper product-swiper">
                                <div class="swiper-wrapper">
                                    @foreach($photos as $photo)
                                        <div class="swiper-slide">
                                            <img src="{{ asset('storage/'.$photo) }}" alt="{{ $product->nama_obat }}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    @elseif(count($photos) == 1)
                        <div class="single-product-img">
                            <img src="{{ asset('storage/'.$photos[0]) }}" alt="{{ $product->nama_obat }}">
                        </div>
                    @else
                        <div class="single-product-img">
                            <img src="{{ asset('assets/fe/img/products/default.jpg') }}" alt="Default Image">
                        </div>
                    @endif
                </div>

                <!-- PRODUCT INFO COLUMN -->
                <div class="col-lg-6 col-md-12">
                    <div class="product-info">
                        <h1 class="product-title">{{ $product->nama_obat }}</h1>
                        
                        <!-- Category Info with IMAGE -->
                        <div class="category-info">
                            @php
                                $jenisObat = $product->jenis;
                                $jenisImage = $jenisObat && $jenisObat->image_url ? asset('storage/'.$jenisObat->image_url) : null;
                            @endphp
                            @if($jenisImage)
                                <img src="{{ $jenisImage }}" alt="{{ $jenisObat->jenis ?? 'Kategori' }}" class="category-img">
                            @else
                                <i class="fas fa-capsules" style="color: #F28123;"></i>
                            @endif
                            <span class="category-name">{{ $jenisObat->jenis ?? 'Obat Umum' }}</span>
                            @if(in_array($jenisObat->jenis ?? '', ['Narkotika', 'Obat Keras']))
                                <span class="prescription-badge">
                                    <i class="fas fa-prescription-bottle"></i> Perlu Resep Dokter
                                </span>
                            @endif
                        </div>
                        
                        <!-- Price Section -->
                        <div class="price-section">
                            <div class="price-label">Harga</div>
                            <div class="product-price-wrapper">
                                <span class="currency-symbol">Rp</span>
                                <span class="product-price-large">{{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                                {{-- <span class="price-unit">/ kemasan</span> --}}
                            </div>
                        </div>

                        <!-- ========== WEIGHT SECTION - ATTRACTIVE ========== -->
                        <div class="weight-section">
                            <div class="weight-info">
                                <div class="weight-icon">
                                    <i class="fas fa-weight-hanging"></i>
                                </div>
                                <div class="weight-details">
                                    <span class="weight-label">Berat Produk</span>
                                    <span class="weight-value">
                                        {{ $product->berat ?? 100 }} <span>gram</span>
                                    </span>
                                </div>
                            </div>
                            {{-- <div class="weight-badge">
                                <i class="fas fa-truck-fast"></i> Berat untuk perhitungan ongkir
                            </div> --}}
                        </div>
                        
                        <!-- Stock Info -->
                        <div class="stock-info">
                            <i class="fas fa-boxes" style="color: #F28123;"></i>
                            @if($product->stok > 10)
                                <span class="stock-badge"><i class="fas fa-check-circle"></i> Stok tersedia: {{ $product->stok }}</span>
                            @elseif($product->stok > 0)
                                <span class="stock-badge low-stock"><i class="fas fa-exclamation-triangle"></i> Sisa {{ $product->stok }} pcs</span>
                            @else
                                <span class="stock-badge" style="background:#ffebee; color:#c62828;"><i class="fas fa-times-circle"></i> Stok Habis</span>
                            @endif
                        </div>
                        
                        <!-- Shipping Info Banner -->
                        <div class="shipping-info-banner">
                            <i class="fas fa-truck-fast"></i>
                            <div class="shipping-text">
                                <strong>Info Pengiriman</strong><br>
                                Berat {{ $product->berat ?? 100 }} gram per kemasan. Ongkir dihitung berdasarkan total berat pesanan.
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div class="product-description">
                            <h4><i class="fas fa-align-left"></i> Deskripsi Produk</h4>
                            <p>{{ $product->deskripsi_obat ?? 'Deskripsi produk tidak tersedia' }}</p>
                        </div>
                        
                        <!-- Add to Cart Section -->
                        <div class="cart-action">
                            @auth('pelanggan')
                                <form action="{{ route('cart.store', $product->id) }}" method="POST" id="cartForm">
                                    @csrf
                                    <div class="quantity-clean">
                                        <div class="qty-clean-control">
                                            <button type="button" class="qty-clean-btn" onclick="changeQty(-1)">−</button>
                                            <input type="number" name="jumlah_order" id="quantity" value="1" min="1" max="{{ $product->stok }}" class="quantity-clean-input" readonly>
                                            <button type="button" class="qty-clean-btn" onclick="changeQty(1)">+</button>
                                        </div>
                                        <span class="stock-info-text">
                                            <i class="fas fa-weight-hanging"></i> 
                                            Total berat: <span id="total-weight">{{ $product->berat ?? 100 }}</span> gram
                                        </span>
                                    </div>
                                    <button type="submit" class="btn-add-to-cart" {{ $product->stok < 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart"></i>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('cart.store', $product->id) }}" method="POST" id="cartForm">
                                    @csrf
                                    <div class="quantity-clean">
                                        <div class="qty-clean-control">
                                            <button type="button" class="qty-clean-btn" onclick="changeQty(-1)">−</button>
                                            <input type="number" name="jumlah_order" id="quantity" value="1" min="1" max="{{ $product->stok }}" class="quantity-clean-input" readonly>
                                            <button type="button" class="qty-clean-btn" onclick="changeQty(1)">+</button>
                                        </div>
                                        <span class="stock-info-text">
                                            <i class="fas fa-weight-hanging"></i> 
                                            Total berat: <span id="total-weight">{{ $product->berat ?? 100 }}</span> gram
                                        </span>
                                    </div>
                                    <button type="button" class="btn-add-to-cart" onclick="window.location.href='{{ route('user.login') }}'">
                                        <i class="fas fa-shopping-cart"></i>
                                        Login untuk Beli
                                    </button>
                                </form>
                            @endauth
                        </div>
                        
                        <!-- Product Meta -->
                        <div class="product-meta">
                            <p><i class="fas fa-truck"></i> Pengiriman ke seluruh Indonesia</p>
                            <p><i class="fas fa-shield-alt"></i> Produk 100% Original</p>
                        
                        <!-- Share Section -->
                        <div class="product-social">
                            <h4><i class="fas fa-share-alt"></i> Bagikan</h4>
                            <ul class="social-share">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ $product->nama_obat }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="https://wa.me/?text={{ urlencode($product->nama_obat . ' - ' . Request::url()) }}" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products Section -->
<section class="more-products">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">    
                    <h3><span class="orange-text">Produk</span> Terkait</h3>
                    <p>Produk lain yang mungkin Anda sukai</p>
                </div>
            </div>
        </div>
        <div class="row">
            @if($relatedProducts->count() > 0)
                @foreach($relatedProducts as $related)
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="single-product-item">
                        <div class="product-image">
                            <a href="{{ route('product.show', $related->id) }}">
                                @php
                                    $relatedPhoto = $related->foto1 ?? null;
                                @endphp
                                @if($relatedPhoto)
                                    <img src="{{ asset('storage/'.$relatedPhoto) }}" alt="{{ $related->nama_obat }}">
                                @else
                                    <img src="{{ asset('assets/fe/img/products/default.jpg') }}" alt="Default Image">
                                @endif
                            </a>
                        </div>
                        <h3>{{ Str::limit($related->nama_obat, 35) }}</h3>
                        <p class="related-price">Rp{{ number_format($related->harga_jual, 0, ',', '.') }}</p>
                        <a href="{{ route('product.show', $related->id) }}" class="cart-btn">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-lg-12 text-center">
                    <p>Tidak ada produk terkait</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
// Function untuk change quantity dan update total berat
function changeQty(delta) {
    let input = document.getElementById('quantity');
    let current = parseInt(input.value);
    let max = parseInt(input.getAttribute('max'));
    let newVal = current + delta;
    
    if (newVal >= 1 && newVal <= max) {
        input.value = newVal;
        // Update total berat
        let beratPerItem = {{ $product->berat ?? 100 }};
        let totalBerat = newVal * beratPerItem;
        document.getElementById('total-weight').innerText = totalBerat;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    @if(count($photos) > 1)
        var swiper = new Swiper('.product-swiper', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'slide',
            speed: 400,
        });
    @endif
    
    // Inisialisasi total berat awal
    let beratPerItem = {{ $product->berat ?? 100 }};
    let initialQty = parseInt(document.getElementById('quantity').value) || 1;
    document.getElementById('total-weight').innerText = initialQty * beratPerItem;
});
</script>
@endpush