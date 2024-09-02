<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		include "../koneksi/koneksi.php";
		session_start();
		$ret['data'] = array();
		$no = $_GET['start']+1;
		$where = '';
		//echo'<pre>';print_r($_GET['search']['value']);exit;
		if(isset($_GET['ruangan'])){
			if($_GET['ruangan'] != null && $_GET['ruangan'] != 'null' && $_GET['ruangan'] != 'all'){
				$where .= ' and mu.id_unit = '.$_GET['ruangan'];
			}
		}
		
		if(isset($_GET['jenis'])){
			if($_GET['jenis'] != 'all'){
				$where .= ' and mp.tipe_id = '.$_GET['jenis'];
			}
		}
		
		if(isset($_GET['kriteria'])){
			if($_GET['kriteria'] != 'all'){
				$where .= ' and ma.kriteria = '.$_GET['kriteria'];
			}
		}
		
		if($_SESSION['ruangan'] == 51){
			$ruangan_pj = 1;
		}else{
			$ruangan_pj = 2;
		}
		$where .= " and ma.unit_pj = $ruangan_pj ";
		$a_row  = ['ma.nm_aset', 'mp.nm_tipe', 'mu.nama'];
		$v_cari = $_GET['search']['value'];
		$s_where = " AND (";
		foreach($a_row as $v){
			$a_where[] = "$v like '%$v_cari%'";
		}
		$s_where .= implode(' or ', $a_where);
		$s_where .= ")";
		//echo $s_where;exit;
		$select = "select 
					ma.aset_id, 
					ma.nm_aset, 
					mp.jenis_id jenis_tipe,
					mp.nm_tipe,
					ma.merk_aset, 
					ma.no_seri, 
					ma.tanggal_pembelian, 
					ma.ruangan_id,
					ms.jenis_id jenis_status,
					ms.status_id,
					ms.nm_status,
					mu.nama as ruangan ";
		$query = "
				from ipl_aset ma
				left join ipl_tipe mp on mp.tipe_id = ma.tipe_id and mp.delete_mark = 0 and mp.aktif = 1
				left join ipl_status ms on ms.status_id = ma.status_id and ms.delete_mark = 0 and ms.aktif = 1
				left join unit mu on mu.id_unit = ma.ruangan_id and mu.delete_mark = 0 and mu.aktif = 1
				where ma.delete_mark = 0";
		//echo $select.$query.$where.$s_where." order by ma.aset_id desc limit $_GET[start],$_GET[length]";exit;
		$q = mysql_query($select.$query.$where.$s_where." order by ma.aset_id desc limit $_GET[start],$_GET[length]");
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
			
			$cek = cek_jml_tindakan($data['aset_id'], 0);
			
			$ret['data'][] = array(
								'no'		=> $no,
								'nama'		=> $data['nm_aset'],
								'tipe'		=> $data['nm_tipe'],
								'ruangan'	=> $data['ruangan'],
								'merk'		=> $data['merk_aset'],
								'no_seri'	=> $data['no_seri'],
								//'tgl_beli'	=> $data['tanggal_pembelian'],
								'history'	=> $cek,
								'status'	=> "<span class='label' style='$style'>$data[nm_status]</span>",
								'aksi'		=> "<a href='#'>
													<button type='button' class='btn btn-primary btn-xs' onclick='barcode($data[aset_id])'>
														<i class='fa fa-qrcode'></i>
													</button>
												</a>
												<a href='#'>
													<button type='button' class='btn btn-success btn-xs' onclick='edit_data($data[aset_id], $data[jenis_tipe], $data[jenis_status])'>
														<i class='fa fa-pencil'></i>
													</button>
												</a>
												<a href='#'>
													<button type='button' class='btn btn-danger btn-xs' onclick='hapus_data($data[aset_id])'>
														<i class='fa fa-trash-o'></i>
													</button>
												</a>"
							);
			$no++;
		}
		$sqlrn = mysql_query("select count(ma.aset_id) rn".$query.$where);
		$rown = mysql_fetch_array($sqlrn);
		$ret['draw'] = $_GET['draw'];
		$ret['recordsTotal'] = $rown['rn'];
		$ret['recordsFiltered'] = $rown['rn'];
		echo json_encode($ret);
	}
	
	function cek_jml_tindakan($aset_id, $ex){
		include "../koneksi/koneksi.php";
		$qry = "SELECT COUNT(tindakan_id) jml FROM ipl_tindakan where delete_mark = 0 and aset_id = $aset_id";
		$sql = mysql_query($qry);
		$jml = mysql_fetch_assoc($sql);
		//print_r($jml);exit;
		if($jml['jml'] > 0){
			$ret =  "<button type='button' class='btn btn-primary' onclick='get_list_perbaikan($aset_id)'>
						Perbaikan <span class='badge'>$jml[jml]</span>
					</button>";
		}else{
			$ret =  "<button type='button' class='btn btn-primary' disabled>
							Perbaikan
						</button>";
		}
		if($ex == 1){
			return $jml['jml'];
		}else{
			return $ret;
		}
	}
	
	function get_data_edit(){
		include "../koneksi/koneksi.php";
		$query = mysql_query("select aset_id, tipe_id, tipe, keterangan, nm_aset, kd_barang, merk_aset, ruangan_id, no_seri, tanggal_pembelian, status_id, unit_pj, files, umum, stok, hbs_pakai, ifnull(kriteria, 0) kriteria, penyedia, no_telp, harga, lokasi from ipl_aset where aset_id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function edit_data_proses(){
		session_start();
		include "../koneksi/koneksi.php";
		$upd_date 	= date('Y-m-d h:i:s');
		$upd_by		= $_SESSION['nama'];
		$tipe_id	= $_POST['g_tipe'];
		$nama 		= $_POST['g_nama'];
		$kd_barang	= $_POST['g_kode'];
		$id 		= $_POST['g_id'];
		$merk 		= $_POST['g_merk'];
		$ruangan	= isset($_POST['g_ruangan']) ? $_POST['g_ruangan'] : 0;
		$tipe		= $_POST['g_tipe_n'];
		$keterangan	= $_POST['g_keterangan'];
		$nose 		= isset($_POST['g_nose']) ? $_POST['g_nose'] : '';
		$tgl_beli 	= $_POST['g_tgl_beli'];
		$status 	= $_POST['g_status'];
		$unit_pj 	= $_POST['g_unit_pj'];
		$kriteria	= $_POST['g_non'];
		$stok		= isset($_POST['g_stok']) ? $_POST['g_stok'] : 0;
		$umum		= isset($_POST['g_umum']) ? 1 : 0 ;
		$hbs_pakai	= isset($_POST['g_hbs_pakai']) ? 1 : 0;
		$penyedia	= $_POST['g_penyedia'];
		$telp_p		= $_POST['g_telp_p'];
		$harga		= $_POST['g_harga'];
		$lokasi		= $_POST['g_lokasi'];
		
		if($umum == 1){
			$status = 1;
		}
		
		if(isset($_FILES['g_file']) && $_FILES['g_file']['error'] == 0){
			$files			= $_FILES['g_file'];
			if($files['error'] == 0){
				$info   	= pathinfo($files['name']);
				$datime 	= date("Ymd_his");
				$nm_img		= "aset_$datime.$info[extension]";
				$tempname	= $files['tmp_name'];
				$folder		= "files/img/aset/$nm_img";
				
				$file = $_FILES['g_file']['tmp_name']; 
				$sourceProperties = getimagesize($file);
				$fileNewName = time();
				$folderPath = "../files/img/aset/";
				$ext = pathinfo($_FILES['g_file']['name'], PATHINFO_EXTENSION);
				$imageType = $sourceProperties[2];
				
				switch ($imageType) {
					case IMAGETYPE_PNG:
						$imageResourceId = imagecreatefrompng($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagepng($targetLayer,$folderPath. $fileNewName. "$_POST[g_tipe].". $ext);
						break;
					case IMAGETYPE_GIF:
						$imageResourceId = imagecreatefromgif($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagegif($targetLayer,$folderPath. $fileNewName. "$_POST[g_tipe].". $ext);
						break;
					case IMAGETYPE_JPEG:
						$imageResourceId = imagecreatefromjpeg($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagejpeg($targetLayer,$folderPath. $fileNewName. "$_POST[g_tipe].". $ext);
						break;
					default:
						echo "Invalid Image type.";
						exit;
						break;
				}
				
				if ($sks){
					$d['files']		= 'files/img/aset/'.$fileNewName. "$_POST[g_tipe].". $ext;
					$q = "update ipl_aset set
						tipe_id 			= $tipe_id,
						nm_aset 			= '$nama',
						kd_barang			= '$kd_barang',
						merk_aset 			= '$merk',
						ruangan_id 			= $ruangan,
						no_seri 			= '$nose',
						tipe 				= '$tipe',
						keterangan 			= '$keterangan',
						tanggal_pembelian 	= '$tgl_beli',
						unit_pj				= $unit_pj,
						status_id 			= $status,
						files 				= '$folder',
						kriteria			= $kriteria,
						umum				= $umum,
						hbs_pakai			= $hbs_pakai,
						stok				= $stok,
						penyedia			= '$penyedia',
						no_telp				= '$telp_p',
						harga				= '$harga',
						lokasi				= '$lokasi',
						update_date 		= '$upd_date',
						update_by 			= '$upd_by'
					where aset_id = $id";
					if(mysql_query($q)){
						$return = array('sts'=>1, 'msg'=>'Berhasil edit data');
					}else{
						$return = array('sts'=>0, 'msg'=>mysql_error());
					}
				}else{
					$return = array('sts'=> 0, 'msg'=> 'upload file gagal');
				}
			}else{
				$return = array('sts'=> 0, 'msg'=> 'files error');
			}
		}else{
			$q = "update ipl_aset set
				tipe_id 			= $tipe_id,
				nm_aset 			= '$nama',
				kd_barang			= '$kd_barang',
				merk_aset 			= '$merk',
				ruangan_id 			= $ruangan,
				no_seri 			= '$nose',
				tipe 				= '$tipe',
				keterangan 			= '$keterangan',
				tanggal_pembelian 	= '$tgl_beli',
				unit_pj				= $unit_pj,
				status_id 			= $status,
				kriteria			= $kriteria,
				umum				= $umum,
				hbs_pakai			= $hbs_pakai,
				stok				= $stok,
				penyedia			= '$penyedia',
				no_telp				= '$telp_p',
				harga				= '$harga',
				lokasi				= '$lokasi',
				update_date 		= '$upd_date',
				update_by 			= '$upd_by'
			where aset_id = $id";
			if(mysql_query($q)){
				$return = array('sts'=>1, 'msg'=>'Berhasil edit data');
			}else{
				$return = array('sts'=>0, 'msg'=>mysql_error());
			}
		}
		echo json_encode($return);
	}
	
	function add_data(){
		session_start();
		include "../koneksi/koneksi.php";
		//print_r($_POST);exit;
		$d['create_by']	= $_SESSION['nama'];
		$d['tipe_id'] 	= $_POST['g_tipe'];
		$d['nm_aset']	= $_POST['g_nama'];
		$d['kd_barang']	= $_POST['g_kode'];
		$d['merk_aset']	= $_POST['g_merk'];
		$d['tipe']		= $_POST['g_tipe_n'];
		$d['keterangan']= $_POST['g_keterangan'];
		$d['no_seri'] 	= isset($_POST['g_nose']) ? $_POST['g_nose'] : '';
		$d['tanggal_pembelian'] 	= $_POST['g_tgl_beli'];
		$d['status_id']	= $_POST['g_status'];
		$d['unit_pj'] 	= $_POST['g_unit_pj'];
		$d['kriteria']	= $_POST['g_non'];
		$d['umum']		= isset($_POST['g_umum']) ? 1 : 0 ;
		$d['hbs_pakai']	= isset($_POST['g_hbs_pakai']) ? 1 : 0;
		$d['penyedia']	= $_POST['g_penyedia'];
		$d['no_telp']	= $_POST['g_telp_p'];
		$d['harga']		= $_POST['g_harga'];
		$d['lokasi']	= $_POST['g_lokasi'];
		
		
		if($d['umum'] == 0){
			$d['ruangan_id']	= $_POST['g_ruangan'];
		}
		
		if($d['hbs_pakai'] == 1){
			$d['stok']		= $_POST['g_stok'];
		}
		
		if(isset($_FILES['g_file']) && $_FILES['g_file']['error'] == 0){
			$files			= $_FILES['g_file'];
			if($files['error'] == 0){
				//if($files['size'] <= 1000000){
				$info   	= pathinfo($files['name']);
				$datime 	= date("Ymd_his");
				$nm_img		= "aset_$datime.$info[extension]";
				$tempname	= $files['tmp_name'];
				$folder		= "files/img/aset/$nm_img";
				
				$file = $_FILES['g_file']['tmp_name']; 
				$sourceProperties = getimagesize($file);
				$fileNewName = time();
				$folderPath = "../files/img/aset/";
				$ext = pathinfo($_FILES['g_file']['name'], PATHINFO_EXTENSION);
				$imageType = $sourceProperties[2];
				switch ($imageType) {
					case IMAGETYPE_PNG:
						$imageResourceId = imagecreatefrompng($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagepng($targetLayer,$folderPath. $fileNewName. "$_POST[g_tipe].". $ext);
						break;
					case IMAGETYPE_GIF:
						$imageResourceId = imagecreatefromgif($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagegif($targetLayer,$folderPath. $fileNewName. "$_POST[g_tipe].". $ext);
						break;
					case IMAGETYPE_JPEG:
						$imageResourceId = imagecreatefromjpeg($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagejpeg($targetLayer,$folderPath. $fileNewName. "$_POST[g_tipe].". $ext);
						break;
					default:
						echo "Invalid Image type.";
						exit;
						break;
				}
				
				if ($sks){
					$d['files']		= 'files/img/aset/'.$fileNewName. "$_POST[g_tipe].". $ext;
					$cols = array();
					foreach ($d as $field => $value) {
						$cols[] = "`".$field."`";
					}
					$query = "insert into ipl_aset(".implode(',', $cols).")
											value('".implode("','", $d)."')";
											//echo $query;
					if(mysql_query($query)){
						$return = array('sts'=> 1, 'msg'=> 'sukses');
					}else{
						$return = array('sts'=> 0, 'msg'=> mysql_error());
					}
				}else{
					$return = array('sts'=> 0, 'msg'=> 'upload file gagal');
				}
				//}else{
					//$return = array('sts'=> 0, 'msg'=> 'ukuran tidak boleh lebih dari 1mb');
				//}
			}else{
				$return = array('sts'=> 0, 'msg'=> 'files error');
			}
		}else{
			$cols = array();
			foreach ($d as $field => $value) {
				$cols[] = "`".$field."`";
			}
			$query = "insert into ipl_aset(".implode(',', $cols).")
									value('".implode("','", $d)."')";
			if(mysql_query($query)){
				$return = array('sts'=> 1, 'msg'=> 'sukses');
			}else{
				$return = array('sts'=> 0, 'msg'=> mysql_error());
			}
		}
		
		echo json_encode($return);
	}
	
	function imageResize($imageResourceId,$width,$height) {
		$targetWidth =200;
		$targetHeight =200;
		$targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
		imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
		return $targetLayer;
	}
	
	function hapus_data(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_aset set delete_mark = 1 where aset_id = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function get_qrcode(){
		$directory 	= "../qrcode/qrcode-img/";
		$qr_code 	= glob($directory . "qrcode-aset-$_POST[gid].png");
		
		include "../koneksi/koneksi.php";
		$query = mysql_query("select aset.nm_aset, aset.lokasi, aset.merk_aset, rg.nama
								from ipl_aset aset 
								left join unit rg on rg.id_unit = aset.ruangan_id
								where aset.aset_id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		
		if($qr_code){
			$ret = array('sts'=>1, 'msg'=>str_replace('../', '', $qr_code[0]), 'nm_aset'=>"<span>$data[nama]</span> [<span>$data[nm_aset] - $data[merk_aset]</span>]<br><span>$data[lokasi]</span>");
		}else{
			$ret = array('sts'=>0, 'msg'=>'');
		}
		echo json_encode($ret);
	}
	
	function get_list_perbaikan(){
		include "../koneksi/koneksi.php";
		$aset_id = $_GET['aset_id'];
		$select = 'SELECT it.jenis_id, it.petugas_id, ip.nama nm_teknisi, it.tindakan, it.tanggal';
		$query = " FROM ipl_tindakan it
		LEFT JOIN ipl_pengguna ip ON ip.id = it.petugas_id
		WHERE it.delete_mark = 0
		AND it.aset_id = $aset_id";
		$sql = mysql_query($select.$query." order by it.tindakan_id desc");
		$no = 1;
		$ret['data'] = array();
		while($data = mysql_fetch_array($sql)){
			$ret['data'][] = array(
				'no'		=> $no,
				'tgl'		=> $data['tanggal'],
				'ket'		=> $data['tindakan'],
				'tks'		=> $data['nm_teknisi'],
				'jns'		=> $data['jenis_id'] == 1 ? "<span class='label' style='background-color:#47a447;'>Pemeliharaan</span>" : "<span class='label' style='background-color:#08c;'>Perbaikan</span>"
			);
			$no++;
		}
		echo json_encode($ret);
	}
	
	function downloadexcel(){
		session_start();
		include "../koneksi/koneksi.php";
		include '../files/PHPExcel.php';
		$ruangan 	= $_GET['ruangan'];
		$jenis 		= $_GET['jenis'];
		$kriteria 	= $_GET['kriteria'];
		$where = '';
		$no = 1;
		
		if($_SESSION['ruangan'] == 51){
			$ruangan_pj = 1;
		}else{
			$ruangan_pj = 2;
		}
		$where .= " and ma.unit_pj = $ruangan_pj ";
		$a_row  = ['ma.nm_aset', 'mp.nm_tipe', 'mu.nama'];
		$v_cari = $_GET['cari'];
		$s_where = " AND (";
		foreach($a_row as $v){
			$a_where[] = "$v like '%$v_cari%'";
		}
		$s_where .= implode(' or ', $a_where);
		$s_where .= ")";
		//echo $s_where;exit;
		$select = "select 
					ma.aset_id, 
					ma.nm_aset, 
					mp.jenis_id jenis_tipe,
					mp.nm_tipe,
					ma.merk_aset, 
					ma.no_seri, 
					ma.tanggal_pembelian, 
					ma.ruangan_id,
					ms.jenis_id jenis_status,
					ms.status_id,
					ms.nm_status,
					mu.nama as ruangan ";
		$query = "
				from ipl_aset ma
				left join ipl_tipe mp on mp.tipe_id = ma.tipe_id and mp.delete_mark = 0 and mp.aktif = 1
				left join ipl_status ms on ms.status_id = ma.status_id and ms.delete_mark = 0 and ms.aktif = 1
				left join unit mu on mu.id_unit = ma.ruangan_id and mu.delete_mark = 0 and mu.aktif = 1
				where ma.delete_mark = 0";
		//echo $select.$query.$where.$s_where." order by ma.aset_id desc limit $_GET[start],$_GET[length]";exit;
		$q = mysql_query($select.$query.$where.$s_where." order by ma.aset_id desc");
		
		$phpex = new PHPExcel();
		$phpexActive = $phpex->getActiveSheet();
		
		$phpex->getProperties()->setTitle("title")->setDescription("description");
		$phpex->setActiveSheetIndex(0);
		//$phpexActive->setCellValue('A2', 'DATA ULASAN PASIEN');
		$phpexActive->setCellValue('A3', 'NO');
		$phpexActive->setCellValue('B3', 'NAMA');
		$phpexActive->setCellValue('C3', 'JENIS');
		$phpexActive->setCellValue('D3', 'RUANGAN');
		$phpexActive->setCellValue('E3', 'MERK');
		$phpexActive->setCellValue('F3', 'NO SERI');
		$phpexActive->setCellValue('G3', 'PERBAIKAN');
		$phpexActive->setCellValue('H3', 'STATUS');
		
		$phpexActive->getStyle('A3:H3')->applyFromArray(
			array(
				'font' => array(
					'bold' => true
				)
			)
		);
		$phpexActive->getStyle('A3:H3')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'CCFFFF')
				)
			)
		);
		
		$rakr = 0;
		while($data = mysql_fetch_array($q)){
			$row 	= 3 + $no;
			$rakr 	= $row;
			$cek 	= cek_jml_tindakan($data['aset_id'], 1);
			
			$phpexActive->setCellValue("A$row", $no);
			$phpexActive->setCellValue("B$row", $data['nm_aset']);
			$phpexActive->setCellValue("C$row", $data['nm_tipe']);
			$phpexActive->setCellValue("D$row", $data['ruangan']);
			$phpexActive->setCellValue("E$row", $data['merk_aset']);
			$phpexActive->setCellValue("F$row", $data['no_seri']);
			$phpexActive->setCellValue("G$row", $cek);
			$phpexActive->setCellValue("H$row", $data['nm_status']);
			$no++;
		}
		
		$phpexActive->getStyle("A3:H$rakr")->applyFromArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			)
		);
		
		foreach (range('A', 'H') as $columnID) {
            $phpexActive->getColumnDimension($columnID)->setAutoSize(true);
        }
		
		$name = "Data Master Aset ".date('d-m-Y').".xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$name");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($phpex, 'Excel5');
        $objWriter->save('php://output');
	}
?>