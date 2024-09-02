<?php 
	$home = 'Checklist 5R';
	include('scan_header.php');
?>

<section role="main" class="content-body">
	<header class="page-header">
		
	</header>
	<!-- start: page -->
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<div class="panel-body">
					<div calss="form-group">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<?php
								$tgl_inp = isset($_GET['tanggal']) ? $_GET['tanggal'] : date("Y-m-d");
							?>
							<input id="g_tanggal" name="g_tanggal" type="text" data-plugin-datepicker="" class="form-control" value="<?=$tgl_inp?>" onchange="change_tgl(this)">
						</div>
					</div>
					<br>
					<div calss="form-group">
						<ul class="widget-todo-list" id="checklist_cb">
						<?php
							$q_cek = "	select * from ipl_5r_input where tanggal = '".$tgl_inp."'";
							$sql_c = mysql_query($q_cek);
							$query = "	select  r.id,
												r.perihal,
												m.id vr_id,
												m.nama vr_nm,
												m.bg_color,
												m.color
										from ipl_5r_ruangan r 
										left join ipl_5r m on m.id = r.vr_id
										where r.unit_id = $f_id
										and r.deletemark = 0 
										and r.aktif = 1
										order by m.id";
							$sql = mysql_query($query);
							if(mysql_num_rows($sql_c) == 0){
								while($ck = mysql_fetch_array($sql)){
									echo "	<li>
												<div class='checkbox-custom checkbox-default'>
													<input type='checkbox' id='$ck[id]' class='todo-check' onchange='change_cekbox(this, $ck[id])'>
													<label class='todo-label' for='$ck[id]'><span>".wordwrap($ck['perihal'], 35, '<br>')."</span></label>
												</div>
												<div class='todo-actions'>
													<span class='label' style='background-color:$ck[bg_color]; color:$ck[color]'>$ck[vr_nm]</span>
												</div>
											</li>";
								}
							}else{
								$a_vr_id = array();
								$dt_c = array();
								while($dt = mysql_fetch_array($sql_c)){
									$a_vr_id[] = $dt['m_vr_id'];
									$dt_c[$dt['m_vr_id']] = $dt;
								}
								while($ck = mysql_fetch_array($sql)){
									$checked = '';
									if(in_array($ck['id'],$a_vr_id)){
										$checked = $dt_c[$ck['id']]['status'] == 1 ? 'checked' : '';
									}
									echo "	<li>
												<div class='checkbox-custom checkbox-default'>
													<input type='checkbox' $checked id='$ck[id]' class='todo-check'>
													<label class='todo-label' for='$ck[id]'><span>".wordwrap($ck['perihal'], 35, '<br>')."</span></label>
												</div>
												<div class='todo-actions'>
													<span class='label' style='background-color:$ck[bg_color]; color:$ck[color]'>$ck[vr_nm]</span>
												</div>
											</li>";
								}
							}
						?>
						</ul>
					</div>
				</div>
			</section>
		</div>
	</div>
	<input type="text" id="temp_gid" value="<?=$_GET['gid']?>" hidden>
</section>
<?php include('scan_footer.php');?>

<script>
	$(document).ready( function() {
		var gid = "<?=$f_id;?>";
		//saiki = get_today();
		//$('#g_tanggal').val(saiki);
		//get_data(saiki);
	});
	
	function get_data(tanggal){
		$('#g_tanggal').val(tanggal);
		$.ajax({
			url		: 'scan_qrcode_data.php?f=get_data_checklist_vr',
            type	: 'POST',
			data	: {tanggal:tanggal},
            success: function(data) {
				$('#checklist_cb').html(data);
			}
		});
	}
	
	function get_today(){
		var today = new Date();
		var dd = String(today.getDate()).padStart(2, '0');
		var mm = String(today.getMonth() + 1).padStart(2, '0');
		var yyyy = today.getFullYear();
		today = yyyy + '-' + mm + '-' + dd;
		
		return today;
	}
	
	function change_cekbox(cb, id){
		var checkboxId = cb.id;
		var isChecked = cb.checked;
		var tanggal = $('#g_tanggal').val();
		
		$.ajax({
			url		: 'scan_qrcode_data.php?f=change_cekbox',
            type	: 'POST',
			data	: {cb:isChecked, id:id, tgl:tanggal},
			dataType: 'json',
            success: function(data) {
				
			}
		});
	}
	
	function change_tgl(datepicker){
		var selectedDate = datepicker.value;
		$(datepicker).datepicker('hide');
		get_gid = $('#temp_gid').val();
		window.location.href = '?tanggal=' + selectedDate +'&gid='+get_gid;
	}
</script>
<style>
	#dtaset{
		width:100% !important;
	}
	.text-wrap{
		white-space:normal;
	}
	.width-200{
		width:150px;
	}
</style>