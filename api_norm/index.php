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
			//$coba = JWT::decode($token, new Key($_ENV['ACCESS_TOKEN_SECRET'], 'HS256'));
			try {
				
				JWT::decode($token, new Key($_ENV['ACCESS_TOKEN_SECRET'], 'HS256'));
				
				$nomer_rm = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($_GET['norm'],ENT_QUOTES))));

				$query = mysql_query("select count(no_rm) jml from b_ms_pasien where no_rm = '$nomer_rm'");
				$data = mysql_fetch_row($query);
				echo json_encode($data);
			} catch (Exception $e) {
			  http_response_code(401);
			  exit();
			}

		}
	}	
?>