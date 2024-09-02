<header class="page-header">
	<h2>Master Biaya</h2>
</header>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Biaya</h5>
			</header>
			<div class="panel-body">
				<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#add_data_modal">
					<i class="fa fa-plus"></i> Tambah
				</button>
				<table class="table table-striped table-bordered table-hover dataTables-example" id="dtaset">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">ASET</th>
							<th class="center">BIAYA</th>
							<th class="center">TANGGAL MULAI</th>
							<th class="center">TANGGAL AKHIR</th>
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
						<label class="col-sm-2 col-form-label">Aset</label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_aset" id="g_aset_add" placeholder="Ruangan">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nominal</label>
						<div class="col-sm-10">
							<input id="g_nominal_add" maxlength="54" name="g_nominal" type="text" class="form-control" placeholder="Nominal">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tanggal Mulai</label>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input id="g_tgl_mulai_add" name="g_tgl_mulai" type="text" data-plugin-datepicker="" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tanggal Akhir</label>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input id="g_tgl_akhir_add" name="g_tgl_akhir" type="text" data-plugin-datepicker="" class="form-control">
							</div>
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
						<label class="col-sm-2 col-form-label">Aset</label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_aset" id="g_aset_edit" placeholder="Ruangan">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nominal</label>
						<div class="col-sm-10">
							<input id="g_nominal_edit" maxlength="54" name="g_nominal" type="text" class="form-control" placeholder="Nominal">
							<input id="g_id_edit" name="g_id" type="text" hidden>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tanggal Mulai</label>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input id="g_tgl_mulai_edit" name="g_tgl_mulai" type="text" data-plugin-datepicker="" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tanggal Akhir</label>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input id="g_tgl_akhir_edit" name="g_tgl_akhir" type="text" data-plugin-datepicker="" class="form-control">
							</div>
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
		get_aset('', 'add');
		
		$("#edit_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("edit_data_form").reset();
		});
		
		$("#add_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("add_data_form").reset();
		});
	});
	
	function get_data(){
		$.ajax({
            url: 'master/biaya_data.php?f=get_data',
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
			url		: 'master/biaya_data.php?f=get_data_edit',
			type	: 'POST',
			data	: {'gid':id},
			dataType: 'json',
			success	: function(data){
				get_aset(data.aset_id, 'edit');
				$('#g_id_edit').val(data.biaya_id);
				$('#g_nominal_edit').val(data.nominal);
				$('#g_tgl_mulai_edit').val(data.start_date);
				$('#g_tgl_akhir_edit').val(data.end_date);
				$('#edit_data_modal').modal('show');
			}
		});
	}
	
	function add_data(){
		var formData = new FormData($("#add_data_form").get(0));
		$.ajax({
			url		: 'master/biaya_data.php?f=add_data',
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
			url		: 'master/biaya_data.php?f=edit_data_proses',
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
				url		: 'master/biaya_data.php?f=hapus_data&gid='+id,
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
	
	function get_aset(id,f){
		$.ajax({
			url		: 'master/global.php?f=get_aset',
			type	: 'get',
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_aset_'+f).innerHTML = data;
				$("#g_aset_"+f).select2("val", id);
			}
		});
	}
</script>
