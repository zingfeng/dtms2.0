<div class="container">
	<div class="row"> 
		<div class="bghead">
			<ul id="main-menu-f" class="sm sm-clean">
				<?php foreach ($rows as $row){?>
				<li>
					<a <?php if (in_array($row['menu_id'], $menuSelected)) echo 'class="active"'; ?> href="<?php echo $row['link'] ?>"><?php echo ($row['item_mod'] != 'home') ? $row['name'] : "<i class='fa fa-home'></i>"; ?></a>
					<?php if ($row['child']){ ?>
					<ul>
						 <?php foreach ($row['child'] as $child) { ?>
                            <li><a href="<?php echo $child['link'] ?>"><?php echo $child['name']; ?></a></li>
                            <?php } ?>
					</ul>
					<?php }?>
				</li> 
				<?php }?>
			</ul><!-- /.nav -->
		</div><!-- /.navbar-collapse -->
	</div>     
</div><!-- /.container -->  