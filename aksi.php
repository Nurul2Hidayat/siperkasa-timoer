<?php
session_start();
include "koneksi/koneksi.php";
date_default_timezone_set('Asia/Jakarta');
$tgl		= date('Y-m-d');
$waktu		= date('Y-m-d H:i:s');

$module	= $_GET['module'];
$act	= $_GET['act'];

// Menghapus data
if (isset($module) AND $act=='hapus'){
	mysql_query("DELETE FROM ".$module." WHERE id_".$module."='$_GET[id]'");
	header('location:media.php?module='.$module);
}

// Hapus cek harian
elseif ($module=='cek_harian' AND $act=='delete'){	
	mysql_query("DELETE FROM cek_harian WHERE id ='$_GET[id]'");
	header('location:media.php?module='.$module);
}

// Input group
elseif ($module=='group' AND $act=='input'){	
	mysql_query("INSERT INTO `group` (nama) 
							   VALUES('$_POST[nama]')");
	header('location:media.php?module='.$module);
}

// Update group
elseif ($module=='group' AND $act=='update'){	
    mysql_query("UPDATE `group` SET 
				nama			= '$_POST[nama]'
          WHERE id_group     	= '$_POST[id]'");
	header('location:media.php?module='.$module);
}

// Akses
elseif ($module=='group' AND $act=='akses'){
	$group			= $_POST['id'];
    $jml_akses		= count($_POST['akses']);
	
	mysql_query("DELETE FROM akses WHERE id_group = '$group'");
    
	for($i=0;$i<$jml_akses;$i++){
        $id_modul	= $_POST['akses'][$i];
        $id_group	= $_POST['id_group'][$i];		
	mysql_query("INSERT INTO akses(id_modul,
										id_group) 
								   VALUES('$id_modul',
										'$id_group')");
    }
	
    $jml_akses_anak		= count($_POST['akses_anak']);
	for($i=0;$i<$jml_akses_anak;$i++){
        $id_modul_anak	= $_POST['akses_anak'][$i];
        $id_group_anak	= $_POST['id_group_anak'][$i];
	mysql_query("INSERT INTO akses(id_modul,
										id_group) 
								   VALUES('$id_modul_anak',
										'$id_group_anak')");
    }	
	header('location:media.php?module='.$module);
}


// Input user
elseif ($module=='user' AND $act=='input'){
	$pass=md5($_POST[password]);
	mysql_query("INSERT INTO pegawai(nip,
                                password,
								nama,
								ruangan_id,
								role_id,
								aktif) 
	                       VALUES('$_POST[username]',
                                '$pass',
								'$_POST[nama]',
								'$_POST[id_unit]',
								'$_POST[id_group]',
								'1')");
	header('location:media.php?module='.$module);
}

// Update user
elseif ($module=='user' AND $act=='update'){
  // Apabila password tidak diubah
	if (empty($_POST[password])) {
		mysql_query("UPDATE pegawai SET 
						nip  		= '$_POST[username]',
						nama  		= '$_POST[nama]',
						ruangan_id 	= '$_POST[id_unit]',
						role_id  	= '$_POST[id_group]',
						aktif		= '$_POST[aktif]'
			  WHERE  pegawai_id    	= '$_POST[id]'");
		header('location:media.php?module='.$module);
	}
	// Apabila password diubah
	else{
		$pass=md5($_POST[password]);
		mysql_query("UPDATE pegawai SET 
					password    = '$pass',
					nip  		= '$_POST[username]',
					nama 		= '$_POST[nama]',
					ruangan_id	= '$_POST[id_unit]',
					role_id     = '$_POST[id_group]',
					aktif		= '$_POST[aktif]' 
			  WHERE pegawai_id	= '$_POST[id]'");
		header('location:media.php?module='.$module);
	}
}

// Ganti password
elseif ($module=='password' AND $act=='update'){
  
	$pass=md5($_POST[password]);
	mysql_query("UPDATE user SET password = '$pass' WHERE id_user = '$_POST[id]'");  
	header('location:media.php?module='.$module);

}

// Input Menu Hak Akses
elseif ($module=='hakakses' AND $act=='input'){
	$id_user		= $_POST['id'];
	$jumlah = count($_POST["id_modul"]);
		for($i=0; $i < $jumlah; $i++)
		{
			$id_modul=$_POST["id_modul"][$i];
			mysql_query("INSERT INTO akses(
							id_modul,
							id_user) 
	                       VALUES(
							'$id_modul',
							'$id_user')");
		}						
	header('location:media.php?module=user');
}

// Input unit
elseif ($module=='unit' AND $act=='input'){
	mysql_query("INSERT INTO unit(
							id_aset,
							nama, 
							aktif) 
						VALUES(
							'0',
							'$_POST[nama]',
							'$_POST[aktif]')");
	header('location:media.php?module='.$module);
}

// Update unit
elseif ($module=='unit' AND $act=='update'){
	mysql_query("UPDATE unit SET 
								nama		= '$_POST[nama]',
								aktif		= '$_POST[aktif]'
                          WHERE id_unit		= '$_POST[id]'");
	header('location:media.php?module='.$module);
}

// Input barang
elseif ($module=='barang' AND $act=='input'){
	$nomor		= mysql_query("SELECT kode FROM `barang` ORDER BY id_barang DESC LIMIT 1");
	$r_no		= mysql_fetch_array($nomor);	
	$kode		= $r_no['kode'] + 1;
	$nokode 	= sprintf("%06d",$kode);
	
	mysql_query("INSERT INTO barang(
							kode,
							nama,
							jenis,
							aktif) 
						VALUES(
							'$nokode',
							'$_POST[nama]',
							'$_POST[jenis]',
							'$_POST[aktif]')");
							
	$data		= mysql_query("SELECT id_barang FROM `barang` ORDER BY id_barang DESC LIMIT 1");
	$r_brg		= mysql_fetch_array($data);	
	$brg		= $r_brg['id_barang'];						
							
	mysql_query("INSERT INTO tipe_barang(
						id_barang,
						tipe,
						aktif) 
					VALUES(
						'$brg',
						'-',
						'1')");						
	header('location:media.php?module='.$module);
}

// Update barang
elseif ($module=='barang' AND $act=='update'){
	mysql_query("UPDATE barang SET 
								kode		= '$_POST[kode]',
								nama		= '$_POST[nama]',
								jenis		= '$_POST[jenis]',
								aktif		= '$_POST[aktif]'
                          WHERE id_barang	= '$_POST[id]'");
	header('location:media.php?module='.$module);
}

// Input tipe barang
elseif ($module=='tipe_barang' AND $act=='input'){
	mysql_query("INSERT INTO tipe_barang(
							id_barang,
							tipe,
							aktif) 
						VALUES(
							'$_POST[id_barang]',
							'$_POST[tipe]',
							'1')");
	header('location:media.php?module='.$module);
}

// Update tipe barang
elseif ($module=='tipe_barang' AND $act=='update'){
	mysql_query("UPDATE tipe_barang SET 
								id_barang		= '$_POST[id_barang]',
								tipe			= '$_POST[tipe]',
								aktif			= '$_POST[aktif]'
                          WHERE id				= '$_POST[id]'");
	header('location:media.php?module='.$module);
}

// Input checklist
elseif ($module=='checklist' AND $act=='input'){
	mysql_query("INSERT INTO checklist(
							nama,
							aktif) 
						VALUES(
							'$_POST[nama]',
							'1')");
	header('location:media.php?module='.$module);
}

// Update checklist
elseif ($module=='checklist' AND $act=='update'){
	mysql_query("UPDATE checklist SET 
								nama			= '$_POST[nama]',
								aktif			= '$_POST[aktif]'
                          WHERE id_checklist	= '$_POST[id]'");
	header('location:media.php?module='.$module);
}

// Input permintaan sarana dan prasarana
elseif ($module=='permintaan_snp' AND $act=='input'){
	$no_seri	= addslashes($_POST['no_seri']);
	$merk		= addslashes($_POST['merk_dkk']);
	$kerusakan	= addslashes($_POST['kerusakan']);
	$keterangan	= addslashes($_POST['keterangan']);
	$pelapor	= addslashes($_POST['pelapor']);

	$folder		= '';
	if($_FILES['file_img']['name']){
		$filename		= $_FILES['file_img']['name'];
		$tempname		= $_FILES['file_img']['tmp_name'];
		$folder			= "files/img/permintaan_snp/".$filename;
		if (move_uploaded_file($tempname, $folder))  {
			$msg = "Upload Gambar Berhasil";
		}else{
			$msg = "Upload Gambar Gagal";
		}
	}

	mysql_query("INSERT INTO permintaan_snp(
							tanggal_minta,
							jam_minta,
							id_unit,
							jenis,
							no_series,
							nama_merk_model,
							kerusakan,
							keterangan,
							pelapor,
							id_user,
							id_tipe,
							user_verif,
							status_minta,
							filename) 
						VALUES(
							'$tgl',
							'$waktu',
							'$_POST[id_unit]',
							'$_POST[jenis_alat]',
							'$no_seri',
							'$merk',
							'$kerusakan',
							'$keterangan',
							'$pelapor',
							'$_SESSION[simrsig]',
							'0',
							'0',
							'0',
							'$folder')");
	
	header('location:media.php?module='.$module);
}

// Update permintaan sarana dan prasarana
elseif ($module=='permintaan_snp' AND $act=='update'){
	$no_seri	= addslashes($_POST['no_seri']);
	$merk		= addslashes($_POST['merk_dkk']);
	$kerusakan	= addslashes($_POST['kerusakan']);
	$keterangan	= addslashes($_POST['keterangan']);
	$pelapor	= addslashes($_POST['pelapor']);

	if($_POST['jenis_alat'] == 'non medis'){
		$no_seri = '';
	}

	$folder = '';

	if($_FILES['file_img']['name']){
		$filename		= $_FILES['file_img']['name'];
		$tempname		= $_FILES['file_img']['tmp_name'];
		$folder			= "files/img/permintaan_snp/".$filename;
		if (move_uploaded_file($tempname, $folder))  {
			$msg = "Upload Gambar Berhasil";
		}else{
			$msg = "Upload Gambar Gagal";
		}
	}

	mysql_query("UPDATE permintaan_snp SET 
								id_unit			= '$_POST[id_unit]',
								jenis			= '$_POST[jenis_alat]',
								nama_merk_model = '$merk',
								kerusakan		= '$kerusakan',
								keterangan		= '$keterangan',
								pelapor			= '$pelapor',
								no_series		= '$no_seri',
								filename		= '$folder'
                          WHERE id				= '$_POST[id_snp]'");
	header('location:media.php?module='.$module);
}

//hapus permintaan sarana dan prasarana
elseif ($module=='permintaan_snp' AND $act=='delete'){
	mysql_query("update permintaan_snp set delete_mark = 1 WHERE id = $_GET[id]");
	header('location:media.php?module='.$module);
}

// Verifikasi sarana dan prasarana
elseif ($module=='permintaan_snp' AND $act=='verif'){
	
	$jam_minta	= $_POST['jam_minta'];
	$kini 		= new DateTime($jam_minta);  
	$kemarin 	= new DateTime($timestamp);  
	$selisi 	= $kemarin->diff($kini)->format('%a hari %h jam %i menit');
	
	$kerusakan	= addslashes($_POST[kerusakan]);
	$perbaikan	= addslashes($_POST[perbaikan]);
	$catatan	= addslashes($_POST[catatan]);
	mysql_query("UPDATE permintaan_snp SET
								status_minta		= '1',
								tanggal_selesai		= '$tgl',
								jam_selesai			= '$waktu',
								kerusakan_verif		= '$kerusakan',
								perbaikan			= '$perbaikan',	
								catatan				= '$catatan',
								jenis				= '$_POST[jenis]',
								status				= '$_POST[status]',
								user_verif			= '$_POST[user_verif]',
								respontime			= '$selisi'
                          WHERE id					= '$_POST[id]'");
	header('location:media.php?module='.$module);
}

// Input permintaan
elseif ($module=='permintaan' AND $act=='input'){
	$permintaan		= addslashes($_POST['permintaan']);
	$pelapor		= addslashes($_POST['pelapor']);
	$folder = '';
	if($_FILES['file_img']['name']){
		$filename		= $_FILES['file_img']['name'];
		$tempname		= $_FILES['file_img']['tmp_name'];
		$folder			= "files/img/permintaan/".$filename;
		if (move_uploaded_file($tempname, $folder))  {
			$msg = "Upload Gambar Berhasil";
		}else{
			$msg = "Upload Gambar Gagal";
		}
	}
	
	mysql_query("INSERT INTO permintaan(
							tanggal_minta,
							jam_minta,
							permintaan,
							id_barang,
							id_unit,
							pelapor,
							id_user,
							status_minta,
							tanggal_selesai,
							jam_selesai,
							kerusakan,
							perbaikan,
							catatan,
							jenis,
							id_tipe,
							status,
							user_verif,
							respontime,
							filename) 
						VALUES(
							'$tgl',
							'$waktu',
							'$permintaan',
							'$_POST[id_barang]',
							'$_POST[id_unit]',
							'$pelapor',
							'$_SESSION[simrsig]',
							'0',
							'',
							'',
							'',
							'',
							'',
							'',
							'0',
							'',
							'0',
							'',
							'$folder')");
	
	header('location:media.php?module='.$module);
}

// Update permintaan
elseif ($module=='permintaan' AND $act=='update'){
	$permintaan		= addslashes($_POST[permintaan]);
	$pelapor		= addslashes($_POST[pelapor]);
	$folder = '';
	if($_FILES['file_img']['name']){
		$filename		= $_FILES['file_img']['name'];
		$tempname		= $_FILES['file_img']['tmp_name'];
		$folder			= "files/img/permintaan/".$filename;
		if (move_uploaded_file($tempname, $folder))  {
			$msg = "Upload Gambar Berhasil";
		}else{
			$msg = "Upload Gambar Gagal";
		}
	}
	mysql_query("UPDATE permintaan SET 
								permintaan		= '$permintaan',
								id_barang		= '$_POST[id_barang]',
								id_unit			= '$_POST[id_unit]',
								pelapor			= '$pelapor',
								filename		= '$folder'
                          WHERE id_permintaan	= '$_POST[id]'");
	header('location:media.php?module='.$module);
}

// Verifikasi
elseif ($module=='permintaan' AND $act=='verif'){
	
	$jam_minta	= $_POST['jam_minta'];
	$kini 		= new DateTime($jam_minta);  
	$kemarin 	= new DateTime($timestamp);  
	$selisi 	= $kemarin->diff($kini)->format('%a hari %h jam %i menit');
	
	$kerusakan	= addslashes($_POST[kerusakan]);
	$perbaikan	= addslashes($_POST[perbaikan]);
	$catatan	= addslashes($_POST[catatan]);
	mysql_query("UPDATE permintaan SET 
								status_minta		= '1',
								tanggal_selesai		= '$tgl',
								jam_selesai			= '$waktu',
								kerusakan			= '$kerusakan',
								perbaikan			= '$perbaikan',	
								catatan				= '$catatan',
								jenis				= '$_POST[jenis]',
								id_tipe				= '$_POST[id_tipe]',
								status				= '$_POST[status]',
								user_verif			= '$_POST[user_verif]',
								respontime			= '$selisi'
                          WHERE id_permintaan		= '$_POST[id]'");
	header('location:media.php?module='.$module);
}

// Update permintaan detail
elseif ($module=='permintaan_detail' AND $act=='update'){
	$permintaan		= addslashes($_POST[permintaan]);
	$pelapor		= addslashes($_POST[pelapor]);
	mysql_query("UPDATE permintaan SET 
								permintaan		= '$permintaan',
								id_barang		= '$_POST[id_barang]',
								id_unit			= '$_POST[id_unit]',
								pelapor			= '$pelapor'
                          WHERE id_permintaan	= '$_POST[id]'");
	header('location:media.php?module='.$module);
}

// Verifikasi detail
elseif ($module=='permintaan_detail' AND $act=='verif'){	
	$kerusakan	= addslashes($_POST[kerusakan]);
	$perbaikan	= addslashes($_POST[perbaikan]);
	$catatan	= addslashes($_POST[catatan]);
	mysql_query("UPDATE permintaan SET 
								kerusakan			= '$kerusakan',
								perbaikan			= '$perbaikan',	
								catatan				= '$catatan',
								jenis				= '$_POST[jenis]',
								id_tipe				= '$_POST[id_tipe]',
								status				= '$_POST[status]',
								user_verif			= '$_POST[user_verif]'
                          WHERE id_permintaan		= '$_POST[id]'");
	header('location:media.php?module='.$module);
}

// Input Cek harian
elseif ($module=='cek_harian' AND $act=='input'){
	$jumlah    		= count($_POST["checklist"]);
		for($i=0; $i < $jumlah; $i++)
		{
			$checklist	= $_POST["checklist"][$i];
			$ket		= $_POST["ket"][$i];
			
			mysql_query("INSERT INTO cek_harian(
							id_checklist,
							tgl,
							tgl_act,
							user,
							ket) 
						   VALUES(
							'$checklist',
							'$tgl',
							'$waktu',
							'$_SESSION[simrsig]',
							'$ket')");
		}
	header('location:media.php?module='.$module);
}

// Input Agenda SIMRS
elseif ($module=='agendasimrs' AND $act=='input'){
	mysql_query("INSERT INTO agenda_simrs(
							tgl,
							tgl_act, 
							user_act, 
							agenda,
							peserta,
							status,
							tgl_verif,
							verif_act,
							user_verif,
							hasil,
							nama_file,
							ukuran_file,
							direktori) 
					VALUES(	
							'$_POST[tgl]',  
							'$waktu', 
							'$_SESSION[simrsig]', 
							'$_POST[agenda]',
							'$_POST[peserta]',
							'0',
							'',
							'',
							'0',
							'',
							'',
							'0',
							'')");
	header('location:media.php?module='.$module);
}

//  Edit Agenda SIMRS
elseif ($module=='agendasimrs' AND $act=='update'){
	$lokasi_file 	= $_FILES['fupload']['tmp_name'];
	$nama_file   	= $_FILES['fupload']['name'];
	$ukuran_file 	= $_FILES['fupload']['size'];
	$direktori 		= "files/$nama_file";
	
	if (empty($lokasi_file)){
	mysql_query("UPDATE agenda_simrs SET 
							tgl			= '$_POST[tgl]',
							agenda		= '$_POST[agenda]',
							peserta		= '$_POST[peserta]', 
							status		= '$_POST[status]', 
							tgl_verif	= '$tgl',
							verif_act	= '$waktu',
							user_verif	= '$_SESSION[simrsig]',
							hasil		= '$_POST[hasil]'
						WHERE id		= '$_POST[id]'");
	}
	else{
	move_uploaded_file($lokasi_file,"$direktori");
	mysql_query("UPDATE agenda_simrs SET  
							tgl			= '$_POST[tgl]',
							agenda		= '$_POST[agenda]',
							peserta		= '$_POST[peserta]',
							status		= '$_POST[status]', 
							tgl_verif	= '$tgl',
							verif_act	= '$waktu',
							user_verif	= '$_SESSION[simrsig]',
							hasil		= '$_POST[hasil]',
							nama_file	= '$nama_file',
							ukuran_file	= '$ukuran_file',
							direktori	= '$direktori'
						WHERE id		= '$_POST[id]'");
	}					
	header('location:media.php?module='.$module);
}

// Input Kegiatan SIMRS
elseif ($module=='kegiatan' AND $act=='input'){
	$lokasi_file 	= $_FILES['fupload']['tmp_name'];
	$nama_file   	= $_FILES['fupload']['name'];
	$ukuran_file 	= $_FILES['fupload']['size'];
	$direktori 		= "files/$nama_file";
	
	if (empty($lokasi_file)){
		mysql_query("INSERT INTO kegiatan(
								tgl,
								tgl_act, 
								user_act, 
								kegiatan,
								lokasi,
								status,
								hasil,
								tgl_selesai,
								jam_selesai,
								user_selesai,
								nama_file,
								ukuran_file,
								direktori) 
						VALUES(	
								'$_POST[tgl]',  
								'$waktu', 
								'$_SESSION[simrsig]', 
								'$_POST[kegiatan]',
								'$_POST[lokasi]',
								'0',
								'',
								'',
								'',
								'0',
								'',
								'0',
								'')");
	}
	else{
		move_uploaded_file($lokasi_file,"$direktori");
		mysql_query("INSERT INTO kegiatan(
								tgl,
								tgl_act, 
								user_act, 
								kegiatan,
								lokasi,
								status,
								hasil,
								tgl_selesai,
								jam_selesai,
								user_selesai,
								nama_file,
								ukuran_file,
								direktori) 
						VALUES(	
								'$_POST[tgl]',  
								'$waktu', 
								'$_SESSION[simrsig]', 
								'$_POST[kegiatan]',
								'$_POST[lokasi]',
								'0',
								'',
								'',
								'',
								'0',
								'$nama_file',
								'$ukuran_file',
								'$direktori')");
	}
	header('location:media.php?module='.$module);
}

//  Edit Kegiatan SIMRS
elseif ($module=='kegiatan' AND $act=='update'){
	$lokasi_file 	= $_FILES['fupload']['tmp_name'];
	$nama_file   	= $_FILES['fupload']['name'];
	$ukuran_file 	= $_FILES['fupload']['size'];
	$direktori 		= "files/$nama_file";
	
	if (empty($lokasi_file)){
	mysql_query("UPDATE kegiatan SET 
						kegiatan		= '$_POST[kegiatan]',
						lokasi			= '$_POST[lokasi]',
						status			= '$_POST[status]',
						hasil			= '$_POST[hasil]',
						tgl_selesai		= '$tgl',
						jam_selesai		= '$waktu',
						user_selesai	= '$_SESSION[simrsig]'
				WHERE id_kegiatan = '$_POST[id]'");
	}
	else{
	move_uploaded_file($lokasi_file,"$direktori");
	mysql_query("UPDATE kegiatan SET
						kegiatan		= '$_POST[kegiatan]',
						lokasi			= '$_POST[lokasi]',
						status			= '$_POST[status]',
						hasil			= '$_POST[hasil]',
						tgl_selesai		= '$tgl',
						jam_selesai		= '$waktu',
						user_selesai	= '$_SESSION[simrsig]',
						nama_file		= '$nama_file',
						ukuran_file		= '$ukuran_file',
						direktori		= '$direktori'
				WHERE id_kegiatan = '$_POST[id]'");
	}					
	header('location:media.php?module='.$module);
}

// Input Perbaikan Modul
elseif ($module=='perbaikan_modul' AND $act=='input'){
	$lokasi_file 	= $_FILES['fupload']['tmp_name'];
	$nama_file   	= $_FILES['fupload']['name'];
	$ukuran_file 	= $_FILES['fupload']['size'];
	$direktori 		= "aplikasi/$nama_file";
	
	if (empty($lokasi_file)){
		mysql_query("INSERT INTO aplikasi(
								tgl,
								tgl_act, 
								user_act, 
								id_barang,
								id_unit,
								perbaikan,
								status,
								tgl_update,
								act_update,
								respontime,
								keterangan,
								user_update,
								nama_file,
								ukuran_file,
								direktori) 
						VALUES(	
								'$tgl',  
								'$waktu', 
								'$_SESSION[simrsig]', 
								'$_POST[id_barang]',
								'$_POST[id_unit]',
								'$_POST[perbaikan]',
								'0',
								'',
								'',
								'',
								'',
								'0',
								'',
								'0',
								'')");
	}
	else{
		move_uploaded_file($lokasi_file,"$direktori");
		mysql_query("INSERT INTO aplikasi(
								tgl,
								tgl_act, 
								user_act, 
								id_barang,
								id_unit,
								perbaikan,
								status,
								tgl_update,
								act_update,
								respontime,
								keterangan,
								user_update,
								nama_file,
								ukuran_file,
								direktori) 
						VALUES(	
								'$tgl',  
								'$waktu', 
								'$_SESSION[simrsig]', 
								'$_POST[id_barang]',
								'$_POST[id_unit]',
								'$_POST[perbaikan]',
								'0',
								'',
								'',
								'',
								'',
								'0',
								'$nama_file ',
								'$ukuran_file',
								'$direktori')");
	}
	header('location:media.php?module='.$module);
}

//  Edit perbaikan modul SIMRS
elseif ($module=='perbaikan_modul' AND $act=='update'){
	$lokasi_file 	= $_FILES['fupload']['tmp_name'];
	$nama_file   	= $_FILES['fupload']['name'];
	$ukuran_file 	= $_FILES['fupload']['size'];
	$direktori 		= "aplikasi/$nama_file";
	
	if (empty($lokasi_file)){
	mysql_query("UPDATE aplikasi SET 
						id_barang		= '$_POST[id_barang]',
						id_unit			= '$_POST[id_unit]',
						perbaikan		= '$_POST[perbaikan]'
				WHERE id = '$_POST[id]'");
	}
	else{
	move_uploaded_file($lokasi_file,"$direktori");
	mysql_query("UPDATE aplikasi SET
						id_barang		= '$_POST[id_barang]',
						id_unit			= '$_POST[id_unit]',
						perbaikan		= '$_POST[perbaikan]',
						nama_file		= '$nama_file',
						ukuran_file		= '$ukuran_file',
						direktori		= '$direktori'
				WHERE id = '$_POST[id]'");
	}					
	header('location:media.php?module='.$module);
}

//  Verif perbaikan modul 
elseif ($module=='perbaikan_modul' AND $act=='verif'){
	$tgl_minta	= $_POST['tgl'];
	$kemarin 	= new DateTime($tgl_minta);  
	$kini 		= new DateTime($tgl);  
	$selisi 	= $kini->diff($kemarin)->format('%a hari');
	
	mysql_query("UPDATE aplikasi SET 
						status			= '$_POST[status]',
						tgl_update		= '$tgl',
						act_update		= '$waktu',
						respontime		= '$selisi',
						keterangan		= '$_POST[keterangan]',
						user_update		= '$_SESSION[simrsig]'
				WHERE id = '$_POST[id]'");
	
	header('location:media.php?module='.$module);
}
?>
