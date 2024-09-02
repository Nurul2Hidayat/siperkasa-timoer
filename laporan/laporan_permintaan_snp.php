<?php
include '../koneksi/koneksi.php';
if (isset($_SESSION['simrsig']) && $_SESSION['simrsig'] != '') {
    session_destroy();
}
include '../sesi.php';

$r_formatlap = $_POST['formatlap'];

switch ($r_formatlap) {
    case "XLS" :
        header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=laporan.xls");//ganti nama sesuai keperluan
		header("Pragma: no-cache");
		header("Expires: 0");
        break;
        break;
    default :
        Header("Content-Type: text/html");
        break;
}
?>
<!doctype html>
<html class="fixed">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Laporan permintaan modul</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts-->  
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="../assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="../assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<section class="body">
		<section class="panel">
			<header class="panel-heading">
				<?php
					$tanggal		= $_POST['start']; 
					$tanggal2		= $_POST['end'];
					$tgl1			= date("d-m-Y", strtotime("$tanggal"));
					$tgl2			= date("d-m-Y", strtotime("$tanggal2"));
				?>
				<h2 class="panel-title" align="center">LAPORAN PERMINTAAN PERBAIKAN SARANA DAN PRASARANA</h2>
				<h5 align="center">Rumah Sakit Umum Daerah Mohammad Noer Pamekasan</h5>
				<h5 align="center">Periode : <?php echo $tgl1;?> s/d <?php echo $tgl2;?></h5>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">TGL MINTA</th>
							<th class="center">UNIT</th>
							<th class="center">PELAPOR</th>
							<th class="center">JENIS</th>
							<th class="center">NOMER SERI</th>
							<th class="center">NAMA, MERK, MODEL</th>
							<th class="center">STATUS</th>
							<th class="center">KERUSAKAN</th>
							<th class="center">PERBAIKAN</th>						
							<th class="center">RESPONTIME</th>
						</tr>
					</thead>
					    <?php
							$tanggal		= $_POST['start']; 
							$tanggal2		= $_POST['end'];
							$barang_pos		= $_POST['barang'];
							
							if ($_POST['status'] == 'semua'){
								$filter = "";
							}else if ($_POST['status'] == 'belum'){ 
								$filter = "AND a.status = 'belum'";
							}else if ($_POST['status'] == 'pending'){ 
								$filter = "AND a.status = 'pending'";
							}else if ($_POST['status'] == 'sudah'){
								$filter = "AND a.status = 'sudah'";
							}
							
							if ($barang_pos	 == 'semua'){
								$barang = "";
							}else{ 
								$barang = "AND a.jenis = '$barang_pos'";
							}
							
							$sql_isi = "SELECT 
											a.id, 
											a.tanggal_minta,
											u.nama AS unit, 
											a.pelapor, 
											a.jenis, 
											a.no_series, 
											a.nama_merk_model, 
											a.kerusakan, 
											a.perbaikan,
											a.respontime, 
											a.status
										FROM permintaan_snp a
										INNER JOIN unit u ON u.id_unit = a.id_unit
										WHERE a.TANGGAL_MINTA BETWEEN '$tanggal' and '$tanggal2'
											AND STATUS_MINTA = 1
											$filter 
											$barang
										ORDER BY TANGGAL_MINTA ASC";
							$res_isi = mysql_query($sql_isi);
							$no=0;
							while($rows_isi = mysql_fetch_array($res_isi)){						
								$unit_nama = strtoupper($rows_isi['unit']);	
							
							$no++;
						?>
					<tbody>
						<tr class="gradeX">
							<td class="center" width="50"><?=$no?></td>			
							<td class="center" width="100"><?=$rows_isi["tanggal_minta"]?></td>			
							<td width="200"><?=$unit_nama?></td>
							<td width="300"><?=$rows_isi["pelapor"]?></td>
							<td width="150"><?=$rows_isi["jenis"]?></td>
							<td width="300"><?=$rows_isi["no_series"]?></td>
							<td class="center" width="300"><?=$rows_isi["nama_merk_model"]?></td>	
							<td class="center" width="150"><?=$rows_isi["status"]?></td>
							<td width="300"><?=$rows_isi["kerusakan"]?></td>
							<td width="300"><?=$rows_isi["perbaikan"]?></td>
							<td width="300"><?=$rows_isi["respontime"]?></td>
						</tr>
						<?php
						}	
						?>
					</tbody>
				</table>
			</div>
		</section>												
		</section>

		<!-- Vendor -->
		<script src="../assets/vendor/jquery/jquery.js"></script>
		<script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="../assets/vendor/select2/select2.js"></script>
		<script src="../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="../assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="../assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="../assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="../assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
	</body>
</html>