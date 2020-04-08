<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends CI_Controller
{
    // ============ NEW
    public function class_()
    {
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.

        guard();
        guard_admin_manager();

        $this->load->model('Feedback_model', 'feedback');
        $params = array();

        $checkParams = count($_GET);
        if($checkParams == 0) {
            $params['limit'] = 100;
        }

        if (isset($_GET['min']) && (is_numeric($_GET['min']))) { //done
            $params['min'] = (float)$_GET['min'];
        }

        if (isset($_GET['max']) && (is_numeric($_GET['max']))) { //done
            $params['max'] = (float)$_GET['max'];
        }

        if (isset($_GET['location'])) { // done
            $location = $_GET['location'];
            $params['location'] = json_decode($location, true);
        }

        if (isset($_GET['classCode'])) { // done
            $classCode = $_GET['classCode'];
            $params['class_code'] = $classCode;
        }

        if (isset($_GET['type'])) { // done
            $type = $_GET['type'];
            $params['type'] = json_decode($type, true);
        }

        if (isset($_GET['area'])) {
            $area = $_GET['area'];
            $params['area'] = json_decode($area, true);
        }

        $class_info_raw = $this->feedback->get_list_class_filter($params);

        $class_info = array();

        $list_id_location_filter = array();
        if (isset($_GET['area'])) {
            $area = $_GET['area'];
            $area = json_decode($area, true);
            foreach ($area as $area_mono) {
                $res_location = $this->feedback->get_list_location($area_mono);
                foreach ($res_location as $item_location) {
                    $id_location_this = $item_location['id'];
                    array_push($list_id_location_filter, $id_location_this);
                }
            }
        }

        foreach ($class_info_raw as $item) {
            $id_location = $item['id_location'];
            $list_teacher_live = json_decode($item['list_teacher'], true);

            if (isset($_GET['teacher'])) {
                $teacher_filter = $_GET['teacher'];
                $teacher_filter = json_decode($teacher_filter, true);

                $led = false;
                for ($i = 0; $i < count($list_teacher_live); $i++) {
                    $mono_id_teacher = (string)$list_teacher_live[$i];
                    if (in_array($mono_id_teacher, $teacher_filter)) {
                        $led = true;
                    }
                }
                if (!$led) continue;
            }

            // ============ get list area

            if (isset($_GET['area'])) {
                if (!in_array($id_location, $list_id_location_filter)) {
                    continue;
                }
            }
            array_push($class_info, $item);
        }

        foreach ($class_info as &$mono_class_info) {
            $time_start = $mono_class_info['time_start'];
            $time_end = $mono_class_info['time_end'];
            $mono_class_info['time_start_client'] = date('Y-m-d' . '\T' . "H:i", $time_start); // 2000-01-01T00:00:00
            $mono_class_info['time_end_client'] = date('Y-m-d' . '\T' . "H:i", $time_end);
        }

        $this->load->model('Feed_upgrade_model','fu');

        $teacher_info = $this->feedback->get_list_info_teacher();
        $location_info = $this->feedback->get_list_location();

        $teacher_id_to_name = array();
        for ($k = 0; $k < count($teacher_info); $k++) {
            $id_teacher = $teacher_info[$k]['teacher_id'];
            $teacher_id_to_name[$id_teacher] = $teacher_info[$k]['name'];
        }

        $data = array(
            'class_info' => $class_info,
            'teacher_info' => $teacher_info,
            'location_info' => $location_info,
            'teacher_id_to_name' => $teacher_id_to_name,
        );

        $this->load->layout('feedback/class2', $data, false, 'layout_feedback');
    }

    public function class_old()
    {
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.

        guard();
        guard_admin_manager();

        $this->load->model('Feedback_model', 'feedback');
        $params = array();

        $checkParams = count($_GET);
        if($checkParams == 0) {
            $params['limit'] = 100;
        }

        if (isset($_GET['min']) && (is_numeric($_GET['min']))) { //done
            $params['min'] = (float)$_GET['min'];
        }

        if (isset($_GET['max']) && (is_numeric($_GET['max']))) { //done
            $params['max'] = (float)$_GET['max'];
        }

        if (isset($_GET['location'])) { // done
            $location = $_GET['location'];
            $params['location'] = json_decode($location, true);
        }

        if (isset($_GET['classCode'])) { // done
            $classCode = $_GET['classCode'];
            $params['class_code'] = $classCode;
        }

        if (isset($_GET['type'])) { // done
            $type = $_GET['type'];
            $params['type'] = json_decode($type, true);
        }

        if (isset($_GET['area'])) {
            $area = $_GET['area'];
            $params['area'] = json_decode($area, true);
        }

        $class_info_raw = $this->feedback->get_list_class_filter($params);

        $class_info = array();
        foreach ($class_info_raw as $item) {
            $id_location = $item['id_location'];
            $list_teacher_live = json_decode($item['list_teacher'], true);

            if (isset($_GET['teacher'])) {
                $teacher_filter = $_GET['teacher'];
                $teacher_filter = json_decode($teacher_filter, true);

                $led = false;
                for ($i = 0; $i < count($list_teacher_live); $i++) {
                    $mono_id_teacher = (string)$list_teacher_live[$i];
                    if (in_array($mono_id_teacher, $teacher_filter)) {
                        $led = true;
                    }
                }
                if (!$led) continue;
            }

            // ============ get list area

            if (isset($_GET['area'])) {
                $area = $_GET['area'];
                $area = json_decode($area, true);

                $list_id_location_filter = array();
                foreach ($area as $area_mono) {
                    $res_location = $this->feedback->get_list_location($area_mono);
                    foreach ($res_location as $item_location) {
                        $id_location_this = $item_location['id'];
                        array_push($list_id_location_filter, $id_location_this);
                    }
                }

                if (!in_array($id_location, $list_id_location_filter)) {
                    continue;
                }
            }

            array_push($class_info, $item);
        }

        foreach ($class_info as &$mono_class_info) {
            $time_start = $mono_class_info['time_start'];
            $time_end = $mono_class_info['time_end'];
            $mono_class_info['time_start_client'] = date('Y-m-d' . '\T' . "H:i", $time_start); // 2000-01-01T00:00:00
            $mono_class_info['time_end_client'] = date('Y-m-d' . '\T' . "H:i", $time_end);
            $mono_class_info['number_feedback_homthugopy'] = $this->feedback->get_number_feedback_homthugopy_by_class_code($mono_class_info['class_code']);
            $mono_class_info['number_feedback_phone'] = $this->feedback->get_number_feedback_phone_by_class_code($mono_class_info['class_code']);
            $mono_class_info['number_feedback_phone_1'] = $this->feedback->get_number_feedback_phone_by_class_code($mono_class_info['class_code'], 1);
            $mono_class_info['number_feedback_phone_2'] = $this->feedback->get_number_feedback_phone_by_class_code($mono_class_info['class_code'], 2);
            $mono_class_info['number_feedback_phone_3'] = $this->feedback->get_number_feedback_phone_by_class_code($mono_class_info['class_code'], 3);
            $mono_class_info['number_feedback_phone_4'] = $this->feedback->get_number_feedback_phone_by_class_code($mono_class_info['class_code'], 4);
            $mono_class_info['number_feedback_ksgv1'] = $this->feedback->get_number_feedback_ksgv_1_by_class_code($mono_class_info['class_code']);
            $mono_class_info['number_feedback_ksgv2'] = $this->feedback->get_number_feedback_ksgv_2_by_class_code($mono_class_info['class_code']);
            $mono_class_info['number_feedback_online'] = $this->feedback->get_number_feedback_online_by_class_code($mono_class_info['class_code']);
        }



        $teacher_info = $this->feedback->get_list_info_teacher();
        $location_info = $this->feedback->get_list_location();


        $teacher_id_to_name = array();
        for ($k = 0; $k < count($teacher_info); $k++) {
            $id_teacher = $teacher_info[$k]['teacher_id'];
            $teacher_id_to_name[$id_teacher] = $teacher_info[$k]['name'];
        }

        $data = array(
            'class_info' => $class_info,
            'teacher_info' => $teacher_info,
            'location_info' => $location_info,
            'teacher_id_to_name' => $teacher_id_to_name,
        );

        $this->load->layout('feedback/class2', $data, false, 'layout_feedback');
    }

    // belong to Tuvan
    public function class_tuvan()
    {
        guard();

        $this->load->model('Feedback_model', 'feedback');
        $checkParams = count($_GET);
        if($checkParams == 0) {
            $params['limit'] = 1000;
        }

        if (isset($_GET['min']) && (is_numeric($_GET['min']))) { //done
            $params['min'] = (float)$_GET['min'];
        }

        if (isset($_GET['max']) && (is_numeric($_GET['max']))) { //done
            $params['max'] = (float)$_GET['max'];
        }

        if (isset($_GET['location'])) { // done
            $location = $_GET['location'];
            $params['location'] = json_decode($location, true);
        }

        // Phần này của tư vấn nên fix location
        $params['location'] = (int)$_SESSION['id_location'];

        if (isset($_GET['type'])) { // done
            $type = $_GET['type'];
            $params['type'] = json_decode($type, true);
        }

        if (isset($_GET['area'])) {
            $area = $_GET['area'];
            $params['area'] = json_decode($area, true);
        }

        $class_info_raw = $this->feedback->get_list_class_filter($params);

        $class_info = array();

        $list_id_location_filter = array();
        if (isset($_GET['area'])) {
            $area = $_GET['area'];
            $area = json_decode($area, true);
            foreach ($area as $area_mono) {
                $res_location = $this->feedback->get_list_location($area_mono);
                foreach ($res_location as $item_location) {
                    $id_location_this = $item_location['id'];
                    array_push($list_id_location_filter, $id_location_this);
                }
            }
        }


        foreach ($class_info_raw as $item) {
            $id_location = $params['location'];
            $list_teacher_live = json_decode($item['list_teacher'], true);

            if (isset($_GET['teacher'])) {
                $teacher_filter = $_GET['teacher'];
                $teacher_filter = json_decode($teacher_filter, true);

                $led = false;
                for ($i = 0; $i < count($list_teacher_live); $i++) {
                    $mono_id_teacher = (string)$list_teacher_live[$i];
                    if (in_array($mono_id_teacher, $teacher_filter)) {
                        $led = true;
                    }
                }
                if (!$led) continue;
            }

            // ============ get list area

            if (isset($_GET['area'])) {
                if (!in_array($id_location, $list_id_location_filter)) {
                    continue;
                }
            }

            array_push($class_info, $item);
        }

        foreach ($class_info as &$mono_class_info) {
            $mono_class_info['time_start_client'] = date('Y-m-d' . '\T' . "H:i", $mono_class_info['time_start']); // 2000-01-01T00:00:00
            $mono_class_info['time_end_client'] = date('Y-m-d' . '\T' . "H:i", $mono_class_info['time_end']);
        }

        $teacher_info = $this->feedback->get_list_info_teacher();
        $location_info = $this->feedback->get_list_location();

        $teacher_id_to_name = array();
        for ($k = 0; $k < count($teacher_info); $k++) {
            $id_teacher = $teacher_info[$k]['teacher_id'];
            $teacher_id_to_name[$id_teacher] = $teacher_info[$k]['name'];
        }

        $data = array(
            'class_info' => $class_info,
            'teacher_info' => $teacher_info,
            'location_info' => $location_info,
            'teacher_id_to_name' => $teacher_id_to_name,
        );
        $this->load->layout('feedback/class_tuvan', $data, false, 'layout_feedback_tuvan');
    }

}
