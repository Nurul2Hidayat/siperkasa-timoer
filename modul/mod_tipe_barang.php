<header class="page-header">
	<h2>Tipe Barang</h2>
</header>
<?php
switch(@$_GET['act']){
default:
?>
<!-- Tambah -->
<div class="row">
	<div class="col-md-5">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Tipe Barang</h5>
			</header>		
            <form class="form-horizontal" method="POST" action="./aksi.php?module=tipe_barang&act=input">
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Barang<span class="required"></span></label>
						<div class="col-sm-8">
							<select data-plugin-selectTwo class="form-control populate" name="id_barang">
								<?php
									$tampil=mysql_query("SELECT * FROM `barang` WHERE aktif ='1' ORDER BY nama");
									while($r=mysql_fetch_array($tampil)){
										$barang_nama = strtoupper($r['nama']);
										echo "<option value=$r[id_barang]>$barang_nama</option>";
										}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Tipe</span></label>
						<div class="col-sm-8">
							<input type="text" name="tipe" class="form-control"/>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=tipe_barang"><button type="button" class="btn btn-warning">Reset</button></a>
				</footer>
            </form>
		</section> 
	</div>
<?php
break;

	
//edit 
case "edit":
	$edit = mysql_query("SELECT * FROM `tipe_barang` WHERE id ='$_GET[id]'");
	$row  = mysql_fetch_array($edit);	
?>
<div class="row">
	<div class="col-md-5">
		<section class="panel">
			<header class="panel-heading portlet-handler">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Tipe Barang</h5>
			</header>
            <form class="form-horizontal" method="POST" action="./aksi.php?module=tipe_barang&act=update">
				<input type="hidden" name="id" value="<?php echo $row['id'];?>" class="form-control"/>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Barang<span class="required"></span></label>
						<div class="col-sm-8">
							<select data-plugin-selectTwo class="form-control populate" name="id_barang">
								<?php
									$tampil=mysql_query("SELECT * FROM `barang` WHERE aktif ='1' ORDER BY nama");
									while($w=mysql_fetch_array($tampil)){
									$barang_nama = strtoupper($w['nama']);
									
									if ($row[id_barang]==$w[id_barang]){
										echo "<option value=$w[id_barang] selected>$barang_nama</option>";
										}
									else{
											echo "<option value=$w[id_barang]>$barang_nama</option>";
										}
									}
									echo "</select>";
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Tipe</span></label>
						<div class="col-sm-8">
							<input type="text" name="tipe" value="<?php echo $row['tipe'];?>" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Aktif</label>
						<div class="col-sm-8">
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
					<a href="?module=tipe_barang"><button type="button" class="btn btn-warning">Reset</button></a>
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
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Tipe Barang</h5>
			</header>			
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none" id="datatable-default">
				<thead>
					<tr>
						<th class="center">NO</th>
						<th class="center">NAMA</th>
						<th class="center">TIPE</th>
						<th class="center">AKTIF</th>
						<th class="center">AKSI</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$data = mysql_query("SELECT t.id, t.tipe, t.aktif, b.id_barang, b.nama AS barang 
											FROM `tipe_barang` t
											INNER JOIN `barang` b ON b.id_barang = t.id_barang
											ORDER BY t.id DESC");
						$no = 1;
						while ($r = mysql_fetch_array($data)){
						$barang_nama = strtoupper($r['barang']);
						$tipe_nama = strtoupper($r['tipe']);
					?>
					<tr>
						<td class="center"><?php echo $no;?></td>
						<td><?php echo $barang_nama;?></td>
						<td><?php echo $tipe_nama;?></td>
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
						<td class="center">
							<a href="?module=tipe_barang&act=edit&id=<?php echo $r["id"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a>
						</td>
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
