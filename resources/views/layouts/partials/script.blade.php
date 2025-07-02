<script src="{{ asset('assets/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{ asset('assets/js/apexcharts.js')}}"></script>
<script src="{{ asset('assets/plugins/popper.min.js')}}"></script>
<script src="{{ asset('assets/plugins/simplebar.min.js')}}"></script>
<script src="{{ asset('assets/js/lord-icon-2.1.0.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/plugins/filepond/filepond.min.js')}}"></script>
<script src="{{ asset('assets/plugins/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js')}}"></script>
<script src="{{ asset('assets/js/datatables.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js')}}"></script>
<script src="{{ asset('assets/plugins/choices.js/choices.min.js')}}"></script>
<script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('assets/js/form-editor.init.js')}}"></script>
<script src="{{ asset('assets/plugins/@ckeditor/ckeditor5-build-classic/build/ckeditor.js')}}"></script>
<script src="{{ asset('assets/js/pace.min.js')}}"></script>
<script src="{{ asset('assets/js/script.js')}}"></script>
<script src="{{ asset('assets/js/custom.js')}}"></script>

@if (isset($mods))
    @if (is_array($mods))
        @foreach ($mods as $mod)
            <script src="{{ asset('mods/mod_' . $mod . '.js') }}"></script>
        @endforeach
    @else
        <script src="{{ asset('mods/mod_' . $mods . '.js') }}"></script>
    @endif
@endif

<script>
    @if (Session::has('message'))
        var type = "{{ Session::get('type', 'info') }}"
        switch (type) {
            case 'info':
                toastr.options.timeOut = 5000;
                toastr.info("{{ Session::get('message') }}");
                break;
            case 'success':
                toastr.options.timeOut = 5000;
                toastr.success("{{ Session::get('message') }}");
                break;
            case 'warning':
                toastr.options.timeOut = 5000;
                toastr.warning("{{ Session::get('message') }}");
                break;
            case 'error':
                toastr.options.timeOut = 5000;
                toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif
</script>
