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
            title: 'Posisi',
            data: null,
            name: null,
            mRender: (data, type, row) => {
                return `
                <div>
                    <p class="fw-bold fs-16 mb-1">${row.job_vacancy.title}</p>
                    <p class="text-muted mb-0">Penempatan : ${row.job_vacancy.placement ?? '-'}</p>
                </div>`
            }
        },
        {
            title: 'Tanggal Interview',
            data: null,
            name: null,
            mRender: (data, type, row) => {
                return `
                <div>
                    <p class="fw-bold fs-16 mb-1">${row.interview.schedule}</p>
                    <p class="text-muted mb-0">Lokasi : ${row.interview.location ?? '-'}</p>
                </div>`
            }
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
                render += `<button class="btn btn-sm btn-outline-primary btn-square btn-detail" data-user="${row.user.name}" data-email="${row.user.email}" data-placement="${row.job_vacancy.placement}" data-position="${row.job_vacancy.title}" data-schedule="${row.interview?.schedule ?? '-'}" data-location="${row.interview?.location ?? '-'}" data-interviewer="${row.interview?.interviewer ?? '-'}" data-note="${row.interview?.note ?? '-'}"><i class="ti ti-calendar-event"></i></button>`
                // if(PERMISSIONS.includes('delete-users') && row?.roles[0]?.name != 'Admin') {
                    render += `<a href="${ BASE_URL }/apps/schedules/${data}/evaluations" class="btn btn-sm mx-1 btn-outline-primary btn-square" data-toggle="delete" title="Evaluasi" data-id="${data}"><i class="ti ti-clipboard-check"></i></a>`
                // }

                return render
            }
        }
    ],
    callback: () => {}
});

$(function () {
    $(document).on('click', '.btn-detail', function () {
        const user = $(this).data('user');
        const email = $(this).data('email');
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
                            <li class="list-group-item"><strong>Nama:</strong> ${user}</li>
                            <li class="list-group-item"><strong>Email:</strong> ${email}</li>
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
