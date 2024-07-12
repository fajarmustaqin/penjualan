<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 1) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sistem Manajemen Penjualan</title>
</head>
<body>
    <h1>Selamat Datang di Sistem Manajemen Penjualan</h1>
    <a href="logout.php">Logout</a>
</body>
</html>
