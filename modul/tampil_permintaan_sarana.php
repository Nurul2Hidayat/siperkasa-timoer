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
					<th class="center">RUANGAN</th>
					<th class="center">PELAPOR</th>
					<th class="center">JENIS</th>
					<th class="center">NOMER SERI</th>
					<th class="center">NAMA MERK TYPE MODEL</th>
					<th class="center">KERUSAKAN</th>
					<th class="center">GAMBAR</th>
					<th class="center">AKSI</th>
				</tr>
			</thead>
			<tbody>	
			<?php
				$where = $_SESSION['group'] == '1' ? '' : "AND p.id_user='$_SESSION[simrsig]'";

				$tampil=mysql_query("SELECT
										tp.id,
										tp.jam_minta,
										mu.nama,
										tp.`pelapor`,
										tp.jenis,
										tp.`no_series`,
										tp.`nama_merk_model`,
										tp.`kerusakan`,
										(case when tp.filename = '' then 'files/img/no-image.jpg' else tp.filename end) filename
									FROM permintaan_snp tp
									LEFT JOIN unit mu ON mu.id_unit = tp.id_unit
									WHERE TP.delete_mark = 0
										AND tp.status_minta = 0
										$where");
					
				$no=1;
				while ($row = mysql_fetch_array($tampil)){
				?>
					<tr>
						<td class="center"><?php echo $no;?></td>
						<td class="center"><?php echo $row["jam_minta"]; ?></td>
						<td><?php echo $row["nama"]; ?></td>						
						<td><?php echo $row["pelapor"]; ?></td>						
						<td><?php echo $row["jenis"]; ?></td>								
						<td><?php echo $row["no_series"]; ?></td>
						<td><?php echo $row["nama_merk_model"]; ?></td>
						<td><?php echo $row["kerusakan"]; ?></td>
						<td width= "90px"><img src = '<?php echo $row["filename"]; ?>' alt ="" title = "" width= "90px"/></td>
				<?php
						if ($_SESSION['group'] == '1'){	
				?>
						<td class="center" width="100">
							<a href="?module=permintaan_snp&act=verif&id=<?php echo $row["id"];?>"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-check-square-o"></i></button></a>
							
							<a href="?module=permintaan_snp&act=edit&id=<?php echo $row["id"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a>
							
							<a href="./aksi.php?module=permintaan_snp&act=delete&id=<?php echo $row["id"];?>" onclick="return confirm('Yakin Hapus?')"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
						</td>			
				<?php
					}else{
				?>								
						<td class="center" width="80">		
							<a href="?module=permintaan_snp&act=edit&id=<?php echo $row["id"];?>"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></a>
							
							<a href="./aksi.php?module=permintaan_snp&act=hapus&id=<?php echo $row["id"];?>"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
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
				