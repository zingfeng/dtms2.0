<div class="profile-user row"> 
	<div class="col-md-8 col-sm-8">
	    <div class="profile-content">
	    <ul class="breadcrumbs">
			<li><i class="fa fa-folder-open"></i><a href="#">Trang chủ</a></li> 
			<li><i class="fa fa-angle-double-right"></i> <a class="active" href="javascript:void(0)">Bài tập lớp</a></li>
		</ul><!-- /.End -->   
		
		<div class="col_box_btl">
		    <div class="row">
			    <a href="<?php echo SITE_URL; ?>/chia-se-lop-hoc.html" class="title_test">FILE NGHE & TAPESCRIPT</a>
			    <div class="col-md-6"> 
				    <div class="row box_mini_test">
						<div class="col-md-12">
						    <div class="title">
								 <h2>BÀI TẬP LUYỆN THÊM</h2>
								 <p>Chọn skill để bắt đầu</p>
							</div>
						</div> 	
					</div>	
				    <ul class="list_test">
						 <li><div><a href="<?php echo SITE_URL; ?>/test/class_list/1">Listening & Reading</a></div></li> 
					</ul>   
			    </div>	 
                <div class="col-md-6"> 
				    <div class="row box_mini_test">
						<div class="col-md-12">
						    <div class="title">
								 <h2>ACTUAL TEST</h2>
								 <p>Chọn skill để bắt đầu</p>
							</div>
						</div> 	
					</div>	
				    <ul class="list_test">
						 <li><div><a href="<?php echo SITE_URL; ?>/test/class_list/1/2">Listening & Reading</a></div></li> 
						 <li><div><a href="<?php echo SITE_URL; ?>/test/class_list/2/2">Writing</a></div></li>
						 <li><div><a href="javascript:alert('Chức năng này hiện đang được update. Vui lòng quay lại sau')">Speaking</a></div></li>
						 
					</ul> 
			    </div>	 
			</div>
		</div><!-- End -->
		
		<div class="panel-group" id="accordion">
			<div class="panel panel-toeic">
			  <div class="panel-heading">
				<h4 data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title expand">
				   <div class="right-arrow pull-left">-</div>
				   <a href="<?php echo SITE_URL; ?>/chia-se-lop-hoc.html">Chia sẻ lớp học</a>
				</h4>
			  </div>
			  <div id="collapse1" class="panel-collapse collapse in">
				<div class="panel-body">
				    <ul class="faq-toeic">
				    	<?php foreach($arrNews as $item){?>
						<li>
							<a href="<?php echo $item['share_url'];?>" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a>
						</li>
						<?php } ?>
					</ul>
				</div>
			  </div>
			</div>
        </div> <!-- End -->
		<?php if ($arrVideo) { ?>
		<div class="row"> 
		    <h1 class="col-md-12 title-list-video">Video đề xuất</h1>
			<ul class="list-video">
				<?php foreach($arrVideo as $item){?>
				<li>
					<div class="shadow">
						<div class="image">
							<div class="overlay"> 
								<div class="view-wrap">
								  <div class="view">
									<a class="shape"><i class="fa fa-play"></i></a>
								  </div>
								</div><!-- /.view-wrap -->
							</div><!-- /.overlay -->
							<figure><img src="<?php echo getimglink($item['images'],'size4');?>" alt=""></figure>
						</div>
						<div class="caption">
							<h2><a href="<?php echo $item['share_url'];?>" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a></h2>
						</div>
					</div>	
				</li>
				<?php } ?>
			</ul>
		</div><!-- End -->
		<?php } ?>
		<?php echo $this->load->get_block('content'); ?> 
	    </div> 
	</div> 
	
	<div class="col-md-4 col-sm-4">
		<?php echo $this->load->view('test/block/right_class_name',array('row' => $classDetail)); ?>
		<?php echo $this->load->get_block('right'); ?>
	</div>
</div>