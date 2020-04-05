<?php
$arrTestType = $this->config->item('test_type');
$test_type = $arrTestType[$type];
?>
<section class="result-listen container clearfix m_height">
	<?php echo $this->load->view('common/breadcrumb'); ?>
    <div class="row">
        <div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12">
            <div class="warp_bg mb20">
                <div class="information">
                    <div class="information__title">
                        <?php echo $testDetail['title']; ?> - <?php echo $test_type; ?>
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
                        <a href="<?php echo $this->config->item('score_table')?>" class="result-main-link-detail">
                            Bảng quy điểm&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>

                    <!--Bắt đầu kết quả-->
                    <div class="row circle">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-tn-12 circle__correct-answers">
                            <div class="c100 number p<?php echo round($answer_true / $total_question * 100); ?>">
                                <span><?php echo $answer_true; ?></span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                            <div class="circle__title">Số câu trả lời đúng</div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-tn-12 circle__your-point">
                            <div class="c100 point p<?php echo ceil($score_converted / 9 * 100); ?>">
								                <span><?php echo $score_converted; ?></span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                            <div class="circle__title">Điểm của bạn</div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 col-tn-12 circle__your-time">
                            <div class="c100 time p<?php echo $spent_time_percent; ?>">
                                <span><?php echo $spent_time; ?></span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                            <p>Thời gian làm bài</p>
                        </div>
                    </div>
                    <!--Kết thúc kết quả-->
                    <hr>
                    <div class="wrap_bg">
                        <div class="row result-notification">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-tn-12">
                                <div class="result-notification__title">
                                    <?php echo $score_text; ?>
                                </div>
                                <div class="detail_tin" style="text-align: initial">
                                    <?php echo $score_suggest; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="center button-action">
                                <a class="btn btn-primary button-action__answer" href="/test/review_result/<?php echo $test_log_id; ?>/<?php echo $this->security->generate_token_post($test_log_id); ?>">Xem đáp án</a>
                                <a class="btn button-action__reset" href="<?php echo $replay_url; ?>">Làm lại đề thi này</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--    End result listen-->
            <div class="warp_bg">
                <table class="table table-bordered">
                    <thead align="center">
                        <tr>
                            <th>STT</th>
                            <th colspan="2">Câu trả lời của bạn</th>
                            <th>Đáp án</th>                                      
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number_question = 1; ?>
                        <?php foreach ($arrAnswerResult as $key1 => $arrAnswerLists) { 
                            $userAnswer = $arrUserAnswer[$key1];
                            $check_count = (!$userAnswer || count($userAnswer) != count($arrAnswerLists)) ? FALSE : TRUE;
                            if ($check_count == TRUE) {
                                reset($userAnswer);
                            }
                            foreach ($arrAnswerLists as $key2 => $value) {
                        ?>
                        <?php 
                        if($check_count == TRUE AND strtolower(trim($value['answer'])) == strtolower(trim($userAnswer[$key2]))){
                            $class_name = 'text-true';
                            $fa_name = 'fa-check';
                        }else{
                            $class_name = 'text-false';
                            $fa_name = 'fa-times';
                        } 
                        ?>
                            <tr>
                                <td><?php echo $number_question; ?></td>
                                <td class="<?php echo $class_name?>"><?php echo $userAnswer[$key2]; ?></td>
                                <td class="<?php echo $class_name?>"><i class="fa <?php echo $fa_name?>" aria-hidden="true"></i></td>
                                <td><?php echo $value['answer']; ?></td>                                     
                            </tr>
                            <?php $number_question++; } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12 mb20">
            <div class="category">
                <?php echo $this->load->view("block/contact")?>
            </div>
            <?php echo $this->load->get_block('right'); ?>
        </div>
    </div>
    <!-- TIN QUAN TÂM -->
    <div class="warp_bg mb20 art_other grid4">
         <h2>Các bài test khác</h2>
         <div class="list_learn list_learn_other">
            <div class="row">
                <?php foreach ($arrTestRelate as $key => $testDetail) {?>
                <?php $share_url = str_replace('/test/', '/test/'.strtolower($testDetail['test_list'][0]).'/', $testDetail['share_url']).'?skill=1'; ?>
                <div class="col-md-3 col-sm-3 col-xs-3 col-tn-12 mb10">
                    <div class="ava">
                        <a href="<?php echo $share_url; ?>" title="<?php echo $testDetail['title']; ?>">
                            <span class="thumb_img thumb_5x3"><img title="" src="<?php echo getimglink($testDetail['images'], 'size6'); ?>" alt=""></span>
                        </a>
                    </div>
                    <div class="content">
                      <h3><a href="<?php echo $share_url; ?>" title="<?php echo $testDetail['title']; ?>"><?php echo $testDetail['title']; ?></a></h3>
                      <p><?php echo $testDetail['test_list'][0]?></p>
                    </div>
                </div>
                <?php }?>

          </div>
        </div>
      </div>
    <?php echo $this->load->get_block('left_content'); ?>
</section>

<div id="result-popup" class="white-popup mfp-hide">
  <div class="content_poup width_common">
      <h2>Số câu trả lời đúng</h2>
      <div class="warp">
          <div class="scrollbar-inner">
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 col-tn-12 mb20">
                  <div class="c100 number p<?php echo round($answer_true / $total_question * 100); ?>">
                    <span><?php echo $answer_true; ?>/<?php echo $total_question; ?></span>
                    <div class="slice">
                      <div class="bar"></div>
                      <div class="fill"></div>
                    </div>
                  </div>
                  <strong>Số câu trả lời đúng</strong>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 col-tn-12 mb20">
                  <div class="c100 point p<?php echo round($score_converted / 9 * 100); ?>">
                    <span><?php echo $score_converted?></span>
                    <div class="slice">
                      <div class="bar"></div>
                      <div class="fill"></div>
                    </div>
                  </div>
                  <strong>Điểm của bạn</strong>
                </div>
              </div>
              <a href="<?php echo $this->config->item('score_table')?>"><i class="fa fa-table"></i>&nbsp;&nbsp;Bảng quy điểm</a>
              <div class="list-result">
        		<?php
					$number_question = 1;
					$number_answer = 1;
					$number_break = round($total_question / 2);
				?>
                  	<div class="left result">
                      	<h4>Câu trả lời của bạn</h4>
                      	<ul>
                      		<li>
                      	<?php foreach ($arrAnswerResult as $key1 => $arrAnswerLists) {
							$userAnswer = $arrUserAnswer[$key1];
							$check_count = (!$userAnswer || count($userAnswer) != count($arrAnswerLists)) ? FALSE : TRUE;
							if ($check_count == TRUE) {
								reset($userAnswer);
							}
							foreach ($arrAnswerLists as $key2 => $value) {
							?>
                              <p class="<?php echo ($check_count == TRUE AND strtolower(trim($value['answer'])) == strtolower(trim($userAnswer[$key2]))) ? 'true' : 'false'; ?> "><span><?php echo $number_question; ?>. <?php echo $userAnswer[$key2]; ?></span></p>

                        <?php
							if ($number_question == $number_break) {
								echo '</li><li>';
							}
							$number_question++;}}?>
                        </li>
                      </ul>
                  </div>
                  <div class="right result">
                      <h4>Đáp án</h4>
                      <ul>
                      	<li>
                      	<?php
							foreach ($arrAnswerResult as $key1 => $arrAnswerLists) {
								$userAnswer = $arrUserAnswer[$key1];
								if ($userAnswer) {
									reset($userAnswer);
								}

							foreach ($arrAnswerLists as $key2 => $value) {
							?>
                              <p><strong><?php echo $number_answer; ?>. <?php echo $value['answer']; ?></strong></p>
                        <?php
							if ($number_answer == $number_break) {
										echo '</li><li>';
									}

							$number_answer++;}}?>
                        </li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<!--END POPUP-->
<script src="<?php echo $this->config->item("js"); ?>jquery.scrollbar.min.js"></script>
<script src="<?php echo $this->config->item("js"); ?>jquery.magnific-popup.min.js"></script>
<script>
  $(document).ready(function () {
    jQuery('.scrollbar-inner').scrollbar();
    $('.open-popup-link').magnificPopup({
      type:'inline',
      midClick: true,
      mainClass: 'mfp-with-zoom',
      fixedContentPos: false,
      fixedBgPos: true,
      overflowY: 'auto',
      closeBtnInside: true,
      preloader: false,
      removalDelay: 300,
    });
  });
</script>