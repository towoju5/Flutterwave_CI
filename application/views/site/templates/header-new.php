<?php 
error_reporting(1);
$google_login_type = $_SESSION['login_type'];
$normal_login_type = $_SESSION['normal_login'];
$linkedin_login_type = $_SESSION['linked_in_login'];
$facebook_login_type = $_SESSION['facebook_in_login'];
$facebook_id = $_SESSION['f_id'];
$google_id = $_SESSION['google_id'];
$fg_id = $_SESSION['fc_session_user_id'];
$cur_URL = 'http';
if ($_SERVER["HTTPS"] == "on") {$cur_URL .= "s";}
	$cur_URL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
	$cur_URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} else {
	$cur_URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}
$_SESSION['currentpage_url'] = $cur_URL;

?>
<!DOCTYPE html><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if($this->config->item('google_verification')){ echo stripslashes($this->config->item('google_verification')); }if ($heading == ''){?>
<title><?php echo $title;?></title><?php }else {?><title><?php echo $heading;?></title><?php }?><meta property="og:image" content="<?php echo base_url(); ?>images/logo/<?php echo $this->config->item('logo_image');?>"/>
<?php if($_SESSION['language_code']=="ar")
{ 
?>
<meta name="title" content="<?php echo $meta_title_arabic;?>" />
<meta name="keywords" content="<?php echo $meta_keyword_arabic; ?>" />
<meta name="description" content="<?php echo $meta_description_arabic; ?>" />
<?php } else {?>
<meta name="title" content="<?php echo $meta_title;?>" />
<meta name="keywords" content="<?php echo $meta_keyword; ?>" />
<meta name="description" content="<?php echo $meta_description; ?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, user-scalable=no">
<link rel="shortcut icon" type="image/x-icon" href="images/logo/<?php echo $this->config->item('fevicon_image'); ?>"><base href="<?php echo base_url(); ?>"/><?php $by_creating_accnt = str_replace("{SITENAME}",$siteTitle);	if($_SESSION['language_code']=="ar") { $this->load->view('site/templates/css_files-arabic',$this->data);} else {$this->load->view('site/templates/css_files',$this->data);} ?><script type="text/javascript" src="js/site/1.10.min.js"></script><script type="text/javascript" src="js/site/bootstrap.min.js"></script><script type="text/javascript" src="js/site/bootstrap.js"></script><script type="text/javascript" src="js/site/slider-contact.js"></script><script type="text/javascript" src="js/toggle-slide.js"></script>

<script type="text/javascript" src="js/site/jquery.colorbox.js"></script>
<?php
if($_SESSION['language_code']=="ar")
{
?>
<script type="text/javascript" src="js/site/jquery-ui-arabic.js"></script>
<?php } else {?><script type="text/javascript" src="js/site/jquery-ui.js"></script><?php } ?>
<?php	$this->load->view('site/templates/script_files',$this->data);?><link rel="stylesheet" type="text/css" href="css/site/twitter-bootstrap.css"><link rel="stylesheet" type="text/css" href="css/site/bootstrap-min.css">
<?php
if($_SESSION['language_code']=="ar")
{
?>
<link rel="stylesheet" media="all" href="css/main-arabic.css" type="text/css" />
<link rel="stylesheet" media="all" href="css/style-arabic.css" type="text/css" />
<?php } else{?>
<link rel="stylesheet" media="all" href="css/site/themes-smoothness-jquery-ui.css" type="text/css" />
<link rel="stylesheet" media="all" href="css/site/New_CSS.css" type="text/css" />
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
<!--<link rel="stylesheet" media="all" href="css/style.css" type="text/css" />-->
<?php } ?>
<link rel="stylesheet" media="all" href="<?php echo base_url(); ?>css/popup-contact.css" type="text/css" /><link rel="stylesheet" media="all" href="css/font-awesome.css" type="text/css" />
<link rel="stylesheet" media="all" href="css/site/style-invite.css" type="text/css" />
<link rel="stylesheet" href="css/style_common.css"><link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet"><link rel="stylesheet" href="css/style7.css"><link rel="stylesheet" media="all" href="css/help-style.css" type="text/css" />
<!--
<link rel="stylesheet" media="all" href="css/popup2.css" type="text/css" />

--->
<!--[if lt IE 8]>
<script type="text/javascript" src="js/html5shiv/dist/html5shiv.js"></script>
<![endif]-->
<!--
<style type="text/css">.btn,button,input[type=button],input[type=reset],input[type=submit]{cursor:pointer}.popup_facebook,.popup_sub_header{font-family:Arial,Helvetica,sans-serif}.btn,.popup_facebook,.popup_signup_or{display:inline-block}.popup_header{background-color:#EFEFEF;border-bottom:1px solid #DBDBDB;font-size:15px;font-weight:700;font-family:Arial,Helvetica,sans-serif;color:#393C3D;padding:10px 15px}.popup_sub_header{font-size:13px;font-weight:400;color:#393C3D;padding:8px 0}.banner_signup{text-align:center;margin:20px;font-size: 14px;}.sigup a{color:#F44336 !important;}.sigup a:hover{color:#F44336 !important;cursor:pointer}.popup_facebook{background:url(images/facebook.png) no-repeat;color:#FFF;cursor:pointer;font-size:14px;font-weight:700!important;line-height:37px;margin:0;padding:0 35px 0 80px;text-indent:initial}.popup_facebook:hover{background:Url("images/facebook.png") no-repeat;text-decoration:none}.popup_page{background:#fff;overflow:hidden}.popup_signup_or{margin:10px 0;text-align:center;width:100%}.btn.large{font-size:16px}.mail-btn{background:url(images/mail-bg.png) repeat-x rgba(0,0,0,0)!important;border:1px solid #1689c7!important;border-radius:2px!important;color:#fff;font-size:14px!important;line-height:17px!important;padding:8px 0!important;text-shadow:none!important;text-transform:capitalize;width:275px}.btn,.btn-primary{background-repeat:repeat-x;color:#fff;text-shadow:0 -1px 0 rgba(0,0,0,.2)}.btn{-moz-user-select:none;white-space:nowrap;-moz-border-bottom-colors:none;-moz-border-left-colors:none;-moz-border-right-colors:none;-moz-border-top-colors:none;background-color:#018fe1;background-image:-moz-linear-gradient(center top ,#018fe1,#00aeff);border-color:#0195eb #0083c7 #0175b8;border-image:none;border-radius:5px!important;border-style:solid;border-width:1px;box-shadow:0 0 .2em rgba(255,255,255,.2) inset,0 1px 2px rgba(0,0,0,.2),0 0 0 #000;box-sizing:border-box;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:12px;font-weight:700;line-height:16px;margin-bottom:0;padding:.4em 1.8em;text-align:center;text-transform:uppercase;vertical-align:middle}.btn-primary{background-color:#2badf3;background-image:-moz-linear-gradient(center top ,#2badf3,#2492db);border:1px solid #106fa9;box-shadow:0 1px 2px 0 rgba(0,0,0,.18),0 0 1px 1px rgba(255,255,255,.09) inset}.btn-large{font-size:15px;padding:9px 18px}.btn-block{display:block;white-space:normal;width:100%}.popup_page p{text-align:left!important}.popup_stay{border-top:1px solid #dbdbdb;color:#393c3d;display:inline-block;float:left;font-family:Arial,Helvetica,sans-serif;font-size:13px;margin:0;padding:10px 0 12px 20px!important;width:100%}.all-link{color:#00b0ff;font-size:15px}p{margin:0;padding:0}.decorative-input,.decorative-input1{background-position:right 5px;background-repeat:no-repeat;box-sizing:border-box;display:block;height:40px;padding:0 10px;width:95%!important}a{outline:0}.decorative-input{background-image:url(images/site/EMAIL.png);font-size:15px;line-height:30px}input,select,textarea{transition:border .2s linear 0s,box-shadow .2s linear 0s}button,input,select,textarea{margin:0;vertical-align:middle;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif}button,input,label,select,textarea{font-size:13px;font-weight:400;line-height:18px}.uneditable-input,input,select,textarea{line-height:18px}.decorative-input1{background-image:url(images/site/lock.png);font-size:15px;line-height:30px}.next_button,button,input{line-height:normal}.all-link1{color:#00b0ff;float:right;font-size:13px;margin:10px 0}.uneditable-input,input,select,textarea{background-color:#fff;border:1px solid #cdcdcd;border-radius:3px;box-shadow:0 1px 1px 0 rgba(0,0,0,.08) inset,0 1px 0 0 #fff;color:#959595;display:inline-block;font-size:13px;margin-bottom:9px;padding:6px 9px;width:210px}#cboxClose{right:-4px;top:3px}.slide-out-div{padding:20px;width:255px;background:#ccc;border:0 solid #29216d;z-index:999999999999999999!important;height:196px!important}.border{border:2px solid #29216d;margin-left:-11px;margin-right:-14px;margin-top:-12px;padding-bottom:25px}.whatsapp-content{padding-top:30px;padding-left:10px}#slideout{position:fixed;top:230px;left:0;width:35px;padding:12px 0;text-align:center;background:#373180;-webkit-transition-duration:.3s;-moz-transition-duration:.3s;transition-duration:.3s;-o-transition-duration:.3s;-webkit-border-radius:0 5px 5px 0;-moz-border-radius:0 5px 5px 0;border-radius:0 5px 5px 0;z-index:999999999999}#slideout_inner{position:fixed;top:230px;left:-285px;background:#D5E0D4;width:285px;padding:25px;height:243px;-webkit-transition-duration:.3s;-moz-transition-duration:.3s;transition-duration:.3s;-o-transition-duration:.3s;text-align:left;-webkit-border-radius:0 0 5px;-moz-border-radius:0 0 5px;border-radius:6px}#slideout_inner textarea{width:190px;height:100px;margin-bottom:6px}#slideout:hover{left:285px}#slideout:hover #slideout_inner{left:0}.pre-header{width:100%;height:30px;background-color:#BB8E04;z-index:99999999999999;position:fixed;opacity:.9}a.request-trip1{background:#A80128;border-radius:4px;color:#fff;font-family:opensansSemibold;font-size:15px;margin:26px 10px 30px;padding:7px;text-align:center;text-shadow:0 0 0 #ccc;width:50px;transition-duration:.5s}a:hover{text-decoration:none;}.Send-decline{background:rgba(34,93,181,.87)!important}.next_button{width:50%;float:right}a.popul:hover{color: #fff !important;}
</style>-->

<!--<link rel="stylesheet" media="all" href="css/bug-fixed.css" type="text/css" />--->
<script>
jQuery.fn.extend({ propAttr: $.fn.prop || $.fn.attr}); 
$(function() {$("#autocomplete,#city_landing").autocomplete({source: function( request, response ) {$( "#autoCompImg" ).show();
$.ajax({url: "<?php echo base_url();?>site/landing/home_search_auto",
            dataType: "json",
            data: {
			term : request.term,
            tableName : "city"
			},
            success: function(data) {
                    response(data);
					$( "#autoCompImg" ).hide();
            }
        });
    },
	change: function (event, ui) {
            if (!ui.item) {
                this.value = '';
            }
        },
		select: function(event,ui){
		
		var city=ui.item.value;
		city=city.replace(" ", "+");
		if($(this).attr('id')=='autocomplete')
		{
		window.location='<?php echo base_url()?>property?city='+city+'';
		}
		
        
    },
	min_length: 10,
    delay: 1

});
});
</script>
<!--<script src="js/tabcontent.js"></script>--->
<script src="js/site/jquery.tabSlideOut.v1.3.js"></script>
 
  
<!-- Autosuggestion Script End-->
<style type="text/css">
.morecontent span {
    display: none;
}
.morelink {
    display: inline-block;
	cursor:pointer;
}
#message {
    font-size: 10px;
    text-align: left;
}

</style>    
</head>

<body <?php if($this->uri->segment(1) == 'property' ){echo 'onload="initialize();"'; } else {echo 'onload="initializeMap()"';} ?> >

<?php



 if (is_file('google-login-mats/index.php'))
{
	require_once 'google-login-mats/index.php';
}
$newAuthUrl = $authUrl;
$userdata = array('newAuthUrl'=>$newAuthUrl);
$this->session->set_userdata($userdata);

$this->session->userdata('rUrl');

if($this->session->userdata('rUrl') != '')
{
$reUrl = $this->session->userdata('rUrl');
$this->session->unset_userdata('rUrl');
redirect ($reUrl);
}
//echo $authUrl;
?>

<!--<link rel="stylesheet" type="text/css" media="all" href="css/new-customization.css" />-->


<!-- scroll top start -->
<div class="scrollToTop" style="display: none;">
	<img src="images/topArrow.png" width="42">
</div>

<script type="text/javascript">

	$(window).scroll(function (event) {
	    var scroll = $(window).scrollTop();
	    if(scroll > 350){
	    	$(".scrollToTop").show();
	    }
	    else{
	    	$(".scrollToTop").hide();	
	    }
	});

	$(document).on("click",".scrollToTop", function(){
		$("html, body").animate({ scrollTop: 0 }, "slow");
	});
</script>
<!-- scroll top End-->


<!-- Popup_signin_start -->
<div style='display:none'>

  <div id='inline_login' style='background:#fff;'>
		<div id="login_error" style="background:grey; display:none;"></div>
  		<div class="popup_page">
 
  			<div class="popup_header"><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "Log in"; ?></div>
            
			<script>
			function fbLogon()
			{
				var datefrom = $("#datefrom").val();
				var expiredate = $("#expiredate").val();
				var number_of_guests = $("#number_of_guests").val();
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
				$.ajax(
				{
				type: 'POST',
				url: "<?php echo base_url();?>site/landing/fbLogin",
				data: { rUrl : "<?php echo $pageURL;?>",datefrom : datefrom,expiredate : expiredate,number_of_guests: number_of_guests },
				success: function(data) 
				{		
					window.location.href='<?php echo $pageURL;?>';
				}
				});
			}
			function gglLogon()
			{
				var datefrom = $("#datefrom").val();
				var expiredate = $("#expiredate").val();
				var number_of_guests = $("#number_of_guests").val();
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
				$.ajax(
				{
				type: 'POST',
				url: "<?php echo base_url();?>site/landing/fbLogin",
				data: { rUrl : "<?php echo $pageURL;?>",datefrom : datefrom,expiredate : expiredate,number_of_guests: number_of_guests },
				success: function(data) 
				{		//alert(data);
					window.location.href='<?php echo $authUrl; ?>';
				}
				});
			}
			function linkedin_login() {
			
				var datefrom = $("#datefrom").val();
				var expiredate = $("#expiredate").val();
				var number_of_guests = $("#number_of_guests").val();
				window.location = "<?php echo base_url();?>site/invitefriend/login?datefrom="+datefrom+"&expiredate="+expiredate+"&number_of_guests="+number_of_guests;
			}
			</script>

<?php ?>
			
            <div class="popup_detail">
            
            	<div class="banner_signup">
							<?php
		            	    $facebook_id = $this->config->item('facebook_app_id');
						    $facebook_secert = $this->config->item('facebook_app_secret'); 
							$linkedin_id = $this->config->item('linkedin_app_id');
							$linkedin_secert = $this->config->item('linkedin_app_key');
							$google_id = $this->config->item('google_client_id');
							$google_secert = $this->config->item('google_client_secret'); ?>			
							
							<?php if ($facebook_id !='' && $facebook_secert !='') { ?>
                                <a href="javascript:void(0);" onclick="fb_login();" class="popup_facebook"><?php if($this->lang->line('login_facebook') != '') { echo stripslashes($this->lang->line('login_facebook')); } else echo "Login with Facebook"; ?></a> 				
							<?php } if($linkedin_id !='' && $linkedin_secert !='') { ?>
							<!--href="<?php echo base_url();?>site/invitefriend/login?datefrom="-->
								<a href="javascript:void(0);" onclick="linkedin_login();"  class="popup_linkedin" ><?php if($this->lang->line('login_linkedin') != '') { echo stripslashes($this->lang->line('login_linkedin')); } else echo "Login with Linkedin"; ?></a>
							<?php } if($google_id !='' && $google_secert !='') { ?>
                                 <a href="javascript:void(0);" class="popup_google" onclick="gglLogon();"><?php if($this->lang->line('login_google') != '') { echo stripslashes($this->lang->line('login_google')); } else echo "Login with Google"; ?></a>
							<?php } ?>
								 <span class="popup_signup_or"><?php if($this->lang->line('OR') != '') { echo stripslashes($this->lang->line('OR')); } else echo "OR"; ?></span>
                                 
                                 <input type="text" name="email" id="signin_email_address" value="" class="decorative-input" placeholder="<?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address"; ?>" onblur="if(this.value=='')this.value=this.defaultValue;"  />
                                 
                                 <input type="password" id="signin_password"  placeholder="<?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?>" value="" class="decorative-input1" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                 
								 <input type="hidden" name="bpath" id="bpath" value="<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>" />
								 
                                <span class="popup_stay"><input class="check" id="remember" type="checkbox" /><?php if($this->lang->line('remember_me') != '') { echo stripslashes($this->lang->line('remember_me')); } else echo "Remember Me";?></span>
                                 <a href="javascript:void(0);" class="all-link1 forgot-popup"><?php if($this->lang->line('forgot_passsword') != '') { echo stripslashes($this->lang->line('forgot_passsword')); } else echo "Forgot Password"; ?>?</a>
                                 <button class="btn btn-block btn-primary large btn-large padded-btn-block" type="submit" onclick="javascript:signin();" id="signin_click" ><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "Log in"; ?></button>
                                 <span class="popup_stay" style="text-align:center!important;margin-bottom:10px;width:100% !important;"><?php if($this->lang->line('dont_account') != '') { echo stripslashes($this->lang->line('dont_account')); } else echo "Don't have an account?"; ?><a href="javascript:void(0);" style="font-size:13px;float:none !important; margin:0 0 0 3px" class="all-link reg-popup"><?php if($this->lang->line('login_signup') != '') { echo stripslashes($this->lang->line('login_signup')); } else echo "Create  Account"; ?></a></span>
                            </div>
                    
                    	
            </div>
     
        </div>
        
  </div>
  
</div>


<div style='display:none'>

  <div id='inline_reg' style='background:#fff;'>
  
  		<div class="popup_page">
  
  			<div class="popup_header"><?php if($this->lang->line('login_signup') != '') { echo stripslashes($this->lang->line('login_signup')); } else echo "Create  Account"; ?></div>
            
            <div class="popup_detail">
            
            	<div class="banner_signup">
                            	
                              <?php if ($facebook_id !='' && $facebook_secert !='') { ?>             	
                                <a class="popup_facebook" onclick="fb_login()"><?php if($this->lang->line('facebook_signup') != '') { echo stripslashes($this->lang->line('facebook_signup')); } else echo "Continue with Facebook"; ?></a>							<?php }	
								if($linkedin_id !='' && $linkedin_secert !='') { ?>	<!--href="<?php echo base_url();?>site/invitefriend/login" -->
								<a href="javascript:void(0);" onclick="linkedin_login();" class="popup_linkedin" ><?php if($this->lang->line('signup_linkedin') != '') { echo stripslashes($this->lang->line('signup_linkedin')); } else echo "Continue with Linkedin"; ?></a>								<?php }							if($google_id !='' && $google_secert !='') { ?>								
                                <a class="popup_google" onclick="gglLogon();" ><!-- onclick="window.location.href='<?php echo $authUrl; ?>'"--><?php if($this->lang->line('signup_google') != '') { echo stripslashes($this->lang->line('signup_google')); } else echo "Continue with Google"; ?></a>								<?php } ?>
                                	
                                 <span class="popup_signup_or"><?php if($this->lang->line('OR') != '') { echo stripslashes($this->lang->line('OR')); } else echo "OR"; ?></span>
                                 <button class="btn btn-block btn-primary large btn-large padded-btn-block mail-btn register-popup" type="submit"><?php if($this->lang->line('signup_email') != '') { echo stripslashes($this->lang->line('signup_email')); } else echo "Sign up with Email"; ?></button>
                                 <p style="font-size:13px; margin:10px 0; color:#959595;"><?php if($this->lang->line('signup_cont1') != '') { echo stripslashes($this->lang->line('signup_cont1')); } else echo 'By Signing up, you confirm that you accept the';?> <a target="_blank" data-popup="true" href="pages/terms-of-service"><?php if($this->lang->line('header_terms_service') != '') { echo stripslashes($this->lang->line('header_terms_service')); } else echo "Terms of Service";?></a> <?php if($this->lang->line('header_and') != '') { echo stripslashes($this->lang->line('header_and')); } else echo "and"; ?> <a target="_blank" data-popup="true" href="pages/privacy-policy"><?php if($this->lang->line('header_privacy_policy') != '') { echo stripslashes($this->lang->line('header_privacy_policy')); } else echo "Privacy Policy";?></a>.</p>
                    </div>
                    </div>
        		<span class="popup_stay"><?php if($this->lang->line('already_member') != '') { echo stripslashes($this->lang->line('already_member')); } else echo "Already a member?";?><a href="javascript:void(0);" style="font-size:13px; margin:0 0 0 3px" class="all-link login-popup"><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "Log in"; ?></a></span>
        </div>
        
  </div>
  
</div>

<!-- contact me popupwindow -->
<!-- contact me popupwindow -->


<div style='display:none'>

  <div id='inline_register' style='background:#fff;'>
  
  		<div class="popup_page">
  
  			<div class="popup_header"><?php if($this->lang->line('login_signup') != '') { echo stripslashes($this->lang->line('login_signup')); } else echo "Create Account"; ?></div>
            
            <div class="popup_detail">
            
            	<div class="banner_signup sigup">
                                           								

<?php if($this->lang->line('sign_up_with') != '') { echo stripslashes($this->lang->line('sign_up_with')); } else echo "Sign Up With"; ?>
<?php if($google_id !='' && $google_secert !='') { ?>
 <a id="sgup_tx" class="" onclick="window.location.href='<?php echo $authUrl; ?>'"><?php if($this->lang->line('Google') != '') { echo stripslashes($this->lang->line('Google')); } else echo "Google"; ?></a>, 
<?php } ?>

 <?php //if ($facebook_id !='' && $facebook_api !='') { ?>  							 
                                <a id="sgup_tx" class="" onclick="fb_login()"><?php if($this->lang->line('Facebook') != '') { echo stripslashes($this->lang->line('Facebook')); } else echo "Facebook"; ?></a>,								
<?php //}	?> 
<?php if($linkedin_id !='' && $linkedin_secert !='') { ?>																<a id="sgup_tx" href="<?php echo base_url();?>site/invitefriend/login" class="" ><?php if($this->lang->line('Linkedin') != '') { echo stripslashes($this->lang->line('Linkedin')); } else echo "Linkedin"; ?></a>
<?php  } ?>


 								
                                 <span class="popup_signup_or"><?php if($this->lang->line('OR') != '') { echo stripslashes($this->lang->line('OR')); } else echo "OR"; ?></span>
                                 
                                 <input type="text" id="first_name" value="<?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "First name"; ?>" class="decorative-input2" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                 <input type="text" id="last_name" value="<?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Last name"; ?>" class="decorative-input2" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                 
                                 <input type="text" id="email" value="<?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address"; ?>" class="decorative-input" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                 <div id="emailalert" style="display:none; color:red; ; font-weight:bold; padding-bottom:8px;" align="left"><?php if($this->lang->line('Email_Id_already_exist') != '') { echo stripslashes($this->lang->line('Email_Id_already_exist')); } else echo "Email Id already exist";?></div>
                                 <input type="password" id="password" value=""  placeholder="<?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?>" class="decorative-input1" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                  <input type="password" id="cnf_password"  placeholder="<?php if($this->lang->line('change_conf_pwd') != '') { echo stripslashes($this->lang->line('change_conf_pwd')); } else echo "Confirm Password"; ?>" value="" class="decorative-input1" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
								  <div id="rep_code_alert" style="display:none; color:red; ; font-weight:bold; padding-bottom:8px;" align="left"><?php if($this->lang->line('Does_not_Support_Rep_Code') != '') { echo stripslashes($this->lang->line('Does_not_Support_Rep_Code')); } else echo "Does not Support Rep Code";?></div>
								  
								  <!--<input type="text" id="rep_code" value="" class="decorative-input" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" placeholder="<?php //if($this->lang->line('rep_code') != '') { echo stripslashes($this->lang->line('rep_code')); } else echo "Representative Code"; ?>"/>-->
                                  
                                 <div class="test" style="float:left; width:100%; margin:5px 0"> <input type="checkbox" checked="checked" id="checkbox" style="float:left; width:auto; margin:0 5px 0 0px" /><label class="news-stay" style="float:left"><?php if($this->lang->line('staynest_news') != '') { echo stripslashes($this->lang->line('staynest_news')); } else echo "Tell me about latest news";?> </label></div>
                                 
                                

<p style="font-size:11px; text-align:left; margin:10px 0"><?php if($this->lang->line('simplesignup_cont1') != '') { echo stripslashes($this->lang->line('simplesignup_cont1')); } else echo 'By clicking "Sign up" you confirm that you accept the';?> <a data-popup="true" href="pages/privacy-policy"><?php if($this->lang->line('header_terms_service') != '') { echo stripslashes($this->lang->line('header_terms_service')); } else echo "Terms of Service";?></a> <?php if($this->lang->line('header_and') != '') { echo stripslashes($this->lang->line('header_and')); } else echo "and"; ?> <a data-popup="true" href="pages/policy"><?php if($this->lang->line('header_privacy_policy') != '') { echo stripslashes($this->lang->line('header_privacy_policy')); } else echo "Privacy Policy";?></a>.</p>
<br />



<div style="font-weight: 700; color: rgb(0, 0, 0); font-style: oblique; line-height: 65px; float: left; width: 50%; font-size: 22px; height: 36px; margin: -15px 0px 5px 0px; border-radius: 6px;"><input type="text" placeholder="<?php if($this->lang->line('captcha') != '') { echo stripslashes($this->lang->line('captcha')); } else echo "captcha";?>" id="register_captcha" style="height:37px; width:75%; float:left;"/><a href="javascript:reload_captcha();"><img src="images/refresh.png" style="width:12px;height:12px;margin:15px 10px;" title="<?php if($this->lang->line('Refresh') != '') { echo stripslashes($this->lang->line('Refresh')); } else echo "Refresh";?>" /></a></div><div style="font-weight: 700; color: rgb(0, 0, 0); font-style: oblique; line-height: 65px; float: right; width: 50%; font-size: 22px; border: 1px solid rgb(223, 223, 195); height: 36px; margin: -15px 0px 5px 0px; border-radius: 6px; background: none repeat scroll 0% 0% rgb(242, 252, 227);"><span class="captcha-cls" id="captacha1" style="float: left; width: 48%; text-decoration: line-through; transform: rotate(-10deg); text-align: right; margin: -15px 0px 0px;"><?php $Capta1 = substr(str_shuffle("0123456789"), 0, 4); echo $Capta1; ?></span><span class="captcha-cls" id="captacha2" style="float: left; width: 48%; text-decoration: line-through; margin: -12px 0px 0px; text-align: left; transform: rotate(12deg);"><?php $Capta2 = substr(str_shuffle("0123456789"), 0, 4); echo $Capta2; ?></span><input type="hidden" id="captacha" value="<?php echo $Capta1.$Capta2; ?>" style="width:46%" /></div>


                                 <div style="display:none;" id="loading_signup_image" ><img  src="images/ajax-loader/ajax-loader(4).gif" id="loading_signup_image" ></div>

                                 <input type ='hidden' name='invite_reference' id="invite_reference" value="<?php if(isset($_SESSION['inviterID'])) echo $_SESSION['inviterID']; else echo '0';?>" />
<?php 
							if($this->lang->line('Please_enter_the_email_address') != '')
							{ 
								$email_add = stripslashes($this->lang->line('Please_enter_the_email_address')); 
							} 
							else
							{
								$email_add = "Please enter the email address";
							}		
							if($this->lang->line('Please_enter') != '')
							{ 
								$pass_enter = stripslashes($this->lang->line('Please_enter')); 
							} 
							else
							{
								$pass_enter = "Please enter the password";
							}		
						
							if($this->lang->line('Password must be minimum of 6 characters') != '')
							{ 
								$min_password = stripslashes($this->lang->line('Password must be minimum of 6 characters')); 
							} 
							else
							{
								$min_password = "Password must be minimum of 6 characters";
							}	
							if($this->lang->line('Please_enter_the_first_name') != '')
							{ 
								$first_name = stripslashes($this->lang->line('Please_enter_the_first_name')); 
							} 
							else
							{
								$first_name = "Please enter the first name";
							}
							if($this->lang->line('Please_enter_the_last_name') != '')
							{ 
								$last_name = stripslashes($this->lang->line('Please_enter_the_last_name')); 
							} 
							else
							{
								$last_name = "Please enter the last name";
							}	
							if($this->lang->line('Passwords_not_matching') != '')
							{ 
								$pass_not_match = stripslashes($this->lang->line('Passwords_not_matching')); 
							} 
							else
							{
								$pass_not_match = "Passwords not matching";
							}	
							if($this->lang->line('Enter_valid_captcha') != '')
							{ 
								$valid_captcha = stripslashes($this->lang->line('Enter_valid_captcha')); 
							} 
							else
							{
								$valid_captcha = "Enter valid captcha";
							}

						if($this->lang->line('Please enter a valid email address') != '')
							{ 
								$enter_mail = stripslashes($this->lang->line('Please enter a valid email address')); 
							} 
							else
							{
								$enter_mail = "Please enter a valid email address";
							}	


							
							?>
							<input type="hidden" value="<?php echo $email_add; ?>" name="email_add" id="email_add">
							<input type="hidden" value="<?php echo $min_password; ?>" name="min_pass" id="min_pass">
							<input type="hidden" value="<?php echo $pass_enter; ?>" name="pass_msg" id="pass_msg">
							<input type="hidden" value="<?php echo $first_name; ?>" name="first_name_msg" id="first_name_msg">
							<input type="hidden" value="<?php echo $last_name; ?>" name="last_name_msg" id="last_name_msg">
							<input type="hidden" value="<?php echo $pass_not_match; ?>" name="pass_not_match" id="pass_not_match">
							<input type="hidden" value="<?php echo $valid_captcha; ?>" name="valid_captcha" id="valid_captcha">
							
							<input type="hidden" value="<?php echo $enter_mail; ?>" name="enter_mail" id="enter_mail">
							
                                 <button type="submit" id="loading_signup" class="btn btn-block btn-primary large btn-large padded-btn-block register-popup cboxElement" onclick="javascript:register_user();" ><?php if($this->lang->line('login_signup') != '') { echo stripslashes($this->lang->line('login_signup')); } else echo "Create Account"; ?></button>
								 
								 <div class="remembr" style="display:none;">
								 <input class="new-chek" type="checkbox"><span class="remember-me"><?php if($this->lang->line('remember_me') != '') { echo stripslashes($this->lang->line('remember_me')); } else echo "Remember Me";?></span>
								 </div>
                                 <span class="popup_stay"><?php if($this->lang->line('already_member') != '') { echo stripslashes($this->lang->line('already_member')); } else echo "Already member?";?><a href="javascript:void(0);" style="font-size:13px; margin:0 0 0 3px" class="all-link login-popup"><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "log in"; ?></a></span>
                            </div>
                    
                    	
            </div>
        
        </div>
        
  </div>
  
</div>

<div style='display:none'>

  <div id='inline_forgot' style='background:#fff;'>
  
  		<div class="popup_page">
  
  			<div class="popup_header"> <?php if($this->lang->line('forgot_reset_pwd') != '') { echo stripslashes($this->lang->line('forgot_reset_pwd')); } else echo "Reset Password";?> </div>
            
            <div class="popup_detail">
            
            	<div class="banner_signup">
                            	<p style="font-size:12px; text-align:left; margin:10px 0"><?php if($this->lang->line('contant_reset_pwd') != '') { echo stripslashes($this->lang->line('contant_reset_pwd')); } else echo "Enter the email address associated with your account, and we'll email you a link to reset your password.";?></p>
                                
                                 <input type="text" id="forgot_email" value="" placeholder="<?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address"; ?>" class="decorative-input" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
                                 <?php if($this->lang->line('Email required') != '')
								{ 
									$Email_required = stripslashes($this->lang->line('Email required')); 
								} 
								else
								{
									$Email_required = "Email required";
								}
								?>
								<input type="hidden" value="<?php echo $Email_required; ?>" name="Email_required" id="Email_required">
                              <button class="btn btn-primary" style="height:25px;" type="submit" onclick="javascript:forgot_password();" >
							  <span id="load-img-forgot" style="display:none;">
							  <img src="images/ajax-loader/ajax-loader(2).gif" alt="Loading..." />
							  </span>
							  <?php if($this->lang->line('send_reset_pwd') != '') { echo stripslashes($this->lang->line('send_reset_pwd')); } else echo "Send Reset Link";?></button>
                               
                            </div>
                    
                    	
            </div>
        
        </div>
        
  </div>
  
</div>



<header class="header-style land_headr">

<input type="hidden" value="" name="login_checked_status" id="login_checked_status">
	<div class="header">
	<div class="container2 renter22">
		<div class="col-md-4 leftlog">
			<div class="logo-container">
        <span class="logo">
		<?php
		if($_SESSION['language_code']=="ar")
{
		?>
		<a href="<?php echo base_url();?>"><img src="images/logo/<?php echo $this->config->item('logo_image_arabic');?>" alt=""></a>
<?php } else {?>
		<?php if($this->uri->segment(1) != '') { ?>
		<a href="<?php echo base_url();?>"><img src="images/logo/<?php echo $this->config->item('logo_image');?>" alt=""></a>
		<?php }else { ?>
		<a href="<?php echo base_url();?>"><img src="images/logo/<?php echo $this->config->item('home_logo_image');?>" alt=""></a>
		<?php } ?>
		<?php } ?>
		</span>
		<?php $temp = $this->uri->segment(1); //if($temp != '') {?>
        <div class="inpt-head-place">
		<!--<input type="text" style="width: 85%;" class="auto-tet" placeholder="<?php if($this->lang->line('Where_are') != '') { echo stripslashes($this->lang->line('Where_are')); } else echo "Where are you going?";?>" id="autocomplete">-->
		
		<input type="hidden" name="current_controller" value="<?php echo $current_controller;?>" id="current_controller">
		
		<i class="fa fa-search home-search" aria-hidden="true"></i>
		<input class="auto-tet"  style="color:black" name="city" id="autocompleteNew" placeholder="<?php if($this->lang->line('search_where') != '') { echo stripslashes($this->lang->line('search_where')); } else echo "Where do you want to go?"; ?>" onFocus="geolocate()" type="text" onkeyup="findLocation(event);" value="<?php echo $gogole_address;?>">
		<div id="autoCompImg" style="float: right; margin: 15px; display:none;"><img src="images/ajax-loader/ajax-loader.gif" alt="Loading..."></div>
        </div><?php //} ?>
		

 <!--	
	 <div class="brows-loop"> <label class="browse"><a href="popular" class="popul"><?php if($this->lang->line('popular') != '') { echo stripslashes($this->lang->line('popular')); } else echo "Popular"; ?></a>
</label>
</div>

-->

<div>

</div>
			</div></div>


		<div class="col-md-8 rightlog">
      <div class="navbar">
        <div class="navbar-inner">
            
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<!-- <span>Menu</span> -->
			<span class="icon-bar"></span>
			
            </a>
            <div class="nav-collapse navbar-collapse my-nav">
			
                <ul class="nav">
				
				
				
				<li class="bocom-host"><a <?php if ($loginCheck == ''){?> href="popular" class="" <?php } else { ?> href="popular" <?php } ?>  class="request-trip" ><?php if($this->lang->line('popular') != '') { echo stripslashes($this->lang->line('popular')); } else echo "Popular";?></a></li>
				<!--<li class="bocom-host"><a <?php if ($loginCheck == ''){?> href="javascript:void(0);" class="login-popup ren-sp" <?php } else { ?> href="explore_experience" <?php } ?>  class="request-trip" ><?php if($this->lang->line('small_experience') != '') { echo stripslashes($this->lang->line('small_experience')); } else echo "Experience";?></a></li>-->
		

				<li class="browse_div2 bocom-host" id="broswe_box1">
            	 <a href="javascript:void(0);" >
				 <?php if($this->lang->line('Become_Host') != '') { echo stripslashes($this->lang->line('Become_Host')); } else echo "Become a Host";?><i class="caret"></i></a>             
					<ul class="showlist3" >
						<span class="ard"></span>
						 <li ><a <?php if ($loginCheck == ''){?> href="javascript:void(0);" class="login-popup ren-sp" <?php } else { ?> href="list_space" <?php } ?>  class="request-trip" ><?php if($this->lang->line('list_your') != '') { echo stripslashes($this->lang->line('list_your')); } else echo "List Your Space";?></a></li>
						<li><a <?php if ($loginCheck == ''){?> href="javascript:void(0);" class="login-popup ren-sp" <?php } else { ?> href="<?php echo base_url();?>manage_experience" <?php } ?>><?php if($this->lang->line('create_experience') != '') { echo stripslashes($this->lang->line('create_experience')); } else echo "Create Experience"; ?></a></li>
					</ul>
			
				</li>
					
				 	
					
                    
                     
					    
					

				<?php if ($loginCheck == ''){?> 
                   <!-- <li ><a href="javascript:void(0);" class="reg-popup">sign up</a></li> -->
				   
				   <li class="bocom-host"><a href="javascript:void(0);" class="reg-popup"><?php if($this->lang->line('signup') != '') { echo stripslashes($this->lang->line('signup')); } else echo "sign up"; ?></a></li>


                    
					<!-- <li><a href="javascript:void(0);" class="login-popup">login</a></li> -->
					<li class="bocom-host"><a href="javascript:void(0);" class="login-popup"><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "login"; ?></a></li>
                    <?php $actual_link1 = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
					$arr = explode(",",$actual_link1);
					$dynamic_url = $arr[0];
					?>
                    <!--li class="bocom-host"><a href="contact-us"><?php //if($this->lang->line('Contactus') != '') { echo stripslashes($this->lang->line('Contactus')); } else echo "Contact Us ";?></a></li-->


					
                    <li class="bocom-host"><a href="help" ><?php if($this->lang->line('footer_follow_help') != '') { echo stripslashes($this->lang->line('footer_follow_help')); } else echo "Help"; ?></a>
				 <ul class="showlist2" >
                	<?php 
						if ($cmsList->num_rows() > 0){
							foreach ($cmsList->result() as $row){
								if($row->hidden_page == 'No' && $row->category == 'Sub' && $row->parent == '71') {
						?>
        	   <li class="bocom-host"><a href="pages/<?php echo $row->seourl; ?>"><?php echo $row->page_name;?></a></li> <?php } } } ?>
                </ul>
					</li>
					<?php }else {?>
					
               <li class="browse_div2 bocom-host" id="broswe_box1">
            	 <a href="javascript:void(0);">
				 <?php //if($userDetails->row()->loginUserType=='google' || $userDetails->row()->google=='Yes')
	  //{
		?>
		
		<!--<img width="20" src="<?php //echo $userDetails->row()->image; ?>" style="float:left; margin:0 5px;" id="showlist_test" alt=""/>-->
		<?php
	  //}
	  //else{
	  ?>
	  <img width="20" src="<?php if($userDetails->row()->image!='') { echo base_url(); ?>images/users/<?php echo $userDetails->row()->image; } else echo "images/profile1.png";?>" id="showlist_test" alt="">
	  
	  <?php //} ?>
				  
				 
				 <label class="user-name"><?php //if($this->lang->line('login_hi') != '') { echo stripslashes($this->lang->line('login_hi')); } else echo "Hi"; ?><?php echo " ".ucfirst($userDetails->row()->firstname);?></label><i class="caret" ></i></a>             
                <ul class="showlist3" >
                    <span class="ard"></span>
                    <li><a href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('header_dashboard') != '') { echo stripslashes($this->lang->line('header_dashboard')); } else echo "Dashboard"; ?></a></li>

                   

                    <li><a href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('header_listing') != '') { echo stripslashes($this->lang->line('header_listing')); } else echo "Your Listings"; ?></a></li>

                    <?php /* Experience Listing */
                    if($experienceExistCount>0){
                    ?>
                    <li><a href="<?php echo base_url();?>experience/all"><?php if($this->lang->line('my_experience_list') != '') { echo stripslashes($this->lang->line('my_experience_list')); } else echo "My Experiences List"; ?></a></li>
                    <?php } /* Experience Listing ends */?>


					<li><a href="<?php echo base_url();?>listing-reservation"><?php if($this->lang->line('YourReservations') != '') { echo stripslashes($this->lang->line('YourReservations')); } else echo "Your Reservations"; ?></a></li>
                    <li><a href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('your_trips') != '') { echo stripslashes($this->lang->line('your_trips')); } else echo "Your Trips"; ?></a></li>
					<li><a href="users/<?php echo $loginCheck;?>/wishlists"><?php if($this->lang->line('wish_list') != '') { echo stripslashes($this->lang->line('wish_list')); } else echo "Wish List"; ?></a></li>
                    <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('settings_edit_prof') != '') { echo stripslashes($this->lang->line('settings_edit_prof')); } else echo "Edit Profile"; ?></a></li>
                    <li><a href="<?php echo base_url();?>account-payout"><?php if($this->lang->line('referrals_account') != '') { echo stripslashes($this->lang->line('referrals_account')); } else echo "Account"; ?></a></li>
                    
                    <!--Wallet - referal amount display -->
                    
                    <li><a href="<?php echo base_url();?>your-wallet"><?php if($this->lang->line('Wallet') != '') { echo stripslashes($this->lang->line('Wallet')); } else echo "Wallet";echo "$ (".$currencySymbol.' '.convertCurrency('USD',$this->session->userdata('currency_type'),$userDetails->row()->referalAmount).")"; ?></a></li>

                    <!--Wallet - referal amount display -->
 					<?php if($normal_login_type =='normal' && $userDetails->row()->id == $fg_id){?>
                    <li><a href="logout" ><?php if($this->lang->line('header_signout') != '') { echo stripslashes($this->lang->line('header_signout')); } else echo "Log Out"; ?></a></li>
                	
                	<?php } elseif($google_login_type == 'google'){?>

                		<li><button onclick="javascript:signOut();" style="margin-top:0px !important; text-align:center !important;"><?php if($this->lang->line('header_signout') != '') { echo stripslashes($this->lang->line('header_signout')); } else echo "Log Out"; ?></button></li>

                		<?php } elseif($linkedin_login_type == 'linkedin' && $userDetails->row()->id == $fg_id){ ?>

                		<li><a href="logout" onclick="javascript:linkedin_logout();"><?php if($this->lang->line('linkedin_login_type') != '') { echo stripslashes($this->lang->line('linkedin_login_type')); } else echo "Log Out"; ?></a></li>
                			
                		<?php } elseif($facebook_login_type=='facebook' && $facebook_id){?>
						<li><a href="logout" onclick="javascript:logout();"><?php if($this->lang->line('facebook_login_type') != '') { echo stripslashes($this->lang->line('facebook_login_type')); } else echo "Log Out"; ?></a></li>
						<?php } else{}?>
                </ul>

               
          </li>
		  <!--Facebook-->
		  
		  <!--Facebook-->
		  
		   <div class="browse_di">
		   
		   
                <?php
				
				$user_id=$userDetails->row()->id;
				$msg_unread_count=0;
				
				if($user_id!=''){ 
				
					$sql=" select m.*,p.user_id as host_id from ".MED_MESSAGE." as m,".PRODUCT." as p where m.productId=p.id and m.receiverId=".$user_id." and ( ( m.receiverId=p.user_id and m.host_msgread_status='No') or (m.receiverId!=p.user_id and m.user_msgread_status='No')) and m.msg_status=0";
					
					$result=$this->db->query($sql);
					$msg_unread_count=$result->num_rows();
				}
				$total=$msg_unread_count;
				?>
				
				 <a href="<?php echo base_url();?>inbox"><i class="fa fa-envelope" aria-hidden="true"></i>
				<span class="unread-icon">
				<?php echo $total; ?></span>
				
				</a>
				
				
				<?php 
/*				
				$msg_read='No'; $total=0;

				if($userDetails->row()->group=="Seller"){ 
				
				$result = 0;
				 if($userDetails->row()->id != '') {
				 $this->db->select('*');
				 $this->db->from(MED_MESSAGE);
				 $this->db->where('receiverId',$userDetails->row()->id);
				 $this->db->where('msg_read','No');
                 $this->db->group_by('bookingNo');
				 $result = $this->db->get()->num_rows();
				 //echo 'Hai';
				 //echo $result;
				 }
				 
				 $host_result = 0;
				 if($userDetails->row()->id != '') {
				 $this->db->select('*');
				 $this->db->from(MED_MESSAGE);
				 $this->db->where('receiverId',$userDetails->row()->id);
				 $this->db->where('host_msgread_status','No');
				 //$this->db->where('user_msgread_status','No');
                 $this->db->group_by('bookingNo');
                 
				 $host_result = $this->db->get()->num_rows();
				// echo $this->db->last_query();
				 //echo $host_result;
				 }
				 $host_results = 0;
				 if($userDetails->row()->id != '') {
				 $this->db->select('*');
				 $this->db->from(MED_MESSAGE);
				 $this->db->where('receiverId',$userDetails->row()->id);
				 $this->db->where('user_msgread_status','No');
                 $this->db->group_by('bookingNo');
				 $host_results = $this->db->get()->num_rows();
				 //echo $this->db->last_query();
				 //echo "User";
				 //echo $host_results;
				 }
				 
				 $result_c = 0;
				                        if($userDetails->row()->id != '') {
				                        $this->db->reconnect();
				                        $this->db->select('*');
				                        $this->db->from(MED_MESSAGE);
				                        $this->db->where('receiverId',$userDetails->row()->id);
				                        $this->db->where('host_msgread_status','No');
                                        $result_c = $this->db->get()->num_rows();
										//echo 'Hai';
										//echo $result_c;
										}
										//echo $this->db->last_query();
										if($result>0)
										{
											$total = $result;
										}
										else{
											
											$host_msgread_status = 'No';
											if($host_result>0)
											{
												
												$total = $host_result;
											}
											if($host_results>0)
											
											{
												$total = $host_results;
											}
										}	
											//$total = $host_results;
										
										//echo $total = $host_results;
				//$sql=mysql_query("SELECT COUNT(`host_msgread_status`) FROM `fc_med_message` WHERE `receiverId`='51' AND `host_msgread_status`='No'");
				//$row=mysql_num_rows($sql);
				//$total = $result +$host_results+$host_result;
											
				 ?>
				 
				 
                <a href="<?php echo base_url();?>inbox"><i class="fa fa-envelope" aria-hidden="true"></i>
				<span class="unread-icon">
				<?php echo $total; ?></span>
				
				</a>
			
				
			
				 
				 <?php } elseif($userDetails->row()->group=="User"){
					 
					 
				 $results = 0;
				 if($userDetails->row()->id != '') {
				 $this->db->select('*');
				 $this->db->from(MED_MESSAGE);
				 $this->db->where('receiverId',$userDetails->row()->id);
				 $this->db->where('user_msgread_status','No');
                 $this->db->group_by('bookingNo');
				 $results = $this->db->get()->num_rows();
				 //echo $this->db->last_query();die;
				 }
				 $result_u = 0;
				                        if($userDetails->row()->id != '') {
				                        $this->db->reconnect();
				                        $this->db->select('*');
				                        $this->db->from(MED_MESSAGE);
				                        $this->db->where('receiverId',$userDetails->row()->id);
				                        $this->db->where('user_msgread_status','No');
										$this->db->where('bookingNo',$med_message->bookingNo);
                                        $result_u = $this->db->get()->num_rows();
										//echo $result_c;
										}
										$total_u = $results + $result_u;
				 ?>
				 <a href="<?php echo base_url();?>inbox"><i class="fa fa-envelope" aria-hidden="true"></i><?php if ($results > 0 ) {?><span class="unread-icon"><?php echo $total_u; ?></span><?php } else{echo '<span class="unread-icon">0</span>';}?></a>
				 <?php }?>
				 
				 
			*/ ?>		 
					 
				 
           </div> 
                    
					<?php }?>

					 <div class="browse_di">		
											 <!--msg for experience -->
						 <?php /* Experience Listing */
		                    if($experienceExistCount>0){
								
		                    	if(!empty($userDetails)){
									
									$total_exp=0;
									$msg_unread_count_exp=0;
									
									if($user_id!=''){ 
				
										$sql=" select m.*,p.user_id as host_id from ".EXPERIENCE_MED_MSG." as m,".EXPERIENCE." as p where m.productId=p.experience_id and m.receiverId=".$user_id." and ( ( m.receiverId=p.user_id and m.host_msgread_status='No') or (m.receiverId!=p.user_id and m.user_msgread_status='No')) and m.msg_status=0";
										
										$result=$this->db->query($sql);
										$msg_unread_count_exp=$result->num_rows();
									}
									$total_exp=$msg_unread_count_exp;
				
		                    	//if ($total_exp > 0 ) {
				                    ?>
				                    <a href="<?php echo base_url();?>experience_inbox" style="padding-left: 10px" title="Experience Message"><i class="fa fa-comment" aria-hidden="true"></i><?php if ($total_exp > 0 ) {?><span class="unread-icon"><?php echo $total_exp; ?></span><?php } else{echo '<span class="unread-icon">0</span>';}?></a> 
		                    <?php 
							//} 
		                    	}
		                    } /* Experience Listing ends */?>
							
					</div>	
					
                </ul>
				
            </div>
        </div>
    </div>
	
	
	<!---responsive-menu-->
	
	<div class="nav-right-new visible-xs">
  <div class="tog-button" id="btn">
    <div class="bar1 top"></div>
    <div class="bar1 midl"></div>
    <div class="bar1 bottom"></div>
  </div>
</div>
<!-- nav-right -->
<div style="position:relative"> 
<main>

    <div class="nav-right-new hidden-xs">
      <div class="tog-button" id="btn">
        <div class="bar1 top"></div>
        <div class="bar1 midl"></div>
        <div class="bar1 bottom"></div>
      </div>
    </div>
    <!-- nav-right -->
  

  
</main>

<div class="sidebar-menu-new">
  <ul class="sidebar-list">
   	
				
				 <li class="sidebar-item"><a class="sidebar-anchor" <?php if ($loginCheck == ''){?> href="popular" class="" <?php } else { ?> href="popular" <?php } ?>  ><?php if($this->lang->line('popular') != '') { echo stripslashes($this->lang->line('popular')); } else echo "Popular";?></a></li>
								


                    <li class="sidebar-item"><a class="ren-sp sidebar-anchor" <?php if ($loginCheck == ''){?> href="javascript:void(0);"  <?php } else { ?> href="list_space" <?php } ?>  ><?php if($this->lang->line('list_your') != '') { echo stripslashes($this->lang->line('list_your')); } else echo "List Your Space";?></a></li>
				<?php if ($loginCheck == ''){?> 
                   
				   

				 	<li class="sidebar-item"><a  class="login-popup ren-sp sidebar-anchor" href="<?php echo base_url();?>explore_experience"><?php if($this->lang->line('experience') != '') { echo stripslashes($this->lang->line('experience')); } else echo "Experiences"; ?></a></li>

				   <li class="sidebar-item"><a href="javascript:void(0);" class="reg-popup sidebar-anchor"><?php if($this->lang->line('signup') != '') { echo stripslashes($this->lang->line('signup')); } else echo "sign up"; ?></a></li>

				
					<li class="sidebar-item"><a class="sidebar-anchor login-popup" href="javascript:void(0);" ><?php if($this->lang->line('header_login') != '') { echo stripslashes($this->lang->line('header_login')); } else echo "login"; ?></a></li>
                    <?php $actual_link1 = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
					$arr = explode(",",$actual_link1);
					$dynamic_url = $arr[0];
					?>
                  


					
                    <li class="sidebar-item"><a href="help" class="sidebar-anchor"><?php if($this->lang->line('footer_follow_help') != '') { echo stripslashes($this->lang->line('footer_follow_help')); } else echo "Help"; ?></a></li>
				 <ul class="showlist2" >
                	<?php 
						if ($cmsList->num_rows() > 0){
							foreach ($cmsList->result() as $row){
								if($row->hidden_page == 'No' && $row->category == 'Sub' && $row->parent == '71') {
						?>
        	   <li class="sidebar-item"><a class="sidebar-anchor" href="pages/<?php echo $row->seourl; ?>"><?php echo $row->page_name;?></a></li> <?php } } } ?>
                </ul>
					
					<?php }else {?>
					
               
            	           
                <ul class="browse_div2 rg" id="broswe_box1">
                    
                    <li class="sidebar-item"><a class="sidebar-anchor" href="<?php echo base_url();?>dashboard"><?php if($this->lang->line('header_dashboard') != '') { echo stripslashes($this->lang->line('header_dashboard')); } else echo "Dashboard"; ?></a></li>
<!--new-->
                    


                     <li class="sidebar-item"><a class="sidebar-anchor" href="<?php echo base_url();?>experience/all"><?php if($this->lang->line('header_experience') != '') { echo stripslashes($this->lang->line('header_experience')); } else echo "Your Experiences List"; ?></a></li>
<!--new-->
                    <li class="sidebar-item"><a class="sidebar-anchor" href="<?php echo base_url();?>listing/all"><?php if($this->lang->line('header_listing') != '') { echo stripslashes($this->lang->line('header_listing')); } else echo "Your Listings"; ?></a></li>
					<li class="sidebar-item"><a class="sidebar-anchor" href="<?php echo base_url();?>listing-reservation"><?php if($this->lang->line('YourReservations') != '') { echo stripslashes($this->lang->line('YourReservations')); } else echo "Your Reservations"; ?></a></li>
                    <li class="sidebar-item"><a class="sidebar-anchor" href="<?php echo base_url();?>trips/upcoming"><?php if($this->lang->line('your_trips') != '') { echo stripslashes($this->lang->line('your_trips')); } else echo "Your Trips"; ?></a></li>
					<li class="sidebar-item"><a class="sidebar-anchor" href="users/<?php echo $loginCheck;?>/wishlists"><?php if($this->lang->line('wish_list') != '') { echo stripslashes($this->lang->line('wish_list')); } else echo "Wish List"; ?></a></li>
                    <li class="sidebar-item"><a class="sidebar-anchor" href="<?php echo base_url();?>settings"><?php if($this->lang->line('settings_edit_prof') != '') { echo stripslashes($this->lang->line('settings_edit_prof')); } else echo "Edit Profile"; ?></a></li>
                    <li class="sidebar-item"><a class="sidebar-anchor" href="<?php echo base_url();?>account"><?php if($this->lang->line('referrals_account') != '') { echo stripslashes($this->lang->line('referrals_account')); } else echo "Account"; ?></a></li>
                    
                    <!--Wallet - referal amount display -->
                    
                    <li class="sidebar-item"><a class="sidebar-anchor" href=""><?php if($this->lang->line('wallets') != '') { echo stripslashes($this->lang->line('wallets')); } else echo "Wallet(".$currencySymbol.' '.convertCurrency('USD',$this->session->userdata('currency_type'),$userDetails->row()->referalAmount).")"; ?></a></li>

                    <!--Wallet - referal amount display -->
 					<?php if($normal_login_type =='normal' && $userDetails->row()->id == $fg_id){?>
                    <li class="sidebar-item"><a class="sidebar-anchor" href="logout" ><?php if($this->lang->line('header_signout') != '') { echo stripslashes($this->lang->line('header_signout')); } else echo "Log Out"; ?></a></li>
                	
                	<?php } elseif($google_login_type == 'google'){?>

                		<li class="sidebar-item"><button onclick="javascript:signOut();" style="margin-top:0px !important; text-align:center !important;"><?php if($this->lang->line('header_signout') != '') { echo stripslashes($this->lang->line('header_signout')); } else echo "Log Out"; ?></button></li>

                		<?php } elseif($linkedin_login_type == 'linkedin' && $userDetails->row()->id == $fg_id){ ?>

                		<li class="sidebar-item"><a class="sidebar-anchor" href="logout" onclick="javascript:linkedin_logout();"><?php if($this->lang->line('linkedin_login_type') != '') { echo stripslashes($this->lang->line('linkedin_login_type')); } else echo "Log Out"; ?></a></li>
                			
                		<?php } elseif($facebook_login_type=='facebook' && $facebook_id){?>
						<li class="sidebar-item"><a class="sidebar-anchor" href="logout" onclick="javascript:logout();"><?php if($this->lang->line('facebook_login_type') != '') { echo stripslashes($this->lang->line('facebook_login_type')); } else echo "Log Out"; ?></a></li>
						<?php } else{}?>
                </ul>

               
        
		  <!--Facebook-->
		  
		  <!--Facebook-->
		  
		   <div class="browse_di">
		   
		   
                <?php 
				$msg_read='No'; $total=0;
				if($userDetails->row()->group=="Seller"){ 
				$result = 0;
				 if($userDetails->row()->id != '') {
				 $this->db->select('*');
				 $this->db->from(MED_MESSAGE);
				 $this->db->where('receiverId',$userDetails->row()->id);
				 $this->db->where('msg_read','No');
                 $this->db->group_by('bookingNo');
				 $result = $this->db->get()->num_rows();
				 //echo 'Hai';
				 //echo $result;
				 }
				 
				 $host_result = 0;
				 if($userDetails->row()->id != '') {
				 $this->db->select('*');
				 $this->db->from(MED_MESSAGE);
				 $this->db->where('receiverId',$userDetails->row()->id);
				 $this->db->where('host_msgread_status','No');
				 //$this->db->where('user_msgread_status','No');
                 $this->db->group_by('bookingNo');
                 
				 $host_result = $this->db->get()->num_rows();
				// echo $this->db->last_query();
				 //echo $host_result;
				 }
				 $host_results = 0;
				 if($userDetails->row()->id != '') {
				 $this->db->select('*');
				 $this->db->from(MED_MESSAGE);
				 $this->db->where('receiverId',$userDetails->row()->id);
				 $this->db->where('user_msgread_status','No');
                 $this->db->group_by('bookingNo');
				 $host_results = $this->db->get()->num_rows();
				 //echo $this->db->last_query();
				 //echo "User";
				 //echo $host_results;
				 }
				 
				 $result_c = 0;
				                        if($userDetails->row()->id != '') {
				                        $this->db->reconnect();
				                        $this->db->select('*');
				                        $this->db->from(MED_MESSAGE);
				                        $this->db->where('receiverId',$userDetails->row()->id);
				                        $this->db->where('host_msgread_status','No');
                                        $result_c = $this->db->get()->num_rows();
										//echo 'Hai';
										//echo $result_c;
										}
										//echo $this->db->last_query();
										if($result>0)
										{
											$total = $result;
										}
										else{
											$host_msgread_status = 'No';
											if($host_result>0)
											{
												$total = $host_result;
											}
											if($host_results>0)
											
											{
												$total = $host_results;
											}
										}	
											//$total = $host_results;
										
										//echo $total = $host_results;
				//$sql=mysql_query("SELECT COUNT(`host_msgread_status`) FROM `fc_med_message` WHERE `receiverId`='51' AND `host_msgread_status`='No'");
				//$row=mysql_num_rows($sql);
				//$total = $result +$host_results+$host_result;
											
				 ?>
				 
				 
                
				
			
				 
				 <?php } elseif($userDetails->row()->group=="User"){
					 
					 
				 $results = 0;
				 if($userDetails->row()->id != '') {
				 $this->db->select('*');
				 $this->db->from(MED_MESSAGE);
				 $this->db->where('receiverId',$userDetails->row()->id);
				 $this->db->where('user_msgread_status','No');
                 $this->db->group_by('bookingNo');
				 $results = $this->db->get()->num_rows();
				 //echo $this->db->last_query();die;
				 }
				 $result_u = 0;
				                        if($userDetails->row()->id != '') {
				                        $this->db->reconnect();
				                        $this->db->select('*');
				                        $this->db->from(MED_MESSAGE);
				                        $this->db->where('receiverId',$userDetails->row()->id);
				                        $this->db->where('user_msgread_status','No');
										$this->db->where('bookingNo',$med_message->bookingNo);
                                        $result_u = $this->db->get()->num_rows();
										//echo $result_c;
										}
										$total_u = $results + $result_u;
				 ?>
				 <a href="<?php echo base_url();?>inbox"><i class="fa fa-envelope" aria-hidden="true"></i><?php if ($results > 0 ) {?><span class="unread-icon"><?php echo $total_u; ?></span><?php } else{echo '<span class="unread-icon">0</span>';}?></a>
				 <?php }?>
				 
				 
					 
					 
				 
           </div> 
                    
					<?php }?>
  </ul>
</div>
</div>

<style>


</style>


<script>
$(document).ready(function() {

  function toggleSidebar() {
    $(".tog-button").toggleClass("active");
    $("main").toggleClass("move-to-left");
    $(".sidebar-item").toggleClass("active");
	 $(".sidebar-menu-new").toggleClass("hid-menu");
	
  }

  $(".tog-button").on("click tap", function() {
    toggleSidebar();
  });

  $(document).keyup(function(e) {
    if (e.keyCode === 27) {
      toggleSidebar();
    }
  });

});

</script>
	
	
	
	
	
	

	</div>



</div>
</div>
</header>

                   <?php if($flash_data != '') {?>
                    <div class="errorContainer" id="<?php echo $flash_data_type;?>">
                        <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 4000);</script>
                        <p style="color:#000000; font-size:16px;"><span><?php echo $flash_data;?></span></p>
                    </div>
                    <?php } ?>
					<?php if ($this->session->flashdata('success') == TRUE): ?>
                    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>
<!---HEADER-->
                 
					<script type="text/javascript">
					function showView()
					{
					//alert($(this).attr('class'));
                    if($('.showlist3').css('display')=='none')
					{
					$('.showlist3').css('display','block')
					}
					}
					
      $('body').click(function(){    
				   if($(this).attr('id')!= "showlist_test")
				   {
				   //alert();
				   $('.showlist3').css('display','none')
				   }
				  
          
            });
			
$('#signin_email_address,#signin_password').keypress(function(e)
{
if(e.keyCode == 13)$( "#signin_click" ).click();
});			
</script>
<!--<script src="https://code.jquery.com/jquery-migrate-1.0.0.js"></script>-->




<script type="text/javascript">
$(window).on("scroll", function() {
    if($(window).scrollTop() > 50) {
        $(".header").addClass("active");
    } else {
        //remove the background property so it comes transparent again (defined in your css)
       $(".header").removeClass("active");
    }
});
</script>


<script>

$(document).ready(function(){
	initializeMap();
	if($('#address_location').length)initializeMapAddress();
	if($('#autocompleteNewList').length)initializeMapList();
	if($('#autocompleteNewExperience').length)initializeMapExperience();
	
	if($('#autocompleteNewMobile').length)initializeMapListMobile();
  $("body").scroll(function(){
    $(".header").addClass("important blue");
  });
});
</script>
<?php if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Speed Insights') === false): ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxTcwp4mXnhBxXpfPjXp2RkVxLZyeYIwU&libraries=places&signed_in=true"></script>
<!--<script type="text/javascript" src="js/markerwithlabel.js"></script>
<script type="text/javascript" src="js/markerwithlabel_packed.js"></script>-->
<script>
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initializeMap() { 
  // Create the autocomplete object, restricting the search
  // to geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {HTMLInputElement} */(document.getElementById('autocompleteNew')),
      { types: ['geocode'] });
  // When the user selects an address from the dropdown,
  // populate the address fields in the form.
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
	var uri_segment='<?php echo $this->uri->segment(1)?>';
	if( uri_segment != '')
	{
		var data = $("#autocompleteNew").serialize();
		findLocationAuto(data);
		return false;
	}
	
  });
}

function initializeMapList() {
  // Create the autocomplete object, restricting the search
  // to geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {HTMLInputElement} */(document.getElementById('autocompleteNewList')),
      { types: ['(cities)'] });
  // When the user selects an address from the dropdown,
  // populate the address fields in the form.
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    //fillInAddress();
	var uri_segment='<?php echo $this->uri->segment(1)?>';

		if( uri_segment =='list_space' )
		{

	 localStorage.setItem("location",$('#autocompleteNewList').val());
		}
  });
}

function initializeMapExperience() {
 
  // Create the autocomplete object, restricting the search
  // to geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {HTMLInputElement} */(document.getElementById('autocompleteNewExperience')),
      { types: ['(cities)'] });
  // When the user selects an address from the dropdown,
  // populate the address fields in the form.
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    //fillInAddress();
	var uri_segment='<?php echo $this->uri->segment(1)?>';

		if( uri_segment =='new_experience' )
		{

	 localStorage.setItem("location",$('#autocompleteNewExperience').val());
		}
  });
}

function initializeMapListMobile() {
  // Create the autocomplete object, restricting the search
  // to geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {HTMLInputElement} */(document.getElementById('autocompleteNewMobile')),
      { types: ['geocode'] });
  // When the user selects an address from the dropdown,
  // populate the address fields in the form.
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    fillInAddress();
  });
}

function initializeMapAddress() {
  // Create the autocomplete object, restricting the search
  // to geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {HTMLInputElement} */(document.getElementById('address_location')),
      { types: ['geocode'] });
  // When the user selects an address from the dropdown,
  // populate the address fields in the form.
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    fillInAddress();
  });
}

// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
}

function findLocation(event){
	current_controller=$('#current_controller').val();
	var x = event.which || event.keyCode;
	//s_val=$('#searched_main_category').val();
	//alert(s_val);
	//return false;
	if(x == 13){
		if(current_controller=='experience'){
			window.location='<?php echo base_url()?>explore_experience?city='+$('#autocompleteNew').val();
		}else{
			window.location='<?php echo base_url()?>property?city='+$('#autocompleteNew').val();
		}

	}
}

function findLocationAuto(loc){
	current_controller=$('#current_controller').val();
	if(current_controller=='experience'){
		window.location='<?php echo base_url()?>explore_experience?'+loc;
	}else{
		window.location='<?php echo base_url()?>property?'+loc;
	}
	
}
// [END region_geolocation]
</script>



<script type="text/javascript">
    var clientId = '<?php echo GOOGLEKEY; ?>'; // for web
    var apiKey = '<?php echo GOOGLESECRETKEY; ?>';
    var scopes = 'https://www.googleapis.com/auth/plus.me'; // also tried with 'profile email';
    function signOut() {
		document.location.href = "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo base_url('logout'); ?>";
        //window.location = '<?php //echo base_url('logout')?>';
		
		
    };

</script>



<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  api_key: '<?php echo APPLinkKEY; ?>'
  authorize: true
  onLoad: onLoad
</script>

<script type="text/javascript">
function linkedin_logout() {
  try {
    IN.User.logout();
  } catch (err) {
    console.log(err);
  }
  setTimeout("goToHome()", 100);
}

function goToHome() {
  document.location.href = "https://www.linkedin.com/secure/login?session_full_logout=&trk=hb_signout";
  location.href="logout";

}
</script>
<script src="//connect.facebook.net/en_US/sdk.js" type="text/javascript"></script> 
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
var datefrom = $("#datefrom").val();
var expiredate = $("#expiredate").val();
var number_of_guests = $("#number_of_guests").val();
  console.log( 'fb_login function initiated' );
	  FB.login(function(response) {

      console.log( 'login response' );
      console.log( response );
      console.log( 'Response Status' + response.status );
		//top.location.href=<?php echo base_url('dashboard'); ?>;
      if (response.authResponse) {

        console.log( 'Auth success' );

    		FB.api("/me",'GET',{'fields':'id,email,verified,name,picture'}, function(me){

      		if (me.id) {


            //console.log( 'Retrived user details from FB.api', me );

             var id = me.id; 
		var email = me.email;
            	var name = me.name;
            	var picture = me.picture.data.url;
                var live ='';
				if (me.hometown!= null)
				{			
					var live = me.hometown.name;
				}        
            	
    var passData = 'fid='+ id + '&email='+ email + '&name='+ name + '&live='+ live+'&picture='+picture+'&picture='+datefrom+'&datefrom='+expiredate+'&expiredate='+number_of_guests;
 //alert(passData);
            //console.log('data', passData);
          
            $.ajax({
             type: 'GET',
            data: passData,
			//data1:{ rUrl : "<?php echo $pageURL;?>" },
             //data: $.param(passData),
             global: false,
             url: '<?php echo base_url('site/landing/facebooklogin');?>',
             success: function(responseText)
			 
			 			 
			 { 
              console.log( responseText ); 
			  //exit;
              window.location.href = '<?php echo $pageURL;?>';
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
 <script src="js/site/facebook_sdk.js"></script>
 <div id="fb-root"></div>

        <script>
        window.fbAsyncInit = function() {
                FB.init({
                appId: '<?php echo APPKEY; ?>',
                status: true,
                cookie: true,
                xfbml: true
            });
        };

        // Load the SDK asynchronously
        (function(d){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);
        }(document));

        function login() {
            FB.login(function(response) {

            // handle the response
            console.log("Response goes here!");

            }, {scope: 'read_stream,publish_stream,publish_actions,read_friendlists'});            
        }

        function logout() {
            FB.logout(function(response) {
              window.location = "<?php echo base_url(); ?>";
            });
        }

        var status = FB.getLoginStatus();

       // console.log(status);

        </script>   

		
		
<?php endif; ?>


<script>

function show_more_and_less(char_count=200){
	//alert(char_count);
	var showChar = char_count;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = " <small>Show more</small>";
    var lesstext = " <small>Show less</small>";
    

    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
	
	
}

</script>

<!---->

