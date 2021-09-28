<?php $this->load->view('site/templates/header'); 
$this->load->view('site/experience/experience_head_side');

//print_r($listDetail->row());
?>
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>

			<div class="right_side overview schedule-experience">
				 <div class="dashboard_price_main" style="border-bottom:none;">
            
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('exp_set_your_time') != '') { echo stripslashes($this->lang->line('exp_set_your_time')); } else echo "Schedule your Experience";?></h3>
                        
                        <p><?php if($this->lang->line('Atitleandsummary') != '') { echo stripslashes($this->lang->line('Atitleandsummary')); } else echo "You can adjust this time depending on the dates you're scheduled to host. Each experience must be at least 1 hour.";?> </p>
                    
                    </div>
					
							<!---List of schedule---->
				<div class="add_new_form">
					
					
					
					<form onsubmit="return validate_form()" id="overviewlist" name="overviewlist" action="<?php echo base_url()."photos_listing/".$listDetail->row()->id;?>" method="post" accept-charset="UTF-8">
                    <div class="dashboard_price_right">

                   

                        <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                        <input type="hidden" class=" col-sm-2"  id="dates_id" name="dates_id" />
                        
							<div class="basic-next">
							  <span id="form_action_msg_common"></span>
							 <button class="next_button" id="add_new" type="button"><?php if($this->lang->line('exp_add_new') != '') { echo stripslashes($this->lang->line('exp_add_new')); } else echo "Add new";?></button>
							</div>
					 
                        <div class="overview_title new_schedule_div" style="display:none;">
                        	<label class="exp-reqlbl"><?php if($this->lang->line('experience_Schedule') != '') { echo stripslashes($this->lang->line('experience_Schedule')); } else echo "New Schedule";?> <span class="req"> *</span></label>
							<div class="exp-outerpanel exp-div">
						
                        <?php if($listDetail->row()->date_count>1) { ?>
                        

	                            <div class="col-md-3 col-xs-12 no-padding">
									<label class="field_title service_det_edit"  for="datetimepicker1"><?php if($this->lang->line('exp_from_date') != '') { echo stripslashes($this->lang->line('exp_from_date')); } else echo "From Date";?>: </label>
									<input type="text" class="dev_tour_date col-sm-2" placeholder="yyyy-mm-dd"  id="datetimepicker1" onchange='affectTodate()' class="checkin ui-datepicker-target" style="cursor:pointer;" name="from_date" onclick="datepick();" />
								</div>

								<div class=" col-md-3 col-xs-12 no-padding">
									<label class="field_title service_det_edit" for="to_date"><?php if($this->lang->line('exp_to_date') != '') { echo stripslashes($this->lang->line('exp_to_date')); } else echo "To Date";?>: </label>
									<input type="text" placeholder="yyyy-mm-dd" class=" col-sm-2"  id="to_date" name="to_date" readonly value=""/>
								</div>
								<?php /*
								<div class=" col-md-4 col-xs-12 no-padding">
									<label class="field_title service_det_edit" for="to_date">Price: </label>
									<select class="exp-currency" name='exp_currency' id='dev_exp_currency'><?php foreach($currencyDetail->result() as $currency) {  if($listDetail->row()->currency == $currency->currency_type) {?>
                                      <option value="<?php echo $currency->currency_type;?>" <?php if($listDetail->row()->currency == $currency->currency_type) echo 'selected="selected"';?>><?php echo $currency->currency_type;?></option>
                                    <?php } } ?></select>
									<input type="text" class=" col-sm-2"  id="price" name="price"  value="<?php echo $listDetail->row()->price;  ?>" readonly />
								</div>
								<?php */ ?>
							
                      

                        <?php } else{
                        	?>
	                            <div class="col-md-3 col-xs-12 no-padding">
									<label class="field_title service_det_edit" for="datetimepicker1"><?php if($this->lang->line('exp_choose_date') != '') { echo stripslashes($this->lang->line('exp_choose_date')); } else echo "Choose date";?></label>
									<input type="text" class="dev_tour_date col-sm-2"  id="datetimepicker1" onclick="datepick();" onchange='affectTodate()' name="from_date" />
									<input type="hidden" class=" col-sm-2"  id="to_date" name="to_date" readonly value=""/>
								</div>
								
								
								<?php /* ?>
	                        	<div class=" col-md-4 col-xs-12 no-padding">
									<label class="field_title service_det_edit" for="to_date">Price: </label>
									<select class="exp-currency" name='exp_currency' id='dev_exp_currency' disabled >
									<?php foreach($currencyDetail->result() as $currency) {  if($listDetail->row()->currency == $currency->currency_type) {?>
                                      <option value="<?php echo $currency->currency_type;?>" <?php if($listDetail->row()->currency == $currency->currency_type) echo 'selected="selected"';?>><?php echo $currency->currency_type;?></option>
                                    <?php } } ?>
									</select>
									<input type="text" class=" col-sm-2"  id="price" name="price"  value="<?php echo $listDetail->row()->price;  ?>" readonly />
								</div>
								<?php */ ?>
	                        
	                        
                        	<?php
                        	} ?>

							
								<div class="exp-addicon  col-md-3 col-xs-12 no-padding">
								<label style="margin-top: 15px;"></label>
								<button type="button" class="btn-sm" id='cancel_btn' title="cancel" onclick="cancel_dates_form()" ><span style="color:#fff"><b> <?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel";?></b></span></button><button type="button" class="btn-sm" id='add_btn' title="Add Date" onclick="add_dates()" ><span style="color:#fff"><b><?php if($this->lang->line('Submit') != '') { echo stripslashes($this->lang->line('Submit')); } else echo "Submit";?></b></span></button></div>
							
							<!--- Experiece Panel9-->
							
							<div class="popup-panel-exp" id='dev_add_date_timing' style='display: none; margin-bottom: 15px;' >

								<div class="exp-addpanel">
								<div style="display: block;overflow: hidden;">
								<div class="col-md-6">
								<label><?php if($this->lang->line('Date') != '') { echo stripslashes($this->lang->line('Date')); } else echo "Date";?></label>
									<?php if($listDetail->row()->date_count>1) { ?>
										<input type="text" class="dev_multi_schedule_date col-sm-2"  id="schedule_date1" name="schedule_date[]" onclick="setDatepickerHere();" />
									<?php } else { ?>
										<input type="text" class="dev_multi_schedule_date dev_schedule_date col-sm-2"  id="schedule_date1" name="schedule_date[]" readonly />
									<?php	
									}?>	
                                    </div>
                               
                                   	</div>
                                    <div class="col-md-6">
									<label><?php if($this->lang->line('exp_start_time') != '') { echo stripslashes($this->lang->line('exp_start_time')); } else echo "Start Time";?></label>
									<input type="text" class="dev_time" name="start_time[]" id="start_time"  value="" required/>
									</div>
									<div class="col-md-6">
									<label><?php if($this->lang->line('exp_end_time') != '') { echo stripslashes($this->lang->line('exp_end_time')); } else echo "End Time";?></label>
									<input type="hidden" class="dev_time"  name="end_time[]" value="" required />
									<input type="text" class="dev_time"  name="end_time1[]" value="" required />
									</div>
									<div class="col-md-12 exp-full">
									<label><?php if($this->lang->line('Title') != '') { echo stripslashes($this->lang->line('Title')); } else echo "Title";?></label>
									<input type="text" class="" name="schedule_title[]"  value="" required />
									</div>
									<div class="col-md-12">
									<label><?php if($this->lang->line('list_Description') != '') { echo stripslashes($this->lang->line('list_Description')); } else echo "Description";?></label>
								<textarea class="" id="description_id" name="schedule_description[]" required >  </textarea>
								</div>
									<!--<input type="text" class="" name="schedule_description[]"  value=""  />-->
									
								
								</div>
								
								<!--<div class="exp-addicon"><button type="button" class="" id='add_timing_btn_1' onclick="add_timing_row(1)" ><span class="add-timeing">Add new Timing</span><i class="fa fa-plus-circle" aria-hidden="true"></i></button></div>-->
								
							</div>
							
							<?php for($i=1;$i<50;$i++){
							?>
								<div id="dev_new_timing<?php echo $i; ?>"></div>

							<?php
							}?>
							
<div class="exp-addicon"><button title="save" style='display:none;width: 40px;padding-right:4px;font-size: 16px;background: #752b7e; color:#ffffff;' type="button"  class="" id='save_timing_btn' onclick="save_timing()" ><?php if($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save";?></button></div> 
						
							<!--- Experiece Panel End-->

								<div style="">
									 <input type="button" class="filter-btn" id="update_btn" style="display: none; float: left;" name="" value="Update" onclick="update_tab2()">
									<input type="reset" class="filter-btn" id="reset_btn" style="display: none; float: left;"  name="" value="Cancel" onclick="reset_reload()">

								</div>
																
							</div>
							

                        </div>
                    </div>


                </form>
       
            </div>    
			
					<!---List of schedule---->
					
					<div class="webform" method="post" id="hourly">
					<div class="managlist_tabl div_timing" id="package_table">
		            	<table id="example" cellspacing="0" width="100%" border="1" class="table table-striped display">
		            		<thead>
		            			<tr>
		            			<th><?php if($this->lang->line('Start Date') != '') { echo stripslashes($this->lang->line('Start Date')); } else echo "Start Date"; ?></th>
		            			<th><?php if($this->lang->line('End Date') != '') { echo stripslashes($this->lang->line('End Date')); } else echo "End Date"; ?></th>
		            			<!--<th>Price</th>-->		
		            			<th><?php if($this->lang->line('Action') != '') { echo stripslashes($this->lang->line('Action')); } else echo "Action"; ?></th>
		            			</tr>	
		            		<thead>
		            		<tbody>
		            		<?php 
							
							/*echo '<pre>';
							 print_r($date_details->result());
							echo '</pre>';
							*/
								
								// exit();
								
								if ($date_details->num_rows() > 0){
									$i = 1;
									foreach ($date_details->result() as $row){

										/* check for booking exist for tha particular schedule if exist dont allow to edit & delete */

								
									// $check_booking_entry = $this->experience_model->ExecuteQuery("select * from ".EXPERIENCE_ENQUIRY." where prd_id='".$row->experience_id."' and checkin='".date('Y-m-d',strtotime($row->from_date))."' and checkout='".date('Y-m-d',strtotime($row->to_date))."'");
									 
									 $query = "select * from ".EXPERIENCE_ENQUIRY." where prd_id='".$row->experience_id."' and checkin='".date('Y-m-d',strtotime($row->from_date))."' and checkout='".date('Y-m-d',strtotime($row->to_date))."'";
									 $check_booking_entry=$this->experience_model->ExecuteQuery($query);
									
									
									
								?>
		            		<tr id="parent_<?php echo $row->id;?>">
							    
		            			<td><input type="hidden" id="from_date_<?php echo $row->id;?>" value="<?php echo $row->from_date; ?>"><?php echo $row->from_date;?></td>
			            		<td><input type="hidden" id="to_date_<?php echo $row->id;?>" value="<?php echo $row->to_date; ?>"><?php echo $row->to_date;?></td>
								
			            		<!--<td><?php echo   $row->price; ?> </td>-->
								
			            		<td class="date_actions" id="tab_span_date">
			            			
		            				<?php if($check_booking_entry->num_rows()==0)  //$listDetail->row()->status == '0' 
		            				{ 
		            					if(date('Y-m-d',strtotime($row->from_date)) > date('Y-m-d'))	/* schedule once started  means no edit priviledge */
		            					{	

		            					?>	
										
										
									<?php /*	
										<span class="action-icons c-edit" onclick="javascript:get_activity_data('<?php echo $row->experience_id; ?>','<?php echo $row->id; ?>','<?php echo $row->from_date; ?>','<?php echo $row->to_date; ?>','<?php echo $row->price; ?>');" title="Edit" style="cursor: pointer;"><?php if($this->lang->line('back_Edit') != '') { echo stripslashes($this->lang->line('back_Edit')); } else echo "<i class='fa fa-pencil-square-o fa-lg' aria-hidden='true'></i>"; ?></span> |
										
										*/?>
										
										<?php } ?>
									
									<?php 
									$allow=0;
									if($row->time_count<$listDetail->row()->date_count) { 
										$allow=1;
									} ?>
									
									<input type="hidden" name="schedule_hours_<?php echo $row->id; ?>" id="schedule_hours_<?php echo $row->id; ?>" value="<?php echo $listDetail->row()->total_hours; ?>">
									<span class="action-icons c-delete" onclick="get_new_timesheet('<?php echo $row->id;?>','<?php echo $row->status;?>','<?php echo $allow; ?>');" title="Add Sheduled timings"><i class="fa fa-plus-square-o fa-lg cursor_pointer" aria-hidden="true"></i></span>&nbsp;&nbsp;
									
									<span class="" onclick="view_timesheet('<?php echo $row->id;?>');" title="View Sheduled timings"><i class="fa fa-eye fa-lg cursor_pointer" aria-hidden="true"></i> (<?php echo $row->time_count; ?>) </span>&nbsp;&nbsp;
									
									<span><a class="delet_time" href="site/experience/delete_date/<?php echo $row->id;?>/<?php echo $row->experience_id;?>" title="Delete"><i class="fa fa-trash-o fa-lg cursor_pointer" aria-hidden="true"></i> </a></span>&nbsp;&nbsp;
									
									<?php
									//echo $row->status;
									if($row->status==1){
										
										
										
				if($this->lang->line('exp_inactive') != '') 
				{ 
					$Inactive = stripslashes($this->lang->line('exp_inactive')); 
				} 
				else 
				{
					$Inactive = "Inactive";
				}
										
										
										//$active_str='Inactive';
										$active_str=$Inactive;
										
										
										
										
										
									}else{
										
															
				if($this->lang->line('exp_Active') != '') 
				{ 
					$active = stripslashes($this->lang->line('exp_Active')); 
				} 
				else 
				{
					$active = "Active";
				}	
										
										
										
										
										//$active_str='Active';
										$active_str=$active;
									}
									?>
									<span class="status" id="span_sts" title="Make inactive"><a class="btn-sm status" href='javascript:void(0);' id="status_<?php echo $row->id; ?>" onclick="change_date_status('<?php echo $row->id;?>',this);"><?php echo $active_str; ?></a></span>&nbsp;&nbsp;
									
									<span class="" onclick="hide_child('<?php echo $row->id;?>');" style="display:none;" id="hide_icon_<?php echo $row->id;?>" title="hide"><i class="fa fa-minus-square-o fa-lg cursor_pointer" aria-hidden="true"></i></span>&nbsp;&nbsp;

									 <?php }  else{
										 
										 echo $status=$check_booking_entry->row()->booking_status; ?>
										 
										 
										 <span class="" onclick="view_timesheet_forStatus('<?php echo $row->id;?>','<?php echo $status; ?>');" title="View Sheduled timings"><i class="fa fa-eye fa-lg cursor_pointer" aria-hidden="true"></i> (<?php echo $row->time_count; ?>) </span>&nbsp;&nbsp;
										 
									 <?php }
									 
																	 ?>
		                               <!--  <span><a class="action-icons c-delete" onclick="javascript:delete_season_data('<?php //echo $row->season_id;?>','<?php //echo $row->product_id;?>','<?php //echo $row->date_from; ?>','<?php //echo $row->date_to; ?>');" title="Delete">Delete</a></span> -->

									
			            		</td>
		            		</tr>
							
							
		            		<?php 
								$i++;	
									}
								}else{
								?>
								<tr>
									<td colspan="6"><?php if($this->lang->line('exp_no_activity_found') != '') { echo stripslashes($this->lang->line('exp_no_activity_found')); } else echo "No Activity Found.."; ?></td>
								</tr>
								<?php } ?>
		            		<tbody>
		            		
		            	</table>


					</div>
					
			    </div>
				
<script>
function change_timing_status(id,obj,exp_date_id){
	//hide_other_divs();
	$('.new_schedule_div').hide();
	str=$(obj).html().trim();

	if(str=='Active'){
		status='0';//inactive
		//$(obj).html('Inactive');
	}else{
		status='1';//active
	//	$(obj).html('Active');
	}

	$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/change_timing_status',
			data:'id='+id+'&status='+status+'&exp_date_id='+exp_date_id,
			dataType:'html',
			success:function(data){
				//alert(data);
				//return false;
				/*if(data==2){
					//alert(data+'l');
					$('#status_'+exp_date_id).html('Inactive');
					$(obj).html('Active');
					$('#form_action_msg_common').html('Sheduled time has been activated Successfully..!');
					$('#form_action_msg_common').fadeIn('slow', function () {
						$(this).delay(1000).fadeOut('slow',function(){
							$('#form_action_msg_common').html('');
						});
					});
				}else{
				*/	
					if(data){
						if(str=='Active'){
							$(obj).html('Inactive');
							$('#form_action_msg_common').html('Sheduled time has been inactivated Successfully..!');
							$('#form_action_msg_common').fadeIn('slow', function () {
								$(this).delay(1000).fadeOut('slow',function(){
									$('#form_action_msg_common').html('');
								});
							});
							
						}else{
							$(obj).html('Active');
							$('#form_action_msg_common').html('Sheduled time has been activated Successfully..!');
							$('#form_action_msg_common').fadeIn('slow', function () {
								$(this).delay(1000).fadeOut('slow',function(){
									$('#form_action_msg_common').html('');
								});
							});
						}
					}
				//}
			}
	});
}

function change_date_status(id,obj){
	hide_other_divs();
	$('.new_schedule_div').hide();
	str=$(obj).html().trim();

	if(str=='Active'){
		status='1';//inactive
		//$(obj).html('Inactive');
	}else{
		status='0';//active
	//	$(obj).html('Active');
	}

	$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/change_date_status',
			data:'id='+id+'&status='+status,
			dataType:'html',
			success:function(data){
				//alert(data);
				//return false;
				
				if(data){
					if(str=='Active'){
						$(obj).html('Inactive');
						$('#form_action_msg_common').html('Sheduled date has been inactivated Successfully..!');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow',function(){
								$('#form_action_msg_common').html('');
							});
						});
						
					}else{
						$(obj).html('Active');
						$('#form_action_msg_common').html('Sheduled date has been activated Successfully..!');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow',function(){
								$('#form_action_msg_common').html('');
							});
						});
					}
				}
				window.location.reload();
			}
	});
}
function all_form_reset(){
	$('form').each(function() { this.reset() });
}
function cancel_time_sheet_grand_child(id){
	all_form_reset();
	$('#grand_child_edit_'+id).remove();
}

function edit_time_sheet(id,date_id){
	
	$('[id^=grand_child_edit_]').hide();
	if($('#grand_child_edit_'+id).length>0){
		$('#grand_child_edit_'+id).show();
		return false;
	}
	$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/get_timesheets_for_edit',
			data:'id='+id,
			dataType:'html',
			success:function(data){
				if(data!=''){
					
					$('#first_child_'+id).after(data);
					
					$('#grand_child_edit_'+id).show();
					
					$('.dev_multi_schedule_date').each(function(){
			
						
						$(this).datepicker({

							changeMonth: true,
							dateFormat: 'yy-mm-dd',
							numberOfMonths: 1,
							minDate: new Date($('#from_date_'+date_id).val()),
							maxDate :new Date($('#to_date_'+date_id).val()),
							beforeShowDay: unavailable_new,
							
						});
					});
				
				$('.dev_time').timepicker({
					
				'minTime': '12:00am',
				'maxTime': '11:59pm',
				'timeFormat': 'h:i  a',
				'step': 60,

				});
				
		
		
				}
			}
	});
		
	$('#update_time_sheet_'+id).show();
	$("#timesheet_"+id+" input").prop("disabled", false);
	$("#timesheet_"+id+" textarea").prop("disabled", false);
	
}

/*function update_time_sheet(id,date_id){
	
	var schedule_date = $('#time_sheet_'+id).find('input[name="schedule_date"]').val();
	var start_time = $('#time_sheet_'+id).find('input[name="start_time"]').val();
	
	
	var startime_converted = convertTo24Hour(start_time);
	
	

	var del_zoro = startime_converted.split(":")
	
	if(del_zoro[0].length == 3 ){
		var newString = del_zoro[0].indexOf('0') == 0 ? startime_converted.substring(1) : startime_converted;
		startime_converted = newString;
	}
	
	//alert(startime_converted);
	
	
	
	var end_time = $('#time_sheet_'+id).find('input[name="end_time"]').val();
	
	var title = $('#time_sheet_'+id).find('input[name="title"]').val();
	var description = $('#time_sheet_'+id).find('textarea[name="description"]').val();
	
	//
	if(schedule_date=='' || startime_converted=='' || end_time=='' || title=='' || description==''){
		
		$('#edit_form_error_msg_'+id).html('Please fill all mandatory fields');
		$('#edit_form_error_msg_'+id).fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow',function(){
				$('#edit_form_error_msg_'+id).html('');
			});
		});
		return false;
	}
	
	
	hours_count=$('#schedule_hours_'+date_id).val();
	//alert(hours_count);
	hours_count=$('#schedule_hours_'+date_id).val();
	//alert(hours_count);

	var diff_start = startime_converted.replace(":", ".");
	var diff_end = end_time.replace(":", ".");
	
	
	/*if(parseInt(diff_end)<=parseInt(diff_start)){
		$('#edit_form_error_msg_'+id).html('End time should be greater than start time');
		$('#edit_form_error_msg_'+id).fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow',function(){
				$('#edit_form_error_msg_'+id).html('');
			});
		});
		return false;
	}*/
	/*if(hours_count!='' && hours_count>0){
		
		diff=parseFloat(diff_end-diff_start);
		alert(diff_start);
	alert(diff);

		if(parseInt(hours_count)==parseInt(diff)){
			//alert('same');
		}else{
			//alert('not same');
			$('#edit_form_error_msg_'+id).html('Allowed time limit is '+hours_count+' hours ');
			$('#edit_form_error_msg_'+id).fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow',function(){
					$('#edit_form_error_msg_'+id).html('');
				});
			});
			return false;
		}
		
	}

	if(id!='' && id!=null){
		$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/update_timesheet',
			data:$('#time_sheet_'+id).serialize(),
			dataType:'html',
			success:function(data){
				if(data){
					alert("<?php if($this->lang->line('exp_time_schedule_succ') != '') { echo stripslashes($this->lang->line('exp_time_schedule_succ')); } else echo "Time schedule is updated successfully"; ?>");
					window.location.reload();
				}
			}
		});
	}
}*/

function update_time_sheet(id,date_id){
	
	var schedule_date = $('#time_sheet_'+id).find('input[name="schedule_date"]').val();
	
	
	start_time=$('input[name="start_time"]').val();
	
	

	var startime_converted = convertTo24Hour(start_time);
	var del_zoro = startime_converted.split(":")
	if(del_zoro[0].length == 3 ){
		var newString = del_zoro[0].indexOf('0') == 0 ? startime_converted.substring(1) : startime_converted;
		startime_converted = newString;
	}
	/*micheal alert(startime_converted);
	return false;*/
	
	
	
	
	var start_time = startime_converted ;
	var end_time = $('#time_sheet_'+id).find('input[name="end_time"]').val();
	var title = $('#time_sheet_'+id).find('input[name="title"]').val();
	var description = $('#time_sheet_'+id).find('textarea[name="description"]').val();
	
	//
	if(schedule_date=='' || startime_converted=='' || end_time=='' || title=='' || description==''){
		
		$('#edit_form_error_msg_'+id).html('Please fill all mandatory fields');
		$('#edit_form_error_msg_'+id).fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow',function(){
				$('#edit_form_error_msg_'+id).html('');
			});
		});
		return false;
	}
	hours_count=$('#schedule_hours_'+date_id).val();
	//alert(hours_count);

	if(hours_count!='' && hours_count>0){
		var diff_start = start_time.replace(":", ".");
		var diff_end = end_time.replace(":", ".");
		diff=parseFloat(diff_end-diff_start);

		if(parseInt(hours_count)==parseInt(diff)){
			//alert('same');
		}else{
			//alert('not same');
			$('#edit_form_error_msg_'+id).html('Allowed time limit is '+hours_count+' hours ');
			$('#edit_form_error_msg_'+id).fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow',function(){
					$('#edit_form_error_msg_'+id).html('');
				});
			});
			return false;
		}
		
	}
	if(id!='' && id!=null){
		$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/update_timesheet',
			data:$('#time_sheet_'+id).serialize(),
			dataType:'html',
			success:function(data){
				
				if(data){
					alert('Time schedule is updated successfully');
					window.location.reload();
				}
			}
		});
	}
}


function update_time_sheetcvbcvb(id,date_id){
	
	var schedule_date = $('#time_sheet_'+id).find('input[name="schedule_date"]').val();
	
	
	var start_time=$('input[name="start_time"]').val();
		var startime_converted = convertTo24Hour(start_time);
	
	var del_zoro = startime_converted.split(":")
	if(del_zoro[0].length == 3 ){
		var newString = del_zoro[0].indexOf('0') == 0 ? startime_converted.substring(1) : startime_converted;
		startime_converted = newString;
	}
	/*micheal alert(startime_converted);
	return false;*/
	
	
	
	
	var start_time = startime_converted ;
	var end_time = $('#time_sheet_'+id).find('input[name="end_time"]').val();
	var title = $('#time_sheet_'+id).find('input[name="title"]').val();
	var description = $('#time_sheet_'+id).find('textarea[name="description"]').val();
	
	//
	if(schedule_date=='' || startime_converted=='' || end_time=='' || title=='' || description==''){
		
		$('#edit_form_error_msg_'+id).html('Please fill all mandatory fields');
		$('#edit_form_error_msg_'+id).fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow',function(){
				$('#edit_form_error_msg_'+id).html('');
			});
		});
		return false;
	}
	hours_count=$('#schedule_hours_'+date_id).val();
	//alert(hours_count);

	if(hours_count!='' && hours_count>0){
		var diff_start = start_time.replace(":", ".");
		var diff_end = end_time.replace(":", ".");
		diff=parseFloat(diff_end-diff_start);

		if(parseInt(hours_count)==parseInt(diff)){
			//alert('same');
		}else{
			//alert('not same');
			$('#edit_form_error_msg_'+id).html('Allowed time limit is '+hours_count+' hours ');
			$('#edit_form_error_msg_'+id).fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow',function(){
					$('#edit_form_error_msg_'+id).html('');
				});
			});
			return false;
		}
		
	}
	if(id!='' && id!=null){
		$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>admin/experience/update_timesheet',
			data:$('#time_sheet_'+id).serialize(),
			dataType:'html',
			success:function(data){
				if(data){
					alert('Time schedule is updated successfully');
					window.location.reload();
				}
			}
		});
	}
}


function assign_to_time_hour_edit(id,date_id){
	hours_count=$('#schedule_hours_'+date_id).val();
	var start_time = $('#time_sheet_'+id).find('input[name="start_time"]').val();
	var end_time = $('#time_sheet_'+id).find('input[name="end_time"]').val();
	if(hours_count!='' && hours_count>0){
		
		$('#time_sheet_'+id).find('input[name="end_time"]').prop('readonly', true);
		
		if(start_time==''){
			$('#time_sheet_'+id).find('input[name="end_time"]').val('');
			$('#new_form_error_msg_'+date_id).html('Please choose start time ');
			$('#new_form_error_msg_'+date_id).fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow',function(){
					$('#new_form_error_msg_'+date_id).html('');
				});
			});
			return false;
		}
		
		
		//alert(start_time);
		
		
		var startime_converted = convertTo24Hour(start_time);

		var del_zoro = startime_converted.split(":")
		
		if(del_zoro[0].length == 3 ){
			var newString = del_zoro[0].indexOf('0') == 0 ? startime_converted.substring(1) : startime_converted;
			startime_converted = newString;
		}

		//alert(startime_converted);
		
		

		
    	var timeElements = startime_converted.split(":");    
	    var theHour = parseInt(timeElements[0]);
	    var theMintute = timeElements[1];
	    var newHour = theHour + parseInt(hours_count);
	    
	    // alert(startime_converted);
	    var dis_txt;


	    if(newHour.toString().length == 1){
	    	dis_txt = "0" + newHour + ":" + theMintute;
	    }
	    else if(newHour.toString().length == 2){
	    	dis_txt = newHour + ":" + theMintute;
	    }


	    var objectToString = tConv24(dis_txt);

	    /*alert(objectToString);


	    alert(dis_txt);*/

	    $("input[name='end_time1']").val(objectToString);



		/*var start_time = start_time.replace(":", ".");
		end_val=(parseFloat(start_time)+parseFloat(hours_count)).toFixed(2);

		

		end_val=('0' + end_val).slice(-5);*/

		end_val = dis_txt;
		
		
		total_hours=(parseFloat(24)-parseFloat(hours_count));

		if(parseInt(end_val)<24){
			//end_val=end_val.replace(".", ":");
			$('#time_sheet_'+id).find('input[name="end_time"]').val(end_val);
		}else{
			$('#time_sheet_'+id).find('input[name="end_time"]').val('');
			
			$('#edit_form_error_msg_'+id).html('Allowed time limit is '+hours_count+' hours. Please change the start time ');
			$('#edit_form_error_msg_'+id).fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow',function(){
					$('#edit_form_error_msg_'+id).html('');
				});
			});
			return false;
		}

	}
	
}

function tConv24(time24) {
  var ts = time24;
  var H = +ts.substr(0, 2);
  var h = (H % 12) || 12;
  h = (h < 10)?("0"+h):h;  // leading 0 at the left for 1 digit hours
  var ampm = H < 12 ? " am" : " pm";
  ts = h + ts.substr(2, 3) + ampm;
  return ts;
}


function assign_to_time_hour(date_id,tim=''){
	
	hours_count=$('#schedule_hours_'+date_id).val();
		if(hours_count!='' && hours_count!=null && hours_count>0){
		var start_time = $('#star_time_'+date_id).val();
		//var start_time = $('#time_sheet_'+id).find('input[name="start_time"]').val();
		if(start_time==''){
			$('#end_time_'+date_id).val('');
			$('#new_form_error_msg_'+date_id).html('Please choose start time ');
			$('#new_form_error_msg_'+date_id).fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow',function(){
					$('#new_form_error_msg_'+date_id).html('');
				});
			});
			return false;
		}
		var startime_converted = convertTo24Hour(start_time);
		
		var del_zoro = startime_converted.split(":")
				if(del_zoro[0].length == 3 ){
			var newString = del_zoro[0].indexOf('0') == 0 ? startime_converted.substring(1) : startime_converted;
			startime_converted = newString;
		}
		var timeElements = startime_converted.split(":");    
	    var theHour = parseInt(timeElements[0]);
	    var theMintute = timeElements[1];
	    var newHour = theHour + parseInt(hours_count);
	    	if(newHour.toString().length == 1){
	    	dis_txt = "0" + newHour + ":" + theMintute;
	    }
	    else if(newHour.toString().length == 2){
	    	dis_txt = newHour + ":" + theMintute;
	    }
		 var objectToString = tConv24(dis_txt);
		  $("input[name='end_time1']").val(objectToString);
		
		end_val = dis_txt;
		end_val=('0' + end_val).slice(-5);

		end_val = dis_txt;
		total_hours=(parseFloat(24)-parseFloat(hours_count));
		
		if(parseInt(end_val)<24){
			//end_val=end_val.replace(".", ":");
			$('#end_time_'+date_id).val(end_val);
		}else{
			$('#end_time_'+date_id).val('');
			$('#new_form_error_msg_'+date_id).html('Allowed time limit is '+hours_count+' hours. Please change the start time ');
			$('#new_form_error_msg_'+date_id).fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow',function(){
					$('#new_form_error_msg_'+date_id).html('');
				});
			});
			return false;
		}
			}
}


function remove_time_sheet(id){
	//alert(id);
	if (confirm("<?php if($this->lang->line('exp_are_you_sure_todelete') != '') { echo stripslashes($this->lang->line('exp_are_you_sure_todelete')); } else echo "Are you sure to delete this scheduled timing?"; ?>")) {
		$('#first_child_'+id).remove();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/delete_timesheet',
			data:"id="+id,
			dataType:'html',
			success:function(data){
				alert("<?php if($this->lang->line('exp_time_removed_succ') != '') { echo stripslashes($this->lang->line('exp_time_removed_succ')); } else echo "Time schedule has been removed successfully"; ?>");
				window.location.reload();
			}
		});
	}
}
function hide_child(date_id){
	
	$('.child_'+date_id).remove();
	hide_other_divs(date_id);
	//$('#next_button_div').show();
	continue_button_manage('show');
}
function cancel_time_sheet(date_id){
	all_form_reset();
	$('#child_create_'+date_id).hide();
	//$('#next_button_div').show();
	continue_button_manage('show');
}
function hide_other_divs(date_id=''){
	$('#hide_icon_'+date_id).hide();
	all_form_reset();
	if(date_id==''){
		$('[id^=child_create_]').hide();
		$('[id^=child_view_]').hide();
		
		$('[id^=grand_child_edit_]').hide();
		//$('#next_button_div').hide();
		continue_button_manage('hide');
	}else{
		$('[id^=grand_child_edit_]').hide();
		$('#child_create_'+date_id).hide();
		$('#child_view_'+date_id).hide();
		//$('#next_button_div').hide();
		continue_button_manage('hide');
	}
}

function get_new_timesheet(date_id,status,allow){
	
	$('#hide_icon_'+date_id).show();
	//$('#next_button_div').hide();
	$('.new_schedule_div').hide();
	continue_button_manage('hide');
	hide_other_divs();
	
	if(allow==0){
		$('#form_action_msg_common').html('Timings were scheduled for this date limits. Please add a new date');
		$('#form_action_msg_common').fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow',function(){
				$('#form_action_msg_common').html('');
			});
		});
		continue_button_manage('show');
		return false;
	}
	if(status==1){
		$('#form_action_msg_common').html('Please activate the scheduled date and add timings');
		$('#form_action_msg_common').fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow',function(){
				$('#form_action_msg_common').html('');
			});
		});
		
		return false;
	}
	
	if($('#child_create_'+date_id).length>0){
		$('#child_create_'+date_id).show();
		$('#child_view_'+date_id).hide();	
		return false;
	}

	$('#child_create_'+date_id).show();	
	
	$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/get_new_timesheet',
			data:"date_id="+date_id,
			dataType:'html',
			success:function(data){
				
				$('#child_create_'+date_id).remove();
				
				if ($('#child_view_'+date_id).length > 0) {
					$('#child_view_'+date_id).hide();
					$('#child_view_'+date_id).after(data);
				}else{
					$('#parent_'+date_id).after(data);
				}

				
				$('.dev_time').timepicker({
				'minTime': '12:00am',
				'maxTime': '11:00pm',
				'timeFormat': 'h:i a',
				'ampm': true,
				//'timeFormat': 'H:i',
				'step': 60,

				});
				

		$('.dev_multi_schedule_date').each(function(){	
			$(this).datepicker({

		    	changeMonth: true,
				dateFormat: 'yy-mm-dd',
				
				numberOfMonths: 1,
				minDate: new Date($('#from_date_'+date_id).val()),
				maxDate :new Date($('#to_date_'+date_id).val()),
				beforeShowDay: unavailable_add_new,
				
		    });
		});
		
		
			
			}
	});
}

function add_time_sheet(date_id){
	

	start_time=$('#star_time_'+date_id).val();
	
	var startime_converted = convertTo24Hour(start_time);
	
	var del_zoro = startime_converted.split(":")
	
	if(del_zoro[0].length == 3 ){
		var newString = del_zoro[0].indexOf('0') == 0 ? startime_converted.substring(1) : startime_converted;
		startime_converted = newString;
	}
	
	end_time=$('#end_time_'+date_id).val();
	
	schedule_date=$('#schedule_date_'+date_id).val();
	
	title=$('#title_'+date_id).val();
	description=$('#description_'+date_id).val();
	//$('#next_button_div').hide();
	continue_button_manage('hide');
	
if(startime_converted=='' || end_time=='' || schedule_date=='' || title=='' || description==''){
	
	//alert('Please fill all fields and proceed');
	$('#new_form_error_msg_'+date_id).html('Please fill all mandatory fields');
	$('#new_form_error_msg_'+date_id).fadeIn('slow', function () {
		$(this).delay(1000).fadeOut('slow',function(){
			$('#new_form_error_msg_'+date_id).html('');
		});
	});
	
	return false;
}
	
	hours_count=$('#schedule_hours_'+date_id).val();
	//alert(hours_count);
	
	//var s_time = $('#new_time_sheet_'+date_id).find('input[name="start_time"]').val();
	var s_time = startime_converted;
	
	var e_time = $('#new_time_sheet_'+date_id).find('input[name="end_time"]').val();
	
	
	
	if(hours_count!='' && hours_count>0){
		var diff_start = s_time.replace(":", ".");
		var diff_end = e_time.replace(":", ".");
		
		
		diff=parseFloat(diff_end-diff_start);
		
		
	
		

		if(parseInt(hours_count)==parseInt(diff)){
			//alert('same');
		}else{
			//alert('not same');
			$('#new_form_error_msg_'+date_id).html('Allowed time limit is '+hours_count+' hours ');
			$('#new_form_error_msg_'+date_id).fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow',function(){
					$('#new_form_error_msg_'+date_id).html('');
				});
			});
			return false;
		}
		
	}
	$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/add_timesheet',
			data:$('#new_time_sheet_'+date_id).serialize(),
			dataType:'html',
			success:function(data){
								if(data){
					alert('Time schedule has been added successfully');
					//$('#next_button_div').hide();
					continue_button_manage('hide');
					window.location.reload();
				}
			}
	});
	
}

function view_timesheet(date_id){
	
	$('#hide_icon_'+date_id).show();
	hide_other_divs();
	$('.new_schedule_div').hide();
	if ($('#child_view_'+date_id).length > 0) {
		$('#child_view_'+date_id).show();	
	}
	$('#child_view_'+date_id).show();
	
	if ($('.child_'+date_id).length > 0) {
		///$('.child_'+date_id).remove();
		return false;
	}
	
	if(date_id!='' && date_id!=null){
		$.ajax({
		type:'POST',
		url:'<?php echo base_url()?>site/experience/get_timesheets',
		data:"date_id="+date_id,
		dataType:'html',
		success:function(data){
			//alert(data);
			//$(data).insertAfter('#parent_'+date_id);
			$('#parent_'+date_id).after(data);
			//$('#child_'+date_id).html(data);
			$('.dev_time').timepicker({
			'minTime': '12:00am',
			'maxTime': '11:59pm',
			'timeFormat': 'hh:mm:ss tt',
			'ampm': true,
			//'timeFormat': 'H:i',
			'step': 60,

			});

		}
		});
	}
}



function view_timesheet_forStatus(date_id,status){
	$('#hide_icon_'+date_id).show();
	hide_other_divs();
	$('.new_schedule_div').hide();
	if ($('#child_view_'+date_id).length > 0) {
		$('#child_view_'+date_id).show();	
	}
	$('#child_view_'+date_id).show();
	
	if ($('.child_'+date_id).length > 0) {
		///$('.child_'+date_id).remove();
		return false;
	}
	
	if(date_id!='' && date_id!=null){
		$.ajax({
		type:'POST',
		url:'<?php echo base_url()?>site/experience/get_timesheets_forStatus',
		data:"date_id="+date_id+"&status_is="+status,
		//data:"date_id="+date_id,"status_is="+status,
		dataType:'html',
		success:function(data){
			//alert(data);
			//$(data).insertAfter('#parent_'+date_id);
			$('#parent_'+date_id).after(data);
			//$('#child_'+date_id).html(data);
			$('.dev_time').timepicker({
			//'minTime': '12:00am',
			//'maxTime': '11:59pm',
			'timeFormat': 'H:i a',
			
			//'timeFormat': 'H:i',
			'step': 60,

			});

		}
		});
	}
} 




function unavailable_add_new(date){
	
	dateAr=[] ;
		$('.scheduled_date_exists').each(function(){
		//alert($(this).val());
		dateAr.push($(this).val());
	});
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
    return [dateAr.indexOf(string) == -1];
	
}
 function unavailable_new(date) {
		dateAr=[] ;
		$('.dev_multi_schedule_date_new').each(function(){
		//alert($(this).val());
		dateAr.push($(this).val());
		
	   
	});
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
    return [dateAr.indexOf(string) == -1];
}
function cancel_dates_form(){
	$('.new_schedule_div').hide();
	//$('#next_button_div').show();
	continue_button_manage('show');
}

</script>
				
<hr>
				
			
                <?php  //echo ($timing==0) ? 'class="disabled_exp"' : ''; ?>
				<?php

				if($timing==1){ 

				?>
			     <!-- Tour dates selection Ends  -->
					<div class="basic-next nxt_btn_ctn" id="next_button_div">
					 <button class="next_button continue" id="next-btn" type="button"><?php if($this->lang->line('Continue') != '') { echo stripslashes($this->lang->line('Continue')); } else echo "Continue";?></button>
					 </div>
					<?php 
				}else { ?>
					
					<?php if($this->lang->line('pls_fill_nxt_form') != '') { echo stripslashes($this->lang->line('pls_fill_nxt_form')); } else echo "Please fill all the details to get Next form";?>
	
				<?php }
					 ?>

                </div>
            
            </div>
            
            </div>
            
            
            <div class="calender_comments">
            
                <div class="calender_comment_content">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
                    
                    <div class="calender_comment_text">
                    
                        <h2><?php if($this->lang->line('exp_frame_schedule') != '') { echo stripslashes($this->lang->line('exp_frame_schedule')); } else echo "Frame your Schedule"; ?></h2>
                    
                        <p><?php if($this->lang->line('exp_schedule_for_newdate_new') != '') { echo stripslashes($this->lang->line('exp_schedule_for_newdate_new')); } else echo "It's all about a matter of time. Organize your experience by choosing your favorite date and time. You can plot the time schedule by simply clicking the (plus) button.  You can adjust this time later depending on the dates which you scheduled."; ?>  </p>

                        
                       <?php /* <p><strong><?php if($this->lang->line('note') != '') { echo stripslashes($this->lang->line('note')); } else echo "Note"; ?>:</strong> <?php if($this->lang->line('exp_for_dates_youhave') != '') { echo stripslashes($this->lang->line('exp_for_dates_youhave')); } else echo "For Dates you have to add time schedule, schedule title is important for identify each timing session activity. You can explain the follow for that session in description."; ?>  </p> */ ?>
                        
                    
                    </div>
                    
                    
                
                </div>
            
            </div>
            
        
        </div>
        
    </div>

<script type="text/javascript" src="js/jquery.timepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="js/jquery.timepicker.css" />
  
     
    


<script type="text/javascript">

	 function checkSpcialChar(event){
	 
		if(!((event.keyCode >= 65) && (event.keyCode <= 90) || (event.keyCode >= 97) && (event.keyCode <= 122) || (event.keyCode >= 48) && (event.keyCode <= 57))){
		   event.returnValue = false;	
		   return;
		}
		event.returnValue = true;
	 }

</script>

<script type="text/javascript">
function validate_form()
{
	var title=$("#title");
	var summary=$("#summary");
	var contents = summary.val();
	var words = contents.split(/\b\S+\b/g).length - 1;
	if(title.val()=="")
	{
		alert("<?php if($this->lang->line('err_enter_title') != '') { echo stripslashes($this->lang->line('err_enter_title')); } else echo "Please Enter Title"; ?>");
		return false;
	}
	else if(summary.val()=="")
	{
		alert("<?php if($this->lang->line('err_enter_summary') != '') { echo stripslashes($this->lang->line('err_enter_summary')); } else echo "Please Enter Summary"; ?>");
		return false;
	}
	if(words > 150)
	{
		alert("Total of "+words+"words found! Summary should not exceed 150 words!");
		return false;
	}
	
}
</script>   



<script>
 function unavailable(date) {
		dateAr=[] ;
		$('.dev_multi_schedule_date').each(function(){
		
		dateAr.push($(this).val());
		
	   
	});
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
    return [dateAr.indexOf(string) == -1];
}

function setDatepickerHere() {

	

	/*
	$('.dev_multi_schedule_date').datepicker({
		changeMonth: true,
		dateFormat: 'yy-mm-dd',
		numberOfMonths: 1,
		minDate:0
	});
	*/
	// $('.dev_multi_schedule_date').each(function(){
	// 	    $(this).datepicker({
	// 	    	changeMonth: true,
	// 			dateFormat: 'yy-mm-dd',
	// 			numberOfMonths: 1,
	// 			minDate: new Date($('#datetimepicker1').val()),
	// 			maxDate :new Date($('#to_date').val()),
	// 	    });
	// 	});
		$('.dev_multi_schedule_date').each(function(){
			
			
		    $(this).datepicker({

		    	changeMonth: true,
				dateFormat: 'yy-mm-dd',
				
				numberOfMonths: 1,
				minDate: new Date($('#datetimepicker1').val()),
				maxDate :new Date($('#to_date').val()),
				beforeShowDay: unavailable,
				
		    });
		});

	
}





	function datepick() {
		//datepicker
		// alert("aa");

		$('.dev_tour_date').datepicker({
		changeMonth: true,
		dateFormat: 'yy-mm-dd',
		numberOfMonths: 1,
		minDate:1,
	    onSelect: function(selected) {
	    	//alert(selected);
	    	//var selectedDate = new Date(selected);
	        /*var tomorrow = new Date();
	        date_count = Number(<?php echo $listDetail->row()->date_count; ?>);
			selectedDate.setDate(selectedDate.getDate() + date_count);
	        //var endDate = selected;
	       // alert(selectedDate.getDate() );
	      	$("#to_date").val(selectedDate);

	      	*/

	      	date_count = Number(<?php echo $listDetail->row()->date_count; ?>);
			

	      	if(date_count==1){
	      		$(".dev_schedule_date").val(selected);
	      	}

	      	$.ajax({
				type:'POST',
				url:'<?php echo base_url()?>site/experience/todateCalculate',
				data:{from_date:selected,date_count:date_count},
				success:function(response)
				{
					
					$("#to_date").val(response.trim());
					//window.location.reload(true);

				}
			});

	    }
	});
		
	
}




//Timepicker
$('.dev_time').timepicker({
			
		'minTime': '12:00am',
		'maxTime': '11:59pm',
		'timeFormat': 'H:i a',
		
		'step': 30,

		});





//Add new Date
function add_dates(){

//alert("addNEwDate");
//save_timing();
//return false;

	var from_date 		= $("#datetimepicker1").val();
	var to_date 		= $("#to_date").val();
	var price 			= $("#price").val();
	var experience_id 	= $("#experience_id").val();
	var dev_exp_currency= $("#dev_exp_currency").val();

	/*
	alert(from_date);
	alert(to_date);
	alert(price);
	alert(experience_id);
	alert(dev_exp_currency);
	
	return false;
	
	*/
	
	if(from_date!='' && to_date!='' && price!='' && dev_exp_currency!='' ){
		
		$.ajax({
		type:'POST',
		url:'<?php echo base_url()?>site/experience/saveDates',
		data:{from_date:from_date,to_date:to_date,price:price,experience_id:experience_id,currency:dev_exp_currency},
		dataType:'json',
		success:function(data)
		{
			if(data.case == 1){
			 	//$("div.added").fadeIn(300).delay(1500).fadeOut(400);
			 	//$("#package_table").load(location.href + " #package_table");
			 	
			 	$('#dates_id').val(data.date_id);
			 	$('#add_btn').css('display','none');
			 	
				
				
				/*$('#dev_add_date_timing').css('display','block');
			 	$('#save_timing_btn').css('display','block');
				*/

			 	setDatepickerHere();//set datepicker
				//alert('Date has been added Successfully');
				$('#form_action_msg_common').html('Sheduled date has been added Successfully');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow',function(){
								$('#form_action_msg_common').html('');
							});
						});
				window.location.reload();
				
			 	//save_timing();
			 	
			 }else if(data.case == 2){
			 	//$("div.updated").fadeIn(300).delay(1500).fadeOut(400);
			 	//$("#package_table").load(location.href + " #package_table");

			 	
			 	window.location.reload();
			 }
			 else if(data.case == 3){
			 	//alert('Sheduled date exists Already..! ');
				$('#form_action_msg_common').html('Sheduled date exists Already..! ');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow',function(){
								$('#form_action_msg_common').html('');
							});
						});
			 }
			  else if(data.case == 4){
			 	alert('Not Valid Times');
			 	$('#datetimepicker1').val('');
			 	$('#to_date').val('');
			 }
		}
		});
	}
	else{
		if( price!='' || dev_exp_currency!='' ){
			//alert('Please Choose From Date.');
			//alert('Please fill price/currency in Basic Details .');
			$('#form_action_msg_common').html('Please Choose Scheduled Date');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow',function(){
								$('#form_action_msg_common').html('');
							});
						});
		}
		else{
		//alert('Please fill all data');
		$('#form_action_msg_common').html('Please fill all data');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow',function(){
								$('#form_action_msg_common').html('');
							});
						});
		}
	}
}

function convertTo24Hour(time) {
	
	
    var hours = parseInt(time.substr(0, 2));
    
    if(time.indexOf('am') != -1 && hours == 12) {
        time = time.replace('12', '0');
        
    }
    if(time.indexOf('pm')  != -1 && hours < 12) {
        time = time.replace(hours, (hours + 12));

    }
	
	
    return time.replace(/(am|pm)/, '');
    
}

/* add timing of new dates */
function add_timing_row(rowID) {
	date_count = Number(<?php echo $listDetail->row()->date_count; ?>);
	from_date = $('#datetimepicker1').val();
	$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/add_timing_row',
			data:{rowID:rowID,date_count:date_count,from_date:from_date},
			success:function(response)
			{
				$("#add_timing_btn_"+rowID).css('display','none');
				$("#dev_new_timing"+rowID).addClass("popup-panel-exp");
				$("#dev_new_timing"+rowID).html(response);



				//window.location.reload(true);
				//add timepicker
				$('.dev_time').timepicker({
				'minTime': '12:00am',
				'maxTime': '11:59pm',
				'timeFormat': 'H:i a',
				'step': 60,
				});

				setDatepickerHere();//add datepicker to edit rows	

			} 
		});
}

/* add timing of new dates  ends*/
function add_scheduled_date(){
	schedule_date 	= $("input[name='schedule_date[]']").map(function(){return $(this).val();}).get();
	experience_id 	= $('#experience_id').val();
	$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/add_timing_row',
			data:{schedule_date:schedule_date,experience_id:experience_id},
			success:function(response){

			}
		});
	
}

/* save timing starts */
function save_timing() {

	experience_id 	= $('#experience_id').val();
	dates_id 		= $('#dates_id').val();
	start_time 		= $("input[name='start_time[]']").map(function(){return $(this).val();}).get();
	end_time 		= $("input[name='end_time[]']").map(function(){return $(this).val();}).get();
	schedule_date 	= $("input[name='schedule_date[]']").map(function(){return $(this).val();}).get();

	schedule_title 			= $("input[name='schedule_title[]']").map(function(){return $(this).val();}).get();
	schedule_description 	= $("textarea[name='schedule_description[]']").map(function(){return $(this).val();}).get();

	error =  error_in_mandatory = error_schd_date = error_time = 0;
	wrongTimingID = [];
	
   //alert(schedule_date); 
   
   	for(i=0;i<schedule_date.length;i++){
		if(schedule_date[i]=='0000-00-00' || schedule_date[i]=='' )
			error_schd_date +=1; 
	}

    for (i=0;i<start_time.length;i++) {
    	if(schedule_title[i]=='')
    	{	error =error+1;}
    	if(start_time[i]=='' || end_time[i]=='' || schedule_date[i]==''){
    		error_in_mandatory = error_in_mandatory+1;
    	}
    	//alert(start_time[i]>end_time[i]);
    	if(start_time[i]>end_time[i]){
    		error_time = error_time+1;
    		wrongTimingID.push(i+1);
    	}
    }
	
    if(error==0 && error_in_mandatory==0 && error_time==0 && error_schd_date==0)
    {
	   $.ajax({
				type:'POST',
				url:'<?php echo base_url()?>site/experience/save_date_schedule_timing',
				data:{experience_id:experience_id,dates_id:dates_id,start_time:start_time,end_time:end_time,schedule_date:schedule_date,schedule_title:schedule_title,schedule_description:schedule_description},
				dataType:'json',
				success:function(data)
				{
					//alert(response);
					//window.location.reload(true);
					
					//$("#experience_id").val(response);
					
					if(data.case == 1){
					alert("<?php if($this->lang->line('exp_invalid_schedule_periods') != '') { echo stripslashes($this->lang->line('exp_invalid_schedule_periods')); } else echo "Invalid Schedule Periods."; ?>");
					window.location.reload();
					}else if (data.case==2){
					alert("<?php if($this->lang->line('exp_schedule_period_saved') != '') { echo stripslashes($this->lang->line('exp_schedule_period_saved')); } else echo "Schedule Period saved successfully."; ?>");
					window.location.reload();
					}
					
					
					
				}
			});   
     }else{
     	if(error_schd_date>0){
     		alert("<?php if($this->lang->line('exp_schedule_date_req') != '') { echo stripslashes($this->lang->line('exp_schedule_date_req')); } else echo "schedule date required."; ?>");
     	}
     	if(error>0){
	     	alert("<?php if($this->lang->line('exp_title_req') != '') { echo stripslashes($this->lang->line('exp_title_req')); } else echo "title is required"; ?>");
	    }
	    else if(error_in_mandatory>0){
	    	alert("<?php if($this->lang->line('exp_fill_all') != '') { echo stripslashes($this->lang->line('exp_fill_all')); } else echo "Please fill all fields"; ?>");
	    }else if(error_time>=0){ alert('Start time should be less than end time in following schedules: '+ wrongTimingID);}
     }
}

/* save timing ends */

/* delete timing row */
function delete_timing_row(row_id) {
	var r = confirm("Are you sure,Do you want to delete this schedule?");
    if (r == true) {
	$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/delete_timing_row',
			data:{row_id :row_id},
			success:function(response)
			{
				//alert(response);
				window.location.reload(true);
				

			}
		}); 
	} else {
        
    }  
}

function hide_edit(date_id){
	$('#dev_add_date_timing_'+date_id).hide();
}
/* edit existing dates  starts */
function get_activity_data(exp_id ,date_id,start_date,end_date,price) {
	
	$('#dates_id').val(date_id);
	$('#datetimepicker1').val(start_date);
	$('#to_date').val(end_date);
	$('#price').val(price);
	
	
	//$('#child_price').val(child_price);
	
	$('#add_btn').hide();


 	$('#dev_add_date_timing').css('display','block');
 	$('#save_timing_btn').css('display','none');
	//$('#save_timing_btn').css('display','block');

 	$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/get_timing',
			data:{experience_id:exp_id,date_id:date_id},
			success:function(response)
			{
				$('#dev_add_date_timing_'+date_id).show();
				$('#dev_add_date_timing_'+date_id).html(response);
				$('.dev_time').timepicker({
				'minTime': '12:00am',
				'maxTime': '11:59pm',
				'timeFormat': 'H:i a',
				'step': 60,
				});
				setDatepickerHere();//add datepicker to edit rows	
			}
		});


	$('#update_btn').show();
	$('#reset_btn').show();

}
function update_timing(timing_id){
	
}
function update_tab2()
{
	var date_id 		= $('#dates_id').val();
	var from_date		= $('#datetimepicker1').val();
	var to_date 		= $('#to_date').val();
	var price 			= $('#price').val();
	var experience_id 	= $('#experience_id').val();
	var dev_exp_currency= $("#dev_exp_currency").val();
	
	
	
	//alert(dev_exp_currency);
	//return false;
	
	if(from_date != '' && to_date != ''  && (from_date)){


		$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>site/experience/updateDates',
			data:{date_id:date_id,from_date:from_date,to_date:to_date,price:price,experience_id:experience_id,currency:dev_exp_currency},
			dataType:'json',
			success:function(data)
			{
				if(data.case == 1){


				 	experience_id 	= $('#experience_id').val();
					dates_id 		= $('#dates_id').val();
					start_time 		= $("input[name='start_time[]']").map(function(){return $(this).val();}).get();
					end_time 		= $("input[name='end_time[]']").map(function(){return $(this).val();}).get();
					schedule_date 	= $("input[name='schedule_date[]']").map(function(){return $(this).val();}).get();

					schedule_title 			= $("input[name='schedule_title[]']").map(function(){return $(this).val();}).get();
					schedule_description 	= $("textarea[name='schedule_description[]']").map(function(){return $(this).val();}).get();
					error =  error_in_mandatory = error_time = error_schd_date = 0;
					wrongTimingID = [];
				    //alert(schedule_date); 
				    for(i=0;i<schedule_date.length;i++){
				    	if(schedule_date[i]=='0000-00-00' || schedule_date[i]=='' )
				    		error_schd_date +=1; 
				    }
				    for (i=0;i<start_time.length;i++) {
				    	if(schedule_title[i]=='' )
				    	{	error =error+1;}
				    	if(start_time[i]=='' || end_time[i]=='' || schedule_date[i]==''){
				    		error_in_mandatory = error_in_mandatory+1;
				    	}
				    	//alert(start_time[i]>end_time[i]);
				    	if(start_time[i]>end_time[i]){
				    		error_time = error_time+1;
				    		wrongTimingID.push(i+1);
				    	}
				    }
				    if(error==0 && error_in_mandatory==0 && error_time==0 && error_schd_date==0)
				    {
					   $.ajax({
								type:'POST',
								url:'<?php echo base_url()?>site/experience/save_date_schedule_timing',
								data:{experience_id:experience_id,dates_id:dates_id,start_time:start_time,end_time:end_time,schedule_date:schedule_date,schedule_title:schedule_title,schedule_description:schedule_description},
								success:function(response)
								{
									//alert(response);
									save_timing(); // save timings
									window.location.reload(true);
									

								}
							});   
				     }else{ 
					 
						$('#form_action_msg_common').html('Sheduled date exists Already..!');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow',function(){
								$('#form_action_msg_common').html('');
							});
						});
					
				     	if(error_schd_date>0){
				     		alert("<?php if($this->lang->line('exp_schedule_date_req') != '') { echo stripslashes($this->lang->line('exp_schedule_date_req')); } else echo "schedule date required."; ?>");
				     	}
				     	if(error>0){
					     	alert("<?php if($this->lang->line('exp_title_req') != '') { echo stripslashes($this->lang->line('exp_title_req')); } else echo "title is required"; ?>");
					    }
					    else if(error_in_mandatory>0){
					    	alert("<?php if($this->lang->line('exp_fill_all') != '') { echo stripslashes($this->lang->line('exp_fill_all')); } else echo "Please fill all fields"; ?>");
					    }else if(error_time>=0){ alert('Start time should be less than end time in following schedules: '+ wrongTimingID);}
				     }
				 	
				 	
				 	//window.location.reload();
				 }
				 else if(data.case == 2){
				 	//$("div.updated").fadeIn(300).delay(1500).fadeOut(400);
				 	//$("#package_table").load(location.href + " #package_table");



				 	window.location.reload();
				 }
				 else if(data.case == 3){
				 	//alert('Sheduled date exists Already..!');
					$('#form_action_msg_common').html('Sheduled date exists Already..!');
					$('#form_action_msg_common').fadeIn('slow', function () {
						$(this).delay(1000).fadeOut('slow',function(){
							$('#form_action_msg_common').html('');
						});
					});
				 }
				  else if(data.case == 4){
				 	//alert('Not Valid Times');
					
					$('#form_action_msg_common').html('Not Valid Times');
					$('#form_action_msg_common').fadeIn('slow', function () {
						$(this).delay(1000).fadeOut('slow',function(){
							$('#form_action_msg_common').html('');
						});
					});
						
				 	$('#datetimepicker1').val('');
				 	$('#to_date').val('');
				 }
			}
			});	
	}

	else{
			alert("<?php if($this->lang->line('exp_fill_all') != '') { echo stripslashes($this->lang->line('exp_fill_all')); } else echo "Please fill all fields"; ?>");
	}

}

function reset_reload(){
window.location.reload();
}
/* edit existing dates  ends */

function Detailview(catID,title,chk)
{
	$.ajax({
	type:'POST',
	url:'<?php echo base_url()?>site/product/saveDetailPage',
	data:{catID:catID,title:title,chk:chk},
	success:function(response)
	{
		window.location.reload(true);
	}
	})
}
function return_false_fun(e){
	return false;
}
</script>	

<script type="text/javascript">
	$(document).ready(function () {
		datepick();
		//setDatepickerHere();
	});
</script>

<script type="text/javascript">
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>

<style>
.content{
height:44px !important;
}
</style>

<script>
$(document).ready(function(){
    $(document).on("click",".btn1", function(){
    	$(this).parent().parent().parent().removeClass("popup-panel-exp");
    	$(this).parent().parent(".removeBlock").remove();
    });
    
   
});

$(document).ready(function() {
    $('#next-btn').click(function(e) {
		has=$(this).hasClass("disabled_exp");
		if(has==false){
			window.location.href = '<?php echo base_url()."tagline_experience/".$id; ?>';
		}
    }); 
	$('#add_new').click(function(e) {  
		hide_other_divs();
		$('.new_schedule_div').show();
		
    });
});
</script>

<?php $this->load->view('site/templates/footer'); ?>>>>>>>>