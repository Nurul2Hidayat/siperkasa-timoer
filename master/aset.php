<header class="page-header">
	<h2>Master Aset</h2>
</header>
<script src="html2img/jquery.min.js"></script>
<script src="html2img/html2canvas.js"></script>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Aset</h5>
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-3">
						<div class="form-group">
							<label class="control-label">Ruangan</label>
							<select data-plugin-selectTwo class="form-control populate" id="g_ruangan_filter" placeholder="Ruangan">
								
							</select>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Kriteria</label>
							<select class="form-control" id="g_kriteria_filter" placeholder="Kriteria">
								<option value="all">Semua</option>
								<option value="0">Aset</option>
								<option value="1">Non Aset</option>
							</select>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Jenis</label>
							<select class="form-control" id="g_jenis_filter" placeholder="Jenis">
								<option value="all">Semua</option>
								<option value="1">Medis</option>
								<option value="2">Non Medis</option>
							</select>
						</div>
					</div>
					<div class="col-sm-1">
						<label class="control-label"></label>
						<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary form-control" onclick="get_data()">
							<i class="fa fa-search"></i>Cari
						</button>
					</div>
					<div class="col-sm-1">
						<label class="control-label"></label>
						<button type="button" class="mb-xs mt-xs mr-xs btn btn-success form-control" data-toggle="modal" onclick="download_excel()">
							<i class="fa fa-file-excel-o"></i>
						</button>
					</div>
					<div class="col-sm-2">
						<label class="control-label"></label>
						<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary form-control" data-toggle="modal" data-target="#add_data_modal">
							<i class="fa fa-plus"></i> Tambah
						</button>
					</div>
				</div>
				<div class="col-sm-8">&nbsp;</div>
				<table class="table table-striped table-bordered table-hover dataTables-example" id="dtaset">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">NAMA</th>
							<th class="center">JENIS</th>
							<th class="center">RUANGAN</th>
							<th class="center">MERK</th>
							<th class="center">NO SERI</th>
							<th class="center">HISTORI PERBAIKAN</th>
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
			<form id="add_data_form" onsubmit="return false" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kriteria</label>
						<div class="col-sm-4">
							<select id="g_non_add" name="g_non" class="form-control" onchange="change_non(this.value, 'add')">
								<option value="0">Aset</option>
								<option value="1">Non Aset</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jenis</label>
						<!--<div class="col-sm-10" id="tipe_aset_add" onchange="change_tipe('add')">-->
						<!--<div class="col-sm-10" id="tipe_aset_add">
							
						</div>-->
						<div class="col-sm-5">
							<select id="tipe_aset_add" name="g_tipe" class="form-control">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nama Aset</label>
						<div class="col-sm-8">
							<input id="g_nama_add" maxlength="54" name="g_nama" type="text" class="form-control" placeholder="Nama Aset">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kode Barang</label>
						<div class="col-sm-8">
							<input id="g_kode_add" maxlength="54" name="g_kode" type="text" class="form-control" placeholder="Nomer Seri">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Merk</label>
						<div class="col-sm-5">
							<input id="g_merk_add" maxlength="54" name="g_merk" type="text" class="form-control" placeholder="Merk Aset">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tipe</label>
						<div class="col-sm-10">
							<input id="g_tipe_add" maxlength="54" name="g_tipe_n" type="text" class="form-control" placeholder="Tipe Aset">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Ruangan</label>
						<div class="col-sm-6">
							<select data-plugin-selectTwo class="form-control populate" name="g_ruangan" id="g_ruangan_add" placeholder="Ruangan">
								
							</select>
						</div>
						<div class="col-sm-4">
							<label class="checkbox-inline">
								<input type="checkbox" id="g_umum_add" name="g_umum" onchange="change_umum('add')"> Umum
							</label>
						</div>
					</div>
					<div id="div_stok_add" class="form-group row">
						<label class="col-sm-2 col-form-label">Stok</label>
						<div class="col-sm-3">
							<input id="g_stok_add" maxlength="54" name="g_stok" type="number" class="form-control" placeholder="Stok" disabled>
						</div>
						<div class="col-sm-4">
							<label class="checkbox-inline">
								<input type="checkbox" id="g_hbs_pakai_add" name="g_hbs_pakai" onchange="change_hbs('add')"> Habis Pakai
							</label>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nomer Seri</label>
						<div class="col-sm-8">
							<input id="g_nose_add" maxlength="54" name="g_nose" type="text" class="form-control" placeholder="Nomer Seri">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Penyedia</label>
						<div class="col-sm-10">
							<input id="g_penyedia_add" maxlength="54" name="g_penyedia" type="text" class="form-control" placeholder="Penyedia">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">No Telp Penyedia</label>
						<div class="col-sm-10">
							<input id="g_telp_p_add" maxlength="54" name="g_telp_p" type="text" class="form-control" placeholder="No Telpon penyedia">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tanggal Pembelian</label>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input id="g_tgl_beli_add" name="g_tgl_beli" type="text" data-plugin-datepicker="" class="form-control">
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
								<input id="g_harga_add" maxlength="54" name="g_harga" type="number" class="form-control" placeholder="Harga">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Lokasi</label>
						<div class="col-sm-6">
							<input id="g_lokasi_add" maxlength="54" name="g_lokasi" type="text" class="form-control" placeholder="Lokasi">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Penanggung Jawab</label>
						<div class="col-sm-5">
							<select id="g_unit_pj" name="g_unit_pj" class="form-control">
								<option value="1">Instalasi IT & SIMRS</option>
								<option value="2">Instalasi IPSRS</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_status_add" name="g_status" class="form-control">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-10">
							<textarea id="g_ket_add" name="g_keterangan" class="form-control" placeholder="Keterangan"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 control-label">Gambar Aset</label>
						<div class="col-md-5">
							<input type="file" id="g_file_add" name="g_file" class="form-control" onchange="change_file(this.value)">
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button id="btn_add_aset" type="submit" class="btn btn-primary waves-effect waves-light" onclick = "add_data()">Tambah Data</button>
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
					<div class="form-group row">
						<label class="col-md-2 control-label">Gambar Aset</label>
						<div class="col-md-5">
							<input type="file" id="g_file_edit" name="g_file" class="form-control" onchange="change_file(this.value)">
						</div>
						<div class="col-md-5">
							<p id="view_img" onclick="view_img()">lihat gambar</p>
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

<!--  View Image  -->
<div class="modal fade" id="view_img_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lihat Gambar</h4>
			</div>
			<form id="edit_data_form" onsubmit="return false">
				<div class="modal-body">
					<iframe id="img_view" src="../files/img/no-image.jpg" style="width : 100%; height : 600px"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
				</div>
			</form>
		 </div>
	</div>
</div>

<!--  QR Code  -->
<div class="modal fade" id="barcode_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content center">
			<div class="modal-header">
				<h4 class="modal-title">Barcode Aset</h4>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				</button>-->
			</div>
			<div class="modal-body">
				<div id="qr_code_ada" class="form-group row center border border-dark" style="background:#fff; padding:30px">
					<div style="background:#000; height:auto; margin:auto; border-radius:25px">
						<h2 style="color:#fff; margin:auto; font-weight:bold">QR Code Aset</h2>
						<div style="border:5px solid #000; margin: auto; border-radius:25px; padding:5px; background:#fff">
							<img id="qr_code_img" alt="QR Code">
						</div>
						<div id="nm_aset" style="color:#fff; font-size:20px; font-weight:bold"></div>
					</div>
				</div>
				<div id="qr_code_not" class="form-group row center">
					<i class='fa fa-qrcode' style="font-size:400px"></i>
					<p>Barcode Belum tersedia, silahkan klik Generate</p>
				</div>
				<div class="form-group row">
					<button id="btn_ctk_qr_code" type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Generate</button>
					<button id="btn-Preview-Image" type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Set Image Qrcode</button>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<!--  print qr code  -->
<div class="modal fade" id="cetak_qrcode" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content center">
			<div class="modal-header">
				<h4 class="modal-title">Download Barcode</h4>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				</button>-->
			</div>
			<div class="modal-body">
				<div id="previewImage" class="form-group row center">
					
				</div>
				<a id="btn-Convert-Html2Image" href="#">
					<button type='button' class='btn btn-primary btn-lg'>
						<i class='fa fa-download'></i> Download
					</button>
				</a>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<!--  History Perbaikan aset  -->
<div class="modal fade" id="history_mdl" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog  modal-lg" role="document">
		<div class="modal-content center">
			<div class="modal-header">
				<h4 class="modal-title">History Perbaikan Aset</h4>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				</button>-->
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<div class="col-sm-12">
						<table class="table table-striped table-bordered table-hover dataTables-example" id="dtperbaikan">
							<thead>
								<tr>
									<th class="center">No</th>
									<th class="center">Tanggal</th>
									<th class="center">Perbaikan</th>
									<th class="center">Teknisi</th>
									<th class="center">Jenis</th>
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
		</div>
	</div>
</div>
<script>
	$(document).ready( function() {
		get_data();
		get_tipe_aset(1, '', 'add');
		get_status_aset(1, '', 'add');
		get_ruangan_aset('', 'add');
		get_ruangan_aset('', 'filter');
		
		$("#edit_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("edit_data_form").reset();
		});
		
		$("#add_data_modal").on("show.bs.modal", function () {
			//document.getElementById("add_data_form").reset();
			sts = $('#g_non_add').val();
			change_non(sts, 'add');
		});
		
		 // Global variable 
		var element = $("#qr_code_ada");  
	   
		// Global variable 
		var getCanvas;  
		$("#btn-Preview-Image").on('click', function() { 
			$('#previewImage').html('');
			$('#cetak_qrcode').modal('show');
			html2canvas(element, {
			scale: 2,
			onrendered: function(canvas) { 
					$("#previewImage").append(canvas); 
					getCanvas = canvas; 
				} 
			}); 
		}); 
		$("#btn-Convert-Html2Image").on('click', function() { 
			nm_aset = $('#nm_aset').html();
			var imgageData =  
				getCanvas.toDataURL("image/png",1); 
		   
			// Now browser starts downloading  
			// it instead of just showing it 
			var newData = imgageData.replace( 
			/^data:image\/png/, "data:application/octet-stream"); 
		   
			$("#btn-Convert-Html2Image").attr( 
			"download", nm_aset+".png").attr( 
			"href", newData); 
		});
	});
	function change_tipe(f){
		val = $("input[type='radio'][name='g_tipe']:checked").val();
		if(val == 2){
			$('#g_nose_'+f).attr('disabled',true);
			$('#g_nose_'+f).val('');
		}else{
			$('#g_nose_'+f).attr('disabled',false);
		}
	}
	
	function get_data(){
		ruangan = $('#g_ruangan_filter').val();
		jenis 	= $('#g_jenis_filter').val();
		kriteria= $('#g_kriteria_filter').val();
		
		$('#dtaset').DataTable({
			"Processing": true, 
			"serverSide": true,
			"ajax"		: 'master/aset_data.php?f=get_data&ruangan='+ruangan+'&jenis='+jenis+'&kriteria='+kriteria,
			"sAjaxDataProp": "data",
			"columns"	: [
							{"data" : "no"},
							{"data" : "nama"},
							{"data" : "tipe"},
							{"data" : "ruangan"},
							{"data" : "merk"},
							{"data" : "no_seri"},
							{"data" : "history"},
							{"data" : "status"},
							{"data" : "aksi"}
						],
			"searching"	: true,
			"paging"	: true,
			"ordering"	: true,
			"destroy"	: true,
			"info"		: true,
			"dom"		: '<"left"l>frtip',
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function edit_data(id, jenis_tipe, jenis_status){
		$.ajax({
			url		: 'master/aset_data.php?f=get_data_edit',
			type	: 'POST',
			data	: {'gid':id},
			dataType: 'json',
			success	: function(data){
				get_tipe_aset(jenis_tipe, data.tipe_id, 'edit');
				get_status_aset(jenis_status, data.status_id, 'edit');
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
	
	function add_data(){
		$('#btn_add_aset').text('Loading...');
		var formData = new FormData($("#add_data_form").get(0));
		$.ajax({
			url		: 'master/aset_data.php?f=add_data',
			type	: 'POST',
			data	: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success	: function(data){
				$('#btn_add_aset').text('Tambah Data');
				if(data.sts == 1){
					new PNotify({
						title	: 'Berhasil',
						text	: 'Berhasil menambahkan data',
						type	: 'success'
						//icon	: 'fa fa-home'
					});
					$('#add_data_modal').modal('toggle');
					get_data();
				}else{
					new PNotify({
						title: 'Error',
						text: data.msg,
						type: 'error'
					});
				}
			},error: function(){
				$('#btn_add_aset').text('Tambah Data');
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
		$('#button_edit_modal_ak').text('Loading...');
		var formData = new FormData($("#edit_data_form").get(0));
		$.ajax({
			url		: 'master/aset_data.php?f=edit_data_proses',
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
	
	function hapus_data(id){
		cc = confirm("Apakah anda yakin ingin menghapus data ini.?");
		if(cc == true){
			$.ajax({
				url		: 'master/aset_data.php?f=hapus_data&gid='+id,
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
	
	function get_ruangan_aset(id,f){
		$.ajax({
			url		: 'master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:id, gf:f},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_ruangan_'+f).innerHTML = data;
				$("#g_ruangan_"+f).select2("val", id);
			}
		});
	}
	
	function barcode(id){
		$.ajax({
			url		: 'master/aset_data.php?f=get_qrcode',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				if(data.sts == 1){
					$('#qr_code_ada').attr('hidden', false);
					$('#qr_code_not').attr('hidden', true);
					$('#btn_ctk_qr_code').addClass('hidden');
					$('#btn-Preview-Image').removeClass('hidden');
					$('#qr_code_img').attr('src', data.msg);
					$('#nm_aset').html(data.nm_aset);
				}else{
					$('#qr_code_ada').attr('hidden', true);
					$('#qr_code_not').attr('hidden', false);
					$('#btn_ctk_qr_code').removeClass('hidden');
					$('#btn-Preview-Image').addClass('hidden');
					$('#btn_ctk_qr_code').attr('onclick', 'generate('+id+')');
				}
				$('#barcode_modal').modal('show');
			},error	: function(){
				
			}
		});
	}
	
	function generate(id){
		$.ajax({
			url		: 'qrcode/index.php?id='+id+'&ruangan=0',
			type	: 'post',
			dataType: 'json',
			success	: function(data){
				if(data == 1){
					barcode(id);
				}else{
					new PNotify({
						title: 'Gagal',
						text: 'Terjadi kesalahan sistem, silahkan dicoba kembali',
						type: 'error'
					});
				}
			},error	: function(){
				
			}
		});
	}
	
	function get_aset(id, unit, f){
		group = $('#g_group_id').val();
		if(group == 4 && f == 'add'){
			unit = $("#g_unit_id").val();
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
	
	function change_non(val, f){
		if(val == 1){
			
			//$('#div_stok_'+f).attr('hidden', false);
		}else{
			
			//$('#div_stok_'+f).attr('hidden', true);
			//$('#g_stok_'+f).val(0);
		}
		
	}
	
	function change_umum(f){
		val = $('#g_umum_'+f).is(":checked");
		if(val){
			$('#g_ruangan_'+f).select2('val', '');
			$('#g_ruangan_'+f).attr('disabled', true);
		}else{
			$('#g_ruangan_'+f).attr('disabled', false);
		}
	}
	
	function change_hbs(f){
		val = $('#g_hbs_pakai_'+f).is(":checked");
		if(val){
			$('#g_stok_'+f).attr('disabled', false);
		}else{
			$('#g_stok_'+f).val(0);
			$('#g_stok_'+f).attr('disabled', true);
		}
	}
	
	function view_img(){
		$('#view_img_modal').modal('show');
	}
	
	function get_list_perbaikan(aset_id){
		$('#history_mdl').modal('show');
		$('#dtperbaikan').DataTable({
			"Processing": true, 
			"serverSide": false,
			"ajax"		: 'master/aset_data.php?f=get_list_perbaikan&aset_id='+aset_id,
			"sAjaxDataProp": "data",
			"columns"	: [
							{"data" : "no"},
							{"data" : "tgl"},
							{"data" : "ket"},
							{"data" : "tks"},
							{"data" : "jns"}
						],
			"searching"	: true,
			"paging"	: true,
			"ordering"	: true,
			"destroy"	: true,
			"info"		: true,
			"dom"		: '<"left"l>frtip',
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function download_excel(){
		ruangan = !$('#g_ruangan_filter').val() ? 'all' : $('#g_ruangan_filter').val();
		jenis 	= $('#g_jenis_filter').val();
		kriteria= $('#g_kriteria_filter').val();
		table 	= $('#dtaset').DataTable();
		search 	= table.search();
		window.location.replace(window.location.origin+'/it/master/aset_data.php?f=downloadexcel&ruangan='+ruangan+'&jenis='+jenis+'&kriteria='+kriteria+'&cari='+search);
	}
</script>

<style>
	#view_img{
		color: #005fb8
	}
	
	#view_img:hover{
		cursor:pointer;
		font-weight:bold
	}
</style>