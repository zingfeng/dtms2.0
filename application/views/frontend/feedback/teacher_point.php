<div class="modal" id="modal_get_link">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> Link feedback </h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h4>
                    Link feed back của lớp <span id="modal_link_feedback" style="font-weight: bold"></span>
                </h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink()" >Open</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy()">Copy</button>
                    </div>

                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>


<div class="container-fluid area" id="class">
    <div class="row" id="insert_class" style="padding: 15px">

        <h4  class="">Điểm đánh giá giáo viên  </h4>
        <div class="filter">
            <div class="row">
                <form action="/feedback/teacher_point" method="get">
                <div class="col col-sm-3">
                    <div class="form-group">
                        <label for="usr">Từ ngày:</label>
                        <input type="date" class="form-control" name="min_opening" id="min_opening" value="<?php
                        if (isset($_REQUEST['min_opening'])){
                            echo $_REQUEST['min_opening'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="col col-sm-3">
                    <div class="form-group">
                        <label for="usr">Đến ngày :</label>
                        <input type="date" class="form-control" name="max_opening" id="max_opening" value="<?php
                        if (isset($_REQUEST['max_opening'])){
                            echo $_REQUEST['max_opening'];
                        }
                        ?>">
                    </div>
                </div>


                    <div class="col col-sm-1">
                        <div>
                            <label for="usr" style="visibility: hidden">-</label>
                        </div>
                        <button class="btn btn-md btn-danger" type="submit" style="width: 100%"><i class="fa fa-filter"></i> Filter</button>
                </div>
                <div class="col col-sm-1">
                    <div><label for="usr" style="visibility: hidden">-</label></div>
                    <a class="btn btn-md btn-primary" style="width: 100%" target="_blank" href="<?php echo SITE_URL."/feedback/export_teacher_point".(($this->input->get()) ? "?".http_build_query($this->input->get()) : ''); ?>">Export</a>
                    </div>
                </form>
                    <div class="col col-sm-5" style="text-align: right;">
                        <div>
                            <label for="usr">Lọc nhanh</label>
                        </div>
                        <a href="/feedback/teacher_point?min_opening=<?php echo $one_month; ?>&max_opening=<?php echo $today; ?>"><button class="btn btn-sm btn-success">1 tháng</button></a>
                        <a href="/feedback/teacher_point?min_opening=<?php echo $two_month; ?>&max_opening=<?php echo $today; ?>"><button class="btn btn-sm btn-primary">2 tháng</button></a>
                        <a href="/feedback/teacher_point?min_opening=<?php echo $three_month; ?>&max_opening=<?php echo $today; ?>"><button class="btn btn-sm btn-warning">3 tháng</button></a>
                        <a href="/feedback/teacher_point?min_opening=<?php echo $six_month; ?>&max_opening=<?php echo $today; ?>"><button class="btn btn-sm btn-default">6 tháng</button></a>
                        <a href="/feedback/teacher_point?min_opening=<?php echo $one_year; ?>&max_opening=<?php echo $today; ?>"><button class="btn btn-sm btn-primary">1 năm</button></a>
                    </div>

            </div>

        </div>

        <div class="list_in_table container-fluid" id="list_class">
            <table id="dtClassList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID</th>
                    <th class="th-sm">Tên</th>
                    <th class="th-sm">Số lượng lớp</th>
                    <th class="th-sm">Điểm trung bình</th>
                    <th class="th-sm">Chi tiết</th>
                    <th class="th-sm">Xếp loại</th>
                    <th class="th-sm">Action</th>
                </tr>

                </thead>
                <tbody>
                <?php
                foreach ($arr_info_view as $m) { ?>
                    <tr>
                        <td><?php echo $m['teacher_id']; ?></td>
                        <td><?php
                            echo $m['teacher_info'];
                        ?></td>
                        <td><?php echo $m['number_class']; ?></td>
                        <td><?php echo $m['average_point_of_teacher']; ?></td>
                        <td><ul><?php
                            for ($i = 0; $i < count($m['arr_class_code_and_type']); $i++) {
                                $class_info_mono = $m['arr_class_code_and_type'][$i];
                                echo '<a href="feedback/statistic/'.$class_info_mono[0].'" target="_blank" ><li>'.$class_info_mono[0];
                                echo ' ('.$class_info_mono[1].') </li></a>';
                            }
                        ?></ul>
                        </td>
                        <td><?php
                                $xeploai = '';
                                switch (true){
                                    case ($m['average_point_of_teacher'] >=9.5):
                                        $xeploai = 'Xuất sắc';
                                        break;
                                    case ($m['average_point_of_teacher'] >=9):
                                        $xeploai = 'Giỏi';
                                        break;
                                    case ($m['average_point_of_teacher'] >=8.6):
                                        $xeploai = 'Khá';
                                        break;
                                    case ($m['average_point_of_teacher'] >=8):
                                        $xeploai = 'Trung bình';
                                        break;
                                    default:
                                        $xeploai = 'Yếu';
                                        break;
                                }

                                if ($m['average_point_of_teacher'] == 0){
                                    $xeploai = '';
                                }
                                echo $xeploai;
                        ?></td>
<!--                        <td>-->
<!--                            --><?php
//                            // Khu vực
////                                  $list_class_id_to_area
//                                $arr_area = [];
//                                for ($i = 0; $i < count($list_class_id); $i++) {
//                                    $class_id_super_mono = $list_class_id[$i];
//                                    array_push($arr_area,$list_class_id_to_area[$class_id_super_mono]);
//                                }
//                                $arr_area = array_values(array_unique($arr_area));
//                                for ($x = 0; $x < count($arr_area); $x++) {
//                                    if ($x ==0 ){
//                                        echo $arr_area[$x];
//                                    }else{
//                                        echo " | ".$arr_area[$x];
//                                    }
//                                }
//                            ?>
<!---->
<!--                        </td>-->
                        <td style="font-size: x-large; min-width: 250px;">
<!--                            <i info='--><?php //echo json_encode($mono_class_info); ?><!--'  class="fa fa-link" aria-hidden="true" title="Get link feedback" onclick="load_get_link_class(event)"></i>-->
<!--                            <a target="_blank" href="/feedback/statistic/--><?php //echo $mono_class_info['class_code']; ?><!--"> <i class="fa fa-eye" aria-hidden="true" title="Xem báo cáo"></i></a>-->
<!--                            <i info='--><?php //echo json_encode($mono_class_info); ?><!--'  class="fa fa-pencil-square-o" aria-hidden="true" onclick="load_edit_class(event)" title="Chỉnh sửa"></i>-->
<!--                            <i info='--><?php //echo json_encode($mono_class_info); ?><!--'  class="fa fa-trash" aria-hidden="true" title="Xóa" onclick="load_del_class(event)"></i>-->
                        </td>
                    </tr>

                    <?php
                } ?>




                </tbody>
<!--                <tfoot>-->
<!--                <tr>-->
<!--                    <th class="th-sm">ID-->
<!--                    </th>-->
<!--                    <th class="th-sm">Type-->
<!--                    </th>-->
<!--                    <th class="th-sm">Mã lớp-->
<!--                    </th>-->
<!--                    <th class="th-sm">Giáo viên-->
<!--                    </th>-->
<!--                    <th class="th-sm">Nhận feed từ ngày-->
<!--                    </th>-->
<!--                    <th class="th-sm">Nhận feedback đến ngày-->
<!--                    </th>-->
<!--                    <th class="th-sm">Thông tin khác-->
<!--                    </th>-->
<!--                    <th class="th-sm">Số lượng Feedback-->
<!--                    </th>-->
<!--                    <th class="th-sm">Action-->
<!--                    </th>-->
<!--                </tr>-->
<!--                </tfoot>-->
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dtClassList').DataTable({
            // "ordering": true // false to disable sorting (or any other option)
            "pageLength": 50,
        });
        $('.dataTables_length').addClass('bs-select');
    });

    function ClickSelect(type_select) {
        var checked = $('#filter-teacher-anchor').attr('select');
        if (checked === 'true'){
            $('#filter-teacher-anchor').attr('select','false');
            checked = false;
        }else{
            $('#filter-teacher-anchor').attr('select','true');
            checked = true;
        }

        $('.filter-' + type_select).each(function () {
            $(this).prop('checked',checked);
        });

    }

    function ClickSelectLabel(type_select) {
        var checked = $('#filter-' + type_select + '-anchor').prop('checked');
        $('.filter-' + type_select).each(function () {
            $(this).prop('checked',checked);
        });
    }

    function clickFilter() {
        var query_string = '';
        var arr_type = [];
        $(".filter-type").each(function () {
            if ($(this).prop('checked')){
                arr_type.push($(this).val());
            }
        });
        console.log("arr_type");
        console.log(arr_type);
        query_string += '&type=' + JSON.stringify(arr_type);

        var min = $('#min').val();
        var max = $('#max').val();

        console.log("min");
        console.log(min);
        if (min !== ''){
            query_string += '&min=' + min;
        }

        console.log("max");
        console.log(max);
        if (max !== ''){
            query_string += '&max=' + max;
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


        var arr_teacher = [];

        $(".filter-teacher").each(function () {
            if ($(this).prop('checked')){
                arr_teacher.push($(this).val());
            }
        });
        query_string += '&teacher=' + JSON.stringify(arr_teacher);

        console.log("arr_teacher");
        console.log(arr_teacher);

        window.location.href = "/feedback/class_?" + query_string;



    }
</script>