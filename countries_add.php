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
$ban_type = '';
if(isset($_GET['type']))
{
    $ban_type =  $_GET['type'];
}
if (isset($_POST['submit_btn']) && isset($_POST['sending_country']) && !empty($_POST['sending_country'])) {
    $cc_id = '';
    $country_id = '';
    $get_id = '';
    $sending_country = '';
    multiple_single($link, $cc_id, $country_id, $get_id, $sending_country, $_GET);
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
                                    if (isset($_GET['failes3'])) {
                                    ?>
                                        <div class="alert alert-warning">
                                            <div class="container"><strong>Invalid file name. Please enter a correct file name.</strong></div>
                                        </div>
                                    <?php }
                                    if (isset($_GET['failes']) && $_GET['failes'] == 1) { ?>
                                        <div class='alert alert-danger'>
                                            <div class='container'><strong>This type of file is not allowed to upload.</strong></div>
                                        </div>
                                    <?php } elseif (isset($_GET['failes']) && $_GET['failes'] == 2) { ?>
                                        <div class='alert alert-danger'>
                                            <div class='container'><strong>This type of Banner is already Exist.</strong></div>
                                        </div>
                                    <?php } elseif (isset($_GET['failes']) && $_GET['failes'] == 3) { ?>
                                        <div class='alert alert-danger'>
                                            <div class='container'><strong>Country is Empty.</strong></div>
                                        </div>
                                        <?php }
                                    if (!empty($error_array)) {
                                        foreach ($error_array as $error) {
                                        ?>
                                            <?php echo $error; ?>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <div id="no-more-tables">
                                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?type=<?=$ban_type?>" method="POST" id="product_add" enctype="multipart/form-data" name="uploadfiles" autocomplete="off">
                                            <div class="container">
                                                <div class="row sml-padding conatnt_alignment">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label for="banner_type" class="control-label">Banner Type <span class="text-danger">*</span></label>
                                                        <select name="banner_type" id="banner_type" class="form-control" required>
                                                            <option value="" hidden disabled selected>SELECT</option>
                                                            <?php
                                                            // $banner_query = "SELECT * FROM `banner_types` where id = ";
                                                            // $banner_query .= isset($_GET['type']) && $_GET['type'] == 2 ?  2 : "1 OR id = 3";
                                                            $banner_query = "SELECT * FROM `banner_types`";
                                                            $banner_types = $link->query($banner_query);
                                                            foreach ($banner_types as $banner_type) {
                                                                $banner_id = $banner_type['id'];
                                                                $banner_name = $banner_type['name'];
                                                            ?>
                                                                <option value="<?php echo $banner_id; ?>"><?php echo ucfirst(str_replace("_", " ", $banner_name)); ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row sml-padding conatnt_alignment" id="country" style="display: none;">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label for="sending_country" class="control-label country_label">Sending Country <span class="text-danger">*</span></label>
                                                        <select name="sending_country" id="sending_country" class="form-control" required>
                                                            <option value="" hidden disabled selected>SELECT</option>
                                                            <?php
                                                            $countries =  mysqli_query($link, "SELECT * FROM `countries`");
                                                            foreach ($countries as $country) {
                                                            ?>
                                                                <option value="<?php echo $country['id'] ?>"><?php echo $country['name'] ?></option>
                                                            <?php
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
                                                <div class="row sml-padding conatnt_alignment">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label class="control-label" for="banner">Banner <span class="text-danger">*</span></label>
                                                        <input type="file" name="banner" id="banner" class="form-control" required>
                                                        <p style="margin: 6px 0px 0px 0px; font-size: 12px;color: #999393;"> <i class='fa fa-info-circle'></i> Please add file with country code i.e for Australia AUS.</p>
                                                    </div>
                                                </div>
                                                <div class="row sml-padding conatnt_alignment">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><a href="countries_list.php" class="btn btn-default">Back</a> <input type="submit" class="btn btn-primary" name="submit_btn" value="Submit"></div>
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