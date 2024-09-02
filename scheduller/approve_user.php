<?php
	include "../koneksi/koneksi.php";
	include "../save_log.php";
	$query = "SELECT 
				pm.pelapor,
				pl.nama nm_pelapor,
				pm.permintaan,
				pm.permintaan_id,
				pm.tanggal_permintaan,
				pm.status_id,
				st.nm_status,
				cg.id log_id,
				cg.create_by,
				pt.nama nm_petugas,
				pt.ruangan_id,
				cg.create_date
			FROM ipl_permintaan pm
			LEFT JOIN ipl_log_sts_permintaan cg ON cg.permintaan_id = pm.permintaan_id
			LEFT JOIN ipl_pengguna pl ON pl.pegawai_id = pm.pelapor
			LEFT JOIN ipl_status st ON st.status_id = pm.status_id
			LEFT JOIN ipl_pengguna pt ON pt.pegawai_id = cg.create_by
			WHERE pm.status_id = 14
			AND cg.create_date < DATE_SUB(NOW(), INTERVAL 1 DAY)
			GROUP BY pm.permintaan_id";
	$sql = mysql_query($query);
	$cnt = mysql_num_rows($sql);
	if($cnt > 0){
		while($row = mysql_fetch_array($sql)){
			$query = "update ipl_permintaan set status_id = 12 where permintaan_id = $row[permintaan_id]";
			if(mysql_query($query)){
				$par = array('id'=>$row['permintaan_id'], 'val'=>12, 'peg'=>$row['pelapor']);
				$ret = log_status($par);
				send_wa_change_status($par);
			}else{
				$ret = array(
					'sts' 	=> 0,
					'permintaan_id'	=> $row['permintaan_id'],
					'pegawai_id'	=> $row['pelapor'],
					'nama'	=> 'approve_permintaan',
					'msg' 	=> mysql_error()
				);
			}
			$res = save_log_sceduller($ret);
			echo $res;
		}
	}else{
		$ret = array(
			'sts' 	=> 1,
			'permintaan_id'	=> 0,
			'pegawai_id'	=> 0,
			'nama'	=> 'approve_permintaan',
			'msg' 	=> 'tidak ada data'
		);
		$res = save_log_sceduller($ret);
		echo $res;
	}
	
	function send_wa_change_status($par){
		$query = "SELECT un.nama nm_ruangan, ia.nm_aset, ia.aset_id, ia.unit_pj, pg.nama nm_pelapor, ip.permintaan, ip.tanggal_permintaan, ip.jumlah, ip.lokasi
					FROM ipl_permintaan ip
					LEFT JOIN unit un ON un.id_unit = ip.ruangan_id
					LEFT JOIN ipl_aset ia ON ia.aset_id = ip.aset_id
					LEFT JOIN ipl_pengguna pg ON pg.pegawai_id = ip.pelapor
					WHERE ip.permintaan_id = $par[id]";
		$sql = mysql_query($query);
		$data = mysql_fetch_array($sql);
		$filter_token	= base64_encode(base64_encode($data['aset_id'].'___aset'));
		
		//$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/scan_qrcode_list.php";
		//$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode";
		$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/scan_qrcode.php?gid=$filter_token";
		//$teks_qrcode	= "http://rsmn.it-rs.id/it/scan_qrcode/scan_qrcode.php?gid=$filter_token/";

$text = "Perbaikan sudah dikonfirmasi by sistem dengan status *Sudah Selesai*
Status Permintaan perbaikan akan di ubah menjadi *Selesai*
Pelapor : *$data[nm_pelapor]*
Ruangan : $data[nm_ruangan]
Barang : $data[nm_aset]
Kerusakan : $data[permintaan]
Waktu : $data[tanggal_permintaan]
Jumlah : $data[jumlah]
Lokasi : $data[lokasi]
";
		
		$ruangan_id = $data['unit_pj'] == 1 ? 51 : 53;
		$qy2 = "select pegawai_id from ipl_pengguna where ruangan_id = $ruangan_id AND deletemark = 0";
		$sql2 = mysql_query($qy2);
		$res = array();
		while($row = mysql_fetch_array($sql2)){
			include "../koneksi/koneksi_sdm.php";
			$qy3 = mysql_query("select HP from pegawai where PEGAWAI_ID = $row[pegawai_id]");
			$row3 = mysql_fetch_assoc($qy3);
			if($row3['HP']){
				$curl = curl_init();

				curl_setopt_array($curl, array(
					CURLOPT_URL => 'http://192.168.0.237:4567/pesan/teks',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => json_encode(array("nomor"=>"$row3[HP]", "pesan"=>"$text")),
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json'
					),
				));

				$response = curl_exec($curl);

				curl_close($curl);
				$res[]= $response;
			}
		}
		return $res;
	}
	
	function log_status($data){
		include "../koneksi/koneksi.php";
		$ket = isset($data['ket']) ? $data['ket'] : '';
		$query = "insert into ipl_log_sts_permintaan(permintaan_id, status_id, ket, create_by)
												value($data[id], $data[val], '$ket', 0)";
		if(mysql_query($query)){
			$ret = array(
				'sts' 	=> 1,
				'permintaan_id'	=> $data['id'],
				'pegawai_id'	=> $data['peg'],
				'nama'	=> 'approve_permintaan',
				'msg' 	=> 'Berhasil mengubah data'
			);
		}else{
			$ret = array(
				'sts' 	=> 0,
				'permintaan_id'	=> $data['id'],
				'pegawai_id'	=> $data['peg'],
				'nama'	=> 'approve_permintaan',
				'msg' 	=> mysql_error()
			);
		}
		return $ret;
	}
?>