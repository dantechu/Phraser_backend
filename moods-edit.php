<?php include_once('includes/header.php'); ?>

<?php

	if (isset($_GET['id'])) {
        $ID = clean($_GET['id']);
 		$qry 	= "SELECT * FROM tbl_moods WHERE id = '$ID'";
		$result = $connect->query($qry);
		$row 	= $result->fetch_assoc();
 	}

	if(isset($_POST['submit'])) {

        $data = array(
			'mood_name'  => clean($_POST['mood_name']),
			'mood_icon' => clean($_POST['mood_icon'])
		);	

		$hasil = update('tbl_moods', $data, "WHERE id = '$ID'");

		if ($hasil > 0) {
            $_SESSION['msg'] = "Changes Saved...";
            header("Location:moods-edit.php?id=$ID");
            exit;
		}

	}

?>

<section class="content">
   
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="moods.php">Manage Moods</a></li>
            <li class="active">Edit Mood</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                	<form id="form_validation" method="post">
                    <div class="card corner-radius">
                        <div class="header">
                            <h2>EDIT MOOD</h2> 
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

                                    <div class="form-group form-float col-sm-6">
                                        <div class="form-line">
                                            <div class="font-12">Mood Name</div>
                                            <input value='<?php echo $row['mood_name']; ?>' type="text" class="form-control" name="mood_name" id="mood_name" placeholder="e.g. Happy, Sad, Motivated" required/>
                                        </div>
                                    </div>

                                    <div class="form-group form-float col-sm-6">
                                        <div class="form-line">
                                            <div class="font-12">Mood Icon (Emoji)</div>
                                            <input value='<?php echo $row['mood_icon']; ?>' type="text" class="form-control" name="mood_icon" id="mood_icon" placeholder="e.g. 😊 😢 😡 💪" maxlength="10" required/>
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