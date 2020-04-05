

<div class="container-fluid" style="margin-top: 40px; ">
    <div>
        <h3 class="my_title">Bảng tin
        </h3>
        <table id="dtFeedbackList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">ID
                </th>
                <th class="th-sm">Thời gian
                </th>
                <th class="th-sm">Mã lớp
                </th>
                <th class="th-sm">Type
                </th>
                <th class="th-sm">Ghi chú
                </th>
            </tr>
            </thead>
            <tbody>

            <?php
            if (isset($list_feedback_newest) && (is_array($list_feedback_newest))) {
                foreach ($list_feedback_newest as $mono_feedback_paper) {
                    $class_code_mono = $mono_feedback_paper['class_code'];
                    $type = $mono_feedback_paper['type'];
                    $time_end = $mono_feedback_paper['time_end'];
                    $name_feeder = $mono_feedback_paper['name_feeder']; ?>
                    <tr>
                        <td><?php echo $mono_feedback_paper['id'] ?></td>
                        <td><?php echo date('d/m/Y - H:i:s', $time_end); ?></td>
                        <td><?php echo $class_code_mono ?></td>
                        <td><?php echo $type ?></td>
                        <td><?php echo $name_feeder ?></td>
                    </tr>

                    <?php
                }
            }?>

            </tbody>
        </table>

    </div>
</div>


<script>
    $(document).ready(function () {
        $('#dtFeedbackList').DataTable({
            "ordering": false // false to disable sorting (or any other option)
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>