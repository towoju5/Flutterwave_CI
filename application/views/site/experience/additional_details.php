<?php $this->load->view('site/templates/header'); 


$this->load->view('site/experience/experience_head_side');?>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>



            <div class="right_side overview">
                 <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('additional_details') != '') { echo stripslashes($this->lang->line('additional_details')); } else echo "Additional Details";?></h3>
                        
                        <p><?php if($this->lang->line('Atitleandsummary') != '') { echo stripslashes($this->lang->line('Atitleandsummary')); } else echo "A title and summary displayed on your public experience page.";?> </p>
                    
                    </div>
                   <form onsubmit="return validate_form()" id="experience_details" name="experience_details" action="<?php echo base_url()."location_details/".$listDetail->row()->id;?>" method="post" accept-charset="UTF-8">

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                       
                    <div class="dashboard_price_right">
                        <div class="addit_det_right">
                        <div class="overview_title">
                        
                            <label><?php if($this->lang->line('note_to_guest') != '') { echo stripslashes($this->lang->line('note_to_guest')); } else echo "Notes to Guest";?> </label>
                            
                            <textarea class="title_overview" id="note_to_guest" placeholder="<?php  echo "Guest guidelines";?>" rows="8" onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'note_to_guest');" name="note_to_guest" id="note_to_guest" style="color:#000 !important;min-width:100%;max-width:100%;"><?php echo strip_tags($listDetail->row()->note_to_guest);?></textarea>
                        
                            <!--<span>250 characters left</span>-->
                        
                        </div>



                         <div class="overview_title">
                        
                            <label><?php if($this->lang->line('location_details') != '') { echo stripslashes($this->lang->line('location_details')); } else echo "Location Details";?></label>
                            
                            <textarea class="title_overview" id="location_description" placeholder="<?php echo "Detailed notes about location";?>" rows="8" onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'location_description');" name="location_description" id="location_description" style="color:#757474 !important;min-width:100%;max-width:100%; font-size:14px;"><?php echo strip_tags($listDetail->row()->location_description);?></textarea>
                        
                            <!--<span>250 characters left</span>-->
                        
                        </div>
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
                    
                        <h2><?php if($this->lang->line('Agreattitle') != '') { echo stripslashes($this->lang->line('Agreattitle')); } else echo "A great summary";?></h2>
                    
                        <p><?php if($this->lang->line('Agreattitleisunique') != '') { echo stripslashes($this->lang->line('Agreattitleisunique')); } else echo "A great summary is rich and exciting! It should cover the major features of your space and neighborhood in 250 characters or less.";?></p>
                        
                        <p><strong><?php if($this->lang->line('example') != '') { echo stripslashes($this->lang->line('example')); } else echo "Example";?>:</strong><?php if($this->lang->line('Ourcooland') != '') { echo stripslashes($this->lang->line('Ourcooland')); } else echo "Our cool and comfortable one bedroom apartment with exposed brick has a true city feeling! It comfortably fits two and is centrally located on a quiet street, just two blocks from Washington Park. Enjoy a gourmet kitchen, roof access, and easy access to all major subway lines!";?>  </p>
                        
                    
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