<div class="col-md-8 col-sm-8 col-xs-12">
    <?php echo $this->load->view('common/breadcrumb');?>
    <div class="col_news_cm">    
        <div class="fb-comments" data-order-by="reverse_time" data-height="auto" data-width="750" data-href="http://mshoatoeic.com/tu-van.html"  data-num-posts="6"></div>
    </div> <!-- End -->

    
    <?php echo $this->load->get_block('content'); ?> 
</div>
<div class="col-md-4 col-sm-4 col-xs-12">
    <?php echo $this->load->get_block('right'); ?>
    <div class="sidebar-block"> 
        <div class="title-header-bl"><h2>FANPAGE</h2><span><i class="fa fa-angle-right arow"></i></span></div>
        <div class="fb-page" data-href="<?php echo $this->config->item('facebook');?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $this->config->item('facebook');?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $this->config->item('facebook');?>">Facebook</a></blockquote></div>
    </div><!--End-->
</div>