<?php

class Items_model extends CI_Model{
	private $table_name='items';
	
	public function _construct(){
		$this->load->database();
	}
	
}