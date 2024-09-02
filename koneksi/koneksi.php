<?php
$server 	= "localhost";
$username 	= "root";
$password 	= "";
$database 	= "dbsimrsig";

// Koneksi dan memilih database di server
$conn = mysql_connect($server, $username, $password, $database);
$db_selected = mysql_select_db('dbsimrsig', $conn);
if (!$db_selected) {
    die ('Can\'t use : ' . mysql_error());
}
?>