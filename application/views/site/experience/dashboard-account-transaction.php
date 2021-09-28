<?php 
$this->load->view('site/templates/header');
?>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor account accountid1 accttranshistry">
	<div class="top-listing-head">
		<div class="main">   
			<!--main nav header -->  

                <?php 
                    $this->load->view('site/user/main_nav_header');  
                ?>

                 
		</div>
	</div>
	<div class="dash_brd">
		<div id="command_center">
			<div class="dashboard-sidemenu">
				<div class="lispg_top">
				<!--main nav header -->  
                <?php 
                    $this->load->view('site/user/main_nav_header');  
                ?>

                <!--experience sub nav header -->
                <?php 
                    $this->load->view('site/experience/subnav_of_experiences');  
                ?>
               </div>
            </div>
            
			<div id="transaction_history" class="listiong-areas">
				<div class="box" id="my_listings">
					<div class="middle">
						<div class="tabbable-panel">
							<div class="tabbable-line">
								<ul class="nav nav-tabs customTabs_Page">
								<!-- class="active"-->
									<li>
										<a href="#tab_default_1" data-toggle="tab"><?php if($this->lang->line('CompletedTransactions') != '') { echo stripslashes($this->lang->line('CompletedTransactions')); } else echo "Completed Transactions";?></a>
									</li>
									<?php $forTab=$this->uri->segment(2); ?>
									<li>
										<a href="#tabTwo"  data-toggle="tab"><?php if($this->lang->line('FutureTransactions') != '') { echo stripslashes($this->lang->line('FutureTransactions')); } else echo "Future Transactions";?></a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_default_1">
									<?php if(count($completed_transaction->result()) >0 ) { ?>
										<table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
											<thead>
												<tr height="40px">          
													<td width="10%" style="" ><strong>Payment Date</strong></td>
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
													<?php if($row->payment_type=='ON') echo 'Paypal'; else 
													{ if($this->lang->line('via_bank') != '') { echo stripslashes($this->lang->line('via_bank')); } else echo "Via Bank"; } ?>
												</td>
												<td>
													<?php echo $row->transaction_id;?>
												</td>
												<td><?php

												//echo $row->amount;
												
			//echo $currencySymbol;
			if($admin_currency_code!=$this->session->userdata('currency_type')){		
					echo convertCurrency($admin_currency_code,$this->session->userdata('currency_type'),$row->amount);	
			}else{				
					echo $row->amount;
			}
			
												
												
												?></td>
											</tbody>
											<?php } ?>
										</table>
										<?php } else{ ?>
										<h3 class="status-text"><strong><?php if($this->lang->line('NoTransactions') != '') { echo stripslashes($this->lang->line('NoTransactions')); } else echo "No Transactions";?></strong></h3><?php } ?>
										<div id="footer_pagination"><?php echo $completedpaginationLink; ?></div>
									</div>
									<div class="tab-pane" id="tabTwo">
										<?php if(count($featured_transaction->result()) >0)
										{ ?>
										<table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
											<thead>
												<tr height="40px">          
													<td width="15%" style="" ><strong><?php if($this->lang->line(' Booked date') != '') { echo stripslashes($this->lang->line('Booked Date')); } else echo "Booked date";?></strong></td>
													<td width="35%" style=""><strong><?php if($this->lang->line('Details') != '') { echo stripslashes($this->lang->line('Details')); } else echo "Details";?></strong></td>
													<td width="30%" style=""><strong><?php if($this->lang->line('Amount') != '') { echo stripslashes($this->lang->line('Amount')); } else echo "Amount";?></strong></td>
												</tr>
											</thead>
											<?php foreach($featured_transaction->result() as $row){
												
												//print_r($row);
												$currencyPerUnitSeller=$row->currencyPerUnitSeller;
												$unitPerCurrencyUser=$row->unitPerCurrencyUser;
												$user_currencycode=$row->user_currencycode;
												//echo $row->currencycode;
												
												?>
											<tbody>
												<td>
													<?php  echo date('M d, Y',strtotime($row->dateAdded)); ?>
												</td>
												<td class="paddgns">													<a target="_blank" href="users/show/<?php echo $row->GestId; ?>" style="float:left; "><?php echo $row->firstname;?></a><br><br /><?php echo "<a href='".base_url()."view_experience/".$row->product_id."'>".$row->product_title."</a><br>"; ?>				
													
													<?php 

/*
													echo strtoupper($currencySymbol);
													
													if($row->currency != $this->session->userdata('currency_type'))
								                    {
								                     echo convertCurrency($row->currency,$this->session->userdata('currency_type'),$row->price);
								                     }
								                     else{
								                     	 echo $row->price;
								                     }
													 
													 */
													
													echo $currencySymbol."";
													if($row->currency != $this->session->userdata('currency_type')){
														
													

														if($row->currency==$this->session->userdata('currency_type')){
															
															//echo $currencyPerUnitSeller;
															if(!empty($currencyPerUnitSeller))
																
															echo customised_currency_conversion($currencyPerUnitSeller,$row->price);										
														}else{
															
															echo convertCurrency($row->currency,$this->session->userdata('currency_type'),$row->price);
														}

													}else{
														echo $row->price;
													}
													 
								                     ?>
													
													<br>
													<?php if($this->lang->line('Booking No') != '') { echo stripslashes($this->lang->line('Booking No')); } else echo "Booking No"?>: <?php echo $row->Bookingno;
												
													if($row->checkin!='0000-00-00 00:00:00' && $row->checkout!='0000-00-00 00:00:00'){ echo "<br>".date('M d, Y',strtotime($row->checkin))." - ".date('M d, Y',strtotime($row->checkout))."<br>";};
													
													
									/**To Show Schedule Dates**/
										if ($row->date_id!=''){
									$date_id=$row->date_id;
									$query="SELECT * FROM ".EXPERIENCE_TIMING." WHERE exp_dates_id=".$date_id;
									$TimesAre=$this->experience_model->ExecuteQuery($query);
									$count=$TimesAre->num_rows();
										echo "<p class='toggleSchedule'>Read Timings(".$count.")</p><div class='scheduleDetails'>";
											foreach ($TimesAre->result() as $sched) {	 ?>
										
												<div>
													<?php
													echo '<b>'.$sched->title.'</b><br>'; 
													echo date('M d, Y',strtotime($sched->schedule_date));
													echo '<div class="timings">'.date('H:i',strtotime($sched->start_time)).' - '. date('H:i',strtotime($sched->end_time)).'</div>' ;
														?>							
												</div>
											<?php }
											echo "</div>";
										}
										/**To Show Schedule Dates End**/		
	
													?>
													
												</td>
												<td>
													<table>
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('Total') != '') { echo stripslashes($this->lang->line('Total')); } else echo "Total";?> </span></td><td style="text-align:right;"><?php
															
															//echo $currencySymbol."".round($row->totalAmt,2)."";
															echo $currencySymbol."";
															if($row->currency != $this->session->userdata('currency_type')){

																if($row->currency==$this->session->userdata('currency_type')){
																	echo $currencyPerUnitSeller."vv";
																	if(!empty($currencyPerUnitSeller)){
																		$tt=customised_currency_conversion($currencyPerUnitSeller,$row->totalAmt);
																		//echo round($tt,2);
																		echo $tt;
																	}
																
																
																}else{
																	
																	
																	
$tt=convertCurrency($row->currency,$this->session->userdata('currency_type'),$row->totalAmt);
																	//echo round($tt,2);
																	echo $tt;
																}

															}else{
																echo round($row->totalAmt,2);
															}
															
															?> 
															
															</td>
														</tr>
														
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('ServiceFee') != '') { echo stripslashes($this->lang->line('ServiceFee')); } else echo "Service Fee";?> </span></td><td style="text-align:right;">
															<?php
															//echo $currencySymbol."".round($row->guest_fee,2)."";
															echo $currencySymbol."";
															if($row->currency != $this->session->userdata('currency_type')){

																if($row->currency==$this->session->userdata('currency_type')){
																	if(!empty($currencyPerUnitSeller)){
																		$g_f=customised_currency_conversion($currencyPerUnitSeller,$row->guest_fee);
																		//echo round($g_f,2);
																		echo $g_f;
																	}
																}else{
																	$g_f=convertCurrency($row->currency,$this->session->userdata('currency_type'),$row->guest_fee);
																	//echo round($g_f,2);
																	echo $g_f;
																}

															}else{
																echo round($row->guest_fee,2);
															}
																													
															?>

															</td>
														</tr>
														
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('Net Amount') != '') { echo stripslashes($this->lang->line('Net Amount')); } else echo "Net Amount";?> </span></td><td style="text-align:right;">
															<?php 
															
															//echo $currencySymbol."".round($row->payable_amount,2)."";
															
															echo $currencySymbol."";
															if($row->currency != $this->session->userdata('currency_type')){

																if($row->currency==$this->session->userdata('currency_type')){
																	if(!empty($currencyPerUnitSeller)){
																		$p_a=customised_currency_conversion($currencyPerUnitSeller,$row->payable_amount);
																		//echo round($p_a,2);
																		echo $p_a;
																	}
																}else{
																	$p_a=convertCurrency($row->currency,$this->session->userdata('currency_type'),$row->payable_amount);
																	//echo round($p_a,2);
																	echo $p_a;
																}

															}else{
																echo round($row->payable_amount,2);
															}
															
															?> 
															</td>
														</tr>
													
													
													<?php /*
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('Total') != '') { echo stripslashes($this->lang->line('Total')); } else echo "Total";?> </span></td><td style="text-align:right;"><?php

															echo strtoupper($currencySymbol)."".round($row->totalAmt,2)."";
															
															
															
															?> 
															</td>
														</tr>
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('ServiceFee') != '') { echo stripslashes($this->lang->line('ServiceFee')); } else echo "Service Fee";?> </span></td><td style="text-align:right;"><?php echo strtoupper($currencySymbol)."".round($row->guest_fee,2)."";?> </td>
														</tr>
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('Host_Fee') != '') { echo stripslashes($this->lang->line('Host_Fee')); } else echo "Host Fee";?> </span></td><td style="text-align:right;"><?php echo strtoupper($currencySymbol)."".round($row->host_fee,2)."";?> </td>
														</tr>
														<tr>
															<td style="text-align:right;"><span><?php if($this->lang->line('Net Amount') != '') { echo stripslashes($this->lang->line('Net Amount')); } else echo "Net Amount";?> </span></td><td style="text-align:right;"><?php echo strtoupper($currencySymbol)."".round($row->payable_amount,2)."";?> </td>
														</tr>
														
												*/?>
												
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



<!-- to toggle the timings-->
<script>
	$(document).on("click",".toggleSchedule",function(){
		$(this).next(".scheduleDetails").slideToggle();
	});
	
	$('.customTabs_Page a').click(function(e) {
	  e.preventDefault();
	  $(this).tab('show');
	});

	// store the currently selected tab in the hash value
	$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
	  var id = $(e.target).attr("href").substr(1);
	  window.location.hash = id;
	});

	// on load of the page: switch to the currently selected tab
	var hash = window.location.hash;
	$('.customTabs_Page a[href="' + hash + '"]').tab('show');


</script>
<?php 
$this->load->view('site/templates/footer');
?>