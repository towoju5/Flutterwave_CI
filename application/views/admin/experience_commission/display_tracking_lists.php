
<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<script type="text/javascript">
	function checkHostPaypalEmail(id) {
		
		paypalEmail = $("#hostPayPalEmail"+id).val();
		//alert(paypalEmail); //return false;
		if(paypalEmail!='no')
		{
			return true;
		}
		else 
		{	
			alert('No Host Paypal Email.');
			return false;
		}
	}
</script>

<div id="content">
		<div class="grid_container">
			<?php 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;color: red;">
							Commission Will be Calculate once after trip date started. Because of Cancellation
						</div>
					</div>
					<div class="widget_content">
						<table class="display display_tbl" id="commission_tbl">
						<thead>
						<tr>
							<th class="tip_top" title="Click to sort">
								SNo.
							</th>
							<th class="tip_top" title="Click to sort">
								Host Email Id
							</th>
							<th class="tip_top" title="Click to sort">
								Total orders
							</th>
							<th class="tip_top" title="Click to sort">
								Amnt to Host
							</th>
							
							<th class="tip_top" title="Click to sort">
								Guest Service Amnt
							</th>

							<th class="tip_top" title="Click to sort">
								Host Fee
							</th>

							<th class="tip_top" title="Click to sort">
								Cancellation Amount
							</th>

							<th class="tip_top" title="Click to sort">
								Total Amnt
							</th>
							
							<!--<th class="tip_top" title="Click to sort">
								Host Service amount
							</th>-->
							<!--<th class="tip_top" title="Click to sort">
							   Representative Service Amount
							</th>-->
							<th class="tip_top" title="Click to sort">
								Actual Profit
							</th>
							<?php /* ?>
							<th class="tip_top" title="Wallet Amount used on orders">
								Used Wallet Amnt
							</th> 
							<th class="tip_top" title="Admin Profit after applying wallet reduction">
								Profit Reminds
							</th> <?php */ ?>
							
							<th class="tip_top" title="Click to sort">
								Paid
							</th>
							<th class="tip_top" title="Click to sort">
								Balance
							</th>
							<th>
								Experiences
							</th>
							<th>
								Options
							</th>
							
						</tr>
						</thead>
						<tbody>
						<?php 
						
						if (count($trackingDetails) > 0){
							//echo count($trackingDetails);
							$i=1;
							//echo "<pre>"; print_r($trackingDetails); die;
							
							foreach ($trackingDetails as $key => $value){
							$details = $value;
							//print_r($trackingDetails);
							//print_r($value);
							//echo $details['payable_amount'];
							//echo $trackingDetails['total_amount'];
							//echo $details['paid'];
						?>
						<tr>
							<td>
								<?php echo $i;?>
							</td>
							<td>
								<?php echo $key. '&nbsp;&nbsp;';?> <?php if($details['renter_id']!=''){ ?><a href="admin/experience_bookingpayment/display_receivable/<?php echo $details['renter_id'];?>">View</a> <?php } ?>
							</td>
							<td>
								<?php echo $details['rowsCount'];?>
							</td>
							<td>
								<?php  echo $admin_currency_symbol.' '.number_format($details['payable_amount'], 2);?>
							</td>
							<td>
								<?php echo $admin_currency_symbol.' '.number_format($details['guest_fee'], 2);?>
							</td>
							<td>
								<?php echo $admin_currency_symbol.' '.number_format($details['host_fee'], 2);?>
							</td>
							<td>
							<!---guest service amount---->
								<?php
									

								echo  $admin_currency_symbol.' '.number_format($details['exp_cancel_percentage'], 2); ?>
							</td>
							<td>
								<?php echo $admin_currency_symbol.' '.number_format($details['total_amount'], 2);?>
							</td>
							
							<!--<td>
								<?php //echo $admin_currency_symbol.' '.number_format($details['host_fee'], 2);?>
							</td>-->
							<!--<td>
								<?php //echo $admin_currency_symbol.' '.number_format($details['Rep_fee'], 2);?>
								<td>-->
							<td>
					<?php echo  $admin_currency_symbol.' '.number_format($details['guest_fee']+$details['host_fee'], 2);?>
							</td>
							<?php /*
							<td>
								<?php //echo $admin_currency_symbol.' '.number_format($details['booking_walletUse'], 2);?>
							</td>

							<td>
								<?php //echo $admin_currency_symbol.' '.number_format((($details['guest_fee']+$details['host_fee'])-$details['booking_walletUse']), 2);

								echo $admin_currency_symbol.' '.number_format(($details['guest_fee']+$details['host_fee']), 2);

								?>
							</td>
							<?php */ ?>

							
							<td>
								<?php echo $admin_currency_symbol.' '.number_format($details['paid'], 2);?>
							</td>
							<td>
								<?php 
								
								
								
								echo $admin_currency_symbol.' '.number_format($details['payable_amount']-$value['paid'], 2);?>
							</td>

							<td>
							<a title="Click to view details" class="tip_top" href="#"><span class="badge_style">Experiences&nbsp;<span>(<?php echo $details['rowsCount'];?>)</span></span></a>
							</td>

							<td>
								<?php if(number_format($details['payable_amount']-$value['paid'], 2) != 0.00){?>
								<span style="" class="action_link"><a class="p_approve tipTop" href="admin/experience_commission/add_pay_form/<?php  echo $details['id'];?>/<?php echo $details['payable_amount']-$value['paid'];?>" title="Pay balance due">offline Pay</a></span> 
								<span class="action_link">
									<form method="POST" action='admin/experience_commission/paypal_payment' onsubmit="return checkHostPaypalEmail(<?php echo $i;?>);">
										<?php 
										$paypal_amount = number_format($details['payable_amount']-$value['paid'], 2);
										?>
										<input type='hidden' name='amount_from_db' value ='<?php echo $paypal_amount;?>' >
										
										<input type='hidden' name='booking_no' value ='<?php echo $details['Bookingno'];?>' >
										
										
										<?php
										if($admin_currency_code != 'USD')
					                    {
					                    	$paypal_amount = convertCurrency($admin_currency_code,'USD',$paypal_amount);
					                    }
					                     $paypal_amount =  str_replace( ',', '', $paypal_amount);
										?>

										<input type="hidden" name ='amount_to_pay' value="<?php echo $paypal_amount;?>">

										<input type="hidden" name="hostEmail" value="<?php echo $key;?>" >
										
										
										
										<input type="hidden" name="checkinDate" value="<?php echo $details['checkin']; ?>" >
										<input type="hidden" name="bookingNo" value="<?php echo $details['bookinNo_pay']; ?>" >
										
										
										
										<input type="hidden" name="hostPayPalEmail" id="hostPayPalEmail<?php echo $i;?>" value="<?php if($paypalData[$key]!='') echo $paypalData[$key]; else echo 'no';?>" >
										<button type='submit' class="p_approve tipTop"  title="Pay balance due">online Pay</button>
									</form>
								</span> 
								<?php }?>



							</td>
						</tr>
						<?php 
						$i++;
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="tip_top" title="Click to sort">
								SNo.
							</th>
							<th class="tip_top" title="Click to sort">
								Host Email Id
							</th>
							<th class="tip_top" title="Click to sort">
								Total orders
							</th>
							<th class="tip_top" title="Click to sort">
								Amnt to Host
							</th>
							
							<th class="tip_top" title="Click to sort">
								Guest Service Amnt
							</th>
							<th class="tip_top" title="Click to sort">
								Host Fee
							</th>
							<th class="tip_top" title="Click to sort">
								Cancellation Amount
							</th>
							<th class="tip_top" title="Click to sort">
								Total Amnt
							</th>
							
							<!--
							<th class="tip_top" title="Click to sort">
								Host Service amount
							</th> -->
							<!--<th class="tip_top" title="Click to sort">
								Representative Service Amount
							</th>-->
							<th class="tip_top" title="Click to sort">
								Actual Profit
							</th><?php /*
							<th class="tip_top" title="Click to sort">
								Used Wallet Amnt
							</th>
							<th class="tip_top" title="Click to sort">
								Profit Reminds
							</th> */ ?>
							
							<th class="tip_top" title="Click to sort">
								Paid
							</th>
							<th class="tip_top" title="Click to sort">
								Balance
							</th>
							<th>
								Experiences
							</th>
							<th>
								Options
							</th>
							
						</tr>
						</tfoot>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" name="statusMode" id="statusMode"/>
			
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>