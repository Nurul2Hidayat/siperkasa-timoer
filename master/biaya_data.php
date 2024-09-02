<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		include "../koneksi/koneksi.php";
		$tbl = '';
		$no = 1;
		$query = "select 
					ma.aset_id, 
					ma.nm_aset,
					mb.biaya_id,
					mb.nominal,
					mb.start_date,
					mb.end_date
				from ipl_biaya mb
				left join ipl_aset ma on ma.aset_id = mb.aset_id and ma.delete_mark = 0
				where mb.delete_mark = 0";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			$tbl .= "<tr>";
			$tbl .= "<td>$no</td>";
			$tbl .= "<td>$data[nm_aset]</td>";
			$tbl .= "<td>$data[nominal]</td>";
			$tbl .= "<td>$data[start_date]</td>";
			$tbl .= "<td>$data[end_date]</td>";
			$tbl .= "<td>
						<a href='#'>
							<button type='button' class='btn btn-success btn-xs' onclick='edit_data($data[biaya_id])'>
								<i class='fa fa-pencil'></i>
							</button>
						</a>
						<a href='#'>
							<button type='button' class='btn btn-danger btn-xs' onclick='hapus_data($data[biaya_id])'>
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
		$query = mysql_query("select biaya_id, aset_id, nominal, start_date, end_date from ipl_biaya where biaya_id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function edit_data_proses(){
		session_start();
		include "../koneksi/koneksi.php";
		$upd_date 	= date('Y-m-d h:i:s');
		$upd_by		= $_SESSION['nama'];
		$id 		= $_POST['g_id'];
		$aset 		= $_POST['g_aset'];
		$nominal 	= $_POST['g_nominal'];
		$s_date 	= $_POST['g_tgl_mulai'];
		$e_date 	= $_POST['g_tgl_akhir'];
		
		$q = "update ipl_biaya set
				aset_id 			= $aset,
				nominal 			= $nominal,
				start_date 			= '$s_date',
				end_date 			= '$e_date',
				update_date 		= '$upd_date',
				update_by 			= '$upd_by'
			where biaya_id = $id";
		echo mysql_query($q) or die(mysql_error());
	}
	
	function add_data(){
		session_start();
		include "../koneksi/koneksi.php";
		
		$d['ins_by']	= $_SESSION['nama'];
		$d['aset'] 		= $_POST['g_aset'];
		$d['nominal']	= $_POST['g_nominal'];
		$d['s_date'] 	= $_POST['g_tgl_mulai'];
		$d['e_date']	= $_POST['g_tgl_akhir'];
		
		$query = "insert into ipl_biaya(aset_id, nominal, start_date, end_date, create_by)
								value($d[aset], '$d[nominal]', '$d[s_date]', $d[e_date], '$d[ins_by]')";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function hapus_data(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_biaya set delete_mark = 1 where biaya_id = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
?>