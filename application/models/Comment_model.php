<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comment_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $user_id
     * @param $parent_id
     * @param $type
     * @param $target_id
     * @param $content
     * @param int $status
     * @return mixed comment_id_new
     */
    public function add_comment($user_id, $type, $target_id, $content,  $parent_id = 0, $status = 1)
    {
        $data = array(
            'user_id' => $user_id,
            'parent_id' => $parent_id,
            'type' => $type,
            'target_id' => $target_id,
            'content' => $content,
            'count_like' => 0,
            'creat_time' => time(),
            'status' => $status,
            'history' => json_encode(array(time() => $content)),
        );
        $this->db->insert('comment', $data);
        $insertcomment_id = $this->db->insert_id();
        return $insertcomment_id;
    }

    /**
     * Check quyền sửa cmt và sửa cmt
     * @param $user_id
     * @param $comment_id
     * @param $new_content
     * @return bool
     */
    public function edit_comment($user_id, $comment_id, $new_content)
    {
        $right = $this->check_right_handle_cmt($user_id, $comment_id);
        if ($right) {
            // get now content
            $this->db->where('comment_id',$comment_id);
            $this->db->select('history');
            $query = $this->db->get('test');
            $arr_res = $query->result_array();
            $now_history = $arr_res[0]['history'];

            if ($now_history == ''){
                $arr_history = array();
            }else{
                $arr_history = json_decode($now_history,true);
            }
            $arr_history[time()] = $new_content;

            $this->db->get('comment');
            $this->db->set('content', $new_content);
            $this->db->set('history', json_encode($arr_history));
            $this->db->where('comment_id', $comment_id);
            $this->db->update('comment');
            return true;
        }
        return false;
    }

    public function del_comment($user_id, $comment_id)
    {
        $right = $this->check_right_handle_cmt($user_id, $comment_id);
        if ($right){
            // Xóa cmt
            $this->db->delete('comment', array('comment_id' => $comment_id));
            // Xóa danh sách like cmt
            $this->db->delete('like_comment', array('comment_id' => $comment_id));



            // Xóa danh sách like cmt child
            $this->db->where('parent_id',$comment_id);
            $this->db->select('comment_id');
            $query = $this->db->get('comment');
            $arr_res = $query->result_array();
            if ($arr_res){
                for ($i = 0; $i < count($arr_res); $i++) {
                    $comment_id_child = $arr_res[$i]['comment_id'];
                    $this->db->delete('like_comment', array('comment_id' => $comment_id_child));
                }
            }

            // Xóa cmt child
            $this->db->delete('comment', array('parent_id' => $comment_id));
            return true;
        }
        return false;
    }

    /**
     * kiếm tra quyền của user có đủ để thay đổi cmt này ko
     * @param $user_id
     * @param $comment_id
     * @return bool
     */
    public function check_right_handle_cmt($user_id, $comment_id)
    {
        $user_id = (int)$user_id;
        $this->db->where('comment_id', $comment_id);
        $this->db->select('user_id');
        $query = $this->db->get('comment');
        $arr_res = $query->result_array();
        if ($arr_res) {
            $user_id_owner = (int)$arr_res[0]['user_id'];
            if ($user_id_owner === $user_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Hàm này chưa check quyền admin
     * @param $comment_id
     */
    public function admin_hide_cmt($comment_id)
    {
        $this->db->set('status', 0);
        $this->db->where('comment_id', $comment_id);
        $this->db->update('comment');
    }

    /**
     * Hàm này chưa check quyền admin
     * @param $comment_id
     */
    public function admin_show_cmt($comment_id)
    {
        $this->db->set('status', 1);
        $this->db->where('comment_id', $comment_id);
        $this->db->update('comment');
    }

    public function like_comment($user_id, $comment_id)
    {
        $liked_cmt = $this->check_user_liked_cmt($user_id, $comment_id);
        if (! $liked_cmt){
            // Tăng số lượng like
            $this->db->where('comment_id', $comment_id);
            $this->db->set('count_like', 'count_like+1', FALSE);
            $this->db->update('comment');

            // Ghi chi tiết
            $data = array(
                'user_id' => $user_id,
                'comment_id' => $comment_id,
                'time' => time(),
            );
            $this->db->insert('like_comment', $data);
//            $insertcomment_id = $this->db->insert_id();
        }
    }

    public function unlike_comment($user_id, $comment_id)
    {
        $liked_cmt = $this->check_user_liked_cmt($user_id, $comment_id);
        if ($liked_cmt){
            // Giảm số lượng like
            $this->db->where('comment_id', $comment_id);
            $this->db->set('count_like', 'count_like-1', FALSE);
            $this->db->update('comment');

            // Xóa chi tiết
            $data = array(
                'user_id' => $user_id,
                'comment_id' => $comment_id,
            );
            $this->db->delete('like_comment', $data);
        }
    }

    /**
     * Kiểm tra xem người dùng đã like comment hay chưa
     * @param $user_id
     * @param $comment_id
     * @return  bool
     */
    public function check_user_liked_cmt($user_id, $comment_id)
    {
        $user_id = (int) $user_id;
        // get comment_id user_id
        $this->db->where('comment_id', $comment_id);
        $this->db->where('user_id', $user_id);

        $query = $this->db->get('like_comment');
        $arr_res = $query->result_array();
        if (count($arr_res) > 0){
            return true;
        }
        return false;
    }

    // Cần group theo parent id
    public function get_list_cmt_lv1($user_id,$type, $target_id, $number = 100, $newest = true)
    {
        $this->load->model('Users_model','users');


        $this->db->where('type',$type);
        $this->db->where('target_id',$target_id);
        $this->db->where('parent_id',0);
        $this->db->where('status',1);
        if ($newest){
            $this->db->order_by('comment_id',"desc");
        }
        $this->db->limit($number);
        $this->db->select('*');
        $query = $this->db->get('comment');
        $arr_res = $query->result_array();
        // Thêm trạng thái liked

        for ($i = 0; $i < count($arr_res); $i++) {
            $user_id_this = $arr_res[$i]['user_id'];
            $info_user = $this->users->getUserById($user_id_this);

            $mono = $arr_res[$i];
            $comment_id = $mono['comment_id'];
            $arr_res[$i]['liked'] = $this->check_user_liked_cmt($user_id, $comment_id);
            $arr_res[$i]['avatar'] = $info_user['avatar'];
        }


        return array_reverse($arr_res);
    }

    public function get_list_cmt_lv2($user_id,$type, $target_id, $parent_id, $number = 100, $newest = true)
    {
        $this->load->model('Users_model','users');

        $this->db->where('type',$type);
        $this->db->where('target_id',$target_id);
        $this->db->where('parent_id',$parent_id);
        $this->db->where('status',1);
        if ($newest){
            $this->db->order_by('comment_id',"desc");
        }
        $this->db->limit($number);
        $this->db->select('*');
        $query = $this->db->get('comment');
        $arr_res = $query->result_array();

        for ($i = 0; $i < count($arr_res); $i++) {
            $user_id_this = $arr_res[$i]['user_id'];
            $info_user = $this->users->getUserById($user_id_this);


            $mono = $arr_res[$i];
            $comment_id = $mono['comment_id'];
            $arr_res[$i]['liked'] = $this->check_user_liked_cmt($user_id, $comment_id);
            $arr_res[$i]['avatar'] = $info_user['avatar'];
        }


        return array_reverse($arr_res);

    }




    public function get_number_cmt($type, $target_id){
        $this->db->where('type',$type);
        $this->db->where('target_id',$target_id);
        $query = $this->db->get('comment');
        $arr_res = $query->result_array();
        return count($arr_res);
    }
}