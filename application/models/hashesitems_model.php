<?php

class Hashesitems_model extends CI_Model{
	private $table_name='hashesitems';
	
	public function __construct(){
		$this->load->database();
	}
	
	public function set($data)
	{
		return $this->db->insert($this->table_name, $data);
	}
}