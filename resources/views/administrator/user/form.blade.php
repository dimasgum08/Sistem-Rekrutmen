@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-xl-5 col-lg-8 col-md-12 col-sm-12 col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control password-input @error('password') is-invalid @enderror" value="">
                                        <button type="button" class="btn btn-outline-primary toggle-password"><i class="ti ti-eye"></i></button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="confirm_password" id="password_confirmation" class="form-control password-input @error('confirm_password') is-invalid @enderror" value="">
                                        <button type="button" class="btn btn-outline-primary toggle-password"><i class="ti ti-eye"></i></button>
                                    </div>
                                    @error('confirm_password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if (getInfoLogin()->roles[0]->name == 'Admin')
                        <div class="mb-3">
                            <label for="roles" class="form-label">Hak Akses <span class="text-danger">*</span></label>
                            <select name="roles" id="roles" class="form-control choices-js @error('roles') is-invalid @enderror" data-search>
                                <option value="" selected disabled>-- Pilih Hak Akses --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('roles', $user->roles[0]->name ?? '') == $role->name ? 'selected' : '' }}>{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <div class="invalid-feedback d-block" >
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        @else
                            <input type="hidden" name="roles" value="applicant">
                        @endif

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="toggle-applicant" name="is_applicant" {{ !empty($applicant) && $applicant ? 'checked' : '' }}>
                            <label class="form-check-label" for="toggle-applicant">Buat Data Pelamar</label>
                        </div>

                        <div id="applicant_form" style="display: none;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="telp" class="form-label">Nomor Telepon</label>
                                        <input type="text" name="telp" id="telp" class="form-control @error('telp') is-invalid @enderror" value="{{ old('telp', $applicant->telp ?? '') }}">
                                        @error('telp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select name="gender" id="gender" class="form-select choices-js @error('gender') is-invalid @enderror" data-search>
                                            <option value="Male" {{ old('gender', $applicant->gender ?? '') == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Female" {{ old('gender', $applicant->gender ?? '') == 'Female' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea name="address" id="address" placeholder="Alamat lengkap" class="form-control" >{{ old('address', $applicant->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="picture" class="form-label">Foto</label>
                            <input type="file" name="picture" id="picture"class="form-control filepond @error('picture') is-invalid @enderror">
                            @error('picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <div class="text-end">
                            <a href="{{ route('apps.users') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-2"></i>Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
