<header class="page-header">
	<h2>Permintaan Sarana & Prasarana</h2>
</header>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Perbaikan Sarana & Prasarana</h5>
			</header>
			<div class="panel-body">
				<table id="dtpermintaan" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th></th>
							<th width="500px">Ruangan</th>
							<th>Total Permintaan</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th></th>
							<th>Ruangan</th>
							<th>Total Permintaan</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</section>
	</div>
<div>



<script>
	function format2 ( d ) {
		return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
			'<tr>'+
				'<td>Full name:</td>'+
				'<td>'+d.nama+'</td>'+
			'</tr>'+
			'<tr>'+
				'<td>Extension number:</td>'+
				'<td>'+d.nama+'</td>'+
			'</tr>'+
			'<tr>'+
				'<td>Extra info:</td>'+
				'<td>And any further details here (images etc)...</td>'+
			'</tr>'+
		'</table>';
	}
	
	function format ( d ) {
		return '<table width="100%">'+
					'<tbody>'+
						'<tr>'+
							'<th></th>'+
							'<th width="500px">isi 1</th>'+
							'<th>isi 2</th>'+
						'</tr>'+
					'</tbody>'+
				'</table>';
	}
	
	$(document).ready( function() {
		var table = $('#dtpermintaan').DataTable( {
			"ajax": "permintaan/list_ipsls_data2.php?f=get_data",
			"columns": [
				{
					"class":          'details-control',
					"orderable":      false,
					"data":           null,
					"defaultContent": ''
				},
				{ "data": "nama" },
				{ "data": "jml" }
			],
			"order": [[2,'desc']]
		} );
		
		$('#dtpermintaan tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = table.row( tr );

			if ( row.child.isShown() ) {
				row.child.hide();
				tr.removeClass('shown');
			}
			else {
				// Open this row
				const data = row.data();
				$.ajax({
					url : 'permintaan/list_ipsls_data2.php?f=get_data_child',
					data : {ruangan:data['nama']},
					success: function(res){
						row.child(res).show();
						tr.addClass('shown');
					}
				});
				//row.child( format(row.data()) ).show();
				//tr.addClass('shown');
			}
		} );
	} );
	
	$('#dtpermintaan tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = table.row( tr );

		if ( row.child.isShown() ) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		}
		else {
			// Open this row
			row.child( format(row.data()) ).show();
			tr.addClass('shown');
		}
	} );
</script>

<style type="text/css" class="init">
	td.details-control {
		background: url('assets/vendor/jquery-datatables/examples/resources/details_open.png') no-repeat center center;
		cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('assets/vendor/jquery-datatables/examples/resources/details_close.png') no-repeat center center;
	}
</style>