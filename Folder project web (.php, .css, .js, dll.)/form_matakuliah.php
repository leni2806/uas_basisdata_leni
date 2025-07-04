<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Input Matakuliah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">Form Input Matakuliah</h2>
  <form action="insert_matakuliah.php" method="POST">
    <div class="mb-3">
      <label for="kode_mk" class="form-label">Kode MK</label>
      <input type="text" class="form-control" name="kode_mk" required>
    </div>
    <div class="mb-3">
      <label for="nama_mk" class="form-label">Nama Matakuliah</label>
      <input type="text" class="form-control" name="nama_mk" required>
    </div>
    <div class="mb-3">
      <label for="sks" class="form-label">SKS</label>
      <input type="number" class="form-control" name="sks" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
</div>
</body>
</html>
