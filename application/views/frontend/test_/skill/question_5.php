<p class="lead">Choose the word that best completes the sentence:</p>
<div class="myquestionarea" id="testing_answer_<?php echo $question['question_id']?>_<?php echo $page; ?>">
    <p><b>Question <?php echo $page; ?>:</b></p>
    <div class="alert alert-warning"><?php echo $question['detail']; ?></div>
    <div>
        <?php foreach ($question['answer'][0] as $j => $a) { ?>
            <label class="fulltest_answer_label" id="test_answer_label_<?php echo $a['answer_id']?>">
                <input type="radio" data-iquestion="<?php echo $page ?>" data-question="<?php echo $question['question_id']?>" name="answer[<?php echo $question['question_id']?>][0]" value="<?php echo $a['answer_id']?>">
                <strong><?php echo translate_answer($j+1); ?></strong> <span><?php echo $a['content']; ?></span>
            </label>
        <?php } ?>
    </div>
</div>