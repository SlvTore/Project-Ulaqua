@extends('layouts.default')

@push('css')
<style>
    /* 1. Container custom untuk memposisikan avatar naik ke atas cover */
    .custom-avatar-container {
        position: relative;
        margin-top: -65px;
        z-index: 10;
        padding-left: 20px;
    }

    /* 2. Photo wrapper murni dari halaman Client tanpa campur tangan template Eres */
    .photo-wrapper {
        position: relative;
        cursor: pointer;
        width: 130px !important;
        height: 130px !important;
        min-width: 130px !important;
        flex-shrink: 0; /* WAJIB: Mencegah flexbox membuat bentuknya menjadi persegi panjang */
        overflow: hidden;
        background-color: #fff;
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        border-radius: 10px; /* Kotak membulat */
    }

    .photo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover !important;
    }

    .photo-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: 0.3s ease;
        z-index: 5; /* WAJIB: Memastikan overlay ada di lapisan teratas di atas placeholder/gambar */
    }

    .photo-wrapper:hover .photo-overlay {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Aplikasi</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Profil</a></li>
        </ol>
    </div>

    <!-- SEMUA DIBUNGKUS DALAM SATU FORM AGAR FOTO IKUT TERKIRIM -->
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <!-- HEADER COVER -->
            <div class="col-lg-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="photo-content ">
                            <div class="cover-photo rounded"></div>
                        </div>
                        <div class="profile-info">

                            <!-- Bagian Foto dengan Hover Effect (Versi Profile Client) -->
                            <div class="profile-photo me-5">
                                <!-- Klik pada kotak ini akan men-trigger profileUpload -->
                                <div class="photo-wrapper rounded" onclick="document.getElementById('profileUpload').click()">
                                    @if(Auth::check() && Auth::user()->avatar)
                                        <!-- Jika user sudah punya foto, tampilkan fotonya -->
                                        <img id="avatarPreview" src="{{ Auth::user()->avatar_url }}" width="130" height="130" style="object-fit: cover !important; width: 100%; height: 100%;" alt="Avatar">
                                    @else
                                        <!-- Jika belum, tampilkan frame placeholder ikon -->
                                        <div id="avatarPlaceholder" class="bg-primary d-flex align-items-center justify-content-center text-white" style="width: 100%; height: 100%;">
                                            <i class="flaticon-381-user-9 fa-4x"></i>
                                        </div>
                                        <!-- Image tag tersembunyi yang akan muncul otomatis saat user memilih file -->
                                        <img id="avatarPreview" src="" width="250" height="250" style="object-fit: cover !important; width: 100%; height: 100%; display: none;" alt="Avatar">
                                    @endif

                                    <!-- Overlay Kamera saat di-hover -->
                                    <div class="photo-overlay">
                                        <i class="las la-camera fa-3x text-white"></i>
                                    </div>
                                </div>
                                <!-- Input aslinya HANYA SATU file d-none -->
                                <input type="file" id="profileUpload" name="avatar" class="d-none" accept="image/*" onchange="previewImage(event)">
                            </div>

                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h4 class="text-primary mb-0">{{ Auth::check() ? Auth::user()->name : 'Nama Pengguna' }}</h4>
                                    <p>{{ Auth::check() ? (Auth::user()->roles->first()->name ?? 'Pengguna') : 'Peran' }}</p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0">{{ Auth::check() ? Auth::user()->email : 'email@contoh.com' }}</h4>
                                    <p>Email</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- BIODATA FORM -->
            <div class="col-xl-12">
                <!-- Pesan Sukses/Error (Akan menyesuaikan grid dengan baik) -->
                @if(session('success'))
                    <div class="alert alert-success solid alert-dismissible fade show">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger solid alert-dismissible fade show">
                        <strong>Gagal!</strong> Tolong periksa form Anda.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="fs-20 font-w600 text-primary">Detail Pribadi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                <label class="form-label font-w600">Nama Depan<span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="first_name" value="{{ Auth::check() ? Auth::user()->name : '' }}" placeholder="Masukkan nama depan Anda" required>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                <label class="form-label font-w600">Nama Belakang</label>
                                <input type="text" class="form-control" name="last_name" value="{{ Auth::check() ? Auth::user()->last_name : '' }}" placeholder="Masukkan nama belakang Anda">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                <label class="form-label font-w600">Alamat Email<span class="text-danger ms-1">*</span></label>
                                <input type="email" class="form-control bg-light" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" readonly>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                <label class="form-label font-w600">No. Handphone</label>
                                <input type="text" class="form-control" name="phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}" placeholder="Contoh: 08123456789">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                <label class="form-label font-w600">Jenis Kelamin</label>
                                <select class="form-control default-select form-select" name="gender">
                                    <option value="" {{ (Auth::check() && empty(Auth::user()->gender)) ? 'selected' : '' }} disabled>Pilih salah satu</option>
                                    <option value="Male" {{ (Auth::check() && Auth::user()->gender == 'Male') ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Female" {{ (Auth::check() && Auth::user()->gender == 'Female') ? 'selected' : '' }}>Perempuan</option>
                                    <option value="Other" {{ (Auth::check() && Auth::user()->gender == 'Other') ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                <label class="form-label font-w600">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="dob" value="{{ Auth::check() ? Auth::user()->dob : '' }}">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                <label class="form-label font-w600">Gelar / Kualifikasi</label>
                                <input type="text" class="form-control" name="degree" value="{{ Auth::check() ? Auth::user()->degree : '' }}" placeholder="mis. S1 Keperawatan">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                <label class="form-label font-w600">Jabatan / Peran</label>
                                <input type="text" class="form-control" name="designation" value="{{ Auth::check() ? Auth::user()->designation : '' }}" placeholder="mis. Admin Data">
                            </div>

                            <div class="col-xl-12 mb-3">
                                <label class="form-label font-w600">Alamat Lengkap</label>
                                <textarea class="form-control" name="address" rows="3" placeholder="Masukkan alamat lengkap Anda">{{ Auth::check() ? Auth::user()->address : '' }}</textarea>
                            </div>

                            <div class="col-xl-12 mb-3">
                                <label class="form-label font-w600">Tentang Saya</label>
                                <textarea class="form-control" name="about" rows="4" placeholder="Ceritakan singkat tentang diri Anda...">{{ Auth::check() ? Auth::user()->about : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- EXTRAS: Education & Experience -->
                <div class="card" style="margin-bottom: 30px;">
                    <div class="card-header border-0 pb-0">
                        <h4 class="fs-20 font-w600 text-primary">Pengalaman & Pendidikan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 mb-3">
                                <label class="form-label font-w600">Latar Belakang Pendidikan</label>
                                <textarea class="form-control" name="education" rows="3" placeholder="Contoh: S1 Biologi di ITB (2014)&#10;SMA Negeri 1 Jakarta (2010)">{{ Auth::check() ? Auth::user()->education : '' }}</textarea>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <label class="form-label font-w600">Pengalaman Kerja</label>
                                <textarea class="form-control" name="experience" rows="3" placeholder="Contoh: Asisten Lab di RS Mitra (2018-Sekarang)&#10;Staf Administrasi di Klinik Sehat (2015-2018)">{{ Auth::check() ? Auth::user()->experience : '' }}</textarea>
                            </div>
                            <div class="col-xl-12 text-end">
                                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-save me-2"></i> Perbarui dan Simpan Seluruh Data</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Penanganan preview file di browser pengguna sebelum diupload
    function previewImage(event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var previewId = document.getElementById('avatarPreview');
                previewId.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

