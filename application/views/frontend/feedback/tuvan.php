<div class="container-fluid area" id="tuvan">
    <div class="row" id="insert_tuvan" style="padding: 15px">
        <h4  class="">Quản trị danh sách tư vấn </h4>
        <div class="menu" id="menu_tuvan">
            <button type="button" data-toggle="modal" data-target="#insert_tuvan_modal" style="border-radius: 0" class="btn btn-primary">
                <i class="fa fa-plus" aria-hidden="true"></i> Thêm tư vấn
            </button>
        </div>

        <div class="modal fade" id="insert_tuvan_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Tư vấn viên</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="usr">Tên</label>
                            <input type="text" class="form-control" id="name_tuvan_insert">
                        </div>
                        <div class="form-group">
                            <label for="usr">Username (để đăng nhập)</label>
                            <input type="text" class="form-control" id="username_tuvan_insert">
                        </div>
                        <div class="form-group">
                            <label for="usr">Password</label>
                            <input type="text" class="form-control" id="password_tuvan_insert">
                        </div>

                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label for="location">Cơ sở</label>

                                    <select class="form-control" id="location">
                                        <?php
                                        foreach ($location_info as $item) {?>
                                            <option title ="<?php echo $item['area'] ?>" value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
                                        <?php }

                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-sm-3">
                                <label for="tuvan_active_insert">Trạng thái</label>
                                <div class="checkbox">
                                    <label alt="Tài khoản active thì tư vấn viên mới có thể đăng nhập được"><input
                                                id="tuvan_active_insert" name="tuvan_active_insert" type="checkbox"
                                                value="" checked>Active</label>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" status="insert" onclick="click_ok_tuvan()" id="btn_ok_tuvan">OK</button>
                    </div>
                </div>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <br>
        <p>Lưu ý:
            <ul>
            <li>Không nên để các tư vấn viên dùng chung tài khoản</li>
            <li>Tạo mới tài khoản cho nhân viên mới</li>
            <li>Deactive tài khoản của nhân viên cũ</li>
        </ul>
        <div class="list_in_table container-fluid" id="list_tuvan">
            <table id="dtClassList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID
                    </th>
                    <th class="th-sm">Tên
                    </th>
                    <th class="th-sm">Username
                    </th>
                    <th class="th-sm">Password
                    </th>

                    <th class="th-sm">Active
                    </th>

                    <th class="th-sm">Thời gian tạo
                    </th>
                    <th class="th-sm">Cơ sở
                    </th>
                    <th class="th-sm">Action
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($tuvan_info as $mono_tuvan_info) { ?>
                    <tr>
                        <td><?php echo $mono_tuvan_info['id']; ?></td>
                        <td><?php echo $mono_tuvan_info['fullname']; ?></td>
                        <td><?php echo $mono_tuvan_info['username']; ?></td>
                        <td><?php echo $mono_tuvan_info['passwd']; ?></td>
                        <td><?php
                            if ($mono_tuvan_info['status'] == 1){?>
                                <span class="text-success">Active</span>
                            <?php } else{ ?>
                            <span class="text-danger">Not Active</span>
                                <?php } ?>
                        </td>
                        <td>
                            <?php echo date('m/d/Y - H:i',$mono_tuvan_info['time_creat']);  ?>
                        </td>
                        <td>
                            <?php
                            $id_location = $mono_tuvan_info['id_location'];
                            $detail_location = $location_list[$id_location];
                            echo $detail_location['name'].' ('.$detail_location['area'].')' ;
                            ?>
                        </td>

                        <td style="font-size: x-large">
                            <?php if ($mono_tuvan_info['status'] == 1){?>
                            <button class="btn btn-sm btn-danger" info='<?php echo json_encode($mono_tuvan_info); ?>' action_status="deactive" onclick="ClickActive_Deactive(event)">Deactive</button>
                            <?php } else{ ?>
                            <button class="btn btn-sm btn-success" info='<?php echo json_encode($mono_tuvan_info); ?>' action_status="active" onclick="ClickActive_Deactive(event)">Active</button>
                            <?php } ?>

                            <button class="btn btn-sm btn-warning" info='<?php echo json_encode($mono_tuvan_info); ?>' onclick="load_edit_tuvan(event)">Edit</button>
                            <button class="btn btn-sm btn-danger" info='<?php echo json_encode($mono_tuvan_info); ?>' onclick="load_del_tuvan(event)">Del</button>
                        </td>
                    </tr>

                    <?php }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // $('#dtClassList').DataTable({
        //     "ordering": false // false to disable sorting (or any other option)
        // });
        // $('.dataTables_length').addClass('bs-select');
    });
</script>