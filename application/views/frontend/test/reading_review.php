<?php

$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash(),
);
?>
<section class="listening-test_head clearfix">
    <div class="container">
        <div class="show_test" id="show_test_info" style="display: none;">
            <div class="book left">
                <img src="<?php echo $this->config->item("img"); ?>icons/book.png" alt="">
                <a href="<?php echo $cateDetail['share_url']; ?>"><h4><?php echo $cateDetail['name']; ?></h4></a>
            </div>
            <div class="info right">
                <div class="date">
                    <p><i class="fa fa-calendar"></i>Ngày đăng: 22/11/2018</p>
                    <p><i class="fa fa-file-text-o"></i>Số lần test: 100</p>
                    <!--<p><i class="fa fa-file-zip-o"></i>Người tạo: Aland IELTS</p>-->
                </div>
                <div class="user">
                    <div class="content">
                        <h4><?php echo $test['title']; ?></h4>
                        <p>Biên soạn bởi Aland English - Expert in IELTS</p>
                    </div>
                    <img class="ava" src="<?php echo $this->config->item("img"); ?>graphics/thumb_5x4.jpg" alt="">
                </div>
            </div>
        </div>
        <a class="img_logo" href="<?php echo BASE_URL; ?>">
            <img class="logo_web" src="<?php echo $this->config->item("img"); ?>graphics/logo.png" alt="Trang chủ"
                 data-was-processed="true">
        </a>
        <div class="select_sever">
            <span class="hidden-xs">Chọn Section</span>
            <?php
            $i = 1;
            $time = 0;
            foreach ($arrQuestion as $key => $question) {
                if ($i % 2 == 1 && $i != 1) {
                    echo '<div class="clearfix visible-xs"></div>';
                }

                ?>
                <a data-section="<?php echo $question['question_id']; ?>"
                   id="question_setion_selection_<?php echo $question['question_id']; ?>"
                   class="reading_change_section <?php if ($i == 1) {
                       echo 'active';
                   }
                   ?>" href="javascript:void(0)"><?php echo $question['title']; ?></a>
                <?php $i++;
                $test_time += $question['test_time'] * 60 * 1000;
                //var_dump($test_time); die;
            } ?>
        </div>
        <div class="option_listening">
            <div class="social_share">
                <div class="fb-share-button" data-href="<?php echo SITE_URL . $newsDetail['share_url'] ?>"
                     data-layout="button_count" data-size="small" data-mobile-iframe="true">
                     <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url ?>" class="fb-xfbml-parse-ignore">Chia sẻ</a>
                </div>
                <div class="fb-like" data-href="<?php echo SITE_URL . $newsDetail['share_url'] ?>"
                     data-layout="button_count" data-action="like" data-size="small" data-show-faces="true"
                     data-share="false"></div>
            </div>
            <a href="javascript:void(0)" class="show_info_test">Show info test<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
        </div>
    </div>
</section>


<section class="listening-test_container reading-test clearfix">
    <?php echo $this->load->view('test/common/skill_menu_mobile', array('test' => $test, 'type' => 'reading')); ?>
    <div class="container max_width warp_slidebar">
        <?php echo $this->load->view('test/common/skill_menu', array('test' => $test, 'type' => 'reading')); ?>
        <div class="row slidebar_2">
            <form class="form" method="POST" action="<?php echo SITE_URL; ?>/test/result" id="test_form">
                <input type="hidden" name="test_id" value="<?php echo $test['test_id']; ?>">
                <input type="hidden" name="type" value="<?php echo $keyType; ?>">
                <input type="hidden" name="start_time" value="<?php echo $start_time; ?>">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>"/>
                <?php if(!isMobileDevice()) { ?>
                    <div class="col_left col-md-9 col-sm-9 col-xs-12">
                        <?php
                        $number_question = 1;
                        foreach ($arrQuestion as $qkey => $question) {
                            ?>
                            <table id="question_section_<?php echo $question['question_id']; ?>"
                                   class="question_section_content" <?php echo ($number_question != 1) ? 'style="display: none"' : '' ?>
                                   width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <div class="warp_content">
                                            <div id="question_section_<?php echo $question['question_id']; ?>_div_scroll" class="scrollbar-inner">
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
                                                <?php
                                                $userAnswer = json_decode($arrLogDetail['answer_list'], TRUE);
                                                foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) {
                                                    ?>
                                                    <h3><?php echo $qgroup['title']; ?></h3>
                                                    <div class="mb20"><?php echo $qgroup['detail']; ?></div>
                                                    <?php echo $this->load->view("test/question/type_" . $qgroup['type'], array('rows' => $qgroup['question_answer'], 'number' => $number_question, 'userAnswer' => $userAnswer, 'answerResult' => $arrAnswerResult)); ?>
                                                    <?php $number_question += $qgroup['number_question']; ?>
                                                <?php } ?>
                                                <?php if ($nextSection = $arrQuestion[$qkey + 1]) { ?>
                                                    <div class="passage-control">
                                                        <a class="reading_change_section" href="javascript:void(0)"
                                                           data-section="<?php echo $nextSection['question_id']; ?>"><?php echo $nextSection['title']; ?>
                                                            &nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $arrNumberCheck[$question['question_id']] = $number_question; ?>
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
                                    <?php echo $this->load->view("test/question/type_" . $qgroup['type'], array('rows' => $qgroup['question_answer'], 'number' => $number_question, 'userAnswer' => $userAnswer, 'answerResult' => $arrAnswerResult)); ?>
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
                                $score_detail = @json_decode($arrLogDetail['score_detail'], TRUE);
                                $score_detail = $score_detail['arrAnswerTrue'];
                                $i = 1;
                                foreach ($arrAnswerResult as $answer_id => $arrAnswerLists) {
                                    $data_section = $arr_id_answer_to_group_question[$answer_id];
                                    foreach ($arrAnswerLists as $k => $value) {
                                        ?>
                                        <div data-section="<?php echo $data_section;?>" data-q="q-<?php echo $i?>"
                                             class="<?php echo ($score_detail[$answer_id][$k] == 1) ? 'circle_number_success' : 'circle_number_unsuccess'; ?> answer_recheck answer_recheck_item_<?php echo $i; ?> circle_number"><?php echo $i; ?></div>
                                        <?php $i++;
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(function () {
        jQuery('.scrollbar-inner').scrollbar();
        $(".reading_change_section").bind("click", function () {
            var section_id = $(this).attr("data-section");
            $(".question_section_content").hide();
            $("#question_section_" + section_id).show();

            $(".reading_change_section").removeClass("active");
            $("#question_setion_selection_" + section_id).addClass("active");

            $("table").colResizable({disable: true});
            $("#question_section_" + section_id).colResizable({liveDrag: true});
        });
    });
    $(function () {
        jQuery('.scrollbar-inner').scrollbar();
        <?php foreach ($arrQuestion as $qkey => $question) { ?>
        $("#question_section_<?php echo $question['question_id']; ?>").colResizable({
            liveDrag: true,
            gripInnerHtml: "<div class='grip'></div>",
            draggingClass: "dragging",
            resizeMode: 'fit',
            // disable: true
        });
        <?php } ?>
        $('#list_answer').on('click', '.answer_recheck', function (event) {
            event.preventDefault();
            var id = $(this).attr('data-section'); // data section in prob
            var qid = $(this).attr('data-q');
            if($('#question_section_' + id + ':visible').length == 0){
                $("table.question_section_content").hide().colResizable({disable : true });
                $("#question_section_" + id).show().colResizable({liveDrag:true});
            }
            $('#' + qid).focus();
        })
    });

    // EVENT SCROLL
    $(document).ready(function () {        //
        $(".tilte_explain_question").each(function () {
            var id_question_inner = $(this).html();
            id_question_inner = id_question_inner.replace(" ", "");

            if (id_question_inner.indexOf('+') !== -1)
            {
                // check if contain +
                var id_question_arr = id_question_inner.split("+");
                for (var i = 0; i < id_question_arr.length; i++) {
                    var mono_id_question = id_question_arr[i];
                    var span_inside = '<span id="tilte_explain_question' + mono_id_question + '" ></span>';
                    $(this).append(span_inside);
                }
            }else{
                $(this).attr('id','tilte_explain_question' + id_question_inner);
            }
        });

        $(".number_question").each(function () {
            var id_question = $(this).html();
             $(this).attr('tabindex','-1'); // div element need this attribute to be focued
            $(this).attr('id','q-'+id_question);
            $(this).click(function () {
            Scroll_to_Explain(id_question);});
        });
    });

    jQuery.fn.scrollTo = function(elem) {
        $(this).scrollTop($(this).scrollTop() - $(this).offset().top + $(elem).offset().top);
        return this;
    };

    function Scroll_to_Explain(id_question) {
        var id_question_section_content_showing = '';
        $(".question_section_content").each(function () {
            var show = $(this).css("display");
            if (show !== 'none')
            {
                id_question_section_content_showing = $(this).attr('id');
            }
        });


        $('#' + id_question_section_content_showing + '_div_scroll').scrollTo("#tilte_explain_question"+ id_question, 1000); //custom animation speed
    }
</script>