<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to attribute management
 * @author Teamtweaks
 *
 */
class Experience_model extends My_Model
{
	
	/* experience type  */
	public function view_experienceType_details(){
		$select_qry = "select * from ".EXPERIENCE_TYPE." ORDER BY id DESC";
		$attributeList = $this->ExecuteQuery($select_qry);
		return $attributeList;
			
	}


	public function edit_experienceType($dataArr='',$condition=''){
			$this->db->where($condition);
			$this->db->update(EXPERIENCE_TYPE,$dataArr);
	}

	public function view_experienceType($condition=''){
			return $this->db->get_where(EXPERIENCE_TYPE,$condition);
			
	}

	/* experience type   */

	/* experience */

	//view listing experience details
	public function get_exprience_view_details($limit='',$limitstart)
	{
		$this->db->cache_on();
		//echo($limit);
		$this->db->select('p.*,extyp.experience_title as type_title,u.image as user_image,rp.product_image as product_image,expAdd.city');
		$this->db->from(EXPERIENCE.' as p');
		$this->db->join(EXPERIENCE_TYPE.' as extyp','extyp.id=p.type_id');
		$this->db->join(EXPERIENCE_ADDR.' as expAdd','expAdd.experience_id=p.experience_id',"LEFT");
		$this->db->join(USERS.' as u',"u.id=p.user_id");
		$this->db->join(EXPERIENCE_PHOTOS.' as rp',"rp.product_id=p.experience_id","LEFT");
		$this->db->order_by('p.experience_id','desc'); 
		$this->db->group_by('p.experience_id'); 
		$this->db->where('p.status','1');
		if($limit!='') {
			$this->db->limit($limit,$limitstart);
		}
		return $query = $this->db->get();
		//echo $this->db->last_query();die;
	}

	//view listing experience details
	public function get_exprience_view_details_withFilter($condition='')
	{
		
		$this->db->cache_on();
	
		
		$select_qry = "select p.*,extyp.experience_title as type_title,d.from_date,u.image as user_image,rp.product_image as product_image,expAdd.city from ".EXPERIENCE." p  
		LEFT JOIN ".EXPERIENCE_TYPE." extyp on extyp.id=p.type_id
		LEFT JOIN ".EXPERIENCE_ADDR." expAdd on expAdd.experience_id=p.experience_id 
		LEFT JOIN ".EXPERIENCE_PHOTOS." rp on rp.product_id=p.experience_id
		LEFT JOIN ".EXPERIENCE_DATES." d on d.experience_id=p.experience_id
		LEFT JOIN ".EXPERIENCE_TIMING." dt on dt.exp_dates_id=d.id 

		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		//echo $select_qry;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
		

		/*$this->db->cache_on();
		$select_qry = "select p.*,extyp.experience_title as type_title,u.image as user_image,rp.product_image as product_image,expAdd.city from ".EXPERIENCE." p  
		LEFT JOIN ".EXPERIENCE_TYPE." extyp on extyp.id=p.type_id
		LEFT JOIN ".EXPERIENCE_ADDR." expAdd on expAdd.experience_id=p.experience_id 
		LEFT JOIN ".EXPERIENCE_PHOTOS." rp on rp.product_id=p.experience_id

		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		//echo $select_qry;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList; */

	}

	public function get_experiences($condition='')
	{

		$this->db->cache_on();
	
		
		$select_qry = "select p.*,extyp.experience_title as type_title,d.from_date,u.image as user_image,rp.product_image as product_image,expAdd.city from ".EXPERIENCE." p  
		LEFT JOIN ".EXPERIENCE_TYPE." extyp on extyp.id=p.type_id
		LEFT JOIN ".EXPERIENCE_ADDR." expAdd on expAdd.experience_id=p.experience_id 
		LEFT JOIN ".EXPERIENCE_PHOTOS." rp on rp.product_id=p.experience_id
		LEFT JOIN ".EXPERIENCE_DATES." d on d.experience_id=p.experience_id
		LEFT JOIN ".EXPERIENCE_TIMING." dt on dt.exp_dates_id=d.id 

		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		//echo $select_qry;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
		

	}

	public function get_exprience_view_details_all()
	{
		$this->db->cache_on();
		//echo($limit);
		$this->db->select('p.*,extyp.experience_title as type_title,u.image as user_image,rp.product_image as product_image,expAdd.city');
		$this->db->from(EXPERIENCE.' as p');
		$this->db->join(EXPERIENCE_TYPE.' as extyp','extyp.id=p.type_id');
		$this->db->join(EXPERIENCE_ADDR.' as expAdd','expAdd.experience_id=p.experience_id',"LEFT");
		$this->db->join(USERS.' as u',"u.id=p.user_id");
		$this->db->join(EXPERIENCE_PHOTOS.' as rp',"rp.product_id=p.experience_id","LEFT");
		$this->db->order_by('p.experience_id','desc'); 
		$this->db->group_by('p.experience_id'); 
		$this->db->where('p.status','1');
		
		return $query = $this->db->get();
		//echo $this->db->last_query();die;
	}

	public function get_popular_wishlistphoto($prod_id=''){
	//echo($prod_id);die;
	$this->db->cache_on();
		$popular_list_qry = "select *  from ".EXPERIENCE_PHOTOS." where product_id=".$prod_id;
		$productList = $this->ExecuteQuery($popular_list_qry);
		return $productList;			
	}



	public function get_allthe_details($status,$city,$id){

		$this->db->cache_on();
		$whereCond = '';
		
		if($status!=''){
			$whereCond = ' where p.status="'.$status.'" ';
		}
		
		if($city!=''){
			if ($whereCond!=''){
				$whereCond .= ' and ';
			}else {
				$whereCond = ' where ';
			}
			$whereCond .= ' pa.city= "'.$city.'" ';
		}
		
		
		
		//$user_join = '';
		$groupby = '';
		if($id!=''){
			if ($whereCond!=''){
				$whereCond .= ' and ';
			}else {
				$whereCond = ' where ';
			}
			$whereCond .= ' p.user_id= "'.$id.'" ';
			//$user_join = 'JOIN '.TIMESHEET.' t on t.project_id=p.id ';
			
		}
	
		if ($whereCond!=''){
			$whereCond .= ' and u.status="Active" or p.user_id=0';
		}else {
			$whereCond = ' where u.status="Active" or p.user_id=0';
		}
		//$whereCond .= 'u.status="Active" or p.user_id=0';
	//group by p.id 
	//order by p.created desc
		$groupby = 'group by p.experience_id';
		$select_qry = "select p.*,pa.city as city_name,et.id as et_id,et.experience_title as cat_title,u.firstname,u.lastname,u.image as user_image,u.feature_product,u.phone_no,u.email,u.address,u.address2,u.city as addr3,pa.lat as latitude,pa.lang as longitude,ph.product_image as PImg,p.featured
		from ".EXPERIENCE." p 
		LEFT JOIN ".EXPERIENCE_ADDR." pa on pa.experience_id=p.experience_id
		LEFT JOIN ".EXPERIENCE_PHOTOS." ph on p.experience_id=ph.product_id
			 JOIN ".EXPERIENCE_TYPE." et on et.id=p.type_id
		LEFT JOIN ".USERS." u on (u.id=p.user_id)
		".$whereCond." 
		".$groupby."  
		order by p.added_date desc";
		$productList =  $this->ExecuteQuery($select_qry);
		//echo "<pre>";print_r($productList->result());
		return $productList;
	}



	public function get_particular_details($fields='',$table='',$condition='',$sortArr=''){
		$this->db->cache_on();
		
				//echo "<pre>";print_r($condition); 
				$this->db->select($fields); 
			if ($sortArr != '' && is_array($sortArr)){
			foreach ($sortArr as $sortRow){
				if (is_array($sortRow)){
					$this->db->order_by($sortRow['field'],$sortRow['type']);
				}
			}
		}
		return $this->db->get_where($table,$condition);
	}


	public function get_search_options($condition)
	{
		$this->db->cache_on();
		
		$select_qry = "select p.*,cit.name as city_name,cit.id as c_id,u.firstname,u.lastname from ".EXPERIENCE." p
		LEFT JOIN ".EXPERIENCE_ADDR." pa on pa.experience_id=p.experience_id
		LEFT JOIN ".CITY." cit on pa.city = cit.id
		LEFT JOIN ".USERS." u on (u.id=p.user_id)".$condition;
		$searchOption = $this->ExecuteQuery($select_qry); 
		return $searchOption;
		echo $this->db->last_query(); die;
		
		
		
	}

 
	public function view_experience_details($condition = ''){
		$this->db->cache_on();
		$select_qry = "select p.*,p.experience_id as id,p.experience_title as product_title,u.firstname,u.lastname,u.image as user_image,u.feature_product,pa.lat as latitude,pa.lang as longitude,pa.city,pa.state,pa.country,pa.zip,pa.street as apt,pa.address,ph.product_image as PImg,p.featured from ".EXPERIENCE." p 
		LEFT JOIN ".EXPERIENCE_ADDR." pa on pa.experience_id=p.experience_id
		LEFT JOIN ".EXPERIENCE_PHOTOS." ph on p.experience_id=ph.product_id
		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		$productList = $this->ExecuteQuery($select_qry);
		
		return $productList;
			
	}




	public function get_dashboard_experience($condition = '',$Cont2 = '',$pageLimitStart,$searchPerPage){
	
		$this->db->select('p.*,p.experience_id as id,pp.product_image,pa.lat as latitude,p.price,hs.payment_status,sched.id as date_id,u.id_verified');
		
		$this->db->from(EXPERIENCE.' as p');
		$this->db->join(EXPERIENCE_ADDR.' as pa',"pa.experience_id=p.experience_id","LEFT");
		$this->db->join(EXPERIENCE_PHOTOS.' as pp',"pp.product_id=p.experience_id","LEFT");
		$this->db->join(EXPERIENCE_DATES.' as sched',"sched.experience_id=p.experience_id","LEFT");
		$this->db->join(EXPERIENCE_LISTING_PAYMENT.' as hs',"hs.product_id=p.experience_id","LEFT");
		$this->db->join(USERS.' as u',"u.id=p.user_id","LEFT");
		$this->db->where_in('p.user_id',$condition);
		if($Cont2!=''){
			$this->db->where('p.status',$Cont2);
		}
		$this->db->group_by('p.experience_id');
		$this->db->order_by('p.experience_id','desc');
		$this->db->limit($searchPerPage,$pageLimitStart);
		return $query = $this->db->get();
		
	}

	public function get_dashboard_experience_site_map($condition = '',$Cont2 = ''){
	
		$this->db->select('p.*,p.experience_id as id,pp.product_image,pa.lat as latitude,p.price,hs.payment_status,sched.id as date_id,u.id_verified');
		
		$this->db->from(EXPERIENCE.' as p');
		$this->db->join(EXPERIENCE_ADDR.' as pa',"pa.experience_id=p.experience_id","LEFT");
		$this->db->join(EXPERIENCE_PHOTOS.' as pp',"pp.product_id=p.experience_id","LEFT");
		$this->db->join(EXPERIENCE_DATES.' as sched',"sched.experience_id=p.experience_id","LEFT");
		$this->db->join(EXPERIENCE_LISTING_PAYMENT.' as hs',"hs.product_id=p.experience_id","LEFT");
		$this->db->join(USERS.' as u',"u.id=p.user_id","LEFT");
		
		$this->db->where_in('p.user_id',$condition);
		if($Cont2!=''){
			$this->db->where('p.status',$Cont2);
		}
		$this->db->group_by('p.experience_id');
		$this->db->order_by('p.experience_id','desc');
		
		return $query = $this->db->get();
		
	}

	public function get_dashboard_list($condition = '',$Cont2 = ''){
	
			$this->db->select('p.*,p.experience_id as id,pp.product_image,pa.lat as latitude,hs.payment_status');
			$this->db->from(EXPERIENCE.' as p');
			$this->db->join(EXPERIENCE_ADDR.' as pa',"pa.experience_id=p.experience_id","LEFT");
			$this->db->join(EXPERIENCE_PHOTOS.' as pp',"pp.product_id=p.experience_id","LEFT");
			$this->db->join(EXPERIENCE_LISTING_PAYMENT.' as hs',"hs.product_id=p.experience_id","LEFT");
			$this->db->where_in('p.user_id',$condition);
			if($Cont2!=''){
				$this->db->where('p.status',$Cont2);
			}
			$this->db->group_by('p.experience_id');
			$this->db->order_by('p.experience_id','desc');
			
			return $query = $this->db->get();
			
		}

	public function get_images($product_id)
	{
		$this->db->cache_on();
		
		$this->db->from(EXPERIENCE_PHOTOS);
		$this->db->where('product_id',$product_id);
		$this->db->order_by('imgPriority','asc');
	
		return $query = $this->db->get();
			
	}


	function view_product1($product_id='')
	{
		$this->db->cache_on();
		$this->db->select('p.*,p.experience_title as product_title,p.experience_id as id,p.language_list,u.id as OwnerId,
		pa.zip as post_code,pa.address,pa.lat as latitude,pa.lang as longitude,pa.city as cityname, pa.country as CountryName, pa.state as StateName');
		$this->db->from(EXPERIENCE.' as p');
		$this->db->join(EXPERIENCE_ADDR.' as pa',"pa.experience_id=p.experience_id","LEFT");
		$this->db->join(USERS.' as u',"u.id=p.user_id","LEFT");
		$this->db->where('p.experience_id',$product_id);
		$this->db->group_by('p.experience_id');
		return $query = $this->db->get();
	}

	 public function get_old_address($id) {
		 $this->db->cache_on();
   		$this->db->select('p.address, p.lat as latitude, p.lang as longitude, c.name as cityName, s.name as stateName, cn.name as countryName');
		$this->db->from(EXPERIENCE_ADDR.' as p');
		$this->db->join(CITY.' as c',"c.id=p.city","LEFT");
		$this->db->join(STATE_TAX.' as s',"s.id=p.state","LEFT");
		$this->db->join(COUNTRY_LIST.' as cn',"cn.id=p.country","LEFT");
		$this->db->where('p.experience_id',$id);
		return $query = $this->db->get();
	 }



	public function get_review($product_id,$reviewer_id='')
	{
		$this->db->cache_on();
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW.' as p');
		$this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");
		$this->db->where('p.product_id',$product_id);
		if($reviewer_id !='')
		{
		$this->db->where('p.reviewer_id',$reviewer_id);
		}
		$this->db->where('p.status','Active');
		$this->db->order_by('p.dateAdded','desc');
		$query = $this->db->get();
		return $query;
		//echo $this->db->last_query();die;
	}
	
	
	public function get_review_similar($product_id,$reviewer_id=''){
		$this->db->cache_on();
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW.' as p');
		$this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");
		$this->db->where('p.product_id',$product_id);
		if($reviewer_id !='')
		{
		$this->db->where('p.reviewer_id',$reviewer_id);
		}
		$this->db->where('p.status','Active');
		$this->db->order_by('p.dateAdded','desc');
		$query = $this->db->get();
		return $query;
		//echo $this->db->last_query();die;
	}
	

	public function get_review_other($product_id,$reviewer_id='')
	{
		$this->db->cache_on();
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW.' as p');
		$this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");
		$this->db->where('p.product_id',$product_id);
		if($reviewer_id !='')
		{
			$this->db->where('p.reviewer_id !=',$reviewer_id);
		}
		$this->db->where('p.status','Active');
		$this->db->order_by('p.dateAdded','desc');
		$query = $this->db->get();
		return $query;
		//echo $this->db->last_query();die;
	}

	public function get_review_tot($product_id)
	{
		$this->db->cache_on();
		$this->db->select('AVG( total_review ) as tot_tot, AVG( accuracy ) as tot_acc, AVG( communication ) as tot_com, AVG( cleanliness ) as tot_cln, AVG( location ) as tot_loc, AVG( checkin ) as tot_chk, AVG( value ) as tot_val');
		$this->db->from(EXPERIENCE_REVIEW);
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		return $query;
	}
	

	public function get_cat_list($ids=''){
		$this->db->cache_on();
		$this->db->where_in('id',explode(',', $ids));
		return $this->db->get(EXPERIENCE_TYPE);
	}



	public function view_payment_details($transId){
		$this->db->cache_on();
		$this->db->select('p.*,u.email,u.firstname,u.address,u.phone_no,u.postal_code,u.state,u.country,u.city,pd.experience_title,pd.experience_id as PrdID,pd.experience_title as prd_name');
		$this->db->from(EXPERIENCE_LISTING_PAYMENT.' as p');
		$this->db->join(USERS.' as u' , 'p.host_id = u.id');
		$this->db->join(EXPERIENCE.' as pd' , 'pd.experience_id = p.product_id');		
		$this->db->where('p.paypal_txn_id = "'.$transId.'"');
		$this->db->where('p.payment_status = "Paid"');		
		$this->db->order_by("p.created", "desc"); 
		$PrdList = $this->db->get();
		
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}


	//Change status
	public function activeInactiveExperience($table='', $column=''){
		$data =  $_POST['checkbox_id'];
		for ($i=0;$i<count($data);$i++){  
			if($data[$i] == 'on'){
				unset($data[$i]);
			}
		}
		$mode  = $this->input->post('statusMode');
		$AdmEmail  = strtolower($this->input->post('SubAdminEmail'));
		/*$getAdminSettingsDetails = $this->getAdminSettings();
		$config = '<?php '; 
		foreach($getAdminSettingsDetails ->row() as $key => $val){
			$value = addslashes($val);
			$config .= "\n\$config['$key'] = '$value'; ";
		}
		$file = 'fc_admin_action_settings.php';
		file_put_contents($file, $config);
		vinu@teamtweaks.com
		*/
		
		
		$json_admin_action_value = file_get_contents('fc_admin_action_settings.php');
		if($json_admin_action_value !=''){
			$json_admin_action_result = unserialize($json_admin_action_value);
		}
			
		foreach ($json_admin_action_result as $valds) {
				$json_admin_action_result_Arr[] = $valds;
		}
		
		if(sizeof($json_admin_action_result)>29){
				unset($json_admin_action_result_Arr[1]);					
		}

		$json_admin_action_result_Arr[] = array($AdmEmail,$mode,$table,$data,date('Y-m-d H:i:s'),$_SERVER['REMOTE_ADDR']);
		
			
		$file = 'fc_admin_action_settings.php';
		file_put_contents($file, serialize($json_admin_action_result_Arr));
			
		
		$this->db->where_in($column,$data);
		if (strtolower($mode) == 'delete'){
			/*
			$this->db->delete($table);
			if($table==USERS)
			{
			$this->db->where_in('user_id',$data);
			$this->db->delete(EXPERIENCE);
			}
			*/

			//to avoid invalid data display in previous orders page,delete query is avoided instead of that 'experience status' of experience  only changes  ; 

			$newdata = array('status' => '2');
			$condition = array('experience_id' => $product_id);

			//$statusArr = array('status' => $mode);
			//$statusArr = array('status' => 2);
			$this->db->update(EXPERIENCE,$newdata);
			$this->db->update(EXPERIENCE_PHOTOS,array('status' => 'Delete' ));
			$this->db->update(EXPERIENCE_ADDR,$newdata);
			$this->db->update(EXPERIENCE_DATES,$newdata);
			$this->db->update(EXPERIENCE_TIMING,$newdata);
			$this->db->update(EXPERIENCE_GUIDE_PROVIDES,$newdata);
			
		}else {
			$statusArr = array('status' => $mode);
			$this->db->update($table,$statusArr);
					//echo $this->db->last_query(); die;
/* 			$statusArr = array('subscriber' => "Yes");
			$this->db->update($table,$statusArr); */
		}
		//echo $this->db->last_query(); die;
	}
	

	/*********Single experience details*********/
	function view_experience_details_site_one($where1,$where_or,$where2)
	{
		$this->db->cache_on();
		$this->db->select('p.*,extyp.experience_title as type_title,
		pa.country,pa.state,pa.city,pa.zip as post_code,pa.address,pa.lat as latitude,pa.lang as longitude, 
		u.firstname,u.created as user_created,u.response_rate,u.description as description1,u.phone_no,u.group,u.s_phone_no,u.about,u.email as RenterEmail,u.image as thumbnail, u.about, u.loginUserType,u.id_verified, pa.country as Country_name, pa.state as State_name,
		pa.city as CityName, u.host_status,u.status as host_login_status');
		$this->db->from(EXPERIENCE.' as p');
		$this->db->join(EXPERIENCE_TYPE.' as extyp',"extyp.id=p.type_id","LEFT");
		$this->db->join(EXPERIENCE_ADDR.' as pa',"pa.experience_id=p.experience_id","LEFT");
		$this->db->join(USERS.' as u',"u.id=p.user_id","LEFT");
		$this->db->where($where1);
		$this->db->or_where($where_or);
		$this->db->where($where2);
		$this->db->where(array("u.host_status"=>'0'));
		$this->db->group_by('p.experience_id');
		//$this->db->where('p.status','Publish');
		return $query = $this->db->get();
		//echo $this->db->last_query();
		//$result =$query->result_array();
		//echo "<pre>";print_r($result);die;
	}

	public function view_product_details_distance_list($lat,$lon,$condition = ''){
		$this->db->cache_on();
		$aLong = $lon+0.05;
		$bLong = $lon-0.05;
		$aLat = $lat+0.05;
		$bLat = $lat-0.05;
		$whereNew = 'where (pa.lat < '.$aLat.' AND pa.lat > '.$bLat.' AND pa.lang < '.$aLong.' AND pa.lang >'.$bLong.') AND '.$condition;
		
		$select_qry = "select p.experience_id as id, p.experience_title as product_title, pa.city as city_name, pa.lat as latitude, pa.lang as longitude, u.firstname, u.lastname, u.image as user_image, u.id as userId, ph.product_image as PImg
        FROM ".EXPERIENCE." p 
		LEFT JOIN ".EXPERIENCE_ADDR." pa on pa.experience_id=p.experience_id
		LEFT JOIN ".EXPERIENCE_PHOTOS." ph on p.experience_id=ph.product_id
		LEFT JOIN ".USERS." u on u.id=p.user_id ".$whereNew;
		$distanceList = $this->ExecuteQuery($select_qry);
		return $distanceList;
		
		/* $select_qry = "select p.id,p.room_type,p.product_title,c.name as city_name,u.firstname,u.lastname,u.image as user_image,u.id as userId,ph.product_image as PImg,p.price,
		ROUND( 3963.0 * ACOS( SIN( '".$lat."' * PI( ) /180 ) * SIN( latitude * PI( ) /180 ) + COS( '".$lat."' * PI( ) /180 ) * COS( latitude * PI( ) /180 ) * COS( (longitude * PI( ) /180 ) - ( '".$lon."' * PI( ) /180 ) ) ) , 1) AS distance
		FROM ".PRODUCT." p 
		LEFT JOIN ".PRODUCT_ADDRESS." pa on pa.product_id=p.id
		LEFT JOIN ".CITY." c on c.id=pa.city
		LEFT JOIN ".PRODUCT_PHOTOS." ph on p.id=ph.product_id
		LEFT JOIN ".USERS." u on u.id=p.user_id ".$condition;
		$distanceList = $this->ExecuteQuery($select_qry);
		return $distanceList; */
			
	}

	/* get available dates for booking */
	public function getAvailableDates($product_id,$date){

		$this->db->select("d.*,exp.group_size,(select IFNULL(count(eq.date_id),0) from ".EXPERIENCE_ENQUIRY." as eq where eq.date_id=d.id and eq.booking_status='".Booked."') as date_booked_count",FALSE);
		$this->db->from(EXPERIENCE_DATES.' as d');
		$this->db->join(EXPERIENCE.' as exp',"exp.experience_id=d.experience_id","LEFT");
		$this->db->where('d.experience_id',$product_id);
		$this->db->where('d.from_date >',$date);
		$this->db->where('d.status ','0');
		$this->db->where('exp.status ','1');
		$this->db->order_by('d.id');

		return $query = $this->db->get();
	}
	
	
	
	/* get available dates for booking on given date */
	public function getChoosedDates($product_id,$check_In,$check_Out){
		
		$this->db->select("d.*,exp.group_size,(select IFNULL(count(eq.date_id),0) from ".EXPERIENCE_ENQUIRY." as eq where eq.date_id=d.id and eq.booking_status='".Booked."') as date_booked_count",FALSE);
		$this->db->from(EXPERIENCE_DATES.' as d');
		$this->db->join(EXPERIENCE.' as exp',"exp.experience_id=d.experience_id","LEFT");
		$this->db->where('d.experience_id',$product_id);
		
		if ($check_In!='' && $check_Out!=''){
			$this->db->where('d.from_date >',$check_In);
			$this->db->where('d.to_date <=',$check_Out);
		}else if ($check_In!='' && $check_Out==''){
			$this->db->where('d.from_date >',$check_In);
		}else if ($check_In=='' && $check_Out!=''){
			$this->db->where('d.to_date <=',$check_Out);
		}
		$this->db->where('d.status ','0');
		$this->db->where('exp.status ','1');
		$this->db->order_by('d.id');
		return $query = $this->db->get();
	}
	

	/*  date schedule data  */
	public function getDateSchedule($dateId){
		$this->db->select('d.*');
		$this->db->from(EXPERIENCE_TIMING.' as d');
		$this->db->join(EXPERIENCE.' as exp',"exp.experience_id=d.experience_id","LEFT");
		$this->db->where('d.exp_dates_id ',$dateId);
		$this->db->where('d.status ','1');
		$this->db->where('exp.status ','1');
		$this->db->order_by('d.id');

		//return 
		return $query = $this->db->get();
		//echo $this->db->last_query();
	}

	/* user booking details to send mail */
	public function getbookeduser_detail($id) {
		$this->db->cache_on();
		$this->db->reconnect();
	    $this->db->select('rq.numofdates as noofdates,rq.checkin as checkin,rq.checkout as checkout,rq.renter_id as renter_id,rq.unitPerCurrencyUser,rq.user_currencycode,p.price,u.email as email,u.user_name as name,p.experience_title as productname,p.experience_id as prd_id');
		$this->db->from(EXPERIENCE_ENQUIRY.' as rq');		
		$this->db->join(USERS.' as u',"u.id=rq.user_id","LEFT");
		$this->db->join(EXPERIENCE.' as p',"p.experience_id=rq.prd_id","LEFT");
		$this->db->join(EXPERIENCE_DATES.' as d',"d.id=rq.date_id","LEFT");

		$this->db->where('rq.id',$ids);
		$this->db->limit(15, 0);
		return $query = $this->db->get();
	}

	public function getproductimage($prd_id) {
	$this->db->cache_on();
	    $this->db->select('product_image');
		$this->db->from(EXPERIENCE_PHOTOS);		
		$this->db->where('product_id',$prd_id);
		return $query = $this->db->get();
	}

	/************Booking experience Details***************/

	public function view_product_details_booking($condition = ''){
		$this->db->cache_on();
	//u.firstname,u.lastname,u.address as UserAddress,u.city as UserCity,u.state as UserState,u.country as UserCountry,u.postal_code as UserPostCode,
		$select_qry = "select p.*,p.experience_id as id,
						u.id as userid,u.user_name,u.email,u.phone_no,u.address,u.feature_product,u.image as userphoto,
						pa.lat as latitude,pa.lang as longitude,pa.address,pa.zip as post_code,
						c.name as city_name,
						rq.checkin,rq.checkout,rq.NoofGuest,rq.numofdates,rq.serviceFee,rq.totalAmt,rq.Bookingno as Bookingno,rq.secDeposit,rq.cleaningFee,rq.currencycode as currency,rq.date_id,rq.unitPerCurrencyUser,rq.user_currencycode,
						s.name as statename,s.meta_title as statemtitle,s.meta_keyword as statemkey,s.meta_description as statemdesc,s.seourl as stateurl,
						pp.product_image from ".EXPERIENCE." p 
		LEFT JOIN ".EXPERIENCE_ADDR." pa on pa.experience_id=p.experience_id
		LEFT JOIN ".CITY." c on c.id=pa.city
		LEFT JOIN ".EXPERIENCE_ENQUIRY." rq on rq.prd_id=p.experience_id
		LEFT JOIN ".STATE_TAX." s on s.id=pa.state
		LEFT JOIN ".EXPERIENCE_PHOTOS." pp on pp.product_id=p.experience_id
		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		$productList = $this->ExecuteQuery($select_qry);
		//echo $this->db->last_query();
		//echo "<pre>";print_r($result); die;
		return $productList;
			
	}

	/************Booking User Details***************/
	public function view_user_details_booking($condition = ''){
		$this->db->cache_on();
		$select_qry = "select u.id as userid,u.user_name,u.email, u.phone_no, rq.NoofGuest,u.feature_product,u.image as userphoto,u.firstname,u.lastname,u.address as UserAddress,u.city as UserCity,u.state as UserState,u.country as UserCountry,u.postal_code as UserPostCode,rq.serviceFee,rq.totalAmt,rq.unitPerCurrencyUser,rq.user_currencycode
						 from ".EXPERIENCE." p 
		LEFT JOIN ".EXPERIENCE_ENQUIRY." rq on rq.prd_id=p.experience_id
		LEFT JOIN ".USERS." u on (u.id=rq.user_id) ".$condition;
		$productList = $this->ExecuteQuery($select_qry);
		//echo $this->db->last_query();
		//echo "<pre>";print_r($productList->result()); die;
		return $productList;
			
	}

	/*  add review */

	public function add_review($dataArr=''){
		$this->db->cache_on();
		return $this->db->insert(EXPERIENCE_REVIEW,$dataArr);
	}

	/* get review details */

	function get_productreview_byyou($user_id='',$pageLimitStart,$searchPerPage)

	{

		$this->db->select('r.*,p.experience_title as product_title,u.image,u.firstname');

		$this->db->from(EXPERIENCE_REVIEW.' as r');

		$this->db->where('r.reviewer_id', $user_id);

		$this->db->join(EXPERIENCE.' as p',"r.product_id=p.experience_id");
		//$this->db->join(EXPERIENCE_PHOTOS.' as Ph',"Ph.product_id=p.experience_id");

		$this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");
		$this->db->order_by("r.dateAdded","desc");
		$this->db->limit($searchPerPage,$pageLimitStart);
		//$this->db->group_by('p.experience_id'); 
		return $query = $this->db->get_where();

	}
	function get_productreview_byyou_site_map($user_id='')

	{

		$this->db->select('r.*,p.experience_title as product_title,u.image,u.firstname');

		$this->db->from(EXPERIENCE_REVIEW.' as r');

		$this->db->where('r.reviewer_id', $user_id);

		$this->db->join(EXPERIENCE.' as p',"r.product_id=p.experience_id");
		//$this->db->join(EXPERIENCE_PHOTOS.' as Ph',"Ph.product_id=p.experience_id");

		$this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");
		//$this->db->group_by('p.experience_id'); 
		return $query = $this->db->get_where();

	}

	function get_productreview_aboutyou($user_id='',$pageLimitStart,$searchPerPage)

	{

		$this->db->select('r.*,p.experience_title as product_title,u.image,u.firstname');

		$this->db->from(EXPERIENCE_REVIEW.' as r');

		$this->db->where('r.user_id', $user_id);

		$this->db->join(EXPERIENCE.' as p',"r.product_id=p.experience_id");

		$this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");
		
		$this->db->order_by("r.dateAdded","desc");

		$this->db->limit($searchPerPage,$pageLimitStart);

		return $query = $this->db->get_where();

	}

	function get_productreview_aboutyou_site_map($user_id='')

	{

		$this->db->select('r.*,p.experience_title as product_title,u.image,u.firstname');

		$this->db->from(EXPERIENCE_REVIEW.' as r');

		$this->db->where('r.user_id', $user_id);

		$this->db->join(EXPERIENCE.' as p',"r.product_id=p.experience_id");

		$this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");

		return $query = $this->db->get_where();

	}
	/* get review details ends */	


	/* get dispute details starts */	
	function get_productdispute_byyou($user_id='',$pageLimitStart,$searchPerPage)
	{

		$this->db->select('d.*,p.experience_title as product_title,u.image');

		$this->db->from(EXPERIENCE_DISPUTE.' as d');

		$this->db->where('d.user_id', $user_id);

		$this->db->join(EXPERIENCE.' as p',"d.prd_id=p.experience_id");

		$this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");

		$this->db->limit($searchPerPage,$pageLimitStart);

		return $query = $this->db->get_where();

	}
	function get_productdispute_byyou_site_map($user_id='')
	{

		$this->db->select('d.*,p.experience_title as product_title,u.image');

		$this->db->from(EXPERIENCE_DISPUTE.' as d');

		$this->db->where('d.user_id', $user_id);

		$this->db->join(EXPERIENCE.' as p',"d.prd_id=p.experience_id");

		$this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");

		return $query = $this->db->get_where();

	}
	function get_productdispute_aboutyou($user_id='',$pageLimitStart,$searchPerPage)

	{
		

		$this->db->select('d.*,p.experience_title as product_title,p.user_id,u.image');

		$this->db->from(EXPERIENCE_DISPUTE.' as d');

		$this->db->where('d.disputer_id', $user_id);
		$this->db->where('d.cancel_status', 0);
		$this->db->join(EXPERIENCE.' as p',"d.prd_id=p.experience_id");

		$this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");
		$this->db->limit($searchPerPage,$pageLimitStart);
		return $query = $this->db->get_where();

	}

	function get_productdispute_aboutyou_site_map($user_id='')

	{
		

		$this->db->select('d.*,p.experience_title as product_title,p.user_id,u.image');

		$this->db->from(EXPERIENCE_DISPUTE.' as d');

		$this->db->where('d.disputer_id', $user_id);
		$this->db->where('d.cancel_status', 0);
		$this->db->join(EXPERIENCE.' as p',"d.prd_id=p.experience_id");

		$this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");

		return $query = $this->db->get_where();

	}

	/* get dispute details ends */	

	/*get cancel booking dispute details*/
	function get_cancel_dispute($user_id='',$pageLimitStart,$searchPerPage)
	{
		//print_r($user_id);exit;
		$this->db->select('d.*,p.experience_title as product_title,p.user_id,u.image');

			$this->db->from(EXPERIENCE_DISPUTE.' as d');

			$this->db->where('d.disputer_id', $user_id);
			
			$this->db->where('d.cancel_status', 1);

			$this->db->join(EXPERIENCE.' as p',"d.prd_id=p.experience_id");

			$this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");

			return $query = $this->db->get_where();
	}

	function get_cancel_dispute_site_map($user_id='')
	{
		//print_r($user_id);exit;
		$this->db->select('d.*,p.experience_title as product_title,p.user_id,u.image');

			$this->db->from(EXPERIENCE_DISPUTE.' as d');

			$this->db->where('d.disputer_id', $user_id);
			
			$this->db->where('d.cancel_status', 1);

			$this->db->join(EXPERIENCE.' as p',"d.prd_id=p.experience_id");

			$this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");

			return $query = $this->db->get_where();
	}
	/*End */

	/*  transaction diplay details */

	public function get_featured_transaction($email,$pageLimitStart,$searchPerPage)
	{
		$this->db->select('CT.dateAdded, U.id as GestId, U.firstname, P.experience_id as product_id, P.experience_title as product_title, P.price,P.currency, RQ.Bookingno, CT.total_amount as totalAmt, RQ.unitPerCurrencyUser,RQ.user_currencycode,RQ.currencyPerUnitSeller,RQ.checkin,RQ.date_id,RQ.checkout,CT.guest_fee, CT.host_fee, CT.payable_amount');
		$this->db->from(EXP_COMMISSION_TRACKING.' as CT');
		$this->db->join(EXPERIENCE_ENQUIRY.' as RQ' , 'RQ.Bookingno = CT.booking_no','LEFT');
		$this->db->join(EXPERIENCE.' as P' , 'P.experience_id = RQ.prd_id','LEFT');
		$this->db->join(USERS.' as U' , 'U.id = RQ.user_id','LEFT');
		$this->db->where('CT.host_email',$email);
		$this->db->where('CT.paid_status','no');
		$this->db->order_by('CT.dateAdded', 'desc');
		$this->db->limit($searchPerPage,$pageLimitStart);
		return $resultArr = $this->db->get();
	}

	public function get_featured_transaction_site_map($email)
	{
		$this->db->select('CT.dateAdded, U.id as GestId, U.firstname, P.experience_id as product_id, P.experience_title as product_title, P.price,P.currency, RQ.Bookingno, CT.total_amount as totalAmt, RQ.unitPerCurrencyUser,RQ.user_currencycode,RQ.currencyPerUnitSeller,RQ.checkin,RQ.checkout,CT.guest_fee, CT.host_fee, CT.payable_amount');
		$this->db->from(EXP_COMMISSION_TRACKING.' as CT');
		$this->db->join(EXPERIENCE_ENQUIRY.' as RQ' , 'RQ.Bookingno = CT.booking_no','LEFT');
		$this->db->join(EXPERIENCE.' as P' , 'P.experience_id = RQ.prd_id','LEFT');
		$this->db->join(USERS.' as U' , 'U.id = RQ.user_id','LEFT');
		$this->db->where('CT.host_email',$email);
		$this->db->where('CT.paid_status','no');
		$this->db->order_by('CT.dateAdded', 'desc');
		return $resultArr = $this->db->get();
	}
	
	public function get_completed_transaction($email,$pageLimitStart,$searchPerPage)
	{
		$this->db->select('dateAdded, transaction_id ,amount');
		$this->db->from(EXP_COMMISSION_PAID.' as CP');
		$this->db->where('CP.host_email',$email);
		$this->db->order_by('CP.dateAdded', 'desc');
		$this->db->limit($searchPerPage,$pageLimitStart);
		return $resultArr = $this->db->get();
	}

	public function get_completed_transaction_site_map($email)
	{
		$this->db->select('dateAdded, transaction_id ,amount');
		$this->db->from(EXP_COMMISSION_PAID.' as CP');
		$this->db->where('CP.host_email',$email);
		$this->db->order_by('CP.dateAdded', 'desc');
		return $resultArr = $this->db->get();
	}

	/*  transaction diplay details  ends */

	/* my experience upcoming */

	public function booked_rental_trip($prd_id='',$keyword,$pageLimitStart,$searchPerPage)
		{
			//print_r($prd_id);
			$this->db->select('rq.prd_id as product_id, pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.host_status,p.user_id,p.security_deposit, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.serviceFee, rq.totalAmt,rq.secDeposit, rq.cleaningFee,rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno,rq.walletAmount,rq.unitPerCurrencyUser,rq.date_id,rq.user_currencycode,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt,p.currency, p.price,p.group_size'); 
			
			$this->db->from(EXPERIENCE_ENQUIRY.' as rq');
			//$this->db->join(PRODUCT_BOOKING.' as pb' , 'pb.product_id = rq.prd_id', 'left'); //pb.*,
			$this->db->join(EXPERIENCE.' as p' , 'p.experience_id = rq.prd_id','left');
			$this->db->join(EXPERIENCE_ADDR.' as pn' , 'pn.experience_id = p.experience_id','left');

			$this->db->join(EXPERIENCE_DATES.' as d',"d.id=rq.date_id","LEFT");

			$this->db->join(EXPERIENCE_PHOTOS.' as pp' , 'p.experience_id = pp.product_id','left');
			$this->db->join(EXPERIENCE_BOOKING_PAYMENT.' as pay' , 'pay.product_id = p.experience_id','left');
			$this->db->join(USERS.' as u' , 'u.id = rq.renter_id');
			$this->db->where('rq.user_id = ',$prd_id);
			$this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
			if($keyword !="")
			{
				$this->db->where("(p.experience_title LIKE '%$keyword%' OR u.firstname LIKE '%$keyword%' OR pn.address LIKE '%$keyword%')");
				//$this->db->or_like('u.firstname',$keyword);
				//$this->db->or_like('pn.address',pn.address);
			}
			else
			{
				$this->db->where('rq.booking_status != "Enquiry"');
			}
			$this->db->group_by('rq.id');
			$this->db->order_by('rq.dateAdded', 'desc');
			$this->db->limit($searchPerPage,$pageLimitStart);
			/* $this->db->get();
			echo $this->db->last_query();die; */
			return $this->db->get();
		}

		
		
		

		public function booked_rental_trip_site_map($prd_id='',$keyword)
		{
			//print_r($prd_id);
			$this->db->select('rq.prd_id as product_id, pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.host_status,p.user_id,p.security_deposit, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.serviceFee, rq.totalAmt,rq.secDeposit, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno,rq.walletAmount,rq.unitPerCurrencyUser,rq.user_currencycode,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt,p.currency, p.price'); 
			
			$this->db->from(EXPERIENCE_ENQUIRY.' as rq');
			//$this->db->join(PRODUCT_BOOKING.' as pb' , 'pb.product_id = rq.prd_id', 'left'); //pb.*,
			$this->db->join(EXPERIENCE.' as p' , 'p.experience_id = rq.prd_id','left');
			$this->db->join(EXPERIENCE_ADDR.' as pn' , 'pn.experience_id = p.experience_id','left');

			$this->db->join(EXPERIENCE_DATES.' as d',"d.id=rq.date_id","LEFT");

			$this->db->join(EXPERIENCE_PHOTOS.' as pp' , 'p.experience_id = pp.product_id','left');
			$this->db->join(EXPERIENCE_BOOKING_PAYMENT.' as pay' , 'pay.product_id = p.experience_id','left');
			$this->db->join(USERS.' as u' , 'u.id = rq.renter_id');
			$this->db->where('rq.user_id = ',$prd_id);
			$this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
			if($keyword !="")
			{
				$this->db->where("(p.experience_title LIKE '%$keyword%' OR u.firstname LIKE '%$keyword%' OR pn.address LIKE '%$keyword%')");
				//$this->db->or_like('u.firstname',$keyword);
				//$this->db->or_like('pn.address',pn.address);
			}
			else
			{
				$this->db->where('rq.booking_status != "Enquiry"');
			}
			$this->db->group_by('rq.id');
			$this->db->order_by('rq.dateAdded', 'desc');
			/* $this->db->get();
			echo $this->db->last_query();die; */
			return $this->db->get();
		}

	/*  my experience previous */
	function booked_rental_trip_prev($prd_id='',$product_title,$pageLimitStart,$searchPerPage)

	{

		$this->db->select(' rq.prd_id as product_id,pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name,  p.experience_title as product_name, p.experience_title as product_title, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.secDeposit, rq.serviceFee, , rq.totalAmt, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno, rq.walletAmount,rq.unitPerCurrencyUser,rq.date_id,rq.user_currencycode,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt,p.currency, p.price');

		$this->db->from(EXPERIENCE_ENQUIRY.' as rq'); 

		$this->db->join(EXPERIENCE.' as p' , 'p.experience_id = rq.prd_id','left');
		$this->db->join(EXPERIENCE_DATES.' as d',"d.id=rq.date_id","LEFT");

		$this->db->join(EXPERIENCE_ADDR.' as pn' , 'pn.experience_id = p.experience_id','left');

		$this->db->join(EXPERIENCE_PHOTOS.' as pp' , 'p.experience_id = pp.product_id','left');
		
		$this->db->join(EXPERIENCE_BOOKING_PAYMENT.' as pay' , 'pay.product_id = p.experience_id','left');			

		$this->db->join(USERS.' as u' , 'u.id = rq.renter_id');

		$this->db->where('rq.user_id = '.$prd_id);

		$this->db->where('DATE(rq.checkout) <= ', date('"Y-m-d H:i:s"'), FALSE); //dec5 <= dec8

		if($product_title !="")
		{

		$this->db->like('p.experience_title',$keyword);

		$this->db->or_like('u.firstname',$keyword);

		$this->db->or_like('pn.address',$keyword);

		}else{

		$this->db->where('rq.booking_status != "Enquiry"');

		}

		$this->db->group_by('rq.id');

		$this->db->order_by('rq.dateAdded', 'desc');
		$this->db->limit($searchPerPage,$pageLimitStart);

		/* $this->db->get();

		echo $this->db->last_query();die; */

		return $this->db->get();

	}

	function booked_rental_trip_prev_site_map($prd_id='',$product_title)

	{

		$this->db->select(' rq.prd_id as product_id,pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name,  p.experience_title as product_name, p.experience_title as product_title, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.secDeposit, rq.serviceFee, , rq.totalAmt, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno, rq.walletAmount,rq.unitPerCurrencyUser,rq.user_currencycode,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt,p.currency, p.price');

		$this->db->from(EXPERIENCE_ENQUIRY.' as rq');

		$this->db->join(EXPERIENCE.' as p' , 'p.experience_id = rq.prd_id','left');
		$this->db->join(EXPERIENCE_DATES.' as d',"d.id=rq.date_id","LEFT");

		$this->db->join(EXPERIENCE_ADDR.' as pn' , 'pn.experience_id = p.experience_id','left');

		$this->db->join(EXPERIENCE_PHOTOS.' as pp' , 'p.experience_id = pp.product_id','left');
		
		$this->db->join(EXPERIENCE_BOOKING_PAYMENT.' as pay' , 'pay.product_id = p.experience_id','left');			

		$this->db->join(USERS.' as u' , 'u.id = rq.renter_id');

		$this->db->where('rq.user_id = '.$prd_id);

		$this->db->where('DATE(rq.checkout) <= ', date('"Y-m-d H:i:s"'), FALSE);

		if($product_title !="")
		{

		$this->db->like('p.experience_title',$keyword);

		$this->db->or_like('u.firstname',$keyword);

		$this->db->or_like('pn.address',$keyword);

		}else{

		$this->db->where('rq.booking_status != "Enquiry"');

		}

		$this->db->group_by('rq.id');

		$this->db->order_by('rq.dateAdded', 'desc');

		/* $this->db->get();

		echo $this->db->last_query();die; */

		return $this->db->get();

	}

	/* experience trip review  */

	public function get_trip_review($bookingno='',$reviewer_id='')
	{
		$this->db->cache_on();
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW.' as p');
		$this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");
		$this->db->where('p.bookingno',$bookingno);
		if($reviewer_id !='')
		{
			$this->db->where('p.reviewer_id',$reviewer_id);
		}
		$query = $this->db->get();
		return $query;
	}
	
	public function get_trip_review_all($reviewer_id='')
	{
		$this->db->cache_on();
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW.' as p');
		$this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");
		if($reviewer_id !='')
		{
			$this->db->where('p.reviewer_id',$reviewer_id);
		}
		$query = $this->db->get();
		return $query;
	}


	function get_contents() {
        $this->db->select('*');
        $this->db->from(EXPERIENCE);
        $query = $this->db->get();
        return $result = $query->result();
    }

    function booked_rental_future($prd_id='',$pageLimitStart,$searchPerPage)
	{
		$cur_date = date('Y-m-d');
		$this->db->select('p.*,p.experience_id as product_id,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.unitPerCurrencyUser,rq.date_id,rq.user_currencycode,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');

		$this->db->from(EXPERIENCE.' as p');
		$this->db->join(EXPERIENCE_ADDR.' as pa' , 'pa.experience_id = p.experience_id','left');			
		$this->db->join(EXPERIENCE_ENQUIRY.' as rq' , 'p.experience_id = rq.prd_id');
		$this->db->join(USERS.' as u' , 'u.id = rq.user_id');
		$this->db->where('p.user_id = '.$prd_id);
		$this->db->where('DATE(rq.checkin) >= "'.$cur_date.'"');
		$this->db->where('rq.renter_id = '.$prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->limit($searchPerPage,$pageLimitStart);
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded','desc');
		return $this->db->get();
		
		//echo $this->db->last_query();exit;
	}

	function booked_rental_future_site_map($prd_id='')
	{
		$cur_date = date('Y-m-d');
		$this->db->select('p.*,p.experience_id as product_id,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.unitPerCurrencyUser,rq.user_currencycode,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');

		$this->db->from(EXPERIENCE.' as p');
		$this->db->join(EXPERIENCE_ADDR.' as pa' , 'pa.experience_id = p.experience_id','left');			
		$this->db->join(EXPERIENCE_ENQUIRY.' as rq' , 'p.experience_id = rq.prd_id');
		$this->db->join(USERS.' as u' , 'u.id = rq.user_id');
		$this->db->where('p.user_id = '.$prd_id);
		$this->db->where('DATE(rq.checkin) >= "'.$cur_date.'"');
		$this->db->where('rq.renter_id = '.$prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded','desc');
		return $this->db->get();
		
		//echo $this->db->last_query();exit;
	}

	function booked_rental_passed($prd_id='',$pageLimitStart,$searchPerPage)
		{
			$cur_date = date('Y-m-d');
			$this->db->select('p.*,p.experience_id as product_id,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.unitPerCurrencyUser,rq.user_currencycode,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');

			$this->db->from(EXPERIENCE.' as p');
			$this->db->join(EXPERIENCE_ADDR.' as pa' , 'pa.experience_id = p.experience_id','left');
			$this->db->join(EXPERIENCE_ENQUIRY.' as rq' , 'p.experience_id = rq.prd_id');
			$this->db->join(USERS.' as u' , 'u.id = rq.user_id');
			$this->db->where('p.user_id = '.$prd_id);
			$this->db->where('DATE(rq.checkin) < "'.$cur_date.'"');
			$this->db->where('rq.renter_id = '.$prd_id);
			$this->db->where('rq.booking_status != "Enquiry"');
			$this->db->group_by('rq.id');
			$this->db->order_by('rq.dateAdded','desc');
			$this->db->limit($searchPerPage,$pageLimitStart);
			return $this->db->get();
			
			//echo $this->db->last_query();die;
		}

		function booked_rental_passed_site_map($prd_id='')
		{
			$cur_date = date('Y-m-d');
			$this->db->select('p.*,p.experience_id as product_id,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.unitPerCurrencyUser,rq.user_currencycode,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');

			$this->db->from(EXPERIENCE.' as p');
			$this->db->join(EXPERIENCE_ADDR.' as pa' , 'pa.experience_id = p.experience_id','left');
			$this->db->join(EXPERIENCE_ENQUIRY.' as rq' , 'p.experience_id = rq.prd_id');
			$this->db->join(USERS.' as u' , 'u.id = rq.user_id');
			$this->db->where('p.user_id = '.$prd_id);
			$this->db->where('DATE(rq.checkin) < "'.$cur_date.'"');
			$this->db->where('rq.renter_id = '.$prd_id);
			$this->db->where('rq.booking_status != "Enquiry"');
			$this->db->group_by('rq.id');
			$this->db->order_by('rq.dateAdded','desc');
			return $this->db->get();
			
			//echo $this->db->last_query();die;
		}

	public function get_med_messages($userId,$pageLimitStart,$searchPerPage)
	{
		/*$this->db->select('*');
		$this->db->from(EXPERIENCE_MED_MSG);
		$this->db->where_in('receiverId',$userId);
		$this->db->group_by('bookingNo');
		$this->db->order_by('dateAdded', 'desc');
		return $resultArr = $this->db->get();
		*/
		$sql="SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from ".EXPERIENCE_MED_MSG." as ms,".EXPERIENCE." as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=".$userId." and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from ".EXPERIENCE_MED_MSG." as m , ".EXPERIENCE." as p  WHERE m.productId=p.experience_id AND m.receiverId=".$userId." group by m.bookingNo order by m.dateAdded desc limit ".$pageLimitStart.",".$searchPerPage."";
		
		$result=$this->db->query($sql);
		
		return $result->result();
		
	}

	public function get_med_messages_site_map($userId)
	{
		/*$this->db->select('*');
		$this->db->from(EXPERIENCE_MED_MSG);
		$this->db->where_in('receiverId',$userId);
		$this->db->group_by('bookingNo');
		$this->db->order_by('dateAdded', 'desc');
		return $resultArr = $this->db->get();
		*/
		$sql="SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from ".EXPERIENCE_MED_MSG." as ms,".EXPERIENCE." as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=".$userId." and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from ".EXPERIENCE_MED_MSG." as m , ".EXPERIENCE." as p  WHERE m.productId=p.experience_id AND m.receiverId=".$userId." group by m.bookingNo order by m.dateAdded desc";
		
		$result=$this->db->query($sql);
		
		return $result->result();
		
	}

	public function get_booking_details($bookingNo){
		$this->db->cache_on();
		$this->db->reconnect();
		$this->db->select('rq.id, rq.checkin, rq.checkout, rq.Bookingno, rq.subTotal, rq.serviceFee, rq.totalAmt, rq.NoofGuest, rq.renter_id, rq.secDeposit,rq.unitPerCurrencyUser,rq.user_currencycode, p.experience_title as product_title, p.currency,p.experience_id');
		$this->db->from(EXPERIENCE_ENQUIRY.' as rq');
		$this->db->join(EXPERIENCE.' as p',"p.experience_id=rq.prd_id","left");
		$this->db->where('Bookingno', $bookingNo);
		return $query = $this->db->get();
	}

	/* wishlist */

	public function get_wishlistphoto($condition = '')
	{
		$this->db->cache_on();
		$this->db->select('product_image,product_id');
		$this->db->from(EXPERIENCE_PHOTOS);
		$this->db->where('product_id',$condition);
		return $query = $this->db->get();
	}

	public function get_experience_details_wishlist_one_category($condition = ''){
		$this->db->cache_on();
		$this->db->select('pa.city as name,p.experience_id, p.experience_title as product_name, p.currency, p.experience_title as product_title,  p.price, n.id as nid, n.notes, p.experience_id as id, pa.address, pa.zip as post_code');
		$this->db->from(EXPERIENCE.' as p');
		$this->db->join(EXPERIENCE_ADDR.' as pa',"pa.experience_id=p.experience_id","LEFT");
		$this->db->join(EXPERIENCE_PHOTOS.' as pp',"pp.product_id=p.experience_id","LEFT");
		$this->db->join(NOTES.' as n',"n.experience_id=p.experience_id","LEFT");
		$this->db->where_in('p.experience_id',$condition);
		$this->db->group_by('p.experience_id');
		$this->db->order_by('pp.imgPriority','asc');
		return $query = $this->db->get();	
	
	}

	public function get_product_details_wishlist($condition = ''){
		$this->db->cache_on();
		$this->db->select('pa.city as name, p.experience_title as product_name, pp.product_image, p.experience_id as id, p.experience_title as product_title, pa.country as Country_name,pa.state as State_name,pa.city as CityName');
		$this->db->from(EXPERIENCE.' as p');
		$this->db->join(EXPERIENCE_ADDR.' as pa',"pa.experience_id=p.experience_id","LEFT");
		$this->db->join(EXPERIENCE_PHOTOS.' as pp',"pp.product_id=p.experience_id","LEFT");
		$this->db->where('p.experience_id',$condition);
		$this->db->where('p.status','1');
		$this->db->order_by('pp.imgPriority','asc');
		return $query = $this->db->get();
			
	}


	public function get_list_details_wishlist($condition = ''){
		$this->db->cache_on();
		 $select_qry = "select id,name,product_id,experience_id,last_added from ".LISTS_DETAILS." where user_id=".$condition."  or user_id=0"; 
		$productList = $this->ExecuteQuery($select_qry);
		//echo $this->db->last_query(); die;
		return $productList;
			
	}
	
	public function get_notes_added($Rental_id,$user_id){
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from(NOTES);
		$this->db->where('experience_id',$Rental_id);
		$this->db->where('user_id',$user_id);
		return $query = $this->db->get();
	}
	public function get_booked_exp_details($booked,$exp_id){
		$this->db->select('*');
		$this->db->from(EXPERIENCE_ENQUIRY);
		$this->db->where($booked);
		$this->db->where('prd_id',$exp_id);
		return $query = $this->db->get();
	}


	public function update_wishlist($dataStr='',$condition1=''){
		$this->db->cache_on();

		$last_added = '2'; // experience

		$sel_qry = "select experience_id,id from ".LISTS_DETAILS." where user_id=".$this->data['loginCheck']."";
		$ListVal = $this->ExecuteQuery($sel_qry);
		
		if($ListVal->num_rows() > 0){
			foreach($ListVal->result() as $wlist){
		
			$productArr=@explode(',',$wlist->experience_id);
				if(!empty($productArr)){
					if(in_array($dataStr,$productArr)){
						$conditi = array('id' => $wlist->id);
						//$WishListCatArr = @explode(',',$this->data['WishListCat']->row()->product_id);
						$my_array = array_filter($productArr);
						$to_remove =(array)$dataStr;
						$result = array_diff($my_array, $to_remove);
						
						$resultStr =implode(',',$result);
						if($resultStr!=''){
							$last_added = '2';
						}else{
							$last_added = '1';
						}
						//echo $last_added = '1';exit();
						$this->updateWishlistRentals(array('experience_id' =>$resultStr,'last_added'=> $last_added),$conditi);
					}
				}
			}
		}
		
		if(!empty($condition1)){
			foreach($condition1 as $wcont){
				$select_qry = "select experience_id from ".LISTS_DETAILS." where id=".$wcont."";
				$productList = $this->ExecuteQuery($select_qry);
				$productIdArr=explode(',',$productList->row()->experience_id);
		
				if(!empty($productIdArr)){
					if(!in_array($dataStr,$productIdArr)){
						$select_qry = "update ".LISTS_DETAILS." set experience_id= concat(experience_id,',".$dataStr."'),last_added ='".$last_added."' where id=".$wcont."";
						$productList = $this->ExecuteQuery($select_qry);
					}
				}
			}
		}
	}

	public function updateWishlistRentals($dataArr='',$condition=''){
		$this->db->cache_on();
			$this->db->where($condition);
			$this->db->update(LISTS_DETAILS,$dataArr);
	}


	public function update_notes($dataArr='',$condition='')
	{
		$this->db->cache_on();
		if($condition=='')
		{
		$this->db->insert(NOTES,$dataArr);
		}
		//return $this->db->insert_id();
		else {
			$this->db->where($condition);
			$this->db->update(NOTES,$dataArr);
		}
	}

	public function ChkWishlistProduct($productid='',$userid){
		$this->db->cache_on();
		$select_qry = 'SELECT id FROM '.LISTS_DETAILS.' WHERE user_id = '.$userid.' AND FIND_IN_SET('.$productid.' , experience_id)';
		return $rentalList = $this->ExecuteQuery($select_qry);
		
		//return $rentalList->result();
	}
	public function get_date_time_details($experience_id){

		$sql="select D.*,(select IFNULL(count(T.id),0) from ".EXPERIENCE_TIMING." as T where T.exp_dates_id= D.id) as time_count from ".EXPERIENCE_DATES." as D WHERE D.experience_id='".$experience_id."' group by D.id order by D.created_at desc";
		$res=$this->ExecuteQuery($sql);
		return $res;
		
	}
	public function get_data_minimum_stay(){
		//minimum_stay LISTING_TYPES fc_listing_child
		
		$sql="select C.* from ".LISTING_CHILD." as C , ".LISTING_TYPES." as T where T.id=C.parent_id and T.name='minimum_stay'";
		$res=$this->ExecuteQuery($sql);
		return $res;
	}
	
	/**get most viewed Experiences**/
	public function get_mostViewed_experiences(){
		$this->db->cache_on();
		$query="SELECT e.*,u.firstname,ei.product_image
			FROM ".EXPERIENCE." e 
			LEFT JOIN ".USERS." u on u.id=e.user_id
			LEFt JOIN ".EXPERIENCE_PHOTOS." ei on ei.product_id=e.experience_id
			WHERE e.status ='1' order by e.page_view_count desc limit 5";
			$result=$this->ExecuteQuery($query);
			return $result;
	}
	
	/**booked experiences count**/
	public function booked_experiences(){
		$this->db->cache_on();
		$query="SELECT rq.*, u.email, u.firstname, u.address, rq.caltophone, rq.phone_no, u.postal_code, u.state, u.country, u.city,Py.status as status 
			FROM  ".EXPERIENCE_ENQUIRY."  rq
			JOIN ".USERS." as u ON rq.user_id = u.id 
			JOIN ".EXPERIENCE_BOOKING_PAYMENT." as Py ON Py.EnquiryId = rq.id 
			WHERE Py.status = 'Paid' AND rq.booking_status = 'Booked'  ORDER BY rq.dateAdded desc";
			$result=$this->ExecuteQuery($query);
			return $result;
	}
	
	/**get count experiences of logged user**/
		public function get_experiences_list($user_id=''){
		$this->db->select('e.*,ep.product_image');
		$this->db->from(EXPERIENCE.' as e');
		$this->db->join(EXPERIENCE_PHOTOS.' as ep','ep.product_id=e.experience_id','LEFT');
		$this->db->where('e.user_id',$user_id);
		$this->db->where('e.status','1');
		$this->db->group_by('e.experience_id');
		$this->db->order_by('e.experience_id','desc');
		$query=$this->db->get();
		return $query;
	}
	
	/**get review received by logged user**/
	   function get_experiences_review_aboutyou1($user_id=''){
		$this->db->select('r.*,e.experience_title,u.image');
		$this->db->from(EXPERIENCE_REVIEW.' as r');
		$this->db->where('r.user_id', $user_id);		
		$this->db->join(EXPERIENCE.' as e',"r.product_id=e.experience_id");
		$this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");
		return $query = $this->db->get_where();
	} 
	
	
	
}

?>