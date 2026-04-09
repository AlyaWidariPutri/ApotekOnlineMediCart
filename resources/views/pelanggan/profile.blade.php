@extends('fe.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #f28123; color: white;">
                    <h4 class="mb-0">Edit Profil</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- ========== PROFILE PHOTO SECTION ========== -->
                    <div class="text-center mb-4">
                        <div class="profile-photo-container mx-auto">
                            <img src="{{ $pelanggan->foto ? asset($pelanggan->foto) : asset('images/profile/profile.png') }}" 
                                class="img-fluid rounded-circle profile-photo" 
                                alt="Profile Photo"
                                style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f28123;">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#photoModal">
                            <i class="fas fa-camera"></i> Ubah Foto Profil
                        </button>
                        
                        @if($pelanggan->url_ktp)
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $pelanggan->url_ktp) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-id-card"></i> Lihat KTP
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#ktpModal">
                                <i class="fas fa-sync-alt"></i> Ubah KTP
                            </button>
                        </div>
                        @else
                        <div class="mt-3">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ktpModal">
                                <i class="fas fa-upload"></i> Upload KTP
                            </button>
                        </div>
                        @endif
                    </div>

                    <!-- ========== EDIT PROFILE FORM ========== -->
                    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_pelanggan" class="form-control" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $pelanggan->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp', $pelanggan->no_telp) }}" required>
                        </div>

                        <!-- ALAMAT UTAMA -->
                        <h5 class="mt-4 mb-3">Alamat Utama</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Provinsi</label>
                                <select id="propinsi1" name="propinsi1" class="form-control" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kota/Kabupaten</label>
                                <select id="kota1" name="kota1" class="form-control" required disabled>
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" id="kodepos1" name="kodepos1" class="form-control" 
                                   value="{{ old('kodepos1', $pelanggan->kodepos1) }}" 
                                   placeholder="Kode pos akan terisi otomatis" readonly style="background:#e9ecef">
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label">Kode Pos <span class="text-muted"></span></label>
                            <input type="text" id="kodepos1" name="kodepos1" class="form-control" 
                                value="{{ old('kodepos1', $pelanggan->kodepos1) }}" 
                                placeholder="Masukkan kode pos (bisa diisi manual)">
                            <small class="text-muted">Isilahsesuai pilihan Provinsi dan Kota anda</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat1" class="form-control" rows="3" required>{{ old('alamat1', $pelanggan->alamat1) }}</textarea>
                        </div>

                        <!-- ALAMAT TAMBAHAN 1 -->
                        <h5 class="mt-4 mb-3">Alamat Tambahan 1 (Opsional)</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Provinsi</label>
                                <select id="propinsi2" name="propinsi2" class="form-control">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kota/Kabupaten</label>
                                <select id="kota2" name="kota2" class="form-control" disabled>
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode Pos <span class="text-muted"></span></label>
                            <input type="text" id="kodepos2" name="kodepos2" class="form-control" 
                                value="{{ old('kodepos2', $pelanggan->kodepos2) }}" 
                                placeholder="Masukkan kode pos (bisa diisi manual)">
                            <small class="text-muted">Isilahsesuai pilihan Provinsi dan Kota anda</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat2" class="form-control" rows="3">{{ old('alamat2', $pelanggan->alamat2) }}</textarea>
                        </div>

                        <!-- ALAMAT TAMBAHAN 2 -->
                        <h5 class="mt-4 mb-3">Alamat Tambahan 2 (Opsional)</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Provinsi</label>
                                <select id="propinsi3" name="propinsi3" class="form-control">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kota/Kabupaten</label>
                                <select id="kota3" name="kota3" class="form-control" disabled>
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" id="kodepos3" name="kodepos3" class="form-control" 
                                   value="{{ old('kodepos3', $pelanggan->kodepos3) }}" 
                                   placeholder="Kode pos akan terisi otomatis" readonly style="background:#e9ecef">
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label">Kode Pos <span class="text-muted"></span></label>
                            <input type="text" id="kodepos3" name="kodepos3" class="form-control" 
                                value="{{ old('kodepos3', $pelanggan->kodepos3) }}" 
                                placeholder="Masukkan kode pos (bisa diisi manual)">
                            <small class="text-muted">Isilahsesuai pilihan Provinsi dan Kota anda</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat3" class="form-control" rows="3">{{ old('alamat3', $pelanggan->alamat3) }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn" style="background-color: #f28123; color: white;">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <hr>

                    <!-- ========== CHANGE PASSWORD FORM ========== -->
                    <h5 class="mb-3">Ubah Password</h5>
                    <form method="POST" action="{{ route('user.profile.password') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn" style="background-color: #f28123; color: white;">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== PHOTO UPLOAD MODAL ========== -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Ubah Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('user.profile.photo.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto Profil</label>
                        <input class="form-control" type="file" id="foto" name="foto" accept="image/*" required>
                        <small class="text-muted">Ukuran maksimal 2MB. Format: JPG, PNG, JPEG.</small>
                    </div>
                    <div class="current-photo text-center">
                        <img id="preview-photo" src="#" alt="Preview" style="max-width: 150px; display: none; border-radius: 50%; margin-top: 10px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== KTP UPLOAD MODAL ========== -->
<div class="modal fade" id="ktpModal" tabindex="-1" aria-labelledby="ktpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ktpModalLabel">{{ $pelanggan->url_ktp ? 'Ubah' : 'Upload' }} KTP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('user.profile.ktp.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="url_ktp" class="form-label">Upload Scan KTP</label>
                        <input class="form-control" type="file" id="url_ktp" name="url_ktp" accept="image/*,.pdf" required>
                        <small class="text-muted">Ukuran maksimal 2MB. Format: JPG, PNG, JPEG, PDF.</small>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Pastikan KTP Anda jelas terbaca.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan KTP</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const PROXY_BASE_URL = '{{ url("/api") }}';

let provincesCache = null;
let citiesCache = {};

// Preview foto sebelum upload
document.getElementById('foto')?.addEventListener('change', function(e) {
    const preview = document.getElementById('preview-photo');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(this.files[0]);
    }
});

async function loadProvinces(selectElementId, selectedValue = null) {
    const select = document.getElementById(selectElementId);
    if (!select) return;
    
    select.innerHTML = '<option value="">Memuat provinsi...</option>';
    
    try {
        if (!provincesCache) {
            const response = await fetch(`${PROXY_BASE_URL}/provinces`);
            const data = await response.json();
            
            if (data.rajaongkir && data.rajaongkir.status === 'ok') {
                provincesCache = data.rajaongkir.results;
            } else {
                throw new Error('Gagal memuat provinsi');
            }
        }
        
        select.innerHTML = '<option value="">Pilih Provinsi</option>';
        provincesCache.forEach(province => {
            const option = document.createElement('option');
            option.value = province.province;
            option.textContent = province.province;
            option.dataset.provinceId = province.province_id;
            select.appendChild(option);
        });
        
        if (selectedValue && selectedValue !== '') {
            select.value = selectedValue;
            const province = provincesCache.find(p => p.province === selectedValue);
            if (province) {
                const citySelectId = selectElementId === 'propinsi1' ? 'kota1' : 
                                     (selectElementId === 'propinsi2' ? 'kota2' : 'kota3');
                const kodeposId = selectElementId === 'propinsi1' ? 'kodepos1' : 
                                  (selectElementId === 'propinsi2' ? 'kodepos2' : 'kodepos3');
                
                let savedCityValue = null;
                if (citySelectId === 'kota1') savedCityValue = '{{ old("kota1", $pelanggan->kota1) }}';
                if (citySelectId === 'kota2') savedCityValue = '{{ old("kota2", $pelanggan->kota2) }}';
                if (citySelectId === 'kota3') savedCityValue = '{{ old("kota3", $pelanggan->kota3) }}';
                
                await loadCities(province.province_id, citySelectId, kodeposId, savedCityValue);
            }
        }
        
    } catch (error) {
        console.error('Error loading provinces:', error);
        select.innerHTML = '<option value="">Error loading provinces</option>';
    }
}

async function loadCities(provinceId, citySelectId, postalCodeInputId, selectedCityName = null) {
    const citySelect = document.getElementById(citySelectId);
    const postalCodeInput = document.getElementById(postalCodeInputId);
    
    if (!citySelect) return;
    
    citySelect.disabled = true;
    citySelect.innerHTML = '<option value="">Memuat kota...</option>';
    
    try {
        if (!citiesCache[provinceId]) {
            const response = await fetch(`${PROXY_BASE_URL}/cities?province=${provinceId}`);
            const data = await response.json();
            
            if (data.rajaongkir && data.rajaongkir.status === 'ok') {
                citiesCache[provinceId] = data.rajaongkir.results;
            } else {
                throw new Error('Gagal memuat kota');
            }
        }
        
        citySelect.innerHTML = '<option value="">Pilih Kota</option>';
        citiesCache[provinceId].forEach(city => {
            const option = document.createElement('option');
            option.value = city.city_name;
            option.textContent = city.city_name;
            option.dataset.postalCode = city.postal_code;
            citySelect.appendChild(option);
        });
        
        citySelect.disabled = false;
        
        if (selectedCityName && selectedCityName !== '') {
            citySelect.value = selectedCityName;
            const selectedOption = citySelect.querySelector(`option[value="${selectedCityName}"]`);
            if (selectedOption && selectedOption.dataset.postalCode && postalCodeInput) {
                postalCodeInput.value = selectedOption.dataset.postalCode;
            }
        }
        
    } catch (error) {
        console.error('Error loading cities:', error);
        citySelect.innerHTML = '<option value="">Error loading cities</option>';
    }
}

function setupProvinceListener(provinceSelectId, citySelectId, postalCodeInputId) {
    const provinceSelect = document.getElementById(provinceSelectId);
    if (!provinceSelect) return;
    
    provinceSelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        const provinceId = selectedOption?.dataset.provinceId;
        
        if (provinceId) {
            await loadCities(provinceId, citySelectId, postalCodeInputId, null);
        } else {
            const citySelect = document.getElementById(citySelectId);
            const postalCodeInput = document.getElementById(postalCodeInputId);
            if (citySelect) {
                citySelect.innerHTML = '<option value="">Pilih Kota</option>';
                citySelect.disabled = true;
            }
            if (postalCodeInput) postalCodeInput.value = '';
        }
    });
}

function setupCityListener(citySelectId, postalCodeInputId) {
    const citySelect = document.getElementById(citySelectId);
    const postalCodeInput = document.getElementById(postalCodeInputId);
    if (!citySelect || !postalCodeInput) return;
    
    citySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.postalCode) {
            postalCodeInput.value = selectedOption.dataset.postalCode;
        }
    });
}

document.addEventListener('DOMContentLoaded', async function() {
    await loadProvinces('propinsi1', '{{ old("propinsi1", $pelanggan->propinsi1) }}');
    await loadProvinces('propinsi2', '{{ old("propinsi2", $pelanggan->propinsi2) }}');
    await loadProvinces('propinsi3', '{{ old("propinsi3", $pelanggan->propinsi3) }}');
    
    setupProvinceListener('propinsi1', 'kota1', 'kodepos1');
    setupProvinceListener('propinsi2', 'kota2', 'kodepos2');
    setupProvinceListener('propinsi3', 'kota3', 'kodepos3');
    
    setupCityListener('kota1', 'kodepos1');
    setupCityListener('kota2', 'kodepos2');
    setupCityListener('kota3', 'kodepos3');
});
</script>
@endpush