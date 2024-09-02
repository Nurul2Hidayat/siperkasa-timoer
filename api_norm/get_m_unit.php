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
				$qpasien = mysql_query("SELECT id, kode, kodeaskes, nama FROM b_ms_unit WHERE aktif = 1 AND LEVEL = 2");
				while($dpasien = mysql_fetch_array($qpasien)){
					$return[] = array('unit_id'=> $dpasien['id'], 'unit_kode'=> $dpasien['kodeaskes'], 'unit_nama'=>$dpasien['nama']);
					//$return .= "<option value='$dpasien[id]'>$dpasien[nama]</option>";
				}
				echo json_encode($return);
				
			} catch (Exception $e) {
			  http_response_code(401);
			  exit();
			}

		}
	}	
?>