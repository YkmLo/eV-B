<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Index extends CI_Controller {

   public function __construct() {
      parent::__construct();
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      $this->load->helper('url');
		$this->load->library('facebook/Fb');
		$this->load->helper('utilities');
		$this->load->library('session');
		$this->load->model('books_model');
   }
   
   
   public function index() {

      $view_data['header'] = $this->load->view('header', $view_data, true);
      $view_data['content'] = $this->load->view('landing_page', $view_data, true);
      $view_data['footer'] = $this->load->view('footer', $view_data, true);

      $this->load->view('index', $view_data);
   }
   
   public function home() {
	  $view_data['data']=$this->books_model->get_books();
	  $total=count($view_data['data']);
	  $flag=ceil($total/3);
	  $view_data['total']=$total;
	  $view_data['flag']=$flag;
      $view_data['header'] = $this->load->view('header', $view_data, true);
      $view_data['content'] = $this->load->view('home', $view_data, true);
      $view_data['footer'] = $this->load->view('footer', $view_data, true);

      $this->load->view('index', $view_data);
   }
   
   public function book() {

      $view_data['header'] = $this->load->view('header', $view_data, true);
      $view_data['content'] = $this->load->view('book', $view_data, true);
      $view_data['footer'] = $this->load->view('footer', $view_data, true);

      $this->load->view('index', $view_data);
   }
    public function create_page() {
	  
	  $this->load->helper('form');
	  $this->load->library('form_validation');		
	
	  
	  $this->form_validation->set_rules('tags', 'Tags', 'required');
	  $this->form_validation->set_rules('type', 'Type', 'required');
	  
	  if($this->input->post('submit') && $this->form_validation->run()===TRUE)
	  {
	  	$tags = $this->input->post('tags');
	  	$type = $this->input->post('type');
	  }
	
      $view_data['header'] = $this->load->view('header', $view_data, true);
      $view_data['content'] = $this->load->view('create_page', $view_data, true);
      $view_data['footer'] = $this->load->view('footer', $view_data, true);  
	  
      $this->load->view('index', $view_data);
	}
   public function mobile()
   {
      $view_data['header'] = $this->load->view('mobile/header', $view_data, true);
      $view_data['content'] = $this->load->view('mobile/landing_page', $view_data, true);
      $view_data['footer'] = $this->load->view('mobile/footer', $view_data, true);

      $this->load->view('mobile/index', $view_data);     
   }

	public function fb_connection()
	{
		$type = $this->input->post('type');
		
		if ($type == 'connect')
		{
			$fb_conf = $this->config->item('facebook');
			$dialog_url = 'http://www.facebook.com/dialog/oauth?client_id=' . $fb_conf['app_id'] . '&redirect_uri=' . base_url() . 'fb_authorized&state=' . $this->config->item('app_salt') . '&scope=email,user_about_me,user_activities,user_photos,user_videos,friends_photos,friends_videos,publish_stream,read_friendlists';
			
			echo json_encode(array('status' => 'success', 'url' => $dialog_url));
			
			return;
		}
		
		echo json_encode(array('status' => 'failed', 'reason' => 'Invalid request'));
	}
	
	public function fb_authorized()
	{
		$state = null;
      	$code = null;
      	$ref = null;

		if (isset($_GET['state']) && isset($_GET['code']))
		{
			$state = $_GET['state'];
			$code = $_GET['code'];
		}
		
		$fb_conf = $this->config->item('facebook');
		
		
		
		if ($state != null && $state != '' && $state == $this->config->item('app_salt') && $code != null && $code != '')
		{
			$token_url = "https://graph.facebook.com/oauth/access_token?" . "client_id=" . $fb_conf['app_id'] . "&redirect_uri=" . urlencode(base_url() . 'fb_authorized') . '&client_secret=' . $fb_conf['app_secret'] . "&code=" . $code;
						
			try
			{			
				$ch = curl_init ($token_url);
	
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
				curl_setopt($ch, CURLOPT_SSLVERSION, 3);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				/** ignore ssl verification */
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				/** end of ignore ssl verification */
		
				$response=curl_exec($ch);
				curl_close ($ch);
				$params = null;
				
				parse_str($response, $params);
			}
			catch (Exeption $e)
			{
				echo 'Oops connection to facebook is disconnected';
				exit;
			}
			
			// set access token for fb php sdk
			Fb::get()->setAccessToken($params['access_token']);
			
			$graph_url = "https://graph.facebook.com/me?access_token=" . $params['access_token'];
			
			$fb_profile = null;
			
			$ch = curl_init ($graph_url);
	
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
			curl_setopt($ch, CURLOPT_SSLVERSION, 3);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			/** ignore ssl verification */
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			/** end of ignore ssl verification */
	
			$fb_obj=curl_exec($ch);
			curl_close ($ch);
			
			$fb_profile = json_decode($fb_obj);
			//print_r($fb_profile); exit;
			//convert fb_profile to array
			$fb_profile = object_to_array($fb_profile);
			
			if ($fb_profile != null)
			{
				$this->load->model('user_model');
				
				$exists_data['fb_id'] = $fb_profile['id'];
				
				$response = $this->user_model->exists($exists_data);
				
				if ($response != null)
				{
					//user exists in database, log the user in and then redirect to home
					$fb_data['userid_pk'] = $response['0']['userid_pk'];
					$fb_data['fb_id'] = $fb_profile['id'];
					$fb_data['fb_access_token'] = Fb::get()->getExtendedAccessToken();
					
					$update_response = $this->user_model->update($fb_data['userid_pk'], $fb_data);
					
					$this->session->set_userdata(array("userid_pk" => $response['0']['userid_pk']));
					$this->session->set_userdata(array("user_data" => $response['0']));
					$this->session->set_userdata(array("logged_in" => true));
					
					$command = 'start "" C:/xampp/php/php -q ' . BASEPATH . '../bg_scripts/pull_fb_data.php ' . $fb_data['fb_access_token'] . ' ' . BASEPATH . ' ' . $fb_data['userid_pk'] . ' ' . base_url();

            		exec($command);
					
					echo '<script>';
					echo 'window.opener.location.replace("/home");';
					echo 'self.close();';
					echo '</script>';
				}
				else
				{
					//user doesn't exists in database, register
					$new_user_data = array(
						 'email' => $fb_profile['email'],
						 'first_name' => $fb_profile['first_name'],
						 'last_name' => $fb_profile['last_name'],
						 'fb_id' => $fb_profile['id'],
						 'fb_access_token' => Fb::get()->getExtendedAccessToken(),
						 'date_created' => date(c)
					);
					
					$user_data = $this->user_model->set($new_user_data);
					
					$this->session->set_userdata(array("userid_pk" => $user_data['0']['userid_pk']));
					$this->session->set_userdata(array("user_data" => $user_data['0']));
					$this->session->set_userdata(array("logged_in" => true));
					
					echo '<script>';
					echo 'window.opener.location.replace("/home");';
					echo 'self.close();';
					echo '</script>';
				}
			}
		}
		else
		{
			echo '<script>';
			echo 'alert("Unauthorized request");';
			echo 'self.close();';
			echo '</script>';
		}
	}
	
	public function logout()
	{
		 // destroy session
        $this->session->sess_destroy();
        
        // redirect to index page
        redirect(base_url(), 'refresh');
	}
	
	public function insert_items()
	{
		$photo_id = $this->input->post('photo_id');
		$tag = $this->input->post('tag');
		
		$this->load->model('hashes');
		$result = $this->hashes_model->exists(array('hashname_pk' => $tag));
		$hash_id = 0;
		if ($result == null)
			$hash_id = $this->hashes_model->set(array('hashname_pk' => $tag));
		
		$photo_id = $this->item_model->insert(array(
			'type' => 'image',
			'location' => base_url() . 'data/' . $photo_id . '.jpg',
			'userid_fk' => $this->session->userdata('userid_pk'),
			'bookid_fk' => 1,
			'date_created' => date('c')
		));
		
		$this->load->model('hashesitems');
		$this->hashesitems->insert(array('itemid_fk' => $photo_id, 'hashid_fk' => $hash_id));
	}
}