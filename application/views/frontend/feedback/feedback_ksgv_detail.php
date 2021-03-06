<style>
    th{
        text-align: center;
    }
</style>
<h2 class="my_title">
    <?php
        if (isset($type_ksgv)){
            if ($type_ksgv === 'ksgv1'){
                echo ' Feedback Form mẫu 1';
            }elseif($type_ksgv === 'dao_tao_onl'){
//                echo ' Feedback đào tạo online';
                echo ' Feedback giữa kỳ';
            }else{
                echo ' Feedback cuối kỳ';
            }
        }
    ?>

</h2>

<div class="row">
    <div class="col col-md-4">
        <div>
            <h5>Danh sách câu hỏi</h5>
            <?php
            $list_quest_total = array();
            for ($i = 0; $i < count($list_quest_ruler); $i++) {
                echo '<p>'.$list_quest_ruler[$i].'</p>';
            }
            for ($i = 0; $i < count($list_quest_select); $i++) {
                echo '<p>'.$list_quest_select[$i].'</p>';
            }
            for ($i = 0; $i < count($list_quest_text); $i++) {
                echo '<p>'.$list_quest_text[$i].'</p>';
            }
            if($list_quest_ruler){
                $list_quest_total = array_merge($list_quest_ruler,$list_quest_total);
            }
            if($list_quest_select){
                $list_quest_total = array_merge($list_quest_select,$list_quest_total);
            }
            if($list_quest_text){
                $list_quest_total = array_merge($list_quest_text,$list_quest_total);
            }
            ?>
        </div>
    </div>
    <div class="col col-md-8">
        <div class="filter_div">
            <div class="hover-point" onclick="$('#body_filter').toggle();">
                <h4 class="text-primary" style="display: inline-block">Filter</h4>
                <button class="btn btn-primary btn-sm" style="float: right;padding-left: 120px; padding-right: 120px;" onclick="clickFilter()"><i class="fa fa-filter"></i> Filter</button>
                <a href="/feedback/class_"><button class="btn btn-danger btn-sm" style="float: right;padding-left: 20px; padding-right: 20px; margin-right: 20px;" onclick="clickFilter()"><i class="fa fa-filter"></i> X Filter</button></a>
                <button class="btn btn-success btn-sm" style="float: right;padding-left: 20px; padding-right: 20px; margin-right: 20px;" title="Export File" onclick="clickExport()">Export</button>
            </div>
            <div class="row" id="body_filter" style="<?php
            if ( (isset($_GET['type'])) || (isset($_GET['min'])) || (isset($_GET['max'])) || (isset($_GET['location'])) || (isset($_GET['area'])) || (isset($_GET['teacher']))  ){

            }else{
                echo ' display:none; ';
            }
            ?>" >
                <div class="col col-sm-6">
                    <div class="form-group">
                        <label>Mã lớp :</label>
                        <input type="input" class="form-control" name="class_code" id="class_code" value="<?php
                        if (isset($_REQUEST['class_code'])){
                            echo $_REQUEST['class_code'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="col col-sm-6">
                    <div class="form-group">
                        <label for="usr">Quản lý</label>
                        <select name="manager_email" id="manager_email" class="form-control" placeholder="Manager">
                            <option value="">Chọn quản lý</option>
                            <?php if(isset($list_manager) && count($list_manager) > 0) foreach ($list_manager as $manager) {?>
                                <option value="<?php echo $manager; ?>" <?php echo (isset($_REQUEST['manager_email']) && $_REQUEST['manager_email'] == $manager) ? 'selected' : '' ?>><?php echo $manager; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <p class="title_filter">by type </p>
                    <div>
                        <div class="checkbox">
                            <label><input  id="filter-type-anchor" type="checkbox" onchange="ClickSelectLabel('type')" checked > Select All </label>
                        </div>
                        <?php
                        if (isset($_GET['type'])){
                            $type_filter_live = json_decode($_GET['type'],true);
                            ?>
                            <div class="checkbox">
                                <label><input class="filter-type" type="checkbox" value="ielts" <?php if (in_array('ielts',$type_filter_live)){ echo ' checked '; }?>  >Ielts Fighter</label>
                            </div>
                            <div class="checkbox">
                                <label><input class="filter-type"  type="checkbox" value="toeic" <?php if (in_array('toeic',$type_filter_live)){ echo ' checked '; }?>>Toeic</label>
                            </div>
                            <div class="checkbox">
                                <label><input class="filter-type"  type="checkbox" value="giaotiep" <?php if (in_array('giaotiep',$type_filter_live)){ echo ' checked '; }?>>Giao tiếp</label>
                            </div>
                            <div class="checkbox">
                                <label><input class="filter-type"  type="checkbox" value="aland" <?php if (in_array('aland',$type_filter_live)){ echo ' checked '; }?>>Aland</label>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="checkbox">
                                <label><input class="filter-type" type="checkbox" value="ielts" checked>Ielts Fighter</label>
                            </div>
                            <div class="checkbox">
                                <label><input class="filter-type"  type="checkbox" value="toeic" checked>Toeic</label>
                            </div>
                            <div class="checkbox">
                                <label><input class="filter-type"  type="checkbox" value="giaotiep" checked>Giao tiếp</label>
                            </div>
                            <div class="checkbox">
                                <label><input class="filter-type"  type="checkbox" value="aland" checked>Aland</label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <p class="title_filter">by branch  </p>
                    <div>
                        <div class="checkbox">
                            <label><input  id="filter-branch-anchor" type="checkbox" onchange="ClickSelectLabel('branch')" checked > Select All </label>
                        </div>

                        <?php
                        foreach ($location_info as $_mono_location_info){
                            if (isset($_GET['location'])){
                                $location_live = json_decode($_GET['location'],true);
                                if (in_array($_mono_location_info['id'],$location_live)){
                                    $checked = 'checked';
                                }else{
                                    $checked = '';
                                }
                            }else{
                                $checked = 'checked';
                            }
                            ?>
                            <div class="checkbox">
                                <label><input class="filter-branch" type="checkbox" value="<?php echo $_mono_location_info['id']?>" <?php echo $checked; ?> ><?php echo $_mono_location_info['name']?> - Khu vực <?php echo $_mono_location_info['area']?></label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="col col-sm-6 col-md-4">
                    <p class="title_filter">by area</p>
                    <div>
                        <div class="checkbox">
                            <label><input  id="filter-area-anchor" type="checkbox" onchange="ClickSelectLabel('area')" checked > Select All </label>
                        </div>

                        <div class="checkbox">
                            <?php
                            if(isset($_GET['area'])){
                                $area_live = json_decode($_GET['area'],true);
                                if (in_array('Hà Nội',$area_live)){
                                    $checked_area = ' checked ';
                                }else{
                                    $checked_area = '';
                                }
                            }else{
                                $checked_area = 'checked';
                            }
                            ?>
                            <label><input class="filter-area"  type="checkbox" value="Hà Nội" <?php echo $checked_area; ?> >Hà Nội</label>
                        </div>
                        <div class="checkbox">
                            <?php
                            if(isset($_GET['area'])){
                                $area_live = json_decode($_GET['area'],true);
                                if (in_array('Đà Nẵng',$area_live)){
                                    $checked_area = ' checked ';
                                }else{
                                    $checked_area = '';
                                }
                            }else{
                                $checked_area = 'checked';
                            }
                            ?>
                            <label><input class="filter-area"  type="checkbox" value="Đà Nẵng" <?php echo $checked_area; ?>>Đà Nẵng</label>
                        </div>

                        <div class="checkbox">
                            <?php
                            if(isset($_GET['area'])){
                                $area_live = json_decode($_GET['area'],true);
                                if (in_array('Hồ Chí Minh',$area_live)){
                                    $checked_area = ' checked ';
                                }else{
                                    $checked_area = '';
                                }
                            }else{
                                $checked_area = 'checked';
                            }
                            ?>
                            <label><input class="filter-area"  type="checkbox" value="Hồ Chí Minh" <?php echo $checked_area; ?>>Hồ Chí Minh</label>
                        </div>

                        <div class="checkbox">
                            <?php
                            if(isset($_GET['area'])){
                                $area_live = json_decode($_GET['area'],true);
                                if (in_array('Tỉnh thành khác',$area_live)){
                                    $checked_area = ' checked ';
                                }else{
                                    $checked_area = '';
                                }
                            }else{
                                $checked_area = 'checked';
                            }
                            ?>
                            <label><input class="filter-area"  type="checkbox" value="Tỉnh thành khác" <?php echo $checked_area; ?>>Tỉnh thành khác</label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container-fluid" style="margin-top: 20px; ">
    <div class="row">
        <div class="col col-sm-12">
            <table id="dtFeedbackList2" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID</th>
                    <th class="th-sm">Mã lớp - Giáo viên</th>
                    <th class="th-sm">Thời gian</th>
                    <th class="th-sm">Tên</th>
                    <?php if($type_ksgv == 'ksgv2') {?>
                        <th class="th-sm">Tuổi</th>
                    <?php } ?>
                    <?php

                        for ($i = 0; $i < count($list_quest_total); $i++) {
                            $stt = $i +1;
                            echo ' <th class="th-sm">Q'.$stt.'</th>';
                        }

                    ?>

                    <th class="th-sm">Điểm TB</th></th>
                    <?php echo ($del) ? '<th class="th-sm">Action</th>' : ''; ?>
                </tr>
                </thead>
                <tbody>

                <?php
                if (isset($rows) && (is_array($rows))) {
                    foreach ($rows as $row) { ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['class_code'].' - '.$row['teacher_name'] ?></td>
                            <td><?php echo date('d/m/Y - H:i:s', $row['time_end']); ?></td>
                            <td><?php echo $row['name_feeder'] ?></td>
                            <?php if($type_ksgv == 'ksgv2') {?>
                                <td><?php echo $row['age'] ?></td>
                            <?php } ?>

                            <?php
                            $detail = $row['detail'];
                            $detail_live = json_decode($detail,true);
                            $mono__sum = 0;
                            $mono__count = 0;
                            for ($i = 0; $i < count($detail_live); $i++) {
                                if(count($detail_live) > 9) {
                                    // Bỏ câu hỏi số 4 và số 8
                                    if ( ($i == 3) || ($i == 7)){
                                        continue;
                                    }
                                }

                                $mono_detail = $detail_live[$i];
                                $type = $mono_detail[1];
                                if ($type === 'select'){
                                    $mono_point = $mono_detail[3];
                                    if ($mono_point >0){
                                        $mono__sum += $mono_point;
                                        $mono__count ++;
                                    }
                                    echo  '<td><span class="point" >'.$mono_point.'</span></td>';
                                }elseif($type === 'ruler'){
                                    $mono_point = (int)$mono_detail[3]*2;
                                    if ($mono_point >0){
                                        $mono__sum += $mono_point;
                                        $mono__count ++;
                                    }
                                    echo  '<td><span class="point" title="'.$mono_detail[3].'/5">'.$mono_point.'</span></td>';
                                }else{
                                    $content = $mono_detail[3];
                                    echo  '<td>'.$content.'</td>';
                                }
                                // check nếu k có câu trả lời dạng text thì hiển thị cột rỗng tránh lỗi bảng
                                if(count($detail_live) > 9 && $i == 9) {
                                    if($i == 9){
                                        echo  '<td><span class="point" ></span></td>';
                                    }
                                }
                            } ?>
                            <td>
                                <span class="point" >
                                <?php
                                // Điểm TB
                                if ($mono__count > 0){
                                    echo round($mono__sum / $mono__count,2);
                                }else{
                                    echo 0;
                                }
                                ?>
                                </span>
                            </td>
                            <?php echo ($del) ? '<td><button class="btn btn-sm btn-danger" info="'.$row['id'].'" onclick="load_del_feedback_form(event)">Del</button></td>' : ''; ?>
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
            // console.log("value");
            // console.log(value);

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
        $('.dataTables_length').addClass('bs-select');

        // Tô màu điểm

    });


    function clickFilter() {
        var query_string = '';
        var arr_type = [];
        $(".filter-type").each(function () {
            if ($(this).prop('checked')){
                arr_type.push($(this).val());
            }
        });
        var class_code = $('#class_code').val();
        if (class_code !== ''){
            query_string += '&class_code=' + class_code;
        }
        console.log("arr_type");
        console.log(arr_type);
        query_string += '&type=' + JSON.stringify(arr_type);

        var arr_branch = [];
        $(".filter-branch").each(function () {
            if ($(this).prop('checked')){
                arr_branch.push($(this).val());
            }
        });
        var manager_email = $('#manager_email').val();

        if (manager_email !== ''){
            query_string += '&manager_email=' + manager_email;
        }
        console.log("arr_branch");
        console.log(arr_branch);
        query_string += '&location=' + JSON.stringify(arr_branch);

        var arr_area = [];
        $(".filter-area").each(function () {
            if ($(this).prop('checked')){
                arr_area.push($(this).val());
            }
        });
        console.log("arr_area");
        console.log(arr_area);
        query_string += '&area=' + JSON.stringify(arr_area);

        window.location.href = "/feedback/feedback_ksgv_detail?type_ksgv=<?php echo $type_ksgv; ?>" + query_string;

    }

    function clickExport() {
        var query_string = '';
        var arr_type = [];
        var class_code = $('#class_code').val();
        if (class_code !== ''){
            query_string += '&class_code=' + class_code;
        }
        $(".filter-type").each(function () {
            if ($(this).prop('checked')){
                arr_type.push($(this).val());
            }
        });
        console.log("arr_type");
        console.log(arr_type);
        query_string += '&type=' + JSON.stringify(arr_type);

        var arr_branch = [];
        $(".filter-branch").each(function () {
            if ($(this).prop('checked')){
                arr_branch.push($(this).val());
            }
        });
        console.log("arr_branch");
        console.log(arr_branch);
        query_string += '&location=' + JSON.stringify(arr_branch);

        var arr_area = [];
        $(".filter-area").each(function () {
            if ($(this).prop('checked')){
                arr_area.push($(this).val());
            }
        });
        console.log("arr_area");
        console.log(arr_area);
        query_string += '&area=' + JSON.stringify(arr_area);

        var url = "/feedback/export_feedback_ksgv_detail?type_ksgv=<?php echo $type_ksgv; ?>" + query_string;
        var win = window.open(url, '_blank');
        win.focus();

    }


</script>







