<ul class="breadcrumbs">
    <li><i class="fa fa-folder-open"></i><a href="<?php echo SITE_URL;?>">Trang chủ</a></li>
    <?php foreach($this->config->item('breadcrumb') as $breadcrumb){?>
    <?php if($breadcrumb['link']){?>
    <li><i class="fa fa-angle-double-right"></i> <a href="<?php echo $breadcrumb['link'];?>"><?php echo $breadcrumb['name'];?></a></li>
    <?php } else {?>
    <li><i class="fa fa-angle-double-right"></i> <a class="active" href="javascript:;"><?php echo $breadcrumb['name'];?></a></li>
    <?php }?>
    <?php }?>
</ul><!-- /.End --> 