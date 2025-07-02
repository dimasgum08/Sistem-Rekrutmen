if(typeof __initDataTable == 'undefined') {
    let __initDataTable
}

__initDataTable = initDataTable({
    url: $('#dataTables').data('url'),
    element: '#dataTables',
    table: [
        {
            title: 'No',
            data: null,
            name: null,
            searchable: false,
            orderable: false,
            width: '5%',
            mRender: (data, type, row, meta) => {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            title: 'Nama',
            data: 'name',
            name: 'name',
            mRender: (data, type, row) => {
                return `
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 40px;height: 40px;border-radius: 50%;overflow: hidden">
                            <img src="${ row.image == null ? `https://ui-avatars.com/api/?background=random&name=${ data }` : row.image }" width="100%">
                        </div>
                        <div>
                            <strong>${data}</strong>
                        </div>
                    </div>
                `
            }
        },
        {
            title: 'Email',
            data: 'email',
            name: 'email'
        },
        {
            title: 'Role',
            data: null,
            name: 'id',
            mRender: (data, type, row, meta) => {
                return row?.roles ? row?.roles[0]?.display_name : '-'
            }
        },
        {
            title: '',
            data: 'hashid',
            name: 'id',
            searchable: false,
            orderable: false,
            sClass: 'text-center nowrap',
            mRender: (data, type, row, meta) => {
                var render = ``

                if(PERMISSIONS.includes('update-users')) {
                    render += `<a href="${ BASE_URL }/apps/users/${data}/edit" class="btn btn-sm btn-outline-primary btn-square mx-1" title="Edit"><i class="ti ti-pencil"></i></a>`
                }

                if(PERMISSIONS.includes('delete-users') && row?.roles[0]?.name != 'Admin') {
                    render += `<button type="button" class="btn btn-sm mx-1 btn-outline-primary btn-square" data-toggle="delete" title="Hapus" data-id="${data}"><i class="ti ti-trash"></i></button>`
                }

                return render
            }
        }
    ],
    callback: () => {
        $('button[data-toggle="delete"]').unbind().on('click', function(e) {
            e.preventDefault()
            confirmDelete({
                title: 'Hapus?',
                message: 'Apakah Anda yakin ingin menghapus data ini?',
                url: `${ BASE_URL }/apps/users/${$(this).data('id')}/delete`,
                method: 'delete',
                confirmButtontext: 'Ya, Saya yakin!',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            })
        })
    }
})


$(document).ready(function() {
    // Toggle password visibility
    $('[data-toggle="toggle-password"]').on('click', function() {
        var passwordInput = $(this).closest('.input-group').find('input');
        var icon = $(this).find('i');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('ti ti-eye').addClass('ti ti-eye-off');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('ti ti-eye-off').addClass('ti ti-eye');
        }
    });

    $('[data-toggle="show-image"]').on('click', function () {
        var imagePath = $(this).data('url');
        console.log(imagePath);
        var modalHtml = `
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Preview Foto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalImage" src="${imagePath}" alt="Foto" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHtml);
        $('#imageModal').modal('show');
        $('#imageModal').on('hidden.bs.modal', function () {
            $(this).remove();
        });
    });


   $('#toggle-applicant').change(function () {
        if ($(this).is(':checked')) {
            $('#applicant_form').fadeIn(); // cukup ini
        } else {
            $('#applicant_form').fadeOut(); // cukup ini
        }
    });

    // Saat halaman pertama kali load
    if ($('#toggle-applicant').is(':checked')) {
        $('#applicant_form').show(); // ini tidak perlu animasi
    } else {
        $('#applicant_form').hide();
    }

});
