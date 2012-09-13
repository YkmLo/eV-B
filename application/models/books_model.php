<?php

class Books_model extends CI_Model{
	private $table_name='books';
	
	public function __construct(){
		$this->load->database();
	}
	public function get_books(){
		$query = $this->db->get('books');
		$result= $query->result_array();
		return $result;
		//print_r($result);exit;
	}
}