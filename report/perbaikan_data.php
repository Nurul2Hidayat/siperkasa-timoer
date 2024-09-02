<?php
	include "../koneksi/koneksi.php";
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_jml(){
		$status_id 	= $_POST['status_id'];
		$ruangan 	= $_POST['fruangan']=='all' ? '' : ' and ruangan_id = '.$_POST['fruangan'];
		$tgl_awl 	= $_POST['ftgl_awl'];
		$tgl_akr 	= $_POST['ftgl_akr'];
		$query = "SELECT COUNT(permintaan_id) jml, status_id
				FROM ipl_permintaan
				WHERE delete_mark = 0
				AND status_id = $status_id
				AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
				$ruangan
				group by status_id";
		$sql = mysql_query($query);
		$data = mysql_fetch_assoc($sql);
		$data = $data == false ? array('jml'=>0, 'status_id'=>$status_id) : $data;
		echo json_encode($data);
	}
	
	function get_chart_bln(){
		$res = array(
                'opn'=>array(0,0,0,0,0,0,0,0,0,0,0,0),
                'prg'=>array(0,0,0,0,0,0,0,0,0,0,0,0),
                'sls'=>array(0,0,0,0,0,0,0,0,0,0,0,0),
                'pdg'=>array(0,0,0,0,0,0,0,0,0,0,0,0),
				'ttl'=>array(0,0,0,0,0,0,0,0,0,0,0,0)
            );
		$ruangan 	= $_POST['fruangan']=='all' ? '' : ' and ruangan_id = '.$_POST['fruangan'];
		$tgl_awl 	= $_POST['ftgl_awl'];
		$tgl_akr 	= $_POST['ftgl_akr'];
		$query="SELECT tb0.bln, IFNULL(tb0.jml, 0) ttl, IFNULL(tb1.jml, 0) opn, IFNULL(tb2.jml, 0)prg, IFNULL(tb3.jml, 0)sls, IFNULL(tb4.jml, 0) pdg
				FROM(
					SELECT 
						MONTH(tanggal_permintaan) bln,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY MONTH(tanggal_permintaan)
				)tb0
				LEFT JOIN (
					SELECT 
						MONTH(tanggal_permintaan) bln,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 10
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY MONTH(tanggal_permintaan)
				)tb1 ON tb0.bln = tb1.bln
				LEFT JOIN (
					SELECT 
						MONTH(tanggal_permintaan) bln,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 11
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY MONTH(tanggal_permintaan)
				)tb2 ON tb0.bln = tb2.bln
				LEFT JOIN (
					SELECT 
						MONTH(tanggal_permintaan) bln,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 12
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY MONTH(tanggal_permintaan)
				)tb3 ON tb0.bln = tb3.bln
				LEFT JOIN (
					SELECT 
						MONTH(tanggal_permintaan) bln,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 14
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY MONTH(tanggal_permintaan)
				)tb4 ON tb0.bln = tb4.bln
				LEFT JOIN (
					SELECT 
						MONTH(tanggal_permintaan) bln,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 15
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY MONTH(tanggal_permintaan)
				)tb5 ON tb0.bln = tb5.bln
				LEFT JOIN (
					SELECT 
						MONTH(tanggal_permintaan) bln,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 13
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY MONTH(tanggal_permintaan)
				)tb6 ON tb0.bln = tb6.bln
				LEFT JOIN (
					SELECT 
						MONTH(tanggal_permintaan) bln,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 13
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY MONTH(tanggal_permintaan)
				)tb4 ON tb0.bln = tb4.bln";
		$sql = mysql_query($query);
		while($data = mysql_fetch_array($sql)){
			$res['opn'][$data['bln']-1] = (int)$data['opn'];
			$res['prg'][$data['bln']-1] = (int)$data['prg'];
			$res['sls'][$data['bln']-1] = (int)$data['sls'];
			$res['pdg'][$data['bln']-1] = (int)$data['pdg'];
			$res['ttl'][$data['bln']-1] = (int)$data['ttl'];
		}
		echo json_encode($res);
	}
	
	function get_chart_day(){
		$ruangan 	= $_POST['fruangan']=='all' ? '' : ' and ruangan_id = '.$_POST['fruangan'];
		$tgl_awl 	= $_POST['ftgl_awl'];
		$tgl_akr 	= $_POST['ftgl_akr'];
		$tgl_akr_plus_one = date('Y-m-d', strtotime($tgl_akr . ' +1 day'));
		$period = new DatePeriod(
				new DateTime($tgl_awl),
				new DateInterval('P1D'),
				new DateTime($tgl_akr_plus_one)
		);
		foreach($period as $k=>$v){
			$date = date_format($v,"Y-m-d");
			$res['tgl'][$k] = $date;
			$res['ttl'][$k] = 0;
			$res['opn'][$k] = 0;
			$res['prg'][$k] = 0;
			$res['sls'][$k] = 0;
			$res['pdg'][$k] = 0;
			$res['mng'][$k] = 0;
			$res['tkf'][$k] = 0;
		}
		
		$query="SELECT tb0.tgl, IFNULL(tb0.jml, 0) ttl, IFNULL(tb1.jml, 0) opn, IFNULL(tb2.jml, 0)prg, IFNULL(tb3.jml, 0)sls, IFNULL(tb4.jml, 0) pdg,  IFNULL(tb5.jml, 0) mng,  IFNULL(tb6.jml, 0) tkf
				FROM(
					SELECT 
						DATE(tanggal_permintaan) tgl,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY DATE(tanggal_permintaan)
				)tb0
				LEFT JOIN (
					SELECT 
						DATE(tanggal_permintaan) tgl,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 10
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY DATE(tanggal_permintaan)
				)tb1 ON tb0.tgl = tb1.tgl
				LEFT JOIN (
					SELECT 
						DATE(tanggal_permintaan) tgl,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 11
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY DATE(tanggal_permintaan)
				)tb2 ON tb0.tgl = tb2.tgl
				LEFT JOIN (
					SELECT 
						DATE(tanggal_permintaan) tgl,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 12
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY DATE(tanggal_permintaan)
				)tb3 ON tb0.tgl = tb3.tgl
				LEFT JOIN (
					SELECT 
						DATE(tanggal_permintaan) tgl,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 13
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY DATE(tanggal_permintaan)
				)tb4 ON tb0.tgl = tb4.tgl
				LEFT JOIN (
					SELECT 
						DATE(tanggal_permintaan) tgl,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id in (14,16)
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY DATE(tanggal_permintaan)
				)tb5 ON tb0.tgl = tb5.tgl
				LEFT JOIN (
					SELECT 
						DATE(tanggal_permintaan) tgl,
						COUNT(permintaan_id) jml
					FROM ipl_permintaan
					WHERE delete_mark = 0
					AND status_id = 15
					AND STR_TO_DATE(tanggal_permintaan, '%Y-%m-%d') BETWEEN '$tgl_awl' AND '$tgl_akr'
					$ruangan
					GROUP BY DATE(tanggal_permintaan)
				)tb6 ON tb0.tgl = tb6.tgl";
		//echo $query;exit;
		$sql = mysql_query($query);
		while($data = mysql_fetch_array($sql)){
			foreach($period as $k=>$v){
				$date = date_format($v,"Y-m-d");
				//echo $data['tgl'] .'=='. $date.'<br>';
				if($data['tgl'] == $date){
					$res['tgl'][$k] = $date;
					$res['opn'][$k] = (int)$data['opn'];
					$res['prg'][$k] = (int)$data['prg'];
					$res['sls'][$k] = (int)$data['sls'];
					$res['pdg'][$k] = (int)$data['pdg'];
					$res['ttl'][$k] = (int)$data['ttl'];
					$res['mng'][$k] = (int)$data['mng'];
					$res['tkf'][$k] = (int)$data['tkf'];
				}else{
					if(!isset($res['tgl'][$k])){
						$res['tgl'][$k] = $date;
						$res['opn'][$k] = 0;
						$res['prg'][$k] = 0;
						$res['sls'][$k] = 0;
						$res['pdg'][$k] = 0;
						$res['ttl'][$k] = 0;
						$res['mng'][$k] = 0;
						$res['tkf'][$k] = 0;
					}
				}
			}
		}
		echo json_encode($res);
	}
	
	function get_detail(){
		$ruangan 	= $_POST['gruangan']=='all' ? '' : ' and ruangan_id = '.$_POST['gruangan'];
		if($_POST['gjenis'] == 'tgl'){
			$where = "DATE(pm.tanggal_permintaan) = '$_POST[gtanggal]' $ruangan";
		}else{
			$where = "DATE(pm.tanggal_permintaan) BETWEEN '$_POST[gawl]' AND '$_POST[gakr]' AND st.status_id = $_POST[gsts] $ruangan";
		}
		$query = "SELECT 
					pm.permintaan, 
					pm.pelapor, 
					pg.nama nm_pelapor,
					pm.tanggal_permintaan, 
					pm.status_id, 
					st.nm_status,
					(SELECT pg.nama FROM ipl_tindakan td LEFT JOIN ipl_pengguna pg ON pg.pegawai_id = td.petugas_id WHERE delete_mark = 0 AND permintaan_id = pm.permintaan_id ORDER BY tindakan_id LIMIT 1) petugas
				FROM ipl_permintaan pm
				LEFT JOIN ipl_pengguna pg ON pm.pelapor = pg.pegawai_id
				LEFT JOIN ipl_status st ON st.status_id = pm.status_id
				WHERE 
					$where
					AND pm.delete_mark = 0";
		//echo $query;
		$sql = mysql_query($query);
		$no = 1;
		if($sql){
			$cnt = mysql_num_rows($sql);
			if($cnt <= 0){
				$res['data'][] = array(
					'no'		=> '',
					'permintaan'=> '',
					'pelapor'	=> '',
					'tanggal'	=> '',
					'status'	=> '',
					'petugas'	=> ''
				);
			}else{
				while($data = mysql_fetch_array($sql)){
					if($data['status_id'] == 10){
						$style = 'background-color:#d2322d;';
					}else if($data['status_id'] == 11){
						$style = 'background-color:#ffed8b; color:#8a6d3b';
					}else if($data['status_id'] == 12){
						$style = 'background-color:#0088cc;';
					}else if($data['status_id'] == 13){
						$style = 'background-color:#313131;';
					}else if($data['status_id'] == 14 || $data['status_id'] == 16){
						$style = 'background-color:#47a447;';
					}else if($data['status_id'] == 15){
						$style = 'background-color:#5bc0de;';
					}else{
						$style = 'background-color:#ebebeb; color:#606060';
					}
					$res['data'][] = array(
						'no'		=> $no++,
						'permintaan'=> $data['permintaan'],
						'pelapor'	=> $data['nm_pelapor'],
						'tanggal'	=> $data['tanggal_permintaan'],
						'status'	=> "<span class='label' style='$style'>$data[nm_status]</span>",
						'petugas'	=> $data['petugas']
					);
				}
			}
			echo json_encode($res);
		}else{
			echo 'error';
		}
	}
?>