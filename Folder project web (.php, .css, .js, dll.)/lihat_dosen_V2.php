<?php
include 'koneksi.php';

// ===========================
// Pencarian
// ===========================
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$like_cari = "%$cari%";

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$start = ($page - 1) * $limit;

// Sorting
$allowed_sort = ['kd_ds', 'nama'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $allowed_sort) ? $_GET['sort'] : 'kd_ds';
$order = isset($_GET['order']) && strtolower($_GET['order']) === 'desc' ? 'DESC' : 'ASC';
$next_order = $order === 'ASC' ? 'desc' : 'asc';

// Hitung total data
$stmt_count = $conn->prepare("SELECT COUNT(*) AS total FROM dosen WHERE nama LIKE ? OR kd_ds LIKE ?");
$stmt_count->bind_param("ss", $like_cari, $like_cari);
$stmt_count->execute();
$res_count = $stmt_count->get_result();
$total_row = $res_count->fetch_assoc()['total'];
$total_pages = ceil($total_row / $limit);
$stmt_count->close();

// Export CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=daftar_dosen.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Kode Dosen', 'Nama Dosen']);
    $stmt_export = $conn->prepare("SELECT kd_ds, nama FROM dosen WHERE nama LIKE ? OR kd_ds LIKE ? ORDER BY $sort $order");
    $stmt_export->bind_param("ss", $like_cari, $like_cari);
    $stmt_export->execute();
    $res_export = $stmt_export->get_result();
    while ($row = $res_export->fetch_assoc()) {
        fputcsv($output, [$row['kd_ds'], $row['nama']]);
    }
    fclose($output);
    exit;
}

// Tambah dosen
$success_message = '';
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_dosen'])) {
    $kd_ds = trim($_POST['kd_ds']);
    $nama = trim($_POST['nama']);

    if ($kd_ds === '' || $nama === '') {
        $error_message = 'Kode Dosen dan Nama Dosen wajib diisi.';
    } else {
        $stmt_check = $conn->prepare("SELECT kd_ds FROM dosen WHERE kd_ds = ?");
        $stmt_check->bind_param("s", $kd_ds);
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows > 0) {
            $error_message = 'Kode Dosen sudah terdaftar.';
        } else {
            $stmt_insert = $conn->prepare("INSERT INTO dosen (kd_ds, nama) VALUES (?, ?)");
            $stmt_insert->bind_param("ss", $kd_ds, $nama);
            if ($stmt_insert->execute()) {
                $success_message = 'Dosen berhasil ditambahkan.';
            } else {
                $error_message = 'Gagal menambahkan dosen.';
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}

// Ambil data untuk tampil
$stmt = $conn->prepare("SELECT kd_ds, nama FROM dosen WHERE nama LIKE ? OR kd_ds LIKE ? ORDER BY $sort $order LIMIT ?, ?");
$stmt->bind_param("ssii", $like_cari, $like_cari, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 8px; max-width: 950px; margin: auto; }
        th a { color: white; text-decoration: none; }
        th { cursor: pointer; }
        .pagination a.active { background: #0056b3; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-3">Daftar Dosen</h2>

    <?php if ($success_message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
    <?php elseif ($error_message): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <!-- Form Pencarian dan Export -->
    <form method="get" class="mb-3 d-flex justify-content-center">
        <input type="text" name="cari" class="form-control me-2" style="max-width: 250px;"
               placeholder="Cari nama atau kode dosen..." value="<?= htmlspecialchars($cari) ?>">
        <button type="submit" class="btn btn-primary me-2">Cari</button>
        <a class="btn btn-success" href="?cari=<?= urlencode($cari) ?>&sort=<?= $sort ?>&order=<?= strtolower($order) ?>&export=csv">Export CSV</a>
        <button type="button" class="btn btn-warning ms-2" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Dosen</button>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                <tr>
                    <th><a href="?cari=<?= urlencode($cari) ?>&sort=kd_ds&order=<?= $next_order ?>">Kode Dosen</a></th>
                    <th><a href="?cari=<?= urlencode($cari) ?>&sort=nama&order=<?= $next_order ?>">Nama Dosen</a></th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kd_ds']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">Tidak ada data dosen yang ditemukan.</p>
    <?php endif; ?>

    <?php if ($total_pages > 1): ?>
        <div class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?cari=<?= urlencode($cari) ?>&sort=<?= $sort ?>&order=<?= strtolower($order) ?>&page=<?= $i ?>"
                   class="btn btn-sm btn-primary m-1 <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Tambah Dosen -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="kd_ds" class="form-label">Kode Dosen</label>
                    <input type="text" class="form-control" id="kd_ds" name="kd_ds" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Dosen</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="tambah_dosen" value="1">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah Dosen</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
