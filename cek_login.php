<?php
	session_start();
	include "koneksi/koneksi_sdm.php";
	$un = preg_replace("/[^0-9]/", "", $_POST['username']);
	$username = mysql_real_escape_string($un);
	$password = mysql_real_escape_string($_POST['password']);
	$salt 	  = "berisi_slat_rsmn_untuk_aplikasi_siperkasa_timoer";
	$password = md5(sha1($password.$salt));
	$query 	= "SELECT * FROM pegawai WHERE (REPLACE(REPLACE(REPLACE(NIP, '.',''),'-',''),' ','') = '$username' or REPLACE(REPLACE(HP, '.',''),'-','') = '$username') AND password='$password' AND AKTIF ='1'";
	$hasil 	= mysql_query($query);
	$data 	= mysql_fetch_array($hasil);
	// cek kesesuaian password
	if ($password == $data['PASSWORD']){
		$role = get_role($data['PEGAWAI_ID']);
		$_SESSION['simrsig']		= $data['PEGAWAI_ID'];
		$_SESSION['id_pengguna']	= $role['id'];
		$_SESSION['username']		= $data['USERNAME'];
		//$_SESSION['password'] 		= $data['password'];
		$_SESSION['nama'] 			= $data['NAMA'];
		//$_SESSION['unit'] 			= $data['instalasi_id'];
		$_SESSION['ruangan'] 		= $role['ruangan_id'];
		$_SESSION['group'] 			= $role['role_id'];
		header('location:media.php?module=permintaanipsls');
	}else{
		header("location:index.php?pesan=gagal");
	}
	
	function get_role($id_pegawai){
		include "koneksi/koneksi.php";
		$query2 = "select * from ipl_pengguna where pegawai_id = $id_pegawai and aktif = 1 and deletemark = 0";
		$hasil2 = mysql_query($query2);
		$data 	= mysql_fetch_array($hasil2);
		return $data;
	}
?>
