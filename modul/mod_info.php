<header class="page-header">
	<h2>Info Pengguna</h2>
</header>
<?php
switch(@$_GET['act']){
default:
	$sql = mysql_query("SELECT ip.pegawai_id, un.nama nm_ruangan, gp.nama nm_role
						FROM ipl_pengguna ip
						LEFT JOIN unit un ON un.id_unit = ip.ruangan_id
						LEFT JOIN `group` gp ON gp.id_group = ip.role_id
						WHERE id = $_SESSION[id_pengguna]");
	$row  = mysql_fetch_array($sql);
	$sdm  = get_pegawai($row['pegawai_id']);
?>
<div class="row">
	<div class="col-md-7">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-user"></i> Informasi Pengguna</h5>
			</header>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-3 control-label">Nama</span></label>
					<div class="col-sm-7">
						<input type="text" name="nama" value="<?php echo $sdm['nm_pegawai'];?>" class="form-control" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">NIP</span></label>
					<div class="col-sm-7">
						<input type="text" name="nama" value="<?php echo $sdm['NIP'];?>" class="form-control" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">HP</span></label>
					<div class="col-sm-7">
						<input type="text" name="username" value="<?php echo $sdm['HP'];?>" class="form-control" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Ruangan</span></label>
					<div class="col-sm-7">
						<input type="text" name="username" value="<?php echo $row['nm_ruangan'];?>" class="form-control" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Role User<span class="required"></span></label>
					<div class="col-sm-7">
						<input type="text" name="id_unit" value="<?php echo $row['nm_role'];?>" class="form-control" readonly>
					</div>
				</div>
			</div>
		</section> 
	</div>
<?php
break;
}

function get_pegawai($id){
	include __DIR__."/../koneksi/koneksi_sdm.php";
	$sql = mysql_query("SELECT p.NIP, CONCAT_WS (' ', mgd.nama_gelar,p.NAMA,mgb.nama_gelar) AS nm_pegawai , p.LP, p.TMLAHIR, p.TGLAHIR, p.AGAMA, p.HP
						FROM pegawai p
						LEFT JOIN ms_gelar mgd ON p.gelar_dpn = mgd.gelar_id
						LEFT JOIN ms_gelar mgb ON p.gelar_blk = mgb.gelar_id
						WHERE p.PEGAWAI_ID = $id");
	$row  = mysql_fetch_array($sql);
	return $row;
}
?>
<div>
