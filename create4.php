<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id_toko = isset($_POST['id_toko']) && !empty($_POST['id_toko']) && $_POST['id_toko'] != 'auto' ? $_POST['id_toko'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama_toko = isset($_POST['nama_toko']) ? $_POST['nama_toko'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO toko VALUES (?, ?)');
    $stmt->execute([$id_toko, $nama_toko]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Add Toko</h2>
    <form action="create4.php" method="post">
        <label for="id_toko">ID Toko</label>
        <label for="nama_toko">Nama Toko</label>
        <input type="text" name="id_toko" id="id_toko">
        <input type="text" name="nama_toko" id="nama_toko">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>