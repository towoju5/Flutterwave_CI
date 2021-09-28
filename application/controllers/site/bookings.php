<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Shop related functions
 * @author Teamtweaks
 * 
 */

class Bookings extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('bookings_model');
		$this->data ['loginCheck'] = $this->checkLogin ( 'U' );
	}
    
	public function my_trips()
	{
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			$keyword = "";
			if ($_POST) {
				$keyword = $this->input->post ('product_title');
			}

            $this->load->model('admin_model');
			$this->data ['heading'] = 'Dashboard-Trips';
			$this->data ['bookedRental'] = $this->bookings_model->booked_rental_trip( $this->checkLogin ('U'), $keyword );
			$this->data['user_id'] = $this->checkLogin('U');
			$this->load->view ( 'site/user/my_trips', $this->data );
		}
	}
    
	public function cancel_request()
	{
		if ($this->checkLogin ( 'U' ) == '') {
			redirect ( base_url () );
		} else {
			$json = array();
			$json['status'] = 0;
			$bookingNo = $this->uri->segment ( 2 );
			$bookingDetails = $this->bookings_model->get_all_details(RENTALENQUIRY, array('Bookingno' => $bookingNo));
			$productDetails = $this->bookings_model->get_all_details(PRODUCT, array('id' => $bookingDetails->row()->prd_id));
			$cancellation_policy = $productDetails->row()->cancellation_policy;
			$actual = $bookingDetails->row()->checkout;
			if($cancellation_policy == 'Flexible')
			$eligible = date('Y-m-d h:i:s', strtotime("+1 days"));
			else if($cancellation_policy == 'Moderate')
			$eligible = date('Y-m-d h:i:s', strtotime("+5 days"));
			else if($cancellation_policy == 'Strict')
			$eligible = date('Y-m-d h:i:s', strtotime("+7 days"));
			$eligible;
			$checkIn = date('Y-m-d h:i:s', strtotime($bookingDetails->row()->checkin."+17 Hours"));
			if($eligible < $checkIn)
			{
				$this->data['cancellation_policy'] = $productDetails->row()->cancellation_policy;
				$this->data['totalAmt'] = $bookingDetails->row()->totalAmt;
				$this->data['serviceFee'] = $bookingDetails->row()->serviceFee;
				$this->data['refundAmount'] = number_format($bookingDetails->row()->totalAmt-$bookingDetails->row()->serviceFee,2);
			}
		}
	}
}
/*End of file bookings.php */
/* Location: ./application/controllers/site/bookings.php */