<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="theme-color" content="#2196f3">
		<title>Catering</title>
		<link rel="stylesheet" href="/assets/plugins/framework7/dist/css/framework7.material.min.css">
		<link rel="stylesheet" href="/assets/plugins/framework7/dist/css/framework7.material.colors.min.css">
		<link href="http://fonts.googleapis.com/css?family=Roboto:400,300,500,700" rel="stylesheet" type="text/css">
		<link href="/assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="/assets/css/custom_mobile.css">
		<link rel="icon" href="img/icon.png">
	</head>
	<body>
		<div class="statusbar-overlay"></div>
		<div class="panel-overlay"></div>
		<div class="panel panel-left panel-cover shift-panel">
			<div class="view navbar-fixed">
				<div class="pages">

					<div data-page="panel-left" class="page">
						<div class="navbar">
							<div class="navbar-inner">
								<div class="center">Catering</div>
							</div>
						</div>
						<div class="page-content">
							<div class="content-block-title"><?=$logged_in_user->firstname . ' ' . $logged_in_user->lastname?></div>
							<div class="content-block">
								<div class="list-group">
									<div class="list-block">
									    <ul>
		      								<li class="list-group-title">Στοιχεία βάρδιας</li>
		      								<li>
												<div class="item-inner">
													<div class="item-title">Ωρα έναρξης:</div>
													<div><?=$start_date?></div>
												</div>
											</li>
											<li>
												<div class="item-inner">
													<div class="item-title">Χρόνος εργασίας: </div>
													<div class="time-worked-timer"><?=$time_worked?></div>
												</div>
											</li>											
											<li>
												<div class="item-inner">
													<div class="item-title">Σύνολο παραγγελίων</div>
													<div class="total-orders"><?=$total_orders?></div>
												</div>
											</li>											
											<li>
												<div class="item-inner">
													<div class="item-title">Απλήρωτες</div>
													<div class="unpaid-orders"><?=$unpaid_orders?></div>
												</div>
											</li>
		    							</ul>
		  							</div>
		  							<div class="list-block">
										<ul class="left-side-menu">
											<li class="list-group-title">Επιλογές</li>
											<li>
												<a href="#" class="item-link item-content external">
													<div class="item-inner waiter-close-shift">
														<div class="item-title">Κλείσιμο βάρδιας</div>
														<div class="item-after"><i class="fa fa-history fa-lg"></i></div>
													</div>
												</a>
											</li>									
											<li>
												<a href="/logout" class="item-link item-content external">
													<div class="item-inner">
														<div class="item-title">Αποσύνδεση</div>
														<div class="item-after"><i class="fa fa-sign-out fa-lg"></i></div>
													</div>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>

		<div class="views">
			<div class="view view-main">

				 <div class="pages navbar-fixed">
					<div data-page="index" class="page">
						<div class="navbar">
							<div class="navbar-inner">
							<div class="center">Catering</div>
							<div class="right"><a href="#" class="open-panel link icon-only"><i class="icon icon-bars"></i></a></div>
							</div>
						</div>

						<div class="toolbar tabbar">
							<div class="toolbar-inner">
								<a href="#incomplete-orders" class="tab-link active"><i class="fa fa-hourglass-half fa-lg"></i><span class="tabbar-label">Προς υλοποιηση</span></a>
								<a href="#unpaid-orders" class="tab-link "><i class="fa fa-money fa-lg"></i><span class="tabbar-label">Προς πληρωμη</span></a>
							</div>
						</div>

						<a href="/Waiter_new_order" class="floating-button"><i class="icon icon-plus"></i></a>
						<div class="page-content"> 

							<div class="tabs">
								<div id="incomplete-orders" class="tab active"></div>
								<div id="unpaid-orders" class="tab"></div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div> 

		<!-- popover modal -->
		<div class="popover my-popover">
			<div class="popover-angle"></div>
			<div class="popover-inner">
				<div class="content-block"></div>
			</div>
		</div>

		<!-- Popup modal -->
		<div class="popup my-popup"></div>

		<script type="text/javascript" src="/assets/plugins/framework7/dist/js/framework7.min.js"></script>
		<script src="/assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script src="/assets/plugins/plugin-countid/countid.js"></script>
		<script src="/assets/plugins/jquery-maskedinput/jquery.maskedinput.js"></script>
		<!-- Το websocket κανάλι του επιλεγμένου καταστήματος -->
		<script> var user_channel = '<?=$logged_in_user->record_id?>'</script>
		<script type="text/javascript" src="assets/js/mobile_global.js"></script>
		<?=$this->layout_lib->print_additional_js()?>
		
		<script>

		</script>

	</body>
</html>