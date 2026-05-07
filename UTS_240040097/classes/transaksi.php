<?php
require_once 'config/database.php';

class transaksi extends database {
    private $table = 'transaksi';

    public function create($produk_id, $jumlah, $keterangan) {
        $qry = "INSERT INTO $this->table (produk_id, jumlah, keterangan) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("iis", $produk_id, $jumlah, $keterangan);
        return $stmt->execute();
    }

    public function read() {
        $qry = "SELECT * FROM $this->table";
        return $this->conn->query($qry);
    }

    public function kurangiStok($produk_id, $jumlah){
        $qry = "UPDATE produk SET stok = stok - ? WHERE id = ?";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("ii", $jumlah, $produk_id);
        return $stmt->execute();
    }
}