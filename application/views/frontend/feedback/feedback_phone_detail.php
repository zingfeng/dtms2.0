<h2 class="my_title">Feedback Phone Detail
    <button class="btn btn-success" title="Export File" onclick="clickFilter('export')" data-url="export"><i class="fa fa-file-excel-o"></i> Export</button>
</h2>

<div class="filter_div">
    <div class="hover-point" onclick="$('#body_filter').toggle();">
        <h4 class="text-primary" style="display: inline-block">Filter</h4>
        <button class="btn btn-primary btn-sm" style="float: right;padding-left: 120px; padding-right: 120px;" onclick="clickFilter('filter')" data-url="filter"><i class="fa fa-filter"></i> Filter</button>
        <a href="/feedback/feedback_phone_detail"><button class="btn btn-danger btn-sm" style="float: right;padding-left: 20px; padding-right: 20px; margin-right: 20px;"><i class="fa fa-filter"></i> X Filter</button></a>
    </div>

    <div class="row" id="body_filter" style="display: none">
        <form action="/feedback/feedback_phone_detail" method="get">
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


    <!--            $_REQUEST['min_opening']-->
</div>

<div class="container-fluid" style="margin-top: 20px; ">
    <div class="row">
        <div class="col col-sm-12">
            <table id="dtFeedbackList2" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID</th>
                    <th class="th-sm">Thời gian</th>
                    <th class="th-sm">Mã lớp</th>
                    <th class="th-sm">Giáo viên</th>
                    <th class="th-sm" title="Tên người phản hồi">Học viên</th>
                    <th class="th-sm">Điểm</th>
                    <th class="th-sm">Nhận xét</th>
                    <?php echo ($del) ? '<th class="th-sm">Action</th>' : ''; ?>
                </tr>
                </thead>
                <tbody>

                <?php
                if (isset($rows) && (is_array($rows))) {
                    foreach ($rows as $row) { ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo date('d/m/Y - H:i:s', $row['time']); ?></td>
                            <td><?php echo $row['class_code'] ?></td>
                            <td><?php echo $row['name'] ?></td>

                            <td><?php echo $row['name_feeder'] ?></td>
                            <td><?php echo $row['point'] ?></td>
                            <td><?php echo $row['comment'] ?></td>
                            <?php echo ($del) ? '<td><button class="btn btn-sm btn-danger" info="'.$row['id'].'" onclick="load_del_feedback_phone(event)">Del</button></td>' : ''; ?>
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
        $('.dataTables_length').addClass('bs-select');

        // Tô màu điểm

    });
    function ClickSelectLabel(type_select) {
        var checked = $('#filter-' + type_select + '-anchor').prop('checked');
        $('.filter-' + type_select).each(function () {
            $(this).prop('checked',checked);
        });
    }
    function clickFilter(type) {
        var query_string = '';

        var starttime = $('#starttime').val();
        var endtime = $('#endtime').val();

        console.log("starttime");
        console.log(starttime);
        if (starttime !== ''){
            query_string += '&starttime=' + starttime;
        }

        console.log("endtime");
        console.log(endtime);
        if (endtime !== ''){
            query_string += '&endtime=' + endtime;
        }

        var class_code = $('#class').val();

        console.log("class_code");
        console.log(class_code);
        if (class_code !== ''){
            query_string += '&class=' + class_code;
        }

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

        console.log(query_string);
        if(type == 'export'){
            window.location.href = "/feedback/export_list_feedback_phone_detail?" + query_string;
        }else {
            window.location.href = "/feedback/feedback_phone_detail?" + query_string;
        }
    }
</script>



