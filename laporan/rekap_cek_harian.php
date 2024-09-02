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

		<title>Rekap checklist</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
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
					$tgl		= $_POST['tanggal'];
					$bln		= date('m', strtotime($tgl)); //Mengambil bulan saat ini
					$bln_view	= date('F', strtotime($tgl)); //Mengambil bulan saat ini
					$thn		= date('Y', strtotime($tgl)); //Mengambil bulan saat ini
					$tanggal 	= cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
				?>
				<h2 class="panel-title" align="center">REKAP CHECKLIST BULANAN</h2>
				<h5 align="center">Rumah Sakit Umum Daerah Mohammad Noer Pamekasan</h5>
				<h5 class="panel" align="center">Bulan : <?php echo $bln_view;?> Tahun : <?php echo $thn;?></h5>
			</header>
			<div class="panel-body">
				<table class="table table-bordered mb-none">
					<thead>
						<tr>
							<th width="50" rowspan='2' align="center">No</th>
							<th width="250" rowspan='2' align="center">KEGIATAN</th>
						</tr>
						<tr>
							<?php
								for ($i=01; $i < $tanggal+1; $i++) { 
								  echo "<th>$i</th>";
								}
							?>
							  </tr>
					</thead>
					<tbody>
					    <?php
							$sql_isi = "SELECT * FROM checklist ORDER BY id_checklist ASC";											
							$res_isi = mysql_query($sql_isi);
							$no = 1;
							while($rows_isi = mysql_fetch_array($res_isi)){								
							$kata_nama = strtoupper($rows_isi['nama']);							
						?>
					
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $kata_nama;?></td>
								<?php
									for ($i=01; $i < $tanggal+1; $i++) {  
										$mulai	=	sprintf("%02d%02d%02d",$thn,$bln,$i);
										$format = date('Y-m-d', strtotime($mulai));
										$tampil = mysql_query("SELECT *
															FROM cek_harian h
															INNER JOIN checklist c ON c.id_checklist = h.id_checklist
															WHERE h.id_checklist = '$rows_isi[id_checklist]'
															AND h.tgl = '$format'
															ORDER BY h.id ASC");
										$r = mysql_fetch_array($tampil);
										$checklist = $rows_isi['id_checklist'];
										if($r ['id_checklist'] == $checklist){ 
													 $id_checklist = '<span style="font-family: wingdings; font-size: 120%;">&#10004;</span>';
												}  
												else{ 
													 $id_checklist  = '';				 
												} 
										echo "<td align='center'>$id_checklist<br></td>";
									}
								?>
						</tr>
						<?php
						$no++;
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