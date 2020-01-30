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
	
}
