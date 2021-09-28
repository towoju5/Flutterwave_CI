<?php 
$this->load->view('site/templates/header');
?>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor account acc-security">

  <div class="top-listing-head">
 <div class="main">
<?php $this->load->view('site/user/main_nav_header');   ?> 
             </div></div>
	<div class="dash_brd">
    	<div id="command_center">
    
			<div class="lispg_top">	
			<!--Side nav header -->
            <?php 
             $this->load->view('site/user/sub_nav_header');  
            ?>
            	<div id="account" class="listiong-areas">
    <div class="box">
      <div class="middle">
        <form method="post" action="site/user/change_password1" accept-charset="UTF-8" id="changePassword1"><div class="emptydiv_actsetting" style="margin:0;padding:0;display:inline"></div>
          <h2><?php if($this->lang->line('ChangeYourPassword') != '') { echo stripslashes($this->lang->line('ChangeYourPassword')); } else echo "Change Your Password";?></h2>
          <div class="section notification_section">
            <div class="notification_area">
            
              <div class="notification_action password-action">

		<?php if($this->lang->line('Please_enter_your_old_password') != '')
		{ 
			$old_password = stripslashes($this->lang->line('Please_enter_your_old_password')); 
		} 
		else
		{
			$old_password = "Please enter your old password";
		}		
		?>
		<?php if($this->lang->line('Please_enter_your_new_passowrd') != '')
		{ 
			$new_password = stripslashes($this->lang->line('Please_enter_your_new_passowrd')); 
		} 
		else
		{
			$new_password = "Please enter your new passowrd";
		}		
		?>
		<?php if($this->lang->line('Please_enter_confirm_password') != '')
		{ 
			$confirm_password = stripslashes($this->lang->line('Please_enter_confirm_password')); 
		} 
		else
		{
			$confirm_password = "Please enter confirm password";
		}		
		?>
		<?php if($this->lang->line('Passwords_not_matching') != '')
		{ 
			$pass_not_match = stripslashes($this->lang->line('Passwords_not_matching')); 
		} 
		else
		{
			$pass_not_match = "Passwords not matching";
		}		
		?>
                <input type="hidden" value="<?php echo $userDetails->row()->email;?>" name="id" id="id">
              
                <table class="password-changes">
				 
                    <tbody>
					<tr>
					<td class="password-lbl"><label><?php if($this->lang->line('OldPassword') != '') { echo stripslashes($this->lang->line('OldPassword')); } else echo "Old Password";?>:<span style="color:#FF0000">*</span></label>
					</td>
					<td>
					<input type="hidden" value="<?php echo $old_password; ?>" name="old_pass" id="old_pass">
					<input type="hidden" value="<?php echo $new_password; ?>" name="new_pass" id="new_pass">
					<input type="hidden" value="<?php echo $confirm_password; ?>" name="confirm_pass" id="confirm_pass">
					<input type="hidden" value="<?php echo $pass_not_match; ?>" name="pass_not" id="pass_not">
					<input type="password" name="old_password" id="old_password">
					
					
                    <div id="old_password_warn" class="sec-old" style=""></div></td></tr>
                  <tr><td class="password-lbl" style=""><label><?php if($this->lang->line('NewPassword') != '') { echo stripslashes($this->lang->line('NewPassword')); } else echo "New Password";?>:<span style="color:#FF0000">*</span></label></td><td style="position: relative;"><input type="password" size="30" name="new_password" id="new_password">
                   <div id="new_password_warn" class="sec-new" style=""></div>
				   
				   <span id="new_password_error" class="pass-len" style=" display:none;">
				   *<?php if($this->lang->line('pasword_length') != '') { echo stripslashes($this->lang->line('pasword_length')); } else echo "Password Should be atleast 6";?>!</span>
				   
				   
				   
				   </td></tr>
                  <tr><td class="password-lbl"><label><?php if($this->lang->line('change_conf_pwd') != '') { echo stripslashes($this->lang->line('change_conf_pwd')); } else echo "Confirm Password";?>:<span style="color:#FF0000">*</span></label></td><td><input type="password" size="30" name="confirm_password" id="confirm_password">
                   <div id="confirm_password_warn" class="sec-con" style=""></div></td></tr>
                </tbody></table>
              </div>
            </div>
            <div class="buttons">
              <input type="submit" value="<?php if($this->lang->line('UpdatePassword') != '') { echo stripslashes($this->lang->line('UpdatePassword')); } else echo "Update Password";?>" onclick="return ChangePassword();" name="commit" class="updatepaswd">
            </div>
          </div>
		  
</form>

	
        <!--<h2>Cancel Account</h2>
        <div id="cancel_account" class="section notification_section">
          <div class="notification_area">
            <div style="clear: both;"></div>
            <p class="cancel_link"><a onclick="jQuery('#account_canceler').show(); jQuery('.cancel_link').hide(); return false;" href="#">Cancel my account</a></p>
            <div style="clear: both;"></div>
            <div style="display: none;" id="account_canceler">
              <form method="post" action="site/user/cancel_account" accept-charset="UTF-8"><div style="margin:0;padding:0;display:inline"></div>
              <div id="canceling_explanation" class="fanged_panel">
                <div class="header">
                  <h3>Tell us why you're leaving</h3>
                </div>
                <div class="body">
                  <ul class="no-disc">
                    <li class="clearfix"><input type="radio" value="safety_concerns" name="reason" id="reason_safety_concerns"> <label for="reason_safety_concerns">I have safety concerns.</label> </li>
                    <li class="clearfix"><input type="radio" value="privacy_concerns" name="reason" id="reason_privacy_concerns"> <label for="reason_privacy_concerns">I have privacy concerns.</label> </li>
                    <li class="clearfix"><input type="radio" value="not_useful" name="reason" id="reason_not_useful"> <label for="reason_not_useful">I don't find it useful.</label> </li>
                    <li class="clearfix"><input type="radio" value="dont_understand_how_to_use" name="reason" id="reason_dont_understand_how_to_use"> <label for="reason_dont_understand_how_to_use">I don't understand how to use it.</label> </li>
                    <li class="clearfix"><input type="radio" value="temporary" name="reason" id="reason_temporary"> <label for="reason_temporary">It's temporary; I'll be back.</label> </li>
                    <li class="clearfix"><input type="radio" value="other" name="reason" id="reason_other"> <label for="reason_other">Other</label> </li>
                  </ul>

                  <p class="tell_more">Care to tell us more?</p>
                  <textarea name="details" id="details"></textarea>

                  <h6>Can we contact you for more details?</h6>
                  <input type="radio" value="yes" name="contact_ok" id="contact_ok_yes"> <label for="reason_yes">Yes</label>
                  <input type="radio" value="no" name="contact_ok" id="contact_ok_no"> <label for="reason_no">No</label>

                  <h6>What's going to happen</h6>
                  <ul>
                    <li>Your profile and any listings will disappear.</li>
                    <li>We'll remove you from any groups you're in.</li>
                    <li><strong>We'll miss you terribly.</strong></li>
                  </ul>
				  <input type="hidden" value="<?php echo $userDetails->row()->email; ?>" name="email" />
                  <input type="hidden" value="<?php echo $userDetails->row()->id; ?>" name="id" />
                  <input type="submit" value="Cancel my account" id="make_the_call" class="btn red"> or <a onclick="jQuery('#account_canceler').hide(); jQuery('.cancel_link').show(); return false;" href="#">Don't cancel account</a>
                </div>
              </div>
</form>
              <div id="canceling_alternatives" class="fanged_panel">
                <div class="header">
                  <h3>Alternatives to canceling</h3>
                </div>
                <div class="body">
                  <h5>
                    <a href="<?php echo base_url().'account-privacy';?>">Adjust my privacy settings</a>
                  </h5>
                  <p class="alternative_explanation">
                    Turn off search indexing on your listing, preventing search engines such as Google and Bing from displaying your listing in their search results.
                  </p>
                  <h5>
                    <a href="<?php echo base_url().'account';?>">Change notification preferences</a>
                  </h5>
                  <p class="alternative_explanation">
                    Are we sending you too much email? Change your notification preferences.
                  </p>
                  <h5>
                    <a href="<?php echo base_url().'listing/all';?>">Hide my listings</a>
                  </h5>
                  <p class="alternative_explanation">
                    Remove your listings from being viewed or found in search to stop hosting on .
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>-->

        <div class="clearfix"></div>
      </div>
    </div>
  </div>
         </div>
  </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
			$("#changePassword").submit(function(){
				// var email = $('#vendor_email').val();
				//alert('');
			
				 $("#old_password_warn").html('');
				 $("#new_password_warn").html('');
				 $("#confirm_password_warn").html('');
				
				
					
					if(jQuery.trim($("#old_password").val()) == ''){
					  
						$("#old_password_warn").html('<?php if($this->lang->line('Please_enter_your_old_password') != '') { echo stripslashes($this->lang->line('Please_enter_your_old_password')); } else echo "Please enter your old password";?>');
						$("#old_password").focus();
						return false;
						
					}else if(jQuery.trim($("#new_password").val()) == ''){
						
						$("#new_password_warn").html('<?php if($this->lang->line('Please_enter_your_new_passowrd') != '') { echo stripslashes($this->lang->line('Please_enter_your_new_passowrd')); } else echo "Please enter your new passowrd";?>');
						$("#new_password").focus();
						return false;
						
					}else if(jQuery.trim($("#confirm_password").val()) == ''){
					  
						$("#confirm_password_warn").html('<?php if($this->lang->line('Re_enter_the_new_password') != '') { echo stripslashes($this->lang->line('Re_enter_the_new_password')); } else echo "Re-enter the new password";?>');
						$("#confirm_password").focus();
						return false;
					}else if(jQuery.trim($("#confirm_password").val()) != (jQuery.trim($("#new_password").val()))){
					  
						$("#confirm_password_warn").html('<?php if($this->lang->line('Passwords_do_not_match') != '') { echo stripslashes($this->lang->line('Passwords_do_not_match')); } else echo "Passwords do not match";?>');
						$("#confirm_password").focus();
						return false;
						
					}else
					{	
					      	$("#changePassword").submit();
					}
					
					return false;	
				});
		});
		
	 
function removeError(idval){
	$("#"+idval+"_warn").html('');}
</script>

<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<script>
// just for the demos, avoids form submit
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
$( "#changePassword" ).validate({
  rules: {
    old_password: {
      required: true,
      minlength: 6
    },
	new_password: {
      required: true,
      minlength: 6
    },
	confirm_password: {
      required: true,
      minlength: 6
    },
  }
});
</script>
<!---DASHBOARD-->

<script>
$('#new_password').on('blur', function(){
    if(this.value.length < 6 ){ // checks the password value length
       document.getElementById("new_password_error").style.display = "inline";
	   $("#new_password_error").fadeOut(5000);
       $(this).focus(); // focuses the current field.
       return false; // stops the execution.
    }
});
</script>
<!---FOOTER-->
<?php 

$this->load->view('site/templates/footer');
?>