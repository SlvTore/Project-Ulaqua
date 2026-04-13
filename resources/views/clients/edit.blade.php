@extends('layouts.default')

@push('scripts')
<!-- Import Library CSS & JS Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lat = document.getElementById('latInput').value;
        var lng = document.getElementById('lngInput').value;

        var map = L.map('formMap').setView([lat, lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([lat, lng], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            var position = marker.getLatLng();
            document.getElementById('latInput').value = position.lat;
            document.getElementById('lngInput').value = position.lng;
        });

        map.on('click', function(e) {
            var newPos = e.latlng;
            marker.setLatLng(newPos);
            document.getElementById('latInput').value = newPos.lat;
            document.getElementById('lngInput').value = newPos.lng;
        });

        setTimeout(function(){
            map.invalidateSize();
        }, 500);
    });
</script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Edit Data Klien</h4>
                <span>Perbarui detail identitas klien</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Klien</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
            </ol>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger solid alert-dismissible fade show">
            <strong>Gagal!</strong> Periksa kembali form isian Anda.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Edit Data Klien</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('clients.update', $client->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label form-label-lg">Nama Klien / Instansi <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $client->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label form-label-lg">Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email', $client->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label form-label-lg">Nomor Telepon</label>
                                    <input type="text" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror" value="{{ old('phone', $client->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label form-label-lg">Alamat Lengkap</label>
                                    <textarea name="address" class="form-control form-control-lg mb-3 @error('address') is-invalid @enderror" rows="2" placeholder="Masukkan detail alamat">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Field Hidden Menyimpan Pilihan User -->
                                    <input type="hidden" name="latitude" id="latInput" value="{{ old('latitude', -6.914744) }}">
                                    <input type="hidden" name="longitude" id="lngInput" value="{{ old('longitude', 107.609810) }}">

                                    <!-- Komponen Peta -->
                                    <label class="form-label form-label-lg mt-2">Geser Pin Untuk Menentukan Titik Lokasi Peta (Opsional)</label>
                                    <div id="formMap" class="w-100 rounded" style="height: 250px; z-index:1;"></div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary d-inline-block rounded-square"><i class="fa fa-save me-2"></i> Perbarui Data</button>
                                <a href="{{ route('clients.index') }}" class="btn btn-danger light d-inline-block rounded-square"><i class="fa fa-times me-2"></i> Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
