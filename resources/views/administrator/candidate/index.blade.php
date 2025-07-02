@extends('layouts.main')

@section('content')

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table zero-configuration" width="100%" data-url={{ route('apps.candidates.get-data')}} id="dataTables"></table>
            </div>
        </div>
    </div>

@endsection
