<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to Order management 
 * @author Teamtweaks
 *
 */ 

class Experience_Account extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->model('experience_account_model');
		if ($this->checkPrivileges('BookingStatus',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the order list page
     */
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/experience_account/display_newbooking');
		}
	}
	
	/**
	 * 
	 * This function loads the order list page
	 */
	public function display_newbooking(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'New Booking List';
			$this->data['newbookingList'] =$this->experience_account_model->view_newbooking_details();
			//echo $this->db->last_query();
			//print_r($this->data['newbookingList']->result());
			//$this->experience_account_model->view_newbooking_details('Pending');
			//echo '<pre>'; print_r($this->data['newbookingList']->result_array()); die;
			$this->load->view('admin/experience_account/display_newbooking',$this->data);
		}
	}
	
	
	public function display_book_confirmed(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Upcoming Completed Booking List';
			$this->data['newbookingList'] = $this->experience_account_model->view_newbooking_details_confirmed();

			//$this->experience_account_model->view_newbooking_details('Booked');
			//echo '<pre>'; print_r($this->data['newbookingList']->result_array()); die;
			$this->load->view('admin/experience_account/display_book_confirmed',$this->data);
		}
	}
	
	
	
	public function display_book_expired(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
		    //echo $today =  date('y-m-d H:m:s',strtotime(date('Y-m-d', strtotime("-5 days"))));
		
			$this->data['heading'] = 'Expired Booking List';
			//$this->data['newbookingList'] = $this->experience_account_model->view_newbooking_detailsexp('Pending');
			
			$this->data['newbookingList'] = $this->experience_account_model->view_newbooking_detailsexp_nw();
			
			
			//echo '<pre>'; print_r($this->data['newbookingList']->result_array()); die;
			$this->load->view('admin/experience_account/display_book_expired',$this->data);
		}
	}
	
	public function display_order_pending(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Order List';
			$this->data['orderList'] = $this->experience_account_model->view_order_details('Pending');
			$this->load->view('admin/experience_account/display_orders_pending',$this->data);
		}
	}
	
	public function customerExcelExportNewBooking() 
	{
		/*
        $status=$this->uri->segment(4);	
		$condition = array();
		$UserDetails = $this->experience_account_model->view_newbooking_details(ucfirst($status));
		$data['getCustomerDetails'] = $UserDetails->result_array();
		if($status=="booked") {
		$status ="Completed";
		}
		$data['title'] =ucfirst($this->config->item('email_title'))." ".ucfirst($status);
	    $data['status']= ucfirst($status);		
		$this->load->view('admin/accounts/customerExportExcelNewBooking',$data);
		*/

		$status=$this->uri->segment(4);	
		$condition = array();
		if($status=='enquiry')
			$UserDetails = $this->experience_account_model->view_newbooking_details();
		elseif($status=='booked')
			$UserDetails = $this->experience_account_model->view_newbooking_details_confirmed();
		elseif($status=='expiry')
			$UserDetails = $this->experience_account_model->view_newbooking_detailsexp_nw();

		$data['getCustomerDetails'] = $UserDetails->result_array();
		if($status=="booked") {
		$status ="Completed";
		}
		//print_r($status);exit;
		$data['title'] = ucfirst($status)."_booking_";
		//print_r($title);exit;
	    $data['status']= ucfirst($status);
		$data['admin_currency_symbol'] = $this->data['admin_currency_symbol'];
		$data['admin_currency_code'] = $this->data['admin_currency_code'];
		
		$this->load->view('admin/experience_account/customerExportExcelNewBooking',$data);

	}	
	
	public function customerExcelExportExpired() 
	{
        $status="Expired_booking";
		$condition = array();
		//$UserDetails = $this->experience_account_model->view_newbooking_detailsexp('Booked');
		$UserDetails = $this->experience_account_model->view_newbooking_detailsexp_nw();
		
		$data['getCustomerDetails'] = $UserDetails->result_array();
		$data['title'] = ucfirst($status);
	    $data['status']= $status;
		$data['admin_currency_symbol'] = $this->data['admin_currency_symbol'];
		$data['admin_currency_code'] = $this->data['admin_currency_code'];		
		$this->load->view('admin/experience_account/customerExportExcelexpired',$data);
	}	
	
	
}

/* End of file order.php */
/* Location: ./application/controllers/admin/order.php */