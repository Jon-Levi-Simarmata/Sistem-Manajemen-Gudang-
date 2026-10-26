<?php
session_start();
require_once __DIR__ . '/../controllers/BarangKeluarController.php';

// Ambil path URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/Sistem-Manajemen-Gudang-/public';

if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

if ($uri === '' || $uri === '/index.php') {
    $uri = '/';
}

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

    case '/transaksi/barang-keluar':
        $title = "Daftar Barang Keluar";

        $controller = new BarangKeluarController();
        $transaksi = $controller->index();

        ob_start();
        require __DIR__ . '/../views/pages/transaksi/barang_keluar.php';
        $content = ob_get_clean();
        break;
        
    case '/transaksi/store':
        $controller = new BarangKeluarController();
        echo $controller->store();
        exit;
    
    
    case '/transaksi/update':
        $controller = new BarangKeluarController();
        echo $controller->update((int) ($_POST['id'] ?? 0));
        exit;

    case '/transaksi/delete':
        $controller = new BarangKeluarController();
        echo $controller->delete((int) ($_POST['id'] ?? 0));
        exit;


    default:
        http_response_code(404);
        echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
        exit;
}

// Render tampilan menggunakan Layout Utama
require __DIR__ . '/../views/layouts/main.php';