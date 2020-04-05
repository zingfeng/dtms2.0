<p class="lead">Look at the picture and listen to the sentences. Choose the sentence that best describes the picture:</p>

<?php if ($question['images']) { ?>
	<figure><img src="<?php echo getimglink($question['images'],'size6') ?>" alt="<?php echo $question['title']; ?>"></figure>
<?php } ?>
<?php if ($question['sound']) { ?>
	<div style="text-align:center"><audio src="<?php echo getFileLink($question['sound'],'sound'); ?>" controls=""></audio></div>
<?php } ?>

<div class="myquestionarea" id="testing_answer_<?php echo $question['question_id']?>_<?php echo $page ?>">
    <p><b>Question <?php echo $page; ?>:</b></p>
    <div>
        <?php foreach ($question['answer'][0] as $j => $a) { ?>
            <label class="fulltest_answer_label" id="test_answer_label_<?php echo $a['answer_id']?>">
                <input type="radio" data-iquestion="<?php echo $page ?>" data-question="<?php echo $question['question_id']?>" name="answer[<?php echo $question['question_id']?>][0]" value="<?php echo $a['answer_id']?>">
                <strong><?php echo translate_answer($j+1); ?></strong> <span id="tapescript_answer_<?php echo $a['answer_id']; ?>" class="answer_content"></span>
            </label>
        <?php } ?>
	</div>
</div>