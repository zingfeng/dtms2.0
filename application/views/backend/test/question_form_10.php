<?php if ($isDetail) { ?>
<div class="form-group ckeditor_detail">
    <label class="control-label col-sm-2 col-xs-12">Chi tiết</label>
    <div class="col-sm-10 col-xs-12">
        <textarea name="detail" class="form-control" placeholder="Chi tiết" rows="3"><?php echo $row['detail']; ?></textarea>
    </div>
</div>
<?php } ?>

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
