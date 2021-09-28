<?php 
$this->load->view('site/templates/header');
?>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor account acc-setting">

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
        <form method="post" action="account-setting" accept-charset="UTF-8" id="dashboard_account_setting"><div class="emptydiv_actsetting" style="margin:0;padding:0;display:inline"></div>
          <h2><?php echo $heading;?></h2>
          <div class="section notification_section">
            <div class="notification_area">
              
              <div class="notification_action">


              
               
                <table class="password-fields">
                    <tbody><tr>
					<td id="cntryrsdnc_lbl"><?php if($this->lang->line('CountryofResidence') != '') { echo stripslashes($this->lang->line('CountryofResidence')); } else echo "Country of Residence";?>:<!--<i class="questn">
              <span class="verifi">
              Verifications help build trust between guests and hosts and can make booking easier.
              <i class="arsd-ico rot"></i>
              <a href="#">Learn more »</a>
              </span>
              </i>--></td><td>
					<select id="country" name="country" onchange="javascript:changebotton();">
					<option value="" ><?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select";?></option>
					<?php foreach ($countries->result() as $country):?>
					<option  value="<?php echo $country->id;?>" <?php if($userDetails->row()->country==$country->id){?>selected="selected"<?php }?>><?php echo $country->name;?></option>
					<?php endforeach;?>
					</select>

					
                    <div id="old_password_warn"  style="float:right; color:#FF0000;"></div>
					<br><div id="message"  style=""><?php if($this->lang->line('Select and save country of residence to confirm') != '') { echo stripslashes($this->lang->line('Select and save country of residence to confirm')); } else echo "Select and save country of residence to confirm";?></div></td>
					</td>
					
					<span style="float:right;" class="error" id="country_warn"></span>
					</tr>
                  </tbody></table>

                       
              </div>
            </div>
            <div class="buttons">
              <input id="change_button" type="button" disabled="true" value="<?php if($this->lang->line('ResidenceClicksave') != '') { echo stripslashes($this->lang->line('ResidenceClicksave')); } else echo "Save Country of Residence";?>"  onclick="return dashboard_account_setting();" name="commit" class="invitefrds">
            </div>
          </div>
</form>
      

        
      </div>
    </div>















    <div class="box cancel-account">
      <div class="middle">
       
          <h2><?php if($this->lang->line('CancelAccount') != '') { echo stripslashes($this->lang->line('CancelAccount')); } else echo "Cancel Account";?></h2>
          <div class="section notification_section">
            <div class="notification_area">
              
              <div class="notification_action">


             <!-- <a href="site/cms/cancelmyaccount/<?php //echo $userDetails->row()->id; ?>"> <input type="button" value="<?php //if($this->lang->line('CancelAccount') != '') { echo stripslashes($this->lang->line('CancelAccount')); } else echo "Cancel Account";?>"  class="invitefrds"></a>-->
			  
			  
			  <input type="button" onclick="checkConfirmation();" value="<?php if($this->lang->line('CancelAccount') != '') { echo stripslashes($this->lang->line('CancelAccount')); } else echo "Cancel Account";?>"  class="invitefrds">
			  
			  
			  
			  
			  
              </div>
            </div>
            
          </div>

      

        <div class="clearfix"></div>
      </div>
    </div>


  </div></div>
         
  </div>
    </div>
</div>
<script type="text/javascript">
function dashboard_account_setting()
{
$('#country_warn').text('');
var country=$('#country').val();
if(country=='')
{
$('#country_warn').text('<?php if($this->lang->line('Please_Select_Country') != '') { echo stripslashes($this->lang->line('Please_Select_Country')); } else echo "Please Select Country";?>');
return false;
}
else
{
$('#dashboard_account_setting').submit();
}
}
		
	 
function removeError(idval){
	$("#"+idval+"_warn").html('');}
	
function changebotton(){
	$("#change_button").removeAttr('disabled');
	}
</script>
<!---DASHBOARD-->

<script type="text/javascript">
function checkConfirmation(){
	if (confirm("<?php if($this->lang->line('want_to_cancel') != '') { echo stripslashes($this->lang->line('want_to_cancel')); } else echo "Are You Sure Want to cancel your Account.?";?>")){
		window.location.href="site/cms/cancelmyaccount/<?php echo $userDetails->row()->id; ?>";
	}else{
		window.location.reload();
	}
}
</script>
<!---FOOTER-->
<?php 
$this->load->view('site/templates/footer');
?>