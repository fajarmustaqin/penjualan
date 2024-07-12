<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 1) {
    header('Location: ../../index.php');
    exit;
}

include "../../koneksi.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (product_name, price) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Kesalahan persiapan pernyataan: " . $conn->error);
    }

    $stmt->bind_param('sd', $product_name, $price);
    if ($stmt->execute()) {
        $_SESSION['flash_message'] = "Produk berhasil ditambahkan!";
        header('location: list_product.php');
    } else {
        $_SESSION['flash_message'] = "Terjadi kesalahan: " . $stmt->error;
        header('location: list_product.php');
    }
    $stmt->close();
}

$pageTitle = "Tambah Produk";



// Hapus flash message setelah ditampilkan
$flashMessage = isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : '';
unset($_SESSION['flash_message']);

// Koneksi ke database
include '../../layouts/header.php';
?>

<div class="container">
    <div class="card">
        <div class="card-header bg-info">
            <h2>Tambah Produk</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($flashMessage)): ?>
                <div class="alert alert-<?php echo strpos($flashMessage, 'berhasil') !== false ? 'success' : 'danger'; ?>" role="alert">
                    <?php echo $flashMessage; ?>
                </div>
            <?php endif; ?>
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="product_name">Nama Produk</label>
                                <input type="text" id="product_name" class="form-control" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <input type="number" id="price" name="price" class="form-control" step="0.01" required>
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

<?php include '../../layouts/footer.php'; ?>
