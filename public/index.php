<?php
session_start();

// Ambil path URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Tentukan judul & halaman yang dipanggil berdasarkan URL
switch ($uri) {
    case '/':
    case '/home':
        $title = "Home - Sistem Manajemen Gudang";
        ob_start();
        require __DIR__ . '/../views/pages/home.php';
        $content = ob_get_clean();
        break;

    case '/products':
        $title = "Stok Barang & Reorder Point";
        // Contoh data dummy untuk tes tampilan
        $products = [
            ['barcode' => '12345678', 'nama_barang' => 'Printer Epson L3210', 'rak' => 'Rak A1', 'stok' => 3, 'min_stok' => 5],
            ['barcode' => '87654321', 'nama_barang' => 'Kertas HVS A4', 'rak' => 'Rak B2', 'stok' => 20, 'min_stok' => 10]
        ];
        ob_start();
        require __DIR__ . '/../views/pages/products/index.php';
        $content = ob_get_clean();
        break;

    case '/transaksi':
        $title = "Scan Barcode & Transaksi Gudang";
        ob_start();
        require __DIR__ . '/../views/pages/transaksi/scan.php';
        $content = ob_get_clean();
        break;

    default:
        http_response_code(404);
        echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
        exit;
}

// Render tampilan menggunakan Layout Utama
require __DIR__ . '/../views/layouts/main.php';