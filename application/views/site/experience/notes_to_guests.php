<?php $this->load->view('site/templates/header'); 


$this->load->view('site/experience/experience_head_side');?>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>



			<div class="right_side overview schedule-experience">
				 <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('exp_what_else_guest_know') != '') { echo stripslashes($this->lang->line('exp_what_else_guest_know')); } else echo "Is there anything you’d like guests to know before booking?";?></h3>
                        
                        <p><?php if($this->lang->line('exp_mention_anything_that_guests') != '') { echo stripslashes($this->lang->line('exp_mention_anything_that_guests')); } else echo "Is there anything you’d like guests to know before booking?";?> </p>
                    
                    </div>
                   <form onsubmit="return validate_form_new(event)" id="overviewlist" name="overviewlist"  method="post"  accept-charset="UTF-8">

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                       
                    <div class="dashboard_price_right">
                        <div class="exp_det_right">
						
						<span class="error text-center">
						<small> * <?php if($this->lang->line('exp_fill_all_fields') != '') { echo stripslashes($this->lang->line('exp_fill_all_fields')); } else echo "Please fill all mandatory fields"; ?></small>
						</span>
						
						<div class="overview_title margin_top_20 margin_bottom_20 input ">
                        
                          <h4> <?php if($this->lang->line('exp_add_notes') != '') { echo stripslashes($this->lang->line('exp_add_notes')); } else echo "Add notes"; ?><span class="req"><small>*</small></span></h4>
							
							<textarea  maxlength="200" onkeyup="char_count(this)" class="title_overview" placeholder="<?php if($this->lang->line('note_to_guest') != '') { echo stripslashes($this->lang->line('note_to_guest')); } else echo "Notes to guests";?>" rows="8" name="note_to_guest" id="note_to_guest" style="color:#757474 !important;min-width:100%;max-width:100%;min-height: 50px; font-size: 14px;"><?php echo $listDetail->row()->note_to_guest;?></textarea>
							
							<?php
							$string = str_replace(' ', '', $listDetail->row()->note_to_guest);
							$len=mb_strlen($string, 'utf8');
							$remaining=(200-$len);
							?>
							<span class="small_label notes_span"><span id="note_to_guest_char_count"><?php echo $remaining; ?></span> <?php if($this->lang->line('exp_characters_remaining') != '') { echo stripslashes($this->lang->line('exp_characters_remaining')); } else echo "characters remaining"; ?></span>

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
                    
                        <h2><?php if($this->lang->line('experience_details_footnotes') != '') { echo stripslashes($this->lang->line('experience_details_footnotes')); } else echo "Add Footnotes ";?></h2>
                    
                        <p><?php if($this->lang->line('exp_great_summary_footnotes') != '') { echo stripslashes($this->lang->line('exp_great_summary_footnotes')); } else echo "Always ensure that you should be transparent to your guest. Even more explicitly describe your prerequisites to the guest to build credibility in you. ";?></p>
                        
                        <p><strong><?php if($this->lang->line('exp_examples') != '') { echo stripslashes($this->lang->line('exp_examples')); } else echo "Example: ";?> </strong><?php if($this->lang->line('exp_adddtionals_footnotes') != '') { echo stripslashes($this->lang->line('exp_adddtionals_footnotes')); } else echo "Passenger to bring: sneakers, wind jacket, long trousers, and sunglasses. The time may change depending on the weather conditions.";?>  </p>
                        
                    
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

	note_to_guest=$('#note_to_guest').val();
	
	err=0;
	if(note_to_guest==''){
		err=1;
	}

	if(err==1){
		//$('.error').show();
		 $('.error').fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow');
		 });
		 return false;
	}else{
		
		url='<?php echo base_url()."site/experience/add_note_to_guest/".$id;?>';
		$('#overviewlist').attr('method', 'post');
		$('#overviewlist').attr('action', url).submit();
		
	}
}
$(document).ready(function() {
    $('#next-btn').click(function(e) {  
     window.location.href = '<?php echo base_url()."about_exp_host/".$id; ?>';
    });
});

</script>


<?php $this->load->view('site/templates/footer'); ?>