<?php $this->load->view('site/templates/header'); ?>
<section>
  <div class="learn-more-about-hosting-page">
  <div class="container">


    	  <div class="col-sm-12">
    	  
    	  	<div class="how-it-box">
    	  	
    	  		<div class="how-top-box">
    	  	
    	  		<h2><?php if($this->lang->line('Start earning money today') != '') { echo stripslashes($this->lang->line('Start earning money today')); } else echo "Start earning money today";?></h2>
    	  		  <ul class="nav">
    	  		 
    	  		<button onclick="window.location.href='list_space'" class="text-submit-btn" ><?php if($this->lang->line('List Your Space') != '') { echo stripslashes($this->lang->line('List Your Space')); } else echo "List Your Space";?></button>
    	  		
    	  		</div>
    	  		
    	  		<div class="advantages">
    	  		
    	  			<?php echo stripslashes($cmslearnmore->row()->description);?>
    	  			
    	  		
    	  		
    	  		</div>

          </div>
  

         <div class="col-sm-12">
      
      			<div class="how-links"><?php if($this->lang->line('Any questions about being a guest, check out our') != '') { echo stripslashes($this->lang->line('Any questions about being a guest, check out our')); } else echo "Any questions about being a guest, check out our";?> <a href="pages/faq"><?php if($this->lang->line('FAQs') != '') { echo stripslashes($this->lang->line('FAQs')); } else echo "FAQs";?></a> <?php if($this->lang->line('or') != '') { echo stripslashes($this->lang->line('or')); } else echo "or";?> <a href="contact-us"><?php if($this->lang->line('drop us a line') != '') { echo stripslashes($this->lang->line('drop us a line')); } else echo "drop us a line";?></a></div>
      
 
  		 </div>


</section>

<script>
function change_next(evt){
	$(evt).parent().prev().find('li.active').next().find('a').trigger('click');

}
function change_previous(evt)
{
	$(evt).parent().prev().find('li.active').prev().find('a').trigger('click');
}
</script>


<?php $this->load->view('site/templates/footer');?>