<?php
$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash(),
);
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
                        <?php
                        $i = 1; $test_time = 0;
                        //$test_time = 0;
                        foreach ($arrQuestion as $key => $question) { ?>
                            <?php $nextSetion = $arrQuestion[$key+1]?>
                            <li class="nav-item">
                                <a data-section="<?php echo $question['question_id']; ?>" data-index="<?php echo $i-1; ?>" id="question_setion_selection_<?php echo $question['question_id']; ?>" class="reading_change_section nav-link menu-link -custom-color-link <?php echo $i == 1 ? '-active' : '' ?>" href="javascript:;">
                                    <?php echo $question['title']; ?>
                                </a>
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

<section class="test-reading test-listening">
    <div class="container background-test">
        <div class="row">
            <div class="col group-test text-center">
                <div class="group-test__title">
                    <?php echo $test['title']?>
                </div>
                <div class="group-test__subtitle">
                    READING PRACTICE
                </div>
                <div class="group-test__custom-border-bottom"></div>
            </div>
        </div>
        <form class="form" method="POST" action="/test/result" id="test_form">
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
            <?php
            $number_question = 1;
            foreach ($arrQuestion as $qkey => $question) {
                ?>
                <div class="row no-gutters question_section_content" id="question_section_<?php echo $question['question_id']; ?>" <?php echo ($number_question != 1) ? 'style="display: none"' : '' ?>>
                    <div id="col1" class="col col_gutter read">
                        <h2 class="title"><?php echo $question['title']; ?></h2>
                        <div class="read_content">
                            <?php echo $question['detail']; ?>
                        </div>
                    </div>
                    <div id="col2" class="col col_gutter answer">
                        <?php $userAnswer = json_decode($arrLogDetail['answer_list'], TRUE);
                        foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) { ?>
                            <div class="question bg_warp mb30">
                                <h3><?php echo $qgroup['title']; ?></h3>
                                <p><?php echo $qgroup['detail']; ?></p>
                                <?php echo $this->load->view("test/question/type_" . $qgroup['type'], array('rows' => $qgroup['question_answer'], 'number' => $number_question, 'userAnswer' => $userAnswer, 'answerResult' => $arrAnswerResult)); ?>
                            </div>
                            <?php $number_question += $qgroup['number_question'];?>
                        <?php } ?>
                    </div>
                </div>
                <?php $arrNumberCheck[$question['question_id']] = $number_question;?>
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
            <div class="col-2">
                <button class="btn btn-outline-primary form-control" onclick="showQuestionsList()">
                    Bảng câu hỏi
                </button>
            </div>
            <div class="col-8 audio-player-time-countdown align-item-center">
                <!-- thời gian làm bài còn lại -->
                <div class="time-countdown align-item-center">
                    <span class="time-countdown__icon">
                        <span class="icon-round-timer-24px"></span>
                    </span>
                    <span class="time-countdown__time" id="show_count_down"></span>
                </div>
                <!-- kết thúc thời gian làm bài còn lại -->
            </div>
            <div class="col-2 passage-control">
                <?php foreach ($arrQuestion as $i => $question) {?>
                    <?php if ($nextSection = $arrQuestion[$i + 1]) {?>
                        <button class="btn btn-danger form-control reading_change_section" data-section="<?php echo $nextSection['question_id']; ?>" data-index="<?php echo $i+1?>" data-ci=<?php echo $i?> <?php echo $i != 0 ? 'style="display:none"' : ''?>><?php echo $nextSection['title']; ?>&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></button>
                    <?php } ?>
                <?php }?>
            </div>
            
        </div>

    </div>
</footer>

<!-- ------------------bảng câu hỏi----------------- -->
<section id="questions-list">
    <div class="container background-questions-list">
        <div class="row justify-content-between title-button-hide-questions-list">
            <div class="col-2  title-button-hide-questions-list__title">
                Bảng câu hỏi
            </div>
            <div class="col-2 text-right">
                <a class="button-hide-questions-list" onclick="hideQuestionsList()">
                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12  questions-list" id="list_answer">
                <?php
                    $j = 1;
                    $score_detail = @json_decode($arrLogDetail['score_detail'], TRUE);
                    $score_detail = $score_detail['arrAnswerTrue'];
                    $i = 1;
                    foreach ($arrAnswerResult as $answer_id => $arrAnswerLists) {
                        $data_section = $arr_id_answer_to_group_question[$answer_id];
                        foreach ($arrAnswerLists as $k => $value) {
                            ?>
                            <a href="javascript:;" data-section="<?php echo $data_section; ?>" class="<?php echo ($score_detail[$answer_id][$k] == 1) ? '-true' : '-false'; ?> answer_recheck answer_recheck_item_<?php echo $i; ?> questions-number" data-q="q-<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php $i++; }
                    } ?>
            </div>
        </div>
    </div>
</section>
<!-- kết thúc bảng câu hỏi -->

<style type="text/css">
    /* Only in showing */
    .tilte_explain_question{
        display: inline !important;
    }
    .content_explain_question{
        background-color: #eeff00 !important;
    }
</style>

<script src="<?php echo $this->config->item("js"); ?>split.min.js"></script>
<script type="text/javascript">
    $(function(){
        cal_main_height();
        jQuery('.scrollbar-inner').scrollbar();
        $(".reading_change_section").bind("click",function(){
            var section_id = $(this).attr("data-section");
            $(".question_section_content").hide();
            $("#question_section_" + section_id).show();

            $(".reading_change_section").removeClass("-active");
            $("#question_setion_selection_" + section_id).addClass("-active");

            $("table").colResizable({disable : true });
            $("#question_section_" + section_id).colResizable({liveDrag:true});

            //Show-hide next page
            var dataIndex = $(this).attr("data-index");
            $(".passage-control button").hide();
            $('.passage-control button[data-ci="' + dataIndex +'"]').show();
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
                $("div.question_section_content").hide().colResizable({disable : true });
                $("#question_section_" + id).show().colResizable({liveDrag:true});

                //Reactive section
                $(".reading_change_section").removeClass("-active");
                $("#question_setion_selection_" + id).addClass("-active");
            }

            //Focus
            if (tagName === 'INPUT' || tagName === 'SELECT') {
                $("#"+ qid).focus();
            }
        })
    });


    /* JS Goes Here */
    if ($(document).width() > 768) {
        Split(['#col1', '#col2'], {
            elementStyle: (dimension, size, gutterSize) => ({
                'flex-basis': `calc(${size}% - ${gutterSize}px)`,
            }),
            gutterStyle: (dimension, gutterSize) => ({
                'flex-basis':  `5px`,
            }),
            minSize: 500
        });
    }

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