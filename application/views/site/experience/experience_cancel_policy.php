<?php $this->load->view('site/templates/header'); 


$this->load->view('site/experience/experience_head_side');?>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>



            <div class="right_side overview">
                 <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left cnltn_head">
                    
						
						
                        <h3 id="can_plcy_main">Cancellation Policy</h3>
                        
                        <p><?php if($this->lang->line('AtitlecancelPolicy') != '') { echo stripslashes($this->lang->line('AtitlecancelPolicy')); } else echo "Choose your cancellation Policy";?> </p>
                    
                    </div>
               <!--    <form onsubmit="return validate_form()" id="experience_cancel_policy" name="experience_cancel_policy" action="<?php //echo base_url()."manage_experience/".$listDetail->row()->id;?>" method="post">-->
				     <form onsubmit="return validate_form_new(event)"  id="experience_cancel_policy" name="experience_cancel_policy" method="post" accept-charset="UTF-8">

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                       
                    <div class="dashboard_price_right">
						<span class="error text-center">
						<small> * <?php if($this->lang->line('exp_fill_all_fields') != '') { echo stripslashes($this->lang->line('exp_fill_all_fields')); } else echo "Please fill all mandatory fields"; ?></small>
						</span>
						
					<div class="cancel_policy_security">
					
					
                        <div class="overview_title margin_top_20 margin_bottom_20">
                        
                            <label><?php if($this->lang->line('CancellationPolicy') != '') { echo stripslashes($this->lang->line('CancellationPolicy')); } else echo "Cancellation Policy";?> <small> <?php /*if($this->lang->line('Maximum150words') != '') { echo stripslashes($this->lang->line('Maximum150words')); } else echo "Maximum 150 words";*/?></small></label>

							<?php /* onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'cancel_policy');"*/ ?>
                            <select class="gends" name="cancel_policy" id="cancel_policy_1" onchange="show_val(this);">
                  
                          
                                <option value="Flexible" <?php if(!empty($listDetail)){ if($listDetail->row()->cancel_policy=='Flexible'){echo 'selected="selected"';}}?>><?php if($this->lang->line('exp_flexible') != '') { echo stripslashes($this->lang->line('exp_flexible')); } else echo "Flexible"; ?></option>
                                <option value="Moderate" <?php if(!empty($listDetail)){ if($listDetail->row()->cancel_policy=='Moderate'){echo 'selected="selected"';}}?>><?php if($this->lang->line('exp_moderate') != '') { echo stripslashes($this->lang->line('exp_moderate')); } else echo "Moderate"; ?></option>
                            <option value="Strict" <?php if(!empty($listDetail)){ if($listDetail->row()->cancel_policy=='Strict'){echo 'selected="selected"';}}?>><?php if($this->lang->line('exp_strict') != '') { echo stripslashes($this->lang->line('exp_strict')); } else echo "Strict"; ?></option>

                            <option value="No Return" <?php if(!empty($listDetail)){ if($listDetail->row()->cancel_policy=='No Return'){echo 'selected="selected"';}}?>>No Return</option>
                            </select>
                            
                            <?php /*
                            <textarea class="title_overview" id="cancel_policy" placeholder="<?php if($this->lang->line('Minimum150words') != '') { echo stripslashes($this->lang->line('Minimum150words')); } else echo "Minimum 150 words";?>" rows="8" onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'cancel_policy');" name="cancel_policy" id="cancel_policy" style="color:#000 !important;min-width:100%;max-width:100%;min-height: 250px"><?php echo strip_tags($listDetail->row()->cancel_policy);?></textarea>
                            <?php */ ?>
                            <!--<span>250 characters left</span>-->
                        
                        </div>
						
						
						<div class="overview_title">
                        
                        <label><?php if($this->lang->line('SecurityDeposit') != '') { echo stripslashes($this->lang->line('SecurityDeposit')); } else echo "Security Deposit";?>(<?php if($this->lang->line('optional') != '') { echo stripslashes($this->lang->line('optional')); } else echo "Optional"; ?>) </label>
						
						<input type="text" name="currency" readOnly value="<?php echo $currentCurrency_type;?>" style="display:inline-block;" id="cur_name">
						
						<input type="text" id="sec_deposit" name="sec_deposit" onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'security_deposit');" value="<?php  echo  ($listDetail->row()->security_deposit>0) ? $listDetail->row()->security_deposit : ''; ?>" style="display:inline-block;">

                        
                        </div> 
						<div id="return_amount_percentage" <?php if($listDetail->row()->cancel_policy == 'No Return'){?>style="display:none" <?php } ?>>
						<div class="cancel-listrow cnltn_plcy_frm" >
					<label class="depost"><?php if($this->lang->line('Return_amount') != '') { echo stripslashes($this->lang->line('Return_amount')); } else echo "Return Amount"; ?><span class="req">*</span></label>

					<input type="text" maxlength="2" value="<?php echo $listDetail->row()->cancel_percentage;?>" class="number_field2 per_amount_scroll" onkeypress="return check_for_num(event)" id="cancel_percentage" name="cancel_percentage" placeholder="Enter your return amount"  required <?php if($listDetail->row()->cancel_policy == 'No Return' || $listDetail->row()->cancel_policy == 'Strict' || $listDetail->row()->cancel_policy == 'Moderate'){?> readonly <?php } ?>/><span id="pres">%</span>
                    
					</div>
					</div>
						<div class="overview_title">
						<label>
						<?php if($this->lang->line('list_Description') != '') { echo stripslashes($this->lang->line('list_Description')); } else echo " Description";?>
						</label>
							<textarea  maxlength="250" onkeyup="char_count(this)" name="cancel_policy_des" id="cancel_policy_des"><?php echo $listDetail->row()->cancel_policy_des; ?></textarea>
							
							<?php
							$string = str_replace(' ', '', $listDetail->row()->cancel_policy_des);
							$len=mb_strlen($string, 'utf8');
							$remaining=(250-$len);
							?>

						<span class="small_label" id="span_can_bottm_caption">
						<span id="cancel_policy_des_char_count"><?php echo $remaining; ?></span>
						<?php if($this->lang->line('exp_characters_remaining') != '') { echo stripslashes($this->lang->line('exp_characters_remaining')); } else echo "characters remaining"; ?></span>
						
						
						</div>
						
					</div>

<!-- SEO-->

<span class="onclk-text"><?php if($this->lang->line('Want to add SEO tags') != '') { echo stripslashes($this->lang->line('Want to add SEO tags')); } else echo "Want to add SEO tags";?>?&nbsp;<span onclick="show_block_cate('1')"><?php if($this->lang->line('You can add') != '') { echo stripslashes($this->lang->line('You can add')); } else echo "You can add";?>.</span></span>
<div class="" id="monthly" style="display:none" >
   <div class="overview_title cancel-listrow">
      <label><?php if($this->lang->line('Meta Title') != '') { echo stripslashes($this->lang->line('Meta Title')); } else echo "Meta Title";?></label>
      <input type="text" value="<?php echo $listDetail->row()->meta_title;?>" placeholder="<?php if($this->lang->line('Meta Title') != '') { echo stripslashes($this->lang->line('Meta Title')); } else echo "Meta Title";?>" class="title_overview meta_tile" 
         onchange="javascript:UpdateSEO(this,<?php echo $listDetail->row()->id; ?>,'meta_title');" name="meta_title" style="color:#000 !important;" />
      <input type="hidden" id="id" name="id" value="<?php echo $listDetail->row()->id; ?>" />
      <!--<span>35 characters left</span>-->
   </div>
   <div class="overview_title cancel-listrow">
      <label><?php if($this->lang->line('keywords') != '') { echo stripslashes($this->lang->line('keywords')); } else echo "keywords";?></label>
      <textarea class="title_overview" maxlength=150 onkeyup="char_count(this)" placeholder="Keywords" rows="8"  onchange="javascript:UpdateSEO(this,<?php echo $listDetail->row()->id; ?>,'meta_keyword');"  name="meta_keyword" id="meta_keyword" style="color:#000 !important;"><?php echo strip_tags($listDetail->row()->meta_keyword);?></textarea>
	  
	  
							<?php
							$string = $listDetail->row()->meta_keyword;
							$string = str_replace(" ", "", $string);	
							$len=mb_strlen($string, 'utf8');
							$remaining=(150-$len);
							?>
	  
	  <span class="small_label" id="span_can_bottm_caption" style="margin-left: -10px;">
		<span id="meta_keyword_char_count"><?php echo $remaining; ?></span>
		
		<?php if($this->lang->line('exp_characters_remaining') != '') { echo stripslashes($this->lang->line('exp_characters_remaining')); } else echo "characters remaining"; ?></span>
	  
	  
   </div>
   <div class="overview_title cancel-listrow">
      <label><?php if($this->lang->line('MetaDescription') != '') { echo stripslashes($this->lang->line('MetaDescription')); } else echo "Meta Description";?></label>
      <textarea class="title_overview"  maxlength=150 onkeyup="char_count(this)" placeholder="Meta Description" rows="8"  onchange="javascript:UpdateSEO(this,<?php echo $listDetail->row()->id; ?>,'meta_description');"  name="meta_description" id="meta_description" style="color:#000 !important;"><?php echo strip_tags($listDetail->row()->meta_description);?></textarea>
	  
	  
	  							<?php
							$string = $listDetail->row()->meta_description;
							$string = str_replace(" ", "", $string);	
							$len=mb_strlen($string, 'utf8');
							$remaining=(150-$len);
							?>
							
	   <span class="small_label" id="span_can_bottm_caption" style="margin-left: -10px;">
		<span id="meta_keyword_char_count"><?php echo $remaining; ?></span>
		
		<?php if($this->lang->line('exp_characters_remaining') != '') { echo stripslashes($this->lang->line('exp_characters_remaining')); } else echo "characters remaining"; ?></span>
	  
	  
	  
   </div>
</div>

<!-- SEO Ends-->
					
					
					
					
					
					
					
					
					
					
					
                            
						</div>
                        <div class="exp-pic">
                     <button class="next_button" style="width:87px;" type="submit" id="can_pol_btn"><?php if($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save";?></button>

                        </div>
                </form>


                </div>
            
            </div>
            
            </div>
            
            
            <div class="calender_comments">
            
                <div class="calender_comment_content">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
                    
                    <div class="calender_comment_text">
                    
                        <h2><?php if($this->lang->line('Cancellation_policies_exp') != '') { echo stripslashes($this->lang->line('Cancellation_policies_exp')); } else echo "Cancellation Policies";?></h2>
                    
                        <p><?php if($this->lang->line('exp_detailed_description_about_cancel') != '') { echo stripslashes($this->lang->line('exp_detailed_description_about_cancel')); } else echo "HomestayDNN allows hosts to choose among three standardized cancellation policies (Flexible, Moderate, and Strict) that we will enforce to protect both guest and host alike. Guests may cancel and review any penalties by viewing their travel plans and then clicking ‘Cancel’ on the appropriate reservation. A host's cancellation policy can be found in the Cancellations section of their listing page. Guests will also be asked to agree to the host's cancellation policy when they make a booking."; ?></p>    
                    
                    </div>
                    
                    
                
                </div>
            
            </div>
            
        
        </div>
        
    </div>
	

<script type="text/javascript">
	function show_block_cate(columin_id){
	   $(".onclk-text").css("display","none");
	   $("#monthly").css("display","block");  
}
</script>


<script type="text/javascript">

     function checkSpcialChar(event){
     
        if(!((event.keyCode >= 65) && (event.keyCode <= 90) || (event.keyCode >= 97) && (event.keyCode <= 122) || (event.keyCode >= 48) && (event.keyCode <= 57))){
           event.returnValue = false;   
           return;
        }
        event.returnValue = true;
     }

</script>


<script>

function validate_form_new(e){

	cancel_policy_1=$('#cancel_policy_1').val();
	cancel_policy_des=$('#cancel_policy_des').val();
	sec_deposit=$('#sec_deposit').val();
	cancel_percentage=$('#cancel_percentage').val();
	
	err=0;
	
	if(sec_deposit=='' || cancel_policy_1=='' || cancel_policy_des==''){
		err=1;
	}
	if(cancel_policy_1 == 'Flexible' || cancel_policy_1 == 'Moderate')
	{
		if(cancel_percentage == '')
		{
			err=1;
		}
		
	}
	if(err==1){
		//$('.error').show();
		 $('.error').fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow');
		 });
		 return false;
	}else{
		
		url='<?php echo base_url()."site/experience/add_cancel_policy/".$id;?>';
		$('#experience_cancel_policy').attr('method', 'post');
		$('#experience_cancel_policy').attr('action', url).submit();
		
	}
}
$(document).ready(function() {
    $('#next-btn').click(function(e) {  
     window.location.href = '<?php echo base_url()."experience/all"; ?>';
    });
});
$(document).ready(function() {
    $(".number_field2").keydown(function (e) {
		//alert('cc');
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
</script>

<script>
function show_val(cancel_value)
{
	if(cancel_value.value == 'Flexible')
	{
		$('#cancel_percentage').val('100');
		$('#cancel_percentage').attr('readonly', true);
		//$('#return_amount').trigger("change");
		$('#return_amount_percentage').show(); 	
	}
	else if(cancel_value.value == 'Strict')
	{
		$('#cancel_percentage').val('50');
		/*update the onchange vaues in trigger concept*/
		//$('#cancel_percentage').trigger("change");
		$('#cancel_percentage').attr('readonly', 'true');
		$('#return_amount_percentage').show(); 		
	}
	else if(cancel_value.value == 'Moderate')
	{
		$('#cancel_percentage').val('100');
		//$('#cancel_percentage').trigger("change");
		$('#cancel_percentage').attr('readonly', true);
		$('#return_amount_percentage').show(); 
	}
	else if(cancel_value.value == 'No Return')
	{
		$('#cancel_percentage').val('0');
		//$('#cancel_percentage').trigger("change");
		$('#cancel_percentage').attr('readonly', true);
		$('#return_amount_percentage').show(); 
	}
	else
	{
		$('#return_amount_percentage').hide(); 
	}
}
</script>


<style>
.content{
height:44px !important;
}
</style>
<script type="text/javascript">
function UpdateSEO(evt,catID,chk){
	var title = evt.value;
		$.ajax({
			type:'post',
			url:baseURL+'site/experience/UpdateSEO',
			data:{'catID':catID,'title':title,'chk':chk},
			complete:function(){
				//$('#imgmsg_'+catID).hide();
				//$('#imgmsg_'+catID).show().text(msg);
			}
		});
}
</script>






<?php $this->load->view('site/templates/footer'); ?>