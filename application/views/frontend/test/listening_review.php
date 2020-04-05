<section class="listening-test_head clearfix">
	<div class="container">
		<a class="img_logo" href="">
			<img class="logo_web" src="<?php echo $this->config->item("img"); ?>graphics/logo.png" alt="Trang chủ" data-was-processed="true">
		</a>
		<div class="select_sever">
			<span>Chọn Section để làm bài</span>
			<?php 
			$i = 1;
			foreach ($arrQuestion as $key => $question) { ?>
				<a data-section="<?php echo $question['question_id']; ?>" data-index="<?php echo $i-1; ?>" id="question_setion_selection_<?php echo $question['question_id']; ?>" class="reading_change_section <?php if ($i == 1) echo 'active'; ?>" href="javascript:void(0)"><?php echo $question['title']; ?></a>
				<?php $i ++; 
				$test_time += $question['test_time'] * 60 * 1000;
				//var_dump($test_time); die;
			} 
			?>
			</div> 
			<div class="option_listening">
				<a href="javascript:void(0)" class="show_info_test">Show info test<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
			</div>        
		</div>
	</section>

	<section class="listening-test_running clearfix">
		<div class="container">
			<div class="row">
				<div class="col-xs-6">
					<?php echo $this->load->view('common/player'); ?>
					<?php 
					/* $i = 1;
					foreach ($arrQuestion as $key => $question) { ?>
					<audio controls autoplay>
						<source src="<?php echo UPLOAD_URL . 'sound/'.$question['sound']; ?>" type="audio/ogg">
					</audio>
					<?php }*/ ?>
				</div>
				<div class="col-xs-6 right">
					<h3 style="display:none">Chữa bài</h3>
					<!--<div class="timer"><i class="fa fa-clock-o"></i>20:00</div>-->
					<!--<a class="back" href="javascript:voi(0)" id="submit_answer_result">Nộp bài</a>-->
				</div>
			</div> 
		</div>
	</section>

	<section class="listening-test_container clearfix">
		<?php 
			echo $this->load->view('test/common/skill_menu_mobile',array('test' => $test,'type' => 'listening')); ?>    
		<div class="container max_width warp_slidebar">
			<?php //echo $this->load->view('test/common/skill_menu',array('test' => $test,'type' => 'listening')); ?>
			<div class="row">
				<div class="col_left col-md-9 col-sm-9 col-xs-12">
					<form class="form" method="POST" action="/test/result" id="test_form">
						<input type="hidden" name="test_id" value="<?php echo $test['test_id']; ?>">
						<input type="hidden" name="type" value="<?php echo $keyType; ?>">
						<input type="hidden" name="start_time" value="<?php echo $start_time; ?>">
						<input type="hidden" name="token" value="<?php echo $token; ?>">
						<?php 
						$number_question = 1;
						foreach ($arrQuestion as $qkey => $question) { ?>
							<div class="question_section_content" id="question_section_<?php echo $question['question_id']; ?>" <?php if ($number_question != 1) echo 'style="display: none"'; ?>>
								<div class="warp_content">
									<div class="scrollbar-inner" id="question_section_<?php echo $question['question_id']; ?>_div_scroll" >
										<?php if(isset($question['tapescript']) &&($question['tapescript'] !='')) { ?>
											<h3 class="tapescript" data-toggle="collapse" data-target="#tapescript" aria-expanded="false">Tapescript</h3>
											<div id="tapescript" class="collapse in" aria-expanded="true" style="background: #fcf8e3; padding: 15px; margin-bottom: 20px;">
												<?php echo $question['tapescript']?>
											</div>
										<?php } ?>

										<?php 
										$userAnswer = json_decode($arrLogDetail['answer_list'],TRUE); 
										foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) {?>
										<div style="margin-top: 10px;" class="question mb30">

										<a class="listening audio_start_time" href="javascript:;" data-audio-time="<?php echo $qgroup['audio_start_time']?>"><i class="fa fa-headphones">
											</i>&nbsp;&nbsp;Listening from here
										</a>

				                        <h3><?php echo $qgroup['title']; ?></h3>
				                        <div class="mb20"><?php echo $qgroup['detail']; ?></div>
				                        <?php 
				                        //var_dump($qgroup['question_answer']); die;
				                        echo $this->load->view("test/question/type_".$qgroup['type'],array('rows' => $qgroup['question_answer'],'number' => $number_question,'userAnswer' => $userAnswer,'answerResult' => $arrAnswerResult)); ?>
				                        </div>
				                        <?php $number_question += $qgroup['number_question']; } ?>

				                        <?php if ($nextSection = $arrQuestion[$qkey + 1]) { ?>                                                                                  
				                        <div class="passage-control">
				                            <a class="reading_change_section" href="javascript:void(0)" data-section="<?php echo $nextSection['question_id']; ?>"><?php echo $nextSection['title']; ?>&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
				                        </div>
				                        <?php } ?>


										
									</div>  
								</div>
							</div>
						<?php 
						$arrNumberCheck[$question['question_id']] = $number_question; 
						} ?>
					</form>
				</div>

				<div class="col_right col-md-3 col-sm-3 col-xs-12" id="list_answer">
					<div class="warp_content">
						<div class="timer"><i class="fa fa-clock-o"></i><span id="show_count_down"></span></div>
						<div class="scrollbar-inner">
							<div class="col-xs-12">

								<?php 
								$j = 1;
								$score_detail = @json_decode($arrLogDetail['score_detail'],TRUE);
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
			</div>
		</div> 
	</section> 

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
					this_countdown.html(event.strftime('%H : %M : %S'));
				}
			});

			var arrPlaylist = [];
		
		<?php foreach ($arrQuestion as $key => $question) { ?> 
			arrPlaylist.push({
	                title:"<?php echo $question['title']; ?>",
	                mp3:"<?php echo UPLOAD_URL . 'sound/'.$question['sound']; ?>",
        		});
		<?php } ?>
			
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

					$(".reading_change_section").removeClass("active");
					$("#question_setion_selection_" + section_id).addClass("active");

					var dataIndex = $(this).attr("data-index");
					myPlaylist.play(dataIndex);
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
                var id = $(this).attr('data-section'); // data section in prob
                var qid = $(this).attr('data-q');
                if($('#question_section_' + id + ':visible').length == 0){
                    $("div.question_section_content").hide();
                    $("#question_section_" + id).show();
                }
                $('#' + qid).focus();
            })

            $('body').on('click', '.audio_start_time', function (event) {
          		var audio = document.getElementById("jp_audio_0");
          		audio.play();
			 	audio.currentTime = $(this).data("audio-time"); // jumps to audio time
	        });

            // =========== Question Explain

            $(".tilte_explain_question").each(function () {
                var id_question_inner = $(this).html();
                $(this).attr('id','tilte_explain_question' + id_question_inner);
            });



            $(".number_question").each(function () {
                var id_question = $(this).html();
                $(this).attr('tabindex','-1'); // div element need this attribute to be focued
                $(this).attr('id','q-'+id_question);
                $(this).click(function () {
                    Scroll_to_Explain_listening(id_question);});
            });

            jQuery.fn.scrollTo = function(elem) {
                $(this).scrollTop($(this).scrollTop() - $(this).offset().top + $(elem).offset().top);
                return this;
            };

            function Scroll_to_Explain_listening(id_question) {
                var id_question_section_content_showing = '';
                $(".question_section_content").each(function () {
                    var show = $(this).css("display");
                    if (show !== 'none')
                    {
                        id_question_section_content_showing = $(this).attr('id');
                        console.log("id_question_section_content_showing");
                        console.log(id_question_section_content_showing);

                    }
                });


                $('#' + id_question_section_content_showing + '_div_scroll').scrollTo("#tilte_explain_question"+ id_question, 1000); //custom animation speed
            }

            $(function(){
                jQuery('.scrollbar-inner').scrollbar();
            });


		});







		
		</script>
