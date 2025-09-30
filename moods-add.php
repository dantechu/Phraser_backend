<?php include_once('includes/header.php'); ?>
<?php 

    if (isset($_POST['submit'])) {

        $data = array(
            'mood_name'	 => clean($_POST['mood_name']),
            'mood_color' => clean($_POST['mood_color'])
        );

        $qry = insert('tbl_moods', $data);

        $_SESSION['msg'] = "Mood added successfully...";
        header( "Location: moods-add.php");
        exit;

    }

?>

<section class="content">

	<ol class="breadcrumb">
		<li><a href="dashboard.php">Dashboard</a></li>
		<li><a href="moods.php">Manage Moods</a></li>
		<li class="active">Add Mood</a></li>
	</ol>

	<div class="container-fluid">

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

				<form id="form_validation" method="post">
					<div class="card corner-radius">
						<div class="header">
							<h2>ADD MOOD</h2>
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
											<input type="text" class="form-control" name="mood_name" id="mood_name" placeholder="e.g. Happy, Sad, Motivated" required>
										</div>
									</div>

									<div class="form-group form-float col-sm-6">
										<div class="form-line">
											<div class="font-12">Mood Color</div>
											<input type="color" class="form-control" name="mood_color" id="mood_color" value="#FFD700" required>
										</div>
									</div>

									<div class="col-sm-12">
										<button class="button button-rounded waves-effect waves-float pull-right" type="submit" name="submit">SUBMIT</button>
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