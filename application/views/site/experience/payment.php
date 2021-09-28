<?php 
error_reporting(0);
$this->load->view('site/templates/header');
$product=$ProductDetail->row();

$hostCurrency=$product->currency;

?>
<?php

$commission=$hosting_payment_details->row()->commission_percentage;
$promotion_type=$hosting_payment_details->row()->promotion_type;
if($promotion_type=='percentage'){
	$hosting_price=($product->price/100)*$commission;
}else{
	$hosting_price=$commission;
}
define("StripeDetails",$this->config->item('payment_1'));
$StripeValDet = unserialize(StripeDetails); 
$StripeVal = $StripeValDet['status'];
$StripeValDet1=unserialize($StripeValDet['settings']);
?>
<input type="hidden" id="rental_id" value="<?php echo $product->id; ?>" />
<script type="text/javascript" src="js/site/SpryTabbedPanels.js"></script>
<script type="text/javascript" src="javascript/autocomplete/jquery-ui-1.8.2.custom.min.js"></script> 
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
// This identifies your website in the createToken call below
Stripe.setPublishableKey('<?php echo $StripeValDet1['publishable_key']; ?>');
</script>
<script>
jQuery(function($) {
	$('#stripe-pay-button').click(function(event) {
		
		//credit_card_form_func();

		var terms = document.getElementById("terms").checked;
		if(terms == false)
		{
			$("#terms_warn").html('<br><span style="color:red;">To Proceed click check box</span>');
			return false;
		}
		else if(terms == true)
		{
			$("#terms_warn").html('');
		}
		$('#error').fadeOut();
		var $form = $("#credit_card_forms_stripe");
		
		$form.find('.loading').text('<?php if($this->lang->line('Please wait your transaction on process') != '') { echo stripslashes($this->lang->line('Please wait your transaction on process')); } else echo "Please wait your transaction on process";?>');
		$('#loading').fadeIn;
		// Disable the submit button to prevent repeated clicks
		$form.find('button').prop('disabled', true);
		Stripe.createToken($form, stripeResponseHandler);
		
		// Prevent the form from submitting with the default action
		return false;
		
	});
});
var stripeResponseHandler = function(status, response) {
	$('#loading').fadeOut();
	var $form = $('#credit_card_forms_stripe');
	
	if (response.error) {
		// Show the errors on the form
		$form.find('.payment-errors').text('<?php if($this->lang->line('Sorry! please check') != '') { echo stripslashes($this->lang->line('Sorry! please check')); } else echo "Sorry! please check";?> '+response.error.message);
		$('#error').fadeIn();
		setTimeout(function(){
		$('#error').fadeout();
		},3000);
		$form.find('button').prop('disabled', false);
	} else {
		// token contains id, last4, and card type
		var token = response.id;
		// Insert the token into the form so it gets submitted to the server
		$form.append($('<input type="hidden" name="stripeToken" />').val(token));
		// and submit
		$form.get(0).submit();
	}
};
</script>
<!---DASHBOARD-->
<div class="dashboard paymntoptionpg">
	<div class="main">
        <div class="payment_main">
            <div class="payment_user">
                <div class="payment_box">
					<h1><?php if($this->lang->line('Payment options') != '') { echo stripslashes($this->lang->line('Payment options')); } else echo "Payment options";?></h1>
					<div id="TabbedPanels1" class="TabbedPanels">
						<ul class="TabbedPanelsTabGroup">
							<li class="TabbedPanelsTab " tabindex="0" onclick="return submit_button1('CreditCard');"><?php if($this->lang->line('Stripe Credit card') != '') { echo stripslashes($this->lang->line('Stripe Credit card')); } else echo "Stripe Credit card";?></li>
							<li class="TabbedPanelsTab " tabindex="0" onclick="return submit_button2('Paypal');"><?php if($this->lang->line('Paypal') != '') { echo stripslashes($this->lang->line('Paypal')); } else echo "Paypal";?></li>
						</ul>
						<div class="TabbedPanelsContentGroup">
							<form method="post" action="site/experience/GuidePaymentCredit" id="credit_card_forms_stripe" accept-charset="UTF-8">
							<input type="hidden" name="payment_method" id="payment_method" value="CreditCard">
							<input type="hidden" name="commission" id="commission" value="<?php echo $commission; ?>">
							<input type="hidden" name="commission_type" id="commission_type" value="<?php echo $promotion_type; ?>">
							<input type="hidden" name="hosting_price" id="hosting_price" value="<?php echo $hosting_price;?>">
							<input type="hidden" name="amount" value="<?php echo $hosting_price; //echo ($product->price * $product->numofdates);?>" id="totprice" />
							
							
							
								<div class="payment_detail_method">
								<?php /*
									<div class="payment_left">
										<input type="hidden" name="stripe_mode" id="stripe_mode" value="<?php echo $StripeValDet1['mode']; ?>"  />
										<input type="hidden" name="stripe_key" id="stripe_key" value="<?php echo $StripeValDet1['secret_key']; ?>"  />
										<input type="hidden" name="stripe_publish_key" id="stripe_publish_key" value="<?php echo $StripeValDet1['publishable_key']; ?>"  />
										<label><?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "First Name";?></label>
										<input type="text" value="<?php echo $BookingUser->firstname; ?>" id="firstname" name="firstname" style="width:138px;" size="30"  />
										<label><?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Last Name";?></label>
										<input type="text" value="<?php echo $BookingUser->lastname; ?>" id="lastname" name="lastname" style="width:138px;" size="30"  />
										<label><?php if($this->lang->line('Street Address') != '') { echo stripslashes($this->lang->line('Street Address')); } else echo "Street Address";?></label>
										<input type="text" value="<?php echo $BookingUser->UserAddress; ?>" size="30" id="address" name="address"  />
										<label><?php if($this->lang->line('Apt, Suite, Bldg (optional)') != '') { echo stripslashes($this->lang->line('Apt, Suite, Bldg (optional)')); } else echo "Apt, Suite, Bldg (optional)";?></label>
										<input type="text" id="suite" name="suite" size="30"  />
										<label><?php if($this->lang->line('City') != '') { echo stripslashes($this->lang->line('City')); } else echo "City";?></label>
										<input type="text" id="city" name="city" value="<?php echo $BookingUser->UserCity; ?>" style="width:151px;" size="30"  />
										<label><?php if($this->lang->line('State') != '') { echo stripslashes($this->lang->line('State')); } else echo "State";?></label>
										<input type="text" id="state" name="state" value="<?php echo $BookingUser->UserState; ?>" style="width:40px;" size="30"  />
										<label><?php if($this->lang->line('Postal Code') != '') { echo stripslashes($this->lang->line('Postal Code')); } else echo "Postal Code";?></label>
										<input type="text" id="postal_code" name="postal_code" value="" style="width:75px;" size="30"  /><span style="margin-left:10px;"><b></b></span>
									</div>
									
									*/?>
									<div  class="payment_right">
									
									<h4 id="terms_warn"></h4>
									<?php

		$admin=$this->user_model->get_all_details (ADMIN,array('admin_type'=>'super'));
		$data=$admin->row();
		//print_r($data=$admin->row());
		$admin_currencyCode=trim($data->admin_currencyCode);
		$listingAmount = $hosting_price;

	if($this->session->userdata('currency_type') != $admin_currencyCode){
		    $listingAmount1=convertCurrency($admin_currencyCode,$this->session->userdata('currency_type'),$listingAmount);
		}else{
		    $listingAmount1=$listingAmount;
		}
									 ?>
									
									<p>The Amount for this listing is  :  <?php echo $this->session->userdata('currency_type') . " " .$listingAmount1; ?></p>
									
									<!-- validatation for currency-->
									<?php //if ($this->session->userdata('currency_type')!=$hostCurrency) { ?>
									<!--<span style="color:red"><?php //echo "Please Change Currency into " . $hostCurrency;?> </span>-->
									<?php //} ?>
									<!-- validatation for currency-->
									
									
										<label><?php if($this->lang->line('Card Type') != '') { echo stripslashes($this->lang->line('Card Type')); } else echo "Card Type"; ?></label>
										<select id="cardType" name="cardType" class="select-round select-white select-country selectBox required">
											<option value="Visa"><?php if($this->lang->line('Visa') != '') { echo stripslashes($this->lang->line('Visa')); } else echo 'Visa'; ?></option>
											<option value="Amex"><?php if($this->lang->line('American Express') != '') { echo stripslashes($this->lang->line('American Express')); } else echo 'American Express'; ?></option>
											<option value="MasterCard"><?php if($this->lang->line('MasterCard') != '') { echo stripslashes($this->lang->line('MasterCard')); } else echo 'MasterCard'; ?></option>
											<option value="Discover"><?php if($this->lang->line('Discover') != '') { echo stripslashes($this->lang->line('Discover')); } else echo 'Discover'; ?></option>
										</select>
										<div style="position:relative;" class="pypg_lb">
											<label><?php if($this->lang->line('Credit Card Number') != '') { echo stripslashes($this->lang->line('Credit Card Number')); } else echo "Credit Card Number"; ?></label>
											<input  maxlength="16" id="cardNumber" name="cardNumber" type="text" style="width:100%; margin-top:5px;" autocomplete="off" data-stripe="number"/>
										</div>
										<label><?php if($this->lang->line('Expiration Date') != '') { echo stripslashes($this->lang->line('Expiration Date')); } else echo "Expiration Date"; ?></label>
										
										<?php $Sel ='selected="selected"';  ?>
										
										<select id="CCExpDay" name="CCExpDay" style="width:46%; margin: 0 12px 0 0 !important;" class="select-round select-white select-date selectBox required" data-stripe="exp-month">
										
										
											<option value="01" <?php if(date('m')=='01'){ echo $Sel;} ?>>01</option>
											<option value="02" <?php if(date('m')=='02'){ echo $Sel;} ?>>02</option>
											<option value="03" <?php if(date('m')=='03'){ echo $Sel;} ?>>03</option>
											<option value="04" <?php if(date('m')=='04'){ echo $Sel;} ?>>04</option>
											<option value="05" <?php if(date('m')=='05'){ echo $Sel;} ?>>05</option>
											<option value="06" <?php if(date('m')=='06'){ echo $Sel;} ?>>06</option>
											<option value="07" <?php if(date('m')=='07'){ echo $Sel;} ?>>07</option>
											<option value="08" <?php if(date('m')=='08'){ echo $Sel;} ?>>08</option>
											<option value="09" <?php if(date('m')=='09'){ echo $Sel;} ?>>09</option>
											<option value="10" <?php if(date('m')=='10'){ echo $Sel;} ?>>10</option>
											<option value="11" <?php if(date('m')=='11'){ echo $Sel;} ?>>11</option>
											<option value="12" <?php if(date('m')=='12'){ echo $Sel;} ?>>12</option>
										</select>
										<select id="CCExpMnth" name="CCExpMnth" style="width:46%;" class="select-round select-white select-date selectBox required" data-stripe="exp-year">
										<?php for($i=date('Y');$i< (date('Y') + 30);$i++){ ?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php } ?>
										</select>
										<input type="hidden" value="stripe" name="creditvalue" />
										<input type="hidden" value="<?php echo $hosting_price; ?>" name="total_price" />
										<input type="hidden" value="<?php echo $product->experience_id; ?>" name="booking_rental_id" />
										
										<label><?php if($this->lang->line('Security Code') != '') { echo stripslashes($this->lang->line('Security Code')); } else echo "Security Code"; ?></label>
										<input id="payment-card-security" name="creditCardIdentifier" type="password" style="width:46%; padding: 5px;" size="4" autocomplete="off" />
										<div id="error" style="color:red;" class="payment-errors"></div>
										<div id="loading" style="color:green;" class="loading"></div>
									</div>
								</div>
							</form>
							
							<div class="TabbedPanelsContent">
							<div class="currency_alert"><?php if($this->lang->line('This payment transacts in') != '') { echo stripslashes($this->lang->line('This payment transacts in')); } else echo "This payment transacts in";?> <?php echo $currencySymbol?> <?php

		                    if($this->session->userdata('currency_type') != 'USD'){
								echo convertCurrency('USD',$this->session->userdata('currency_type'),$hosting_price);
		                    }else{
		                     	 echo  $hosting_price;
		                    }
		                     ?>.</div>
							 
							 
							 
							 <?php //if ($this->session->userdata('currency_type')!=$hostCurrency) { ?>
								<!--	<span style="color:red"><?php// echo "Please Change Currency into " . $hostCurrency;?> 
									</span>-->
							 <?php //} ?>
							 
							 
							<p class="payment_method_paypal"><span style="font-weight:bold;"><?php if($this->lang->line('Instructions') != '') { echo stripslashes($this->lang->line('Instructions')); } else echo "Instructions";?>:</span><br><?php if($this->lang->line('After clicking Book it you will be redirected to PayPal to authorize the payment') != '') { echo stripslashes($this->lang->line('After clicking Book it you will be redirected to PayPal to authorize the payment')); } else echo "After clicking Book it you will be redirected to PayPal to authorize the payment";?>.<span style="font-weight:bold;"><?php if($this->lang->line('You must complete the process or the transaction will not occur') != '') { echo stripslashes($this->lang->line('You must complete the process or the transaction will not occur')); } else echo "You must complete the process or the transaction will not occur";?>.</span></p></div>
							<script type="text/javascript">
								var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
							</script>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="payment_agree" style="padding-bottom:10px;">
				
					
					
					
					<p>
                    <input type="checkbox" style="float:left; width:25px;" id="terms" required>
					<label for="agrees_to_terms"><?php if($this->lang->line('I agree to the') != '') { echo stripslashes($this->lang->line('I agree to the')); } else echo "I agree to the";?> <a target="_blank" class="terms_link" href="<?php echo base_url();?>pages/terms-of-service"><?php if($this->lang->line('terms of service') != '') { echo stripslashes($this->lang->line('terms of service')); } else echo "terms of service";?></a>.<br><span id="terms_warn" style="color:red;"></span></label></p>
					
					<input type="submit" style="margin:10px 0 0 10px;" id="stripe-pay-button" value="<?php if($this->lang->line('Book it using Credit Card') != '') { echo stripslashes($this->lang->line('Book it using Credit Card')); } else echo "Book it using Credit Card";?>"  class="btn large green">
					
				
					
					
					</span>
					
					
					
					
					<div style="display:none" id="paypal_but" >
					
					
					<input type="submit" id="paypal" style="margin:10px 0 0 10px;" onclick="paypal_form();" value="<?php if($this->lang->line('Book it using Paypal') != '') { echo stripslashes($this->lang->line('Book it using Paypal')); } else echo "Book it using Paypal";?>"  class="btn large green">
					
					
					
					
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="dashboard_bottom">
		<div class="main">
			<ul class="dashboard_links">
				<li class="center">
					<div class="trust_box"><img src="images/site/trust.jpg" width="73" height="70" /></div>
					<h3><?php if($this->lang->line('Trust & Safety') != '') { echo stripslashes($this->lang->line('Trust & Safety')); } else echo "Trust & Safety";?></h3>
					<p><?php if($this->lang->line('World-class security & communications features mean you never have to accept a booking unless you re 100% comfortable') != '') { echo stripslashes($this->lang->line('World-class security & communications features mean you never have to accept a booking unless you re 100% comfortable')); } else echo "World-class security & communications features mean you never have to accept a booking unless you're 100% comfortable";?>.</p>
				</li>
				<li class="center">
					<div class="trust_box trust_shadow"><img src="images/host_guarantee.png" width="80%" height="" /></div>
					<h3><?php if($this->lang->line('$1,000,000 Host Guarantee') != '') { echo stripslashes($this->lang->line('$1,000,000 Host Guarantee')); } else echo "$1,000,000 Host Guarantee";?></h3>
					<p><?php if($this->lang->line('Your peace of mind is priceless. So we don t charge for it. Every single booking on Rental-ya is covered by our Host Guarantee - at no cost to you') != '') { echo stripslashes($this->lang->line('Your peace of mind is priceless. So we don t charge for it. Every single booking on Rental-ya is covered by our Host Guarantee - at no cost to you')); } else echo "Your peace of mind is priceless. So we don't charge for it. Every single booking on Rental-ya is covered by our Host Guarantee - at no cost to you";?>.</p>
				</li>
				<li class="center">
					<div class="trust_box"><img src="<?php echo base_url(); ?>images/site/host_couple.jpg" width="73" height="70" /></div>
                    <h3><?php if($this->lang->line('Secure Payments') != '') { echo stripslashes($this->lang->line('Secure Payments')); } else echo "Secure Payments";?></h3>
					<p><?php if($this->lang->line('Our fast, flexible payment system puts money in your bank account 24 hours after guests check in') != '') { echo stripslashes($this->lang->line('Our fast, flexible payment system puts money in your bank account 24 hours after guests check in')); } else echo "Our fast, flexible payment system puts money in your bank account 24 hours after guests check in";?>.</p>
				</li>
			</ul>
		</div>
	</div>
</div>
<!---DASHBOARD-->

<input type="hidden" id="sess_cur" value="<?php echo $this->session->userdata('currency_type');  ?>">
<input type="hidden" id="host_cur" value="<?php echo $hostCurrency;?>">

<script type="text/javascript">
function credit_card_form_func()
{ 
	var caltophone=jQuery("input:radio[name=caltophone]:checked").val();
	var terms = document.getElementById("terms").checked;
	/*		
	cardType
	cardNumber
	CCExpDay
	CCExpMnth
	*/
	var cardNumber=jQuery("input[name=cardNumber]").val().trim();
	var CCExpDay=jQuery("select[name=CCExpDay]").val();
	var CCExpMnth=jQuery("select[name=CCExpMnth]").val();
	
	var d = new Date();
	var m = d.getMonth();
	var Y = d.getFullYear();
	err=0;
	if(parseInt(Y)<=CCExpMnth){
		if(parseInt(m)<=parseInt(CCExpDay)){
			
		}else{
			err=1;
		}
	}else{
		err=1;
	}
	err_c=0;
	if(cardNumber.length<16){
		err_c=1;
	}
	
	if(cardNumber=='' || CCExpDay=='' || CCExpMnth=='' || err==1 || err_c==1){
		if(err==1){
			$('#terms_warn').html('<p style="color:#F00; margin-right:3px;">Please fill valid data and check the Expiration Date</p> ');
		}else if(err_c==1){
			$('#terms_warn').html('<p style="color:#F00; margin-right:3px;">Please Enter valid card number</p> ');
		}else{
			$('#terms_warn').html('<p style="color:#F00; margin-right:3px;">Please fill valid data</p> ');
		}
		$('#terms_warn').show().delay('3000').fadeOut();
		return false;
	}else if(terms == true){
			document.getElementById("credit_card_form").submit();
	}else{
			$('#terms_warn').html('<p style="color:#F00; margin-right:3px;">Fill all fields</p> ');
			$('#terms_warn').show().delay('3000').fadeOut();
			return false;
	}
	
}

function paypal_form()
{
	
	var caltophone=jQuery("input:radio[name=caltophone]:checked").val();
	var terms = document.getElementById("terms").checked;

	
	var product = <?php echo $this->uri->segment(5);?>;
	var amount = $('#totprice').val();
	
	 if(terms == true)
		{//alert("sdds");
		/*
			$.ajax({
			type:'POST',
			url:'site/experience/edit_enquiry_details',
			data:{'rental_id':$('#rental_id').val(),'Enquiry':$('#Enquiry').val(),'caltophone':caltophone,'phone_no':$('#phone_no').val(),'enquiry_timezone':$('#enquiry_timezone').val()},
			dataType:'json',
			success:function(json){
			//alert(json);
				window.location = BaseURL+"site/product/HostPayment/"+product+"/"+amount;
			}
		}); */
			window.location = BaseURL+"site/experience/GuidePayment/"+product+"/"+amount;
		}
	else
		{
			$('#terms_warn').html('<p style="color:#F00; margin-right:3px;">This field is required</p> ');
			$('#terms_warn').show().delay('3000').fadeOut();
			return false;
		}
}
function updateenqueryDetails(){
		$.ajax({
			type:'POST',
			url:'site/experience/edit_enquiry_details',
			data:{'rental_id':$('#rental_id').val(),'Enquiry':$('#Enquiry').val(),'enquiry_timezone':$('#enquiry_timezone').val()},
			dataType:'json',
			success:function(json){
			//alert(json.val);
				//return;
			}
		});
		
}
function submit_button1(method)
{
	$('#paypal').hide();
	$('#stripe-pay-button').show();
	$('#payment_method').val(method);
}

function submit_button2(method)
{
	$('#payment_method').val(method);
	$('#stripe-pay-button').hide();
	$('#paypal').show();
	$('#paypal_but').css('display', 'block');
	
	/* var sess_cur=$("#sess_cur").val();
	var host_cur=$("#host_cur").val();	
	if(sess_cur==host_cur){
	$('#paypal_but').css('display', 'block');
	}  currency validation*/
}

</script>

<script type="text/javascript" src="js/1.8-jquery-ui-min.js"></script>
<link rel="stylesheet" type="text/css" href="javascript/autocomplete/jquery-ui-1.8.2.custom.css" media="all" />
<script type="text/javascript" src="javascript/autocomplete/jquery-ui-1.8.2.custom.min.js"></script> 
<?php
$this->load->view('site/templates/footer');
?>