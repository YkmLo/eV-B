<?php

class Hashesitems_model extends CI_Model{
	private $table_name='hashesitems';
	
	public function _construct(){
		$this->load->database();
	}
	
}