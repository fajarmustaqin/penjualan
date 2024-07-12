<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit;
}

$pageTitle = "Dashboard Admin - Beranda";

// Include file koneksi ke database
include '../../koneksi.php';

// Query untuk menghitung jumlah produk
$sql_products = "SELECT COUNT(*) AS total_products FROM Products";
$result_products = $conn->query($sql_products);
$row_products = $result_products->fetch_assoc();
$total_products = $row_products['total_products'];

// Query untuk menghitung jumlah pelanggan
$sql_customers = "SELECT COUNT(*) AS total_customers FROM Customer";
$result_customers = $conn->query($sql_customers);
$row_customers = $result_customers->fetch_assoc();
$total_customers = $row_customers['total_customers'];

// Query untuk menghitung jumlah penjualan
$sql_sales = "SELECT COUNT(*) AS total_sales FROM Sales";
$result_sales = $conn->query($sql_sales);
$row_sales = $result_sales->fetch_assoc();
$total_sales = $row_sales['total_sales'];

$current_month = date('m');
$sql_total_sales = "SELECT (sd.qty * p.price) AS total_price
        FROM sales s
        JOIN customer c ON s.customer_id = c.customer_id
        JOIN sales_detail sd ON s.sale_id = sd.sale_id
        JOIN products p ON sd.product_id = p.product_id
        WHERE MONTH(s.sale_date) = ?";
$stmt_total_sales = $conn->prepare($sql_total_sales);
if ($stmt_total_sales === false) {
    die("Kesalahan persiapan pernyataan: " . $conn->error);
}

$current_month = date('m'); // Contoh: Ambil bulan saat ini sebagai contoh
$amt = 0;
$stmt_total_sales->bind_param('s', $current_month);
if ($stmt_total_sales->execute()) {
    $result_total_sales = $stmt_total_sales->get_result();
    if ($result_total_sales->num_rows > 0) {
        while ($row_total_sales = $result_total_sales->fetch_assoc()) {
            $amt +=$row_total_sales['total_price'];
        } // Menggunakan alias total_price
    }
} else {
    echo "Terjadi kesalahan saat menjalankan query: " . $stmt_total_sales->error;
}

$stmt_total_sales->close();

?>

<?php include '../../layouts/header.php'; ?>

<div class="container">
    <div class="row">
        <?php if($_SESSION['level'] == '1'){ ?>
            <div class="col-4">
                <div class="card">
                    <div class="card-header bg-secondary">
                        Total Produk
                    </div>
                    <div class="card-body">
                        <p class="total-info"><?php echo $total_products; ?></p>
                    </div>
                </div>
            </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header bg-success">
                    Total Penjualan
                </div>
                <div class="card-body">
                    <p class="total-info"><?php echo $total_sales; ?></p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header bg-info">
                    Total Pelanggan
                </div>
                <div class="card-body">
                    <p class="total-info"><?php echo $total_customers; ?></p>
                </div>
            </div>
        </div>
        <?php } else{?>
            <div class="col-4">
                <div class="card">
                    <div class="card-header bg-success">
                        Total Pemasukan Bulan Ini
                    </div>
                    <div class="card-body">
                        <p class="total-info"><?php echo number_format($amt); ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>
