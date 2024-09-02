<header class="page-header">
	<h2>Master Checklist</h2>
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
				<h5><i class="fa fa-edit"></i> Form Checklist</h5>
			</header>
            <form class="form-horizontal" method="POST" action="./aksi.php?module=checklist&act=input">
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama</span></label>
						<div class="col-sm-8">
							<input type="text" name="nama" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Aktif</label>
						<div class="col-sm-8">
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
					<a href="?module=checklist"><button type="button" class="btn btn-warning">Reset</button></a>
				</footer>
            </form>
		</section> 
	</div>
<?php
break;

	
//edit 
case "edit":
	$edit = mysql_query("SELECT * FROM `checklist` WHERE id_checklist='$_GET[id]'");
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
            <form class="form-horizontal" method="POST" action="./aksi.php?module=checklist&act=update">
				<input type="hidden" name="id" value="<?php echo $row['id_checklist'];?>" class="form-control"/>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama</span></label>
						<div class="col-sm-7">
							<input type="text" name="nama" value="<?php echo $row['nama'];?>" class="form-control"/>
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
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
							<button type="submit" class="btn btn-info">Submit </button>
							<a href="?module=checklist"><button type="button" class="btn btn-warning">Reset</button></a>
						</div>
					</div>
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
				<h5><i class="fa fa-table"></i> Checklist</h5>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none" id="datatable-default">
				<thead>
					<tr>
						<th class="center">NO</th>
						<th class="center">NAMA</th>
						<th class="center">AKTIF</th>
						<th class="center">AKSI</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$data = mysql_query("SELECT *
											FROM `checklist` 								
											ORDER BY id_checklist DESC");
						$no = 1;
						while ($r = mysql_fetch_array($data)){
						$check_nama = strtoupper($r['nama']);

					?>
					<tr>
						<td class="center"><?php echo $no;?></td>
						<td><?php echo $check_nama;?></td>
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
						<td class="center"><a href="?module=checklist&act=edit&id=<?php echo $r["id_checklist"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a></td>
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
