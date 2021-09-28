<?php $this->load->view('site/templates/header'); 


$this->load->view('site/experience/experience_head_side');?>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>



            <div class="right_side overview schedule-experience">
                 <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('exp_which_language') != '') { echo stripslashes($this->lang->line('exp_which_language')); } else echo "Which Language will you host in?";?></h3>
                        
                        <p><?php if($this->lang->line('Aexperiencetitleandsummary') != '') { echo stripslashes($this->lang->line('Aexperiencetitleandsummary')); } else echo "You'll write your descriptions in this language and guests will expect you to speak it during experiences.";?></p>
                    
                    </div>
                <form onsubmit="return validate_form()" id="experience_details" name="experience_details" method="post"  accept-charset="UTF-8">

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                       
                    <div class="dashboard_price_right">
                       
                        <div class="overview_title margin_top_20 margin_bottom_20">
                        
                          <h4> <?php if($this->lang->line('exp_submission_language') != '') { echo stripslashes($this->lang->line('exp_submission_language')); } else echo "Submission Language";?></h4>
                                
                                
                            <div>
                                <span class="no-numbr">
                                <ul >
                                 
                                
                                <li><a onclick="reset_check_boxes()" data-toggle="modal" href="#myModal"  class="multiselect-add-more"><i class="fa fa-plus"></i> <?php if($this->lang->line('AddMore') != '') { echo stripslashes($this->lang->line('AddMore')); } else echo "Add Language";?></a></li>
                                <li><span style="width:100%; float:left" ><?php if($this->lang->line('Addlanguages') != '') { echo stripslashes($this->lang->line('Addlanguages')); } else echo "Add languages you speak.";?></span></li>
                                </ul>

                                </span>
                                <?php 
                                $languages_known_user=explode(',',$listDetail->row()->language_list);
                                if(count($languages_known_user)>0)
                                { ?>
                                <ul class="inner_language margin_bottom_20 margin_top_20">
                                <?php
                                foreach($languages_known->result() as $language){
                                if(in_array($language->language_code,$languages_known_user)) {?>
                                <li id="<?php echo $language->language_code;?>"><?php echo $language->language_name;?><small>
                              <span class="text-normal remove" href="javascript:void(0);" onclick="delete_languages(this,'<?php echo $language->language_code;?>')"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </small></li>
                                <?php } }?>
                                </ul>
                                <?php }?>
                            </div>
                        </div>
    
                    </div>

                     <div class="exp-pic"><button class="next_button" type="button" id="next-btn" ><?php if($this->lang->line('Continue') != '') { echo stripslashes($this->lang->line('Continue')); } else echo "Continue";?></button></div>

                </form>


                </div>
            
            </div>
            
            </div>
            
            
            <div class="calender_comments">
            
                <div class="calender_comment_content">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
                    
                    <div class="calender_comment_text">
                    
                        <h2><?php if($this->lang->line('switch_your_lang') != '') { echo stripslashes($this->lang->line('switch_your_lang')); } else echo "Switch to your Language";?></h2>
                    
                        <p><?php if($this->lang->line('exp_great_summary') != '') { echo stripslashes($this->lang->line('exp_great_summary')); } else echo '"A new language is a new life". Are you flexible in more than one language? Please specify it. Make your guest comfort with their native language. With languages you can make your guest to feel they are at Home. Don’t miss out any of your guest.';?></p>
                        
                      
                        
                    
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


<!-- Language Model starts -->
<div class="exp-lang">
<div id="myModal" class="modal fade in profilepage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              
    <div class="panel-header">
        <a class="close" aria-hidden="true" data-dismiss="modal" type="button"><i class="fa fa-times" aria-hidden="true"></i>
        </a>
        <?php if($this->lang->line('SpokenLanguages') != '') { echo stripslashes($this->lang->line('SpokenLanguages')); } else echo "Spoken Languages";?>
    </div>
    <div class="panel-body" id="lang-panel">
        <p><?php if($this->lang->line('Whatlanguages') != '') { echo stripslashes($this->lang->line('Whatlanguages')); } else echo "What languages can you speak fluently? We have many international travelers who appreciate hosts who can speak their language."; ?></p>
        <div class="row-fluid row">
        <div class="span6 col-6">
            <?php $languages_knowns=explode(',',$listDetail->row()->language_list);?>
            <?php $i = 1;foreach($languages_known->result() as $language){ if($i%2 == 1) {?>
                <li>
                    <input type="checkbox" <?php if(in_array($language->language_code,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]" value="<?php echo $language->language_code;?>"
                    alt="<?php echo $language->language_name;?>">
                    <label><?php echo $language->language_name;?></label>
                </li>
        <?php } $i++; } ?>
        </div>
            <div class="span6 col-6">
                <?php $languages_knowns=explode(',',$listDetail->row()->language_list);?>
                <?php $i = 1;foreach($languages_known->result() as $language){ if($i%2 == 0) {?>
                <li>
                    <input type="checkbox" <?php if(in_array($language->language_code,$languages_knowns)) {?> checked="checked" <?php }?> name="languages[]" value="<?php echo $language->language_code?>"
                    alt="<?php echo $language->language_name?>">
                    <label><?php echo $language->language_name?></label>
                </li>
                <?php } $i++; } ?>
            </div>
        </div>
    </div>
    <div class="panel-footer language-popup">

        <button class="btn btn-primary"  data-dismiss="modal" type="button" id="language_ajax"> <?php if($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save";?> </button>
        <a class="btn btn-default pull-left" data-dismiss="modal" type="button"><?php if($this->lang->line('Close') != '') { echo stripslashes($this->lang->line('Close')); } else echo "Close";?></a>

    </div>
        
        
</div><!-- /.modal ends -->
</div>

<script type="text/javascript">
    


$(function()
{
        lan_count=$(".inner_language li").length;
        if(lan_count==0){
            $('#next-btn').hide();
        }else{
            $('#next-btn').show();
        }
    $('#language_ajax').click(function()
    {

        var languages=document.getElementsByName('languages[]');
        var expID   = $("#experience_id").val();
        var languages_known=new Array();
        for(var i=0;i<languages.length;i++)
        {
            if($(languages[i]).is(':checked'))
            {
                languages_known.push(languages[i].value);
            }
        }

        if(languages_known.length>0)
        {
           // alert(languages_known);
           $('#next-btn').show();
            $.ajax({
                type:'POST',
                url:'<?php echo base_url()?>site/experience/update_languages',
                data:{languages_known:languages_known,experience_id:expID},
                success:function(response)
                {
                    $('.inner_language').html(response.trim());
                    //$('#no_language').css('display','none');
                    window.location.reload();
                }
            });

        }else{
            $('#next-btn').hide();
            
        }
    })
});

function reset_check_boxes(){
    var languages=document.getElementsByName('languages[]');
    //$('#myCheckbox').prop('checked', false);
     //$('#myModal').find('input:checkbox').prop('checked', false);
}

function delete_languages(elem,language_code){
    
    //return false;
    lan_count=$(".inner_language li").length;
    if(lan_count==1){
        alert("<?php if($this->lang->line('exp_please_choose_one') != '') { echo stripslashes($this->lang->line('exp_please_choose_one')); } else echo "Please choose atleast one language";?>");
        return false;
    }
    var expID   = $("#experience_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo base_url()?>site/experience/delete_languages',
        data:{language_code:language_code,experience_id:expID},
        dataType:'json',
        success:function(response){
            
            if(response['status_code']==1){
                $(elem).closest('li').remove();
                
                lan_count=$(".inner_language li").length;
                if(lan_count==0){
                    $('#next-btn').hide();
                }else{
                    $('#next-btn').show();
                }
            window.location.reload(true);
            }
        }
    });
}

function reset_reload(){
window.location.reload();
}
$(document).ready(function() {
    $('#next-btn').click(function(e) { 
     window.location.href = '<?php echo base_url()."experience_organization_details/".$id; ?>';
    });
});
</script>


<?php $this->load->view('site/templates/footer'); ?>