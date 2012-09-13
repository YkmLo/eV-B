<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Index extends CI_Controller {

   public function __construct() {
      parent::__construct();
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      $this->load->helper('url');
 
   }
   
   
   public function index() {

      $view_data['header'] = $this->load->view('header', $view_data, true);
      $view_data['content'] = $this->load->view('landing_page', $view_data, true);
      $view_data['footer'] = $this->load->view('footer', $view_data, true);

      $this->load->view('index', $view_data);
   }
   
   public function home() {

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
   
   public function mobile()
   {
      $view_data['header'] = $this->load->view('header', $view_data, true);
      $view_data['content'] = $this->load->view('home', $view_data, true);
      $view_data['footer'] = $this->load->view('footer', $view_data, true);

      $this->load->view('index', $view_data);     
   }

	public function fb_connection()
	{
		$type = $this->input->post('type');
		
		if ($type == 'connect')
		{
			$fb_conf = $this->config->item('facebook');
			$dialog_url = 'http://www.facebook.com/dialog/oauth?client_id=' . $fb_conf['app_id'] . '&redirect_uri=' . base_url() . 'fb_authorized&state=' . $this->config->item('app_salt') . 'scope=email,user_about_me,user_activities,user_photos,user_videos,friends_photos,friends_videos,publish_stream,read_friendlists';
			
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
		
		if ($state != null && $state != '' && $state == $this->config->item('lopidopi_salt') && $code != null && $code != '')
		{
			$token_url = "https://graph.facebook.com/oauth/access_token?" . "client_id=" . $fb_conf['app_id'] . "&redirect_uri=" . base_url() . 'fb_authorized&client_secret=' . $fb_conf['app_secret'] . "&code=" . $code;
			try
			{
				$response = file_get_contents($token_url);
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
			$fb_profile = json_decode(file_get_contents($graph_url));
			
			//convert fb_profile to array
			$fb_profile = object_to_array($fb_profile);
			
			if ($fb_profile != null)
			{
				$exists_data['fb_id'] = $fb_profile['id'];
				
				$response = $this->user_model->exists($exists_data);
				
				if ($response != null)
				{
					if ($response->status == 'success')
					{ //user exists in database, log the user in and then redirect to home
						$fb_data['userid_pk'] = $response->user_data->userid_pk;
						$fb_data['fb_id'] = $fb_profile['id'];
						$fb_data['fb_access_token'] = Fb::get()->getExtendedAccessToken();
						
						$update_data['user_data'] = $fb_data;
						
						$update_response = $this->user_model->update($update_data);
						
						$this->session->set_userdata(array("userid_pk" => $response->user_data->userid_pk));
						$this->session->set_userdata(array("logged_in" => true));
						
						echo '<script>';
						echo 'window.opener.location.replace("/home");';
						echo 'self.close();';
						echo '</script>';
					}
					else
					{ //user doesn't exists in database, register
						echo '<script>';
						echo 'window.opener.location.replace("/register?ref=fb");';
						echo 'self.close();';
						echo '</script>';
					}
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */