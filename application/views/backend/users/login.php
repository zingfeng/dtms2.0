<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title>F6 CMS LOGIN </title>
	<!-- Bootstrap -->
	<link href="<?php echo $this->config->item("theme"); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?php echo $this->config->item("theme"); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="<?php echo $this->config->item("css"); ?>custom.css" rel="stylesheet">
</head>

<body style="background:#F7F7F7;">
	<div id="wrapper">
		<div id="login" class=" form">
			<section class="login_content">
				<form method="POST" action="">
					<h1>Login Form</h1>
					<?php if ($error_description) { ?>
						<p class="error" style="font-size: 13px;"><?php echo $error_description; ?> </p>
					<?php } ?>
					<div>
						<a class="btn btn-default" href="<?php echo $configOauth['site']; ?>/users/logout?redirect_uri=<?php echo $redirect_uri; ?>">Đăng nhập lại</a>
						<a class="reset_pass" href="<?php echo $configOauth['site']; ?>/users/forgotpass?redirect_uri=<?php echo $redirect_uri; ?>">Lost your password?</a>

					</div>
					<div class="clearfix"></div>
					<div class="separator">
						
						<p class="change_link">New to site?
							<a href="<?php echo $configOauth['site']; ?>/users/register?redirect_uri=<?php echo $redirect_uri; ?>" class="to_register"> Create Account </a>
						</p>
						<div class="clearfix"></div>
						<br />
						<div>
							<a href="http://f6.com.vn">
							<h1 style="font-size: 20px;">
								<i class="fa fa-paw"></i> F6 VIET NAM.,JSC
							</h1>
							</a>
							<p>©2015 All Rights Reserved. Version 1.0</p>
						</div>
					</div>
				</form>
			</section>
		</div>
	</div>
</body>
</html>