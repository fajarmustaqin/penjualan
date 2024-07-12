<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit;
}
$pageTitle = "Tambah Penjualan";

// Koneksi ke database
include "../../koneksi.php";

// Mendapatkan daftar pelanggan dan produk
$customers = $conn->query("SELECT * FROM customer");
if (!$customers) {
    die("Query pelanggan gagal: " . $conn->error);
}

$products = $conn->query("SELECT * FROM products");
if (!$products) {
    die("Query produk gagal: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $sale_date = $_POST['sale_date'];
    $product_ids = $_POST['product_id'];
    $quantities = $_POST['quantity'];

    $conn->begin_transaction();

    try {
        // Insert data ke tabel Sales
        $sql = "INSERT INTO sales (customer_id, sale_date) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Kesalahan persiapan pernyataan: " . $conn->error);
        }
        $stmt->bind_param('is', $customer_id, $sale_date);
        $stmt->execute();
        $sale_id = $stmt->insert_id;

        // Insert data ke tabel SalesDetails
        foreach ($product_ids as $index => $product_id) {
            $quantity = $quantities[$index];
            $sql = "INSERT INTO sales_detail (sale_id, product_id, qty) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Kesalahan persiapan pernyataan: " . $conn->error);
            }
            $stmt->bind_param('iii', $sale_id, $product_id, $quantity);
            $stmt->execute();
        }

        $conn->commit();
        $_SESSION['flash_message'] = "Penjualan berhasil ditambahkan!";
        header('location: list_sales.php');
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['flash_message'] = "Terjadi kesalahan: " . $e->getMessage();
        header('location: list_sales.php');
    }

}
include '../../layouts/header.php';
?>

<div class="container">
    <div class="card">
        <div class="card-header bg-info">
            <h2>Tambah Penjualan</h2>
        </div>
        <div class="card-body">
            <div class="container">
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="customer_id">Pilih Pelanggan</label>
                                <select id="customer_id" class="form-control" name="customer_id" required>
                                    <option value="" selected>==Pilih Pelanggan</option>
                                    <?php while ($customer = $customers->fetch_assoc()) { ?>
                                        <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">Tanggal Penjualan</label>
                                <input type="date" class="form-control" id="sale_date" name="sale_date" required>
                            </div>
                        </div>
                    </div>
                    <div id="product-container">
                        <div class="product-row">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Produk</label>
                                        <select name="product_id[]" class="form-control" required>
                                            <option value="" selected>==Pilih Produk==</option>
                                            <?php
                                            $products = $conn->query("SELECT * FROM products"); // Query ulang produk
                                            if (!$products) {
                                                die("Query produk gagal: " . $conn->error);
                                            }
                                            while ($product = $products->fetch_assoc()) { ?>
                                                <option value="<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">QTY</label>
                                        <input type="number" name="quantity[]" min="1" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <button type="button" class="btn btn-success" onclick="addProductRow()">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function addProductRow() {
        var container = document.getElementById('product-container');
        var row = container.querySelector('.product-row').cloneNode(true);
        container.appendChild(row);
    }
</script>

<?php include '../../layouts/footer.php'; ?>
