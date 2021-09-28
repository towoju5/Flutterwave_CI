<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit List</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'editattribute_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/attribute/EditAttribute',$attributes) 
					?>
	 			
                <ul>
	 					

<?php $langCount=$number_of_lang->num_rows();
	  $langResult=$number_of_lang->result(); 

			foreach ($valAre as $key=>$val){

				$attrName[]=$key;
			
			}
			
			
?>					
					
						<!-- <li>
								<div class="form_grid_12">
								<label class="field_title" for="attribute_name">List Name  <?php echo $lang->name; ?> <span class="req">*</span></label>
									<div class="form_input">
										<input name="attribute_name" id="attribute_name" type="text" tabindex="1" class="required large tipTop" value=" <?php  //if ($key==$name) { echo $val; }?>"  title="Please enter the list name" required/><span id="attribute_name_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!</span>
									</div>
								</div>
						</li>
							
							
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="attribute_title">List Title <?php echo $lang->name; ?> <span class="req">*</span></label>
								<div class="form_input">
									<input name="attribute_title" id="attribute_title" type="text" tabindex="1" class="required large tipTop" value="" title="Please enter the list Title"required/><span id="attribute_title_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!</span>
								</div>
							</div>
						</li>		 -->
						
						
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="attribute_name">List Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="attribute_name" id="attribute_name" type="text" tabindex="1" class="required large tipTop" title="Please enter the list name" value="<?php echo $attribute_details->row()->attribute_name;?>" required/><span id="attribute_name_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!</span>
									</div>
								</div>
							</li>
							
							
							
							<li >
							<div class="form_grid_12">
							<label class="field_title" for="attribute_title">List Title <span class="req">*</span></label>
							<div class="form_input">
								<input name="attribute_title" id="attribute_title" type="text" tabindex="1" class="required large tipTop" title="Please enter the list Title"  value="<?php echo $attribute_details->row()->attribute_title;?>" required/><span id="attribute_title_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!</span>
							</div>
							</div>
							</li>
							
							

								<li>
								<div class="form_grid_12">
									<div class="form_input">
								<input type="hidden" name="attribute_id" value="<?php echo $attribute_details->row()->id;?>"/> 
																		
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>
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
$('#editattribute_form').validate();
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>
<script>
/* $("#attribute_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z.,|-\s()]/g)) {
	   document.getElementById("attribute_name_valid_error").style.display = "inline";
	   $("#attribute_name_valid_error").fadeOut(5000);
	   $("#attribute_name").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()]/g, ''));
   }
});

$("#attribute_title").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z.,|-\s()]/g)) {
	   document.getElementById("attribute_title_valid_error").style.display = "inline";
	   $("#attribute_title_valid_error").fadeOut(5000);
	   $("#attribute_title").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()]/g, ''));
   }
}); */
</script>