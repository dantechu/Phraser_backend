<?php include_once('includes/header.php'); ?>

<?php

	if (isset($_GET['id'])) {
		$ID = clean($_GET['id']);
		
		// First, remove all phraser-mood relationships
		$delete_relationships = "DELETE FROM tbl_phraser_moods WHERE mood_id = '$ID'";
		$connect->query($delete_relationships);
		
		// Then delete the mood
		$qry = "DELETE FROM tbl_moods WHERE id = '$ID'";
		$result = $connect->query($qry);

		if ($result) {
			$_SESSION['msg'] = "Mood deleted successfully and removed from all phrasers...";
			header("Location: moods.php");
			exit;
		} else {
			$_SESSION['msg'] = "Something went wrong. Please try again...";
			header("Location: moods.php");
			exit;
		}
	}

?>