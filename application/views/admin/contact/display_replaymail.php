<?php
$this->load->view('admin/templates/header.php');
extract($privileges);

?>

<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Contact</h6>
					</div>
					<div class="widget_content">
					<?php 
						//$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm', 'accept-charset' => 'utf-8');
						//echo form_open(ADMIN_PATH.'/currency/insertEditCurrency',$attributes) 


						$attributes = array('class' => 'form_container left_label', 'id' => 'editcontact_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/contact_us/replaymail1',$attributes) 
					
					?> 	
					
                    	<div id="tab1">
	 						<ul>				
								<li>
								  <div class="form_grid_12">
									<label class="field_title" for="email">Email<span class="req">*</span></label>
									<div class="form_input">
										 <input name="replayemail" id="replayemail" readonly value="<?php echo $admin_replay->row()->email;?>" type="text" tabindex="1" class="cnt-bx"/>
									</div>									
								   </div>
								 </li>
							</ul>
							<ul>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="your-message">REPLY MESSAGE:</label>
									<div class="form_input">
										<textarea name="your-message" id="your-message" cols="60" rows="10" tabindex="5" class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required" aria-required="true" aria-invalid="false"></textarea>
										</br>
										<br><span class="words-left"> </span>
									</div>
								</div>
							</li>
							</ul>
							<ul>
							<li>
								<div class="form_grid_12">
									<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Submit</span></button>
									</div>
								</div>
								</div>
							</li>
							
							</ul>
                        </div>
      
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
<script>
$('#replayemail').change(function() {
    var inputVal = $(this).val();
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if(!emailReg.test(inputVal)) {
        alert("Enter Valid Email Id");
		$("#replayemail").focus();
		$("#replayemail").val('');
    }
});
</script>