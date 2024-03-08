<?php include('inc_meta_header.php'); ?>
<title>Dashboard <?php include('inc_page_title.php'); ?></title>
<?php include('inc_head.php'); ?>

<body class="nav-md">

    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <?php include('inc_nav.php'); ?>
            </div>
            <?php include('inc_header.php'); ?>
            <!-- breadcrumb -->
            <div class="breadcrumb_content">
                <div class="breadcrumb_text">Dashboard / <!--<a href="dashboard.php">Dashboard</a> / -->
                </div>
            </div>
            <!-- /breadcrumb -->

            <!-- page content -->
            <div class="right_col bg_fff" role="main">

                <div class="container">
                    <div class="page-header">
                        <h1>Receiving Country</h1>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading panel-heading-nav">
                            <ul class="nav nav-tabs">
                                <li role="presentation" class="active">
                                    <a href="#one" aria-controls="one" role="tab" data-toggle="tab">Prefrred Country</a>
                                </li>
                                <li role="presentation">
                                    <a href="#two" aria-controls="two" role="tab" data-toggle="tab">Country Wise</a>
                                </li>
                                <li role="presentation">
                                    <a href="#three" aria-controls="three" role="tab" data-toggle="tab">Individual Country</a>
                                </li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="one">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-body">
                                                Prefrred Country
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="two">
                                    <form>
                                        <div class="panel-header">
                                            <div class="panel-body">

                                            
                                                Country Wise
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="three">
                                    <form>
                                        <div class="panel-header">
                                            <div class="panel-body">
                                                Individual Country
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">

                    <div id="chartContainer_multi" style="height: 400px; width: 100%;"></div>
                    <div id="chartContainer" style="height: 400px; width: 100%;"></div>

                </div>


            </div>


            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


            <!-- /page content -->
            <?php include('inc_footer.php'); ?>

        </div>
    </div>
    <?php include('inc_foot.php'); ?>