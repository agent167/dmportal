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
            if (empty($_FILES["upload_file"]["error"])) {
                $upload_FileName = $_FILES["upload_file"]["name"];
                $upload_FileName = $_FILES["upload_file"]["tmp_name"];
                $i = 0;
                $upload_FileNameSubStr = substr($upload_FileName, 0, -4);
                // For Sending Country Validation Start
                if ($_FILES["upload_file"]["size"] > 0) {
                    $file = fopen($upload_FileName, "r");
                    $array = [];
                    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $emapData = str_replace(",", " ", $emapData);
                        if ($i > 0) {
                            // echo $emapData[1];
                            // echo "<br>";
                            $array[$emapData[2]][] = [
                                'country' =>  $emapData[1],
                                'currency' =>  $emapData[2],
                                'rate' =>  $emapData[3]
                            ];
                        }
                        $i++;
                    }
                    fclose($file);
                    $result_array = [];
                    foreach ($array as $arr_index => $arr) {
                        $country_array = [];
                        $max = 0;
                        foreach ($arr as $inner_arr_index => $inner_arr) {
                            if ($inner_arr['rate'] > $max) {
                                $max = $inner_arr['rate'];
                                $country_array = $inner_arr;
                            }
                        }
                        $country_name = $country_array['country'];
                        $select_sql = mysqli_fetch_array(mysqli_query($link, "SELECT `id`,`name` FROM `countries` WHERE `currency`='$arr_index' AND `name`='$country_name'"));
                        if (!empty($select_sql)) {
                            $currency_id = $select_sql['id'];
                            $currency_id_array = [
                                'currency_id' => $currency_id,
                            ];
                            $result_array[] = array_merge($country_array, $currency_id_array);
                        }
                    }
                    $countries_currencies = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$cc_id'"));
                    if ($countries_currencies > 0) {
                        // mysqli_query($link, "UPDATE `countries_currencies_rates` SET `status`='0' WHERE `count_curr_id`='$cc_id'");
                        // exit;
                        $sql =   "UPDATE `countries_currencies_rates` SET `status`='0' WHERE `count_curr_id`='$cc_id';";
                        $sql .=   "INSERT INTO currencies_rates_history SELECT * FROM countries_currencies_rates WHERE `count_curr_id`='$cc_id' AND `status`='0';";
                        $sql .=  "DELETE FROM countries_currencies_rates WHERE `count_curr_id`='$cc_id';";
                        // mysqli_query($link, $sql);
                        // if (!mysqli_query($link, $sql)) {
                        //     echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        // }
                        if (mysqli_multi_query($link, $sql)) {
                            do {
                                if ($result = mysqli_store_result($link)) {
                                    while ($row = mysqli_fetch_row($result)) {
                                        printf("%s\n", $row[0]);
                                    }
                                    mysqli_free_result($result);
                                }
                            } while (mysqli_next_result($link));
                        }
                    }
                    foreach ($result_array as $result_arr) {
                        $currency_id = $result_arr['currency_id'];
                        $currency = $result_arr['currency'];
                        $rate = $result_arr['rate'];
                        $sql3 = mysqli_query($link, "INSERT INTO `countries_currencies_rates`(`count_curr_id`, `currency_id`, `rate`, `status`, `created_at`) VALUES ('$cc_id','$currency_id','$rate','1',NOW())");
                    }
                    $strNotice = "<strong>Your File:</strong> <strong><u>" . $upload_FileName . "</u></strong> <em>CSV File has been successfully Imported.</em>";
                } else {
                    $strNotice = "<strong>Invalid File:</strong> <strong><u>" . $upload_FileName . "</u></strong> <em>Please Upload CSV File.</em>";
                }
                echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$cc_id&country_id=$country_id&success=y'</script>");
            }
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