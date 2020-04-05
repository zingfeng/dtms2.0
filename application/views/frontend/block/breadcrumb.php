<ul class="breadcrumbs">
    <li><a href="<?php echo BASE_URL ?>"><i class="fa fa-folder-open"></i>Trang chủ</a></li>
    <?php foreach ($rows as $row) { ?>
        <li><i class="fa fa-angle-double-right"></i>
            <a href="<?php echo (!$row['link'])? 'javascript:void(0)' : $row['link']?>" class="<?php echo end($rows) == $row ? 'active' : ''?>"><?php echo $row['name'] ?></a>
        </li>
    <?php } ?>
</ul><!-- /.End -->   