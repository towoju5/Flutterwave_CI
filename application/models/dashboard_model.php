<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Dashboard_model extends My_Model
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	function getCountDetails($tableName='',$fieldName='',$whereCondition=array(),$rep_code='')
	{
		//$rep_code='REP00045';
		if($rep_code!=''){
			$sql="select p.*,u.firstname,u.lastname from fc_product p LEFT JOIN fc_users u on (u.id=p.user_id) where u.status='Active' and u.group='Seller' and u.rep_code=".'"'.$rep_code.'"'." group by p.id order by p.created desc";
			$productList = $this->ExecuteQuery($sql); 
			return $productList->num_rows();
		}else{
			$this->db->select($fieldName);
			$this->db->from($tableName);
			$this->db->where($whereCondition);
			
			//$this->db->where(JOB.".dateAdded >= DATE_SUB(NOW(),INTERVAL 30 DAY)", NULL, FALSE);
			$countQuery = $this->db->get();
			//echo $countQuery->num_rows();
			return $countQuery->num_rows();
		}
		
	}
	
	function getRecentDetails($tableName='',$fieldName='',$userOrderBy='',$userLimit='',$whereCondition=array())
	{
		$this->db->select('*');
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		$this->db->order_by($fieldName, $userOrderBy);
		$this->db->limit($userLimit);
		$countQuery = $this->db->get();
		return $countQuery->result_array();
	}
	
	function getTodayUsersCount($tableName='',$fieldName='',$whereCondition=array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		
		$this->db->where("created >= DATE_SUB(NOW(),INTERVAL 24 HOUR)", NULL, FALSE);
		//$this->db->like("created",date('Y-m-d', strtotime('-24 hours')));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}
	function getTodayPropertyCount($tableName='',$fieldName='',$whereCondition=array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		
		$this->db->where("created >= DATE_SUB(NOW(),INTERVAL 24 HOUR)", NULL, FALSE);
		//$this->db->like("created",date('Y-m-d', strtotime('-24 hours')));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}
	
	public function view_product_details($condition = ''){
		
		$this->db->cache_on();
		$select_qry = "select p.*,cit.name as city_name,cit.id as ci_it,u.firstname,u.lastname,u.image as user_image,u.feature_product,u.user_name,u.phone_no,u.email,u.address,u.address2,u.city as addr3,pa.latitude,pa.longitude,pb.datefrom as book_datefrom,pb.dateto as book_dateto,ph.product_image as PImg,p.featured from ".PRODUCT." p 
		LEFT JOIN ".PRODUCT_ADDRESS." pa on pa.product_id=p.id
		LEFT JOIN ".PRODUCT_BOOKING." pb on pb.product_id=p.id
		LEFT JOIN ".PRODUCT_PHOTOS." ph on p.id=ph.product_id
		LEFT JOIN ".CITY." cit on pa.city = cit.id  
		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		$productList = $this->ExecuteQuery($select_qry); 
		return $productList;
		
	}
	
	function getThisMonthCount($tableName='',$fieldName='',$whereCondition=array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		
		$this->db->where("created >= DATE_SUB(NOW(),INTERVAL 30 DAY)", NULL, FALSE);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}
	function getThisMonthPropertyCount($tableName='',$fieldName='',$whereCondition=array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		
		$this->db->where("created >= DATE_SUB(NOW(),INTERVAL 30 DAY)", NULL, FALSE);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}
	
	function getLastYearCount($tableName='',$fieldName='',$whereCondition=array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		//date("Y");
		$this->db->like('created', date("Y"));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
		
	}
	function getLastYearProertyCount($tableName='',$fieldName='',$whereCondition=array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		//date("Y");
		$this->db->like('created', date("Y"));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
		
	}
	
	function getDashboardOrderDetails()
	{
		$this->db->select('*,'.PAYMENT.'.id as orderId,'.PAYMENT.'.status as paymentStatus,'.PAYMENT.'.price as paymentPrice');
		$this->db->from(PAYMENT);
		$this->db->join(PRODUCT,PRODUCT.'.id='.PAYMENT.'.product_id','inner');
		$this->db->join('fc_rentalsenquiry','fc_payment.EnquiryId = fc_rentalsenquiry.id','LEFT');
		$this->db->order_by(PAYMENT.'.id','desc');
		$this->db->limit(3);
		$orderQueryDashboard = $this->db->get();
		return $orderQueryDashboard->result_array();
		//$this->db->where($whereCondition);
	}
	function get_sub($rep_id)
	{
		$this->db->select('*');
		$this->db->from(SUBADMIN);
		$this->db->where('id',$rep_id);
		return $query = $this->db->get_where();
	}
	function get_seller($rep_un_sellerid)
	{
		$this->db->select('*');
		$this->db->from(USERS);
		$this->db->where('rep_code',$rep_un_sellerid);
		return $query = $this->db->get_where();
	}
}