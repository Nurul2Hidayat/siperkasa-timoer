<header class="page-header">
	<h2>Group Akses</h2>
</header>
<?php
switch(@$_GET['act']){
default:
?>
<!-- Tambah -->
<div class="row">
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Group Akses</h5>
			</header>			
			<form class="form-horizontal" method="POST" action="./aksi.php?module=group&act=input">
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Group</span></label>
						<div class="col-sm-6">
							<input type="text" name="nama" class="form-control"/>
						</div>
					</div>
					<br>					
				</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=group"><button type="button" class="btn btn-warning">Reset</button></a>
				</footer>
			</form>
		</section>
	</div>
<?php
break;

	
//edit 
case "edit":
	$edit = mysql_query("SELECT * FROM `group` WHERE id_group='$_GET[id]'");
	$row  = mysql_fetch_array($edit);	
?>
<div class="row">
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Group Akses</h5>
			</header>			
			<form class="form-horizontal" method="POST" action="./aksi.php?module=group&act=update">
				<input type="hidden" name="id" value="<?php echo $row['id_group'];?>"/>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Group</span></label>
						<div class="col-sm-6">
							<input type="text" name="nama" value="<?php echo $row['nama'];?>" class="form-control"/>
						</div>
					</div>						
				</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=group"><button type="button" class="btn btn-warning">Reset</button></a>
				</footer>
			</form>
		</section>
	</div>
<?php
break;


//akses
case "akses":
	$akses = mysql_query("SELECT * FROM `group` WHERE id_group='$_GET[id]'");
	$row  = mysql_fetch_array($akses);
	$group_nama = strtoupper($row['nama']);	
?>
<div class="row">
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-gears"></i> Setting Hak Akses</h5>
			</header>	
		<!-- tabel -->
            <form class="form-horizontal" method="POST" action="./aksi.php?module=group&act=akses">
                <input type="hidden" name="id" value="<?php echo $row["id_group"]; ?>">
				<div class="panel-body">
					<ul>
						<?php
							$sql_isi = "SELECT m.*,IF(T1.id_modul = m.id_modul,1,0) NL
										FROM modul m
										LEFT JOIN (SELECT g.id_group, a.id_modul
													FROM `group` g
													INNER JOIN akses a ON g.id_group = a.id_group
													WHERE g.id_group = '$row[id_group]') T1 ON m.id_modul = T1.id_modul
										WHERE m.induk='0'
										AND m.aktif='1'
										GROUP BY m.id_modul
										ORDER BY m.urut ASC";
							$res_isi = mysql_query($sql_isi);
							while($rows_isi = mysql_fetch_array($res_isi)){
								$id=$rows_isi['id_modul'];
								$checked="";
								if($rows_isi['NL']==1)$checked="checked='checked'";
						?>
							<li>
								<input name="id_group[]" type="hidden" value="<?php echo $row['id_group'];?>" />
								<input type="checkbox" id="akses" name="akses[]" <?php echo $checked;?> value="<?php echo $id ?>" />
								<b><?php echo $rows_isi["nama_modul"];?></b>
								<ul>
									<?php
										$anak_data = mysql_query("SELECT m.*,IF(T1.id_modul = m.id_modul,1,0) NL
																FROM modul m
																LEFT JOIN (SELECT g.id_group, a.id_modul
																			FROM `group` g
																			INNER JOIN akses a ON g.id_group = a.id_group
																			WHERE g.id_group = '$row[id_group]') T1 ON m.id_modul = T1.id_modul
																WHERE m.induk = '$rows_isi[id_modul]'
																AND m.aktif='1'");
										while ($anak = mysql_fetch_array($anak_data)){
											$id_anak=$anak['id_modul'];
											$checked_anak="";
											if($anak['NL']==1)$checked_anak="checked='checked'";
									?>
										<li>
											
											<input name="id_group_anak[]" type="hidden" value="<?php echo $row['id_group'];?>" />
											<input type="checkbox" id="akses_anak" name="akses_anak[]" <?php echo $checked_anak;?> value="<?php echo $id_anak ?>" />
											<?php echo $anak["nama_modul"];?>
										</li>
									<?php
										}
									?>
								</ul>
							</li>
						<?php
							}
						?>
					</ul>
                </div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=group"><button type="button" class="btn btn-warning">Kembali</button></a>
				</footer>
            </form>
		</section>
	</div>
<?php
break;              
}
?>
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Group Akses</h5>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none" id="datatable-default">
					<thead>
						<tr>
							<th class="center">NO</th>
							<th class="center">GROUP</th>
							<th class="center">AKSES</th>
							<th class="center">AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$data = mysql_query("SELECT * FROM `group` ORDER BY id_group DESC");
							$no = 1;
							while ($r = mysql_fetch_array($data)){
							$kata_nama = strtoupper($r['nama']);
						?>
						<tr>
							<td class="center"><?php echo $no;?></td>
							<td><?php echo $kata_nama;?></td>
							<td class="center"><a href="?module=group&act=akses&id=<?php echo $r["id_group"];?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-cogs"></i></button></a></td>		
							<td class="center"><a href="?module=group&act=edit&id=<?php echo $r["id_group"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a></td>
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
<div
<!-- and tabel --> 
