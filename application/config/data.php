<?php
$config['test_type'] = array(
	//1 => array('name' => '[Toeic] Photo'), // trac nghiem ko hien cau tra loi 
	//2 => array('name' => '[Toeic] Question-Response'),
	1 =>'Listening',
	2 =>'Reading', // trac nghiem ko hien detail
	3 =>'Writing',
	4 =>'Speaking',

	//20 => array('name' => 'Bài tập viết'),
	//30 => array('name' => 'Bài tập ghi âm'),
);
$config['course_class_type'] = array(
	1 => 'Bài học',
	2 => 'Test kỹ năng',
);
$config['cate_type'] = array(
	1 => array('name' => 'Tin tức', 'code' => 'tin-tuc', 'module' => 'news'),
	2 => array('name' => 'Test', 'code' => 'test', 'module' => 'test'),
	3 => array('name' => 'Quảng cáo', 'code' => 'advertise', 'module' => 'advertise'),
	4 => array('name' => 'Khóa học', 'code' => 'course', 'module' => 'course'),
	5 => array('name' => 'Video', 'code' => 'video', 'module' => 'video')
);

$config['test_answer_type'] = array(
	1 => array(
		101 => 'Chọn đáp án',
		102 => 'Điền từ vào chỗ trống',
		103 => 'Trắc nghiệm chọn đáp án đúng',
		104 => 'Trắc nghiệm chọn nhiều đáp án',
	),
	2 => array(
		100 => 'True / False / Not Given',
		101 => 'Chọn đáp án',
		102 => 'Điền từ vào chỗ trống',
		103 => 'Trắc nghiệm chọn đáp án đúng',
		104 => 'Trắc nghiệm chọn nhiều đáp án',
	),
	3 => array(
		201 => 'Writing',
	),
	4 => array(
		301 => 'Speaking',
	),
);

$config['cate_news_type'] = array(
	1 => 'News',
	2 => 'Khóa học',
	3 => 'Video'
);
$config['news_theme'] = array(
	1 => 'Nomal',
	2 => 'Photo'
);
$config['device'] = array(
    0 => 'All device',
    1 => 'Mobile',
    4 => 'PC'
);
$config['location'] = array(
    1 => 'Hà Nội',
	2 => 'Hồ Chí Minh',
	3 => 'Đà Nẵng',
	4 => 'Khác'
);
