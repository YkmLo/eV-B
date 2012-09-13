<?php

class items_model extends CI_Model{
	private $table_name='items';
	
	public function __construct(){
		$this->load->database();
	}
	
	public function insert($data)
	{
		$this->db->insert($this->table_name, $data);
		return $this->db->insert_id();
	}
	
}