<ul class="list_item_panel section" id="auto_footer_first_list">
    <?php 
    foreach ($rows as $row){?>
    <li>
      <a href="<?php echo $row['link'] ?>" target="<?php echo $row['target']; ?>" class="link_item_panel"><?php echo $row['name'] ?></a>
      <?php if ($row['child']) { ?>
      <span class="sub-icon">+</span>
      <ul class="level2">
          <?php foreach ($row['child'] as $child) { ?>
         <li>
            <a href="<?php echo $child['link'] ?>"><?php echo $child['name']; ?></a>
            <?php if ($child['child']) { ?>
            <span class="sub-icon2">+</span> 
            <ul class="level3">
                <?php foreach ($child['child'] as $sub) { ?>
                    <li>
                        <a href="<?php echo $sub['link'] ?>"><?php echo $sub['name']; ?></a>
                    </li>
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