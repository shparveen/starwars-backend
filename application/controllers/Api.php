<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
 
*/
class Api extends CI_Controller {
	
	 public function __construct(){
		 parent::__construct();
		 // Load model
		 $this->load->model('ApiOperation');
	}
	
  /*
     * Get Longest Crawl from this method.
     * @param
     * @return Response
    */
	public function longestCrawl()
	{   

		$data = array();
		$data = $this->ApiOperation->getLongestCrawl();
		return $this->output->set_header('Access-Control-Allow-Origin: *')->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data));
	}
	
}
