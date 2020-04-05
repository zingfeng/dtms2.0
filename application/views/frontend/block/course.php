<!-- <section class="container clearfix"> -->
    <div class="learn_ielts">
        <h2 class="title_box_category"><i class="icon icon-tivi"></i><?php echo $block['name']?></h2>
        <div class="item left">
            <img src="<?php echo $this->config->item('img');?>graphics/ads_kh.jpg" alt="<?php echo $first['title']?>" style="border-radius: 10px">
        </div>
        <?php if($rows) { ?>
        <div class="right">
            <?php
            if ($this->agent->is_mobile()){
                $i_max = 4; // tối đa 4 block trên mobile
            }else{
                $i_max = 6; // tối đa 6 block trên PC
            }
            $i_max = 6;
            $i_ = 1;
            foreach($rows as $row) {
                if ($i_ > $i_max){
                    break;
                }
                ?>
            <div class="item">
                <a href="<?php echo $row['share_url']?>" title="<?php echo $row['title']?>">
                    <h4>
                        <strong><?php echo $row['title']?></strong>
                        <?php if($teacher[$row['course_id']]) { ?>
                            <?php foreach($teacher[$row['course_id']] as $teacher) { ?>
                                <span><?php echo $teacher['teacher_name']?></span>
                            <?php } ?>
                        <?php } ?>
                    </h4>
                    <img src="<?php echo getimglink($row['images'],'size8', 3);?>" alt="this">
                    <span class="icon icon-videofree"></span>
                </a>
            </div>
            <?php
                $i_ ++ ;
            } ?>
        </div>
        <?php } ?>
    </div>
<!-- </section>  -->