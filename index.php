<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!--<link rel="icon" href="images/favicon.ico" type="image/ico" />-->


	<title>SIPERKASA TIMOER</title>
	<!--<link rel="icon" type="image/png" href="assets/images/logo-timoer.png">-->
	<link rel="icon" type="image/png" href="assets/images/rsmn.ico">
    <!-- Bootstrap -->
    <link href="login/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="login/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="login/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="login/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="login/build/css/custom.min.css" rel="stylesheet">
	
</head>
<body class="login">
	<div class="login_wrapper">
		<div class="animate form login_form">
			<section class="login_content">				
				<?php 
					if(isset($_GET['pesan'])){
						if($_GET['pesan'] == "gagal"){
				?>				
							<font color="red">Login gagal! username dan password salah!</font>
				<?php
						}
					}
				?>
				<form method="POST" action="cek_login.php">
				<img src="assets/images/rsmn.png" height="90"  alt="Porto Admin" />
				<!--<img src="assets/images/timor.png" height="90"  alt="Porto Admin" />-->
				
					<h2 style="font-weight:bold">SIPERKASA TIMOER</h2>
					<h5 style="font-style:italic">"Sistem Informasi Perbaikan Sarana Prasarana dan Teknologi Informasi Mohammad Noer"</h5>
						<div>
							<input type="text" class="form-control" placeholder="Username" name="username" autofocus>
						</div>
						<div>
							<input type="password" class="form-control" placeholder="Password" name="password" required>
						</div>
						<button class="btn btn-round btn-success" type="submit">Log In</button>
				</form>
				<div class="separator">
					<div>
					  <p>Copyright &copy; 2021. Powered by IT RSMN</p>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
