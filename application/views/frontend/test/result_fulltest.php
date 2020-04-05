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
                            Bấm vào từng kỹ năng để xem chi tiết (Listening & Reading)
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
                                <a class="skill-point__content" href="/test/review_result/<?php echo $test_logs[1]['logs_id']; ?>/<?php echo $this->security->generate_token_post($test_logs[1]['logs_id']); ?>">
                                    Listening: <span class="text-blue"><?php echo $test_logs[1]['score']?></span>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if($test_logs[3]) { ?>
                            <div class="skill-point -custom-skill-point-2">
                                <div class="skill-point__logo -custom-logo-2">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </div>
                                <a class="skill-point__content" href="javascript:;">
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
                                <a class="skill-point__content" href="/test/review_result/<?php echo $test_logs[2]['logs_id']; ?>/<?php echo $this->security->generate_token_post($test_logs[2]['logs_id']); ?>">
                                    Reading: <span class="text-blue"><?php echo $test_logs[2]['score']?></span>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if($test_logs[4]) { ?>
                            <div class="skill-point -custom-skill-point-2">
                                <div class="skill-point__logo -custom-logo-3">
                                    <i class="fa fa-microphone" aria-hidden="true"></i>
                                </div>
                                <a class="skill-point__content" href="javascript:;">
                                    Speaking
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
                                <div class="result-notification__title">
                                    <p><span style="font-size:18px;"><strong>Chúc mừng bạn đã hoàn thành xuất sắc bài thi thử IELTS Online Full test 4 kỹ năng <br>tại Aland IELTS.</strong></span></p>
                                </div>
                                <div class="detail_tin" style="text-align: initial">
                                    <p>Các bạn có thể click vào kết qua của từng phần để xem đáp án chi tiết. (Reading & Listening)</p>
                                    <p>Riêng với 2 kỹ năng Writing và Speaking, bài làm của bạn sẽ được chấm điểm và phân tích chi tiết bới đội ngũ chuyên gia 8.0 IELTS. Và trả kết quả cho bạn qua mail đăng ký tài khoản. Các bạn nhớ check maill thường xuyên nhé.</p>
                                    <p>Ngoài ra, các chuyên gia IELTS của Aland đã tổng hợp những <strong style="background-color: #ffff66">Bộ tài liệu luyện thi IELTS cực chất</strong> giúp bạn nâng cao và có sự chuẩn bị tốt nhất cho kỳ thi IELTS sắp tới. Tham khảo ngay các bạn nhé:</p>
                                    <ul>
                                        <li><a href="https://www.aland.edu.vn/tin-tuc/sach-luyen-thi-ielts-37743.html">Top sách luyện thi IELTS tốt nhất (Cơ Bản -> Nâng Cao)</a></li>
                                        <li>
                                            <a href="https://www.aland.edu.vn/tin-tuc/sach-luyen-thi-ielts-reading-37729.html">
                                                Tổng hợp sách luyện thi IELTS Reading từ Cơ bản đến Nâng cao
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.aland.edu.vn/tin-tuc/sach-luyen-thi-ielts-listening-37731.html">
                                                Trọn bộ sách luyện thi IELTS Listening từ cơ bản đến nâng cao
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.aland.edu.vn/tin-tuc/tai-lieu-luyen-thi-ielts-speaking-37732.html">
                                                Trọn bộ tài liệu luyện thi IELTS Speaking từ Cơ bản đến Nâng cao
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.aland.edu.vn/tin-tuc/sach-luyen-thi-ielts-writing-37730.html">
                                                Trọn bộ tài liệu luyện thi IELTS Writing theo Band 1.0 - 9.0
                                            </a>
                                        </li>
                                    </ul>
                                    <p><strong><i>Chúc các bạn ôn luyện hiệu quả và cán mốc số điểm IELTS mà mình mong muốn trong kỳ thi IELTS sắp tới. Fighting! <(^.^)></i></strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="center button-action">
                                <a class="btn button-action__reset" href="<?php echo SITE_URL.$replay_url; ?>">Làm lại đề thi này</a>
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

<style type="text/css">
    .result-main ul li a{
        color: blue;
    }
</style>