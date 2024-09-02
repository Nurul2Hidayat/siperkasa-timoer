<?php
	$home = 'Tindakan Rutin';
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
								<th class="center">TINDAKAN</th>
								<th class="center">TANGGAL</th>
								<th class="center">PETUGAS</th>
								<th class="center">AKSI</th>
								<th class="center">id</th>
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

<!--  add tindakan  -->
<div class="modal fade" id="add_tindakan_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambah Tindakan</h4>
			</div>
			<form id="add_tindakan_form" onsubmit="return false">
				<input type="text" id="g_id_action" name="g_id" hidden>
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
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_aset" id="g_aset_add" placeholder="Nama Barang/Aset" required>
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Petugas <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_petugas" id="g_pelapor_add" placeholder="Petugas" required>
								
							</select>
						</div>
					</div>
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
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<select id="g_status_tindakan" name="g_status" class="form-control">
								
							</select>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button id="btn_save_tindakan" type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
				</div>
			</form>
		 </div>
	</div>
</div>
<?php include('scan_footer.php');?>

<script>
	$(document).ready( function() {
		$('#add_tindakan_modal').modal('show');
		var gid = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		get_data(gid);
		if(type == 'aset'){
			get_dtl_aset(gid);
		}else{
			get_dtl_ruangan(gid);
		}
		//$('#btn_add').attr('onclick', 'add_data('+aset_id+')');
		
		$('#dtaset tbody').on( 'click', 'tr', function () {
			var id = $('#dtaset').DataTable().row(this).data().tindakan_id;
			//editMember(data[0]);
			action(id);
        });
	});
	
	function get_dtl_aset(aset_id){
		var ptgs = "<?=$_SESSION['simrsig'];?>";
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_dtl_aset',
			type	: 'post',
			data	: {gid_aset:aset_id},
			dataType: 'json',
			success	: function(data){
				get_ruangan_aset(data.ruangan_id, 'add');
				get_aset(data.aset_id, data.ruangan_id, 'add');
				get_pegawai(ptgs, 'add');
				get_status_aset(1, data.status_id, 'tindakan');
				add_tindakan();
				//console.log(data);
			},error	: function(){
				
			}
		});
	}
	
	function get_dtl_ruangan(ruangan_id){
		var id_peg = "<?=$_SESSION['simrsig'];?>";
		var role_id = "<?=$_SESSION['group'];?>";
		get_ruangan_aset(ruangan_id, 'add');
		get_aset('',ruangan_id, 'add');
		get_pegawai(id_peg, 'add');
		get_status_aset(1, '', 'tindakan');
		add_tindakan();
	}
	
	function get_data(aset_id){
		var type = "<?=$f_tp;?>";
		$('#dtaset').DataTable({
			"ajax"		: 'scan_qrcode_data.php?f=get_data_tindakan_rutin&gid='+aset_id+'&type='+type,
			"sAjaxDataProp": "data",
			"Processing": true, 
			"columns"	: [
							{"data" : "tindakan"},
							{"data" : "tanggal"},
							{"data" : "petugas"},
							{"data" : "aksi"},
							{"data" : "tindakan_id", "visible":false},
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
			"order"		: [[1, 'desc']],
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function action(id){
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_detail',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				//get_status_aset(jenis_id, data.status_aset, 'tindakan');
				$('#add_tindakan_modal').modal('show');
				$('#g_id_action').val(data.tindakan_id);
				get_ruangan_aset(data.ruangan_id, 'add');
				get_aset(data.aset_id, data.ruangan_id, 'add');
				get_pegawai(data.petugas_id, 'add');
				$('#g_tgl_add_tindakan').val(data.tanggal);
				$('#g_time_add_tindakan').val(data.time);
				$('#g_tindakan_add_tindakan').val(data.tindakan);
				$('#btn_save_tindakan').attr('onclick', 'update_tindakan('+id+','+data.aset_id+')');
				$('#btn_save_tindakan').html('Update Data');
				get_status_aset(1, data.status_aset, 'tindakan');
				$('.modal-title').html('Update Tindakan');
			},error	: function(){
				
			}
		});
	}
	
	function update_tindakan(id, aset_id){
		tgl = $('#g_tgl_add_tindakan').val();
		tim = $('#g_time_add_tindakan').val();
		tdk = $('#g_tindakan_add_tindakan').val();
		sts = $('#g_status_tindakan').val();
		$.ajax({
			url		: 'scan_qrcode_data.php?f=update_tindakan',
			type	: 'post',
			data	: {gid:id, gtgl:tgl, gtim:tim, gtdk:tdk, gsts:sts, gast:aset_id},
			dataType: 'json',
			success	: function(data){
				if(data == 1){
					$('#add_tindakan_modal').modal('toggle');
					get_data(aset_id);
				}
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
	
	function add_tindakan(){
		$('#add_tindakan_modal').modal('show');
		saiki = get_today();
		waktune = get_time();
		$('#g_tgl_add_tindakan').datepicker('setDate', saiki);
		$('#g_time_add_tindakan').val(waktune);
		/*var rupiah 	= document.getElementById('g_biaya_add_tindakan');
		rupiah.addEventListener('keyup', function(e){
			rupiah.value = formatrupiah(this.value, 'Rp. ');
		});*/
		
		$('#btn_save_tindakan').attr('onclick', 'save_tindakan()');
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
	
	function save_tindakan(){
		aset		= document.forms['add_tindakan_form'].elements['g_aset'].value;
		petugas		= document.forms['add_tindakan_form'].elements['g_petugas'].value;
		tanggal 	= document.forms['add_tindakan_form'].elements['g_tanggal'].value;
		time	 	= document.forms['add_tindakan_form'].elements['g_time'].value;
		tindakan 	= document.forms['add_tindakan_form'].elements['g_tindakan'].value;
		status_aset	= document.forms['add_tindakan_form'].elements['g_status'].value;
		
		if(aset && petugas && tanggal && time && tindakan && status_aset){
			$.ajax({
				url		: 'scan_qrcode_data.php?f=save_tindakan_rutin',
				type	: 'post',
				data	: {aset_id : aset, petugas_id : petugas, tanggal:tanggal, time:time, tindakan:tindakan, status_aset:status_aset},
				dataType: 'json',
				success	: function(data){
					$('#add_tindakan_modal').modal('toggle');
					get_data(aset);
				},error	: function(){
					new PNotify({
						title: 'Gagal',
						text: 'Terjadi kesalahan sistem, silahkan dicoba kembali',
						type: 'error'
					});
				}
			});
		}else{
			new PNotify({
				title: 'Tidak Boleh Kosong',
				text: 'kolom bertanda * wajib diisi',
				type: 'warning'
			});
		}
	}
	
	/*function change_status(status_id){
		id = $('#g_id_action').val();
		var aset_id = "<?=$_GET['aset_id'];?>";
		$.ajax({
			url		: 'scan_qrcode_data.php?f=change_status',
			type	: 'post',
			data	: {gid_status:status_id, gid:id},
			dataType: 'json',
			success	: function(data){
				get_data(aset_id);
				//alert('success');
			},error	: function(){
				//alert('error');
			}
		});
	}*/
	
	function get_ruangan_aset(unit,f){
		$.ajax({
			url		: '../master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:unit, gf:'column'},
			dataType: 'json',
			success	: function(data){
				document.getElementById("g_ruangan_"+f).innerHTML = data;
				//group = $('#g_group_id').val();
				$("#g_ruangan_"+f).select2("readonly", true);
				$("#g_ruangan_"+f).select2("val", unit);
			}
		});
	}
	
	function get_aset(id, unit, f){
		$.ajax({
			url		: '../permintaan/ipsls_data.php?f=get_aset',
			type	: 'post',
			data	: {gunit : unit},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_aset_'+f).innerHTML = data;
				if(id){
					$("#g_aset_"+f).select2("val", id);
					$("#g_aset_"+f).select2("readonly", true);
				}				
			}
		});
	}
	
	function get_pegawai(val, f){
		$.ajax({
			url		: '../master/global.php?f=get_option_pegawai',
			data	: {gf:'column'},
			type	: 'post',
			success	: function(data){
				document.getElementById('g_pelapor_'+f).innerHTML = data;
				$("#g_pelapor_"+f).select2("val", val);
				$("#g_pelapor_"+f).select2("readonly", true);
			}
		});
	}
	
	function hapus_data(id, aset_id){
		$.ajax({
			url		: 'scan_qrcode_data.php?f=hapus_data_tindakan',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				$('#add_tindakan_modal').modal('toggle');
				get_data(aset_id);
			},error	: function(){
				
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