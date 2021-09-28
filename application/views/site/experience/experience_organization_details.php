<?php $this->load->view('site/templates/header'); 





$this->load->view('site/experience/experience_head_side');?>



<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>







			<div class="right_side overview schedule-experience">

				 <div class="dashboard_price_main" style="border-bottom:none;">

            

                <div class="dashboard_price">

            

                    <div class="dashboard_price_left">

                    

                        <h3><?php if($this->lang->line('exp_tell_us_about') != '') { echo stripslashes($this->lang->line('exp_tell_us_about')); } else echo "Tell us about the organization you represent";?></h3>

                        

                        <p><?php if($this->lang->line('Aexperiencetitleandsummary') != '') { echo stripslashes($this->lang->line('Aexperiencetitleandsummary')); } else echo "Please provide the organization . So we can verify your organization.";?> </p>

                    

                    </div>

                   <form onsubmit="return validate_form_new(event)" id="overviewlist" name="overviewlist" method="post"  accept-charset="UTF-8">



                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>

                       

                    <div class="dashboard_price_right">

						<span class="error text-center">

							<small> *  <?php if($this->lang->line('exp_fill_all_fields') != '') { echo stripslashes($this->lang->line('exp_fill_all_fields')); } else echo "Please fill all mandatory fields"; ?></small>

						</span>

						

                        <div class="overview_title margin_top_20 margin_bottom_20 input ">

                        

                          <h4>  <?php if($this->lang->line('exp_organization_name') != '') { echo stripslashes($this->lang->line('exp_organization_name')); } else echo "Organization name"; ?> <span class="req"> <small>*</small></span></h4>

							

							<input name="organization" id="organization" type="text" class="exp_input" value="<?php echo $listDetail->row()->organization;  ?>" > 

							

							<!-- <?php

							$string = str_replace(' ', '', $listDetail->row()->organization);

							$len=mb_strlen($string, 'utf8');

							$remaining=(20-$len);

							?> -->

							<span class="small_label"><span id="organization_char_count">Maximum 10 words</span></span>

							

                        </div>

						

						

						<div class="overview_title margin_top_20 margin_bottom_20">

                        

                          <h4> <?php if($this->lang->line('exp_about_your_organization') != '') { echo stripslashes($this->lang->line('exp_about_your_organization')); } else echo "About your Organization"; ?> <span class="req"> <small>*</small></span></h4>

							

							<textarea name="organization_des"  id="organization_des" type="text" class="exp_input" placeholder="<?php if($this->lang->line('exp_about_your_organization') != '') { echo stripslashes($this->lang->line('exp_about_your_organization')); } else echo "About your Organization"; ?>" ><?php echo $listDetail->row()->organization_des;  ?></textarea>

							

							<!-- <?php

							$string = str_replace(' ', '', $listDetail->row()->organization_des);

							$len=mb_strlen($string, 'utf8');

							$remaining=(250-$len);

							?> -->

							<span class="small_label"><span id="organization_des_char_count">Maximum 150 words</span></span>

							

                        </div>

	

                    </div>



                     <div class="exp-pic org_div">

					 

					 <button class="next_button" id="next-btn" type="button"><?php if($this->lang->line('exp_skip') != '') { echo stripslashes($this->lang->line('exp_skip')); } else echo "Skip";?></button>

					 

					 <button class="next_button" type="submit"><?php if($this->lang->line('Save_and_Continue') != '') { echo stripslashes($this->lang->line('Save_and_Continue')); } else echo "Save & Continue";?></button></div>

<?php //echo $id; ?>

                </form>





                </div>

            

            </div>

            

            </div>

            

            

            <div class="calender_comments">

            

                <div class="calender_comment_content">

                

                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>

                    

                    <div class="calender_comment_text">

                    

                        <h2><?php if($this->lang->line('exp_organization_details') != '') { echo stripslashes($this->lang->line('exp_organization_details')); } else echo "Is this a social impact experience?";?></h2>

                    

                        <p><?php if($this->lang->line('exp_great_summary_exe') != '') { echo stripslashes($this->lang->line('exp_great_summary_exe')); } else echo "If you’re partnering with a nonprofit or a charitable organization, you can host a social impact experience. Make others aware about social issues. Always try to provide right information about your organization.";?></p>

                        

                        <!--<p><strong><?php if($this->lang->line('exp_adddtionals') != '') { echo stripslashes($this->lang->line('exp_adddtionals')); } else echo "Adddtionals";?> : </strong>

						<?php if($this->lang->line('exp_additionally') != '') { echo stripslashes($this->lang->line('exp_additionally')); } else echo "Additionally have to mention the special features included in your experience like languages support, the things provided by guide on the time of experience.";?>   </p>-->

                        

                    

                    </div>

                    

                    

                

                </div>

            

            </div>

            

        

        </div>

        

    </div>



<style>

.content{

height:44px !important;

}

</style>



<script>

function validate_form_new(e){

	

	organization=$('#organization').val();

	organization_des=$('#organization_des').val();

	err=0;

	if(organization=='' || organization_des==''){

		err=1;

	}



	if(err==1){

		//$('.error').show();

		 $('.error').fadeIn('slow', function () {

			$(this).delay(5000).fadeOut('slow');

		 });

		 return false;

	}else{

		url='<?php echo base_url()."site/experience/add_org_details/".$id;?>';

		$('#overviewlist').attr('method', 'post');

		$('#overviewlist').attr('action', url).submit();



	}

}

$(document).ready(function() {

    $('#next-btn').click(function(e) {  

     window.location.href = '<?php echo base_url()."experience_details/".$id; ?>';

    });

});


</script>

<script type="text/javascript">
var wordLenSum = 10,
lenSum; 			

$('#organization').keydown(function(event) {	

	lenSum = $('#organization').val().split(/[\s]+/); 

	if (lenSum.length > wordLenSum) { 

		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons

    } else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons

    	event.preventDefault();

    }

	}

	wordsLeftSum = (wordLenSum) - lenSum.length;

	if(wordsLeftSum < 0) {	

		 document.getElementById("organization_char_count").innerHTML = "10 Words Reached";

	}else{

		$("#organization_char_count").html("You can add "+wordsLeftSum+" more words!");

	}

});
</script>

<script type="text/javascript">
var orgwordLenSum = 150, 
orglenSum; 			

$('#organization_des').keydown(function(event) {	

	orglenSum = $('#organization_des').val().split(/[\s]+/); 

	if (orglenSum.length > orgwordLenSum) { 

		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons

    } else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons

    	event.preventDefault();

    }

	}

	wordsLeftSum = (orgwordLenSum) - orglenSum.length;

	if(wordsLeftSum < 0) {	

		 document.getElementById("organization_des_char_count").innerHTML = "150 Words Reached";

	}else{

		$("#organization_des_char_count").html("You can add "+wordsLeftSum+" more words!");

	}

});
</script>



<?php $this->load->view('site/templates/footer'); ?>