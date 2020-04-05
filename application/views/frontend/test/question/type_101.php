<?php  /////////////// TRUE / FALSE / NOT GIVEN //
foreach ($rows as $key => $questionAnswer) {
	$arrquestionAnswer = json_decode($questionAnswer['params'],TRUE);
	$arrOptions = json_decode($questionAnswer['options'],TRUE);
	$userAnswer = $userAnswer[$questionAnswer['answer_id']];
	if ($questionAnswer['content']) {
	?>
	<div class="question_content">
		<?php echo $questionAnswer['content']; ?>	
	</div>
	<?php } ?>
	<table class="table">
	<?php 
	$jk = 0;
	foreach ($arrquestionAnswer as $key => $textAnswer) { 
		if ($answerResult) {
			$result = $answerResult[$questionAnswer['answer_id']];
		}
		?>
		<tr>
			<td width="20px;"><div class="number_question"><?php echo $number; ?></div></td>
			<td width="120px;">
				<?php 
				if(!$result) { ?>
				<select id="q-<?php echo $number; ?>" onchange="question_update_answer(<?php echo $number; ?>,this.value)" name="answer[<?php echo $questionAnswer['answer_id']; ?>][<?php echo $jk; ?>]" class="question_check form-control">
					<option value=""></option>
					<?php foreach ($arrOptions as $key => $option) { ?>
						<option value="<?php echo $option; ?>"><?php echo $option; ?></option>
					<?php } ?>
				</select>
				<?php } else { ?>
					<?php 
					if ($result[$key]['answer'] == $userAnswer[$key]) { ?>
					<span class="checked"><i class="fa fa-check"></i><?php echo $result[$key]['answer']; ?></span>
					<?php } else { ?>
						<span class="false"><i class="fa fa-times"></i><strike><?php echo $userAnswer[$key]; ?></strike> <b><?php echo $result[$key]['answer']; ?></b></span>
					<?php } ?>

				<?php } ?>
			</td>
			<td><?php echo $textAnswer; ?></td>
		</tr>
	
	<?php $number ++; $jk++;} ?>
	</table>
<?php }?>