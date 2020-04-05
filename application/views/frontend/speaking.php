<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <base href="/">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=yes">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="description" content="nguyen nhu hung" >
    <meta name="keywords" content="Tin tức, hình ảnh, video clip, scandal sao Việt &amp; thế giới - Ngôi Sao">
    <title>ALAND IELTS</title>
    <link type="image/x-icon" href="http://ssl.gstatic.com/docs/doclist/images/infinite_arrow_favicon_5.ico" rel="shortcut icon"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
    <link rel="stylesheet" href="theme/frontend/default/css/fontAwesome/css/font-awesome.min.css" media="all" />
    <link rel="stylesheet" href="theme/frontend/default/css/bootstrap.min.css" media="all" />
    <link rel="stylesheet" href="theme/frontend/default/css/style.css" media="all" />
    <link rel="stylesheet" type="text/css" href="theme/frontend/default/css/style_record.css">

</head>

<body class="body_home listening-test vertical">
<div style="    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    z-index: 1000;
    background-color: #7ac17d;
    padding: 10px;">
    <div>
        <button onclick="GetListMp3File()" class="btn btn-info">Touch Me</button>
    </div>

    <div id="controls">
        <button id="recordButton">Record</button>
        <button id="pauseButton" disabled>Pause</button>
        <button id="stopButton" disabled>Stop</button>
    </div>
    <div id="formats">Format: start recording to see sample rate</div>
    <h3>Recordings</h3>
    <ol id="recordingListready"></ol>


</div>
<!--HEADER-->
<header id="header" class="section header">
    <a class="img_logo" href="">
        <img class="logo_web" src="theme/frontend/default/images/graphics/logo.png" alt="Trang chủ" data-was-processed="true">
    </a>
    <div class="btn_control_menu"><i class="fa fa-bars"></i></div>
    <div class="my_user">
        <a class="notification" href=""><i class="fa fa-globe"></i><span>2</span></a>
        <a class="login" href=""><i class="fa fa-user"></i></a>
        <a class="ava" href=""><img src="theme/frontend/default/images/graphics/ava.png" alt="this"></a>
    </div>
</header>
<!--END HEADER-->
<section class="listening-test_head clearfix">
    <div class="container">
        <a class="img_logo" href="">
            <img class="logo_web" src="theme/frontend/default/images/graphics/logo.png" alt="Trang chủ" data-was-processed="true">
        </a>
        <div class="select_sever">
            <a href="">Part 1</a>
            <a href="">Part 2</a>
            <a href="">Part 3</a>
        </div>
        <div class="option_listening">
            <div class="timer"><i class="fa fa-clock-o"></i>22:20</div>
            <a class="nop_bai" href="">Nộp bài</a>
            <select id="show_test">
                <option>Show Test Info</option>
                <option>Show Test Info</option>
            </select>
        </div>
    </div>
</section>


<section class="listening-test_container speaking-test clearfix">
    <div class="fillter-mobile">
        <a href="">
            <img class="img2" src="theme/frontend/default/images/icons/icon-book1.png" alt="">
            <img class="img4" src="theme/frontend/default/images/icons/icon-book.png" alt="">
        </a>
        <a href="">
            <img class="img2" src="theme/frontend/default/images/icons/icon-headphone1.png" alt="">
            <img class="img4" src="theme/frontend/default/images/icons/icon-headphone.png" alt="">
        </a>
        <a href="">
            <img class="img2" src="theme/frontend/default/images/icons/icon-pencil1.png" alt="">
            <img class="img4" src="theme/frontend/default/images/icons/icon-pencil.png" alt="">
        </a>
        <a class="active" href="">
            <img class="img2" src="theme/frontend/default/images/icons/icon-microphone1.png" alt="">
            <img class="img4" src="theme/frontend/default/images/icons/icon-microphone.png" alt="">
        </a>
    </div>
    <div class="container warp_slidebar">
        <div class="fillter-test">
            <a class="on" href="javascript:;"><i class="fa fa-backward"></i></a>
            <ul>
                <h4>FULL TEST</h4>
                <li class="reading">
                    <a href="">
                        <img src="theme/frontend/default/images/icons/book1.png" alt="">
                        <img class="img2" src="theme/frontend/default/images/icons/icon-book1.png" alt="">
                        <img class="img3" src="theme/frontend/default/images/icons/book.png" alt="">
                        <img class="img4" src="theme/frontend/default/images/icons/icon-book.png" alt="">
                        <span>reading</span>
                    </a>
                </li>
                <li class="listening">
                    <a href="">
                        <img src="theme/frontend/default/images/icons/headphone1.png" alt="">
                        <img class="img2" src="theme/frontend/default/images/icons/icon-headphone1.png" alt="">
                        <img class="img3" src="theme/frontend/default/images/icons/headphone.png" alt="">
                        <img class="img4" src="theme/frontend/default/images/icons/icon-headphone.png" alt="">
                        <span>listening</span>
                    </a>
                </li>
                <li class="writing">
                    <a href="">
                        <img src="theme/frontend/default/images/icons/pencil1.png" alt="">
                        <img class="img2" src="theme/frontend/default/images/icons/icon-pencil1.png" alt="">
                        <img class="img3" src="theme/frontend/default/images/icons/pencil.png" alt="">
                        <img class="img4" src="theme/frontend/default/images/icons/icon-pencil.png" alt="">
                        <span>writing</span>
                    </a>
                </li>
                <li class="speaking">
                    <a class="active" href="">
                        <img src="theme/frontend/default/images/icons/microphone1.png" alt="">
                        <img class="img2" src="theme/frontend/default/images/icons/icon-microphone1.png" alt="">
                        <img class="img3" src="theme/frontend/default/images/icons/microphone.png" alt="">
                        <img class="img4" src="theme/frontend/default/images/icons/icon-microphone.png" alt="">
                        <span>speaking</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="slidebar_2">
            <div class="warp_content">
                <div class="huong_dan">
                    <a class="title" href="javascript:;" data-toggle="collapse" data-target="#huong_dan"><i class="fa fa-exclamation-circle"></i>Hướng dẫn làm bài</a>
                    <div id="huong_dan" class="collapse">
                        <div class="warp">
                            Windows 7 hiện nay vẫn là một trong những hệ điều hành được sử dụng rộng rãi trong các môi trường làm việc cũng như học tập trên toàn thế giới. Việc sử dụng Win 7 đã trở thành thói quen mặc dù đã có những hệ điều hành mới hơn được phát triển như Win 8 và Win 8.1. Việc sử dụng Win 7 đã trở thành thói quen đã trở thành thói quen mặc dù đã có những hệ điều hành mới hơn được phát triển như Win 8 và Win 8.1. Việcđã trở thành thói quen mặc dù đã có những hệ điều hành mới hơn được phát triển như Win 8 và Win 8.1. Việcđã trở thành thói quen mặc dù đã có những hệ điều hành mới hơn được phát triển như Win 8 và Win 8.1.
                        </div>
                    </div>
                </div>
                <h2>Part 1</h2>
                <ul class="list_speaking">
                    <li>
                        <label>Question 1</label>
                        <div class="speaking_right">
                            <h3 class="tapescript" href="">
                                <a>Bấm để mở Tapescript</a>
                                <span>What’s the weather like in your country?</span>
                            </h3>
                            <a class="icon_speaking icon_speaking_record" href="javascript:void(0);" id_question="1" id="a_speaking1">
                                <img src="theme/frontend/default/images/icons/icon-speaking.png" id="img_speaking1">
                                <span id="span_speaking1">click để làm bài</span>
                            </a>
                            <a class="icon_speaking icon_speaking_pause" href="javascript:void(0);"  id_question="1" id="a_speaking_pause1" style="display: none;">
                                <img src="theme/frontend/default/images/icons/icon-speaking.png">
                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                <span id="span_speaking_pause1">Pause</span>
                            </a>
                            <a class="icon_speaking icon_speaking_finish" href="javascript:void(0);"  id_question="1" id="a_speaking_finish1"  style="display: none;">
                                <img src="theme/frontend/default/images/icons/icon-speaking.png">
                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                <span>Finish</span>
                            </a>
                            <div class="recordingList"  id="recordingList1" file_url="" ></div>

                        </div>
                    </li>
                    <li class="true">
                        <label>Question 2</label>
                        <div class="speaking_right">
                            <h3 class="tapescript" href="">
                                <a>Bấm để mở Tapescript</a>
                                <span>What’s the weather like in your country?</span>
                            </h3>

                            <a class="icon_speaking icon_speaking_record" href="javascript:void(0);" id_question="2" id="a_speaking2">
                                <img src="theme/frontend/default/images/icons/icon-speaking.png" id="img_speaking2">
                                <span id="span_speaking2">click để làm bài</span>
                            </a>
                            <a class="icon_speaking icon_speaking_pause" href="javascript:void(0);"  id_question="2" id="a_speaking_pause2" style="display: none;">
                                <img src="theme/frontend/default/images/icons/icon-speaking.png">
                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                <span id="span_speaking_pause2">Pause</span>
                            </a>
                            <a class="icon_speaking icon_speaking_finish" href="javascript:void(0);"  id_question="2" id="a_speaking_finish2"  style="display: none;">
                                <img src="theme/frontend/default/images/icons/icon-speaking.png">
                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                <span>Finish</span>
                            </a>
                            <div class="recordingList"  id="recordingList2" file_url="" ></div>

                        </div>
                    </li>
                    <li>
                        <label>Question 3</label>
                        <div class="speaking_right">
                            <h3 class="tapescript" href="">
                                <a>Bấm để mở Tapescript</a>
                                <span>What’s the weather like in your country?</span>
                            </h3>
                            <a class="icon_speaking icon_speaking_record" href="javascript:void(0);" id_question="3" id="a_speaking3">
                                <img src="theme/frontend/default/images/icons/icon-speaking.png" id="img_speaking3">
                                <span id="span_speaking3">click để làm bài</span>
                            </a>
                            <a class="icon_speaking icon_speaking_pause" href="javascript:void(0);"  id_question="3" id="a_speaking_pause3" style="display: none;">
                                <img src="theme/frontend/default/images/icons/icon-speaking.png">
                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                <span id="span_speaking_pause3">Pause</span>
                            </a>
                            <a class="icon_speaking icon_speaking_finish" href="javascript:void(0);"  id_question="3" id="a_speaking_finish3"  style="display: none;">
                                <img src="theme/frontend/default/images/icons/icon-speaking.png">
                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                <span>Finish</span>
                            </a>
                            <div class="recordingList" id="recordingList3" file_url="" ></div>
                        </div>
                    </li>
                    <li>
<!--                        <label>Question 4</label>-->
<!--                        <div class="speaking_right">-->
<!--                            <h3 class="tapescript" href="">-->
<!--                                <a>Bấm để mở Tapescript</a>-->
<!--                                <span>What’s the weather like in your country?</span>-->
<!--                            </h3>-->
<!--                            <a class="icon_speaking" href=""  id_question="4">-->
<!--                                <img src="theme/frontend/default/images/icons/icon-speaking.png">-->
<!--                                <span>< click để làm bài</span>-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <label>Question 5</label>-->
<!--                        <div class="speaking_right">-->
<!--                            <h3 class="tapescript" href="">-->
<!--                                <a>Bấm để mở Tapescript</a>-->
<!--                                <span>What’s the weather like in your country?</span>-->
<!--                            </h3>-->
<!--                            <a class="icon_speaking" href="">-->
<!--                                <img src="theme/frontend/default/images/icons/icon-speaking.png">-->
<!--                                <span>< click để làm bài</span>-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <label>Question 6</label>-->
<!--                        <div class="speaking_right">-->
<!--                            <h3 class="tapescript" href="">-->
<!--                                <a>Bấm để mở Tapescript</a>-->
<!--                                <span>What’s the weather like in your country?</span>-->
<!--                            </h3>-->
<!--                            <a class="icon_speaking" href="">-->
<!--                                <img src="theme/frontend/default/images/icons/icon-speaking.png">-->
<!--                                <span>< click để làm bài</span>-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </li>-->

                </ul>
                <h2>Part 2</h2>
                <div class="speaking_document">
                    <div class="warp">
                        <p>You should spend about <strong>20 minutes</strong> on this task.</p>
                        <p><strong>The graphs below show the enrolments of overseas students and local students in Australian universities over a ten year period. Summarise the information by selecting and reporting the main features, and make comparisons where relevant.</strong></p>
                        <p>You should write at least <strong>150 words</strong></p>
                    </div>
                    <div class="controler">
                        <div class="td">
                            <span>Thời gian chuẩn bị</span>
                            <div class="timer">
                                <img src="theme/frontend/default/images/icons/clock.png">
                                <span>00:60</span>
                            </div>
                        </div>
                        <div class="td right">
                            <span>Thời gian trả lời</span>
                            <div class="timer">
                                <img src="theme/frontend/default/images/icons/clock.png">
                                <span>00:60</span>
                            </div>
                        </div>
                        <a href="" class="start">
                            <img src="theme/frontend/default/images/icons/icon-speaking.png">
                            <i class="fa fa-angle-double-up"></i>
                            <span>Click để làm bài</span>
                        </a>
                    </div>
                </div>
                <div class="speaking_note">
                    <span class="gim"><img src="theme/frontend/default/images/icons/gim.png"></span>
                    <textarea class="input_form input_area" onblur="if(this.value=='') this.value=this.defaultValue" onfocus="if(this.value==this.defaultValue) this.value=''" placeholder="Answer..."></textarea>
                </div>
                <h2>Part 3&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></h2>
            </div>
        </div>
    </div>
</section>

<div class="mask-content"></div>

<!--MAIN MENU-->
<nav id="main_menu" class="main_menu">
    <div class="header_menu section">
        <span id="auto_close_left_menu_button" class="close_main_menu">×</span>
        <div class="my_contact">
            <p><i class="fa fa-phone"></i><a style="color:#ff3333;font-weight:bold">0987 915 448</a></p>
            <p class="email"><a><i class="fa fa-envelope-o"></i>support@aland.edu.vn</a></p>
        </div>
    </div>
    <div class="block_scoll_menu section">
        <div class="block_search section">
            <form id="search" action="http://timkiem.MSN.net/" method="get">
                <div class="warp">
                    <input id="auto_search_textbox" maxlength="80" name="q" class="input_form" placeholder="Tìm kiếm" type="search">
                    <button type="submit" id="btn_search_ns" class="btn_search"><i class="fa fa-search"></i></button>
                    <button type="reset" class="btn_reset">×</button>
                </div>
            </form>
        </div>
        <div class="list_menu section" id="auto_footer_menu">
            <ul class="list_item_panel section" id="auto_footer_first_list">
                <li>
                    <a href="https://www.google.com/" class="link_item_panel">About us</a>
                    <span class="sub-icon">+</span>
                    <ul class="level2">
                        <li>
                            <a href="">About us 1</a>
                            <span class="sub-icon2">+</span>
                            <ul class="level3">
                                <li>
                                    <a href="">About us 2</a>
                                </li>
                                <li>
                                    <a href="">About us 2</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="">About us 1</a>
                        </li>
                        <li>
                            <a href="">About us 1</a>
                        </li>
                    </ul>
                </li>
                <li><a href="#" class="link_item_panel">IELTS Online</a></li>
                <li><a href="#" class="link_item_panel">Lịch khai giảng</a></li>
                <li><a href="#" class="link_item_panel">IELTS Test</a></li>
                <li><a href="#" class="link_item_panel">Lộ trình học</a></li>
                <li><a href="#" class="link_item_panel">Tuyển dụng</a></li>
            </ul>
        </div>
        <div class="footer_bottom">
            <div class="bold_text_top width_common"><h3>Học tiếng anh trực tuyến<br>© 2018 aland.net</h3>
                <p>Trực thuộc công ty cổ phần giáo dục và đào tạo Imap Việt Nam</p>
                <div class="social">
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-youtube-play"></i></a>
                </div>
            </div>
        </div>
    </div>
</nav>
<!--END MAIN MENU-->
<a href="javascript:;" id="to_top"><i class="fa fa-long-arrow-up"></i></a>
<!--Jquery lib-->
<script src="theme/frontend/default/js/jquery-2.1.4.min.js"></script>
<script src="theme/frontend/default/js/owl.carousel.min.js"></script>
<script src="theme/frontend/default/js/bootstrap.min.js"></script>
<script src="theme/frontend/default/js/jquery.scrollbar.min.js"></script>
<script src="theme/frontend/default/js/common.js"></script>
<script src="theme/frontend/default/js/recorder.js"></script>
<script src="theme/frontend/default/js/app.js"></script>
<!--Owl slider lib-->
<script type="text/javascript">
    $(function(){
        jQuery('.scrollbar-inner').scrollbar();
    });


</script>
</body>
</html>
