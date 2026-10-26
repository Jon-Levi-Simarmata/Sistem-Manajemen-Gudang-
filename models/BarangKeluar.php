
<?php

class BarangKeluar
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // READ: mengambil semua transaksi barang keluar
    public function getAll()
    {
        $sql = "SELECT * FROM barang_keluar ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ: mengambil satu transaksi berdasarkan ID
    public function getById($id)
    {
        $sql = "SELECT * FROM barang_keluar WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CREATE: menyimpan transaksi baru
    public function create($data)
    {
        $sql = "INSERT INTO barang_keluar
                (barcode, jumlah, tujuan)
                VALUES (:barcode, :jumlah, :tujuan)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'barcode' => $data['barcode'],
            'jumlah'  => $data['jumlah'],
            'tujuan'  => $data['tujuan']
        ]);
    }

    // UPDATE: mengubah data transaksi
    public function update($id, $data)
    {
        $sql = "UPDATE barang_keluar
                SET barcode = :barcode,
                    jumlah = :jumlah,
                    tujuan = :tujuan
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id'      => $id,
            'barcode' => $data['barcode'],
            'jumlah'  => $data['jumlah'],
            'tujuan'  => $data['tujuan']
        ]);
    }

    // DELETE: menghapus transaksi
    public function delete($id)
    {
        $sql = "DELETE FROM barang_keluar WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}
