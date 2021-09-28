<section class="loggedBg">
    <div class="container">
        <ul class="loginMenu">
            <li>
                <a href="<?php echo base_url(); ?>dashboard" <?php if ($this->uri->segment(1) == 'dashboard') { ?> class="active" <?php } ?>><?php if ($this->lang->line('Dashboard') != '') {
                        echo stripslashes($this->lang->line('Dashboard'));
                    } else echo "Dashboard"; ?></a></li>
            <?php $inboxLinks = array('inbox', 'new_conversation'); ?>
            <li>
                <a href="<?php echo base_url(); ?>inbox" <?php if (in_array($this->uri->segment(1), $inboxLinks)) { ?> class="active" <?php } ?>><?php if ($this->lang->line('Inbox') != '') {
                        echo stripslashes($this->lang->line('Inbox'));
                    } else echo "Inbox"; ?></a></li>
            <?php $listingLinks = array('listing', 'listing-reservation'); ?>
            <li>
                <a href="<?php echo base_url(); ?>listing/all" <?php if (in_array($this->uri->segment(1), $listingLinks)) { ?> class="active" <?php } ?>><?php if ($this->lang->line('YourListing') != '') {
                        echo stripslashes($this->lang->line('YourListing'));
                    } else echo "Your Listing"; ?></a></li>
            <?php
                if ($experienceExistCount > 0) {
                    $experienceLinks = array('experience', 'experience_inbox', 'experience-cancel_booking_dispute', 'experience-dispute1', 'experience-dispute', 'experience-review1', 'experience-review', 'experience-passed-reservation', 'experience-reservation', 'my_experience', 'experience-transactions');
                    ?>
                    <li>
                        <a href="<?php echo base_url(); ?>experience/all" <?php if (in_array($this->uri->segment(1), $experienceLinks)) { ?> class="active" <?php } ?>><?php if ($this->lang->line('YourExperiences') != '') {
                                echo stripslashes($this->lang->line('YourExperiences'));
                            } else echo "Your Experiences"; ?></a></li>
                    <?php
                }
            ?>
            <li>
                <a href="<?php echo base_url(); ?>trips/upcoming" <?php if ($this->uri->segment(1) == 'trips') { ?> class="active" <?php } ?>><?php if ($this->lang->line('your_trips') != '') {
                        echo stripslashes($this->lang->line('your_trips'));
                    } else echo "My Trips"; ?></a></li>
				
				
					
				
            <?php $profileLinks = array('settings', 'photo-video', 'verification', 'display-review', 'display-dispute'); ?>
            <li>
                <a href="<?php echo base_url(); ?>settings" <?php if (in_array($this->uri->segment(1), $profileLinks)) { ?> class="active" <?php } ?>><?php if ($this->lang->line('Profile') != '') {
                        echo stripslashes($this->lang->line('Profile'));
                    } else echo "Profile"; ?></a></li>
            <?php $accountLinks = array('account-payout', 'account-trans', 'account-security', 'account-setting', 'your-wallet'); ?>
            <li>
                <a href="<?php echo base_url(); ?>account-payout" <?php if (in_array($this->uri->segment(1), $accountLinks)) { ?> class="active" <?php } ?>><?php if ($this->lang->line('Account') != '') {
                        echo stripslashes($this->lang->line('Account'));
                    } else echo "Account"; ?></a></li>
            <li>
                <a href="<?php echo base_url(); ?>invite" <?php if ($this->uri->segment(1) == 'invite' OR $this->uri->segment(2) == 'invite') { ?> class="active" <?php } ?>><?php if ($this->lang->line('Invite') != '') {
                        echo stripslashes($this->lang->line('Invite'));
                    } else echo "Invite"; ?></a></li>
        </ul>
    </div>
</section>
