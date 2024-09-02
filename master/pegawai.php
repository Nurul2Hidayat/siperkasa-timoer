<header class="page-header">
	<h2>Master Pegawai</h2>
</header>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Pegawai</h5>
			</header>
			<div class="panel-body">
				<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#add_data_modal">
					<i class="fa fa-plus"></i> Tambah
				</button>
				<table class="table table-striped table-bordered table-hover dataTables-example" id="dtpegawai">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">NAMA</th>
							<th class="center">NIP</th>
							<th class="center">NO HP</th>
							<th class="center">RUANGAN</th>
							<th class="center">KEPEGAWAIAN</th>
							<th class="center">STATUS</th>
							<th class="center">AKSI</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</section>
	</div>
<div>

<!--  Add Data  -->
<div class="modal fade" id="add_data_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambah Data</h4>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				</button>-->
			</div>
			<form id="add_data_form" onsubmit="return false">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nama Pegawai</label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_nama" id="g_nama_add" placeholder="Nama Ruangan" onchange="change_peg_add(this.value)">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">NIP</label>
						<div class="col-sm-5">
							<input id="g_nm_peg_add" name="g_nm_peg" type="text" hidden>
							<input id="g_nip_add" maxlength="54" name="g_nip" type="text" class="form-control" placeholder="NIP" readonly>
						</div>
						<label class="col-sm-1 col-form-label">No HP</label>
						<div class="col-sm-4">
							<input id="g_no_hp_add" maxlength="54" name="g_no_hp" type="text" class="form-control" placeholder="No HP">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kepegawaian</label>
						<div class="col-sm-4">
							<input id="g_kepegawaian_add" maxlength="54" name="g_kepegawaian" type="text" class="form-control" placeholder="Kepegawaian" readonly>
						</div>
						<label class="col-sm-1 col-form-label">Ruangan</label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="g_ruangan" id="g_ruangan_add" placeholder="Ruangan">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Role</label>
						<div class="col-sm-2">
							<select id="g_role_add" name="g_role" class="form-control">
								
							</select>
						</div>
						<label class="col-sm-1 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_status_add" name="g_status" class="form-control">
								<option value="1">Aktif</option>
								<option value="0">Tidak Aktif</option>
							</select>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary waves-effect waves-light" onclick = "add_data()">Tambah Data</button>
				</div>
			</form>
		 </div>
	</div>
</div>

<!--  Edit Data  -->
<div class="modal fade" id="edit_data_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Data</h4>
			</div>
			<form id="edit_data_form" onsubmit="return false">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nama Pegawai</label>
						<div class="col-sm-10">
							<input id="g_nama_edit" maxlength="54" name="g_nama" type="text" class="form-control" placeholder="Nama Pegawai" readonly>
							<input id="g_id_edit" name="g_id" type="text" hidden>
							<input id="g_id_peg_edit" name="g_id_peg" type="text" hidden>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">NIP</label>
						<div class="col-sm-5">
							<input id="g_nip_edit" maxlength="54" name="g_nip" type="text" class="form-control" placeholder="NIP" readonly>
						</div>
						<label class="col-sm-1 col-form-label">No HP</label>
						<div class="col-sm-4">
							<input id="g_no_hp_edit" maxlength="54" name="g_no_hp" type="text" class="form-control" placeholder="No HP">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kepegawaian</label>
						<div class="col-sm-4">
							<input id="g_kepegawaian_edit" maxlength="54" name="g_kepegawaian" type="text" class="form-control" placeholder="Kepegawaian" readonly>
						</div>
						<label class="col-sm-1 col-form-label">Ruangan</label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="g_ruangan" id="g_ruangan_edit" placeholder="Ruangan">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Role</label>
						<div class="col-sm-2">
							<select id="g_role_edit" name="g_role" class="form-control">
								
							</select>
						</div>
						<label class="col-sm-1 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_status_edit" name="g_status" class="form-control">
								<option value="1">Aktif</option>
								<option value="0">Tidak Aktif</option>
							</select>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button id="button_edit_modal_ak" type="submit" class="btn btn-primary waves-effect waves-light" onclick = "edit_data_proses()">Simpan Perubahan</button>
				</div>
			</form>
		 </div>
	</div>
</div>

<script>
	$(document).ready( function() {
		get_data();
		get_ruangan_aset('', 'add');
		get_role('', 'add');
		get_pegawai_baru();
		//get_status_aset(2, '', 'add');
		
		$("#edit_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("edit_data_form").reset();
		});
		
		$("#add_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("add_data_form").reset();
		});
	});
	
	function get_pegawai_baru(){
		$.ajax({
			url		: 'master/pegawai_data.php?f=get_pegawai_baru',
			type	: 'POST',
			success	: function(data){
				document.getElementById("g_nama_add").innerHTML = data;
			}
		});
	}
	
	function change_peg_add(val){
		$.ajax({
			url		: 'master/pegawai_data.php?f=get_dtl_peg',
			type	: 'POST',
			data	: {'gid':val},
			dataType: 'json',
			success	: function(data){
				$('#g_nm_peg_add').val(data.NAMA);
				$('#g_nip_add').val(data.NIP);
				$('#g_no_hp_edit').val(data.HP);
				$('#g_kepegawaian_add').val(data.STATUS_KEPEGAWAIAN);
			}
		});
	}
	
	function get_data(){	
		$('#dtpegawai').DataTable({
			"ajax"		: 'master/pegawai_data.php?f=get_data',
			"sAjaxDataProp": "data",
			"Processing": true,
			"serverSide": false,
			"columns"	: [
							{"data" : "no", "searchable": false},
							{"data" : "nama"},
							{"data" : "nip"},
							{"data" : "no_hp"},
							{"data" : "ruangan"},
							{"data" : "kepegawaian", "searchable": false},
							{"data" : "status", "searchable": false},
							{"data" : "aksi", "searchable": false, "orderable": false}
						],
			"searching"	: true,
			"paging"	: true,
			"ordering"	: true,
			"order"		: [[0, 'asc']],
			"destroy"	: true,
			"info"		: true,
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function edit_data(id){
		$.ajax({
			url		: 'master/pegawai_data.php?f=get_data_edit',
			type	: 'POST',
			data	: {'gid':id},
			dataType: 'json',
			success	: function(data){
				$('#g_id_edit').val(data.id);
				$('#g_id_peg_edit').val(data.pegawai_id);
				$('#g_nama_edit').val(data.NAMA);
				$('#g_nip_edit').val(data.NIP);
				$('#g_no_hp_edit').val(data.HP);
				$('#g_kepegawaian_edit').val(data.STATUS_KEPEGAWAIAN);
				get_role(data.role_id, 'edit');
				get_ruangan_aset(data.ruangan_id, 'edit');
				$('#g_status_edit').val(data.aktif);
				
				$('#edit_data_modal').modal('show');
			}
		});
	}
	
	function add_data(){
		var formData = new FormData($("#add_data_form").get(0));
		$.ajax({
			url		: 'master/pegawai_data.php?f=add_data',
			type	: 'POST',
			data	: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success	: function(data){
				$('#add_data_modal').modal('toggle');
				get_data();
				new PNotify({
					title	: 'Berhasil',
					text	: 'Berhasil menambahkan data',
					type	: 'success'
					//icon	: 'fa fa-home'
				});
			},error: function(){
				new PNotify({
					title	: 'Error',
					text	: 'Gagal menambahkan data',
					type	: 'error'
				});
				$('#add_data_modal').modal('toggle');
			}
		});
	}
	
	function edit_data_proses(){
		var formData = new FormData($("#edit_data_form").get(0));
		$.ajax({
			url		: 'master/pegawai_data.php?f=edit_data_proses',
			type	: 'POST',
			data	: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success	: function(data){
				$('#edit_data_modal').modal('toggle');
				get_data();
				if(data.sts == 1){
					new PNotify({
						title	: 'Berhasil',
						text	: 'Berhasil edit data',
						type	: 'success'
						//icon	: 'fa fa-home'
					});
				}else{
					new PNotify({
						title	: 'Gagal',
						text	: data.msg,
						type	: 'warning'
						//icon	: 'fa fa-home'
					});
				}
			},error: function(){
				new PNotify({
					title: 'Error',
					text: 'Gagal edit data',
					type: 'error'
				});
				$('#edit_data_modal').modal('toggle');
			}
		});
	}
	
	function hapus_data(id){
		cc = confirm("Apakah anda yakin ingin menghapus data ini.?");
		if(cc == true){
			$.ajax({
				url		: 'master/pegawai_data.php?f=hapus_data&gid='+id,
				type	: 'get',
				contentType	: false,
				processData : false,
				success	: function(){
					new PNotify({
						title	: 'Berhasil',
						text	: 'Data telah dihapus',
						type	: 'success'
						//icon	: 'fa fa-home'
					});
					get_data();
				},error	: function(){
					new PNotify({
					title: 'Error',
					text: 'Gagal hapus data',
					type: 'error'
				});
				}
			});
		}
	}

	function get_ruangan_aset(id,f){
		var iddiv = 'g_ruangan_add';
		if(f == 'edit'){
			iddiv = 'g_ruangan_edit';
		}
		$.ajax({
			url		: 'master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:id, gf:f},
			dataType: 'json',
			success	: function(data){
				document.getElementById(iddiv).innerHTML = data;
				$("#"+iddiv).select2("val", id);
			}
		});
	}
	
	function get_role(id,f){
		var iddiv = 'g_role_add';
		if(f == 'edit'){
			iddiv = 'g_role_edit';
		}
		$.ajax({
			url		: 'master/global.php?f=get_role',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				document.getElementById(iddiv).innerHTML = data;
			}
		});
	}
</script>