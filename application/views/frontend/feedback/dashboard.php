<h1 class="my_title" style="margin-bottom: 0">Dashboard
    <i class="fa fa-info-circle fa_info_feedback" aria-hidden="true" data-toggle="modal" data-target="#modal_info"></i>
</h1>
<h3><a style="font-weight: bold; color: firebrick" href="https://dtms.aland.edu.vn/uploads/files/FeedbackIMAP.pdf" target="_blank">Hướng dẫn sử dụng cho người mới bắt đầu</a></h3>
<div class="container-fluid" style="margin-top: 20px; border-top: 1px solid #bdbdbd;">
    <div class="row">
        <div class="col col-sm-12 col-md-6 ">
            <h3 style="font-weight: bold; color: firebrick;">Danh sách lớp quá hạn khảo sát</h3>
            <div class="list_in_table container-fluid" id="list_class">
                <table id="dtClassList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm" rowspan="2">ID</th>
                        <th class="th-sm" rowspan="2">Type</th>
                        <th class="th-sm" rowspan="2">Mã lớp</th>
                        <th class="th-sm" rowspan="2">Giáo viên</th>
                        <th class="th-sm" rowspan="2">Ngày khai giảng</th>
                        <th class="th-sm" rowspan="2">Cơ sở</th>
                        <th class="th-sm" colspan="2">Ngày khảo sát</th>
                    </tr>
                    <tr>
                        <th class="th-sm">Lần 1</th>
                        <th class="th-sm">Lần 2</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($feedback_notify as $mono_class_info) { ?>
                        <tr>
                            <td><?php echo $mono_class_info['class_id']; ?></td>
                            <td><?php
                                switch ($mono_class_info['type']) {
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

                                ?></td>
                            <td><?php echo $mono_class_info['class_code']; ?></td>
                            <td>
                                <ol>
                                    <?php
                                    $list_teacher_id = json_decode($mono_class_info['list_teacher'],true);
                                    foreach ($list_teacher_id as $teacher_id) { ?>
                                        <li><?php echo $arr_techer_id_to_teacher_info[$teacher_id]['name']; ?></li>
                                    <?php }
                                    ?>
                                </ol>
                            </td>
                            <td><?php
                                $mono_open_day_Y_m_d = $mono_class_info['opening_day'];
                                if ($mono_open_day_Y_m_d != ''){
                                    echo substr($mono_open_day_Y_m_d,8,2).'/'.substr($mono_open_day_Y_m_d,5,2).'/'.substr($mono_open_day_Y_m_d,0,4);
                                }?>
                            </td>
                            <td style="max-width: 300px;"><?php echo $mono_class_info['name']; ?></td>
                            <td><?php echo date("d-m-Y", $mono_class_info['time_feedback1']); ?></td>
                            <td><?php echo date("d-m-Y", $mono_class_info['time_feedback2']); ?></td>
                        </tr>
                        <?php
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col col-sm-12 col-md-6">
            <h3  style="font-weight: bold; color: #0b2e13;">Danh sách lớp chuẩn bị khảo sát</h3>
            <div class="list_in_table container-fluid" id="list_class">
                <table id="dtClassListSurvey" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm" rowspan="2">ID</th>
                        <th class="th-sm" rowspan="2">Type</th>
                        <th class="th-sm" rowspan="2">Mã lớp</th>
                        <th class="th-sm" rowspan="2">Giáo viên</th>
                        <th class="th-sm" rowspan="2">Ngày khai giảng</th>
                        <th class="th-sm" rowspan="2">Cơ sở</th>
                        <th class="th-sm" colspan="2">Ngày khảo sát</th>
                    </tr>
                    <tr>
                        <th class="th-sm">Lần 1</th>
                        <th class="th-sm">Lần 2</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($feedback_survey as $mono_class_info) { ?>
                        <tr>
                            <td><?php echo $mono_class_info['class_id']; ?></td>
                            <td><?php
                                switch ($mono_class_info['type']) {
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

                                ?></td>
                            <td><?php echo $mono_class_info['class_code']; ?></td>
                            <td>
                                <ol>
                                    <?php
                                    $list_teacher_id = json_decode($mono_class_info['list_teacher'],true);
                                    foreach ($list_teacher_id as $teacher_id) { ?>
                                        <li><?php echo $arr_techer_id_to_teacher_info[$teacher_id]['name']; ?></li>
                                    <?php }
                                    ?>
                                </ol>
                            </td>
                            <td><?php
                                $mono_open_day_Y_m_d = $mono_class_info['opening_day'];
                                if ($mono_open_day_Y_m_d != ''){
                                    echo substr($mono_open_day_Y_m_d,8,2).'/'.substr($mono_open_day_Y_m_d,5,2).'/'.substr($mono_open_day_Y_m_d,0,4);
                                }?>
                            </td>
                            <td style="max-width: 300px;"><?php echo $mono_class_info['name']; ?></td>
                            <td><?php echo date("d-m-Y", $mono_class_info['time_feedback1']); ?></td>
                            <td><?php echo date("d-m-Y", $mono_class_info['time_feedback2']); ?></td>
                        </tr>
                        <?php
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_info">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Genaral Infomation</h4>
                <!--                        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p><i></i>Số lượng Feedback: <span><?php echo $count_paper; ?></span></p>
                <p><i></i>Số lượng Lớp học: <span><?php echo $count_class; ?></span></p>
                <p><i></i>Số lượng Giáo viên: <span><?php echo $count_teacher; ?></span></p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="modal" id="modal_giao_tiep_info">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Giao tiếp Infomation</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p><i></i>Số lượng Feedback: <span><?php echo $info_giaotiep['count_paper']; ?></span></p>
                <p><i></i>Số lượng Lớp học: <span><?php echo $info_giaotiep['count_class'] ; ?></span></p>
                <p><i></i>Số lượng Giáo viên: <span><?php echo $info_giaotiep['count_teacher']; ?></span></p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="modal" id="modal_toeic_info">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Toeic Infomation</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p><i></i>Số lượng Feedback: <span><?php echo $info_toeic['count_paper']; ?></span></p>
                <p><i></i>Số lượng Lớp học: <span><?php echo $info_toeic['count_class'] ; ?></span></p>
                <p><i></i>Số lượng Giáo viên: <span><?php echo $info_toeic['count_teacher']; ?></span></p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="modal" id="modal_ielts_info">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Ielts Infomation</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p><i></i>Số lượng Feedback: <span><?php echo $info_ielts['count_paper']; ?></span></p>
                <p><i></i>Số lượng Lớp học: <span><?php echo $info_ielts['count_class'] ; ?></span></p>
                <p><i></i>Số lượng Giáo viên: <span><?php echo $info_ielts['count_teacher']; ?></span></p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="modal" id="modal_aland_info">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Aland Infomation</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p><i></i>Số lượng Feedback: <span><?php echo $info_aland['count_paper']; ?></span></p>
                <p><i></i>Số lượng Lớp học: <span><?php echo $info_aland['count_class'] ; ?></span></p>
                <p><i></i>Số lượng Giáo viên: <span><?php echo $info_aland['count_teacher']; ?></span></p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>







<div class="container-fluid">
    <div style="margin-right: 6%; margin-left: 6%">
        <div class="row">
            <div class="col col-sm-12 col-md-3 ">
                <div class="card_feedback">
                    <h3 class="title_card">Report Giao tiếp
                        <i class="fa fa-info-circle fa_info_feedback card_info_btn" aria-hidden="true" data-toggle="modal" data-target="#modal_giao_tiep_info"></i>
                    </h3>
                    <div class="img_logo_feed">
                        <a href="/feedback/giaotiep" target="_blank">
                            <img class="img_logo_feed_inside" src="theme/frontend/default/images/images/logo/giaotiep.png" alt="Xem mẫu">
                        </a>
                    </div>
                    <div class="giaotiep_report body_card">
                        <div>
                            <p class="text_card">Feedback Phone Newest</p>
                            <?php
                            if (isset($array_class_code_feedback_phone_type['giaotiep'])){
                                for ($i = 0; $i < min(count($array_class_code_feedback_phone_type['giaotiep']),15); $i++) {
                                    $class_code = $array_class_code_feedback_phone_type['giaotiep'][$i];
                                    ?>
                                    <p><?php echo $i + 1; ?>. <a href="/feedback/statistic/<?php echo $class_code; ?>"
                                                                 title ="<?php  echo 'Giáo viên: ';
                                                                 $list_teacher = $arr_info_class[$class_code]['list_teacher'];
                                                                 if ( ($list_teacher != '')&&($list_teacher != 'null')){
                                                                     $list_teacher_live = json_decode($list_teacher,true);
                                                                     foreach ($list_teacher_live as $super_mono_teacher_id) {
                                                                         echo $arr_techer_id_to_teacher_info[$super_mono_teacher_id]['name'].' ';
                                                                     }
                                                                 }
                                                                 echo ' | Cơ sở: ';
                                                                 $id_location_mono = $arr_info_class[$class_code]['id_location'];
                                                                 echo $arr_location_id_to_location_info[$id_location_mono]['name'];
                                                                 ?>"
                                                                 target="_blank"><?php echo $class_code; ?></a>
                                        <span class="point"><?php echo $arr_info_class[$class_code]['point_phone']; ?></span>
                                    </p>

                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <div>
                            <p class="text_card">Feedback Form Newest</p>

                            <?php
                            if (isset($top_class_giaotiep)) {
                                for ($i = 0; $i < count($top_class_giaotiep); $i++) {
                                    $mono = json_decode($top_class_giaotiep[$i], true);
                                    $type = $mono[0];
                                    $class_code = $mono[1];
                                    ?>
                                    <p><?php echo $i + 1; ?>. <a href="/feedback/statistic/<?php echo $class_code; ?>"
                                                                 title ="<?php  echo 'Giáo viên: ';
                                                                 $list_teacher = $arr_info_class[$class_code]['list_teacher'];
                                                                 if ( ($list_teacher != '')&&($list_teacher != 'null')){
                                                                     $list_teacher_live = json_decode($list_teacher,true);
                                                                     foreach ($list_teacher_live as $super_mono_teacher_id) {
                                                                         echo $arr_techer_id_to_teacher_info[$super_mono_teacher_id]['name'].' ';
                                                                     }
                                                                 }
                                                                 echo ' | Cơ sở: ';
                                                                 $id_location_mono = $arr_info_class[$class_code]['id_location'];
                                                                 echo $arr_location_id_to_location_info[$id_location_mono]['name'];
                                                                 ?>"
                                                                 target="_blank"><?php echo $class_code; ?></a>
                                        <span class="point"><?php echo $arr_info_class[$class_code]['point']; ?></span>

                                    </p>

                                    <?php

                                }
                            } ?>


                        </div>



                    </div>
                </div>
            </div>

            <div class="col col-sm-12 col-md-3 ">
                <div class="card_feedback">
                    <h3 class="title_card">Report Toeic
                        <i class="fa fa-info-circle fa_info_feedback card_info_btn" aria-hidden="true" data-toggle="modal" data-target="#modal_toeic_info"></i>
                    </h3>

                    <div class="img_logo_feed">
                        <a href="/feedback/toeic" target="_blank">
                            <img class="img_logo_feed_inside" src="theme/frontend/default/images/images/logo/toeic.jpg" alt="Xem mẫu">
                        </a>

                    </div>
                    <div class="toeic_report body_card">
                        <div>
                            <p class="text_card">Feedback Phone Newest</p>
                            <?php
                            if (isset($array_class_code_feedback_phone_type['toeic'])){
                                for ($i = 0; $i < min(count($array_class_code_feedback_phone_type['toeic']),15); $i++) {
                                    $class_code = $array_class_code_feedback_phone_type['toeic'][$i];
                                    ?>
                                    <p><?php echo $i + 1; ?>. <a href="/feedback/statistic/<?php echo $class_code; ?>"
                                                                 title ="<?php  echo 'Giáo viên: ';
                                                                 $list_teacher = $arr_info_class[$class_code]['list_teacher'];
                                                                 if ( ($list_teacher != '')&&($list_teacher != 'null')){
                                                                     $list_teacher_live = json_decode($list_teacher,true);
                                                                     foreach ($list_teacher_live as $super_mono_teacher_id) {
                                                                         echo $arr_techer_id_to_teacher_info[$super_mono_teacher_id]['name'].' ';
                                                                     }
                                                                 }
                                                                 echo ' | Cơ sở: ';
                                                                 $id_location_mono = $arr_info_class[$class_code]['id_location'];
                                                                 echo $arr_location_id_to_location_info[$id_location_mono]['name'];
                                                                 ?>"
                                                                 target="_blank"><?php echo $class_code; ?></a>

                                        <span class="point"><?php echo $arr_info_class[$class_code]['point_phone']; ?></span>

                                    </p>

                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <div>
                            <p class="text_card">Feedback Form Newest</p>

                            <?php
                            if (isset($top_class_toeic)) {
                                for ($i = 0; $i < count($top_class_toeic); $i++) {
                                    $mono = json_decode($top_class_toeic[$i], true);
                                    $type = $mono[0];
                                    $class_code = $mono[1];
                                    ?>
                                    <p><?php echo $i + 1; ?>. <a href="/feedback/statistic/<?php echo $class_code; ?>"
                                                                 title ="<?php  echo 'Giáo viên: ';
                                                                 $list_teacher = $arr_info_class[$class_code]['list_teacher'];
                                                                 if ( ($list_teacher != '')&&($list_teacher != 'null')){
                                                                     $list_teacher_live = json_decode($list_teacher,true);
                                                                     foreach ($list_teacher_live as $super_mono_teacher_id) {
                                                                         echo $arr_techer_id_to_teacher_info[$super_mono_teacher_id]['name'].' ';
                                                                     }
                                                                 }
                                                                 echo ' | Cơ sở: ';
                                                                 $id_location_mono = $arr_info_class[$class_code]['id_location'];
                                                                 echo $arr_location_id_to_location_info[$id_location_mono]['name'];
                                                                 ?>"

                                                                 target="_blank"><?php echo $class_code; ?></a>
                                        <span class="point"><?php echo $arr_info_class[$class_code]['point']; ?></span>

                                    </p>

                                    <?php

                                }
                            }

                            ?>
                        </div>


                    </div>
                </div>
            </div>

            <div class="col col-sm-12 col-md-3">
                <div class="card_feedback">

                <h3 class="title_card">Report Ielts
                    <i class="fa fa-info-circle fa_info_feedback card_info_btn" aria-hidden="true" data-toggle="modal" data-target="#modal_ielts_info"></i>
                </h3>

                <div class="img_logo_feed">
                    <a href="/feedback/ielts"  target="_blank">
                        <img class="img_logo_feed_inside" src="theme/frontend/default/images/images/logo/ielts.png" alt="Xem mẫu">
                    </a>
                </div>
                <div class="ielts_report body_card">
                    <div>
                        <p class="text_card">Feedback Phone Newest</p>
                        <?php
                        if (isset($array_class_code_feedback_phone_type['ielts'])){
                            for ($i = 0; $i < min(count($array_class_code_feedback_phone_type['ielts']),15); $i++) {
                                $class_code = $array_class_code_feedback_phone_type['ielts'][$i];
                                ?>
                                <p><?php echo $i + 1; ?>. <a href="/feedback/statistic/<?php echo $class_code; ?>"
                                                             title ="<?php  echo 'Giáo viên: ';
                                                             $list_teacher = $arr_info_class[$class_code]['list_teacher'];
                                                             if ( ($list_teacher != '')&&($list_teacher != 'null')){
                                                                 $list_teacher_live = json_decode($list_teacher,true);
                                                                 foreach ($list_teacher_live as $super_mono_teacher_id) {
                                                                     echo $arr_techer_id_to_teacher_info[$super_mono_teacher_id]['name'].' ';
                                                                 }
                                                             }
                                                             echo ' | Cơ sở: ';
                                                             $id_location_mono = $arr_info_class[$class_code]['id_location'];
                                                             echo $arr_location_id_to_location_info[$id_location_mono]['name'];
                                                             ?>"
                                                             target="_blank"><?php echo $class_code; ?></a>
                                    <span class="point"><?php echo $arr_info_class[$class_code]['point_phone']; ?></span>

                                </p>

                                <?php
                            }
                        }
                        ?>
                    </div>

                    <div>
                        <p class="text_card">Feedback Form Newest</p>
                        <?php
                        if (isset($top_class_ielts)) {
                            for ($i = 0; $i < count($top_class_ielts); $i++) {
                                $mono = json_decode($top_class_ielts[$i], true);
                                $type = $mono[0];
                                $class_code = $mono[1];
                                ?>
                                <p><?php echo $i + 1; ?>. <a href="/feedback/statistic/<?php echo $class_code; ?>"
                                                             title ="<?php  echo 'Giáo viên: ';
                                                             $list_teacher = $arr_info_class[$class_code]['list_teacher'];
                                                             if ( ($list_teacher != '')&&($list_teacher != 'null')){
                                                                 $list_teacher_live = json_decode($list_teacher,true);
                                                                 foreach ($list_teacher_live as $super_mono_teacher_id) {
                                                                     echo $arr_techer_id_to_teacher_info[$super_mono_teacher_id]['name'].' ';
                                                                 }
                                                             }
                                                             echo ' | Cơ sở: ';
                                                             $id_location_mono = $arr_info_class[$class_code]['id_location'];
                                                             echo $arr_location_id_to_location_info[$id_location_mono]['name'];
                                                             ?>"
                                                             target="_blank"><?php echo $class_code; ?></a>
                                    <span class="point"><?php echo $arr_info_class[$class_code]['point']; ?></span>

                                </p>

                                <?php

                            }
                        }

                        ?>
                    </div>


                </div>

                </div>
            </div>

            <div class="col col-sm-12 col-md-3">
                <div class="card_feedback">

                    <h3 class="title_card">Report Aland
                        <i class="fa fa-info-circle fa_info_feedback card_info_btn" aria-hidden="true" data-toggle="modal" data-target="#modal_aland_info"></i>
                    </h3>

                    <div class="img_logo_feed">
                        <a href="/feedback/aland"  target="_blank">
                            <img class="img_logo_feed_inside" src="theme/frontend/default/images/images/logo/aland.png" alt="Xem mẫu">
                        </a>
                    </div>
                    <div class="aland_report body_card">

                        <div>
                            <p class="text_card">Feedback Phone Newest</p>
                            <?php
                            if (isset($array_class_code_feedback_phone_type['aland'])){
                                for ($i = 0; $i < min(count($array_class_code_feedback_phone_type['aland']),15); $i++) {
                                    $class_code = $array_class_code_feedback_phone_type['aland'][$i];
                                    ?>
                                    <p><?php echo $i + 1; ?>. <a href="/feedback/statistic/<?php echo $class_code; ?>"
                                                                 title ="<?php  echo 'Giáo viên: ';
                                                                 $list_teacher = $arr_info_class[$class_code]['list_teacher'];
                                                                 if ( ($list_teacher != '')&&($list_teacher != 'null')){
                                                                     $list_teacher_live = json_decode($list_teacher,true);
                                                                     foreach ($list_teacher_live as $super_mono_teacher_id) {
                                                                         echo $arr_techer_id_to_teacher_info[$super_mono_teacher_id]['name'].' ';
                                                                     }
                                                                 }
                                                                 echo ' | Cơ sở: ';
                                                                 $id_location_mono = $arr_info_class[$class_code]['id_location'];
                                                                 echo $arr_location_id_to_location_info[$id_location_mono]['name'];
                                                                 ?>"
                                                                 target="_blank"><?php echo $class_code; ?></a>
                                        <span class="point"><?php echo $arr_info_class[$class_code]['point_phone']; ?></span>

                                    </p>

                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <div>
                            <p class="text_card">Feedback Form Newest</p>
                            <?php
                            if (isset($top_class_aland)) {
                                for ($i = 0; $i < count($top_class_aland); $i++) {
                                    $mono = json_decode($top_class_aland[$i], true);
                                    $type = $mono[0];
                                    $class_code = $mono[1];
                                    ?>
                                    <p><?php echo $i + 1; ?>. <a href="/feedback/statistic/<?php echo $class_code; ?>"
                                        title ="<?php  echo 'Giáo viên: ';
                                            $list_teacher = $arr_info_class[$class_code]['list_teacher'];
                                            if ( ($list_teacher != '')&&($list_teacher != 'null')){
                                                $list_teacher_live = json_decode($list_teacher,true);
                                                foreach ($list_teacher_live as $super_mono_teacher_id) {
                                                    echo $arr_techer_id_to_teacher_info[$super_mono_teacher_id]['name'].' ';
                                                }
                                            }
                                            echo ' | Cơ sở: ';
                                            $id_location_mono = $arr_info_class[$class_code]['id_location'];
                                            echo $arr_location_id_to_location_info[$id_location_mono]['name'];
                                        ?>"
                                                                 target="_blank"><?php echo $class_code; ?></a>
                                        <span class="point"><?php echo $arr_info_class[$class_code]['point']; ?></span>

                                    </p>

                                    <?php

                                }
                            }

                            ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>


    </div>
</div>

<div class="container-fluid" style="margin-top: 50px; border-top: 1px solid #bdbdbd;">


    <h3 >Hoạt động gần đây</h3>
    <div class="row">
        <div class="col col-sm-4">
            <h4 class="my_title">Feedback Form</h4>
            <table id="dtFeedbackList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID
                    </th>
                    <th class="th-sm">Thời gian
                    </th>
                    <th class="th-sm">Mã lớp
                    </th>
                    <th class="th-sm">Type
                    </th>
                    <th class="th-sm">Ghi chú
                    </th>
                </tr>
                </thead>
                <tbody>

                <?php
                if (isset($list_feedback_newest) && (is_array($list_feedback_newest))) {
                    foreach ($list_feedback_newest as $mono_feedback_paper) {
                        $class_code_mono = $mono_feedback_paper['class_code'];
                        $type = $mono_feedback_paper['type'];
                        $time_end = $mono_feedback_paper['time_end'];
                        $name_feeder = $mono_feedback_paper['name_feeder']; ?>
                        <tr>
                            <td><?php echo $mono_feedback_paper['id'] ?></td>
                            <td><?php echo date('d/m/Y - H:i:s', $time_end); ?></td>
                            <td><?php echo $class_code_mono ?></td>
                            <td><?php echo $type ?></td>
                            <td><?php echo $name_feeder ?></td>
                        </tr>

                        <?php
                    }
                }?>

                </tbody>
            </table>

        </div>
        <div class="col col-sm-8">
            <h4 class="my_title">Feedback Phone</h4>
            <table id="dtFeedbackList2" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID
                    </th>
                    <th class="th-sm">Thời gian
                    </th>
                    <th class="th-sm">Mã lớp
                    </th>
                    <th class="th-sm">Giáo viên
                    </th>
                    <th class="th-sm" title="Tên người phản hồi">Học viên
                    </th>
                    <th class="th-sm">Điểm
                    </th>
                    <th class="th-sm">Nhận xét
                    </th>
                </tr>
                </thead>
                <tbody>

                <?php
                if (isset($list_feedback_phone_newest) && (is_array($list_feedback_phone_newest))) {
                    foreach ($list_feedback_phone_newest as $mono_feedback_phone) {
                        $class_code_mono = $mono_feedback_phone['class_code'];
                        $time_end = $mono_feedback_phone['time'];
                        $name_feeder = $mono_feedback_paper['name_feeder']; ?>
                        <tr>
                            <td><?php echo $mono_feedback_phone['id'] ?></td>
                            <td><?php echo date('d/m/Y - H:i:s', $time_end); ?></td>
                            <td><?php echo $class_code_mono ?></td>
                            <td>
                                <?php
                                $list_teacher = $arr_info_class[$class_code_mono]['list_teacher'];
                                if ( ($list_teacher != '')&&($list_teacher != 'null')){
                                    $list_teacher_live = json_decode($list_teacher,true);
                                    foreach ($list_teacher_live as $super_mono_teacher_id) {
                                        echo $arr_techer_id_to_teacher_info[$super_mono_teacher_id]['name'].' ';
                                    }
                                }
                                ?>
                            </td>
                            <td><?php echo $mono_feedback_phone['name_feeder'] ?></td>
                            <td><?php echo $mono_feedback_phone['point'] ?></td>
                            <td><?php echo $mono_feedback_phone['comment'] ?></td>
                        </tr>

                        <?php
                    }
                }?>

                </tbody>
            </table>

        </div>
    </div>

</div>


<script>
    $(document).ready(function () {
        $("span.point").each(function () {
            var value_string = $(this).html();
            value =parseFloat(value_string);
            console.log("value");
            console.log(value);

            switch (true) {
                case (value >= 9.5):
                    // $xeploai = 'Xuất sắc';
                    $(this).css("color", "green");
                    $(this).attr("title", "Xuất sắc");

                    break;
                case (value >= 9):
                    $(this).css("color", "orange");
                    $(this).attr("title", "Giỏi");


                    // $xeploai = 'Giỏi';
                    break;
                case (value >= 8.6):
                    $(this).css("color", "red");
                    $(this).attr("title", "Khá");


                    // $xeploai = 'Khá';
                    break;
                case (value >= 8):
                    $(this).css("color", "brown");
                    $(this).attr("title", "Trung bình");


                    // $xeploai = 'Trung bình';
                    break;
                default:
                    break;
            }
        });


        $('#dtFeedbackList').DataTable({
            "pageLength": 50,

            "ordering": false // false to disable sorting (or any other option)
        });
        $('#dtFeedbackList2').DataTable({
            "pageLength": 50,

            "ordering": false // false to disable sorting (or any other option)
        });
        $('#dtClassList').DataTable({
            "pageLength": 10,
            "ordering": false // false to disable sorting (or any other option)
        });$('#dtClassListSurvey').DataTable({
            "pageLength": 10,
            "ordering": false // false to disable sorting (or any other option)
        });
        $('.dataTables_length').addClass('bs-select');

        // Tô màu điểm

    });
</script>







