<?php 
	$home = 'Detail Aset';
	include('scan_header.php');
?>

<section role="main" class="content-body">
	<header class="page-header">
		
	</header>
	<!-- start: page -->
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<div class="panel-body">
					<?php
						if($f_tp == 'aset'){
							$query = mysql_query("select 
													tpe.nm_tipe,
													ast.nm_aset,
													ast.kd_barang,
													ast.merk_aset,
													rgn.nama ruangan,
													ast.no_seri,
													ast.tanggal_pembelian,
													sts.nm_status,
													ast.keterangan
												from ipl_aset ast 
												left join ipl_tipe tpe on tpe.tipe_id = ast.tipe_id
												left join unit rgn on rgn.id_unit = ast.ruangan_id
												left join ipl_status sts on sts.status_id = ast.status_id
												where ast.aset_id = $f_id");
						}else{
							
						}
						$data = mysql_fetch_array($query);
					?>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kode Barang</label>
						<div class="col-sm-10">
							<b><?=$data['kd_barang']?></b>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tipe</label>
						<div class="col-sm-10">
							<b><?=$data['nm_tipe']?></b>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nama Aset</label>
						<div class="col-sm-10">
							<b><?=$data['nm_aset']?></b>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Merk</label>
						<div class="col-sm-10">
							<b><?=$data['merk_aset']?></b>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Ruangan</label>
						<div class="col-sm-6">
							<b><?=$data['ruangan']?></b>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nomer Seri</label>
						<div class="col-sm-10">
							<b><?=$data['no_seri']?></b>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tanggal Pembelian</label>
						<div class="col-sm-3">
							<b><?=$data['tanggal_pembelian']?></b>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<b><?=$data['nm_status']?></b>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-4">
							<b><?=$data['keterangan']?></b>
						</div>
						<div class="col-sm-8">&nbsp;</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</section>
<?php include('scan_footer.php');?>