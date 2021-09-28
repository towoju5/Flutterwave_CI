<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * This model contains all db functions related to user management

 * @author Teamtweaks

 *

 */

class review_model extends My_Model

{

	public function __construct()

	{

		parent::__construct();

	}

	public function UpdateActiveStatus($table='',$data=''){

		$query =  $this->db->get_where($table,$data);

		return $result = $query->result_array();

	}

	

	function Display_ContactInfo($condition='')

	{

		$this->db->select('c.*,p.product_name,u.full_name,u.user_name');

		$this->db->from(CONTACT.' as c');

		$this->db->join(PRODUCT.' as p',"c.rental_id=p.id","LEFT");

		$this->db->join(USERS.' as u',"c.renter_id=u.id","LEFT");

		if(!empty($condition)){

			$this->db->where('p.id',$condition);

			$this->db->order_by('c.id','desc');

		}else{

			$this->db->where('c.id !=','');

			$this->db->order_by('c.id','desc');

		}

		//$this->db->where('p.status','Publish');

		return $query = $this->db->get();

		//echo $this->db->last_query();

		//return $result =$query->result_array();

		//echo "<pre>";print_r($result);die;

	}

	

	function get_contactAll_details($contactgorup='',$contactorder=''){



	//echo "<pre>";print_r($contactorder);die;

		$this->db->select('c.*,p.product_name,u.full_name,u.user_name,u.contact_count,p.contact_count as rental_count');

		$this->db->from(CONTACT.' as c');

		$this->db->join(PRODUCT.' as p',"c.rental_id=p.id","LEFT");

		$this->db->join(USERS.' as u',"c.renter_id=u.id","LEFT");

		$this->db->where('c.status','Active');

		$this->db->group_by($contactgorup);

		foreach($contactorder as $conkey=>$conVal) {

			$this->db->order_by($conkey,$conVal);

		}

		$this->db->limit('5');

		//$this->db->get();

		//echo $this->db->last_query();die;

		//echo "<pre>";print_r($result);die;

		return $query = $this->db->get();

	}

	

	function get_all_review_details()

		{

			$this->db->select('r.*, p.id as product_id, p.product_title');

			$this->db->from(REVIEW.' as r');

			$this->db->join(PRODUCT.' as p',"r.product_id=p.id","LEFT");

			$this->db->order_by('r.dateAdded','desc');

			return $query = $this->db->get();

		}

	function get_all_dispute_details()

		{

			$this->db->select('d.*, p.id as product_id, p.product_title,u.email');

			$this->db->from(DISPUTE.' as d');

			$this->db->join(PRODUCT.' as p',"d.prd_id=p.id","LEFT");

			$this->db->join(USERS.' as u',"u.id = d.user_id","LEFT");

			$this->db->order_by('d.created_date','desc');
			
			$this->db->where('d.cancel_status',0);
			
			$this->db->group_by('d.id');

			return $query = $this->db->get();

			

		}
		function get_all_dispute_cancel_booking()

		{

			$this->db->select('d.*, p.id as product_id, p.product_title,u.email');

			$this->db->from(DISPUTE.' as d');

			$this->db->join(PRODUCT.' as p',"d.prd_id=p.id","LEFT");

			$this->db->join(USERS.' as u',"u.id = d.user_id","LEFT");

			$this->db->order_by('d.created_date','desc');
			
			$this->db->where('d.cancel_status',1);

			$this->db->group_by('d.id');

			return $query = $this->db->get();

			

		}

		

	function get_review_details($review_id='')

		{

			$this->db->select('r.*,p.product_title,u.user_name');

			$this->db->from(REVIEW.' as r');

			$this->db->join(PRODUCT.' as p',"r.product_id=p.id","LEFT");

			$this->db->join(USERS.' as u',"r.email=u.email","LEFT");

			$this->db->where('r.id',$review_id);

			return $query = $this->db->get_where();

		}

	function get_dispute_details($booking_no='')

		{

			$this->db->select('d.*,p.product_title,u.user_name,u.email,mm.senderId as med_senderid,mm.receiverId as med_receiverid,p.user_id as host_id');

			$this->db->from(DISPUTE.' as d');

			$this->db->join(PRODUCT.' as p',"d.prd_id=p.id","LEFT");

			$this->db->join(USERS.' as u',"d.user_id=u.id","LEFT");

			$this->db->join(MED_MESSAGE.' as mm',"mm.bookingNo=d.booking_no","LEFT");

			$this->db->where('d.booking_no',$booking_no);

			return $query = $this->db->get_where();

		}

/* 	function get_productreview_byyou($user_id='')

		{

			$this->db->select('r.*,p.product_title,u.image');

			$this->db->from(REVIEW.' as r');

			$this->db->where('r.reviewer_id', $user_id);

			$this->db->join(PRODUCT.' as p',"r.product_id=p.id");

			$this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");

			return $query = $this->db->get_where();

		} */
		
		
		
		function get_productreview_byyou($condition='')

		{
			$this->db->cache_on();
			$select_qry = "SELECT r.*,p.product_title,u.image from ".REVIEW." r 
			JOIN ".PRODUCT." p on p.id=r.product_id
			LEFT JOIN ".USERS." u on u.id=r.reviewer_id ".$condition;
			//echo $select_qry;
			$reviewList = $this->ExecuteQuery($select_qry);
			return $reviewList;
		}

/* 		function get_productdispute_byyou($user_id='')
		{

			$this->db->select('d.*,p.product_title,u.image');

			$this->db->from(DISPUTE.' as d');

			$this->db->where('d.user_id', $user_id);

			$this->db->join(PRODUCT.' as p',"d.prd_id=p.id");

			$this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");

			return $query = $this->db->get_where();

		} */
		
		
		function get_productdispute_byyou($condition='')
		{
			$this->db->cache_on();
			$select_qry = "SELECT d.*,p.product_title,u.image from ".DISPUTE." d 
			JOIN ".PRODUCT." p on p.id=d.prd_id
			LEFT JOIN ".USERS." u on u.id=d.user_id ".$condition;
			$disputeList = $this->ExecuteQuery($select_qry);
			return $disputeList;
		}
		
		
		

/* 	function get_productreview_aboutyou($user_id='')

		{

			$this->db->select('r.*,p.product_title,u.image');

			$this->db->from(REVIEW.' as r');

			$this->db->where('r.user_id', $user_id);

			$this->db->join(PRODUCT.' as p',"r.product_id=p.id");

			$this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");

			return $query = $this->db->get_where();

		} */
		
		
		
	 	function get_productreview_aboutyou1($user_id='')

		{

			$this->db->select('r.*,p.product_title,u.image');

			$this->db->from(REVIEW.' as r');

			$this->db->where('r.user_id', $user_id);		
			$this->db->join(PRODUCT.' as p',"r.product_id=p.id");

			$this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");

			return $query = $this->db->get_where();

		} 
		
		
	function get_productreview_aboutyou($condition='')
		{
	
		$this->db->cache_on();
		$select_qry = "SELECT r.*,p.product_title,u.image from ".REVIEW." r 
		JOIN ".PRODUCT." p on p.id=r.product_id
		LEFT JOIN ".USERS." u on u.id=r.reviewer_id ".$condition;
		//echo $select_qry;
		$reviewList = $this->ExecuteQuery($select_qry);
		return $reviewList;
		}
		
		
		
/* 		function get_productdispute_aboutyou($user_id='')

		{
			

			$this->db->select('d.*,p.product_title,p.user_id,u.image');

			$this->db->from(DISPUTE.' as d');

			$this->db->where('d.disputer_id', $user_id);
			$this->db->where('d.cancel_status', 0);
			$this->db->join(PRODUCT.' as p',"d.prd_id=p.id");

			$this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");

			return $query = $this->db->get_where();

		}
 */
 
 
		function get_productdispute_aboutyou($condition='')

		{
			$this->db->cache_on();
			$select_qry = "SELECT d.*,p.product_title,p.user_id,u.image FROM ".DISPUTE." d 
			JOIN ".PRODUCT." p on p.id=d.prd_id
			LEFT JOIN ".USERS." u on u.id=d.user_id ".$condition;
			//echo $select_qry;
			$disputeList = $this->ExecuteQuery($select_qry);
			return $disputeList;

		}



		
	/*get cancel booking dispute details*/
	
/* 	function get_cancel_dispute($user_id='')
	{
		//print_r($user_id);exit;
		$this->db->select('d.*,p.product_title,p.user_id,u.image');

			$this->db->from(DISPUTE.' as d');

			$this->db->where('d.disputer_id', $user_id);
			
			$this->db->where('d.cancel_status', 1);

			$this->db->join(PRODUCT.' as p',"d.prd_id=p.id");

			$this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");

			return $query = $this->db->get_where();
	} */
	
	
	/*End */
	
	
	function get_cancel_dispute($condition='')
	{

			$this->db->cache_on();
			$select_qry = "SELECT d.*,p.product_title,p.user_id,u.image from ".DISPUTE." d 
			JOIN ".PRODUCT." p on p.id=d.prd_id
			LEFT JOIN ".USERS." u on u.id=d.user_id ".$condition;
			//echo $select_qry; 
			$cancelDisputeList = $this->ExecuteQuery($select_qry);
			return $cancelDisputeList;
		
	}
	
		
	function get_productreview_details1($user_id='')
	

		{

			//echo $user_id; die;

			$this->db->select('r.*,p.product_title,pp.product_image');

			$this->db->from(REVIEW.' as r');

			$this->db->join(PRODUCT.' as p',"r.product_id=p.id");

			$this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=r.product_id","LEFT");

			//$this->db->where('u.id',$user_id);

			//$this->db->select('r.*,p.product_title,u.thumbnail,pp.product_image');

			//$this->db->from(REVIEW.' as r');

			//$this->db->join(PRODUCT.' as p',"r.product_id=p.id");

			//$this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=r.product_id","LEFT");

			//$this->db->join(USERS.' as u',"u.id=r.reviewer_id");

			//$this->db->where('u.id',$user_id);

			return $query = $this->db->get_where();

			//echo $this->db->last_query(); die;

			

		}

		

		function get_productreview_details($user_id='')

		{

		//echo $user_id; die;

		$this->db->select('r.*,p.product_title,pp.product_image');

		$this->db->from(REVIEW.' as r');

		$this->db->join(PRODUCT.' as p',"r.product_id=p.id");

		$this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=r.product_id","LEFT");

		$this->db->join(USERS.' as u',"u.id=r.reviewer_id");

			//$this->db->where('u.id',$user_id);

			// $this->db->select('r.*,p.product_title,u.thumbnail,pp.product_image');

			// $this->db->from(REVIEW.' as r');

			// $this->db->join(PRODUCT.' as p',"r.product_id=p.id");

			// $this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=r.product_id","LEFT");

			// $this->db->join(USERS.' as u',"u.id=r.reviewer_id");

			$this->db->where('u.id',$user_id);

			return $query = $this->db->get_where();

			//echo $this->db->last_query(); die;

			

		}

		

		

	function get_yourproductreview_details($user_id='')

		{

			$this->db->select('r.*,p.product_title,u.thumbnail,pp.product_image');

			$this->db->from(REVIEW.' as r');

			$this->db->join(PRODUCT.' as p',"r.product_id=p.id");

			$this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=r.product_id","LEFT");

			$this->db->join(USERS.' as u',"u.id=r.user_id");

			$this->db->where('u.id',$user_id);

			$this->db->group_by('r.id');

			return $query = $this->db->get_where();

			//echo $this->db->last_query();die;

			

		}

		

	function get_phone_number_verified($user_id='')

		{	

	

			$this->db->select('*');

			$this->db->from(REQUIREMENTS);

			$this->db->where('id',$user_id);
			return $query = $this->db->get_where();
		}
		
		
		public function get_all_commission_tracking($customer_id)
		{
			$Query = "select * from ".COMMISSION_TRACKING." c JOIN ".RENTALENQUIRY." re on re.Bookingno=c.booking_no JOIN ".USERS." u on re.user_id=u.id  where  cancelled = 'yes' AND `user_id`='".$customer_id."'";
			return $this->ExecuteQuery($Query)->result();
		}
		
		public function get_all_experience_commission_tracking($customer_id='')
		{
		$Query = "select * from ".EXP_COMMISSION_TRACKING." c JOIN ".EXPERIENCE_ENQUIRY." re on re.Bookingno=c.booking_no JOIN ".USERS." u on re.user_id=u.id  where  cancelled = 'yes' AND `user_id`='".$customer_id."'";
		return $this->ExecuteQuery($Query)->result();
		
		}
		
		public function get_all_cancelled_users()
		{
			$this->db->select('*');
			$this->db->from(RENTALENQUIRY.' as r');
			$this->db->join(USERS.' as u',"r.user_id=u.id");
			$this->db->where('r.cancelled','Yes');
			$this->db->group_by('r.user_id');
			return $query = $this->db->get_where();
		}
		
		public function get_all_experienced_cancelled_users()
		{
			$this->db->select('*');
			$this->db->from(EXPERIENCE_ENQUIRY.' as r');
			$this->db->join(USERS.' as u',"r.user_id=u.id");
			$this->db->where('r.cancelled','Yes');
			$this->db->group_by('r.user_id');
			return $query = $this->db->get_where();
		}
		
		public function get_paid_details($customer_id)
		{

			$Query = "select c.* , re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.subtotal from ".COMMISSION_TRACKING." c JOIN ".RENTALENQUIRY." re on re.Bookingno=c.booking_no where paid_canel_status = '1' AND `user_id`='".$customer_id."'";
			return $this->ExecuteQuery($Query)->result_array();
		
		}
		public function get_paid_details_host($hostEmail)
		{

			$Query = "select c.* , re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.subtotal from ".COMMISSION_TRACKING." c JOIN ".RENTALENQUIRY." re on re.Bookingno=c.booking_no where paid_canel_status = '1' AND `host_email`='".$hostEmail."'";
			return $this->ExecuteQuery($Query)->result_array();
		
		}
		public function get_commission_track_id($id){

		$Query = "select c.* , re.prd_id from ".COMMISSION_TRACKING." c JOIN ".RENTALENQUIRY." re on re.Bookingno=c.booking_no where c.booking_no='".$id."'";
		return $this->ExecuteQuery($Query);
	}
	public function get_exp_commission_track_id($id){

		$Query = "select c.* , re.prd_id,u.email from ".EXP_COMMISSION_TRACKING." c JOIN ".EXPERIENCE_ENQUIRY." re on re.Bookingno=c.booking_no LEFT JOIN ".USERS." u on u.id=re.user_id where c.booking_no='".$id."'";
		return $this->ExecuteQuery($Query);
	}
	public function get_unpaid_commission_tracking($sellerEmail,$id){
	
		$Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller from ".COMMISSION_TRACKING." c JOIN ".RENTALENQUIRY." re on re.Bookingno=c.booking_no where  c.paid_canel_status = '0' AND c.booking_no = '".$id."' AND  `host_email`='".$sellerEmail."'";
		return $this->ExecuteQuery($Query)->result_array();
	}
	public function get_unpaid_commission_tracking_details($sellerEmail,$id){
	
		$Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller from ".COMMISSION_TRACKING." c JOIN ".RENTALENQUIRY." re on re.Bookingno=c.booking_no where  c.paid_canel_status = '0'  AND c.booking_no = '".$id."' AND  `host_email`='".$sellerEmail."'";
		return $this->ExecuteQuery($Query)->result_array();
	}
	public function get_unpaid_exp_commission_tracking($sellerEmail,$id){
	
		$Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller from ".EXP_COMMISSION_TRACKING." c JOIN ".EXPERIENCE_ENQUIRY." re on re.Bookingno=c.booking_no where  c.paid_canel_status = '0' AND c.booking_no = '".$id."' AND  `host_email`='".$sellerEmail."'";
		return $this->ExecuteQuery($Query)->result_array();
	}
	
}