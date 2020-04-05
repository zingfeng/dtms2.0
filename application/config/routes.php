<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
/** ADMIN **/
$route['admin'] = "admin/users/dashboard";
// tags news

//$route['tin-tuc/tuyen-tap-tai-lieu-ielts-simon-writing-moi-nhat-2019-ebook-pdf-37722.html'] = "tin-tuc/ielts-simon-37722.html";


////////// SITEMAP ////////
$route['sitemap.xml'] = "rss/sitemap_index";
$route['sitemap/(:any).xml'] = "rss/sitemap/$1";
/** COMMON **/
//$route['(:any)'] = "frontend/$1";
$route['default_controller'] = "feedback/login";

$route['feedback/(giaotiep|ielts|toeic|aland|slide|ksgv_lan1|ksgv_lan2|hom_thu_gop_y|zoom|dao_tao_online)'] = "form/$1";
$route['feedback/(feedback_ksgv_detail|export_feedback_ksgv_detail|hom_thu_gop_y_detail|export_hom_thu_gop_y_detail)'] = "log/$1";
$route['feedback/(feedback_phone_detail|export_list_feedback_phone_detail)'] = "log/$1";

$route['feedback/teacher'] = "teacher/index";
$route['feedback/(teacher_point|export_teacher_point|teacher_point_new)'] = "teacher/$1";

$route['feedback/location'] = "location/index";
$route['feedback/location_point'] = "location/location_point";

$route['feedback/request'] = "request/index";
$route['feedback/get_url_fb_zoom'] = "request/get_url_fb_zoom";

$route['feedback/(class_tuvan|class_|class_new)'] = "classes/$1";

$route['feedback/(statistic|statistic_tuvan)/(:any)'] = "stat/$1/$2";

$route['feedback/phone'] = "phone/index";

$route['feedback/(script_handle_bell_1_times|script_handle_bell)'] = "bell/$1";

// Error
$route['404_override'] = '';
$route['404.html'] = 'news/error_404';

$route['translate_uri_dashes'] = FALSE;



/* End of file routes.php */
/* Location: ./application/config/routes.php */