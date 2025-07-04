<?php
include "koneksi.php";
$nim = $_POST['nim'];
$nama = $_POST['nama'];
$jurusan = $_POST['jurusan'];

$query = "INSERT INTO mahasiswa (nim, nama, jurusan) VALUES ('$nim', '$nama', '$jurusan')";
if(mysqli_query($koneksi, $query)){
  echo "<script>alert('Data berhasil ditambahkan'); window.location='lihat_mahasiswa_V2.php';</script>";
} else {
  echo "Error: " . mysqli_error($koneksi);
}
?>
