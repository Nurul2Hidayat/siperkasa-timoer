<header class="page-header">
	<h2>Laporan SIMRS</h2>
</header>
<?php
switch(@$_GET['act']){
  // Tampil User
  default:
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel-group" id="accordion2">
			<div class="panel panel-accordion panel-accordion-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2Three">Laporan permintaan perbaikan IT</a>
					</h4>
				</div>
				<div id="collapse2Three" class="accordion-body collapse">
					<form class="form-horizontal" method="POST" action='./laporan/laporan_permintaan.php' target="_blank">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-3 control-label">Nama<span class="required"></span></label>
								<div class="col-sm-4">
									<select data-plugin-selectTwo class="form-control populate" name="barang">
										<option value="semua">SEMUA</option>
										<?php
											$tampil=mysql_query("SELECT * FROM barang ORDER BY nama");
											while($r=mysql_fetch_array($tampil)){
											$barang_nama = strtoupper($r['nama']);
												echo "<option value=$r[id_barang]>$barang_nama</option>";
												}
												echo "</select>";
										?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Unit<span class="required"></span></label>
								<div class="col-sm-4">
									<select data-plugin-selectTwo class="form-control populate" name="unit">
										<option value="semua">SEMUA</option>
										<?php
											$tampil=mysql_query("SELECT * FROM unit ORDER BY nama");
											while($r=mysql_fetch_array($tampil)){
											$unit_nama = strtoupper($r['nama']);
												echo "<option value=$r[id_unit]>$unit_nama</option>";
												}
												echo "</select>";
										?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Status<span class="required"></span></label>
								<div class="col-sm-4">
									<select data-plugin-selectTwo class="form-control populate" name="status">
										<option value="semua">SEMUA</option>
										<option value="Sudah">SUDAH</option>
										<option value="Pending">PENDING</option>
									</select>
								</div> 
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Jenis<span class="required"></span></label>
								<div class="col-sm-4">
									  <select data-plugin-selectTwo name="jenis" class="form-control populate">
									  <option value="semua">SEMUA</option>
									  <option value="Hardware">Hardware</option>
									  <option value="Software">Software</option>
									  <option value="Jaringan">Jaringan</option>
									  <option value="Desain">Desain</option>
									  </select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Tgl permintaan</label>
								<div class="col-md-4">
									<div class="input-daterange input-group" data-plugin-datepicker>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="text" class="form-control" name="start" value="<?php echo $tgl;?>"/>
										<span class="input-group-addon">to</span>
										<input type="text" class="form-control" name="end" value="<?php echo $tgl;?>"/>
									</div>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-md-3 control-label">Format laporan</label>
								<div class="col-md-4">
									<select data-plugin-selectTwo class="form-control populate" name="formatlap">
										<option value="HTML">HTML</option>
										<option value="XLS">EXCEL</option>
									</select>
								</div>
							</div>
							<footer class="panel-footer">
								<button type="submit" class="btn btn-info">Submit </button>
								<a class="btn btn-warning" href="?module=lap_simrs">Kembali</a>
							</footer>
						</div>
					</form>					
				</div>
			</div>
			
			
			<div class="panel panel-accordion panel-accordion-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2Three2">Laporan checklist harian</a>
					</h4>
				</div>
				<div id="collapse2Three2" class="accordion-body collapse">
					<form class="form-horizontal" method="POST" action='./laporan/laporan_cek_harian.php' target="_blank">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Tanggal</label>
								<div class="col-md-4">
									<div class="input-daterange input-group" data-plugin-datepicker>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="text" class="form-control" name="start" value="<?php echo $tgl;?>"/>
										<span class="input-group-addon">to</span>
										<input type="text" class="form-control" name="end" value="<?php echo $tgl;?>"/>
									</div>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-md-3 control-label">Format laporan</label>
								<div class="col-md-4">
									<select data-plugin-selectTwo class="form-control populate" name="formatlap">
										<option value="HTML">HTML</option>
										<option value="XLS">EXCEL</option>
									</select>
								</div>
							</div>
							<footer class="panel-footer">
								<button type="submit" class="btn btn-info">Submit </button>
								<a class="btn btn-warning" href="?module=lap_simrs">Kembali</a>
							</footer>
						</div>
					</form>					
				</div>
			</div>
			
			
			<div class="panel panel-accordion panel-accordion-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2Three3">Rekap checklist perbulanan</a>
					</h4>
				</div>
				<div id="collapse2Three3" class="accordion-body collapse">
					<form class="form-horizontal" method="POST" action='./laporan/rekap_cek_harian.php' target="_blank">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-3 control-label">Tanggal</label>
								<div class="col-sm-4">
									<input type="text" data-plugin-datepicker  class="form-control" name="tanggal" value="<?php echo $tgl;?>"/>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-md-3 control-label">Format laporan</label>
								<div class="col-md-4">
									<select data-plugin-selectTwo class="form-control populate" name="formatlap">
										<option value="HTML">HTML</option>
										<option value="XLS">EXCEL</option>
									</select>
								</div>
							</div>
							<footer class="panel-footer">
								<button type="submit" class="btn btn-info">Submit </button>
								<a class="btn btn-warning" href="?module=lap_simrs">Kembali</a>
							</footer>
						</div>
					</form>					
				</div>
			</div>
			
			
			<div class="panel panel-accordion panel-accordion-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2Three4">Laporan agenda SIMRS</a>
					</h4>
				</div>
				<div id="collapse2Three4" class="accordion-body collapse">
					<form class="form-horizontal" method="POST" action='./laporan/laporan_agendasimrs.php' target="_blank">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-3 control-label">Status<span class="required"></span></label>
								<div class="col-sm-4">
									<select data-plugin-selectTwo class="form-control populate" name="status">
										<option value="semua">SEMUA</option>
										<option value="0">BELUM</option>
										<option value="1">SUDAH</option>
										<option value="2">PENDING</option>
									</select>
								</div> 
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Tgl Agenda</label>
								<div class="col-md-4">
									<div class="input-daterange input-group" data-plugin-datepicker>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="text" class="form-control" name="start" value="<?php echo $tgl;?>"/>
										<span class="input-group-addon">to</span>
										<input type="text" class="form-control" name="end" value="<?php echo $tgl;?>"/>
									</div>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-md-3 control-label">Format laporan</label>
								<div class="col-md-4">
									<select data-plugin-selectTwo class="form-control populate" name="formatlap">
										<option value="HTML">HTML</option>
										<option value="XLS">EXCEL</option>
									</select>
								</div>
							</div>
							<footer class="panel-footer">
								<button type="submit" class="btn btn-info">Submit </button>
								<a class="btn btn-warning" href="?module=lap_simrs">Kembali</a>
							</footer>
						</div>
					</form>					
				</div>
			</div>
			
			
			<div class="panel panel-accordion panel-accordion-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2Three5">Laporan kegiatan SIMRS</a>
					</h4>
				</div>
				<div id="collapse2Three5" class="accordion-body collapse">
					<form class="form-horizontal" method="POST" action='./laporan/laporan_kegiatansimrs.php' target="_blank">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-3 control-label">Status<span class="required"></span></label>
								<div class="col-sm-4">
									<select data-plugin-selectTwo class="form-control populate" name="status">
										<option value="semua">SEMUA</option>
										<option value="0">BELUM</option>
										<option value="1">SUDAH</option>
										<option value="2">PENDING</option>
									</select>
								</div> 
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Tgl Kegiatan</label>
								<div class="col-md-4">
									<div class="input-daterange input-group" data-plugin-datepicker>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="text" class="form-control" name="start" value="<?php echo $tgl;?>"/>
										<span class="input-group-addon">to</span>
										<input type="text" class="form-control" name="end" value="<?php echo $tgl;?>"/>
									</div>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-md-3 control-label">Format laporan</label>
								<div class="col-md-4">
									<select data-plugin-selectTwo class="form-control populate" name="formatlap">
										<option value="HTML">HTML</option>
										<option value="XLS">EXCEL</option>
									</select>
								</div>
							</div>
							<footer class="panel-footer">
								<button type="submit" class="btn btn-info">Submit </button>
								<a class="btn btn-warning" href="?module=lap_simrs">Kembali</a>
							</footer>
						</div>
					</form>					
				</div>
			</div>
			
			
			<div class="panel panel-accordion panel-accordion-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2Three6">Laporan permintaan perbaikan modul</a>
					</h4>
				</div>
				<div id="collapse2Three6" class="accordion-body collapse">
					<form class="form-horizontal" method="POST" action='./laporan/laporan_permintaan_modul.php' target="_blank">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-3 control-label">Nama<span class="required"></span></label>
								<div class="col-sm-4">
									<select data-plugin-selectTwo class="form-control populate" name="barang">
										<option value="semua">SEMUA</option>
										<?php
											$tampil=mysql_query("SELECT * FROM barang WHERE jenis ='software' ORDER BY nama");
											while($r=mysql_fetch_array($tampil)){
											$barang_nama = strtoupper($r['nama']);
												echo "<option value=$r[id_barang]>$barang_nama</option>";
												}
												echo "</select>";
										?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Status<span class="required"></span></label>
								<div class="col-sm-4">
									<select data-plugin-selectTwo class="form-control populate" name="status">
										<option value="semua">SEMUA</option>
										<option value="0">BELUM</option>
										<option value="1">SUDAH</option>
										<option value="2">PENDING</option>
									</select>
								</div> 
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Tgl Permintaan</label>
								<div class="col-md-4">
									<div class="input-daterange input-group" data-plugin-datepicker>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="text" class="form-control" name="start" value="<?php echo $tgl;?>"/>
										<span class="input-group-addon">to</span>
										<input type="text" class="form-control" name="end" value="<?php echo $tgl;?>"/>
									</div>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-md-3 control-label">Format laporan</label>
								<div class="col-md-4">
									<select data-plugin-selectTwo class="form-control populate" name="formatlap">
										<option value="HTML">HTML</option>
										<option value="XLS">EXCEL</option>
									</select>
								</div>
							</div>
							<footer class="panel-footer">
								<button type="submit" class="btn btn-info">Submit </button>
								<a class="btn btn-warning" href="?module=lap_simrs">Kembali</a>
							</footer>
						</div>
					</form>					
				</div>
			</div>

			<div class="panel panel-accordion panel-accordion-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2Three7">Laporan permintaan perbaikan sarana dan prasarana</a>
					</h4>
				</div>
				<div id="collapse2Three7" class="accordion-body collapse">
					<form class="form-horizontal" method="POST" action='./laporan/laporan_permintaan_snp.php' target="_blank">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-3 control-label">Nama<span class="required"></span></label>
								<div class="col-sm-4">
									<select data-plugin-selectTwo class="form-control populate" name="barang">
										<option value="semua">SEMUA</option>
										<option value="medis">MEDIS</option>
										<option value="non_medis">NON MEDIS</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Status<span class="required"></span></label>
								<div class="col-sm-4">
									<select data-plugin-selectTwo class="form-control populate" name="status">
										<option value="semua">SEMUA</option>
										<option value="belum">BELUM</option>
										<option value="sudah">SUDAH</option>
										<option value="pending">PENDING</option>
									</select>
								</div> 
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Tgl Permintaan</label>
								<div class="col-md-4">
									<div class="input-daterange input-group" data-plugin-datepicker>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="text" class="form-control" name="start" value="<?php echo $tgl;?>"/>
										<span class="input-group-addon">to</span>
										<input type="text" class="form-control" name="end" value="<?php echo $tgl;?>"/>
									</div>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-md-3 control-label">Format laporan</label>
								<div class="col-md-4">
									<select data-plugin-selectTwo class="form-control populate" name="formatlap">
										<option value="HTML">HTML</option>
										<option value="XLS">EXCEL</option>
									</select>
								</div>
							</div>
							<footer class="panel-footer">
								<button type="submit" class="btn btn-info">Submit </button>
								<a class="btn btn-warning" href="?module=lap_simrs">Kembali</a>
							</footer>
						</div>
					</form>					
				</div>
			</div>			
			
			<div class="panel panel-accordion panel-accordion-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2Three8">Laporan perbaikan modul</a>
					</h4>
				</div>
				<div id="collapse2Three8" class="accordion-body collapse">
					<form class="form-horizontal" method="POST" action='./laporan/laporan_perbaikan_modul.php' target="_blank">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-3 control-label">Nama<span class="required"></span></label>
								<div class="col-sm-4">
									<select data-plugin-selectTwo class="form-control populate" name="barang">
										<option value="semua">SEMUA</option>
										<?php
											$tampil=mysql_query("SELECT * FROM barang WHERE jenis ='software' ORDER BY nama");
											while($r=mysql_fetch_array($tampil)){
											$barang_nama = strtoupper($r['nama']);
												echo "<option value=$r[id_barang]>$barang_nama</option>";
												}
												echo "</select>";
										?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Tgl Perbaikan</label>
								<div class="col-md-4">
									<div class="input-daterange input-group" data-plugin-datepicker>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="text" class="form-control" name="start" value="<?php echo $tgl;?>"/>
										<span class="input-group-addon">to</span>
										<input type="text" class="form-control" name="end" value="<?php echo $tgl;?>"/>
									</div>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-md-3 control-label">Format laporan</label>
								<div class="col-md-4">
									<select data-plugin-selectTwo class="form-control populate" name="formatlap">
										<option value="HTML">HTML</option>
										<option value="XLS">EXCEL</option>
									</select>
								</div>
							</div>
							<footer class="panel-footer">
								<button type="submit" class="btn btn-info">Submit </button>
								<a class="btn btn-warning" href="?module=lap_simrs">Kembali</a>
							</footer>
						</div>
					</form>
				</div>
			</div>
			
			<div class="panel panel-accordion panel-accordion-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2Three9">Laporan Temperatur Server</a>
					</h4>
				</div>
				<div id="collapse2Three9" class="accordion-body collapse">
					<form class="form-horizontal" method="POST" action='./laporan/laporan_temperatur_server.php' target="_blank">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Tgl Perbaikan</label>
								<div class="col-md-4">
									<div class="input-daterange input-group" data-plugin-datepicker>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="text" class="form-control" name="start" value="<?php echo $tgl;?>"/>
										<span class="input-group-addon">to</span>
										<input type="text" class="form-control" name="end" value="<?php echo $tgl;?>"/>
									</div>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-md-3 control-label">Format laporan</label>
								<div class="col-md-4">
									<select data-plugin-selectTwo class="form-control populate" name="formatlap">
										<option value="HTML">HTML</option>
										<option value="XLS">EXCEL</option>
									</select>
								</div>
							</div>
							<footer class="panel-footer">
								<button type="submit" class="btn btn-info">Submit </button>
								<a class="btn btn-warning" href="?module=lap_simrs">Kembali</a>
							</footer>
						</div>
					</form>
				</div>
			</div>
			
			
		</div>
	</div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<?php
break;
}
?>
