<?php $this->load->view('site/templates/header'); 


$this->load->view('site/experience/experience_head_side');?>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>



            <div class="right_side overview">
                 <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('group_details') != '') { echo stripslashes($this->lang->line('group_details')); } else echo "Group Details";?></h3>
                        
                        <p><?php  echo "Summary about the group who provides experience.";?> </p>
                    
                    </div>
                   <form onsubmit="return validate_form()" id="group_details" name="group_details" action="<?php echo base_url()."guest_requirement/".$listDetail->row()->id;?>" method="post" accept-charset="UTF-8">

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                       
                    <div class="dashboard_price_right">

                        <div class="overview_title">
                        
                            <label><?php if($this->lang->line('about_group') != '') { echo stripslashes($this->lang->line('about_group')); } else echo "About Group Size";?> <small> <?php /*if($this->lang->line('Maximum150words') != '') { echo stripslashes($this->lang->line('Maximum150words')); } else echo "Maximum 150 words";*/?></small></label>
                            
                            <textarea class="title_overview" id="group_size" placeholder="<?php  echo "Summary about the group who provides experience.";?>" rows="8" onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'group_size');" name="group_size" id="group_size" style="color:#757474 !important;min-width:100%;max-width:100%;min-height: 250px; font-size: 14px;"><?php echo strip_tags($listDetail->row()->group_size);?></textarea>
                        
                            <!--<span>250 characters left</span>-->
                        
                        </div>


                            
                    </div>
                    <div class="exp-pic">
            <button class="next_button" style="width:87px;" type="submit"><?php if($this->lang->line('Next') != '') { echo stripslashes($this->lang->line('Next')); } else echo "Next";?></button>
                        </div>
                </form>


                </div>
            
            </div>
            
            </div>
            
            
            <div class="calender_comments">
            
                <div class="calender_comment_content">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
                    
                    <div class="calender_comment_text">
                    
                        <h2><?php  echo "Group Details";?></h2>
                    
                        <p><?php  echo "Summary about the group who provides experience.";?></p>
                        
                        
                    
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



<script type="text/javascript">
 
</script>


<?php $this->load->view('site/templates/footer'); ?>