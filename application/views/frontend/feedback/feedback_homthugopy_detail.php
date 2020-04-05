<style>
    th{
        text-align: center;
    }
</style>
<h2 class="my_title">
    Hòm thư góp ý
</h2>

<div class="row">
    <div class="col col-md-12">
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
<!--                <div class="col col-sm-6 col-md-3">-->
<!--                    <p class="title_filter">by point</p>-->
<!---->
<!--                    <div class="row">-->
<!--                        <div class="col col-sm-6">-->
<!--                            <div class="form-group">-->
<!--                                <label for="usr">Min</label>-->
<!--                                <input type="number" min="0" max="10" class="form-control" id="min" value="--><?php // if (isset($_GET['min'])) {echo $_GET['min'];} ?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col col-sm-6">-->
<!--                            <div class="form-group">-->
<!--                                <label for="usr">Max</label>-->
<!--                                <input type="number" min="0" max="10"  class="form-control" id="max" value="--><?php // if (isset($_GET['max'])) {echo $_GET['max'];} ?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
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
<!--                <div class="col col-sm-6 col-md-2">-->
<!--                    <p class="title_filter">by teacher </p>-->
<!--                    <div style="    max-height: 500px; overflow: auto;">-->
<!---->
<!--                        <div class="checkbox">-->
<!--                            <label><input  id="filter-teacher-anchor" type="checkbox" onchange="ClickSelectLabel('teacher')" checked > Select All </label>-->
<!--                        </div>-->
<!---->
<!--                        --><?php
//                        foreach ($teacher_info as $item_teacher) {
//
//                            if (isset($_GET['teacher'])){
//                                $teacher_live = json_decode($_GET['teacher'],true);
//                                if ( in_array($item_teacher['teacher_id'], $teacher_live)){
//                                    $checked_teacher = ' checked ';
//                                }else{
//                                    $checked_teacher = '';
//                                }
//                            }else{
//                                $checked_teacher = ' checked ';
//                            }
//
//                            ?>
<!--                            <div class="checkbox">-->
<!--                                <label><input class="filter-teacher" type="checkbox" value="--><?php //echo $item_teacher['teacher_id']; ?><!--" --><?php //echo $checked_teacher; ?><!-- >--><?php //echo $item_teacher['name']; ?><!--</label>-->
<!--                            </div>-->
<!--                            --><?php
//                        }
//                        ?>
<!--                    </div>-->
<!--                </div>-->
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
                    <th class="th-sm">ID                    </th>
                    <th class="th-sm">Mã lớp                   </th>
                    <th class="th-sm">Thời gian                    </th>
                    <th class="th-sm">Tên                    </th>
                    <th class="th-sm">Nội dung góp ý                    </th>
                    </th>
                </tr>
                </thead>
                <tbody>

                <?php
                if (isset($rows) && (is_array($rows))) {
                    foreach ($rows as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['class_code'] ?></td>
                            <td><?php echo date('d/m/Y - H:i:s', $row['time_end']); ?></td>
                            <td><?php echo $row['name_feeder'] ?></td>
                            <td><?php
                                $detail = $row['detail'];
                                $detail_live = json_decode($detail,true);
                                echo $detail_live[0][3];
                                ?></td>
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

        // var min = $('#min').val();
        // var max = $('#max').val();
        //
        // console.log("min");
        // console.log(min);
        // if (min !== ''){
        //     query_string += '&min=' + min;
        // }
        //
        // console.log("max");
        // console.log(max);
        // if (max !== ''){
        //     query_string += '&max=' + max;
        // }

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


        // var arr_teacher = [];

        // $(".filter-teacher").each(function () {
        //     if ($(this).prop('checked')){
        //         arr_teacher.push($(this).val());
        //     }
        // });
        // query_string += '&teacher=' + JSON.stringify(arr_teacher);
        //
        // console.log("arr_teacher");
        // console.log(arr_teacher);

        window.location.href = "/feedback/hom_thu_gop_y_detail?"+ query_string;

    }

    function clickExport() {
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

        // var min = $('#min').val();
        // var max = $('#max').val();
        //
        // console.log("min");
        // console.log(min);
        // if (min !== ''){
        //     query_string += '&min=' + min;
        // }
        //
        // console.log("max");
        // console.log(max);
        // if (max !== ''){
        //     query_string += '&max=' + max;
        // }

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

        var url = "/feedback/export_hom_thu_gop_y_detail?" + query_string;
        var win = window.open(url, '_blank');
        win.focus();

    }


</script>







