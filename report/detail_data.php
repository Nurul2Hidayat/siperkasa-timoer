<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		include "../koneksi/koneksi.php";
		session_start();
		//print_r($_SESSION);exit;
		$tbl = $where = '';
		if($_SESSION['group'] == 1){
			$where = " AND tp.pelapor = $_SESSION[simrsig] ";
		}else{
			if(isset($_POST['gruangan'])){
				if($_POST['gruangan'] != null && $_POST['gruangan'] != 'null' && $_POST['gruangan'] != 'all'){
					$where .= " and mr.id_unit = $_POST[gruangan] ";
				}
			}
			
			if(isset($_POST['gpelapor'])){
				if($_POST['gpelapor'] != null && $_POST['gpelapor'] != 'null' && $_POST['gpelapor'] != 'all'){
					$where .= " and mp.pegawai_id = $_POST[gpelapor] ";
				}
			}
			
			if(isset($_POST['gstatus'])){
				if($_POST['gstatus'] != null && $_POST['gstatus'] != 'null' && $_POST['gstatus'] != 'all'){
					$where .= " and ms.status_id = $_POST[gstatus] ";
				}
			}
			//print_r($_SESSION);
			if($_SESSION['ruangan'] == 51){
				$ruangan_pj = 1;
			}else{
				$ruangan_pj = 2;
			}
			$where .= " and ma.unit_pj = $ruangan_pj ";
		}
		if($_POST['gtanggal'] != null && $_POST['gtanggal'] != 'null' && $_POST['gtanggal'] != 'all'){
			$where .= " AND DATE_FORMAT(tp.tanggal_permintaan, '%Y-%m-%d') = '$_POST[gtanggal]'";
		}
		
		
		
		
		$no = $_POST['start']+1;
		$ret['data'] = array();
		$select ="SELECT 
					tp.permintaan_id,
					tp.aset_id,
					mr.nama,
					mp.nama pelapor,
					ma.nm_aset,
					tp.permintaan,
					tp.jumlah,
					mt.nm_tipe,
					DATE_FORMAT(tp.tanggal_permintaan, '%Y-%m-%d') tanggal_permintaan,
					ms.jenis_id,
					ms.status_id,
					ms.nm_status ";
		$query = "
				FROM ipl_permintaan tp
				LEFT JOIN unit mr ON mr.id_unit = tp.ruangan_id AND mr.aktif = 1
				LEFT JOIN ipl_aset ma ON ma.aset_id = tp.aset_id AND ma.delete_mark = 0
				LEFT JOIN ipl_status ms ON ms.status_id = tp.status_id AND ms.delete_mark = 0
				LEFT JOIN ipl_pengguna mp ON mp.pegawai_id = tp.pelapor
				LEFT JOIN ipl_aset_tipe mt ON mt.id = tp.tipe_id
				WHERE tp.delete_mark = 0 $where";
		//echo $query;exit;
		$q = mysql_query($select.$query." order by tp.tanggal_permintaan desc limit $_POST[start],$_POST[length]");
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
			
			$btn = "<td>
						<a href='#'>
							<button type='button' class='btn btn-success btn-xs' onclick='detail($data[permintaan_id], $data[jenis_id], $data[aset_id])'>
								<i class='fa fa-exclamation-circle'></i> detail
							</button>
						</a>
					</td>";
			
			$ret['data'][] = array(
								'no'			=> $no,
								'ruangan'		=> $data['nama'],
								'teknisi'		=> $data['pelapor'],
								'barang'		=> $data['nm_aset'],
								'permintaan'	=> $data['permintaan'],
								'jumlah'		=> $data['jumlah'],
								'tipe'			=> $data['nm_tipe'],
								'tgl_permintaan'=> $data['tanggal_permintaan'],
								'status'		=> "<span class='label' style='$style'>$data[nm_status]</span>",
								'aksi'			=> $btn
							);
			$no++;
		}
		$sqlrn = mysql_query("select count(tp.permintaan_id) rn".$query);
		$rown = mysql_fetch_array($sqlrn);
		$ret['recordsTotal'] = $rown['rn'];
		$ret['recordsFiltered'] = $rown['rn'];
		echo json_encode($ret);
	}
	
	function get_aset(){
		include "../koneksi/koneksi.php";
		$unit = $_POST['gunit'] ? ' and ruangan_id = '.$_POST['gunit'] : '';
		$result = "<option></option>";
		$query = mysql_query("select aset_id, nm_aset, merk_aset from ipl_aset where delete_mark = 0 $unit");
		while($data = mysql_fetch_array($query)){
			$result .= "<option value='$data[aset_id]'>$data[nm_aset] ($data[merk_aset])</option>";
		}
		$query2 = mysql_query("select aset_id, nm_aset from ipl_aset where delete_mark = 0 and umum = 1");
		while($data2 = mysql_fetch_array($query2)){
			$result .= "<option value='$data2[aset_id]'>$data2[nm_aset]</option>";
		}
		echo json_encode($result);
	}
	
	function get_data_edit(){
		include "../koneksi/koneksi.php";
		$query = mysql_query("select 
									permintaan_id, 
									ruangan_id, 
									pelapor, 
									aset_id, 
									permintaan,
									status_id,
									jumlah,
									tipe_id,
									lokasi,
									ifnull(gambar, 'no-image.jpg') gambar
								from ipl_permintaan 
								where permintaan_id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function edit_data_proses(){
		session_start();
		include "../koneksi/koneksi.php";
		if($_FILES['g_file']['error'] == 0) {
			$file = $_FILES['g_file']['tmp_name']; 
			$sourceProperties = getimagesize($file);
			$fileNewName = time();
			$folderPath = "../files/img/permintaan/";
			$ext = pathinfo($_FILES['g_file']['name'], PATHINFO_EXTENSION);
			$imageType = $sourceProperties[2];
			switch ($imageType) {
				case IMAGETYPE_PNG:
					$imageResourceId = imagecreatefrompng($file); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					$sks = imagepng($targetLayer,$folderPath. $fileNewName. "$_POST[g_aset].". $ext);
					break;
				case IMAGETYPE_GIF:
					$imageResourceId = imagecreatefromgif($file); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					$sks = imagegif($targetLayer,$folderPath. $fileNewName. "$_POST[g_aset].". $ext);
					break;
				case IMAGETYPE_JPEG:
					$imageResourceId = imagecreatefromjpeg($file); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					$sks = imagejpeg($targetLayer,$folderPath. $fileNewName. "$_POST[g_aset].". $ext);
					break;
				default:
					echo "Invalid Image type.";
					exit;
					break;
			}
			if($sks){				
				$upd_date 	= date('Y-m-d h:i:s');
				$upd_by		= $_SESSION['nama'];
				$id		 	= $_POST['g_id'];
				$ruangan 	= $_POST['g_ruangan'];
				$pelapor 	= $_POST['g_pelapor'];
				$aset 		= isset($_POST['g_aset']) ? $_POST['g_aset'] : 0;
				$permintaan = $_POST['g_permintaan'];
				$status 	= $_POST['g_status'];
				$jumlah		= $_POST['g_stok'];
				$lokasi		= $_POST['g_lokasi'];
				$tipe		= isset($_POST['g_tipe']) ? $_POST['g_tipe'] : 0;
				
				$query = "update ipl_permintaan set
							ruangan_id	= $ruangan,
							pelapor 	= '$pelapor',
							aset_id 	= $aset,
							permintaan 	= '$permintaan',
							status_id 	= $status,
							jumlah		= $jumlah,
							tipe_id		= $tipe,
							lokasi		= '$lokasi',
							gambar		= '$fileNewName$_POST[g_aset].$ext'
						where permintaan_id = $id";
						
				if(mysql_query($query)){
					$return = array('sts'=>1, 'msg'=>'sukses');
				}else{
					$return = array('sts'=>0, 'msg'=>mysql_error());
				}
			}else{
				$return = array('sts'=>0, 'msg'=>'gagal upload file');
			}
		}else if($_FILES['g_file']['error'] == 4){
			$upd_date 	= date('Y-m-d h:i:s');
			$upd_by		= $_SESSION['nama'];
			$id		 	= $_POST['g_id'];
			$ruangan 	= $_POST['g_ruangan'];
			$pelapor 	= $_POST['g_pelapor'];
			$aset 		= isset($_POST['g_aset']) ? $_POST['g_aset'] : 0;
			$permintaan = $_POST['g_permintaan'];
			$status 	= $_POST['g_status'];
			$jumlah		= $_POST['g_stok'];
			$lokasi		= $_POST['g_lokasi'];
			$tipe		= isset($_POST['g_tipe']) ? $_POST['g_tipe'] : 0;
			
			$query = "update ipl_permintaan set
						ruangan_id	= $ruangan,
						pelapor 	= '$pelapor',
						aset_id 	= $aset,
						permintaan 	= '$permintaan',
						status_id 	= $status,
						jumlah		= $jumlah,
						tipe_id		= $tipe,
						lokasi		= '$lokasi'
					where permintaan_id = $id";
					
			if(mysql_query($query)){
				$return = array('sts'=>1, 'msg'=>'sukses');
			}else{
				$return = array('sts'=>0, 'msg'=>mysql_error());
			}
		}else{
			$return = array('sts'=>0, 'msg'=>'file bermasalah');
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
	
	function add_data(){
		session_start();
		include "../koneksi/koneksi.php";
		if($_FILES['g_file']['error'] == 0) {
			$file = $_FILES['g_file']['tmp_name']; 
			$sourceProperties = getimagesize($file);
			$fileNewName = time();
			$folderPath = "../files/img/permintaan/";
			$ext = pathinfo($_FILES['g_file']['name'], PATHINFO_EXTENSION);
			$imageType = $sourceProperties[2];
			switch ($imageType) {
				case IMAGETYPE_PNG:
					$imageResourceId = imagecreatefrompng($file); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					$sks = imagepng($targetLayer,$folderPath. $fileNewName. "$_POST[g_aset].". $ext);
					break;
				case IMAGETYPE_GIF:
					$imageResourceId = imagecreatefromgif($file); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					$sks = imagegif($targetLayer,$folderPath. $fileNewName. "$_POST[g_aset].". $ext);
					break;
				case IMAGETYPE_JPEG:
					$imageResourceId = imagecreatefromjpeg($file); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					$sks = imagejpeg($targetLayer,$folderPath. $fileNewName. "$_POST[g_aset].". $ext);
					break;
				default:
					echo "Invalid Image type.";
					exit;
					break;
			}
			if($sks){
				$d['ins_by']	= isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
				$d['ruangan']	= $_POST['g_ruangan'];
				$d['pelapor'] 	= $_POST['g_pelapor'];
				$d['aset'] 		= isset($_POST['g_aset']) ? $_POST['g_aset'] : 0;
				$d['permintaan']= $_POST['g_permintaan'];
				$d['status'] 	= $_POST['g_status'];
				$d['jumlah']	= $_POST['g_stok'] == '' ? 0 : $_POST['g_stok'];
				$d['lokasi']	= $_POST['g_lokasi'];
				$d['tipe']		= isset($_POST['g_tipe']) ? $_POST['g_tipe'] : 0;
				
				$query = "insert into ipl_permintaan(ruangan_id, pelapor, aset_id, permintaan, status_id, jumlah, tipe_id, lokasi, gambar, create_by)
											value($d[ruangan], '$d[pelapor]', $d[aset], '$d[permintaan]', $d[status], $d[jumlah], $d[tipe], '$d[lokasi]', '$fileNewName$_POST[g_aset].$ext', '$d[ins_by]')";
				if(mysql_query($query)){
					$return = array('sts'=>1, 'msg'=>'sukses');
					$wa = send_wa(mysql_insert_id());
				}else{
					$return = array('sts'=>0, 'msg'=>mysql_error());
				}
			}else{
				$return = array('sts'=>0, 'msg'=>'gagal upload file');
			}
		}else if($_FILES['g_file']['error'] == 4){
			$d['ins_by']	= isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
			$d['ruangan']	= $_POST['g_ruangan'];
			$d['pelapor'] 	= $_POST['g_pelapor'];
			$d['aset'] 		= isset($_POST['g_aset']) ? $_POST['g_aset'] : 0;
			$d['permintaan']= $_POST['g_permintaan'];
			$d['status'] 	= $_POST['g_status'];
			$d['jumlah']	= $_POST['g_stok'] == '' ? 0 : $_POST['g_stok'];
			$d['lokasi']	= $_POST['g_lokasi'];
			$d['tipe']		= isset($_POST['g_tipe']) ? $_POST['g_tipe'] : 0;
			
			$query = "insert into ipl_permintaan(ruangan_id, pelapor, aset_id, permintaan, status_id, jumlah, tipe_id, lokasi, create_by)
										value($d[ruangan], '$d[pelapor]', $d[aset], '$d[permintaan]', $d[status], $d[jumlah], $d[tipe], '$d[lokasi]', '$d[ins_by]')";
			//echo $query;exit;
			if(mysql_query($query)){
				$return = array('sts'=>1, 'msg'=>'sukses');
				$wa = send_wa(mysql_insert_id());
			}else{
				$return = array('sts'=>0, 'msg'=>mysql_error());
			}
		}else{
			$return = array('sts'=>0, 'msg'=>'file bermasalah');
		}
		echo json_encode($return);
	}
	
	function send_wa($id){
		$query = "SELECT un.nama nm_ruangan, ia.nm_aset, ia.aset_id, ia.unit_pj, pg.nama nm_pelapor, ip.permintaan, ip.tanggal_permintaan, ip.jumlah, ip.lokasi
					FROM ipl_permintaan ip
					LEFT JOIN unit un ON un.id_unit = ip.ruangan_id
					LEFT JOIN ipl_aset ia ON ia.aset_id = ip.aset_id
					LEFT JOIN ipl_pengguna pg ON pg.pegawai_id = ip.pelapor
					WHERE ip.permintaan_id = $id";
		$sql = mysql_query($query);
		$data = mysql_fetch_array($sql);
		$filter_token	= base64_encode(base64_encode($data['aset_id'].'___aset'));
		
		//$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/scan_qrcode_list.php";
		//$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode";
		$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/scan_qrcode.php?gid=$filter_token";
		//$teks_qrcode	= "http://rsmn.it-rs.id/it/scan_qrcode/scan_qrcode.php?gid=$filter_token/";
$text = "Permintaan Perbaikan[system]
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
		$qy2 = "select pegawai_id from ipl_pengguna where ruangan_id = $ruangan_id";
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
	
	function hapus_data(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_permintaan set delete_mark = 1 where permintaan_id = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function get_data_detail(){
		include "../koneksi/koneksi.php";
		$query = mysql_query("SELECT 
								pl.permintaan_id, 
								pl.ruangan_id, 
								pl.pelapor, 
								pl.aset_id, 
								pl.permintaan,
								pl.status_id,
								pl.alasan,
								pl.gambar,
								ps.status_id status_aset,
								ps.nm_aset
							FROM ipl_permintaan  pl
							LEFT JOIN ipl_aset ps ON ps.aset_id = pl.aset_id
							WHERE pl.permintaan_id = $_POST[gid]");
		$data = mysql_fetch_array($query);
		echo json_encode($data);
	}
	
	function get_data_tindakan(){
		include "../koneksi/koneksi.php";
		$no = 1;
		$tbl['data'] = array();
		$btn = '';
		$query = mysql_query("	select 
									pl.tindakan_id, 
									pl.permintaan_id,
									pl.tindakan, 
									pl.status_id, 
									pl.tanggal,
									pg.nama
								from ipl_tindakan  pl
								left join ipl_permintaan pr on pr.permintaan_id = pl.permintaan_id
								left join ipl_pengguna pg on pg.pegawai_id = pl.petugas_id
								where pr.permintaan_id = $_GET[gid] 
									and pl.delete_mark = 0
								order by pl.tanggal desc"
							);
		while($data = mysql_fetch_array($query)){
			$btn = "<a href='#'>
						<button type='button' class='btn btn-info btn-xs' onclick='view_tindakan($data[tindakan_id])'>
							<i class='fa fa-eye'></i>
						</button>
					</a>
					<a href='#'>
						<button type='button' class='btn btn-success btn-xs' onclick='edit_tindakan($data[tindakan_id])'>
							<i class='fa fa-pencil'></i>
						</button>
					</a>
					<a href='#'>
						<button type='button' class='btn btn-danger btn-xs' onclick='hapus_tindakan($data[tindakan_id], $data[permintaan_id])'>
							<i class='fa fa-trash-o'></i>
						</button>
					</a>";
			
			$tbl['data'][] = array(
								'no'		=> $no,
								'id'		=> $data['tindakan_id'],
								'tindakan'	=> $data['tindakan'],
								'petugas'	=> $data['nama'],
								'tanggal'	=> $data['tanggal'],
								'aksi'		=> $btn
							);
			$no++;
		}
		echo json_encode($tbl);
	}
	
	function add_tindakan(){
		session_start();
		include "../koneksi/koneksi.php";
		$d['ptg_id']	= $_SESSION['simrsig'];
		$d['ins_by']	= $_SESSION['nama'];
		$d['tindakan']	= $_POST['g_tindakan'];
		$d['id_per']	= $_POST['g_id_per'];
		$d['status']	= $_POST['g_status'];
		$d['tanggal'] 	= $_POST['g_tanggal'];
		$d['time']	 	= $_POST['g_time'];
		$d['aset_id']	= $_POST['g_id_aset'];	
		//echo'<pre>';print_r($d);exit;
		if(isset($_FILES['g_file']) && $_FILES['g_file']['error'] == 0){
			$files			= $_FILES['g_file'];
			if($files['error'] == 0){
				$info   	= pathinfo($files['name']);
				$datime 	= date("Ymd_his");
				$nm_img		= "tindakan_$datime.$info[extension]";
				$tempname	= $files['tmp_name'];
				$folder		= "files/img/tindakan/$nm_img";
				
				$file = $_FILES['g_file']['tmp_name']; 
				$sourceProperties = getimagesize($file);
				$fileNewName = time();
				$folderPath = "../files/img/tindakan/";
				$ext = pathinfo($_FILES['g_file']['name'], PATHINFO_EXTENSION);
				$imageType = $sourceProperties[2];
				switch ($imageType) {
					case IMAGETYPE_PNG:
						$imageResourceId = imagecreatefrompng($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagepng($targetLayer,$folderPath. $fileNewName. ".". $ext);
						break;
					case IMAGETYPE_GIF:
						$imageResourceId = imagecreatefromgif($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagegif($targetLayer,$folderPath. $fileNewName. ".". $ext);
						break;
					case IMAGETYPE_JPEG:
						$imageResourceId = imagecreatefromjpeg($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagejpeg($targetLayer,$folderPath. $fileNewName. ".". $ext);
						break;
					default:
						echo "Invalid Image type.";
						exit;
						break;
				}
				
				if ($sks){
					$d['files']		= 'files/img/tindakan/'.$fileNewName. ".". $ext;
					
					$query = "insert into ipl_tindakan(permintaan_id, petugas_id, aset_id, tindakan, tanggal, time, status_id, files)
									value($d[id_per], $d[ptg_id], $d[aset_id], '$d[tindakan]', '$d[tanggal]', '$d[time]', $d[status], '$d[files]')";
					//echo $query;
					if(mysql_query($query)){
						$qy = "update ipl_aset set status_id = $d[status] where aset_id = $d[aset_id]";
						echo mysql_query($qy) or die(mysql_error());
					}else{
						echo mysql_error();
					}
				}else{
					echo 0;
				}
			}else{
				echo 0;
			}
		}else{
			$query = "insert into ipl_tindakan(permintaan_id, petugas_id, aset_id, tindakan, tanggal, time, status_id)
									value($d[id_per], $d[ptg_id], $d[aset_id], '$d[tindakan]', '$d[tanggal]', '$d[time]', $d[status])";
			//echo $query;exit;
			if(mysql_query($query)){
				$qy = "update ipl_aset set status_id = $d[status] where aset_id = $d[aset_id]";
				echo mysql_query($qy) or die(mysql_error());
			}else{
				echo mysql_error();
			}
		}
	}
	
	function get_dtl_tindakan(){
		include "../koneksi/koneksi.php";
		$query = "select it.tindakan_id, it.tindakan, it.tanggal, it.time, it.status_id, isa.aset_id, isa.status_id status_aset, ip.permintaan_id, it.files
			from ipl_tindakan it 
			left join ipl_permintaan ip on ip.permintaan_id = it.permintaan_id
			left join ipl_aset isa on isa.aset_id = ip.aset_id
			where it.tindakan_id = $_GET[gid]";
		$sql = mysql_query($query);
		$data = mysql_fetch_array($sql);
		echo json_encode($data);
	}
	
	function proses_edit_tindakan(){
		include "../koneksi/koneksi.php";
		
		if(isset($_FILES['g_file']) && $_FILES['g_file']['error'] == 0){
			$files			= $_FILES['g_file'];
			if($files['error'] == 0){
				$info   	= pathinfo($files['name']);
				$datime 	= date("Ymd_his");
				$nm_img		= "tindakan_$datime.$info[extension]";
				$tempname	= $files['tmp_name'];
				$folder		= "files/img/tindakan/$nm_img";
				
				$file = $_FILES['g_file']['tmp_name']; 
				$sourceProperties = getimagesize($file);
				$fileNewName = time();
				$folderPath = "../files/img/tindakan/";
				$ext = pathinfo($_FILES['g_file']['name'], PATHINFO_EXTENSION);
				$imageType = $sourceProperties[2];
				switch ($imageType) {
					case IMAGETYPE_PNG:
						$imageResourceId = imagecreatefrompng($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagepng($targetLayer,$folderPath. $fileNewName. ".". $ext);
						break;
					case IMAGETYPE_GIF:
						$imageResourceId = imagecreatefromgif($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagegif($targetLayer,$folderPath. $fileNewName. ".". $ext);
						break;
					case IMAGETYPE_JPEG:
						$imageResourceId = imagecreatefromjpeg($file); 
						$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
						$sks = imagejpeg($targetLayer,$folderPath. $fileNewName. ".". $ext);
						break;
					default:
						echo "Invalid Image type.";
						exit;
						break;
				}
				
				if ($sks){
					$d['files']		= 'files/img/tindakan/'.$fileNewName. ".". $ext;
					$query = "update ipl_tindakan 
								set 	tindakan	= '$_POST[g_tindakan]',
										tanggal		= '$_POST[g_tanggal]',
										time		= '$_POST[g_time]',
										files		= '$d[files]'
								where tindakan_id = $_POST[g_id]";
					//echo $query;
					echo mysql_query($query) or die(mysql_error());
				}else{
					echo 0;
				}
			}else{
				echo 0;
			}
		}else{
			$query = "update ipl_tindakan 
						set 	tindakan	= '$_POST[g_tindakan]',
								tanggal		= '$_POST[g_tanggal]',
								time		= '$_POST[g_time]'
						where tindakan_id = $_POST[gid]";
			//echo $query;exit;
			echo mysql_query($query) or die(mysql_error());
		}
	}
	
	function hapus_tindakan($per_id){
		include "../koneksi/koneksi.php";
		$query = "update ipl_tindakan set delete_mark = 1 where tindakan_id = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function cek_barang(){
		include "../koneksi/koneksi.php";
		$id = $_POST['gkey'];
		$query = "SELECT COUNT(it.id) tipe, ia.hbs_pakai, merk_aset, unit_pj, no_seri, ia.lokasi, ia.umum
					FROM ipl_aset ia
					LEFT JOIN ipl_aset_tipe it ON it.aset_id = ia.aset_id and it.deletemark = 0 and it.aktif = 1
					WHERE ia.aset_id = $id";
		$sql = mysql_query($query);
		$data = mysql_fetch_array($sql);
		echo json_encode($data);
	}
	
	function change_status(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_permintaan set status_id = $_POST[val] where permintaan_id = $_POST[id]";
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
		$query = "SELECT 
					pm.pelapor,
					pl.nama nm_pelapor,
					pm.permintaan,
					pm.tanggal_permintaan,
					pm.status_id,
					st.nm_status,
					cg.id log_id,
					cg.create_by,
					pt.nama nm_petugas,
					pt.ruangan_id,
					cg.create_date
				FROM ipl_permintaan pm
				LEFT JOIN ipl_log_sts_permintaan cg ON cg.permintaan_id = pm.permintaan_id
				LEFT JOIN ipl_pengguna pl ON pl.pegawai_id = pm.pelapor
				LEFT JOIN ipl_status st ON st.status_id = pm.status_id
				LEFT JOIN ipl_pengguna pt ON pt.pegawai_id = cg.create_by
				WHERE pm.permintaan_id = $par[id]
				AND pm.status_id = $par[val]
				ORDER BY cg.create_date DESC
				LIMIT 1";
		
		$sql = mysql_query($query);
		$data = mysql_fetch_assoc($sql);
		//print_r($data);
		if($par['val'] == 15){
			$act = "dengan konfirmasi *$par[ket]*";
		}else if($par['val'] == 12){
			$act = "dengan tindakan *$par[ket]*";
		}else if($par['val'] == 13){
			$act = "dengan alasan *$par[ket]*";
		}else{
			$act = "";
		}
		$peg = data_pegawai($data['pelapor']);
		if($peg['HP'] != null){
			$link = "Terimakasih";
			
			if($data['ruangan_id'] == 51 && $par['val'] == 12){
				$filter_token	= base64_encode(base64_encode($par['id'].'___rating'));
$link = "
Mohon untuk mengisi rating dan ulasan terhadap kinerja kami dengan klik link dibawah ini

http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/rating.php?gid=$filter_token

Terimakasih";
			}
			
			$text = "
Hai *$data[nm_pelapor]*
untuk permintaan perbaikan : $data[permintaan]

sudah di update ke status *$data[nm_status]*
oleh *$data[nm_petugas]*
$act
pada *$data[create_date]*

$link

Note:
pesan ini dikirim oleh sistem, tidak perlu membalas pesan ini
";
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
				CURLOPT_POSTFIELDS => json_encode(array("nomor"=>"$peg[HP]", "pesan"=>"$text")),
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json'
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
		}
	}
	
	function data_pegawai($id){
		include "../koneksi/koneksi_sdm.php";
		$query = mysql_query("select * from pegawai where PEGAWAI_ID = $id");
		$data = mysql_fetch_array($query);
		return $data;
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
	
	function change_alasan(){
		include "../koneksi/koneksi.php";
		$query = "update ipl_permintaan set alasan = '$_POST[val]' where permintaan_id = $_POST[id]";
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
		echo json_encode($ret);
	}
	
	function get_data_dtl(){
		include "../koneksi/koneksi.php";
		$id = $_POST['gid'];
		
		$qy = "SELECT lg.permintaan_id, lg.status_id, ist.nm_status, lg.ket, lg.create_by, ip.nama nm_teknisi, lg.create_date
				FROM ipl_log_sts_permintaan lg
				LEFT JOIN ipl_pengguna ip ON ip.id = lg.create_by
				LEFT JOIN ipl_status ist ON ist.status_id = lg.status_id
				WHERE lg.permintaan_id = $id
				AND lg.deletemark = 0
				GROUP BY lg.status_id
				ORDER BY lg.id";
		$sql = mysql_query($qy);
		$ret = array();
		while($row = mysql_fetch_array($sql)){
			$ret[] = $row;
		}
		echo json_encode($ret);
	}
?>