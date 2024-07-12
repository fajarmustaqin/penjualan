<?php

// Simpan nama pengguna dari session ke dalam variabel
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard Admin'; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        nav {
            background-color: #444;
            padding: 5px 0;
            text-align: center;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
        }
        .card-body {
            padding: 20px;
        }
        .total-info {
            font-size: 24px;
            font-weight: bold;
        }
        .navbar-text {
            color: #fff;
            margin-left: auto; /* Untuk memindahkan ke pojok kanan */
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="../dashboard/admin.php">Beranda <span class="sr-only">(current)</span></a>
                    </li>
                    <?php if($_SESSION['level'] == '1'){?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProduct" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Produk
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownProduct">
                            <a class="dropdown-item" href="../product/add_product.php">Tambah Produk</a>
                            <a class="dropdown-item" href="../product/list_product.php">Daftar Produk</a>
                        </div>
                    </li>
                    <?php } ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCustomer" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pelanggan
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownCustomer">
                            <a class="dropdown-item" href="../customer/add_customer.php">Tambah Pelanggan</a>
                            <a class="dropdown-item" href="../customer/list_costumers.php">Daftar Pelanggan</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSale" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Penjualan
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownSale">
                            <a class="dropdown-item" href="../penjualan/add_sale.php">Tambah Penjualan</a>
                            <a class="dropdown-item" href="../penjualan/list_sales.php">Daftar Penjualan</a>
                            <a class="dropdown-item" href="../report/sales_report.php">Laporan Penjualan</a>
                        </div>
                    </li>
                </ul>
                <span class="navbar-text">
                    <?php echo "Selamat datang, $username"; ?>
                </span>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div><br><br>

