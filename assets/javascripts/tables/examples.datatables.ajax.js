(function( $ ) {
	'use strict';
	var datatableInit = function() {
		var $table = $('#datatable-ajax');
		$table.dataTable({
			"bStateSave": false, 
                "autoWidth": false,
                "columnDefs": [
                        { "orderable": false, "targets": [0, 4, 5] },
                        { "searchable": false, "targets": [0, 1, 4, 5] },
                        { "className": "text-center", "targets": [0, 1, 2, 4, 5] },
                    ],
                "pagingType": "bootstrap_full_number",
                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                // "deferLoading": 0, // here
                "scrollX": 100,
                "scrollY": 300,
                // "scroller": false,
                "ajax": {
                    "url": 'cek_data.php', // ajax source
                    "data": function(datas){
                                datas.status	= function(){ return $('#status').val(); };
                            }
                },
                "order": [
                    [ 1, "desc"]
                ]// set first column as a default sort by asc
		});
	};
	$(function() {
		datatableInit();
	});
}).apply( this, [ jQuery ]);