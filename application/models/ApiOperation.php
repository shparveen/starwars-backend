<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ApiOperation extends CI_Model {

  function getPlanets($id = 0){ 
  
    $qResult = array(); 
	$sql = "SELECT id,name from planets";
	if($id != 0){
		$sql .= " WHERE id = $id";
	}
	
   	$qResult = $this->db->query($sql)->result();     
    return $qResult;
  }
  
  function getLongestCrawl(){
	$qResult = array();
	$qResult = $this->db->select('title as longest_crawl, Char_length(`opening_crawl`) as longest_crawl_char_count')
				->from('films')->order_by("longest_crawl_char_count", "desc")->limit(1,0)->get()->result();	
   	// print_r($this->db->last_query());    exit;
	return $qResult;	
  }
  
  function getMostAppearCharacter(){
	$qResult = array();
	$sql = "SELECT (select name from people where id=fc.people_id) as character_name, count(film_id) as number_of_films FROM `films_characters` as fc group by people_id order by number_of_films DESC limit 0,1";
	$qResult =  $this->db->query($sql)->result();
	return $qResult;	
  }

  function getStarWarSpecies(){
	$qResult = array();
	$sql = "SELECT  (SELECT name from species where id = fs.`species_id` ) as species_name, (SELECT COUNT(DISTINCT(people_id)) from species_people where species_id = fs.`species_id`) as number_of_characters_belongsTo_species FROM `films_species` as fs GROUP By species_id";
	$qResult =  $this->db->query($sql)->result();
	return $qResult;  
  }
  
  function getPlanetVehilePilotsCount(){
	$qResult = array();
	$sql = "SELECT (SELECT name from people WHERE id=fp.planet_id) as planet_name, fp.planet_id, count(DISTINCT(vp.people_id)) as total_vehicle_pilots  FROM `films_planets` as fp, films_vehicles as fv, vehicles_pilots as vp WHERE fp.film_id  = fv.film_id and fv.vehicle_id = vp.vehicle_id group by fp.planet_id order by total_vehicle_pilots desc";
	$qResult =  $this->db->query($sql)->result();
	return $qResult; 
  }
  
  function getPlanetPilotsDetail($planet_id){
	$qResult = array();
	$sql = "SELECT  DISTINCT(SELECT p.name from people p WHERE p.id= vp.people_id) as pilot_name,  ( SELECT  ( SELECT name from species s where  s.id = GROUP_CONCAT(sp.species_id) ) as species_name FROM species_people as sp  WHERE sp.people_id = vp.people_id ) as species_id FROM `films_planets` as fp, films_vehicles as fv, vehicles_pilots as vp WHERE fp.film_id  = fv.film_id and fv.vehicle_id = vp.vehicle_id  and fp.planet_id = $planet_id";
	$qResult =  $this->db->query($sql)->result();

	return $qResult; 
  }
  
  
}