<?php include_once('includes/header.php'); ?>

<?php

	if (isset($_GET['id'])) {
		$ID = clean($_GET['id']);
		
		// First, remove all phraser-region relationships
		$delete_relationships = "DELETE FROM tbl_phraser_regions WHERE region_id = '$ID'";
		$connect->query($delete_relationships);
		
		// Then delete the region
		$qry = "DELETE FROM tbl_regions WHERE id = '$ID'";
		$result = $connect->query($qry);

		if ($result) {
			$_SESSION['msg'] = "Region deleted successfully and removed from all phrasers...";
			header("Location: regions.php");
			exit;
		} else {
			$_SESSION['msg'] = "Something went wrong. Please try again...";
			header("Location: regions.php");
			exit;
		}
	}

?>