@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('apps.schedules.update', $candidate) }}">
                    @csrf
                    <div class="mt-1">
                        <ul class="mb-0">
                            <li>
                                <strong>Nama Kandidat:</strong> <br>
                                <p class="fw-bold fs-16 mb-2">{{ $candidate->user->name }}</p>
                            </li>
                            <li>
                                <strong>Posisi Yang Dilamar:</strong> <br>
                                <p class="fw-bold fs-16 mb-2">{{ $candidate->jobVacancy->title }}</p>
                            </li>
                            <li>
                                <strong>Penempatan:</strong> <br>
                                <p class="fw-bold fs-16 mb-2">{{ $candidate->jobVacancy->placement }}</p>
                            </li>
                            @if($candidate->document?->cv)
                                <li>
                                    <strong>CV:</strong> <br>
                                    <a href="{{ asset('storage/files/documents/' . $candidate->document->cv) }}" download class="text-decoration-none">
                                        Download CV
                                        <i class="ti ti-download ms-1"></i>
                                    </a>
                                </li>
                            @endif

                            @if($candidate->document?->cover_letter)
                                <li class="mt-2">
                                    <strong>Surat Lamaran:</strong> <br>
                                    <a href="{{ asset('storage/files/documents/' . $candidate->document->cover_letter) }}" download class="text-decoration-none">
                                        Download Surat Lamaran
                                            <i class="ti ti-download ms-1"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <hr>
                    @php
                        $fields = [
                            'ethics' => 'Nilai Etika',
                            'discipline' => 'Nilai Kedisiplinan',
                            'accuracy' => 'Nilai Ketepatan Menjawab',
                            'cv' => 'Nilai Curriculum Vitae (CV)'
                        ];
                    @endphp
                    @foreach ($fields as $name => $label)
                    <div class="row mb-3 align-items-start flex-md-row flex-column">
                        <div class="col-md-4 col-sm-12 mb-2 mb-md-0">
                            <label for="{{ $name }}" class="col-form-label">{{ $label }}</label>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-2 mb-md-0">
                            <input type="text" name="{{ $name }}" id="{{ $name }}"
                                class="form-control numeric @error($name) is-invalid @enderror"
                                value="{{ old($name, $criteria->$name ?? null) }}">
                            @error($name)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <span class="form-text">Nilai 1 - 100.</span>
                        </div>
                    </div>

                    @endforeach

                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="statusAccept" value="Accept" {{ old('status', $candidate->status) == 'Accept' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusAccept">Diterima</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="statusReject" value="Reject" {{ old('status', $candidate->status) == 'Reject' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusReject">Tolak</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="statusConsider" value="Consider" {{ old('status', $candidate->status) == 'Consider' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusConsider">Dipertimbangkan</label>
                    </div>
                    @error('status')
                        <div class="form-text text-danger d-block">{{ $message }}</div>
                    @enderror
                    <hr>
                    <div class="text-end">
                            <a href="{{ route('apps.schedules') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-2"></i>Simpan</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
