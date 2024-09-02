<?php
	include "../koneksi/koneksi.php";
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_detail(){
		$id		= $_POST['gid'];
		$query	= mysql_query("select td.tindakan_id, td.permintaan_id, td.petugas_id, td.jenis_id, td.aset_id, td.tindakan, td.tanggal, td.time, td.status_id, td.status_aset, pg.nama, aset.nm_aset
								from ipl_tindakan td
								LEFT JOIN ipl_pengguna pg on pg.pegawai_id = td.petugas_id
								left join ipl_permintaan pm on pm.permintaan_id = td.permintaan_id
								left join ipl_aset aset on aset.aset_id = pm.aset_id or aset.aset_id = td.aset_id
								where td.tindakan_id = $id");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function get_dtl_aset(){
		$aset_id = $_POST['gid_aset'];
		$query = mysql_query("select * from ipl_aset where aset_id = $aset_id");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function get_data_permintaan_perbaikan(){
		include "../koneksi/koneksi.php";
		session_start();
		$where = '';
		if($_GET['type'] == 'aset'){
			$where .= " AND ma.aset_id = $_GET[gid]";
		}else{
			$where .= " AND tp.ruangan_id = $_GET[gid]";
		}
		
		$no = 1;
		$ret['data'] = array();
		$query = "SELECT 
					tp.permintaan_id,
					mr.nama,
					mp.nama pelapor,
					ma.aset_id,
					ma.nm_aset,
					tp.permintaan,
					DATE_FORMAT(tp.tanggal_permintaan, '%Y-%m-%d') tanggal_permintaan,
					ms.jenis_id,
					ms.status_id,
					ms.nm_status
				FROM ipl_permintaan tp
				LEFT JOIN unit mr ON mr.id_unit = tp.ruangan_id AND mr.aktif = 1
				LEFT JOIN ipl_aset ma ON ma.aset_id = tp.aset_id AND ma.delete_mark = 0
				LEFT JOIN ipl_status ms ON ms.status_id = tp.status_id AND ms.delete_mark = 0
				LEFT JOIN ipl_pengguna mp ON mp.pegawai_id = tp.pelapor
				WHERE tp.delete_mark = 0 $where
				order by tp.tanggal_permintaan desc";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			if($data['status_id'] == 10){
				$style = 'background-color:#d2322d;';
			}else if($data['status_id'] == 11){
				$style = 'background-color:#ffed8b; color:#8a6d3b';
			}else if($data['status_id'] == 12){
				$style = 'background-color:#0088cc;';
			}else if($data['status_id'] == 13){
				$style = 'background-color:#313131;';
			}else{
				$style = 'background-color:#ebebeb; color:#606060';
			}
			$ret['data'][] = array(
								'no'			=> $no,
								'ruangan'		=> $data['nama'],
								'pelapor'		=> $data['pelapor'],
								'barang'		=> $data['nm_aset'],
								'permintaan'	=> $data['permintaan'],
								'tgl_permintaan'=> $data['tanggal_permintaan'],
								'status'		=> "<span class='label' style='$style'>$data[nm_status]</span>",
								'permintaan_id'	=> $data['permintaan_id'],
								'jenis_id'		=> $data['jenis_id'],
								'aset_id'		=> $data['aset_id']
							);
			$no++;
		}
		echo json_encode($ret);
	}
	
	function login(){
		session_start();
		include "../koneksi/koneksi_sdm.php";
		$username = preg_replace("/[^0-9]/", "",$_POST['username']);
		$password = md5(sha1($_POST['password']));
		//$query 	= "SELECT * FROM pegawai WHERE (REPLACE(REPLACE(nip, '.',''),'-','')='$username' or REPLACE(REPLACE(no_hp, '.',''),'-','')='$username') AND password='$password' AND aktif ='1'";
		$query 	= "SELECT * FROM pegawai WHERE (REPLACE(REPLACE(REPLACE(NIP, '.',''),'-',''),' ','') = '$username' or REPLACE(REPLACE(HP, '.',''),'-','') = '$username') AND password='$password' AND AKTIF ='1'";
		$hasil 	= mysql_query($query);
		$data 	= mysql_fetch_array($hasil);
		// cek kesesuaian password
		if ($password == $data['PASSWORD']){
			$role = get_role($data['PEGAWAI_ID']);
			//print_r($data);exit;
			$_SESSION['simrsig']		= $data['PEGAWAI_ID'];
			$_SESSION['id_pengguna']	= $role['id'];
			$_SESSION['username']		= $data['USERNAME'];
			//$_SESSION['password'] 		= $data['password'];
			$_SESSION['nama'] 			= $data['NAMA'];
			//$_SESSION['unit'] 			= $data['unit_id'];
			$_SESSION['ruangan'] 		= $role['ruangan_id'];
			$_SESSION['group'] 			= $role['role_id'];
			if($role['role_id'] == 2){
				echo 1;
			}else{
				echo 2;
			}
		}else{
			echo 0;
		}
	}
	
	function get_role($id_pegawai){
		include "../koneksi/koneksi.php";
		$query2 = "select * from ipl_pengguna where pegawai_id = $id_pegawai and aktif = 1 and deletemark = 0";
		$hasil2 = mysql_query($query2);
		$data 	= mysql_fetch_array($hasil2);
		return $data;
	}
	
	function change_status(){
		session_start();
		$status_id = $_POST['gid_status'];
		$id = $_POST['gid'];
		$q = "update ipl_permintaan set
				status_id	= $status_id
			where permintaan_id = $id";
		if(mysql_query($q)){
			$qq = "insert into ipl_status_permintaan(permintaan_id, status_id, petugas_id)
												value($id, $status_id, $_SESSION[simrsig])";
			echo mysql_query($qq) or die(mysql_error());
		}else{
			echo die(mysql_error());
		}
	}
	
	function get_data_tindakan_rutin(){
		session_start();
		$tbl = $where = '';
		
		if($_GET['type'] == 'aset'){
			$where = "aset.aset_id = $_GET[gid]";
		}else{
			$where = "aset.ruangan_id = $_GET[gid]";
		}
		
		$no = 1;
		$ret['data'] = array();
		$query = "SELECT tdk.tindakan_id, 
					tdk.petugas_id, 
					pgw.nama,
					tdk.tindakan, 
					tdk.tanggal
				FROM ipl_tindakan tdk
				LEFT JOIN ipl_pengguna pgw ON pgw.pegawai_id = tdk.petugas_id
				left join ipl_aset aset on aset.aset_id = tdk.aset_id
				WHERE tdk.delete_mark = 0
				AND tdk.jenis_id = 1
				AND $where
				order by tdk.petugas_id desc";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			$ret['data'][] = array(
								'no'			=> $no,
								'tindakan'		=> $data['tindakan'],
								'tindakan_id'	=> $data['tindakan_id'],
								'petugas'		=> $data['nama'],
								'tanggal'		=> $data['tanggal'],
								'aksi'			=> "<a href='#'>
														<button type='button' class='btn btn-danger btn-xs' onclick='hapus_data($data[tindakan_id], $_GET[gid])'>
															<i class='fa fa-trash-o'></i>
														</button>
													</a>"
							);
			$no++;
		}
		echo json_encode($ret);
	}
	
	function save_tindakan_rutin(){
		session_start();
		$data	= $_POST;
		$query = "insert into ipl_tindakan(aset_id, petugas_id, tindakan, tanggal, time, status_id, jenis_id)
									value($data[aset_id], $data[petugas_id], '$data[tindakan]', '$data[tanggal]', '$data[time]', $data[status_aset], 1)";
		if(mysql_query($query)){
			$q = "update ipl_aset set
					status_id = $data[status_aset]
				where aset_id = $data[aset_id]";
			echo mysql_query($q) or die(mysql_error());
		}else{
			echo die(mysql_error());
		}
	}
	
	function update_tindakan(){
		$id		 	= $_POST['gid'];
		$tanggal 	= $_POST['gtgl'];
		$time 		= $_POST['gtim'];
		$tindakan 	= $_POST['gtdk'];
		$status 	= $_POST['gsts'];
		$aset_id 	= $_POST['gast'];
		
		$q = "update ipl_tindakan set
				tindakan			= '$tindakan',
				tanggal 			= '$tanggal',
				time 				= '$time',
				status_id 		= $status
			where tindakan_id = $id";
		if(mysql_query($q)){
			$qq = "update ipl_aset set
					status_id = $status
				where aset_id = $aset_id";
			echo mysql_query($qq) or die(mysql_error());
		}else{
			echo die(mysql_error());
		}
	}
	
	function hapus_data_tindakan(){
		$id = $_POST['gid'];
		$query = "update ipl_tindakan set delete_mark = 1 where tindakan_id = $id";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function get_data_server(){
		//$id = $_POST['gid_aset'];
		$no = 1;
		$ret['data'] = array();
		$query = "SELECT 
					svr.id,
					svr.tanggal, 
					svr.suhu,
					svr.kelembapan,
					svr.petugas,
					pgw.nama
				FROM server_temperatur svr
				LEFT JOIN ipl_pengguna pgw ON pgw.pegawai_id = svr.petugas
				WHERE svr.deletemark = 0
				order by svr.id desc";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			$ret['data'][] = array(
								'no'			=> $no,
								'tanggal'		=> $data['tanggal'],
								'suhu'			=> $data['suhu'].'C',
								'kelembapan'	=> $data['kelembapan'].'%',
								'petugas'		=> $data['nama'],
								'tindakan_id'	=> $data['id']
							);
			$no++;
		}
		echo json_encode($ret);
	}
	
	function save_tindakan_server(){
		session_start();
		$data	= $_POST;
		$q = mysql_query("select count(id) jml from server_temperatur where tanggal = '$data[tanggal]' and deletemark = 0");
		$cek = mysql_fetch_array($q);
		if($cek['jml'] == 0){
			$query = "insert into server_temperatur(tanggal, jam, suhu, kelembapan, petugas)
									value('$data[tanggal]', '$data[time]', $data[suhu], $data[kelembapan], $data[petugas_id])";
			echo mysql_query($query) or die(mysql_error());
		}else{
			echo 2;
		}
	}
	
	function get_detail_server(){
		$id		= $_POST['gid'];
		$query	= mysql_query("select td.id, td.tanggal, td.jam, td.suhu, td.kelembapan, td.petugas, pg.nama
								from server_temperatur td
								LEFT JOIN ipl_pengguna pg on pg.pegawai_id = td.petugas
								where td.id = $id");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function update_tindakan_server(){
		session_start();
		$id		 	= $_POST['gid'];
		$tanggal 	= $_POST['gtgl'];
		$time 		= $_POST['gtim'];
		$suhu 		= $_POST['gtep'];
		$kelembapan	= $_POST['gkel'];
		//$petugas	= $_POST['gptg'];
		$petugas	= $_SESSION['simrsig'];
		
		$q = "update server_temperatur set
				suhu				= $suhu,
				kelembapan			= $kelembapan,
				tanggal 			= '$tanggal',
				jam 				= '$time',
				petugas				= $petugas
			where id = $id";
		echo mysql_query($q) or die(mysql_error());
	}
	
	function get_list_permintaan(){
		session_start();
		$pj = $_SESSION['ruangan'] == 51 ? 1 : 2;
		$status = $_GET['id'];
		$where = $status == 'all' ? '' : ' and pt.status_id = '.$status;
		$ret['data'] = array();
		$query = mysql_query("SELECT pt.permintaan_id, pt.permintaan, DATE_FORMAT(pt.tanggal_permintaan, '%Y-%m-%d') tanggal_permintaan, pt.aset_id, st.status_id, st.nm_status
								FROM ipl_permintaan pt 
								LEFT JOIN ipl_status st ON st.status_id = pt.status_id
								LEFT JOIN ipl_aset ia ON ia.aset_id = pt.aset_id
								WHERE pt.delete_mark = 0 and ia.unit_pj = $pj $where
								ORDER BY pt.tanggal_permintaan DESC");
		while($data = mysql_fetch_array($query)){
			if($data['status_id'] == 10){
				$style = 'background-color:#d2322d;';
			}else if($data['status_id'] == 11){
				$style = 'background-color:#ffed8b; color:#8a6d3b';
			}else if($data['status_id'] == 12){
				$style = 'background-color:#0088cc;';
			}else if($data['status_id'] == 13){
				$style = 'background-color:#313131;';
			}else{
				$style = 'background-color:#ebebeb; color:#606060';
			}
			$ret['data'][] = array(
								'permintaan'	=> $data['permintaan'],
								'tgl_permintaan'=> $data['tanggal_permintaan'],
								'aset_id'		=> $data['aset_id'],
								'permintaan_id'	=> $data['permintaan_id'],
								'status'		=> "<span class='label' style='$style'>$data[nm_status]</span>"
							);
		}
		echo json_encode($ret);
	}
	
	function tindaklanjuti(){
		$id 	= $_POST['gid'];
		$token	= base64_encode(base64_encode($id.'___aset'));
		$link	= "https://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/scan_qrcode.php?gid=$token";
		//header("location:scan_qrcode.php?gid=$token");
		echo $link;
	}
	
	function get_data_peminjaman_aset(){
		session_start();
		$ret['data'] = array();
		$org = " and pm.pegawai_id = $_SESSION[simrsig]";
		if($_GET['type'] == 'aset'){
			$ruang_aset = cek_ruangan_aset($_GET['gid']);
			if($ruang_aset['ruangan_id'] == $_SESSION['ruangan']){
				$org = '';
			}
			$where = " and aset.aset_id = $_GET[gid]";
		}else{
			if($_SESSION['ruangan'] == $_GET['gid']){
				$org = '';
			}
			$where = " and aset.`ruangan_id` = $_GET[gid]";
		}
		$qy = "SELECT 
					pm.id,
					pg.pegawai_id,
					pg.`nama`,
					pm.`tgl_pinjam`,
					pm.`jam_pinjam`,
					pm.`tgl_kembali`,
					pm.`jam_kembali`,
					pm.`status`
				FROM ipl_peminjaman_aset pm
				LEFT JOIN ipl_pengguna pg ON pg.`pegawai_id` = pm.`pegawai_id`
				LEFT JOIN ipl_aset aset ON aset.`aset_id` = pm.`aset_id`
				WHERE pm.deletemark = 0 $org $where";
		$sql = mysql_query($qy);
		while($data = mysql_fetch_array($sql)){
			if($data['status'] == 1){
				$status = "<span class='label label-info'>Menunggu Konfirmasi</span>";
			}else if($data['status'] == 3){
				$status = "<span class='label label-warning'>Sedang dipinjam</span>";
			}else if($data['status'] == 4){
				$status = "<span class='label label-dark'>Peminjaman ditolak</span>";
			}else if($data['status'] == 2){
				$status = "<span class='label label-success'>dikembalikan</span>";
			}else if($data['status'] == 5){
				$status = "<span class='label label-primary'>Menunggu Konfirmasi</span>";
			}else{
				$status = "<span class='label label-primary'>-</span>";
			}
			$ret['data'][] = array(
								'id'		=> $data['id'],
								'nama'		=> $data['nama'],
								'tanggal'	=> $data['tgl_pinjam'],
								'status'	=> $status
							);
		}
		echo json_encode($ret);
	}
	
	function add_pinjaman(){
		$data = $_POST;
		//print_r($data);
		$query = "insert into ipl_peminjaman_aset(aset_id, pegawai_id, konfirmasi_id, tgl_pinjam, jam_pinjam)
									value($data[g_aset_add], $data[g_pelapor], $data[g_konfirmasi], '$data[g_tanggal]', '$data[g_time]')";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function cek_aset(){
		session_start();
		$p_id	= $_SESSION['simrsig'];
		$id		= $_POST['aset_id'];
		$query	= mysql_query("select count(id) jml from ipl_peminjaman_aset where aset_id = $id and pegawai_id = $p_id and tgl_kembali is null and status <> 4 and deletemark = 0");
		$data 	= mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function get_detail_peminjaman(){
		$qy = "select status from ipl_peminjaman_aset where id = $_POST[gid]";
		$sql = mysql_query($qy);
		$jml 	= mysql_fetch_array($sql);
		if($jml['status'] == 1 || $jml['status'] == 3 ||  $jml['status'] == 5){
			$sts = 'not';
		}else{
			$sts = 'done';
		}
		$query	= mysql_query("SELECT '$sts' sts, pm.*, aset.`ruangan_id`
								FROM ipl_peminjaman_aset pm
								LEFT JOIN ipl_aset aset ON aset.`aset_id` = pm.`aset_id`
								WHERE pm.id = $_POST[gid]");
		$data 	= mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function kembalikan_pinjaman(){
		$data = $_POST;
		/*$q = "update ipl_peminjaman_aset set
				status				= 5,
				tgl_kembali			= '$data[g_tanggal]',
				jam_kembali			= '$data[g_time]'
			where id = $data[id_action]";*/
		$q = "update ipl_peminjaman_aset set
				status					= 5,
				konfirmasi_id_kembali	= $data[g_konfirmasi]
			where id = $data[id_action]";
		//echo $q;exit;
		echo mysql_query($q) or die(mysql_error());
	}
	
	function get_konfirmasi(){
		$result = "<option></option>";
		$query = mysql_query("select pegawai_id, nama from ipl_pengguna where deletemark = 0 and aktif = 1 and ruangan_id = $_POST[gu]");
		while($data = mysql_fetch_array($query)){
			$result .= "<option value='$data[pegawai_id]'>$data[nama]</option>";
		}
		echo $result;
		//echo json_encode($result);
	}
	
	function get_data_peminjaman_konfirmasi(){
		session_start();
		$ret['data'] = array();
		$qy = "SELECT 
					pm.id,
					pg.pegawai_id,
					pg.`nama`,
					aset.nm_aset,
					pm.`tgl_pinjam`,
					pm.`jam_pinjam`,
					pm.`tgl_kembali`,
					pm.`jam_kembali`,
					pm.`status`
				FROM ipl_peminjaman_aset pm
				LEFT JOIN ipl_pengguna pg ON pg.`pegawai_id` = pm.`pegawai_id`
				LEFT JOIN ipl_aset aset ON aset.`aset_id` = pm.`aset_id`
				WHERE pm.deletemark = 0 and pm.status in (1,5) and (pm.konfirmasi_id = $_SESSION[simrsig] or pm.konfirmasi_id_kembali = $_SESSION[simrsig])";
		$sql = mysql_query($qy);
		while($data = mysql_fetch_array($sql)){
			if($data['status'] == 1){
				$status = "<span class='label label-info'>Menunggu Konfirmasi</span>";
			}else if($data['status'] == 3){
				$status = "<span class='label label-warning'>Sedang dipinjam</span>";
			}else if($data['status'] == 4){
				$status = "<span class='label label-dark'>Peminjaman ditolak</span>";
			}else if($data['status'] == 5){
				$status = "<span class='label label-primary'>Menunggu Konfirmasi</span>";
			}else if($data['status'] == 2){
				$status = "<span class='label label-success'>dikembalikan</span>";
			}else{
				$status = "<span class='label label-primary'>-</span>";
			}
			$ret['data'][] = array(
								'id'		=> $data['id'],
								'nama'		=> $data['nama'],
								'aset'		=> $data['nm_aset'],
								'tanggal'	=> $data['tgl_pinjam'],
								'status'	=> $status
							);
		}
		echo json_encode($ret);
	}
	
	function konfirmasi_peminjaman(){
		$clm = $_POST['gsts'] == 2 ? 'kembali' : 'konfirmasi';
		$query = "update ipl_peminjaman_aset set status = $_POST[gsts], tgl_$clm = '$_POST[gtgl]', jam_$clm = '$_POST[gwkt]' where id = $_POST[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function cek_ruangan_peg(){
		$id = $_POST['gid'];
		$query = "select ruangan_id from ipl_pengguna where pegawai_id = $id";
		$sql = mysql_query($query);
		$data = mysql_fetch_array($sql);
		echo json_encode($data);
	}
	
	function cek_ruangan_aset($aset_id){
		$query = "select ruangan_id from ipl_aset where aset_id = $aset_id";
		$sql = mysql_query($query);
		$data = mysql_fetch_array($sql);
		return $data;
	}
	
	function edit_pinjaman(){
		$post = $_POST;
		$konfirm = $post['gbalik'] == 1 ? 'konfirmasi_id_kembali' : 'konfirmasi_id';
		$query = "update ipl_peminjaman_aset set $konfirm = $_POST[gkonfirm], tgl_pinjam = '$_POST[gtgl]', jam_pinjam = '$_POST[gtime]' where id = $_POST[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function saverating(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_permintaan set rating = $_POST[grating], ulasan = '$_POST[gulasan]' where permintaan_id = $_POST[gid]";
		if(mysql_query($query)){
			$ret = array(
				'sts' => 1,
				'msg' => 'Berhasil menyimpan data'
			);
		}else{
			$ret = array(
				'sts' => 0,
				'msg' => mysql_error()
			);
		}
		
		echo json_encode($ret);
	}
	
	function save_feedback(){
		include "../koneksi/koneksi.php";
		$status = $_POST['val'] == 1 ? 12 : 11;
		$query = "update ipl_permintaan set status_id = $status where permintaan_id = $_POST[id]";
		if(mysql_query($query)){
			$ret = log_status($_POST);
			send_wa_change_status($_POST);
		}else{
			$ret = array(
				'sts' => 0,
				'msg' => mysql_error()
			);
		}
		echo json_encode($ret);
	}
	
	function send_wa_change_status($par){
		$query = "SELECT un.nama nm_ruangan, ia.nm_aset, ia.aset_id, ia.unit_pj, pg.nama nm_pelapor, ip.permintaan, ip.tanggal_permintaan, ip.jumlah, ip.lokasi
					FROM ipl_permintaan ip
					LEFT JOIN unit un ON un.id_unit = ip.ruangan_id
					LEFT JOIN ipl_aset ia ON ia.aset_id = ip.aset_id
					LEFT JOIN ipl_pengguna pg ON pg.pegawai_id = ip.pelapor
					WHERE ip.permintaan_id = $par[id]";
		$sql = mysql_query($query);
		$data = mysql_fetch_array($sql);
		$filter_token	= base64_encode(base64_encode($data['aset_id'].'___aset'));
		
		//$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/scan_qrcode_list.php";
		//$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode";
		$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/scan_qrcode.php?gid=$filter_token";
		//$teks_qrcode	= "http://rsmn.it-rs.id/it/scan_qrcode/scan_qrcode.php?gid=$filter_token/";
if($par['val'] == 1){
	$sts = "
Perbaikan sudah dikonfirmasi oleh user dengan status *Sudah Selesai*
Status Permintaan perbaikan akan di ubah menjadi *Selesai*";
}else{
	$sts = "
Perbaikan sudah dikonfirmasi oleh user dengan status *Belum Selesai*
Status Permintaan perbaikan akan di ubah menjadi *Sedang diproses*";
}

$text = "$sts
Pelapor : *$data[nm_pelapor]*
Ruangan : $data[nm_ruangan]
Barang : $data[nm_aset]
Kerusakan : $data[permintaan]
Waktu : $data[tanggal_permintaan]
Jumlah : $data[jumlah]
Lokasi : $data[lokasi]


Silahkan klik link dibawah untuk menindak lanjuti

$teks_qrcode
";
		
		$ruangan_id = $data['unit_pj'] == 1 ? 51 : 53;
		$qy2 = "select pegawai_id from ipl_pengguna where ruangan_id = $ruangan_id AND deletemark = 0";
		$sql2 = mysql_query($qy2);
		$res = array();
		while($row = mysql_fetch_array($sql2)){
			include "../koneksi/koneksi_sdm.php";
			$qy3 = mysql_query("select HP from pegawai where PEGAWAI_ID = $row[pegawai_id]");
			$row3 = mysql_fetch_assoc($qy3);
			if($row3['HP']){
				$curl = curl_init();

				curl_setopt_array($curl, array(
					CURLOPT_URL => 'http://192.168.0.237:4567/pesan/teks',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => json_encode(array("nomor"=>"$row3[HP]", "pesan"=>"$text")),
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json'
					),
				));

				$response = curl_exec($curl);

				curl_close($curl);
				$res[]= $response;
			}
		}
		//if($data['ruangan_id'] != 51){
		send_wa_teknisi_change_status($par);
		//}
		return $res;
	}
	
	function send_wa_teknisi_change_status($par){
		include "../koneksi/koneksi.php";
		$query = "SELECT un.nama nm_ruangan, ia.nm_aset, ia.aset_id, ia.unit_pj, pg.nama nm_pelapor, ip.permintaan, ip.tanggal_permintaan, ip.jumlah, ip.lokasi, pg2.nama nm_teknisi, mis.nm_status
					FROM ipl_permintaan ip
					LEFT JOIN unit un ON un.id_unit = ip.ruangan_id
					LEFT JOIN ipl_aset ia ON ia.aset_id = ip.aset_id
					LEFT JOIN ipl_pengguna pg ON pg.pegawai_id = ip.pelapor
					LEFT JOIN (
						SELECT status_id, create_by, permintaan_id
						FROM ipl_log_sts_permintaan 
						WHERE permintaan_id = $par[id]
						ORDER BY id DESC LIMIT 1
					) tblog ON tblog.permintaan_id = ip.permintaan_id
					LEFT JOIN ipl_pengguna pg2 ON pg2.pegawai_id = tblog.create_by
					LEFT JOIN ipl_status mis ON mis.status_id = tblog.status_id
					WHERE ip.permintaan_id = $par[id]";
		//echo $query;exit;
		$sql = mysql_query($query);
		$data = mysql_fetch_array($sql);
		$filter_token	= base64_encode(base64_encode($data['aset_id'].'___aset'));
		
		//$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/scan_qrcode_list.php";
		//$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode";
		$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/scan_qrcode.php?gid=$filter_token";
		//$teks_qrcode	= "http://rsmn.it-rs.id/it/scan_qrcode/scan_qrcode.php?gid=$filter_token/";
$text = "Perubahan Status Perbaikan

Pelapor : *$data[nm_pelapor]*
Ruangan : $data[nm_ruangan]
Barang : $data[nm_aset]
Kerusakan : $data[permintaan]
Waktu : $data[tanggal_permintaan]
Jumlah : $data[jumlah]
Lokasi : $data[lokasi]

sudah di ubah status ke *$data[nm_status]*
oleh teknisi *$data[nm_teknisi]*

Silahkan klik link dibawah untuk melihat detail permintaan

$teks_qrcode
";
		
		$ruangan_id = $data['unit_pj'] == 1 ? 51 : 53;
		$qy2 = "select pegawai_id from ipl_pengguna where ruangan_id = $ruangan_id AND deletemark = 0";
		$sql2 = mysql_query($qy2);
		$res = array();
		while($row = mysql_fetch_array($sql2)){
			include "../koneksi/koneksi_sdm.php";
			$qy3 = mysql_query("select HP from pegawai where PEGAWAI_ID = $row[pegawai_id]");
			$row3 = mysql_fetch_assoc($qy3);
			if($row3['HP']){
				$curl = curl_init();

				curl_setopt_array($curl, array(
					CURLOPT_URL => 'http://192.168.0.237:4567/pesan/teks',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => json_encode(array("nomor"=>"$row3[HP]", "pesan"=>"$text")),
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json'
					),
				));

				$response = curl_exec($curl);

				curl_close($curl);
				$res[]= $response;
			}
		}
		return $res;
	}
	
	function log_status($data){
		include "../koneksi/koneksi.php";
		session_start();
		$ket = isset($data['ket']) ? $data['ket'] : '';
		$query = "insert into ipl_log_sts_permintaan(permintaan_id, status_id, ket, create_by)
												value($data[id], $data[val], '$ket', '$_SESSION[simrsig]')";
		if(mysql_query($query)){
			$ret = array(
				'sts' => 1,
				'msg' => 'Berhasil mengubah data'
			);
		}else{
			$ret = array(
				'sts' => 0,
				'msg' => mysql_error()
			);
		}
		return $ret;
	}
	
	function save_no_hp(){
		session_start();
		include "../koneksi/koneksi_sdm.php";
		$query = "update pegawai set HP = '$_POST[nohp]' where PEGAWAI_ID = $_SESSION[simrsig]";
		if(mysql_query($query)){
			$ret = array(
				'sts' => 1,
				'msg' => 'Berhasil menyimpan data'
			);
		}else{
			$ret = array(
				'sts' => 0,
				'msg' => mysql_error()
			);
		}
		echo json_encode($ret);
	}
	
	function get_data_pegawai(){
		session_start();
		include "../koneksi/koneksi_sdm.php";
		$query = "select * from pegawai where PEGAWAI_ID = $_SESSION[simrsig]";
		$sql = mysql_query($query);
		$data = mysql_fetch_array($sql);
		echo json_encode($data);
	}
	
	function update_password(){
		session_start();
		include "../koneksi/koneksi_sdm.php";
		$spass = md5(sha1($_POST['gpass_old']));
		$npass = md5(sha1($_POST['gpass_new']));
		$kpass = md5(sha1($_POST['gpass_kon']));
		if($npass === $kpass){
			$qcek = mysql_fetch_array(mysql_query("select count(PEGAWAI_ID) jml from pegawai where PEGAWAI_ID = $_SESSION[simrsig] and PASSWORD = '$spass'"));
			if($qcek['jml'] > 0){
				$query = "update pegawai set PASSWORD = '$npass' where PEGAWAI_ID = $_SESSION[simrsig]";
				if(mysql_query($query)){
					$ret = array(
						'sts' => 1,
						'msg' => 'Berhasil menyimpan data'
					);
				}else{
					$ret = array(
						'sts' => 0,
						'msg' => mysql_error()
					);
				}
			}else{
				$ret = array(
					'sts' => 0,
					'msg' => 'Password lama anda tidak sesuai'
				);
			}
		}else{
			$ret = array(
				'sts' => 0,
				'msg' => 'Password baru tidak sesuai dengan konfirmasi'
			);
		}
		echo json_encode($ret);
	}
	
	function get_list_aset(){
		include "../koneksi/koneksi.php";
		session_start();
		$pj = $_SESSION['ruangan'] == 51 ? 1 : 2;
		
		$no = 1;
		$ret['data'] = array();
		$query = "SELECT ia.aset_id, ia.nm_aset, ia.merk_aset, ia.tipe, ia.status_id, t_is.nm_status
					FROM ipl_aset ia
					LEFT JOIN ipl_status t_is ON t_is.status_id = ia.status_id AND t_is.jenis_id = 1
					WHERE ia.delete_mark = 0 and ia.ruangan_id = $_GET[gid]
					AND ia.unit_pj = $pj
					ORDER BY ia.create_date";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			if($data['status_id'] == 1){
				$style = 'background-color:#0088cc;';
			}else if($data['status_id'] == 2){
				$style = 'background-color:#ffed8b; color:#8a6d3b';
			}else if($data['status_id'] == 3){
				$style = 'background-color:#d2322d;';
			}else if($data['status_id'] == 4){
				$style = 'background-color:#313131;';
			}else{
				$style = 'background-color:#ebebeb;';
			}
			$ret['data'][] = array(
								'no'		=> $no,
								'nama'		=> $data['nm_aset'],
								'merk'		=> $data['merk_aset'],
								'tipe'		=> $data['tipe'],
								'status'	=> "<span class='label' style='$style'>$data[nm_status]</span>",
								'aset_id'	=> $data['aset_id']
							);
			$no++;
		}
		echo json_encode($ret);
	}
	
	function get_data_checklist_vr(){
		session_start();
		$tanggal = $_POST['tanggal'];
		$q_cek = "	select * from ipl_5r_input where tanggal = '$tanggal'";
		$sql_c = mysql_query($q_cek);
		$query = "	select  r.id,
							r.perihal,
							m.id vr_id,
							m.nama vr_nm,
							m.color
					from ipl_5r_ruangan r 
					left join ipl_5r m on m.id = r.vr_id
					where r.unit_id = $_SESSION[ruangan] 
					and r.deletemark = 0 
					and r.aktif = 1";
		$sql = mysql_query($query);
		if(mysql_num_rows($sql_c) == 0){
			while($ck = mysql_fetch_array($sql)){
				echo "	<li>
						<div class='checkbox-custom checkbox-default'>
							<input type='checkbox' id='$ck[id]' class='todo-check' onchange='change_cekbox(this, $ck[id])'>
							<label class='todo-label' for='$ck[id]'><span>$ck[perihal]</span></label>
						</div>
						<div class='todo-actions'>
							<span class='label' style='background-color:\"$ck[bg_color]\", color:\"$ck[color]\"'>$ck[vr_nm]</span>
						</div>
					</li>";
			}
		}else{
			$a_vr_id = array();
			$dt_c = array();
			while($dt = mysql_fetch_array($sql_c)){
				$a_vr_id[] = $dt['m_vr_id'];
				$dt_c[$dt['m_vr_id']] = $dt;
			}
			while($ck = mysql_fetch_array($sql)){
				if(in_array($ck['id'],$a_vr_id)){
					$checked = $dt_c[$ck['id']]['status'] == 1 ? 'checked' : '';
				}
				echo "	<li>
						<div class='checkbox-custom checkbox-default'>
							<input type='checkbox' $checked id='$ck[id]' class='todo-check'>
							<label class='todo-label' for='$ck[id]'><span>$ck[perihal]</span></label>
						</div>
						<div class='todo-actions'>
							<span class='label' style='background-color:$ck[color];'>$ck[vr_nm]</span>
						</div>
					</li>";
			}
		}
	}
	
	function change_cekbox(){
		session_start();
		$status = $_POST['cb'] == 'true' ? 1 : 0;
		$vr_id 	= $_POST['id'];
		$tgl 	= $_POST['tgl'];
		
		$q_cek = "select * from ipl_5r_input where m_vr_id = $vr_id and tanggal = '$tgl' and deletemark = 0";
		$s_cek = mysql_query($q_cek);
		if(mysql_num_rows($s_cek) == 0){
			$q_ins = "insert into ipl_5r_input(m_vr_id, status, tanggal, createby)
										value($vr_id, $status, '$tgl', $_SESSION[simrsig])";
			echo mysql_query($q_ins) or die(mysql_error());
		}else{
			$q_upd = "update ipl_5r_input set status = $status, updateby = $_SESSION[simrsig], updatedate = CURRENT_TIMESTAMP where m_vr_id = $vr_id and tanggal = '$tgl'";
			echo mysql_query($q_upd) or die(mysql_error());
		}
	}
?>