<?php ob_start(); ?>
<?php include_once('includes/header.php'); ?>

<?php
	
	if (isset($_GET['id'])) {
		$ID = clean($_GET['id']);
	} else {
		$ID = clean("");
	}

	// delete mood relationships first
	$delete_moods = "DELETE FROM tbl_phraser_moods WHERE phraser_id = '$ID'";
	$connect->query($delete_moods);
	
	// delete data from gallery table
	$sql_delete = "DELETE FROM tbl_gallery WHERE id = '$ID'";
	$delete = $connect->query($sql_delete);

	// if delete data success
	if ($delete) {

		$_SESSION['msg'] = "Phraser deleted successfully...";
	    header( "Location: phraser.php");
	     exit;
	}

?>

<?php include_once('includes/footer.php'); ?>