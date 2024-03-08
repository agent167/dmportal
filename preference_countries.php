<?php include('inc_meta_header.php'); ?>

<style>
    .select2-container {
        width: 100% !important;
    }
</style>


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

    $all_countries_results = mysqli_query($link, "SELECT `name` , `id` FROM `countries`");
    $all_countries = array();
    while ($row = mysqli_fetch_assoc($all_countries_results)) {
        $all_countries[] = $row;
    }

    $sending_prefered_countries_result = mysqli_query($link, "SELECT * FROM `sending_prefered_countries`   where `sending_country_id` = '$get_id'");
    $prefered_countries = array();
    while ($row = mysqli_fetch_assoc($sending_prefered_countries_result)) {
        $prefered_countries[] = $row;
    }
    $singleArray = [];
    foreach ($prefered_countries as $subArray) {
        $singleArray[] = $subArray;
    }
    $prefered_countries = $singleArray;
}
if (isset($_POST['submit'])) {
    $get_id = $_GET['id'];
    $prefered_countries_result = mysqli_query($link, "SELECT spc.* , c.iso3, c.name FROM `sending_prefered_countries` as spc inner join countries as c on spc.prefered_country_id = c.id where `sending_country_id` =  '$get_id'");

    $prefered_countries2 = array();
    while ($row = mysqli_fetch_assoc($prefered_countries_result)) {
        $prefered_countries2[] = $row;
    }

    $sending_country = mysqli_query($link, "SELECT cc.* , c.iso3 FROM `countries_currencies` as cc INNER join countries as c on cc.country_id = c.id WHERE cc.id =  '$get_id'");

    $send_country_result = mysqli_fetch_assoc($sending_country);

    rates_history($link, $get_id);
    foreach ($prefered_countries2 as $prefred_countries) {
        $exchangeRates = 0.00;
        // URL to send the POST request to
        $url = 'https://api.remitchoice.net/api/utils/publicexchangerate';
        // Form data to be sent in the POST request
        $data = ['SendingCountryIso3Code' => $send_country_result['iso3'], 'ReceivingCountryIso3Code' => $prefred_countries['iso3'],];
        // Initialize cURL session
        $curl = curl_init($url);
        // Set cURL options
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Execute cURL session and get the response
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            echo 'cURL Error: ' . curl_error($curl);
        } else {
            $response = json_decode($response, true);
            if($response['result']['Code'] ==102 || $response['result']['Rflag']== 0 ){
                echo ( "<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$get_id&country_id=$country_id&failes={$prefred_countries['name']}'</script>");
            }else{
               
                $exchangeRates = max(array_column($response['data'], 'ExchangeRate'));
                $receiving_iso_code = $response['data'][0]['RecievingCurrencyyISOCode'];
                $sending_iso_code = $response['data'][0]['SendingCurrencyISOCode'];
          
                $currency_id = $prefred_countries['prefered_country_id'];

                // echo "INSERT INTO `countries_currencies_rates`(`count_curr_id`, `currency_id`, `rate`, `receiving_iso_code`,`sending_iso_code`,`status`,  `created_at`) VALUES ('$get_id','$currency_id','$exchangeRates', '$receiving_iso_code', '$sending_iso_code',1',NOW())";
                // exit;


                 mysqli_query($link, "INSERT INTO currencies_rates_history SELECT * FROM countries_currencies_rates WHERE `count_curr_id`='$currency_id'");
    
                    mysqli_query($link, "DELETE FROM `countries_currencies_rates` WHERE `count_curr_id`='$currency_id'");

                mysqli_query($link, "INSERT INTO `countries_currencies_rates`(`count_curr_id`, `currency_id`, `rate`, `receiving_iso_code`,`sending_iso_code`,`status`,  `created_at`) VALUES ('$get_id','$currency_id','$exchangeRates', '$receiving_iso_code', '$sending_iso_code','1',NOW())");


        

            }  
        }
        curl_close($curl);
    }
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$get_id&country_id=$country_id&success=y'</script>");
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
                                            <div class='container'><strong>Rates Successfully Imported.</strong></div>
                                        </div>
                                    <?php }
                                    if (isset($_GET['failes'])) { ?>
                                        <div class='alert alert-danger'>
                                            <div class='container'><strong><?= $_GET['failes']; ?> Country not Exist</strong></div>
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



                                                <!-- Include Select2 CSS -->

                                                <div class="row sml-padding" id="upload_file_1">
                                                    <div class="conatnt_alignment">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

                                                            <label class="control-label" for="">Country<span class="text-danger">*</span></label>
                                                            <select class="js-example-basic-multiple " name="selected_prefred_countries[]" multiple="multiple">
                                                                <?php

                                                                foreach ($all_countries as $countreis) {
                                                                    $c_id = $countreis['id'];
                                                                    $c_name = $countreis['name'];
                                                                ?>
                                                                    <option value="<?php echo $c_id; ?>" <?php echo in_array($c_id, array_column($prefered_countries ?? [], 'prefered_country_id')) ? 'selected' : '' ?>><?php echo $c_name; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="row sml-padding conatnt_alignment">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><a href="countries_list.php" class="btn btn-default ">Back</a> <input data-loading-text="Loading..." type="submit" class="btn btn-primary sumit-prefered" name="submit" value="Submit"></div>
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

    <!-- Include jQuery (required for Select2) -->