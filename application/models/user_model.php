<?php
class user_model extends CI_Model {
	
	private $table_name = 'users';
	
	public function __construct()
	{
		// load the library
		$this->load->database();
	}
	
	//public function get($id = NULL)
//	{
//		if ($id == NULL)
//		{
//			$query = $this->db->get($this->table_name);
//			
//			$result = MemcachedManager::get('user_get');
//			
//			if ($result == null)
//			{
//				$result = $query->result_array();
//				//MemcachedManager::set('user_get', $result, true, 60);
//			}
//			
//			return $result;
//		}	
//		else
//		{
//			$this->db->where('userid_pk', $id);
//			$query = $this->db->get($this->table_name);
//			
//			$result = MemcachedManager::get("user_get_id_" . $id);
//			
//			if ($result == null)
//			{
//				$result = $query->result_array();
//				MemcachedManager::set('user_get_id_' . $id, $result[0], true, 60);
//				
//				$result = $result[0];
//			}
//			
//			return $result;
//		}
//	}
//	
	public function set($data)
	{
		return $this->db->insert($this->table_name, $data);
	}
	
	public function update($id, $data)
	{
		

		return $this->db->update($this->table_name, $data, "userid_pk = " . $id);
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
	
	//public function get_basic_info_by_email($email)
//	{
//		$query = $this->db->query('SELECT userid_pk, first_name, last_name, birthday, email FROM ' . $this->table_name . ' WHERE email = ?', array($email));
//		
//		$result = MemcachedManager::get('user_get_basic_info_by_email_email_' . $email);
//		
//		if ($result == null)
//		{
//			$result = $query->result_array();
//			if ($result)
//			{
//				MemcachedManager::set('user_get_basic_info_by_email_email_' . $email, $result[0], true, 30);
//				return $result[0];
//			}
//			else
//				return null;
//		}
//		
//		return $result;
//	}
//	
//	public function get_id_by_name($first_name,$last_name)
//	{
//		$query_string = "SELECT userid_pk FROM `". $this->table_name ."` WHERE first_name = '".$first_name."' and last_name = '".$last_name."'";
//		$query = $this->db->query($query_string);
//		$result = $query->result_array();
//		if ($result)
//			return $result[0];
//		else
//			return null;
//	}
//
//	// get users who invited based on the email provided
//	public function get_inviting_users_by_invited_email($email)
//	{
//		if ($email == null || $email == '')
//			return null;
//		
//		// this query returns all the users who invited based on the email provided but haven't made request yet
//		$query = $this->db->query("SELECT userid_pk, first_name, last_name, lpi.type FROM ld_invitations lpi LEFT JOIN ld_users lu ON lu.userid_pk = lpi.userid_fk where lpi.email = ? and userid_pk not in ( select li.userid_fk from ld_invitations li left join ld_users lu on li.email = lu.email left join ld_partner_requests lpr on lu.userid_pk = lpr.requested_userid_fk where lpr.status is not null ) and userid_pk not in ( select li.userid_fk from ld_invitations li left join ld_users lu on li.email = lu.email left join ld_friends lf on lu.userid_pk = lf.requested_userid_fk where lf.status is not null )", array("email" => $email));
//		$users = $query->result_array();
//		if($users)
//			return $users;
//		else
//			return null;
//	}
//	
//	// get users who invited this user
//	public function get_inviting_users_by_invited_user_id($user_id)
//	{
//		if ($user_id == null || $user_id == '')
//			return null;
//		
//		// this query returns all the users who invited based on the id provided but haven't made request yet
//		$query = $this->db->query("SELECT lu1.userid_pk, lu1.first_name, lu1.last_name, lu1.email, lpi.type FROM ld_invitations lpi LEFT JOIN ld_users lu1 ON lu1.userid_pk = lpi.userid_fk LEFT JOIN ld_users lu2 ON lu2.email = lpi.email where lu2.userid_pk = ? AND lu1.userid_pk NOT IN ( select li.userid_fk from ld_invitations li left join ld_users lu on li.email = lu.email left join ld_partner_requests lpr on lu.userid_pk = lpr.requested_userid_fk where lpr.status is not null ) and lu1.userid_pk not in ( select li.userid_fk from ld_invitations li left join ld_users lu on li.email = lu.email left join ld_friends lf on lu.userid_pk = lf.requested_userid_fk where lf.status is not null )", array("userid_pk" => $user_id));
//		$users = $query->result_array();
//		if($users)
//			return $users;
//		else
//			return null;
//	}
//	
//	// get users who get requested by this user to be partners
//	public function get_partner_requested_users($user_id)
//	{
//		if ($user_id == null || $user_id == '')
//			return null;
//		
//		$query = $this->db->query("SELECT userid_pk, first_name, last_name, email, lpr.status FROM ld_users lu left join ld_partner_requests lpr on lu.userid_pk = lpr.requested_userid_fk WHERE lpr.requesting_userid_fk = ?", array("userid_pk" => $user_id));
//		
//		$users = $query->result_array();
//		if($users)
//			return $users;
//		else
//			return null;
//	}
//	
//	// get users who requested this user to be partners
//	public function get_partner_requesting_users($user_id)
//	{
//		if ($user_id == null || $user_id == '')
//			return null;
//		
//		$query = $this->db->query("SELECT userid_pk, first_name, last_name, email, lpr.status FROM ld_users lu left join ld_partner_requests lpr on lu.userid_pk = lpr.requesting_userid_fk WHERE lpr.requested_userid_fk = ?", array("userid_pk" => $user_id));
//		
//		$users = $query->result_array();
//		if($users)
//			return $users;
//		else
//			return null;
//	}
//	
//	// get users who get requested by this user to be friends
//	public function get_friend_requested_users($user_id)
//	{
//		if ($user_id == null || $user_id == '')
//			return null;
//		
//		$query = $this->db->query("SELECT userid_pk, first_name, last_name, email, lf.status FROM ld_users lu left join ld_friends lf on lu.userid_pk = lf.requested_userid_fk WHERE lf.requesting_userid_fk = ?", array("userid_pk" => $user_id));
//		
//		$users = $query->result_array();
//		if($users)
//			return $users;
//		else
//			return null;
//	}
//	
//	// get users who requested this user to be friends
//	public function get_friend_requesting_users($user_id)
//	{
//		if ($user_id == null || $user_id == '')
//			return null;
//		
//		$query = $this->db->query("SELECT userid_pk, first_name, last_name, email, lf.status FROM ld_users lu left join ld_friends lf on lu.userid_pk = lf.requesting_userid_fk WHERE lf.requested_userid_fk = ?", array("userid_pk" => $user_id));
//		
//		$users = $query->result_array();
//		if($users)
//			return $users;
//		else
//			return null;
//	}
}

?>
