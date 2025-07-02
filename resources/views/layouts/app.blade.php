@extends('layouts.base')

@section('app')

    @if (getInfoLogin()->roles[0]->name == 'Admin')
        @include('layouts.partials.side-nav')
    @endif

    @include('layouts.partials.top-nav')

    @if (getInfoLogin()->roles[0]->name == 'Admin')
        <div class="pc-container">
            <div class="pc-content">
                @yield('main')
            </div>
        </div>
    @else
    <div class="vertical-layout">
        <div class="content-content">
            <div class="container my-3">
                @yield('main')
            </div>
        </div>
    </div>
    @endif

    @include('layouts.partials.footer')

@endsection
