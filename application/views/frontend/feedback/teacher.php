<div class="container-fluid area" id="teacher">
    <div class="row" id="insert_teacher" style="padding: 15px">
        <h4  class="">Quản trị danh sách giáo viên </h4>
        <div class="menu" id="menu_teacher">
            <button type="button" data-toggle="modal" data-target="#insert_teacher_modal" style="border-radius: 0" class="btn btn-primary">
                <i class="fa fa-plus" aria-hidden="true"></i> Thêm giáo viên
            </button>
        </div>

        <div class="modal fade" id="insert_teacher_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Teacher</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="usr">Tên</label>
                                    <input type="text" class="form-control" id="name_teacher_insert">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="usr">Email</label>
                                    <input type="text" class="form-control" id="email_teacher_insert">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comment">Thông tin thêm</label>
                            <textarea class="form-control" rows="3" id="info_teacher_insert"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Email quản lý</label>
                            <input type="text" class="form-control" id="manager_email_insert">
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label><input id="teacher_giaotiep_insert"  name="teacher_giaotiep_insert" type="checkbox" value="" checked>GIAO TIẾP</label>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label><input id="teacher_toeic_insert" name="teacher_toeic_insert"  type="checkbox" value="" checked>TOEIC</label>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label><input id="teacher_ielts_insert" name="teacher_ielts_insert" type="checkbox" value="" checked>IELTS</label>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label><input id="teacher_aland_insert" name="teacher_aland_insert" type="checkbox" value="" checked>ALAND</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" status="insert" onclick="click_ok_teacher()" id="btn_ok_teacher">OK</button>
                    </div>
                </div>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="list_in_table container-fluid" id="list_teacher">
            <table id="dtClassList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID
                    </th>
                    <th class="th-sm">Tên
                    </th>
                    <th class="th-sm">Email
                    </th>
                    <th class="th-sm">Info
                    </th>
                    <th class="th-sm">Giao tiếp
                    </th>
                    <th class="th-sm">Toeic
                    </th>
                    <th class="th-sm">Ielts
                    </th>
                    <th class="th-sm">Aland
                    </th>
                    <th class="th-sm">Action
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($teacher_info as $mono_teacher_info) { ?>
                    <tr>
                        <td><?php echo $mono_teacher_info['teacher_id']; ?></td>
                        <td><?php echo $mono_teacher_info['name']; ?></td>
                        <td><?php echo $mono_teacher_info['email']; ?></td>

                        <td><?php echo $mono_teacher_info['info']; ?></td>
                        <td><?php
                            if( $mono_teacher_info['giaotiep'] == 1){ ?>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            <?php } ?>
                        </td>
                        <td><?php
                            if( $mono_teacher_info['toeic'] == 1){ ?>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            <?php } ?>
                        </td>
                        <td><?php
                            if( $mono_teacher_info['ielts'] == 1){ ?>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            <?php } ?>
                        </td>
                        <td><?php
                            if( $mono_teacher_info['aland'] == 1){ ?>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            <?php } ?>
                        </td>
                        <td style="font-size: x-large">
                        <i info='<?php echo json_encode($mono_teacher_info); ?>' onclick="load_edit_teacher(event)" class="fa fa-pencil-square-o" aria-hidden="true" title="Chỉnh sửa"></i>
                            <i info='<?php echo json_encode($mono_teacher_info); ?>' onclick="load_del_teacher(event)"  class="fa fa-trash" aria-hidden="true" title="Xóa"></i>
                        </td>

                    </tr>

                    <?php
                } ?>

                </tbody>
                <tfoot>
                <tr>
                    <th class="th-sm">ID
                    </th>
                    <th class="th-sm">Tên
                    </th>
                    <th class="th-sm">Email
                    </th>

                    <th class="th-sm">Info
                    </th>
                    <th class="th-sm">Giao tiếp
                    </th>
                    <th class="th-sm">Toeic
                    </th>
                    <th class="th-sm">Ielts
                    </th>
                    <th class="th-sm">Aland
                    </th>
                    <th class="th-sm">Action
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dtClassList').DataTable({
            "ordering": false // false to disable sorting (or any other option)
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>