<?php 
	$home = 'Konfirmasi Peminjaman';
	include('scan_header.php');
?>

<section role="main" class="content-body">
	<header class="page-header">
		
	</header>
	<!-- start: page -->
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover dataTables-example" id="dtaset">
						<thead>
							<tr>
								<th class="center">TANGGAL</th>
								<th class="center">NAMA</th>
								<th class="center">ASET</th>
								<th class="center">STATUS</th>
								<th class="center">ID</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>
</section>

<!--  modal detail  -->
<div class="modal fade" id="add_permintaan" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Peminjaman</h4>
			</div>
			<form id="add_data_form" onsubmit="return false">
				<input id="g_id_action" type="text" name="id_action" hidden>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Ruangan <span class="required">*</span></label>
						<div class="col-sm-6">
							<select data-plugin-selectTwo class="form-control populate" name="g_ruangan" id="g_ruangan_add" placeholder="Ruangan" onchange="get_aset('', this.value, 'add')">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Barang <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_aset_add" id="g_aset_add" placeholder="Nama Barang/Aset">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Peminjam <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_pelapor" id="g_pelapor_add" placeholder="Pelapor">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Konfirmasi <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_konfirmasi" id="g_konfirmasi_add" placeholder="Konfirmasi">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tanggal <span class="required">*</span></label>
						<div class="col-sm-5">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input id="g_tgl_add_tindakan" name="g_tanggal" type="text" data-plugin-datepicker="" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Waktu <span class="required">*</span></label>
						<div class="col-sm-5">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</span>
								<input id="g_time_add_tindakan" name="g_time" class="form-control" type="text" data-plugin-timepicker="" data-plugin-options='{ "showMeridian": false }'>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-5">
							<button id="btn_tlk" type="button" class="btn btn-danger waves-effect " data-dismiss="modal">Tolak Konfirmasi</button>
							<button id="btn_trm" type="button" class="btn btn-primary waves-effect " data-dismiss="modal">Terima Konfirmasi</button>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
				</div>
			</form>
		 </div>
	</div>
</div>
<?php 
	include('scan_footer.php');
	$id_user = isset($_SESSION['simrsig']) ? $_SESSION['simrsig'] : '';
	$role_id = isset($_SESSION['group']) ? $_SESSION['group'] : '';
?>

<script>
	$(document).ready( function() {
		var aset_id = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		get_data();
		saiki = get_today();
		waktune = get_time();
		$('#g_tgl_add_tindakan').datepicker('setDate', saiki);
		$('#g_time_add_tindakan').val(waktune);
		
		if(type == 'aset'){
			get_dtl_aset(aset_id);
		}else{
			get_dtl_ruangan(aset_id);
		}
		
		$('#dtaset tbody').on( 'click', 'tr', function () {
			var id = $('#dtaset').DataTable().row(this).data().id;
			action(id);
        });
	});
	
	function action(id){
		var aset_id = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_detail_peminjaman&type='+type+'&gid='+aset_id,
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				//get_status_aset(jenis_id, data.status_aset, 'tindakan');
				$('#add_permintaan').modal('show');
				$('#g_id_action').val(id);
				//get_ruangan_aset(data.ruangan_id, 'add');
				if(data.status == 1){
					konfirm = data.konfirmasi_id;
					$('.modal-title').html('Konfirmasi Pinjaman');
					$('#btn_tlk').attr('onclick', 'add_data('+id+',4)');
					$('#btn_trm').attr('onclick', 'add_data('+id+',3)');
				}else{
					konfirm = data.konfirmasi_id_kembali;
					$('.modal-title').html('Konfirmasi Pengembalian');
					$('#btn_tlk').attr('onclick', 'add_data('+id+',3)');
					$('#btn_trm').attr('onclick', 'add_data('+id+',2)');
				}
				
				get_aset(data.aset_id, data.ruangan_id, 'add', konfirm);
				saiki = get_today();
				waktune = get_time();
				get_pegawai(data.pegawai_id, 'add');
				//get_konfirmasi(data.konfirmasi_id, data.ruangan_id, 'add');
				$('#g_tgl_add_tindakan').val(saiki);
				$('#g_time_add_tindakan').val(waktune);
			},error	: function(){
				
			}
		});
	}
	
	function get_today(){
		var today = new Date();
		var dd = String(today.getDate()).padStart(2, '0');
		var mm = String(today.getMonth() + 1).padStart(2, '0');
		var yyyy = today.getFullYear();
		today = yyyy + '-' + mm + '-' + dd;
		
		return today;
	}
	
	function get_time(){
		const d = new Date();
		let minutes = d.getMinutes();
		let hour = d.getHours();
		return hour+':'+minutes;
	}
	
	function get_data(){
		var aset_id = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		$('#dtaset').DataTable({
			"ajax"		: 'scan_qrcode_data.php?f=get_data_peminjaman_konfirmasi&gid='+aset_id+'&type='+type,
			"sAjaxDataProp": "data",
			"Processing": true, 
			"columns"	: [
							{"data" : "tanggal"},
							{"data" : "nama"},
							{"data" : "aset"},
							{"data" : "status"},
							{"data"	: "id", "visible":false}
						],
			"searching"	: false,
			"paging"	: true,
			"ordering"	: true,
			"destroy"	: true,
			"info"		: false,
			"order"		: [[0, 'desc']],
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function get_dtl_aset(aset_id){
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_dtl_aset',
			type	: 'post',
			data	: {gid_aset:aset_id},
			dataType: 'json',
			success	: function(data){
				var id_peg  = "<?=$id_user?>";
				var role_id = "<?=$role_id?>";
				if(role_id == 2){
					id_peg = '';
				}
				get_ruangan_aset(data.ruangan_id, 'add');
				get_aset(data.aset_id, data.ruangan_id, 'add');
				get_pegawai(id_peg, 'add');
				//get_status_aset(5, '', 'add');
				//console.log(data);
			},error	: function(){
				
			}
		});
	}
	
	function get_dtl_ruangan(ruangan_id){
		var id_peg = "<?=$id_user?>";
		var role_id = "<?=$role_id?>";
		if(role_id == 2){
			id_peg = '';
		}
		get_ruangan_aset(ruangan_id, 'add');
		get_aset('',ruangan_id, 'add');
		get_pegawai(id_peg, 'add');
		//get_status_aset(5, '', 'add');
	}
	
	function get_ruangan_aset(unit,f){
		$.ajax({
			url		: '../master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:unit,gf:'column'},
			dataType: 'json',
			success	: function(data){
				document.getElementById("g_ruangan_"+f).innerHTML = data;
				$("#g_ruangan_"+f).select2("readonly", true);
				$("#g_ruangan_"+f).select2("val", unit);
			}
		});
	}
	
	function get_aset(id, unit, f, k=''){
		$.ajax({
			url		: '../permintaan/ipsls_data.php?f=get_aset',
			type	: 'post',
			data	: {gunit : unit},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_aset_'+f).innerHTML = data;
				if(id){
					$("#g_aset_"+f).select2("val", id);
					$("#g_aset_"+f).select2("readonly", true);
				}
				get_konfirmasi(k, unit, f);
			}
		});
	}
	
	function get_konfirmasi(val, unit, f){
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_konfirmasi',
			type	: 'post',
			data	: {gu:unit},
			success	: function(data){
				document.getElementById('g_konfirmasi_'+f).innerHTML = data;
				$("#g_konfirmasi_"+f).select2("val", val);
				$("#g_konfirmasi_"+f).select2("readonly", true);
			}
		});
	}
	
	function get_pegawai(val, f){
		$.ajax({
			url		: '../master/global.php?f=get_option_pegawai',
			type	: 'post',
			data	: {gf:'column'},
			success	: function(data){
				document.getElementById('g_pelapor_'+f).innerHTML = data;
				if(val){
					$("#g_pelapor_"+f).select2("val", val);
					$("#g_pelapor_"+f).select2("readonly", true);
				}
			}
		});
	}
	
	function get_status_aset(key, val, f){
		$.ajax({
			url		: '../master/global.php?f=get_option_status',
			type	: 'post',
			data	: {gkey:key, gval:val},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_status_'+f).innerHTML = data;
			}
		});
	}
	
	function add_data(id, sts){
		c_tgl 		= document.forms['add_data_form'].elements['g_tgl_add_tindakan'].value;
		c_time 		= document.forms['add_data_form'].elements['g_time_add_tindakan'].value;
		$.ajax({
			url		: 'scan_qrcode_data.php?f=konfirmasi_peminjaman',
			type	: 'POST',
			data	: {gid:id, gsts:sts, gtgl:c_tgl, gwkt:c_time},
			dataType: 'json',
			success	: function(data){
				get_data();
				new PNotify({
					title	: 'Berhasil',
					text	: 'Berhasil Konfirmasi data',
					type	: 'success'
					//icon	: 'fa fa-home'
				});
			},error: function(){
				new PNotify({
					title: 'Error',
					text: 'Gagal Konfirmasi data',
					type: 'error'
				});
			}
		});
	}
</script>