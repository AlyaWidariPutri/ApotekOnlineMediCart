<!-- Featured Products Section -->
<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">    
                    <h3><span class="orange-text">Our</span> Medicines</h3>
                    <p>Providing high-quality medicines to ensure your well-being and health.</p>
                </div>
            </div>
        </div>

        <!-- Featured Products with Swipe -->
        <div class="featured-products-wrapper">
            <!-- Tombol Navigasi Kiri -->
            <button class="scroll-btn scroll-left" id="scrollLeftBtn">
                <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Container Scroll Horizontal -->
            <div class="featured-scroll-container" id="featuredScrollContainer">
                <div class="featured-scroll-wrapper" id="featuredScrollWrapper">
                    @foreach($featuredProducts as $product)
                    <div class="featured-card">
                        <!-- Harga di pojok kanan atas -->
                        <div class="featured-price-corner">
                            <span class="currency">Rp</span>
                            <span class="price-number">{{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Gambar Jenis Obat di Kiri -->
                        @php
                            $jenisObat = $product->jenis;
                            $jenisImage = $jenisObat && $jenisObat->image_url ? asset('storage/'.$jenisObat->image_url) : null;
                        @endphp
                        <div class="featured-type-icon">
                            @if($jenisImage)
                                <img src="{{ $jenisImage }}" alt="{{ $jenisObat->jenis ?? 'Kategori' }}" class="featured-type-image">
                            @else
                                <div class="featured-type-icon-default">
                                    <i class="fas fa-capsules"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Gambar Produk dengan Overlay CTA -->
                        <div class="featured-image-wrapper">
                            <div class="featured-image">
                                <a href="{{ route('product.show', $product->id) }}">
                                    @if($product->foto1)
                                        <img src="{{ asset('storage/'.$product->foto1) }}" alt="{{ $product->nama_obat }}">
                                    @else
                                        <img src="{{ asset('assets/fe/img/products/default.jpg') }}" alt="Default Image">
                                    @endif
                                </a>
                            </div>
                            <div class="featured-overlay-cta">
                                <a href="{{ route('product.show', $product->id) }}" class="featured-cta-btn">
                                    <i class="fas fa-search-plus"></i>
                                    <span>Lihat Detail</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Info Produk -->
                        <div class="featured-info">
                            <h3 class="featured-name">
                                <a href="{{ route('product.show', $product->id) }}">{{ $product->nama_obat }}</a>
                            </h3>
                            <div class="featured-category-badge">
                                <span class="featured-category-chip">
                                    {{ $product->jenis->jenis ?? 'Obat Umum' }}
                                </span>
                            </div>
                            <div class="featured-action">
                                @auth('pelanggan')
                                    <form action="{{ route('cart.store', $product->id) }}" method="POST" class="featured-order-form">
                                        @csrf
                                        <input type="hidden" name="jumlah_order" value="1">
                                        <button type="submit" class="featured-order-btn">
                                            Order Now <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="featured-order-btn" onclick="window.location.href='{{ route('user.login') }}';">
                                        Login to Order <i class="fas fa-arrow-right"></i>
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tombol Navigasi Kanan -->
            <button class="scroll-btn scroll-right" id="scrollRightBtn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('shop.index') }}" class="boxed-btn">View All Medicines</a>
        </div>
    </div>
</div>

<style>
/* ========== FEATURED PRODUCTS SECTION ========== */
.featured-products-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    gap: 15px;
}

/* Scroll Container */
.featured-scroll-container {
    flex: 1;
    overflow-x: auto;
    overflow-y: hidden;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}

.featured-scroll-container::-webkit-scrollbar {
    display: none;
}

.featured-scroll-wrapper {
    display: flex;
    gap: 25px;
    padding: 20px 5px;
}

/* Featured Card - Sama seperti product-card-classy */
.featured-card {
    min-width: 300px;
    max-width: 300px;
    background: white;
    border-radius: 24px;
    padding: 20px 20px 25px;
    position: relative;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
    flex-shrink: 0;
}

.featured-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
}

/* Harga pojok kanan atas */
.featured-price-corner {
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

.featured-price-corner .currency {
    font-size: 0.75rem;
    font-weight: 500;
    margin-right: 2px;
}

.featured-price-corner .price-number {
    font-size: 1rem;
    font-weight: 700;
}

/* Gambar Jenis Obat di Kiri */
.featured-type-icon {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 10;
}

.featured-type-image {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    background: white;
    transition: all 0.3s ease;
}

.featured-card:hover .featured-type-image {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(242, 129, 35, 0.25);
    border-color: #F28123;
}

.featured-type-icon-default {
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

.featured-type-icon-default i {
    font-size: 1.3rem;
    color: #F28123;
}

/* Gambar Produk */
.featured-image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    margin-bottom: 20px;
}

.featured-image {
    text-align: center;
    padding: 10px;
}

.featured-image a {
    display: block;
}

.featured-image img {
    max-width: 80%;
    height: auto;
    margin: 0 auto;
    transition: transform 0.4s ease;
}

.featured-card:hover .featured-image img {
    transform: scale(1.08);
}

/* Overlay CTA */
.featured-overlay-cta {
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

.featured-image-wrapper:hover .featured-overlay-cta {
    opacity: 1;
}

.featured-cta-btn {
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

.featured-image-wrapper:hover .featured-cta-btn {
    transform: translateY(0);
    opacity: 1;
}

.featured-cta-btn:hover {
    background: #f6c44f;
    transform: scale(1.05);
    color: white;
}

/* Info Produk */
.featured-info {
    text-align: center;
    padding: 0 10px;
}

.featured-name {
    margin-bottom: 12px;
    font-size: 1.3rem;
    font-weight: 700;
}

.featured-name a {
    color: #2c2c2c;
    text-decoration: none;
    transition: color 0.3s ease;
}

.featured-name a:hover {
    color: #F28123;
}

/* Category Badge */
.featured-category-badge {
    margin-bottom: 20px;
}

.featured-category-chip {
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

/* Tombol Order Now */
.featured-action {
    margin-top: 5px;
}

.featured-order-form {
    display: inline-block;
    width: 100%;
}

.featured-order-btn {
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

.featured-order-btn i {
    font-size: 0.75rem;
    transition: transform 0.3s ease;
}

.featured-order-btn:hover {
    background: #F28123;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(242, 129, 35, 0.25);
}

.featured-order-btn:hover i {
    transform: translateX(5px);
}

/* Tombol Navigasi Scroll */
.scroll-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: white;
    border: 1px solid #e8e2d9;
    color: #F28123;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    flex-shrink: 0;
}

.scroll-btn:hover {
    background: #F28123;
    color: white;
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(242, 129, 35, 0.25);
}

.scroll-btn i {
    font-size: 1.2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .featured-card {
        min-width: 260px;
        max-width: 260px;
        padding: 15px 15px 20px;
    }
    
    .featured-price-corner {
        top: 12px;
        right: 12px;
        padding: 5px 10px;
    }
    
    .featured-price-corner .price-number {
        font-size: 0.85rem;
    }
    
    .featured-type-image,
    .featured-type-icon-default {
        width: 35px;
        height: 35px;
    }
    
    .featured-name {
        font-size: 1rem;
    }
    
    .featured-category-chip {
        padding: 4px 12px;
        font-size: 0.7rem;
    }
    
    .featured-order-btn {
        padding: 10px 16px;
        font-size: 0.75rem;
    }
    
    .scroll-btn {
        width: 36px;
        height: 36px;
    }
    
    .scroll-btn i {
        font-size: 0.9rem;
    }
}
</style>

<script>
// Featured Products Scroll dengan Tombol & Auto Swipe
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('featuredScrollContainer');
    const scrollLeftBtn = document.getElementById('scrollLeftBtn');
    const scrollRightBtn = document.getElementById('scrollRightBtn');
    
    if (!container) return;
    
    // Fungsi scroll kiri
    scrollLeftBtn.addEventListener('click', function() {
        container.scrollBy({
            left: -320,
            behavior: 'smooth'
        });
    });
    
    // Fungsi scroll kanan
    scrollRightBtn.addEventListener('click', function() {
        container.scrollBy({
            left: 320,
            behavior: 'smooth'
        });
    });
    
    // Auto swipe setiap 4 detik
    let autoScrollInterval = setInterval(function() {
        // Cek apakah mouse sedang hover di container
        const isHovering = container.matches(':hover');
        if (!isHovering) {
            // Scroll ke kanan sedikit
            container.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
            
            // Reset scroll ke awal jika sudah mencapai akhir
            setTimeout(function() {
                const maxScroll = container.scrollWidth - container.clientWidth;
                if (container.scrollLeft >= maxScroll - 10) {
                    container.scrollTo({
                        left: 0,
                        behavior: 'smooth'
                    });
                }
            }, 500);
        }
    }, 4000);
    
    // Hentikan auto scroll saat hover
    container.addEventListener('mouseenter', function() {
        clearInterval(autoScrollInterval);
    });
    
    // Mulai lagi auto scroll saat mouse leave
    container.addEventListener('mouseleave', function() {
        autoScrollInterval = setInterval(function() {
            const isHovering = container.matches(':hover');
            if (!isHovering) {
                container.scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
                
                setTimeout(function() {
                    const maxScroll = container.scrollWidth - container.clientWidth;
                    if (container.scrollLeft >= maxScroll - 10) {
                        container.scrollTo({
                            left: 0,
                            behavior: 'smooth'
                        });
                    }
                }, 500);
            }
        }, 4000);
    });
    
    // Update tombol navigasi (disable saat di ujung)
    function updateScrollButtons() {
        const maxScroll = container.scrollWidth - container.clientWidth;
        
        if (container.scrollLeft <= 10) {
            scrollLeftBtn.disabled = true;
            scrollLeftBtn.style.opacity = '0.5';
            scrollLeftBtn.style.cursor = 'not-allowed';
        } else {
            scrollLeftBtn.disabled = false;
            scrollLeftBtn.style.opacity = '1';
            scrollLeftBtn.style.cursor = 'pointer';
        }
        
        if (container.scrollLeft >= maxScroll - 10) {
            scrollRightBtn.disabled = true;
            scrollRightBtn.style.opacity = '0.5';
            scrollRightBtn.style.cursor = 'not-allowed';
        } else {
            scrollRightBtn.disabled = false;
            scrollRightBtn.style.opacity = '1';
            scrollRightBtn.style.cursor = 'pointer';
        }
    }
    
    container.addEventListener('scroll', updateScrollButtons);
    window.addEventListener('resize', updateScrollButtons);
    setTimeout(updateScrollButtons, 100);
});
</script>