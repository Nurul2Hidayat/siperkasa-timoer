<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		include "../koneksi/koneksi.php";
		session_start();
		$tbl = '';
		$no = 1;
		$query = "select 
					r.id,
					r.perihal,
					m.nama jenis,
					r.aktif
				from ipl_5r_ruangan r
				left join ipl_5r m on r.vr_id = m.id
 				where r.deletemark = 0
				and r.unit_id = $_SESSION[ruangan]";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			$tbl .= "<tr>";
			$tbl .= "<td>$no</td>";
			$tbl .= "<td>$data[perihal]</td>";
			$tbl .= "<td>$data[jenis]</td>";
			$tbl .= $data['aktif'] == 1 ? '<td><span class="label" style="background-color:#47a447;">Aktif</span></td>' : '<td><span class="label" style="background-color:#d2322d;">Tidak</span></td>';
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
		$query = mysql_query("select * from ipl_5r_ruangan where id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function edit_data_proses(){
		session_start();
		include "../koneksi/koneksi.php";
		$upd_by		= $_SESSION['nama'];
		$nama 		= $_POST['g_nama'];
		$id 		= $_POST['g_id'];
		
		$q = "update ipl_5r_ruangan set
				perihal	= '$_POST[g_nama]',
				vr_id 	= $_POST[g_jenis],
				aktif 	= $_POST[g_aktif]
			where id = $id";
		echo mysql_query($q) or die(mysql_error());
	}
	
	function add_data(){
		session_start();
		//print_r($_SESSION);
		include "../koneksi/koneksi.php";
		
		$query = "insert into ipl_5r_ruangan(perihal, vr_id, unit_id, aktif, createby)
								value('$_POST[g_nama]', '$_POST[g_jenis]', $_SESSION[ruangan], $_POST[g_aktif], $_SESSION[id_pengguna])";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function hapus_data(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_5r_ruangan set deletemark = 1 where id = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function get_jenis(){
		include "../koneksi/koneksi.php";
		$query = mysql_query("select * from ipl_5r where deletemark = 0");
		$ret = "<option> - </option>";
		while($data = mysql_fetch_array($query)){
			$ret .= "<option value='$data[id]'>$data[nama]</option>";
		}
		echo $ret;
	}
	
	function get_jml(){
		include "../koneksi/koneksi.php";
	}
	
	function get_data_grafik(){
		include "../koneksi/koneksi.php";
		$ruangan = $_POST['fruangan'];
		$tgl_awl = $_POST['ftgl_awl'];
		$tgl_akr = $_POST['ftgl_akr'];
		$jnsdata = $_POST['fdt'];
		$tgl_akr_plus_one = date('Y-m-d', strtotime($tgl_akr . ' +1 day'));
		
		$period = 	new DatePeriod(
					new DateTime($tgl_awl),
					new DateInterval('P1D'),
					new DateTime($tgl_akr_plus_one)
		);
		
		$c_day = 0;
		
		foreach($period as $k=>$v){
			$date = date_format($v,"Y-m-d");
			$res['tanggal'][$k] = $date;
			$res[1][$k] = 0;
			$res[2][$k] = 0;
			$res[3][$k] = 0;
			$res[4][$k] = 0;
			$res[5][$k] = 0;
			$c_day++;
		}
		
		$q_ttl = "SELECT vr_id, COUNT(id) jml
					FROM ipl_5r_ruangan
					WHERE deletemark = 0
					GROUP BY vr_id";
		$s_ttl = mysql_query($q_ttl);
		$ttl = array(1=>0, 2=>0, 3=>0, 4=>0, 5=>0);
		while($dt = mysql_fetch_array($s_ttl)){
			$ttl[$dt['vr_id']] = $dt['jml'];
		}
		$query="SELECT i.tanggal, r.vr_id, COUNT(i.id) jml
				FROM ipl_5r_input i
				LEFT JOIN ipl_5r_ruangan r ON r.id = i.m_vr_id
				WHERE i.deletemark = 0
				AND i.tanggal BETWEEN '$tgl_awl' AND '$tgl_akr'
				AND i.status = 1
				GROUP BY i.tanggal, r.vr_id";
		//echo $query;exit;
		$sql = mysql_query($query);
		while($data = mysql_fetch_array($sql)){
			foreach($period as $k=>$v){
				$date = date_format($v,"Y-m-d");
				//echo $data['tanggal'] .'=='. $date.'<br>';
				if($data['tanggal'] == $date){
					$res['tanggal'][$k] = $date;
					$res[$data['vr_id']][$k] = ((int)$data['jml']/$ttl[$data['vr_id']])*100;
				}else{
					if(!isset($res['tanggal'][$k])){
						$res['tanggal'][$k] = $date;
						$res[$data['vr_id']][$k] = 0;
					}
				}
			}
		}
		if($jnsdata == 'lbl'){
			for($c=1; $c<=5; $c++){
				$jml = array_sum($res[$c]);
				$ret[$c] = $jml/$c_day;
			}
			echo json_encode($ret);
		}else{
			echo json_encode($res);
		}
	}
?>