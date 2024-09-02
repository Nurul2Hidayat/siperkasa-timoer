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
					$qry_cek = mysql_query("select rating, ulasan from ipl_permintaan where permintaan_id = $f_id");
					$data = mysql_fetch_array($qry_cek);
					if($data['rating'] == ''){
				?>
				<input id="ss_role_id" value="<?php echo isset($_SESSION['group']) ? $_SESSION['group'] : '-'?>" hidden>
				<section role="main" class="content-body">
					<header class="page-header">
					</header>
					<!-- start: page -->
					<div class="row">
						<div class="col-xl-6">
							<div class="col-md-12 col-lg-12 col-xl-12" style="padding-bottom:15px">
								<label class="col-form-label">Rating</label>
								<input id="g_rating" type='text' class='rating' data-size='sm' data-min='0' data-max='5' data-step='1' data-show-clear='false' data-show-caption='false' value=''>
								<input id="g_id" type='text' value="<?=$fa['0']?>" hidden>
							</div>
							<div class="col-md-12 col-lg-12 col-xl-12" style="padding-bottom:15px">
								<label class="col-form-label">Ulasan</label>
								<textarea id="g_ulasan" class="form-control" placeholder="Ulasan"></textarea>
							</div>
							<div class="col-md-12">
								<button type="submit" class="btn btn-primary waves-effect waves-light" style="width:100%" onclick="send_rating()">Kirim Data</button>
							</div>
						</div>
					</div>
				</section>
				<?php
					}else{
				?>
				<section role="main" class="content-body">
					<header class="page-header">
					</header>
					<!-- start: page -->
					<div class="row">
						<div class="col-xl-6">
							<div class="col-md-12 col-lg-12 col-xl-12" style="padding-bottom:15px">
								<h2 class="center" style="color:#f60; font-weight:bold">Terimakasih</h2>
								<h4 class="center">Sudah Mengisi Rating dan Ulasan, ini akan sangat membantu kami sebagai bahan evaluasi kinerja kami</h4>
							</div>
							<div class="col-md-12 col-lg-12 col-xl-12 center" style="padding-bottom:15px">
								<i class="fa fa-smile-o" style="font-size:20em"></i>
							</div>
						</div>
					</div>
				</section>
				<?php
					}
				?>
				<!-- Specific Page Vendor -->
				<script src="../assets/vendor/star-rating/js/star-rating.min.js"></script>
				<script src="../assets/vendor/star-rating/themes/krajee-svg/theme.js"></script>
				<script src="../assets/vendor/star-rating/js/locales/LANG.js"></script>
				<?php include('scan_footer.php');?>

				<script>
					function send_rating(){
						id = $('#g_id').val();
						rating = $('#g_rating').val();
						ulasan = $('#g_ulasan').val();
						if(rating != ''){
							if(ulasan != ''){
								$.ajax({
									url		: 'scan_qrcode_data.php?f=saverating',
									type	: 'POST',
									data	: {grating:rating, gulasan:ulasan, gid:id},
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
									text: 'Ulasan tidak boleh kosong',
									type: 'warning'
								});
							}
						}else{
							new PNotify({
								title: 'Harus diisi',
								text: 'Rating bintang harus diisi',
								type: 'warning'
							});
						}
					}
				</script>
				<style>
					.krajee-icon-star{
						width:2.5rem !important;
						height:2.5rem !important;
					}
				</style>