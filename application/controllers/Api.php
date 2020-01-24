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
		return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($data));
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
		return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($data));
	}
	
	/*
     * Get Most Appear Character from this method.
     * @param
     * @return Response
    */	
	public function mostAppearCharacter(){
		$data = array();
		$data = $this->ApiOperation->getMostAppearCharacter();
		return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($data));
	}	
	
	/*
     * Get StarWars Species details from this method.
     * @param
     * @return Response
    */	
	public function starWarsSpecies(){
		$data = array();
		$data = $this->ApiOperation->getStarWarSpecies();
		return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($data));
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
				
				$resData[$i]['planet_detail'] = "Planet: ".$data->planet_name." - Pilots: (".$data->total_vehicle_pilots.")";
				$resData[$i]['planet_pilots_detail'] = [];
				$planet_pilots_species_datas = $this->ApiOperation->getPlanetPilotsDetail($data->planet_id);
				
				$j=0;
				foreach($planet_pilots_species_datas as $planet_pilots_species_data){
					$resData[$i]['planet_pilots_detail'][$j]['pilot_name'] = $planet_pilots_species_data->pilot_name;
					$resData[$i]['planet_pilots_detail'][$j]['species_name'] = (empty($planet_pilots_species_data->species_id))?"":$planet_pilots_species_data->species_id;
					$j++;
				}
				$i++;
			}			
		}
		return $this->output->set_content_type('application/json')->set_status_header(400)->set_output(json_encode($resData));
	} 
}
