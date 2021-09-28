<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Currency</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm', 'accept-charset' => 'utf-8');
						echo form_open(ADMIN_PATH.'/currency/insertEditCurrency',$attributes) 
					?> 		
                    	<div id="tab1">
	 						<ul>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="country_name">Country Name <span class="req">*</span></label>
									<div class="form_input">
                                    <select name="country_name" title="Please select the country name" style=" width:295px; height:25px;" id="name" tabindex="1" class="required tipTop">
											<option value="">Select Country</option>
<?php if($countryList->num_rows() >0){ 
    foreach($countryList->result() as $get_list){?>
   <option value="<?php echo $get_list->name?>" <?php if($get_list->name == $currency_details->row()->country_name){echo "selected";}?>><?php echo $get_list->name?></option>     
										    <?php } }?>
											</select>
									</div>
								</div>
								</li>
                                 <li>
								<div class="form_grid_12">
									<label class="field_title" for="currency_symbols">Currency Symbol <span class="req">*</span></label>
									<div class="form_input">
										 <input name="currency_symbols" maxlength="5" style=" width:295px" id="currency_symbols" value="<?php echo $currency_details->row()->currency_symbols;?>" type="text" tabindex="1" class="required tipTop" title="Please enter the currency name"/>
										<span id="currency_symbol_valid" style="color:#f00;display:none;">Numbers Not Allowed!</span>
										<label id="currency_symbol_len" style="font-size:12px;display:none;" class="error">Max 5 Characters Allowed</label>
									</div>
								</div>
								</li>
								 <li style="display:none;">
								<div class="form_grid_12">
									<label class="field_title" for="currency_rate">Currency Rate <span class="req">*</span></label>
									<div class="form_input">
										 <input name="currency_rate" style=" width:295px" id="currency_rate" value="<?php echo $currency_details->row()->currency_rate;?>" type="hidden" tabindex="1" class="required tipTop" title="Please enter the currency rate" value="1"/>
										

									</div>
								</div>
								</li>
								 <li>
								<div class="form_grid_12">
									<label class="field_title" for="currency_type">Currency Type <span class="req">*</span></label>
									<div class="form_input">
										 <input name="currency_type" style=" width:295px" maxlength="5" id="currency_type" value="<?php echo $currency_details->row()->currency_type;?>" type="text" tabindex="1" class="required tipTop" title="Please enter the currency type"/>
										<label id="currency_type_len" style="font-size:12px;display:none;" class="error">Max 5 Characters Allowed</label>

										<span id="currency_type_valid" style="color:#f00;display:none;">Only Characters Allowed!</span>
											
											<br><br><span style="font-size:14px; color:#CC3300;" >*Note: Add the currency code accept by Paypal, to view the currency codes click the Below link,<br /><br /> <a href="javascript: void(0)" onclick="window.open('https://developer.paypal.com/webapps/developer/docs/classic/api/currency_codes/ ', 'Paypal Currency Code', 'width=1200, height=1200'); 

                                             return false;">https://developer.paypal.com/webapps/developer/docs/classic/api/currency_codes/ </a></span>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
                                        <input type="checkbox" name="status" <?php if ($currency_details->row()->status == 'Active'){echo 'checked="checked"';}?> id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								</li>
                                
                            
                               
								<input type="hidden" name="currency_id" value="<?php echo $currency_details->row()->id;?>"/>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>
										<a href="<?php echo base_url()."admin/currency/display_currency_list"; ?>"><button type="button" class="btn_small btn_blue" tabindex="4"><span>Back</span></button></a>
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
$("#currency_symbol").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^0-9\s]/g)) {
	   
   }else {
	   document.getElementById("currency_symbol_valid").style.display = "inline";
	   $("#currency_symbol_valid").fadeOut(5000);
	   $("#currency_symbol").focus();
	   $("#currency_symbol").val('');
   }
});

$("#currency_symbols").on('keypress', function(e) {
     var val = $(this).val();
	   if(val.length == 5){
	   document.getElementById("currency_symbol_len").style.display = "inline";
	   $("#currency_symbol_len").fadeOut(5000);
   }
});

$("#currency_type").on('keypress', function(e) {
     var val = $(this).val();
	   if(val.length == 5){
	   document.getElementById("currency_type_len").style.display = "inline";
	   $("#currency_type_len").fadeOut(5000);
   }
});

</script>