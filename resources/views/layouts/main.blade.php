@extends('layouts.app')

@section('main')

    @if (getInfoLogin()->roles[0]->name == 'Admin')
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    @if (isset($breadcrumbs))
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                @foreach ($breadcrumbs as $item)
                                    @if (isset($item['is_active']) && $item['is_active'])
                                        <li class="breadcrumb-item active">{{ $item['title'] }}</li>
                                    @else
                                        <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">{{ $title ?? '' }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 breadcrumb-vertical">
            <h5 class="mb-0 fw-semibold text-primary">{{ $title ?? 'Halaman' }}</h5>
            @if (isset($breadcrumbs))
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    @foreach ($breadcrumbs as $item)
                        @if (isset($item['is_active']) && $item['is_active'])
                            <li class="breadcrumb-item active">{{ $item['title'] }}</li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>
            @endif
        </div>
    @endif

    @yield('content')

@endsection
