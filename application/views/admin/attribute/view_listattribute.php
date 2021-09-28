<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View List</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin',$attributes) 
					?>
				
	 						<ul>
	 							
	 							
								<li>
								<div class="form_grid_12">
									<label class="field_title">List Value :</label>
									<div class="form_input">
										<?php echo $attribute_details->row()->list_value;?>
									</div>
								</div>
								</li>

								
								<li>
								<div class="form_grid_12">
									<label class="field_title">Status :</label>
									<div class="form_input">
										<?php echo $attribute_details->row()->status;?>
									</div>
								</div>
								</li>
	 							
								
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/listattribute/display_list_values" class="tipLeft" title="Go to lists"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
								</li>
								</ul>
							
							
							
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>