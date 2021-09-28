<?php 

$this->load->view('site/templates/header');	

?>    



<!---DASHBOARD-->

<div class="dashboard yourlisting dash-home bgcolor dasbprofnwthm">



<div class="top-listing-head">



 <div class="main">  

 

            <?php 

             $this->load->view('site/user/main_nav_header');  

            ?>

			

			</div>

			

			

			

			</div>

  <div class="dash_brd">

  

      <div id="command_center">

    

            <ul id="nav">

                <li class="active"><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>

                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>

                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>

               <?php /*?><li><a href="<?php echo base_url();?>rental/<?php echo $userDetails->row()->id;?>">Your Listing</a></li><?php */?>

                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></li>

                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>

                <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>

				<li><a href="<?php echo base_url();?>invite"><?php if($this->lang->line('Invite') != '') { echo stripslashes($this->lang->line('Invite')); } else echo "Invite";?></a></li>

                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>

            </ul>

<div class="clearfix" id="dashboard">

              <div id="left">





                <div class="box" id="user_box">

                  <div class="middle">

                    <div id="user_pic">

                      <div class="_pm_container">

        

       

              

                        <a class="prof-cont-img" href="users/show/<?php echo $userDetails->row()->id; ?>"><img src="<?php if($userDetails->row()->image!='') { echo base_url();?>images/users/<?php echo $userDetails->row()->image; } else echo "images/ProfilE11.png";?>" width="" height=""   >

						

		

						

						</a>

						

                      <a href="photo-video" class="upload-photo"><span class="mob-uplo-pic"><i></i><span><?php if($this->lang->line('uploadprofilephoto') != '') { echo stripslashes($this->lang->line('uploadprofilephoto')); } else echo "upload profile photo";?></span></span></a>

        

        </div>            </div>

                    <h2>

                      <label style="cursor:text"><?php echo ucfirst($userDetails->row()->firstname);?></label>

                       <!--<a href="users/show/<?php echo $userDetails->row()->id; ?>"><?php echo ucfirst($userDetails->row()->firstname);?></a>-->

                    </h2>

                    <p>

                      <a href="users/show/<?php echo $userDetails->row()->id;?>"><?php if($this->lang->line('ViewProfile') != '') { echo stripslashes($this->lang->line('ViewProfile')); } else echo "View Profile";?></a>

                    </p>



                    <div class="bulid-prof"><a href="settings"><?php if($this->lang->line('buildyourprofile') != '') { echo stripslashes($this->lang->line('buildyourprofile')); } else echo "build your profile";?></a></div>

                  </div>

                </div>

        

              

        

                <div class="box" id="quick_links">

                  <div class="middle">

				  

                    <h3 class="box-header"><?php if($this->lang->line('QuickLinks') != '') { echo stripslashes($this->lang->line('QuickLinks')); } else echo "Quick Links";?></h3>

					<?php if($userDetails->row()->group == 'User'){ ?>

					<ul class="unstyled">

                        <li><a href="<?php echo base_url()."listing/all";?>"><?php if($this->lang->line('View_ManageListing') != '') { echo stripslashes($this->lang->line('View_ManageListing')); } else echo "View/Manage Listing";?></a></li>

						<li><a href="trips/upcoming"><?php if($this->lang->line('My Trips') != '') { echo stripslashes($this->lang->line('My Trips')); } else echo "My Trips";?></a></li>

						<li><a href="users/show/<?php echo $userDetails->row()->id;?>"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></a></li>

					</ul>	

					<?php }else {?>

                    <ul class="unstyled">

                        <li><a href="<?php echo base_url()."listing/all";?>"><?php if($this->lang->line('View_ManageListing') != '') { echo stripslashes($this->lang->line('View_ManageListing')); } else echo "View/Manage Listing";?></a></li>

                        <li><a href="<?php echo base_url()."listing-reservation";?>"><?php if($this->lang->line('Reservations') != '') { echo stripslashes($this->lang->line('Reservations')); } else echo "Reservations";?></a></li>

                        <li><a href="users/show/<?php echo $userDetails->row()->id;?>"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></a></li>

                    </ul>

					<?php } ?>

                  </div>

                </div>

        

                  <div class="box" id="snapshot">

                    <div class="middle">

                      <h3 class="box-header"><?php if($this->lang->line('Snapshot') != '') { echo stripslashes($this->lang->line('Snapshot')); } else echo "Snapshot";?></h3>

                      <ul class="unstyled">

                        <li class="clearfix">

                        <div class="stat_name"><?php if($this->lang->line('All_Page_Views') != '') { echo stripslashes($this->lang->line('All_Page_Views')); } else echo "All Page Views";?></div>

                        <div class="stat_value">

                          0

                        </div>

                        </li>

                      </ul>

                    </div>

                  </div>

        

              </div>

        

              <div class="dashboard-right" id="main">





              <div id="account">

             

              <?php if($userDetails->row()->id_verified =='No' || $userDetails->row()->accno==''){?>

			   <div class="box">

              <div class="middle">

             

              <h2><?php if($this->lang->line('Alerts') != '') { echo stripslashes($this->lang->line('Alerts')); } else echo "Alerts";?></h2>

              <div class="section notification_section">

              <div class="notification_area">

              <div class="notification_action">

			  <?php if($userDetails->row()->accno =='' AND $userDetails->row()->accname =='' AND $userDetails->row()->bankname ==''){

			

			  ?>

              <a target="_blank" class="dashboard_alert_link" href="account-payout"><?php if($this->lang->line('Pleasetellus') != '') { echo stripslashes($this->lang->line('Pleasetellus')); } else echo "Please tell us how to pay you.";?><i class="icon icon-caret-right"></i></a>

				<?php } else{}?>

              <div class="conformation-mail">

			 <p>  <?php

			 // echo $userDetails->row()->is_verified;

			  if($userDetails->row()->id_verified =='No'){ ?>

              <?php if($this->lang->line('Pleaseconfirm') != '') { echo stripslashes($this->lang->line('Pleaseconfirm')); } else echo "Please confirm your email address by clicking on the link we just emailed you. If you cannot find the email, you can";?>

			 </p>

			  <a href="site/user/verification/verfiy-mail"><?php if($this->lang->line('requestanew') != '') { echo stripslashes($this->lang->line('requestanew')); } else echo "request a new confirmation email";?></a><!--

        or

			

          <a href="settings"><?php if($this->lang->line('changeyouremailaddress') != '') { echo stripslashes($this->lang->line('changeyouremailaddress')); } else echo "change your email address";?></a>-->.

		  <?php  }

			  ?>

        

        </div>



              </div>

              </div>

              </div>

				

             

              </div>

			  </div>

			 <?php } ?>

              









            <div class="box" style="display:none">

              <div class="middle">

              

              <div class="section notification_section nwli">

              <div class="notification_area">

              <div class="notification_action">

              <div class="noti-left">



                

                <p class="invote-text"><?php if($this->lang->line('Invitefriendsearn') != '') { echo stripslashes($this->lang->line('Invitefriendsearn')); } else echo "Invite friends, earn travel credit!";?>  </p>

                <p><?php if($this->lang->line('Earn_up') != '') { echo stripslashes($this->lang->line('Earn_up')); } else echo "Earn up to $6,151 for everyone you invite.";?>  </p>



              </div>

                <div class="noti-right">

                   <a class="invite-frd-btn" href="invite-friends"><?php if($this->lang->line('InviteFriends') != '') { echo stripslashes($this->lang->line('InviteFriends')); } else echo "Invite Friends";?></a>





                </div>



    



              </div>

              </div>

              </div>

              

             

              </div>

              </div>





<?php 

				 $result = 0;

				 if($userDetails->row()->id != '') {

				 $this->db->select('*');

				 $this->db->from(MED_MESSAGE);

				 $this->db->where('receiverId',$userDetails->row()->id);

				 $this->db->where('msg_read','No');

                 $this->db->group_by('bookingNo');

				 $result = $this->db->get()->num_rows();

				 //echo $this->db->last_query();die;

				 }?>











              <div class="box">

              <div class="middle">

            

              <h2><?php if($this->lang->line('Messages') != '') { echo stripslashes($this->lang->line('Messages')); } else echo " New Messages";?> (<?php echo $result;?>)</h2>

              <div class="section notification_section">

              <div class="notification_area">

              <div class="notification_action">

			  <?php if ($result > 0 ) {?>

              <table>

			  <tr height="25"><th style="color:#752b7e;"><?php if($this->lang->line('Youhavereceived') != '') { echo stripslashes($this->lang->line('Youhavereceived')); } else echo "You have Received";?> <?php echo $result; ?> <?php if($this->lang->line('newmessages') != '') { echo stripslashes($this->lang->line('newmessages')); } else echo "New Message(s)";?> --> <a href="<?php echo base_url().'inbox';?>"><?php if($this->lang->line('viewmessage') != '') { echo stripslashes($this->lang->line('viewmessage')); } else echo "view message";?></a></th></tr>

			  </table>

			  <?php }

			  else

			  {?>

			  <p><?php if($this->lang->line('Nomessagesto') != '') { echo stripslashes($this->lang->line('Nomessagesto')); } else echo "No New Messages to show";?></p>

			  <?php }?>

			  </div>

              </div>

              </div>

             

             

              </div>

              </div>



                  















                      <div class="box">

              <div class="middle">

             

              <h2 class="verifi-text"><?php if($this->lang->line('Verifications') != '') { echo stripslashes($this->lang->line('Verifications')); } else echo "Verifications";?> <i class="questn"><span class="verifi"><?php if($this->lang->line('Verificationshelp') != '') { echo stripslashes($this->lang->line('Verificationshelp')); } else echo "Verifications help build trust between guests and hosts and can make booking easier.";?> <i class="arsd-ico rot"></i><a href="#"><?php if($this->lang->line('Learnmore') != '') { echo stripslashes($this->lang->line('Learnmore')); } else echo "Learn more";?> »</a></span></i></h2>

              <div class="section notification_section">

              <div class="notification_area">

              <div class="notification_action viewd">

              

              <p class="nothing"> 



 

                   

              <h5><?php if($this->lang->line('EmailAddressVerification') != '') { echo stripslashes($this->lang->line('EmailAddressVerification')); } else echo "Email Address Verification";?></h5>

			  

         <?php

			 // echo $userDetails->row()->is_verified;

			  if($userDetails->row()->id_verified =='No'){ ?>

          <?php if($this->lang->line('Pleaseverifyyour') != '') { echo stripslashes($this->lang->line('Pleaseverifyyour')); } else echo "Please verify your email address by clicking the link in the message we just sent to:";?> <?php echo $userDetails->row()->email; ?>



<?php if($this->lang->line('Cantfind') != '') { echo stripslashes($this->lang->line('Cantfind')); } else echo "Can’t find our message? Check your spam folder or resend the confirmation email.";?>

<?php }?>



<?php //echo '<pre>'; print_r($user_verified_status->row()->id_verified);

				if($this->lang->line('Verified') != '') 

				{

					$Verified = stripslashes($this->lang->line('Verified')); 

				}

				else 

				{

					$Verified = "Verified";

				}

				if($this->lang->line('No verifications yet,To get verify') != '') 

				{

					$NoVerified = stripslashes($this->lang->line('No verifications yet,To get verify')); 

				}

				else 

				{

					$NoVerified = "No verifications yet,To get verify";

				}

				$verified_id = ($userDetails->row()->id_verified =='No')?$NoVerified:$Verified;  ?>

				<br />

              <?php echo $verified_id;  ?>

              

      

            

           

        </p>



        <div class="no-veri">

       <!--<span>No verifications yet</span>-->

	  <?php if($userDetails->row()->id_verified =='No'){ ?>

       <a href="verification"><?php if($this->lang->line('Click here') != '') { echo stripslashes($this->lang->line('Click here')); } else echo "Click here";?> </a>

	  <?php } else{  ?>

       <a href="verification"><?php if($this->lang->line('AddMore') != '') { echo stripslashes($this->lang->line('AddMore')); } else echo "AddMore";?> </a>

	   

		  <?php }?>

        </div>



             



              </div>

              </div>

              </div>

             

             

              </div>

              </div>



              <!-- malar 11/07/2017 - coupon display -->  

              <div class="box" style="">

                <div class="middle">

              <h2> <?php if($this->lang->line('available_coupons') != '') { echo stripslashes($this->lang->line('available_coupons')); } else echo "Available Coupons";?></h2>

                  

                

                  <div class="section notification_section nwli">

                    <div class="notification_area">

                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship" id="productListTable">

                        <thead>

                          <tr height="40px">

                            <td><strong><?php if($this->lang->line('S.no') != '') { echo stripslashes($this->lang->line('S.no')); } else echo "S.no";?></strong></td>

                            <td ><strong><?php if($this->lang->line('coupon_name') != '') { echo stripslashes($this->lang->line('coupon_name')); } else echo "Coupon Name";?></strong> </td>

                            <td><strong><?php if($this->lang->line('coupon_code') != '') { echo stripslashes($this->lang->line('coupon_code')); } else echo "Coupon Code";?></strong></td>

                            <td><strong><?php if($this->lang->line('prodcut_list') != '') { echo stripslashes($this->lang->line('prodcut_list')); } else echo "Prodcut List";?></strong></td>

                            <td ><strong><?php if($this->lang->line('from') != '') { echo stripslashes($this->lang->line('from')); } else echo "From";?></strong></td>

                            <td ><strong><?php if($this->lang->line('to') != '') { echo stripslashes($this->lang->line('to')); } else echo "to";?></strong></td>

                            <td ><strong><?php if($this->lang->line('limit_count') != '') { echo stripslashes($this->lang->line('limit_count')); } else echo "Limit Count";?></strong></td>

                            <td ><strong><?php if($this->lang->line('Status') != '') { echo stripslashes($this->lang->line('Status')); } else echo "Status";?></strong></td>

                          </tr>

                        </thead>

                        <tbody>

                          <?php 

                          if($couponData->num_rows()>0){ 

                            $i=1;

                            foreach ($couponData->result() as $coupon) {

                              if(($coupon->quantity - $coupon->purchase_count) >0)

                              {

                                $type = $coupon->price_type ==1 ? 'flat' :'%';

                            ?>



                            <tr >

                              <td><?php echo $i; ?></td>

                              <td ><?php echo $coupon->coupon_name; ?></td>

                              <td><?php echo $coupon->code.' ('.$coupon->price_value.' '.$type.')'; ?></td>

                              <td style="text-align: center;" class="table-prd-img">

                              <?php

							  if($coupon->product_id!=''){

									$sel_product = "select p.id,p.product_title from ".PRODUCT." p where p.id IN (". $coupon->product_id.")" ; 



									$productData = $this->user_model->ExecuteQuery($sel_product);

									foreach ($productData->result() as $product) {

										$sel_img = "select ph.product_image as PImg from ".PRODUCT_PHOTOS." ph  where ph.product_id ='". $product->id."'" ; 



										$imgData = $this->user_model->ExecuteQuery($sel_img)->row();







										?><div><a href = "<?php echo base_url().'rental/'.$product->id; ?>"><img src="<?php echo base_url().'server/php/rental/'.$imgData->PImg; ?>" height='50px'>

										<label class="tab-prod-title"><?php echo $product->product_title; ?></label></a></div> 

										<?php

									}

							  }else{

								  echo 'All';

							  }



                               ?>

                                 

                               </td>

                              <td ><?php echo $coupon->datefrom; ?></td>

                              <td ><?php echo $coupon->dateto; ?></td>

                              <td ><?php echo $coupon->quantity - $coupon->purchase_count; ?></td>

                              <td ><?php echo $coupon->status; ?></td>



                            </tr>

                           <?php  $i++;

                              } 

                            }

                          }

                            ?>

                        </tbody>

                      </table>  

                    </div>

                  </div>

                  <div id="footer_pagination"><?php echo $paginationLink; ?></div>

               

                </div>

              </div>



              <!-- malar 11/07/2017 - coupon display -->  



              </div>



  </div>

              <div class="clear"></div>

            </div>

  </div>

    </div>

</div>

<!---DASHBOARD-->



<!---FOOTER-->

<?php



$this->load->view('site/templates/footer');

?>





