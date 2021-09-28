<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>



<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/order/change_order_status_global',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						
					</div>
					<div class="widget_content">
						<table class="display display_tbl" id="subadmin_tbl">
						<thead>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
                            <th class="tip_top" title="Click to sort">
								<span style="padding:10px"> S No</span>
							</th>
							<th class="tip_top" title="Click to sort">
								<span style="padding:5px 10px 5px 5px">Booking No</span>
							</th>
							<th class="tip_top" title="Click to sort">
                            	Guest Email ID
                            </th>
							<th class="tip_top" title="Click to sort">
                            	Product Title
                            </th>
                            <th class="tip_top" title="Click to sort">
								 Date Added		
							</th>
							<th>
                            	Total Amount
                            </th>
							<th>
                            	Total Discount
                            </th>
							<th>
                            	Guest Service Amt
                            </th>
							<th>
                            	Cancellation Amt
                            </th>
							<th>
                            	Actual Profit
                            </th>
							<th>
                            	Used Wallet Amt
                            </th>
							<th>
                            	paid
                            </th>
							<th>
                            	Balance
                            </th>
							<th>
								<span style="padding:10px">Product Title</span>
							</th>
							<th>
                            	Booking Status
                            </th>
                            
                           

							<!-- <th>
								 Action
							</th> -->
						</tr>
						</thead>
						<tbody>
						<?php 
						
						if (count($product) > 0){
						$i=1;
							foreach ($product as $value){
								
								foreach($value as $pro)
								{
						
						
						$currencyPerUnitSeller=$pro->currencyPerUnitSeller;
						
						?>
						<tr>
							<td class="center tr_select ">
								<input name="checkbox_id[]" type="checkbox" value="<?php echo $pro->id;?>">
							</td>
                            <td class="center">
								<?php echo $i;?>
							</td>
							<td class="center">
								<?php echo $pro->Bookingno;?>
							</td>
							<td class="center">
								<?php echo $pro->email;?>
							</td>
							<td class="center">
								<?php echo $pro->product_title;?>
							</td>
							<td class="center">
								<?php echo date('d-m-Y',strtotime($pro->dateAdded));?>
							</td>
							<td class="center">
							<!-- TotalAmount-->
								<?php 
								
								$tot_amount=$pro->total_amount;
								if($admin_currency_code!=$pro->currencycode){
									$theTot_amount=customised_currency_conversion($currencyPerUnitSeller,$tot_amount);
								}else{
									$theTot_amount=$tot_amount;
								}
								echo $admin_currency_symbol.' '.$theTot_amount;
								
								
								?>
							</td>
							<td class="center">
							
							<!-- TotalDiscount-->
								<?php 
								if($pro->coupon_discount != '')
								{									
									echo $admin_currency_symbol.' '.$pro->coupon_discount;
								}else
								{
									echo $admin_currency_symbol.''."0.00";
								}
								
								?>
							</td>
							
							<td class="center">
							<!-- Guest Fee-->
							
								<?php 
								
								$GuestFee=$pro->guest_fee;
								
								if($admin_currency_code!=$pro->currencycode){
									$theGuestFee=customised_currency_conversion($currencyPerUnitSeller,$GuestFee);
								}else{
									$theGuestFee=$GuestFee;
								}
								echo $admin_currency_symbol.' '.$theGuestFee;
				
								?>
							</td>
							
							<td class="center">
							
							<!-- cancellation Amount-->
							<?php

							
							
					/** Start - Convert Cancel Amount **/
					$cancel_amountBf = $pro->subTotal/100 * $pro->cancel_percentage;
					$cancel_amountPayableAmt = $pro->payable_amount/100 * $pro->cancel_percentage; 
				if ($pro->cancelled=='Yes'){					
					if($admin_currency_code!=$pro->currencycode){
						if ($pro->cancel_percentage!='100') { 							
							$cancel_amount=customised_currency_conversion($currencyPerUnitSeller,$cancel_amountBf); 							
						}else{							
							$cancel_amount=customised_currency_conversion($currencyPerUnitSeller,$cancel_amountPayableAmt); 					
						}
					}else{
						
						if ($pro->cancel_percentage!='100') { 							
							 $cancel_amount=$cancel_amountBf; 
						}else{							
							 $cancel_amount=$cancel_amountPayableAmt; 
						}	
					}
					/** End - Convert Cancel Amount **/
					
						echo $admin_currency_symbol.' '.$cancel_amount;			
				}else {

						echo $admin_currency_symbol.' '.'0.00';
				}	

				
							
								 ?>
							</td>
							
							
							
							<td class="center">
							
							
							<!-- Actual Profit-->
							
							
							<?php $act_pro = ($pro->guest_fee + $pro->host_fee) - $pro->coupon_discount; ?>
							<?php 
							
							if($admin_currency_code!=$pro->currencycode){
								$theActualProfit=customised_currency_conversion($currencyPerUnitSeller,$act_pro);					
							}else{
								$theActualProfit=$act_pro;	
							}

							echo $admin_currency_symbol.' '.$theActualProfit;
	
							?>
							</td>
							<td class="center">
							
								<?php
								if($pro->booking_walletUse != '')
								{									
								echo $admin_currency_symbol.' '.number_format($pro->booking_walletUse);
								}else
								{
									echo $admin_currency_symbol.''."0.00";
								}
								?>
							</td>
							<td class="center">
							
								<?php if($pro->paid_status == 'yes')
								{
									
								
								/** Start - Convert Cancel Amount **/
								$cancel_amountBf = $pro->subtotal/100 * $pro->cancel_percentage;
								$cancel_amountPayableAmt = $balence=$pro->payable_amount/100 *  $pro->cancel_percentage; 
								if($admin_currency_code!=$pro->currencycode){
									if ($pro->cancel_percentage!='100') { 							
										$cancel_amount=customised_currency_conversion($currencyPerUnitSeller,$cancel_amountBf); 
									}else{							
										$cancel_amount=customised_currency_conversion($currencyPerUnitSeller,$cancel_amountPayableAmt);  	
									}
								}else{
									if ($pro->cancel_percentage!='100') { 							
										$cancel_amount=$cancel_amountBf; 
									}else{							
										$cancel_amount=$cancel_amountPayableAmt; 
									}	
								}
								/** End - Convert Cancel Amount **/
							
								
								
								/** Start - Convert Payable Amount **/
									$payable=$pro->payable_amount;
									if($admin_currency_code!=$pro->currencycode){
										$thePayable=customised_currency_conversion($currencyPerUnitSeller,$payable); 
									}else{
										$thePayable=$payable; 
									}								
								/** End - Convert Payable Amount **/
								
								
								
								
								/** Paid AMount*/
								if($pro->cancelled=='Yes'){
									//check policy here
									if ($pro->cancel_percentage!='0') {    //can_percentage 0 means no cash back to guest
										$thepaidAmount = $thePayable - $cancel_amount;
									}else{
										$thepaidAmount = $thePayable;
									}

								}else{
									$thepaidAmount = $thePayable;
								}					
								/** Paid AMount*/
								
								
		
									echo $admin_currency_symbol.''.$thepaidAmount;
							

								}else
								{
									echo $admin_currency_symbol.''."0.00";
								} ?>
							</td>
							<td class="center">
					<?php if($pro->paid_status == 'no')
					{
									

								/** Start - Convert Cancel Amount **/
								$cancel_amountBf = $pro->subtotal/100 * $pro->cancel_percentage;
								$cancel_amountPayableAmt = $balence=$pro->payable_amount/100 *  $pro->cancel_percentage; 
								if($admin_currency_code!=$pro->currencycode){
									if ($pro->cancel_percentage!='100') { 							
										$cancel_amount=customised_currency_conversion($currencyPerUnitSeller,$cancel_amountBf); 
									}else{							
										//$cancel_amount=$cancel_amountPayableAmt; 	
										$cancel_amount=customised_currency_conversion($currencyPerUnitSeller,$cancel_amountPayableAmt);  	
									}
								}else{
									if ($pro->cancel_percentage!='100') { 							
										$cancel_amount=$cancel_amountBf; 
									}else{							
										$cancel_amount=$cancel_amountPayableAmt; 
									}	
								}
								/** End - Convert Cancel Amount **/
							
								
								/** Start - Convert Payable Amount **/
								$payable=$pro->payable_amount;
								if($admin_currency_code!=$pro->currencycode){
									$thePayable=customised_currency_conversion($currencyPerUnitSeller,$payable); 
								}else{
									$thePayable=$payable; 
								}								
								/** End - Convert Payable Amount **/
								
		
								/** Balence AMount*/
								if($pro->cancelled=='Yes'){
									//check policy here
									if ($pro->cancel_percentage!='0') {    //can_percentage 0 means no cash back to guest
										$thebalenceAmount = $thePayable - $cancel_amount;
									}else{
										$thebalenceAmount = $thePayable;
									}

								}else{
									$thebalenceAmount = $thePayable;
								}					
								/** Balence AMount*/
								
								
									
						echo $admin_currency_symbol.''.$thebalenceAmount;
					//echo $admin_currency_symbol.''.($pro->payable_amount - $cancel_amount);
		
				}else
				{
					echo $admin_currency_symbol.''."0.00";
				}
								?>
							</td>
							<td class="center">
								<?php echo $pro->product_title;?>
							</td>
							<td class="center">
								<?php echo $pro->booking_status;?>
							</td>
   							
							
						</tr>
                        
						<?php 
						

							 }
							$i++;
						}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
                             <th class="tip_top" title="Click to sort">
								 S No
							</th>
							<th class="tip_top" title="Click to sort">
								Booking No
							</th>
							<th class="tip_top" title="Click to sort">
                            	Guest Email ID
                            </th>
							<th>
                            	Product Title
                            </th>
							<th class="tip_top" title="Click to sort">
								 Date Added
							</th>
							<th>
                            	Total Amount
                            </th>
							<th>
                            	Total Discount
                            </th>
							<th>
                            	Guest Service Amt
                            </th>
							<th>
                            	Cancellation Amt
                            </th>
							<th>
                            	Actual Profit
                            </th>
							<th>
                            	Used Wallet Amt
                            </th>
                            <th>
                            	paid
                            </th>
							<th>
                            	Balance
                            </th>
							
							<th>
								Product Title
							</th>
    
						
   							<th class="tip_top" title="Click to sort">
								Booking Status
							</th>

						<!--	<th>
								 Action
							</th> -->
						</tr>
						</tfoot>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" name="statusMode" id="statusMode"/>
			<input type="hidden" name="SubAdminEmail" id="SubAdminEmail"/>
		</form>	
			
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>