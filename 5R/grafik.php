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

<div class="col-md-12 col-lg-12 col-xl-12">
	<div class="row">
	<?php
		$query 	= "SELECT * FROM ipl_5r where deletemark = 0 and aktif = 1";
		$sql	= mysql_query($query);
		
		while($data = mysql_fetch_array($sql)){
			$icon = '';
			if($data['id'] == 1){
				$icon = 'fa-compress';
			}else if($data['id'] == 2){
				$icon = 'fa-align-justify';
			}else if($data['id'] == 3){
				$icon = 'fa-recycle';
			}else if($data['id'] == 4){
				$icon = 'fa-cogs';
			}else if($data['id'] == 5){
				$icon = 'fa-check-circle';
			}
			echo"<div class='col-md-4'>
					<section class='panel panel-featured-left' style='border-color:$data[bg_color]'>
						<div class='panel-body pointer' onclick='view_dtl_sts($data[id])'>
							<div class='widget-summary'>
								<div class='widget-summary-col widget-summary-col-icon'>
									<div class='summary-icon' style='background:$data[bg_color]; color:$data[color]'>
										<i class='fa $icon'></i>
									</div>
								</div>
								<div class='widget-summary-col'>
									<div class='summary'>
										<h4 class='title'>$data[nama]</h4>
										<div class='info'>
											<strong id='jml_$data[id]' class='amount'> </strong>
										</div>
									</div>
									<div class='summary-footer'>
										<a class='text-muted text-uppercase'>(view all)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>";
		}
	?>
	</div>
	<div class="row">
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
				<div id="chart_dtl" style="height:400px"></div>
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
					<table class="table table-striped table-bordered table-hover dataTables-example" id="dtdetail">
						<thead>
							<tr>
								<th class="center">NO</th>
								<th class="center">PERMINTAAN</th>
								<th class="center">PELAPOR</th>
								<th class="center">TANGGAL</th>
								<th class="center">STATUS</th>
								<th class="center">PETUGAS</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
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
		rgn = "<?=$_SESSION['ruangan']?>";
		get_ruangan_aset(rgn, 'filter');
		fsday = get_day('01', 'thismonth');
		today = get_day('today', 'thismonth');
		$('#g_tgl_awl_filter').val(fsday);
		$('#g_tgl_akr_filter').val(today);
		cari();
	});
	
	function cari(){
		var ruangan = $('#g_ruangan_filter').val() == null ? "<?=$_SESSION['ruangan']?>" : $('#g_ruangan_filter').val();
		var tgl_awl = $('#g_tgl_awl_filter').val();
		var tgl_akr = $('#g_tgl_akr_filter').val();
		
		ruangan = ruangan == null ? 'all' : ruangan;
		get_jml(ruangan, tgl_awl, tgl_akr);
		get_chart(ruangan, tgl_awl, tgl_akr);
	}
	
	function get_day(day, month){
		var today = new Date();
		
		var dd = day == 'today' ? String(today.getDate()).padStart(2, '0') : day;
		var mm = month == 'thismonth' ? String(today.getMonth() + 1).padStart(2, '0') : month;
		
		var yyyy = today.getFullYear();
		today = yyyy + '-' + mm + '-' + dd;
		
		return today;
	}
	
	function get_jml(ruangan, tgl_awl, tgl_akr){
		$.ajax({
			url		: '5R/data.php?f=get_data_grafik',
			type	: 'POST',
			data	: {fruangan:ruangan, ftgl_awl:tgl_awl, ftgl_akr:tgl_akr, fdt:'lbl'},
			dataType: 'json',
			success	: function(data){
				var status = new Array(1, 2, 3, 4, 5);
				for(i=1; i<=status.length; i++){
					$('#jml_'+i).html(parseFloat(data[i]).toFixed(0)+' %');
				}
			}
		});
	}
	
	function klik_dtl(ind){
		var ruangan = $('#g_ruangan_filter').val();
		var tgl_awl = $('#g_tgl_awl_filter').val();
		var tgl_akr = $('#g_tgl_akr_filter').val();
		$.ajax({
			url		: 'report/perbaikan_data.php?f=get_data_detail&bln_i='+ind+'&thn='+thn,
			type	: 'post',
			dataType: 'json',
			success	: function(data){
				$('#detail_tgl').modal('show');
			}
		});
	}
	
	function get_chart(ruangan, tgl_awl, tgl_akr){
		$.ajax({
			url		: '5R/data.php?f=get_data_grafik',
			type	: 'post',
			data	: {fruangan:ruangan, ftgl_awl:tgl_awl, ftgl_akr:tgl_akr, fdt:'gfk'},
			dataType: 'json',
			success	: function(data){
				get_dtl(data);
			}
		});
	}
	
	function get_dtl(data){
		//console.log(data[1]);
		Highcharts.chart('chart_dtl', {
			chart: {
				type: 'spline'
			},
			title: {
				text: 'Laporan Checklist 5R'
			},
			subtitle: {
				text: 'Source: ' +
					'RSUD Mohammad Noer Pamekasan'
			},
			xAxis: {
				categories: data['tanggal']
			},
			yAxis: {
				title: {
					text: 'Persentase (%)'
				}
			},
			plotOptions: {
				spline: {
					dataLabels: {
						enabled: true,
						formatter: function(){
							console.log(this.point.y);
							if(this.point.y === 0){
								return "";
							}else{
								return "<span>" + parseFloat(this.point.y).toFixed(0) + "%</span>";
							}
						},
					},
					enableMouseTracking: false
				}
			},
			series: [{
				name: 'Ringkas',
				data: data[1]
			}, {
				name: 'Rapi',
				data: data[2]
			}, {
				name: 'Resik',
				data: data[3]
			}, {
				name: 'Rawat',
				data: data[4]
			}, {
				name: 'Rajin',
				data: data[5]
			}]
		});
	}
	
	function view_dtl(tgl){
		$('#modal_view_dtl').modal('show');
		var ruangan = $('#g_ruangan_filter').val();
		$('#dtdetail').DataTable({
			"ajax"		: {
				"url"		: 'report/perbaikan_data.php?f=get_detail',
				"type"		: 'POST',
				"data"		: {"gjenis":"tgl", "gtanggal":tgl, "gruangan":ruangan}
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
							{"data" : "petugas"}
						],
			"searching"	: true,
			"paging"	: false,
			"ordering"	: true,
			"destroy"	: true,
			"info"		: true,
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function view_dtl_sts(val){
		awl = $('#g_tgl_awl_filter').val();
		akr = $('#g_tgl_akr_filter').val();
		$('#modal_view_dtl').modal('show');
		var ruangan = $('#g_ruangan_filter').val();
		$('#dtdetail').DataTable({
			"ajax"		: {
				"url"		: 'report/perbaikan_data.php?f=get_detail',
				"type"		: 'POST',
				"data"		: {"gjenis":"sts", "gawl":awl, "gakr":akr, "gsts":val, "gruangan":ruangan}
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
							{"data" : "petugas"}
						],
			"searching"	: true,
			"paging"	: false,
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
					}
					$("#g_ruangan_"+f).select2("readonly", true);
				}
				$("#g_ruangan_"+f).select2().select2('val',unit);
				
				$("#g_ruangan_"+f).select2("readonly", true);//sementara semua role
			}
		});
	}
</script>

<style>
  .col-five {
    float: left;
    width: 20%;
	padding:1%;
  }

  @media (max-width: 992px) {
    .col-five {
      width: 50%;
    }
  }

  @media (max-width: 768px) {
    .col-five {
      width: 100%;
    }
  }
  
  .panel-featured-default{
	border-color: #aaa; 
  }
  
  .pointer{
	  cursor:pointer
  }
</style>