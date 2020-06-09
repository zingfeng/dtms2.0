<h2 class="my_title">
    Feedback
    <?php if($fb_type == 'phone') {
        echo 'Phone';
    } else {
        if($type_ksgv == 'dao_tao_onl') {
            echo 'online giữa kỳ';
        } else {
            echo 'online cuối kỳ';
        }
    }?>
    By Class</h2>

<div class="filter_div">
    <div class="hover-point" onclick="$('#body_filter').toggle();">
        <h4 class="text-primary" style="display: inline-block">Filter</h4>
        <button class="btn btn-primary btn-sm" style="float: right;padding-left: 120px; padding-right: 120px;" onclick="clickFilter('filter')" data-url="filter"><i class="fa fa-filter"></i> Filter</button>
        <a href="/log/list_feedback_group_by_class?fb_type=<?php echo ($fb_type) ? $fb_type : 'ksgv'; echo ($type_ksgv) ? '&type_ksgv='.$type_ksgv : ''?>"><button class="btn btn-danger btn-sm" style="float: right;padding-left: 20px; padding-right: 20px; margin-right: 20px;"><i class="fa fa-filter"></i> X Filter</button></a>
        <button class="btn btn-success btn-sm" style="float: right;padding-left: 20px; padding-right: 20px; margin-right: 20px;" title="Export File" onclick="clickFilter('export')">Export</button>
    </div>
    <div class="row" id="body_filter" style="display: none">
        <form action="/log/list_feedback_group_by_class" method="get">
            <input type="hidden" name="fb_type" id="fb_type" value="<?php echo ($fb_type) ? $fb_type : 'ksgv'?>">
            <input type="hidden" name="type_ksgv" id="type_ksgv" value="<?php echo ($type_ksgv) ? $type_ksgv : 'phone'?>">
            <div class="col col-sm-1">
                <div class="form-group">
                    <label>Mã lớp :</label>
                    <input type="input" class="form-control" name="class" id="class" value="<?php
                    if (isset($_REQUEST['class'])){
                        echo $_REQUEST['class'];
                    }
                    ?>">
                </div>
            </div>
            <div class="col col-sm-2">
                <div class="form-group">
                    <label>Tên giáo viên :</label>
                    <input type="input" class="form-control" name="teacher_name" id="teacher_name" value="<?php
                    if (isset($_REQUEST['teacher_name'])){
                        echo $_REQUEST['teacher_name'];
                    }
                    ?>">
                </div>
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
            <div class="col col-sm-2">
                <div class="form-group">
                    <label>Từ ngày:</label>
                    <input type="date" class="form-control" name="starttime" id="starttime" value="<?php
                    if (isset($_REQUEST['starttime'])){
                        echo $_REQUEST['starttime'];
                    }
                    ?>">
                </div>
            </div>
            <div class="col col-sm-2">
                <div class="form-group">
                    <label>Đến ngày :</label>
                    <input type="date" class="form-control" name="endtime" id="endtime" value="<?php
                    if (isset($_REQUEST['endtime'])){
                        echo $_REQUEST['endtime'];
                    }
                    ?>">
                </div>
            </div>
            <div class="col col-sm-3">
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

            <div class="col col-sm-2">
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
        </form>
    </div>
</div>

<div class="container-fluid" style="margin-top: 20px; ">
    <div class="row">
        <div class="col col-sm-12">
            <table id="dtFeedbackList2" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID</th>
                    <th class="th-sm">Type</th>
                    <th class="th-sm">Mã lớp - Giáo viên</th>
                    <th class="th-sm">Ngày khai giảng</th>
                    <th class="th-sm">Cơ sở</th>
                    <th class="th-sm">Số lượng feedback</th>
                    <th class="th-sm">Action</th>
                </tr>
                </thead>
                <tbody>

                <?php
                if (isset($rows) && (is_array($rows))) {
                    foreach ($rows as $row) { ?>
                        <tr>
                            <td><?php echo $row['class_id'] ?></td>
                            <td>
                                <?php
                                switch ($row['type']) {
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

                                ?>
                            </td>
                            <td>
                                <?php if($arr_total[$row['class_id']]['number_fb'] > 0) {?>
                                    <?php if($fb_type == 'phone') {?>
                                        <a rel="nofollow" href="<?php echo SITE_URL.'/feedback/feedback_phone_detail?class='.$row['class_code']; ?>" title="Xem chi tiết lớp"><?php echo $row['class_code'].' - '.$arr_teacher[$row['main_teacher']]['name']; ?></a>
                                    <?php } else {?>
                                        <a rel="nofollow" href="<?php echo SITE_URL.'/feedback/feedback_ksgv_detail?type_ksgv='.$type_ksgv.'&class_code='.$row['class_code']; ?>" title="Xem chi tiết lớp"><?php echo $row['class_code'].' - '.$arr_teacher[$row['main_teacher']]['name']; ?></a>
                                    <?php }?>
                                <?php } else {?>
                                    <?php echo $row['class_code'].' - '.$arr_teacher[$row['main_teacher']]['name']; ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php $mono_open_day_Y_m_d = $row['opening_day'];
                                if ($mono_open_day_Y_m_d != ''){
                                    echo substr($mono_open_day_Y_m_d,8,2).'/'.substr($mono_open_day_Y_m_d,5,2).'/'.substr($mono_open_day_Y_m_d,0,4);
                                } ?>
                            </td>
                            <td><?php echo $arrLocation[$row['id_location']]['name'].' - '.$arrLocation[$row['id_location']]['area'] ?></td>
                            <td><?php echo $arr_total[$row['class_id']]['number_fb'] ?></td>
                            <td>
                                <?php if($arr_total[$row['class_id']]['number_fb'] > 0) {?>
                                    <?php if($fb_type == 'phone') {?>
                                        <a rel="nofollow" href="<?php echo SITE_URL.'/feedback/feedback_phone_detail?class='.$row['class_code']; ?>"> <i class="fa fa-eye" aria-hidden="true" title="Xem chi tiết lớp"></i></a>
                                    <?php } else {?>
                                        <a rel="nofollow" href="<?php echo SITE_URL.'/feedback/feedback_ksgv_detail?type_ksgv='.$type_ksgv.'&class_code='.$row['class_code']; ?>" title="Xem chi tiết lớp"> <i class="fa fa-eye" aria-hidden="true" title="Xem chi tiết lớp"></i></a>
                                    <?php }?>
                                <?php } ?>
                            </td>
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
        $('#dtFeedbackList').DataTable({
            "pageLength": 50,
            "ordering": false // false to disable sorting (or any other option)
        });
        $('#dtFeedbackList2').DataTable({
            "pageLength": 50,
            "ordering": false // false to disable sorting (or any other option)
        });
        $('.dataTables_length').addClass('bs-select');

    });
    function ClickSelectLabel(type_select) {
        var checked = $('#filter-' + type_select + '-anchor').prop('checked');
        $('.filter-' + type_select).each(function () {
            $(this).prop('checked',checked);
        });
    }
    function clickFilter(type) {
        var query_string = '';
        var class_code = $('#class').val();

        if (class_code !== ''){
            query_string += '&class=' + class_code;
        }

        var starttime = $('#starttime').val();
        var endtime = $('#endtime').val();
        if (starttime !== ''){
            query_string += '&starttime=' + starttime;
        }
        if (endtime !== ''){
            query_string += '&endtime=' + endtime;
        }

        var manager_email = $('#manager_email').val();

        if (manager_email !== ''){
            query_string += '&manager_email=' + manager_email;
        }

        var fb_type = $('#fb_type').val();

        if (fb_type !== ''){
            query_string += '&fb_type=' + fb_type;
        }

        var type_ksgv = $('#type_ksgv').val();

        if (type_ksgv !== ''){
            query_string += '&type_ksgv=' + type_ksgv;
        }

        var teacher = $('#teacher_name').val();

        if (teacher !== ''){
            query_string += '&teacher_name=' + teacher;
        }

        var arr_branch = [];
        $(".filter-branch").each(function () {
            if ($(this).prop('checked')){
                arr_branch.push($(this).val());
            }
        });

        query_string += '&location=' + JSON.stringify(arr_branch);

        var arr_area = [];
        $(".filter-area").each(function () {
            if ($(this).prop('checked')){
                arr_area.push($(this).val());
            }
        });

        query_string += '&area=' + JSON.stringify(arr_area);
        if(type == 'export'){
            window.location.href = "/log/export_list_feedback_group_by_class?" + query_string;
        }else {
            window.location.href = "/log/list_feedback_group_by_class?" + query_string;
        }
    }
</script>



