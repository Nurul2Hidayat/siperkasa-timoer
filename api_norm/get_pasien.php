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
				$return = array();
				$query = mysql_query("SELECT DISTINCT * FROM (
					SELECT mpas.id, mpas.no_rm, mpas.nama, mpas.alamat
					FROM b_ms_pasien mpas
					INNER JOIN b_kunjungan mkun ON mkun.`pasien_id` = mpas.id
					INNER JOIN b_pelayanan mpel ON mpel.`kunjungan_id` = mkun.id
					WHERE (mkun.`pulang` = 1 AND DATE_FORMAT(mkun.tgl_pulang, '%d-%m-%Y') = '".date('d-m-Y')."') OR (mpel.dilayani = 2 AND DATE_FORMAT(mpel.`tgl_krs`, '%d-%m-%Y') = '".date('d-m-Y')."')
					) AS tbl ORDER BY nama");
				while($data = mysql_fetch_array($query)){
					$return[] = array('id'=>$data['id'], 'no_rm'=>$data['no_rm'], 'nama'=>$data['nama'], 'alamat'=>$data['alamat']);
				}
				echo json_encode($return);
				
			} catch (Exception $e) {
			  http_response_code(401);
			  exit();
			}

		}
	}	
?>