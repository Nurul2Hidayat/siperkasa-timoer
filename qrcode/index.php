<?php
	include "phpqrcode/qrlib.php";    // Ini adalah letak pemyimpanan plugin qrcode
	
	$tempdir = "qrcode-img/";        // Nama folder untuk pemyimpanan file qrcode
	
	if (!file_exists($tempdir))        //jika folder belum ada, maka buat
	mkdir($tempdir);
	
	if($_GET['ruangan'] == 1){
		$type = 'ruangan';
		$nama = 'ruangan';
	}else{
		$type = 'aset';
		$nama = 'aset';
	}
	// berikut adalah parameter qr code
	$id 			= $_GET['id'];
	$nama_file		= "qrcode-$nama-$id.png";
	$salt 			= "berisi_salt_untuk_generate_qrcode_aplikasi_siperkasa";
	$filter_token	= base64_encode(base64_encode($salt.'___'.$id.'___'.$type));
	$teks_qrcode	= "http://".$_SERVER['SERVER_NAME']."/it/scan_qrcode/scan_qrcode.php?gid=$filter_token";
	$namafile		= $nama_file;
	$quality		= "H"; // ini ada 4 pilihan yaitu L (Low), M(Medium), Q(Good), H(High)
	$ukuran			= 10; // 1 adalah yang terkecil, 10 paling besar
	$padding		= 1;
	
	QRCode::png($teks_qrcode, $tempdir.$namafile, $quality, $ukuran, $padding);
	
	$file = glob($tempdir . $nama_file);
	if($file){
		$QR = imagecreatefrompng($tempdir.$namafile); // Membaca QR code yang telah dibuat
		$logo = imagecreatefrompng('../assets/images/jatim_border.png'); // Membaca logo yang akan ditambahkan

		$QR_width = imagesx($QR);
		$QR_height = imagesy($QR);

		$logo_width = imagesx($logo);
		$logo_height = imagesy($logo);

		// Ukuran logo yang diinginkan (misal, 20% dari ukuran QR code)
		$logo_qr_width = $QR_width / 5;
		$scale = $logo_width / $logo_qr_width;
		$logo_qr_height = $logo_height / $scale;

		// Posisi logo di tengah QR code
		$from_width = ($QR_width - $logo_qr_width) / 2;

		// Menyisipkan logo ke QR code
		imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

		// Menyimpan QR code dengan logo
		imagepng($QR, $tempdir.$namafile);

		// Membersihkan memori
		imagedestroy($QR);
		imagedestroy($logo);

		// Memeriksa apakah file berhasil dibuat
		$file = glob($tempdir . $nama_file);
		if($file) {
			echo 1;
		} else {
			echo 0;
		}
	}else{
		echo 0;
	}
?>