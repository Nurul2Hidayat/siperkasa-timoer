<header class="page-header">
	<h2>Checklist 5R</h2>
</header>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Checklist</h5>
			</header>
			<div class="panel-body">
				<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#add_data_modal">
					<i class="fa fa-plus"></i> Tambah
				</button>
				<table class="table table-striped table-bordered table-hover dataTables-example" id="dtaset">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">PERIHAL</th>
							<th class="center">JENIS 5R</th>
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
</div>

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
						<label class="col-sm-2 col-form-label">Perihal</label>
						<div class="col-sm-10">
							<input id="g_nama_add" name="g_nama" type="text" class="form-control" placeholder="Nama Jenis">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jenis 5R</label>
						<div class="col-sm-4">
							<select id="g_jenis_add" name="g_jenis" class="form-control" placeholder="Jenis 5R">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Aktif</label>
						<div class="col-sm-4">
							<select id="g_aktif_add" name="g_aktif" class="form-control" placeholder="Aktif">
								<option value="1">Aktif</option>
								<option value="0">Tidak</option>
							</select>
						</div>
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
						<label class="col-sm-2 col-form-label">Perihal</label>
						<div class="col-sm-10">
							<input id="g_nama_edit" maxlength="54" name="g_nama" type="text" class="form-control" placeholder="Nama Jenis">
							<input id="g_id_edit" name="g_id" type="text" hidden>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jenis 5R</label>
						<div class="col-sm-4">
							<select id="g_jenis_edit" name="g_jenis" class="form-control" placeholder="Jenis 5R">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Aktif</label>
						<div class="col-sm-4">
							<select id="g_aktif_edit" name="g_aktif" class="form-control" placeholder="Aktif">
								<option value="1">Aktif</option>
								<option value="0">Tidak</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
						<button id="button_edit_modal_ak" type="submit" class="btn btn-primary waves-effect waves-light" onclick = "edit_data_proses()">Simpan Perubahan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready( function() {
		get_data();
		get_jenis('add', '');
		$("#edit_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("edit_data_form").reset();
		});
		
		$("#add_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("add_data_form").reset();
		});
	});
	
	function get_data(){
		$.ajax({
            url: '5R/data.php?f=get_data',
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
	
	function edit_data(id){
		$.ajax({
			url		: '5R/data.php?f=get_data_edit',
			type	: 'POST',
			data	: {'gid':id},
			dataType: 'json',
			success	: function(data){
				get_jenis('edit', data.vr_id);
				$('#g_id_edit').val(data.id);
				$('#g_nama_edit').val(data.perihal);
				$('#g_jenis_edit').val(data.vr_id);
				$('#g_aktif_edit').val(data.aktif);
				$('#edit_data_modal').modal('show');
			}
		});
	}
	
	function add_data(){
		var formData = new FormData($("#add_data_form").get(0));
		$.ajax({
			url		: '5R/data.php?f=add_data',
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
			url		: '5R/data.php?f=edit_data_proses',
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
				url		: '5R/data.php?f=hapus_data&gid='+id,
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
	
	function get_jenis(f, v){
		$.ajax({
			url	: '5R/data.php?f=get_jenis',
			type: 'POST',
            success: function(data) {
				$('#g_jenis_'+f).html(data);
				if(v){
					$('#g_jenis_'+f).val(v);
				}
			},error: function(){
				console.log('error');
			}
		});
	}
</script>
