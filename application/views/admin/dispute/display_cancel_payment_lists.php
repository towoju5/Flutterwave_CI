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
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						</div>
					</div>
					<div class="widget_content">
						<table class="display display_tbl" id="propertyCancel_tbl">
						<thead>
						<tr>
							<th class="tip_top" title="Click to sort">
								SNo.
							</th>
							<th class="tip_top" title="Click to sort">
								Guest Email Id
							</th>
							<th class="tip_top" title="Click to sort">
								Total orders
							</th>
							
							<th class="tip_top" title="Click to sort">
								Cancellation Amount
							</th>
							<!--<th class="tip_top" title="Click to sort">
								Host Service amount
							</th>-->
							<!--<th class="tip_top" title="Click to sort">
							   Representative Service Amount
							</th>-->
							
							<th class="tip_top" title="Click to sort">
								Paid
							</th>
							<th class="tip_top" title="Click to sort">
								Balance
							</th>
							
							<th>
								Options
							</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						
						if (count($trackingDetails) > 0)
						{
							
							$i=1;
							
							

							foreach ($trackingDetails  as $value){
							
							foreach($value as $cancel)
							{
							
							
						$currencyPerUnitSeller=$cancel->currencyPerUnitSeller;
							
						/** To Display cancel amount Once the admin defined Dates Starts */	
/* 							$today=date("Y-m-d"); 
							$hideCancelDay = $this->config->item ('cancel_hide_days_property');
							$totlessDays=$hideCancelDay;
							$minus_checkin =  strtotime("-".$totlessDays."days",strtotime($cancel->checkin));
							$checkinBeforeDay = date('Y-m-d',$minus_checkin);
 */						/** To Display cancel amount Once the admin defined Dates Starts */	
						
						//if ($checkinBeforeDay<=$today){  
							

							

							
						?>
						<tr>
							<td>
								<?php echo $i;
							

								?>
							</td>
							<td>
								<?php echo $cancel->email;?>
							</td>
							<td>
								<?php echo count($cancel->host_email);
								
								//echo "checkin". date("Y-m-d",strtotime($cancel->checkin))."<br>";
								//echo "beforetwo". $checkinBeforeDay."<br>";
								
								?>
							</td>
							<td>
							<!---guest service amount---->							
								<?php 
								
								$cancel_amount = $cancel->subTotal/100 * $cancel->cancel_percentage;
									
									
									
									if ($cancel->cancel_percentage!='100'){ // for moderate,flexible,no refund
										
										if($admin_currency_code!=$cancel->currencycode){
											$TheCancelAMount=customised_currency_conversion($currencyPerUnitSeller,$cancel_amount);
										}else{
											$TheCancelAMount=$cancel_amount;
										}
										
										echo  $admin_currency_symbol.' '.$TheCancelAMount;
										
									}else {  //for strict 
									
											if($admin_currency_code!=$cancel->currencycode){
												$TheCancelAMountStrict=customised_currency_conversion($currencyPerUnitSeller,$cancel->payable_amount);
											}else{
												$TheCancelAMountStrict=$cancel->payable_amount;
											}
										
											echo  $admin_currency_symbol.' '.$TheCancelAMountStrict;
									
									}

								
								//echo $admin_currency_symbol.' '.number_format($cancel_amount);
								echo "--" . $cancel->booking_no;
								?>
							</td>
							
							<td>
							<!---paid---->							
								<?php
								if($cancel->paid_canel_status == 1)
								{
	
									if ($cancel->cancel_percentage!='100'){ // for moderate,flexible,no refund
										if($admin_currency_code!=$cancel->currencycode){
											$Paid=customised_currency_conversion($currencyPerUnitSeller,$cancel->paid_cancel_amount);
										}else{
											$Paid=$cancel->paid_cancel_amount;
										}
										
											echo $admin_currency_symbol.''.$Paid;
				
									} else{ //for strict
										
										if($admin_currency_code!=$cancel->currencycode){
												$paidStrictAMount=customised_currency_conversion($currencyPerUnitSeller,$cancel->payable_amount);
											}else{
												$paidStrictAMount=$cancel->payable_amount;
											}
										
											echo  $admin_currency_symbol.' '.$paidStrictAMount;

									}
		
								}else
								{
									
									
									echo $admin_currency_symbol.''."0.00";
								}
								?>
							</td>

							<td>
							<!---option---->
							<?php
								if($cancel->paid_canel_status == 0)
								{
									
									
									if ($cancel->cancel_percentage!='100'){ // for moderate,flexible,no refund
									
										if($admin_currency_code!=$cancel->currencycode){
											$Balence=customised_currency_conversion($currencyPerUnitSeller,$cancel->paid_cancel_amount);
										}else{
											$Balence=$cancel->paid_cancel_amount;
										}
										echo $admin_currency_symbol.''.$Balence;
									
										
									}else{ //for strict
										
										if($admin_currency_code!=$cancel->currencycode){
											$balenceStrictAMount=customised_currency_conversion($currencyPerUnitSeller,$cancel->payable_amount);
										}else{
											$balenceStrictAMount=$cancel->payable_amount;
										}
									
										echo  $admin_currency_symbol.' '.$balenceStrictAMount;
										
										
									}
	
								}else
								{
									echo $admin_currency_symbol.''."0.00";
								}
								?>
							</td>

							<td>
							
								<?php 
								if($cancel->paid_canel_status == 0)
								{
									
									if ($cancel->cancel_percentage!='100'){ // for moderate,flexible,no refund
									
										if($admin_currency_code!=$cancel->currencycode){
											$cancel_amount_pay=customised_currency_conversion($currencyPerUnitSeller,$cancel->paid_cancel_amount);
										}else{
											$cancel_amount_pay=$cancel->paid_cancel_amount;
										}
									
									}else{
										
										if($admin_currency_code!=$cancel->currencycode){
											$cancel_amount_pay=customised_currency_conversion($currencyPerUnitSeller,$cancel->payable_amount);
										}else{
											$cancel_amount_pay=$cancel->payable_amount;
										}
						
									}
									
				
								}else{
									$cancel_amount_pay = 0;
								}
								
								
								
									

								if($cancel_amount_pay != 0.00) { ?>
								
								<span class="action_link"><a class="p_approve tipTop" href="admin/dispute/add_pay_form/<?php  echo $cancel->booking_no;?>/<?php echo $cancel->id; ?>" title="Offline Payment Mode">Offline</a></span> 


								<span class="action_link">
									<form method="POST" action='admin/dispute/paypal_Cancelpayment_property' onsubmit="return checkHostPaypalEmail(<?php echo $i;?>);">
										<?php 
										$paypal_amount = $cancel_amount_pay;
										?>
										<input type='hidden' name='amount_from_db' value ='<?php echo $paypal_amount;?>' >
										<?php
										if($admin_currency_code != 'USD')
					                    {
					                    	$paypal_amount = convertCurrency($admin_currency_code,'USD',$paypal_amount);
					                    }
					                     $paypal_amount =  str_replace( ',', '', $paypal_amount);
										?>

										<input type="hidden" name ='amount_to_pay' value="<?php echo $paypal_amount;?>">
										<input type="hidden" name="GuestEmail" value="<?php echo $cancel->email; ?>" >
										
										
										<input type="hidden" name ='booking_number' value="<?php echo $cancel->booking_no;?>">
										<input type="hidden" name="hostEmail" value="<?php echo $key;?>" >
										<input type="hidden" name="guestPayPalEmail" id="guestPayPalEmail<?php echo $i;?>" value="<?php if($paypalData[$key]!='') echo $paypalData[$key]; else echo 'no';?>" >
										<button type='submit' class="p_approve tipTop"  title="Paypal Online Payment Mode">Online</button>
									</form>
								</span> 
								<?php } ?>



							</td>
						</tr>
						
						<?php  //}  ?>
						<?php 
						$i++;
							}
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
								Guest Email Id
							</th>
							<th class="tip_top" title="Click to sort">
								Total orders
							</th>
							
							<th class="tip_top" title="Click to sort">
								Cancellation Amount
							</th>
							<!--
							<th class="tip_top" title="Click to sort">
								Host Service amount
							</th> -->
							<!--<th class="tip_top" title="Click to sort">
								Representative Service Amount
							</th>-->
							
							<th class="tip_top" title="Click to sort">
								Paid
							</th>
							<th class="tip_top" title="Click to sort">
								Balance
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