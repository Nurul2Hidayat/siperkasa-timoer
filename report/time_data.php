<?php
	include "../koneksi/koneksi.php";
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		//echo'<pre>';print_r($_POST);exit;
		$ruangan 	= $_POST['gruangan']=='all' ? '' : ' and ruangan_id = '.$_POST['gruangan'];
		$query = "SELECT 
					pm.permintaan_id,
					pm.permintaan, 
					pm.pelapor, 
					pg.nama nm_pelapor,
					pm.tanggal_permintaan, 
					date(pm.tanggal_permintaan) tgl_permintaan, 
					pm.status_id, 
					st.nm_status,
					lopn.create_date time_prs,
					lsls.create_date time_sls
				FROM ipl_permintaan pm
				LEFT JOIN ipl_pengguna pg ON pm.pelapor = pg.pegawai_id
				LEFT JOIN ipl_status st ON st.status_id = pm.status_id
				LEFT JOIN ipl_log_sts_permintaan lopn ON lopn.permintaan_id = pm.permintaan_id AND lopn.status_id = 11
				LEFT JOIN ipl_log_sts_permintaan lsls ON lsls.permintaan_id = pm.permintaan_id AND lsls.status_id = 12
				WHERE 
					DATE(pm.tanggal_permintaan) between '$_POST[gtgl_awl]' and '$_POST[gtgl_akr]'
					$ruangan
					AND pm.delete_mark = 0
				order by pm.tanggal_permintaan desc";
		$sql = mysql_query($query."  limit $_POST[start],$_POST[length]");
		$no = $_POST['start']+1;
		$res['data'] = array();
		while($data = mysql_fetch_array($sql)){
			$time_res = isset($data['time_prs']) ? selisih($data['tanggal_permintaan'], $data['time_prs']) : '-';
			$time_sls = isset($data['time_sls']) ? selisih($data['tanggal_permintaan'], $data['time_sls']) : '-';
			if($time_res == '-' && $time_sls != '-'){
				$time_res = $time_sls;
			}
			if($data['status_id'] == 10){
				$style = 'background-color:#d2322d;';
			}else if($data['status_id'] == 11){
				$style = 'background-color:#ffed8b; color:#8a6d3b';
			}else if($data['status_id'] == 12){
				$style = 'background-color:#0088cc;';
			}else if($data['status_id'] == 13){
				$style = 'background-color:#313131;';
			}else{
				$style = 'background-color:#ebebeb; color:#606060';
			}
			$res['data'][] = array(
				'no'		=> $no++,
				'permintaan'=> $data['permintaan'],
				'pelapor'	=> $data['nm_pelapor'],
				'tanggal'	=> $data['tgl_permintaan'],
				'status'	=> "<span class='label' style='$style'>$data[nm_status]</span>",
				'time_res'	=> $time_res,
				'time_sls'	=> $time_sls
			);
		}
		//echo "select count(tp.permintaan_id) rn from ($query)";exit;
		$sqlrn = mysql_query("select count(tp.permintaan_id) rn from ($query)tp");
		$rown = mysql_fetch_array($sqlrn);
		$res['recordsTotal'] = $rown['rn'];
		$res['recordsFiltered'] = $rown['rn'];
		echo json_encode($res);
	}
	
	function selisih($awal, $akhir){
		$awal	= date_create($awal);
		$akhir	= date_create($akhir);
		$diff	= date_diff( $awal, $akhir );
		
		$text	= $diff->d.' hari, '.$diff->h.' jam,'.$diff->i.' menit,'.$diff->s.' detik';
		return $text;
	}
?>