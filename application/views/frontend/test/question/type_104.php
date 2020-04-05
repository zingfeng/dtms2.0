<?php  /////////////// Điền từ //
if($rows) { 
	foreach ($rows as $key => $questionAnswer) {
		$arrquestionAnswer = json_decode($questionAnswer['params'],TRUE);
		
		if ($questionAnswer['content']) {
		?>
		<div class="question_content">
			<?php echo $questionAnswer['content']; ?>	
		</div>
		<?php } ?>
		<div class="question_check_item_<?php echo $questionAnswer['answer_id']; ?>">
		<?php 
		$jk = 0;
		$arrAlpha = range('A', 'Z');
		if ($answerResult) {
			$result = $answerResult[$questionAnswer['answer_id']];
			$userAnswer = $userAnswer[$questionAnswer['answer_id']];
			//var_dump($result,$userAnswer);
			foreach ($result as $resultData) {
				$arrResult[] = $resultData['answer'];
			}
		}
		foreach ($arrquestionAnswer as $key => $textAnswer) { 

			?>
				<div class="clearfix user_answer_result">
					<?php 
					if(!$result) { ?>
					<label>
						<input type="checkbox" value="<?php echo $arrAlpha[$key]; ?>" type="text" name="answer[<?php echo $questionAnswer['answer_id']; ?>][<?php echo $jk; ?>]" class="question_check">
						<span style="font-weight: normal; margin-left: 15px;">
							<?php echo $textAnswer; ?>
						</span>
					</label>
					<?php } else { 
						$classDom = ''; $margin_text = '20';
						if (in_array($arrAlpha[$key], $arrResult) ) {
							$classDom = 'success';
						}
						elseif ($userAnswer && in_array($arrAlpha[$key], $userAnswer)){
							$classDom = 'unsuccess';
							$margin_text = 0;
						}
						if ($result['answer'])
						?>
						<label class="<?php echo $classDom; ?>">
							<input type="checkbox" disabled class="question_check">
							<?php if ($userAnswer && in_array($arrAlpha[$key], $userAnswer)) { 
								$margin_text = 0;
								echo ($classDom == 'success') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';  } ?>
							<span style="font-weight: normal; margin-left: <?php echo $margin_text; ?>px;">
								<?php echo $textAnswer; ?>
							</span>
						</label>
					<?php } ?>
				</div>
			</tr>
		
		<?php $jk++;} $number += $questionAnswer['number_question'];?>
		</div>
		<script type="text/javascript">
			$(".question_check_item_<?php echo $questionAnswer['answer_id']; ?>").find("input").bind("click",function(){
				var max_number = <?php echo $questionAnswer['number_question']; ?>;
				var to_number = <?php echo $number - 1; ?>;
				var checked_length = $(".question_check_item_<?php echo $questionAnswer['answer_id']; ?>").find("input:checked").length;
				console.log(max_number,to_number,checked_length);
				if (max_number < checked_length) {
					alert("Nhập quá số lượng câu trả lời");
					return false;
				}
				else {
					if (max_number == checked_length) {
						for (var i = 0; i < max_number; i++) {
							question_update_answer(to_number - i,1)
						}
					}
					else {
						for (var i = 0; i < max_number; i++) {
							question_update_answer(to_number - i,null)
						}
					}
				}

			});
		</script>
	<?php }?>
<?php }?>
