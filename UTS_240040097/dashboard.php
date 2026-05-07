<?php
require_once 'classes/produk.php';
require_once 'classes/transaksi.php';

$produk = new Produk();
$transaksi = new Transaksi();

$dataProduk = $produk->read();
$menipis = $produk->stokMenipis();
$dataTransaksi = $transaksi->read();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Inventaris</title>
</head>
<body>

<h1>Sistem Inventaris Toko</h1>
<hr>

<?php if ($menipis->num_rows > 0): ?>
<p><strong>Peringatan: Stok Menipis!</strong></p>
<ul>
    <?php while($row = $menipis->fetch_assoc()): ?>
        <li><?= htmlspecialchars($row['nama_produk']) ?> - Sisa Stok: <?= $row['stok'] ?></li>
    <?php endwhile; ?>
</ul>
<hr>
<?php endif; ?>

<h2>Data Stok Produk</h2>
<a href="tambah_produk.php">Tambah Produk</a>
<br><br>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Tipe</th>
        <th>Stok</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>
    <?php 
    $no = 1;
    while($row = $dataProduk->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
        <td><?= $row['tipe'] ?></td>
        <td>
            <?php if($row['stok'] < 5): ?>
                <strong style="color:red;"><?= $row['stok'] ?> (Stok Menipis)</strong>
            <?php else: ?>
                <?= $row['stok'] ?>
            <?php endif; ?>
        </td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
        <td>
            <a href="edit_produk.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="hapus_produk.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<br>

<h2>Rekap Transaksi</h2>
<a href="tambah_transaksi.php">Tambah Transaksi</a>
<br><br>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>ID Produk</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
        <th>Tanggal</th>
    </tr>
    <?php 
    $no = 1;
    while($row = $dataTransaksi->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['produk_id'] ?></td>
        <td><?= $row['jumlah'] ?></td>
        <td><?= htmlspecialchars($row['keterangan']) ?></td>
        <td><?= $row['dibuat_pada'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>