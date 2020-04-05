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
<footer id="footer" class="section">
    <div class="container">      
         <div class="row">
            <?php foreach($arr_data as $key => $data) { ?>
            <div class="col-md-3 col-sm-3 col-xs-6 col-tn-12 mb20">
                <h3><?php echo $arr_loc[$key]?></h3>
                <?php foreach($data as $item) { ?>
                <label><?php echo $item['label']?></label>
                    <p><?php echo $item['name']?><a style="color:white" href="tel:<?php echo $item['phone']?>"> SĐT: <?php echo $item['phone']?></a></p>
                <?php } ?>            
            </div>
            <?php } ?>
            <div class="col-md-3 col-sm-3 col-xs-6 col-tn-12 mb20">
                <h3 style="margin-bottom: 40px;">FANPAGE</h3>
                <div class="fb-page" data-href="<?php echo $this->config->item("facebook"); ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $this->config->item("facebook"); ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $this->config->item("facebook"); ?>">Facebook</a></blockquote></div>
            </div>
         </div> 
    </div>
</footer>
<div class="modal fade" id="modal_message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
