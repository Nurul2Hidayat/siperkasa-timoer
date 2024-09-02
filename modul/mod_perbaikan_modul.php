<script>
	function lihat() {
		var status		= parseInt($("#status").val());
        window.location = 'media.php?module=perbaikan_modul&status=' + status;
    }
</script>
<header class="page-header">
	<h2>Perbaikan Modul</h2>					
</header>
<?php
switch(@$_GET['act']){
default:
$kode	= isset($_GET['kd']) ? $_GET['kd'] : '';

$status		= isset($_GET['status']) ? $_GET['status'] : '';
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Perbaikan Modul</h5>
			</header>
			<form class="form-horizontal" method="POST" enctype='multipart/form-data' action='./aksi.php?module=perbaikan_modul&act=input'>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Tanggal<span class="required"></span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control name="tgl" value="<?php echo $tgl;?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Modul<span class="required"></span></label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="id_barang">
								<?php
									$tampil=mysql_query("SELECT * FROM barang WHERE jenis ='Software' ORDER BY nama");
									while($r=mysql_fetch_array($tampil)){
										$barang_nama = strtoupper($r['nama']);
										echo "<option value=$r[id_barang]>$barang_nama</option>";
										}
										echo "</select>";
								?>
						</div>
					</div>		
					<div class="form-group">
						<label class="col-sm-3 control-label">Unit<span class="required"></span></label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="id_unit">
								<?php
									$tampil=mysql_query("SELECT * FROM unit ORDER BY nama");
									while($r=mysql_fetch_array($tampil)){
										$unit_nama = strtoupper($r['nama']);
										echo "<option value=$r[id_unit]>$unit_nama</option>";
										}
										echo "</select>";
								?>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 control-label">Perbaikan<span class="required"></span></label>
						<div class="col-sm-7">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="perbaikan"></textarea>
						</div>
					</div>				
					<div class="form-group">
						<label class="col-md-3 control-label">File Upload</label>
						<div class="col-md-8">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
									<div class="uneditable-input">
										<i class="fa fa-file fileupload-exists"></i>
										<span class="fileupload-preview"></span>
									</div>
									<span class="btn btn-default btn-file">
										<span class="fileupload-exists">Change</span>
										<span class="fileupload-new">Select file</span>
										<input type="file" name="fupload">
									</span>
									<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=agendasimrs"><button type="button" class="btn btn-warning">Reset</button></a>
				</footer>
			</form>
		</section>
	</div>
</div>
<?php
break;

//Edit perbaikan modul
case "edit":
	$edit		= mysql_query("SELECT * FROM aplikasi WHERE id ='$_GET[id]'");
	$r_edit		= mysql_fetch_array($edit);	
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Perbaikan Modul</h5>
			</header>
			<form class="form-horizontal" method="POST" enctype='multipart/form-data' action='./aksi.php?module=perbaikan_modul&act=update'>
				<div class="panel-body">
					<input type="hidden" class="form-control" name="id" value="<?php echo $r_edit['id'];?>" readonly>
					<div class="form-group">
						<label class="col-sm-3 control-label">Tanggal<span class="required"></span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="tgl" value="<?php echo $r_edit['tgl'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Modul<span class="required"></span></label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="id_barang">
								<?php
									$tampil=mysql_query("SELECT * FROM barang WHERE jenis ='Software' ORDER BY nama");
									while($w=mysql_fetch_array($tampil)){
										$barang_nama = strtoupper($w['nama']);
									if ($r_edit[id_barang]==$w[id_barang]){
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
						<label class="col-sm-3 control-label">Unit<span class="required"></span></label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="id_unit">
								<?php
									$tampil=mysql_query("SELECT * FROM `unit` ORDER BY nama");
									while($w=mysql_fetch_array($tampil)){
										$unit_nama = strtoupper($w['nama']);
									if ($r_edit[id_unit]==$w[id_unit]){
										echo "<option value=$w[id_unit] selected>$unit_nama</option>";
										}
									else{
											echo "<option value=$w[id_unit]>$unit_nama</option>";
										}
									}
									echo "</select>";
								?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 control-label">Perbaikan<span class="required"></span></label>
						<div class="col-sm-7">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="perbaikan"><?php echo $r_edit['perbaikan'];?></textarea>
						</div>
					</div>				
					<div class="form-group">
						<label class="col-md-3 control-label">File Upload</label>
						<div class="col-md-8">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
									<div class="uneditable-input">
										<i class="fa fa-file fileupload-exists"></i>
										<span class="fileupload-preview"></span>
									</div>
									<span class="btn btn-default btn-file">
										<span class="fileupload-exists">Change</span>
										<span class="fileupload-new">Select file</span>
										<input type="file" name="fupload">
									</span>
									<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a class="btn btn-warning" href="javascript:window.history.back();">Cancel</a>
				</footer>
			</form>
		</section>
	</div>
</div>
<?php
break;

//Verif perbaikan modul
case "verif":
	$edit		= mysql_query("SELECT * FROM aplikasi WHERE id ='$_GET[id]'");
	$r_edit		= mysql_fetch_array($edit);	
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Perbaikan Modul</h5>
			</header>
			<form class="form-horizontal" method="POST" enctype='multipart/form-data' action='./aksi.php?module=perbaikan_modul&act=verif'>
				<div class="panel-body">
					<input type="hidden" class="form-control" name="id" value="<?php echo $r_edit['id'];?>" readonly>
					<input type="hidden" class="form-control" name="tgl" value="<?php echo $r_edit['tgl'];?>" readonly>
					<div class="form-group">
						<label class="col-sm-3 control-label">Tanggal Update<span class="required"></span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="tgl_update" value="<?php echo $r_edit['tgl'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Status</label>
						<div class="col-md-3">
							<select data-plugin-selectTwo class="form-control populate" name="status">
								<option value="<?php echo $r_edit["status"]; ?>">
									<?php
										if ($r_edit['status'] == '0'){	
									?>
											BELUM</option>
								
								<option value="1">SUDAH</option>
								<option value="2">PENDING</option>			
									<?php
										} elseif ($r_edit['status'] == '1'){
									?>
											SUDAH</option>
								<option value="0">BELUM</option>
								<option value="2">PENDING</option>
									<?php
										} elseif ($r_edit['status'] == '2'){
									?>
											PENDING</option>
								<option value="0">BELUM</option>
								<option value="1">SUDAH</option>
									<?php
										} 
									?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Keterangan<span class="required"></span></label>
						<div class="col-sm-7">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="keterangan"><?php echo $r_edit['keterangan'];?></textarea>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a class="btn btn-warning" href="javascript:window.history.back();">Cancel</a>
				</footer>
			</form>
		</section>
	</div>
</div>
<?php
break;    
}
$status		= isset($_GET['status']) ? $_GET['status'] : '';
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<select class="form-control" id="status" name="status" onchange="lihat()">
						<option <?php if ($status=="0") echo 'selected'; ?> value="0">Belum</option>
						<option <?php if ($status=="1") echo 'selected'; ?> value="1">Sudah</option>
						<option <?php if ($status=="2") echo 'selected'; ?> value="2">Pending</option>
					</select>
				</div>
				<h5><i class="fa fa-table"></i> Kegiatan</h5>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none" id="datatable-default">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">TANGGAL</th>
							<th class="center">UNIT</th>
							<th class="center">NAMA</th>
							<th class="center">PERBAIKAN</th>
							<th class="center">FILE</th>
							<th class="center">STATUS</th>
							<th class="center">AKSI</th>
						</tr>
					</thead>
					<tbody>	
					<?php
						if ($status == '0'){ 
							$filter = "WHERE a.status='0'";
						}else if ($status == ''){
							$filter = "WHERE a.status='0'";
						}else if ($status == '1'){ 
							$filter = "WHERE a.status='1'";
						}else if ($status == '2'){
							$filter = "WHERE a.status='2'";
						}
					
						$tampil = mysql_query("SELECT a.id, a.tgl, a.perbaikan, a.direktori, a.ukuran_file, b.nama AS barang, u.nama AS unit
												FROM aplikasi a
												INNER JOIN barang b ON b.id_barang = a.id_barang
												INNER JOIN unit u ON u.id_unit = a.id_unit
												$filter 
												ORDER BY tgl DESC");
						$no=1;
						while ($row = mysql_fetch_array($tampil)){
							$barang_nama = strtoupper($row['barang']);							
							$unit_nama = strtoupper($row['unit']);							
					?>
						<tr>
							<td class="center" width="50"><?php echo $no;?></td>			
							<td class="center" width="100"><?php echo $row["tgl"];?></td>			
							<td><?php echo $barang_nama;?></td>			
							<td><?php echo $unit_nama;?></td>
							<td><?php echo $row["perbaikan"];?></td>	
							<td class="center" width="50">
								<?php
									if ($row['ukuran_file'] != '0'){ 
										echo"<a href='$row[direktori]' target='_blank'><button type='button' class='btn btn-info btn-xs'><i class='fa fa-download '></i></button></a>";	
									}else{
										
									}
								?>	
							</td>							
							<td class="center" width="100">
								<?php if ($status == '0'){ ?> BELUM
								<?php }else if ($status == ''){ ?> BELUM
								<?php }else if ($status == '1'){ ?> SUDAH
								<?php }else if ($status == '2'){ ?> PENDING
								<?php }?>	
							</td>
							<td class="center" width="80">
								<a href="?module=perbaikan_modul&status=<?php echo $status;?>&act=edit&id=<?php echo $row["id"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a>
								
								<a href="?module=perbaikan_modul&status=<?php echo $status;?>&act=verif&id=<?php echo $row["id"];?>"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-check-square-o"></i></button></a>
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
</div>
