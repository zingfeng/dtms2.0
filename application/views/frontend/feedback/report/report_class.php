<?php
$data_singleview = $data['singleview'];
?>
<!--<!DOCTYPE HTML>-->
<!--<html>-->
<!--<head>-->
<!--    <base href="/">-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>-->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<!--    <link rel="stylesheet"-->
<!--          href="https://qlcl.imap.edu.vn/theme/frontend/default/css/fontAwesome/css/font-awesome.min.css" media="all">-->
<!--    <link rel="stylesheet" href="https://qlcl.imap.edu.vn/theme/frontend/default/css/bootstrap.min.css" media="all">-->


    <script>
        window.onload = function () {
            CanvasJS.addColorSet("greenShades",
                [   // colorSet Array
                    //
                    // "rgb(223,249,218)",
                    // "rgb(196,232,203)",
                    // "rgb(116,194,134)",
                    // "rgb(24,139,65)",
                    // "rgb(0,103,31)",

                    "rgb(210,238,234)",
                    "rgb(153,207,209)",
                    "rgb(103,168,182)",
                    "rgb(59,128,154)",
                    "rgb(42,86,118)",
                ]);
            CanvasJS.addColorSet("super",
                [   // colorSet Array
                    //
                    // "rgb(223,249,218)",
                    // "rgb(196,232,203)",
                    // "rgb(116,194,134)",
                    // "rgb(24,139,65)",
                    // "rgb(0,103,31)",

                    "rgb(11,191,89)",
                    "rgb(193,52,53)",
                    "rgb(103,168,182)",
                    "rgb(59,128,154)",
                    "rgb(42,86,118)",
                ]);


            render_all_chart();
        };

        function render_chart_type_ruler(id_div, data) {

            var x1 = data['1'];
            var x2 = data['2'];
            var x3 = data['3'];
            var x4 = data['4'];
            var x5 = data['5'];

            var sum = x1*1 + x2*2 + x3*3 + x4*4 + x5*5;
            var count = x1 + x2 + x3 + x4 + x5;
            if (count > 0){
                var tbc = sum / count;
            }else{
                var tbc = 0;
            }

            tbc = Math.round(tbc * 100) / 100;

            $('#average' + id_div).html('Average: ' + tbc);

            var my_dataPoint = [];
            // if (x1 > 0){
                my_dataPoint.push({y: x1 / count * 100, label: "Rất kém"});
            // }
            // if (x2 > 0){
                my_dataPoint.push({y: x2 / count * 100, label: "Khá kém"});
            // }
            // if (x3 > 0){
                my_dataPoint.push({y: x3 / count * 100, label: "Bình thường"});
            // }

            // if (x4 > 0){
                my_dataPoint.push({y: x4 / count * 100, label: "Khá tốt"});
            // }

            // if (x5 > 0){
                my_dataPoint.push({y: x5 / count * 100, label: "Rất tốt"});
            // }

            console.log("my_dataPoint");
            console.log(my_dataPoint);

            var chart = new CanvasJS.Chart(id_div, {
                colorSet: "greenShades",

                animationEnabled: true,
                title: {
                    text: data['title']
                },
                data: [{
                    type: "pie",
                    startAngle: -90,
                    yValueFormatString: "##0.00\"%\"",
                    indexLabel: "{label} {y}",
                    dataPoints: my_dataPoint,
                }]
            });
            chart.render();
        }

        function render_chart_type_radio(id_div, data) {
            var x0 = data['0'];
            var x1 = data['1'];
            var sum = x0*0 + x1*1;
            if ( (x0 + x1 ) > 0){
                var tbc = sum/(x0 + x1);
            }else{
                var tbc = 0;
            }
            tbc = Math.round(tbc * 100) / 100;
            $('#average' + id_div).html('Average: ' + tbc);

            var chart = new CanvasJS.Chart(id_div, {
                colorSet: "super",
                animationEnabled: true,
                title: {
                    text: data['title']
                },
                data: [{
                    type: "pie",
                    startAngle: -90,
                    yValueFormatString: "##0.00\"%\"",
                    indexLabel: "{label} {y} {more}",
                    dataPoints: [

                        {y: x1 / sum * 100, label: "Có", more: ' (số lượng: ' + x1 + ')'},
                        {y: x0 / sum * 100, label: "Không", more: ' (số lượng: ' + x0 + ')'},

                    ]
                }]
            });
            chart.render();
        }

        function render_chart_type_select(id_div, data) {
            var sum = 0;
            var count = 0;
            for (var i = 1; i < 11; i++) {
                var i_str = i.toString();
                var val = data[i_str];
                sum += val * i;
                count += val;
            }

            if (count > 0){
                var tbc = sum/count;
            }else{
                var tbc = 0;
            }

            tbc = Math.round(tbc * 100) / 100;

            $('#average' + id_div).html('Average: ' + tbc);


            var chart = new CanvasJS.Chart(id_div, {
                animationEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: data['title']
                },
                axisY: {
                    title: "Số lượng"
                },
                data: [{
                    type: "column",
                    showInLegend: true,
                    legendMarkerColor: "grey",
                    legendText: "Điểm",
                    dataPoints: [
                        {y: data['1'], label: "1"},
                        {y: data['2'], label: "2"},
                        {y: data['3'], label: "3"},
                        {y: data['4'], label: "4"},
                        {y: data['5'], label: "5"},
                        {y: data['6'], label: "6"},
                        {y: data['7'], label: "7"},
                        {y: data['8'], label: "8"},
                        {y: data['9'], label: "9"},
                        {y: data['10'], label: "10"},
                    ]
                }]
            });
            chart.render();
        }

        function render_all_chart() {
            $(".feedback_chart").each(function () {
                var id = $(this).attr('id');
                var data = $(this).attr('data');
                var type = $(this).attr('type');
                data = JSON.parse(data);
                data['title'] = $(this).attr('title');
                switch (type) {
                    case 'ruler':
                        render_chart_type_ruler(id, data);
                        break;
                    case 'radio':
                        render_chart_type_radio(id, data);
                        break;
                    case 'select':
                        render_chart_type_select(id, data);
                        break;
                }
            });
        }

    </script>

    <style type="text/css">
        body {
            background-color: #f9f9f9;
        }

        p.average{
            font-size: large;
            font-weight: bold;
            margin: 0 8px;
            padding: 0;
            text-align: right;
        }

        .p_title_chart {
            text-align: center;
            color: #3e3d3d;
            font-weight: bold;
            font-size: 22px;
            height: 95px;
            overflow: auto;

        }

        .div_ruler_chart_inside {
            background: white;
            padding: 20px;
            border-radius: 4px;
            /*border: 1px solid #170a0a;*/
            margin-bottom: 10px;
            margin-top: 10px;
            box-shadow: 0 8px 10px -5px rgba(0, 0, 0, .2), 0 16px 24px 2px rgba(0, 0, 0, .14), 0 6px 30px 5px rgba(0, 0, 0, .12);

        }

        .card_text {
            padding: 8px;
            /*border-bottom: 1px solid grey;*/
            background: white;
            box-shadow: 0 8px 10px -5px rgba(0, 0, 0, .2), 0 16px 24px 2px rgba(0, 0, 0, .14), 0 6px 30px 5px rgba(0, 0, 0, .12);
            border-radius: 4px;
            margin: 15px;
        }

        .li_text {
            font-size: medium;
        }
        .overview{
            font-size: x-large;
        }

        .card_normal{
            box-shadow: none !important;
        }

    </style>
<!--</head>-->
<!--<body>-->

<div class="singleview container-fluid" style="padding: 5px 15px;">
    <div class="row text_and_radio_quest_info">
        <div class="col-sm-12 col-md-4 hidden-md hidden-lg" style="margin-bottom: 60px;">
            <div style=" font-size: medium;   padding: 40px;    margin: 0 20px;    background: rgb(0, 148, 133);    color: white;">
                <h3 >Thông tin lớp học <?php echo $class_code;?></h3>
                <li>Mảng đào tạo: <?php
                    switch ($info_class['type']) {
                        case 'ielts':
                            echo 'Ielts Fighter';
                            break;
                        case 'giaotiep':
                            echo 'Giao tiếp';
                            break;
                        case 'toeic':
                            echo 'Toeic';
                            break;
                        case 'aland':
                            echo 'Aland';
                            break;
                        default:
                            echo '';
                    }

                    ?></li>
                <li>Ngày khai giảng: <?php echo $info_class['opening_day'] ; ?></li>
                <li>Thời gian nhận Feedback Form: Từ <?php echo date('d/m/Y - H:i:s',$info_class['time_start']);?>
                    đến <?php echo date('d/m/Y - H:i:s',$info_class['time_end']);?>
                </li>
                <li>Giáo viên:
                    <?php


                    for ($i = 0; $i < count($teacher_info); $i++) {
                        $mono_tt = $teacher_info[$i];
                        echo '<a style="  color: white;  font-weight: bold; text-decoration: underline;" href=\'/feedback/class_?teacher='.json_encode(array($mono_tt['teacher_id'])).'\' target="_blank">'.$mono_tt['name'].'</a> ';
                    }
                    ?>
                </li>
                <li>Cơ sở: <?php
                    echo $info_location['name'].' ('.$info_location['area'].') ';
                    ?></li>
            </div>



        </div>

        <div class="col col-sm-12 col-md-8" style="margin-bottom: 60px;">
            <h2 style="border-left: 5px solid #0bc75b;    padding-left: 8px;">Feedback Phone</h2>
            <?php

            if ( (! isset($view_feedback_phone) ) ||  ($view_feedback_phone == '')){
                echo '<p>Lớp học này hiện chưa có Feedback Phone</p>';
            }else{
                echo $view_feedback_phone;
            }

            ?>

        </div>

        <div class="col-sm-12 col-md-4 hidden-sm" style="margin-bottom: 60px;">
            <div style=" font-size: medium;   padding: 40px;    margin: 0 20px;    background: rgb(0, 148, 133);    color: white;">
                <h3 >Thông tin lớp học <?php echo $class_code;?></h3>
                    <li>Mảng đào tạo: <?php
                        switch ($info_class['type']) {
                            case 'ielts':
                                echo 'Ielts Fighter';
                                break;
                            case 'giaotiep':
                                echo 'Giao tiếp';
                                break;
                            case 'toeic':
                                echo 'Toeic';
                                break;
                            case 'aland':
                                echo 'Aland';
                                break;
                            default:
                                echo '';
                        }

                        ?></li>
                    <li>Ngày khai giảng: <?php echo $info_class['opening_day'] ; ?></li>
                    <li>Thời gian nhận Feedback Form: Từ <?php echo date('d/m/Y - H:i:s',$info_class['time_start']);?>
                        đến <?php echo date('d/m/Y - H:i:s',$info_class['time_end']);?>
                    </li>
                    <li>Giáo viên:
                        <?php


                        for ($i = 0; $i < count($teacher_info); $i++) {
                            $mono_tt = $teacher_info[$i];
                            echo '<a style="  color: white;  font-weight: bold; text-decoration: underline;" href=\'/feedback/class_?teacher='.json_encode(array($mono_tt['teacher_id'])).'\' target="_blank">'.$mono_tt['name'].'</a> ';
                        }
                        ?>
                    </li>
                    <li>Cơ sở: <?php
                        echo $info_location['name'].' ('.$info_location['area'].') ';
                        ?></li>
            </div>



        </div>
        <hr>

        <div class="col col-sm-12 col-md-6 col-lg-6 ">
            <h2 style="border-left: 5px solid #0bc75b;    padding-left: 8px;">Feedback Form</h2>

            <div class="overview">
                <div class="card_text card_normal">
                    <p class="p_title_chart" style="height: auto;">Thông tin chung</p>
                    <p>Mã lớp: <?php echo $class_code;?></p>
                    <p>Thời gian báo cáo: <?php echo date('d/m/Y - H:i:s',time()); ?></p>
                    <p>Số lượng feedback: <?php echo count($time_list); ?></p>
                    <p>Thời gian làm feedback trung bình: <?php echo $average_time; ?> giây </p>

                </div>

            </div>


            <?php
            for ($i = 0; $i < count($data_singleview); $i++) {
                $mono = $data_singleview[$i];
                $id_quest = $mono['id_quest'];
                $data = $mono['data'];
                $title = $mono['title'];
                $type = $mono['type'];

                if ($type != 'text') {
                    continue;
                }
//                      var_dump($mono);

                ?>

                <div class="card_text card_normal">
                    <p class="p_title_chart"><?php echo $title; ?></p>
                    <ol>
                        <?php
                        foreach ($data as $mono_data_text) {
                            ?>
                            <li class="li_text"><?php echo $mono_data_text; ?></li>
                        <?php }
                        ?>
                    </ol>
                </div>


            <?php }
            ?>

            <?php
            if  ( (isset($name_list)) && (is_array($name_list)) ){ ?>
                <div class="card_text card_normal">
                    <p class="p_title_chart" title="Danh sách cá nhân để lại tên khi làm feed back">Họ tên người làm feedback </p>
                    <ul style="font-size: large">
                        <?php
                        foreach ($name_list as $mono_name){
                            if (trim($mono_name) != ''){
                                echo '<li>'.$mono_name .'</li>' ;
                            }
                        }
                        ?>
                    </ul>
                </div>
            <?php }?>






            <?php
            for ($i = 0; $i < count($data_singleview); $i++) {
                $mono = $data_singleview[$i];
                $id_quest = $mono['id_quest'];
                $data = $mono['data'];
                $title = $mono['title'];
                $type = $mono['type'];

                if ($type == 'radio') { ?>
                    <div class="card_text">
                        <p class="p_title_chart"><?php echo $title; ?></p>
                        <p class="average" id="average<?php echo $id_quest; ?>"></p>
                        <div type="<?php echo $type; ?>" title="<?php //echo $title; // Vì lỗi font tiếng Việt
                        ?>" id="<?php echo $id_quest; ?>" data='<?php echo json_encode($data); ?>'
                             class="feedback_chart chartContainer"
                             style="height: 390px; width: 100%;"></div>
                    </div>
                    <?php
                }

//

//                if ($type == 'select') {
////                    var_dump($mono);
//                    ?>
<!---->
<!--                    <div class="card_text">-->
<!--                        <p class="p_title_chart">--><?php //echo $title; ?><!--</p>-->
<!--                        <div type="--><?php //echo $type; ?><!--" title="--><?php ////echo $title; // Vì lỗi font tiếng Việt
//                        ?><!--" id="--><?php //echo $id_quest; ?><!--" data='--><?php //echo json_encode($data); ?><!--'-->
<!--                             class="feedback_chart chartContainer"-->
<!--                             style="height: 390px; width: 100%;"></div>-->
<!--                    </div>-->
<!---->
<!---->
<!--                    --><?php
//                }
            }
            ?>




        </div>

        <div class="col col-sm-12 col-md-6 col-lg-6">

            <?php
            for ($i = 0; $i < count($data_singleview); $i++) {
                $mono = $data_singleview[$i];
                $id_quest = $mono['id_quest'];
                $data = $mono['data'];
                $title = $mono['title'];
                $type = $mono['type'];


                if ($type == 'select') {
//                    var_dump($mono);
                    ?>

                    <div class="card_text">
                        <p class="p_title_chart"><?php echo $title; ?></p>
                        <p class="average" id="average<?php echo $id_quest; ?>"></p>
                        <div type="<?php echo $type; ?>" title="<?php //echo $title; // Vì lỗi font tiếng Việt
                        ?>" id="<?php echo $id_quest; ?>" data='<?php echo json_encode($data); ?>'
                             class="feedback_chart chartContainer"
                             style="height: 390px; width: 100%;"></div>
                    </div>


                    <?php
                }
            }
            ?>





        </div>

    </div>

    <div class="row ruler_quest_info">
        <?php



        for ($i = 0; $i < count($data_singleview); $i++) {
            $mono = $data_singleview[$i];
            $id_quest = $mono['id_quest'];
            $data = $mono['data'];
            $title = $mono['title'];
            $type = $mono['type'];

            if ($type != 'ruler') {
                continue;
            }
            ?>
            <div class="col col-sm-12 col-md-6 col-lg-4 div_ruler_chart" style="">
                <div class="div_ruler_chart_inside">
                    <p class="p_title_chart"><?php echo $title; ?></p>
                    <p class="average" id="average<?php echo $id_quest; ?>"></p>
                    <div type="<?php echo $type; ?>" title="<?php //echo $title; // Vì lỗi font tiếng Việt ?>"
                         id="<?php echo $id_quest; ?>" data='<?php echo json_encode($data); ?>'
                         class="feedback_chart chartContainer"
                         style="height: 390px; width: 100%;"></div>
                </div>
            </div>

        <?php } ?>


    </div>


</div>

<div class="overview container-fluid">
    <div class="row">
        <div class="col col-sm-12 col-md-6">



        </div>


    </div>
    <?php
    //    $data_overview = $data['overview'];



    ?>
</div>




</div>

<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<script src="theme/frontend/default/lib/jquerycanvas/canvasjs.min.js"></script>
</body>
</html>
