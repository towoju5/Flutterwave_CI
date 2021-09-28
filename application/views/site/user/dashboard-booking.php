<?php 
$this->load->view('site/templates/header');
?>
<!---DASHBOARD-->
<div class="dashboard">
	<div class="main">
    	<div id="command_center">
    
            <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li class="active"><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('Your_Listing') != '') { echo stripslashes($this->lang->line('Your_Listing')); } else echo "Your Listing";?></a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('Your_Trips') != '') { echo stripslashes($this->lang->line('Your_Trips')); } else echo "Your Trips";?></a></li>
                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
                
            </ul>    
            <ul class="subnav">
                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('ManageListings') != '') { echo stripslashes($this->lang->line('ManageListings')); } else echo "Manage Listings";?></a></li>
                <li><a href="<?php echo base_url();?>listing-reservation"><?php if($this->lang->line('Your_Reservations') != '') { echo stripslashes($this->lang->line('Your_Reservations')); } else echo "Your Reservations";?></a></li>
                <li><a href="<?php echo base_url();?>listing-requirement"><?php if($this->lang->line('ReservationRequirements') != '') { echo stripslashes($this->lang->line('ReservationRequirements')); } else echo "Reservation Requirements";?></a></li>
                <!--<li  class="active"><a href="<?php echo base_url();?>listing-booking">Booking</a></li>
                <li><a href="<?php echo base_url();?>listing_enquiry">Enquiry</a></li>-->
                
            </ul>
            
            <div class="box" id="my_listings">
                <div class="middle">
                <?php if($bookedRental->num_rows() >0)
				   			    { ?>
                       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">
                     		<thead>
 							 <tr height="40px"><!--<td width="15%" style="background:#f5f5f5;" ><strong>Status</strong></td>-->
   							 <td width="20%" style="background:#f5f5f5;"><strong><?php if($this->lang->line('DatesandLocation') != '') { echo stripslashes($this->lang->line('DatesandLocation')); } else echo "Dates and Location";?></strong></td>
   							 <td width="45%" style="background:#f5f5f5;" ><strong><?php if($this->lang->line('Guest') != '') { echo stripslashes($this->lang->line('Guest')); } else echo "Guest";?></strong></td>
   							 <td width="20%" style="background:#f5f5f5;"><strong><?php if($this->lang->line('Details') != '') { echo stripslashes($this->lang->line('Details')); } else echo "Details";?></strong></td>
   							 </tr>
							</thead>
                         
                 				   <?php 
								  // echo '<pre>';print_r($bookedRental->result());die;
								   
								   
								   /*echo $datebyPropid->row()->the_date;
								   echo count($datebyPropid);*/
								   
								   foreach($bookedRental->result() as $row)
									    	{ ?>
                                    
                                        <tbody>
                                       <!-- <td><p style=" color: #000; font-weight: bold;  margin-right: 80px;">Status</p></td>-->
                                        <!--echo "<br>".date('M d',strtotime($row->datefrom))." - ".date('d, Y',strtotime($row->dateto))."<br>";-->
                                        <td> <?php echo "<br><label style='color:red;'>".date('M d Y',strtotime($row->the_date))."</label><br>";
												   echo "<a href='".base_url()."rental/".$row->product_id."'>".$row->product_title."</a><br>";
												   echo $row->address."<br>";
												   echo $row->city_name.",".$row->state_name." ".$row->post_code."<br>";
												   echo $row->country_name;
												   ?>
										</td>
                                        <td><img src="<?php echo base_url(); ?>images/users/<?php if($row->image == '') echo "owner_img.png"; else echo $row->image;?>" width="100" height="100" alt="image"/> &nbsp;&nbsp;<a href="javascript:void(0);" style="float:right; margin-right:247px;"><?php echo $row->firstname;?></a></td>
                                        <td><?php echo strtoupper($currencySymbol)." ".round(CurrencyValue($row->product_id ,$row->price ),2)." total";?> </td>
                                        </tbody>
                                        	<?php	} ?>
                                        </table>
                                       <?php } 
									else
										{ ?>
                            
							<p class="no_listings">
                 				<?php if($this->lang->line('Youhavenoreservations') != '') { echo stripslashes($this->lang->line('Youhavenoreservations')); } else echo "You have no reservations";?>.<br>
                       			<a href="<?php echo base_url()."list_space"; ?>"><?php if($this->lang->line('Createanewisting') != '') { echo stripslashes($this->lang->line('Createanewisting')); } else echo "Create a new listing";?></a>.
                  			 </p>
							<?php 
							}
							?>
                        <div class="show_all_reservations">
                           <!-- <a href="#=1">View past reservation history</a>-->
                        </div>
                </div>
    </div>
           
  </div>
    </div>
</div>
<!---DASHBOARD-->
<!---FOOTER-->
<?php 
$this->load->view('site/templates/content_above_footer');
$this->load->view('site/templates/footer');
?>