<?php
	$server2 	= "localhost";
	$username2 	= "root";
	$password2 	= "";
	$database2 	= "dari_db_sdm";

	// Koneksi dan memilih database di server
	$conn2 = mysql_connect($server2, $username2, $password2, $database2);
	$db_selected2 = mysql_select_db('dari_db_sdm', $conn2);
	if (!$db_selected2) {
		die ('Can\'t use : ' . mysql_error());
	}
?>