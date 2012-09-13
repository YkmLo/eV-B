<?php

class Books_model extends CI_Model{
	private $table_name='books';
	
	public function _construct(){
		$this->load->database();
	}
	
}