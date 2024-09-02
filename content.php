<?php
include "koneksi/koneksi.php";
date_default_timezone_set('Asia/Jakarta');
$tgl		= date('Y-m-d');
$waktu		= date('Y-m-d H:i:s');

$query = mysql_query("select link, include from modul where link = '$_GET[module]'");
$data = mysql_fetch_array($query);

if ($_GET['module']==$data['link']){
	include $data['include'];
}
?>
