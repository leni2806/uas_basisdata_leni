# 📘 Sistem Akademik Mini

### Nama : Leni
### Nim : 312410442
### Kelas : TI.24.A5
### Matkul : Basis data

---

## 🗄️ Struktur Tabel

### **5 tabel utama**:

---

### 1️⃣ **`🧑‍🎓 mahasiswa`**  
- `nim` (PK)  
- `nama`  
- `jk`  
- `tgl_lahir`  
- `jalan`  
- `kota`  
- `kodepos`  
- `no_hp`  
- `kd_ds` (FK ke `dosen.kd_ds`)

### 2️⃣ **`👨‍🏫 dosen`**  
- `kd_ds` (PK)  
- `nama`

### 3️⃣ **`📚 matakuliah`**  
- `kd_mk` (PK)  
- `nama`  
- `sks`

### 4️⃣ **`🗓️ jadwalmengajar`**  
- `kd_mk` (PK, FK ke `matakuliah.kd_mk`)  
- `kd_ds` (PK, FK ke `dosen.kd_ds`)  
- `hari`  
- `jam`  
- `ruang`

### 5️⃣ **`📋 krsmahasiswa`**  
- `nim` (PK, FK ke `mahasiswa.nim`)  
- `kd_mk` (PK, FK ke `matakuliah.kd_mk`)  
- `kd_ds` (FK ke `dosen.kd_ds`)  
- `semester`  
- `nilai`

---

## ⚙️ Penjelasan Fitur Aplikasi

### 1. 📊 Dashboard Statistik Akademik
Menampilkan jumlah total data dari setiap entitas utama menggunakan query SELECT COUNT(*):

👨‍🎓 Mahasiswa (mahasiswa)

👨‍🏫 Dosen (dosen)

📚 Matakuliah (matakuliah)

🗓️ Jadwal Mengajar (jadwalmengajar)

📋 KRS (krsmahasiswa)


### 2. 🧭 Navigasi Menu Utama
Tersedia menu untuk akses cepat ke halaman:

- lihat_mahasiswa_V2.php → Data Mahasiswa

- lihat_dosen_V2.php → Data Dosen

- lihat_matakuliah.php → Data Matakuliah

- lihat_jadwal_mengajar.php → Jadwal Mengajar

- laporan_krs.php → Laporan KRS


### 3. 💬 Quotes Motivasi Acak
Menampilkan kutipan motivasi yang berubah setiap kali halaman direfresh. Diambil dari array PHP secara acak.


### 4. ➕ Tombol Aksi Cepat
Tambah Data ➜ ke tambah_data.php

Cetak Laporan ➜ ke cetak_laporan.php (dalam tab baru)


### 5. 🕒 Jam dan Tanggal Real-Time
Menampilkan waktu saat ini di header atas dengan JavaScript (startTime())

Footer juga menampilkan waktu server saat halaman terakhir diperbarui

###🧪 Teknologi yang Digunakan
PHP (Plain)

- MySQLi untuk koneksi database

- HTML5 + CSS3

- Bootstrap 5 CDN

- JavaScript DOM

---

## 🖥️ Screenshot Tampilan Aplikasi

| Dashboard |
<img src="/dashboard.png" width="500">

| Mahasiswa |
<img src="/mahasiswa.png" width="500"> 

| Dosen |
<img src="/dosen.png" width="500">

| Matakuliah |
<img src="/matakuliah.png" width="500">

| Jadwal |
<img src="/jadwal.png" width="500">

| Krs |
<img src="/krs.png" width="500">

---

## 💻 Cuplikan Fungsi SQL/UDF yang Digunakan

```sql
--  UPPER
SELECT UPPER(nama) AS hasil_upper FROM mahasiswa;

-- IFNULL
SELECT IFNULL(nilai, 'Belum Dinilai') AS hasil_ifnull FROM krsmahasiswa;

-- DATEDIFF
SELECT DATEDIFF(CURRENT_DATE, tgl_lahir) AS umur_dalam_hari FROM mahasiswa;

-- NOW
SELECT NOW() AS tanggal_laporan;

---

** OUTPUT **
<img src="/Concat.png" width="500">

** OUTPUT **
<img src="/Upper.png" width="500">

** OUTPUT **
<img src="/Ifinull.png" width="500">

** OUTPUT **
<img src="/Datediff.png" width="500">

** OUTPUT **
<img src="/Now.png" width="500">

---

## 📥 Cara Menjalankan

1️⃣ Import `uas_basisdata.sql` ke phpMyAdmin:  
- Buat database `uas_basisdata`  
- Import file .sql

2️⃣ Letakkan folder project ke `C:/xampp/htdocs/uas_basisdata/`  
3️⃣ Sesuaikan `koneksi.php` jika user/password MySQL berbeda  
4️⃣ Jalankan Apache & MySQL di XAMPP  
5️⃣ Akses di browser:
```
http://localhost/uas_basisdata/
```

---

## 🤝 Leni

Sistem Akademik Mini  
Mata Kuliah Basis Data  
Universitas Pelita Bangsa
