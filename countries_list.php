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
    $id = $_GET['id'];
 //   $banner_id = $_GET['banner_id'];
    country_delete($link, $id);
}
?>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <?php include('inc_nav.php'); ?>
            </div>
            <?php include('inc_header.php'); ?>
            <div class="breadcrumb_content">
                <div class="breadcrumb_text"><a href="dashboard.php">Dashboard</a> / <?php echo $plu_del_rep; ?>
                </div>
            </div>
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
                                        <li>
                                            <a href="countries_add.php?type=1" class="border-none btn btn-primary btn-xs bg-none">
                                                <button type="button" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-plus"></i> New
                                                </button>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <?php if (isset($_GET['delete'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong>Row is successfully deleted!</strong></div>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_SESSION['failes'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong><?php echo $_SESSION['failes']; ?></strong></div>
                                        </div>
                                    <?php } ?>
                                    <table id="leads" class="col-lg-12 table-striped table-condensed cf tbl">
                                        <thead class="cf">
                                            <tr>
                                                <th>#</th>
                                                <th>Country</th>
                                                <th class="al-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // echo "SELECT `cc`.`id` AS `cc_id`,`cc`.`country_id` AS `country_id`,`ct`.`id` AS `ct_id`,`ct`.`name` AS `name` FROM `countries` AS `ct` LEFT JOIN `countries_currencies` AS `cc`  ON `ct`.`id`=`cc`.`country_id` WHERE `cc`.`status`='1'";
                                            $countries =  mysqli_query($link, "SELECT `cc`.`id` AS `cc_id`, `cc`.`country_id` AS `country_id`, `ct`.`id` AS `ct_id`, `ct`.`name` AS `name`, `b`.`type` AS `banner_type` FROM `countries` AS `ct` LEFT JOIN `countries_currencies` AS `cc` ON `ct`.`id` = `cc`.`country_id` INNER JOIN `banners` AS `b` ON `cc`.`id` = `b`.`count_curr_id` WHERE `cc`.`status` = '1' AND `b`.`type` in (1,5,7) GROUP by `ct_id`;");
                                            foreach ($countries as $country) {
                                                $cc_id = $country['cc_id'];
                                                $country_id = $country['country_id'];
                                                $name = $country['name'];
                                                $count_curr_count = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `sending_prefered_countries` WHERE `sending_country_id`='$cc_id'"));
                                            ?>
                                                <tr id="">
                                                    <td></td>
                                                    <td><?php echo $name; ?></td>
                                                    <td data-title="Action" class="al-center">
                                                        <!-- <a href="upload_rate_file.php?id=<?php //echo $cc_id . "&country_id=" . $country_id; 
                                                                                                ?>" data-toggle="tooltip" data-placement="top" title="Upload" class="btn btn-info btn-sm"><i class="fa fa-upload"></i></a> -->
                                                        <a href="countries_edit.php?id=<?php echo $cc_id . "&country_id=" . $country_id; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                        <a href="preference_countries.php?id=<?php echo $cc_id ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                                        <?php
                                                        if ($count_curr_count > 0) {
                                                        ?>
                                                            <a href="banner_download.php?id=<?php echo $cc_id . "&country_id=" . $country_id; ?>" data-toggle="tooltip" data-placement="top" title="Download" class="btn btn-success btn-sm"><i class="fa fa-download"></i></a>
                                                        <?php
                                                        }
                                                        ?>
                                                        <a href="<?php echo basename($_SERVER['PHP_SELF']) . "?id=" . $cc_id; ?>&delete=y" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
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