<script>
	function lihat() {
		var status		= parseInt($("#status").val());
        window.location = 'media.php?module=kegiatan&status=' + status;
    }
</script>
<header class="page-header">
	<h2>Kegiatan SIMRS</h2>					
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
				<h5><i class="fa fa-edit"></i> Form Kegiatan</h5>
			</header>
			<form class="form-horizontal" method="POST" enctype='multipart/form-data' action='./aksi.php?module=kegiatan&act=input'>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Tgl Kegiatan<span class="required"></span></label>
						<div class="col-sm-3">
							<input type="text" data-plugin-datepicker class="form-control" name="tgl" value="<?php echo $tgl;?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Kegiatan<span class="required"></span></label>
						<div class="col-sm-7">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 100, "codemirror": { "theme": "ambiance" } }' name="kegiatan"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Lokasi<span class="required"></span></label>
						<div class="col-sm-7">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 100, "codemirror": { "theme": "ambiance" } }' name="lokasi"></textarea>
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
					<a href="?module=kegiatan"><button type="button" class="btn btn-warning">Reset</button></a>
				</footer>
			</form>
		</section>
	</div>
</div>
<?php
break;

//Edit agenda
case "edit":
	$edit		= mysql_query("SELECT * FROM kegiatan WHERE id_kegiatan ='$_GET[id]'");
	$r_edit		= mysql_fetch_array($edit);	
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Kegiatan</h5>
			</header>
			<form class="form-horizontal" method="POST" enctype='multipart/form-data' action='./aksi.php?module=kegiatan&act=update'>
				<input type="hidden" name="id" value="<?php echo $r_edit['id_kegiatan'];?>" class="form-control"/>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Tgl Kegiatan<span class="required"></span></label>
						<div class="col-sm-3">
							<input type="text" data-plugin-datepicker class="form-control" name="tgl" value="<?php echo $r_edit['tgl'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Kegiatan<span class="required"></span></label>
						<div class="col-sm-7">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 100, "codemirror": { "theme": "ambiance" } }' name="kegiatan"><?php echo $r_edit['kegiatan'];?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Lokasi<span class="required"></span></label>
						<div class="col-sm-7">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 100, "codemirror": { "theme": "ambiance" } }' name="lokasi"><?php echo $r_edit['lokasi'];?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Status</label>
						<div class="col-md-7">
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
						<label class="col-sm-3 control-label">Hasil<span class="required"></span></label>
						<div class="col-sm-7">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 100, "codemirror": { "theme": "ambiance" } }' name="hasil"><?php echo $r_edit['hasil'];?></textarea>
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
							<th class="center">KEGIATAN</th>
							<th class="center">LOKASI</th>
							<th class="center">FILE</th>
							<th class="center">STATUS</th>
							<th class="center">AKSI</th>
						</tr>
					</thead>
					<tbody>	
					<?php
						if ($status == '0'){ 
							$filter = "WHERE status='0'";
						}else if ($status == ''){
							$filter = "WHERE status='0'";
						}else if ($status == '1'){ 
							$filter = "WHERE status='1'";
						}else if ($status == '2'){
							$filter = "WHERE status='2'";
						}
					
						$tampil = mysql_query("SELECT * FROM kegiatan $filter ORDER BY tgl DESC");
						$no=1;
						while ($row = mysql_fetch_array($tampil)){					
					?>
						<tr>
							<td class="center" width="50"><?php echo $no;?></td>			
							<td class="center" width="100"><?php echo $row["tgl"];?></td>			
							<td><?php echo $row["kegiatan"];?></td>			
							<td><?php echo $row["lokasi"];?></td>
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
							<td class="center" width="50">
								<a href="?module=kegiatan&status=<?php echo $status;?>&act=edit&id=<?php echo $row["id_kegiatan"];?>"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-check-square-o"></i></button></a>
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
