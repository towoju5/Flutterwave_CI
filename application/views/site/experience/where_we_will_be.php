<?php $this->load->view('site/templates/header'); 


$this->load->view('site/experience/experience_head_side');?>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>



			<div class="right_side overview schedule-experience">
				 <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('exp_mention_where') != '') { echo stripslashes($this->lang->line('exp_mention_where')); } else echo "Mention where you'll be";?></h3>
                        
                        <p><?php if($this->lang->line('exp_name_all_the') != '') { echo stripslashes($this->lang->line('exp_name_all_the')); } else echo "Name all the locations you will visit. Give guests a glimpse of why they are meaningful.";?> </p>
                    
                    </div>
                   <form onsubmit="return validate_form_new(event)" id="overviewlist" name="overviewlist"  method="post"  accept-charset="UTF-8">

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                       
                    <div class="dashboard_price_right">
                        <div class="exp_det_right">
						
						<span class="error text-center">
						<small> * <?php if($this->lang->line('exp_fill_all_fields') != '') { echo stripslashes($this->lang->line('exp_fill_all_fields')); } else echo "Please fill all mandatory fields"; ?></small>
						</span>
						
						<div class="overview_title margin_top_20 margin_bottom_20 input ">
                        
                          <h4>Where you will be<span class="req"><small>*</small></span></h4>
							
							<textarea maxlength="250" onkeyup="char_count(this)" name="location_description" id="location_description" class="exp_input"><?php echo $listDetail->row()->location_description;  ?></textarea>
							
							<?php
							$string = str_replace(' ', '', $listDetail->row()->location_description);
							$len=mb_strlen($string, 'utf8');
							$remaining=(250-$len);
							?>
							<span class="small_label we_do_sl"><span id="location_description_char_count"><?php echo $remaining; ?></span><?php if($this->lang->line('exp_characters_remaining') != '') { echo stripslashes($this->lang->line('exp_characters_remaining')); } else echo "characters remaining"; ?></span>
							
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
                    
                        <h2><?php if($this->lang->line('descripe_location') != '') { echo stripslashes($this->lang->line('descripe_location')); } else echo "Describe your Location";?></h2>
                    
                        <p><?php if($this->lang->line('exp_great_summary_location') != '') { echo stripslashes($this->lang->line('exp_great_summary_location')); } else echo "Tell your guests where you’ll be taking them for this experience. Mention any places you’ll visit and hint at why they’re meaningful to you and the overall experience.";?></p>
                        
                        <p><strong><?php if($this->lang->line('exp_examples') != '') { echo stripslashes($this->lang->line('exp_examples')); } else echo "Example";?>: </strong><?php if($this->lang->line('exp_additionally_location') != '') { echo stripslashes($this->lang->line('exp_additionally_location')); } else echo "We’ll most likely go up to Kloof Corner Ridge, a superb ridge line scramble towards the upper Cabbleway. However, we could do a slightly different version of this run, depending on the weather and ability of the group. After we descend and clean up, we’ll enjoy dinner at one of my favorite restaurants.";?>   </p>
                        
                    
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

	location_description=$('#location_description').val();
	
	err=0;
	if(location_description==''){
		err=1;
	}

	if(err==1){
		//$('.error').show();
		 $('.error').fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow');
		 });
		 return false;
	}else{
		
		url='<?php echo base_url()."site/experience/add_location_description/".$id;?>';
		$('#overviewlist').attr('method', 'post');
		$('#overviewlist').attr('action', url).submit();
		
	}
}
$(document).ready(function() {
    $('#next-btn').click(function(e) {  
     window.location.href = '<?php echo base_url()."location_details/".$id; ?>';
    });
});

</script>


<?php $this->load->view('site/templates/footer'); ?>