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
    $id = $_GET['id'];
    // exit;
    $countries =  mysqli_query($link, "DELETE FROM `countries_currencies` WHERE `id`='$id'");
}
?>
<style>
    .pm_0 {
        padding: 0;
        margin: 0;
        margin-top: 10px;
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
                    <?php
                    if (isset($_GET['failes']) && $_GET['failes'] == 1) { ?>
                        <div class='alert alert-danger'>
                            <div class='container'><strong>From Date Mendatory</strong></div>
                        </div>
                    <?php }
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="row">
                            <div class="col-lg-12 pm_0" style="display: flex;flex-direction: row; justify-content: center;">
                                <?php
                                $sending_currency = '';
                                $receiving_currency = '';
                                $date_from = '';
                                $date_to = '';
                                $date_filter = '';
                                $sending_filter = '';
                                $receiving_filter = '';

                                if (isset($_POST['search'])) {
                                    if (isset($_POST['sending_currency'])) {
                                        $sending_currency = $_POST['sending_currency'];
                                        $sending_filter = "`cc`.`country_id`='$sending_currency'";
                                    }
                                    if (isset($_POST['date_from'])) {
                                        $date_from = $_POST['date_from'];
                                    } else {
                                        $date_from = '';
                                    }
                                    if (isset($_POST['date_to'])) {
                                        $date_to = $_POST['date_to'];
                                    } else {
                                        $date_to = '';
                                    }

                                    if (!empty($date_from) && !empty($date_to)) {
                                        $date_filter = "AND date(`crh`.`created_at`) BETWEEN '$date_from' AND '$date_to'";
                                    } elseif (!empty($date_from) && empty($date_to)) {
                                        $date_filter = "AND date(`crh`.`created_at`) = '$date_from'";
                                    } else {
                                        if (empty($date_from) && !empty($date_to)) {
                                            echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?failes=1'</script>");
                                        }
                                    }
                                }
                                ?>
                                <div class="col-lg-7">
                                    <label for="sending_currency">Country</label>
                                    <select name="sending_currency" id="sending_currency" class="form-control">
                                        <option selected hidden disabled> SELECT</option>
                                        <?php
                                        $countries =  mysqli_query($link, "SELECT * FROM `countries`");
                                        foreach ($countries as $country) {
                                        ?>
                                            <option value="<?php echo $country['id'] ?>" <?php if (!empty($sending_currency) && $sending_currency == $country['id']) {
                                                                                                echo "selected";
                                                                                            } ?>><?php echo $country['name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 pm_0" style="display: flex;flex-direction: row; justify-content: center;">
                                <div class="col-lg-7">
                                    <div class="col-lg-4 pm_0">
                                        <input type="date" class="form-control input-date-picker datepicker-dropdown " id="date_from" name="date_from" placeholder="Start Date" autocomplete="off" value="<?php if (!empty($date_from)) {
                                                                                                                                                                                                                echo $_POST['date_from'];
                                                                                                                                                                                                            } ?>" />
                                    </div>
                                    <div class="col-lg-4 pm_0">
                                        <span class="input-group-addon" style="padding: 9px 0;"><i class="fa fa-angle-left"></i> <span class="text-danger">*</span> From DATE To <span class="text-danger">*</span> <i class="fa fa-angle-right"></i></span>
                                    </div>
                                    <div class="col-lg-4 pm_0">
                                        <input type="date" class="form-control input-date-picker" id="date_to" name="date_to" placeholder="End Date" autocomplete="off" value="<?php if (!empty($date_to)) {
                                                                                                                                                                                    echo $_POST['date_to'];
                                                                                                                                                                                } ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 pm_0" style="display: flex;flex-direction: row; justify-content: center;">
                                <div>
                                    <button type="submit" name="search" class="btn btn-success col-lg-12"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                    <table id="leads" class="col-lg-12 table-striped table-condensed cf tbl">
                                        <thead class="cf">
                                            <tr>
                                                <th>#</th>
                                                <th>Dated</th>
                                                <th>Country</th>
                                                <th>Currency</th>
                                                <th>Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_POST['search'])) {
                                                $countries_currencies =  mysqli_query($link, "SELECT `crh`.`id` AS `crh_id`,`crh`.`created_at` AS `crh_created_at`,`crh`.`currency_id` AS `crh_currency_id`,`cc`.`id` AS `cc_id`,`cc`.`country_id` AS `cc_country_id`,`crh`.`rate` AS `crh_rate` FROM `countries_currencies` AS `cc` INNER JOIN `currencies_rates_history` AS `crh`  ON `cc`.`id`=`crh`.`count_curr_id` WHERE $sending_filter $receiving_filter $date_filter");
                                                if (mysqli_num_rows($countries_currencies) > 0) {
                                                    foreach ($countries_currencies as $countries_currency) {
                                                        $crh_id = $countries_currency['crh_id'];
                                                        $cc_country_id = $countries_currency['cc_country_id'];
                                                        $countries =  mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `countries` WHERE `id`='$cc_country_id'"));
                                                        $country_name = $countries['name'];
                                                        $crh_currency_id = $countries_currency['crh_currency_id'];
                                                        $currencies =  mysqli_fetch_array(mysqli_query($link, "SELECT `name`,`iso` FROM `countries` WHERE `id`='$crh_currency_id'"));
                                                        $currency_name = $currencies['name'];
                                                        $currency_iso = $currencies['iso'];
                                                        $crh_rate = $countries_currency['crh_rate'];
                                                        $crh_created_at = $countries_currency['crh_created_at'];
                                            ?>
                                                        <tr id="">
                                                            <td></td>
                                                            <td><?php echo date('Y-m-d', strtotime($crh_created_at)); ?></td>
                                                            <td><?php echo $country_name; ?></td>
                                                            <td><?php echo  $currency_name . ' [ ' . $currency_iso . ' ] '; ?></td>
                                                            <td><?php echo $crh_rate; ?></td>
                                                        </tr>

                                                    <?php }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td colspan="5" style="text-align: center;">No Record Found</td>
                                                    </tr>
                                            <?php
                                                }
                                            }  ?>
                                        </tbody>
                                    </table>
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