<?php include_once('includes/header.php'); ?>
<?php include_once('thumbnail.php'); ?>

<?php

	if (isset($_GET['id'])) {
        $ID = clean($_GET['id']);
 		$qry 	= "SELECT * FROM tbl_category_section WHERE id = '$ID'";
		$result = $connect->query($qry);
		$row 	= $result->fetch_assoc();
 	}

	if(isset($_POST['submit'])) {

        $data = array(			
			'name' => clean($_POST['name']),
		);	

		$hasil = update('tbl_category_section', $data, "WHERE id = '$ID'");

		if ($hasil > 0) {
            $_SESSION['msg'] = "Changes Saved...";
            header("Location:category-section-edit.php?id=$ID");
            exit;
		}


	}

?>


   <section class="content">
   
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="category-section.php">Manage Category Section</a></li>
            <li class="active">Edit Category Section</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                	<form id="form_validation" method="post" enctype="multipart/form-data">
                    <div class="card corner-radius">
                        <div class="header">
                            <h2>EDIT CATEGORY SECTION</h2> 
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
                                        <div class="font-12">Category Section</div>
                                        <div class="form-line">
                                            <input type="text" value='<?php echo $row['name']; ?>' class="form-control" name="name" id="name" placeholder="Type Category Sectio" required/>
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