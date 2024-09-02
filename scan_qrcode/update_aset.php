<?php
	$home = 'Update data Aset';
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
					<form id="edit_data_form" onsubmit="return false">
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Kriteria</label>
							<div class="col-sm-4">
								<select id="g_non_edit" name="g_non" class="form-control" onchange="change_non(this.value, 'edit')">
									<option value="0">Aset</option>
									<option value="1">Non Aset</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Jenis</label>
							<!--<div class="col-sm-10" id="tipe_aset_g" onchange="change_tipe('edit')">-->
							<!--<div class="col-sm-10" id="tipe_aset_g">
								
							</div>-->
							<div class="col-sm-5">
								<select id="tipe_aset_g" name="g_tipe" class="form-control">
									
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Nama Aset</label>
							<div class="col-sm-8">
								<input id="g_nama_edit" maxlength="54" name="g_nama" type="text" class="form-control" placeholder="Nama Aset">
								<input id="g_id_edit" name="g_id" type="text" hidden>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Kode Barang</label>
							<div class="col-sm-8">
								<input id="g_kode_edit" maxlength="54" name="g_kode" type="text" class="form-control" placeholder="Nomer Seri">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Merk</label>
							<div class="col-sm-5">
								<input id="g_merk_edit" maxlength="54" name="g_merk" type="text" class="form-control" placeholder="Merk Aset">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Tipe</label>
							<div class="col-sm-10">
								<input id="g_tipe_edit" maxlength="54" name="g_tipe_n" type="text" class="form-control" placeholder="Tipe Aset">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Ruangan</label>
							<div class="col-sm-6">
								<select data-plugin-selectTwo class="form-control populate" name="g_ruangan" id="g_ruangan_edit" placeholder="Ruangan">
									
								</select>
							</div>
							<div class="col-sm-4">
								<label class="checkbox-inline">
									<input type="checkbox" id="g_umum_edit" name="g_umum" onchange="change_umum('edit')"> Umum
								</label>
							</div>
						</div>
						<div id="div_stok_edit" class="form-group row">
							<label class="col-sm-2 col-form-label">Stok</label>
							<div class="col-sm-3">
								<input id="g_stok_edit" maxlength="54" name="g_stok" type="number" class="form-control" placeholder="Stok">
							</div>
							<div class="col-sm-4">
								<label class="checkbox-inline">
									<input type="checkbox" id="g_hbs_pakai_edit" name="g_hbs_pakai" onchange="change_hbs('edit')"> Habis Pakai
								</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Nomer Seri</label>
							<div class="col-sm-10">
								<input id="g_nose_edit" maxlength="54" name="g_nose" type="text" class="form-control" placeholder="Nomer Seri">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Penyedia</label>
							<div class="col-sm-10">
								<input id="g_penyedia_edit" maxlength="54" name="g_penyedia" type="text" class="form-control" placeholder="Penyedia">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">No Telp Penyedia</label>
							<div class="col-sm-10">
								<input id="g_telp_p_edit" maxlength="54" name="g_telp_p" type="text" class="form-control" placeholder="No Telpon penyedia">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Tanggal Pembelian</label>
							<div class="col-sm-3">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input id="g_tgl_beli_edit" name="g_tgl_beli" type="text" data-plugin-datepicker="" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Harga</label>
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input id="g_harga_edit" maxlength="54" name="g_harga" type="number" class="form-control" placeholder="Harga">
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Lokasi</label>
							<div class="col-sm-6">
								<input id="g_lokasi_edit" maxlength="54" name="g_lokasi" type="text" class="form-control" placeholder="Lokasi">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Penanggung Jawab</label>
							<div class="col-sm-5">
								<select id="g_unit_pj_edit" name="g_unit_pj" class="form-control">
									<option value="1">Instalasi IT & SIMRS</option>
									<option value="2">Instalasi IPSRS</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Status</label>
							<div class="col-sm-4">
								<select id="g_status_edit" name="g_status" class="form-control">
									
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Keterangan</label>
							<div class="col-sm-10">
								<textarea id="g_ket_edit" name="g_keterangan" class="form-control" placeholder="Keterangan"></textarea>
							</div>
							<div class="col-sm-8">&nbsp;</div>
						</div>
						<div class="form-groupm pull-right col-md-12">
							<button id="button_edit_modal_ak" type="submit" class="btn btn-primary waves-effect waves-light" onclick = "edit_data_proses()">Simpan Perubahan</button>
						</div>
					</form>
				</div>
			</section>
		</div>
	</div>
</section>
<?php include('scan_footer.php');?>

<script>
	$(document).ready( function() {
		var gid = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		
		if(type == 'aset'){
			edit_data(gid);
		}else{
			alert('Fitur ini hanya berlaku pada qr code aset');
		}		
	});
	
	function edit_data(id){
		$.ajax({
			url		: '../master/aset_data.php?f=get_data_edit',
			type	: 'POST',
			data	: {'gid':id},
			dataType: 'json',
			success	: function(data){
				get_tipe_aset(1, data.tipe_id, 'edit');
				get_status_aset(1, data.status_id, 'edit');
				get_ruangan_aset(data.ruangan_id, 'edit');
				$('#g_id_edit').val(data.aset_id);
				$('#g_nama_edit').val(data.nm_aset);
				$('#g_kode_edit').val(data.kd_barang);
				$('#g_merk_edit').val(data.merk_aset);
				$('#g_tipe_edit').val(data.tipe);
				$('#g_ket_edit').val(data.keterangan);
				$('#g_nose_edit').val(data.no_seri);
				$('#g_tgl_beli_edit').val(data.tanggal_pembelian);
				$('#g_unit_pj_edit').val(data.unit_pj);
				$('#g_stok_edit').val(data.stok);
				$('#g_non_edit').val(data.kriteria);
				$('#g_penyedia_edit').val(data.penyedia);
				$('#g_telp_p_edit').val(data.no_telp);
				$('#g_harga_edit').val(data.harga);
				$('#g_lokasi_edit').val(data.lokasi);
				//change_non(data.kriteria, 'edit');
				if(data.files == null || data.files == '' || data.files == '0000-00-00'){
					src_img = 'files/img/no-image.jpg';
				}else{
					src_img = data.files;
				}
				hbs = data.hbs_pakai == 1 ? true : false;
				umm = data.umum == 1 ? true : false;
				$('#g_hbs_pakai_edit').attr('checked', hbs);
				$('#g_umum_edit').attr('checked', umm);
				change_hbs('edit');
				change_umum('edit');
				$('#img_view').attr('src', src_img);
				/*if(data.tipe_id == 2){
					$('#g_nose_edit').attr('disabled',true);
					$('#g_nose_edit').val('');
				}else{
					$('#g_nose_edit').attr('disabled',false);
				}*/
				$('#edit_data_modal').modal('show');
			}
		});
	}
	
	function edit_data_proses(){
		$('#button_edit_modal_ak').text('Loading...');
		var formData = new FormData($("#edit_data_form").get(0));
		$.ajax({
			url		: '../master/aset_data.php?f=edit_data_proses',
			type	: 'POST',
			data	: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success	: function(data){
				$('#button_edit_modal_ak').text('Simpan Perubahan');
				if(data.sts == 1){
					new PNotify({
						title	: 'Berhasil',
						text	: 'Berhasil edit data',
						type	: 'success'
						//icon	: 'fa fa-home'
					});
					$('#edit_data_modal').modal('toggle');
					get_data();
				}else{
					new PNotify({
						title: 'Error',
						text: data.msg,
						type: 'error'
					});
				}
			},error: function(){
				$('#button_edit_modal_ak').text('Simpan Perubahan');
				new PNotify({
					title: 'Error',
					text: 'Gagal edit data',
					type: 'error'
				});
				$('#edit_data_modal').modal('toggle');
			}
		});
	}
	
	function get_tipe_aset(key,val,f){
		var iddiv = 'tipe_aset_add';
		if(f == 'edit'){
			iddiv = 'tipe_aset_g';
		}
		$.ajax({
			url		: '../master/global.php?f=get_option_tipe',
			type	: 'post',
			data	: {gkey:key, gval:val},
			dataType: 'json',
			success	: function(data){
				document.getElementById(iddiv).innerHTML = data;
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
	
	function save_tindakan(){
		aset		= document.forms['add_tindakan_form'].elements['g_aset'].value;
		petugas		= document.forms['add_tindakan_form'].elements['g_petugas'].value;
		tanggal 	= document.forms['add_tindakan_form'].elements['g_tanggal'].value;
		time	 	= document.forms['add_tindakan_form'].elements['g_time'].value;
		tindakan 	= document.forms['add_tindakan_form'].elements['g_tindakan'].value;
		status_aset	= document.forms['add_tindakan_form'].elements['g_status'].value;
		
		if(aset && petugas && tanggal && time && tindakan && status_aset){
			$.ajax({
				url		: 'scan_qrcode_data.php?f=save_tindakan_rutin',
				type	: 'post',
				data	: {aset_id : aset, petugas_id : petugas, tanggal:tanggal, time:time, tindakan:tindakan, status_aset:status_aset},
				dataType: 'json',
				success	: function(data){
					$('#add_tindakan_modal').modal('toggle');
					get_data(aset);
				},error	: function(){
					new PNotify({
						title: 'Gagal',
						text: 'Terjadi kesalahan sistem, silahkan dicoba kembali',
						type: 'error'
					});
				}
			});
		}else{
			new PNotify({
				title: 'Tidak Boleh Kosong',
				text: 'kolom bertanda * wajib diisi',
				type: 'warning'
			});
		}
	}
	
	/*function change_status(status_id){
		id = $('#g_id_action').val();
		var aset_id = "<?=$_GET['aset_id'];?>";
		$.ajax({
			url		: 'scan_qrcode_data.php?f=change_status',
			type	: 'post',
			data	: {gid_status:status_id, gid:id},
			dataType: 'json',
			success	: function(data){
				get_data(aset_id);
				//alert('success');
			},error	: function(){
				//alert('error');
			}
		});
	}*/
	
	function get_ruangan_aset(unit,f){
		$.ajax({
			url		: '../master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:unit, gf:'column'},
			dataType: 'json',
			success	: function(data){
				document.getElementById("g_ruangan_"+f).innerHTML = data;
				//group = $('#g_group_id').val();
				//$("#g_ruangan_"+f).select2("readonly", true);
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
			data	: {gf:'column'},
			type	: 'post',
			success	: function(data){
				document.getElementById('g_pelapor_'+f).innerHTML = data;
				$("#g_pelapor_"+f).select2("val", val);
				$("#g_pelapor_"+f).select2("readonly", true);
			}
		});
	}
	
	function hapus_data(id, aset_id){
		$.ajax({
			url		: 'scan_qrcode_data.php?f=hapus_data_tindakan',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				$('#add_tindakan_modal').modal('toggle');
				get_data(aset_id);
			},error	: function(){
				
			}
		});
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