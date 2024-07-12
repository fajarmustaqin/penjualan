<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 1) {
    header('Location: ../../index.php');
}

// Koneksi ke database
include "../../koneksi.php";

// Mendapatkan daftar produk
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if (!$result) {
    die("Query produk gagal: " . $conn->error);
}

include '../../layouts/header.php';

$flashMessage = isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : '';
unset($_SESSION['flash_message']);

?>
<div class="container">
    <div class="card">
        <div class="card-header bg-info">
            <h2>Daftar Produk</h2>
        </div>
        <div class="card-body">
            <div class="container table-responsive">
            <?php if (!empty($flashMessage)): ?>
                <div class="alert alert-<?php echo strpos($flashMessage, 'berhasil') !== false ? 'success' : 'danger'; ?>" role="alert">
                    <?php echo $flashMessage; ?>
                </div>
            <?php endif; ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID Produk</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $result->fetch_assoc()) { ?>
                        <tr>
                            <td class="text-center"><?php echo $product['product_id']; ?></td>
                            <td><?php echo $product['product_name']; ?></td>
                            <td><?php echo number_format($product['price']); ?></td>
                            <td class="text-center">
                                <a class="btn btn-warning btn-sm" href="update_product.php?id=<?php echo $product['product_id']; ?>">Edit</a> | 
                                <a class="btn btn-danger btn-sm" href="delete_product.php?id=<?php echo $product['product_id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>
