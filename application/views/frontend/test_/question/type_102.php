<?php  /////////////// Điền từ //
if($rows) {
	foreach ($rows as $key => $questionAnswer) {
		$arrQuestionAnswer = json_decode($questionAnswer['params'],TRUE);
		$userAnswer = $userAnswer[$questionAnswer['answer_id']];
		//var_dump($userAnswer); die;
		if ($questionAnswer['content']) {
		?>
		<div class="question_content">
			<?php echo $questionAnswer['content']; ?>	
		</div>
		<?php } ?>
		<table class="table">
			<?php $jk = 0;
			foreach ($arrQuestionAnswer as $key => $textAnswer) { 
				if ($answerResult) {
					$result = $answerResult[$questionAnswer['answer_id']];
				}
				?>
				<tr>
					<td width="50px;">
		                <div class="form-answer__number-answer number_question">
		                    <?php echo $number; ?>
		                </div>
		            </td>
		            <td class="input-answer -custom-padding-left">
	                    <?php  if(!$result) { ?>
							<input id="q-<?php echo $number; ?>" onkeyup="question_update_answer(<?php echo $number; ?>,this.value)" type="text" name="answer[<?php echo $questionAnswer['answer_id']; ?>][<?php echo $jk; ?>]" class="question_check form-control" placeholder="Enter your answer">
						<?php } else { ?>
							<div id="q-<?php echo $number; ?>">
								<?php 
								if ($result[$key]['answer'] == $userAnswer[$key]) { ?>
									<span class="form-answer-review-mode__text -true">
										<?php echo $result[$key]['answer']; ?> <i class="fa fa-check"></i>
									</span>
								<?php } else { ?>
									<span class="form-answer-review-mode__text -false">
										<strike><?php echo $userAnswer[$key]; ?></strike> <i class="fa fa-times"></i>
										<span class="form-answer-review-mode__text-answer"> - <?php echo $result[$key]['answer']; ?></span> 
									</span>
								<?php } ?>
							</div>
						<?php } ?>
		            </td>
		        </tr>
			<?php $number ++; $jk++;} ?>
		</table>
	<?php }?>
<?php } ?>