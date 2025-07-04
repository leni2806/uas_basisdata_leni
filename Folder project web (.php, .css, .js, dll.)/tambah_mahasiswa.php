<?php
session_start();
include 'koneksi.php';

// Inisialisasi variabel error dan sukses
$errors = [];
$success = "";

// Proses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nim = trim($_POST['nim'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jk = $_POST['jk'] ?? '';
    $kota = trim($_POST['kota'] ?? '');

    // Validasi
    if ($nim === '') $errors[] = "NIM wajib diisi.";
    if ($nama === '') $errors[] = "Nama wajib diisi.";
    if ($jk !== 'L' && $jk !== 'P') $errors[] = "Jenis Kelamin wajib dipilih.";
    if ($kota === '') $errors[] = "Kota wajib diisi.";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, jk, kota) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nim, $nama, $jk, $kota);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Data mahasiswa berhasil ditambahkan.";
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Gagal menyimpan data. Mungkin NIM sudah terdaftar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f8; padding: 40px; }
        h2 { color: #2c3e50; }
        form { background: #fff; padding: 20px; max-width: 400px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 10px; }
        input[type="text"], select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px; }
        button { background: #27ae60; color: #fff; border: none; padding: 10px 14px; border-radius: 4px; cursor: pointer; margin-top: 15px; }
        button:hover { background: #2ecc71; }
        .error { background: #e74c3c; color: #fff; padding: 10px; border-radius: 4px; margin-bottom: 10px; }
        .success { background: #2ecc71; color: #fff; padding: 10px; border-radius: 4px; margin-bottom: 10px; }
        a { text-decoration: none; color: #2980b9; }
    </style>
</head>
<body>

    <h2>➕ Tambah Mahasiswa</h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $e) echo htmlspecialchars($e) . "<br>"; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label for="nim">NIM</label>
        <input type="text" name="nim" id="nim" value="<?= htmlspecialchars($nim ?? '') ?>">

        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($nama ?? '') ?>">

        <label for="jk">Jenis Kelamin</label>
        <select name="jk" id="jk">
            <option value="">-- Pilih --</option>
            <option value="L" <?= (isset($jk) && $jk == 'L') ? 'selected' : '' ?>>Laki-laki</option>
            <option value="P" <?= (isset($jk) && $jk == 'P') ? 'selected' : '' ?>>Perempuan</option>
        </select>

        <label for="kota">Kota</label>
        <input type="text" name="kota" id="kota" value="<?= htmlspecialchars($kota ?? '') ?>">

        <button type="submit">💾 Simpan</button>
    </form>

    <p><a href="index.php">⬅ Kembali ke Data Mahasiswa</a></p>

</body>
</html>
