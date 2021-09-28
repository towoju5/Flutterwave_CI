<?php 
$this->load->view('site/templates/header');
?>
<!--<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-1.5.1.min"></script>-->
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery.colorbox.js"></script>
<script type="text/javascript">
$(document).ready(function(){
			$(".paypal-popup").colorbox({width:"365px", height:"500px", inline:true, href:"#dddddinline_paypal"}); $("#accno").keydown(function (event) {        if (!(event.keyCode == 8                                           || event.keyCode == 9                                          || event.keyCode == 17                                          || event.keyCode == 46                                          || (event.keyCode >= 35 && event.keyCode <= 40)                 || (event.keyCode >= 48 && event.keyCode <= 57)                 || (event.keyCode >= 96 && event.keyCode <= 105)                || (event.keyCode == 65 && prevKey == 17 && prevControl == event.currentTarget.id))             ) {            event.preventDefault();            }           });
});
</script>
<div style='display:none'>
<style>
.modal-backdrop.fade.in{z-index: 999 !important;}  

</style>
<div id='dddddinline_paypal' style='background:#fff;'>
  
  		<div class="popup_page" >
        <img src="<?php echo base_url().'images/site/paypal.png' ?>"  style="margin-top:20px;">
        
       
       <table>
        <tr><td><label><?php if($this->lang->line('Full_Name') != '') { echo stripslashes($this->lang->line('Full_Name')); } else echo "Full Name";?> </label></td></tr>
        <tr><td><input type="text" name="bank_name" id="bank_name" value="<?php echo $userpay->row()->bank_name; ?>" /></td></tr> 
        <tr><td><label><?php if($this->lang->line('Account_Number') != '') { echo stripslashes($this->lang->line('Account_Number')); } else echo " Account Number";?> </label></td></tr>
        <tr><td><input type="text" name="bank_no" id="bank_no" value="<?php echo $userpay->row()->bank_no; ?>" /></td></tr> 
        <tr><td><label> <?php if($this->lang->line('BankCode') != '') { echo stripslashes($this->lang->line('BankCode')); } else echo " Bank Code";?> </label></td></tr>
        <tr><td><input type="text" name="bank_code" id="bank_code" value="<?php echo $userpay->row()->bank_code; ?>" /></td></tr>
        <tr><td><label> <?php if($this->lang->line('paypal_email_new') != '') { echo stripslashes($this->lang->line('paypal_email_new')); } else echo "Paypal Email";?> </label></td></tr>
        <tr><td><input type="text" name="paypal_email" id="paypal_email" value="<?php echo $userpay->row()->paypal_email; ?>" /></td></tr>
        <tr><td>
		<?php if($this->lang->line('Bank_full_name_required') != '')
			{ 
				$bank_name = stripslashes($this->lang->line('Bank_full_name_required')); 
			} 
			else
			{
				$bank_name = "Bank full name required";
			}	
			if($this->lang->line('Bank_number_required') != '')
			{ 
				$bank_number = stripslashes($this->lang->line('Bank_number_required')); 
			} 
			else
			{
				$bank_number = "Bank number required";
			}
			if($this->lang->line('Bank_code_required') != '')
			{ 
				$bank_code = stripslashes($this->lang->line('Bank_code_required')); 
			} 
			else
			{
				$bank_code = "Bank code required";
			}
			if($this->lang->line('Email_id_required') != '')
			{ 
				$email_required = stripslashes($this->lang->line('Email_id_required')); 
			} 
			else
			{
				$email_required = "Email id required";
			}
			?>
		<input type="hidden" value="<?php echo $bank_name; ?>" name="bank_name" id="bank_name">
		<input type="hidden" value="<?php echo $bank_number; ?>" name="bank_number" id="bank_number">
		<input type="hidden" value="<?php echo $bank_code; ?>" name="bank_code" id="bank_code">
		<input type="hidden" value="<?php echo $email_required; ?>" name="email_required" id="email_required">
        <button class="btn btn-block btn-primary large btn-large padded-btn-block" type="submit" onclick="javascript:paypaldetail();" ><?php if($this->lang->line(' Submit') != '') { echo stripslashes($this->lang->line(' Submit')); } else echo "  Submit";?></button>
        
        </td></tr>
       </table>
       
       
        </div>
        
  </div>
  
</div>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor account acc-payout">

  <div class="top-listing-head">
 <div class="main">   
          <?php $this->load->view('site/user/main_nav_header');   ?>
		   </div></div>
  <div class="dash_brd">
      <div id="command_center">
    
           
<div class="lispg_top">
            <?php 
             $this->load->view('site/user/sub_nav_header');  
            ?>
  <div id="account" class="acctpayout_rit listiong-areas">
    <div class="box">
      <div class="middle">

        <div id="payout_setup">
          
            <h2><?php if($this->lang->line('PayoutMethods') != '') { echo stripslashes($this->lang->line('PayoutMethods')); } else echo "Payout Methods";?></h2>
            
              <a data-toggle="modal" href="#myModal" class="btn btn paypal-popup2 cboxElement2" href="#">
			  <?php if($userpay->row()->accname == ''){ ?>
			  <?php if($this->lang->line('add_payout_method') != '') { echo stripslashes($this->lang->line('add_payout_method')); } else echo "Add Payout Method";?>
			  <?php }else{ ?> 
			   <?php if($this->lang->line('view_payout_method') != '') { echo stripslashes($this->lang->line('view_payout_method')); } else echo "View Payout Method";?>
			  <?php } ?></a>
          <a data-toggle="modal" href="#myModal1" class="btn btn paypal-popup2 cboxElement2" href="#">
			  <?php if($userpay->row()->paypal_email == ''){ ?>
			  <?php if($this->lang->line('add_paypal_det_new') != '') { echo stripslashes($this->lang->line('add_paypal_det_new')); } else echo "Add Paypal Details";?>
			  <?php }else{ ?> 
			   <?php if($this->lang->line('view_paypal_det_new') != '') { echo stripslashes($this->lang->line('view_paypal_det_new')); } else echo "View Paypal Details";?>
			  <?php } ?></a>
        </div>
        <div id="taxes"></div>
        </div>
      </div> 
    </div> </div>
         
  </div>
    </div>
</div>











<div id="myModal" class="modal fade in payoutprefer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
 
                <div class="modal-header">
                    <a class="" data-dismiss="modal"><span class="">X</span></a>
                    <h4 class="modal-title" id="myModalLabel"><?php if($this->lang->line('AddPayoutDetails') != '') { echo stripslashes($this->lang->line('AddPayoutDetails')); } else echo "Add Payout Details";?></h4>
                </div>
				<form action="<?php echo base_url(); ?>site/user/account_update" method="post" onsubmit="return validate_form()" accept-charset="UTF-8">
				
				<input type="hidden" name="hid" id="hid" value="<?php echo $userpay->row()->id;?>" />
                <div class="modal-body">
                   <table>
                  <tbody>
                  <tr>
                  <td>
                  <label><?php if($this->lang->line('AccountName') != '') { echo stripslashes($this->lang->line('AccountName')); } else echo "Account Name";?>*</label>
                  </td>
                  </tr>
                  <tr>
                  <td class="payout-bank">
                  <input id="accname" type="text" value="<?php echo $userpay->row()->accname;?>" name="accname" placeholder="<?php if($this->lang->line('account_name_here') != '') { echo stripslashes($this->lang->line('account_name_here')); } else echo "Account name here";?>">
				  <span id="accname_error" style="color:#f00;display:none;">*<?php if($this->lang->line('numbers_only') != '') { echo stripslashes($this->lang->line('numbers_only')); } else echo "Numbers Only";?>!</span>
				  
                  </td>
                  </tr>
                  <tr>
                  <td>
                  <label><?php if($this->lang->line('AccountNumber') != '') { echo stripslashes($this->lang->line('AccountNumber')); } else echo "Account Number";?>*</label>
                  </td>
                  </tr>
                  <tr>
                  <td>
                  <input id="accno" type="text" value="<?php echo $userpay->row()->accno;?>" name="accno" placeholder="<?php if($this->lang->line('account_number_here') != '') { echo stripslashes($this->lang->line('account_number_here')); } else echo "Account number here";?>">
				  
				   <span id="accno_error" style="color:#f00;display:none;">*<?php if($this->lang->line('numbers_only') != '') { echo stripslashes($this->lang->line('numbers_only')); } else echo "Numbers Only";?>!</span>
                  </td>
                  </tr>
                  <tr>
                  <td>
                  <label><?php if($this->lang->line('BankName') != '') { echo stripslashes($this->lang->line('BankName')); } else echo "Bank Name";?>*</label>
                  </td>
                  </tr>
                  <tr>
                  <td class="payout-bank">
                  <input id="bankname" placeholder="<?php if($this->lang->line('enter_bank_name_here') != '') { echo stripslashes($this->lang->line('enter_bank_name_here')); } else echo "Enter bank name here";?>" type="text" name="bankname" value="<?php echo $userpay->row()->bankname;?>" >
				  
				   <span id="bankname_error" style="color:#f00;display:none;">*<?php 
				if($this->lang->line('charecters_only') != '')
			{ 
				echo stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}
			?>!</span>
                  </td>
                  </tr>

				  
		<!-- Update for client side new fields --->
		<tr><td><label> <?php if($this->lang->line('swift_code') != '') { echo stripslashes($this->lang->line('swift_code')); } else echo " SWIFT Code (Non-US Banks Only)";?> </label></td></tr>
        <tr><td class="payout-bank"><input type="text" name="swift_code" id="swift_code" placeholder="<?php if($this->lang->line('enter_swift_code_here') != '') { echo stripslashes($this->lang->line('enter_swift_code_here')); } else echo "Enter swift code here";?>"  value="<?php echo $userpay->row()->swift_code; ?>" /></td></tr>
		
		<tr><td><label> <?php if($this->lang->line('IBAN') != '') { echo stripslashes($this->lang->line('IBAN')); } else echo " IBAN (Non-US Banks Only)";?> </label></td></tr>
        <tr><td class="payout-bank"><input type="text" name="ibnb_code" id="ibnb_code" placeholder="<?php if($this->lang->line('enter_ibnb_code_here') != '') { echo stripslashes($this->lang->line('enter_ibnb_code_here')); } else echo "Enter ibnb code here";?>" value="<?php echo $userpay->row()->ibnb_code; ?>" /></td></tr>
		
		<tr><td><label> <?php if($this->lang->line('sort_routing_code') != '') { echo stripslashes($this->lang->line('sort_routing_code')); } else echo " Routing Code/Sort Code (Non-US Banks Only)";?> </label></td></tr>
        <tr><td class="payout-bank"><input type="text" name="routing_code" id="routing_code" placeholder="<?php if($this->lang->line('enter_routing_code_here') != '') { echo stripslashes($this->lang->line('enter_routing_code_here')); } else echo "Enter Routing Code/Sort Code here";?>" value="<?php echo $userpay->row()->routing_code; ?>" /></td></tr>
		
		<tr><td><label> <?php if($this->lang->line('Currency') != '') { echo stripslashes($this->lang->line('Currency')); } else echo " Currency";?> </label></td></tr>
        <tr><td class="payout-bank">
			<select name="currency_code_bank" id="currency_code_bank" >
			<?php if($active_currency->num_rows() >0){ foreach($active_currency->result() as $currency_s){?>             
  <option value="<?php echo $currency_s->currency_type; ?>" <?php if($currency_s->currency_type==$userpay->row()->currency_code_bank) echo "selected"; ?>><?php echo $currency_s->currency_type; ?></option><?php } } ?>
				
			</select> 
		</td></tr>
		
		<tr><td><label> 	 </label></td></tr>
        <tr><td class="payout-bank">
			<select name="country_code_bank" id="country_code_bank" >
				<?php $active_countries=$active_countries->result();foreach($active_countries as $actcnt) { 
				echo '<option value="'.$actcnt->id.'" '.(($actcnt->id==$userpay->row()->country_code_bank)?"selected":"").'>'.$actcnt->name.'</option>';
				} ?>
			</select> 
		</td></tr>
		<!-- Update for client side new fields --->
		
		
                   <!--tr><td><label> <?php if($this->lang->line(' Paypal_Email') != '') { echo stripslashes($this->lang->line(' Paypal_Email')); } else echo "  Paypal Email";?></label></td></tr>
					<tr><td><input placeholder="<?php if($this->lang->line('enter_paypal_email_here') != '') { echo stripslashes($this->lang->line('enter_paypal_email_here')); } else echo "Enter Paypal email here";?>"  type="email" name="paypal_email" id="paypal_email" value="<?php echo $userpay->row()->paypal_email; ?>" /></td></tr-->
				  
				  
				  
				  
				   <tr>
                  <td>
                  <button type="submit" class="btn btn-block btn-primary large btn-large padded-btn-block"  type="submit"><?php if($this->lang->line('Submit') != '') { echo stripslashes($this->lang->line('Submit')); } else echo "Submit";?></button>
                  </td>
                  </tr>
                  </tbody>
                  </table>
                </div>
                </form>
                </div>
 
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dalog -->
</div><!-- /.modal -->

<div id="myModal1" class="modal fade in payoutprefer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
 
                <div class="modal-header">
                    <a class="" data-dismiss="modal"><span class="">X</span></a>
                    <h4 class="modal-title" id="myModalLabel"><?php if($this->lang->line('add_paypal_det_new') != '') { echo stripslashes($this->lang->line('add_paypal_det_new')); } else echo "Add Paypal Details";?></h4>
                </div>
				<form action="<?php echo base_url(); ?>site/user/account_update" method="post"  accept-charset="UTF-8">
				    <!--onsubmit="return validate_form()" -->
				
				<input type="hidden" name="hid" id="hid" value="<?php echo $userpay->row()->id;?>" />
                <div class="modal-body">
                   <table>
                  <tbody>

                   <tr><td><label> <?php if($this->lang->line(' Paypal_Email') != '') { echo stripslashes($this->lang->line(' Paypal_Email')); } else echo "  Paypal Email";?> * </label></td></tr>
					<tr><td><input placeholder="<?php if($this->lang->line('enter_paypal_email_here') != '') { echo stripslashes($this->lang->line('enter_paypal_email_here')); } else echo "Enter Paypal email here";?>"  type="email" name="paypal_email" id="paypal_email" value="<?php echo $userpay->row()->paypal_email; ?>" required /></td></tr>
				  
				  
				  
				  
				   <tr>
                  <td>
                  <button type="submit" class="btn btn-block btn-primary large btn-large padded-btn-block"  type="submit"><?php if($this->lang->line('Submit') != '') { echo stripslashes($this->lang->line('Submit')); } else echo "Submit";?></button>
                  </td>
                  </tr>
                  </tbody>
                  </table>
                </div>
                </form>
                </div>
 
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dalog -->
</div><!-- /.modal -->
<script>
function validate_form()
{
	var account_number = /^\d{5,}$/;
	var bank_name = /^[\d]*$/;
	
	var entered_acc_no=$("#accno").val();
	
	if($("#accname").val()=="")
	{
		alert("<?php if($this->lang->line('enter_account_name') != '') { echo stripslashes($this->lang->line('enter_account_name')); } else echo "Please enter the account name!";?>");
		$("#accname").focus();
		return false;
	}
	else if($("#accno").val()=="")
	{
		alert("<?php if($this->lang->line('enter_account_number') != '') { echo stripslashes($this->lang->line('enter_account_number')); } else echo "Please enter the account number!";?>");
		$("#accno").focus();
		return false;
	}
	/*else if(!entered_acc_no.match(account_number))
	{
		alert("Please enter the valid account number!");
		$("#accno").focus();
		return false;
	}*/
	else if($("#bankname").val()=="")
	{
		alert("<?php if($this->lang->line('enter_bank_name') != '') { echo stripslashes($this->lang->line('enter_bank_name')); } else echo "Please enter the bank name!";?>");
		$("#bankname").focus();
		return false;
	}
	/*else if(!$("#bankname").val().match(bankname))
	{
		alert("Please enter the valid bank name!");
		$("#bankname").focus();
		return false;
	}*/
	/*if($("#paypal_email").val())
	{
		//alert($("#paypal_email").val());
		var email=$("#paypal_email").val();
		var atpos = email.indexOf("@");
		var dotpos = email.lastIndexOf(".");
		if(email!="" && atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
		{
			alert("Please enter the valid paypal email!");
			$("#paypal_email").focus();
			return false;
		}
	}*/
	
}
</script>

<!---DASHBOARD-->


<script>
$("#accname").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("accname_error").style.display = "inline";
  $("#accname").focus();
  $("#accname_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});

$("#bankname").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z\s]/g)) {
  document.getElementById("bankname_error").style.display = "inline";
  $("#bankname").focus();
  $("#bankname_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});

	
$("#accno").on('keyup', function(e) {
   var val = $(this).val();
    if (val.match(/[^a-zA-Z0-9-\s()]/g)) {
  document.getElementById("accno_error").style.display = "inline";
  $("#accno").focus();
  $("#accno_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z0-9-\s()]/g, ''));
  }
});



</script>

<!---FOOTER-->
<?php 
$this->load->view('site/templates/footer');
?>