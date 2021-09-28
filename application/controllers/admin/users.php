<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to user management 
 * @author Teamtweaks
 *
 */

class Users extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation','image_lib','resizeimage'));		
		$this->load->model('user_model');
		$this->load->library('pagination');
		if ($this->checkPrivileges('Members',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the users list page
     */
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/users/display_user_list');
		}
	}


	/* User ID proof Verify  starts */
	public function verify_user()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Verify User Proof';
			$user_id = $this->uri->segment(4,0);
						
			$select_query = "SELECT * FROM ".ID_PROOF." WHERE user_id='".$user_id."'" ;
			
			$this->data['user_id'] = $user_id;
			$this->data['user_type'] = 'User';
			$this->data['userDetails'] = $this->user_model->ExecuteQuery($select_query);
			//echo $this->db->last_query();exit;
			//print_r($this->data['userDetails']->result());exit;
			
			//echo $this->data['userDetails']->row()->group; exit;
				
			
			
			$this->load->view('admin/users/verify_user',$this->data);
			
		}
	}


    public function update_proof_file(){
    	if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {

	    	if (isset($_POST['submit'])) {
				
				//echo "<pre>";print_r($_POST);exit;
				
				$ids=$this->input->post('proofID');
				$status=$this->input->post('proof_status');
				$comments = $this->input->post('comments');
				$user_type = $this->input->post('user_type');
				// print_r($id);
				//print_r($status); exit;
				foreach ($ids as $id)
				{
					
						//echo "Update Here";
							
						$this->db->set('proof_status',$status[$id]); //value that used to update column  
						$this->db->set('proof_comments',$comments[$id]); //value that used to update column  
						$this->db->where('id',$id); //which row want to upgrade  
						$this->db->update(ID_PROOF);	               
						
					
					//$this->load->view('admin/seller/add_seller',$this->data);
					//redirect('admin/seller/display_seller_list');				
				}			
				$this->setErrorMessage('success',' Proof Verified successfully');
			}
			if($user_type=='User')
				redirect('admin/users/display_user_list');
			else
				redirect('admin/seller/display_seller_list');
		}
    }

	/*  User ID proof Verify Ends */
	
	/**
	 * 
	 * This function loads the users list page
	 */
	 /*  public function display_user_list()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Guest List';
			
			
			$rep_code=ltrim($this->session->userdata('fc_session_admin_rep_code'), '0'); 
			if($rep_code!=''){
				$condition1 = array('group' => 'User','rep_code'=>$rep_code);
				//$condition = 'where u.status="Active" and u.rep_code="'.$rep_code.'" group by cit.name order by p.created desc';
			}else{
				$condition1 = array('group'=>'User');
				//$condition = 'where u.status="Active" or p.user_id=0 group by cit.name order by p.created desc';
			}
			
			//$condition = array();
			//$condition1 = array('group'=>'User');
			
			//$condition = array();
			$config = array();	
			$config["base_url"] = base_url() . "admin/users/display_user_list";	
			$total_row = $this->db->count_all(USERS,$condition,$condition1); 
			$config["total_rows"] = $total_row;			
			$config["per_page"] = 1;	
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = 3;	
			$config['cur_tag_open'] = '<a class="current">';
			$config['cur_tag_close'] = '</a>';
			$config['next_link'] = '<span>Next</span>';	
			$config['prev_link'] = 'Previous';
			$config['uri_segment'] = 4;	
			$rowsperpage = $config["per_page"];	
			$totalpages = ceil($total_row / $rowsperpage);
			if($this->uri->segment(4)){	
			$currentpage = ($this->uri->segment(4)) ;	}
			else{$currentpage = 1;}	
			if ($currentpage > $totalpages) {		
			$currentpage = $totalpages;		}
			if ($currentpage < 1) {$currentpage = 1;}
			$offset = ($currentpage - 1) * $rowsperpage;			
			$this->pagination->initialize($config);		
			
			
			$this->data['usersList'] = $this->user_model->get_user_details(USERS,$condition1,$config["per_page"],$offset);
			$this->data['links'] = $this->pagination->create_links();//print_r($this->data['cityList']);die;
			
			
			
			$this->load->view('admin/users/display_userlist',$this->data);
		}
	}  */
	
	  /* public function display_user_list()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Guest List';
			
			
			$rep_code=ltrim($this->session->userdata('fc_session_admin_rep_code'), '0'); 
			if($rep_code!=''){
				$condition1 = array('group' => 'User','rep_code'=>$rep_code);
				//$condition = 'where u.status="Active" and u.rep_code="'.$rep_code.'" group by cit.name order by p.created desc';
			}else{
				$condition1 = array('group'=>'User');
				//$condition = 'where u.status="Active" or p.user_id=0 group by cit.name order by p.created desc';
			}
			
			//$condition = array();
			//$condition1 = array('group'=>'User');
			
			//$condition = array();
			$config = array();	
			$config["base_url"] = base_url() . "admin/users/display_user_list";	
			$total_row = $this->db->count_all(USERS,$condition,$condition1); 
			$config["total_rows"] = $total_row;			
			$config["per_page"] = 3;	
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['uri_segment'] = 4;	
			$config['suffix'] = '?'.http_build_query($_GET, '', "&"); 
			$this->pagination->initialize($config);
			$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0; 
			$this->data['links'] = $this->pagination->create_links();
			$this->data['usersList'] = $this->user_model->get_user_details(USERS,$condition1,$config["per_page"],NULL);
			$this->data['links'] = $this->pagination->create_links();//print_r($this->data['cityList']);die;
			$this->load->view('admin/users/display_userlist',$this->data);
		}
	} */
	 

	 public function display_user_list()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Guest List';
			
			$condition = array('group'=>'User','email !=' => '');
			$condition1 = array(array('field'=>'id','type'=>'desc'));
			$this->data['usersList'] = $this->user_model->get_all_details(USERS,$condition,$condition1);
			
			
			//$this->data['usersList'] = $this->user_model->get_all_user_details_Proof( 'u.group = "User" ORDER BY u.id desc');
			
			
			
			$this->load->view('admin/users/display_userlist',$this->data);
		}
	}
	 
	/**
	 * 
	 * This function loads the users dashboard
	 */

	public function display_user_dashboard(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Guest Dashboard';
			$condition = 'where `group`="User" order by `id` desc'; 
			$this->data['usersList'] = $this->user_model->get_users_details($condition);
			$this->load->view('admin/users/display_user_dashboard',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the add new user form
	 */
	public function add_user_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New Guest';
			$this->load->view('admin/users/add_user',$this->data);
		}
	}
	
	/**
	 * 
	 * This function insert and edit a user
	 */
	public function insertEditUser(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$user_id = $this->input->post('user_id');
			$first = $this->input->post('firstname');
			$firstname = $first.trim();
			$user = $this->input->post('firstname');
			$user_name = $user.trim();
		
			$password = md5($this->input->post('new_password'));
			$email = $this->input->post('email');
			if ($user_id == ''){
				//$unameArr = $this->config->item('unameArr');
				/*if (!preg_match('/^\w{1,}$/', trim($firstname))){
					$this->setErrorMessage('error','User name not valid. Only alphanumeric allowed');
					echo "<script>window.history.go(-1);</script>";exit;
				}*/
				
				$condition = array('firstname' => $firstname);
				$duplicate_name = $this->user_model->get_all_details(USERS,$condition);
				/*if ($duplicate_name->num_rows() > 0){
					 $this->setErrorMessage('error','First name already exists');
					redirect('admin/users/add_user_form'); 
				}else {*/
					$condition = array('email' => $email);
					$duplicate_mail = $this->user_model->get_all_details(USERS,$condition);
					 if ($duplicate_mail->num_rows() > 0){
						$this->setErrorMessage('error','User email already exists');
						redirect('admin/users/add_user_form');
					} 
				/* } */
			}
			$excludeArr = array("user_id","image","new_password","confirm_password","group","status");
			
			$user_group = 'User';
			
			if ($this->input->post('status') != ''){
				$user_status = 'Active';
			}else {
				$user_status = 'Inactive';
			}
			$inputArr = array('group' => $user_group, 'status' => $user_status, 'user_name' => $user_name);
			
			$inputArr['request_status'] = 'Approved';
			
			$datestring = "%Y-%m-%d %H:%s:%i";
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
		    	/* Compress */ 
		    	$source_photo = './images/users/'.$imgDetails['file_name'].'';
				$dest_photo = './images/users/'.$imgDetails['file_name'];
				$this->compress($source_photo, $dest_photo, $this->config->item('image_compress_percentage'));
				/* End Compress */ 
			}else{
				
				if ($user_id !=''){
				$this->setErrorMessage('error','File Should be JPEG,JPG,PNG and below 272*272 px');
				redirect('admin/users/edit_user_form/'.$user_id);
				
				}else{
				$this->setErrorMessage('error','File Should be JPEG,JPG,PNG and below 272*272 px');
				redirect('admin/users/add_user_form/');
				
					
				}
				
				
				
				
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
			$excludeArr = array("user_id","confirm-password","password","new_password","confirm_password");
			$condition = array('id' => $user_id);
			if ($user_id == ''){
				$this->user_model->commonInsertUpdate(USERS,'insert',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','User added successfully');
				
				$insertid = $this->db->insert_id ();
                              
                        /* Mail function */ 

                        $newsid='39';

			$template_values=$this->product_model->get_newsletter_template_details($newsid);
			if($template_values['sender_name']=='' && $template_values['sender_email']==''){
				$sender_email=$this->data['siteContactMail'];
				$sender_name=$this->data['siteTitle'];
			} else {
				$sender_name=$template_values['sender_name'];
				$sender_email=$template_values['sender_email'];
			} 
                          
                $username = $firstname.$lastname;	
                $uid = $insertid;
		$randStr = $this->get_rand_str ( '10' );
		$cfmurl = base_url () . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
		$logo_mail = $this->data['logo'];
                                 
                        $email_values = array(
					'from_mail_id'=>$sender_email,
					'to_mail_id'=> $email,
					'subject_message'=>$template_values ['news_subject'],
					'body_messages'=>$message
			);  
           $reg= array('username' => $username, 'email'=>$email, 'password'=>$this->input->post('new_password'), 'cfmurl'=>$cfmurl, 'email_title' => $sender_name,'logo'=>$logo_mail );
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
				$this->user_model->commonInsertUpdate(USERS,'update',$excludeArr,$dataArr,$condition);
				if($this->input->post('password') != '')
				{
					$pwd = $this->input->post('password');
					$newdata = array ('password' => md5 ( $pwd ));
					$this->user_model->update_details ( USERS, $newdata, $condition );
				}
				$this->setErrorMessage('success','User updated successfully');
			}
			
			redirect('admin/users/display_user_list');
		}
	}
	
	/**
	 * 
	 * This function loads the edit user form
	 */
	public function edit_user_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit Member';
			$user_id = $this->uri->segment(4,0);
			$condition = array('id' => $user_id);
			$this->data['user_details'] = $this->user_model->get_all_details(USERS,$condition);
			 $this->data['user_idProof'] = $this->user_model->get_all_details(ID_PROOF,array('user_id' => $user_id));
			if ($this->data['user_details']->num_rows() == 1){
				$this->load->view('admin/users/edit_user',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	
		
public function update_member_id_proof(){
		
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
					//'from_mail_id'=>$sender_email,
					'from_mail_id'=>'kailashkumar.r@pofitec.com',
					//'to_mail_id'=> $email,
					'to_mail_id'=> 'preetha@pofitec.com',
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
					//'from_mail_id'=>$sender_email,
					'from_mail_id'=>'kailashkumar.r@pofitec',
					//'to_mail_id'=> $email,
					'to_mail_id'=> 'preetha@pofitec.com',
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
			redirect('admin/users/display_user_list');
		
		
	}
	
	
	
	
	
	
	
	
	/**
	 * 
	 * This function change the user status
	 */
	public function change_user_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Inactive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			$this->user_model->update_details(USERS,$newdata,$condition);
			$this->setErrorMessage('success','User Status Changed Successfully');
			redirect('admin/users/display_user_list');
		}
	}
	
	/**
	 * 
	 * This function loads the user view page
	 */
	public function view_user(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View User';
			$user_id = $this->uri->segment(4,0);
			$condition = array('id' => $user_id);
			$this->data['user_details'] = $this->user_model->get_all_details(USERS,$condition);
			if ($this->data['user_details']->num_rows() == 1){
				$this->load->view('admin/users/view_user',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function delete the user record from db
	 */
	public function delete_user(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$user_id = $this->uri->segment(4,0);
			$condition = array('id' => $user_id);
			$this->user_model->commonDelete(USERS,$condition);
			$this->setErrorMessage('success','User deleted successfully');
            redirect('admin/users/display_user_list');
		}
	}
	/**
	 * 
	 * This function change the user verified status
	 */
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
			$this->user_model->update_details(USERS,$newdata,$condition);
			$this->setErrorMessage('success','User Status Changed Successfully');
			redirect('admin/users/display_user_list');
		}
	}
	
	
	/**
	 * 
	 * This function change the user status, delete the user record
	 */
	public function change_user_status_global(){
		if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
			$this->user_model->activeInactiveCommon(USERS,'id');
			if (strtolower($_POST['statusMode']) == 'delete'){
				$this->setErrorMessage('success','User records deleted successfully');
			}else {
				$this->setErrorMessage('success','User records status changed successfully');
			}
			redirect('admin/users/display_user_list');
		}
	}
	
	public function export_user_details()
	{
	$fields_wanted=array('firstname','lastname','email','created','last_login_date','last_login_ip','status');
    $table=USERS;
	$users=$this->user_model->export_user_details($table,$fields_wanted);
	$this->data['users_detail']=$users['users_detail']->result_array();
	$this->load->view('admin/users/export_user',$this->data);
	}
	
	  /*This function used to check subadmin email id is already exist or not when add/edit subadmin */
	public function check_user_email_exist(){
		$email_id = $_POST['email_id'];
		$group    = $_POST['group'];
		$exist    =  $this->user_model->check_user_email_exist($email_id,$group);
		echo $exist->num_rows();
	} 
}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */