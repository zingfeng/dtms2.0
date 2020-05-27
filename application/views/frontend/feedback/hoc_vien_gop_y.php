<html>
<head>
    <title>PHIẾU KHẢO SÁT CHẤT LƯỢNG ĐÀO TẠO IMAP</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://www.anhngumshoa.com/theme/frontend/default/images/favicon.ico">
    <base href="/">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://dtms.aland.edu.vn/theme/frontend/default/css/fontAwesome/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="https://dtms.aland.edu.vn/theme/frontend/default/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" href="theme/frontend/default/css/feedback.css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
    <link href="theme/frontend/default/css/select2.min.css" rel="stylesheet" />
    <script src="theme/frontend/default/js/select2.min.js"></script>
    <style type="text/css">
        body{
            font-family: 'Muli', sans-serif;
        }
        .select_quest_feedback_select {
            font-size: medium !important;
        }
    </style>
</head>
<body style="background-color: rgb(70,126,159);" >
<div class="container" >
    <div class="row">
        <div class="col-sm-0 col-md-3 col-lg-3 col-xl-3" ></div>

        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6"  style="background-color: white; padding: 30px; ">
            <div style="background-color: transparent; padding: 10px; ">
                <div class="row">
                    <div class="col col-sm-12 col-md-4">
                        <img style=" max-width: 100%; padding-top: 20px;" src="<?php echo $type_detail['logo']; ?>" alt="logo IMAP">
                    </div>
                    <div class="col col-sm-12 col-md-8">
                        <h2 class="title_top">FORM PHẢN ÁNH CHẤT LƯỢNG DỊCH VỤ TẠI <?php echo $type_detail['name']; ?></h2>
                    </div>
                </div>
                <div class="description">
                    <br><br><br><br><br>
                    <?php
                        if (isset($_GET['type'])){
                            $__type = $_GET['type'];
                        }else{
                            $__type = 'imap';
                        }
                        switch ($__type){
                            case 'giaotiep':
                                $brand = 'Ms Hoa Giao Tiếp';
                                break;
                            case 'ielts':
                                $brand = 'Ielts Fighter';
                                break;
                            case 'toeic':
                                $brand = 'Anh ngữ Ms Hoa';
                                break;
                            case 'aland':
                                $brand = 'Aland';
                                break;
                            default:
                                $brand = 'IMAP';
                        }
                        switch ($__type){
                            case 'aland':
                                $content = '<p>Gửi Ba Mẹ cùng các bạn học viên thân yêu,</p>
                                    <p>Cảm ơn Ba Mẹ cùng các con đã tin tưởng và lựa chọn ALAND ENGLISH là nơi đồng hành trong chặng đường chinh phục tiếng Anh.</p>
                                    <p>Nhằm thấu hiểu những khó khăn mà các con đang gặp phải, những mong muốn, kỳ vọng của các con về một môi trường học tiếng Anh hiệu quả, tràn đầy cảm hứng, ALAND ENGLISH mong muốn nhận được những ý kiến đóng góp của ba mẹ cùng các con để trung tâm ngày một hoàn thiện hơn, trở thành ngôi nhà thứ hai mang lại nhiều giá trị về ngôn ngữ cho các con hơn.</p>
                                    <p>Ba Mẹ cùng các con vui lòng điền ý kiến của mình vào form dưới đây cho trung tâm nhé ạ.</p>
                                    <p>Một lần nữa cảm ơn Ba Mẹ cùng các con!</p>';
                                break;
                            default:
                                $content = '<p>Gửi các bạn học viên thân yêu,</p>
                                    <p>Cảm ơn các bạn đã tin tưởng và lựa chọn <b>'.$brand.'</b> là nơi đồng hành trong chặng đường chinh phục tiếng Anh của mình.</p>
                                    <p>Nhằm thấu hiểu những khó khăn mà các bạn đang gặp phải, những mong muốn, kỳ vọng của các bạn về một môi trường học tiếng Anh hiệu quả, tràn đầy cảm hứng, các bạn hãy đừng ngại ngần chia sẻ với <b>'.$brand.'</b> những ý kiến đóng góp của mình nhé. </p>
                                    <p>Bạn vui lòng điền ý kiến của mình vào form dưới đây. Những ý kiến vô cùng quý báu của các bạn sẽ giúp <b>'.$brand.'</b> ngày càng hoàn thiện, mang đến nhiều giá trị hơn nữa cho học viên.</p>
                                    <p>Một lần nữa cảm ơn các bạn!</p>';
                        }
                        echo $content;
                        ?>
                </div>
            </div>

            <div class="row">
                <div class="col col-sm-12">
                    <div class="form-group" style="padding: 5px 20px; font-size: large;">
                        <label class="control-label">Cơ sở</label>
                        <select name="location" class="form-control" id="suggest_location" placeholder="Cơ sở"></select>
                    </div>
                    <div class="form-group" style="padding: 5px 20px; font-size: large;">
                        <label class="control-label">Lớp học</label>
                        <select data-query-location_id="" name="class_code" id="suggest_class" class="form-control" placeholder="Lớp học"></select>
                    </div>
                    <div class="form-group" style="padding: 5px 20px; font-size: large;">
                        <label class="control-label">Họ tên</label>
                        <input type="text" name="name_feeder" class="form-control" id="name_feeder" placeholder="Họ tên">
                    </div>
                    <div class="form-group" style="padding: 5px 20px; font-size: large;">
                        <label class="control-label">Số điện thoại</label>
                        <input type="tel" name="phone" class="form-control" id="phone" placeholder="Số điện thoại">
                    </div>
                </div>
            </div>
            <input type="hidden" class="form-control" id="time_start" value="<?php echo $time_start; ?>">
            <input type="hidden" class="form-control" id="type_feedback" value="<?php echo $type_feedback; ?>">
            <input type="hidden" class="form-control" id="token" value="<?php echo $token; ?>">

            <?php creat_feedback_list_question_text2($list_quest_text,300); ?>

            <div class="row">
                <div class="col-sm-12">
                    <p style="padding: 15px;font-style: italic;">Chân thành cảm ơn những ý kiến đóng góp quý báu của Bạn, <?php echo $brand; ?> sẽ không ngừng nỗ lực để thực hiện sứ mệnh của mình !</p>
                </div>
            </div>
            <div style="padding: 10px; text-align: center">
                <button class="btn btn-lg btn-success mx-auto btn_send_feedback" onclick="Send_feedback()">Gửi</button>
            </div>
        </div>

        <div class="col-sm-0 col-md-3 col-lg-3 col-xl-3" ></div>
    </div>

</div>
<br>
<br>
<br>
<script>
    $(document).ready(function() {
        $("#suggest_location").on("change",function(){
            $("#suggest_class").attr("data-query-location_id",$(this).val());
        });
        $("#suggest_class").select2({
            allowClear: true,
            placeholder: 'Chọn hoặc tìm Lớp học',
            ajax: {
                url: "/feedback/suggest_class_code",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term, // search term
                        page: params.page,
                        location_id: $("#suggest_class").attr('data-query-location_id'),
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.option.nextpage
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateSelection: function(data) {
                if (typeof (data.item_id) != 'undefined') {
                    $("#suggest_class").val(data.item_id);
                }
                return data.text;
            }
        });
        $("#suggest_location").select2({
            allowClear: true,
            placeholder: 'Chọn hoặc tìm cơ sở',
            ajax: {
                url: "/feedback/suggest_location",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term, // search term
                        page: params.page,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.option.nextpage
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateSelection: function(data) {
                if (typeof (data.item_id) != 'undefined') {
                    $("#suggest_location").val(data.item_id);
                }
                return data.text;
            }
        });
    });
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

        var class_code = $('#suggest_class').val();
        var location = $('#suggest_location').val();
        var type = $('#type_feedback').val();
        var name_feeder = $('#name_feeder').val();
        var time_start = $('#time_start').val();
        var phone = $('#phone').val();
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
                phone: phone,
                location: location,
            },
            function (data, status) {
                console.log(data);
                // alert('Thank you!');
                // location.reload();
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
