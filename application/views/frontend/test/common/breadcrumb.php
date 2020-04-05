<section class="section-breadcrumb margin-navbar">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="custom-breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL;?>">Trang chủ</a></li>
			    <?php foreach($this->config->item('breadcrumb') as $breadcrumb){?>
				    <?php if($breadcrumb['link']){?>
				    	<li class="breadcrumb-item"><a href="<?php echo $breadcrumb['link'];?>"><?php echo $breadcrumb['name'];?></a></li>
				    <?php } else {?>
				    	<li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['name'];?></li>
				    <?php }?>
			    <?php }?>
            </ol>
        </nav>
    </div>
</section>