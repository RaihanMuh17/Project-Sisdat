<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the client ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM pembeli WHERE id_pembeli = ?');
    $stmt->execute([$_GET['id']]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$client) {
        exit('Client doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM pembeli WHERE id_pembeli = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the client!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read2.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Client #<?=$client['id_pembeli']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete client #<?=$client['id_pembeli']?>?</p>
    <div class="yesno">
        <a href="delete2.php?id=<?=$client['id_pembeli']?>&confirm=yes">Yes</a>
        <a href="delete2.php?id=<?=$client['id_pembeli']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>