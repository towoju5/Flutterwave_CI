<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to Cart Page
 * @author Teamtweaks
 *
 */
class Account_model extends My_Model
{
	
	
	public function view_newbooking_details(){
		
		$today = date('Y-m-d'); 

		$this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID');
		$this->db->from(RENTALENQUIRY.' as rq');
		$this->db->join(USERS.' as u' , 'rq.user_id = u.id');
		$this->db->join(PRODUCT.' as pd' , 'pd.id = rq.prd_id');
		//$this->db->where('rq.booking_status = "'.$status.'"');	
		
		$this->db->where('DATE(rq.checkin)>=',$today); /* malar- new booking checkin must be from today */ 
		$this->db->where("(rq.booking_status!='Booked')"); //malar-booked-property not booked
		$this->db->order_by("rq.dateAdded", "desc"); 
		$PrdList = $this->db->get();
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}
	
	
	
	
	
	public function view_newbooking_details_confirmed(){

		$today = date('Y-m-d');

		$this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID,py.status as status,py.dval,py.total_amt,py.is_coupon_used,py.discount,py.currency_code,cu.currency_symbols');
		$this->db->from(RENTALENQUIRY.' as rq');
		$this->db->join(USERS.' as u' , 'rq.user_id = u.id');
		$this->db->join(PRODUCT.' as pd' , 'pd.id = rq.prd_id');
		$this->db->join(PAYMENT.' as py' , 'py.EnquiryId = rq.id');
		$this->db->join(CURRENCY.' as cu' , 'cu.currency_type = rq.currencycode');
		$this->db->where('py.status = "Paid"');	
		$this->db->where('rq.booking_status',"Booked"); //malar-booked-property is booked(payment done)
		$this->db->where('DATE(rq.checkin)>=',$today); /* malar- new booking checkin must be from today - upcoming confirm booking */ 
		$this->db->order_by("rq.dateAdded", "desc"); 
		$PrdList = $this->db->get();
		
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}
	
	
	
	
	
	
	
	public function view_newbooking_detailsexp($status){

		$today = date('Y-m-d'); 

		$this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID');
		$this->db->from(RENTALENQUIRY.' as rq');
		$this->db->join(USERS.' as u' , 'rq.user_id = u.id');
		$this->db->join(PRODUCT.' as pd' , 'pd.id = rq.prd_id');		
		$this->db->where('rq.approval = "'.$status.'"');
		//$this->db->where('rq.booking_status',"Booked"); //malar-booked-property is booked(payment done)	
		$this->db->where('DATE(rq.checkout)<',$today);

		/* $today = date('Y-m-d'); 
		$today =  date('Y-m-d',strtotime(date('Y-m-d', strtotime("-6 days"))));
		$minvalue = $today.' 00:00:00';
		$maxvalue = $today.' 23:59:59';
		$this->db->where("rq.dateAdded =",$today);
		$this->db->where( "rq.dateAdded BETWEEN '$minvalue' AND '$maxvalue'", NULL, FALSE); */
		$PrdList = $this->db->get();
		//echo $this->db->last_query(); die;
		
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}
	
	
	public function view_newbooking_detailsexp_nw(){

		$today = date('Y-m-d'); 

		$this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID');
		$this->db->from(RENTALENQUIRY.' as rq');
		$this->db->join(USERS.' as u' , 'rq.user_id = u.id');
		$this->db->join(PRODUCT.' as pd' , 'pd.id = rq.prd_id');		
		//$this->db->where('rq.approval = "'.$status.'"'); // malar- commented - all expire list
		//$this->db->where('rq.booking_status',"Booked"); //malar-booked-property is booked(payment done)	
		$this->db->where('DATE(rq.checkout)<',$today);

		/* $today = date('Y-m-d'); 
		$today =  date('Y-m-d',strtotime(date('Y-m-d', strtotime("-6 days"))));
		$minvalue = $today.' 00:00:00';
		$maxvalue = $today.' 23:59:59';
		$this->db->where("rq.dateAdded =",$today);
		$this->db->where( "rq.dateAdded BETWEEN '$minvalue' AND '$maxvalue'", NULL, FALSE); */
		$PrdList = $this->db->get();
		//echo $this->db->last_query(); die;
		
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}

?>