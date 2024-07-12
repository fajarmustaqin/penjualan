<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit;
}

// Koneksi ke database
include "../../koneksi.php";

// Mendapatkan parameter pencarian
$search_keyword = isset($_GET['search_keyword']) ? $_GET['search_keyword'] : '';
$search_date = isset($_GET['search_date']) ? $_GET['search_date'] : '';
$search_product = isset($_GET['search_product']) ? $_GET['search_product'] : '';

// Query dasar
$sql = "SELECT s.sale_id, c.nama, s.sale_date, p.product_name, sd.qty, (sd.qty * p.price) as total_price
        FROM sales s
        JOIN customer c ON s.customer_id = c.customer_id
        JOIN sales_detail sd ON s.sale_id = sd.sale_id
        JOIN products p ON sd.product_id = p.product_id";

// Menambahkan kondisi pencarian jika ada
if ($search_keyword || $search_date || $search_product) {
    $sql .= " WHERE";
    $conditions = [];
    if ($search_keyword) {
        $conditions[] = " c.nama LIKE '%" . $conn->real_escape_string($search_keyword) . "%'";
    }
    if ($search_date) {
        $conditions[] = " s.sale_date = '" . $conn->real_escape_string($search_date) . "'";
    }
    if ($search_product) {
        $conditions[] = " p.product_name LIKE '%" . $conn->real_escape_string($search_product) . "%'";
    }
    $sql .= implode(' AND ', $conditions);
}

$result = $conn->query($sql);

if (!$result) {
    die("Query penjualan gagal: " . $conn->error);
}

$pageTitle = "Report Penjualan";

include '../../layouts/header.php';
?>
<div class="container">
    <div class="card">
        <div class="card-header bg-success">
            <h2>Laporan Penjualan</h2>
        </div>
        <div class="card-body">
            <form method="get" action="">
                <div class="row">
                    <div class="col-3">
                        <input type="text" id="search_keyword" class="form-control" name="search_keyword" placeholder="Cari Nama Pelanggan" value="<?php echo htmlspecialchars($search_keyword); ?>">
                    </div>
                    <div class="col-3">
                        <input type="text" id="search_product" class="form-control" placeholder="Cari Nama Produk" name="search_product" value="<?php echo htmlspecialchars($search_product); ?>">
                    </div>
                    <div class="col-3">
                        <input type="date" id="search_date" name="search_date" class="form-control" placeholder="Cari Tanggal" value="<?php echo htmlspecialchars($search_date); ?>">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </div>
            </form><br>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Penjualan</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal Penjualan</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['sale_id']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['sale_date']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['qty']; ?></td>
                            <td><?php echo number_format($row['total_price'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>