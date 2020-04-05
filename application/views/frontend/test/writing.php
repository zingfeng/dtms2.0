<?php
$question = $arrQuestion[0];
?>
<!--END HEADER-->
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
            <img class="logo_web" src="<?php echo $this->config->item("img"); ?>graphics/logo.png" alt="Trang chủ" data-was-processed="true">
        </a>
        <?php if($arrQuestionGroup) { ?>
        <div class="select_sever">
            <?php 
            $i = 1; $time = 0;
            foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) {?>
              <a data-section="<?php echo $qgroup['question_id']; ?>" id="question_setion_selection_<?php echo $qgroup['question_id']; ?>" class="reading_change_section <?php if ($i == 1) echo 'active'; ?>" href="javascript:void(0)"><?php echo $qgroup['title']; ?></a>
            <?php $i ++; 
            } 
            $test_time = $question['test_time'] * 60 * 1000; 
            ?>
        </div> 
        <?php } ?>
        <div class="option_listening">
            <div class="timer"><i class="fa fa-clock-o"></i><span id="show_count_down"></span></div>
            <a class="nop_bai" href="javascript:voi(0)" id="submit_answer_result">Nộp bài</a>
            <a href="javascript:void(0)" class="show_info_test">Show info test<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
        </div>        
    </div>
</section>
   
<section class="listening-test_container writing-test clearfix">
    <?php echo $this->load->view('test/common/skill_menu_mobile',array('test' => $test,'type' => 'writing')); ?>    
    <div class="container warp_slidebar">
        <?php 
        if (!$this->input->get('skill')) {
            echo $this->load->view('test/common/skill_menu',array('test' => $test,'type' => 'writing')); 
        }
        ?>
        <div class="slidebar_2">
            <form class="form" method="POST" action="/test/writing_result" id="test_form">
                <input type="hidden" name="test_id" value="<?php echo $test['test_id']; ?>">
                <input type="hidden" name="type" value="<?php echo $keyType; ?>">
                <input type="hidden" name="start_time" value="<?php echo $start_time; ?>">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
        <?php
            if (isset($arr_fulltest_all_detail)){
              echo '<input type="hidden" name="fulltest_timestamp" value="' . $arr_fulltest_all_detail['fulltest_timestamp'].  '">';
              echo '<input type="hidden" name="fulltest_all_step" value=\''. $arr_fulltest_all_detail['fulltest_all_step'] .'\'>';
              echo '<input type="hidden" name="fulltest_now_step" value="'.$arr_fulltest_all_detail['fulltest_now_step'].'">';
            }
        ?>

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
          <div class="warp_content question_section_content" id="question_section_<?php echo $qgroup['question_id']; ?>" <?php if ($number_question != 1) echo 'style="display: none"'; ?>>
              <div class="huong_dan">
                <a class="title" href="javascript:;" data-toggle="collapse" data-target="#huong_dan_<?php echo $qgroup['question_id']; ?>"><i class="fa fa-exclamation-circle"></i>Hướng dẫn làm bài</a>
                <div id="huong_dan_<?php echo $qgroup['question_id']; ?>" class="collapse">
                  <div class="warp" style="padding: 10px;">
                    <?php echo $qgroup['detail']; ?> 
                  </div>
                </div>
              </div>
              <h2><?php echo $qgroup['title']; ?> </h2>
              <div class="writing_document max_width">
                  <?php echo $qgroup['question_answer'][0]['content']; ?>
              </div>
              <div class="writing_note">
                  <header>
                      <div>Bài làm của bạn : <strong><span id="test_writing_count_word_<?php echo $qgroup['question_id']; ?>" style="color:#0a77ec">0</span>/<?php echo $max_length_text; ?></strong> words</div>
                  </header>
                  <textarea data-max-word="<?php echo $max_length_text; ?>" data-question-id="<?php echo $qgroup['question_id']; ?>"  class="input_form input_area test_writing_input" name="user_answer[<?php echo $qgroup['question_id']?>]" placeholder="Answer..."></textarea>
              </div>
              <?php if ($nextSection = $arrQuestionGroup[$question['question_id']][$key + 1]) { ?>
              <h2><a class="reading_change_section" href="javascript:void(0)" data-section="<?php echo $nextSection['question_id']; ?>"><?php echo $arrQuestionGroup[$question['question_id']][$key + 1]['title']; ?>&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a></h2>
              <?php } ?>                
          </div>
          <?php $number_question ++;} ?>
          </form>
        </div>
    </div> 
</section>  

<script type="text/javascript">
    $(function(){
        jQuery('.scrollbar-inner').scrollbar();
        $(".reading_change_section").bind("click",function(){
            var section_id = $(this).attr("data-section");
            $(".question_section_content").hide();
            $("#question_section_" + section_id).show();

            $(".reading_change_section").removeClass("active");
            $("#question_setion_selection_" + section_id).addClass("active");
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
                $("#test_writing_count_word_" + qgid).css('color','');
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
