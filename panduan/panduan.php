<input id='g_group_id' type='text' value="<?=$_SESSION['group']?>" hidden>
<input id='g_unit_id' type='text' value="<?=$_SESSION['ruangan']?>" hidden>
<input id='g_ruangan_id' type='text' value="<?=$_SESSION['ruangan']?>" hidden>
<header class="page-header">
	<h2>Panduan Penggunaan Aplikasi</h2>
</header>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Panduan Penggunaan Aplikasi</h5>
			</header>
			<div class="panel-body">
				<div class="row">
					<iframe src="assets/files/panduan/PANDUAN_SIPERKASA_TIMOR.pdf" title="Panduan Penggunaan Aplikasi" style="width:100%; height:800px"></iframe> 
				</div>
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
						<label class="col-sm-2 col-form-label">Ruangan <span class="required">*</span></label>
						<div class="col-sm-6">
							<select data-plugin-selectTwo class="form-control populate" name="g_ruangan" id="g_ruangan_add" placeholder="Ruangan" onchange="get_aset('', this.value, 'add')" required>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Barang <span class="required">*</span></label>
						<div class="col-sm-8">
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
					<div class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Status </label>
						<div class="col-sm-4">
							<select id="g_status_add" name="g_status" class="form-control">
								
							</select>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 control-label">Gambar Aset <span class="required c_unit">*</span></label>
						<div class="col-md-5">
							<input type="file" id="g_file_add" name="g_file" class="form-control" onchange="change_file(this.value)">
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
				<input type="text" id="g_id_edit" name="g_id" hidden>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Ruangan <span class="required">*</span></label>
						<div class="col-sm-6">
							<select data-plugin-selectTwo class="form-control populate" name="g_ruangan" id="g_ruangan_edit" placeholder="Ruangan" onchange="get_aset('', this.value, 'edit')" required>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Barang </label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_aset" id="g_aset_edit" placeholder="Barang" onchange="change_barang(this.value, '', 'edit')">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Merk </label>
						<div class="col-sm-4">
							<input id="g_merk_edit" maxlength="54" type="text" class="form-control" placeholder="Merk" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">No. Seri </label>
						<div class="col-sm-6">
							<input id="g_nosi_edit" maxlength="54" type="text" class="form-control" placeholder="No. Seri" disabled>
						</div>
					</div>
					<div id="div_tipe_edit" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Tipe <span class="required">*</span></label>
						<div class="col-sm-8">
							<select class="form-control populate" name="g_tipe" id="g_tipe_edit" placeholder="Tipe Permintaan">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kerusakan <span class="required">*</span></label>
						<div class="col-sm-10">
							<textarea class="form-control" id="g_permintaan_edit" name="g_permintaan" placeholder="Kerusakan" style="width:100%" required></textarea>
						</div>
					</div>
					<div id="div_stok_edit" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Jumlah <span class="required">*</span></label>
						<div class="col-sm-4">
							<input id="g_stok_edit" maxlength="54" name="g_stok" type="number" class="form-control" placeholder="Jumlah">
						</div>
					</div>
					<div id="div_lokasi_edit" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Lokasi <span class="required">*</span></label>
						<div class="col-sm-10">
							<input id="g_lokasi_edit" maxlength="54" name="g_lokasi" type="text" class="form-control" placeholder="Lokasi">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Pelapor <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_pelapor" id="g_pelapor_edit" placeholder="Pelapor" required>
								
							</select>
						</div>
					</div>
					<div class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_status_edit" name="g_status" class="form-control">
								
							</select>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 control-label">Gambar Aset <span class="required c_unit">*</span></label>
						<div class="col-md-5">
							<input type="file" id="g_file_edit" name="g_file" class="form-control" onchange="change_file(this.value)">
						</div>
						<div class="col-md-5">
							<p id="view_img" onclick="view_img()">lihat gambar</p>
						</div>
						<div class="col-sm
						<div class="col-sm-8">&nbsp;</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button id="" type="submit" class="btn btn-primary waves-effect waves-light" onclick = "edit_data_proses()">Simpan Perubahan</button>
				</div>
			</form>
		 </div>
	</div>
</div>

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
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_status_action" name="g_status" class="form-control" onchange="change_status(this.value)">
								
							</select>
						</div>
					</div>
					<div class="col-sm-12">&nbsp;</div>
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
										<th class="center">AKSI</th>
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
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input id="g_tgl_add_tindakan" name="g_tanggal" type="text" data-plugin-datepicker="" class="form-control" required>
							</div>
						</div>
						<div class="col-sm-3">
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
				<h4 class="modal-title">Edit Tindakan</h4>
			</div>
			<form id="edit_tindakan_form" onsubmit="return false">
				<input type="text" id="g_id_tindakan" name="g_id" hidden>
				<input type="text" id="g_id_per_tindakan_edit" name="g_id_per" hidden>
				<input type="text" id="g_id_aset_tindakan_edit" name="g_id_aset" hidden>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tanggal <span class="required">*</span></label>
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input id="g_tgl_edit_tindakan" name="g_tanggal" type="text" data-plugin-datepicker="" class="form-control" required>
							</div>
						</div>
						<div class="col-sm-3">
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
							<select id="g_status_tindakan_edit" name="g_status" class="form-control" disabled>
								
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
					<div class="col-sm-10">
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

<!--  View Image Tindakan -->
<div class="modal fade" id="view_img_modal_tindakan" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lihat Gambar</h4>
			</div>
			<div class="modal-body">
				<iframe id="img_view_tindakan" src="files/img/no-image.jpg" style="width : 100%; height : 600px"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
			</div>
		 </div>
	</div>
</div>

<script>
	$(document).ready( function() {
		get_ruangan_aset('', 'filter');
		get_pegawai('', 'filter');
		get_status_aset(5, '', 'filter');
		get_data();
		saiki = get_today();
		//$('#g_tgl_filter').datepicker('setDate', saiki);
		//get_aset('', '', 'filter');
		
		$("#add_data_modal").on("shown.bs.modal", function () {
			get_status_aset(5, '', 'add');
			get_ruangan_aset('', 'add');
			get_aset('', '', 'add');
			get_pegawai('', 'add');
		});
		
		$("#edit_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("edit_data_form").reset();
		});
		
		$("#add_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("add_data_form").reset();
		});
		
		$("#action_modal").on("hidden.bs.modal", function () {
			get_data();
		});
	});
	
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
		fruangan	= $('#g_ruangan_filter').val();
		fpelapor	= $('#g_pelapor_filter').val();
		ftanggal	= $('#g_tgl_filter').val();
		fstatus		= $('#g_status_filter').find(':selected').val();
		
		$('#dtaset').DataTable({
			"ajax"		: {
				"url"		: 'permintaan/ipsls_data.php?f=get_data',
				"type"		: 'POST',
				"data"		: {"gruangan":fruangan, "gpelapor":fpelapor, "gtanggal":ftanggal, "gstatus":fstatus}
			},
			"sAjaxDataProp": "data",
			"Processing": true, 
			"serverSide": true,
			"columns"	: [
							{"data" : "no"},
							{"data" : "ruangan"},
							{"data" : "pelapor"},
							{"data" : "barang"},
							{"data" : "permintaan"},
							{"data" : "tipe"},
							{"data" : "jumlah"},
							{"data" : "tgl_permintaan"},
							{"data" : "status"},
							{"data" : "aksi"}
						],
			"searching"	: true,
			"paging"	: true,
			"ordering"	: true,
			"destroy"	: true,
			"info"		: true,
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function edit_data(id, jenis_id){
		$.ajax({
			url		: 'permintaan/ipsls_data.php?f=get_data_edit',
			type	: 'POST',
			data	: {'gid':id},
			dataType: 'json',
			success	: function(data){
				get_status_aset(jenis_id, data.status_id, 'edit');
				get_ruangan_aset(data.ruangan_id, 'edit');
				get_aset(data.aset_id, data.ruangan_id, 'edit');
				get_pegawai(data.pelapor, 'edit');
				change_barang(data.aset_id, data.tipe_id, 'edit');
				$('#g_id_edit').val(data.permintaan_id);
				$('#g_permintaan_edit').val(data.permintaan);
				$('#g_deskripsi_edit').val(data.deskripsi);
				$('#g_tgl_permintaan_edit').val(data.tanggal_permintaan);
				$('#g_lokasi_edit').val(data.lokasi);
				$('#g_stok_edit').val(data.jumlah);
				$('#img_view').attr('src', 'files/img/permintaan/'+data.gambar);
				$('#edit_data_modal').modal('show');
			}
		});
	}
	
	function add_data(){
		c_ruangan 	= document.forms['add_data_form'].elements['g_ruangan'].value;
		c_pelapor 	= document.forms['add_data_form'].elements['g_pelapor'].value;
		c_permintaan= document.forms['add_data_form'].elements['g_permintaan'].value;
		c_aset 		= document.forms['add_data_form'].elements['g_aset'].value;
		c_lokasi	= document.forms['add_data_form'].elements['g_lokasi'].value;
		c_file		= document.forms['add_data_form'].elements['g_file'].value;
		
		h_lokasi	= $('#div_lokasi_add').attr('hidden');
		
		if(c_pelapor == '' || c_permintaan == '' || c_ruangan == '' || c_aset == ''){
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
			var formData = new FormData($("#add_data_form").get(0));
			$.ajax({
				url		: 'permintaan/ipsls_data.php?f=add_data',
				type	: 'POST',
				data	: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success	: function(data){
					if(data.sts == 1){
						$('#add_data_modal').modal('toggle');
						get_data();
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
					$('#add_data_modal').modal('toggle');
				}
			});
		}
	}
	
	function edit_data_proses(){
		c_ruangan = document.forms['edit_data_form'].elements['g_ruangan'].value;
		c_pelapor = document.forms['edit_data_form'].elements['g_pelapor'].value;
		c_permintaan = document.forms['edit_data_form'].elements['g_permintaan'].value;
		
		if(c_pelapor == '' || c_permintaan == '' || c_ruangan == ''){
			required = 1;
		}else{
			required = 0;
		}
		
		if(required == 1){
			new PNotify({
				title	: 'Isi Form',
				text	: 'Silahkan isi form yang harus diisi',
				type	: 'info'
			});
		}else{
			var formData = new FormData($("#edit_data_form").get(0));
			$.ajax({
				url		: 'permintaan/ipsls_data.php?f=edit_data_proses',
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
	}
	
	function hapus_data(id){
		cc = confirm("Apakah anda yakin ingin menghapus data ini.?");
		if(cc == true){
			$.ajax({
				url		: 'permintaan/ipsls_data.php?f=hapus_data&gid='+id,
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
	
	function get_status_aset(key, val, f){
		$.ajax({
			url		: 'master/global.php?f=get_option_status',
			type	: 'post',
			data	: {gkey:key, gval:val, gf:f},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_status_'+f).innerHTML = data;
			}
		});
	}
	
	function get_ruangan_aset(unit,f){
		$.ajax({
			url		: 'master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:unit, gf:f},
			dataType: 'json',
			success	: function(data){
				document.getElementById("g_ruangan_"+f).innerHTML = data;
				group = $('#g_group_id').val();
				if(group == 1){
					if(f == 'add'){
						unit = $("#g_ruangan_id").val();
						get_aset('', unit, f);
					}
					$("#g_ruangan_"+f).select2("readonly", true);
				}
				$("#g_ruangan_"+f).select2("val", unit);
			}
		});
	}
	
	function get_aset(id, unit, f){
		group = $('#g_group_id').val();
		if(group == 1 && f == 'add'){
			unit = $("#g_ruangan_id").val();
		}
		$.ajax({
			url		: 'permintaan/ipsls_data.php?f=get_aset',
			type	: 'post',
			data	: {gunit : unit},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_aset_'+f).innerHTML = data;
				$("#g_aset_"+f).select2("val", id);
			}
		});
	}
	
	function get_pegawai(val, f){
		$.ajax({
			url		: 'master/global.php?f=get_option_pegawai',
			data	: {gf:f},
			type	: 'post',
			success	: function(data){
				document.getElementById('g_pelapor_'+f).innerHTML = data;
				group = $('#g_group_id').val();
				if(group == 1){
					if(f == 'add'){
						val = <?=$_SESSION['simrsig']?>;
					}
					$("#g_pelapor_"+f).select2("readonly", true);
				}
				$("#g_pelapor_"+f).select2("val", val);
			}
		});
	}
	
	function action(id, jenis_id, aset_id){
		$.ajax({
			url		: 'permintaan/ipsls_data.php?f=get_data_detail',
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
				$('#g_permintaan_action').val(data.permintaan);
				$('#g_deskripsi_action').val(data.deskripsi);
				$('#btn_add_tindakan').attr('onclick', 'add_tindakan('+id+','+aset_id+','+data.status_id+')');
				get_data_tindakan(id);
				$('#action_modal').modal('show');
				get_status_aset(1, data.status_aset, 'tindakan');
				
				$('#g_id_action').val(id);
				$('#g_idaset_action').val(aset_id);
				$('#g_alasan_action').val(data.alasan);
			},error	: function(){
				new PNotify({
					title: 'Error',
					text: 'Terjadi kesalahan sisem, silahkan coba kembali',
					type: 'error'
				});
			}
		});
	}
	
	function get_data_tindakan(id){
		$('#dttindakan').DataTable({
			"ajax"		: 'permintaan/ipsls_data.php?f=get_data_tindakan&gid='+id,
			"sAjaxDataProp": "data",
			"Processing": true, 
			"columns"	: [
							{"data" : "no"},
							{"data" : "tindakan"},
							{"data" : "petugas"},
							{"data" : "tanggal"},
							{"data" : "aksi"}
						],
			"searching"	: false,
			"paging"	: true,
			"ordering"	: true,
			"destroy"	: true,
			"info"		: false,
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
	
	/*function formatrupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }*/
	
	function cek_barang(key){
		ret = 0;
		$.ajax({
			async	: false,
			url		: 'permintaan/ipsls_data.php?f=cek_barang',
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
		tindakan 	= document.forms['add_tindakan_form'].elements['g_tindakan'].value;
		status_aset	= document.forms['add_tindakan_form'].elements['g_status'].value;
		time		= document.forms['add_tindakan_form'].elements['g_time'].value;
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
					url		: 'permintaan/ipsls_data.php?f=add_tindakan',
					type	: 'post',
					//data	: {gid:id, g_tanggal:tanggal, g_tindakan:tindakan, g_status:status_aset, g_time:time, g_aset_id:aset_id},
					data	: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					success	: function(data){
						$('#add_tindakan_modal').modal('toggle');
						get_data_tindakan(id);
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
	
	function edit_tindakan(id){
		$.ajax({
			url		: 'permintaan/ipsls_data.php?f=get_dtl_tindakan&gid='+id,
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
				$('#gambar_tidakan_edit').attr('onclick', 'view_img_t("'+data.files+'")');
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
	
	function view_img_t(src){
		$('#img_view_tindakan').attr('src', src);
		$('#view_img_modal_tindakan').modal('show');
	}
	
	function proses_edit_tindakan(id, aset_id, permintaan_id){
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
					url		: 'permintaan/ipsls_data.php?f=proses_edit_tindakan',
					type	: 'post',
					//data	: {gid:id, g_tanggal:tanggal, g_tindakan:tindakan, g_status:status_aset, g_time:time, g_aset_id:aset_id},
					data	: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					success	: function(data){
						if(data){
							$('#edit_tindakan_modal').modal('toggle');
							new PNotify({
								title	: 'Success',
								text	: 'Data berhasil diedit',
								type	: 'success'
							});
							get_data_tindakan(permintaan_id);
						}
						$('#btn_save_edit_tindakan').text('Simpan');
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
	
	function hapus_tindakan(id, per_id){
		cc = confirm("Apakah anda yakin ingin menghapus data ini.?");
		if(cc == true){
			$.ajax({
				url		: 'permintaan/ipsls_data.php?f=hapus_tindakan&gid='+id,
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
					get_data_tindakan(per_id);
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
	
	function change_barang(key, val, f){
		$.ajax({
			url		: 'permintaan/ipsls_data.php?f=cek_barang',
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
			url		: 'master/global.php?f=get_option_tipe_aset',
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
				url		: 'permintaan/ipsls_data.php?f=change_status',
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
				url		: 'permintaan/ipsls_data.php?f=change_status',
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
			url		: 'permintaan/ipsls_data.php?f=change_alasan',
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
</script>

<style>
	.modal { overflow: auto !important; }
	
	#view_img{
		color: #005fb8
	}
	
	#view_img:hover{
		cursor:pointer;
		font-weight:bold
	}
</style>