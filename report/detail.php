<input id='g_group_id' type='text' value="<?=$_SESSION['group']?>" hidden>
<input id='g_unit_id' type='text' value="<?=$_SESSION['ruangan']?>" hidden>
<input id='g_ruangan_id' type='text' value="<?=$_SESSION['ruangan']?>" hidden>
<header class="page-header">
	<h2>Laporan Perbaikan</h2>
</header>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Laporan Perbaikan</h5>
			</header>
			<div class="panel-body">
				<div class="row">
					<?php 
						if($_SESSION['group'] != 1){
					?>
					<div class="col-lg-3">
						<div class="form-group">
							<label class="control-label">Ruangan</label>
							<select data-plugin-selectTwo class="form-control populate" id="g_ruangan_filter" placeholder="Ruangan">
								
							</select>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Teknisi</label>
							<select data-plugin-selectTwo class="form-control populate" id="g_teknisi_filter" placeholder="Teknisi">
								
							</select>
						</div>
					</div>
					<?php } ?>
					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Tanggal</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" data-plugin-datepicker="" class="form-control" id="g_tgl_filter" placeholder="Tanggal">
							</div>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Status</label>
							<select id="g_status_filter" name="g_status	" class="form-control">
							
							</select>
						</div>
					</div>
					<div class="col-sm-1">
						<label class="control-label"></label>
						<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary form-control" onclick="get_data()">
							<i class="fa fa-search"></i>Cari
						</button>
					</div>
				</div>
				<div class="col-sm-8">&nbsp;</div>
				<div class="row col-lg-12">
					<table class="table table-striped table-bordered table-hover dataTables-example" id="dtaset">
						<thead>
							<tr>
								<th class="center">NO</th>
								<th class="center">RUANGAN</th>
								<th class="center">TEKNISI</th>
								<th class="center">BARANG</th>
								<th class="center">PERMINTAAN</th>
								<th class="center">TIPE</th>
								<th class="center">JUMLAH</th>
								<th class="center">TANGGAL PERMINTAAN</th>
								<th class="center">STATUS</th>
								<th class="center">AKSI</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
<div>

<!--  Add Data  -->
<div class="modal fade" id="detail_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Detail data perbaikan</h4>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				</button>-->
			</div>
			<form id="dtl_data_form" onsubmit="return false">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Ruangan </label>
						<div class="col-sm-6">
							<select data-plugin-selectTwo class="form-control populate sl2_ro" name="g_ruangan" id="g_ruangan_dtl" placeholder="Ruangan" onchange="get_aset('', this.value, 'add')" required>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Barang </label>
						<div class="col-sm-8">
							<select data-plugin-selectTwo class="form-control populate sl2_ro" name="g_aset" id="g_aset_dtl" placeholder="Nama Barang/Aset" required onchange="change_barang(this.value, '', 'add')">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Merk </label>
						<div class="col-sm-4">
							<input id="g_merk_dtl" maxlength="54" type="text" class="form-control" placeholder="Merk" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">No. Seri </label>
						<div class="col-sm-6">
							<input id="g_nosi_dtl" maxlength="54" type="text" class="form-control" placeholder="No. Seri" disabled>
						</div>
					</div>
					<div id="div_tipe_add" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Tipe </label>
						<div class="col-sm-8">
							<select class="form-control populate" name="g_tipe" id="g_tipe_dtl" placeholder="Tipe Permintaan">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kerusakan </label>
						<div class="col-sm-10">
							<!--<input id="g_permintaan_add" maxlength="54" name="g_permintaan" type="text" class="form-control" placeholder="Permintaan" required>-->
							<textarea class="form-control" id="g_permintaan_dtl" name="g_permintaan" placeholder="Kerusakan" style="width:100%" required readonly></textarea>
						</div>
					</div>
					<div id="div_stok_add" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Jumlah </label>
						<div class="col-sm-4">
							<input id="g_stok_dtl" maxlength="54" name="g_stok" type="number" class="form-control" placeholder="Jumlah">
						</div>
					</div>
					<div id="div_lokasi_add" class="form-group row" hidden>
						<label class="col-sm-2 col-form-label">Lokasi </label>
						<div class="col-sm-10">
							<input id="g_lokasi_dtl" maxlength="54" name="g_lokasi" type="text" class="form-control" placeholder="Lokasi">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Pelapor </label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate sl2_ro" name="g_pelapor" id="g_pelapor_dtl" placeholder="Pelapor" required>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status </label>
						<div class="col-sm-4">
							<select id="g_status_dtl" name="g_status" class="form-control" readonly>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 control-label">Gambar Aset </label>
						<div class="col-md-5">
							<p id="view_img" onclick="view_img()">lihat gambar</p>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Detail Perbaikan </label>
						<div class="col-sm-10">
							<table style="width:100%" id="tbl_dtl" border="1px solid ccc">
								
							</table>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
				</div>
			</form>
		 </div>
	</div>
</div>

<!--  View Image  -->
<div class="modal fade" id="view_img_modal_dtl" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lihat Gambar</h4>
			</div>
			<form id="edit_data_form" onsubmit="return false">
				<div class="modal-body">
					<iframe id="img_view_dtl" src="files/img/no-image.jpg" style="width : 100%; height : 600px"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
				</div>
			</form>
		 </div>
	</div>
</div>

<script>
	$(document).ready( function() {
		get_ruangan_aset('', 'filter');
		get_pegawai('', 'filter');
		get_status_aset(5, '', 'filter');
		get_data();
	});
	
	function get_data(){
		fruangan	= $('#g_ruangan_filter').val();
		fpelapor	= $('#g_teknisi_filter').val();
		ftanggal	= $('#g_tgl_filter').val();
		fstatus		= $('#g_status_filter').find(':selected').val();
		
		$('#dtaset').DataTable({
			"ajax"		: {
				"url"		: 'report/detail_data.php?f=get_data',
				"type"		: 'POST',
				"data"		: {"gruangan":fruangan, "gpelapor":fpelapor, "gtanggal":ftanggal, "gstatus":fstatus}
			},
			"sAjaxDataProp": "data",
			"Processing": true, 
			"serverSide": true,
			"columns"	: [
							{"data" : "no"},
							{"data" : "ruangan"},
							{"data" : "teknisi"},
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
			url		: 'master/global.php?f=get_option_teknisi',
			data	: {gf:f},
			type	: 'post',
			success	: function(data){
				document.getElementById(f).innerHTML = data;
				group = $('#g_group_id').val();
				if(group == 1){
					if(f == 'add'){
						val = <?=$_SESSION['simrsig']?>;
					}
					$("#"+f).select2("readonly", true);
				}
				$("#"+f).select2("val", val);
			}
		});
	}
	
	function view_img_t(src){
		$('#img_view_dtl').attr('src', src);
		$('#view_img_modal_dtl').modal('show');
	}
	
	function detail(id, jenis_id, aset_id){
		$(".sl2_ro").select2("readonly", true);
		$('#detail_modal').modal('show');
		$.ajax({
			url		: 'permintaan/ipsls_data.php?f=get_data_detail',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				get_status_aset(jenis_id, data.status_id, 'dtl');
				get_ruangan_aset(data.ruangan_id, 'dtl');
				get_aset(data.aset_id, data.ruangan_id, 'dtl');
				get_pegawai(data.pelapor, 'g_pelapor_dtl');
				change_barang(data.aset_id, data.tipe_id, 'dtl');
				$('#g_permintaan_dtl').val(data.permintaan);
				$('#g_deskripsi_dtl').val(data.deskripsi);
				$('#g_tgl_permintaan_dtl').val(data.tanggal_permintaan);
				$('#g_lokasi_dtl').val(data.lokasi);
				$('#g_stok_dtl').val(data.jumlah);
				if(data.gambar){
					$('#view_img').text('Lihat Gambar');
					$('#view_img').attr('onclick', 'view_img_t("files/img/permintaan/'+data.gambar+'")');
				}else{
					$('#view_img').text('Tidak ada gambar');
					$('#view_img').attr('onclick', 'false');
				}
				
				tbl = '<tr>'+
							'<td>No</td>'+
							'<td>Status</td>'+
							'<td>Keterangan</td>'+
							'<td>Waktu</td>'+
							'<td>Teknisi</td>'+
						'</tr>';
				$.ajax({
					url 	: 'report/detail_data.php?f=get_data_dtl',
					type 	: 'post',
					data	: {gid:id},
					dataType: 'json',
					success	: function(data){
						no = 0;
						for(i=0; i<data.length; i++){
							no++;
							tbl += '<tr>'+
										'<td>'+no+'</td>'+
										'<td>'+data[i].nm_status+'</td>'+
										'<td>'+data[i].ket+'</td>'+
										'<td>'+data[i].create_date+'</td>'+
										'<td>'+data[i].nm_teknisi+'</td>'+
									'</tr>';
						}
						document.getElementById('tbl_dtl').innerHTML = tbl;
					}
				});
			},error	: function(){
				new PNotify({
					title: 'Error',
					text: 'Terjadi kesalahan sisem, silahkan coba kembali',
					type: 'error'
				});
			}
		});
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
	
	function view_img(){
		$('#view_img_modal').modal('show');
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