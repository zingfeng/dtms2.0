<div class="tai_lieu category">
	<h2 class="sub_title">Tài liệu bổ trợ</h2>
	<ul>
		<?php foreach($rows as $row) { ?>
		<li>
			<a href="<?php echo $row['share_url']?>" title="<?php echo $row['title']?>"><?php echo $row['title']?></a>
		</li>     
		<?php } ?>                                                        
	</ul>
</div>