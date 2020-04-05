<?php 
	$first = array_shift($rows);
?>

<div class="box_folder_nth">
    <h2>Folder niềm tự hào <a href="<?php echo $cateDetail['share_url']?>" title="<?php echo $cateDetail['name']?>"><i class="fa fa-angle-right"></i></a></h2>
	<div class="item item-big">
		<a href="<?php echo $first['share_url']?>" class="thumb" title="<?php echo $first['title']?>">
			<img src="<?php echo getimglink($first['images'],'size3',3) ?>" alt="<?php echo $first['title']?>" title="<?php echo $first['title']?>"  >
		</a>
		<div class="item-caption">
			<h3><a href="<?php echo $first['share_url']?>" title="<?php echo $first['title']?>"><?php echo $first['title']?></a></h3>
			<p class="user"><?php echo $first['description']?></p> 
		</div>
		<div class="item-position"><?php echo $first['score']?><span>TOEIC</span></div> 
	</div>
	
	<?php if($rows) { ?>
		<?php foreach($rows as $key => $row) { ?>
		<?php switch ($key) {
			case 0:
				$class_top = 'top1';
				break;
			case 1:
				$class_top = 'top2';
				break;
			case 2:
				$class_top = 'top3';
				break;
			default:
				$class_top = '';
				break;
		}?>
		<div class="item">
			<div class="item-caption">
				<h3><a href="<?php echo $row['share_url']?>" title="<?php echo $row['title']?>"><?php echo $row['title']?></a></h3>
				<p class="user"><?php echo $row['description']?></p>
			</div>
			<div class="item-position <?php echo $class_top?>"><?php echo $row['score']?> <span>TOEIC</span></div>
		</div>
		<?php } ?>
	<?php } ?>
    <div class="view_all"><a href="<?php echo $cateDetail['share_url']?>" title="<?php echo $cateDetail['name']?>">Xem thêm học viên điểm cao >></a></div>
</div><!--End-->


<div class="goc_kn category">
		<h2 class="title_left"><?php echo $block['name'] ?></h2>
		<a href="" class="next_slide"><i class="fa fa-angle-right"></i></a>
		<img title="" src="images/graphics/kinhnghiem.jpg" alt="">
		<div class="warp">
			<?php foreach($rows as $key => $row) { ?>
		  <div class="item active">
			  <div class="left">
				  <strong>8.5</strong>
				  <span>IELTS</span>
			  </div>
			  <p><?php echo $row['description']; ?></p>
		  </div>
		<?php } ?>
		  <div class="item">
			  <div class="left">
				  <strong>8.5</strong>
				  <span>IELTS</span>
			  </div>
			  <p>Mai Linh (8.5 IELTS) chia sẻ kinh nghiệm đạt điểm tuyệt đối Listeing và Reading</p>
		  </div>                    
		  <div class="item">
			  <div class="left">
				  <strong>8.5</strong>
				  <span>IELTS</span>
			  </div>
			  <p>Mai Linh (8.5 IELTS) chia sẻ kinh nghiệm đạt điểm tuyệt đối Listeing và Reading</p>
		  </div>                    
		  <div class="item">
			  <div class="left">
				  <strong>8.5</strong>
				  <span>IELTS</span>
			  </div>
			  <p>Mai Linh (8.5 IELTS) chia sẻ kinh nghiệm đạt điểm tuyệt đối Listeing và Reading</p>
		  </div>
		  <a class="view-more" href="">Xem thêm &nbsp;<i class="fa fa-long-arrow-right"></i></a>         
		</div>                    
	</div>
</div>