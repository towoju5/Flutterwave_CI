<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** *  * Landing page functions * @author Teamtweaks * */

class Landing extends MY_Controller 
{	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie','date','form','email','text'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->library( 'jquery_stars' );
		$this->load->model(array('product_model','city_model','admin_model','cms_model','landing_model','slider_model','user_model'));
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->product_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		if($_SESSION['sColorLists'] == ''){
			
		}		
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
	 	if ($this->data['loginCheck'] != ''){
			$this->data['likedProducts'] = $this->product_model->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	}
	}   	
	public function index(){
		//featuredLists
		$this->data['heading'] = '';
	 	$this->data['totalProducts'] = $this->product_model->get_total_records(PRODUCT);
		
		$this->data['CityDetails'] = $this->city_model->Featured_city();
		
		
		$this->data['controller'] = $this;

		
		foreach($this->data['CityDetails']->result() as $r)
		{
			$city_name = $r->name;
			$country = $r->country;
			$this->data['CityName'][$city_name] = $this->city_model->cityall($city_name,$country)->result();

		}
	
		
		
		
		$this->data['CityCountDetails'] = $this->city_model->CityCountDisplay('neighborhoods,count(neighborhoods) as CityCountVal','neighborhoods',NEIGHBORHOOD);
		$this->data['SliderList'] = $this->slider_model->get_slider_details('WHERE status="Active"');
		$this->data['sliderList'] = $this->slider_model->get_all_details(SLIDER,$condition);
		$condition=array('id'=>1);
		$listValues = $this->product_model->get_all_details(LISTINGS,array('id'=>1));
		foreach ($listValues->result() as $result){	
			$values = $result->listing_values;
		}
		$roombedVal=json_decode($values);
		foreach ($roombedVal as $key => $values)		
		{
			$listing_values[$key] = $values;
		}
		
	/* 	if($listing_values['accommodates'] != ''){
			$accommodates= explode(',',$listing_values['accommodates']);
		}
		else{
			$accommodates= '';
		} */
		

		/**preetha - Start -  Get Listing child values of Accomodates**/
		$listChildValues = $this->product_model->get_all_details(LISTING_CHILD,array('parent_id'=>31));
		if ($listChildValues->num_rows() > 0) {
			foreach ($listChildValues->result() as $accom){
				$accommodates[]=$accom->child_name;
			}
		}else{
				$accommodates='';
		}
		/**preetha -End -  Get Listing child values of Accomodates**/
		
		
		$this->data['accommodates'] = $accommodates;
		$condition = array('id'=>'1');
		$enableRslt = $this->slider_model->get_all_details(ADMIN_SETTINGS,$condition);
		$this->data['featuredLists'] = $this->landing_model->get_featured_lists();
		$this->data['adminList'] = $enableRslt->row();
               $this->data['posts'] = $this->user_model->get_user_type();
       
       /* experience module data - check experience module enabled or not */
        /*
        $exprienceModuleExist = $this->landing_model->checkModuleStatus('experience');
        //print_r($exprienceModuleExist->num_rows());exit;
        $this->data['experienceExistCount'] = $exprienceModuleExist->num_rows();
		*/
        /* experience module ends  */


        /* experience module exist means display featured experience  */
        if($this->data['experienceExistCount']>0){
        	$sel_featuredExp = "select * from ".EXPERIENCE." as exp left join ".EXPERIENCE_PHOTOS." as ph on ph.product_id=exp.experience_id LEFT JOIN  ".EXPERIENCE_DATES." d  on d.experience_id=exp.experience_id where exp.status='1' and featured='1' and  d.from_date >'".date('Y-m-d')."'  group by exp.experience_id order by exp.added_date desc ";
        	//print_r($sel_featuredExp);
        	
			/*newly added*/
			
			$this->data ['featuredExperiences'] = $product  = $this->landing_model->get_exprience_view_details_withFilter ( '  where ' . $search . '  d.from_date > "' .date('Y-m-d'). '"'." and extyp.status='Active' and p.status='1' and p.featured='1' AND EXISTS
      ( select c.id FROM fc_experience_dates c where c.status='0' and c.experience_id=p.experience_id
      )  AND EXISTS (select count(td.id) FROM fc_experience_time_sheet td where td.status='1' and td.experience_id=p.experience_id) group by p.experience_id order by p.added_date desc ");
	  
			/*newly added*/
			
			
			
		//	$this->data['featuredExperiences'] = $this->landing_model->ExecuteQuery($sel_featuredExp);
			
			
			
			
        	//print_r($this->data['featuredExperiences']->result());

			//Experience Type Featured Starts
			
		    /*$sel_featuredExpType = "SELECT * FROM ".EXPERIENCE_TYPE." WHERE  featured = 1 and status='Active'";
        	$this->data['featuredExperiencesType'] = $this->landing_model->ExecuteQuery($sel_featuredExpType);
			foreach ($this->data['featuredExperiencesType']->result() as $exp_type){
			$exp_type_id=$exp_type->id;
			$get_featured_all = "select exp.*,et.id as e_type_id,et.experience_title from ".EXPERIENCE." as exp left join ".EXPERIENCE_PHOTOS." as ph on ph.product_id=exp.experience_id inner join " . EXPERIENCE_TYPE." as et on et.id=exp.type_id where exp.status='1' and exp.type_id = ". $exp_type_id .  " group by exp.experience_id order by exp.added_date desc ";
			$this->data['Cat_Type'][$exp_type_id] = $this->landing_model->ExecuteQuery($get_featured_all);
			}*/

		   //Experience Type Featured Ends 	
        }

        /* experience module exist means display featured experience  */
	
		$this->load->view('site/landing/landing',$this->data);
	}		
	
	public function display_cms_trips($product_id,$reviewer_id)	
	{		
		$product_id = $this->input->post('product_id');
		$reviewer_id = $this->input->post('reviewer_id');
		$this->data['reviewData'] = $this->product_model->get_trip_review($product_id,$reviewer_id);
		$data = $this->load->view('site/cms/rating',$this->data);
		if($this->data['reviewData']->num_rows>0)		
		{
			$res['count']='1';
			$res['data']=$data;
		}
		else {
			$res['count']='0';
		}
		echo json_encode($res);
	}

	public function display_product_detail($seourl)	
	{
		$where1 = array('p.status'=>'Publish','p.id'=>$seourl);
		$where_or = array('p.status'=>'Publish') ;
		$where2 = array('p.status'=>'Publish','p.id'=>$seourl);
		$this->load->model('admin_model');
		$this->data['admin_settings'] = $result = $this->admin_model->getAdminSettings();
		
		$this->data['productDetails'] = $this->product_model->view_product_details_site_one($where1,$where_or,$where2);
		
		
		
		if($this->data['productDetails']->row()->id==''){
			if($this->lang->line('List details not available') != '') 
				{ 
					$message = stripslashes($this->lang->line('List details not available')); 
				} 
				else 
				{
					$message = "List details not available";
				}
				$this->setErrorMessage('error',$message);
				redirect(base_url());
		}
		$this->data['productImages'] = $this->product_model->get_images($this->data['productDetails']->row()->id);
		$this->data['reviewData'] = $this->product_model->get_review($this->data['productDetails']->row()->id);
		if($this->checkLogin('U') != '')		
		{
			$this->data['user_reviewData'] = $this->product_model->get_review($this->data['productDetails']->row()->id,$this->checkLogin('U'));
			$this->data['reviewData'] = $this->product_model->get_review_other($this->data['productDetails']->row()->id,$this->checkLogin('U'));
			
		}
		$this->data['reviewTotal'] = $this->product_model->get_review_tot($this->data['productDetails']->row()->id);
		$product_id = $this->data['productDetails']->row()->id;
		$this->data['product_details'] = $this->product_model->view_product1($product_id);
		$this->data['RatePackage']='';
		$this->data['heading'] = $this->data['productDetails']->row()->meta_title;
		if ($this->data['productDetails']->row()->meta_title != '')
		{	
			$this->data['meta_title'] = $this->data['productDetails']->row()->meta_title;
		}
		if ($this->data['productDetails']->row()->meta_keyword != '')
		{	    	
			$this->data['meta_keyword'] = $this->data['productDetails']->row()->meta_keyword;
		}
		if ($this->data['productDetails']->row()->meta_description != '')
		{	    	
			$this->data['meta_description'] = $this->data['productDetails']->row()->meta_description;
		}
		
		$listings_hometype=$this->product_model->get_all_details(LISTSPACE_VALUES,array('id'=>$this->data['product_details']->row()->home_type)); 
		
		if(!empty($listings_hometype)){
			$listings_hometype=$listings_hometype->row()->list_value;
		}else{
			$listings_hometype='';
		}
		
		$this->data['listings_hometype'] = $listings_hometype;
		
		$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT,array('status'=>'Active'));					
		$this->data['pay_option'] = $this->product_model->get_all_details(PRODUCT,array('id'=>$seourl));
		
		$this->data['instant_pay'] = $this->product_model->get_all_details(MODULES_MASTER,array('module_name'=>'payment_option')); //Instant pay option should be enable in admin settings too
		
        $this->data['listNameCnt'] = $this->product_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
		$this->data['listValueCnt'] = $this->product_model->get_all_details(LIST_VALUES,array('status'=>'Active'));
		$this->data['listItems'] = $this->product_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
		$wishlists= $this->product_model->get_all_details(LISTS_DETAILS, array('user_id'=>$this->checkLogin ( 'U' )));
		$newArr = array();
		foreach($wishlists->result() as $wish)		
		{			
			$newArr = array_merge($newArr , explode(',', $wish->product_id));
		}
		$this->data ['newArr'] = $newArr;
		$this->data['SublistDetail'] = $this->product_model->get_all_details(LIST_SUB_VALUES,$contition);
		$rental_category_subcategory=$this->product_model->amenities_main_sub_category($this->data['product_details']->row()->list_name);
	    $this->data['subcategory']=$rental_category_subcategory;
        $listIdArr=array();
		foreach($this->data['listValueCnt']->result_array() as $listCountryValue)
		{
			$listIdArr[]=$listCountryValue['list_id'];
		}	
		$this->data['ChkWishlist']='0';
		if($this->checkLogin('U') > 0 )
		{
			$this->data['getWishList'] = $this->product_model->ChkWishlistProduct($this->data['productDetails']->row()->id,$this->checkLogin('U'));
			$this->data['ChkWishlist']=$this->data['getWishList']->num_rows();
		}		
		$this->data['DistanceQryArr'] = $this->product_model->view_product_details_distance_list($this->data['productDetails']->row()->latitude,$this->data['productDetails']->row()->longitude,' p.id <> '.$this->data['productDetails']->row()->id.' and  p.status="Publish" group by p.id order by p.id  DESC');
		
		
		$this->data['ConfigBooking'] = $this->product_model->get_all_details(BOOKINGCONFIG,array('cal_url'=>base_url()));
		
		
		
		if($this->data['ConfigBooking']->num_rows()=='')
		{			
			$this->product_model->update_details(BOOKINGCONFIG,array('cal_url'=>base_url()),array());
		}		
		/*-Muthu-*/		
		$this->data['CalendarBooking'] = $this->product_model->get_all_details(CALENDARBOOKING,array('PropId'=>$this->data['productDetails']->row()->id));
		
		if($this->data['CalendarBooking']->num_rows() > 0)
		{	
			foreach($this->data['CalendarBooking']->result()  as $CRow){
				$DisableCalDate .='"'.$CRow->the_date.'",';
			}
			$this->data['forbiddenCheckIn']='['.$DisableCalDate.']';
		}
		else
		{
			$this->data['forbiddenCheckIn']='[]';
			$this->data['forbiddenCheckOut']='[]';
		}
		
		
		
		$all_dates = array();
		$selected_dates = array();
		foreach($this->data['CalendarBooking']->result()  as $date)
		{	
			$all_dates[] = trim($date->the_date);
			
			$date1 = new DateTime(trim($date->the_date));
			
			$date2 = new DateTime($prev);
			
			
			
			$diff = $date2->diff($date1)->format("%a"); //diff in days
			

			
			if($diff == '1')
			{	
				$selected_dates[] = trim($date->the_date);
			}
			
			$prev = trim($date->the_date);
			
			
			$DisableCalDate = '';
			foreach($all_dates as $CRow)
			{
				$DisableCalDate .= '"'.$CRow.'",';
			}	
			$this->data['forbiddenCheckIn']='['.$DisableCalDate.']';
			
			
			
			
			$DisableCalDate = '';
			foreach($selected_dates as $CRow)
			{
				$DisableCalDate .= '"'.$CRow.'",';
			}	
			$this->data['forbiddenCheckOut']='['.$DisableCalDate.']';
		}	
		/*Muthu*/	
		$service_tax_query='SELECT * FROM '.COMMISSION.' WHERE seo_tag="guest-booking" AND status="Active"';
		$this->data['service_tax']=$this->product_model->ExecuteQuery($service_tax_query);
		
		//[IDproof_Verify]	
		
		
		//[IDproof_Verify]	
		if ($this->data['productDetails']->row()->user_id!=''){
		$existCheck = "SELECT * FROM ".ID_PROOF." WHERE user_id=".$this->data['productDetails']->row()->user_id;
		$this->data['proof_verify'] = $this->product_model->ExecuteQuery($existCheck);
		}
		
		
		$this->data['ProductDealPrice']=$this->product_model->get_all_details(PRODUCT_DEALPRICE,array('product_id'=>$seourl));

		$this->load->view('site/rentals/product_detail',$this->data);
	}	
	
	function fbLogin()	
	{		
		$rUrl = $this->input->post('rUrl');
		//echo $rUrl;
		//exit();
		$userdata = array('rUrl'=>$rUrl,'datefrom'=>$datefrom,'expiredate'=>$expiredate,'number_of_guests'=>$number_of_guests);
		$this->session->set_userdata($userdata);
		$this->load->view('site/templates/header',$this->data);

	}
	public function facebooklogin()
   {  
  // echo "test "; echo $this->input->get('email');
		
        $fb_id = $this->input->get('fid');
        $pic = $this->input->get('picture');
		$ustatus = $this->input->get('u_status');
		$ustatus = $this->input->get('u_status');

		$datefrom = $this->input->post('datefrom');
		$expiredate = $this->input->post('expiredate');
		$number_of_guests = $this->input->post('number_of_guests');
		$userdata = array('datefrom'=>$datefrom,'expiredate'=>$expiredate,'number_of_guests'=>$number_of_guests);
		$this->session->set_userdata($userdata);
        if($pic!=""){
			//$profile_img = 'https://graph.facebook.com/'.$fb_id.'/picture?type=large';
			$profile_img = 'https://graph.facebook.com/'.$fb_id.'/picture';
			$profile_image = $fb_id.'.jpg';
			$image = file_get_contents($profile_img); // sets $image to the contents of the url
			file_put_contents('images/users/'.$fb_id.'.jpg', $image); // places the contents in the file /path/image.gif
			

        } else {
        	$profile_image = 'profile.png';
        }
		$email = $this->input->get('email');
		$orgPass = time();
				$pwd = md5($orgPass);
				$Confirmpwd = $orgPass;
        $data  = array(
			'loginUserType'=>'facebook',
            'user_name' => $this->input->get('name'),
            'email' => $this->input->get('email'),
			'f_id' =>$this->input->get('fid'),
			'firstname'=>$this->input->get('name'),
			'facebook'=>'Yes',
			'password'=>$pwd,
			'image'=>$profile_image
			
			
			
            
       );
	 
				//$ret = $this->landing_model->facebook_get();
				//echo $ret->email; exit;
				//$data['query'] = $this->landing_model->facebook_get();
				//$data['query']->$email; exit;
		
	    $return = $this->landing_model->facebook($data,$fb_id);
		//redirect('index');
		//$return = $this->landing_model->facebook_login_check($data,$fb_id);
		//print_r($return);

		
    }
	public function facebook_logout()
    {
        $datestring = "%Y-%m-%d %h:%i:%s";
		$time = time ();
		$newdata = array (
				'last_logout_date' => mdate ( $datestring, $time ) 
		);
		$condition = array (
				'id' => $this->checkLogin ( 'U' ) 
		);
		$this->user_model->update_details ( USERS, $newdata, $condition );
		$userdata = array (
				'fc_session_user_id' => '',
				'session_user_name' => '',
				'session_user_email' => '',
				'fc_session_temp_id' => '',
				'login_type' =>'',
				'normal_login' => ''
		);
		$this->session->unset_userdata ( $userdata );
		//$this->load->url('https://accounts.google.com/logout');
		@session_start ();
		unset ( $_SESSION ['token'] );
		$twitter_return_values = array (
				'tw_status' => '',
				'tw_access_token' => '' 
		);
		
		$this->session->unset_userdata ( $twitter_return_values );
		if($this->lang->line('User_Profile_Information_Updated_successfully') != '') 
				{ 
					$message = stripslashes($this->lang->line('User_Profile_Information_Updated_successfully')); 
				} 
				else 
				{
					$message = "User Profile Information Updated successfully";
				}
			$this->setErrorMessage ( 'success', $message);
			redirect ( base_url () );
		
    }
	/*Review*/
	
	public function get_avg_review_experience($id){
		
		$sql=" select count(*) as num_reviewers,avg(total_review) as avg_val from ".EXPERIENCE_REVIEW." where product_id=".$id." and status='Active'";
		$result=$this->db->query($sql);
		$res=$result->row();
		return $res;
	}
	
	
	/**get The Password From DB**/
	public function get_password(){
		$email=$this->input->post('email');
		$getpassword=$this->landing_model->get_password($email);
		$thePassword=$getpassword->row()->confirm_password;
		echo $thePassword;	
	}
	
	
      
}
/* End of file landing.php */
/* Location: ./application/controllers/site/landing.php */