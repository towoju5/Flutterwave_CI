
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
				<div class="right">
					<h5>Admin Total Profit: <?php echo $admin_currency_symbol.' '.$adminProfit;	?></h5>
					<br>
					<h5>Total Used Wallet Amount: <?php echo $admin_currency_symbol.' '.$tot_usedWallet;	?></h5>
					<br>
					<h5>Balance: <?php echo $admin_currency_symbol.' '.($adminProfit-$tot_usedWallet);	?></h5>
				</div>
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						</div>
					</div>
					<div class="widget_content">
						<table class="display display_tbl" id="wallet_tbl">
							<thead>
								<tr>
									<th class="tip_top" title="Click to sort">
										SNo.
									</th>
									<th class="tip_top" title="Click to sort">
										Name
									</th>
									<th class="tip_top" title="Click to sort">
										Email
									</th>
									<th class="tip_top" title="Total Amount on Wallet">
										Total Wallet Amnt
									</th>
									<th class="tip_top" title="Total Amount used from wallet">
										Used Wallet
									</th>
									
									<th class="tip_top" title="Available Balance  on Wallet">
										Balance
									</th>
									
								</tr>
							</thead>
							<tbody>
							<?php 
							//print_r($walletData);
							if (count($walletData) > 0){
								//echo count($trackingDetails);
								$i=1;
								//echo "<pre>"; print_r($trackingDetails); die;
								
								foreach ($walletData as $details){
								
								
							?>
							<tr>
								<td>
									<?php echo $i;?>
								</td>
								<td>
									<?php echo $details['name'];?>
								</td>
								<td>
									<?php echo $details['email'];?>
								</td>
								<td>
									<?php echo $admin_currency_symbol.' '.number_format($details['totalReferalAmount'], 2);?>
								</td>
								<td>
									<?php echo $admin_currency_symbol.' '.number_format($details['usedWallet'], 2);?>
								</td>
								<!--<td>
									<?php //echo $admin_currency_symbol.' '.number_format($details['host_fee'], 2);?>
								</td>-->
								<!--<td>
									<?php //echo $admin_currency_symbol.' '.number_format($details['Rep_fee'], 2);?>
									<td>-->
								<td>
						<?php echo $admin_currency_symbol.' '.number_format($details['totalReferalAmount']-$details['usedWallet'], 2);?>
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
									Name
								</th>
								<th class="tip_top" title="Click to sort">
									Email
								</th>
								<th class="tip_top" title="Click to sort">
									Total Wallet Amnt
								</th>
								<th class="tip_top" title="Click to sort">
									Used Wallet
								</th>
								
								<th class="tip_top" title="Click to sort">
									Balance
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