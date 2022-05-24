<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id_produk = isset($_POST['id_produk']) && !empty($_POST['id_produk']) && $_POST['id_produk'] != '' ? $_POST['id_produk'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
    $jenis_produk = isset($_POST['jenis_produk']) ? $_POST['jenis_produk'] : '';
    $harga_produk = isset($_POST['harga_produk']) ? $_POST['harga_produk'] : '';
    $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : '';
    $id_toko = isset($_POST['id_toko']) ? $_POST['id_toko'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO produk VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id_produk, $nama_produk, $jenis_produk, $harga_produk, $supplier_id, $id_toko]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Add Product</h2>
    <form action="create1.php" method="post">
        <label for="id_produk">ID Produk</label>
        <label for="nama_produk">Nama Produk</label>
        <input type="text" name="id_produk" id="id_produk">
        <input type="text" name="nama_produk" id="nama_produk">
        <label for="jenis_produk">Jenis Produk</label>
        <label for="harga_produk">Harga </label>
        <input type="text" name="jenis_produk" id="jenis_produk">
        <input type="text" name="harga_produk" id="harga_produk">
        <label for="supplier_id">ID supplier</label>
        <label for="id_toko">ID Toko</label>
        <input type="text" name="supplier_id" id="supplier_id">
        <input type="text" name="id_toko" id="id_toko">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>