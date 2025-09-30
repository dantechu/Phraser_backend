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

        $data = array(											 
			'cat_id'  	=> $categoryId,
			'tags' 		=> '', // Keep tags field empty since we're using mood relationships
			'quote' => clean($_POST['quote']),
		);	

		$hasil = update('tbl_gallery', $data, "WHERE id = '$ID'");

		// Delete existing mood relationships
		$delete_moods = "DELETE FROM tbl_phraser_moods WHERE phraser_id = '$ID'";
		$connect->query($delete_moods);

		// Insert new mood relationships if any moods were selected
        if (isset($_POST['moods']) && is_array($_POST['moods'])) {
            foreach ($_POST['moods'] as $mood_id) {
                $mood_data = array(
                    'phraser_id' => $ID,
                    'mood_id' => clean($mood_id)
                );
                insert('tbl_phraser_moods', $mood_data);
            }
        }

		if ($hasil >= 0) { // Changed > to >= to handle cases where no changes were made to the main table
            $_SESSION['msg'] = "Changes Saved...";
            header("Location:phraser-edit.php?id=$ID");
            exit;
		}


	}

 	$sql_categories = "SELECT * FROM tbl_category";
	$result_categories = $connect->query($sql_categories);
	
	$moods_qry = "SELECT * FROM tbl_moods ORDER BY mood_name";
	$moods_result = $connect->query($moods_qry);
	
	// Get current phraser moods
	$current_moods_qry = "SELECT mood_id FROM tbl_phraser_moods WHERE phraser_id = '$ID'";
	$current_moods_result = $connect->query($current_moods_qry);
	$current_moods = array();
	while ($mood_row = mysqli_fetch_array($current_moods_result)) {
		$current_moods[] = $mood_row['mood_id'];
	}

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
                                                            $is_selected = in_array($mood_row['id'], $current_moods) ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $mood_row['id']; ?>" <?php echo $is_selected; ?> 
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