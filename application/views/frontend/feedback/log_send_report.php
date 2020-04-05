<div class="row">
    <div class="col-sm-9" id="list_class">
        <h4>Lịch sử yêu cầu gửi báo cáo </h4>
        <table id="dtClassList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm" >ID
                </th>
                <th class="th-sm" >Thời gian
                </th>
                <th class="th-sm" >Người yêu cầu
                </th>
                <th class="th-sm" >Mã lớp
                </th>
                <th class="th-sm" >Trạng thái
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($get_list_bell as $mono) { ?>
            <tr>
                <td><?php echo $mono['id']; ?></td>
                <td><?php echo date('d/m/Y - H:i:s', $mono['time']); ?></td>
                <td><?php echo $mono['fullname']; ?></td>
                <td><?php echo $mono['class_code']; ?></td>
                <td><?php
                    switch ($mono['status']) {
                        case 1:
                            echo 'Hoàn thành';
                            break;
                        default:
                            echo 'Đang chờ';
                    }
                    ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>