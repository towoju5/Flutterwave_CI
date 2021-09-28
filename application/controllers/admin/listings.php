<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to listings management 
 * @author Teamtweaks
 *
 */

class Listings extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('listings_model');
		if ($this->checkPrivileges('Listing',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
	
	/*
	*Load contens for rooms and beds for listings
	*
	*/
	public function rooms_and_beds() {
		//$condition=array('id'=>1);
		$this->data['listDetail'] = $this->listings_model->get_all_data(LISTING_TYPES);	
		$this->data['listvalues'] = $this->listings_model->get_all_values(LISTING);
				foreach($this->data['listvalues'] as $result)
					{
						$data = $result->listing_values;	
					}
					$this->data['finalVal'] = json_decode($data);
					//var_dump($this->data);die;
								
		$this->load->view('admin/listings/rooms_and_beds',$this->data);
	}
	
	/*
	*Load contens for listings informations for listings
	*
	*/
	public function listings_info() {
		$condition=array('id'=>1);
		$this->data['listDetail'] = $this->listings_model->get_all_details(LISTINGS,$condition);	
		$this->load->view('admin/listings/listings_info',$this->data);
	}
	
	public function add_new_attribute()
	{
	if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$id=$this->uri->segment(4,0);
			
			if($id != ''){
			$this->data['heading'] = 'Edit Listing Type';
			$this->data['details'] = $this->listings_model->get_all_details(LISTING_TYPES, array('id'=>$id));
			
			
/* echo "<pre>";	print_r($data->result()); */
			}
			else
			$this->data['heading'] = 'Add New Listing Type';
			
			$this->load->view('admin/listings/add_new_attribute',$this->data);
		}
	
	}

	/*
	*Save rooms and beds for listings
	*
	*/
	 public function insertlistings_roomsandbed() {		

		$condition=array('id'=>1);
		if($this->input->post())
		{
		 
		$postValues = $this->input->post();
		// print_r($postValues);
		// exit();

		foreach($postValues as $seperate_key => $seperate_value){
				// $key_id = substr($seperate_key, 0,2);
				// echo $key_id;
				$newArr[$seperate_key] = $seperate_value;
				
		}
		print_r($newArr);
		exit();
		foreach($newArr as $newkey => $newval){
			$secondArr[$newval] = $newkey;
		}

		foreach ($secondArr as $key => $value) {

			$key_ex = explode(',',$key);
			// echo '<pre>';
			// print_r($key_ex);
			// echo '</pre>';
			foreach($key_ex as $now_key => $key_val){
				//$get_parent_id = $this->db->where()
				$insertdata = array('parent_id' => $value,'child_name' => $key_val);

				$this->db->insert('fc_listing_child',$insertdata);
			}
			
		}
		
		exit();
		
		
		foreach($postValues as $listName => $lsitValues ){
		
			$dataArr[$listName]= $lsitValues;
		}
			$finalVal=json_encode($dataArr);
			
			
		}
	  
		$listvalues = $this->listings_model->get_all_details(LISTINGS,$condition);	
		$listArr=array('listing_values'=>$finalVal);
               
		//$this->listings_model->update_details(LISTINGS,$listArr,$condition);
		if($listvalues->num_rows()==1){
			$this->listings_model->update_details(LISTINGS,$listArr,$condition);
		}else{
			$this->listings_model->simple_insert(LISTINGS,$listArr);
		} 
		
		redirect('admin/listings/rooms_and_beds');
	} 
	
 public function insert_attribute()
{ 
		$id=$this->input->post('id');
		//echo $id;die;
		
		$attribute_name = str_replace(' ','_',$this->input->post('attribute_name'));
		$type = $this->input->post('type');
		$label_name = $this->input->post('label_name');
		$status = $this->input->post('status');

		if($status == 'on' || $status == 'off')
		{
		$status_value ="Active"; 
		}
		if($id !== '')
		{
			$condition = array();
			$condition['id']=$id;
			if($attribute_name!='')$condition['name']=$attribute_name;
			if($type!='')$condition['type']=$type;
			$condition['labelname']=$label_name;
			//echo '<pre>';print_r($condition);die;
			$this->listings_model->simple_updates($condition,$id);

			redirect('admin/listings/attribute_values');
		
		}
		else
		{ 
			$exist_attribute = 0;
			$condition = array('name'=>$attribute_name,'status'=>$status_value,'type'=>$type,'labelname'=>$label_name);
			$listing_values = $this->listings_model->get_all_details(LISTINGS,array('id'=>'1'));
			
			$listingEncodeValue = $listing_values->row()->listing_values;
			$listingDecodeValue = json_decode($listingEncodeValue);
			foreach($listingDecodeValue as $listName => $lsitValues ){
			
				$dataArr[$listName]= $lsitValues;
				if($listName == $attribute_name){
					$exist_attribute += 1;
				}
			}
			if($exist_attribute==0){
				$dataArr[$attribute_name] = '';
					$finalVal=json_encode($dataArr);
				$this->listings_model->update_details(LISTINGS,array('listing_values'=>$finalVal),array('id'=>'1'));
				$this->listings_model->simple_insert(LISTING_TYPES,$condition);
			}else{
				$this->setErrorMessage('error','List type name already exist');
			}
			redirect('admin/listings/attribute_values');
		}
}

public function attribute_values()
{
		$this->data['heading'] = 'Listing Types';
		$this->data['listingvalues'] = $this->listings_model->get_all_data();	
		$this->load->view('admin/listings/listing_types',$this->data);

}
public function delete_list($id='')
{ 
		$id = $this->uri->segment(4,0);
		$listingValues = $this->listings_model->get_all_datas($id);
		foreach($listingValues as $result)	  
		{
		 $data = $result->name;
		}
		$listing_values = $this->listings_model->get_all_details(LISTINGS,array('id'=>'1'));
	foreach($listing_values->result() as $list)	  
		
		{
		 //echo $list->listing_values;
		 $restult_listing = $list->listing_values;
		 //echo $data;
		}
		$result_decode = json_decode($restult_listing);
		foreach($result_decode as $listName => $keyValues){
		
		if($data != $listName){
		//echo $listName;
		$finla_listing[$listName] = $keyValues;
		}
		
		}
		
		$this->listings_model->update_details(LISTINGS,array('listing_values'=>json_encode($finla_listing)),array('id'=>'1'));
		$this->listings_model->delete_listing($id);
		redirect('admin/listings/attribute_values');

	}
	
	public function change_list_types_status_global(){
	
		if(count($this->input->post('checkbox_id')) > 0 &&  $this->input->post('statusMode') != ''){
			$this->listings_model->activeInactiveCommon(LISTING_TYPES,'id');
			//echo $this->db->last_query();exit;
			if (strtolower($this->input->post('statusMode')) == 'delete'){
				$this->setErrorMessage('success','List types deleted successfully');
			}
			redirect('admin/listings/attribute_values');
		}
	}

	public function change_listings_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$attribute_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Inactive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $attribute_id);
			$this->listings_model->update_details(LISTING_TYPES,$newdata,$condition);
			$this->setErrorMessage('success','Listings Status Changed Successfully');
			redirect('admin/listings/attribute_values');
		}
	}

	public function listing_child_values(){
		$this->data['heading'] = 'Listing Child Values';
		$this->data['listingvalues'] = $this->listings_model->get_all_data();	
		$this->load->view('admin/listings/listing_child_values',$this->data);
	}
	
	public function view_listing_child_values(){
		$this->data['heading'] = 'View Listing Child Values';
		$parent_id = $this->uri->segment(4);
		$this->data['listchildvalues'] = $this->db->select('lc.*,lc.id as child_id,lt.*')->from('fc_listing_child as lc')->join('fc_listing_types as lt','lt.id = lc.parent_id')->where('parent_id',$parent_id)->order_by('child_id', "asc")->get();	
		$this->load->view('admin/listings/view_listing_child_values',$this->data);
	}
	

	public function add_new_child_fields(){
		$this->data['heading'] = 'Add Child Values';
		$parent_id = $this->uri->segment(4);
		$this->data['listchildvalues'] = $this->db->select('lc.*,lc.id as child_id,lt.*')->from('fc_listing_child as lc')->join('fc_listing_types as lt','lt.id = lc.parent_id')->where('parent_id',$parent_id)->order_by('child_id', "asc")->get();	
		$this->load->view('admin/listings/add_new_child_fields',$this->data);

	}

	public function add_submit_new_child_fields(){
		$parent_id = $this->input->post('parent_id');
		$child_value = $this->input->post('child_value');
		//$child_value_arabic = $this->input->post('child_value_arabic');

		$insert_data= array(
			'parent_id' =>$parent_id,
			'child_name' =>$child_value
			//'child_name_arabic' =>$child_value_arabic
			);

		$this->db->insert('fc_listing_child',$insert_data);
		redirect('admin/listings/add_new_child_fields/'.$parent_id);
	}

	public function delete_child_list_value(){
		//exit();
		$id = $this->uri->segment(4);
		$parent_id = $this->uri->segment(5);
		$this->db->where('id',$id)->delete('fc_listing_child');
		redirect('admin/listings/add_new_child_fields/'.$parent_id);

	}

	public function update_child_data(){
		$child_id = $this->input->post('child_id');
		$child_name = $this->input->post('child_name');
		$child_name_arabic = $this->input->post('child_name_arabic');

		$update_data= array(
			'child_name' =>$child_name,
			'child_name_arabic' =>$child_name_arabic
			);

		$this->db->where('id',$child_id)->update('fc_listing_child',$update_data);

	}
   
}



/* End of file listings.php */
/* Location: ./application/controllers/admin/listings.php */