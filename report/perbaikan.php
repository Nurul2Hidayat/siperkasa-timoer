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
		<div class="col-md-4">
			<section class="panel panel-featured-left panel-featured-secondary">
				<div class="panel-body pointer" onclick="view_dtl_sts(10)">
					<div class="widget-summary">
						<div class="widget-summary-col widget-summary-col-icon">
							<div class="summary-icon bg-secondary">
								<i class="fa fa-wrench"></i>
							</div>
						</div>
						<div class="widget-summary-col">
							<div class="summary">
								<h4 class="title">Belum dikonfirmasi</h4>
								<div class="info">
									<strong id="jml_10" class="amount"> </strong>
								</div>
							</div>
							<div class="summary-footer">
								<a class="text-muted text-uppercase">(view all)</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="col-md-4">
			<section class="panel panel-featured-left panel-featured-info">
				<div class="panel-body pointer" onclick="view_dtl_sts(15)">
					<div class="widget-summary">
						<div class="widget-summary-col widget-summary-col-icon">
							<div class="summary-icon bg-info">
								<i class="fa fa-thumbs-up"></i>
							</div>
						</div>
						<div class="widget-summary-col">
							<div class="summary">
								<h4 class="title">Terkonfirmasi</h4>
								<div class="info">
									<strong id="jml_15" class="amount"> </strong>
								</div>
							</div>
							<div class="summary-footer">
								<a class="text-muted text-uppercase">(view all)</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="col-md-4">
			<section class="panel panel-featured-left panel-featured-dark">
				<div class="panel-body pointer" onclick="view_dtl_sts(14)">
					<div class="widget-summary">
						<div class="widget-summary-col widget-summary-col-icon">
							<div class="summary-icon bg-dark">
								<i class="fa fa-pause"></i>
							</div>
						</div>
						<div class="widget-summary-col">
							<div class="summary">
								<h4 class="title">dipending</h4>
								<div class="info">
									<strong id="jml_14" class="amount"> </strong>
								</div>
							</div>
							<div class="summary-footer">
								<a class="text-muted text-uppercase">(view all)</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="col-md-4">
			<section class="panel panel-featured-left panel-featured-warning">
				<div class="panel-body pointer" onclick="view_dtl_sts(11)">
					<div class="widget-summary">
						<div class="widget-summary-col widget-summary-col-icon">
							<div class="summary-icon bg-warning">
								<i class="fa fa-cogs"></i>
							</div>
						</div>
						<div class="widget-summary-col">
							<div class="summary">
								<h4 class="title">Sedang diproses</h4>
								<div class="info">
									<strong id="jml_11" class="amount"> </strong>
								</div>
							</div>
							<div class="summary-footer">
								<a class="text-muted text-uppercase">(view all)</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="col-md-4">
			<section class="panel panel-featured-left panel-featured-success">
				<div class="panel-body pointer" onclick="view_dtl_sts(13)">
					<div class="widget-summary">
						<div class="widget-summary-col widget-summary-col-icon">
							<div class="summary-icon bg-success">
								<i class="fa fa-spinner "></i>
							</div>
						</div>
						<div class="widget-summary-col">
							<div class="summary">
								<h4 class="title">Menunggu Persetujuan</h4>
								<div class="info">
									<strong id="jml_13" class="amount"> </strong>
								</div>
							</div>
							<div class="summary-footer">
								<a class="text-muted text-uppercase">(view all)</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="col-md-4">
			<section class="panel panel-featured-left panel-featured-primary">
				<div class="panel-body pointer" onclick="view_dtl_sts(12)">
					<div class="widget-summary">
						<div class="widget-summary-col widget-summary-col-icon">
							<div class="summary-icon bg-primary">
								<i class="fa fa-check"></i>
							</div>
						</div>
						<div class="widget-summary-col">
							<div class="summary">
								<h4 class="title">Selesai</h4>
								<div class="info">
									<strong id="jml_12" class="amount"> </strong>
								</div>
							</div>
							<div class="summary-footer">
								<a class="text-muted text-uppercase">(view all)</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
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
		get_ruangan_aset('all', 'filter');
		fsday = get_day('01', 'thismonth');
		today = get_day('today', 'thismonth');
		$('#g_tgl_awl_filter').val(fsday);
		$('#g_tgl_akr_filter').val(today);
		cari();
	});
	
	function cari(){
		var ruangan = $('#g_ruangan_filter').val();
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
		var status = new Array(10,11,12,13,14,15);
		for(i=0; i<status.length; i++){
			$.ajax({
				url		: 'report/perbaikan_data.php?f=get_jml',
				type	: 'POST',
				data	: {status_id:status[i], fruangan:ruangan, ftgl_awl:tgl_awl, ftgl_akr:tgl_akr},
				dataType: 'json',
				success	: function(data){
					$('#jml_'+data.status_id).text(data.jml);
				}
			});
		}
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
				//get_dtl(data);
			}
		});
	}
	
	function get_chart(ruangan, tgl_awl, tgl_akr){
		$.ajax({
			url		: 'report/perbaikan_data.php?f=get_chart_day',
			type	: 'post',
			data	: {fruangan:ruangan, ftgl_awl:tgl_awl, ftgl_akr:tgl_akr},
			dataType: 'json',
			success	: function(data){
				get_dtl(data);
			}
		});
	}
	
	function get_dtl(data){
		Highcharts.chart('chart_dtl', {
			chart: {
                type: 'column'
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Daftar Jumlah Permintaan Perbaikan'
            },
			subtitle: {
				text: 'di Rumah Sakit Mohammad Noer Pamekasan'
			},
            xAxis: {
                categories: data.tgl,
				labels:{
					style:{
						fontSize:'12px'
					}
				}
            },
			
            yAxis: {
                title: {
                    text: 'Jumlah Permintaan Perbaikan'
                }
            },
            tooltip: {
                valueSuffix: '',
				style:{
					fontSize:'15px'
				}
            },
			
			colors:['#e36159', '#ed9c28', '#0088cc', '#171717', '#47a447', '#5bc0de'],
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
						formatter: function(){
							if(this.point.y === 0){
								return "";
							}else{
								return "<span>" + this.point.y + "</span>";
							}
						},
						style:{
							fontSize:'15px'
						}
                    }
                },
				
				spline: {
                    dataLabels: {
                        enabled: true,
						style:{
							fontSize:'15px'
						}
                    },
                    enableMouseTracking: true
                },
				series:{
					cursor: 'pointer',
					events: {
						click: function(data){
							view_dtl(data.point.category);
						}
					},
					animation:true
				}
            },
            series: [{
                name: 'Belum dikonfirmasi',
                data: data.opn,
            }, {
                name: 'Sedang diproses',
                data: data.prg
            }, {
                name: 'Selesai',
                data: data.sls
            }, {
                name: 'dipending',
                data: data.pdg
            }, {
                name: 'menunggu persetujuan',
                data: data.mng
            }, {
				name: 'terkonfirmasi',
                data: data.tkf
			}, {
                type: 'spline',
                name: 'Total Permintaan',
                data: data.ttl,
                marker: {
                    lineWidth: 2,
                    lineColor: Highcharts.getOptions().colors[3],
                    fillColor: 'white'
                }
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
						get_aset('', unit, f);
					}
					$("#g_ruangan_"+f).select2("readonly", true);
				}
				$("#g_ruangan_"+f).select2("val", unit);
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