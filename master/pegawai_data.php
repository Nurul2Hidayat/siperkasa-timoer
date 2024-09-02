<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data_pegawai($id = ''){
		include "../koneksi/koneksi_sdm.php";
		$ret = array();
		$where = $id == '' ? '' : ' where PEGAWAI_ID = '.$id;
		$query = mysql_query("select * from pegawai $where");
		//echo "select * from pegawai $where";exit;
		while($data = mysql_fetch_array($query)){
			$ret[] = $data;
		}
		return $ret;
	}
	
	function get_data(){
		$pegawai = get_data_pegawai();
		include "../koneksi/koneksi.php";
		$ret['data'] = array();
		$no = 1;
		$query = "select pg.id, pg.pegawai_id, pg.role_id, pg.ruangan_id, rg.nama nm_ruangan, pg.aktif 
					from ipl_pengguna pg
					left join unit rg on rg.id_unit = pg.ruangan_id
					where pg.deletemark = 0";
		//$query = "select pegawai_id, nama, nip, no_hp, jabatan, status_kepegawaian, aktif from pegawai where deletemark = 0 order by pegawai_id desc";
		//echo $query;
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			if($data['aktif'] == 1){
				$sts = "<span class='label label-success'>Aktif</span>";
			}else{
				$sts = "<span class='label label-danger'>Tidak Aktif</span>";
			}
			$dataf = array();
			foreach($pegawai as $k=>$v){
				if($v['PEGAWAI_ID'] == $data['pegawai_id']){
					$dataf = $v;
					break;
				}
			}
			$ret['data'][] = array(
								'no'			=> $no,
								'nama'			=> $dataf['GELAR_DPN'].$dataf['NAMA'].$dataf['GELAR_BLK'],
								'nip'			=> $dataf['NIP'],
								'no_hp'			=> $dataf['HP'],
								'ruangan'		=> $data['nm_ruangan'],
								'kepegawaian'	=> $dataf['STATUS_KEPEGAWAIAN'],
								'status'		=> $sts,
								'aksi'			=> "
													<a href='#'>
														<button type='button' class='btn btn-success btn-xs' onclick='edit_data($data[id], $data[pegawai_id])'>
															<i class='fa fa-pencil'></i>
														</button>
													</a>
													<a href='#'>
														<button type='button' class='btn btn-danger btn-xs' onclick='hapus_data($data[id])'>
															<i class='fa fa-trash-o'></i>
														</button>
													</a>
													"
							);
			$no++;
		}
		/*$sqlrn = mysql_query("select count(pegawai_id) rn from pegawai where deletemark = 0");
		$rown = mysql_fetch_array($sqlrn);
		$ret['draw'] = $_GET['draw'];
		$ret['recordsTotal'] = $rown['rn'];
		$ret['recordsFiltered'] = $rown['rn'];*/
		echo json_encode($ret);
	}
	
	function add_data(){
		session_start();
		include "../koneksi/koneksi.php";
		
		$d['nama']		= $_POST['g_nm_peg'];
		$d['peg_id'] 	= $_POST['g_nama'];
		$d['nip']		= $_POST['g_nip'];
		$d['no_hp']		= $_POST['g_no_hp'];
		$d['role_id']	= $_POST['g_role'];
		$d['ruangan_id']= $_POST['g_ruangan'];
		$d['aktif'] 	= $_POST['g_status'];
		
		$query = "insert into ipl_pengguna(pegawai_id, nama, role_id, ruangan_id, aktif)
								value($d[peg_id], '$d[nama]', $d[role_id], $d[ruangan_id], $d[aktif])";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function get_dtl_peg(){
		include "../koneksi/koneksi_sdm.php";
		$pegawai = get_data_pegawai($_POST['gid']);
		echo json_encode($pegawai[0]);
	}
	
	function get_data_edit(){
		include "../koneksi/koneksi.php";
		$query = mysql_query("select id, pegawai_id, ruangan_id, aktif, role_id from ipl_pengguna where id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		$pegawai = get_data_pegawai($data['pegawai_id']);
		$dataf = array_merge($pegawai[0], $data);
		echo json_encode($dataf);
	}
	
	function edit_data_proses(){
		session_start();
		include "../koneksi/koneksi.php";
		//print_r($_POST);exit;
		
		$id 		= $_POST['g_id'];
		$nama 		= $_POST['g_nama'];
		$nip 		= $_POST['g_nip'];
		$no_hp 		= $_POST['g_no_hp'];
		$kepegawaian= $_POST['g_kepegawaian'];
		$role 		= $_POST['g_role'];
		$ruangan 	= $_POST['g_ruangan'];
		$status 	= $_POST['g_status'];
		
		$q = "update ipl_pengguna set
				role_id		= $role,
				ruangan_id	= $ruangan,
				aktif		= $status
			where id = $id";
		
		if(mysql_query($q)){
			$res = edit_proses_sdm($_POST);
			if($res){
				$ret = array(
					'sts' => 1,
					'msg' => 'Berhasil menyimpan data'
				);
			}else{
				$ret = array(
					'sts' => 0,
					'msg' => 'Gagal Menyimpan data pegawai'
				);
			}
		}else{
			$ret = array(
				'sts' => 0,
				'msg' => mysql_error()
			);
		}
		echo json_encode($ret);
	}
	
	function edit_proses_sdm($par){
		include "../koneksi/koneksi_sdm.php";
		
		$id 		= $par['g_id_peg'];
		$nama 		= $par['g_nama'];
		$no_hp 		= $par['g_no_hp'];
		$kepegawaian= $par['g_kepegawaian'];
		
		$q = "update pegawai set
				HP			= '$no_hp',
				STATUS_KEPEGAWAIAN	= '$kepegawaian'
			where PEGAWAI_ID = $id";
		$ret = mysql_query($q) or mysql_error();
		return $ret;
	}
	
	function hapus_data(){
		include "../koneksi/koneksi.php";
		$query = "update pegawai set deletemark = 1 where pegawai_id = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function get_pegawai_baru(){
		$pegawai = get_data_pegawai();
		include "../koneksi/koneksi.php";
		$query = mysql_query("select pegawai_id from ipl_pengguna where deletemark = 0");
		while($data = mysql_fetch_array($query)){
			$pengguna[]= $data['pegawai_id'];
		}
		
		foreach($pegawai as $v){
			$peg[]= $v['PEGAWAI_ID'];
		}
		
		$ret = array_diff($peg, $pengguna);
		$result = "<option></option>";
		if(count($ret) > 0){
			foreach($ret as $k=>$v){
				//$res[]= $pegawai[$k];
				$result .= "<option value='".$pegawai[$k]['PEGAWAI_ID']."'>".$pegawai[$k]['NAMA']."</option>";
			}
		}else{
			$result = "<option></option>";
		}
		echo $result;
	}
?>