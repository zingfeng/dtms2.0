<?php 
$profile = $this->permission->getIdentity();
?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>F6 Permission</h3>
        <ul class="nav side-menu">
            <?php if ($this->permission->has_level_user('news')) { ?>
            <li><a><i class="fa fa-newspaper-o"></i> <?php echo $this->lang->line("common_mod_news"); ?> <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'news'))) { ?>
                    <li><a href="<?php echo SITE_URL; ?>/news/add"><?php echo $this->lang->line("common_mod_news_add"); ?></a>
                    <?php } ?>
                    </li>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'news'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/news/index"><?php echo $this->lang->line("common_mod_news_index"); ?></a>
                    </li>
                    <?php } ?>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'buildtop','class' => 'news'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/news/buildtop"><?php echo $this->lang->line("common_mod_news_buildtop"); ?></a>
                    </li>
                    <?php } ?>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'buildtag','class' => 'news'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/news/buildtag"><?php echo $this->lang->line("common_mod_news_buildtag"); ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('test')) { ?>
            <li><a><i class="fa fa-question-circle"></i> Bài test <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'test'))) { ?>
                    <li><a href="<?php echo SITE_URL; ?>/test/add">Thêm bài test</a>
                    <?php } ?>
                    </li>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'test'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/test/index">Danh sách bài test</a>
                    </li>
                    <?php } ?>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'result','class' => 'test'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/test/result">Đánh giá kết quả</a>
                    </li>
                    <?php } ?>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'log_lists','class' => 'test'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/test/log_lists">Lịch sử làm bài test</a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/test/mark_lists">Bài test thủ công</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('course')) { ?>
            <li><a><i class="fa fa-book"></i> Khóa học <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'course'))) { ?>
                    <li><a href="<?php echo SITE_URL; ?>/course/add">Thêm khóa học</a>
                    <?php } ?>
                    </li>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'course'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/course/index">Danh sách khóa học</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('video')) { ?>
            <li><a><i class="fa fa-video-camera"></i> Video <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'video'))) { ?>
                    <li><a href="<?php echo SITE_URL; ?>/video/add">Thêm video</a>
                    <?php } ?>
                    </li>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'video'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/video/index">Danh sách video</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('category')) { ?>
            <li><a><i class="fa fa-tag"></i> Category <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'category'))) { ?>
                    <li><a href="<?php echo SITE_URL; ?>/category/add"><?php echo $this->lang->line("common_mod_category_add"); ?></a>
                    <?php } ?>
                    </li>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'category'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/category/index"><?php echo $this->lang->line("common_mod_category_index"); ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('expert')) { ?>
            <li><a><i class="fa fa-th"></i> Giáo viên <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'expert'))) { ?>
                    <li><a href="<?php echo SITE_URL; ?>/expert/add">Thêm giáo viên</a>
                    <?php } ?>
                    </li>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'expert'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/expert/index">Danh sách giáo viên</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('dictionary')) { ?>
            <li><a><i class="fa fa-th"></i> Từ điển Anh - Việt <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'dictionary'))) { ?>
                    <li><a href="<?php echo SITE_URL; ?>/dictionary/add">Thêm từ</a>
                    <?php } ?>
                    </li>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'dictionary'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/dictionary/index">Danh sách từ</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('group')) { ?>
            <!-- <li><a><i class="fa fa-th"></i> Lớp học <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'group'))) { ?>
                    <li><a href="<?php echo SITE_URL; ?>/group/add">Thêm lớp học</a>
                    <?php } ?>
                    </li>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'group'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/group/index">Danh sách lớp học</a>
                    </li>
                    <?php } ?>
                </ul>
            </li> -->
            <?php } ?>
            <?php if ($this->permission->has_level_user('menu')) { ?>
            <li><a><i class="fa fa-th"></i> <?php echo $this->lang->line("common_mod_menu"); ?> <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'menu'))) { ?>
                    <li><a href="<?php echo SITE_URL; ?>/menu/add"><?php echo $this->lang->line("common_mod_menu_add"); ?></a>
                    <?php } ?>
                    </li>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'menu'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/menu/index"><?php echo $this->lang->line("common_mod_menu_index"); ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('users')) { ?>
            <li><a><i class="fa fa-users"></i> <?php echo $this->lang->line("common_mod_users"); ?> <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'users'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/users/add"><?php echo $this->lang->line("common_mod_users_add"); ?></a>
                    </li>
                    <?php } ?>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'users'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/users/index"><?php echo $this->lang->line("common_mod_users_index"); ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('setting')) { ?>
            <li><a><i class="fa fa-cog"></i> <?php echo $this->lang->line("common_mod_setting"); ?> <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'setting'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/setting"><?php echo $this->lang->line("common_mod_setting"); ?></a>
                    </li>
                    <?php } ?>
                    
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('contact')) { ?>
            <li><a><i class="fa fa-phone"></i> <?php echo $this->lang->line("common_mod_contact"); ?> <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'contact'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/contact/index"><?php echo $this->lang->line("common_mod_contact_index"); ?></a>
                    </li>
                    <?php } ?>
                    
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('advertise')) { ?>
            <li><a><i class="fa fa-file-picture-o"></i> <?php echo $this->lang->line("common_mod_advertise"); ?> <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'news'))) { ?>
                    <li><a href="<?php echo SITE_URL; ?>/advertise/add"><?php echo $this->lang->line("common_mod_advertise_add"); ?></a>
                    <?php } ?>
                    </li>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'news'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/advertise/index"><?php echo $this->lang->line("common_mod_advertise_index"); ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('block')) { ?>
            <li><a><i class="fa fa-desktop"></i> <?php echo $this->lang->line("common_mod_block"); ?> <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'block'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/block/add"><?php echo $this->lang->line("common_mod_block_add"); ?></a>
                    </li>
                    <?php } ?>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'block'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/block/index"><?php echo $this->lang->line("common_mod_block_index"); ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('noti')) { ?>
            <li><a><i class="fa fa-bell-o" aria-hidden="true"></i> Noti <span  class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'noti'))) { ?>
                        <li>
                            <a href="<?php echo SITE_URL; ?>/noti/add">Thêm Noti</a>
                        </li>
                    <?php } ?>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'noti'))) { ?>
                        <li>
                            <a href="<?php echo SITE_URL; ?>/noti/index">Danh sách</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('comment')) { ?>
            <li><a><i class="fa fa-commenting-o" aria-hidden="true"></i> Bình luận <span  class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'comment'))) { ?>
                        <li>
                            <a href="<?php echo SITE_URL; ?>/comment/index">Danh sách</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($this->permission->has_level_user('roles')) { ?>
            <li><a><i class="fa fa-lock"></i> <?php echo $this->lang->line("common_mod_role"); ?> <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php if ($this->permission->check_permission_backend(array('function' => 'member_add','class' => 'roles'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/roles/member_add"><?php echo $this->lang->line("common_mod_role_member_add"); ?></a>
                    </li>
                    <?php } ?>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'member_index','class' => 'roles'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/roles/member_index"><?php echo $this->lang->line("common_mod_role_member_index"); ?></a>
                    </li>
                    <?php } ?>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'add','class' => 'roles'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/roles/add"><?php echo $this->lang->line("common_mod_role_add"); ?></a>
                    </li>
                    <?php } ?>
                    <?php if ($this->permission->check_permission_backend(array('function' => 'index','class' => 'roles'))) { ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/roles/index"><?php echo $this->lang->line("common_mod_role_index"); ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>