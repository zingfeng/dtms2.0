<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$question = $arrQuestion[0];
?>
<header class="header">
    <nav class="row navigation-top">
        <div class="container">
            <div class="row">

                <?php echo $this->load->view('test/common/home');?>

                <button class="navbar-toggler navigation-top__button-collapse" type="button"
                        data-toggle="collapse" data-target="#navbarTogglerTop" aria-controls="navbarTogglerTop"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="col-8 navigation-top__menu-collapse" id="navbarTogglerTop">
                    <div class="select_sever" id="select_sever">
                    <ul class="menu">
                        <li class="nav-item">
                            <a class="nav-link -custom-color-link" href="#" onclick="goback() ">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            </a>
                        </li>
                        <?php if($arrQuestionGroup) { ?>

                                <?php
                                $i = 1; $time = 0;
//                                var_dump($arrQuestionGroup); exit;
                                foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) {?>

<!--                                    <a onclick="SelectPart(--><?php //echo $i; ?><!--)" data-section="<?php //echo $qgroup['question_id']; ?>"-->
<!--                                       id="question_setion_selection_--><?php //echo $qgroup['question_id']; ?><!--"-->
<!--                                       class="reading_change_section --><?php //if ($i == 1) echo 'active'; ?><!--"-->
<!--                                       href="javascript:void(0)">--><?php //echo $qgroup['title']; ?><!--</a>-->

                                    <li class="nav-item">
                                        <a class="nav-link menu-link -custom-color-link  <?php if ($i == 1) echo '-active'; ?>" href="javascript:void(0)" data-section="<?php echo $qgroup['question_id']; ?>"
                                           id="question_setion_selection_<?php echo $qgroup['question_id']; ?>"
                                           onclick="SelectPart(<?php echo $i; ?>,event)"><?php echo $qgroup['title']; ?></a>
                                    </li>

                                    <?php $i ++;
                                }
                                $test_time = $question['test_time'] * 60 * 1000;
                                ?>

                        <?php } ?>


<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link menu-link -custom-color-link" href="#"-->
<!--                               onclick="onClickTabMenu()">Section 1</a>-->
<!--                        </li>-->
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link menu-link -custom-color-link" href="#"-->
<!--                               onclick="onClickTabMenu()">Section 2</a>-->
<!--                        </li>-->
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link menu-link -custom-color-link" href="#"-->
<!--                               onclick="onClickTabMenu()">Section 3</a>-->
<!--                        </li>-->
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link menu-link -custom-color-link" href="#"-->
<!--                               onclick="onClickTabMenu()">Section 4</a>-->
<!--                        </li>-->
                    </ul>
                    </div>
                </div>

                <?php echo $this->load->view('test/common/account');?>
            </div>

    </nav>

    <div class="technical_box" style="display: none">
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
</header>

<section class="section-breadcrumb margin-navbar">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="custom-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>
</section>

<!--    ======================================================================== -->
<!--    ======================================================================== -->
<!--    ======================================================================== -->
<!--    ======================================================================== -->




<section class="test-speaking">
    <div class="container background-test">
        <div class="row">
            <div class="col group-test text-center">
                <div class="group-test__title">
<!--                    IELTS Recent Actual Test With Answers (Vol 6)-->
                    <?php echo $cateDetail['name']; ?>
                </div>
                <div class="group-test__subtitle">
<!--                    LISTENING PRACTICE TEST 1-->
                    <?php echo $test['title']; ?>
                </div>
                <div class="group-test__custom-border-bottom"></div>
            </div>
        </div>
        <div class="user_guide">
            <a data-toggle="collapse" href="#user_guide_content_speaking" role="button" aria-expanded="false" aria-controls="collapseExample">
                <div class="user_guide_title">Hướng dẫn làm bài</div>
            </a>

            <div class="user_guide_content collapse" id="user_guide_content_speaking">
                Đây là hướng dẫn làm bài
            </div>

        </div>

        <div class="row justify-content-md-center">
            <div class="col-lg-8 col-xl-7 col-md-10 question">
            <?php
                foreach ($arrQuestionGroup as $id_question_mom => $Arr_question_child) {
                $stt_part = 1;
                foreach ($Arr_question_child as $id_question_part123 => $Arr_question_part){
                // Từng part một
                $id_question_mono = $Arr_question_part['question_id'];
                $question_answer = $Arr_question_part['question_answer'];

                    if ($stt_part != 2) {
                    echo '
                    
                    <div class="div_part" id="div_part'.$stt_part.'"><div class="row item" >';
//                                <ul class="list_speaking">';
                        for ($m = 0; $m < count($question_answer) ; $m++) {

                            $stt_inside_part = $m + 1;
                            $mono_1_by_1 = $question_answer[$m];

                            $id_question_1_by_1 = $mono_1_by_1['question_id'];
                            $id_answer_1_by_1 = $mono_1_by_1['answer_id'];
                            $content = $mono_1_by_1['content'];

                            $options = $mono_1_by_1['options'];
                            $options_live = json_decode($options,true);
                            $audio = 'uploads/sound/'.$options_live['audio'];
                            $suggest = $options_live['suggest'];

                            ?>
                            <!--                    <label>Question --><?php //echo $stt_inside_part; ?><!--</label>-->
                            <div class="col-12 col-sm-3"><strong>Question <?php echo $stt_inside_part; ?>:</strong></div>
                            <div class="col-12 col-sm-9">


                                <div class="show_tape">
                                    <span id="content_tape<?php echo $id_answer_1_by_1; ?>" <?php if ($stt_part != 2) echo ' style="display: none; " ' ?>><?php echo $content; ?></span>
                                    <a style="width: 100%;padding: 5px; <?php if ($stt_part == 2) echo ' display:none; '?>"
                                       onclick="ShowTapescript(<?php echo $id_answer_1_by_1; ?>)" id="clickTape<?php echo $id_answer_1_by_1; ?>">
                                        Show tape script
                                        <i class="fa fa-eye" aria-hidden="true" style="float:right"></i>
                                    </a>
                                </div>

                                <div class="mp3_OLD">
                                    <audio controls <?php if ($stt_part == 2) echo ' style="display:none" ' ?> style="width: 100%">
                                        <source src="<?php echo $audio; ?>" type="audio/ogg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                                <div class="player audio-player-time-countdown" style="display: none">
                                    <div class="audio-player">
                                        <!-- nút play pause file audio -->
                                        <div class="group-button-audio">
                                            <a href="" class="group-button-audio__button-play">
                                                <i class="fa fa-play-circle btn-play-pause" aria-hidden="true"></i>
                                            </a>
                                            <div class="group-button-audio__button-pause">
                                                <!-- <i class="fa fa-pause-circle  btn-play-pause" aria-hidden="true"></i> -->
                                            </div>
                                        </div>

                                        <!-- thời gian file audio -->
                                        <div class="time-play d-flex align-item-center">
                                            <div class="time-play__time-audio">
                                                00:00
                                            </div>
                                            <div class="time-play__audio-time-line">
                                                <div class="position-play-dot">

                                                </div>
                                            </div>
                                            <!--<div class="time-play__time-left">
                                                03:43
                                            </div>-->
                                        </div>

                                        <!-- chỉnh volume -->
                                        <div class="volume d-flex align-item-center">
                                            <a href="" class="volume__icon">
                                                <i class="fa fa-volume-up" aria-hidden="true"></i>
                                                <!-- <i class="fa fa-volume-down" aria-hidden="true"></i> -->
                                                <!-- <i class="fa fa-volume-off" aria-hidden="true"></i> -->
                                            </a>
                                            <div class="volume__level"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3"><strong>Bài làm của bạn:</strong></div>
                            <div class="col-12 col-sm-9 form-inline"
                                 id_question="<?php echo $id_answer_1_by_1_1_by_1; ?>"
                                 style="">


                                <a class="icon_speaking icon_speaking_record" href="javascript:void(0);"
                                   id_question="<?php echo $id_answer_1_by_1; ?>"
                                   id="a_speaking<?php echo $id_answer_1_by_1; ?>">
                                    <button class="btn btn-outline-danger form-control btn-speaking">
                                        <i id="img_speaking<?php echo $id_answer_1_by_1; ?>" class="fa fa-bullhorn" aria-hidden="true"></i>
                                        <span id="span_speaking<?php echo $id_answer_1_by_1; ?>">Start Record</span>
                                    </button>
                                </a>

                                <a class="icon_speaking icon_speaking_pause" href="javascript:void(0);"
                                   id_question="<?php echo $id_answer_1_by_1; ?>"
                                   id="a_speaking_pause<?php echo $id_answer_1_by_1; ?>"
                                   style="display: none;">
                                    <button class="btn btn-danger form-control btn-speaking">
                                        <i class="fa fa-pause" aria-hidden="true"></i>
                                        <span id="span_speaking_pause<?php echo $id_answer_1_by_1; ?>">Pause Record</span>
                                    </button>
                                </a>

                                <a class="icon_speaking icon_speaking_finish" href="javascript:void(0);"
                                   id_question="<?php echo $id_answer_1_by_1; ?>"
                                   id="a_speaking_finish<?php echo $id_answer_1_by_1; ?>"  style="display: none;">
                                    <button class="btn btn-outline-info form-control btn-speaking">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span>Finish Record</span>
                                    </button>
                                </a>

                                <a class="icon_speaking icon_speaking_record_again" href="javascript:void(0);"
                                   id_question="<?php echo $id_answer_1_by_1; ?>"
                                   id="a_speaking_record_again<?php echo $id_answer_1_by_1; ?>"  style="display: none;">

                                    <button class="btn btn-outline-info form-control btn-speaking">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span>Record Again</span>
                                    </button>
                                </a>


                                <div class="recordingList"  id="recordingList<?php echo $id_answer_1_by_1; ?>" file_url="" ></div>
                            </div>


                            <?php
                        }

                        echo '</div>';
                        echo '</div> ';
                        $stt_part ++;
                    }else{
                        ?>
                <div class="div_part" id="div_part<?php echo $stt_part; ?>">
                                <div class="row">

                                    <?php
                                for ($m = 0; $m < count($question_answer) ; $m++) {

                                    $stt_inside_part = $m + 1;
                                    $mono_1_by_1 = $question_answer[$m];

                                    $id_question_1_by_1 = $mono_1_by_1['question_id'];
                                    $id_answer_1_by_1 = $mono_1_by_1['answer_id'];
                                    $content = $mono_1_by_1['content'];

                                    $options = $mono_1_by_1['options'];
                                    $options_live = json_decode($options,true);
                                    $audio = 'uploads/sound/'.$options_live['audio'];
                                    $suggest = $options_live['suggest'];
                                    ?>
                                    <div class="col-12 col-sm-3"><strong>Cue card</strong></div>

                                    <div class="col-12 col-sm-9">
                                        <div class="cue_card">
                                            <?php echo $content; ?>
                                        </div>

                                    </div>
                                    <div class="col-12 col-sm-3"><strong>Notepad</strong></div>
                                    <div class="col-12 col-sm-9">
                                        <textarea class="notepad form-control" placeholder="Write your note here"></textarea>
                                    </div>
                                    <div class="col-12 col-sm-3"><strong>Bài làm của bạn</strong></div>

                                    <div class="col-12 col-sm-9 form-inline"
                                         id_question="<?php echo $id_answer_1_by_1_1_by_1; ?>"
                                         style="">

                                        <a class="icon_speaking icon_speaking_record" href="javascript:void(0);"
                                           id_question="<?php echo $id_answer_1_by_1; ?>"
                                           id="a_speaking<?php echo $id_answer_1_by_1; ?>">
                                            <button class="btn btn-outline-danger form-control btn-speaking">
                                                <i id="img_speaking<?php echo $id_answer_1_by_1; ?>" class="fa fa-bullhorn" aria-hidden="true"></i>
                                                <span id="span_speaking<?php echo $id_answer_1_by_1; ?>">Start Record</span>
                                            </button>
                                        </a>

                                        <a class="icon_speaking icon_speaking_pause" href="javascript:void(0);"
                                           id_question="<?php echo $id_answer_1_by_1; ?>"
                                           id="a_speaking_pause<?php echo $id_answer_1_by_1; ?>"
                                           style="display: none;">
                                            <button class="btn btn-danger form-control btn-speaking">
                                                <i class="fa fa-pause" aria-hidden="true"></i>
                                                <span id="span_speaking_pause<?php echo $id_answer_1_by_1; ?>">Pause Record</span>
                                            </button>
                                        </a>

                                        <a class="icon_speaking icon_speaking_finish" href="javascript:void(0);"
                                           id_question="<?php echo $id_answer_1_by_1; ?>"
                                           id="a_speaking_finish<?php echo $id_answer_1_by_1; ?>"  style="display: none;">
                                            <button class="btn btn-outline-info form-control btn-speaking">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                <span>Finish Record</span>
                                            </button>
                                        </a>

                                        <a class="icon_speaking icon_speaking_record_again" href="javascript:void(0);"
                                           id_question="<?php echo $id_answer_1_by_1; ?>"
                                           id="a_speaking_record_again<?php echo $id_answer_1_by_1; ?>"  style="display: none;">

                                            <button class="btn btn-outline-info form-control btn-speaking">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                <span>Record Again</span>
                                            </button>
                                        </a>

                                        <div class="recordingList"  id="recordingList<?php echo $id_answer_1_by_1; ?>" file_url="" ></div>
                                    </div>



                            <?php } ?>





                        </div>
                </div>
                    <?php $stt_part ++; }


                        }


                }?>
            </div>
        </div>




    </div>
</section>

<footer id="footer-listening" class="fixed-bottom">
    <div class="container">
        <div class="row align-item-center">
            <div class="col-6 audio-player-time-countdown ">
                <!-- thời gian làm bài còn lại -->
                <div class="time-countdown time-countdown_left">
                    <span class="time-countdown__icon">
                        <span class="icon-round-timer-24px"></span>
                    </span>
                    <span class="time-countdown__time">
                        <span id="show_count_down"></span>
                    </span>
                </div>
                <!-- kết thúc thời gian làm bài còn lại -->
            </div>
            <div class="col-6 text-right">
                <button class="btn btn-danger form-control next_section" id="btn_next_part_speaking" onclick="NextSection()">
                    next section <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>

    </div>
</footer>

<section class="answer_sheet">
    <form id="testing_form" action="<?php echo SITE_URL; ?>/test/speaking_result" method="POST">
        <input type="hidden" name="test_id" value="<?php echo $test['test_id']?>"/>
        <input type="hidden" name="log_id" value="<?php echo $log_id?>"/>

        <?php
        {
            // Lấy mẫu kết quả answer
            $answer_sheet = array();
            foreach ($arrQuestionGroup as $id_question_mom => $Arr_question_child) {
                foreach ($Arr_question_child as $id_question_part123 => $Arr_question_part){
                    // Từng part một
                    $id_question_mono = $Arr_question_part['question_id'];
                    $question_answer = $Arr_question_part['question_answer'];

                    $arr_id_answer = array();
                    for ($m = 0; $m < count($question_answer) ; $m++) {
                        $mono_1_by_1 = $question_answer[$m];
                        $id_answer_1_by_1 = $mono_1_by_1['answer_id'];
                        array_push($arr_id_answer,$id_answer_1_by_1);
                    }
                    $answer_sheet[$id_question_mono] = $arr_id_answer;
                }
            }
            echo '<input type="hidden" name="answer_sheet_form" id="answer_sheet_form" value=\'' .json_encode($answer_sheet).  '\'>';
        }


        if (isset($arr_fulltest_all_detail)){
            echo '<input type="hidden" name="fulltest_timestamp" value="' . $arr_fulltest_all_detail['fulltest_timestamp'].  '">';
            echo '<input type="hidden" name="fulltest_all_step" value=\''. $arr_fulltest_all_detail['fulltest_all_step'] .'\'>';
            echo '<input type="hidden" name="fulltest_now_step" value="'.$arr_fulltest_all_detail['fulltest_now_step'].'">';
        }
        ?>

        <input type="hidden" name="token" value="<?php echo $this->security->generate_token_post(array($test['test_id'],$log_id)); ?>">
        <input type="hidden" name="type" value="<?php echo $test['type']?>"/>
        <input type="hidden" name="start_time" value="<?php echo $start_time?>"/>
        <input type="hidden" name="user_answer" id="user_answer" value=""/>
        <button type="submit" id="clickSubmit">Nộp bài</button>
    </form>
</section>

<!--<section class="information">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col designed-build text-center">-->
<!--                Designed and built with all the love in the world by the Imap team-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->

<script>
    function goback() {
        window.history.back();
    }
</script>

<script>
    function ClickSubmit(){
        // Get nội dung answer
        var user_answer = GetListMp3File();
        $('#user_answer').val(JSON.stringify(user_answer));

        $('#clickSubmit').click();

    }

    $(document).ready(function() {
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        console.log(navigator.getUserMedia);
        if (navigator.getUserMedia)
        {
            navigator.getUserMedia({ audio: true },
                function(stream) {

                },
                function(err) {
                    alert("Bạn cần phải kết nối với Microphone để có thể ghi âm");
                }
            );
        }
        else {
            console.log("Trình duyệt không hỗ trợ");
        }
        // scroll box ket qua
        //$('.scrollbar-inner').scrollbar();
        // count downtime
        function liftOff() {
            // mshoatoeic.send_answer_writing();
        }

        var fiveSeconds = new Date().getTime() + parseInt(<?php echo (int) $test_time; ?>);
        $('#show_count_down').countdown(fiveSeconds, {elapse: true})
            .on('update.countdown', function(event) {
                var this_countdown = $('#show_count_down');
                if (event.elapsed) {
                    // $this.html('Hết thời gian làm bài');
                    return liftOff();
                } else {
                    this_countdown.html(event.strftime('%H : %M : %S'));
                }
            });
        ////////// NEXT & PREV //////////
        $("#fulltest_page").find(".button_page").bind("click",function(){
            var current_page = parseInt($("#fulltest_page").attr("data-page"));
            var type = parseInt($(this).attr("data-type"));
            current_page = current_page + type;
            fulltest_change_page(current_page);

        });
        $("#fulltest_question_shortcut").find(".cau").bind("click",function(){
            var page = parseInt($(this).attr("data-page"));
            fulltest_change_page(page);
        });
        $("#fulltest_part_head").find(".fulltest_part").bind("click",function(){
            var part = $(this).attr("data-part");
            var page = $("#fulltest_content").find('.question[data-part="'+part+'"]').first().attr("data-page");
            fulltest_change_page(page);
        });

        SelectPart(1);
    });

    function ShowTapescript(id_answer) {
        console.log("ShowTapescript");
        console.log('id_question: ' + id_answer);

        $('#clickTape' + id_answer).css('display','none');
        $('#content_tape' + id_answer).css('display','inline-block');
    }

    function SelectPart(stt_part,event) {
        // Change class btn
        if (typeof  event !== 'undefined'){

            // click trực tiếp vào btn Part X
            $('.menu-link').removeClass('-active');
            var obj = event.target;
            obj.className = 'nav-link menu-link -custom-color-link  -active';

        }else{
            $(".menu-link").each(function () {
                    var html = $(this).html();
                    for (var i = 1; i <= 3; i++) {
                    var j = stt_part.toString();
                    if (html.includes(j)){
                        $(this).addClass('-active');
                    }else{
                        $(this).removeClass('-active');
                    }
                }
            });
        }


        // Change button Next Section
        switch (stt_part) {
            case 3:
                $('#btn_next_part_speaking').html('nộp bài <i class="fa fa-angle-double-right" aria-hidden="true"></i>');
                break;
            default: // Nộp bài
                $('#btn_next_part_speaking').html('next section <i class="fa fa-angle-double-right" aria-hidden="true"></i>');
        }


        $('.div_part').css('display','none');
        $('#div_part'+stt_part).css('display','block');
    }

    function NextSection() {
        var now_part = getNowPartSelect();
        console.log("now_part");
        console.log(now_part);

        switch (now_part) {
            case '1':
                SelectPart(2);
                $('#btn_next_part_speaking').html('next section <i class="fa fa-angle-double-right" aria-hidden="true"></i>');
                break;
            case '2':
                SelectPart(3);
                $('#btn_next_part_speaking').html('Nộp bài <i class="fa fa-angle-double-right" aria-hidden="true"></i>');
                break;
            default: // Nộp bài
                ClickSubmit();
        }

    }

    function getNowPartSelect() {
        var res = '';
        $(".menu-link").each(function () {
            if ($(this).hasClass("-active")){
                var html = $(this).html();
                console.log("html- getNowPartSelect");
                console.log(html);

                for (var i = 1; i <= 3; i++) {
                    var j = i.toString();
                    console.log("j");
                    console.log(j);
                    if (html.includes(j)){
                        res = j;
                    }
                }
            }
        });
        return res;
    }
</script>