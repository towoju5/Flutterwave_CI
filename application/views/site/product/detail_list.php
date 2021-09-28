<?php
$this->load->view('site/templates/header');
$this->load->view('site/templates/listing_head_side');
?>
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addProperty.js"></script>

<script>
function overview() {
    document.getElementById("overviewlist").submit();
    
}
</script>



            <div class="right_side detail-map">
            
            <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('detail_list') != '') { echo stripslashes($this->lang->line('detail_list')); } else echo "Details"; ?></h3>
                        
                        <p><?php if($this->lang->line('detail_list_description') != '') { echo stripslashes($this->lang->line('detail_list_description')); } else echo "A description of your space displayed on your public listing page"; ?>. </p>
                    
                    </div>
	<form id="overviewlist" name="overviewlist" action="<?php echo base_url()."extra_description/".$listDetail->row()->id;?>" method="post" accept-charset="UTF-8">
                    <div class="dashboard_price_right">
                    
                        <div class="overview_title">
                      
                            <label><?php if($this->lang->line('The_Space') != '') { echo stripslashes($this->lang->line('The_Space')); } else echo "The Space";?></label>
                         <textarea class="title_overview" maxlength="250"  title="The Space" style="color:#000 !important;"  rows="8" 
						 onpaste="count_characters(this,'space')" 
						 onfocus="count_characters(this,'space')" 
						 onkeyup="count_characters(this,'space')" 
						 name="space" id="space" placeholder="<?php if($this->lang->line('the_space_place') != '') { echo stripslashes($this->lang->line('the_space_place')); } else echo "what makes  your listing unique?";?>"> <?php echo strip_tags($listDetail->row()->other_thingnote);?></textarea>
                            <p id="chars_left_space" style="color:red;"></p>
                            
                            
                            <input type="hidden" id="id" name="id" value="<?php echo $listDetail->row()->id; ?>" />
                            
                        </div>
                    </div>
               
                </div>
            
            </div>
            
            
            
            <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('detail_list_extra_detail') != '') { echo stripslashes($this->lang->line('detail_list_extra_detail')); } else echo "Extra Details";?></h3>
                        
                        <p><?php if($this->lang->line('detail_list_public_listing') != '') { echo stripslashes($this->lang->line('detail_list_public_listing')); } else echo "Other information you wish to share on your public listing page";?>. </p>
                    
                    </div>
                   
                    <div class="dashboard_price_right">
                    
                        <div class="overview_title">
                        
                            <label><?php if($this->lang->line('other_things_to_note') != '') { echo stripslashes($this->lang->line('other_things_to_note')); } else echo "Other Things to Note";?></label>
                        <textarea class="title_overview"  maxlength="250" title=" <?php if($this->lang->line('other_things_to_note') != '') { echo stripslashes($this->lang->line('other_things_to_note')); } else echo "Other Things to Note";?> " style="color:#000 !important;" placeholder="<?php if($this->lang->line('other_things_to_note_place') != '') { echo stripslashes($this->lang->line('other_things_to_note_place')); } else echo "Are there any other details you’d like to share?";?>" rows="8" 
						onpaste="count_characters(this,'other_thingnote')"
						onfocus="count_characters(this,'other_thingnote')" 
						onkeyup="count_characters(this,'other_thingnote')" 
						name="other_thingnote" id="other_thingnote" ><?php echo strip_tags($listDetail->row()->other_thingnote);?></textarea>
                        <p id="chars_left_other_thingnote" style="color:red;"></p>
                        
                        </div>
                        
                        
                      
                        
                         <div class="overview_title">
                            <label><?php if($this->lang->line('House_Rules') != '') { echo stripslashes($this->lang->line('House_Rules')); } else echo "House Rules";?></label>
                           <textarea class="title_overview" maxlength="250" title="<?php if($this->lang->line('House_Rules') != '') { echo stripslashes($this->lang->line('House_Rules')); } else echo "House Rules";?>" placeholder="<?php if($this->lang->line('house_rules_place') != '') { echo stripslashes($this->lang->line('house_rules_place')); } else echo "How do you expect your guests to behave?";?>" rows="8" style="color:#000 !important;"

								onpaste="count_characters(this,'house_rules')"
                                onfocus="count_characters(this,'house_rules')"
                                onkeyup="count_characters(this,'house_rules')"
								
						    name="house_rules" id="house_rules" ><?php echo strip_tags($listDetail->row()->house_rules);?></textarea>
							 <p id="chars_left_house_rules" style="color:red;"></p>
							
                        </div>
						<div class="overview_title">
                            <label><?php if($this->lang->line('guest_access') != '') { echo stripslashes($this->lang->line('guest_access')); } else echo "Guest access";?></label>
                           <textarea class="title_overview" maxlength="250" title="<?php if($this->lang->line('guest_access') != '') { echo stripslashes($this->lang->line('guest_access')); } else echo "Guest access";?>" placeholder="<?php if($this->lang->line('guest_access_place') != '') { echo stripslashes($this->lang->line('guest_access_place')); } else echo "How do you expect your Guest Access ?";?>" rows="8" style="color:#000 !important;"
                                onpaste="count_characters(this,'guest_access')"
                                onfocus="count_characters(this,'guest_access')"
                                onkeyup="count_characters(this,'guest_access')"
                            
                                name="guest_access" id="guest_access" ><?php echo strip_tags($listDetail->row()->guest_access);?></textarea>
                                <p id="chars_left_guest_access" style="color:red;"></p>
                        </div>
						<div class="overview_title">
                            <label><?php if($this->lang->line('interaction_with_guest') != '') { echo stripslashes($this->lang->line('interaction_with_guest')); } else echo "Interaction with guest";?></label>
                           <textarea class="title_overview" maxlength="250" title="<?php if($this->lang->line('interaction_with_guest') != '') { echo stripslashes($this->lang->line('interaction_with_guest')); } else echo "Interaction with guest";?>" placeholder="<?php if($this->lang->line('interaction_with_guest') != '') { echo stripslashes($this->lang->line('interaction_with_guest')); } else echo "Interaction with guest";?>" rows="8" style="color:#000 !important;"
                                onpaste="count_characters(this,'interact_guest')"
                                onfocus="count_characters(this,'interact_guest')"
                                onkeyup="count_characters(this,'interact_guest')"
                                name="interact_guest" id="interact_guest" ><?php echo strip_tags($listDetail->row()->interact_guest);?></textarea>
                                <p id="chars_left_interact_guest" style="color:red;"></p>
                        </div>
						<div class="overview_title">
                            <label><?php if($this->lang->line('neighborhood') != '') { echo stripslashes($this->lang->line('neighborhood')); } else echo "Neighborhood";?></label>
                           <textarea class="title_overview"  maxlength="250" title="<?php if($this->lang->line('neighborhood') != '') { echo stripslashes($this->lang->line('neighborhood')); } else echo "Neighborhood";?>" placeholder="<?php if($this->lang->line('neighborhood') != '') { echo stripslashes($this->lang->line('neighborhood')); } else echo "Neighborhood";?>" rows="8" style="color:#000 !important;"
                                onpaste="count_characters(this,'neighbor_overview')"
                                onfocus="count_characters(this,'neighbor_overview')"
                                onkeyup="count_characters(this,'neighbor_overview')"
                             name="neighbor_overview" id="neighbor_overview" ><?php echo strip_tags($listDetail->row()->neighbor_overview);?></textarea>
                             <p id="chars_left_neighbor_overview" style="color:red;"></p>
                        </div>

                        
                       
                        
                         <button class="next_button" ><?php if($this->lang->line('Next') != '') { echo stripslashes($this->lang->line('Next')); } else echo "Next";?></button>
                       
                        <input type="hidden" name="pro_id" value="<?php echo $this->uri->segment(2); ?>" />
                        
                    </div>
                </form>
                </div>
            
            </div>
            
            
             
            </div>


		   <div class="calender_comments">
            
                <div class="calender_comment_content" id="div1" style="display:block;margin-top:0;">
                <div class="left-calender_comment">
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
                    </div>
					
					<div class="right-calender_comment">
                    <div class="calender_comment_text">
                    
                        <h2><?php if($this->lang->line('detail_list_about_space') != '') { echo stripslashes($this->lang->line('detail_list_about_space')); } else echo "About your space";?></h2>
                    
                        <p> <ul >
                        <li style="list-style-type:disc;"><?php if($this->lang->line('detail_list_unique') != '') { echo stripslashes($this->lang->line('detail_list_unique')); } else echo "What makes your listing unique?";?></li>
                        <li style="list-style-type:disc;"><?php if($this->lang->line('detail_list_comfortably') != '') { echo stripslashes($this->lang->line('detail_list_comfortably')); } else echo "How many people does your listing comfortably fit?";?></li>
                        
                      
                        </ul></p>
                        
                        
                    </div></div>
                    
                    
                
                </div>
                <div class="calender_comment_content" id="div2" style="display:none;margin-top:72%;">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>                    
                    <div class="calender_comment_text">                    
                        <h2><?php if($this->lang->line('detail_list_gust_access') != '') { echo stripslashes($this->lang->line('detail_list_gust_access')); } else echo "Guest access";?></h2>                    
                        <p> <ul >
                        <li style="list-style-type:disc;"><?php if($this->lang->line('detail_list_access_to') != '') { echo stripslashes($this->lang->line('detail_list_access_to')); } else echo "What will guests have access to?";?></li>
                        <li style="list-style-type:disc;"><?php if($this->lang->line('detail_list_amenities_shared') != '') { echo stripslashes($this->lang->line('detail_list_amenities_shared')); } else echo "Which amenities or areas will be shared?";?></li>
                        <li style="list-style-type:disc;"><?php if($this->lang->line('detail_list_off_limits') != '') { echo stripslashes($this->lang->line('detail_list_off_limits')); } else echo "Is anything off limits?";?></li>
                      
                        </ul></p>
                    </div>
                </div>
            
            
              <div class="calender_comment_content" id="div3" style="display:none;margin-top:130%;">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>                    
                    <div class="calender_comment_text">                    
                        <h2><?php if($this->lang->line('Interaction with guests') != '') { echo stripslashes($this->lang->line('Interaction with guests')); } else echo "Interaction with guests";?></h2>                    
                        <p> <ul >
                        <li style="list-style-type:disc;"><?php if($this->lang->line('How much do you interact with your guests') != '') { echo stripslashes($this->lang->line('How much do you interact with your guests')); } else echo "How much do you interact with your guests";?>?</li>
                        <li style="list-style-type:disc;"><?php if($this->lang->line('Will you be present at the listing during your guest s stay') != '') { echo stripslashes($this->lang->line('Will you be present at the listing during your guest s stay')); } else echo "Will you be present at the listing during your guest's stay";?>?</li>
                        
                      
                        </ul></p>
                    </div>
                </div>
            
            
            <div class="calender_comment_content" id="div4" style="display:none;margin-top:220%;">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>                    
                    <div class="calender_comment_text">                    
                        <h2><?php if($this->lang->line('Neighborhood overview') != '') { echo stripslashes($this->lang->line('Neighborhood overview')); } else echo "Neighborhood overview";?></h2>                    
                        <p> <ul >
                        <li style="list-style-type:disc;"><?php if($this->lang->line('What do you love about your neighborhood') != '') { echo stripslashes($this->lang->line('What do you love about your neighborhood')); } else echo "What do you love about your neighborhood";?>?</li>
                        <li style="list-style-type:disc;"><?php if($this->lang->line('What do you think your guests should experience') != '') { echo stripslashes($this->lang->line('What do you think your guests should experience')); } else echo "What do you think your guests should experience";?>?</li>
                        
                      
                        </ul></p>
                    </div>
                </div>
                
                
                 <div class="calender_comment_content" id="div5" style="display:none;margin-top:310%;">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>                    
                    <div class="calender_comment_text">                    
                        <h2><?php if($this->lang->line('Getting around') != '') { echo stripslashes($this->lang->line('Getting around')); } else echo "Getting around";?></h2>                    
                        <p> <ul >
                        <li style="list-style-type:disc;"><?php if($this->lang->line('Is there convenient public transit') != '') { echo stripslashes($this->lang->line('Is there convenient public transit')); } else echo "Is there convenient public transit";?>?</li>
                        <li style="list-style-type:disc;"><?php if($this->lang->line('Is parking included with your listing or nearby') != '') { echo stripslashes($this->lang->line('Is parking included with your listing or nearby')); } else echo "Is parking included with your listing or nearby";?>?</li>
                        <li style="list-style-type:disc;"><?php if($this->lang->line('How does your guest get to your listing from the airport') != '') { echo stripslashes($this->lang->line('How does your guest get to your listing from the airport')); } else echo "How does your guest get to your listing from the airport";?>?</li>
                        
                      
                        </ul></p>
                    </div>
                </div>
            
            
            
               <div class="calender_comment_content" style="display:none;margin-top:380%;">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>                    
                    <div class="calender_comment_text">                    
                        <h2><?php if($this->lang->line('Other Things to Note') != '') { echo stripslashes($this->lang->line('Other Things to Note')); } else echo "Other Things to Note";?></h2>                    
                        <p> <ul >
                        <li style="list-style-type:disc;"><?php if($this->lang->line('Are there any other details you d like to share') != '') { echo stripslashes($this->lang->line('Are there any other details you d like to share')); } else echo "Are there any other details you'd like to share";?>?</li>
                        
                        
                      
                        </ul></p>
                    </div>
                </div>
                
                  <div class="calender_comment_content" id="div7" style="display:none;margin-top:443%;">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>                    
                    <div class="calender_comment_text">                    
                        <h2><?php if($this->lang->line('House Rules') != '') { echo stripslashes($this->lang->line('House Rules')); } else echo "House Rules";?></h2>                    
                        <p> <ul >
                        <li style="list-style-type:disc;"><?php if($this->lang->line('How do you expect your guests to behave') != '') { echo stripslashes($this->lang->line('How do you expect your guests to behave')); } else echo "How do you expect your guests to behave";?>?</li>
                        <li style="list-style-type:disc;"><?php if($this->lang->line('Do you allow pets') != '') { echo stripslashes($this->lang->line('Do you allow pets')); } else echo "Do you allow pets";?>?</li>
                        <li style="list-style-type:disc;"><?php if($this->lang->line('Do you have rules against smoking') != '') { echo stripslashes($this->lang->line('Do you have rules against smoking')); } else echo "Do you have rules against smoking";?>?</li>
                        
                        
                      
                        </ul></p>
                    </div>
                </div></div>

        </div>
		
        
    </div>
	
	
	
    <script type="text/javascript" language="javascript">
        function limitKeyword(limitCount, limitNum) {
        var limitField = document.getElementById("product_name");
            if (limitField.value.length > limitNum) {
                limitField.value = limitField.value.substring(0, limitNum);
                } else {
                limitCount.value = limitNum - limitField.value.length;
            }
        }
		
/* Sathyaseelan for counting and limiting words(open) */
function count_characters(data,update_field)
{
	
    var contents = data.value;
    var characters = contents.length;
    
    if(characters > 250) //when changing the charecter limit also change maxlength attribute of textarea
    {
        var split_by_uncerscore=update_field.replace("_"," ");
        $("#chars_left_"+update_field).html("The "+split_by_uncerscore+" should not exceed 250 Characters!");
        return false;
    }
    else
    {		
        var chars_remaining=250-parseInt(characters);
        if(parseInt(chars_remaining)>0)
        {
            $("#chars_left_"+update_field).html("You can add "+chars_remaining+" more characters!");
        }
        else if(parseInt(chars_remaining)<=0)
        {
            $("#chars_left_"+update_field).html("You reached the character limit!!");
            return false;
        }
        Detailview(data,<?php echo $listDetail->row()->id; ?>,update_field);
    }
}
/* Sathyaseelan for counting and limiting words(close) */
</script>
    
<!---DASHBOARD-->
<?php
$this->load->view('site/templates/footer');
?>