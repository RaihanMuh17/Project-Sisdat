<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the client id exists, for example update.php?id=1 will get the client with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id_pembeli = isset($_POST['id_pembeli']) ? $_POST['id_pembeli'] : NULL;
        $nama_pembeli = isset($_POST['nama_pembeli']) ? $_POST['nama_pembeli'] : '';
        $id_produk = isset($_POST['id_produk']) ? $_POST['id_produk'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE pembeli SET id_pembeli = ?, nama_pembeli = ?, id_produk = ? WHERE id_pembeli = ?');
        $stmt->execute([$id_pembeli, $nama_pembeli, $id_produk, $_GET['id_pembeli']]);
        $msg = 'Updated Successfully!';
    }
    // Get the client from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM pembeli WHERE id_pembeli = ?');
    $stmt->execute([$_GET['id']]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$client) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update client #<?=$client['id_pembeli']?></h2>
    <form action="update2.php?id_pembeli=<?=$client['id_pembeli']?>" method="post">
        <label for="id_pembeli">ID Pembeli</label>
        <label for="nama_pembeli">Nama Pembeli</label>
        <input type="text" name="id_pembeli" value="<?=$client['id_pembeli']?>" id="id">
        <input type="text" name="nama" value="<?=$client['nama_pembeli']?>" id="nama_pembeli">
        <label for="id_produk">ID Produk</label>
        <label></label>
        <input type="text" name="id_produk" value="<?=$client['id_produk']?>" id="id_produk">
        <label></label>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>