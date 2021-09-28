<?php 
$this->load->view('site/templates/header');
?>

<!---DASHBOARD-->
<div class="dashboard yourlisting resrev bgcolor dasblistgresvnwthm">

<div class="top-listing-head">
 <div class="main">   
            <?php 
             $this->load->view('site/user/main_nav_header');  
            ?>
			</div></div>
    <div class="dash_brd">
        <div class="dashboard-sidemenu" id="command_center">
       
        <div class="dashboard-sidemenu">
            <ul class="subnav">
                <li ><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('ManageListings') != '') { echo stripslashes($this->lang->line('ManageListings')); } else echo "Manage Listings";?></a></li>
                <li class="active"><a href="<?php echo base_url();?>listing-reservation"><?php if($this->lang->line('YourReservations') != '') { echo stripslashes($this->lang->line('YourReservations')); } else echo "Your Reservations";?>  </a></li>
                <!--<li><a href="<?php echo base_url();?>listing-requirement"><?php if($this->lang->line('ReservationRequirements') != '') { echo stripslashes($this->lang->line('ReservationRequirements')); } else echo "Reservation Requirements";?></a></li>-->
                <!--<li><a href="<?php echo base_url();?>listing-booking">Booking</a></li>
                <li><a href="<?php echo base_url();?>listing_enquiry">Enquiry</a></li>-->
                
            </ul>

            </div>


            <div class="dashboard-rightmenu">
            <div class="box" id="my_listings">
                <div class="middle">
                <?php if($bookedRental->num_rows() >0)
                                { ?>
                       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
                            <thead>
                             <tr height="40px">
                             
                             <td style="width:100px"><strong><?php if($this->lang->line('UserName') != '') { echo stripslashes($this->lang->line('UserName')); } else echo "User Name";?></strong></td>
                             <td style="width:150px"><strong><?php if($this->lang->line('DatesandLocation') != '') { echo stripslashes($this->lang->line('DatesandLocation')); } else echo "Dates and Location";?></strong></td>
                             <td style="width:100px"><strong><?php if($this->lang->line('Amount') != '') { echo stripslashes($this->lang->line('Amount')); } else echo "Amount";?></strong></td>
                             <td style="width:100px"><strong><?php if($this->lang->line('PaymentStatus') != '') { echo stripslashes($this->lang->line('PaymentStatus')); } else echo "Payment Status";?></strong></td>
							  <td style="width:100px"><strong><?php if($this->lang->line('Approval') != '') { echo stripslashes($this->lang->line('Approval')); } else echo "Approval";?></strong></td>
                             <!--<td width="15%" style="background:#f5f5f5;" ><strong>Action</strong></td>-->
                             </tr>
                            </thead>
                         
                                   <?php 
                                 // echo '<pre>';print_r($bookedRental->result());die;
                                   
                                   
                                   
                                   
                                   foreach($bookedRental->result() as $row)
                                            { ?>
                                    
                                        <tr>
                                        <td><img src="<?php if($row->loginUserType == 'google'){ echo $row->image;} elseif($row->image == '' ){ echo base_url();?>images/site/profile.png<?php } else { echo base_url().'images/users/'.$row->image;}?>" width="100" height="100" alt="image"/> &nbsp;&nbsp;<br /><a target="_blank" href="users/show/<?php echo $row->GestId; ?>" style="float:left;  "><?php echo $row->firstname;?></a></td>
                                        <td class="nw-lite"> <?php if($row->checkin!='0000-00-00 00:00:00' && $row->checkout!='0000-00-00 00:00:00'){ echo "<br>".date('M d',strtotime($row->checkin))." - ".date('M d, Y',strtotime($row->checkout))."<br>";
                                                   echo "<a href='".base_url()."rental/".$row->product_id."'>".$row->product_title."</a><br>";
                                                   echo $row->address."<br>";
                                                  // echo $row->city_name.",".$row->state_name." "."<br>";
                                                  // echo $row->country_name.'- '.$row->post_code."<br>";
												    if($this->lang->line('booking_no') != '') { echo stripslashes($this->lang->line('booking_no')); } else echo "Booking No";  echo  " : " . $row->Bookingno;   }
                                                   ?>
                                        </td>                                        
                                        <td>
										<?php  echo $currencySymbol; ?>
										<?php
										if($row->is_coupon_used == 'Yes'){
					
					  echo '<li style="color: green;">Coupon: '. $row->coupon_code  .'</li>';
					  echo '<li style="text-decoration: ;">'.strtoupper($currencySymbol)." ".number_format($row->discount*$this->session->userdata('currency_r'),2).'</li>';
					  echo '<li style="text-decoration: line-through;">'.strtoupper($currencySymbol)." ".number_format($row->total_amt*$this->session->userdata('currency_r'),2).'</li>';
					
					}else {
                        foreach($result as $product){}
						
						$currencyPerUnitSeller=$row->currencyPerUnitSeller;
						
                                            //echo $row->subTotal;
                                            $totalAmount = ($row->subTotal + $row->serviceFee + $row->secDeposit);
                                            if($row->currency != $this->session->userdata('currency_type')){

										if($row->currency==$this->session->userdata('currency_type')){
											if(!empty($currencyPerUnitSeller))
											echo customised_currency_conversion($currencyPerUnitSeller,$totalAmount);										
										}else{
											 echo convertCurrency($row->currency,$this->session->userdata('currency_type'),$totalAmount);
										}

                                            }else{
                                                 echo $totalAmount;
											}
						//echo strtoupper($currencySymbol)." ".convertCurrency(USD,$this->session->userdata('currency_type'),$row->totalAmt);

                        
					}
										?>
                                        <?php echo $this->session->userdata('currency_type');?>
										 </td>
                                        <td>
										<?php 
$paymentstatus = $this->cms_model->get_all_details(PAYMENT,array('Enquiryid'=>$row->EnqId));
 $chkval = $paymentstatus->num_rows();

										if($chkval==1) { 
										?>
										 <p><a href="javascript:void(0);" title="Edit Enquiry">
<?php // echo "Paid"  

if($this->lang->line('paid') != '') { echo stripslashes($this->lang->line('paid')); } 
else echo "Paid";
//$row->booking_status;


 ?></a></p>
										 <p><a href="site/user/invoice/<?php echo $row->Bookingno;?>" target="_blank"><?php if($this->lang->line('Confirmation') != '') { echo stripslashes($this->lang->line('Confirmation')); } else echo "Confirmation";?></a></p>
                                        
                                        <?php } else { 
										
										
										//echo "Pending"; 
										if($this->lang->line('Pending') != '') { echo stripslashes($this->lang->line('Pending')); } else echo "Pending";
										
										
										
										} ?> 
                                        
                                        </td>
<td>
<?php   if($row->approval=='Pending') { 

//echo 'Approval Pending';

if($this->lang->line('approval_pending') != '') { echo stripslashes($this->lang->line('approval_pending')); } else echo "Approval Pending";



 } else { 
 
 
			if($this->lang->line('Accepted') != '') 
				{ 
					$accepted = stripslashes($this->lang->line('Accepted')); 
				} 
			else 
				{
					$accepted = "Accepted";
				}
				
				
			if($this->lang->line('Declined') != '') 
				{ 
					$declined = stripslashes($this->lang->line('Declined')); 
				} 
			else 
				{
					$declined = "Declined";
				}
 
 
 
 ?>
<?php echo ($row->approval == 'Accept')? "$accepted":"$declined"; ?>
<?php } ?>
</td>

                                        </tr>
                                            <?php   } ?>
                                        </table>
                                       <?php } 
                                    else
                                        { ?>
                            
                            <p class="no_listings">
                                <?php 

								if($this->lang->line('no_upcoming_reservations') != '') { echo stripslashes($this->lang->line('no_upcoming_reservations')); } else echo "You have no upcoming reservations.";
								
								
								
								?><br>
                                <?php if($this->uri->segment(2)=="") {?>
                                <a href="<?php echo base_url()."listing-passed-reservation"; ?>"><?php if($this->lang->line('ViewPastReserv') != '') { echo stripslashes($this->lang->line('ViewPastReserv')); } else echo "View Past Reservation History.";?></a>
                                <?php } else {?>
                                <a href="<?php echo base_url()."list_space"; ?>"><?php if($this->lang->line('Createanewisting') != '') { echo stripslashes($this->lang->line('Createanewisting')); } else echo "Create a new listing.";?></a>
                                <?php }?>
                                
                             </p>
                            <?php 
                            }
                            ?>
                   
                </div>
                <div id="footer_pagination"><?php echo $paginationLink; ?></div>
           </div>     
    </div>
           
  </div>
    </div>
</div>
<!---DASHBOARD-->
<!---FOOTER-->
<?php 

$this->load->view('site/templates/footer');
?>