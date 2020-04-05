<?php
    $question = $arrQuestion[0];
?>
<header class="header">
    <nav class="row navigation-top">
        <div class="container"> 
            <div class="row">
                <?php echo $this->load->view('test/common/home');?>
                <div class="col-8 navigation-top__menu-collapse" id="navbarTogglerTop">
                    <ul class="menu">
                        <li class="nav-item">
                            <a class="nav-link -custom-color-link" href="#">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            </a>
                        </li>
                        <?php $i = 1; $test_time = 0;
                        foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) {?>
                            <?php $nextSetion = $arrQuestion[$key+1]?>
                            <li class="nav-item">
                                <a data-index="<?php echo $i-1; ?>" data-section="<?php echo $qgroup['question_id']; ?>" id="question_setion_selection_<?php echo $qgroup['question_id']; ?>" class="reading_change_section nav-link menu-link -custom-color-link <?php if ($i == 1) echo '-active'; ?>" href="javascript:void(0)"><?php echo $qgroup['title']; ?></a>
                            </li>
                        <?php $i++;
                            $test_time += $question['test_time'] * 60 * 1000;
                        } ?>
                    </ul> 
                </div>
                <?php echo $this->load->view('test/common/account');?>
            </div>
        </nav>
    </div>
</header>
<?php echo $this->load->view('test/common/breadcrumb');?>

<section class="test-writing">
    <div class="container background-test">
        <div class="row">
            <div class="col group-test text-center">
                <div class="group-test__title">
                    <?php echo $test['title']?>
                </div>
                <div class="group-test__subtitle">
                    WRITING PRACTICE
                </div>
                <div class="group-test__custom-border-bottom"></div>
            </div>
        </div>
        <form class="form" method="POST" action="/test/writing_result" id="test_form">
            <input type="hidden" name="test_id" value="<?php echo $test['test_id']; ?>">
            <input type="hidden" name="type" value="<?php echo $keyType; ?>">
            <?php 
                if (isset($arr_fulltest_all_detail)){
                    echo '<input type="hidden" name="fulltest_timestamp" value="' . $arr_fulltest_all_detail['fulltest_timestamp'].  '">';
                    echo '<input type="hidden" name="fulltest_all_step" value=\''. $arr_fulltest_all_detail['fulltest_all_step'] .'\'>';
                    echo '<input type="hidden" name="fulltest_now_step" value="'.$arr_fulltest_all_detail['fulltest_now_step'].'">';
                }
            ?>
            <input type="hidden" name="start_time" value="<?php echo $start_time; ?>">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

            <?php
                $number_question = 1;
                foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) {
                    switch ($number_question) {
                        case 1:
                          $max_length_text= 200;
                          break;
                        default:
                          $max_length_text= 300;
                          break;
                      }
            ?>
            <div class="row warp_content question_section_content" id="question_section_<?php echo $qgroup['question_id']; ?>" <?php if ($number_question != 1) echo 'style="display: none"'; ?>>
                <div class="col-6 question">
                    <h2 class="question_title"><?php echo $qgroup['title']; ?></h2>
                    <div class="question_content">
                        <?php echo $qgroup['question_answer'][0]['content']; ?>
                    </div>
                </div>
                <div class="col-6 answer">
                    <div class="answer_title">
                        Bài làm của bạn
                        <span class="answer_count_word"><font id="test_writing_count_word_<?php echo $qgroup['question_id']; ?>" style="color:#0a77ec">0</font>/<?php echo $max_length_text; ?> Words</span>
                    </div>
                    <div class="answer_textarea">
                        <textarea data-max-word="<?php echo $max_length_text; ?>" data-question-id="<?php echo $qgroup['question_id']; ?>"  class="input_form input_area test_writing_input form-control" name="user_answer[<?php echo $qgroup['question_id']?>]" placeholder="Answer..."></textarea>
                    </div>
                </div>
            </div>
            <?php $number_question ++; ?>
            <?php } ?>
        </form>
    </div>
</section>
<section class="information">
    <div class="container">
        <div class="row">
            <div class="col designed-build text-center">
                Designed and built with all the love in the world by the Imap team
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
                    <span class="time-countdown__time" id="show_count_down"></span>
                </div>
                <!-- kết thúc thời gian làm bài còn lại -->
            </div>
            <div class="col-6 text-right passage-control">
                <?php $i = 0; foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) { ?>
                    <?php if ($nextSection = $arrQuestionGroup[$question['question_id']][$key + 1]) {?>
                        <button class="btn btn-danger form-control next_section reading_change_section" data-section="<?php echo $nextSection['question_id']; ?>" data-index="<?php echo $i+1?>" data-ci=<?php echo $i?> <?php echo $i != 0 ? 'style="display:none"' : ''?>><?php echo $nextSection['title']; ?>&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></button>
                    <?php } else { ?>
                        <button data-ci="<?php echo $i?>" class="btn btn-danger form-control next_section" type="submit" id="submit_answer_result" style="display: none">Nộp bài</button> 
                    <?php } ?>
                <?php $i++; }?>
            </div>
        </div>

    </div>
</footer>

<script type="text/javascript">
    $(function(){
        jQuery('.scrollbar-inner').scrollbar();
        $(".reading_change_section").bind("click",function(){
            var section_id = $(this).attr("data-section");
            $(".question_section_content").hide();
            $("#question_section_" + section_id).show();

            $(".reading_change_section").removeClass("-active");
            $("#question_setion_selection_" + section_id).addClass("-active");

            var dataIndex = $(this).attr("data-index");
            $(".passage-control button").hide();
            $('.passage-control button[data-ci="' + dataIndex +'"]').show();
        });

        $("#test_form").find("select").bind("change",function(){
            var number = $(this).attr("data-question-number");
        });

        $(".answer_recheck").bind("click",function(){

        })
        window.onbeforeunload = function() {
            //return "Data will be lost if you leave the page, are you sure?";
        };
        // scroll box ket qua
        //$('.scrollbar-inner').scrollbar();
        // count downtime
        function liftOff() {
            $("#test_form").submit();
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
        //////////// COUNT WORD ////////
        $( ".test_writing_input" ).keyup(function() {
            var regex = /\s+/gi;
            var wordcount = jQuery.trim($(this).val()).replace(regex, ' ').split(' ').length;
            var qgid = $(this).attr("data-question-id");
            var max_word = parseInt($(this).attr("data-max-word"));
            if (wordcount > max_word) {
                $("#test_writing_count_word_" + qgid).css('color','#f92c53');
            }
            else {
                $("#test_writing_count_word_" + qgid).css('color','#0a77ec');
            }
            $("#test_writing_count_word_" + qgid).text(wordcount);
        });

        /// submit 
        $("#submit_answer_result").bind("click",function(){
          var r = confirm("Bạn có chắc muốn nộp bài ?");
          if (r == true) {
            $("#test_form").submit();
          }
          return false;
          
        })
    });
</script>
