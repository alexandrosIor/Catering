<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Catering Mobile Layout</title>

		<!-- Sets initial viewport load and disables zooming  -->
		<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

		<!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!-- Include the compiled Ratchet CSS -->
		<link href="/assets/plugins/ratchet/css/ratchet.css" rel="stylesheet">
		<link href="/assets/css/custom_mobile.css" rel="stylesheet">

		<!-- fonts-awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

		<?=$this->layout_lib->print_additional_css()?>
	</head>
	<body>

		<!-- Make sure all your bars are the first things in your <body> -->
		<header class="bar bar-nav">
			<a class="open-settings icon icon-gear pull-right"></a>
			<?=isset($home) ? '<a href="' . $home . '" class="icon icon-left-nav pull-left"></a>' : ''?>
			<h1 class="title"><?=$title?></h1>
		</header>

		<?=$body?>

		<!-- Modal -->
		<div id="myModal" class="modal">
			<header class="bar bar-nav">
				<a class="close-settings icon icon-close pull-right"></a>
				<h1 class="title">Ρυθμίσεις</h1>
			</header>
			<div class="content"></div>
		</div>

		<nav class="bar bar-tab">
<?php foreach ($menu as $key => $menu_item)
{?>
			<a class="tab-item" href="<?=$menu_item['link']?>" data-transition="slide-in">
				<span class="icon"><i class="<?=$menu_item['icon']?>"></i></span>
				<span class="tab-label"><?=$menu_item['name']?></span>
			</a>
<?php }?>
		</nav>

		<script src="/assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script src="/assets/plugins/ratchet/js/ratchet.js"></script>
		<script src="/assets/js/waiter_mobile_views/global_waiter_mobile.js"></script>
		
		<?=$this->layout_lib->print_additional_js()?>

	</body>
</html>
