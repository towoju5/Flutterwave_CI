<div class="dashboard-sidemenu">
<ul class="subnav">

<?php 
$url = $this->uri->segment(1);
//need to set active
?>
<?php /*              
			  <li><a href="<?php echo base_url();?>account"><?php if($this->lang->line('Notifications') != '') { echo stripslashes($this->lang->line('Notifications')); } else echo "Notifications";?></a></li>
			  */?>
				
				
                <li <?php if($url == 'account-payout') echo 'class="active"';?>><a href="<?php echo base_url();?>account-payout"><?php if($this->lang->line('PayoutPreferences') != '') { echo stripslashes($this->lang->line('PayoutPreferences')); } else echo "Payout Preferences";?></a></li>
                <li <?php if($url == 'account-trans') echo 'class="active"';?>><a href="<?php echo base_url();?>account-trans"><?php if($this->lang->line('TransactionHistory') != '') { echo stripslashes($this->lang->line('TransactionHistory')); } else echo "Transaction History";?></a></li>
                <!-- <li><a href="<?php echo base_url();?>referrals">Referrals</a></li>-->
				<?php /*
                <li><a href="<?php echo base_url();?>account-privacy"><?php if($this->lang->line('Privacy') != '') { echo stripslashes($this->lang->line('Privacy')); } else echo "Privacy";?></a></li>
				*/ ?>
				
				<?php if($_SESSION['login_type']=='google' AND $_SESSION['linked_in_login']=='linkedin' AND $_SESSION['facebook_in_login']=='facebook'){	}elseif($_SESSION['normal_login']=='normal' AND $_SESSION['fc_session_user_id']){?>                <li <?php if($url == 'account-security') echo 'class="active"';?>><a href="<?php echo base_url();?>account-security"><?php if($this->lang->line('Security') != '') { echo stripslashes($this->lang->line('Security')); } else echo "Security";?></a></li><?php } else{}?>
                <li  <?php if($url == 'account-setting') echo 'class="active"';?>><a href="<?php echo base_url();?>account-setting"><?php if($this->lang->line('Settings') != '') { echo stripslashes($this->lang->line('Settings')); } else echo "Settings";?></a></li>            
            
                <!-- malar - 80/07/2017 - wallet status  -->
                <li  <?php if($url == 'your-wallet') echo 'class="active"';?>>
                  <a href="<?php echo base_url();?>your-wallet"><?php if($this->lang->line('your_wallet') != '') { echo stripslashes($this->lang->line('your_wallet')); } else echo "Your Wallet";?></a>
                </li>
                <!-- malar - 80/07/2017 - wallet status ends  -->
            <a class="invitefrds" href="#" style="display:none"><?php if($this->lang->line('InviteFriendspage') != '') { echo stripslashes($this->lang->line('InviteFriendspage')); } else echo "Invite Friends page";?></a>

            
          </ul>
</div>		  