<?php

class books_model extends CI_Model{
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
	
	public function create($user_id, $tag)
	{
		$data = array('bookname' => $tag, 'userid_fk' => $user_id, 'type' => 'public', 'date_created' => date('c'));
		$this->db->insert($this->table_name, $data);
		return $this->db->insert_id();
	}
	
	public function get_by_name($tag)
	{
		$this->db->where(array('bookname' => $tag));
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0)
			{
				$result = $query->result_array();
				
				return $result[0]['bookid_pk'];
			}
			else
				return null;
	}
}