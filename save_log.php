<?php
	function save_log_sceduller($par){
		include "koneksi/koneksi.php";
		$query = "insert into ipl_log_scheduler(nama, permintaan_id, pegawai_id, status, ket)
										value('$par[nama]', $par[permintaan_id], $par[pegawai_id], $par[sts], '$par[msg]')";
		if(mysql_query($query)){
			$ret = array('sts'=>1, 'msg'=>'sukses');
		}else{
			$ret = array('sts'=>0, 'msg'=>mysql_error());
		}
		echo json_encode($ret);
	}
?>