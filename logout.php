<?php 
	session_start();
	session_destroy();
	//$location = isset($_GET['qr']) ? 'location:scan_qrcode/scan_qrcode.php?gid='.$_GET['qr'] : 'location:index.php';
	if(isset($_GET['qr'])){
		$location = 'location:scan_qrcode/scan_qrcode.php?gid='.$_GET['qr'];
	}else if(isset($_GET['list'])){
		$location = 'location:scan_qrcode/scan_qrcode_list.php';
	}else{
		$location = 'location:index.php';
	}
	header($location);
?>