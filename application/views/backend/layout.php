<?php 
	$oauthConfig = $this->config->item("web4u_oauth"); 
	$userProfile = $this->permission->getIdentity();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?php echo $title; ?></title>
	<!-- Bootstrap -->
	<link href="<?php echo $this->config->item("theme"); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?php echo $this->config->item("theme"); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- Jquery confirm -->
	<link href="<?php echo $this->config->item("theme"); ?>vendors/jquery-confirm/jquery-confirm.min.css" rel="stylesheet">
	<!-- CSS for form -->
	<link href="<?php echo $this->config->item("theme"); ?>vendors/jquery-datetimepicker/jquery.datetimepicker.min.css" rel="stylesheet">
	<?php if ($isForm) { ?>
	<link href="<?php echo $this->config->item("theme"); ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<link href="<?php echo $this->config->item("theme"); ?>vendors/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet">
	
	<!--<link href="< ?php echo $this->config->item("theme"); ?>vendors/fancyBox/jquery.fancybox.css" rel="stylesheet">-->
	<?php } ?>
	<?php if (isset($isLists)) { ?>
	<!-- iCheck -->
    <link href="<?php echo $this->config->item("theme"); ?>vendors/iCheck/skins/square/_all.css" rel="stylesheet">
	<?php } ?>
	
	<link href="<?php echo $this->config->item("theme"); ?>vendors/pnotify/dist/pnotify.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="<?php echo $this->config->item("css"); ?>custom.css" rel="stylesheet">
	<!-- jQuery -->
	<script src="<?php echo $this->config->item("theme"); ?>vendors/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript">
		SITE_URL = '<?php echo SITE_URL; ?>';
		UPLOAD_URL = '<?php echo UPLOAD_URL; ?>';
		THEME_URL = '<?php echo $this->config->item("theme"); ?>';
	</script>
	<meta name="web4u:app_id" content="<?php echo $oauthConfig['client_id']; ?>">
</head>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="http://f6.com.vn" class="site_title" title="Thiết kê website chuyên nghiệp"><i class="fa fa-paw"></i> <span>F6 CMS</span></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<div class="profile">
						<div class="profile_pic">
							<img src="<?php echo $this->config->item("img"); ?>user.png" alt="..." class="img-circle profile_img">
						</div>
						<div class="profile_info">
							<span>Welcome,</span>
							<h2><?php echo $userProfile['fullname']; ?></h2>
						</div>
					</div>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<?php echo $this->load->view('common/menu'); ?>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->
					<div class="sidebar-footer hidden-small">
						<a data-toggle="tooltip" data-placement="top" title="Settings">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="FullScreen">
							<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Lock">
							<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
						</a>
						<a href="<?php echo SITE_URL; ?>/users/logout" data-toggle="tooltip" data-placement="top" title="Logout">
							<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
						</a>
					</div>
					<!-- /menu footer buttons -->
				</div>
			</div>

			<!-- top navigation -->
			<div class="top_nav">

				<div class="nav_menu">
					<nav class="" role="navigation">
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						</div>

						<ul class="nav navbar-nav navbar-right">
							<li class="">
								<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<img src="<?php echo $this->config->item("img"); ?>user.png" alt=""><?php echo $this->session->userdata('fullname'); ?>
									<span class=" fa fa-angle-down"></span>
								</a>
								<ul class="dropdown-menu dropdown-usermenu pull-right">
									<li><a href="<?php echo $oauthConfig['site']; ?>/users/profile">  Profile</a>
									</li>
									<li><a href="<?php echo $oauthConfig['site']; ?>/users/changepass">  Đổi mật khẩu</a>
									</li>
									<li>
										<a href="javascript:;">
											<!--<span class="badge bg-red pull-right">50%</span>-->
											<span>Settings</span>
										</a>
									</li>
									<li>
										<a href="http://f6.com.vn/help.html">Help</a>
									</li>
									<li><a href="<?php echo SITE_URL; ?>/users/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
									</li>
								</ul>
							</li>

							<!--<li role="presentation" class="dropdown">
								<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-envelope-o"></i>
									<span class="badge bg-green">6</span>
								</a>
								<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
									<li>
										<a>
											<span class="image">
												<img src="user.png" alt="Profile Image" />
											</span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were where...
											</span>
										</a>
									</li>
									<li>
										<div class="text-center">
											<a href="inbox.html">
												<strong>See All Alerts</strong>
												<i class="fa fa-angle-right"></i>
											</a>
										</div>
									</li>
								</ul>
							</li>-->

						</ul>
					</nav>
				</div>
				<div class="clearfix"></div>
			</div>
			<!-- /top navigation -->


			<!-- page content -->
			<div class="right_col" id="content_for_layout" role="main">
				<?php echo $content_for_layout; ?>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<footer>
				<div class="pull-right">
					<a href="http://f6.com.vn">Power by F6 Vietnam., JSC - Version 2.0</a>
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
	</div>
	<!--VIMEO-->
    <script src="<?php echo $this->config->item("theme"); ?>vendors/vimeoapi/vimeo-upload.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo $this->config->item("theme"); ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?php echo $this->config->item("theme"); ?>vendors/jquery-datetimepicker/jquery.datetimepicker.full.min.js"></script>
	<!-- Select 2 form -->
	<?php if ($isForm) { ?>
	<script src="<?php echo $this->config->item("theme"); ?>vendors/select2/dist/js/select2.full.min.js"></script>
	<!-- jQuery Tags Input -->
    <script src="<?php echo $this->config->item("theme"); ?>vendors/jquery.tagsinput/jquery.tagsinput.js"></script>
    <!-- FANCYBOX -->
    <!--<script src="< ?php echo $this->config->item("theme"); ?>vendors/fancyBox/jquery.fancybox.pack.js"></script>-->
	<!-- CKEDITOR -->
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/3rd/ckeditor/ckeditor.js"></script>
	<?php } ?>
	<?php if (isset($isLists)) { ?>
	<!-- iCheck -->
	<script src="<?php echo $this->config->item("theme"); ?>vendors/checkboxes/jquery.checkboxes.min.js"></script>
    <script src="<?php echo $this->config->item("theme"); ?>vendors/iCheck/icheck.min.js"></script>
    <?php } ?>
    <script src="<?php echo $this->config->item("theme"); ?>vendors/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
    <!-- pnotify -->
	<script src="<?php echo $this->config->item("theme"); ?>vendors/jquery-confirm/jquery-confirm.min.js"></script>
	<!-- Jquery confirm -->
	<script src="<?php echo $this->config->item("theme"); ?>vendors/pnotify/dist/pnotify.js"></script>
	<!-- Custom Theme Scripts -->
	<!--<script src="<?php echo $this->config->item("js"); ?>custom.full.js"></script>-->
	<script src="<?php echo $this->config->item("js"); ?>custom.full.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		<?php if ($isForm) { ?>
		form_script();
		<?php } ?>
		<?php if ($isLists) { ?>
		lists_script();
		<?php } ?>
	});
	</script>
</body>
</html>