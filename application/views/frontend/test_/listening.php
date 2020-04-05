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
                        $i = 1; $time = 0;
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

<section class="test-listening listening-test_container">
    <div class="container background-test">
        <div class="row">
            <div class="col group-test text-center">
                <div class="group-test__title">
                    <?php echo $test['title']?>
                </div>
                <div class="group-test__subtitle">
                    LISTENING PRACTICE
                </div>
                <div class="group-test__custom-border-bottom"></div>
            </div>
        </div>
        <form class="form" method="POST" action="/test/result" id="test_form">
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
                foreach ($arrQuestion as $qkey => $question) {
            ?>
                <div class="row question_section_content" id="question_section_<?php echo $question['question_id']; ?>" <?php echo $number_question != 1 ? 'style="display: none"' : ''?> >
                    <?php foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) { ?>
                        <div class="col-7 ">
                            <div class="questions">
                                <div class="questions__title" style="border: none;">
                                    <?php echo $qgroup['title']; ?>
                                </div>
                                
                            </div>
                            <p><?php echo $qgroup['detail']; ?></p>

                        </div>
                        <div class="col-5">
                            <div class="row group-button">
                                <div class="col-xl-6 col-lg-6 col-md-12 custom-col">
                                    <button type="button" class="listening audio_start_time group-button__button-listen btn btn-outline-primary form-control" data-audio-time="<?php echo $qgroup['audio_start_time']?>">
                                        Listen From Here
                                    </button>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 custom-col">
                                    <button type="button" class=" =group-button__button-show-notepad btn btn-outline-primary form-control" onclick="onClickShowNotepad(this,<?php echo $key?>)">
                                        Show Notepad
                                        <!-- viet hoa chu cai dau -->
                                    </button>
                                </div>
                                <div class="col-sm-12 custom-col form-textarea-notepad" id="show_note_pad_<?php echo $key?>" style="display: none;">
                                    <textarea name="" placeholder="" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row form-answer">
                                <?php echo $this->load->view("test/question/type_" . $qgroup['type'], array('rows' => $qgroup['question_answer'], 'number' => $number_question)); ?>
                            </div>
                        </div>
                        <?php $number_question += $qgroup['number_question'];?>
                    <?php } ?>
                </div>
                <?php $arrNumberCheck[$question['question_id']] = $number_question; ?>
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
                <!-- file audio -->
                <?php echo $this->load->view('common/player'); ?>
                <!-- kết thúc file audio -->

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
                    <?php } else { ?>
                        <button data-ci="<?php echo $i?>" class="btn btn-danger form-control" type="submit" id="submit_answer_result" style="display: none">Nộp bài</button> 
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
                foreach ($arrNumberCheck as $question_id => $number_max) {
                    for ($i = $j; $i < $number_max; $i++) {?>
                        <a href="javascript:;" data-section="<?php echo $question_id; ?>" class="answer_recheck answer_recheck_item_<?php echo $i; ?> questions-number -not-done-yet" data-q="q-<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php }
                    $j = $i;
                }?>
            </div>
        </div>
    </div>
</section>
<!-- kết thúc bảng câu hỏi -->

<script type="text/javascript">
    $(document).ready(function(){
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
                this_countdown.html(event.strftime('%M:%S'));
            }
        });

        var arrPlaylist = [];

        <?php foreach ($arrQuestion as $key => $question) {?>
            arrPlaylist.push({
                    title:"<?php echo $question['title']; ?>",
                    mp3:"<?php echo UPLOAD_URL . 'sound/' . $question['sound']; ?>",
                });
        <?php }?>

    var myPlaylist = new jPlayerPlaylist({
    jPlayer: "#jquery_jplayer_playlist",
    cssSelectorAncestor: "#jp_container_playlist"
        }, arrPlaylist, {
            volume: 1.0,
            playlistOptions: {
                //autoPlay: true,
                shuffleOnLoop: false
            },
            swfPath: "js",
            supplied: "oga, mp3",
            wmode: "window",
            useStateClassSkin: true,
            autoBlur: false,
            //autoplay: true,
            smoothPlayBar: true,
            keyEnabled: true
        });

        jQuery('.scrollbar-inner').scrollbar();
            $(".reading_change_section").bind("click",function(){
                var section_id = $(this).attr("data-section");
                $(".question_section_content").hide();
                $("#question_section_" + section_id).show();

                $(".reading_change_section").removeClass("-active");
                $("#question_setion_selection_" + section_id).addClass("-active");

                var dataIndex = $(this).attr("data-index");
                myPlaylist.play(dataIndex);

                //Show-hide next page
                $(".passage-control button").hide();
                $('.passage-control button[data-ci="' + dataIndex +'"]').show();
            });
            $("#test_form").find("select").bind("change",function(){
                var number = $(this).attr("data-question-number");

            });
            $(".answer_recheck").bind("click",function(){

        });
        // USERS ANSWER //
        $("#submit_answer_result").bind("click",function(){
            var r = confirm("Bạn có chắc muốn nộp bài ?");
            if (r == true) {
                $("#test_form").submit();
            }
            return false;

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

            console.log(tagName+qid);

            //Focus
            if (tagName === 'INPUT' || tagName === 'SELECT' || tagName === 'DIV') {
                $("#"+ qid).focus();
            }
        });

        $('body').on('click', '.audio_start_time', function (event) {
            var audio = document.getElementById("jp_audio_0");
            audio.play();
            audio.currentTime = $(this).data("audio-time"); // jumps to audio time
        });

    });
</script>