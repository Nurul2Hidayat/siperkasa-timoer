<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function cek_password(){
		include "../koneksi/koneksi_sdm.php";
		session_start();
		$pw_now = md5(sha1($_POST['pw_now']));
		$sql = mysql_query("select count(PEGAWAI_ID) cnt from pegawai where PEGAWAI_ID = $_SESSION[simrsig] and password = '$pw_now'");
		$data = mysql_fetch_array($sql);
		if($data['cnt'] > 0){
			if($_POST['pw_new'] === $_POST['pw_new_k']){
				$pass_new = md5(sha1($_POST['pw_new']));
				$sql_upd = "update pegawai set password = '$pass_new' where PEGAWAI_ID = $_SESSION[simrsig]";
				if(mysql_query($sql_upd)){
					$ret = array('sts'=> 1, 'msg'=>'berhasil mengganti password');
				}else{
					$ret = array('sts'=> 0, 'msg'=>mysql_error());
				}
			}else{
				$ret = array('sts'=> 0, 'msg'=>'password baru tidak sama dengan konfirmasi password');
			}
		}else{
			$ret = array('sts'=> 0, 'msg'=>'password saat ini tidak sesuai');
		}
		echo json_encode($ret);
	}
?>