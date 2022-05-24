<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the toko ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM toko WHERE id_toko = ?');
    $stmt->execute([$_GET['id']]);
    $toko = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$toko) {
        exit('toko doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM toko WHERE id_toko = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the toko!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read4.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete toko #<?=$toko['id_toko']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete toko #<?=$toko['id_toko']?>?</p>
    <div class="yesno">
        <a href="delete4.php?id=<?=$toko['id_toko']?>&confirm=yes">Yes</a>
        <a href="delete4.php?id=<?=$toko['id_toko']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>