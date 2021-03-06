<html>
<head>
    <title>Phiếu khảo sát IELTS Fighter</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://ielts-fighter.com/web/skins/images/favicon_IELTS.png">


    <base href="/">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://qlcl.imap.edu.vn/theme/frontend/default/css/fontAwesome/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="https://qlcl.imap.edu.vn/theme/frontend/default/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" href="theme/frontend/default/css/feedback.css" media="all">

    <style type="text/css">

    </style>
</head>
<body style="background-color: coral" >

<div class="container" >
    <div class="row">
        <div class="col-sm-0 col-md-2 col-lg-3 col-xl-4" ></div>

        <div class="col-sm-12 col-md-8 col-lg-6 col-xl-4"  style="/*max-width: 100%; width: 750px; margin: auto; */    background-color: white; padding: 0; " >
            <div style="background-color: transparent; padding: 10px; ">
                <h2 class="title_top">KHẢO SÁT LỚP HỌC IELTS FIGHTER</h2>
                <p class="description">Với mong muốn không ngừng nâng cao chất lượng dịch vụ và đào tạo, Trung tâm IELTS FIGHTER mong bạn vui lòng dành chút thời gian hoàn thành Phiếu khảo sát chất lượng dưới đây</p>
            </div>

            <?php  if (count($info_class) > 0 ){ ?>
                <div class="info class info_class_detail" >
                    <input  id="class_info_feedback" type="text" value="<?php echo $info_class['class_code']; ?>" style="display: none">
                    <h3 style="text-align: center;" >Lớp <span class="class_name_focus"><?php echo $info_class['class_code']; ?></span></h3>
                    <h4 style="text-align: center;" ><?php echo $arr_location_info[$info_class['id_location']]; ?></h4>
                </div>
                <?php
            }else{ ?>
                <div class="form-group" style="padding: 5px 20px; font-size: large;">
                    <label for="class_info_feedback">Lựa chọn lớp học của bạn</label>
                    <select class="form-control"  name="" id="class_info_feedback">
                        <option disabled selected value="">Lớp học ...</option>
                        <?php  foreach ($list_info_class as $mono_info_class){?>
                        <option value="<?php echo $mono_info_class['class_code']; ?>"><?php echo $mono_info_class['class_code']; ?></option>
                        <?php } ?>
                    </select>
                </div><?php
                }
            ?>
<!--            <hr>-->

            <div class="form-group" style="padding: 5px 20px; font-size: large;">
                <label for="usr">Họ tên</label>
                <input type="text" class="form-control" id="name_feeder" placeholder="Không bắt buộc">
            </div>
            <div class="form-group" style="display: none">
                <label for="usr">Time start</label>
                <input type="text" class="form-control" id="time_start" value="<?php echo $time_start; ?>">
            </div>

            <div class="form-group" style="display: none">
                <label for="usr">Time start</label>
                <input type="text" class="form-control" id="type_feedback" value="<?php echo $type_class; ?>">
            </div>

            <div class="form-group" style="display: none">
                <label for="usr">Token</label>
                <input type="text" class="form-control" id="token" value="<?php echo $token; ?>">
            </div>




            <?php  creat_feedback_list_question_ruler($list_quest_ruler,100); ?>

            <h3 class="title_group_quest">Đánh giá theo thang điểm</h3>

            <?php
            creat_feedback_list_question_select_fast($list_quest_select,200);

            ?>
            <h3 class="title_group_quest">Đóng góp ý kiến</h3> <?php

            creat_feedback_list_question_text($list_quest_text,300);

            creat_feedback_list_question_radio($list_quest_radio,400);
            ?>



            <div style="padding: 10px; text-align: center">
                <button class="btn btn-lg btn-success mx-auto btn_send_feedback" onclick="Send_feedback()">Gửi</button>
            </div>
        </div>


        <div class="col-sm-0 col-md-2 col-lg-3 col-xl-4" ></div>
    </div>

</div>


<div class="container">
    <h5>. </h5>
</div>

<script>
    function Send_feedback() {
        // Select value ruler quest
        var list_feedback = [];

        $(".div_quest").each(function () {
            var type = $(this).attr("type");
            var id_quest = $(this).attr("id_quest");
            switch (type) {
                case 'ruler':
                    var name_radio = 'radio_feedback_' + id_quest;
                    var quest = $(this).attr("content_quest");
                    var value = $("input[name='" + name_radio + "']:checked").val();
                    list_feedback.push([
                        id_quest,
                        type,
                        quest,
                        value,
                    ]);
                    break;
                case 'select':
                    var quest = $(this).attr("content_quest");
                    var value = $('#feedback_quest_select' + id_quest).val();
                    list_feedback.push([
                        id_quest,
                        type,
                        quest,
                        value,
                    ]);
                    break;
                case 'text':
                    // content_quest
                    var quest = $(this).attr("content_quest");
                    var value = $('#feedback_quest_text' + id_quest).val();
                    list_feedback.push([
                        id_quest,
                        type,
                        quest,
                        value,
                    ]);
                    break;
                case 'radio':
                    var name_radio = 'feedback_quest' + id_quest;
                    var quest = $(this).attr("content_quest");
                    var value = $("input[name='" + name_radio + "']:checked").val();
                    var text =  $("input[name='" + name_radio + "']:checked").parent('label').text();
                    list_feedback.push([
                        id_quest,
                        type,
                        quest,
                        value,
                        text,
                    ]);

                    break;

            }

        });

        console.log(list_feedback);

        var class_code = $('#class_info_feedback ').val();
        var type = $('#type_feedback').val();
        var name_feeder = $('#name_feeder').val();
        var time_start = $('#time_start').val();
        var token = $('#token').val();

        var detail = JSON.stringify(list_feedback);

        $.post("/feedback/send_feedback",
        {
            name_feeder: name_feeder,
            token: token,
            type: type,
            time_start: time_start,
            class_code: class_code,
            detail: detail,
        },
        function (data, status) {
            console.log(data);
            alert('Thank you!');
            location.reload();
        });

    }

    function ClickChild(e) {
        var obj = e.target;
        var child = obj.firstChild;
        child.click();
    }
    function ClickElement(id) {
        document.getElementById(id).click();
    }
</script>
</body>
</html>

