<div class="modal" id="modal_get_link">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> Link feedback </h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h4>
                    Link feed back của lớp <span id="modal_link_feedback" style="font-weight: bold"></span>
                </h4>
                <div class="row">
                    <div class="col col-sm-12 col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_feedback">
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-warning" id="btn_copy" onclick="ClickOpenLink()" >Open</button>
                    </div>
                    <div class="col col-sm-12 col-md-2">
                        <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy()">Copy</button>
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

        <div class="list_in_table container-fluid" id="list_class">
            <table id="dtClassList" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">ID</th>
                    <th class="th-sm">Cơ sở</th>
                    <th class="th-sm">Số lượng lớp</th>
                    <th class="th-sm">Điểm trung bình</th>
                </tr>

                </thead>
                <tbody>
                <?php
                foreach ($rows as $row) { ?>
                    <tr>
                        <td><?php echo $row['id_location']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['soluonglop']; ?></td>
                        <td><?php echo round($row['diemtrungbinh'],2); ?></td>
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
            // "ordering": true // false to disable sorting (or any other option)
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
</script>