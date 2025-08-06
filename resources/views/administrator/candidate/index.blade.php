@extends('layouts.main')

@section('content')


    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="mb-3 ">
                <label for="status">Semua Status </label>
                <select name="status" class="form-control form-select" data-toggle="filter">
                    <option value="">Semua</option>
                    <option value="Reject">Ditolak</option>
                    <option value="Accept">Diterima</option>
                    <option value="Process">Proses</option>
                    <option value="Interview">Interview</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table zero-configuration" width="100%" data-url={{ route('apps.candidates.get-data')}} id="dataTables"></table>
            </div>
        </div>
    </div>

@endsection
