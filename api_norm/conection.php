<?php
$hostname_conn = "192.168.0.233";
$database_conn = "rsmn_billing";
$username_conn = "umum";
$password_conn = "RSmndb2020";

$dbbilling		= $database_conn;
$dbapotek 		= "rsmn_apotek";
$dbbank_darah	= "bank_darah_rsijs";

$idKasirPendaftaranRJ=127;
$idKasirRJ=81;

$konek=mysql_connect($hostname_conn,$username_conn,$password_conn);
mysql_select_db($database_conn,$konek);



/*$conn_string = "host=192.168.0.36 port=5432 dbname=pacsdb user=pacs password=pacs";
$dbconn4 = pg_connect($conn_string);*/

ini_set('upload_max_filesize', '10');
ini_set('max_execution_time', '800');
ini_set('memory_limit', '-1');
date_default_timezone_set("Asia/Jakarta");

$perpage=100;

if(!isset($set_addslashes)) {
	foreach($_POST as $key => $val){
		if(!is_array($val))
	  		$_POST[$key] = addslashes($val);
	}
	foreach($_GET as $key => $val){
		if(!is_array($val))
	  		$_GET[$key] = addslashes($val);
	}
	foreach($_REQUEST as $key => $val){
		if(!is_array($val))
	  		$_REQUEST[$key] = addslashes($val);
	}
}

function tglSQL($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'-'.$t[1].'-'.$t[0];
   return $t;
}

function toDay($day){
	$days = array('Sunday'=>'Minggu',
				  'Monday'=>'Senin',
				  'Tuesday'=>'Selasa',
				  'Wednesday'=>'Rabu',
				  'Thursday'=>'Kamis',
				  'Friday'=>"Jum'at",
				  'Saturday'=>'Sabtu');
	return $days[$day];
}

function tglJamSQL($tgl){
   $dateTime=explode(" ",$tgl);
   $dateTime=tglSQL($dateTime[0])." ".$dateTime[1];
   return $dateTime;
}

function kekata($x) {
  $x = abs($x);
  $angka = array("", "satu", "dua", "tiga", "empat", "lima",
  "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  $temp = "";
  if ($x <12) {
	  $temp = " ". $angka[$x];
  } else if ($x <20) {
	  $temp = kekata($x - 10). " belas";
  } else if ($x <100) {
	  $temp = kekata($x/10)." puluh". kekata($x % 10);
  } else if ($x <200) {
	  $temp = " seratus" . kekata($x - 100);
  } else if ($x <1000) {
	  $temp = kekata($x/100) . " ratus" . kekata($x % 100);
  } else if ($x <2000) {
	  $temp = " seribu" . kekata($x - 1000);
  } else if ($x <1000000) {
	  $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
  } else if ($x <1000000000) {
	  $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
  } else if ($x <1000000000000) {
	  $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
  } else if ($x <1000000000000000) {
	  $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
  }      
	  return $temp;
}

function terbilang($x, $style=4) {
  if($x<0) {
	  $hasil = "minus ". trim(kekata($x));
  } else {
	  $hasil = trim(kekata($x));
  }      
  switch ($style) {
	  case 1:
		  $hasil = strtoupper($hasil);
		  break;
	  case 2:
		  $hasil = strtolower($hasil);
		  break;
	  case 3:
		  $hasil = ucwords($hasil);
		  break;
	  default:
		  $hasil = ucfirst($hasil);
		  break;
  }      
  return $hasil;
}

$sql="SELECT * FROM b_ms_reference WHERE stref=24";
$rsBD=mysql_query($sql);
$rwBD=mysql_fetch_array($rsBD);
$backdate=$rwBD["nama"];
$DisableBD='';
if ($backdate=="0"){
	$DisableBD='disabled="disabled"';
}

$pTglSkrg=gmdate('Y-m-d',mktime(date('H')+7));

function ValidasiText($x) {
	$txt=str_replace("'","''",$x);
	return $txt;
}

if(!function_exists('getHari')){
	function getHari($bln){
		switch ($bln){
		  case "Monday": 
		  return "Senin";
		  break;
		  case "Tuesday":
		  return "Selasa";
		  break;
		  case "Wednesday":
		  return "Rabu";
		  break;
		  case "Thursday":
		  return "Kamis";
		  break;
		  case "Friday":
		  return "Jumat";
		  break;
		  case "Saturday":
		  return "Sabtu";
		  break;
		  case "Sunday":
		  return "Minggu";
		  break;
		}
	} 
}

if(!function_exists('get_akses_file')){
	function get_akses_file($request_uri, $session_id, $url) {
		$sql = "SELECT mga.id
					FROM b_ms_group_petugas mgp
						INNER JOIN b_ms_group_akses mga ON mga.ms_group_id = mgp.ms_group_id
						INNER JOIN b_ms_menu mm ON mm.id = mga.ms_menu_id
				WHERE mm.url LIKE '%{$request_uri}%' AND mgp.ms_pegawai_id = {$session_id}";
		$query = mysql_query($sql);
		$nums = mysql_num_rows($query);
		$result = '';
		if ( $nums == 0 ) {
			$result = '<script type="text/javascript">
						alert("Anda tidak memiliki hak akses ke menu ini.");
						window.location.href = "'.$url.'";
					   </script>';
		}
		return $result;
	}
}

if(!function_exists('getAgeGlobal')){
	function getAgeGlobal($date1){
		$date2 = gmdate('Y-m-d',mktime(date('H')+7));
		$diff = abs(strtotime($date2) - strtotime($date1));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		if ($years == 0 && $months == 0 && $days != 0) {
			$umur = $days." hr";
		} else if ($years == 0 && $months != 0 && $days == 0) {
			$umur = $months." bln";
		} else if ($years != 0 && $months == 0 && $days == 0) {
			$umur = $years." thn";
		} else if ($years == 0 && $months != 0 && $days != 0) {
			$umur = $months." bln ".$days." hr";
		} else if ($years != 0 && $months == 0 && $days != 0) {
			$umur = $years." thn ".$days." hr";
		} else if ($years != 0 && $months != 0 && $days == 0) {
			$umur = $years." thn ".$months." bln";
		} else {
			$umur = $years." thn ".$months." bln ".$days." hr";	
		}
		return $umur;
	}
}

/* if (!function_exists('currency')){
	function currency($number){
		$data = number_format($number,0,",",".");
		return $data;
	}
} */

$instansi 		= 'RUMAH SAKIT UMUM';
$ins_nama		= 'MOHAMMAD NOER';
$rs_nama 		= 'RUMAH SAKIT UMUM MOHAMMAD NOER PAMEKASAN';
$rs_alamat 		= 'Jl. Bonorogo No. 17, Kecamatan Pademawu, Kabupaten Pamekasan';
$rs_alamat2 	= 'Jl. Bonorogo No. 17, Kecamatan Pademawu, Kabupaten Pamekasan'; 
$rs_telp 		= 'Telp. (0324) 322594 ';
$rs_fax 		= 'Fax. (0324) 323085 ';
$rs_email 		= 'Email : rsumohnoer.jatimprov@gmail.com ';
$rs_kota 		= 'Pamekasan';
$rs_PJ_lab 		= 'dr. Siti Hotimah, Sp.PK';
$rs_PJ_kasir	= 'Yuli Setiana Rahayu, SE';
$rs_web			= 'Website : www.rsumohnoerpamekasan.jatimprov.go.id';

$pemprof		= 'PEMERINTAH PROVINSI JAWA TIMUR';
$dinkes			= 'DINAS KESEHATAN';

$dbakuntansi 	= 'rsmn_akuntansi';
?>
