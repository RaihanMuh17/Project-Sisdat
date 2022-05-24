<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $supplier_id = isset($_POST['supplier_id']) && !empty($_POST['supplier_id']) && $_POST['supplier_id'] != 'auto' ? $_POST['supplier_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama_supplier = isset($_POST['nama_supplier']) ? $_POST['nama_supplier'] : '';
    $id_produk = isset($_POST['id_produk']) ? $_POST['id_produk'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO supplier VALUES (?, ?, ?)');
    $stmt->execute([$supplier_id, $nama_supplier, $id_produk]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Add Supplier</h2>
    <form action="create3.php" method="post">
        <label for="supplier_id">ID Supplier</label>
        <label for="nama_supplier">Nama</label>
        <input type="text" name="supplier_id" id="supplier_id">
        <input type="text" name="nama_supplier" id="nama_supplier">
        <label for="id_produk">ID Produk yang di supply</label>
        <label></label>
        <input type="text" name="id_produk" id="id_produk">
        <label></label>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>