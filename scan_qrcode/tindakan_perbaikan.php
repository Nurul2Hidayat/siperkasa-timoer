<?php 
	$home = 'Tindakan Perbaikan';
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
								<th class="center">id</th>
								<th class="center">jenis id</th>
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

<!--  action  -->
<div class="modal fade" id="action_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tindakan</h4>
			</div>
			<form id="action_data_form" onsubmit="return false">
				<input type="text" id="g_id_action" name="g_id" hidden>
				<input type="text" id="g_idaset_action" name="g_id_aset" hidden>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Aset</label>
						<div class="col-sm-4">
							<input id="g_aset_action" type="text" class="form-control" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_status_action" name="g_status" class="form-control" onchange="change_status(this.value)">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Permintaan </label>
						<div class="col-sm-10">
							<textarea class="form-control" id="g_permintaan_action" name="g_permintaan" placeholder="Permintaan" style="width:100%" readonly></textarea>
						</div>
					</div>
					<?php
						$hidden = $_SESSION['ruangan'] == 51 ? '' : 'hidden';
					?>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tindakan </label>
						<div class="col-sm-10">
							<button id='btn_add_tindakan' type='button' class='btn btn-primary <?=$hidden?>'>
								<i class='fa fa-plus'> Tambah Tindakan</i>
							</button>
							<div>&nbsp;</div>
							<table class="table table-striped table-bordered table-hover dataTables-example" id="dttindakan">
								<thead>
									<tr>
										<th class="center">NO</th>
										<th class="center">TINDAKAN</th>
										<th class="center">PETUGAS</th>
										<th class="center">TANGGAL</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
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

<!--  add tindakan  -->
<div class="modal fade" id="add_tindakan_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambah Tindakan</h4>
			</div>
			<form id="add_tindakan_form" onsubmit="return false">
				<input type="text" id="g_id_per_tindakan_add" name="g_id_per" hidden>
				<input type="text" id="g_id_aset_tindakan_add" name="g_id_aset" hidden>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tanggal <span class="required">*</span></label>
						<div class="col-sm-5">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input id="g_tgl_add_tindakan" name="g_tanggal" type="text" data-plugin-datepicker="" class="form-control" required>
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
								<input id="g_time_add_tindakan" name="g_time" class="form-control" type="text" data-plugin-timepicker="" data-plugin-options='{ "showMeridian": false }' required>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tindakan <span class="required">*</span></label>
						<div class="col-sm-10">
							<textarea class="form-control" id="g_tindakan_add_tindakan" name="g_tindakan" placeholder="tindakan" style="width:100%" required></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status Barang</label>
						<div class="col-sm-4">
							<select id="g_status_tindakan" name="g_status" class="form-control">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 control-label">Foto</label>
						<div class="col-md-5">
							<input type="file" id="g_file_add" name="g_file" class="form-control" onchange="change_file(this.value)">
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
				</div>
				<div id="add_tindakan_footer" class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button id="btn_save_tindakan" type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
				</div>
			</form>
		 </div>
	</div>
</div>

<!--  edit tindakan  -->
<div class="modal fade" id="edit_tindakan_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambah Tindakan</h4>
			</div>
			<form id="edit_tindakan_form" onsubmit="return false">
				<input type="text" id="g_id_tindakan" name="g_id" hidden>
				<input type="text" id="g_id_per_tindakan_edit" name="g_id_per" hidden>
				<input type="text" id="g_id_aset_tindakan_edit" name="g_id_aset" hidden>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tanggal <span class="required">*</span></label>
						<div class="col-sm-5">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input id="g_tgl_edit_tindakan" name="g_tanggal" type="text" data-plugin-datepicker="" class="form-control" required>
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
								<input id="g_time_edit_tindakan" name="g_time" class="form-control" type="text" data-plugin-timepicker="" data-plugin-options='{ "showMeridian": false }' required>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tindakan <span class="required">*</span></label>
						<div class="col-sm-10">
							<textarea class="form-control" id="g_tindakan_edit_tindakan" name="g_tindakan" placeholder="tindakan" style="width:100%" required></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status Barang</label>
						<div class="col-sm-4">
							<select id="g_status_tindakan_edit" name="g_status" class="form-control">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 control-label">Foto</label>
						<div class="col-md-5">
							<h5 id="gambar_tidakan_edit" style="color: blue;font-weight: bold;">Lihat Gambar</h5>
							<input type="file" id="g_file_edit" name="g_file" class="form-control" onchange="change_file(this.value)">
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button id="btn_save_edit_tindakan" type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!--  keterangan status  -->
<div class="modal fade" id="modal_ket_status" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tit_mdl_sts"></h4>
			</div>
			<div class="modal-body">
				<input id="g_id_sts" type="text" class="form-control hidden">
				<input id="g_id_act" type="text" class="form-control hidden">
				<div class="form-group row">
					<label id="lbl_sts" class="col-sm-2 col-form-label"></label>
					<div class="col-sm-4">
						<input id="g_ket_sts" type="text" class="form-control">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-primary waves-effect waves-light" onclick="save_sts()">Simpan</button>
			</div>
		</div>
	</div>
</div>

<!--  View Image  -->
<div class="modal fade" id="view_img_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lihat Gambar</h4>
			</div>
			<form id="edit_data_form" onsubmit="return false">
				<div class="modal-body">
					<iframe id="img_view" src="files/img/no-image.jpg" style="width : 100%; height : 600px"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
				</div>
			</form>
		 </div>
	</div>
</div>
<?php include('scan_footer.php');?>

<script>
	$(document).ready( function() {
		var gid = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		get_data(gid, type);
		//get_dtl_aset(aset_id);
		//$('#btn_add').attr('onclick', 'add_data('+aset_id+')');
		
		$('#dtaset tbody').on( 'click', 'tr', function () {
			var id = $('#dtaset').DataTable().row(this).data().permintaan_id;
			var jenis_id = $('#dtaset').DataTable().row(this).data().jenis_id;
			var aset_id = $('#dtaset').DataTable().row(this).data().aset_id;
			//editMember(data[0]);
			action(id, jenis_id, aset_id);
        });
		
		$('#dttindakan tbody').on( 'click', 'tr', function () {
			var id = $('#dttindakan').DataTable().row(this).data().id;
			edit_tindakan(id);
			//var jenis_id = $('#dtaset').DataTable().row(this).data().jenis_id;
			//var aset_id = $('#dtaset').DataTable().row(this).data().aset_id;
			//editMember(data[0]);
			//action(id, jenis_id, aset_id);
        });
		
		$("#action_modal").on("hidden.bs.modal", function () {
			get_data(gid, type);
		});
	});
	
	function get_data(gid, type){
		$('#dtaset').DataTable({
			"ajax"		: 'scan_qrcode_data.php?f=get_data_permintaan_perbaikan&gid='+gid+'&type='+type,
			"sAjaxDataProp": "data",
			"Processing": true, 
			"columns"	: [
							{"data" : "permintaan"},
							{"data" : "tgl_permintaan"},
							{"data" : "status"},
							{"data" : "permintaan_id", "visible":false},
							{"data" : "jenis_id", "visible":false},
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
			"autoWidth"	: false,
			"order"		: [[1, 'desc']],
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function action(id, jenis_id, aset_id){
		//alert(aset_id);return;
		$.ajax({
			url		: '../permintaan/ipsls_data.php?f=get_data_detail',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				get_status_aset(jenis_id, data.status_id, 'action');
				if(data.status_id ==  12){
					$('#g_status_action').attr('disabled', true);
				}else{
					$('#g_status_action').attr('disabled', false);
				}
				$('#g_aset_action').val(data.nm_aset);
				$('#g_permintaan_action').val(data.permintaan);
				$('#g_deskripsi_action').val(data.deskripsi);
				$('#btn_add_tindakan').attr('onclick', 'add_tindakan('+id+','+aset_id+','+data.status_id+')');
				get_data_tindakan(id);
				$('#action_modal').modal('show');
				$('#g_id_action').val(id);
				get_status_aset(1, data.status_aset, 'tindakan');
				
				$('#g_id_action').val(id);
				$('#g_idaset_action').val(aset_id);
				$('#g_alasan_action').val(data.alasan);
			},error	: function(){
				
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
	
	function get_data_tindakan(id){
		$('#dttindakan').DataTable({
			"ajax"		: '../permintaan/ipsls_data.php?f=get_data_tindakan&gid='+id,
			"sAjaxDataProp": "data",
			"Processing": true, 
			"columns"	: [
							{"data" : "no"},
							{"data" : "tindakan"},
							{"data" : "petugas"},
							{"data" : "tanggal"},
							{"data" : "id", "visible":false}
						],
			"columnDefs": [
							{
								render: function (data, type, full, meta) {
									return "<div class='text-wrap width-200'>" + data + "</div>";
								},
								targets: 1
							}
						 ],
			"searching"	: false,
			"paging"	: true,
			"ordering"	: true,
			"destroy"	: true,
			"info"		: false,
			"autoWidth"	: false,
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function add_tindakan(id, aset_id, val){
		$('#add_tindakan_modal').modal('show');
		//$('#add_tindakan_footer').html('<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button><button id="btn_save_tindakan" type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>');
		$('#g_id_aset_tindakan_add').val(aset_id);
		$('#g_id_per_tindakan_add').val(id);
		saiki = get_today();
		waktune = get_time();
		//$('#g_tgl_add_tindakan').datepicker();
		$('#g_tgl_add_tindakan').datepicker('setDate', saiki);
		$('#g_time_add_tindakan').val(waktune);
		/*var rupiah 	= document.getElementById('g_biaya_add_tindakan');
		rupiah.addEventListener('keyup', function(e){
			rupiah.value = formatrupiah(this.value, 'Rp. ');
		});*/
		
		$('#btn_save_tindakan').attr('onclick', 'save_tindakan('+id+','+aset_id+','+val+')');
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
	
	function cek_barang(key){
		ret = 0;
		$.ajax({
			async	: false,
			url		: '../permintaan/ipsls_data.php?f=cek_barang',
			type	: 'post',
			data	: {gkey:key},
			dataType: 'json',
			success	: function(data){
				ret =  data.unit_pj;
			},error	: function(){
				
			}
		});
		return ret;
	}
	
	function save_tindakan(id, aset_id, val){
		var formData = new FormData($("#add_tindakan_form").get(0));
		tanggal 	= document.forms['add_tindakan_form'].elements['g_tanggal'].value;
		time	 	= document.forms['add_tindakan_form'].elements['g_time'].value;
		tindakan 	= document.forms['add_tindakan_form'].elements['g_tindakan'].value;
		status_aset	= document.forms['add_tindakan_form'].elements['g_status'].value;
		file		= document.forms['add_tindakan_form'].elements['g_file'].value;
		aset_id		= document.forms['add_tindakan_form'].elements['g_id_aset'].value;
		
		if(tanggal && tindakan && time){
			ck 	= cek_barang(aset_id);
			lnjt = 1;
			msg = '';
			if(ck == 2){
				if(file){
					lnjt = 1;
				}else{
					lnjt = 0;
					msg = 'File Harus Terisi';
				}
			}else{
				lnjt = 1;
			}
			
			if(lnjt == 0){
				new PNotify({
					title: 'Tidak Boleh Kosong',
					text: msg,
					type: 'warning'
				});
			}else{
				$('#btn_save_tindakan').text('Loading...');
				$.ajax({
					url		: '../permintaan/ipsls_data.php?f=add_tindakan',
					type	: 'POST',
					//data	: {gid:id, g_tanggal:tanggal, g_time:time, g_tindakan:tindakan, g_status:status_aset, g_aset_id:aset_id},
					data	: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					success	: function(data){
						get_data_tindakan(id);
						$('#add_tindakan_modal').modal('toggle');
						if(val == 12 || val == 14){
							save_to_db_status(id, val, tindakan);
						}
					},error	: function(){
						new PNotify({
							title: 'Gagal',
							text: 'Terjadi kesalahan sistem, silahkan dicoba kembali',
							type: 'error'
						});
					}
				});
			}
		}else{
			new PNotify({
				title: 'Tidak Boleh Kosong',
				text: 'kolom bertanda * wajib diisi',
				type: 'warning'
			});
		}
	}
	
	function change_status(val){
		id = $('#g_id_action').val();
		aset_id = $('#g_idaset_action').val();
		$('#g_status_action').attr('disabled', false);
		if(val == 12 || val == 14){
			$('#g_status_action').attr('disabled', true);
			$('#add_tindakan_modal').modal('show');
			$('#g_id_aset_tindakan_add').val(aset_id);
			$('#g_id_per_tindakan_add').val(id);
			//$('#add_tindakan_footer').html('<button id="btn_save_tindakan" type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>');
			saiki = get_today();
			waktune = get_time();
			$('#g_tgl_add_tindakan').datepicker();
			$('#g_tgl_add_tindakan').datepicker('setDate', saiki);
			$('#g_time_add_tindakan').val(waktune);
			$('#btn_save_tindakan').attr('onclick', 'save_tindakan('+id+','+aset_id+','+val+')');
		}else if(val == 13){
			$('#g_id_act').val(id);
			$('#g_id_sts').val(val);
			$('#tit_mdl_sts').text('Alasan Dipending');
			$('#lbl_sts').text('Alasan');
			$('#g_ket_sts').val('');
			$('#modal_ket_status').modal('show');
		}else if(val == 15){
			$('#g_id_act').val(id);
			$('#g_id_sts').val(val);
			$('#tit_mdl_sts').text('Konfirmasi');
			$('#lbl_sts').text('Konfirmasi');
			$('#g_ket_sts').val('');
			$('#modal_ket_status').modal('show');
		}else{
			$.ajax({
				url		: '../permintaan/ipsls_data.php?f=change_status',
				type	: 'post',
				data	: {val, id},
				dataType: 'json',
				success	: function(data){
					if(data.sts == 1){
						new PNotify({
							title: 'Berhasil',
							text: data.msg,
							type: 'success'
						});
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
	}
	
	function save_sts(){
		val = $('#g_id_sts').val();
		id	= $('#g_id_act').val();
		ket = $('#g_ket_sts').val();
		$('#modal_ket_status').modal('toggle');
		save_to_db_status(id, val, ket);
	}
	
	function save_to_db_status(id, val, ket){
		if(ket){
			$.ajax({
				url		: '../permintaan/ipsls_data.php?f=change_status',
				type	: 'post',
				data	: {val, id, ket},
				dataType: 'json',
				success	: function(data){
					if(data.sts == 1){
						new PNotify({
							title: 'Berhasil',
							text: data.msg,
							type: 'success'
						});
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
		}else{
			new PNotify({
				title: 'Harus diisi',
				text: 'Data tidak boleh kosong',
				type: 'warning'
			});
		}
	}
	
	function change_alasan(val){
		id = $('#g_id_action').val();
		$.ajax({
			url		: '../permintaan/ipsls_data.php?f=change_alasan',
			type	: 'post',
			data	: {val, id},
			dataType: 'json',
			success	: function(data){
				if(data.sts == 1){
					new PNotify({
						title: 'Berhasil',
						text: data.msg,
						type: 'success'
					});
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
	
	function edit_tindakan(id){
		$.ajax({
			url		: '../permintaan/ipsls_data.php?f=get_dtl_tindakan&gid='+id,
			type	: 'get',
			dataType: 'json',
			success	: function(data){
				get_status_aset(1, data.status_id, 'tindakan_edit');
				$('#g_id_aset_tindakan_edit').val(data.aset_id);
				$('#g_id_per_tindakan_edit').val(data.permintaan_id);
				$('#g_id_tindakan').val(data.tindakan_id);
				$('#g_tgl_edit_tindakan').datepicker("setDate",data.tanggal);
				$('#g_time_edit_tindakan').timepicker("setTime",data.time);
				$('#g_tindakan_edit_tindakan').val(data.tindakan);
				$('#btn_save_edit_tindakan').attr('onclick', 'proses_edit_tindakan('+data.tindakan_id+','+data.aset_id+','+data.permintaan_id+')');
				$('#gambar_tidakan_edit').text('Lihat Gambar');
				$('#gambar_tidakan_edit').attr('onclick', 'view_img("../'+data.files+'")');
				if(data.status_id != data.status_aset){
					$('#g_status_tindakan_edit').attr('disabled', true);
				}else{
					//$('#g_status_tindakan_edit').attr('disabled', false);
				}
				$('#edit_tindakan_modal').modal('show');
			},error	: function(){
				new PNotify({
					title	: 'Error',
					text	: 'Gagal get data',
					type	: 'error'
				});
			}
		});
	}
	
	function view_img(src){
		$('#img_view').attr('src', src);
		$('#view_img_modal').modal('show');
	}
	
	function proses_edit_tindakan(id, aset_id, permintaan_id){
		var formData = new FormData($("#edit_tindakan_form").get(0));
		tanggal 	= document.forms['edit_tindakan_form'].elements['g_tgl_edit_tindakan'].value;
		tindakan 	= document.forms['edit_tindakan_form'].elements['g_tindakan_edit_tindakan'].value;
		status_aset	= document.forms['edit_tindakan_form'].elements['g_status_tindakan_edit'].value;
		time		= document.forms['edit_tindakan_form'].elements['g_time_edit_tindakan'].value;
		file		= document.forms['edit_tindakan_form'].elements['g_file'].value;
		aset_id		= document.forms['edit_tindakan_form'].elements['g_id_aset'].value;
		
		if(tanggal && tindakan && time){
			ck 	= cek_barang(aset_id);
			lnjt = 1;
			msg = '';
			if(ck == 2){
				if(file){
					lnjt = 1;
				}else{
					lnjt = 0;
					msg = 'File Harus Terisi';
				}
			}else{
				lnjt = 1;
			}
			
			if(lnjt == 0){
				new PNotify({
					title: 'Tidak Boleh Kosong',
					text: msg,
					type: 'warning'
				});
			}else{
				$('#btn_save_edit_tindakan').text('Loading...');				
				$.ajax({
					url		: '../permintaan/ipsls_data.php?f=proses_edit_tindakan',
					type	: 'post',
					//data	: {gid:id, g_tanggal:tanggal, g_tindakan:tindakan, g_status:status_aset, g_time:time, g_aset_id:aset_id},
					data	: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					success	: function(data){
						get_data_tindakan(permintaan_id);
						$('#edit_tindakan_modal').modal('toggle');
						$('#btn_save_edit_tindakan').text('Simpan');	
						if(data){
							new PNotify({
								title	: 'Success',
								text	: 'Data berhasil diedit',
								type	: 'success'
							});
						}
					},error	: function(){
						new PNotify({
							title	: 'Error',
							text	: 'Gagal edit data',
							type	: 'error'
						});
					}
				});
			}
		}else{
			new PNotify({
				title: 'Tidak Boleh Kosong',
				text: 'kolom bertanda * wajib diisi',
				type: 'warning'
			});
		}
		
		
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