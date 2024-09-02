<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		include "../koneksi/koneksi.php";
		$tbl = '';
		$no = 1;
		$query = "select 
					jenis_id, 
					nm_jenis, 
					deskripsi
				from ipl_jenis
				where delete_mark = 0";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			$tbl .= "<tr>";
			$tbl .= "<td>$no</td>";
			$tbl .= "<td>$data[nm_jenis]</td>";
			$tbl .= "<td>$data[deskripsi]</td>";
			$tbl .= "<td>
						<a href='#'>
							<button type='button' class='btn btn-success btn-xs' onclick='edit_data($data[jenis_id])'>
								<i class='fa fa-pencil'></i>
							</button>
						</a>
						<a href='#'>
							<button type='button' class='btn btn-danger btn-xs' onclick='hapus_data($data[jenis_id])'>
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
		$query = mysql_query("select jenis_id, nm_jenis, deskripsi from ipl_jenis where jenis_id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function edit_data_proses(){
		session_start();
		include "../koneksi/koneksi.php";
		$upd_date 	= date('Y-m-d h:i:s');
		$upd_by		= $_SESSION['nama'];
		$nama 		= $_POST['g_nama'];
		$id 		= $_POST['g_id'];
		$deskripsi	= $_POST['g_deskripsi'];
		
		$q = "update ipl_jenis set
				nm_jenis 			= '$nama',
				deskripsi 			= '$deskripsi',
				update_date 		= '$upd_date',
				update_by 			= '$upd_by'
			where jenis_id = $id";
		echo mysql_query($q) or die(mysql_error());
	}
	
	function add_data(){
		session_start();
		include "../koneksi/koneksi.php";
		
		$d['ins_by']	= $_SESSION['nama'];
		$d['nama'] 		= $_POST['g_nama'];
		$d['deskripsi'] = $_POST['g_deskripsi'];
		
		$query = "insert into ipl_jenis(nm_jenis, deskripsi, create_by)
								value('$d[nama]', '$d[deskripsi]', '$d[ins_by]')";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function hapus_data(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_jenis set delete_mark = 1 where jenis_id = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
?>