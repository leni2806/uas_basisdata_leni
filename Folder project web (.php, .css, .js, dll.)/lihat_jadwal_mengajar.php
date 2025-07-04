<?php
include "koneksi.php";

// Proses tambah data jika form disubmit
$success = '';
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_jadwal'])) {
    $kd_mk = trim($_POST['kd_mk']);
    $kd_ds = trim($_POST['kd_ds']);
    $ruang = trim($_POST['ruang']);
    $hari = trim($_POST['hari']);
    $jam = trim($_POST['jam']);

    if ($kd_mk && $kd_ds && $ruang && $hari && $jam) {
        $stmt = $conn->prepare("INSERT INTO jadwalmengajar (kd_mk, kd_ds, ruang, hari, jam) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $kd_mk, $kd_ds, $ruang, $hari, $jam);
        if ($stmt->execute()) {
            $success = "✅ Jadwal berhasil ditambahkan.";
        } else {
            $error = "❌ Gagal menambahkan jadwal.";
        }
        $stmt->close();
    } else {
        $error = "❌ Semua field wajib diisi.";
    }
}

// Pencarian
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$param = "%$cari%";

if ($cari != '') {
    $stmt = $conn->prepare("
        SELECT jm.kd_mk, mk.nama AS nama_mk, d.nama AS nama_dosen, jm.ruang, jm.hari, jm.jam 
        FROM jadwalmengajar jm
        JOIN matakuliah mk ON jm.kd_mk = mk.kd_mk
        JOIN dosen d ON jm.kd_ds = d.kd_ds
        WHERE mk.nama LIKE ? OR d.nama LIKE ? OR jm.kd_mk LIKE ?
        ORDER BY jm.hari ASC, jm.jam ASC
    ");
    $stmt->bind_param("sss", $param, $param, $param);
} else {
    $stmt = $conn->prepare("
        SELECT jm.kd_mk, mk.nama AS nama_mk, d.nama AS nama_dosen, jm.ruang, jm.hari, jm.jam 
        FROM jadwalmengajar jm
        JOIN matakuliah mk ON jm.kd_mk = mk.kd_mk
        JOIN dosen d ON jm.kd_ds = d.kd_ds
        ORDER BY jm.hari ASC, jm.jam ASC
    ");
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Jadwal Mengajar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">📕 Jadwal Mengajar</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- Form Pencarian dan Tambah -->
    <div class="d-flex justify-content-between mb-3">
        <form method="get" class="d-flex" role="search">
            <input type="text" name="cari" class="form-control me-2" placeholder="Cari MK, dosen, kode MK..." value="<?= htmlspecialchars($cari) ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Jadwal</button>
    </div>

    <!-- Tabel Jadwal -->
    <table class="table table-bordered table-striped">
        <thead class="table-primary text-center">
            <tr>
                <th>Kode MK</th>
                <th>Matakuliah</th>
                <th>Dosen</th>
                <th>Ruang</th>
                <th>Hari</th>
                <th>Jam</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kd_mk']) ?></td>
                        <td><?= htmlspecialchars($row['nama_mk']) ?></td>
                        <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
                        <td><?= htmlspecialchars($row['ruang']) ?></td>
                        <td><?= htmlspecialchars($row['hari']) ?></td>
                        <td><?= htmlspecialchars($row['jam']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada data ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Tambah Jadwal Mengajar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="tambah_jadwal" value="1">
            <div class="mb-2">
                <label>Kode MK</label>
                <input type="text" name="kd_mk" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Kode Dosen</label>
                <input type="text" name="kd_ds" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Ruang</label>
                <input type="text" name="ruang" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Hari</label>
                <input type="text" name="hari" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Jam</label>
                <input type="text" name="jam" class="form-control" placeholder="Contoh: 08:00 - 10:00" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
$stmt->close();
$conn->close();
?>
</body>
</html>
