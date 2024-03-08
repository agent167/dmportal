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
    $country_id = $_GET['country_id'];
    $countries =  mysqli_query($link, "SELECT `cc`.`id` AS `cc_id`,`ct`.`id` AS `ct_id`,`ct`.`name` AS `name`,`ct`.`currency` AS `currency`,`ct`.`iso` AS `iso`,`cc`.`country_id` AS `country_id` FROM `countries` AS `ct` INNER JOIN `countries_currencies` AS `cc`  ON `ct`.`id`=`cc`.`country_id` WHERE `cc`.`country_id`='$country_id'");
    foreach ($countries as $country) {
        $cc_id = $country['cc_id'];
        $country_id = $country['country_id'];
        $country_name = $country['name'];
        $iso = $country['iso'];
        $currency_code = $country['currency'];
    }
    $currencies_rates =  mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$cc_id'");
    $currencies_rates_counts =  mysqli_num_rows($currencies_rates);
}
if (isset($_POST['edit_submit'])) {
    $rate_id = $_POST['rate_id'];
    $currency = $_POST['currency'];
    // print_r($currency);
    $currency_count = count($_POST['currency']);
    $rate = $_POST['rate'];
    for ($i = 0; $i < $currency_count; $i++) {
        if (empty($_POST['preferrence'][$i])) {
            $preferrence = 0;
        } else {
            $preferrence = 1;
        }
        $validaiton_count = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `id`=$rate_id[$i] AND `rate` != '$rate[$i]'"));
        if ($validaiton_count != 0) {
            specific_rates_history($link, $i, $rate_id);
        }
        $sql_query = "UPDATE `countries_currencies_rates` SET `rate`= '$rate[$i]',`preferrence`= '$preferrence',`upated_at`=NOW() WHERE `id` = $rate_id[$i] AND `currency_id` = $currency[$i]";
        if (!mysqli_query($link, $sql_query)) {
            echo "ERROR: Could not able to execute $sql_query. " . mysqli_error($link);
        }
    }
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$get_id&country_id=$country_id&success=y'</script>");
}
// $folderPath = "D:/DM Rate Posting/";
$folderPath = "images/downloads/";
// $folderPath = "D:/images/downloads/";
// $folderPath = "X:/";


?>
<style>
    #sending_content {
        position: relative;
        width: 1080px;
        height: 1080px;
        color: #fff;
    }

    #sending_content img {
        /* width: 100%; */
    }

    .list-content {
        position: absolute;
        top: 0px;
        right: 0px;
        /* transform: translate(-0%, -0%); */
        /* padding-right: 9px; */
        height: 100%;
        display: table;
        padding: 0px;
        margin: 0px;
    }

    #sending_content ul {
        list-style-type: none;
        display: table-cell;
        vertical-align: middle;
    }

    #sending_content ul li img {
        width: 54px;
        /* display: inline-block; */
    }

    #sending_content ul li {
        margin: 21px -10px 21px 0;
        display: flex;
        flex-direction: row;
        padding-left: 125px;
    }

    .sending_li_8 {
        margin: 62px 0 63px 433px !important;

    }

    .sending_li_9 {
        margin: 52px 0 56px 433px !important;
    }

    .sending_li_10 {
        margin: 48px 0 47px 433px !important;
    }

    .sending_li_11 {
        margin: 40px 0 40px 433px !important;
    }

    .sending_li_12 {
        margin: 33px 0 32px 433px !important;
    }

    .sending_li_13 {
        margin: 26px 0 27px 433px !important;
    }

    .sending_li_14 {
        margin: 17px 0 21px 433px !important;
    }

    .sending_li_15 {
        margin: 16px 0 16px 432px !important;
    }

    #sending_content .rate-input {
        font-family: sans-serif;
        width: 51%;
        text-align: center;
        margin: 0 30px;
        font-weight: 900;
        font-size: 26px;
        border: 1px solid #d1cac3;
        border-radius: 5px;
        color: black;
    }

    input:focus {
        outline: none;
    }

    #sending_content .c-short {
        /* font-size: 20px;
        color: #000;
        font-weight: bold;
        display: inline-block;
        max-width: 30px !important; */
        font-size: 26px;
        color: #000;
        font-weight: 900;
        margin-top: 6px;
    }

    .download_icon {
        color: #f4901b;
        font-size: 25px;
        cursor: pointer;
    }

    .active {
        border: 1px solid #f4901b;
        border-bottom: 0;
        font-weight: bold;
    }

    .nav-tabs a:hover {
        color: #f4901b;
    }

    #receiving_content {
        position: relative;
        width: 1080px;
        height: 1080px;
        color: #fff;
    }

    #receiving_content ul {
        list-style-type: none;
        display: table-cell;
        vertical-align: bottom;
    }

    #receiving_content ul li img {
        width: 54px;
    }

    #receiving_content ul li {
        margin: 0px 53px 31px 0;
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
    }

    .nine {
        margin: 0px 53px 39px 0 !important;
    }

    .eight1 {
        margin: 0px 53px 48px 0 !important;
    }

    #receiving_content .rate-input {
        font-family: sans-serif;
        width: 40%;
        text-align: center;
        margin: 0 9px;
        font-weight: 900;
        font-size: 26px;
        border: 1px solid #d1cac3;
        border-radius: 5px;
        color: black;
    }

    #receiving_content .c-short {
        /* font-size: 20px;
        color: #000;
        font-weight: bold;
        display: inline-block;
        max-width: 30px !important; */
        font-size: 26px;
        color: #000;
        font-weight: 900;
        margin-top: 6px;
    }

    .list-left-content {
        position: absolute;
        top: 0px;
        left: 0px;
        height: 100%;
        /* display: table; */
        padding: 0px;
        margin: 0px;
    }

    .list-left-content .round_bog_image {
        width: 55%;
        margin: 35.8% 0 0 5.9%;
    }

    .list-left-content h1 {
        font-size: 85px;
        font-weight: 900;
        font-family: monospace;
        margin-left: 6%;
        -webkit-transform: scale(1.2, 1);
    }

    .list-left-content p.sub_heading_one {
        font-size: 20px;
        font-weight: 700;
        font-family: sans-serif;
        margin-left: 9%;
        line-height: 20px;
        margin-top: 3%;
        -webkit-transform: scale(1.5, 1.3);
    }

    .list-left-content p.sub_heading_two {
        font-size: 18px;
        font-weight: 700;
        font-family: sans-serif;
        margin-left: 9%;
        line-height: 19px;
        margin-top: 9%;
        -webkit-transform: scale(1.5, 1.3);
    }

    .list-left-content div.sub_heading_three {
        margin-left: 3%;
        margin-top: 11%;
        display: flex;
        justify-content: space-around;
        line-height: 20px;
        align-items: center;
    }

    /* .list-left-content ol {
        list-style-type: none;
        display: table-cell;
        vertical-align: bottom;
    } */

    .list-left-content div.sub_heading_three img {
        width: 60px;
        height: 60px;
    }

    .list-left-content div.sub_heading_three p {
        text-align: left;
        font-size: 18px;
        font-family: sans-serif;
        font-weight: 700;
    }

    .list-left-content div.sub_heading_four {
        text-align: center;
        margin-left: 9%;
    }

    .list-left-content p {
        font-size: 18px;
        font-weight: 700;
        font-family: sans-serif;
    }

    .sending_download,
    .receiving_download,
    .individual_download {
        background-color: transparent;
        border: none;
    }
</style>

<body class="nav-md">
    <div class="container body">
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
                                <style>
                                    /* #success_message {
                                        display: none;
                                    } */
                                </style>
                                <div id="success_message"> </div>

                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active preferred_country_tab"><a href="#">Select Preferred Country</a></li>
                                    <?php
                                    // echo $get_id;
                                    $banner_sending_validaiton = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `banners` WHERE `count_curr_id`='$get_id' AND `type`!=2"));
                                    if ($banner_sending_validaiton > 0) {
                                    ?>
                                        <li class="country_wise_tab"><a href="#">Country Wise</a></li>
                                        <li class="individuals_tab"><a href="#">Individuals</a></li>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    $banner_receiving_validaiton = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `banners` WHERE `count_curr_id`='$get_id' AND `type`=2"));
                                    if ($banner_receiving_validaiton > 0) {
                                    ?>
                                        <li class="receiving_wise_tab"><a href="#">Currency Wise</a></li>
                                    <?php
                                    }
                                    ?>

                                </ul>
                                <div class="x_content">
                                    <div class="row" id="preferred_country_div">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="color:#f4901b;display: flex;justify-content: space-between;">
                                            <h1><?php echo $currencies_rates_counts; ?></h1>
                                            <h1 class="updated_counts"></h1>
                                        </div>
                                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $get_id; ?>&country_id=<?php echo $country_id; ?>" method="POST" id="product_add" enctype="multipart/ form-data" name="uploadfiles" autocomplete="off">
                                            <?php
                                            $counter = 0;
                                            foreach ($currencies_rates as $index => $currencies_rate) {
                                                $rate_id = $currencies_rate['id'];
                                                $currency_id = $currencies_rate['currency_id'];
                                                $rate = $currencies_rate['rate'];
                                                $preferrence = $currencies_rate['preferrence'];
                                                $index++;
                                            ?>
                                                <input type="hidden" name="rate_id[]" value="<?php echo $rate_id; ?>">
                                                <div id="parent_div<?php echo $rate_id; ?>" class="conatnt_alignment col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <?php
                                                        if ($index <= 1) {
                                                        ?>
                                                            <label for="currency" class="control-label">Currency <span class="text-danger">*</span></label>
                                                        <?php
                                                        } ?>
                                                        <div class="form-control bg-default"><?php
                                                                                                $countries =  mysqli_fetch_array(mysqli_query($link, "SELECT `currency` FROM `countries` WHERE `id`='$currency_id'"));
                                                                                                echo $countries['currency'];
                                                                                                ?>
                                                            <input type="hidden" name="currency[<?php echo $counter; ?>]" value="<?php echo $currency_id; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <?php
                                                        if ($index <= 1) {
                                                        ?>
                                                            <label for="rate" class="control-label">Rate <span class="text-danger">*</span></label>
                                                        <?php
                                                        } ?>
                                                        <div class="conatnt_alignment" id="<?php echo $rate_id; ?>">
                                                            <input type="number" name="rate[<?php echo $counter; ?>]" id="rate" class="form-control" value="<?php echo $rate; ?>" step="any" required>
                                                            <span class="btn btn-default">
                                                                <input type="checkbox" name="preferrence[<?php echo $counter; ?>]" style="padding: 0;margin: 0;" <?php if ($currencies_rate['preferrence'] == 1) {
                                                                                                                                                                        echo "checked";
                                                                                                                                                                    }
                                                                                                                                                                    ?> value="1">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                $counter++;
                                            }
                                            ?>
                                            <div class="row sml-padding conatnt_alignment">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><a href="countries_list.php" class="btn btn-default">Back</a> <input type="submit" class="btn btn-primary" name="edit_submit" value="Submit"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <script src="vendors/dom/dom-to-image.js"></script>
                                    <script src="vendors/file_server/file-server.js"></script>
                                    <div class="row" id="country_wise_div" style="display: none;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" align="center">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h1>Sending Country Wise</h1>
                                                <?php
                                                $sending_banners =  mysqli_query($link, "SELECT * FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '1' AND `image` IS NOT NULL");
                                                $sending_image = '';
                                                $sending_count_curr_id = '';
                                                foreach ($sending_banners as $sending_banner) {
                                                    $sending_image = $sending_banner['image'];
                                                    $sending_count_curr_id = $sending_banner['count_curr_id'];
                                                }
                                                $sending_currencies_rates =  mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$sending_count_curr_id' AND `preferrence`=1");
                                                if (!empty($sending_image) && mysqli_num_rows($sending_currencies_rates) > 0) {
                                                ?>
                                                    <button class="download_icon sending_download"><i class="fa fa-download" aria-hidden="true"></i></button>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
                                                <?php
                                                if (!empty($sending_image) && mysqli_num_rows($sending_currencies_rates) > 0) {
                                                    $banner_types =  mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE  `id` = '1'"));
                                                    $banner_path = $banner_types['name'];
                                                ?>
                                                    <div id="sending_content" class="list-content" style="background-image: url(images/<?php echo $banner_path; ?>/<?php echo $sending_image; ?>);background-repeat: no-repeat;background-size: contain">
                                                        <ul>
                                                            <?php
                                                            // echo "<pre>";
                                                            // print_r($sending_currencies_rates);
                                                            // echo "<pre>";
                                                            foreach ($sending_currencies_rates as $index => $sending_currencies_rate) {
                                                                $rate_id = $sending_currencies_rate['id'];
                                                                $sending_currency_id = $sending_currencies_rate['currency_id'];
                                                                $rate = $sending_currencies_rate['rate'];
                                                                $countries =  mysqli_fetch_array(mysqli_query($link, "SELECT `currency`,`name` FROM `countries` WHERE id = '$sending_currency_id'"));
                                                                $sending_currency = $countries['currency'];

                                                                $sending_name = strtolower($countries['name']);
                                                                $sending_name = str_replace(" ", "-", $sending_name);
                                                            ?>
                                                                <li class="<?php if (mysqli_num_rows($sending_currencies_rates) == 8) {
                                                                                echo "sending_li_8";
                                                                            } elseif (mysqli_num_rows($sending_currencies_rates) == 9) {
                                                                                echo "sending_li_9";
                                                                            } elseif (mysqli_num_rows($sending_currencies_rates) == 10) {
                                                                                echo "sending_li_10";
                                                                            } elseif (mysqli_num_rows($sending_currencies_rates) == 11) {
                                                                                echo "sending_li_11";
                                                                            } elseif (mysqli_num_rows($sending_currencies_rates) == 12) {
                                                                                echo "sending_li_12";
                                                                            } elseif (mysqli_num_rows($sending_currencies_rates) == 13) {
                                                                                echo "sending_li_13";
                                                                            } elseif (mysqli_num_rows($sending_currencies_rates) == 14) {
                                                                                echo "sending_li_14";
                                                                            } elseif (mysqli_num_rows($sending_currencies_rates) == 15) {
                                                                                echo "sending_li_15";
                                                                            } ?>">
                                                                    <img src="flat-country-flags-64x64/<?php echo $sending_name; ?>.png" alt="">
                                                                    <input type="text" class="rate-input" readonly value="<?php echo $rate; ?>">
                                                                    <p class="c-short"><?php echo $sending_currency; ?></p>
                                                                </li>
                                                            <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <!-- Ad Reeiving Div -->
                                    </div>
                                    <div class="row" id="receiving_wise_div" style="display: none;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h1>Receving Country Wise</h1>
                                                <?php
                                                $receiving_banners =  mysqli_query($link, "SELECT * FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '2' AND `image` IS NOT NULL");
                                                $receiving_image = '';
                                                $receiving_count_curr_id = '';
                                                foreach ($receiving_banners as $receiving_banner) {
                                                    $receiving_image = $receiving_banner['image'];
                                                    $receiving_count_curr_id = $receiving_banner['count_curr_id'];
                                                }
                                                $receiving_currencies_rates =  mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$receiving_count_curr_id' AND `preferrence`='1'");
                                                if (!empty($receiving_image) && mysqli_num_rows($receiving_currencies_rates) > 0) {
                                                ?>
                                                    <span class="download_icon receiving_download"><i class="fa fa-download" aria-hidden="true"></i></span>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
                                                <?php
                                                if (!empty($receiving_image) && mysqli_num_rows($receiving_currencies_rates) > 0) {
                                                    $receiving_currencies_rates_counts =  mysqli_num_rows($receiving_currencies_rates);
                                                    $banner_types =  mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE  `id` = '2'"));
                                                    $banner_path = $banner_types['name'];
                                                ?>
                                                    <div id="receiving_content" class="list-content" style="background-image: url(images/<?php echo $banner_path; ?>/<?php echo $receiving_image; ?>);background-repeat: no-repeat;background-size: contain">

                                                        <div class="row list-content">
                                                            <ul>
                                                                <?php
                                                                foreach ($receiving_currencies_rates as $index => $receiving_currencies_rate) {
                                                                    $rate_id = $receiving_currencies_rate['id'];
                                                                    $currency_id = $receiving_currencies_rate['currency_id'];
                                                                    $rate = $receiving_currencies_rate['rate'];
                                                                    $countries =  mysqli_fetch_array(mysqli_query($link, "SELECT `currency`,`name` FROM `countries` WHERE id = '$currency_id'"));
                                                                    $currency = $countries['currency'];
                                                                    $name = strtolower($countries['name']);
                                                                    $name = str_replace(" ", "-", $name);


                                                                    $received_countries =  mysqli_fetch_array(mysqli_query($link, "SELECT `currency` FROM `countries` WHERE id = '$country_id'"));
                                                                    $received_currency = $received_countries['currency'];
                                                                ?>
                                                                    <li class="<?php if (mysqli_num_rows($receiving_currencies_rates) == 9) {
                                                                                    echo "nine";
                                                                                } elseif (mysqli_num_rows($receiving_currencies_rates) == 8) {
                                                                                    echo "eight1";
                                                                                }
                                                                                ?>">
                                                                        <p class="c-short"><span style="color: #ec7220;">1 </span><?php echo $currency; ?> =</p>
                                                                        <input type="text" class="rate-input" readonly value="<?php echo $rate; ?>">
                                                                        <p class="c-short"><?php echo $received_currency; ?></p>
                                                                    </li>
                                                                <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <!-- Ad Reeiving Div -->
                                    </div>

                                    <div class="row" id="individuals_div" style="display: none;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                            <h1>Individual Country Wise</h1>
                                            <?php
                                            $individual_query = "SELECT * FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '3'";
                                            $individual_image_validate = " AND `image` IS NOT NULL";
                                            $individual_banners =  $link->query($individual_query . $individual_image_validate);
                                            if (mysqli_num_rows($individual_banners) > 0) {
                                            ?>
                                                <button class="download_icon individual_download"><i class="fa fa-download" aria-hidden="true"></i></button>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: space-around;">
                                                <style>
                                                    #individual_content {
                                                        width: 700px;
                                                        height: 700px;
                                                        color: black;
                                                    }

                                                    .guinea-rate-fill {
                                                        font-size: 40px;
                                                        font-weight: 700;
                                                        margin-top: 48.1%;
                                                        margin-left: 150px;
                                                    }

                                                    .guinea-mains {
                                                        display: flex;
                                                        justify-content: space-between;
                                                        padding: 0px 130px;
                                                        margin-top: 1.1%;
                                                        padding-right: 493px;

                                                    }

                                                    .guinea-mains img {
                                                        width: 105px;

                                                    }

                                                    .individual_content_download {
                                                        width: 1080px;
                                                        height: 1080px;
                                                        color: black;
                                                    }
                                                </style>
                                                <?php
                                                if (mysqli_num_rows($individual_banners) > 0) {
                                                    $individual_image = '';
                                                    $individual_extention = '';
                                                    $individual_banners_specific =  $link->query($individual_query . " AND `sub_type` ='2'" . $individual_image_validate);
                                                    $count = 0;

                                                    if (mysqli_num_rows($individual_banners_specific) > 0) {
                                                        foreach ($individual_banners_specific as $individual_banner_specific) {
                                                            $individual_image = $individual_banner_specific['image'];
                                                            if (str_contains("$individual_image", '-')) {
                                                                $individual_image = explode('-', $individual_image);
                                                                $individual_extention = explode('.', $individual_image[1]);
                                                            } elseif (str_contains("$individual_image", '.')) {
                                                                $individual_image = explode('.', $individual_image);
                                                            }
                                                            //For Currency Data Start
                                                            $countries =  mysqli_fetch_array(mysqli_query($link, "SELECT `id`,`currency`,`name`,`iso` FROM `countries` WHERE `iso3` = '$individual_image[0]'"));

                                                            $cur_id = $countries['id'];
                                                            $individual_currency = $countries['currency'];
                                                            $name = strtolower($countries['name']);
                                                            $name = str_replace(" ", "-", $name);
                                                            $individual_iso = strtolower($countries['iso']);
                                                            //For Currency Data End
                                                            $sending_currencies_rates =  mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$cc_id' AND `currency_id`='$cur_id' AND preferrence='1'");

                                                            foreach ($sending_currencies_rates as $index => $currencies_rate) {
                                                                $rate_id = $currencies_rate['id'];
                                                                $rate = $currencies_rate['rate'];
                                                                individual_html($link, $individual_image, $currency_code, $rate, $individual_currency, $iso, $individual_iso, $countries, $individual_extention, $count);
                                                            }
                                                            $count++;
                                                        }
                                                    } else {
                                                        $individual_banners =  mysqli_query($link, "SELECT * FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '3' AND `sub_type` = '1'  AND `image` IS NOT NULL");
                                                        foreach ($individual_banners as $individual_banner) {
                                                            $individual_image = $individual_banner['image'];
                                                        }
                                                        if (str_contains("$individual_image", '-')) {
                                                            $individual_image = explode('-', $individual_image);
                                                            $individual_extention = explode('.', $individual_image[1]);
                                                        }
                                                        $sendgin_currencies_rates =  mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$cc_id' AND preferrence='1'");
                                                        $sendgin_currencies_rates_counts =  mysqli_num_rows($sendgin_currencies_rates);
                                                        foreach ($sendgin_currencies_rates as $index => $currencies_rate) {
                                                            $rate_id = $currencies_rate['id'];
                                                            $currency_id = $currencies_rate['currency_id'];
                                                            $rate = $currencies_rate['rate'];
                                                            $countries =  mysqli_fetch_array(mysqli_query($link, "SELECT `currency`,`name`,`iso` FROM `countries` WHERE `id` = '$currency_id'"));
                                                            $individual_currency = $countries['currency'];
                                                            $name = strtolower($countries['name']);
                                                            $name = str_replace(" ", "-", $name);
                                                            $individual_iso = strtolower($countries['iso']);
                                                            individual_html($link, $individual_image, $currency_code, $rate, $individual_currency, $iso, $individual_iso, $countries, $individual_extention, $count);

                                                            $count++;
                                                ?>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        var sending_content = document.getElementById('sending_content');
                                        var receiving_content = document.getElementById('receiving_content');
                                        var country = '<?= $country_name; ?>';
                                        var currency = '<?= $currency_code; ?>';
                                        console.log(currency);
                                        console.log(country);
                                        $(document).ready(function() {
                                            $('.preferred_country_tab').click(function() {
                                                $("#preferred_country_div").show();
                                                $(".preferred_country_tab").addClass('active');
                                                $("#country_wise_div").hide();
                                                $(".country_wise_tab").removeClass('active');
                                                $("#receiving_wise_div").hide();
                                                $(".receiving_wise_tab").removeClass('active');
                                                $("#individuals_div").hide();
                                                $(".individuals_tab").removeClass('active');
                                            });
                                            $('.country_wise_tab').click(function() {
                                                $("#preferred_country_div").hide();
                                                $(".preferred_country_tab").removeClass('active');
                                                $("#country_wise_div").show();
                                                $(".country_wise_tab").addClass('active');
                                                $("#receiving_wise_div").hide();
                                                $(".receiving_wise_tab").removeClass('active');
                                                $("#individuals_div").hide();
                                                $(".individuals_tab").removeClass('active');
                                            });
                                            $('.receiving_wise_tab').click(function() {
                                                $("#preferred_country_div").hide();
                                                $(".preferred_country_tab").removeClass('active');
                                                $("#country_wise_div").hide();
                                                $(".country_wise_tab").removeClass('active');
                                                $("#receiving_wise_div").show();
                                                $(".receiving_wise_tab").addClass('active');
                                                $("#individuals_div").hide();
                                                $(".individuals_tab").removeClass('active');
                                            });
                                            $('.individuals_tab').click(function() {
                                                $("#preferred_country_div").hide();
                                                $(".preferred_country_tab").removeClass('active');
                                                $("#country_wise_div").hide();
                                                $(".country_wise_tab").removeClass('active');
                                                $("#receiving_wise_div").hide();
                                                $(".receiving_wise_tab").removeClass('active');
                                                $("#individuals_div").show();
                                                $(".individuals_tab").addClass('active');
                                            });
                                            var numberOfChecked = $('input:checkbox:checked').length;
                                            $('.updated_counts').text(numberOfChecked);
                                            $('input:checkbox').click(function() {
                                                var numberOfChecked = $('input:checkbox:checked').length;
                                                $('.updated_counts').text(numberOfChecked);
                                            });
                                            $('.individual_download').click(function() {
                                                var images = document.querySelectorAll(".individual_content_download");
                                                var folderPath = '<?php echo $folderPath; ?>' + country;
                                                var $button = $(this);
                                                $button.button('loading');

                                                $.ajax({
                                                    url: 'create_folder.php',
                                                    type: 'POST',
                                                    data: {
                                                        folderPath: folderPath
                                                    },
                                                    success: function(response) {
                                                        for (let i = 0; i < images.length; i++) {
                                                            console.log(images[i]);
                                                            domtoimage.toBlob(images[i])
                                                                .then(function(blob) {
                                                                    var fileName = $('#currency_code_' + i).val();
                                                                    var formData = new FormData();
                                                                    formData.append('file', blob, fileName + '.jpg');
                                                                    formData.append('folderPath', folderPath);
                                                                    $.ajax({
                                                                        url: 'upload_image.php',
                                                                        type: 'POST',
                                                                        data: formData,
                                                                        processData: false,
                                                                        contentType: false,
                                                                        success: function(uploadResponse) {
                                                                            console.log(uploadResponse);
                                                                            $('#success_message').show()
                                                                                .addClass("alert alert-success")
                                                                                .text('Banner Successfully Downloaded!')
                                                                                .delay(5000)
                                                                                .fadeOut('slow', function() {
                                                                                    $(this).hide();
                                                                                });
                                                                            $button.button('reset');
                                                                        },
                                                                        error: function(xhr, status, error) {
                                                                            console.log('Error uploading image:', error);
                                                                        }
                                                                    });
                                                                });
                                                        }
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.log('Error creating folder:', error);
                                                    }
                                                });
                                            });
                                            $('.sending_download').click(function() {
                                                var folderPath = '<?php echo $folderPath; ?>' + country;
                                                var $button = $(this);
                                                $button.button('loading');
                                                $.ajax({
                                                    url: 'create_folder.php',
                                                    type: 'POST',
                                                    data: {
                                                        folderPath: folderPath
                                                    },
                                                    success: function(response) {
                                                        domtoimage.toBlob(sending_content)
                                                            .then(function(blob) {
                                                                var formData = new FormData();
                                                                formData.append('file', blob, currency + '.jpg');
                                                                formData.append('folderPath', folderPath);
                                                                $.ajax({
                                                                    url: 'upload_image.php',
                                                                    type: 'POST',
                                                                    data: formData,
                                                                    processData: false,
                                                                    contentType: false,
                                                                    success: function(uploadResponse) {
                                                                        console.log(uploadResponse);
                                                                        $('#success_message').show()
                                                                            .addClass("alert alert-success")
                                                                            .text('Successfully downloaded')
                                                                            .delay(5000)
                                                                            .fadeOut('slow', function() {
                                                                                $(this).hide();
                                                                            });
                                                                        $button.button('reset');
                                                                    },
                                                                    error: function(xhr, status, error) {
                                                                        console.log('Error uploading image:', error);
                                                                    }
                                                                });
                                                            });
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.log('Error creating folder:', error);
                                                    }
                                                });
                                            });
                                            $('.receiving_download').click(function() {
                                                var folderPath = '<?php echo $folderPath; ?>' + country;
                                                var $button = $(this);
                                                $button.button('loading');
                                                $.ajax({
                                                    url: 'create_folder.php',
                                                    type: 'POST',
                                                    data: {
                                                        folderPath: folderPath
                                                    },
                                                    success: function(response) {
                                                        domtoimage.toBlob(receiving_content)
                                                            .then(function(blob) {
                                                                var formData = new FormData();
                                                                formData.append('file', blob, currency + '.jpg');
                                                                formData.append('folderPath', folderPath);
                                                                $.ajax({
                                                                    url: 'upload_image.php',
                                                                    type: 'POST',
                                                                    data: formData,
                                                                    processData: false,
                                                                    contentType: false,
                                                                    success: function(uploadResponse) {
                                                                        console.log(uploadResponse);
                                                                        $('#success_message').show()
                                                                            .addClass("alert alert-success")
                                                                            .text('Successfully downloaded')
                                                                            .delay(5000)
                                                                            .fadeOut('slow', function() {
                                                                                $(this).hide();
                                                                            });
                                                                        $button.button('reset');

                                                                    },
                                                                    error: function(xhr, status, error) {
                                                                        console.log('Error uploading image:', error);
                                                                    }
                                                                });
                                                            });
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.log('Error creating folder:', error);
                                                    }
                                                });
                                            });
                                        });
                                    </script>
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
    <script>
        $(document).ready(function() {
            window.setTimeout(function() {
                $(".alert").fadeTo(1800, 0).slideUp(800, function() {
                    $(this).remove();
                });
            }, 2000);
        });
    </script>