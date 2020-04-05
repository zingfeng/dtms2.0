<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<form id="testing_form" action="<?php echo SITE_URL; ?>/test/result" method="POST">
    <input type="hidden" name="test_id" value="<?php echo $test['test_id']?>"/>
    <input type="hidden" name="log_id" value="<?php echo $log_id?>"/>
    <input type="hidden" name="token" value="<?php echo $this->security->generate_token_post(array($test['test_id'],$log_id)); ?>">
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?php echo $breadcrumb; ?>  
        <div class="col_box_test">
            <h1><?php echo $test['title']?></h1>
            <div class="part" id="fulltest_part_head">
                <?php 
                $i = 1;
                foreach ($arrPart as $key => $part){ ?>
                    <div class="fulltest_part item" data-part="<?php echo $part?>">
                        <a class="<?php echo $i == 1 ? 'active' : ''?>" href="javascript:;">Part <?php echo $part?></a>
                    </div>
                <?php $i++; } ?>
                <div class="item" id="test_score" style="display: none;">
                    <a href="javascript:;">
                        <strong></strong>
                        <span>Score</span>
                    </a>
                </div>
            </div>
            <div class="clear col_box_baihoc_view" id="fulltest_content">
                <?php $i = 1; $page = 1;
                foreach($question as $part => $arrQuestion) { ?> 
                    <?php foreach ($arrQuestion as $item) { ?>
                    <div data-part="<?php echo $item['type']; ?>" class="question fullest_page_<?php echo $page; ?>" data-page="<?php echo $page; ?>" style="display: <?php echo ($i == 1) ? 'block' : 'none' ; ?>;" id="test_question_<?php echo $item['question_id']; ?>">
                        <?php
                        $this->load->view('test/skill/question_'.$item['type'],array('question' => $item,'page' => $i),FALSE);  
                        $i = $i + count($item['answer']); 
                        $page ++;
                        ?>
                    </div>
                    <?php }?>
                <?php } ?>
            </div>
            <div class="pageing" id="fulltest_page" data-page="1" data-limit="<?php echo $page; ?>">
                <a href="javascript:void(0)" style="display: none;" data-type="-1" class="button_page back">BACK</a>
                <a href="javascript:void(0)" class="button_page next" data-type="1">NEXT</a>
                <a id="button_send_answer" class="btn btn-danger" onclick="return mshoatoeic.send_answer_fulltest()">Chấm điểm</a>
            </div>
        </div><!-- End -->

        <!-- Tài liệu luyện thi toeic -->
        <?php if (DEVICE_ENV == 4) { ?>
        <div class="hidden-xs hidden-sm">
                <?php echo $this->load->get_block('content'); ?> 
        </div>
        <?php } ?>
    </div> 
</form>
<div class="col-md-4 col-sm-4 col-xs-12" id="test_col_right" style="position: relative;">
    
    <div class="box_ketqua" id="test_ketqua">
        <div class="head">
            <a class="check" href="javascript:void(0)" id="test_result" onclick="return mshoatoeic.send_answer_fulltest()"><i></i><span>Chấm điểm</span></a>
            <div class="timer" id="show_count_down"></div>
            <a href="javascript:;" onclick="return location.reload()" class="refresh"><i></i><span>Làm lại</span></a>
            <div class="clearfix"></div>
        </div>
        <div class="list">
            <div class="scrollbar-inner" id="fulltest_question_shortcut">
                <?php $i= 1; $page = 1;
                foreach($question as $part => $arrQuestion) { 
                    foreach ($arrQuestion as $item) {
                        foreach ($item['answer'] as $answer) { ?>
                            <div class="cau cau_<?php echo $i; ?>" data-iquestion="<?php echo $i?>" data-page="<?php echo $page; ?>" data-question="<?php echo $item['question_id']?>" >
                                <a href="javascript:void(0)"><?php echo $i?></a>
                            </div>
                        <?php $i++; }
                        $page ++;
                    }
                } ?>
            </div>      
        </div>
        <div class="clearfix"></div>
    </div>


    <?php //echo $this->load->get_block('right'); ?>
    <!--<div class="sidebar-block"> 
        <div class="title-header-bl"><h2>FANPAGE</h2><span><i class="fa fa-angle-right arow"></i></span></div>
        <div class="fb-page" data-href="<?php echo $this->config->item('facebook');?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $this->config->item('facebook');?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $this->config->item('facebook');?>">Facebook</a></blockquote></div>
    </div>--><!--End-->
</div>
<!--<script type="text/javascript" src="<?php echo $this->config->item("js"); ?>jquery.scrollbar.min.js"></script>-->
<?php
$test_time = $test['test_time']*60*1000;
$html = <<<HTML
<script type="text/javascript" src="{$this->config->item('js')}mshoatoeic.js"></script>
<script type="text/javascript" src="{$this->config->item('js')}jquery.countdown.min.js"></script>
<script>
    $(document).ready(function() {
        window.onbeforeunload = function() {
            return "Data will be lost if you leave the page, are you sure?";
        };
        // scroll box ket qua
        //$('.scrollbar-inner').scrollbar();
        // count downtime
        function liftOff() {
            mshoatoeic.send_answer_fulltest();
        }

        var fiveSeconds = new Date().setTimeCurrent() + {$test_time};
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
        })
        /////////// SCROLL BAR RESULT /////////
        var window_width = $(window).width();
        if (window_width >= 992) {
            var boxketqua_top = $("#test_ketqua").offset().top;
            var boxketqua_head_height = $("#test_ketqua").find(".head").height() + 30;
            var window_height = $(window).height();
            $( window ).scroll(function() {
                var bottom_top = $("#layout_footer").offset().top;
                var wintop = $(this).scrollTop();
                var margin = wintop - boxketqua_top;
                $("#test_col_right").height(bottom_top - boxketqua_top - 30);
                if ((wintop + window_height) > bottom_top) {
                    $("#test_ketqua").find(".list").height(window_height);
                    $("#test_ketqua").css({"position":"absolute","top" : "auto", "bottom": 0, "left": 15, "right": 15});
                }
                else if (margin > 0) {
                    $("#test_ketqua").find(".list").height(window_height - boxketqua_head_height);
                    $("#test_ketqua").css({"position":"absolute","margin-top": 0,"top" : margin + 3, "bottom": 0, "left": 15, "right": 15});
                }
                else {
                    $("#test_ketqua").find(".list").height(window_height + margin - boxketqua_head_height);
                    $("#test_ketqua").css({"position":"relative","top" : 0, "bottom": 0, "left":0, "right": 0});
                }
            });
        }

    });
</script>
HTML;
$this->load->push_section('script','test_page',$html);
?>