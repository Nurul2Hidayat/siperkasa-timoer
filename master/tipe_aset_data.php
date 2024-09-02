<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		include "../koneksi/koneksi.php";
		$tbl = '';
		$no = 1;
		$query = "SELECT iat.id, ias.nm_aset, iat.nm_tipe, iat.aktif, iat.ket
					FROM ipl_aset_tipe iat
					LEFT JOIN ipl_aset ias ON ias.aset_id = iat.aset_id
					WHERE iat.deletemark = 0";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			$aktif = $data['aktif'] == 1 ? 'Aktif' : 'Tidak Aktif';
			$tbl .= "<tr>";
			$tbl .= "<td>$no</td>";
			$tbl .= "<td>$data[nm_aset]</td>";
			$tbl .= "<td>$data[nm_tipe]</td>";
			$tbl .= "<td>$data[ket]</td>";
			$tbl .= "<td>$aktif</td>";
			$tbl .= "<td>
						<a href='#'>
							<button type='button' class='btn btn-success btn-xs' onclick='edit_data($data[id])'>
								<i class='fa fa-pencil'></i>
							</button>
						</a>
						<a href='#'>
							<button type='button' class='btn btn-danger btn-xs' onclick='hapus_data($data[id])'>
								<i class='fa fa-trash-o'></i>
							</button>
						</a>
					</td>";
			$tbl .= "</tr>";
			$no++;
		}
		echo json_encode($tbl);
	}
	
	function get_data_edit(){
		include "../koneksi/koneksi.php";
		$query = mysql_query("select id, aset_id, nm_tipe, ket, aktif from ipl_aset_tipe where id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function edit_data_proses(){
		session_start();
		include "../koneksi/koneksi.php";
		$aset 		= $_POST['g_aset'];
		$nama 		= $_POST['g_nama'];
		$id 		= $_POST['g_id'];
		$deskripsi	= $_POST['g_deskripsi'];
		$aktif	 	= $_POST['g_aktif'];
		
		$q = "update ipl_aset_tipe set
				nm_tipe 			= '$nama',
				aset_id 			= $aset,
				ket		 			= '$deskripsi',
				aktif	 			= $aktif
			where id = $id";
			//echo $q;exit;
		echo mysql_query($q) or die(mysql_error());
	}
	
	function add_data(){
		session_start();
		include "../koneksi/koneksi.php";
		
		$d['aset']		= $_POST['g_aset'];
		$d['nama'] 		= $_POST['g_nama'];
		$d['deskripsi']	= $_POST['g_deskripsi'];
		$d['aktif'] 	= $_POST['g_aktif'];
		
		$query = "insert into ipl_aset_tipe(aset_id, nm_tipe, ket, aktif)
								value($d[aset], '$d[nama]', '$d[deskripsi]', $d[aktif])";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function hapus_data(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_aset_tipe set deletemark = 1 where id = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
?>