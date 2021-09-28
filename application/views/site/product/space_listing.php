<?php 
$this->load->view('site/templates/header');
$this->load->view('site/templates/listing_head_side');
 
//echo "<pre>"; print_r($listspace->result() );die;

foreach ($listValues->result() as $result){
	if($_SESSION['language_code']=="ar")
	{
	 $values = $result->listing_values_arabic;
	}
 else
 {
	 $values = $result->listing_values;
 }

 }
	$roombedVal=json_decode($values);
	
	$product_list_decode = json_decode($listDetail->row()->listings);
	foreach($product_list_decode as $product_list_name => $product_list_values)
	{
	 $product_list_data[$product_list_name] = $product_list_values;
	}
		
?>


<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addProperty.js"></script>
         
            <div class="right_side">
			
			<div class="dashboard_price_main space-price-list spc_lst_div" style="border-bottom:none !important;">
            
              <div class="dashboard_price spc_lst_div">
            
                    <div class="dashboard_price_left">
                    
                      <h3><?php if($this->lang->line('ListingInfo') != '') { echo stripslashes($this->lang->line('ListingInfo')); } else echo "Listing Info"; ?></h3>
                        
                        <p><?php if($this->lang->line('Basicinformationabout') != '') { echo stripslashes($this->lang->line('"Basicinformationabout')); } else echo "Basic information about your listing."; ?></p>
                    
                    </div>
					
					<?php 
					
					$listvalue = $this->product_model->get_all_details(LISTSPACE_VALUES,array('listspace_id'=>9));
					//echo '<pre>'; print_r($listDetail->result_array());
					//die ?>
					<!--action="<?php //echo base_url()."address_listing/".$listDetail->row()->id;?>" -->
                   <form name="space_listing" method="post"  accept-charset="UTF-8" id="listForm" >
                    <div class="dashboard_price_right spc_lst_div">
                    <?php
					$pcount=0;
					foreach($listspace->result() as $value){
					  $id=$value->id;

					   	$sql = "SELECT * FROM fc_listspace_values WHERE other='Yes' and listspace_id = ".$id;
						$inner = $this->db->query($sql);
						
						
						if($inner->num_rows() > 0)
						{
							if($_SESSION['language_code']=="ar")
							{
								$value->attribute_name = $value->attribute_name_arabic;
							}
							else
							{
								$value->attribute_name = $value->attribute_name;
							}
					 ?>
                      	<div class="dashboard_apart width100">
                        
                          <label style="text-transform:capitalize;"><?php echo $value->attribute_name; ?> <span class="req">*</span></label>
                            <div class="select">
							<select  name="home_type"  required onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'<?php if($value->attribute_seourl == 'propertytype')echo 'home_type';else if($value->attribute_seourl == 'roomtype') echo 'room_type';?>');">
							<option value=""><?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?></option>
							<?php
                           
							foreach($inner->result() as $listvalues)
						 {
							 if($_SESSION['language_code']=="ar")
                        {
							$listvalues->list_value = $listvalues->list_value_arabic;
						}
						else
						{
							$listvalues->list_value = $listvalues->list_value;
						}
						 if($pcount == 0){
						 ?>  
							  <option value="<?php echo $listvalues->id; ?>" <?php if(trim($listvalues->id) == trim($listDetail->row()->home_type)) echo 'selected="selected"'; ?> ><?php echo ucfirst($listvalues->list_value); ?></option>
							  <?php }else{  ?>
							   <option value="<?php echo $listvalues->id; ?>" <?php if(trim($listvalues->id) == trim($listDetail->row()->room_type)) echo 'selected="selected"'; ?> ><?php echo ucfirst($listvalues->list_value); ?></option>
                                 
						<?php
						
						}
						} ?>
						 </select>
                            </div>
                        </div>
						
						<?php 
						}
						$pcount++;
						}
						?>
						
						
						<?php 						
						foreach ($roombedVal as $key => $values){ 			
						$listing_keys[$key] = $key;
						$listing_values[$key] = $values;
						}
						//print_r($listTypeValues->result());
						foreach ($listTypeValues->result() as $keys => $finals)
									{

						if($_SESSION['language_code']=="ar")
                        {
							 $name = $finals->name_arabic; 
						}
						else
						{
							$name = $finals->name; 
							$name_id = $finals->id;  //show textBox value
						}
						$field_id =  $finals->id;
						 $selected = $product_list_values;
	
						//if($name != 'accommodates' && $name != 'can_policy'){		 
						if($name != 'can_policy'){		 
						 
						$list_type = $finals->type;
							
							
						$getChildValues=$this->product_model->get_all_details(LISTING_CHILD,array('parent_id'=>$field_id)); 
						
						
						if ($list_type=='option'){			 
						?>
							<div class="dashboard_apart width100" style="<?php if ($getChildValues->num_rows() > 0) { echo "display:block"; } else { echo "display:none"; }?>">
						<?php } else { ?>
							<div class="dashboard_apart width100">
						<?php } ?>
			
                        	<label style="text-transform:capitalize;"><?php
						//*Preetha - Start - display if childvalues exist 
							if ($list_type=='option'){
								if ($getChildValues->num_rows() > 0 ){									
									//echo  str_replace('_',' ',$finals->name); 
									echo  str_replace('_',' ',$finals->labelname); 
								}														
							}else{
									//echo str_replace('_',' ',$finals->name);
									echo str_replace('_',' ',$finals->labelname);
							}		
						//*Preetha - End - display if childvalues exist 
						
							if( $finals->name =='minimum_stay') { echo  ' <span style="color:red">*'; } ?></label>
							<?php //echo print_r($name); ?>
                            
                            <div class="select">
                         <?php    
                         $product_list_decode = json_decode($listDetail->row()->listings);
                        foreach($product_list_decode as $product_list_name => $product_list_values)
						{
							
						 $product_list_data[$product_list_name] = $product_list_values;
						//echo "id";	 print_r($product_list_name);
						//echo "val";	 print_r($product_list_values);
						//print_r($product_list_name);

						  }
				   		
                         if($list_type == 'option' ) { 

							if ($getChildValues->num_rows() > 0 ){		


                         	?>
                   <!-- name="select_option"-->
                            	<!--<select class="select_option"   name="<?php //echo $finals->name; ?>"  onchange="javascript:Detaillist(this,<?php//echo $listDetail->row()->id; ?>,'<?php //echo $finals->name; ?>');"  <?php //if(($finals->name=='minimum_stay' )||( $finals->name=='guest_capacity') ) echo 'required';?>   >it saves in name-->
								
								 <!-- saves as id=>id -->
								<select class="select_option"   name="<?php echo $finals->name; ?>"  onchange="javascript:Detaillist(this,<?php echo $listDetail->row()->id; ?>,'<?php echo $finals->id; ?>');">
								 <!-- saves as id=>id -->
								 
								
                            		 <?php 
									/*  if($finals->name=='minimum_stay' )
										 echo '';
									 else  */
										 echo '<option value="">';
									 ?> <?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?></option>
                            	<?php 
                            	  foreach($product_list_decode as $product_list_name => $product_list_values)
									{
										
									 $product_list_data[$product_list_name] = $product_list_values;
								
									 //echo $selected = $product_list_values;

									  } 

							   foreach($listchildValues->result() as $val){ 


							   	//$my_id = $val->id;
							   	if($field_id == $val->parent_id){
                            	?>
    
								    <option value="<?php echo $val->id; ?>"  <?php if (in_array($val->id, $product_list_data)) {  echo 'selected="selected"'; }   ?> ><?php if($_SESSION['language_code']=="ar")
                        { echo $val->child_name_arabic; } else{ echo $val->child_name; } ?></option>
								<?php } } ?>                                       
                                  </select>
                            <?php } } else { //echo $listing_values[$name];
							?>
                            
							 <!--<input type="text"  value="<?php //echo  $product_list_data[$name]; ?>" class="select_option" onchange="javascript:Detaillist(this,<?php// echo $listDetail->row()->id; ?>,'<?php //echo $finals->name; ?>');">it saves in name-->
							 
							 <!-- saves as id=>id -->
							 
							 
							 <?php //if($field_id == $product_list_name){ ?>
							 
							 <input type="text"  value="<?php echo  $product_list_data[$name_id]; ?>" class="select_option" onchange="javascript:Detaillist(this,<?php echo $listDetail->row()->id; ?>,'<?php echo $finals->id; ?>');">
							 
							<?php // } ?>
							 
							 
							  <!-- saves as id=>id -->
							 
							<?php }
							 ?>
                            </div>
                            </div>
							<?php }  }   ?>
                        
                         	
						<!-- <div class="dashboard_apart width100"> -->
						
						<?php 						
						// foreach ($roombedVal as $key => $values){ 			
						// $listing_keys[$key] = $key;
						// $listing_values[$key] = $values;
						// }
	 
						// foreach ($listTypeValues->result() as $keys => $finals)
						// 			{
						// 	if($_SESSION['language_code']=="ar")
      //                   {
						// 	 $name = $finals->name_arabic; 
						// }
						// else
						// {
						// 	$name = $finals->name; 
						// }
						// 	 //echo $name;
						// //print_r($listDetail->row());
						// if($name != 'accommodates' && $name != 'can_policy'){
									 
						// 			  $list_type = $finals->type;
									 
									  ?>
                        
                        	<!-- <label style="text-transform:capitalize;"><?php echo str_replace('_',' ',$name); ?></label> -->
							<?php //echo print_r($name); ?>
                            
                            <!-- <div class="select"> -->
                         <?php    //if($list_type == 'option' ) { ?>
                   
<!--                             	<select class="select_option" name="select_option" onchange="javascript:Detaillist(this,<?php echo $listDetail->row()->id; ?>,'<?php echo $name; ?>');">
    
                                      <option value=""><?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?></option>
									  
                                      <?php 
									  //print_r($valuesArr);
							$valuesArr=@explode(',',$listing_values[$name]);
									  foreach($valuesArr as $value){
									  
										
										?>
										<option value="<?php echo $value; ?>" <?php   if($product_list_data[$name] == $value){ echo 'selected="selected"'; }  ?> >
											<?php echo ucfirst($value); ?>
										</option>
										
									  <?php } ?>
                                      
                                  </select> -->
                            <?php //} else //{ //echo $listing_values[$name]; ?>
                            
							<!--  <input type="text" value="<?php echo  $product_list_data[$name]; ?>" class="select_option" onchange="javascript:Detaillist(this,<?php echo $listDetail->row()->id; ?>,'<?php echo $name; ?>');"> -->
							<?php //} ?>
                            <!-- </div> -->
							<?php //}    } ?>
                        
                       <!--  </div>  -->
						
                    
                    </div>
                
                </div>
            
            </div>
			
			<!---- -->
            
            
            
            <div class="dashboard_price_main spacelist-savebtn spc_div_main">
            
            	<div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                    <!--	<h3><?php
						// if($this->lang->line('RoomsandBeds') != '') { echo stripslashes($this->lang->line('RoomsandBeds')); } else echo "Rooms and Beds"; ?></h3>
                        
                        <p><?php //if($this->lang->line('Thenumberof') != '') { echo stripslashes($this->lang->line('Thenumberof')); } else echo "The number of rooms and beds guests can access."; ?> </p>
                    -->
                    </div>
                    
                    <div class="dashboard_price_right no_padding_bttm_spc">
					
                    	<!--<div class="dashboard_apart width100">
						
						<?php // echo '<pre>';print_r($product_list_data);die;
						
						
						  foreach ($roombedVal as $key => $values){ 			
						$listing_keys[$key] = $key;
						$listing_values[$key] = $values;
						}
				//	print_r($listing_values);
						 
						foreach ($listTypeValues->result() as $keys => $finals)
									{
							
							 $name = $finals->name; 
						if($name != 'accommodates' && $name != 'can_policy'){
									 
									  $list_type = $finals->type;
									 
									  ?>
                        
                        	<label style="text-transform:capitalize;"><?php echo $name; ?></label>
                            
                            <div class="select">
                         <?php    if($list_type == 'option' ) { ?>
                            	<select class="select_option" name="select_option" onchange="javascript:Detaillist(this,<?php echo $listDetail->row()->id; ?>,'<?php echo $name; ?>');">
    
                                      <option value="">Select</option>
									  
                                      <?php $valuesArr=@explode(',',$listing_values[$name]);
									  foreach($valuesArr as $value){
									  
										
										?>
										<option value="<?php echo $value; ?>" <?php   if($product_list_data[$name] == $value){ echo 'selected="selected"'; }  ?> >
											<?php echo $value; ?>
										</option>
										
									  <?php } ?>
                                      
                                  </select>
                            <?php } else { //echo $listing_values[$name]; ?>
                            
							 <input type="text" value="<?php echo  $product_list_data[$name]; ?>" class="select_option" onchange="javascript:Detaillist(this,<?php echo $listDetail->row()->id; ?>,'<?php echo $name;?>');">
							<?php } ?>
                            </div>
							<?php }    } ?>
                        
                        </div>  -->
						
						
                        
                        <input type="hidden" name="id" value="<?php echo $listDetail->row()->id;?>" />
                        </div>
                     <div class="row">
                      <div class="col-sm-3"></div>
                       <div class="col-sm-3"></div>
                     <div class="col-sm-3 spc_nxt_btn">
                     	<button class="next_button" onclick="checkMinimumStay();" type="button"><?php if($this->lang->line('Next') != '') { echo stripslashes($this->lang->line('Next')); } else echo "Next";?></button>
                     </div>                    	
                     </div>
                    </div>
                   
                </form>
                </div>


            
            
          <!--   <p class="price_text_links">If you wish, you can permanently <a href="javascript:void(0);" onclick="return DeleteListYoutProperty('<?php echo $listDetail->row()->id; ?>');">delete this listing.</a></p> -->
            
            </div>
			
			
			
			<div class="calender_comments">
            
            	<div class="calender_comment_content">
                <div class="left-calender_comment">
                	<i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
                    </div>
					<div class="right-calender_comment">
                    <div class="calender_comment_text">
                    
                    	<h2><?php if($this->lang->line('your_location') != '') { echo stripslashes($this->lang->line('your_location')); } else echo "Your Location";?></h2>
                    
                    	<p><?php if($this->lang->line('test') != '') { echo stripslashes($this->lang->line('test')); } else echo "test";?></p>
                        <!--
                        <p><strong>It will only be shared with guests after a reservation is confirmed.</strong></p>
                        -->
                    
                    </div></div>
                    
                    
                
                </div>
            
            </div>
			
            
        </div>
        
    </div>
<script type="text/javascript">
function DeleteListYoutProperty(val){
	//$('#delete_profile_image').disable();
	var res = window.confirm('<?php if($this->lang->line('Are you sure') != '') { echo stripslashes($this->lang->line('Are you sure')); } else echo "Are you sure";?>?');
	if(res){
		window.location.href = 'site/product/delete_property_details/'+val;
	}else{
		//$('#delete_profile_image').removeAttr('disabled');
		return false;
	}
}
</script> 

 <script type="text/javascript">
function checkMinimumStay(){
var minimum_stayVal = $('#listForm').find('select[name="minimum_stay"]').val();
var homeType = $('#listForm').find('select[name="home_type"]').val();

if (minimum_stayVal==""){
	alert("Please Fill All Mandatory Fields");
	return false;
}else if (homeType==""){
	alert("Please Fill All Mandatory Fields");
}else{
	window.location.href="<?php echo base_url()."address_listing/".$listDetail->row()->id;?>"
}	
}
</script>
<!---DASHBOARD-->
<?php
$this->load->view('site/templates/footer');
?>