<?php 
include_once('application/views/site/templates/header.php');

$facebook_id = $this->config->item('facebook_app_id');
$facebook_secert = $this->config->item('facebook_app_secret');
$linkedin_app_id = $this->config->item('linkedin_app_id');
$linkedin_app_key = $this->config->item('linkedin_app_key');
$google_id = $this->config->item('google_client_id');
$google_secert = $this->config->item('google_client_secret');

 ?>

<link rel="stylesheet" type="text/css" href="css/colorbox.css" media="all" />
<link href="css/page_inner.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/my-account.css" type="text/css" media="all"/>
<script type="text/javascript" src="js/site/SpryTabbedPanels.js"></script>

<script type="text/javascript" src="js/site/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="js/site/jquery.galleryview-3.0-dev.js"></script>
<script type="text/javascript">
      (function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();
</script>

<style>

body{overflow-x: hidden;}

</style>


<!---DASHBOARD-->
<div class="dashboard yourlisting emailverify bgcolor">

<div class="top-listing-head">
 <div class="main">  
 <?php 
             $this->load->view('site/user/main_nav_header');  
            ?>
           </div></div>
	<div class="dash_brd">
    	<div id="command_center">
    
            <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
               <?php /*?><li><a href="<?php echo base_url();?>rental/<?php echo $userDetails->row()->id;?>">Your Listing</a></li><?php */?>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></li>
                <li class="active"><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
				<li><a href="<?php echo base_url();?>invite"><?php if($this->lang->line('Invite') != '') { echo stripslashes($this->lang->line('Invite')); } else echo "Invite";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul>
			
<div class="lispg_top">			
			<div class="dashboard-sidemenu">    <ul class="subnav">
                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('EditProfile') != '') { echo stripslashes($this->lang->line('EditProfile')); } else echo "Edit Profile";?></a></li>
				<li><a href="<?php echo base_url();?>photo-video"><?php if($this->lang->line('photos') != '') { echo stripslashes($this->lang->line('photos')); } else echo "Photos";?></a></li>
				<li class="active" ><a href="<?php echo base_url();?>verification"><?php if($this->lang->line('TrustandVerification') != '') { echo stripslashes($this->lang->line('TrustandVerification')); } else echo "Trust and Verification";?></a></li>
                <li ><a href="<?php echo base_url();?>display-review"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></a></li>
				<li ><a href="<?php echo base_url();?>display-dispute"><?php if($this->lang->line('Dispute') != '') { echo stripslashes($this->lang->line('Dispute')); } else echo "Dispute";?></a></li>
				 <li ><a href="users/show/<?php echo $userDetails->row()->id;?>"><?php if($this->lang->line('ViewProfile') != '') { echo stripslashes($this->lang->line('ViewProfile')); } else echo "View Profile";?></a></li>
				
                          
            </ul>
			</div>

            	<div class="listiong-areas">
				
				<div class="box">
				<div class="middle">
			
				<div class="section notification_section">
				
				<div class="notification_action">
				<div class="left-notic">
				
<h3 class="bold-verify"><?php if($this->lang->line('VerifyyourID') != '') { echo stripslashes($this->lang->line('VerifyyourID')); } else echo "Verify Your ID";?></h3>

<p><?php if($this->lang->line('GettingyourVerified') != '') { echo stripslashes($this->lang->line('GettingyourVerified')); } else echo "Getting your Verified ID is the easiest way to help build trust in the community. We'll verify you by matching information from an online account to an official ID.";?>
</p>
<p><?php if($this->lang->line('youwantbelow') != '') { echo stripslashes($this->lang->line('youwantbelow')); } else echo "Or, you can choose to only add the verifications you want below.";?></p>

				
				<div class="right-notic">
				<?php 
				//$user_id_exist=$this->user_model->get_all_details(USERS,array('id'=>$UserDetail->row()->id, 'id_verified'=>'Yes'));
				//echo "<pre>";print_r($user_id_exist->row()>id_verified);die;
				if($UserDetail->row()->id_verified == 'Yes')
				{
					?><a class="verify-text" href="javascript:void(0);"><?php if($this->lang->line('Verified') != '') { echo stripslashes($this->lang->line('Verified')); } else echo "Verified";?></a><?php
				}
				else
				{
					?>
					
					<a class="verify-text" href="verification/verify-mail"><?php if($this->lang->line('Verifyme') != '') { echo stripslashes($this->lang->line('Verifyme')); } else echo "Verify me";?></a><?php
					
				}
				?>
				
								
				
				</div></div>
				</div>
				
				</div>
				</div>
				
				
				
				
				
				
				
				
				
				
				<div class="middle">
             
              <h3 class="bold-verify"><?php if($this->lang->line('Verifications') != '') { echo stripslashes($this->lang->line('Verifications')); } else echo "Verifications";?> <i class="questn"><span class="verifi"><?php if($this->lang->line('Verificationshelp') != '') { echo stripslashes($this->lang->line('Verificationshelp')); } else echo "Verifications help build trust between guests and hosts and can make booking easier.";?> </span></i></h3>
              <div class="section notification_section">
              <div class="notification_area">
              <div class="notification_action viewd">
			  
              <?php 
				if($this->lang->line('Verified') != '') 
				{
					$Verified = stripslashes($this->lang->line('Verified')); 
				}
				else 
				{
					$Verified = "Verified";
				}
				if($this->lang->line('NotVerified') != '') 
				{
					$NotVerified = stripslashes($this->lang->line('NotVerified')); 
				}
				else 
				{
					$NotVerified = "Not Verified";
				}
				
				$user_id_exist=$this->user_model->get_all_details(USERS,array('id'=>$UserDetail->row()->id));
					$eVerify = $user_id_exist->row()->id_verified;
					$eV = ($eVerify == 'Yes' ? $Verified:$NotVerified);
					$pVerify = $user_id_exist->row()->ph_verified;
					$pV = ($pVerify == 'Yes' ? $Verified:$NotVerified)
					?><h5><?php if($this->lang->line('EmailAddressVerification') != '') { echo stripslashes($this->lang->line('EmailAddressVerification')); } else echo "Email Address Verification";?></h5>
			  
				
              <span class="verification-info"><?php echo $eV;?></span>
			  <h5><?php if($this->lang->line('PhoneNumberVerification') != '') { echo stripslashes($this->lang->line('PhoneNumberVerification')); } else echo "Email Phone Number Verification";?></h5>
			  			
              <span class="verification-info-nil"><?php echo $pV;?></span>
			 
				
				
                           

              </div>
              </div>
              </div>
             
             
              </div>
				



				
			<div class="middle">
			
			
			<h3 class="bold-verify">Phone Number Verification </h3>
			
			
			
			
				<div class="section notification_section">
				<div class="notification_area">
				<ul class="notification_action mail">
					<?php if($eVerify != 'Yes'){?>
					<li>
					<h3><?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address";?></h3>
					
					<p><?php if($this->lang->line('Pleaseverify') != '') { echo stripslashes($this->lang->line('Pleaseverify')); } else echo "Can’t find our message? Check your spam folder or";?> <a href="verification/send-mail"> <?php if($this->lang->line('findour') != '') { echo stripslashes($this->lang->line('findour')); } else echo "resend the confirmation email.";?> </a></p>
				    </li>
					<?php } if ($pVerify != 'Yes'){ ?>
				    <li>
				
					<p><?php if($this->lang->line('Makeit') != '') { echo stripslashes($this->lang->line('Makeit')); } else echo "Make it easier to communicate with a verified phone number. We’ll send you a code by SMS or read it to you over the phone. Enter the code below to confirm that you’re the person on the other end.";?> </p>
					<p><?php if($this->lang->line('Restassured') != '') { echo stripslashes($this->lang->line('Restassured')); } else echo "Rest assured, your number is only shared with another member once you have a confirmed booking.";?> </p>
				


				
			<div class="phone-number-verify-widget1" style="display: block;">
   <div class="pnaw-step1">
      <div id="phone-number-input-widget-64e0b448" class="phone-number-input-widget">
         <div class="email-phone-container">
            <label class="contrylbl-emai" for="phone_country"><?php if($this->lang->line('Chooseacountry') != '') { echo stripslashes($this->lang->line('Chooseacountry')); } else echo "Choose a country:";?></label>
            <div class="select">
               <select id="phone_country" name="phone_country" onchange="get_mobile_code(this.value)">
                  <option value=""><?php if($this->lang->line('') != 'Select') { echo stripslashes($this->lang->line('Select')); } else echo "Select";?></option>
                  <?php foreach($active_countries->result() as $active_country) :?>
                  <option value="<?php echo $active_country->id;?>" <?php if ($active_country->id== $this->config->item ('admin_country_code')) { echo 'selected="selected"'; } ?>>
                     <?php echo $active_country->name;  ?>
                  </option>
                  <?php endforeach; ?>
               </select>
			     
            </div>
         </div>
         <div class="email-phone-container">
            <label for="phone_number" class="contrylbl-emai"><?php if($this->lang->line('') != 'Addaphonenumber') { echo stripslashes($this->lang->line('Addaphonenumber')); } else echo "Add a phone number";?>:</label>
            <div class="pniw-number-container" id="pn2">
               <div class="pniw-number-prefix">
                 
               </div>
               <input id="phone_number" class="pniw-number" type="text">
            </div>
         </div>
      </div>
      <div class="pnaw-verify-container">
         <a class="btn btn-primary" rel="sms" href="javascript:void(0);" id="verify_sms"><?php if($this->lang->line('VerifyviaSMS') != '') { echo stripslashes($this->lang->line('VerifyviaSMS')); } else echo "Verify via SMS";?></a>
         <a class="btn btn-primary" rel="call" href="#"><?php if($this->lang->line('VerifyviaCall') != '') { echo stripslashes($this->lang->line('VerifyviaCall')); } else echo "Verify via Call";?></a>
         <a class="why-verify" target="_blank" href="pages/why-verify" style="display:none;"><?php if($this->lang->line('WhyVerify') != '') { echo stripslashes($this->lang->line('WhyVerify')); } else echo "Why Verify?";?></a>
      </div>
   </div>
</div>


					
					<?php } else { ?>
					 <input class="mobil-num" type="text" value="<?php echo $userDetails->row()->phone_no; ?>" disabled>
				 <span class="tips-text verified-num">
			 	<a href="javascript:void(0);" onclick="changePhone();" rel="changePhone">
			    <?php if($this->lang->line('PhoneNumberisVerified') != '') { echo stripslashes($this->lang->line('PhoneNumberisVerified')); } else echo "Phone Number is Verified"; ?> 
			    </a>

				</span>
					<?php } ?>
					<input type="hidden" name="admin_country" id="admin_country" value="<?php echo $this->config->item ('admin_country_code'); ?>">
				    </li>
					
					
					
					
					
					
			
			
			

				    <li>
				    	<div class="phone-number-verify-widget verification_div" style="display: none;">
    <p class="message message_sent"></p>

    <label for="phone_number_verification">Please enter the 6-digit code:</label>
    <input type="text" id="mobile_verification_code">
     <a href="javascript:void(0);" onclick="check_phpone_verification()" rel="verify">
        <?php if($this->lang->line('Verify') != '') { echo stripslashes($this->lang->line('Verify')); } else echo "Verify";?>
      </a>
      <a href="javascript:void(0);" onclick="cancel_verification();">
        <?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel";?>
      </a>
    
    <p class="arrive"><?php if($this->lang->line('arrival_text') != '') { echo stripslashes($this->lang->line('arrival_text')); } else echo "If it doesn't arrive, click cancel and try call verification instead.";?></p>
  
			</div>
						</li>
						
						
						
						
						
						<!--
			 <?php if (($facebook_id !='') && ($facebook_secert !='')) { ?>		

				  <li class="socil">
					<h3 class="face-bok"><?php if($this->lang->line('Facebook') != '') { echo stripslashes($this->lang->line('Facebook')); } else echo "Facebook";?></h3>
					<div class="verify-left">
					<p><?php if($this->lang->line('Signnwit') != '') { echo stripslashes($this->lang->line('Signnwit')); } else echo "Sign in with Facebook and discover your trusted connections to hosts and guests all over the world.";?></h3> </p>
					</div>
					<?php if( $UserDetail->row()->facebook == '' ) {?>
					<a class="conect" onclick="fb_login()" style="cursor:pointer;"><?php if($this->lang->line('Connect') != '') { echo stripslashes($this->lang->line('Connect')); } else echo "Connect";?></a>
					<?php } else {?>
					<a onclick="return confirm('Are you sure want to disconnect!');" class="conect" href="<?php echo base_url().'site/invitefriend/facebook_disconnect'; ?>"><?php if($this->lang->line('Disconnect') != '') { echo stripslashes($this->lang->line('Disconnect')); } else echo "Disconnect";?></a>
					<?php } ?>
				   </li>
				   <?php }
							if($google_id !='' && $google_secert !='') { ?>
				   
				   <li class="socil">
					<h3 class="face-bok"><?php if($this->lang->line('Google') != '') { echo stripslashes($this->lang->line('Google')); } else echo "Google";?></h3>
					<div class="verify-left">
					<p><?php if($this->lang->line('Connectyour') != '') { echo stripslashes($this->lang->line('Connectyour')); } else echo "Connect your account to your Google account for simplicity and ease.";?></p>
					</div>
					<?php if( $UserDetail->row()->google == '' ) {?>
					<a class="conect" style="cursor:pointer;" onclick="login()"><?php if($this->lang->line('Connect') != '') { echo stripslashes($this->lang->line('Connect')); } else echo "Connect";?></a>
					<?php } else {?>
					<a onclick="return confirm('Are you sure want to disconnect!');" class="conect" href="<?php echo base_url().'site/invitefriend/google_disconnect'; ?>"><?php if($this->lang->line('Disconnect') != '') { echo stripslashes($this->lang->line('Disconnect')); } else echo "Disconnect";?></a>
					<?php } ?>
				   </li>

					<?php }
							if($linkedin_app_id !='' && $linkedin_app_key !='') { ?>	
					 <li class="socil">
					<h3 class="face-bok"><?php if($this->lang->line('Linked in') != '') { echo stripslashes($this->lang->line('Linked in')); } else echo "Linked in";?></h3>
					<div class="verify-left">
					<p><?php if($this->lang->line('Createaink') != '') { echo stripslashes($this->lang->line('Createaink')); } else echo "Create a link to your professional life by connecting your account and LinkedIn accounts.";?>  </p>
					</div>
					<?php if( $UserDetail->row()->twitter == '' ) {?>
					<a class="conect" href="<?php echo base_url().'site/invitefriend/linkedin_connect'; ?>"><?php if($this->lang->line('Connect') != '') { echo stripslashes($this->lang->line('Connect')); } else echo "Connect";?></a>
					<?php } else { ?>
					<a onclick="return confirm('Are you sure want to disconnect!');" class="conect" href="<?php echo base_url().'site/invitefriend/linkedin_disconnect'; ?>"><?php if($this->lang->line('Disconnect') != '') { echo stripslashes($this->lang->line('Disconnect')); } else echo "Disconnect";?></a>
					<?php } ?>
					
					 </li>
					 -->
					 <?php } ?>

</ul>

				</div>
				</div>
				</div>
				

				<!-- malar 12/07/2017 - proof verification starts -->

				
					<div class="middle proofverification-mid" style="<?php if ($user_Details->row()->group=='Seller' || $user_Details->row()->is_experienced==1){ echo "display:block";} else if ($user_Details->row()->group=='User') { echo "display:none";}?>" >
					
					
					
					
					<?php
						//echo $proofDetails->num_rows();
						if($proofDetails->num_rows()>0)
						{
						?>
							<div class="col-sm-12 text-center">
								<table class="table table-responsive">
									<thead>
										<tr>
											<th width="120px"><?php if($this->lang->line('proof_name') != '') { echo stripslashes($this->lang->line('proof_name')); } else echo "Proof Name";?></th>
											<th><?php if($this->lang->line('file') != '') { echo stripslashes($this->lang->line('file')); } else echo "File";?></th>
											<th width="100px"><?php if($this->lang->line('Status') != '') { echo stripslashes($this->lang->line('Status')); } else echo "Status";?></th>
											<!--<th>Comments</th>-->
										</tr>
									</thead>
									<tbody>
										<?php
										//print_r($proofDetails->result());
										$img_type  = array('gif','jpg','png','bmp','jpeg');
										$doc_type  = array('doc','docx');
										$pdf_type = 'pdf';

										foreach ($proofDetails->result() as $proof) {

											$file_ar = explode('.',$proof->proof_file);
											$file_ext = $file_ar[1]; 

											$proof_title = '';
											if($proof->proof_type =='1')
												$proof_title = "Passport";
											elseif($proof->proof_type =='2')
												$proof_title = "Voter ID";
											elseif($proof->proof_type =='3')
												$proof_title = "Driving Licence";
											
											if($proof->proof_status=='P')
												$proof_status = 'Not Verified';
											elseif($proof->proof_status=='CL')
												$proof_status = 'Cancelled';
											elseif($proof->proof_status=='V')
												$proof_status = 'Verified';
											else
												$proof_status='Not Done';
											?>
											<tr>
												<td><h4><?php echo $proof_title;?></h4></td>
												<td>
													<?php 

													if(in_array($file_ext, $img_type)){
													?>
														<img src="<?php echo ID_PROOF_PATH.$proof->proof_file; ?>" width='100' />	
													<?php
													}elseif(in_array($file_ext, $doc_type)){
														?><a href='<?php echo ID_PROOF_PATH.$proof->proof_file;?>' target='_blank'>
														<img src="images/uploadimg/document_thumb.png" width='100' /> </a>
														<?php
													}elseif($file_ext==$pdf_type){
														?><a href='<?php echo ID_PROOF_PATH.$proof->proof_file;?>' target='_blank'>
														<img src="images/uploadimg/pdf_thumb.jpg" width='100' /> </a>
														<?php
													}
													?>
												</td>
												<td>
												
													<!--<button class="btn btn-warning"><?php //echo $proof_status; ?></button>-->
													
													
													<?php 
													
												
													
													 if ($proof->id_proof_status=='UnVerified' &&  $proof->decline_status=='Yes')  { ?>
														
														<button class="btn btn-warninge" type="button"  onclick="showUpload();"  id="newUpload" ><?php if($this->lang->line('upload_new_proof') != '') { echo stripslashes($this->lang->line('upload_new_proof')); } else echo "Upload New Proof";?> </button>	
														
														<span id="uploadNewProof">	</span>
														
													<?php } else if ($proof->id_proof_status=='OnRequest') { ?>
														<label id="request_id" ><?php if($this->lang->line('request_sent') != '') { echo stripslashes($this->lang->line('request_sent')); } else echo "Request Sent";?> </label>	
													<?php } else if ($proof->id_proof_status=='Verified'){ ?> 
														
														<!--<button class="btn btn-warninge" type="button" id="verified_id" ><?php// if($this->lang->line('Verified') != '') { echo stripslashes($this->lang->line('Verified')); } else echo "Verified";?> </button>--> 
														
														<label id="verified_id"><?php if($this->lang->line('Verified') != '') { echo stripslashes($this->lang->line('Verified')); } else echo "Verified";?> </label> 
														
														<br><br>
														
														<!--<button class="btn btn-warninge" type="button" id="decline_id" onclick="askEdit();" >Decline </button>-->
														
														
													<?php }    else if ($proof->id_proof_status=='UnVerified') { ?>
													
													<button class="btn btn-warninge" type="button" id="request_id"  > <?php if($this->lang->line('request_to_verify') != '') { echo stripslashes($this->lang->line('request_to_verify')); } else echo "Request to Verify";?> </button>
													
													<!-- onclick="sentRequest();"-->
													<?php } ?>
	
													
												</td>
												
												
							<!--	<td><p style='font-size:12px;'><?php //echo $proof->proof_comments; ?></p></td>-->
								
								
											</tr>
											<?php
										}
										
										?>

									</tbody>
								</table>
								
							</div>
						<?php 
						}
						
						/* else{
							
							if($this->lang->line('proof_not_found!') != '')
							{ 
								$proof_not_found = stripslashes($this->lang->line('proof_not_found!')); 
							} 
							else
							{
								$proof_not_found = "Proof not found!";
							}
							
							
							
								echo  "<p class='proofnotfound'>$proof_not_found</p>";
							} */
						?>
					
					
					
					
					<!-- <div id="head "-->
					<div id="proofUpload"  <?php if ($proofDetails->row()->decline_status=='Yes' && $proofDetails->row()->id_proof_status=='UnVerified') { echo  'style="display:none;"'; } else if ($proofDetails->row()->id_proof_status=='UnVerified' || $proofDetails->row()->id_proof_status=='OnRequest'  || $proofDetails->row()->id_proof_status=='Verified') { echo 'style="display:none;"'; }  ?> >
					
					<!-- id="head"-->
					<div id="head"  <?php   if ($proofDetails->row()->decline_status=='Yes' && $proofDetails->row()->id_proof_status=='UnVerified') { echo  'style="display:block;"'; } else if ($proofDetails->row()->id_proof_status=='UnVerified' || $proofDetails->row()->id_proof_status=='OnRequest'  || $proofDetails->row()->id_proof_status=='Verified') { echo 'style="display:none;"'; }  ?> >
				
					
						<h3 class="bold-verify"><?php if($this->lang->line('upload_your_documents') != '') { echo stripslashes($this->lang->line('upload_your_documents')); } else echo "Upload your Documents";?> (<?php if($this->lang->line('goverment_id') != '') { echo stripslashes($this->lang->line('goverment_id')); } else echo "Goverment Id";?>)</h3>	

						
							<div class="passport-verification" ><?php if($this->lang->line('upload_proof') != '') { echo stripslashes($this->lang->line('upload_proof')); } else echo "Upload the picture of your official id such as Passport or Voter ID";?></div>
							
							
							</div>
							
							
							<p class="msgverif"><?php echo $msg; ?></p>
							<p id= 'checkedValue'></p>
							<form action="site/user/upload_id_proof" method="POST" id='form_id' enctype="multipart/form-data" accept-charset="UTF-8">

							
								<ul id="listoption"  <?php   if ($proofDetails->row()->decline_status=='Yes') { 'style="display:block;"'; } else if ($proofDetails->row()->id_proof_status=='UnVerified' || $proofDetails->row()->id_proof_status=='OnRequest'  || $proofDetails->row()->id_proof_status=='Verified') { echo 'style="display:none;"'; }  ?> >
								
								
								<li>
									<label for= 'option1'>
									<img src="images/uploadimg/f1.png" alt="Passport" title="Passport">
									<div class="radiolbl-verification"><input type="radio" value="1" id="option1" name="option"  checked  required/>
									<span><?php if($this->lang->line('passport') != '') { echo stripslashes($this->lang->line('passport')); } else echo "Passport";?></span> </div>
									</label>
									
									
								</li>
								<li>
									<label for= 'option2'>
									<img src="images/uploadimg/f2.png" alt="Identity" title="Identity">
									<div class="radiolbl-verification">
									<input type="radio" value="2" id="option2" name="option" required/>
									<span><?php if($this->lang->line('voter_id') != '') { echo stripslashes($this->lang->line('voter_id')); } else echo "Voter ID";?></span>
									</div>
									</label>
								</li>
								<li>
									<label for= 'option3'>
									<img src="images/uploadimg/f3.png" alt="Driving Licence" title="Driving Licence">
									
									<div class="radiolbl-verification"><input type="radio" value="3" id="option3" name="option" required/><span><?php if($this->lang->line('driving_licence') != '') { echo stripslashes($this->lang->line('driving_licence')); } else echo "Driving Licence";?></span></div> </label>
									
									
								</li>
								</ul>
								<!--<input type="text" name="country" id="country" placeholder="Enter your country" required> --> 
								
								
										<div id="SubmitBtn" <?php   if ($proofDetails->row()->decline_status=='Yes') { 'style="display:block;"'; } else if ($proofDetails->row()->id_proof_status=='UnVerified' || $proofDetails->row()->id_proof_status=='OnRequest'  || $proofDetails->row()->id_proof_status=='Verified') { echo 'style="display:none;"'; }  ?> > 
								
								
								<div class="verification-uploadimg">
								<input type="file" name="proof_file" required id="proof_file"/>
							<b><?php if($this->lang->line('note') != '') { echo stripslashes($this->lang->line('note')); } else echo "Note";?> : </b>	<small><?php if($this->lang->line('err_upload_proof') != '') { echo stripslashes($this->lang->line('err_upload_proof')); } else echo "Please upload jpg,gif,png or pdf,doc file to verification, File size limit it 2 mb";?></small>
								<br><br>
								<b><?php if($this->lang->line('note') != '') { echo stripslashes($this->lang->line('note')); } else echo "Note";?> : </b> <small><?php if($this->lang->line('once_you_uploaded') != '') { echo stripslashes($this->lang->line('once_you_uploaded')); } else echo "Once You Upload Proof you cannot able to edit Until Admin Gives Acceptance";?> </small>
								
								</div>
								
								
								
								<div class="text-center col-sm-12" >	
									<button class="col-sm-offset-5 col-sm-2 btn btn-info blue" type="button" onclick="checkProofAvailability();"><?php if($this->lang->line('Submit') != '') { echo stripslashes($this->lang->line('Submit')); } else echo "Submit";?> </button>	
								</div>
								</div>
								
								
							</form>
							
							</div>
						
						
						
						
					</div>
				</div>
				<!-- malar 12/07/2017 - proof verification ends -->
				
				
	<!-- 
    <div class="box">
      <div class="middle">
			

         
         
  				<h1><?php echo $heading;?></h1>
               
        <div class="section notification_section" style="width:100%;">
					 
  	       <div id="div-form" style="border:1px solid #000;">
  		
         <p>Getting your Verified ID is the easiest way to help build trust in the Airbnb community.
		  We'll verify you by matching information from an online account to an official ID.</p>
		 <p>
      Or, you can choose to only add the verifications you want below.
       </p> 
	   <?php if($UserDetail->row()->is_verified=='Yes') {?>
	   <span style="color:green;">Verified</span>
	   <?php }else {?>
	   <a href="verification/send-mail">Verify Me</a>
	   <?php }?>
            
           </div> 
         </div>
		 
		 
		 <h1>Your Current Verification</h1>
		<?php if($UserDetail->row()->is_verified=='Yes') {?>
		 <div class="section notification_section" style="width:100%;">
					 
  	       <div id="div-form" style="border:1px solid #000;">
  		
         <p>You have confirmed your email:<?php echo $UserDetail->row()->email; ?>.  A confirmed email is important to allow us to securely communicate with you.

        </p>
	   <?php } ?>
	
            
           </div> 
         </div>script added 14/05/2014 -->			
			 
    <div class="clearfix"></div>
      </div>
	  </div>
    
  </div>
         
  </div>
    </div>
    </div>

<!---DASHBOARD-->
<!---FOOTER-->


<link rel="stylesheet" type="text/css" media="all" href="css/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.css" />

<!-- malar 12/07/2017 - proof varification starts -->

<script type="text/javascript">
	
function checkProofAvailability(){
	var choices = '';
	var els = document.getElementsByName('option');
	for (var i=0;i<els.length;i++){
	  if ( els[i].checked ) {
	    choices = els[i].value;
	  }
	}
	//$("#checkedValue").html(choices);

	$.ajax({
		type:'POST',
		url:'<?php echo base_url();?>site/user/checkUserProof',
		data:{proof_type:choices},
		success:function(response)
		{
			//alert(response); 
			if(response.trim()=='exist')
			{	//alert(response.trim()); 
			//	var r = confirm("Proof for this type is already submitted. Do you want rewrite the existing one? ");
			
			    if (confirm("<?php if($this->lang->line('rewrite_existing_one') != '') { echo stripslashes($this->lang->line('rewrite_existing_one')); } else echo "Proof for this type is already submitted. Do you want rewrite the existing one?";?> ")) {
			       allowfn();
			    } else {
			    	alert("<?php if($this->lang->line('choose_another_proof') != '') { echo stripslashes($this->lang->line('choose_another_proof')); } else echo "Please choose another proof type.";?>");
			        //rejectfn();
			     	
			    }

			
			}else {
				//alert(response);
				 //$("#checkedValue").html(choices);

			allowfn();
			}
		}
	});

	//return false;
}

function allowfn(){	


		if( document.getElementById("proof_file").files.length == 0 ){
			alert("<?php if($this->lang->line('choose_file') != '') { echo stripslashes($this->lang->line('choose_file')); } else echo "Please Choose File";?>");
			return false;
}else{
	
     if (confirm("<?php if($this->lang->line('request_to_admin') != '') { echo stripslashes($this->lang->line('request_to_admin')); } else echo "Are you sure want to send request to admin?";?>")) {
			$("#form_id").submit();
	 }else{
		  //window.location.reload();
	 }
	
}
	
}



</script>
<!-- malar 12/07/2017 - proof varification ends -->


<script type="text/javascript">

function sentRequest(){
	 if (confirm("Are you sure want to send request to admin?")) {
		 window.location.reload();
		 sentRequestConfirm();
	 }
}
function sentRequestConfirm(){
	var choices = document.querySelector('input[name="option"]:checked').value;
	var status="OnRequest";
	$.ajax({
		type:'POST',
		url:'<?php echo base_url();?>site/user/requestToAdmin',
		data:{status:status,proof_type:choices},
		success:function(data)
		{
			if (data=='Onreq'){
					//window.location.reload();
			}
			
		}
	});
	
	
}
</script>



<script type="text/javascript">
	/*jQuery(document).ready( function () {
		$(".datepicker").datepicker({ minDate:0, dateFormat: 'yy-mm-dd'});
	});*/
	
	
	

$(function() {
$( "#datefrom" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
minDate:0,
onClose: function( selectedDate ) {
$( "#expiredate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#expiredate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
minDate:0,
onClose: function( selectedDate ) {
$( "#datefrom" ).datepicker( "option", "maxDate", selectedDate );
}
});
});



$('#verify_sms').click(function()
{
var mobile_code=$('.pniw-number-prefix').text();
var phone_number=$('#phone_number').val();
if(phone_number =='')
{
alert('<?php if($this->lang->line('Please_Enter_Phone_Number') != '') { echo stripslashes($this->lang->line('Please_Enter_Phone_Number')); } else echo "Please Enter Phone Number";?>');
}
else if(isNaN(phone_number) || phone_number.length <8 || phone_number.length >10)
{
alert('<?php if($this->lang->line('Phone_Number_Should_be_Valid') != '') { echo stripslashes($this->lang->line('Phone_Number_Should_be_Valid')); } else echo "Phone Number Should be Valid";?>
');
}
else{
$.ajax({
type:'POST',
url:'<?php echo base_url();?>site/twilio/product_verification',
data:{phone_no:phone_number,mobile_code:mobile_code},
success:function(response)
{
	response=response.trim();
if(response=='success')
{
alert('<?php if($this->lang->line('We_Have_Sent_Verification_Code_to_Your_Mobile_Please_Enter_Verification_Code') != '') { echo stripslashes($this->lang->line('We_Have_Sent_Verification_Code_to_Your_Mobile_Please_Enter_Verification_Code')); } else echo "We Have Sent Verification Code to Your Mobile Please Enter Verification Code";?>');

$('.message_sent').text('<?php if($this->lang->line('We_sent_a_verification_code_to') != '') { echo stripslashes($this->lang->line('We_sent_a_verification_code_to')); } else echo "We sent a verification code to"; echo " ";?>'+phone_number);

 $('.verification_div').css('display','block');
}
}
});
}
});

function cancel_verification()
{
$('.verification_div').css('display','none');
}

function check_phpone_verification()
{
 mobile_verification_code=$('#mobile_verification_code').val();
$.ajax({
type:'POST',
url:'<?php echo base_url()?>site/product/check_phone_verification',
data:{mobile_verification_code:mobile_verification_code},
success:function(response)
{ 
response=response.trim();
if(response=='success')
{
window.location.reload(true);
}
else{
alert('<?php if($this->lang->line('Verification_Code_Does_not_match_Please_enter_Correct_Code') != '') { echo stripslashes($this->lang->line('Verification_Code_Does_not_match_Please_enter_Correct_Code')); } else echo "Verification Code Does not match Please enter Correct Code";?>');
}

}
}); 

}


function get_mobile_code(country_id)
{

 $.ajax({
type:'POST',
url:'<?php echo base_url();?>site/twilio/get_mobile_code',
data:{country_id:country_id},
dataType:'json',
success:function(response)
{
$('.pniw-number-prefix').text(response['country_mobile_code']);
}
});
}



</script>   

<!-- start - get admin country and display country and country code-->
<script type="text/javascript">
window.addEventListener('load',   
  function() { 
  var ad_country_code=$("#admin_country").val();
 $.ajax({
type:'POST',
url:'<?php echo base_url();?>site/twilio/get_mobile_code_default',
data:{country_id:ad_country_code},
dataType:'json',
success:function(response)
{
$('.pniw-number-prefix').text(response['country_mobile_code']);
}
});
 
  }, false);
</script>
<!-- end - get admin country and display country and country code-->

</script>
<script src="//connect.facebook.net/en_US/sdk.js"" type="text/javascript"></script> 
<script type="text/javascript">
FB.init({ 
       appId:'<?php echo APPKEY; ?>', 
      cookie: true,
          xfbml: true,
            version: 'v2.5',
          oauth: true
     });
function fb_login()
{ 
  console.log( 'fb_login function initiated' );
	  FB.login(function(response) {

      console.log( 'login response' );
      console.log( response );
      console.log( 'Response Status' + response.status );
		//top.location.href=<?php echo base_url('dashboard'); ?>;
      if (response.authResponse) {

        console.log( 'Auth success' );

    		FB.api("/me",'GET',{'fields':'id,email,verified,name'}, function(me){

      		if (me.id) {


            //console.log( 'Retrived user details from FB.api', me );

             var id = me.id; 
		var email = me.email;
            	var name = me.name;
                var live ='';
				if (me.hometown!= null)
				{			
					var live = me.hometown.name;
				}        
            	
    var passData = 'fid='+ id + '&email='+ email + '&name='+ name + '&live='+ live;
 //alert(passData);
            //console.log('data', passData);
          
            $.ajax({
             type: 'GET',
            data: passData,
			//data1:{ rUrl : "<?php echo $pageURL;?>" },
             //data: $.param(passData),
             global: false,
             url: '<?php echo base_url('site/invitefriend/facebook_connect');?>',
             success: function(responseText)
			 
			 			 
			 { 
              console.log( responseText ); 
			  //exit;
              //window.location.href = '<?php echo base_url('verification#!'); ?>';
			  location.reload('<?php echo base_url('verification#!'); ?>');
             },
             error: function(xhr,status,error){
               console.log(status, status.responseText);
             }
           }); 

        }else{

          console.log('There was a problem with FB.api', me);

        }
      });

    }else{
      console.log( 'Auth Failed' );
    }

  }, {scope: 'email'});
}
 
 </script>

<script>
	
function onLoadCallback()
{
    gapi.client.setApiKey('<?php echo GOOGLEKEY; ?>'); //set your API KEY
    gapi.client.load('plus', 'v1',function(){});//Load Google + API
}
function login() 
{
  var myParams = {
    'clientid' : '<?php echo GOOGLEKEY; ?>', //You need to set client id
    'cookiepolicy' : 'single_host_origin',
    'callback' : 'loginCallback', //callback function
    'approvalprompt':'force',
    'scope' : 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
  };
  gapi.auth.signIn(myParams);
  		   
}
function loginCallback(result)
{
    if(result['status']['signed_in'])
    {
		//alert("Login Success");
		//url: '<?php echo base_url('site/invitefriend/google_connects');?>',
		//location.reload('<?php echo base_url('verification#!'); ?>');
		
		  $.ajax({
		 type: 'GET',
             data: '',
             global: false,
             url: '<?php echo base_url('site/invitefriend/google_connects');?>',
             success: function(responseText){  
		//alert(responseText);
            location.reload('<?php echo base_url('verification#!'); ?>');
             }
            
           }); 
        var request = gapi.client.plus.people.get(
        {
            'userId': 'me'
        });
        request.execute(function (resp)
        {
            var email = '';
            if(resp['emails'])
            {
                for(i = 0; i < resp['emails'].length; i++)
                {
                    if(resp['emails'][i]['type'] == 'account')
                    {
                        email = resp['emails'][i]['value'];
                    }
                }
            }
 
            var str = "Name:" + resp['displayName'] + "<br>";
            str += "Image:" + resp['image']['url'] + "<br>";
            str += "<img src='" + resp['image']['url'] + "' /><br>";
 
            str += "URL:" + resp['url'] + "<br>";
            str += "Email:" + email + "<br>";
			
            //document.getElementById("profile").innerHTML = str;
			
        });
		
 
    }
 
}
</script>


<script type="text/javascript">
	function changePhone(){
		var confirm_change = confirm('<?php if($this->lang->line('Your_current_phone_number_is_verfied_actually_Are_you_sure_you_want_to_change_it?') != '') { echo stripslashes($this->lang->line('Your_current_phone_number_is_verfied_actually_Are_you_sure_you_want_to_change_it?')); } else echo "Your current phone number is verfied actually, Are you sure,you want to change it?";?>');
		if(confirm_change){
			$.ajax({
				type:'POST',
				url:'<?php echo base_url()?>site/user_settings/allow_changePhone',
				data:{data:'1'},
				success:function(response)
				{
					if(response.trim()=='success')
						window.location.reload();
					else 
						alert('<?php if($this->lang->line('sorry_Enable_to_change') != '') { echo stripslashes($this->lang->line('sorry_Enable_to_change')); } else echo "sorry.Enable to change.";?>');
				}
			});
		}else 
		alert('<?php if($this->lang->line('new_phone_number_cancelled') != '') { echo stripslashes($this->lang->line('new_phone_number_cancelled')); } else echo "new phone number cancelled";?>');
	}
</script> 



<script type="text/javascript">
function showUpload(){
	
	 if (confirm("<?php if($this->lang->line('upload_new_proof') != '') { echo stripslashes($this->lang->line('upload_new_proof')); } else echo "Are You Want to upload a new proof?"; ?>")) {
		   document.getElementById("proofUpload").style.display = "block";
		   document.getElementById("newUpload").style.display = "none";
		   $('#uploadNewProof').html('Upload New Proof');
		   
	 }else{
		 
	 }
}
</script>

<?php 

$this->load->view('site/templates/footer');
?>