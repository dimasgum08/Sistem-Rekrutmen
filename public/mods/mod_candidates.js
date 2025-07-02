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
            data: 'user.name',
            name: 'name',
            mRender: (data, type, row) => {
                return `
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 40px;height: 40px;border-radius: 50%;overflow: hidden">
                            <img src="${ row.user.image == null ? `https://ui-avatars.com/api/?background=random&name=${ data }` : row.user.image }" width="100%">
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">${data}</h5>
                            <p class="text-muted mb-0">${row.user.email}</p>
                        </div>
                    </div>
                `
            }
        },
        {
            title: 'Lowongan Kerja',
            data: 'job_vacancy.title',
            name: 'title',
        },
        {
            title: 'Status',
            data: 'status',
            name: 'status',
           mRender: (data, type, row) => {
                const statusMap = {
                    Process: { label: 'Menunggu', class: 'bg-warning' },
                    Interview: { label: 'Interview', class: 'bg-info' },
                    Accept: { label: 'Diterima', class: 'bg-success' },
                    Reject: { label: 'Ditolak', class: 'bg-danger' },
                    Consider: { label: 'Dipertimbangkan', class: 'bg-warning' },
                };

                const status = statusMap[data] || { label: data, class: 'bg-secondary' };

                return `<span class="badge ${status.class}">${status.label}</span>`;
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

                // if(PERMISSIONS.includes('delete-users') && row?.roles[0]?.name != 'Admin') {
                    render += `<a href="${ BASE_URL }/apps/candidates/${data}/detail" class="btn btn-sm mx-1 btn-outline-primary btn-square" data-toggle="delete" title="Detail" data-id="${data}"><i class="ti ti-clipboard-check"></i></a>`
                // }

                return render
            }
        }
    ],
    callback: () => {}
})

$(function () {
    function toggleInterviewFields() {
        const selected = $('#statusModal input[name="status"]:checked').val();
        if (selected === 'Interview') {
            $('#interviewFields').stop(true, true).slideDown();
        } else {
            $('#interviewFields').stop(true, true).slideUp();
        }
    }

    $('#statusModal').on('shown.bs.modal', function () {
        toggleInterviewFields();
    });

    $('#statusModal input[name="status"]').on('change', function () {
        toggleInterviewFields();
    });

    $('#statusModal').on('hidden.bs.modal', function () {
        const $modal = $(this);
        const $form = $modal.find('form');

        const token = $form.find('input[name="_token"]').val();

        $form[0].reset();
        $form.find('input[name="_token"]').val(token);

        $('#interviewFields').hide();

    });

    $('.btn-detail').on('click', function () {
        console.log('oi');
        const position = $(this).data('position');
        const schedule = $(this).data('schedule');
        const location = $(this).data('location');
        const placement = $(this).data('placement');
        const interviewer = $(this).data('interviewer');
        const note = $(this).data('note');

        const modalHTML = `
        <div class="modal fade" id="dynamicInterviewModal" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Jadwal Interview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Posisi:</strong> ${position}</li>
                            <li class="list-group-item"><strong>Penempatan:</strong> ${placement}</li>
                            <li class="list-group-item"><strong>Jadwal:</strong> ${schedule}</li>
                            <li class="list-group-item"><strong>Lokasi Interview:</strong> ${location}</li>
                            <li class="list-group-item"><strong>Interviewer:</strong> ${interviewer}</li>
                            <li class="list-group-item"><strong>Catatan:</strong> ${note}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        `;

        $('body').append(modalHTML);

        $('#dynamicInterviewModal').modal('show');
    });
});
