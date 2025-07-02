<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="uploadForm" enctype="multipart/form-data" action="" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload CV Anda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="jobVacancyId" name="job_vacancy_id">
                        <div class="mb-3">
                            <label for="cv_document" class="form-label">CV (PDF)</label>
                            <input type="file" class="form-control @error('cv_document') is-invalid @enderror filepond" name="cv_document" id="cv_document">
                            @error('cv_document')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cover_letter_document" class="form-label">Surat Lamaran (PDF)</label>
                            <input type="file" class="form-control filepond @error('cover_letter_document') is-invalid @enderror" name="cover_letter_document" id="cover_letter_document">
                            @error('cover_letter_document')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
