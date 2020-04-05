<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Convert extends CI_Controller
{
    function __construct(){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit','2048M');

        parent::__construct();
    }

    /**
     * Update các đường link trong chi tiết bài viết, replace các đường link cũ thành đường link mới
     */
    public function convert_to_link_new()
    {
        ob_start(null, 4096);
        $this->db->select('note_new');
        $query_note = $this->db->get('setting');
        $res = $query_note->row_array();
        $note_done = $res['note_new'];

        if ($note_done == '')
        {
            $arr_id_done = array();
        }else{
            $arr_id_done = explode('|',$note_done);
        }


        $this->load->helper('simple_html_dom');
        set_time_limit(0);
        $this->db->select('news_id, detail');
        $query = $this->db->get('news');

        foreach ($query->result() as $row) {
            $id_str =  (string) $row->news_id;
            echo '<br>Handle: '.$id_str;
            if (in_array($id_str,$arr_id_done))
            {
                continue;
            }
            ob_implicit_flush(true);
            ob_flush();

            if ( trim($row->detail ) == '' )
            {
                $this->db->select('note_new');
                $query_note = $this->db->get('setting');
                $res = $query_note->row_array();
                $note_done = $res['note_new'];
                $note_done2 = $note_done.'|'. $id_str;

                $this->db->set('note_new', $note_done2);
                $this->db->where('site_id', 1);
                $this->db->update('setting');

                continue;
            }

            if (  $id_str ==  '37319' )
            {
                continue;
            }

            $html = str_get_html($row->detail);

            if (count($html->find('a')) > 0) {
                $arr_search = array();
                $arr_replace = array();

                foreach ($html->find('a') as $element) {
                    if (isset($element->attr['href'])) {
                        $href = trim(strtolower($element->attr['href']));
                        echo '<br>Link: '.$href;
                        ob_implicit_flush(true);
                        ob_flush();
                        // $route['(:any)-nd(:num)'] = "rss/redirect/news/$2"; //
                        // $route['(:any)-nd(:num)-(:num)'] = "rss/redirect/news/$2";
                        $re0 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com.*-nd(\d+)(|-[0-9]+)\/*$/m';
                        preg_match_all($re0, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $this->db->where('old_news', $id);
                            $query = $this->db->get("news");
                            $arrData = $query->row_array();
                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }

                        // $route['(:any)-nl(:num)'] = "rss/redirect/news_cate/$2";
                        $re1 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com.*-nl(\d+)\/*$/m';
                        preg_match_all($re1, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $this->db->where('old_cate', $id);
                            $this->db->where("type", 1);
                            $query = $this->db->get("category");
                            $arrData = $query->row_array();
                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }

                        // $route['question/test/(:num)'] = "rss/redirect/test/$1";
                        $re2 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com\/question\/test\/(\d+)\/*$/m';
                        preg_match_all($re2, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $this->db->where('old_test', $id);
                            $query = $this->db->get("test");
                            $arrData = $query->row_array();

                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }

                        // $route['question/catetest/(:num)'] = "rss/redirect/test_cate/$1";
                        $re3 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com\/question\/catetest\/(\d+)\/*$/m';
                        preg_match_all($re3, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $this->db->where('old_cate', $id);
                            $this->db->where("type", 2);
                            $query = $this->db->get("category");
                            $arrData = $query->row_array();

                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }

                        //  $route['question/minitest/(:num)'] = "rss/redirect/fulltest/$1";
                        $re4 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com\/minitest\/(\d+)\/*$/m';
                        preg_match_all($re4, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $id = 10000 + (int)$id;
                            $this->db->where('old_test', $id);
                            $this->db->where('type', 1);
                            $query = $this->db->get("test");
                            $arrData = $query->row_array();

                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }

                        //  $route['question/fulltest/(:num)'] = "rss/redirect/fulltest/$1";
                        $re5 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com\/fulltest\/(\d+)\/*$/m';
                        preg_match_all($re5, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $id = 10000 + (int)$id;
                            $this->db->where('old_test', $id);
                            $this->db->where('type', 1);
                            $query = $this->db->get("test");
                            $arrData = $query->row_array();

                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }
                    }
                }

                if (count($arr_search) > 0) {
                    $new_detail = str_replace($arr_search, $arr_replace, $row->detail);
                    $news_id = $row->news_id;
                    // Update
                    $this->db->set('detail', $new_detail); // third param
                    $this->db->where('news_id', $news_id);
                    $this->db->update('news');
                }
            }

            $this->db->select('note_new');
            $query_note = $this->db->get('setting');
            $res = $query_note->row_array();
            $note_done = $res['note_new'];
            $note_done2 = $note_done.'|'. $id_str;

            $this->db->set('note_new', $note_done2);
            $this->db->where('site_id', 1);
            $this->db->update('setting');
        }
    }

    /**
     * Fix thẻ a của site từ http thành https
     */
    public function fix_tag_a_html()
    {
        ob_start(null, 4096);
        set_time_limit(0);
        $this->load->helper('simple_html_dom');
        $this->db->select('news_id, detail');
        $query = $this->db->get('news');
        $i = 1;
        foreach ($query->result() as $row) {
            $id_str = $row->id;
            echo '<br>'.$i.'. '.$id_str;
            ob_implicit_flush(true);
            ob_flush();
            $i++;
            $html = str_get_html($row->detail);
            $arr_find = array();
            $arr_replace = array();


            if (count($html->find('a')) > 0) {
                foreach ($html->find('a') as $element) {
                    if (isset($element->attr['href'])) {
                        $href = trim(strtolower($element->attr['href']));
                        if (substr($href,0,26) == 'http://www.anhngumshoa.com' ) {
                            $new_href = str_replace('http://www.anhngumshoa.com', 'https://www.anhngumshoa.com', $href);
                            if ($new_href != $href)
                            {
                                array_push($arr_find,$href);
                                array_push($arr_replace,$new_href);
                            }
                        }
                    }
                }
            }

            if ( (count($arr_find) >0 ) && (count($arr_replace) >0))
            {
                $detail = str_replace($arr_find,$arr_replace,$row->detail);
                $news_id = $row->news_id;

                // Update
                $this->db->set('detail', $detail);
                $this->db->where('news_id', $news_id);
                $this->db->update('news');
            }
        }
    }

    /**
     * Fix thẻ img của site từ http thành https
     */
    public function fix_tag_img_html()
    {
        ob_start(null, 4096);
        set_time_limit(0);
        $this->load->helper('simple_html_dom');
        $this->db->select('news_id, detail');
        $query = $this->db->get('news');
        $i = 1;
        foreach ($query->result() as $row) {
            $id_str = $row->id;
            echo '<br>'.$i.'. '.$id_str;
            ob_implicit_flush(true);
            ob_flush();
            $i++;
            $html = str_get_html($row->detail);
            $arr_find = array();
            $arr_replace = array();

            if (count($html->find('img')) > 0) {
                foreach ($html->find('img') as $element) {
                    if (isset($element->attr['src'])) {
                        $src = trim(strtolower($element->attr['src']));
                        if (substr($src,0,26) == 'http://www.anhngumshoa.com' ) {
                            $new_src = str_replace('http://www.anhngumshoa.com', 'https://www.anhngumshoa.com', $src);
                            if ($new_src != $src)
                            {
                                array_push($arr_find,$src);
                                array_push($arr_replace,$new_src);
                            }
                        }
                    }
                }
            }

            if ( (count($arr_find) >0 ) && (count($arr_replace) >0))
            {
                $detail = str_replace($arr_find,$arr_replace,$row->detail);
                $news_id = $row->news_id;

                // Update
                $this->db->set('detail', $detail);
                $this->db->where('news_id', $news_id);
                $this->db->update('news');
            }
        }
    }

    /**
     *  Thêm thuộc tính rel="Nofollow" cho tất cả các linkout. Loại trừ một số link trong list
     */
    public function fix_rel_follow_a_html()
    {
        ob_start(null, 4096);
        // Set danh sách các site rel = 'dofollow'
        $array_domain_rel_follow = array('www.anhngumshoa.com');

        set_time_limit(0);
        $this->load->helper('simple_html_dom');
        $this->db->select('news_id, detail');
        $query = $this->db->get('news');

        $i = 1;
        foreach ($query->result() as $row) {
            $id_str = $row->id;
            echo '<br>'.$i.'. '.$id_str;
            ob_implicit_flush(true);
            ob_flush();
            $i++;

            $html = str_get_html($row->detail);
            $arr_find = array();
            $arr_replace = array();

            if (count($html->find('a')) > 0) {
                foreach ($html->find('a') as $element) {
                    if (isset($element->attr['href'])) {
                        $href = trim(strtolower($element->attr['href']));
                        $domain = $this->get_domain_from_url($href);
                        if (in_array($domain,$array_domain_rel_follow))
                        {
                            $rel_tar = 'do-follow'; // Set rel= 'do-follow'
                        }else{
                            $rel_tar = 'no-follow'; // Set rel= 'no-follow'
                        }

                        $first_outertext = $element->outertext;
                        $element->attr['rel'] = $rel_tar;
                        $second_outertext = $element->outertext;

                        if ($first_outertext != $second_outertext)
                        {
                            array_push($arr_find,$first_outertext);
                            array_push($arr_replace,$second_outertext);
                        }
                    }
                }
            }

            if ( (count($arr_find) >0 ) && (count($arr_replace) >0))
            {
                $detail = str_replace($arr_find,$arr_replace,$row->detail);
                $news_id = $row->news_id;

                // Update
                $this->db->set('detail', $detail);
                $this->db->where('news_id', $news_id);
                $this->db->update('news');
            }
        }
    }

    public function handle_step_by_step()
    {
        // get list finish


        set_time_limit(0);
        $this->load->helper('simple_html_dom');
        $this->db->select('news_id, detail');
        $query = $this->db->get('news');
        foreach ($query->result() as $row) {
            $html = str_get_html($row->detail);
            if (count($html->find('a')) > 0) {
                $arr_search = array();
                $arr_replace = array();

                foreach ($html->find('a') as $element) {
                    if (isset($element->attr['href'])) {
                        $href = trim(strtolower($element->attr['href']));

                        // $route['(:any)-nd(:num)'] = "rss/redirect/news/$2"; //
                        // $route['(:any)-nd(:num)-(:num)'] = "rss/redirect/news/$2";
                        $re0 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com.*-nd(\d+)(|-[0-9]+)\/*$/m';
                        preg_match_all($re0, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $this->db->where('old_news', $id);
                            $query = $this->db->get("news");
                            $arrData = $query->row_array();
                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }

                        // $route['(:any)-nl(:num)'] = "rss/redirect/news_cate/$2";
                        $re1 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com.*-nl(\d+)\/*$/m';
                        preg_match_all($re1, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $this->db->where('old_cate', $id);
                            $this->db->where("type", 1);
                            $query = $this->db->get("category");
                            $arrData = $query->row_array();
                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }

                        // $route['question/test/(:num)'] = "rss/redirect/test/$1";
                        $re2 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com\/question\/test\/(\d+)\/*$/m';
                        preg_match_all($re2, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $this->db->where('old_test', $id);
                            $query = $this->db->get("test");
                            $arrData = $query->row_array();

                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }

                        // $route['question/catetest/(:num)'] = "rss/redirect/test_cate/$1";
                        $re3 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com\/question\/catetest\/(\d+)\/*$/m';
                        preg_match_all($re3, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $this->db->where('old_cate', $id);
                            $this->db->where("type", 2);
                            $query = $this->db->get("category");
                            $arrData = $query->row_array();

                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }

                        //  $route['question/minitest/(:num)'] = "rss/redirect/fulltest/$1";
                        $re4 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com\/minitest\/(\d+)\/*$/m';
                        preg_match_all($re4, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $id = 10000 + (int)$id;
                            $this->db->where('old_test', $id);
                            $this->db->where('type', 1);
                            $query = $this->db->get("test");
                            $arrData = $query->row_array();

                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }

                        //  $route['question/fulltest/(:num)'] = "rss/redirect/fulltest/$1";
                        $re5 = '/http[s]{0,1}:\/\/www\.anhngumshoa\.com\/fulltest\/(\d+)\/*$/m';
                        preg_match_all($re5, $href, $matches, PREG_SET_ORDER, 0);
                        if (count($matches) == 1) {
                            $id = $matches[0][1];
                            $id = 10000 + (int)$id;
                            $this->db->where('old_test', $id);
                            $this->db->where('type', 1);
                            $query = $this->db->get("test");
                            $arrData = $query->row_array();

                            if ($arrData) {
                                $share_url = $arrData['share_url'];
                                if (is_string($share_url) && (trim($share_url) != '')) {
                                    $share_url = trim(strtolower($share_url));
                                    if (substr($share_url, 0, 1) != '/') $share_url = '/' . $share_url;
                                    $new_fulllink = 'https://www.anhngumshoa.com' . $share_url;
                                    array_push($arr_search, $element->attr['href']);
                                    array_push($arr_replace, $new_fulllink);
                                }
                            }
                        }
                    }
                }

                if (count($arr_search) > 0) {
                    $new_detail = str_replace($arr_search, $arr_replace, $row->detail);
                    $news_id = $row->news_id;
                    // Update
                    $this->db->set('detail', $new_detail); // third param
                    $this->db->where('news_id', $news_id);
                    $this->db->update('news');
                }
            }
        }

    }

    private function get_domain_from_url($url)
    {
        $parse = parse_url($url);
        return $parse['host'];
    }


    /**
     * API get list branch and offline place
     */

    public function Check_duplicate_SEO_title()
    {
        $this->db->select('news_id, seo_title, share_url');
        $query = $this->db->get('news');

        $arr_duplicate = array(); // seo_title => list news_id
        // check trùng
        $number_duplicate = 0;
        $list_arr_key_dup = array();
        $share_url_arr = array();

        $number_no_SEO_title = 0;
        $arr_no_SEO_title = array();

        foreach ($query->result() as $row) {
            $news_id = $row->news_id;
            if (trim($row->seo_title) != '')
            {
                $seo_title = $row->seo_title;
                if (array_key_exists($seo_title, $arr_duplicate))
                {
                    // đã tồn tại
                    $number_duplicate ++;
                    $arr_duplicate[$seo_title] = $arr_duplicate[$seo_title].'|'.$news_id;
                    array_push($list_arr_key_dup,$seo_title);
                    $share_url_arr[$news_id] = $row->share_url;

                }else{
                    // chưa tồn tại
                    $arr_duplicate[$seo_title] = $news_id;
                    $share_url_arr[$news_id] = $row->share_url;
                }
            }else{
                // Chưa có SEO title
                $number_no_SEO_title ++ ;
                array_push($arr_no_SEO_title,$news_id);
            }
        }

        echo '<br>Result: ';
        echo '<br>Tổng số lượng bài viết: '.count($query->result());
        echo '<br>Số lượng bài viết chưa có tiêu đề SEO: '.$number_no_SEO_title;

        echo '<hr>';
        echo '<br>Số lượng tiêu đề SEO bị trùng: '.$number_duplicate;
//        echo '<br>Số lượng nhóm trùng: '.count($list_arr_key_dup);
        echo '<br>Chi tiết: ';
        for ($i = 0; $i < count($list_arr_key_dup); $i++) {
            $mono_key_arr = $list_arr_key_dup[$i];
            echo '<h5>&bull; SEO title: ' .$mono_key_arr.'</h5>';
            $arr_id = explode('|',$arr_duplicate[$mono_key_arr]);
            echo 'Số lượng trùng: '.count($arr_id);

            for ($k = 0; $k < count($arr_id); $k++) {
                $news_id_this = $arr_id[$k];
                $share_url = $share_url_arr[$news_id_this];
                echo '<br>- <a href ="'.$share_url.'" title="news_id '.$news_id_this.'" target="_blank" >'.$share_url.'</a> (Id bài viết '.$news_id_this.' )';
            }
            echo '<br>';
        }
    }

    public function Check_duplicate_SEO_title_SHOW()
    {
        $this->load->view('check_seo_title','',false);
    }

    public function Convert_Out_link_target_blank()
    {
        ob_start(null, 4096);
        // Set danh sách các site rel = 'dofollow'
        $array_domain_rel_follow = array('www.anhngumshoa.com');

        set_time_limit(0);
        $this->load->helper('simple_html_dom');
        $this->db->select('news_id, detail');
        $query = $this->db->get('news');

        $i = 1;
        foreach ($query->result() as $row) {
            $id_str = $row->id;
            echo '<br>'.$i.'. '.$id_str;
            ob_implicit_flush(true);
            ob_flush();
            $i++;

            $html = str_get_html($row->detail);
            $arr_find = array();
            $arr_replace = array();

            if (count($html->find('a')) > 0) {
                foreach ($html->find('a') as $element) {
                    if (isset($element->attr['href'])) {
                        $href = trim(strtolower($element->attr['href']));
                        $domain = $this->get_domain_from_url($href);

                        if (trim(strtolower($domain)) == 'docs.google.com')
                        {
                            $first_outertext = $element->outertext;
                            $element->attr['target'] = '_blank';
                            $second_outertext = $element->outertext;

                            if ($first_outertext != $second_outertext)
                            {
                                array_push($arr_find,$first_outertext);
                                array_push($arr_replace,$second_outertext);
                            }
                        }
                    }
                }
            }

            if ( (count($arr_find) >0 ) && (count($arr_replace) >0))
            {
                $detail = str_replace($arr_find,$arr_replace,$row->detail);
                $news_id = $row->news_id;

                // Update
                $this->db->set('detail', $detail);
                $this->db->where('news_id', $news_id);
                $this->db->update('news');
            }
        }
    }

}
