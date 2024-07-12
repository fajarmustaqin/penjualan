<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit;
}
$pageTitle = "Tambah Pelanggan";

// Koneksi ke database
include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $contact_number = $_POST['contact_number'];

    $sql = "INSERT INTO Customer (nama, no_hp) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $customer_name, $contact_number);
    if ($stmt->execute()) {
        $_SESSION['flash_message'] = "Produk berhasil ditambahkan!";
        header('location: list_costumers.php');
    } else {
        $_SESSION['flash_message'] = "Terjadi kesalahan: " . $stmt->error;
        header('location: list_costumers.php');
    }
}

include '../../layouts/header.php';
?>

<div class="container">
    <div class="card">
        <div class="card-header bg-secondary">
            <h2>Tambah Pelanggan</h2>
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
                                <label for="product_name">Nama Pelanggan</label>
                                <input type="text" id="product_name" class="form-control" name="customer_name" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Nomor Handphone</label>
                                <input type="text" id="price" name="contact_number" class="form-control" step="0.01" required>
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
