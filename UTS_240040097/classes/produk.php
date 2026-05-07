<?php
require_once 'config/database.php';

class produk extends database {
    private $table = 'produk';

    public function create($nama_produk, $tipe, $stok, $harga) {
        $qry = "INSERT INTO $this->table (nama_produk, tipe, stok, harga) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("ssid", $nama_produk, $tipe, $stok, $harga);
        return $stmt->execute();
    }

    public function read() {
        $qry = "SELECT * FROM $this->table";
        return $this->conn->query($qry);
    }

    public function readById($id) {
        $qry = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc(); 
    }

    public function update($id, $nama_produk, $tipe, $stok, $harga){
        $qry = "UPDATE $this->table SET nama_produk = ?, tipe = ?, stok = ?, harga = ? WHERE id = ?";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("ssidi", $nama_produk, $tipe, $stok, $harga, $id);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $qry = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function stokMenipis() {
       $qry = "SELECT * FROM $this->table WHERE stok < 5";
       return $this->conn->query($qry);         
    }
}