<?php include_once('includes/header.php'); ?>

<?php

	error_reporting(0);

	$now = new DateTime();
	$lastUpdate = $now->format('Y-m-d H:i:s');

	//add to featured
    if (isset($_GET['add'])) {
		$data = array(
			'featured' => 'yes',
			'last_update' => $lastUpdate
		);	
		$hasil = update('tbl_gallery', $data, "WHERE id = '".$_GET['add']."'");
		if ($hasil > 0) {
	        $_SESSION['msg'] = "Success added to featured phraser";
	        header("Location:phraser.php");
			exit;
		}
    }

    //remove from featured
    if (isset($_GET['remove'])) {
		$data = array('featured' => 'no');	
		$hasil = update('tbl_gallery', $data, "WHERE id = '".$_GET['remove']."'");
		if ($hasil > 0) {
	        $_SESSION['msg'] = "Success removed from featured phraser";
	        header("Location:phraser.php");
			exit;
		}
    }

    // delete selected records
    if(isset($_POST['submit'])) {

        $arr = $_POST['chk_id'];
        $count = count($arr);
        if ($count > 0) {
            foreach ($arr as $nid) {
                // Delete mood relationships first
                $delete_moods = "DELETE FROM tbl_phraser_moods WHERE phraser_id = $nid";
                mysqli_query($connect, $delete_moods);
                
                // Then delete the phraser
                $sql_delete = "DELETE FROM tbl_gallery WHERE id = $nid";
                if (mysqli_query($connect, $sql_delete)) {
                    $_SESSION['msg'] = "$count Selected phrasers deleted";
                } else {
                    $_SESSION['msg'] = "Error deleting record";
                }

            }
        } else {
            $_SESSION['msg'] = "Whoops! no phrasers selected to delete";
        }
        header("Location:phraser.php");
        exit;
    }

	if (isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>"") {
		$keyword = $_REQUEST['keyword'];
		$reload = "phraser.php";
		$sql =  "SELECT w.*, c.category_name FROM tbl_gallery w, tbl_category c WHERE w.cat_id = c.cid AND w.image_name LIKE '%$keyword%'";
		$result = $connect->query($sql);
	} else {
		$reload = "phraser.php";
		$sql =  "SELECT w.*, c.category_name FROM tbl_gallery w, tbl_category c WHERE w.cat_id = c.cid ORDER BY w.id DESC";
		$result = $connect->query($sql);
	}

	$rpp = $postPerPage;
	$page = intval($_GET["page"]);
	if($page <= 0) $page = 1;  
	$tcount = mysqli_num_rows($result);
	$tpages = ($tcount) ? ceil($tcount / $rpp) : 1;
	$count = 0;
	$i = ($page-1) * $rpp;
	$no_urut = ($page-1) * $rpp;
	

?>

<section class="content">

	<ol class="breadcrumb">
		<li><a href="dashboard.php">Dashboard</a></li>
		<li class="active">Manage Phraser</a></li>
	</ol>

	<div class="container-fluid">

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card corner-radius">
					<div class="header">
						<h2>MANAGE PHRASER</h2>
						<div class="header-dropdown m-r--5">
							<a href="phraser-add.php"><button type="button" class="button button-rounded btn-offset waves-effect waves-float">ADD NEW PHRASER</button></a>
						</div>
					</div>

					<div style="margin-top: -10px;" class="body table-responsive">

						<?php if(isset($_SESSION['msg'])) { ?>
						<div class='alert alert-info alert-dismissible corner-radius bottom-offset' role='alert'>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>&nbsp;&nbsp;</button>
							<?php echo $_SESSION['msg']; ?>
						</div>
						<?php unset($_SESSION['msg']); } ?>

						<form method="get" id="form_validation">
							<table class='table'>
								<tr>
									<td>
										<div class="form-group form-float">
											<div class="form-line">
												<input type="text" class="form-control" name="keyword" placeholder="Search..." required>
											</div>
										</div>
									</td>
									<td width="1%"><a href="phraser.php"><button type="button" class="button button-rounded waves-effect waves-float">RESET</button></a></td>
									<td width="1%"><button type="submit" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">search</i></button></td>
								</tr>
							</table>
						</form>

						<?php if ($tcount == 0) { ?>
							<p align="center" style="font-size: 110%;">There are no Phrasers.</p>
						<?php } else { ?>

						<form method="post" action="">

							<div style="margin-left: 8px; margin-top: -36px; margin-bottom: 10px;">
								<button type="submit" name="submit" id="submit" class="button button-rounded waves-effect waves-float" onclick="return confirm('Are you sure want to delete all selected Phrasers?')">Delete selected items(s)</button>
							</div>				

							<table class='table table-hover table-striped'>
								<thead>
									<tr>
										<th width="1%">
											<div class="demo-checkbox" style="margin-bottom: -15px">
												<input id="chk_all" name="chk_all" type="checkbox" class="filled-in chk-col-blue" />
												<label for="chk_all"></label>
											</div>
										</th>
										<th>Category</th>
										<th><div align="center">Quote</div></th>
										<th>Moods</th>
										<th><center>Action</center></th>
									</tr>
								</thead>
								<?php
								while(($count < $rpp) && ($i < $tcount)) {
									mysqli_data_seek($result, $i);
									$data = mysqli_fetch_array($result);
									
									// Get moods for this phraser
									$moods_sql = "SELECT m.mood_name, m.mood_color 
										FROM tbl_phraser_moods pm 
										JOIN tbl_moods m ON pm.mood_id = m.id 
										WHERE pm.phraser_id = ".$data['id']."
										ORDER BY m.mood_name";
									$moods_result = $connect->query($moods_sql);
									?>
									<tr>
										<td width="1%">
											<div class="demo-checkbox" style="margin-top: 20px;">
												<input type="checkbox" name="chk_id[]" id="<?php echo $data['id'];?>" class="chkbox filled-in chk-col-blue" value="<?php echo $data['id'];?>"/>
												<label for="<?php echo $data['id'];?>"></label>
											</div>
										</td>

										<td><?php echo $data['category_name'];?></td>
										<td><?php echo $data['quote'];?></td>
										<td>
											<?php 
											if ($moods_result && mysqli_num_rows($moods_result) > 0) {
												while ($mood = mysqli_fetch_array($moods_result)) {
													echo '<span style="background-color: '.$mood['mood_color'].'; color: white; padding: 2px 6px; border-radius: 3px; margin-right: 4px; margin-bottom: 2px; display: inline-block; font-size: 11px;">'.$mood['mood_name'].'</span>';
												}
											} else {
												echo '<span style="color: #999; font-style: italic;">No moods</span>';
											}
											?>
										</td>
										<td><center>

											<a href="phraser-send.php?id=<?php echo $data['id'];?>">
												<i class="material-icons">notifications_active</i>
											</a>

											<a href="phraser-edit.php?id=<?php echo $data['id'];?>">
												<i class="material-icons">mode_edit</i>
											</a>

											<a href="phraser-delete.php?id=<?php echo $data['id'];?>" onclick="return confirm('Are you sure want to delete this phraser?')" >
												<i class="material-icons">delete</i>
											</a></center>
										</td>
									</tr>
									<?php
									$i++; 
									$count++;
								}
								?>
							</table>

						</form>

						<?php } ?>

						<?php if ($tcount > $postPerPage) { echo pagination($reload, $page, $keyword, $tpages); } ?>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>

<?php include_once('includes/footer.php'); ?>