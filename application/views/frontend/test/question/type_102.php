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
		<?php 
		$jk = 0;
		foreach ($arrQuestionAnswer as $key => $textAnswer) { 
			if ($answerResult) {
				$result = $answerResult[$questionAnswer['answer_id']];
			}
			?>
			<tr>
				<td width="20px;"><div class="number_question"><?php echo $number; ?></div></td>
				<td width="120px;">
					<?php 
					if(!$result) { ?>
					<input id="q-<?php echo $number; ?>" onkeyup="question_update_answer(<?php echo $number; ?>,this.value)" type="text" name="answer[<?php echo $questionAnswer['answer_id']; ?>][<?php echo $jk; ?>]" class="question_check form-control">
					<?php } else { ?>
						<?php 
						if ($result[$key]['answer'] == $userAnswer[$key]) { ?>
						<span class="checked"><i class="fa fa-check"></i><?php echo $result[$key]['answer']; ?></span>
						<?php } else { ?>
							<span class="false"><i class="fa fa-times"></i><strike><?php echo $userAnswer[$key]; ?></strike> <b><?php echo $result[$key]['answer']; ?></b></span>
						<?php } ?>
					<?php } ?>
				</td>
				<td><?php echo ($textAnswer != '#') ? $textAnswer : ''; ?></td>
			</tr>
		
		<?php $number ++; $jk++;} ?>
		</table>
	<?php }?>
<?php } ?>