<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Landing page functions
 * @author Teamtweaks
 *
 */
class Landing_model extends My_Model
{
	public function __construct() 
	{
		parent::__construct();	
$this->load->model('user_model');		
	}
	function get_city_details($q){$this->db->cache_on();
	//$this->db->select('c.name,COUNT(p.id) as Rentals,states_list.name as 
		$this->db->select('c.name,states_list.name as State,country_list.country_code,country_list.name as country_name');
		$this->db->from(CITY.' as c');
		/* $this->db->join(PRODUCT_ADDRESS.' as pa',"pa.city=c.id","LEFT");
		$this->db->join(PRODUCT.' as p',"pa.product_id=p.id and p.status='Publish'","LEFT"); */
		$this->db->join(STATE_TAX.' as states_list',"states_list.id=c.stateid","LEFT");
		$this->db->join(COUNTRY_LIST.' as country_list',"country_list.id=states_list.countryid","LEFT");
		$this->db->where('country_list.status','Active');
		$this->db->like('states_list.name', $q);
		$this->db->or_like('c.name', $q);
		
		$this->db->limit(30);
		//$this->db->group_by('pa.city');
		$this->db->order_by('c.name',asc);
		$this->db->order_by('states_list.name',asc);
		
		$query = $this->db->get();
        //echo $this->db->last_query();  die;
		$autocomplete = $query->result_array();
		return $autocomplete; 
	}
	
	
	public function get_featured_lists()
	{$this->db->cache_on();
		$this->db->select("P.id,P.room_type,P.product_title, P.price,P.instantbook,P.description, P.accommodates, PP.product_image, PA.city, PA.state, PA.country,u.image,u.id as property_owner,(select IFNULL(count(R.id),0) from ".REVIEW." as R where R.product_id= P.id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from ".REVIEW." as Rw where Rw.product_id= P.id and Rw.status='Active') as avg_val",false);
		
		$this->db->from(PRODUCT.' as P');
		$this->db->join(PRODUCT_PHOTOS.' as PP' , 'P.id = PP.product_id');
		$this->db->join(PRODUCT_ADDRESS_NEW.' as PA' , 'P.id = PA.productId');
		$this->db->join(USERS.' as u',"u.id=P.user_id","LEFT");
		//$this->db->join(REVIEW.' as r',"r.product_id=P.id","LEFT");
		$this->db->where('P.status','Publish');
		$this->db->where('P.featured = "Featured"');
		$this->db->order_by("P.created", desc);
		$this->db->group_by("P.id"); 
		return $result = $this->db->get();
		//echo $this->db->last_query();die;
		/* $result = $this->db->get();
		echo '<pre>';print_r($result->result());die; */
	}
	public function facebook($data,$fb_id)
	{
		$email = $data['email'];
		$type= 'facebook';
		$this->db->where('email',$email);
        $query = $this->db->get('fc_users');
		
		
        if ($query->num_rows() > 0){
			$user_id = $query->row()->id;
			$this->session->set_userdata('session_user_email',$email);
			$this->session->set_userdata('fc_session_user_id',$user_id);
			$this->session->set_userdata('f_id',$fb_id);
			$this->session->set_userdata('facebook_in_login',$type);
			
			    //$profile_image = $data['image'];
			$condition = array('email' => $email);
			
			//$dataArr = array('f_id'=>$fb_id,'status'=>'Active','image'=>$profile_image,'expired_date'=>$expireddate,'is_verified'=>'Yes','facebook'=>'Yes','created'=>date('Y-m-d H:i:s'));
			
					$dataArr = array('f_id'=>$fb_id,'status'=>'Active','expired_date'=>$expireddate,'is_verified'=>'Yes','facebook'=>'Yes');
				    $this->user_model->update_details(USERS,$dataArr,$condition);
		
		return true;
        }
	
        else{
			$this->db->insert('fc_users', $data);
			//$this->db->where('f_id',$fb_id);
			//$table1_id = $this->db->insert_id();
			//print_r($table1_id = $this->db->insert_id());
            $qry = $this->db->get('fc_users');
			if ($qry->num_rows() > 0){
			//$user_id = 172;
			$this->session->set_userdata('session_user_email',$email);
			$this->session->set_userdata('fc_session_user_id',$table1_id = $this->db->insert_id());
			$this->session->set_userdata('f_id',$fb_id);
			$this->session->set_userdata('facebook_in_login',$type);
			//$this->db->where('f_id',$fb_id);
			
        return false;
			}
        }
	}
	public static function facebook_login_check($fb_id,$data)
	{

		if($fb_id!='')
		{
		$data1 = $this->db->select('fc_users')->where('f_id', $fb_id)->get();
		
		if($data)
		{
		
			$this->session->set_userdata('email',$data[0]->email);
			$this->session->set_userdata('id',$data[0]->id);
			$this->session->set_userdata('f_id',$data[0]->f_id);
			return "success";
		}
		
		}
		else
		{
			return "error";
		}
	}
	
	public function get_social_media()
	{
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from(ADMIN_SETTINGS);
        return $result = $this->db->get();		
		
	}
	public function get_exprience_view_details_withFilter($condition='')
	{
		
		$this->db->cache_on();
		
		$select_qry = "select p.*,extyp.experience_title as type_title,d.from_date,u.image as user_image,rp.product_image as product_image,expAdd.city,(select IFNULL(count(R.id),0) from ".EXPERIENCE_REVIEW." as R where R.product_id= p.experience_id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from ".EXPERIENCE_REVIEW." as Rw where Rw.product_id= p.experience_id and Rw.status='Active') as avg_val from ".EXPERIENCE." p  
		LEFT JOIN ".EXPERIENCE_TYPE." extyp on extyp.id=p.type_id
		LEFT JOIN ".EXPERIENCE_ADDR." expAdd on expAdd.experience_id=p.experience_id 
		LEFT JOIN ".EXPERIENCE_PHOTOS." rp on rp.product_id=p.experience_id
		LEFT JOIN ".EXPERIENCE_DATES." d on d.experience_id=p.experience_id
		LEFT JOIN ".EXPERIENCE_TIMING." dt on dt.exp_dates_id=d.id 

		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		//echo $select_qry;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
		
	}
	
	/**Preetha - Start - for Remember me option get password**/
	public function get_password($email=''){
		if ($email!=''){
			$this->db->select('confirm_password');
			$this->db->from(USERS);
			$this->db->where('email',$email);
			$result=$this->db->get();
			return $result;	
		}		
	}
	/**Preetha - End - for Remember me option get password**/
	
}