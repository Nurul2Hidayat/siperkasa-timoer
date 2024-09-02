<header class="page-header">
	<h2>Ganti Password</h2>
</header>
<?php
	$edit = mysql_query("SELECT * FROM `user` WHERE id_user ='$_SESSION[simrsig]'");
	$row  = mysql_fetch_array($edit);
?>
<div class="row">
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Ganti Password</h5>
			</header>
			<input type="hidden" id="id" value="<?php echo $_SESSION['simrsig'];?>" class="form-control"/>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-3 control-label">Password saat ini</span></label>
					<div class="col-sm-7">
						<input type="password" id="pw_now" class="form-control" placeholder="Password Saat ini" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Password baru</span></label>
					<div class="col-sm-7">
						<input type="password" id="pw_new" class="form-control" placeholder="Password Baru" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Konfirmasi Password baru</span></label>
					<div class="col-sm-7">
						<input type="password" id="pw_new_k" class="form-control" placeholder="Konfirmasi Password Baru" required>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<button type="submit" class="btn btn-info" onclick="ganti_password()">Submit </button>
			</footer>
		</section> 
	</div>
</div>
<script>
	function ganti_password(){
		pw_now = $('#pw_now').val();
		pw_new = $('#pw_new').val();
		pw_new_k = $('#pw_new_k').val();
		
		$.ajax({
			url		: 'modul/password_data.php?f=cek_password',
			type	: 'POST',
			data	: {pw_now:pw_now, pw_new:pw_new, pw_new_k:pw_new_k},
			dataType: 'json',
			success	: function(data){
				alert(data.msg);
			},error	: function(){
				alert('error');
			}
		});
	}
</script>