<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to seller management
 * @author Teamtweaks
 *
 */

class Seller extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('seller_model');$this->load->model('user_model');$this->load->model('cms_model');
		if ($this->checkPrivileges('Host',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the seller requests page
     */
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/seller/display_seller_dashboard');
		}
	}
	
	/**
	 * 
	 * This function loads the sellers dashboard
	 */
	public function display_seller_dashboard(){
		/*if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Renters Dashboard';
			$condition = array('group'=>'Seller');
			$this->data['sellerList'] = $this->seller_model->get_all_details(USERS,$condition);
			$condition = array('request_status'=>'Pending','group'=>'User');
			$this->data['pendingList'] = $this->seller_model->get_all_details(USERS,$condition);
			$this->load->view('admin/seller/display_seller_dashboard',$this->data);
		}*/
		
		
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Host Dashboard';
			
			$rep = $this->seller_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			if($rep->row()->admin_rep_code=='')
			{
				
				//$condition = array('group' => 'Seller');
				//$condition = 'where `group`="Seller" and `host_status`=0 order by `created` desc';
				$condition = 'where `group`="Seller" order by `created` desc'; //to display even in archive list
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				//$condition = array('group' => 'Seller','rep_code'=>$rep_code);
				//$condition = 'where `group`="Seller" and `rep_code`="'.$rep_code.'" and `host_status`=0 order by `created` desc';
				
				$condition = 'where `group`="Seller" and `rep_code`="'.$rep_code.'" order by `created` desc';
			}
			
			
			//$condition = 'where `group`="Seller" order by `created` desc';
			$this->data['usersList'] = $this->user_model->get_users_details($condition);
			$this->load->view('admin/seller/display_seller_dashboard',$this->data);
		}
	
	}


	/* Seller Proof Verification Starts  - malar 12/07/2017 */
	public function verify_seller()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Verify User Proof';
			$user_id = $this->uri->segment(4,0);
						
			$select_query = "SELECT * FROM ".ID_PROOF." WHERE user_id='".$user_id."'" ;
			
			$this->data['user_id'] = $user_id;
			$this->data['user_type'] = 'Seller';
			$this->data['userDetails'] = $this->user_model->ExecuteQuery($select_query);
			//echo $this->db->last_query();exit;
			//print_r($this->data['userDetails']->result());exit;
			
			//echo $this->data['userDetails']->row()->group; exit;
				
			
			
			$this->load->view('admin/users/verify_user',$this->data);
			
		}
	}

	/* Seller Proof Verification Ends */

	
	/**
	 * 
	 * This function loads the seller requests page
	 */
	public function display_seller_requests(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Hosts Requests';
			$condition = array('request_status' => 'Pending','group' => 'User');
	
			$this->data['sellerRequests'] = $this->seller_model->get_all_details(USERS,$condition);
			$this->load->view('admin/seller/display_seller_requests',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the sellers list page
	 */
	/* public function display_seller_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Hosts List';
			$rep = $this->seller_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			
			if($rep->row()->admin_rep_code=='')
			{
				
				$condition = array('group' => 'Seller');
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				$condition = array('group' => 'Seller','rep_code'=>$rep_code,'host_status'=>0);
			}
			
			if($reptv_code!=''){
				$condition['rep_code']=$reptv_code;
			}
			
			//$condition = array('group' => 'Seller','rep_code'=>'REP00002');
			//$this->data['sellersList'] = $this->seller_model->get_all_details(USERS,$condition);
			
			
		$this->data['sellersList'] = $this->seller_model->get_all_seller_details_Proof($condition);
			
			
			
			//$this->data['sellersList'] = $this->seller_model->get_all_seller_details_admin();
			$this->load->view('admin/seller/display_sellerlist',$this->data);
		}
	} */
	
	
	public function display_seller_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Host List';
			$rep = $this->seller_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			
			if($rep->row()->admin_rep_code=='')
			{
				
				$condition = array('group' => 'Seller','host_status'=>0);
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				$condition = array('group' => 'Seller','rep_code'=>$rep_code,'host_status'=>0);
			}
			
			if($reptv_code!=''){
				$condition['rep_code']=$reptv_code;
			}
			
			//$condition = array('group' => 'Seller','rep_code'=>'REP00002');
			//$this->data['sellersList'] = $this->seller_model->get_all_details(USERS,$condition);
			
			$rep_set = $this->uri->segment(4,0); 
			if($rep_set !='0') { 
				//$condition = array('group' => 'Seller','rep_code'=>$rep_set,'host_status'=>0);
				$condition = array('group' => 'Seller','rep_code'=>$rep_set,'host_status'=>0);
				$this->data['sellersList'] = $this->seller_model->get_all_seller_details_Proof($condition);
			}  else {
			
		$this->data['sellersList'] = $this->seller_model->get_all_seller_details_Proof($condition);
			
			}
			
			//$this->data['sellersList'] = $this->seller_model->get_all_seller_details_admin();
			$this->load->view('admin/seller/display_sellerlist',$this->data);
		}
	} 
	
	
	public function display_archieve_seller(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Hosts Archive List';
			$rep = $this->seller_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			if($rep->row()->admin_rep_code=='')
			{
				
				$condition = array('group' => 'Seller','host_status'=>1);
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				$condition = array('group' => 'Seller','rep_code'=>$rep_code,'host_status'=>1);
			}
			//$condition = array('group' => 'Seller');
			$this->data['sellersList'] = $this->seller_model->get_all_details(USERS,$condition);
			//$this->data['sellersList'] = $this->seller_model->get_all_seller_details_admin();
			$this->load->view('admin/seller/display_archieve_seller',$this->data);
		}
	}
	
	
	
	
	
	/**
	 * 
	 * This function insert and edit a user
	 */
	public function insertEditRenter(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$seller_id = $this->input->post('seller_id');
			$firstname = $this->input->post('firstname');
			$password = md5($this->input->post('new_password'));
			$confirm_password = md5($this->input->post('new_password'));
			$email = $this->input->post('email');
			$rep_code = $this->input->post('rep_code');
			$user_name = $this->input->post('firstname');

			// if ($user_id == ''){
				
				
			// 	$condition = array('firstname' => $firstname);
			// 	$duplicate_name = $this->seller_model->get_all_details(USERS,$condition);
			// 	if ($duplicate_name->num_rows() > 0){
			// 		$this->setErrorMessage('error','First name already exists');
			// 		redirect('admin/seller/add_seller_form');
			// 	}else {
			 		$condition = array('email' => $email);
			 		$duplicate_mail = $this->seller_model->get_all_details(USERS,$condition);
			 		if ($duplicate_mail->num_rows() > 0){
			 			$this->setErrorMessage('error','This email already exists');
			 			redirect('admin/seller/add_seller_form');
			 		}
			
			// 	}
			// }
			$excludeArr = array("email","seller_id","image","new_password","group","status");
			
			$user_group = 'Seller';
			$repcode_id = 1;
			if ($this->input->post('status') != ''){
				$user_status = 'Active';
			}else {
				$user_status = 'Inactive';
			}
			$inputArr = array('group' => $user_group,'email'=>$email, 'status' => $user_status,'repcode_id'=>$repcode_id);
			
			$inputArr['request_status'] = 'Approved';
			
			$datestring = "%Y-%m-%d";
			$time = time();
			//$config['encrypt_name'] = TRUE;
			
			
			
			$Image_name=$_FILES['image']['name'];
			if ($Image_name!=''){
				
			$config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
		    $config['max_size'] = 2000;
			$config ['max_width'] = '272';
		    $config ['max_height'] = '272';
		    $config['upload_path'] = './images/users';
		    $this->load->library('upload', $config);
			if ( $this->upload->do_upload('image')){
		    	$imgDetails = $this->upload->data();
		    	$inputArr['image'] = $imgDetails['file_name'];
			}else{
				$this->setErrorMessage('error','File Should be JPEG,JPG,PNG and below 272*272 px');
				redirect('admin/seller/add_seller_form/');
				
			}
			
			}
			

			//$MemberList = $this->seller_model->get_all_details(FANCYYBOX,array('id'=>$this->input->post('member_pakage')));
			$currDAte=date("Y-m-d");
			if ($seller_id == ''){
				$user_data = array(
					'password'	=>	$password,
					'is_verified'	=>	'No',
					'member_purchase_date'=>$currDAte,
					'package_status' => 'Paid',
					'created'	=>	mdate($datestring,$time),
					'modified'	=>	mdate($datestring,$time),
				);
			}else {
				$user_data = array('modified' =>	mdate($datestring,$time));
			}
			$dataArr = array_merge($inputArr,$user_data);
			$condition = array('id' => $seller_id);
			if ($seller_id == ''){
				//print_r($dataArr);die;
				$this->seller_model->commonInsertUpdate(USERS,'insert',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Added successfully');
				
				/******Mail Function**********/
				$newsid='45';

			$template_values=$this->product_model->get_newsletter_template_details($newsid);
			if($template_values['sender_name']=='' && $template_values['sender_email']==''){
				$sender_email=$this->data['siteContactMail'];
				$sender_name=$this->data['siteTitle'];
			}else{
				$sender_name=$template_values['sender_name'];
				$sender_email=$template_values['sender_email'];
			} 
                          
                $username = $firstname.$lastname;	
                $uid = $insertid;
				$repcode = $rep_code;
				$email = $email;
				$password = $this->input->post('new_password');
		//$username = $usrDetails->row ()->user_name;
		//$email = $usrDetails->row ()->email;
		
		$randStr = $this->get_rand_str ( '10' );

		//$cfmurl = base_url () . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
		$logo_mail = $this->data['logo'];
                                 
                        $email_values = array(
					'from_mail_id'=>$sender_email,
					'to_mail_id'=> $email,
					'subject_message'=>$template_values ['news_subject'],
					'body_messages'=>$message
			);  
           $reg= array('username' => $username, 'email'=>$email, 'password'=>$password, 'email_title' => $sender_name,'logo'=>$logo_mail,'repcode'=>$repcode );
           //print_r($this->data['logo']);
            $message = $this->load->view('newsletter/HostRegistrationConfirmation'.$newsid.'.php',$reg,TRUE);

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
				
				
				
				
				
			}else {
				//print_r($dataArr);die;
				$this->seller_model->commonInsertUpdate(USERS,'update',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Updated successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}
	public function insertEditRenter1(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$user_id = $this->input->post('user_id');
			$firstname = $this->input->post('firstname');
			$password = md5($this->input->post('new_password'));
			$email = $this->input->post('email');
			if ($user_id == ''){
				//$unameArr = $this->config->item('unameArr');
				/*if (!preg_match('/^\w{1,}$/', trim($firstname))){
					$this->setErrorMessage('error','User name not valid. Only alphanumeric allowed');
					echo "<script>window.history.go(-1);</script>";exit;
				}*/
				
				$condition = array('firstname' => $firstname);
				$duplicate_name = $this->seller_model->get_all_details(USERS,$condition);
				if ($duplicate_name->num_rows() > 0){
					$this->setErrorMessage('error','First name already exists');
					redirect('admin/seller/add_seller_form');
				}else {
					$condition = array('email' => $email);
					$duplicate_mail = $this->seller_model->get_all_details(USERS,$condition);
					if ($duplicate_mail->num_rows() > 0){
						$this->setErrorMessage('error','This email already exists');
						redirect('admin/seller/add_seller_form');
					}
				}
			}
			$condition = array('id' => $seller_id);
			$excludeArr = array("user_id","image","new_password","confirm_password","group","status");
			
			$user_group = 'Seller';
			
			if ($this->input->post('status') != ''){
				$user_status = 'Active';
			}else {
				$user_status = 'Inactive';
			}
			$inputArr = array('group' => $user_group, 'status' => $user_status);
			
			$inputArr['request_status'] = 'Approved';
			
			$datestring = "%Y-%m-%d";
			$time = time();
			//$config['encrypt_name'] = TRUE;
			$config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
		    $config['max_size'] = 2000;
		    $config['upload_path'] = './images/users';
		    $this->load->library('upload', $config);
			if ( $this->upload->do_upload('image')){
		    	$imgDetails = $this->upload->data();
		    	$inputArr['image'] = $imgDetails['file_name'];

			}
			//$MemberList = $this->seller_model->get_all_details(FANCYYBOX,array('id'=>$this->input->post('member_pakage')));
			$currDAte=date("Y-m-d");
			if ($user_id == ''){
				$user_data = array(
					'password'	=>	$password,
					'is_verified'	=>	'No',
					'member_purchase_date'=>$currDAte,
					'package_status' => 'Paid',
					'created'	=>	mdate($datestring,$time),
					'modified'	=>	mdate($datestring,$time),
				);
			}else {
				$user_data = array('modified' =>	mdate($datestring,$time));
			}
			$dataArr = array_merge($inputArr,$user_data);
			$condition = array('id' => $user_id);
			if ($user_id == ''){
				$this->seller_model->commonInsertUpdate(USERS,'insert',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Added successfully');
				$insertid = $this->db->insert_id ();
				
				/* Mail function */ 

                        $newsid='39';

			$template_values=$this->product_model->get_newsletter_template_details($newsid);
			if($template_values['sender_name']=='' && $template_values['sender_email']==''){
				$sender_email=$this->data['siteContactMail'];
				$sender_name=$this->data['siteTitle'];
			}else{
				$sender_name=$template_values['sender_name'];
				$sender_email=$template_values['sender_email'];
			} 
                          
                $username = $firstname.$lastname;	
                $uid = $insertid;
		//$username = $usrDetails->row ()->user_name;
		//$email = $usrDetails->row ()->email;
		
		$randStr = $this->get_rand_str ( '10' );

		$cfmurl = base_url () . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
		$logo_mail = $this->data['logo'];
                                 
                        $email_values = array(
					'from_mail_id'=>$sender_email,
					'to_mail_id'=> $email,
					'subject_message'=>$template_values ['news_subject'],
					'body_messages'=>$message
			);  
           $reg= array('username' => $username, 'cfmurl'=>$cfmurl, 'email_title' => $sender_name,'logo'=>$logo_mail );
           //print_r($this->data['logo']);
            $message = $this->load->view('newsletter/UserRegistrationConfirmation'.$newsid.'.php',$reg,TRUE);

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
				
				
				
				
				
			}else {
				//print_r($dataArr);die;
				$this->seller_model->commonInsertUpdate(USERS,'update',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Updated successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}
	
	/**
	 * 
	 * This function insert and edit a seller
	 */
	public function insertEditSeller(){

		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$user_id = $this->input->post('seller_id');
			$firstname = $this->input->post('firstname');
			$user_name = $this->input->post('firstname');
			$password = md5($this->input->post('new_password'));
			$email = $this->input->post('email');

			$accname = $this->input->post('accname');
			$accno = $this->input->post('accno');
			$bankname = $this->input->post('bankname');
			$paypal_email = $this->input->post('paypal_email');

			//echo $email; die;
			if ($user_id == ''){
				
				
				$condition = array('firstname' => $firstname);
				$duplicate_name = $this->user_model->get_all_details(USERS,$condition);
				if ($duplicate_name->num_rows() > 0){
					$this->setErrorMessage('error','First name already exists');
					redirect('admin/seller/add_seller_form');
				}
			}
			$excludeArr = array("user_id","image","new_password","confirm_password","group","status","accname","accno","bankname","paypal_email");
			
			
			$user_group = 'Seller';
			
			if ($this->input->post('status') != ''){
				$user_status = 'Active';
			}else {
				$user_status = 'Inactive';
			}
			$inputArr = array('group' => $user_group,'email'=>$email, 'status' => $user_status, 'user_name' => $user_name,"accname" => $accname,"accno" => $accno,"bankname" => $bankname,"paypal_email" => $paypal_email);
			
			$inputArr['request_status'] = 'Approved';
			
			$datestring = "%Y-%m-%d";
			$time = time();
			//$config['encrypt_name'] = TRUE;
			
			$Image_name=$_FILES['image']['name'];
			if ($Image_name!=''){
			
			$config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
		    $config['max_size'] = 2000000;
			$config ['max_width'] = '272';
		    $config ['max_height'] = '272';
		    $config['upload_path'] = './images/users';
		    $this->load->library('upload', $config);
			if ( $this->upload->do_upload('image')){
		    	$imgDetails = $this->upload->data();
		    	$inputArr['image'] = $imgDetails['file_name'];
			}else{
			
				$this->setErrorMessage('error','File Should be JPEG,JPG,PNG and below 272*272 px');
				redirect('admin/seller/edit_seller_form/'.$user_id);
				//echo "<script>window.history.go(-1)</script>";
			}
			
			}
			
			

			if ($user_id == ''){
				$user_data = array(
					'password'	=>	$password,
					'is_verified'	=>	'No',
					'created'	=>	mdate($datestring,$time),
					'modified'	=>	mdate($datestring,$time),
				);
			}else {
				$user_data = array('modified' =>	mdate($datestring,$time));
			}
			$dataArr = array_merge($inputArr,$user_data);
			$excludeArr = array("user_id","confirm-password","password","new_password","confirm_password","accname","accno","bankname","paypal_email");
			$condition = array('id' => $user_id);
			if ($user_id == ''){
				$this->user_model->commonInsertUpdate(USERS,'insert',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','User added successfully');
			}else {
				//print_r($dataArr);die;
				$this->user_model->commonInsertUpdate(USERS,'update',$excludeArr,$dataArr,$condition);
				if($this->input->post('password') != '')
				{
					$pwd = $this->input->post('password');
					$newdata = array ('password' => md5 ( $pwd ));
					$this->user_model->update_details ( USERS, $newdata, $condition );
				}
				$this->setErrorMessage('success','Host updated successfully');
			}
			
			redirect('admin/seller/display_seller_list');
		}
	}

	public function insertEditSeller1(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			//echo '<pre>';print_r($_POST);die;
			$seller_id = $this->input->post('seller_id');
			$email = $this->input->post('email');
			$excludeArr = array("seller_id","confirm_password","password","email");
			$dataArr = array();
			$condition = array('id' => $seller_id);
			if($this->input->post('password') != '')
			{
				$pwd = $this->input->post('password');
				$newdata = array ('password' => md5 ( $pwd ));
				$this->seller_model->update_details ( USERS, $newdata, $condition );
				$this->send_user_password ( $pwd, $email );
			}		
			if ($seller_id == ''){
				$this->seller_model->commonInsertUpdate(USERS,'update',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','User added successfully');
			}else {
				$this->seller_model->commonInsertUpdate(USERS,'update',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','User updated successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}
	
	public function send_user_password($pwd = '', $email) {
		$newsid = '5';
		$template_values = $this->seller_model->get_newsletter_template_details ( $newsid );
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'email_title' ),
				'logo' => $this->data ['logo'] 
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['news_subject'] . '</title>
			<body>';
		include ('./newsletter/registeration' . $newsid . '.php');
		
		$message .= '</body>
			</html>';
		
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
				'to_mail_id' => $email,
				'subject_message' => 'Password Reset',
				'body_messages' => $message 
		);
		
		//echo stripslashes($message);die;
		
		$email_send_to_common = $this->seller_model->common_email_send ( $email_values );
	}
	
	/**
	 * 
	 * This function change the seller request status
	 */
	public function change_seller_request(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Rejected':'Approved';
			$newdata = array('request_status' => $status);
			if ($status == 'Rejected'){
				$newdata['group'] = 'User';
			}else if ($status == 'Approved'){
				$newdata['group'] = 'Seller';
			}
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS,$newdata,$condition);
			$this->setErrorMessage('success','Host Request '.$status.' Successfully');
			redirect('admin/seller/display_seller_requests');
		}
	}
	
	/**
	 * 
	 * This function change the seller status
	 */
	public function change_seller_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Rejected':'Approved';
			$newdata = array('request_status' => $status);
			if ($status == 'Rejected'){
				$newdata['group'] = 'User';
			}else if ($status == 'Approved'){
				$newdata['group'] = 'Seller';
			}
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS,$newdata,$condition);
			$this->setErrorMessage('success','Host Status Changed Successfully');
			redirect('admin/seller/display_seller_list');
		}
	}
	
	/**
	 * 
	 * This function loads the add new seller form
	 */
	public function add_seller_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New Host';
			$sortArr1 = array('field'=>'name','type'=>'asc');
			$sortArr = array($sortArr1);
			$this->data['member_details'] = $this->seller_model->get_all_details(FANCYYBOX,array('status'=>'Publish'),$sortArr);
			$this->data['query'] = $this->seller_model->get_rep_all_details();
			$country_query = 'SELECT id,name FROM ' . LOCATIONS . ' WHERE status="Active" order by name';
			$this->data ['active_countries'] = $this->cms_model->ExecuteQuery ( $country_query );
			$currency_query = 'SELECT * FROM ' . CURRENCY . ' WHERE status="Active" order by id';
			$this->data ['active_currency'] = $this->cms_model->ExecuteQuery ( $currency_query );
			$this->load->view('admin/seller/add_seller',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the edit seller form
	 */
	public function edit_seller_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit Host';
			$user_id = $this->uri->segment(4,0);
			$condition = array('id' => $user_id);
			$this->data['seller_details'] = $this->seller_model->get_all_details(USERS,$condition);
			$this->data['user_details'] = $this->user_model->get_all_details(USERS,$condition);
			$this->data['user_idProof'] = $this->user_model->get_all_details(ID_PROOF,array('user_id' => $user_id));
			$this->data['member_details'] = $this->seller_model->get_all_details(FANCYYBOX,array('status'=>'Publish'),$sortArr);
			//print_r($this->data['seller_details']->result());die;
			$this->data['query'] = $this->seller_model->get_rep_all_details();
			
			$country_query = 'SELECT id,name FROM ' . LOCATIONS . ' WHERE status="Active" order by name';
			$this->data ['active_countries'] = $this->cms_model->ExecuteQuery ( $country_query );
			$currency_query = 'SELECT * FROM ' . CURRENCY . ' WHERE status="Active" order by id';
			$this->data ['active_currency'] = $this->cms_model->ExecuteQuery ( $currency_query );
			
			if ($this->data['seller_details']->num_rows() == 1 && $this->data['seller_details']->row()->group == 'Seller'){
				$this->load->view('admin/seller/edit_seller',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	
	public function update_host_id_proof(){
		
			if (isset($_POST['submit'])) {
			
			//echo "<pre>";print_r($_POST);exit;
			
			$ids=$this->input->post('id');
			$status=$this->input->post('status');
			$user_id=$this->input->post('user_id');
			$declineStatus=$this->input->post('decline_status');
			foreach ($ids as $id)
			{
				
				if (isset($status[$id]) && $declineStatus=='on' ){
					
					echo "NoProcess";
					
				}
				
				else if (isset($status[$id]) )
				{
					
					//echo "elsee if";
						
					$this->db->set('id_proof_status','Verified'); //value that used to update column  
					$this->db->where('id',$id); //which row want to upgrade  
					$this->db->update(ID_PROOF);              
					$this->setErrorMessage('success','Seller Proof Verified successfully');
					
					/* Mail to Host*/
			/* Mail function */ 

            $newsid='54';
			$template_values=$this->product_model->get_newsletter_template_details($newsid);
			if($template_values['sender_name']=='' && $template_values['sender_email']==''){
				$sender_email=$this->data['siteContactMail'];
				$sender_name=$this->data['siteTitle'];
			}else{
				$sender_name=$template_values['sender_name'];
				$sender_email=$template_values['sender_email'];
			} 
              
			  
		
					$condition = array (
				'id' => $user_id	
				);
		$usrDetails = $this->user_model->get_all_details( USERS, $condition );
		
		//echo $this->db->last_query();
		
		$uid = $usrDetails->row ()->id;
		$username = $usrDetails->row ()->user_name;
		$email = $usrDetails->row ()->email;
		
		
		//echo $username;
		
		
		$randStr = $this->get_rand_str ( '10' );

		//$cfmurl = base_url () . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
		//$logo_mail = $this->data['logo'];
                                 
                      $email_values = array(
					'from_mail_id'=>$sender_email,
					//'from_mail_id'=>'kailashkumar.r@pofitec.com',
					'to_mail_id'=> $email,
					//'to_mail_id'=> 'preetha@pofitec.com',
					'subject_message'=>$template_values ['news_subject'],
					'body_messages'=>$message
			);  
			$reg= array('hostname' => $username);
           //print_r($this->data['logo']);
            $message = $this->load->view('newsletter/Admin - ID Proof verified'.$newsid.'.php',$reg,TRUE);

            
            //send mail
            $this->load->library('email',$config);
            $this->email->from($email_values['from_mail_id'], $sender_name);
            $this->email->to($email_values['to_mail_id']);
            $this->email->subject($email_values['subject_message']);
            $this->email->set_mailtype("html");
           $this->email->message($message); 
                        
                        
						if ($this->email->send()){
							echo "Success";
						}else{
							 echo $this->email->print_debugger();
						}
						
					//exit;
						
                        // try{
                        // $this->email->send();
                        // $returnStr ['msg'] = 'Successfully registered';
			// $returnStr ['success'] = '1';
                        // }catch(Exception $e){
                        // echo $e->getMessage();
                        // }                   
                        
                        /* Mail function End */  

					
					/* Mail to Host End*/
					
	
				}
				else{

			//	echo "else";
				
					$this->db->set('id_proof_status','UnVerified'); //value that used to update column  
					$this->db->where('id',$id); //which row want to upgrade  
					$this->db->update(ID_PROOF);	               
					$this->setErrorMessage('success','Seller Proof Verified successfully');
					
				}
				
				
				//$this->load->view('admin/seller/add_seller',$this->data);
				//redirect('admin/seller/display_seller_list');				
			}
			
			
			
			
	if ($declineStatus=='on'){
		
	
				
					$this->db->set('decline_status','Yes');
					$this->db->set('id_proof_status','UnVerified');			//value that used to update column  
					$this->db->where('user_id',$user_id); //which row want to upgrade  
					$this->db->update(ID_PROOF);	               
					$this->setErrorMessage('success','Status Updated successfully');
					
					/* Mail To Host*/

			/* Mail function */ 

            $newsid='55';
			$template_values=$this->product_model->get_newsletter_template_details($newsid);
			if($template_values['sender_name']=='' && $template_values['sender_email']==''){
				$sender_email=$this->data['siteContactMail'];
				$sender_name=$this->data['siteTitle'];
			}else{
				$sender_name=$template_values['sender_name'];
				$sender_email=$template_values['sender_email'];
			} 
			
              
						$condition = array (
				'id' => $user_id	
				);
		$usrDetails = $this->user_model->get_all_details( USERS, $condition );  
		
		$uid = $usrDetails->row ()->id;
		$username = $usrDetails->row ()->user_name;
		$email = $usrDetails->row ()->email;
		
		//echo $username;
		
		$randStr = $this->get_rand_str ( '10' );

		//$cfmurl = base_url () . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
		//$logo_mail = $this->data['logo'];
                                 
                      $email_values = array(
					'from_mail_id'=>$sender_email,
					//'from_mail_id'=>'kailashkumar.r@pofitec',
					'to_mail_id'=> $email,
					//'to_mail_id'=> 'preetha@pofitec.com',
					'subject_message'=>$template_values ['news_subject'],
					'body_messages'=>$message
			);  
			$reg= array('hostname' => $username);
           //print_r($this->data['logo']);
            $message = $this->load->view('newsletter/Admin - Request to Host to Send another ID Proof'.$newsid.'.php',$reg,TRUE);

            
            //send mail
            $this->load->library('email',$config);
            $this->email->from($email_values['from_mail_id'], $sender_name);
            $this->email->to($email_values['to_mail_id']);
            $this->email->subject($email_values['subject_message']);
            $this->email->set_mailtype("html");
            $this->email->message($message); 
                        
						
					if ($this->email->send())	{
						echo "Success";
					}else{
						 echo $this->email->print_debugger();
						
					}
						
						
						//exit;
                       
                        // try{
                        // $this->email->send();
                        // $returnStr ['msg'] = 'Successfully registered';
			// $returnStr ['success'] = '1';
                        // }catch(Exception $e){
                        // echo $e->getMessage();
                        // }                   
                        
                        /* Mail function End */  
					

					
				/* Mail To Host End*/
					
					
//echo $this->db->last_query();					
			}else{
				
				//echo "offff";
				
					$this->db->set('decline_status','No'); //value that used to update column  
					$this->db->where('user_id',$user_id); //which row want to upgrade  
					$this->db->update(ID_PROOF);	               
					$this->setErrorMessage('success','Status Updated successfully');
//echo $this->db->last_query();	
				
			}

			//exit;

			
		}
			redirect('admin/seller/display_seller_list');
		
		
	}
	
	
	/**
	 * 
	 * This function loads the seller view page
	 */
	public function view_seller(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View Host';
			$seller_id = $this->uri->segment(4,0);
			$condition = array('id' => $seller_id);
			$this->data['seller_details'] = $this->seller_model->get_all_details(USERS,$condition);
			if ($this->data['seller_details']->num_rows() == 1){
				$this->load->view('admin/seller/view_seller',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function delete the seller record from db
	 */
	public function delete_seller(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$seller_id = $this->uri->segment(4,0);
			/*$condition = array('id' => $seller_id);
			$this->seller_model->commonDelete(USERS,$condition);
			$condition1 = array('user_id' => $seller_id);
			$this->seller_model->commonDelete(PRODUCT,$condition1);*/
			$act=1;
			$this->db->reconnect();
			$this->db->where('id',$seller_id);
			$this->db->set('host_status',$act);
            $this->db->update(USERS);
			
			$this->db->reconnect();
			$this->db->where('user_id',$seller_id);
			$this->db->set('host_status',$act);
            $this->db->update(PRODUCT);
			$this->setErrorMessage('success','Host deleted successfully');
			redirect('admin/seller/display_seller_list');
		}
	}
	
	public function update_seller(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$seller_id = $this->uri->segment(4,0);
			/*$condition = array('id' => $seller_id);
			$this->seller_model->commonDelete(USERS,$condition);
			$condition1 = array('user_id' => $seller_id);
			$this->seller_model->commonDelete(PRODUCT,$condition1);*/
			$act=0;
			$this->db->reconnect();
			$this->db->where('id',$seller_id);
			$this->db->set('host_status',$act);
            $this->db->update(USERS);
			
			$this->db->reconnect();
			$this->db->where('user_id',$seller_id);
			$this->db->set('host_status',$act);
            $this->db->update(PRODUCT);
			$this->setErrorMessage('success','Host Updated successfully');
			redirect('admin/seller/display_archieve_seller');
		}
	}
	
	/**
	 * 
	 * This function delete the seller request records
	 */
	public function change_seller_status_global(){
		if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
			$this->seller_model->activeInactiveCommon(USERS,'id');
			if (strtolower($_POST['statusMode']) == 'delete'){
				$this->setErrorMessage('success','Host records deleted successfully');
			}else {
				$this->setErrorMessage('success','Host records status changed successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}
	
	/**
	 * 
	 * This function change the user status
	 */
	/* public function change_user_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Inactive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS,$newdata,$condition);
			$this->setErrorMessage('success','Host Status Changed Successfully');
			redirect('admin/seller/display_seller_list');
		}
	} */
	
	
	public function change_user_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Inactive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS,$newdata,$condition);
			$this->setErrorMessage('success','Host Status Changed Successfully');
			redirect('admin/seller/display_seller_list');
		}
	}
	
	public function verify_user_status(){
	echo ("inside function");
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'No':'Yes';
			$newdata = array('is_verified' => $status);
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS,$newdata,$condition);
			$this->setErrorMessage('success','Host Status Changed Successfully');
			redirect('admin/seller/display_seller_list');
		}
	}
	
	public function verify_user_liststatus(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'no':'Yes';
			$newdata = array('other' => $status);
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(LISTSPACE_VALUES,$newdata,$condition);
			$this->setErrorMessage('success','User Status Changed Successfully');
			redirect('admin/listattribute/display_listspace_values');
		}
	}
	
	public function update_refund(){
		if ($this->checkLogin('A') != ''){
			$uid = $this->input->post('uid');
			$refund_amount = $this->input->post('amt');
			if ($uid != ''){
				$this->seller_model->update_details(USERS,array('refund_amount'=>$refund_amount),array('id'=>$uid));
			}
		}
	}
	
	
	 /* Export Excel function */
	public function customerExcelExport() 
	{	
		$sortArr = array('field'=>'id','type'=>'desc');
		
		$rep_code=ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
		if($rep_code!=''){
			$condition = array('group'=>'Seller','rep_code'=>$rep_code);
		}else{	
			$condition = array('group'=>'Seller');
		}
		
		$UserDetails = $this->user_model->get_all_details(USERS,$condition);
		$data['getCustomerDetails'] = $UserDetails->result_array();
		//echo '<pre>';print_r($data['getCustomerDetails']);die;
		$this->load->view('admin/seller/customerExportExcel',$data);
	}	
	
	public function check_seller_email_exist(){
		$email_id = $_POST['email_id'];
		
		$this->data['exist'] =  $this->seller_model->check_seller_email_exist($email_id);
		if ($this->data['exist']->num_rows() > 0){
			echo "1";
		}
	}
	
}

/* End of file seller.php */
/* Location: ./application/controllers/admin/seller.php */