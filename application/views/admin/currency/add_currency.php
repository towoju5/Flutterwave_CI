<?php

$this->load->view('admin/templates/header.php');

?>

<div id="content">

		<div class="grid_container">

			<div class="grid_12">

				<div class="widget_wrap">

					<div class="widget_top">

						<span class="h_icon list"></span>

						<h6>Add New Currency</h6>

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

									    <label class="field_title" for="location_name">Country Name <span class="req">*</span></label>

									    <div class="form_input">

										    <select name="country_name" style=" width:295px; height:25px;" id="name" title="Please select country" onchange="get_suggestion(this.value);" tabindex="1" class="required tipTop">

											<option value="">Select Country</option>

											<?php if($countryList->num_rows() >0){

											      foreach($countryList->result() as $get_list){?>

												      <option value="<?php echo $get_list->name?>"><?php echo $get_list->name?></option>     

										    <?php } }?>

											</select>

									    </div>

								    </div>

								</li>

                                <li>

								    <div class="form_grid_12">

									    <label class="field_title" for="currency_symbol">Currency Symbol<span class="req">*</span></label>

									    <div class="form_input">

                                            <input name="currency_symbols" id="currency_symbols" maxlength="5" style=" width:295px" id="currency_symbol" type="text" tabindex="1" class="required tipTop" title="Please enter the currency symbol"/>
											<span id="currency_symbol_valid" style="color:#f00;display:none;">Numbers Not Allowed!</span>
											<label id="currency_symbol_len" style="font-size:12px;display:none;" class="error">Max 50 Characters Allowed</label>

									    </div>

								    </div>

								</li>

                                <li>

								    <div class="form_grid_12">

									    <label class="field_title" for="currency_type">Currency Type<span class="req">*</span></label>

									    <div class="form_input">

                                            <input name="currency_type" id="currency_type" style=" width:295px" maxlength="5" id="currency_type" type="text" tabindex="1" class="required tipTop" title="Please enter the currency Code"/><span id="currency_type_valid" style="color:#f00;display:none;">Only Characters Allowed!</span>
											 <label id="currency_type_len" style="font-size:12px;display:none;" class="error">Max 50 Characters Allowed</label>
											<br /><br /> 

                                            <span style="font-size:14px; color:#CC3300;" >*Note: Add the currency code accept by Paypal, to view the currency codes click the Below link,<br /><br /> <a href="javascript: void(0)" onclick="window.open('https://developer.paypal.com/webapps/developer/docs/classic/api/currency_codes/ ', 'Paypal Currency Code', 'width=1200, height=1200'); 

                                             return false;">https://developer.paypal.com/webapps/developer/docs/classic/api/currency_codes/ </a></span>
											

									    </div>

								    </div>

								</li>

                                <li style="display:none;">

								    <div class="form_grid_12">

									    <label class="field_title" for="currency_type" >1 USD($)<span class="req">*</span></label>

									    <div class="form_input">

                                            <input name="currency_rate" style=" width:295px" id="currency_rate" type="hidden" tabindex="1" class="required number tipTop" title="Please enter the currency rate" value="1" />

									    </div>

								    </div>

								</li>

								<li>

								<div class="form_grid_12">

									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>

									<div class="form_input">

										<div class="active_inactive">

                                        <input type="checkbox" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>

										</div>

									</div>

								</div>

								</li>

								<!--<input type="hidden" name="location_id" value=""/>-->

								<li>

								    <div class="form_grid_12">

									    <div class="form_input">

										    <button type="submit" class="btn_small btn_blue" tabindex="4"><span>Submit</span></button>

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


$("#currency_symbol").on('keypress', function(e) {
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
function get_suggestion(country_name)
{
	$.post("admin/currency/get_currency_code_and_symbol",
    {
        country_name: country_name
    },
    function(data, status){
    	var data=data.trim();
    	var obj = JSON.parse(data);
    	var code=obj.code;
    	var symbol=obj.symbol;
    	$("#currency_symbols").val(symbol);
    	$("#currency_type").val(code);
    	// console.log(symbol+code);
        // alert("Data: " + data + "\nStatus: " + status);
    });
}
</script>