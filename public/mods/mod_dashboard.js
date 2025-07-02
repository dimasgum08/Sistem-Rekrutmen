$(document).ready(function () {
    $('[data-toggle="card-redirect"]').css('cursor', 'pointer').on('click', function () {
        let url = $(this).data('url');
        if (url) {
            window.location.href = url;
        }
    });
    $('[data-toggle="schedule"]').css('cursor', 'pointer').on('click', function () {
        let url = $(this).data('url');
        if (url) {
            window.location.href = url;
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
        fetch(`${ BASE_URL }/apps/get-data-job`)
            .then(response => response.json())
            .then(result => {
                const data = result.data;
                const options = {
                    chart: {
                        height: 320,
                        type: 'donut'
                    },
                    series: [data.posted, data.draft],
                    labels: ['Diposting', 'Draft'],
                    colors: ['#4680FF', '#E58A00'],
                    fill: {
                        opacity: 1
                    },
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                                labels: {
                                    show: true,
                                    name: { show: true },
                                    value: { show: true }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    responsive: [{
                        breakpoint: 575,
                        options: {
                            chart: { height: 250 },
                            legend: { position: 'bottom' },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '65%',
                                        labels: { show: false }
                                    }
                                }
                            }
                        }
                    }]
                };

                const chart = new ApexCharts(document.querySelector("#total-income-graph"), options);
                chart.render();
            })
            .catch(error => {
                console.error("Gagal mengambil data grafik:", error);
            });
    });
