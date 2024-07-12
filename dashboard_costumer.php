<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 2) {
    header('Location: index.php');
    exit;
}

include "koneksi.php";

// Mengambil informasi pelanggan
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT * FROM customer WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Mengambil riwayat pembelian
$sql = "SELECT s.sale_id, s.sale_date, p.product_name, sd.qty, (sd.qty * p.price) as total_price
        FROM sales s
        JOIN sales_detail sd ON s.sale_id = sd.sale_id
        JOIN products p ON sd.product_id = p.product_id
        WHERE s.customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$sales = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pelanggan</title>
</head>
<body>
    <h1>Dashboard Pelanggan</h1>
    <h2>Profil Saya</h2>
    <p>Nama: <?php echo htmlspecialchars($customer['nama']); ?></p>
    <p>Email: <?php echo htmlspecialchars($customer['email']); ?></p>
    <p>Alamat: <?php echo htmlspecialchars($customer['alamat']); ?></p>
    <a href="edit_profile.php">Edit Profil</a>
    <h2>Riwayat Pembelian</h2>
    <table border="1">
        <tr>
            <th>ID Penjualan</th>
            <th>Tanggal Penjualan</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
        </tr>
        <?php while ($row = $sales->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['sale_id']; ?></td>
                <td><?php echo $row['sale_date']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['qty']; ?></td>
                <td><?php echo number_format($row['total_price'], 2); ?></td>
            </tr>
        <?php } ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html>
