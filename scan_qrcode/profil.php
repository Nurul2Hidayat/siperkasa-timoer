<?php
	$home = 'Profil';
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
					<form id="add_tindakan_form" onsubmit="return false">
						<input type="text" id="g_id" name="g_id" hidden>
						<div class="modal-body">
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Nama <span class="required">*</span></label>
								<div class="col-sm-6">
									<input id="g_nama" type="text" class="form-control" name="g_nama" placeholder="Nama" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">NIP <span class="required">*</span></label>
								<div class="col-sm-10">
									<input id="g_nip" type="text" class="form-control" name="g_nip" placeholder="NIP" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">No HP <span class="required">*</span></label>
								<div class="col-sm-10">
									<input id="g_no_hp" type="text" class="form-control" name="g_no_hp" placeholder="No HP">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Kepegawaian <span class="required">*</span></label>
								<div class="col-sm-4">
									<input id="g_kepegawaian" type="text" class="form-control" name="g_kepegawaian" placeholder="Jabatan" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Status</label>
								<div class="col-sm-4">
									<select id="g_status" name="g_status" class="form-control" readonly>
										<option value="1">Aktif</option>
										<option value="0">Tidak Aktif</option>
									</select>
								</div>
							</div>
							<div class="col-sm-8">&nbsp;</div>
							<button id="btn_save_tindakan" type="submit" class="btn btn-primary waves-effect waves-light" onclick="change_pass()"><i class="fa fa-repeat"></i> Ubah Password</button>
							<div class="col-sm-8">&nbsp;</div>
						</div>
						<div class="modal-footer">
							<button id="btn_save_tindakan" type="submit" class="btn btn-primary waves-effect waves-light" onclick="save()">Simpan</button>
						</div>
					</form>
				</div>
			</section>
		</div>
	</div>
</section>

<!--  change password  -->
<div class="modal fade" id="change_password_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ubah Password</h4>
			</div>
			<form id="change_password_form" onsubmit="return false">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Password Baru <span class="required">*</span></label>
						<div class="col-sm-6">
							<input id="g_pass_new" type="password" class="form-control" placeholder="Password Baru">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Konfirmasi Password Baru <span class="required">*</span></label>
						<div class="col-sm-6">
							<input id="g_pass_kon" type="password" class="form-control" placeholder="Konfirmasi Password Baru">
						</div>
					</div>
					<div class="col-sm-8">&nbsp;</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Password Lama <span class="required">*</span></label>
						<div class="col-sm-6">
							<input id="g_pass_old" type="password" class="form-control" placeholder="Password Lama">
						</div>
					</div>
					<div class="col-sm-8">&nbsp;</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary waves-effect waves-light" onclick="update_pass()">Simpan</button>
				</div>
			</form>
		 </div>
	</div>
</div>
<?php include('scan_footer.php');?>

<script>
	$(document).ready( function() {
		get_data();
	});
	
	function get_data(){
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_data_pegawai',
			type	: 'post',
			dataType: 'json',
			success	: function(data){
				//console.log(data);return;
				$('#g_id').val(data.PEGAWAI_ID);
				$('#g_nama').val(data.NAMA);
				$('#g_nip').val(data.NIP);
				$('#g_no_hp').val(data.HP);
				$('#g_kepegawaian').val(data.STATUS_KEPEGAWAIAN);				
				$('#g_status').val(data.AKTIF);
			},error	: function(){
				
			}
		});
	}
	
	function save(){
		//id = $('#g_id').val();
		no_hp = $('#g_no_hp').val();
		$.ajax({
			url		: 'scan_qrcode_data.php?f=save_no_hp',
			type	: 'POST',
			data	: {nohp:no_hp},
			dataType: 'json',
			success	: function(data){
				if(data.sts == 1){
					new PNotify({
						title: 'Berhasil',
						text: data.msg,
						type: 'success'
					});
					location.reload();
				}else{
					new PNotify({
						title: 'Gagal',
						text: data.msg,
						type: 'warning'
					});
				}
			},error	: function(){
				new PNotify({
					title: 'Error',
					text: 'Terjadi kesalahan sistem, silahkan coba lagi',
					type: 'Error'
				});
			}
		});
	}
	
	function change_pass(){
		$('#change_password_modal').modal('show');
		$('#change_password_form').trigger("reset");
	}
	
	function update_pass(){
		pass_new = $('#g_pass_new').val();
		pass_kon = $('#g_pass_kon').val();
		pass_old = $('#g_pass_old').val();
		$.ajax({
			url		: 'scan_qrcode_data.php?f=update_password',
			type	: 'POST',
			data	: {gpass_new:pass_new, gpass_kon:pass_kon, gpass_old:pass_old},
			dataType: 'json',
			success	: function(data){
				if(data.sts == 1){
					new PNotify({
						title: 'Berhasil',
						text: data.msg,
						type: 'success'
					});
					$('#change_password_modal').modal('toggle');
				}else{
					new PNotify({
						title: 'Gagal',
						text: data.msg,
						type: 'warning'
					});
				}
			},error	: function(){
				new PNotify({
					title: 'Error',
					text: 'Terjadi kesalahan sistem, silahkan coba lagi',
					type: 'Error'
				});
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