@php
    $controller = DzHelper::controller();
    $page = $action = DzHelper::action();
    $action = $controller.'_'.$action;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>

	   <!-- Title -->
	<title>{{ config('dz.name') }} | @yield('title', $page_title ?? '')</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta name="keywords" content="admin dashboard, admin template, administration, analytics, bootstrap, disease, doctor, elegant, health, hospital admin, medical dashboard, modern, responsive admin dashboard">
	<meta name="description" content="@yield('page_description', $page_description ?? '')">

	<meta property="og:title" content="ERES - Hospital Admin Dashboard Bootstrap Laravel Templates">
	<meta property="og:description" content="{{ config('dz.name') }} | @yield('title', $page_title ?? '')">
	<meta property="og:image" content="https://eres.dexignzone.com/laravel/social-image.png">
	<meta name="format-detection" content="telephone=no">
	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Favicon icon -->

	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png')}}">
	@if(!empty(config('dz.public.pagelevel.css.'.$action)))
		@foreach(config('dz.public.pagelevel.css.'.$action) as $style)
			<link href="{{ asset($style) }}" rel="stylesheet" type="text/css"/>
		@endforeach
	@endif

	{{-- Global Theme Styles (used by all pages) --}}
	@if(!empty(config('dz.public.global.css')))
		@foreach(config('dz.public.global.css') as $style)
			<link href="{{ asset($style) }}" rel="stylesheet" type="text/css"/>
		@endforeach
	@endif

</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{url('index')}}" class="brand-logo">
             <img src="{{ asset('images/logo-ulaqua.png') }}" alt="Ulaqua Logo" style="max-height: 48px; width: auto; max-width: 100%;">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

		<!--**********************************
            Header start
        ***********************************-->
		@include('elements.header')

        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
		@include('elements.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->

		<!--**********************************
            Content body start
        ***********************************-->
        @php
            $body_class = '';
            if($page == 'ui_button'){ $body_class = 'btn-page';}
            if($page == 'ui_badge'){ $body_class = 'badge-demo';}
        @endphp
		<div class="content-body  {{ $body_class }}">
			@yield('content')
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        @stack('modals')
        <!--**********************************
            Footer start
        ***********************************-->
        @include('elements.footer')
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    @if(!empty(config('dz.public.global.js.top')))
        @foreach(config('dz.public.global.js.top') as $script)
            <script src="{{ asset($script) }}" type="text/javascript"></script>
        @endforeach
    @endif
    @if(!empty(config('dz.public.pagelevel.js.'.$action)))
        @foreach(config('dz.public.pagelevel.js.'.$action) as $script)
            <script src="{{ asset($script) }}" type="text/javascript"></script>
        @endforeach
    @endif
    @if(!empty(config('dz.public.global.js.bottom')))
        @foreach(config('dz.public.global.js.bottom') as $script)
            <script src="{{ asset($script) }}" type="text/javascript"></script>
        @endforeach
    @endif

    <!-- SWEETALERT2 DARI CDN (Berjaga-jaga jika template Eres belum memuatnya secara global) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- PELINDUNG ANTI DOUBLE-SUBMIT & SWEETALERT GLOBAL -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // 1. Anti Double-Submit HANYA untuk Form biasa (Create/Update), BUKAN Form Delete
            document.querySelectorAll('form:not(.delete-form)').forEach(function(form) {
                form.addEventListener('submit', function() {
                    let submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn && !this.classList.contains('no-disable')) {
                        submitBtn.setAttribute('disabled', 'disabled');
                        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memproses...';
                    }
                });
            });

            // 2. Intersepsi SWEETALERT Khusus untuk Form Hapus / Batal
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Hentikan form sementara waktu

                    // Ambil teks peringatan dari atribut HTML
                    let message = this.getAttribute('data-confirm-message') || 'Apakah Anda yakin ingin menghapus data ini?';

                    Swal.fire({
                        title: 'Konfirmasi Tindakan',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745', // Hijau (Lanjut)
                        cancelButtonColor: '#dc3545',  // Merah (Batal)
                        confirmButtonText: '<i class="fa fa-check"></i> Ya, Lanjutkan!',
                        cancelButtonText: '<i class="fa fa-times"></i> Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // JIKA DIKLIK YA DI SWEETALERT: Baru ubah tombol jadi loading dan submit form
                            let submitBtn = this.querySelector('button[type="submit"]');
                            if (submitBtn) {
                                submitBtn.setAttribute('disabled', 'disabled');
                                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menghapus...';
                            }
                            this.submit(); // Lanjutkan penghapusan Data
                        }
                        // Jika batal, maka tidak akan ada tombol muter / sistem berhenti dan kembali semula.
                    });
                });
            });

        });
    </script>

    <!-- TAMBAHKAN KODE INI DI SINI -->
    @stack('scripts')

</body>
</html>


