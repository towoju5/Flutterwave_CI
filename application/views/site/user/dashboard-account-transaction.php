<?php 
$this->load->view('site/templates/header');
?>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor account accountid1 accttranshistry">
	<div class="top-listing-head">
		<div class="main">   
			<?php $this->load->view('site/user/main_nav_header');   ?>
		</div>
	</div>
	<div class="dash_brd">
		<div id="command_center">
		
			<div class="lispg_top">
			<!--Side nav header -->
			<?php 
             $this->load->view('site/user/sub_nav_header');  
            ?>
            
			<div id="transaction_history" class="listiong-areas">
				<div class="box" id="my_listings">
					<div class="middle">
						<div class="tabbable-panel">
							<div class="tabbable-line">
								<ul class="nav nav-tabs ">
									<li class="active">
										<a href="#tab_default_1" data-toggle="tab"><?php if($this->lang->line('CompletedTransactions') != '') { echo stripslashes($this->lang->line('CompletedTransactions')); } else echo "Completed Transactions";?></a>
									</li>
									<li>
										<a href="#tab_default_2" data-toggle="tab"><?php if($this->lang->line('FutureTransactions') != '') { echo stripslashes($this->lang->line('FutureTransactions')); } else echo "Future Transactions";?></a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_default_1">
									<?php if(count($completed_transaction->result()) >0 ) { ?>
										<table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
											<thead>
												<tr height="40px">          
													<td width="10%" style="" ><strong><?php if($this->lang->line('Date') != '') { echo stripslashes($this->lang->line('Date')); } else echo "Date";?></strong></td>
													<td width="20%" style=""><strong><?php if($this->lang->line('Transaction_Method') != '') { echo stripslashes($this->lang->line('Transaction_Method')); } else echo "Transaction Method";?></strong></td>
													<td width="15%" style=""><strong><?php if($this->lang->line('TransactionId') != '') { echo stripslashes($this->lang->line('TransactionId')); } else echo "Transaction Id";?></strong></td>
													<td width="15%" style=""><strong><?php if($this->lang->line('Amount') != '') { echo stripslashes($this->lang->line('Amount')); } else echo "Amount";?></strong></td>
												</tr>
											</thead>
											<?php foreach($completed_transaction->result() as $row) { ?>
											<tbody>
												<td>
													<?php echo date('M d, Y',strtotime($row->dateAdded));?>
												</td>
												<td>
													<?php echo 'Via Bank';?>
												</td>
												<td>
													<?php echo $row->transaction_id;?>
												</td>
												<td>
												
												
												
												<?php
												
												
												
/* 												echo $currencySymbol."".$row->amount."".$row->currencycode;
										if($row->currencycode!=$this->session->userdata('currency_type')){		
											echo convertCurrency($row->currencycode,$this->session->userdata('currency_type'),$row->amount);
										}else{
											echo $row->amount;		
										}
										 */
										 
										 
			echo $currencySymbol;
			if($admin_currency_code!=$this->session->userdata('currency_type')){		
					echo convertCurrency($admin_currency_code,$this->session->userdata('currency_type'),$row->amount);	
			}else{				
					echo $row->amount;
			}
			
			
			
										
												?>
												
												
												
												
												
												</td>
											</tbody>
											<?php } ?>
										</table>
										<?php } else{ ?>
										<h3 class="status-text"><strong><?php if($this->lang->line('NoTransactions') != '') { echo stripslashes($this->lang->line('NoTransactions')); } else echo "No Transactions";?></strong></h3><?php } ?>
										<div id="footer_pagination"><?php echo $completed_transaction; ?></div>
									</div>
									<div class="tab-pane" id="tab_default_2">
										<?php if(count($featured_transaction->result()) >0){ ?>
										
										<table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
											<thead>
												<tr height="40px">          
													<td width="15%" style="" ><strong><?php if($this->lang->line('Date') != '') { echo stripslashes($this->lang->line('Date')); } else echo "Date";?></strong></td>
													<td width="35%" style=""><strong><?php if($this->lang->line('Details') != '') { echo stripslashes($this->lang->line('Details')); } else echo "Details";?></strong></td>
													<td width="30%" style=""><strong><?php if($this->lang->line('Amount') != '') { echo stripslashes($this->lang->line('Amount')); } else echo "Amount";?></strong></td>
												</tr>
											</thead>
											<?php foreach($featured_transaction->result() as $row){
												
												$currencyPerUnitSeller=$row->currencyPerUnitSeller;
												$unitPerCurrencyUser=$row->unitPerCurrencyUser;
												$user_currencycode=$row->user_currencycode;
												
												?>
											<tbody>
												<td>
													<?php  echo date('M d, Y',strtotime($row->dateAdded)); ?>
												</td>
												<td class="paddgns">
													
													<a target="_blank" href="users/show/<?php echo $row->GestId; ?>" style="float:left; "><?php echo $row->firstname;?></a><br><br /><?php echo "<a href='".base_url()."tour/".$row->product_id."'>".$row->product_title."</a><br>"; ?>
													<?php
														
													//echo $row->price;
													//echo  $row->currencycode;
													//echo $currencySymbol."".round(CurrencyValue($row->product_id ,$row->price ),2)." / Night";
													
													echo $currencySymbol."";
													if($row->currencycode != $this->session->userdata('currency_type')){

														if($row->currencycode==$this->session->userdata('currency_type')){
															if(!empty($currencyPerUnitSeller))
															echo customised_currency_conversion($currencyPerUnitSeller,$row->price);										
														}else{
															echo convertCurrency($row->currencycode,$this->session->userdata('currency_type'),$row->price);
														}

													}else{
														echo $row->price;
													}

													?><br>
													<?php if($this->lang->line('Booking No') != '') { echo stripslashes($this->lang->line('Booking No')); } else echo "Booking No"?>: <?php echo $row->Bookingno;?>
													
												</td>
												<td>
													<table>
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('Total') != '') { echo stripslashes($this->lang->line('Total')); } else echo "Total";?> </span></td><td style="text-align:right;"><?php
															
															//echo $currencySymbol."".round($row->totalAmt,2)."";
															echo $currencySymbol."";
															if($row->currencycode != $this->session->userdata('currency_type')){

																if($row->currencycode==$this->session->userdata('currency_type')){
																	if(!empty($currencyPerUnitSeller)){
																		$tt=customised_currency_conversion($currencyPerUnitSeller,$row->subTotal);
																		echo round($tt,2);
																	}
																
																
																}else{
																	
$tt=convertCurrency($row->currencycode,$this->session->userdata('currency_type'),$row->subTotal);
																	echo round($tt,2);
																}

															}else{
																echo round($row->subTotal,2);
															}
															
															?> 
															</td>
														</tr>
														<tr style="display:none">
															<td style="text-align:right;"><span><?php if($this->lang->line('ServiceFee') != '') { echo stripslashes($this->lang->line('ServiceFee')); } else echo "Service Fee";?> </span></td><td style="text-align:right;">
															<?php
															//echo $currencySymbol."".round($row->guest_fee,2)."";
															echo $currencySymbol."";
															if($row->currencycode != $this->session->userdata('currency_type')){

																if($row->currencycode==$this->session->userdata('currency_type')){
																	if(!empty($currencyPerUnitSeller)){
																		$g_f=customised_currency_conversion($currencyPerUnitSeller,$row->guest_fee);
																		echo round($g_f,2);
																	}
																}else{
																	$g_f=convertCurrency($row->currencycode,$this->session->userdata('currency_type'),$row->guest_fee);
																	echo round($g_f,2);
																}

															}else{
																echo round($row->guest_fee,2);
															}
																													
															?>

															</td>
														</tr>
														<?php /*
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('Host_Fee') != '') { echo stripslashes($this->lang->line('Host_Fee')); } else echo "Host Fee";?> </span></td><td style="text-align:right;">
															<?php
															//echo $currencySymbol."".round($row->host_fee,2)."";
															
															echo $currencySymbol."";
															if($row->currencycode != $this->session->userdata('currency_type')){

																if($row->currencycode==$this->session->userdata('currency_type')){
																	if(!empty($currencyPerUnitSeller)){
																		$h_f=customised_currency_conversion($currencyPerUnitSeller,$row->host_fee);
																		echo round($h_f,2);
																	}
																}else{
																	$h_f=convertCurrency($row->currencycode,$this->session->userdata('currency_type'),$row->host_fee);
																	echo round($h_f,2);
																}

															}else{
																echo round($row->host_fee,2);
															}
															
															?> 
															
															</td>
														</tr>
														
														*/?>
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('SecurityDeposit') != '') { echo stripslashes($this->lang->line('SecurityDeposit')); } else echo "Security Deposit";?></span></td><td style="text-align:right;">
															<?php
															//echo $currencySymbol."".round($row->host_fee,2)."";
															echo $currencySymbol."";
															if($row->currencycode != $this->session->userdata('currency_type')){

																if($row->currencycode==$this->session->userdata('currency_type')){
																	if(!empty($currencyPerUnitSeller)){
																		$h_f=customised_currency_conversion($currencyPerUnitSeller,$row->secDeposit);
																		echo round($h_f,2);
																	}
																}else{
																	$h_f=convertCurrency($row->currencycode,$this->session->userdata('currency_type'),$row->secDeposit);
																	echo round($h_f,2);
																}

															}else{
																echo round($row->secDeposit,2);
															}
															
															?> 
															
															</td>
														</tr>
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('Net Amount') != '') { echo stripslashes($this->lang->line('Net Amount')); } else echo "Net Amount";?> </span></td><td style="text-align:right;">
															<?php 
															
															//echo $currencySymbol."".round($row->payable_amount,2)."";
															
															echo $currencySymbol."";
															if($row->currencycode != $this->session->userdata('currency_type')){

																if($row->currencycode==$this->session->userdata('currency_type')){
																	if(!empty($currencyPerUnitSeller)){
																		$p_a=customised_currency_conversion($currencyPerUnitSeller,$row->payable_amount);
																		echo round($p_a,2);
																	}
																}else{
																	$p_a=convertCurrency($row->currencycode,$this->session->userdata('currency_type'),$row->payable_amount);
																	echo round($p_a,2);
																}

															}else{
																echo round($row->payable_amount,2);
															}
															
															?> 
															</td>
														</tr>
													</table>
												</td>
											</tbody>
											<?php } ?>
										</table>
										<?php } else { ?>
										<h3 class="status-text"><?php if($this->lang->line('NoTransactions') != '') { echo stripslashes($this->lang->line('NoTransactions')); } else echo "No Transactions";?>  </h3>
										<?php } ?>
										<div id="footer_pagination"><?php echo $featuredpaginationLink; ?></div>
									</div>
								</div>
							</div>
						</div>
						<div class="show_all_reservations">
						</div>
					</div>
				</div>
			</div></div>
		</div>
	</div>
</div>
<!---DASHBOARD-->
<!---FOOTER-->
<script type="text/javascript">
function redirect()
{
}
function transaction_change(elem,booking_status)
{
var cur_field=$(elem).attr('id');
var cur_value=$(elem).val();
cur_value= cur_value.replace(' ', '-');
if(cur_field !="" && cur_value !="")
{
window.location='<?php echo base_url()?>account-trans/'+cur_field+'/'+cur_value+'/'+booking_status;
}
else{
window.location='<?php echo base_url();?>account-trans/'+booking_status;
}

}

function gross_earning(elem)
{
var cur_field=$(elem).attr('id');
var cur_value=$(elem).val();
cur_value= cur_value.replace(' ', '-');
if(cur_field !="" && cur_value !="")
{
window.location='<?php echo base_url()?>gross-earning/'+cur_field+'/'+cur_value;
}
else{
window.location='<?php echo base_url()?>gross-earning/';
}
}
</script>
<?php 
$this->load->view('site/templates/footer');
?>