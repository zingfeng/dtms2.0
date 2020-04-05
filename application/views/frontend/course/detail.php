<!-- Trending now -->
<?php echo $this->load->get_block('trending'); ?>
<!-- End trending -->

<section class="container page_khoahoc clearfix m_height"> 
    <?php echo $this->load->view('common/breadcrumb');?>    
    <div class="row">
        <div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12">
            <div class="warp_bg mb20">
                <div class="detail_tin">
                    <h1>
                        <?php echo $courseDetail['title'];?>
                        <div class="block_share right">
                            <div class="fb-share-button" data-href="<?php echo SITE_URL.$courseDetail['share_url']?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url?>" class="fb-xfbml-parse-ignore"></a></div>
                            <div class="fb-like" data-href="<?php echo SITE_URL.$courseDetail['share_url']?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                        </div>
                    </h1>
                    <div class="teacher_star">
                        <?php if($arrTeacher) { ?>
                            <p>Giáo viên: 
                                <?php foreach($arrTeacher as $teacher) { ?>
                                    <strong><a href="<?php echo $teacher['share_url'];?>"><?php echo $teacher['teacher_name'];?></a></strong>
                                    <?php echo (end($arrTeacher) != $teacher) ? ' | ' : ''?>
                                <?php } ?>
                            </p>
                        <?php } ?>
                        <p class="star"><?php echo $courseDetail['rate']?> <i class="fa fa-star"></i> <span>(<?php echo number_format($courseDetail['count_rate']);?> đánh giá)</span></p>
                    </div>
                    <p class="Images">
                        <?php if($courseDetail['youtube_id']) { ?>
                                <iframe frameborder="0" width="100%" height="350px" src="https://www.youtube.com/embed/<?php echo $courseDetail['youtube_id']?>"></iframe>
                        <?php }else{ ?>
                            <img src="<?php echo getimglink($courseDetail['images'], 'size7', 3);?>" alt="<?php echo $courseDetail['title'];?>" style="width:100%;">
                        <?php } ?>
                    </p>
                </div>
                <div class="tab_kh_online">
                    <a class="active" href="#mota">Mô tả khóa học</a>
                    <a href="#baihoc">Danh sách bài học</a>
                    <a href="#giaovien">Giáo viên</a>
                </div>                                      
            </div>

            <div class="warp_bg mb20">
                <div class="detail_tin">
                    <!-- Nội dung khóa học -->
                    <div class="noi_dung mb20" id="mota">
                        <h3>Nội dung bài học</h3>
                        <?php echo html_entity_decode($courseDetail['detail']);?>
                    </div>
                    <?php if (!$this->permission->hasIdentity()) {?>
                    <div class="mar_fix">
                       <div class="note"><i class="fa fa-question-circle"></i>&nbsp;&nbsp;Bạn có muốn đăng nhập để lưu quá trình học tập không?</div>
                       <a class="resign" href="<?php echo SITE_URL; ?>/users/login?redirect_uri=<?php echo urlencode("//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}")?>"><i>Có</i>Đăng nhập</a>
                    </div>
                    <?php } ?>
                    <!-- Danh sách bài học -->
                    <div class="list_baihoc" id="baihoc">
                        <div class="mt20"></div>
                        <h3>Danh sách bài học</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <?php foreach($arrTopic as $key => $topic) { ?>
                                <thead class="active">
                                    <tr>
                                        <th class="togle">Phần <?php echo $key +1?></th>
                                        <th class="timer">Thời gian</th>
                                        <th class="learn">Đã học</th>
                                        <th class="lock_down"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($arrClass[$topic['topic_id']]) { ?>
                                        <?php foreach($arrClass[$topic['topic_id']] as $item) { ?>
                                        <tr class="<?php echo $item['user_id'] ? 'view' : ''?>">
                                            <td>
                                                <a href="<?php echo $item['share_url']?>" title="<?php echo $item['title']?>">
                                                    <i class="fa fa fa-play-circle-o"></i>&nbsp;&nbsp;<?php echo $item['title']?>
                                                </a>
                                            </td>
                                            <td><?php echo $item['duration']?></td>
                                            <td><i class="fa fa-check-circle"></i></td>
                                            <td></td>
                                        </tr>  
                                        <?php } ?>        
                                    <?php } ?>                                           
                                </tbody>
                                <?php } ?>                     
                            </table>                     
                        </div>
                    </div>
                    <!-- Giáo viên giảng dạy -->
                    <div class="teacher_learn" id="giaovien">
                        <div class="mt20"></div>
                        <h3>Giáo viên giảng dạy</h3>
                        <?php if($arrTeacher) { ?>
                            <?php foreach($arrTeacher as $teacher) { ?>
                            <div class="row">
                                <div class="col-md-3 col-sm-4 col-xs-4 col-tn-12">
                                    <div class="ava">
                                        <span class="thumb_img thumb_5x5">
                                            <a href="<?php echo $teacher['share_url']?>" title="<?php echo $teacher['teacher_name']?>">
                                                <img title="<?php echo $teacher['teacher_name']?>" src="<?php echo getimglink($teacher['images'],'size3');?>">
                                            </a>
                                        </span>
                                    </div>
                                    <div class="info">
                                        <p><strong><i class="fa fa-star"></i>5 </strong>Xếp hạng tốt</p>
                                        <!-- <p><strong><i class="fa fa-play-circle"></i>10 </strong>Khóa học</p>
                                        <p><strong><i class="fa fa-user"></i>269,113 </strong>Học viên</p> -->
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-8 col-xs-8 col-tn-12">
                                    <h4 class="name">
                                        <a href="<?php echo $teacher['share_url']?>" title="<?php echo $teacher['teacher_name']?>" style="color: #f45b69">
                                            <?php echo $teacher['teacher_name']?></h4>
                                        </a>
                                    <p><strong>Sứ giả truyền cảm hứng</strong></p>
                                    <p><?php echo $teacher['description']?></p>
                                </div>
                            </div>
                            <?php } ?>
                        <?php } ?>
                    </div>


                    <?php
                    $data_content = array(
                        'type' => 0,
                        'target_id' => $courseId,
                    );
                    echo generateHtmlCommentBlock($data_content);
                    ?>

<!--                    <div class="block-comment-face"> -->
<!--                        <div class="fb-comments" data-order-by="reverse_time" data-href="--><?php //echo SITE_URL.$courseDetail['share_url']?><!--" data-numposts="5" width="100%"></div>-->
<!--                        <div class="fb-share-button" data-href="--><?php //echo SITE_URL.$courseDetail['share_url']?><!--" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=--><?php //echo SITE_URL.$courseDetail['share_url']?><!--" class="fb-xfbml-parse-ignore"></a></div>-->
<!--                        <div class="fb-like" data-href="--><?php //echo SITE_URL.$courseDetail['share_url']?><!--" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>-->
<!--                    </div>                                    -->
                </div>                                      
            </div>

            <?php if($arrTest) { ?> 
                <div class="warp_bg mb20 art_other">
                    <h2 class="title_category">Bài test đính kèm</h2>
                    <div class="list_learn">
                        <div class="owl-carousel">
                            <?php foreach($arrTest as $item) { ?>
                                <?php if($item['test_list']) { ?>
                                    <div class="item">
                                        <div class="ava">
                                            <a href="<?php echo str_replace('/test/', '/test/'.strtolower($item['test_list'][0]).'/', $item['share_url']); ?>" title="<?php echo $item['title']?>">
                                                <span class="thumb_img thumb_5x3"><img title="<?php echo $item['title']?>" src="<?php echo getimglink($item['images'],'size1',3);?>" alt="<?php echo $item['title']?>"></span>
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h3><a href="<?php echo str_replace('/test/', '/test/'.strtolower($item['test_list'][0]).'/', $item['share_url']); ?>" title="<?php echo $item['title']?>"><?php echo $item['title']?></a></h3>
                                            <p><?php echo $item['test_list'][0]?></p>     
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>                                                                     
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="warp_bg document_ielts mb20">
                <?php echo $this->load->get_block('left_content'); ?>
            </div>
        </div>

        <div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12 mb20">
            <div class="warp_bg block_vote category">
                <div class="star">
                    <?php for($i = 1; $i <= $courseDetail['rate']; $i++) { ?>
                        <i class="fa fa-star"></i>
                    <?php } ?>
                    <span>Có <?php echo $courseDetail['count_rate']?> lượt đánh giá</span>
                </div>
                <p>
                    <span class="ic">
                        <img src="<?php echo $this->config->item('img')?>icons/calendar.png">
                    </span>
                    Phát hành: <strong><?php echo date('d/m/Y', $courseDetail['publish_time'])?></strong>
                </p>
                
                <?php if($courseDetail['input']) { ?>
                <p>
                    <span class="ic">
                        <img src="<?php echo $this->config->item('img')?>icons/bong-den.png">
                    </span>
                    Đầu vào: <strong><?php echo $courseDetail['input']?></strong>
                </p>
                <?php } ?>

                <?php if($courseDetail['output']) { ?>
                <p>
                    <span class="ic">
                        <img src="<?php echo $this->config->item('img')?>icons/mu.png">
                    </span>
                    Mục tiêu: <strong><?php echo $courseDetail['output']?></strong></p>
                <hr>
                <?php } ?>
                <?php if($document) { ?>
                    <p><span class="ic"><img src="<?php echo $this->config->item('img')?>icons/folder.png"></span><strong>Tài liệu cùng band</strong></p>
                    <ul>
                        <li>
                            <a href="<?php echo $document['share_url']?>">Tải tài liệu</a>
                        </li>
                    </ul>           
                <?php } ?>         

                <?php if($courseDetail['price'] > 0) { ?>
                    <div class="center mt20"><button type="button" class="btn btn-default">Đăng ký học ngay</button></div>
                <?php }else{ ?>
                <div class="center mt20"><a href="<?php if (isset($first_topic)) echo $first_topic; ?>" ><button type="button" class="btn btn-default">Học ngay MIỄN PHÍ</button></a></div>
                <?php } ?>
            </div>
            
            <div class="category">
                <?php echo $this->load->view("block/contact") ?>
            </div>

            <!-- Liên kết nhanh -->
            <?php echo $this->load->get_block('right_course'); ?>  

            <?php if($arrRelated) { ?> 
            <div class="warp_bg category">
                <h2 class="title_left">khóa học ielts khác</h2>
                <?php foreach($arrRelated as $row) { ?>
                <article class="art_item">
                    <div class="thumb_art">
                        <a href="<?php echo $row['share_url'];?>" title="<?php echo $row['title'];?>">
                            <span class="thumb_img thumb_5x3">
                                <img src="<?php echo getimglink($row['images'],'size1',3);?>" alt="<?php echo $row['title'];?>" title="<?php echo $row['title'];?>">
                            </span>
                        </a>      
                    </div>
                    <div class="content">
                        <h3 class="title_news">
                            <a href="<?php echo $row['share_url'];?>" title="<?php echo $row['title'];?>">
                                <?php echo $row['title'];?>
                            </a>
                        </h3>
                        <div class="star"><?php echo $row['rate'];?><i class="fa fa-star"></i></div>
                    </div>
                </article>    
                <?php } ?>                                                                          
            </div>
            <?php } ?>
            <div class="ads category center">
                <?php echo $this->load->get_block('course_right'); ?>     
                <!-- <img title="" src="<?php echo $this->config->item('img')?>graphics/ads.jpg" alt="">  -->
            </div>  
            <!-- Góc kinh nghiệm -->
            <?php echo $this->load->get_block('home_footer_right'); ?>            
        </div>
    </div>   
</section>

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