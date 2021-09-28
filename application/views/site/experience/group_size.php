<?php $this->load->view('site/templates/header'); 


$this->load->view('site/experience/experience_head_side');?>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>



			<div class="right_side overview schedule-experience">
				 <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('exp_maximum_number_ofGuests') != '') { echo stripslashes($this->lang->line('exp_maximum_number_ofGuests')); } else echo "Maximum number of guests";?></h3>
                        
                        <p><?php if($this->lang->line('exp_num_of_guest_accommodate') != '') { echo stripslashes($this->lang->line('exp_num_of_guest_accommodate')); } else echo "What's the number of guests you can accommodate?

";?> </p>
                    
                    </div>
                   <form onsubmit="return validate_form_new(event)" id="overviewlist" name="overviewlist"  method="post"  accept-charset="UTF-8">

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                       
                    <div class="dashboard_price_right">
                        <div class="exp_det_right">
						
						<span class="error text-center">
						<small> * <?php if($this->lang->line('exp_fill_group_size') != '') { echo stripslashes($this->lang->line('exp_fill_group_size')); } else echo "Please fill group size"; ?></small>
						</span>
						
						<div class="overview_title margin_top_20 margin_bottom_20 input ">

							<input class="title_overview number_field gp_sz_inpt" placeholder="<?php if($this->lang->line('group_size') != '') { echo stripslashes($this->lang->line('group_size')); } else echo "Group size";?>" name="group_size" id="group_size" value="<?php echo $listDetail->row()->group_size;?>" maxlength="2">
							
							
							<?php 
							/*
							if(!empty($minimum_stay)){
								?>
								<div class="select">
								<select name="group_size" id="group_size">
								<option value="">-<?php if($this->lang->line('exp_select_size') != '') { echo stripslashes($this->lang->line('exp_select_size')); } else echo "Select size"; ?>-</option>
								<?php
								//print_r($minimum_stay);
								foreach($minimum_stay as $size){
									$selected='';
									if($listDetail->row()->group_size==$size->child_name){
										$selected='selected';
									}
									echo '<option value="'.$size->child_name.'" '.$selected.'>'.$size->child_name.'</option>';
								}
								?>
								</select>
								</div>
								<?php
							}else{
								?>
								<input class="title_overview number_field" placeholder="<?php if($this->lang->line('group_size') != '') { echo stripslashes($this->lang->line('group_size')); } else echo "Group size";?>" name="group_size" id="group_size" value="<?php echo $listDetail->row()->group_size;?>" maxlength="2">
								<?php
							}
							*/
							?>
							
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
                    
                        <h2><?php if($this->lang->line('experience_details_precise') != '') { echo stripslashes($this->lang->line('experience_details_precise')); } else echo "Be Precise";?></h2>
                    
                        <p><?php if($this->lang->line('exp_great_summary_prices') != '') { echo stripslashes($this->lang->line('exp_great_summary_prices')); } else echo "Make sure that you have entered a right count. Don’t forget to maintain the quality of service for each guest throughout the Experience. You don’t have to fill all of them. Experiences are meant to be social, so other travelers could join too.";?></p>
                        
                       
                        
                    
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

	group_size=$('#group_size').val();
	
	err=0;
	if(group_size==''){
		err=1;
	}

	if(err==1){
		//$('.error').show();
		 $('.error').fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow');
		 });
		 return false;
	}else{
		
		url='<?php echo base_url()."site/experience/add_group_size/".$id;?>';
		$('#overviewlist').attr('method', 'post');
		$('#overviewlist').attr('action', url).submit();
		
	}
}
$(document).ready(function() {
    $('#next-btn').click(function(e) {  
     window.location.href = '<?php echo base_url()."price/".$id; ?>';
    });
});

</script>


<?php $this->load->view('site/templates/footer'); ?>