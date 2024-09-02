<?php 
	$home = 'Peminjaman Aset';
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
								<th class="center">TANGGAL</th>
								<th class="center">NAMA</th>
								<th class="center">STATUS</th>
								<th class="center">ID</th>
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

<!--  modal detail  -->
<div class="modal fade" id="add_permintaan" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Peminjaman</h4>
			</div>
			<form id="add_data_form" onsubmit="return false">
				<input id="g_id_action" type="text" name="id_action" hidden>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Ruangan <span class="required">*</span></label>
						<div class="col-sm-6">
							<select data-plugin-selectTwo class="form-control populate" name="g_ruangan" id="g_ruangan_add" placeholder="Ruangan" onchange="get_aset('', this.value, 'add')">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Barang <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_aset_add" id="g_aset_add" placeholder="Nama Barang/Aset">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Peminjam <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_pelapor" id="g_pelapor_add" placeholder="Pelapor">
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Konfirmasi <span class="required">*</span></label>
						<div class="col-sm-10">
							<select data-plugin-selectTwo class="form-control populate" name="g_konfirmasi" id="g_konfirmasi_add" placeholder="Konfirmasi">
								
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
								<input id="g_tgl_add_tindakan" name="g_tanggal" type="text" data-plugin-datepicker="" class="form-control">
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
								<input id="g_time_add_tindakan" name="g_time" class="form-control" type="text" data-plugin-timepicker="" data-plugin-options='{ "showMeridian": false }'>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button id="btn_add" type="submit" class="btn btn-primary waves-effect waves-light">Pinjam Aset</button>
				</div>
			</form>
		 </div>
	</div>
</div>
<?php 
	include('scan_footer.php');
	$id_user = isset($_SESSION['simrsig']) ? $_SESSION['simrsig'] : '';
	$role_id = isset($_SESSION['group']) ? $_SESSION['group'] : '';
?>

<script>
	$(document).ready( function() {
		var aset_id = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		cek_aset(aset_id);
		get_data();
		saiki = get_today();
		waktune = get_time();
		$('#g_tgl_add_tindakan').datepicker('setDate', saiki);
		$('#g_time_add_tindakan').val(waktune);
		
		if(type == 'aset'){
			get_dtl_aset(aset_id);
		}else{
			get_dtl_ruangan(aset_id);
		}
		$('#btn_add').attr('onclick', 'add_data('+aset_id+')');
		
		$('#dtaset tbody').on( 'click', 'tr', function () {
			var id = $('#dtaset').DataTable().row(this).data().id;
			action(id);
        });
	});
	
	function action(id){
		var aset_id = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_detail_peminjaman&type='+type+'&gid='+aset_id,
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				if(data.sts == 'done'){
					new PNotify({
						title	: 'Sudah Selesai',
						text	: 'Transaksi ini sudah selesai, silahkan coba untuk transaksi yg lain',
						type	: 'warning'
					});
				}else{
					//get_status_aset(jenis_id, data.status_aset, 'tindakan');
					$('#add_permintaan').modal('show');
					$('#g_id_action').val(id);
					//get_ruangan_aset(data.ruangan_id, 'add');
					
					saiki = get_today();
					waktune = get_time();
					get_pegawai(data.pegawai_id, 'add');
					//get_konfirmasi(data.konfirmasi_id, data.ruangan_id, 'add');
					$('#g_tgl_add_tindakan').val(saiki);
					$('#g_time_add_tindakan').val(waktune);
					if(data.status == 1){
						konfirm = data.konfirmasi_id;
						$('#btn_add').html('Simpan Perubahan');
						$('.modal-title').html('Edit data pinjaman');
						$('#btn_add').attr('onclick', 'edit_pinjaman('+id+', 0)');
					}else if(data.status == 3){
						konfirm = data.konfirmasi_id_kembali;
						$('#btn_add').html('Kembalikan Pinjaman');
						$('.modal-title').html('Kembalikan Pinjaman');
						$('#btn_add').attr('onclick', 'kembalikan_pinjaman('+id+', '+data.aset_id+')');
					}else if(data.status == 5){
						konfirm = data.konfirmasi_id_kembali;
						$('#btn_add').html('Simpan Perubahan');
						$('.modal-title').html('Edit data pinjaman');
						$('#btn_add').attr('onclick', 'edit_pinjaman('+id+', 1)');
					}else{
						//$('#btn_add').html('Kembalikan Pinjaman');
						konfirm = data.konfirmasi_id;
						$('#btn_add').addClass('hidden');
						$('.modal-title').html('Menunggu Konfirmasi');
					}
					get_aset(data.aset_id, data.ruangan_id, 'add', konfirm);
					
				}				
			},error	: function(){
				
			}
		});
	}
	
	function edit_pinjaman(id, balik){
		c_peminjam 	= document.forms['add_data_form'].elements['g_pelapor'].value;
		c_tgl 		= document.forms['add_data_form'].elements['g_tgl_add_tindakan'].value;
		c_time 		= document.forms['add_data_form'].elements['g_time_add_tindakan'].value;
		c_konfirm	= document.forms['add_data_form'].elements['g_konfirmasi_add'].value;
		$.ajax({
			url		: 'scan_qrcode_data.php?f=edit_pinjaman',
			type	: 'POST',
			data	: {gid:id, gpeminjam:c_peminjam, gtgl:c_tgl, gtime:c_time, gkonfirm:c_konfirm, gbalik:balik},
			dataType: 'json',
			success	: function(data){
				$('#add_permintaan').modal('toggle');
				if(data == 1){
					new PNotify({
						title	: 'Berhasil',
						text	: 'Berhasil Mengubah Data',
						type	: 'success'
					});
				}else{
					new PNotify({
						title	: 'Error',
						text	: 'Terdapat Kesalahan Sistem, Silahkan coba kembali',
						type	: 'error'
					});
				}
			}
		});
	}
	
	function cek_aset(aset_id){
		$.ajax({
			url		: 'scan_qrcode_data.php?f=cek_aset',
			type	: 'POST',
			data	: {aset_id:aset_id},
			dataType: 'json',
			success	: function(data){
				if(data.jml < 1){
					$('#add_permintaan').modal('show');
				}else{
					new PNotify({
						title	: 'Anda Masih Meminjam Barang ini',
						text	: 'Harus Mengembalikan barang terlebih dahulu',
						type	: 'warning'
					});
				}
			},error: function(){
				alert('error');
			}
		});
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
	
	function get_data(){
		var aset_id = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		$('#dtaset').DataTable({
			"ajax"		: 'scan_qrcode_data.php?f=get_data_peminjaman_aset&gid='+aset_id+'&type='+type,
			"sAjaxDataProp": "data",
			"Processing": true, 
			"columns"	: [
							{"data" : "tanggal"},
							{"data" : "nama"},
							{"data" : "status"},
							{"data"	: "id", "visible":false}
						],
			"searching"	: false,
			"paging"	: true,
			"ordering"	: true,
			"destroy"	: true,
			"info"		: false,
			"order"		: [[0, 'desc']],
			"mimeType"	: "application/json",
			"language"	: {"sEmptyTable": "Data Kosong"}
		});
	}
	
	function get_dtl_aset(aset_id){
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_dtl_aset',
			type	: 'post',
			data	: {gid_aset:aset_id},
			dataType: 'json',
			success	: function(data){
				var id_peg  = "<?=$id_user?>";
				var role_id = "<?=$role_id?>";
				id_ruang = cek_ruangan_peg(id_peg);
				if(data.ruangan_id == id_ruang){
					id_peg = '';
				}
				get_ruangan_aset(data.ruangan_id, 'add');
				get_aset(data.aset_id, data.ruangan_id, 'add');
				get_pegawai(id_peg, 'add');
				//get_status_aset(5, '', 'add');
				//console.log(data);
			},error	: function(){
				
			}
		});
	}
	
	function cek_ruangan_peg(id){
		var ret = 0;
		//id = 5;
		$.ajax({
			url		: 'scan_qrcode_data.php?f=cek_ruangan_peg',
			type	: 'post',
			data	: {gid:id},
			dataType: 'json',
			async	: false,
			success	: function(data){
				if(data[0] != 0){
					ret = data[0];
				}
				//alert(ret);
			}
		});
		return ret;
	}
	
	function get_dtl_ruangan(ruangan_id){
		var id_peg = "<?=$id_user?>";
		var role_id = "<?=$role_id?>";
		if(role_id == 2){
			id_peg = '';
		}
		get_ruangan_aset(ruangan_id, 'add');
		get_aset('',ruangan_id, 'add');
		get_pegawai(id_peg, 'add');
		//get_status_aset(5, '', 'add');
	}
	
	function get_ruangan_aset(unit,f){
		$.ajax({
			url		: '../master/global.php?f=get_option_ruangan',
			type	: 'post',
			data	: {gid:unit,gf:'column'},
			dataType: 'json',
			success	: function(data){
				document.getElementById("g_ruangan_"+f).innerHTML = data;
				//group = $('#g_group_id').val();
				type = "<?=$f_tp;?>";
				//if(type == 'aset'){
					$("#g_ruangan_"+f).select2("readonly", true);
					$("#g_ruangan_"+f).select2("val", unit);
				//}
			}
		});
	}
	
	function get_aset(id, unit, f, k=''){
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
				get_konfirmasi(k, unit, f);
			}
		});
	}
	
	function get_konfirmasi(val, unit, f){
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_konfirmasi',
			type	: 'post',
			data	: {gu:unit},
			success	: function(data){
				document.getElementById('g_konfirmasi_'+f).innerHTML = data;
				$("#g_konfirmasi_"+f).select2("val", val);
			}
		});
	}
	
	function get_pegawai(val, f){
		$.ajax({
			url		: '../master/global.php?f=get_option_pegawai',
			type	: 'post',
			data	: {gf:'column'},
			success	: function(data){
				document.getElementById('g_pelapor_'+f).innerHTML = data;
				
				if(val){
					$("#g_pelapor_"+f).select2("val", val);
					$("#g_pelapor_"+f).select2("readonly", true);
				}
			}
		});
	}
	
	function get_status_aset(key, val, f){
		$.ajax({
			url		: '../master/global.php?f=get_option_status',
			type	: 'post',
			data	: {gkey:key, gval:val},
			dataType: 'json',
			success	: function(data){
				document.getElementById('g_status_'+f).innerHTML = data;
			}
		});
	}
	
	function add_data(aset_id){
		c_peminjam 	= document.forms['add_data_form'].elements['g_pelapor'].value;
		c_tgl 		= document.forms['add_data_form'].elements['g_tgl_add_tindakan'].value;
		c_time 		= document.forms['add_data_form'].elements['g_time_add_tindakan'].value;
		c_konfirm	= document.forms['add_data_form'].elements['g_konfirmasi_add'].value;
		if(c_peminjam == '' || c_tgl == '' || c_time == '' || c_konfirm == ''){
			new PNotify({
				title	: 'Isi Form',
				text	: 'Silahkan isi form yang bertanda bintang',
				type	: 'warning'
			});
		}else{
			var formData = new FormData($("#add_data_form").get(0));
			$.ajax({
				url		: 'scan_qrcode_data.php?f=add_pinjaman',
				type	: 'POST',
				data	: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success	: function(data){
					get_data();
					$('#add_permintaan').modal('toggle');
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
				}
			});
		}
	}
	
	function kembalikan_pinjaman(id, aset_id){
		c_konfirm	= document.forms['add_data_form'].elements['g_konfirmasi_add'].value;
		c_tgl 		= document.forms['add_data_form'].elements['g_tgl_add_tindakan'].value;
		c_time 		= document.forms['add_data_form'].elements['g_time_add_tindakan'].value;
		if(c_tgl == '' || c_time == '' || c_konfirm == ''){
			new PNotify({
				title	: 'Isi Form',
				text	: 'Silahkan isi form yang bertanda bintang',
				type	: 'warning'
			});
		}else{
			var formData = new FormData($("#add_data_form").get(0));
			$.ajax({
				url		: 'scan_qrcode_data.php?f=kembalikan_pinjaman',
				type	: 'POST',
				data	: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success	: function(data){
					get_data();
					if(data == 1){
						$('#add_permintaan').modal('toggle');
						new PNotify({
							title	: 'Berhasil',
							text	: 'Berhasil',
							type	: 'success'
							//icon	: 'fa fa-home'
						});
					}else{
						new PNotify({
							title	: 'Error',
							text	: 'Gagal menambahkan data',
							type	: 'error'
						});
					}				
				},error: function(){
					new PNotify({
						title	: 'Error',
						text	: 'Gagal menambahkan data',
						type	: 'error'
					});
				}
			});
		}
	}
</script>