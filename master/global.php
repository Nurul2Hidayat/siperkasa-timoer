<?php
	session_start();
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_option_tipe(){
		include "../koneksi/koneksi.php";
		$result = "";
		$jenis_id = $_POST['gkey'];
		$tipe_id = $_POST['gval'];
		$query = mysql_query("select mt.tipe_id, mt.nm_tipe, mt.aktif 
							from ipl_tipe  mt
							where mt.jenis_id = $jenis_id and mt.aktif = 1 and mt.delete_mark = 0");
							
		while($data = mysql_fetch_array($query)){
			//$checked = $tipe_id == $data['tipe_id'] ? 'checked' : '';
			//$result .= "<div class='radio'>";
			//$result .= "<label><input type='radio' name='g_tipe' value='$data[tipe_id]' $checked>$data[nm_tipe]</label>";
			//$result .= "</div>";
			$selected = $tipe_id == $data['tipe_id'] ? 'selected' : '';
			$result .= "<option value='$data[tipe_id]' $selected> $data[nm_tipe]</option>";
		}
		echo json_encode($result);
	}
	
	function get_option_status(){
		include "../koneksi/koneksi.php";
		$result = "";
		$jenis_id = $_POST['gkey'];
		$status_id = $_POST['gval'];
		$fc = $_POST['gf'];
		$result = "";
		$where = "";
		if($fc == 'filter'){
			$result .= "<option value='all'>Semua</option>";
		}else{
			$where = " AND status_id <> 12";
		}
		$query = mysql_query("select status_id, nm_status, aktif from ipl_status where jenis_id = $jenis_id and delete_mark = 0 $where order by urut");
		while($data = mysql_fetch_array($query)){
			$selected = $status_id == $data['status_id'] ? 'selected' : '';
			if($fc != 'filter' && $data['status_id'] == 14){
				$data['nm_status'] = 'Selesai (konfirmasi user)';
			}
			$result .= "<option value='$data[status_id]' $selected> $data[nm_status]</option>";
		}
		echo json_encode($result);
	}
	
	function get_option_ruangan(){
		include "../koneksi/koneksi.php";  
		$id = $_POST['gid'];
		$fc = $_POST['gf'];
		$result = "<option></option>";
		if($fc == 'filter'){
			$result .= "<option value='all'>Semua</option>";
		}
		$query = mysql_query("select id_unit, nama from unit where aktif = 1 and delete_mark = 0");
		while($data = mysql_fetch_array($query)){
			$result .= "<option value='$data[id_unit]'>$data[nama]</option>";
		}
		echo json_encode($result);
	}
	
	function get_option_jenis(){
		include "../koneksi/koneksi.php";  
		$id = $_POST['gid'];
		$result = "";
		
		$query = mysql_query("select jenis_id, nm_jenis from ipl_jenis where delete_mark = 0");
		while($data = mysql_fetch_array($query)){
			$result .= "<option value='$data[jenis_id]'>$data[nm_jenis]</option>";
		}
		echo json_encode($result);
	}
	
	function get_aset(){
		include "../koneksi/koneksi.php";
		$result = "";
		$query = mysql_query("SELECT ij.aset_id, 
								ij.nm_aset,
								un.nama
							FROM ipl_aset ij
							LEFT JOIN unit un ON un.id_unit = ij.ruangan_id
							WHERE ij.delete_mark = 0");
		while($data = mysql_fetch_array($query)){
			$result .= "<option value='$data[aset_id]'>$data[nm_aset] ($data[nama])</option>";
		}
		echo json_encode($result);
	}
	
	function get_option_pegawai(){
		include "../koneksi/koneksi.php";
		$f = $_POST['gf'];
		$result = "<option></option>";
		if($f == 'filter'){
			$result .= "<option value='all'>Semua</option>";
		}
		$query = mysql_query("select pegawai_id, nama from ipl_pengguna where deletemark = 0 and aktif = 1");
		while($data = mysql_fetch_array($query)){
			$result .= "<option value='$data[pegawai_id]'>$data[nama]</option>";
		}
		echo $result;
		//echo json_encode($result);
	}
	
	function get_option_teknisi(){
		include "../koneksi/koneksi.php";
		$f = $_POST['gf'];
		$result = "<option></option>";
		if($f == 'filter'){
			$result .= "<option value='all'>Semua</option>";
		}
		$query = mysql_query("select pegawai_id, nama from ipl_pengguna where deletemark = 0 and aktif = 1 and role_id = 2 and ruangan_id = $_SESSION[ruangan]");
		while($data = mysql_fetch_array($query)){
			$result .= "<option value='$data[pegawai_id]'>$data[nama]</option>";
		}
		echo $result;
		//echo json_encode($result);
	}
	
	function get_role(){
		include "../koneksi/koneksi.php";
		$result = "";
		$status_id = $_POST['gid'];
		$query = mysql_query("select id_group, nama from `group`");
		while($data = mysql_fetch_array($query)){
			$selected = $status_id == $data['id_group'] ? 'selected' : '';
			$result .= "<option value='$data[id_group]' $selected> $data[nama]</option>";
		}
		echo json_encode($result);
	}
	
	function get_option_tipe_aset(){
		include "../koneksi/koneksi.php";
		$result = "";
		$aset_id = $_POST['gkey'];
		$tipe_id = $_POST['gval'];
		$query = mysql_query("select id, nm_tipe, aktif from ipl_aset_tipe where aset_id = $aset_id and deletemark = 0 and aktif = 1");
		while($data = mysql_fetch_array($query)){
			$selected = $tipe_id == $data['id'] ? 'selected' : '';
			$result .= "<option value='$data[id]' $selected> $data[nm_tipe]</option>";
		}
		echo json_encode($result);
	}
?>