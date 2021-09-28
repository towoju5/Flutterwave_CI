<?php $this->load->view('site/templates/header');?>

<div class="dashboard yourlisting bgcolor profile-edit invitbnrpg">

<div class="top-listing-head">

 <div class="main"> 

 

          <!--  <ul id="nav">

                <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('header_dashboard') != '') { echo stripslashes($this->lang->line('header_dashboard')); } else echo "Dashboard";?></a></li>

                <li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>

                <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>

                <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></a></li>

                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>

                <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>

				<li class="active"><a href="<?php echo base_url();?>invite"><?php if($this->lang->line('Invite') != '') { echo stripslashes($this->lang->line('Invite')); } else echo "Invite";?></a></li>

                <li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>

            </ul>-->

			

			

			<!--main nav header -->

            <?php 

             $this->load->view('site/user/main_nav_header');  

            ?>







			</div></div>

</div>



<div class="invit-banner" id="invbnr">

	<h1><?php if($this->lang->line('Earn up to $20 for everyone you invite') != '') { echo stripslashes($this->lang->line('Earn up to $20 for everyone you invite')); } else echo "Earn up to $20 for everyone you invite";?>.</h1>

</div>

<div class="visit-container" id="invvist">

						

<div class="col-sm-12 credit-content">

<center><?php

 /*if($this->lang->line('Send a friend Vacason credit, you will get '.$guest_invite.'  or when they travel and '.$host_invite.'  when they host') != '') { echo stripslashes($this->lang->line('Send a friend Vacason credit, you will get $'.$guest_invite.' or when they travel and $'.$host_invite.' when they host')); } else 

 echo "Send a friend Vacason credit, you will get $".$guest_invite."  when they travel and $".$host_invite." when they host";*/

 

 if($this->lang->line('send_home_stay_credit') != '') {

	echo stripslashes($this->lang->line('send_home_stay_credit'));

 } else 

 echo "Send a friend Homestay credit, you will get $".$guest_invite."  when they travel and $".$host_invite." when they host";

 

 ?></center>

</div>

<div class="clear"></div>

<div class="credit-socialbtn">

<form id="google" method="post" action="site/cms/invite_add_form" accept-charset="UTF-8">

	<input type="hidden" name="sender_id" value="<?php echo $_SESSION['fc_session_user_id']; ?>">

	<div class="col-md-6 col-sm-12 invite-mail">

	<input type="text" placeholder="<?php if($this->lang->line('Add friend email address') != '') { echo stripslashes($this->lang->line('Add friend email address')); } else echo "Add friend email address";?>" name="invite_email" class="input-field" required="required">

	<a href="" class="invite-send">

	<input type="submit" name="submit" value="<?php if($this->lang->line('Send') != '') { echo stripslashes($this->lang->line('Send')); } else echo "Send";?>" class="facebook_inside_btn"></a>



	<div class="para_al" style="color:#565a5c;"><p><?php if($this->lang->line('Separate multiple emails with commas') != '') { echo stripslashes($this->lang->line('Separate multiple emails with commas')); } else echo "Separate multiple emails with commas";?>.</p></div>

	</div>

</form>



<?php

//$url=base_url().'rental/'.$this->config->item('facebook_share');

$url=$this->config->item('facebook_share');

$url=urlencode($url);

$facebook_share='http://www.facebook.com/sharer.php?u='.$url;

?>

<div class="col-md-6 col-sm-12 invite-mailfb">

<input type="text" name="" class="input-field1" value="<?php echo $facebook_share; ?>" readonly>

<a href="<?php echo $facebook_share;?>" class="invite-sendfb"><i class="fa fa-facebook" aria-hidden="true"></i> <span  id="fb_ibut"><input type="submit" name="submit" value="Facebook" class="facebook_inside_btn"></span></a>



<div class="para_fbbtn"><p><?php if($this->lang->line('Share') != '') { echo stripslashes($this->lang->line('Share')); } else echo "Share";?>: <a href="#"><i class="fa fa-twitter invite-tweeter" aria-hidden="true"></i></a></p> </div>		

</div>



</div>

<div class="clear"></div>



<table class="roundedCorners">

<?php 

//print_r($Query->result());

/*foreach($user_credit as $key=>$val)

{

	$user_count_label = $val;

	echo $user_count_label;

}*/

$cn = 0;

/*

foreach($Query->result() as $ac_log)

{

	//echo $ac_log->id;

if($ac_log->group=='Seller')

{

	$ac_log->cnt = $ac_log->cnt1;

	$credit_pointss = 20*$Query->num_rows();

	//echo $Query->num_rows();

}

else

{

	$ac_log->cnt = $ac_log->cnt;

	$credit_pointss = 10*$Query->num_rows();

	//echo $Query->num_rows();

}



?>

<div class="samp_tab">

	<tr>

		<td class="samp_td_img"><div class="inv_img"><img src="<?php if($ac_log->profile_image!='' ) echo $ac_log->profile_image; else echo "images/profile1.png";?>"></div></td><td class="samp_td"><h3><span class="name_wid"><?php echo $ac_log->username; ?></span></h3> </td>

		<td class="samp_td"><span style="color:#00d1c1;"><?php echo $ac_log->cnt; ?></span> <?php if($this->lang->line('Credit Points') != '') { echo stripslashes($this->lang->line('Credit Points')); } else echo "Credit Points";?></td>

		

	</tr>

	</div>



<?php

$cn = $cn+$ac_log->cnt;

}

*/

$credit_points = $cn;

?>

</table>





<div class="col-md-12 col-sm-12" id="invpoint">

<!--

<div class="credit-point">



<center><?php //if($this->lang->line('You ve got') != '') { echo stripslashes($this->lang->line('You ve got')); } else echo "You ve got";?><span style="color:#00d1c1;"> $ <?php //echo $credit_points; ?></span><?php //if($this->lang->line('in travel credit to spend!') != '') { echo stripslashes($this->lang->line('in travel credit to spend!')); } else echo "in travel credit to spend!";?> </center>

</div>

-->



<div class="credit-point">



<center><?php echo $host_invite.",".$guest_invite." "; if($this->lang->line('You ve got') != '') { echo stripslashes($this->lang->line('You ve got')); } else echo "You ve got";?><span style="color:#00d1c1;"> $ <?php echo $Details->row()->referalAmount; ?></span> <?php if($this->lang->line('in travel credit to spend!') != '') { echo stripslashes($this->lang->line('in travel credit to spend!')); } else echo "in travel credit to spend!";?> </center>

</div>

</div>

</div>





<?php



$this->load->view('site/templates/footer');

?>

