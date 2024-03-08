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
<?php include('countries_backend.php');

?>
<style>
    .list-contentone {
        position: absolute;
        top: 0px;
        right: 10px;
        /* right: 0px; */
        height: 100%;
        display: table;
        padding: 0px;
        display: flex;
        align-items: center;
   }
   .list-contenttwo {
        position: absolute;
        top: 0px;
        right: 10px;
        /* right: 0px; */
        height: 100%;
        display: table;
        padding: 0px;
        display: flex;
        align-items: center;
   }
    .list-contentthree {
        position: absolute;
        top: 0px;
        right: 10px;
        /* right: 0px; */
        height: 100%;
        display: table;
        padding: 0px;
        display: flex;
        align-items: center;
   }
   input:focus {
        outline: none;
    }
   .download_icon {
        color: #f4901b;
        font-size: 25px;
        cursor: pointer;
    }
   .nav-tabs a:hover {
        color: #f4901b;
    }
   #receiving_content_teneighty {
        position: relative;
        width: 1080px;
        height: 1080px;
        color: #fff;
   }
   #receiving_content_teneighty ul {
        position: relative;
        list-style-type: none;
        text-align: center;
    }
   #receiving_content_teneighty ul li {
       /* padding: 10px 0px 10px 30px;
        display: flex;
        flex-direction: row;
        justify-content: center; */
           padding: 10px 27px 10px 30px;
            display: flex;
            flex-direction: row;
            justify-content: right;
    }
   #receiving_content_teneighty ul li img {
        width: 54px;
    }
   #receiving_content_thirteenfifty {
        position: relative;
        width: 1080px !important;
        height: 1350px;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    }
   #receiving_content_thirteenfifty ul {
        width: 100%;
        list-style-type: none;
        padding: 0;
        text-align: center;
    }
   #receiving_content_thirteenfifty ul li img {
        width: 54px;
    }
   #receiving_content_thirteenfifty ul li {
           display: flex;
            flex-direction: row;
            justify-content: right;
            padding: 16px 44px;
   }
   #receiving_content_thirteenfifty .rate-input {
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
   #receiving_content_thirteenfifty .c-short {
       font-size: 26px;
        color: #000;
        font-weight: 900;
        margin-top: 6px;
    }
   #receiving_content_sixthirty {
       position: relative;
        width: 1200px;
        height: 630px;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
   }
   #receiving_content_sixthirty ul {
        list-style-type: none;
        display: flex;
        flex-wrap: wrap;
        padding: 0;
        margin: 0;
    }
   #receiving_content_sixthirty ul li img {
        width: 54px;
    }
   #receiving_content_sixthirty ul li {
       display: flex;
        flex-wrap: wrap;
        width: 50%;
        padding: 20px 0px;
        text-align: center;
        margin: 0;
    }
   #receiving_content_sixthirty .rate-input {
        font-family: sans-serif;
        width: 36%;
        text-align: center;
        margin: 0 9px;
        font-weight: 900;
        font-size: 19px;
        border: 1px solid #d1cac3;
        border-radius: 5px;
        color: black;
    }
   #receiving_content_sixthirty .c-short {
       font-size: 19px;
        color: #000;
        font-weight: 900;
        margin-top: 6px;
    }
   .nine {
        margin: 0px 53px 39px 0 !important;
    }
   .eight1 {
        margin: 0px 53px 48px 0 !important;
    }
   #receiving_content_teneighty .rate-input {
        font-family: sans-serif;
        width: 48%;
        text-align: center;
        margin: 0 9px;
        font-weight: 900;
        font-size: 26px;
        border: 1px solid #d1cac3;
        border-radius: 5px;
        color: black;
    }
   #receiving_content_teneighty .c-short {
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
   .eight-h {
        padding-left: 645px !important;
   }
 
</style>
<?php
$folderPath = "images/downloads/";

if (isset($_GET['id'])) {
    $get_id = $_GET['id'];
   $country_id = $_GET['country_id'];
   $countries =  mysqli_query($link, "SELECT `cc`.`id` AS `cc_id`,`ct`.`id` AS `ct_id`,`ct`.`name` AS `name`,`ct`.`currency` AS `currency`,`ct`.`iso` AS `iso`,`cc`.`country_id` AS `country_id` FROM `countries` AS `ct` INNER JOIN `countries_currencies` AS `cc`  ON `ct`.`id`=`cc`.`country_id` WHERE `cc`.`country_id`='$country_id'");
   // echo "SELECT `cc`.`id` AS `cc_id`,`ct`.`id` AS `ct_id`,`ct`.`name` AS `name`,`ct`.`currency` AS `currency`,`ct`.`iso` AS `iso`,`cc`.`country_id` AS `country_id` FROM `countries` AS `ct` INNER JOIN `countries_currencies` AS `cc`  ON `ct`.`id`=`cc`.`country_id` WHERE `cc`.`country_id`='$country_id'";
    // exit;
   foreach ($countries as $country) {
       $cc_id = $country['cc_id'];
        $country_id = $country['country_id'];
        $country_name = $country['name'];
        $iso = $country['iso'];
        $currency_code = $country['currency'];
        // $sending_iso3_code = $country['currency'];
        $currencies_rates =  mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$cc_id'");
        // echo "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$cc_id'";
       $currencies_rates_counts =  mysqli_num_rows($currencies_rates);
    }
}


$banner_id = '';
if (isset($_POST["bannertype"])) {
    echo $bannertypeID = $_POST["bannertype"];
   echo "<script>  console.log('Banner Type ID:', $bannertypeID); window.location.href = '" . basename($_SERVER['PHP_SELF']) . "?id=$get_id&country_id=$country_id&banner_id=$bannertypeID'; </script>";
}

if (isset($_GET['banner_id'])) {
    $banner_id = $_GET['banner_id'];
    // echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$get_id&country_id=$country_id&banner_id=$bannertypeID'</script>");
}
else
{
    $banner_id = 2;
}

?>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <?php include('inc_nav.php'); ?>
            </div>
            <?php include('inc_header.php'); ?>
            <!-- breadcrumb -->
            <div class="breadcrumb_content">
                <div class="breadcrumb_text"><a href="dashboard.php">Dashboardsssssssss</a> / <?php echo $plu_del_rep; ?>
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
                                        <li><a href="<?php echo basename($_SERVER['REQUEST_URI']) ?>" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Page Refresh"><i class="fa fa-refresh"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- added by umair naveed -->
                                <div class="container">
                                    <div class="page-header">
                                        <h1>Receiving Country</h1>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading panel-heading-nav">
                                            <ul class="nav nav-tabs">
                                                <!-- <li role="presentation" class="active">
                                                    <a href="#one" aria-controls="one" role="tab" data-toggle="tab">Prefrred Country</a>
                                                </li> -->
                                                <li role="presentation">
                                                    <a href="#two" aria-controls="two" role="tab" data-toggle="tab">
                                                        Country Wise</a>
                                                </li>
                                                <!-- <li role="presentation">
                                                    <a href="#three" aria-controls="three" role="tab" data-toggle="tab">Individual Country</a>
                                                </li> -->
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <!-- <div role="tabpanel" class="tab-pane fade in active" id="one">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="card-body">
                                                                Prefrred Country
                                                            </div>
                                                        </div>
                                                   </div>
                                                </div> -->
                                                <div role="tabpanel" class="tab-pane fade" id="two">
                                                   <div class="panel-header">
                                                        <div class="panel-body">
                                                            <?php
                                                           $bannerdropdown = mysqli_query($link, "SELECT `id`, `name`, `sizes`, `status`, `created_at`, `updated_at` 
                                                                        FROM `banner_types`   WHERE `id` IN (2,6,8) ");
                                                            if ($bannerdropdown->num_rows > 0) {
                                                                $bannerTypes = $bannerdropdown->fetch_all(MYSQLI_ASSOC);
                                                            } else {
                                                                $bannerTypes = array();
                                                            }
                                                            ?>
                                                           <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $get_id; ?>&country_id=<?php echo $country_id; ?>">
                                                               <select id="bannerType" name="bannertype" class="form-control" style="width: 50%;" onchange="this.form.submit()">
                                                                   <?php foreach ($bannerTypes as $bannerType) : ?>
                                                                       <option style="text-align: center;" value="<?php echo $bannerType['id']; ?>" <?php echo ($banner_id == $bannerType['id']) ? 'selected' : ''; ?>>
                                                                            <?php echo $bannerType['name']; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </form>
                                                           <div class="mainsec">
                                                                <div class="x_content">
                                                                    <script src="vendors/dom/dom-to-image.js"></script>
                                                                    <script src="vendors/file_server/file-server.js"></script>
                                                                    <div class="row" id="receiving_wise_div" style="display: block;">
                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                <h1>Receiving Country Wise</h1>
                                                                            </div>
                                                                            <?php
                                                                            //  $cc_id = isset($_GET['cc_id']) ? $_GET['cc_id'] : '';
                                                                           //rate query
                                                                            // added by umairnaveed
                                                    $countries = mysqli_query($link, "SELECT ccr.*, c.currency, ccr.sending_iso_code
                                                        FROM   countries_currencies_rates AS ccr
                                                        INNER JOIN countries_currencies AS cc ON ccr.count_curr_id = cc.id
                                                        INNER JOIN countries AS c ON cc.country_id = c.id
                                                        INNER JOIN (
                                                            SELECT sending_iso_code, MAX(rate) AS max_rate
                                                            FROM countries_currencies_rates
                                                            WHERE currency_id = '$country_id' AND status = '1'
                                                            GROUP BY sending_iso_code
                                                        ) AS max_rates ON ccr.sending_iso_code = max_rates.sending_iso_code AND ccr.rate = max_rates.max_rate
                                                        WHERE ccr.currency_id = '$country_id' AND ccr.status = '1'");

                                                        
                                                                      //added by ahsaam
                                                                            //    echo "SELECT ccr.*, c.currency, ccr.sending_iso_code 
                                                                            //    FROM countries_currencies_rates  AS ccr 
                                                                            //                                    INNER JOIN countries_currencies 
                                                                            //                                    AS cc ON ccr.count_curr_id = cc.id
                                                                            //                                    INNER JOIN countries AS c ON cc.country_id = c.id 
                                                                            //                                    WHERE ccr.currency_id = '$country_id'
                                                                            //                                     AND ccr.status = '1'
                                                                            //                                      GROUP BY ccr.`sending_iso_code`";
                                                                           // banner and image and path
                                                                            $receiving_banners = mysqli_query($link, "SELECT b.`id` as `banner_id`, b.`image`, bt.`id` as `bannertype_id`, bt.`name` as `name` ,  b.`count_curr_id` as `count_curr_id`
                                                                         FROM `banners` b
                                                                         LEFT JOIN `banner_types` as bt ON b.`type` = bt.`id`
                                                                        WHERE b.`type` = '$banner_id' AND b.`image` IS NOT NULL AND  b.`count_curr_id` = '$get_id' ");
                                                                           foreach ($receiving_banners as $receiving_banner) {
                                                                                $receiving_image = $receiving_banner['image'];
                                                                                $receiving_count_curr_id = $receiving_banner['count_curr_id'];
                                                                                $banner_path = $receiving_banner['name'];
                                                                                $ban_id = $receiving_banner['bannertype_id'];
                                                                               $receiving_currencies_rates =  mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$receiving_count_curr_id' AND `preferrence`=1");
                                                                           ?>
                                                                               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
                                                                                   <?php
                                                                                    if ($ban_id == 2) {
                                                                                        //if (!empty($receiving_image) && mysqli_num_rows($receiving_currencies_rates) > 0) {
                                                                                    ?>
                                                                                        <button class="download_icon receiving_download"><i class="fa fa-download" aria-hidden="true"></i></button>
                                                                                        <?php
                                                                                        // }
                                                                                        ?>
                                                                                       <div id="receiving_content_teneighty" class="list-content" style="background-image: url(images/<?php echo $banner_path; ?>/<?php echo $receiving_image; ?>);background-repeat: no-repeat;background-size: contain">
                                                                                            <div class="list-contentone">
                                                                                                <ul>
                                                                                                    <?php
                                                                                                   $conter = 0;
                                                                                                    foreach ($countries  as $countries_rate) {
                                                                                                        $currency = $countries_rate['currency'];
                                                                                                        $rate = $countries_rate['rate'];
                                                                                                        $currency_new = $countries_rate['receiving_iso_code'];
                                                                                                        $conter++;
                                                                                                       $received_countries =  mysqli_fetch_array(mysqli_query($link, "SELECT `currency` FROM `countries` WHERE id = '$country_id'"));
                                                                                                        $received_currency = $received_countries['currency'];
                                                                                                    ?>
                                                                                                        <li class="<?php if (mysqli_num_rows($countries) == 9) {
                                                                                                                        echo "nine";
                                                                                                                    } elseif (mysqli_num_rows($countries) == 8) {
                                                                                                                        echo "eight1";
                                                                                                                    }
                                                                                                                    ?>">
                                                                                                            <p class="c-short"><span style="color: #000;">1 </span><?php echo $currency; ?> =</p>
                                                                                                            <input type="text" class="rate-input" readonly value="<?php echo $rate; ?>">
                                                                                                            <!-- <p class="c-short"><?php //echo $received_currency; 
                                                                                                                                    ?></p> -->
                                                                                                            <p class="c-short"><?php echo $currency_new; ?></p>
                                                                                                        </li>
                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                        // }
                                                                                        ?>
                                                                                    <?php
                                                                                    } else if ($ban_id == 6) {
                                                                                        // if (!empty($receiving_image) && mysqli_num_rows($receiving_currencies_rates) > 0) {
                                                                                    ?>
                                                                                        <button class="download_icon receiving_download_six"><i class="fa fa-download" aria-hidden="true"></i></button>
                                                                                        <?php
                                                                                        //  }
                                                                                        ?>
                                                                                       <div id="receiving_content_thirteenfifty" class="list-content" style="background-image: url(images/<?php echo $banner_path; ?>/<?php echo $receiving_image; ?>);background-repeat: no-repeat;background-size: contain">
                                                                                            <div class="list-contenttwo">
                                                                                                <ul>
                                                                                                    <?php
                                                                                                   $conter = 0;
                                                                                                    foreach ($countries  as $countries_rate) {
                                                                                                        $currency = $countries_rate['currency'];
                                                                                                        $rate = $countries_rate['rate'];
                                                                                                        $currency_new = $countries_rate['receiving_iso_code'];
                                                                                                        $conter++;
                                                                                                       $received_countries =  mysqli_fetch_array(mysqli_query($link, "SELECT `currency` FROM `countries` WHERE id = '$country_id'"));
                                                                                                        $received_currency = $received_countries['currency'];
                                                                                                    ?>
                                                                                                        <li class="<?php if (mysqli_num_rows($countries) == 9) {
                                                                                                                        echo "nine";
                                                                                                                    } elseif (mysqli_num_rows($countries) == 8) {
                                                                                                                        echo "eight1";
                                                                                                                    }
                                                                                                                    ?>">
                                                                                                            <p class="c-short"><span style="color: #000;">1 </span><?php echo $currency; ?> =</p>
                                                                                                            <input type="text" class="rate-input" readonly value="<?php echo $rate; ?>">
                                                                                                            <!-- <p class="c-short"><?php //echo $received_currency; 
                                                                                                                                    ?></p> -->
                                                                                                            <p class="c-short"><?php echo $currency_new; ?></p>
                                                                                                        </li>
                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                        // }
                                                                                        ?>
                                                                                   <?php } else if ($ban_id == 8) {
                                                                                        // if (!empty($receiving_image) && mysqli_num_rows($receiving_currencies_rates) > 0) {
                                                                                    ?>
                                                                                        <button class="download_icon receiving_download_eight"><i class="fa fa-download" aria-hidden="true"></i></button>
                                                                                        <?php
                                                                                        //  }
                                                                                        ?>
                                                                                       <div id="receiving_content_sixthirty" class="list-content" style="background-image: url(images/<?php echo $banner_path; ?>/<?php echo $receiving_image; ?>);background-repeat: no-repeat;background-size: contain">
                                                                                            <div class="list-contentthree">
                                                                                                <ul class="eight-h">
                                                                                                    <?php
                                                                                                   $conter = 0;
                                                                                                    foreach ($countries  as $countries_rate) {
                                                                                                        $currency = $countries_rate['currency'];
                                                                                                        $rate = $countries_rate['rate'];
                                                                                                        $currency_new = $countries_rate['receiving_iso_code'];
                                                                                                        $conter++;
                                                                                                       $received_countries =  mysqli_fetch_array(mysqli_query($link, "SELECT `currency` FROM `countries` WHERE id = '$country_id'"));
                                                                                                        $received_currency = $received_countries['currency'];
                                                                                                    ?>
                                                                                                        <li class="<?php if (mysqli_num_rows($countries) == 9) {
                                                                                                                        echo "nine";
                                                                                                                    } elseif (mysqli_num_rows($countries) == 8) {
                                                                                                                        echo "eight1";
                                                                                                                    }
                                                                                                                    ?>">
                                                                                                            <p class="c-short"><span style="color: #000;">1 </span><?php echo $currency; ?> =</p>
                                                                                                            <input type="text" class="rate-input" readonly value="<?php echo $rate; ?>">
                                                                                                            <!-- <p class="c-short"><?php //echo $received_currency; 
                                                                                                                                    ?></p> -->
                                                                                                            <p class="c-short"><?php echo $currency_new; ?></p>
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
                                                                            <?php } ?>
                                                                        </div>
                                                                        <!-- Ad Reeiving Div -->
                                                                    </div>
                                                                    <script>
                                                                        var country = '<?= $country_name; ?>';
                                                                        var currency = '<?= $currency_code; ?>';
                                                                        var receiving_content = document.getElementById('receiving_content_teneighty');
                                                                        var receiving_content_six = document.getElementById('receiving_content_thirteenfifty');
                                                                        var receiving_content_eight = document.getElementById('receiving_content_sixthirty');
                                                                       console.log(currency);
                                                                        console.log(country);
                                                                        $(document).ready(function() {
                                                                            var numberOfChecked = $('input:checkbox:checked').length;
                                                                            $('.updated_counts').text(numberOfChecked);
                                                                            $('input:checkbox').click(function() {
                                                                                var numberOfChecked = $('input:checkbox:checked').length;
                                                                                $('.updated_counts').text(numberOfChecked);
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
                                                                                                var randomNum = Math.floor(Math.random() * 100000);
                                                                                                formData.append('file', blob, currency + '_' + randomNum + '.jpg');
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
                                                                       $(document).ready(function() {
                                                                            var numberOfChecked = $('input:checkbox:checked').length;
                                                                            $('.updated_counts').text(numberOfChecked);
                                                                            $('input:checkbox').click(function() {
                                                                                var numberOfChecked = $('input:checkbox:checked').length;
                                                                                $('.updated_counts').text(numberOfChecked);
                                                                            });
                                                                            $('.receiving_download_six').click(function() {
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
                                                                                        domtoimage.toBlob(receiving_content_six)
                                                                                            .then(function(blob) {
                                                                                                var formData = new FormData();
                                                                                                var randomNumSix = Math.floor(Math.random() * 100000);
                                                                                                formData.append('file', blob, currency + '_' + randomNumSix + '.jpg');
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
                                                                       $(document).ready(function() {
                                                                            var numberOfChecked = $('input:checkbox:checked').length;
                                                                            $('.updated_counts').text(numberOfChecked);
                                                                            $('input:checkbox').click(function() {
                                                                                var numberOfChecked = $('input:checkbox:checked').length;
                                                                                $('.updated_counts').text(numberOfChecked);
                                                                            });
                                                                            $('.receiving_download_eight').click(function() {
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
                                                                                        domtoimage.toBlob(receiving_content_eight)
                                                                                            .then(function(blob) {
                                                                                                var formData = new FormData();
                                                                                                var randomNumEight = Math.floor(Math.random() * 100000);
                                                                                                formData.append('file', blob, currency + '_' + randomNumEight + '.jpg');
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
                                                <!-- <div role="tabpanel" class="tab-pane fade" id="three">
                                                    <form>
                                                        <div class="panel-header">
                                                            <div class="panel-body">
                                                                Individual Country
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div> -->
                                            </div>
                                        </div>
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
    <script>
        $(document).ready(function() {
            window.setTimeout(function() {
                $(".alert").fadeTo(1800, 0).slideUp(800, function() {
                    $(this).remove();
                });
            }, 2000);
        });
       /////// added by umair naveed
        $(function() {
           $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                localStorage.setItem('lastTab', $(this).attr('href'));
            });
            var lastTab = localStorage.getItem('lastTab');
           if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
       });
    </script>