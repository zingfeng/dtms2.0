<!--MAIN MENU-->
    <nav id="main_menu" class="main_menu">   
       <div class="header_menu section">
           <span id="auto_close_left_menu_button" class="close_main_menu">×</span>   
           <div class="my_contact">
            <p><i class="fa fa-phone"></i><a style="color:#ff3333;font-weight:bold" href="tel:<?php echo $this->config->item("hotline"); ?>"><?php echo $this->config->item("hotline"); ?></a></p>
            <p class="email"><a href="mailto:<?php echo $this->config->item("email_support"); ?>"><i class="fa fa-envelope-o"></i><?php echo $this->config->item("email_support"); ?></a></p>
          </div>                  
       </div>
      <div class="block_scoll_menu section">
         <div class="block_search section">
            <form id="search" action="/news/search" method="get">
               <div class="warp">
                  <input id="auto_search_textbox" maxlength="80" name="keyword" class="input_form" placeholder="Tìm kiếm" type="search">
                  <button type="submit" id="btn_search_ns" class="btn_search"><i class="fa fa-search"></i></button>
                  <button type="reset" class="btn_reset">×</button>
               </div>
            </form>
         </div>
         <div class="list_menu section" id="auto_footer_menu">
            <?php echo $this->load->get_block('menu_mobile'); ?>
            
         </div>            
         <div class="footer_bottom">         
            <div class="bold_text_top width_common"><h3>Học tiếng anh trực tuyến<br>© 2018 aland.net</h3>
                <p>Trực thuộc công ty cổ phần giáo dục và đào tạo Imap Việt Nam</p>
                <div class="social">
                  <a href=""><i class="fa fa-facebook"></i></a>
                  <a href=""><i class="fa fa-google-plus"></i></a>
                  <a href=""><i class="fa fa-youtube-play"></i></a>
                </div>                
            </div>
        </div>                              
      </div>
    </nav>
    <!--END MAIN MENU-->   