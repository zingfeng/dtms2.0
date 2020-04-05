<?php if ($params['title']) { ?>
<div class="title-header-bl"><h2><?php echo $block['name'] ?></h2></div>
<?php } ?>
<div class="row">
    <div class="col-md-12" data-wow-delay="0.2s">
        <div class="carousel slide" data-ride="carousel" id="quote-carousel">
            <!-- Bottom Carousel Indicators -->
            <ol class="carousel-indicators">
                <?php $i =0; foreach ($rows as $row){?>
                <li data-target="#quote-carousel" data-slide-to="<?php echo $i;?>" class="<?php echo ($i == 0) ? "active":"";?>">
                    <a href="<?php echo $row['share_url']?>" title="Đội ngũ sứ giả">
                        <img src="<?php echo getimglink($row['images'],'size2',3);?>" alt="">
                    </a>
                </li>
                <?php $i++;}?>
            </ol>

            <!-- Carousel Slides / Quotes -->
            <div class="carousel-inner">
                <?php $i =1; foreach ($rows as $row){ $title = explode('-',$row['title']);?>
                <div class="item <?php echo ($i == 1) ? "active":"";?>">
                    <blockquote>
                        <div class="bg-blockquote">
							<p><?php echo $row['description'];?></p>
							<small>
                                <b>
                                    <a href="<?php echo $row['share_url']?>" title="<?php echo $title[0];?>"><?php echo $title[0];?></a>
                                </b><br>
                                <?php echo $title[1];?>
                            </small>
						</div>
                    </blockquote>
                </div>
                <?php $i++;}?>
            </div>

            <!-- Carousel Buttons Next/Prev -->
            <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-angle-left"></i></a>
            <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-angle-right"></i></a>
        </div>
    </div>
</div>

<style type="text/css">
    #quote-carousel .carousel-control{height: 50px;}
</style>