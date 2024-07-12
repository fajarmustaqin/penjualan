<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 1) {
    header('Location: ../../index.php');
    exit;
}

// Koneksi ke database
include "../../koneksi.php";

$customer_id = $_GET['id'];
$customer = $conn->query("SELECT * FROM customer WHERE customer_id = $customer_id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];

    $sql = "UPDATE customer SET nama = ?, no_hp = ? WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Kesalahan persiapan pernyataan: " . $conn->error);
    }
    $stmt->bind_param('ssi', $nama, $no_hp, $customer_id);
    if ($stmt->execute()) {
        $_SESSION['flash_message'] = "Produk berhasil ditambahkan!";
        header('location: list_costumers.php');
    } else {
        $_SESSION['flash_message'] = "Terjadi kesalahan: " . $stmt->error;
        header('location: list_costumers.php');
    }
}
include '../../layouts/header.php';
$pageTitle = "Edit Pelanggan";

?>

<div class="container">
    <div class="card">
        <div class="card-header bg-secondary">
            <h2>Edit Pelanggan</h2>
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
                                <input type="text" id="product_name" class="form-control" value="<?php echo $customer['nama']; ?>" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Nomor Handphone</label>
                                <input type="text" id="price" name="no_hp" class="form-control" value="<?php echo $customer['no_hp']; ?>" step="0.01" required>
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
