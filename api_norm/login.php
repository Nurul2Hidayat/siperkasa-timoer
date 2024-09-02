<?php
	require_once('./vendor/autoload.php');
	use Firebase\JWT\JWT;
	use Dotenv\Dotenv;

	$dotenv = Dotenv::createImmutable(__DIR__);
	$dotenv->load();

	header('Content-Type: application/json');
	
	include "../condb/consdebe.php";
	$json = file_get_contents('php://input');
	$input = json_decode($json);
	$un = isset($_POST['g_username'])?$_POST['g_username'] : $input->email;
	$pw = isset($_POST['g_password'])?$_POST['g_password'] : $input->password;

	$username = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($un,ENT_QUOTES))));
	$password = md5(sha1($pw));

	$qakses = mysql_query("select pegawai_id, nip, nama, jabatan, username, role_id, status_kepegawaian from pegawai where delete_mark = 0 and status_karyawan = 1 and username = '$username' and password = '$password'");
	$dakses = mysql_fetch_row($qakses);

	$expired_time = time() + (3 * 60);
	
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		http_response_code(405);
		exit();
	}else{
		$json = file_get_contents('php://input');
		$input = json_decode($json);
		if (count($dakses) == 1) {
			echo json_encode([
				'message' => 'Email atau password tidak sesuai'
			]);
		  exit();
		}else{
			$payload = [
				'email' => $username,
				'nama'	=> $dakses[2],
				'roleid'=> $dakses[5],
				'id'	=> $dakses[0],
				'exp' 	=> $expired_time
			];
			$access_token = JWT::encode($payload, $_ENV['ACCESS_TOKEN_SECRET'], 'HS256');
			setcookie('jwttoken', $access_token, $payload['exp'], '', '', false, true);
			$row2 = mysql_fetch_array($qakses);
			$_SESSION['login_users']	= $row2['username'];
			$_SESSION['nama_users']		= $row2['nama'];
			$_SESSION['role_cat']		= $row2['role_id'];
			echo json_encode([
				'accessToken' => $access_token,
				'expiry' => date(DATE_ISO8601, $expired_time),
				'nama_user' => $dakses[2]
			]);
		}
	}
?>