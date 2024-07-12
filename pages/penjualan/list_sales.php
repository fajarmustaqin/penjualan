<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit;
}

// Koneksi ke database
include "../../koneksi.php";

$pageTitle = "Daftar Penjualan";



$sql = "SELECT s.sale_id, c.nama, s.sale_date, SUM(sd.qty * p.price) as total
        FROM Sales s
        JOIN customer c ON s.customer_id = c.customer_id
        JOIN sales_detail sd ON s.sale_id = sd.sale_id
        JOIN products p ON sd.product_id = p.product_id
        GROUP BY s.sale_id, c.nama, s.sale_date";

$result = $conn->query($sql);

include '../../layouts/header.php';

$flashMessage = isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : '';
unset($_SESSION['flash_message']);

?>
<div class="container">
    <div class="card">
        <div class="card-header bg-info">
            <h2>Daftar Penjualan</h2>
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
                        <th class="text-center">No</th>
                        <th class="text-center">ID Penjualan</th>
                        <th class="text-center">Nama Pelanggan</th>
                        <th class="text-center">Tanggal Penjualan</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no =1; while ($sale = $result->fetch_assoc()) { ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?php echo $sale['sale_id']; ?></td>
                            <td class="text-center"><?php echo $sale['nama']; ?></td>
                            <td class="text-center"><?php echo $sale['sale_date']; ?></td>
                            <td><?php echo number_format($sale['total'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>