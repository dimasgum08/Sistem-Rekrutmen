@extends('layouts.base')

@section('app')
    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5 register">
                    <div class="card-body">
                        <div class="text-center mb-2">
                            <h4 class="fw-bold text-primary">PT Al-Falah Banyuwangi</h4>
                        </div>
                        <p class="text-center text-muted mb-4">Silahkan daftar untuk melanjutkan</p>

                        <form method="POST" action="{{ route('auth.register') }}" enctype="multipart/form-data">
                            @csrf
                            {{-- Nama & Email --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" id="name" placeholder="Nama Lengkap"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" placeholder="Alamat Email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Password & Konfirmasi Password --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Kata Sandi</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" placeholder="Password"
                                                class="form-control @error('password') is-invalid @enderror">
                                            <button class="btn btn-outline-primary toggle-password" type="button">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                placeholder="Ulangi Password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror">
                                            <button class="btn btn-outline-primary toggle-password" type="button">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Jenis Kelamin & Nomor Telepon --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label d-block">Jenis Kelamin</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender_l" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gender_l">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender_p" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gender_p">Perempuan</label>
                                        </div>
                                        @error('gender')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="telp" class="form-label">Nomor Telepon</label>
                                        <input type="text" name="telp" id="telp"
                                            placeholder="Contoh: 08xxxxxxxxxx"
                                            class="form-control @error('telp') is-invalid @enderror"
                                            value="{{ old('telp') }}">
                                        @error('telp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="form-group mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea name="address" id="address" rows="3" placeholder="Alamat lengkap"
                                    class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Foto Profil --}}
                            <div class="form-group mb-3">
                                <label for="image" class="form-label">Foto Profil</label>
                                <input type="file" name="picture" id="image"
                                    class="form-control filepond @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Submit --}}
                            <div class="d-grid mt-4">
                                <button type="submit"
                                    class="btn btn-primary d-flex align-items-center justify-content-center">
                                    <i class="ti ti-user-plus me-2"></i> Daftar
                                </button>
                            </div>
                        </form>


                        <div class="d-flex justify-content-between align-items-end mt-4">
                            <h6 class="fw-bold mb-0">Sudah punya akun?</h6>
                            <a href="{{ route('login') }}" class="text-primary">Login Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
