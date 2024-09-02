<?php
	require_once('./vendor/autoload.php');
	use Firebase\JWT\JWT;
	use Dotenv\Dotenv;
	use Firebase\JWT\Key;
	include 'conection.php';
	
	$dotenv = Dotenv::createImmutable(__DIR__);
	$dotenv->load();
	
	header('Content-Type: application/json');
	
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		http_response_code(405);
		exit();
	}else{
		$headers = getallheaders();
		if (!isset($headers['Authorization'])) {
			http_response_code(401);
			exit();
		}else{
			list(, $token) = explode(' ', $headers['Authorization']);
			try {
				
				JWT::decode($token, new Key($_ENV['ACCESS_TOKEN_SECRET'], 'HS256'));
				
				$nomer_rm = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($_GET['norm'],ENT_QUOTES))));
				
				$return = array();
				$query = mysql_query("SELECT 
										mp.id,
										(SELECT id FROM b_kunjungan WHERE pasien_id = mp.id GROUP BY id ORDER BY id LIMIT 1) kunjungan_id,
										mp.no_rm,
										mp.nama,
										sex,
										ROUND(DATEDIFF(CURRENT_DATE, tgl_lahir)/365) umur,
										mpd.nama pendidikan,
										mpk.nama pekerjaan,
										mp.alamat
									FROM b_ms_pasien mp
									LEFT JOIN b_ms_pendidikan mpd ON mpd.id = mp.pendidikan_id
									LEFT JOIN b_ms_pekerjaan mpk ON mpk.id = mp.pekerjaan_id
									WHERE 
									mp.no_rm = '$nomer_rm'");
				$data = mysql_fetch_row($query);
				//echo json_encode($data);
				
				$qpasien = mysql_query("SELECT unit_id, unit_nama
										FROM (									
											SELECT 
												mp.id,
												mp.jenis_layanan,
												mt.nama layanan_nama,
												mp.unit_id,
												mu.nama unit_nama,
												mp.dokter_id,
												mpg.nama dokter_nama,
												mp.tgl
											FROM b_pelayanan mp
											LEFT JOIN (SELECT id FROM b_kunjungan WHERE pasien_id = '$data[0]' GROUP BY id ORDER BY id LIMIT 1) mk ON mk.id = mp.kunjungan_id
											LEFT JOIN b_ms_unit mu ON mu.id = mp.unit_id
											LEFT JOIN b_ms_pegawai mpg ON mpg.id = mp.`dokter_id`
											LEFT JOIN b_ms_tindakan mt ON mt.id = mp.jenis_layanan
											WHERE kunjungan_id = (SELECT id FROM b_kunjungan WHERE pasien_id = '$data[0]' GROUP BY id ORDER BY id LIMIT 1)
										)tbl GROUP BY unit_id, unit_nama");
				while($dpasien = mysql_fetch_array($qpasien)){
					$return['unit'][] = array('unit_id'=> $dpasien['unit_id'], 'unit_nama'=>$dpasien['unit_nama']);
				}
				$return['pasien'] = $data;
				echo json_encode($return);
				
			} catch (Exception $e) {
			  http_response_code(401);
			  exit();
			}

		}
	}	
?>