<header class="page-header">
	<h2>Permintaan Perbaikan</h2>
</header>
<?php
switch(@$_GET['act']){
default:
?>
<div class="row">
	<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="?module=permintaan&act=tambah"><button type="button" class="btn btn-warning"><i class="fa fa-plus"></i> Add Data</button></a>
					</div>
					<h5><i class="fa fa-table"></i> Permintaan</h5>
				</header>
				<div class="tempat"></div>
			</section>
		</div>
	</div>
</div>
<script>
        setInterval(function() { $(".tempat").load("modul/tampil_permintaan.php"); }, 1000);
</script>
<?php
break;

//tambah permintaan 
case "tambah":	
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
			<form class="form-horizontal" method="POST" enctype="multipart/form-data" action='./aksi.php?module=permintaan&act=input'>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama<span class="required"></span></label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="id_barang">
								<?php
									$tampil=mysql_query("SELECT * FROM barang where aktif = 1 ORDER BY nama");
									while($r=mysql_fetch_array($tampil)){
										$barang_nama = strtoupper($r['nama']);
										echo "<option value=$r[id_barang]>$barang_nama</option>";
										}
										echo "</select>";
								?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Permintaan<span class="required"></span></label>
						<div class="col-sm-5">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="permintaan"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Tambah Gambar<span class="required"></span></label>
						<div class="input-group col-sm-5">
							<span class="input-group-btn">
								<span class="btn btn-default btn-file">
									Pilih.. <input type="file" id="imgInp" name="file_img">
								</span>
							</span>
							<input type="text" class="form-control" readonly>
						</div>
						<div class="col-sm-3"></div><img id='img-upload' width= "120px"/>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Unit<span class="required"></span></label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="id_unit">
								<?php
									$tampil=mysql_query("SELECT * FROM unit where aktif = 1 ORDER BY nama");
									while($r=mysql_fetch_array($tampil)){
										$unit_nama = strtoupper($r['nama']);
										echo "<option value=$r[id_unit]>$unit_nama</option>";
										}
										echo "</select>";
								?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Pelapor</span></label>
						<div class="col-sm-5">
							<input type="text" name="pelapor" class="form-control" required>
						</div>
					</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=permintaan"><button type="button" class="btn btn-warning">Kembali</button></a>
				</footer>
			</form>
		</section>
	</div>
</div>
<?php
break;       

//edit permintaan 
case "edit":
	$edit		= mysql_query("SELECT 
									pelapor,
									id_permintaan,
									permintaan,
									id_barang,
									id_unit,
									(case when filename = '' then 'files/img/permintaan/no-image.jpg' else filename end) filename
								FROM permintaan 
								WHERE id_permintaan='$_GET[id]'");
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
			<form class="form-horizontal" method="POST" enctype="multipart/form-data" action='./aksi.php?module=permintaan&act=update'>
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
						<label class="col-sm-3 control-label">Edit Gambar<span class="required"></span></label>
						<div class="input-group col-sm-5">
							<span class="input-group-btn">
								<span class="btn btn-default btn-file">
									Pilih.. <input type="file" id="imgInp_edit" name="file_img">
								</span>
							</span>
							<input type="text" class="form-control" readonly>
						</div>
						<div class="col-sm-3"></div><img src ='<?php echo $r["filename"]; ?>' id='img-upload_edit' width= "120px"/>
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
					<a href="?module=permintaan"><button type="button" class="btn btn-warning">Kembali</button></a>
				</footer>
			</form>
		</section>
	</div>
</div>
<?php
break; 

//Perbaikan
case "verif":
	$verif		= mysql_query("SELECT 
									pelapor,
									id_permintaan,
									jam_minta,
									permintaan,
									id_barang,
									id_unit,
									(case when filename = '' then 'files/img/permintaan/no-image.jpg' else filename end) filename
								FROM permintaan  WHERE id_permintaan='$_GET[id]'");
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
			<form class="form-horizontal" method="POST" action='./aksi.php?module=permintaan&act=verif'>
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
							<div class="form-group">
								<label class="col-sm-3 control-label">Gambar<span></span></label>
								<div class="col-sm-8"><img src ='<?php echo $r["filename"]; ?>' class="zoom" id='img-upload_perbaikan' width= "120px"/></div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-sm-3 control-label">Tipe Barang<span class="required"></span></label>
								<div class="col-sm-8">
									<select data-plugin-selectTwo class="form-control populate" name="id_tipe">
										<?php
											$tampil=mysql_query("SELECT * FROM tipe_barang WHERE id_barang = '$r[id_barang]' ORDER BY tipe");
											while($r=mysql_fetch_array($tampil)){
											$tipe_nama = strtoupper($r['tipe']);
												echo "<option value=$r[id]>$tipe_nama</option>";
												}										
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Kerusakan<span class="required"></span></label>
								<div class="col-sm-8">
									<textarea class="form-control" rows="2" name="kerusakan"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Perbaikan<span class="required"></span></label>
								<div class="col-sm-8">
									<textarea class="form-control" rows="2" name="perbaikan" required></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Follow Up<span class="required"></span></label>
								<div class="col-sm-8">
									<textarea class="form-control" rows="2" name="catatan"></textarea>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-3 control-label">Jenis Perbaikan<span class="required"></span></label>
								<div class="col-sm-8">
									  <select data-plugin-selectTwo name="jenis" class="form-control populate">
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
											while($r=mysql_fetch_array($tampil)){
												?><option value="<?= $r['id_user']; ?>" <?php if($r['id_user']== $_SESSION['simrsig']){ echo "selected"; } ?> ><?= $r['nama']; ?></option><?php
												}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Status<span class="required"></span></label>
								<div class="col-sm-8">
									<select data-plugin-selectTwo name="status" class="form-control populate">
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
					<a href="?module=permintaan"><button type="button" class="btn btn-warning">Kembali</button></a>
				</footer>
			</form>
		<section>
	</div>
</div>
<?php     
}
?>
<script language="JavaScript" type="text/javascript">
	$(document).ready( function() {
    	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {
		    
		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;
		    
		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }
	    
		});
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        
		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }
		        
		        reader.readAsDataURL(input.files[0]);
		    }
		}

		function readURLedit(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        
		        reader.onload = function (e) {
		            $('#img-upload_edit').attr('src', e.target.result);
		        }
		        
		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imgInp").change(function(){
		    readURL(this);
		});

		$("#imgInp_edit").change(function(){
		    readURLedit(this);
		}); 
	});
</script>

<style>
	.zoom {      
	-webkit-transition: all 0.40s ease-in-out;    
	-moz-transition: all 0.40s ease-in-out;    
	transition: all 0.40s ease-in-out;     
	cursor: -webkit-zoom-in;      
	cursor: -moz-zoom-in;      
	cursor: zoom-in;  
	}     

	.zoom:hover,  
	.zoom:active,   
	.zoom:focus {
	/**adjust scale to desired size, 
	add browser prefixes**/
	-ms-transform: scale(3.5);    
	-moz-transform: scale(3.5);  
	-webkit-transform: scale(3.5);  
	-o-transform: scale(3.5);  
	transform: scale(3.5);    
	position:relative;      
	z-index:100;  
	}
</style>