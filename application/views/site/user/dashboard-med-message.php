<?php 

//echo '<pre>';print_r($med_messages->result_array());die;

$this->load->view('site/templates/header');

?>



<script type="text/javascript"  src="js/validation.js"></script>



<!---DASHBOARD-->

<div class="dashboard yourlisting inbox bgcolor dasbinbxnwthm">



<div class="top-listing-head">

	<div class="main"> 

	

           <!-- <ul id="nav">

                <li ><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>

                <li class="active"><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>

                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>

                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></li>

                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>

				<li><a href="<?php echo base_url();?>user/<?php echo $userDetails->row()->id; ?>/wishlists">Wishlists</a></li> 

                <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>

				<li><a href="<?php echo base_url();?>invite"><?php if($this->lang->line('Invite') != '') { echo stripslashes($this->lang->line('Invite')); } else echo "Invite";?></a></li>

                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>

            </ul>-->

			

			

			 <!--main nav header -->

            <?php 

             $this->load->view('site/user/main_nav_header');  

            ?>





			</div></div>





<div class="dash_brd">

<!--

 <div class="box">

  <div class="close"><i class="fa fa-times-circle" aria-hidden="true"></i></div>

  <div class="inner">

   

   <div class="well1">

  <p class="er-cre">Earn $280 Travel Credit</p>

  <p class="er-cre-fre">Give your friends $70 off their first trip on Vacason.com and you'll get up to 280 $ travel credit.</p>

  <div class="invite-fre"><a class="btn blue"href="#">Invite Friends</a></div>

    <div class="invite-fre-lat"><a class="btn blue" href="#">Later</a></div>

  </div> 

   

   

  </div>

</div>



-->

<div class="main">





  <div style="display:none" class="page-top-duplt">

    <div class="page-top-duplt-top">

      <select><option>All message(3)</option></select>

      </div>



      <table class="table inbx-table">

    <tr>

     <td style="text-align: center; width: 12%;">

      <img class="aimg" src="http://192.168.1.253/muthukrishnang/holidan/images/users/Chrysanthemum.jpg">

    </td>



      <td class="name-art" style="width: 12%;">

        <span>Vimal</span><span>4:39 AM</span>  

      </td>



      <td style="width: 57%; color: rgb(140, 140, 140);"> Hi Muhammed.. is it for the whole month? . Where are you from?...</td>

      <td><b style="color:#565A5C">Declined</b></td>

      <td><span class="thread-unstar"> Unstar </span></td>





    </tr>

      </table>



  </div>







    	<div style="min-height: 183px;" id="command_center">

    

        <div id="page-wrap">

			

		<div id="example-two">

          

        <div class="list-wrap">

        

          <div id="tab_inbox">

            <div class="box" id="inbox">

                <div class="middle clearfix">

                          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_ship datatable" id="productListTable">

                     				  <thead >

 										<tr ><td width="3%"  ><strong><?php if($this->lang->line('Sno') != '') { echo stripslashes($this->lang->line('Sno')); } else echo "Sno";?></strong></td>

   										<td width="13%" ><strong><?php if($this->lang->line('Date') != '') { echo stripslashes($this->lang->line('Date')); } else echo "Date";?></strong></td>

										<td width="15%" ><strong><?php if($this->lang->line('Subject') != '') { echo stripslashes($this->lang->line('Subject')); } else echo "Subject";?></strong></td>

										<td width="15%" ><strong><?php if($this->lang->line('Action') != '') { echo stripslashes($this->lang->line('Action')); } else echo "Action";?></strong></td>

										</tr>

										</thead>

                                        <tbody>

                                        <?php 

										$i=1;

										if(!empty($med_messages)){ 

										

										/*echo '<pre>';

										print_r($med_messages->result());

										echo '</pre>';

										*/

										function msg_unread($a, $b) { 

											

											return ($b->msg_unread_count < $a->msg_unread_count) ? -1 : 1;

										} 



										usort($med_messages, 'msg_unread');



										foreach($med_messages as $med_message){ 							

?>

											<tr <?php if($med_message->msg_unread_count > 0)echo 'class="msg_unread"';?>>

											

												<td <?php if($med_message->msg_read=='No'){ echo 'class="unread-color"';} else{} ?>><?php echo $i; $i++;?></td>

												<td <?php if($med_message->msg_read=='No'){ echo 'class="unread-color"';} else{} ?>><?php echo $med_message->dateAdded;?></td>

												<td <?php if($med_message->msg_read=='No'){ echo 'class="unread-color"';} else{} ?>><?php echo $med_message->subject;?>

												

												

												<?php

												echo ($med_message->msg_unread_count>0) ? '('.$med_message->msg_unread_count.')':''; ?>

												

												<br>

												

												<?php 

												

												//same id

												if(($med_message->status=='Pending') && ($med_message->user_id==$luser_id)){

													echo '<small style="color:#752b7e;">There is a booking request for you</small>';

												}

												

												?>

												

												</td>

												<td>

												<div class="edit" style="width:100%"><a href="new_conversation/<?php echo $med_message->bookingNo;?>/<?php echo $med_message->id ;?>"><?php if($this->lang->line('viewmessage') != '') { echo stripslashes($this->lang->line('viewmessage')); } else echo "View Messagess";?></a>&nbsp;

												<?php if($med_message->msg_read=='Yes'){?>

												<a onclick="return confirm('Are you sure want to delete?');" href="site/user_settings/delete_conversation_details_msg/<?php echo $med_message->id;?>"><?php if($this->lang->line('Delete') != '') { echo stripslashes($this->lang->line('Delete')); } else echo "Delete";?></a>

												<?php } else{}?>

												

												</div>

												</td>

											</tr>

											

											



<?php /*										$product_details = $this->user_model->get_all_details(PRODUCT,array('id'=>$med_message->productId));



										$this->db->select('*');

										$this->db->from(MED_MESSAGE);

										$this->db->where('receiverId', $med_message->receiverId);

										$this->db->where('msg_read','No');

										$this->db->where('admin_id =','0');

										$this->db->or_where('admin_id !=','0');

										$this->db->where('bookingNo',$med_message->bookingNo);

										$result = $this->db->get()->num_rows();

										if($med_message->msg_status==0)

										{

											if($med_message->msg_read=='No'){

												echo "<style>.unread-color{color:#752b7e !important;}</style>";

											}

											

											?>

											<tr <?php if($result > 0)echo 'class="msg_unread"';?>>

											

											<td <?php if($med_message->msg_read=='No'){ echo 'class="unread-color"';} else{} ?>><?php echo $i; $i++;?></td>

											<td <?php if($med_message->msg_read=='No'){ echo 'class="unread-color"';} else{} ?>><?php echo $med_message->dateAdded;?></td>

											<td <?php if($med_message->msg_read=='No'){ echo 'class="unread-color"';} else{} ?>><?php echo $med_message->subject;

											

											?> <?php 

											if($userDetails->row()->group=='Seller')

											{

													

											$result_c = 0;

										   // if($userDetails->row()->id != '' && $product_details->user_id == $userDetails->row()->id ) {

											$this->db->reconnect();

											$this->db->select('*');

											$this->db->from(MED_MESSAGE);

											$this->db->where('receiverId',$userDetails->row()->id);

											$this->db->where('host_msgread_status','No');

											$this->db->where('bookingNo',$med_message->bookingNo);

											//$this->db->group_by('bookingNo');

											$result_c = $this->db->get()->num_rows();

											

											//}

											$result_css = 0;

										   // if($userDetails->row()->id != '' && $product_details->user_id != $userDetails->row()->id ) {

											$this->db->reconnect();

											$this->db->select('*');

											$this->db->from(MED_MESSAGE);

											$this->db->where('receiverId',$userDetails->row()->id);

											$this->db->where('user_msgread_status','No');

											$this->db->where('bookingNo',$med_message->bookingNo);

											//$this->db->group_by('bookingNo');

											$result_css = $this->db->get()->num_rows();

											

											//}

											$host_id = $_SESSION['fc_session_user_id'];



											echo $result_c;

	if($userDetails->row()->id==$host_id)

	{

		if($result_c!=0)

		{

		?>

		<span style='color:#752b7e;'><?php if($this->lang->line('Message') != '') { echo stripslashes($this->lang->line('Message')); } else echo "Message";?>(<?php echo $result_c; ?>)</span>

		<?php

		}

		elseif($result_css!=0)

		{

			echo "<span class='read-inmsg'>Message1($result_css)</span>";

		}

		else

		{

			//echo $result_c;

		}

		



		

											if($result_c!=0){if($med_message->user_msgread_status=='Yes'){echo "";}else{}}}}?>

											<!--User-->

											<?php

											if($userDetails->row()->group=='User')

											{

											

											if($userDetails->row()->id != '') {

											$this->db->reconnect();

											$this->db->select('*');

											$this->db->from(MED_MESSAGE);

											$this->db->where('receiverId',$userDetails->row()->id);

											$this->db->where('user_msgread_status','No');

											$this->db->where('bookingNo',$med_message->bookingNo);

											$this->db->group_by('bookingNo');

											$result_cs = $this->db->get()->num_rows();

											

											}

											$result_cs = 0;

											if($userDetails->row()->id != '') {

											$this->db->reconnect();

											$this->db->select('*');

											$this->db->from(MED_MESSAGE);

											$this->db->where('receiverId',$userDetails->row()->id);

											$this->db->where('user_msgread_status','No');

											$this->db->where('bookingNo',$med_message->bookingNo);

											$result_cs = $this->db->get()->num_rows();

											

											}

											$user_id = $_SESSION['fc_session_user_id'];

											if($userDetails->row()->id==$user_id)

											{

												//print_r($user_id);

												if($result_cs!=0)

		{

		?>

		<span style='color:red;'><?php if($this->lang->line('Message') != '') { echo stripslashes($this->lang->line('Message')); } else echo "Message";?>(<?php echo $result_cs; ?>)</span>

		<?php

		}

		else

		{

		}

												

												

											if($result_cs!=0){if($med_message->user_msgread_status=='Yes'){echo "";}else{}}}}?>

											

											</td>

											<td><div class="edit" style="width:100%"><a href="new_conversation/<?php echo $med_message->bookingNo;?>/<?php echo $med_message->id ;?>"><?php if($this->lang->line('viewmessage') != '') { echo stripslashes($this->lang->line('viewmessage')); } else echo "View Messagess";?></a>&nbsp;

											<?php if($med_message->msg_read=='Yes'){?>

											<a onclick="return confirm('Are you sure want to delete?');" href="site/user_settings/delete_conversation_details_msg/<?php echo $med_message->id;?>"><?php if($this->lang->line('Delete') != '') { echo stripslashes($this->lang->line('Delete')); } else echo "Delete";?></a>

											<?php } else{}?>

											

											</div></td>

											

											</tr>

											<?php 

											

										}

										

										*/?>

										

										<?php

										

										} //foreach



										}else{

											

									?>

									<tr><td colspan="4"><center><?php if($this->lang->line('NoMessage') != '') { echo stripslashes($this->lang->line('NoMessage')); } else echo "There is no message(s) in inbox";?></center> </td></tr>

<?php									

										} ?>

                                        </tbody>

                                        </table>

                                        

                                        

                                        </p>

                  <?php echo $paginationLink;?>                            

                              

          </div>

 			 </div>  

          </div>

         </div> <!-- END List Wrap -->

     

         </div>     </div> <!-- END Organic Tabs (Example One) -->







 </div>

    </div>

	</div>

</div>

<!---DASHBOARD-->

<?php 

$this->load->view('site/templates/footer');

?>



<script>

$('.box .close').on('click', function() {

  $(this).parent().fadeOut();

});

</script>