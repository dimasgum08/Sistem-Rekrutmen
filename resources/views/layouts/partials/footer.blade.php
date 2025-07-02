@if (getInfoLogin()->roles[0]->name == 'Admin')
<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col my-1">
                <p class="m-0">
                    &copy; {{ date('Y') }} PT AL-Falah Banyuwangi </span>
                </p>
            </div>
            <div class="col-auto my-1">
                <ul class="list-inline footer-link mb-0">
                    <li class="list-inline-item"><a href="#">Sistem Penerimaan Calon Pegawai</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer> <!-- Required Js -->

@else
<footer class="mt-auto py-3 footer-vertical bg-white shadow-sm">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0 text-muted">
                &copy; {{ date('Y') }} PT AL-Falah Banyuwangi
            </div>
            <div class="col-md-6 text-center text-md-end text-muted">
                Sistem Penerimaan Calon Pegawai
            </div>
        </div>
    </div>
</footer>

@endif

