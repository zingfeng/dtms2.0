<?php  /////////////// TRUE / FALSE / NOT GIVEN //
foreach ($rows as $key => $questionAnswer) {
	$arrquestionAnswer = json_decode($questionAnswer['params'],TRUE);
	$arrOptions = json_decode($questionAnswer['options'],TRUE);
	$userAnswer = $userAnswer[$questionAnswer['answer_id']];
	$arrAlpha = range('A', 'D');
	if ($questionAnswer['content']) {
	?>
	<div class="question_content">
		<?php echo $questionAnswer['content']; ?>	
	</div>
	<?php } ?>
	
	<?php 
	$jk = 0;
	if ($answerResult) {
		$result = $answerResult[$questionAnswer['answer_id']];
		$userAnswerResult = $userAnswer[$key];
	}
	foreach ($arrquestionAnswer as $key => $textAnswer) { 
		
		?>
		<div class="mb20"><div class="number_question" id="q-<?php echo $number; ?>"><?php echo $number; ?></div><?php echo $textAnswer; ?></div>
		<div border="0" class="question" id="answer_question_<?php echo $questionAnswer['answer_id']; ?>">
		<?php foreach ($arrOptions as $key => $option) { ?>
		
			<?php 
			if(!$result) { ?>
			<div class="clearfix">
			<label data-answer="<?php echo $questionAnswer['answer_id']; ?>" class="input_check_box">
				<strong><?php echo $arrAlpha[$key]; ?></strong>
				<input onchange="question_update_answer(<?php echo $number; ?>,this.value)" value="<?php echo strtolower($arrAlpha[$key]); ?>" style="display: none;" type="radio" class="question_check form-control" name="answer[<?php echo $questionAnswer['answer_id']; ?>][<?php echo $jk; ?>]">
				<?php echo $option; ?>
			</label>
			</div>
			<?php } else { ?>
				<?php 
				//
				if ($userAnswerResult != $result[0]['answer'] && $userAnswerResult == strtolower($arrAlpha[$key])) {?>
					<label class="error active"><i class="fa fa-times"></i><strong><?php echo $arrAlpha[$key]; ?></strong><?php echo $option; ?></label>
				<?php }
				elseif ($result[0]['answer'] == $arrAlpha[$key]) { ?>
					<label class="success active">
						<?php if($userAnswerResult == strtolower($arrAlpha[$key])) echo '<i class="fa fa-check"></i>'; ?>
						<strong><?php echo $arrAlpha[$key]; ?></strong><?php echo $option; ?>
					</label>
				<?php } else {?>
				<label><strong><?php echo $arrAlpha[$key]; ?></strong><?php echo $option; ?></label>
				<?php } ?>
			<?php } ?>
		
		<?php } ?>
		</div>
	<?php $number ++; $jk++;} ?>
	
<?php }?>
<script type="text/javascript">
	$(document).ready(function(){
		$(".input_check_box").bind("click",function(){
			var answer_id = $(this).attr("data-answer");
			$("#answer_question_" + answer_id).find(".input_check_box").removeClass("circle_number_active");
			$(this).addClass("circle_number_active");
		});
	})
</script>