<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 1) {
    header('Location: ../../index.php');
    exit;
}

// Koneksi ke database
include "../../koneksi.php";

$customer_id = $_GET['id'];

$sql = "DELETE FROM customer WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Kesalahan persiapan pernyataan: " . $conn->error);
}
$stmt->bind_param('i', $customer_id);
if ($stmt->execute()) {
    $_SESSION['flash_message'] = "Produk berhasil dihapus";
} else {
    $_SESSION['flash_message'] = "Terjadi kesalahan: " . $stmt->error;
}
header("Location: list_costumers.php");
exit;
