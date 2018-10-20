$(document).ready(function() {

    //$('#data-table-documents').dataTable();

    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [
            {orderable: true, width: '20%', targets: [0]},
            {orderable: true, width: '10%', targets: [1]},
            {orderable: true, width: '30%', targets: [2]},
            {orderable: true, width: '20%', targets: [3]},
            {orderable: true, width: '20%', targets: [4]}
        ],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });

    var lastIdx = null;
    var table = $('#data-table-documents').DataTable();

    $('#data-table-documents tbody').on('mouseover', 'td', function() {

    }).on('mouseleave', function() {
        $(table.cells().nodes()).removeClass('active');
    });

    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });
});
