<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('dashboard_model');
    }
    
    
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/dashboard/admin_dashboard');
		}
	}
	
	public function admin_dashboard()
	{
    if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else { 
			/* get dashboard values start*/
			//$recentUserWhereCondition = array('status'=>'Active','group'=>'User');
			$recentUserWhereCondition = array('group'=>'User');
			/* Get user count start*/
			$userTableName = USERS;
			$userFieldName = 'id';
			//print_r($userFieldName);
			$getTotalUsersCount = $this->dashboard_model->getCountDetails($userTableName,$userFieldName,$recentUserWhereCondition);
			
			
			//echo $this->db->last_query();die;
			/* Get user count end*/
			
			/* last 24 hours record start */
			$userWhereCondition = array('status'=>'Active');
			$userWhereCondition1 = array('status'=>'Active');
			// 10.9.2017 $getTodayUsersCount = $this->dashboard_model->getTodayUsersCount($userTableName,$userFieldName,$userWhereCondition1);
			$getTodayUsersCount = $this->dashboard_model->getTodayUsersCount($userTableName,$userFieldName);
			$productTableName = PRODUCT;
			$productFieldName = 'id';			
			$getTodayPropertyCount = $this->dashboard_model->getTodayPropertyCount($productTableName,$productFieldName); 
			$getThisMonthPropertyCount = $this->dashboard_model->getThisMonthPropertyCount($productTableName,$productFieldName);
			$getLastYearProertyCount = $this->dashboard_model->getLastYearProertyCount($productTableName,$productFieldName);
			//echo $this->db->last_query();die;
			
			/* last 24 hours record start */
			
			/* last 30 days record start */
			$userWhereCondition1 = array('status'=>'Active');
			// 10.9.2017 $getThisMonthCount = $this->dashboard_model->getThisMonthCount($userTableName,$userFieldName,$userWhereCondition1);
			$getThisMonthCount = $this->dashboard_model->getThisMonthCount($userTableName,$userFieldName);
			//echo $getThisMonthCount;die;
			/* last 30 days  record start */
			
			
			/* last year record start */
			$userWhereCondition1 = array('status'=>'Active');
			// 10.9.2017 $getLastYearCount = $this->dashboard_model->getLastYearCount($userTableName,$userFieldName,$userWhereCondition1);
			$getLastYearCount = $this->dashboard_model->getLastYearCount($userTableName,$userFieldName);
			  
			//echo $this->db->last_query();die;
			//echo $getLastYearCount;die;
			//echo $getThisMonthCount;die;
			/* last last year  record start */
			
			/* get recent users list start*/
			$recentUserWhereCondition = array('status'=>'Active','group'=>'User');
			$userOrderBy = 'desc';
			$userLimit = "3";
			$getRecentUsersList = $this->dashboard_model->getRecentDetails($userTableName,$userFieldName,$userOrderBy,$userLimit,$recentUserWhereCondition);
			//echo "<pre>";print_r($getRecentUsersList);die;
			
			
			/* get recent users list end*/
			
			/* get recent sellers list start*/
			$rep = $this->dashboard_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			$rep_type = $rep->row()->admin_rep_type;
			
			if($rep->row()->admin_rep_code=='')
			{
				
				$sellerWhereCondition = array('status'=>'Active','group'=>'Seller');
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				$sellerWhereCondition = array('status'=>'Active','group'=>'Seller','rep_code'=>$rep_code);
			}
			//$sellerWhereCondition = array('status'=>'Active','group'=>'Seller');
			$userOrderBy = 'desc';
			$userLimit = "3";
			$getRecentSellerList = $this->dashboard_model->getRecentDetails($userTableName,$userFieldName,$userOrderBy,$userLimit,$sellerWhereCondition);
			//echo "<pre>";print_r($getRecentUsersList);die;
			
			
			/* get recent sellers list end*/
			
			/* get total product count start*/
			$rep = $this->dashboard_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep_un_sellerid = $rep->row()->admin_rep_code;
			//echo $rep_un_sellerid;
			$get_rep = $this->dashboard_model->get_seller($rep_un_sellerid);
			//echo $get_rep->row()->id;
			
			
			
			/*if($rep_un_sellerid=='')
			{
				
			$productTableName = PRODUCT;
			$productFieldName = 'id';
			$productWhereCondition = array();
			$getTotalProductCount = $this->dashboard_model->getCountDetails($productTableName,$productFieldName,$productWhereCondition);
			//echo $getTotalProductCount;
			}
			else
			{
			$productTableName = PRODUCT;
			$productFieldName = 'id';
			//$productWhereCondition = array('user_id'=>$get_rep->row()->id);
			$productWhereCondition = array();
			$rep_code=ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
			
			$getTotalProductCount_rep = $this->dashboard_model->getCountDetails($productTableName,$productFieldName,$productWhereCondition,$rep_code);
			//echo $getTotalProductCount_rep;
			}*/
			
			
			
			$condition = array();
		$rep_code=ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
		if($rep_code!=''){
			$condition = 'where u.status="Active" and u.rep_code="'.$rep_code.'" group by p.id order by p.created desc';
		}else{	
			$condition = 'where u.status="Active" or p.user_id=0 group by p.id order by p.created desc';
		}
		
		$prd_details = $this->dashboard_model->view_product_details($condition);
		$getTotalProductCount1= $prd_details->num_rows();
			
			$this->db->select('*');
			$this->db->from('fc_product');
			$prd_details_count = $this->db->get();
			$getTotalProductCount2 = $prd_details_count->num_rows(); 
			
			
			$productTableName = PRODUCT;
			$productFieldName = 'id';
			$productWhereCondition = array();
			$getTotalProductCount = $this->dashboard_model->getCountDetails($productTableName,$productFieldName,$productWhereCondition);
			
			//echo $getTotalProductCount;die;
			
			$todayproductWhereCondition=array('created'=>date('Y-m-d'));
			$getTodayProductCount = $this->dashboard_model->getCountDetails($productTableName,$productFieldName,$todayproductWhereCondition);
			//echo $getTotalProductCount;die;
			/* get total product count end*/
			
			/* get total seller count start */
			//echo $_SESSION['fc_session_admin_id'];
			$rep = $this->dashboard_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			
			if($rep->row()->admin_rep_code=='')
			{
				$sellerWhereCondition = array('group'=>'Seller');
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				$sellerWhereCondition = array('group'=>'Seller','rep_code'=>$rep_code);
			}
			
			$getTotalSellerCount = $this->dashboard_model->getCountDetails($userTableName,$userFieldName,$sellerWhereCondition);
			
			$TodaysellerWhereCondition=array('created'=>date('Y-m-d'),'group'=>'Seller');
			$getTodaySellerCount = $this->dashboard_model->getCountDetails($userTableName,$userFieldName,$TodaysellerWhereCondition);
			
			//echo $this->db->last_query(); exit;
			/* get total seller count end*/
			
			
			/* get dashboard values end*/
			
			
			/* get recent orders details start*/
			
			
			$getOrderDetails = $this->dashboard_model->getDashboardOrderDetails();
			
			//echo "<pre>";print_r($getOrderDetails);die;
			/* get recent orders details end*/
			
			/*Assign dashboard values to view start */
			/*$data = array('totalUserCounts'=>$getTotalUsersCount,'todayUserCounts'=>$getTodayUsersCount,'getRecentUsersList'=>$getRecentUsersList,'getThisMonthCount'=>$getThisMonthCount,'getLastYearCount'=>$getLastYearCount,'getTotalProductCount'=>$getTotalProductCount,'getTodayProductCount'=>$getTodayProductCount,'getTotalSellerCount'=>$getTotalSellerCount,'getTodaySellerCount'=>$getTodaySellerCount,'getTotalGiftCardCount'=>$getTotalGiftCardCount,'getTotalSubscriberCount'=>$getTotalSubscriberCount,'heading'=>'Dashboard','getOrderDetails'=>$getOrderDetails,'getRecentSellerList'=>$getRecentSellerList,'getTotalProductCount_rep'=>$getTotalProductCount_rep,'rep_type'=>$rep_type);*/
			
			
			$data = array('totalUserCounts'=>$getTotalUsersCount,'todayUserCounts'=>$getTodayUsersCount,'getRecentUsersList'=>$getRecentUsersList,'getThisMonthCount'=>$getThisMonthCount,'getLastYearCount'=>$getLastYearCount,'getTotalProductCount'=>$getTotalProductCount2,'getTodayProductCount'=>$getTodayProductCount,'getTotalSellerCount'=>$getTotalSellerCount,'getTodaySellerCount'=>$getTodaySellerCount,'getTotalGiftCardCount'=>$getTotalGiftCardCount,'getTotalSubscriberCount'=>$getTotalSubscriberCount,'heading'=>'Dashboard','getOrderDetails'=>$getOrderDetails,'getRecentSellerList'=>$getRecentSellerList,'getTotalProductCount_rep'=>$getTotalProductCount1,'rep_type'=>$rep_type,'TodayPropertyCount'=>$getTodayPropertyCount,'ThisMonthPropertyCount'=>$getThisMonthPropertyCount,'getLastYearProertyCount'=>$getLastYearProertyCount);
			
			
			
			
			$this->data = array_merge($data,$this->data);
			$heading = array('heading'=>'Dashboard');
			$this->data = array_merge($this->data,$heading);
			//print_r($data);die;
			
			//nanth 2-9-17//
			$admin_currencyCode=$this->session->userdata('fc_session_admin_currencyCode');

			$this->load->view('admin/adminsettings/dashboard',$this->data);
			
			//nanth 2-9-17//
			
			/*Assign dashboard values to view end */
		}
	
	}
	
	
	
}