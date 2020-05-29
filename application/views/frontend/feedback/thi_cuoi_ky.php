<html>
<head>
    <title>PHIẾU ĐĂNG KÝ LỊCH THI CUỐI KỲ TẠI <?php
        echo $type_detail['name'];
        ?></title>
    <link rel="shortcut icon" type="image/x-icon"
          href="https://www.anhngumshoa.com/theme/frontend/default/images/favicon.ico">
    <base href="/">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
          href="https://qlcl.imap.edu.vn/theme/frontend/default/css/fontAwesome/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="https://qlcl.imap.edu.vn/theme/frontend/default/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" href="theme/frontend/default/css/feedback.css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style type="text/css">
        body {
            font-family: 'Muli', sans-serif;
        }

        .select_quest_feedback_select {
            font-size: medium !important;
        }
    </style>
</head>
<body>

<div class="container" style="width: 100% !important;padding-right: 0;">
    <div class="row">
        <div class="col-sm-0 col-md-2 col-lg-3 col-xl-4"></div>
        <div class="col-sm-12 col-md-8 col-lg-6 col-xl-4" style="/*max-width: 100%; width: 750px; margin: auto; */    background-color: white; padding: 0; ">
            <div style="background-color: transparent; padding: 10px; ">
                <div class="row">
                    <div class="col col-sm-12 col-md-4">
                        <img style=" max-width: 100%; padding-top: 20px;" src="<?php echo $type_detail['logo']; ?>" alt="logo IMAP">
                    </div>
                    <div class="col col-sm-12 col-md-8">
                        <h2 class="title_top">FORM ĐĂNG KÝ LỊCH THI CUỐI KỲ TẠI <?php echo $type_detail['name']; ?></h2>
                    </div>
                </div>
                <p class="description">Bạn vui lòng chọn lịch thi cuối kỳ phù hợp với bạn.</p>
            </div>
            <?php if (count($info_class) > 0) { ?>
                <div class="info class info_class_detail">
                    <input id="class_info_feedback" type="text" value="<?php echo $info_class['class_code']; ?>"
                           style="display: none">
                    <input id="type_class" type="text" value="<?php echo $type_class; ?>"
                           style="display: none">

                    <h3 style="text-align: center;">Lớp <span
                                class="class_name_focus" id="class_code"><?php echo $info_class['class_code']; ?></span></h3>
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
                        <input type="text" class="form-control" id="hoten" placeholder="">
                    </div>
                </div>
                <div class="col col-sm-12 col-md-8">
                    <div class="form-group" style="padding: 5px 20px; font-size: large;">
                        <label for="usr">Số điện thoại (*)</label>
                        <input type="text" class="form-control" id="phone" placeholder="">
                    </div>
                </div>
                <div class="col col-sm-12 col-md-8">
                    <div class="form-group" style="padding: 5px 20px; font-size: large;">
                        <label for="usr">Email (*)</label>
                        <input type="text" class="form-control" id="email" placeholder="">
                    </div>
                </div>

            </div>

            <input type="hidden" class="form-control" id="time_start" value="<?php echo $time_start; ?>">
            <input type="hidden" class="form-control" id="type_feedback" value="<?php echo $type_class; ?>">
            <input type="hidden" class="form-control" id="token" value="<?php echo $token; ?>">

            <h3 class="title_group_quest"> Đăng ký lịch thi</h3>
            <br>
            <div class="row" style="padding: 5px 20px; font-size: large;">
                <div class="col col-sm-6">
                    <p class="quest_title" id="quest_title_200" style="font-size:medium ">Lựa chọn lịch thi</p>
                </div>
                <div class="col col-sm-6">
                    <div class="form-group" style="">
                        <select class="form-control select_quest_feedback_select" name="shift" id="shift">
                            <option selected="" disabled="" value="">Chọn</option>
                            <option value="s_04">09:00 Thứ 5, ngày 04/06/2020</option>
                            <option value="s_06">09:00 Thứ 7, ngày 06/06/2020</option>
                            <option value="c_06">14:00 Thứ 7, ngày 06/06/2020</option>
                            <option value="c_09">14:00 Thứ 3, ngày 09/06/2020</option>
                            <option value="s_11">09:00 Thứ 5, ngày 11/06/2020</option>
                            <option value="s_13">09:00 Thứ 7, ngày 13/06/2020</option>
                            <option value="c_13">14:00 Thứ 7, ngày 13/06/2020</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <p style="padding: 15px;font-style: italic;">Hẹn gặp bạn tại lớp học !</p>
                </div>
            </div>
            <div style="padding: 10px; text-align: center">
                <button class="btn btn-lg btn-success mx-auto btn_send_feedback" onclick="Send_feedback()">Gửi</button>
            </div>
        </div>
        <div class="col-sm-0 col-md-2 col-lg-3 col-xl-4"></div>
    </div>
</div>
<br>
<br>
<br>
<br>
<script>
    function Send_feedback() {
        var class_code = $('#class_info_feedback').val();
        var type_class = $('#type_class').val();

        var hoten = $('#hoten').val();
        var phone = $('#phone').val();
        var email = $('#email').val();
        var shift = $('#shift').val();

        var token = $('#token').val();
        var time_start = $('#time_start').val();

        if (hoten.trim() === ''){
            alert('Bạn cần nhập họ tên !'); return false;
        }
        if (phone.trim() === ''){
            alert('Bạn cần nhập số điện thoại !'); return false;
        }
        if (email.trim() === ''){
            alert('Bạn cần nhập email !'); return false;
        }
        if (shift === null){
            alert('Bạn cần chọn ca học !'); return false;
        }

        $.ajax({
            url : "/feedback/send_feedback",
            type : "post",
            dataType:"json",
            data : {
                type: 'thicuoiky',
                hoten: hoten,
                phone: phone,
                email: email,
                shift: shift,
                token: token,
                time_start: time_start,
                type_class: type_class,
                class_code: class_code,
            },
            beforeSend: function(){
                $('.btn_send_feedback').attr('disabled', true);
            },
            success : function (result){
                $('.btn_send_feedback').attr('disabled', false);
                alert(result.message);
                if(result.error == false){
                    location.reload();
                }
            }
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

