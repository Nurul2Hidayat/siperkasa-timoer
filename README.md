# Siperkasa Timoer

**Sistem Informasi Perbaikan Sarana, Prasarana, dan Teknologi Informasi RSUD Mohammad Noer**

Siperkasa Timoer adalah aplikasi yang berfungsi sebagai sistem tiket untuk melaporkan kerusakan dari pegawai ke unit IPSRS dan unit IT di RSUD Mohammad Noer. Selain itu, aplikasi ini juga berfungsi sebagai buku kinerja bagi teknisi yang melakukan perbaikan dan sebagai pencatatan permintaan perbaikan, peminjaman asset dari pengguna atau pegawai lainnya.

---

## Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Fitur](#fitur)
- [Tampilan Aplikasi](#tampilan-aplikasi)
- [Catatan saya](#catatan-dari-saya)

---

## Tentang Proyek

Siperkasa Timoer dikembangkan untuk mempermudah proses pelaporan dan penanganan kerusakan sarana, prasarana, serta teknologi informasi di RSUD Mohammad Noer. Dengan aplikasi ini, pegawai dapat dengan mudah melaporkan kerusakan, dan teknisi dapat mencatat serta memantau kinerja mereka dalam menangani perbaikan.

---

## Fitur

- **Sistem Tiketing:** Memungkinkan pegawai melaporkan kerusakan secara efisien.
- **Sistem QRcode:** sistem permintaan by qrcode untuk memudahkan dalam pembuatan tiket atau permintaan perbaikan.
- **Buku Kinerja Teknisi:** Mencatat dan memantau kinerja teknisi dalam menangani perbaikan.
- **Pencatatan Permintaan Perbaikan:** Menyimpan riwayat permintaan perbaikan dari pengguna.
- **Notifikasi Real-time via WhatsApp:** Memberikan pemberitahuan kepada teknisi terkait tiket baru.
- **Dashboard Administratif:** Menyediakan tampilan keseluruhan status tiket dan kinerja teknisi.
- **versi web mobile:** Memudahkan ketika mengakses dari mobile, yang bisa diakses dengan scan qrcode yang sudah ditentukan.

---

## Tampilan Aplikasi
Terdapat dua bentuk tampilan untuk aplikasi siperkasa, yaitu web pc atau web desktop yang bisa diakses melalui browser di pc, dan web mobile yang bisa dikases di web mobile smart phone.

## web PC

Pada tampilan web pc, lebih ke pengaturan master untuk admin, laporan dashboard, dan laporan kinerja. ada juga pembuatan tiket dan pengerjaan tiket oleh teknisi. untuk web pc bisa diakses dengan membuka link aplikasi dan login dengan username dan password.

### Beranda

![Tampilan Awal](https://rsmn.it-rs.id/it_30-01-24/IKM/siperkasa-cpns/web_halaman_awal.jpg)

pada halaman beranda ini, merupakan halaman memonitoring permintaan perbaikan, baik dari status, data perbaikan dan proses perbaikan yang sudah dilakukan oleh teknisi.

### Pembuatan Tiket Perbaikan

![Pembuatan Tiket Perbaikan](https://rsmn.it-rs.id/it_30-01-24/IKM/siperkasa-cpns/web_permintaan_perbaikan.jpg)

Pembuatan tiket, yang akan diinputkan oleh user ketika ada kendala atau barang yang perlu diperbaiki.

### Tindakan Perbaikan

![Tindakan Perbaikan](https://rsmn.it-rs.id/it_30-01-24/IKM/siperkasa-cpns/web_menambahkan_tindakan_perbaikan.jpg)

Tindakan perbaikan yang diisi oleh teknisi.

### Dashboard Teknisi

![Dashboard Teknisi](https://rsmn.it-rs.id/it_30-01-24/IKM/siperkasa-cpns/web_laporan_grafik.jpg)

Berisi laporan yang berbentuk dashboard untuk memudahkan monitoring hasil perbaikan oleh teknisi.

### Laporan Kinerja

![Laporan Kinerja](https://rsmn.it-rs.id/it_30-01-24/IKM/siperkasa-cpns/web_laporan_detail.jpg)

Berisi laporan detail pekerjaan teknisi. bisa menghitung respontime, waktu pengerjaan, dan waktu selesai dikerjakan.

## web mobile
pada web mobile, lebih mengutamakan fitur tidakan perbaikan. baik dari pembuatan tiket, perbaikan oleh teknisi, peminjaman aset dll. untuk mengakses web mobile harus melalui qrcode yang sudah di sediakan.

### Tampilan Awal

![Tampilan Awal](https://rsmn.it-rs.id/it_30-01-24/IKM/siperkasa-cpns/mobile_tampilan_awal.jpg)

pada tampilan awal web mobile, berisi keterangan aset sesuai dengan qrcode yang sudah di scan di aset tersebut. dan berisi fitur apa saja yang tersedia di aplikasi siperkasa, seperti detail aset, permintaan perbaikan, peminjaman aset, pemeliharaan dll.

### Pembuatan Tiket Perbaikan

![Pembuatan Tiket Perbaikan](https://rsmn.it-rs.id/it_30-01-24/IKM/siperkasa-cpns/mobile_permintaan_perbaikan.jpg)

pembuatan tiket yang bisa dilakukan oleh user.

### Tindakan Perbaikan

![Tindakan Perbaikan](https://rsmn.it-rs.id/it_30-01-24/IKM/siperkasa-cpns/mobile%20menambahkan%20tindakan.jpg)

tindakan perbaikan yang dilakukan oleh teknisi sesuai dengan tiket yang sudah dibuat oleh user.

## Fitur dan teknologi lainnya

Fitur dan teknologi lainnya yang dipakai di aplikasi siperkasa timoer.

## QRCODE

![Teknologi qrcode](https://rsmn.it-rs.id/it_30-01-24/IKM/siperkasa-cpns/qrcode.png)

saya menggunakan teknologi phpqrcode untuk mengenerate dari link menjadi qrcode. saya juga menambahkan logo jawa timur karena aset yang ada dirumah sakit mohammad noer merupakan aset milik pemprov jatim.

## Whatsapp

![Whatsapp](https://rsmn.it-rs.id/it_30-01-24/IKM/siperkasa-cpns/wa_new.jpg)

untuk memudahkan monitoring, evaluasi, dan notifikasi baik ke user dan teknisi. siperkasa dilengkapi dengan notifikasi via whatsapp. notifikasi via wa ini terkirim ke teknisi ketika ada pembuatan tiket baru, dan terkirim juga ke user ketika status tiket diubah menjadi proses ataupun selesai.


### catatan dari saya

tidak banyak yang bisa saya sampaikan, bahkan tidak bisa menyampaikan fitur semua aplikasi sampai selesai. namun ini aplikasi yang sedang saya bangun di RSUD mohammad noer pamekasan sekarang. untuk keamanan data, akses, serta pengkodean sudah saya atur supaya tidak mengancam keamanan data instansi. saya upload aplikasi siperkasa ini di github untuk keperluan portofolio cpns tahun 2024. setelah tes administrasi cpns 2024 selesai. akan saya ubah repository ini menjadi private kembali. terimakasih.
