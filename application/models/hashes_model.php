<?php

class Hashes_model extends CI_Model{
	private $table_name='hashes';
	
	public function _construct(){
		$this->load->database();
	}
	
}