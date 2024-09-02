<?php
	session_start();
	include "../koneksi/koneksi_sdm.php";
	$un = preg_replace("/[^0-9]/", "", $_POST['username']);
	$username = mysql_real_escape_string($un);
	$password = mysql_real_escape_string($_POST['password']);
	$password = md5(sha1($password));
	$query	= "SELECT * FROM pegawai WHERE (REPLACE(REPLACE(NIP, '.',''),'-','') = '$username' or REPLACE(REPLACE(HP, '.',''),'-','') = '$username') AND password='$password' AND AKTIF ='1'";
	//echo $query;exit;
	$hasil 	= mysql_query($query);
	$data 	= mysql_fetch_array($hasil);
	// cek kesesuaian password
	if ($password == $data['PASSWORD']){
		$role = get_role($data['PEGAWAI_ID']);
		if($role){
			$_SESSION['simrsig']		= $data['PEGAWAI_ID'];
			$_SESSION['username']		= $data['USERNAME'];
			//$_SESSION['password'] 		= $data['password'];
			$_SESSION['nama'] 			= $data['NAMA'];
			$_SESSION['ruangan'] 		= $role['ruangan_id'];
			$_SESSION['group'] 			= $role['role_id'];
			$filter_token = base64_encode(base64_encode($role['ruangan_id'].'___ruangan'));
			header('location:scan_qrcode.php?gid='.$filter_token);
		}else{
			header('location:index.php?pesan=tidakaktif');
		}
	}else{
		header('location:index.php?pesan=gagal');
	}
	
	function get_role($id_pegawai){
		include "../koneksi/koneksi.php";
		$query2 = "select * from ipl_pengguna where pegawai_id = $id_pegawai and aktif = 1 and deletemark = 0";
		$hasil2 = mysql_query($query2);
		$data 	= mysql_fetch_array($hasil2);
		return $data;
	}
?>
