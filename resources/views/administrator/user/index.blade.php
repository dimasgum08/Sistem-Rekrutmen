@extends('layouts.main')

@section('content')

@can('create-users')
    <div class="col-12 text-end mb-3">
        <a href="{{ route('apps.users.create') }}" class="btn btn-primary"><i class="ti ti-plus me-2"></i>Tambah Pengguna</a>
    </div>
    @endcan

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table zero-configuration" width="100%" data-url={{ route('apps.users.get-data')}} id="dataTables"></table>
            </div>
        </div>
    </div>
@endsection
