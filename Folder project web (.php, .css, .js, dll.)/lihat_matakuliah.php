<?php
include "koneksi.php";

// Handle Tambah Matakuliah dengan prepared statement
$errors = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kd_mk = trim($_POST['kd_mk']);
    $nama = trim($_POST['nama']);
    $sks = (int)$_POST['sks'];

    if ($kd_mk === '' || $nama === '' || $sks <= 0) {
        $errors = "Semua field wajib diisi dengan benar.";
    } else {
        $stmt_insert = $conn->prepare("INSERT INTO matakuliah (kd_mk, nama, sks) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("ssi", $kd_mk, $nama, $sks);

        if ($stmt_insert->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $errors = "Gagal menambahkan matakuliah. Mungkin kode sudah terdaftar.";
        }
        $stmt_insert->close();
    }
}

// Pencarian aman
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$like_cari = "%$cari%";

if ($cari !== '') {
    $stmt = $conn->prepare("SELECT kd_mk, nama, sks FROM matakuliah WHERE nama LIKE ? OR kd_mk LIKE ? ORDER BY kd_mk ASC");
    $stmt->bind_param("ss", $like_cari, $like_cari);
} else {
    $stmt = $conn->prepare("SELECT kd_mk, nama, sks FROM matakuliah ORDER BY kd_mk ASC");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Matakuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📘 Daftar Matakuliah</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">➕ Tambah Matakuliah</button>
    </div>

    <!-- Form Pencarian -->
    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="cari" class="form-control" placeholder="Cari nama atau kode matakuliah..." value="<?= htmlspecialchars($cari) ?>">
            <button type="submit" class="btn btn-primary">🔍 Cari</button>
        </div>
    </form>

    <?php if ($errors): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errors) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-primary">
                <tr>
                    <th>Kode MK</th>
                    <th>Nama MK</th>
                    <th>SKS</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kd_mk']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['sks']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted">Tidak ada data ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Matakuliah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Matakuliah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kd_mk" class="form-label">Kode Matakuliah</label>
                        <input type="text" name="kd_mk" id="kd_mk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Matakuliah</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="sks" class="form-label">SKS</label>
                        <input type="number" name="sks" id="sks" class="form-control" min="1" max="6" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
