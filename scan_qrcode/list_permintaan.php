<?php 
	$home = 'List Permintaan Perbaikan';
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
					<table class="table table-striped table-bordered table-hover dataTables-example" id="dtlist">
						<thead>
							<tr>
								<th class="center">PERMINTAAN</th>
								<th class="center">TANGGAL</th>
								<th class="center">STATUS</th>
								<th class="center">PER</th>
								<th class="center">ASET</th>
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
<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Detail Permintaan</h4>
			</div>
			<form id="add_data_form" onsubmit="return false">
				<div class="modal-body">
					<input type="text" id="g_id_add" hidden>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Ruangan <span class="required">*</span></label>
						<div class="col-sm-6">
							<select data-plugin-selectTwo class="form-control populate" name="g_ruangan" id="g_ruangan_add" placeholder="Ruangan" onchange="get_aset('', this.value, 'add')" required disabled>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Barang <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_aset" id="g_aset_add" placeholder="Nama Barang/Aset" required onchange="change_barang(this.value, '', 'add')" disabled>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Merk </label>
						<div class="col-sm-4">
							<input id="g_merk_add" maxlength="54" type="text" class="form-control" placeholder="Merk" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">No. Seri </label>
						<div class="col-sm-6">
							<input id="g_nosi_add" maxlength="54" type="text" class="form-control" placeholder="No. Seri" disabled>
						</div>
					</div>
					<div id="div_tipe_add" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Tipe <span class="required">*</span></label>
						<div class="col-sm-8">
							<select class="form-control populate" name="g_tipe" id="g_tipe_add" placeholder="Tipe Permintaan" disabled>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kerusakan <span class="required">*</span></label>
						<div class="col-sm-10">
							<!--<input id="g_permintaan_add" maxlength="54" name="g_permintaan" type="text" class="form-control" placeholder="Permintaan" required>-->
							<textarea class="form-control" id="g_permintaan_add" name="g_permintaan" placeholder="Kerusakan" style="width:100%" required disabled></textarea>
						</div>
					</div>
					<div id="div_stok_add" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Jumlah <span class="required">*</span></label>
						<div class="col-sm-4">
							<input id="g_stok_add" maxlength="54" name="g_stok" type="number" class="form-control" placeholder="Jumlah" disabled>
						</div>
					</div>
					<div id="div_lokasi_add" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Lokasi <span class="required">*</span></label>
						<div class="col-sm-10">
							<input id="g_lokasi_add" maxlength="54" name="g_lokasi" type="text" class="form-control" placeholder="Lokasi" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Pelapor <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_pelapor" id="g_pelapor_add" placeholder="Pelapor" required disabled>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 control-label">Gambar Aset <span class="required c_unit">*</span></label>
						<div class="col-md-5">
							<img class="form-control" id="g_img_add" style="height:100%"></img>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status Aset</label>
						<div class="col-sm-4">
							<select id="g_status_add" name="g_status" class="form-control" disabled>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status Permintaan</label>
						<div class="col-sm-4">
							<select id="g_stat_per_add" name="g_stat_per" class="form-control" disabled>
								
							</select>
						</div>
					</div>
					<div id="div_alasan" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Alasan</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="g_alasan_add" name="g_alasan" placeholder="Alasan" style="width:100%" onchange="change_alasan(this.value)" disabled></textarea>
						</div>
					</div>
					<div class="col-sm-8">&nbsp;</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button id="btn_add" type="submit" class="btn btn-primary waves-effect waves-light" onclick="tindak()">Tindak Lanjuti</button>
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
		//$('#add_permintaan').modal('show');
		id = "<?=$_GET['id']?>";
		get_data(id);
		
		$('#dtlist tbody').on( 'click', 'tr', function () {
			var id = $('#dtlist').DataTable().row(this).data().permintaan_id;
			var aset_id = $('#dtlist').DataTable().row(this).data().aset_id;
			//editMember(data[0]);
			action(id, aset_id);
        });
	});
	
	function tindak(){
		id = $('#g_id_add').val();
		$.ajax({
			url		: 'scan_qrcode_data.php?f=tindaklanjuti',
			type	: 'post',
			data	: {gid:id},
			dataType: 'text',
			success	: function(data){
				window.location.replace(data);
			}
		});
	}
	
	function get_data(id){
		$('#dtlist').DataTable({
			"ajax"		: 'scan_qrcode_data.php?f=get_list_permintaan&id='+id,
			"sAjaxDataProp": "data",
			"Processing": true, 
			"columns"	: [
							{"data" : "permintaan"},
							{"data" : "tgl_permintaan"},
							{"data" : "status"},
							{"data" : "permintaan_id", "visible":false},
							{"data" : "aset_id", "visible":false}
						],
			"columnDefs": [
							{
								render: function (data, type, full, meta) {
									return "<div class='text-wrap width-200'>" + data + "</div>";
								},
								targets: 0
							}
						 ],
			"searching"	: false,
			"paging"	: true,
			"ordering"	: true,
			"destroy"	: true,
			"info"		: false,
			"order"		: [[1, 'desc']],
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function action(id, aset_id){
		//alert(aset_id);return;
		$.ajax({
			url		: '../permintaan/ipsls_data.php?f=get_data_detail',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				get_ruangan_aset(data.ruangan_id,'add');
				get_aset(aset_id, data.ruangan_id, 'add');
				get_status_permintaan(5, data.status_id, 'add');
				$('#g_aset_add').val(data.nm_aset);
				$('#g_permintaan_add').val(data.permintaan);
				get_pegawai(data.pelapor,'add');
				$('#btn_add_tindakan').attr('onclick', 'add_tindakan('+id+','+aset_id+')');
				$('#add_modal').modal('show');
				img_url = data.gambar == null ? 'no-image.jpg' : data.gambar;
				img = window.location.origin+'/it/files/img/permintaan/'+img_url;
				$('#g_img_add').attr('src', img);
				get_status_aset(1, data.status_aset, 'add');
				
				$('#g_id_add').val(aset_id);
				$('#g_alasan_add').val(data.alasan);
				
				if(data.status_id == 13){
					$('#div_alasan').attr('hidden', false);
				}else{
					$('#div_alasan').attr('hidden', true);
				}
			},error	: function(){
				
			}
		});
	}
	
	function get_ruangan_aset(unit,f){
		$.ajax({
			url		: '../master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:unit, gf:f},
			dataType: 'json',
			success	: function(data){
				document.getElementById("g_ruangan_"+f).innerHTML = data;
				$("#g_ruangan_"+f).select2("val", unit);
			}
		});
	}
	
	function get_aset(id, unit, f){
		$.ajax({
			url		: '../permintaan/ipsls_data.php?f=get_aset',
			type	: 'post',
			data	: {gunit : unit},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_aset_'+f).innerHTML = data;
				change_barang(id, '', 'add');
				$("#g_aset_"+f).select2("val", id);
			}
		});
	}
	
	function get_pegawai(val, f){
		$.ajax({
			url		: '../master/global.php?f=get_option_pegawai',
			type	: 'post',
			success	: function(data){
				document.getElementById('g_pelapor_'+f).innerHTML = data;
				$("#g_pelapor_"+f).select2("val", val);
			}
		});
	}
	
	function get_status_aset(key, val, f){
		$.ajax({
			url		: '../master/global.php?f=get_option_status',
			type	: 'post',
			data	: {gkey:key, gval:val, gf:f},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_status_'+f).innerHTML = data;
			}
		});
	}
	
	function get_status_permintaan(key, val, f){
		$.ajax({
			url		: '../master/global.php?f=get_option_status',
			type	: 'post',
			data	: {gkey:key, gval:val, gf:f},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_stat_per_'+f).innerHTML = data;
			}
		});
	}
	
	function change_barang(key, val, f){
		$.ajax({
			url		: '../permintaan/ipsls_data.php?f=cek_barang',
			type	: 'post',
			data	: {gkey:key},
			dataType: 'json',
			success	: function(data){
				if(data.tipe > 0){
					$('#div_tipe_'+f).attr('hidden', false);
					get_opt_tipe(key, val, f);
				}else{
					$('#div_tipe_'+f).attr('hidden', true);
					$('#g_tipe_'+f).val('');
				}
				
				if(data.hbs_pakai == 1){
					$('#div_stok_'+f).attr('hidden', false);
				}else{
					$('#div_stok_'+f).attr('hidden', true);
					$('#g_stok_'+f).val('');
				}
				
				if(data.unit_pj == 2){
					$('#div_lokasi_'+f).attr('hidden', false);
					$('.c_unit').removeClass('hidden');
					$('#g_lokasi_'+f).val(data.lokasi);
				}else{
					$('#div_lokasi_'+f).attr('hidden', true);
					$('.c_unit').addClass('hidden');
					$('#g_lokasi_'+f).val('');
				}
				
				$('#g_merk_'+f).val(data.merk_aset);
				$('#g_nosi_'+f).val(data.no_seri);
			},error	: function(){
				
			}
		});
	}
	
	function get_opt_tipe(key, val, f){
		$.ajax({
			url		: '../master/global.php?f=get_option_tipe_aset',
			type	: 'post',
			data	: {gkey:key, gval:val},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_tipe_'+f).innerHTML = data;
			}
		});
	}
	
	function change_file(val){
		sval	= val.split('.');
		ext 	= sval[sval.length-1];
		if(ext != 'jpg' && ext != 'png' && ext != 'jpeg'){
			new PNotify({
				title: 'tipe file tidak sesuai',
				text: 'File Harus berupa gambar (jpg, jpeg, png)',
				type: 'warning'
			});
		}
	}
	
	function view_img(){
		$('#view_img_modal').modal('show');
	}
</script>

<style>
	#dtlist{
		width:100% !important;
	}
	.text-wrap{
		white-space:normal;
	}
	.width-200{
		width:150px;
	}
</style>