<?php include_once('includes/header.php'); ?>
<?php include_once('thumbnail.php'); ?>

<?php

	if (isset($_GET['id'])) {
        $ID = clean($_GET['id']);
 		$qry 	= "SELECT * FROM tbl_gallery WHERE id = '$ID'";
		$result = $connect->query($qry);
		$row 	= $result->fetch_assoc();
 	}

	if(isset($_POST['submit'])) {

		$categoryId = clean($_POST['cat_id']);

        if ($_POST['tags'] == '') {
            $sql = "SELECT * FROM tbl_category WHERE cid = '$categoryId'";
            $result = $connect->query($sql);
            $row = $result->fetch_assoc();
            $tags = $row['category_name'];
        } else {
            $tags = $_POST['tags'];
        }


        $data = array(											 
			'cat_id'  	=> $categoryId,
			'tags' 		=> $tags,
			'quote' => clean($_POST['quote']),
		);	

		$hasil = update('tbl_gallery', $data, "WHERE id = '$ID'");

		if ($hasil > 0) {
            $_SESSION['msg'] = "Changes Saved...";
            header("Location:phraser-edit.php?id=$ID");
            exit;
		}


	}

 	$sql_categories = "SELECT * FROM tbl_category";
	$result_categories = $connect->query($sql_categories);

?>


   <section class="content">
   
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="phraser.php">Manage Phraser</a></li>
            <li class="active">Edit Phraser</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                	<form id="form_validation" method="post" enctype="multipart/form-data">
                    <div class="card corner-radius">
                        <div class="header">
                            <h2>EDIT PHRASER</h2> 
                        </div>
                        <div class="body">

                            <?php if(isset($_SESSION['msg'])) { ?>
                                <div class='alert alert-info alert-dismissible corner-radius' role='alert'>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>&nbsp;&nbsp;</button>
                                    <?php echo $_SESSION['msg']; ?>
                                </div>
                            <?php unset($_SESSION['msg']); } ?>                            

                        	<div class="row clearfix">
                            	<div class="col-md-12">

                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Category</div>
                                        <select class="form-control show-tick" name="cat_id" id="cat_id">
                                           <?php 	
												while ($r_c_row = mysqli_fetch_array($result_categories)) {
													$sel = '';
													if ($r_c_row['cid'] == $row['cat_id']) {
													$sel = "selected";	
												}	
											?>
										    <option value="<?php echo $r_c_row['cid'];?>" <?php echo $sel; ?>><?php echo $r_c_row['category_name'];?></option>
										        <?php } ?>
                                        </select>
                                    </div>

                                    
                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Quote</div>
                                        <div class="form-line">
                                            <input value='<?php echo $row['quote']; ?>' type="text" class="form-control" name="quote" id="quote" placeholder="Type Quote" required/>
                                        </div>
                                    </div>
                              


                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Tags (Optional)</div>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="tags" id="tags" data-role="tagsinput" value="<?php echo $row['tags']; ?>" required/>
                                        </div>
                                    </div>
									<input type="hidden" name="id" value="<?php echo $row['id'];?>">

	                                <div class="col-sm-12">
	                                    <button type="submit" name="submit" class="button button-rounded waves-effect waves-float pull-right">UPDATE</button>
	                                </div>
                            	</div>
                            </div>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
            
        </div>

    </section>

<?php include_once('includes/footer.php'); ?>