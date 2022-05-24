<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the store id exists, for example update.php?id=1 will get the store with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id_toko']) ? $_POST['id_toko'] : NULL;
        $nama_toko = isset($_POST['nama_toko']) ? $_POST['nama_toko'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE toko SET id_toko = ?, nama_toko = ? WHERE id_toko = ?');
        $stmt->execute([$id, $nama_toko, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the store from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM toko WHERE id_toko = ?');
    $stmt->execute([$_GET['id']]);
    $store = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$store) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update store #<?=$store['id_toko']?></h2>
    <form action="update4.php?id_toko=<?=$store['id_toko']?>" method="post">
        <label for="id_toko">ID Toko</label>
        <label for="nama_toko">Nama Toko</label>
        <input type="text" name="id_toko" value="<?=$store['id_toko']?>" id="id_toko">
        <input type="text" name="nama_toko" value="<?=$store['nama_toko']?>" id="nama_toko">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>