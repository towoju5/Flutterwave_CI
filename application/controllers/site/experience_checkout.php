<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**

 * 

 * User related functions

 * @author Teamtweaks

 *

 */



class Experience_Checkout extends MY_Controller { 

	function __construct(){

        parent::__construct();

		$this->load->helper(array('cookie','date','form','email'));

		$this->load->library(array('encrypt','form_validation'));		

		$this->load->model('experience_checkout_model');

		/*

		if($_SESSION['sMainCategories'] == ''){

			$sortArr1 = array('field'=>'cat_position','type'=>'asc');

			$sortArr = array($sortArr1);

			$_SESSION['sMainCategories'] = $this->experience_checkout_model->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);

		}

		$this->data['mainCategories'] = $_SESSION['sMainCategories'];

		if($_SESSION['sColorLists'] == ''){

			//$_SESSION['sColorLists'] = $this->experience_checkout_model->get_all_details(LIST_VALUES,array('list_id'=>'1'));

		}

		$this->data['mainColorLists'] = $_SESSION['sColorLists'];

			*/

		$this->data['loginCheck'] = $this->checkLogin('U');

		$this->data['countryList'] = $this->experience_checkout_model->get_all_details(COUNTRY_LIST,array());

		define("API_LOGINID",$this->config->item('payment_2'));

		define("StripeDetails",$this->config->item('payment_1'));

    }



	/**

	 * 

	 * Loading Cart Page

	 */



	public function index(){

		if ($this->data['loginCheck'] != ''){

			/* 

			$this->data['heading'] = 'Checkout'; 

			$this->data['checkoutViewResults'] = $this->experience_checkout_model->mani_checkout_total($this->data['common_user_id']);	

			$this->data['GiftViewTotal'] = $this->experience_checkout_model->mani_gift_total($this->data['common_user_id']);				

			$this->data['SubCribViewTotal'] = $this->experience_checkout_model->mani_subcribe_total($this->data['common_user_id']);							

			$this->data['countryList'] = $this->experience_checkout_model->get_all_details(COUNTRY_LIST,array());	

		 	$this->load->view('site/checkout/checkout.php',$this->data);

		 	*/

		}else{

			redirect('login');

		}	

	}



	/****************** Insert the checkout to user********************/

	public function PaymentProcess(){

		//echo $this->uri->segment(4); die;

		///print_r($this->checkLogin('U'));die;

		$product_id = $this->input->post('product_id');

		$tax = $this->input->post('tax');

		$enquiryid = $this->input->post('enquiryid'); 

		$product = $this->experience_checkout_model->get_all_details(EXPERIENCE,array('experience_id' => $product_id));

		

		$seller = $this->experience_checkout_model->get_all_details(USERS,array('id' => $product->row()->user_id));

		$dealcode =$this->db->insert_id();

        /*Paypal integration start */

		$this->load->library('paypal_class');

		$item_name = $this->input->post('product_name');

		//echo $item_name; exit;

		$totalAmount = $this->input->post('price'); //price from rentalEnq totalAmt nzd

		$indtotal = $this->input->post('indtotal'); //price from expe_dates



		$currencyCode = $this->input->post('currencycode');// Get currency code from Rental Enquiry Table

		



		

		

		//User ID

		$loginUserId = $this->checkLogin('U');

		//DealCodeNumber

		$lastFeatureInsertId = $this->session->userdata('randomNo');

		//echo $lastFeatureInsertId;die;

		$quantity = 1;

		//$BookingproductList = $this->product_model->view_product_details_booking(' where p.id="'.$product_id.'"  group by p.id order by p.created desc limit 0,1');

		//insert payment

		if($this->session->userdata('randomNo') != '') {

			$delete = 'delete from '.EXPERIENCE_BOOKING_PAYMENT.' where dealCodeNumber = "'.$this->session->userdata('randomNo').'" and user_id = "'.$loginUserId.'" and status != "Paid"  ';

			$this->experience_checkout_model->ExecuteQuery($delete, 'delete');

			$dealCodeNumber = $this->session->userdata('randomNo');

		} else {

			$dealCodeNumber = mt_rand();

		}



/*

'product_id'=>$product_id,

			//'price'=>$totalAmount,

			'price'=> convertCurrency($currencyCode,'USD',$totalAmount),

			'indtotal'=>$indtotal,

			//'indtotal'=> convertCurrency($currencyCode,'USD',$indtotal),

			'tax'=>$tax,

			//'sumtotal'=>$totalAmount,

			'sumtotal'=> convertCurrency($currencyCode,'USD',$totalAmount),

			'user_id'=>$loginUserId,

			'sell_id'=>$product->row()->user_id,

			'created' => $now,

			'dealCodeNumber' => $dealCodeNumber,

			'status' => 'Pending',

			'shipping_status' => 'Pending',

			'total'  => convertCurrency($currencyCode,'USD',$totalAmount),

			'EnquiryId'=>$enquiryid,

			'inserttime' => NOW(),

			'payment_type'=>'Paypal',

			'currency_code' => 'USD'





*/

		



		$insertIds = array();

		$now = date("Y-m-d H:i:s");

		$paymentArr=array(

			'product_id'=>$product_id,

			'price'=>$totalAmount,

			//'price'=> convertCurrency($currencyCode,'USD',$totalAmount),

			

			'indtotal'=>$indtotal,

			//'indtotal'=> convertCurrency($currencyCode,'USD',$indtotal),

			'tax'=>$tax,

			'sumtotal'=>$totalAmount,

			//'sumtotal'=> convertCurrency($currencyCode,'USD',$totalAmount),

			'user_id'=>$loginUserId,

			'sell_id'=>$product->row()->user_id,

			'created' => $now,

			'dealCodeNumber' => $dealCodeNumber,

			'status' => 'Pending',

			'shipping_status' => 'Pending',

			//'total'  => convertCurrency($currencyCode,'USD',$totalAmount),

			'total'  => $totalAmount,

			'EnquiryId'=>$enquiryid,

			'inserttime' => NOW(),

			'payment_type'=>'Paypal',

			'currency_code' => 'USD');

		$this->experience_checkout_model->simple_insert(EXPERIENCE_BOOKING_PAYMENT,$paymentArr);

		//echo $this->db->last_query();exit;

		$insertIds[]=$this->db->insert_id();

		$paymtdata = array(

			'randomNo'  => $dealCodeNumber,

			'randomIds' => $insertIds

		);

		$lastFeatureInsertId = $dealCodeNumber;		

		//echo '<pre>'; print_r($paymentArr); die;

		$this->session->set_userdata($paymtdata);

		$paypal_settings=unserialize($this->config->item('payment_0'));

		$paypal_settings=unserialize($paypal_settings['settings']);

		//sandbox

		if($paypal_settings['mode'] == 'sandbox'){

			$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

		}else{

			$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url

		}



		if($paypal_settings['mode'] == 'sandbox') {

			$ctype ='USD';

		}

		else {

			$ctype='USD';

		}

		$logo = base_url().'images/logo/'.$this->data['logo_img'];

		//echo "<img src='$logo'>";

		//echo $logo; exit;

		//$logo_url = "<img src='$logo'>";

		// To change the currency type for below line >> Sandbox: USD, Live: MYR

		$CurrencyType = $this->experience_checkout_model->get_all_details(CURRENCY,array('currency_type' => $ctype)); 

		$this->paypal_class->add_field('currency_code', $CurrencyType->row()->currency_type); 

		$this->paypal_class->add_field('image_url',$logo);

		$this->paypal_class->add_field('business',$paypal_settings['merchant_email']); // Business Email

		$this->paypal_class->add_field('return',base_url().'experience_order/success/'.$loginUserId.'/'.$lastFeatureInsertId); // Return URL

		$this->paypal_class->add_field('cancel_return', base_url().'experience_order/failure'); // Cancel URL

		$this->paypal_class->add_field('notify_url', base_url().'experience_order/ipnpayment'); // Notify url

		$this->paypal_class->add_field('custom', 'Product|'.$loginUserId.'|'.$lastFeatureInsertId); // Custom Values

		$this->paypal_class->add_field('item_name', $item_name); // Product Name

		$this->paypal_class->add_field('user_id', $loginUserId);

		$this->paypal_class->add_field('quantity', $quantity); // Quantity



		

		//echo $this->session->userdata('currency_type');

		$currencyCode;

		if($currencyCode != 'USD')

			{



			 $totalAmount = convertCurrency($currencyCode,'USD',$totalAmount);



			}

											

		//exit();

	

		$this->paypal_class->add_field('amount', $totalAmount); // Price

		

		

		//echo base_url().'order/success/'.$loginUserId.'/'.$lastFeatureInsertId; die;

		$this->paypal_class->submit_paypal_post(); 

	}

	

	

	//PayUMoney/////////////

	

	public function PaymentProcess_PayUMoney()

	{

		$product_id = $this->input->post('product_id');

		$tax = $this->input->post('tax');

		$txnid = $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

		$Prod_info = 'xxxxxxxxxxxxxxxxxx';

		$firstname = $this->input->post('firstname');

		$email = $this->input->post('email');

		$phone = $this->input->post('phone');

		$surl = $this->input->post('surl');

		$furl = $this->input->post('furl');

		$enquiryid = $this->input->post('enquiryid'); 

		$product = $this->experience_checkout_model->get_all_details(EXPERIENCE,array('experience_id' => $product_id));

		$seller = $this->experience_checkout_model->get_all_details(USERS,array('id' => $product->row()->user_id));

		$dealcode =$this->db->insert_id();

     

		$item_name = $this->input->post('product_name');



		$totalAmount = $this->input->post('amount');

		//echo $totalAmount;

		

		$currencyCode = $this->input->post('currencycode');// Get currency code from Rental Enquiry Table





		$loginUserId = $this->checkLogin('U');

		

		$lastFeatureInsertId = $this->session->userdata('randomNo');

		

		$quantity = 1;

		

		//insert payment

		if($this->session->userdata('randomNo') != '') {

			$delete = 'delete from '.EXPERIENCE_BOOKING_PAYMENT.' where dealCodeNumber = "'.$this->session->userdata('randomNo').'" and user_id = "'.$loginUserId.'" and status != "Paid"  ';

			$this->experience_checkout_model->ExecuteQuery($delete, 'delete');

			$dealCodeNumber = $this->session->userdata('randomNo');

		}

		else 

		{

			$dealCodeNumber = mt_rand();

		}

		$insertIds = array();

		$now = date("Y-m-d H:i:s");

		$paymentArr=array(

			'product_id'=>$product_id,

			'price'=>$totalAmount,

			'indtotal'=>$product->row()->price,

			'tax'=>$tax,

			'sumtotal'=>$totalAmount,

			'user_id'=>$loginUserId,

			'sell_id'=>$product->row()->user_id,

			'payment_type'=>'PayUMoney',

			'created' => $now,

			'dealCodeNumber' => $dealCodeNumber,

			'status' => 'Paid',

			'shipping_status' => 'Pending',

			'total'  => $totalAmount,

			'EnquiryId'=>$enquiryid,

			'inserttime' => NOW());

			

		$this->experience_checkout_model->simple_insert(EXPERIENCE_BOOKING_PAYMENT,$paymentArr);

		$insertIds[]=$this->db->insert_id();

		$transaction_no = $this->db->insert_id();

		$paymtdata = array(

			'randomNo' => $dealCodeNumber,

			'randomIds' => $insertIds

		);

		

		

		//print_r($transaction_no);

		

		//die;

		//print_r($paymentArr);

		//die;

			//die;

		/* if($success)

		{

			$MERCHANT_KEY = "Y2tY24iJ";

		$SALT = "cFDB2gpIku";

		$PAYU_BASE_URL = "https://test.payu.in";

			redirect('order/success/'.$loginUserId.'/'.$lastFeatureInsertId.'/'.$token);

		}

		else

		{

			redirect('order/failure');

		} */

		

		//redirect('https://test.payu.in');

			

$MERCHANT_KEY = "gtKFFx";	

$SALT = "eCwWELxi";

$PAYU_BASE_URL = "https://test.payu.in";

//$PAYU_BASE_URL =base_url();

//echo $PAYU_BASE_URL;

//die;

$hash_string = '';

$hash_string = array(



	'key'=>$MERCHANT_KEY,

	'txnid'=>$txnid,

	'amount'=>$this->input->post('amount'),

	'productinfo'=>$Prod_info ,

	'firstname'=>$firstname,

	'email'=>$email,

	'phone'=>$phone,

	'surl'=>$surl,

	'furl'=>$furl



);

$hash_string = implode("|",$hash_string);

//print_r($hash_string);

/* foreach($hash_string as $r_pay)

{

	$key = $r_pay['key'];

	$txnid =  $r_pay['txnid'];

	$amount =  $r_pay['amount'];

	$productinfo =  $r_pay['productinfo'];

	$firstname =  $r_pay['firstname'];

	$email =  $r_pay['email'];

	$phone =  $r_pay['phone'];

	$surl =  $r_pay['surl'];

	$furl =  $r_pay['furl'];

	

    //$hash_string = $key|$txnid|$amount|$productinfo|$firstname|$email|$phone|$surl|$furl;

} */

//die;

$hash_string .= $SALT;

$hash = strtolower(hash('sha512', $hash_string));

//$hash = $this->input->post('hash');

//echo $hash; die;

//$action = $PAYU_BASE_URL . '/_payment';



	

redirect($PAYU_BASE_URL . '/_payment_options?mihpayid='.$hash.'');

$this->data['query'] = $this->experience_checkout_model->view_payment_payumoney($transaction_no);

		foreach($this->data['query'] as $p_row)

		{

			

			$payment_status = $p_row->status;

		}

		if($payment_status="Paid")

		{

			/* Mail function */ 



            $newsid='43';



			$template_values=$this->product_model->get_newsletter_template_details($newsid);

			if($template_values['sender_name']=='' && $template_values['sender_email']==''){

				$sender_email=$this->data['siteContactMail'];

				$sender_name=$this->data['siteTitle'];

			}else{

				$sender_name=$template_values['sender_name'];

				$sender_email=$template_values['sender_email'];

			} 

                          

                                      



		$cfmurl = "Payment paid successfully";

		$logo_mail = $this->data['logo'];

                                 

        $email_values = array(

					'from_mail_id'=>$sender_email,

					'to_mail_id'=> 'charlesvictor.j@pofitec.com',

					'subject_message'=>$template_values ['news_subject'],

					'body_messages'=>$message

			);  

			$reg= array('cfmurl'=>$cfmurl, 'email_title' => $sender_name,'logo'=>$logo_mail );

           

            $message = $this->load->view('newsletter/Payumoney'.$newsid.'.php',$reg,TRUE);



            

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

		}

		

		

	

	}

	

	

	//PayUMoney////////////



						



	public function UserPaymentCreditStripe(){
		//echo '<pre>'; print_r($_POST);die;
		$condition =array('id' => $this->checkLogin('U'));
		$userDetails = $this->experience_checkout_model->get_all_details(USERS,$condition);
		$loginUserId = $this->checkLogin('U');
		$product_id = $this->input->post('product_id');
		$tax = $this->input->post('tax');
		$currencyCode = $this->input->post('currencycode');
		$enquiryid = $this->input->post('enquiryid'); 
		$indtotal	= $this->input->post('indtotal');  // experience unit price
		$product = $this->experience_checkout_model->get_all_details(EXPERIENCE,array('experience_id' => $product_id));
		$seller = $this->experience_checkout_model->get_all_details(USERS,array('id' => $product->row()->user_id));
		$dealcode =$this->db->insert_id();
		$lastFeatureInsertId = $this->session->userdata('randomNo');
		$userDetails = $this->experience_checkout_model->get_all_details(USERS,$condition);
		$values = array('amount' =>  $this->input->post('total_price'), 

						'card_num' =>  $this->input->post('cardNumber'), 

						'exp_date' => $this->input->post('CCExpDay').'/'.$this->input->post('CCExpMnth'),

						'first_name' =>$userDetails->row()->firstname,

						'last_name' =>$userDetails->row()->lastname,

						'address' => $this->input->post('address'),

						'city' => $this->input->post('city'),

						'state' => $this->input->post('state'),

						'country' => $userDetails->row()->country,

						'phone' => $userDetails->row()->phone_no,

						'email' =>  $userDetails->row()->email,

						'card_code' => $this->input->post('creditCardIdentifier'));

		

		$excludeArr = array('authorize_mode','authorize_id','authorize_key','creditvalue','shipping_id','cardType','email','cardNumber','CCExpDay','CCExpMnth','creditCardIdentifier','total_price','CreditSubmit');
		$condition =array('id' => $loginUserId);
		$dataArr = array('user_id'=>$loginUserId,'full_name'=>$userDetails->row()->firstname.' '.$userDetails->row()->lastname,'address1'=>$this->input->post('address'),'address2'=>$this->input->post('address2'),'city'=>$this->input->post('city'),'state'=>$this->input->post('state'),'country'=>$this->input->post('country'),'postal_code'=>$this->input->post('postal_code'),'phone'=>$this->input->post('phone_no'));
		$StripDetVal=unserialize(StripeDetails); 			
		$StripeVals=unserialize($StripDetVal['settings']);	
		require_once('./stripe/lib/Stripe.php');
		$secret_key = $StripeVals['secret_key'];
		$publishable_key = $StripeVals['publishable_key'];
		$stripe = array(			
			"secret_key"      => $secret_key,			
			"publishable_key" => $publishable_key			
		);				
		Stripe::setApiKey($stripe['secret_key']);
		$token = $this->input->post('stripeToken');
		$amounts = currencyConvertToUSD($product_id,$values['amount'])*100;
		try {
			$customer = Stripe_Customer::create(array(
				"card" => $token,
				"description" => "Product Purhcase for ".$this->config->item('email_title'),
				"email" => $this->input->post('email'))
			);		

			Stripe_Charge::create(array(
					"amount" => $amounts, # amount in cents, again
					"currency" => $this->data['currencyType'],
					"customer" => $customer->id)
				);
			$product_id =$this->input->post('booking_rental_id');
			$product = $this->experience_checkout_model->get_all_details(EXPERIENCE,array('experience_id' => $product_id));
			$seller = $this->experience_checkout_model->get_all_details(USERS,array('id' => $product->row()->user_id));
			$totalAmount = $this->input->post('total_price');
			if($this->session->userdata('randomNo') != '') {
				$delete = 'delete from '.EXPERIENCE_BOOKING_PAYMENT.' where dealCodeNumber = "'.$this->session->userdata('randomNo').'" and user_id = "'.$loginUserId.'" ';
				$this->experience_checkout_model->ExecuteQuery($delete, 'delete');
				$dealCodeNumber = $this->session->userdata('randomNo');
				} else {
					$dealCodeNumber = mt_rand();
				}
				$insertIds = array();
				$now = date("Y-m-d H:i:s");
				$paymentArr=array(

						'product_id'		=> 	$product_id,

						'sell_id'			=> 	$product->row()->user_id,

						'price'				=>	$totalAmount,   //totAmt in rentalEnquiry

						'indtotal'			=>	$indtotal, 

						'sumtotal'			=>	$totalAmount,  //totAmt in rentalEnquiry

						'user_id'			=>	$loginUserId, //price in product Tbl

						'created' 			=> 	$now,

						'dealCodeNumber'	=> 	$dealCodeNumber,

						'status' 			=> 'Pending',

						'shipping_status'	=> 'Pending',

						'total'  			=> 	$totalAmount,  //totAmt in rentalEnquiry

						'EnquiryId'			=>	$enquiryid,

						'inserttime' 		=> 	NOW(),

						'currency_code' 	=> $currencyCode);



				$this->experience_checkout_model->simple_insert(EXPERIENCE_BOOKING_PAYMENT,$paymentArr);

				$insertIds[]=$this->db->insert_id();

				$paymtdata = array(

					'randomNo' 	=> 	$dealCodeNumber,

					'randomIds' => 	$insertIds,

					'EnquiryId'	=>	$enquiryid

				);

				$this->session->set_userdata($paymtdata);

				$this->experience_checkout_model->edit_rentalbooking(array('booking_status' => 'Booked'),array('id'=>$this->session->userdata('EnquiryId')));

				$lastFeatureInsertId = $this->session->userdata('randomNo');

				redirect('experience_order/success/'.$loginUserId.'/'.$lastFeatureInsertId.'/'.$token);

			} catch (Exception $e) {

				$error = $e->getMessage();

				$this->session->set_userdata('payment_error', $error);

				redirect('experience_order/failure'); 

			}	

	}


	public function PaymentCredit(){

		//echo '<pre>';print_r($_POST);die;

		$cvv = md5($this->input->post('creditCardIdentifier'));

		$dataArr = array('cvv' => $cvv);

		$condition =array('id' => $this->checkLogin('U'));

		$userDetails = $this->experience_checkout_model->get_all_details(USERS,$condition);

		$loginUserId = $this->checkLogin('U');

		$lastFeatureInsertId = $this->session->userdata('randomNo');

		$currency_code = $this->input->post('currencycode');

		if($this->input->post('creditvalue')=='authorize') 

		{	

		

			$Auth_Details=unserialize(API_LOGINID); 

			$Auth_Setting_Details=unserialize($Auth_Details['settings']);	

			///echo '<pre>';print_r($Auth_Setting_Details);die;

			error_reporting(-1);

			define("AUTHORIZENET_API_LOGIN_ID",$Auth_Setting_Details['merchantcode']);    // Add your API LOGIN ID

			define("AUTHORIZENET_TRANSACTION_KEY",$Auth_Setting_Details['merchantkey']); // Add your API transaction key

			define("API_MODE",$Auth_Setting_Details['mode']);

			if(API_MODE	=='sandbox')

			{ 

				define("AUTHORIZENET_SANDBOX",true);// Set to false to test against production

			}

			else

			{

				define("AUTHORIZENET_SANDBOX",false);

			} 



			

			define("TEST_REQUEST", "FALSE"); 

			require_once './authorize/autoload.php';

			$transaction = new AuthorizeNetAIM;

			$transaction->setSandbox(AUTHORIZENET_SANDBOX);

			$transaction->setFields(

			array(

				'amount' =>  $this->input->post('total_price'), 

				'card_num' =>  $this->input->post('cardNumber'), 

				'exp_date' => $this->input->post('CCExpDay').'/'.$this->input->post('CCExpMnth'),

				'first_name' =>$userDetails->row()->firstname,

				'last_name' =>$userDetails->row()->lastname,

				'address' => $this->input->post('address'),

				'city' => $this->input->post('city'),

				'state' => $this->input->post('state'),

				'country' => $userDetails->row()->country,

				'phone' => $userDetails->row()->phone_no,

				'email' =>  $userDetails->row()->email,

				'card_code' => $this->input->post('creditCardIdentifier'),

				));

				

			$response = $transaction->authorizeAndCapture();

			

			//echo '<pre>';print_r($response);die;

			

			if($response->approved != '')

			{

				$product_id =$this->input->post('booking_rental_id');

				$product = $this->experience_checkout_model->get_all_details(EXPERIENCE,array('experience_id' => $product_id));

				$seller = $this->experience_checkout_model->get_all_details(USERS,array('id' => $product->row()->user_id));

				$totalAmnt = $this->input->post('total_price');

				$enquiryid = $this->input->post('enquiryid');



				$indtotal	= $this->input->post('indtotal');  // experience unit price



				$loginUserId = $this->checkLogin('U');

				if($this->session->userdata('randomNo') != '') {

				$delete = 'delete from '.EXPERIENCE_BOOKING_PAYMENT.' where dealCodeNumber = "'.$this->session->userdata('randomNo').'" and user_id = "'.$loginUserId.'" ';

				$this->experience_checkout_model->ExecuteQuery($delete, 'delete');

				$dealCodeNumber = $this->session->userdata('randomNo');

				} else {

				$dealCodeNumber = mt_rand();

				}



				

				//echo $this->db->last_query();exit;





				$insertIds = array();

				$now = date("Y-m-d H:i:s");

				$paymentArr=array(

					'product_id'		=>	$product_id,

					'sell_id'			=>	$product->row()->user_id,

					'price'				=>	$totalAmnt,

					'indtotal'			=>	$indtotal,

					'sumtotal'			=>	$totalAmnt,

					'user_id'			=>	$loginUserId,

					'created' 			=> 	$now,

					'dealCodeNumber' 	=> 	$dealCodeNumber,

					'status' 			=> 	'Paid',

					'shipping_status' 	=> 	'Pending',

					'total'  			=> 	$totalAmnt,

					'EnquiryId'			=>	$enquiryid,

					'inserttime' 		=> 	NOW(),

					'currency_code' 	=> 	$currency_code 

					);

					

				$this->experience_checkout_model->simple_insert(EXPERIENCE_BOOKING_PAYMENT,$paymentArr);

				$insertIds[]=$this->db->insert_id();

				$paymtdata = array(

					'randomNo' => $dealCodeNumber,

					'randomIds' => $insertIds

					);

				$this->session->set_userdata($paymtdata, $currency_code);

				$this->experience_checkout_model->edit_rentalbooking(array('booking_status' => 'Booked'),array('id'=>$enquiryid));

				$lastFeatureInsertId = $this->session->userdata('randomNo');

				redirect('experience_order/success/'.$loginUserId.'/'.$lastFeatureInsertId.'/'.$response->transaction_id);

				

			}else{

				$this->session->set_userdata('payment_error', $response->response_reason_text);

				//redirect('experience_order/failure/'.$response->response_reason_text); 

				redirect('experience_order/failure/'); 

			}

		}

	}

	//10/1
	public function PaymentFlutterwave(){
		$email = $this ->input ->post('f_email');
		$amount = $this ->input ->post('f_amount');
		var_dump($email);
		var_dump($amount);
		exit;
	}


}







/* End of file experience_checkout.php */



/* Location: ./application/controllers/site/experience_checkout.php */