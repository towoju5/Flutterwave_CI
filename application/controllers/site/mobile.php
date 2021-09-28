<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * 
 * mobile related functions
 * @author Teamtweaks
 *
 */
 
class Mobile extends MY_Controller {  


  function __construct(){
        parent::__construct();
    $this->load->helper(array('cookie','date','form','email'));
    $this->load->library(array('encrypt','form_validation','resizeimage'));   
    $this->load->model('mobile_model');
    //header('content-type:text/html; charset=UTF-8');
    $this->google_map_api = $this->config->item('google_map_api');
  } 

  /** 
   * 
   * Loading Category Json Page
   */
  
  public function index(){
    
  } 
  
  public function discoverfeatured(){

    $perpage = 10; 
    $page=intval($_GET['page_Id']);
    $email = $_GET['email_id'];
    $userSection = array();
    if($email != '')
    {
      $userDetails = $this->mobile_model->get_all_details(USERS, array('email'=>$email));
      $userSection['user_name'] = $userDetails->row()->user_name;
      $userSection['firstname'] = $userDetails->row()->firstname;
      $userSection['lastname'] = $userDetails->row()->lastname;
      $userSection['is_verified'] = $userDetails->row()->is_verified;
      $userSection['id_verified'] = $userDetails->row()->id_verified;
      $userSection['ph_verified'] = $userDetails->row()->ph_verified;
      $userSection['phone_no'] = $userDetails->row()->phone_no;
      $userSection['since'] = date('Y-m-d', strtotime($userDetails->row()->created));
      $userSection['gender'] = $userDetails->row()->gender;
      $userSection['description'] = $userDetails->row()->description;
      if($userDetails->row()->dob_date != 0) {
      $date = $userDetails->row()->dob_date."-";
      }else{
      $date = '';
      }
      if($userDetails->row()->dob_month != 0) {
      $month = $userDetails->row()->dob_month."-";
      }else{
      $month = '';
      }
      if($userDetails->row()->dob_year != 0) {
      $year = $userDetails->row()->dob_year;
      }else{
      $year = '';
      }
      $userSection['dob'] = $date.$month.$year;
      if($userDetails->row()->image != '') {
      $userSection['image'] = $userDetails->row()->image;
      }else{
      $userSection['image'] = 'profile.jpg';
      }
    }
        $this->db->select('u.state_code,u.name,u.id,c.name as countryname,u.citythumb as citylogo');
    $this->db->from(CITY.' as u');
    $this->db->join(LOCATIONS.' as c' , 'u.countryid = c.id');
    $this->db->where('u.status','Active');
    $this->db->where('u.featured','1');
    $this->db->order_by('u.name');
    
    if($page>0){
      $this->db->limit($perpage,($page*$perpage)-$perpage); 
    }else{
      $page=1;
      $this->db->limit($perpage,0);
    }
    $city = $this->db->get();
    $CatArr = array();
    foreach($city->result() as $catVal){
      
      $googleAddress = $catVal->name.", ".$catVal->countryname;
      $googleAddress = str_replace(" ", "+", $googleAddress);
      $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$googleAddress&sensor=false&key=$this->google_map_api");
    
      $city = '';
      $country = '';
      $json = json_decode($json);
      if($json->{'error_message'} == ''){
        $newAddress = $json->{'results'}[0]->{'address_components'};
        $this->data ['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $this->data ['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        foreach($newAddress as $nA)
        {
          if($nA->{'types'}[0] == 'locality')$location = $nA->{'long_name'};
          if($nA->{'types'}[0] == 'administrative_area_level_2')$city = $nA->{'long_name'};
          if($nA->{'types'}[0] == 'country')$country = $nA->{'long_name'};
        }
        if($city == '')
        $city = $location;
        
        
        $this->db->from(PRODUCT.' as p');
        $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
        $this->db->where('p.status', 'Publish');
        $this->db->where('pa.city', $city);
        $this->db->where('pa.country', $country);
        $product_count=$this->db->count_all_results();
        
        if($catVal->citylogo != ''){
          $renameArr = explode('.', $catVal->citylogo);
          $catImage = $renameArr[0].'.jpg';;
        }else{
          $catImage = 'no_image.jpg'; 
        }
        if($product_count != 0){ 
        $CatArr[] = array("city_id" => $catVal->name, "city_name" => $catVal->name,"city_image" =>$catImage,"product_count"=>$product_count);
        }
      }
    }

    $json_encode = json_encode(array("featuredCities" => $CatArr,"pageId"=>(string)$page, "userDetails" => $userSection));
    echo $json_encode;
    
  }

  public function citysearch() {
    $cityname = $_GET['cityname'];
  }
  /* Rental List and search filter for rental page */
  public function rental_list_old(){
    
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $conditions = array('status'=>'Active');
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    $attribute = array();
    $property = array();
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>$pro->id);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
            if($pro->id == $room->listspace_id) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
            }
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
  
  //  print_r($_POST); 
    $responseArr = array();
    $perpage =5;
    $page=intval($_POST['page_Id']);
    $email=$_POST['email_id'];
    $fav=0;
    if($_POST['city_name'] !="")$cityId=$_POST['city_name'];else$cityId='';
    $responseArr['city_name'] = $cityId;
    if($_POST['mcity_name'] !="")$mcityId=$_POST['mcity_name'];else$mcityId='';
    $responseArr['mcity_name'] = $mcityId;
    if($_POST['f_date_arrive'] !="")$arive=$_POST['f_date_arrive'];else$arive='';
    $responseArr['f_date_arrive'] = $arive;
    if($_POST['f_date_depart'] !="")$depart=$_POST['f_date_depart'];else$depart='';
    $responseArr['f_date_depart'] = $depart;
    if($_POST['f_guest'] !="")$noofguest=$_POST['f_guest'];else$noofguest='';
    $responseArr['f_guest'] = $noofguest;
    if($_POST['f_p_min'] !="")$pricemin=$_POST['f_p_min'];else$pricemin='';
    $responseArr['f_p_min'] = $pricemin;
    if($_POST['f_p_max'] !="")$pricemax=$_POST['f_p_max'];else$pricemax='';
    $responseArr['f_p_max'] = $pricemax;
    if($_POST['f_private_room'] !="")$privateroom=$_POST['f_private_room'];else$privateroom='';
    $responseArr['f_private_room'] = $privateroom;
    if($_POST['f_shared_room'] !="")$sharedroom=$_POST['f_shared_room'];else$sharedroom='';
    $responseArr['f_shared_room'] = $sharedroom;
    if($_POST['f_entire_home'] !="")$entireroom=$_POST['f_entire_home'];else$entireroom='';
    $responseArr['f_entire_home'] = $entireroom;
    
    if($_POST['f_bath_room'] !="")$bathroom=$_POST['f_bath_room'];else$bathroom='';
    $responseArr['f_bath_room'] = $bathroom;
    if($_POST['f_bed'] !="")$bed=$_POST['f_bed'];$bed='';
    $responseArr['f_bed'] = $bed;
    if($_POST['f_bed_room'] !="")$bedroom=$_POST['f_bed_room'];else$bedroom='';
    $responseArr['f_bed_room'] = $bedroom;
    
    
    if($noofguest != '' && $noofguest != '0'){
    $search .= " and p.accommodates >=".$noofguest;
    }
    if($pricemax != '' && $pricemin != ''){
    $search .= " and (p.price BETWEEN ".$pricemin." and ".$pricemax.')';
    }
    if($bed != '' && $bed != '0'){
    $search .= " and p.listings LIKE '%\"Beds\":\"".$bed."\"%'";
    }
    if($bedroom != '' && $bedroom != '0'){
    $search .= " and p.listings LIKE '%\"Bedrooms\":\"".$bedroom."\"%'";
    }
    if($bathroom != '' && $bathroom != '0'){
    $search .= " and p.listings LIKE '%\"Bathrooms\":\"".$bathroom."\"%'";
    }
    if($entireroom != '' && $entireroom == 'Entire home/apartment'){
    $search .= ' and p.room_type =" '.$entireroom.'"';
    }
    if($sharedroom != '' && $sharedroom == 'Shared room'){
    $search .= ' and p.room_type =" '.$sharedroom.'"';
    }
    if($privateroom != '' && $privateroom == 'Private Room'){
    $search .= ' and p.room_type ="'.$privateroom.'"';
    }
    
    //{"Bedrooms":"1","Beds":"1","Bathrooms":"Private","minimum_stay":"3","accommodates":"","SPACE_SIZE":""}

    if($page>0){
    $pageLimitStart=($page*$perpage)-$perpage;
         $this->db->limit($perpage,($page*$perpage)-$perpage);  
    }else{
      $page=1;
      $pageLimitStart=0;
      $this->db->limit($perpage,0);
    }
    $searchPerPage=$perpage;
    $condition .= '( 1=1';
    
    if($cityId !='')
    {
      $googleAddress = str_replace(" ", "+", $cityId);
      $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$googleAddress&sensor=false&key=$this->google_map_api");
      $json = json_decode($json);
      //echo '<pre>';print_r($json);die;
      $newAddress = $json->{'results'}[0]->{'address_components'};
      $this->data ['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
      $this->data ['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
      foreach($newAddress as $nA)
      {
        if($nA->{'types'}[0] == 'locality')$location = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'administrative_area_level_2')$city = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'country')$country = $nA->{'long_name'};
      }
      $minLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lat'};
      $minLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lng'};
      $maxLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lat'};
      $maxLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lng'};
      
      $condition .= ' AND (pa.lat BETWEEN "'.$minLat.'" AND "'.$maxLat.'" ) AND (pa.lang BETWEEN "'.$minLong.'" AND "'.$maxLong.'" )';
    }
    
    if($mcityId !='')
    {
      $googleAddress = str_replace(" ", "+", $mcityId);
      $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$googleAddress&sensor=false&key=$this->google_map_api");
      $json = json_decode($json);
      //echo '<pre>';print_r($json);die;
      $newAddress = $json->{'results'}[0]->{'address_components'};
      $this->data ['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
      $this->data ['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
      foreach($newAddress as $nA)
      {
        if($nA->{'types'}[0] == 'locality')$location = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'administrative_area_level_2')$city = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'country')$country = $nA->{'long_name'};
      }
      $minLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lat'};
      $minLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lng'};
      $maxLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lat'};
      $maxLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lng'};
      
      $condition .= ' AND (pa.lat BETWEEN "'.$minLat.'" AND "'.$maxLat.'" ) AND (pa.lang BETWEEN "'.$minLong.'" AND "'.$maxLong.'" )';
    }
    
    if($mrentalId !='')
    {
      $condition .= ' and p.id = "' .$_POST['mrental_Id']. '" ';
    }
    $condition .= ' ) ';
    $condition=' where '.$condition.$search.' and p.status="Publish" group by p.id order by p.created desc limit '. $pageLimitStart . ',' . $searchPerPage;
       
    $select_qry = "select  p.product_title,p.description,p.id,p.price,p.currency,p.fav,p.home_type,u.image as userphoto,u.email,u.user_name,pa.lat as latitude,pa.lang as longitude, pp.product_image from ".PRODUCT." p LEFT JOIN ".PRODUCT_ADDRESS_NEW." pa on pa.productId=p.id LEFT JOIN ".PRODUCT_PHOTOS." pp on pp.product_id=p.id LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
    $rentalList = $this->mobile_model->ExecuteQuery($select_qry);
    
    $searchcount = $rentalList->num_rows();
        echo $this->db->last_query();die;
    $mapcount=0;
    $condition = array('email'=>$email);
    $userDetails = $this->mobile_model->get_all_details ( USERS, $condition );
    $userId = $userDetails->row()->id;
    $favs = array();
    $checkFavorite = $this->mobile_model->get_all_details(LISTS_DETAILS, array('user_id'=>$userId));
    foreach($checkFavorite->result() as $result)
    $favs[] = $result->product_id;
    
    foreach($rentalList->result() as $rental){
      if (in_array($rental->id,$favs))$fav = 1;
      $price_details .= $rental->price.','; 
      if($rental->product_image != ''){
      $p_img = explode('.',$rental->product_image); 
        $suffix = strrchr($rental->product_image, "."); 
          $pos = strpos  ( $rental->product_image  , $suffix); 
          $name = substr_replace ($rental->product_image, "", $pos); 
         // echo $suffix . "<br><br>". $name;

          $pro_img = $name.''.$suffix; 
      
      $proImage = base_url().'server/php/rental/'.$pro_img;
      }else{
        $proImage = base_url().'server/php/rental/dummyProductImage.jpg';
      }
      if($_POST['currency_code'] != ''){
      $condition = array('currency_type'=>$_POST['currency_code']);
      $currency_rate = $this->mobile_model->get_all_details ( CURRENCY, $condition );
      $currency_code = $currency_rate->row()->currency_symbols;
      }else{
      $currency_code = '$';
      }
      if($_POST['currency_code'] != ''){
      $condition = array('currency_type'=>$_POST['currency_code']);
      $currency_rate = $this->mobile_model->get_all_details ( CURRENCY, $condition );
      $currency_price =$rental->price * $currency_rate->row()->currency_rate; 
      }else{
      $currency_price = $rental->price;
      }
      if($rental->userphoto != '') {
      $userphoto = base_url().'images/users/'.$rental->userphoto;
      }else{
      $userphoto = base_url().'images/site/profile.jpg';
      }
      if($rental->user_name != ''){
        $host_name = $rental->user_name;
        
      } else {
        $host_name ="";
      }
      //$this->dyn_price($rental->email); 
      //$latandlog[] = array("latitude" => $rental->latitude,"longitude" => $rental->longitude,"rental_id" => $rental->id,"description"=>$rental->description,"hostname"=>$rental->user_name,"rental_price" =>$currency_price,"rental_title" => $rental->product_title,"rental_image" =>$proImage,"userphoto" =>$userphoto,"fav"=>$fav,"user_currency"=>$currency_code,"home_type"=>$rental->home_type);
      $latandlog[] = array("rental_id" => $rental->id, "rental_title" => $rental->product_title,"description"=>$rental->description,"rental_image" =>$proImage,"latitude" => $rental->latitude,"longitude" => $rental->longitude,"userphoto" =>$userphoto,"is_favourite"=>$fav,"rental_price" =>$currency_price,"user_currency"=>$currency_code,"home_type"=>$rental->home_type,"hostname"=>$host_name);      
    
      $rentalListArr[] = array("rental_id" => $rental->id, "rental_title" => $rental->product_title,"description"=>$rental->description,"rental_image" =>$proImage,"latitude" => $rental->latitude,"longitude" => $rental->longitude,"userphoto" =>$userphoto,"is_favourite"=>$fav,"rental_price" =>$currency_price,"user_currency"=>$currency_code,"home_type"=>$rental->home_type,"hostname"=>$host_name);
      $mapcount++;
      $fav = 0;
      
    }
    $all_price =  rtrim($price_details,',');
    
    $all_price_detail  =  explode(',',$all_price);
    
    
    if($mcityId == ''){
      if($searchcount == 0){
      $rentalListArr = array();
      $json_encode = json_encode(array("status"=>0,"message"=>"No property available","rentalList" =>$rentalListArr,"property" =>$property,"attribute"=>$attribute,'minprice'=>'0.00','maxprice'=>max($all_price_detail)));
      }else{
      if(min($all_price_detail) == max($all_price_detail))
        $json_encode = json_encode(array("status"=>1,"message"=>"property available","rentalList" => $rentalListArr,"property" =>$property,"attribute"=>$attribute,'minprice'=>'0.00','maxprice'=>max($all_price_detail)));
      else
        $json_encode = json_encode(array("status"=>1,"message"=>"property available","rentalList" => $rentalListArr,"property" =>$property,"attribute"=>$attribute,'minprice'=>min($all_price_detail),'maxprice'=>max($all_price_detail)));
      }
    }else{
      $json_encode = json_encode(array("status"=>1,"message"=>"property available","rentalList"=>$latandlog,"property" =>$property,"attribute"=>$attribute));
    }
    
    
    echo $json_encode;
    
  } 
  /* Rental List and search filter for rental page */
  public function rental_list(){
    
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    
    /* Property and Room Type and so on */
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $roomvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $roomvalueArr[] = array("child_id" =>intval($room->id),"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>intval($pro->id));
          }
          $rooms[]  = array("option_id"=>intval($pro->id),"option_name"=>$pro->attribute_name,"options"=>$roomvalueArr);
        }
      }
    } 
    
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
            foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>intval($room->id),"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>intval($pro->id));
            }
            $property[]  = array("option_id"=>intval($pro->id),"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    } 
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>intval($list_value->id),"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>intval($list_value->attr_id));
            }
          }
          $attribute[]  = array("option_id"=>intval($parent_value->id),"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
  //  print_r($_POST); 
    $responseArr = array();
    $perpage =5;
    $page=intval($_POST['page_Id']);
    $email=$_POST['email_id'];
    $fav=0;
    if($_POST['mcity_name'] !="")$mcityId=$_POST['mcity_name'];else$mcityId='';
    $responseArr['mcity_name'] = $mcityId;
    if($_POST['f_date_arrive'] !="")$arive=$_POST['f_date_arrive'];else$arive='';
    $responseArr['f_date_arrive'] = $arive;
    if($_POST['f_date_depart'] !="")$depart=$_POST['f_date_depart'];else$depart='';
    $responseArr['f_date_depart'] = $depart;
    if($_POST['f_guest'] !="")$noofguest=$_POST['f_guest'];else$noofguest='';
    $responseArr['f_guest'] = $noofguest;
    if($_POST['f_p_min'] !="")$pricemin=$_POST['f_p_min'];else$pricemin='';
    $responseArr['f_p_min'] = $pricemin;
    if($_POST['f_p_max'] !="")$pricemax=$_POST['f_p_max'];else$pricemax='';
    $responseArr['f_p_max'] = $pricemax;
    
    if($_POST['f_room_type'] !="")$room_type=$_POST['f_room_type'];else$room_type='';
    
    if($_POST['f_home_type'] !="")$home_type=$_POST['f_home_type'];else$home_type='';
    
    if($_POST['f_list_type'] !="")$list_type=$_POST['f_list_type'];else$list_type='';
    
    if(($arive != '') && ($depart != '')){
      $newDateStart = date("Y-m-d", strtotime($arive));
      $newDateEnd = date("Y-m-d", strtotime($depart));
      $this->db->select('*');
      $this->db->from(CALENDARBOOKING);
      $this->db->where('the_date >=',$newDateStart);
      $this->db->where('the_date <=',$newDateEnd);
      $this->db->group_by('PropId');
      $restrick_booking_query = $this->db->get();
      if($restrick_booking_query->num_rows() != 0 ){
        $restrick_booking_result = $restrick_booking_query->result();
        foreach($restrick_booking_result as $restrick_data){
          $product_restrick_id .="'".$restrick_data->PropId."',";
        }
        $product_restrick_id .='}';
        $restrick_product_id =  str_replace(',}','',$product_restrick_id );
        $search .= " and p.id NOT IN(".$restrick_product_id.")";
      }
    }
    
    if($noofguest != '' && $noofguest != '0'){
    $search .= " and p.accommodates >=".$noofguest;
    }
    if($pricemax != '' && $pricemin != ''){
    //$search .= " and (p.price BETWEEN ".$pricemin." and ".$pricemax.')';
    }
    
    if($room_type != '' && $room_type != '0'){
      $find_in_set_room .=  'and p.room_type IN ( ';
      $roomvalue = explode(',',$room_type);
      foreach($roomvalue as $room) {
        $find_in_set_room .= " '$room',";
      }
    }
    if ($find_in_set_room != '') {
      $find_in_set_room = substr ( $find_in_set_room, 0, - 1 );
      $search .= ' ' . $find_in_set_room . ') ';
    }
    
    if($home_type != '' && $home_type != '0'){
      $find_in_set_home .=  'and p.home_type IN ( ';
      $homevalue = explode(',',$home_type);
      foreach($homevalue as $home) {
        $find_in_set_home .= " '$home',";
      }
    }
    if ($find_in_set_home != '') {
      $find_in_set_home = substr ( $find_in_set_home, 0, - 1 );
      $search .= ' ' . $find_in_set_home . ') ';
    }
    
    
    if($list_type != '' && $list_type != '0'){
      $find_in_set_categories .=  'and (';
      $listvalue = explode(',',$list_type);
      foreach($listvalue as $list) {
        $find_in_set_categories .= ' FIND_IN_SET("' . $list . '", p.list_name) OR';
      }
    }
    if ($find_in_set_categories != '') {
      $find_in_set_categories = substr ( $find_in_set_categories, 0, - 2 );
      $search .= ' ' . $find_in_set_categories . ') ';
    }
    
    if($page>0){
    $pageLimitStart=($page*$perpage)-$perpage;
         $this->db->limit($perpage,($page*$perpage)-$perpage);  
    }else{
      $page=1;
      $pageLimitStart=0;
      $this->db->limit($perpage,0);
    }
    $searchPerPage=$perpage;
    $condition .= '( 1=1';
    
    $user_id = $_POST['user_id'];
    
    if($mcityId !='')
    {
      $googleAddress = str_replace(" ", "+", $mcityId);
      $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$googleAddress&sensor=false&key=$this->google_map_api");
      $json = json_decode($json);
      //echo '<pre>';print_r($json);die;
      $newAddress = $json->{'results'}[0]->{'address_components'};
      $this->data ['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
      $this->data ['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
      foreach($newAddress as $nA)
      {
        if($nA->{'types'}[0] == 'locality')$location = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'administrative_area_level_2')$city = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'country')$country = $nA->{'long_name'};
      }
      $minLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lat'};
      $minLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lng'};
      $maxLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lat'};
      $maxLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lng'};
      
      $condition .= ' AND (pa.lat BETWEEN "'.$minLat.'" AND "'.$maxLat.'" ) AND (pa.lang BETWEEN "'.$minLong.'" AND "'.$maxLong.'" )';
    }
    
    if($mrentalId !='')
    {
      $condition .= ' and p.id = "' .$_POST['mrental_Id']. '" ';
    }
    $condition .= ' ) ';
    //$condition=' where '.$condition.$search.' and p.status="Publish" group by p.id order by p.created desc limit '. $pageLimitStart . ',' . $searchPerPage;
    $condition=' where '.$condition.$search.' and p.status="Publish" group by p.id order by p.created desc,' . $searchPerPage;
       
    $select_qry = "select  p.product_title,p.description,p.id,p.price,p.currency,p.fav,p.home_type,u.image as userphoto,u.email,u.user_name,u.id as userid,pa.lat as latitude,pa.lang as longitude, pp.product_image from ".PRODUCT." p LEFT JOIN ".PRODUCT_ADDRESS_NEW." pa on pa.productId=p.id LEFT JOIN ".PRODUCT_PHOTOS." pp on pp.product_id=p.id LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
    $rentalList = $this->mobile_model->ExecuteQuery($select_qry);
    
    $searchcount = $rentalList->num_rows();
       // echo $this->db->last_query(); //die;
    $mapcount=0;
    $condition = array('email'=>$email);
    $userDetails = $this->mobile_model->get_all_details ( USERS, $condition );
    $userId = $userDetails->row()->id;
    $favs = array();
    $checkFavorite = $this->mobile_model->get_all_details(LISTS_DETAILS, array('user_id'=>$userId));
    foreach($checkFavorite->result() as $result)
    $favs[] = $result->product_id;

    $rentalListArr = array();
    $latandlog =array();
    foreach($rentalList->result() as $rental){
      if($pricemin !="" && $pricemax !="") {
        $filter_price = $rental->price;
        if($filter_price >= $pricemin && $filter_price <= $pricemax && $pricemin !="" && $pricemax !="" ) {
          
          if (in_array($rental->id,$favs))$fav = 1;
          $fav = 0;
          if($user_id !="" || $user_id !=0) {
            $select_qrys = "select fc_lists.id from fc_lists where  find_in_set(".$rental->id.",product_id) and user_id = ".$user_id;
            $checkFavorite = $this->mobile_model->ExecuteQuery($select_qrys);
            if($checkFavorite->num_rows() > 0) $fav = 1;
            else $fav = 0;
          }

          $price_details .= $rental->price.','; 
          if($rental->product_image != ''){
          $p_img = explode('.',$rental->product_image); 

          $suffix = strrchr($rental->product_image, "."); 
          $pos = strpos  ( $rental->product_image  , $suffix); 
          $name = substr_replace ($rental->product_image, "", $pos); 
         // echo $suffix . "<br><br>". $name;

          $pro_img = $name.''.$suffix; 
          
          $proImage = base_url().'server/php/rental/'.$pro_img;
          }else{
            $proImage = base_url().'server/php/rental/dummyProductImage.jpg';
          }
          
            $condition = array('currency_type'=>$rental->currency);
            $currency_rate = $this->mobile_model->get_all_details ( CURRENCY, $condition );
            $currency_code = $currency_rate->row()->currency_symbols;
            $property_currency_symbol = $currency_rate->row()->currency_symbols;
            
          $currency_price = $rental->price;
          if($rental->userphoto != '') {
          $userphoto = base_url().'images/users/'.$rental->userphoto;
          }else{
          $userphoto = base_url().'images/site/profile.jpg';
          }
          if($rental->user_name != ''){
            $host_name = $rental->user_name;
            
          } else {
            $host_name ="";
          }
          
          $latandlog[] = array("rental_id" => intval($rental->id), "rental_title" => $rental->product_title,"description"=>$rental->description,"rental_image" =>$proImage,"latitude" => $rental->latitude,"longitude" => $rental->longitude,"userphoto" =>$userphoto,"is_favourite"=>$fav,"rental_price" =>floatval($currency_price),"user_currency"=>$currency_code,"home_type"=>$rental->home_type,"hostname"=>$host_name,"host_id"=>intval($rental->userid),"property_currency_code"=>$rental->currency,"property_currency_symbol"=>$property_currency_symbol);     
        
          $rentalListArr[] = array("rental_id" => intval($rental->id), "rental_title" => $rental->product_title,"description"=>$rental->description,"rental_image" =>$proImage,"latitude" => $rental->latitude,"longitude" => $rental->longitude,"userphoto" =>$userphoto,"is_favourite"=>$fav,"rental_price" =>floatval($currency_price),"user_currency"=>$currency_code,"home_type"=>$rental->home_type,"hostname"=>$host_name,"host_id"=>intval($rental->userid),"property_currency_code"=>$rental->currency,"property_currency_symbol"=>$property_currency_symbol);
          $mapcount++;
          $fav = 0;
        }
      } else {
        
        if (in_array($rental->id,$favs))$fav = 1;
          $fav = 0;
          if($user_id !="" || $user_id !=0) {
            $select_qrys = "select fc_lists.id from fc_lists where  find_in_set(".$rental->id.",product_id) and user_id = ".$user_id;
            $checkFavorite = $this->mobile_model->ExecuteQuery($select_qrys);
            if($checkFavorite->num_rows() > 0) $fav = 1;
            else $fav = 0;
          }

          $price_details .= $rental->price.','; 
          if($rental->product_image != ''){
          $p_img = explode('.',$rental->product_image); 

          $suffix = strrchr($rental->product_image, "."); 
          $pos = strpos  ( $rental->product_image  , $suffix); 
          $name = substr_replace ($rental->product_image, "", $pos); 
         // echo $suffix . "<br><br>". $name;

          $pro_img = $name.''.$suffix; 
          
          $proImage = base_url().'server/php/rental/'.$pro_img;
          }else{
            $proImage = base_url().'server/php/rental/dummyProductImage.jpg';
          }
        
            $condition = array('currency_type'=>$rental->currency);
            $property_currency_details = $this->mobile_model->get_all_details ( CURRENCY, $condition );
            $property_currency_symbol = $property_currency_details->row()->currency_symbols;
            $currency_code = $property_currency_details->row()->currency_symbols;
        
          $currency_price = $rental->price;
          
          if($rental->userphoto != '') {
            $userphoto = base_url().'images/users/'.$rental->userphoto;
          }else{
            $userphoto = base_url().'images/site/profile.jpg';
          }
          if($rental->user_name != ''){
            $host_name = $rental->user_name;
          } else {
            $host_name ="";
          }
          
          $latandlog[] = array("rental_id" => intval($rental->id), "rental_title" => $rental->product_title,"description"=>$rental->description,"rental_image" =>$proImage,"latitude" => $rental->latitude,"longitude" => $rental->longitude,"userphoto" =>$userphoto,"is_favourite"=>$fav,"rental_price" =>floatval($currency_price),"user_currency"=>$currency_code,"home_type"=>$rental->home_type,"hostname"=>$host_name,"host_id"=>intval($rental->userid),"property_currency_code"=>$rental->currency,"property_currency_symbol"=>$property_currency_symbol);     
        
          $rentalListArr[] = array("rental_id" => intval($rental->id), "rental_title" => $rental->product_title,"description"=>$rental->description,"rental_image" =>$proImage,"latitude" => $rental->latitude,"longitude" => $rental->longitude,"userphoto" =>$userphoto,"is_favourite"=>$fav,"rental_price" =>floatval($currency_price),"user_currency"=>$currency_code,"home_type"=>$rental->home_type,"hostname"=>$host_name,"host_id"=>intval($rental->userid),"property_currency_code"=>$rental->currency,"property_currency_symbol"=>$property_currency_symbol);
          $mapcount++;
          $fav = 0;
      }
        
    }
      $currency_val = array();
    if($mcityId == ''){
      if($searchcount == 0){
      $rentalListArr = array();
      $json_encode = json_encode(array("status"=>0,"message"=>"No property available","rentalList" =>$rentalListArr,"property" =>$property,"rooms" =>$rooms,"attribute"=>$attribute,"currency_list"=>$currency_val));
      }else{
        $json_encode = json_encode(array("status"=>1,"message"=>"property available","rentalList" => $rentalListArr,"property" =>$property,"rooms" =>$rooms,"attribute"=>$attribute,"currency_list"=>$currency_val));
      }
    }else{
      $json_encode = json_encode(array("status"=>1,"message"=>"property available","rentalList"=>$latandlog,"property" =>$property,"rooms" =>$rooms,"attribute"=>$attribute,"currency_list"=>$currency_val));
    }
    echo $json_encode;
    
  } 
  /* Property Rental Detail Page */
  public function rental_detail() {
    $email = $_POST['email'];
    $prodID = $_POST['prod_id'];
    $prodPrice = $_POST['prodPrice']; 
    $user_id = $_POST['user_id'];
    $userDetails = $this->mobile_model->get_all_details(USERS, array('email'=>$email));
    $userId = $userDetails->row()->id;
    $fav = 0;
    if($user_id !="" || $user_id !=0) {
      $select_qrys = "select fc_lists.id from fc_lists where  find_in_set(".$prodID.",product_id) and user_id = ".$user_id;
      $checkFavorite = $this->mobile_model->ExecuteQuery($select_qrys);
      if($checkFavorite->num_rows() > 0) $fav = 1;
      else $fav = 0;
    }

      $where1 = array('p.id'=>$prodID); 
      $where2 = array('product_id'=>$prodID); 
      
      $this->db->select('p.product_title,p.listings, p.home_type, p.datefrom, p.dateto, p.price_perweek, p.price_permonth, p.id, p.user_id, p.description, p.fav,p.price, p.image, p.accommodates, p.bedrooms, p.beds, p.noofbathrooms, p.minimum_stay, p.cancellation_policy, p.house_rules, p.list_name,pa.lat as latitude,pa.lang as longitude, u.description as description1, u.phone_no, rq.id, rq.checkin, rq.checkout, u.user_name, u.group, u.s_phone_no, u.about, u.loginUserType, u.email as RenterEmail, u.image as thumbnail,
      pa.country, pa.state, pa.city, pa.zip, pa.address, u.is_verified, u.id_verified, u.ph_verified, u.created, u.facebook, u.google, u.address, u.about,p.security_deposit,p.currency,rq.booking_status');
      $this->db->from(PRODUCT.' as p');
      $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
      $this->db->join(USERS.' as u',"u.id=p.user_id","LEFT");
      $this->db->join(RENTALENQUIRY.' as rq',"rq.prd_id=p.id","LEFT");
      $this->db->where($where1);
      $this->db->group_by('rq.id');
      $rental_details = $this->db->get();
      //echo '<pre>';print_r($rental_details->result());die;
      $this->db->select('product_image');
      $this->db->from(PRODUCT_PHOTOS);
      $this->db->where($where2);
      $photoDetails = $this->db->get();
      //echo $this->db->last_query(); die;
      if($rental_details->num_rows() > 0) {
        $prodimgArr = array();
        $proddetailArr = array();
        $check = array();
        $producttitle="";
        $productdesc="";
        $productprice="";
        $userimg="";
        $loginUserType="";
        $hostname="";
        $accommodates="";
        $bedroom="";
        $beds="";
        $bathrooms="";
        $country="";
        $state="";
        $city="";
        $post_code="";
        $address="";
        $latitude="";
        $longitude="";
        $minimum_stay="";
        $cancellation="";
        $house_rules="";
        $list_name="";
        $rental_id="";
        $host_id="";
        $host_email="";
        $user_currency="";
        $user_about="";
        $price_perweek="";
        $price_permonth="";
        $email_verified="";
        $ph_verified="";
        $id_verified="";
        $listarr = array();
        $datefrom = "";
        $dateto = "";
        $home_type = "";
        $member_since = "";
        $facebook = "";
        $google = "";
        $userAddress = "";
        $hostabout = "";
        foreach($photoDetails->result() as $rental_detail){ 
          if($rental_detail->product_image != ''){
          $p_img = explode('.',$rental_detail->product_image);  

          $suffix = strrchr($rental_detail->product_image, "."); 
          $pos = strpos  ( $rental_detail->product_image  , $suffix); 
          $name = substr_replace ($rental_detail->product_image, "", $pos); 
         // echo $suffix . "<br><br>". $name;

          $pro_img = $name.''.$suffix; 
          
          $proImage = base_url().'server/php/rental/'.$pro_img;
          }else{
            $proImage = base_url().'server/php/rental/dummyProductImage.jpg';
          }
          $prodimgArr[] = array("product_image" =>$proImage);
        }
        $reviewTotals = $this->mobile_model->get_review_tot($prodID);

        $star_avg = $reviewTotals->row()->tot_tot * 20;
        $reviewData = $this->mobile_model->get_review($prodID);
        $reviewTotal = $reviewData->num_rows();
        $property_review = array();

        if($reviewData->num_rows()>0){
          foreach($reviewData->result() as $review){ 
            if($review->image == '') {
              $img_url = base_url().'images/site/profile.png';
            }  else {
              $img_url = base_url().'images/users/'.$review->image;
            } 
            $review_date = date('F Y',strtotime($review->dateAdded));
            if($review->firstname !="")$review_name = $review->firstname; else $review_name="";
            if($review->review !="")$review_comments = $review->review; else $review_comments="";
            
            $property_review[] = array("user_name"=>$review_name,"review"=>nl2br($review_comments),"star_rating"=>intval($review->total_review),"review_date"=>$review_date,"user_image"=>$img_url); 
 
          }
        
        }
        //print_r($rental_details->result());
//die();
        foreach($rental_details->result() as $rental_detail){ 
          if($rental_detail->checkin != '' && $rental_detail->booking_status =="Booked"){
            $checkin = $rental_detail->checkin;
            $checkout = $rental_detail->checkout;
          }else{
            $checkin = '';
            $checkout = '';
          }
          
          $producttitle = $rental_detail->product_title;

          $productdesc = $rental_detail->description;

          

          $productprice = $rental_detail->price;
          if(($checkin != "" && $checkout != "") || ($checkin != null&& $checkout != null)) {
            $check[] = array("checkin" =>$checkin,'checkout'=>$checkout);
          }
          $hostname = $rental_detail->user_name;
          if($rental_detail->thumbnail != ''){
            $userimg = base_url().'images/users/'.$rental_detail->thumbnail;
          }else{
            $userimg = base_url().'images/site/profile.png';
          }
          if($rental_detail->loginUserType != ''){
            $loginUserType = $rental_detail->loginUserType;
          }else{
            $loginUserType = '';
          }
          //$userimg = $rental_detail->thumbnail;
          $listing_json = $rental_detail->listings;
          $listing_decode = json_decode($listing_json);
		  
if(count($listing_decode)>0) {
          foreach($listing_decode as $lkey=>$lvalues) {
            $listinginformation = $this->mobile_model->get_all_details ( LISTING_TYPES, array('name'=>$lkey) );

            if(trim($lkey)==trim($listinginformation->row()->name)) { 
			 
			  $listingchild = $this->mobile_model->get_all_details ( LISTING_CHILD, array('id'=>$lvalues) );
              if(strtolower($listinginformation->row()->name)=="bedrooms")
              $bedroom = ($listingchild->num_rows>0)?$listingchild->row()->child_name:'';
              if(strtolower($listinginformation->row()->name)=="beds") {
              $beds = $listingchild->row()->child_name; }
			  if(strtolower($listinginformation->row()->name)=="bathrooms") {
              $bathrooms = $listingchild->row()->child_name; }
		      if(strtolower($listinginformation->row()->name)=="guest_capacity") {
              $accommodates = $listingchild->row()->child_name;}
            }
          
         
          }
} else {
$bedroom = '';
$beds = '';
$bathrooms = ''; 
$accommodates='';
}
          //$listingchild = $this->db->select('*')->from(LISTING_CHILD)->where('id',$rental_detail->accommodates)->get()->row();
          $accommodates = $this->db->select('child_name')->from(LISTING_CHILD)->where('id',$rental_detail->accommodates)->get()->row()->child_name;
         // $bedroom = $listing_decode->Bedrooms;
         // $beds = $listing_decode->Beds;
         // if($listing_decode->Bathrooms == ''){
         // $bathrooms = ''; 
         // }else{ 
         // $bathrooms = $listing_decode->Bathrooms;
          //}
        //  if($bedroom== '')$bedroom = $rental_detail->bedrooms;
        //  if($beds == '')$beds = $rental_detail->beds;
        //  if($bathrooms == '')$bathrooms = $rental_detail->noofbathrooms;
          if($rental_detail->country != ''){
          $country = $rental_detail->country;
          }else{
          $country = '';
          }
          if($rental_detail->state != ''){
          $state = $rental_detail->state;
          }else{
          $state = '';
          }
          if($rental_detail->city != ''){
          $city = $rental_detail->city;
          }else{
          $city = '';
          }
          
          if($rental_detail->zip != '') {
          $post_code = $rental_detail->zip;
          }else{
          $post_code ='';
          }
          
          if($rental_detail->address !='') {
          $address = $rental_detail->address;
          }else{
          $address ='';
          }
          
          if($rental_detail->latitude !='') {
          $latitude = $rental_detail->latitude;
          }else{
          $latitude = '';
          }
          
          if($rental_detail->longitude !='') {
          $longitude = $rental_detail->longitude;
          }else{
          $longitude ='';
          }
          
          if($rental_detail->minimum_stay !='') {
          $minimum_stay = $this->db->select('child_name')->from(LISTING_CHILD)->where('id',$rental_detail->minimum_stay)->get()->row()->child_name;
		  //$rental_detail->minimum_stay;
          }else{
          $minimum_stay ='';
          }
          
          if($rental_detail->cancellation_policy !='') {
          $cancellation = $rental_detail->cancellation_policy;
          }else{
          $cancellation = '';
          }
          
          if($rental_detail->security_deposit != '') {
            if($rental_detail->currency != $_POST['currency_code'])
                      {
            //$security_deposit = convertCurrency($rental_detail->currency,$_POST['currency_code'],$rental_detail->security_deposit);
            $security_deposit = floatval($rental_detail->security_deposit);
                     }
                     else{
                      $security_deposit = floatval($rental_detail->security_deposit);
                     }
          
          }else{
          $security_deposit ='0';
          }
          
          $rental_id = $_POST['prod_id'];
          $host_id = intval($rental_detail->user_id);
          
          
          if($rental_detail->about != '') {
          $user_about = $rental_detail->about;
          }else{
          $user_about ='';
          }
          
          if($rental_detail->price_perweek != '') {
          $price_perweek = $rental_detail->price_perweek;
          }else{
          $price_perweek = '';
          }
          
          if($rental_detail->price_permonth != '') {
          $price_permonth = $rental_detail->price_permonth;
          }else{
          $price_permonth = '';
          }
          
          
          $hostemail = $this->mobile_model->get_all_details ( USERS, array('id'=>$host_id) );
          $host_email = $hostemail->row()->email;
          if($rental_detail->house_rules == ''){
          $house_rules = '';
          }else{
          $house_rules = $rental_detail->house_rules;
          }
          if($rental_detail->list_name == ''){
          $list_name = '';
          }
          else
          {
            $list_name = $rental_detail->list_name;
          }
          $datefrom = $rental_detail->datefrom;
          $dateto = $rental_detail->dateto;
          if(is_int($rental_detail->home_type) || ($rental_detail->home_type!=0)) {
            $home_type_sql=$this->mobile_model->get_all_details(LISTSPACE_VALUES,array("id"=>$rental_detail->home_type));
$home_type_varfinal =trim($home_type_sql->row()->list_value);
          } else {
            $home_type_varfinal = $rental_detail->home_type;
          }
          $home_type = $home_type_varfinal;
          $email_verified=$rental_detail->is_verified;
          $ph_verified=$rental_detail->ph_verified;
          $id_verified=$rental_detail->id_verified;
          $member_since=$rental_detail->created;
          $facebook=$rental_detail->facebook;
          $google=$rental_detail->google;
          $userAddress=$rental_detail->address;
        }
        $list = $rental_details->row()->list_name;
        $list_value = explode(',',$list);
        for($i=0;$i<count($list_value);$i++) {
          if($list_value[$i] !="") {
          $list_detail = $this->mobile_model->get_all_details (LIST_VALUES, array('id'=>$list_value[$i]) );
          
          if($list_detail != '')$list_name = $list_detail->row()->list_value;
          else $list_name="";
          if($list_detail != '')$list_img = $list_detail->row()->image;
          else $list_img="";
          if($list_img != '')$list_img = base_url().'images/attribute/'.$list_detail->row()->image;
          else $list_img="";
          $listarr[] = array('list_name'=>$list_name,'list_image'=>$list_img);
          }
        }
        $service_tax_query='SELECT * FROM '.COMMISSION.' WHERE seo_tag="guest-booking" AND status="Active"';
        $service_taxs = $this->mobile_model->ExecuteQuery($service_tax_query);
        //echo $this->db->last_query(); 
        $services =array();
        if(($service_taxs->num_rows())>0) {
            $service_type = $service_taxs->row()->promotion_type;
            $service_fee = $service_taxs->row()->commission_percentage;
            $services = array("service_type"=>$service_type,"service_value"=>floatval($service_fee));
        } else {
                               $service_type = "";
                               $service_fee = "";
                               $services = array("service_type"=>$service_type,"service_value"=>"");
               }
            /* schedule starts here */
            $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$rental_id));
            $sometime_arr = array();
            if($scheduleCheck->num_rows() >0){
              foreach($scheduleCheck->result() as $sc){ 
                $json_decode = json_decode($sc->data);
                foreach($json_decode as $key=>$value){
                  if($value->status=="available"){
                    $status = 1;
                  }else if($value->status=="booked"){
                    $status = 2;
                  }else if($value->status=="unavailable"){
                    $status = 3;
                  }
                  $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
                }
              } 
            }
        /* schedule ends here */
        $condition = array('currency_type'=>$rental_detail->currency);
        $currency_details = $this->mobile_model->get_all_details (CURRENCY, $condition );
        $user_currency = $currency_details->row()->currency_symbols;
        $json_encode = json_encode(array("status"=>1,"message"=>"Property available","product_image" => $prodimgArr,"check"=>$check,"defaultproducttitle"=>(string)$producttitle,"productdesc"=>$productdesc,"productprice"=>floatval($productprice),"hostimg"=>$userimg,"loginUserType"=>$loginUserType,"hostname"=>$hostname,"accommodates"=>$accommodates,"bedrooms"=>$bedroom,"beds"=>$beds,"is_favourite"=>$fav,"bathrooms"=>$bathrooms,"country"=>$country,"state"=>$state,"city"=>$city,"post_code"=>$post_code,"address"=>$address,"latitude"=>$latitude,"longitude"=>$longitude,"minimum_stay"=>$minimum_stay,"cancellation"=>$cancellation,"house_rules"=>$house_rules,"list_name"=>$list_name,'rental_id'=>intval($rental_id),'host_id'=>intval($host_id),'host_email'=>$host_email,'user_currency'=>$user_currency,'user_about'=>$user_about,'week_price'=>floatval($price_perweek),'month_price'=>floatval($price_permonth),'url'=>base_url(),'datefrom'=>$datefrom,'dateto'=>$dateto,'home_type'=>$home_type,'email_verified'=>$email_verified, 'ph_verified'=>$ph_verified, 'id_verified'=>$id_verified, 'member_since'=>$member_since, 'facebook'=>$facebook, 'google'=>$google, 'userAddress'=>$userAddress, 'hostabout'=>$hostabout,"property_currency_code"=>$currency_details->row()->currency_type,"property_currency_symbol"=>$currency_details->row()->currency_symbols,'list_details'=>$listarr,'security_deposit'=>$security_deposit,"services"=>$services,"total_review_count"=>intval($reviewTotal),"star_rating"=>floatval($star_avg),"property_reviews"=>$property_review,"seasonal_calendar_price"=>$sometime_arr));
        
      } else {
        $json_encode = json_encode(array("status"=>0,"message"=>"No Property available"));
        
      }
    echo $json_encode;
    }
    
    public function search_detail() {
    
      $q = $_GET['query'];
      $this->db->select('c.name,c.latitude,c.longitude,c.id,states_list.name as State,country_list.name as country_name');
      $this->db->from(CITY.' as c');
      $this->db->join(STATE_TAX.' as states_list',"states_list.id=c.stateid","LEFT");
      $this->db->join(COUNTRY_LIST.' as country_list',"country_list.id=states_list.countryid","LEFT");
      $this->db->like('states_list.name', $q);
      $this->db->or_like('c.name', $q);
      $this->db->limit(20);
      $this->db->order_by('c.name',asc);
      $this->db->order_by('states_list.name',asc);
      $query = $this->db->get();
      $search_res = $query->result_array();
      //echo $this->db->last_query();  die;
      $row_set = array();
      $state_arr = array();
      foreach ($search_res as $result){
        if (!in_array($result['State'],$state_arr)){
          $row_set[] = array(
            'search_result' => $result['State'].','.$result['country_name'],
            'id'=>$result['id'],'lat'=>$result['latitude'],'long'=>$result['longitude']
            
          );
          $state_arr[] = $result['State'];
        }
        $row_set[] = array(
             'search_result' => $result['name'].','.$result['State'].','.$result['country_name'],
             'id'=>$result['id'],'lat'=>$result['latitude'],'long'=>$result['longitude']
             
        );
      //$row_set[] .= array('lat'=>$result['latitude'],'long'=>$result['longitude']);
          }
      $json_encode = json_encode(array("search_list"=>$row_set));
           echo $json_encode;
      
    
    
    }
  public function mobile_bkguide() {
    $prd_id = $_GET['pro_id'];
    $this->db->select('pb.*,pa.post_code,pa.address,pa.apt,
                c.name as country_name,
                s.name as state_name,
                ci.name as city_name,
                p.product_name,p.product_title,p.price,p.currency,
                u.firstname,u.image,
                rq.id as EnqId,rq.booking_status,rq.checkin,rq.checkout,rq.dateAdded,rq.user_id as GestId,rq.numofdates as noofdates,rq.approval as approval,rq.serviceFee,rq.totalAmt,rq.Bookingno as Bookingno');
      $this->db->from(PRODUCT_BOOKING.' as pb');
      //$this->db->from(PAYMENT.' as py');
      $this->db->join(PRODUCT_ADDRESS.' as pa' , 'pa.product_id = pb.product_id','left');
      $this->db->join(LOCATIONS.' as c' , 'c.id = pa.country','left');
      $this->db->join(STATE_TAX.' as s' , 's.id = pa.state','left');
      $this->db->join(CITY.' as ci' , 'ci.id = pa.city','left');
      $this->db->join(PRODUCT.' as p' , 'p.id = pb.product_id');
      $this->db->join(RENTALENQUIRY.' as rq' , 'p.id = rq.prd_id');
      $this->db->join(USERS.' as u' , 'u.id = rq.user_id');
      $this->db->where('p.user_id = '.$prd_id);
      $this->db->where('rq.renter_id = '.$prd_id);
      $this->db->where('rq.booking_status != "Enquiry"');
      $this->db->group_by('rq.id');
      $this->db->order_by('rq.dateAdded','desc');
      return $this->db->get();
      echo $this->db->last_query();die;
  }
    
    
  public function mobile_login(){
  
    $email = $_POST['u_email'];
    $user_password = $_POST['u_psd'];
    $pwd = md5($user_password);
    if($_POST['device_type'] == 'android') {
      if($_POST['u_key'] != '') {
        $data = array(
            'mobile_key'=>''
            );
        $condition = array(
            'mobile_key'=>$_POST['u_key']
            );
        $this->mobile_model->update_details(USERS ,$data ,$condition);
        $data = array(
            'mobile_key'=>$_POST['u_key']
            );
        $condition = array(
            'email'=>$_POST['u_email']  
            );
        $this->mobile_model->update_details(USERS ,$data ,$condition);
      }
    }
    
    if($_POST['device_type'] == 'ios') {
    if($_POST['u_key'] != '') {
      $data = array(
          'ios_key'=>''
          );
      $condition = array(
          'ios_key'=>$_POST['u_key']
          );
      $this->mobile_model->update_details(USERS ,$data ,$condition);
      $data = array(
          'ios_key'=>$_POST['u_key']
          );
      $condition = array(
          'email'=>$_POST['u_email']  
          );
      $this->mobile_model->update_details(USERS ,$data ,$condition);
    }
    }
    if (valid_email ( $email )) {
      $condition = array (
          'email' => $email,
          'password' => $pwd,
          'status' => 'Active' 
      );  
      $checkUser = $this->mobile_model->get_all_details (USERS, $condition );
      if ($checkUser->num_rows () == '1') {
        $status = 'You are Logged In successfully';
        $firstname = $checkUser->row()->firstname;
        $lastname = $checkUser->row()->lastname;
        $email = $checkUser->row()->email;
        $key = $checkUser->row()->mobile_key;
        $user_id = $checkUser->row()->id;
        if($checkUser->row()->image != '') {
        $img = base_url().'images/users/'.$checkUser->row()->image;
        }else{
        $img = base_url().'images/site/profile.png';
        }
        $response[] = array('firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email,'userimage'=>$img,'userid'=>intval($user_id),'key'=>$key);
        $json_encode = json_encode(array('status'=>1,'message'=>$status,'user_details'=>$response));
      }else{
        $status = 'Invalid login details';
        $response=array();
        $json_encode = json_encode(array('status'=>0,'message'=>$status,'user_details'=>$response));
      }
    }
    echo $json_encode;
  }
  public function mobile_signup(){
  
    $firstname = $_POST['u_first_name'];
    $lastname = $_POST['u_last_name'];
    $email = $_POST['u_email'];
    $pwd = $_POST['u_psd'];
    $key = $_POST['u_key'];

    if($_POST['login_type'] == 'facebook' || $_POST['login_type'] == 'google' || $_POST['login_type'] == 'linkedin' ) {
      $this->db->select('id,image');
      $this->db->from(USERS);
      $this->db->where('email',$email);
      //$this->db->where('status','Active');
      $facebookQuery = $this->db->get();
      if($facebookQuery->num_rows() > 0 ){
        if($_POST['device_type'] == 'android' ) {
          if($_POST['u_key'] != '') {
            $data = array(
                'mobile_key'=>''
                );
            $condition = array(
                'mobile_key'=>$_POST['u_key']
                );
            $this->mobile_model->update_details(USERS ,$data ,$condition);
            $data = array(
                'mobile_key'=>$_POST['u_key']
                );
            $condition = array(
                'email'=>$_POST['u_email']  
                );
            $this->mobile_model->update_details(USERS ,$data ,$condition);
          }
        }
      
        if($_POST['device_type'] == 'ios' ) {
          if($_POST['u_key'] != '') {
            $data = array(
                'ios_key'=>''
                );
            $condition = array(
                'ios_key'=>$_POST['u_key']
                );
            $this->mobile_model->update_details(USERS ,$data ,$condition);
            $data = array(
                'ios_key'=>$_POST['u_key']
                );
            $condition = array(
                'email'=>$_POST['u_email']  
                );
            $this->mobile_model->update_details(USERS ,$data ,$condition);
          }
        }
        $user_id = $facebookQuery->row()->id;
        if($facebookQuery->row()->image != '') {
        $img = base_url().'images/users/'.$facebookQuery->row()->image;
        }else{
        $img = base_url().'images/site/profile.png';
        }
        $returnStr .= 'You are Logged In successfully';
        $response[] = array('firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email,'userimage'=>$img,'userid'=>$user_id,'key'=>$key);
        $json_encode = json_encode(array('status'=>1,'message'=>$returnStr,'user_details'=>$response));
      }else{
        if($_FILES['photo1'] != ''){
          
          $uploaddir = "images/users/";
          $data = file_get_contents($_FILES['photo1']['tmp_name']);
          $image = imagecreatefromstring( $data );
          $imgname=time().".jpg";
          imagejpeg($image,$uploaddir.$imgname, 99);
        
        }else{
          $imgname = '';
        }
        
        $orgPass = time();
        $pwd = md5($orgPass);
        $dataArr = array('firstname'=>$firstname,'lastname'=>$lastname,'user_name'=>$firstname,'image'=>$imgname,'group'=>'User','email'=>$email,'password'=>$pwd,'status'=>'Active','loginUserType'=>$_POST['login_type'],'is_verified'=>'No','created'=>date('Y-m-d H:i:s'),'mobile_key'=>$key);
        
        $this->mobile_model->simple_insert(USERS,$dataArr);
        $user_id = $this->db->insert_id();
        if($imgname != '') {
        $img = base_url().'images/users/'.$imgname;
        }else{
        $img = base_url().'images/site/profile.png';
        }
        $condition = array (
            'email' => $email 
        );
        $usrDetails = $this->mobile_model->get_all_details ( USERS, $condition );
          /* Mail function */ 

                    $newsid='35';
          $template_values=$this->mobile_model->get_newsletter_template_details($newsid);
          if($template_values['sender_name']=='' && $template_values['sender_email']==''){
            $sender_email=$this->data['siteContactMail'];
            $sender_name=$this->data['siteTitle'];
          }else{
            $sender_name=$template_values['sender_name'];
            $sender_email=$template_values['sender_email'];
          } 
                    $username = $firstname.$lastname; 
          $uid = $usrDetails->row ()->id;
          $username = $usrDetails->row ()->user_name;
          $email = $usrDetails->row ()->email;
          
          $randStr = $this->get_rand_str ( '10' );

          $cfmurl = base_url () . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
          $logo_mail = $this->data['logo'];
                    
          $reg= array('username' => $username, 'cfmurl'=>$cfmurl, 'email_title' => $sender_name,'logo'=>$logo_mail );
          //print_r($this->data['logo']);
          $message = $this->load->view('newsletter/RegistrationConfirmation'.$newsid.'.php',$reg,TRUE);
          
                    $email_values = array(
            'from_mail_id'=>$sender_email,
            'to_mail_id'=> $_POST['u_email'],
            'subject_message'=>$template_values ['news_subject'],
            'body_messages'=>$message
          );  
          
            
          //send mail
          $this->load->library('email');
          $this->email->from($email_values['from_mail_id'], $sender_name);
          $this->email->to($email_values['to_mail_id']);
          $this->email->subject($email_values['subject_message']);
          $this->email->set_mailtype("html");
          $this->email->message($message); 
                    try{
                        $this->email->send();
                        $returnStr ['msg'] = 'Successfully registered';
            $returnStr ['success'] = '1';
                    }catch(Exception $e){
                        echo $e->getMessage();
                    }                   
                    /* Mail function End */  

          /* Admin Mail function */ 

          $newsid='42';

          $template_values=$this->product_model->get_newsletter_template_details($newsid);
          if($template_values['sender_name']=='' && $template_values['sender_email']==''){
            $sender_email=$this->data['siteContactMail'];
            $sender_name=$this->data['siteTitle'];
          }else{
            $sender_name=$template_values['sender_name'];
            $sender_email=$template_values['sender_email'];
          } 
                          
          $username = $firstname.$lastname; 
          $uid = $usrDetails->row ()->id;
          $username = $usrDetails->row ()->user_name;
          $email = $usrDetails->row ()->email;
          $randStr = $this->get_rand_str ( '10' );

          $cfmurl = 'There is one new registration done on website. User details below.';
          $logo_mail = $this->data['logo'];
                                 
          $email_values = array(
              'from_mail_id'=>$this->input->post('email'),
              'to_mail_id'=> $sender_email,
              'subject_message'=>$template_values ['news_subject'],
              'body_messages'=>$message
          );  
          $reg= array('username' => $username, 'email'=> $email, 'cfmurl'=>$cfmurl, 'email_title' => $sender_name,'logo'=>$logo_mail );
           //print_r($this->data['logo']);
          $message = $this->load->view('newsletter/RegistrationAdminConfirmation'.$newsid.'.php',$reg,TRUE);
            
          //send mail
          $this->load->library('email');
          $this->email->from($email_values['from_mail_id'], $sender_name);
          $this->email->to($email_values['to_mail_id']);
          $this->email->subject($email_values['subject_message']);
          $this->email->set_mailtype("html");
                        
                    $this->email->message($message); 
          try{
            $this->email->send();
            $returnStr ['msg'] = 'Successfully registered';
            $returnStr ['success'] = '1';
          }catch(Exception $e){
            echo $e->getMessage();
          }                   
                    /* Admin Mail function End */ 
          
        $returnStr .= 'You are Registered successfully';
        $response[] = array('firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email,'userimage'=>$img,'userid'=>intval($user_id),'key'=>$key);
        $json_encode = json_encode(array('status'=>1,'message'=>$returnStr,'user_details'=>$response));
      }   
    }else{
      if (valid_email ( $email )) {
        $condition = array (
            'email' => $email 
        );
        $duplicateMail = $this->mobile_model->get_all_details( USERS, $condition );
        if ($duplicateMail->num_rows () > 0) {
          $returnStr .= 'EmailId already exists'; 
        } else {
  
                $expireddate = date ( 'Y-m-d', strtotime ( '+15 days' ) );
          $this->mobile_model->insertUserQuick ( $firstname, $lastname, $email, $pwd, $expireddate,$key);
          $usrDetails = $this->mobile_model->get_all_details ( USERS, $condition );
          //$this->send_confirm_mail ( $usrDetails );
          $returnStr .= 'Successfully registered';

          $user_id = $usrDetails->row()->id;
          if($usrDetails->row()->image != '') {
            $img = base_url().'images/users/'.$facebookQuery->row()->image;
          }else{
            $img = base_url().'images/site/profile.png';
          }
          
          /* Mail function */ 

                    $newsid='35';
          $template_values=$this->mobile_model->get_newsletter_template_details($newsid);
          if($template_values['sender_name']=='' && $template_values['sender_email']==''){
            $sender_email=$this->data['siteContactMail'];
            $sender_name=$this->data['siteTitle'];
          }else{
            $sender_name=$template_values['sender_name'];
            $sender_email=$template_values['sender_email'];
          } 
                    $username = $firstname.$lastname; 
          $uid = $usrDetails->row ()->id;
          $username = $usrDetails->row ()->user_name;
          $email = $usrDetails->row ()->email;
          
          $randStr = $this->get_rand_str ( '10' );

          $cfmurl = base_url () . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
          $logo_mail = $this->data['logo'];
                    
          $reg= array('username' => $username, 'cfmurl'=>$cfmurl, 'email_title' => $sender_name,'logo'=>$logo_mail );
          //print_r($this->data['logo']);
          $message = $this->load->view('newsletter/RegistrationConfirmation'.$newsid.'.php',$reg,TRUE);
          
                    $email_values = array(
            'from_mail_id'=>$sender_email,
            'to_mail_id'=> $_POST['u_email'],
            'subject_message'=>$template_values ['news_subject'],
            'body_messages'=>$message
          );  
          
            
          //send mail
          $this->load->library('email');
          $this->email->from($email_values['from_mail_id'], $sender_name);
          $this->email->to($email_values['to_mail_id']);
          $this->email->subject($email_values['subject_message']);
          $this->email->set_mailtype("html");
          $this->email->message($message); 
          
                    try{
                        $this->email->send();
                        $returnStr ['msg'] = 'Successfully registered';
            $returnStr ['success'] = '1';
                    }catch(Exception $e){
                        echo $e->getMessage();
                    }                   
                    /* Mail function End */  
          
          /* Admin Mail function */ 

          $newsid='42';

          $template_values=$this->product_model->get_newsletter_template_details($newsid);
          if($template_values['sender_name']=='' && $template_values['sender_email']==''){
            $sender_email=$this->data['siteContactMail'];
            $sender_name=$this->data['siteTitle'];
          }else{
            $sender_name=$template_values['sender_name'];
            $sender_email=$template_values['sender_email'];
          } 
                          
          $username = $firstname.$lastname; 
          $uid = $usrDetails->row ()->id;
          $username = $usrDetails->row ()->user_name;
          $email = $usrDetails->row ()->email;
          $randStr = $this->get_rand_str ( '10' );

          $cfmurl = 'There is one new registration done on website. User details below.';
          $logo_mail = $this->data['logo'];
                                 
          $email_values = array(
              'from_mail_id'=>$this->input->post('email'),
              'to_mail_id'=> $sender_email,
              'subject_message'=>$template_values ['news_subject'],
              'body_messages'=>$message
          );  
          $reg= array('username' => $username, 'email'=> $email, 'cfmurl'=>$cfmurl, 'email_title' => $sender_name,'logo'=>$logo_mail );
           //print_r($this->data['logo']);
          $message = $this->load->view('newsletter/RegistrationAdminConfirmation'.$newsid.'.php',$reg,TRUE);
          //send mail
          $this->load->library('email');
          $this->email->from($email_values['from_mail_id'], $sender_name);
          $this->email->to($email_values['to_mail_id']);
          $this->email->subject($email_values['subject_message']);
          $this->email->set_mailtype("html");
                        
                    $this->email->message($message); 
          try{
            $this->email->send();
            $returnStr ['msg'] = 'Successfully registered';
            $returnStr ['success'] = '1';
          }catch(Exception $e){
            echo $e->getMessage();
          }                   
                    /* Admin Mail function End */           
                  
        }
      }
        if($returnStr == 'EmailId already exists'){
          $response = array();
          $json_encode = json_encode(array('status'=>0,'message'=>$returnStr,'user_details'=>$response));
        }else{
          
          $response[] = array('firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email,'userimage'=>$img,'userid'=>intval($user_id),'key'=>$key);
          $json_encode = json_encode(array('status'=>1,'message'=>$returnStr,'user_details'=>$response));
        }
    }
             echo $json_encode;
  }
  public function mobile_forgotpsd(){
    $email=$_POST['u_email'];
    //$email='vinod4@gmail.com';
    if (valid_email ( $email )) {
        $condition = array (
            'email' => $email 
        );
        $checkUser = $this->mobile_model->get_all_details ( USERS, $condition );
        if ($checkUser->num_rows () == '1') {
          $pwd = $this->get_rand_str ( '6' );
          $newdata = array (
              'password' => md5 ( $pwd ) 
          );
          $condition = array (
              'email' => $email 
          );
          $this->mobile_model->update_details ( USERS, $newdata, $condition );
          $this->send_user_password ( $pwd, $checkUser );
          $returnStr .= 'New password sent to your email';
          $json_encode = json_encode(array('status'=>1,'message'=>$returnStr));
        } else {
          $returnStr .= 'EmailId not matched';
          $json_encode = json_encode(array('status'=>0,'message'=>$returnStr));
        }
      } 
    
    echo $json_encode;
  }
  
  
  public function send_user_password($pwd = '', $query) {
    $newsid = '5';
    $template_values = $this->mobile_model->get_newsletter_template_details ( $newsid );
    $adminnewstemplateArr = array (
        'email_title' => $this->config->item ( 'email_title' ),
        'logo' => $this->data ['logo'] 
    );
    extract ( $adminnewstemplateArr );
    $subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];
    $newsid = '5';
    if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
      $sender_email = $this->config->item ( 'site_contact_mail' );
      $sender_name = $this->config->item ( 'email_title' );
    } else {
      $sender_name = $template_values ['sender_name'];
      $sender_email = $template_values ['sender_email'];
    }
    
    $email_values = array (
        'mail_type' => 'html',
        'from_mail_id' => $sender_email,
        'mail_name' => $sender_name,
        'to_mail_id' => $query->row ()->email,
        'subject_message' => 'Password Reset',
        'body_messages' => $message 
    );
    $reg = array (
        'email_title' => $this->config->item ( 'email_title' ),
'pwd' => $pwd,
        'logo' => $this->data ['logo'] 
    );
           
        $message = $this->load->view('newsletter/Forgot Password'.$newsid.'.php',$reg,TRUE);
     //send mail
            $this->load->library('email');
            $this->email->from($email_values['from_mail_id'], $sender_name);
            $this->email->to($email_values['to_mail_id']);
            $this->email->subject($email_values['subject_message']);
            $this->email->set_mailtype("html");
           
                        
      $this->email->message($message); 
      try{
        $this->email->send();

        $returnStr ['msg'] = 'Successfully registered';

        $returnStr ['success'] = '1';
      }catch(Exception $e){
        echo $e->getMessage();
      } 
    
  }
  
  public function send_confirm_mail($userDetails = '') {
  
    $uid = $userDetails->row ()->id;
    $email = $userDetails->row ()->email;
    $name = $userDetails->row ()->firstname.$userDetails->row ()->lastname;
    
    $randStr = $this->get_rand_str ( '10' );
    $condition = array (
        'id' => $uid 
    );
    $dataArr = array (
        'verify_code' => $randStr 
    );
    $this->mobile_model->update_details ( USERS, $dataArr, $condition );
    $newsid = '3';
    $template_values = $this->mobile_model->get_newsletter_template_details( $newsid );
    
    $user=$userDetails->row ()->firstname.' '.$userDetails->row ()->lastname;
    $cfmurl = base_url () . 'site/user/confirm_register/' . $uid . "/" . $randStr . "/confirmation";
    $subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];
    $adminnewstemplateArr = array (
        'email_title' => $this->config->item ( 'email_title' ),
        'logo' => $this->data ['logo'],
        'username'=>$name
    );
    extract ( $adminnewstemplateArr );
    $header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    
    $message .= '<body>';
    include ('./newsletter/registeration' . $newsid . '.php');
    
    $message .= '</body>
      ';
    
    if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
      $sender_email = $this->data ['siteContactMail'];
      $sender_name = $this->data ['siteTitle'];
    } else {
      $sender_name = $template_values ['sender_name'];
      $sender_email = $template_values ['sender_email'];
    }
    $email_values = array (
        'mail_type' => 'html',
        'from_mail_id' => $sender_email,
        'mail_name' => $sender_name,
        'to_mail_id' => $email,
        'subject_message' => $template_values ['news_subject'],
        'body_messages' => trim($message)
    );
    $email_send_to_common = $this->mobile_model->common_email_send ( $email_values );
  }
  /* Amenties list */
  public function list_values() {
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($property_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($property_listvalue->result() as $prty) {
              $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    }
    
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
	
	/***********Yamuna 09-1-2018 Parent Name*********/
	//listing values
	$roombedVal=array();
    $roombedVal1=array();
	$select_qrys = "select * from fc_listing_types WHERE status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		   
	
	/***********Yamuna 09-1-2018 Child Name*********/
    $select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    
    if($list_valuesy->num_rows()>0){
	 if($listing_type=="option") {
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);
	  }
	 }
	}
	$roombedVal[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	/***********Charles 09-1-2018 Parent Name*********/
	
	/* $roombedVal=array();
    $roombedVal1=array();
    $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as   $list){
        $roombedVal[] =json_decode($list->listing_values);
        $roombedVal1[] =json_decode($list->rooms_bed);
      }
    } */
    
    
    $json_encode = json_encode(array("status"=>1,"message"=>"property available","property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"other_attributes" => $roombedVal)); 
    echo $json_encode;
    
  }
  /* List all currency values */
  public function currency_values() {
  
      $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
      $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
      
      $listvalueArr = array();
      if($currency_values->num_rows() >0) {
        foreach($currency_values->result() as $list_value) {
        $listvalueArr[] = array("id" =>$list_value->id,"country_symbols"=>$list_value->currency_symbols,"currency_type"=>$list_value->currency_type,"currency_rate"=>$list_value->currency_rate);
        }
        $json_encode = json_encode(array("status"=>1,"message"=>"Currency list available","list_values"=>$listvalueArr));
      } else {
        $json_encode = json_encode(array("status"=>0,"message"=>"No currency list available","list_values"=>$listvalueArr));
      }
      echo $json_encode;
      
  }
  
  public function mobile_edit_list_value() {
  
  }
  
  public function mobile_delete_image() {
    if($_POST['imageIds'] != ''){
      $imgIds = explode(',', $_POST['imageIds']);
      foreach($imgIds as $imgId)
      {
        $this->db->where('id', $imgId);
        $this->db->delete(PRODUCT_PHOTOS);
      }
      $res = 'Success';
      $json_encode = json_encode(array("status"=>$res));
      echo $json_encode;
    }
    else{
      $res = 'Failed';
      $json_encode = json_encode(array("status"=>$res));
      echo $json_encode;
    }
  }
  /* ADD PROPERTY LIST */
  public function mobile_list_value() {
    
    $email = $_POST['Email'];
    $p_address = $_POST['p_location'];
    $property_type = $_POST['property_type'];
    $t_guest= $_POST['t_guest'];
    $t_bed= $_POST['t_bed'];
    $t_bedroom= $_POST['t_bedroom'];
    
    $bathrooms = $_POST['t_bathroom'];
    
    if($_POST['list_space'] == 1){
    $list_space = 'Entire home/apt';
    }elseif($_POST['list_space'] == 2){
    $list_space = 'Private room';
    }else{
    $list_space = 'Shared room';
    }
    $currency = $_POST['P_Currency'];
    if($currency == '')$currency = 'USD';
    $condition = array('email'=>$email,'status'=>'Active');
    $this->data['checkUser'] = $this->mobile_model->get_all_details(USERS,$condition);
    $id = $this->data['checkUser']->row()->id;
    
    $data = array('room_type'=>$this->input->post('room_type1'),
        'room_type'=>$list_space,
        'home_type'=>$property_type,
        'accommodates'=>$t_guest,
        'bedrooms'=>$t_bedroom,
        'beds'=>$t_bed,
        'noofbathrooms'=>$bathrooms,
        'user_id'=>$id,
        'currency'=>$currency,
        'status'=>'UnPublish',
        'through'=>'mobile'
      );

    $this->mobile_model->simple_insert(PRODUCT,$data);
    //echo $this->db->last_query();die;
    $getInsertId=$this->mobile_model->get_last_insert_id();
    
    $street = '';
    $street1 = '';
    $area = '';
    $location = '';
    $city = '';
    $state = '';
    $country = '';
    $lat = '';
    $long = '';
    $zip = '';
    $address = str_replace(" ", "+", $p_address);
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$this->google_map_api");
    $json = json_decode($json);
    
    $newAddress = $json->{'results'}[0]->{'address_components'};
    foreach($newAddress as $nA)
    {
      if($nA->{'types'}[0] == 'route')$street = $nA->{'long_name'};
      if($nA->{'types'}[0] == 'sublocality_level_2')$street1 = $nA->{'long_name'};
      if($nA->{'types'}[0] == 'sublocality_level_1')$area = $nA->{'long_name'};
      if($nA->{'types'}[0] == 'locality')$location = $nA->{'long_name'};
      if($nA->{'types'}[0] == 'administrative_area_level_2')$city = $nA->{'long_name'};
      if($nA->{'types'}[0] == 'administrative_area_level_1')$state = $nA->{'long_name'};
      if($nA->{'types'}[0] == 'country')$country = $nA->{'long_name'};
      if($nA->{'types'}[0] == 'postal_code')$zip = $nA->{'long_name'};
    }
    if($city == '')
    $city = $location;
    
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $lang = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    
    $data = array('address' => $p_address,'productId' => $getInsertId,'street' => $street,'area' => $area,'location' => $location,'city' => $city,'state' => $state,'country' => $country,'lang' => $lang,'lat' => $lat,'zip' => $zip);
    
    $this->mobile_model->simple_insert(PRODUCT_ADDRESS_NEW,$data);
    
    $inputArr = array('product_id' =>$getInsertId);
    
    $this->mobile_model->simple_insert(PRODUCT_BOOKING,$inputArr);

    $inputArr = array('id' =>$getInsertId);
    
    $this->mobile_model->simple_insert(SCHEDULE,$inputArr);
    
    $this->mobile_model->update_details(USERS,array('group'=>'Seller'),array('id'=>$id));
    
    $res = 'successfully added';
    
    $condition1 = array('id'=>$getInsertId);
    
    $pDetails = $this->mobile_model->get_all_details(PRODUCT,$condition1);
    
    $currency = $pDetails->row()->currency;
    
    if($currency == '')$currency = 'USD';
    
    $json_encode = json_encode(array("status"=>$res,'p_id'=>$getInsertId,'currency'=>$currency,'location'=>$p_address, "lat"=>$lat,"long"=>$lang));
    
    echo $json_encode;
  }
  /* UPDATE PROPERTY LIST */
  public function mobile_update_list() {
    if($_POST['P_Title'] !='' && $_POST['P_Id'] != '') {
        $data = array(
        'product_title'=>$_POST['P_Title']
          );
      
      $condition = array(
        'id'=>$_POST['P_Id']  
          );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Price'] !='' && $_POST['P_Id'] != '') {
      $data = array(
        'price'=>$_POST['P_Price']
          );
      
      $condition = array(
        'id'=>$_POST['P_Id']  
          );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Summary'] !='' && $_POST['P_Id'] != '') {
      $data = array(
        'description'=>$_POST['P_Summary']
          );
      
      $condition = array(
        'id'=>$_POST['P_Id']  
          );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Currency'] != '' && $_POST['P_Id'] != '' )
    {
      if($_POST['P_Currency'] == '')$c_value = 'USD';
      else $c_value = $_POST['P_Currency'];
      $data = array(
        'currency'=>$c_value
        );
      
      $condition = array(
        'id'=>$_POST['P_Id']  
        );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    
    if($_POST['p_address'] != '' && $_POST['P_Id'] != '' )
    {
      $p_address = $_POST['p_address'];
      $street = '';
      $street1 = '';
      $area = '';
      $location = '';
      $city = '';
      $state = '';
      $country = '';
      $lat = '';
      $long = '';
      $zip = '';
      $address = str_replace(" ", "+", $p_address);
      $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$this->google_map_api");
      $json = json_decode($json);
      
      $newAddress = $json->{'results'}[0]->{'address_components'};
      foreach($newAddress as $nA)
      {
        if($nA->{'types'}[0] == 'route')$street = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'sublocality_level_2')$street1 = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'sublocality_level_1')$area = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'locality')$location = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'administrative_area_level_2')$city = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'administrative_area_level_1')$state = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'country')$country = $nA->{'long_name'};
        if($nA->{'types'}[0] == 'postal_code')$zip = $nA->{'long_name'};
      }
      if($city == '')
      $city = $location;
      
      $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
      $lang = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
      
      $data = array('address' => $p_address,'street' => $street,'area' => $area,'location' => $location,'city' => $city,'state' => $state,'country' => $country,'lang' => $lang,'lat' => $lat,'zip' => $zip);
      
      $condition = array(
        'productId'=>$_POST['P_Id'] 
        );
      $this->mobile_model->update_details(PRODUCT_ADDRESS_NEW ,$data ,$condition);
    }
    if($_FILES['photo'] != '' && $_POST['P_Id'] != '') { 
      $uploaddir = "server/php/rental/";
      //$data = file_get_contents($_FILES['photo']['tmp_name']);
      //$image = imagecreatefromstring( $data );
      //echo 'Hi';die;
      $imgname=time().".jpg";
      //imagejpeg($image,$uploaddir.$imgname, 99);
      //echo 'Hi';die;
      move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir.$imgname);
      @copy($uploaddir.$imgname, './server/php/rental/mobile/'.$imgname);
      $imageName=$imgname;
      /* $image_name=$imgname;
      $newname=$uploaddir.$image_name;
      
      
      $timeImg=time();
      @copy($imgname, './server/php/rental/mobile/'.$imgname);
      $target_file=$uploaddir.$image_name;
      $imageName=$imgname; 
      $option=$this->getImageShape(800,750,$target_file);
      
      $resizeObj = new Resizeimage($target_file); 
      $resizeObj -> resizeImage(800, 750, $option);
      $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
      $this->ImageCompress($uploaddir.'mobile/'.$imageName);
      @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName); */

      $inputArr3 = array(
        'product_id' =>$_POST['P_Id'],
        'product_image'=>$imgname,
        'mproduct_image'=>$imageName
          ); 
      $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
      $getPhotoInsertId=$this->mobile_model->get_last_insert_id();
      $latLong = $this->mobile_model->get_all_details(PRODUCT_ADDRESS_NEW, array('productId'=>$_POST['P_Id']));
      $res = 'successfully added';  
      $json_encode = json_encode(array("status"=>$res, "image"=>$imgname,"imgId"=>$getPhotoInsertId, "lat"=>$latLong->row()->lat,"long"=>$latLong->row()->lang));
      echo $json_encode;die;
    }
    if($_FILES['photo1'] != '' && $_POST['P_Id'] != '') {
      $uploaddir = "server/php/rental/";
      $data = file_get_contents($_FILES['photo1']['tmp_name']);
      $image = imagecreatefromstring( $data );
      $imgname=time().".jpg";
      imagejpeg($image,$uploaddir.$imgname, 99);


      $image_name=$imgname;
      $newname=$uploaddir.$image_name;
      
      
      $timeImg=time();
      @copy($imgname, './server/php/rental/mobile/'.$imgname);
      $target_file=$uploaddir.$image_name;
      $imageName=$imgname; 
      $option=$this->getImageShape(800,750,$target_file);
      
      $resizeObj = new Resizeimage($target_file); 
      $resizeObj -> resizeImage(800, 750, $option);
      $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
      $this->ImageCompress($uploaddir.'mobile/'.$imageName);
      @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);

      $inputArr3 = array(
        'product_id' =>$_POST['P_Id'],
        'product_image'=>$imgname,
        'mproduct_image'=>$imageName
          );
      $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
    }
    if($_FILES['photo2'] != '' && $_POST['P_Id'] != '') {
      $uploaddir = "server/php/rental/";
      $data = file_get_contents($_FILES['photo2']['tmp_name']);
      $image = imagecreatefromstring( $data );
      $imgname=time().".jpg";
      imagejpeg($image,$uploaddir.$imgname, 99);


      $image_name=$imgname;
      $newname=$uploaddir.$image_name;
      
      
      $timeImg=time();
      @copy($imgname, './server/php/rental/mobile/'.$imgname);
      $target_file=$uploaddir.$image_name;
      $imageName=$imgname; 
      $option=$this->getImageShape(500,350,$target_file);
      
      $resizeObj = new Resizeimage($target_file); 
      $resizeObj -> resizeImage(500, 350, $option);
      $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
      $this->ImageCompress($uploaddir.'mobile/'.$imageName);
      @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);

      $inputArr3 = array(
        'product_id' =>$_POST['P_Id'],
        'product_image'=>$imgname,
        'mproduct_image'=>$imageName
          );
      $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
    }
    if($_FILES['photo3'] != '' && $_POST['P_Id'] != '') {
      $uploaddir = "server/php/rental/";
      $data = file_get_contents($_FILES['photo3']['tmp_name']);
      $image = imagecreatefromstring( $data );
      $imgname=time().".jpg";
      imagejpeg($image,$uploaddir.$imgname, 99);


      $image_name=$imgname;
      $newname=$uploaddir.$image_name;
      
      
      $timeImg=time();
      @copy($imgname, './server/php/rental/mobile/'.$imgname);
      $target_file=$uploaddir.$image_name;
      $imageName=$imgname; 
      $option=$this->getImageShape(500,350,$target_file);
      
      $resizeObj = new Resizeimage($target_file); 
      $resizeObj -> resizeImage(500, 350, $option);
      $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
      $this->ImageCompress($uploaddir.'mobile/'.$imageName);
      @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);

      $inputArr3 = array(
        'product_id' =>$_POST['P_Id'],
        'product_image'=>$imgname,
        'mproduct_image'=>$imageName
          );
      $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
    }
    if($_FILES['photo4'] != '' && $_POST['P_Id'] != '') {
      $uploaddir = "server/php/rental/";
      $data = file_get_contents($_FILES['photo4']['tmp_name']);
      $image = imagecreatefromstring( $data );
      $imgname=time().".jpg";
      imagejpeg($image,$uploaddir.$imgname, 99);


      $image_name=$imgname;
      $newname=$uploaddir.$image_name;
      
      
      $timeImg=time();
      @copy($imgname, './server/php/rental/mobile/'.$imgname);
      $target_file=$uploaddir.$image_name;
      $imageName=$imgname; 
      $option=$this->getImageShape(500,350,$target_file);
      
      $resizeObj = new Resizeimage($target_file); 
      $resizeObj -> resizeImage(500, 350, $option);
      $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
      $this->ImageCompress($uploaddir.'mobile/'.$imageName);
      @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);

      $inputArr3 = array(
        'product_id' =>$_POST['P_Id'],
        'product_image'=>$imgname,
        'mproduct_image'=>$imageName
          );
      $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
    }
    if($_FILES['photo5'] != '' && $_POST['P_Id'] != '') {
      $uploaddir = "server/php/rental/";
      $data = file_get_contents($_FILES['photo5']['tmp_name']);
      $image = imagecreatefromstring( $data );
      $imgname=time().".jpg";
      imagejpeg($image,$uploaddir.$imgname, 99);


      $image_name=$imgname;
      $newname=$uploaddir.$image_name;
      
      
      $timeImg=time();
      @copy($imgname, './server/php/rental/mobile/'.$imgname);
      $target_file=$uploaddir.$image_name;
      $imageName=$imgname; 
      $option=$this->getImageShape(500,350,$target_file);
      
      $resizeObj = new Resizeimage($target_file); 
      $resizeObj -> resizeImage(500, 350, $option);
      $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
      $this->ImageCompress($uploaddir.'mobile/'.$imageName);
      @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);

      $inputArr3 = array(
        'product_id' =>$_POST['P_Id'],
        'product_image'=>$imgname,
        'mproduct_image'=>$imageName
      );
      $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
    }
    if($_POST['P_Id'] != '' && $_POST['list_space'] !='')
    {
      $t_guest= $_POST['t_guest'];
      $t_bed= $_POST['t_bed'];
      $t_bedroom= $_POST['t_bedroom'];
      $property_type= $_POST['property_type'];

      if($_POST['t_bathroom'] == 1){
        $bathrooms = 'Private';
      }elseif($_POST['t_bathroom'] == 2){
        $bathrooms = 'Both';
      }else{
        $bathrooms = 'Shared';
      }

      if($_POST['P_Id'] != '' && $_POST['list_space'] == 1){
        $list_space = 'entire home/apt';
      }elseif($_POST['list_space'] == 2){
        $list_space = 'private room';
      }else{
        $list_space = 'Shared room';
      }
      
      $data = array(
        'room_type'=>$list_space,
        'home_type'=>$property_type,
        'accommodates'=>$t_guest,
        'bedrooms'=>$t_bedroom,
        'beds'=>$t_bed,
        'bathrooms'=>$bathrooms
      );

      $condition = array(
        'id'=>$_POST['P_Id']  
      );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Id'] != '' && $_POST['d_space'] !='')
    {
      $data = array(
        'space'=>$_POST['d_space']
      );

      $condition = array(
        'id'=>$_POST['P_Id']  
      );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Id'] != '' && $_POST['P_Title'] !='')
    {
      $data = array(
        'product_title'=>$_POST['P_Title']
      );

      $condition = array(
        'id'=>$_POST['P_Id']  
      );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Id'] != '' && $_POST['P_Summary'] !='')
    {
      $data = array(
        'description'=>$_POST['P_Summary']
      );

      $condition = array(
        'id'=>$_POST['P_Id']  
      );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Id'] != '' && $_POST['d_other'] !='')
    {
      $condition = array('email'=>$_POST['Email'],'status'=>'Active');

      $data = array(
        'other_thingnote'=>$_POST['d_other']
      );

      $condition = array(
        'id'=>$_POST['P_Id']  
      );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Id'] != '' && $_POST['d_house_rules'] !='')
    {
      $data = array(
        'house_rules'=>$_POST['d_house_rules']
      );

      $condition = array(
        'id'=>$_POST['P_Id']  
      );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Id'] != '' && $_POST['d_listvalue'] !='')
    {
      $data = array(
        'list_name'=>$_POST['d_listvalue']
      );

      $condition = array(
        'id'=>$_POST['P_Id']  
      );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Id'] != '' && $_POST['l_week'] !='')
    {
      $data = array(
      'price_perweek'=>$_POST['l_week'],
      'price_permonth'=>$_POST['l_month']
      );

      $condition = array(
      'id'=>$_POST['P_Id']  
      );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    if($_POST['P_Id'] != '' && $_POST['P_Currency'] !='')
    {
      if($_POST['P_Currency'] == '')$c_value = 'USD';
      else $c_value = $_POST['P_Currency'];
      $data = array(
        'currency'=>$c_value
      );

      $condition = array(
        'id'=>$_POST['P_Id']  
      );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    }
    $res = 'successfully added';
    $latLong = $this->mobile_model->get_all_details(PRODUCT_ADDRESS_NEW, array('productId'=>$_POST['P_Id']));
    $json_encode = json_encode(array("status"=>$res, "lat"=>$latLong->row()->lat,"long"=>$latLong->row()->lang));
    echo $json_encode;
  }
  
  public function mobile_listvalue() {
    $email = $_POST['Email'];
    $p_address = $_POST['p_address'];
    $p_location = $_POST['p_location'];
    $fulladdress = explode(',',$p_address);
    $lat = $_POST['P_Address_LatLon'];
    $log = explode(',',$lat);
    $property_type = $_POST['property_type'];
    
    $t_guest= $_POST['t_guest'];
    $t_bed= $_POST['t_bed'];
    $t_bedroom= $_POST['t_bedroom'];
    
    if($_POST['t_bathroom'] == 1){
    $bathrooms = 'Private';
    }elseif($_POST['t_bathroom'] == 2){
    $bathrooms = 'Both';
    }else{
    $bathrooms = 'Shared';
    }
    
    if($_POST['list_space'] == 1){
    $list_space = 'entire home/apt';
    }elseif($_POST['list_space'] == 2){
    $list_space = 'private room';
    }else{
    $list_space = 'Shared room';
    }
    
    $condition = array('email'=>$email,'status'=>'Active');
    $this->data['checkUser'] = $this->mobile_model->get_all_details(USERS,$condition);
    $id = $this->data['checkUser']->row()->id;
    //echo $this->data['checkUser']->num_rows();die;
    if($_POST['Email'] != '' && $_POST['P_Id'] != ''){
    //post value start
      if($_FILES['photo1'] != '') {
            
          $uploaddir = "server/php/rental/";
          $data = file_get_contents($_FILES['photo1']['tmp_name']);
          $image = imagecreatefromstring( $data );
          $imgname=time().".jpg";
          imagejpeg($image,$uploaddir.$imgname, 99);


          $image_name=$imgname;
          $newname=$uploaddir.$image_name;
          
          
          $timeImg=time();
          @copy($imgname, './server/php/rental/mobile/'.$imgname);
          $target_file=$uploaddir.$image_name;
          $imageName=$imgname; 
          $option=$this->getImageShape(800,750,$target_file);
          
          $resizeObj = new Resizeimage($target_file); 
          $resizeObj -> resizeImage(800, 750, $option);
          $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
          $this->ImageCompress($uploaddir.'mobile/'.$imageName);
          @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);

          $inputArr3 = array(
            'product_id' =>$_POST['P_Id'],
            'product_image'=>$imgname,
            'mproduct_image'=>$imageName
              );
          $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
          
          
      }
      if($_FILES['photo2'] != '') {
          $uploaddir = "server/php/rental/";
          $data = file_get_contents($_FILES['photo2']['tmp_name']);
          $image = imagecreatefromstring( $data );
          $imgname=time().".jpg";
          imagejpeg($image,$uploaddir.$imgname, 99);


          $image_name=$imgname;
          $newname=$uploaddir.$image_name;
          
          
          $timeImg=time();
          @copy($imgname, './server/php/rental/mobile/'.$imgname);
          $target_file=$uploaddir.$image_name;
          $imageName=$imgname; 
          $option=$this->getImageShape(500,350,$target_file);
          
          $resizeObj = new Resizeimage($target_file); 
          $resizeObj -> resizeImage(500, 350, $option);
          $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
          $this->ImageCompress($uploaddir.'mobile/'.$imageName);
          @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);

          $inputArr3 = array(
            'product_id' =>$_POST['P_Id'],
            'product_image'=>$imgname,
            'mproduct_image'=>$imageName
              );
          $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
          
      }
      if($_FILES['photo3'] != '') {
        $uploaddir = "server/php/rental/";
          $data = file_get_contents($_FILES['photo3']['tmp_name']);
          $image = imagecreatefromstring( $data );
          $imgname=time().".jpg";
          imagejpeg($image,$uploaddir.$imgname, 99);


          $image_name=$imgname;
          $newname=$uploaddir.$image_name;
          
          
          $timeImg=time();
          @copy($imgname, './server/php/rental/mobile/'.$imgname);
          $target_file=$uploaddir.$image_name;
          $imageName=$imgname; 
          $option=$this->getImageShape(500,350,$target_file);
          
          $resizeObj = new Resizeimage($target_file); 
          $resizeObj -> resizeImage(500, 350, $option);
          $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
          $this->ImageCompress($uploaddir.'mobile/'.$imageName);
          @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);

          $inputArr3 = array(
            'product_id' =>$_POST['P_Id'],
            'product_image'=>$imgname,
            'mproduct_image'=>$imageName
              );
          $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
          
      }
      if($_FILES['photo4'] != '') {
          $uploaddir = "server/php/rental/";
          $data = file_get_contents($_FILES['photo4']['tmp_name']);
          $image = imagecreatefromstring( $data );
          $imgname=time().".jpg";
          imagejpeg($image,$uploaddir.$imgname, 99);


          $image_name=$imgname;
          $newname=$uploaddir.$image_name;
          
          
          $timeImg=time();
          @copy($imgname, './server/php/rental/mobile/'.$imgname);
          $target_file=$uploaddir.$image_name;
          $imageName=$imgname; 
          $option=$this->getImageShape(500,350,$target_file);
          
          $resizeObj = new Resizeimage($target_file); 
          $resizeObj -> resizeImage(500, 350, $option);
          $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
          $this->ImageCompress($uploaddir.'mobile/'.$imageName);
          @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);

          $inputArr3 = array(
            'product_id' =>$_POST['P_Id'],
            'product_image'=>$imgname,
            'mproduct_image'=>$imageName
              );
          $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
          
      }
      if($_FILES['photo5'] != '') {
          $uploaddir = "server/php/rental/";
          $data = file_get_contents($_FILES['photo5']['tmp_name']);
          $image = imagecreatefromstring( $data );
          $imgname=time().".jpg";
          imagejpeg($image,$uploaddir.$imgname, 99);


          $image_name=$imgname;
          $newname=$uploaddir.$image_name;
          
          
          $timeImg=time();
          @copy($imgname, './server/php/rental/mobile/'.$imgname);
          $target_file=$uploaddir.$image_name;
          $imageName=$imgname; 
          $option=$this->getImageShape(500,350,$target_file);
          
          $resizeObj = new Resizeimage($target_file); 
          $resizeObj -> resizeImage(500, 350, $option);
          $resizeObj -> saveImage($uploaddir.'mobile/'.$imageName, 100);
          $this->ImageCompress($uploaddir.'mobile/'.$imageName);
          @copy($uploaddir.'mobile/'.$imageName, $uploaddir.'mobile/'.$imageName);

          $inputArr3 = array(
            'product_id' =>$_POST['P_Id'],
            'product_image'=>$imgname,
            'mproduct_image'=>$imageName
              );
          $this->mobile_model->simple_insert(PRODUCT_PHOTOS,$inputArr3);
          
      }
      if($_POST['P_Id'] != '') {
        if($_POST['P_Title'] !='') {
        
          $data = array(
            'product_title'=>$_POST['P_Title']
              );
          
          $condition = array(
            'id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
        }
        if($_POST['P_Price'] !='') {
          $data = array(
            'price'=>$_POST['P_Price']
              );
          
          $condition = array(
            'id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
        }
        if($_POST['P_Summary'] !='') {
          $data = array(
            'description'=>$_POST['P_Summary']
              );
          
          $condition = array(
            'id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
        }
        if(count($fulladdress) > 3 && $_POST['P_Id'] != '') {
        $data = array(
            'address'=>$fulladdress[4].$fulladdress[3],
            'latitude'=>$log[0],
            'longitude'=>$log[1]
            );
        $condition = array(
            'product_id'=>$_POST['P_Id']  
              );
        $this->mobile_model->update_details(PRODUCT_ADDRESS ,$data ,$condition);
        
        $condition = array('name'=>$fulladdress[0]);
        $this->data['city'] = $this->mobile_model->get_all_details(CITY,$condition);
        $city_id = $this->data['city']->row()->id;
        if($this->data['city']->num_rows() !=0 ) {
          $data = array(
            'city'=>$city_id
            );
          $condition = array(
            'product_id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT_ADDRESS ,$data ,$condition);
          //echo $this->db->last_query();
        }
        $condition1 = array('name'=>$fulladdress[1]);
        $this->data['state'] = $this->mobile_model->get_all_details(STATE_TAX,$condition1);
        $state = $city_id = $this->data['state']->row()->id;
        if($this->data['state']->num_rows() !=0 ) {
          $data = array(
            'state'=>$state
            );
          $condition = array(
            'product_id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT_ADDRESS ,$data ,$condition);
          //echo $this->db->last_query();
        }
        //echo "country".$fulladdress[2];
        $condition2 = array('name'=>$fulladdress[2]);
        $this->data['LOCATIONS'] = $this->mobile_model->get_all_details(COUNTRY_LIST,$condition2);
        $loc = $city_id = $this->data['LOCATIONS']->row()->id;
        if($this->data['LOCATIONS']->num_rows() !=0 ) {
          $data = array(
            'country'=>$loc
            );
          $condition = array(
            'product_id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT_ADDRESS ,$data ,$condition);
          //echo $this->db->last_query();
        }
        
        
      
      }
      
      if(count($fulladdress) == 3 && $_POST['P_Id'] != '') {
        
        $condition = array('name'=>$fulladdress[0]);
        $this->data['city'] = $this->mobile_model->get_all_details(CITY,$condition);
        $city_id = $this->data['city']->row()->id;
        if($this->data['city']->num_rows() !=0 ) {
          $data = array(
            'city'=>$city_id,
            'latitude'=>$log[0],
            'longitude'=>$log[1]
            );
          $condition = array(
            'product_id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT_ADDRESS ,$data ,$condition);
          //echo $this->db->last_query();
        }
        $condition1 = array('name'=>$fulladdress[1]);
        $this->data['state'] = $this->mobile_model->get_all_details(STATE_TAX,$condition1);
        $state = $city_id = $this->data['state']->row()->id;
        if($this->data['state']->num_rows() !=0 ) {
          $data = array(
            'state'=>$state
            );
          $condition = array(
            'product_id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT_ADDRESS ,$data ,$condition);
          //echo $this->db->last_query();
        }
        //echo "country".$fulladdress[2];
        $condition2 = array('name'=>$fulladdress[2]);
        $this->data['LOCATIONS'] = $this->mobile_model->get_all_details(COUNTRY_LIST,$condition2);
        $loc = $city_id = $this->data['LOCATIONS']->row()->id;
        if($this->data['LOCATIONS']->num_rows() !=0 ) {
          $data = array(
            'country'=>$loc
            );
          $condition = array(
            'product_id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT_ADDRESS ,$data ,$condition);
          //echo $this->db->last_query();
        }
        
        
      
      }
      if(count($fulladdress) == 2 && $_POST['P_Id'] != '') {
        
        
        $condition1 = array('name'=>$fulladdress[0]);
        $this->data['state'] = $this->mobile_model->get_all_details(STATE_TAX,$condition1);
        $state = $city_id = $this->data['state']->row()->id;
        if($this->data['state']->num_rows() !=0 ) {
          $data = array(
            'state'=>$state,
            'latitude'=>$log[0],
            'longitude'=>$log[1]
            );
          $condition = array(
            'product_id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT_ADDRESS ,$data ,$condition);
          //echo $this->db->last_query();
        }
        //echo "country".$fulladdress[2];
        $condition2 = array('name'=>$fulladdress[1]);
        $this->data['LOCATIONS'] = $this->mobile_model->get_all_details(COUNTRY_LIST,$condition2);
        $loc = $city_id = $this->data['LOCATIONS']->row()->id;
        if($this->data['LOCATIONS']->num_rows() !=0 ) {
          $data = array(
            'country'=>$loc
            );
          $condition = array(
            'product_id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT_ADDRESS ,$data ,$condition);
          //echo $this->db->last_query();
        }
        
        
      
      }
      
      if(count($fulladdress) == 1 && $_POST['P_Id'] != '') {
        $condition2 = array('name'=>$fulladdress[0]);
        $this->data['LOCATIONS'] = $this->mobile_model->get_all_details(COUNTRY_LIST,$condition2);
        $loc = $city_id = $this->data['LOCATIONS']->row()->id;
        if($this->data['LOCATIONS']->num_rows() !=0 ) {
          $data = array(
            'country'=>$loc
            );
          $condition = array(
            'product_id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT_ADDRESS ,$data ,$condition);
          //echo $this->db->last_query();
        }
        
        
      
      }
        
        
        
        //post value end
      }
      $res = 'successfully added';  
      $json_encode = json_encode(array("status"=>$res));
      }elseif($this->data['checkUser']->num_rows() == 1){
    
          $data = array('room_type'=>$this->input->post('room_type1'),
                 'room_type'=>$list_space,
                 'home_type'=>$property_type,
                 'accommodates'=>$t_guest,
                 'bedrooms'=>$t_bedroom,
                 'beds'=>$t_bed,
                 'bathrooms'=>$bathrooms,
                 'user_id'=>$id,
                 'status'=>'UnPublish',
                 'through'=>'mobile'
              );
              
      $this->mobile_model->simple_insert(PRODUCT,$data);
      //echo $this->db->last_query();die;
      $getInsertId=$this->mobile_model->get_last_insert_id();
      $inputArr3 = array(
            'product_id' =>$getInsertId,
            'address'=>$_POST['p_location']
               );
      $this->mobile_model->simple_insert(PRODUCT_ADDRESS,$inputArr3);
      $addr_id=$this->mobile_model->get_last_insert_id();
      $location = $_POST['p_location'];
      $this->mobile_model->update_details(USERS,array('group'=>'Seller'),array('id'=>$id));
      $res = 'successfully added';
      $condition1 = array('id'=>$getInsertId);
      $pDetails = $this->mobile_model->get_all_details(PRODUCT,$condition1);
      $currency = $pDetails->row()->currency;
      if($currency = '')$currency = 'USD';
      $json_encode = json_encode(array("status"=>$res,'p_id'=>$getInsertId,'currency'=>$currency,'location'=>$location));
      }elseif($_POST['P_Id'] != '' && $_POST['list_space'] !=''){
      $t_guest= $_POST['t_guest'];
      $t_bed= $_POST['t_bed'];
      $t_bedroom= $_POST['t_bedroom'];
      $property_type= $_POST['property_type'];

      if($_POST['t_bathroom'] == 1){
      $bathrooms = 'Private';
      }elseif($_POST['t_bathroom'] == 2){
      $bathrooms = 'Both';
      }else{
      $bathrooms = 'Shared';
      }

      if($_POST['list_space'] == 1){
      $list_space = 'entire home/apt';
      }elseif($_POST['list_space'] == 2){
      $list_space = 'private room';
      }else{
      $list_space = 'Shared room';
      }
      $data = array(
            'room_type'=>$list_space,
             'home_type'=>$property_type,
             'accommodates'=>$t_guest,
             'bedrooms'=>$t_bedroom,
             'beds'=>$t_bed,
             'bathrooms'=>$bathrooms
              );
          
      $condition = array(
        'id'=>$_POST['P_Id']  
          );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
      
      $res = 'successfully added';
      $json_encode = json_encode(array("status"=>$res));
      }elseif($_POST['P_Id'] != '' && $_POST['d_space'] !=''){
      //echo  $_GET['P_Id'];die;
      $data = array(
            'space'=>$_POST['d_space']
              );
          
          $condition = array(
            'id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
      $res = 'successfully added';
      $json_encode = json_encode(array("status"=>$res));
      }elseif($_POST['P_Id'] != '' && $_POST['P_Title'] !=''){
      $data = array(
        'product_title'=>$_POST['P_Title']
          );
      
      $condition = array(
        'id'=>$_POST['P_Id']  
          );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
      $res = 'successfully added';
      $json_encode = json_encode(array("status"=>$res));
      }elseif($_POST['P_Id'] != '' && $_POST['P_Summary'] !=''){
      $data = array(
        'description'=>$_POST['P_Summary']
          );
      
      $condition = array(
        'id'=>$_POST['P_Id']  
          );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
      $res = 'successfully added';
      $json_encode = json_encode(array("status"=>$res));
      }elseif($_POST['P_Id'] != '' && $_POST['d_other'] !=''){
      $condition = array('email'=>$_POST['Email'],'status'=>'Active');
      
      $data = array(
            'other_thingnote'=>$_POST['d_other']
              );
          
          $condition = array(
            'id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
      $res = 'successfully added';
      $json_encode = json_encode(array("status"=>$res));
      }elseif($_POST['P_Id'] != '' && $_POST['d_house_rules'] !=''){

      $data = array(
            'house_rules'=>$_POST['d_house_rules']
              );
          
          $condition = array(
            'id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
      $res = 'successfully added';
      $json_encode = json_encode(array("status"=>$res));
      }elseif($_POST['P_Id'] != '' && $_POST['d_listvalue'] !=''){

      $data = array(
            'list_name'=>$_POST['d_listvalue']
          );
          
      $condition = array(
        '   id'=>$_POST['P_Id'] 
          );
      $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
      $res = 'successfully added';
      $json_encode = json_encode(array("status"=>$res));
      }elseif($_POST['P_Id'] != '' && $_POST['l_week'] !=''){

      $data = array(
            'price_perweek'=>$_POST['l_week'],
            'price_permonth'=>$_POST['l_month']
              );
          
          $condition = array(
            'id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
      $res = 'successfully added';
      $json_encode = json_encode(array("status"=>$res));
      }elseif($_POST['P_Id'] != '' && $_POST['P_Price'] !=''){
      
          $data = array(
            'price'=>$_POST['P_Price']
              );
          
          $condition = array(
            'id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
      $res = 'successfully added';
      $json_encode = json_encode(array("status"=>$res));
      
      }elseif($_POST['P_Id'] != '' && $_POST['P_Currency'] !=''){
      if($_POST['P_Currency'] == '')$c_value = 'USD';
      else $c_value = $_POST['P_Currency'];
      $data = array(
            'currency'=>$c_value
              );
          
          $condition = array(
            'id'=>$_POST['P_Id']  
              );
          $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
      $res = 'successfully added';
      $json_encode = json_encode(array("status"=>$res));
      }else{
      $res = 'failed';
      $json_encode = json_encode(array("status"=>$res));
      }
      echo $json_encode;
  }
  /* Property listing in user your listing */
  public function mobile_listview(){
    $id = $_POST['userid'];
    if($id == "") {
      $json_encode = json_encode(array("status"=>0,"message"=>"Missing parameter!"));
      echo $json_encode; 
      exit;
    }
    
    $hosting_commission='SELECT * FROM '.COMMISSION.' WHERE seo_tag="host-listing"';
    $hosting_commission_status=$this->mobile_model->ExecuteQuery($hosting_commission);
    $condition = array('id'=>$id);    
    $this->db->select('p.product_title,p.description,p.price,p.calendar_checked,p.list_name,p.id,p.user_status,p.status,p.room_type,pp.product_image,pa.address,pa.country, pa.lat, pa.lang, u.user_name as hostname,pa.lat as latitude,p.listings,p.cancellation_policy,hs.payment_status,p.created,p.currency,p.user_id as host_id');
    $this->db->from(PRODUCT.' as p');
    $this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=p.id","LEFT");
    $this->db->join(USERS.' as u',"u.id=p.user_id","LEFT");
    $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
    $this->db->join(HOSTPAYMENT.' as hs',"hs.product_id=p.id","LEFT");
    $this->db->where('p.user_id',$id);
    if($_POST['status'] == 'publish')
    $this->db->where('p.status','Publish');
    if($_POST['status'] == 'unpublish')
    $this->db->where('p.status','UnPublish');
    $this->db->order_by('p.id','desc');
    $this->db->group_by('p.id');
    $query = $this->db->get();
    $search_res1 = $query->result();
    if($query->num_rows() != 0) {
      foreach($search_res1 as $res1){ 
        $total_steps=8;
        if($res1->product_title !="")
        {
          $total_steps--;
        }
        if($res1->price !="0.00")
        {
          $total_steps--;
        }
        if($res1->calendar_checked !="")
        {
          $total_steps--;
        }
        if($res1->product_image !="")
        {
          $total_steps--;
        }
        if($res1->list_name !="")
        {
          $total_steps--;
        }
        if($res1->latitude !="" && $res1->latitude !="0")
        {
          $total_steps--;
        }
        
        if($res1->listings !="")
        {
          $total_steps--;
        }

        if($res1->cancellation_policy !="")
        {
          $total_steps--;
        }
        $payable = false;
        $calendar_status = false;
        if($res1->status == 'Publish' ){
          $calendar_status = true;
        }
        if($total_steps != 0 ){
          $status = $total_steps.' steps to list';
        } else {
          if($res1->status == 'Publish' && $total_steps == 0){
            $status = 'Listed';
          } elseif($res1->status == 'UnPublish' && $total_steps == 0 && $hosting_commission_status->row()->status == 'Inactive'){
            $status = 'Pending';
          } elseif($res1->status == 'UnPublish' && $total_steps == 0 && $hosting_commission_status->row()->status == 'Active' && $res1->payment_status == 'paid'){
            $status = 'Pending';
          } elseif($res1->status == 'UnPublish' && $total_steps == 0 && $hosting_commission_status->row()->status == 'Active') {
            $status = 'Pay';
            $payable = true;
          }
        } 
          
    
        if($res1->product_image != ''){
          $p_img = explode('.',$res1->product_image); 

          $suffix = strrchr($res1->product_image, "."); 
          $pos = strpos  ( $res1->product_image  , $suffix); 
          $name = substr_replace ($res1->product_image, "", $pos); 
         // echo $suffix . "<br><br>". $name;

          $pro_img = $name.''.$suffix; 
          
          $proImage = base_url().'server/php/rental/'.$pro_img;
        }else{
          $proImage = base_url().'server/php/rental/dummyProductImage.jpg';
        }
        $adminCurrency = 'USD';
        // $condition = array('currency_type'=>$res1->currency);
        $condition = array('currency_type'=>$adminCurrency);

        //$condition = array('currency_type'=>$res1->currency);
        $property_currency_details = $this->mobile_model->get_all_details ( CURRENCY, $condition );
        $property_currency_symbol = $property_currency_details->row()->currency_symbols;
          
          $product_title = $res1->product_title;
          $hostname = $res1->hostname;
          $price = floatval($res1->price);
          $commission=$hosting_commission_status->row()->commission_percentage;
          if($hosting_commission_status->row()->promotion_type=='percentage')
          {
            $hosting_price=floatval(($res1->price/100)*$commission);
          }
          else{
            $hosting_price=floatval($commission);
          }
          $productarr[] = array('remaining_steps'=>$total_steps,'property_image'=>$proImage,'property_title'=>$product_title,'property_price'=>$hosting_price,'property_status'=>$status,'hostname'=>$hostname,'property_id'=>intval($res1->id),'created_date'=>$res1->created,'property_currency_code'=>$adminCurrency,'property_currency_symbol'=>$property_currency_symbol,'payable'=>$payable,'calendar_status'=>$calendar_status,'host_id'=>intval($res1->host_id));
      }
    }
      
    $this->db->select('pb.product_id,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name,pa.state as state_name, pa.city as city_name, p.product_name,p.product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.currencycode, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno,p.cancellation_policy,p.house_rules,rq.NoofGuest');
    $this->db->from(PRODUCT_BOOKING.' as pb');
    $this->db->join(PRODUCT_ADDRESS_NEW.' as pa' , 'pa.productId = pb.product_id','left');
    $this->db->join(PRODUCT.' as p' , 'p.id = pb.product_id');
    $this->db->join(RENTALENQUIRY.' as rq' , 'p.id = rq.prd_id');
    $this->db->join(USERS.' as u' , 'u.id = rq.user_id');
    $this->db->where('p.user_id = '.$id);
    $this->db->where('rq.renter_id = '.$id);
    $this->db->where('rq.booking_status != "Enquiry"');
    $this->db->group_by('rq.id');
    $this->db->order_by('rq.dateAdded','desc');
    $reservationDetails = $this->db->get();
    $my_reservation =array();
    $payment_status = "";
    $approval_status = "";  
    if($reservationDetails->num_rows()>0){
      foreach($reservationDetails->result() as $trip)
      {
      $paymentstatus = $this->mobile_model->get_all_details(PAYMENT,array('Enquiryid'=>$trip->EnqId));
      $chkval = $paymentstatus->num_rows();
      if($chkval==1) { 
        $payment_status = "Paid";
      }else {
        $payment_status = "Pending";
      }
      if($trip->approval=='Pending') {
        $approval_status = "Approval Pending";
      }else {
        if($trip->approval == 'Accept'){
          $approval_status = "Accepted";
        } else {
          $approval_status = "Declined";
        }
      }
        if($trip->image != ''){
          if($trip->loginUserType == 'google'){
            $userImage = $trip->image;
          }elseif($trip->image == '' ){ 
            $userImage = base_url().'images/site/profile.png';
          } else { 
            $userImage = base_url().'images/users/'.$trip->image;
          }
        }else{
          $userImage = base_url().'images/site/profile.png';
        }
        
        if($trip->firstname != ''){
          $host_name = $trip->firstname;
        } else {
          $host_name ="";
        }
        if($trip->house_rules != ''){
          $house_rules = $trip->house_rules;
        } else {
          $house_rules ="None";
        }
        if($trip->checkin!='0000-00-00 00:00:00' && $res->checkout!='0000-00-00 00:00:00'){ 
          $book_date = date('M d',strtotime($trip->checkin))." - ".date('M d, Y',strtotime($trip->checkout));
        }
        $cur_date = date("Y-m-d H:i:s");
        $secDeposit = floatval($trip->secDeposit);
        $total = $trip->subTotal + $trip->secDeposit +$trip->serviceFee;
        $condition = array('currency_type'=>$trip->currency);
        $property_currency_details = $this->mobile_model->get_all_details ( CURRENCY, $condition );
        $property_currency_symbol = $property_currency_details->row()->currency_symbols;
        //paid currency details
        $conditionrq = array('currency_type'=>$trip->currencycode);
        $paid_currency_details = $this->mobile_model->get_all_details(CURRENCY, $conditionrq);
        $paid_currency_symbol = $paid_currency_details->row()->currency_symbols; 

        $my_reservation[] = array("id"=>$trip->EnqId,"property_title"=>$trip->product_title,"property_price"=>floatval($trip->price),"property_currency_code"=>$trip->currency,"property_currency_symbol"=>$property_currency_symbol,"booking_dates"=>$book_date,"checkin"=>$trip->checkin,"checkout"=>$trip->checkout,"numofdates"=>$trip->noofdates,"property_address"=>$trip->address,"country"=>$trip->country_name,"state"=>$trip->state_name,"city"=>$trip->city_name,"post_code"=>$trip->post_code,"property_id"=>$trip->product_id,"service_fee"=>floatval($trip->serviceFee),"sub_total"=>floatval($trip->subTotal),"security_deposit"=>floatval($trip->secDeposit),"NoofGuest"=>$trip->NoofGuest,"cancellation_policy"=>$trip->cancellation_policy,"house_rules"=>$house_rules,"total"=>floatval($total),"payment_status"=>$payment_status,"approval_status"=>$approval_status,"paid_currency_code"=>$trip->currencycode,"paid_currency_symbol"=>$paid_currency_symbol,"user_name"=>$host_name,"bookingno"=>$trip->Bookingno,"loginUserType"=>$trip->loginUserType,"user_image"=>$userImage);
      
      }
    }
      if($query->num_rows() == 0 && $reservationDetails->num_rows() ==0) {
      
      $productarr = array();
      $json_encode = json_encode(array("status"=>1,"message"=>"No Listing available","property_listing"=>$productarr,"my_reservation"=>$my_reservation));
      
      } else {
        $json_encode = json_encode(array("status"=>1,"message"=>"Listing available","property_listing"=>$productarr,"my_reservation"=>$my_reservation));
      }
      echo $json_encode;

  }
  /* Property details for property edit  */ 
  public function product_edit()
  {
  
    $catID = intval($this->input->post('property_id'));
    if ($catID=='')
    {
      $json_encode = json_encode(array('status'=>0,'message'=>'Parameter missing'));
    } else {
      
      $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
      $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
      
      $currencyvalueArr = array();
      if($currency_values->num_rows() >0) {

        foreach($currency_values->result() as $cur_value) {

        $currencyvalueArr[] = array("id" =>$cur_value->id,"country_symbols"=>$cur_value->currency_symbols,"currency_type"=>$cur_value->currency_type);
        }
      } 
      $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
      $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
      
      $attribute = array();
      $property = array();
      $rooms = array();
      $conditions = array('status'=>'Active','id'=>9);
      $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
      /* Property and Room Type and so on */
      if($property_space->num_rows()>0) {
        foreach($property_space->result() as $pro) {
          $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
          $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
          if($property_listvalue->num_rows()>0) {
            $propertyvalueArr = array();
            foreach($property_listvalue->result() as $prty) {
                $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
            }
            $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
          }
        }
      }
      
      $conditions = array('status'=>'Active','id'=>10);
      $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
      /* Room Type and so on */
      if($property_space->num_rows()>0) {
        foreach($property_space->result() as $pro) {
          $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
          $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
          if($room_listvalue->num_rows()>0) {
            $propertyvalueArr = array();
            foreach($room_listvalue->result() as $room) {
                $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
            }
            $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
          }
          
        }
      }
      
      /* Features of amenties,extras ,wifi and so on */
      if($parent_list_values->num_rows()>0) {
        foreach($parent_list_values->result() as $parent_value) {
          $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
          $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
          if($list_values->num_rows()>0) {
            $listvalueArr = array();
            foreach($list_values->result() as $list_value) {
              if($parent_value->id == $list_value->list_id) {
                $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
              }
            }
            $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
          } 
        }
      }
      
      $roombedVal=array();
      $roombedVal1=array();
      $select_qry = "select * from fc_listings where id=1";
      $list_values = $this->mobile_model->ExecuteQuery($select_qry);
      if($list_values->num_rows()>0){
        foreach($list_values->result() as   $list){
          $roombedVal[] =json_decode($list->listing_values);
          $roombedVal1[] =json_decode($list->rooms_bed);
        }
      }
	  
	  
	  /***********Charles 18-3-2017 Parent Name*********/
	$select_qrys = "select * from fc_listing_types where status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		   
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		  
		  
	/***********Charles 18-3-2017 Child Name*********/
	/***********Charles 2-3-2017 Child Name*********/
	$select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
	
    if($list_valuesy->num_rows()>0){
	if($listing_type=="option") {
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		  $listing_child_type = $listing_child->type;
		  $listing_child_labelname = $listing_child->labelname;
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);
	  }
	}
	
	}
	$property_attributes[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	/***********Charles 18-3-2017 Parent Name*********/
	  
	  
	  
        if($catID !="") {
          /* schedule starts here */
            $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$catID));
          $sometime_arr = array();
          if($scheduleCheck->num_rows() >0){
            foreach($scheduleCheck->result() as $sc){ 
              $json_decode = json_decode($sc->data);
              foreach($json_decode as $key=>$value){
                if($value->status=="available"){
                  $status = 1;
                }else if($value->status=="booked"){
                  $status = 2;
                }else if($value->status=="unavailable"){
                  $status = 3;
                }
                $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
              }
            } 
          }
      /* schedule ends here */
          /* Get the property details */
          $attributes=array();
          $where1 = array('p.id'=>$catID);  
          $where2 = array('product_id'=>$catID);  
          $this->db->select('p.home_type,p.id,p.accommodates,p.room_type,p.price,p.currency,p.status,p.calendar_checked,pa.address,p.description,p.product_title,p.other_thingnote,p.house_rules,p.list_name,p.listings,pa.address,pa.country,pa.state,pa.city,pa.street,pa.zip,pa.lat,pa.lang,p.cancellation_policy,p.security_deposit,p.meta_title,p.meta_keyword,p.meta_description');
          $this->db->from(PRODUCT.' as p');
          $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
          $this->db->where($where1);
          $rental_details = $this->db->get(); 
          /* Get Cancellation Policy detail starts */
          $seourl = 'cancellation-policy';
          $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
          $cancellation_policy_description  = "";
          $cancellation_policy_title        = "";
          if($pageDetails->num_rows()>0) {
            foreach($pageDetails->result() as $page){
                $cancellation_policy_description  = $page->description;
                $cancellation_policy_title        = $page->page_title;
            }
          }
          /* Get Cancellation Policy detail ends */
          /* Get the property image details */
          $photos = array();
          if($rental_details->num_rows() == 1) {
            $this->db->from(PRODUCT_PHOTOS);
            $this->db->where('product_id',$catID);
            $this->db->order_by('imgPriority','asc');
            $productImages = $this->db->get();
            if($productImages->num_rows()>0) {
              foreach($productImages->result() as $prd_Images){ 
                $photos[] =array("product_image_id"=>intval($prd_Images->id),"product_image"=>base_url().'server/php/rental/'.$prd_Images->product_image); 
              }
            }
            foreach($rental_details->result() as $rental_detail){
              if($rental_detail->listings !=""){
                $attributes[] = json_decode($rental_detail->listings);          
              }
            $step1 = array("propertyid"=>$catID,"home_type"=>$rental_detail->home_type,"room_type"=>$rental_detail->room_type,"accommodates"=>$rental_detail->accommodates,"address"=>$rental_detail->address,"status"=>$rental_detail->status);
            $calendar_status = false;
            if($rental_detail->status == 'Publish' ){
              $calendar_status = true;
            }
            $step2 = array("propertyid"=>$catID,"calendar_checked"=>$rental_detail->calendar_checked,"dateto"=>"","datefrom"=>"","calendar_status"=>$calendar_status,"seasonal_calendar_price"=>$sometime_arr);
            }
            $price ="";
            if($rental_detail->price !=0){
              $price = floatval($rental_detail->price);
            }
            $step3 = array("propertyid"=>$catID,"currency_code"=>$rental_detail->currency,"price"=>$price,"chk"=>"price");
            $step4 = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title,"property_description"=>$rental_detail->description,"other_thingnote"=>$rental_detail->other_thingnote,"house_rules"=>$rental_detail->house_rules);
            $step4_chk = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title);
            $step5 = array("propertyid"=>$catID,"product_image"=>$photos);
            $step6 = array("propertyid"=>$catID,"list_name"=>$rental_detail->list_name);
            $step7 = array("propertyid"=>$catID,"room_type"=>$rental_detail->room_type,"home_type"=>$rental_detail->home_type,"attribute"=>$attributes);
            $step8 = array("propertyid"=>$catID,"address"=>$rental_detail->address,"country"=>$rental_detail->country,"state"=>$rental_detail->state,"city"=>$rental_detail->city,"street"=>$rental_detail->street,"zip"=>$rental_detail->zip,"lat"=>$rental_detail->lat,"long"=>$rental_detail->lang);
            $step9 = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"meta_title"=>$rental_detail->meta_title,"meta_keyword"=>$rental_detail->meta_keyword,"meta_description"=>$rental_detail->meta_description,"property_currency"=>$rental_detail->currency,"cancellation_policy_title"=>$cancellation_policy_title,"cancellation_policy_description"=>$cancellation_policy_description);
            $step9_chk = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"property_currency"=>$rental_detail->currency);
            
            $step_empty1=0;
            if (in_array('', $step1)) { $step_empty1++; }
            if($step_empty1>0){ $array1 = array("step_completed"=>false); } else { $array1 = array("step_completed"=>true); }
            $step1 = array_merge($array1, $step1); 
            
            $step22[] = $step2['calendar_checked'];
            $step_empty2=0;
            if (in_array('',$step22)) { $step_empty2++; }
            if($step_empty2>0){ $array2 = array("step_completed"=>false); } else { $array2 = array("step_completed"=>true); }
            $step2 = array_merge($array2, $step2); 
            
            $step_empty3=0;
            if (in_array('', $step3)) { $step_empty3++; }
            if($step_empty3>0){ $array3 = array("step_completed"=>false); } else { $array3 = array("step_completed"=>true); }
            $step3 = array_merge($array3, $step3); 
            
            $step_empty4=0;
            if (in_array('', $step4_chk)) { $step_empty4++; }
            if($step_empty4>0){ $array4 = array("step_completed"=>false); } else { $array4 = array("step_completed"=>true); }
            $step4 = array_merge($array4, $step4); 
            
            $step_empty5=0;
            if (empty($photos)) { $step_empty5++; }
            if($step_empty5>0){ $array5 = array("step_completed"=>false); } else { $array5 = array("step_completed"=>true); }
            $step5 = array_merge($array5, $step5); 
            
            
            $step_empty6=0;
            if (in_array('', $step6)) { $step_empty6++; }
            if($step_empty6>0){ $array6 = array("step_completed"=>false); } else { $array6 = array("step_completed"=>true); }
            $step6 = array_merge($array6, $step6); 
            
            $step_empty7=0;
            if (empty($attributes)) { $step_empty7++; }
            //if (in_array('', $step7)) { $step_empty7++; }
            if($step_empty7>0){ $array7 = array("step_completed"=>false); } else { $array7 = array("step_completed"=>true); }
            $step7 = array_merge($array7, $step7); 
            
            $step_empty8=0;
            if (in_array('', $step8)) { $step_empty8++; }
            if($step_empty8>0){ $array8 = array("step_completed"=>false); } else { $array8 = array("step_completed"=>true); }
            $step8 = array_merge($array8, $step8); 
            
            $step_empty9=0;
            if (in_array('', $step9_chk)) { $step_empty9++; }
            if($step_empty9>0){ $array9 = array("step_completed"=>false); } else { $array9 = array("step_completed"=>true); }
            $step9 = array_merge($array9, $step9); 
            
            
            $result_arr[] = array("step1"=>$step1,"step2"=>$step2,"step3"=>$step3,"step4"=>$step4,"step5"=>$step5,"step6"=>$step6,"step7"=>$step7,"step8"=>$step8,"step9"=>$step9);
            
            $json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$catID,"result"=>$result_arr,"property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"property_attributes" => $property_attributes,"currency" =>$currencyvalueArr));
          } else {
            $json_encode = json_encode(array('status'=>0,'message'=>'No data found',"propertyid"=>"")); 
          }
        }   
    }
    echo $json_encode;
  }
  
  
  
  /** 
   * 
   * Loading Category Json Page
   */
   
   //wish list 
   
  public function mobile_wishlist() {
  
    $wishcatname = $_POST['wishlist_title'];
    $product_id =$_POST['property_id'];
    $userid = $_POST['userid'];
    $wishuser_id = $userid;
    $condition = array('user_id'=>$wishuser_id,'product_id'=>$product_id);
    $check = $this->mobile_model->get_all_details(LISTS_DETAILS,$condition);
    
    if($check->num_rows() == 0) {
      $data = $this->mobile_model->add_wishlist_category ( array (
          'user_id' => $wishuser_id,
          'name' => ucfirst ( $wishcatname ),
          'product_id'=>$product_id

      ) );
      $newdata = array('fav'=>1);
      $condition = array('id'=>$product_id);
      $this->mobile_model->update_details ( PRODUCT, $newdata, $condition );
      $res = 'successfully wishlist added';
      $json_encode = json_encode(array("status"=>1,"message"=>$res));
    }else{
      $this->db->where('user_id', $wishuser_id);
      $this->db->where('product_id', $product_id);
      $this->db->delete(LISTS_DETAILS);
      $newdata = array('fav'=>0);
      $condition = array('id'=>$product_id);
      $this->mobile_model->update_details ( PRODUCT, $newdata, $condition );    
      $res = 'successfully wishlist removed';
      $json_encode = json_encode(array("status"=>0,"message"=>$res));
    }
    echo $json_encode;    
  }
  public function mobile_setcurrency(){
    $currencytype = $_GET['currency_code'];
    $email = $_GET['email'];
    if($_GET['currency_code'] != '' && $_GET['email'] != '') {
    $condition1 = array("email"=>$email);
    $view = $this->mobile_model->get_all_details(USERS,$condition1);
    $euser_id = $view->row()->id;
    
    $newdata = array('user_currency'=>$currencytype);
    $condition = array('id'=>$euser_id);
    $this->mobile_model->update_details ( USERS, $newdata, $condition );
    $res = 'successful';
    $json_encode = json_encode(array("status"=>$res));
    }else{
    $res = 'failed';
    $json_encode = json_encode(array("status"=>$res));
    }
    echo $json_encode;
  }
  public function mobile_wishlistview() {
    $user_id = $_POST['userid'];
    if($user_id =="") {
      $json_encode = json_encode(array("status"=>0,"message"=>"Parameter Missing!"));
      echo $json_encode;
      exit;
    } else{
      $condition1 = array("id"=>$user_id);
      $userDetails = $this->mobile_model->get_all_details(USERS,$condition1); 
      $WishListCat = $this->mobile_model->get_list_details_wishlist($user_id);
      // echo $this->db->last_query();die;
      $wishlist = array();
      if($WishListCat->num_rows() > 0){
        foreach($WishListCat->result() as $wlist){
            $product = array();
            $img = "";
          if($wlist->product_id !=''){
            $products=explode(',',$wlist->product_id);
            $productsNotEmy=array_filter($products);
            $CountProduct1=count($productsNotEmy);
            if($CountProduct1 > 0){
              $CountProduct = $this->mobile_model->get_all_details(PRODUCT,array('id'=>end($productsNotEmy)))->num_rows(); 
            }
            $img = "";
            if($CountProduct > 0){ 
              $ProductsImg = $this->mobile_model->get_all_details(PRODUCT_PHOTOS,array('product_id'=>end($productsNotEmy))); 
              if($ProductsImg->row()->product_image!=''){
                $img = base_url().PRODUCTPATH.$ProductsImg->row()->product_image;
              }else{
                $img = base_url().'images/product/dummyProductImage.jpg';
              }
            } else {
              $img = base_url().'images/site/empty-wishlist.jpg';
            }
            
            if (count ( $productsNotEmy ) > 0) {
              $product_details = $this->mobile_model->get_product_details_wishlist_one_category ( $productsNotEmy );
              
              if(count($product_details)>0) {
                $product = array();
                foreach($product_details->result() as $p) {
                  $wishlist_image  = $this->mobile_model->get_wishlistphoto ( $p->id );
                  $wish_img = array();
                  if(count($wishlist_image)>0) {
                    foreach($wishlist_image->result() as $product_image) {
                      $prd_img  ="";
                      if($product_image->product_image !=""){
                        if(strpos($product_image->product_image, 's3.amazonaws.com') > 1) {
                        $prd_img = $product_image->product_image;
                        } else  {
                          $prd_img = base_url()."server/php/rental/".$product_image->product_image;
                        }
                      }
                      $wish_img[] = array("property_image"=>$prd_img);
                    }
                  }
                  $condition = array('currency_type'=>$p->currency);
                  $property_currency_details = $this->mobile_model->get_all_details ( CURRENCY, $condition );
                  $property_currency_symbol = $property_currency_details->row()->currency_symbols;
                  if($userDetails->row()->image !=''){
                    $user_img = base_url().'images/users/'.$userDetails->row()->image;
                  }else{
                    $user_img = base_url().'images/users/user-thumb.png';
                  }
				  $select_prd = "select user_id from fc_product where id='".$p->id."'";
				  $prd_ty = $this->mobile_model->ExecuteQuery($select_prd);
				  foreach($prd_ty->result() as $RW)
				  {
					  $hostId = $RW->user_id;
					  //echo $hostId;
				  }
                  
                  $product[] = array("property_id"=>intval($p->id),"property_title"=>
                  $p->product_title,"property_address"=>$p->address,"bedrooms"=>$p->bedrooms,"bathrooms"=>$p->bathrooms,"room_type"=>$p->room_type,"notes_id"=>intval($p->nid),"notes_desc"=>strip_tags($p->notes),"property_price"=>floatval($p->price),"property_currency_code"=>$p->currency,"property_currency_symbol"=>$property_currency_symbol,"host_id"=>intval($hostId),"user_image"=>$user_img,"property_images"=>$wish_img);
                }
              }
            }
          }
          $wishlist[] = array("wishlist_id"=>intval($wlist->id),"wishlist_title"=>$wlist->name,"wishlist_image"=>$img,"property_details"=>$product);     
                
        }
        $json_encode = json_encode(array("status"=>1,"message"=>"Successfully Wishlist Removed!","wishlist"=>$wishlist));
        echo $json_encode;
        exit;
      } else {
        $json_encode = json_encode(array("status"=>1,"message"=>"Not Available!","wishlist"=>$wishlist));
        echo $json_encode;
        exit;
      }
    }
  } 
  
  public function mobile_yourtrips() {
    $email = $_GET['email'];
    $condition = array("email"=>$email);
    $view = $this->mobile_model->get_all_details(USERS,$condition);
    $user_id = $view->row()->id;
    //$user_id= 75;
    if($_GET['email'] != ''){
    $this->db->select('pb.*,pa.post_code,pa.address,pa.apt,pp.product_image,
                c.name as country_name,
                s.name as state_name,
                ci.name as city_name,
                p.product_name,p.product_title,p.price,p.currency,
                u.firstname,u.image,
                rq.booking_status,rq.checkin,rq.checkout,rq.dateAdded,rq.user_id as GestId,rq.renter_id,rq.serviceFee,rq.totalAmt,rq.approval as approval,rq.id as cid');
      $this->db->from(PRODUCT_BOOKING.' as pb');
      $this->db->join(PRODUCT_ADDRESS.' as pa' , 'pa.product_id = pb.product_id','left');
      $this->db->join(LOCATIONS.' as c' , 'c.id = pa.country','left');
      $this->db->join(STATE_TAX.' as s' , 's.id = pa.state','left');
      $this->db->join(CITY.' as ci' , 'ci.id = pa.city','left');
      $this->db->join(PRODUCT.' as p' , 'p.id = pb.product_id','left');
      $this->db->join(PRODUCT_PHOTOS.' as pp' , 'p.id = pp.product_id','left');
      $this->db->join(RENTALENQUIRY.' as rq' , 'p.id = rq.prd_id');
      
      $this->db->join(USERS.' as u' , 'u.id = rq.renter_id');
      $this->db->where('rq.user_id = '.$user_id);
      $this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
      $this->db->where('rq.booking_status != "Enquiry"');
      $this->db->group_by('rq.id');
      $this->db->order_by('rq.dateAdded');
      $tripresult = $this->db->get();
      foreach($tripresult->result() as $trip){
      if($trip->product_image !=''){
      $p_img = explode('.',$trip->product_image); 

      $suffix = strrchr($trip->product_image, "."); 
      $pos = strpos  ( $trip->product_image  , $suffix); 
      $name = substr_replace ($trip->product_image, "", $pos); 
     // echo $suffix . "<br><br>". $name;

      $pro_img = $name.''.$suffix; 
      
      $proImage = $pro_img;
      }else{
        $proImage = 'no_image.jpg';
      }
        $res[] =array("product_title"=>$trip->product_title,"image"=>'no_image.jpg');
      }
      if($tripresult->num_rows()==0) {
        $res=array();
        $json_encode = json_encode(array("status"=>$res));
      }else{
        $json_encode = json_encode(array("status"=>$res));
      }
      }else{
        $res=array();
        $json_encode = json_encode(array("status"=>$res));
      }
      echo $json_encode;    
  }
  public function mobile_psdchange(){
    
    $email = $_POST['email'];
    $current_pass = md5 ( $_POST['currentpsd'] );
    $newpsd = $_POST['newpsd'];
    $condition = array (
          'email' => $email,
          'password' => $current_pass 
      );
      $checkuser = $this->mobile_model->get_all_details ( USERS, $condition );
      if ($checkuser->num_rows () == 1) {
        $newPass = md5 ( $newpsd );
        $newdata = array (
            'password' => $newPass 
        );
        $condition1 = array (
            'email' => $email 
        );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
         $res = 'Password changed successfully';
      } else {
        $res = 'Current password is wrong';
      }
      $json_encode = json_encode(array("status"=>$res));
      echo $json_encode;
      
  }
  /* Room Type Sub values */
  public function mobile_roomtype() {
    $condition = array('listspace_id'=>9,'other'=>'Yes');
    $listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $condition );
    foreach($listvalue->result() as $list){
    $propertytype[] = array('room_title'=>$list->list_value,'room_type_id'=>$list->id,'room_type_mainid'=>$list->listspace_id);
    }
    $json_encode = json_encode(array('room_type'=>$propertytype));
    echo $json_encode;
  }
  /*  Property type values */
  public function mobile_listspacetype() {
    $condition = array('listspace_id'=>10,'other'=>'yes');
    $listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $condition );
    foreach($listvalue->result() as $list){
    $propertytype[] = array('property_title'=>$list->list_value,'propertytype_id'=>$list->id,'propertytype_mainid'=>$list->listspace_id);
    }
    $json_encode = json_encode(array('property_type'=>$propertytype));
    echo $json_encode;
  }
  
  public function mobile_update_account() {
    //echo '<pre>';print_r($_POST);die;
    //$email = $_GET['Email'];
    $user_id = $_POST['userid'];
    $condition = array("id"=>$user_id);
    $view = $this->mobile_model->get_all_details(USERS,$condition);
    //$user_id = $view->row()->id;
    $detail=array();
    $notify=array();
    $payout=array();
    $privacy=array();
    $comp_trans=array();
    $fut_trans=array();
    $country_list=array();
    if ($view->num_rows() == 1) {
      if($_POST['u_first_name'] != '') {
        
        $firstname = $_POST['u_first_name'];
        $newdata = array ('firstname' => $firstname,'user_name'=>$firstname);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      
      if($_POST['u_last_name'] != '') {
        
        $lastname = $_POST['u_last_name'];
        $newdata = array ('lastname' => $lastname);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      
      if($_POST['u_gender'] != '') {
      
        $gender = $_POST['u_gender'];
        $newdata = array ('gender' => $gender);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
        // echo $this->db->last_query();die;
      }

      if($_POST['u_birth'] != '') {
        $dob = explode("/",$_POST['u_birth']);
        
        $newdata = array ('dob_date' => $dob[0],"dob_month"=>$dob[1],"dob_year"=>$dob[2]);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      //  echo $this->db->last_query();die;
      }
      if($_POST['u_phone'] != '') {
        
        $phone_no = $_POST['u_phone'];
        $newdata = array ('phone_no' => $phone_no);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_FILES['photo1'] != '') {
      
            $uploaddir = "images/users/";
            $data = file_get_contents($_FILES['photo1']['tmp_name']);
            $image = imagecreatefromstring( $data );
            $imgname=time().".jpg";
            imagejpeg($image,$uploaddir.$imgname, 99);
        $newdata = array ('image' => $imgname);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      
      if($_POST['u_live'] != '') {
        $live = $_POST['u_live'];
        $newdata = array ('address' => $live);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }

      if($_POST['u_about'] != '') {
      
        $describe = $_POST['u_about'];
        $newdata = array ('description' => $describe);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      
      if($_POST['school'] != '') {
        $school = $_POST['school'];
        $newdata = array ('school' => $school);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }

      if($_POST['work'] != '') {
        $work = $_POST['work'];
        $newdata = array ('work' => $work);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }

      if($_POST['language'] != '') {
      
        $newdata = array ('languages_known' => $language);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['email_id_verified'] != '' && $_POST['email_id_verified'] =='Yes'){
        $id_verified ="Yes";
        $newdata = array ('id_verified' => $id_verified);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['phone_verified'] != '' && $_POST['phone_verified'] =='Yes') {
        $id_verified ="Yes";
        $newdata = array ('ph_verified' => $id_verified);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['email_notifications'] != '') {
        $email_notifications =$_POST['email_notifications'];
        $newdata = array ('email_notifications' => $email_notifications);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['notifications'] != '') {
        $notifications =$_POST['notifications'];
        $newdata = array ('notifications' => $notifications);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['accname'] != '' && $_POST['accno'] != '' && $_POST['bankname'] != '') {
        $newdata = array ('accname' => $_POST['accname'],'accno' => $_POST['accno'],  'bankname' => $_POST['bankname']);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['social_recommend'] != '') {
        if($_POST['social_recommend'] =='true' || $_POST['social_recommend']=='false') {
          if($_POST['social_recommend'] =='true') {
            $social ='yes';
          } else if($_POST['social_recommend'] =='false') {
            $social ='no';
          }
          $newdata = array ('social_recommend' => $social );
          $condition1 = array ('id' => $user_id );
          $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
        }
      }
      if($_POST['search_by_profile'] != '') {
        if($_POST['search_by_profile'] =='true' || $_POST['search_by_profile']=='false') {
          if($_POST['search_by_profile'] =='true') {
            $search_by_profile ='yes';
          } else if($_POST['search_by_profile'] =='false') {
            $search_by_profile ='no';
          }
          $newdata = array ('search_by_profile' => $search_by_profile);
          $condition1 = array ('id' => $user_id );
          $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
        }
      }
      if($_POST['country'] != '') {
          $newdata = array ('country' => $_POST['country'],'ph_country' => $_POST['country']);
          $condition1 = array ('id' => $user_id );
          $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
    
      $user_id = $_POST['userid'];
      $condition = array("id"=>$user_id);
      $view = $this->mobile_model->get_all_details(USERS,$condition);
      //echo '<pre>';print_r($view->row());die;
      
      if($view->row()->image != '') {
        $img = base_url().'images/users/'.$view->row()->image;
      }else{
        $img = base_url().'images/site/profile.png';
      }
      if($view->row()->gender != 'Unspecified') {
        $gender = $view->row()->gender;
      }else{
        $gender = '';
      }
      if($view->row()->dob_date != 0) {
        $date = $view->row()->dob_date."-";
      }else{
        $date = '';
      }
      if($view->row()->dob_month != 0) {
        $month = $view->row()->dob_month."-";
      }else{
        $month = '';
      }
      if($view->row()->dob_year != 0) {
        $year = $view->row()->dob_year;
      }else{
        $year = '';
      }
      
      if($view->row()->ph_verified != "") {
        if($view->row()->ph_verified =="Yes"){
          $phone_verified = true;
        } else if($view->row()->ph_verified =="No"){
          $phone_verified = false;
        } else {
          $phone_verified = '';
        }
        
      }else{
        $phone_verified = '';
      }
      if($view->row()->id_verified != "") {
        if($view->row()->id_verified =="Yes"){
          $email_id_verified = true;
        } else if($view->row()->id_verified =="No"){
          $email_id_verified = false;
        } else {
          $email_id_verified = '';
        }
      }else{
        $email_id_verified = '';
      }
      if($view->row()->email_notifications != "") {
        $email_notifications = $view->row()->email_notifications;
      }else{
        $email_notifications = '';
      }
      if($view->row()->notifications != "") {
        $notifications = $view->row()->notifications;
      }else{
        $notifications = '';
      }
      if($view->row()->accname != "") {
        $accname = $view->row()->accname;
      }else{
        $accname = '';
      }
      if($view->row()->accno != "") {
        $accno = $view->row()->accno;
      }else{
        $accno = '';
      }
      if($view->row()->bankname != "") {
        $bankname = $view->row()->bankname;
      }else{
        $bankname = '';
      }
      if($view->row()->social_recommend != "") {
        if($view->row()->social_recommend =='yes') {
          $social_recommend =true;
        } else if($view->row()->social_recommend =='no') {
          $social_recommend =false;
        } else {
          $social_recommend = '';
        }
      
      }else{
        $social_recommend = '';
      }
      if($view->row()->search_by_profile != "") {
        if($view->row()->search_by_profile =='yes') {
          $search_by_profile =true;
        } else if($view->row()->search_by_profile =='no') {
          $search_by_profile =false;
        } else {
          $search_by_profile = '';
        }
        
      }else{
        $search_by_profile = '';
      }
      
      if($view->row()->country != "") {
        $country = $view->row()->country;
      }else{
        $country = '';
      }
      $payout[] = array("accname"=>$accname,"accno"=>$accno,"bankname"=>$bankname);
      $notify[] = array("reservation_request"=>$notifications,"email_notifications"=>$email_notifications);
      $privacy[] = array("search_by_profile"=>$search_by_profile,"social_recommend"=>$social_recommend);
      
      $detail[] = array("firstname"=>$view->row()->firstname,"lastname"=>$view->row()->lastname,"email"=>$view->row()->email,"phone"=>$view->row()->phone_no,"gender"=>$gender,"dob"=>$date.$month.$year,"live"=>$view->row()->address,"describe"=>$view->row()->description,"school"=>$view->row()->school,"work"=>$view->row()->work,"language"=>$view->row()->language,"image"=>$img,"country"=>intval($country),"phone_verified"=>$phone_verified,"email_id_verified"=>$email_id_verified);
      
      /* Country List starts here */
      $country_list = array();
      $country_query='SELECT id,name FROM '.LOCATIONS.' WHERE status="Active" order by name';
      $active_countries = $this->mobile_model->ExecuteQuery($country_query);
      if($active_countries->num_rows() >0) {
        foreach($active_countries->result() as $cntry) {
          $country_list[] = array("id"=>intval($cntry->id),"country_name"=>$cntry->name);
        }
      } 
      /*  Country List ends here */
      
      /* Transaction History starts here */
      $emailQry = $this->mobile_model->get_all_details(USERS, array('id' => $user_id));
      $email = $emailQry->row()->email;
      $future_transaction = $this->mobile_model->get_future_transaction($email);
      $completed_transaction = $this->mobile_model->get_completed_transaction($email);
      $fut_trans = array();
      $comp_trans = array();
      if($completed_transaction->num_rows() >0) {
        foreach($completed_transaction->result() as $comp) {
          $comp_trans[] = array("dateadded"=>date('M d, Y',strtotime($comp->dateAdded)),"transaction_method"=>"Via Bank","transaction_id"=>$comp->transaction_id,"amount"=>floatval($comp->amount),"currency_code"=>"USD","currency_symbol"=>"$");
        }
      }
      if($future_transaction->num_rows() >0) {
        foreach($future_transaction->result() as $fut) {
          $fut_trans[] = array("dateadded"=>date('M d, Y',strtotime($fut->dateAdded)),"firstname"=>$fut->firstname,"property_title"=>$fut->product_title,"property_price"=>floatval($fut->price),"bookingno"=>$fut->Bookingno,"totalAmt"=>floatval($fut->totalAmt),"service_fee"=>floatval($fut->guest_fee),"host_fee"=>floatval($fut->host_fee),"payable_amount"=>floatval($fut->payable_amount),"currency_code"=>"USD","currency_symbol"=>"$");
        }
      }
      //$user_transaction = array("completed_transaction"=>$comp_trans,"future_transaction"=>$fut_trans);
      /* Transaction History starts here */
    
    
    
      $json_encode = json_encode(array("status"=>1,"message"=>"Successfully Updated","accountinfo"=>$detail,"notifications"=>$notify,"payout_perference"=>$payout,"privacy"=>$privacy,"completed_transaction"=>$comp_trans,"future_transaction"=>$fut_trans,"country_list"=>$country_list));
      
      
    } else {
      $json_encode = json_encode(array("status"=>0,"message"=>'Failed',"accountinfo"=>$detail,"notifications"=>$notify,"payout_perference"=>$payout,"privacy"=>$privacy,"completed_transaction"=>$comp_trans,"future_transaction"=>$fut_trans,"country_list"=>$country_list));
    }
    echo $json_encode;
  
  }
  
  
  public function mobile_updateprofile() {
    //echo '<pre>';print_r($_POST);die;
    //$email = $_GET['Email'];
    $user_id = $_POST['userid'];
    $condition = array("id"=>$user_id);
    $view = $this->mobile_model->get_all_details(USERS,$condition);
    //$user_id = $view->row()->id;
    $detail=array();
    $notify=array();
    $payout=array();
    $privacy=array();
    $trust= array();
    $country_list = array();
    $rev_abt_you = array();
    $rev_by_you = array();
    $Dis_abt_you = array();
    $Dis_by_you = array();
    if ($view->num_rows() == 1) {
      if($_POST['photo1'] != '') {
        $base64_string = $_POST['photo1'];
            $imgname= time().".jpg";
            $ifp = fopen( "images/users/".$imgname, "wb" ); 
            fwrite( $ifp, base64_decode( $base64_string) ); 
            fclose( $ifp ); 
            //echo $output_file;
            //echo base64_decode($base64_string);
            /*
            $uploaddir = "images/users/";
            $data = file_get_contents($_FILES['photo1']['tmp_name']);
            $image = imagecreatefromstring( $data );
            $imgname=time().".jpg";
            imagejpeg($image,$uploaddir.$imgname, 99);
            */
        $newdata = array ('image' => $imgname);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      
      if($_POST['u_first_name'] != '') {
        
        $firstname = $_POST['u_first_name'];
        $newdata = array ('firstname' => $firstname,'user_name'=>$firstname);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      
      if($_POST['u_last_name'] != '') {
        
        $lastname = $_POST['u_last_name'];
        $newdata = array ('lastname' => $lastname);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      
      if($_POST['u_gender'] != '') {
      
        $gender = $_POST['u_gender'];
        $newdata = array ('gender' => $gender);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
        // echo $this->db->last_query();die;
      }

      if($_POST['u_birth'] != '') {
        $dob = explode("/",$_POST['u_birth']);
        
        $newdata = array ('dob_date' => $dob[0],"dob_month"=>$dob[1],"dob_year"=>$dob[2]);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      //  echo $this->db->last_query();die;
      }
      if($_POST['u_phone'] != '') {
        
        $phone_no = $_POST['u_phone'];
        $newdata = array ('phone_no' => $phone_no);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      /*  if($_FILES['photo1'] != '') {
      
            $uploaddir = "images/users/";
            $data = file_get_contents($_FILES['photo1']['tmp_name']);
            $image = imagecreatefromstring( $data );
            $imgname=time().".jpg";
            imagejpeg($image,$uploaddir.$imgname, 99);
        $newdata = array ('image' => $imgname);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      */
      
      if($_POST['u_live'] != '') {
        $live = $_POST['u_live'];
        $newdata = array ('address' => $live);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }

      if($_POST['u_about'] != '') {
      
        $describe = $_POST['u_about'];
        $newdata = array ('description' => $describe);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      
      if($_POST['school'] != '') {
        $school = $_POST['school'];
        $newdata = array ('school' => $school);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }

      if($_POST['work'] != '') {
        $work = $_POST['work'];
        $newdata = array ('work' => $work);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }

      if($_POST['language'] != '') {
      
        $newdata = array ('languages_known' => $language);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['email_id_verified'] != '' && (($_POST['email_id_verified'] =='true') || ($_POST['email_id_verified'] =='false'))){
        if($_POST['email_id_verified'] =='true'){
          $id_verified ="Yes";  
        } else if($_POST['email_id_verified'] =='false'){
          $id_verified ="No"; 
        } else {
          $id_verified ="";
        }
        
        $newdata = array ('id_verified' => $id_verified);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['phone_verified'] != '' && (($_POST['phone_verified'] =='true') ||($_POST['phone_verified'] =='false'))) {
        if($_POST['phone_verified'] =='true'){
          $id_verified ="Yes";  
        } else if($_POST['phone_verified'] =='false'){
          $id_verified ="No"; 
        }else { 
          $id_verified =""; 
        }
        
        $newdata = array ('ph_verified' => $id_verified);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['email_notifications'] != '') {
        $email_notifications =$_POST['email_notifications'];
        $newdata = array ('email_notifications' => $email_notifications);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['notifications'] != '') {
        $notifications =$_POST['notifications'];
        $newdata = array ('notifications' => $notifications);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['accname'] != '' && $_POST['accno'] != '' && $_POST['bankname'] != '') {
        $newdata = array ('accname' => $_POST['accname'],'accno' => $_POST['accno'],  'bankname' => $_POST['bankname']);
        $condition1 = array ('id' => $user_id );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
      if($_POST['social_recommend'] != '') {
        if($_POST['social_recommend'] =='yes' || $_POST['social_recommend']=='no') {
          $newdata = array ('social_recommend' => $_POST['social_recommend'] );
          $condition1 = array ('id' => $user_id );
          $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
        }
      }
      if($_POST['search_by_profile'] != '') {
        if($_POST['search_by_profile'] =='yes' || $_POST['search_by_profile']=='no') {
          $newdata = array ('search_by_profile' => $_POST['search_by_profile']);
          $condition1 = array ('id' => $user_id );
          $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
        }
      }
      if($_POST['country'] != '') {
          $newdata = array ('country' => $_POST['country']);
          $condition1 = array ('id' => $user_id );
          $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
      }
    
      $user_id = $_POST['userid'];
      $condition = array("id"=>$user_id);
      $view = $this->mobile_model->get_all_details(USERS,$condition);
      //echo '<pre>';print_r($view->row());die;
      
      if($view->row()->image != '') {
        $img = base_url().'images/users/'.$view->row()->image;
      }else{
        $img = base_url().'images/site/profile.png';
      }
      if($view->row()->gender != 'Unspecified') {
        $gender = $view->row()->gender;
      }else{
        $gender = '';
      }
      if($view->row()->dob_date != 0) {
        $date = $view->row()->dob_date."-";
      }else{
        $date = '';
      }
      if($view->row()->dob_month != 0) {
        $month = $view->row()->dob_month."-";
      }else{
        $month = '';
      }
      if($view->row()->dob_year != 0) {
        $year = $view->row()->dob_year;
      }else{
        $year = '';
      }
      
      if($view->row()->ph_verified != "") {
        if($view->row()->ph_verified =="Yes"){
          $phone_verified = true;
        } else if($view->row()->ph_verified =="No"){
          $phone_verified = false;
        } else {
          $phone_verified = '';
        }
        
      }else{
        $phone_verified = '';
      }
      if($view->row()->id_verified != "") {
        if($view->row()->id_verified =="Yes"){
          $email_id_verified = true;
        } else if($view->row()->id_verified =="No"){
          $email_id_verified = false;
        } else {
          $email_id_verified = '';
        }
      }else{
        $email_id_verified = '';
      }
      if($view->row()->email_notifications != "") {
        $email_notifications = $view->row()->email_notifications;
      }else{
        $email_notifications = '';
      }
      if($view->row()->notifications != "") {
        $notifications = $view->row()->notifications;
      }else{
        $notifications = '';
      }
      if($view->row()->accname != "") {
        $accname = $view->row()->accname;
      }else{
        $accname = '';
      }
      if($view->row()->accno != "") {
        $accno = $view->row()->accno;
      }else{
        $accno = '';
      }
      if($view->row()->bankname != "") {
        $bankname = $view->row()->bankname;
      }else{
        $bankname = '';
      }
      if($view->row()->social_recommend != "") {
        if($view->row()->social_recommend =='yes') {
          $social_recommend =true;
        } else if($view->row()->social_recommend =='no') {
          $social_recommend =false;
        } else {
          $social_recommend = '';
        }
      
      }else{
        $social_recommend = '';
      }
      if($view->row()->search_by_profile != "") {
        if($view->row()->search_by_profile =='yes') {
          $search_by_profile =true;
        } else if($view->row()->search_by_profile =='no') {
          $search_by_profile =false;
        } else {
          $search_by_profile = '';
        }
        
      }else{
        $search_by_profile = '';
      }
      if($view->row()->twitter != "") {
        if($view->row()->twitter =='Yes') {
          $linkedin_connect =true;
        } else if($view->row()->twitter =='No') {
          $linkedin_connect =false;
        } else {
          $linkedin_connect = '';
        }
        
      }else{
        $linkedin_connect = '';
      }
      if($view->row()->google != "") {
        if($view->row()->google =='Yes') {
          $google_connect =true;
        } else if($view->row()->google =='No') {
          $google_connect =false;
        } else {
          $google_connect = '';
        }
        
      }else{
        $google_connect = '';
      }
      if($view->row()->facebook != "") {
        if($view->row()->facebook =='Yes') {
          $facebook_connect =true;
        } else if($view->row()->facebook =='No') {
          $facebook_connect =false;
        } else {
          $facebook_connect = '';
        }
        
      }else{
        $facebook_connect = '';
      }
      if($view->row()->country != "") {
        $country = $view->row()->country;
      }else{
        $country = '';
      }
      $payout[] = array("accname"=>$accname,"accno"=>$accno,"bankname"=>$bankname);
      $notify[] = array("reservation_request"=>$notifications,"email_notifications"=>$email_notifications);
      $privacy[] = array("search_by_profile"=>$search_by_profile,"social_recommend"=>$social_recommend);
      $trust[] = array("phone_verified"=>$phone_verified,"email_id_verified"=>$email_id_verified,"country"=>intval($country),"phone"=>$view->row()->phone_no,"linkedin_connect"=>$linkedin_connect,"facebook_connect"=>$facebook_connect,"google_connect"=>$google_connect);
      
      $detail[] = array("id"=>intval($view->row()->id),"firstname"=>$view->row()->firstname,"lastname"=>$view->row()->lastname,"email"=>$view->row()->email,"phone_no"=>$view->row()->phone_no,"gender"=>$gender,"dob"=>$date.$month.$year,"live"=>$view->row()->address,"describe"=>$view->row()->description,"school"=>$view->row()->school,"work"=>$view->row()->work,"language"=>$view->row()->language,"country"=>intval($country),"search_by_profile"=>$search_by_profile,"social_recommend"=>$social_recommend,"accname"=>$accname,"accno"=>$accno,"bankname"=>$bankname,"notifications"=>$notifications,"email_notifications"=>$email_notifications,"user_image"=>$img,"where_you_live"=>$view->row()->address,"description"=>$view->row()->description,"dob_date"=>$date,"dob_month"=>$month,"dob_year"=>$year);
      
      /* Reviews starts here */
      $Review_about_you = $this->mobile_model->get_productreview_aboutyou($user_id);
      $Review_by_you = $this->mobile_model->get_productreview_byyou($user_id);
      $rev_abt_you = array();
      $rev_by_you = array();
      if($Review_about_you->num_rows() >0) {
        foreach($Review_about_you->result() as $rau) {
          if($rau->image != ''){
            if($rau->loginUserType == 'google'){
              $userimg = $rau->image;
            } else {
              $userimg = base_url().'images/users/'.$rau->image;
            }
          }else{
            $userimg = base_url().'images/site/profile.png';
          }
          if($rau->email !=""){ $email=$rau->email;} else { $email="";}
          if($rau->review !=""){ $review=$rau->review;} else { $review="";}
          $rev_abt_you[] = array("review"=>$review,"review_email"=>$email,"star_rating"=>$rau->total_review,"user_image"=>$userimg);
        }
      }
      if($Review_by_you->num_rows() >0) {
        foreach($Review_by_you->result() as $rbu) {
          if($rbu->image != ''){
            if($rbu->loginUserType == 'google'){
              $userimg = $rbu->image;
            } else {
              $userimg = base_url().'images/users/'.$rbu->image;
            }
            
          }else{
            $userimg = base_url().'images/site/profile.png';
          }
          if($rbu->email !=""){ $email=$rbu->email;} else { $email="";}
          if($rbu->review !=""){ $review=$rbu->review;} else { $review="";}
          $rev_by_you[] = array("review"=>$review,"review_email"=>$email,"star_rating"=>$rbu->total_review,"user_image"=>$userimg);
        }
      }
      //$review = array('reviews_about_you'=>$rev_abt_you,'reviews_by_you'=>$rev_by_you);
      /* Review Ends here */
      /* Dispute starts here */
      $Dispute_about_you = $this->mobile_model->get_productdispute_aboutyou($user_id);
      $Dispute_by_you = $this->mobile_model->get_productdispute_byyou($user_id);
      $Dis_abt_you = array();
      $Dis_by_you = array();
      if($Dispute_about_you->num_rows() >0) {
        foreach($Dispute_about_you->result() as $dau) {
          if($dau->image != ''){
            if($dau->loginUserType == 'google'){
              $userimg = $dau->image;
            } else {
              $userimg = base_url().'images/users/'.$dau->image;
            }
          }else{
            $userimg = base_url().'images/site/profile.png';
          }
          $Dis_abt_you[] = array("message"=>$dau->message,"review_email"=>$dau->email,"booking_no"=>$dau->booking_no,"user_image"=>$userimg);
        }
      }
      if($Dispute_by_you->num_rows() >0) {
        foreach($Dispute_by_you->result() as $dbu) {
          if($dbu->image != ''){
            if($dbu->loginUserType == 'google'){
              $userimg = $dbu->image;
            } else {
              $userimg = base_url().'images/users/'.$dbu->image;
            }
          }else{
            $userimg = base_url().'images/site/profile.png';
          }
          $Dis_by_you[] = array("message"=>$dbu->message,"review_email"=>$dbu->email,"booking_no"=>$dbu->booking_no,"user_image"=>$userimg);
        }
      }
      //$dispute = array('dispute_about_you'=>$Dis_abt_you,'dispute_by_you'=>$Dis_by_you);
      /* Dispute starts here */
      
      /* Country List starts here */
      $country_list = array();
      $country_query='SELECT id,name FROM '.LOCATIONS.' WHERE status="Active" order by name';
      $active_countries = $this->mobile_model->ExecuteQuery($country_query);
      if($active_countries->num_rows() >0) {
        foreach($active_countries->result() as $cntry) {
          $country_list[] = array("id"=>intval($cntry->id),"country_name"=>$cntry->name);
        }
      } 
      /*  Country List ends here */
	  
	  /*  Property List starts here */ 
	  
    $rentalDetail = $this->mobile_model->get_dashboard_list ( $userid,Publish);
    $listingarr = array();
    if($rentalDetail->num_rows() >0) {
      foreach($rentalDetail->result() as $r) {
        if($r->product_image != ''){
          $p_img = explode('.',$r->product_image);  

          $suffix = strrchr($r->product_image, "."); 
          $pos = strpos  ( $r->product_image  , $suffix); 
          $name = substr_replace ($r->product_image, "", $pos); 
         // echo $suffix . "<br><br>". $name;

          $pro_img = $name.''.$suffix; 
        
          $proImage = base_url().'server/php/rental/'.$pro_img;
        }else{
          $proImage = base_url().'server/php/rental/dummyProductImage.jpg';
        }
      $listingarr[] = array("property_id"=>intval($r->id),"property_title"=>$r->product_title,"property_image"=>$proImage,'property_address'=>$r->address); 
      }
    }
    /*  Property List ends here */ 
    
      
      //$json_encode = json_encode(array("status"=>1,"message"=>"Successfully Updated","profileinfo"=>$detail,"notifications"=>$notify,"payout_perference"=>$payout,"privacy"=>$privacy,"trust_verify"=>$trust));
      $json_encode = json_encode(array("status"=>1,"message"=>"Successfully Updated","profileinfo"=>$detail,"trust_verify"=>$trust,'reviews_about_you'=>$rev_abt_you,'reviews_by_you'=>$rev_by_you,'dispute_about_you'=>$Dis_abt_you,'dispute_by_you'=>$Dis_by_you,"country_list"=>$country_list,"property_listing"=>$listingarr));
    }else{
    
      $json_encode = json_encode(array("status"=>0,"message"=>'Failed',"profileinfo"=>$detail,"trust_verify"=>$trust,'reviews_about_you'=>$rev_abt_you,'reviews_by_you'=>$rev_by_you,'dispute_about_you'=>$Dis_abt_you,'dispute_by_you'=>$Dis_by_you,"country_list"=>$country_list,"property_listing"=>$listingarr));
    }
    echo $json_encode;
  
  }
  
  
  public function mobile_chat_new() {
    $user_email = $_POST['Email'];
    $rental_id = $_POST['p_id'];
    $message = $_POST['h_msg'];
    $receiverId = $_POST['h_id'];
    $condition = array('email'=>$user_email);
    $senderDetails = $this->mobile_model->get_all_details ( USERS, $condition );
    $senderId = $senderDetails->row()->id;
    $condition = array('id'=>$receiverId);
    $receiverDetails = $this->mobile_model->get_all_details ( USERS, $condition );
    
  }
  public function mobile_chat() {
    $user_email = $_POST['Email'];
    $rental_id = $_POST['p_id'];
    $message = $_POST['h_msg'];
    $host_id = $_POST['h_id'];
    
    $condition = array('email'=>$user_email);
    $useremail = $this->mobile_model->get_all_details ( USERS, $condition );
    $user_id = $useremail->row()->id;
    
    $condition4 = array('id'=>$rental_id);
    $productdetail = $this->mobile_model->get_all_details ( PRODUCT, $condition4);
    $pro_user_id = $useremail->row()->user_id;
    
    $condition2 = array('rental_id'=>$rental_id,'sender_id'=>$user_id);
    $sender = $this->mobile_model->get_all_details ( DISCUSSION, $condition2 );
    $condition3 = array('rental_id'=>$rental_id,'receiver_id'=>$user_id,'sender_id'=>$host_id);
    $receiver = $this->mobile_model->get_all_details (DISCUSSION, $condition3 );
    if($sender->num_rows() > 0) {
    $condition1 = array('id'=>$host_id);
    $key = $this->mobile_model->get_all_details ( USERS, $condition1 );
    $mobile_key = $key->row()->mobile_key;
    $ios_key = $key->row()->ios_key;
    $conid = $sender->row()->convId;
    $data = array(
          'rental_id'=>$rental_id,
          'sender_id'=>$user_id,
          'receiver_id'=>$host_id,
          'message'=>$message,
          'convId'=>$conid,
          'posted_by'=>$_POST['h_type']
          
          );
    $this->mobile_model->simple_insert(DISCUSSION,$data);

    }elseif($receiver->num_rows() > 0){
    $condition1 = array('id'=>$host_id);
    $key = $this->mobile_model->get_all_details ( USERS, $condition1 );
    $mobile_key = $key->row()->mobile_key;
    $ios_key = $key->row()->ios_key;
    $conid = $receiver->row()->convId;
    $data = array(
          'rental_id'=>$rental_id,
          'sender_id'=>$user_id,
          'receiver_id'=>$host_id,
          'message'=>$message,
          'convId'=>$conid,
          'posted_by'=>$_POST['h_type']
          );
    $this->mobile_model->simple_insert(DISCUSSION,$data);
    
    //echo "test";die;
    }else{
    
    $condition1 = array('id'=>$host_id);
    $key = $this->mobile_model->get_all_details ( USERS, $condition1 );
    $mobile_key = $key->row()->mobile_key;
    $ios_key = $key->row()->ios_key;
    $conid = time();
    $data = array(
          'rental_id'=>$rental_id,
          'sender_id'=>$user_id,
          'receiver_id'=>$host_id,
          'message'=>$message,
          'convId'=>$conid,
          'posted_by'=>$_POST['h_type']
        );
    $this->mobile_model->simple_insert(DISCUSSION,$data);
    
    }
    
    $condition1 = array('id'=>$user_id);
    $key = $this->mobile_model->get_all_details ( USERS, $condition1 );
    if($key->row()->image !=''){
      $userImage = $key->row()->image;
    }else{
      $userImage  = 'profile.jpg';
    }
      
    $userName = $key->row()->user_name;
    $pushStatus = "";

    if($mobile_key != ''){
      if(!empty($_GET["push"])) { 
        $gcmRegID  = $mobile_key;
        $pushMessage = $message;  
        if (isset($gcmRegID) && isset($pushMessage)) {    
          $gcmRegIds = array($gcmRegID);
          $message = array("m" => $pushMessage,"k"=>'msg',"convId"=>$conid,"convName"=>$userName,"convImage"=>$userImage,"convRentalId"=>$rental_id,"convIHostId"=>$host_id); 
          $pushStatus = $this->sendPushNotificationToGCM($gcmRegIds, $message);
        }
      }
    }
    if($ios_key != ''){
      $message = array('message'=>$message);
      $this->push_notification($ios_key,$message);
    }
    $json_encode = json_encode(array('status'=>'successful'));  
    echo $json_encode;
  }
  
  function sendPushNotificationToGCM($registatoin_ids, $message) {
    //Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
    // Google Cloud Messaging GCM API Key
    define("GOOGLE_API_KEY", "AIzaSyD0VJs5nLcm0j34eHCIpP7I8iNI-yRycqo");    
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);       
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
  
  public function mobile_viewchat() {
    
    $user_email = $_GET['email'];
    $condition = array('email'=>$user_email);
    $useremail = $this->mobile_model->get_all_details ( USERS, $condition );
    $user_id = $useremail->row()->id;
    
    $this->db->select('d.message,d.receiver_id,d.sender_id,d.rental_id,d.convId,d.date_created,u.user_name,u.image,p.user_id');
    $this->db->from(DISCUSSION.' as d');
    $this->db->join(USERS.' as u' , 'u.id = d.receiver_id');
    $this->db->join(PRODUCT.' as p' , 'p.id = d.rental_id','LEFT');
    $this->db->where('d.sender_id',$user_id);
    $this->db->or_where('d.receiver_id',$user_id);
    $this->db->group_by('d.convId');
    $chat = $this->db->get();
    if($chat->num_rows() != 0) {
    foreach($chat->result() as $list)
    {
      $newChat[] = $list;
    }
    foreach($newChat as $key => $list)
    {
      $newMessages = $this->mobile_model->get_all_details(DISCUSSION, array('convId'=>$list->convId),array(array('field'=>'id','type'=>'desc')));
      $newChat[$key]->newMsg = $newMessages->row()->message;
      $newChat[$key]->newDate = $newMessages->row()->date_created;
    }
    foreach($newChat as $chatval) {
    if($chatval->image !=''){
    $img = $chatval->image;
    }else{
    $img  = 'profile.jpg';
    }
    if($user_id == $chatval->sender_id){
    $hot = $chatval->receiver_id;
    }else{
    $hot = $chatval->sender_id;
    }
    $CatArr[] = array("msg" =>$chatval->newMsg,"newMsg" =>$chatval->newMsg,"username"=>$chatval->user_name,"date"=>$chatval->newDate,"newDate"=>$chatval->newDate,"image"=>$img,'convId'=>$chatval->convId,'rental_id'=>$chatval->rental_id,'host_id'=>$hot);
    }
    }else{
    $CatArr = array();
    }
    
    $json_encode = json_encode(array("sender" => $CatArr));
    echo $json_encode;

  }
  public function mobile_detailchat() {
    
    $convId = $_GET['convId'];
    $condition = array('email'=>$_GET['email']);
    $useremail = $this->mobile_model->get_all_details ( USERS, $condition );
    $user_id = $useremail->row()->id;
    
    $this->db->select('d.message,d.sender_id,d.receiver_id,d.convId,d.posted_by,d.date_created');
    $this->db->from(DISCUSSION.' as d');
    $this->db->where('convId',$convId);
    $chat = $this->db->get();
    
    if($chat->num_rows() != 0) {
    foreach($chat->result() as $chatval) {
    if($chatval->image !=''){
    $img = $chatval->image;
    }else{
    $img  = 'profile.jpg';
    }
    $sender_id = $chatval->sender_id;
    $receiver_id = $chatval->receiver_id;
    $msgby='';
    if($user_id == $sender_id){
    //$msgby='currentuser';
    //echo $sender_id;
    $detail = $this->mobile_model->get_all_details ( USERS, array ('id' => $sender_id));
    //echo $detail->row()->email;
    }else{
    //$msgby='receiver';
    //echo $receiver_id;
    $detail = $this->mobile_model->get_all_details ( USERS, array ('id' => $sender_id ));
    //echo $detail->row()->email;die;
    }
    
     
    $CatArr[] = array("msg" =>$chatval->message,"username"=>$detail->row()->user_name,"date"=>$chatval->date_created,"image"=>$img,'convId'=>$chatval->convId,'post_by'=>$chatval->posted_by,'email'=>$detail->row()->email);
    }
    }else{
    $CatArr = array();
    }
    $json_encode = json_encode(array("sender" => $CatArr));
    echo $json_encode;
  
      
  }
  
  public function category(){
    $this->db->select('id,cat_name,image,rootID');
    $this->db->from(CATEGORY);
    $this->db->where('status','Active');
    $CategoryVal = $this->db->get();
        
    $CatArr = array();
      
    foreach($CategoryVal->result() as $catVal){
      if($catVal->image!=''){
        $catImage = $catVal->image;
      }else{
        $catImage = 'no_image.jpg';
      }
      $CatArr[] = array("id" => $catVal->id, "categoryName" => $catVal->cat_name,"image" =>'mb/'.$catImage,"catId"=>$catVal->rootID);
    }
    
    $json_encode = json_encode(array("categoryDetails" => $CatArr,"cartCount"=>(string)$this->data["cartCount"]));
    echo $json_encode;
  } 
  
  
  public function product() {
    $catid=intval($_GET['catid']);
    
    $shopname=$_GET['shopname'];
    $shopId=0;
    if($shopname!="")   {
      $shopId=intval($this->mobile_model->get_sellerId($shopname));
    }
    $this->db->select('p.id,p.product_name,p.image,p.price,p.base_price,p.user_id,p.status,s.seller_businessname,s.seller_id,a.pricing');
    $this->db->from(PRODUCT.' as p');
    $this->db->join(SELLER.' as s' , 'p.user_id = s.seller_id');
    $this->db->join(SUBPRODUCT.' as a','p.id=a.product_id','left');
    if($catid>0){
      $run = "FIND_IN_SET('".$catid."', p.category_id)";
      $this->db->where($run);
    }
    $this->db->where('p.status','Publish');
    $this->db->where('p.pay_status','Paid');
    if($shopId>0){
      $this->db->where('p.user_id',$shopId);
    }
    $this->db->group_by('p.id');
    $productList = $this->db->get();
    $ProdArr = array();
      //$ProdArr[] = array('itemCount'=>$productList->num_rows());
      $i=1;
    foreach($productList->result() as $ProdList) {
      if($i<=20){
      $img=explode(',',$ProdList->image);
      #$price= $ProdList->base_price;
      $price= number_format($this->data["currencyValue"]*$ProdList->base_price,2);
      
      
      $favStatus = $this->mobile_model->get_all_details(FAVORITE,array('p_id'=>$ProdList->id,'user_id'=>$this->data["commonId"],'favorite'=>'Yes'))->num_rows();
      if($favStatus>0){$favStatus=1;}else{$favStatus=0;}
      
      $ProdArr[] = array("productId" => $ProdList->id,
                    "productName" => character_limiter($ProdList->product_name,15),
                    "Image" => 'mb/'.$img[0],
                    "Price" => $price,
                    "currencySymbol" =>$this->data["currencySymbol"],
                    "currencyCode" =>$this->data["currencyCode"],
                    "favStatus" =>(string)$favStatus,
                    "storeName" => $ProdList->seller_businessname,
                    "itemCount"=> (string)$productList->num_rows(),
                    "pagePos"=>'1');
      $i++;
      }else{
        break;
      }
    }
    $json_encode = json_encode(array("productDetails" => $ProdArr,"cartCount"=>(string)$this->data["cartCount"]));
    echo $json_encode;
  }
  public function mobile_pay_cal(){

    $date1 = $_GET['start'];
    $date2 = $_GET['end'];

    $diff = abs(strtotime($date2) - strtotime($date1));
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
  }
  
  public function GetDays($sStartDate, $sEndDate){  
    
    $sStartDate = date("Y-m-d", strtotime($sStartDate));  
    $sEndDate = date("Y-m-d", strtotime("-1 day", strtotime($sEndDate)));  
    
    $aDays[] = $sStartDate;  
      
    $sCurrentDate = $sStartDate;
    
    while($sCurrentDate < $sEndDate){  
        $sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
      
        $aDays[] = $sCurrentDate; 
    }  
    return $aDays;  
    
    }
  
  public function mobile_price_calculation(){
    
    $productId = $_GET['P_Id'];
    $startDate = $_GET['s_date'];
    $endDate = $_GET['e_date'];
    $CalendarDateArr = $this->GetDays($startDate, $endDate);
    
    $this->data['productPriceDetails'] = $this->mobile_model->get_all_details(PRODUCT,array('id'=>$productId));
    
    $price = $this->data['productPriceDetails']->row()->price;
    
    $currency = 1;
    
    $currencySymbol = '$';
    
    if($_GET['code'] && $_GET['code'] != '')
    {
    $this->data['currencyDetails'] = $this->mobile_model->get_all_details(CURRENCY,array('currency_type'=>$_GET['code']));
    if($this->data['currencyDetails']->num_rows() == 1){
    $currency = $this->data['currencyDetails']->row()->currency_rate;
    
    $currencySymbol = $this->data['currencyDetails']->row()->currency_symbols;
    }
    }
    $price = $price*$currency;
    $jsonReturn['perNight'] = $currencySymbol.$price;
    
    foreach($CalendarDateArr as $CalendarDateRow){
      $CalendarTimeDateArr = explode(' GMT',$CalendarDateRow);
      $sadfsd=trim($CalendarTimeDateArr[0]);
      $startDate = strtotime($sadfsd);    
      $result[] =  date("Y-m-d",$startDate);
    }
    $jsonReturn['totalNights'] = count($result) > 1 ? count($result).' nights' : count($result).' night';
    $DateCalCul=0;
    $this->data['ScheduleDatePrice'] = $this->mobile_model->get_all_details(SCHEDULE,array('id'=>$productId));
    if($this->data['ScheduleDatePrice']->row()->data !=''){
      $dateArr=json_decode($this->data['ScheduleDatePrice']->row()->data);
      $finaldateArr=(array)$dateArr;
      foreach($result as $Rows){
        if (array_key_exists($Rows, $finaldateArr)) {
          $DateCalCul = $DateCalCul+$finaldateArr[$Rows]->price;
        }else{
          $DateCalCul = $DateCalCul+$price;
        };
      }
    }else{ 
      $DateCalCul = (count($result) * $price);
    }
    $jsonReturn['total'] = $currencySymbol.$DateCalCul;
    $service_tax_query='SELECT * FROM '.COMMISSION.' WHERE commission_type="Guest Booking" AND status="Active"';
    $service_tax = $this->mobile_model->ExecuteQuery($service_tax_query);
    
    if($service_tax->num_rows()==0){
      $tax = 0;
    }
    else if($service_tax->row()->promotion_type=='flat'){
      $tax = $service_tax->row()->commission_percentage*$currency;
    }
    else{
      $tax = number_format((($DateCalCul * $service_tax->row()->commission_percentage)/100)*$currency, 2);
    }
    $jsonReturn['tax'] = $currencySymbol.$tax;
    $jsonReturn['grandTotal'] = $currencySymbol.($DateCalCul+$tax);
    echo json_encode($jsonReturn);
  }
  /* Book Property for Rental */
  public function mobile_host_request(){
    $productId = $_POST['P_Id'];
    $startDate = $_POST['s_date'];
    $endDate = $_POST['e_date'];
    $guestEmail = $_POST['email'];
    $currency_code = $_POST['currency_code'];
    $message = $_POST['message'];

  if($productId =="" || $startDate =="" ||$endDate =="" ||$guestEmail =="" || $currency_code =="") {
      $jsonReturn = array("status"=>0,"message"=>"Your request has failed!");
      echo json_encode($jsonReturn);
      exit;
    }
    $this->data['guestDetails'] = $this->mobile_model->get_all_details(USERS,array('email'=>$guestEmail));
    $this->data['productPriceDetails'] = $this->mobile_model->get_all_details(PRODUCT,array('id'=>$productId));
    if($this->data['productPriceDetails']->num_rows() ==0) {
      $jsonReturn = array("status"=>0,"message"=>"Your request has failed!");
      echo json_encode($jsonReturn);
      exit;
    }
    if($this->data['guestDetails']->num_rows() ==0) {
      $jsonReturn = array("status"=>0,"message"=>"Your request has failed!");
      echo json_encode($jsonReturn);
      exit;
    }
    $userId = $this->data['guestDetails']->row()->id;
    $phone_no = $this->data['guestDetails']->row()->phone_no;
    $guests = $_POST['guests'];
    
    $CalendarDateArr = $this->GetDays($startDate, $endDate);
    
    if($this->data['productPriceDetails']->row()->currency != $currency_code)
    {
    $price = convertCurrency($this->data['productPriceDetails']->row()->currency,$currency_code,$this->data['productPriceDetails']->row()->price);
    
    $security_deposit = convertCurrency($this->data['productPriceDetails']->row()->currency,$currency_code,$this->data['productPriceDetails']->row()->security_deposit);
   }
   else{
     $price = $this->data['productPriceDetails']->row()->price;
     $security_deposit  = $this->data['productPriceDetails']->row()->security_deposit;
   }
    //$price = $this->data['productPriceDetails']->row()->price;
    
    $sellerId = $sellerId = $this->data['productPriceDetails']->row()->user_id;
    
    $currency = 1;
    
    $currencySymbol = '';
    
    $checkIn = date('Y-m-d H:i:s', strtotime($startDate));
      
    $checkOut = date('Y-m-d H:i:s', strtotime($endDate));
    
    $price = $price*$currency;
    
    foreach($CalendarDateArr as $CalendarDateRow){
      $CalendarTimeDateArr = explode(' GMT',$CalendarDateRow);
      $sadfsd=trim($CalendarTimeDateArr[0]);
      $startDate = strtotime($sadfsd);    
      $result[] =  date("Y-m-d",$startDate);
    }
    $totalNights = count($result) > 1 ? count($result).' nights' : count($result).' night';
    $DateCalCul=0;
    $this->data['ScheduleDatePrice'] = $this->mobile_model->get_all_details(SCHEDULE,array('id'=>$productId));
    if($this->data['ScheduleDatePrice']->row()->data !=''){
      $dateArr=json_decode($this->data['ScheduleDatePrice']->row()->data);
      $finaldateArr=(array)$dateArr;
      foreach($result as $Rows){
        if (array_key_exists($Rows, $finaldateArr)) {
          if($this->data['productPriceDetails']->row()->currency != $currency_code)
            {
           $price1 = convertCurrency($this->data['productPriceDetails']->row()->currency,$currency_code,$finaldateArr[$Rows]->price);
           }
           else{
             $price1 = $finaldateArr[$Rows]->price;
           }
          $DateCalCul = $DateCalCul+$price1;
        }else{
          $DateCalCul = $DateCalCul+$price;
        };
      }
    }else{ 
      $DateCalCul = (count($result) * $price);
    }
    $service_tax_query='SELECT * FROM '.COMMISSION.' WHERE commission_type="Guest Booking" AND status="Active"';
    $service_tax = $this->mobile_model->ExecuteQuery($service_tax_query);
    
    if($service_tax->num_rows()==0){
      $tax = 0;
    }
    else if($service_tax->row()->promotion_type=='flat'){
      $tax = $service_tax->row()->commission_percentage*$currency;
    }
    else{
      $tax = number_format((($DateCalCul * $service_tax->row()->commission_percentage)/100)*$currency, 2);
    }
    $grandTotal = $DateCalCul+$tax+$security_deposit;
    
    $dataArr = array(
      'user_id' => $userId,
      'prd_id' => $productId,
      'checkin' => $checkIn,
      'checkout' => $checkOut,
      'caltophone' => $phone_no,
      'NoofGuest' => $guests,
      'renter_id' => $sellerId,
      'numofdates' => $totalNights,
      'serviceFee' => $tax,
      'subTotal' => $DateCalCul,
      'totalAmt' => $grandTotal,
      'phone_no' => $phone_no,
      'currencycode' => $currency_code,
      'booking_status' => 'Pending',
      'secDeposit' => $security_deposit,
      'approval' => 'Pending'
    );
    //echo '<pre>';print_r($dataArr);die;
    $this->db->insert(RENTALENQUIRY, $dataArr); 
    
    $insertid = $this->db->insert_id ();
    
    $val = 1500000+$insertid;
    $bookingno ="EN".$val;
    
    $newdata = array ('Bookingno' => $bookingno);
    $condition = array ('id' => $insertid);
    $this->mobile_model->update_details (RENTALENQUIRY,$newdata,$condition);
    
    $message = $_POST['message'];
    $dataArr = array('productId' => $productId, 'bookingNo' => $bookingno, 'senderId' => $userId, 'receiverId' => $sellerId, 'subject' => 'Booking Request : '.$bookingno, 'message' => $message);
    
    $this->user_model->simple_insert(MED_MESSAGE, $dataArr);
    
    
    /* Mail function start */
    
    $id = $insertid;
        $this->data['bookingmail'] = $this->mobile_model->getbookeduser_detail($id);
        $currencycd = $currency_code;
    $this->data['hostdetail'] = $this->mobile_model->get_all_details(USERS,array('id'=>$this->data['bookingmail']->row()->renter_id));
    $hostemail = $this->data['hostdetail']->row()->email;
    $hostname = $this->data['hostdetail']->row()->user_name;
    
    $price = $this->data['bookingmail']->row()->price * $this->data['bookingmail']->row()->noofdates+$this->data['bookingmail']->row()->secDeposit;


    $checkindate = date('d-M-Y',strtotime($this->data['bookingmail']->row()->checkin));
    $checkoutdate = date('d-M-Y',strtotime($this->data['bookingmail']->row()->checkout));

    $newsid = '16';

    $template_values = $this->mobile_model->get_newsletter_template_details ( $newsid );
      
    
    if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
      $sender_email = $this->config->item ( 'site_contact_mail' );
      $sender_name = $this->config->item ( 'email_title' );
    } else {
      $sender_name = $template_values ['sender_name'];
      $sender_email = $template_values ['sender_email'];
    }
    $Booking_info = array('travellername' => $this->data['bookingmail']->row()->name, 'checkindate'=>$checkindate, 'checkoutdate' => $checkoutdate, 'price' => $this->data['bookingmail']->row()->price, 'totalprice' => $price, 'email_title' => $sender_name ,'currencySymbol' =>'', 'currencycode'=>$currencycd,'logo'=>$this->data['logo'],'booking_no'=>$this->data['bookingmail']->row()->Bookingno);

      $message = $this->load->view('newsletter/BookInfo'.$newsid.'.php',$Booking_info,TRUE);
    
    $email_values = array (
        'mail_type' => 'html',
        'from_mail_id' => $sender_email,
        'mail_name' => $sender_name,
        'to_mail_id' => $hostemail, 
        'subject_message' => $template_values['news_subject'],
        'body_messages' => $message 
    );
    //send mail
            $this->load->library('email');
            $this->email->from($email_values['from_mail_id'], $sender_name);
            $this->email->to($email_values['to_mail_id']);
            $this->email->subject($email_values['subject_message']);
            $this->email->set_mailtype("html");
            $this->email->message($message); 
            
            try{
        $this->email->send();
            }catch(Exception $e) {
        echo $e->getMessage();
            }                   

    /* Mail function end */
    
    
    
    if($insertid > 0) {
      $jsonReturn = array("status"=>1,"message"=>"Your request has been sent to Host successfully!");
    } else {
      $jsonReturn = array("status"=>0,"message"=>"Your request has failed!");
    }
    
    $hostDetails = $this->mobile_model->get_all_details(USERS,array('id'=>$sellerId));
    
    $gcmRegID  = $hostDetails->row()->mobile_key;
    $pushMessage = 'Your property '.$this->data['productPriceDetails']->row()->product_title.' was booked by '.$this->data['guestDetails']->row()->user_name; 
    if (isset($gcmRegID) && isset($pushMessage)) {    
      $gcmRegIds = array($gcmRegID);
      $message = array("m" => $pushMessage, "k"=>'Your Reservation'); 
      $pushStatus = $this->sendPushNotificationToGCM($gcmRegIds, $message);
    }
    
    echo json_encode($jsonReturn);
    
  }
  /* Your Trips */
  public function mobile_your_trips(){
    $guestEmail = $_POST['email']; 
    $keyword = "";
    if ($_POST) {
      $keyword = $this->input->post ('product_title');
    }
    $this->data['guestDetails'] = $this->mobile_model->get_all_details(USERS,array('email'=>$guestEmail));
    
    $userId = $this->data['guestDetails']->row()->id;
    $this->db->select('pb.expiredate,pb.product_id,pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.product_name,p.product_title,p.price,p.currency, u.firstname,u.image, rq.booking_status, rq.checkin, rq.currencycode, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.serviceFee, rq.totalAmt, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno,rq.numofdates,rq.subTotal,rq.secDeposit,rq.NoofGuest, p.cancellation_policy,p.house_rules');
      $this->db->from(RENTALENQUIRY.' as rq');
      $this->db->join(PRODUCT_BOOKING.' as pb' , 'pb.product_id = rq.prd_id', 'left');
      $this->db->join(PRODUCT_ADDRESS_NEW.' as pn' , 'pn.productId = pb.product_id','left');
      $this->db->join(PRODUCT.' as p' , 'p.id = rq.prd_id','left');
      $this->db->join(PRODUCT_PHOTOS.' as pp' , 'p.id = pp.product_id','left');
      $this->db->join(USERS.' as u' , 'u.id = rq.renter_id');
      $this->db->where('rq.user_id = '.$userId);
      //$this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
      if($keyword !="")
      
      {
      $this->db->like('p.product_title',$keyword);
      $this->db->or_like('u.firstname',$keyword);
      $this->db->or_like('pn.address',$keyword);
      }else{
      $this->db->where('rq.booking_status != "Enquiry"');
      }
      $this->db->group_by('rq.id');
      $this->db->order_by('rq.dateAdded', 'desc');
      
    $this->data['tripDetails'] = $trip_details = $this->db->get();
    //echo $this->db->last_query();
    $tripDetails['yourTrips'] = array();
    $my_trips =array();
    if($trip_details->num_rows()>0){
      foreach($trip_details->result() as $trip)
      {
        if($trip->product_image != ''){
          $p_img = explode('.',$trip->product_image); 

          $suffix = strrchr($trip->product_image, "."); 
          $pos = strpos  ( $trip->product_image  , $suffix); 
          $name = substr_replace ($trip->product_image, "", $pos); 
         // echo $suffix . "<br><br>". $name;

          $pro_img = $name.''.$suffix; 
         
          $proImage = base_url().'server/php/rental/'.$pro_img;
        }else{
          $proImage = base_url().'server/php/rental/dummyProductImage.jpg';
        }
        if($trip->firstname != ''){
          $host_name = $trip->firstname;
        } else {
          $host_name ="";
        }
        if($trip->house_rules != ''){
          $house_rules = $trip->house_rules;
        } else {
          $house_rules ="None";
        }
        if(($trip->checkout) > date("Y-m-d H:i:s")) {
          $is_previous = false;
        } else if(($trip->checkout) <= date("Y-m-d H:i:s")) {
          $is_previous = true;
        }
        $condition = array('currency_type'=>$trip->currency);
        $property_currency_details = $this->mobile_model->get_all_details ( CURRENCY, $condition );
        $property_currency_symbol = $property_currency_details->row()->currency_symbols;

        $conditionrq = array('currency_type'=>$trip->currencycode);
        $paid_currency_details = $this->mobile_model->get_all_details ( CURRENCY, $conditionrq );
        $paid_currency_symbol = $paid_currency_details->row()->currency_symbols;
        
        $cur_date = date("Y-m-d H:i:s");
        $secDeposit = floatval($trip->secDeposit);
        $total = $trip->subTotal + $trip->secDeposit +$trip->serviceFee;
        $reviewData = $this->mobile_model->get_trip_review($trip->bookingno,$userId); 
        if($reviewData->num_rows()==0){
          $is_review =false;
        } else {
          $is_review =true;
        }
        $dis_details = $this->mobile_model->get_all_details(DISPUTE,array('user_id'=>$userId,'prd_id'=>$trip->product_id));
                    
        if($dis_details->num_rows() == 0){
          $is_dispute=false;
        } else {
          $is_dispute =true;
        }
         $my_trips[] = array("id"=>intval($trip->cid),"property_title"=>$trip->product_title,"property_price"=>floatval($trip->price),"property_currency_code"=>$trip->currency,"property_currency_symbol"=>$property_currency_symbol,"bookedon"=>$trip->dateAdded,"bookingno"=>$trip->bookingno,"booking_status"=>$trip->booking_status,"approval_status"=>$trip->approval,"checkin"=>$trip->checkin,"checkout"=>$trip->checkout,"numofdates"=>intval($trip->numofdates),"property_address"=>$trip->prd_address,"expiredate"=>$trip->expiredate,"country"=>$trip->country_name,"state"=>$trip->state_name,"city"=>$trip->city_name,"property_id"=>intval($trip->product_id),"host_name"=>$host_name,"service_fee"=>floatval($trip->serviceFee),"sub_total"=>floatval($trip->subTotal),"security_deposit"=>floatval($trip->secDeposit),"NoofGuest"=>intval($trip->NoofGuest),"cancellation_policy"=>$trip->cancellation_policy,"house_rules"=>$house_rules,"total"=>floatval($total),"paid_currency_code"=>$trip->currencycode,"paid_currency_symbol"=>$paid_currency_symbol,"property_image"=>$proImage,"is_previous"=>$is_previous,"is_review"=>$is_review,"is_dispute"=>$is_dispute,"guest_id"=>intval($trip->GestId));
      }
    }
    
    if($trip_details->num_rows()==0){
      $response = array("status"=>1,"message"=>"No Listing found","mytrips"=>$my_trips);
    } else {
      $response = array("status"=>1,"message"=>"My trips available","mytrips"=>$my_trips);
    }
    
    echo json_encode($response);
  }
  
  
  /* Host Approve the user booking */
  public function host_approval()
  {
    $sender_id = $this->input->post ( 'sender_id' );
    $receiver_id = $this->input->post ( 'receiver_id' );
    $bookingno = $this->input->post ( 'bookingno' );
    $property_id = $this->input->post ( 'property_id' );
    $subject = $this->input->post ( 'subject' );
    $message = $this->input->post ( 'message' );
    $status = $this->input->post ( 'status' ); // Accept
    
    if($sender_id =="" || $receiver_id =="" || $bookingno =="" || $property_id =="" || $subject =="" || $message =="" || $status ==""){
      $response = array("status"=>1,"message"=>"Parameter missing!");
      echo json_encode($response);
      exit;
    }
    $dataArr = array(
      'productId' => $property_id ,
      'senderId' => $sender_id ,
      'receiverId' => $receiver_id ,
      'bookingNo' => $bookingno ,
      'subject' => $subject ,
      'message' => $message,
      'point' => '1',
      'status' => $status
    );
    
    $this->db->insert(MED_MESSAGE, $dataArr);
    $this->db->where('bookingNo', $bookingno);
    $this->db->update(MED_MESSAGE, array('status' => $status));
    $newdata = array('approval' => $status);
    $condition = array('Bookingno' => $bookingno);
    $this->mobile_model->update_details(RENTALENQUIRY,$newdata,$condition);
    
    /*
    $enquiryId = $_POST['enqId'];
    
    $newdata = array ('approval' => 'Accept');
    $condition = array ('id' => $enquiryId);
    $this->mobile_model->update_details (RENTALENQUIRY,$newdata,$condition);
    */
    $enqDetails = $this->mobile_model->get_all_details(RENTALENQUIRY,array('Bookingno'=>$bookingno));
    $enquiryId = $enqDetails->row()->id;
    $product_Id = $enqDetails->row()->prd_id;
    
    $rentalDetails = $this->mobile_model->get_all_details(PRODUCT,array('id'=>$product_Id));
    
    $product_title = $rentalDetails->row()->product_title;
    
    //$productDetails = $this->mobile_model->get_all_details(RENTALENQUIRY,array('id'=>$enquiryId));
    
    $userId = $enqDetails->row()->user_id;
    
    $userDetails = $this->mobile_model->get_all_details(USERS,array('id'=>$userId));
    
    $hostdetail = $this->mobile_model->get_all_details(USERS,array('id'=>$enqDetails->row()->renter_id));
    
    /* Approval mail function Start */
      
    $newsid = '23';

      $template_values = $this->mobile_model->get_newsletter_template_details ($newsid);
    
    if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
      $sender_email = $this->config->item ( 'site_contact_mail' );
      $sender_name = $this->config->item ( 'email_title' );
    } else {
      $sender_name = $template_values ['sender_name'];
      $sender_email = $template_values ['sender_email'];
    }
  
    $Approval_info = array('email_title' => $sender_name,'logo' => $this->data ['logo'],'travelername'=>$userDetails->row()->firstname."  ".$userDetails->row()->lastname,'propertyname'=>$product_title,'hostname'=>$hostdetail->row()->firstname." ".$hostdetail->row()->lastname );
           
      $message = $this->load->view('newsletter/Host Approve Reservation'.$newsid.'.php',$Approval_info,TRUE);
    $email_values = array (
        'mail_type' => 'html',
        'from_mail_id' => $sender_email,
        'mail_name' => $sender_name,
        'to_mail_id' => $userDetails->row()->email,     
        'subject_message' => $template_values ['news_subject'],
        'body_messages' => $message 
    );

            //send mail
            $this->load->library('email');
            $this->email->from($email_values['from_mail_id'], $sender_name);
            $this->email->to($email_values['to_mail_id']);
            $this->email->subject($email_values['subject_message']);
            $this->email->set_mailtype("html");
            $this->email->message($message); 
            try{
        $this->email->send();
            }catch(Exception $e){
        echo $e->getMessage();
            }  
      
    $response = array("status"=>1,"message"=>"Successfully accepted");
    echo json_encode($response);
    /* Approval mail function Ends */
/*
    $gcmRegID  = $userDetails->row()->mobile_key;
    $pushMessage = 'The booked property '.$rentalDetails->row()->product_title.' was approved'; 
    if (isset($gcmRegID) && isset($pushMessage)) {    
      $gcmRegIds = array($gcmRegID);
      $message = array("m" => $pushMessage, "k"=>'Your Trips'); 
      $pushStatus = $this->sendPushNotificationToGCM($gcmRegIds, $message);
    }
    
    
    
    if($enquiryId > 0) $jsonReturn['status'] = 'successfully accepted';
    else $jsonReturn['status'] = 'Failed';
    echo json_encode($jsonReturn);
    */
  }
  /* Host Decline the user booking */
  public function host_decline()
  {
    $sender_id = $this->input->post ( 'sender_id' );
    $receiver_id = $this->input->post ( 'receiver_id' );
    $bookingno = $this->input->post ( 'bookingno' );
    $property_id = $this->input->post ( 'property_id' );
    $subject = $this->input->post ( 'subject' );
    $message = $this->input->post ( 'message' );
    $status = $this->input->post ( 'status' ); // Decline
    
    if($sender_id =="" || $receiver_id =="" || $bookingno =="" || $property_id =="" || $subject =="" || $message =="" || $status ==""){
      $response = array("status"=>1,"message"=>"Parameter missing!");
      echo json_encode($response);
      exit;
    }
    $dataArr = array(
      'productId' => $property_id ,
      'senderId' => $sender_id ,
      'receiverId' => $receiver_id ,
      'bookingNo' => $bookingno ,
      'subject' => $subject ,
      'message' => $message,
      'point' => '1',
      'status' => $status
    );
    
    $this->db->insert(MED_MESSAGE, $dataArr);
    $this->db->where('bookingNo', $bookingno);
    $this->db->update(MED_MESSAGE, array('status' => $status));
    $newdata = array('approval' => $status);
    $condition = array('Bookingno' => $bookingno);
    $this->mobile_model->update_details(RENTALENQUIRY,$newdata,$condition);
    
    
    $enqDetails = $this->mobile_model->get_all_details(RENTALENQUIRY,array('Bookingno'=>$bookingno));
    $enquiryId = $enqDetails->row()->id;
    $product_Id = $enqDetails->row()->prd_id;
    
    $rentalDetails = $this->mobile_model->get_all_details(PRODUCT,array('id'=>$product_Id));
    
    $product_title = $rentalDetails->row()->product_title;
    
    $userId = $enqDetails->row()->user_id;
    
    $userDetails = $this->mobile_model->get_all_details(USERS,array('id'=>$userId));
    
    $hostdetail = $this->mobile_model->get_all_details(USERS,array('id'=>$enqDetails->row()->renter_id));
    
    /* Decline mail function Start */
      
    $newsid = '24';

      $template_values = $this->mobile_model->get_newsletter_template_details ($newsid);
    
    if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
      $sender_email = $this->config->item ( 'site_contact_mail' );
      $sender_name = $this->config->item ( 'email_title' );
    } else {
      $sender_name = $template_values ['sender_name'];
      $sender_email = $template_values ['sender_email'];
    }
  
    $Approval_info = array('email_title' => $sender_name,'logo' => $this->data ['logo'],'travelername'=>$userDetails->row()->firstname."  ".$userDetails->row()->lastname,'propertyname'=>$product_title,'hostname'=>$hostdetail->row()->firstname." ".$hostdetail->row()->lastname );
           
      $message = $this->load->view('newsletter/Host Decline Reservation'.$newsid.'.php',$Approval_info,TRUE);
    $email_values = array (
        'mail_type' => 'html',
        'from_mail_id' => $sender_email,
        'mail_name' => $sender_name,
        'to_mail_id' => $userDetails->row()->email,     
        'subject_message' => $template_values ['news_subject'],
        'body_messages' => $message 
    );

            //send mail
            $this->load->library('email');
            $this->email->from($email_values['from_mail_id'], $sender_name);
            $this->email->to($email_values['to_mail_id']);
            $this->email->subject($email_values['subject_message']);
            $this->email->set_mailtype("html");
            $this->email->message($message); 
            try{
        $this->email->send();
            }catch(Exception $e){
        echo $e->getMessage();
            }  
    $response = array("status"=>1,"message"=>"Successfully Declined!");
    echo json_encode($response);
    exit;
    /* Decline mail function Ends */
    
/*    $gcmRegID  = $userDetails->row()->mobile_key;
    $pushMessage = 'The booked property '.$rentalDetails->row()->product_title.' was declined';
    if (isset($gcmRegID) && isset($pushMessage)) {    
      $gcmRegIds = array($gcmRegID);
      $message = array("m" => $pushMessage, "k"=>'Your Trips'); 
      $pushStatus = $this->sendPushNotificationToGCM($gcmRegIds, $message);
    }
    
    
    if($enquiryId > 0) $jsonReturn['status'] = 'successfully declined';
    else $jsonReturn['status'] = 'Failed';
    echo json_encode($jsonReturn);
    */
  }
  /* SEnd Message the user booking */
  public function send_message()
  {
    $sender_id = $this->input->post ( 'sender_id' );
    $receiver_id = $this->input->post ( 'receiver_id' );
    $bookingno = $this->input->post ( 'bookingno' );
    $property_id = $this->input->post ( 'property_id' );
    $subject = $this->input->post ( 'subject' );
    $message = $this->input->post ( 'message' );
    
    if($sender_id =="" || $receiver_id =="" || $bookingno =="" || $property_id =="" || $subject =="" || $message ==""){
      $response = array("status"=>1,"message"=>"Parameter missing!");
      echo json_encode($response);
      exit;
    }
    
    $statusQry = $this->user_model->get_all_details ( MED_MESSAGE, array ('bookingNo' => $bookingno));
    $status = $statusQry->row()->status;
    $dataArr = array(
      'productId' => $property_id ,
      'senderId' => $sender_id ,
      'receiverId' => $receiver_id ,
      'bookingNo' => $bookingno ,
      'subject' => $subject ,
      'message' => $message,
      'status' => $status
    );
    if($statusQry->num_rows()>0){
      $this->db->insert(MED_MESSAGE, $dataArr);
      $response = array("status"=>1,"message"=>"Successfully Message Sent!");
    } else {
      $response = array("status"=>0,"message"=>"Invalid data!");
    }
    
    
    echo json_encode($response);
    
    
  }
  public function host_delete_list()
  {
    $email = $_GET['email'];
    $productId = $_GET['pId'];
    $condition = array('email'=>$email);
    $userDetails = $this->mobile_model->get_all_details ( USERS, $condition );
    $userId = $userDetails->row()->id;
    $this->db->where('user_id', $userId);
    $this->db->where('id', $productId);
    $this->db->delete(PRODUCT);
    $condition = array('user_id' => $userId, 'id' => $productId);
    $productDetails = $this->mobile_model->get_all_details ( PRODUCT, $condition );
    if($productDetails->num_rows() == 0)
    {
      $this->db->where('product_id', $productId);
      $this->db->delete(PRODUCT_ADDRESS); 
      $this->db->where('product_id', $productId);
      $this->db->delete(PRODUCT_PHOTOS); 
      $this->db->where('id', $productId);
      $this->db->delete(SCHEDULE); 
      $this->db->where('PropId', $productId);
      $this->db->delete(CALENDARBOOKING);
      $jsonReturn['status'] = 'Success';
    }
    echo json_encode($jsonReturn);
  }
  
  public function host_unlist_list()
  {
    $email = $_GET['email'];
    $productId = $_GET['pId'];
    $action = $_GET['action'];
    $condition = array('email'=>$email);
    $userDetails = $this->mobile_model->get_all_details ( USERS, $condition );
    $userId = $userDetails->row()->id;
    $data = array(
      'user_status'=>$action
      );
    $condition = array(
      'id'=>$productId,
      'user_id'=>$userId
      );
    $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    $jsonReturn['status'] = 'Success';
    echo json_encode($jsonReturn);
  }
  
  public function save_cancel_policy()
  {
    $tType = $_GET['tType'];
    $productId = $_GET['pId'];
    $data = array(
      'cancellation_policy'=>$tType
      );
    $condition = array(
      'id'=>$productId
      );
    $this->mobile_model->update_details(PRODUCT ,$data ,$condition);
    $jsonReturn['status'] = 'successfully added';
    echo json_encode($jsonReturn);
  }
  
  public function proceedPayment(){
    //if ($_POST['enqId']!=''){ 
    $enqId = 1;
    if ($enqId != ''){ 
      $this->db->select('R.*');
      $this->db->from(RENTALENQUIRY . ' as R');
      $this->db->where('R.id',$enqId);
      $result = $this->db->get();
      $userId=$result->row()->renter_id;
      $sellerId=$result->row()->user_id;
      $productId=$result->row()->prd_id;
      $payment=$result->row()->totalAmt;
      $payArr = array('userId'  =>  $userId,
              'sellerId'    =>  $sellerId,
              'productId'   =>  $productId,
              'payment' =>  $payment, 
            );
      $this->mobile_model->simple_insert(MOBILE_PAYMENT,$payArr);
      $mobileId = $this->db->insert_id();
      $json_encode = json_encode(array("status"=>'Success', "mobileId"=>$mobileId));
      echo $json_encode;
      //echo "Success|".$mobileId;
    }else{
      $json_encode = json_encode(array("status"=>'Failed'));
      echo $json_encode;
      //echo "Failure";
    }
  }
  
  public function send_iphone_message()
  {
    $this->push_notification();
  }
  /** 
   * 
   * Load CMS pages for mobile view
   */
  public function mobilePages() { 
    $seourl = $this->uri->segment(2);
    $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
    if ($pageDetails->num_rows() == 0){
        show_404();
      }else {
        $this->mobdata['pageDetails'] = $pageDetails;     
      $this->load->view('mobile/cms.php',$this->mobdata);
    }
  }
  
  public function iospn(){
    #413944117c13a80d85ef678f6557d854e36fe378da63376bdf24bdbe6e86381a
    $this->push_notification();
  }
  
  public function transaction_history(){
    $email = $_POST['email'];
    //$transactionsArr = $this->mobile_model->get_all_details(COMMISSION_TRACKING,array('host_email'=>$email));
    //$resonse_json = $transactionsArr->result();
$transactionsArr = $this->mobile_model->get_transaction_details($email);
$resonse_json = $transactionsArr->result();

    if($transactionsArr->num_rows()== 0) {
      echo json_encode(array('status'=>0,'message'=>'No Transaction found','transaction_history'=>$resonse_json));
    } else {
      echo json_encode(array('status'=>1,'message'=>'Transaction available','transaction_history'=>$resonse_json));
    }
  }
   
  public function add_to_favourite(){
    $email = $_POST['email'];
    $productId = $_POST['p_Id'];
    $userDetails = $this->mobile_model->get_all_details(USERS,array('email'=>$email));
    $userId = $userDetails->row()->id;
    $listDetails = $this->mobile_model->get_all_details(LISTS_DETAILS,array('user_id'=>$userId, 'product_id'=>$productId));
    if($listDetails->num_rows() == 0)
    {
      $productDetails = $this->mobile_model->get_all_details(PRODUCT,array('id'=>$productId));
      $productName = $productDetails->row()->product_title;
      $dataArr = array('user_id'=>$userId, 'name'=>$productName, 'product_id'=>$productId, 'whocansee'=>'Everyone');
      $this->mobile_model->simple_insert(LISTS_DETAILS,$dataArr);
      $listDetails = $this->mobile_model->get_all_details(LISTS_DETAILS,array('user_id'=>$userId, 'product_id'=>$productId));
    }
    $jsonReturn['status'] = 'successfully added';
    echo json_encode(array('jsonReturn'=>$jsonReturn));
  }
  
  public function remove_from_favourite(){
    $email = $_POST['email'];
    $productId = $_POST['p_Id'];
    $userDetails = $this->mobile_model->get_all_details(USERS,array('email'=>$email));
    $userId = $userDetails->row()->id;
    $productDetails = $this->mobile_model->get_all_details(PRODUCT,array('id'=>$productId));
    $productName = $productDetails->row()->product_title;
    $this->db->where('user_id', $userId);
    $this->db->where('product_id', $productId);
    $this->db->delete(LISTS_DETAILS); 
    $jsonReturn['status'] = 'successfully removed';
    echo json_encode(array('jsonReturn'=>$jsonReturn));
  }
  
  /************10-06-2016************************************************************/
  public function property_values() {
    $select_qry = "id,seller_product_id,product_title,seourl,price,price_range,description,quantity,max_quantity,purchasedCount,shipping_type,shipping_cost,taxable_type,tax_cost,user_id,list_name,ship_immediate,status,currency,home_type,room_type,accommodates,listings,price_perweek,price_permonth,datefrom,dateto,minimum_stay,security_deposit,cancellation_policy,user_status from fc_product";
      
      $property_values = $this->product_model->check_product_id($select_qry);
      
      $productvalueArr = array();
      foreach($property_values->result() as $product_value) {
      $productvalueArr[] = array("id" =>$product_value->id,"seller_product_id"=>$product_value->seller_product_id,"product_title"=>$product_value->product_title,"seourl"=>$product_value->seourl,"price"=>$product_value->price,"price_range"=>$product_value->price_range,"description"=>$product_value->description,"quantity"=>$product_value->quantity,"max_quantity"=>$product_value->max_quantity,"purchasedCount"=>$product_value->purchasedCount,"shipping_type"=>$product_value->shipping_type,"shipping_cost"=>$product_value->shipping_cost,"taxable_type"=>$product_value->taxable_type,"tax_cost"=>$product_value->tax_cost,"user_id"=>$product_value->user_id,"list_name"=>$product_value->list_name,"ship_immediate"=>$product_value->ship_immediate,"status"=>$product_value->status,"currency"=>$product_value->currency,"home_type"=>$product_value->home_type,"room_type"=>$product_value->room_type,"accommodates"=>$product_value->accommodates,"listings"=>$product_value->listings,"price_perweek"=>$product_value->price_perweek,"price_permonth"=>$product_value->price_permonth,"datefrom"=>$product_value->datefrom,"dateto"=>$product_value->dateto,"minimum_stay"=>$product_value->minimum_stay,"security_deposit"=>$product_value->security_deposit,"cancellation_policy"=>$product_value->cancellation_policy,"user_status"=>$product_value->user_status);
      }
      $json_encode = json_encode(array("product_values"=>$productvalueArr));
      echo $json_encode;
  }
  
  public function booking_values() {
  
    $select_qry = "id,id_item,the_date,id_state,id_booking,PropId,price from bookings";
      
      $booking_values = $this->bookings_model->book_all($select_qry);
      
      $bookingvalueArr = array();
      foreach($booking_values->result() as $booking_value) {
      $bookingvalueArr[] = array("id" =>$booking_value->id,"id_item"=>$booking_value->id_item,"the_date"=>$booking_value->the_date,"id_state"=>$booking_value->id_state,"id_booking"=>$booking_value->id_booking,"PropId"=>$booking_value->PropId,"price"=>$booking_value->price);
      }
      $json_encode = json_encode(array("booking_values"=>$bookingvalueArr));
      echo $json_encode;
  }
  
  public function custom_values() {
          //$select_qry = "id,loginUserType,user_name,group,email,password,status from fc_users";
          
      $custom_values = $this->custom_model->get_user_all();
      
      $customvalueArr = array();
      foreach($custom_values->result() as $custom_value) {
      $customvalueArr[] = array("id" =>$custom_value->id,"loginUserType"=>$custom_value->loginUserType,"user_name"=>$custom_value->user_name,"group"=>$custom_value->group,"email"=>$custom_value->email,"password"=>$custom_value->password,"status"=>$custom_value->status);
      }
      $json_encode = json_encode(array("custom_values"=>$customvalueArr));
      echo $json_encode;
  }
/* PROPERTY HOME PAGE */
  public function home_property_info()
  {
    $CityDetails = $this->mobile_model->Featured_city();
    $response= array();
    $currency_val = array();
    if($CityDetails->num_rows()>0){
      foreach ($CityDetails->result() as $result){  
        $name=str_replace(' ','+',$result->name);
        $response[] = array("name" => trim(stripslashes($result->name)), "citythumb" => $result->citythumb,"image_url" => base_url().'images/city/'.trim(stripslashes($result->citythumb)), "property_url" => 'property?city='.$name);
      }
      //$response_json['Home_page_details'] = $response;
      
    }
    
    $currency_symbol_query='SELECT * FROM '.CURRENCY.' where status = "Active"';
    $currency_symbol=$this->mobile_model->ExecuteQuery($currency_symbol_query);
    
    if($currency_symbol->num_rows() > 0)
    { 
      foreach($currency_symbol->result() as $cur){
         $currency_rate =0;
        //if($currency_type != $cur->currency_type) {
          $currency_val[] = array('id'=>intval($cur->id),'currency_symbol'=>$cur->currency_symbols,'currency_code'=>$cur->currency_type,"currency_value"=>0);
        //}
      }
    }
    if(($currency_symbol->num_rows() == 0) && ($CityDetails->num_rows() ==0) )
    { 
      $response_json = array('status'=>0,'message'=>'No Data Available','Home_page_details'=>$response,'currency_list'=>$currency_val);
    } else {
      $response_json = array('status'=>1,'message'=>'Data Available','Home_page_details'=>$response,'currency_list'=>$currency_val);
    }
    
    echo json_encode($response_json);
  } 
  
  /* Listing type values */
  public function listing_type_values() {
    $roombedVal=array();
	
	$select_qrys = "select * from fc_listing_types WHERE status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		   
		  
	/***********Yamuna 09-1-2018 Child Name*********/
    $select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    if($list_valuesy->num_rows()>0){
		if($listing_type=="option") {
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);
	  }
	  
		}
	
	}
	$roombedVal[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	//print_r($roombedVal);die();
	echo json_encode(array('listing_type'=>$roombedVal));
	
    /* $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as $list){
        $roombedVal[] =json_decode($list->listing_values);
      }
    }
    echo json_encode(array('listing_type'=>$roombedVal)); */
  }
  /* Inbox message */
  public function json_med_message()
  {
    $userid = $_POST['userid'];
    $med_messages = $this->mobile_model->json_get_med_messages($userid);
    //echo $this->db->last_query();
               $messageArr = array();
         if($med_messages->num_rows()>0){
               foreach($med_messages->result() as $message_value) {
           if($message_value->image != '') {
            $img = base_url().'images/users/'.$message_value->image;
          }else{
            $img = base_url().'images/site/profile.png';
          }
          if($message_value->firstname !=""){
            $firstname = $message_value->firstname;
          }else { $firstname=""; }
          if($message_value->message !=""){
            $message = $message_value->message;
          }else { $message=""; }
          if($message_value->subject !=""){
            $subject = $message_value->subject;
          }else { $subject=""; }
          $id = $message_value->id;
          $property_id = $message_value->productId;
          $dateAdded = $message_value->dateAdded;
                       $messageArr[] = array("id"=>$message_value->id,"property_id"=>$message_value->productId,"dateAdded"=>$message_value->dateAdded,"message"=>$message,"subject"=>$subject,"bookingno"=>$message_value->bookingNo,"msg_read"=>$message_value->msg_read,"status"=>$message_value->status,"user_msgread_status"=>$message_value->user_msgread_status,"host_msgread_status"=>$message_value->host_msgread_status,"msg_status"=>$message_value->msg_status,"sender_name"=>$firstname,"user_image"=>$img);
               }
               $json_encode = json_encode(array("status"=>1,"message"=>"Notification available","message_values"=>$messageArr));
         } else {
            $json_encode = json_encode(array("status"=>1,"message"=>"Notification available","message_values"=>$messageArr));
         }
           echo $json_encode;
  }
  /* Language values */
  public function mobile_lang_list() {
    $condition = array('language_code !='=>"");
    $listvalue = $this->mobile_model->get_all_details (LANGUAGES_KNOWN, $condition);
    $language =array();
    if($listvalue->num_rows()>0) {
      foreach($listvalue->result() as $list){
        $language[] = array('id'=>$list->id,'language_name'=>$list->language_name,'language_code'=>$list->language_code);
      }
      $json_encode = json_encode(array('status'=>1,'message'=>'Language Available','language_list'=>$language));
    } else {
      $json_encode = json_encode(array('status'=>0,'message'=>'No data found','language_list'=>$language));
    }
    
    echo $json_encode;
  }
  /* ADD PROPERTY STEP1 */
  public function mobile_add_property_step1()
  {
    $user_id = $this->input->post('user_id');
    $property_type = $this->input->post('property_type');
    $room_type = $this->input->post('room_type');
    $accommodates = $this->input->post('accommodates');
    $address = $this->input->post('city');
    $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
    $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
    
    $currencyvalueArr = array();
    if($currency_values->num_rows() >0) {
      foreach($currency_values->result() as $cur_value) {
      $currencyvalueArr[] = array("id" =>$cur_value->id,"country_symbols"=>$cur_value->currency_symbols,"currency_type"=>$cur_value->currency_type);
      }
    } 
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($property_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($property_listvalue->result() as $prty) {
              $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    }
    
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
    $roombedVal=array();
    $roombedVal1=array();
    $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as   $list){
        $roombedVal[] =json_decode($list->listing_values);
        $roombedVal1[] =json_decode($list->rooms_bed);
      }
    }
	
	/***********Charles 18-3-2017 Parent Name*********/
	$select_qrys = "select * from fc_listing_types WHERE status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		   
		  
	/***********Charles 2-3-2017 Child Name*********/
$select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    if($list_valuesy->num_rows()>0){
	if($listing_type=="option") {
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);
	  }
	}
	
	
	}
	$property_attributes[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	/***********Charles 18-3-2017 Parent Name*********/
	
	
	
	
	
	
	
    if ($user_id=='')
    {
      $json_encode = json_encode(array('status'=>0,'message'=>'Please sign in before listing your rental'));
      echo $json_encode;
    }
    else
    {
      $condition = array('id'=>$user_id,'status'=>'Active');
      $this->data['checkUser'] = $this->mobile_model->get_all_details(USERS,$condition);
      $cityArr = explode(',',$this->input->post('city'));
      if($this->data['checkUser']->num_rows() == 1)
        {
          $data = array('room_type'=>$this->input->post('room_type'),
                 'accommodates'=>$this->input->post('accommodates'),
                 'home_type'=>$this->input->post('property_type'),
                 'user_id'=>$user_id,
                 'status'=>'UnPublish',
                );
                
          $this->mobile_model->simple_insert(PRODUCT,$data);
          
          $getInsertId=$this->mobile_model->get_last_insert_id();
          
          $dataArr = array('productId' => $getInsertId, 'address' => $address);
          $this->mobile_model->simple_insert(PRODUCT_ADDRESS_NEW,$dataArr);
          $inputArr3=array();
          $inputArr3 = array(
                'product_id' =>$getInsertId
                );
          $this->mobile_model->simple_insert(PRODUCT_BOOKING,$inputArr3);
          $inputArr4=array();
          $inputArr4 = array(
                'id' =>$getInsertId
                );
          $this->mobile_model->simple_insert(SCHEDULE,$inputArr4);
          $this->mobile_model->update_details(USERS,array('group'=>'Seller'),array('id'=>$user_id));
          //$json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$getInsertId));
        }
      else
        {
          $json_encode = json_encode(array('status'=>0,'message'=>'Please register  before listing your rental'));
          echo $json_encode; 
          exit;
        }
    }
    $catID = $getInsertId;
    
/* schedule starts here */
      $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$catID));
    $sometime_arr = array();
    if($scheduleCheck->num_rows()>0){
      foreach($scheduleCheck->result() as $sc){ 
        $json_decode = json_decode($sc->data);
        foreach($json_decode as $key=>$value){
          if($value->status=="available"){
            $status = 1;
          }else if($value->status=="booked"){
            $status = 2;
          }else if($value->status=="unavailable"){
            $status = 3;
          }
          $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
        }
      } 
    }
/* schedule ends here */
    
    /* Get the property details */
    $attributes=array();
    $where1 = array('p.id'=>$catID);  
    $this->db->select('p.home_type,p.id,p.accommodates,p.room_type,p.price,p.currency,p.status,p.calendar_checked,pa.address,p.description,p.product_title,p.other_thingnote,p.house_rules,p.list_name,p.listings,pa.address,pa.country,pa.state,pa.city,pa.street,pa.zip,pa.lat,pa.lang,p.cancellation_policy,p.security_deposit,p.meta_title,p.meta_keyword,p.meta_description');
    $this->db->from(PRODUCT.' as p');
    $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
    $this->db->where($where1);
    $rental_details = $this->db->get(); 
     /* Get Cancellation Policy detail starts */
          $seourl = 'cancellation-policy';
          $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
          $cancellation_policy_description  = "";
          $cancellation_policy_title        = "";
          if($pageDetails->num_rows()>0) {
            foreach($pageDetails->result() as $page){
                $cancellation_policy_description  = $page->description;
                $cancellation_policy_title        = $page->page_title;
            }
          }
          /* Get Cancellation Policy detail ends */
    $photos = array();
    if($rental_details->num_rows() == 1) {
      $this->db->from(PRODUCT_PHOTOS);
      $this->db->where('product_id',$catID);
      $this->db->order_by('imgPriority','asc');
      $productImages = $this->db->get();
      if($productImages->num_rows()>0) {
        foreach($productImages->result() as $prd_Images){ 
          $photos[] =array("product_image_id"=>intval($prd_Images->id),"product_image"=>base_url().'server/php/rental/'.$prd_Images->product_image); 
        }
      } 
      foreach($rental_details->result() as $rental_detail){
        if($rental_detail->listings !=""){
          $attributes[] = json_decode($rental_detail->listings);          
        }
      
$step1 = array("propertyid"=>$catID,"home_type"=>$rental_detail->home_type,"room_type"=>$rental_detail->room_type,"accommodates"=>$rental_detail->accommodates,"address"=>$rental_detail->address,"status"=>$rental_detail->status);
      $calendar_status = false;
      if($rental_detail->status == 'Publish' ){
        $calendar_status = true;
      }
      $step2 = array("propertyid"=>$catID,"calendar_checked"=>$rental_detail->calendar_checked,"dateto"=>"","datefrom"=>"","calendar_status"=>$calendar_status,"seasonal_calendar_price"=>$sometime_arr);
     
      $price ="";
      if($rental_detail->price !=0){
        $price = floatval($rental_detail->price);
      }
      $step3 = array("propertyid"=>$catID,"currency_code"=>$rental_detail->currency,"price"=>$price,"chk"=>"price");
      $step4 = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title,"property_description"=>$rental_detail->description,"other_thingnote"=>$rental_detail->other_thingnote,"house_rules"=>$rental_detail->house_rules);
      $step4_chk = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title);
      $step5 = array("propertyid"=>$catID,"product_image"=>$photos);
      $step6 = array("propertyid"=>$catID,"list_name"=>$rental_detail->list_name);
      $step7 = array("propertyid"=>$catID,"room_type"=>$rental_detail->room_type,"home_type"=>$rental_detail->home_type,"attribute"=>$attributes);
      $step8 = array("propertyid"=>$catID,"address"=>$rental_detail->address,"country"=>$rental_detail->country,"state"=>$rental_detail->state,"city"=>$rental_detail->city,"street"=>$rental_detail->street,"zip"=>$rental_detail->zip,"lat"=>$rental_detail->lat,"long"=>$rental_detail->lang);
      $step9 = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"meta_title"=>$rental_detail->meta_title,"meta_keyword"=>$rental_detail->meta_keyword,"meta_description"=>$rental_detail->meta_description,"property_currency"=>$rental_detail->currency,"cancellation_policy_title"=>$cancellation_policy_title,"cancellation_policy_description"=>$cancellation_policy_description);
      $step9_chk = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"property_currency"=>$rental_detail->currency);
      }
      
      $step_empty1=0;
      if (in_array('', $step1)) { $step_empty1++; }
      if($step_empty1>0){ $array1 = array("step_completed"=>false); } else { $array1 = array("step_completed"=>true); }
      $step1 = array_merge($array1, $step1); 
      
      $step22[] = $step2['calendar_checked'];
      $step_empty2=0;
      if (in_array('',$step22)) { $step_empty2++; }
      if($step_empty2>0){ $array2 = array("step_completed"=>false); } else { $array2 = array("step_completed"=>true); }
      $step2 = array_merge($array2, $step2); 
      
      $step_empty3=0;
      if (in_array('', $step3)) { $step_empty3++; }
      if($step_empty3>0){ $array3 = array("step_completed"=>false); } else { $array3 = array("step_completed"=>true); }
      $step3 = array_merge($array3, $step3); 
      
      $step_empty4=0;
      if (in_array('', $step4_chk)) { $step_empty4++; }
      if($step_empty4>0){ $array4 = array("step_completed"=>false); } else { $array4 = array("step_completed"=>true); }
      $step4 = array_merge($array4, $step4); 
      
      $step_empty5=0;
      if (empty($photos)) { $step_empty5++; }
      if($step_empty5>0){ $array5 = array("step_completed"=>false); } else { $array5 = array("step_completed"=>true); }
      $step5 = array_merge($array5, $step5); 
      
      
      $step_empty6=0;
      if (in_array('', $step6)) { $step_empty6++; }
      if($step_empty6>0){ $array6 = array("step_completed"=>false); } else { $array6 = array("step_completed"=>true); }
      $step6 = array_merge($array6, $step6); 
      
      $step_empty7=0;
       
      if (empty($attributes)) { $step_empty7++; }
      //if (in_array('', $step7)) { $step_empty7++; }
      if($step_empty7>0){ $array7 = array("step_completed"=>false); } else { $array7 = array("step_completed"=>true); }
      $step7 = array_merge($array7, $step7); 
      
      $step_empty8=0;
      if (in_array('', $step8)) { $step_empty8++; }
      if($step_empty8>0){ $array8 = array("step_completed"=>false); } else { $array8 = array("step_completed"=>true); }
      $step8 = array_merge($array8, $step8); 
      
      $step_empty9=0;
      if (in_array('', $step9_chk)) { $step_empty9++; }
      if($step_empty9>0){ $array9 = array("step_completed"=>false); } else { $array9 = array("step_completed"=>true); }
      $step9 = array_merge($array9, $step9); 
      
      
      $result_arr[] = array("step1"=>$step1,"step2"=>$step2,"step3"=>$step3,"step4"=>$step4,"step5"=>$step5,"step6"=>$step6,"step7"=>$step7,"step8"=>$step8,"step9"=>$step9);
    
      $json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$catID,"result"=>$result_arr,"property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"property_attributes"=>$property_attributes,"currency" =>$currencyvalueArr)); 
      
    } else {
      $json_encode = json_encode(array('status'=>0,'message'=>'No data found',"propertyid"=>"")); 
    }
  echo $json_encode;
        
  }
  /* ADD PROPERTY STEP2 CALENDAR */ 
  public function mobile_add_property_step2() 
  {
    $some_times = json_decode($this->input->post('seasonal_list'));
    $user_id =$this->input->post('user_id');
    $property_id = intval($this->input->post('property_id'));
    $calendar_checked =$this->input->post('calendar_checked');
    $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
    $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
    
    $currencyvalueArr = array();
    if($currency_values->num_rows() >0) {
      foreach($currency_values->result() as $cur_value) {
      $currencyvalueArr[] = array("id" =>$cur_value->id,"country_symbols"=>$cur_value->currency_symbols,"currency_type"=>$cur_value->currency_type);
      }
    } 
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($property_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($property_listvalue->result() as $prty) {
              $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    }
    
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
    $roombedVal=array();
    $roombedVal1=array();
    $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as   $list){
        $roombedVal[] =json_decode($list->listing_values);
        $roombedVal1[] =json_decode($list->rooms_bed);
      }
    }
	
	/***********Charles 18-3-2017 Parent Name*********/
	$select_qrys = "select * from fc_listing_types where status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		  
		  
	/***********Charles 18-3-2017 Child Name*********/
	/***********Charles 2-3-2017 Child Name*********/
	$select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    if($list_valuesy->num_rows()>0){
		if($listing_type=="option") {
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		  $listing_child_type = $listing_child->type;
		  $listing_child_labelname = $listing_child->labelname;
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);

	  }
	  
	$property_attributes[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	}
	/***********Charles 18-3-2017 Parent Name*********/
	
	
	
	
	
    if ($user_id=='')
    {
      $json_encode = json_encode(array('status'=>0,'message'=>'Please sign in before listing your rental'));
    }
    else
    {
    
      $dataArr = array('calendar_checked' => $calendar_checked);
      $this->mobile_model->update_details(PRODUCT,$dataArr,array('id'=>$property_id));
      $this->mobile_model->commonDelete(PRODUCT_BOOKING,array('product_id' => $property_id));
           
        $inputArr3=array();
        
        $inputArr3 = array(
              'product_id' =>$this->input->post('property_id'),
              'dateto' => date('Y-m-d',strtotime($this->input->post('dateto'))),
              'datefrom' => date('Y-m-d',strtotime($this->input->post('datefrom')))
              
        );
        $this->mobile_model->simple_insert(PRODUCT_BOOKING,$inputArr3);
        /* schedule starts */
        if(!empty($some_times)) {
          foreach($some_times->seasonal_calendar_price as $s)
          {
            
            if($s->status==1){
              $status = "available";
            }else if($s->status==2){
              $status = "booked";
            }else if($s->status==3){
              $status = "unavailable";
            }
            $json_array[$s->date] = array('available' => 1, 'bind' => 0, 'info' => '','notes'=> '','price' => $s->price, 'promo' =>'','status'=>$status);
                 
          }
               $schedule_data = json_encode($json_array);
                 $schedule_arr = array('id' => $property_id,'data'=>$schedule_data);

                 $res = $this->db->select('data')->from('schedule')->where('id',$property_id)->get()->result();
                 $decode = json_decode($res);

                 $this->db->where('id',$property_id);
                 $this->db->update('schedule',$schedule_arr);
        }
        $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$property_id));
        
        $sometime_arr = array();
        if($scheduleCheck->num_rows() >0){
          foreach($scheduleCheck->result() as $sc){ 
            $json_decode = json_decode($sc->data);
            foreach($json_decode as $key=>$value){
              if($value->status=="available"){
                $status = 1;
              }else if($value->status=="booked"){
                $status = 2;
              }else if($value->status=="unavailable"){
                $status = 3;
              }
              $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
            }

          } 
        }
        /* schedule ends here */
        $DateUpdateCheck = $this->mobile_model->get_all_details(PRODUCT_BOOKING,array('product_id'=>$property_id,'dateto'=>$this->input->post('dateto'),'datefrom'=>$this->input->post('datefrom')));
        $getPrice = $this->mobile_model->get_all_details(PRODUCT, array('id'=>$property_id));
        $price=$getPrice->row()->price;
        
      if($DateUpdateCheck->num_rows() == '1'){
      
        $DateArr=$this->GetDays1($this->input->post('datefrom'), $this->input->post('dateto')); 
          $dateDispalyRowCount=0;
          if(!empty($DateArr)){
            $dateArrVAl .='{';
            foreach($DateArr as $dateDispalyRow){
            
              if($dateDispalyRowCount==0){
              
                $dateArrVAl .='"'.$dateDispalyRow.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"available"}';
              }else{
                $dateArrVAl .=',"'.$dateDispalyRow.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"available"}';
              }
              $dateDispalyRowCount=$dateDispalyRowCount+1;
            }
            $dateArrVAl .='}';
          }
//          echo $dateArrVAl;die;
          $inputArr4=array();
          $inputArr4 = array(
                'id' =>$property_id,
                'data' => trim($dateArrVAl)
          );
          $this->mobile_model->update_details(SCHEDULE,$inputArr4,array('id'=>$property_id));
        }
        
        $inputArr3=array();
        $inputArr3 = array(
              'dateto' => $this->input->post('dateto'),
              'datefrom' => $this->input->post('datefrom'),
              'price' => $this->input->post('price'),
        );
        $this->mobile_model->update_details(PRODUCT_BOOKING,$inputArr3,array('product_id' => $property_id));
        
      //$json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$property_id));  
    }
    $catID = $property_id;
    
    /* Get the property details */
    $attributes=array();
    $where1 = array('p.id'=>$catID);  
    $this->db->select('p.home_type,p.id,p.accommodates,p.room_type,p.price,p.currency,p.status,p.calendar_checked,pa.address,p.description,p.product_title,p.other_thingnote,p.house_rules,p.list_name,p.listings,pa.address,pa.country,pa.state,pa.city,pa.street,pa.zip,pa.lat,pa.lang,p.cancellation_policy,p.security_deposit,p.meta_title,p.meta_keyword,p.meta_description');
    $this->db->from(PRODUCT.' as p');
    $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
    $this->db->where($where1);
    $rental_details = $this->db->get(); 
     /* Get Cancellation Policy detail starts */
          $seourl = 'cancellation-policy';
          $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
          $cancellation_policy_description  = "";
          $cancellation_policy_title        = "";
          if($pageDetails->num_rows()>0) {
            foreach($pageDetails->result() as $page){
                $cancellation_policy_description  = $page->description;
                $cancellation_policy_title        = $page->page_title;
            }
          }
          /* Get Cancellation Policy detail ends */
    $photos = array();
    if($rental_details->num_rows() == 1) {
      $this->db->from(PRODUCT_PHOTOS);
      $this->db->where('product_id',$catID);
      $this->db->order_by('imgPriority','asc');
      $productImages = $this->db->get();
      if($productImages->num_rows()>0) {
        foreach($productImages->result() as $prd_Images){ 
          $photos[] =array("product_image_id"=>intval($prd_Images->id),"product_image"=>base_url().'server/php/rental/'.$prd_Images->product_image); 
        }
      } 
      foreach($rental_details->result() as $rental_detail){
        if($rental_detail->listings !=""){
          $attributes[] = json_decode($rental_detail->listings);          
        }
      
      $step1 = array("propertyid"=>$catID,"home_type"=>$rental_detail->home_type,"room_type"=>$rental_detail->room_type,"accommodates"=>$rental_detail->accommodates,"address"=>$rental_detail->address,"status"=>$rental_detail->status);
      $calendar_status = false;
      if($rental_detail->status == 'Publish' ){
        $calendar_status = true;
      }
      $step2 = array("propertyid"=>$catID,"calendar_checked"=>$rental_detail->calendar_checked,"dateto"=>"","datefrom"=>"","calendar_status"=>$calendar_status,"seasonal_calendar_price"=>$sometime_arr);
      $price ="";
      if($rental_detail->price !=0){
        $price = floatval($rental_detail->price);
      }
      $step3 = array("propertyid"=>$catID,"currency_code"=>$rental_detail->currency,"price"=>$price,"chk"=>"price");
      $step4 = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title,"property_description"=>$rental_detail->description,"other_thingnote"=>$rental_detail->other_thingnote,"house_rules"=>$rental_detail->house_rules);
      $step4_chk = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title);
      $step5 = array("propertyid"=>$catID,"product_image"=>$photos);
      $step6 = array("propertyid"=>$catID,"list_name"=>$rental_detail->list_name);
      $step7 = array("propertyid"=>$catID,"room_type"=>$rental_detail->room_type,"home_type"=>$rental_detail->home_type,"attribute"=>$attributes);
      $step8 = array("propertyid"=>$catID,"address"=>$rental_detail->address,"country"=>$rental_detail->country,"state"=>$rental_detail->state,"city"=>$rental_detail->city,"street"=>$rental_detail->street,"zip"=>$rental_detail->zip,"lat"=>$rental_detail->lat,"long"=>$rental_detail->lang);
      $step9 = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"meta_title"=>$rental_detail->meta_title,"meta_keyword"=>$rental_detail->meta_keyword,"meta_description"=>$rental_detail->meta_description,"property_currency"=>$rental_detail->currency,"cancellation_policy_title"=>$cancellation_policy_title,"cancellation_policy_description"=>$cancellation_policy_description);
      $step9_chk = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"property_currency"=>$rental_detail->currency);
      }
      
      $step_empty1=0;
      if (in_array('', $step1)) { $step_empty1++; }
      if($step_empty1>0){ $array1 = array("step_completed"=>false); } else { $array1 = array("step_completed"=>true); }
      $step1 = array_merge($array1, $step1); 
      
      $step22[] = $step2['calendar_checked'];
      $step_empty2=0;
      if (in_array('',$step22)) { $step_empty2++; }
      if($step_empty2>0){ $array2 = array("step_completed"=>false); } else { $array2 = array("step_completed"=>true); }
      $step2 = array_merge($array2, $step2); 
      
      $step_empty3=0;
      if (in_array('', $step3)) { $step_empty3++; }
      if($step_empty3>0){ $array3 = array("step_completed"=>false); } else { $array3 = array("step_completed"=>true); }
      $step3 = array_merge($array3, $step3); 
      
      $step_empty4=0;
      if (in_array('', $step4_chk)) { $step_empty4++; }
      if($step_empty4>0){ $array4 = array("step_completed"=>false); } else { $array4 = array("step_completed"=>true); }
      $step4 = array_merge($array4, $step4); 
      
      $step_empty5=0;
      if (empty($photos)) { $step_empty5++; }
      if($step_empty5>0){ $array5 = array("step_completed"=>false); } else { $array5 = array("step_completed"=>true); }
      $step5 = array_merge($array5, $step5); 
      
      
      $step_empty6=0;
      if (in_array('', $step6)) { $step_empty6++; }
      if($step_empty6>0){ $array6 = array("step_completed"=>false); } else { $array6 = array("step_completed"=>true); }
      $step6 = array_merge($array6, $step6); 
      
      $step_empty7=0;
       
      if (empty($attributes)) { $step_empty7++; }
      //if (in_array('', $step7)) { $step_empty7++; }
      if($step_empty7>0){ $array7 = array("step_completed"=>false); } else { $array7 = array("step_completed"=>true); }
      $step7 = array_merge($array7, $step7); 
      
      $step_empty8=0;
      if (in_array('', $step8)) { $step_empty8++; }
      if($step_empty8>0){ $array8 = array("step_completed"=>false); } else { $array8 = array("step_completed"=>true); }
      $step8 = array_merge($array8, $step8); 
      
      $step_empty9=0;
      if (in_array('', $step9_chk)) { $step_empty9++; }
      if($step_empty9>0){ $array9 = array("step_completed"=>false); } else { $array9 = array("step_completed"=>true); }
      $step9 = array_merge($array9, $step9); 
      
      
      $result_arr[] = array("step1"=>$step1,"step2"=>$step2,"step3"=>$step3,"step4"=>$step4,"step5"=>$step5,"step6"=>$step6,"step7"=>$step7,"step8"=>$step8,"step9"=>$step9);
    
      $json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$catID,"result"=>$result_arr,"property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"property_attributes" => $property_attributes,"currency" =>$currencyvalueArr)); 
      
    } else {
      $json_encode = json_encode(array('status'=>0,'message'=>'No data found',"propertyid"=>"")); 
    }
    echo $json_encode;
  }
  /* ADD PROPERTY STEP3 PRICE */  
  public function mobile_add_property_step3()
  {
    $user_id =$this->input->post('user_id');
    $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
    $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
    
    $currencyvalueArr = array();
    if($currency_values->num_rows() >0) {
      foreach($currency_values->result() as $cur_value) {
      $currencyvalueArr[] = array("id" =>$cur_value->id,"country_symbols"=>$cur_value->currency_symbols,"currency_type"=>$cur_value->currency_type);
      }
    } 
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($property_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($property_listvalue->result() as $prty) {
              $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    }
    
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
    $roombedVal=array();
    $roombedVal1=array();
    $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as   $list){
        $roombedVal[] =json_decode($list->listing_values);
        $roombedVal1[] =json_decode($list->rooms_bed);
      }
    }
    /***********Charles 18-3-2017 Parent Name*********/
	$select_qrys = "select * from fc_listing_types where status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		  
		  
	/***********Charles 18-3-2017 Child Name*********/
	/***********Charles 2-3-2017 Child Name*********/
	$select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    if($list_valuesy->num_rows()>0){
		
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		  $listing_child_type = $listing_child->type;
		  $listing_child_labelname = $listing_child->labelname;
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);
		
		  
		  
		  
		 
		
	  }
	  
	$property_attributes[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	}
	/***********Charles 18-3-2017 Parent Name*********/
    
    if ($user_id=='')
    {
      $json_encode = json_encode(array('status'=>0,'message'=>'Please sign in before listing your rental'));
    }
    else
    {
      $property_id = intval($this->input->post('property_id'));
      $value = $this->input->post('currency_code');
      $price = $this->input->post('price');
      
   
      $this->mobile_model->update_details(PRODUCT,array('price'=>$price,'currency'=>$value),array('id'=>$property_id));
        
      if($property_id != ''){     
      $product_id = intval($this->input->post('property_id'));
      $DateUpdateCheck = $this->mobile_model->get_all_details(PRODUCT_BOOKING,array('product_id'=>$product_id));
        
        if($DateUpdateCheck->num_rows() == '1'){
          $DateArr=$this->GetDays1($DateUpdateCheck->row()->datefrom, $DateUpdateCheck->row()->dateto); 
          $dateDispalyRowCount=0;
          if(!empty($DateArr)){
            $dateArrVAl .='{';
            foreach($DateArr as $dateDispalyRow){
              if($dateDispalyRowCount==0){
                $dateArrVAl .='"'.$dateDispalyRow.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"available"}';
              }else{
                $dateArrVAl .=',"'.$dateDispalyRow.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"available"}';
              }
              $dateDispalyRowCount=$dateDispalyRowCount+1;
            }
            $dateArrVAl .='}';
          }
          $inputArr4=array();
          $inputArr4 = array(
                'id' =>$product_id,
                'data' => trim($dateArrVAl)
          );
          //$this->mobile_model->update_details(SCHEDULE,$inputArr4,array('id'=>$product_id));
        }
      }
      $catID = $property_id;
/* schedule starts here */
        $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$catID));
      $sometime_arr = array();
      if($scheduleCheck->num_rows() >0){
        foreach($scheduleCheck->result() as $sc){ 
          $json_decode = json_decode($sc->data);
          foreach($json_decode as $key=>$value){
            if($value->status=="available"){
              $status = 1;
            }else if($value->status=="booked"){
              $status = 2;
            }else if($value->status=="unavailable"){
              $status = 3;
            }
            $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
          }
        } 
      }
/* schedule ends here */
      /* Get the property details */
      $attributes=array();
      $where1 = array('p.id'=>$catID);  
      $this->db->select('p.home_type,p.id,p.accommodates,p.room_type,p.price,p.currency,p.status,p.calendar_checked,pa.address,p.description,p.product_title,p.other_thingnote,p.house_rules,p.list_name,p.listings,pa.address,pa.country,pa.state,pa.city,pa.street,pa.zip,pa.lat,pa.lang,p.cancellation_policy,p.security_deposit,p.meta_title,p.meta_keyword,p.meta_description');
      $this->db->from(PRODUCT.' as p');
      $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
      $this->db->where($where1);
      $rental_details = $this->db->get(); 
      /* Get Cancellation Policy detail starts */
          $seourl = 'cancellation-policy';
          $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
          $cancellation_policy_description  = "";
          $cancellation_policy_title        = "";
          if($pageDetails->num_rows()>0) {
            foreach($pageDetails->result() as $page){
                $cancellation_policy_description  = $page->description;
                $cancellation_policy_title        = $page->page_title;
            }
          }
          /* Get Cancellation Policy detail ends */
      $photos = array();
      if($rental_details->num_rows() == 1) {
        $this->db->from(PRODUCT_PHOTOS);
        $this->db->where('product_id',$catID);
        $this->db->order_by('imgPriority','asc');
        $productImages = $this->db->get();
        if($productImages->num_rows()>0) {
          foreach($productImages->result() as $prd_Images){ 
            $photos[] =array("product_image_id"=>intval($prd_Images->id),"product_image"=>base_url().'server/php/rental/'.$prd_Images->product_image); 
          }
        } 
        foreach($rental_details->result() as $rental_detail){
          if($rental_detail->listings !=""){
            $attributes[] = json_decode($rental_detail->listings);          
          }
        
        $step1 = array("propertyid"=>$catID,"home_type"=>$rental_detail->home_type,"room_type"=>$rental_detail->room_type,"accommodates"=>$rental_detail->accommodates,"address"=>$rental_detail->address,"status"=>$rental_detail->status);
        $calendar_status = false;
        if($rental_detail->status == 'Publish' ){
          $calendar_status = true;
        }
        $step2 = array("propertyid"=>$catID,"calendar_checked"=>$rental_detail->calendar_checked,"dateto"=>"","datefrom"=>"","calendar_status"=>$calendar_status,"seasonal_calendar_price"=>$sometime_arr);
        $price ="";
        if($rental_detail->price !=0){
          $price = floatval($rental_detail->price);
        }
        $step3 = array("propertyid"=>$catID,"currency_code"=>$rental_detail->currency,"price"=>$price,"chk"=>"price");
        $step4 = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title,"property_description"=>$rental_detail->description,"other_thingnote"=>$rental_detail->other_thingnote,"house_rules"=>$rental_detail->house_rules);
        $step4_chk = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title);
        $step5 = array("propertyid"=>$catID,"product_image"=>$photos);
        $step6 = array("propertyid"=>$catID,"list_name"=>$rental_detail->list_name);
        $step7 = array("propertyid"=>$catID,"room_type"=>$rental_detail->room_type,"home_type"=>$rental_detail->home_type,"attribute"=>$attributes);
        $step8 = array("propertyid"=>$catID,"address"=>$rental_detail->address,"country"=>$rental_detail->country,"state"=>$rental_detail->state,"city"=>$rental_detail->city,"street"=>$rental_detail->street,"zip"=>$rental_detail->zip,"lat"=>$rental_detail->lat,"long"=>$rental_detail->lang);
        $step9 = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"meta_title"=>$rental_detail->meta_title,"meta_keyword"=>$rental_detail->meta_keyword,"meta_description"=>$rental_detail->meta_description,"property_currency"=>$rental_detail->currency,"cancellation_policy_title"=>$cancellation_policy_title,"cancellation_policy_description"=>$cancellation_policy_description);
        $step9_chk = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"property_currency"=>$rental_detail->currency);
        }
        
        $step_empty1=0;
        if (in_array('', $step1)) { $step_empty1++; }
        if($step_empty1>0){ $array1 = array("step_completed"=>false); } else { $array1 = array("step_completed"=>true); }
        $step1 = array_merge($array1, $step1); 
        
        $step22[] = $step2['calendar_checked'];
        $step_empty2=0;
        if (in_array('',$step22)) { $step_empty2++; }
        if($step_empty2>0){ $array2 = array("step_completed"=>false); } else { $array2 = array("step_completed"=>true); }
        $step2 = array_merge($array2, $step2); 
        
        $step_empty3=0;
        if (in_array('', $step3)) { $step_empty3++; }
        if($step_empty3>0){ $array3 = array("step_completed"=>false); } else { $array3 = array("step_completed"=>true); }
        $step3 = array_merge($array3, $step3); 
        
        $step_empty4=0;
        if (in_array('', $step4_chk)) { $step_empty4++; }
        if($step_empty4>0){ $array4 = array("step_completed"=>false); } else { $array4 = array("step_completed"=>true); }
        $step4 = array_merge($array4, $step4); 
        
        $step_empty5=0;
        if (empty($photos)) { $step_empty5++; }
        if($step_empty5>0){ $array5 = array("step_completed"=>false); } else { $array5 = array("step_completed"=>true); }
        $step5 = array_merge($array5, $step5); 
        
        
        $step_empty6=0;
        if (in_array('', $step6)) { $step_empty6++; }
        if($step_empty6>0){ $array6 = array("step_completed"=>false); } else { $array6 = array("step_completed"=>true); }
        $step6 = array_merge($array6, $step6); 
        
        $step_empty7=0;
         
        if (empty($attributes)) { $step_empty7++; }
        //if (in_array('', $step7)) { $step_empty7++; }
        if($step_empty7>0){ $array7 = array("step_completed"=>false); } else { $array7 = array("step_completed"=>true); }
        $step7 = array_merge($array7, $step7); 
        
        $step_empty8=0;
        if (in_array('', $step8)) { $step_empty8++; }
        if($step_empty8>0){ $array8 = array("step_completed"=>false); } else { $array8 = array("step_completed"=>true); }
        $step8 = array_merge($array8, $step8); 
        
        $step_empty9=0;
        if (in_array('', $step9_chk)) { $step_empty9++; }
        if($step_empty9>0){ $array9 = array("step_completed"=>false); } else { $array9 = array("step_completed"=>true); }
        $step9 = array_merge($array9, $step9); 
        
        
        $result_arr[] = array("step1"=>$step1,"step2"=>$step2,"step3"=>$step3,"step4"=>$step4,"step5"=>$step5,"step6"=>$step6,"step7"=>$step7,"step8"=>$step8,"step9"=>$step9);
      
        $json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$catID,"result"=>$result_arr,"property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"property_attributes" => $property_attributes,"currency" =>$currencyvalueArr)); 
        
      } else {
        $json_encode = json_encode(array('status'=>0,'message'=>'No data found',"propertyid"=>"")); 
      }
      echo $json_encode;
    }
    
  }
  /* ADD PROPERTY STEP4 OVERVIEW */ 
  public function mobile_add_property_step4()
  {
    $user_id =$this->input->post('user_id');
    $property_id = intval($this->input->post('property_id'));
    $title = $this->input->post('title');
    $description = $this->input->post('description');
    
    $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
    $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
    
    $currencyvalueArr = array();
    if($currency_values->num_rows() >0) {
      foreach($currency_values->result() as $cur_value) {
      $currencyvalueArr[] = array("id" =>$cur_value->id,"country_symbols"=>$cur_value->currency_symbols,"currency_type"=>$cur_value->currency_type);
      }
    } 
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($property_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($property_listvalue->result() as $prty) {
              $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    }
    
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
    $roombedVal=array();
    $roombedVal1=array();
    $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as   $list){
        $roombedVal[] =json_decode($list->listing_values);
        $roombedVal1[] =json_decode($list->rooms_bed);
      }
    }
	
	/***********Charles 18-3-2017 Parent Name*********/
	$select_qrys = "select * from fc_listing_types WHERE status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		  
		  
	/***********Charles 18-3-2017 Child Name*********/
	/***********Charles 2-3-2017 Child Name*********/
	$select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    if($list_valuesy->num_rows()>0){
		
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		  $listing_child_type = $listing_child->type;
		  $listing_child_labelname = $listing_child->labelname;
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);
		
		  
		  
		  
		 
		
	  }
	  
	$property_attributes[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	}
	/***********Charles 18-3-2017 Parent Name*********/
    
    if ($user_id=='')
    {
      $json_encode = json_encode(array('status'=>0,'message'=>'Please sign in before listing your rental'));
    }
    else
    {
    
      $property_id = intval($this->input->post('property_id'));
      $title = $this->input->post('title');
      $description = $this->input->post('description');
      $other_thingnote = $this->input->post('other_thingnote');
      $house_rules = $this->input->post('house_rules');
      if($property_id !="") {
        $seourl = url_title($title, '-', TRUE); 
        $this->mobile_model->update_details(PRODUCT,array('product_title'=>$title,'seourl'=>$seourl,'description'=>$description,"other_thingnote"=>$other_thingnote,"house_rules"=>$house_rules),array('id'=>$property_id));
        
      }
      $catID = $property_id;
/* schedule starts here */
        $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$catID));
      $sometime_arr = array();
      if($scheduleCheck->num_rows() >0){
        foreach($scheduleCheck->result() as $sc){ 
          $json_decode = json_decode($sc->data);
          foreach($json_decode as $key=>$value){
            if($value->status=="available"){
              $status = 1;
            }else if($value->status=="booked"){
              $status = 2;
            }else if($value->status=="unavailable"){
              $status = 3;
            }
            $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
          }
        } 
      }
  /* schedule ends here */
      /* Get the property details */
      $attributes=array();
      $where1 = array('p.id'=>$catID);  
      $this->db->select('p.home_type,p.id,p.accommodates,p.room_type,p.price,p.currency,p.status,p.calendar_checked,pa.address,p.description,p.product_title,p.other_thingnote,p.house_rules,p.list_name,p.listings,pa.address,pa.country,pa.state,pa.city,pa.street,pa.zip,pa.lat,pa.lang,p.cancellation_policy,p.security_deposit,p.meta_title,p.meta_keyword,p.meta_description');
      $this->db->from(PRODUCT.' as p');
      $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
      $this->db->where($where1);
      $rental_details = $this->db->get(); 
       /* Get Cancellation Policy detail starts */
          $seourl = 'cancellation-policy';
          $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
          $cancellation_policy_description  = "";
          $cancellation_policy_title        = "";
          if($pageDetails->num_rows()>0) {
            foreach($pageDetails->result() as $page){
                $cancellation_policy_description  = $page->description;
                $cancellation_policy_title        = $page->page_title;
            }
          }
          /* Get Cancellation Policy detail ends */
      $photos = array();
      if($rental_details->num_rows() == 1) {
        $this->db->from(PRODUCT_PHOTOS);
        $this->db->where('product_id',$catID);
        $this->db->order_by('imgPriority','asc');
        $productImages = $this->db->get();
        if($productImages->num_rows()>0) {
          foreach($productImages->result() as $prd_Images){ 
            $photos[] =array("product_image_id"=>intval($prd_Images->id),"product_image"=>base_url().'server/php/rental/'.$prd_Images->product_image); 
          }
        } 
        foreach($rental_details->result() as $rental_detail){
          if($rental_detail->listings !=""){
            $attributes[] = json_decode($rental_detail->listings);          
          }
        
        $step1 = array("propertyid"=>$catID,"home_type"=>$rental_detail->home_type,"room_type"=>$rental_detail->room_type,"accommodates"=>$rental_detail->accommodates,"address"=>$rental_detail->address,"status"=>$rental_detail->status);
      	$calendar_status = false;
        if($rental_detail->status == 'Publish' ){
          $calendar_status = true;
        }
        $step2 = array("propertyid"=>$catID,"calendar_checked"=>$rental_detail->calendar_checked,"dateto"=>"","datefrom"=>"","calendar_status"=>$calendar_status,"seasonal_calendar_price"=>$sometime_arr);
        
        $price ="";
        if($rental_detail->price !=0){
          $price = floatval($rental_detail->price);
        }
        $step3 = array("propertyid"=>$catID,"currency_code"=>$rental_detail->currency,"price"=>$price,"chk"=>"price");
        $step4 = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title,"property_description"=>$rental_detail->description,"other_thingnote"=>$rental_detail->other_thingnote,"house_rules"=>$rental_detail->house_rules);
        $step4_chk = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title);
        $step5 = array("propertyid"=>$catID,"product_image"=>$photos);
        $step6 = array("propertyid"=>$catID,"list_name"=>$rental_detail->list_name);
        $step7 = array("propertyid"=>$catID,"room_type"=>$rental_detail->room_type,"home_type"=>$rental_detail->home_type,"attribute"=>$attributes);
        $step8 = array("propertyid"=>$catID,"address"=>$rental_detail->address,"country"=>$rental_detail->country,"state"=>$rental_detail->state,"city"=>$rental_detail->city,"street"=>$rental_detail->street,"zip"=>$rental_detail->zip,"lat"=>$rental_detail->lat,"long"=>$rental_detail->lang);
        $step9 = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"meta_title"=>$rental_detail->meta_title,"meta_keyword"=>$rental_detail->meta_keyword,"meta_description"=>$rental_detail->meta_description,"property_currency"=>$rental_detail->currency,"cancellation_policy_title"=>$cancellation_policy_title,"cancellation_policy_description"=>$cancellation_policy_description);
        $step9_chk = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"property_currency"=>$rental_detail->currency);
        }
        
        $step_empty1=0;
        if (in_array('', $step1)) { $step_empty1++; }
        if($step_empty1>0){ $array1 = array("step_completed"=>false); } else { $array1 = array("step_completed"=>true); }
        $step1 = array_merge($array1, $step1); 
        
        $step22[] = $step2['calendar_checked'];
        $step_empty2=0;
        if (in_array('',$step22)) { $step_empty2++; }
        if($step_empty2>0){ $array2 = array("step_completed"=>false); } else { $array2 = array("step_completed"=>true); }
        $step2 = array_merge($array2, $step2); 
        
        $step_empty3=0;
        if (in_array('', $step3)) { $step_empty3++; }
        if($step_empty3>0){ $array3 = array("step_completed"=>false); } else { $array3 = array("step_completed"=>true); }
        $step3 = array_merge($array3, $step3); 
        
        $step_empty4=0;
        if (in_array('', $step4_chk)) { $step_empty4++; }
        if($step_empty4>0){ $array4 = array("step_completed"=>false); } else { $array4 = array("step_completed"=>true); }
        $step4 = array_merge($array4, $step4); 
        
        $step_empty5=0;
        if (empty($photos)) { $step_empty5++; }
        if($step_empty5>0){ $array5 = array("step_completed"=>false); } else { $array5 = array("step_completed"=>true); }
        $step5 = array_merge($array5, $step5); 
        
        
        $step_empty6=0;
        if (in_array('', $step6)) { $step_empty6++; }
        if($step_empty6>0){ $array6 = array("step_completed"=>false); } else { $array6 = array("step_completed"=>true); }
        $step6 = array_merge($array6, $step6); 
        
        $step_empty7=0;
         
        if (empty($attributes)) { $step_empty7++; }
        //if (in_array('', $step7)) { $step_empty7++; }
        if($step_empty7>0){ $array7 = array("step_completed"=>false); } else { $array7 = array("step_completed"=>true); }
        $step7 = array_merge($array7, $step7); 
        
        $step_empty8=0;
        if (in_array('', $step8)) { $step_empty8++; }
        if($step_empty8>0){ $array8 = array("step_completed"=>false); } else { $array8 = array("step_completed"=>true); }
        $step8 = array_merge($array8, $step8); 
        
        $step_empty9=0;
        if (in_array('', $step9_chk)) { $step_empty9++; }
        if($step_empty9>0){ $array9 = array("step_completed"=>false); } else { $array9 = array("step_completed"=>true); }
        $step9 = array_merge($array9, $step9); 
        
        
        $result_arr[] = array("step1"=>$step1,"step2"=>$step2,"step3"=>$step3,"step4"=>$step4,"step5"=>$step5,"step6"=>$step6,"step7"=>$step7,"step8"=>$step8,"step9"=>$step9);
      
        $json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$catID,"result"=>$result_arr,"property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"property_attributes" => $property_attributes,"currency" =>$currencyvalueArr)); 
        
      } else {
        $json_encode = json_encode(array('status'=>0,'message'=>'No data found',"propertyid"=>"")); 
      }
    }
    echo $json_encode;
  }
  /* ADD PROPERTY STEP5 PHOTOS */ 
  public function mobile_add_property_step5() {
    
    $prd_id = intval($this->input->post('property_id'));
    $user_id =$this->input->post('user_id');
    
    if ($user_id=='')
    {
      $json_encode = json_encode(array('status'=>0,'message'=>'Please sign in before listing your rental'));
      echo $json_encode;
      exit;
    }
    $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
    $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
    
    $currencyvalueArr = array();
    if($currency_values->num_rows() >0) {
      foreach($currency_values->result() as $cur_value) {
      $currencyvalueArr[] = array("id" =>$cur_value->id,"country_symbols"=>$cur_value->currency_symbols,"currency_type"=>$cur_value->currency_type);
      }
    } 
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($property_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($property_listvalue->result() as $prty) {
              $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    }
    
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
    $roombedVal=array();
    $roombedVal1=array();
    $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as   $list){
        $roombedVal[] =json_decode($list->listing_values);
        $roombedVal1[] =json_decode($list->rooms_bed);
      }
    }
	
	/***********Charles 18-3-2017 Parent Name*********/
	$select_qrys = "select * from fc_listing_types WHERE status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		  
		  
	/***********Charles 18-3-2017 Child Name*********/
	/***********Charles 2-3-2017 Child Name*********/
	$select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    if($list_valuesy->num_rows()>0){
		
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		  $listing_child_type = $listing_child->type;
		  $listing_child_labelname = $listing_child->labelname;
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);
		
		  
		  
		  
		 
		
	  }
	  
	$property_attributes[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	}
	/***********Charles 18-3-2017 Parent Name*********/
    
    if($_POST['photos'] != '') {
      $arr_image = explode(',',$_POST['photos']);
      if (!empty($arr_image)) {
        $i=0;
        foreach($arr_image as $img){
          $image_name= time().$i.".jpg";
          $ifp = fopen("server/php/rental/".$image_name, "wb" ); 
          fwrite( $ifp, base64_decode( $img) ); 
          fclose( $ifp ); 
          mysql_query("INSERT INTO fc_rental_photos(product_image,product_id) VALUES('$image_name','$prd_id')");
          $i++;
        }
      }
    }
    $catID = $prd_id;
/* schedule starts here */
      $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$catID));
    $sometime_arr = array();
    if($scheduleCheck->num_rows() >0){
      foreach($scheduleCheck->result() as $sc){ 
        $json_decode = json_decode($sc->data);
        foreach($json_decode as $key=>$value){
          if($value->status=="available"){
            $status = 1;
          }else if($value->status=="booked"){
            $status = 2;
          }else if($value->status=="unavailable"){
            $status = 3;
          }
          $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
        }
      } 
    }
/* schedule ends here */
    /* Get the property details */
    $attributes=array();
    $where1 = array('p.id'=>$catID);  
    $this->db->select('p.home_type,p.id,p.accommodates,p.room_type,p.price,p.currency,p.status,p.calendar_checked,pa.address,p.description,p.product_title,p.other_thingnote,p.house_rules,p.list_name,p.listings,pa.address,pa.country,pa.state,pa.city,pa.street,pa.zip,pa.lat,pa.lang,p.cancellation_policy,p.security_deposit,p.meta_title,p.meta_keyword,p.meta_description');
    $this->db->from(PRODUCT.' as p');
    $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
    $this->db->where($where1);
    $rental_details = $this->db->get();
     /* Get Cancellation Policy detail starts */
          $seourl = 'cancellation-policy';
          $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
          $cancellation_policy_description  = "";
          $cancellation_policy_title        = "";
          if($pageDetails->num_rows()>0) {
            foreach($pageDetails->result() as $page){
                $cancellation_policy_description  = $page->description;
                $cancellation_policy_title        = $page->page_title;
            }
          }
          /* Get Cancellation Policy detail ends */ 
    $photos = array();
    if($rental_details->num_rows() == 1) {
      $this->db->from(PRODUCT_PHOTOS);
      $this->db->where('product_id',$catID);
      $this->db->order_by('imgPriority','asc');
      $productImages = $this->db->get();
      if($productImages->num_rows()>0) {
        foreach($productImages->result() as $prd_Images){ 
          $photos[] =array("product_image_id"=>intval($prd_Images->id),"product_image"=>base_url().'server/php/rental/'.$prd_Images->product_image); 
        }
      } 
      foreach($rental_details->result() as $rental_detail){
        if($rental_detail->listings !=""){
          $attributes[] = json_decode($rental_detail->listings);          
        }
      
      $step1 = array("propertyid"=>$catID,"home_type"=>$rental_detail->home_type,"room_type"=>$rental_detail->room_type,"accommodates"=>$rental_detail->accommodates,"address"=>$rental_detail->address,"status"=>$rental_detail->status);
      $calendar_status = false;
      if($rental_detail->status == 'Publish' ){
        $calendar_status = true;
      }
      $step2 = array("propertyid"=>$catID,"calendar_checked"=>$rental_detail->calendar_checked,"dateto"=>"","datefrom"=>"","calendar_status"=>$calendar_status,"seasonal_calendar_price"=>$sometime_arr);
      $price ="";
      if($rental_detail->price !=0){
        $price = floatval($rental_detail->price);
      }
      $step3 = array("propertyid"=>$catID,"currency_code"=>$rental_detail->currency,"price"=>$price,"chk"=>"price");
      $step4 = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title,"property_description"=>$rental_detail->description,"other_thingnote"=>$rental_detail->other_thingnote,"house_rules"=>$rental_detail->house_rules);
      $step4_chk = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title);
      $step5 = array("propertyid"=>$catID,"product_image"=>$photos);
      $step6 = array("propertyid"=>$catID,"list_name"=>$rental_detail->list_name);
      $step7 = array("propertyid"=>$catID,"room_type"=>$rental_detail->room_type,"home_type"=>$rental_detail->home_type,"attribute"=>$attributes);
      $step8 = array("propertyid"=>$catID,"address"=>$rental_detail->address,"country"=>$rental_detail->country,"state"=>$rental_detail->state,"city"=>$rental_detail->city,"street"=>$rental_detail->street,"zip"=>$rental_detail->zip,"lat"=>$rental_detail->lat,"long"=>$rental_detail->lang);
      $step9 = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"meta_title"=>$rental_detail->meta_title,"meta_keyword"=>$rental_detail->meta_keyword,"meta_description"=>$rental_detail->meta_description,"property_currency"=>$rental_detail->currency,"cancellation_policy_title"=>$cancellation_policy_title,"cancellation_policy_description"=>$cancellation_policy_description);
      $step9_chk = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"property_currency"=>$rental_detail->currency);
      }
      
      $step_empty1=0;
      if (in_array('', $step1)) { $step_empty1++; }
      if($step_empty1>0){ $array1 = array("step_completed"=>false); } else { $array1 = array("step_completed"=>true); }
      $step1 = array_merge($array1, $step1); 
      
      $step22[] = $step2['calendar_checked'];
      $step_empty2=0;
      if (in_array('',$step22)) { $step_empty2++; }
      if($step_empty2>0){ $array2 = array("step_completed"=>false); } else { $array2 = array("step_completed"=>true); }
      $step2 = array_merge($array2, $step2); 
      
      $step_empty3=0;
      if (in_array('', $step3)) { $step_empty3++; }
      if($step_empty3>0){ $array3 = array("step_completed"=>false); } else { $array3 = array("step_completed"=>true); }
      $step3 = array_merge($array3, $step3); 
      
      $step_empty4=0;
      if (in_array('', $step4_chk)) { $step_empty4++; }
      if($step_empty4>0){ $array4 = array("step_completed"=>false); } else { $array4 = array("step_completed"=>true); }
      $step4 = array_merge($array4, $step4); 
      
      $step_empty5=0;
      if (empty($photos)) { $step_empty5++; }
      if($step_empty5>0){ $array5 = array("step_completed"=>false); } else { $array5 = array("step_completed"=>true); }
      $step5 = array_merge($array5, $step5); 
      
      
      $step_empty6=0;
      if (in_array('', $step6)) { $step_empty6++; }
      if($step_empty6>0){ $array6 = array("step_completed"=>false); } else { $array6 = array("step_completed"=>true); }
      $step6 = array_merge($array6, $step6); 
      
      $step_empty7=0;
       
      if (empty($attributes)) { $step_empty7++; }
      //if (in_array('', $step7)) { $step_empty7++; }
      if($step_empty7>0){ $array7 = array("step_completed"=>false); } else { $array7 = array("step_completed"=>true); }
      $step7 = array_merge($array7, $step7); 
      
      $step_empty8=0;
      if (in_array('', $step8)) { $step_empty8++; }
      if($step_empty8>0){ $array8 = array("step_completed"=>false); } else { $array8 = array("step_completed"=>true); }
      $step8 = array_merge($array8, $step8); 
      
      $step_empty9=0;
      if (in_array('', $step9_chk)) { $step_empty9++; }
      if($step_empty9>0){ $array9 = array("step_completed"=>false); } else { $array9 = array("step_completed"=>true); }
      $step9 = array_merge($array9, $step9); 
      
      
      $result_arr[] = array("step1"=>$step1,"step2"=>$step2,"step3"=>$step3,"step4"=>$step4,"step5"=>$step5,"step6"=>$step6,"step7"=>$step7,"step8"=>$step8,"step9"=>$step9);
    
      $json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$catID,"result"=>$result_arr,"property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"property_attributes" => $property_attributes,"currency" =>$currencyvalueArr)); 
    } else {
      $json_encode = json_encode(array('status'=>0,'message'=>'No data found',"propertyid"=>"")); 
    }
    echo $json_encode; 
    exit;
  }
  /* ADD PROPERTY STEP6 Amenities list */ 
  public function mobile_add_property_step6() 
  {
    $property_id = intval($this->input->post('id'));
    $user_id =$this->input->post('user_id');
    $device_type =$this->input->post('device_type');
    $currency_code =$this->input->post('currency_code');
    
    $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
    $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
    
    $currencyvalueArr = array();
    if($currency_values->num_rows() >0) {
      foreach($currency_values->result() as $cur_value) {
      $currencyvalueArr[] = array("id" =>$cur_value->id,"country_symbols"=>$cur_value->currency_symbols,"currency_type"=>$cur_value->currency_type);
      }
    } 
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($property_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($property_listvalue->result() as $prty) {
              $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    }
    
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
    $roombedVal=array();
    $roombedVal1=array();
    $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as   $list){
        $roombedVal[] =json_decode($list->listing_values);
        $roombedVal1[] =json_decode($list->rooms_bed);
      }
    }
	
	/***********Charles 18-3-2017 Parent Name*********/
	$select_qrys = "select * from fc_listing_types WHERE status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		   
		  
	/***********Charles 18-3-2017 Child Name*********/
	/***********Charles 2-3-2017 Child Name*********/
	$select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    if($list_valuesy->num_rows()>0){
		
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		  $listing_child_type = $listing_child->type;
		  $listing_child_labelname = $listing_child->labelname;
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);
		
		  
		  
		  
		 
		
	  }
	  
	$property_attributes[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	}
	/***********Charles 18-3-2017 Parent Name*********/
    
    if ($user_id=='')
    {
      $json_encode = json_encode(array('status'=>0,'message'=>'Please sign in before listing your rental'));
    } else {
      $excludeArr = array('string','id');
      $dataArr = array('list_name' => $this->input->post('string'));
    
      $condition=array('id'=>$property_id);
      $this->mobile_model->update_details(PRODUCT,array('list_name'=>$this->input->post('string')),array('id' => $property_id));
      //$this->mobile_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,$dataArr,$condition);
      $catID = $property_id;

/* schedule starts here */
      $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$catID));
    $sometime_arr = array();
    if($scheduleCheck->num_rows() >0){
      foreach($scheduleCheck->result() as $sc){ 
        $json_decode = json_decode($sc->data);
        foreach($json_decode as $key=>$value){
          if($value->status=="available"){
            $status = 1;
          }else if($value->status=="booked"){
            $status = 2;
          }else if($value->status=="unavailable"){
            $status = 3;
          }
          $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
        }
      } 
    }
/* schedule ends here */
      /* Get the property details */
      $attributes=array();
      $where1 = array('p.id'=>$catID);  
      $this->db->select('p.home_type,p.id,p.accommodates,p.room_type,p.price,p.currency,p.status,p.calendar_checked,pa.address,p.description,p.product_title,p.other_thingnote,p.house_rules,p.list_name,p.listings,pa.address,pa.country,pa.state,pa.city,pa.street,pa.zip,pa.lat,pa.lang,p.cancellation_policy,p.security_deposit,p.meta_title,p.meta_keyword,p.meta_description');
      $this->db->from(PRODUCT.' as p');
      $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
      $this->db->where($where1);
      $rental_details = $this->db->get(); 
       /* Get Cancellation Policy detail starts */
          $seourl = 'cancellation-policy';
          $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
          $cancellation_policy_description  = "";
          $cancellation_policy_title        = "";
          if($pageDetails->num_rows()>0) {
            foreach($pageDetails->result() as $page){
                $cancellation_policy_description  = $page->description;
                $cancellation_policy_title        = $page->page_title;
            }
          }
          /* Get Cancellation Policy detail ends */
      $photos = array();
      if($rental_details->num_rows() == 1) {
        $this->db->from(PRODUCT_PHOTOS);
        $this->db->where('product_id',$catID);
        $this->db->order_by('imgPriority','asc');
        $productImages = $this->db->get();
        if($productImages->num_rows()>0) {
          foreach($productImages->result() as $prd_Images){ 
            $photos[] =array("product_image_id"=>intval($prd_Images->id),"product_image"=>base_url().'server/php/rental/'.$prd_Images->product_image); 
          }
        } 
        foreach($rental_details->result() as $rental_detail){
          if($rental_detail->listings !=""){
            $attributes[] = json_decode($rental_detail->listings);          
          }
        
        $step1 = array("propertyid"=>$catID,"home_type"=>$rental_detail->home_type,"room_type"=>$rental_detail->room_type,"accommodates"=>$rental_detail->accommodates,"address"=>$rental_detail->address,"status"=>$rental_detail->status);
       	$calendar_status = false;
        if($rental_detail->status == 'Publish' ){
          $calendar_status = true;
        }
        $step2 = array("propertyid"=>$catID,"calendar_checked"=>$rental_detail->calendar_checked,"dateto"=>"","datefrom"=>"","calendar_status"=>$calendar_status,"seasonal_calendar_price"=>$sometime_arr);
        $price ="";
        if($rental_detail->price !=0){
          $price = floatval($rental_detail->price);
        }
        $step3 = array("propertyid"=>$catID,"currency_code"=>$rental_detail->currency,"price"=>$price,"chk"=>"price");
        $step4 = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title,"property_description"=>$rental_detail->description,"other_thingnote"=>$rental_detail->other_thingnote,"house_rules"=>$rental_detail->house_rules);
        $step4_chk = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title);
        $step5 = array("propertyid"=>$catID,"product_image"=>$photos);
        $step6 = array("propertyid"=>$catID,"list_name"=>$rental_detail->list_name);
        $step7 = array("propertyid"=>$catID,"room_type"=>$rental_detail->room_type,"home_type"=>$rental_detail->home_type,"attribute"=>$attributes);
        $step8 = array("propertyid"=>$catID,"address"=>$rental_detail->address,"country"=>$rental_detail->country,"state"=>$rental_detail->state,"city"=>$rental_detail->city,"street"=>$rental_detail->street,"zip"=>$rental_detail->zip,"lat"=>$rental_detail->lat,"long"=>$rental_detail->lang);
        $step9 = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"meta_title"=>$rental_detail->meta_title,"meta_keyword"=>$rental_detail->meta_keyword,"meta_description"=>$rental_detail->meta_description,"property_currency"=>$rental_detail->currency,"cancellation_policy_title"=>$cancellation_policy_title,"cancellation_policy_description"=>$cancellation_policy_description);
        $step9_chk = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"property_currency"=>$rental_detail->currency);
        }
        
        $step_empty1=0;
        if (in_array('', $step1)) { $step_empty1++; }
        if($step_empty1>0){ $array1 = array("step_completed"=>false); } else { $array1 = array("step_completed"=>true); }
        $step1 = array_merge($array1, $step1); 
        
        $step22[] = $step2['calendar_checked'];
        $step_empty2=0;
        if (in_array('',$step22)) { $step_empty2++; }
        if($step_empty2>0){ $array2 = array("step_completed"=>false); } else { $array2 = array("step_completed"=>true); }
        $step2 = array_merge($array2, $step2); 
        
        $step_empty3=0;
        if (in_array('', $step3)) { $step_empty3++; }
        if($step_empty3>0){ $array3 = array("step_completed"=>false); } else { $array3 = array("step_completed"=>true); }
        $step3 = array_merge($array3, $step3); 
        
        $step_empty4=0;
        if (in_array('', $step4_chk)) { $step_empty4++; }
        if($step_empty4>0){ $array4 = array("step_completed"=>false); } else { $array4 = array("step_completed"=>true); }
        $step4 = array_merge($array4, $step4); 
        
        $step_empty5=0;
        if (empty($photos)) { $step_empty5++; }
        if($step_empty5>0){ $array5 = array("step_completed"=>false); } else { $array5 = array("step_completed"=>true); }
        $step5 = array_merge($array5, $step5); 
        
        
        $step_empty6=0;
        if (in_array('', $step6)) { $step_empty6++; }
        if($step_empty6>0){ $array6 = array("step_completed"=>false); } else { $array6 = array("step_completed"=>true); }
        $step6 = array_merge($array6, $step6); 
        
        $step_empty7=0;
         
        if (empty($attributes)) { $step_empty7++; }
        //if (in_array('', $step7)) { $step_empty7++; }
        if($step_empty7>0){ $array7 = array("step_completed"=>false); } else { $array7 = array("step_completed"=>true); }
        $step7 = array_merge($array7, $step7); 
        
        $step_empty8=0;
        if (in_array('', $step8)) { $step_empty8++; }
        if($step_empty8>0){ $array8 = array("step_completed"=>false); } else { $array8 = array("step_completed"=>true); }
        $step8 = array_merge($array8, $step8); 
        
        $step_empty9=0;
        if (in_array('', $step9_chk)) { $step_empty9++; }
        if($step_empty9>0){ $array9 = array("step_completed"=>false); } else { $array9 = array("step_completed"=>true); }
        $step9 = array_merge($array9, $step9); 
        
        
        $result_arr[] = array("step1"=>$step1,"step2"=>$step2,"step3"=>$step3,"step4"=>$step4,"step5"=>$step5,"step6"=>$step6,"step7"=>$step7,"step8"=>$step8,"step9"=>$step9);
      
        $json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$catID,"result"=>$result_arr,"property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"property_attributes" => $property_attributes,"currency" =>$currencyvalueArr)); 
        
      } else {
        $json_encode = json_encode(array('status'=>0,'message'=>'No data found',"propertyid"=>"")); 
      }
    }
    echo $json_encode;
  }
  /* ADD PROPERTY STEP7 Listing info */ 
  public function mobile_add_property_step7()
  {
    $user_id = $this->input->post('user_id');
    
    $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
    $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
    
    $currencyvalueArr = array();
    if($currency_values->num_rows() >0) {
      foreach($currency_values->result() as $cur_value) {
      $currencyvalueArr[] = array("id" =>$cur_value->id,"country_symbols"=>$cur_value->currency_symbols,"currency_type"=>$cur_value->currency_type);
      }
    } 
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($property_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($property_listvalue->result() as $prty) {
              $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    }
    
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
    $roombedVal=array();
    $roombedVal1=array();
    $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as   $list){
        $roombedVal[] =json_decode($list->listing_values);
        $roombedVal1[] =json_decode($list->rooms_bed);
      }
    }
	
	/***********Charles 18-3-2017 Parent Name*********/
	$select_qrys = "select * from fc_listing_types WHERE status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		  
		  
	/***********Charles 18-3-2017 Child Name*********/
	/***********Charles 2-3-2017 Child Name*********/
	$select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    if($list_valuesy->num_rows()>0){
		
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		  $listing_child_type = $listing_child->type;
		  $listing_child_labelname = $listing_child->labelname;
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);
		
		  
		  
		  
		 
		
	  }
	  
	$property_attributes[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	}
	/***********Charles 18-3-2017 Parent Name*********/
    
    if ($user_id=='')
    {
      $json_encode = json_encode(array('status'=>0,'message'=>'Please sign in before listing your rental'));
    } else {
      $property_id = intval($this->input->post('property_id'));
      $room_type = $this->input->post('room_type');
      $property_type = $this->input->post('property_type');
      $attr_values = $this->input->post('attribute');
      $attribute = json_decode($this->input->post('attribute'),true);
      if($attr_values !="") {
        foreach($attribute as $attributeTableName => $attributeTablevalue )
        {
          if($attributeTableName == "minimum_stay") {
            $this->mobile_model->update_details(PRODUCT,array('minimum_stay'=>$attributeTablevalue),array('id' => $property_id));
          }
          /* if($attributeTableName == "accommodates") {              $this->mobile_model->update_details(PRODUCT,array('accommodates'=>$attributeTablevalue),array('id' => $property_id));
          }
          */
        }
      }
      
      $FinalsValues= array('listings'=>$attr_values,"room_type"=>$room_type,"home_type"=>$property_type);
      $this->mobile_model->update_details(PRODUCT, $FinalsValues, array('id' => $property_id));
      $catID = $property_id;
/* schedule starts here */
      $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$catID));
    $sometime_arr = array();
    if($scheduleCheck->num_rows() >0){
      foreach($scheduleCheck->result() as $sc){ 
        $json_decode = json_decode($sc->data);
        foreach($json_decode as $key=>$value){
          if($value->status=="available"){
            $status = 1;
          }else if($value->status=="booked"){
            $status = 2;
          }else if($value->status=="unavailable"){
            $status = 3;
          }
          $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
        }
      } 
    }
/* schedule ends here */
      /* Get the property details */
      $attributes=array();
      $where1 = array('p.id'=>$catID);  
      $this->db->select('p.home_type,p.id,p.accommodates,p.room_type,p.price,p.currency,p.status,p.calendar_checked,pa.address,p.description,p.product_title,p.other_thingnote,p.house_rules,p.list_name,p.listings,pa.address,pa.country,pa.state,pa.city,pa.street,pa.zip,pa.lat,pa.lang,p.cancellation_policy,p.security_deposit,p.meta_title,p.meta_keyword,p.meta_description');
      $this->db->from(PRODUCT.' as p');
      $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
      $this->db->where($where1);
      $rental_details = $this->db->get(); 
       /* Get Cancellation Policy detail starts */
          $seourl = 'cancellation-policy';
          $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
          $cancellation_policy_description  = "";
          $cancellation_policy_title        = "";
          if($pageDetails->num_rows()>0) {
            foreach($pageDetails->result() as $page){
                $cancellation_policy_description  = $page->description;
                $cancellation_policy_title        = $page->page_title;
            }
          }
          /* Get Cancellation Policy detail ends */
      $photos = array();
      if($rental_details->num_rows() == 1) {
        $this->db->from(PRODUCT_PHOTOS);
        $this->db->where('product_id',$catID);
        $this->db->order_by('imgPriority','asc');
        $productImages = $this->db->get();
        if($productImages->num_rows()>0) {
          foreach($productImages->result() as $prd_Images){ 
            $photos[] =array("product_image_id"=>intval($prd_Images->id),"product_image"=>base_url().'server/php/rental/'.$prd_Images->product_image); 
          }
        } 
        foreach($rental_details->result() as $rental_detail){
          if($rental_detail->listings !=""){
            $attributes[] = json_decode($rental_detail->listings);          
          }
        
        $step1 = array("propertyid"=>$catID,"home_type"=>$rental_detail->home_type,"room_type"=>$rental_detail->room_type,"accommodates"=>$rental_detail->accommodates,"address"=>$rental_detail->address,"status"=>$rental_detail->status);
        $calendar_status = false;
        if($rental_detail->status == 'Publish' ){
          $calendar_status = true;
        }
        $step2 = array("propertyid"=>$catID,"calendar_checked"=>$rental_detail->calendar_checked,"dateto"=>"","datefrom"=>"","calendar_status"=>$calendar_status,"seasonal_calendar_price"=>$sometime_arr);
       
        $price ="";
        if($rental_detail->price !=0){
          $price = floatval($rental_detail->price);
        }
        $step3 = array("propertyid"=>$catID,"currency_code"=>$rental_detail->currency,"price"=>$price,"chk"=>"price");
        $step4 = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title,"property_description"=>$rental_detail->description,"other_thingnote"=>$rental_detail->other_thingnote,"house_rules"=>$rental_detail->house_rules);
        $step4_chk = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title);
        $step5 = array("propertyid"=>$catID,"product_image"=>$photos);
        $step6 = array("propertyid"=>$catID,"list_name"=>$rental_detail->list_name);
        $step7 = array("propertyid"=>$catID,"room_type"=>$rental_detail->room_type,"home_type"=>$rental_detail->home_type,"attribute"=>$attributes);
        $step8 = array("propertyid"=>$catID,"address"=>$rental_detail->address,"country"=>$rental_detail->country,"state"=>$rental_detail->state,"city"=>$rental_detail->city,"street"=>$rental_detail->street,"zip"=>$rental_detail->zip,"lat"=>$rental_detail->lat,"long"=>$rental_detail->lang);
        $step9 = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"meta_title"=>$rental_detail->meta_title,"meta_keyword"=>$rental_detail->meta_keyword,"meta_description"=>$rental_detail->meta_description,"property_currency"=>$rental_detail->currency,"cancellation_policy_title"=>$cancellation_policy_title,"cancellation_policy_description"=>$cancellation_policy_description);
        $step9_chk = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"property_currency"=>$rental_detail->currency);
        }
        
        $step_empty1=0;
        if (in_array('', $step1)) { $step_empty1++; }
        if($step_empty1>0){ $array1 = array("step_completed"=>false); } else { $array1 = array("step_completed"=>true); }
        $step1 = array_merge($array1, $step1); 
        
        $step22[] = $step2['calendar_checked'];
        $step_empty2=0;
        if (in_array('',$step22)) { $step_empty2++; }
        if($step_empty2>0){ $array2 = array("step_completed"=>false); } else { $array2 = array("step_completed"=>true); }
        $step2 = array_merge($array2, $step2); 
        
        $step_empty3=0;
        if (in_array('', $step3)) { $step_empty3++; }
        if($step_empty3>0){ $array3 = array("step_completed"=>false); } else { $array3 = array("step_completed"=>true); }
        $step3 = array_merge($array3, $step3); 
        
        $step_empty4=0;
        if (in_array('', $step4_chk)) { $step_empty4++; }
        if($step_empty4>0){ $array4 = array("step_completed"=>false); } else { $array4 = array("step_completed"=>true); }
        $step4 = array_merge($array4, $step4); 
        
        $step_empty5=0;
        if (empty($photos)) { $step_empty5++; }
        if($step_empty5>0){ $array5 = array("step_completed"=>false); } else { $array5 = array("step_completed"=>true); }
        $step5 = array_merge($array5, $step5); 
        
        
        $step_empty6=0;
        if (in_array('', $step6)) { $step_empty6++; }
        if($step_empty6>0){ $array6 = array("step_completed"=>false); } else { $array6 = array("step_completed"=>true); }
        $step6 = array_merge($array6, $step6); 
        
        $step_empty7=0;
         
        if (empty($attributes)) { $step_empty7++; }
        //if (in_array('', $step7)) { $step_empty7++; }
        if($step_empty7>0){ $array7 = array("step_completed"=>false); } else { $array7 = array("step_completed"=>true); }
        $step7 = array_merge($array7, $step7); 
        
        $step_empty8=0;
        if (in_array('', $step8)) { $step_empty8++; }
        if($step_empty8>0){ $array8 = array("step_completed"=>false); } else { $array8 = array("step_completed"=>true); }
        $step8 = array_merge($array8, $step8); 
        
        $step_empty9=0;
        if (in_array('', $step9_chk)) { $step_empty9++; }
        if($step_empty9>0){ $array9 = array("step_completed"=>false); } else { $array9 = array("step_completed"=>true); }
        $step9 = array_merge($array9, $step9); 
        
        
        $result_arr[] = array("step1"=>$step1,"step2"=>$step2,"step3"=>$step3,"step4"=>$step4,"step5"=>$step5,"step6"=>$step6,"step7"=>$step7,"step8"=>$step8,"step9"=>$step9);
      
        $json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$catID,"result"=>$result_arr,"property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"property_attributes" => $property_attributes,"currency" =>$currencyvalueArr)); 
        
      } else {
        $json_encode = json_encode(array('status'=>0,'message'=>'No data found',"propertyid"=>"")); 
      }
    }
    echo $json_encode;
  }
  /* ADD PROPERTY STEP8 Address location */ 
  public function mobile_add_property_step8()
  { 
  $user_id =$this->input->post('user_id');
  
  $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
    $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
    
    $currencyvalueArr = array();
    if($currency_values->num_rows() >0) {
      foreach($currency_values->result() as $cur_value) {
      $currencyvalueArr[] = array("id" =>$cur_value->id,"country_symbols"=>$cur_value->currency_symbols,"currency_type"=>$cur_value->currency_type);
      }
    } 
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($property_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($property_listvalue->result() as $prty) {
              $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    }
    
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
    $roombedVal=array();
    $roombedVal1=array();
    $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as   $list){
        $roombedVal[] =json_decode($list->listing_values);
        $roombedVal1[] =json_decode($list->rooms_bed);
      }
    }
	
	/***********Charles 18-3-2017 Parent Name*********/
	$select_qrys = "select * from fc_listing_types WHERE status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		  
		  
	/***********Charles 18-3-2017 Child Name*********/
	/***********Charles 2-3-2017 Child Name*********/
	$select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    if($list_valuesy->num_rows()>0){
		
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		  $listing_child_type = $listing_child->type;
		  $listing_child_labelname = $listing_child->labelname;
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);
		
		  
		  
		  
		 
		
	  }
	  
	$property_attributes[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	}
	/***********Charles 18-3-2017 Parent Name*********/
    
    if ($user_id=='')
    {
      $json_encode = json_encode(array('status'=>0,'message'=>'Please sign in before listing your rental'));
    } else {
      //echo '<pre>';print_r($_POST);die;
      $prd_id = intval($this->input->post('property_id'));
      $product_id = array('productId'=>$prd_id);
      $newAddress = '';
      if($this->input->post('street') != '')
      $newAddress .= ','.$this->input->post('street');
      if($this->input->post('city') != '')
      $newAddress .= ','.$this->input->post('city');
      if($this->input->post('state') != '')
      $newAddress .= ','.$this->input->post('state');
      if($this->input->post('country') != '')
      $newAddress .= ','.$this->input->post('country');
      if($this->input->post('post_code') != '')
      $newAddress .= ','.$this->input->post('post_code');
      $address = $this->input->post('address_location');
      $address = str_replace(" ", "+", $newAddress);
      $lat = $this->input->post('lat');
      $lang = $this->input->post('lng');
      
      $dataArr = array('address'=>$this->input->post('address_location'),
              'country'=>$this->input->post('country'),
              'state'=>$this->input->post('state'),
              'city'=>$this->input->post('city'),
              'street'=>$this->input->post('street'),
              'zip'=>$this->input->post('post_code'),
              'lat'=> $lat,
              'lang'=> $lang
              );
  
      $datas = array_merge($dataArr,$product_id);
    
      $this->data['productDetail'] = $this->mobile_model->get_all_details(PRODUCT_ADDRESS_NEW,array('productId'=>$prd_id));
      
      
      if($this->data['productDetail']->num_rows() > 0 )
        {
          $this->mobile_model->update_details(PRODUCT_ADDRESS_NEW,$dataArr,array('productId'=>$prd_id));
        }
      else
        {
          $this->mobile_model->simple_insert(PRODUCT_ADDRESS_NEW,$datas);
        }
  $dataArr = array('address'=>$this->input->post('address_location'),
              'country'=>$this->input->post('country'),
              'state'=>$this->input->post('state'),
              'city'=>$this->input->post('city'),
              'street'=>$this->input->post('street'),
              'zip'=>$this->input->post('post_code'),
              'lat'=> $lat,
              'lang'=> $lang
              );
      $catID = $prd_id;
/* schedule starts here */
        $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$catID));
      $sometime_arr = array();
      if($scheduleCheck->num_rows() >0){
        foreach($scheduleCheck->result() as $sc){ 
          $json_decode = json_decode($sc->data);
          foreach($json_decode as $key=>$value){
            if($value->status=="available"){
              $status = 1;
            }else if($value->status=="booked"){
              $status = 2;
            }else if($value->status=="unavailable"){
              $status = 3;
            }
            $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
          }
        } 
      }
/* schedule ends here */
      /* Get the property details */
      $attributes=array();
      $where1 = array('p.id'=>$catID);  
      $this->db->select('p.home_type,p.id,p.accommodates,p.room_type,p.price,p.currency,p.status,p.calendar_checked,pa.address,p.description,p.product_title,p.other_thingnote,p.house_rules,p.list_name,p.listings,pa.address,pa.country,pa.state,pa.city,pa.street,pa.zip,pa.lat,pa.lang,p.cancellation_policy,p.security_deposit,p.meta_title,p.meta_keyword,p.meta_description');
      $this->db->from(PRODUCT.' as p');
      $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
      $this->db->where($where1);
      $rental_details = $this->db->get(); 
       /* Get Cancellation Policy detail starts */
          $seourl = 'cancellation-policy';
          $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
          $cancellation_policy_description  = "";
          $cancellation_policy_title        = "";
          if($pageDetails->num_rows()>0) {
            foreach($pageDetails->result() as $page){
                $cancellation_policy_description  = $page->description;
                $cancellation_policy_title        = $page->page_title;
            }
          }
          /* Get Cancellation Policy detail ends */
      $photos = array();
      if($rental_details->num_rows() == 1) {
        $this->db->from(PRODUCT_PHOTOS);
        $this->db->where('product_id',$catID);
        $this->db->order_by('imgPriority','asc');
        $productImages = $this->db->get();
        if($productImages->num_rows()>0) {
          foreach($productImages->result() as $prd_Images){ 
            $photos[] =array("product_image_id"=>intval($prd_Images->id),"product_image"=>base_url().'server/php/rental/'.$prd_Images->product_image); 
          }
        } 
        foreach($rental_details->result() as $rental_detail){
          if($rental_detail->listings !=""){
            $attributes[] = json_decode($rental_detail->listings);          
          }
        
        $step1 = array("propertyid"=>$catID,"home_type"=>$rental_detail->home_type,"room_type"=>$rental_detail->room_type,"accommodates"=>$rental_detail->accommodates,"address"=>$rental_detail->address,"status"=>$rental_detail->status);
        $calendar_status = false;
        if($rental_detail->status == 'Publish' ){
          $calendar_status = true;
        }
        $step2 = array("propertyid"=>$catID,"calendar_checked"=>$rental_detail->calendar_checked,"dateto"=>"","datefrom"=>"","calendar_status"=>$calendar_status,"seasonal_calendar_price"=>$sometime_arr);
        $price ="";
        if($rental_detail->price !=0){
          $price = floatval($rental_detail->price);
        }
        $step3 = array("propertyid"=>$catID,"currency_code"=>$rental_detail->currency,"price"=>$price,"chk"=>"price");
        $step4 = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title,"property_description"=>$rental_detail->description,"other_thingnote"=>$rental_detail->other_thingnote,"house_rules"=>$rental_detail->house_rules);
        $step4_chk = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title);
        $step5 = array("propertyid"=>$catID,"product_image"=>$photos);
        $step6 = array("propertyid"=>$catID,"list_name"=>$rental_detail->list_name);
        $step7 = array("propertyid"=>$catID,"room_type"=>$rental_detail->room_type,"home_type"=>$rental_detail->home_type,"attribute"=>$attributes);
        $step8 = array("propertyid"=>$catID,"address"=>$rental_detail->address,"country"=>$rental_detail->country,"state"=>$rental_detail->state,"city"=>$rental_detail->city,"street"=>$rental_detail->street,"zip"=>$rental_detail->zip,"lat"=>$rental_detail->lat,"long"=>$rental_detail->lang);
        $step9 = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"meta_title"=>$rental_detail->meta_title,"meta_keyword"=>$rental_detail->meta_keyword,"meta_description"=>$rental_detail->meta_description,"property_currency"=>$rental_detail->currency,"cancellation_policy_title"=>$cancellation_policy_title,"cancellation_policy_description"=>$cancellation_policy_description);
        $step9_chk = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"property_currency"=>$rental_detail->currency);
        }
        
        $step_empty1=0;
        if (in_array('', $step1)) { $step_empty1++; }
        if($step_empty1>0){ $array1 = array("step_completed"=>false); } else { $array1 = array("step_completed"=>true); }
        $step1 = array_merge($array1, $step1); 
        
        $step22[] = $step2['calendar_checked'];
        $step_empty2=0;
        if (in_array('',$step22)) { $step_empty2++; }
        if($step_empty2>0){ $array2 = array("step_completed"=>false); } else { $array2 = array("step_completed"=>true); }
        $step2 = array_merge($array2, $step2); 
        
        $step_empty3=0;
        if (in_array('', $step3)) { $step_empty3++; }
        if($step_empty3>0){ $array3 = array("step_completed"=>false); } else { $array3 = array("step_completed"=>true); }
        $step3 = array_merge($array3, $step3); 
        
        $step_empty4=0;
        if (in_array('', $step4_chk)) { $step_empty4++; }
        if($step_empty4>0){ $array4 = array("step_completed"=>false); } else { $array4 = array("step_completed"=>true); }
        $step4 = array_merge($array4, $step4); 
        
        $step_empty5=0;
        if (empty($photos)) { $step_empty5++; }
        if($step_empty5>0){ $array5 = array("step_completed"=>false); } else { $array5 = array("step_completed"=>true); }
        $step5 = array_merge($array5, $step5); 
        
        
        $step_empty6=0;
        if (in_array('', $step6)) { $step_empty6++; }
        if($step_empty6>0){ $array6 = array("step_completed"=>false); } else { $array6 = array("step_completed"=>true); }
        $step6 = array_merge($array6, $step6); 
        
        $step_empty7=0;
         
        if (empty($attributes)) { $step_empty7++; }
        //if (in_array('', $step7)) { $step_empty7++; }
        if($step_empty7>0){ $array7 = array("step_completed"=>false); } else { $array7 = array("step_completed"=>true); }
        $step7 = array_merge($array7, $step7); 
        
        $step_empty8=0;
        if (in_array('', $step8)) { $step_empty8++; }
        if($step_empty8>0){ $array8 = array("step_completed"=>false); } else { $array8 = array("step_completed"=>true); }
        $step8 = array_merge($array8, $step8); 
        
        $step_empty9=0;
        if (in_array('', $step9_chk)) { $step_empty9++; }
        if($step_empty9>0){ $array9 = array("step_completed"=>false); } else { $array9 = array("step_completed"=>true); }
        $step9 = array_merge($array9, $step9); 
        
        
        $result_arr[] = array("step1"=>$step1,"step2"=>$step2,"step3"=>$step3,"step4"=>$step4,"step5"=>$step5,"step6"=>$step6,"step7"=>$step7,"step8"=>$step8,"step9"=>$step9);
      
        $json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$catID,"result"=>$result_arr,"property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"property_attributes" => $property_attributes,"currency" =>$currencyvalueArr)); 
        
      } else {
        $json_encode = json_encode(array('status'=>0,'message'=>'No data found',"propertyid"=>"")); 
      }
    }
    echo $json_encode;
    
  }
  /* ADD PROPERTY STEP9 Cancellation */ 
  public function mobile_add_property_step9()
  {
    $user_id =$this->input->post('user_id');
    $cancellation_policy="";
    $security_deposit="";
    $meta_title="";
    $meta_keyword="";
    $meta_description="";
    
    $select_qry = "select id,currency_symbols,currency_type,currency_rate from fc_currency where status='Active' and currency_symbols !='' and currency_type !=''";
      
    $currency_values = $this->mobile_model->ExecuteQuery($select_qry);
    
    $currencyvalueArr = array();
    if($currency_values->num_rows() >0) {
      foreach($currency_values->result() as $cur_value) {
      $currencyvalueArr[] = array("id" =>$cur_value->id,"country_symbols"=>$cur_value->currency_symbols,"currency_type"=>$cur_value->currency_type);
      }
    } 
    $parent_select_qry = "select id,attribute_name,status from fc_attribute where status='Active'";
    $parent_list_values = $this->mobile_model->ExecuteQuery($parent_select_qry);
    
    $attribute = array();
    $property = array();
    $rooms = array();
    $conditions = array('status'=>'Active','id'=>9);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Property and Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>9);
        $property_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($property_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($property_listvalue->result() as $prty) {
              $propertyvalueArr[] = array("child_id" =>$prty->id,"child_name"=>$prty->list_value,"child_image"=>base_url()."images/attribute/".$prty->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $property[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
      }
    }
    
    $conditions = array('status'=>'Active','id'=>10);
    $property_space = $this->mobile_model->get_all_details (LISTSPACE, $conditions);
    /* Room Type and so on */
    if($property_space->num_rows()>0) {
      foreach($property_space->result() as $pro) {
        $conditions1 = array('status'=>'Active','other'=>'Yes','listspace_id'=>10);
        $room_listvalue = $this->mobile_model->get_all_details (LISTSPACE_VALUES, $conditions1);
        if($room_listvalue->num_rows()>0) {
          $propertyvalueArr = array();
          foreach($room_listvalue->result() as $room) {
              $propertyvalueArr[] = array("child_id" =>$room->id,"child_name"=>$room->list_value,"child_image"=>base_url()."images/attribute/".$room->image,"parent_name"=>$pro->attribute_name,"parent_id"=>$pro->id);
          }
          $rooms[]  = array("option_id"=>$pro->id,"option_name"=>$pro->attribute_name,"options"=>$propertyvalueArr);
        }
        
      }
    }
    
    /* Features of amenties,extras ,wifi and so on */
    if($parent_list_values->num_rows()>0) {
      foreach($parent_list_values->result() as $parent_value) {
        $select_qrys = "select fc_list_values.id,list_value,list_id,fc_attribute.id as attr_id,attribute_name,image from fc_list_values left join fc_attribute  on fc_attribute.id = fc_list_values.list_id where fc_list_values.status='Active' and list_id = ".$parent_value->id;
        $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
        if($list_values->num_rows()>0) {
          $listvalueArr = array();
          foreach($list_values->result() as $list_value) {
            if($parent_value->id == $list_value->list_id) {
              $listvalueArr[] = array("child_id" =>$list_value->id,"child_name"=>$list_value->list_value,"child_image"=>base_url()."images/attribute/".$list_value->image,"parent_name"=>$list_value->attribute_name,"parent_id"=>$list_value->attr_id);
            }
          }
          $attribute[]  = array("option_id"=>$parent_value->id,"option_name"=>$parent_value->attribute_name,"options"=>$listvalueArr);
        } 
      }
    }
    
    $roombedVal=array();
    $roombedVal1=array();
    $select_qry = "select * from fc_listings where id=1";
    $list_values = $this->mobile_model->ExecuteQuery($select_qry);
    if($list_values->num_rows()>0){
      foreach($list_values->result() as   $list){
        $roombedVal[] =json_decode($list->listing_values);
        $roombedVal1[] =json_decode($list->rooms_bed);
      }
    }
	
	/***********Charles 18-3-2017 Parent Name*********/
	$select_qrys = "select * from fc_listing_types where status='Active'";
    $listing_values = $this->mobile_model->ExecuteQuery($select_qrys);
	$property_attributes = array();
    if($listing_values->num_rows()>0)
	{
      foreach($listing_values->result() as $listing_parent)
	  {
		  
		  $listing_id = $listing_parent->id;
		  $listing_name = $listing_parent->name;
		  $listing_type = $listing_parent->type;
		  $listing_labelname = $listing_parent->labelname;
		   
		  
	/***********Charles 18-3-2017 Child Name*********/
	/***********Charles 2-3-2017 Child Name*********/
	$select_qryy = "select * from fc_listing_child where parent_id=".$listing_id." and status=0";
    $list_valuesy = $this->mobile_model->ExecuteQuery($select_qryy);
	//print_r($list_valuesy->result()); exit;
	$property_child_attributes = array();
    if($list_valuesy->num_rows()>0){
		
      foreach($list_valuesy->result() as $listing_child){
		  
		 $listing_child_id = $listing_child->id;
		  $listing_child_name = $listing_child->child_name;
		  $listing_child_type = $listing_child->type;
		  $listing_child_labelname = $listing_child->labelname;
		  $property_child_attributes[] = array("attribute_child_id"=>intval($listing_child_id),"attribute_parent_name"=>$listing_name,"attribute_child_value"=>$listing_child_name);

	  }
	  
	$property_attributes[] = array("attribute_id"=>intval($listing_id),"attribute_type"=>$listing_type,"attribute_name"=>$listing_name,"attribute_label"=>$listing_labelname,"attribute_value"=>$property_child_attributes);
	}
	}
	}
	/***********Charles 18-3-2017 Parent Name*********/
    
    if ($user_id=='')
    {
      $json_encode = json_encode(array('status'=>0,'message'=>'Please sign in before listing your rental'));
    } else {
      $catID = intval($this->input->post('property_id'));
      if($catID !="") {
        $cancellation_policy = $this->input->post('cancellation_policy');
        $security_deposit = $this->input->post('security_deposit');
        $meta_title = $this->input->post('meta_title');
        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');
  
        $this->mobile_model->update_details(PRODUCT,
        array('cancellation_policy'=>$cancellation_policy,'security_deposit'=>$security_deposit,'meta_title'=>$meta_title,'meta_keyword'=>$meta_keyword,'meta_description'=>$meta_description),array('id'=>$catID));
        /* Get the property details */
/* schedule starts here */
          $scheduleCheck = $this->mobile_model->get_all_details('schedule',array('id'=>$catID));
        $sometime_arr = array();
        if($scheduleCheck->num_rows() >0){
          foreach($scheduleCheck->result() as $sc){ 
            $json_decode = json_decode($sc->data);
            foreach($json_decode as $key=>$value){
              if($value->status=="available"){
                $status = 1;
              }else if($value->status=="booked"){
                $status = 2;
              }else if($value->status=="unavailable"){
                $status = 3;
              }
              $sometime_arr[] = array("date"=>$key,"price"=>floatval($value->price),"status"=>$status);
            }
          } 
        }
    /* schedule ends here */
        $attributes=array();
        $where1 = array('p.id'=>$catID);  
        $attributes=array();
        $where1 = array('p.id'=>$catID);  
        $this->db->select('p.home_type,p.id,p.accommodates,p.room_type,p.price,p.currency,p.status,p.calendar_checked,pa.address,p.description,p.product_title,p.other_thingnote,p.house_rules,p.list_name,p.listings,pa.address,pa.country,pa.state,pa.city,pa.street,pa.zip,pa.lat,pa.lang,p.cancellation_policy,p.security_deposit,p.meta_title,p.meta_keyword,p.meta_description');
        $this->db->from(PRODUCT.' as p');
        $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
        $this->db->where($where1);
        $rental_details = $this->db->get(); 
        /* Get Cancellation Policy detail starts */
          $seourl = 'cancellation-policy';
          $pageDetails = $this->mobile_model->get_all_details(CMS,array('seourl'=>$seourl,'status'=>'Publish'));
          $cancellation_policy_description  = "";
          $cancellation_policy_title        = "";
          if($pageDetails->num_rows()>0) {
            foreach($pageDetails->result() as $page){
                $cancellation_policy_description  = $page->description;
                $cancellation_policy_title        = $page->page_title;
            }
          }
          /* Get Cancellation Policy detail ends */
        $photos = array();
        if($rental_details->num_rows() == 1) {
          $this->db->from(PRODUCT_PHOTOS);
          $this->db->where('product_id',$catID);
          $this->db->order_by('imgPriority','asc');
          $productImages = $this->db->get();
          if($productImages->num_rows()>0) {
            foreach($productImages->result() as $prd_Images){ 
              $photos[] =array("product_image_id"=>intval($prd_Images->id),"product_image"=>base_url().'server/php/rental/'.$prd_Images->product_image); 
            }
          } 
          foreach($rental_details->result() as $rental_detail){
            if($rental_detail->listings !=""){
              $attributes[] = json_decode($rental_detail->listings);          
            }
          
          $step1 = array("propertyid"=>$catID,"home_type"=>$rental_detail->home_type,"room_type"=>$rental_detail->room_type,"accommodates"=>$rental_detail->accommodates,"address"=>$rental_detail->address,"status"=>$rental_detail->status);
          $calendar_status = false;
          if($rental_detail->status == 'Publish' ){
            $calendar_status = true;
          }
          $step2 = array("propertyid"=>$catID,"calendar_checked"=>$rental_detail->calendar_checked,"dateto"=>"","datefrom"=>"","calendar_status"=>$calendar_status,"seasonal_calendar_price"=>$sometime_arr);
         
          $price ="";
          if($rental_detail->price !=0){
            $price = floatval($rental_detail->price);
          }
          $step3 = array("propertyid"=>$catID,"currency_code"=>$rental_detail->currency,"price"=>$price,"chk"=>"price");
          $step4 = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title,"property_description"=>$rental_detail->description,"other_thingnote"=>$rental_detail->other_thingnote,"house_rules"=>$rental_detail->house_rules);
          $step4_chk = array("propertyid"=>$catID,"property_title"=>$rental_detail->product_title);
          $step5 = array("propertyid"=>$catID,"product_image"=>$photos);
          $step6 = array("propertyid"=>$catID,"list_name"=>$rental_detail->list_name);
          $step7 = array("propertyid"=>$catID,"room_type"=>$rental_detail->room_type,"home_type"=>$rental_detail->home_type,"attribute"=>$attributes);
          $step8 = array("propertyid"=>$catID,"address"=>$rental_detail->address,"country"=>$rental_detail->country,"state"=>$rental_detail->state,"city"=>$rental_detail->city,"street"=>$rental_detail->street,"zip"=>$rental_detail->zip,"lat"=>$rental_detail->lat,"long"=>$rental_detail->lang);
          $step9 = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"meta_title"=>$rental_detail->meta_title,"meta_keyword"=>$rental_detail->meta_keyword,"meta_description"=>$rental_detail->meta_description,"property_currency"=>$rental_detail->currency,"cancellation_policy_title"=>$cancellation_policy_title,"cancellation_policy_description"=>$cancellation_policy_description);
          $step9_chk = array("propertyid"=>$catID,"cancellation_policy"=>$rental_detail->cancellation_policy,"security_deposit"=>$rental_detail->security_deposit,"property_currency"=>$rental_detail->currency);
          }
          
          $step_empty1=0;
          if (in_array('', $step1)) { $step_empty1++; }
          if($step_empty1>0){ $array1 = array("step_completed"=>false); } else { $array1 = array("step_completed"=>true); }
          $step1 = array_merge($array1, $step1); 
          
          $step22[] = $step2['calendar_checked'];
          $step_empty2=0;
          if (in_array('',$step22)) { $step_empty2++; }
          if($step_empty2>0){ $array2 = array("step_completed"=>false); } else { $array2 = array("step_completed"=>true); }
          $step2 = array_merge($array2, $step2); 
          
          $step_empty3=0;
          if (in_array('', $step3)) { $step_empty3++; }
          if($step_empty3>0){ $array3 = array("step_completed"=>false); } else { $array3 = array("step_completed"=>true); }
          $step3 = array_merge($array3, $step3); 
          
          $step_empty4=0;
          if (in_array('', $step4_chk)) { $step_empty4++; }
          if($step_empty4>0){ $array4 = array("step_completed"=>false); } else { $array4 = array("step_completed"=>true); }
          $step4 = array_merge($array4, $step4); 
          
          $step_empty5=0;
          if (empty($photos)) { $step_empty5++; }
          if($step_empty5>0){ $array5 = array("step_completed"=>false); } else { $array5 = array("step_completed"=>true); }
          $step5 = array_merge($array5, $step5); 
          
          
          $step_empty6=0;
          if (in_array('', $step6)) { $step_empty6++; }
          if($step_empty6>0){ $array6 = array("step_completed"=>false); } else { $array6 = array("step_completed"=>true); }
          $step6 = array_merge($array6, $step6); 
          
          $step_empty7=0;
           
          if (empty($attributes)) { $step_empty7++; }
          //if (in_array('', $step7)) { $step_empty7++; }
          if($step_empty7>0){ $array7 = array("step_completed"=>false); } else { $array7 = array("step_completed"=>true); }
          $step7 = array_merge($array7, $step7); 
          
          $step_empty8=0;
          if (in_array('', $step8)) { $step_empty8++; }
          if($step_empty8>0){ $array8 = array("step_completed"=>false); } else { $array8 = array("step_completed"=>true); }
          $step8 = array_merge($array8, $step8); 
          
          $step_empty9=0;
          if (in_array('', $step9_chk)) { $step_empty9++; }
          if($step_empty9>0){ $array9 = array("step_completed"=>false); } else { $array9 = array("step_completed"=>true); }
          $step9 = array_merge($array9, $step9); 
          
          
          $result_arr[] = array("step1"=>$step1,"step2"=>$step2,"step3"=>$step3,"step4"=>$step4,"step5"=>$step5,"step6"=>$step6,"step7"=>$step7,"step8"=>$step8,"step9"=>$step9);
        
          $json_encode = json_encode(array('status'=>1,'message'=>'Successfully saved',"propertyid"=>$catID,"result"=>$result_arr,"property" =>$property,"rooms"=>$rooms,"attribute"=>$attribute,"property_attributes" => $property_attributes,"currency" =>$currencyvalueArr)); 
          
        } else {
          $json_encode = json_encode(array('status'=>0,'message'=>'No data found',"propertyid"=>"")); 
        }
      }   
    }
    echo $json_encode;
  } 
    
  
  /* For Calendar property add */
  public function GetDays1($sStartDate, $sEndDate){  
      // Firstly, format the provided dates.  
      // This function works best with YYYY-MM-DD  
      // but other date formats will work thanks  
      // to strtotime().  
      $sStartDate = date("Y-m-d", strtotime($sStartDate));  
      $sEndDate = date("Y-m-d", strtotime($sEndDate));  
      
      // Start the variable off with the start date  
      $aDays[] = $sStartDate;  
      
      // Set a 'temp' variable, sCurrentDate, with  
      // the start date - before beginning the loop  
      $sCurrentDate = $sStartDate;  
      
      // While the current date is less than the end date  
      while($sCurrentDate < $sEndDate){  
        // Add a day to the current date  
        $sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
      
        // Add this new day to the aDays array  
        $aDays[] = $sCurrentDate;  
      }  
      
      // Once the loop has finished, return the  
      // array of days.  
      return $aDays;  
    }
  /* GET CURRENCY VALUES */
  public function mobile_get_currency_symbol()
  {
    $currency_type=$this->input->post('currency_code');
    if($currency_type ==""){
      echo json_encode(array('status'=>0,'message'=>'currency code missing!'));
      exit;
    }
    $currency_symbol_query='SELECT * FROM '.CURRENCY.' where status = "Active"';
    $currency_symbol=$this->mobile_model->ExecuteQuery($currency_symbol_query);
    $currency_val = array();
    if($currency_symbol->num_rows() > 0)
    { 
      foreach($currency_symbol->result() as $cur){
         $currency_rate =0;
        //if($currency_type != $cur->currency_type) {
          $currency_rate = convertCurrency_mobile($currency_type,$cur->currency_type,1);
          $currency_val[] = array('currency_symbol'=>$cur->currency_symbols,'currency_code'=>$cur->currency_type,'currency_value'=>floatval($currency_rate));
        //}
      }
      
      echo json_encode(array('status'=>1,'message'=>'Currency Available','currency_list'=>$currency_val));
    }
    else{
      echo json_encode(array('status'=>0,'message'=>'No currency available','currency_values'=>$currency_val));
    }
  }
  /* check file extension */
  public function getExtension($str)
  {
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
    return $ext;
  }
  
  /* GET USER DETAILS */
  public function json_user_details()
  {
    $userid = $_POST['userid'];
    if($userid =="") {
      echo json_encode(array('status'=>0,'message'=>'Parameter missing!'));
      exit;
    }
    
    $userDetails = $this->db->query('select * from '.USERS.' where `id`="'.$userid.'"');
    //echo $this->db->last_query();
    $user_details = array();
    $user_list = array();
    if($userDetails->num_rows() >0) {
      foreach($userDetails->result() as $u) {
        if($u->image != ''){
          $userimg = base_url().'images/users/'.$u->image;
        }else{
          $userimg = base_url().'images/site/profile.png';
        }
      if($u->is_verified=='Yes'){ $is_verified=true; } elseif($u->is_verified =='No'){ $is_verified=false; }else{ $is_verified=""; }
        if($u->id_verified=='Yes'){ $id_verified=true; } elseif($u->id_verified =='No'){ $id_verified=false; }else{ $id_verified=""; }
        if($u->ph_verified=='Yes'){ $ph_verified=true; } elseif($u->ph_verified =='No'){ $ph_verified=false; }else{ $ph_verified=""; }
        if($u->is_brand=='yes'){ $is_brand=true; } elseif($u->is_brand =='no'){ $is_brand=false; }else{ $is_brand=""; }
        if($u->display_lists=='Yes'){ $display_lists=true; } elseif($u->display_lists =='No'){ $display_lists=false; }else{ $display_lists=""; }
        if($u->social_recommend=='yes'){ $social_recommend=true; } elseif($u->social_recommend =='no'){ $social_recommend=false; }else{ $social_recommend=""; }
        if($u->search_by_profile=='yes'){ $search_by_profile=true; } elseif($u->search_by_profile =='no'){ $search_by_profile=false; }else{ $search_by_profile=""; }
        if($u->subscriber=='Yes'){ $subscriber=true; } elseif($u->subscriber =='No'){ $subscriber=false; }else{ $subscriber=""; }
        
        if($u->twitter != "") {
        if($u->twitter =='Yes') {
          $linkedin_connect =true;
        } else if($u->twitter =='No') {
          $linkedin_connect =false;
        } else {
          $linkedin_connect = '';
        }
        
      }else{
        $linkedin_connect = '';
      }
      if($u->google != "") {
        if($u->google =='Yes') {
          $google_connect =true;
        } else if($u->google =='No') {
          $google_connect =false;
        } else {
          $google_connect = '';
        }
        
      }else{
        $google_connect = '';
      }
      if($u->facebook != "") {
        if($u->facebook =='Yes') {
          $facebook_connect =true;
        } else if($u->facebook =='No') {
          $facebook_connect =false;
        } else {
          $facebook_connect = '';
        }
        
      }else{
        $facebook_connect = '';
      }
      $languages = $this->mobile_model->get_all_details(LANGUAGES_KNOWN,array());
  $languages_known=explode(',',$u->languages_known);
          $languages_known_text='';
          foreach($languages->result() as $language)
          {
            if(in_array($language->language_code,$languages_known))
            {
              $languages_known_text .=$language->language_name.',';
            }
          }
          $lang = substr($languages_known_text,0,-1);
          if($languages_known_text ==''){ $lang ='None Selected'; }
          if($u->school !="") { $school = $u->school; } else { $school="";}
        if($u->work !="") { $work = $u->work; } else { $work="";} 
          
$trust[] = array("phone_verified"=>$ph_verified,"email_id_verified"=>$id_verified,"country"=>intval($u->ph_country),"phone"=>$u->phone_no,"linkedin_connect"=>$linkedin_connect,"facebook_connect"=>$facebook_connect,"google_connect"=>$google_connect);     
      $user_list[] = array("id"=>intval($u->id),"loginUserType"=>$u->loginUserType,"facebook_id"=>$u->f_id,"google_id"=>$u->google_id,"linkedin_id"=>$u->linkedin_id,"group"=>$u->group,"email"=>$u->email,"status"=>$u->status,"is_verified"=>$is_verified,"id_verified"=>$id_verified,"ph_verified"=>$ph_verified,"is_brand"=>$is_brand,"created"=>$u->created,"last_login_date"=>$u->last_login_date,"last_logout_date"=>$u->last_logout_date,"firstname"=>$u->firstname,"lastname"=>$u->lastname,"description"=>$u->description,"gender"=>$u->gender,"dob_date"=>$u->dob_date,"dob_month"=>$u->dob_month,"dob_year"=>$u->dob_year,"country"=>intval($u->country),"phone_no"=>$u->phone_no,"where_you_live"=>$u->s_city,"request_status"=>$u->request_status,"verify_code"=>$u->verify_code,"feature_product"=>$u->feature_product,"followers_count"=>$u->followers_count,"following_count"=>$u->following_count,"language"=>$u->language,"visibility"=>$u->visibility,"display_lists"=>$display_lists,"email_notifications"=>$u->email_notifications,
      "notifications"=>$u->notifications,"updates"=>$u->updates,"package_status"=>$u->package_status,"expired_date"=> $u->expired_date,"social_recommend"=>$social_recommend,"search_by_profile"=>$search_by_profile,"languages_known"=>$lang,"school"=>$school,"work"=>$work,"accname"=>$u->accname,"accno"=>$u->accno,"bankname"=>$u->bankname,"subscriber"=>$subscriber,"login_hit"=>$u->login_hit,"user_image"=>$userimg);
      }
    } 
    //$user_details = array("user_info"=>$user_list);
    /* Reviews starts here */
    $Review_about_you = $this->mobile_model->get_productreview_aboutyou($userid);
    $Review_by_you = $this->mobile_model->get_productreview_byyou($userid);
    $rev_abt_you = array();
    $rev_by_you = array();
    if($Review_about_you->num_rows() >0) {
      foreach($Review_about_you->result() as $rau) {
        if($rau->image != ''){
          if($rau->loginUserType == 'google'){
            $userimg = $rau->image;
          } else {
            $userimg = base_url().'images/users/'.$rau->image;
          }
        }else{
          $userimg = base_url().'images/site/profile.png';
        }
        if($rau->email !=""){ $email=$rau->email;} else { $email="";}
        if($rau->review !=""){ $review=$rau->review;} else { $review="";}
         $rev_abt_you[] = array("review"=>$review,"review_email"=>$email,"star_rating"=>$rau->total_review,"user_image"=>$userimg,"created_date"=>$rau->dateAdded);
      }
    }
    if($Review_by_you->num_rows() >0) {
      foreach($Review_by_you->result() as $rbu) {
        if($rbu->image != ''){
          if($rbu->loginUserType == 'google'){
            $userimg = $rbu->image;
          } else {
            $userimg = base_url().'images/users/'.$rbu->image;
          }
          
        }else{
          $userimg = base_url().'images/site/profile.png';
        }
        if($rbu->email !=""){ $email=$rbu->email;} else { $email="";}
        if($rbu->review !=""){ $review=$rbu->review;} else { $review="";}
       $rev_by_you[] = array("review"=>$review,"review_email"=>$email,"star_rating"=>$rbu->total_review,"user_image"=>$userimg,"created_date"=>$rbu->dateAdded);
      }
    }
    //$review = array('reviews_about_you'=>$rev_abt_you,'reviews_by_you'=>$rev_by_you);
    /* Review Ends here */
    /* Dispute starts here */
    $Dispute_about_you = $this->mobile_model->get_productdispute_aboutyou($userid);
    $Dispute_by_you = $this->mobile_model->get_productdispute_byyou($userid);
    $Dis_abt_you = array();
    $Dis_by_you = array();
    if($Dispute_about_you->num_rows() >0) {
      foreach($Dispute_about_you->result() as $dau) {
        if($dau->image != ''){
          if($dau->loginUserType == 'google'){
            $userimg = $dau->image;
          } else {
            $userimg = base_url().'images/users/'.$dau->image;
          }
        }else{
          $userimg = base_url().'images/site/profile.png';
        }
        $Dis_abt_you[] = array("message"=>$dau->message,"review_email"=>$dau->email,"booking_no"=>$dau->booking_no,"user_image"=>$userimg,"created_date"=>$dau->created_date);
      }
    }
    if($Dispute_by_you->num_rows() >0) {
      foreach($Dispute_by_you->result() as $dbu) {
        if($dbu->image != ''){
          if($dbu->loginUserType == 'google'){
            $userimg = $dbu->image;
          } else {
            $userimg = base_url().'images/users/'.$dbu->image;
          }
        }else{
          $userimg = base_url().'images/site/profile.png';
        }
        $Dis_by_you[] = array("message"=>$dbu->message,"review_email"=>$dbu->email,"booking_no"=>$dbu->booking_no,"user_image"=>$userimg,"created_date"=>$dbu->created_date);
      }
    }
    //$dispute = array('dispute_about_you'=>$Dis_abt_you,'dispute_by_you'=>$Dis_by_you);
    /* Dispute starts here */
    
    /* Country List starts here */
    $country_list = array();
    $country_query='SELECT id,name FROM '.LOCATIONS.' WHERE status="Active" order by name';
    $active_countries = $this->mobile_model->ExecuteQuery($country_query);
    if($active_countries->num_rows() >0) {
      foreach($active_countries->result() as $cntry) {
        $country_list[] = array("id"=>intval($cntry->id),"country_name"=>$cntry->name);
      }
    } 
    /*  Country List ends here */   
 /*  Property List starts here */      
    $rentalDetail = $this->mobile_model->get_dashboard_list ( $userid,Publish);
    $listingarr = array();
    if($rentalDetail->num_rows() >0) {
      foreach($rentalDetail->result() as $r) {
        if($r->product_image != ''){
          $p_img = explode('.',$r->product_image); 

          $suffix = strrchr($r->product_image, "."); 
          $pos = strpos  ( $r->product_image  , $suffix); 
          $name = substr_replace ($r->product_image, "", $pos); 
         // echo $suffix . "<br><br>". $name;

          $pro_img = $name.''.$suffix; 
                   
          $proImage = base_url().'server/php/rental/'.$pro_img;
        }else{
          $proImage = base_url().'server/php/rental/dummyProductImage.jpg';
        }
      $listingarr[] = array("property_id"=>intval($r->id),"property_title"=>$r->product_title,"property_image"=>$proImage,'property_address'=>$r->address); 
      }
    }
    /*  Property List ends here */    
    echo json_encode(array('status'=>1,'message'=>'User Details Available','profileinfo'=>$user_list,'trust_verify'=>$trust,'reviews_about_you'=>$rev_abt_you,'reviews_by_you'=>$rev_by_you,'dispute_about_you'=>$Dis_abt_you,'dispute_by_you'=>$Dis_by_you,"country_list"=>$country_list,"property_listing"=>$listingarr));
    
    
  }
  
  /* GET USER ACCOUNT */
  public function json_user_account()
  {
    $userid = $_POST['userid'];
    if($userid =="") {
      echo json_encode(array('status'=>0,'message'=>'Parameter missing!'));
      exit;
    }
    
    $userDetails = $this->db->query('select * from '.USERS.' where `id`="'.$userid.'"');
    //echo $this->db->last_query();
    $user_details = array();
    $user_list = array();
    if($userDetails->num_rows() >0) {
      foreach($userDetails->result() as $u) {
        if($u->image != ''){
          $userimg = base_url().'images/users/'.$u->image;
        }else{
          $userimg = base_url().'images/site/profile.png';
        }
        if($u->is_verified=='Yes'){ $is_verified=true; } elseif($u->is_verified =='No'){ $is_verified=false; }else{ $is_verified=""; }
        if($u->id_verified=='Yes'){ $id_verified=true; } elseif($u->id_verified =='No'){ $id_verified=false; }else{ $id_verified=""; }
        if($u->ph_verified=='Yes'){ $ph_verified=true; } elseif($u->ph_verified =='No'){ $ph_verified=false; }else{ $ph_verified=""; }
        if($u->is_brand=='yes'){ $is_brand=true; } elseif($u->is_brand =='no'){ $is_brand=false; }else{ $is_brand=""; }
        if($u->display_lists=='Yes'){ $display_lists=true; } elseif($u->display_lists =='No'){ $display_lists=false; }else{ $display_lists=""; }
        if($u->social_recommend=='yes'){ $social_recommend=true; } elseif($u->social_recommend =='no'){ $social_recommend=false; }else{ $social_recommend=""; }
        if($u->search_by_profile=='yes'){ $search_by_profile=true; } elseif($u->search_by_profile =='no'){ $search_by_profile=false; }else{ $search_by_profile=""; }
        if($u->subscriber=='Yes'){ $subscriber=true; } elseif($u->subscriber =='No'){ $subscriber=false; }else{ $subscriber=""; }
      $user_list[] = array("id"=>intval($u->id),"loginUserType"=>$u->loginUserType,"facebook_id"=>$u->f_id,"google_id"=>$u->google_id,"linkedin_id"=>$u->linkedin_id,"group"=>$u->group,"email"=>$u->email,"status"=>$u->status,"is_verified"=>$is_verified,"id_verified"=>$id_verified,"ph_verified"=>$ph_verified,"is_brand"=>$is_brand,"created"=>$u->created,"last_login_date"=>$u->last_login_date,"last_logout_date"=>$u->last_logout_date,"firstname"=>$u->firstname,"lastname"=>$u->lastname,"description"=>$u->description,"gender"=>$u->gender,"dob_date"=>$u->dob_date,"dob_month"=>$u->dob_month,"dob_year"=>$u->dob_year,"country"=>intval($u->country),"phone_no"=>$u->phone_no,"where_you_live"=>$u->s_city,"request_status"=>$u->request_status,"verify_code"=>$u->verify_code,"feature_product"=>$u->feature_product,"followers_count"=>$u->followers_count,"following_count"=>$u->following_count,"language"=>$u->language,"visibility"=>$u->visibility,"display_lists"=>$display_lists,"email_notifications"=>$u->email_notifications,
      "notifications"=>$u->notifications,"updates"=>$u->updates,"package_status"=>$u->package_status,"expired_date"=> $u->expired_date,"social_recommend"=>$social_recommend,"search_by_profile"=>$u->search_by_profile,"languages_known"=>$u->languages_known,"accname"=>$u->accname,"accno"=>$u->accno,"bankname"=>$u->bankname,"subscriber"=>$subscriber,"login_hit"=>$u->login_hit,"user_image"=>$userimg);
      $payout[] = array("accname"=>$u->accname,"accno"=>$u->accno,"bankname"=>$u->bankname);
$notify[] = array("reservation_request"=>$u->notifications,"email_notifications"=>$u->email_notifications);
$privacy[] = array("search_by_profile"=>$search_by_profile,"social_recommend"=>$social_recommend);
      }
    } 
    
    /* Transaction History starts here */
    $emailQry = $this->mobile_model->get_all_details(USERS, array('id' => $userid));
    $email = $emailQry->row()->email;
    $future_transaction = $this->mobile_model->get_future_transaction($email);

    $completed_transaction = $this->mobile_model->get_completed_transaction($email);
    $fut_trans = array();
    $comp_trans = array();
    if($completed_transaction->num_rows() >0) {
      foreach($completed_transaction->result() as $comp) {
        $comp_trans[] = array("dateadded"=>date('M d, Y',strtotime($comp->dateAdded)),"transaction_method"=>"Via Bank","transaction_id"=>$comp->transaction_id,"amount"=>floatval($comp->amount),"currency_code"=>"USD","currency_symbol"=>"$");
      }
    }
    if($future_transaction->num_rows() >0) {
      foreach($future_transaction->result() as $fut) {
        $fut_trans[] = array("dateadded"=>date('M d, Y',strtotime($fut->dateAdded)),"firstname"=>$fut->firstname,"property_title"=>$fut->product_title,"property_price"=>floatval($fut->price),"bookingno"=>$fut->Bookingno,"totalAmt"=>floatval($fut->totalAmt),"service_fee"=>floatval($fut->guest_fee),"host_fee"=>floatval($fut->host_fee),"payable_amount"=>floatval($fut->payable_amount),"currency_code"=>"USD","currency_symbol"=>"$");
      }
    }
    //$user_transaction = array("completed_transaction"=>$comp_trans,"future_transaction"=>$fut_trans);
    /* Transaction History starts here */
    /* Country List starts here */
    $country_list = array();
    $country_query='SELECT id,name FROM '.LOCATIONS.' WHERE status="Active" order by name';
    $active_countries = $this->mobile_model->ExecuteQuery($country_query);
    if($active_countries->num_rows() >0) {
      foreach($active_countries->result() as $cntry) {
        $country_list[] = array("id"=>intval($cntry->id),"country_name"=>$cntry->name);
      }
    } 
    /*  Country List ends here */   
    echo json_encode(array('status'=>1,'message'=>'User Details Available','accountinfo'=>$user_list,"notifications"=>$notify,"payout_perference"=>$payout,"privacy"=>$privacy,"completed_transaction"=>$comp_trans,"future_transaction"=>$fut_trans,"country_list"=>$country_list));
    
  }
  /* GET INBOX CONVERSATION */
  public function json_inbox_conversation_bck()
  {
    $bookingNo = $_POST['bookingid'];
    $userId = $_POST['userid'];
    
    if($bookingNo =="" || $userId =="") {
      echo json_encode(array('status'=>0,'message'=>'Parameter missing!'));
      exit;
    }
      
    $conversationDetails = $this->user_model->get_all_details ( MED_MESSAGE, array ('bookingNo' => $bookingNo ),array(array('field'=>'id', 'type'=>'desc')));
    //echo $this->db->last_query();
    $product_details = $this->user_model->get_all_details(PRODUCT,array('id'=>$conversationDetails->row()->productId));
    if($product_details->row()->user_id == $userId){
      $this->db->where('bookingNo', $bookingNo);
      $this->db->update(MED_MESSAGE, array('msg_read' => 'Yes','host_msgread_status'=>'Yes')); 
    }else{
      $this->db->where('bookingNo', $bookingNo);
      $this->db->update(MED_MESSAGE, array('msg_read' => 'Yes','user_msgread_status'=>'Yes')); 
    }
      $bookingDetails = $this->user_model->get_booking_details($bookingNo);
      
      
      //echo '<pre>';print_r($this->data['bookingDetails']->result_array());die;
      $temp[] = $conversationDetails->row()->senderId;
      $temp[] = $conversationDetails->row()->receiverId;
      //$productId = $conversationDetails->row()->productId;
      
      if(!in_array($userId, $temp)) {
        echo json_encode(array('status'=>0,'message'=>'User not available!'));
        exit;
      }
        

      if($userId == $temp[0])
      {
        $sender_id = $temp[0];
        $receiver_id = $temp[1];
      }
      else 
      {
        $sender_id = $temp[1];
        $receiver_id = $temp[0];
      }
      
      $senderDetails = $this->user_model->get_all_details ( USERS, array ('id' => $sender_id ));
      
      $receiverDetails = $this->user_model->get_all_details ( USERS, array ('id' => $receiver_id ));
    
      $username = $receiverDetails->row()->user_name;
      if ($bookingDetails->row()->secDeposit != 0) {
        $secDeposite = $bookingDetails->row()->secDeposit;
      }
      $totalAmount = $bookingDetails->row()->subTotal + $bookingDetails->row()->serviceFee + $secDeposite;
      $message_detail =array();
        foreach($conversationDetails->result() as  $conversation) {
          if($sender_id == $conversation->senderId){
            $messenger = true;
            $message = $conversation->message;
            if($senderDetails->row()->image != ''){
              if($senderDetails->row()->loginUserType == 'google'){
                $userimg = $senderDetails->row()->image;
              } else {
                $userimg = base_url().'images/users/'.$senderDetails->row()->image;
              }
            }else{
              $userimg = base_url().'images/site/profile.png';
            }
            
          } else {
            $messenger = false;
            $message = $conversation->message;
            if($receiverDetails->row()->image != ''){
              if($receiverDetails->row()->loginUserType == 'google'){
                $userimg = $receiverDetails->row()->image;
              } else {
                $userimg = base_url().'images/users/'.$receiverDetails->row()->image;
              }
            }else{
              $userimg = base_url().'images/site/profile.png';
            }
            
          }
          $accept_decline ="";
          if($bookingDetails->row()->renter_id != $userId && $conversation->status == 'Decline'){
            $accept_decline = "Declined";
          } else if($bookingDetails->row()->renter_id == $userId && $conversation->status == 'Decline'){
            $accept_decline = "Declined";
          } else if($bookingDetails->row()->renter_id != $userId && $conversation->status == 'Accept'){
            $accept_decline = "Accepted";
          } else if($bookingDetails->row()->renter_id == $userId && $conversation->status == 'Accept'){ 
            $accept_decline = "Accepted";
          } else if($bookingDetails->row()->renter_id == $userId && $conversation->status == 'Pending'){ 
            $accept_decline = "Pending";
          }
          
          if($receiverDetails->row()->user_name !=""){
            $user_name = $receiverDetails->row()->user_name;
          } else { $user_name =""; }
          if($bookingDetails->row()->product_title !=""){
            $product_title = $bookingDetails->row()->product_title;
          } else { $product_title =""; }
          if($conversation->status !=""){
            $status = $conversation->status;
          } else { $status =""; }
          if($message !=""){
            $message = $message;
          } else { $message =""; }
          if($totalAmount !=""){
            $totalAmount = $totalAmount;
          } else { $totalAmount =""; }
          
          $message_detail[] = array("id"=>$conversation->id,"username"=>$receiverDetails->row()->user_name,"property_id"=>$conversation->productId,"property_title"=>$bookingDetails->row()->product_title,"property_currency_code"=>"USD",
          "property_currency_symbol"=>"$","NoofGuest"=>$bookingDetails->row()->NoofGuest,"coversation_status"=>$conversation->status,"coversation_point"=>$conversation->point,"dateAdded"=>date('d/m/Y', strtotime($conversation->dateAdded)),"message"=>$message,"messenger"=>$messenger,"totalAmount"=>$totalAmount,"user_image"=>$userimg,"accept_decline_status"=>$accept_decline,"bookingno"=>$conversation->bookingNo,"senderId"=>$conversation->senderId,"receiverId"=>$conversation->receiverId,"subject"=>$conversation->subject);
        }
      
      echo json_encode(array('status'=>1,'message'=>' Available','message_detail'=>$message_detail));
  }
  /* New Inbox api */
  public function json_inbox_conversation()
  {
    $bookingNo = $_POST['bookingid'];
    $userId = $_POST['userid'];
    
    if($bookingNo =="" || $userId =="") {
      echo json_encode(array('status'=>0,'message'=>'Parameter missing!'));
      exit;
    }
    $conversationDetails = $this->mobile_model->get_all_details ( MED_MESSAGE, array ('bookingNo' => $bookingNo ),array(array('field'=>'id', 'type'=>'desc')));
    
    $bookingDetails = $this->mobile_model->get_booking_details($bookingNo);
    if($bookingDetails->num_rows() >0) {
      $product_details = $this->mobile_model->get_all_details(PRODUCT,array('id'=>$conversationDetails->row()->productId));
      if($product_details->row()->user_id == $userId){
        $this->db->where('bookingNo', $bookingNo);
        $this->db->update(MED_MESSAGE, array('msg_read' => 'Yes','host_msgread_status'=>'Yes')); 
      }else{
        $this->db->where('bookingNo', $bookingNo);
        $this->db->update(MED_MESSAGE, array('msg_read' => 'Yes','user_msgread_status'=>'Yes')); 
      }
      
      
      if($bookingDetails->row()->host_image != ''){
        if($bookingDetails->row()->host_login_type == 'google'){
          $host_img = $bookingDetails->row()->host_image;
        } else {
          $host_img = base_url().'images/users/'.$bookingDetails->row()->host_image;
        }
      }else{
        $host_img = base_url().'images/site/profile.png';
      }
      if($bookingDetails->row()->requester_image != ''){
        if($bookingDetails->row()->requester_login_type == 'google'){
          $req_img = $bookingDetails->row()->requester_image;
        } else {
          $req_img = base_url().'images/users/'.$bookingDetails->row()->requester_image;
        }
      }else{
        $req_img = base_url().'images/site/profile.png';
      }
      $message_detail = array();
      foreach($conversationDetails->result() as  $conversation) {
        $subject = false;
        if($conversation->point ==1) {
          $subject = true;
        }
        $is_receiver = false;
        if($conversation->user_msgread_status =='Yes') {
          $is_receiver = true;        
        }
        $is_host = false;
        if($conversation->host_msgread_status =='Yes') {
          $is_host = true;        
        }
        $parent_select_qry = "select image,loginUserType,id from fc_users where id=$conversation->senderId";
        $sender_img = $this->mobile_model->ExecuteQuery($parent_select_qry);
        if($sender_img->row()->image != ''){
          if($sender_img->row()->loginUserType == 'google'){
            $user_img = $sender_img->row()->image;
          } else {
            $user_img = base_url().'images/users/'.$sender_img->row()->image;
          }
        }else{
          $user_img = base_url().'images/site/profile.png';
        }
        
        $receiver_select_qry = "select image,loginUserType,id from fc_users where id=$conversation->receiverId";
        $receiver_img = $this->mobile_model->ExecuteQuery($receiver_select_qry);
        if($receiver_img->row()->image != ''){
          if($receiver_img->row()->loginUserType == 'google'){
            $rec_img = $receiver_img->row()->image;
          } else {
            $rec_img = base_url().'images/users/'.$receiver_img->row()->image;
          }
        }else{
          $rec_img = base_url().'images/site/profile.png';
        }
        $message_detail[] = array("Id"=>$conversation->id,"message"=>$conversation->message,"message_by"=>$conversation->senderId,"is_subject"=>$subject,"is_receiver_read"=> $is_receiver,"is_host_read"=> $is_host,"server_time"=>$conversation->dateAdded,"user_image"=>$user_img);
      }
      echo json_encode(array('status'=>1,'message'=>' Available',"property_id"=>$bookingDetails->row()->prd_id,"property_name"=> $bookingDetails->row()->product_title,"host_id"=>$bookingDetails->row()->renter_id,"host_name"=> $bookingDetails->row()->host_name,"host_image"=> $host_img,"requester_id"=>$bookingDetails->row()->user_id,"requester_name"=>$bookingDetails->row()->requester_name,"requester_image"=>$req_img,"booking_id"=>$bookingDetails->row()->Bookingno,"no_of_guest"=>$bookingDetails->row()->NoofGuest,"checkin"=>$bookingDetails->row()->checkin,"checkout"=>$bookingDetails->row()->checkout,"approval"=>$bookingDetails->row()->approval,"total_amount"=>floatval($bookingDetails->row()->totalAmt),"property_currency_code"=>$bookingDetails->row()->currencycode,"member_from"=>$bookingDetails->row()->created,'messages'=>$message_detail));
      //echo $this->db->last_query();
    } else {
      echo json_encode(array('status'=>0,'message'=>' Not available'));
    }
    
  }
  /* RESET PASSWORD */
  public function mobile_reset_password() {
    $userid = $this->input->post ( 'userid' );
    $old_password = $this->input->post ( 'old_password' );
    $new_password = $this->input->post ( 'new_password' );
    if ($userid == '' || $old_password =='' || $new_password=='' ) {
      echo json_encode(array('status'=>0,'message'=>'Parameter missing!'));
      exit;
    } else {
    
    
     $current_pass = md5 ( $this->input->post ( 'old_password' ) );
      $condition = array (
          'id' => $userid,
          'password' => $current_pass 
      );
      $checkuser = $this->mobile_model->get_all_details ( USERS, $condition );
      if ($checkuser->num_rows () == 1) {
        $newPass = md5 ( $this->input->post ( 'new_password' ) );
        $newdata = array (
            'password' => $newPass 
        );
        $condition1 = array (
            'id' => $userid 
        );
        $this->mobile_model->update_details ( USERS, $newdata, $condition1 );
        echo json_encode(array('status'=>1,'message'=>'Password changed successfully'));
        exit;
      } else {
        echo json_encode(array('status'=>0,'message'=>'Current password is wrong'));
        exit;
      }
    }
  }
  
  /* MORE ABOUT HOST AND USER PROFILE */
  public function mobile_about_host()
  {
    $userid = $this->input->post ( 'userid' );
    if($userid ==""){
      echo json_encode(array("status"=>0,"message"=>"Parameter missing!"));
      exit;
    } else {
      $userDetails = $this->db->query('select * from '.USERS.' where `id`="'.$userid.'"');
      $languages = $this->mobile_model->get_all_details(LANGUAGES_KNOWN,array());
      $rentalDetail = $this->mobile_model->get_dashboard_list ( $userid,Publish);
      $Review_about_you = $this->mobile_model->get_productreview_aboutyou($userid);
      //$WishListCat = $this->mobile_model->get_list_details_wishlist($userid);
      if($userDetails->num_rows() >0) {
        foreach($userDetails->result() as $u) {
          if($u->image != ''){
            $userimg = base_url().'images/users/'.$u->image;
          }else{
            $userimg = base_url().'images/site/profile.png';
          }
          if($u->id_verified=='Yes'){ $id_verified=true; } elseif($u->id_verified =='No'){ $id_verified=false; } else { $id_verified=""; }
          if($u->ph_verified=='Yes'){ $ph_verified=true; } elseif($u->ph_verified =='No'){ $ph_verified=false; } else { $ph_verified=""; }
          $languages_known=explode(',',$u->languages_known);
          $languages_known_text='';
          foreach($languages->result() as $language)
          {
            if(in_array($language->language_code,$languages_known))
            {
              $languages_known_text .=$language->language_name.',';
            }
          }
          $lang = substr($languages_known_text,0,-1);
          if($languages_known_text ==''){ $lang ='None Selected'; }
          
          $user_list[] = array("id"=>intval($u->id),"loginUserType"=>$u->loginUserType,"firstname"=>$u->firstname,"lastname"=>$u->lastname,"description"=>$u->description,"id_verified"=>$id_verified,"ph_verified"=>$ph_verified,"phone_no"=>$u->phone_no,"work"=>$u->work,"school"=>$u->school,"language"=>$lang,"user_image"=>$userimg);
        }
        $listingarr = array();
        if($rentalDetail->num_rows() >0) {
          foreach($rentalDetail->result() as $r) {
            if($r->product_image != ''){
              $p_img = explode('.',$r->product_image);  

              $suffix = strrchr($r->product_image, "."); 
              $pos = strpos  ( $r->product_image  , $suffix); 
              $name = substr_replace ($r->product_image, "", $pos); 
             // echo $suffix . "<br><br>". $name;

              $pro_img = $name.''.$suffix; 
              
              $proImage = base_url().'server/php/rental/'.$pro_img;
            }else{
              $proImage = base_url().'server/php/rental/dummyProductImage.jpg';
            }
          $listingarr[] = array("property_id"=>intval($r->id),"property_title"=>$r->product_title,"property_image"=>$proImage); 
          }
        }
        
        $rev_abt_you = array();
        if($Review_about_you->num_rows() >0) {
          foreach($Review_about_you->result() as $rau) {
            if($rau->image != ''){
              if($rau->loginUserType == 'google'){
                $userimg = $rau->image;
              } else {
                $userimg = base_url().'images/users/'.$rau->image;
              }
            }else{
              $userimg = base_url().'images/site/profile.png';
            }
            if($rau->user_name !=""){ $user_name = $rau->user_name;} else { $user_name="";}
            if($rau->email !=""){ $email=$rau->email;} else { $email="";}
            if($rau->review !=""){ $review=$rau->review;} else { $review="";}
            $rev_abt_you[] = array("review"=>$review,"review_email"=>$email,"user_name" =>$user_name,"star_rating"=>$rau->total_review,"user_image"=>$userimg);
          }
        }
        /* $wisharr = array();
        if($WishListCat->num_rows() >0) {
          foreach($WishListCat->result() as $w) {
            $products=explode(',',$w->product_id);
            $productsNotEmy=array_filter($products);
            shuffle($productsNotEmy);
            $CountProduct=count($productsNotEmy);
            $bgImage = $this->mobile_model->get_all_details ( PRODUCT_PHOTOS, array ('product_id' => $productsNotEmy[0] ) );
            if($bgImage->row()->product_image != ''){
              $p_img = explode('.',$bgImage->row()->product_image); 
              $pro_img = $p_img[0].'.jpg';
              $bgImg = base_url().'server/php/rental/'.$pro_img;
            }else{
              $bgImg = base_url().'server/php/rental/dummyProductImage.jpg';
            }
            $wisharr[] = array("wish_list_name"=>ucfirst($w->name),"wish_list_img"=>$bgImg);
          }
        }
        */
        $condition1 = array("id"=>$userid);
        $userDetails = $this->mobile_model->get_all_details(USERS,$condition1); 
        $WishListCat = $this->mobile_model->get_list_details_wishlist($userid);
        $wishlist = array();
        if($WishListCat->num_rows() > 0){
          foreach($WishListCat->result() as $wlist){
            if($wlist->product_id !=''){
              $products=explode(',',$wlist->product_id);
              $productsNotEmy=array_filter($products);
              $CountProduct1=count($productsNotEmy);
              if($CountProduct1 > 0){
                $CountProduct = $this->mobile_model->get_all_details(PRODUCT,array('id'=>end($productsNotEmy)))->num_rows(); 
              }
              $img = "";
              if($CountProduct > 0){ 
                $ProductsImg = $this->mobile_model->get_all_details(PRODUCT_PHOTOS,array('product_id'=>end($productsNotEmy))); 
                if($ProductsImg->row()->product_image!=''){
                  $img = base_url().PRODUCTPATH.$ProductsImg->row()->product_image;
                }else{
                  $img = 'images/product/dummyProductImage.jpg';
                }
              } else {
                $img = 'images/site/empty-wishlist.jpg';
              }
              $product = array();
              if (count ( $productsNotEmy ) > 0) {
                $product_details = $this->mobile_model->get_product_details_wishlist_one_category ( $productsNotEmy );
                
                if(count($product_details)>0) {
                  foreach($product_details->result() as $p) {
                    
                    $wishlist_image  = $this->mobile_model->get_wishlistphoto ( $p->id );
                    $wish_img = array();
                    if(count($wishlist_image)>0) {
                      foreach($wishlist_image->result() as $product_image) {
                        $prd_img  ="";
                        if($product_image->product_image !=""){
                          if(strpos($product_image->product_image, 's3.amazonaws.com') > 1) {
                          $prd_img = $product_image->product_image;
                          } else  {
                            $prd_img = base_url()."server/php/rental/".$product_image->product_image;
                          }
                        }
                        $wish_img[] = array("property_image"=>$prd_img);
                      }
                    }
                    $condition = array('currency_type'=>$p->currency);
                    $property_currency_details = $this->mobile_model->get_all_details ( CURRENCY, $condition );
                    $property_currency_symbol = $property_currency_details->row()->currency_symbols;
                    if($userDetails->row()->image !=''){
                      $user_img = base_url().'images/users/'.$userDetails->row()->image;
                    }else{
                      $user_img = base_url().'images/users/user-thumb.png';
                    }
                    
                    $product[] = array("property_id"=>intval($p->id),"property_title"=>
                    $p->product_title,"property_address"=>$p->address,"bedrooms"=>$p->bedrooms,"bathrooms"=>$p->bathrooms,"room_type"=>$p->room_type,"notes_id"=>intval($p->nid),"notes_desc"=>strip_tags($p->notes),"property_price"=>$p->price,"property_currency_code"=>$p->currency,"property_currency_symbol"=>$property_currency_symbol,"user_image"=>$user_img,"property_images"=>$wish_img);
                    
                    
                  }
                }
              }
              $wishlist[] = array("wishlist_id"=>intval($wlist->id),"wishlist_title"=>$wlist->name,"wishlist_image"=>$img,"property_details"=>$product);
            }           
          }
        }
        
        
        
        echo json_encode(array('status'=>1,'message'=>'Successfully!',"profileinfo"=>$user_list,"property_listing"=>$listingarr,"reviews_about_you"=>$rev_abt_you,"wish_list"=>$wishlist));
        
      } else {
        echo json_encode(array("status"=>0,"message"=>"No data found!"));
      }
    }
  }
  /* CREATE NEW WISHLIST */
  public function mobile_create_wishlist()
  {
    $userid = $this->input->post ( 'userid' );
    $wishlist_title = $this->input->post ( 'wishlist_title' );
    $property_id = $this->input->post ( 'property_id' );

    if($userid =="" || $wishlist_title ==""){
      echo json_encode(array("status"=>0,"message"=>"Parameter missing!"));
      exit;
    } 
    if($userid ==0){
      echo json_encode(array("status"=>0,"message"=>"Invalid value!"));
      exit;
    } else {
      $data = $this->mobile_model->add_wishlist_category ( array (
          'user_id' => $userid,
          'name' => ucfirst($wishlist_title),
          'product_id'=>$property_id
      ));
    /*  $res = 'Successfully wishlist Created';
      $json_encode = json_encode(array("status"=>1,"message"=>$res)); 
      echo $json_encode;    
      exit;
      */
      $condition1 = array("id"=>$userid);
      $userDetails = $this->mobile_model->get_all_details(USERS,$condition1); 
      $WishListCat = $this->mobile_model->get_list_details_wishlist($userid);
      // echo $this->db->last_query();die;
      $wishlist = array();
      if($WishListCat->num_rows() > 0){
        foreach($WishListCat->result() as $wlist){
            $product = array();
            $img = "";
          if($wlist->product_id !=''){
            $products=explode(',',$wlist->product_id);
            $productsNotEmy=array_filter($products);
            $CountProduct1=count($productsNotEmy);
            if($CountProduct1 > 0){
              $CountProduct = $this->mobile_model->get_all_details(PRODUCT,array('id'=>end($productsNotEmy)))->num_rows(); 
            }
            $img = "";
            if($CountProduct > 0){ 
              $ProductsImg = $this->mobile_model->get_all_details(PRODUCT_PHOTOS,array('product_id'=>end($productsNotEmy))); 
              if($ProductsImg->row()->product_image!=''){
                $img = base_url().PRODUCTPATH.$ProductsImg->row()->product_image;
              }else{
                $img = 'images/product/dummyProductImage.jpg';
              }
            } else {
              $img = 'images/site/empty-wishlist.jpg';
            }
            
            if (count ( $productsNotEmy ) > 0) {
              $product_details = $this->mobile_model->get_product_details_wishlist_one_category ( $productsNotEmy );
              
              if(count($product_details)>0) {
                $product = array();
                foreach($product_details->result() as $p) {
                  
                  $wishlist_image  = $this->mobile_model->get_wishlistphoto ( $p->id );
                  $wish_img = array();
                  if(count($wishlist_image)>0) {
                    foreach($wishlist_image->result() as $product_image) {
                      $prd_img  ="";
                      if($product_image->product_image !=""){
                        if(strpos($product_image->product_image, 's3.amazonaws.com') > 1) {
                        $prd_img = $product_image->product_image;
                        } else  {
                          $prd_img = base_url()."server/php/rental/".$product_image->product_image;
                        }
                      }
                      $wish_img[] = array("property_image"=>$prd_img);
                    }
                  }
                  $condition = array('currency_type'=>$p->currency);
                  $property_currency_details = $this->mobile_model->get_all_details ( CURRENCY, $condition );
                  $property_currency_symbol = $property_currency_details->row()->currency_symbols;
                  if($userDetails->row()->image !=''){
                    $user_img = base_url().'images/users/'.$userDetails->row()->image;
                  }else{
                    $user_img = base_url().'images/users/user-thumb.png';
                  }
                  
                  $product[] = array("property_id"=>intval($p->id),"property_title"=>

                  $p->product_title,"property_address"=>$p->address,"bedrooms"=>$p->bedrooms,"bathrooms"=>$p->bathrooms,"room_type"=>$p->room_type,"notes_id"=>intval($p->nid),"notes_desc"=>strip_tags($p->notes),"property_price"=>floatval($p->price),"property_currency_code"=>$p->currency,"property_currency_symbol"=>$property_currency_symbol,"user_image"=>$user_img,"host_id"=>$p->user_id,"property_images"=>$wish_img);
                  
                  
                }
              }
            }
          }
          $wishlist[] = array("wishlist_id"=>intval($wlist->id),"wishlist_title"=>$wlist->name,"wishlist_image"=>$img,"property_details"=>$product);      
                
        }
        $json_encode = json_encode(array("status"=>1,"message"=>"Available!","wishlist"=>$wishlist));
        echo $json_encode;
        exit;
      } else {
        $json_encode = json_encode(array("status"=>1,"message"=>"Not Available!","wishlist"=>$wishlist));
        echo $json_encode;
        exit;
      }


    }

  }

  /* ADD Property to  WISHLIST */
  public function mobile_add_wishlist_property()
  {
    $wishlist_id = $this->input->post ( 'wishlist_id' );
    $user_id = $this->input->post ( 'user_id' );
    $property_id = $this->input->post ( 'property_id' );
  
    if($wishlist_id =="" || $user_id=="" || $user_id==0 || $wishlist_id ==0 || $property_id =="" || $property_id ==0) {
      echo json_encode(array("status"=>0,"message"=>"Parameter missing!"));
      exit;
    } else {
      $wishlist = array();
      $select_qrys = "select fc_lists.id from fc_lists where  id = ".$wishlist_id." and user_id = ".$user_id;
      $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
      if($list_values->num_rows()>0) {
        $update_wishlist_details = $this->mobile_model->update_wishlist_property ($property_id,$user_id,$wishlist_id);

        $condition1 = array("id"=>$user_id);
        $userDetails = $this->mobile_model->get_all_details(USERS,$condition1); 
        $WishListCat = $this->mobile_model->get_list_details_wishlist($user_id);
        // echo $this->db->last_query();die;
        $wishlist = array();
        if($WishListCat->num_rows() > 0){
          foreach($WishListCat->result() as $wlist){
              $product = array();
              $img = "";
            if($wlist->product_id !=''){
              $products=explode(',',$wlist->product_id);
              $productsNotEmy=array_filter($products);
              $CountProduct1=count($productsNotEmy);
              if($CountProduct1 > 0){
                $CountProduct = $this->mobile_model->get_all_details(PRODUCT,array('id'=>end($productsNotEmy)))->num_rows(); 
              }
              $img = "";
              if($CountProduct > 0){ 
                $ProductsImg = $this->mobile_model->get_all_details(PRODUCT_PHOTOS,array('product_id'=>end($productsNotEmy))); 
                if($ProductsImg->row()->product_image!=''){
                  $img = base_url().PRODUCTPATH.$ProductsImg->row()->product_image;
                }else{
                  $img = 'images/product/dummyProductImage.jpg';
                }
              } else {
                $img = 'images/site/empty-wishlist.jpg';
              }
              
              if (count ( $productsNotEmy ) > 0) {
                $product_details = $this->mobile_model->get_product_details_wishlist_one_category ( $productsNotEmy );
                
                if(count($product_details)>0) {
                  $product = array();
                  foreach($product_details->result() as $p) {
                    $wishlist_image  = $this->mobile_model->get_wishlistphoto ( $p->id );
                    $wish_img = array();
                    if(count($wishlist_image)>0) {
                      foreach($wishlist_image->result() as $product_image) {
                        $prd_img  ="";
                        if($product_image->product_image !=""){
                          if(strpos($product_image->product_image, 's3.amazonaws.com') > 1) {
                          $prd_img = $product_image->product_image;
                          } else  {
                            $prd_img = base_url()."server/php/rental/".$product_image->product_image;
                          }
                        }
                        $wish_img[] = array("property_image"=>$prd_img);
                      }
                    }
                    $condition = array('currency_type'=>$p->currency);
                    $property_currency_details = $this->mobile_model->get_all_details ( CURRENCY, $condition );
                    $property_currency_symbol = $property_currency_details->row()->currency_symbols;
                    if($userDetails->row()->image !=''){
                      $user_img = base_url().'images/users/'.$userDetails->row()->image;
                    }else{
                      $user_img = base_url().'images/users/user-thumb.png';
                    }
                    
                    $product[] = array("property_id"=>intval($p->id),"property_title"=>
                    $p->product_title,"property_address"=>$p->address,"bedrooms"=>$p->bedrooms,"bathrooms"=>$p->bathrooms,"room_type"=>$p->room_type,"notes_id"=>intval($p->nid),"notes_desc"=>strip_tags($p->notes),"property_price"=>floatval($p->price),"property_currency_code"=>$p->currency,"property_currency_symbol"=>$property_currency_symbol,"user_image"=>$user_img,"property_images"=>$wish_img);
                  }
                }
              }
            }
            $wishlist[] = array("wishlist_id"=>intval($wlist->id),"wishlist_title"=>$wlist->name,"wishlist_image"=>$img,"property_details"=>$product);      
                  
          }
          $json_encode = json_encode(array("status"=>1,"message"=>"Successfully Wishlist Added!","wishlist"=>$wishlist));
          echo $json_encode;
          exit;
        } else {
          $json_encode = json_encode(array("status"=>1,"message"=>"Not Available!","wishlist"=>$wishlist));
          echo $json_encode;
          exit;
        }
        
      } else {
        echo json_encode(array("status"=>0,"message"=>"No data available!","wishlist"=>$wishlist));
        exit;
      }
    }
  }
  /* REMOVE Property to  WISHLIST */
  public function mobile_remove_wishlist_property()
  {
    $wishlist_id = $this->input->post ( 'wishlist_id' );
    $user_id = $this->input->post ( 'user_id' );
    $property_id = $this->input->post ( 'property_id' );
  
    if($user_id=="" || $user_id==0  || $property_id =="" || $property_id ==0) {
      echo json_encode(array("status"=>0,"message"=>"Parameter missing!"));
      exit;
    } else {
      $wishlist = array();
      //$select_qrys = "select fc_lists.id from fc_lists where  id = ".$wishlist_id." and user_id = ".$user_id;
      $select_qrys = "select fc_lists.id from fc_lists where  find_in_set(".$property_id.",product_id) and user_id = ".$user_id;
      $list_values = $this->mobile_model->ExecuteQuery($select_qrys);
      
      if($list_values->num_rows()>0) {

        $update_wishlist_details = $this->mobile_model->remove_wishlist_property ($property_id,$user_id,$wishlist_id);
        
        $condition1 = array("id"=>$user_id);
        $userDetails = $this->mobile_model->get_all_details(USERS,$condition1); 
        $WishListCat = $this->mobile_model->get_list_details_wishlist($user_id);
        // echo $this->db->last_query();die;
        $wishlist = array();
        if($WishListCat->num_rows() > 0){
          foreach($WishListCat->result() as $wlist){
              $product = array();
              $img = "";
            if($wlist->product_id !=''){
              $products=explode(',',$wlist->product_id);
              $productsNotEmy=array_filter($products);
              $CountProduct1=count($productsNotEmy);
              if($CountProduct1 > 0){
                $CountProduct = $this->mobile_model->get_all_details(PRODUCT,array('id'=>end($productsNotEmy)))->num_rows(); 
              }
              $img = "";
              if($CountProduct > 0){ 
                $ProductsImg = $this->mobile_model->get_all_details(PRODUCT_PHOTOS,array('product_id'=>end($productsNotEmy))); 
                if($ProductsImg->row()->product_image!=''){
                  $img = base_url().PRODUCTPATH.$ProductsImg->row()->product_image;
                }else{
                  $img = 'images/product/dummyProductImage.jpg';
                }
              } else {
                $img = 'images/site/empty-wishlist.jpg';
              }
              
              if (count ( $productsNotEmy ) > 0) {
                $product_details = $this->mobile_model->get_product_details_wishlist_one_category ( $productsNotEmy );
                
                if(count($product_details)>0) {
                  $product = array();
                  foreach($product_details->result() as $p) {
                    $wishlist_image  = $this->mobile_model->get_wishlistphoto ( $p->id );
                    $wish_img = array();
                    if(count($wishlist_image)>0) {
                      foreach($wishlist_image->result() as $product_image) {
                        $prd_img  ="";
                        if($product_image->product_image !=""){
                          if(strpos($product_image->product_image, 's3.amazonaws.com') > 1) {
                          $prd_img = $product_image->product_image;
                          } else  {
                            $prd_img = base_url()."server/php/rental/".$product_image->product_image;
                          }
                        }
                        $wish_img[] = array("property_image"=>$prd_img);
                      }
                    }
                    $condition = array('currency_type'=>$p->currency);
                    $property_currency_details = $this->mobile_model->get_all_details ( CURRENCY, $condition );
                    $property_currency_symbol = $property_currency_details->row()->currency_symbols;
                    if($userDetails->row()->image !=''){
                      $user_img = base_url().'images/users/'.$userDetails->row()->image;
                    }else{
                      $user_img = base_url().'images/users/user-thumb.png';
                    }
                    
                    $product[] = array("property_id"=>intval($p->id),"property_title"=>
                    $p->product_title,"property_address"=>$p->address,"bedrooms"=>$p->bedrooms,"bathrooms"=>$p->bathrooms,"room_type"=>$p->room_type,"notes_id"=>intval($p->nid),"notes_desc"=>strip_tags($p->notes),"property_price"=>floatval($p->price),"property_currency_code"=>$p->currency,"property_currency_symbol"=>$property_currency_symbol,"user_image"=>$user_img,"property_images"=>$wish_img);
                  }
                }
              }
            }
            $wishlist[] = array("wishlist_id"=>intval($wlist->id),"wishlist_title"=>$wlist->name,"wishlist_image"=>$img,"property_details"=>$product);      
                  
          }
          $json_encode = json_encode(array("status"=>1,"message"=>"Successfully Wishlist Removed!","wishlist"=>$wishlist));
          echo $json_encode;
          exit;
        } else {
          $json_encode = json_encode(array("status"=>1,"message"=>"Not Available!","wishlist"=>$wishlist));
          echo $json_encode;
          exit;
        }

      } else {
        echo json_encode(array("status"=>1,"message"=>"No data available!","wishlist"=>$wishlist));
        exit;
      }
    }
  }
  /* ADD REVIEW */
  public function mobile_add_review()
  {
    
    $user_id = $this->input->post ( 'user_id' );
    $property_id = $this->input->post ( 'property_id' );
    $bookingno = $this->input->post ( 'bookingno' );
    $review = $this->input->post ( 'review' );
    $total_review = $this->input->post ( 'star_rating' );

    if($user_id=="" || $user_id==0  || $property_id =="" || $property_id ==0 ||  $bookingno =="" ||  $review =="") {
      echo json_encode(array("status"=>0,"message"=>"Parameter missing!"));
      exit;
    } else {
      $this->db->select('*');
      $this->db->from(USERS.' as u');
      $this->db->join(PRODUCT.' as p' , 'p.user)id = u.id');

      $userDetails = $this->db->query('select u.email,u.id from '.USERS.' as u where u.id ="'.$user_id.'"');
      if($userDetails->num_rows() >0) {
        foreach($userDetails->result() as $u) {
          $user_id = $u->id;  
          $email = $u->email; 
        }
      } else {
        echo json_encode(array("status"=>1,"message"=>"No data available!"));
        exit;
      }
      $renter_Details = $this->db->query('select u.email,u.id from '.USERS.' as u join '.PRODUCT.' as p on p.user_id = u.id  where p.id ="'.$property_id.'"');
      //echo $this->db->last_query();die;
      if($renter_Details->num_rows() >0) {
        foreach($renter_Details->result() as $r) {
          $host_id = $r->id;  
        }
        $dataArr = array( 'review'=>$review, 'status'=>'Inactive', 'product_id'=>$property_id, 'user_id'=>$host_id, 'reviewer_id'=>$user_id, 'email'=>$email, 'bookingno'=>$bookingno, 'total_review'=>$total_review);
        $insertquery = $this->mobile_model->add_review($dataArr);
        $review_id = $this->db->insert_id();
        echo json_encode(array("status"=>1,"message"=>"Success!","review_id"=>intval($review_id)));
        exit;
      } else {
        echo json_encode(array("status"=>1,"message"=>"No data available!"));
        exit;
      }

    }
  }
  /* ADD DISPUTE */
  public function mobile_add_dispute()
  {

    $user_id = $this->input->post ( 'user_id' );
    $property_id = $this->input->post ( 'property_id' );
    $bookingno = $this->input->post ( 'bookingno' );
    $message = $this->input->post ( 'message' );

    if($user_id=="" || $user_id==0  || $property_id =="" || $property_id ==0 ||  $bookingno =="" ||  $message =="") {
      echo json_encode(array("status"=>0,"message"=>"Parameter missing!"));
      exit;
    } else {
      $this->db->select('*');
      $this->db->from(USERS.' as u');
      $this->db->join(PRODUCT.' as p' , 'p.user)id = u.id');

      $userDetails = $this->db->query('select u.email,u.id from '.USERS.' as u where u.id ="'.$user_id.'"');
      if($userDetails->num_rows() >0) {
        foreach($userDetails->result() as $u) {
          $user_id = $u->id;  
          $email = $u->email; 
        }
      } else {
        echo json_encode(array("status"=>1,"message"=>"No data available!"));
        exit;
      }
      $renter_Details = $this->db->query('select u.email,u.id from '.USERS.' as u join '.PRODUCT.' as p on p.user_id = u.id  where p.id ="'.$property_id.'"');
      //echo $this->db->last_query();die;
      if($renter_Details->num_rows() >0) {
        foreach($renter_Details->result() as $r) {
          $disputer_id = $r->id;  
        }
        $dataArr = array('prd_id'=>$property_id,
            'message'=>$message,
            'user_id'=>$user_id,
            'booking_no'=>$bookingno,
            'email'=>$email,
            'disputer_id'=>$disputer_id
            );
        $insertquery = $this->mobile_model->add_dispute($dataArr);
        $dispute_id = $this->db->insert_id();
        echo json_encode(array("status"=>1,"message"=>"Success!","dispute_id"=>intval($dispute_id)));
        exit;
      } else {
        echo json_encode(array("status"=>1,"message"=>"No data available!"));
        exit;
      }

    }
  }

  /* Property Image Delete */
  public function mobile_propertyimage_delete()
  {
    $image_id = $this->input->post ( 'image_id' );
    if($image_id=="" || $image_id==0 ) {
      echo json_encode(array("status"=>0,"message"=>"Parameter missing!"));
      exit;
    } else {
      $condition =array('id'=>$image_id);
          $image_del = $this->mobile_model->commonDelete(PRODUCT_PHOTOS,array('id' => $image_id));
      echo json_encode(array("status"=>1,"message"=>"Success!"));
      exit;
    }
  }
  /* Property your review */
  public function mobile_your_review()
  {
    $user_id = $this->input->post ( 'user_id' );
    $booking_no = $this->input->post ( 'booking_no' );
    if($user_id =="" || $booking_no =="") {
      echo json_encode(array("status"=>0,"message"=>"Parameter Missing!"));
      exit;
    } else {
     $review_all = $this->mobile_model->get_trip_review($booking_no,$user_id); 

      $your_review = array();

      if($review_all->num_rows()>0){
          foreach($review_all->result() as $review) {

            if($review->image == '') {

              $img_url = base_url().'images/site/profile.png';

            }  else {

              $img_url = base_url().'images/users/'.$review->image;

            } 

          $review_date = date('F Y',strtotime($review->dateAdded));

          $your_review[] = array("name"=>$review->firstname,"review"=>$review->review,"review_date"=>$review_date,"star_rating"=>intval($review->total_review),"user_image"=>$img_url); 

          
        }
        echo json_encode(array("status"=>1,"message"=>"Success!","your_review"=>$your_review));
        exit;
      } else {
        echo json_encode(array("status"=>1,"message"=>"No data available!","your_review"=>$your_review));
        exit;
      }
    }
  
  }
// property your Dispute
    public function mobile_your_dispute()

  {

    $user_id = $this->input->post ( 'user_id' );

    $booking_no = $this->input->post ( 'booking_no' );

    if($user_id =="" || $booking_no =="") {

      echo json_encode(array("status"=>0,"message"=>"Parameter Missing!"));

      exit;

    } else {

      $dispute_all = $this->mobile_model->get_trip_dispute($booking_no,$user_id); 
     
      $your_dispute = array();

      if($dispute_all->num_rows()>0){
          foreach($dispute_all->result() as $dispute) {

            if($dispute->image == '') {

              $img_url = base_url().'images/site/profile.png';

            }  else {

              $img_url = base_url().'images/users/'.$dispute->image;

            } 

          $dispute_date = date('F Y',strtotime($dispute->created_date));

          $your_dispute[] = array("name"=>$dispute->firstname,"dispute"=>$dispute->message,"dispute_date"=>$dispute_date,"user_image"=>$img_url); 

          
        }
        echo json_encode(array("status"=>1,"message"=>"Success!","your_dispute"=>$your_dispute));

        exit;

      } else {

        echo json_encode(array("status"=>1,"message"=>"No data available!","your_dispute"=>$your_dispute));

        exit;

      }

    }

  

  }

  public function test_page()
  {
    
    $this->load->view('site/order/test.php');
  }
  
  public function test_api_post()
  {
    $test = $this->input->post ( 'test' );
    echo $test; exit;
  }
  /* TRUST AND VERIFICATION */
  public function trust_verification()
  {
       $user_id = $this->input->post('user_id');
        if($user_id =="" || $user_id ==0){
           echo json_encode(array('status'=>0,'message'=>'Parameter missing!'));
           exit;
        } 
      require_once('twilio/Services/Twilio.php');
      $account_sid = $this->config->item('twilio_account_sid'); 
      $auth_token = $this->config->item('twilio_account_token');
      $twilio_enabledisable=$this->config->item('twilio_onoff');
      $random_confirmation_number = mt_rand(100000, 999999);
      // $random_confirmation_number = "12345";    // for testing purpose once testing is done delete this line
      $excludeArr=array('product_id','mobile_code','user_id');
      $dataArr=array('mobile_verification_code'=>$random_confirmation_number);
      $condition=array('id'=>$user_id);
      $data = array(
            'mobile_verification_code'=>$random_confirmation_number
            );
        $condition = array(
            'id'=>$user_id
            );
        $this->mobile_model->update_details(USERS ,$data ,$condition);
      
      $from=$this->config->item('twilio_phone_number');
      if($this->input->post('mobile_code') && $this->input->post('phone_no'))
      {
        $mobile_code=$this->input->post('mobile_code');
        $phone_number=$this->input->post('phone_no');
      } else {

        $user_details_query = $this->mobile_model->get_all_details(USERS,array('id'=>$user_id));
         if($user_details_query->row()->ph_country == "") {
          echo json_encode(array('status'=>0,'message'=>'Country Missing!'));
           exit;
        }
        $mobile_code_query='SELECT country_mobile_code FROM '.LOCATIONS.' WHERE id='.$user_details_query->row()->ph_country;

        $mobile_code=$this->mobile_model->ExecuteQuery($mobile_code_query);

        $phone_number=$user_details_query->row()->phone_no;
        $mobile_code=$mobile_code->row()->country_mobile_code;
      }
      if($twilio_enabledisable==1) {
      $to=$mobile_code.$phone_number; //echo $to;die;
      try {
      $client = new Services_Twilio($account_sid, $auth_token); 

      $client->account->messages->create(array( 

        'To' => $to,  
        //'To' => '+919790153222', // test number

        'From' =>$from, 

        'Body' => "Hi This is from ".$this->config->item('meta_title')." and Your Verification Code is ".$random_confirmation_number,   

      ));
 $json_encode = json_encode(array('status'=>1,'message'=>"Success",'mobile_verification_code'=>intval($random_confirmation_number)));
} catch( Services_Twilio_RestException $e ) {
    $message=$e->getMessage(); // Or maybe log it
    // Handle the fact that "The requested resource /PhoneNumbers/310-69-5340 was not found"
 $json_encode = json_encode(array('status'=>0,'message'=>"Not valid setting Inputs. Please contact Administrator.",'mobile_verification_code'=>intval($random_confirmation_number)));
} 
      
      } else {
          $json_encode = json_encode(array('status'=>0,'message'=>"Verification Not Enabled. Please Contact administrator.",'mobile_verification_code'=>intval($random_confirmation_number)));
      }
      
      
      /*$json_encode = json_encode(array('status'=>0,'message'=>"Success",'mobile_verification_code'=>intval($random_confirmation_number)));*/
      echo $json_encode;
      exit;
  }
  /* Mobile NUmber verification validator */
  public function trust_verification_validator()
  {
      $user_id = $this->input->post('user_id');
      $mobile_verification_code = $this->input->post('mobile_verification_code');
      if($user_id =="" ||  $mobile_verification_code ==""){
         echo json_encode(array('status'=>0,'message'=>'Parameter missing!'));
         exit;
      } else {
          $user_details_query = $this->mobile_model->get_all_details(USERS,array('id'=>$user_id,'mobile_verification_code'=>
            $mobile_verification_code));
          if($user_details_query->num_rows()>0) {
            $data = array(
                 'ph_verified'=>'Yes'
            );
            $condition = array(
                'id'=>$user_id
            );
            $this->mobile_model->update_details(USERS ,$data ,$condition);
            echo json_encode(array('status'=>1,'message'=>'Success!'));
            exit;
          } else {
             echo json_encode(array('status'=>0,'message'=>'Invalid details!'));
             exit;
          }
         
      } 
  }
/* settings */
public function payment_settings()
{
$paypal_settings=unserialize($this->config->item('payment_0'));
$paypal_settings=unserialize($paypal_settings['settings']);

if($paypal_settings['mode'] == 'sandbox'){
        $this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
      }else{
        $this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
      }
if($paypal_settings['mode'] !="" && $paypal_settings['merchant_email']!="" && $paypal_settings['clientID']!="" && $paypal_settings['secretkey']!="") {
    $settings = array("mode"=>$paypal_settings['mode'],"paypal_merchant_email"=>$paypal_settings['merchant_email'],"clientID"=>$paypal_settings['clientID'],"secretkey"=>$paypal_settings['secretkey']);
echo json_encode(array('status'=>1,'message'=>'Success!','settings'=>$settings));
            exit;

} else {
    echo json_encode(array('status'=>0,'message'=>'Failure!'));
            exit;

}


}


  
  
  
  
  
  
}

/* End of file mobile.php no_image.jpg */
/* Location: ./application/controllers/site/mobile.php */
