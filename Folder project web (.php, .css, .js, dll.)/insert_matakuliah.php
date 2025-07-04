<?php
include "koneksi.php";
$kode = $_POST['kode_mk'];
$nama = $_POST['nama_mk'];
$sks = $_POST['sks'];

$query = "INSERT INTO matakuliah (kode_mk, nama_mk, sks) VALUES ('$kode', '$nama', '$sks')";
if(mysqli_query($koneksi, $query)){
  echo "<script>alert('Data berhasil ditambahkan'); window.history.back();</script>";
} else {
  echo "Error: " . mysqli_error($koneksi);
}
?>
