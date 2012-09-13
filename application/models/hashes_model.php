<?php

class hashes_model extends CI_Model{
	private $table_name='hashes';
	
	public function __construct(){
		$this->load->database();
	}
	
	
	public function set($data)
	{
		return $this->db->insert($this->table_name, $data);
	}
	
	
	public function update($hashname, $data)
	{
		return $this->db->update($this->table_name, $data, "hashname_pk = " . $hashname);
	}
	
	
	public function exists($data=null)
	{
		$where = null;
		
		if ($data == null)
			return null;
		else
		{
			
			foreach ($data as $key => $value)
			{
				$where[$key] = $value;
			}
			
			$this->db->where($where);
			$query = $this->db->get($this->table_name);
			
			if ($query->num_rows() > 0)
			{
				$result = $query->result_array();
				
				return $result;
			}
			else
				return null;
		}
	}
	
}