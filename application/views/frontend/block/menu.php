<nav id="main_menu_pc" class="">
     <div class="container">
        <ul>
            <li class="home"><a href="<?php echo SITE_URL; ?>" title="Trang chủ"><i class="fa fa-home"></i></a></li>
            <?php foreach ($rows as $row){?>
            <li>
              <a href="<?php echo $row['link'] ?>" title="<?php echo $row['name'] ?>" <?php echo $row['hot'] ? 'style="background: #f45b69; padding-left: 10px;" ': ''?>><?php echo $row['name'] ?></a>
              <?php if ($row['child']) { ?>
              <span class="sub-icon"><i class="fa fa-caret-down"></i></span>
              <ul class="level2">
                    <?php foreach ($row['child'] as $child) { ?>
                    <li>
                    <a href="<?php echo $child['link'] ?>" title="<?php echo $child['name']; ?>"><?php echo $child['name']; ?></a>
                    <?php if ($child['child']) { ?>
                    <span class="sub-icon"><i class="fa fa-caret-right"></i></span>
                    <ul class="level3">
                        <?php foreach ($child['child'] as $sub) { ?>
                      <li><a href="<?php echo $sub['link'] ?>" title="<?php echo $sub['name']; ?>"><?php echo $sub['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                  </li>
                  <?php } ?>
              </ul>

                <?php } ?>
            </li>
            <?php } ?>
        </ul>
    </div>
</nav>