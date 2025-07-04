<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Input Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">Form Input Mahasiswa</h2>
  <form action="insert_mahasiswa.php" method="POST">
    <div class="mb-3">
      <label for="nim" class="form-label">NIM</label>
      <input type="text" class="form-control" name="nim" required>
    </div>
    <div class="mb-3">
      <label for="nama" class="form-label">Nama</label>
      <input type="text" class="form-control" name="nama" required>
    </div>
    <div class="mb-3">
      <label for="jurusan" class="form-label">Jurusan</label>
      <input type="text" class="form-control" name="jurusan" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="lihat_mahasiswa_V2.php" class="btn btn-secondary">Lihat Data</a>
  </form>
</div>
</body>
</html>
