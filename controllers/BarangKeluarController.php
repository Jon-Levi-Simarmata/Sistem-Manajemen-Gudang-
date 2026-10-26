
<?php

require_once __DIR__ . '/../models/BarangKeluar.php';
require_once __DIR__ . '/../config/database.php';

class BarangKeluarController
{
    private $model;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        $this->model = new BarangKeluar($db);
    }

    // READ: menampilkan semua transaksi
    public function index()
    {
        return $this->model->getAll();
    }

    // READ: menampilkan satu transaksi
    public function show($id)
    {
        return $this->model->getById($id);
    }

    // CREATE: menyimpan transaksi baru
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode request tidak diizinkan.');
        }

        $data = $this->ambilData();

        if ($data === false) {
            http_response_code(400);
            exit('Data barang keluar tidak valid.');
        }

        if ($this->model->create($data)) {
            return 'Transaksi barang keluar berhasil disimpan.';
        }

        http_response_code(500);
        return 'Transaksi gagal disimpan.';
    }

    // UPDATE: mengubah transaksi
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode request tidak diizinkan.');
        }

        $data = $this->ambilData();

        if ($data === false) {
            http_response_code(400);
            exit('Data barang keluar tidak valid.');
        }

        if (!$this->model->getById($id)) {
            http_response_code(404);
            return 'Transaksi tidak ditemukan.';
        }

        if ($this->model->update($id, $data)) {
            return 'Transaksi berhasil diperbarui.';
        }

        http_response_code(500);
        return 'Transaksi gagal diperbarui.';
    }

    // DELETE: menghapus transaksi
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode request tidak diizinkan.');
        }

        if (!$this->model->getById($id)) {
            http_response_code(404);
            return 'Transaksi tidak ditemukan.';
        }

        if ($this->model->delete($id)) {
            return 'Transaksi berhasil dihapus.';
        }

        http_response_code(500);
        return 'Transaksi gagal dihapus.';
    }

    // Memeriksa data formulir
    private function ambilData()
    {
        $barcode = trim($_POST['barcode'] ?? '');
        $jumlah = filter_var(
            $_POST['jumlah'] ?? null,
            FILTER_VALIDATE_INT
        );
        $tujuan = trim($_POST['tujuan'] ?? '');

        if (
            $barcode === '' ||
            $jumlah === false ||
            $jumlah === null ||
            $jumlah <= 0 ||
            $tujuan === ''
        ) {
            return false;
        }

        return [
            'barcode' => $barcode,
            'jumlah' => $jumlah,
            'tujuan' => $tujuan
        ];
    }
}
