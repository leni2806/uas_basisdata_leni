<?php
include 'koneksi.php';

// Pencarian aman
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$like_cari = "%$cari%";

$sql = "SELECT m.nim, m.nama AS nama_mahasiswa, mk.nama AS nama_mk, d.nama AS nama_dosen, jm.hari, jm.jam, jm.ruang
        FROM krsmahasiswa km
        JOIN mahasiswa m ON km.nim = m.nim
        JOIN matakuliah mk ON km.kd_mk = mk.kd_mk
        JOIN dosen d ON km.kd_ds = d.kd_ds
        JOIN jadwalmengajar jm ON jm.kd_mk = km.kd_mk AND jm.kd_ds = km.kd_ds
        WHERE m.nim LIKE ? OR m.nama LIKE ?
        ORDER BY m.nim ASC, jm.hari ASC, jm.jam ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $like_cari, $like_cari);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan KRS Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; padding: 20px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { background: white; }
        .table th { background: #0d6efd; color: white; }
        .search-box { max-width: 400px; margin: auto; }
        .no-data { text-align: center; color: #888; font-style: italic; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>📑 Laporan KRS Mahasiswa</h2>

    <!-- Form Pencarian -->
    <form method="get" class="mb-3 search-box">
        <div class="input-group">
            <input type="text" name="cari" class="form-control" placeholder="Cari NIM atau nama mahasiswa..." value="<?= htmlspecialchars($cari) ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Ruang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nim']) ?></td>
                            <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                            <td><?= htmlspecialchars($row['nama_mk']) ?></td>
                            <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
                            <td><?= htmlspecialchars($row['hari']) ?></td>
                            <td><?= htmlspecialchars($row['jam']) ?></td>
                            <td><?= htmlspecialchars($row['ruang']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="no-data">Tidak ada data KRS Mahasiswa ditemukan.</p>
    <?php endif; ?>

</div>

<?php
$stmt->close();
$conn->close();
?>

</body>
</html>
