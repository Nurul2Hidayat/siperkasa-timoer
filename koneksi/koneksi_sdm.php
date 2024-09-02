<?php
	$server2 	= "192.168.0.233";
	$username2 	= "umum";
	$password2 	= "RSmndb2020";
	$database2 	= "rsmn_sdm";

	// Koneksi dan memilih database di server
	$conn2 = mysql_connect($server2, $username2, $password2, $database2);
	$db_selected2 = mysql_select_db('rsmn_sdm', $conn2);
	if (!$db_selected2) {
		die ('Can\'t use : ' . mysql_error());
	}
?>