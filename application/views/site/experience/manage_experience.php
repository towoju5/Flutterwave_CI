<?php

$this->load->view('site/templates/header'); 

$this->load->view('site/experience/experience_head_side');

?>



<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>



			<div class="right_side overview schedule-experience">

				 <div class="dashboard_price_main" style="border-bottom:none;">

            

                <div class="dashboard_price">

            

                    <div class="dashboard_price_left">

                    

                   <h3><?php if($this->lang->line('exp_basic') != '') { echo stripslashes($this->lang->line('exp_basic')); } else echo "Basic";?></h3> 

                        

                        <p> <?php if($this->lang->line('exp_set_basic_fields') != '') { echo stripslashes($this->lang->line('exp_set_basic_fields')); } else echo "Set the basic mandatory fields of your experience."; ?></p>

                    

                    </div>

                <form onsubmit="return validate_form_new(event)" id="overviewlist" name="overviewlist" method='post' accept-charset="UTF-8">

                    <div class="dashboard_price_right">

						

						<span class="error text-center">

						<small> * <?php if($this->lang->line('exp_fill_all_fields') != '') { echo stripslashes($this->lang->line('exp_fill_all_fields')); } else echo "Please fill all mandatory fields"; ?></small>

						</span>

                    	<div class="overview_title margin_top_20">

                        

                            <h4><?php if($this->lang->line('exprience_type') != '') { echo stripslashes($this->lang->line('exprience_type')); } else echo "Experience Type";?><span class="req"> <small>*</small></span></h4>

                        

                            <?php /*<span class="title_overview"><?php if($listDetail->row()->date_count>1) echo "Immersions"; else echo "Experience"; ?></span> */?>

							

                       <?php 

							$exp_type=$listDetail->row()->exp_type;

							$disab='';$reaOnly='';

							if($exp_type!=''){

								$disab='disabled="true"';

								$reaOnly="readOnly";

							}

							//echo $exp_type;

						?>

						

						<div class="select margin_bottom_20">

								<select name="experience_type" id="experience_type" class="" onchange="change_date_or_time(this.value)" <?php echo $disab;?> >

									<option value="">--<?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?>--</option>

									<option value="2" <?php echo ($exp_type==2) ? "selected" : "" ;?>><?php if($this->lang->line('immersions') != '') { echo stripslashes($this->lang->line('immersions')); } else echo "Immersions"; ?></option>

									<option value="2" <?php echo ($exp_type==2) ? "selected" : "" ;?>><?php if($this->lang->line('experiences') != '') { echo stripslashes($this->lang->line('experiences')); } else echo "Experiences"; ?></option>

								</select>

						</div>

						 </div>



                        <?php

						

							if($listDetail->row()->exp_type==1){

								$sty="block;";

							}else{

								$sty="none;";

							}

						?>

						

                        <div class="overview_title input margin_bottom_20 date_count_div " style="display:<?php echo $sty;?>">

                        <div id="days_error" style="color:red"></div>

                            <h4><?php if($this->lang->line('date_count') != '') { echo stripslashes($this->lang->line('date_count')); } else echo "Number of days";?><span class="req"><small>*</small></span></h4>

                        

                            <?php /*<span class="title_overview"><?php echo $listDetail->row()->date_count;  ?></span>*/?>

							

							<input name="total_count_date" id="total_count_date" type="text" class="exp_input number_field" value="<?php echo $listDetail->row()->date_count;  ?>" <?php echo $reaOnly;?>>

                            

                        </div>

						

						<?php

						

							if($listDetail->row()->exp_type==1){

								$st="none;";

							}else{

								$st="block;";

							}

						?>

						<div class="overview_title input margin_bottom_20 hour_count_div " style="display:<?php echo $st; ?>">

                        

                            <h4><?php if($this->lang->line('total_hours') != '') { echo stripslashes($this->lang->line('total_hours')); } else echo "Total Hours";?><span class="req"><small>*</small></span></h4>

                        

                             <?php /*<span class="title_overview"><?php echo $listDetail->row()->date_count;  ?></span>*/?>

							

							<input name="total_count_time" onkeyup="hourValidation();" id="total_count_time" type="text" class="exp_input number_field" value="<?php echo $listDetail->row()->total_hours;  ?>"  <?php echo $reaOnly;?>>

							<span id="entered_hour_err" style="color:green"></span>

                            

                        </div>

						

						

						

						<div class="overview_title margin_bottom_20">

                        

                            <h4 style="text-transform:capitalize;"><?php if($this->lang->line('experience_category') != '') { echo stripslashes($this->lang->line('experience_category')); } else echo "Experience Category";?> <span class="req"><small>*</small></span></h4>

							<input type="hidden" id="org_type_id" name="org_type_id" value="<?php echo $listDetail->row()->type_id; ?>">

                            <div class="select">

								<select  name="type_id" id="type_id" <?php echo ($id!='' || ($id!=0)) ? 'onChange="UpdateExp_Category();"' : '' ?> >

								<option value=""><?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?></option>

									<?php 

									foreach ($experienceTypeList->result() as $type) { ?>

										<option value="<?php echo $type->id; ?>" <?php if(trim($type->id) == trim($listDetail->row()->type_id)) echo 'selected="selected"'; ?> ><?php echo ucfirst($type->experience_title); ?></option>

										<?php

									}

									?>

								</select>

							<span id="cat_update" style="color:green"></span>

	                            

	                            <input type="hidden" id="id" name="id" value="<?php echo $listDetail->row()->id; ?>" />

	                            

	                        </div>

                        </div>

						

						

						

						

			<?php /*		

                        <?php if($listDetail->row()->date_count==1) { ?>

                         <div class="overview_title margin_bottom_20 hour_count_div">

                        

                            <label><?php if($this->lang->line('total_hours') != '') { echo stripslashes($this->lang->line('total_hours')); } else echo "Total Hours";?><span class="req"> <small> *</small></span></label>

                        

                            <input type="text" value="<?php echo $listDetail->row()->total_hours;?>" placeholder="<?php if($this->lang->line('total_hours') != '') { echo stripslashes($this->lang->line('total_hours')); } else echo "Total Hours";?>" class="title_overview" 

                            onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'total_hours') " id="title" name="total_hours" onkeypress="return isNumber(event)" style="color:#000 !important;" />

                            

                        </div>

                        <?php } ?>



						

											

<br><br><br>

                    	<div class="overview_title">

                        

                            <h2 style="text-transform:capitalize;"><?php if($this->lang->line('experience_category') != '') { echo stripslashes($this->lang->line('experience_category')); } else echo "Experience Category";?> <span class="req">*</span></h2>

                            <div class="select exp-select">

								<select  name="experience_type"  required onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'type_id');">

								<option value=""><?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?></option>

									<?php 

									foreach ($experienceTypeList->result() as $type) { ?>

										<option value="<?php echo $type->id; ?>" <?php if(trim($type->id) == trim($listDetail->row()->type_id)) echo 'selected="selected"'; ?> ><?php echo ucfirst($type->experience_title); ?></option>

										<?php

									}

									?>

								</select>



	                            

	                            <input type="hidden" id="id" name="id" value="<?php echo $listDetail->row()->id; ?>" />

	                            

	                        </div>

                        </div>



                    

                        <div class="overview_title">

                        

                            <label><?php if($this->lang->line('Title') != '') { echo stripslashes($this->lang->line('Title')); } else echo "Title";?><span class="req"> </span></label>

                        

                            <input type="text" onkeypress="return checkSpcialChar(event)"; value="<?php echo $listDetail->row()->experience_title;?>" placeholder="<?php if($this->lang->line('Title') != '') { echo stripslashes($this->lang->line('Title')); } else echo "Title";?>" class="title_overview" 

                            onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'experience_title') " id="title" name="product_title" style="color:#000 !important;" />

                            

                        </div>

                        <div class="schedule-experience">

                            <div class="overview_title no-padding">

                                <label class="field_title service_det_edit" for="to_date">Price Per Person: </label>

                                <div class="exp-price">

                                    <span style="width: 100px; float: left;">

                                        <select class="exp-currency" name='exp_currency' id='dev_exp_currency' onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'currency') " >

                                            <?php foreach($currencyDetail->result() as $currency) { ?>

                                              <option value="<?php echo $currency->currency_type;?>" <?php if($listDetail->row()->currency == $currency->currency_type) echo 'selected="selected"';?>><?php echo $currency->currency_type;?></option>

                                            <?php } ?>

                                        </select>

                                    </span>

                                    <span style="width: 120px; float: left;margin-left: 5px;">

                                        <input type="text" class=" col-sm-2 changePrice"  id="price"  onkeypress="return isNumber(event)" name="price" onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'price') "  value="<?php echo $listDetail->row()->price; ?>"  />

                                    </span>

                                </div>

                            </div>

                        </div>



                    



                        <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>

                       

*/?>

                        	

                    </div>

					

					<?php

					if(!isset($exp_type)){

						if($exp_type==''){

					?>

                     <div class="basic-next">

					 <button class="next_button" type="submit"><?php if($this->lang->line('Save_and_Continue') != '') { echo stripslashes($this->lang->line('Save_and_Continue')); } else echo "Save & Continue";?></button>

					 </div>

					<?php 

						}

					}else{

						//echo $id;

						if($id!=0){

						?>

						<div class="basic-next">

						 <button class="next_button continue" type="button" id="next-btn"><?php if($this->lang->line('Continue') != '') { echo stripslashes($this->lang->line('Continue')); } else echo "Continue";?></button>

						 </div>

						<?php 

						}

					}

					?>



                </form>





                </div>

            

            </div>

            

           </div> 

            

            

            <div class="calender_comments">

            

                <div class="calender_comment_content">

                

                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>

                    

                    <div class="calender_comment_text">

                    

                        <h2><?php if($this->lang->line('exp_basic_experience') != '') { echo stripslashes($this->lang->line('exp_basic_experience')); } else echo "Speak out your Experience";?></h2>

                    

                        <p><?php if($this->lang->line('exp_fill_your_basic_info') != '') { echo stripslashes($this->lang->line('exp_fill_your_basic_info')); } else echo "No one can epitomize your experience better than you. Depict your unique experience in a short and sweet way. The description should outline all the stellar features of Your Experience in 250 Characters or Less.";?> </p>

                        <p> <?php if($this->lang->line('exp_you_cant_edit') != '') { echo stripslashes($this->lang->line('exp_you_cant_edit')); } else echo "Create your experience earn extra money by attracting more explorers. No matter who you are, you can be a chef, hiker, theater artist, or a singer who love to share their experience with others. Anyone can create and host their interest or passion.";?> </p>



                        <?php /* ?>

                        <p><strong><?php if($this->lang->line('example') != '') { echo stripslashes($this->lang->line('example')); } else echo "Example";?>:</strong><?php if($this->lang->line('Ourcooland') != '') { echo stripslashes($this->lang->line('Ourcooland')); } else echo "Our cool and comfortable one bedroom apartment with exposed brick has a true city feeling! It comfortably fits two and is centrally located on a quiet street, just two blocks from Washington Park. Enjoy a gourmet kitchen, roof access, and easy access to all major subway lines!";?>  </p>

                        <?php */ ?>

                        

                    

                    </div>

                    

                    

                

                </div>

            

            </div>

            

        

        </div>

        

    </div>



<script type="text/javascript">

    /*

	 function checkSpcialChar(event){

	 

		if(!((event.keyCode >= 65) && (event.keyCode <= 90) || (event.keyCode >= 97) && (event.keyCode <= 122) || (event.keyCode >= 48) && (event.keyCode <= 57))){

		   event.returnValue = false;	

		   return;

		}

		event.returnValue = true;

	 } */



    function isNumber(evt) {

        evt = (evt) ? evt : window.event;

        var charCode = (evt.which) ? evt.which : evt.keyCode;

        if (charCode > 31 && (charCode < 48 || charCode > 57)) {

            return false;

        }

        return true;

    }

	



function change_date_or_time(type){

	//alert(type);



	if(type==2){

		$('.date_count_div').hide();

		$('#total_count_date').val('');

		$('.hour_count_div').show();

	}else{

		$('.date_count_div').show();

		$('.hour_count_div').hide();

		$('#total_count_time').val('')

	}	

}

function validate_form_new(e){

	

	experience_type=$('#experience_type').val();

	type_id=$('#type_id').val();

	err=0;

	if(experience_type!=''){

		if(experience_type==2){

			count=$('#total_count_time').val();

		}else{

			count=$('#total_count_date').val();

			if(count < 2) 

				{

					$('#days_error').html('Number of Days Shoule be at least 2..!');

					return false;

			

				}else

				{

					$('#days_error').html('');

				}

		}

		if(count==''){

			err=1;

		}

	}else{

		err=1;

	}

	

	if(type_id==''){

		err=1;

	}

	//alert(err);

	

	if(err==1){

		//$('.error').show();

		 $('.error').fadeIn('slow', function () {

			$(this).delay(5000).fadeOut('slow');

		 });

		 return false;

	}else{

		url='<?php echo base_url()."add_experience_new";?>';

		$('#overviewlist').attr('method', 'post');

		$('#overviewlist').attr('action', url).submit();



	}

}

$(document).ready(function() {

    $('#next-btn').click(function(e) {  

     window.location.href = '<?php echo base_url()."experience_language_details/".$id; ?>';

    });

});

</script>



<!-- To Update Experience Category-->

<script type="text/javascript">

function UpdateExp_Category(){

	var category=$("#type_id").val();

	var exp_id=$("#id").val();

	

	if(category!='' && exp_id!=''){

	$.ajax({

		type:'POST',

		data:{'category_id':category,'exp_id':exp_id},

		url:'site/experience/UpdateExp_Category',

		success:function(data){

				data=data.trim();

			if(data=='success'){

				$("#cat_update").html('Experience Category is Updated..!');

				$('#cat_update').fadeIn('slow', function () {

					$(this).delay(1000).fadeOut('slow',function(){

						$('#cat_update').html('');

					});

				});

			}else{

				org_type_id=$("#org_type_id").val();

				$("#type_id").val(org_type_id);

				$("#cat_update").html('<span style="color: red;">Sorry,Booking happend on this experience!</span>');

				$('#cat_update').fadeIn('slow', function () {

					$(this).delay(1000).fadeOut('slow',function(){

						$('#cat_update').html('');

					});

				});

			}

		}

	});

	}else{

		$("#cat_update").html('<span style="color: red;">Please Choose Category..!</span>');

		$('#cat_update').fadeIn('slow', function () {

			$(this).delay(1000).fadeOut('slow',function(){

				$('#cat_update').html('');

			});

		});

	}

	

}

</script>

<script type="text/javascript">

/** to Avoide hour entereing more then 24**/

function hourValidation(){

	var entered_hour=$("#total_count_time").val();

	if(entered_hour > 24){

				$("#entered_hour_err").html('Total hours Should be 24 or below');

				$("#total_count_time").val('');

				$('#entered_hour_err').fadeIn('slow', function () {

					$(this).delay(1000).fadeOut('slow',function(){

						$('#entered_hour_err').html('');

					});

				});

	}

}

</script>



<style>

.content{

height:44px !important;

}

</style>



<?php $this->load->view('site/templates/footer'); ?>