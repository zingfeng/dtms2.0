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

        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6"  style="/*max-width: 100%; width: 750px; margin: auto; */    background-color: white; padding: 30px; " >
            <div style="background-color: transparent; padding: 10px; ">
                <div class="row">
                    <div class="col col-sm-12 col-md-4">
                        <img  style="    max-width: 100%;    padding-top: 20px;" src="theme/frontend/default/images/images/logo/logoImap.png" alt="logo IMAP">
                    </div>
                    <div class="col col-sm-12 col-md-8">
                        <h2 class="title_top">HÒM THƯ GÓP Ý</h2>
                    </div>
                    
                </div>
               
                <div class="description">
                    <br><br><br><br><br>
                    <p style="padding-left: 35px;">
                        Gửi các bạn học viên thân yêu,
                    </p>
                    Cảm ơn các bạn đã tin tưởng và lựa chọn
                    <b><?php
                        if (isset($_GET['type'])){
                            $__type = $_GET['type'];
                        }else{
                            $__type = 'imap';
                        }
                        switch ($__type){
                            case 'giaotiep':
                                echo 'Ms Hoa Giao Tiếp';
                                break;
                            case 'ielts':
                                echo 'Ielts Fighter';
                                break;
                            case 'toeic':
                                echo 'Anh ngữ Ms Hoa';
                                break;
                            case 'aland':
                                echo 'Aland';
                                break;
                            default:
                                echo 'IMAP';
                        }
                        ?></b>
                    là nơi đồng hành trong chặng đường chinh phục tiếng Anh của mình.
                    <br><br>Nhằm thấu hiểu những khó khăn mà các bạn đang gặp phải, những mong muốn, kỳ vọng của các bạn về một môi trường học tiếng Anh hiệu quả, tràn đầy cảm hứng, các bạn hãy đừng ngại ngần chia sẻ với cô những ý kiến đóng góp của mình nhé.
                    Các bạn vui lòng điền ý kiến vào form dưới đây, những thông tin này sẽ được gửi trực tiếp đến mail của cô và hoàn toàn bảo mật, các bạn yên tâm chia sẻ với cô nhé.
                    <br><br>Những ý kiến vô cùng quý báu của các bạn sẽ giúp cô và hệ thống ngày càng hoàn thiện, mang đến nhiều giá trị hơn nữa cho học viên.
                    <br>
                    <p style="padding-left: 35px;">Một lần nữa cảm ơn các bạn!</p>

                    </div>
            </div>
            <!--            <hr>-->

            <div class="row">
                <div class="col col-sm-12">
                    <div class="form-group" style="padding: 5px 20px; font-size: large;">
                        <input type="text" class="form-control" id="name_feeder" placeholder="Họ tên">
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

<!--             <h3 class="title_group_quest">Đóng góp ý kiến</h3> --><?php
//            var_dump($list_quest_text);
            creat_feedback_list_question_text2($list_quest_text,300);
            ?>

            <div class="row">
                <div class="col-sm-12">
                    <p style="
    padding: 15px;
    font-style: italic;
">Chân thành cảm ơn những ý kiến đóng góp quý báu của Bạn, IMAP sẽ không ngừng nỗ lực để thực hiện sứ mệnh của mình !</p>
                </div>

            </div>
            <div style="padding: 10px; text-align: center">
                <button class="btn btn-lg btn-success mx-auto btn_send_feedback" onclick="Send_feedback()">Gửi</button>
            </div>
        </div>

        <div class="col-sm-0 col-md-3 col-lg-3 col-xl-3" ></div>
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

        var class_code = "<?php  echo $_GET['my_class'];?>";
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

