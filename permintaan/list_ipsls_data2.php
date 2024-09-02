<?php
	if(function_exists($_GET['f'])) {
       $_GET['f']();
    }
	
	function get_data(){
		include "../koneksi/koneksi.php";
		$query = mysql_query("SELECT tbl.* from (
								SELECT 
									mu.nama , 
									(case when tps.jml is null then 0 else tps.jml end) jml_tps,
									(case when tps1.jml is null then 0 else tps1.jml end) jml_tps1,
									(case when tps2.jml is null then 0 else tps2.jml end) jml_tps2,
									(case when tps3.jml is null then 0 else tps3.jml end) jml_tps3,
									(case when tps4.jml is null then 0 else tps4.jml end) jml_tps4,
									(case when tp.jml is null then 0 else tp.jml end) jml_permintaan
								from unit mu
								left join (
									SELECT ruangan_id, count(permintaan_id)jml 
									from ipl_permintaan where delete_mark = 0 
									group by ruangan_id
								) tp on tp.ruangan_id = mu.id_unit
								left join (
									SELECT tp2.ruangan_id, count(tp2.permintaan_id)jml 
									from ipl_permintaan tp2
									left join ipl_status ms on ms.status_id = tp2.status_id
									where tp2.delete_mark = 0 and ms.status_id = 10
									group by tp2.ruangan_id, ms.status_id
								) tps on tps.ruangan_id = mu.id_unit
								left join (
									SELECT tp2.ruangan_id, count(tp2.permintaan_id)jml 
									from ipl_permintaan tp2
									left join ipl_status ms on ms.status_id = tp2.status_id
									where tp2.delete_mark = 0 and ms.status_id = 11
									group by tp2.ruangan_id, ms.status_id
								) tps1 on tps1.ruangan_id = mu.id_unit
								left join (
									SELECT tp2.ruangan_id, count(tp2.permintaan_id)jml 
									from ipl_permintaan tp2
									left join ipl_status ms on ms.status_id = tp2.status_id
									where tp2.delete_mark = 0 and ms.status_id = 12
									group by tp2.ruangan_id, ms.status_id
								) tps2 on tps2.ruangan_id = mu.id_unit
								left join (
									SELECT tp2.ruangan_id, count(tp2.permintaan_id)jml 
									from ipl_permintaan tp2
									left join ipl_status ms on ms.status_id = tp2.status_id
									where tp2.delete_mark = 0 and ms.status_id = 13
									group by tp2.ruangan_id, ms.status_id
								) tps3 on tps3.ruangan_id = mu.id_unit
								left join (
									SELECT tp2.ruangan_id, count(tp2.permintaan_id)jml 
									from ipl_permintaan tp2
									left join ipl_status ms on ms.status_id = tp2.status_id
									where tp2.delete_mark = 0 and ms.status_id = 14
									group by tp2.ruangan_id, ms.status_id
								) tps4 on tps4.ruangan_id = mu.id_unit
								where mu.aktif = 1
							) tbl
							order by tbl.jml_permintaan DESC");
		$ret = array();
		while($data = mysql_fetch_array($query)){
			$ret[] = array(	'nama'=> $data['nama'], 
							'jml'=> "	<span class='highlight' style='background-color:#d2322d;'>Open : $data[jml_tps]</span>
										<span class='highlight' style='background-color:#ffed8b; color:#8a6d3b;'>On Process : $data[jml_tps1]</span>
										<span class='highlight' style='background-color:#0088cc;'>Close : $data[jml_tps2]</span>
										<span class='highlight' style='background-color:#313131;'>Hold : $data[jml_tps3]</span>
										<span class='highlight' style='background-color:#ebebeb; color:#606060'>Cancel : $data[jml_tps4]</span>"
							);
		}
		$return = array('data'=> $ret);
		echo json_encode($return);
	}
	
	function get_data_child(){
		include "../koneksi/koneksi.php";
		$ruangan = $_GET['ruangan'];
		$query = mysql_query("SELECT tp.permintaan, mr.nama, ms.nm_status
					from ipl_permintaan tp
					left join unit mr on mr.id_unit = tp.ruangan_id
					LEFT join ipl_status ms on ms.status_id = tp.status_id and ms.delete_mark = 0
					WHERE tp.delete_mark = 0 and mr.nama = '$ruangan'");
		$ret = '<table width="100%" class="table-hover">
					<thead>
						<tr>
							<th></th>
							<th>Permintaan</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>';
		while($data = mysql_fetch_array($query)){
			$ret .='<tbody>
						<tr>
							<th width="100px"></th>
							<th width="500px" style="font-weight : normal">'.$data['permintaan'].'</th>
							<th style="font-weight : normal">'.$data['nm_status'].'</th>
							<th style="font-weight : normal"></th>
						</tr>
					</tbody>';
		}
		$ret .= '</table>';
		echo $ret;
	}
?>