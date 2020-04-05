<?php  /////////////// TRUE / FALSE / NOT GIVEN //
//var_dump($rows); die;
foreach ($rows as $key => $questionAnswer) {
	$arrquestionAnswer = json_decode($questionAnswer['params'],TRUE);
	$userAnswer = $userAnswer[$questionAnswer['answer_id']];
	?>
	<table class="table">
	<?php 
	$jk = 0;
	foreach ($arrquestionAnswer as $key => $textAnswer) { 
		//var_dump($answerResult[$questionAnswer['answer_id']]); die;
		if ($answerResult) {
			$result = $answerResult[$questionAnswer['answer_id']];
		}
		?>
		<tr>
			<td><div class="number_question"><?php echo $number; ?></div></td>
			
			<td width="120px;">
				<?php 
				if(!$result) { ?>
				<select id="q-<?php echo $number; ?>" onchange="question_update_answer(<?php echo $number; ?>,this.value)" name="answer[<?php echo $questionAnswer['answer_id']; ?>][<?php echo $jk; ?>]" class="question_check form-control">
					<option value="">CHOOSE</option>
					<option value="true">TRUE</option>
					<option value="false">FALSE</option>
					<option value="notgiven">NOT GIVEN</option>
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
			
			<td>
				<?php echo $textAnswer; ?>
			</td>
		</tr>
	
	<?php $number ++; $jk++;} ?>
	</table>
<?php }?>