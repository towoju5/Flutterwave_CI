<?php 
//echo '<pre>';print_r($receiverDetails->row());die;

//print_r($conversationDetails->result());
//print_r($senderDetails->row());
$this->load->view('site/templates/header');
$count = 0;
?>

<script>
<?php if($unread_count != 0 ){ ?>
var unread = "<?php echo $unread_count; ?>";
$(".unread-icon").text(unread);

<?php } ?>
function sendMessage()
{   

   document.body.style.cursor='wait'; 
	var sender_id = $('#sender_id').val();
	var receiver_id = $('#receiver_id').val();
	var booking_id = $('#bookingno').val();
	var pageURL = $('#pageURL').val();
	var product_id = $('#product_id').val();
	var message_content = $('#message_content').val();
	if(message_content == '')
	{
		alert('<?php if($this->lang->line('Message_is_required!') != '') { echo stripslashes($this->lang->line('Message_is_required!')); } else echo "Message is required!";?>');
		return false;
	}
	//alert(message_content);
	var subject = $('#subject').val();
	$.ajax(
		{
			type: 'POST',
			url: "<?php echo base_url();?>site/experience/send_message",
			data: {'sender_id':sender_id, 'receiver_id':receiver_id, 'booking_id':booking_id, 'product_id':product_id, 'message':message_content,'subject':subject},
			success: function(data) 
			{	
				 window.location.reload();
			}
		});
}

</script>
<div class="dashboard yourlisting yourlistinghome converstn">
	<div class="top-listing-head">
		<div class="main">   
            <!--main nav header -->
            <?php 
             $this->load->view('site/user/main_nav_header');  
            ?>
		</div>
	</div>
				<?php 
				$pageURL = 'http';
				if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
				$pageURL .= "://";
				if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				}
				?>
	<div class="dash_brd">
	<div id="command_center">
	<div class="conversation-box">
		<div class="hatbx">
			<h2 class="convrs"><?php if($this->lang->line('Conversation with') != '') { echo stripslashes($this->lang->line('Conversation with')); } else echo "Conversation with";?> <span class="chat-user-name"><?php echo $receiverDetails->row()->user_name?></span></h2>
			<?php if($bookingDetails->row()->renter_id != $userId && $conversationDetails->row()->status == 'Decline'){ ?>
			<div class="top-section">
            <p class="rd-color"><?php if($this->lang->line('Declined') != '') { echo stripslashes($this->lang->line('Declined')); } else echo "Declined";?> </p>
            <p><?php if($this->lang->line('Don t give up — keep contacting other listings.') != '') { echo stripslashes($this->lang->line('Don t give up — keep contacting other listings.')); } else echo "Don t give up — keep contacting other listings.";?></p>
            <p><?php if($this->lang->line('Contacting several places considerably improves your odds of a booking.') != '') { echo stripslashes($this->lang->line('Contacting several places considerably improves your odds of a booking.')); } else echo "Contacting several places considerably improves your odds of a booking.";?></p>
            <a class="rd-color" href="#"><?php if($this->lang->line('View Similar Listings') != '') { echo stripslashes($this->lang->line('View Similar Listings')); } else echo "View Similar Listings";?></a>

			</div>
			<?php } else if($bookingDetails->row()->renter_id == $userId && $conversationDetails->row()->status == 'Decline'){ ?>
			<div class="top-section">
            <p class="rd-color"><?php if($this->lang->line('Declined') != '') { echo stripslashes($this->lang->line('Declined')); } else echo "Declined";?> </p>
            <p><?php if($this->lang->line('You was declined the guest for this booking.') != '') { echo stripslashes($this->lang->line('You was declined the guest for this booking.')); } else echo "You was declined the guest for this booking.";?></p>
            <p><?php if($this->lang->line('Kindly reply to guest to get more number of guests.') != '') { echo stripslashes($this->lang->line('Kindly reply to guest to get more number of guests.')); } else echo "Kindly reply to guest to get more number of guests.";?></p>
            </div>
			<?php }else if($bookingDetails->row()->renter_id != $userId && $conversationDetails->row()->status == 'Accept'){ ?>
			<div class="top-section">
            <p class="rd-color"><?php if($this->lang->line('Accepted') != '') { echo stripslashes($this->lang->line('Accepted')); } else echo "Accepted";?> </p>
            <p><?php if($this->lang->line('Your request for this property was accepted by Host.') != '') { echo stripslashes($this->lang->line('Your request for this property was accepted by Host.')); } else echo "Your request for this property was accepted by Host.";?></p>
            <p><?php if($this->lang->line('kindly_make_payment_experience') != '') { echo stripslashes($this->lang->line('kindly_make_payment_experience')); } else echo "Kindly make a payment and contact Host through this conversation.";?></p>
            <a class="rd-color" href="#"><?php if($this->lang->line('View Similar Listings') != '') { echo stripslashes($this->lang->line('View Similar Listings')); } else echo "View Similar Listings";?></a>

			</div>
			<?php } else if($bookingDetails->row()->renter_id == $userId && $conversationDetails->row()->status == 'Accept'){ ?>
			<div class="top-section">
            <p class="rd-color"><?php if($this->lang->line('Accepted') != '') { echo stripslashes($this->lang->line('Accepted')); } else echo "Accepted";?> </p>
            <p><?php if($this->lang->line('You Accepted the guest for this booking.') != '') { echo stripslashes($this->lang->line('You Accepted the guest for this booking.')); } else echo "You Accepted the guest for this booking.";?></p>
            <p><?php if($this->lang->line('Kindly respond to guest to give a guidance through this conversation.') != '') { echo stripslashes($this->lang->line('Kindly respond to guest to give a guidance through this conversation.')); } else echo "Kindly respond to guest to give a guidance through this conversation.";?></p>
            </div>
			<?php }?>

			<div class="col-md-8 top-area-col">
				<div class="top-area-convers">
					<div class="dic-area">
						<textarea id="message_content" class="fstlin-txt" placeholder="<?php if($this->lang->line('Add a Personal message here...') != '') { echo stripslashes($this->lang->line('Add a Personal message here...')); } else echo "Add a Personal message here...";?>" ></textarea>
		
						<div class="botom-botm">
							<input type="hidden" id="sender_id" value="<?php echo $sender_id;?>" />
							<input type="hidden" id="receiver_id" value="<?php echo $receiver_id;?>" />
							<input type="hidden" id="bookingno" value="<?php echo $bookingNo;?>" />
							<input type="hidden" id="product_id" value="<?php echo $productId;?>" />
							<input type="hidden" id="subject" value="<?php echo $conversationDetails->row()->subject;?>" />            
							<input type="hidden" id="pageURL" value="<?php echo $pageURL;?>" />
							<input type="hidden" id="baseURL" value="<?php echo base_url();?>" />
							
							<button class="Send-message" onClick="sendMessage();"><?php if($this->lang->line('Send Message') != '') { echo stripslashes($this->lang->line('Send Message')); } else echo "Send Message";?></button>
							<?php 
							if($conversationDetails->row()->status != 'Pending'){
								
													
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
 
								
								
								
	$status = ($conversationDetails->row()->status == 'Accept')?"$accepted":"$declined";
								
								
								}?>
						</div>
						

						<div class="full-hat-app">
								<div class="full-hat-app-header">
                                   <div class="full-hat-app-left">
                                   	<span class="red-ares"><?php echo $bookingDetails->row()->product_title;?></span>
                                   	<span class="date-plac"><?php echo date('M d', strtotime($bookingDetails->row()->checkin));?> - <?php echo date('d, Y', strtotime($bookingDetails->row()->checkout));?>. <?php echo $bookingDetails->row()->NoofGuest;echo ($bookingDetails->row()->NoofGuest > 1)?'Guests':'Guest';?></span>


								</div>


								<div class="full-hat-app-right">
                                     <span class="cls-dolar">
                                      <?php  echo $currencySymbol; ?>
                                     <?php
                                     //echo $bookingDetails->row()->currency;
                                     	 if ($bookingDetails->row()->secDeposit != 0) {
                                     	 	$secDeposite = $bookingDetails->row()->secDeposit;
                                     	 }
                                         
											$totalAmount = $bookingDetails->row()->subTotal + $bookingDetails->row()->serviceFee + $secDeposite;
											if($bookingDetails->row()->currency != $this->session->userdata('currency_type'))
						                      {
						                      

						                     echo convertCurrency($bookingDetails->row()->currency,$this->session->userdata('currency_type'),$totalAmount);

						                     }
											else{
						                     	 echo $totalAmount;
						                     }

                                     // echo $this->session->userdata('currency_s').' '.CurrencyValue($bookingDetails->row()->prd_id,$bookingDetails->row()->totalAmt); ?>
                                     <?php echo $this->session->userdata('currency_type');?>
                                     </span>

								</div>

								</div>



						</div>
					</div> 
				</div>
				<ul>
				<?php if($this->lang->line('Guest') != '')
							{ 
								$Guest = stripslashes($this->lang->line('Guest')); 
							} 
							else
							{
								$Guest = "Guest";
							}if($this->lang->line('guest') != '')
							{ 
								$guests = stripslashes($this->lang->line('guest')); 
							} 
							else
							{
								$guests = "Guests";
							}
							?>
				<?php 
				$total = $conversationDetails->num_rows();
				foreach($conversationDetails->result() as  $coversation) {
				$count++;
				//echo $sender_id;
				 if($sender_id == $coversation->senderId){ ?>
					<li>
						<div class="col-xs-2 host-cht"><a class="aurtors text-center" href="<?php echo base_url();?>users/show/<?php echo $senderDetails->row()->id?>">
						<img style="border-radius: 50%; width: 32px; height: 33px;" src="<?php if($senderDetails->row()->loginUserType == 'google'){ echo $senderDetails->row()->image;} elseif($senderDetails->row()->image == '' ){ echo base_url();?>images/site/profile.png<?php } else { echo base_url().'images/users/'.$senderDetails->row()->image;}?>"> <span class="pep-name"><?php echo $senderDetails->row()->firstname.' '.$senderDetails->row()->lastname;?></span></a></div>
						<div class="col-xs-10 host-cht">

						
						<div class="conversation">
						<span class="ardsleft"></span>
						<span><pre><?php echo $coversation->message;?></pre></span>

						</div>

						<span class="span-left-area"><?php echo date('d/m/Y', strtotime($coversation->dateAdded));?> <?php if($this->lang->line('via the') != '') { echo stripslashes($this->lang->line('via the')); } else echo "via the";?> <label><?php if($this->lang->line('web') != '') { echo stripslashes($this->lang->line('web')); } else echo "web";?></label>
						</span>

						</div>
      
					</li>
					<?php } else { 
					
					if($total == $count) { //print_r($bookingDetails->row());?>
					<li class="booking_msg">
				<label class="line-mesg">	<?php if($this->lang->line('Inquiry about') != '') { echo stripslashes($this->lang->line('Inquiry about')); } else echo "Inquiry about";?><p class="conv-enquiry"> <a href='<?php echo base_url().'view_experience/'.$bookingDetails->row()->experience_id;?>'><?php echo $bookingDetails->row()->product_title;?></a></p></label>
				<span class="line-let">
					<?php  if(date('Y', strtotime($bookingDetails->row()->checkout)) == date('Y', strtotime($bookingDetails->row()->checkin))){ echo date('M d', strtotime($bookingDetails->row()->checkin));} else {echo date('M d, Y', strtotime($bookingDetails->row()->checkin));}?> - <?php if(date('M', strtotime($bookingDetails->row()->checkout)) != date('M', strtotime($bookingDetails->row()->checkin))) { echo date('M d, Y', strtotime($bookingDetails->row()->checkout)); } else { echo date('d, Y', strtotime($bookingDetails->row()->checkout)); } ?>. <?php echo $bookingDetails->row()->NoofGuest;echo ($bookingDetails->row()->NoofGuest > 1)?$guests:$Guest;?>
					</span></li>
					<?php $first = 1; } ?>

					<li class="evenli">
     
						<div class="col-xs-10 host-cht1">

						<div class="conversation">
						<span class="ardsleft"></span>
						<span><pre><?php echo $coversation->message;?></pre></span>

						</div>

						<span class="span-left-area"><?php echo date('d/m/Y', strtotime($coversation->dateAdded));?> <?php if($this->lang->line('via the') != '') { echo stripslashes($this->lang->line('via the')); } else echo "via the";?> <label><?php if($this->lang->line('web') != '') { echo stripslashes($this->lang->line('web')); } else echo "web";?></label>


						</span>

						</div>
      
						<div class="col-xs-2 host-cht1"><a class="aurtors text-center" href="<?php echo base_url();?>users/show/<?php echo $receiverDetails->row()->id?>">
						<img style="border-radius: 50%; width: 32px; height: 33px;" src="<?php if($receiverDetails->row()->loginUserType == 'google'){ echo $receiverDetails->row()->image;} elseif($receiverDetails->row()->image == '' ){ echo base_url();?>images/site/profile.png<?php } else { echo base_url().'images/users/'.$receiverDetails->row()->image;}?>"> <span class="pep-name"><?php echo $receiverDetails->row()->firstname.' '.$receiverDetails->row()->lastname;?></span></a></div>
   
					</li>
					<?php } }?>
				</ul>
			</div>


    <div class="col-md-4 top-area-col">

    	<div class="right-artrs">
          <div class="profile-topd">
          <div class="profile-topd-left">
        <img src="<?php if($receiverDetails->row()->loginUserType == 'google'){ echo $receiverDetails->row()->image;} elseif($receiverDetails->row()->image == '' ){ echo base_url();?>images/site/profile.png<?php } else { echo base_url().'images/users/'.$receiverDetails->row()->image;}?>">
           </div>

           <div class="profile-topd-right">

           	<span class="chat-user-name"><?php echo $receiverDetails->row()->user_name;?></span>
           	
           	<address><?php if($receiverDetails->row()->address!='') { echo $receiverDetails->row()->address;?></br> <?php } else {if($this->lang->line('No Address') != '') { echo stripslashes($this->lang->line('No Address')); } else echo "No Address"; }?> <br><?php if($this->lang->line('Member since') != '') { echo stripslashes($this->lang->line('Member since')); } else echo "Member since";?> <?php echo date('Y', strtotime($receiverDetails->row()->created));?></address>

           </div>

           <div class="profile-topd-middle">
           	<span><?php if($this->lang->line('Verifications') != '') { echo stripslashes($this->lang->line('Verifications')); } else echo "Verifications";?> </span>
           	 <ul class="verid">
			 
				
				<?php if($receiverDetails->row()->id_verified == 'Yes') {?>
           	 	<li class="verified">
					  <p><?php if($this->lang->line('Email Address') != '') { echo stripslashes($this->lang->line('Email Address')); } else echo "Email Address";?></p>
					  <label><?php if($this->lang->line('Verified') != '') { echo stripslashes($this->lang->line('Verified')); } else echo "Verified";?></label>
           	 	</li>
				<?php } else { ?>
           	 	<li class="not-verified">
					  <p><?php if($this->lang->line('Email Address') != '') { echo stripslashes($this->lang->line('Email Address')); } else echo "Email Address";?></p>
					  <label><?php if($this->lang->line('NotVerified') != '') { echo stripslashes($this->lang->line('NotVerified')); } else echo "Not Verified";?></label>
           	 	</li>
				<?php } ?>
				
				<?php if($receiverDetails->row()->ph_verified == 'Yes') {?>
           	 	<li class="verified">
					  <p><?php if($this->lang->line('Phone number') != '') { echo stripslashes($this->lang->line('Phone number')); } else echo "Phone number";?></p>
					  <label><?php if($this->lang->line('Verified') != '') { echo stripslashes($this->lang->line('Verified')); } else echo "Verified";?></label>
           	 	</li>
				<?php } else { ?>
           	 	<li class="not-verified">
					  <p><?php if($this->lang->line('Phone number') != '') { echo stripslashes($this->lang->line('Phone number')); } else echo "Phone number";?></p>
					  <label><?php if($this->lang->line('NotVerified') != '') { echo stripslashes($this->lang->line('NotVerified')); } else echo "Not Verified";?></label>
           	 	</li>
				<?php } ?>
				
				<!-- is_verified Temporary hide. if we need later unhide this Starts-->
				<?php // if($receiverDetails->row()->is_verified == 'Yes') {?>
           	 <!--	<li class="verified">
					  <p><?php //if($this->lang->line('VerifiedID') != '') { echo stripslashes($this->lang->line('VerifiedID')); } else echo "VerifiedID";?></p>
					  <label><?php// if($this->lang->line('VerifiedID') != '') { echo stripslashes($this->lang->line('VerifiedID')); } else echo "VerifiedID";?><?php// if($this->lang->line('Yes') != '') { echo stripslashes($this->lang->line('Yes')); } else echo "Yes";?></label>
           	 	</li>
				<?php //} else { ?>
           	 	<li class="not-verified">
					  <p><?php// if($this->lang->line('VerifiedID') != '') { echo stripslashes($this->lang->line('VerifiedID')); } else echo "VerifiedID";?></p>
					  <label><?php// if($this->lang->line('No') != '') { echo stripslashes($this->lang->line('No')); } else echo "No";?></label>
           	 	</li>-->
				<?php //} ?>
				
				<!-- is_verified Temporary hide. if we need later unhide this Ends-->
				
				<?php if($reviewCount > 0) {?>
           	 	<li class="verified">
				<?php } else { ?>
				<li class="not-verified">
				<?php } ?>
					  <p><?php if($this->lang->line('review') != '') { echo stripslashes($this->lang->line('review')); } else echo "Review";?></p>
					  <label><?php echo $reviewCount;?> <?php if($this->lang->line('review') != '') { echo stripslashes($this->lang->line('review')); } else echo "review";?></label>
           	 	</li>


           	</ul>
           </div>

          </div>
</div>
         

    </div>


	</div>

</div></div></div>

</div>

<style>


</style>

<script>

function slidings(){

$(".botom-botm").hide();
$(".fstlin-txt").hide();
$(".dic-area").css('padding','0');
$(".full-hat-app").slideDown();
};

function alowdsliding(){
$(".aloe-div-opens").slideToggle();
$(".aloe-div-opens2").hide();
$(".aloe-div-opens3").hide();

}


function alowdsliding2(){
$(".aloe-div-opens").hide();
$(".aloe-div-opens2").slideToggle();
$(".aloe-div-opens3").hide();

}

function alowdsliding3(){
$(".aloe-div-opens").hide();
$(".aloe-div-opens2").hide();
$(".aloe-div-opens3").slideToggle();

}
</script>

<?php
$this->load->view('site/templates/footer');
?>

