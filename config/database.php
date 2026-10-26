
<?php

class Database
{
    private $host = 'localhost';
    private $db_name = 'NAMA_DATABASE';
    private $username = 'root';
    private $password = '';

    public function connect()
    {
        try {
            $db = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $db->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $db;
        } catch (PDOException $e) {
            throw new RuntimeException(
                'Koneksi database gagal.',
                0,
                $e
            );
        }
    }
}
