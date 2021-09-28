<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * User related functions
 * @author Pofitec
 *
 */

class Mobilecart extends MY_Controller { 
  public $mobdata = array();
  function __construct(){
        parent::__construct();
    $this->load->helper(array('cookie','date','form','email'));
    $this->load->library(array('encrypt','form_validation'));   
    $this->load->model('mobile_model');   
    $this->load->model('order_model');  
    $this->load->model('product_model');
    $this->load->model('contact_model');
    $this->load->model('checkout_model');   
    define("API_LOGINID",$this->config->item('payment_2'));
                define("StripeDetails",$this->config->item('payment_1'));
    
    }
  
  /** 
   * 
   * Loading index page
   */
  /*
  public function index(){
    $this->load->view('mobile/home.php',$this->mobdata);
  } 
  */
  
  public function index(){
    
    $this->data['heading'] = 'Order Confirmation'; 
    if($this->uri->segment(2) == 'success'){
      if($this->uri->segment(5)==''){
        $transId = $_REQUEST['txn_id'];
        $Pray_Email = $_REQUEST['payer_email'];
      }else{
        $transId = $this->uri->segment(5);
        $Pray_Email = '';
      }
      $UserNo = $this->uri->segment(3);
      $DealCodeNo = $this->uri->segment(4);
        
      $PaymentSuccessCheck = $this->order_model->get_all_details(PAYMENT,array('user_id' => $UserNo, 'dealCodeNumber' => $DealCodeNo,'status'=>'Paid'));
      $EnquiryUpdate = $this->order_model->get_all_details(PAYMENT,array('dealCodeNumber'=>$DealCodeNo));

      $eprd_id = $EnquiryUpdate->row()->product_id;
      $eInq_id = $EnquiryUpdate->row()->EnquiryId;
      
      /******** coupon   *********/
     
      $coupon = $this->session->userdata('coupon_strip');
      $coupon = explode('-', $coupon);
       
      if($coupon['0'] != ''){
      
        $data = array('is_coupon_used' => 'Yes',
                 'discount_type' => $coupon['4'],
                 'coupon_code' => $coupon['0'],
                 'discount' => $coupon['2'],
                 'dval' => $coupon['1'],
                 'total_amt' => $coupon['3']
                );
        $this->session->unset_userdata('coupon_strip');
       
        $this->order_model->update_details(PAYMENT,$data,array('dealCodeNumber'=>$DealCodeNo));
        $data = array('totalAmt' => $coupon['2']);
        $this->order_model->update_details(RENTALENQUIRY,$data,array('id'=>$eInq_id));
        $data = array('code' => trim($coupon['0']));
        $couponi = $this->order_model->get_all_details(COUPONCARDS,$data);
        $data = array('purchase_count' => $couponi->row()->purchase_count+1,
               'card_status' => 'redeemed');
        $this->order_model->update_details(COUPONCARDS,$data,array('id'=>$couponi->row()->id));
      }
      /******** coupon end  *************/
          
      $this->data['invoicedata'] = $this->order_model->get_all_details(RENTALENQUIRY,array('id'=>$eInq_id));    
      
      $condition1 = array('user_id'=>$UserNo,'prd_id'=>$eprd_id,'id'=>$eInq_id);
      $dataArr1 = array('booking_status'=>'Booked');
      
      $this->order_model->update_details(RENTALENQUIRY,$dataArr1,$condition1);
      
      $this->data['Confirmation'] = $this->order_model->PaymentSuccess($this->uri->segment(3),$this->uri->segment(4),$transId,$Pray_Email);
                    
      $SelBookingQty =$this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $eInq_id));
      
      //booking update
      $productId = $SelBookingQty->row()->prd_id;
      $arrival = $SelBookingQty->row()->checkin;
      $depature = $SelBookingQty->row()->checkout;
      $dates = $this->getDatesFromRange($arrival, $depature);
      $i=1;
      $dateMinus1= count($dates)-1;
      foreach($dates as $date){
        if($i <= $dateMinus1){
          $BookingArr=$this->contact_model->get_all_details(CALENDARBOOKING,array('PropId' => $productId,'id_state' => 1,'id_item' => 1,'the_date' => $date));
          if($BookingArr->num_rows() > 0){
          
          }else{
            $dataArr = array('PropId' => $productId,
                     'id_state' => 1,
                     'id_item' => 1,
                     'the_date' => $date
                    );
            $this->contact_model->simple_insert(CALENDARBOOKING,$dataArr);
          }
         }
         $i++;
      }
      
      //SCHEDULE calendar
      
      $DateArr=$this->product_model->get_all_details(CALENDARBOOKING,array('PropId'=>$productId));
      $dateDispalyRowCount=0;
      if($DateArr->num_rows > 0){
        $dateArrVAl .='{';
        foreach($DateArr->result() as $dateDispalyRow){
                    
          if($dateDispalyRowCount==0){
            $dateArrVAl .='"'.$dateDispalyRow->the_date.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"booked"}';
          }else{
            $dateArrVAl .=',"'.$dateDispalyRow->the_date.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"booked"}';
          }
          $dateDispalyRowCount=$dateDispalyRowCount+1;
        }
        $dateArrVAl .='}';
      }
                    
      $inputArr4=array();
      $inputArr4 = array('id' =>$productId,'data' => trim($dateArrVAl));
                    
      $this->product_model->update_details(SCHEDULE,$inputArr4,array('id' =>$productId));
                    
      //End SCHEDULE calendar
      
      $condition = array('status' => 'Active', 'seo_tag'=>'host-accept');
      $service_tax_host=$this->product_model->get_all_details(COMMISSION, $condition);
      $this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
      $this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
      $condition = array('status' => 'Active', 'seo_tag'=>'guest-booking');
      $service_tax_guest=$this->product_model->get_all_details(COMMISSION, $condition);
      $this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
      $this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
      
      $orderDetails = $this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $eInq_id));
      $userDetails = $this->order_model->get_all_details(USERS,array( 'id' => $orderDetails->row()->renter_id));
      $guest_fee = $orderDetails->row()->serviceFee;
      $netAmount = $orderDetails->row()->totalAmt-$orderDetails->row()->serviceFee;
      if($this->data['host_tax_type'] == 'flat')
      {
        $host_fee = $this->data['host_tax_value'];
      }
      else 
      {
        $host_fee = ($netAmount * $this->data['host_tax_value'])/100;
      }
      $payable_amount = $netAmount - $host_fee;
      $data1 = array('host_email'=>$userDetails->row()->email,
        'booking_no'=>$orderDetails->row()->Bookingno,
        'total_amount'=>$orderDetails->row()->totalAmt,
        'guest_fee'=>$guest_fee,
        'host_fee'=>$host_fee,
        'payable_amount'=>$payable_amount
        );
      $chkQry = $this->order_model->get_all_details(COMMISSION_TRACKING,array( 'booking_no' => $orderDetails->row()->Bookingno));
      if($chkQry->num_rows() == 0) {
        //$this->product_model->simple_insert(COMMISSION_TRACKING, $data1);
      } else { 
        $this->product_model->update_details(COMMISSION_TRACKING,$data1,array('booking_no'=>$orderDetails->row()->Bookingno));
      }
      //$this->booking_conform_mail($DealCodeNo);
      $this->data['Confirmation'] = 'Success';
      $this->data['productId'] = $productId;
      
      $this->data['json_encode'] = $json_encode = json_encode(array("status"=>1,"message"=>"Success","currencycode" =>"USD","total_price" =>floatval($orderDetails->row()->totalAmt),"booking_no"=>$orderDetails->row()->Bookingno));
      
      
      $this->load->view('mobile/mobile_order.php',$this->data);
    }elseif($this->uri->segment(2) == 'failure'){
      $this->data['Confirmation'] = 'Failure';
      $this->data['errors'] = $this->session->userdata('payment_error');
      $this->data['json_encode'] = $json_encode = json_encode(array("status"=>0,"message"=>"Failure"));
      $this->session->unset_userdata('payment_error');
      $this->load->view('mobile/mobile_order.php',$this->data);
    }elseif($this->uri->segment(2) == 'notify'){
      $this->data['Confirmation'] = 'Failure';
      $this->data['json_encode'] = $json_encode = json_encode(array("status"=>0,"message"=>"Failure"));     
      $this->load->view('mobile/mobile_order.php',$this->data);
    }elseif($this->uri->segment(2) == 'confirmation'){
      $this->data['Confirmation'] = 'Success';
      $this->data['json_encode'] = $json_encode = json_encode(array("status"=>1,"message"=>"Success","currencycode" =>"USD","total_price" =>floatval($orderDetails->row()->totalAmt),"booking_no"=>$orderDetails->row()->Bookingno));
      $this->load->view('mobile/mobile_order.php',$this->data);
    }elseif($this->uri->segment(2) == 'pakagesuccess') {
      $this->data['json_encode'] = $json_encode = json_encode(array("status"=>1,"message"=>"Success","currencycode" =>"USD","total_price" =>floatval($orderDetails->row()->totalAmt),"booking_no"=>$orderDetails->row()->Bookingno));
      $this->memberPackageUpdate($this->uri->segment(3)); 
    }
      
      
     
            
  }
  
  
  /** 
   * 
   * Payment Process using credit card
   */
  
  public function userPaymentCard(){
  
    $enqury_id=$this->input->post('enqury_id'); 
    
    $enquryDetails = $this->mobile_model->get_all_details(RENTALENQUIRY,array('id'=>$enqury_id));
    
    
    $condition =array('id' => $enquryDetails->row()->user_id);
    $userDetails = $this->mobile_model->get_all_details(USERS,$condition);
    $loginUserId = $enquryDetails->row()->user_id;
    $lastFeatureInsertId = mt_rand();
    if($this->input->post('creditvalue')=='authorize') 
    { 
      $Auth_Details=unserialize(API_LOGINID); 
      $Auth_Setting_Details=unserialize($Auth_Details['settings']); 
      //echo '<pre>';print_r($Auth_Setting_Details);die;
      error_reporting(-1);
      define("AUTHORIZENET_API_LOGIN_ID",$Auth_Setting_Details['merchantcode']);    // Add your API LOGIN ID
      define("AUTHORIZENET_TRANSACTION_KEY",$Auth_Setting_Details['merchantkey']); // Add your API transaction key
      define("API_MODE",$Auth_Setting_Details['mode']);
      if(API_MODE =='sandbox')
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
      $transaction->setFields(array('amount' =>   $enquryDetails->row()->totalAmt, 
        'card_num' =>  $this->input->post('cardNumber'), 
        'exp_date' => $this->input->post('CCExpDay').'/'.$this->input->post('CCExpMnth'),
        'first_name' =>$userDetails->row()->firstname,
        'last_name' =>$userDetails->row()->lastname,
        'address' => $userDetails->row()->address,
        'city' => $userDetails->row()->city,
        'state' => $userDetails->row()->state,
        'country' => $userDetails->row()->country,
        'phone' => $userDetails->row()->phone_no,
        'email' =>  $userDetails->row()->email,
        'card_code' => $this->input->post('creditCardIdentifier'),
        ));
      $response = $transaction->authorizeAndCapture();
      
      if($response->approved != '')
      {
        $product_id =$enquryDetails->row()->prd_id;
        $product = $this->mobile_model->get_all_details(PRODUCT,array('id' => $product_id));
        $seller = $this->mobile_model->get_all_details(USERS,array('id' => $product->row()->user_id));
        $totalAmount = $enquryDetails->row()->totalAmt;
        $enquiryid = $enquryDetails->row()->id;
        $loginUserId = $enquryDetails->row()->user_id;
        if($lastFeatureInsertId != '') {
        $delete = 'delete from '.PAYMENT.' where dealCodeNumber = "'.$lastFeatureInsertId.'" and user_id = "'.$loginUserId.'" ';
        $this->mobile_model->ExecuteQuery($delete, 'delete');
        $dealCodeNumber = $lastFeatureInsertId;
        } else {
        $dealCodeNumber = mt_rand();
        }
        $insertIds = array();
        $now = date("Y-m-d H:i:s");
        $paymentArr=array(
          'product_id'=>$product_id,
          'sell_id'=>$product->row()->user_id,
          'price'=>$totalAmount,
          'indtotal'=>$product->row()->price,
          'sumtotal'=>$totalAmount,
          'user_id'=>$loginUserId,
          'created' => $now,
          'dealCodeNumber' => $dealCodeNumber,
          'status' => 'Paid',
          'shipping_status' => 'Pending',
          'total'  => $totalAmount,
          'EnquiryId'=>$enquiryid,
          'inserttime' => NOW());
          
        $this->mobile_model->simple_insert(PAYMENT,$paymentArr);
        $insertIds[]=$this->db->insert_id();
        $paymtdata = array(
          'randomNo' => $dealCodeNumber,
          'randomIds' => $insertIds
          );
        
        $this->product_model->edit_rentalbooking(array('booking_status' => 'Booked'),array('id'=>$enquiryid));
        //$lastFeatureInsertId = $this->session->userdata('randomNo');
    
      if( $response->approved ){
        redirect('mobile/success/'.$loginUserId.'/'.$lastFeatureInsertId.'/'.$response->transaction_id);
      }else{    
        redirect('mobile/failed/'.$response->response_reason_text); 
      }
    
  }
  
  }
  }
  
  /** 
   * 
   * Loading success payment
   */
  
  public function pay_success(){
    if($this->uri->segment(5)==''){
      $transId = $_REQUEST['txn_id'];
      $Pray_Email = $_REQUEST['payer_email'];
    }else{
      $transId = $this->uri->segment(5);
      $Pray_Email = '';
    }

    $this->mobdata['Confirmation'] = "Success"; 

    $this->load->view('mobile/success.php',$this->mobdata);
  }
  
  /** 
   * 
   * Loading failed payment
   */
  
  public function pay_failed(){
    $this->mobdata['errors'] = $this->uri->segment(3);
    $this->load->view('mobile/failed.php',$this->mobdata);
  }
  /** 
   * 
   * Connecting back to mobile application
   */
  
  public function payment_return(){
    $this->mobdata['msg'] = $this->uri->segment(3); 
    $this->load->view('mobile/payment_return.php',$this->mobdata);
  }
  
  
  
  /* selvakumar mobile payment function */
  
  /* */
  /* credit form function */
  
  public function credit_card_form(){
    $enqury_id = $_GET['enqury-id'];
    $this->mobdata['enqury_id'] = $enqury_id;
    
    $this->mobdata['enqury_detail'] = $this->mobile_model->get_all_details(RENTALENQUIRY,array('id'=>$this->mobdata['enqury_id']));
    
    $this->mobdata['product_detail'] = $this->mobile_model->get_all_details(PRODUCT,array('id'=>$this->mobdata['enqury_detail']->row()->prd_id));
    
    $this->mobdata['product_image'] = $this->mobile_model->get_all_details(PRODUCT_PHOTOS,array('product_id'=>$this->mobdata['enqury_detail']->row()->prd_id));
    
    $this->load->view('mobile/credit_card_payment.php',$this->mobdata);
  }
  
  /* credit form function */
  /* selvakumar mobile payment function */
  
  
  
  /* Trip Authorize Credit card payment gateway */
  public function PaymentCredit(){
    //echo '<pre>';print_r($_POST);die;
    $cvv = md5($this->input->post('credit_card_identifier'));
    $dataArr = array('cvv' => $cvv);
    $condition =array('id' => $this->input->post('user_id'));
    $userDetails = $this->checkout_model->get_all_details(USERS,$condition);
    $loginUserId = $this->input->post('user_id');
    $lastFeatureInsertId = $this->session->userdata('randomNo');
    $currencyCode = $this->input->post('currencycode');
    if($this->input->post('creditvalue')=='authorize') 
    { 
      $Auth_Details=unserialize(API_LOGINID); 
      $Auth_Setting_Details=unserialize($Auth_Details['settings']); 
      //echo '<pre>';print_r($Auth_Setting_Details);die;
      error_reporting(-1);
      define("AUTHORIZENET_API_LOGIN_ID",$Auth_Setting_Details['merchantcode']);    // Add your API LOGIN ID
      define("AUTHORIZENET_TRANSACTION_KEY",$Auth_Setting_Details['merchantkey']); // Add your API transaction key
      define("API_MODE",$Auth_Setting_Details['mode']);
      if(API_MODE =='sandbox')
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
        'card_num' =>  $this->input->post('cardnumber'), 
        'exp_date' => $this->input->post('cc_exp_day').'/'.$this->input->post('cc_exp_year'),
        'first_name' =>$userDetails->row()->firstname,
        'last_name' =>$userDetails->row()->lastname,
        'address' => $this->input->post('address'),
        'city' => $this->input->post('city'),
        'state' => $this->input->post('state'),
        'country' => $userDetails->row()->country,
        'phone' => $userDetails->row()->phone_no,
        'email' =>  $userDetails->row()->email,
        'card_code' => $this->input->post('credit_card_identifier'),
        ));
      $response = $transaction->authorizeAndCapture();
      //echo '<pre>';print_r($response);die;
      if($response->approved != '')
      {
        $product_id =$this->input->post('property_id');
        $product = $this->mobile_model->get_all_details(PRODUCT,array('id' => $product_id));
        $seller = $this->mobile_model->get_all_details(USERS,array('id' => $product->row()->user_id));
        $totalAmount = $this->input->post('total_price');
        $enquiryid = $this->input->post('enquiryid');
        $loginUserId = $this->input->post('user_id');
        if($this->session->userdata('randomNo') != '') {
        $delete = 'delete from '.PAYMENT.' where dealCodeNumber = "'.$this->session->userdata('randomNo').'" and user_id = "'.$loginUserId.'" ';
        $this->mobile_model->ExecuteQuery($delete, 'delete');
        $dealCodeNumber = $this->session->userdata('randomNo');
        } else {
        $dealCodeNumber = mt_rand();
        }
        $insertIds = array();
        $now = date("Y-m-d H:i:s");
        $paymentArr=array(
          'product_id'=>$product_id,
          'sell_id'=>$product->row()->user_id,
          'price'=>$totalAmount,
          'indtotal'=>$product->row()->price,
          'sumtotal'=>$totalAmount,
          'user_id'=>$loginUserId,
          'created' => $now,
          'dealCodeNumber' => $dealCodeNumber,
          'status' => 'Paid',
          'shipping_status' => 'Pending',
          'total'  => $totalAmount,
          'EnquiryId'=>$enquiryid,
          'inserttime' => NOW());
          
        $this->mobile_model->simple_insert(PAYMENT,$paymentArr);
        $insertIds[]=$this->db->insert_id();
        $paymtdata = array(
          'randomNo' => $dealCodeNumber,
          'randomIds' => $insertIds
          );
        $this->session->set_userdata($paymtdata, $currencyCode);
        $this->mobile_model->edit_rentalbooking(array('booking_status' => 'Booked'),array('id'=>$enquiryid));
        $lastFeatureInsertId = $this->session->userdata('randomNo');
      
//  redirect('order/success/'.$loginUserId.'/'.$lastFeatureInsertId.'/'.$response->transaction_id);
        
        if($response->transaction_id==''){
          $transId = $_REQUEST['txn_id'];
          $Pray_Email = $_REQUEST['payer_email'];
        }else{
          $transId = $response->transaction_id;
          $Pray_Email = '';
        } 
        $UserNo = $loginUserId;
        $DealCodeNo = $lastFeatureInsertId;
          
        $PaymentSuccessCheck = $this->order_model->get_all_details(PAYMENT,array('user_id' => $UserNo, 'dealCodeNumber' => $DealCodeNo,'status'=>'Paid'));
        
        $EnquiryUpdate = $this->order_model->get_all_details(PAYMENT,array('dealCodeNumber'=>$DealCodeNo));
        //echo "<pre>";print_r($EnquiryUpdate->result());die; 
         $eprd_id = $EnquiryUpdate->row()->product_id;
         $eInq_id = $EnquiryUpdate->row()->EnquiryId;
         
         
         /******** coupon   *********/
         
         $coupon = $this->session->userdata('coupon_strip');
         $coupon = explode('-', $coupon);
         
         if($coupon['0'] != ''){
         
         $data = array('is_coupon_used' => 'Yes',
                 'discount_type' => $coupon['4'],
                 'coupon_code' => $coupon['0'],
                 'discount' => $coupon['2'],
                 'dval' => $coupon['1'],
                 'total_amt' => $coupon['3']
                );

         $this->session->unset_userdata('coupon_strip');
         
         $this->order_model->update_details(PAYMENT,$data,array('dealCodeNumber'=>$DealCodeNo));
         $data = array('totalAmt' => $coupon['2']);
         $this->order_model->update_details(RENTALENQUIRY,$data,array('id'=>$eInq_id));
         
         $data = array('code' => trim($coupon['0']));
         $couponi = $this->order_model->get_all_details(COUPONCARDS,$data);
         
         $data = array('purchase_count' => $couponi->row()->purchase_count+1,
                 'card_status' => 'redeemed');
         $this->order_model->update_details(COUPONCARDS,$data,array('id'=>$couponi->row()->id));
        }
        
        /******** coupon end  *************/
        
        $this->data['invoicedata'] = $this->order_model->get_all_details(RENTALENQUIRY,array('id'=>$eInq_id));    
        //print_r($this->data['invoicedata']->result_array());die;
        $condition1 = array('user_id'=>$UserNo,'prd_id'=>$eprd_id,'id'=>$eInq_id);
        $dataArr1 = array('booking_status'=>'Booked');
        
        $this->order_model->update_details(RENTALENQUIRY,$dataArr1,$condition1);
        //echo $this->db->last_query();
        //$this->order_model->commonInsertUpdate(RENTALENQUIRY,'update',$excludeArr1,$dataArr1,$condition1);          
                    
        $this->data['Confirmation'] = $this->order_model->PaymentSuccess($loginUserId,$lastFeatureInsertId,$transId,$Pray_Email);
                      
        $SelBookingQty =$this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $eInq_id));
          
        //booking update
        $productId = $SelBookingQty->row()->prd_id;
        $arrival = $SelBookingQty->row()->checkin;
        $depature = $SelBookingQty->row()->checkout;
        $dates = $this->getDatesFromRange($arrival, $depature);
        $i=1;
        $dateMinus1= count($dates)-1; 
        
        foreach($dates as $date){
          if($i <= $dateMinus1){
            $BookingArr=$this->contact_model->get_all_details(CALENDARBOOKING,array('PropId' => $productId,'id_state' => 1,'id_item' => 1,'the_date' => $date));
            if($BookingArr->num_rows() > 0){
            
            }else{
              $dataArr = array('PropId' => $productId,
                       'id_state' => 1,
                       'id_item' => 1,
                       'the_date' => $date
                      );
              $this->contact_model->simple_insert(CALENDARBOOKING,$dataArr);
            }
           }
           $i++;
        }       
        
        //SCHEDULE calendar
        $DateArr=$this->product_model->get_all_details(CALENDARBOOKING,array('PropId'=>$productId));
        $dateDispalyRowCount=0;
        $dateArrVAl ="";
        $price="";
        if($DateArr->num_rows > 0){
          $dateArrVAl .='{';
          foreach($DateArr->result() as $dateDispalyRow){
                      
            if($dateDispalyRowCount==0){
              $dateArrVAl .='"'.$dateDispalyRow->the_date.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"booked"}';
            }else{
              $dateArrVAl .=',"'.$dateDispalyRow->the_date.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"booked"}';
            }
            $dateDispalyRowCount=$dateDispalyRowCount+1;
          }
          $dateArrVAl .='}';
        }
                      
        $inputArr4=array();
        $inputArr4 = array('id' =>$productId,'data' => trim($dateArrVAl));
                      
        $this->product_model->update_details(SCHEDULE,$inputArr4,array('id' =>$productId));
                      
        //End SCHEDULE calendar
        
        $condition = array('status' => 'Active', 'seo_tag'=>'host-accept');
        $service_tax_host=$this->product_model->get_all_details(COMMISSION, $condition);
        if($service_tax_host->num_rows() > 0) {
         $this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
         $this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
        } else {
          $this->data['host_tax_type'] = 'flat';
          $this->data['host_tax_value'] = '0';
        }
        $condition = array('status' => 'Active', 'seo_tag'=>'guest-booking');
        $service_tax_guest=$this->product_model->get_all_details(COMMISSION, $condition);
        $this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
        $this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
        
        
        $orderDetails = $this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $eInq_id));
        //echo $this->db->last_query();die;
        $userDetails = $this->order_model->get_all_details(USERS,array( 'id' => $orderDetails->row()->renter_id));
        $guest_fee = $orderDetails->row()->serviceFee;
        $netAmount = $orderDetails->row()->totalAmt-$orderDetails->row()->serviceFee;
        if($this->data['host_tax_type'] == 'flat')
        {
          $host_fee = $this->data['host_tax_value'];
        }
        else 
        {
          $host_fee = ($netAmount * $this->data['host_tax_value'])/100;
        }
        $payable_amount = $netAmount - $host_fee;
        $data1 = array('host_email'=>$userDetails->row()->email,
          'booking_no'=>$orderDetails->row()->Bookingno,
          'total_amount'=>$orderDetails->row()->totalAmt,
          'guest_fee'=>$guest_fee,
          'host_fee'=>$host_fee,
          'payable_amount'=>$payable_amount
          );
        $chkQry = $this->order_model->get_all_details(COMMISSION_TRACKING,array( 'booking_no' => $orderDetails->row()->Bookingno));
        if($chkQry->num_rows() == 0)
        $this->product_model->simple_insert(COMMISSION_TRACKING, $data1);
        else
        $this->product_model->update_details(COMMISSION_TRACKING,$data1,array('booking_no'=>$orderDetails->row()->Bookingno));
        

        //$this->booking_conform_mail($DealCodeNo);
                
        $this->data['Confirmation'] = 'Success';
        $this->data['productId'] = $productId;
        
        $json_encode = json_encode(array("status"=>1,"message"=>"Success","currencycode" =>$currencyCode,"total_price" =>floatval($orderDetails->row()->totalAmt),"booking_no"=>$orderDetails->row()->Bookingno));
        echo $json_encode;
        exit;

      }else{
        $json_encode = json_encode(array("status"=>0,"message"=>$response->response_reason_text));
        echo $json_encode;
        exit;
        //redirect('order/failure/'.$response->response_reason_text); 
      }
    }
  }
  /* Trip Authorize Credit card payment gateway Ends */
  
  /* Trip Stripe payment gateway */
  public function UserPaymentCreditStripe(){

    //echo '<pre>'; print_r($_POST); echo $this->checkLogin('U'); die;
    $condition =array('id' => $this->input->post('user_id'));
    $userDetails = $this->mobile_model->get_all_details(USERS,$condition);
    $loginUserId = $this->input->post('product_id');
    $product_id = $this->input->post('product_id');
    $tax = $this->input->post('tax');
    $enquiryid = $this->input->post('enquiryid'); 
    $currencyCode = $this->input->post('currencycode');
    $product = $this->mobile_model->get_all_details(PRODUCT,array('id' => $product_id));
    $seller = $this->mobile_model->get_all_details(USERS,array('id' => $product->row()->user_id));
    $dealcode =$this->db->insert_id();
    $lastFeatureInsertId = $this->session->userdata('randomNo');
    $userDetails = $this->mobile_model->get_all_details(USERS,$condition);
    $values = array('amount' =>  $this->input->post('total_price'), 
            'card_num' =>  $this->input->post('cardnumber'), 
            'exp_date' => $this->input->post('cc_exp_day').'/'.$this->input->post('cc_exp_year'),
            'first_name' =>$userDetails->row()->firstname,
            'last_name' =>$userDetails->row()->lastname,
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'country' => $userDetails->row()->country,
            'phone' => $userDetails->row()->phone_no,
            'email' =>  $userDetails->row()->email,
            'card_code' => $this->input->post('credit_card_identifier'));
    
    $excludeArr = array('authorize_mode','authorize_id','authorize_key','creditvalue','shipping_id','cardtype','email','cardnumber','cc_exp_day','cc_exp_year','credit_card_identifier','total_price','CreditSubmit');
    
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
    //$token = $this->input->post('stripeToken');
        //$token = 'tok_18rNhZGSJl4rw2Zd3itBZgF5';
    $stripeToken = Stripe_Token::create(
      array(
        "card" => array(
          "name" => $userDetails->row()->firstname,
          "number" => $this->input->post('cardnumber'),
          "exp_month" => $this->input->post('cc_exp_day'),
          "exp_year" => $this->input->post('cc_exp_year'),
          "cvc" => $this->input->post('credit_card_identifier')
        )
      )
    );

    $token = $stripeToken['id'];    
        
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
      $product_id =$this->input->post('property_id');
      $product = $this->mobile_model->get_all_details(PRODUCT,array('id' => $product_id));
      $seller = $this->mobile_model->get_all_details(USERS,array('id' => $product->row()->user_id));
      $totalAmount = $this->input->post('total_price');
      if($this->session->userdata('randomNo') != '') {
        $delete = 'delete from '.PAYMENT.' where dealCodeNumber = "'.$this->session->userdata('randomNo').'" and user_id = "'.$loginUserId.'" ';
        $this->mobile_model->ExecuteQuery($delete, 'delete');
        $dealCodeNumber = $this->session->userdata('randomNo');
        } else {
          $dealCodeNumber = mt_rand();
        }
        $insertIds = array();
        $now = date("Y-m-d H:i:s");
        $paymentArr=array(
            'product_id'=>$product_id,
            'sell_id'=>$product->row()->user_id,
            'price'=>$totalAmount,
            'indtotal'=>$product->row()->price,
            'sumtotal'=>$totalAmount,
            'user_id'=>$loginUserId,
            'created' => $now,
            'dealCodeNumber' => $dealCodeNumber,
            'status' => 'Pending',
            'shipping_status' => 'Pending',
            'total'  => $totalAmount,
            'EnquiryId'=>$enquiryid,
            'inserttime' => NOW());
        $this->mobile_model->simple_insert(PAYMENT,$paymentArr);
        $insertIds[]=$this->db->insert_id();
        $paymtdata = array(
          'randomNo' => $dealCodeNumber,
          'randomIds' => $insertIds,
          'EnquiryId'=>$enquiryid
        );
        $this->session->set_userdata($paymtdata);
        $this->mobile_model->edit_rentalbooking(array('booking_status' => 'Booked'),array('id'=>$enquiryid));
        //$lastFeatureInsertId = $this->session->userdata('randomNo');
        $lastFeatureInsertId = $dealCodeNumber;
        
        //redirect('order/success/'.$loginUserId.'/'.$lastFeatureInsertId.'/'.$token);
        if($token==''){
          $transId = $_REQUEST['txn_id'];
          $Pray_Email = $_REQUEST['payer_email'];
        }else{
          $transId = $token;
          $Pray_Email = '';
        } 
        
        $UserNo = $loginUserId;
        $DealCodeNo = $lastFeatureInsertId;
          
        $PaymentSuccessCheck = $this->order_model->get_all_details(PAYMENT,array('user_id' => $UserNo, 'dealCodeNumber' => $DealCodeNo,'status'=>'Paid'));
        
        $EnquiryUpdate = $this->order_model->get_all_details(PAYMENT,array('dealCodeNumber'=>$DealCodeNo));
        //echo "<pre>";print_r($EnquiryUpdate->result());die; 
         $eprd_id = $EnquiryUpdate->row()->product_id;
         $eInq_id = $EnquiryUpdate->row()->EnquiryId;
         
         
         /******** coupon   *********/
         
         $coupon = $this->session->userdata('coupon_strip');
         $coupon = explode('-', $coupon);
         
         if($coupon['0'] != ''){
         
         $data = array('is_coupon_used' => 'Yes',
                 'discount_type' => $coupon['4'],
                 'coupon_code' => $coupon['0'],
                 'discount' => $coupon['2'],
                 'dval' => $coupon['1'],
                 'total_amt' => $coupon['3']
                );

         $this->session->unset_userdata('coupon_strip');
         
         $this->order_model->update_details(PAYMENT,$data,array('dealCodeNumber'=>$DealCodeNo));
         $data = array('totalAmt' => $coupon['2']);
         $this->order_model->update_details(RENTALENQUIRY,$data,array('id'=>$eInq_id));
         
         $data = array('code' => trim($coupon['0']));
         $couponi = $this->order_model->get_all_details(COUPONCARDS,$data);
         
         
         
         $data = array('purchase_count' => $couponi->row()->purchase_count+1,
                 'card_status' => 'redeemed');
         
         

         $this->order_model->update_details(COUPONCARDS,$data,array('id'=>$couponi->row()->id));
        }
        /******** coupon end  *************/
        $this->data['invoicedata'] = $this->order_model->get_all_details(RENTALENQUIRY,array('id'=>$eInq_id));    
        //print_r($this->data['invoicedata']->result_array());die;
        $condition1 = array('user_id'=>$UserNo,'prd_id'=>$eprd_id,'id'=>$eInq_id);
        $dataArr1 = array('booking_status'=>'Booked');
        
        $this->order_model->update_details(RENTALENQUIRY,$dataArr1,$condition1);
        //echo $this->db->last_query();
        //$this->order_model->commonInsertUpdate(RENTALENQUIRY,'update',$excludeArr1,$dataArr1,$condition1);          
        $this->data['Confirmation'] = $this->order_model->PaymentSuccess($loginUserId,$lastFeatureInsertId,$transId,$Pray_Email);
      
        $SelBookingQty =$this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $eInq_id));
      
        //booking update
        $productId = $SelBookingQty->row()->prd_id;
        $arrival = $SelBookingQty->row()->checkin;
        $depature = $SelBookingQty->row()->checkout;
        $dates = $this->getDatesFromRange($arrival, $depature);
        $i=1;
        $dateMinus1= count($dates)-1; 
        
        foreach($dates as $date){
          if($i <= $dateMinus1){
            $BookingArr=$this->contact_model->get_all_details(CALENDARBOOKING,array('PropId' => $productId,'id_state' => 1,'id_item' => 1,'the_date' => $date));
            if($BookingArr->num_rows() > 0){
            
            }else{
              $dataArr = array('PropId' => $productId,
                       'id_state' => 1,
                       'id_item' => 1,
                       'the_date' => $date
                      );
              $this->contact_model->simple_insert(CALENDARBOOKING,$dataArr);
            }
           }
           $i++;
        }
                        
        //SCHEDULE calendar
        $DateArr=$this->product_model->get_all_details(CALENDARBOOKING,array('PropId'=>$productId));
        $dateDispalyRowCount=0;
        $dateArrVAl ="";
        $price="";
        if($DateArr->num_rows > 0){
          $dateArrVAl .='{';
          foreach($DateArr->result() as $dateDispalyRow){
                      
            if($dateDispalyRowCount==0){
              $dateArrVAl .='"'.$dateDispalyRow->the_date.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"booked"}';
            }else{
              $dateArrVAl .=',"'.$dateDispalyRow->the_date.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"booked"}';
            }
            $dateDispalyRowCount=$dateDispalyRowCount+1;
          }
          $dateArrVAl .='}';
        }
                      
        $inputArr4=array();
        $inputArr4 = array('id' =>$productId,'data' => trim($dateArrVAl));
                      
        $this->product_model->update_details(SCHEDULE,$inputArr4,array('id' =>$productId));
                      
        //End SCHEDULE calendar
        
        $condition = array('status' => 'Active', 'seo_tag'=>'host-accept');
        $service_tax_host=$this->product_model->get_all_details(COMMISSION, $condition);
        $this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
        $this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
        $condition = array('status' => 'Active', 'seo_tag'=>'guest-booking');
        $service_tax_guest=$this->product_model->get_all_details(COMMISSION, $condition);
        $this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
        $this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
        
        
        $orderDetails = $this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $eInq_id));
        //echo $this->db->last_query();die;
        $userDetails = $this->order_model->get_all_details(USERS,array( 'id' => $orderDetails->row()->renter_id));
        $guest_fee = $orderDetails->row()->serviceFee;
        $netAmount = $orderDetails->row()->totalAmt-$orderDetails->row()->serviceFee;
        if($this->data['host_tax_type'] == 'flat')
        {
          $host_fee = $this->data['host_tax_value'];
        }
        else 
        {
          $host_fee = ($netAmount * $this->data['host_tax_value'])/100;
        }
        $payable_amount = $netAmount - $host_fee;
        $data1 = array('host_email'=>$userDetails->row()->email,
          'booking_no'=>$orderDetails->row()->Bookingno,
          'total_amount'=>$orderDetails->row()->totalAmt,
          'guest_fee'=>$guest_fee,
          'host_fee'=>$host_fee,
          'payable_amount'=>$payable_amount
          );
        $chkQry = $this->order_model->get_all_details(COMMISSION_TRACKING,array( 'booking_no' => $orderDetails->row()->Bookingno));
        if($chkQry->num_rows() == 0)
        $this->product_model->simple_insert(COMMISSION_TRACKING, $data1);
        else
        $this->product_model->update_details(COMMISSION_TRACKING,$data1,array('booking_no'=>$orderDetails->row()->Bookingno));
        

        //$this->booking_conform_mail($DealCodeNo);
                
        $this->data['Confirmation'] = 'Success';
        $this->data['productId'] = $productId;
        
        $json_encode = json_encode(array("status"=>1,"message"=>"Success","currencycode" =>$currencyCode,"total_price" =>floatval($orderDetails->row()->totalAmt),"booking_no"=>$orderDetails->row()->Bookingno));
        echo $json_encode;
        exit;
      } catch (Exception $e) {
        $error = $e->getMessage();
        $this->session->set_userdata('payment_error', $error);
        
        $json_encode = json_encode(array("status"=>0,"message"=>"failure"));
        echo $json_encode;
        exit;
        //redirect('order/failure'); 
      } 
  }
  
  /* Trips Paypal */
  public function PaymentProcess(){
    //echo '<pre>'; print_r($_POST);die;
    //echo $this->uri->segment(4); die;
    ///print_r($this->checkLogin('U'));die;
    
    $type = $this->input->post('type');
    if($type=='trip') {
      $product_id = $this->input->post('property_id');
      $tax = $this->input->post('tax');
      $enquiryid = $this->input->post('enquiryid'); 
      //$enquiryid = 220;
      $product = $this->mobile_model->get_all_details(PRODUCT,array('id' => $product_id));
$seller = $this->mobile_model->get_all_details(USERS,array('id' => $product->row()->user_id));
      $dealcode =$this->db->insert_id();
      /* Paypal integration start */
      $this->load->library('paypal_class');
      $item_name = $this->input->post('property_title');
  //echo $item_name; exit;
      $totalAmount = $this->input->post('total_price');

      $currencyCode = $this->input->post('currencycode');// Get currency code from Rental Enquiry Table
      //User ID
      $loginUserId = $this->input->post('user_id');
      //DealCodeNumber
      $lastFeatureInsertId = $this->session->userdata('randomNo');
      //echo $lastFeatureInsertId;die;
      $quantity = 1;
      //$BookingproductList = $this->product_model->view_product_details_booking(' where p.id="'.$product_id.'"  group by p.id order by p.created desc limit 0,1');
      //insert payment
      if($this->session->userdata('randomNo') != '') {
        $delete = 'delete from '.PAYMENT.' where dealCodeNumber = "'.$this->session->userdata('randomNo').'" and user_id = "'.$loginUserId.'" and status != "Paid"  ';
        $this->checkout_model->ExecuteQuery($delete, 'delete');
        $dealCodeNumber = $this->session->userdata('randomNo');
      } else {
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
        'created' => $now,
        'dealCodeNumber' => $dealCodeNumber,
        'status' => 'Pending',
        'shipping_status' => 'Pending',
        'total'  => $totalAmount,
        'EnquiryId'=>$enquiryid,
        'inserttime' => NOW());
      $this->mobile_model->simple_insert(PAYMENT,$paymentArr);
      $insertIds[]=$this->db->insert_id();
      $paymtdata = array(
        'randomNo' => $dealCodeNumber,
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
      $CurrencyType = $this->mobile_model->get_all_details(CURRENCY,array('currency_type' => $ctype)); 
      $this->paypal_class->add_field('currency_code', $CurrencyType->row()->currency_type); 
      $this->paypal_class->add_field('image_url',$logo);
      $this->paypal_class->add_field('business',$paypal_settings['merchant_email']); // Business Email
      $this->paypal_class->add_field('return',base_url().'mobilecart/success/'.$loginUserId.'/'.$lastFeatureInsertId); // Return URL
      $this->paypal_class->add_field('cancel_return', base_url().'mobilecart/failure'); // Cancel URL
      $this->paypal_class->add_field('notify_url', base_url().'mobilecart/ipnpayment'); // Notify url
      $this->paypal_class->add_field('custom', 'Product|'.$loginUserId.'|'.$lastFeatureInsertId); // Custom Values
      $this->paypal_class->add_field('item_name', $item_name); // Product Name
      $this->paypal_class->add_field('user_id', $loginUserId);
      $this->paypal_class->add_field('quantity', $quantity); // Quantity

      if($currencyCode != 'USD')
      {
        $totalAmount = convertCurrency($currencyCode,'USD',$totalAmount);
      }
        
      $this->paypal_class->add_field('amount', $totalAmount); // Price
  // echo "<pre>"; print_r($this->paypal_class); exit;
      //echo base_url().'order/success/'.$loginUserId.'/'.$lastFeatureInsertId; die;
      $this->paypal_class->submit_paypal_post(); 
    }else if($type=='listing'){
      $product_id = $this->input->post('property_id');
      //delete failed payment for particular user
      $host_payment=$this->mobile_model->get_all_details(HOSTPAYMENT,array('product_id' => $product_id,'host_id'=>$this->input->post('user_id')));
      if($host_payment->num_rows() >0){
        $delete_failed_payment='DELETE FROM '.HOSTPAYMENT.' WHERE product_id='.$product_id.' AND host_id='.$this->input->post('user_id');
        $this->mobile_model->ExecuteQuery($delete_failed_payment);
      }
      
    
      $product = $this->mobile_model->get_all_details(PRODUCT,array('id' => $product_id));
      $seller = $this->mobile_model->get_all_details(USERS,array('id' => $product->row()->user_id));
            /* Paypal integration start */
      $this->load->library('paypal_class');
      
      $item_name = $this->config->item('email_title').' Property';
      
      $totalAmount = $this->input->post('total_price');
      $loginUserId = $this->input->post('user_id');
      
      $quantity = 1;
            $insertIds = array();
      
      $now = date("Y-m-d H:i:s");
      $paymentArr=array(
      'product_id'=>$product_id,
      'amount'=>$totalAmount,
            'host_id'=>$loginUserId,
            'payment_status' => 'Pending',
      'payment_type' => 'paypal'
      );
      $this->mobile_model->simple_insert(HOSTPAYMENT,$paymentArr);
       $insertIds[]=$this->db->insert_id();
      $paymtdata = array(
                'randomNo' => $dealCodeNumber,
                'randomIds' => $insertIds
              );
              
      $this->session->set_userdata($paymtdata);
       
      $paypal_settings=unserialize($this->config->item('payment_0'));
      
      $paypal_settings=unserialize($paypal_settings['settings']);
      if($paypal_settings['mode'] == 'sandbox'){
        $this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
      }else{
        $this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
      }
      $ctype = ($paypal_settings['mode'] == 'sandbox')?"USD":"USD";
      
      // To change the currency type for below line >> Sandbox: USD, Live: MYR
      $CurrencyType = $this->mobile_model->get_all_details(CURRENCY,array('currency_type' => $ctype )); 
      
      
      $this->paypal_class->add_field('currency_code', $CurrencyType->row()->currency_type); //   USD
      
      $totAmt = $totalAmount * $CurrencyType->row()->currency_rate;
      
            $this->paypal_class->add_field('business',$paypal_settings['merchant_email']); // Business Email
      
      $this->paypal_class->add_field('return',base_url().'mobile-host-payment-success/'.$product_id); // Return URL
      
      $this->paypal_class->add_field('cancel_return', base_url().'mobilecart/failure'); // Cancel URL
      
      $this->paypal_class->add_field('notify_url', base_url().'mobilecart/ipnpayment'); // Notify url
      
      $this->paypal_class->add_field('custom', 'Product|'.$loginUserId.'|'.$lastFeatureInsertId); // Custom Values      
      
      $this->paypal_class->add_field('item_name', $item_name); // Product Name
      
      $this->paypal_class->add_field('user_id', $loginUserId);
      
      $this->paypal_class->add_field('quantity', $quantity); // Quantity
      $this->paypal_class->add_field('amount', number_format($totAmt,2,'.',''));
      
      $this->paypal_class->submit_paypal_post(); 
    } else {
      echo json_encode(array('status'=>0,'message'=>"Invalid type!"));
      exit;
    }
  }
  
  
  public function ipnpayment(){

    mysql_query('CREATE TABLE IF NOT EXISTS '.TRANSACTIONS.' ( `id` int(255) NOT NULL AUTO_INCREMENT,`payment_cycle` varchar(500) NOT NULL,`txn_type` varchar(500) NOT NULL, `last_name` varchar(500) NOT NULL,`next_payment_date` varchar(500) NOT NULL, `residence_country` varchar(500) NOT NULL, `initial_payment_amount` varchar(500) NOT NULL, `currency_code` varchar(500) NOT NULL, `time_created` varchar(500) NOT NULL, `verify_sign` varchar(750) NOT NULL, `period_type` varchar(500) NOT NULL, `payer_status` varchar(500) NOT NULL, `test_ipn` varchar(500) NOT NULL, `tax` varchar(500) NOT NULL, `payer_email` varchar(500) NOT NULL, `first_name` varchar(500) NOT NULL, `receiver_email` varchar(500) NOT NULL, `payer_id` varchar(500) NOT NULL, `product_type` varchar(500) NOT NULL, `shipping` varchar(500) NOT NULL, `amount_per_cycle` varchar(500) NOT NULL, `profile_status` varchar(500) NOT NULL, `charset` varchar(500) NOT NULL, `notify_version` varchar(500) NOT NULL, `amount` varchar(500) NOT NULL, `outstanding_balance` varchar(500) NOT NULL, `recurring_payment_id` varchar(500) NOT NULL, `product_name` varchar(500) NOT NULL,`custom_values` varchar(500) NOT NULL, `ipn_track_id` varchar(500) NOT NULL, `tran_date` datetime NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;');

    mysql_query("insert into ".TRANSACTIONS." set  payment_cycle='".$_REQUEST['payment_cycle']."', txn_type='".$_REQUEST['txn_type']."', last_name='".$_REQUEST['last_name']."',
next_payment_date='".$_REQUEST['next_payment_date']."', residence_country='".$_REQUEST['residence_country']."', initial_payment_amount='".$_REQUEST['initial_payment_amount']."',
currency_code='".$_REQUEST['currency_code']."', time_created='".$_REQUEST['time_created']."', verify_sign='".$_REQUEST['verify_sign']."', period_type= '".$_REQUEST['period_type']."', payer_status='".$_REQUEST['payer_status']."', test_ipn='".$_REQUEST['test_ipn']."', tax='".$_REQUEST['tax']."', payer_email='".$_REQUEST['payer_email']."', first_name='".$_REQUEST['first_name']."', receiver_email='".$_REQUEST['receiver_email']."', payer_id='".$_REQUEST['payer_id']."', product_type='".$_REQUEST['product_type']."', shipping='".$_REQUEST['shipping']."', amount_per_cycle='".$_REQUEST['amount_per_cycle']."', profile_status='".$_REQUEST['profile_status']."', charset='".$_REQUEST['charset']."',
notify_version='".$_REQUEST['notify_version']."', amount='".$_REQUEST['amount']."', outstanding_balance='".$_REQUEST['payment_status']."', recurring_payment_id='".$_REQUEST['txn_id']."', product_name='".$_REQUEST['product_name']."', custom_values ='".$_REQUEST['custom']."', ipn_track_id='".$_REQUEST['ipn_track_id']."', tran_date=NOW()");


    $this->data['heading'] = 'Order Confirmation'; 

    if($_REQUEST['payment_status'] == 'Completed'){
      $newcustom = explode('|',$_REQUEST['custom']);
  
      if($newcustom[0]=='Product'){
        $userdata = array('fc_session_user_id' => $newcustom[1],'randomNo' => $newcustom[2]);
        $this->session->set_userdata($userdata);  
        $transId = $_REQUEST['txn_id'];
        $Pray_Email = $_REQUEST['payer_email'];
        $this->data['Confirmation'] = $this->order_model->PaymentSuccess($newcustom[1],$newcustom[2],$transId,$Pray_Email); 
        //$userdata = array('fc_session_user_id' => $newcustom[1],'randomNo' => $newcustom[2]);
        $this->session->unset_userdata($userdata);
      }elseif($newcustom[0]=='Gift'){
        $userdata = array('fc_session_user_id' => $newcustom[1]);
        $this->session->set_userdata($userdata);
        $transId = $_REQUEST['txn_id'];
        $Pray_Email = $_REQUEST['payer_email'];
        $this->data['Confirmation'] = $this->order_model->PaymentGiftSuccess($newcustom[1],$transId,$Pray_Email); 
        //$userdata = array('fc_session_user_id' => $newcustom[1]);
        $this->session->unset_userdata($userdata);
      }

    } 
      
  }
  
  
  /* My Listing stripe Credit card payment */
  /* My Listing stripe Credit card payment */
  public function HostPaymentCredit(){
    //echo '<pre>'; print_r($_POST);die;
    $product_id = $this->input->post('property_id');
    $currencycode = $this->input->post('currencycode');
    $host_payment=$this->mobile_model->get_all_details(HOSTPAYMENT,array('product_id' => $product_id,'host_id'=>$this->input->post('user_id')));
    if($host_payment->num_rows() >0)
    {
      $delete_failed_payment='DELETE FROM '.HOSTPAYMENT.' WHERE product_id='.$product_id.' AND host_id='.$this->input->post('user_id');
      $this->mobile_model->ExecuteQuery($delete_failed_payment);
    }
    $loginUserId = $this->input->post('user_id');
    $paymentArr=array(
    'product_id'=>$product_id,
    'amount'=>$this->input->post('total_price'),
    'host_id'=>$loginUserId,
    'payment_status' => 'Pending',
    'payment_type' => 'CreditCard'
    );
    
    $this->data['currencyType'] = 'USD';
    $this->mobile_model->simple_insert(HOSTPAYMENT,$paymentArr);

    $totalAmount = $this->input->post('total_price');
//    define("StripeDetails",$this->config->item('payment_1'));
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
    
    $stripeToken = Stripe_Token::create(
      array(
        "card" => array(
          "name" => '',
          "number" => $this->input->post('cardnumber'),
          "exp_month" => $this->input->post('cc_exp_day'),
          "exp_year" => $this->input->post('cc_exp_year'),
          "cvc" => $this->input->post('credit_card_identifier')
        )
      )
    );

    $token = $stripeToken['id'];  
    
    //$token = $this->input->post('stripeToken');
    //$token = 'tok_18rNhZGSJl4rw2Zd3itBZgF5';
     $amounts = $totalAmount*100;
    
    try {
        
      $customer = Stripe_Customer::create(array(
        "card" => $token,
        "description" => "Property Purchase for ".$this->config->item('email_title'),
        "email" => $this->input->post('email'))
      );
     
      Stripe_Charge::create(array(
        "amount" => $amounts, # amount in cents, again
        "currency" => $this->data['currencyType'],
        "customer" => $customer->id)
      );
      
      $dataArr = array('payment_status'=>'paid');
      $condition=array('product_id'=>$product_id);  
      $this->mobile_model->update_details(HOSTPAYMENT,$dataArr,$condition);
      
      $json_encode = json_encode(array("status"=>1,"message"=>"Success","currencycode" =>$this->data['currencyType'],"total_price" =>floatval($totalAmount)));
      echo $json_encode;
    
      //redirect('listing/all');
    } catch (Exception $e) {
    echo json_encode(array('status'=>0,'message'=>$e->getMessage()));
      //redirect('order/failure/'.$e->getMessage()); 
    } 
  }
  /* MY Listing Paypal Payment Gateway  */
  public function HostPayment(){
    //echo '<pre>'; print_r($_POST);die;
     // $product_id = $this->uri->segment(4);
    $product_id = $this->input->post('property_id');
    //delete failed payment for particular user
    $host_payment=$this->mobile_model->get_all_details(HOSTPAYMENT,array('product_id' => $product_id,'host_id'=>$this->input->post('user_id')));
    if($host_payment->num_rows() >0)
    {
    $delete_failed_payment='DELETE FROM '.HOSTPAYMENT.' WHERE product_id='.$product_id.' AND host_id='.$this->input->post('user_id');
    $this->mobile_model->ExecuteQuery($delete_failed_payment);
    }
    
  
    $product = $this->mobile_model->get_all_details(PRODUCT,array('id' => $product_id));
    $seller = $this->mobile_model->get_all_details(USERS,array('id' => $product->row()->user_id));
            /*Paypal integration start */
      $this->load->library('paypal_class');
      
      $item_name = $this->config->item('email_title').' Property';
      
      $totalAmount = $this->input->post('total_price');
      $loginUserId = $this->input->post('user_id');
      
      $quantity = 1;
            $insertIds = array();
      
      $now = date("Y-m-d H:i:s");
      $paymentArr=array(
      'product_id'=>$product_id,
      'amount'=>$totalAmount,
            'host_id'=>$loginUserId,
            'payment_status' => 'Pending',
      'payment_type' => 'paypal'
      );
      $this->mobile_model->simple_insert(HOSTPAYMENT,$paymentArr);
       $insertIds[]=$this->db->insert_id();
      $paymtdata = array(
                'randomNo' => $dealCodeNumber,
                'randomIds' => $insertIds
              );
              
      $this->session->set_userdata($paymtdata);
       
      $paypal_settings=unserialize($this->config->item('payment_0'));
      
      $paypal_settings=unserialize($paypal_settings['settings']);
      if($paypal_settings['mode'] == 'sandbox'){
        $this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
      }else{
        $this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
      }
      $ctype = ($paypal_settings['mode'] == 'sandbox')?"USD":"USD";
      
      // To change the currency type for below line >> Sandbox: USD, Live: MYR
      $CurrencyType = $this->mobile_model->get_all_details(CURRENCY,array('currency_type' => $ctype )); 
      
      
      $this->paypal_class->add_field('currency_code', $CurrencyType->row()->currency_type); //   USD
      
      $totAmt = $totalAmount * $CurrencyType->row()->currency_rate;
      
            $this->paypal_class->add_field('business',$paypal_settings['merchant_email']); // Business Email
      
      $this->paypal_class->add_field('return',base_url().'host-payment-success/'.$product_id); // Return URL
      
      $this->paypal_class->add_field('cancel_return', base_url().'order/failure'); // Cancel URL
      
      $this->paypal_class->add_field('notify_url', base_url().'order/ipnpayment'); // Notify url
      
      $this->paypal_class->add_field('custom', 'Product|'.$loginUserId.'|'.$lastFeatureInsertId); // Custom Values      
      
      $this->paypal_class->add_field('item_name', $item_name); // Product Name
      
      $this->paypal_class->add_field('user_id', $loginUserId);
      
      $this->paypal_class->add_field('quantity', $quantity); // Quantity
      $this->paypal_class->add_field('amount', number_format($totAmt,2,'.',''));
      
      $this->paypal_class->submit_paypal_post(); 
            
  }

  public function getDatesFromRange($start, $end){
      $dates = array($start);
      while(end($dates) < $end){
          $dates[] = date('Y-m-d', strtotime(end($dates).' +1 day'));
      }
    return $dates;
  }
  
  public function hostpayment_success()
  {
  
      $transId = $_REQUEST['txn_id'];
      $Pray_Email = $_REQUEST['payer_email'];     
      $payment_gross = $_REQUEST['payment_gross'];
$currencySymbol = $this->session->userdata('currency_s');
      //var_dump($_REQUEST);die;
      $bookingId = 'EN'.time();
      $this->data['payment_gross'] = $payment_gross;
      $this->data['bookingId'] = $bookingId;
          $dataArr = array('paypal_txn_id' => $transId,'paypal_email' => $Pray_Email,'payment_status'=>'paid', 'bookingId'=>$bookingId);
      
      $condition=array('product_id'=>$this->uri->segment(2)); 
      
      $this->product_model->update_details(HOSTPAYMENT,$dataArr,$condition);
      
      //$this->host_payment_mail($transId);
      //$this->host_payment_mailbyadmin($transId);
      
      //die;
      $this->data['json_encode'] = $json_encode = json_encode(array("status"=>1,"message"=>"Success! Payment Made Successfully, please wait for Approval to list your Product","currencycode" =>"USD","total_price" =>floatval($payment_gross),"booking_no"=>$bookingId));
      $this->setErrorMessage('success','Payment Made Successfull, please wait for Approval to list your Product');
      
      $this->load->view ( 'mobile/mobile_host_success', $this->data );
      
      //redirect('listing/all');
  }

/* Paypal Success */
  public function host_paypal_success()
  {

      $transId = $this->input->post('txn_id');
      $Pray_Email = $this->input->post('payer_email');
      $payment_gross = $this->input->post('payment_gross');
      $currencySymbol = $this->input->post('currency_symbol');
      $currencyCode = $this->input->post('currency_code');
      $property_id = $this->input->post('property_id');
    $condition_user = array('id'=>$property_id);
    $productdetail = $this->mobile_model->get_all_details ( PRODUCT, $condition_user);
    $renter_host_id = $productdetail->row()->user_id;


 $condition = array('currency_type'=>$currencyCode);
 $currency_details = $this->mobile_model->get_all_details ( CURRENCY, $condition);
 $currency_symbol = $currency_details->row()->currency_symbols;
 $default_currency_code = $currency_details->row()->currency_type;

 if($default_currency_code != $currencyCode)
    {
    $payment_gross1 = convertCurrency($currencyCode,$default_currency_code,$payment_gross);
    
    
   }
   else{
     $payment_gross1 = $payment_gross;
     
   }
 $condition12 = array('product_id'=>$property_id);
 $hostpayment_details = $this->mobile_model->get_all_details ( HOSTPAYMENT, $condition12);
  $bookingId = 'EN'.time();
      $this->data['payment_gross'] = $payment_gross;
      $this->data['bookingId'] = $bookingId;
      
 if($hostpayment_details->num_rows()>0) {
      
      $dataArr = array('paypal_txn_id' => $transId,'paypal_email' => $Pray_Email,'payment_status'=>'paid', 'bookingId'=>$bookingId);
      
      $condition=array('product_id'=>$property_id); 
      
      $this->product_model->update_details(HOSTPAYMENT,$dataArr,$condition);
      $dataArrPrd=array('status'=>'Publish');
      $condition_product_query=array('id'=>$property_id); 
      $this->product_model->update_details(PRODUCT,$dataArrPrd,$condition_product_query);

} else {
      $dataArr = array('product_id'=>$property_id,'paypal_txn_id' => $transId,'paypal_email' => $Pray_Email,'payment_status'=>'paid', 'bookingId'=>$bookingId,'host_id'=>$renter_host_id,'amount'=>$payment_gross1,'payment_type'=>'Paypal');
 
      $this->product_model->simple_insert(HOSTPAYMENT,$dataArr);
      $dataArrPrd=array('status'=>'Publish');
      $condition_product_query=array('id'=>$property_id); 
      $this->product_model->update_details(PRODUCT,$dataArrPrd,$condition_product_query);

}

  

      
      
      //$this->host_payment_mail($transId);
      //$this->host_payment_mailbyadmin($transId);
      
      //die;
      
      $response[] = array("currencycode" =>$currencyCode,"total_price" =>floatval($payment_gross),"booking_no"=>$bookingId);
      $json_encode = json_encode(array("status"=>1,"message"=>"Success! Payment Made Successfully, please wait for Approval to list your Product","payment_success"=>$response));
      
      echo $json_encode;
      exit;

  }

  /* Trip Paypal Success */
  public function trip_paypal_success(){
    
    $this->data['heading'] = 'Order Confirmation'; 
    $transId = $this->input->post('txn_id');
    $Pray_Email = $this->input->post('payer_email');
    $UserNo = $this->input->post('user_id');
    $EnquiryId = $this->input->post('enquiryid');
    $property_id = $this->input->post('property_id');
    $currencyCode = $this->input->post('currencycode');

    $PaymentSuccessCheck = $this->order_model->get_all_details(PAYMENT,array('user_id' => $UserNo, 'EnquiryId' => $EnquiryId,'status'=>'Paid'));
    
    $eprd_id = $property_id;
    $eInq_id = $EnquiryId;

    /******** coupon   *********/
       
        $coupon = $this->session->userdata('coupon_strip');
        $coupon = explode('-', $coupon);
         
        if($coupon['0'] != ''){
        
          $data = array('is_coupon_used' => 'Yes',
                   'discount_type' => $coupon['4'],
                   'coupon_code' => $coupon['0'],
                   'discount' => $coupon['2'],
                   'dval' => $coupon['1'],
                   'total_amt' => $coupon['3']
                  );
          $this->session->unset_userdata('coupon_strip');
         
          $this->order_model->update_details(PAYMENT,$data,array('EnquiryId'=>$EnquiryId));
          $data = array('totalAmt' => $coupon['2']);
          $this->order_model->update_details(RENTALENQUIRY,$data,array('id'=>$eInq_id));
          $data = array('code' => trim($coupon['0']));
          $couponi = $this->order_model->get_all_details(COUPONCARDS,$data);
          $data = array('purchase_count' => $couponi->row()->purchase_count+1,
                 'card_status' => 'redeemed');
          $this->order_model->update_details(COUPONCARDS,$data,array('id'=>$couponi->row()->id));
        }
        /******** coupon end  *************/

        $this->data['invoicedata'] = $this->order_model->get_all_details(RENTALENQUIRY,array('id'=>$eInq_id));    
        
        $condition1 = array('user_id'=>$UserNo,'prd_id'=>$eprd_id,'id'=>$eInq_id);
        $dataArr1 = array('booking_status'=>'Booked');
        
        $this->order_model->update_details(RENTALENQUIRY,$dataArr1,$condition1);
        $this->data['Confirmation'] = $this->order_model->PaymentSuccess($this->uri->segment(3),$this->uri->segment(4),$transId,$Pray_Email);
        $SelBookingQty =$this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $eInq_id));

        //booking update
        $productId = $SelBookingQty->row()->prd_id;
        $arrival = $SelBookingQty->row()->checkin;
        $depature = $SelBookingQty->row()->checkout;
        $dates = $this->getDatesFromRange($arrival, $depature);
        $i=1;
        $dateMinus1= count($dates)-1;
        foreach($dates as $date){
          if($i <= $dateMinus1){
            $BookingArr=$this->contact_model->get_all_details(CALENDARBOOKING,array('PropId' => $productId,'id_state' => 1,'id_item' => 1,'the_date' => $date));
            if($BookingArr->num_rows() > 0){
            
            }else{
              $dataArr = array('PropId' => $productId,
                       'id_state' => 1,
                       'id_item' => 1,
                       'the_date' => $date
                      );
              $this->contact_model->simple_insert(CALENDARBOOKING,$dataArr);
            }
           }
           $i++;
        }
        //SCHEDULE calendar
        
        $DateArr=$this->product_model->get_all_details(CALENDARBOOKING,array('PropId'=>$productId));
        $dateDispalyRowCount=0;
        if($DateArr->num_rows > 0){
          $dateArrVAl .='{';
          foreach($DateArr->result() as $dateDispalyRow){
                      
            if($dateDispalyRowCount==0){
              $dateArrVAl .='"'.$dateDispalyRow->the_date.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"booked"}';
            }else{
              $dateArrVAl .=',"'.$dateDispalyRow->the_date.'":{"available":"1","bind":0,"info":"","notes":"","price":"'.$price.'","promo":"","status":"booked"}';
            }
            $dateDispalyRowCount=$dateDispalyRowCount+1;
          }
          $dateArrVAl .='}';
        }
                      
        $inputArr4=array();
        $inputArr4 = array('id' =>$productId,'data' => trim($dateArrVAl));
                      
        $this->product_model->update_details(SCHEDULE,$inputArr4,array('id' =>$productId));
                      
        //End SCHEDULE calendar

        $condition = array('status' => 'Active', 'seo_tag'=>'host-accept');
        $service_tax_host=$this->product_model->get_all_details(COMMISSION, $condition);
        $this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
        $this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
        $condition = array('status' => 'Active', 'seo_tag'=>'guest-booking');
        $service_tax_guest=$this->product_model->get_all_details(COMMISSION, $condition);
        $this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
        $this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
        
        $orderDetails = $this->order_model->get_all_details(RENTALENQUIRY,array( 'id' => $eInq_id));
        $userDetails = $this->order_model->get_all_details(USERS,array( 'id' => $orderDetails->row()->renter_id));
        $guest_fee = $orderDetails->row()->serviceFee;
        $netAmount = $orderDetails->row()->totalAmt-$orderDetails->row()->serviceFee;
        if($this->data['host_tax_type'] == 'flat')
        {
          $host_fee = $this->data['host_tax_value'];
        }
        else 
        {
          $host_fee = ($netAmount * $this->data['host_tax_value'])/100;
        }
        $payable_amount = $netAmount - $host_fee;
        $data1 = array('host_email'=>$userDetails->row()->email,
          'booking_no'=>$orderDetails->row()->Bookingno,
          'total_amount'=>$orderDetails->row()->totalAmt,
          'guest_fee'=>$guest_fee,
          'host_fee'=>$host_fee,
          'payable_amount'=>$payable_amount
          );
        $chkQry = $this->order_model->get_all_details(COMMISSION_TRACKING,array( 'booking_no' => $orderDetails->row()->Bookingno));
        if($chkQry->num_rows() == 0) {
          //$this->product_model->simple_insert(COMMISSION_TRACKING, $data1);
        } else { 
          $this->product_model->update_details(COMMISSION_TRACKING,$data1,array('booking_no'=>$orderDetails->row()->Bookingno));
        }
        //$this->booking_conform_mail($DealCodeNo);
        $this->data['Confirmation'] = 'Success';
        $this->data['productId'] = $productId;
        
        //$this->data['json_encode'] = $json_encode = json_encode(array("status"=>1,"message"=>"Success","currencycode" =>"USD","total_price" =>floatval($orderDetails->row()->totalAmt),"booking_no"=>$orderDetails->row()->Bookingno));

        $response[] = array("currencycode" =>$currencyCode,"total_price" =>floatval($orderDetails->row()->totalAmt),"booking_no"=>$orderDetails->row()->Bookingno);
      $json_encode = json_encode(array("status"=>1,"message"=>"Success! Payment Made Successfully","payment_success"=>$response));
      
      echo $json_encode;
      exit;


}

  

}

/* End of file user.php */
/* Location: ./application/controllers/site/mobilecart.php */