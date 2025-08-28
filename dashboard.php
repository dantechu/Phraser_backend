<?php include_once ('includes/header.php'); ?>

<?php

  $categories = "SELECT COUNT(*) as num FROM tbl_category";
  $totalCategories = $connect->query($categories);
  $totalCategories = $totalCategories->fetch_array();
  $totalCategories = $totalCategories['num'];

  $featured = "SELECT COUNT(*) as num FROM tbl_gallery WHERE featured = 'yes'";
  $totalFeatured = $connect->query($featured);
  $totalFeatured = $totalFeatured->fetch_array();
  $totalFeatured = $totalFeatured['num'];

  $wallpapers = "SELECT COUNT(*) as num FROM tbl_gallery";
  $totalWallpapers = $connect->query($wallpapers);
  $totalWallpapers = $totalWallpapers->fetch_array();
  $totalWallpapers = $totalWallpapers['num'];

?>

    <section class="content">

    <ol class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li class="active">Home</a></li>
    </ol>

        <div class="container-fluid">
             
             <div class="row">

                <a href="category.php">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect corner-radius col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name">MANAGE CATEGORY</div>
                            <div class="color-name"><i class="material-icons">people</i></div>
                            <div class="color-class-name">Total ( <?php echo $totalCategories; ?> ) Categories</div>
                            <br>
                        </div>
                    </div>
                </a>

                <!-- <a href="featured.php">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect corner-radius col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name">MANAGE FEATURED</div>
                            <div class="color-name"><i class="material-icons">lens</i></div>
                            <div class="color-class-name">Total ( <?php echo $totalFeatured; ?> ) Wallpapers</div>
                            <br>
                        </div>
                    </div>
                </a> -->

                <a href="phraser.php">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect corner-radius col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name">MANAGE PHRASER</div>
                            <div class="color-name"><i class="material-icons">image</i></div>
                            <div class="color-class-name">Total ( <?php echo $totalWallpapers; ?> ) Phraser</div>
                            <br>
                        </div>
                    </div>
                </a>

                <a href="notification.php">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect corner-radius col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name">NOTIFICATION</div>
                            <div class="color-name"><i class="material-icons">notifications</i></div>
                            <div class="color-class-name">Send notification to your users</div>
                            <br>
                        </div>
                    </div>
                </a>

                <!-- <a href="ads.php">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect corner-radius col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name uppercase">MANAGE ADS</div>
                            <div class="color-name"><i class="material-icons">monetization_on</i></div>
                            <div class="color-class-name">App Monetization</div>
                            <br>
                        </div>
                    </div>
                </a> -->

                <a href="admin.php">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect corner-radius col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name">ADMINISTRATOR</div>
                            <div class="color-name"><i class="material-icons">people</i></div>
                            <div class="color-class-name">Admin Panel Privileges</div>
                            <br>
                        </div>
                    </div>
                </a>

                <a href="settings.php">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect corner-radius col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name">SETTINGS</div>
                            <div class="color-name"><i class="material-icons">settings</i></div>
                            <div class="color-class-name">Key and Privacy Settings</div>
                            <br>
                        </div>
                    </div>
                </a>

            </div>
            
        </div>

    </section>


<?php include_once('includes/footer.php'); ?>