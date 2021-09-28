<?php 
	$this->load->view('site/templates/header');
	?>
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addProperty.js"></script>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor account accountid1 acctprivcy">
	<div class="top-listing-head">
		<div class="main">
		<?php $this->load->view('site/user/main_nav_header');   ?>
		<?php /*
			<ul id="nav">
				<li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('Dashboard') != '') { echo stripslashes($this->lang->line('Dashboard')); } else echo "Dashboard";?></a></li>
				<li><a href="<?php echo base_url();?>inbox"><?php if($this->lang->line('Inbox') != '') { echo stripslashes($this->lang->line('Inbox')); } else echo "Inbox";?></a></li>
				<li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('YourListing') != '') { echo stripslashes($this->lang->line('YourListing')); } else echo "Your Listing";?></a></li>
				<li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('YourTrips') != '') { echo stripslashes($this->lang->line('YourTrips')); } else echo "Your Trips";?></a></li>
				<li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('Profile') != '') { echo stripslashes($this->lang->line('Profile')); } else echo "Profile";?></a></li>
				<li class="active"><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Account') != '') { echo stripslashes($this->lang->line('Account')); } else echo "Account";?></a></li>
				<li><a href="<?php echo base_url();?>invite"><?php if($this->lang->line('Invite') != '') { echo stripslashes($this->lang->line('Invite')); } else echo "Invite";?></a></li>
				<li><a href="<?php echo base_url();?>plan"><?php if($this->lang->line('Plan') != '') { echo stripslashes($this->lang->line('Plan')); } else echo "Plan";?></a></li>
			</ul>
			
			*/?>
			
		</div>
	</div>
	<div class="dash_brd">
		<div id="command_center">
			
			
			<div class="lispg_top">
			<!--Side nav header -->
			<?php 
             $this->load->view('site/user/sub_nav_header');  
            ?>

			<div id="privacy" class="listiong-areas">
				<div id="notification-area">
					<div class="box">
						<div class="middle">
							<h2><?php if($this->lang->line('SocialConnections') != '') { echo stripslashes($this->lang->line('SocialConnections')); } else echo "Social Connections";?></h2>
							<form method="post">
								<div class="padded-text">
									<div class="setting-description">
										<p> <?php if($this->lang->line('SocialConnectionshighlights') != '') { echo stripslashes($this->lang->line('SocialConnectionshighlights')); } else echo "Social Connections highlights your connections to other members of the Guest community.";?></p>
										<p><?php if($this->lang->line('Shownoyour') != '') { echo stripslashes($this->lang->line('Shownoyour')); } else echo "Shown on your profile, Wish Lists, and in search results, Social Connections helps you find guest users who are mutual friends, people from your alma mater, or hosts that your friends recommend.";?></p>
										<p><?php if($this->lang->line('Ifyouturnoff') != '') { echo stripslashes($this->lang->line('Ifyouturnoff')); } else echo "If you turn off this feature, all these connections will be hidden from you and other people on both your profile, Wish Lists, and on your listings.";?></p>
										<div class="checking-area"> 
										
										
											<input type="checkbox"  id="social_recommend" name="social_recommend"  <?php if($userDetails->row()->social_recommend=='yes'){?> checked="checked"<?php }?>> 
											
											
										<!--<input type="checkbox"  id="social_recommend" name="social_recommend" required <?php //if($userDetails->row()->social_recommend=='yes'){?> checked="checked"<?php //}?>> -->
											
											
											<span><?php if($this->lang->line('Showother') != '') { echo stripslashes($this->lang->line('Showother')); } else echo "Show other guest users my social connections (recommended)";?></span> 
											
											
											
											
											
										</div>
									</div>
									
									
									<!--<div class="panel-footer">
										<input  class="save-social" type="submit" value="<?php //if($this->lang->line('SaveSocialConnections') != '') { echo stripslashes($this->lang->line('SaveSocialConnections')); } else echo "Save";?>" <?php //if($userDetails->row()->social_recommend=='no'){ ?> onclick="social_recommend_profile_search('social_recommend')<?php// } ?>">
									</div>-->
									
									
										<div class="panel-footer">
										<input  class="save-social" type="submit" value="<?php if($this->lang->line('SaveSocialConnections') != '') { echo stripslashes($this->lang->line('SaveSocialConnections')); } else echo "Save";?>"  onclick="social_recommend_profile_search('social_recommend')">
									</div>
									
									
									
								</div></div>
							</form>
							<div class="middle">
							<h2><?php if($this->lang->line('YourListingsand') != '') { echo stripslashes($this->lang->line('YourListingsand')); } else echo "Your Listings and Profile in Search Engines";?></h2>
							<form method="post">
								<div class="padded-text">
									<div class="setting-description">
										<p><?php if($this->lang->line('Searchenginesattract') != '') { echo stripslashes($this->lang->line('Searchenginesattract')); } else echo "Search engines attract lots of traffic to your listing and generate interest and bookings for our hosts.";?></p>
										<p><?php if($this->lang->line('Perhapsyou') != '') { echo stripslashes($this->lang->line('Perhapsyou')); } else echo "Perhaps you want to be listed on Cudlstay but have concerns about your listings and profile being advertised more widely. You can turn off search indexing, preventing search engines such as Google and Bing from displaying your pages in their search results.";?></p>
										<p><?php if($this->lang->line('Thismay') != '') { echo stripslashes($this->lang->line('Thismay')); } else echo "Note: This may reduce your bookings and will take a few days to take effect.";?></p>
										<div class="checking-area"> 
										
										
											<!--<input type="checkbox" required id="search_by_profile" name="search_by_profile" <?php //if($userDetails->row()->search_by_profile=='yes'){?> checked="checked"<?php //}?>> 
											<span><?php //if($this->lang->line('Includemyprofile') != '') { echo stripslashes($this->lang->line('Includemyprofile')); } else echo "Include my profile and listing in search engines like Google and Bing (recommended) ";?></span> -->
											
											
										<input type="checkbox"  id="search_by_profile" name="search_by_profile" <?php if($userDetails->row()->search_by_profile=='yes'){?> checked="checked"<?php }?>> 
											<span><?php if($this->lang->line('Includemyprofile') != '') { echo stripslashes($this->lang->line('Includemyprofile')); } else echo "Include my profile and listing in search engines like Google and Bing (recommended) ";?></span> 
											
											
											
											
											
										</div>
									</div>
									<div class="panel-footer">
									
									
									<!--	<input  class="save-social" type="submit" value="<?php //if($this->lang->line('SaveFindability') != '') { echo stripslashes($this->lang->line('SaveFindability')); } else echo "Save";?>" <?php// if($userDetails->row()->search_by_profile=='no'){?> onclick="social_recommend_profile_search('search_by_profile') <?php //} ?>">-->
										
										
								<input  class="save-social" type="submit" value="<?php if($this->lang->line('SaveFindability') != '') { echo stripslashes($this->lang->line('SaveFindability')); } else echo "Save";?>" onclick="social_recommend_profile_search('search_by_profile') ">
										
										
										
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div></div>
		</div>
	</div>
</div>
</div>
<!---DASHBOARD-->
<script type="text/javascript">
	function social_recommend_profile_search(update_field_name)
	{
	//var update_field=update_field;
	if($('#'+update_field_name).is(':checked'))
	{
	var update_field_value='yes';
	}
	else
	{
	var update_field_value='no';
	}
	$.ajax({
	type:'POST',
	data:{update_field:update_field_name,update_value:update_field_value},
	url:'<?php echo base_url()?>site/cms/social_recommend_profile_search',
	success:function(response)
	{
		if(response=='yes')
		{
		window.location.reload(true);
		}
	}
	});
	}
</script>
<!---FOOTER-->
<?php 
	$this->load->view('site/templates/footer');
	?>