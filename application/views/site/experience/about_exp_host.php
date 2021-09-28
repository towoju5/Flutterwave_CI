<?php $this->load->view('site/templates/header'); 


$this->load->view('site/experience/experience_head_side');?>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>



			<div class="right_side overview schedule-experience">
				 <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('exp_write_your_bio') != '') { echo stripslashes($this->lang->line('exp_write_your_bio')); } else echo "Write your bio";?></h3>
                        
                        <p><?php if($this->lang->line('exp_describe_yourself') != '') { echo stripslashes($this->lang->line('exp_describe_yourself')); } else echo "Describe yourself and tell guests how came to be passionate about hosting this experience.

";?> </p>
                    
                    </div>
                   <form onsubmit="return validate_form_new(event)" id="overviewlist" name="overviewlist"  method="post"  accept-charset="UTF-8">

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                       
                    <div class="dashboard_price_right">
                        <div class="exp_det_right">
						
						<span class="error text-center">
						<small> * <?php if($this->lang->line('exp_fill_all_fields') != '') { echo stripslashes($this->lang->line('exp_fill_all_fields')); } else echo "Please fill all mandatory fields"; ?></small>
						</span>
						
						<div class="overview_title margin_top_20 margin_bottom_20 input ">

							<textarea  maxlength="250" onkeyup="char_count(this)" class="title_overview" placeholder="<?php if($this->lang->line('about_host') != '') { echo stripslashes($this->lang->line('about_host')); } else echo "About you";?>" rows="8" name="about_host" id="about_host" style="color:#757474 !important;min-width:100%;max-width:100%;min-height: 50px; font-size: 14px;"><?php echo $listDetail->row()->about_host;?></textarea>
							<?php
							$string = str_replace(' ', '', $listDetail->row()->about_host);
							$len=mb_strlen($string, 'utf8');
							$remaining=(250-$len);
							?>
							<span class="small_label notes_span"><span id="about_host_char_count"><?php echo $remaining; ?></span> <?php if($this->lang->line('exp_characters_remaining') != '') { echo stripslashes($this->lang->line('exp_characters_remaining')); } else echo "characters remaining"; ?></span>
                        </div>
						
                    	
						
						
						
                    </div>
              	
                    </div>

                     <div class="basic-next">
					 <button class="next_button" type="submit"><?php if($this->lang->line('Save_and_Continue') != '') { echo stripslashes($this->lang->line('Save_and_Continue')); } else echo "Save & Continue";?></button>
					 </div>

                </form>


                </div>
            
            </div>
            
            </div>
            
            
            <div class="calender_comments">
            
                <div class="calender_comment_content">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
                    
                    <div class="calender_comment_text">
                    
                        <h2><?php if($this->lang->line('experience_details_intro') != '') { echo stripslashes($this->lang->line('experience_details_intro')); } else echo "A Short Intro";?></h2>
                    
                        <p><?php if($this->lang->line('exp_great_summary_intro') != '') { echo stripslashes($this->lang->line('exp_great_summary_intro')); } else echo "Sometimes the words we leave unspoken are the most important ones that should have been said. So don’t miss this opportunity to speak about you. Give a short biography of you.";?></p>
                        
                        <p><strong><?php if($this->lang->line('exp_examples') != '') { echo stripslashes($this->lang->line('exp_examples')); } else echo "Adddtionals";?>: </strong><?php if($this->lang->line('exp_additionally_intro') != '') { echo stripslashes($this->lang->line('exp_additionally_intro')); } else echo "I followed my passion since I was child. I loved to build and fly paper airplanes. I started to fly at the age of 16, now I'm professional paragliding pilot, I participate in international competitions like Paragliding World Cup in many nation and European championships with paragliding Italian national team.";?>  </p>
                        
                    
                    </div>
                    
                    
                
                </div>
            
            </div>
            
        
        </div>
        
    </div>

<script type="text/javascript">

	 function checkSpcialChar(event){
	 
		if(!((event.keyCode >= 65) && (event.keyCode <= 90) || (event.keyCode >= 97) && (event.keyCode <= 122) || (event.keyCode >= 48) && (event.keyCode <= 57))){
		   event.returnValue = false;	
		   return;
		}
		event.returnValue = true;
	 }

</script>
<style>
.content{
height:44px !important;
}
</style>






<script>

function validate_form_new(e){

	about_host=$('#about_host').val();
	
	err=0;
	if(about_host==''){
		err=1;
	}

	if(err==1){
		//$('.error').show();
		 $('.error').fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow');
		 });
		 return false;
	}else{
		
		url='<?php echo base_url()."site/experience/add_about_exp_host/".$id;?>';
		$('#overviewlist').attr('method', 'post');
		$('#overviewlist').attr('action', url).submit();
		
	}
}
$(document).ready(function() {
    $('#next-btn').click(function(e) {  
     window.location.href = '<?php echo base_url()."guest_requirement/".$id; ?>';
    });
});

</script>


<?php $this->load->view('site/templates/footer'); ?>