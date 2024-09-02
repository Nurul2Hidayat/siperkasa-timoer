<script type="text/javascript"> 
function checkAll(form){
	for (var i=0;i<document.forms[form].elements.length;i++)
	{
		var e=document.forms[form].elements[i];
		if ((e.name !='allbox') && (e.type=='checkbox'))
		{
			e.checked=document.forms[form].allbox.checked;
		}
	}
}
</script>
<header class="page-header">
	<h2>Checklist Harian</h2>
</header>
<?php
switch(@$_GET['act']){
default:
?>
<!-- Tambah -->
<div class="row">
	<div class="col-md-7">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h5><i class="fa fa-edit"></i> Form Checklist</h5>
			</header>
            <form class="form-horizontal" method="POST" action="./aksi.php?module=cek_harian&act=input" name="form[0]">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered mb-none">
							<thead>
								<tr>
									<th class="center"><input type="checkbox" name="allbox" value="check" onclick="checkAll(0);"/></th>
									<th class="center">NAMA</th>
									<th class="center">KETERANGAN</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$data = mysql_query("SELECT *
														FROM checklist
														WHERE id_checklist NOT IN (SELECT id_checklist FROM cek_harian WHERE tgl ='$tgl')
														ORDER BY nama ASC");
									$no = 1;
									while ($r = mysql_fetch_array($data)){
									$cek_nama = strtoupper($r['nama']);
								?>
								<tr>
									<td class="center"><input type="checkbox" name="checklist[]" value="<?php echo $r['id_checklist'];?>"></td>
									<td><?php echo $cek_nama;?></td>	
									<td align="center"><input type="text" name="ket[]" class="form-control"/></td>
								</tr>
								<?php
									$no++;
									}
								?>
							</tbody>
						</table>
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
				<h5><i class="fa fa-table"></i> Checklist harian</h5>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none" id="datatable-default">
				<thead>
					<tr>
						<th class="center">NO</th>
						<th class="center">TGL</th>
						<th class="center">CHECKLIST HARIAN</th>
						<th class="center">KETERANGAN</th>
						<th class="center">USER</th>
						<th class="center">AKSI</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$data = mysql_query("SELECT ch.id, ch.tgl, ch.tgl_act, ch.ket, c.nama AS checklist, u.nama AS user
											FROM cek_harian ch
											INNER JOIN checklist c ON c.id_checklist = ch.id_checklist
											INNER JOIN user u ON u.id_user = ch.user
											WHERE ch.tgl ='$tgl'
											ORDER BY ch.id DESC");
						$no = 1;
						while ($r = mysql_fetch_array($data)){
						$cek_nama = strtoupper($r['checklist']);

					?>
					<tr>
						<td width="50" class="center"><?php echo $no;?></td>
						<td width="130"><?php echo $r['tgl_act'];?></td>
						<td><?php echo $cek_nama;?></td>
						<td><?php echo $r['ket'];?></td>
						<td><?php echo $r['user'];?></td>
						<td class="center">
							<a href="./aksi.php?module=cek_harian&act=delete&id=<?php echo $r['id'];?>" onclick="return confirm('Yakin Hapus?')"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
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
<div>
<!-- and tabel --> 
