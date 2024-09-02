<?php
	$home = 1;
	include('scan_header.php');
	//session_start();
	$pj = isset($_SESSION['ruangan']) ? ($_SESSION['ruangan'] == 51 ? 1 : 2): 0;
	$qttl = mysql_query("SELECT COUNT(ip.permintaan_id) ttl FROM ipl_permintaan ip LEFT JOIN ipl_aset ia ON ia.aset_id = ip.aset_id WHERE ip.delete_mark = 0 AND ia.unit_pj = $pj");
	$qopn = mysql_query("SELECT COUNT(ip.permintaan_id) ttl FROM ipl_permintaan ip LEFT JOIN ipl_aset ia ON ia.aset_id = ip.aset_id WHERE ip.delete_mark = 0 AND ip.status_id = 10 AND ia.unit_pj = $pj");
	$qprs = mysql_query("SELECT COUNT(ip.permintaan_id) ttl FROM ipl_permintaan ip LEFT JOIN ipl_aset ia ON ia.aset_id = ip.aset_id WHERE ip.delete_mark = 0 AND ip.status_id = 11 AND ia.unit_pj = $pj");
	$qpdg = mysql_query("SELECT COUNT(ip.permintaan_id) ttl FROM ipl_permintaan ip LEFT JOIN ipl_aset ia ON ia.aset_id = ip.aset_id WHERE ip.delete_mark = 0 AND ip.status_id = 13 AND ia.unit_pj = $pj");
	$qfns = mysql_query("SELECT COUNT(ip.permintaan_id) ttl FROM ipl_permintaan ip LEFT JOIN ipl_aset ia ON ia.aset_id = ip.aset_id WHERE ip.delete_mark = 0 AND ip.status_id = 12 AND ia.unit_pj = $pj");
	$qccl = mysql_query("SELECT COUNT(ip.permintaan_id) ttl FROM ipl_permintaan ip LEFT JOIN ipl_aset ia ON ia.aset_id = ip.aset_id WHERE ip.delete_mark = 0 AND ip.status_id = 14 AND ia.unit_pj = $pj");
	
	$ttl = mysql_fetch_array($qttl);
	$opn = mysql_fetch_array($qopn);
	$prs = mysql_fetch_array($qprs);
	$pdg = mysql_fetch_array($qpdg);
	$fns = mysql_fetch_array($qfns);
	$ccl = mysql_fetch_array($qccl);
	
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
					?>
				</div>
				<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to('all')">
					<section class="panel panel-featured-left panel-featured-success">
						<div class="panel-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-success">
										<i class="fa fa-cubes"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Total Permintaan</h4>
										<div class="info">
											<strong class="amount"><?=$ttl['ttl']?></strong>
											<span class="text-success">(Permintaan)</span>
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
				<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(10)">
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
										<h4 class="title">Permintaan Open</h4>
										<div class="info">
											<strong class="amount"><?=$opn['ttl']?></strong>
											<span class="text-secondary">(Permintaan)</span>
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
				<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(11)">
					<section class="panel panel-featured-left panel-featured-warning">
						<div class="panel-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-warning">
										<i class="fa fa-cogs"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Permintaan Proses</h4>
										<div class="info">
											<strong class="amount"><?=$prs['ttl']?></strong>
											<span class="text-warning">(Permintaan)</span>
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
				<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(13)">
					<section class="panel panel-featured-left panel-featured-dark">
						<div class="panel-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-dark">
										<i class="fa fa-times"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Permintaan Pending</h4>
										<div class="info">
											<strong class="amount"><?=$pdg['ttl']?></strong>
											<span class="text-dark">(Permintaan)</span>
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
				<div class="col-md-12 col-lg-6 col-xl-6" onclick="go_to(12)">
					<section class="panel panel-featured-left panel-featured-primary">
						<div class="panel-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-primary">
										<i class="fa fa-check"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Permintaan Selesai</h4>
										<div class="info">
											<strong class="amount"><?=$fns['ttl']?></strong>
											<span class="text-primary">(Permintaan)</span>
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
						<div class="col-sm-6">
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

<script>
	$(document).ready( function() {
		var sess = $('#ss_role_id').val();
		if(sess == '-'){
			$('#modal_login').modal('show');
			$('#id_section').val(id);
		}
	});

	var base_url = window.location.origin;
	function go_to(id){
		var sess = $('#ss_role_id').val();
		if(sess == '-'){
			$('#modal_login').modal('show');
			$('#id_section').val(id);
		}else{
			window.location.replace(base_url+'/it/scan_qrcode/list_permintaan.php?id='+id);
		}
	}
	
	function login(){
		var formData = new FormData($("#login_form").get(0));
		$.ajax({
			url		: 'scan_qrcode_data.php?f=login',
			type	: 'POST',
			data	: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success	: function(data){
				if(data == 1){
					sec = $('#id_section').val();
					if(sec == ''){
						window.location.replace(base_url+'/it/scan_qrcode/scan_qrcode_list.php');
					}else{
						window.location.replace(base_url+'/it/scan_qrcode/list_permintaan.php?id='+sec);
					}
					
				}else if(data == 2){
					new PNotify({
						title: 'Akses ditolak',
						text: 'Hanya Untuk Teknisi',
						type: 'warning'
					});
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