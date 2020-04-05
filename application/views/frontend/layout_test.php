<?php
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash(),
);
?>
<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<base href="/">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=yes">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-title" content="<?php echo $seo_keyword ?>" />
	<?php if ($meta) {
	foreach ($meta as $key => $value) {?>
			<meta name="<?php echo $key; ?>" content="<?php echo $value; ?>" />
		<?php }
}?>
	<?php if ($ogMeta) {
	foreach ($ogMeta as $key => $value) {?>
			<meta property="<?php echo $key; ?>" content="<?php echo $value; ?>" />
		<?php }
}?>
	<meta name="keywords" content="<?php echo $seo_keyword ?>">
	<meta name="description" content="<?php echo $seo_description ?>">
	<link rel="canonical" href="<?php echo BASE_URL ?>"/>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->config->item("img"); ?>favicon.ico">
	<title><?php echo $seo_title; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=vietnamese" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>fontAwesome/css/font-awesome.min.css" media="all" />
	<link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>bootstrap.min.css" media="all" />
	<link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>style.css" media="all" />
	<link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>customize.css" media="all" />
	<script type="text/javascript">
		SITE_URL = '<?php echo SITE_URL; ?>';
	</script>
	<script src="<?php echo $this->config->item("js"); ?>jquery-2.1.4.min.js"></script>
	<?php echo $this->config->item("tracking_code_header"); ?>
</head>

<body class="body_home listening-test">
	<!--HEADER-->
	<header id="header" class="section header">
		<a class="img_logo" href="<?php echo SITE_URL?>">
			<img style="height: 35px" class="logo_web" src="<?php echo $this->config->item("img"); ?>graphics/logo.png" alt="Trang chủ" data-was-processed="true">
		</a>
		<div class="btn_control_menu"><i class="fa fa-bars"></i></div>
		<div class="my_user">
            <?php if (!$this->permission->hasIdentity()) {?>
                <a class="login" href="<?php echo SITE_URL; ?>/users/login"><i class="fa fa-user"></i></a>
            <?php } else {?>
                <?php $profile = $this->permission->getIdentity(); ?>
                <!-- <a class="notification" href="javascript:;" onClick="showNotification()"><i class="fa fa-globe"></i><span></span></a> -->
                <a class="ava" href="javascript:;" onclick="showUserMenu()" style="width: 24px; height: 24px; float: left">
                    <img alt="" src="<?php echo $profile['avatar'] ?>">
                </a>
                <ul id="notificationMenu-mobile" class="user-menu" style="display: none;">
                    <li><a class="link-items" href="<?php echo SITE_URL.'/thong-tin-hoc-vien.html'; ?>"><i class="icon-truck"></i>Thông tin học viên</a></li>
                    <li><a class="link-items" href="<?php echo SITE_URL.'/thong-tin-ca-nhan.html'; ?>"><i class="icon-truck"></i>Thông tin cá nhân </a></li>
                    <li><a class="link-items" href="<?php echo SITE_URL.'/doi-mat-khau.html'; ?>"><i class="icon-plane"></i>Đổi mật khẩu </a></li>
                    <li><a class="link-items" href="<?php echo SITE_URL.'/users/logout'; ?>"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
                </ul>
            <?php } ?>    
        </div>
	</header>
	<!--END HEADER-->

	<?php echo $content_for_layout; ?>

	<div class="mask-content"></div>
	<!--MAIN MENU-->
	<?php echo $this->load->view('common/mobile_nav'); ?>
	<!--END MAIN MENU-->
	<a href="javascript:;" id="to_top"><i class="fa fa-long-arrow-up"></i></a>

	<!--<script src="<?php echo $this->config->item("js"); ?>owl.carousel.min.js"></script>-->
	<script src="<?php echo $this->config->item("js"); ?>bootstrap.min.js"></script>
	<script src="<?php echo $this->config->item("js"); ?>jquery.scrollbar.min.js"></script>
	<!--Owl slider lib-->
	<script type="text/javascript">
		function question_update_answer(position,value) {
			if (value) {
				$(".answer_recheck_item_" + position).addClass("circle_number_active")
			}
			else {
				$(".answer_recheck_item_" + position).removeClass("circle_number_active")
			}
		}
	</script>
	<link href="<?php echo $this->config->item("lib"); ?>/jplayer/css/jplayer-flat-audio-theme.css" rel="stylesheet">
	<script src="<?php echo $this->config->item("js"); ?>owl.carousel.min.js"></script>
	<script src="<?php echo $this->config->item("lib"); ?>/jplayer/js/jquery.jplayer.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item("lib"); ?>/jplayer/js/jplayer.playlist.min.js"></script>
	<script src="<?php echo $this->config->item("js"); ?>jquery.countdown.min.js"></script>
	<script src="<?php echo $this->config->item("js"); ?>colResizable-1.6.min.js"></script>
	<script src="<?php echo $this->config->item("js"); ?>common.js"></script>
	<script src="<?php echo $this->config->item("js"); ?>test.js"></script>
</body>

</html>
