<?php 
include 'koneksi.php'; // koneksi database

// Ambil kata kunci pencarian
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';

// Pagination
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

// Query aman menggunakan prepared statement
if ($cari !== '') {
    $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE nama LIKE ? OR nim LIKE ? LIMIT ? OFFSET ?");
    $like = "%$cari%";
    $stmt->bind_param("ssii", $like, $like, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM mahasiswa WHERE nama LIKE ? OR nim LIKE ?");
    $count_stmt->bind_param("ss", $like, $like);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $total_data = $count_result->fetch_assoc()['total'];
} else {
    $stmt = $conn->prepare("SELECT * FROM mahasiswa LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $count_result = $conn->query("SELECT COUNT(*) as total FROM mahasiswa");
    $total_data = $count_result->fetch_assoc()['total'];
}

$total_pages = max(ceil($total_data / $limit), 1);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f8; padding: 40px; }
        h2 { color: #2c3e50; }
        form { margin: 20px 0; }
        input[type="text"] { padding: 8px; width: 250px; border: 1px solid #ccc; border-radius: 4px; }
        button, .btn-success { padding: 8px 14px; border: none; border-radius: 4px; cursor: pointer; }
        button { background: #2980b9; color: #fff; transition: 0.3s; }
        button:hover { background: #3498db; }
        .btn-success { background: #27ae60; color: #fff; text-decoration: none; }
        .btn-success:hover { background: #2ecc71; }
        table { width: 90%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; margin-top: 20px; }
        th, td { padding: 12px 15px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #2980b9; color: #fff; }
        tr:hover { background: #ecf0f1; }
        .pagination { margin-top: 20px; }
        .pagination a, .pagination span { padding: 6px 12px; margin: 0 3px; border-radius: 4px; text-decoration: none; }
        .pagination a { background: #fff; border: 1px solid #ddd; color: #2980b9; }
        .pagination a:hover { background: #2980b9; color: #fff; }
        .pagination span { background: #2980b9; color: #fff; border: 1px solid #2980b9; }
    </style>
</head>
<body>
    <h2>📚 Data Mahasiswa</h2>

    <form method="get">
        <input type="text" name="cari" placeholder="Cari nama atau NIM..." value="<?= htmlspecialchars($cari) ?>">
        <button type="submit">🔍 Cari</button>
    </form>

    <a href="tambah_mahasiswa.php" class="btn-success">➕ Tambah Mahasiswa</a>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Kota</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nim']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= $row['jk'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                        <td><?= htmlspecialchars($row['kota']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data mahasiswa ditemukan.</p>
    <?php endif; ?>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?cari=<?= urlencode($cari) ?>&page=<?= $page - 1 ?>">⬅ Previous</a>
        <?php else: ?>
            <span>⬅ Previous</span>
        <?php endif; ?>

        <span>Halaman <?= $page ?> dari <?= $total_pages ?></span>

        <?php if ($page < $total_pages): ?>
            <a href="?cari=<?= urlencode($cari) ?>&page=<?= $page + 1 ?>">Next ➡</a>
        <?php else: ?>
            <span>Next ➡</span>
        <?php endif; ?>
    </div>

</body>
</html>
