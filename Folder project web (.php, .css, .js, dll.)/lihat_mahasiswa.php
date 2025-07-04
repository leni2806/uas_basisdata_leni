    <?php
    include 'koneksi.php'; // Menyertakan file koneksi.php

    // Lakukan operasi database di sini
    $sql = "SELECT * FROM mahasiswa"; // Ganti dengan query Anda
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Output data dari setiap baris
        while($row = mysqli_fetch_assoc($result)) {
            echo "id: " . $row["nim"]. " - Nama: " . $row["nama"]. "<br>"; // Ganti dengan kolom yang sesuai
        }
    } else {
        echo "0 results";
    }

    mysqli_close($conn); // Menutup koneksi
    ?>