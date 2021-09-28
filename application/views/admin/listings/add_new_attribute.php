<?php
$this->load->view('admin/templates/header.php');
/* var_dump($details->result());die; */
?>


<?php if(isset($details)){ ?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				
				
				<div class="widget_wrap">
					<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit Listing Type</h6>
                        
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addattribute_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/listings/insert_attribute',$attributes) ;
						if($details->row()->name == 'accommodates' || $details->row()->name == 'can_policy'  || $details->row()->name == 'minimum_stay') { $disabled = 'Yes';}else{ $disabled = 'No';} 
					?>
					
                    
						<ul>
	 							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="attribute_name">Listing Name <span class="req">*</span></label>
							<div class="form_input">
							
							
								<input name="attribute_name" id="attribute_name" type="text" tabindex="1" class="required large tipTop" title="Please enter the list name"        value="<?php echo $details->row()->name; ?>" <?php if($disabled == 'Yes')echo 'Disabled';?>/>
								
		
							</div>
							</div>
							</li>
							
							<input type="hidden" name="id" value="<?php echo $this->uri->segment(4,0); ?>">
							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="attribute_name">Type <span class="req">*</span></label>
							<div class="form_input">
							
							    <input type="radio" name="type" value="option" <?php echo ($details->row()->type=='option')?'checked':''; ?> <?php if($disabled == 'Yes')echo 'Disabled';?>>option
							    <input type="radio" name="type" value="text" <?php echo ($details->row()->type=='text')?'checked':''; ?> <?php if($disabled == 'Yes')echo 'Disabled';?>>text
								
		
							</div>
							</div>
							</li>
							
							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="attribute_name">label <span class="req">*</span></label>
							<div class="form_input">
							
							
								<input name="label_name" id="label_name" type="text" tabindex="1" class="required large tipTop" title="Please enter the list label"        value="<?php echo $details->row()->labelname; ?>"/>
								
		
							</div>
							</div>
							</li>
							
						
                        	
							<!--<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="11" name="status" checked="checked" id="active_inactive_active" class="active_inactive" <?php// if($disabled == 'Yes')echo 'Disabled';?>/>
										</div>
									</div>
								</div>
								</li> -->
								<li> 
								
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue " tabindex="9"><span>Updata</span></button>
										<a href='<?php echo base_url().'admin/listings/attribute_values';?>'>
											<button type="button" class="btn_small btn_blue " tabindex="9"><span>Back</span></button>
										</a>
									</div>
								</div>
								</li>
							</ul>
                    
						</form>
					</div>
				</div>
				</div>
				</div>
				</div>
				<?php } else { ?>
		<div id="content">		
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New Listing Type</h6>
                        
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addattribute_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/listings/insert_attribute',$attributes) 
					?>
					
                    
						<ul>
	 							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="attribute_name">Listing Name <span class="req">*</span></label>
							<div class="form_input">
							
							
								<input name="attribute_name" id="attribute_name" type="text" tabindex="1" class="required large tipTop" title="Please enter the list name" value=""/><span id="attribute_name_valid" style="color:#f00;display:none;">Only Characters are allowed!</span>
								
		
							</div>
							</div>
							</li>
							
							<input type="hidden" name="id" value="">
							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="attribute_name">Type <span class="req">*</span></label>
							<div class="form_input">
							
							    <input type="radio" checked="checked" name="type" value="option">option
							    <input type="radio" name="type" value="text">text
								
		
							</div>
							</div>
							</li>
							
							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="attribute_name">label <span class="req">*</span></label>
							<div class="form_input">
							
							
								<input name="label_name" id="label_name" type="text" tabindex="1" class="required large tipTop" title="Please enter the list label"  value=""/><span id="label_name_valid" style="color:#f00;display:none;">Only Characters are allowed!</span>
								
		
							</div>
							</div>
							</li>
							
						
                        	
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="11" name="status" checked="checked" id="active_inactive_active" class="active_inactive" />
										</div>
									</div>
								</div>
								</li> 
								<li> 
								
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue " tabindex="9"><span>Submit</span></button>
									</div>
								</div>
								</li>
							</ul>
                    
						</form>
					</div>
				</div>
				
			</div>
		</div>
		</div>
		<?php } ?>
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
	$('#addattribute_form').validate();
	
</script>

<?php 
$this->load->view('admin/templates/footer.php');
?>

<script>
/* $("#attribute_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z.,|-\s()&/]/g)) {
	   document.getElementById("attribute_name").style.display = "inline";
	   $("#attribute_name_valid").fadeOut(5000);
	   $("#attribute_name").focus();
       $(this).val(val.replace(/[^a-zA-Z.,|-\s()&/]/g, ''));
   }
});

$("#label_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z.,|-\s()&/]/g)) {
	   document.getElementById("label_name").style.display = "inline";
	   $("#label_name_valid").fadeOut(5000);
	   $("#label_name").focus();
       $(this).val(val.replace(/[^a-zA-Z.,|-\s()&/]/g, ''));
   }
}); */
</script>