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

		<!-- Settings Modal -->
			<div id="settings_modal" class="modal">
				<header class="bar bar-nav">
					<a class="close-settings icon icon-close pull-right"></a>
					<h1 class="title">Ρυθμίσεις</h1>
				</header>

				<div class="content">
					<h5 class="content-padded">Ρυθμισεις λογαριασμου</h5>
					<form class="input-group user-info">
						<input type="text" value="<?=$logged_in_member->email?>">
						<input type="password" value="<?=$logged_in_member->password?>">
						<div class="content-padded">
							<button class="save-changes btn btn-positive btn-block" type="submit" disabled>αποθηκευση</button>
						</div>
					</form>

					<h5 class="content-padded">App settings</h5>
					<ul class="table-view">
						<li class="table-view-cell media">
							<span class="media-object pull-left icon icon-sound"></span>
							<div class="media-body">Enable sounds</div>
							<div class="toggle">
								<div class="toggle-handle"></div>
							</div>
						</li>
					</ul>

					<div class="content-padded">
						<a href="/logout" class="btn btn-negative btn-block sign-out" data-transition="slide-out">αποσύνδεση <i class="fa fa-sign-out fa-lg fa-fw"></i></a>
					</div>
				</div>
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
		<script src="/assets/js/mobile.js"></script>
		
		<?=$this->layout_lib->print_additional_js()?>

	</body>
</html>
