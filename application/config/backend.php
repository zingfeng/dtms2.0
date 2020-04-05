<?php
$CI = &get_instance();

$config['limit_item'] = 30;
/////////////////////////////////// MENU ////////////////////////////////////
$config['menu']['position'] = array('main' => 'Menu chính','right' => 'Danh mục',);
$config['menu']['module'] = array(
    "news" => array(
        "name" => $CI->lang->line('common_mod_news'),
        "action" => array(
            'news_cate' => array(
                "name"  => $CI->lang->line('common_mod_news_cate'),
                "type" => 'select'
            ),
            'news' => array(
                "name"  => $CI->lang->line('common_mod_static'),
                "type" => 'suggest'
            ),
        )
    ),
    "other" => array(
        "name" => $CI->lang->line('common_mod_fastlink'),
        "action" => array(
            'home' => array(
                "name"  => $CI->lang->line('common_home'),
                "type" => 'fix',
                "link" => '/'
            ),
            "contact" => array(
                "name"  => $CI->lang->line('common_mod_contact'),
                "type" => 'fix',
                "link"  => "/contact"
            ),
            "link" => array(
                "name"  => $CI->lang->line('common_mod_link'),
                "type" => 'text',
            ),
            "class_test" => array(
                "name"  => "Bài tập lớp",
                "type" => 'fix',
                "link" => '/bai-tap-lop.html',
            ),
            "class_news" => array(
                "name"  => "Chia sẻ lớp học",
                "type" => 'fix',
                "link" => '/chia-se-lop-hoc.html',
            ),
        )
    )
);
//////////////////// BLOCK //////////////////////
$config['block'] = array(
    'news_cate' => array(
        "name" => $CI->lang->line('common_mod_news_cate'),
        "position" => array('home_right' => 'Phải trang chủ','home_footer_right' => 'Góc học viên trang chủ',"right" => "Phải", 'user_right' => 'Phải học viên'),
        "params" => array("nums_item",'title',"template" => array(NULL => 'Cột phải','hocvien' => 'Học viên', 'tailieu' => 'Tài liệu bổ trợ', 'videohay' => 'Video hay cho bạn', 'bikip' => "Bí kíp từ cao thủ")),
    ),
    'news_sub_cate' => array(
        "name" => 'Tin tức nhóm cấp 2',
        "position" => array('left_content' => 'Bên trái nội dung','footer' => 'Chân trang','home_content' => 'Trai trang chu'),
        "params" => array("nums_item","template" => array('ebook' => 'Ebook','news' => 'Tin tức','document' => 'Tài liệu'),'title'),
    ),
    'static' => array(
        "name" => $CI->lang->line('common_mod_static'),
        "position" => array('content' => 'Content','right' => 'Right'),
        "params" => array("content","title","template" => array(NULL => 'Normal', 'tuvan' => 'Đăng ký tư vấn','lotrinh' => 'Lộ trình học'))
    ),
    'menu' => array(
        "name" => $CI->lang->line("common_mod_menu"),
        "position" => array('top' => 'Menu chính','right' => 'Right', 'right_course' => "Right course"),
        "params" => array("menu" => $config['menu']['position'],"template" => array(NULL => 'Menu chính','right' => 'Menu phải')),
    ),
    'advertise_cate' => array(
        "name" => $CI->lang->line("common_mod_advertise_cate"),
        "position" => array("home_banner" => 'Slide lớn trang chủ',"home_footer" => "Đối tác", 'home_footer_2' => 'Quảng cáo tin tức trang chủ',"right" => 'Phải tin tức','news_detail' => 'Quảng cáo chân bài viết chi tiết','banner_top' => 'Quảng cáo trên banner', 'course_right' => 'Quảng cáo trong khóa học'),
        "params" => array("nums_item","thumb","title","template" => array('slide' => 'Slide','list' => 'Danh sách','news' => 'Quảng cáo tin','detail' => 'Một banner'))
    ),
    'news_special' => array(
        'name' => $CI->lang->line('common_mod_news_buildtop'), 
        'position' => array('trending' => 'Trending'),
        "params" => array("template" => array('trending' => 'Trending'))
    ),
    'news_tags' => array(
        'name' => $CI->lang->line('common_mod_news_buildtag'), 
        'position' => array('top' => 'Tag special')
    ),
    'expert' => array(
        'name' => 'Giáo viên', 
        'position' => array('home_center' => 'Giữa trang chủ'),
        "params" => array("nums_item","title")
    ),
    'course' => array(
        'name' => 'Khóa học', 
        'position' => array('home_course' => 'Khóa học trang chủ'),
        "params" => array("nums_item", "title")
    ),
);
/////////////////////////////////// PERMISSION ////////////////////////////////////
$config['admin_role'] = array(
    'category' => array(
        'name' => $CI->lang->line("common_mod_category"),
        'permission' => array(
            1 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('index','edit','add','delete')
            )
        )
    ),
    'news' => array(
        'name' => $CI->lang->line("common_mod_news"),
        'permission' => array(
            1 => array( // tao bai viet, xem dc danh sach bai viet cua minh, edit bai viet cua minh
                'name' => 'Writer',
                'permission' => array('layout_form','index','edit','add','copy','suggest_tag','getbranch','getnoti','notiold')
            ),
            2 => array( // edit bai viet nguoi khac, public bai viet
                'name' => 'Manager', 
                'permission' => array('publish','buildtop','suggest_news','buildtag','suggest_tags','suggest_documents')
            ),
            3 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete','cate_add','cate_edit','cate_index','cate_delete')
            )
        )
    ),
    'test' => array(
        'name' => 'Bài test',
        'permission' => array(
            1 => array( // tao bai viet, xem dc danh sach bai viet cua minh, edit bai viet cua minh
                'name' => 'Writer',
                'permission' => array('index','edit','add','question_add','question_edit','question_index','question_delete','suggest_test','question_sort','log_lists','log_export','mark_lists')
            ),
            2 => array( // edit bai viet nguoi khac, public bai viet
                'name' => 'Manager', 
                'permission' => array('publish','copy','answer_add','answer_edit','answer_delete', 'mark_list', 'mark_result', 'result', 'result_add', 'result_edit', 'result_delete')
            ),
            3 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete')
            )
        )
    ),
    'group' => array(
        'name' => 'Lớp học',
        'permission' => array(
            1 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete','add','edit','index','suggest_group','index_users')
            )
        )
    ),
    'expert' => array(
        'name' => 'Giáo viên',
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Giáo viên',
                'permission' => array('suggest','suggest_teacher','suggest_teacher_offline')
            ),
            2 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('add','index','edit')
            ),
            3 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete')
            )
        )
    ),
    'dictionary' => array(
        'name' => 'Từ điển',
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('add','index','edit','suggest')
            ),
            2 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete')
            )
        )
    ),
    'menu' => array(
        'name' => $CI->lang->line("common_mod_menu"),
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('add','index','edit','copy','option')
            ),
            2 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete')
            )
        )
    ),
    'users' => array(
        'name' => $CI->lang->line("common_mod_users"),
        'permission' => array(
            1 => array( // xem dc danh sach thanh vien
                'name' => 'Viewer',
                'permission' => 'index'
            ),
            2 => array( // Edit profile member
                'name' => 'Manager', 
                'permission' => array('edit', 'suggest')
            ),
            3 => array(// xoa user, phan quyen user, tao role
                'name' => 'Administrator',
                'permission' => array('delete')
            )
        )
    ),
    'setting' => array(
        'name' => $CI->lang->line("common_mod_setting"),
        'permission' => array(
            1 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('index')
            )
        )
    ),
    'block' => array(
        'name' => $CI->lang->line("common_mod_block"),
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('option','add','index','edit','copy')
            ),
            2 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete')
            )
        )
    ),
    'noti' => array(
        'name' => $CI->lang->line("common_mod_noti"),
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('add','index','edit')
            ),
            2 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete')
            )
        )
    ),
    'advertise' => array(
        'name' => $CI->lang->line("common_mod_advertise"),
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('index','add','edit','copy')
            ),
            2 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete')
            )
        )
    ),
    'course' => array(
        'name' => 'Khóa học',
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('index','add','edit','copy')
            ),
            2 => array(// Xoa, sua, copy, danh sach
                'name' => 'Giáo viên',
                'permission' => array('topic_index', 'topic_add', 'topic_edit', 'class_add', 'class_edit','class_point','class_score','users_index', 'users_add','users_delete','publish')
            ),
            3 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete', 'topic_delete')
            )
        )
    ),
    'video' => array(
        'name' => 'Video',
        'permission' => array(
            1 => array(
                'name' => "Giáo viên",
                'permission' => array("suggest_video"),
            ),
            2 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('index','add','edit')
            ),
            3 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete','publish')
            )
        )
    ),
    'filemanager' => array(
        'name' => $CI->lang->line("common_mod_filemanager"),
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Writer',
                'permission' => array('index','files','directory','upload','folders','copy','move','create','delete','recursiveCopy','recursiveFolders','rename','fast_upload')
            ),
            2 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array()
            ),
            3 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('recursiveDelete')
            )
        )
    ),
    'contact' => array(
        'name' => $CI->lang->line("common_mod_contact"),
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('index','edit','subscribe','export')
            ),
            2 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('delete')
            )
        )
    ),
    'noti' => array(
        'name' => 'Noti',
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('index','add','delete','edit','subscribe','export')
            ),
            2 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('index','add','delete','edit','subscribe','export')
            )
        )
    ),
    'comment' => array(
        'name' => 'Bình luận',
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('index')
            ),
            2 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('change_status','delete')
            )
        )
    ),
    'roles' => array(
        'name' => $CI->lang->line("common_mod_role"),
        'permission' => array(
            1 => array(// Xoa, sua, copy, danh sach
                'name' => 'Manager',
                'permission' => array('member_index','member_add','member_edit','member_delete')
            ),
            2 => array(// xoa bai, tao folder
                'name' => 'Administrator',
                'permission' => array('index','add','copy','edit','delete')
            )
        )
    ),

);