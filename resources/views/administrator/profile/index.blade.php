@extends('layouts.main')

@section('css')
<style>
    .profile-photo-wrapper {
    position: relative;
    display: inline-block;
    width: 200px;
    height: 200px;
}

.photo-border {
    border: 3px solid #08428C; /* Bootstrap Primary */
    border-radius: 50%;
    overflow: hidden;
    width: 100%;
    height: 100%;
}

.object-fit-cover {
    object-fit: cover;
    width: 100%;
    height: 100%;
    border-radius: 50%;
}

/* Kamera: sembunyikan default */
.camera-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    display: none;
    z-index: 2;
}

/* Tampilkan icon saat hover */
.profile-photo-wrapper:hover .camera-icon {
    display: block;
}
</style>
@endsection

@section('content')
    <form action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 col-12 text-center mb-3">
                <div class="text-center mb-3">
                    <div class="profile-photo-wrapper">
                        <div class="photo-border">
                            <img id="previewImage"
                                src="{{ getInfoLogin()->image ? asset('storage/images/users/' . getInfoLogin()->image) : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(getInfoLogin()->name) }}"
                                alt="Foto Profil" class="w-100 h-100 object-fit-cover">
                        </div>

                        <label for="photoInput" class="camera-icon">
                            <i class="ti ti-camera"></i>
                        </label>

                        <input type="file" name="image" id="photoInput" accept="image/*" class="d-none" onchange="this.form.submit()">
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Informasi Pengguna</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ getInfoLogin()->name ? getInfoLogin()->name : '' }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="telp" class="form-label">Nomor HP</label>
                                    <input type="text" name="telp" class="form-control" id="telp" value="{{ getInfoLogin()->applicant->telp ? getInfoLogin()->applicant->telp : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" id="address" rows="3">{{ getInfoLogin()->applicant->address ? getInfoLogin()->applicant->address : '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Ubah Password</h5>
                        <div class="mb-3 position-relative">
                            <label for="old_password" class="form-label">Password Lama</label>
                            <input type="password" name="old_password" class="form-control @error('old_password')
                                is-invalid
                            @enderror password-field" id="old_password">
                            <button type="button" class="btn btn-sm position-absolute top-50 end-0 me-2 toggle-password"><i class="ti ti-eye"></i></button>
                            @error('old_password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror password-field" id="new_password">
                            <button type="button" class="btn btn-sm position-absolute top-50 end-0 me-2 toggle-password"><i class="ti ti-eye"></i></button>
                            @error('new_password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror password-field" id="confirm_password">
                            <button type="button" class="btn btn-sm position-absolute top-50 end-0 me-2 toggle-password"><i class="ti ti-eye"></i></button>
                            @error('confirm_password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <hr>
                        <div class="text-end">
                            <a href="{{ route('apps.dashboard') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-2"></i>Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
       const photoInput = document.getElementById('photoInput');
        const previewImage = document.getElementById('previewImage');
        const cameraIcon = document.getElementById('cameraIcon');
        const hoverArea = document.querySelector('.hover-photo');

        hoverArea.addEventListener('mouseenter', () => {
            cameraIcon.style.display = 'block';
        });
        hoverArea.addEventListener('mouseleave', () => {
            cameraIcon.style.display = 'none';
        });

        photoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                previewImage.src = URL.createObjectURL(file);
            }
        });

    </script>
@endsection
