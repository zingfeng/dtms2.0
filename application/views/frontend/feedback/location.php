<div class="container-fluid area" id="teacher">
    <div class="row" id="insert_teacher" style="padding: 15px">
        <h4  class="">Quản trị danh sách cơ sở </h4>
        <div class="menu" id="menu_teacher">
            <button type="button" data-toggle="modal" data-target="#insert_location_modal" style="border-radius: 0" class="btn btn-primary">
                <i class="fa fa-plus" aria-hidden="true"></i> Thêm cơ sở
            </button>
        </div>

        <div class="modal fade" id="insert_location_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Cơ sở</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="usr">Tên</label>
                            <input type="text" class="form-control" id="name_location_insert">
                        </div>

                        <div class="form-group">
                            <label for="area">Khu vực</label>
                            <select class="form-control" id="area">
                                <option value="Hà Nội">Hà Nội</option>
                                <option value="Đà Nẵng">Đà Nẵng</option>
                                <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                                <option value="Tỉnh thành khác">Tỉnh thành khác</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="brand">Thương hiệu</label>
                            <select class="form-control" id="brand" name="brand" multiple="multiple">
                                <option value="aland">Aland</option>
                                <option value="giaotiep">Giao tiếp</option>
                                <option value="ielts">IELTS Fighter</option>
                                <option value="toeic">TOEIC</option>
                            </select>
                        </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" status="insert" onclick="click_ok_location()" id="btn_ok_location">OK</button>
                    </div>
                </div>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        </div>

        <div class="list_in_table container-fluid" id="list_teacher">
            <table id="dtClassList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID</th>
                    <th class="th-sm">Tên</th>
                    <th class="th-sm">Khu vực</th>
                    <th class="th-sm">Thương hiệu</th>
                    <th class="th-sm">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($location_info as $mono_location_info) { ?>
                    <tr>
                        <td><?php echo $mono_location_info['id']; ?></td>
                        <td><?php echo $mono_location_info['name']; ?></td>
                        <td><?php echo $mono_location_info['area']; ?></td>
                        <td>
                            <?php
                            $detail_brand = json_decode($mono_location_info['brand']);
                            if(count($detail_brand) > 0) {
                                foreach ($detail_brand as $brand) {
                                    echo $brands[$brand].', ';
                                }
                            }
                            ?>
                        </td>
                        <td style="font-size: x-large">
                            <i info='<?php echo json_encode($mono_location_info); ?>' onclick="load_edit_location(event)" class="fa fa-pencil-square-o" aria-hidden="true" title="Chỉnh sửa"></i>
                            <i info='<?php echo json_encode($mono_location_info); ?>' onclick="load_del_location(event)"  class="fa fa-trash" aria-hidden="true" title="Xóa"></i>
                        </td>

                    </tr>

                    <?php
                } ?>

                </tbody>
<!--                <tfoot>-->
<!--                <tr>-->
<!--                    <th class="th-sm">ID-->
<!--                    </th>-->
<!--                    <th class="th-sm">Tên-->
<!--                    </th>-->
<!--                    <th class="th-sm">Khu vực-->
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
            "ordering": false // false to disable sorting (or any other option)
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>