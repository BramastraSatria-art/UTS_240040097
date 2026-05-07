<?php
require_once 'classes/produk.php';

$produk = new Produk();
$id = $_GET['id'] ?? null;

if ($id) {
    $produk->delete($id);
}

header('Location:dashboard.php');
exit;