<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 1) {
    header('Location: ../../index.php');
    exit;
}

// Koneksi ke database
include "../../koneksi.php";

$product_id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE product_id = $product_id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    $sql = "UPDATE products SET product_name = ?, price = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Kesalahan persiapan pernyataan: " . $conn->error);
    }
    $stmt->bind_param('sdi', $product_name, $price, $product_id);
    if ($stmt->execute()) {
        $_SESSION['flash_message'] = "Produk berhasil di edit!";
        header('location: list_product.php');
    } else {
        $_SESSION['flash_message'] = "Terjadi kesalahan: " . $stmt->error;
        header('location: list_product.php');
    }
}

$pageTitle = "Edit Produk";

include '../../layouts/header.php';


?>
<div class="container">
    <div class="card">
        <div class="card-header bg-info">
            <h2>Tambah Produk</h2>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="product_name">Nama Produk</label>
                                <input type="text" id="product_name" class="form-control" value="<?php echo $product['product_name']; ?>" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <input type="number" id="price" name="price" class="form-control" value="<?php echo $product['price']; ?>" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

