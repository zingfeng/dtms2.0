<h2 class="my_title">Danh sách học viên đăng ký thi cuối kỳ
    <button class="btn btn-success" title="Export File" onclick="clickFilter('export')" data-url="export"><i class="fa fa-file-excel-o"></i> Export</button>
</h2>

<div class="filter_div">
    <div class="hover-point" onclick="$('#body_filter').toggle();">
        <h4 class="text-primary" style="display: inline-block">Filter</h4>
        <button class="btn btn-primary btn-sm" style="float: right;padding-left: 120px; padding-right: 120px;" onclick="clickFilter('filter')" data-url="filter"><i class="fa fa-filter"></i> Filter</button>
        <a href="/log/thi_cuoi_ky"><button class="btn btn-danger btn-sm" style="float: right;padding-left: 20px; padding-right: 20px; margin-right: 20px;"><i class="fa fa-filter"></i> X Filter</button></a>
    </div>

    <div class="row" id="body_filter" style="display: none">
        <form action="/log/thi_cuoi_ky" method="get">
            <div class="col col-sm-1">
                <div class="form-group">
                    <label>Mã lớp :</label>
                    <input type="input" class="form-control" name="class" id="class" value="<?php
                    if (isset($_REQUEST['class'])){
                        echo $_REQUEST['class'];
                    }
                    ?>">
                </div>
            </div>

        </form>
    </div>
    <!--            $_REQUEST['min_opening']-->
</div>

<div class="container-fluid" style="margin-top: 20px; ">
    <div class="row">
        <div class="col col-sm-12">
            <table id="dtFeedbackList2" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID</th>
                    <th class="th-sm">Họ vào tên</th>
                    <th class="th-sm">Số điện thoại</th>
                    <th class="th-sm">Email</th>
                    <th class="th-sm">Cơ sở</th>
                    <th class="th-sm">Lớp</th>
                    <th class="th-sm">Lịch thi</th>
                </tr>
                </thead>
                <tbody>

                <?php
                if (isset($rows) && (is_array($rows))) {
                    foreach ($rows as $row) { ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['hoten'] ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['location'].' - '.$row['area'] ?></td>
                            <td><?php echo $row['class_code'] ?></td>
                            <td><?php echo $shift_text[$row['shift']]?></td>
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
    function ClickSelectLabel(type_select) {
        var checked = $('#filter-' + type_select + '-anchor').prop('checked');
        $('.filter-' + type_select).each(function () {
            $(this).prop('checked',checked);
        });
    }
    function clickFilter(type) {
        var query_string = '';

        var class_code = $('#class').val();

        console.log("class_code");
        console.log(class_code);
        if (class_code !== ''){
            query_string += '&class=' + class_code;
        }
        if(type == 'export'){
            window.location.href = "/log/export_list_thicuoiky_by_type?" + query_string;
        }else {
            window.location.href = "/log/thi_cuoi_ky?" + query_string;
        }
    }
</script>



