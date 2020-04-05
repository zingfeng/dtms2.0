<?php if ($isDetail) { ?>
<div class="form-group ckeditor_detail">
    <label class="control-label col-sm-2 col-xs-12">Chi tiết</label>
    <div class="col-sm-10 col-xs-12">
        <textarea name="detail" class="form-control" placeholder="Chi tiết" rows="3"><?php echo $row['detail']; ?></textarea>
    </div>
</div>
<?php } ?>
<?php for($i = 0; $i <=$max_question-1; $i++){?>
<div class="form-group">
    <label class="control-label col-sm-2 col-xs-12">Câu trả lời <?php echo ($i + 1);?></label>
    <div class="col-sm-10 col-xs-12">
        <div class="col-sm-4 col-xs-9">
            <input value="<?php echo $answer[$i]['content'];?>" type="text" name="answer[<?php echo $i;?>][label]" placeholder="Câu trả lời <?php echo ($i + 1);?>" class="form-control">
        </div>
        <div class="col-sm-1 col-xs-3">
            <div class="checkbox">
                <label><input <?php echo ($answer[$i]['correct'] == 1 )? 'checked':'';?> type="checkbox" value="1" name="answer[<?php echo $i;?>][correct]"></label>      
                <?php if($answer[$i]) {?>
                <input type="hidden" name="answer[<?php echo $i;?>]['id']" value="<?php echo $answer[$i]['answer_id']; ?>"> 
                <?php } ?>                 
            </div>
        </div>
    </div>
</div>
<?php }?>



<script>
    $(document).ready(function () {

        CKEDITOR.addTemplates("default", {
            imagesPath: CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates") + "templates/images/"),
            templates: [
                {
                    title: "Question Explain",
                    image: "template1.gif",
                    description: "Giải thích câu hỏi",
                    html: '<p style="display: inline;">'
                        + '<span class="tilte_explain_question" style="display: inline; font-weight:bold; padding-right: 5px; padding-left: 5px; background-color: #ff8e3d; color:#463a41">1</span>'
                        + '<span class="content_explain_question" style="display: inline; padding-right: 5px; padding-left: 5px; background: #eeff00; ">Nội dung câu hỏi</span>'
                        + '</p>',


                },
            ]
        });
    });

</script>
