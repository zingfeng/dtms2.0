<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$question = $arrQuestion[0];
?>

<div style="    height: 100%;position: fixed;top: 0;left: 0;width: 250px;z-index: 1000;background-color: #7ac17d;padding: 10px;display: none;">
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
    <hr>
    <div>
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

            ?>
            <?php
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


            <div class="col-md-8 col-sm-8 col-xs-12">
                <?php echo $breadcrumb; ?>
                <div class="col_box_test">
                    <h1><?php echo $test['title']?></h1>
                    <div class="part" id="fulltest_part_head">
                        <?php
                        $i = 1;
                        if (is_array($question)){
                            $numberQuestion = count($question);
                        }else{
                            $numberQuestion = 0;
                        }

                        for ($i = 1; $i <= $numberQuestion; $i ++){ ?>
                            <div class="fulltest_part item" data-part="<?php echo $i?>">
                                <a class="<?php echo $i == 1 ? 'active' : ''?>" href="javascript:;">Question <?php echo $i?></a>
                            </div>
                        <?php } ?>
                        <div class="item" id="test_score" style="display: none;">
                            <a href="javascript:;">
                                <strong></strong>
                                <span>Score</span>
                            </a>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                </div><!-- End -->

                <!-- Tài liệu luyện thi toeic -->
                <?php echo $this->load->get_block('content'); ?>
            </div>
            <div>
                <button type="submit" id="clickSubmit">Nộp bài</button>
            </div>
        </form>
        <div class="col-md-4 col-sm-4 col-xs-12" id="test_col_right" style="position: relative;">

            <?php echo $this->load->get_block('right'); ?>
        </div>
    </div>

</div>

<section class="listening-test_head clearfix">
    <div class="container">
        <div class="show_test" id="show_test_info" style="display: none;">
            <div class="book left">
                <img src="<?php echo $this->config->item("img"); ?>icons/book.png" alt="">
                <a href="<?php echo $cateDetail['share_url']; ?>"><h4><?php echo $cateDetail['name']; ?></h4></a>
            </div>
            <div class="info right">
                <div class="date">
                    <!--<p><i class="fa fa-calendar"></i>Ngày đăng: 22/11/2018</p>-->
                    <p><i class="fa fa-file-text-o"></i>Số lần test: <?php echo $test['total_hit']?></p>
                    <!--<p><i class="fa fa-file-zip-o"></i>Người tạo: Aland IELTS</p>-->
                </div>
                <div class="user">
                    <div class="content">
                        <h4><?php echo $test['title']; ?></h4>
                        <?php if($test['author']) { ?>
                            <p>Biên soạn bởi <?php echo $test['author']?></p>
                        <?php } ?>
                    </div>
                    <img class="<?php echo $test['title']; ?>" src="<?php echo getimglink($test['images'],'size1');?>" alt="<?php echo $test['title']; ?>">
                </div>
            </div>
        </div>
        <a class="img_logo" href="">
            <img class="logo_web" src="theme/frontend/default/images/graphics/logo.png" alt="Trang chủ" data-was-processed="true">
        </a>
        <?php if($arrQuestionGroup) { ?>
            <div class="select_sever" id="select_sever">
                <?php
                $i = 1; $time = 0;
                foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) {?>
                    <a onclick="SelectPart(<?php echo $i; ?>)" data-section="<?php echo $qgroup['question_id']; ?>" id="question_setion_selection_<?php echo $qgroup['question_id']; ?>" class="reading_change_section <?php if ($i == 1) echo 'active'; ?>" href="javascript:void(0)"><?php echo $qgroup['title']; ?></a>
                    <?php $i ++;
                }
                $test_time = $question['test_time'] * 60 * 1000;
                ?>
            </div>
        <?php } ?>
        <div class="option_listening">
            <div class="timer"><i class="fa fa-clock-o"></i><span id="show_count_down"></span></div>
            <a class="nop_bai" href="javascript:void(0)" id="submit_answer_result" onclick="ClickSubmit()">Nộp bài</a>
            <a href="javascript:void(0)" class="show_info_test">Show info test<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
        </div>
    </div>
</section>

<section class="listening-test_container speaking-test clearfix">
    <?php echo $this->load->view('test/common/skill_menu_mobile',array('test' => $test,'type' => 'speaking')); ?>
    <div class="container warp_slidebar">
        <?php 
            if (!$this->input->get('skill')) {
                echo $this->load->view('test/common/skill_menu',array('test' => $test,'type' => 'speaking')); 
            }
        ?>
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

                <?php

                // $arrQuestionGroup

                foreach ($arrQuestionGroup as $id_question_mom => $Arr_question_child) {
                    $stt_part = 1;
                    foreach ($Arr_question_child as $id_question_part123 => $Arr_question_part){
                        // Từng part một
                        $id_question_mono = $Arr_question_part['question_id'];
                        $question_answer = $Arr_question_part['question_answer'];

                        echo '<div class="div_part" id="div_part'.$stt_part.'"><h2>Part '.$stt_part.'</h2><ul class="list_speaking">';

//                            echo '<hr><pre>'.print_r($question_answer).'</pre>'; exit;
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
                            <li>
                                <label>Question <?php echo $stt_inside_part; ?></label>

                                <div class="speaking_right">
                                    <h3 class="tapescript" href="">
                                        <a style="width: 100%;padding: 5px; <?php if ($stt_part == 2) echo ' display:none; '?>" onclick="ShowTapescript(<?php echo $id_answer_1_by_1; ?>)" id="clickTape<?php echo $id_answer_1_by_1; ?>">Bấm để mở Tapescript</a>
                                        <span id="content_tape<?php echo $id_answer_1_by_1; ?>" <?php if ($stt_part != 2) echo ' style="color: #208b96;" ' ?>><?php echo $content; ?></span>
                                    </h3>
                                    <audio controls <?php if ($stt_part == 2) echo ' style="display:none" ' ?>>
                                        <source src="<?php echo $audio; ?>" type="audio/ogg">
                                        Your browser does not support the audio element.
                                    </audio>
                                    <div class="suggest_text tapescript"
                                         style="    color: black;  background-color: rgb(247, 247, 170); margin: 5px 0;
                                         <?php if ($stt_part !== 2) {echo ' display: none; ';} ?>
                                                 " id_question="<?php echo $id_answer_1_by_1_1_by_1; ?>"><?php echo $suggest; ?></div>
                                    <a class="icon_speaking icon_speaking_record" href="javascript:void(0);" id_question="<?php echo $id_answer_1_by_1; ?>" id="a_speaking<?php echo $id_answer_1_by_1; ?>">
                                        <img src="theme/frontend/default/images/icons/icon-speaking.png" id="img_speaking<?php echo $id_answer_1_by_1; ?>">
                                        <span id="span_speaking<?php echo $id_answer_1_by_1; ?>">click để làm bài</span>
                                    </a>
                                    <a class="icon_speaking icon_speaking_pause" href="javascript:void(0);"  id_question="<?php echo $id_answer_1_by_1; ?>" id="a_speaking_pause<?php echo $id_answer_1_by_1; ?>" style="display: none;">
                                        <img src="theme/frontend/default/images/icons/icon-speaking.png">
                                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                        <span id="span_speaking_pause<?php echo $id_answer_1_by_1; ?>">Pause</span>
                                    </a>
                                    <a class="icon_speaking icon_speaking_finish" href="javascript:void(0);"  id_question="<?php echo $id_answer_1_by_1; ?>" id="a_speaking_finish<?php echo $id_answer_1_by_1; ?>"  style="display: none;">
                                        <img src="theme/frontend/default/images/icons/icon-speaking.png">
                                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                        <span>Finish</span>
                                    </a>
                                    <a class="icon_speaking icon_speaking_record_again" href="javascript:void(0);"  id_question="<?php echo $id_answer_1_by_1; ?>" id="a_speaking_record_again<?php echo $id_answer_1_by_1; ?>"  style="display: none;">
                                        <img src="theme/frontend/default/images/icons/icon-speaking.png">
                                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                        <span>Record Again</span>
                                    </a>
                                    <div class="recordingList"  id="recordingList<?php echo $id_answer_1_by_1; ?>" file_url="" ></div>

                                </div>
                            </li>

                            <?php

                        }

                        echo '</div>';
                        $stt_part ++;
                    }

                }

                //                    for ($k = 0; $k < count($arrQuestion); $k++) {
                //                        $mono = $arrQuestion[$k];
                //                        $id_question = $mono['question_id'];
                //                        $stt = $k + 1;
                //                        if (isset($arrQuestionGroup[$id_question])){
                //                            // Đây là part 1 hoặc part 3
                //
                //
                //
                //
                //                            // danh sách trong $arrQuestionGroup
                //                            $stt_next = 2;
                //                            foreach ($arrQuestionGroup[$id_question] as $mono_question_next){
                //                                $question_id_inside = $mono_question_next['question_id'];
                //                                echo '<li>
                //                                    <label>Question '.$stt_next.'</label>'.
                //                                    '<div class="speaking_right">
                //                            <h3 class="tapescript" href="">
                //<!--                                <a>Bấm để mở Tapescript</a> -->
                //                                <span>'.$mono_question_next['detail'].'</span>
                //                            </h3>
                //                            <a class="icon_speaking icon_speaking_record" href="javascript:void(0);" id_question="'.$question_id_inside.'" id="a_speaking'.$question_id_inside.'">
                //                                <img src="theme/frontend/default/images/icons/icon-speaking.png" id="img_speaking'.$question_id_inside.'">
                //                                <span id="span_speaking'.$question_id_inside.'">click để làm bài</span>
                //                            </a>
                //                            <a class="icon_speaking icon_speaking_pause" href="javascript:void(0);"  id_question="'.$question_id_inside.'" id="a_speaking_pause'.$question_id_inside.'" style="display: none;">
                //                                <img src="theme/frontend/default/images/icons/icon-speaking.png">
                //                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                //                                <span id="span_speaking_pause'.$question_id_inside.'">Pause</span>
                //                            </a>
                //                            <a class="icon_speaking icon_speaking_finish" href="javascript:void(0);"  id_question="'.$question_id_inside.'" id="a_speaking_finish'.$question_id_inside.'"  style="display: none;">
                //                                <img src="theme/frontend/default/images/icons/icon-speaking.png">
                //                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                //                                <span>Finish</span>
                //                            </a>
                //                            <div class="recordingList"  id="recordingList'.$question_id_inside.'" file_url="" ></div>
                //
                //                        </div>
                //                    </li>';
                //                                $stt_next ++;
                //
                //                            }
                //
                //                            echo '</ul>';
                //
                //                        }else{
                //                            // Đây là part 2
                //
                //                            $test_time = (int)  $mono['test_time'];
                //                            $test_time_second = $test_time*60;
                //                            $test_time_text =  $test_time.':00';
                //                            echo '<h2>Part '.$stt.'</h2>
                //                <div class="speaking_document">
                //                    <div class="warp">'.$mono['detail'].'</div>
                //                    <div class="controler">';
                //
                ////                       <div class="td right">
                ////                            <span>Thời gian chuẩn bị</span>
                ////                            <div class="timer">
                ////                                <img src="theme/frontend/default/images/icons/clock.png">
                ////                                <span>00:60</span>
                ////                            </div>
                ////                        </div>
                ////                        <div class="td">
                ////                            <span>Thời gian trả lời</span>
                ////                            <div class="timer">
                ////                                <img src="theme/frontend/default/images/icons/clock.png">
                ////                                <span id="time_count_down'.$id_question.'" test_time_second="'.$test_time_second.'">'.$test_time_text.'</span>
                ////                            </div>
                ////                        </div>
                //
                //                            echo '<p id="p_count_'.$id_question.'" style="text-align: center; font-size: large; display: none;"><span class="">Record</span> - <span  id="span_speaking'.$id_question.'"></p>
                //                        <a class="icon_speaking icon_speaking_record icon_speaking_part2" href="javascript:void(0);" id_question="'.$id_question.'" id="a_speaking'.$id_question.'">
                //                            <img src="theme/frontend/default/images/icons/icon-speaking.png"  id="img_speaking'.$id_question.'" >
                //                            <i class="fa fa-angle-double-up"></i>
                //                            <span>Click để làm bài</span>
                //                        </a>
                //
                //
                //                            <a class="icon_speaking icon_speaking_pause" href="javascript:void(0);"  id_question="'.$id_question.'" id="a_speaking_pause'.$id_question.'" style="display: none;">
                //                                <img src="theme/frontend/default/images/icons/icon-speaking.png">
                //                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                //                                <span id="span_speaking_pause'.$id_question.'">Pause</span>
                //                            </a>
                //                            <a class="icon_speaking icon_speaking_finish" href="javascript:void(0);"  id_question="'.$id_question.'" id="a_speaking_finish'.$id_question.'"  style="display: none;">
                //                                <img src="theme/frontend/default/images/icons/icon-speaking.png">
                //                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                //                                <span>Finish</span>
                //                            </a>
                //                            <div class="recordingList"  id="recordingList'.$id_question.'" file_url="" ></div>
                //
                //                    </div>
                //                </div>
                //                <div class="speaking_note">
                //                    <span class="gim"><img src="theme/frontend/default/images/icons/gim.png"></span>
                //                    <textarea class="input_form input_area" onblur="if(this.value==\'\') this.value=this.defaultValue" onfocus="if(this.value==this.defaultValue) this.value=\'\'" placeholder="Answer..."></textarea>
                //                </div>';
                //
                //                        }
                //
                //                    }

                ?>

            </div>
        </div>
    </div>
</section>
<script src="<?php echo $this->config->item("js"); ?>recorder.js"></script>
<script src="<?php echo $this->config->item("js"); ?>app.js"></script>
<script>
    function ClickSubmit(){
        // Get nội dung answer
        var r = confirm("Bạn có chắc muốn nộp bài ?");
        if (r == true) {
            var user_answer = GetListMp3File();
            $('#user_answer').val(JSON.stringify(user_answer));
            $('#clickSubmit').click();
        }
        return false;
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
        $('#content_tape' + id_answer).css('color','black');
    }

    function SelectPart(stt_part) {
        $('.div_part').css('display','none');
        $('#div_part'+stt_part).css('display','block');
    }
</script>