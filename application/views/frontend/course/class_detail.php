<!-- Trending now -->

<?php
echo $this->load->get_block('trending'); ?>
<!-- End trending -->

<section class="container clearfix">
  	<?php echo $this->load->view('common/breadcrumb');?>     
    <div class="row">
        <div id="sidebar_left" class="right col-md-8 col-sm-8 col-xs-8 col-tn-12">
            <div class="warp_bg mb20">
              <div class="detail_tin">
                <h1>
                    <?php echo $classDetail['title'];?>
                    <div class="block_share right">
                        <div class="fb-share-button" data-href="<?php echo SITE_URL.$classDetail['share_url']?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url?>" class="fb-xfbml-parse-ignore"></a></div>
                        <div class="fb-like" data-href="<?php echo SITE_URL.$classDetail['share_url']?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                    </div>
                </h1>
                <div class="teacher_star">
                    
                </div>           
                <p class="Images">
                    <?php if($classDetail['youtube_id']) { ?>
                            <iframe frameborder="0" width="100%" height="350px" src="https://www.youtube.com/embed/<?php echo $classDetail['youtube_id']?>"></iframe>
                    <?php }else{ ?>
                        <img src="<?php echo getimglink($classDetail['images'], 'size7', 3);?>" alt="<?php echo $classDetail['title'];?>" style="width:100%;">
                    <?php } ?>
                </p>
                <div class="row option_tab">
                    <div class="col-md-4 col-sm-4">
                      <a href="#noi_dung"><i class="fa fa-file-text-o"></i>Nội dung</a>
                    </div>
                    <?php if($arrTest) { ?> 
                    <div class="col-md-4 col-sm-4">
                      <a href="#test"><i class="fa fa-check-circle-o"></i>Test</a>
                    </div>
                    <?php } ?>
                    <?php if($classDetail['document']) { ?>
                    <div class="col-md-4 col-sm-4">
                        <?php
                        // detect pdf
                        echo '<a type="button" data-toggle="modal"  data-target="#modal_preview_div" href="#"><i class="fa fa-download"></i>'.'Tải tài liệu</a>';
                        ?>
                    </div>

                    <?php } ?>                                   
                </div>

                  <div class="row">
                      <div class="col col-sm-12">
                          <div class="modal fade" role="dialog" id="modal_preview_div">
                              <div class="container-fluid">
                                  <div class="modal-dialog modal-lg" role="document" style="width: 100%">
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">Tải tài liệu
                                                  <?php
                                                  if (isset($classDetail['document'])){
                                                      $str = $classDetail['document'];
                                                      $re = '/drive\.google\.com\/file\/d\/(.*)\/preview*/m';
                                                      preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
                                                      if (isset($matches[0][1])){
                                                          $direct_link = 'https://drive.google.com/uc?export=download&id='.$matches[0][1];
                                                          echo ' <a class="btn btn-success" type="button" target="_blank" style="margin-left: 20px;" href="'.$direct_link.'" ><i class="fa fa-download" aria-hidden="true"></i></a>';
                                                      }
                                                  }
                                                  ?>
                                              </h4>

                                          </div>
                                          <div class="modal-body" style="height: 1500px !important;" >
                                              <iframe style="height:100% !important; width: 100% !important;" src="<?php
                                              if($classDetail['document']) echo $classDetail['document'];
                                              ?>" frameborder="0"></iframe>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                <div class="noi_dung" id="noi_dung">
                  	<h3>Nội dung bài học</h3>
                    <?php echo html_entity_decode($classDetail['detail']);?>
                </div>
                <div class="clearfix mt20 mb20">
                    <?php if($prev) { ?>
                        <a class="prev" href="<?php echo $prev['share_url']?>">
                            <i class="fa fa-angle-double-left"></i>Quay lại
                        </a>
                    <?php } ?>
                    <?php if($next) { ?>
                        <a class="next" href="<?php echo $next['share_url']?>">
                            Tiếp theo <i class="fa fa-angle-double-right"></i>
                        </a>
                    <?php } ?>
                </div>
                <?php if($arrTest) { ?> 
                <div class="bai_test_khac" id="test">
                    <h2 class="title_category">Bài test đính kèm</h2>
                    <div class="owl-carousel">
                        <?php foreach($arrTest as $item) { ?>
                            <?php if($item['test_list']) { ?>
                            <a class="<?php echo $item['title']?>" href="<?php echo str_replace('/test/', '/test/'.strtolower($item['test_list'][0]).'/', $item['share_url']); ?>?skill=1">
                                <h3><?php echo $item['title']?></h3>  
                                <img title="<?php echo $item['title']?>" src="<?php echo getimglink($item['images'],'size1',3);?>" alt="<?php echo $item['title']?>">
                            </a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>

                <?php
                    $data_content = array(
                      'type' => 1,
                      'target_id' => $class_id,
                    );
                    echo generateHtmlCommentBlock($data_content);
                ?>

<!--                <div class="block-comment-face"> -->
<!--                    <div class="fb-comments" data-order-by="reverse_time" data-href="--><?php //echo SITE_URL.$classDetail['share_url']?><!--" data-numposts="5" width="100%"></div>-->
<!--                    <div class="fb-share-button" data-href="--><?php //echo SITE_URL.$classDetail['share_url']?><!--" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=--><?php //echo SITE_URL.$classDetail['share_url']?><!--" class="fb-xfbml-parse-ignore"></a></div>-->
<!--                    <div class="fb-like" data-href="--><?php //echo SITE_URL.$classDetail['share_url']?><!--" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>-->
<!--                </div>-->
              </div>                                      
            </div>
        </div>
        <?php if($arrTopic) { ?>
        <div id="sidebar_right" class="left col-md-4 col-sm-4 col-xs-4 col-tn-12 mb20">
            <div class="category category_new">
                <h2>Danh mục bài học</h2>
                <?php foreach($arrTopic as $key => $topic) { ?>
                    <h3 class="<?php echo $key == 0 ? "active" : ""?>"><?php echo $topic['name']?></h3>
                    <?php if($arrClass[$topic['topic_id']]) { ?>
                        <div class="level2" <?php echo $key > 0 ? 'style="display: none;"' : ''?>>
                            <?php foreach($arrClass[$topic['topic_id']] as $item) { ?>
                                <a href="<?php echo $item['share_url']?>"  <?php if($item['share_url'] == $present['share_url']) echo ' class="active" style="color: white;background-color: #456990;" '; ?>><i class="fa fa fa-play-circle-o"></i><?php echo $item['title']?></a>
                             <?php } ?>
                        </div>
                     <?php } ?>
                <?php } ?>               
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <div id="sidebar_left" class="right col-md-8 col-sm-8 col-xs-8 col-tn-12">
            <!-- Khóa học khác -->
            <?php if($arrRelated) { ?> 
            <div class="warp_bg mb20 art_other">
             	<h2 class="title_category">Khóa học liên quan</h2>
             	<div class="list_learn">
                    <div class="owl-carousel">
                      	<?php foreach($arrRelated as $row) { ?>
                      	<div class="item">
	                        <div class="ava">
	                          	<a href="<?php echo $row['share_url'];?>" title="<?php echo $row['title'];?>">
	                           	 	<span class="thumb_img thumb_5x3">
	                           	 		<img src="<?php echo getimglink($row['images'],'size1',3);?>" alt="<?php echo $row['title'];?>" title="<?php echo $row['title'];?>">
	                           	 	</span>
	                          	</a>
	                        </div>
	                        <div class="content">
	                          	<h3><a href="<?php echo $row['share_url'];?>" title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a></h3>
                          		<p>Reading</p>     
	                        </div>
                      	</div>
                      	<?php } ?>
                  	</div>                                                
                </div>                     
          	</div>
          	<?php } ?>

            <div class="warp_bg document_ielts mb20">
                <?php echo $this->load->get_block('left_content'); ?>
            </div>
        </div>
    </div>
</section>

<script src="https://www.aland.edu.vn/theme/frontend/default/js/pdfobject.js"></script>
<script type="text/javascript">
  $('a[href^="#"]').on('click', function(event) {
    var target = $(this.getAttribute('href'));
    if( target.length ) {
        event.preventDefault();
        $('html, body').stop().animate({
            scrollTop: target.offset().top
        }, 1000);
    }
  });
</script>