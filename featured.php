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
	        $_SESSION['msg'] = "Success added to featured wallpaper";
	        header("Location:featured.php");
			exit;
		}
    }

    //remove from featured
    if (isset($_GET['remove'])) {
		$data = array('featured' => 'no');	
		$hasil = update('tbl_gallery', $data, "WHERE id = '".$_GET['remove']."'");
		if ($hasil > 0) {
	        $_SESSION['msg'] = "Success removed from featured wallpaper";
	        header("Location:featured.php");
			exit;
		}
    }

    // delete selected records
    if(isset($_POST['submit'])) {

        $arr = $_POST['chk_id'];
        $count = count($arr);
        if ($count > 0) {
            foreach ($arr as $nid) {

                $sql_image = "SELECT image FROM tbl_gallery WHERE id = $nid";
                $img_results = mysqli_query($connect, $sql_image);

                $sql_delete = "DELETE FROM tbl_gallery WHERE id = $nid";

                if (mysqli_query($connect, $sql_delete)) {
                    while ($row = mysqli_fetch_assoc($img_results)) {
                        unlink('upload/' . $row['image']);
                        unlink('upload/thumbs/' . $row['image']);
                    }
                    $_SESSION['msg'] = "$count Selected wallpapers deleted";
                } else {
                    $_SESSION['msg'] = "Error deleting record";
                }

            }
        } else {
            $_SESSION['msg'] = "Whoops! no wallpapers selected to delete";
        }
        header("Location:featured.php");
        exit;
    }

	if (isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>"") {
		$keyword = $_REQUEST['keyword'];
		$reload = "featured.php";
		$sql =  "SELECT w.*, c.category_name FROM tbl_gallery w, tbl_category c WHERE w.cat_id = c.cid AND w.featured = 'yes' AND w.image_name LIKE '%$keyword%'";
		$result = $connect->query($sql);
	} else {
		$reload = "featured.php";
		$sql =  "SELECT w.*, c.category_name FROM tbl_gallery w, tbl_category c WHERE w.cat_id = c.cid AND w.featured = 'yes' ORDER BY w.last_update DESC";
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
		<li class="active">Featured Wallpaper</a></li>
	</ol>

	<div class="container-fluid">

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card corner-radius">
					<div class="header">
						<h2>FEATURED WALLPAPER</h2>
						<div class="header-dropdown m-r--5">
							<a href="wallpaper-add.php"><button type="button" class="button button-rounded btn-offset waves-effect waves-float">ADD NEW WALLPAPER</button></a>
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
									<td width="1%"><a href="featured.php"><button type="button" class="button button-rounded waves-effect waves-float">RESET</button></a></td>
									<td width="1%"><button type="submit" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">search</i></button></td>
								</tr>
							</table>
						</form>

						<?php if ($tcount == 0) { ?>
							<p align="center" style="font-size: 110%;">There are no featured wallpapers.</p>
						<?php } else { ?>

						<form method="post" action="">

							<div style="margin-left: 8px; margin-top: -36px; margin-bottom: 10px;">
								<button type="submit" name="submit" id="submit" class="button button-rounded waves-effect waves-float" onclick="return confirm('Are you sure want to delete all selected wallpapers?')">Delete selected items(s)</button>
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
										<th>Image</th>
										<th>Name</th>
										<th>Category</th>
										<th><div align="center">Type</div></th>
										<th><div align="center">Featured</div></th>
										<th><div align="center">Views</div></th>
										<th><div align="center">Downloads</div></th>
										<th><center>Action</center></th>
									</tr>
								</thead>
								<?php
								while(($count < $rpp) && ($i < $tcount)) {
									mysqli_data_seek($result, $i);
									$data = mysqli_fetch_array($result);
									?>
									<tr>
										<td width="1%">
											<div class="demo-checkbox" style="margin-top: 20px;">
												<input type="checkbox" name="chk_id[]" id="<?php echo $data['id'];?>" class="chkbox filled-in chk-col-blue" value="<?php echo $data['id'];?>"/>
												<label for="<?php echo $data['id'];?>"></label>
											</div>
										</td>

										<td>
											<?php if ($data['type'] == 'url') { ?>
											<img src="<?php echo $data['image_url'];?>" height="64px" width="40px"/>
											<?php } else { ?>
											<img src="upload/<?php echo $data['image'];?>" height="64px" width="40px"/>
											<?php } ?>
										</td>

										<td><?php echo $data['image_name'];?></td>
										<td><?php echo $data['category_name'];?></td>

										<td align="center">
											<?php if ($data['type'] == 'url') { ?>
											<span class="label label-rounded bg-orange">&nbsp;URL&nbsp;</span>
											<?php } else { ?>
											<span class="label label-rounded bg-green">UPLOAD</span>
											<?php } ?>
										</td>

										<td align="center">
											<?php if ($data['featured'] == 'no') { ?>
											<a href="featured.php?add=<?php echo $data['id'];?>" onclick="return confirm('Add to featured wallpaper?')" ><i class="material-icons" style="color:grey">lens</i></a>
											<?php } else { ?>
											<a href="featured.php?remove=<?php echo $data['id'];?>" onclick="return confirm('Remove from featured wallpaper?')" ><i class="material-icons" style="color:#4bae4f">lens</i></a>
											<?php } ?>
										</td>

										<td align="center"><?php echo $data['view_count'];?></td>
										<td align="center"><?php echo $data['download_count'];?></td>

										<td><center>

											<a href="wallpaper-send.php?id=<?php echo $data['id'];?>">
												<i class="material-icons">notifications_active</i>
											</a>

											<a href="wallpaper-edit.php?id=<?php echo $data['id'];?>">
												<i class="material-icons">mode_edit</i>
											</a>

											<a href="wallpaper-delete.php?id=<?php echo $data['id'];?>" onclick="return confirm('Are you sure want to delete this wallpaper?')" >
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