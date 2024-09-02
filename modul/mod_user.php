<header class="page-header">
	<h2>Pengguna</h2>
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
				<h5><i class="fa fa-edit"></i> Form Pengguna</h5>
			</header>
            <form class="form-horizontal" method="POST" action="./aksi.php?module=user&act=input">
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Username</span></label>
						<div class="col-sm-7">
							<input type="text" name="username" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Password</span></label>
						<div class="col-sm-7">
							<input type="password" name="password" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama</span></label>
						<div class="col-sm-7">
							<input type="text" name="nama" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Unit<span class="required"></span></label>
						<div class="col-sm-7">
							<select data-plugin-selectTwo class="form-control populate" name="id_unit">
								<?php
									$tampil=mysql_query("SELECT * FROM `unit` ORDER BY nama");
									while($r=mysql_fetch_array($tampil)){
										echo "<option value=$r[id_unit]>$r[nama]</option>";
										}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Group<span class="required"></span></label>
						<div class="col-sm-7">
							<select data-plugin-selectTwo class="form-control populate" name="id_group">
								<?php
									$tampil=mysql_query("SELECT * FROM `group` ORDER BY nama");
									while($r=mysql_fetch_array($tampil)){
										echo "<option value=$r[id_group]>$r[nama]</option>";
										}
								?>
							</select>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=user"><button type="button" class="btn btn-warning">Reset</button></a>
				</footer>
            </form>
		</section> 
	</div>
<?php
break;

	
//edit 
case "edit":
	$edit = mysql_query("SELECT * FROM `pegawai` WHERE pegawai_id ='$_GET[id]'");
	$row  = mysql_fetch_array($edit);	
?>
<div class="row">
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Pengguna</h5>
			</header>
            <form class="form-horizontal" method="POST" action="./aksi.php?module=user&act=update">
				<input type="hidden" name="id" value="<?php echo $row['pegawai_id'];?>" class="form-control"/>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Username</span></label>
						<div class="col-sm-7">
							<input type="text" name="username" value="<?php echo $row['nip'];?>" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Password</span></label>
						<div class="col-sm-7">
							<input type="password" name="password" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama</span></label>
						<div class="col-sm-7">
							<input type="text" name="nama" value="<?php echo $row['nama'];?>" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Unit<span class="required"></span></label>
						<div class="col-sm-7">
							<select data-plugin-selectTwo class="form-control populate" name="id_unit">
								<?php
									$tampil=mysql_query("SELECT * FROM `unit` ORDER BY nama");
									while($w=mysql_fetch_array($tampil)){
									if ($row[ruangan_id]==$w[id_unit]){
										echo "<option value=$w[id_unit] selected>$w[nama]</option>";
										}
									else{
											echo "<option value=$w[id_unit]>$w[nama]</option>";
										}
									}
									echo "</select>";
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Group<span class="required"></span></label>
						<div class="col-sm-7">
							<select data-plugin-selectTwo class="form-control populate" name="id_group">
								<?php
									$tampil=mysql_query("SELECT * FROM `group` ORDER BY nama");
									while($w=mysql_fetch_array($tampil)){
									if ($row[role_id]==$w[id_group]){
										echo "<option value=$w[id_group] selected>$w[nama]</option>";
										}
									else{
											echo "<option value=$w[id_group]>$w[nama]</option>";
										}
									}
									echo "</select>";
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
					<a href="?module=user"><button type="button" class="btn btn-warning">Reset</button></a>
				</footer>
            </form>
		</section> 
	</div>
<?php
break;
}
?>
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-table"></i> Pengguna</h5>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none" id="datatable-default">
				<thead>
					<tr>
						<th class="center">NO</th>
						<th class="center">USERNAME</th>
						<th class="center">NAMA</th>
						<th class="center">GROUP</th>
						<th class="center">UNIT</th>
						<th class="center">AKTIF</th>
						<th class="center">AKSI</th>
					</tr>
				</thead>
				<tbody>
					<?php
						/*$data = mysql_query("SELECT u.id_user, u.username, u.nama AS namauser, u.aktif, g.nama AS namagroup, n.nama AS namaunit
											FROM `user` u
											INNER JOIN `group` g ON g.id_group = u.id_group
											INNER JOIN `unit` n ON n.id_unit = u.id_unit
											ORDER BY u.id_user DESC");*/
						$data = mysql_query("SELECT pg.pegawai_id, pg.nip, pg.nama, gp.nama role, un.nama ruangan, pg.aktif
											FROM pegawai pg
											LEFT JOIN `group` gp ON gp.id_group = pg.role_id
											LEFT JOIN unit un ON un.id_unit = pg.ruangan_id
											WHERE pg.deletemark = 0");
						
						
						
						$no = 1;
						while ($r = mysql_fetch_array($data)){
						$user_nama = strtoupper($r['nama']);
						$group_nama = strtoupper($r['role']);
						$unit_nama = strtoupper($r['ruangan']);

					?>
					<tr>
						<td class="center"><?php echo $no;?></td>
						<td><?php echo $r['nip'];?></td>
						<td><?php echo $user_nama;?></td>
						<td><?php echo $group_nama;?></td>
						<td><?php echo $unit_nama;?></td>
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
						<td class="center"><a href="?module=user&act=edit&id=<?php echo $r["pegawai_id"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a></td>
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
