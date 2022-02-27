$(document).ready(function (){
    $('.data-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        'language' : {
            'emptyTable' : 'Няма данни',
            "info":  "Показвани са _START_ до _END_ от _TOTAL_ записа",
            "paginate": {
                "first":      "Първи",
                "last":       "Последен",
                "next":       "Напред",
                "previous":   "Назад"
            },
        }
    });
})