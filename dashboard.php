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