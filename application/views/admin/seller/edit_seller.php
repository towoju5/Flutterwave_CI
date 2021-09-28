<?php
$this->load->view('admin/templates/header.php');
//print_r($seller_details->row());
?>
<script type="text/javascript">
	
	function isNumber(evt) {
	    evt = (evt) ? evt : window.event;
	    var charCode = (evt.which) ? evt.which : evt.keyCode;
	    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    return true;
	}
</script>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Host</h6>
						<div id="widget_tab">
			              <ul>
			                <li><a href="#tab1" class="active_tab">Host Details</a></li>
			                <li><a href="#tab2">Bank Details</a></li>
							<li><a href="#tab3">Change Password</a></li>
							
							<li><a href="#tab4"  class="id_verify active_tab" id="id_verify">ID Verification</a></li>
							
			              </ul>
			            </div>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open('admin/seller/insertEditSeller',$attributes);
						
					?>
	 						<div id="tab1">
	 						<ul>
	 							<input type="hidden" name="rep_code" value="<?php echo $seller_details->row()->rep_code;?>" class="tipTop required" title="Enter the bank name" readonly/>
	 							
								<?php /*
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Rep Code<span class="req">*</span></label>
									<div class="form_input">
										<input type="text" name="rep_code" value="<?php echo $seller_details->row()->rep_code;?>" class="tipTop required" title="Enter the bank name" readonly style=" width:295px"/>
									</div>
								</div>
								</li>
								*/ ?>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Rep Code<span class="req">*</span></label>
									<div class="form_input">
									<?php if($_SESSION['fc_session_admin_rep_code']!='')
									{?>
										<input type="text" name="rep_code" value="<?php echo $_SESSION['fc_session_admin_rep_code']; ?>" class="tipTop required" title="Enter the Representative Code" style=" width:295px" readonly />
									<?php } else {?>
									<select name="rep_code">
									<option value="">Select Rep Code</option>
									<?php
									 foreach($this->data['query'] as $row_rep)
									{
										$prev_c=$seller_details->row()->rep_code;
										$l_rep_c=$row_rep->admin_rep_code;
										$selected='';
										if($prev_c==$l_rep_c){
											$selected='selected';
										}
										echo '<option value="'.$row_rep->admin_rep_code.'" '.$selected.'>'.$row_rep->admin_rep_code.'</option>';
									} 

									
									
									?>
									</select>
									<?php } ?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="full_name">First Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="firstname" style=" width:295px" id="full_name" value="<?php echo $seller_details->row()->firstname;?>" type="text" tabindex="1" class="required tipTop" title="Please enter the  firstname" />
										<label id="full_name_error" style="font-size:12px;display:none;" generated="true" class="error">Numbers are not allowed</label>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="full_name">Last Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="lastname" style=" width:295px" id="last_name" value="<?php echo $seller_details->row()->lastname;?>" type="text" tabindex="2" class="required tipTop" title="Please enter the  lastname" />
										<label id="last_name_error" style="font-size:12px;display:none;" generated="true" class="error">Numbers are not allowed</label>

									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="gender">I Am</label>
									<div class="form_input">
                                    <select name="gender" id="gender" class=" large tipTop" tabindex="3" title="Please select the gender">
									<option value="">--Select--</option>
                                    <option value="Male" <?php if($seller_details->row()->gender=='Male'){echo 'selected="selected"';}?>>Male</option>
                                    <option value="Female" <?php if($seller_details->row()->gender=='Female'){echo 'selected="selected"';}?>>Female</option>
                                    <option value="Unspecified" <?php if($seller_details->row()->gender=='Unspecified'){echo 'selected="selected"';}?>>Unspecified</option>
                                    </select>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="gender">Date of birth</label>
									<div class="form_input">
                                    <select name="dob_month" id="user_birthdate_2i" tabindex="4" class="valid">
									<option value="">--Select--</option>
                                        <option value="1" <?php if($seller_details->row()->dob_month=='1'){echo 'selected="selected"';}?> >January</option>
                                        <option value="2" <?php if($seller_details->row()->dob_month=='2'){echo 'selected="selected"';}?>>February</option>
                                        <option value="3" <?php if($seller_details->row()->dob_month=='3'){echo 'selected="selected"';}?>>March</option>
                                        <option value="4" <?php if($seller_details->row()->dob_month=='4'){echo 'selected="selected"';}?>>April</option>
                                        <option value="5" <?php if($seller_details->row()->dob_month=='5'){echo 'selected="selected"';}?>>May</option>
                                        <option value="6" <?php if($seller_details->row()->dob_month=='6'){echo 'selected="selected"';}?>>June</option>
                                        <option value="7" <?php if($seller_details->row()->dob_month=='7'){echo 'selected="selected"';}?>>July</option>
                                        <option value="8" <?php if($seller_details->row()->dob_month=='8'){echo 'selected="selected"';}?>>August</option>
                                        <option value="9" <?php if($seller_details->row()->dob_month=='9'){echo 'selected="selected"';}?>>September</option>
                                        <option value="10" <?php if($seller_details->row()->dob_month=='10'){echo 'selected="selected"';}?>>October</option>
                                        <option value="11" <?php if($seller_details->row()->dob_month=='11'){echo 'selected="selected"';}?>>November</option>
                                        <option value="12" <?php if($seller_details->row()->dob_month=='12'){echo 'selected="selected"';}?>>December</option>
                                        </select>
                                        
                                        
                                        <select name="dob_date" id="user_birthdate_3i">
										<option value="">--Select--</option>
                                        <?php
                                        for($i=1;$i<=31;$i++){
                                        
                                        echo '<option value="'.$i.'"'; 
                                        if($seller_details->row()->dob_date==$i){echo 'selected="selected"';}
                                        
                                        echo '>'.$i.'</option>';
                                        }
                                        
                                        
                                         ?>
                                        </select>
                                        
                                        <select name="dob_year" id="user_birthdate_1i" class="valid">
										<option value="">--Select--</option>
                                        <?php 
                                        for($i=2005;$i > 1920;$i--){
                                        
                                        echo '<option value="'.$i.'"'; 
                                        if($seller_details->row()->dob_year==$i){echo 'selected="selected"';}
                                        
                                        echo '>'.$i.'</option>';
                                        }
                                        ?>
                                        </select>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="phone_no">Phone no </label>
									<div class="form_input">
										<input type="text" style=" width:295px" name="phone_no" tabindex="5" id="phone_no" value="<?php  echo $seller_details->row()->phone_no; ?>" onkeypress="return isNumber(event)" />
										<label id="phone_no_error" style="font-size:12px;display:none;" generated="true" class="error"> Only Numbers are not allowed</label>
									</div>
								</div>
								</li> 
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="s_city">Where You Live</label>
									<div class="form_input">
										<input type="text" style=" width:295px" id="s_city" name="s_city" tabindex="6" value="<?php  echo $seller_details->row()->s_city; ?>" /> 
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Describe Yourself</label>
									<div class="form_input">
										<textarea name="description" tabindex="7" style="width:295px;"><?php  echo $seller_details->row()->description; ?></textarea>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="s_city">School</label>
									<div class="form_input">
										<input type="text" style=" width:295px" id="school" tabindex="8" name="school" value="<?php  echo $seller_details->row()->school; ?>" /> 
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="work">Work</label>
									<div class="form_input">
										<input type="text" style=" width:295px" tabindex="9" name="work" id="work" value="<?php  echo $seller_details->row()->work; ?>" /> 
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="email">Email Address  <span class="req">*</span></label>
									<div class="form_input">
									<input type="email" style=" width:295px" name="email" tabindex="10" value="<?php echo $seller_details->row()->email;?>" class="required tipTop" required title="Please enter Email ID"  readonly/>
										
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="image">User Image (Image Size 272px X 272px)</label>
									<div class="form_input">
										<input name="image" onchange="Upload();" id="image" type="file" tabindex="11" class="large tipTop" title="Please select user image"  /> <!--accept="image/*" -->
										<!--<?php print_r($seller_details->row()->image); ?>-->
										<label id="image_valid_error" style="font-size:12px;display:none;" class="error"> Height and Width must be below 272PX X 272PX.</label>
										<label id="image_type_error" style="font-size:12px;display:none;" class="error"> Please select a valid Image file</label>
									</div>
										<?php if($seller_details->row()->loginUserType =="google" && strpos($seller_details->row()->image, 'http') !== false){?>
									<div class="form_input"><img src="<?php if($seller_details->row()->image==''){ echo base_url().'images/site/profile.png';}else{ echo $seller_details->row()->image;}?>" width="100px"/></div>	
									<?php }elseif($seller_details->row()->image != '' && file_exists('images/users/'.$seller_details->row()->image)){?>
									<div class="form_input"><img src="<?php if($seller_details->row()->image==''){ echo base_url().'images/site/profile.png';}else{ echo base_url();?>images/users/<?php echo $seller_details->row()->image;}?>" width="100px"/></div>
									<?php }else{?>

											<img width="40px" height="40px" src="<?php echo base_url();?>images/users/user-thumb1.png" />
										<?php }?>
										
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="web_url">Website</label>
									<div class="form_input">
										<input type="url" name="web_url" value="<?php echo $seller_details->row()->web_url;?>" tabindex="12" class="tipTop large" title="Enter the website url" />
										<br><br><label class="">Example: http://www.domain.com </label>
									</div>
								</div>
								</li>
								<li>

								<div class="form_grid_12">

									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>

									<div class="form_input">

										<div class="active_inactive">

											<input type="checkbox" tabindex="13" name="status" <?php if ($user_details->row()->status == 'Active'){echo 'checked="checked"';}?> id="active_inactive_active" class="active_inactive"/>

										</div>

									</div>

								</div>
								</li>
                               <li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" ><span>Update</span></button>
									</div>
								</div>
								</li>
							</ul>
						</div>
						<div id="tab2">
							<ul>
								<li>
								<div class="form_grid_12">
								<label class="field_title" for="acc_name">Account Name <span class="req">*</span></label>
									
									<div class="form_input">
										<input type="text" name="accname" id="accname" value="<?php echo $seller_details->row()->accname;?>" class="tipTop large" title="Enter the bank account Name" required/>
										<label id="accname_error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>

									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="accno">Account Number<span class="req">*</span></label>
									<div class="form_input">
										<input type="text" name="accno" id="accno" value="<?php echo $seller_details->row()->accno;?>" class="tipTop large" title="Enter the bank account number" required/> 
										<label id="accno_error" style="font-size:12px;display:none;" class="error">Only Numbers are allowed</label>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Bank Name<span class="req">*</span></label>
									<div class="form_input">
										<input type="text" name="bankname" id="bankname" value="<?php echo $seller_details->row()->bankname;?>" class="tipTop large" title="Enter the bank name" required/>
										<label id="bankname_error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>

									</div>
								</div>
								</li>
								<!-- Update for client side new fields --->
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">SWIFT Code (Non-US Banks Only)</label>
									<div class="form_input">
										<input type="text" name="swift_code" id="swift_code" value="<?php echo $seller_details->row()->swift_code;?>" class="tipTop large" title="Enter the swift code" />
										<label id="bankname_error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>

									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">IBAN (Non-US Banks Only)</label>
									<div class="form_input">
										<input type="text" name="ibnb_code" id="ibnb_code" value="<?php echo $seller_details->row()->ibnb_code;?>" class="tipTop large" title="Enter the ibnb code" />
										<label id="bankname_error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>

									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Routing Code/Sort Code (Non-US Banks Only)</label>
									<div class="form_input">
										<input type="text" name="routing_code" id="routing_code" value="<?php echo $seller_details->row()->routing_code;?>" class="tipTop large" title="Enter Routing Code/Sort Code" />
										
									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Currency</label>
									<div class="form_input">
										<select name="currency_code_bank" id="currency_code_bank" >
			<?php if($active_currency->num_rows() >0){ foreach($active_currency->result() as $currency_s){?>             
  <option value="<?php echo $currency_s->currency_type; ?>" <?php if($currency_s->currency_type==$seller_details->row()->currency_code_bank) echo "selected"; ?>><?php echo $currency_s->currency_type; ?></option><?php } } ?>
				
			</select> 

									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Country</label>
									<div class="form_input">
									<select name="country_code_bank" id="country_code_bank" >
				<?php $active_countries=$active_countries->result();foreach($active_countries as $actcnt) { 
				echo '<option value="'.$actcnt->id.'" '.(($actcnt->id==$seller_details->row()->country_code_bank)?"selected":"").'>'.$actcnt->name.'</option>';
				} ?>
			</select> 
										

									</div>
								</div>
								</li>
								
								<!-- Update for client side new fields --->
								
								
								<li>

								<div class="form_grid_12">

									<label class="field_title" for="paypal_email">Paypal Email<span class="req">*</span></label>

									<div class="form_input">

										<input type="email" name="paypal_email" id="paypal_email" value="<?php echo $seller_details->row()->paypal_email;?>" class="tipTop large" title="Enter the Paypal Email" required/>

									</div>

								</div>

								</li>	
								
								<!----<li>
								<div class="form_grid_12">
									<label class="field_title" for="Acccountry">Account Country</label>
									<div class="form_input">
										 <select id="Acccountry" name="Acccountry">
											<option value="">Select</option>
											<option  value="<?php // echo $seller_details->row()->Acccountry;?>" <?php // if($seller_details->row()->Acccountry != ''){echo 'selected';}else{ echo 'style="display:none"';} ?>><?php //echo $seller_details->row()->Acccountry;?></option>
											
											<?php //foreach($active_countries->result() as $active_country) :?>
											<option value="<?php //echo $active_country->name;?>"><?php //echo $active_country->name;?></option>
											<?php //endforeach;?>
											</select>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="swiftcode">Swift Code</label>
									<div class="form_input">
										<input type="text" name="swiftcode" value="<?php echo $seller_details->row()->swiftcode;?>" class="tipTop large" title="Enter the Swiftcode" />
										
										
									</div>
								</div>
								</li>---->
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>
									</div>
								</div>
								</li>
							</ul>
						</div>
						<div id="tab3">
							<ul>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="password">Password</label>
									<div class="form_input">
										<input type="password" name="password" value="" class="tipTop large" id="admin-pass" title="Enter the Password" />
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="confirm-password">Confirm Password</label>
									<div class="form_input">
										<input type="password" name="confirm-password" value="" class="tipTop large" id="admin-cnfm-pass" title="Enter the Confirm Password" />
									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" onclick="return checkPassword();" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>
									</div>
								</div>
								</li>
							</ul>
						</div>
						
						<input type="hidden" name="seller_id" value="<?php echo $seller_details->row()->id;?>"/>
						<!--
						<input type="hidden" name="email" value="<?php echo $seller_details->row()->email;?>"/>
						-->
						</form>
						
						
											
		<!-- id verify-->
		<div id="tab4">
		<?php 
		
		$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
		echo form_open('admin/seller/update_host_id_proof/'.$user_idProof->row()->id,$attributes);

		
		?>	
		<ul>
		<?php // print_r($id_verify->result()); exit;  ?>
		<li>
		<div class="form_grid_12">
		<table border="1px" width="100%" >
		<tr>
		<th width="25%">S.No </th>
		<th width="25%"> Proof Type</th>
		<th width="25%">ID Proof</th>
		<th width="25%">Status</th>
		</tr>
		<?php
		
	
		
		
		$db_proof=$user_idProof->result();
		// print_r($db_proof);
		if ($db_proof=='')
		{
		?>
		<img src="<?php echo base_url();?>images/users/proof.png" style="width: 242px;"> 
		<?php
		//echo "iffff";
		}else{					
		?>
		<tr>
		<?php $i=1; 
		foreach($user_idProof->result() as $post) {
		$img_formats = array("jpg", "png", "gif","jpeg");	
				 
		$txt_formats = array("txt");
		$pdf_formats = array("pdf");
		$word_formats = array("doc", "docx");

		$file_ext = explode('.', $post->proof_file);

		// print_r($file_ext);exit;
		if(in_array($file_ext[1],$img_formats))	//check the file is image or not
		{
		?> 
		<td><?php echo $i;  ?> </td>
		
	
		
		<td><?php

$proof_title = '';
if($post->proof_type =='1')
$proof_title = "Passport";
elseif($post->proof_type =='2')
$proof_title = "Voter ID";
elseif($post->proof_type =='3')
$proof_title = "Driving Licence";


			echo $proof_title;  ?> </td>
		
		<td> <img src="<?php if($post->proof_file==''){ echo base_url().'server/php/id_proof/proof.png';}else{

		echo base_url();?>server/php/id_proof/<?php echo $post->proof_file;
		}?>" width="150px"  alt ="Proof"/>

		 </td>
		<td> <?php //echo $post->id_proof_status ?>
		
		<div class="verified_unverified">
		<input type="checkbox" name="status[<?php echo $post->id; ?>]" <?php if ($post->id_proof_status == 'Verified'){echo 'checked="checked"';}?> id="active_inactive_active" class="verified_unverified" 
		onchange="SaveProofStatus();" />
		
		<input type="hidden" name="id[]" value="<?php echo $post->id; ?>">
		</div>
		
		 <span id="showErr"></span>
		
		</td>




		<?php 								
		}
		else if (in_array($file_ext[1],$txt_formats))
		{?>


		<td><?php echo $i;  ?> </td>

		<td> 
		<a href="<?php if($post->proof_file==''){ echo base_url().'server/php/id_proof/txt_thumb.png';}else {

		echo base_url();?>server/php/id_proof/<?php echo $post->proof_file;
		}?>" target="_blank"><?php echo $post->proof_file; ?></a>
		</td>

		<td> 

		<div class="verified_unverified">

		<input type="checkbox" name="status[<?php echo $post->id; ?>]" <?php if ($post->id_proof_status == 'Verified'){echo 'checked="checked"';}?> id="active_inactive_active" class="verified_unverified" 
		onchange="SaveProofStatus();" />
		
		<input type="hidden" name="id[]" value="<?php echo $post->id; ?>">
		</div>
		
		 <span id="showErr"></span>
		</td>	



		<?php	
		}
		else if (in_array($file_ext[1],$pdf_formats))
		{?>
		<td><?php echo $i;  ?> </td>

		<td> 
		<a href="<?php if($post->proof_file==''){ echo base_url().'server/php/id_proof/pdf_thumb.png';}else {

		echo base_url();?>server/php/id_proof/<?php echo $post->proof_file;
		}?>" target="_blank"><?php echo $post->proof_file; ?></a>
		</td>

		<td> 

		<div class="verified_unverified">

		<input type="checkbox" name="status[<?php echo $post->id; ?>]" <?php if ($post->id_proof_status == 'Verified'){echo 'checked="checked"';}?> id="active_inactive_active" class="verified_unverified" 
		onchange="SaveProofStatus();" />
 <span id="showErr"></span>
		<input type="hidden" name="id[]" value="<?php echo $post->id; ?>">

		</div>	

 <span id="showErr"></span>		
		</td>



		<?php  }
		else if (in_array($file_ext[1],$word_formats))

		{
		?>
		<td><?php echo $i;  ?> </td>

		<td> 
		<a href="<?php if($post->proof_file==''){ echo base_url().'images/verify-images/word_thumb/word_thumb.jpg';}else {

		echo base_url();?>server/php/id_proof/<?php echo $post->proof_file;
		}?>" target="_blank"><?php echo $post->proof_file; ?></a>
		</td>

		<td> 

		<div class="verified_unverified">
		<input type="checkbox" name="status[<?php echo $post->id; ?>]" <?php if ($post->id_proof_status == 'Verified'){echo 'checked="checked"';}?> id="active_inactive_active" class="verified_unverified" 
		onchange="SaveProofStatus();" />
		 <span id="showErr"></span>
		<input type="hidden" name="id[]" value="<?php echo $post->id; ?>">
		</div>	

 <span id="showErr"></span>		
		</td> 

		<?php }
		?>  </tr><?php
		$i++;
		}

		}
		?>

		
		
<div class="form_grid_12" id="allowSubmit">
<label class="field_title" for="declineStatus">Allow Another Proof to Submit</label>
<div class="form_input">


		<div class="yes_no">
		<input type="checkbox" name="decline_status" <?php if ($post->decline_status == 'Yes'){echo 'checked="checked"';}?> id="yesNoCheck" class="yes_no" 
		 />
		 
		 <!-- id="active_inactive_active" -->
		 
		<input type="hidden" name="user_id" value="<?php echo $user_idProof->row()->user_id; ?>">
		</div>	
		
		

</div>
	<hr>
</div>

		<br><br><br>
		</table>
		</div>								
		</li>	
		<li>
		<div class="form_grid_12">
		<div class="form_input" style="text-align: right;">
		<input type="submit"  class="btn_small btn_blue nxtTab" id="formSub" name="submit" tabindex="9"  value="Submit"/>
		</div>
		</div>
		</li>
		</ul>
		</form>
		</div>

		<!--//id verify-->
						
						
						
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<script type="text/javascript">
function checkPassword()
{
	if($('#admin-pass').val().length < 6)
	{
		alert('Password should be 6 charecter and both same!');
		return false;
	}
	if($('#admin-pass').val() != $('#admin-cnfm-pass').val())
	{
		alert('Password should be same as above given password!');
		return false;
	}
	else return true;
}
</script>
<script>
$('#edituser_form').validate();
</script>

<?php 
$id_seg=$this->uri->segment(5);
if ($id_seg=="Id_verify"){
?>
<script>

 $("#host_id").removeClass("active_tab");
$("#id_verify").addClass("active_tab");
</script>

<?php } else if ($id_seg=="") { ?>

 <script>

$("#host_id").addClass("active_tab");
 $("#id_verify").removeClass("active_tab");

//  $("#allowSubmit").css("display","none");
  //$("#formSub").css("display","none"); 

 </script>
 <?php  } ?>
 
 
 <script>
    $(document).ready(function() {
        $('.yes_no').click(function() {
			
			

			if ($('#yesNoCheck').is(":checked"))
			{
			  $(".verified_unverified").css("display","none");
			  $("#showErr").html("UnVerified");
			}else{
				 $(".verified_unverified").css("display","block");
				  $("#showErr").html("");
			}

        });
    });
</script>
 
<script>
 $("#full_name").on('keyup', function(e) {
	 var numers = /[0-9]+$/;
     var val = $(this).val();
	   if(numers.test(val)){
	   document.getElementById("full_name_error").style.display = "inline";
	   $("#full_name").focus();
	   $("#full_name_error").fadeOut(5000);
       $(this).val(val.replace(/[0-9]+$/, ''));
   }
});

$("#last_name").on('keyup', function(e) {
    var numers = /[0-9]+$/;
    var val = $(this).val();
	   if(numers.test(val)){
	   document.getElementById("last_name_error").style.display = "inline";
	    $("#last_name").focus();
	   $("#last_name_error").fadeOut(5000);
        $(this).val(val.replace(/[0-9]+$/, ''));
   }
}); 

$("#phone_no").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^0-9\s]/g)) {
	   document.getElementById("phone_no_error").style.display = "inline";
	   $("#phone_no").focus();
	   $("#phone_no_error").fadeOut(5000);
       $(this).val(val.replace(/[^0-9\s]/g, ''));
   }
});


 $("#accno").on('keyup', function(e) {
    var val = $(this).val();
     if (val.match(/[^0-9-\s()]/g)) {
	   document.getElementById("accno_error").style.display = "inline";
	   $("#accno").focus();
	   $("#accno_error").fadeOut(5000);
       $(this).val(val.replace(/[^0-9-\s()]/g, ''));
   }
});

$("#accname").on('keyup', function(e) {
     var numers = /[0-9]+$/;
     var val = $(this).val();
	   if(numers.test(val)){
	   document.getElementById("accname_error").style.display = "inline";
	   $("#accname").focus();
	   $("#accname_error").fadeOut(5000);
       $(this).val(val.replace(/[0-9]+$/, ''));
   }
});

$("#bankname").on('keyup', function(e) {
    var numers = /[0-9]+$/;
     var val = $(this).val();
	   if(numers.test(val)){
	   document.getElementById("bankname_error").style.display = "inline";
	   $("#bankname").focus();
	   $("#bankname_error").fadeOut(5000);
        $(this).val(val.replace(/[0-9]+$/, ''));
   }
}); 
</script>


<script type="text/javascript">
function Upload() {
   
    var fileUpload = document.getElementById("image");
 
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
 
        if (typeof (fileUpload.files) != "undefined") {
            
            var reader = new FileReader();

            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
               
                var image = new Image();
                image.src = e.target.result;
                       
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if (height > 272 || width > 272) {
                       // alert("Height and Width must be 272PX X 272PX.");
						document.getElementById("image_valid_error").style.display = "inline";
						$("#image_valid_error").fadeOut(7000);
						$("#image").val('');
						$("#image").focus();
                        return false;
                    } 
                    return true;
                };
            }
        } else {
            alert("This browser does not support HTML5.");
			$("#image").val('');
            return false;
        }
    } else {
       // alert("Please select a valid Image file.");
		document.getElementById("image_type_error").style.display = "inline";
		$("#image_type_error").fadeOut(7000);
		$("#image").val('');
		$("#image").focus();
        return false;
    }
}
</script>


<?php 
$this->load->view('admin/templates/footer.php');
?>