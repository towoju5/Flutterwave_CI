<?php
$this->load->view('site/templates/header');
?>

<link rel="stylesheet" type="text/css" href="css/colorbox.css" media="all" />
<link href="css/page_inner.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/my-account.css" type="text/css" media="all"/>
<script type="text/javascript" src="js/site/SpryTabbedPanels.js"></script>


<script type="text/javascript" src="js/site/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="js/site/jquery.galleryview-3.0-dev.js"></script>
<!-- script added 14/05/2014 -->

<!-- script end -->

<!---DASHBOARD-->
<div class="dashboard yourlisting bgcolor profile-edit dasbsettgnwthm">

<div class="top-listing-head">
 <div class="main">  
 
       <!--  <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('header_dashboard') != '') { echo stripslashes($this->lang->line('header_dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></a></li>
                <li class="active"><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
				<li><a href="<?php echo base_url();?>invite"><?php if($this->lang->line('Invite') != '') { echo stripslashes($this->lang->line('Invite')); } else echo "Invite";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul> -->
			
			<!--main nav header -->
            <?php 
             $this->load->view('site/user/main_nav_header');  
            ?>
			
			
			</div></div>
	<div class="dash_brd">
    	<div id="command_center">
		<div class="lispg_top">	
		
        <div class="dashboard-sidemenu">
             <ul id="nav">
                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></a></li>
                <li class="active"><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
                <li ><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
				<li><a href="<?php echo base_url();?>invite"><?php if($this->lang->line('Invite') != '') { echo stripslashes($this->lang->line('Invite')); } else echo "Invite";?></a></li>
                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
            </ul> 
            <ul class="subnav">
                <li class="active"><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('EditProfile') != '') { echo stripslashes($this->lang->line('EditProfile')); } else echo "Edit Profile";?></a></li>
				<li ><a href="<?php echo base_url();?>photo-video"><?php if($this->lang->line('photos') != '') { echo stripslashes($this->lang->line('photos')); } else echo "Photos";?></a></li>
				<li ><a href="<?php echo base_url();?>verification"><?php if($this->lang->line('TrustandVerification') != '') { echo stripslashes($this->lang->line('TrustandVerification')); } else echo "Trust and Verification";?></a></li>
                <li ><a href="<?php echo base_url();?>display-review"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></a></li>
                <li ><a href="<?php echo base_url();?>display-dispute"><?php if($this->lang->line('Dispute') != '') { echo stripslashes($this->lang->line('Dispute')); } else echo "Dispute";?></a></li>
				<li > <a href="users/show/<?php echo $userDetails->row()->id; ?>"><?php if($this->lang->line('ViewProfile') != '') { echo stripslashes($this->lang->line('ViewProfile')); } else echo "View Profile";?></a> </li >
				 
				 
                          
            </ul>
			</div>
			
            	<div class="listiong-areas" id="account">
    <div class="box">
	
	
	<?php //echo "<pre>"; print_r($userDetails);die;   ?>
      <div class="middle">
			

         <!-- <h1>Mobile Notifications / Text Messages</h1>-->
         
  				<h1><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></h1>
               <!-- <form name="email_settings" method="post" action="site/user/update_notifications">-->
                 <div class="section notification_section" style="width:100%;">
					 
  	       <div id="div-form" style="border:1px solid #000;">
  		<form class="myform" id="profile_settings_form" method="post" action="site/user_settings/changePhoto" enctype="multipart/form-data" onSubmit="return profileUpdate();" accept-charset="UTF-8">
          <ul class="formul">
		 <!-- <?php if($userDetails->row()->group=='Seller')
		  {
			  
			  //echo 'Seller';
			  ?>
		   <li>
		  <label for="user"><?php if($this->lang->line('rep_code') != '') { echo stripslashes($this->lang->line('rep_code')); } else echo "Representative Code";?></label>
		  <?php if($userDetails->row()->rep_code!='')
		  {?>
            <input type="text" name="rep_code" id="rep_code" value="<?php if(!empty($userDetails)) echo $userDetails->row()->rep_code; ?>" readonly/>
		  <?php } else{?>
		  <input type="text" name="rep_code" id="rep_code" value="<?php if(!empty($userDetails)) echo $userDetails->row()->rep_code; ?>"/>
		  <?php } ?>
           </li>
		  <?php } else {} ?>-->
            <li>
		  <label class="my-edit-lbl" for="user" id="myformuserlabl"><?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "First Name";?>  <span style="color:#f00;">*</span> </label>
            <input required placeholder="Enter first name here" type="text" name="firstname" id="firstname" value="<?php if(!empty($userDetails)) echo $userDetails->row()->firstname; ?>" />
			
			
			
			<span id="first_name_error" style="color:#f00;display:none;">*<?php 
				if($this->lang->line('charecters_only') != '')
			{ 
				echo stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}
			?>!</span>
			
           </li> 
		   
		   <li>
            <label class="my-edit-lbl" for="emailaddress"><?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Last Name:";?> <span style="color:#f00;">*</span> </label>
            <input required placeholder="Enter last name here" type="text" id="lastname" name="lastname" value="<?php if(!empty($userDetails)) echo $userDetails->row()->lastname; ?>" />
			
		
			<span id="last_name_error" style="color:#f00;display:none;">*<?php 
				if($this->lang->line('charecters_only') != '')
			{ 
				echo stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}
			?>!</span>
			
			
            <div class="setting-empty-lbl col-sm-3"></div>
			<span class="tips-text"><?php if($this->lang->line('Thisisonlyshared') != '') { echo stripslashes($this->lang->line('Thisisonlyshared')); } else echo "This is only shared once you have a confirmed booking with another user.";?></span>
			</li> 
           
              <li>
            <label class="my-edit-lbl" for="emailaddress"><?php if($this->lang->line('IAm') != '') { echo stripslashes($this->lang->line('IAm')); } else echo "I Am";?>&nbsp;<span class="lock_ic"><i class="fa fa-lock" aria-hidden="true"></i></span>
			
			</label>
            <div class="gend-sel"><select class="gends" id="gender" name="gender">
			<option value="Male" <?php if(!empty($userDetails)){if($userDetails->row()->gender=='Male'){echo 'selected="selected"';}}?>><?php if($this->lang->line('Male') != '') { echo stripslashes($this->lang->line('Male')); } else echo "Male";?></option>
			<option value="Female" <?php if(!empty($userDetails)){if($userDetails->row()->gender=='Female'){echo 'selected="selected"';}}?>><?php if($this->lang->line('Female') != '') { echo stripslashes($this->lang->line('Female')); } else echo "Female";?></option>
			<option value="Unspecified" <?php if(!empty($userDetails)){if($userDetails->row()->gender=='Unspecified'){echo 'selected="selected"';}}?>><?php if($this->lang->line('unspecified') != '') { echo stripslashes($this->lang->line('unspecified')); } else echo "Unspecified";?></option>
			</select></div><div class="setting-empty-lbl col-sm-3"></div>
            <span class="tips-text"><?php if($this->lang->line('Weusethisdata') != '') { echo stripslashes($this->lang->line('Weusethisdata')); } else echo "We use this data for analysis and never share it with other users.";?></span>
			</li>              
			 <li>
            <label class="my-edit-lbl" for="emailaddress"><?php if($this->lang->line('BirthDate') != '') { echo stripslashes($this->lang->line('BirthDate')); } else echo "Birth Date";?>&nbsp;<span class="lock_ic"><i class="fa fa-lock" aria-hidden="true"></i></span>
			 <span style="color:#f00;">*</span>
			</label>
            <select required class="mnths" name="dob_month" id="user_birthdate_2i" class="valid">
			<option></option>
<option value="1" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='1'){echo 'selected="selected"';}}?> ><?php if($this->lang->line('back_January') != '') { echo stripslashes($this->lang->line('back_January')); } else echo "January"; ?></option>
<option value="2" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='2'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_February') != '') { echo stripslashes($this->lang->line('back_February')); } else echo "February"; ?></option>
<option value="3" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='3'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_March') != '') { echo stripslashes($this->lang->line('back_March')); } else echo "March"; ?></option>
<option value="4" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='4'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_April') != '') { echo stripslashes($this->lang->line('back_April')); } else echo "April"; ?></option>
<option value="5" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='5'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_May') != '') { echo stripslashes($this->lang->line('back_May')); } else echo "May"; ?></option>
<option value="6" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='6'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_June') != '') { echo stripslashes($this->lang->line('back_June')); } else echo "June"; ?></option>
<option value="7" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='7'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_July') != '') { echo stripslashes($this->lang->line('back_July')); } else echo "July"; ?></option>
<option value="8" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='8'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_August') != '') { echo stripslashes($this->lang->line('back_August')); } else echo "August"; ?></option>
<option value="9" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='9'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_September') != '') { echo stripslashes($this->lang->line('back_September')); } else echo "September"; ?></option>
<option value="10" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='10'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_October') != '') { echo stripslashes($this->lang->line('back_October')); } else echo "October"; ?></option>
<option value="11" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='11'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_November') != '') { echo stripslashes($this->lang->line('back_November')); } else echo "November"; ?></option>
<option value="12" <?php if(!empty($userDetails)){if($userDetails->row()->dob_month=='12'){echo 'selected="selected"';}}?>><?php if($this->lang->line('back_December') != '') { echo stripslashes($this->lang->line('back_December')); } else echo "December"; ?></option>
</select>


<select required class="mnths2" name="dob_date" id="user_birthdate_3i">
<option></option>
<?php
for($i=1;$i<=31;$i++){

echo '<option value="'.$i.'"'; 
if(!empty($userDetails)){if($userDetails->row()->dob_date==$i){echo 'selected="selected"';}}

echo '>'.$i.'</option>';
}


 ?>
</select>

 

<select required class="dob21" name="dob_year" id="user_birthdate_1i" class="valid">
<option></option>
<?php 
$current_year=date('Y')-5;
for($i=$current_year;$i > 1930;$i--){

echo '<option value="'.$i.'"'; 
if(!empty($userDetails)){if($userDetails->row()->dob_year==$i){echo 'selected="selected"';}}

echo '>'.$i.'</option>';
}
?>
</select>
<div class="setting-empty-lbl col-sm-3"></div>
<span class="tips-text"><?php if($this->lang->line('Themagicaldayou') != '') { echo stripslashes($this->lang->line('Themagicaldayou')); } else echo "The magical day you were dropped from the sky by a stork. We use this data for analysis and never share it with other users.";?></span>
     </li>          
            
           <!-- <input type="text" placeholder="mm/dd/yyyy" name="datefrom" id="datefrom" class="checkin ui-datepicker-target">-->
            
            <li>
             <label class="my-edit-lbl" for="emailaddress"><?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address";?>&nbsp;<span class="lock_ic"><i class="fa fa-lock" aria-hidden="true"></i></span></label>
            <input type="text" readonly name="email" value="<?php if(!empty($userDetails)) echo $userDetails->row()->email; ?>" /><div class="setting-empty-lbl col-sm-3"></div>
           <span class="tips-text"><?php if($this->lang->line('Thisisonlyshared') != '') { echo stripslashes($this->lang->line('Thisisonlyshared')); } else echo "This is only shared once you have a confirmed booking with another user.";?></span>
		   </li> 
			
			
			 <li>
             <label class="my-edit-lbl" for="emailaddress"><?php if($this->lang->line('paypal_emailid') != '') { echo stripslashes($this->lang->line('paypal_emailid')); } else echo "Paypal Email-ID";?>&nbsp;<span class="lock_ic"><i class="fa fa-lock" aria-hidden="true"></i></span></label>
            <input type="text" name="paypal_email" value="<?php if(!empty($userDetails)) echo $userDetails->row()->paypal_email; ?>" /><div class="setting-empty-lbl col-sm-3"></div>
		   </li> 
			
			<div style="display:none"> <!-- Its On Trust and verification Page-->
			 <li>
			 <label class="my-edit-lbl" for="emailaddress"><?php if($this->lang->line('PhoneNumber') != '') { echo stripslashes($this->lang->line('PhoneNumber')); } else echo "Phone Number";?>&nbsp;<span class="lock_ic"><i class="fa fa-lock" aria-hidden="true"></i></span></label>
			
			<?php if($userDetails->row()->ph_verified=='Yes'){?>
			 <input class="mobil-num" type="text" value="<?php echo $userDetails->row()->phone_no; ?>" disabled>
			 <?php /*
			 <span class="tips-text"><?php if($this->lang->line('PhoneNumberisVerified') != '') { echo stripslashes($this->lang->line('PhoneNumberisVerified')); } else echo "Phone Number is Verified"; ?>.</span>
			*/ ?>	
			<div class="setting-empty-lbl col-sm-3"></div>
			 <span class="tips-text verified-num">
			 	<a href="javascript:void(0);" onclick="changePhone();" rel="changePhone">
			    <?php if($this->lang->line('PhoneNumberisVerified') != '') { echo stripslashes($this->lang->line('PhoneNumberisVerified')); } else echo "Phone Number is Verified"; ?> 
			    </a>

			 </span>
			 <?php } else { ?> 

			
			<div class="phone-number-verify-widget" style="display: block;">
			<div class="pnaw-step1">
			<div id="phone-number-input-widget-64e0b448" class="phone-number-input-widget">
			<label class="phone-number-lbl" for="phone_country"><?php if($this->lang->line('Chooseacountry') != '') { echo stripslashes($this->lang->line('Chooseacountry')); } else echo "Choose a country";?>:</label>
			<div class="select">
			<select id="phone_country" name="phone_country" id='phone_country' onchange="get_mobile_code(this.value)">
			<option value="" ><?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?></option>
			<?php 
			foreach($active_countries->result() as $active_country) :?>
				<?php 
				if($userDetails->row()->ph_country!=''){
				?>
				<option value="<?php echo $active_country->id;?>" <?php if($userDetails->row()->ph_country == $active_country->id ){ echo "selected";} ?> ><?php echo $active_country->name;?></option>
				<?php } else {?>
				<option value="<?php echo $active_country->id;?>" <?php if(strtolower($active_country->name) == 'india'){ echo "selected";} ?> ><?php echo $active_country->name;?></option>
				<?php } ?>
			<?php endforeach;?>
			</select>
			</div>
			<label class="phone-number-lbl" for="phone_number"><?php if($this->lang->line('Addaphonenumber') != '') { echo stripslashes($this->lang->line('Addaphonenumber')); } else echo "Add a phone number";?>:</label>
			<div class="pniw-number-container clearfix">
			<div class="pniw-number-prefix">+91</div>
			<input id="phone_number" name="phone_no" class="pniw-number phnonwthm" type="text" value="<?php if(!empty($userDetails)) echo $userDetails->row()->phone_no; ?>" placeholder="Enter mobile number here">
			</div>
			</div>
			<div class="pnaw-verify-container">
			<a class="btn btn-primary" rel="sms" href="javascript:void(0);" id="verify_sms"><?php if($this->lang->line('VerifyviaSMS') != '') { echo stripslashes($this->lang->line('VerifyviaSMS')); } else echo "Verify via SMS";?></a>
			<a class="btn btn-primary" rel="call" href="#"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?><?php if($this->lang->line('Verify via Call') != '') { echo stripslashes($this->lang->line('Verify via Call')); } else echo "Verify via Call";?></a>
			<a class="why-verify" target="_blank" href="pages/why-verify" style="display:none;"><?php if($this->lang->line('WhyVerify') != '') { echo stripslashes($this->lang->line('WhyVerify')); } else echo "Why Verify?";?></a>
			</div>
			</div>
			</div>
			
			<div class="phone-number-verify-widget verification_div" style="display: none;">
    <p class="message message_sent"></p>
    <label for="phone_number_verification"><?php if($this->lang->line('Pleaseenterthe') != '') { echo stripslashes($this->lang->line('Pleaseenterthe')); } else echo "Please enter the 4-digit code";?>:</label>
    <input type="text" id="mobile_verification_code">
     <a href="javascript:void(0);" onclick="check_phpone_verification()" rel="verify">
        <?php if($this->lang->line('Verify') != '') { echo stripslashes($this->lang->line('Verify')); } else echo "Verify";?>
      </a>
      <a href="javascript:void(0);" onclick="cancel_verification();">
       <?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel";?> 
      </a>
    
    <p class="arrive"><?php if($this->lang->line('Ifitdoesnt') != '') { echo stripslashes($this->lang->line('Ifitdoesnt')); } else echo "If it doesn't arrive, click cancel and try call verification instead.";?></p>
  
			</div>

           <div class="setting-empty-lbl col-sm-3"></div>
           <span class="tips-text"><?php if($this->lang->line('Thisisonlysharedonce') != '') { echo stripslashes($this->lang->line('Thisisonlysharedonce')); } else echo "This is only shared once you have a confirmed booking with another user. This is how we can all get in touch.";?></span>
		   <?php }?>
		   </li> 
		   
		   </div>
			
			
			
			 <li>
            <label class="my-edit-lbl" for="emailaddress"><?php if($this->lang->line('WhereYouLive') != '') { echo stripslashes($this->lang->line('WhereYouLive')); } else echo "Where You Live";?>:  <span style="color:#f00;">*</span> </label>
            <input type="text" required name="s_city"  id="s_city" value="<?php if(!empty($userDetails)) echo $userDetails->row()->s_city; ?>" placeholder="<?php if($this->lang->line('enter_living_place') != '') { echo stripslashes($this->lang->line('enter_living_place')); } else echo "Enter your living place here";?>" /><br />
            </li> 
			
			
			<span id="s_city_error" style="color:#f00;display:none; margin-left: 230px;">*<?php 
				if($this->lang->line('charecters_only') != '')
			{ 
				echo stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}
			?>!</span>
			
			
			 <li>
            <label class="my-edit-lbl" for="comments"><?php if($this->lang->line('DescribeYourself') != '') { echo stripslashes($this->lang->line('DescribeYourself')); } else echo "DescribeYourself";?>:</label>
			<textarea name="description" id="description" placeholder="<?php if($this->lang->line('write_something_about_ourself') != '') { echo stripslashes($this->lang->line('write_something_about_ourself')); } else echo "Write something about yourself";?>"><?php if(!empty($userDetails)) echo $userDetails->row()->description; ?></textarea>
			
			<span id="description_error" style="color:#f00;display:none; margin-left: 230px;">*<?php 
				if($this->lang->line('charecters_only') != '')
			{ 
				echo stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}
			?>!</span>
			
			
			<div class="setting-empty-lbl col-sm-3"></div>
			<span class="tips-text"><div class="text-muted row-space-top-1">


<p>
<?php if($this->lang->line('We built on relationships. Help other people get to know you.') != '') { echo stripslashes($this->lang->line('We built on relationships. Help other people get to know you.')); } else echo "We built the relationships. Help other people get to know you.";?>
</p>
<p>
<?php if($this->lang->line('Tellthemabout') != '') { echo stripslashes($this->lang->line('Tellthemabout')); } else echo "Tell them about the things you like: What are 5 things you can’t live without? Share your favorite travel destinations, books, movies, shows, music, food.";?>
</p>
<p>
<?php if($this->lang->line('Tellthemwhat') != '') { echo stripslashes($this->lang->line('Tellthemwhat')); } else echo "Tell them what it’s like to have you as a guest or host: What’s your style traveling? hosting?";?>
</p>
<p>
<?php if($this->lang->line('Dyouhave') != '') { echo stripslashes($this->lang->line('Dyouhave')); } else echo "Tell them about you: Do you have a life motto?";?></p>
</div></span>
            </li> 
			
			
			
        
        </div> <!-- form befor div closed -->
					
  	       
  			 
          </div>
		   
    
      </div>
    </div>
	
	
	
	
	
	 <div class="box">
	
	
	
      <div class="middle">
			

         <!-- <h1>Mobile Notifications / Text Messages</h1>-->
         
  				<h1><?php if($this->lang->line('Optional') != '') { echo stripslashes($this->lang->line('Optional')); } else echo "Optional";?></h1>
               <!-- <form name="email_settings" method="post" action="site/user/update_notifications">-->
                 <div class="section notification_section" style="width:100%;">
					 
  	       <div id="div-form" style="border:1px solid #000;">
  		
          <ul class="bottom-edit">
          
			
			
			
			 <li>
            <label class="my-edit-lbl" for="school"><?php if($this->lang->line('School') != '') { echo stripslashes($this->lang->line('School')); } else echo "School";?></label>
			<input type="text" name="school" placeholder="<?php if($this->lang->line('where_did_your_schooling') != '') { echo stripslashes($this->lang->line('where_did_your_schooling')); } else echo "Where did your schooling";?>" value="<?php if(!empty($userDetails)) echo $userDetails->row()->school; ?>" /><br />
            
			</li>
			
			
			<li>
            <label class="my-edit-lbl" for="work"><?php if($this->lang->line('Work') != '') { echo stripslashes($this->lang->line('Work')); } else echo "Work";?></label>
			<input type="text" name="work" placeholder="<?php if($this->lang->line('your_working_place') != '') { echo stripslashes($this->lang->line('your_working_place')); } else echo "Your working place";?>" value="<?php if(!empty($userDetails)) echo $userDetails->row()->work; ?>" /><br />
            </li> 
			
			
			<li>
<label class="my-edit-lbl" for="timezone" ><?php if($this->lang->line('TimeZone') != '') { echo stripslashes($this->lang->line('TimeZone')); } else echo "Time Zone";?></label>


<select name="timezone"  id="user_preference_time_zone">
<option value=""><?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?></option>
<option value="International Date Line West" <?php if($userDetails->row()->timezone=='International Date Line West'){?>selected="selected"<?php }?>>(GMT-11:00) International Date Line West</option>
<option value="Midway Island" <?php if($userDetails->row()->timezone=='Midway Island'){?>selected="selected"<?php }?>>(GMT-11:00) Midway Island</option>
<option value="Samoa" <?php if($userDetails->row()->timezone=='Samoa'){?>selected="selected"<?php }?>>(GMT-11:00) Samoa</option>
<option value="Hawaii" <?php if($userDetails->row()->timezone=='Hawaii'){?>selected="selected"<?php }?>>(GMT-10:00) Hawaii</option>
<option value="Alaska" <?php if($userDetails->row()->timezone=='Alaska'){?>selected="selected"<?php }?>>(GMT-09:00) Alaska</option>
<option value="America/Los_Angeles" <?php if($userDetails->row()->timezone=='America/Los_Angeles'){?>selected="selected"<?php }?>>(GMT-08:00) America/Los_Angeles</option>
<option value="Pacific Time (US &amp; Canada)" <?php if($userDetails->row()->timezone=='Pacific Time (US & Canada)'){?>selected="selected"<?php }?>>(GMT-08:00) Pacific Time (US &amp; Canada)</option>
<option value="Tijuana" <?php if($userDetails->row()->timezone=='Tijuana'){?>selected="selected"<?php }?>>(GMT-08:00) Tijuana</option>
<option value="Arizona" <?php if($userDetails->row()->timezone=='Arizona'){?>selected="selected"<?php }?>>(GMT-07:00) Arizona</option>
<option value="Chihuahua" <?php if($userDetails->row()->timezone=='Chihuahua'){?>selected="selected"<?php }?>>(GMT-07:00) Chihuahua</option>
<option value="Mazatlan" <?php if($userDetails->row()->timezone=='Mazatlan'){?>selected="selected"<?php }?>>(GMT-07:00) Mazatlan</option>
<option value="Mountain Time (US &amp; Canada)" <?php if($userDetails->row()->timezone=='Mountain Time (US & Canada)'){?>selected="selected"<?php }?>>(GMT-07:00) Mountain Time (US &amp; Canada)</option>
<option value="Central America" <?php if($userDetails->row()->timezone=='Central America'){?>selected="selected"<?php }?>>(GMT-06:00) Central America</option>
<option value="Central Time (US &amp; Canada)" <?php if($userDetails->row()->timezone=='Central Time (US & Canada)'){?>selected="selected"<?php }?>>(GMT-06:00) Central Time (US &amp; Canada)</option>
<option value="Guadalajara" <?php if($userDetails->row()->timezone=='Guadalajara'){?>selected="selected"<?php }?>>(GMT-06:00) Guadalajara</option>
<option value="Mexico City" <?php if($userDetails->row()->timezone=='Mexico City'){?>selected="selected"<?php }?>>(GMT-06:00) Mexico City</option>
<option value="Monterrey" <?php if($userDetails->row()->timezone=='Monterrey'){?>selected="selected"<?php }?>>(GMT-06:00) Monterrey</option>
<option value="Saskatchewan" <?php if($userDetails->row()->timezone=='Saskatchewan'){?>selected="selected"<?php }?>>(GMT-06:00) Saskatchewan</option>
<option value="America/Montreal" <?php if($userDetails->row()->timezone=='America/Montreal'){?>selected="selected"<?php }?>>(GMT-05:00) America/Montreal</option>
<option value="America/New_York" <?php if($userDetails->row()->timezone=='America/New_York'){?>selected="selected"<?php }?>>(GMT-05:00) America/New_York</option>
<option value="America/Toronto" <?php if($userDetails->row()->timezone=='America/Toronto'){?>selected="selected"<?php }?>>(GMT-05:00) America/Toronto</option>
<option value="Bogota" <?php if($userDetails->row()->timezone=='Bogota'){?>selected="selected"<?php }?>>(GMT-05:00) Bogota</option>
<option value="Eastern Time (US &amp; Canada)" <?php if($userDetails->row()->timezone=='Eastern Time (US & Canada)'){?>selected="selected"<?php }?>>(GMT-05:00) Eastern Time (US &amp; Canada)</option>
<option value="Indiana (East)" <?php if($userDetails->row()->timezone=='ndiana (East)'){?>selected="selected"<?php }?>>(GMT-05:00) Indiana (East)</option>
<option value="Lima" <?php if($userDetails->row()->timezone=='Lima'){?>selected="selected"<?php }?>>(GMT-05:00) Lima</option>
<option value="Quito" <?php if($userDetails->row()->timezone=='Quito'){?>selected="selected"<?php }?>>(GMT-05:00) Quito</option>
<option value="Caracas" <?php if($userDetails->row()->timezone=='Caracas'){?>selected="selected"<?php }?>>(GMT-04:30) Caracas</option>
<option value="Atlantic Time (Canada)" <?php if($userDetails->row()->timezone=='Atlantic Time (Canada)'){?>selected="selected"<?php }?>>(GMT-04:00) Atlantic Time (Canada)</option>
<option value="Georgetown" <?php if($userDetails->row()->timezone=='Georgetown'){?>selected="selected"<?php }?>>(GMT-04:00) Georgetown</option>
<option value="La Paz" <?php if($userDetails->row()->timezone=='La Paz'){?>selected="selected"<?php }?>>(GMT-04:00) La Paz</option>
<option value="Santiago" <?php if($userDetails->row()->timezone=='Santiago'){?>selected="selected"<?php }?>>(GMT-04:00) Santiago</option>
<option value="Newfoundland" <?php if($userDetails->row()->timezone=='Newfoundland'){?>selected="selected"<?php }?>>(GMT-03:30) Newfoundland</option>
<option value="Brasilia" <?php if($userDetails->row()->timezone=='Brasilia'){?>selected="selected"<?php }?>>(GMT-03:00) Brasilia</option>
<option value="Buenos Aires" <?php if($userDetails->row()->timezone=='Buenos Aires'){?>selected="selected"<?php }?>>(GMT-03:00) Buenos Aires</option>
<option value="Greenland" <?php if($userDetails->row()->timezone=='Greenland'){?>selected="selected"<?php }?>>(GMT-03:00) Greenland</option>
<option value="Mid-Atlantic" <?php if($userDetails->row()->timezone=='Mid-Atlantic'){?>selected="selected"<?php }?>>(GMT-02:00) Mid-Atlantic</option>
<option value="Azores" <?php if($userDetails->row()->timezone=='Azores'){?>selected="selected"<?php }?>>(GMT-01:00) Azores</option>
<option value="Cape Verde Is." <?php if($userDetails->row()->timezone=='Cape Verde Is.'){?>selected="selected"<?php }?>>(GMT-01:00) Cape Verde Is.</option>
<option value="Casablanca" <?php if($userDetails->row()->timezone=='Casablanca'){?>selected="selected"<?php }?>>(GMT+00:00) Casablanca</option>
<option value="Dublin" <?php if($userDetails->row()->timezone=='Dublin'){?>selected="selected"<?php }?>>(GMT+00:00) Dublin</option>
<option value="Edinburgh" <?php if($userDetails->row()->timezone=='Edinburgh'){?>selected="selected"<?php }?>>(GMT+00:00) Edinburgh</option>
<option value="Lisbon" <?php if($userDetails->row()->timezone=='Lisbon'){?>selected="selected"<?php }?>>(GMT+00:00) Lisbon</option>
<option value="London" <?php if($userDetails->row()->timezone=='London'){?>selected="selected"<?php }?>>(GMT+00:00) London</option>
<option value="Monrovia" <?php if($userDetails->row()->timezone=='Monrovia'){?>selected="selected"<?php }?>>(GMT+00:00) Monrovia</option>
<option value="UTC" <?php if($userDetails->row()->timezone=='UTC'){?>selected="selected"<?php }?>>(GMT+00:00) UTC</option>
<option value="Amsterdam" <?php if($userDetails->row()->timezone=='Amsterdam'){?>selected="selected"<?php }?>>(GMT+01:00) Amsterdam</option>
<option value="Belgrade" <?php if($userDetails->row()->timezone=='Belgrade'){?>selected="selected"<?php }?>>(GMT+01:00) Belgrade</option>
<option value="Berlin" <?php if($userDetails->row()->timezone=='Berlin'){?>selected="selected"<?php }?>>(GMT+01:00) Berlin</option>
<option value="Bern" <?php if($userDetails->row()->timezone=='Bern'){?>selected="selected"<?php }?>>(GMT+01:00) Bern</option>
<option value="Bratislava" <?php if($userDetails->row()->timezone=='Bratislava'){?>selected="selected"<?php }?>>(GMT+01:00) Bratislava</option>
<option value="Brussels" <?php if($userDetails->row()->timezone=='Brussels'){?>selected="selected"<?php }?>>(GMT+01:00) Brussels</option>
<option value="Budapest" <?php if($userDetails->row()->timezone=='Budapest'){?>selected="selected"<?php }?>>(GMT+01:00) Budapest</option>
<option value="Copenhagen" <?php if($userDetails->row()->timezone=='Copenhagen'){?>selected="selected"<?php }?>>(GMT+01:00) Copenhagen</option>
<option value="Europe/Amsterdam" <?php if($userDetails->row()->timezone=='Europe/Amsterdam'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Amsterdam</option>
<option value="Europe/Berlin" <?php if($userDetails->row()->timezone=='Europe/Berlin'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Berlin</option>
<option value="Europe/Copenhagen" <?php if($userDetails->row()->timezone=='Europe/Copenhagen'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Copenhagen</option>
<option value="Europe/Madrid" <?php if($userDetails->row()->timezone=='Europe/Madrid'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Madrid</option>
<option value="Europe/Paris" <?php if($userDetails->row()->timezone=='Europe/Paris'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Paris</option>
<option value="Europe/Rome" <?php if($userDetails->row()->timezone=='Europe/Rome'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Rome</option>
<option value="Europe/Zagreb" <?php if($userDetails->row()->timezone=='Europe/Zagreb'){?>selected="selected"<?php }?>>(GMT+01:00) Europe/Zagreb</option>
<option value="Ljubljana" <?php if($userDetails->row()->timezone=='Ljubljana'){?>selected="selected"<?php }?>>(GMT+01:00) Ljubljana</option>
<option value="Madrid" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Madrid</option>
<option value="Paris" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Paris</option>
<option value="Prague" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Prague</option>
<option value="Rome" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Rome</option>
<option value="Sarajevo" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Sarajevo</option>
<option value="Skopje" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Skopje</option>
<option value="Stockholm" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Stockholm</option>
<option value="Vienna" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Vienna</option>
<option value="Warsaw" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Warsaw</option>
<option value="West Central Africa" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) West Central Africa</option>
<option value="Zagreb" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+01:00) Zagreb</option>
<option value="Asia/Jerusalem" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Asia/Jerusalem</option>
<option value="Athens" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Athens</option>
<option value="Bucharest" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Bucharest</option>
<option value="Cairo" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Cairo</option>
<option value="Harare" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Harare</option>
<option value="Helsinki" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Helsinki</option>
<option value="Istanbul" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Istanbul</option>
<option value="Jerusalem" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Jerusalem</option>
<option value="Kyiv" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Kyiv</option>
<option value="Pretoria" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Pretoria</option>
<option value="Riga" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Riga</option>
<option value="Sofia" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Sofia</option>
<option value="Tallinn" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Tallinn</option>
<option value="Vilnius" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+02:00) Vilnius</option>
<option value="Baghdad" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:00) Baghdad</option>
<option value="Kuwait" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:00) Kuwait</option>
<option value="Minsk" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:00) Minsk</option>
<option value="Nairobi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:00) Nairobi</option>
<option value="Riyadh" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:00) Riyadh</option>
<option value="Tehran" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+03:30) Tehran</option>
<option value="Abu Dhabi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Abu Dhabi</option>
<option value="Baku" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Baku</option>
<option value="Moscow" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Moscow</option>
<option value="Muscat" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Muscat</option>
<option value="St. Petersburg" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) St. Petersburg</option>
<option value="Tbilisi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Tbilisi</option>
<option value="Volgograd" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Volgograd</option>
<option value="Yerevan" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:00) Yerevan</option>
<option value="Kabul" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+04:30) Kabul</option>
<option value="Islamabad" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:00) Islamabad</option>
<option value="Karachi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:00) Karachi</option>
<option value="Tashkent" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:00) Tashkent</option>
<option value="Chennai" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:30) Chennai</option>
<option value="Kolkata" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:30) Kolkata</option>
<option value="Mumbai" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:30) Mumbai</option>
<option value="New Delhi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:30) New Delhi</option>
<option value="Sri Jayawardenepura" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:30) Sri Jayawardenepura</option>
<option value="Kathmandu" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+05:45) Kathmandu</option>
<option value="Almaty" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+06:00) Almaty</option>
<option value="Astana" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+06:00) Astana</option>
<option value="Dhaka" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+06:00) Dhaka</option>
<option value="Ekaterinburg" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+06:00) Ekaterinburg</option>
<option value="Rangoon" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+06:30) Rangoon</option>
<option value="Bangkok" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+07:00) Bangkok</option>
<option value="Hanoi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+07:00) Hanoi</option>
<option value="Jakarta" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+07:00) Jakarta</option>
<option value="Novosibirsk" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+07:00) Novosibirsk</option>
<option value="Asia/Makassar" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Asia/Makassar</option>
<option value="Beijing" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Beijing</option>
<option value="Chongqing" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Chongqing</option>
<option value="Hong Kong" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Hong Kong</option>
<option value="Krasnoyarsk" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Krasnoyarsk</option>
<option value="Kuala Lumpur" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Kuala Lumpur</option>
<option value="Perth" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Perth</option>
<option value="Singapore" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Singapore</option>
<option value="Taipei" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Taipei</option>
<option value="Ulaan Bataar" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Ulaan Bataar</option>
<option value="Urumqi" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+08:00) Urumqi</option>
<option value="Irkutsk" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:00) Irkutsk</option>
<option value="Osaka" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:00) Osaka</option>
<option value="Sapporo" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:00) Sapporo</option>
<option value="Seoul" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:00) Seoul</option>
<option value="Tokyo" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:00) Tokyo</option>
<option value="Adelaide" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:30) Adelaide</option>
<option value="Darwin" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+09:30) Darwin</option>
<option value="Brisbane" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Brisbane</option>

<option value="Canberra" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Canberra</option>
<option value="Guam" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Guam</option>
<option value="Hobart" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Hobart</option>
<option value="Melbourne" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Melbourne</option>
<option value="Port Moresby" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Port Moresby</option>
<option value="Sydney" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Sydney</option>
<option value="Yakutsk" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+10:00) Yakutsk</option>
<option value="New Caledonia" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+11:00) New Caledonia</option>
<option value="Vladivostok" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+11:00) Vladivostok</option>
<option value="Auckland" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Auckland</option>
<option value="Fiji" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Fiji</option>
<option value="Kamchatka" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Kamchatka</option>
<option value="Magadan" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Magadan</option>
<option value="Marshall Is." <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Marshall Is.</option>
<option value="Solomon Is." <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Solomon Is.</option>
<option value="Wellington" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+12:00) Wellington</option>
<option value="Nuku'alofa" <?php if($userDetails->row()->timezone=='cvvdf'){?>selected="selected"<?php }?>>(GMT+13:00) Nuku'alofa</option></select>




<div class="setting-empty-lbl col-sm-3"></div>
<span class="tips-text"><?php if($this->lang->line('Yourhometime') != '') { echo stripslashes($this->lang->line('Yourhometime')); } else echo "Your home time zone.";?></span>

</li>

<li>

<label class="my-edit-lbl" for="emailaddress"></label>


<span class="no-numbr">
<ul>

<!--<li><?php // if($this->lang->line('None') != '') { echo stripslashes($this->lang->line('None')); } else echo "None";?> </li>-->


<li><a  data-toggle="modal" href="#myModal"  class="multiselect-add-more"><i class="fa fa-plus"></i> <?php if($this->lang->line('AddMore') != '') { echo stripslashes($this->lang->line('AddMore')); } else echo "Add More";?></a></li>
<li><span style="width:100%; float:left" ><?php if($this->lang->line('Addlanguages') != '') { echo stripslashes($this->lang->line('Addlanguages')); } else echo "Add languages you speak.";?></span></li>
</ul>

</span>

<div id="parentDiv">
<?php 
$languages_known_user=explode(',',$userDetails->row()->languages_known);
if(count($languages_known_user)>0)
{ ?>
<ul class="inner_language">
<?php
foreach($languages_known->result() as $language){
if(in_array($language->language_code,$languages_known_user)) { ?>
<li id="<?php echo $language->language_code; ?>"><?php echo $language->language_name;?><small>
<a class="text-normal" href="javascript:void(0);" onclick="delete_languages(this,'<?php echo $language->language_code; ?>')">x</a>
</small></li>
<?php } }?>
</ul>
<?php } ?>
</div>



</li>




</ul>

<div class="setting_svbtn">
<button class="btn btn-primary blue" type="submit"><?php if($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save";?> </button>
</div>
		
  	       
  			 
          </div>
				</form>    
    <div class="clearfix"></div>
      </div>
    </div>
	
	
  </div>
         
  </div>
   </div>
    </div>
</div>
<!---DASHBOARD-->
<!---FOOTER-->

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.css" />
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

/* $(function() {
$( "#datepicker" ).datepicker();
});*/
</script>

		<div id="myModal" class="modal fade in profilepage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		      
		<div class="panel-header">
		<a class="close" aria-hidden="true" data-dismiss="modal" type="button"><i class="fa fa-times" aria-hidden="true"></i>
</a>
		<?php if($this->lang->line('SpokenLanguages') != '') { echo stripslashes($this->lang->line('SpokenLanguages')); } else echo "Spoken Languages";?>
		</div>
		<div class="panel-body">
		<p><?php if($this->lang->line('Whatlanguages') != '') { echo stripslashes($this->lang->line('Whatlanguages')); } else echo "What languages can you speak fluently? We have many international travelers who appreciate hosts who can speak their language.";?></p>
		<div class="row-fluid row">
		<div class="span6 col-6">
		<?php $languages_knowns=explode(',',$userDetails->row()->languages_known);?>
		<?php $i = 1;foreach($languages_known->result() as $language){ if($i%2 == 1) {?>
          <li>
            <input type="checkbox" <?php if(in_array($language->language_code,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]" value="<?php echo $language->language_code;?>"
			alt="<?php echo $language->language_name;?>">
           <label><?php echo $language->language_name;?></label>
          </li>
		  <?php } $i++; } ?>
        </div>
		<div class="span6 col-6">
		<?php $languages_knowns=explode(',',$userDetails->row()->languages_known);?>
		<?php $i = 1;foreach($languages_known->result() as $language){ if($i%2 == 0) {?>
          <li>
            <input type="checkbox" <?php if(in_array($language->language_code,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]" value="<?php echo $language->language_code?>"
			alt="<?php echo $language->language_name?>">
           <label><?php echo $language->language_name?></label>
          </li>
		  <?php } $i++; } ?>
        </div>
		</div>
		</div>
		
		<div class="panel-footer language-popup">
		
		<button class="btn btn-primary"  data-dismiss="modal" type="button" id="language_ajax"> <?php if($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save";?> </button>
		<a class="btn btn-default pull-left" data-dismiss="modal" type="button"><?php if($this->lang->line('Close') != '') { echo stripslashes($this->lang->line('Close')); } else echo "Close";?></a>
		
		</div>
		
		
</div><!-- /.modal -->
<script type="text/javascript">
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
//alert(response);
}
});
}
$('.toggle').click(function()
{
$('.emergncy-hide').slideToggle('slow');
});

$('#verify_sms').click(function()
{
var mobile_code=$('.pniw-number-prefix').text();
var phone_number=$('#phone_number').val();
var phone_country = $("#phone_country").val();

if(phone_number =='')
{
alert('<?php if($this->lang->line('Please_Enter_Phone_Number') != '') { echo stripslashes($this->lang->line('Please_Enter_Phone_Number')); } else echo "Please Enter Phone Number";?>');
}
else if(isNaN(phone_number) || phone_number.length < 9)
{
alert('<?php if($this->lang->line('Phone_Number_Should_be_10_Digit_Number') != '') { echo stripslashes($this->lang->line('Phone_Number_Should_be_10_Digit_Number')); } else echo "Phone Number Should be 10 Digit Number";?>');
}
else{
$.ajax({
type:'POST',
url:'<?php echo base_url();?>site/twilio/product_verification',
data:{phone_no:phone_number,mobile_code:mobile_code,ph_country:phone_country},
success:function(response)
{
if(response.trim()=='success')
{
alert('<?php if($this->lang->line('We_Have_Sent_Verification_Code_to_Your_Mobile_Please_Enter_Verification_Code') != '') { echo stripslashes($this->lang->line('We_Have_Sent_Verification_Code_to_Your_Mobile_Please_Enter_Verification_Code')); } else echo "We Have Sent Verification Code to Your Mobile Please Enter Verification Code";?>');

$('.message_sent').text('<?php if($this->lang->line('We_sent_a_verification_code_to') != '') { echo stripslashes($this->lang->line('We_sent_a_verification_code_to')); } else echo "We sent a verification code to";?>'+phone_number);


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
if(response.trim()=='success')
{
window.location.reload(true);
}
else{
alert('<?php if($this->lang->line('Verification_Code_Does_not_match_Please_enter_Correct_Code') != '') { echo stripslashes($this->lang->line('Verification_Code_Does_not_match_Please_enter_Correct_Code')); } else echo "Verification Code Does not match Please enter Correct Code";?>');
}

}
}); 

}


$(function()
{

$('#language_ajax').click(function()
{

var languages=document.getElementsByName('languages[]');

var languages_known=new Array();
for(var i=0;i<languages.length;i++)
{
if($(languages[i]).is(':checked'))
{
languages_known.push(languages[i].value);
}
}

if(languages_known.length>0)
{

$.ajax({
type:'POST',
url:'<?php echo base_url()?>site/user_settings/update_languages',
data:{languages_known:languages_known},
success:function(response)
{

	$('.inner_language').html(response.trim());
	
}
});

}
})
});

function delete_languages(elem,language_code)
{
	
	
$.ajax({
type:'POST',
url:'<?php echo base_url()?>site/user_settings/delete_languages',
data:{language_code:language_code},
dataType:'json',
success:function(response)
{
if(response['status_code']==1)
{
$(elem).closest('li').remove();
//window.location.reload(true);
}
}
});
}



</script>  
<!-- Malar - change Phone number -1-7-2017 -->
<script type="text/javascript">
	function changePhone(){
		var confirm_change = confirm('<?php if($this->lang->line('Your_current_phone_number_is_verfied_actually_Are_you_sure_you_want_to_change_it?') != '') { echo stripslashes($this->lang->line('Your_current_phone_number_is_verfied_actually_Are_you_sure_you_want_to_change_it?')); } else echo "Your current phone number is verfied actually, Are you sure,you want to change it?";?>');
		if(confirm_change){

			//alert('change phone');

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
<!-- malar - change phone number Ends -->

<script>

$("#firstname").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("first_name_error").style.display = "inline";
  $("#firstname").focus();
  $("#first_name_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});


$("#lastname").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("last_name_error").style.display = "inline";
  $("#lastname").focus();
  $("#last_name_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});

$("#s_city").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("s_city_error").style.display = "inline";
  $("#s_city").focus();
  $("#s_city_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});

$("#description").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("description_error").style.display = "inline";
  $("#description").focus();
  $("#description_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});


</script>
<?php 
$this->load->view('site/templates/footer');
?>