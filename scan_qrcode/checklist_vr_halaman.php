<?php
	session_start();
	include "../koneksi/koneksi.php";
	$q_cek = "	select * from ipl_5r_input where tanggal = '".date("Y-m-d")."'";
	$sql_c = mysql_query($q_cek);
	$query = "	select  r.id,
						r.perihal,
						m.id vr_id,
						m.nama vr_nm,
						m.color
				from ipl_5r_ruangan r 
				left join ipl_5r m on m.id = r.vr_id
				where r.unit_id = $_SESSION[ruangan] 
				and r.deletemark = 0 
				and r.aktif = 1";
	$sql = mysql_query($query);
	echo '<ul class="widget-todo-list" id="checklist_cb">';
	if(mysql_num_rows($sql_c) == 0){
		while($ck = mysql_fetch_array($sql)){
			echo "	<li>
					<div class='checkbox-custom checkbox-default'>
						<input type='checkbox' id='$ck[id]' class='todo-check' onchange='change_cekbox(this, $ck[id])'>
						<label class='todo-label' for='$ck[id]'><span>$ck[perihal]</span></label>
					</div>
					<div class='todo-actions'>
						<span class='label' style='background-color:$ck[color];'>$ck[vr_nm]</span>
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
			if(in_array($ck['id'],$a_vr_id)){
				$checked = $dt_c[$ck['id']]['status'] == 1 ? 'checked' : '';
			}
			echo "	<li>
					<div class='checkbox-custom checkbox-default'>
						<input type='checkbox' $checked id='$ck[id]' class='todo-check'>
						<label class='todo-label' for='$ck[id]'><span>$ck[perihal]</span></label>
					</div>
					<div class='todo-actions'>
						<span class='label' style='background-color:$ck[color];'>$ck[vr_nm]</span>
					</div>
				</li>";
		}
		echo '</ul>';
	}
?>