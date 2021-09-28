<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading;?></h6>
                        
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'add_vendor_payment_form');
						echo form_open_multipart('admin/dispute/add_admin_payment_manual',$attributes) 	
						?>
							<ul>
		 						<input type="hidden" name="hostEmail" value="<?php echo $hostEmail; ?>" >
								<input type="hidden" name="bookid" value="<?php echo $bookid; ?>" >	
	 							<li>
									<div class="form_grid_12">
									<label class="field_title" for="transaction_id">Transaction Id<span class="req">*</span></label>
									<div class="form_input">
										<input name="transaction_id" onkeypress="return check_for_num(event)" id="transaction_id" type="text" tabindex="1" class="required large tipTop" title="Please enter the transaction id"/>
									</div>
									</div>
								</li>
		 							
								<li>
									<div class="form_grid_12">
									<label class="field_title" for="amount">Amount<span class="req">*</span></label>
									<div class="form_input">
										<input name="amount" id="" type="text" tabindex="3" class="required number large tipTop" title="Please enter the amount" value="<?php echo number_format($payableAmount,2, '.', '');?>" readonly/>
										<span class="input_instruction green">Balance amount is <?php echo $currencySymbol.number_format($payableAmount,2, '.', '');?></span>
									</div>
									</div>
								</li>
								
								<li>
								<input type="hidden" name="balance_due" value="<?php echo $GuestEmail;?>"/>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>ADD PAYMENT</span></button>

										<a href="<?php echo base_url()."admin/dispute/cancel_booking_payment";?>"><button type="button" class="btn_small btn_blue" tabindex="4"><span>Cancel</span></button></a>
										
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
$('#add_vendor_payment_form').validate();
</script>

<script>
function check_for_num(evt)
{
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	{
		return false;
	}
	return true;
}
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>
