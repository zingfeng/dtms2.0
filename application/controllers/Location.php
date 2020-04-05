<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller
{
    public function index()
    {
        guard();
        guard_admin_manager();

        $this->load->model('Feedback_model', 'feedback');
        $location_info = $this->feedback->get_list_location();

        $data = array(
            'location_info' => $location_info,
//            'teacher_info' => $teacher_info,
//            'teacher_id_to_name' => $teacher_id_to_name,
        );
        $this->load->layout('feedback/location', $data, false, 'layout_feedback');
    }

    public function location_point()
    {
        guard();
        guard_admin_manager();

        $params = array();
        if (isset($_REQUEST['min_opening'])) {
            $params['min_opening'] = strip_tags($_REQUEST['min_opening']);
        }

        if (isset($_REQUEST['max_opening'])) {
            $params['max_opening'] = strip_tags($_REQUEST['max_opening']);
        }

        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');

        $rows = $this->fu->get_location_point_full();

        $today = date('Y-m-d', time());
        $one_month = date('Y-m-d', time() - 1 * 30 * 24 * 60 * 60);
        $two_month = date('Y-m-d', time() - 2 * 30 * 24 * 60 * 60);
        $three_month = date('Y-m-d', time() - 3 * 30 * 24 * 60 * 60);
        $six_month = date('Y-m-d', time() - 6 * 30 * 24 * 60 * 60);
        $one_year = date('Y-m-d', time() - 365 * 24 * 60 * 60);

        $data = array(
            'rows' => $rows,
            'today' => $today,
            'one_month' => $one_month,
            'two_month' => $two_month,
            'three_month' => $three_month,
            'six_month' => $six_month,
            'one_year' => $one_year,
        );

        $this->load->layout('feedback/location_point', $data, false, 'layout_feedback');
    }

}
