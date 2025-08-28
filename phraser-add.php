<?php include_once('includes/header.php'); ?>
<?php include_once('thumbnail.php'); ?>

<?php
 
	$cat_qry = "SELECT * FROM tbl_category ORDER BY category_name";
	$cat_result = $connect->query($cat_qry);    
	
	if(isset($_POST['submit'])) {


        if ($_POST['tags'] == '') {
            $sql = "SELECT * FROM tbl_category WHERE cid = '".$_POST['cat_id']."'";
            $result = mysqli_query($connect, $sql);
            $row = mysqli_fetch_assoc($result);
            $tags = $row['category_name'];
        } else {
            $tags = $_POST['tags'];
        }

        $data = array( 
            'cat_id'    => $_POST['cat_id'],
            'quote'    => $_POST['quote'],
            'tags'      => $tags,
        );	

        $qry = insert('tbl_gallery', $data);

        $_SESSION['msg'] = "Phraser added Successfully...";
        header("Location:phraser-add.php");
        exit;
		 
	}
	  
?>


   <section class="content">
   
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="phraser.php">Manage Phraser</a></li>
            <li class="active">Add Phraser</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                	<form id="form_validation" method="post" enctype="multipart/form-data">
                    <div class="card corner-radius">
                        <div class="header">
                            <h2>ADD PHRASER</h2> 
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
		          								while ($cat_row = mysqli_fetch_array($cat_result)) {
		          							?>          						 
		          								<option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>					 
		          							<?php
		          								}
		          							?>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Quote</div>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="quote" id="quote" placeholder="Type Quote" required/>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Tags (Optional)</div>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="tags" id="tags" data-role="tagsinput" placeholder="add tags" required/>
                                        </div>
                                    </div>                                                            

                                    <div class="col-sm-12">
                                    <button type="submit" name="submit" class="button button-rounded waves-effect waves-float pull-right">SUBMIT</button>
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