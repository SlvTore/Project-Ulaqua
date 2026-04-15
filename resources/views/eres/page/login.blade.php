@extends('layouts.fullwidth')

@section('content')
    <div class="col-md-6">
        <div class="authincation-content">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <div class="auth-form">
                        <div class="text-center mb-3">
                            <a href="{{url('index')}}"><img src="{{ asset('images/logo-ulaqua.png') }}" alt="" style="max-width: 200px;"></a>
                        </div>
                        <h4 class="text-center mb-4">Sign in your account</h4>
                        <!-- Pastikan method-nya POST dan action mengarah ke rute 'login' bawaan Laravel -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf <!-- Token keamanan (Wajib) -->

                            <div class="mb-3">
                                <label class="mb-1"><strong>Email</strong></label>
                                <!-- Ubah input name menjadi 'email' -->
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="Masukkan email Anda">

                                <!-- Jika ada error login, tampilkan di sini -->
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="mb-1"><strong>Password</strong></label>
                                <!-- Ubah input name menjadi 'password' -->
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row d-flex justify-content-between mt-4 mb-2">
                                <div class="mb-3">
                                    <div class="form-check custom-checkbox ms-1">
                                        <!-- Checkbox untuk Remember Me -->
                                        <input type="checkbox" name="remember" class="form-check-input" id="basic_checkbox_1" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="basic_checkbox_1">Ingat Saya</label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <!-- Tombol submit login -->
                                <button type="submit" class="btn btn-primary btn-block">Masuk ke Sistem</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

