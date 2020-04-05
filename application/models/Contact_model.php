<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Contact_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function insert($input) {
		$input = array_merge($input, array('create_time' => time()));
		$contact_id = $this->db->insert('contact', $input);
		return $contact_id;
	}

	public function insert_subcriber($email) {
		$input = array(
			'email' => $email,
			'create_time' => time(),
		);
		$this->db->insert('subcriber', $input);
		return TRUE;
	}
}