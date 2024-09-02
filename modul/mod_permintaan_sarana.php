<header class="page-header">
	<h2>Permintaan Perbaikan Sarana dan Pra Sarana</h2>
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
						<a href="?module=permintaan_snp&act=tambah"><button type="button" class="btn btn-warning"><i class="fa fa-plus"></i> Add Data</button></a>
					</div>
					<h5><i class="fa fa-table"></i> Permintaan</h5>
				</header>
				<div class="tempat"></div>
			</section>
		</div> 
	</div>
</div>
<script>
        setInterval(function() { $(".tempat").load("modul/tampil_permintaan_sarana.php"); }, 1000);
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
			<form class="form-horizontal" method="POST" enctype="multipart/form-data" action='./aksi.php?module=permintaan_snp&act=input'>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Ruangan<span class="required"></span></label>
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
						<label class="col-sm-3 control-label">Jenis<span class="required"></span></label>
						<div class="col-sm-5">
							<select class="form-control populate" name="jenis_alat" onchange = "change_jenis(this.value)">
								<option value="medis">Medis</option>
								<option value="non medis">Non Medis</option>
							</select>
						</div>
					</div>
					<div class="form-group" id="seri_div">
						<label class="col-sm-3 control-label">Nomer Seri</span></label>
						<div class="col-sm-5">
							<input type="text" name="no_seri" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama, Merk, Type, Model<span class="required"></span></label>
						<div class="col-sm-5">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="merk_dkk"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Kerusakan<span class="required"></span></label>
						<div class="col-sm-5">
							<input type="text" name="kerusakan" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Keterangan</span></label>
						<div class="col-sm-5">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="keterangan"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Pelapor</span></label>
						<div class="col-sm-5">
							<input type="text" name="pelapor" class="form-control" required>
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
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=permintaan_sarana"><button type="button" class="btn btn-warning">Kembali</button></a>
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
									id,
									id_unit,
									jenis,
									no_series,
									nama_merk_model,
									kerusakan,
									keterangan,
									pelapor,
									(CASE WHEN filename = '' THEN 'files/img/no-image.jpg' ELSE filename END) filename
								FROM permintaan_snp
								WHERE delete_mark = 0
								AND id='$_GET[id]'");
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
			<form class="form-horizontal" method="POST" enctype="multipart/form-data" action='./aksi.php?module=permintaan_snp&act=update'>
				<input type="hidden" name="id_snp" value="<?=$r["id"]?>">
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Ruangan<span class="required"></span></label>
						<div class="col-sm-5">
							<select data-plugin-selectTwo class="form-control populate" name="id_unit">
								<?php
									$tampil=mysql_query("SELECT * FROM unit ORDER BY nama");
									while($w=mysql_fetch_array($tampil)){
									$unit_nama = strtoupper($w['nama']);
									if ($r['id_unit']==$w['id_unit']){
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
						<label class="col-sm-3 control-label">Jenis<span class="required"></span></label>
						<div class="col-sm-5">
							<select class="form-control populate" name="jenis_alat" onchange = "change_jenis(this.value)">
								<?php
									if($r['jenis'] == 'medis'){
										echo   '<option value="medis" selected>Medis</option>
												<option value="non medis">Non Medis</option>';
									}else{
										echo   '<option value="medis">Medis</option>
												<option value="non medis" selected>Non Medis</option>';
									}
								?>
								
							</select>
						</div>
					</div>
					<div class="form-group" id="seri_div" <?=$r['jenis'] == 'medis'? '' : 'hidden = "hidden"';?>>
						<label class="col-sm-3 control-label">Nomer Seri</span></label>
						<div class="col-sm-5">
							<input type="text" name="no_seri" class="form-control" value="<?=$r['no_series']?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama, Merk, Type, Model<span class="required"></span></label>
						<div class="col-sm-5">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="merk_dkk"><?=$r['nama_merk_model']?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Kerusakan<span class="required"></span></label>
						<div class="col-sm-5">
							<input type="text" name="kerusakan" class="form-control" required value="<?=$r['kerusakan']?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Keterangan</span></label>
						<div class="col-sm-5">
							<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="keterangan"><?=$r['keterangan']?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Pelapor</span></label>
						<div class="col-sm-5">
							<input type="text" name="pelapor" class="form-control" required value="<?=$r['pelapor']?>">
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
						<div class="col-sm-3"></div><img src = "<?=$r['filename']?>" id='img-upload_edit' width= "120px"/>
					</div>
				<footer class="panel-footer">
					<button type="submit" class="btn btn-info">Submit </button>
					<a href="?module=permintaan_snp"><button type="button" class="btn btn-warning">Kembali</button></a>
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
									id,
									id_unit,
									jenis,
									jam_minta,
									no_series,
									nama_merk_model,
									kerusakan,
									keterangan,
									pelapor,
									(CASE WHEN filename = '' THEN 'files/img/no-image.jpg' ELSE filename END) filename
								FROM permintaan_snp
								WHERE delete_mark = 0
								AND id='$_GET[id]'");
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
			<form class="form-horizontal" method="POST" enctype="multipart/form-data" action='./aksi.php?module=permintaan_snp&act=verif'>
				<input type="hidden" name="id" value="<?php echo $r["id"]; ?>">
				<input type="hidden" name="jam_minta" value="<?php echo $r["jam_minta"]; ?>">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-sm-3 control-label">Ruangan<span class="required"></span></label>
								<div class="col-sm-8">
									<select data-plugin-selectTwo class="form-control populate" name="id_unit" disabled>
									<?php
										$tampil=mysql_query("SELECT * FROM unit ORDER BY nama");
										while($w=mysql_fetch_array($tampil)){
										$unit_nama = strtoupper($w['nama']);
										if ($r['id_unit']==$w['id_unit']){
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
								<label class="col-sm-3 control-label">pelapor<span class="required"></span></label>
								<div class="col-sm-8">
									<input type="text" name="pelapor" class="form-control" required value="<?=$r['pelapor']?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Jenis<span class="required"></span></label>
								<div class="col-sm-8">
									<select class="form-control populate" name="jenis_alat" onchange = "change_jenis(this.value)" disabled>
										<?php
											if($r['jenis'] == 'medis'){
												echo   '<option value="medis" selected>Medis</option>
														<option value="non medis">Non Medis</option>';
											}else{
												echo   '<option value="medis">Medis</option>
														<option value="non medis" selected>Non Medis</option>';
											}
										?>
								
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">No Seri</span></label>
								<div class="col-sm-8">
									<input type="text" name="no_seri" class="form-control" value="<?=$r['no_series']?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Nama Merk Tipe Model</span></label>
								<div class="col-sm-8">
									<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="merk_dkk" disabled><?=$r['nama_merk_model']?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Kerusakan</span></label>
								<div class="col-sm-8">
									<input type="text" name="kerusakan" class="form-control" required value="<?=$r['kerusakan']?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">keterangan</span></label>
								<div class="col-sm-8">
									<textarea class="form-control" data-plugin-summernote data-plugin-options='{ "height": 150, "codemirror": { "theme": "ambiance" } }' name="keterangan" disabled><?=$r['keterangan']?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Gambar</span></label>
								<div class="col-sm-8">
									<div class="col-sm-8"><img src ='<?=$r["filename"]?>' class="zoom" id='img-upload_perbaikan' width= "120px"/></div>
								</div>
							</div>
						</div>
					
					
						<div class="col-md-6">
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
										<option value="medis">Medis</option>
										<option value="non_medis">Non Medis</option>
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
					<a href="?module=permintaan_snp"><button type="button" class="btn btn-warning">Kembali</button></a>
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

	function change_jenis(data){
		if(data == 'medis'){
			$('#seri_div').attr('hidden', false);
		}else{
			$('#seri_div').attr('hidden', true);
		}
	}
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