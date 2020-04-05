<?php
header('Access-Control-Allow-Origin: *');

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

?>
<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php        // SEO support ||
    if ($noindex || (trim(strtolower($this->uri->segment(1))) == 'users') || (trim(strtolower($this->uri->segment(1))) == 'tim-kiem.html'))
    {
//             echo trim(strtolower($this->uri->segment(1)));
        echo '<meta name="robots" content="noindex, follow">';
    }else{
        echo '<meta name="robots" content="index, follow">';
    }?>
    <meta property="og:locale" content="vi_VN" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=yes">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="<?php echo $seo_keyword ?>" />
    <?php if ($meta) {
	foreach ($meta as $key => $value) {?>
            <meta name="<?php echo $key; ?>" content="<?php echo strip_tags($value) ?>" />
        <?php }
    }?>
    <!-- <link rel="canonical" href="https://www.aland.edu.vn<?php echo str_replace('/index.php','',$_SERVER['PHP_SELF']);?>" /> -->

    <meta property="og:site_name" content="Aland" />
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
    <title><?php echo $seo_title; ?> - Aland IELTS</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>fontAwesome/css/font-awesome.min.css" media="all" />
    <link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>bootstrap.min.css" media="all" />
    <link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>customize.css" media="all" />
    <link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>style.css" media="all" />
    <script type="text/javascript">
        SITE_URL = '<?php echo SITE_URL; ?>';
    </script>
    <script src="<?php echo $this->config->item("js"); ?>jquery-2.1.4.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>comment.js"></script>
    <?php echo $this->config->item("tracking_code_header"); ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KHG6LFM');</script>
    <!-- End Google Tag Manager -->
    <style>
        [contenteditable=true]:empty:before{
            content: attr(placeholder);
            display: block; /* For Firefox */
        }
        ::placeholder {
            color: #9DA7B1;
            color: red;
        }

        li.menu_comment{
            list-style-type: none !important;
            padding: 0 !important;
        }
        ul.dropdown-comment-option{
            padding-left: 0;
        }

        .detail_tin .noi_dung ul li{
            list-style: initial;
            padding: 0;
        }
        .detail_tin .noi_dung ul li a{
            color: #0000FF;
        }
    </style>
</head>

<body class="body_home">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KHG6LFM"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!--HEADER-->
    <header id="header" class="section header">
        <a class="img_logo" href="<?php echo SITE_URL; ?>">
            <img class="logo_web" src="<?php echo $this->config->item("img"); ?>graphics/logo2.png" alt="Trang chủ" data-was-processed="true" style="height: 35px; ">
        </a>
        <div class="btn_control_menu"><i class="fa fa-bars"></i></div>
        <div class="my_user">
            <?php if (!$this->permission->hasIdentity()) {?>
                <a class="login" href="<?php echo SITE_URL; ?>/users/login"><i class="fa fa-user"></i></a>
            <?php } else {?>
                <?php $profile = $this->permission->getIdentity(); ?>
                <!-- <a class="notification" href="javascript:;" onClick="showNotification()"><i class="fa fa-globe"></i><span></span></a> -->
                <a class="ava" href="javascript:;" onclick="showUserMenu()" style="width: 24px; height: 24px; float: left; ">
                    <img alt="" src="<?php echo $profile['avatar'] ?>">
                </a>
                <ul id="notificationMenu-mobile" class="user-menu">
                    <li><a class="link-items" href="<?php echo SITE_URL.'/thong-tin-hoc-vien.html'; ?>"><i class="icon-truck"></i>Thông tin học viên</a></li>
                    <li><a class="link-items" href="<?php echo SITE_URL.'/thong-tin-ca-nhan.html'; ?>"><i class="icon-truck"></i>Thông tin cá nhân </a></li>
                    <li><a class="link-items" href="<?php echo SITE_URL.'/doi-mat-khau.html'; ?>"><i class="icon-plane"></i>Đổi mật khẩu </a></li>
                    <li><a class="link-items" href="<?php echo SITE_URL.'/users/logout'; ?>"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
                </ul>
            <?php } ?>    
        </div>
    </header>

    <section class="my_taskbar">
        <div class="container">
          <div class="my_contact">
              <p><i class="fa fa-phone"></i>Hotline: <a style="color:#ff3333;font-weight:bold"><?php echo $this->config->item('hotline')?></a></p>
              <p class="email"><a><i class="fa fa-envelope-o"></i><?php echo $this->config->item('email_support')?></a></p>
          </div>
          <div class="my_user">
              <?php if (!$this->permission->hasIdentity()) {?>
                <a href="<?php echo SITE_URL; ?>/users/register">Đăng ký</a>
                <a class="login" href="<?php echo SITE_URL; ?>/users/login">Đăng nhập</a>
              <?php } else {?>
                <?php $profile = $this->permission->getIdentity(); ?>
<!--                <a class="notification" href=""><i class="fa fa-globe"></i><span>2</span></a>                -->
                  <a class="notification" onClick="showNotification()"><i class="fa fa-globe"></i><span id="number_noti">0</span></a>
                  <ul id="notificationMenu" class="notifications">
                      <li class="titlebar">
                          <span class="title">Thông báo</span>
                          <span class="settings"><i class="icon-cog"></i>
                    </span>
                      </li>
                      <div class="notifbox" id="div_notifbox" style="min-height: 50px;">
                      </div>
                      <li class="seeall">
                          <a>Xem tất cả</a>
                      </li>
                  </ul>
<!--                  ====-->
                  <div id="dd" class="wrapper-dropdown-3">
                      <a href="#" class="avatar-header">
                          <img alt="" src="<?php echo $profile['avatar'] ?>">
                      </a>
                    <span><strong>Hi</strong>, <?php echo $profile['fullname'] ?> </span>
                    <ul class="dropdown">
                        <li><a href="<?php echo SITE_URL.'/thong-tin-hoc-vien.html'; ?>"><i class="icon-truck"></i>Thông tin học viên</a></li>
                        <li><a href="<?php echo SITE_URL.'/thong-tin-ca-nhan.html'; ?>"><i class="icon-truck"></i>Thông tin cá nhân </a></li>
                        <li><a href="<?php echo SITE_URL.'/thay-anh-dai-dien.html'; ?>"><i class="icon-truck"></i>Thay ảnh đại diện </a></li>
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
            <a class="logo" href="<?php echo SITE_URL; ?>" style="margin: 0px"><img src="<?php echo $this->config->item("img"); ?>graphics/logo2.png" alt="this"></a>
            <div class="banner_top">

                  <?php echo $this->load->get_block('banner_top'); ?>
            </div>
        </div>
    </header>
    <!--MENU MANIN PC-->
    <?php echo $this->load->get_block('top'); ?>
    <!--MENU MANIN PC-->

    <?php echo $content_for_layout; ?>
    <!-- FOOTER -->
    <?php echo $this->load->view("common/footer"); ?>
    <div class="copyright section">
      <div class="container">
        <p>Trực thuộc công ty cổ phần giáo dục và đào tạo Imap Việt Nam</p>
        <div class="social">
            <a href="<?php echo $this->config->item('facebook')?>"><i class="fa fa-facebook"></i></a>
            <a href="<?php echo $this->config->item('google')?>"><i class="fa fa-google-plus"></i></a>
            <a href="<?php echo $this->config->item('youtube')?>"><i class="fa fa-youtube-play"></i></a>
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
    <script src="<?php echo $this->config->item("js"); ?>common.js"></script>
    <!--Owl slider lib-->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2&appId=<?php echo $this->config->item('facebook_app_id'); ?>&autoLogAppEvents=1"></script>

    <script>
        var sload = {
            domain: [], // list
            load: function (domain) {
                // Cập nhật danh sách domain
                sload.domain = domain;

                $("img").error(function () {
                    var list_domain = sload.domain;
                    try {
                        // List tried
                        var attr = $(this).attr('sload-tried');
                        if ( (typeof attr === 'undefined') || ( attr === false) ) {
                            $(this).attr('sload-tried','');
                        }
                        var tried =  $(this).attr('sload-tried');
                        var src = $(this).attr("src");
                        var arr = src.split("/");

                        var fail_domain = arr[0] + "//" + arr[2];

                        var uri = src.replace(fail_domain,'');
                        console.log("uri");
                        console.log(uri);

                        var list_fail_domain = tried + ' ' + fail_domain;
                        $(this).attr('sload-tried', list_fail_domain);

                        var tried_all = true;
                        for (var i = 0; i < list_domain.length; i++) {
                            var domain = list_domain[i];
                            if (! list_fail_domain.includes(domain)){
                                $(this).attr("src", domain + uri);
                                tried_all = false;
                                break;
                            }
                        }
                        if (tried_all){
                            $(this).removeClass('sload');
                            $(this).addClass('sload-finish');
                        }
                    } catch (err) {
                        console.log(err.message);
                    }

                });
            },
        };

        $(document).ready(function () {
            sload.load(['https://www.aland.edu.vn', 'https://static1.aland.edu.vn', 'https://static2.aland.edu.vn']);
        });

        $( document ).ready(function() {
            $( "span.phone" ).bind( "click", function(event) {
                var obj = event.target;
                var content = obj.innerHTML;
                callPhoneText(content);
            });
        });

        function callPhoneText(content){
            content = content.replace('s','');
            content = content.replace('S','');
            content = content.replace('ố','');
            content = content.replace('Ố','');
            content = content.replace('ô','');
            content = content.replace('Ô','');
            content = content.replace('Đ','');
            content = content.replace('đ','');
            content = content.replace('T','');
            content = content.replace('t','');
            content = content.replace(':','');
            content = content.replace(' ','');

            callPhone(content);
        }

        function callPhone(phone_number){
            // alert(phone_number);
            var id = makeid(10);
            // style="display:none"
            var content = '<a href="tel:' + phone_number+'" id="' + id + '"  >__</a>';
            $( "body" ).append( content );
            $('#' + id).click();
        }

        function makeid(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

    </script>
</body>
</html>
