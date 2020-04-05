<?php

?>
<header class="comment-header">
    <div class="show-more-comment">
<!--        <a href="" class="show-more-comment">Xem các bình luận trước</a>-->
    </div>
    <div class="total-comment"><?php echo $info; ?> Bình luận
    </div>
</header>
<section class="comment-list">
    <div id="comment-list-target-<?php echo $target_id; ?>-type-<?php echo $type; ?>">
<!--Comment LV1 -->
<?php
    $arr_comment_lv1 = $list;
    for ($i = 0; $i < count($arr_comment_lv1); $i++) {
        $mono_comment_lv1 = $arr_comment_lv1[$i];
        $content    = $mono_comment_lv1['content'];
        $cmt_id     = $mono_comment_lv1['comment_id'];
        $avatar     = $mono_comment_lv1['avatar'];
        $time     = $mono_comment_lv1['creat_time'];
        $liked_lv1 = $mono_comment_lv1['liked'];
        $deltatime = getDeltaTimeTillNow($time);
        $user_id = $mono_comment_lv1['user_id'];

        $this->db->where('user_id',$user_id);
        $this->db->select('fullname');
        $query = $this->db->get('users');
        $arr_res = $query->result_array();
        $username = $arr_res[0]['fullname'];
        $char_avar = strtoupper(mb_substr($username,0,1, "utf-8"));




        $content_short = cut_text($content, 300);
        $content_short_show = cut_text($content, 200);

        ?>
            <div id="comment-block-lv1-<?php echo $cmt_id; ?>" >
                <div class="comment-block" >
<!--                    <figure class="comment-block__avatar -color-random---><?php //echo (toNumber($char_avar) % 5) + 1; ?><!--">-->
<!--                        <figcaption class="text-avatar">--><?php //echo $char_avar;?><!--</figcaption>-->
<!--                    </figure>-->
                    <div>
                        <img class="comment-block__avatar"  src="<?php echo $avatar;?>" alt="">
                    </div>

                    <div class="comment-block__content">
                        <div class="user-comment">
                            <form class="user-comment__text">
                                <p class="text-content">

                                    <span class="username"><?php echo $username;?></span>
                                    <?php  if ($content_short != $content){?>
                                    <span id="content_short<?php echo $cmt_id;?>"><?php echo $content_short_show;?></span>
                                    <span cmt_id="<?php echo $cmt_id; ?>" class="showtext-more showtext-more-comment"><a cmt_id="<?php echo $cmt_id; ?>" class="btn_see_more" href="javascript:void(0)">Xem thêm</a></span>
                                    <span id="content<?php echo $cmt_id;?>" style="display:none"><?php echo $content;?></span>
                                    <?php } else { ?>
                                        <span id="content<?php echo $cmt_id;?>" style=""><?php echo $content;?></span>
                                    <?php } ?>

                                </p>
                            </form>

                            <?php

                                if ($user_id == $my_userid){
                                    ?>
                                    <div class="user-comment__btn-more">
                                        <a href="javascript:void(0)" class="button-more" onclick="showDropdownCommentOption(<?php echo $cmt_id; ?>)"><span class="icon-baseline-more_horiz-24px-1"></span></a>
                                        <ul class="dropdown-comment-option" id="DropdownComment<?php echo $cmt_id; ?>">
                                            <li onclick="ClickDelComment(<?php echo $cmt_id; ?>,1)"  class="menu_comment">
                                                <a href="javascript:void(0)" class="link-items special-option">
                                                    Xóa bình luận
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php
                                }
                            ?>


                        </div>
                        <div class="button">
                            <div class="button__like-reply-time">
                                <?php
                                if ($liked_lv1){?>
                                    <a href="javascript:void(0)" class="button-action custom-margin btn_like_cmt" cmt_id="<?php echo $cmt_id; ?>" style="font-weight: bold">Đã thích</a>
                                <?php }else{ ?>
                                    <a href="javascript:void(0)" class="button-action custom-margin btn_like_cmt" cmt_id="<?php echo $cmt_id; ?>">Thích</a>
                                <?php }
                                ?>

                                <a cmt_id="<?php echo $cmt_id;?>"  level="1"  target_id="<?php echo $target_id; ?>"  type="<?php echo $type; ?>"   href="" class="button-action custom-margin btn_reply">Trả lời</a>
                                <span class="date-comment custom-margin"><?php echo $deltatime;?></span>
                            </div>
                        </div>
                    </div>
                </div>

<?php
                $arr_comment_lv2 = $mono_comment_lv1['lv2'];
//                var_dump($arr_comment_lv2);

                for ($k = 0; $k < count($arr_comment_lv2); $k++) {
                    $arr_comment_lv2_mono = $arr_comment_lv2[$k];
                    $content    = $arr_comment_lv2_mono['content'];
                    $cmt_id_lv2     = $arr_comment_lv2_mono['comment_id'];
                    $avatar     = $arr_comment_lv2_mono['avatar'];
                    $time     = $arr_comment_lv2_mono['creat_time'];
                    $liked     = $arr_comment_lv2_mono['liked'];
                    $deltatime = getDeltaTimeTillNow($time);
                    $user_id = $arr_comment_lv2_mono['user_id'];
                    $this->db->where('user_id',$user_id);
                    $this->db->select('fullname');
                    $query = $this->db->get('users');
                    $arr_res = $query->result_array();
                    $username = $arr_res[0]['fullname'];
                    $char_avar = strtoupper(mb_substr($username,0,1, "utf-8"));


//                    $content_short = word_limiter($content, 200);
                    $content_short = cut_text($content, 300);
                    $content_short_show = cut_text($content, 200);

                    $btn_show_more = '<span cmt_id="<?php echo $cmt_id; ?>" class="showtext-more showtext-more-comment"><a href="">Xem thêm</a></span>';


                    ?>

                    <div class="comment-block -comment-reply" id="-comment-reply-<?php echo $cmt_id_lv2;?>">
<!--                        <figure class="comment-block__avatar -color-random---><?php //echo (toNumber($char_avar) % 5) + 1; ?><!--  -comment-reply">-->
<!--                            <figcaption class="text-avatar -comment-reply">--><?php //echo $char_avar; ?><!--</figcaption>-->
<!--                        </figure>-->
                        <div>
                            <img class="comment-block__avatar" src="<?php echo $avatar; ?>" alt="">
                        </div>

                        <div class="comment-block__content">
                            <div class="user-comment">
                                <form class="user-comment__text -comment-reply">
                                    <p class="text-content">
                                        <span class="username"><?php echo $username; ?></span>

                                        <?php  if ($content_short != $content){?>
                                            <span id="content_short<?php echo $cmt_id_lv2;?>"><?php echo $content_short_show;?></span>
                                            <span cmt_id="<?php echo $cmt_id_lv2; ?>" class="showtext-more showtext-more-comment"><a cmt_id="<?php echo $cmt_id_lv2; ?>" class="btn_see_more" href="javascript:void(0)">Xem thêm</a></span>
                                            <span id="content<?php echo $cmt_id_lv2;?>" style="display:none"><?php echo $content;?></span>
                                        <?php } else { ?>
                                            <span id="content<?php echo $cmt_id_lv2;?>" style=""><?php echo $content;?></span>
                                        <?php } ?>

                                    </p>
                                </form>
                                <?php

                                if ($user_id == $my_userid){
                                    ?>
                                    <div class="user-comment__btn-more">
                                        <a href="javascript:void(0)" class="button-more" onclick="showDropdownCommentOption(<?php echo $cmt_id_lv2; ?>)"><span class="icon-baseline-more_horiz-24px-1"></span></a>
                                        <ul class="dropdown-comment-option" id="DropdownComment<?php echo $cmt_id_lv2; ?>" >
                                            <li onclick="ClickDelComment(<?php echo $cmt_id_lv2; ?>,2)" class="menu_comment">
                                                <a href="javascript:void(0)" class="link-items special-option">
                                                    Xóa bình luận
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>



                            </div>
                            <div class="button">
                                <div class="button__like-reply-time">
                                    <?php
                                        if ($liked){?>
                                            <a href="" class="button-action custom-margin btn_like_cmt" cmt_id="<?php echo $cmt_id_lv2; ?>" style="font-weight: bold">Đã thích</a>
                                       <?php }else{ ?>
                                            <a href="" class="button-action custom-margin btn_like_cmt" cmt_id="<?php echo $cmt_id_lv2; ?>">Thích</a>
                                        <?php }
                                    ?>

                                    <a href=""  level="2"  cmt_id="<?php echo $cmt_id; ?>"  class="button-action custom-margin btn_reply">Trả lời</a>
                                    <span class="date-comment custom-margin"><?php echo $deltatime; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

<?php      }  ?>

            </div>
        <!--        insert cmt lv2          -->
        <div class="comment-block -comment-reply -custom-answer" id="-comment-reply-<?php echo $cmt_id; ?>"   <?php if (is_null($my_userid)) echo ' style="display:none;" ' ?>  >
<!--            <figure class="comment-block__avatar -color-random---><?php //echo (toNumber($my_char_avar) % 5) + 1; ?><!--  -comment-reply">-->
<!--                <figcaption class="text-avatar -comment-reply">--><?php //echo $my_char_avar; ?><!--</figcaption>-->
<!--            </figure>-->
            <div>
                <img class="comment-block__avatar" src="<?php  echo $my_avatar; ?>" alt="">
            </div>

            <div class="comment-block__content">
                <div class="user-comment">
                    <form class="user-comment__text -custom-answer">
                        <div id="insert-cmt-<?php echo $cmt_id; ?>" cmt_id="<?php echo $cmt_id; ?>" color="<?php echo (toNumber($my_char_avar) % 5) + 1; ?>"  my_avatar="<?php echo $my_avatar; ?>"   my_char_avar="<?php echo $my_char_avar; ?>"   my_username="<?php echo $my_username; ?>"  parent_id="<?php echo $cmt_id; ?>" level="2"  target_id="<?php echo $target_id; ?>"  type="<?php echo $type; ?>"  class="text-content -custom-answer insert_cmt" contenteditable="true" placeholder=" Viết phản hồi..." spellcheck="false"></div>
                    </form>
                    <div class="user-comment__btn-more">
                        <a href="" class="button-more">
                            <span class="icon-baseline-more_horiz-24px-1"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--   -->

<?php } ?>

    </div>

<!--insert cmt lv1-->
<div class="comment-block" <?php if (is_null($my_userid)) echo ' style="display:none;" ' ?>>
<!--    <figure class="comment-block__avatar -color-random---><?php //echo (toNumber($my_char_avar) % 5) + 1; ?><!--">-->
<!--        <figcaption class="text-avatar">--><?php //echo $my_char_avar; ?><!--</figcaption>-->
<!--    </figure>-->

    <div>
        <img class="comment-block__avatar" src="<?php  echo $my_avatar; ?>" alt="">
    </div>

    <div class="comment-block__content">
        <div class="user-comment">
            <form class="user-comment__text -form-comment">
                <div id="insertComment-target<?php echo $target_id; ?>-type-<?php echo $type; ?>" color="<?php echo (toNumber($my_char_avar) % 5) + 1; ?>" my_avatar="<?php echo $my_avatar; ?>" my_char_avar="<?php echo $my_char_avar; ?>"   my_username="<?php echo $my_username; ?>"  class="text-content -custom-answer insert_cmt" parent_id="0" level="1"  target_id="<?php echo $target_id; ?>"  type="<?php echo $type; ?>"  contenteditable="true" placeholder="Viết phản hồi..." spellcheck="false"></div>
            </form>
        </div>
    </div>
</div>

    <?php
        if (is_null($my_userid)) {?>
            <div style="    margin-top: 30px;    text-align: center;" id="no_user_capacity">
                <hr>
                <p>Đăng ký hoặc đăng nhập để bình luận </p>
                <div class="my_user">
                    <?php $actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>

                    <a href="https://www.aland.edu.vn/users/register" ><button class="btn btn-primary">Đăng ký</button></a>
                    hoặc
                    <a href="https://www.aland.edu.vn/users/login" id="btn_log_in_cmt"><button class="btn btn-success">Đăng nhập</button></a>
                </div>

            </div>

        <?php }
    ?>


</section>