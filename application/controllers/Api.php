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
	
   /**
     * Get Plants Data from this method.
     * @param $id
     * @return Response
    */
	public function Planets($id = 0)
	{
        $data = $this->ApiOperation->getPlanets($id);     
		return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data));
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
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		return $this->output->set_header('Access-Control-Allow-Origin: *')->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data));
	}
	
	/*
     * Get Most Appear Character from this method.
     * @param
     * @return Response
    */	
	public function mostAppearCharacter(){
		$data = array();
		$data = $this->ApiOperation->getMostAppearCharacter();
		return $this->output->set_header('Access-Control-Allow-Origin: *')->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data));
	}	
	
	/*
     * Get StarWars Species details from this method.
     * @param
     * @return Response
    */	
	public function starWarsSpecies(){
		$data = array();
		$data = $this->ApiOperation->getStarWarSpecies();
		return $this->output->set_header('Access-Control-Allow-Origin: *')->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data));
	}	
	
	
	/*
     * Get Planet Vehicle Pilots from this method.
     * @param
     * @return Response
    */	
	public function planetVehiclePilotsDetail(){
		$data = array();
		$resData = array();
		$datas = $this->ApiOperation->getPlanetVehilePilotsCount();
		if(!empty($datas)){
			$i=0;
			foreach($datas as $data){
				
				$resData[$i]['planet_detail'] = "PLANETS: ".$data->planet_name." - Pilots: (".$data->total_vehicle_pilots.") ";
			//	$resData[$i]['planet_pilots_detail'] = array();
				$planet_pilots_species_datas = $this->ApiOperation->getPlanetPilotsDetail($data->planet_id);
				
				$j=0;
				foreach($planet_pilots_species_datas as $planet_pilots_species_data){
					$species_name = (empty($planet_pilots_species_data->species_id))?"species name not found":$planet_pilots_species_data->species_id;
					$resData[$i]['planet_detail'] .= " ".$planet_pilots_species_data->pilot_name." - ".$species_name.", ";
					//$resData[$i]['planet_pilots_detail'][$j]['pilot_name'] = $planet_pilots_species_data->pilot_name;
					//$resData[$i]['planet_pilots_detail'][$j]['species_name'] = $species_name;
					
					$j++;
				}
				$resData[$i]['planet_detail'] = rtrim($resData[$i]['planet_detail']);
				$resData[$i]['planet_detail'] = substr($resData[$i]['planet_detail'],0,strlen($resData[$i]['planet_detail'])-1);
				$i++;
			}			
		}
		return $this->output->set_header('Access-Control-Allow-Origin: *')->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($resData));
	} 
	
   /**
         * Create new user from this method.
         * @param $name
	 * @param $email
	 * @param $userpassword
	 
     * @return Response
    */
	public function createUser()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$userpassword = $this->input->post('userpassword');
		if($name == '' || $email == '' || $userpassword ==''){
		     $data = "Please enter valid data";
		     return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data));
		}
		$userdata = array();
        	$data = $this->ApiOperation->checkUserAlreadyExists($email);  
		if(!empty($data) ){ 
			$data = "User Already exists";
		}else{ 				
			$userdata['name'] = $name;
			$userdata['email'] = $email; 
			$userdata['userpassword'] = $userpassword; 
			$data = $this->ApiOperation->createUser($userdata);	
		}			
		return $this->output->set_header('Access-Control-Allow-Origin: *')->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data));
	}

/**
     * Create new user from this method.
     * @param $username 
     * @param $userpassword
     * @return Response
    */
	public function checkLogin(){
		$username = $this->input->post('username');
		$userpassword = $this->input->post('userpassword');
		
		if($username == '' || $userpassword ==''){
			$data = "Please enter valid username and password";
			return $this->output->set_header('Access-Control-Allow-Origin: *')->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data));
		}
		
		$data = $this->ApiOperation->checkUser($username,$userpassword);  
		
		return $this->output->set_header('Access-Control-Allow-Origin: *')->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data));
	}
}
