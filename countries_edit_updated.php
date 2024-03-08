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
    $sending_country = $_GET['country_id'];

    $countries =  mysqli_query($link, "SELECT `cc`.`id` AS `cc_id`,`ct`.`id` AS `ct_id`,`ct`.`name` AS `name`,`cc`.`country_id` AS `country_id` FROM `countries` AS `ct` INNER JOIN `countries_currencies` AS `cc`  ON `ct`.`id`=`cc`.`country_id` WHERE `cc`.`id`='$get_id'");
    foreach ($countries as $country) {
        $cc_id = $country['cc_id'];
        $country_id = $country['country_id'];
    }
    $country_select = mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `countries` WHERE `id`='$country_id'"));
    $country_name = $country_select['name'];
    $currencies_rates =  mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$cc_id'");
    $currencies_rates_counts =  mysqli_num_rows($currencies_rates);
}
if (isset($_POST['edit_submit'])) {
    multiple_single($link, $cc_id, $country_id, $get_id, $sending_country);
}
if (isset($_GET['delete']) && $_GET['delete'] == 'y') {
    $cc_id = $_GET['id'];
    $banner_type = $_GET['banner_type'];
    edit_banner_delete($link, $cc_id, $banner_type);
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
            background-color: #f5f5f5;
            border-radius: 30px;
            border: 1px solid #c5c5c5;
            font-size: 11px;
            min-width: 20px;
            margin: 0 !important;
            padding: 5px 2px 3px 2px;
            text-align: center;
        }

        .minus_button {
            background-color: white;
            border: none;
        }

        .msg_img {
            cursor: pointer;
        }
    </style>
    <style>
        .img_modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            padding-bottom: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        .img_modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        .close_modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: 900;
            transition: 0.3s;
        }

        .close_modal:hover,
        .close_modal:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .download_icon {
            position: absolute;
            top: 27px;
            right: 77px;
            color: #f1f1f1;
            font-size: 25px;
            font-weight: bold;
            transition: 0.3s;
        }

        .download_icon:hover,
        .download_icon:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        @media only screen and (max-width: 700px) {
            .img_modal-content {
                width: 100%;
            }
        }
    </style>
    <style>
        .content_alignment {
            display: flex;
            flex-direction: row;
            justify-content: center;
        }

        .content_alignment img {
            padding: 0;
        }

        .content_alignment .content_alignment_inner_div {
            text-align: center;
        }

        #content {
            color: #fff;
            min-width: 1080px;
        }

        .ratelist {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .ratelist li img {
            width: 50px;
            display: inline-block;
        }

        .ratelist .li_10 {
            display: flex;
            flex-direction: row;
            justify-content: center;
            padding: 10px 0 10px 615px;
        }

        .spec_padding_top {
            padding-top: 20px !important;
        }

        .spec_padding_bottom {
            padding-bottom: 20px !important;
        }

        .ratelist .li_15 {
            display: flex;
            flex-direction: row;
            justify-content: center;
            padding: 10px 0 10px 514px;
        }

        .ratelist .li_17 {
            display: flex;
            flex-direction: row;
            justify-content: center;
            padding: 10px 0 10px 615px;
        }

        .rate-input {
            width: 250px;
            height: 50px;
            text-align: center;
            margin: 0px 52px;
            font-weight: 900;
            font-size: 20px;
            border: 1px solid #d1cac3;
            border-radius: 5px;
            color: black;
        }

        input:focus {
            outline: none;
        }

        .c-short {
            font-family: sans-serif;
            font-size: 28px;
            color: #000;
            font-weight: 900;
            display: inline-block;
            max-width: 30px !important;
        }
    </style>
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
                                <div class="x_content">
                                    <?php if (isset($_GET['success'])) { ?>
                                        <div class="alert alert-success">
                                            <div class="container"><strong>Row is successfully Inserted!</strong></div>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_GET['failes'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong>This type of file is not allowed to upload.</strong></div>
                                        </div>
                                    <?php }
                                    if (isset($_GET['failes3'])) {
                                    ?>
                                        <div class="alert alert-warning">
                                            <div class="container"><strong>Invalid file name. Please enter a correct file name.</strong></div>
                                        </div>
                                        <?php }

                                    if (!empty($error_array)) {
                                        foreach ($error_array as $error) {
                                        ?>
                                            <?php echo $error; ?>
                                    <?php
                                        }
                                    } ?>
                                    <div id="no-more-tables">
                                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $get_id; ?>&country_id=<?php echo $country_id; ?>" method="POST" id="product_add" enctype="multipart/form-data" name="uploadfiles" autocomplete="off">
                                            <div class="container">
                                                <div class="row sml-padding conatnt_alignment">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label for="sending_country" class="control-label">Sending Country <span class="text-danger">*</span></label>
                                                        <div class="form-control"><?php echo $country_name; ?></div>
                                                    </div>
                                                </div>
                                                <div class="row sml-padding conatnt_alignment">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label for="banner_type" class="control-label">Banner Type <span class="text-danger">*</span></label>
                                                        <?php
                                                        $banner_validate = $link->query("SELECT `bn`.`type` AS `banner_type` FROM `banners` AS `bn` INNER JOIN `countries_currencies` AS `cc` ON `bn`.`count_curr_id` = `cc`.`id` and `bn`.`count_curr_id`='$get_id'");
                                                        $banner_validate_data = $banner_validate->fetch_all(MYSQLI_ASSOC);
                                                        $resultArray = !empty($banner_validate_data) ? array_column($banner_validate_data, 'banner_type') : [];
                                                        $banners_types = in_array(2, $resultArray) ? [2] :  [1, 3];
                                                        ?>
                                                        <select name="banner_type" id="banner_type" class="form-control" required>
                                                            <option value="" selected hidden disabled>SELECT</option>
                                                            <?php
                                                            $banner_types =  mysqli_query($link, "SELECT * FROM `banner_types`");
                                                            foreach ($banner_types as $banner_type) {
                                                                $bannerTypeId = $banner_type['id'];
                                                                $bannerTypeName = ucfirst(str_replace("_", " ", $banner_type['name']));
                                                                if (in_array($bannerTypeId, $resultArray) || in_array($bannerTypeId, $banners_types) || empty($resultArray)) {
                                                                    echo "<option value='$bannerTypeId'>$bannerTypeName</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label for="banner_type_size" class="control-label">Banner Size <span class="text-danger">*</span></label>
                                                        <select name="banner_type_size" id="banner_type_size" class="form-control" required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row sml-padding" id="banner_sub_type_div" style="display: none;">
                                                    <div class="conatnt_alignment">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                            <label class="control-label" for="banner_sub_type">Banner Sub Type <span class="text-danger">*</span></label>
                                                            <select name="banner_sub_type" id="banner_sub_type" class="form-control" required>
                                                                <option value="" hidden disabled selected>SELECT</option>
                                                                <?php
                                                                $banner_sub_types =  mysqli_query($link, "SELECT * FROM `banner_sub_types`");
                                                                foreach ($banner_sub_types as $banner_sub_type) {
                                                                ?>
                                                                    <option value="<?php echo $banner_sub_type['id'] ?>"><?php echo ucfirst(str_replace("_", " ", $banner_sub_type['name'])); ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row sml-padding">
                                                    <div class="col-lg-3"></div>
                                                    <div class="col-lg-6">
                                                        <label class="control-label" for="banner">Banner <span class="text-danger">*</span></label>
                                                        <input type="file" name="banner" id="banner" class="form-control" required>
                                                        <p style="margin: 6px 0px 0px 0px; font-size: 12px;color: #999393;"> <i class='fa fa-info-circle'></i> Please add file with country code i.e for Australia AUS.</p>
                                                    </div>
                                                    <div class="col-lg-3"></div>
                                                </div>
                                                <div class="row sml-padding">
                                                    <div class="col-lg-3 text-right"></div>
                                                    <div class="col-lg-6"><a href="countries_list.php" class="btn btn-default">Back</a> <input type="submit" class="btn btn-primary" name="edit_submit" value="Submit"></div>
                                                </div>
                                            </div>
                                        </form>
                                        <script>
                                            $(document).ready(function() {
                                                $('#banner_type').change(function() {
                                                    $('#country').show();
                                                    if ($("#banner_type option:selected").text() == "Individuals") {
                                                        $('#banner_sub_type_div').show();
                                                        $('#banner_sub_type').prop('required', true);
                                                        $('#country .country_label').html('Sending Country <span class="text-danger">*</span>');
                                                    } else {
                                                        $('#banner_sub_type_div').hide();
                                                        $('#banner_sub_type').prop('required', false);
                                                        if ($("#banner_type option:selected").text() == "Country wise") {
                                                            $('#country .country_label').html('Sending Country <span class="text-danger">*</span>');
                                                        } else {
                                                            $('#country .country_label').html('Receving Country <span class="text-danger">*</span>');
                                                        }
                                                        $('#banner').prop('multiple', false)
                                                        $('#banner').attr('name', "banner");
                                                    }
                                                    $('#banner_type_size_div').show();
                                                    $.ajax({
                                                        type: "get",
                                                        url: "banner_size.php",
                                                        data: {
                                                            "id": $("#banner_type option:selected").val(),
                                                        },
                                                        success: function(response) {
                                                            $('#banner_type_size').html(response);
                                                        },
                                                        error: (error) => {
                                                            console.log(JSON.stringify(error));
                                                        }
                                                    });
                                                });
                                                $('#banner_sub_type').change(function() {
                                                    if ($("#banner_sub_type option:selected").text() == "Specific") {
                                                        $('#banner').prop('multiple', true);
                                                        $('#banner').attr('name', "banner[]");
                                                    } else {
                                                        $('#banner').prop('multiple', false)
                                                        $('#banner').attr('name', "banner");
                                                    }
                                                });
                                            });
                                        </script>
                                        <!-- Banner Preview -->
                                        <div class="row sml-padding" style="margin-top: 1%;">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <h1 class="col-lg-12 content_alignment"> Sending Country Wise</h1>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 content_alignment">
                                                        <div class="content_alignment_inner_div">
                                                            <?php
                                                            edit_sending_country_html($link, $cc_id, $country_id);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <h1 class="col-lg-12 content_alignment"> Receiving Country Wise</h1>
                                                </div>
                                                <div class="row">
                                                    <div class=" col-lg-12 content_alignment">
                                                        <div class="content_alignment_inner_div">
                                                            <?php
                                                            edit_receving_country_html($link, $cc_id, $country_id);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row sml-padding" style="margin-top: 1%;">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <h1 class="col-lg-12 content_alignment"> Individual Country Wise</h1>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content_alignment" style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: space-around;">
                                                        <div class="content_alignment_inner_div col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                            <?php
                                                            edit_individual_country_html($link, $cc_id, $country_id);
                                                            ?>
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
                </div>
            </div>
        </div>
        <!-- /page content -->
        <?php include('inc_footer.php'); ?>
    </div>
    </div>
    <?php include('inc_foot.php'); ?>