<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 1) {
    header('Location: index.php');
    exit;
}

$total_products = 150;
$total_sales = 500;
$total_customers = 300;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            padding: 10px 0;
            text-align: center;
            color: #fff;
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
    </style>
</head>
<body>
    <header>
        <h1>Dashboard Admin</h1>
    </header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Beranda <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProduct" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Produk
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownProduct">
                            <a class="dropdown-item" href="add_product.php">Tambah Produk</a>
                            <a class="dropdown-item" href="list_product.php">Daftar Produk</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCustomer" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pelanggan
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownCustomer">
                            <a class="dropdown-item" href="add_customer.php">Tambah Pelanggan</a>
                            <a class="dropdown-item" href="list_customers.php">Daftar Pelanggan</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSale" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Penjualan
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownSale">
                            <a class="dropdown-item" href="add_sale.php">Tambah Penjualan</a>
                            <a class="dropdown-item" href="list_sales.php">Daftar Penjualan</a>
                            <a class="dropdown-item" href="sales_report.php">Laporan Penjualan</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div><br><br>

    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        Total Produk
                    </div>
                    <div class="card-body">
                        <p class="total-info"><?php echo $total_products; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        Total Penjualan
                    </div>
                    <div class="card-body">
                        <p class="total-info"><?php echo $total_sales; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        Total Pelanggan
                    </div>
                    <div class="card-body">
                        <p class="total-info"><?php echo $total_customers; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
