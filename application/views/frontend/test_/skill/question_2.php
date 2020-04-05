<p class="lead">Listen to the question and the three responses. Choose the response that best answers the question:</p>
<div class="myquestionarea" id="testing_answer_<?php echo $question['question_id']?>_<?php echo $page ?>">
    <?php if ($question['sound']) { ?>
    <div class="test_audio"><audio src="<?php echo getFileLink($question['sound'],'sound'); ?>" controls=""></audio></div>
    <?php } ?>
	<?php 
    $i = 0;
    foreach ($question['answer'][0] as $j => $a) { ?>
        <?php if ($a['parent'] == 1) { ?>
        <div class="question_number"><b>Question <?php echo $page; ?>: </b><span id="tapescript_answer_<?php echo $a['answer_id']; ?>" class="answer_content"></span></div>
        <?php continue;} ?>
        <label class="fulltest_answer_label" id="test_answer_label_<?php echo $a['answer_id']?>">
            <input type="radio" data-iquestion="<?php echo $page ?>"  data-question="<?php echo $question['question_id']?>" name="answer[<?php echo $question['question_id']?>][0]" value="<?php echo $a['answer_id']?>">
            <strong><?php echo translate_answer($i + 1); ?></strong> <span id="tapescript_answer_<?php echo $a['answer_id']; ?>" class="answer_content"></span>
        </label>
    <?php $i++; } ?>
</div>