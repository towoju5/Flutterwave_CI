<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading; ?> </h6>
					</div>
					<div class="widget_content">
					<?php 
						$experience = array('class' => 'form_container left_label', 'id' => 'editexperience_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8' );
						echo form_open_multipart('admin/experience/EditExperienceType',$experience) 
					?>
	 			
                			<ul>
	 							
							
							
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="experience_title">Experience Title <span class="req">*</span></label>
										<div class="form_input">
											<input name="experience_title" id="experience_title" type="text" tabindex="1" class="required large tipTop" title="Please enter the Experience Title"  value="<?php echo $experience_details->row()->experience_title;?>" required/>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="experience_description">Description <span class="req">*</span></label>
										<div class="form_input">
											<textarea name="experience_description" id="experience_description" tabindex="1" class="required large tipTop" title="Please enter the Experience Description" rows='10' required><?php echo $experience_details->row()->experience_description;?></textarea>
										</div>
									</div>
								</li>

								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<input type="hidden" name="experience_id" value="<?php echo $experience_details->row()->id;?>"/> 
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>
										<a href="<?php echo 'admin/experience/experienceTypeList'; ?>"  class="btn_small btn_blue"><span>Cancel</span></a>
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
$('#editexperience_form').validate();
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>

