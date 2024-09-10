<?php
$server 	= "localhost";
$username 	= "root";
$password 	= "";
$database 	= "dari_db_siperkasa";

// Koneksi dan memilih database di server
$conn = mysql_connect($server, $username, $password, $database);
$db_selected = mysql_select_db('dari_db_siperkasa', $conn);
if (!$db_selected) {
    die ('Can\'t use : ' . mysql_error());
}
?>