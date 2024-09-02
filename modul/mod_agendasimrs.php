<script>
	function lihat() {
		var status		= parseInt($("#status").val());
        window.location = 'media.php?module=agendasimrs&status=' + status;
    }
</script>
<header class="page-header">
	<h2>Agenda SIMRS</h2>					
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
				<h5><i class="fa fa-edit"></i> Form Agenda</h5>
			</header>
			<form class="form-horizontal" method="POST" action='./aksi.php?module=agendasimrs&act=input'>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Tgl Acara<span class="required"></span></label>
						<div class="col-sm-3">
							<input type="text" data-plugin-datepicker class="form-control" name="tgl" value="<?php echo $tgl;?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Agenda</span></label>
						<div class="col-sm-7">
							<input type="text" name="agenda" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Peserta<span class="required"></span></label>
						<div class="col-sm-7">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 100, "codemirror": { "theme": "ambiance" } }' name="peserta"></textarea>
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

//Edit agenda
case "edit":
	$edit		= mysql_query("SELECT * FROM agenda_simrs WHERE id ='$_GET[id]'");
	$r_edit		= mysql_fetch_array($edit);	
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Agenda</h5>
			</header>
			<form class="form-horizontal" method="POST" enctype='multipart/form-data' action='./aksi.php?module=agendasimrs&act=update'>
				<input type="hidden" name="id" value="<?php echo $r_edit['id'];?>" class="form-control"/>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Tgl Acara<span class="required"></span></label>
						<div class="col-sm-3">
							<input type="text" data-plugin-datepicker class="form-control" name="tgl" value="<?php echo $r_edit['tgl'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Agenda</span></label>
						<div class="col-sm-7">
							<input type="text" name="agenda" value="<?php echo $r_edit['agenda'];?>" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Peserta<span class="required"></span></label>
						<div class="col-sm-7">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 100, "codemirror": { "theme": "ambiance" } }' name="peserta"><?php echo $r_edit['peserta'];?></textarea>
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
				<h5><i class="fa fa-table"></i> Agenda</h5>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none" id="datatable-default">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">TANGGAL</th>
							<th class="center">AGENDA</th>
							<th class="center">PESERTA</th>
							<th class="center">STATUS</th>
							<?php
								if ($status == '1'){ 
							?>
								<th class="center">FILE</th>	
							<?php
								}
							?>
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
					
						$tampil = mysql_query("SELECT * FROM agenda_simrs $filter ORDER BY tgl DESC");
						$no=1;
						while ($row = mysql_fetch_array($tampil)){
						$agenda_nama = strtoupper($row['agenda']);					
					?>
						<tr>
							<td class="center" width="50"><?php echo $no;?></td>			
							<td class="center" width="100"><?php echo $row["tgl"];?></td>			
							<td><?php echo $agenda_nama;?></td>			
							<td><?php echo $row["peserta"];?></td>			
							<td class="center" width="100">
							<?php if ($status == '0'){ ?> BELUM
							<?php }else if ($status == ''){ ?> BELUM
							<?php }else if ($status == '1'){ ?> SUDAH
							<?php }else if ($status == '2'){ ?> PENDING
							<?php }?>	
							</td>
							<?php
								if ($status == '1'){ 
							?>
							<td class="center" width="50">
								<?php echo"<a href='$row[direktori]' target='_blank'><button type='button' class='btn btn-info btn-xs'><i class='fa fa-download '></i></button></a>";?>	
							</td>
							<?php
								}
							?>
							<td class="center" width="50">
								<a href="?module=agendasimrs&status=<?php echo $status;?>&act=edit&id=<?php echo $row["id"];?>"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-check-square-o"></i></button></a>
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
