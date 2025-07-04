<?php
include "koneksi.php";
$nidn = $_POST['nidn'];
$nama = $_POST['nama'];
$prodi = $_POST['prodi'];

$query = "INSERT INTO dosen (nidn, nama, prodi) VALUES ('$nidn', '$nama', '$prodi')";
if(mysqli_query($koneksi, $query)){
  echo "<script>alert('Data berhasil ditambahkan'); window.location='lihat_dosen_V2.php';</script>";
} else {
  echo "Error: " . mysqli_error($koneksi);
}
?>
