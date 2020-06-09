<div class="modal" id="modal_get_link">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> Lấy link feedback của lớp <span id="modal_link_feedback" style="font-weight: bold"></span></h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div style="border-left: 2px solid green; padding-left: 8px;">
                    <h5 style="font-style: italic">
                        Thay đổi thời gian nhận Feedback Form của lớp <span id="modal_link_feedback_2" style="font-weight: bold"></span>
                    </h5>
                    <div class="row" id="box_edit_date">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="usr">Từ ngày</label>
                                <input class="form-control" id="class_from_date_get_link" type="datetime-local" value="2000-01-01T00:00:00" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="usr">đến ngày</label>
                                <input class="form-control" id="class_to_date_get_link" type="datetime-local" value="2030-01-01T00:00:00" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="usr">Sĩ số lớp</label>
                                <input class="form-control" id="number_student_get_link" type="number" value="0" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-warning" id="btn_save_change_date" onclick="SaveFromDateToDateLink()" >Save</button>
                        </div>
                    </div>
                </div>
                <hr>

                <h4>Link Feedback Form khảo sát online giữa kỳ</h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback_online">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink__('link_feedback_online')" >Xem mẫu</button>
                    </div>
                    <div class="col col-sm-12 col-md-2" style="text-align: right">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy__('link_feedback_online')">Copy</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" onclick="get_qrcode('link_feedback_online')">QR Code</button>
                    </div>
                </div>
                <h4>Link Feedback Form khảo sát offline giữa kỳ</h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback_offline">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink__('link_feedback_offline')" >Xem mẫu</button>
                    </div>
                    <div class="col col-sm-12 col-md-2" style="text-align: right">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy__('link_feedback_offline')">Copy</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" onclick="get_qrcode('link_feedback_offline')">QR Code</button>
                    </div>
                </div>
                <h4>Link Feedback Form khảo sát cuối kỳ</h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback_lan2">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink__('link_feedback_lan2')" >Xem mẫu</button>
                    </div>
                    <div class="col col-sm-12 col-md-2" style="text-align: right">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy__('link_feedback_lan2')">Copy</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" onclick="get_qrcode('link_feedback_lan2')">QR Code</button>
                    </div>
                </div>
                <h4>Link hòm thư góp ý</h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback_homthugopy">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink__('link_feedback_homthugopy')" >Xem mẫu</button>
                    </div>
                    <div class="col col-sm-12 col-md-2" style="text-align: right">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy__('link_feedback_homthugopy')">Copy</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" onclick="get_qrcode('link_feedback_homthugopy')">QR Code</button>
                    </div>
                </div>
                <h4>Link đăng ký lớp luyện đề</h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback_luyende">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink__('link_feedback_luyende')" >Xem mẫu</button>
                    </div>
                    <div class="col col-sm-12 col-md-2" style="text-align: right">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy__('link_feedback_luyende')">Copy</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" onclick="get_qrcode('link_feedback_luyende')">QR Code</button>
                    </div>
                </div>
                <h4>Link đăng ký thi cuối kỳ</h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_thicuoiky">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink__('link_thicuoiky')" >Xem mẫu</button>
                    </div>
                    <div class="col col-sm-12 col-md-2" style="text-align: right">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy__('link_thicuoiky')">Copy</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" onclick="get_qrcode('link_thicuoiky')">QR Code</button>
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
        <h4  class="">Danh sách lớp học tại cơ sở <?php
            foreach ($location_info as $mono_location_info){
                if ($_SESSION['id_location'] == $mono_location_info['id']){
                    echo $mono_location_info['name'].' - Khu vực '.$mono_location_info['area'];
                }
            }
            ?>
        </h4>
        <h3><a style="font-weight: bold; color: firebrick" href="https://qlcl.imap.edu.vn/uploads/files/FeedbackIMAP.pdf" target="_blank">Hướng dẫn sử dụng cho người mới bắt đầu</a></h3>
        <div class="menu" id="menu_teacher">
            <button type="button" data-toggle="modal" data-target="#insert_class_modal" style="border-radius: 0" class="btn btn-primary">
                <i class="fa fa-plus" aria-hidden="true"></i> Thêm lớp học
            </button>
            <br>
            <br>
        </div>
        <div class="filter_div">
            <div class="hover-point" onclick="$('#body_filter').toggle();">
                <h4 class="text-primary" style="display: inline-block">Filter - Lọc</h4>
                <button class="btn btn-primary btn-sm" style="float: right;padding-left: 120px; padding-right: 120px;" onclick="clickFilter()"><i class="fa fa-filter"></i> Filter</button>
                <a href="/feedback/class_tuvan"><button class="btn btn-danger btn-sm" style="float: right;padding-left: 20px; padding-right: 20px; margin-right: 20px;" onclick="clickFilter()"><i class="fa fa-filter"></i> Clear Filter</button></a>
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
                <div class="col col-sm-6 col-md-7">
                    <p class="title_filter">by teacher </p>
                    <div style="    max-height: 500px; overflow: auto;">
                        <div class="checkbox">
                            <label><input  id="filter-teacher-anchor" type="checkbox" onchange="ClickSelectLabel('teacher')" checked > Select All </label>
                        </div>
                        <?php foreach ($teacher_info as $item_teacher) {
                            if (isset($_GET['teacher'])){
                                $teacher_live = json_decode($_GET['teacher'],true);
                                if ( in_array($item_teacher['teacher_id'], $teacher_live)){
                                    $checked_teacher = ' checked ';
                                }else{
                                    $checked_teacher = '';
                                }
                            }else{
                                $checked_teacher = ' checked ';
                            } ?>
                            <div class="checkbox">
                                <label><input class="filter-teacher" type="checkbox" value="<?php echo $item_teacher['teacher_id']; ?>" <?php echo $checked_teacher; ?> ><?php echo $item_teacher['name']; ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ringthebelltype">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Ring The Bell <b><span id="modal-bell-title" data-query-class_id=""></span></b></h4>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <div class="row">
                            <div class="col-sm-3">
                                <button class="btn btn-blue-grey" data-query-type="phone" onclick="ringthebelltype(event)">Phone</button>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-blue-grey" data-query-type="dao_tao_online" onclick="ringthebelltype(event)">Giữa kỳ</button>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-blue-grey" data-query-type="ksgv_lan2" onclick="ringthebelltype(event)">Cuối kỳ</button>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-blue-grey" data-query-type="all" onclick="ringthebelltype(event)">Tổng hợp</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="insert_class_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Class</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">
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
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="usr">Mã lớp</label>
                                    <input type="text" class="form-control" id="class_code">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <input type="text" class="form-control" id="level">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="usr">Ngày khai giảng</label>
                                    <input type="date" class="form-control" id="class_opening_date">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="border-top: 1px solid rgba(128, 128, 128, 0.3); border-bottom: 1px solid rgba(128, 128, 128, 0.3);; padding-top: 8px; padding-bottom: 8px; margin-bottom: 5px;">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="usr">Nhận Feedback Form từ ngày</label>
                                    <input class="form-control" id="class_from_date" type="datetime-local" value="2000-01-01T00:00:00" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="usr">Đến ngày</label>
                                    <input class="form-control" id="class_to_date" type="datetime-local" value="2030-01-01T00:00:00" />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <p style="font-style: italic; font-size: smaller">Lưu ý: Việc nhập Feedback Phone không bị giới hạn thời gian, khung thời gian trên chỉ áp dụng cho Feedback Form</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="location">Cơ sở </label>
                                <select class="form-control" id="location_class" disabled>
                                    <?php
                                        $location_access = array();
                                        foreach ($location_info as $mono_location_info){
                                            $location_access[$mono_location_info['id']] =  $mono_location_info['name'] .' - Khu vực '.$mono_location_info['area'];
                                            ?>
                                            <option <?php if ($_SESSION['id_location'] == $mono_location_info['id']){echo 'selected="selected"';} ?> value="<?php echo $mono_location_info['id'];?>"><?php echo $mono_location_info['name'];?> - Khu vực <?php echo $mono_location_info['area'];?></option>
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
                                <?php foreach ($teacher_info as $mono_teacher){ ?>
                                    <option value="<?php echo $mono_teacher['teacher_id'] ?>"><?php echo $mono_teacher['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn_ok_class" class="btn btn-primary" status="insert" onclick="click_ok_class()">OK</button>
                    </div>
                </div>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="list_in_table container-fluid" id="list_class">
            <table id="dtClassList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <style>
                    th{
                        vertical-align: middle !important;
                        text-align: center;
                    }
                </style>
                <thead>
                <tr>
                    <th class="th-sm" rowspan="2">ID</th>
                    <th class="th-sm" rowspan="2">Type</th>
                    <th class="th-sm" rowspan="2">Mã lớp</th>
                    <th class="th-sm" rowspan="2">Giáo viên</th>
                    <th class="th-sm" rowspan="2">Ngày khai giảng</th>
                    <th class="th-sm" colspan="2">Feedback Form mẫu 1</th>
                    <th class="th-sm" colspan="2">Feedback Form mẫu 2</th>
                    <th class="th-sm" colspan="2">Feedback Phone 1</th>
                    <th class="th-sm" colspan="2">Feedback Phone 2</th>
                    <th class="th-sm" rowspan="2">Điểm TB</th>
                    <th class="th-sm" rowspan="2">Nội dung hòm thư</th>
                    <th class="th-sm" rowspan="2" title="Số lượng học viên trong lớp">Sĩ số lớp</th>
                    <th class="th-sm" rowspan="2" title="Số lượng học viên đăng ký lớp Luyện đề">SL HV ĐK Luyện đề</th>
                    <th class="th-sm" rowspan="2" title="Số lượng học viên đăng ký thi cuối kỳ">SL HV ĐK Thi cuối kỳ</th>
                    <th class="th-sm" rowspan="2" style="background: red; color: white; text-align: center">Action</th>
                </tr>
                <tr>
                    <th class="th-sm">Số lượng</th>
                    <th class="th-sm">Điểm</th>
                    <th class="th-sm">Số lượng</th>
                    <th class="th-sm">Điểm</th>
                    <th class="th-sm">Số lượng</th>
                    <th class="th-sm">Điểm</th>
                    <th class="th-sm">Số lượng</th>
                    <th class="th-sm">Điểm</th>
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
                        <td><?php echo $mono_class_info['number_feedback_ksgv1']; ?></td>
                        <td><?php echo $mono_class_info['point_ksgv1']; ?></td>
                        <td><?php echo $mono_class_info['number_feedback_ksgv2']; ?></td>
                        <td><?php echo $mono_class_info['point_ksgv2']; ?></td>
                        <td><?php echo $mono_class_info['number_feedback_phone_1']; ?></td>
                        <td><?php echo $mono_class_info['point_phone1']; ?></td>
                        <td><?php echo $mono_class_info['number_feedback_phone_2']; ?></td>
                        <td><?php echo $mono_class_info['point_phone2']; ?></td>
                        <td><?php echo $mono_class_info['average_point']; ?></td>
                        <td><a href="//qlcl.imap.edu.vn/feedback/hom_thu_gop_y_detail" target="_blank"><?php echo $mono_class_info['number_feedback_homthugopy']; ?></a></td>
                        <td><?php echo $mono_class_info['number_student']; ?></td>
                        <td><?php echo $mono_class_info['number_luyen_de']; ?></td>
                        <td><?php echo $mono_class_info['number_thicuoiky']; ?></td>

                        <td style="font-size: x-large; min-width: 200px;">
                            <i info='<?php echo json_encode($mono_class_info); ?>'  class="fa fa-link" aria-hidden="true" title="Lấy link làm Feedback cho học viên" onclick="load_get_link_class(event)"></i>
                            <a href="/feedback/phone?class_code=<?php echo $mono_class_info['class_code']; ?>" target="_blank" ><i class="fa fa-phone" aria-hidden="true" title="Nhập phản hồi điện thoại" ></i></a>
                            <a target="_blank" href="/feedback/statistic_tuvan/<?php echo $mono_class_info['class_code']; ?>"> <i class="fa fa-eye" aria-hidden="true" title="Xem báo cáo Feedback Paper"></i></a>
                            <i info='<?php echo json_encode($mono_class_info); ?>'  class="fa fa-bell" aria-hidden="true" onclick="ringthebell(event)" title="Gửi báo cáo"></i>
                            <i info='<?php echo json_encode($mono_class_info); ?>'  class="fa fa-pencil-square-o" aria-hidden="true" onclick="load_edit_class(event)" title="Chỉnh sửa thông tin lớp học"></i>
                            <i info='<?php echo $mono_class_info['class_code']; ?>'  class="fa fa-calculator" aria-hidden="true" onclick="calculator(event)" title="Tính lại điểm"></i>
                            <i info='<?php echo json_encode($mono_class_info); ?>'  class="fa fa-trash" aria-hidden="true" title="Xóa lớp học" onclick="load_del_class(event)"></i>
                        </td>
                    </tr>

                    <?php
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#dtClassList').DataTable({
            "ordering": false, // false to disable sorting (or any other option)
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

        // var arr_branch = [];
        // $(".filter-branch").each(function () {
        //     if ($(this).prop('checked')){
        //         arr_branch.push($(this).val());
        //     }
        // });
        // console.log("arr_branch");
        // console.log(arr_branch);
        // query_string += '&location=' + JSON.stringify(arr_branch);

        // var arr_area = [];
        // $(".filter-area").each(function () {
        //     if ($(this).prop('checked')){
        //         arr_area.push($(this).val());
        //     }
        // });
        // console.log("arr_area");
        // console.log(arr_area);
        // query_string += '&area=' + JSON.stringify(arr_area);


        var arr_teacher = [];

        $(".filter-teacher").each(function () {
            if ($(this).prop('checked')){
                arr_teacher.push($(this).val());
            }
        });
        query_string += '&teacher=' + JSON.stringify(arr_teacher);

        console.log("arr_teacher");
        console.log(arr_teacher);

        window.location.href = "/feedback/class_tuvan?" + query_string;



    }
</script>