@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Nama</th>
                        <td>:</td>
                        <td>{{ $candidate->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>:</td>
                        <td>{{ $candidate->user->email }}</td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td>:</td>
                        <td>{{ $candidate->user->applicant->telp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>:</td>
                        <td>
                            <span class="badge
                                {{ $candidate->status === 'Process' ? 'bg-warning' :
                                ($candidate->status === 'Interview' ? 'bg-info text-dark' :
                                ($candidate->status === 'Accept' ? 'bg-success' :
                                ($candidate->status === 'Consider' ? 'bg-warning' :
                                'bg-danger'))) }}">
                                {{ $candidate->status === 'Process' ? 'Menunggu' :
                                ($candidate->status === 'Interview' ? 'Interview' :
                                ($candidate->status === 'Accept' ? 'Diterima' :
                                ($candidate->status === 'Consider' ? 'Dipertimbangkan' :
                                'Ditolak'))) }}
                            </span>

                        </td>
                    </tr>
                    <tr>
                        <th>Dilamar pada</th>
                        <td>:</td>
                        <td>{{ $candidate->created_at->locale('id')->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Penempatan</th>
                        <td>:</td>
                        <td>{{ $candidate->jobVacancy->placement }}</td>
                    </tr>
                </table>
                <hr>
                <div class="text-end">
                    <a href="{{ route('apps.candidates') }}" class="btn btn-secondary me-2">Kembali</a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#statusModal"><i class="ti ti-edit"></i> Tindak Lanjuti</button>
                </div>
            </div>
        </div>

        @if ($otherCandidate->count() > 0)
            <div class="card shadow-sm mt-4 d-none d-lg-block">
                    @include('administrator.candidate.partials.other', ['otherCandidate' => $otherCandidate])
            </div>
        @endif

    </div>
    <div class="col-lg-6">
        <div class="card document shadow-sm mb-3">
            <div class="card-body">
                <ul class="nav nav-tabs mt-3" id="docTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="cv-tab" data-bs-toggle="tab" data-bs-target="#cv" type="button" role="tab" aria-controls="cv" aria-selected="true">CV</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cover-tab" data-bs-toggle="tab" data-bs-target="#cover" type="button" role="tab" aria-controls="cover" aria-selected="false">Surat Lamaran</button>
                    </li>
                </ul>

                <div class="tab-content border rounded-bottom mt-2" id="docTabContent" style="min-height: 500px;">
                    {{-- Tab CV --}}
                    <div class="tab-pane fade show active p-2" id="cv" role="tabpanel" aria-labelledby="cv-tab">
                        @if($candidate->document?->cv)
                        <div class="document-wrapper">
                            <iframe src="{{ asset('storage/files/documents/' . $candidate->document->cv) }}#toolbar=0" width="100%" height="500px" frameborder="0"></iframe>
                        </div>
                        @else
                            <p class="text-muted">CV belum tersedia.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade p-2" id="cover" role="tabpanel" aria-labelledby="cover-tab">
                        @if($candidate->document?->cover_letter)
                        <div class="document-wrapper">
                            <iframe src="{{ asset('storage/files/documents/' . $candidate->document->cover_letter) }}#toolbar=0" width="100%" height="500px" frameborder="0"></iframe>
                        </div>
                        @else
                            <p class="text-muted">Surat lamaran belum tersedia.</p>
                        @endif
                    </div>

                </div>
                <div class="mt-3">
                    <ul class="mb-0">
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
            </div>
        </div>
    </div>

    @if ($otherCandidate->count() > 0)
    <div class="col-lg-6 d-block d-lg-none">
        <div class="card shadow-sm mt-4 ">
                @include('administrator.candidate.partials.other', ['otherCandidate' => $otherCandidate])
        </div>
    </div>
    @endif
</div>

<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('apps.candidates.update-status', $candidate->hashid) }}" id="form" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Ubah Status Pelamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex gap-3 mb-3">
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="statusAccept" value="Accept" {{ (old('status') ?? $candidate->status) === 'Accept' ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusAccept">Setujui</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="statusInterview" value="Interview" {{ (old('status') ?? $candidate->status) === 'Interview' ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusInterview">Interview</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="statusReject" value="Reject" {{ (old('status') ?? $candidate->status) === 'Reject' ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusReject">Tolak</label>
                        </div>
                    </div>
                </div>
                <div class="form-text text-danger">
                    @error('status')
                        {{ $message }}
                    @enderror
                </div>

                <div id="interviewFields" style="display: none;">
                    <div class="mb-3">
                        <label for="schedule" class="form-label">Tanggal Interview <span class="text-danger">*</span></label>
                        <input type="text" class="form-control flatpickr-datetime @error('schedule') is-invalid @enderror" name="schedule" id="schedule" value="{{ old('schedule', $interview->schedule ?? null )  }}">
                    </div>
                    <div class="form-text text-danger">
                        @error('schedule')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Lokasi Interview <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" id="location" value="{{ old('location', $interview->location ?? null )  }}">
                    </div>
                    <div class="form-text text-danger">
                        @error('location')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="interviewer" class="form-label">Interviewer</label>
                        <input type="text" class="form-control" name="interviewer" id="interviewer" value="{{ old('interviewer', $interview->interviewer ?? null )  }}">
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea class="form-control" name="note" id="note" rows="3">{{ old('note', $interview->note ?? null )  }}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection
