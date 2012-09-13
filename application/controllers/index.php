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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */