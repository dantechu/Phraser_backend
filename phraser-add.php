<?php include_once('includes/header.php'); ?>
<?php include_once('thumbnail.php'); ?>

<?php
 
	$cat_qry = "SELECT * FROM tbl_category ORDER BY category_name";
	$cat_result = $connect->query($cat_qry);
	
	$moods_qry = "SELECT * FROM tbl_moods ORDER BY mood_name";
	$moods_result = $connect->query($moods_qry);    
	
	if(isset($_POST['submit'])) {

        // Insert phraser data
        $data = array( 
            'cat_id'    => $_POST['cat_id'],
            'quote'    => $_POST['quote'],
            'tags'      => '', // We'll keep tags field empty since we're using mood relationships
        );	

        $phraser_id = insert('tbl_gallery', $data);

        // Insert mood relationships if any moods were selected
        if (isset($_POST['moods']) && is_array($_POST['moods'])) {
            foreach ($_POST['moods'] as $mood_id) {
                $mood_data = array(
                    'phraser_id' => $phraser_id,
                    'mood_id' => clean($mood_id)
                );
                insert('tbl_phraser_moods', $mood_data);
            }
        }

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
                                        <div class="font-12">Moods (Optional)</div>
                                        <div style="position: relative; z-index: 1000;">
                                            <select class="form-control selectpicker" name="moods[]" id="moods" multiple 
                                                    data-live-search="true" 
                                                    data-size="5" 
                                                    data-width="100%" 
                                                    data-style="btn-default" 
                                                    data-max-options-text="Maximum reached"
                                                    title="Choose moods...">
                                                <?php
                                                    if (mysqli_num_rows($moods_result) > 0) {
                                                        while ($mood_row = mysqli_fetch_array($moods_result)) {
                                                ?>
                                                    <option value="<?php echo $mood_row['id']; ?>" 
                                                            data-content="<span class='mood-option' style='background-color: <?php echo $mood_row['mood_color']; ?>; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px; display: inline-block;'><?php echo $mood_row['mood_name']; ?></span>">
                                                        <?php echo $mood_row['mood_name']; ?>
                                                    </option>
                                                <?php
                                                        }
                                                    } else {
                                                        echo '<option disabled>No moods available</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <small class="text-muted" style="font-size: 11px;">Select multiple moods for this phraser</small>
                                    </div>

                                    <style>
                                        .bootstrap-select .dropdown-menu {
                                            max-height: 300px !important;
                                            overflow-y: auto;
                                            z-index: 1050 !important;
                                        }
                                        .bootstrap-select .btn-default {
                                            border: 1px solid #ddd;
                                            background: white;
                                            min-height: 38px;
                                        }
                                        .mood-option {
                                            white-space: nowrap;
                                        }
                                        .bootstrap-select .dropdown-menu li a {
                                            padding: 6px 12px 6px 80px;
                                        }
                                        .bootstrap-select .dropdown-menu li.selected a {
                                            background-color: #f5f5f5 !important;
                                        }
                                    </style>                                                            

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