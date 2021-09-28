<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to user management 
 * @author Teamtweaks
 *
 */

class Experience_Commission extends MY_Controller {


	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('experience_commission_model');
		if ($this->checkPrivileges('Commission',$this->privStatus) == FALSE){
			redirect('admin');
		}
		
		
    }

    /**
     * 
     * This function loads the commisions list page
     */
   	public function index(){

	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/experience_commission/display_commission_tracking_lists');
		}
	}


	public function display_commission_tracking_lists(){
		

		if ($this->checkLogin('A') == ''){

			redirect('admin');

		}else {

			$this->data['heading'] = 'Experience Commission Tracking Lists';

			$sellerDetails = $this->experience_commission_model->get_all_details(USERS,array('is_experienced'=>'1','status'=>'Active'));
			
//echo $this->db->last_query();

		//echo "<pre>";	print_r($sellerDetails->result()); die; $this->data['trackingDetails']
			//print_r($sellerDetails);
			foreach($sellerDetails->result() as $seller)

			{

				$sellerEmail = $seller->email;

				/* paypal email */

				$this->data['paypalData'][$sellerEmail] = $seller->paypal_email;
				//echo "<pre>";
				//print_r($this->data['paypalData']);

				$rental_booking_details[$sellerEmail] = $this->experience_commission_model->get_all_commission_tracking($sellerEmail);
				//echo $this->db->last_query();
				
				//print_r($rental_booking_details[$sellerEmail]);

				$this->data['trackingDetails'][$sellerEmail]['rowsCount'] = 0;

				$this->data['trackingDetails'][$sellerEmail]['guest_fee'] = 0;

				$this->data['trackingDetails'][$sellerEmail]['total_amount'] = 0;

				$this->data['trackingDetails'][$sellerEmail]['host_fee'] = 0;

				$this->data['trackingDetails'][$sellerEmail]['payable_amount'] = 0;

				$this->data['trackingDetails'][$sellerEmail]['booking_walletUse'] = 0; // malar - 

				//$this->data['trackingDetails'][$sellerEmail]['listing_walletUse'] = 0;
				//echo $this->data['trackingDetails'][$sellerEmail]['payable_amount'];

				if(count($rental_booking_details[$sellerEmail]) != 0){ 

				foreach($rental_booking_details[$sellerEmail] as $rentals)

				{
					$totlessDays = $this->config->item ('cancel_hide_days_experience');
					$minus_checkin =  strtotime("-".$totlessDays."days",strtotime($rentals['checkin']));
							$checkinBeforeDay = date('Y-m-d',$minus_checkin);
							$current_date = date('Y-m-d');

				  if($checkinBeforeDay <= $current_date){	
				  
				  
	

				  	$this->data['trackingDetails'][$sellerEmail]['rowsCount'] = $this->data['trackingDetails'][$sellerEmail]['rowsCount'] + 1;
					
					$this->data['trackingDetails'][$sellerEmail]['checkin'] .= $rentals['checkin'].",";
					$this->data['trackingDetails'][$sellerEmail]['bookinNo_pay'] .= $rentals['booking_no'].",";
					
					
					

					$this->data['trackingDetails'][$sellerEmail]['id'] = $rentals['id'];
				//echo	$rentals['id'];
					//print_r($rentals['currencycode']);exit;
					$this->data['trackingDetails'][$sellerEmail]['renter_id'] = $rentals['renter_id'];
					
				
					
					if($rentals['currencycode'] != $this->data['admin_currency_code'])
                    {
                      /*

                     	$rentals['total_amount']= convertCurrency($rentals['currencycode'] ,$this->data['admin_currency_code'],$rentals['total_amount']);

                     //	$rentals['booking_walletUse'] = convertCurrency($rentals['currencycode'],$this->data['admin_currency_code'],$rentals['booking_walletUse']);

                     	$rentals['guest_fee']= convertCurrency($rentals['currencycode'] ,$this->data['admin_currency_code'],$rentals['guest_fee']);

                     	$rentals['host_fee']= convertCurrency($rentals['currencycode'] ,$this->data['admin_currency_code'],$rentals['host_fee']);

                     	$rentals['payable_amount']= convertCurrency($rentals['currencycode'],$this->data['admin_currency_code'],$rentals['payable_amount']);
                     	
                     	*/
						$currencyPerUnitSeller=$rentals['currencyPerUnitSeller'];
                     	$rentals['total_amount']=customised_currency_conversion($currencyPerUnitSeller,$rentals['total_amount']);
						//if($sellerEmail=='sephost@testmail.com')
						//echo "|".$rentals['total_amount']."|";
						$rentals['booking_walletUse'] =customised_currency_conversion($currencyPerUnitSeller,$rentals['booking_walletUse']);
						$rentals['guest_fee']=customised_currency_conversion($currencyPerUnitSeller,$rentals['guest_fee']);
						$rentals['host_fee']=customised_currency_conversion($currencyPerUnitSeller,$rentals['host_fee']);
						$rentals['payable_amount']=customised_currency_conversion($currencyPerUnitSeller,$rentals['payable_amount']); 

                  
                     }else{
						 /*
                     	 $rentals['total_amount'] = $rentals['total_amount'];

                     	 $rentals['guest_fee'] =  $rentals['guest_fee'];
                     	 $rentals['host_fee'] =  $rentals['host_fee'];
                     	 $rentals['payable_amount'] =  $rentals['payable_amount'];
                     	// $rentals['booking_walletUse'] =  $rentals['booking_walletUse'];
						*/
						$rentals['total_amount'] = $rentals['total_amount'];
                     	$rentals['guest_fee'] =  $rentals['guest_fee'];
                     	$rentals['host_fee'] =  $rentals['host_fee'];
                     	$rentals['payable_amount'] =  $rentals['payable_amount'];
						
						
                     	$rentals['booking_walletUse'] =  $rentals['booking_walletUse'];

                     }
					 
					 
					 //echo "perce" .  $rentals['exp_cancel_percentage'];

					$this->data['trackingDetails'][$sellerEmail]['total_amount'] = $this->data['trackingDetails'][$sellerEmail]['total_amount'] + $rentals['total_amount'];
					//echo $rentals['total_amount'];
					//echo $this->data['trackingDetails'][$sellerEmail]['total_amount'];
					
					$this->data['trackingDetails'][$sellerEmail]['guest_fee'] = $this->data['trackingDetails'][$sellerEmail]['guest_fee'] + $rentals['guest_fee'];

					

					$this->data['trackingDetails'][$sellerEmail]['host_fee'] = $this->data['trackingDetails'][$sellerEmail]['host_fee'] + $rentals['host_fee'];

					$cancel_amountBf = $rentals['subtotal']/100 * $rentals['exp_cancel_percentage'];
					
					if($rentals['currencycode'] != $this->data['admin_currency_code']){	
							$cancel_amount=customised_currency_conversion($currencyPerUnitSeller,$cancel_amountBf); 
					}else{
							$cancel_amount=$cancel_amountBf;
					}
					
					
					/**to show AmountTohost if the experience is cancelled**/
					
					if($rentals['cancelled'] =='Yes'){
						$this->data['trackingDetails'][$sellerEmail]['payable_amount'] = $this->data['trackingDetails'][$sellerEmail]['payable_amount'] + $rentals['payable_amount'] - $cancel_amount;
					}else{
						$this->data['trackingDetails'][$sellerEmail]['payable_amount'] = $this->data['trackingDetails'][$sellerEmail]['payable_amount'] + $rentals['payable_amount'];
					}
					
					
					/**to show cancelAmount if the experience is cancelled**/
					if($rentals['cancelled'] =='Yes'){
						$this->data['trackingDetails'][$sellerEmail]['exp_cancel_percentage'] += $cancel_amount;
					}else{
						$this->data['trackingDetails'][$sellerEmail]['exp_cancel_percentage'] += '0.00';
					}

					
					
					//echo $this->data['trackingDetails'][$sellerEmail]['payable_amount']; echo '</br>';
					//$this->data['trackingDetails'][$sellerEmail]['booking_walletUse'] = $this->data['trackingDetails'][$sellerEmail]['booking_walletUse'] + $rentals['booking_walletUse'];
				    }
					}


					

				}

			$this->data['trackingDetails'][$sellerEmail]['Bookingno'] = $rentals['Bookingno'];	
				
			$paidAmountQry = $this->experience_commission_model->get_paid_details($sellerEmail);
				//echo $this->db->last_query();
			$this->data['trackingDetails'][$sellerEmail]['paid'] = 0;

			if(count($paidAmountQry) != 0){ 
				foreach($paidAmountQry as $rental_paid){
				$cancel_amount = $rentals['subtotal']/100 * $rentals['exp_cancel_percentage'];
				//$this->data['trackingDetails'][$sellerEmail]['paid'] =  $rental_paid['payable_amount'] - $cancel_amount;	

					/**if the experience is cancelled only means minus the cancel amount**/
					if($rentals['cancelled'] =='Yes'){
						$paid =  $rental_paid['payable_amount'] - $cancel_amount;	
					}else{
						$paid =  $rental_paid['payable_amount'];	
					}
					

					if($rentals['currencycode'] != $this->data['admin_currency_code']){	
							$this->data['trackingDetails'][$sellerEmail]['paid']+=customised_currency_conversion($currencyPerUnitSeller,$paid); 
					}else{
							$this->data['trackingDetails'][$sellerEmail]['paid']+=$paid;
					}
					
				
				}

			}

			}//exit;
			//$this->data['trackingDetails'] = $this->experience_commission_model->get_all_commission_tracking($sellerEmail);
			$this->load->view('admin/experience_commission/display_tracking_lists',$this->data);

		}
	}


	public function add_pay_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add vendor payment';
			$sid = $this->uri->segment(4,0);
			$hostEmailQry = $this->experience_commission_model->get_commission_track_id($sid);
			$product_id = $hostEmailQry->row()->prd_id;
			$hostEmail = $hostEmailQry->row()->host_email;
			$this->data['hostEmail'] = $hostEmail;
			
			$rental_booking_details= $this->experience_commission_model->get_unpaid_commission_tracking($hostEmail);
			$payableAmount = 0;
			if(count($rental_booking_details) != 0){ 
				foreach($rental_booking_details as $rentals)
				{
					$totlessDays = $this->config->item ('cancel_hide_days_experience');
					$minus_checkin =  strtotime("-".$totlessDays."days",strtotime($rentals['checkin']));
							$checkinBeforeDay = date('Y-m-d',$minus_checkin);
							$current_date = date('Y-m-d');

				  if($checkinBeforeDay <= $current_date){	

					if($rentals['cancelled'] =='Yes'){
							$cancel_amount = $rentals['subtotal']/100 * $rentals['exp_cancel_percentage'];
					}
					else{
						$cancel_amount = 0;
					}
					
					
					$payableAmount = $payableAmount + $rentals['payable_amount'] - $cancel_amount;
					
					//print_r(AdminCurrencyValue);
					}
				  }
				}
				// echo $payableAmount;
			
			$paidAmountQry = $this->experience_commission_model->get_paid_details($hostEmail);
			$paidAmount = 0;
			if(count($paidAmountQry) != 0){ 
				foreach($paidAmountQry as $rental_paid)
				{
					
				$paidAmount =$paidAmount + $rental_paid['payable_amount'];	
				}
			}
			

			$this->data['hostEmail'] = $hostEmail;
			
			//$this->data['payableAmount'] = number_format($payableAmount-$paidAmount, 2, '.', '');

			$this->data['payableAmount'] = $this->uri->segment(5,0);


			$this->load->view('admin/experience_commission/add_vendor_payment',$this->data);
		}
	}
	public function display_product_list($email){
		
		
		
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Experience wise payment details';
			$detail_get = $this->experience_commission_model->get_rep_details_commison($email);
			//echo $this->db->last_query();
			
			$pro_detail = array();
			
			foreach($detail_get->result() as $details)
			{
				$condition = array('Bookingno' => $details->booking_no,'booking_status'=>'Booked');
				$details=$this->experience_commission_model->get_all_product_details($condition);
				
				$pro_detail[] = $details->result();
				
			}
			
				$this->data['product'] = $pro_detail;
				
			$this->load->view('admin/experience_commission/display_experience_list',$this->data);
		}
	} 

	
	public function paypal_payment()

	{

		 /*Paypal integration start */

			$this->load->library('paypal_class');


			$return_url = base_url().'admin/experience_commission/paypal_commission_success';

			$cancel_url = base_url().'admin/experience_commission/paypal_commission_cancel';

			$notify_url = base_url().'admin/experience_commission/paypal_commission_ipn';

			$item_name = $this->config->item('email_title').' Commission Payment';

			$totalAmount = $this->input->post('amount_to_pay');
			//print_r($totalAmount);

			$amount_from_db = $this->input->post('amount_from_db');
			
			$checkInDate = $this->input->post('checkinDate');
			$bookingNo = $this->input->post('bookingNo');
			
			
			
			$booking_no = $this->input->post('booking_no');

			$hostEmail = $this->input->post('hostEmail');

			$hostPayPalEmail = $this->input->post('hostPayPalEmail');

            $loginUserId = $this->checkLogin('A');

			$quantity = 1;

			$paypal_settings=unserialize($this->config->item('payment_0'));

			$paypal_settings=unserialize($paypal_settings['settings']);

			if($paypal_settings['mode'] == 'sandbox'){

				$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url

			}else{

				$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url

			}

			$ctype = ($paypal_settings['mode'] == 'sandbox')?"USD":"USD";


			$logo = base_url().'images/logo/'.$this->data['logo_img'];

			//echo "<img src='$logo'>";

			//echo $logo; exit;

			//$logo_url = "<img src='$logo'>";

			// To change the currency type for below line >> Sandbox: USD, Live: MYR

			

			$this->paypal_class->add_field('currency_code', 'USD'); 

			$this->paypal_class->add_field('image_url',$logo);

			//$this->paypal_class->add_field('business',trim($paypal_settings['merchant_email'])); // Business Email - for pay to admin



			$this->paypal_class->add_field('business',trim($hostPayPalEmail)); // Business Email -for pay to host

			

			$this->paypal_class->add_field('return',$return_url); // Return URL

			

			$this->paypal_class->add_field('cancel_return', $cancel_url); // Cancel URL

			

			$this->paypal_class->add_field('notify_url', $notify_url); // Notify url

			

			$this->paypal_class->add_field('custom', $hostEmail.'|'.$amount_from_db.'|'.$checkInDate.'|'.$bookingNo); // Custom Values

			$this->paypal_class->add_field('item_name', $item_name); // Product Name

			$this->paypal_class->add_field('user_id', $loginUserId);

			$this->paypal_class->add_field('quantity', $quantity); // Quantity


			$this->paypal_class->add_field('amount', $totalAmount); // Price

			

			

			//echo base_url().'order/success/'.$loginUserId.'/'.$lastFeatureInsertId; die;

			$this->paypal_class->submit_paypal_post(); 



	}



	 /* paypal commission payment starts */ 

	function paypal_commission_success(){

        //get the transaction data

        /*$paypalInfo = $this->input->post();

          

        $data['item_number'] = $paypalInfo['item_name']; 

        $data['payment_amt'] = $paypalInfo["amount"];

        $data['currency_code'] = $paypalInfo['currency_code'];

        */

        

        $this->data['receiver_email'] = $_REQUEST['receiver_email'];

        $this->data['txn_id'] = $_REQUEST['txn_id'];

        $this->data['payer_email'] = $_REQUEST['payer_email'];

       // $this->data['hostEmail'] = $_REQUEST['custom'];

        $custom_values = explode('|',$_REQUEST['custom']);

        $this->data['hostEmail'] = $custom_values[0];

        $paypal_amount = $custom_values[1];
		
		
		$checkin = $custom_values[2];
		$bookingno = $custom_values[3];
		
		$theCheckIn=explode(",",$checkin);
		$thebookingNo=explode(",",$bookingno);
	
		
      
        //print_r($this->data['txn_id']);
       /*

        $this->data['receiver_email'] = 'kailashkumar075@gmail.com';

        $this->data['txn_id '] = '3434ggfdhg5';

        $this->data['payer_email'] = 'admin@gmail.com';

        $this->data['hostEmail'] = 'vinodbabu@pofitec.com';

        */ 

        

       $this->data['mc_gross'] = $_REQUEST['mc_gross']; 

       $this->data['currency_code'] = $_REQUEST['mc_currency'];

       /*

        $paypal_amount = $this->data['mc_gross'];

        

      	if($this->data['currency_code']!=$this->data['admin_currency_code'])

       		$paypal_amount = convertCurrency($this->data['currency_code'],$this->data['admin_currency_code'],$this->data['mc_gross']);



        //$paypal_amount;exit;

		*/

        $dataArr = array(

						'host_email'	=>	$this->data['hostEmail'] ,

						'transaction_id' => $this->data['txn_id'],

						'amount'		=>  $paypal_amount,

						'payment_type'	=> 'ON',

						'status' => 'Paid'	

					);

        //Commission update

        $this->experience_commission_model->simple_insert(EXP_COMMISSION_PAID,$dataArr);
		
		/** Start - Update payment details if the dates reached and certain booking no **/
			$totlessDays = $this->config->item ('cancel_hide_days_experience');
			$minus_checkin =  strtotime("-".$totlessDays."days",strtotime($date));
			$checkinBeforeDay = date('Y-m-d',$minus_checkin);
			$current_date = date('Y-m-d');
			
			foreach($theCheckIn as $date){
					$totlessDays = $this->config->item ('cancel_hide_days_experience');
					$minus_checkin =  strtotime("-".$totlessDays."days",strtotime($date));
					$checkinBeforeDay = date('Y-m-d',$minus_checkin);
					$current_date = date('Y-m-d');
			 if($checkinBeforeDay <= $current_date){
				 foreach($thebookingNo as $b_no){
					$this->experience_commission_model->update_details(EXP_COMMISSION_TRACKING, array('paid_status'=>'yes'), array('booking_no'=>$b_no));
				 }	 
			}
	
		}
		/** End - Update payment details if the dates reached and certain booking no **/
		
		
		
		

		/* $this->experience_commission_model->update_details(EXP_COMMISSION_TRACKING, array('paid_status'=>'yes'), array('host_email'=>$this->data['hostEmail'])); */
		
		
		
		
		
		
		/*  Mail notification to host starts */


		//$host_details = $this->commission_model->ExecuteQuery('select user_name from '.USERS." where email='".$this->data['hostEmail'] ."' and account_type='1'");

		//$host_detail = $host_details->get();

		$adminnewstemplateArr=array(

				'news_subject'=> 'HomeStay DNN - Commission Payment',

				'logo_image'=>$this->config->item('logo_image'),

				'logo'=>$this->config->item('logo_image'),

				'news_descrip'=>$description,

				'email'=>$this->config->item('email'),

				'title'=>'Commission Payment',

				'hostname' =>  'Host'

		);


		extract($adminnewstemplateArr);

		$description = '<table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#4f595b">

				<tbody>

				<tr>

				<td>

				<table class="devicewidth" style="background-color: #f8f8f8;" border="0" cellspacing="0" cellpadding="0" width="600" align="center">

				<tbody>

				<tr>

				<td height="30" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td align="left" bgcolor="#4f595b"><img src="'.base_url().'images/logo/'.$logo.'" alt="logo" /></td>

				</tr>

				<tr>

				<td height="30" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td class="editable" style="color: #ffffff; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 18px; font-weight: bold; text-transform: uppercase; padding: 8px 20px; background-color: #752b7e;" align="center" valign="middle">Hi '.$hostname.',</td>

				</tr>

				<tr>

				<td height="30">&nbsp;</td>

				</tr>

				<tr>

				<td>&nbsp;</td>

				</tr>

				<tr>

				<th style="color: #000; padding: 0px 20px; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="center"> Your commission amount('.$paypal_amount.' '.$this->data['currency_code'].') is paid by  admin on '.date('d/m/Y').'.  </th>

				</tr>

				<tr>

				<td>&nbsp;</td>

				</tr>

				<tr>

				<td height="30">&nbsp;</td>

				</tr>

				<tr>

				<td style="padding: 0px 20px; color: #444444; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="left" valign="middle">

				<p>Thanks!</p>

				<p>The Home<span>StayDnn</span> Team</p>

				</td>

				</tr>

				<tr>

				<td height="30">&nbsp;</td>

				</tr>

				<tr>

				<td height="30" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td align="center" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td height="50" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				</tbody>

				</table>

				</td>

				</tr>

				</tbody>

				</table>';



		$subject = 'From: '.$this->config->item('email_title').' - ';

  		$message .= '<!DOCTYPE HTML>

			<html>

			<head>

			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

			<meta name="viewport" content="width=device-width"/>

			<title>'.$news_subject.'</title><body>';

		$message .=  $description;		

		

		$message .= '</body>

			</html>';



				

		$email_values = array('mail_type'=>'html',

							'from_mail_id'=>'sales@laravelecommerce.com',

							'mail_name'=>'HomeStay DNN',

							'to_mail_id'=> $this->data['hostEmail'],

							'subject_message'=> 'HomeStay DNN - Commission Payment',

							'body_messages'=>$message

							);

						

		$email_send_to_common = $this->experience_commission_model->common_email_send($email_values);

		//print_r($email_send_to_common);die;

		

		/*  Mail notification to host ends */



		$this->setErrorMessage('success','Experience Commission Payment is competed');

		redirect('admin/experience_commission/display_commission_tracking_lists');

        //pass the transaction data to view

        //$this->data['heading'] = "Payment Cancelled";

        //$this->load->view('admin/commission/paypal_success', $this->data);

     }

     

     function paypal_commission_cancel(){

     	$this->data['heading'] = "Payment Cancelled";

        $this->load->view('admin/experience_commission/paypal_cancel',$this->data);

     }

     

     function paypal_commission_ipn(){

     	/*

        $paypalInfo = $this->input->post();

          

        

        	$dataArr = array(

				'host_email'	=>	'vinodbabu@pofitec.com',

				'amount'		=>'210.28'

			);

		//	print_r($dataArr); die;

			$this->commission_model->simple_insert(COMMISSION_PAID,$dataArr);

			$this->commission_model->update_details(COMMISSION_TRACKING, array('paid_status'=>'yes'), array('host_email'=>$paypalInfo['hostEmail']));

			redirect('admin/commission/display_commission_tracking_lists');

		*/

       

    }



    /* paypal commission payment ends */ 

    /* offline payment starts */


	public function add_vendor_payment_manual(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
		//echo "<pre>";	print_r($this->input->post());
		$rental_booking_details= $this->experience_commission_model->get_unpaid_commission_tracking($this->input->post('hostEmail'));
			$payableAmount = 0;
			if(count($rental_booking_details) != 0){ 
				foreach($rental_booking_details as $rentals)
				{
					
						
					/** Start - Update payment details if the dates reached **/
					$totlessDays = $this->config->item ('cancel_hide_days_experience');
					$minus_checkin =  strtotime("-".$totlessDays."days",strtotime($rentals['checkin']));
					$checkinBeforeDay = date('Y-m-d',$minus_checkin);
					$current_date = date('Y-m-d');

					if($checkinBeforeDay <= $current_date){	
				  

							//$payableAmount = $payableAmount + $rentals['payable_amount'];
							
							$payableAmount = $this->input->post('amount'); //post amount from commission

						$this->experience_commission_model->update_details(EXP_COMMISSION_TRACKING, array('paid_status'=>'yes'), array('booking_no'=>$rentals['booking_no']));	
							
	
					 }
					
				}
				}
				
		
			$dataArr = array(
				'host_email'	=>	$this->input->post('balance_due'),
				'transaction_id'		=>	$this->input->post('transaction_id'),
				'amount'		=>$payableAmount,
				'payment_type'	=> 'OFF',
				'status' => 'Paid'	


			);

			$this->experience_commission_model->simple_insert(EXP_COMMISSION_PAID,$dataArr);
			
			
			
			
			/* $this->experience_commission_model->update_details(EXP_COMMISSION_TRACKING, array('paid_status'=>'yes'), array('host_email'=>$this->input->post('hostEmail'))); */
			
			
			
			
			
			
			redirect('admin/experience_commission/display_commission_tracking_lists');
		}
	}

	 /* offline payment ends */


}