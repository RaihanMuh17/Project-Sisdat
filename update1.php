<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the product id_produk exists, for example update.php?id_produk=1 will get the product with the id_produk of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id_produk = isset($_POST['id_produk']) ? $_POST['id_produk'] : NULL;
        $nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
        $jenis_produk = isset($_POST['jenis_produk']) ? $_POST['jenis_produk'] : '';
        $harga_produk = isset($_POST['harga_produk']) ? $_POST['harga_produk'] : '';
        $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : '';
        $id_toko = isset($_POST['id_toko']) ? $_POST['id_toko'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE produk SET id_produk = ?, nama_produk = ?, jenis_produk = ?, harga_produk = ?, supplier_id = ?, id_toko = ? WHERE id_produk = ?');
        $stmt->execute([$id_produk, $nama_produk, $jenis_produk, $harga_produk, $supplier_id, $id_toko, $_GET['id_produk']]);
        $msg = 'Updated Successfully!';
    }
    // Get the product from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM produk WHERE id_produk = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Product doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Product #<?=$product['id_produk']?></h2>
    <form action="update1.php?id_produk=<?=$product['id_produk']?>" method="post">
        <label for="id_produk">ID Produk</label>
        <label for="nama_produk">Nama Produk</label>
        <input type="text" name="id_produk" value="<?=$product['id_produk']?>" id="id_produk">
        <input type="text" name="nama_produk" value="<?=$product['nama_produk']?>" id="nama_produk">
        <label for="jenis_produk">Jenis Produk</label>
        <label for="harga_produk">Harga</label>
        <input type="text" name="jenis_produk" value="<?=$product['jenis_produk']?>" id="jenis_produk">
        <input type="text" name="harga_produk" value="<?=$product['harga_produk']?>" id="harga_produk">
        <label for="supplier_id">ID Supplier</label>
        <label for="id_toko">ID Toko</label>
        <input type="text" name="supplier_id" value="<?=$product['supplier_id']?>" id="supplier_id">
        <input type="text" name="id_toko" value="<?=$product['id_toko']?>" id="id_toko">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>