<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Dispute</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin',$attributes) 
					?>
	 						<ul>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="title">Rental Name</label>
									<div class="form_input">
                                    <?php echo ucfirst($review_details->row()->product_title);?>
									</div>
								</div>
								</li>
								
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Dispute Comments</label>
									<div class="form_input">
                                   <?php echo $review_details->row()->message;?>
									</div>
								</div>
								</li>
                                
                               <li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Dispute Email Address</label>
									<div class="form_input">
                                   <?php echo $review_details->row()->email;?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="description">Host Name</label>
									<div class="form_input">
									<?php if($review_details->row()->med_senderid == $review_details->row()->host_id){
									$host_id = $review_details->row()->med_senderid; 
									}else{
									$host_id = $review_details->row()->med_receiverid;
									} ?>
									<?php $host_details = $this->review_model->get_all_details(USERS,array('id'=>$host_id)); ?>
                                   <?php echo $host_details->row()->user_name;?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="description">User Name</label>
									<div class="form_input">
									
									<?php 
									//echo $review_details->row()->med_senderid;
									//echo $review_details->row()->host_id;
									if($review_details->row()->med_senderid != $review_details->row()->host_id){
									$user_id = $review_details->row()->med_senderid; 
									}else{
									$user_id = $review_details->row()->med_receiverid;
									} ?>
									<?php $user_details = $this->review_model->get_all_details(USERS,array('id'=>$user_id)); ?>
                                   <?php echo $user_details->row()->user_name;?>
                                  
									</div>
								</div>
								</li>
								<?php if($review_details->row()->status=='Pending') { ?>		
								<li >
								<div style="margin-left:340px;">
									<a href='<?php echo base_url()."admin/dispute/accept_dispute/".$review_details->row()->id.'/'.$review_details->row()->booking_no;?>'><button type="button" class="btn_small btn_blue" tabindex="4"><span>Accept</span></button></a>
									<a href='<?php echo base_url()."admin/dispute/reject_dispute/".$review_details->row()->id.'/'.$review_details->row()->booking_no;?>'>
									<button type="button" class="btn_small btn_blue" style='background-color: rgb(206, 10, 10);border-color:#771515  ' tabindex="4"><span>Reject</span></button></a>
								</div>

								</li>
								<?php  }	 ?>
								 <li>

								<div class="form_grid_12" style="margin-left:340px;">
									<label class="field_title" for="description">Message Conversation </label>	
								</div>
								</li> 
                               <li>
								<?php 
								$booking_no = $this->uri->segment(4);
								$message = $this->review_model->get_all_details(MED_MESSAGE,array('bookingNo'=>$booking_no));
								foreach($message->result() as $list){
								if($review_details->row()->host_id == $list->senderId){
								
								?>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="description"> <?php echo $host_details->row()->user_name;?> (HOST)</label>
									<div class="form_input">
                                   <?php echo $list->message;?>
									</div>
								</div>
								</li>
								<?php }else{ ?>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="description"><?php echo $user_details->row()->user_name;?> (USER)</label>
									<div class="form_input">
                                   <?php echo $list->message;?>
									</div>
								</div>
								</li>
							
								<?php } } ?>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/dispute/display_dispute_list" class="tipLeft" title="Go to Dispute list"><span class="badge_style b_done">Back</span></a>
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