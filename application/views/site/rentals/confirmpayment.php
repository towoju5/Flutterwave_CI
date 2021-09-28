<?php 
$this->load->view('site/templates/header');
$product = $productList->row();
$BookingUser = $BookingUserDetails->row();
$servicetax = $service_tax->row();
$country = $countryList;

/**Start - Get Payments Gateway is Enabled**/
define("paypal",$this->config->item('payment_0'));
$paypal = unserialize(paypal); 
$paypalVal = $paypal['status'];

define("StripeDetails",$this->config->item('payment_1'));
$StripeValDet = unserialize(StripeDetails); 
$StripeVal = $StripeValDet['status'];
$StripeValDet1=unserialize($StripeValDet['settings']);

define("creditcard",$this->config->item('payment_2'));
$creditcard = unserialize(creditcard);
$creditCard_payment = $creditcard['status'];

/**End - Get Payments Gateway is Enabled **/
?>


<?php if($creditCard_payment !='Disable' && $StripeVal != 'Disable' && $paypalVal !='Disable') { ?> 
<script type="text/javascript">
$(document).ready(function () {
	$('#credit_card_forms_stripe').hide();
    $('#credit_card_forms_stripe').hide();
    $('#pay-with-stripe').hide();
    $('.pad').hide();
	
	
/*     $('.heading').click(function () {
        $(this).next('.pad').slideToggle();
        if($(this).find('.span1').attr('id') == 'yes') {
            $(this).find('.span1').attr('id', '').html('<i class="fa fa-chevron-down" aria-hidden="true"></i>');
        } else {
            $(this).find('.span1').attr('id', 'yes').html('<i class="fa fa-chevron-down" aria-hidden="true"></i>');
        }
    }); */
	
	
});
</script>
<?php } ?>

<?php if($creditCard_payment !='Disable' || $StripeVal != 'Disable' || $paypalVal !='Disable') { ?> 

<script type="text/javascript">
$(document).ready(function () {	
    $('.heading').click(function () {
        $(this).next('.pad').slideToggle();
        if($(this).find('.span1').attr('id') == 'yes') {
            $(this).find('.span1').attr('id', '').html('<i class="fa fa-chevron-down" aria-hidden="true"></i>');
        } else {
            $(this).find('.span1').attr('id', 'yes').html('<i class="fa fa-chevron-down" aria-hidden="true"></i>');
        }
    });
	
	
});
</script>

<?php } ?>

<script type="text/javascript">
$(document).ready(function () {
    $('.pad1').hide();
    $('.heading1').click(function () {
        $(this).next('.pad1').slideToggle();
        if($(this).find('.span2').attr('id') == 'yes') {
            $(this).find('.span2').attr('id', '').html('&#8744;');
        } else {
            $(this).find('.span2').attr('id', 'yes').html('&#8743;');
        }
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).attr("value")=="red"){
                $(".red").toggle();
            }
        });
    });
</script>
<input type="hidden" id="rental_id" value="<?php echo $product->id; ?>" />
<script type="text/javascript" src="js/site/SpryTabbedPanels.js"></script>
<section>
	<div class="payment-container paymode-container">
		<div class="container">
			<?php $ipayuser = $this->product_model->get_all_details(USERS,array('id'=>$BookingUserDetails->row()->userid)); ?>
			<div class="payment-section1" style="display:block;">
				<div class="payed-container">
				
				
				<?php if($creditCard_payment !='Disable' || $StripeVal != 'Disable' || $paypalVal !='Disable') { ?> 
				
					<article class="pay-head">
						<span><?php if($this->lang->line('Howwouldyou') != '') { echo stripslashes($this->lang->line('Howwouldyou')); } else echo "How would you like to pay?";?> </span>
					</article>
					
				<?php } else { ?>	
				
					<article class="pay-head">
						<span>No Payment Method is Available</span>
					</article>
				
				<?php } ?>
					
					<div class="over-view-details">
						<ul class="coupn-list-cont">


					<?php if($creditCard_payment !='Disable' || $StripeVal != 'Disable' || $paypalVal !='Disable') { ?> 

							<li>
								<form id="myFormmm" name="myForm" onsubmit="return validateForm();" method="POST" accept-charset="UTF-8">
								<span class="heading copncode"><?php if($this->lang->line('Doyouhave') != '') { echo stripslashes($this->lang->line('Doyouhave')); } else echo "Do you have Coupon code?";?><span class="span1" style="float:right;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></span>
								
								<div id="occ" class="pad" style="display:none;"><br />
									<input type="text" name="couponcode" id="couponcode" placeholder="<?php if($this->lang->line('Coupon Code') != '') { echo stripslashes($this->lang->line('Coupon Code')); } else echo "Coupon Code";?>"  />&nbsp; &nbsp;
									<input type="hidden" id="huser_id" name="huser_id" value="<?php echo $product->user_id;?>">
									<input type="hidden" name="total" id="total" value="<?php echo $subtotal+$tax_price; ?>"/>
									<input type="button" class="filter-btn" value="<?php if($this->lang->line('Apply') != '') { echo stripslashes($this->lang->line('Apply')); } else echo "Apply";?>" onclick="mycoupon();">
									<br />
									<p id="totals"></p>
									<p id="disper"></p>
									<p id="disamount"></p>
								</div>
								</form>
							</li>
					<?php } ?>
					
							
							

							<!-- wallet  payment-->
							
							<li  <?php if($userWallet->row()->referalAmount<=0) { echo "style='display:none;'" ;}?> >

							
							
								<input type="checkbox"  onclick="myWallet();" id="wallet_pay"  name="wallet_pay"></checkbox>
								
								
								
								
								
								<label for='wallet_pay'><span class="credit-card" style="text-transform: capitalize;"><?php if($this->lang->line('Use_Wallet') != '') { echo stripslashes($this->lang->line('Use_Wallet')); } else echo "Use Wallet";?> ( <?php echo $currencySymbol;  echo convertCurrency($userWallet->row()->referalAmount_currency,$this->session->userdata('currency_type'),$userWallet->row()->referalAmount);?> )</span></label>

								<form id="wallet_form" name="myForm" action="site/checkout/PaymentWallet"   method="POST" accept-charset="UTF-8">

									<input type="hidden" name="wallet" id="w_wallet" value="<?php  echo convertCurrency($userWallet->row()->referalAmount_currency,$datavalues->row()->currencycode,$userWallet->row()->referalAmount);?>" />
									<input type="hidden" name="total_price" id="w_price" value="<?php echo $datavalues->row()->totalAmt; ?>" />
									<input type="hidden" name="sumtotal" id="w_sum"  value="<?php echo $datavalues->row()->totalAmt; ?>" />
									<input type="hidden" name="indtotal" id="w_ind"  value="<?php echo $datavalues->row()->totalAmt; ?>" />	

									<input type="hidden" value="<?php  echo $datavalues->row()->currencycode;  ?>" id="_price_val_authorize" name="currencycode" />
									<input type="hidden" value="<?php echo $product->id; ?>" name="booking_rental_id" />

									<input type="hidden" name="enquiryid" value="<?php echo $this->uri->segment(4); ?>" />

								</form>	

								<p id="w_totals"></p>
								<p id="w_disper"></p>
								<p id="w_disamount"></p>

							</li>
							
							<!-- wallet payment ends -->

						
							
							<?php if($creditCard_payment !='Disable') { ?>
							<li>
								<input type="radio" checked="checked" onclick="myFunction();"  name="pay"><span class="credit-card" style="text-transform: capitalize;"><?php if($this->lang->line('Credit card') != '') { echo stripslashes($this->lang->line('Credit card')); } else echo "Credit card";?></span>
								<form method="post" onsubmit="return form_validation_creditcard();" action="site/checkout/PaymentCredit" id="credit_card_forms">
								<div style="display:none">
									<label><?php if($this->lang->line('Street Address') != '') { echo stripslashes($this->lang->line('Street Address')); } else echo "Street Address";?></label>
									<input type="hidden" value="chennai" size="30" id="address" name="address"  />
									<label><?php if($this->lang->line('Apt, Suite, Bldg (optional)') != '') { echo stripslashes($this->lang->line('Apt, Suite, Bldg (optional)')); } else echo "Apt, Suite, Bldg (optional)";?></label>
									<input type="hidden" id="suite" name="suite" size="30"  />
									<label><?php if($this->lang->line('City') != '') { echo stripslashes($this->lang->line('City')); } else echo "City";?></label>
									<input type="hidden" id="city" name="city" value="minjur" style="width:151px;" size="30"  />
									<label><?php if($this->lang->line('State') != '') { echo stripslashes($this->lang->line('State')); } else echo "State";?></label>
									<input type="hidden" id="state" name="state" value="tamilnadu" style="width:40px;" size="30"  />
									<label><?php if($this->lang->line('Postal Code') != '') { echo stripslashes($this->lang->line('Postal Code')); } else echo "Postal Code";?></label>
									<input type="hidden" id="postal_code" name="postal_code" value="<?php echo $BookingUser->UserPostCode; ?>" style="width:75px;" size="30"  /><span style="margin-left:10px;"><b><?php echo $BookingUser->UserCountry; ?></b></span>
								</div>
								<div  class="payment_right">
									<p id="cc_error_msg" style="color:red;"></p>
									<label><?php if($this->lang->line('Card Type') != '') { echo stripslashes($this->lang->line('Card Type')); } else echo "Card Type"; ?></label>
									<select id="cardType" name="cardType">
										<option value="visa"><?php if($this->lang->line('Visa') != '') { echo stripslashes($this->lang->line('Visa')); } else echo "Visa"; ?></option>
										<option value="mastercard"><?php if($this->lang->line('MasterCard') != '') { echo stripslashes($this->lang->line('MasterCard')); } else echo "MasterCard"; ?></option>
										<option value="american_express"><?php if($this->lang->line('American Express') != '') { echo stripslashes($this->lang->line('American Express')); } else echo "American Express"; ?></option>
										<option value="discover"><?php if($this->lang->line('Discover') != '') { echo stripslashes($this->lang->line('Discover')); } else echo "Discover"; ?></option>
									</select>
									<div style="position:relative;">
										<label><?php if($this->lang->line('Credit Card Number') != '') { echo stripslashes($this->lang->line('Credit Card Number')); } else echo "Credit Card Number"; ?></label>
										<input  id="cardNumber" name="cardNumber" type="text" value="" style="" autocomplete="off" />
										
									</div>
									<label style="display: -webkit-box;"><?php if($this->lang->line('Expiration Date') != '') { echo stripslashes($this->lang->line('Expiration Date')); } else echo "Expiration Date"; ?></label>
									<select id="CCExpDay" name="CCExpDay" style=" ">
										<?php for($i=1;$i<13;$i++)
										{
											echo '<option value="'.$i.'">'.$i.'</option>';
										}?>
									</select>
									<select id="CCExpMnth" name="CCExpMnth"  style="">
										<?php for($i=date('Y');$i< (date('Y') + 25);$i++){ ?>	
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php } ?>    
									</select>
									<input type="hidden" value="authorize" name="creditvalue" />
									<input type="hidden" value="<?php  echo $datavalues->row()->totalAmt;  ?>" id="price_val_authorize" name="total_price" />
									<input type="hidden" value="<?php  echo $datavalues->row()->currencycode;  ?>" id="_price_val_authorize" name="currencycode" />
									<input type="hidden" value="<?php echo $product->id; ?>" name="booking_rental_id" />
									<label><?php if($this->lang->line('Security Code') != '') { echo stripslashes($this->lang->line('Security Code')); } else echo "Security Code"; ?></label>
									<input id="payment-card-security" name="creditCardIdentifier" type="password" style="display:block;" value="" size="4" autocomplete="off" />
									<input type="hidden" name="enquiryid" value="<?php echo $this->uri->segment(4); ?>" />
								</div>
								</form>
							</li>
							<?php } 
							

							if($StripeVal != 'Disable') { ?>
							<li>
							
							<?php if($creditCard_payment !='Disable' && $StripeVal != 'Disable' && $paypalVal !='Disable') { ?> 
							<input type="radio"   onclick="myFunctionstripe();"  name="pay">
							<?php } else if($creditCard_payment !='Disable' && $StripeVal != 'Disable')  { ?>
							<input type="radio"  onclick="myFunctionstripe();"  name="pay">
							<?php } else if  ($StripeVal != 'Disable' ) { ?>
							<input type="radio"  checked="checked" onclick="myFunctionstripe();"  name="pay">
							<?php } ?>
								
								<span class="credit-card"><?php if($this->lang->line('Stripe') != '') { echo stripslashes($this->lang->line('Stripe')); } else echo "Stripe"; ?></span>
								<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
								<script type="text/javascript">
								
								// This identifies your website in the createToken call below
								
								Stripe.setPublishableKey('<?php echo $StripeValDet1['publishable_key']; ?>');
								
								</script>
								<script>
								
								jQuery(function($) {
								
								$('#stripe-pay-button').click(function(event) {
								
								$('#error').fadeOut();
								
								var $form = $("#credit_card_forms_stripe");
								
								$form.find('.loading').text('<?php if($this->lang->line('Please_wait_your_transaction_on_process') != '') { echo stripslashes($this->lang->line('Please_wait_your_transaction_on_process')); } else echo "Please wait your transaction on process";?>');
								
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
								
								$form.find('.payment-errors').text('Sorry! please check '+response.error.message);
								
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
								<form method="post" action="site/checkout/UserPaymentCreditStripe" id="credit_card_forms_stripe" accept-charset="UTF-8">
								<div style="display:none">
									<input type="hidden" name="stripe_mode" id="stripe_mode" value="<?php echo $StripeValDet1['mode']; ?>"  />
									<input type="hidden" name="stripe_key" id="stripe_key" value="<?php echo $StripeValDet1['secret_key']; ?>"  />
									<input type="hidden" name="stripe_publish_key" id="stripe_publish_key" value="<?php echo $StripeValDet1['publishable_key']; ?>"  />                   
									<label><?php if($this->lang->line('Street Address') != '') { echo stripslashes($this->lang->line('Street Address')); } else echo "Street Address";?></label>
									<input type="hidden" value="chennai" size="30" id="address" name="address"  />
									<label>Apt, Suite, Bldg (optional)</label>
									<input type="hidden" id="suite" name="suite" size="30"  />
									<label><?php if($this->lang->line('City') != '') { echo stripslashes($this->lang->line('City')); } else echo "City";?></label>
									<input type="hidden" id="city" name="city" value="minjur" style="width:151px;" size="30"  />
									<label><?php if($this->lang->line('State') != '') { echo stripslashes($this->lang->line('State')); } else echo "State";?></label>
									<input type="hidden" id="state" name="state" value="tamilnadu" style="width:40px;" size="30"  />
									<label><?php if($this->lang->line('Postal Code') != '') { echo stripslashes($this->lang->line('Postal Code')); } else echo "Postal Code";?></label>
									<input type="hidden" id="postal_code" name="postal_code" value="<?php echo $BookingUser->UserPostCode; ?>" style="width:75px;" size="30"  /><span style="margin-left:10px;"><b><?php echo $BookingUser->UserCountry; ?></b></span>
								</div>
								
								<div  class="payment_right" >
									<div id="error" style="color:red;" class="payment-errors"></div>
									<div id="loading" style="color:green;" class="loading"></div>
									<label><?php if($this->lang->line('Card Type') != '') { echo stripslashes($this->lang->line('Card Type')); } else echo "Card Type"; ?></label>
									<select id="cardType" name="cardType" class="select-round select-white select-country selectBox required">
										<option value="Visa"><?php if($this->lang->line('Visa') != '') { echo stripslashes($this->lang->line('Visa')); } else echo 'Visa'; ?></option>
										<option value="Amex"><?php if($this->lang->line('American Express') != '') { echo stripslashes($this->lang->line('American Express')); } else echo "American Express"; ?></option>
										<option value="MasterCard"><?php if($this->lang->line('MasterCard') != '') { echo stripslashes($this->lang->line('MasterCard')); } else echo "MasterCard"; ?></option>
										<option value="Discover"><?php if($this->lang->line('Discover') != '') { echo stripslashes($this->lang->line('Discover')); } else echo "Discover"; ?></option>
									</select>
									<div style="position:relative;">
										<label><?php if($this->lang->line('Credit Card Number') != '') { echo stripslashes($this->lang->line('Credit Card Number')); } else echo "Credit Card Number"; ?></label>
										<input  id="cardNumber" name="cardNumber" type="text" value="" style="margin-top:5px;" autocomplete="off" data-stripe="number" />
									</div>
									<label><?php if($this->lang->line('Expiration Date') != '') { echo stripslashes($this->lang->line('Expiration Date')); } else echo "Expiration Date"; ?></label><br> 
									<?php $Sel ='selected="selected"';  ?>                      
									<select id="CCExpDay" name="CCExpDay" style="" class="select-round select-white select-date selectBox required" data-stripe="exp-month">
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
									<select id="CCExpMnth" name="CCExpMnth" style="" class="select-round select-white select-date selectBox required" data-stripe="exp-year">
										<?php for($i=date('Y');$i< (date('Y') + 30);$i++){ ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php } ?>
									</select>
									<input type="hidden" value="stripe" name="creditvalue" />
									<input type="hidden" value="<?php echo $product->id; ?>" name="booking_rental_id" />
									<label><?php if($this->lang->line('Security Code') != '') { echo stripslashes($this->lang->line('Security Code')); } else echo "Security Code"; ?></label>
									<input id="payment-card-security" name="creditCardIdentifier" type="password" style="display:block;" value="" size="4" autocomplete="off" />
									<input type="hidden" id='price_val_stripe' value="<?php echo $datavalues->row()->totalAmt  ?>" name="total_price" />
									<input type="hidden" value="<?php echo $datavalues->row()->currencycode  ?>" name="currencycode" />
									<input type="hidden" value="<?php echo $product->id; ?>" name="booking_rental_id" />
									<input type="hidden" name="enquiryid" value="<?php echo $this->uri->segment(4); ?>" />
									
								</div>
								</form>
							</li>
							<?php }  
							
							
							if($creditCard_payment !='Disable' && $StripeVal != 'Disable' && $paypalVal !='Disable') { ?>
							<li>
								<input type="radio" name="pay" onclick="myFunction1();" ><span class="credit-card"><?php if($this->lang->line('Paypal') != '') { echo stripslashes($this->lang->line('Paypal')); } else echo "Paypal"; ?></span>
								<img src="<?php echo base_url();?>images/visa2.png" />
							</li>
							
							<?php  } else if($creditCard_payment !='Disable'  && $paypalVal !='Disable')  {  ?>
								<li>
								<input type="radio" name="pay" onclick="myFunction1();" ><span class="credit-card"><?php if($this->lang->line('Paypal') != '') { echo stripslashes($this->lang->line('Paypal')); } else echo "Paypal"; ?></span>
								<img src="<?php echo base_url();?>images/visa2.png" />
								</li>
							<?php } else if ($StripeVal != 'Disable' && $paypalVal !='Disable')  {  ?>
								<li>
								<input type="radio" name="pay" onclick="myFunction1();" ><span class="credit-card"><?php if($this->lang->line('Paypal') != '') { echo stripslashes($this->lang->line('Paypal')); } else echo "Paypal"; ?></span>
								<img src="<?php echo base_url();?>images/visa2.png" />
								</li>
							
							<?php } else if ($paypalVal !='Disable') {   ?>
								<li>
								<input type="radio"  checked="checked" name="pay" onclick="myFunction1();" ><span class="credit-card"><?php if($this->lang->line('Paypal') != '') { echo stripslashes($this->lang->line('Paypal')); } else echo "Paypal"; ?></span>
								<img src="<?php echo base_url();?>images/visa2.png" />
								</li>
							<?php } ?>
							
							
							

						</ul>
						<span id="terms_warn" style="background:red;"></span>
						<div class="booknw-area">
						
						
				
						
						<?php if($creditCard_payment !='Disable') { ?>
							<INPUT type="button" onclick="pay_by_card();" value="<?php if($this->lang->line('Proceed with Payment Credit card') != '') { echo stripslashes($this->lang->line('Proceed with Payment Credit card')); } else echo "Pay with Credit card"; ?>" id="card" class="filter-btn">
						<?php } ?>
						
							<INPUT type="submit"   value="<?php if($this->lang->line('Pay with Stripe') != '') { echo stripslashes($this->lang->line('Pay with Stripe')); } else echo "Pay with Stripe"; ?>" id="stripe-pay-button" style="display: none;" class="filter-btn">


							<!-- only wallet pay -->

							<INPUT type="button" onclick="pay_by_wallet();"   value="<?php  echo "Pay with Wallet"; ?>" id="wallet-pay-button" style="display: none;" class="filter-btn">

							<!-- only wallet pay ends -->
						
							
							
						
							

							<div id="paypal_but" style="display:none">
							<?php $data=$datavalues->row();
								$coupon=$pay->row();
								$service_tax = $service_tax->row();
								$productprice = $this->user_model->get_all_details(PRODUCT,array('id'=>$data->prd_id));
								$pprice = $productprice->row()->price;
								$total = $pprice * $data->numofdates;
								$total1 = $stotal * $data->NoofGuest;
								if($service_tax->promotion_type == 'flat'){
									$total = $total + $service_tax->commission_percentage;
								}else{
									$tax = $service_tax->commission_percentage;
									$taxamt = ($total*$tax/100);
									$total = ($total+$taxamt);
									$total1 = ($total1+($total1*$tax/100));
								}
								?>
								<form name="paypal" method="POST" action="<?php echo base_url(); ?>site/checkout/PaymentProcess">

								
								<input type="hidden" name="product_id" value="<?php echo $data->prd_id; ?>" />
<input type="hidden" name="product_name" value="<?php echo $productprice->row()->product_title; ?>" />
<input type="hidden" name="currencycode" id="currencycode"  value="<?php echo $datavalues->row()->currencycode; ?>" />
								<?php 
								$pricevalue = ($coupon->couponCode == '')?$datavalues->row()->totalAmt:$pay->row()->total_amt; ?>
								<input type="hidden" name="price" id="final_value_price" value="<?php echo $datavalues->row()->totalAmt; ?>" />
								
								<input type="hidden" name="unitPriceUser" id="" value="<?php echo $datavalues->row()->unitPerCurrencyUser; ?>" />
								
								<input type="hidden" name="sumtotal" id="final_value_sum"  value="<?php echo $datavalues->row()->totalAmt; ?>" />
								<input type="hidden" name="indtotal" id="final_value_ind"  value="<?php echo $datavalues->row()->totalAmt; ?>" />

								<input type="hidden" name="user_id" value="<?php echo $data->user_id; ?>" />
								<input type="hidden" name="sell_id" value="<?php echo $data->renter_id;?>" />
								<input type="hidden" name="tax" value="<?php echo $datavalues->row()->serviceFee; ?>" />
								<input type="hidden" name="dealCodeNumber" value="" />
								<input type="hidden" name="enquiryid" value="<?php echo $this->uri->segment(4); ?>" />
								
								
							
								
								<input type="submit" name="caltophone" style="margin:10px 0 0 10px;" value="<?php if($this->lang->line('Book Now') != '') { echo stripslashes($this->lang->line('Book Now')); } else echo "Book Now"; ?>(paypal)" id="paypal"  class="filter-btn">
								
							
								
								
								
								</form>
							</div>
							
					<?php if($creditCard_payment !='Disable' || $StripeVal != 'Disable' || $paypalVal !='Disable') { 
						?>
	
							<label class="submtig-text" style="padding:9px;"><?php if($this->lang->line('Bysubmittinga') != '') { echo stripslashes($this->lang->line('Bysubmittinga')); } else echo "By submitting a booking request, you accept the Renters";?><a target="_blank" href="<?php echo base_url();?>pages/terms-of-service"><?php if($this->lang->line('termsandconditions1') != '') { echo stripslashes($this->lang->line('termsandconditions1')); } else echo "terms and conditions";?></a></label>
							
					<?php }else{ ?>
					
						<label class="submtig-text" style="padding:9px;"><?php if($this->lang->line('Bysubmittinga_nopayment') != '') { echo stripslashes($this->lang->line('Bysubmittinga_nopayment')); } else echo "No payment method is available currently.";?></label>
						
					<?php } ?>
					
						</div>
						<div class="norto-areas">
							<a href="#"><img src="<?php echo base_url();?>images/veri1.png"></a>
							<a href="#"><img src="<?php echo base_url();?>images/veri2.png"></a>
							<a href="#"><img src="<?php echo base_url();?>images/veri3.png"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<input type="hidden" value="<?php echo $sub_tot_price_in_dollar+$tax_price_in_dollar;?>" id="totprice" />

<input type="hidden" name="unitprice" id="unitprice" value="<?php echo $BookingUser->unitPerCurrencyUser; ?>">
<input type="hidden" name="user_currencycode"  id="user_currencycode" value="<?php echo $BookingUser->user_currencycode; ?>">

<script type="text/javascript">
function ipay88() {
//alert("Welcome");

}

function credit_card_form_func()

{ 

  //alert("Welcome");



	var caltophone=jQuery("input:radio[name=caltophone]:checked").val();

	var terms = document.getElementById("credit").checked;

	var dis = parseInt($('#disamounts').val());

	if( dis == ""){

	var amount = parseInt($('#totprice').val());

	}else{

	var amount =  parseInt($('#disamounts').val());

	}

	if($('#phone_no').val()==''){

		$('#terms_warn').html('<p style="color:#F00; margin-right:3px;">Please Enter Contact Phone Number.</p> ');

		return false;

	}else if(terms == true)

		{

		//alert("erl");

			document.getElementById("ipay88").submit();

			// $.ajax({

			// type:'POST',

			// url:'site/product/edit_enquiry_details',

			// data:{'rental_id':$('#rental_id').val(),'Enquiry':$('#Enquiry').val(),'caltophone':caltophone,'phone_no':$('#phone_no').val(),'enquiry_timezone':$('#enquiry_timezone').val()},

			// dataType:'json',

			// success:function(json){

			// document.getElementById("credit_card_form").submit();

			// }

		// });

			

		}

	else

		{

			$('#terms_warn').html('<p style="color:#F00; margin:6px;padding:3px;">Please choose your <b>payment mode<b></p> ');

			$('#terms_warn').show().delay('3000').fadeOut();

			return false;

		}

}



function paypal_form()

{



	var caltophone=jQuery("input:radio[name=caltophone]:checked").val();

	var product = <?php echo $product->id;?>;

	var dis = parseInt($('#disamounts').val());

	if( dis == ""){

	var amount = parseInt($('#totprice').val());

	}else{

	var amount =  parseInt($('#disamounts').val());

	}

    

	//alert(amount);

	

	

	if(jQuery($('#phone_no').val())==''){

		$('#terms_warn').html('<p style="color:#F00; margin-right:3px;">Please Enter Contact Phone Number.</p>');

		return false;

	}else if(true == true)

		{

			$.ajax({

			type:'POST',

			url:'site/product/edit_enquiry_details',

			data:{'rental_id':$('#rental_id').val(),'Enquiry':$('#Enquiry').val(),'caltophone':caltophone,'phone_no':$('#phone_no').val(),'enquiry_timezone':$('#enquiry_timezone').val(),'guide_id':$('#guide_id').val()},

			dataType:'json',

			success:function(json){

            window.location = BaseURL+"site/checkout/PaymentProcess/"+product+"/"+amount;

			}

		});

			

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

			url:'site/product/edit_enquiry_details',

			data:{'rental_id':$('#rental_id').val(),'Enquiry':$('#Enquiry').val(),'enquiry_timezone':$('#enquiry_timezone').val()},

			dataType:'json',

			success:function(json){ 

				//return;

			}

		});

		

		

}

function submit_button1(){
	$('#paypal').hide();
	$('#card').show();
}



function submit_button2(){
	$('#card').hide();

	$('#paypal').show();

	$('#paypal_but').css('display', 'block');

	$('#netbank').css('display', 'none');

}

function coupon_codes(){

 var totalamount = parseInt($('#totprice').val());

$.ajax({

			type:'POST',

			url:'<?php echo base_url();?>site/product/coupons',

			data:{'couponcode':$('#couponcode').val(),'total':$('#total').val()},

			dataType:'json',

			success: function(json){

			//alert(json);

			

			var test = json.split("-"); 

			$('#totals').html('<p style="color:#F00; margin-right:3px;">'+'Total Amount :'+ test[3] +'</p> ');

			$('#totals').show();

			if(test[4] == 1){

			$('#disper').html('<p style="color:#F00; margin-right:3px;">'+'Flat Discount Amount :'+ test[1] +'</p> ');

			$('#disper').show();

			}else{

			$('#disper').html('<p style="color:#F00; margin-right:3px;">'+'Discount Percentage :'+ test[1] +'</p> ');

			$('#disper').show();
			}

			$('#disamount').html('<p style="color:#F00; margin-right:3px;">'+'Discounted Amount :'+ test[2] +'</p> ');

			$('#disamount').show();

			document.getElementById("dcouponcode").value=test[0];

			document.getElementById("disamounts").value=test[2];

			document.getElementById("distype").value=test[4];

			document.getElementById("dval").value=test[1];

			//alert(totalamount);

				return;

			}

			

		});  

		

}





function updateUserEmail()

{

	$.ajax({

			type:'POST',

			url:'site/product/edit_user_email',

			data:{'email_id':$('#email_id').val(),'user_id':$('#user_id').val()},

			dataType:'json',

			success:function(json){ 

				//return;

			}

		});

}





function get_mobile_code(country_id)

{



 $.ajax({

type:'POST',

url:'<?php echo base_url();?>site/user/get_mobile_code',

data:{country_id:country_id},

dataType:'json',

success:function(response)

{

$('.pniw-number-prefix').text(response['country_mobile_code']);

//alert(response);

}

});

}









</script>

<input type="hidden" id="ttotal" name="sumtotal" value="<?php echo $datavalues->row()->totalAmt; ?>" />

<input type="hidden" id="tuser_id" value="<?php echo $datavalues->row()->user_id; ?>" />





<script>

function myFunction() {

    $('#paypal').hide();

	$('#credit_card_forms_stripe').hide();

    $('#credit_card_forms').show();

    $('#stripe-pay-button').hide();

    $('#card').show();

}



function myFunctionstripe() {
	

    $('#card').hide();

    $('#wallet-pay-button').hide(); // wallet button

    $('#credit_card_forms').hide();

    $('#stripe-pay-button').show();

    $('#credit_card_forms_stripe').show();

    $('#paypal_but').hide();

}

function myFunction1() {
    $('#card').hide();

	$('#paypal').show();

	$('#paypal_but').css('display', 'block');

    $('#stripe-pay-button').hide();

    $('#wallet-pay-button').hide(); //wallet button
	 $('#credit_card_forms').hide();
	 
	 $('#credit_card_forms_stripe').hide();
}

function pay_by_card() {

$('#credit_card_forms').submit();


}

function pay_by_wallet() {



$('#wallet_form').submit();

   

}


function emptyValues(){
	document.getElementById("couponcode").value='';

			$('#disper').hide();

			$('#disamount').hide();

			$("#price_val_stripe").val('');

			$("#price_val_authorize").val('');

			$("#dcouponcode").val('');

			$("#disamounts").val('');

			$("#final_value_price").val('');

			$("#final_value_sum").val('');

			$("#final_value_ind").val('');

			$("distype").val('');

			$("#dval").val('');

			$("#wallet_exist").val('');

			$("#w_price").val('');

			$("#w_sum").val('');

			$("#w_ind").val('');

			$("#w_dval").val('');

				return false;
	
}






function mycoupon()

{


    $.ajax({

			type:'POST',

			url:'<?php echo base_url();?>site/product/coupons',

			data:{'couponcode':$('#couponcode').val(),
			'total':$('#ttotal').val(),
			'user_id':$('#tuser_id').val(),
			'product_id':$("#rental_id").val(),
			'unitprice':$("#unitprice").val(),
			'user_curcode':$("#user_currencycode").val()},

			dataType:'json',

			success: function(json){
				
			//alert(json);
			
			if (json=='0endcount'){
				
			$('#totals').html('Coupon is Not Available..!');
				 emptyValues();
				 return false;
			}
			
			if (json=='0couexpi'){
			$('#totals').html('Coupon Code Expired..!');	
				 emptyValues();
				 return false;
			}
			
			if (json=='0invalid'){
				$('#totals').html('Invalid Coupon Please Try again Later..!');	
				 emptyValues();
				 return false;
			}
			
			if (json=='0moreamt'){
				$('#totals').html('Your Property Amount is more then Coupon Amount..!');	
				 emptyValues();
				 return false;
			}
		
		
			var test = json.split("-");
			/* 
			test1=[];
			for (var i=0; i<test.length; i++)
			  {
			    test1.push('Eqt_Param'+i+'='+test[i]);
			  }
			  alert(test1.join(', '));
			*/
			if(test[0] == '' || test[0] == '0')

			{

			$('#totals').html('Invalid Coupon Code or Coupon Code may be Expired');

			document.getElementById("couponcode").value='';

			$('#disper').hide();

			$('#disamount').hide();

			$("#price_val_stripe").val('');

			$("#price_val_authorize").val('');

			$("#dcouponcode").val('');

			$("#disamounts").val('');

			$("#final_value_price").val('');

			$("#final_value_sum").val('');

			$("#final_value_ind").val('');

			$("distype").val('');

			$("#dval").val('');

			$("#wallet_exist").val('');

			$("#w_price").val('');

			$("#w_sum").val('');

			$("#w_ind").val('');

			$("#w_dval").val('');

				return false;

			}

	

			$('#totals').html('<p style="color:#0193e6; margin-right:3px;">'+'Total Amount : '+ test[8] +'</p> ');

			$('#totals').show();

			

	        $('#disper').html('<p style="color:#0193e6; margin-right:3px;">'+'Amount Discount : '+ test[6] +'</p> ');

			$('#disper').show();

		

			

			$('#disamount').html('<p style="color:#0193e6; margin-right:3px;">'+'Amount to be paid: '+ test[7] +'</p> ');

			//alert(test[2]);

			$('#disamount').show();

			$("#price_val_stripe").val(test[2]);

			$("#price_val_authorize").val(test[2]);

			//$("#ttotal").val(test[2]);

			

			$("#dcouponcode").val(test[0]);

			$("#disamounts").val(test[3]-test[2]);

			$("#final_value_price").val(test[2]);

			$("#final_value_sum").val(test[2]);

			$("#final_value_ind").val(test[2]);

			$("distype").val(test[4]);

			$("#dval").val(test[1]);



			$("#w_price").val(test[2]);

			$("#w_sum").val(test[2]);

			$("#w_ind").val(test[2]);

			//$("distype").val(test[4]);

			$("#w_dval").val(test[1]);

			return;

			}

			

		});  

	

}







</script>
<!-- malar - wallet payment -->
<script type="text/javascript">
 	


function myWallet()

{

	var walletAmount = $("#w_wallet").val();
	var bookingtot = $("#w_price").val();


	if($("#wallet_pay").is(':checked')){
			
		if(walletAmount!=bookingtot){
			if(walletAmount<bookingtot)
			{	
				useWallet();
			}else{
				useWallet();

				$('#paypal').hide();

				$('#credit_card_forms_stripe').hide();

			    $('#credit_card_forms').hide();

			    $('#stripe-pay-button').hide();

			    $("#card").hide();

			    $('#wallet-pay-button').show();

			    $("input[name='pay']").hide();

			}
		}else{

			$('#paypal').hide();

			$('#credit_card_forms_stripe').hide();

		    $('#credit_card_forms').hide();

		    $('#stripe-pay-button').hide();

		    $("#card").hide();

		    $('#wallet-pay-button').show();

		    $("input[name='pay']").hide();

			//alert("Sorry you can't pay full payment from wallet. ");
		}

	}else {
		alert('no wallet');
		$('#w_totals').hide();

		$('#w_disper').hide();

		$('#w_disamount').hide();

		$("#price_val_stripe").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#price_val_authorize").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#final_value_price").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#final_value_sum").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#final_value_ind").val('<?php echo $datavalues->row()->totalAmt; ?>');

		//$("distype").val('');

		$("#w_price").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#w_sum").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#w_ind").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#w_dval").val('');
	}


    

}

function useWallet(){
		$.ajax({

			type:'POST',

			url:'<?php echo base_url();?>site/product/useWallet',

			data:{'walletAmount':$('#w_wallet').val(),'total':$('#ttotal').val(),'user_id':$('#tuser_id').val(),'product_id':$("#rental_id").val()},

			dataType:'json',

			success: function(json){

			

			var test = json.split("-"); 
			/*
			test1=[];
			  for (var i=0; i<test.length; i++)
			  {
			    test1.push('Eqt_Param'+i+'='+test[i].value)
			  }
			  alert(test1.join(', '));
			*/
			if(test[0] == '' || test[0] == 'no')

			{

			$('#w_totals').html('wallet invalid');

			//document.getElementById("couponcode").value='';

			$('#w_disper').hide();

			$('#w_disamount').hide();

			$("#price_val_stripe").val('');

			$("#price_val_authorize").val('');

			//$("#dcouponcode").val('');

			$("#wallet_exist").val(test[0]);

			$("#disamounts").val('');

			$("#final_value_price").val('');

			$("#final_value_sum").val('');

			$("#final_value_ind").val('');

			//$("distype").val('');

			$("#w_price").val('');

			$("#w_sum").val('');

			$("#w_ind").val('');

			$("#w_dval").val('');

				return false;

			}

	

			$('#w_totals').html('<p style="color:#0193e6; margin-right:3px;">'+'Total Amount : '+ test[8] +'</p> ');

			$('#w_totals').show();

			

	        $('#w_disper').html('<p style="color:#0193e6; margin-right:3px;">'+'Wallet Amount : '+ test[6] +'</p> ');

			$('#w_disper').show();

		

			

			$('#w_disamount').html('<p style="color:#0193e6; margin-right:3px;">'+'Amount to be paid: '+ test[7] +'</p> ');

			//alert(test[2]);

			$('#w_disamount').show();

			$("#price_val_stripe").val(test[3]);

			$("#price_val_authorize").val(test[3]);

			//$("#ttotal").val(test[2]);

			

			$("#wallet_exist").val(test[0]);

			$("#disamounts").val(test[4]-test[3]);

			$("#final_value_price").val(test[3]);

			$("#final_value_sum").val(test[3]);

			$("#final_value_ind").val(test[3]);

			$("#w_price").val(test[3]);

			$("#w_sum").val(test[3]);

			$("#w_ind").val(test[3]);

			//$("distype").val(test[4]);

			$("#w_dval").val(test[1]);

			return;

			}

			

		}); 
}
function form_validation_creditcard()
{
	var card_no=$("#credit_card_forms #cardNumber").val();
	var security_code=$("#credit_card_forms #payment-card-security").val();
	if(card_no=="")
	{
		$("#cc_error_msg").html("Please provide credit card Number");
		return false;
	}
	else if(isNaN(card_no))
	{
		$("#cc_error_msg").html("Please provide valid credit card Number");
		return false;
	}
	else
	{
		$("#cc_error_msg").html("");
	}
	if(security_code=="")
	{
		$("#cc_error_msg").html("Please provide security code");
		return false;
	}
	else if(isNaN(security_code))
	{
		$("#cc_error_msg").html("Please provide valid security code");
		return false;
	}
	/*else if(security_code.length>3 Or security_code.length<3)
	{
		$("#cc_error_msg").html("Please provide valid security code");
		return false;
	}*/
	else
	{
		$("#cc_error_msg").html("");
	}
	return true;
}
</script>
<!-- malar - wallet payment ends -->


<?php if($creditCard_payment !='Disable' && $StripeVal != 'Disable')   { ?>
<script>
    $('#stripe-pay-button').hide();
    $('#credit_card_forms_stripe').hide();
</script>
 <?php } else if ($StripeVal != 'Disable') { ?>
<script>
myFunctionstripe();
</script>
<?php } ?>



<?php  if ($creditCard_payment !='Disable' && $paypalVal != 'Disable') { ?>	
<?php } else if ($StripeVal !='Disable' && $paypalVal != 'Disable')  { ?>
<?php }  else if ( $paypalVal != 'Disable') {  ?>
<script>
myFunction1();
</script>
<?php } ?>





<link rel="stylesheet" type="text/css" href="javascript/autocomplete/jquery-ui-1.8.2.custom.css" media="all" />

<script type="text/javascript" src="javascript/autocomplete/jquery-ui-1.8.2.custom.min.js"></script> 

<?php

$this->load->view('site/templates/footer');

?>