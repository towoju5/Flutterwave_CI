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
						$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'enctype' => 'multipart/form-data');
						echo form_open_multipart('admin/listattribute/EditlistAttribute',$attributes) 
					?>
	 			
                <ul>
	 							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="attribute_name">List Name <span class="req">*</span></label>
							<div class="form_input">
								<input name="attribute_name" id="attribute_name" type="text" tabindex="1" class="required large tipTop" title="Please enter the list name" value="<?php echo $attribute_details->row()->attribute_name;?>" required /><span id="attribute_name_valid" style="color:#f00;display:none;"> Only Characters allowed!</span>
							</div>
							</div>
							</li>

								<li>
								<div class="form_grid_12">
									<div class="form_input">
								<input type="hidden" name="attribute_id" value="<?php echo $attribute_details->row()->id;?>"/>                                    
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>

										<a href='<?php echo base_url().'admin/listattribute/display_attribute_listspace';?>'>
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
		<span class="clear"></span>
	</div>
</div>

<script type="text/javascript">
$('#edituser_form').validate();
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>
<script>
/* $("#attribute_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z-,\s]/g)) {
	   document.getElementById("attribute_name_valid").style.display = "inline";
	   $("#attribute_name").focus();
	   $("#attribute_name_valid").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z-,\s]/g, ''));
   }
}); */

</script>