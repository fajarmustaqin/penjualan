<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit;
}

// Koneksi ke database
include "../../koneksi.php";

// Mendapatkan daftar pelanggan
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);

if (!$result) {
    die("Query pelanggan gagal: " . $conn->error);
}

$flashMessage = isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : '';
unset($_SESSION['flash_message']);

$pageTitle = "Daftar Pelanggan";


include '../../layouts/header.php';
?>


<div class="container">
    <div class="card">
        <div class="card-header bg-secondary">
            <h2>Daftar Pelanggan</h2>
        </div>
        <div class="card-body">
            <div class="container table-responsive">
            <?php if (!empty($flashMessage)): ?>
                <div class="alert alert-<?php echo strpos($flashMessage, 'berhasil') !== false ? 'success' : 'danger'; ?>" role="alert">
                    <?php echo $flashMessage; ?>
                </div>
            <?php endif; ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID Pelanggan</th>
                        <th class="text-center">Nama Pelanggan</th>
                        <th class="text-center">Nomor Handphone</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($customer = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $customer['customer_id']; ?></td>
                            <td><?php echo $customer['nama']; ?></td>
                            <td><?php echo $customer['no_hp']; ?></td>
                            <td>
                                <?php if($_SESSION['level'] == 1){ ?>
                                <a class="btn btn-sm btn-warning" href="update_customer.php?id=<?php echo $customer['customer_id']; ?>">Edit</a> | 
                                <a class="btn btn-sm btn-danger" href="delete_customer.php?id=<?php echo $customer['customer_id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">Delete</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>
