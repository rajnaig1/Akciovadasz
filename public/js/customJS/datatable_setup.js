function setupDataTable(id) {
    $(document).ready(function () {
        $('#' + id).DataTable({
            "language": {
                "lengthMenu": "Oldalankénti találat _MENU_ ",
                "zeroRecords": "Sajnáljuk nincs ilyen találat",
                "info": " _PAGE_ / _PAGES_",
                "infoEmpty": "Nincs record",
                "infoFiltered": "(Az összes _MAX_ találatból szűrve)",
                'search': "Keresés",
                'searchPlaceholder': 'Keresés',
                "paginate": {
                    "previous": "Előző oldal",
                    "next": "Következő oldal"
                }
            }
            , dom: "<'row'<'col-sm-12 col-md-10'l><'col-sm-12 col-md-2'f>>" + "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });
    });
}