<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

?>
<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=yes">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="<?php echo $seo_keyword ?>" />
    <?php if ($meta) {
	foreach ($meta as $key => $value) {?>
            <meta name="<?php echo $key; ?>" content="<?php echo strip_tags($value) ?>" />
        <?php }
    }?>
    <meta property="fb:app_id" content="<?php echo $this->config->item('facebook_app_id'); ?>" />
    <?php if ($this->config->item('facebook_app_admin')) {
        foreach ($this->config->item('facebook_app_admin') as $admin_id) {?>
            <meta property="fb:admins" content="<?php echo $admin_id?>"/>
        <?php }
    }?>
    <?php if ($ogMeta) {
	foreach ($ogMeta as $key => $value) {?>
            <meta property="<?php echo $key; ?>" content="<?php echo strip_tags($value) ?>" />
        <?php }
}?>
    <link rel="canonical" href="<?php echo current_url() ?>"/>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->config->item("img"); ?>favicon.ico">
    <title><?php echo $seo_title; ?> - Aland English</title>
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
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KHG6LFM');</script>
    <!-- End Google Tag Manager -->
</head>

<body class="body_home page-hv">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KHG6LFM"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!--HEADER-->
    <header id="header" class="section header">
        <a class="img_logo" href="<?php echo SITE_URL; ?>">
            <img class="logo_web" src="<?php echo $this->config->item("img"); ?>graphics/logo.png" alt="Trang chủ" data-was-processed="true">
        </a>
        <div class="btn_control_menu"><i class="fa fa-bars"></i></div>
        <div class="my_user">
            <a class="notification" href=""><i class="fa fa-globe"></i><span>2</span></a>
            <a class="login" href=""><i class="fa fa-user"></i></a>
            <a class="ava" href=""><img src="<?php echo $this->config->item("img"); ?>graphics/ava.png" alt="this"></a>
        </div>
    </header>
    <section class="my_taskbar">
        <div class="container">
          <div class="my_contact">
              <p><i class="fa fa-phone"></i>Hotline: <a style="color:#ff3333;font-weight:bold"><?php echo $this->config->item('hotline')?></a></p>
              <p class="email"><a><i class="fa fa-envelope-o"></i>support@aland.edu.vn</a></p>
          </div>
          <div class="my_user">
              <?php if (!$this->permission->hasIdentity()) {?>
                <a href="<?php echo SITE_URL; ?>/users/register">Đăng ký</a>
                <a class="login" href="<?php echo SITE_URL; ?>/users/login">Đăng nhập</a>
              <?php } else {?>
                <?php $profile = $this->permission->getIdentity(); ?>
                <a class="notification" href=""><i class="fa fa-globe"></i><span>2</span></a>                
                <div id="dd" class="wrapper-dropdown-3">
                    <a href="#" class="avatar-header">
                        <img alt="" src="<?php echo $profile['avatar'] ?>">
                    </a>

                    <span><strong>Hi</strong>, <?php echo $profile['fullname'] ?> </span>
                    <ul class="dropdown">
                        <li><a href="<?php echo SITE_URL.'/thong-tin-hoc-vien.html'; ?>"><i class="icon-truck"></i>Thông tin học viên</a></li>
                        <li><a href="<?php echo SITE_URL.'/thay-anh-dai-dien.html'; ?>"><i class="fa fa-picture-o"></i>Thông ảnh đại diện </a></li>
                        <li><a href="<?php echo SITE_URL.'/doi-mat-khau.html'; ?>"><i class="icon-plane"></i>Đổi mật khẩu </a></li>
                        <li><a href="<?php echo SITE_URL.'/users/logout'; ?>"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
                    </ul>
                </div>
              <?php }?>
          </div>
        </div>
    </section>
    <!--END HEADER-->
    <header class="pc_header">
        <div class="container">
            <a class="logo" href="<?php echo SITE_URL; ?>"><img src="<?php echo $this->config->item("img"); ?>graphics/logo.png" alt="this"></a>
            <div class="banner_top">
                  <?php echo $this->load->get_block('banner_top'); ?>
            </div>
        </div>
    </header>

    <?php echo $content_for_layout; ?>
    <!-- FOOTER -->
    <?php echo $this->load->view("common/footer"); ?>
    <div class="copyright section">
      <div class="container">
        <p>Trực thuộc công ty cổ phần giáo dục và đào tạo Imap Việt Nam</p>
        <div class="social">
            <a href=""><i class="fa fa-facebook"></i></a>
            <a href=""><i class="fa fa-google-plus"></i></a>
            <a href=""><i class="fa fa-youtube-play"></i></a>
        </div>
      </div>

    </div>
    <!--END FOOTER -->

    <div class="mask-content"></div>
    <?php echo $this->load->view('common/mobile_nav'); ?>
    <a href="javascript:;" id="to_top"><i class="fa fa-long-arrow-up"></i></a>
    <!--Jquery lib-->

    <script src="<?php echo $this->config->item("js"); ?>owl.carousel.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item("lib"); ?>jquery/jquery.validate.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>jquery.scrollbar.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>jquery.magnific-popup.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>common.js"></script>
    <!--Owl slider lib-->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2&appId=<?php echo $this->config->item('facebook_app_id'); ?>&autoLogAppEvents=1"></script>
</body>
</html>
