				<?php $url2 = $this->uri->segment(1);?>
				
				<ul id="nav">
                <li class="<?php  if(current_url()== base_url().'dashboard') echo "active"; ?>"><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
                <li class="<?php  if((current_url()== base_url().'inbox') || ($url2=='new_conversation')) echo "active"; ?> " ><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li class="<?php if((current_url()==base_url().'listing/all') || (current_url()==base_url().'listing-reservation')) echo "active"; ?>"><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>

                  <?php /* Experience Listing */
                    if($experienceExistCount>0){
                    ?>
                     <li class="<?php  if((current_url()== base_url().'experience/all') || (current_url()== base_url().'experience-transactions') || (current_url()== base_url().'my_experience/upcoming') || (current_url()== base_url().'my_experience/previous') || (current_url()== base_url().'experience-reservation')  || (current_url()== base_url().'experience-passed-reservation') || (current_url()== base_url().'experience-review') || (current_url()== base_url().'experience-review1') || (current_url()== base_url().'experience-dispute') || (current_url()== base_url().'experience-dispute1') || (current_url()== base_url().'experience-cancel_booking_dispute') || (current_url()== base_url().'experience_inbox')) echo "active"; ?>"><a href="<?php echo base_url();?>experience/all"><?php if($this->lang->line('YourExperiences') != '') { echo stripslashes($this->lang->line('YourExperiences')); } else echo "Your Experiences";?></a></li>

                  <?php } /* Experience Listing ends */?>  
                <li class="<?php  if(current_url()== base_url().'trips/upcoming' || current_url()== base_url().'previous') echo "active"; ?>" ><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></li>
				
                <li class="<?php  if(current_url()== base_url().'settings' || current_url()== base_url().'photo-video' || current_url()== base_url().'verification' || current_url()==base_url().'display-review' || current_url()==base_url().'display-dispute' || current_url()== base_url().'site/product/display_dispute1' || current_url()== base_url().'site/product/cancel_booking_dispute' || current_url()== base_url().'site/product/display_dispute' || current_url()== base_url().'site/product/display_review1' || current_url()== base_url().'site/product/display_review' || current_url()== base_url().'site/product/display_dispute2' ) echo "active"; ?>" ><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
				
				
                <li class="<?php  if((current_url()== base_url().'account-payout') || (current_url()== base_url().'account-trans') || ($url2=='account-security') || ($url2=='account-setting') || ($url2=='your-wallet')){ echo "active";} ?>" ><a href="<?php echo base_url();?>account-payout"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
				        
						<li class="<?php  if(current_url()== base_url().'invite') echo "active"; ?>"><a href="<?php echo base_url();?>invite"><?php if($this->lang->line('Invite') != '') { echo stripslashes($this->lang->line('Invite')); } else echo "Invite";?></a></li>
						
                <li class="<?php  if(current_url()== base_url().'plan') echo "active"; ?>"><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul>