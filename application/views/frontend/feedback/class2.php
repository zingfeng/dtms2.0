<?php
//var_dump($class_info);
//var_dump($teacher_info);
?>

<div class="modal" id="modal_get_link">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> Link feedback lớp <span id="modal_link_feedback" style="font-weight: bold"></span></h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h4>
                    Link Feedback Form khảo sát lớp lần 1
                </h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback_lan1">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">

                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink__('link_feedback_lan1')" >Xem mẫu</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy__('link_feedback_lan1')">Copy</button>
                    </div>

                </div>



                <h4>
                    Link Feedback Form khảo sát lớp lần 2
                </h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback_lan2">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink__('link_feedback_lan2')" >Xem mẫu</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy__('link_feedback_lan2')">Copy</button>
                    </div>

                </div>

                <h4>
                    Link hòm thư góp ý
                </h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback_homthugopy">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink__('link_feedback_homthugopy')" >Xem mẫu</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy__('link_feedback_homthugopy')">Copy</button>
                    </div>

                </div>
                <h4>
                    Link Feedback đào tạo online
                </h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback_online">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink__('link_feedback_online')" >Xem mẫu</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy__('link_feedback_online')">Copy</button>
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

        <h4  class="">Quản trị danh sách lớp học </h4>

        <div class="menu" id="menu_teacher">
            <button id="add_feedback_class" type="button" data-toggle="modal" data-target="#insert_class_modal" style="border-radius: 0" class="btn btn-primary">
                <i class="fa fa-plus" aria-hidden="true"></i> Thêm lớp học
            </button>

            <br>
        </div>

        <div class="filter_div">
            <div class="hover-point" onclick="$('#body_filter').toggle();">
                <h4 class="text-primary" style="display: inline-block">Filter</h4>
                <button class="btn btn-primary btn-sm" style="float: right;padding-left: 120px; padding-right: 120px;" onclick="clickFilter()"><i class="fa fa-filter"></i> Filter</button>
                <a href="/feedback/class_"><button class="btn btn-danger btn-sm" style="float: right;padding-left: 20px; padding-right: 20px; margin-right: 20px;" onclick="clickFilter()"><i class="fa fa-filter"></i> X Filter</button></a>
            </div>
            
           

            <div class="row" id="body_filter" style="<?php
            if ( (isset($_GET['type'])) || (isset($_GET['min'])) || (isset($_GET['max'])) || (isset($_GET['location'])) || (isset($_GET['area'])) || (isset($_GET['teacher']))  ){

            }else{
                echo ' display:none; ';
            }
            ?>" >

                <div class="col col-sm-6 col-md-2">
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
                <div class="col col-sm-6 col-md-3">
                    <p class="title_filter">by point</p>

                    <div class="row">
                        <div class="col col-sm-6">
                            <div class="form-group">
                                <label for="usr">Min</label>
                                <input type="number" min="0" max="10" class="form-control" id="min" value="<?php  if (isset($_GET['min'])) {echo $_GET['min'];} ?>">
                            </div>
                        </div>
                        <div class="col col-sm-6">
                            <div class="form-group">
                                <label for="usr">Max</label>
                                <input type="number" min="0" max="10"  class="form-control" id="max" value="<?php  if (isset($_GET['max'])) {echo $_GET['max'];} ?>">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col col-sm-6 col-md-3">
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

                <div class="col col-sm-6 col-md-2">
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
                <div class="col col-sm-6 col-md-2">
                    <p class="title_filter">by teacher </p>
                    <div style="    max-height: 500px; overflow: auto;">

                        <div class="checkbox">
                            <label><input  id="filter-teacher-anchor" type="checkbox" onchange="ClickSelectLabel('teacher')" checked > Select All </label>
                        </div>

                        <?php
                        foreach ($teacher_info as $item_teacher) {

                            if (isset($_GET['teacher'])){
                                $teacher_live = json_decode($_GET['teacher'],true);
                                if ( in_array($item_teacher['teacher_id'], $teacher_live)){
                                    $checked_teacher = ' checked ';
                                }else{
                                    $checked_teacher = '';
                                }
                            }else{
                                $checked_teacher = ' checked ';
                            }

                                ?>
                            <div class="checkbox">
                                <label><input class="filter-teacher" type="checkbox" value="<?php echo $item_teacher['teacher_id']; ?>" <?php echo $checked_teacher; ?> ><?php echo $item_teacher['name']; ?></label>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="insert_class_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Class</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="sel1">Type</label>
                                    <select class="form-control" id="class_type"  caption_get="value" caption_instruction="value or text" >
                                        <option value="ielts" >Ielts Fighter</option>
                                        <option value="giaotiep" >Giao tiếp</option>
                                        <option value="toeic" >Toeic</option>
                                        <option value="aland" >Aland</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="usr">Mã lớp</label>
                                    <input type="text" class="form-control" id="class_code">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="usr">Ngày khai giảng</label>
                                    <input type="date" class="form-control" id="class_opening_date">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="usr">Nhận feedback từ ngày</label>
                                    <input class="form-control" id="class_from_date" type="datetime-local" value="2000-01-01T00:00:00" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="usr">đến ngày</label>
                                    <input class="form-control" id="class_to_date" type="datetime-local" value="2030-01-01T00:00:00" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="location">Cơ sở </label>
                                <select class="form-control" id="location_class">
                                    <?php
                                        $location_access = array();
                                        foreach ($location_info as $mono_location_info){
                                            $location_access[$mono_location_info['id']] =  $mono_location_info['name'] .' - Khu vực '.$mono_location_info['area'];
                                            ?>
                                            <option value="<?php echo $mono_location_info['id'];?>"><?php echo $mono_location_info['name'];?> - Khu vực <?php echo $mono_location_info['area'];?></option>
                                        <?php }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment">Thông tin thêm</label>
                            <textarea class="form-control" rows="3" id="class_more_info"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="usr">Danh sách giảng viên</label>

                            <select class="js-example-basic-multiple select2_input" id="class_teacher" name="states[]" multiple="multiple">
                                <?php
                                    foreach ($teacher_info as $mono_teacher){ ?>
                                        <option value="<?php echo $mono_teacher['teacher_id'] ?>"><?php echo $mono_teacher['name'] ?></option>
                                    <?php }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="btn_ok_class" class="btn btn-primary" status="insert" onclick="click_ok_class()">OK</button>
                    </div>
                </div>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--            class_id	type	class_code	list_teacher	more_info	time_start	time_end  -->

        <style>
            th{
                vertical-align: middle;
                text-align: center;
            }

        </style>
        <div class="list_in_table container-fluid" id="list_class">
            <table id="dtClassList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm" rowspan="2">ID</th>
                    <th class="th-sm" rowspan="2">Type</th>
                    <th class="th-sm" rowspan="2">Mã lớp</th>
                    <th class="th-sm" rowspan="2">Giáo viên</th>
                    <th class="th-sm" rowspan="2">Ngày khai giảng</th>
                    <th class="th-sm" rowspan="2" style="max-width: 300px;">Cơ sở</th>
                    <th class="th-sm" colspan="2">Feedback Form mẫu 1</th>
                    <th class="th-sm" colspan="2">Feedback Form mẫu 2</th>
<!--                    <th class="th-sm" colspan="2">Feedback Phone</th>-->
                    <th class="th-sm" colspan="2">Feedback Phone 1</th>
                    <th class="th-sm" colspan="2">Feedback Phone 2</th>
                    <th class="th-sm" colspan="2">Feedback Phone 3</th>
                    <th class="th-sm" colspan="2">Feedback Phone 4</th>
                    <th class="th-sm" colspan="2">Feedback Online</th>
                    <th class="th-sm" rowspan="2">Điểm TB</th>
                    <th class="th-sm" rowspan="2">Nội dung hòm thư</th>

                    <th class="th-sm" rowspan="2">Action
                    </th>

                </tr>
                <tr>



                    <th class="th-sm">Số lượng
                    </th>
                    <th class="th-sm">Điểm
                    </th>
                    <th class="th-sm">Số lượng
                    </th>
                    <th class="th-sm">Điểm
                    </th>
<!--                    <th class="th-sm">Số lượng</th>-->
<!--                    <th class="th-sm">Điểm </th>-->
                    <th class="th-sm">Số lượng</th>
                    <th class="th-sm">Điểm </th>
                    <th class="th-sm">Số lượng</th>
                    <th class="th-sm">Điểm </th>
                    <th class="th-sm">Số lượng</th>
                    <th class="th-sm">Điểm </th>
                    <th class="th-sm">Số lượng</th>
                    <th class="th-sm">Điểm </th>
                    <th class="th-sm">Số lượng</th>
                    <th class="th-sm">Điểm </th>

                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($class_info as $mono_class_info) { ?>
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
                                for ($i = 0; $i < count($list_teacher_id); $i++) { ?>
                                    <li><?php echo $teacher_id_to_name[$list_teacher_id[$i]]; ?></li>
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

                        <!--                        <td>--><?php //echo date('H:i:s - d/m/Y', $mono_class_info['time_start']); ?><!--</td>-->
<!--                        <td>--><?php //echo date('H:i:s - d/m/Y', $mono_class_info['time_end']); ?><!--</td>-->
                        <td style="max-width: 300px;"><?php echo $location_access[$mono_class_info['id_location']]; ?></td>
<!--                        <td>--><?php //echo $mono_class_info['more_info']; ?><!--</td>-->
                        <td><?php echo $mono_class_info['number_feedback_ksgv1']; ?></td>
                        <td><?php echo $mono_class_info['point_ksgv1']; ?></td>
                        <td><?php echo $mono_class_info['number_feedback_ksgv2']; ?></td>
                        <td><?php echo $mono_class_info['point_ksgv2']; ?></td>
<!--                        <td>--><?php //echo $mono_class_info['number_feedback_phone']; ?><!--</td>-->
<!--                        <td>--><?php //echo $mono_class_info['point_phone']; ?><!--</td>-->
                        <td><?php echo $mono_class_info['number_feedback_phone_1']; ?></td>
                        <td><?php echo $mono_class_info['point_phone1']; ?></td>
                        <td><?php echo $mono_class_info['number_feedback_phone_2']; ?></td>
                        <td><?php echo $mono_class_info['point_phone2']; ?></td>
                        <td><?php echo $mono_class_info['number_feedback_phone_3']; ?></td>
                        <td><?php echo $mono_class_info['point_phone3']; ?></td>
                        <td><?php echo $mono_class_info['number_feedback_phone_4']; ?></td>
                        <td><?php echo $mono_class_info['point_phone4']; ?></td>
                        <td><?php echo $mono_class_info['number_feedback_online']; ?></td>
                        <td><?php echo $mono_class_info['point_online']; ?></td>
                        <td><?php echo $mono_class_info['average_point']; ?></td>
                        <td><a href="//dtms.aland.edu.vn/feedback/hom_thu_gop_y_detail" target="_blank"><?php echo $mono_class_info['number_feedback_homthugopy']; ?></a></td>

                        <td style="font-size: x-large; min-width: 250px;">
                            <i info='<?php echo json_encode($mono_class_info); ?>'  class="fa fa-link" aria-hidden="true" title="Link Feedback Form" onclick="load_get_link_class2(event)"></i>
                            <a href="/feedback/phone?class_code=<?php echo $mono_class_info['class_code']; ?>" target="_blank" ><i class="fa fa-phone" aria-hidden="true" title="Nhập phản hồi điện thoại" ></i></a>
                            <a target="_blank" href="/feedback/statistic/<?php echo $mono_class_info['class_code']; ?>"> <i class="fa fa-eye" aria-hidden="true" title="Xem báo cáo"></i></a>
                            <i info='<?php echo json_encode($mono_class_info); ?>'  class="fa fa-pencil-square-o" aria-hidden="true" onclick="load_edit_class(event)" title="Chỉnh sửa"></i>
                            <i info='<?php echo json_encode($mono_class_info); ?>'  class="fa fa-bell" aria-hidden="true" onclick="ringthebell(event)" title="Gửi báo cáo"></i>
                            <i info='<?php echo $mono_class_info['class_code']; ?>'  class="fa fa-calculator" aria-hidden="true" onclick="calculator(event)" title="Tính lại điểm"></i>
                            <i info='<?php echo json_encode($mono_class_info); ?>'  class="fa fa-trash" aria-hidden="true" title="Xóa" onclick="load_del_class(event)"></i>
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
            "pageLength": 50,
            "ordering": false // false to disable sorting (or any other option)
        });
        $('.dataTables_length').addClass('bs-select');

        $([document.documentElement, document.body]).animate({
            scrollTop: $("#dtClassList_wrapper").offset().top
        }, 500);
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



    function ClickOpenLink__(id_target) {
        var link = $('#' + id_target).val();
        openInNewTab(link);
    }
    function ClickCopy__(id_target) {
        var link = $('#' + id_target).val();
        captain.copyToClipboard(link);
        $('#' + id_target).select();
    }

    function load_get_link_class2(event) {

        var obj = event.target;
        var info = obj.getAttribute('info');
        var info_live = JSON.parse(info);
        console.log("info_live");
        console.log(info_live);

        $("#class_from_date_get_link").val(info_live.time_start_client);
        $("#class_to_date_get_link").val(info_live.time_end_client);



        var link_feedback_ksgv1 = 'https://dtms.aland.edu.vn/feedback/ksgv_lan1?my_class=' + info_live.class_code;
        var link_feedback_ksgv2 = 'https://dtms.aland.edu.vn/feedback/ksgv_lan2?my_class=' + info_live.class_code;
        var link_feedback_homthugopy = 'https://dtms.aland.edu.vn/feedback/hom_thu_gop_y?type=' + info_live.type +'&my_class='+ info_live.class_code;
        var link_feedback_online = 'https://dtms.aland.edu.vn/feedback/dao_tao_online?type=' + info_live.type +'&my_class='+ info_live.class_code;

        $('#modal_link_feedback').html(info_live.class_code);
        $('#modal_link_feedback').attr('class_id',info_live.class_id);
        $('#modal_link_feedback_2').html(info_live.class_code);

        $('#link_feedback_lan1').val(link_feedback_ksgv1);
        $('#link_feedback_lan2').val(link_feedback_ksgv2);

        $('#link_feedback_homthugopy').val(link_feedback_homthugopy);

        $('#link_feedback_online').val(link_feedback_online);

        $('#modal_get_link').modal('show');

        $('#link_feedback_lan1').select();

        captain.copyToClipboard(link_feedback_ksgv1);
        // alert('Link feedback: ' + link_feedback + '\nĐã copy vào Clipboard !');

    }


</script>