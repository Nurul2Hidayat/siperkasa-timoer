<header class="page-header">
	<h2>Master Barang</h2>
</header>
<?php
switch(@$_GET['act']){
default:
	$nomor		= mysql_query("SELECT kode FROM `barang` ORDER BY id_barang DESC LIMIT 1");
	$r_no		= mysql_fetch_array($nomor);	
	$kode		= $r_no['kode'] + 1;
	$nokode 	= sprintf("%06d",$kode);
?>
<!-- Tambah -->
<div class="row">
	<div class="col-md-5">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Barang</h5>
			</header>
            <form class="form-horizontal" method="POST" action="./aksi.php?module=barang&act=input">
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Kode</span></label>
						<div class="col-sm-7">
							<input type="text" name="kode" class="form-control" value="<?php echo $nokode;?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama</span></label>
						<div class="col-sm-7">
							<input type="text" name="nama" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Jenis</span></label>
						<div class="col-sm-7">
							<select class="form-control" name="jenis"/>
								<option value="Hardware">Hardware</option>
								<option value="Software">Software</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Aktif</label>
						<div class="col-sm-7">
							<div class="radio-custom">
								<input type="radio" name="aktif" value="1" checked>
								<label>Ya</label>
							</div>
							<div class="radio-custom radio-danger">
								<input type="radio" name="aktif" value="0"/>
								<label>Tidak</label>
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=barang"><button type="button" class="btn btn-warning">Reset</button></a>
				</footer>
            </form>
		</section> 
	</div>
<?php
break;

	
//edit 
case "edit":
	$edit = mysql_query("SELECT * FROM `barang` WHERE id_barang ='$_GET[id]'");
	$row  = mysql_fetch_array($edit);	
?>
<div class="row">
	<div class="col-md-5">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Barang</h5>
			</header>		
            <form class="form-horizontal" method="POST" action="./aksi.php?module=barang&act=update">
				<input type="hidden" name="id" value="<?php echo $row['id_barang'];?>" class="form-control"/>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Kode</span></label>
						<div class="col-sm-7">
							<input type="text" name="kode" class="form-control" value="<?php echo $row['kode'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama</span></label>
						<div class="col-sm-7">
							<input type="text" name="nama" value="<?php echo $row['nama'];?>" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Jenis</span></label>
						<div class="col-sm-4">
							<select class="form-control" name="jenis"/>
							<?php
								if($row['jenis']== 'Hardware'){
							?>
								<option value="Hardware">Hardware</option>
								<option value="Software">Software</option>
							<?php 
								} else{
							?>
								<option value="Software">Software</option>
								<option value="Hardware">Hardware</option>
							<?php
								}
							?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Aktif</label>
						<div class="col-sm-7">
							<div class="radio-custom">
								<input type="radio" name="aktif" value="1" <?php echo ($row['aktif']== '1') ?  "checked" : "" ;  ?>/>
								<label>Ya</label>
							</div>
							<div class="radio-custom radio-danger">
								<input type="radio" name="aktif" value="0" <?php echo ($row['aktif']== '0') ?  "checked" : "" ;  ?>/>
								<label>Tidak</label>
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=barang"><button type="button" class="btn btn-warning">Reset</button></a>
				</footer>
            </form>
		</section> 
	</div>
<?php
break;
}
?>
	<div class="col-md-7">
		<section class="panel">
			<header class="panel-heading portlet-handler">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Barang</h5>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none" id="datatable-default">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">KODE</th>
							<th class="center">NAMA</th>
							<th class="center">JENIS</th>
							<th class="center">AKTIF</th>
							<th class="center">AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$data = mysql_query("SELECT *
												FROM `barang` 								
												ORDER BY id_barang DESC");
							$no = 1;
							while ($r = mysql_fetch_array($data)){
							$barang_nama = strtoupper($r['nama']);
							$jenis_nama = strtoupper($r['jenis']);

						?>
						<tr>
							<td class="center"><?php echo $no;?></td>
							<td><?php echo $r['kode'];?></td>
							<td><?php echo $barang_nama;?></td>
							<td><?php echo $jenis_nama;?></td>
							<td class="center">
								<?php
									if($r['aktif']== '1'){
								?>
									<button type="button" class="btn btn-info btn-xs"><i class="fa fa-check"></i></button>
								<?php
									}else{
								?>
									<button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
								<?php
									}
								?>
							</td>
							<td class="center"><a href="?module=barang&act=edit&id=<?php echo $r["id_barang"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a></td>
						</tr>
						<?php
							$no++;
							}
						?>
					</tbody>
				</table>
			</div>
		</section>
	</div>
<div>
<!-- and tabel --> 
