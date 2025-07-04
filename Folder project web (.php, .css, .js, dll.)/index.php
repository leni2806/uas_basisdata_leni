<?php
include 'koneksi.php';

$jumlah_mahasiswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM mahasiswa"))['total'];
$jumlah_dosen = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM dosen"))['total'];
$jumlah_matakuliah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM matakuliah"))['total'];
$jumlah_jadwal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM jadwalmengajar"))['total'];
$jumlah_krs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM krsmahasiswa"))['total'];

// Quotes motivasi acak
$quotes = [
    "Belajar hari ini, sukses di masa depan.",
    "Tetap semangat, ilmu adalah investasi.",
    "Jangan lelah untuk terus mencoba.",
    "Setiap hari adalah peluang untuk berkembang.",
    "Kesuksesan dimulai dari tekad dan usaha."
];
$quote = $quotes[array_rand($quotes)];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Sistem Akademik Mini</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      animation: fadeIn 1s ease-in;
    }
    @keyframes fadeIn {
      from {opacity: 0;}
      to {opacity: 1;}
    }
    header {
      background: linear-gradient(135deg, #007bff, #00bfff);
      color: white;
      padding: 30px 0 10px 0;
      text-align: center;
    }
    #clock {
      font-size: 1.2rem;
      font-weight: 500;
      margin-top: 5px;
    }
    nav {
      background: #fff;
      padding: 15px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }
    nav a {
      margin: 0 10px;
      color: #007bff;
      text-decoration: none;
      font-weight: 500;
    }
    nav a:hover {
      text-decoration: underline;
    }
    .hero-wave {
      position: relative;
      width: 100%;
      overflow: hidden;
      line-height: 0;
    }
    .hero-wave svg {
      position: relative;
      display: block;
      width: calc(170% + 1.3px);
      height: 100px;
    }
    .card-stat {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }
    .card-stat:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    footer {
      background: #007bff;
      color: #fff;
      text-align: center;
      padding: 15px 0;
      margin-top: 40px;
    }
  </style>
</head>
<body onload="startTime()">

<header>
  <h1>Sistem Akademik Mini</h1>
  <p>Universitas Pelita Bangsa</p>
  <div id="clock"></div>
</header>

<div class="hero-wave">
  <svg viewBox="0 0 500 150" preserveAspectRatio="none">
    <path d="M-0.00,49.98 C150.00,150.00 349.89,-49.98 500.00,49.98 L500.00,150.00 L-0.00,150.00 Z"
          style="stroke: none; fill: #007bff;"></path>
  </svg>
</div>

<nav>
  <a href="lihat_mahasiswa_V2.php">👨‍🎓 Mahasiswa</a>
  <a href="lihat_dosen_V2.php">👨‍🏫 Dosen</a>
  <a href="lihat_matakuliah.php">📚 Matakuliah</a>
  <a href="lihat_jadwal_mengajar.php">🗓️ Jadwal Mengajar</a>
  <a href="laporan_krs.php">📋 Laporan KRS</a>
</nav>

<section class="container my-5">
  <h3 class="text-center mb-3">📊 Dashboard Akademik</h3>
  <p class="text-center fst-italic"><?= $quote ?></p>

  <div class="row g-4 justify-content-center">
  <div class="col-6 col-md-2">
    <a href="lihat_mahasiswa_V2.php" style="text-decoration: none;">
      <div class="card text-white bg-primary card-stat p-3 text-center">
        <div class="h2">👨‍🎓</div>
        <h4><?= $jumlah_mahasiswa ?></h4>
        <p>Mahasiswa</p>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-2">
    <a href="lihat_dosen_V2.php" style="text-decoration: none;">
      <div class="card text-white bg-success card-stat p-3 text-center">
        <div class="h2">👨‍🏫</div>
        <h4><?= $jumlah_dosen ?></h4>
        <p>Dosen</p>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-2">
    <a href="lihat_matakuliah.php" style="text-decoration: none;">
      <div class="card text-dark bg-warning card-stat p-3 text-center">
        <div class="h2">📚</div>
        <h4><?= $jumlah_matakuliah ?></h4>
        <p>Matakuliah</p>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-2">
    <a href="lihat_jadwal_mengajar.php" style="text-decoration: none;">
      <div class="card text-white bg-info card-stat p-3 text-center">
        <div class="h2">🗓️</div>
        <h4><?= $jumlah_jadwal ?></h4>
        <p>Jadwal</p>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-2">
    <a href="laporan_krs.php" style="text-decoration: none;">
      <div class="card text-white bg-danger card-stat p-3 text-center">
        <div class="h2">📋</div>
        <h4><?= $jumlah_krs ?></h4>
        <p>KRS</p>
      </div>
    </a>
  </div>

  <div class="text-center mt-4">
    <a href="tambah_data.php" class="btn btn-outline-primary">➕ Tambah Data</a>
    <a href="cetak_laporan.php" class="btn btn-outline-success" target="_blank">📄 Cetak Laporan</a>
 </div>
</section>

<footer>
  Terakhir diperbarui pada: <?= date("d-m-Y H:i:s") ?> | Sistem Akademik Mini UPB &copy; <?= date('Y') ?>
</footer>

<script>
function startTime() {
  const today = new Date();
  let h = today.getHours();
  let m = today.getMinutes();
  let s = today.getSeconds();
  let d = today.getDate();
  let mo = today.getMonth() + 1;
  let y = today.getFullYear();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('clock').innerHTML = d + '-' + mo + '-' + y + ' | ' + h + ":" + m + ":" + s;
  setTimeout(startTime, 1000);
}
function checkTime(i) {
  return (i < 10) ? "0" + i : i;
}
</script>

<!-- Loading Badge -->
<div id="loadingBadge" style="
  position: fixed;
  top: 20px;
  right: 20px;
  background: #007bff;
  color: white;
  padding: 8px 12px;
  border-radius: 20px;
  font-weight: 500;
  z-index: 9999;
  display: flex;
  align-items: center;
  font-size: 0.9rem;
">
  <div class="spinner-border spinner-border-sm me-2" role="status"></div> Memuat data...
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const badge = document.getElementById('loadingBadge');
  window.addEventListener('load', function() {
    badge.style.display = 'none';
  });
});
</script>

</body>
</html>
