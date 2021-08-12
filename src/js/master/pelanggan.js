$(document).ready(function() {
    table = $('.data-pelanggan').DataTable({
        "ordering": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": BASE_URL + "pelanggan/data",
            "type": "GET"
        },
        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        }],
        "columns": [{
                "class": "text-center"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-center"
            },
            {
                "class": "text-center"
            }
        ]
    });
});