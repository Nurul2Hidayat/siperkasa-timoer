<?php
if (isset($_SESSION['simrsig']) && $_SESSION['simrsig'] != '') {
    session_destroy();
}
include 'sesi.php';
include "koneksi/koneksi.php";
?>
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>SIPERKASA TIMOER</title>
		<link rel="icon" type="image/png" href="assets/images/rsmn.ico">
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		
		<!-- Web Fonts  -->
		<link rel="stylesheet" href="assets/stylesheets/font.css" />

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="assets/vendor/pnotify/pnotify.custom.css">

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
		<link rel="stylesheet" type="text/css" href="assets/vendor/jquery-datatables/media/css/jquery.dataTables.css">
		<link rel="stylesheet" href="assets/vendor/pnotify/pnotify.custom.css" />
		<link rel="stylesheet" href="assets/vendor/summernote/summernote.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
		
		<script src="assets/vendor/jquery/jquery.min.js"> </script>

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
		
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
					<a href="#" class="logo">
						<img src="assets/images/rsmn.png" height="46" alt="Porto Admin" />
						<img src="assets/images/JATIM.png" height="46" alt="Porto Admin" />
						<!--<img src="assets/images/timor.png" height="46" alt="Porto Admin" />-->
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="assets/images/mad.png" alt="Joseph Doe" class="img-circle" data-lock-picture="assets/images/!logged-user.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
								<span class="name"><?php echo $_SESSION['nama'];?></span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
					<div class="sidebar-header">
						<div class="sidebar-title" style = "color : #ecedf0">
							SIPERKASA
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
								<?php
									$op_sql = "SELECT m.link, m.nama_modul, m.id_modul, m.icon
													FROM `modul` m
													INNER JOIN `akses` a ON m.id_modul = a.id_modul
													WHERE m.aktif = 1
													AND a.id_group = '$_SESSION[group]'
													and m.level = 1
													order by m.urut";
									$op_data	= mysql_query($op_sql) or die (mysql_error());
									while($op = mysql_fetch_array($op_data)){
										if($op['link'] == '#'){
										echo'<li class="nav-parent">
												<a><i class="'.$op['icon'].'" aria-hidden="true"></i><span>'.$op["nama_modul"].'</span></a>
												<ul class="nav nav-children">';
											$sql_op = "SELECT m.link, m.nama_modul
													FROM `modul` m
													INNER JOIN `akses` a ON m.id_modul = a.id_modul
													WHERE m.induk = '$op[id_modul]'
													AND a.id_group = '$_SESSION[group]'
													ORDER BY m.id_modul";
											$data_op	= mysql_query($sql_op) or die (mysql_error());
											while($op_r =mysql_fetch_array($data_op)){
												echo'<li>
														<a href="?module='.$op_r["link"].'">'.$op_r["nama_modul"].'</a>
													</li>';
											}
												
											echo'</ul>
											</li>';
										}else{
											echo '	<li>
														<a href="?module='.$op['link'].'"><i class="'.$op['icon'].'" aria-hidden="true"></i><span>'.$op["nama_modul"].'</span></a>
													</li>';
										}
									}
								?>
								</ul>
							</nav>
							<hr class="separator" />
						</div>
					</div>
				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<?php include "content.php"; ?>	
				</section>
			</div>
		</section>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/select2/select2.js"></script>
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		<script src="assets/vendor/pnotify/pnotify.custom.js"></script>
		<script src="assets/vendor/summernote/summernote.js"></script>
		<script src="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>
		<script src="assets/javascripts/ui-elements/examples.modals.js"></script>
		<script src="assets/javascripts/ui-elements/examples.notifications.js"></script>
		
		<!-- Highchart -->
		<script src="assets/javascripts/highcharts/highcharts.js"></script>
		<script src="assets/javascripts/highcharts/series-label.js"></script>
		<script src="assets/javascripts/highcharts/exporting.js"></script>
		<script src="assets/javascripts/highcharts/export-data.js"></script>
	</body>
</html>