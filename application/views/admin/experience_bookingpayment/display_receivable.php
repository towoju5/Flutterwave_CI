<?php //echo '<pre>'; print_r($service_tax); die;
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
							<!--<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>-->
                            <th class="tip_top" title="Click to sort">
								S No
							</th>
							<th class="tip_top" title="Click to sort">
								Date
							</th>
                            <th class="tip_top" title="Click to sort">
								Booking No		
							</th>
							<!--<th class="tip_top" title="Click to sort">
								Property ID 
							</th>-->
							<!--<th>
								Guest Email
							</th>
                            <th>
                            	Guest Contact
                            </th>-->
							<th>
                            	Host Email Id 
                            </th>
							<th>
								Total Amount
							</th>
                            <th>
								Guest Service Fee
							</th>
							<th>
								Host Service Fee
                            </th>
							<th>
                            	Net Profit
                            </th>
                            <th>
                            	Amount to Host
                            </th>
						</tr>
						</thead>
						<tbody>
						<?php 
						if ($commissionTracking->num_rows() > 0){
						$i=1;
					//	print_r($commissionTracking->result());die;
							foreach ($commissionTracking->result() as $row){
						?>
						<tr>
							<td class="center">
								<?php echo $i;?>
							</td>
							<td class="center">
								<?php echo date('d-m-Y',strtotime($row->dateAdded));?>
							</td>
   							<td class="center">
								<?php echo $row->booking_no;?>
							</td>

							<td class="center">
								 <?php echo $row->host_email;?>
							</td>
							
							<td class="center">
							
							<?php
							
				///echo $admin_currency_symbol.' '.AdminCurrencyValue($row->prd_id ,$row->total_amount);
				      /*echo $admin_currency_symbol;
							
							
						if($admin_currency_code != $row->currencycode )
						{
							echo convertCurrency($row->currencycode,$admin_currency_code,$row->total_amount);	
						}	
						else
						{	echo $row->total_amount;
						}
						*/
						
						$currencyPerUnitSeller=$row->currencyPerUnitSeller; 
						//echo $currencyPerUnitSeller;
						//echo $row->total_amount;
						if($admin_currency_code != $row->currencycode ){
							//echo $admin_currency_symbol.' '.AdminCurrencyValue($row->prd_id ,$row->total_amount);
							echo $admin_currency_symbol.' '.customised_currency_conversion($currencyPerUnitSeller,$row->total_amount);	
						}else{
							echo $admin_currency_symbol.' '.$row->total_amount;
						}
						
							
							?>
							</td>
							
							
							<td class="center">
							<?php 

							//echo $admin_currency_symbol.' '.AdminCurrencyValue($row->prd_id ,$row->guest_fee);
							
							//echo $row->guest_fee."||";
							if($admin_currency_code != $row->currencycode ){
								//echo $admin_currency_symbol.' '.AdminCurrencyValue($row->prd_id ,$row->guest_fee);
								echo $admin_currency_symbol.' '.customised_currency_conversion($currencyPerUnitSeller,$row->guest_fee);	
							}else{
								echo $admin_currency_symbol.' '.$row->guest_fee;
							}
						
							?>
							</td>
							
							<td class="center">
							<?php //echo $admin_currency_symbol.' '.AdminCurrencyValue($row->prd_id ,$row->host_fee);
								if($admin_currency_code != $row->currencycode ){
									//echo $admin_currency_symbol.' '.AdminCurrencyValue($row->prd_id ,$row->host_fee);
									echo $admin_currency_symbol.' '.customised_currency_conversion($currencyPerUnitSeller,$row->host_fee);	
								}else{
									echo $admin_currency_symbol.' '.$row->host_fee;
								}
							?>
							</td>
							
							<td class="center">
							<?php // echo $admin_currency_symbol.' '.number_format(AdminCurrencyValue($row->prd_id ,$row->guest_fee+$row->host_fee),2);
								$net_profit=round($row->guest_fee+$row->host_fee,2);
								
								if($admin_currency_code != $row->currencycode ){
									//echo $admin_currency_symbol.' '.number_format(AdminCurrencyValue($row->prd_id ,$row->guest_fee+$row->host_fee),2);
									echo $admin_currency_symbol.' '.customised_currency_conversion($currencyPerUnitSeller,$net_profit);	
								}else{
									echo $admin_currency_symbol.' '.$net_profit;
								}
							 

							?>
							</td>
							
							<td class="center">
							<?php //echo $admin_currency_symbol.' '.AdminCurrencyValue($row->prd_id ,$row->payable_amount);
							
								if($admin_currency_code != $row->currencycode ){
									//echo $admin_currency_symbol.' '.AdminCurrencyValue($row->prd_id ,$row->payable_amount);
									echo $admin_currency_symbol.' '.customised_currency_conversion($currencyPerUnitSeller,$row->payable_amount);	
								}else{
									echo $admin_currency_symbol.' '.$row->payable_amount;
								}
							
							
							?>
							</td>
						
						</tr>
                        
						<?php 
							$i++; }
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<!--<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>-->
                            <th class="tip_top" title="Click to sort">
								S No
							</th>
							<th class="tip_top" title="Click to sort">
								Date
							</th>
                            <th class="tip_top" title="Click to sort">
								Booking No		
							</th>
							<th>
                            	Host Email Id
                            </th>
							<th>
								Total Amount
							</th>
							<th> 
								Guest Service Fee 
							</th>
							<th>
								Host Service Fee
                            </th>      
							<th>
                            	Net Profit
                            </th>
                            <th>
                            	Amount to Host
                            </th>
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