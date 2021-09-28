<?php $this->load->view('site/templates/header'); 


$this->load->view('site/experience/experience_head_side');?>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>



            <div class="right_side overview">
                 <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('guest_requirement_new') != '') { echo stripslashes($this->lang->line('guest_requirement_new')); } else echo "Have any guest requirements?";?></h3>
                        
                        <p>Mention anything that guests will have to bring with them or arrange on their own, like transportation. </p>
                    
                    </div>
                   
				     <form onsubmit="return validate_form_new(event)" id="overviewlist" name="overviewlist"  method="post"  accept-charset="UTF-8">
					 
				   <?php /*<form onsubmit="return validate_form()" id="guest_requirement_form" name="guest_requirement_form" action="<?php echo base_url()."experience_cancel_policy/".$listDetail->row()->id;?>" method="post" accept-charset="UTF-8">*/?>

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                       
                    <div class="dashboard_price_right">

                        <div class="overview_title">
                        
                            <h4><?php if($this->lang->line('guest_requirement') != '') { echo stripslashes($this->lang->line('guest_requirement')); } else echo "Guest requirements";?> <small> <?php /*if($this->lang->line('Maximum150words') != '') { echo stripslashes($this->lang->line('Maximum150words')); } else echo "Maximum 150 words";*/?></small></h4>
                            
                            <?php /*<textarea class="title_overview" id="guest_requirement" placeholder="<?php if($this->lang->line('guest_requirement') != '') { echo stripslashes($this->lang->line('guest_requirement')); } else echo "Details about Guest Requirement";?>" rows="8" onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'guest_requirement');" name="guest_requirement" id="guest_requirement" style="color:#757474 !important;min-width:100%;max-width:100%;min-height: 250px; font-size: 14px;"><?php echo strip_tags($listDetail->row()->guest_requirement);?></textarea> */?>
							
							
							<textarea  maxlength="250" onkeyup="char_count(this)" class="title_overview" placeholder="<?php if($this->lang->line('guest_requirement') != '') { echo stripslashes($this->lang->line('guest_requirement')); } else echo "Details about Guest Requirement";?>" rows="8" name="guest_requirement" id="guest_requirement" style="color:#757474 !important;min-width:100%;max-width:100%;min-height:100px; font-size: 14px;"><?php echo $listDetail->row()->guest_requirement;?></textarea>
							
							<?php
							$string = str_replace(' ', '', $listDetail->row()->guest_requirement);
							$len=mb_strlen($string, 'utf8');
							$remaining=(250-$len);
							?>

                           <span class="small_label notes_span"><span id="guest_requirement_char_count"><?php echo $remaining; ?></span> <?php if($this->lang->line('exp_characters_remaining') != '') { echo stripslashes($this->lang->line('exp_characters_remaining')); } else echo "characters remaining"; ?></span>
                        
                        </div>


                            
                    </div>
                    <div class="exp-pic">
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
                    
                        <h2><?php if($this->lang->line('guest_requirement_transparent') != '') { echo stripslashes($this->lang->line('guest_requirement_transparent')); } else echo "Be Transparent"; ?></h2>
                    
                        <p><?php if($this->lang->line('exp_description_the_req_transparent') != '') { echo stripslashes($this->lang->line('exp_description_the_req_transparent')); } else echo "Always add a footnote to your guest. It helps them to make extra precautions. Add any age limits, certifications, or abilities required for your experience. Give a vivid description about your requirements to the guest which builds credibility in you. "; ?></p>
                        
                        
                        
                    
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

	guest_requirement=$('#guest_requirement').val();
	
	err=0;
	if(guest_requirement==''){
		err=1;
	}

	if(err==1){
		//$('.error').show();
		 $('.error').fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow');
		 });
		 return false;
	}else{
		
		url='<?php echo base_url()."site/experience/add_guest_requirements/".$id;?>';
		$('#overviewlist').attr('method', 'post');
		$('#overviewlist').attr('action', url).submit();
		
	}
}
$(document).ready(function() {
    $('#next-btn').click(function(e) {  
     window.location.href = '<?php echo base_url()."group_size/".$id; ?>';
    });
});

</script>

<?php $this->load->view('site/templates/footer'); ?>