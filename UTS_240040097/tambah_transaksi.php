<?php
require_once 'classes/produk.php';
require_once 'classes/transaksi.php';

$produk = new Produk();
$transaksi = new Transaksi();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produk_id = (int)$_POST['produk_id'];
    $jumlah = (int)$_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    if ($jumlah <= 0) {
        $error = "Jumlah transaksi harus lebih dari 0!";
    } else {
        $dataCek = $produk->readById($produk_id);
        if ($dataCek['stok'] < $jumlah) {
            $error = "Stok tidak mencukupi! Stok tersedia: " . $dataCek['stok'];
        } else {
            $transaksi->create($produk_id, $jumlah, $keterangan);
            $transaksi->kurangiStok($produk_id, $jumlah);
            $success = "Transaksi berhasil dicatat!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi</title>
</head>
<body>

<h1>Sistem Inventaris Toko</h1>
<a href="dashboard.php">Dashboard</a>
<hr>

<h2>Tambah Transaksi</h2>

<?php if ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php endif; ?>

<form method="POST">
    <p>
        <label>Pilih Produk</label><br>
        <select name="produk_id" required>
            <option value="">-- Pilih Produk --</option>
            <?php 
            $dataProduk = $produk->read();
            while($row = $dataProduk->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>">
                    <?= htmlspecialchars($row['nama_produk']) ?> (Stok: <?= $row['stok'] ?>)
                </option>
            <?php endwhile; ?>
        </select>
    </p>
    <p>
        <label>Jumlah</label><br>
        <input type="number" name="jumlah" placeholder="Masukkan jumlah" min="1" required>
    </p>
    <p>
        <label>Keterangan</label><br>
        <textarea name="keterangan" rows="3" placeholder="Masukkan keterangan transaksi"></textarea>
    </p>
    <button type="submit">Simpan</button>
    <a href="dashboard.php">Batal</a>
</form>

</body>
</html>