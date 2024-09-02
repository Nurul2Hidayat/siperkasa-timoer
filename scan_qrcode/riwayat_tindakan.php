<?php 
	$home = 'Riwayat Tindakan';
	include('scan_header.php');
?>

<section role="main" class="content-body">
	<header class="page-header">
		
	</header>
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<div class="panel-body">
					<?php
						if($f_tp == 'aset'){
							$where = "(aset.aset_id = $f_id or td.aset_id = $f_id)";
						}else{
							$where = "aset.ruangan_id = $f_id";
						}
						$query = mysql_query("select
												aset.tipe_id, 
													aset.nm_aset, 
													aset.ruangan_id, 
													aset.no_seri, 
													aset.tanggal_pembelian, 
													aset.status_id, 
													td.tindakan_id, 
													td.tindakan, 
													td.tanggal,
													pg.nama 
												FROM ipl_tindakan td 
												LEFT JOIN ipl_permintaan pm ON pm.permintaan_id = td.permintaan_id
												LEFT JOIN ipl_aset aset ON aset.aset_id = pm.aset_id OR aset.aset_id = td.aset_id
												LEFT JOIN pegawai pg ON pg.pegawai_id = td.petugas_id 
											where $where
											and td.delete_mark = 0
											order by td.tanggal desc");
						echo '
						<div class="">
							<table class="table mb-none">
								<thead>
									<tr>
										<th>Tindakan</th>
										<th>Tanggal</th>
										<th>Aset</th>
									</tr>
								</thead>
								<tbody>';
							
							while($data = mysql_fetch_array($query)){
								
								echo'
									<tr onclick="detail('.$data['tindakan_id'].')">
										<td>'.$data['tindakan'].'</td>
										<td>'.$data['tanggal'].'</td>
										<td>'.$data['nm_aset'].'</td>
									</tr>';
							}
							echo'
								</tbody>
							</table>
						</div>';
					?>
				</div>
			</section>
		</div>
	</div>
</section>

<!--  modal detail  -->
<div class="modal fade" id="detail_tindakan" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Detail Tindakan</h4>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Aset</label>
					<div class="col-sm-4">
						<b id="id_aset"></b>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Tindakan</label>
					<div class="col-sm-10">
						<b id="id_tindakan"></b>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Tanggal</label>
					<div class="col-sm-4">
						<b id="id_tanggal"></b>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Jam</label>
					<div class="col-sm-4">
						<b id="id_time"></b>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Petugas</label>
					<div class="col-sm-10">
						<b id="id_petugas"></b>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
			</div>
		 </div>
	</div>
</div>


<?php include('scan_footer.php');?>

<script>
	var base_url = window.location.origin;
	function detail(id){
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_detail',
			type	: 'POST',
			data	: {gid:id},
			dataType: 'json',
			success	: function(data){
				$('#id_tindakan').html(data.tindakan);
				$('#id_tanggal').html(data.tanggal);
				$('#id_time').html(data.time);
				$('#id_petugas').html(data.nama);
				$('#id_aset').html(data.nm_aset);
				$('#detail_tindakan').modal('show');
			},error	: function(){
				
			}
		});
	}
</script>