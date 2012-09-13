<?php

class booksusers_model extends CI_Model{
	private $table_name='booksusers';
	
	public function __construct(){
		$this->load->database();
	}
	
}