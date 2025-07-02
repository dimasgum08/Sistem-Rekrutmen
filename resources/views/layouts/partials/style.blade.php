<link rel="icon" href="{{ asset('assets/images/logo.jpg')}}" type="image/x-icon">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css')}}" id="main-font-link" />
<link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css')}}" >
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css')}}" >
<link rel="stylesheet" href="{{ asset('assets/css/pace-theme-minimal.css')}}" >
<link rel="stylesheet" href="{{ asset('assets/plugins/filepond/filepond.min.css')}}" >
<link rel="stylesheet" href="{{ asset('assets/plugins/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}" >
<link href="{{ asset('assets/plugins/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/css/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/toastr.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/plugins/choices.js/choices.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/style.css')}}" id="main-style-link" >
<link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}" id="main-style-link" >
<script>
    const BASE_URL = "{{ url('/') }}"
    const ASSET_URL = "{{ asset('/') }}"
    var CSRF_TOKEN = "{{ csrf_token() }}"
    var PERMISSIONS = '{!! getAuthPermissions() !!}'.split(',')
    var ROLES = '{{ auth()->user() ? collect(auth()->user()->getRoleNames())->join(",") : '' }}'.split(',')
</script>
