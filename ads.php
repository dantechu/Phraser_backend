<?php include_once('includes/header.php'); ?>

<?php

    $ID =  clean("1");

    $sql = "SELECT * FROM tbl_ads WHERE id = '$ID'";
    $result = $connect->query($sql);
    $settings_row = $result->fetch_assoc();

    if (isset($_POST['submit'])) {

        $primaryAd = $_POST['ad_type'];
        $backupAd = $_POST['backup_ads'];

        $data = array(
            'ad_status'                   => clean($_POST['ad_status']),
            'ad_type'                     => $primaryAd,
            'backup_ads'                  => $backupAd,
            'admob_publisher_id'          => clean($_POST['admob_publisher_id']),
            'admob_app_id'                => clean($_POST['admob_app_id']),
            'admob_banner_unit_id'        => clean($_POST['admob_banner_unit_id']),
            'admob_interstitial_unit_id'  => clean($_POST['admob_interstitial_unit_id']),
            'admob_native_unit_id'        => clean($_POST['admob_native_unit_id']),
            'admob_app_open_ad_unit_id'   => clean($_POST['admob_app_open_ad_unit_id']),
            'startapp_app_id'             => clean($_POST['startapp_app_id']),
            'unity_game_id'               => clean($_POST['unity_game_id']),
            'unity_banner_placement_id'   => clean($_POST['unity_banner_placement_id']),
            'unity_interstitial_placement_id'  => clean($_POST['unity_interstitial_placement_id']),
            'applovin_banner_ad_unit_id'       => clean($_POST['applovin_banner_ad_unit_id']),
            'applovin_interstitial_ad_unit_id' => clean($_POST['applovin_interstitial_ad_unit_id']),
            'applovin_native_ad_manual_unit_id' => clean($_POST['applovin_native_ad_manual_unit_id']),
            'applovin_banner_zone_id' => clean($_POST['applovin_banner_zone_id']),
            'applovin_interstitial_zone_id' => clean($_POST['applovin_interstitial_zone_id']),
            'mopub_banner_ad_unit_id' => clean($_POST['mopub_banner_ad_unit_id']),
            'mopub_interstitial_ad_unit_id' => clean($_POST['mopub_interstitial_ad_unit_id']),
            'interstitial_ad_interval'    => clean($_POST['interstitial_ad_interval']),
            'native_ad_interval'          => clean($_POST['native_ad_interval']),
            'native_ad_index'             => clean($_POST['native_ad_index'])
        );

        if ($backupAd == $primaryAd) {
            $_SESSION['msg'] = "Backup Ad cannot be the same as Primary Ad and vice versa!";
            header( "Location:ads.php");
            exit;
        } else {
            $update = update('tbl_ads', $data, "WHERE id = '1'");
            if ($update > 0) {
                $_SESSION['msg'] = "Changes Saved...";
                header( "Location:ads.php");
                exit;
            }
        }

    }

    $sql_status = mysqli_query($connect, "SELECT * FROM tbl_ads_status WHERE ads_status_id = 1");
    $row_status = mysqli_fetch_assoc($sql_status);
    if (isset($_GET['placement']) && isset($_GET['status'])) {
        $placement = clean($_GET['placement']);
        $status = clean($_GET['status']);
        if ($status == 1) {
            $update = "UPDATE tbl_ads_status SET $placement = 0";
            if (mysqli_query($connect, $update)) {
                header( "Location:ads.php");
                exit;
            }
        } else {
            $update = "UPDATE tbl_ads_status SET $placement = 1";
            if (mysqli_query($connect, $update)) {
                header( "Location:ads.php");
                exit;
            }
        }
    }

?>

<script src="assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(e) {

        $("#ad_status").change(function() {
            var status = $("#ad_status").val();
            if (status == "on") {
                $("#ad_status_on").show();
            } else {
                $("#ad_status_on").hide();
            }
            
        });

        $( window ).load(function() {
            var status = $("#ad_status").val();
            if (status == "on") {
                $("#ad_status_on").show();
            } else {
                $("#ad_status_on").hide();
            }
        });

        //primary ads
        $("#ad_type").change(function() {
            var type = $("#ad_type").val();
            if (type == "admob") {
                $("#admob_ad_network").show();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_max_ad_network").hide();
                $("#applovin_discovery_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "startapp") {
                $("#admob_ad_network").hide();
                $("#startapp_ad_network").show();
                $("#unity_ad_network").hide();
                $("#applovin_max_ad_network").hide();
                $("#applovin_discovery_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "unity") {
                $("#admob_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").show();
                $("#applovin_max_ad_network").hide();
                $("#applovin_discovery_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "applovin") {
                $("#admob_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_max_ad_network").show();
                $("#applovin_discovery_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "applovin_discovery") {
                $("#admob_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_max_ad_network").hide();
                $("#applovin_discovery_ad_network").show();
                $("#mopub_ad_network").hide();
            }
            if (type == "mopub") {
                $("#admob_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_max_ad_network").hide();
                $("#applovin_discovery_ad_network").hide();
                $("#mopub_ad_network").show();
            }
        });

        $( window ).load(function() {
            var type = $("#ad_type").val();
            if (type == "admob") {
                $("#admob_ad_network").show();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_max_ad_network").hide();
                $("#applovin_discovery_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "startapp") {
                $("#admob_ad_network").hide();
                $("#startapp_ad_network").show();
                $("#unity_ad_network").hide();
                $("#applovin_max_ad_network").hide();
                $("#applovin_discovery_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "unity") {
                $("#admob_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").show();
                $("#applovin_max_ad_network").hide();
                $("#applovin_discovery_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "applovin") {
                $("#admob_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_max_ad_network").show();
                $("#applovin_discovery_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "applovin_discovery") {
                $("#admob_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_max_ad_network").hide();
                $("#applovin_discovery_ad_network").show();
                $("#mopub_ad_network").hide();
            }
            if (type == "mopub") {
                $("#admob_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_max_ad_network").hide();
                $("#applovin_discovery_ad_network").hide();
                $("#mopub_ad_network").show();
            }
        });

        //backup ads
        $("#backup_ads").change(function() {
            var type = $("#backup_ads").val();
            if (type == "admob") {
                $("#admob_ad_network").show();
            }
            if (type == "startapp") {
                $("#startapp_ad_network").show();
            }
            if (type == "unity") {
                $("#unity_ad_network").show();
            }
            if (type == "applovin") {
                $("#applovin_max_ad_network").show();
            }
            if (type == "applovin_discovery") {
                $("#applovin_discovery_ad_network").show();
            }
            if (type == "mopub") {
                $("#mopub_ad_network").show();
            }
        });

        $( window ).load(function() {
            var type = $("#backup_ads").val();
            if (type == "admob") {
                $("#admob_ad_network").show();
            }
            if (type == "startapp") {
                $("#startapp_ad_network").show();
            }
            if (type == "unity") {
                $("#unity_ad_network").show();
            }
            if (type == "applovin") {
                $("#applovin_max_ad_network").show();
            }
            if (type == "applovin_discovery") {
                $("#applovin_discovery_ad_network").show();
            }
            if (type == "mopub") {
                $("#mopub_ad_network").show();
            }
        });

    });

</script>

<section class="content">

    <ol class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li class="active">Manage Ads</a></li>
    </ol>

    <div class="container-fluid">

        <div class="row clearfix">

            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">

                <form method="post" enctype="multipart/form-data">

                    <div class="card corner-radius">
                        <div class="header">
                            <h2>MANAGE ADS</h2>
                            <div class="header-dropdown m-r--5">
                                <button type="submit" name="submit" class="button button-rounded btn-offset waves-effect waves-float">UPDATE</button>
                            </div>
                        </div>

                        <div class="body">

                            <?php if(isset($_SESSION['msg'])) { ?>
                            <div class='alert alert-info alert-dismissible corner-radius' role='alert'>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>&nbsp;&nbsp;</button>
                                <?php echo $_SESSION['msg']; ?>
                            </div>
                            <?php unset($_SESSION['msg']); } ?>                            

                            <div class="row clearfix">

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="font-12">Ad Status</div>
                                        <select class="form-control show-tick" name="ad_status" id="ad_status">
                                            <?php if ($settings_row['ad_status'] == 'on') { ?>
                                            <option value="on" selected="selected">ON</option>
                                            <option value="off">OFF</option>
                                            <?php } else { ?>
                                            <option value="on">ON</option>
                                            <option value="off" selected="selected">OFF</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div id="ad_status_on">

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="font-12">Primary Ad Network</div>
                                            <select class="form-control show-tick" name="ad_type" id="ad_type">
                                                <?php if ($settings_row['ad_type'] == 'admob') { ?>
                                                    <option value="admob" selected="selected">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['ad_type'] == 'startapp') { ?>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp" selected="selected">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['ad_type'] == 'unity') { ?>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity" selected="selected">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['ad_type'] == 'applovin') { ?>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin" selected="selected">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['ad_type'] == 'applovin_discovery') { ?>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery" selected="selected">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['ad_type'] == 'mopub') { ?>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub" selected="selected">Mopub</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="font-12">Backup Ad Network</div>
                                            <select class="form-control show-tick" name="backup_ads" id="backup_ads">
                                                <?php if ($settings_row['backup_ads'] == 'none') { ?>
                                                    <option value="none" selected="selected">None</option>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['backup_ads'] == 'admob') { ?>
                                                    <option value="none">None</option>
                                                    <option value="admob" selected="selected">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['backup_ads'] == 'startapp') { ?>
                                                    <option value="none">None</option>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp" selected="selected">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['backup_ads'] == 'unity') { ?>
                                                    <option value="none">None</option>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity" selected="selected">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['backup_ads'] == 'applovin') { ?>
                                                    <option value="none">None</option>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin" selected="selected">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['backup_ads'] == 'applovin_discovery') { ?>
                                                    <option value="none">None</option>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery" selected="selected">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['backup_ads'] == 'mopub') { ?>
                                                    <option value="none">None</option>
                                                    <option value="admob">AdMob</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin_discovery">AppLovin Discovery</option>
                                                    <option value="applovin">AppLovin MAX</option>
                                                    <option value="mopub" selected="selected">Mopub</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="admob_ad_network">

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">AdMob Publisher ID</div>
                                                    <input type="text" class="form-control" name="admob_publisher_id" id="admob_publisher_id" value="<?php echo $settings_row['admob_publisher_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="font-12">AdMob App ID</div>
                                                <div class="ex2">Important : Your <b>AdMob App ID</b> must be added programmatically inside Android Studio Project in the <b>AndroidManifest.xml</b></div>
                                                <a href="" data-toggle="modal" data-target="#modal-admob-app-id"><button class="button button-rounded waves-effect waves-float">VIEW IMPLEMENTATION</button></a>
                                                <input type="hidden" class="form-control" name="admob_app_id" id="admob_app_id" value="<?php echo $settings_row['admob_app_id'];?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">AdMob Banner Ad Unit ID</div>
                                                    <input type="text" class="form-control" name="admob_banner_unit_id" id="admob_banner_unit_id" value="<?php echo $settings_row['admob_banner_unit_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">AdMob Interstitial Ad Unit ID</div>
                                                    <input type="text" class="form-control" name="admob_interstitial_unit_id" id="admob_interstitial_unit_id" value="<?php echo $settings_row['admob_interstitial_unit_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">AdMob Native Ad Unit ID</div>
                                                    <input type="text" class="form-control" name="admob_native_unit_id" id="admob_native_unit_id" value="<?php echo $settings_row['admob_native_unit_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">AdMob App Open Ad Unit ID</div>
                                                    <input type="text" class="form-control" name="admob_app_open_ad_unit_id" id="admob_app_open_ad_unit_id" value="<?php echo $settings_row['admob_app_open_ad_unit_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div id="startapp_ad_network">

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">StartApp App ID</div>
                                                    <input type="text" class="form-control" name="startapp_app_id" id="startapp_app_id" value="<?php echo $settings_row['startapp_app_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div id="unity_ad_network">

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">Unity Game ID</div>
                                                    <input type="text" class="form-control" name="unity_game_id" id="unity_game_id" value="<?php echo $settings_row['unity_game_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">Unity Banner Ad Placement ID</div>
                                                    <input type="text" class="form-control" name="unity_banner_placement_id" id="unity_banner_placement_id" value="<?php echo $settings_row['unity_banner_placement_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">Unity Interstitial Ad Placement ID</div>
                                                    <input type="text" class="form-control" name="unity_interstitial_placement_id" id="unity_interstitial_placement_id" value="<?php echo $settings_row['unity_interstitial_placement_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div id="applovin_max_ad_network">

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="font-12">AppLovin SDK Key</div>
                                                <div class="ex2">Important : Your <b>AppLovin SDK Key</b> must be added programmatically inside Android Studio Project in the <b>res/value/ads.xml</b></div>
                                                <a href="" data-toggle="modal" data-target="#modal-applovin-sdk-key"><button class="button button-rounded waves-effect waves-float">VIEW IMPLEMENTATION</button></a>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">AppLovin Banner Ad ID</div>
                                                    <input type="text" class="form-control" name="applovin_banner_ad_unit_id" id="applovin_banner_ad_unit_id" value="<?php echo $settings_row['applovin_banner_ad_unit_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">AppLovin Interstitial Ad ID</div>
                                                    <input type="text" class="form-control" name="applovin_interstitial_ad_unit_id" id="applovin_interstitial_ad_unit_id" value="<?php echo $settings_row['applovin_interstitial_ad_unit_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">AppLovin Native Ad (Manual) ID</div>
                                                    <input type="text" class="form-control" name="applovin_native_ad_manual_unit_id" id="applovin_native_ad_manual_unit_id" value="<?php echo $settings_row['applovin_native_ad_manual_unit_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div id="applovin_discovery_ad_network">

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="font-12">AppLovin SDK Key</div>
                                                <div class="ex2">Important : Your <b>AppLovin SDK Key</b> must be added programmatically inside Android Studio Project in the <b>res/value/ads.xml</b></div>
                                                <a href="" data-toggle="modal" data-target="#modal-applovin-sdk-key"><button class="button button-rounded waves-effect waves-float">VIEW IMPLEMENTATION</button></a>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">AppLovin Banner Zone ID</div>
                                                    <input type="text" class="form-control" name="applovin_banner_zone_id" id="applovin_banner_zone_id" value="<?php echo $settings_row['applovin_banner_zone_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">AppLovin Interstitial Zone ID</div>
                                                    <input type="text" class="form-control" name="applovin_interstitial_zone_id" id="applovin_interstitial_zone_id" value="<?php echo $settings_row['applovin_interstitial_zone_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div id="mopub_ad_network">

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">Mopub Banner Ad Unit ID</div>
                                                    <input type="text" class="form-control" name="mopub_banner_ad_unit_id" id="mopub_banner_ad_unit_id" value="<?php echo $settings_row['mopub_banner_ad_unit_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-line">
                                                    <div class="font-12">Mopub Interstitial Ad Unit ID</div>
                                                    <input type="text" class="form-control" name="mopub_interstitial_ad_unit_id" id="mopub_interstitial_ad_unit_id" value="<?php echo $settings_row['mopub_interstitial_ad_unit_id'];?>" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="form-line">
                                                <div class="font-12">Interstitial Ad Interval</div>
                                                <input type="number" class="form-control" name="interstitial_ad_interval" id="interstitial_ad_interval" value="<?php echo $settings_row['interstitial_ad_interval'];?>" required>
                                            </div>
                                        </div>    
                                    </div>   

                                    <input type="hidden" class="form-control" name="native_ad_interval" id="native_ad_interval" value="<?php echo $settings_row['native_ad_interval'];?>" required>
                                    <input type="hidden" class="form-control" name="native_ad_index" id="native_ad_index" value="<?php echo $settings_row['native_ad_index'];?>" required>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card corner-radius">
                        <div class="header">
                            <h2>DISPLAY ADS</h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="font-12 ex1">&nbsp;&nbsp;Enable or Disable Certain Ads Format Separately</div>
                                    <table class="table-condensed">
                                        
                                        <tr class="clickable-row pointer-view" data-href="ads.php?placement=banner_ad_on_home_page&status=<?php echo $row_status['banner_ad_on_home_page']; ?>">
                                            <td>
                                                <?php if ($row_status['banner_ad_on_home_page'] == 1) { ?>
                                                <i class="material-icons ext2" style="color:#4bae4f">check_box</i>
                                                <?php } else { ?>
                                                <i class="material-icons ext2">check_box_outline_blank</i>
                                                <?php } ?>
                                            </td>
                                            <td>Banner Ad on Home Page</td>
                                        </tr>

                                        <tr class="clickable-row pointer-view" data-href="ads.php?placement=banner_ad_on_search_page&status=<?php echo $row_status['banner_ad_on_search_page']; ?>">
                                            <td>
                                                <?php if ($row_status['banner_ad_on_search_page'] == 1) { ?>
                                                <i class="material-icons ext2" style="color:#4bae4f">check_box</i>
                                                <?php } else { ?>
                                                <i class="material-icons ext2">check_box_outline_blank</i>
                                                <?php } ?>
                                            </td>
                                            <td>Banner Ad on Search Page</td>
                                        </tr>

                                        <tr class="clickable-row pointer-view" data-href="ads.php?placement=banner_ad_on_wallpaper_detail&status=<?php echo $row_status['banner_ad_on_wallpaper_detail']; ?>">
                                            <td>
                                                <?php if ($row_status['banner_ad_on_wallpaper_detail'] == 1) { ?>
                                                <i class="material-icons ext2" style="color:#4bae4f">check_box</i>
                                                <?php } else { ?>
                                                <i class="material-icons ext2">check_box_outline_blank</i>
                                                <?php } ?>
                                            </td>
                                            <td>Banner Ad on Wallpaper Detail</td>
                                        </tr>

                                        <tr class="clickable-row pointer-view" data-href="ads.php?placement=banner_ad_on_wallpaper_by_category&status=<?php echo $row_status['banner_ad_on_wallpaper_by_category']; ?>">
                                            <td>
                                                <?php if ($row_status['banner_ad_on_wallpaper_by_category'] == 1) { ?>
                                                <i class="material-icons ext2" style="color:#4bae4f">check_box</i>
                                                <?php } else { ?>
                                                <i class="material-icons ext2">check_box_outline_blank</i>
                                                <?php } ?>
                                            </td>
                                            <td>Banner Ad on Wallpaper by Category</td>
                                        </tr>

                                        <tr class="clickable-row pointer-view" data-href="ads.php?placement=interstitial_ad_on_click_wallpaper&status=<?php echo $row_status['interstitial_ad_on_click_wallpaper']; ?>">
                                            <td>
                                                <?php if ($row_status['interstitial_ad_on_click_wallpaper'] == 1) { ?>
                                                <i class="material-icons ext2" style="color:#4bae4f">check_box</i>
                                                <?php } else { ?>
                                                <i class="material-icons ext2">check_box_outline_blank</i>
                                                <?php } ?>
                                            </td>
                                            <td>Interstitial Ad on click Wallpaper</td>
                                        </tr>

                                        <tr class="clickable-row pointer-view" data-href="ads.php?placement=interstitial_ad_on_wallpaper_detail&status=<?php echo $row_status['interstitial_ad_on_wallpaper_detail']; ?>">
                                            <td>
                                                <?php if ($row_status['interstitial_ad_on_wallpaper_detail'] == 1) { ?>
                                                <i class="material-icons ext2" style="color:#4bae4f">check_box</i>
                                                <?php } else { ?>
                                                <i class="material-icons ext2">check_box_outline_blank</i>
                                                <?php } ?>
                                            </td>
                                            <td>Interstitial Ad on Wallpaper Detail</td>
                                        </tr>

                                        <tr class="clickable-row pointer-view" data-href="ads.php?placement=native_ad_on_wallpaper_list&status=<?php echo $row_status['native_ad_on_wallpaper_list']; ?>">
                                            <td>
                                                <?php if ($row_status['native_ad_on_wallpaper_list'] == 1) { ?>
                                                <i class="material-icons ext2" style="color:#4bae4f">check_box</i>
                                                <?php } else { ?>
                                                <i class="material-icons ext2">check_box_outline_blank</i>
                                                <?php } ?>
                                            </td>
                                            <td>Native Ad on Wallpaper List</td>
                                        </tr>

                                        <tr class="clickable-row pointer-view" data-href="ads.php?placement=app_open_ad&status=<?php echo $row_status['app_open_ad']; ?>">
                                            <td>
                                                <?php if ($row_status['app_open_ad'] == 1) { ?>
                                                <i class="material-icons ext2" style="color:#4bae4f">check_box</i>
                                                <?php } else { ?>
                                                <i class="material-icons ext2">check_box_outline_blank</i>
                                                <?php } ?>
                                            </td>
                                            <td>AdMob App Open Ads</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </form>

            </div>


            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">

                <div class="card corner-radius">
                    <div class="header">
                        <h2>ANNOUNCEMENT</h2>
                    </div>

                    <div class="body body-offset">

                        <div class="row clearfix" style="padding-right: 10px;">

                            <ol>
                                <li><b>Facebook Audience Network</b> will only use bidding for Android apps starting September 30, 2021. Placement ID from Waterfall are <b>deprecated</b> now. So, put Audience Network placement ID from admin panel is no longer used, you need to setup for Bidding with Partner Mediation.</li>
                                <br>

                                <li>If you choose to use <b>Facebook Audience Network</b> Open Bidding, please select <b>Ad Network Type</b> to be <b>AdMob</b>, <b>AppLovin</b> or <b>Mopub</b>, These Ad Networks support being a Mediation Partner although it's still a Beta version.</li>
                                <br>

                                <li><b>AdMob</b> as a Bidding Mediation Partner for Audience Network :
                                    <br>* The official documentation can be seen <a href="https://developers.facebook.com/docs/audience-network/bidding/partner-mediation/admob" target="_blank"><b>Here</b></a>
                                    <br>* See AdMob's guidance on how to set up for <a href="https://developers.google.com/admob/android/mediation/facebook?fbclid=IwAR3E_IRcUqQmTjqdW_3dq6vPbodTQqUtQgmk_lCgjizr8T1MR7Bh1Qa1Oic" target="_blank"><b>Android</b></a> (Step 1 & 2)
                                </li>
                                <br>

                                <li><b>AppLovin</b> as a Bidding Mediation Partner for Audience Network :
                                    <br>* The official documentation can be seen <a href="https://developers.facebook.com/docs/audience-network/bidding/partner-mediation/max" target="_blank"><b>Here</b></a>
                                    <br>* See AdMob's guidance on how to set up for <a href="https://dash.applovin.com/documentation/mediation/android/mediation-setup/facebook" target="_blank"><b>Android</b></a>
                                </li>
                                <br>


                                <li><b>Mopub</b> as a Bidding Mediation Partner for Audience Network :
                                    <br>* The official documentation can be seen <a href="https://developers.facebook.com/docs/audience-network/bidding/partner-mediation/mopub" target="_blank"><b>Here</b></a>
                                </li>
                                <br>

                                <li>Supported Ad Formats :
                                    <br>* <b>AdMob</b> : Banner, Interstitial, Native, App Open
                                    <br>* <b>StartApp</b> : Banner, Interstitial, Native
                                    <br>* <b>Unity Ads</b> : Banner, Interstitial
                                    <br>* <b>AppLovin Discovery</b> : Banner, Interstitial
                                    <br>* <b>AppLovin MAX</b> : Banner, Interstitial, Native
                                    <br>* <b>Mopub</b> : Banner, Interstitial
                                    <br>* <b>Audience Network</b> : Open Bidding with AdMob, AppLovin MAX or Mopub as mediation partner 
                                </li>

                            </ol>

                        </div>

                    </div>

                </div>
                
            </div>


        </div>



    </div>

</section>

<?php include_once('includes/footer.php'); ?>