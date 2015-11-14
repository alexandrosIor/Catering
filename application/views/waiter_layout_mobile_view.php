<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Catering Mobile Layout</title>

		<!-- Sets initial viewport load and disables zooming  -->
		<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

		<!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!-- Include the compiled Ratchet CSS -->
		<link href="/assets/plugins/ratchet/css/ratchet.css" rel="stylesheet">

		<!-- Optionally, include either the iOS or Android theme -->
		<link href="/assets/plugins/ratchet/css/ratchet-theme-ios.css" rel="stylesheet">

		<!-- fonts-awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

		<?=$this->layout_lib->print_additional_css()?>
	</head>
	<body>

		<!-- Make sure all your bars are the first things in your <body> -->
		<header class="bar bar-nav">
			<a class="icon icon-gear pull-right" href="#settingsModal"></a>
			<h1 class="title">Catering</h1>
		</header>

		<?=$body?>

		<nav class="bar bar-tab">
			<a class="tab-item" href="tables.php" data-transition="slide-in">
				<!-- <span class="icon icon-person"></span> -->
				<span class="icon"><i class="fa fa-th-large"></i></span>
				<span class="tab-label">τραπέζια</span>
			</a>
			<a class="tab-item" href="#">
				<!-- <span class="icon icon-star-filled"></span> -->
				<span class="icon"><i class="fa fa-pencil-square-o"></i></span>
				<span class="tab-label">παραγγελίες</span>
			</a>
			<a class="tab-item" href="#">
				<span class="icon icon-search"></span>
				<span class="tab-label">Search</span>
			</a>
			<a class="tab-item" href="#">
				<span class="icon icon-gear"></span>
				<span class="tab-label">Settings</span>
			</a>
			<a class="tab-item" href="#">

				<style>
				.badge-notify{
				   background:red;
				   position:relative;
				   top: -40px;
				   left: 15px;
				}
				</style>

				<div class="container">
				<span class="icon"><i class="fa fa-bell-o"></i></span>
					<span class="tab-label">Home
					  <span class="badge badge-notify">3</span></span>
				</div>
			</a>
		</nav>
		
		<!-- Include the compiled Ratchet JS -->
		<script src="/assets/plugins/ratchet/js/ratchet.js"></script>
		<script src="/assets/plugins/ratchet/js/jquery-2.1.4.min.js"></script>

		<?=$this->layout_lib->print_additional_js()?>

	</body>
</html>
