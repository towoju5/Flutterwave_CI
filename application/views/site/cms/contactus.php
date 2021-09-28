<?php 

$this->load->view('site/templates/header');

?>
<style type="text/css">
.white {
	color: #FFF;
}
</style>


<div class="lang-en wider no-subnav thing signed-out winOS" style="min-height:auto;">

 <div id="container-wrapper">

<div class="contact">

 <section>

<div class="contact-us">

  <div class="container">

   <div class="contact-space">

    <h2 class="contac-text cnt_head"><?php if($this->lang->line('Contact Us') != '') { echo stripslashes($this->lang->line('Contact Us')); } else echo "Contact Us";?></h2>

      <div class="col-md-6 backgr">
      
      <ul class="contact-area">
<div>
		<li>

        <div class="white">

		  <p><strong>You may contact Occupyproperties below or by email at contact@occupyproperties.com.</strong>
		    
	      </p>
		  
        </div>
        
        <div>
		<li>

        <div class="white">

		  <p><strong> 
          Office Address:


           </strong>
		    
	      </p>
		  <p>&nbsp;</p>
        </div>
     
      
<form action="site/cms/contactus" id="form" method="post" accept-charset="UTF-8">

<ul class="contact-area">

		<li>

        <div class="col-md-4">

		<label class="text-name"><?php if($this->lang->line('Your Name') != '') { echo stripslashes($this->lang->line('Your Name')); } else echo "Your Name";?>:</label>

		</div>

		

         <div class="col-md-7">

		 <input id="name" name="name" placeholder="<?php if($this->lang->line('Your Name') != '') { echo stripslashes($this->lang->line('Your Name')); } else echo "Your Name";?>" class="cnt-bx" 

		 type="text" 

		 

		 <?php if ($loginCheck == '')

		 { ?> value="" 

		 <?php }

		 else

		 { ?>

		 value= " <?php echo $userDetails->row()->user_name;?>">

		 <?php } ?>

		 </div>

      

       </li>





           <li>

        <div class="col-md-4"><label class="text-name"><?php if($this->lang->line('Email') != '') { echo stripslashes($this->lang->line('Email')); } else echo "Email";?>:</label></div>

         <div class="col-md-7"><input  id="contact_email" name="email" placeholder="<?php if($this->lang->line('Your@yourcompany.com') != '') { echo stripslashes($this->lang->line('Your@yourcompany.com')); } else echo "Your@yourcompany.com";?>" class="cnt-bx" required type="email"

          <?php if ($loginCheck == '')  

		 { ?> value="" 

		 <?php }

		 else

		 { ?>

		  value= " <?php echo $userDetails->row()->email;?>">

		 <?php } ?>

         

         </div>

        </li>



      



           <li>

        <div class="col-md-4"><label class="text-name"><?php if($this->lang->line('Subject') != '') { echo stripslashes($this->lang->line('Subject')); } else echo "Subject";?>:</label></div>

          <?php 

        

        	if($_GET['a'] !='')

        	{?>

        	<div class="col-md-7"><input name="subject" id="subject" class="cnt-bx widful" value="<?php echo $_GET['a'];?>"></div>

       <?php }else { ?>

         <div class="col-md-7"><input placeholder="<?php if($this->lang->line('General Enquiry') != '') { echo stripslashes($this->lang->line('General Enquiry')); } else echo "General Enquiry";?>" name="subject" id="subject" class="cnt-bx widful" type="text"></div>

        <?php }?> </li>





           <li>

        <div class="col-md-4"><label class="text-name"><?php if($this->lang->line('Message') != '') { echo stripslashes($this->lang->line('Message')); } else echo "Message";?>:</label></div>

         <div class="col-md-7" id="ctn_form"><textarea class="cnt-bx widful" name="msg"  id="msg" type="text"></textarea></div>

        </li>

          











           <li class="ct_capt">

        <div class="col-md-4"></div>

         <div class="col-md-7" style="color:white">

         <?php

					     

					      require_once 'captcha/securimage.php';

					      $options = array();

					      $options['input_name'] = 'ct_captcha'; 

					        

					      if (!empty($_SESSION['ctform']['captcha_error'])) {

					       

					        $options['error_html'] = $_SESSION['ctform']['captcha_error'];

					      }

					

					      echo Securimage::getCaptchaHtml($options);

					    ?></div>

         </li>





          



          <li class="cap_tt">

       <?php /*?> <div class="col-md-4"></div>

           <div class="col-md-7"><input class="get-code" value="Get Code" type="submit"></div>

         </li>



 <li>

        <div class="col-md-4"></div>

         <div class="col-md-7"><input placeholder="Security Code" name="security_code" id="security_code" class="cnt-bx widful" type="text"></textarea></div>

         </li>*/ ?>





<input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">

          <li>

        <div class="col-md-4"></div>

         <div class="col-md-7"><input class="send-btd" value="<?php if($this->lang->line('Send') != '') { echo stripslashes($this->lang->line('Send')); } else echo "Send"; ?>" type="button" onclick="checkval()";></div>

         </li>

    </ul>

      </form>

</div>

















<div class="col-md-6">

  <div class="address-section">

  

<div class="address-contained">

 <p> 

 <?php echo $cmscontactus->row()->description;?>   

</p>

  

</div>



 <?php /*?> <div class="map-frame">

  <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3971.8742511119563!2d100.3114405!3d5.436062499999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sHunza+Tower%2CGurney+Paragon%2C+Jalan+Kelawai%2C10250%2C+Penang.!5e0!3m2!1sen!2sin!4v1417184761768" width="500" height="200" frameborder="0" style="border:0"></iframe>

  </div> */?>



  <ul class="social-side">

    <li><a href="<?php echo $this->config->item('facebook_link'); ?>" target="_blank"></a></li>

    <li><a class="g1" href="<?php echo $this->config->item('twitter_link'); ?>" target="_blank"></a></li>

      <li><a class="g2" href="<?php echo $this->config->item('googleplus_link'); ?>" target="_blank"></a></li>

  </ul>

  

  





   </div>    



<div>

<div>

</section>

</div>



</div>

</div>

<script type="text/javascript">

function checkval()

{

	var name = $('#name').val();

	var email = $('#contact_email').val();

	var subject = $('#subject').val();

  var date = $('#date').val();

	var msg = $('#msg').val();

	  if(name==''){

		alert('<?php if($this->lang->line('Full name required') != '') { echo stripslashes($this->lang->line('Full name required')); } else echo "Full name required";?>');

	}else if(email==''){

		alert('<?php if($this->lang->line('Email required') != '') { echo stripslashes($this->lang->line('Email required')); } else echo "Email required";?>');

	}else if(subject==''){

		alert('<?php if($this->lang->line('Subject required') != '') { echo stripslashes($this->lang->line('Subject required')); } else echo "Subject required";?>');

	}else if(msg==''){

		alert('<?php if($this->lang->line('Message required') != '') { echo stripslashes($this->lang->line('Message required')); } else echo "Message required";?>');

	}else

	{

		$("#form").submit();

	}

}

<?php /*?>var email = document.forms["form"]["email"].value;

var atpos = email.indexOf("@");

var dotpos = email.lastIndexOf(".");

if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=email.length) {

    alert("Not a valid e-mail address");

    return false;

} */?>

</script>



<?php

$this->load->view('site/templates/footer');

?>