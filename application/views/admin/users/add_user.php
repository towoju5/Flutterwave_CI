<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New Guest</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'adduser_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/users/insertEditUser',$attributes) 
					?>
	 						<ul>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="firstname">First Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="firstname" id="firstname" type="text" maxlength="50" tabindex="1" class="required large tipTop" title="Please enter the user First Name"/> <label id="firstname_error_len" style="font-size:12px;display:none;" class="error">Max 50 Characters Allowed</label>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="lastname">Last Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="lastname" id="lastname" type="text" maxlength="50" tabindex="2" class="required large tipTop" title="Please enter the user Last Name"/> <label id="lastname_error_len" style="font-size:12px;display:none;" class="error">Max 50 Characters Allowed</label>
									</div>
								</div>
								</li>
                                
                                
                                
								<!--<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_name">User Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="user_name" id="user_name" type="text" tabindex="2" class="required large tipTop" title="Please enter the username"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="group">Group <span class="req">*</span></label>
									<div class="form_input">
										<div class="user_renter">
											<input type="checkbox" tabindex="3" name="group" checked="checked" id="User_Seller_User" class="User_Renter"/>
										</div>
									</div>
								</div>
								</li>-->
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="email">Email Address <span class="req">*</span></label>
									<div class="form_input">
										<input name="email" id="email" type="text" tabindex="3" class="required email large tipTop" title="Please enter the user email address" onChange="check_email_exist(this.value);"/>
										<label id="email_exist_error" class="error" style="display:none;">This Email Id Already Exist</label>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="new_password">New Password <span class="req">*</span></label>
									<div class="form_input">
										<input name="new_password" id="new_password" type="password" tabindex="4" class="required large tipTop" title="Please enter the new password"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="confirm_password">Re-type Password <span class="req">*</span></label>
									<div class="form_input">
										<input name="confirm_password" id="confirm_password" type="password" tabindex="5" class="required large tipTop" title="Please re-type the above password"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12 ">
									<label class="field_title" for="image">User Image <span class="req">(Upload 272px X 272px Image)</span></label>
									<div class="form_input">
										<input name="image" id="image" onchange="Upload(this.id);" type="file" tabindex="6" class="large tipTop" title="Please select user image" /> <!-- accept="image/*"-->
										<label id="image_valid_error" style="font-size:12px;display:none;" class="error"> Height and Width must be 272PX x 272PX.</label>
										<label id="image_type_error" style="font-size:12px;display:none;" class="error"> Please select a valid Image file</label>
									</div>
									
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="7" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="8"><span>Submit</span></button>
									</div>
								</div>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>

<?php 
$this->load->view('admin/templates/footer.php');
?>

<script>
 $("#firstname").on('keypress', function(e) {
     var val = $(this).val();
	   if(val.length == 50){
	   document.getElementById("firstname_error_len").style.display = "inline";
	   $("#firstname_error_len").fadeOut(5000);
   }
});

$("#lastname").on('keypress', function(e) {
     var val = $(this).val();
	 if(val.length == 50){
	   document.getElementById("lastname_error_len").style.display = "inline";
	   $("#lastname_error_len").fadeOut(5000);
   }
}); 
</script>

<script type="text/javascript">
function Upload(files) {
   
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
						$("#image").val('');
						$(".filename").html('No file selected');
						//$('#image').attr('src', '');
						$("#image_valid_error").fadeOut(7000);
						
						//document.getElementById(files).value = "";
						//document.getElementById("image").value = "";
						$("#image").focus();
                        return false;
                    } 
                    return true;
                };
            }
        } else {
            alert("This browser does not support HTML5.");
			$("#image").val('');
			$(".filename").html('');
            return false;
        }
    } else {
       // alert("Please select a valid Image file.");
		document.getElementById("image_type_error").style.display = "inline";
		$("#image_type_error").fadeOut(7000);
		$("#image").val('');
		$(".filename").html('');
		$("#image").focus();
        return false;
    }
}
</script>
<!--start subadmin email id check-->
<script type="text/javascript">
	function check_email_exist(emailid){
		
		$.ajax({
			type: 'POST',
			data: 'email_id='+emailid+'&group=User',
			url: 'admin/users/check_user_email_exist',
			success: function(responseText){  
	
				if(responseText > 0){
					document.getElementById("email_exist_error").style.display = "inline";	
				}else{
					document.getElementById("email_exist_error").style.display = "none";
				}
			}
		});
	}
</script>	
<!--end subadmin email id check-->	