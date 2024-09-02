<?php
	session_start();
	if(!isset($_SESSION['group'])){
		//header('location:index.php');
	}
	//include 'sesi.php';
	include "../koneksi/koneksi.php";
	//$data 	= mysql_query("SELECT * FROM user WHERE id_user='$_SESSION[simrsig]'");
	//$r_data = mysql_fetch_array($data);
	if(isset($_GET['gid'])){
		$ft = base64_decode(base64_decode($_GET['gid']));
		$fa = explode('___', $ft);
		
		$f_id = $fa[0];
		$f_tp = $fa[1];
	}
?>
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>TiMoer</title>
		<link rel="icon" type="image/png" href="../assets/images/logo-timoer.png">
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		
		<!-- Web Fonts  -->
		<link rel="stylesheet" href="../assets/stylesheets/font.css" />

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="../assets/vendor/pnotify/pnotify.custom.css">

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="../assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
		<link rel="stylesheet" type="text/css" href="../assets/vendor/jquery-datatables/media/css/jquery.dataTables.css">
		<link rel="stylesheet" href="../assets/vendor/pnotify/pnotify.custom.css" />
		<link rel="stylesheet" href="../assets/vendor/summernote/summernote.css" />
		<link rel="stylesheet" href="../assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
		
		<script src="../assets/vendor/jquery/jquery.min.js"> </script>

		<!-- Theme CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="../assets/vendor/modernizr/modernizr.js"></script>
		<!-- Time Picker -->
		<link rel="stylesheet" href="../assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
		
		<!-- Star Rating -->
		<link rel="stylesheet" href="../assets/vendor/star-rating/css/star-rating.min.css" />
		<link rel="stylesheet" href="../assets/vendor/star-rating/themes/krajee-svg/theme.css" />
		
		<style>
			.bootstrap-timepicker-widget {
				z-index : 9999
			}
		</style>
	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="scan_qrcode.php?gid='.$_GET['gid'].'" class="logo">
						<img src="../assets/images/timor.png" height="35" alt="JSOFT Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened" style="color:#000; background:none; width:auto">
						
					</div>
				</div>
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">

				<?php
					$qry_cek = mysql_query("SELECT 
											  pm.pelapor, 
											  pl.nama nm_pelapor, 
											  pm.permintaan, 
											  pm.tanggal_permintaan, 
											  pm.status_id, 
											  st.nm_status, 
											  cg.id log_id, 
											  cg.create_by, 
											  pt.nama nm_petugas, 
											  pt.ruangan_id, 
											  cg.create_date 
											FROM 
											  ipl_permintaan pm 
											  LEFT JOIN ipl_log_sts_permintaan cg ON cg.permintaan_id = pm.permintaan_id 
											  LEFT JOIN ipl_pengguna pl ON pl.pegawai_id = pm.pelapor 
											  LEFT JOIN ipl_status st ON st.status_id = pm.status_id 
											  LEFT JOIN ipl_pengguna pt ON pt.pegawai_id = cg.create_by 
											WHERE 
											  pm.permintaan_id = $f_id
											ORDER BY 
											  cg.create_date DESC 
											LIMIT 
											  1");
					$data = mysql_fetch_array($qry_cek);
				?>
				<input id="ss_role_id" value="<?php echo isset($_SESSION['group']) ? $_SESSION['group'] : '-'?>" hidden>
				<section role="main" class="content-body">
					<header class="page-header">
					</header>
					<!-- start: page -->
					<div class="row">
						<div class="col-xl-6">
						<?php
							if($data['status_id'] == 14){
						?>
							<div class="col-md-12 col-lg-12 col-xl-12" style="padding-bottom:15px">
								<h4>Permintaan anda dengan keterangan</h4>
								<h4 style="font-weight:bold"><?=$data['permintaan']?></h4>
								<h4>sudah diselesaikan oleh Teknisi : <span style="font-weight:bold"><?=$data['nm_petugas']?></span></h4>
								<h4>Mohon untuk mengkonfirmasi apakah permintaan anda sudah selesai</h4>
								<h4>Terimakasih</h4>
								<input id="g_id" type='text' value="<?=$f_id?>" hidden>
							</div>
							<div class="col-md-12" style="text-align:center">
								<button type="submit" class="btn btn-danger waves-effect waves-light" style="width:45%" onclick="send_feedback(0)">Belum</button>
								<button type="submit" class="btn btn-success waves-effect waves-light" style="width:45%" onclick="send_feedback(1)">Selesai</button>
							</div>
							<div class="col-md-12" style="text-align:center">
								<b>*status akan dikonfirmasi selesai secara otomatis (by sistem) jika sudah melewati 24 jam.</b>
							</div>
						<?php
							}else if($data['status_id'] == 12){
						?>
							<div class="col-md-12" style="text-align:center">
								<h4>Permintaan Sudah dikonfirmasi Selesai</h4>
							</div>
						<?php
							}else{
						?>
							<div class="col-md-12" style="text-align:center">
								<h4>Permintaan dikonfirmasi masih belum selesai</h4>
							</div>
						<?php
							}
						?>
						</div>
					</div>
				</section>
				
				<!-- Specific Page Vendor -->
				<script src="../assets/vendor/star-rating/js/star-rating.min.js"></script>
				<script src="../assets/vendor/star-rating/themes/krajee-svg/theme.js"></script>
				<script src="../assets/vendor/star-rating/js/locales/LANG.js"></script>
				<?php include('scan_footer.php');?>

				<script>
					function send_feedback(val){
						id = $('#g_id').val();
						$.ajax({
							url		: 'scan_qrcode_data.php?f=save_feedback',
							type	: 'POST',
							data	: {val:val, id:id},
							dataType: 'json',
							success	: function(data){
								if(data.sts == 1){
									new PNotify({
										title: 'Berhasil',
										text: data.msg,
										type: 'success'
									});
									location.reload();
									if(val == 1){
										$.ajax({
											url		: '../permintaan/ipsls_data.php?f=change_status',
											type	: 'post',
											data	: {val:12, id:id},
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