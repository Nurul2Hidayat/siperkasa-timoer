<?php 
	$home = 'Permintaan Perbaikan';
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
								<th class="center">PERMINTAAN</th>
								<th class="center">TANGGAL</th>
								<th class="center">STATUS</th>
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
				<h4 class="modal-title">Permintaan Perbaikan</h4>
			</div>
			<form id="add_data_form" onsubmit="return false">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Ruangan <span class="required">*</span></label>
						<div class="col-sm-6">
							<select data-plugin-selectTwo class="form-control populate" name="g_ruangan" id="g_ruangan_add" placeholder="Ruangan" onchange="get_aset('', this.value, 'add')" required>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Barang <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_aset" id="g_aset_add" placeholder="Nama Barang/Aset" required onchange="change_barang(this.value, '', 'add')">
								
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
							<select class="form-control populate" name="g_tipe" id="g_tipe_add" placeholder="Tipe Permintaan">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kerusakan <span class="required">*</span></label>
						<div class="col-sm-10">
							<!--<input id="g_permintaan_add" maxlength="54" name="g_permintaan" type="text" class="form-control" placeholder="Permintaan" required>-->
							<textarea class="form-control" id="g_permintaan_add" name="g_permintaan" placeholder="Kerusakan" style="width:100%" required></textarea>
						</div>
					</div>
					<div id="div_stok_add" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Jumlah <span class="required">*</span></label>
						<div class="col-sm-4">
							<input id="g_stok_add" maxlength="54" name="g_stok" type="number" class="form-control" placeholder="Jumlah">
						</div>
					</div>
					<div id="div_lokasi_add" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Lokasi <span class="required">*</span></label>
						<div class="col-sm-10">
							<input id="g_lokasi_add" maxlength="54" name="g_lokasi" type="text" class="form-control" placeholder="Lokasi">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Pelapor <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_pelapor" id="g_pelapor_add" placeholder="Pelapor" required>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 control-label">Gambar Aset <span class="required c_unit">*</span></label>
						<div class="col-md-5">
							<input type="file" id="g_file_add" name="g_file" class="form-control" onchange="change_file(this.value)">
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
					<div class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Status </label>
						<div class="col-sm-4">
							<select id="g_status_add" name="g_status" class="form-control">
								
							</select>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button id="btn_add" type="submit" class="btn btn-primary waves-effect waves-light">Tambah Data</button>
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
		$('#add_permintaan').modal('show');
		var aset_id = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		change_barang(aset_id, '', 'add');
		get_data(aset_id);
		if(type == 'aset'){
			get_dtl_aset(aset_id);
		}else{
			get_dtl_ruangan(aset_id);
		}
		$('#btn_add').attr('onclick', 'add_data('+aset_id+')');
	});
	
	function get_data(aset_id){
		var type = "<?=$f_tp;?>";
		$('#dtaset').DataTable({
			"ajax"		: 'scan_qrcode_data.php?f=get_data_permintaan_perbaikan&gid='+aset_id+'&type='+type,
			"sAjaxDataProp": "data",
			"Processing": true, 
			"columns"	: [
							{"data" : "permintaan"},
							{"data" : "tgl_permintaan"},
							{"data" : "status"}
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
				get_status_aset(5, '', 'add');
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
		get_status_aset(5, '', 'add');
	}
	
	function get_ruangan_aset(unit,f){
		$.ajax({
			url		: '../master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:unit, gf:f},
			dataType: 'json',
			success	: function(data){
				document.getElementById("g_ruangan_"+f).innerHTML = data;
				//group = $('#g_group_id').val();
				$("#g_ruangan_"+f).select2("readonly", true);
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
				if(id){
					$("#g_aset_"+f).select2("val", id);
					$("#g_aset_"+f).select2("readonly", true);
				}
				
			}
		});
	}
	
	function get_pegawai(val, f){
		$.ajax({
			url		: '../master/global.php?f=get_option_pegawai',
			type	: 'post',
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
			data	: {gkey:key, gval:val, gf:f},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_status_'+f).innerHTML = data;
			}
		});
	}
	
	function add_data(aset_id){
		c_pelapor = document.forms['add_data_form'].elements['g_pelapor'].value;
		c_permintaan = document.forms['add_data_form'].elements['g_permintaan'].value;
		c_aset 		= document.forms['add_data_form'].elements['g_aset'].value;
		c_lokasi	= document.forms['add_data_form'].elements['g_lokasi'].value;
		c_file		= document.forms['add_data_form'].elements['g_file'].value;
		
		h_lokasi	= $('#div_lokasi_add').attr('hidden');
		
		if(c_pelapor == '' || c_permintaan == '' || c_aset == ''){
			required = 1;
		}else{
			//required = 0;
			if(h_lokasi){
				required = 0;
			}else{
				if(c_lokasi == '' || c_file == ''){
					required = 1;
				}else{
					required = 0;
				}
			}
		}
		
		if(required == 1){
			new PNotify({
				title	: 'Isi Form',
				text	: 'Silahkan isi form yang bertanda bintang',
				type	: 'warning'
			});
		}else{
			$('#btn_add').text('Loading...');
			$('#btn_add').addClass('disabled');
			var formData = new FormData($("#add_data_form").get(0));
			$.ajax({
				url		: '../permintaan/ipsls_data.php?f=add_data',
				type	: 'POST',
				data	: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success	: function(data){
					$('#btn_add').text('Tambah Data');
					$('#btn_add').removeClass('disabled');
					$('#add_permintaan').modal('toggle');
					if(data.sts == 1){
						$('#add_data_modal').modal('toggle');
						get_data(aset_id);
						new PNotify({
							title	: 'Berhasil',
							text	: data.msg,
							type	: 'success'
							//icon	: 'fa fa-home'
						});
					}else{
						new PNotify({
							title	: 'Gagal',
							text	: data.msg,
							type	: 'error'
						});
					}
				},error: function(){
					new PNotify({
						title: 'Error',
						text: 'Gagal menambahkan data',
						type: 'error'
					});
				}
			});
		}
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
					$('.c_unit').removeClass('hidden');
					if(data.umum == 1){
						$('#div_lokasi_'+f).attr('hidden', false);
						$('#g_lokasi_'+f).val(data.lokasi);
					}else{
						$('#div_lokasi_'+f).attr('hidden', true);
						$('#g_lokasi_'+f).val('');
					}
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
	#dtaset{
		width:100% !important;
	}
	.text-wrap{
		white-space:normal;
	}
	.width-200{
		width:150px;
	}
</style>