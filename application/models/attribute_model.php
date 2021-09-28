<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to attribute management
 * @author Teamtweaks
 *
 */
class Attribute_model extends My_Model
{
	
	public function add_attribute($dataArr=''){
			$this->db->insert(ATTRIBUTE,$dataArr);
	}
	
	public function addlist_attribute($dataArr=''){
			$this->db->insert(LISTSPACE,$dataArr);
	}


	public function edit_attribute($dataArr='',$condition=''){
			$this->db->where($condition);
			$this->db->update(ATTRIBUTE,$dataArr);
	}
	
	public function edit_listattribute($dataArr='',$condition=''){
			$this->db->where($condition);
			$this->db->update(LISTSPACE,$dataArr);
	}
	
	
	public function view_attribute($condition=''){
			return $this->db->get_where(ATTRIBUTE,$condition);
			
	}
	
	public function view_listattribute($condition=''){
			return $this->db->get_where(LISTSPACE,$condition);
			
	}
	
	
	public function view_attribute_details(){
	
		$select_qry = "select * from ".ATTRIBUTE."";
		$attributeList = $this->ExecuteQuery($select_qry);
		return $attributeList;
			
	}
	
	public function view_listattribute_details(){
	
		$select_qry = "select * from ".LISTSPACE."";
		$attributeList = $this->ExecuteQuery($select_qry);
		return $attributeList;
			
	}
	
	
	
	public function get_list_values($lid='all'){
		if ($lid == 'all'){
			$where = '';
		}else {
			$where = 'and lv.list_id = '.$lid;
		}
		$Query = 'select lv.*,l.attribute_name from '.LIST_VALUES.' lv
					JOIN '.ATTRIBUTE.' l on l.id=lv.list_id where l.status = "Active" '.$where.' order by lv.id desc';
					//echo $Query; die;
		return $this->ExecuteQuery($Query);
	}
	
		public function get_listspace_values($lid='all'){
		if ($lid == 'all'){
			$where = 'order by lv.id desc';
		}else {
			$where = 'and lv.listspace_id = '.$lid;
		}
		$Query = 'select lv.*,l.attribute_name from '.LISTSPACE_VALUES.' lv
					JOIN '.LISTSPACE.' l on l.id=lv.listspace_id where lv.lang = "en" AND l.status = "Active" '.$where;
		//echo $Query; 
		return $this->ExecuteQuery($Query);
	}
	
	public function get_sub_list_values($lid='all'){
		if ($lid == 'all'){
			$where = '';
		}else {
			$where = 'and lv.list_id = '.$lid;
		}
		/*$Query = 'select lv.*,l.attribute_name from '.LIST_VALUES.' lv
					JOIN '.ATTRIBUTE.' l on l.id=lv.list_id where l.status = "Active" '.$where; */
					
				$Query='SELECT lsv.*,lv.list_value,a.attribute_name FROM '.LIST_SUB_VALUES.' lsv JOIN '.LIST_VALUES.' lv on  lv.id=lsv.list_value_id JOIN '.ATTRIBUTE.' a on a.id=lv.list_id where a.status = "Active" '.$where;	
		//echo $Query;die;
		return $this->ExecuteQuery($Query);
	}


	

	public function activeInactiveCommon_new($table='', $column=''){
		$data =  $_POST['checkbox_id'];
		for ($i=0;$i<count($data);$i++){  
			if($data[$i] == 'on'){
				unset($data[$i]);
			}
		}
		$mode  = $this->input->post('statusMode');
		$AdmEmail  = strtolower($this->input->post('SubAdminEmail'));
		/*$getAdminSettingsDetails = $this->getAdminSettings();
		$config = '<?php '; 
		foreach($getAdminSettingsDetails ->row() as $key => $val){
			$value = addslashes($val);
			$config .= "\n\$config['$key'] = '$value'; ";
		}
		$file = 'fc_admin_action_settings.php';
		file_put_contents($file, $config);
		vinu@teamtweaks.com
		*/
		
		
		$json_admin_action_value = file_get_contents('fc_admin_action_settings.php');
		if($json_admin_action_value !=''){
			$json_admin_action_result = unserialize($json_admin_action_value);
		}
			
		foreach ($json_admin_action_result as $valds) {
				$json_admin_action_result_Arr[] = $valds;
		}
		
		if(sizeof($json_admin_action_result)>29){
				unset($json_admin_action_result_Arr[1]);					
		}

		$json_admin_action_result_Arr[] = array($AdmEmail,$mode,$table,$data,date('Y-m-d H:i:s'),$_SERVER['REMOTE_ADDR']);
		
			
		$file = 'fc_admin_action_settings.php';
		file_put_contents($file, serialize($json_admin_action_result_Arr));
			
		
		$this->db->where_in($column,$data);
		if (strtolower($mode) == 'delete'){
			$this->db->delete($table);
			if($table==USERS)
			{
			$this->db->where_in('user_id',$data);
			$this->db->delete(PRODUCT);
			}
		}else {
			$statusArr = array('other' => $mode);
			$this->db->update($table,$statusArr);
					//echo $this->db->last_query(); die;
/* 			$statusArr = array('subscriber' => "Yes");
			$this->db->update($table,$statusArr); */
		}
		//echo $this->db->last_query(); die;
	}
	
}


?>