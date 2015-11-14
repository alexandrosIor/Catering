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
			<?=isset($home) ? '<a href="' . $home . '" class="icon icon-left-nav pull-left" data-transition="slide-out"></a>' : ''?>
			<h1 class="title"><?=$title?></h1>
		</header>

		<?=$body?>

		<!-- Settings Modal -->
			<div id="settingsModal" class="modal">
				<header class="bar bar-nav">
					<a class="icon icon-close pull-right" href="#settingsModal"></a>
					<h1 class="title">Ρυθμίσεις</h1>
				</header>

				<div class="content">
					<h5 class="content-padded">Ρυθμισεις λογαριασμου</h5>
					<form class="input-group">
						<input type="text" placeholder="Αλέξανδρος Ιορδανίδης">
						<input type="email" placeholder="<?=$logged_in_member->email?>">
						<div class="content-padded">
							<button class="btn btn-positive btn-block" type="submit" disabled>αποθηκευση</button>
						</div>
					</form>

					<h5 class="content-padded">App settings</h5>
					<ul class="table-view">
						<li class="table-view-cell media">
							<span class="media-object pull-left icon icon-sound"></span>
							<div class="media-body">
								Enable sounds
							</div>
							<div class="toggle">
								<div class="toggle-handle"></div>
							</div>
						</li>
						<li class="table-view-cell media">
							<span class="media-object pull-left icon icon-person"></span>
							<div class="media-body">
								Parental controls
							</div>
							<div class="toggle">
								<div class="toggle-handle"></div>
							</div>
						</li>
					</ul>

					<h5 class="content-padded">πληροφοριες βαρδιας</h5>
					<div class="content-padded">
						<i class="fa fa-clock-o fa-lg"></i> 
						<span> 4:32:20</span>
					</div>

					<div class="content-padded">
						<a href="/logout" class="btn btn-negative btn-block sign-out" data-transition="slide-in">αποσύνδεση <i class="fa fa-sign-out fa-lg fa-fw"></i></a>
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
		
		<!-- Include the compiled Ratchet JS -->
		<script src="/assets/plugins/ratchet/js/ratchet.js"></script>
		<script src="/assets/plugins/ratchet/js/jquery-2.1.4.min.js"></script>

		<?=$this->layout_lib->print_additional_js()?>

	</body>
</html>
