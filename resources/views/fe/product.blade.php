@extends('fe.master')

@section('title', 'Product')

@section('content')
    <!-- Breadcrumb Section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Your Trusted Pharmacy</p>
                        <h1>Our Products</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <!-- Category Filters -->
            <div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            <li class="active" data-filter="*">All Products</li>
                            @foreach($categories as $category)
                                <li data-filter=".jenis-{{ $category->id }}">
                                    {{ $category->jenis }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product List -->
            <div class="row product-lists">
                @foreach($data as $product)
                <div class="col-lg-4 col-md-6 text-center jenis-{{ $product->idjenis }}">
                    <div class="product-card-classy">
                        <!-- Harga di pojok kanan atas -->
                        <div class="product-price-corner">
                            <span class="currency">Rp</span>
                            <span class="price-number">{{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Gambar Jenis Obat di Kiri -->
                        @php
                            $jenisObat = $product->jenis;
                            $jenisImage = $jenisObat && $jenisObat->image_url ? asset('storage/'.$jenisObat->image_url) : null;
                        @endphp
                        <div class="product-type-icon">
                            @if($jenisImage)
                                <img src="{{ $jenisImage }}" alt="{{ $jenisObat->jenis ?? 'Kategori' }}" class="type-image">
                            @else
                                <div class="type-icon-default">
                                    <i class="fas fa-capsules"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Gambar Produk dengan Overlay CTA -->
                        <div class="product-image-wrapper">
                            <div class="product-image-classy">
                                <a href="{{ route('product.show', $product->id) }}">
                                    @if($product->foto1)
                                        <img src="{{ asset('storage/'.$product->foto1) }}" alt="{{ $product->nama_obat }}">
                                    @else
                                        <img src="{{ asset('assets/fe/img/products/default.jpg') }}" alt="Default Image">
                                    @endif
                                </a>
                            </div>
                            <!-- Overlay CTA yang muncul saat hover -->
                            <div class="product-overlay-cta">
                                <a href="{{ route('product.show', $product->id) }}" class="cta-detail-btn">
                                    <i class="fas fa-search-plus"></i>
                                    <span>Lihat Detail</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Info Produk -->
                        <div class="product-info-classy">
                            <h3 class="product-name-classy">
                                <a href="{{ route('product.show', $product->id) }}">{{ $product->nama_obat }}</a>
                            </h3>
                            
                            <!-- Jenis Obat Text -->
                            <div class="product-category-badge">
                                <span class="category-chip">
                                    {{-- <i class="fas fa-tag"></i> --}}
                                    {{ $product->jenis->jenis ?? 'Obat Umum' }}
                                </span>
                            </div>
                            
                            <!-- Tombol Order Now -->
                            <div class="product-action-classy">
                                @auth('pelanggan')
                                    <form action="{{ route('cart.store', $product->id) }}" method="POST" class="order-form">
                                        @csrf
                                        <input type="hidden" name="jumlah_order" value="1">
                                        <button type="submit" class="order-now-btn">
                                            Order Now <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="order-now-btn" onclick="window.location.href='{{ route('user.login') }}';">
                                        Login to Order <i class="fas fa-arrow-right"></i>
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="row">
            <div class="col-lg-12 text-center">
                <ul class="pagination-modern">
                    @if($data->onFirstPage())
                        <li class="disabled"><span><i class="fas fa-chevron-left"></i></span></li>
                    @else
                        <li><a href="{{ $data->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
                    @endif
                    
                    @foreach(range(1, $data->lastPage()) as $i)
                        @if($i == $data->currentPage())
                            <li class="active"><span>{{ $i }}</span></li>
                        @else
                            <li><a href="{{ $data->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endforeach
                    
                    @if($data->hasMorePages())
                        <li><a href="{{ $data->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
                    @else
                        <li class="disabled"><span><i class="fas fa-chevron-right"></i></span></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if(typeof jQuery == 'undefined') {
        console.error('jQuery is not loaded');
        return;
    }

    $('.product-filters').on('click', 'li', function() {
        try {
            $('.product-filters li').removeClass('active');
            $(this).addClass('active');
            
            const filterValue = $(this).attr('data-filter');
            
            $('.product-lists .col-lg-4').hide();
            
            if(filterValue === '*') {
                $('.product-lists .col-lg-4').show();
            } else {
                $('.product-lists').find(filterValue).show();
            }
        } catch (e) {
            console.error('Filter error:', e);
        }
    });

    $('.product-filters li[data-filter="*"]').click();
});
</script>
@endpush

@push('styles')
<style>
/* ========== CLASSY PRODUCT CARD DENGAN OVERLAY CTA ========== */
.product-section {
    background: #fffbf7;
}

/* Filter Styles */
.product-filters ul {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    list-style: none;
    padding: 0;
    justify-content: center;
    margin-bottom: 50px;
}

.product-filters li {
    padding: 10px 28px;
    background: transparent;
    border: 1.5px solid #e8e2d9;
    border-radius: 40px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.5px;
    color: #4a4a4a;
}

.product-filters li:hover {
    background: #F28123;
    border-color: #F28123;
    color: white;
    transform: translateY(-2px);
}

.product-filters li.active {
    background: #F28123;
    border-color: #F28123;
    color: white;
    box-shadow: 0 4px 12px rgba(242, 129, 35, 0.25);
}

/* Product Card */
.product-card-classy {
    background: white;
    border-radius: 24px;
    padding: 20px 20px 25px;
    margin-bottom: 30px;
    position: relative;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
}

.product-card-classy:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
}

/* Harga di pojok kanan atas */
.product-price-corner {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #F28123;
    padding: 8px 14px;
    border-radius: 40px;
    color: white;
    font-weight: 700;
    z-index: 10;
    box-shadow: 0 4px 10px rgba(242, 129, 35, 0.3);
}

.product-price-corner .currency {
    font-size: 0.75rem;
    font-weight: 500;
    margin-right: 2px;
}

.product-price-corner .price-number {
    font-size: 1rem;
    font-weight: 700;
}

/* Gambar Jenis Obat di Kiri */
.product-type-icon {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 10;
}

.type-image {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    background: white;
    transition: all 0.3s ease;
}

.product-card-classy:hover .type-image {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(242, 129, 35, 0.25);
    border-color: #F28123;
}

.type-icon-default {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #f5f0eb;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.type-icon-default i {
    font-size: 1.3rem;
    color: #F28123;
}

/* Product Image Wrapper dengan Overlay */
.product-image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    margin-bottom: 20px;
}

.product-image-classy {
    text-align: center;
    padding: 10px;
    transition: transform 0.4s ease;
}

.product-image-classy a {
    display: block;
}

.product-image-classy img {
    max-width: 80%;
    height: auto;
    margin: 0 auto;
    transition: transform 0.4s ease;
}

.product-card-classy:hover .product-image-classy img {
    transform: scale(1.08);
}

/* Overlay CTA yang muncul saat hover */
.product-overlay-cta {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    border-radius: 20px;
    backdrop-filter: blur(3px);
}

.product-image-wrapper:hover .product-overlay-cta {
    opacity: 1;
}

.cta-detail-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: #F28123;
    color: white;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    transform: translateY(20px);
    opacity: 0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.product-image-wrapper:hover .cta-detail-btn {
    transform: translateY(0);
    opacity: 1;
}

.cta-detail-btn:hover {
    background: #f6c44f;
    transform: scale(1.05);
    color: white;
}

.cta-detail-btn i {
    font-size: 1rem;
}

/* Product Info */
.product-info-classy {
    text-align: center;
    padding: 0 10px;
}

.product-name-classy {
    margin-bottom: 12px;
    font-size: 1.3rem;
    font-weight: 700;
}

.product-name-classy a {
    color: #2c2c2c;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-name-classy a:hover {
    color: #F28123;
}

/* Jenis Obat Badge */
.product-category-badge {
    margin-bottom: 20px;
}

.category-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: #f5f0eb;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
    color: #F28123;
    letter-spacing: 0.5px;
}

.category-chip i {
    font-size: 0.7rem;
    color: #F28123;
}

/* Tombol Order Now */
.product-action-classy {
    margin-top: 5px;
}

.order-form {
    display: inline-block;
    width: 100%;
}

.order-now-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 12px 20px;
    background: #051922;
    color: white;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.order-now-btn i {
    font-size: 0.75rem;
    transition: transform 0.3s ease;
}

.order-now-btn:hover {
    background: #F28123;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(242, 129, 35, 0.25);
}

.order-now-btn:hover i {
    transform: translateX(5px);
}

/* Pagination Modern */
.pagination-modern {
    display: inline-flex;
    list-style: none;
    padding: 0;
    margin: 40px 0 0;
    gap: 8px;
}

.pagination-modern li {
    margin: 0;
}

.pagination-modern li a,
.pagination-modern li span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: white;
    border-radius: 12px;
    color: #4a4a4a;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.pagination-modern li a:hover {
    background: #F28123;
    color: white;
    transform: translateY(-2px);
}

.pagination-modern li.active span {
    background: #F28123;
    color: white;
    box-shadow: 0 4px 12px rgba(242, 129, 35, 0.3);
}

.pagination-modern li.disabled span {
    background: #f0f0f0;
    color: #ccc;
    cursor: not-allowed;
}

/* Responsive */
@media (max-width: 768px) {
    .product-filters li {
        padding: 6px 18px;
        font-size: 12px;
    }
    
    .product-card-classy {
        padding: 15px 15px 20px;
    }
    
    .product-price-corner {
        top: 12px;
        right: 12px;
        padding: 5px 10px;
    }
    
    .product-price-corner .price-number {
        font-size: 0.85rem;
    }
    
    .type-image,
    .type-icon-default {
        width: 35px;
        height: 35px;
    }
    
    .type-icon-default i {
        font-size: 1rem;
    }
    
    .product-name-classy {
        font-size: 1rem;
    }
    
    .category-chip {
        padding: 4px 12px;
        font-size: 0.7rem;
    }
    
    .order-now-btn {
        padding: 10px 16px;
        font-size: 0.75rem;
    }
    
    .cta-detail-btn {
        padding: 8px 16px;
        font-size: 0.75rem;
    }
    
    .pagination-modern li a,
    .pagination-modern li span {
        width: 38px;
        height: 38px;
        font-size: 14px;
    }
}
</style>
@endpush
