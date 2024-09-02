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

		<title>SIPERKASA TIMOER</title>
		<link rel="icon" type="image/png" href="../assets/images/rsmn.ico">
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
				<?php
					if($home == 1){
						if(isset($_GET['gid'])){
							if(isset($_SESSION['nama'])){
								$nm_user = $_SESSION['nama'];
								$qy = mysql_fetch_array(mysql_query("select nama from unit where id_unit = $_SESSION[ruangan]"));
								$un_user = $qy['nama'];
							}else{
								$nm_user = "Profil";
								$un_user = '';
							}
							echo '<a href="scan_qrcode.php?gid='.$_GET['gid'].'" class="logo">
									<img src="../assets/images/rsmn.png" height="35" alt="JSOFT Admin" />
									<img src="../assets/images/JATIM.png" height="46" alt="Porto Admin" />
								</a>
								
								<div id="userbox" class="userbox" style="float:right; margin-right:5%">
									<a href="#" data-toggle="dropdown" aria-expanded="false">
										<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@JSOFT.com">
											<span class="name">'.$nm_user.'</span>
											<span class="role">'.$un_user.'</span>
										</div>
						
										<i class="fa custom-caret"></i>
									</a>
						
									<div class="dropdown-menu">
										<ul class="list-unstyled">
											<li class="divider"></li>
											<li>
												<a role="menuitem" tabindex="-1" href="profil.php?gid='.$_GET['gid'].'"><i class="fa fa-user"></i> My Profile</a>
											</li>
											<li>
												<a role="menuitem" tabindex="-1" href="../logout.php?qr='.$_GET['gid'].'"><i class="fa fa-power-off"></i> Logout</a>
											</li>
										</ul>
									</div>
								</div>';
						}else{
							echo '<a href="#" class="logo">
									<img src="../assets/images/rsmn.png" height="35" alt="JSOFT Admin" />
									<img src="../assets/images/JATIM.png" height="46" alt="Porto Admin" />
								</a>
								
								<a href="../logout.php?list=1" class="logo" style="float:right; margin-right:5%">
									Logouts
								</a>';
						}						
					}else{
						if(isset($_GET['gid'])){
							echo '<a href="scan_qrcode.php?gid='.$_GET['gid'].'" class="logo">
									<i class="fa fa-times" aria-label="Toggle sidebar" style="color:#000; font-size:20px; font-weight:bold"> '.$home.'</i>
								</a>';
						}else{
							echo '<a href="scan_qrcode_list.php" class="logo">
									<i class="fa fa-times" aria-label="Toggle sidebar" style="color:#000; font-size:20px; font-weight:bold"> '.$home.'</i>
								</a>';
						}
						
					}
				?>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened" style="color:#000; background:none; width:auto">
						<!--<?=print_r($_SESSION['nama']);?>-->
					</div>
				</div>
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
