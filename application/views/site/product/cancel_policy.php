<?php 



$this->load->view('site/templates/header');



$this->load->view('site/templates/listing_head_side');







	$can_policy="";



	$roombedVal=json_decode($listValues->row()->rooms_bed);



	$can_policy=$roombedVal->can_policy;



?>



<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addProperty.js"></script>

<style type="text/css">

	input[type=number]::-webkit-inner-spin-button, 

input[type=number]::-webkit-outer-spin-button { 

    -webkit-appearance: none;

    -moz-appearance: none;

    appearance: none;

    margin: 0; 

}

</style>

         

<form action="<?php echo base_url()."cancel_policy/".$listDetail->row()->id;?>" method="post" accept-charset="UTF-8"> 

            <div class="right_side cancelation">



            



            <div class="dashboard_price_main policy-sel">



			<?php if($this->lang->line('Pleaseselectyour') != '') { echo stripslashes($this->lang->line('Pleaseselectyour')); } else echo "Please select your cancellation policy. You can read more about the cancellation policy"; ?> <a target="_blank" href="<?php echo 'pages/'.$cancellation_policy->row()->seourl;?>"><?php if($this->lang->line('here') != '') { echo stripslashes($this->lang->line('here')); } else echo "here"; ?> </a>.



           <?php //echo stripslashes($cancellation_policy->row()->description);?>



            </div>



			<div class="cancelation-text dashboard_price_main">

			<div class="cancel-listrow">

			<label><?php if($this->lang->line('CancellationPolicy') != '') { echo stripslashes($this->lang->line('CancellationPolicy')); } else echo "Cancellation Policy"; ?><span class="req">*</span></label>



			<?php  //echo $listDetail->row()->cancellation_policy;?>



			<select name="cancellation_policy" title="<?php if($this->lang->line('CancellationPolicy') != '') { echo stripslashes($this->lang->line('CancellationPolicy')); } else echo "Cancellation Policy"; ?>" required onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'cancellation_policy'); show_val(this);">



			<option value = ""><?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?></option>



			



			<?php



									  if($can_policy!=""){ 



										$can_policyArr=@explode(',',$can_policy);



										foreach($can_policyArr as $rows){



									  ?>



									



									 <option value="<?php echo $rows; ?>"<?php if($listDetail->row()->cancellation_policy == $rows) { echo 'selected="selected"';} ?>>



											<?php echo $rows; ?>



										</option>



									  <?php 



										}



									  } 



									?>



			</select></div>

			<div id="return_amount_percentage" >

						<div class="cancel-listrow" >

			<label class="depost"><?php if($this->lang->line('return_amount_property') != '') { echo stripslashes($this->lang->line('return_amount_property')); } else echo "Return Amount"; ?><span class="req">*</span></label>



			<input  type="text" maxlength="2" title="<?php if($this->lang->line('return_amount_property') != '') { echo stripslashes($this->lang->line('return_amount_property')); } else echo "Return Amount"; ?>" value="<?php echo $listDetail->row()->cancel_percentage;?>" class="number_field per_amount_scroll" onkeypress="return check_for_num(event)" id="return_amount" name="return_amount" placeholder="<?php if($this->lang->line('return_amount_property_place') != '') { echo stripslashes($this->lang->line('return_amount_property_place')); } else echo "Enter your return amount"; ?>"  onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'cancel_percentage');" required/> %

			</div>

			

			

			</div>

			

			<div id="cancel_description" >

			<div class="cancel-listrow">

			<label class="depost"><?php if($this->lang->line('description_can_property') != '') { echo stripslashes($this->lang->line('description_can_property')); } else echo "Description"; ?><span class="req">*</span></label>



			

			

			<textarea  class="per_amount_scroll" title="<?php if($this->lang->line('description_can_property') != '') { echo stripslashes($this->lang->line('description_can_property')); } else echo "Description"; ?>" placeholder="<?php if($this->lang->line('enter_desc_canpolicy') != '') { echo stripslashes($this->lang->line('enter_desc_canpolicy')); } else echo "Enter your description"; ?>" id="can_description" name="can_description" onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'cancel_description');" required/><?php echo $listDetail->row()->cancel_description;?></textarea>

			</div>

			</div>

			<div class="cancel-listrow">

			<label class="depost"><?php if($this->lang->line('SecurityDeposit') != '') { echo stripslashes($this->lang->line('SecurityDeposit')); } else echo "Security Deposit"; ?>(<?php if($this->lang->line('optional') != '') { echo stripslashes($this->lang->line('optional')); } else echo "Optional"; ?>)</label>



			<?php if($listDetail->row()->currency != ''){



						$currency_type=$listDetail->row()->currency;



						$currency_symbol_query='SELECT * FROM '.CURRENCY.' WHERE currency_type="'.$currency_type.'"';



						$currency_symbol=$this->product_model->ExecuteQuery($currency_symbol_query);



	



						if($currency_symbol->num_rows() > 0)



						{



							$currency_sym = $currency_symbol->row()->currency_symbols;



						}



						else{



							$currency_sym = '$';



						}



						?>



						



							<span class="WebRupee"><?php echo $currency_sym; ?></span>



						<?php } else { ?>



							<span class="WebRupee">$</span>



						<?php } ?>

<!-- type="number" pattern="[0-9]*\.[0-9]{0,2}" title="Example : 100.00"-->

			<input  type="text" maxlength="5"  title="<?php if($this->lang->line('SecurityDeposit') != '') { echo stripslashes($this->lang->line('SecurityDeposit')); } else echo "Security Deposit"; ?>" value="<?php echo $listDetail->row()->security_deposit;?>" class="per_amount_scroll" onkeypress="return check_for_num(event)" id="price" name="security_deposit" onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'security_deposit');" />

			</div>

			<div class="cancel-listrow">

			<label class="depost"><?php if($this->lang->line('cleaningfee') != '') { echo stripslashes($this->lang->line('cleaningfee')); } else echo "Cleaning Fee"; ?>(<?php if($this->lang->line('optional') != '') { echo stripslashes($this->lang->line('optional')); } else echo "Optional"; ?>)</label>



			<?php if($listDetail->row()->currency != ''){



						$currency_type=$listDetail->row()->currency;



						$currency_symbol_query='SELECT * FROM '.CURRENCY.' WHERE currency_type="'.$currency_type.'"';



						$currency_symbol=$this->product_model->ExecuteQuery($currency_symbol_query);



	



						if($currency_symbol->num_rows() > 0)



						{



							$currency_sym = $currency_symbol->row()->currency_symbols;



						}



						else{



							$currency_sym = '$';



						}



						?>



						



							<span class="WebRupee"><?php echo $currency_sym; ?></span>



						<?php } else { ?>



							<span class="WebRupee">$</span>



						<?php } ?>

<!-- type="number" pattern="[0-9]*\.[0-9]{0,2}" title="Example : 100.00"-->

			<input  type="text" maxlength="5"  title="<?php if($this->lang->line('cleaningfee') != '') { echo stripslashes($this->lang->line('cleaningfee')); } else echo "Cleaning Fee"; ?>" value="<?php echo $listDetail->row()->Cleaning_fees;?>" class="per_amount_scroll" onkeypress="return check_for_num(event)" id="price" name="Cleaning_fees" onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'Cleaning_fees');" />

			</div>

			</div>

			<span class="onclk-text"><?php if($this->lang->line('Want to add SEO tags') != '') { echo stripslashes($this->lang->line('Want to add SEO tags')); } else echo "Want to add SEO tags";?>?&nbsp;<span onclick="show_block_cate('1')"><?php if($this->lang->line('You can add') != '') { echo stripslashes($this->lang->line('You can add')); } else echo "You can add";?>.</span></span>

			<div class="dashboard_price_main" id="monthly" style="display:none" >



				<div class="overview_title cancel-listrow">

                        

                        	<label><?php if($this->lang->line('Meta Title') != '') { echo stripslashes($this->lang->line('Meta Title')); } else echo "Meta Title";?></label>

                        

                        	<input type="text" title="<?php if($this->lang->line('Meta Title') != '') { echo stripslashes($this->lang->line('Meta Title')); } else echo "Meta Title";?>" value="<?php echo $listDetail->row()->meta_title;?>" placeholder="<?php if($this->lang->line('Meta Title') != '') { echo stripslashes($this->lang->line('Meta Title')); } else echo "Meta Title";?>" class="title_overview meta_tile" 

                           onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'meta_title');" name="meta_title" style="color:#000 !important;" />

                            

                            <input type="hidden" id="id" name="id" value="<?php echo $listDetail->row()->id; ?>" />

                            

                            <!--<span>35 characters left</span>-->

                        

                        </div>

                        

                        

                        <div class="overview_title cancel-listrow">

                        

                        	<label><?php if($this->lang->line('keywords') != '') { echo stripslashes($this->lang->line('keywords')); } else echo "keywords";?></label>

                            

                            <textarea class="title_overview"  title="<?php if($this->lang->line('keywords') != '') { echo stripslashes($this->lang->line('keywords')); } else echo "keywords";?>" placeholder="<?php if($this->lang->line('Maximum150words') != '') { echo stripslashes($this->lang->line('Maximum150words')); } else echo "Maximum 150 words";?>" rows="8"  onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'meta_keyword');"  name="meta_keyword" id="meta_keyword" style="color:#000 !important;"><?php echo strip_tags($listDetail->row()->meta_keyword);?></textarea>

                        </div>

						

						<div class="overview_title cancel-listrow">

                        

                        	<label><?php if($this->lang->line('MetaDescription') != '') { echo stripslashes($this->lang->line('MetaDescription')); } else echo "Meta Description";?></label>

                            

                            <textarea class="title_overview" title="<?php if($this->lang->line('MetaDescription') != '') { echo stripslashes($this->lang->line('MetaDescription')); } else echo "Meta Description";?>" placeholder="<?php if($this->lang->line('Maximum150words') != '') { echo stripslashes($this->lang->line('Maximum150words')); } else echo "Maximum 150 words";?>" rows="8"  onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'meta_description');"  name="meta_description" id="meta_description" style="color:#000 !important;"><?php echo strip_tags($listDetail->row()->meta_description);?></textarea>

                        </div>



			</div>

			<input type="submit" value="<?php if($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save";?>" class="newline-btn" />

</form>

          </div>



		  

		  

		  <div class="calender_comments" id="dum_list4">

            

            	<div class="calender_comment_content">

                <div class="left-calender_comment">

                	<i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>

                    </div>

					<div class="right-calender_comment">

                    <div class="calender_comment_text">

                    

                    	<h2><?php if($this->lang->line('Cancellation') != '') { echo stripslashes($this->lang->line('Cancellation')); } else echo "Cancellation";?></h2>

                    

                    	<p><?php if($this->lang->line('It will only be shared with guests after a reservation is confirmed') != '') { echo stripslashes($this->lang->line('It will only be shared with guests after a reservation is confirmed')); } else echo "It will only be shared with guests after a reservation is confirmed";?>.</p>

                        

                       

                        

                    

                    </div></div>

                    

                    

                

                </div>

            

            </div>

		  

		  

		  

		  

		  

            



        </div>



        



    </div>



<script type="text/javascript">



function DeleteListYoutProperty(val){



	//$('#delete_profile_image').disable();



	var res = window.confirm('<?php if($this->lang->line('Are_you_sure') != '') { echo stripslashes($this->lang->line('Are_you_sure')); } else echo "Are you sure";?>?');



	if(res){



		window.location.href = 'site/product/delete_property_details/'+val;



	}else{



		//$('#delete_profile_image').removeAttr('disabled');



		return false;



	}



}

function show_block_cate(columin_id)



{



  $(".onclk-text").css("display","none");



   $("#monthly").css("display","block");  



}



function check_for_num(evt)

{

	evt = (evt) ? evt : window.event;

	var charCode = (evt.which) ? evt.which : evt.keyCode;

	if (charCode > 31 && (charCode < 48 || charCode > 57))

	{

		return false;

	}

	return true;

}

function show_val(cancel_value)

{

	if(cancel_value.value == 'Flexible') // (n)% amount to guest

	{

		$('#return_amount').val('100');

		$('#return_amount').attr('readonly', false);

		$('#return_amount').trigger("change");

        $('#return_amount').attr('readonly', 'true');

		$('#return_amount_percentage').show(); 

		$('#cancel_description').show(); 

	}

	else if(cancel_value.value == 'Strict')  //Only 50% amount to guest 

	{

		$('#return_amount').val('50');

		/*update the onchange vaues in trigger concept*/

		$('#return_amount').trigger("change");

		$('#return_amount').attr('readonly', 'true');

		$('#return_amount_percentage').show(); 

		$('#cancel_description').show();

	}

	else if(cancel_value.value == 'Moderate')   //Except Guest fee to Guest

	{

		//var id = $("#id").val();

		//Detailview_local('0',id,'cancel_percentage');

		$('#return_amount').val('100');

		$('#return_amount').trigger("change");

		$('#return_amount').attr('readonly', 'true');

		$('#return_amount_percentage').show(); 

		$('#cancel_description').show();

		

	}else if (cancel_value.value == 'No Refund'){  //No CashBack to Guest

		$('#return_amount').val('0');

		$('#return_amount').trigger("change");

		$('#return_amount').attr('readonly', 'true');

		$('#return_amount_percentage').show(); 

		$('#cancel_description').show();	

	}

	else

	{

		$('#return_amount_percentage').hide(); 

		$('#cancel_description').hide();

	}

}

function Detailview_local(title,catID,chk){



	//alert(chk);

		$.ajax({

			type:'post',

			url:baseURL+'site/product/saveDetailPage',

			data:{'catID':catID,'title':title,'chk':chk},

			

			complete:function(){

				$('#imgmsg_'+catID).hide();

				//$('#imgmsg_'+catID).show().text('Saved');

				//$('#imgmsg_'+catID).show().text(msg);

			}

		});

}  

</script>

<script>

$(document).ready(function() {

    $(".number_field").keydown(function (e) {

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

<!---DASHBOARD--> 



<?php



$this->load->view('site/templates/footer');



?>