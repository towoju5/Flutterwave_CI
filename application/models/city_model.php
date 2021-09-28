<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to user management
 * @author Teamtweaks
 *
 */
class City_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function UpdateActiveStatus($table='',$data=''){
		$query =  $this->db->get_where($table,$data);
		return $result = $query->result_array();
	}
	
	public function SelectAllCountry($condition=''){
	//print_r($OrderAsc);die;

		$this->db->select('*');
		$this->db->from(STATE_TAX);
		if(!empty($condition)){
			$this->db->where($condition);
		}
		//$this->db->where('status','Active');
		$this->db->order_by('id','asc');
		$query =  $this->db->get();
		
//echo $this->db->last_query();die;
		return $result = $query->result_array();
	}
	
	
	
	
	public function SelectAllPrimaryCities(){
		$this->db->select('id,name');
		$this->db->from(CITY);
		$this->db->where('status','Active');
		$this->db->where('featured','1');
		$this->db->order_by('id','asc');
		$query =  $this->db->get();
		
//echo $this->db->last_query();die;
		return $result = $query->result_array();
	}
	public function State_city(){
		$this->db->select('p.*,u.name,u.status,u.description,u.citylogo,u.citythumb,u.seourl as cityurl');
		$this->db->from(STATE_TAX.' as p');
		$this->db->join(CITY.' as u' , 'p.id = u.stateid');
		$this->db->group_by('p.id'); 
		$city = $this->db->get();
		
		//echo $this->db->last_query();
	//	return $result =$query->result_array();
		//echo "<pre>";print_r($result);die;
		return $city;
	}
	
	
	public function Featured_city(){
		$this->db->select('u.*,u.seourl as cityurl,count(u.id) as NCount, st.name as state_name,c.name as country');
		$this->db->from(CITY.' as u');
		$this->db->join(STATE_TAX.' as st' , 'st.id = u.stateid','LEFT');
		$this->db->join(LOCATIONS.' as c' , 'c.id = st.countryid','LEFT');
		$this->db->join(NEIGHBORHOOD.' as n' , 'u.id = n.neighborhoods','LEFT');
		$this->db->where('u.status','Active');
		$this->db->where('u.featured','1');
		$this->db->group_by('u.id');
		$this->db->order_by('u.view_order');
		$city = $this->db->get();
		
		//echo $this->db->last_query();die;
	//	return $result =$query->result_array();
		//echo "<pre>";print_r($result);die;
		return $city;
	}
	
	
	
	public function Featured_city1(){
    	$this->db->select(CITY.'.*,'.CITY.'.seourl as cityurl');
		$this->db->from(CITY);
		//$this->db->where('u.status','Active','u.featured','1');
		//$this->db->where('u.featured','1');
		//$this->db->join(STATE_TAX,STATE_TAX.'.id = '.CITY.'.stateid');
	//	$this->db->join(COUNTRY_LIST,COUNTRY_LIST.'.id = '.STATE_TAX,STATE_TAX.'.id = '.CITY.'.stateid');

		//$this->db->where('.COUNTRY_LIST,COUNTRY_LIST.'.id NOT IN ('.STATE_TAX,STATE_TAX.'.id = '.CITY.'.stateid')', NULL, FALSE);
		
		$city = $this->db->get();
		
		//echo $this->db->last_query();
	//	return $result =$query->result_array();
		//echo "<pre>";print_r($result);die;
		return $city;
	}

	
	
	
	public function FeaturedExperice(){
	
	$this->db->select('*');
	$this->db->from(EXPERIENCE);
	$this->db->where('featured','1');
	$featured_experice=$this->db->get();
	
	return $featured_experice;
	
	
	}
	
	public function featured_all($cat_type_id){
	
	// $sel_featuredExp = "select exp.*,et.experience_title,et.id as e_type_id from ".EXPERIENCE." as exp left join ".EXPERIENCE_PHOTOS." as ph on ph.product_id=exp.experience_id inner join ". EXPERIENCE_TYPE . " as et on et.id= where exp.status='1' and exp.type_id= ".$cat_type_id . " group by exp.experience_id order by exp.added_date desc ";
     // $featuredExperiences = $this->ExecuteQuery($sel_featuredExp);
	 // return $featuredExperiences;
	
	}
	
	
	
	
	public function CityCountDisplay($SelValue='',$condition='',$dbname=''){
		$this->db->select($SelValue);
		$this->db->from($dbname);
		$this->db->group_by($condition); 
		$cityCount = $this->db->get();
		//echo $this->db->last_query();
		//echo "<pre>";print_r($result);die;
		return $cityCount;
		
	}
	public function cityall($city_name,$country){
		//echo $country;
		
	$SQL_QUERY="SELECT a.id as cityid,a.city,a.state,a.country,b.id,b.product_title,b.price,b.currency,c.product_id,c.product_image,(select IFNULL(count(R.id),0) from ".REVIEW." as R where R.product_id= b.id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from ".REVIEW." as Rw where Rw.product_id= b.id and Rw.status='Active') as avg_val FROM ".PRODUCT_ADDRESS_NEW." a INNER JOIN ".PRODUCT." b on b.id = a.productId LEFT JOIN ".PRODUCT_PHOTOS." c on c.product_id = b.id where LOWER(a.city) LIKE LOWER('".$city_name."%') AND LOWER(a.country) LIKE LOWER('".$country."%') AND b.status='Publish' group by c.product_id";	
	
	$city_list =  $this->ExecuteQuery($SQL_QUERY);
	return $city_list;
		
		
		
/* 	$SQL_QUERY="SELECT a.id as cityid,a.city,b.id,b.product_title,b.price,b.currency,c.product_id,c.product_image FROM ".PRODUCT_ADDRESS_NEW." a INNER JOIN ".PRODUCT." b on b.id = a.productId INNER JOIN ".PRODUCT_PHOTOS." c on c.product_id = b.id where a.city='".$city_name."' group by c.product_id";	
	$city_list =  $this->ExecuteQuery($SQL_QUERY);
	return $city_list; */
	}
	
	
	
}