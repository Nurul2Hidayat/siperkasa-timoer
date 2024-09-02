<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		include "../koneksi/koneksi.php";
		$tbl = '';
		$ret['data'] = array();
		$no = 1;
		$query = "select id_unit, nama, aktif from unit where delete_mark = 0 order by id_unit desc";
		$q = mysql_query($query);
		while($data = mysql_fetch_array($q)){
			if($data['aktif'] == 1){
				$sts = "<span class='label label-success'>Aktif</span>";
			}else{
				$sts = "<span class='label label-danger'>Tidak Aktif</span>";
			}
			
			$cek = cek_jml_tindakan($data['id_unit'], 0);
			
			$ret['data'][] = array(
								'no'			=> $no,
								'ruangan'		=> $data['nama'],
								'history'		=> $cek,
								'status'		=> $sts,
								'aksi'			=> "<a href='#'>
														<button type='button' class='btn btn-primary btn-xs' onclick='barcode($data[id_unit])'>
															<i class='fa fa-qrcode'></i>
														</button>
													</a>
													<a href='#'>
														<button type='button' class='btn btn-success btn-xs' onclick='edit_data($data[id_unit])'>
															<i class='fa fa-pencil'></i>
														</button>
													</a>
													<a href='#'>
														<button type='button' class='btn btn-danger btn-xs' onclick='hapus_data($data[id_unit])'>
															<i class='fa fa-trash-o'></i>
														</button>
													</a>
													"
							);
			$no++;
		}
		echo json_encode($ret);
	}
	
	function cek_jml_tindakan($id_unit, $ex){
		include "../koneksi/koneksi.php";
		$qry = "SELECT COUNT(it.tindakan_id) jml 
				FROM ipl_tindakan it
				LEFT JOIN ipl_aset ia ON ia.aset_id = it.aset_id
				WHERE it.delete_mark = 0 AND ia.ruangan_id = $id_unit";
		$sql = mysql_query($qry);
		$jml = mysql_fetch_assoc($sql);
		//print_r($jml);exit;
		if($jml['jml'] > 0){
			$ret =  "<button type='button' class='btn btn-primary' onclick='get_list_perbaikan($id_unit)'>
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
	
	function add_data(){
		session_start();
		include "../koneksi/koneksi.php";
		
		$d['ins_by']	= $_SESSION['nama'];
		$d['nama'] 		= $_POST['g_nama'];
		$d['status'] 	= $_POST['g_status'];
		
		$query = "insert into unit(nama, aktif)
								value('$d[nama]', $d[status])";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function get_data_edit(){
		include "../koneksi/koneksi.php";
		$query = mysql_query("select id_unit, nama, aktif from unit where id_unit = $_POST[gid]");
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
		$status 	= $_POST['g_status'];
		
		$q = "update unit set
				nama 	= '$nama',
				aktif	= $status
			where id_unit = $id";
		echo mysql_query($q) or die(mysql_error());
	}
	
	function hapus_data(){
		include "../koneksi/koneksi.php";
		$query = "update unit set delete_mark = 1 where id_unit = $_GET[gid]";
		echo mysql_query($query) or die(mysql_error());
	}
	
	function get_qrcode(){
		$directory 	= "../qrcode/qrcode-img/";
		$qr_code 	= glob($directory . "qrcode-ruangan-$_POST[gid].png");
		
		include "../koneksi/koneksi.php";
		$query = mysql_query("select id_unit, nama from unit where id_unit = $_POST[gid]");
		$data = mysql_fetch_array($query);
		
		if($qr_code){
			$ret = array('sts'=>1, 'msg'=>str_replace('../', '', $qr_code[0]), 'nm_aset'=>$data['nama']);
		}else{
			$ret = array('sts'=>0, 'msg'=>'');
		}
		echo json_encode($ret);
	}
	
	function get_list_perbaikan(){
		include "../koneksi/koneksi.php";
		$id_unit = $_GET['id_unit'];
		$select = 'SELECT it.jenis_id, it.petugas_id, ip.nama nm_teknisi, it.tindakan, it.tanggal, ia.nm_aset';
		$query = " FROM ipl_tindakan it
		LEFT JOIN ipl_pengguna ip ON ip.id = it.petugas_id
		LEFT JOIN ipl_aset ia ON ia.aset_id = it.aset_id
		WHERE it.delete_mark = 0
		AND ia.ruangan_id = $id_unit";
		$sql = mysql_query($select.$query." order by it.tindakan_id desc");
		$no = 1;
		$ret['data'] = array();
		while($data = mysql_fetch_array($sql)){
			$ret['data'][] = array(
				'no'		=> $no,
				'ast'		=> $data['nm_aset'],
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
		$where = '';
		$no = 1;
		
		$query = "select id_unit, nama, aktif from unit where delete_mark = 0 AND nama like '%$_GET[cari]%' order by id_unit desc";
		$q = mysql_query($query);
		
		$phpex = new PHPExcel();
		$phpexActive = $phpex->getActiveSheet();
		
		$phpex->getProperties()->setTitle("title")->setDescription("description");
		$phpex->setActiveSheetIndex(0);
		//$phpexActive->setCellValue('A2', 'DATA ULASAN PASIEN');
		$phpexActive->setCellValue('A3', 'NO');
		$phpexActive->setCellValue('B3', 'NAMA RUANGAN');
		$phpexActive->setCellValue('C3', 'PERBAIKAN');
		$phpexActive->setCellValue('D3', 'STATUS');
		
		$phpexActive->getStyle('A3:D3')->applyFromArray(
			array(
				'font' => array(
					'bold' => true
				)
			)
		);
		$phpexActive->getStyle('A3:D3')->applyFromArray(
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
			$cek = cek_jml_tindakan($data['id_unit'], 1);
			
			$phpexActive->setCellValue("A$row", $no);
			$phpexActive->setCellValue("B$row", $data['nama']);
			$phpexActive->setCellValue("C$row", $cek);
			$phpexActive->setCellValue("D$row", $data['aktif'] == 1 ? 'Aktif' : 'Tidak');
			$no++;
		}
		
		$phpexActive->getStyle("A3:D$rakr")->applyFromArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			)
		);
		
		foreach (range('A', 'D') as $columnID) {
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