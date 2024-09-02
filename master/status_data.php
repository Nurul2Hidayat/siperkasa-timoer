<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		include "../koneksi/koneksi.php";
		$tbl = '';
		$no = 1;
		$query = "select 
					ms.status_id, 
					ms.nm_status, 
					ms.deskripsi,
					ms.aktif,
					mj.jenis_id,
					mj.nm_jenis
				from ipl_status ms
				left join ipl_jenis mj on mj.jenis_id = ms.jenis_id and mj.delete_mark = 0
				where ms.delete_mark = 0";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			$aktif = $data['aktif'] == 1 ? 'Aktif' : 'Tidak Aktif';
			$tbl .= "<tr>";
			$tbl .= "<td>$no</td>";
			$tbl .= "<td>$data[nm_jenis]</td>";
			$tbl .= "<td>$data[nm_status]</td>";
			$tbl .= "<td>$data[deskripsi]</td>";
			$tbl .= "<td>$aktif</td>";
			$tbl .= "<td>
						<a href='#'>
							<button type='button' class='btn btn-success btn-xs' onclick='edit_data($data[status_id], $data[jenis_id])'>
								<i class='fa fa-pencil'></i>
							</button>
						</a>
						<a href='#'>
							<button type='button' class='btn btn-danger btn-xs' onclick='hapus_data($data[status_id])'>
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
		$query = mysql_query("select status_id, jenis_id, nm_status, deskripsi, aktif from ipl_status where status_id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function edit_data_proses(){
		session_start();
		include "../koneksi/koneksi.php";
		$upd_date 	= date('Y-m-d h:i:s');
		$upd_by		= $_SESSION['nama'];
		$jenis 		= $_POST['g_jenis'];
		$nama 		= $_POST['g_nama'];
		$id 		= $_POST['g_id'];
		$deskripsi	= $_POST['g_deskripsi'];
		$aktif	 	= $_POST['g_aktif'];
		
		$q = "update ipl_status set
				nm_status 			= '$nama',
				jenis_id 			= $jenis,
				deskripsi 			= '$deskripsi',
				aktif	 			= $aktif,
				update_date 		= '$upd_date',
				update_by 			= '$upd_by'
			where status_id = $id";
		echo mysql_query($q) or die(mysql_error());
	}
	
	function add_data(){
		session_start();
		include "../koneksi/koneksi.php";
		
		$d['ins_by']	= $_SESSION['nama'];
		$d['jenis']		= $_POST['g_jenis'];
		$d['nama'] 		= $_POST['g_nama'];
		$d['deskripsi']	= $_POST['g_deskripsi'];
		$d['aktif'] 	= $_POST['g_aktif'];
		
		$query = "insert into ipl_status(jenis_id, nm_status, deskripsi, aktif, create_by)
								value($d[jenis], '$d[nama]', '$d[deskripsi]', $d[aktif], '$d[ins_by]')";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function hapus_data(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_status set delete_mark = 1 where status_id = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
?>