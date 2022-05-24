<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the supplier ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM supplier WHERE supplier_id = ?');
    $stmt->execute([$_GET['id']]);
    $supplier = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$supplier) {
        exit('Supplier doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM supplier WHERE supplier_id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the supplier!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read3.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Supplier #<?=$supplier['supplier_id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete supplier #<?=$supplier['supplier_id']?>?</p>
    <div class="yesno">
        <a href="delete3.php?id=<?=$supplier['supplier_id']?>&confirm=yes">Yes</a>
        <a href="delete3.php?id=<?=$supplier['supplier_id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>