<html>
<head>
    <title>PHIẾU ĐĂNG KÝ LỚP LUYỆN ĐỀ TẠI <?php
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

        <div class="col-sm-12 col-md-8 col-lg-6 col-xl-4"
             style="/*max-width: 100%; width: 750px; margin: auto; */    background-color: white; padding: 0; ">
            <div style="background-color: transparent; padding: 10px; ">
                <div class="row">
                    <div class="col col-sm-12 col-md-4">
                        <img style="    max-width: 100%;    padding-top: 20px;"
                             src="<?php
                                    echo $type_detail['logo'];
                             ?>" alt="logo IMAP">
                    </div>
                    <div class="col col-sm-12 col-md-8">
                        <h2 class="title_top">FORM ĐĂNG KÝ LỚP LUYỆN ĐỀ TẠI <?php
                        echo $type_detail['name'];
                        ?>
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
                        <label for="usr">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="">
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
            <div class="row" style="padding: 5px 20px; font-size: large; <?php
            if ($type_class == 'giaotiep') echo ' display:none; ';
?>" >
                <div class="col col-sm-6">
                    <p class="quest_title" id="quest_title_200" style="font-size:medium ">Lựa chọn trình độ</p>
                </div>
                <div class="col col-sm-6">
                    <div class="form-group" style="">
                        <select class="form-control select_quest_feedback_select" name="level" id="level">
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
                        <select class="form-control select_quest_feedback_select" name="shift" id="shift">
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

        <div class="col-sm-0 col-md-2 col-lg-3 col-xl-4"></div>
    </div>

</div>


<div class="container">
    <h5>. </h5>
</div>

<script>
    function Send_feedback() {
        var class_code = $('#class_info_feedback ').val();
        var type_class = $('#type_class ').val();

        var hoten = $('#hoten').val();
        var phone = $('#phone').val();
        var email = $('#email').val();
        var shift = $('#shift').val();
        var level = $('#level').val();

        var token = $('#token').val();
        var time_start = $('#time_start').val();

        if (hoten.trim() === ''){
            alert('Bạn cần nhập họ tên !'); return false;
        }
        if (phone.trim() === ''){
            alert('Bạn cần nhập số điện thoại !'); return false;
        }
        if (shift === null){
            alert('Bạn cần chọn ca học !'); return false;
        }
        if (type_class !== 'giaotiep'){
            if (level === null){
                alert('Bạn cần chọn trình độ phù hợp !'); return false;
            }
        }

        $.post("/feedback/send_feedback",
            {
                type: 'luyende',
                hoten: hoten,
                phone: phone,
                email: email,
                shift: shift,
                level: level,
                token: token,
                time_start: time_start,
                type_class: type_class,
                class_code: class_code,
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

