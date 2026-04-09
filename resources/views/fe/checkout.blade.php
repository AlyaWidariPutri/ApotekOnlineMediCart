@extends('fe.master')

@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Farmasi Sehat Selalu</p>
                    <h1>Checkout Obat</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-150 mb-150">
    <div class="container">
        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <!-- Informasi Pasien -->
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Informasi Pasien
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="billing-address-form">
                                            @if(Auth::guard('pelanggan')->check())
                                                @php
                                                    $user = Auth::guard('pelanggan')->user();
                                                @endphp
                                                <input type="hidden" name="id_pelanggan" value="{{ $user->id }}">
                                                <p><input type="text" name="nama_penerima" placeholder="Nama Penerima" value="{{ $user->nama_pelanggan }}" required></p>
                                                <p><input type="email" name="email" placeholder="Email" value="{{ $user->email }}" required></p>
                                                <p><input type="text" name="alamat_pengiriman" placeholder="Alamat" value="{{ $user->alamat1 }}" required></p>
                                                <p><input type="tel" name="no_hp_penerima" placeholder="Nomor HP" value="{{ $user->no_telp }}" required></p>
                                            @else
                                                <script>window.location = "{{ route('user.login') }}";</script>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Metode Pengiriman - VERSION SIMPLE -->
                            <div class="card single-accordion">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Metode Pengiriman
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shipping-address-form">
                                            <div class="form-group">
                                                <label>Pilih Metode Pengiriman</label>
                                                <select class="form-control" name="id_jenis_kirim" required id="select-pengiriman">
                                                    <option value="">-- Pilih Pengiriman --</option>
                                                    @foreach($jenisPengiriman as $pengiriman)
                                                        <option value="{{ $pengiriman->id }}" 
                                                            data-harga="{{ $pengiriman->harga }}"
                                                            data-nama="{{ $pengiriman->nama_ekspedisi }}"
                                                            data-layanan="{{ $pengiriman->layanan }}">
                                                            {{ $pengiriman->nama_ekspedisi }} - 
                                                            {{ $pengiriman->layanan }} - 
                                                            Rp {{ number_format($pengiriman->harga, 0, ',', '.') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="ongkos_kirim" id="input-ongkir" value="0">
                                                <input type="hidden" name="kode_kurir" id="input-kode-kurir">
                                                <input type="hidden" name="layanan" id="input-layanan">
                                                <input type="hidden" name="nama_ekspedisi" id="input-nama-ekspedisi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Metode Pembayaran -->
                            <div class="card single-accordion">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Metode Pembayaran
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card-details">
                                            <div class="form-group">
                                                <label>Pilih Metode Pembayaran</label>
                                                <select class="form-control" name="id_metode_bayar" required id="select-pembayaran">
                                                    <option value="">-- Pilih Pembayaran --</option>
                                                    @foreach($metodeBayar as $bayar)
                                                        <option value="{{ $bayar->id }}" 
                                                            data-rekening="{{ $bayar->no_rekening }}"
                                                            data-tempat="{{ $bayar->tempat_bayar }}">
                                                            {{ $bayar->metode_pembayaran }} 
                                                            @if($bayar->tempat_bayar)
                                                                ({{ $bayar->tempat_bayar }})
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="bank-details" style="display: none;">
                                                <div class="form-group">
                                                    <label>Nomor Rekening Tujuan</label>
                                                    <input type="text" class="form-control" readonly id="nomor-rekening">
                                                </div>
                                                <div class="form-group">
                                                    <label>Upload Bukti Transfer</label>
                                                    <input type="file" class="form-control-file" name="bukti_transfer" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Resep -->
                            <div class="card single-accordion">
                                <div class="card-header" id="headingResep">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseResep" >
                                            Resep Dokter (Wajib untuk obat tertentu)
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseResep" class="collapse" aria-labelledby="headingResep" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Upload Resep</label>
                                            <input type="file" name="url_resep" class="form-control-file" 
                                                {{ $requiresPrescription ? 'required' : '' }}>
                                            <small class="text-muted">
                                                @if($requiresPrescription)
                                                    <span class="text-danger">* Wajib diisi untuk obat Narkotika/Obat Keras</span><br>
                                                @endif
                                                Format: JPG, PNG, PDF (max 2MB)
                                            </small>
                                        </div>
                                        <div id="resep-preview" style="display: none;">
                                            <img id="preview-image" src="#" alt="Preview Resep" style="max-width: 100%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="col-lg-4">
                    <div class="order-details-wrap">
                        <table class="order-details">
                            <thead>
                                <tr>
                                    <th>Detail Pesanan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="order-details-body">
                                <tr>
                                    <td>Produk</td>
                                    <td>Subtotal</td>
                                </tr>
                                @foreach($cartItems as $item)
                                <tr>
                                    <td>{{ $item->obat->nama_obat }} ({{ $item->jumlah_order }})</td>
                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tbody class="checkout-details">
                                <tr>
                                    <td>Subtotal</td>
                                    <td>Rp <span id="text-subtotal">{{ number_format($subtotal, 0, ',', '.') }}</span></td>
                                </tr>
                                <tr>
                                    <td>Ongkos Kirim</td>
                                    <td>Rp <span id="text-ongkir">0</span></td>
                                </tr>
                                <tr>
                                    <td>Biaya Aplikasi (2%)</td>
                                    <td>Rp <span id="text-biaya-app">0</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Pembayaran</strong></td>
                                    <td><strong>Rp <span id="text-total">{{ number_format($subtotal, 0, ',', '.') }}</span></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="boxed-btn">Proses Pesanan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end check out section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
alert('Checkout page loaded!');

// Tunggu sampai halaman benar-benar siap
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM siap');
    
    var dropdown = document.getElementById('select-pengiriman');
    if (dropdown) {
        console.log('Dropdown ditemukan');
        
        // Ambil subtotal dari text (Rp 188.553 -> 188553)
        var subtotalText = document.getElementById('text-subtotal').innerText;
        var subtotal = parseInt(subtotalText.replace(/\./g, '').replace('Rp ', ''));
        console.log('Subtotal: ' + subtotal);
        
        dropdown.addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var ongkir = parseInt(selectedOption.getAttribute('data-harga'));
            
            console.log('Ongkir: ' + ongkir);
            
            if (isNaN(ongkir)) {
                console.error('Ongkir tidak valid!');
                return;
            }
            
            // HITUNG: Biaya Aplikasi = 2% dari subtotal
            var biayaApp = Math.round(subtotal * 0.02);
            
            // HITUNG: Total = subtotal + ongkir + biayaApp
            var total = subtotal + ongkir + biayaApp;
            
            console.log('Biaya App (2%): ' + biayaApp);
            console.log('Total: ' + total);
            
            // Update tampilan
            document.getElementById('text-ongkir').innerText = formatRupiah(ongkir);
            document.getElementById('text-biaya-app').innerText = formatRupiah(biayaApp);
            document.getElementById('text-total').innerText = formatRupiah(total);
            
            // Update hidden input untuk dikirim ke server
            document.getElementById('input-ongkir').value = ongkir;
            document.getElementById('input-nama-ekspedisi').value = selectedOption.getAttribute('data-nama') || '';
            document.getElementById('input-layanan').value = selectedOption.getAttribute('data-layanan') || '';
        });
    } else {
        alert('Dropdown TIDAK ditemukan!');
    }
});

// Fungsi format ke Rupiah
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
}
</script>