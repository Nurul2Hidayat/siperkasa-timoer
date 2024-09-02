<script>
	function lihat() {
		var status		= parseInt($("#status").val());
		var tanggal = document.getElementById('tanggal').value;
		//var tanggal 	= parseInt($("#tanggal").val());
        window.location = 'media.php?module=permintaan_detail&status=' + status + '&tanggal=' + tanggal;
    }
</script>
<header class="page-header">
	<h2>Permintaan Detail</h2>					
</header>
<?php
switch(@$_GET['act']){
default:
$kode	= isset($_GET['kd']) ? $_GET['kd'] : '';

$status		= isset($_GET['status']) ? $_GET['status'] : '';
$tanggal	= isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
?>
<div class="row">
	<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<select class="form-control" id="status" name="status" onchange="lihat()">
							<option <?php if ($status=="0") echo 'selected'; ?> value="0">Semua</option>
							<option <?php if ($status=="1") echo 'selected'; ?> value="1">Sudah</option>
							<option <?php if ($status=="2") echo 'selected'; ?> value="2">Pending</option>
						</select>
					</div>
					<h5><i class="fa fa-table"></i> Permintaan detail</h5>
				</header>
				
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-3">
							<div class="input-group mb-md">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<?php
									if ($tanggal == '0'){ 
										$tgl_sel = "$tgl";
									}else if ($tanggal == ''){ 
										$tgl_sel = "$tgl";
									}else {
										$tgl_sel = "$tanggal";
									}
								?>
								<input type="text" data-plugin-datepicker  class="form-control" name="tanggal" id="tanggal" value="<?php echo $tgl_sel;?>"/>
								<span class="input-group-btn">
									<button class="btn btn-success" type="button" onclick="lihat()">Lihat</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				
				<div class="panel-body">
					<table class="table table-bordered table-striped mb-none" id="datatable-default">
						<thead>
							<tr>
								<th class="center">NO</th>
								<th class="center">TGL MINTA</th>
								<th class="center">TGL SELESAI</th>
								<th class="center">NAMA</th>
								<th class="center">PERMINTAAN</th>
								<th class="center">PELAPOR</th>
								<th class="center">UNIT</th>
								<th class="center">SUDAH</th>
								<th class="center">AKSI</th>
							</tr>
						</thead>
						<tbody>	
					<?php	
					date_default_timezone_set('Asia/Jakarta');
					$tgl		= date('Y-m-d');
					$waktu		= date('Y-m-d H:i:s');
					
						if ($status == '0'){ 
							$filter = "";
						}else if ($status == ''){
							$filter = "";
						}else if ($status == '1'){ 
							$filter = "AND p.status = 'Sudah'";
						}else if ($status == '2'){
							$filter = "AND p.status = 'Pending'";
						}

						if ($tanggal == '0'){ 
							$tgl_selesai = "AND p.tanggal_selesai = '$tgl'";
						}else if ($tanggal == ''){ 
							$tgl_selesai = "AND p.tanggal_selesai = '$tgl'";
						}else {
							$tgl_selesai = "AND p.tanggal_selesai = '$tanggal'";
						}
						
						if ($_SESSION['group'] == '1'){
							$tampil=mysql_query("SELECT p.id_permintaan, p.jam_minta, b.nama AS barang, p.permintaan, u.nama AS unit, p.pelapor, 
											p.status, p.jam_selesai 
											FROM permintaan p
											INNER JOIN barang b ON b.id_barang = p.id_barang
											INNER JOIN unit u ON u.id_unit = p.id_unit
											WHERE p.status_minta = '1'
											$filter
											$tgl_selesai
											ORDER BY p.id_permintaan DESC");
						}
						else{
							$tampil=mysql_query("SELECT p.id_permintaan, p.jam_minta, b.nama AS barang, p.permintaan, u.nama AS unit, p.pelapor, 
												p.status, p.jam_selesai 
												FROM permintaan p
												INNER JOIN barang b ON b.id_barang = p.id_barang
												INNER JOIN unit u ON u.id_unit = p.id_unit
												WHERE p.status_minta = '1'
												$filter
												$tgl_selesai
												AND p.id_user='$_SESSION[simrsig]'
												ORDER BY p.id_permintaan DESC");
						} 
								
						$no=1;
						while ($row = mysql_fetch_array($tampil)){	
					?>
						<tr>
							<td class="center"><?php echo $no;?></td>
							<td class="center" width="100"><?php echo $row["jam_minta"]; ?></td>
							<td class="center" width="100"><?php echo $row["jam_selesai"]; ?></td>
							<td><?php echo $row["barang"]; ?></td>						
							<td><?php echo $row["permintaan"]; ?></td>						
							<td><?php echo $row["pelapor"]; ?></td>								
							<td><?php echo $row["unit"]; ?></td>								
							<td><?php echo $row["status"]; ?></td>								
					<?php
							if ($_SESSION['group'] == '1'){	
					?>
							<td class="center" width="80">
								<a href="?module=permintaan_detail&act=verif&id=<?php echo $row["id_permintaan"];?>"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-check-square-o"></i></button></a>
								
								<a href="?module=permintaan_detail&act=edit&id=<?php echo $row["id_permintaan"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a>
							</td>			
					<?php
						}else{
					?>								
							<td class="center" width="80"></td>
					<?php		
						}
					?>											
						</tr>
					<?php
						$no++;
						}
					?>	
						</tbody>
					</table>
					<br>	
				</div>						
			</section>
		</div>
	</div>
</div>
<?php
break;

//edit permintaan 
case "edit":
	$edit		= mysql_query("SELECT * FROM permintaan WHERE id_permintaan='$_GET[id]'");
	$r    		= mysql_fetch_array($edit);
	$pelapor 	= $r['pelapor']; 
	$text 		= htmlentities($pelapor,ENT_QUOTES);		
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Permintaan</h5>
			</header>
			<form class="form-horizontal" method="POST" action='./aksi.php?module=permintaan_detail&act=update'>
				<input type="hidden" name="id" value="<?php echo $r["id_permintaan"]; ?>">
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Jenis<span class="required"></span></label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="id_barang">
								<?php
									$tampil=mysql_query("SELECT * FROM barang ORDER BY nama");
									while($w=mysql_fetch_array($tampil)){
									$barang_nama = strtoupper($w['nama']);
									if ($r[id_barang]==$w[id_barang]){
										echo "<option value=$w[id_barang] selected>$barang_nama</option>";
										}
									else{
											echo "<option value=$w[id_barang]>$barang_nama</option>";
										}
									}
									echo "</select>";
								?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Permintaan<span class="required"></span></label>
						<div class="col-sm-5">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="permintaan"><?php echo $r["permintaan"]; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Unit<span class="required"></span></label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="id_unit">
								<?php
									$tampil=mysql_query("SELECT * FROM unit ORDER BY nama");
									while($w=mysql_fetch_array($tampil)){
									$unit_nama = strtoupper($w['nama']);
									if ($r[id_unit]==$w[id_unit]){
										echo "<option value=$w[id_unit] selected>$unit_nama</option>";
										}
									else{
											echo "<option value=$w[id_unit]>$unit_nama</option>";
										}
									}
									echo "</select>";
								?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Pelapor</span></label>
						<div class="col-sm-5">
							<input type="text" name="pelapor" class="form-control" value="<?php echo $text; ?>"/>
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


//Perbaikan
case "verif":
	$verif		= mysql_query("SELECT * FROM permintaan WHERE id_permintaan='$_GET[id]'");
	$r			= mysql_fetch_array($verif);
	$pelapor	= $r['pelapor']; 
	$text		= htmlentities($pelapor,ENT_QUOTES);
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Verifikasi</h5>
			</header>
			<form class="form-horizontal" method="POST" action='./aksi.php?module=permintaan_detail&act=verif'>
				<input type="hidden" name="id" value="<?php echo $r["id_permintaan"]; ?>">
				<input type="hidden" name="jam_minta" value="<?php echo $r["jam_minta"]; ?>">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-sm-3 control-label">Jenis<span class="required"></span></label>
								<div class="col-sm-8">
									<select data-plugin-selectTwo class="form-control populate" name="id_barang" disabled>
										<?php
											$tampil=mysql_query("SELECT * FROM barang ORDER BY nama");
											while($w=mysql_fetch_array($tampil)){
											$barang_nama = strtoupper($w['nama']);
											if ($r[id_barang]==$w[id_barang]){
												echo "<option value=$w[id_barang] selected>$barang_nama</option>";
												}
											else{
													echo "<option value=$w[id_barang]>$barang_nama</option>";
												}
											}
											echo "</select>";
										?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Permintaan<span class="required"></span></label>
								<div class="col-sm-8">
									<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "ambiance" } }' name="permintaan" disabled><?php echo $r["permintaan"]; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Unit<span class="required"></span></label>
								<div class="col-sm-8">
									<select data-plugin-selectTwo class="form-control populate" name="id_unit" disabled>
										<?php
											$tampil=mysql_query("SELECT * FROM unit ORDER BY nama");
											while($w=mysql_fetch_array($tampil)){
											$unit_nama = strtoupper($w['nama']);
											if ($r[id_unit]==$w[id_unit]){
												echo "<option value=$w[id_unit] selected>$unit_nama</option>";
												}
											else{
													echo "<option value=$w[id_unit]>$unit_nama</option>";
												}
											}
											echo "</select>";
										?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Pelapor</span></label>
								<div class="col-sm-8">
									<input type="text" name="pelapor" class="form-control" value="<?php echo $text;?>" disabled>
								</div>
							</div>
						</div>
					
					
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-sm-3 control-label">Tipe Barang<span class="required"></span></label>
								<div class="col-sm-8">
									<select data-plugin-selectTwo class="form-control populate" name="id_tipe">
										<?php
											$tampil=mysql_query("SELECT * FROM tipe_barang WHERE id_barang = '$r[id_barang]' ORDER BY tipe");
											while($w=mysql_fetch_array($tampil)){
											$tipe_nama = strtoupper($w['tipe']);
												if ($r[id_tipe]==$w[id]){
													echo "<option value=$w[id] selected>$tipe_nama</option>";
													}
												else{
														echo "<option value=$w[id]>$tipe_nama</option>";
													}
											}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Kerusakan<span class="required"></span></label>
								<div class="col-sm-8">
									<textarea class="form-control" rows="2" name="kerusakan"><?php echo $r['kerusakan'];?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Perbaikan<span class="required"></span></label>
								<div class="col-sm-8">
									<textarea class="form-control" rows="2" name="perbaikan" required><?php echo $r['perbaikan'];?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Follow Up<span class="required"></span></label>
								<div class="col-sm-8">
									<textarea class="form-control" rows="2" name="catatan"><?php echo $r['catatan'];?></textarea>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-3 control-label">Jenis Perbaikan<span class="required"></span></label>
								<div class="col-sm-8">
									  <select data-plugin-selectTwo name="jenis" class="form-control populate">
									  <option value="<?php echo $r['jenis'];?>"><?php echo $r['jenis'];?></option>
									  <option value="Hardware">Hardware</option>
									  <option value="Software">Software</option>
									  <option value="Jaringan">Jaringan</option>
									  <option value="Desain">Desain</option>
									  </select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-3 control-label">User <span class="required"></span></label>
								<div class="col-sm-8">
									<select data-plugin-selectTwo class="form-control populate" name="user_verif">
										<?php
											$tampil=mysql_query("SELECT * FROM user WHERE id_group = '1' ORDER BY id_user");
											while($w=mysql_fetch_array($tampil)){
												$user_nama = strtoupper($w['nama']);
												if ($r[user_verif]==$w[id_user]){
													echo "<option value=$w[id_user] selected>$user_nama</option>";
												}else{
													echo "<option value=$w[id_user]>$user_nama</option>";
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Status<span class="required"></span></label>
								<div class="col-sm-8">
									<select data-plugin-selectTwo name="status" class="form-control populate">
									 <option value="<?php echo $r['status'];?>"><?php echo $r['status'];?></option>
									<option value="Sudah">Sudah</option>
									<option value="Pending">Pending</option>
									</select>
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
		<section>
	</div>
</div>
<?php     
}
?>

