<?php
include "../sesi.php";
include "../koneksi/koneksi.php";
?>
<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-bordered mb-none">
			<thead>
				<tr>
					<th class="center">NO</th>
					<th class="center">TANGGAL</th>
					<th class="center">NAMA</th>
					<th class="center">PERMINTAAN</th>
					<th class="center">PELAPOR</th>
					<th class="center">UNIT</th>
					<th class="center">GAMBAR</th>
					<th class="center">AKSI</th>
				</tr>
			</thead>
			<tbody>	
			<?php			
				if ($_SESSION['group'] == '1'){
					$tampil=mysql_query("SELECT p.id_permintaan, p.jam_minta, b.nama AS barang, p.permintaan, (CASE WHEN p.filename = '' THEN 'files/img/no-image.jpg' ELSE p.filename END) filename, u.nama AS unit, p.pelapor 
									FROM permintaan p
									INNER JOIN barang b ON b.id_barang = p.id_barang
									INNER JOIN unit u ON u.id_unit = p.id_unit
									WHERE p.status_minta = '0'
									ORDER BY p.id_permintaan DESC");
				}
				else{
				  $tampil=mysql_query("SELECT p.id_permintaan, p.jam_minta, b.nama AS barang, (CASE WHEN p.filename = '' THEN 'files/img/no-image.jpg' ELSE p.filename END) filename, p.filename, u.nama AS unit, p.pelapor 
									FROM permintaan p
									INNER JOIN barang b ON b.id_barang = p.id_barang
									INNER JOIN unit u ON u.id_unit = p.id_unit
									WHERE p.status_minta = '0'
									AND p.id_user='$_SESSION[simrsig]'
									ORDER BY p.id_permintaan DESC");
				} 
					
				$no=1;
				while ($row = mysql_fetch_array($tampil)){
				?>
					<tr>
						<td class="center"><?php echo $no;?></td>
						<td class="center"><?php echo $row["jam_minta"]; ?></td>
						<td><?php echo $row["barang"]; ?></td>						
						<td><?php echo $row["permintaan"]; ?></td>						
						<td><?php echo $row["pelapor"]; ?></td>								
						<td><?php echo $row["unit"]; ?></td>
						<td width= "90px"><img src = '<?php echo $row["filename"]; ?>' alt ="" title = "" width= "90px"/></td>
				<?php
						if ($_SESSION['group'] == '1'){	
				?>
						<td class="center" width="100">
							<a href="?module=permintaan&act=verif&id=<?php echo $row["id_permintaan"];?>"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-check-square-o"></i></button></a>
							
							<a href="?module=permintaan&act=edit&id=<?php echo $row["id_permintaan"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a>
							
							<a href="./aksi.php?module=permintaan&act=hapus&id=<?php echo $row["id_permintaan"];?>" onclick="return confirm('Yakin Hapus?')"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
						</td>			
				<?php
					}else{
				?>								
						<td class="center" width="80">		
							<a href="?module=permintaan&act=edit&id=<?php echo $row["id_permintaan"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a>
							
							<a href="./aksi.php?module=permintaan&act=hapus&id=<?php echo $row["id_permintaan"];?>"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
						</td>
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
	</div>
	<br>	
</div>						