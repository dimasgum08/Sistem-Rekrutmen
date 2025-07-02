@extends('layouts.base')

@section('app')
<div class="auth-main">
    <div class="auth-wrapper v1">
        <div class="auth-form">
            <div class="card my-5">
                <div class="card-body">
                    <div class="text-center mb-2">
                        <h4 class="fw-bold text-primary">PT Al-Falah Banyuwangi</h4>
                    </div>
                    <p class="text-center text-muted mb-4">Silahkan login untuk melanjutkan</p>
                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" placeholder="Alamat Email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror">
                                <button class="btn btn-outline-primary toggle-password" type="button">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                <i class="ti ti-login me-2"></i> Login
                            </button>
                        </div>
                    </form>

                    <div class="d-flex justify-content-between align-items-end mt-4">
                        <h6 class="fw-bold mb-0">Belum punya akun?</h6>
                        <a href="{{ route('auth.register') }}" class="text-primary">Buat Akun</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
