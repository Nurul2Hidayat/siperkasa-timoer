<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		include "../koneksi/koneksi.php";
		$tbl = '';
		$no = 1;
		$query = "select 
					mt.tipe_id, 
					mt.nm_tipe, 
					mj.jenis_id,
					mj.nm_jenis,
					mt.deskripsi,
					mt.aktif
				from ipl_tipe mt
				left join ipl_jenis mj on mj.jenis_id = mt.jenis_id and mj.delete_mark = 0
				where mt.delete_mark = 0";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			
			if($data['aktif'] == 1){
				$status = 'Aktif';
			}else{
				$status = 'Tidak Aktif';
			}
			
			$tbl .= "<tr>";
			$tbl .= "<td>$no</td>";
			$tbl .= "<td>$data[nm_jenis]</td>";
			$tbl .= "<td>$data[nm_tipe]</td>";
			$tbl .= "<td>$data[deskripsi]</td>";
			$tbl .= "<td>$status</td>";
			$tbl .= "<td>
						<a href='#'>
							<button type='button' class='btn btn-success btn-xs' onclick='edit_data($data[tipe_id])'>
								<i class='fa fa-pencil'></i>
							</button>
						</a>
						<a href='#'>
							<button type='button' class='btn btn-danger btn-xs' onclick='hapus_data($data[tipe_id])'>
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
		$query = mysql_query("select tipe_id, jenis_id, nm_tipe, deskripsi, aktif from ipl_tipe where tipe_id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function edit_data_proses(){
		session_start();
		include "../koneksi/koneksi.php";
		$upd_date 	= date('Y-m-d h:i:s');
		$upd_by		= $_SESSION['nama'];
		//$jenis 		= $_POST['g_jenis'];
		$jenis 		= 1;
		$nama 		= $_POST['g_nama'];
		$id 		= $_POST['g_id'];
		$deskripsi	= $_POST['g_deskripsi'];
		$aktif		= $_POST['g_aktif'];
		
		$q = "update ipl_tipe set
				jenis_id 			= $jenis,
				nm_tipe 			= '$nama',
				deskripsi 			= '$deskripsi',
				aktif 				= $aktif,
				update_date 		= '$upd_date',
				update_by 			= '$upd_by'
			where tipe_id = $id";
		echo mysql_query($q) or die(mysql_error());
	}
	
	function add_data(){
		session_start();
		include "../koneksi/koneksi.php";
		
		$d['ins_by']	= $_SESSION['nama'];
		//$d['jenis'] 	= $_POST['g_jenis'];
		$d['jenis'] 	= 1;
		$d['nama'] 		= $_POST['g_nama'];
		$d['deskripsi'] = $_POST['g_deskripsi'];
		$d['aktif']		= $_POST['g_aktif'];
		
		$query = "insert into ipl_tipe(jenis_id, nm_tipe, deskripsi, aktif, create_by)
								value($d[jenis], '$d[nama]', '$d[deskripsi]', $d[aktif], '$d[ins_by]')";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function hapus_data(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_tipe set delete_mark = 1 where tipe_id = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
?>