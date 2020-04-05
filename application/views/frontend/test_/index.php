<div class="col-md-8 col-sm-8 col-xs-12">
    

	<!-- Full test -->
	
	<?php if($arrCate) { ?>
		<div class="row">
		<?php 
		$i = 1;
		foreach ($arrCate as $key => $cateFull) {
			$arrSkillChild = array();
			$colType = ($i == 1) ? 1 : 2;?>
			<div class="col-md-<?php echo ($colType == 1) ? 12 : 6; ?>">
				<div class="col_box_test">
					<div class="head-list-read"><h2><?php echo $cateFull['name'];?></h2></div>
					<div class="row box_mini_test">
					    <?php foreach($cateFull['child'] as $child){ ?>
					    	<?php if(!$child['child']) { ?>
					    		<div class="col-md-<?php echo ($colType == 1) ? 6 : 12; ?>"><a class="title_test" href="<?php echo $child['share_url']?>"><?php echo $child['name']?></a></div>
					    	<?php } else {
					    		$arrSkillChild[] = $child;
					    	} ?>
						<?php } ?>
					</div>
					<?php if ($arrSkillChild) {
					foreach ($arrSkillChild as $key => $skilltest) { ?>
					<div class="row box_mini_test">
						<div class="title">
						     <h2><?php echo $skilltest['name']?></h2>
							 <p>Chọn skill bạn muốn test để bắt đầu</p>
						</div>
						<?php foreach($skilltest['child'] as $child){?>
						     <div class="col-md-<?php echo ($colType == 1) ? 6 : 12; ?>">
							    <ul class="list_test">
									 <li><div class="gray"><a href="<?php echo SITE_URL . $child['share_url'] ?>"><?php echo $child['name'];?></a></div></li> 
								</ul>
							 </div>  
						<?php } ?>	
						<!--<div class="col-md-6">
						    <ul class="list_test">
								 <li><div class="gray"><a href="javascript:void(0)">Hướng dẫn làm bài</a></div></li> 
							</ul>
					 	</div>--> 					 
					</div>
					<?php } ?>
					<?php } ?>
				</div>
			</div>
		<?php $i++; } ?>
		</div>
	<?php } ?>
	<div class="text-right">
		<div class="fb-like" data-href="<?php echo current_url(); ?>" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="true"></div>
	</div>
	<?php echo $this->load->get_block('content'); ?> 
 	
</div> 





<section class="container clearfix m_height">
    <div class="row">
        <div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12">
            <div class="warp_bg mb20">
                <?php echo $this->load->view('common/breadcrumb');?>
                <div class="infomation">
                  <img class="ava" src="images/graphics/thumb_5x4.jpg" alt="">
                  <div class="content">
                    <h1>IELTS Fighter test1 - December</h1>
                    <p>Biên soạn bởi Aland English - Expert in IELTS</p>
                    <div class="date">
                      <p><i class="fa fa-calendar"></i>Ngày đăng: 22/11/2018</p>
                      <p><i class="fa fa-file-text-o"></i>Số lần test: 100</p>
                      <p><i class="fa fa-file-zip-o"></i>Người tạo: Aland IELTS</p>
                    </div>                        
                  </div>                        
                </div>
                <div class="practice_test">
                    <h2>Practice Test 1</h2>
                    <div class="wrap">
                        <div class="test_icon">
                          <div class="auto">
                            <a href=""><img src="images/icons/icon-book.png" alt=""></a>
                            <a href=""><img src="images/icons/icon-headphone.png" alt=""></a>
                            <a href=""><img src="images/icons/icon-pencil.png" alt=""></a>
                            <a href=""><img src="images/icons/icon-microphone.png" alt=""></a>
                            <h3>Full Test</h3>
                          </div>  
                        </div>
                        <div class="full_test">
                            <div class="item done">
                                <img src="images/icons/book1.png" alt="">
                                <a href="">reading</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/headphone.png" alt="">
                                <a href="">listening</a>
                            </div>
                            <div class="item done">
                                <img src="images/icons/pencil1.png" alt="">
                                <a href="">writing</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/microphone.png" alt="">
                                <a href="">speaking</a>
                            </div>                                
                        </div>
                    </div>
                </div>
                <div class="practice_test">
                    <h2>Practice Test 2</h2>
                    <div class="wrap">
                        <div class="test_icon">
                          <div class="auto">
                            <a class="done" href=""><img src="images/icons/icon-book1.png" alt=""></a>
                            <a class="done" href=""><img src="images/icons/icon-headphone1.png" alt=""></a>
                            <a class="done" href=""><img src="images/icons/icon-pencil1.png" alt=""></a>
                            <a class="done" href=""><img src="images/icons/icon-microphone1.png" alt=""></a>
                            <h3 class="done">Full Test</h3>
                          </div>  
                        </div>
                        <div class="full_test">
                            <div class="item">
                                <img src="images/icons/book.png" alt="">
                                <a href="">reading</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/headphone.png" alt="">
                                <a href="">listening</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/pencil.png" alt="">
                                <a href="">writing</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/microphone.png" alt="">
                                <a href="">speaking</a>
                            </div>                                
                        </div>
                    </div>
                </div>
                <div class="practice_test">
                    <h2>Practice Test 3</h2>
                    <div class="wrap">
                        <div class="test_icon">
                          <div class="auto">
                            <a href=""><img src="images/icons/icon-book.png" alt=""></a>
                            <a href=""><img src="images/icons/icon-headphone.png" alt=""></a>
                            <a href=""><img src="images/icons/icon-pencil.png" alt=""></a>
                            <a href=""><img src="images/icons/icon-microphone.png" alt=""></a>
                            <h3>Full Test</h3>
                          </div>  
                        </div>
                        <div class="full_test">
                            <div class="item">
                                <img src="images/icons/book.png" alt="">
                                <a href="">reading</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/headphone.png" alt="">
                                <a href="">listening</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/pencil.png" alt="">
                                <a href="">writing</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/microphone.png" alt="">
                                <a href="">speaking</a>
                            </div>                                
                        </div>
                    </div>
                </div>
                <div class="practice_test">
                    <h2>Practice Test 4</h2>
                    <div class="wrap">
                        <div class="test_icon">
                          <div class="auto">
                            <a href=""><img src="images/icons/icon-book.png" alt=""></a>
                            <a href=""><img src="images/icons/icon-headphone.png" alt=""></a>
                            <a href=""><img src="images/icons/icon-pencil.png" alt=""></a>
                            <a href=""><img src="images/icons/icon-microphone.png" alt=""></a>
                            <h3>Full Test</h3>
                          </div>  
                        </div>
                        <div class="full_test">
                            <div class="item">
                                <img src="images/icons/book.png" alt="">
                                <a href="">reading</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/headphone.png" alt="">
                                <a href="">listening</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/pencil.png" alt="">
                                <a href="">writing</a>
                            </div>
                            <div class="item">
                                <img src="images/icons/microphone.png" alt="">
                                <a href="">speaking</a>
                            </div>                                
                        </div>
                    </div>
                    <div class="load-more center"><a class="btn" href="">Xem thêm</a></div>
                </div>
            </div>
        </div>

        <div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12 mb20">
          <div class="category">
            <h2 class="title_bg">
              <a href="">TƯ VẤN LỘ TRÌNH HỌC<span>MIỄN PHÍ</span></a>
            </h2>
            <div class="vote">
                <div class="item">
                    <a href="">
                      <span class="thumb_img thumb_5x5"><img title="" src="images/graphics/thumb_5x3.jpg" alt=""></span>
                    </a>  
                    <p>9.0</p>
                    <p>Reading</p>
                </div>
                <div class="item">
                    <a href="">
                      <span class="thumb_img thumb_5x5"><img title="" src="images/graphics/thumb_5x3.jpg" alt=""></span>
                    </a>  
                    <p>9.0</p>
                    <p>Reading</p>
                </div>
                <div class="item">
                    <a href="">
                      <span class="thumb_img thumb_5x5"><img title="" src="images/graphics/thumb_5x3.jpg" alt=""></span>
                    </a>  
                    <p>9.0</p>
                    <p>Reading</p>
                </div>
                <div class="item">
                    <a href="">
                      <span class="thumb_img thumb_5x5"><img title="" src="images/graphics/thumb_5x3.jpg" alt=""></span>
                    </a>  
                    <p>9.0</p>
                    <p>Reading</p>
                </div>                                        
            </div>
            <form>
              <div class="form-group">
                <input type="name" placeholder="Họ và tên" class="form-control">
              </div>                    
              <div class="form-group">
                <input type="name" placeholder="Số điện thoại" class="form-control">
              </div>
              <div class="form-group">
                <select class="form-control">
                  <option>Địa chỉ</option>
                  <option>Hà Nội</option>
                  <option>TP Hồ Chí Minh</option>
                </select>
              </div>
              <button type="submit" class="btn btn-default">Đăng ký tư vấn</button>                    
            </form>                                
          </div>
          <div class="warp_bg category box_lienket">
            <h2 class="title_left">Liên kết nhanh</h2>
            <a href="" class="next_slide"><i class="fa fa-angle-right"></i></a>
            <ul>
              <li><a href=""><i class="icon icon-5"></i>LKG tại Hà Nội</a></li>
              <li><a href=""><i class="icon icon-5"></i>LKG tại Tp. Hồ Chí Minh</a></li>
              <li><a href=""><i class="icon icon-5"></i>LKG tại Đà Nẵng</a></li>
              <li><a href=""><i class="icon icon-6"></i>Lộ trình tự học IELTS 8.0</a></li>
            </ul>
          </div>
          <div class="warp_bg category slide_book">
              <div class="tab">
                  <a class="active" href="">Sách phù hợp với bạn</a>
                  <a href="">Test phù hợp với bạn</a>
              </div>
              <div class="owl-carousel">
                <div class="img_box">
                  <a href=""><img title="" src="images/graphics/book1.jpg" alt=""></a>
                </div>
                <div class="img_box">
                  <a href=""><img title="" src="images/graphics/book1.jpg" alt=""></a>
                </div>                    
                <div class="img_box">
                  <a href=""><img title="" src="images/graphics/book1.jpg" alt=""></a>
                </div>
              </div>
          </div>              
          <div class="ads category center">
             <img title="" src="images/graphics/ads.jpg" alt=""> 
          </div>  
        </div>
    </div>
    <!-- TIN QUAN TÂM --> 
    <div class="warp_bg mb20 art_other grid4">
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
                    <span class="thumb_img thumb_5x5"><img title="" src="images/graphics/book1.jpg" alt=""></span>
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
                    <span class="thumb_img thumb_5x5"><img title="" src="images/graphics/book1.jpg" alt=""></span>
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
                    <span class="thumb_img thumb_5x5"><img title="" src="images/graphics/book1.jpg" alt=""></span>
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
                    <span class="thumb_img thumb_5x5"><img title="" src="images/graphics/book1.jpg" alt=""></span>
                  </a>
                </div>
                <div class="content">
                  <h3><a href="#" title="">IELTS Fighter test1</a></h3>  
                  <p>Reading</p>
                </div>
              </div>                                                
          </div>                                                
        </div>                     
      </div>        
    <div class="warp_bg document_ielts new mb20">
      <h2 class="title_box_category"><i class="icon icon-document"></i>TÀI LIỆU LUYỆN THI IELTS</h2>
      <div class="nav_category">
        <a class="active" href="">Reading</a>
        <a href="">Listening</a>
        <a href="">Speaking</a>
        <a href="">Writing</a>
      </div>
      <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-4 col-tn-12">
          <div class="warp">
            <h3><span>Tài liệu luyện thi IELTS</span></h3>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
          </div>
        </div>            
        <div class="col-md-4 col-sm-4 col-xs-4 col-tn-12">
          <div class="warp">
            <h3><span>Tài liệu Ngữ pháp</span></h3>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
            <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4 col-tn-12">
          <div class="warp">
              <h3><span>Tài liệu Từ Vựng</span></h3>
              <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
              <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
              <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
              <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
              <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
              <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
              <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
              <a href=""><i class="fa fa-chevron-circle-right"></i>Review chi tiết về cuốn - IELTS WRITING Recent Actual Tests</a>
          </div>
        </div>
      </div>
    </div>           
</section>