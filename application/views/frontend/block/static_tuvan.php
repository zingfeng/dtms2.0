<?php 
$arr_loc = array(1 => 'Tp. Hà Nội', 2 => 'Tp. Hồ Chí Minh', 3 => 'Tp. Đà Nẵng');
$arr_branch = json_decode($this->config->item('branch'), true);
if(!empty($arr_branch)){
    $arr_data = array();
    foreach ($arr_branch as $item) {
        $arr_data[$item['loc']][] = $item;
    }
}
?>
<div class="box_dktv">
    <h2><?php echo $block['name'] ?></h2>
    <form id="tuvan_form" method="POST" action="<?php echo SITE_URL; ?>/contact/tuvan">
        <div class="form-group">
            <input class="form-control" type="text" required name="fullname" placeholder="Họ và tên">
        </div>
        <div class="form-group">
            <input class="form-control" type="text" required name="phone" placeholder="Số điện thoại">
        </div>
        <div class="form-group">
            <input class="form-control" type="text" required name="email" placeholder="Email"> 
        </div>
        <div class="form-group" style="display: none">
            <input class="form-control" type="text" name="url" value="<?php
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            echo $actual_link;
            ?>">
        </div>
        <div class="form-group" style="display: none">
            <input class="form-control" type="text" name="form_type" value="form_dang_ky_tu_van">
        </div>


        <div class="form-group">
            <select class="form-control" required placeholder="Cơ sở bạn muốn tư vấn?" name="coso">
                <option value="">Cơ sở bạn muốn tư vấn?</option>
                <?php if($arr_data) { ?>
                <?php foreach($arr_data as $key => $data) { ?>
                    <option disabled style="font-weight: bold;" >
                        Hệ thống cơ sở <?php echo $arr_loc[$key]?>
                    </option>
                    <?php foreach($data as $item) { ?>
                        <option value="<?php echo $item['id']?>">
                            <?php echo $item['label']?>: <?php echo $item['name']?> - SĐT: <?php echo $item['phone']?>
                        </option>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            </select>
        </div>
        <div style="text-align:center"><button class="btn_send" type="submit" id="tuvan_submit">Gửi</button></div>
    </form>
</div><!-- /End --> 