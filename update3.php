<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the supplier id exists, for example update.php?id=1 will get the supplier with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : NULL;
        $nama_supplier = isset($_POST['nama_supplier']) ? $_POST['nama_supplier'] : '';
        $id_produk = isset($_POST['id_produk']) ? $_POST['id_produk'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE supplier SET supplier_id = ?, nama_supplier = ?, id_produk = ? WHERE supplier_id = ?');
        $stmt->execute([$supplier_id, $nama_supplier, $id_produk, $_GET['supplier_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the supplier from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM supplier WHERE supplier_id = ?');
    $stmt->execute([$_GET['id']]);
    $supplier = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$supplier) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update supplier #<?=$supplier['supplier_id']?></h2>
    <form action="update3.php?supplier_id=<?=$supplier['supplier_id']?>" method="post">
        <label for="supplier_id">ID Supplier</label>
        <label for="nama_supplier">Nama Supplier</label>
        <input type="text" name="supplier_id" value="<?=$supplier['supplier_id']?>" id="id">
        <input type="text" name="nama_produk" value="<?=$supplier['nama_supplier']?>" id="nama_supplier">
        <label for="id_produk">ID Produk</label>
        <label></label>
        <input type="text" name="id_produk" value="<?=$supplier['id_produk']?>" id="id_produk">
        <label></label>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>