<?php
$this->load->view('admin/templates/header.php');
/* var_dump($details->result());die; */
?>
	
		<div id="content">		
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add Child Values</h6>
                        
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addattribute_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/listings/add_submit_new_child_fields',$attributes) 
					?>
					
                    
						<ul>
	 						<input type="hidden" name="parent_id" value="<?php echo $this->uri->segment(4);?>">	

	 						<input type="hidden" id="child_id" value="">
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="attribute_name">Child Value <span class="req">*</span></label>
							<div class="form_input">
							
							
								<input name="child_value" id="child_name" type="text" tabindex="1" class="required large tipTop" title="Please enter the child name" value="" required="required" /><span id="child_name_valid" style="color:#f00;display:none;"> Charecters and Numbers only!</span>
								
		
							</div>
							</div>
							</li>
							<li style="display: none;">
							<div class="form_grid_12">
							<label class="field_title" for="attribute_name">Child Value(Arabic) <span class="req">*</span></label>
							<div class="form_input">
							
							
								<input name="child_value_arabic" id="child_name_arabic" type="text" tabindex="1" class="required large tipTop" title="Please enter the list name" value="none" required="required"/>
								
		
							</div>
							</div>
							</li>
							<input type="hidden" name="id" value="">


								<li> 
								
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" id="add_btn" class="btn_small btn_blue" tabindex="9"><span>Submit</span></button>
										<input type="button" class="btn_small btn_blue" id="update_btn" style="display: none;" name="" value="Update" onclick="javascript:child_data_Update();">
										<a href="admin/listings/listing_child_values" ><button class="btn_small btn_blue" type="button">Back</button></a>
									</div>

								</div>
								</li>
							</ul>
                    
						</form>
					</div>

					     	<div id="season_table">
            	<table class="display display_tbl" id="subadmin_tbl">
						<thead>
							<tr>
								
								<th class="tip_top" title="Click to sort">
									 List Name
								</th>
								<th class="tip_top" title="Click to sort">
									 Child Values
								</th>
								
															
								
								<th class="tip_top" title="Click to sort">
									ACTION

								</th>
								
							</tr>
						</thead>
						<tbody>
						<?php 
						// print_r($listchildvalues->result());
						// exit();
						if ($listchildvalues->num_rows() > 0){
							$i = 1;
							foreach ($listchildvalues->result() as $row){
							
								
								
						

						?>
						<tr>
							
							<td class="center">
								<?php echo ucfirst($row->labelname);?>
							</td>
							<td class="center">
						 		
								 <?php echo $row->child_name;?>
								
							</td>
							

							
							<td class="center">
							<?php if ($allPrev == '1' || in_array('2', $Properties)){?>
								<span>
								
								<span class="action-icons c-edit" onclick="javascript:get_child_data('<?php echo $row->child_id;?>','<?php echo $row->child_name; ?>', '<?php echo $row->child_name_arabic; ?>');" title="Edit"><?php if($this->lang->line('back_Edit') != '') { echo stripslashes($this->lang->line('back_Edit')); } else echo "Edit"; ?></span>
								</span>
								 <span><a class="action-icons c-delete" href="admin/listings/delete_child_list_value/<?php echo $row->child_id;?>/<?php echo $this->uri->segment(4);?>" title="Delete">Delete</a></span>
                               <!--  <span><a class="action-icons c-delete" onclick="javascript:delete_season_data('<?php //echo $row->season_id;?>','<?php //echo $row->product_id;?>','<?php //echo $row->date_from; ?>','<?php //echo $row->date_to; ?>');" title="Delete">Delete</a></span> -->
                                
                             
                                
							<?php }?>
								
                                
														
							</td>
							

						
						</tr>
						<?php 
						$i++;	
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="tip_top" title="Click to sort">
									 List Name
								</th>
								<th class="tip_top" title="Click to sort">
									 Child Values
								</th>
								
															
								
								<th class="tip_top" title="Click to sort">
									ACTION

								</th>
						</tr>
						</tfoot>
						</table>
						</div>
				</div>
				
			</div>
		</div>
		</div>
		
		<span class="clear"></span>
	
</div>
<script>
$(".active_inactive").on("click", function (e) {
    var checkbox = $(this);
    if (checkbox.is(":checked") {
        // do the confirmation thing here
        e.preventDefault();
        return false;
    }
});
</script>
<script type="text/javascript">
	function get_child_data(child_id,child_name,child_name_arabic) {
	
	$('#child_id').val(child_id);
	$('#child_name').val(child_name);
	$('#child_name_arabic').val(child_name_arabic);
	
	
	$('#add_btn').hide();
	$('#update_btn').show();
	

	//alert(season_id);
   //  $.ajax({
   //      type: "POST",
   //      url: baseURL+'admin/product/show_customers',
   //      data:{'season_id':season_id},

   //      success: function(data) {
			// $('#season_name').val(season_name);
   //      	//alert(data[0]);
   //      	var res = $.parseJSON(data);
   //      	//alert(res.season_id);
			
   //      	//var user_cal_amount = user_coupon_amount.season_name;
   //      	//alert(user_cal_amount);
   //      	//obj = JSON.parse(data);
   //     //alert(data);
   //     //console.log(obj.season_name);
   //          //$("#customers-list").html(data);

   //          //$("#season_name").value(data[0]['season_name']);
            

   //      }
   //  });
}
</script>
<script type="text/javascript">
function child_data_Update()
  {

	//alert("Welcome"+evt.value);
	var child_id = document.getElementById('child_id').value;
	var child_name = document.getElementById('child_name').value;
	var child_name_arabic = document.getElementById('child_name_arabic').value;
	

	// alert(date_from);
	// alert(title+catID);
	


	

		$.ajax({

			type:'post',

			url:baseURL+'admin/listings/update_child_data',

			data:{'child_id':child_id,'child_name':child_name,'child_name_arabic':child_name_arabic},

			dataType:'json',

			success:function(json){

				
				alert('Updated Successfully');
				
				// $('#prdiii').val(json.resultval);

				// $('#imgmsg_'+catID).hide();

				// $('#imgmsg_'+catID).show().text('Done').delay(800).text('');

				//window.location.href = "admin/product/edit_product_form/"+json.resultval;

				//alert(json.resultval);

				// window.location.hash=json.resultval;
				// $("#season_table").load(location.href + " #season_table");
				
				

			}

		});

		window.location.reload();
}

</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>
<script>
$("#child_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-z0-9\s]/g)) {
	   document.getElementById("child_name_valid").style.display = "inline";
	   $("#child_name").focus();
	   $("#child_name_valid").fadeOut(5000);
       $(this).val(val.replace(/[^0-9\s]/g, ''));
   }
});
</script>