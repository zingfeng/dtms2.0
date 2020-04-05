<style type="text/css">
    /* Only in showing */
    .tilte_explain_question{
        display: none !important;
    }
    .content_explain_question{
        background-color: transparent !important;
        padding: 0 !important;
    }
</style>

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
        <a class="img_logo" href="<?php echo BASE_URL; ?>">
            <img class="logo_web" src="<?php echo $this->config->item("img"); ?>graphics/logo.png" alt="Trang chủ" data-was-processed="true">
        </a>
        <div class="select_sever">
            <span class="hidden-xs">Chọn Section để làm bài</span>
            <?php
            $i = 1;
            $test_time = 0;
            foreach ($arrQuestion as $key => $question) {
                if ($i % 2 == 1 && $i != 1) {
                    echo '<div class="clearfix visible-xs"></div>';
                }

                ?>
                <a data-section="<?php echo $question['question_id']; ?>" id="question_setion_selection_<?php echo $question['question_id']; ?>" class="reading_change_section <?php if ($i == 1) {
                    echo 'active';
                }
                ?>" href="javascript:void(0)"><?php echo $question['title']; ?></a>
                <?php $i++;
                $test_time += $question['test_time'] * 60 * 1000;
                //var_dump($test_time); die;
            }?>

<!--            <button id="submit_answer_result" class="btn" style="">Nộp bài</button>-->
            <a class="nop_bai" href="javascript:void(0)" id="submit_answer_result" style="    background: #ff6c88;">Nộp bài</a>
        </div>
        <div class="option_listening">
            <div class="social_share">
                <div class="fb-share-button" data-href="<?php echo SITE_URL . $newsDetail['share_url'] ?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url ?>" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                <div class="fb-like" data-href="<?php echo SITE_URL . $newsDetail['share_url'] ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
            </div>
            <!--<a href=""><i class="icon icon-download"></i></a>-->
            <!--<a href=""><i class="icon icon-social"></i></a> -->
            <!--<a href=""><i class="icon icon-font"></i></a>-->
            <!--<a href="" title="Thoát"><i class="icon icon-out"></i></a>-->
            <a href="javascript:void(0)" class="show_info_test">Show info test<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
        </div>
    </div>
</section>


<section class="listening-test_container reading-test clearfix">
    <?php
    echo $this->load->view('test/common/skill_menu_mobile', array('test' => $test, 'type' => 'reading')); ?>
    <div class="container max_width warp_slidebar">
        <?php
        if (!$this->input->get('skill')) {
            echo $this->load->view('test/common/skill_menu', array('test' => $test, 'type' => 'reading'));
        }
        ?>
        <div class="row <?php if (!$this->input->get('skill')) {
            echo 'slidebar_2';
        } ?>">

            <form class="form" method="POST" action="<?php echo SITE_URL; ?>/test/result" id="test_form"> 
                <input type="hidden" name="test_id" value="<?php echo $test['test_id']; ?>">
                <input type="hidden" name="type" value="<?php echo $keyType; ?>">
                <input type="hidden" name="start_time" value="<?php echo $start_time; ?>">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                <?php
                if (isset($arr_fulltest_all_detail)){
                    echo '<input type="hidden" name="fulltest_timestamp" value="' . $arr_fulltest_all_detail['fulltest_timestamp'].  '">';
                    echo '<input type="hidden" name="fulltest_all_step" value=\''. $arr_fulltest_all_detail['fulltest_all_step'] .'\'>';
                    echo '<input type="hidden" name="fulltest_now_step" value="'.$arr_fulltest_all_detail['fulltest_now_step'].'">';
                }
                ?>

                <?php if(!isMobileDevice()) { ?>
                <div class="col_left col-md-9 col-sm-9 col-xs-12">
                    <?php
                    $number_question = 1;
                    foreach ($arrQuestion as $qkey => $question) {
                        ?>
                        <table id="question_section_<?php echo $question['question_id']; ?>" class="question_section_content" <?php echo ($number_question != 1) ? 'style="display: none"' : '' ?>  width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <div class="warp_content">
                                        <div class="scrollbar-inner">
                                            <h2><?php echo $question['title']; ?></h2>
                                            <div class="question mb30">
                                                <?php echo $question['detail']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="warp_content grip2">
                                        <div class="scrollbar-inner">
                                            <?php foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) { ?>
                                                <div class="question bg_warp mb30">
                                                    <h3><?php echo $qgroup['title']; ?></h3>
                                                    <p><?php echo $qgroup['detail']; ?></p>
                                                    <?php echo $this->load->view("test/question/type_" . $qgroup['type'], array('rows' => $qgroup['question_answer'], 'number' => $number_question)); ?>
                                                </div>
                                                <?php $number_question += $qgroup['number_question'];?>
                                            <?php } ?>
                                            <?php if ($nextSection = $arrQuestion[$qkey + 1]) {?>
                                                <div class="passage-control">
                                                    <a class="reading_change_section" href="javascript:void(0)" data-section="<?php echo $nextSection['question_id']; ?>"><?php echo $nextSection['title']; ?>&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $arrNumberCheck[$question['question_id']] = $number_question;?>
                        </table>
                    <?php } ?>

                </div>
                <?php } else { ?>
                <div class="col_left col-md-9 col-sm-9 col-xs-12">
                    <?php
                    $number_question = 1;
                    foreach ($arrQuestion as $qkey => $question) {
                        ?>
                    <div class="warp_content question_section_content" id="question_section_<?php echo $question['question_id']; ?>" <?php echo ($number_question != 1) ? 'style="display: none"' : '' ?> >
                        <div class="scrollbar-inner">
                            <h2><?php echo $question['title']; ?></h2>
                            <div class="question mb30">
                                <?php echo $question['detail']; ?>
                            </div>
                            <?php foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) { ?>
                                <div class="question bg_warp mb30">
                                    <h3><?php echo $qgroup['title']; ?></h3>
                                    <p><?php echo $qgroup['detail']; ?></p>
                                    <?php echo $this->load->view("test/question/type_" . $qgroup['type'], array('rows' => $qgroup['question_answer'], 'number' => $number_question)); ?>
                                </div>  
                                <?php $number_question += $qgroup['number_question'];?> 
                            <?php } ?>
                            <?php if ($nextSection = $arrQuestion[$qkey + 1]) {?>
                                <div class="passage-control">
                                    <a class="reading_change_section" href="javascript:void(0)" data-section="<?php echo $nextSection['question_id']; ?>"><?php echo $nextSection['title']; ?>&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            <?php }?>
                        </div>  
                    </div>
                    <?php $arrNumberCheck[$question['question_id']] = $number_question;?>
                    <?php } ?>
                </div>
                <?php } ?>
                <div class="col_right col-md-3 col-sm-3 col-xs-12" id="list_answer">
                    <div class="warp_content">
                        <div class="timer"><i class="fa fa-clock-o"></i><span id="show_count_down"></span></div>
                        <div class="scrollbar-inner">
                            <div class="col-xs-12">
                                <?php
                                $j = 1;
                                foreach ($arrNumberCheck as $question_id => $number_max) {
                                    for ($i = $j; $i < $number_max; $i++) {?>
                                        <div data-section="<?php echo $question_id; ?>" data-q="q-<?php echo $i?>" class="answer_recheck answer_recheck_item_<?php echo $i; ?> circle_number"><?php echo $i; ?></div>
                                    <?php }
                                    $j = $i;
                                }?>
                            </div>
<!--                            <div id="submit_answer_result" class="btn" style="    width: 100%;    background-color: #3597eb;    color: white;    font-size: medium;">Nộp bài</div>-->

                        </div>



                    </div>
                </div>
            </form>

        </div>
</section>

<!--Owl slider lib-->
<script type="text/javascript">
    $(function(){
        cal_main_height();
        jQuery('.scrollbar-inner').scrollbar();
        $(".reading_change_section").bind("click",function(){
            var section_id = $(this).attr("data-section");
            $(".question_section_content").hide();
            $("#question_section_" + section_id).show();

            $(".reading_change_section").removeClass("active");
            $("#question_setion_selection_" + section_id).addClass("active");

            $("table").colResizable({disable : true });
            $("#question_section_" + section_id).colResizable({liveDrag:true});
        });
        $("#test_form").find("select").bind("change",function(){
            var number = $(this).attr("data-question-number");

        });
        $(".answer_recheck").bind("click",function(){

        });
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

        /* $("#test_form").on("submit",function(e) {

              e.preventDefault(); // avoid to execute the actual submit of the form.

              var form = $(this);
              var url = form.attr('action');
              console.log(form.serialize());
              $.ajax({
                  type: "POST",
                  url: url,
                     data: form.serialize(), // serializes the form's elements.
                     success: function(data)
                     {
                         console.log(data);
                     }
                    });
              return false;

            }); */

        /// submit
        $("#submit_answer_result").bind("click",function(e){
            e.preventDefault(); // avoid to execute the actual submit of the form.
            e.stopPropagation();


            var r = confirm("Bạn có chắc muốn nộp bài ?");
            if (r === true) {
                $("#test_form").submit();
            }
            return false;

        });

        $(function(){
            jQuery('.scrollbar-inner').scrollbar();
            <?php foreach ($arrQuestion as $qkey => $question) { ?>
            $("#question_section_<?php echo $question['question_id']; ?>").colResizable({
                liveDrag:true,
                gripInnerHtml:"<div class='grip'></div>",
                draggingClass:"dragging",
                resizeMode:'fit',
                // disable: true
            });
            <?php } ?>
        });

        $('#list_answer').on('click', '.answer_recheck', function (event) {
            event.preventDefault();
            var id = $(this).attr('data-section');
            var qid = $(this).attr('data-q');

            var tagName = $("#"+ qid)[0].tagName;
            if($('#question_section_' + id + ':visible').length == 0){
                $("table.question_section_content").hide().colResizable({disable : true });
                $("#question_section_" + id).show().colResizable({liveDrag:true});
            }

            //Focus
            if (tagName === 'INPUT' || tagName === 'SELECT') {
                $("#"+ qid).focus();
            }
        })
    });


</script>