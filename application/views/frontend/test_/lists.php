<section class="container clearfix m_height">
    <?php echo $this->load->view('common/breadcrumb');?>
    <div class="row">
        <div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12">
            <div class="warp_bg mb20">
                <div class="infomation">
                  <img src="<?php echo getimglink($cate['images']);?>" alt="<?php echo $cate['name']; ?>">
                  <div class="content" style="padding: 15px 0">
                    <h1><?php echo $cate['name']; ?></h1>
                    <?php if(strpos($cate['description'], '<div style="page-break-after: always">') > 0) { ?>
                    <div id="desc_sort">
                        <?php echo substr($cate['description'], 0, strpos($cate['description'], '<div style="page-break-after: always">'));?>
                    </div>
                    <div id="desc_full" style="display: none;">
                        <?php echo $cate['description'];?>
                    </div>
                    <a id="showmore" class="btn btn-default" style="color: #fff;background: #f45b69;line-height: 12px;padding: 8px 20px;margin-top: 10px">Xem thêm >> </a>
                    <?php }else{ ?>
                    <p>
                        <?php echo $cate['description'];?>
                    </p>
                    <?php } ?>
                  </div> 
                  <div class="clearfix"></div>                       
                </div>
                <?php foreach ($rows as $key => $row) { ?>
                    <?php if($test_list = $row['test_list']) { ?>
                    <div class="practice_test">
                        <h2><?php echo $row['title']; ?></h2>
                        <div class="wrap">
                            <div class="test_icon">
                                <div class="auto">
                                    <a title="Fulltest" style="display: inline;" href="<?php echo str_replace('/test/', '/test/'.strtolower($test_list[0]).'/', $row['share_url']); ?>">
                                        <img src="<?php echo $this->config->item("img"); ?>icons/fulltest1.png" alt="">
                                    </a>
                                    <a title="Fulltest" style="display: inline;" href="<?php echo str_replace('/test/', '/test/'.strtolower($test_list[0]).'/', $row['share_url']); ?>"><h3>Full Test</h3></a>
                                </div>  
                            </div>
                            <div class="full_test">
                                <?php if(isset($test_list) && in_array('Listening', $test_list)) { ?>
                                <div class="item done">
                                    <a style="background: none" title="Test ngay" href="<?php echo str_replace('/test/', '/test/listening/', $row['share_url']); ?>?skill=1">
                                    <img src="<?php echo $this->config->item("img"); ?>icons/headphone1.png" alt="">
                                    </a>
                                    <a title="Test ngay" href="<?php echo str_replace('/test/', '/test/listening/', $row['share_url']); ?>?skill=1">listening</a>
                                </div>
                                <?php } ?>
                                <?php if(isset($test_list) && in_array('Reading', $test_list)) { ?>
                                <div class="item done">
                                    <a style="background: none" title="Test ngay" href="<?php echo str_replace('/test/', '/test/reading/', $row['share_url']); ?>?skill=1">
                                    <img src="<?php echo $this->config->item("img"); ?>icons/book1.png" alt="">
                                  </a>
                                    <a title="Test ngay" href="<?php echo str_replace('/test/', '/test/reading/', $row['share_url']); ?>?skill=1">reading</a>
                                </div>
                                <?php } ?>
                                <?php if(isset($test_list) && in_array('Writing', $test_list)) { ?>
                                <div class="item done">
                                  <a style="background: none" title="Test ngay" href="<?php echo str_replace('/test/', '/test/writing/', $row['share_url']); ?>?skill=1">
                                    <img src="<?php echo $this->config->item("img"); ?>icons/pencil1.png" alt="">
                                  </a>
                                    <a title="Test ngay" href="<?php echo str_replace('/test/', '/test/writing/', $row['share_url']); ?>?skill=1">writing</a>
                                </div>
                                <?php } ?>
                                <?php if(isset($test_list) && in_array('Speaking', $test_list)) { ?>
                                <div class="item done">
                                    <a style="background: none" title="Test ngay" href="<?php echo str_replace('/test/', '/test/speaking/', $row['share_url']); ?>?skill=1">
                                    <img src="<?php echo $this->config->item("img"); ?>icons/microphone.png" alt="">
                                  </a>
                                    <a title="Test ngay" href="<?php echo str_replace('/test/', '/test/speaking/', $row['share_url']); ?>?skill=1">speaking</a>
                                </div>    
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
            	<?php } ?>
                
                <?php echo $paging?>
            </div>
        </div>

        <div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12 mb20">
            <div class="category">
                <?php echo $this->load->view("block/contact")?>
            </div>

          	<?php echo $this->load->get_block('right'); ?>
        </div>
    </div>
    <!-- TIN QUAN TÂM --> 
    <!-- <div class="warp_bg mb20 art_other grid4">
        <h2>Các bài test khác</h2>
        <div class="nav_category">
            <a class="active" href="">Reading</a>
            <a href="">Listening</a>
            <a href="">Speaking</a>
            <a href="">Writing</a>
        </div>
        <div class="list_learn list_learn_other">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3 col-tn-12 mb10">
                    <div class="ava">
                      <a href="#" title="">
                        <span class="thumb_img thumb_5x5"><img title="" src="<?php echo $this->config->item("img"); ?>graphics/book1.jpg" alt=""></span>
                      </a>
                    </div>
                    <div class="content">
                      <h3><a href="#" title="">IELTS Fighter test1</a></h3>  
                      <p>Reading</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 col-tn-12 mb10">
                    <div class="ava">
                      <a href="#" title="">
                        <span class="thumb_img thumb_5x5"><img title="" src="<?php echo $this->config->item("img"); ?>graphics/book1.jpg" alt=""></span>
                      </a>
                    </div>
                    <div class="content">
                      <h3><a href="#" title="">IELTS Fighter test1</a></h3>  
                      <p>Reading</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 col-tn-12 mb10">
                    <div class="ava">
                      <a href="#" title="">
                        <span class="thumb_img thumb_5x5"><img title="" src="<?php echo $this->config->item("img"); ?>graphics/book1.jpg" alt=""></span>
                      </a>
                    </div>
                    <div class="content">
                      <h3><a href="#" title="">IELTS Fighter test1</a></h3>  
                      <p>Reading</p>
                    </div>
                </div>                      
                <div class="col-md-3 col-sm-3 col-xs-3 col-tn-12 mb10">
                    <div class="ava">
                      <a href="#" title="">
                        <span class="thumb_img thumb_5x5"><img title="" src="<?php echo $this->config->item("img"); ?>graphics/book1.jpg" alt=""></span>
                      </a>
                    </div>
                    <div class="content">
                      <h3><a href="#" title="">IELTS Fighter test1</a></h3>  
                      <p>Reading</p>
                    </div>
                </div>                                                
            </div>                                                
        </div>                     
    </div> -->    

    <div class="warp_bg document_ielts new mb20">
        <?php echo $this->load->get_block('left_content'); ?>
    </div>           
</section>

<script type="text/javascript">
    $(document).ready(function(){
        $('#showmore').click(function(){
            if($('#desc_full').is(":visible") ){
                $('#desc_full').hide();
                $('#desc_sort').show();
                $(this).html('Xem thêm >>');
            }else{
                $('#desc_full').show();
                $('#desc_sort').hide();
                $(this).html('<< Thu gọn');
            }
        })
    })
</script>