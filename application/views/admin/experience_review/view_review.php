<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Review</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin',$attributes) 
					?>
	 						<ul>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="title">Experience Name</label>
									<div class="form_input">
                                    <?php echo ucfirst($review_details->row()->product_title);?>
									</div>
								</div>
								</li>
								
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Review Comments</label>
									<div class="form_input">
                                   <?php echo $review_details->row()->review;?>
									</div>
								</div>
								</li>
                                
                              <!--  <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Owner Reply</label>
									<div class="form_input">
                                   <?php echo $review_details->row()->owner_reply;?>
									</div>
								</div>
								</li> -->
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Review Rating</label>
									<div class="form_input">
                                   <?php echo $review_details->row()->total_review;?>
									</div>
								</div>
								</li>
	 							
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Full Name</label>
									<div class="form_input">
                                   <?php echo $review_details->row()->user_name;?>
									</div>
								</div>
								</li>
                               
                               <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Email Address</label>
									<div class="form_input">
                                   <?php echo $review_details->row()->email;?>
									</div>
								</div>
								</li>
								
								
								 <!-- <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Review For</label>
									<div class="form_input">
                                   <?php echo $review_details->row()->review_for;?>
									</div>
								</div>
								</li>-->
                              
							  <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Status</label>
									<div class="form_input">
                                   <?php echo $review_details->row()->status;?>
									</div>
								</div>
								</li>

								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/experience_review/display_experience_review_list" class="tipLeft" title="Go to review list"><span class="badge_style b_done">Back</span></a>
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
<?php 
$this->load->view('admin/templates/footer.php');
?>