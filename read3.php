<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;


// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM supplier ORDER BY supplier_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_suppliers = $pdo->query('SELECT COUNT(*) FROM supplier')->fetchColumn();
?>


<?=template_header('Read')?>

<div class="content read">
	<h2>Read Supplier</h2>
	<a href="create3.php" class="create-contact">Add Supplier</a>
	<table>
        <thead>
            <tr>
                <td>Supplier ID</td>
                <td>Nama Supplier</td>
                <td>ID Produk</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($suppliers as $supplier): ?>
            <tr>
                <td><?=$supplier['supplier_id']?></td>
                <td><?=$supplier['nama_supplier']?></td>
                <td><?=$supplier['id_produk']?></td>
                <td class="actions">
                    <a href="update3.php?id=<?=$supplier['supplier_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete3.php?id=<?=$supplier['supplier_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read2.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_suppliers): ?>
		<a href="read2.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>