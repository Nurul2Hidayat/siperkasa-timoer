<header class="page-header">
	<h2>Master Ruangan</h2>
</header>
<script src="html2img/html2canvas.js"></script>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Ruangan</h5>
			</header>
			<div class="panel-body">
				<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#add_data_modal">
					<i class="fa fa-plus"></i> Tambah
				</button>
				<button type="button" class="mb-xs mt-xs mr-xs btn btn-success" data-toggle="modal" onclick="download_excel()">
					<i class="fa fa-file-excel-o"></i>
				</button>
				<table class="table table-striped table-bordered table-hover dataTables-example" id="dtruangan">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">NAMA</th>
							<th class="center">PERBAIKAN</th>
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
						<label class="col-sm-2 col-form-label">Nama Ruangan</label>
						<div class="col-sm-10">
							<input id="g_nama_add" maxlength="54" name="g_nama" type="text" class="form-control" placeholder="Nama Ruangan">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_status_add" name="g_status" class="form-control">
								<option value="1">Aktif</option>
								<option value="2">Tidak Aktif</option>
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
						<label class="col-sm-2 col-form-label">Nama Ruangan</label>
						<div class="col-sm-10">
							<input id="g_nama_edit" maxlength="54" name="g_nama" type="text" class="form-control" placeholder="Nama Ruangan">
							<input id="g_id_edit" name="g_id" type="text" hidden>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_status_edit" name="g_status" class="form-control">
								<option value="1">Aktif</option>
								<option value="2">Tidak Aktif</option>
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
				<div id="qr_code_ada" class="form-group row center" style="background:#fff; padding:30px">
					<div style="background:#000; height:auto; margin:auto; border-radius:25px">
						<h2 style="color:#fff; margin:auto; font-weight:bold">QR Code Ruangan</h2>
						<div style="border:5px solid #000; margin: auto; border-radius:25px; padding:5px; background:#fff">
							<img id="qr_code_img" alt="QR Code">
						</div>
						<div id="nm_aset" style="color:#fff; font-size:20px; font-weight:bold"></div>
					</div>
				</div>
				<div id="qr_code_not" class="form-group row center">
					<i class='fa fa-qrcode' style="font-size:200px"></i>
					<p>Barcode Belum tersedia, silahkan klik Generate</p>
				</div>
				<div class="form-group row">
					<button id="btn_ctk_qr_code" type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Generate</button>
					<button id="btn-Preview-Image" type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Set Image Barcode</button>
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
									<th class="center">Nama Aset</th>
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
		//get_status_aset(2, '', 'add');
		
		$("#edit_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("edit_data_form").reset();
		});
		
		$("#add_data_modal").on("hidden.bs.modal", function () {
			document.getElementById("add_data_form").reset();
		});
		
		// Global variable 
		var element = $("#qr_code_ada");  
	   
		// Global variable 
		var getCanvas; 
		$("#btn-Preview-Image").on('click', function() { 
			$('#previewImage').html('');
			$('#cetak_qrcode').modal('show');
			html2canvas(element, { 
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
	
	function get_data(){	
		$('#dtruangan').DataTable({
			"ajax"		: 'master/ruangan_data.php?f=get_data',
			"sAjaxDataProp": "data",
			"Processing": true, 
			"columns"	: [
							{"data" : "no"},
							{"data" : "ruangan"},
							{"data" : "history"},
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
	
	function edit_data(id, jenis_status){
		$.ajax({
			url		: 'master/ruangan_data.php?f=get_data_edit',
			type	: 'POST',
			data	: {'gid':id},
			dataType: 'json',
			success	: function(data){
				//get_status_aset(jenis_status, data.status_id, 'edit');
				$('#g_status_edit').val(data.aktif);
				$('#g_id_edit').val(data.id_unit);
				$('#g_nama_edit').val(data.nama);
				$('#edit_data_modal').modal('show');
			}
		});
	}
	
	function add_data(){
		var formData = new FormData($("#add_data_form").get(0));
		$.ajax({
			url		: 'master/ruangan_data.php?f=add_data',
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
			url		: 'master/ruangan_data.php?f=edit_data_proses',
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
				url		: 'master/ruangan_data.php?f=hapus_data&gid='+id,
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
	
	function barcode(id){
		$.ajax({
			url		: 'master/ruangan_data.php?f=get_qrcode',
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
			url		: 'qrcode/index.php?id='+id+'&ruangan=1',
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
	
	function get_list_perbaikan(id_unit){
		$('#history_mdl').modal('show');
		$('#dtperbaikan').DataTable({
			"Processing": true, 
			"serverSide": false,
			"ajax"		: 'master/ruangan_data.php?f=get_list_perbaikan&id_unit='+id_unit,
			"sAjaxDataProp": "data",
			"columns"	: [
							{"data" : "no"},
							{"data" : "ast"},
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
		table 	= $('#dtruangan').DataTable();
		search 	= table.search();
		window.location.replace(window.location.origin+'/it/master/ruangan_data.php?f=downloadexcel&cari='+search);
	}

	/*function get_status_aset(key, val, f){
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
				//document.getElementById(iddiv).innerHTML = data;
			}
		});
	}*/
</script>
