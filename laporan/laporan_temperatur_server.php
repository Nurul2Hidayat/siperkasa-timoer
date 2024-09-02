<?php
include '../koneksi/koneksi.php';
if (isset($_SESSION['simrsig']) && $_SESSION['simrsig'] != '') {
    session_destroy();
}
include '../sesi.php';

function getDatesFromRange($start, $end, $format = 'Y-m-d') {
      
    // Declare an empty array
    $array = array();
      
    // Variable that store the date interval
    // of period 1 day
    $interval = new DateInterval('P1D');
  
    $realEnd = new DateTime($end);
    $realEnd->add($interval);
  
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
  
    // Use loop to store date into array
    foreach($period as $date) {                 
        $array[] = $date->format($format); 
    }
  
    // Return the array elements
    return $array;
}

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

		<title>Laporan Temperatur Server</title>
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
				<h2 class="panel-title" align="center">LAPORAN TEMPERATUR SERVER</h2>
				<h5 align="center">Rumah Sakit Umum Daerah Mohammad Noer Pamekasan</h5>
				<h5 align="center">Periode : <?php echo $tgl1;?> s/d <?php echo $tgl2;?></h5>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none">
					<thead>
						<tr>
							<th class="center">TGL</th>
							<?php
								$period = getDatesFromRange($tgl1, $tgl2);
								foreach($period as $k=>$v){
									echo '<th class="center">'.$v.'</th>';
								}
							?>
						</tr>
					</thead>
					    <?php
							$tanggal		= $_POST['start']; 
							$tanggal2		= $_POST['end'];
							
							$sql_isi = "SELECT 
											tanggal, suhu, kelembapan 
										FROM server_temperatur 
										WHERE deletemark = 0
										AND tanggal BETWEEN '$tanggal' AND '$tanggal2'
										ORDER BY tanggal";
							$res_isi = mysql_query($sql_isi);
							$ret = array();
							$r = 0;
							
							while($rows_isi = mysql_fetch_array($res_isi)){
								foreach($period as $k=>$v){
									if($rows_isi['tanggal'] == $v){
										$ret['suhu'][$k]		= array($rows_isi['tanggal'],$rows_isi['suhu']);
										$ret['kelembapan'][$k]	= array($rows_isi['tanggal'],$rows_isi['kelembapan']);
									}else{
										if(!isset($ret['suhu'][$k])){
											$ret['suhu'][$k]		= array(0,'-');
										}
										
										if(!isset($ret['kelembapan'][$k])){
											$ret['kelembapan'][$k]	= array(0,'-');
										}
									}
								}
								$r++;
							}
							
							//echo'<pre>';print_r($ret);
						?>
					<tbody>
							<?php						
							
								foreach($ret as $k=>$v){
									echo '<tr class="gradeX">
											<td class="center" width="50">'.$k.'</td>';
									foreach($v as $vv){
										$nm = '';
										if($vv[1] != '-'){
											if($k == 'suhu'){
												$nm = '&#176;C';
											}else{
												$nm = '%';
											}
										}								
										echo '<td class="center" width="50">'.$vv[1].$nm.'</td>';
									}
									echo'</tr>';
								}
							?>
						
						<?php
						//}
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