<?php 
$this->load->view('site/templates/header');
$product = $productList->row();
//print_r($product);
$BookingUser = $BookingUserDetails->row();
$servicetax = $service_tax->row();
$country = $countryList; 
$unitprice=$productList->row()->unitPerCurrencyUser;
$user_currencycode=$productList->row()->user_currencycode;
$experience_DateDetails = $experience_DateDetails->row();
//print_r($experience_DateDetails->price);
?>

<style>
input[type="text"] {
color:#000 !important;
}
</style>



<script type="text/javascript">
$(document).ready(function () {
    $('.pad').hide();
    $('.heading').click(function () {
        $(this).next('.pad').slideToggle();
        if($(this).find('.span1').attr('id') == 'yes') {
            $(this).find('.span1').attr('id', '').html('&#8744;');
        } else {
            $(this).find('.span1').attr('id', 'yes').html('&#8743;');
        }
    });
});
</script>
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
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).attr("value")=="red"){
                $(".red").toggle();
            }
        });
    });
</script>




<input type="hidden" id="rental_id" value="<?php echo $product->experience_id; ?>" />
<script type="text/javascript" src="js/site/SpryTabbedPanels.js"></script>

<section>
<div class="payment-container">
<div class="container">


<div class="payment-section1" id="paymentpg_book">
			<div class="payed-container">
            <article class="pay-head">
            <span> <?php echo $product->experience_title;?></span>
            <a class="filter-btn" href="<?php echo base_url(); ?>view_experience/<?php echo $product->experience_id;?>"><i class="arow-keyd"></i><?php if($this->lang->line('Back') != '') { echo stripslashes($this->lang->line('Back')); } else echo "Back"; ?></a>
            </article>

            <div class="over-view-details">
            <div class="over-view-details-left">
			<img src="<?php if(strpos($product->product_image, 's3.amazonaws.com') > 1)echo $product->product_image;else echo base_url()."server/php/experience/".$product->product_image; ?>" />
			</div>
            <div class="over-view-details-right">
               

                    <ul class="checkin-details-left cheks-status">
					
					<div style="display:none">
                        <li>
                            <label><?php if($this->lang->line('check_in') != '') { echo stripslashes($this->lang->line('check_in')); } else echo "Check In"; ?>:</label>
                            <span><?php echo date('Y-m-d',strtotime($product->checkin)); ?></span>
                        </li>

                        <li>
                            <label><?php if($this->lang->line('check_out') != '') { echo stripslashes($this->lang->line('check_out')); } else echo "Checkout"; ?>:</label>
                            <span><?php echo date('Y-m-d',strtotime($product->checkout)); ?></span>
						</li>						
						</div>
						
						 <li>
						 
						 
						 
                            <label><?php if($this->lang->line('dates_are') != '') { echo stripslashes($this->lang->line('dates_are')); } else echo "Dates Are"; ?> :</label>
                            <span><?php echo date('Y-m-d',strtotime($product->checkin)) ." to ". date('Y-m-d',strtotime($product->checkout)); ?></span>
						</li>
						
						 <li>
                            <label><?php if($this->lang->line('timings_are') != '') { echo stripslashes($this->lang->line('timings_are')); } else echo "Timings Are"; ?> :</label>
                            <span style="margin-top: -22px;">    
							
								<?php
					/** To Show Schedule Dates**/
					if ($product->date_id!=''){
					$date_id=$product->date_id;
					$query="SELECT * FROM ".EXPERIENCE_TIMING." WHERE exp_dates_id=".$date_id;
					$TimesAre=$this->experience_model->ExecuteQuery($query);
					$count=$TimesAre->num_rows();
						echo "<p class='toggleSchedule'>Read Timings (".$count.")</p><div class='scheduleDetails'>";
							foreach ($TimesAre->result() as $sched) {	
						?>
								<div>
									<?php 
									echo '<b>'.$sched->title.'</b><br>'; 
									echo date('Y-m-d',strtotime($sched->schedule_date));
									echo '<div class="timings">'.date('h:i A',strtotime($sched->start_time)).' - '. date('h:i A',strtotime($sched->end_time)).'</div>' ;
									?>								
								</div>
							<?php }
							echo "</div>";
					}
							?>
					
							</span>
						</li>
						
							
	
	

                        <?php /*?>
                         <li>
                            <label><?php if($this->lang->line('You_Stay') != '') { echo stripslashes($this->lang->line('You_Stay')); } else echo "You Stay"; ?>:</label>
                            <span><?php if($product->numofdates > 1) echo $product->numofdates." Days"; ?></span>
                            <span><?php if($product->numofdates == 1) echo $product->numofdates." Day"; ?></span>
                        </li>
						*/ ?>
                        <li>
                            <label><?php if($this->lang->line('guest_s') != '') { echo stripslashes($this->lang->line('guest_s')); } else echo "Guests"; ?>:</label>
							<span><?php if($product->NoofGuest > 1) echo $product->NoofGuest." Guests"; ?></span>
                            <span><?php if($product->NoofGuest == 1) echo $product->NoofGuest." Guest"; ?></span>
                        </li>
                    </ul>

                     <ul class="checkin-details-right cheks-status">
                        <li>
						
							<?php
							$commission = $product->serviceFee;
							
							
							$pricePerNight = $experience_DateDetails->price;
							?>
                            <label><?php if($this->lang->line('Unit Price') != '') { echo stripslashes($this->lang->line('Unit Price')); } else echo "Unit Price"; ?>:</label>
                            <span> 
                       <?php  echo $currencySymbol; ?><?php
					   /*

						if($product->currency != $this->session->userdata('currency_type')){
						
							echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$pricePerNight);
						
						}else{
							 echo $pricePerNight;
						}
						*/
					
						//echo $unitprice;
						if($user_currencycode==$this->session->userdata('currency_type')){ 
							if(!empty($unitprice)){
							echo customised_currency_conversion($unitprice,$pricePerNight);

							}
						}else{							
							 echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$pricePerNight);
						}
						
						
                     ?> <?php echo $this->session->userdata('currency_type');?></span>
                        </li>

                         <li>
                            <label><?php if($this->lang->line('ServiceFee') != '') { echo stripslashes($this->lang->line('ServiceFee')); } else echo "Service Fee"; ?></label>
                            <span>

							<?php  echo $currencySymbol; ?>
							<?php
		                    /*
							if($product->currency != $this->session->userdata('currency_type')){
		                     echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$product->serviceFee);

		                    }else{
		                     	 echo $product->serviceFee;
		                    }
							*/
							
							if($user_currencycode==$this->session->userdata('currency_type')){ 
								if(!empty($unitprice))
								echo customised_currency_conversion($unitprice,$product->serviceFee);
							}else{
								 echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$product->serviceFee);
							}
							
							
							//echo $currencySymbol."  ".CurrencyValue($product->id,$commission);
							
							 ?> <?php echo $this->session->userdata('currency_type');?>
						</span>
                        </li>

                        <?php if($securityDeposite != 0){?>
                        <li>
                            <label><?php if($this->lang->line('Security Deposit') != '') { echo stripslashes($this->lang->line('Security Deposit')); } else echo "Security Deposit"; ?></label>
                            <span>

							<?php  echo $currencySymbol; ?>
							<?php
		                      
							  /*if($product->currency != $this->session->userdata('currency_type'))
		                      {
		                     echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$securityDeposite);
							 

		                     }
							else{
		                     	 echo $securityDeposite;
		                     }
							*/
							
							if($user_currencycode==$this->session->userdata('currency_type')){ 
								if(!empty($unitprice))
								echo customised_currency_conversion($unitprice,$securityDeposite);
							}else{
								 echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$securityDeposite);
							}
							
							//echo $currencySymbol."  ".CurrencyValue($product->id,$commission);
							
							 ?> <?php echo $this->session->userdata('currency_type');?>
						</span>
                        </li>
                        <?php }?>

                        <?php if($cleaningFee != 0){?>
                        <li>
                            <label><?php if($this->lang->line('cleaningfee') != '') { echo stripslashes($this->lang->line('cleaningfee')); } else echo "Cleaning Fee"; ?></label>
                            <span>

							<?php echo $currencySymbol; ?>
							<?php
		                      
							  /*if($product->currency != $this->session->userdata('currency_type'))
		                      {
		                     echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$securityDeposite);
							 

		                     }
							else{
		                     	 echo $securityDeposite;
		                     }
							*/
							
							if($user_currencycode==$this->session->userdata('currency_type')){ 
								if(!empty($unitprice))
								echo customised_currency_conversion($unitprice,$cleaningFee);
							}else{
								 echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$cleaningFee);
							}
							
							//echo $currencySymbol."  ".CurrencyValue($product->id,$commission);
							
							 ?> <?php echo $this->session->userdata('currency_type');?>
						</span>
                        </li>
                        <?php }?>
                         <li>
                            <label><?php if($this->lang->line('Total') != '') { echo stripslashes($this->lang->line('Total')); } else echo "Total"; ?>:</label>
                            <span><?php  echo $currencySymbol; ?><?php
                            		$totalAmt = ($experience_DateDetails->price) + $product->serviceFee + $securityDeposite + $cleaningFee;
										
/*
				                      if($product->currency != $this->session->userdata('currency_type'))
				                      {
				                     echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$totalAmt);

				                     }
									else{
				                     	 echo $totalAmt;
				                     }
									 */
									 
									if($user_currencycode==$this->session->userdata('currency_type')){ 
										if(!empty($unitprice))
										echo customised_currency_conversion($unitprice,$totalAmt);
									}else{
										 echo convertCurrency($product->currency,$this->session->userdata('currency_type'),$totalAmt);
									}
									
									 
									//echo $currencySymbol."  ".CurrencyValue($product->id,$product->totalAmt);
									?>
									
									
									<?php echo $this->session->userdata('currency_type');?>
						</span>
                        </li>



  	<li>

                    <label class="bookind-smap"><?php if($this->lang->line('BookingNo') != '') { echo stripslashes($this->lang->line('BookingNo')); } else echo "Booking No"; ?> </label>
                    <input type="text" name ="Bookingno" id="Bookingno" readonly="true"  value="<?php echo $product->Bookingno;?>" >
					<input type="hidden" id="user_id" name="user_id"  value="<?php echo $BookingUser->userid;?>"/>
                </li>
     
                    </ul>

					
					
					
					
    <p> <?php if($this->lang->line('cancel_experience') != '') { echo stripslashes($this->lang->line('cancel_experience')); } else echo "You can't Cancel Your Experience until"; ?>  <?php echo $this->config->item('cancel_hide_days_experience'); ?> <?php if($this->lang->line('days_from_checkin_date') != '') { echo stripslashes($this->lang->line('days_from_checkin_date')); } else echo "days from Check in Date"; ?>..!  </p>
                        <?php /* if($instant == 'Yes'){?>
			<form method="post" action="site/user/booking_confirm_instant/<?php echo $this->uri->segment(2); ?>" id="credit_card_form" >
			<?php } else */ {?>
			<form method="post" action="site/experience/experience_bookingConfirm/<?php echo $this->uri->segment(2); ?>" id="credit_card_form" ><?php } ?>
			<input type="hidden" name="Bookingno"  value="<?php echo $product->Bookingno;?>"/>
                <ul class="login-list-cont">
             	<input type="hidden" name = "email_id" id = "email_id" value="<?php echo $BookingUser->email;?>" onblur="updateUserEmail();" readonly >
				<input type="hidden" id="user_id" name="user_id"  value="<?php echo $BookingUser->userid;?>" required />
			
				<li style="display:none;">
                    <label><?php if($this->lang->line('Message') != '') { echo stripslashes($this->lang->line('Message')); } else echo "Message"; ?></label>
                    <textarea class="hiost-mesg" name = "message" value=""  placeholder="<?php if($this->lang->line('Message your host') != '') { echo stripslashes($this->lang->line('Message your host')); } else echo "Message your host"; ?>.." ></textarea>
                </li>





<div align="center">

<input type="submit" class="filter-btn" id="bookbtn" name="bookbtn" value="<?php if($instant == 'Yes'){?><?php if($this->lang->line('PAY and BOOK') != '') { echo stripslashes($this->lang->line('PAY and BOOK')); } else echo "PAY and BOOK"; ?> <?php } else { ?><?php if($this->lang->line('Book Now') != '') { echo stripslashes($this->lang->line('Book Now')); } else echo "Book Now"; ?><?php }?>" />
</div>

</form>


</div>





                    




<div class="notify-profile">
    <div class="thick-area"><img src="images/thick.png"></div>
    <div class="thick-infos"><span class="choise"><?php if($this->lang->line('Great Choice! You are Just 1 minute away from booking') != '') { echo stripslashes($this->lang->line('Great Choice! You are Just 1 minute away from booking')); } else echo "Great Choice! You are Just 1 minute away from booking";?>. </span><p><?php if($this->lang->line('Fill_details') != '') { echo stripslashes($this->lang->line('Fill_details')); } else echo "Fill in your details below to complete the booking. Once you submit your booking, it will be confirmed immediately and you will receive an email with the host’s contact details and the exact address of the property";?>.</p></div>
</div>
</div>
</div>
</div>


<?php 
$ipayuser = $this->product_model->get_all_details(USERS,array('id'=>$BookingUserDetails->row()->userid));
?>


<div class="payment-section1">

<div class="payed-container1">
         

            <div class="over-view-details">
			

</div>

</div>



</div>


</div>
</div>
</section>


<?php 
$sub_tot_price_in_dollar=$product->price*$product->numofdates;
   if($tax->row()->promotion_type=='flat')
      {
	$tax_price_in_dollar=$tax->row()->commission_percentage;
	 }
	else{
	 $tax_price_in_dollar=($product->price * $product->numofdates*$BookingUserDetails->row()->NoofGuest)*$tax->row()->commission_percentage/100;
	}


?>
<input type="hidden" value="<?php echo $sub_tot_price_in_dollar+$tax_price_in_dollar;?>" id="totprice" />


<script>
function phonenumber() {
alert("welcome");
if(document.getElementById('phone_no').value=="") {
alert("Phone number required");
return false;
}
else {
return true;
}
}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>												
<script type="text/javascript">

function credit_card_form_func()
{ 
  

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

			document.getElementById("ipay88").submit();
		
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
function submit_button1()
{
	$('#paypal').hide();
	$('#card').show();
	
}

function submit_button2()
{
	$('#card').hide();
	$('#paypal').show();
	$('#paypal_but').css('display', 'block');
}

function coupon_codes()
{
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

<script>
	$(document).on("click",".toggleSchedule",function(){
		$(this).next(".scheduleDetails").slideToggle();
	});
</script>

<script type="text/javascript" src="js/1.8-jquery-ui-min.js"></script>
<link rel="stylesheet" type="text/css" href="javascript/autocomplete/jquery-ui-1.8.2.custom.css" media="all" />
<script type="text/javascript" src="javascript/autocomplete/jquery-ui-1.8.2.custom.min.js"></script> 
<?php
$this->load->view('site/templates/footer');
?>