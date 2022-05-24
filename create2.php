<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id_pembeli = isset($_POST['id_pembeli']) && !empty($_POST['id_pembeli']) && $_POST['id_pembeli'] != 'auto' ? $_POST['id_pembeli'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama_pembeli = isset($_POST['nama_pembeli']) ? $_POST['nama_pembeli'] : '';
    $id_produk = isset($_POST['id_produk']) ? $_POST['id_produk'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO pembeli VALUES (?, ?, ?)');
    $stmt->execute([$id_pembeli, $nama_pembeli, $id_produk]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Add Clients</h2>
    <form action="create2.php" method="post">
        <label for="id_pembeli">ID Pembeli</label>
        <label for="nama_pembeli">Nama</label>
        <input type="text" name="id_pembeli" id="id_pembeli">
        <input type="text" name="nama_pembeli" id="nama_pembeli">
        <label for="id_produk">ID Produk yang Dibeli</label>
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