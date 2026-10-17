<?php
// Konfigurasi Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_gudang";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$pesan = "";

// Handle Form Submission (Backend PHP)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $barcode = $conn->real_escape_string($_POST['barcode']);
    $jumlah = intval($_POST['jumlah']);

    $cek = $conn->query("SELECT * FROM products WHERE barcode = '$barcode'");
    
    if ($cek->num_rows > 0) {
        $data = $cek->fetch_assoc();
        $stok_sekarang = $data['stok'];
        $rak_sekarang = $data['rak'];

        if ($action === 'masuk') {
            $stok_baru = $stok_sekarang + $jumlah;
            $conn->query("UPDATE products SET stok = $stok_baru WHERE barcode = '$barcode'");
            $conn->query("INSERT INTO transactions (barcode, jenis_transaksi, jumlah, tujuan_rak) VALUES ('$barcode', 'MASUK', $jumlah, '$rak_sekarang')");
            $pesan = "<div class='alert success'>Berhasil! Barang masuk dicatat.</div>";

        } elseif ($action === 'keluar') {
            if ($stok_sekarang >= $jumlah) {
                $stok_baru = $stok_sekarang - $jumlah;
                $conn->query("UPDATE products SET stok = $stok_baru WHERE barcode = '$barcode'");
                $conn->query("INSERT INTO transactions (barcode, jenis_transaksi, jumlah, asal_rak) VALUES ('$barcode', 'KELUAR', $jumlah, '$rak_sekarang')");
                $pesan = "<div class='alert success'>Berhasil! Barang keluar dicatat.</div>";
            } else {
                $pesan = "<div class='alert error'>Gagal! Stok tidak mencukupi.</div>";
            }

        } elseif ($action === 'mutasi') {
            $rak_tujuan = $conn->real_escape_string($_POST['rak_tujuan']);
            if ($stok_sekarang >= $jumlah) {
                $conn->query("UPDATE products SET rak = '$rak_tujuan' WHERE barcode = '$barcode'");
                $conn->query("INSERT INTO transactions (barcode, jenis_transaksi, jumlah, asal_rak, tujuan_rak) VALUES ('$barcode', 'MUTASI', $jumlah, '$rak_sekarang', '$rak_tujuan')");
                $pesan = "<div class='alert success'>Berhasil! Mutasi barang ke $rak_tujuan berhasil.</div>";
            } else {
                $pesan = "<div class='alert error'>Gagal! Stok tidak cukup untuk dimutasi.</div>";
            }
        }
    } else {
        $pesan = "<div class='alert error'>Barang dengan Barcode tersebut tidak ditemukan!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Gudang & Barcode</title>
    <!-- Menghubungkan File CSS Eksternal -->
    <link rel="stylesheet" href="style.css">
    <!-- Library JavaScript untuk Scan Barcode via Kamera HP -->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>

<div class="container">
    <h1>Sistem Manajemen Gudang</h1>
    <p><i>Warehouse Stock Opname & Mutasi Antar Rak via Barcode HP</i></p>

    <?= $pesan; ?>

    <!-- Bagian Form dan Scanner -->
    <div class="card">
        <h2>Scan Barcode & Transaksi</h2>
        
        <!-- Elemen Kamera Scanner Barcode -->
        <div id="reader"></div>

        <form method="POST" id="transactionForm">
            <div class="form-group">
                <label>Barcode Barang</label>
                <input type="text" id="barcode" name="barcode" required placeholder="Hasil scan akan muncul otomatis...">
            </div>

            <div class="form-group">
                <label>Jenis Transaksi</label>
                <select name="action" id="action" onchange="toggleMutasi()">
                    <option value="masuk">Barang Masuk (Supplier)</option>
                    <option value="keluar">Barang Keluar (Distribusi)</option>
                    <option value="mutasi">Mutasi Antar Rak</option>
                </select>
            </div>

            <div class="form-group" id="rakTujuanGroup" style="display:none;">
                <label>Rak Tujuan Baru</label>
                <input type="text" name="rak_tujuan" placeholder="Contoh: Rak C3">
            </div>

            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" value="1" min="1" required>
            </div>

            <button type="submit">Proses Transaksi</button>
        </form>
    </div>

    <!-- Tabel Data Stok -->
    <div class="card">
        <h2>Data Stok & Peringatan Reorder Point</h2>
        <table>
            <thead>
                <tr>
                    <th>Barcode</th>
                    <th>Nama Barang</th>
                    <th>Rak Saat Ini</th>
                    <th>Stok</th>
                    <th>Min. Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM products");
                while($row = $result->fetch_assoc()) {
                    $is_reorder = $row['stok'] <= $row['min_stok'];
                    $row_class = $is_reorder ? "warning-stock" : "";
                    echo "<tr class='$row_class'>";
                    echo "<td>{$row['barcode']}</td>";
                    echo "<td>{$row['nama_barang']}</td>";
                    echo "<td>{$row['rak']}</td>";
                    echo "<td>{$row['stok']}</td>";
                    echo "<td>{$row['min_stok']}</td>";
                    echo "<td>";
                    if ($is_reorder) {
                        echo "<span style='color: var(--danger); font-weight:bold;'>⚠️ Reorder Segera!</span>";
                    } else {
                        echo "<span style='color: var(--success);'>Aman</span>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Menghubungkan File JavaScript Eksternal -->
<script src="script.js"></script>

</body>
</html>