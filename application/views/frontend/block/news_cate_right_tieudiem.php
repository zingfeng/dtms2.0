<div class="sidebar-block"> 
    <div class="title-header-bl"><h2><?php echo $block['name'] ?></h2><span><i class="fa fa-angle-right arow"></i></span></div>
    <ul class="news-sidebar">   
        <?php $i =1; foreach ($rows as $row){?>
        <li>
             <a href="<?php echo $row['share_url']; ?>" title="<?php echo $row['title']; ?>"><img alt="<?php echo $row['title']; ?>" title="<?php echo $row['title']; ?>" src="<?php echo getimglink($row['images'],'size3');?>"></a>
             <a href="<?php echo $row['share_url']; ?>" class="title" title="<?php echo $row['title']; ?>"><?php echo $row['title']; ?></a>
		     <p>
                <?php echo $row['description']; ?>
                <!-- <a href="<?php echo $row['title']; ?>">đọc thêm</a> -->
            </p>
        </li>
        <?php $i++;}?>
    </ul>
</div><!--End-->