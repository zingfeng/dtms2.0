<section class="result-fulltest container clearfix m_height">
    <?php echo $this->load->view('common/breadcrumb'); ?>
    <div class="row">
        <div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12">
            <div class="warp_bg mb20">
                <div class="information">
                    <div class="information__title">
                        <?php echo $testDetail['title']?>
                    </div>
                    <div class="information__view">
                        <i class="fa fa-file-text-o"></i>
                        Số lần test: <span class="number-test"><?php echo $testDetail['total_hit']?></span>
                    </div>
                </div>
                <hr>
                <!--   start result-listen-->
                <div class="border_top result-main">
                    <div class="result-main__title">Kết quả của bạn</div>
                    <div class="result-main__subtitle">
                        <a href="javascript:;" class="result-main-link-detail">
                            Bấm vào từng kỹ năng để xem chi tiết
                        </a>
                    </div>

                    <!--Bắt đầu kết quả-->
                    <div class="row circle list-skill-point">     
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-tn-12 circle__your-time">
                            <div class="c100 time p75">
                                <span><?php echo $spent_time?></span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                            <div class="circle__title">Thời gian làm bài</div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <?php if($test_logs[1]) { ?>
                            <div class="skill-point -custom-skill-point-1">
                                <div class="skill-point__logo -custom-logo-1">
                                    <i class="fa fa-headphones" aria-hidden="true"></i>
                                </div>
                                <a class="skill-point__content" href="">
                                    Listening: <span class="text-blue"><?php echo $test_logs[1]['score']?></span>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if($test_logs[3]) { ?>
                            <div class="skill-point -custom-skill-point-2">
                                <div class="skill-point__logo -custom-logo-2">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </div>
                                <a class="skill-point__content" href="">
                                    Writing
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <?php if($test_logs[2]) { ?>
                            <div class="skill-point -custom-skill-point-1">
                                <div class="skill-point__logo -custom-logo-1">
                                    <i class="fa fa-book" aria-hidden="true"></i>
                                </div>
                                <a class="skill-point__content" href="">
                                    Reading: <span class="text-blue"><?php echo $test_logs[2]['score']?></span>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if($test_logs[4]) { ?>
                            <div class="skill-point -custom-skill-point-2">
                                <div class="skill-point__logo -custom-logo-3">
                                    <i class="fa fa-microphone" aria-hidden="true"></i>
                                </div>
                                <a class="skill-point__content" href="">
                                    Speaking: <span class="text-blue"><?php echo $test_logs[4]['score']?></span>
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <!--Kết thúc kết quả-->
                    <hr>
                    <div class="wrap_bg">
                        <div class="row result-notification">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-tn-12">
                                <div class="result-notification__title"><?php echo $score_text?></div>
                                <div class="result-notification__sub-title"><?php echo $score_suggest; ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="center button-action">
                                <button class="btn button-action__reset" href="<?php echo $replay_url; ?>">Làm lại đề thi này</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--    End result listen-->
        </div>

        <div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12 mb20">
            <div class="category">
                <?php echo $this->load->view("block/contact")?>
            </div>
            <?php echo $this->load->get_block('right'); ?>
        </div>
    </div>
    <!-- TIN QUAN TÂM -->
    <?php echo $this->load->get_block('left_content'); ?>
</section>