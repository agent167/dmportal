<?php include('inc_meta_header.php'); ?>
<title>
    <?php
    $page_link_url = basename($_SERVER['PHP_SELF']);
    $plu_del_ext = rtrim($page_link_url, ' .php');
    echo $plu_del_rep = ucwords(str_replace("_", " ", $plu_del_ext));
    ?>
    <?php include('inc_page_title.php'); ?>
</title>
<?php include('inc_head.php'); ?>
<?php include('countries_backend.php'); ?>
<?php
if (isset($_GET['id'])) {
    $get_id = $_GET['id'];
    $countries =  mysqli_query($link, "SELECT `cc`.`id` AS `cc_id`,`ct`.`id` AS `ct_id`,`ct`.`name` AS `name`,`cc`.`country_id` AS `country_id` FROM `countries` AS `ct` INNER JOIN `countries_currencies` AS `cc`  ON `ct`.`id`=`cc`.`country_id` WHERE `cc`.`id`='$get_id'");
    foreach ($countries as $country) {
        $cc_id = $country['cc_id'];
        $country_id = $country['country_id'];
    }
    $country_select = mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `countries` WHERE `id`='$country_id'"));
    $country_name = $country_select['name'];
}
if (isset($_POST['submit'])) {
    if (
        ($_FILES["upload_file"]["type"] == "text/csv") && ($_FILES["upload_file"]["size"] < 99999999)
    ) {
        if ($_FILES["upload_file"]["error"] > 0) {
            $StrNotice = "Return Code: " . $_FILES["upload_file"]["error"] . "<br />";
        } else {
            // For CSV File Start
            csv_file_upload($link,$upload_FileName,  $cc_id, $country_id);
            // For CSV File End
        } 
    } else {
        echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$cc_id&country_id=$country_id&failes=1'</script>");
    }
}
?>

<body class="nav-md">
    <style>
        .append-plus {
            cursor: pointer;
        }
        .append-minus {
            cursor: pointer;
        }
        .minus_borders {
            /* border-radius: 50% 40%;
        width: 20px;*/
            background-color: #f5f5f5;
            border-radius: 30px;
            border: 1px solid #c5c5c5;
            font-size: 11px;
            min-width: 20px;
            /* position: absolute; */
            margin: 0 !important;
            padding: 5px 2px 3px 2px;
            text-align: center;
        }
        .minus_button {
            background-color: white;
            border: none;
        }
    </style>
    <div class="container body" style="height: 100vh;">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <?php include('inc_nav.php'); ?>
            </div>
            <?php include('inc_header.php'); ?>
            <!-- breadcrumb -->
            <div class="breadcrumb_content">
                <div class="breadcrumb_text"><a href="dashboard.php">Dashboard</a> / <?php echo $plu_del_rep; ?>
                </div>
            </div>
            <!-- /breadcrumb -->
            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $plu_del_rep; ?></h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h4><?php echo $plu_del_rep; ?></h4>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a href="<?php echo basename($_SERVER['REQUEST_URI']) ?>" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Page Refresh"><i class="fa fa-refresh"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <?php if (isset($_GET['success'])) { ?>
                                        <div class='alert alert-success'>
                                            <div class='container'><strong>Row Successfully inserted.</strong></div>
                                        </div>
                                    <?php }
                                    if (isset($_GET['failes']) && $_GET['failes'] == 1) { ?>
                                        <div class='alert alert-danger'>
                                            <div class='container'><strong>This type of file is not allowed to upload.</strong></div>
                                        </div>
                                    <?php } ?>
                                    <div id="no-more-tables">
                                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $cc_id; ?>&country_id=<?php echo $country_id; ?>" method="POST" id="product_add" enctype="multipart/form-data" name="uploadfiles" autocomplete="off">
                                            <!-- <input type="hidden" name="id" value="<?php //echo $cc_id; 
                                                                                        ?>">
                                            <input type="hidden" name="country_id" value="<?php //echo $country_id; 
                                                                                            ?>"> -->
                                            <div class="container">
                                                <div class="row sml-padding conatnt_alignment">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label for="sending_country" class="control-label">Sending Country </label>
                                                        <div class="form-control"><?php echo $country_name; ?></div>
                                                    </div>
                                                </div>
                                                <div class="row sml-padding" id="upload_file_1">
                                                    <div class="conatnt_alignment">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                            <label class="control-label" for="upload_file">Upload CSV <span class="text-danger">*</span></label>
                                                            <input type="file" name="upload_file" id="upload_file" class="form-control upload_file_attr">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row sml-padding conatnt_alignment">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><a href="countries_list.php" class="btn btn-default">Back</a> <input type="submit" class="btn btn-primary" name="submit" value="Submit"></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        <?php include('inc_footer.php'); ?>
    </div>
    </div>
    <?php include('inc_foot.php'); ?>