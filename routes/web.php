<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\Apoteker\PembelianController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\JenisPengirimanController;
use App\Http\Controllers\JenisObatController;
use App\Http\Controllers\MetodeBayarController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\PelangganAuthController;
use App\Http\Controllers\PelangganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Front-end Routes
Route::resource('/', App\Http\Controllers\HomeController::class);
Route::resource('/home', App\Http\Controllers\HomeController::class);
Route::resource('/about', App\Http\Controllers\AboutController::class);
Route::resource('/contact', App\Http\Controllers\ContactController::class);
Route::controller(ShopController::class)->group(function() {
    Route::get('/shop', 'index')->name('shop.index');
    Route::get('/product/{id}', 'show')->name('product.show');
});
Route::prefix('cart')->group(function () {
    Route::get('/', [KeranjangController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id_obat}', [KeranjangController::class, 'store'])->name('cart.store');
    Route::post('/add/{id_obat}', [KeranjangController::class, 'store'])
        ->name('cart.store')
        ->middleware('auth:pelanggan');
    // Route::post('/add/{id_obat}', [KeranjangController::class, 'store'])->name('cart.store');
    Route::get('/product/{id}', [ShopController::class, 'show'])->name('product.show');
    Route::put('/update/{id}', [KeranjangController::class, 'update'])->name('cart.update');
    Route::delete('/delete/{id}', [KeranjangController::class, 'destroy'])->name('cart.destroy');
})->middleware('auth:pelanggan');

Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/summary/{id}', [CheckoutController::class, 'summary'])->name('checkout.summary')->middleware('auth:pelanggan');
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('/cek-ongkir', [CheckoutController::class, 'cekOngkir'])->name('cek.ongkir');
    // Route::get('/riwayat', [InvoiceController::class, 'index'])->name('riwayat.index');
    // Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');

// Route untuk detail invoice
Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
})->middleware('auth:pelanggan');
Route::get('/checkout/summary/{id}', [CheckoutController::class, 'summary'])->name('checkout.summary')->middleware('auth:pelanggan');
Route::post('/checkout/update-status/{id}', [CheckoutController::class, 'updateStatus'])->name('checkout.updateStatus')->middleware('auth:apoteker');
Route::get('/user/orders', [PelangganController::class, 'orders'])->name('user.orders')->middleware('auth:pelanggan');
Route::get('/invoice/download/{id}', [InvoiceController::class, 'downloadPDF'])->name('invoice.download');


Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/summary/{id}', [CheckoutController::class, 'summary'])->name('checkout.summary');
    // Route::get('/riwayat', [InvoiceController::class, 'index'])->name('riwayat.index');
});

// Route untuk invoice (di luar prefix checkout)
Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

// Pelanggan Authentication
Route::prefix('user')->name('user.')->group(function() {
    // Public routes
    Route::get('/login', [PelangganAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PelangganAuthController::class, 'authenticate'])->name('login.submit');
    Route::get('user/password/request', [PasswordController::class, 'showRequestForm'])->name('user.password.request');
    Route::get('/register', [PelangganAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [PelangganAuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [PelangganAuthController::class, 'logout'])->name('logout');
    
    Route::middleware('auth:pelanggan')->group(function() {
        Route::get('/profile', [PelangganController::class, 'profile'])->name('profile'); 
        Route::get('/profile/edit', [PelangganController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [PelangganController::class, 'update'])->name('profile.update');
        Route::get('/profile/password', [PelangganController::class, 'showPasswordForm'])->name('profile.password');
        Route::post('/profile/password', [PelangganController::class, 'updatePassword'])->name('profile.password.update');
        Route::post('/profile/photo', [PelangganController::class, 'updatePhoto'])->name('profile.photo.update');
        Route::post('/profile/ktp', [PelangganController::class, 'updateKtp'])->name('profile.ktp.update');
    });
});


// Back-end Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('jenis_obat', JenisObatController::class)->except(['show']); 
    Route::resource('obat', ObatController::class)->except(['show']);
    Route::resource('/metode_bayar', MetodeBayarController::class);
    Route::resource('/jenis_pengiriman', JenisPengirimanController::class);
    Route::resource('/distributor', DistributorController::class);
});
Route::middleware(['auth', 'jabatan:admin,pemilik'])->group(function() {
    // Route::get('/laporan/pembelian', [LaporanPembelianController::class, 'index'])->name('laporan.pembelian');
    // Route::get('/laporan/pembelian/pdf', [LaporanPembelianController::class, 'downloadPDF'])->name('laporan.pembelian.pdf');
    Route::middleware(['auth', 'jabatan:admin,pemilik'])->group(function() {
    Route::get('/laporan/pembelian', [LaporanPembelianController::class, 'index'])->name('laporan.pembelian');
    Route::get('/laporan/pembelian/pdf', [LaporanPembelianController::class, 'downloadPDF'])->name('laporan.pembelian.pdf');
    Route::get('/laporan/penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan.penjualan');
    Route::get('/laporan/penjualan/pdf', [LaporanPenjualanController::class, 'downloadPDF'])->name('laporan.penjualan.pdf');
});
});
// Route::middleware(['auth', 'jabatan:admin,pemilik'])->group(function () {
//     Route::get('/laporan/pembelian', [LaporanPembelianController::class, 'index'])->name('laporan.pembelian');
//     Route::get('/laporan/pembelian/pdf', [LaporanPembelianController::class, 'downloadPDF'])->name('laporan.pembelian.pdf');
// });
// Route::middleware(['auth', 'jabatan:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
//     Route::resource('pembelian', 'Apoteker\PembelianController');
// });
Route::middleware(['auth', 'jabatan:apoteker'])
    ->prefix('apoteker')
    ->name('apoteker.')
    ->group(function() {
        Route::resource('pembelian', PembelianController::class);
    });
Route::group(['prefix' => 'apoteker', 'as' => 'apoteker.', 'middleware' => ['auth', 'jabatan:apoteker']], function() {
    Route::resource('pembelian', \App\Http\Controllers\Apoteker\PembelianController::class);
});

// Penjualan Routes
Route::prefix('penjualan')->group(function () {
    Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/checkout', [PenjualanController::class, 'checkout'])->name('penjualan.checkout');
    Route::post('/checkout', [PenjualanController::class, 'checkout'])->name('penjualan.checkout.post');
    Route::get('/invoice/{id}', [PenjualanController::class, 'invoice'])->name('penjualan.invoice');
    Route::get('/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::put('/approve/{id}', [PenjualanController::class, 'approve'])->name('penjualan.approve');
    Route::put('/cancel/{id}', [PenjualanController::class, 'cancel'])->name('penjualan.cancel');
    Route::put('/update-status/{id}', [PenjualanController::class, 'updateStatus'])->name('penjualan.updateStatus');
    Route::put('/verifikasi-bayar/{id}', [PenjualanController::class, 'verifikasiBayar'])->name('penjualan.verifikasiBayar');
});

// Pengiriman Routes
Route::resource('pengiriman', PengirimanController::class);
Route::put('/pengiriman/update-status/{id}', [PengirimanController::class, 'updateStatus'])->name('pengiriman.updateStatus');
// Admin Authentication
// Route::prefix('loginytta')->group(function() {
//     Route::get('/lowgin', [AuthController::class, 'showLoginForm'])->name('admin.login');
//     Route::post('/lowgin', [AuthController::class, 'login']);
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// });
// Auth Routes 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/lowgine', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/lowgine', [AuthController::class, 'login']);
    Route::post('/lowgout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('apoteker')->name('apoteker.')->group(function() {
    Route::get('/lowgine', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/lowgine', [AuthController::class, 'login']);
    Route::post('/lowgout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('karyawan')->name('karyawan.')->group(function() {
    Route::get('/lowgine', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/lowgine', [AuthController::class, 'login']);
    Route::post('/lowgout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('kasir')->name('kasir.')->group(function() {
    Route::get('/lowgine', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/lowgine', [AuthController::class, 'login']);
    Route::post('/lowgout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('pemilik')->name('pemilik.')->group(function() {
    Route::get('/lowgine', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/lowgine', [AuthController::class, 'login']);
    Route::post('/lowgout', [AuthController::class, 'logout'])->name('logout');
});

// API Routes untuk alamat (RajaOngkir proxy)
    Route::get('/api/provinces', [App\Http\Controllers\Api\RajaOngkirController::class, 'getProvinces']);
    Route::get('/api/cities', [App\Http\Controllers\Api\RajaOngkirController::class, 'getCities']);
    Route::get('/api/search-destination', [App\Http\Controllers\Api\RajaOngkirController::class, 'searchDestination']);
    // Route::get('/checkout/cek-ongkir', [CheckoutController::class, 'cekOngkir'])->name('checkout.cek-ongkir');
    // Route::post('/api/fake-shipping', [App\Http\Controllers\Api\FakeShippingController::class, 'calculateCost']);
    // Route::post('/api/shipping-cost', [App\Http\Controllers\Api\RajaOngkirController::class, 'getShippingCost']);
    // Route::get('/api/search-city', [App\Http\Controllers\Api\RajaOngkirController::class, 'searchCity']);
    // Route::get('/api/search-city', [App\Http\Controllers\Api\ShippingController::class, 'searchCity']);
    // Route::post('/api/shipping-cost', [App\Http\Controllers\Api\ShippingController::class, 'calculateCost']);
// Biteship Location Routes 
// Route::prefix('api/biteship')->group(function () {
//     Route::get('/provinces', [App\Http\Controllers\Api\BiteshipLocationController::class, 'getProvinces']);
//     Route::get('/cities', [App\Http\Controllers\Api\BiteshipLocationController::class, 'getCities']);
//     Route::get('/search', [App\Http\Controllers\Api\BiteshipLocationController::class, 'searchLocation']);
// });


Route::middleware(['jabatan:admin,pemilik'])->group(function() {
        Route::get('/laporan/pembelian', [LaporanPembelianController::class, 'index'])->name('laporan.pembelian');
        Route::get('/laporan/pembelian/pdf', [LaporanPembelianController::class, 'downloadPDF'])->name('laporan.pembelian.pdf');
        Route::get('/laporan/penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan.penjualan');
        Route::get('/laporan/penjualan/pdf', [LaporanPenjualanController::class, 'downloadPDF'])->name('laporan.penjualan.pdf');
    });
    
// Protected Routes Group
Route::middleware(['auth'])->group(function() {
    // Route::middleware(['jabatan:admin'])->prefix('admin')->name('admin.')->group(function() {
    //     Route::get('/', [AdminController::class, 'index'])->name('index');
    //     Route::resource('users', UserController::class);
    //     Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    //     Route::get('/customers/{id}', [AdminController::class, 'showCustomer'])->name('customers.show');
    // });
    Route::middleware(['jabatan:admin'])->prefix('admin')->name('admin.')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('users', UserController::class);
        Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
        Route::get('/customers/{id}', [AdminController::class, 'showCustomer'])->name('customers.show');
    });

    Route::middleware(['jabatan:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function() {
        Route::get('/', [ApotekerController::class, 'index'])->name('index');
    });
    
    
    // Karyawan Routes
    // Route::middleware(['jabatan:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function() {
    //     Route::get('/', [KaryawanController::class, 'index'])->name('index');
    //     Route::get('/penjualan', [KaryawanController::class, 'penjualan'])->name('penjualan.index');
    //     Route::put('/penjualan/{id}/status', [KaryawanController::class, 'updateStatus'])->name('penjualan.updateStatus');
    // });
    Route::middleware(['jabatan:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function() {
        Route::get('/', [KaryawanController::class, 'index'])->name('index');
        Route::get('/penjualan', [KaryawanController::class, 'penjualan'])->name('penjualan.index');
        Route::put('/penjualan/{id}/status', [KaryawanController::class, 'updateStatus'])->name('penjualan.updateStatus');
    });
    
    // Kasir Routes
    Route::middleware(['jabatan:kasir'])->prefix('kasir')->name('kasir.')->group(function() {
        Route::get('/', [KasirController::class, 'index'])->name('index');
        Route::resource('pengiriman', PengirimanController::class);
        Route::put('pengiriman/update-status/{id}', [PengirimanController::class, 'updateStatus'])->name('pengiriman.updateStatus');
    });
    
    
    // Pemilik Routes
    Route::middleware(['jabatan:pemilik'])->prefix('pemilik')->name('pemilik.')->group(function() {
        Route::get('/', [PemilikController::class, 'index'])->name('index');
        Route::get('/users', [PemilikController::class, 'users'])->name('users');
        Route::prefix('apoteker')->middleware(['auth', 'role:apoteker'])->group(function () {
        Route::resource('pembelian', App\Http\Controllers\Apoteker\PembelianController::class);
        Route::get('/pembelian/obat/{id}', [App\Http\Controllers\Apoteker\PembelianController::class, 'getObatDetail'])->name('apoteker.pembelian.obat-detail');
        Route::get('/pelanggan', [PemilikController::class, 'pelanggan'])->name('pelanggan');
        Route::get('/pelanggan/{id}', [PemilikController::class, 'showPelanggan'])->name('pelanggan.show');
    });
    });
    
    
});

