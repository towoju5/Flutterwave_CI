<?php 
$this->load->view('site/templates/header');
$today =  date('Y-m-d',strtotime(date('Y-m-d', strtotime("-2 days"))));
$today = $today.' 00:00:00';

?>

<style>
/*.modal.msg-popup, .modal.cancle-popup, .modal.trip-popup {
    top: 15%;
    width: auto;
}
*/
/*.modal.cancle-popup, .modal.trip-popup {
    min-height: 400px;
}*/

</style>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery.colorbox.js"></script>

<script type="text/javascript" src="js/jquery-ui-1.8.12.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.stars.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/jquery.ui.stars.min.css" />
<script src="js/jRating.jquery.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/site/jquery.RatingStars.css" type="text/css" />
<link rel="stylesheet" href="css/site/my-account.css" type="text/css" />
<script src="js/site/jquery-ui-1.8.18.custom.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/site/jquery-ui-1.8.18.custom.css" />
<!---DASHBOARD-->
<div class="dashboard yourlisting trip bgcolor dasbmytripsnwthm">
<div class="top-listing-head">
	<div class="main">   
		<?php 
             $this->load->view('site/user/main_nav_header');  
            ?>
	</div>
</div>
<div class="dash_brd">
	<div id="command_center">
	<div class="lispg_top">
		<div class="dashboard-sidemenu">
		
		<!--<ul class="subnav">
			<li class="active"><a href="<?php //echo base_url();?>my_experience/upcoming"><?php //if($this->lang->line('YourExpeirence') != '') { echo stripslashes($this->lang->line('YourExpeirence')); } else echo "My Expeirences";?></a></li>
			<li><a href="<?php //echo base_url();?>my_experience/previous"><?php //if($this->lang->line('PreviousExperiences') != '') { echo stripslashes($this->lang->line('PreviousExperiences')); } else echo "Previous Experiences";?></a></li>
		</ul>-->
		
			 <!--experience sub nav header -->
            <?php 
             $this->load->view('site/experience/subnav_of_experiences');  
            ?>
		
		
		
		
		
		</div>

		<div class="current_trips" id="trips">
			<div id="account">

				<div class="box">
					<div class="middle">
						<div style="margin:0;padding:0;display:inline"></div>
						<h2><?php if($this->lang->line('YourExperience') != '') { echo stripslashes($this->lang->line('YourExperience')); } else echo "My Experience";?></h2>
						<div class="section notification_section">
							<div class="notification_area">
								<form method="post" action="" accept-charset="UTF-8">
									<input type="text" placeholder="<?php if($this->lang->line('Search Your Trips') != '') { echo stripslashes($this->lang->line('Search Your Trips')); } else echo "Search Your Trips";?>" name="product_title" value="">
									<input class="sesarch-areas-btn" type="submit" value="<?php if($this->lang->line('Search') != '') { echo stripslashes($this->lang->line('Search')); } else echo "Search"; ?>">
								</form>
								<?php if($bookedRental->num_rows() >0){?>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
								<thead>
									<tr height="40px">
										<td style="width:100px"><strong><strong><?php if($this->lang->line('BookedOn') != '') { echo stripslashes($this->lang->line('BookedOn')); } else echo "Booked On";?></strong></td>
										<td style="width:100px"><strong><?php if($this->lang->line('ExperienceName') != '') { echo stripslashes($this->lang->line('ExperienceName')); } else echo "Experience Name";?></strong></td>
										<td style="width:100px"><strong><?php if($this->lang->line('Host') != '') { echo stripslashes($this->lang->line('Host')); } else echo "Host";?></strong></td>
										<td style="width:140px"><strong><?php  if($this->lang->line('DatesandLocation') != '') { echo stripslashes($this->lang->line('DatesandLocation')); } else echo "Dates and Location"; ?></strong></td>
										<td style="width:150px"><strong><?php if($this->lang->line('Amount') != '') { echo stripslashes($this->lang->line('Amount')); } else echo "Amount";?></strong></td>
										<td style="width:50px"><strong><?php if($this->lang->line('PaymentStatus') != '') { echo stripslashes($this->lang->line('PaymentStatus')); } else echo "Payment Status";?></strong></td>
										<td style="width:50px"><strong><?php if($this->lang->line('HostApproval') != '') { echo stripslashes($this->lang->line('HostApproval')); } else echo "Host Approval";?></strong></td>
										<td style="width:50px"><strong><?php if($this->lang->line('Host Status') != '') { echo stripslashes($this->lang->line('Host Status')); } else echo "Host Status";?></strong></td>
									</tr>
								</thead>
								<?php foreach($bookedRental->result() as $row){ 
								
								$currencyPerUnitSeller=$row->currencyPerUnitSeller;
								$unitprice=$row->unitPerCurrencyUser;
								$user_currencycode=$row->user_currencycode;

								$paymentstatus = $this->experience_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT,array('Enquiryid'=>$row->cid));
								$chkval = $paymentstatus->num_rows();
								$status = $paymentstatus->row()->status;
								
								$pr_details = $this->experience_model->get_all_details(EXPERIENCE,array('user_id'=>$row->user_id));
								
								
								
								?>
								
								
								<tbody>
									<tr>
										<td><?php echo date('M d, Y',strtotime($row->dateAdded));?></td>
										<td><img src="<?php if(strpos($row->product_image, 's3.amazonaws.com') > 1)echo $row->product_image;else echo base_url()."server/php/experience/".$row->product_image; ?>" width="100" height="100" alt="<?php echo $row->experience_title; ?>"/> <a target="_blank" href="<?php echo base_url(); ?>view_experience/<?php echo $row->product_id; ?>" style="float:left;width:100%"></br><?php echo $row->product_title; ?></a></td>
										<td><a target="_blank" href="users/show/<?php echo $row->renter_id; ?>" style=""><?php echo $row->firstname." ".$row->lastname;?></a></td>
										<td class="area-tags"> <?php  if($row->checkin!='0000-00-00 00:00:00' && $row->checkout!='0000-00-00 00:00:00'){ echo "<br>".date('M d, Y ',strtotime($row->checkin))." - <br>".date('M d, Y ',strtotime($row->checkout))."<br>";
										
										
									
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
													echo '<div class="timings">'.date('H:i A',strtotime($sched->start_time)).' - '. date('H:i A',strtotime($sched->end_time)).'</div>' ;
														?>							
												</div>
											<?php }
											echo "</div>";
									}
										/**To Show Schedule Dates End**/	
										
										
										
										/*
										if($row->product_title !=''){
											echo "<a href='".base_url()."rental/".$row->product_id."'>".$row->product_title."</a><br>";
										}*/

										if($row->city_name!='')
											echo $row->city_name;
										if($row->city_name!='' && $row->state_name!='')
											echo ', ';
										if( $row->state_name!='')
											echo $row->state_name ;
										if($row->country_name!='' && $row->state_name!='')
											echo ', ';
										if($row->country_name!='')
											echo $row->country_name.'.'; 
										echo "<br>";
										echo "<label style='font-weight:bold;'>Booking No :</label>".$row->bookingno;}

										?>
										</td>
										<td>
											<?php  echo $currencySymbol; ?>
										<?php /*if($row->offer > 0){
											//foreach($result as $product){}

											if($row->currency != $this->session->userdata('currency_type'))
						                      {
						                      

						                     echo convertCurrency($row->currency,$this->session->userdata('currency_type'),$totalAmt);

						                     }
											else{
						                     	 echo $totalAmt;
						                     }

										}
										

										else */{ 
											if($row->secDeposit != 0)
											{
											 $securityDeposite = $row->secDeposit;
											
											}

											if($row->cleaningFee != 0)
											{
											 $cleaningFee = $row->cleaningFee;
											
											}
											foreach($result as $product){}

											$totalAmount = $row->subTotal + $row->serviceFee + $securityDeposite + $cleaningFee;
											/*
											if($row->currency != $this->session->userdata('currency_type'))
						                      {
						                     echo convertCurrency($row->currency,$this->session->userdata('currency_type'),$totalAmount);

						                     }
											else{
						                     	 echo $totalAmount;
						                     }
											 */
											
											if($row->currency != $this->session->userdata('currency_type')){

						                     //echo convertCurrency($row->currency,$this->session->userdata('currency_type'),$totalAmount);
											
											
											 if($user_currencycode==$this->session->userdata('currency_type')){ 
												if(!empty($unitprice))
												echo customised_currency_conversion($unitprice,$totalAmount);
											 }else{
												 echo convertCurrency($row->currency,$this->session->userdata('currency_type'),$totalAmount);
											 }

						                     }else{
						                     	 echo $totalAmount;
						                     }									

											//echo $row->totalAmt;
											//echo $product->currency;
											//echo  convertCurrency($product->currency,$this->session->userdata('currency_type'),$row->totalAmt)."<br>";

											//echo $currencySymbol." ".convertCurrency(USD,$this->session->userdata('currency_type'),$row->totalAmt);	
							                 } ?> 
							                 <?php  echo $this->session->userdata('currency_type'); ?>
							                 <br>
							                 <?php 
							                  //malar 8/7/2017 wallet notify
							                 if($row->walletAmount!='0.00')
							                 {
												 
												if($this->lang->line('Wallet') != '') {
											$wallet= stripslashes($this->lang->line('Wallet')); 
											} 
											else $wallet= "Wallet";

											
												 
							                 	echo  "$wallet: ".$currencySymbol; 

							                 	if($row->currency != $this->session->userdata('currency_type')){

													if($user_currencycode==$this->session->userdata('currency_type')){
														if(!empty($unitprice))
														echo customised_currency_conversion($unitprice,$row->walletAmount);										
													}else{
														 echo convertCurrency($row->currency,$this->session->userdata('currency_type'),$row->walletAmount);
													}

												}else{
													echo $row->walletAmount;
												}
							                     echo " ".$this->session->userdata('currency_type');
							                 }
							                 ?>	
							                 <br>
							                 <?php 
							                 //malar 12/7/2017 discount notify
							                 if($row->is_coupon_used=='Yes')
							                 {
							                 	echo  "Coupon: ".$currencySymbol; 
							                 	$couponPrice = ($row->total_amt - $row->discount);
												
												if($row->currency != $this->session->userdata('currency_type')){

													if($user_currencycode==$this->session->userdata('currency_type')){
														if(!empty($unitprice))
														echo customised_currency_conversion($unitprice,$couponPrice);										
													}else{
														 echo convertCurrency($row->currency,$this->session->userdata('currency_type'),$couponPrice);
													}

												}else{
													echo $couponPrice;
												}
											
							                    echo " ".$this->session->userdata('currency_type');
							                    
							                 }

							                 ?>

										</td>
										
										
								<!--<p><?php //if($row->dateAdded < $today) { if($status=="Paid"){if($this->lang->line('Booked') != '') { echo stripslashes($this->lang->line('Booked')); } else echo "Booked";}if($this->lang->line('Expired') != '') { echo stripslashes($this->lang->line('Expired')); } else echo "Expired";} else { 
										/* if($status=="Paid") 
										{ if($this->lang->line('Booked') != '') { echo stripslashes($this->lang->line('Booked')); } else echo "Booked";}
										else {
											$paymentstatus = $this->experience_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT,array('Enquiryid'=>$row->cid));
											
											$chkval = $paymentstatus->num_rows();
											$chkval1 = $paymentstatus->row()->status;
											
											if($row->approval=='Accept' && ($chkval == 0 || $chkval1 == 'Pending')) { */	 ?>
											<a class="" href="site/experience/confirmbooking/<?php //echo  $row->cid; ?>"><?php //if($this->lang->line('Pay') != '') { echo stripslashes($this->lang->line('Pay')); } else echo "Pay";?></a><?php// } else { if($this->lang->line('Pending') != '') { echo stripslashes($this->lang->line('Pending')); } else echo "Pending"; } 
											
											
										//}
										//} ?> </p>	-->	
										
										
										
										<td>
										
										
										<p>
										<?php
									
if($status=="Paid"){	
if($this->lang->line('Booked') != '') { echo stripslashes($this->lang->line('Booked')); } else echo "Booked";
}else{

	$date_id=$row->date_id;
	$check_in=date('Y-m-d',(strtotime ( $row->checkin)));
	$Query="SELECT IFNULL(count(eq.date_id),0) as date_booked_count from ".EXPERIENCE_ENQUIRY." as eq where eq.date_id=".$date_id." and eq.booking_status='".Booked."'";
	$BookedSlots=$this->experience_model->ExecuteQuery($Query);
	$AvailableSlots=$row->group_size-$BookedSlots->row()->date_booked_count;
	$today =  date('Y-m-d',strtotime(date('Y-m-d')));
	$BeforOneDay= date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $today) ) ));
	
	if ($AvailableSlots!='0' && $BeforOneDay <= $check_in){   //dec 9 +1 dec10<=dec10 untill ?> 
	<a class="" href="site/experience/confirmbooking/<?php echo  $row->cid; ?>"><?php if($this->lang->line('Pay') != '') { echo stripslashes($this->lang->line('Pay')); } else echo "Pay";?></a>
	<?php }else if ($AvailableSlots!='0' && $check_in <=  $today){ 
		if($this->lang->line('Expired') != '') { echo stripslashes($this->lang->line('Expired')); } else echo "Expired";
	}else  if ($AvailableSlots=='0' && $BeforOneDay <= $check_in){ 
		if($this->lang->line('Expired') != '') { echo stripslashes($this->lang->line('Expired')); } else echo "Expired";
	}else{
		if($this->lang->line('Expired') != '') { echo stripslashes($this->lang->line('Expired')); } else echo "Expired";
	}
}	
?>										
 </p> 
												
										<?php if($status=="Paid"){
										?>
										<a href="site/experience/invoice/<?php echo  $row->bookingno; ?>" target="_blank"><?php if($this->lang->line('Receipts/Invoice') != '') { echo stripslashes($this->lang->line('Receipts/Invoice')); } else echo "Receipts/Invoice";?></a> 
										<?php  
										$this->data['reviewData_all'] = $this->experience_model->get_trip_review_all($userDetails->row()->id);
										$this->data['reviewData'] = $this->experience_model->get_trip_review($row->bookingno,$userDetails->row()->id); 
										if($this->data['reviewData']->num_rows==0) { ?>
										<a data-toggle="modal" href="#add_review" onclick="return add_data(this)" user_id="<?php echo $row->renter_id;?>" product_id="<?php echo $row->product_id;?>" reviewer_id="<?php if($userDetails!='no') { echo $userDetails->row()->id; }?>" booking_no="<?php if($userDetails!='no') { echo $row->bookingno; }?>" pro_title="<?php echo $row->product_title; ?>" img_src="<?php echo base_url()."server/php/experience/".$row->product_image; ?>"><?php if($this->lang->line('Review') != '') { echo stripslashes($this->lang->line('Review')); } else echo "Review";?></a>
										<?php }else {?>
										<a data-toggle="modal" href="#display_review" onclick="return booking_review(this)"  user_id="<?php echo $row->renter_id;?>" product_id="<?php echo $row->product_id;?>" booking_no="<?php echo $row->bookingno;?>" reviewer_id="<?php if($userDetails!='no') { echo $userDetails->row()->id; }?>" ><?php if($this->lang->line('YourReview') != '') { echo stripslashes($this->lang->line('YourReview')); } else echo "Your Review";?></a>
										<?php }?>
										
										
										<?php 
										$Check_date = $this->experience_model->get_all_details(EXPERIENCE_ENQUIRY,array('user_id'=>$user_id,'prd_id'=>$row->product_id));
											
											//print_r($Check_date->result_array());
											$time_val = date('Y-m-d');
											$check_in = date("Y-m-d", strtotime($row->checkin));
											$check_out = date("Y-m-d", strtotime($row->checkout));
										?>
										<?php


										$dis_details = $this->experience_model->get_all_details(EXPERIENCE_DISPUTE,array('user_id'=>$user_id,'prd_id'=>$row->product_id,'booking_no'=>$row->bookingno));
										$admin = $this->experience_model->getAdminSettings(ADMIN_SETTINGS);
										$dipute_day = $admin->row()->dispute_days;
											$after_day =  strtotime("+".$dipute_day."days",strtotime($check_in));
											$out_date = date('Y-m-d',$after_day);
										 if($dis_details->num_rows() == 0){
											
											//$time_val should be lesser than the $out_date
											/** Start -  To Allow Cancel button Based on Admin defined days*/

							$hideCancelDay = $this->config->item ('cancel_hide_days_experience');
							$totlessDays=$hideCancelDay+1; //from checkin date before (n) days
							$minus_checkin =  strtotime("-".$totlessDays."days",strtotime($check_in));
							$checkinBeforeDay = date('Y-m-d',$minus_checkin);

							/** End - To Allow Cancel button Based on Admin defined days*/
							if ($time_val<= $checkinBeforeDay) { 										
											if(($time_val) < $out_date){
												 
													if(($time_val) > $check_in){ ?>
															
													<?php /*
													//no dispute
														
														<br><a data-toggle="modal" href="#add_dispute_<?php echo $row->product_id; ?>" onclick="return add_data(this)" user_id="<?php echo $row->renter_id;?>" product_id="<?php echo $row->product_id;?>" reviewer_id="<?php if($userDetails!='no') { echo $userDetails->row()->id; }?>" booking_no="<?php if($userDetails!='no') { echo $row->bookingno; }?>" ><?php if($this->lang->line('Dispute') != '') { echo stripslashes($this->lang->line('Dispute')); } else echo "Dispute";?></a>
													*/ ?>
														
														<?php }	else{ ?>
														
															<br><a data-toggle="modal" href="#cancel_booking_<?php echo $row->product_id; ?>" onclick="return add_data(this)" user_id="<?php echo $row->renter_id;?>" product_id="<?php echo $row->product_id;?>" reviewer_id="<?php if($userDetails!='no') { echo $userDetails->row()->id; }?>" booking_no="<?php if($userDetails!='no') { echo $row->bookingno; }?>" ><?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel";?></a>
														
														<?php }
												}else{ ?>
												
												<!---time expired--- no_cancel- experience started -->
												
												<?php /*	<br><a data-toggle="modal" href="#cancel_booking_<?php echo $row->product_id; ?>" onclick="return add_data(this)" user_id="<?php echo $row->renter_id;?>" product_id="<?php echo $row->product_id;?>" reviewer_id="<?php if($userDetails!='no') { echo $userDetails->row()->id; }?>" booking_no="<?php if($userDetails!='no') { echo $row->bookingno; }?>" ><?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel";?></a>
												*/ ?>
												
												<?php } ?>
																			
										<?php }  ?>
										
										<?php }else { ?>
										
										<?php if($dis_details->row()->cancel_status == 1) { ?>
										<br><a data-toggle="modal" href="#disputed_<?php echo $row->product_id; ?>" onclick="return add_data(this)" user_id="<?php echo $row->renter_id;?>" product_id="<?php echo $row->product_id;?>" reviewer_id="<?php if($userDetails!='no') { echo $userDetails->row()->id; }?>" booking_no="<?php if($userDetails!='no') { echo $row->bookingno; }?>" ><?php if($this->lang->line('Canceled') != '') { echo stripslashes($this->lang->line('Canceled')); } else echo "Canceled";?></a>
										<?php } elseif($dis_details->row()->cancel_status == 0){?>
										
										<?php /*
										<br><a data-toggle="modal" href="#disputed_<?php echo $row->product_id; ?>" onclick="return add_data(this)" user_id="<?php echo $row->renter_id;?>" product_id="<?php echo $row->product_id;?>" reviewer_id="<?php if($userDetails!='no') { echo $userDetails->row()->id; }?>" booking_no="<?php if($userDetails!='no') { echo $row->bookingno; }?>" ><?php if($this->lang->line('Disputed') != '') { echo stripslashes($this->lang->line('Disputed')); } else echo "Disputed";?></a>
										
										*/ ?>
										
										<?php } }?>
										
										<br>
										<a data-toggle="modal" href="#inbox" onclick="return post_discussion(this)" renter_id="<?php echo $row->renter_id;?>" product_id="<?php echo $row->product_id;?>" booking_no="<?php echo $row->bookingno;?>" reviewer_id="<?php if($userDetails!='no') { echo $userDetails->row()->id; }?>"><?php if($this->lang->line('Message') != '') { echo stripslashes($this->lang->line('Message')); } else echo "Message";?></a>
										 <?php } ?>
										</td>
										
										
										
										<td> <?php if($row->dateAdded < $today) { echo "-"; } else {
										echo ($row->approval=="Decline")?"Declined":"";
										$paymentstatus = $this->experience_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT,array('Enquiryid'=>$row->cid));
										$chkval = $paymentstatus->num_rows();
										$chkval1 = $paymentstatus->row()->status;
										if($row->approval=='Accept' && ($chkval == 0 || $chkval1 == 'Pending')) {

										//echo "Approved"; 
										if($this->lang->line('Approved') != '') { echo stripslashes($this->lang->line('Approved')); } else echo "Approved";
										
										
										
										} elseif($row->approval!="Decline" && $chkval==0) { if($this->lang->line('Pending Confirmation') != '') { echo stripslashes($this->lang->line('Pending Confirmation')); } else echo "Pending Confirmation"; }
										else if($row->approval!="Decline") if($this->lang->line('Approved') != '') { echo stripslashes($this->lang->line('Approved')); } else
											{
												
										
											//echo "Approved";
											
											if($this->lang->line('Approved') != '') { echo stripslashes($this->lang->line('Approved')); } else echo "Approved";
											}  }?> </td>
										<td><?php if($pr_details->row()->host_status== 1){ if($this->lang->line('host is not available') != '') { echo stripslashes($this->lang->line('host is not available')); } else echo "host is not available";} elseif($pr_details->row()->host_status== 0) { if($this->lang->line('host is available') != '') { echo stripslashes($this->lang->line('host is available')); } else echo "host is available";}?></td>
									</tr>
								</tbody>
								
<div id="add_dispute_<?php echo $row->product_id; ?>" class="modal in trip-popup" style="overflow: hidden; display: none;" aria-hidden="false">



<div class="modal-header" style="background: none repeat scroll 0% 0% rgb(239, 239, 239);"><div ><b><?php if($this->lang->line('Add Dispute') != '') { echo stripslashes($this->lang->line('Add Dispute')); } else echo "Add Dispute";?></b><a style="float:right; padding-right: 30px;cursor: pointer;"; data-dismiss="modal"><span class="">X</span></a></div></div>
<?php if($loginCheck !=''){ echo form_open('site/experience/add_dispute',array('id'=>'reviewForm'));?>
<input type="hidden" name="prd_id" value="<?php echo $row->product_id; ?>" />
<input type="hidden" name="bookingNo" value="<?php echo $row->bookingno; ?>" />
  <input type="hidden" name="disputer_id" value="<?php echo $row->renter_id; ?>" />
  <input type="hidden" name="email" value="<?php if($userDetails!='no') { echo $userDetails->row()->email; }?>" />
<div class="pops-lefd">
<img class="poop-imgs" src="<?php if(strpos($row->product_image, 's3.amazonaws.com') > 1)echo $row->product_image;else echo base_url()."server/php/experience/".$row->product_image; ?>" style="" alt="<?php echo $row->product_title; ?>"/>
</div>


<input type="hidden" name="trip_url" value="<?php echo $this->uri->segment(2); ?>" />
<div class="pops-lefd2">

<span class="tp-text-1"><?php echo $row->product_title; ?></span>
<span class="tp-text-2"><?php echo $row->prd_address; ?></span>

</div>

<textarea  name="message" id="review-text" class="scroll_newdes" maxlength="300" style="height:90px; " required></textarea>

<div id="review_warn"  style="float:left; color:#FF0000;"></div>
<div class="clear"></div>
<div class="field_login">
<input type="submit" id="Review"  value="Submit Dispute">
</div>
<?php echo form_close(); } ?>
</div>

<!-- cancel booking popup -->

<div id="cancel_booking_<?php echo $row->product_id; ?>" class="modal in cancle-popup" style="display: none; " aria-hidden="false">



<div class="modal-header " style="background: none repeat scroll 0% 0% rgb(239, 239, 239);"><div ><b><?php if($this->lang->line('Cancel Booking') != '') { echo stripslashes($this->lang->line('Cancel Booking')); } else echo "Cancel Booking";?></b><a class="trip-popup-close" data-dismiss="modal"><span class="">X</span></a></div></div>
<div class="cancle-trip-popup">
<?php if($loginCheck !=''){ echo form_open('site/experience/cancel_booking',array('id'=>'reviewForm'));?>
<input type="hidden" name="prd_id" value="<?php echo $row->product_id; ?>" />
<input type="hidden" name="bookingNo" value="<?php echo $row->bookingno; ?>" />
  <input type="hidden" name="disputer_id" value="<?php echo $row->renter_id; ?>" />
  <input type="hidden" name="email" value="<?php if($userDetails!='no') { echo $userDetails->row()->email; }?>" />
<div class="cancle-popup-bottom">



<input type="hidden" name="trip_url" value="<?php echo $this->uri->segment(2); ?>" />

<div class="pops-lefd">
<img class="poop-imgs" src="<?php if(strpos($row->product_image, 's3.amazonaws.com') > 1)echo $row->product_image;else echo base_url()."server/php/experience/".$row->product_image; ?>" style="" alt="<?php echo $row->product_title; ?>"/>
</div>
<div class="pops-lefd2">
<?php //print_r($row); ?>

<span class="tp-text-1"><?php echo $row->product_title; ?></span>
<span class="tp-text-2"><?php echo $row->prd_address; ?></span>
<span class="tp-text-2">Booking number:<b><?php echo $row->bookingno; ?></b></span>

</div>
</div>


<textarea  name="message" id="review-text" class="scroll_newdes" maxlength="300" style="height:90px; " required></textarea>

<div id="review_warn"  style="float:left; color:#FF0000;"></div>
<div class="clear"></div>
<div class="field_login canceltrip-btn">
<input type="submit" id="Review"  value="cancel booking">
</div></div>
<?php echo form_close(); } ?>
</div>
<!--End cancel booking popup-->

<div id="disputed_<?php echo $row->product_id; ?>" class="modal in trip-popup" style="overflow: hidden; display: none;" aria-hidden="false">
<div class="modal-header" style="background: none repeat scroll 0% 0% rgb(239, 239, 239);"><div ><b><?php if($this->lang->line('Disputed') != '') { echo stripslashes($this->lang->line('Disputed')); } else echo "Disputed";?></b><a style="float:right; padding-right: 30px;cursor: pointer;"; data-dismiss="modal"><span class="">X</span></a></div></div>
<?php if($loginCheck !=''){ echo form_open('site/experience/add_dispute',array('id'=>'reviewForm'));?>
<div class="pops-lefd">
<img class="poop-imgs" src="<?php if(strpos($row->product_image, 's3.amazonaws.com') > 1)echo $row->product_image;else echo base_url()."server/php/experience/".$row->product_image; ?>" style="" alt="<?php echo $row->product_title; ?>"/>
</div>
<input type="hidden" name="prd_id" value="<?php echo $row->product_id; ?>" />
<input type="hidden" name="bookingNo" value="<?php echo $row->bookingno; ?>" />
<input type="hidden" name="trip_url" value="<?php echo $this->uri->segment(2); ?>" />
<div class="pops-lefd2">

<span class="tp-text-1"><?php echo $row->product_title; ?></span>
<span class="tp-text-2"><?php echo $row->prd_address; ?></span>
<br/>
<br/>
<span class="tp-text-2" style="margin-top:20px;"><?php if(!empty($dis_details))  echo $dis_details->row()->message; ?></span>

<span class="tp-text-2"><?php if(!empty($dis_details))  echo date('F Y',strtotime($dis_details->row()->created_date)); ?></span>

</div>


<div id="review_warn"  style="float:left; color:#FF0000;"></div>
<div class="clear"></div>
<div class="field_login">

</div>
<?php echo form_close(); } ?>


</div>
								<?php   } ?>
								</table>
								<?php } else { ?> <p><?php if($this->lang->line('Youhaveno') != '') { echo stripslashes($this->lang->line('Youhaveno')); } else echo "You have no current trips.";?> <br><br></p><?php } ?>


								<div class="notification_action">
									<input id="id" type="hidden" name="id" value="contact@vacason.com">
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div id="footer_pagination"><?php echo $paginationLink; ?></div>
					</div>
				</div>
			</div>
		</div>       
	</div></div>
</div>

<div id="add_review" class="modal in trip-popup " style="overflow: hidden; display: none;" aria-hidden="false">
<div class="modal-header" style="background: none repeat scroll 0% 0% rgb(239, 239, 239); "><div ><b><?php if($this->lang->line('Add Review') != '') { echo stripslashes($this->lang->line('Add Review')); } else echo "Add Review";?></b><a class="trip-popup-close" data-dismiss="modal"><span class="">X</span></a></div></div>
<?php if($loginCheck !=''){ echo form_open('site/experience/add_review',array('id'=>'reviewFormSubmit'));?>
<input type="hidden" id="proid" name="proid" value="" />
<input type="hidden" id="user_id" name="user_id" value="" />
<input type="hidden" id="booking_no" name="bookingno" value="" />


<div class="pops-lefd">
<img class="poop-imgs" id="pro_img" src="" style="" alt=""/>
</div>
<div class="pops-lefd2">
<?php //print_r($row); ?>

<span class="tp-text-1" id="pro_title"></span>
<span class="tp-text-2">Booking number:<b id="booking_no_show"></b></span>

</div>

<label><?php if($this->lang->line('My review') != '') { echo stripslashes($this->lang->line('My review')); } else echo "My review";?><span>*</span>
<span style="font-size:10px; color:#666;"> (<?php if($this->lang->line('Exclude personally identifiable information such as name, email address, etc') != '') { echo stripslashes($this->lang->line('Exclude personally identifiable information such as name, email address, etc')); } else echo "Exclude personally identifiable information such as name, email address, etc";?>)</span></label>
<textarea  name="review" id="review-text-value" class="scroll_newdes" maxlength="300" style="height:90px;"></textarea>
<div id="review_warn"  style="float:left; color:#FF0000;"></div>
<div class="clear"></div>
<input type="hidden" name="rating" id="r1"/>
<input type="hidden" name="total_review" id="r7" value="1"/>
<div class="star_rating starares">
<li><label><?php if($this->lang->line('Rating') != '') { echo stripslashes($this->lang->line('Rating')); } else echo "Rating";?></label>
<div class="rtng">
    <span id="rating_1" data-id="r1" class="rating" ></span>
    <span id="result_1"></span> 
</div>
<!--<div class="exemple5" data-id="r1" id="r11" data="10_5"  style="width:60%;"></div>-->

<div class="field_login">
  <input type="hidden" name="reviewer_id" value="<?php if($userDetails!='no') { echo $userDetails->row()->id; }?>" />
  <input type="hidden" name="reviewer_email" value="<?php if($userDetails!='no') { echo $userDetails->row()->email; }?>" />
  <input type="button" name="Review" id="Review"  onClick="add_review()" value="Submit my review">
</div>

</li>
</div>

<?php echo form_close();}?>
</div>



<div id="display_review" class="modal in trip-popup" style="overflow: hidden; display: none; " aria-hidden="false">
<div class="modal-header" style="background: none repeat scroll 0% 0% rgb(239, 239, 239);"><div ><b><?php if($this->lang->line('Your Review') != '') { echo stripslashes($this->lang->line('Your Review')); } else echo "Your Review";?></b><a class="trip-popup-close" data-dismiss="modal"><span class="">X</span></a></div></div>
<ul class="list-paging">
<?php 
$reviewData = $this->data['reviewData_all'];

//print_r($reviewData->result_array());
if($reviewData !=''){foreach($reviewData->result_array() as $review ):


?>



<li class="<?php echo $review['bookingno'];?> mainli" style="display:none";>

<div class="peps">
<figure class="peps-area">
<img src="<?php if($review['image'] == '')echo base_url().'images/site/profile.png'; else echo 'images/users/'.$review['image']; ?>">
</figure>
<?php /*
	<br/>(<?php if($this->lang->line('Your Review') != '') { echo stripslashes($this->lang->line('Your Review')); } else echo "Your Review";?>)
*/ ?>

</div>

<span class="johns"><b><div><?php echo $review['firstname'];?></div><small>(<?php echo $review['email'];?>)</small></b></span>

<p class="reviewTxt">
			<?php echo $review['review'];?>
			</p>

	<div class="viewrevw-right">

		<div class="listd-right">

			
			
			<i class="date-year"> - <?php echo date('d F Y',strtotime($review['dateAdded']));?></i>
		</div>

		<h4><?php echo "Booking Number : <b>".$review['bookingno']."</b>";?></h4>

		<div class="listd-right">
		<ul class="right-review">
		<li><span style="padding-right:10px;"><?php if($this->lang->line('Your Rating') != '') { echo stripslashes($this->lang->line('Your Rating')); } else echo "Your Rating";?>  </span><span class="review_img" ><img class="review_st" style="padding:10px 0; width:<?php  echo $review['total_review'] * 12.5?>%"></span></li>


		</ul>
		
		</div>
	</div>

</li>
<?php endforeach;}?>
</ul>

</div>

</div>
<!---DASHBOARD-->
<!---FOOTER-->
<script src="js/site/jquery.RatingStars.js"></script>
<script>
$(document).ready(function(){
    $('.exemple5').jRating({
        length:4.6,
        decimalLength:1,
        onSuccess : function(){
            alert('Success : <?php if($this->lang->line('your_rate_has_been_saved') != '') { echo stripslashes($this->lang->line('your_rate_has_been_saved')); } else echo "your rate has been saved";?>');
            //$("#rating_value_Err").hide();
        },
        onError : function(){
            alert('Error : <?php if($this->lang->line('please retry') != '') { echo stripslashes($this->lang->line('please retry')); } else echo "please retry";?>');
        }
    });
});


/* Creacion de Rating Stars */
 $('#rating_1').RatingStar({callback:function(val){$('#result_1').html(" &nbsp;"+val+" RatingStar."); $('#r7').val(val)}});
 /* Creacion de Rating Stars */

function add_review()
{
if($('textarea#review-text-value').val() == '')
{

		$('#review-text').focus();
		return false;
}
//r1 = $('#r1').val();
//$('#r7').val(r1);
$('#reviewFormSubmit').submit();
}


function cancel_request(evt)
{
	alert($(evt).attr('booking_no'));
}
function post_discussion(evt)
{
$('#rental_id').val($(evt).attr('product_id'));
$('#sender_id').val($(evt).attr('reviewer_id'));
$('#receiver_id').val($(evt).attr('renter_id'));
$('#booking_id').val($(evt).attr('booking_no'));
}

$(function()
{
$('#discussion').click(function()
{
if($('#message').val()=='')
{
// $('#message_warn').html('Please Enter Message');
}
else{
$('#add_discussion').submit();
}
});
});


function add_data(evt){
	
	var product_id = $(evt).attr('product_id');
	var reviewer_id = $(evt).attr('reviewer_id');
	var booking_no = $(evt).attr('booking_no');
	var user_id = $(evt).attr('user_id');
	
	var pro_title = $(evt).attr('pro_title');
	var img_src = $(evt).attr('img_src');

	
	$('#add_review #user_id').val(user_id);
	$('#add_review #proid').val(product_id);
	$('#add_review #booking_no').val(booking_no);
	$('#add_review #booking_no_show').html(booking_no);
	$('#add_review #pro_title').html(pro_title);
	$('#add_review #pro_img').attr("src", img_src);
}


function booking_review(evt){
	var booking_no = $(evt).attr('booking_no');
	var user_id = $(evt).attr('user_id');
	//alert(booking_no);
	//alert(user_id);
	$('#display_review ul li.mainli').hide();
	$('#display_review ul li.'+booking_no).show();
}


</script>

<!-- to toggle the timings-->
<script>
	$(document).on("click",".toggleSchedule",function(){
		$(this).next(".scheduleDetails").slideToggle();
	});
</script>

<!--pop up for inbox message-->
<div id="inbox" class="modal in msg-popup" style="overflow: hidden; display: none;" aria-hidden="false">
<div class="modal-header" style="background: none repeat scroll 0% 0% rgb(239, 239, 239);"><div ><b><?php if($this->lang->line('Message to Host') != '') { echo stripslashes($this->lang->line('Message to Host')); } else echo "Message to Host";?> </b><a class="trip-popup-close" data-dismiss="modal"><span class="">X</span></a></div></div>
<?php if($loginCheck !=''){ echo form_open('site/experience/add_discussion',array('id'=>'add_discussion'));?>
<input type="hidden" id="rental_id" name="rental_id" value="" />
<input type="hidden" id="sender_id" name="sender_id" value="" />
<input type="hidden" id="receiver_id" name="receiver_id" value="" />
<input type="hidden" id="booking_id" name="bookingno" value="" />
<input type="hidden" id="posted_by" name="posted_by" value="customer" />
<input type="hidden" id="redirect" name="redirect" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>" />

<textarea  name="message" required id="message" class="" ></textarea>
<div id="message_warn"  style="float:left; color:#FF0000;"></div>
<div class="clear"></div>
<div class="field_login canceltrip-btn">
<input type="submit" name="discussion" id="discussion"  value="<?php if($this->lang->line('Send') != '') { echo stripslashes($this->lang->line('Send')); } else echo "Send";?>">
</div>
<?php echo form_close();}?>
</div>
<!-- end popup for inbox message -->
<?php 
$this->load->view('site/templates/footer');
?>