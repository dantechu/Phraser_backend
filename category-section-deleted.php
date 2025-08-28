<?php ob_start(); ?>
<?php include_once('includes/header.php'); ?>

<?php
	
	if (isset($_GET['id'])) {
		$ID = clean($_GET['id']);
	} else {
		$ID = clean("");
	}

	// delete data from menu table
	$sql_delete = "DELETE FROM tbl_category_section WHERE id = '$ID'";
	$delete = $connect->query($sql_delete);

	// if delete data success
	if ($delete) {

		$_SESSION['msg'] = "Category Section deleted successfully...";
	    header( "Location: category-section.php");
	     exit;
	}

?>

<?php include_once('includes/footer.php'); ?>