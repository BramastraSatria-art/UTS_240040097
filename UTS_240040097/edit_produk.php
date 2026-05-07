<?php
require_once 'classes/produk.php';
$produk = new Produk();
$error = '';
$success = '';
$id = $_GET['id'] ?? null;
$data = $produk->readById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $tipe = $_POST['tipe'];
    $stok = (int)$_POST['stok'];
    $harga = $_POST['harga'];

    if ($stok < 0) {
        $error = "Stok tidak boleh negatif/minus!";
    } else {
        $produk->update($id, $nama_produk, $tipe, $stok, $harga);
        $success = "Produk berhasil diupdate!";
        $data = $produk->readById($id);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
</head>
<body>

<h1>Sistem Inventaris Toko</h1>
<a href="dashboard.php">Dashboard</a>
<hr>

<h2>Edit Produk</h2>

<?php if ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php endif; ?>

<form method="POST">
    <p>
        <label>Nama Produk</label><br>
        <input type="text" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']) ?>" required>
    </p>
    <p>
        <label>Tipe Produk</label><br>
        <select name="tipe" required>
            <option value="Laptop" <?= $data['tipe'] == 'Laptop' ? 'selected' : '' ?>>Laptop</option>
            <option value="Smartphone" <?= $data['tipe'] == 'Smartphone' ? 'selected' : '' ?>>Smartphone</option>
        </select>
    </p>
    <p>
        <label>Stok</label><br>
        <input type="number" name="stok" value="<?= $data['stok'] ?>" min="0" required>
    </p>
    <p>
        <label>Harga (Rp)</label><br>
        <input type="number" name="harga" value="<?= $data['harga'] ?>" min="0" required>
    </p>
    <button type="submit">Update</button>
    <a href="dashboard.php">Batal</a>
</form>

</body>
</html>