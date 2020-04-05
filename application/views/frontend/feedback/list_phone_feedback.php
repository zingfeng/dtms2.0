<?php
    for ($i = 0; $i < count($arr_times_val); $i++) {
        $times_focus = $arr_times_val[$i];

        ?>
        <div STYLE="border-left: 4PX SOLID #0bc75b;    PADDING-LEFT: 8PX; PADDING-BOTTOM: 20PX;">
        <h3>Danh sách các phản hồi đã tạo lần <?php echo $times_focus; ?> (lớp <?php echo $class_code?>)</h3>
        <h4>Số lượng: <?php echo $full_times_info[$times_focus]['count'] ?></h4>
        <h4>Điểm trung bình: <?php echo $full_times_info[$times_focus]['average_point'] ?></h4>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Lần khảo sát</th>
                <th scope="col">Thời gian</th>
                <th scope="col">Người tạo</th>
                <th scope="col">Tên học viên</th>
                <th scope="col">Nhận xét</th>
                <th scope="col">Điểm</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $stt = 1;
            foreach ($list_phone_feedback as $mono){
                if ($mono['times'] != $times_focus ){
                    continue;
                }

                ?>
                <tr>
                    <th scope="row"><?php echo $stt; ?></th>
                    <th>Lần <?php echo $mono['times']; ?></th>
                    <td><?php echo date('d/m/Y - H:i:s',$mono['time']);?></td>
                    <td title="Role: <?php echo $info_user[$mono['user_id_creat']]['role']; ?>"><?php echo $info_user[$mono['user_id_creat']]['fullname'];?></td>
                    <td><?php echo $mono['name_feeder']; ?></td>
                    <td><?php echo $mono['comment']; ?></td>
                    <td style="text-align: right"><?php echo $mono['point']; ?></td>
                </tr>

                <?php
                $stt++;
            }
            ?>

            </tbody>
        </table>
        </div>

        <?php
    }

?>

<?php

