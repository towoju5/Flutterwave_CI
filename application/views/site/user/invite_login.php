<?php $this->load->view('site/templates/header');?>
<?php
foreach($query as $Row)
{
$user_image = $Row->image;
}

?>
<div class="invit-banner">
 	<div class="pic11">
	<!--	<img src="<?php echo base_url('images/users/'.$user_image.''); ?>" alt="">-->
		<img width="20"  src="<?php if($user_image!='') { echo base_url(); ?>images/users/<?php echo $user_image; } else echo "images/user_unknown.jpg";?>" style="height: inherit;float:left; margin:-1px 0px 0px 0px;"alt="">

	</div>
					<a href="javascript:void(0);" class="reg-popup"><input class="invi_but" style="border-color: #ff5a5f;border-bottom-color: #e00007;background-color: #ff5a5f;color: #fff;" value="Sign up to claim your credit" type="button"></a>
</div>
<div class="visit-container">
	
<div class="col-sm-12 credit-content">
<h1><center><?php if($this->lang->line('How_it_Works') != '') { echo stripslashes($this->lang->line('How_it_Works')); } else echo "How it Works";?>
 </center></h1>
<p class="ptxt"><center><?php if($this->lang->line('Rent unique, local accommodations on any budget, anywhere in the world') != '') { echo stripslashes($this->lang->line('Rent unique, local accommodations on any budget, anywhere in the world')); } else echo "Rent unique, local accommodations on any budget, anywhere in the world";?>.</center> </p>
</div>



  
<div class="row">  
  <div class="col-md-4"><center><h4><?php if($this->lang->line('Explore') != '') { echo stripslashes($this->lang->line('Explore')); } else echo "Explore";?></center></h4> <p class="cont"><?php if($this->lang->line('Find_the_perfect_place') != '') { echo stripslashes($this->lang->line('Find_the_perfect_place')); } else echo "Find the perfect place";?>
.</p></div>  
 
  <div class="col-md-4"><center><h4><?php if($this->lang->line('footer_contact') != '') { echo stripslashes($this->lang->line('footer_contact')); } else echo "Contact";?></center></h4> <p class="cont"><?php if($this->lang->line('Message hosts') != '') { echo stripslashes($this->lang->line('Message hosts')); } else echo "Message hosts";?>.</p></div>  
 
  <div class="col-md-4"><center><h4><?php if($this->lang->line('Book') != '') { echo stripslashes($this->lang->line('Book')); } else echo "Book";?></center></h4> <p class="cont"><?php if($this->lang->line('View_your_itinerary') != '') { echo stripslashes($this->lang->line('View_your_itinerary')); } else echo "View your itinerary";?>
.</p></div>  
 
 
</div>  
</div>

<?php

$this->load->view('site/templates/footer');
?>
