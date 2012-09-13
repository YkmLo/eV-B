<?php

class Booksusers_model extends CI_Model{
	private $table_name='booksusers';
	
	public function _construct(){
		$this->load->database();
	}
	
}