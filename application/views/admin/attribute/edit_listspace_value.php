<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add List Space Value</h6>
                        
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addlistvalue_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/listattribute/insertEditListSpaceValue',$attributes) 
					?>
                    
						<ul>
	 							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="list_name">Select List<span class="req">*</span></label>
							<div class="form_input">
		                      <select class="chzn-select required" name="list_name" id="list_name" tabindex="-1" style="width: 375px; display: none;" data-placeholder="Select List">
		                      		<option value="">--Select--</option>
		                      		<?php 
		                      		foreach ($list_details->result() as $row){
		                      			if ($row->attribute_name!=''){
		                      		?>
		                      		<option <?php if ($list_value_details->row()->listspace_id == $row->id){echo 'selected="selected"';}?> value="<?php echo $row->id;?>">
										<?php echo $row->attribute_name;?>
									</option>
		                      		<?php }}?>
		                      </select>
		                    </div>
							</div>
							</li>
	 							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="list_value">List Value<span class="req">*</span></label>
							<div class="form_input">
								<input name="list_value" value="<?php echo $list_value_details->row()->list_value;?>" id="list_value" type="text" tabindex="1" class="required large tipTop" title="Please enter the list space value"/><span id="list_value_valid" style="color:#f00;display:none;"> Only Characters are allowed!</span>
							</div>
							</div>
							</li>
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="list_description">List Description<span class="req">*</span></label>
							<div class="form_input">
								<input name="list_description" value="<?php echo $list_value_details->row()->list_description;?>" id="list_description" type="text" tabindex="2" class="required large tipTop" title="Please enter the list space value description"/>
							</div>
							</div>
							</li>
							
							
							<?php if($list_value_details->row()->image!='') { ?>
							
								<li>
							<div class="form_grid_12 ">
								<label class="field_title" for="image">List Icon <span class="req">*</span> <span class="req"> Below 35*40 (H*W) </span></label>
								<div class="form_input">
									<input name="image" id="image" type="file" tabindex="7" class="large tipTop" title="Please select image"/>
								</div>
								<div class="form_input">
									<img src="<?php if($list_value_details->row()->image==''){ echo base_url().'images/attribute/default-list-img.png';}else{ echo base_url();?>images/attribute/<?php echo $list_value_details->row()->image;}?>" width="100px"/>
								</div>
							</div>
							</li>
							
							
							<?php } else { ?>
								<li>
							<div class="form_grid_12 form_chsfile">
								<label class="field_title" for="image">List Icon  <span class="req">*</span> <span class="req"> Below 35*40 (H*W)  </span></label>
								<div class="form_input">
									<input name="image" id="image"   type="file" tabindex="7" class=" required large tipTop" title="Please select image"/>
								</div>
								<div class="form_input">
									<img src="<?php if($list_value_details->row()->image==''){ echo base_url().'images/attribute/default-list-img.png';}else{ echo base_url();?>images/attribute/<?php echo $list_value_details->row()->image;}?>" width="100px"/>
								</div>
							</div>
							</li>
							
							
							<?php } ?>
							
							
						
						
                        	
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="2"><span>Update</span></button>
										<a href='<?php echo base_url().'admin//listattribute/display_listspace_values';?>'>
											<button type="button" class="btn_small btn_blue " tabindex="9"><span>Back</span></button>
										</a>
									</div>
								</div>
								</li>
							</ul>
                    <input type="hidden" name="lvID" value="<?php echo $list_value_details->row()->id;?>"/>
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<script>
$('#addlistvalue_form').validate();
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>
<script>
/* $("#list_value").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z-,\s]/g)) {
	   document.getElementById("list_value_valid").style.display = "inline";
	   $("#list_value").focus();
	   $("#list_value_valid").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z-,\s]/g, ''));
   }
}); */

</script>