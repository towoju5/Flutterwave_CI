<!---FOOTER--><footer><div class="footer-bg footrcom"><div class="container"> <!--<div class="container1">-->
<div class="col-sm-3 inputfoot"><div class="country-lop"><script>function changeLanguage(e)
{
	var strUser = e.options[e.selectedIndex].value; 
	//alert(strUser);
	window.location.href = strUser; 
	}
	</script>
	

	
	<select onChange="changeLanguage(this);"><?php $selectedLangCode = $this->session->userdata('language_code'); if ($selectedLangCode == ''){  $selectedLangCode = $defaultLg[0]['lang_code']; } if (count($activeLgs)>0){foreach ($activeLgs as $activeLgsRow){?><option value="<?php echo base_url(); ?>lang/<?php echo $activeLgsRow['lang_code'];?>" <?php if ($selectedLangCode == $activeLgsRow['lang_code']){echo 'selected="selected"';}?>><?php echo ucfirst($activeLgsRow['name']);?></option><?php } } ?></select><!--<input class="country" id="selected_country" placeholder="English" type="text" style="text-transform:capitalize;"><ul class="dropdn"><?php $selectedLangCode = $this->session->userdata('language_code'); if ($selectedLangCode == ''){ $selectedLangCode = $defaultLg[0]['lang_code']; }if (count($activeLgs)>0){
foreach ($activeLgs as $activeLgsRow){ ?><li><a href="lang/<?php echo $activeLgsRow['lang_code'];?>" <?php if ($selectedLangCode == $activeLgsRow['lang_code']){echo 'class="active"';}?>><?php echo $activeLgsRow['name'];?></a></li><?php } } ?></ul>--></div><div class="country-lop"><script>function changeCurrency(e){ var strUser = e.options[e.selectedIndex].value; window.location.href = strUser;
}</script><select onChange="changeCurrency(this);"><?php if($currency_setup->num_rows() >0){ foreach($currency_setup->result() as $currency_s){if($currency_s->currency_type==$this->session->userdata('currency_type')){$SelecTed='selected="selected"';}else{$SelecTed='';}?>             
  <option value="<?php echo base_url(); ?>change-currency/<?php echo $currency_s->id; ?>" <?php echo $SelecTed; ?>><?php echo $currency_s->currency_type; ?></option><?php } } ?></select></div></div>
  
  <div class="col-md-3">
      <ul class="footer-list">
          <li><span><?php if($this->lang->line('Company') != '') { echo stripslashes($this->lang->line('Company')); } else echo "Company"; ?></span></li>
          <?php if ($cmsList->num_rows() > 0){
            foreach ($cmsList->result() as $key => $row){if ($row->seourl != 'help') {?>

          <li class="<?php if($key > 6) {echo 'moreCompany';} ?>"><a href="pages/<?php echo $row->seourl; ?>"><?php echo $row->page_name;?></a></li>

          <?php } 
          else {?>

          <li><a href="<?php echo $row->seourl; ?>"><?php echo $row->page_name;?></a></li>
          
          <?php } } }  ?>

          <?php if($cmsList->num_rows() > 6) {
            echo "<span class='companyToggle'>Show More</span>";
          } ?>

      </ul>
  </div>
  
  
 
  
   <div class="col-md-3"><ul class="footer-list"><li><span><?php if($this->lang->line('Service') != '') { echo stripslashes($this->lang->line('Service')); } else echo "Service"; ?></span></li><li><a href="contact-us"><?php if($this->lang->line('Contact Us') != '') { echo stripslashes($this->lang->line('Contact Us')); } else echo "Contact Us"; ?></a></li><li><a href="help"><?php if($this->lang->line('Help') != '') { echo stripslashes($this->lang->line('Help')); } else echo "Help"; ?></a></li>
   <?php if ($cmsListServices->num_rows() > 0){
            foreach ($cmsListServices->result() as $key => $row){ if ($row->seourl != 'help') {?>

          <li ><a href="pages/<?php echo $row->seourl; ?>"><?php echo $row->page_name;?></a></li>

          <?php } 
          else {?>

          <li><a href="<?php echo $row->seourl; ?>"><?php echo $row->page_name;?></a></li>
          
          <?php } } }  ?>

          
   
   </ul></div>
  
  <div class="col-md-3" id="foot_soicons"><div class="copy-txt footer-bottom"><ul class="footer-list">

<li style="<?php if ($this->config->item('facebook_link')!='') { echo "display:inline-block"; } else { echo "display:none"; } ?>"><a target="_blank" title="<?php if($this->lang->line('Facebook') != '') { echo stripslashes($this->lang->line('Facebook')); } else echo "Facebook";?>" href="<?php echo $this->config->item('facebook_link');?>" alt="<?php if($this->lang->line('signup_facebook') != '') { echo stripslashes($this->lang->line('signup_facebook')); } else echo "Facebook";?>"><i class="fa fa-facebook"></i></a></li>


<li style="<?php if ($this->config->item('twitter_link')!='') { echo "display:inline-block"; } else { echo "display:none"; } ?>"><a target="_blank" title="<?php if($this->lang->line('Twitter') != '') { echo stripslashes($this->lang->line('Twitter')); } else echo "Twitter";?>" href="<?php echo $this->config->item('twitter_link');?>" alt="<?php if($this->lang->line('signup_twitter') != '') { echo stripslashes($this->lang->line('signup_twitter')); } else echo "Twitter";?>"><i class="fa fa-twitter"></i></a></li>


<li style="<?php if ($this->config->item('googleplus_link')!='') { echo "display:inline-block"; } else { echo "display:none"; } ?>"><a target="_blank" title="<?php if($this->lang->line('Google plus') != '') { echo stripslashes($this->lang->line('Google plus')); } else echo "Google plus";?>" href="<?php echo $this->config->item('googleplus_link');?>" alt="<?php if($this->lang->line('signup_google') != '') { echo stripslashes($this->lang->line('signup_google')); } else echo "Google+";?>"><i class="fa fa-google-plus"></i></a></li>
  
<li style="<?php if ($this->config->item('youtube_link')!='') { echo "display:inline-block"; } else { echo "display:none"; } ?>">
<a target="_blank" title="<?php if($this->lang->line('Youtube') != '') { echo stripslashes($this->lang->line('Youtube')); } else echo "Youtube";?>" href="<?php echo $this->config->item('youtube_link');?>" alt="<?php if($this->lang->line('signup_youtube') != '') { echo stripslashes($this->lang->line('signup_youtube')); } else echo "Youtube";?>"><i class="fa fa-youtube-play"></i></a></li>
  
  <li style="<?php if ($this->config->item('pinterest')!='') { echo "display:inline-block"; } else { echo "display:none"; } ?>"><a target="_blank" title="<?php if($this->lang->line('Pinterest') != '') { echo stripslashes($this->lang->line('Pinterest')); } else echo "Pinterest";?>" href="<?php echo $this->config->item('pinterest');?>" alt="<?php if($this->lang->line('pinterest') != '') { echo stripslashes($this->lang->line('pinterest')); } else echo "Pinterest";?>"><i class="fa fa-pinterest"></i></a></li>
  </ul></div></div>



<!--</div>-->
</div></div>
<!--<link rel="stylesheet" media="all" href="css/site/style-responsive.css" type="text/css" />--->
<link rel="stylesheet" media="all" href="css/site/style-responsive-only.css" type="text/css" /><script type="text/javascript" src="<?php echo base_url(); ?>js/site/jquery-ui.js"></script></footer><div class="copy-txt col-md-12 footer-bottom"><p><?php echo stripslashes($this->config->item('footer_content'));?><!-- &nbsp;version - <?php //echo CI_VERSION; ?> --></p></div>
<!---FOOTER-->
<script type="text/javascript">$('.country-lop').click(function(){ if($(this).find('.dropdn').css('display')=='none'){ $(this).find('.dropdn').css('display','block'); $(this).next().find('.dropdn').css('display','none'); $(this).prev().find('.dropdn').css('display','none'); }else{$('.dropdn').css('display','none');}});$(function(){$('.dropdn').each(function(){var selected_language=$(this).find('.active').text();if(selected_language !=''){$(this).prev('input').val(selected_language);}})}); $(function(){$(window).scroll(function(){if($(window).scrollTop()==0){$('.header').css('padding','27px 0 20px');}else{$('.header').css('padding','7px 0 0px');}})});</script><script type="text/javascript">
$('.left carousel-control').click(function() {$('#carousel-example-generic').carousel('prev');});$('.right carousel-control').click(function() {  $('#carousel-example-generic').carousel('next');});</script><?php if($this->config->item('google_verification_code')){ echo "<script type='text/javascript'>".stripslashes($this->config->item('google_verification_code'))."</script>"; } ?>

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on("click",".companyToggle", function(){
      $(this).siblings(".moreCompany").toggle(300);
      
      if($(this).html() == "Show More"){

        $(this).html("Show Less");
      }
      else if($(this).html() == "Show Less"){
        $(this).html("Show More"); 
      }
    });
  });
</script>

<?php /* Contact us popup starts */ ?><?php if(!$this->uri->segment(1)){ ?><script>$( document ).ready(function() {  //  $('.topmtab>.owl-wrapper-outer>.owl-wrapper>.owl-item').attr('style','width: 275px');//	$('.topmtab>.owl-wrapper-outer>.owl-wrapper>.owl-item>.post-slide>.btn').attr('style','width: 275px');});</script><style>@media screen and (max-width: 667px) {  .banner-container {  }  #mobile_version {   }  .maincontent{margin-top:50px;}  .tabarraow{bottom:8px !important;}   .topmtab>.owl-controls{bottom:-216px !important;}   .topmtab>.owl-wrapper-outer{margin-left:-10px;}   .topmtab>.owl-item{width:175px !important;}      .mobweform{margin-top:-18px;}}</style><?php } ?>
</body></html>



