if (typeof __initDataTable == 'undefined') {
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
            title: 'Posisi Pekerjaan',
            data: 'title',
            name: 'title',
        },
        {
            title: 'Penempatan',
            data: 'placement',
            name: 'placement',
        },
        {
            title: 'Tanggal',
            data: null,
            name: 'date_posted',
            render: function (data, type, row) {
                return row.date_posted + ' - ' + row.deadline;
            }
        },
        {
            title: 'Status',
            data: 'is_posted',
            name: 'is_posted',
            mRender: (data, type, row, meta) => {
                if (data == 1) {
                    return `<span class="badge bg-success">Di Posting</span>`
                } else {
                    return `<a href="#" class="badge bg-warning" data-toggle="posted" data-id="${row.hashid}"><i class="ti ti-pencil"></i> Draft</a>`
                }
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

                // if(PERMISSIONS.includes('update-users')) {
                render += `<a href="${BASE_URL}/apps/job-vacancies/${data}/edit" class="btn btn-sm btn-outline-primary btn-square mx-1 me-2 my-2" title="Edit"><i class="ti ti-pencil"></i></a>`
                // }

                // if(PERMISSIONS.includes('delete-users') && row?.roles[0]?.name != 'Admin') {
                render += `<button type="button" class="btn btn-sm mx-1 btn-outline-primary btn-square my-2 me-2" data-toggle="delete" title="Hapus" data-id="${data}"><i class="ti ti-trash"></i></button>`
                // }

                return render
            }
        }
    ],
    callback: () => {
        $('button[data-toggle="delete"]').unbind().on('click', function (e) {
            e.preventDefault()
            confirmDelete({
                title: 'Hapus?',
                message: 'Apakah Anda yakin ingin menghapus data ini?',
                url: `${BASE_URL}/apps/job-vacancies/${$(this).data('id')}/delete`,
                method: 'delete',
                confirmButtontext: 'Ya, Saya yakin!',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                }
            })
        });

        $('a[data-toggle="posted"]').unbind().on('click', function (e) {
            e.preventDefault();
            const hashid = $(this).data('id');
            Swal.fire({
                title: 'Posting Lowongan?',
                text: "Lowongan ini akan ditampilkan ke publik.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#08428C',
                cancelButtonColor: '#6e7881',
                confirmButtonText: 'Ya, Posting Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${BASE_URL}/apps/job-vacancies/${hashid}/posted`, {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ is_posted: 1 })
                    }).then(response => response.json()).then(data => {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data berhasil diposting.",
                            icon: "success",
                            timer: 2000
                        });

                        if (typeof window._dataTables !== 'undefined' && window._dataTables !== null) {
                            window._dataTables.ajax.reload(null, false);
                        }
                    }).catch(error => {
                        Swal.fire({
                            title: "Error!",
                            text: error.message || "Terjadi kesalahan saat posting data.",
                            icon: "error"
                        });
                    });
                }
            })
        });
    }
})

function showJobDetail(e, el) {
    e.preventDefault();

    const $el = $(el);

    if (window.innerWidth < 768) {
        const slug = $el.data('slug');
        window.location.href = `${BASE_URL}/apps/job-vacancies/${slug}/detail`;
        return;
    }

    const title = $el.data('title');
    const content = $el.data('content');
    const applyUrl = $el.data('apply-url');
    const isApply = $el.data('is-apply') === 1 || $el.data('is-apply') === "1";
    const $applyBtn = $('#applyButton');
    const isExpired = $el.data('expired') === 1 || $el.data('expired') === "1";

    $('#jobPlaceholder').addClass('d-none');
    $('#jobDetail').removeClass('d-none');
    $('#jobTitle').text(title);
    $('#jobContent').html(strip_tags(content));
    $('#uploadForm').attr('action', applyUrl);
    $('#jobVacancyId').val($el.data('id'));

   if (isExpired) {
        $applyBtn.addClass('d-none');
    } else {
        $applyBtn.removeClass('d-none');

        if (isApply) {
            $applyBtn.addClass('disabled')
                .html('<i class="ti ti-check"></i> Sudah Dilamar')
                .removeAttr('data-bs-toggle')
                .removeAttr('data-bs-target');
        } else {
            $applyBtn.removeClass('disabled')
                .html('<i class="ti ti-send"></i> Lamar Sekarang')
                .attr('data-bs-toggle', 'modal')
                .attr('data-bs-target', '#uploadModal');
        }
    }

    $('#jobList .list-group-item').removeClass('active');
    $el.addClass('active');
}


$(document).ready(function () {
    $('#applyJob').on('click', function () {
        const applyUrl = $(this).data('apply-url');
        $('#uploadForm').attr('action', applyUrl);
    });


});

