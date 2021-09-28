<?php if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );

/**
 *
 * User related functions
 * 
 * @author Teamtweaks
 *        
 */
class Instant extends MY_Controller {
	function __construct() {
		// echo "<pre>";print_r($_REQUEST);echo "</pre>";// die;
		parent::__construct ();
		$this->load->helper ( array (
				'cookie',
				'date',
				'form',
				'email',
				'url' 
		) );
		$this->load->library ( array (
				'encrypt',
				'form_validation',
				'linkedin',
				'session',
				'email'
		) );
		$this->load->model ( array (
				'user_model',
				'product_model',
				'contact_model',
				'checkout_model',
				'order_model'				
		) );
		}
		
		
	
public function booking_confirm_instant(){

		

		$bookingDetails = $this->user_model->get_all_details(RENTALENQUIRY,array('Bookingno'=>$this->input->post('Bookingno')));
		$message = $this->input->post('message');
		$dataArr = array('productId' => $bookingDetails->row()->prd_id, 'bookingNo' => $bookingDetails->row()->Bookingno, 'senderId' => $bookingDetails->row()->user_id, 'receiverId' => $bookingDetails->row()->renter_id, 'subject' => 'Booking Request : '.$bookingDetails->row()->Bookingno, 'message' => $message, 'currencycode' => $bookingDetails->row()->currencycode);
		
		$this->user_model->simple_insert(MED_MESSAGE, $dataArr);
		
		$this->user_model->update_details( RENTALENQUIRY, array ('booking_status' => 'Pending', 'caltophone' =>$this->input->post('phone_no')), array ('user_id' => $this->checkLogin ( 'U' ),'id' => $this->session->userdata ( 'EnquiryId' ) ) );

		/* Mail function start */

		$id = $this->session->userdata ( 'EnquiryId' );
		$user_id = $this->checkLogin ( 'U' );

        $this->data['bookingmail'] = $this->user_model->getbookeduser_detail($id);
        
		//$price = $this->data['bookingmail']->row()->price * $this->data['bookingmail']->row()->noofdates;
		$price = $this->data['bookingmail']->row()->totalAmt;
		$hostprice = $this->data['bookingmail']->row()->totalAmt - $this->data['bookingmail']->row()->serviceFee;
		$currencycd = $bookingDetails->row()->currencycode;
        $user_currencycode = $bookingDetails->row()->user_currencycode;
		$unitprice = $bookingDetails->row()->unitPerCurrencyUser;
		
		$this->data['hostdetail'] = $this->user_model->get_all_details(USERS,array('id'=>$this->data['bookingmail']->row()->renter_id));

		$hostemail = $this->data['hostdetail']->row()->email;
		$hostname = $this->data['hostdetail']->row()->user_name;
		
		$checkindate = date('d-M-Y',strtotime($this->data['bookingmail']->row()->checkin));
		$checkoutdate = date('d-M-Y',strtotime($this->data['bookingmail']->row()->checkout));

		$newsid = '16';

		$template_values = $this->user_model->get_newsletter_template_details ( $newsid );
			
		
		if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
			$sender_email = $this->config->item ( 'site_contact_mail' );
			$sender_name = $this->config->item ( 'email_title' );
		} else {
			$sender_name = $template_values ['sender_name'];
			$sender_email = $template_values ['sender_email'];
		}
		
		

		$currency_details = $this->db->select('*')->from('fc_currency')->where('currency_type = ',$currencycd)->get();
	
		
			if($currencycd != $this->session->userdata('currency_type')){

					if($user_currencycode==$this->session->userdata('currency_type')){ 
							if(!empty($unitprice))
									 $per_price = customised_currency_conversion($unitprice,$this->data['bookingmail']->row()->price); 

									$total_amount = customised_currency_conversion($unitprice,$price);
							}else{
									$per_price = convertCurrency($currencycd,$this->session->userdata('currency_type'),$this->data['bookingmail']->row()->price);

										$total_amount = convertCurrency($currencycd,$this->session->userdata('currency_type'),$price);
										 }

						       }else{
						           $per_price = $this->data['bookingmail']->row()->price;
						            $total_amount = $price;
						            }

		    // $Booking_info = array('travellername' => $this->data['bookingmail']->row()->name, 'checkindate'=>$checkindate, 'checkoutdate' => $checkoutdate, 'price' => $this->data['bookingmail']->row()->price, 'totalprice' => $price, 'email_title' => $sender_name ,'currencySymbol' =>$this->session->userdata('currency_s'));

			$Host_Booking_info = array('travellername' => $this->data['bookingmail']->row()->name, 'checkindate'=>$checkindate, 'checkoutdate' => $checkoutdate, 'price' => $this->data['bookingmail']->row()->price, 'totalprice' => $hostprice, 'email_title' => $sender_name ,'currencySymbol' =>$currency_details->row()->currency_symbols);			            
           
            $message = $this->load->view('newsletter/BookInfo'.$newsid.'.php',$Host_Booking_info,TRUE);

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
			//echo $message; exit;
            try{
            $this->email->send();
           
            }catch(Exception $e)
            {
            echo $e->getMessage();
            }                   

		/* Mail function end */

		/* Traveller Mail Function Start */
		$id = $this->session->userdata ( 'EnquiryId' );
        $this->data['bookingmail'] = $this->user_model->getbookeduser_detail($id);
		$price = $this->data['bookingmail']->row()->price * $this->data['bookingmail']->row()->noofdates;

		$checkindate =date('d-M-Y',strtotime($this->data['bookingmail']->row()->checkin));
		$checkoutdate =date('d-M-Y',strtotime($this->data['bookingmail']->row()->checkout));
		
		$this->data['hostdetail'] = $this->user_model->get_all_details(USERS,array('id'=>$this->data['bookingmail']->row()->renter_id));
		$hostname = $this->data['hostdetail']->row->email;
		$hostemail = $this->data['hostdetail']->row->user_name;			
		$to  = $this->data['bookingmail']->row()->email; 
		$price = $this->data['bookingmail']->row()->price * $this->data['bookingmail']->row()->noofdates;
		$prd_id =$this->data['bookingmail']->row()->prd_id;
			
		$this->data['productimage'] = $this->user_model->getproductimage($prd_id);
		
		$newsid = '20';

		$template_values = $this->user_model->get_newsletter_template_details ($newsid);
				
		if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
			$sender_email = $this->config->item ( 'site_contact_mail' );
			$sender_name = $this->config->item ( 'email_title' );
		} else {
			$sender_name = $template_values ['sender_name'];
			$sender_email = $template_values ['sender_email'];
		}
		
		
		 //$traveller_info = array('prd_id' => $this->data['bookingmail']->row()->prd_id, 'travellername' => $this->data['bookingmail']->row()->name, 'productname' => $this->data['bookingmail']->row()->productname, 'prd_image'=>$this->data['productimage']->row()->product_image, 'checkindate'=>$checkindate, 'checkoutdate' => $checkoutdate, 'price' => $this->data['bookingmail']->row()->price, 'totalprice' => $price, 'email_title' => $sender_name, 'currencySymbol' =>$this->session->userdata('currency_s'));

		   $traveller_info = array('prd_id' => $this->data['bookingmail']->row()->prd_id, 'travellername' => $this->data['bookingmail']->row()->name, 'productname' => $this->data['bookingmail']->row()->productname, 'prd_image'=>$this->data['productimage']->row()->product_image, 'checkindate'=>$checkindate, 'checkoutdate' => $checkoutdate, 'price' => $per_price, 'totalprice' => $total_amount, 'email_title' => $sender_name, 'currencySymbol' =>$this->session->userdata('currency_s'));
           
            $message = $this->load->view('newsletter/TravellerInfo'.$newsid.'.php',$traveller_info,TRUE);

            $email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $this->data['bookingmail']->row()->email,
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
           
            }catch(Exception $e)
            {
            echo $e->getMessage();
            }                   

		/* Traveller Mail Function End */

		//$this->emailhostreservationreq($this->session->userdata ( 'EnquiryId' ));
		//$this->traveller_reservation($this->session->userdata ( 'EnquiryId' ));
		
		$dataArr = array(
			'productId' => $bookingDetails->row()->prd_id ,
			'senderId' => $bookingDetails->row()->renter_id ,
			'receiverId' => $bookingDetails->row()->user_id ,
			'bookingNo' => $bookingDetails->row()->Bookingno ,
			'subject' => 'Booking Request : '.$bookingDetails->row()->Bookingno ,
			'message' => 'Accepted',
			'point' => '1',
			'status' => 'Accept'
		);
		
		$this->db->insert(MED_MESSAGE, $dataArr);
		$this->db->where('bookingNo', $bookingDetails->row()->Bookingno);
		$this->db->update(MED_MESSAGE, array('status' => 'Accept'));
		$newdata = array('approval' => 'Accept');
		$condition = array('Bookingno' => $bookingDetails->row()->Bookingno);
		$this->user_model->update_details(RENTALENQUIRY,$newdata,$condition);
		$bookingDetails = $this->user_model->get_all_details(RENTALENQUIRY, $condition);
		$enqId = $bookingDetails->row()->id;
		redirect("site/user/confirmbooking/".$enqId);
	}
		
		
		
	


/**
 * ************************************************
 */
}