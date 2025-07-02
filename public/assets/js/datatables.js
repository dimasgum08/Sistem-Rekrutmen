if (typeof initDataTable == 'undefined') {
    let initDataTable;
}

initDataTable = (tableData) => {
    var dataElement = tableData;
    var element = dataElement.element;
    var callback = dataElement.callback;
    var addOptions = dataElement.options ?? {};

    if (!$.fn.DataTable.isDataTable(element)) {}

    var opt = {
        processing: true,
        serverSide: true,
        ajax: {
            url: dataElement.url,
            method: 'GET',
        },
        columns: dataElement.table,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100],
            [10 + " ", 25 + " ", 50 + " ", 100 + " "]
        ],
        language: {
            sLengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        },
        order: [0, 'desc'],
        ...addOptions,
    }

    var table = $(element).DataTable(opt);

    table.on('draw.dt', function () {

        $('.dt-search').on('keyup change', function(e) {
            table.search($(this).val()).draw();
        });

        $('.dt-filter').unbind().on('change', function(e) {
            var params = ``;

            $('.dt-filter').each((key, val) => {
                params += `${$(val).attr('name')}=${$(val).val()}&&`;
            });

            table.ajax.url(`${dataElement.url}?${params}`).load();
        });
        callback(table)
    });

    callback(table)
    table.on('responsive-display', function () {
        callback();

        $('.dt-search').on('keyup change', function(e) {
            table.search($(this).val()).draw();
        });

        $('.dt-filter').unbind().on('change', function(e) {
            var params = ``;

            $('.dt-filter').each((key, val) => {
                params += `${$(val).attr('name')}=${$(val).val()}&`;
            });

            table.ajax.url(`${dataElement.url}?${params}`).load();
        })
        callback(table)
    });

    $(element + ' th').addClass('bg-light');

    window._dataTables = table
    return table;
}
