<header class="page-header">
	<h2>Master Status</h2>
</header>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Status</h5>
			</header>
			<div class="panel-body">
				<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#add_data_modal">
					<i class="fa fa-plus"></i> Tambah
				</button>
				<table class="table table-striped table-bordered table-hover dataTables-example" id="dtaset">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">JENIS</th>
							<th class="center">NAMA</th>
							<th class="center">DESKRIPSI</th>
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
						<label class="col-sm-2 col-form-label">Jenis</label>
						<div class="col-sm-4">
							<select data-plugin-selectTwo class="form-control populate" id="g_jenis_add" name="g_jenis" class="form-control">
								
							</select>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nama Status</label>
						<div class="col-sm-10">
							<input id="g_nama_add" maxlength="54" name="g_nama" type="text" class="form-control" placeholder="Nama Status">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Deskripsi</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="g_deskripsi_add" name="g_deskripsi" placeholder="Deskripsi" style="width:100%"></textarea>
							<!--<input id="g_deskripsi_add" maxlength="54" name="g_deskripsi" type="text" class="form-control" placeholder="Deskripsi">-->
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_aktif_add" name="g_aktif" class="form-control">
								<option value='1'> Aktif</option>
								<option value='2'> Tidak Aktif</option>
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
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				</button>-->
			</div>
			<form id="edit_data_form" onsubmit="return false">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jenis</label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" id="g_jenis_edit" name="g_jenis" class="form-control">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nama Status</label>
						<div class="col-sm-10">
							<input id="g_nama_edit" maxlength="54" name="g_nama" type="text" class="form-control" placeholder="Nama Status">
							<input id="g_id_edit" name="g_id" type="text" hidden>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Deskripsi</label>
						<div class="col-sm-6">
							<textarea class="form-control" id="g_deskripsi_edit" name="g_deskripsi" placeholder="Deskripsi" style="width:100%"></textarea>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_aktif_edit" name="g_aktif" class="form-control">
								<option value='1'> Aktif</option>
								<option value='2'> Tidak Aktif</option>
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
		get_jenis('', 'add');
		$("#edit_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("edit_data_form").reset();
		});
		
		$("#add_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("add_data_form").reset();
		});
	});
	
	function get_data(){
		$.ajax({
            url: 'master/status_data.php?f=get_data',
            type: 'POST',
			dataType: 'json',
            success: function(data) {
				$('#dtaset tbody').html(data);
				tab = $('#dtaset').DataTable({
                    "searching"	: true,
                    "paging"	: true,
                    "ordering"	: true,
					"retrieve"	: true
                });
			},error: function(){
				console.log('error');
			}
		});
	}
	
	function edit_data(id, jenis_id){
		$.ajax({
			url		: 'master/status_data.php?f=get_data_edit',
			type	: 'POST',
			data	: {'gid':id},
			dataType: 'json',
			success	: function(data){
				get_jenis(data.jenis_id, 'edit');
				$('#g_jenis_edit').val(data.jenis_id);
				$('#g_id_edit').val(data.status_id);
				$('#g_nama_edit').val(data.nm_status);
				$('#g_deskripsi_edit').val(data.deskripsi);
				$('#g_aktif_edit').val(data.aktif);
				$('#edit_data_modal').modal('show');
			}
		});
	}
	
	function add_data(){
		var formData = new FormData($("#add_data_form").get(0));
		$.ajax({
			url		: 'master/status_data.php?f=add_data',
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
					title: 'Error',
					text: 'Gagal menambahkan data',
					type: 'error'
				});
				$('#add_data_modal').modal('toggle');
			}
		});
	}
	
	function edit_data_proses(){
		var formData = new FormData($("#edit_data_form").get(0));
		$.ajax({
			url		: 'master/status_data.php?f=edit_data_proses',
			type	: 'POST',
			data	: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success	: function(data){
				$('#edit_data_modal').modal('toggle');
				get_data();
				new PNotify({
					title	: 'Berhasil',
					text	: 'Berhasil edit data',
					type	: 'success'
					//icon	: 'fa fa-home'
				});
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
				url		: 'master/status_data.php?f=hapus_data&gid='+id,
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
	
	function get_tipe_aset(key,val,f){
		var iddiv = 'tipe_aset_add';
		if(f == 'edit'){
			iddiv = 'tipe_aset_g';
		}
		$.ajax({
			url		: 'master/global.php?f=get_option_tipe',
			type	: 'post',
			data	: {gkey:key, gval:val},
			dataType: 'json',
			success	: function(data){
				document.getElementById(iddiv).innerHTML = data;
			}
		});
	}
	
	function get_status_aset(key, val, f){
		var iddiv = 'g_status_add';
		if(f == 'edit'){
			iddiv = 'g_status_edit';
		}
		$.ajax({
			url		: 'master/global.php?f=get_option_status',
			type	: 'post',
			data	: {gkey:key, gval:val},
			dataType: 'json',
			success	: function(data){
				document.getElementById(iddiv).innerHTML = data;
			}
		});
	}
	
	function get_ruangan_aset(id,f){
		var iddiv = 'g_ruangan_add';
		if(f == 'edit'){
			iddiv = 'g_ruangan_edit';
		}
		$.ajax({
			url		: 'master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				document.getElementById(iddiv).innerHTML = data;
				$("#"+iddiv).select2("val", id);
			}
		});
	}
	
	function get_jenis(id,f){
		$.ajax({
			url		: 'master/global.php?f=get_option_jenis',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_jenis_'+f).innerHTML = data;
				$("#g_jenis_edit").select2("val", id);
			}
		});
	}
</script>
