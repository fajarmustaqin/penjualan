<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 1) {
    header('Location: ../../index.php');
    exit;
}

// Koneksi ke database
include "../../koneksi.php";

$product_id = $_GET['id'];

$sql = "DELETE FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Kesalahan persiapan pernyataan: " . $conn->error);
}
$stmt->bind_param('i', $product_id);
if ($stmt->execute()) {
    $_SESSION['flash_message'] = "Produk berhasil dihapus";
    header('location: list_product.php');
} else {
    $_SESSION['flash_message'] = "Terjadi kesalahan: " . $stmt->error;
    header('location: list_product.php');
}
header("Location: list_product.php");
exit;
