<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Guest</h6>
						<div id="widget_tab">
			              <ul>
			                <li><a href="#tab1" class="active_tab">User Details</a></li>
			                <li><a href="#tab2">Change Password</a></li>
							
							<!-- <li><a href="#tab3" class="id_verify active_tab" id="id_verify">ID Verification</a></li> -->
							
			              </ul>
			            </div>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/users/insertEditUser',$attributes) 
					?>
						<div id="tab1">
	 						<ul>
	 							<!--<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_name">User Name </label>
									<div class="form_input">
										<?php echo $user_details->row()->user_name;?>
									</div>
								</div>
								</li>-->
								
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="full_name">First Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="firstname" required style="width:295px" maxlength="50" id="full_name" value="<?php echo $user_details->row()->firstname;?>" type="text" tabindex="1" class="required tipTop" title="Please enter the user First Name"/> <label id="full_name_error_len" class="error" style="font-size:12px;display:none;">Max 50 Characters Allowed</label> <label id="first_name_error_num" class="error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="full_name">Last Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="lastname" required style=" width:295px" maxlength="50" id="last_name" value="<?php echo $user_details->row()->lastname;?>" type="text" tabindex="2" class="required tipTop" title="Please enter the user Last Name"/> <label id="last_name_error_len" class="error" style="font-size:12px;display:none;">Max 50 Characters Allowed</label> <label id="last_name_error_num" class="error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="gender">I Am</label>
									<div class="form_input">
                                    <select name="gender" id="gender" class=" large tipTop"  title="Please select the gender">
									<option value="">--Select--</option>
                                    <option value="Male" <?php if($user_details->row()->gender=='Male'){echo 'selected="selected"';}?>>Male</option>
                                    <option value="Female" <?php if($user_details->row()->gender=='Female'){echo 'selected="selected"';}?>>Female</option>
                                    <option value="Unspecified" <?php if($user_details->row()->gender=='Unspecified'){echo 'selected="selected"';}?>>Unspecified</option>
                                    </select>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="gender">Date of birth</label>
									<div class="form_input">
                                    <select name="dob_month" id="user_birthdate_2i" class="valid">
										<option value="">--Select--</option>
                                        <option value="1" <?php if($user_details->row()->dob_month=='1'){echo 'selected="selected"';}?> >January</option>
                                        <option value="2" <?php if($user_details->row()->dob_month=='2'){echo 'selected="selected"';}?>>February</option>
                                        <option value="3" <?php if($user_details->row()->dob_month=='3'){echo 'selected="selected"';}?>>March</option>
                                        <option value="4" <?php if($user_details->row()->dob_month=='4'){echo 'selected="selected"';}?>>April</option>
                                        <option value="5" <?php if($user_details->row()->dob_month=='5'){echo 'selected="selected"';}?>>May</option>
                                        <option value="6" <?php if($user_details->row()->dob_month=='6'){echo 'selected="selected"';}?>>June</option>
                                        <option value="7" <?php if($user_details->row()->dob_month=='7'){echo 'selected="selected"';}?>>July</option>
                                        <option value="8" <?php if($user_details->row()->dob_month=='8'){echo 'selected="selected"';}?>>August</option>
                                        <option value="9" <?php if($user_details->row()->dob_month=='9'){echo 'selected="selected"';}?>>September</option>
                                        <option value="10" <?php if($user_details->row()->dob_month=='10'){echo 'selected="selected"';}?>>October</option>
                                        <option value="11" <?php if($user_details->row()->dob_month=='11'){echo 'selected="selected"';}?>>November</option>
                                        <option value="12" <?php if($user_details->row()->dob_month=='12'){echo 'selected="selected"';}?>>December</option>
                                        </select>
                                        
                                        
                                        <select name="dob_date" id="user_birthdate_3i">
										<option value="">--Select--</option>
                                        <?php
                                        for($i=1;$i<=31;$i++){
                                        
                                        echo '<option value="'.$i.'"'; 
                                        if($user_details->row()->dob_date==$i){echo 'selected="selected"';}
                                        
                                        echo '>'.$i.'</option>';
                                        }
                                        
                                        
                                         ?>
                                        </select>
                                        
                                        <select name="dob_year" id="user_birthdate_1i" class="valid">
										<option value="">--Select--</option>
                                        <?php 
                                        for($i=2005;$i > 1920;$i--){
                                        
                                        echo '<option value="'.$i.'"'; 
                                        if($user_details->row()->dob_year==$i){echo 'selected="selected"';}
                                        
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
										<input type="text" style=" width:295px" tabindex="3" name="phone_no" id="phone_no" value="<?php  echo $user_details->row()->phone_no; ?>" /> <label id="phone_error" style="font-size:12px;display:none;" class="error">Only Number are allowed</label>
									</div>
								</div>
								</li> 
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="s_city">Where You Live</label>
									<div class="form_input">
										<input type="text" style=" width:295px" id="s_city" tabindex="4" name="s_city" value="<?php  echo $user_details->row()->s_city; ?>" /> 
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Describe Yourself</label>
									<div class="form_input">
										<textarea name="description" id="description" tabindex="5" style="width:295px;"><?php  echo $user_details->row()->description; ?></textarea>
										</br>
										<br><span class="words-left"> </span>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="s_city">School</label>
									<div class="form_input">
										<input type="text" style=" width:295px" name="school" tabindex="6" id="school" value="<?php  echo $user_details->row()->school; ?>" /> 
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="work">Work</label>
									<div class="form_input">
										<input type="text" style=" width:295px" tabindex="7" name="work" id="work" value="<?php  echo $user_details->row()->work; ?>" />  
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="email">Email Address </label>
									<div class="form_input">
										<?php echo $user_details->row()->email;?>
									</div>
								</div>
								</li>
                                <!--<li>
								<div class="form_grid_12">
									<label class="field_title" for="new_password">New Password <span class="req">*</span></label>
									<div class="form_input">
										<input name="new_password" id="new_password" type="password" tabindex="5" class="required large tipTop" title="Please enter the new password" value="<?php echo $user_details->row()->password;?>"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="confirm_password">Re-type Password <span class="req">*</span></label>
									<div class="form_input">
										<input name="confirm_password" id="confirm_password" type="password" tabindex="6" class="required large tipTop" title="Please re-type the above password" value="<?php echo $user_details->row()->password;?>"/>
									</div>
								</div>
								</li>-->

								<li>
								<div class="form_grid_12">
									<label class="field_title" for="image">User Image <span class="req">(Upload 272px X 272px Image)</span></label>
									<div class="form_input">
										<input name="image" onchange="Upload();" id="image" type="file" tabindex="8" class="large tipTop" title="Please select user image" accept="image/*"/>
										<label id="image_valid_error" style="font-size:12px;display:none;" class="error"> Height and Width must be 272PX x 272PX.</label>
										<label id="image_type_error" style="font-size:12px;display:none;" class="error"> Please select a valid Image file</label>
								</div>
									<?php if($user_details->row()->loginUserType =="google"){?>
									<div class="form_input"><img src="<?php if($user_details->row()->image==''){ echo base_url().'images/users/user-thumb1.png';}else{ echo $user_details->row()->image;}?>" width="100px"/></div>	
									<?php }else{?>	
									<div class="form_input"><img src="<?php if($user_details->row()->image==''){ echo base_url().'images/users/user-thumb1.png';}else{ echo base_url();?>images/users/<?php echo $user_details->row()->image;}?>" width="100px"/></div>
									<?php }?>
					
								</div>	
								</li>
								<!--<li>
								<div class="form_grid_12">
									<label class="field_title" for="group">Group <span class="req">*</span></label>
									<div class="form_input">
										<div class="user_renter">
											<input type="checkbox" name="group" <?php if ($user_details->row()->group == 'User'){echo 'checked="checked"';}?> id="User_Seller_User" class="User_Renter"/>
										</div>
									</div>
								</div>
								</li>-->
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" name="status" <?php if ($user_details->row()->status == 'Active'){echo 'checked="checked"';}?> id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								<input type="hidden" name="user_id" value="<?php echo $user_details->row()->id;?>"/>
								</li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="button" id="validate_edituser_form" class="btn_small btn_blue" tabindex=""><span>Update</span></button>
									</div>
								</div>
								</li>
							</ul>
						</div>
						<div id="tab2">
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
						</form>
						
						
															
		<!-- id verify-->
	<!--	<div id="tab3">
		<?php 
		
		$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
		echo form_open('admin/users/update_member_id_proof/'.$user_idProof->row()->id,$attributes);

		
		?>	
		<ul>
		<?php // print_r($id_verify->result()); exit;  ?>
		<li>
		<div class="form_grid_12">
		<table border="1px" height="100%" width="100%" >
		<tr>
		<th>S.No </th>
		<th> Proof Type</th>
		<th>ID Proof</th>
		<th >Status</th>
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
			
<td>
<?php
$proof_title = '';
if($post->proof_type =='1')
$proof_title = "Passport";
elseif($post->proof_type =='2')
$proof_title = "Voter ID";
elseif($post->proof_type =='3')
$proof_title = "Driving Licence";
echo $proof_title; 
 ?> 
</td>
			
		<td> <img src="<?php if($post->proof_file==''){ echo base_url().'server/php/id_proof/proof.png';}else{

		echo base_url();?>server/php/id_proof/<?php echo $post->proof_file;
		}?>" width="150px"  alt ="Proof"/>

		 </td>
		<td> <?php //echo $post->id_proof_status ?>
		
		<div class="verified_unverified">
		<div class="verifyUnverifyOption">
		<input type="checkbox" name="status[<?php echo $post->id; ?>]" <?php if ($post->id_proof_status == 'Verified'){echo 'checked="checked"';}?> id="active_inactive_active" class="verified_unverified" 
		onchange="SaveProofStatus();" />
		</div>
		 <span id="showErr"></span>
		<input type="hidden" name="id[]" value="<?php echo $post->id; ?>">
		</div>
		
		</td>




		<?php 								
		}
		else if (in_array($file_ext[1],$txt_formats))
		{?>


		<td><?php echo $i;  ?> </td>
		
		
		<td>
<?php
$proof_title = '';
if($post->proof_type =='1')
$proof_title = "Passport";
elseif($post->proof_type =='2')
$proof_title = "Voter ID";
elseif($post->proof_type =='3')
$proof_title = "Driving Licence";
echo $proof_title; 
 ?> 
</td>

		<td> 
		<a href="<?php if($post->proof_file==''){ echo base_url().'server/php/id_proof/txt_thumb.png';}else {

		echo base_url();?>server/php/id_proof/<?php echo $post->proof_file;
		}?>" target="_blank"><?php echo $post->proof_file; ?></a>
		</td>

		<td> 

		<div class="verified_unverified">
<div class="verifyUnverifyOption">
		<input type="checkbox" name="status[<?php echo $post->id; ?>]" <?php if ($post->id_proof_status == 'Verified'){echo 'checked="checked"';}?> id="active_inactive_active" class="verified_unverified" 
		onchange="SaveProofStatus();" />
		</div>
		 <span id="showErr"></span>
		<input type="hidden" name="id[]" value="<?php echo $post->id; ?>">
		</div>
		</td>	



		<?php	
		}
		else if (in_array($file_ext[1],$pdf_formats))
		{?>
		<td><?php echo $i;  ?> </td>
		
		<td>
<?php
$proof_title = '';
if($post->proof_type =='1')
$proof_title = "Passport";
elseif($post->proof_type =='2')
$proof_title = "Voter ID";
elseif($post->proof_type =='3')
$proof_title = "Driving Licence";
echo $proof_title; 
 ?> 
</td>

		<td> 
		<a href="<?php if($post->proof_file==''){ echo base_url().'server/php/id_proof/pdf_thumb.png';}else {

		echo base_url();?>server/php/id_proof/<?php echo $post->proof_file;
		}?>" target="_blank"><?php echo $post->proof_file; ?></a>
		</td>

		<td> 

		<div class="verified_unverified">
<div class="verifyUnverifyOption">
		<input type="checkbox" name="status[<?php echo $post->id; ?>]" <?php if ($post->id_proof_status == 'Verified'){echo 'checked="checked"';}?> id="active_inactive_active" class="verified_unverified" 
		onchange="SaveProofStatus();" />
</div>
 <span id="showErr"></span>
		<input type="hidden" name="id[]" value="<?php echo $post->id; ?>">

		</div>																				
		</td>



		<?php  }
		else if (in_array($file_ext[1],$word_formats))

		{
		?>
		<td><?php echo $i;  ?> </td>
		
		<td>
<?php
$proof_title = '';
if($post->proof_type =='1')
$proof_title = "Passport";
elseif($post->proof_type =='2')
$proof_title = "Voter ID";
elseif($post->proof_type =='3')
$proof_title = "Driving Licence";
echo $proof_title; 
 ?> 
</td>

		<td> 
		<a href="<?php if($post->proof_file==''){ echo base_url().'images/verify-images/word_thumb/word_thumb.jpg';}else {

		echo base_url();?>server/php/id_proof/<?php echo $post->proof_file;
		}?>" target="_blank"><?php echo $post->proof_file; ?></a>
		</td>

		<td> 

		<div class="verified_unverified">
		<div class="verifyUnverifyOption">
		<input type="checkbox" name="status[<?php echo $post->id; ?>]" <?php if ($post->id_proof_status == 'Verified'){echo 'checked="checked"';}?> id="active_inactive_active" class="verified_unverified" 
		onchange="SaveProofStatus();" />
		</div>
		 <span id="showErr"></span>
		<input type="hidden" name="id[]" value="<?php echo $post->id; ?>">
		</div>																				
		</td> 

		<?php }
		?>  </tr><?php
		$i++;
		}

		}
		?>

		

<div class="form_grid_12">
<label class="field_title" for="declineStatus">Allow Another Proof to Submit</label>
<div class="form_input">


		<div class="yes_no">
		<div class="yesNoOption">
		<input type="checkbox" name="decline_status" <?php if ($post->decline_status == 'Yes'){echo 'checked="checked"';}?> id="yesNoCheck" class="yes_no" 
		 />
		 <!-- id="active_inactive_active" 
		 </div>
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
		<div class="form_input">
		<input type="submit" class="btn_small btn_blue nxtTab" name="submit" tabindex="9"  value="Submit"/>
		</div>
		</div>
		</li>
		</ul>
		</form>
		</div> -->

		<!--//id verify-->	
						
						
						
						
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<script type="text/javascript">
$('#validate_edituser_form').click(function(){
var image_name=$('#image').val();
var full_name=$('#full_name').val();
var last_name=$('#last_name').val();

var ext = $('#image').val().split('.').pop().toLowerCase();
if(full_name =='') {
	document.getElementById("full_name_error").style.display = "inline";
	$("#full_name_error").fadeOut(8000);
} else
	if(last_name =='') {
	document.getElementById("last_name_error").style.display = "inline";
	$("#last_name_error").fadeOut(8000);
} else
if(image_name !='')
{
if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    alert('Only Images can be Uploaded');
}
else{
$('#edituser_form').submit();
}
}
else{
$('#edituser_form').submit();
}
});
</script>

<script>
 $("#full_name").on('keypress', function(e) {
     var val = $(this).val();
	  if(val.length == 50){
	   document.getElementById("full_name_error_len").style.display = "inline";
	   $("#full_name_error_len").fadeOut(5000);
   }
});

$("#last_name").on('keypress', function(e) {
     var val = $(this).val();
	   if(val.length == 50){
	   document.getElementById("last_name_error_len").style.display = "inline";
	   $("#last_name_error_len").fadeOut(5000);
   }
});

$("#phone_no").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^0-9\s]/g)) {
	   document.getElementById("phone_error").style.display = "inline";
	   $("#phone_no").focus();
	   $("#phone_error").fadeOut(5000);
       $(this).val(val.replace(/[^0-9\s]/g, ''));
   }
});


</script>



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
                   // if (height != 272 || width != 272) {
						if (height > 272 || width > 272) {
                       // alert("Height and Width must be 272PX X 272PX.");
						document.getElementById("image_valid_error").style.display = "inline";
						$("#image_valid_error").fadeOut(7000);
						$("#image").val('');
						$(".filename").text('No file selected');
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

<!--<script type="text/javascript">
//function WordCount(){
var wordLen = 150,
		len; 
$('#description').keydown(function(event) {	
	len = $('#description').val().split(/[\s]+/);
	if (len.length > wordLen) { 
		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons
    } else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons
    	event.preventDefault();
    }
	}
	
	wordsLeft = (wordLen) - len.length;
	//alert(wordsLeft);
	if(wordsLeft == 0) {
	alert("You Can not Type More then 150 Words");
		//$('.words-left').html('You Can not Type More then 150 Words...!');
	}
});

//}


</script>-->




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
 
  //$("#allowSubmit").css("display","none");
 // $("#formSub").css("display","none");
 
 </script>
 <?php  }  ?>

 <script>
    $(document).ready(function() {
        $('.yes_no').click(function() {

			if ($('#yesNoCheck').is(":checked"))
			{
			  $(".verifyUnverifyOption").css("display","none");
			  $("#showErr").html("UnVerified");
			}else{
				 $(".verifyUnverifyOption").css("display","block");
				  $("#showErr").html("");
			}

        });
    });
</script>

<?php 
$this->load->view('admin/templates/footer.php');
?>