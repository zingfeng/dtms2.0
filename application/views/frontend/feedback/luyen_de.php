<html>
<head>
    <title>PHIẾU ĐĂNG KÝ LỚP LUYỆN ĐỀ TẠI IMAP</title>
    <link rel="shortcut icon" type="image/x-icon"
          href="https://www.anhngumshoa.com/theme/frontend/default/images/favicon.ico">
    <base href="/">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
          href="https://dtms.aland.edu.vn/theme/frontend/default/css/fontAwesome/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="https://dtms.aland.edu.vn/theme/frontend/default/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" href="theme/frontend/default/css/feedback.css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: 'Muli', sans-serif;
        }

        .select_quest_feedback_select {
            font-size: medium !important;
        }
    </style>
</head>
<body style="background-color: rgb(70,126,159);">

<div class="container">
    <div class="row">
        <div class="col-sm-0 col-md-2 col-lg-2 col-xl-3"></div>

        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-6"
             style="/*max-width: 100%; width: 750px; margin: auto; */    background-color: white; padding: 0; ">
            <div style="background-color: transparent; padding: 10px; ">
                <div class="row">
                    <div class="col col-sm-12 col-md-4">
                        <img style="    max-width: 100%;    padding-top: 20px;"
                             src="theme/frontend/default/images/images/logo/logoImap.png" alt="logo IMAP">
                    </div>
                    <div class="col col-sm-12 col-md-8">
                        <h2 class="title_top">PHIẾU ĐĂNG KÝ LỚP LUYỆN ĐỀ TẠI IMAP
                        </h2>
                    </div>

                </div>

                <p class="description">
                    Bạn vui lòng chọn lớp học luyện đề phù hợp với bạn.
                </p>
            </div>

            <?php if (count($info_class) > 0) { ?>
                <div class="info class info_class_detail">
                    <input id="class_info_feedback" type="text" value="<?php echo $info_class['class_code']; ?>"
                           style="display: none">
                    <h3 style="text-align: center;">Lớp <span
                                class="class_name_focus"><?php echo $info_class['class_code']; ?></span></h3>
                    <?php
                    if (isset($info_class['name_teacher']) && (trim($info_class['name_teacher']) !== '')) {
                        echo '<h4 style="text-align: center;" >Giảng viên: ' . $info_class['name_teacher'] . '</h4>';
                    }
                    ?>
                    <h4 style="text-align: center;"><?php echo $arr_location_info[$info_class['id_location']]; ?></h4>
                </div>
                <?php
            } else { ?>
                <div class="form-group" style="padding: 5px 20px; font-size: large;">
                <label for="class_info_feedback">Lựa chọn lớp học của bạn</label>
                <select class="form-control" name="" id="class_info_feedback">
                    <option disabled selected value="">Lớp học ...</option>
                    <?php foreach ($list_info_class as $mono_info_class) { ?>
                        <option value="<?php echo $mono_info_class['class_code']; ?>"><?php echo $mono_info_class['class_code']; ?></option>
                    <?php } ?>
                </select>
                </div><?php
            }
            ?>
            <!--            <hr>-->
            <h3 class="title_group_quest"> Thông tin cá nhân</h3>

            <div class="row">
                <br>
                <div class="col col-sm-12 col-md-8">
                    <div class="form-group" style="padding: 5px 20px; font-size: large;">
                        <label for="usr">Họ tên học viên (*)</label>
                        <input type="text" class="form-control" id="name_feeder" placeholder="">
                    </div>
                </div>
                <div class="col col-sm-12 col-md-8">
                    <div class="form-group" style="padding: 5px 20px; font-size: large;">
                        <label for="usr">Số điện thoại (*)</label>
                        <input type="text" class="form-control" id="name_feeder" placeholder="">
                    </div>
                </div>
                <div class="col col-sm-12 col-md-8">
                    <div class="form-group" style="padding: 5px 20px; font-size: large;">
                        <label for="usr">Email</label>
                        <input type="text" class="form-control" id="name_feeder" placeholder="">
                    </div>
                </div>

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

            <h3 class="title_group_quest"> Thông tin lớp học</h3>
            <br>
            <div class="row" style="padding: 5px 20px; font-size: large;">
                <div class="col col-sm-6">
                    <p class="quest_title" id="quest_title_200" style="font-size:medium ">Lựa chọn trình độ</p>
                </div>
                <div class="col col-sm-6">
                    <div class="form-group" style="">
                        <select class="form-control select_quest_feedback_select" name="" id="feedback_quest_select200">
                            <option selected="" disabled="" value="">Chọn</option>
                            <option value="co_ban">Cơ bản</option>
                            <option value="nang_cao">Nâng cao</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 5px 20px; font-size: large;">
                <div class="col col-sm-6">
                    <p class="quest_title" id="quest_title_200" style="font-size:medium ">Lựa chọn ca học</p>
                </div>
                <div class="col col-sm-6">
                    <div class="form-group" style="">
                        <select class="form-control select_quest_feedback_select" name="" id="feedback_quest_select200">
                            <option selected="" disabled="" value="">Chọn</option>
                            <option value="s_t7">Sáng thứ 7</option>
                            <option value="c_t7">Chiều thứ 7</option>
                            <option value="s_cn">Sáng chủ nhật</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <p style="
    padding: 15px;
    font-style: italic;
">Hẹn gặp bạn tại lớp học !</p>
                </div>

            </div>
            <div style="padding: 10px; text-align: center">
                <button class="btn btn-lg btn-success mx-auto btn_send_feedback" onclick="Send_feedback()">Gửi</button>
            </div>
        </div>

        <div class="col-sm-0 col-md-2 col-lg-2 col-xl-3"></div>
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
                    var text = $("input[name='" + name_radio + "']:checked").parent('label').text();
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
        var age = $('#age ').val();
        var type = $('#type_feedback').val();
        var name_feeder = $('#name_feeder').val();
        var time_start = $('#time_start').val();
        var token = $('#token').val();

        var detail = JSON.stringify(list_feedback);

        $.post("/feedback/send_feedback",
            {
                name_feeder: name_feeder,
                age: age,
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

