<?php
$this->load->view('admin/templates/header.php');
?>

<div id="content">
  <div class="grid_container">
    <div class="grid_12">
      <div class="widget_wrap">
        <div class="widget_wrap tabby">
          <div class="widget_top"> <span class="h_icon list"></span>
            <h6>Global Site Configuration</h6>
            <div id="widget_tab">
              <ul>
                <li><a href="#tab1" class="active_tab">Admin Settings</a></li>
                <li><a href="#tab2">Social Media Settings</a></li>
                <li><a href="#tab3">Google Webmaster & SEO</a></li>
              </ul>
            </div>
          </div>
          <div class="widget_content">
            <?php 
				$attributes = array('class' => 'form_container left_label', 'id' => 'settings_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
				echo form_open_multipart('admin/adminlogin/admin_global_settings',$attributes) 
			?>
			<input type="hidden" name="form_mode" value="main_settings"/>
            <div id="tab1">
              <ul>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="admin_name">Admin Name <span class="req">*</span></label>
                    <div class="form_input">
                      <input name="admin_name" value="<?php echo $admin_settings->row()->admin_name;?>" id="admin_name" type="text" tabindex="1" class="required large tipTop" title="Please enter the admin username"/>	<label id="name_error" style="display:none;" class="error">Special Characters are not allowed!</label>

				   </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="email">Email Address <span class="req">*</span></label>
                    <div class="form_input">
                      <input name="email" id="email" type="text" value="<?php echo $admin_settings->row()->email;?>" tabindex="2" class="required large tipTop" title="Please enter the admin email address"/>
                    </div>
                  </div>
                </li>

                 <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="admin_currencyCode">Admin Default Currency<span class="req">*</span></label>
                    <div class="form_input">
                      
						<?php 
							if($admin_settings->row()->admin_currencyCode==''){
						?>
						
                        <select name="admin_currencyCode" id="admin_currencyCode"  required>
                            <option value="">select</option>

                            <?php foreach($currency_list->result() as $currency) { ?>
                            <option value="<?php echo $currency->currency_type;?>" <?php if($admin_settings->row()->admin_currencyCode == $currency->currency_type) echo 'selected="selected"';?>><?php echo $currency->currency_type;?></option>
                          <?php } ?>
                          
                        </select>
						
							<?php }else{
								echo $admin_settings->row()->admin_currencyCode;
							}?>

                    </div>
                  </div>
                </li>
				
				<li>
				<div class="form_grid_12">
                  <label class="field_title" for="admin_name">Instant Pay  <span class="req">*</span></label>
                  <div class="form_input">                 
                      <input type="radio" tabindex="11" name="instant_pay" <?php if(!empty($instant_pay)){ if($instant_pay->row()->status=='1'){echo 'checked="checked"';}}?> value="1"/>Enable
					  <input type="radio" tabindex="11" name="instant_pay" <?php if(!empty($instant_pay)){  if($instant_pay->row()->status=='0'){echo 'checked="checked"';} }?> value="0"/>Disable
                  </div>
                </div>
				</li>
				

                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="site_contact_mail">Site Contact Email</label>
                    <div class="form_input">
                      <input name="site_contact_mail" id="site_contact_mail" value="<?php echo $admin_settings->row()->site_contact_mail;?>" type="email" tabindex="3" class="large tipTop" title="Please enter the site contact email"/>  
                    </div>
                  </div>
                </li>
				 <!--<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="site_contact_mail">Dropbox Email</label>
                    <div class="form_input">
                      <input name="dropbox_email" id="dropbox_email" value="<?php echo $admin_settings->row()->dropbox_email;?>" type="text" tabindex="3" class="large tipTop" title="Please enter the Dropbox Email"/>
                    </div>
                  </div>
                </li>
				 <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="site_contact_mail">Dropbox Password</label>
                    <div class="form_input">
                      <input name="dropbox_password" id="dropbox_password" value="<?php echo $admin_settings->row()->dropbox_password;?>" type="text" tabindex="3" class="large tipTop" title="Please enter the Dropbox password"/>
                    </div>
                  </div>
                </li>-->
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="email_title">Site Name</label>
                    <div class="form_input">
                      <input name="email_title" id="email_title" type="text" value="<?php echo $admin_settings->row()->email_title;?>" tabindex="4" class="large tipTop" title="Please enter the email title"/> <label id="site_name_error" style="display:none;" class="error">*Special Characters are not allowed!</label>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="logo_image">Logo (Below 50*50)</label>
                    <div class="form_input">
                      <input name="logo_image" id="logo_image" type="file" tabindex="5" class="large tipTop" title="Please select the logo image"/>
                    </div>
                    <div class="form_input"><img src="<?php echo base_url();?>images/logo/<?php echo $admin_settings->row()->logo_image;?>" width="100px"/></div>
                  </div>
                </li>
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="home_logo_image">Home page Logo (Below 50*50)</label>
                    <div class="form_input">
                      <input name="home_logo_image" id="home_logo_image" type="file" tabindex="5" class="large tipTop" title="Please select the Home Page logo image"/>
                    </div>
                    <div class="form_input"><img src="<?php echo base_url();?>images/logo/<?php echo $admin_settings->row()->home_logo_image;?>" width="100px"/></div>
                  </div>
                </li>
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="background_image">Background Image (Below 1500*700)</label>
                    <div class="form_input">
                      <input name="background_image" id="background_image" type="file" tabindex="5" class="large tipTop" title="Please select the Background image"/>
                    </div>
                    <div class="form_input"><img src="<?php echo base_url();?>images/logo/<?php echo $admin_settings->row()->background_image;?>" width="100px"/></div>
                  </div>
                </li>
				<li style="display: none;">
                  <div class="form_grid_12">
                    <label class="field_title" for="videoUrl">Banner Video Url</label>
                    <div class="form_input">
                      <input name="videoUrl" id="videoUrl" type="url" value="<?php echo $admin_settings->row()->videoUrl;?>" tabindex="5" class="large tipTop" title="Please enter Banner Video Url"/>
					  <br><label class="error">Example: http://www.domain.com </label>
				   </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="fevicon_image">Favicon (Below 50*50)</label>
                    <div class="form_input">
                      <input name="fevicon_image" id="fevicon_image" type="file" tabindex="6" class="large tipTop" title="Please select the favicon image"/>
                    </div>
                    <div class="form_input"><img src="<?php echo base_url();?>images/logo/<?php echo $admin_settings->row()->fevicon_image;?>" width="50px"/></div>
                  </div>
                </li>
				 <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="watermark">Watermark (Below 50*50)</label>
                    <div class="form_input">
                      <input name="watermark" id="watermark" type="file" tabindex="6" class="large tipTop" title="Please select the watermark image"/>
                    </div>
                    <div class="form_input"><img src="<?php echo base_url();?>images/logo/<?php echo $admin_settings->row()->watermark;?>" width="50px"/></div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="footer_content">Footer Content</label>
                    <div class="form_input">
                      <input name="footer_content" id="footer_content" type="text" value="<?php echo htmlentities($admin_settings->row()->footer_content);?>" tabindex="7" class="large tipTop" title="Please enter the footer copyright content"/>
                    </div>
                  </div>
                </li>
				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="site_pagination_per_page">Pagination Limit for Property Filter</label>
                    <div class="form_input">
                      <input name="site_pagination_per_page" id="site_pagination_per_page" type="number" value="<?php echo htmlentities($admin_settings->row()->site_pagination_per_page);?>" tabindex="7" class="large tipTop" title="Please enter pagination limit for Property Filter" min="1" required/>
                    </div>
                  </div>
                </li>
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="dispute_days">Dispute Days</label>
                    <div class="form_input">
                      <input name="dispute_days" id="dispute_days" type="number" value="<?php echo htmlentities($admin_settings->row()->dispute_days);?>" tabindex="7" class="large tipTop" title="Please enter Dispute Days" min="1"/>
                    </div>
                  </div>
                </li>
				
				
				<li>
					<div class="form_grid_12">
					  <label class="field_title" for="twilio_status"> Twilio Status </label>
					  <div class="form_input">                 
						  <input type="radio" onchange="getTwilioStatus(this);" tabindex="11" name="twilio_status" <?php  if($admin_settings->row()->twilio_status=='1'){echo 'checked="checked"'; } ?> value="1"/>  Enable
						  <input type="radio" onchange="getTwilioStatus(this);"  tabindex="11" name="twilio_status" <?php  if($admin_settings->row()->twilio_status=='0'){echo 'checked="checked"';} ?> value="0"/>Disable
					  </div>
					</div>
					<input type="hidden" id="twilioState_id" value="<?php echo $admin_settings->row()->twilio_status;  ?>">
				</li>
				
		<div id="twilioGroup" style="display:none">		
				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="twilio_account_sid">Twilio Account SID  <span class="req">*</span> </label>
                    <div class="form_input">
                      <input name="twilio_account_sid" id="twilio_account_sid" type="text" value="<?php echo htmlentities($admin_settings->row()->twilio_account_sid);?>" tabindex="7" class="large tipTop" title="Please enter Twilio Account SID" required /> <label id="twilio_account_sid_error" style="display:none;" class="error" >Special Characters are not allowed!</label>
                    </div>
                  </div>
                </li>
				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="twilio_account_token">Twilio Account Auth Token  <span class="req">*</span> </label>
                    <div class="form_input">
                      <input name="twilio_account_token" id="twilio_account_token" type="text" value="<?php echo htmlentities($admin_settings->row()->twilio_account_token);?>" tabindex="7" class="large tipTop" title="Please enter Twilio Account Auth Token" required /> <label id="twilio_account_token_error" style="display:none;" class="error">Special Characters are not allowed!</label>
                    </div>
                  </div>
                </li>
				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="twilio_phone_number">Twilio Phone Number  <span class="req">*</span> </label>
                    <div class="form_input">
                      <input name="twilio_phone_number" id="twilio_phone_number" type="text" value="<?php echo htmlentities($admin_settings->row()->twilio_phone_number);?>" tabindex="7" class="large tipTop" title="Please enter Twilio Phone Number" required />  <label id="twilio_phone_number_error" style="display:none;" class="error">Special Characters are not allowed!</label>
                    </div>
                  </div>
                </li>
				
			</div>	
				
				
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="twilio_phone_number">Pagination Limit for Popular Page</label>
                    <div class="form_input">
                      <input name="popular_pagination_per_page" id="popular_pagination_per_page" type="number" value="<?php echo htmlentities($admin_settings->row()->popular_pagination_per_page);?>" tabindex="7" class="large tipTop" title="Please enter pagination limit for popular page" min="3" required/>  <label id="twilio_phone_number_error" style="display:none;" class="error">Special Characters are not allowed!</label>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="twilio_phone_number">Pagination Limit for Places Page</label>
                    <div class="form_input">
                      <input name="places_pagination_per_page" id="places_pagination_per_page" type="number" value="<?php echo htmlentities($admin_settings->row()->places_pagination_per_page);?>" tabindex="7" class="large tipTop" title="Please enter pagination limit for places page" min="5" required/>  <label id="twilio_phone_number_error" style="display:none;" class="error">Special Characters are not allowed!</label>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="twilio_phone_number">Pagination Limit for Experiences Page</label>
                    <div class="form_input">
                      <input name="experiences_pagination_per_page" id="experiences_pagination_per_page" type="number" value="<?php echo htmlentities($admin_settings->row()->experiences_pagination_per_page);?>" tabindex="7" class="large tipTop" title="Please enter pagination limit for Experience page" min="5" required/>  <label id="twilio_phone_number_error" style="display:none;" class="error">Special Characters are not allowed!</label>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="twilio_phone_number">Pagination Limit for WishList Page</label>
                    <div class="form_input">
                      <input name="wishlist_pagination_per_page" id="wishlist_pagination_per_page" type="number" value="<?php echo htmlentities($admin_settings->row()->wishlist_pagination_per_page);?>" tabindex="7" class="large tipTop" title="Please enter pagination limit for wishlist page" min="3" required/>  <label id="twilio_phone_number_error" style="display:none;" class="error">Special Characters are not allowed!</label>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="twilio_phone_number">Image Compression Percentage</label>
                    <div class="form_input">
                      <input name="image_compress_percentage" id="image_compress_percentage" type="number" value="<?php echo htmlentities($admin_settings->row()->image_compress_percentage);?>" tabindex="8" class="large tipTop" title="Please enter Image Compression Percentage" min="0" max="100" required/>% 
                    </div>
                  </div>
                </li>


                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="property_cancellation">Before Number of days to allow cancellation<br>(property)</label> <small>*Cancellation button will be hide before (n) days from booking start date</small>
                    <div class="form_input">
                      <input name="cancel_hide_days_property" id="cancel_hide_days_property" type="number" value="<?php echo htmlentities($admin_settings->row()->cancel_hide_days_property);?>" tabindex="8" class="large tipTop" title="Please enter Number of Days" min="1" max="100" required/>
                    </div>
                  </div>
                </li>
                
                 <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="experience_cancellation">Before Number of days to allow cancellation<br>(experience)</label> <small>*Cancellation button will be hide before (n) days from booking start date</small>
                    <div class="form_input">
                      <input name="cancel_hide_days_experience" id="cancel_hide_days_experience" type="number" value="<?php echo htmlentities($admin_settings->row()->cancel_hide_days_experience);?>" tabindex="8" class="large tipTop" title="Please enter Number of Days" min="1" max="100" required/>
                    </div>
                  </div>
                </li>    

				<!-- to set default admin country-->
				
				 <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="country">Admin Country <span class="req">*</span> <br></label> 
                    <div class="form_input">
                     <select id="admin_country_code" name="admin_country_code" required>
						<option value="">Select</option>
						<?php foreach($active_countries->result() as $active_country) :?>
						<option value="<?php echo $active_country->id;?>" <?php if ($active_country->id==$admin_settings->row()->admin_country_code) { echo 'selected="selected"'; } ?>>
						<?php echo $active_country->name;  ?></option>
						<?php endforeach; ?>
					</select>
                    </div>
                  </div>
                </li> 


				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="google_map_api">Google Map API Key</label>
                    <div class="form_input">
                      <input name="google_map_api" id="google_map_api" type="text" value="<?php echo htmlentities($admin_settings->row()->google_map_api);?>" tabindex="7" class="large tipTop" title="Please enter google map api key"/>
                    </div>
                  </div>
                </li>
                <li>
					<div class="form_grid_12">
					  <label class="field_title" for="admin_pulishing_status"> Publishing Control </label>
					  <div class="form_input">                 
						  <input type="radio" tabindex="11" name="admin_pulishing_status" <?php  if($admin_settings->row()->admin_pulishing_status=='1'){echo 'checked="checked"'; } ?> value="1"/>  Automatic Publish When Host add Property or Experience
						  <input type="radio" tabindex="11" name="admin_pulishing_status" <?php  if($admin_settings->row()->admin_pulishing_status=='0'){echo 'checked="checked"';} ?> value="0"/>Manual Publish From Admin
					  </div>
					</div>
					<input type="hidden" id="admin_pulishing_status_id" value="<?php echo $admin_settings->row()->admin_pulishing_status;  ?>">
				</li>
				<!--
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="s3_bucket_name">S3 Bucket Name</label>
                    <div class="form_input">
                      <input name="s3_bucket_name" id="s3_bucket_name" type="text" value="<?php //echo htmlentities($admin_settings->row()->s3_bucket_name);?>" tabindex="7" class="large tipTop" title="Please enter google map api key"/>
                    </div>
                  </div>
                </li>
				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="s3_access_key">S3 Access Key</label>
                    <div class="form_input">
                      <input name="s3_access_key" id="s3_access_key" type="text" value="<?php //echo htmlentities($admin_settings->row()->s3_access_key);?>" tabindex="7" class="large tipTop" title="Please enter google map api key"/>
                    </div>
                  </div>
                </li>
				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="s3_secret_key">S3 Secret Key</label>
                    <div class="form_input">
                      <input name="s3_secret_key" id="s3_secret_key" type="text" value="<?php //echo htmlentities($admin_settings->row()->s3_secret_key);?>" tabindex="7" class="large tipTop" title="Please enter google map api key"/>
                    </div>
                  </div>
                </li>-->
				
				<!--<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="home_title_1">Home Title 1</label>
                    <div class="form_input">
                      <input name="home_title_1" id="home_title_1" type="text" value="<?php echo htmlentities($admin_settings->row()->home_title_1);?>" tabindex="7" class="large tipTop" title="Please enter google map api key"/> <label id="home_title_1_error" style="display:none;" class="error">Special Characters are not allowed</label>
                    </div>
                  </div>
                </li>
				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="home_title_2">Home Title 2</label>
                    <div class="form_input">
                      <input name="home_title_2" id="home_title_2" type="text" value="<?php echo htmlentities($admin_settings->row()->home_title_2);?>" tabindex="7" class="large tipTop" title="Please enter google map api key"/> <label id="home_title_2_error" style="display:none;" class="error">Special Characters are not allowed</label>
                    </div>
                  </div>
                </li>
				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="home_title_3">Home Title 3</label>
                    <div class="form_input">
                      <input name="home_title_3" id="home_title_3" type="text" value="<?php echo htmlentities($admin_settings->row()->home_title_3);?>" tabindex="7" class="large tipTop" title="Please enter google map api key"/> <label id="home_title_3_error" style="display:none;" class="error">Special Characters are not allowed</label>
                    </div>
                  </div>
                </li>
				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="home_title_4">Home Title 4</label>
                    <div class="form_input">
                      <input name="home_title_4" id="home_title_4" type="text" value="<?php echo htmlentities($admin_settings->row()->home_title_4);?>" tabindex="7" class="large tipTop" title="Please enter google map api key"/> <label id="home_title_4_error" style="display:none;" class="error">Special Characters are not allowed!</label>
                    </div>
                  </div>
                </li>-->
				
                <!--<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="like_text">Like Button Text</label>
                    <div class="form_input">
                      <input name="like_text" id="like_text" type="text" value="<?php echo htmlentities($admin_settings->row()->like_text);?>" tabindex="8" class="large tipTop" title="Please enter the text for like button"/>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="liked_text">Liked Button Text</label>
                    <div class="form_input">
                      <input name="liked_text" id="liked_text" type="text" value="<?php echo htmlentities($admin_settings->row()->liked_text);?>" tabindex="9" class="large tipTop" title="Please enter the text for liked button"/>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="unlike_text">Unlike Button Text</label>
                    <div class="form_input">
                      <input name="unlike_text" id="unlike_text" type="text" value="<?php echo htmlentities($admin_settings->row()->unlike_text);?>" tabindex="10" class="large tipTop" title="Please enter the text for unlike button"/>
                    </div>
                  </div>
                </li>-->
              </ul>
            <ul><li><div class="form_grid_12">
				<div class="form_input">
					<button type="submit" class="btn_small btn_blue" tabindex="15"><span>Submit</span></button>
				</div>
			</div></li></ul>
			</div>
			</form>
             <?php 
				$attributes = array('class' => 'form_container left_label', 'id' => 'settings_form','accept-charset'=>'UTF-8');
				echo form_open('admin/adminlogin/admin_global_settings',$attributes) 
			?>
			<input type="hidden" name="form_mode" value="social"/>
            <div id="tab2">
            
              <ul>
              <!--<div class="form_grid_12">
              <label class="error">Note: To create google api refer this   <a href="http://www.sanwebe.com/2012/10/creating-google-oauth-api-key" target="_blank">Reference Link</a>  </label>
              </div>
              <div class="form_grid_12">              
              <label class="error">Note: To create Facebook api click below url, click Apps then Create New App <a href="https://developers.facebook.com/" target="_blank">Facebook Link</a>  </label>
              </div>
               <div class="form_grid_12">              
              <label  class="error">Note: To create Twitter api refer this <a href="https://dev.twitter.com/discussions/631" target="_blank">Reference Link</a>  </label>
              </div>-->
              <div class="form_grid_12">
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="facebook_link">Facebook Link</label>
                    <div class="form_input">
                      <input name="facebook_link" id="facebook_link" type="url" value="<?php echo $admin_settings->row()->facebook_link;?>" tabindex="10" class="large tipTop" title="Please enter the site facebook url"/>
                    </div>
                  </div>
                </li>
                
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="googleplus_link">Google plus</label>
                    <div class="form_input">
                      <input name="googleplus_link" id="googleplus_link" type="url" value="<?php echo $admin_settings->row()->googleplus_link;?>" tabindex="10" class="large tipTop" title="Please enter the site google plus url"/>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="youtube_link">Youtube Link</label>
                    <div class="form_input">
                      <input name="youtube_link" id="youtube_link" type="url" tabindex="11" value="<?php echo $admin_settings->row()->youtube_link;?>" class="large tipTop" title="Please enter the site youtube url"/>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="twitter_link">Twitter Link</label>
                    <div class="form_input">
                      <input name="twitter_link" id="twitter_link" type="url" tabindex="11" value="<?php echo $admin_settings->row()->twitter_link;?>" class="large tipTop" title="Please enter the site twitter url"/>
                    </div>
                  </div>
                </li>
				
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="pinterest">Pintrest Link</label>
                    <div class="form_input">
                      <input name="pinterest" id="pinterest" type="url" tabindex="11" value="<?php echo $admin_settings->row()->pinterest;?>" class="large tipTop" title="Please enter the site pintrest url"/>
                    </div>
                  </div>
                </li>
                
                <!--<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="consumer_key">Twitter Consumer Key</label>
                    <div class="form_input">
                      <input name="consumer_key" id="consumer_key" type="text" tabindex="11" value="<?php echo $admin_settings->row()->consumer_key;?>" class="large tipTop" title="Please enter the twitter consumer key"/>
                       <label class="error">Note: For Twitter Callback URL Copy This Url and Paste It.  - <?php echo base_url();?>twtest/callback </label>
                    </div>
                   
                  </div>
                </li>
                
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="consumer_secret">Twitter Secret Key</label>
                    <div class="form_input">
                      <input name="consumer_secret" id="consumer_secret" type="text" tabindex="11" value="<?php echo $admin_settings->row()->consumer_secret;?>" class="large tipTop" title="Please enter the twitter secret key"/>
                    </div>
                  </div>
                </li>-->
                
                 <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="google_client_id">Google Client Id</label>
                    <div class="form_input">
                      <input name="google_client_id" id="google_client_id" type="text" tabindex="11" value="<?php echo $admin_settings->row()->google_client_id;?>" class="large tipTop" title="Please enter the google client id"/>
                    </div>
                  </div>
                </li>
                
                 <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="google_redirect_url">Google Redirect Url</label>
                    <div class="form_input">
                      <input name="google_redirect_url" id="google_redirect_url" type="text" tabindex="11" value="<?php echo $admin_settings->row()->google_redirect_url;?>" class="large tipTop" title="Please enter the google redirect url"/>
                      <label class="error">Note: For Google Redirect Url Copy This Url and Paste It. - <?php echo base_url();?>googlelogin/googleRedirect </label>
                    </div>
                  </div>
                </li>
                
				<li>
                  <div class="form_grid_12">
                    <label class="field_title" for="google_redirect_url">Google Redirect Url For DB Backup</label>
                    <div class="form_input">
                      <input name="google_redirect_url_db" id="google_redirect_url_db" type="text" tabindex="11" value="<?php echo $admin_settings->row()->google_redirect_url_db;?>" class="large tipTop" title="Please enter the google redirect url"/>
                      <label class="error">Note: For Google Redirect Url Copy This Url and Paste It. - <?php echo base_url();?>dbbackup/fileUpload.php </label>
                      <label class="error">Note: Kindly Enable Drive API in APIs </label>
                    </div>
                  </div>
                </li>
				
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="google_redirect_url">Google Redirect Url For Connect</label>
                    <div class="form_input">
                      <input name="google_redirect_url_connect" id="google_redirect_url_connect" type="text" tabindex="11" value="<?php echo $admin_settings->row()->google_redirect_url_connect;?>" class="large tipTop" title="Please enter the google redirect url"/>
                      <label class="error">Note: For Google Redirect Url Copy This Url and Paste It. - <?php echo base_url();?>site/invitefriend/google_connect </label>
                    </div>
                  </div>
                </li>
				
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="google_client_secret">Google Secret Key</label>
                    <div class="form_input">
                      <input name="google_client_secret" id="google_client_secret" type="text" tabindex="11" value="<?php echo $admin_settings->row()->google_client_secret;?>" class="large tipTop" title="Please enter the google secret key"/>
                    </div>
                  </div>
                </li>
                
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="google_developer_key">Google Developer Key</label>
                    <div class="form_input">
                      <input name="google_developer_key" id="google_developer_key" type="text" tabindex="11" value="<?php echo $admin_settings->row()->google_developer_key;?>" class="large tipTop" title="Please enter the google developer key"/>
                    </div>
                  </div>
                </li>         
                
                 <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="facebook_app_id">Facebook App ID</label>
                    <div class="form_input">
                      <input name="facebook_app_id" id="facebook_app_id" type="text" tabindex="11" value="<?php echo $admin_settings->row()->facebook_app_id;?>" class="large tipTop" title="Please enter the facebook app id"/>
                    </div>
                  </div>
                </li>
                
               <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="facebook_app_secret">Facebook App Secret</label>
                    <div class="form_input">
                      <input name="facebook_app_secret" id="facebook_app_secret" type="text" tabindex="11" value="<?php echo $admin_settings->row()->facebook_app_secret;?>" class="large tipTop" title="Please enter the facebook app secret"/>
                    </div>
                  </div>
                </li>
				 <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="linkedin_app_id">LinkedIn App ID</label>
                    <div class="form_input">
                      <input name="linkedin_app_id" id="linkedin_app_id" type="text" tabindex="11" value="<?php echo $admin_settings->row()->linkedin_app_id;?>" class="large tipTop" title="Please enter the LinkedIn app id"/>
                    </div>
                  </div>
                </li>
				 <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="linkedin_secret_key">LinkedIn Secret Key</label>
                    <div class="form_input">
                      <input name="linkedin_app_key" id="linkedin_app_key" type="text" tabindex="11" value="<?php echo $admin_settings->row()->linkedin_app_key;?>" class="large tipTop" title="Please enter the LinkedIn Secret Key"/>
                    </div>
                  </div>
                </li>
                              
                
              </ul>
             <ul><li><div class="form_grid_12">
				<div class="form_input">
					<button type="submit" class="btn_small btn_blue" tabindex="15"><span>Submit</span></button>
				</div>
			</div></li></ul>
			</div>
            </form>
             <?php 
				$attributes = array('class' => 'form_container left_label', 'id' => 'settings_form','accept-charset'=>'UTF-8');
				echo form_open('admin/adminlogin/admin_global_settings',$attributes) 
			?>
			<input type="hidden" name="form_mode" value="seo"/>
            <div id="tab3">
              <ul>
               <li>
                  <h3>Search Engine Information</h3>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_title">Meta Title</label>
                    <div class="form_input">
                      <input name="meta_title" id="meta_title" type="text" value="<?php echo $admin_settings->row()->meta_title;?>" tabindex="1" class="large tipTop" title="Please enter the site meta title"/>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_keyword">Meta Keyword</label>
                    <div class="form_input">
                      <input name="meta_keyword" id="meta_keyword" type="text" value="<?php echo $admin_settings->row()->meta_keyword;?>" tabindex="2" class="large tipTop" title="Please enter the site meta keyword"/>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_description">Meta Description</label>
                    <div class="form_input">
                      <textarea name="meta_description" class="" cols="70" rows="5" tabindex="3"><?php echo $admin_settings->row()->meta_description;?></textarea>
                    </div>
                  </div>
                </li>
                
                <li>
                  <h3>Google Webmaster Info</h3>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="google_verification_code">Google Analytics Code</label>
                    <div class="form_input">
                      <textarea name="google_verification_code" class="input_grow tipTop" title="Copy google analytics code and paste here" cols="70" rows="5" tabindex="4"><?php echo $admin_settings->row()->google_verification_code;?></textarea>
                      <br />
                      <span>For Examples:
                      <pre><?php echo htmlspecialchars('<script type="text/javascript"

  var _gaq = _gaq || [];
  _gaq.push([_setAccount, UA-XXXXX-Y]);
  _gaq.push([_trackPageview]);

  (function() {
    var ga = document.createElement(script); ga.type = text/javascript; ga.async = true;
    ga.src = (https: == document.location.protocol ? https://ssl : http://www) + .google-analytics.com/ga.js;
    var s = document.getElementsByTagName(script)[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>'); ?></pre>
                      </span> </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_keyword">Google HTML Meta Verifcation Code</label>
                    <div class="form_input">
                      <input name="google_verification" id="google_verification" value="<?php echo str_replace('"', "'",$admin_settings->row()->google_verification);?>" type="text" tabindex="5" class="large tipTop" title="Google HTMl Verification Code. Eg: <meta name='google-site-verification' content='XXXXX'>"/>
                      <span><br />
                      Google Webmaster Verification using Meta tag. <br />For more reference: <a href="https://support.google.com/webmasters/answer/35638#3" target="_blank">https://support.google.com/webmasters/answer/35638#3</a></span></div>
                  </div>
                </li>
              </ul>
              <ul><li><div class="form_grid_12">
				<div class="form_input">
					<button type="submit" class="btn_small btn_blue" tabindex="15"><span>Submit</span></button>
				</div>
			</div></li></ul>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <span class="clear"></span> </div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>

<script type="text/javascript">
function getTwilioStatus(status){
	var theValue=status.value;
	if(theValue=='1'){
		$("#twilioGroup").css('display','block');
	}else{
		$("#twilioGroup").css('display','none');
		$("#twilio_account_sid").val('');
		$("#twilio_account_token").val('');
		$("#twilio_phone_number").val('');
	}
	
}
</script>

<script type="text/javascript">
window.addEventListener('load',   
 function() { 
var getStatus=$("#twilioState_id").val();
if (getStatus=='1'){
	$("#twilioGroup").css('display','block');
}else{
	$("#twilioGroup").css('display','none');
}
 
 }, false);
</script>


<script>
/* $("#admin_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z\s()&]/g)) {
	   document.getElementById("name_error").style.display = "inline";
	   $("#name_error").fadeOut(5000);
	   $("#admin_name").focus();
       $(this).val(val.replace(/[^a-zA-Z\s()&]/g, ''));
   }
});

$("#email_title").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z0-9-\s&()]/g)) {
	   document.getElementById("site_name_error").style.display = "inline";
	   $("#site_name_error").fadeOut(5000);
	   $("#email_title").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9-\s&()]/g, ''));
   }
});

$("#twilio_phone_number").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^0-9\s]/g)) {
	   document.getElementById("twilio_phone_number_error").style.display = "inline";
	   $("#twilio_phone_number_error").fadeOut(5000);
	   $("#twilio_phone_number").focus();
       $(this).val(val.replace(/[^0-9\s]/g, ''));
   }
}); */

/*$("#twilio_account_sid").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("twilio_account_sid_error").style.display = "inline";
	   $("#twilio_account_sid_error").fadeOut(5000);
	   $("#twilio_account_sid").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()]/g, ''));
   }
});


$("#twilio_account_token").on('keyup', function(e) {
    var val = $(this).val();
  if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("twilio_account_token_error").style.display = "inline";
	   $("#twilio_account_token_error").fadeOut(5000);
	   $("#twilio_account_token").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()]/g, ''));
   }
});

 $("#home_title_1").on('keyup', function(e) {
    var val = $(this).val();
  if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("home_title_1_error").style.display = "inline";
	   $("#home_title_1_error").fadeOut(5000);
	   $("#home_title_1").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
   }
});

$("#home_title_2").on('keyup', function(e) {
    var val = $(this).val();
  if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("home_title_2_error").style.display = "inline";
	   $("#home_title_2_error").fadeOut(5000);
	   $("#home_title_2").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
   }
});

$("#home_title_3").on('keyup', function(e) {
    var val = $(this).val();
  if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("home_title_3_error").style.display = "inline";
	   $("#home_title_3_error").fadeOut(5000);
	   $("#home_title_3").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
   }
});

$("#home_title_4").on('keyup', function(e) {
    var val = $(this).val();
  if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("home_title_4_error").style.display = "inline";
	   $("#home_title_4_error").fadeOut(5000);
	   $("#home_title_4").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
   }
}); */

</script>
