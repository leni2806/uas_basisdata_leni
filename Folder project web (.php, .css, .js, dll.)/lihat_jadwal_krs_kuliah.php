<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Jadwal, KRS, dan Matakuliah</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            color: #333;
            margin-top: 40px;
        }
        table {
            width: 90%;
            margin: 10px auto 40px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .no-data {
            text-align: center;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>

<!-- 1. JADWALMENGAJAR -->
<h2>Data Jadwal Mengajar</h2>
<?php
$result = mysqli_query($conn, "SELECT * FROM JadwalMengajar");
if (mysqli_num_rows($result) > 0) {
    echo "<table><tr><th>Kode MK</th><th>Kode Dosen</th><th>Hari</th><th>Jam</th><th>Ruang</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['kd_mk']}</td>
                <td>{$row['kd_ds']}</td>
                <td>{$row['hari']}</td>
                <td>{$row['jam']}</td>
                <td>{$row['ruang']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='no-data'>Tidak ada data Jadwal Mengajar.</p>";
}
?>

<!-- 2. KRSMAHASISWA -->
<h2>Data KRS Mahasiswa</h2>
<?php
$result = mysqli_query($conn, "SELECT * FROM KRSMahasiswa");
if (mysqli_num_rows($result) > 0) {
    echo "<table><tr><th>NIM</th><th>Kode MK</th><th>Kode Dosen</th><th>Semester</th><th>Nilai</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['nim']}</td>
                <td>{$row['kd_mk']}</td>
                <td>{$row['kd_ds']}</td>
                <td>{$row['semester']}</td>
                <td>{$row['nilai']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='no-data'>Tidak ada data KRS Mahasiswa.</p>";
}
?>

<!-- 3. MATAKULIAH -->
<h2>Data Matakuliah</h2>
<?php
$result = mysqli_query($conn, "SELECT * FROM Matakuliah");
if (mysqli_num_rows($result) > 0) {
    echo "<table><tr><th>Kode MK</th><th>Nama Matakuliah</th><th>SKS</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['kd_mk']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['sks']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='no-data'>Tidak ada data Matakuliah.</p>";
}
mysqli_close($conn);
?>

</body>
</html>