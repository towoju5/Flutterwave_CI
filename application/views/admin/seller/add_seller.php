<?php
$this->load->view('admin/templates/header.php');
//print_r($_SESSION);
?>
<script>
function checkMandatory(){
	
	noMandatory = 0;
	var firstname = $("#firstname").val();
	var lastname = $("#lastname").val();
	var email = $("#email").val();
	var pwd = $("#new_password").val();
	var confirmPwd = $("#confirm_password").val();
	 var re = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

 
	//alert(firstname+' -'+lastname+' -'+email+' -'+pwd+' -'+confirmPwd);
	if((firstname=='') || (lastname=='' ) || (email=='')  || (pwd=='')|| (confirmPwd=='')){
		$("#nextBtn").removeClass('nxtTab');
		noMandatory = 1;
		
		alert('Some mandatory field remainds empty.Please fill mandatories. ');
		
		return false;
	}else if(!email.match(re))
	{
			$("#nextBtn").removeClass('nxtTab');
			noMandatory = 1;
            alert('Invalid Email Address');
			//$("#tab2").style.display='none';
			
            return false;
	}
	else if(pwd != confirmPwd)
	{
			$("#nextBtn").removeClass('nxtTab');
			noMandatory = 1;
            alert('New password and confirm password miss match');
			//$("#tab2").style.display='none';
			
            return false;
	}
	else{
		noMandatory = 0;

		$("#nextBtn").addClass('nxtTab');
		
		return true;
	}
}


$(document).ready(function(){
	$('.nxtTab').click(function(){

		checkMandatory();
		//alert(noMandatory);
		if(noMandatory == 0)
		{
			var cur = $(this).parent().parent().parent().parent().parent();
			cur.hide();
			cur.next().show();
			var tab = cur.parent().parent().prev();
		
			tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
		}
	});
	$('.prvTab').click(function(){
		var cur = $(this).parent().parent().parent().parent().parent();
		cur.hide();
		cur.prev().show();
		var tab = cur.parent().parent().prev();
		tab.find('a.active_tab').removeClass('active_tab').parent().prev().find('a').addClass('active_tab');
	});
	$('#tab2 input[type="checkbox"]').click(function(){
		var cat = $(this).parent().attr('class');
		var curCat = cat;
		var catPos = '';
		var added = '';
		var curPos = curCat.substring(3);
		var newspan = $(this).parent().prev();
		if($(this).is(':checked')){
			while(cat != 'cat1'){
				cat = newspan.attr('class');
				catPos = cat.substring(3);
				if(cat != curCat && catPos<curPos){
					if (jQuery.inArray(catPos, added.replace(/,\s+/g, ',').split(',')) >= 0) {
					    //Found it!
					}else{
						newspan.find('input[type="checkbox"]').attr('checked','checked');
						added += catPos+',';
					}
				}
				newspan = newspan.prev(); 
			}
		}else{
			var newspan = $(this).parent().next();
			if(newspan.get(0)){
				var cat = newspan.attr('class');
				var catPos = cat.substring(3);
			}
			while(newspan.get(0) && cat != curCat && catPos>curPos){
				newspan.find('input[type="checkbox"]').attr('checked',this.checked);	
				newspan = newspan.next(); 	
				cat = newspan.attr('class');
				catPos = cat.substring(3);
			}
		}
	});
		
});
</script>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New Host</h6>
                        <div id="widget_tab">
			              <ul>
			                <li><a href="#tab1" class="active_tab">Host Details</a></li>
			                <li><a href="#tab2">Bank Details</a></li>
			              </ul>
			            </div>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addseller_form', 'enctype' => 'multipart/form-data','onsubmit'=>'return checkMandatory();','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/seller/insertEditRenter',$attributes) 
					?>		<div id="tab1">
	 						<ul>
							<!---added------->
							<?php /*
							<?php if($_SESSION['fc_session_admin_rep_code']!='')
									{?>
										<input type="hidden" name="rep_code" value="<?php echo $_SESSION['fc_session_admin_rep_code']; ?>" class="tipTop required" title="Enter the Representative Code" style=" width:295px" readonly />
									<?php } ?>
							*/?>
							<!---added------->
							
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Rep Code<span class="req">*</span></label>
									<div class="form_input">
									<?php if($_SESSION['fc_session_admin_rep_code']!='')
									{?>
										<input type="text" name="rep_code" id="rep_code" value="<?php echo $_SESSION['fc_session_admin_rep_code']; ?>" class="tipTop required" title="Enter the Representative Code" style=" width:295px" readonly />
									<?php } else {?>
									<select name="rep_code" id="rep_code">
									<option value="">Select Rep Code</option>
									<?php
									foreach($this->data['query'] as $row_rep)
									{
										
										echo '<option value="'.$row_rep->admin_rep_code.'">'.$row_rep->admin_rep_code.'</option>';
									}
									?>
									</select>
									<?php } ?>
									</div>
								</div>
								</li>
								
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="firstname">First Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="firstname" style=" width:295px" id="firstname" value="" type="text" tabindex="1" class="required tipTop" title="Please enter the firstname" maxlength="15" required />
										<label id="full_name_error" style="font-size:12px;display:none;" generated="true" class="error">Numbers are not allowed</label>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="lastname">Last Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="lastname" style=" width:295px" id="lastname" value="" type="text" tabindex="2" class="required tipTop" title="Please enter the lastname" maxlength="15" required />
										<label id="last_name_error" style="font-size:12px;display:none;" generated="true" class="error">Numbers are not allowed</label>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="gender">I Am</label>
									<div class="form_input">
                                    <select name="gender" id="gender" class=" large tipTop" tabindex="" title="Please select the gender">
									<option value="">--Select--</option>
                                    <option value="Male" >Male</option>
                                    <option value="Female" >Female</option>
                                    <option value="Unspecified">Unspecified</option>
                                    </select>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="dob_month">Date of birth</label>
									<div class="form_input">
                                    <select name="dob_month" id="user_birthdate_2i" class="valid tipTop" tabindex="" title="Please select date of birth">
									<option value="">--Select--</option>
                                        <option value="1"  >January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4" >April</option>
                                        <option value="5" >May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9" >September</option>
                                        <option value="10">October</option>
                                        <option value="11" >November</option>
                                        <option value="12">December</option>
                                        </select>
                                        
                                        
                                        <select name="dob_date" id="user_birthdate_3i">
										<option value="">--Select--</option>
                                        <?php
                                        for($i=1;$i<=31;$i++){
                                        
                                        echo '<option value="'.$i.'"'; 
                                        //if($seller_details->row()->dob_date==$i){echo 'selected="selected"';}
                                        
                                        echo '>'.$i.'</option>';
                                        }
                                        
                                        
                                         ?>
                                        </select>
                                        
                                        <select name="dob_year" id="user_birthdate_1i" class="valid">
										<option value="">--Select--</option>
                                        <?php 
                                        for($i=2005;$i > 1920;$i--){
                                        
                                        echo '<option value="'.$i.'"'; 
                                        //if($seller_details->row()->dob_year==$i){echo 'selected="selected"';}
                                        
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
										<input type="text" style=" width:295px" name="phone_no" id="phone_no" value="" tabindex="3" class="tipTop"  title="Please enter your phone number" maxlength=""/><label id="phone_no_error" style="display:none;" class="error"> Only Numbers are not allowed</label>
									</div>
								</div>
								</li> 
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="s_city">Where You Live</label>
									<div class="form_input">
										<input type="text" style=" width:295px" name="s_city" id="s_city" value="" class="tipTop" tabindex="4" title="Please enter your current location" /><label id="s_city_error" style="font-size:12px;display:none;" generated="true" class="error"> Only Alphabets are not allowed</label>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Describe Yourself</label>
									<div class="form_input">
										<textarea name="description" style="width:295px;" class="tipTop" tabindex="5" title="Please enter your details" ></textarea>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="school">School</label>
									<div class="form_input">
										<input type="text" style=" width:295px" name="school" id="school" value="" class="tipTop" tabindex="6" title="Please enter school name" /><label id="school_error" style="display:none;" class="error"> Only Alphabets are not allowed</label>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="work">Work</label>
									<div class="form_input">
										<input type="text" style=" width:295px" name="work" id="work" value="" class="tipTop" tabindex="7" title="Please enter work position" /><label id="work_error" style="display:none;" class="error"> Only Alphabets are not allowed</label>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="email">Email Address <span class="req">*</span></label>
									<div class="form_input">
										<input type="text" style=" width:295px" id='email' name="email" value="" class="tipTop" tabindex="8" required title="Please enter email address" onChange="check_seller_email(this.value);"/>
										<label id="email_exist_error" class="error" style="display:none;">This Email Id Already Exist</label>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="web_url">Website</label>
									<div class="form_input">
										<input type="url" name="web_url" value="" tabindex="9" class="tipTop large" title="Enter the website url" />
										<br><br><label class="">Example: http://www.domain.com </label>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="new_password">New Password <span class="req">*</span></label>
									<div class="form_input">
										<input name="new_password" id="new_password" type="password" tabindex="10" class="required large tipTop" title="Please enter the new password"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="confirm_password">Confirm Password <span class="req">*</span></label>
									<div class="form_input">
										<input name="confirm_password" id="confirm_password" type="password" tabindex="11" class="required large tipTop" title="Please re-type the above password"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="image">User Image (Image Size 272px X 272px)</label>
									<div class="form_input">
										<input name="image" id="image" onchange="Upload();" type="file" tabindex="12" class="large tipTop" title="Please select user image" />
										<label id="image_valid_error" style="font-size:12px;display:none;" class="error"> Height and Width must be 272PX X 272PX.</label>
										<label id="image_type_error" style="font-size:12px;display:none;" class="error"> Please select a valid Image file</label>
									</div>
								</div>
								</li>
                                
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="13" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								</li>
								
                                <li>
                <div class="form_grid_12">
                  <div class="form_input">
                    <input type="button" class="btn_small btn_blue nxtTab" onclick="//checkMandatory('error');" id="nextBtn" value="Next"/>
                  </div>
                </div>
              </li>
							</ul>
                            </div>
                            <div id="tab2">
							<ul>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="accname">Account Name</label>
									<div class="form_input">
										<input type="text" name="accname" value="" id="accname" tabindex="1" class="tipTop large" title="Enter the bank account Name" /><label id="accname_error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="accno">Account Number</label>
									<div class="form_input">
										<input type="text" name="accno" value="" id="accno" class="tipTop large" tabindex="2" title="Enter the bank account number" /><label id="accno_error" style="font-size:12px;display:none;" class="error">Only Numbers are allowed</label>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Bank Name</label>
									<div class="form_input">
										<input type="text" name="bankname" id="bankname" value="" class="tipTop large" tabindex="3" title="Enter the bank name" /><label id="bankname_error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>
									</div>
								</div>
								</li>
								<!-- Update for client side new fields --->
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">SWIFT Code (Non-US Banks Only)</label>
									<div class="form_input">
										<input type="text" name="swift_code" id="swift_code" value="" class="tipTop large" title="Enter the swift code" />
										<label id="bankname_error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>

									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">IBAN (Non-US Banks Only)</label>
									<div class="form_input">
										<input type="text" name="ibnb_code" id="ibnb_code" value="" class="tipTop large" title="Enter the ibnb code" />
										<label id="bankname_error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>

									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Routing Code/Sort Code (Non-US Banks Only)</label>
									<div class="form_input">
										<input type="text" name="routing_code" id="routing_code" value="" class="tipTop large" title="Enter Routing Code/Sort Code" />
										
									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="bankname">Currency</label>
									<div class="form_input">
										<select name="currency_code_bank" id="currency_code_bank" >
			<?php if($active_currency->num_rows() >0){ foreach($active_currency->result() as $currency_s){?>             
  <option value="<?php echo $currency_s->currency_type; ?>" ><?php echo $currency_s->currency_type; ?></option><?php } } ?>
				
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
				echo '<option value="'.$actcnt->id.'">'.$actcnt->name.'</option>';
				} ?>
			</select> 
										

									</div>
								</div>
								</li>
								<li>

								<div class="form_grid_12">

									<label class="field_title" for="paypal_email">Paypal Email<span class="req">*</span></label>

									<div class="form_input">

										<input type="email" name="paypal_email" id="paypal_email" value="" class="tipTop large" title="Enter the Paypal Email" required/>

									</div>

								</div>

								</li>
								<!-- Update for client side new fields --->
								
                                <li>
								<div class="form_grid_12">
									<div class="form_input">
                                    	<input type="button" class="btn_small btn_blue prvTab" tabindex="4" value="Previous"/>
										<button type="submit" class="btn_small btn_blue" tabindex="9"><span>Submit</span></button>
									</div>
								</div>
								</li>
								
							</ul>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<script>
$('#addseller_form').validate();
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>

<script>

$("#firstname").on('keyup', function(e) {
	 var numers = /[0-9]+$/;
     var val = $(this).val();
	   if(numers.test(val)){
	   document.getElementById("full_name_error").style.display = "inline";
	   $("#full_name").focus();
	   $("#full_name_error").fadeOut(5000);
       $(this).val(val.replace(/[0-9]+$/, ''));
   }
});

$("#lastname").on('keyup', function(e) {
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
                    if (height != 272 || width != 272) {
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
<script type="text/javascript">
	/*this function is to check Email Id already exist are not*/
	function check_seller_email(emailid){
		$.ajax({
			type: 'POST',
			data: 'email_id='+emailid,
			url: 'admin/seller/check_seller_email_exist',
			success: function(responseText){  
				if(responseText==1){
					document.getElementById("email_exist_error").style.display = "inline";
				}else{
					document.getElementById("email_exist_error").style.display = "none";
				}
			}
		});
	}
</script>