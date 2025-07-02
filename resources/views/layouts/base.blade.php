<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title ?? '-' }} - Sistem Penerimaan Calon Pegawai</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistem Penerimaan Calon Pegawai">
    <meta name="keywords" content="sipcapeg, pegawai, calon pegawai, banyuwangi, al-falah">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.partials.style')
    @yield('css')
</head>
<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">

   <div class="loader-bg" id="page-loader">
        <div class="loader-bounce">
            <div class="bounce-circle"></div>
            <div class="bounce-circle"></div>
            <div class="bounce-circle"></div>
        </div>
    </div>

    @yield('app')

    @include('layouts.partials.script')
    @yield('js')
</body>

</html>
