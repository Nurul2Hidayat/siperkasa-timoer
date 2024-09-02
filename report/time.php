<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-3">
						<div class="form-group">
							<label class="control-label">Ruangan</label>
							<select data-plugin-selectTwo class="form-control populate" id="g_ruangan_filter" placeholder="Ruangan">
								
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">Tanggal</label>
							<div class="input-daterange input-group" data-plugin-datepicker="">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" class="form-control" id="g_tgl_awl_filter" name="g_tgl_awl_filter">
								<span class="input-group-addon">to</span>
								<input type="text" class="form-control" id="g_tgl_akr_filter" name="g_tgl_akr_filter">
							</div>
						</div>
					</div>
					<div class="col-sm-1">
						<label class="control-label"></label>
						<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary form-control" onclick="cari()">
							<i class="fa fa-search"></i>Cari
						</button>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-bar-chart-o"></i> Laporan Perbaikan</h5>
			</header>
			<div class="panel-body">
				<table class="table table-striped table-bordered table-hover dataTables-example" id="dt_data">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">PERMINTAAN</th>
							<th class="center">PELAPOR</th>
							<th class="center">TANGGAL</th>
							<th class="center">STATUS</th>
							<th class="center">WAKTU RESPON</th>
							<th class="center">WAKTU SELESAI</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</section>
	</div>
</div>

<!--  detail  -->
<div class="modal fade" id="modal_view_dtl" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Detail</h4>
			</div>
			<form id="edit_data_form" onsubmit="return false">
				<div class="modal-body">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
				</div>
			</form>
		 </div>
	</div>
</div>

<script>
	$(document).ready( function() {
		get_ruangan_aset('all', 'filter');
		fsday = get_day('01', 'thismonth');
		today = get_day('today', 'thismonth');
		$('#g_tgl_awl_filter').val(fsday);
		$('#g_tgl_akr_filter').val(today);
		cari();
	});
	
	function get_day(day, month){
		var today = new Date();
		
		var dd = day == 'today' ? String(today.getDate()).padStart(2, '0') : day;
		var mm = month == 'thismonth' ? String(today.getMonth() + 1).padStart(2, '0') : month;
		
		var yyyy = today.getFullYear();
		today = yyyy + '-' + mm + '-' + dd;
		
		return today;
	}
	
	function cari(){
		var ruangan = $('#g_ruangan_filter').val();
		var tgl_awl = $('#g_tgl_awl_filter').val();
		var tgl_akr = $('#g_tgl_akr_filter').val();
		
		ruangan = ruangan == null ? 'all' : ruangan;
		get_data(ruangan, tgl_awl, tgl_akr);
	}
	
	function get_data(ruangan, tgl_awl, tgl_akr){
		$('#dt_data').DataTable({
			"ajax"		: {
				"url"		: 'report/time_data.php?f=get_data',
				"type"		: 'POST',
				"data"		: {"gtgl_awl":tgl_awl, "gtgl_akr":tgl_akr, "gruangan":ruangan}
			},
			"sAjaxDataProp": "data",
			"Processing": true, 
			"serverSide": true,
			"columns"	: [
							{"data" : "no"},
							{"data" : "permintaan"},
							{"data" : "pelapor"},
							{"data" : "tanggal"},
							{"data" : "status"},
							{"data" : "time_res"},
							{"data" : "time_sls"}
						],
			"searching"	: true,
			"paging"	: true,
			"ordering"	: true,
			"destroy"	: true,
			"info"		: true,
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function get_ruangan_aset(unit,f){
		$.ajax({
			url		: 'master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:unit, gf:f},
			dataType: 'json',
			success	: function(data){
				document.getElementById("g_ruangan_"+f).innerHTML = data;
				group = $('#g_group_id').val();
				if(group == 1){
					if(f == 'add'){
						unit = $("#g_ruangan_id").val();
						get_aset('', unit, f);
					}
					$("#g_ruangan_"+f).select2("readonly", true);
				}
				$("#g_ruangan_"+f).select2("val", unit);
			}
		});
	}
</script>