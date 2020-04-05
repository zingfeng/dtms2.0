<?php foreach ($rows as $row){?>
	<div class="box_quangcao margin_25 width_100" style="text-align: center; margin-top: 10px">
        <a href="<?php echo site_url($row['link']) ?>"><img src="<?php echo getimglink($row['images']) ?>" alt="<?php echo $row['name'] ?>" class="img-responsive"></a> 
    </div>
<?php } ?>