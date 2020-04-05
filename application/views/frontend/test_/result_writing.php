<?php
	$arrTestType = $this->config->item('test_type');
	$test_type = $arrTestType[$type];
?>
<section class="result-writing container clearfix m_height">
	<?php echo $this->load->view('common/breadcrumb');?>
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

                <!--   start result-writing-->
                <ul class="nav nav-tabs task-navigation">
                	<?php $i = 1; foreach($arrQuestion as $question_id => $question) { ?>
                		<li role="presentation" class="change_section <?php echo $i == 1 ? 'active' : ''?>" data-section="<?php echo $question_id?>">
                			<a href="javascript:;"><?php echo $question['title']?></a>
                		</li>
                	<?php $i++; } ?>
                </ul>

                <?php $j = 1; foreach($arrQuestion as $question_id => $question) { 
                	$options = json_decode($question['question_answer'][0]['options'],true);
					$vocabulary = $question['question_answer'][0]['dict'];
					$nextSection = next($arrQuestion);
				?>
                <div <?php echo $j > 1 ? 'style="display: none"' : ''?> class="task_writing" id="writing_section_<?php echo $question_id?>">
	                <div class="your-task">
	                    <div class="your-task__textarea">
	                        <div class="your-task__content">
								<div class="writing-result">
							  		<p><?php echo $userAnswer[$question_id]?></p>
								</div>
	                        </div>
	                    </div>
	                </div>

	                <div class="status-task">
	                    <div class="total-words__text">
	                        Total words:
	                    </div>
	                    <div class="total-words__number">
	                        <?php echo str_word_count(strip_tags($userAnswer[$question_id])) ?>
	                    </div>
	                    <div class="vocab-grammar-errors__text">
	                        Vocab & Grammar errors:
	                    </div>
	                    <div class="vocab-grammar-errors__number">
	                        <?php echo count($gramaly[$question_id]); ?>
	                    </div>
	                </div>
	                <hr>
	                <div class="button-action">
	                    <a class="btn btn-secondary -button-secondary" href="<?php echo $replay_url; ?>">
	                        Làm lại đề thi này
	                    </a>
	                    <a class="btn btn-primary -button-primary" href="/test/send_request/<?php echo $test_log_id; ?>/<?php echo $this->security->generate_token_post($test_log_id); ?>">
	                        Gửi yêu cầu chấm bài
	                    </a>
	                    <?php if ($nextSection) { ?>
		            	<a href="javascript:;" class="button-next-task change_section" data-section="<?php echo $nextSection['question_id']?>">
	                        <?php echo $nextSection['title']?> &nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>
	                    </a>
			        	<?php } ?>
	                </div>
	                <!--    End result-writing-->

	                <!-- Bắt đầu đề bài task -->
		            <div class="task-name">
		                <div class="panel-group panel-task" id="accordion">
		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                            <div class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#panel-task-3" aria-expanded="true">
		                                <div class="panel-task__title"><?php echo $question['title']?></div>
		                            </div>
		                        </div>
		                        <div id="panel-task-3" class="panel-collapse collapse in">
		                            <div class="panel-body panel-task__body">
		                            	<?php echo $question['question_answer'][0]['content']; ?>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <!-- Kết thúc đề bài task -->

		            <!-- Bắt đầu ideal vocabulary -->
		            <div class="ideal-vocabulary">
		                <div class="ideal">
		                    <div class="ideal-vocabulary__title">
		                        Ideal
		                    </div>
		                    <div class="ideal-vocabulary__content">
		                        <?php echo $options['idea']; ?>
		                    </div>
		                </div>
		                <div class="vocabulary">
		                    <div class="ideal-vocabulary__title">
		                        Vocabulary Task
		                    </div>
		                    <div class="ideal-vocabulary__content">
	                            <?php if($vocabulary) { ?>
	                            <table class="table table-borderless">                                    
                                    <tbody>
                                    	<?php $i = 1;  foreach ($vocabulary as $item) { ?>
                                    		<tr>
	                                            <td class="icon-voice -available play" data-content="<?php echo $item['word_en']?>">
	                                            	<i class="fa fa-volume-up" aria-hidden="true"></i>
	                                            </td>
	                                            <td class="vocabulary-text">
	                                                <span class="vocabulary-text__primary">
	                                                    <?php echo $i.'. '.$item['word_en']?>
	                                                </span>
	                                                <br>
	                                                <?php echo $item['trans']?>
	                                            </td>                                               
	                                            <td><?php echo $item['word_vn']?></td>                                     
	                                        </tr>
									  	<?php $i++; } ?> 
                                    </tbody>
                                </table>
                            	<?php } ?>
                            </div>
		                </div>
		            </div>
		            <!-- Kết thúc ideal vocabulary -->

		            <div class="sample-band">
		                <div class="sample-band__title">
		                    Sample <?php echo $question['title']; ?>
		                </div>

		                <div class="sample-band__content">
		                    <?php echo $options['sample']; ?>
		                </div>
		            </div>

		            <?php if ($nextSection) { ?>
		            <div class="reading-passage">
		                <a href="javascript:;" class="reading-passage__content change_section" data-section="<?php echo $nextSection['question_id']?>">
		                    <?php echo $nextSection['title']?> &nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>
		                </a>
		            </div>
		        	<?php } ?>
		        </div>
		    	<?php $j++; } ?>
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
                <?php foreach ($arrTestRelate as $testDetail) {
                    $full_link = str_replace('/test','/test/writing',$testDetail['share_url']);
                    ?>
              	<div class="col-md-3 col-sm-3 col-xs-3 col-tn-12 mb10">
	                <div class="ava">
	                  <a href="<?php echo $full_link; ?>" title="<?php echo $testDetail['title']; ?>">
	                    <span class="thumb_img thumb_5x3"><img title="" src="<?php echo getimglink($testDetail['images'], 'size6'); ?>" alt=""></span>
	                  </a>
	                </div>
	                <div class="content">
	                  <h3><a href="#" title=""><?php echo $testDetail['title']; ?></a></h3>
	                  <p>Writing</p>
	                </div>
              	</div>
              	<?php }?>
          	</div>
        </div>
      </div>
    <?php echo $this->load->get_block('left_content'); ?>
</section>


<script type="text/javascript">
	$(document).ready(function(){
	  	$('[data-toggle="popover"]').popover({ trigger: "hover" });

	  	$(".change_section").bind("click",function(){
			var section = $(this).data('section');
			$(".change_section").removeClass('active');
			$('li[data-section="'+section+'"]').addClass('active');
			//Show | Hide
			$('.task_writing').hide();
			$('#writing_section_'+section).show();
		});

	});

	onload = function() {
	    if ('speechSynthesis' in window) with(speechSynthesis) {
	        var playEle = document.querySelector('.play');
	        playEle.addEventListener('click', onClickPlay);
	        function onClickPlay() {
	            flag = true;
	            utterance = new SpeechSynthesisUtterance($(this).data('content'));
	            utterance.voice = getVoices()[0];
	            speak(utterance);
	        }
	    }else { /* speech synthesis not supported */
	        msg = document.createElement('h5');
	        msg.textContent = "Detected no support for Speech Synthesis";
	        msg.style.textAlign = 'center';
	        msg.style.backgroundColor = 'red';
	        msg.style.color = 'white';
	        msg.style.marginTop = msg.style.marginBottom = 0;
	        document.body.insertBefore(msg, document.querySelector('div'));
	    }
	}
</script>