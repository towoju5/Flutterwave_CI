<script src="//connect.facebook.net/en_US/sdk.js" type="text/javascript"></script>
<script type="text/javascript">
window.fbAsyncInit = function() {
    FB.init({
        appId   : '<?php echo APPKEY; ?>',
        oauth   : true,
        status  : true, // check login status
        cookie  : true, // enable cookies to allow the server to access the session
        xfbml   : true, // parse XFBML
        version    : 'v2.8' // use graph api version 2.8
    });

  };
	function fb_login()
	{ 
		console.log( 'fb_login function initiated' );
		FB.login(function(response) {

			console.log( 'login response' );
			console.log( response );
			console.log( 'Response Status' + response.status );
			//top.location.href=http://vacationhosting.com/;
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

						var passData = 'fid='+ id + '&email='+ email + '&name='+ name + '&live='+ live ;
						//alert(passData);
						//console.log('data', passData);

						$.ajax({
							type: 'GET',
							data: passData,
							//data: $.param(passData),
							global: false,
							url: '<?php echo base_url().'facebooklogin'; ?>',
							success: function(responseText){ 
								console.log( responseText ); 

								location.reload();
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
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="selectBoxRow clear">
                    <div class="selectBox">
                        <select onChange="changeLanguage(this);">
                            <?php
                            $selectedLangCode = $this->session->userdata('language_code');
                            if ($selectedLangCode == '') {
                                $selectedLangCode = $defaultLg[0]['lang_code'];
                            }
                            if (count($activeLgs) > 0) {
                                foreach ($activeLgs as $activeLgsRow) {
                                    ?>
                                    <option
                                            value="<?php echo base_url(); ?>lang/<?php echo $activeLgsRow['lang_code']; ?>" <?php if ($selectedLangCode == $activeLgsRow['lang_code']) {
                                        echo 'selected="selected"';
                                    } ?>><?php echo ucfirst($activeLgsRow['name']); ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="selectBox">
                        <select onChange="changeCurrency(this);">
                            <?php
                            if ($currency_setup->num_rows() > 0) {
                                foreach ($currency_setup->result() as $currency_s) {
                                    if ($currency_s->currency_type == $this->session->userdata('currency_type')) {
                                        $SelecTed = 'selected="selected"';
                                    } else {
                                        $SelecTed = '';
                                    }
                                    ?>
                                    <option
                                            value="<?php echo base_url(); ?>change-currency/<?php echo $currency_s->id; ?>" <?php echo $SelecTed; ?>><?php echo $currency_s->currency_type; ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="listMenus">
                    <h5><?php if ($this->lang->line('Service') != '') {
                            echo stripslashes($this->lang->line('Service'));
                        } else echo "Service"; ?></h5>
                    <ul>
                        <li><a href="<?= base_url(); ?>contact-us"> <?php if ($this->lang->line('Contact Us') != '') {
                                    echo stripslashes($this->lang->line('Contact Us'));
                                } else echo "Contact Us"; ?> </a></li>
                        <li><a href="<?= base_url(); ?>help"> <?php if ($this->lang->line('Help') != '') {
                                    echo stripslashes($this->lang->line('Help'));
                                } else echo "Help"; ?> </a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="listMenus">
                    <h5><?php if ($this->lang->line('Company') != '') {
                            echo stripslashes($this->lang->line('Company'));
                        } else echo "Company"; ?></h5>
                    <ul>
                        <?php if ($cmsList->num_rows() > 0) {
                            $i = 1;
                            foreach ($cmsList->result() as $key => $row) {
                                if ($i % 2 != 0) {
                                    if ($row->seourl != 'help') { ?>
                                        <li>
                                            <?php echo anchor('pages/' . $row->seourl, ucfirst($row->page_name)); ?>
                                        </li>
                                    <?php } else { ?>
                                        <li>
                                            <?php echo anchor('pages/' . $row->seourl, ucfirst($row->page_name)); ?>
                                        </li>
                                    <?php }
                                }
                                $i++;
                            }
                        } ?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="listMenus">
                    <h5>&nbsp;</h5>
                    <ul>
                        <?php if ($cmsList->num_rows() > 0) {
                            $i = 1;
                            foreach ($cmsList->result() as $key => $row) {
                                if ($i % 2 == 0) {
                                    if ($row->seourl != 'help') { ?>
                                        <li>
                                            <?php echo anchor('pages/' . $row->seourl, ucfirst($row->page_name)); ?>
                                        </li>
                                    <?php } else { ?>
                                        <li>
                                            <?php echo anchor('pages/' . $row->seourl, ucfirst($row->page_name)); ?>
                                        </li>
                                    <?php }
                                }
                                $i++;
                            }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyRights">
            <div class="clear">
                <div class="left">
                    <?= $footer; ?>
                </div>
                <div class="right">
                    <a href="<?php echo base_url(); ?>pages/terms-of-service"><?php if ($this->lang->line('header_terms_service') != '') {
                            echo stripslashes($this->lang->line('header_terms_service'));
                        } else echo "Terms of Service"; ?></a>
                    <a href="<?php echo base_url(); ?>pages/privacy-policy"><?php if ($this->lang->line('header_privacy_policy') != '') {
                            echo stripslashes($this->lang->line('header_privacy_policy'));
                        } else echo "Privacy Policy"; ?></a>
                    <!--<a href="#">Site Map</a>-->
                    <?php if ($this->config->item('facebook_link') != '') { ?>
                        <a href="<?php echo $this->config->item('facebook_link'); ?>"><img
                                    src="<?php echo base_url(); ?>images/facebookIcon_f.png"></a>
                    <?php }
                    if ($this->config->item('twitter_link') != '') { ?>
                        <a href="<?php echo $this->config->item('twitter_link'); ?>"><img
                                    src="<?php echo base_url(); ?>images/twitterIcon.png"></a>
                    <?php }
                    if ($this->config->item('googleplus_link') != '') { ?>
                        <a href="<?php echo $this->config->item('googleplus_link'); ?>"><img
                                    src="<?php echo base_url(); ?>images/instagramIcon.png"></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Sign Up Modal -->
<div id="signUp" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="signUpIn">
                    <?php if ($facebook_id != '' && $facebook_secert != '') { ?>
                        <?php /* <a href="<?php echo $fbLoginUrl; ?>" class="faceBook hide_signUp"> <img
                                    src="<?php echo base_url(); ?>images/facebookIcon.png"> <?php if ($this->lang->line('facebook_signup') != '') {
                                echo stripslashes($this->lang->line('facebook_signup'));
                            } else echo "Continue with Facebook"; ?></a> */ ?>
                        <a href="javascript:;" onclick="fb_login()" class="faceBook hide_signUp"> <img src="<?php echo base_url(); ?>images/facebookIcon.png"> <?php if ($this->lang->line('facebook_signup') != '') { echo stripslashes($this->lang->line('facebook_signup')); } else { echo "Continue with Facebook"; } ?></a>
                    <?php }
                    if ($google_id != '' && $google_secert != '') { ?>
                        <a href="<?php echo $googleLoginURL; ?>" class="googlePlus hide_signUp"> <img
                                    src="<?php echo base_url(); ?>images/googlePlus.jpg"> <?php if ($this->lang->line('signup_google') != '') {
                                echo stripslashes($this->lang->line('signup_google'));
                            } else echo "Continue with Google"; ?></a>
                    <?php }
                    if ($linkedin_id != '' && $linkedin_secert != '') { ?>
                        <a href="<?php echo base_url(); ?>linkedin-login?oauth_init=1"
                           class="googlePlus hide_signUp">
                            <img
                                    src="<?php echo base_url(); ?>images/linkedinIcon.png"> <?php if ($this->lang->line('signup_linkedin') != '') {
                                echo stripslashes($this->lang->line('signup_linkedin'));
                            } else echo "Continue with Linkedin"; ?></a>
                    <?php } ?>
                    <p class="SignupBlock"><?php if ($this->lang->line('sign_up_with') != '') {
                            echo stripslashes($this->lang->line('sign_up_with'));
                        } else echo "Sign Up With"; ?> <a
                                href="<?php echo $fbLoginUrl; ?>"><?php if ($this->lang->line('Facebook') != '') {
                                echo stripslashes($this->lang->line('Facebook'));
                            } else echo "Facebook"; ?></a><?php if ($google_id != '' && $google_secert != '') { ?>
                            <a id="sgup_tx" class=""
                               href="<?php echo $googleLoginURL; ?>"><?php if ($this->lang->line('Google') != '') {
                                    echo stripslashes($this->lang->line('Google'));
                                } else echo "Google"; ?></a> Or
                        <?php } ?> <?php if ($linkedin_id != '' && $linkedin_secert != '') { ?>
                            <a id="sgup_tx" href="<?php echo base_url(); ?>linkedin-login?oauth_init=1"
                               class=""><?php if ($this->lang->line('Linkedin') != '') {
                                    echo stripslashes($this->lang->line('Linkedin'));
                                } else echo "Linkedin"; ?></a>
                        <?php } ?></p>
                    <div class="or"><span>or</span></div>
                    <a href="#" class="email signupOpen hide_signUp"> <img
                                src="<?php echo base_url(); ?>images/emailIcon.png"><?php if ($this->lang->line('Sign_up_with_Email') != '') { echo stripslashes($this->lang->line('Sign_up_with_Email'));
                                } else echo "Sign up with Email"; ?> </a>
                    <?php
                    echo form_open('site/signupsignin/create_normal_user')
                    ?>
                    <div class="SignupBlock">
                        <p class="text-danger" id="signup_error_message"></p>
                        <p class="text-success" id="signup_success_message"></p>
                        <div class="image_box">
                            <?php 
                            if ($this->lang->line('signup_emailaddrs') != '') { $em_addr = stripslashes($this->lang->line('signup_emailaddrs')); } else $em_addr = "Email Address";
                            echo form_input('email_address', '', array("id" => "email_address", "placeholder" => $em_addr)); ?>
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        </div>
                        <div class="image_box">
                            <?php 
                            if ($this->lang->line('signup_full_name') != '') { $fn_addr = stripslashes($this->lang->line('signup_full_name')); } else $fn_addr = "First Name";
                            echo form_input('first_name', '', array("id" => "first_name", "placeholder" => $fn_addr)); ?>
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                        </div>
                        <div class="image_box">
                            <?php 
                            if ($this->lang->line('signup_user_name') != '') { $ln_addr = stripslashes($this->lang->line('signup_user_name')); } else $ln_addr = "Last Name";
                            echo form_input('last_name', '', array("id" => "last_name", "placeholder" => $ln_addr)); ?>
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                        </div>
                        <div class="image_box">
                            <?php 
                            if ($this->lang->line('create_pwd') != '') { $cr_pswd = stripslashes($this->lang->line('create_pwd')); } else $cr_pswd = "Create Password";
                            echo form_password('user_password', '', array("id" => "user_password", "placeholder" => $cr_pswd)); ?>
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </div>
                        <div class="image_box">
                            <?php
                            if ($this->lang->line('change_conf_pwd') != '') { $cnfr_pswd = stripslashes($this->lang->line('change_conf_pwd')); } else $cnfr_pswd = "Confirm Password";
                            echo form_password('user_confirm_password', '', array("id" => "user_confirm_password", "placeholder" => $cnfr_pswd)); ?>
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </div>
                        <h5><?php  if ($this->lang->line('BirthDate') != '') { echo  stripslashes($this->lang->line('BirthDate')); } else echo "Birth Day"; ?></h5>
                        <div class="reduceFont"><?php  if ($this->lang->line('signup_18older') != '') { echo  stripslashes($this->lang->line('signup_18older')); } else echo "To sign up, you must be 18 or older. Other people won’t see your
                            birthday."; ?>
                        </div>
                        <div class="row birthdayCol">
                            <div class="col-sm-5">
                                <?php
                                echo form_dropdown('birth_month', $birth_month, '', array("id" => "birth_month"));
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?php
                                echo form_dropdown('birth_day', $birth_day, '', array("id" => "birth_day"));
                                ?>
                            </div>
                            <div class="col-sm-5">
                                <?php
                                echo form_dropdown('birth_year', $birth_year, '', array("id" => "birth_year"));
                                ?>
                            </div>
                        </div>
                        <label>
        			<span class="checkboxStyle">
                        <?php echo form_checkbox('acccept_terms', 'accepted', '', array("id" => "acccept_terms", "class" => "hideTemp")); ?>
                        <i class="fa fa-check" aria-hidden="true"></i>
	        		</span>
                            <input type="hidden" name="invite_reference" id="invite_reference" value="<?= ($this->uri->segment(1)=="c"&& $this->uri->segment(2)=="invite")?$this->uri->segment(3):"0"; ?>">
                            <div class="reduceFont marginTop3"><?php if ($this->lang->line('signup_cont1') != '') {
                                    echo stripslashes($this->lang->line('signup_cont1'));
                                } else echo 'By Signing up, you confirm that you accept the'; ?>
                                <a target="_blank" data-popup="true"
                                   href="pages/terms-of-service"><?php if ($this->lang->line('header_terms_service') != '') {
                                        echo stripslashes($this->lang->line('header_terms_service'));
                                    } else echo "Terms of Service"; ?></a> <?php if ($this->lang->line('header_and') != '') {
                                    echo stripslashes($this->lang->line('header_and'));
                                } else echo "and"; ?>
                                <a target="_blank" data-popup="true"
                                   href="pages/privacy-policy"><?php if ($this->lang->line('header_privacy_policy') != '') {
                                        echo stripslashes($this->lang->line('header_privacy_policy'));
                                    } else echo "Privacy Policy"; ?></a>
                            </div>
                        </label>
                        <a class="email" style="display:none;" id="create_account_btn_loading"
                           href="javascript:void(0);"><i class="fa fa-spinner fa-spin"></i> Creating Account..</a>
                        <a href="javascript:void(0);" id="create_account_button" onclick="validate_and_create_user();"
                           class="email"> <?php if ($this->lang->line('login_signup') != '') {
                                echo stripslashes($this->lang->line('login_signup'));
                            } else echo "Create Account"; ?></a>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="bottom"></div>
                    <p><?php if ($this->lang->line('already_member') != '') {
                            echo stripslashes($this->lang->line('already_member'));
                        } else echo "Already a member?"; ?> <a href="#signIn" data-dismiss="modal"
                                                               data-toggle="modal"><?php if ($this->lang->line('header_login') != '') {
                                echo stripslashes($this->lang->line('header_login'));
                            } else echo "Log in"; ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sign In Modal -->
<div id="signIn" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="signUpIn">
                    <?php if ($facebook_id != '' && $facebook_secert != '') { ?>
                        <?php /* <a href="<?php echo $fbLoginUrl; ?>" class="faceBook hide_signUp"> <img
                                    src="<?php echo base_url(); ?>images/facebookIcon.png"> <?php if ($this->lang->line('facebook_signup') != '') {
                                echo stripslashes($this->lang->line('facebook_signup'));
                            } else echo "Continue with Facebook"; ?></a> */ ?>
                        <a href="javascript:;" onclick="fb_login()" class="faceBook hide_signUp"> <img src="<?php echo base_url(); ?>images/facebookIcon.png"> <?php if ($this->lang->line('facebook_signup') != '') { echo stripslashes($this->lang->line('facebook_signup')); } else { echo "Continue with Facebook"; } ?></a>
                    <?php }
                    if ($google_id != '' && $google_secert != '') {   ?>
                        <a href="<?php echo $googleLoginURL; ?>" class="googlePlus hide_signUp"> <img  src="<?php echo base_url(); ?>images/googlePlus.jpg"> <?php if ($this->lang->line('signup_google') != '') {
                                echo stripslashes($this->lang->line('signup_google')); } else echo "Continue with Google"; ?></a>
                    <?php }
                    if ($linkedin_id != '' && $linkedin_secert != '') { ?>
                        <a href="<?php echo base_url(); ?>linkedin-login?oauth_init=1"
                           class="googlePlus hide_signUp">
                            <img
                                    src="<?php echo base_url(); ?>images/linkedinIcon.png"> <?php if ($this->lang->line('signup_linkedin') != '') {
                                echo stripslashes($this->lang->line('signup_linkedin'));
                            } else echo "Continue with Linkedin"; ?></a>
                    <?php } ?>
                    <div class="or"><span>or</span></div>
                    <?php echo form_open(); 
					if (isset($_COOKIE['autologin'])) 
					{  
						$remembered_det = $_COOKIE['autologin']; 
						$checked_status = 'checked="checked"'; 
						$decodeJson =  json_decode($remembered_det, true);
						$cookie_email = $decodeJson['email'];
						$cookie_paswd = $decodeJson['password'];
					} 
					else 
					{ 
						$remembered_det='';
						$checked_status = ''; 
						$cookie_email = '';
						$cookie_paswd = '';
					}
					//$decodeJson =  json_decode($json, true);
					//echo ;
					//$json = json_encode($rememberArray);
					?>
                    <p class="text-danger" id="signin_error_message"></p>
                    <p class="text-success" id="signin_success_message"></p>
                    <div class="image_box">
                        <?php 
						
						
                        if ($this->lang->line('Enter_Email') != '') { $ent_eml = stripslashes($this->lang->line('Enter_Email')); } else {$ent_eml = 'Enter Email'; }
                            echo form_input('user_email', $cookie_email, array('id' => 'login_email_address', 'placeholder' => $ent_eml)); ?>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    </div>
                    <div class="image_box">
                        <?php
                        if ($this->lang->line('Enter_Password') != '') { $ent_psd = stripslashes($this->lang->line('Enter_Password')); } else {$ent_psd = 'Enter Password'; }
                        echo form_password('user_password', $cookie_paswd, array('id' => 'login_password', "class" => "password_l", 'placeholder' => $ent_psd)); ?>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </div>
                    <div class="remember clear">
                        <div class="left">
                            <label>
	        			<span class="checkboxStyle">
	        				<input type="checkbox" name="remember_me" id="remember_meChkBox" class="hideTemp" <?php echo $checked_status;?>>
		        			<i class="fa fa-check" aria-hidden="true"></i>
		        		</span>
                                <?php if ($this->lang->line('remember_me') != '') {
                                    echo stripslashes($this->lang->line('remember_me'));
                                } else echo "Remember Me"; ?>
                            </label>
                        </div>
                        <div class="right">
                            <a href="#" class="showPass"><?php if ($this->lang->line('Show_Password') != '') {
                                    echo stripslashes($this->lang->line('Show_Password'));
                                } else echo "Show Password"; ?></a>
                        </div>
                    </div>
					
                    <a href="javascript:void(0);" class="email" onclick="javascript:user_login();"><?php if ($this->lang->line('Log_in') != '') { echo stripslashes($this->lang->line('Log_in'));  } else echo "Log in"; ?></a>
                    <a href="#forgotPassword" class="forgotPass" data-dismiss="modal" data-toggle="modal"><?php if ($this->lang->line('forgot_passsword') != '') { echo stripslashes($this->lang->line('forgot_passsword'));
                                } else echo "Forgot Passsword ?"; ?></a>
                    <div class="bottom"></div>
                    <p><?php if ($this->lang->line('dont_have_account') != '') { echo stripslashes($this->lang->line('dont_have_account')); } else echo "Don’t have an account?"; ?> <a href="#signUp" data-dismiss="modal" data-toggle="modal"><?php if ($this->lang->line('signup') != '') { echo stripslashes($this->lang->line('signup')); } else echo "Sign Up"; ?></a></p>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script>
$('#login_password').keypress(function(e) {
    if (e.which == '13') {
        user_login();
    }
});
</script>
<!-- Sign In Modal -->
<div id="forgotPassword" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <?php echo form_open(''); ?>
                <div class="signUpIn">
                    <h3><?php if ($this->lang->line('forgot_reset_pwd') != '') {
                            echo stripslashes($this->lang->line('forgot_reset_pwd'));
                        } else echo "Reset Password"; ?></h3>
                    <p class="resetPassDesc"><?php if ($this->lang->line('contant_reset_pwd') != '') {
                            echo stripslashes($this->lang->line('contant_reset_pwd'));
                        } else echo "Enter the email address associated with your account, and we'll email you a link to reset your password."; ?></p>
                    <p class="text-danger" id="forgot_pass_error"></p>
                    <p class="text-success" id="forgot_pass_success"></p>
                    <div class="image_box">
                        <?php echo form_input('forgot_email', '', array('id' => 'forgot_pass_email', 'placeholder' => 'Enter Email')); ?>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    </div>
                    <div class="remember clear">
                        <div class="left">
                            <a href="#signIn" class="bckToLogin" data-dismiss="modal" data-toggle="modal"> <span
                                        class="number_s">  </span> <?php if ($this->lang->line('back_to_login') != '') {
                                    echo stripslashes($this->lang->line('back_to_login'));
                                } else echo "Back to Login"; ?> </a>
										
										
                        </div>
                        <div id='loadingmessage'>
                          <img width='50px' src='<?php echo base_url(); ?>images/spinner.gif'/>
                        </div>
                        <div class="right">
                            <a href="javascript:void(0);" onclick="javascript:forgot_pass_mail();"
                               class="email"> <?php if ($this->lang->line('send_reset_pwd') != '') {
                                    echo stripslashes($this->lang->line('send_reset_pwd'));
                                } else echo "Send Reset Link"; ?> </a>
                        </div>
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>
<!--Wish List Adding and creating-->
<div id="contactHost" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row" id="WishlistFormContainer">
                </div>
            </div>
        </div>
    </div>
</div>


	<?php 
				if ($this->lang->line('pls_enter_email') != '') {
					$entr_email= stripslashes($this->lang->line('pls_enter_email'));
				} else {
					$entr_email= "Please Enter Email Address";
				} 
	?>
	<input type="hidden" name="" id="entr_email" value="<?php echo $entr_email; ?>">
	
	
	<?php 
				if ($this->lang->line('pls_enter_email_valid') != '') {
					$valid_email= stripslashes($this->lang->line('pls_enter_email_valid'));
				} else {
					$valid_email= "Please Enter Valid Email Address";
				} 
	?>
	<input type="hidden" name="" id="valid_email" value="<?php echo $valid_email; ?>">
	
	<?php 
				if ($this->lang->line('pls_enter_passwrd') != '') {
					$enter_paswrd= stripslashes($this->lang->line('pls_enter_passwrd'));
				} else {
					$enter_paswrd= "Please Enter Password";
				} 
	?>
	<input type="hidden" name="" id="enter_paswrd" value="<?php echo $enter_paswrd; ?>">
	
	<?php 
				if ($this->lang->line('paswrd_must') != '') {
					$paswrd_must= stripslashes($this->lang->line('paswrd_must'));
				} else {
					$paswrd_must= "Password must contain 1 digit,1 Uppercase and Lowercase letters and 6 Digit";
				} 
	?>
	<input type="hidden" name="" id="paswrd_must" value="<?php echo $paswrd_must; ?>">
	
	<?php 
				if ($this->lang->line('pls_entr_first_name') != '') {
					$entr_first= stripslashes($this->lang->line('pls_entr_first_name'));
				} else {
					$entr_first= "Please Enter First Name";
				} 
	?>
	<input type="hidden" name="" id="entr_first" value="<?php echo $entr_first; ?>">
	
	<?php 
				if ($this->lang->line('pls_entr_last_name') != '') {
					$entr_first= stripslashes($this->lang->line('pls_entr_last_name'));
				} else {
					$entr_first= "Please Enter Last name";
				} 
	?>
	<input type="hidden" name="" id="entr_last" value="<?php echo $entr_last; ?>">
	
	<?php 
				if ($this->lang->line('pls_entr_confirm_paswrd') != '') {
					$entr_first= stripslashes($this->lang->line('pls_entr_confirm_paswrd'));
				} else {
					$entr_first= "Please Enter Confirm Password";
				} 
	?>
	<input type="hidden" name="" id="confirm_pas" value="<?php echo $confirm_pas; ?>">
	
	<?php 
				if ($this->lang->line('confirm_paswrd_not_matched') != '') {
					$not_matched= stripslashes($this->lang->line('confirm_paswrd_not_matched'));
				} else {
					$not_matched= "Password and Confirm Password not matched";
				} 
	?>
	<input type="hidden" name="" id="not_matched" value="<?php echo $not_matched; ?>">
	
	<?php 
				if ($this->lang->line('must_accept_term') != '') {
					$must_accept= stripslashes($this->lang->line('must_accept_term'));
				} else {
					$must_accept= "Must accept our terms and conditions";
				} 
	?>
	<input type="hidden" name="" id="must_accept" value="<?php echo $must_accept; ?>">
	<input type="hidden" id="to_url_value" value="<?php echo current_url();?>"/>

<script>
    function validate_and_create_user() {
		var enter_emailS=$("#entr_email").val();
		var enter_email_valS=$("#valid_email").val();
		var entr_firstS=$("#entr_first").val();
		var entr_lastS=$("#entr_last").val();
		var entr_paswrdS=$("#enter_paswrd").val();
		var must_containS=$("#paswrd_must").val();
		var confirmS=$("#confirm_pas").val();
		var not_matchedS=$("#not_matched").val();
		var must_accept=$("#must_accept").val();
		
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        var email_address = $("#email_address").val();
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var user_password = $("#user_password").val();
        var birth_month = $("#birth_month").val();
        var birth_day = $("#birth_day").val();
        var birth_year = $("#birth_year").val();
        var invite_reference = $("#invite_reference").val();
        var user_confirm_password = $("#user_confirm_password").val();
        var acccept_terms = $("#acccept_terms");
        if (email_address == "") {
            $("#email_address").focus();
            $("#signup_error_message").html(enter_emailS)
            return false;
        } else if (!filter.test(email_address)) {
            $("#email_address").focus();
            $("#signup_error_message").html(enter_email_valS)
            return false;
        } else if (first_name == "") {
            $("#first_name").focus();
            $("#signup_error_message").html(entr_firstS)
            return false;
        } else if (last_name == "") {
            $("#last_name").focus();
            $("#signup_error_message").html(entr_lastS)
            return false;
        } else if (user_password == "") {
            $("#user_password").focus();
            $("#signup_error_message").html(entr_paswrdS)
            return false;
        } else if (!user_password.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}$/)) {
            $("#user_password").focus();
            $("#signup_error_message").html(must_containS)
            return false;
        } else if (user_confirm_password == "") {
            $("#user_confirm_password").focus();
            $("#signup_error_message").html(confirmS)
            return false;
        } else if (user_confirm_password != user_password) {
            $("#user_confirm_password").focus();
            $("#signup_error_message").html(not_matchedS)
            return false;
        } else if (acccept_terms.not(":checked").length) {
            $("#acccept_terms").focus();
            $("#signup_error_message").html(must_accept)
            return false;
        } else {
            $("#create_account_button").hide();
            $("#create_account_btn_loading").show();
            $("#signup_error_message").html("");
            $.post("<?= base_url(); ?>site/signupsignin/create_normal_user", {
                email_address: email_address,
                first_name: first_name,
                birth_month: birth_month,
                birth_day: birth_day,
                birth_year: birth_year,
                invite_reference: invite_reference,
                user_password: user_password,
                last_name: last_name
            }, function (result) {
                var data = result.split("::");
                if (data[0] == "Success") {
                    var redirect_to = $('#to_url_value').val();
                    window.location.href = '<?= base_url(); ?>' + redirect_to;
                    $("#signup_success_message").html(data[1])
                    $("#signup_error_message").html("");
                } else {
                    $("#create_account_btn_loading").hide();
                    $("#create_account_button").show();
                    $("#signup_error_message").html(data[1]);
                    $("#signup_success_message").html("");
                }
            });
            return true;
        }
    }

    function user_login() {
		var enter_email=$("#entr_email").val();
		var valid_email=$("#valid_email").val();
		var enter_paswrd=$("#enter_paswrd").val();
		var paswrd_must=$("#paswrd_must").val();
		
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        var email_address = $("#login_email_address").val();
        var user_password = $("#login_password").val();
		var remember_me = $('#remember_meChkBox').is(":checked");
        if (email_address == "") {
            $("#login_email_address").focus();
            $("#signin_error_message").html(enter_email)
            return false;
        } else if (!filter.test(email_address)) {
            $("#login_email_address").focus();
            $("#signin_error_message").html(valid_email)
            return false;
        } else if (user_password == "") {
            $("#login_password").focus();
            $("#signin_error_message").html(enter_paswrd)
            return false;
        } else if (!user_password.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}$/)) {
            $("#login_password").focus();
            $("#signin_error_message").html(paswrd_must)
            return false;
        } else {
            $("#signin_error_message").html("");
            $.post("<?= base_url(); ?>site/signupsignin/login_normal_user", {
                email_address: email_address,
                user_password: user_password,
				remember_me:remember_me
            }, function (result) {
                var data = result.split("::");
                
                if ($.trim(data[0])=='Success') {
                   
                    var redirect_to = $('#to_url_value').val();
                    window.location.href = '<?= base_url(); ?>' + redirect_to;
                    $("#signin_success_message").html(data[1]);
                    $("#signin_error_message").html("");
                    
                } else {
                   
                    $("#signin_error_message").html(data[1]);
                    $("#signin_success_message").html("");
					$("#login_email_address").val('').focus();
					$("#login_password").val('').focus();
                }
                //location.reload();
            });
            return true;
        }
    }

    function forgot_pass_mail() {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        var email_address = $("#forgot_pass_email").val();
        if (email_address == "") {
            $("#forgot_pass_email").focus();
            $("#forgot_pass_error").html("Please Enter Email Address")
            return false;
        } else if (!filter.test(email_address)) {
            $("#forgot_pass_email").focus();
            $("#forgot_pass_error").html("Please Enter Valid Email Address")
            return false;
        } else {
            $('#loadingmessage').show();
            $("#forgot_pass_error").html("");
            $.post("site/signupsignin/send_password_to_mail", {
                email_address: email_address
            }, function (result) {
                var data = result.split("::");
                $('#loadingmessage').hide();
                if (data[0] == "Success") {
                    
                    $("#forgot_pass_success").html(data[1])
                    $("#signin_error_message").html("");
                } else {
                    $("#forgot_pass_error").html(data[1]);
                    $("#forgot_pass_success").html("");
                }
            });
            return true;
        }
    }

    /*Loading wishlist form*/
    function loadWishlistPopup(rentalId) {
        $('#contactHost').modal('show');
        $('#WishlistFormContainer').html('<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</p>');
        $.get("<?php echo base_url(); ?>site/rentals/AddWishListForm/" + rentalId, function (data) {
            $('#WishlistFormContainer').html(data);
        });
    }

    /*Loading wishlist form for experience*/
    function loadExperienceWishlistPopup(rentalId) {
        $('#contactHost').modal('show');
        $('#WishlistFormContainer').html('<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</p>');
        $.get("<?php echo base_url(); ?>site/experience/AddWishListForm/" + rentalId, function (data) {
            $('#WishlistFormContainer').html(data);
        });
    }

    /*Setting Language and currency*/
    function changeLanguage(e) {
        var strUser = e.options[e.selectedIndex].value;
        window.location.href = strUser;
    }

    function changeCurrency(e) {
        var strUser = e.options[e.selectedIndex].value;
        window.location.href = strUser;
    }

    function set_signup_and_login_link(link_to) {
        $("#to_url_value").val(link_to);
        $.post("<?= base_url(); ?>site/user/set_redirect_session", {'to_url': link_to});
    }
</script>
<script type="text/javascript">
    $(function () {
		$("body").tooltip({ selector: '[data-toggle=tooltip]' });
    });
</script>