<?php
	$home = 1;
	include('scan_header.php');
	if($f_tp == 'aset'){
		$qrwt = mysql_query("SELECT COUNT(tdk.tindakan_id) jml
							FROM ipl_tindakan tdk 
							LEFT JOIN ipl_permintaan pmt ON pmt.permintaan_id = tdk.permintaan_id
							WHERE tdk.delete_mark = 0
							AND (pmt.aset_id = $f_id or tdk.aset_id = $f_id)");
		$qpmt = mysql_query("SELECT COUNT(permintaan_id) jml
							FROM ipl_permintaan
							WHERE delete_mark = 0 AND aset_id = $f_id");
		$qtdk = mysql_query("SELECT COUNT(permintaan_id) jml
							FROM ipl_permintaan
							WHERE delete_mark = 0 AND aset_id = $f_id AND status_id <> 12");
		$qtmp = mysql_query("SELECT COUNT(id) jml
							FROM server_temperatur
							WHERE deletemark = 0");
		$ruang_aset = cek_ruangan_aset($f_id);
		$org = isset($_SESSION['ruangan']) ? ($ruang_aset['ruangan_id'] == $_SESSION['ruangan'] ? "" : " and pegawai_id = $_SESSION[simrsig]") : '';
		$qpnj = mysql_query("SELECT COUNT(id) jml
							FROM ipl_peminjaman_aset
							WHERE deletemark = 0 and aset_id = $f_id $org");
		$qdtl = mysql_query("SELECT nm_aset, merk_aset, no_seri from ipl_aset where aset_id = $f_id");
	}else{
		$qrwt = mysql_query("SELECT COUNT(tdk.tindakan_id) jml
							FROM ipl_tindakan tdk 
							LEFT JOIN ipl_permintaan pmt ON pmt.permintaan_id = tdk.permintaan_id
							LEFT JOIN ipl_aset ast ON ast.aset_id = pmt.aset_id OR ast.aset_id = tdk.aset_id
							LEFT JOIN unit ON unit.id_unit = ast.ruangan_id
							WHERE tdk.delete_mark = 0
							AND id_unit = $f_id");
		$qpmt = mysql_query("SELECT COUNT(permintaan_id) jml
							FROM ipl_permintaan
							WHERE delete_mark = 0 AND ruangan_id = $f_id");
		$qtdk = mysql_query("SELECT COUNT(permintaan_id) jml
							FROM ipl_permintaan
							WHERE delete_mark = 0 AND ruangan_id = $f_id AND status_id <> 12");
		$qtmp = mysql_query("SELECT COUNT(id) jml
							FROM server_temperatur
							WHERE deletemark = 0");
		$org = isset($_SESSION['ruangan']) ? ($_SESSION['ruangan'] == $f_id ? "" : " and pm.pegawai_id = $_SESSION[simrsig]") : '';
		$qpnj = mysql_query("SELECT COUNT(pm.id) jml
							FROM ipl_peminjaman_aset pm
							LEFT JOIN ipl_aset aset ON aset.aset_id = pm.`aset_id`
							WHERE deletemark = 0
							AND ruangan_id = $f_id $org");
		$qdtl = mysql_query("select nama from unit where id_unit = $f_id");
	}
	$rwt = mysql_fetch_array($qrwt);
	$pmt = mysql_fetch_array($qpmt);
	$tdk = mysql_fetch_array($qtdk);
	$tmp = mysql_fetch_array($qtmp);
	$pnj = mysql_fetch_array($qpnj);
	$dtl = mysql_fetch_array($qdtl);
	
	
	if(isset($_SESSION['simrsig'])){
		$cek_konfirm = mysql_query("select count(id) cek from ipl_peminjaman_aset where (konfirmasi_id = $_SESSION[simrsig] or konfirmasi_id_kembali = $_SESSION[simrsig]) and status in (1, 5)");
		$cek = mysql_fetch_array($cek_konfirm);
		$notif_konfirm = $cek['cek'] >= 1 ? $cek['cek'].' Perlu Konfirmasi' : 'Peminjaman';
		
		$nohp = cek_no_hp($_SESSION['simrsig']);
		if($nohp['HP'] == ''){
			echo"<script>var opn_hp = 1;</script>";
		}else{
			echo"<script>var opn_hp = 0;</script>";
		}
		echo"<script>var islogin = 1;</script>";
	}else{
		$notif_konfirm = 'Peminjaman';
		echo"<script>var islogin = 0;</script>";
	}
	
	function cek_no_hp($id){
		include "../koneksi/koneksi_sdm.php";
		$cek_no_hp = mysql_query("select HP from pegawai where PEGAWAI_ID = $id");
		$nohp = mysql_fetch_array($cek_no_hp);
		return $nohp;
	}
	
	function cek_ruangan_aset($aset_id){
		$query = "select ruangan_id from ipl_aset where aset_id = $aset_id";
		$sql = mysql_query($query);
		$data = mysql_fetch_array($sql);
		return $data;
	}
	
?>
<input id="ss_role_id" value="<?php echo isset($_SESSION['group']) ? $_SESSION['group'] : '-'?>" hidden>
<section role="main" class="content-body">
	<header class="page-header">
		
	</header>
	<!-- start: page -->
	<div class="row">
		<div class="col-xl-6">
			<div class="row">
				
				<div class="col-md-12 col-lg-6 col-xl-6" style="padding-bottom:15px">
					<?php
						$nm = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
						echo "<h5>Selamat Datang <b>($nm)</b></h5>";
						if($f_tp == 'aset'){
							echo "	<h4><b>Scan QR Asset</b></h4>
									<h5>Nama Aset <b>($dtl[nm_aset])</b></h5>
									<h5>Merk <b>($dtl[merk_aset])</b></h5>
									<h5>No Seri <b>($dtl[no_seri])</b></h5>";
						}else{
							echo "	<h4><b>Scan QR Ruangan</b></h4>
									<h5>Ruangan <b>($dtl[nama])</b></h5>";
						}
					?>
				</div>
				<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(1)">
					<section class="panel panel-featured-left panel-featured-primary">
						<div class="panel-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-primary">
										<i class="fa fa-history"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Riwayat Tindakan</h4>
										<div class="info">
											<strong class="amount"><?=$rwt['jml']?></strong>
											<span class="text-primary">(Tindakan)</span>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase">(view all)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(2)">
					<section class="panel panel-featured-left panel-featured-secondary">
						<div class="panel-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-secondary">
										<i class="fa fa-wrench"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Permintaan Perbaikan</h4>
										<div class="info">
											<strong class="amount"><?=$pmt['jml']?></strong>
											<span class="text-secondary">(Permintaan)</span>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase">(request)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(7)">
					<section class="panel panel-featured-left panel-featured-warning">
						<div class="panel-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-warning">
										<i class="fa fa-random"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Peminjaman Aset</h4>
										<div class="info">
											<strong class="amount"><?=$pnj['jml']?></strong>
											<span class="text-warning" id="text_konfirm">(<?=$notif_konfirm?>)</span>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase">(History)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<?php
				if(isset($_SESSION['group'])){
					if($_SESSION['group'] == 2){
				?>
					<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(4)">
						<section class="panel panel-featured-left panel-featured-quartenary">
							<div class="panel-body">
								<div class="widget-summary">
									<div class="widget-summary-col widget-summary-col-icon">
										<div class="summary-icon bg-quartenary">
											<i class="fa fa-cogs"></i>
										</div>
									</div>
									<div class="widget-summary-col">
										<div class="summary">
											<h4 class="title">Tindakan Perbaikan</h4>
											<div class="info">
												<strong class="amount"><?=$tdk['jml']?></strong>
												<span class="text-quartenary">(Permintaan Perbaikan)</span>
											</div>
										</div>
										<div class="summary-footer">
											<a class="text-muted text-uppercase">(maintenance)</a>
										</div>
									</div>
								</div>
							</div>
						</section>
					</div>
					<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(5)">
						<section class="panel panel-featured-left panel-featured-success">
							<div class="panel-body">
								<div class="widget-summary">
									<div class="widget-summary-col widget-summary-col-icon">
										<div class="summary-icon bg-success">
											<i class="fa fa-calendar-o"></i>
										</div>
									</div>
									<div class="widget-summary-col">
										<div class="summary">
											<h4 class="title">Tindakan Rutin</h4>
											<div class="info">
												<strong class="amount"></strong>
												<span class="text-success"></span>
											</div>
										</div>
										<div class="summary-footer">
											<a class="text-muted text-uppercase">(maintenance)</a>
										</div>
									</div>
								</div>
							</div>
						</section>
					</div>
					<?php
						if($f_tp == 'aset'){
					?>
						<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(3)">
							<section class="panel panel-featured-left panel-featured-tertiary">
								<div class="panel-body">
									<div class="widget-summary">
										<div class="widget-summary-col widget-summary-col-icon">
											<div class="summary-icon bg-tertiary">
												<i class="fa fa-list-ul"></i>
											</div>
										</div>
										<div class="widget-summary-col">
											<div class="summary">
												<h4 class="title">Detail Aset</h4>
												<div class="info">
													<strong class="amount"></strong>
												</div>
											</div>
											<div class="summary-footer">
												<a class="text-muted text-uppercase">(information)</a>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
						<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(8)">
							<section class="panel panel-featured-left panel-featured-dark">
								<div class="panel-body">
									<div class="widget-summary">
										<div class="widget-summary-col widget-summary-col-icon">
											<div class="summary-icon bg-dark">
												<i class="fa fa-exclamation"></i>
											</div>
										</div>
										<div class="widget-summary-col">
											<div class="summary">
												<h4 class="title">Update data Aset</h4>
												<div class="info">
													<strong class="amount"></strong>
												</div>
											</div>
											<div class="summary-footer">
												<a class="text-muted text-uppercase">(Update data)</a>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
						<?php
							if($f_id == 20000){
						?>
							<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(6)">
								<section class="panel panel-featured-left panel-featured-dark">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-dark">
													<i class="fa fa-database"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">Pengecekan Server</h4>
													<div class="info">
														<strong class="amount"><?=$tmp['jml']?></strong>
														<span class="text-primary">(Report Temperatur)</span>
													</div>
												</div>
												<div class="summary-footer">
													<a class="text-muted text-uppercase">(Suhu dan Kelembapan)</a>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
							<?php
							}
						}else{
							?>
							<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(10)">
								<section class="panel panel-featured-left panel-featured-tertiary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-tertiary">
													<i class="fa fa-check-square-o"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">Checklist 5R</h4>
													<div class="info">
														<strong class="amount"></strong>
													</div>
												</div>
												<div class="summary-footer">
													<a class="text-muted text-uppercase">(information)</a>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
							<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(9)">
								<section class="panel panel-featured-left panel-featured-dark">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-dark">
													<i class="fa fa-exclamation"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">List Data Aset</h4>
													<div class="info">
														<strong class="amount"></strong>
													</div>
												</div>
												<div class="summary-footer">
													<a class="text-muted text-uppercase">(Update data)</a>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
							<?php
						}
					}else{
						if($f_tp == 'aset'){
							?>
							<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(3)">
								<section class="panel panel-featured-left panel-featured-tertiary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-tertiary">
													<i class="fa fa-list-ul"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">Detail Aset</h4>
													<div class="info">
														<strong class="amount"></strong>
													</div>
												</div>
												<div class="summary-footer">
													<a class="text-muted text-uppercase">(information)</a>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
							<?php
						}
					}
				}
				?>
				
			</div>
		</div>
	</div>
</section>

<!--  modal login  -->
<div class="modal fade" id="modal_login" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Login</h4>
				<input type="text" id="id_section" hidden>
			</div>
			<form id="login_form" onsubmit="return false">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">NIP/NO HP <span class="required">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" placeholder="Username" name="username" autofocus>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Password <span class="required">*</span></label>
						<div class="col-sm-10">
							<input type="password" class="form-control" placeholder="Password" name="password" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary waves-effect waves-light" onclick="login()">Login</button>
				</div>
			</form>
		 </div>
	</div>
</div>
<?php include('scan_footer.php');?>

<!--  No HP  -->
<div class="modal fade" id="add_no_hp" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambahkan No HP(whatsapp)</h4>
			</div>
			<form id="add_no_hp_form" onsubmit="return false">
				<input type="text" id="g_id_action" name="g_id" hidden>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">No HP</label>
						<div class="col-sm-4">
							<input id="g_no_hp" type="text" class="form-control" placeholder="nomor hp">
						</div>
						<!--<h4 class="center">No HP berfungsi untuk mengirimkan pemberitahuan whatsapp dari sistem jika permintaan sudah selesai</h4>-->
						<div class="col-sm-8">&nbsp;</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary waves-effect waves-light" onclick="save_no_hp()">Simpan</button>
				</div>
			</form>
		 </div>
	</div>
</div>

<script>
	if(islogin == 0){
		$('#modal_login').modal('show');
	}
	
	if(opn_hp == 1){
		$('#add_no_hp').modal('show');
		$('#add_no_hp').modal({backdrop: 'static', keyboard: false})  
	}
	
	function save_no_hp(){
		nohp = $('#g_no_hp').val();
		$.ajax({
			url		: 'scan_qrcode_data.php?f=save_no_hp',
			type	: 'POST',
			data	: {'nohp':nohp},
			dataType: 'json',
			success	: function(data){
				if(data.sts == 1){
					new PNotify({
						title: 'Berhasil',
						text: data.msg,
						type: 'success'
					});
					location.reload();
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
	
	var base_url = window.location.origin;
	function go_to(id){
		var aset_id = "<?=$_GET['gid'];?>";
		//var type = "<?=$f_tp;?>";
		if(id == 1){
			sess = $('#ss_role_id').val();
			if(sess == '-'){
				$('#modal_login').modal('show');
				$('#id_section').val(id);
			}else{
				window.location.replace(base_url+'/it/scan_qrcode/riwayat_tindakan.php?gid='+aset_id);
			}
		}else if(id == 2){
			sess = $('#ss_role_id').val();
			if(sess == '-'){
				$('#modal_login').modal('show');
				$('#id_section').val(id);
			}else{
				window.location.replace(base_url+'/it/scan_qrcode/permintaan_perbaikan.php?gid='+aset_id);
			}
		}else if(id == 3){
			sess = $('#ss_role_id').val();
			if(sess == '-'){
				$('#modal_login').modal('show');
				$('#id_section').val(id);
			}else{
				window.location.replace(base_url+'/it/scan_qrcode/detail_aset.php?gid='+aset_id);
			}
		}else if(id == 4){
			sess = $('#ss_role_id').val();
			if(sess == '-'){
				$('#modal_login').modal('show');
				$('#id_section').val(id);
			}else if(sess == 2){
				window.location.replace(base_url+'/it/scan_qrcode/tindakan_perbaikan.php?gid='+aset_id);
			}else{
				new PNotify({
					title: 'Warning',
					text: 'Hanya untuk petugas',
					type: 'warning'
				});
			}
		}else if(id == 5){
			sess = $('#ss_role_id').val();
			if(sess == '-'){
				$('#modal_login').modal('show');
				$('#id_section').val(id);
			}else if(sess == 2){
				window.location.replace(base_url+'/it/scan_qrcode/tindakan_rutin.php?gid='+aset_id);
			}else{
				new PNotify({
					title: 'Warning',
					text: 'Hanya untuk petugas',
					type: 'warning'
				});
			}
		}else if(id == 6){
			sess = $('#ss_role_id').val();
			if(sess == '-'){
				$('#modal_login').modal('show');
				$('#id_section').val(id);
			}else if(sess == 2){
				window.location.replace(base_url+'/it/scan_qrcode/pengecekan_server.php?gid='+aset_id);
			}else{
				new PNotify({
					title: 'Warning',
					text: 'Hanya untuk petugas',
					type: 'warning'
				});
			}
		}else if(id == 7){
			sess = $('#ss_role_id').val();
			if(sess == '-'){
				$('#modal_login').modal('show');
				$('#id_section').val(id);
			}else{
				konfirm = $('#text_konfirm').text();
				if(konfirm == '(Peminjaman)'){
					window.location.replace(base_url+'/it/scan_qrcode/peminjaman_aset.php?gid='+aset_id);
				}else{
					window.location.replace(base_url+'/it/scan_qrcode/konfirmasi_peminjaman.php?gid='+aset_id);
				}
			}
		}else if(id == 8){
			sess = $('#ss_role_id').val();
			if(sess == '-'){
				$('#modal_login').modal('show');
				$('#id_section').val(id);
			}else if(sess == 2){
				window.location.replace(base_url+'/it/scan_qrcode/update_aset.php?gid='+aset_id);
			}else{
				new PNotify({
					title: 'Warning',
					text: 'Hanya untuk petugas',
					type: 'warning'
				});
			}
		}else if(id == 9){
			sess = $('#ss_role_id').val();
			if(sess == '-'){
				$('#modal_login').modal('show');
				$('#id_section').val(id);
			}else if(sess == 2){
				window.location.replace(base_url+'/it/scan_qrcode/list_aset.php?gid='+aset_id);
			}else{
				new PNotify({
					title: 'Warning',
					text: 'Hanya untuk petugas',
					type: 'warning'
				});
			}
		}else if(id == 10){
			sess = $('#ss_role_id').val();
			if(sess == '-'){
				$('#modal_login').modal('show');
				$('#id_section').val(id);
			}else{
				window.location.replace(base_url+'/it/scan_qrcode/checklist_vr.php?gid='+aset_id);
			}
		}else{
			alert('Tidak Tersedia');
		}
	}
	
	function login(){
		var aset_id = "<?=$f_id;?>";
		var type = "<?=$f_tp;?>";
		var token = "<?=$_GET['gid'];?>";
		var formData = new FormData($("#login_form").get(0));
		$.ajax({
			url		: 'scan_qrcode_data.php?f=login&gid='+aset_id+'&type='+type,
			type	: 'POST',
			data	: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success	: function(data){
				if(data == 1){
					sec = $('#id_section').val();
					if(sec == 2){
						window.location.replace(base_url+'/it/scan_qrcode/permintaan_perbaikan.php?gid='+token);
					}else if(sec == 4){
						window.location.replace(base_url+'/it/scan_qrcode/tindakan_perbaikan.php?gid='+token);
					}else if(sec == 5){
						window.location.replace(base_url+'/it/scan_qrcode/tindakan_rutin.php?gid='+token);
					}else if(sec == 6){
						window.location.replace(base_url+'/it/scan_qrcode/pengecekan_server.php?gid='+token);
					}else if(sec == 7){
						window.location.replace(base_url+'/it/scan_qrcode/peminjaman_aset.php?gid='+token);
					}else{
						location.reload();
					}
				}else if(data == 2){
					sec = $('#id_section').val();
					if(sec == 7){
						window.location.replace(base_url+'/it/scan_qrcode/peminjaman_aset.php?gid='+token);
					}else if(sec == 2){
						window.location.replace(base_url+'/it/scan_qrcode/permintaan_perbaikan.php?gid='+token);
					}else{
						location.reload();
					}					
				}else{
					new PNotify({
						title: 'Warning',
						text: 'User dan Password tidak sesuai',
						type: 'warning'
					});
				}
			},error: function(){
				new PNotify({
					title: 'Error',
					text: 'Gagal login data',
					type: 'error'
				});
			}
		});
	}
</script>