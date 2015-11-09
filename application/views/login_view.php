<!DOCTYPE html>
<html>
	
<head>
		
		<!-- Title -->
		<title>Catering</title>
		
		<meta content="width=device-width, initial-scale=1" name="viewport"/>
		<meta charset="UTF-8">
		<meta name="description" content="Catering manager" />
		<meta name="keywords" content="admin,dashboard" />
		
		<!-- Styles -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
		<link href="../assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
		<link href="../assets/plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
		<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="../assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
		<link href="../assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>	
		<link href="../assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>	
		<link href="../assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>	
		<link href="../assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
		<link href="../assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>	
		
		<!-- Theme Styles -->
		<link href="../assets/css/modern.min.css" rel="stylesheet" type="text/css"/>
		<link href="../assets/css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>
		<link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
		
		<script src="../assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
		<script src="../assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
		
	</head>
	<body class="page-login">
		<main class="page-content">
			<div class="page-inner">
				<div id="main-wrapper">
					<div class="row">
						<div class="col-md-3 center">
							<div class="login-box">
								<a href="/login" class="logo-name text-lg text-center">Catering</a>
								<p class="text-center m-t-md">Παρακλώ συνδεθείτε στον λογαρισμό σας</p>
								<form class="m-t-md" id="login_form">
									<div class="form-group">
										<input type="email" class="form-control" placeholder="Email" required>
									</div>
									<div class="form-group">
										<input type="password" class="form-control" placeholder="Password" required>
									</div>
									<button type="submit" class="btn btn-success btn-block">Σύνδεση</button>
								</form>
								<p class="text-center m-t-xs text-sm">2015 &copy; icd.teicm.gr | Iordanidis Alexandros</p>
							</div>
						</div>
					</div><!-- Row -->
				</div><!-- Main Wrapper -->
			</div><!-- Page Inner -->
		</main><!-- Page Content -->

		<!-- Javascripts -->
		<script src="../assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
		<script src="../assets/plugins/pace-master/pace.min.js"></script>
		<script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
		<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../assets/plugins/switchery/switchery.min.js"></script>
		<script src="../assets/plugins/uniform/jquery.uniform.min.js"></script>
		<script src="../assets/plugins/offcanvasmenueffects/js/classie.js"></script>
		<script src="../assets/plugins/waves/waves.min.js"></script>
		<script src="../assets/js/modern.min.js"></script>
		
		<script>
			window.onload=function()
			{
				$("input:first").focus();
				
				$('body').on('hidden.bs.modal', '.modal', function () {
					$(this).removeData('bs.modal');
				});
				
				$("#login_form").submit(function (e) {
					e.preventDefault();
					
					$.ajax({
						type: "POST",
						url: "/login/check/",
						data: $('form#login_form').serialize(),
						dataType: 'json',
						success: function(msg){
							if (msg.hasOwnProperty('message'))
							{
								//TODO: να γινει swal
								alert(msg.message);
							}
							if (msg.hasOwnProperty('redirect'))
							{
								window.location.replace(msg.redirect);
							}
						},
						error: function() {
							//TODO: να γινει swal
							alert(failure);
						}
					});
				});
			}
		</script>

	</body>
</html>