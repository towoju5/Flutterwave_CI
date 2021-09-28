<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New List</h6>
                        
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addattribute_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/attribute/insertAttribute',$attributes) 
					?>
                    
						<ul>
	 					
<?php $langCount=$number_of_lang->num_rows();
	  $langResult=$number_of_lang->result(); ?>
						
							
					
							<li>
								<div class="form_grid_12">
								<label class="field_title" for="attribute_name">List Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="attribute_name" id="attribute_name" type="text" tabindex="1" class="required large tipTop" value="" title="Please enter the list name" required/><span id="attribute_name_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!</span>
									</div>
								</div>
							</li>
							
							
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="attribute_title">List Title <span class="req">*</span></label>
								<div class="form_input">
									<input name="attribute_title" id="attribute_title" type="text" tabindex="1" class="required large tipTop" title="Please enter the list Title"required/><span id="attribute_title_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!</span>
								</div>
							</div>
						</li>
					
					
					
							<!-- <li style="display:none">
								<div class="form_grid_12">
								<label class="field_title" for="attribute_name">List Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="attribute_name" id="attribute_name" type="text" tabindex="1" class="required large tipTop" value="" title="Please enter the list name" required/><span id="attribute_name_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!</span>
									</div>
								</div>
							</li>
							
							
							
							<li style="display:none">
							<div class="form_grid_12">
							<label class="field_title" for="attribute_title">List Title <span class="req">*</span></label>
							<div class="form_input">
								<input name="attribute_title" id="attribute_title" type="text" tabindex="1" class="required large tipTop" title="Please enter the list Title"required/><span id="attribute_title_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!</span>
							</div>
							</div>
							</li> -->
						
                        	
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="11" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
							</li>
								
								
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="9"><span>Submit</span></button>
									</div>
								</div>
								</li>
							</ul>
                    
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>

<script>
$('#addattribute_form').validate();
</script>

<?php 
$this->load->view('admin/templates/footer.php');
?>
<script>
/* $("#attribute_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("attribute_name_valid_error").style.display = "inline";
	   $("#attribute_name_valid_error").fadeOut(5000);
	   $("#attribute_name").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()]/g, ''));
   }
});

$("#attribute_title").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
	   document.getElementById("attribute_title_valid_error").style.display = "inline";
	   $("#attribute_title_valid_error").fadeOut(5000);
	   $("#attribute_title").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()]/g, ''));
   }
}); */
</script>