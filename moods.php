<?php include_once('includes/header.php'); ?>

<?php

	error_reporting(0);

	if (isset($_REQUEST['keyword']) && $_REQUEST['keyword'] != "") {
		$keyword = $_REQUEST['keyword'];
		$reload = "moods.php";
		$sql = "SELECT * FROM tbl_moods WHERE mood_name LIKE '%$keyword%'";
		$result = $connect->query($sql);
	} else {
		$reload = "moods.php";
		$sql = "SELECT * FROM tbl_moods ORDER BY id DESC";
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
		<li class="active">Manage Moods</a></li>
	</ol>

	<div class="container-fluid">

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card corner-radius">
					<div class="header">
						<h2>MANAGE MOODS</h2>
						<div class="header-dropdown m-r--5">
							<a href="moods-add.php"><button type="button" class="button button-rounded btn-offset waves-effect waves-float">ADD NEW MOOD</button></a>
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
									<td width="1%"><a href="moods.php"><button type="button" class="button button-rounded waves-effect waves-float">RESET</button></a></td>
									<td width="1%"><button type="submit" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">search</i></button></td>
								</tr>
							</table>
						</form>

						<?php if ($tcount == 0) { ?>
							<p align="center" style="font-size: 110%;">There are no moods.</p>
						<?php } else { ?>							

						<table class='table table-hover table-striped table-offset'>
							<thead>
								<tr>
									<th>Mood Name</th>
									<th>Icon</th>
									<th>Usage Count</th>
									<th width="15%">Action</th>
								</tr>
							</thead>
							<?php
							while(($count < $rpp) && ($i < $tcount)) {
								mysqli_data_seek($result, $i);
								$data = mysqli_fetch_array($result);
								
								// Count how many phrasers use this mood
								$usage_sql = "SELECT COUNT(*) as usage_count FROM tbl_phraser_moods WHERE mood_id = ".$data['id'];
								$usage_result = $connect->query($usage_sql);
								$usage_row = mysqli_fetch_array($usage_result);
								$usage_count = $usage_row['usage_count'];
								?>
								<tr>
									<td><?php echo $data['mood_name'];?></td>
									<td>
										<span style="font-size: 24px;">
											<?php echo $data['mood_icon']; ?>
										</span>
									</td>
									<td><?php echo $usage_count; ?> phrasers</td>
									<td>
										<a href="moods-edit.php?id=<?php echo $data['id'];?>">
											<i class="material-icons">mode_edit</i>
										</a>

										<a href="moods-delete.php?id=<?php echo $data['id'];?>" onclick="return confirm('Are you sure want to delete this mood? This will remove it from all phrasers.')" >
											<i class="material-icons">delete</i>
										</a>
									</td>
								</tr>
								<?php
								$i++; 
								$count++;
							}
							?>
						</table>

						<?php } ?>

						<?php if ($tcount > $postPerPage) { echo pagination($reload, $page, $keyword, $tpages); } ?>

					</div>

				</div>
			</div>
		</div>
	</div>
</section>

<?php include_once('includes/footer.php'); ?>