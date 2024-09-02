<?php
	require_once('./vendor/autoload.php');
	use Firebase\JWT\JWT;
	use Dotenv\Dotenv;
	use Firebase\JWT\Key;
	include 'conection.php';
	
	$dotenv = Dotenv::createImmutable(__DIR__);
	$dotenv->load();
	
	header('Content-Type: application/json');

	if(isset($_COOKIE['jwttoken'])){
		if(isset($_POST['decode'])){
			decode($_COOKIE['jwttoken']);
		}else{
			if(isset($_POST['logout'])){
				unset($_COOKIE['jwttoken']);
				setcookie('jwttoken', '');
				echo 2;
			}else{
				try{
					JWT::decode($_COOKIE['jwttoken'], new Key($_ENV['ACCESS_TOKEN_SECRET'], 'HS256'));
					echo 1;
				}catch(\Firebase\JWT\ExpiredException $e){
					echo 0;
				}
			}
		}
	}else{
		echo 0;
	}
	
	function decode($token){
		try{
			$tdecode = JWT::decode($token, new Key($_ENV['ACCESS_TOKEN_SECRET'], 'HS256'));
			$return['nama'] = $tdecode->nama;
			$return['roleid'] = $tdecode->roleid;
			echo json_encode($return);
		}catch(\Firebase\JWT\ExpiredException $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
?>