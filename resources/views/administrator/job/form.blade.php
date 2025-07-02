@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Posisi Lowongan <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $jobVacancy->title ?? '') }}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Tanggal Dibuka <span class="text-danger">*</span></label>
                                    <input type="text" name="date" id="date" class="form-control flatpickr @error('date') is-invalid @enderror" data-range value="{{ old('date', $date ?? '') }}" autocomplete="off">
                                    @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="placement" class="form-label">Penempatan <span class="text-danger">*</span></label>
                            <input type="text" name="placement" id="placement" class="form-control @error('placement') is-invalid @enderror" value="{{ old('placement', $jobVacancy->placement ?? '') }}">
                            @error('placement')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Deskripsi Lowongan <span class="text-danger">*</span></label>
                            <textarea name="content" id="" class="form-control @error('content') is-invalid @enderror ckeditor">{!! old('content', $jobVacancy->content ?? '') !!}</textarea>
                            @error('content')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_posted" role="switch" id="switchCheckDefault" {{ old('is_posted', $jobVacancy->is_posted ?? '') ? 'checked' : '' }}>
                            <label class="form-check-label" for="switchCheckDefault">Posting</label>
                        </div>
                        <hr>
                        <div class="text-end">
                            <a href="{{ route('apps.job-vacancies') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-2"></i>Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
