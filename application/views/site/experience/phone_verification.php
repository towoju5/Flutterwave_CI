<?php 
$this->load->view('site/templates/header');
$this->load->view('site/templates/listing_head_side');
?>
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>
         
            <div class="right_side">
			<div class="verify-phones23"><a href="javascript:;" onclick="phone_verfication()"><?php if($this->lang->line('Verify via sms') != '') { echo stripslashes($this->lang->line('Verify via sms')); } else echo "Verify via sms";?></a></div>
			<div id="verification_div" style="display:none;">
			<input type="text" value="" name="mobile_verification_code" id="mobile_verification_code">
			<input type="button" onclick="check_phpone_verification()" value="Verify">
			</div>
			
			
            </div>
            </div>
</div>
<script type="text/javascript">
function DeleteListYoutProperty(val){
	
	var res = window.confirm('<?php if($this->lang->line('Are you sure') != '') { echo stripslashes($this->lang->line('Are you sure')); } else echo "Are you sure";?>?');
	if(res){
		window.location.href = 'site/experience/delete_property_details/'+val;
	}else{
		
		return false;
	}
}
function phone_verfication()
{
/*  $.ajax({
type:'POST',
url:'<?php echo base_url()?>site/twilio/product_verification',
success:function(response)
{
if(response=='success')
{
alert('We Have Sent Verification Code to Your Mobile Please Enter Verification Code');
 $('#verification_div').css('display','block');
}
}
});  */

	if('<?php echo $hosting_commission_status->row()->status?>'=='Inactive')
	{
		window.location='<?php echo base_url()?>site/experience/redirect_base/completed';
	}
	else{
		window.location='<?php echo base_url()?>site/experience/redirect_base/payment/<?php echo $listDetail->row()->experience_id;?>';
	}

}

function check_phpone_verification()
{
 mobile_verification_code=$('#mobile_verification_code').val();
$.ajax({
type:'POST',
url:'<?php echo base_url()?>site/experience/check_phpone_verification',
data:{product_id:'<?php echo $listDetail->row()->id;?>',mobile_verification_code:mobile_verification_code},
success:function(response)
{ 
if(response=='success')
{
window.location='<?php echo base_url()?>site/experience/redirect_base/payment/<?php echo $listDetail->row()->experience_id;?>';
 }
else{
alert('<?php if($this->lang->line('Verification_Code_Does_not_match_Please_enter_Correct_Code') != '') { echo stripslashes($this->lang->line('Verification_Code_Does_not_match_Please_enter_Correct_Code')); } else echo "Verification Code Does not match Please enter Correct Code";?>');
}

}
}); 

}
</script>   
<!---DASHBOARD-->
<?php
//$this->load->view('site/templates/listing_footer');
 $this->load->view('site/templates/footer');
?>