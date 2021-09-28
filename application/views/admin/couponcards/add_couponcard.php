<?php
$this->load->view('admin/templates/header.php');
?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="css/datepicker.css" rel="stylesheet">
<style type="text/css">
	.hide-date{
		pointer-events: none;
		color: #ddd;
	}
</style>
<script language="javascript">
function coupon_proudct(val){
	if(val=='category'){
		document.getElementById('shipping').style.display = 'block';
		document.getElementById('category').style.display = 'block';
		document.getElementById('product').style.display = 'none';
	}else if(val=='product'){
		document.getElementById('shipping').style.display = 'block';
		document.getElementById('category').style.display = 'none';
		document.getElementById('product').style.display = 'block';
	}else if(val=='shipping'){
		document.getElementById('shipping').style.display = 'none';
		document.getElementById('category').style.display = 'none';
		document.getElementById('product').style.display = 'none';
	}else{
		document.getElementById('shipping').style.display = 'block';
		document.getElementById('category').style.display = 'none';
		document.getElementById('product').style.display = 'none';
	}	
}

</script>

<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New Coupon Code</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'adduser_form','accept-charset'=>'UTF-8');
						echo form_open('admin/couponcards/insertEditCouponcard',$attributes) 
					?>
	 						<ul>
							
							   <li>
								<div class="form_grid_12">
									<label class="field_title" for="user_name">Coupon Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="coupon_name" id="coupon_name" type="text" tabindex="1" class="required small tipTop" title="Please Enter the Coupon Name" value=""/><span id="coupon_name_valid" style="color:#f00;display:none;"> Only Characters are allowed!</span>
									</div>
								</div>
								</li>
                            
                               <li>
								<div class="form_grid_12">
									<label class="field_title" for="user_name">Coupon code <span class="req">*</span></label>
									<div class="form_input">
										<input name="code" id="code" type="text" tabindex="2" class="required small tipTop" title="Please Enter the Coupon Code" value="<?php echo $code; ?>"/>
									</div>
								</div>
								</li>
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="group">Max No. of Coupons <span class="req">*</span></label>
									<div class="form_input">
										<input name="quantity" id="quantity" type="text" tabindex="3" class="required small tipTop" title="Please Enter max no of coupons applied count from the customer while booking"/><span id="quantity_valid" style="color:#f00;display:none;"> Only Numbers are allowed!</span>
									</div>
								</div>
								</li>
                                
                                <!-- <li>
								<div class="form_grid_12">
									<label class="field_title" for="datefrom">Coupon Valid From<span class="req">*</span></label>
									<div class="form_input">
										<input name="datefrom" id="datefrom" type="text" tabindex="5" class="required small tipTop datepicker" title="Please select the From date"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="dateto">Coupon Valid Till<span class="req">*</span></label>
									<div class="form_input">
										<input name="dateto" id="dateto" type="text" tabindex="6" class="required small tipTop datepicker" title="Please select the End date"/>
									</div>
								</div>
								</li> -->
                                <li> 
									<div class="form_grid_12">
										<label class="field_title " for="datefrom">Coupon Valid From<span class="req">*</span></label>
										<div class="form_input">
											<span class="form-control frm_wdth" id="fromDisplay2" name="from"></span>
											<input type="hidden" name="datefrom" value="" id="fromInput2">
											<div class="vf-datepicker" id="startDP2"></div>
										</div>
									</div>
							</li>      
							<li>

								<div class="form_grid_12">
									<label class="field_title" for="dateto">Coupon Valid Till<span class="req">*</span></label>
								<div class="form_input">
									<span class="form-control frm_wdth" id="toDisplay2"></span>
									<input type="hidden" name="dateto" value="" id="toInput2">
									<div class="vf-datepicker" id="endDP2"></div>
								</div>
							</div>
							</li>
                                <li>
								<div class="form_grid_12">
                                    <label class="field_title">Select a Coupon Type <span class="label_intro">Select this field, coupon applied for category or product or shipping. Otherwise Coupon Apply for Cart</span></label>
									<div class="form_input">
							<select data-placeholder="Select a Coupon Type" name="coupon_type" style=" width:300px" class="chzn-select-deselect" tabindex="13" onchange="coupon_proudct(this.value);">
									<option value="">None</option>
									<option value="Advertisement">Advertisement</option>
									<option value="Birthday Card">Birthday Card</option>
									<option value="Business Travel">Business Travel</option> 
                                    <option value="Gift Card">Gift Card</option> 
                                    <option value="Promotion">Promotion</option>
                                    <option value="Staff">Staff</option>									
							</select>
									</div>
								</div>
								</li>
                                </ul>
                                
                                <ul id="shipping" style="display:block;">
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="full_name">Discount Type <span class="req">*</span></label>
									<div class="form_input">
										<div class="flat_percentage">
											<input type="checkbox" tabindex="1" name="price_type" checked="checked" class="Flat_Percentage"/>
										</div>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_name">Price Value <span class="req">*</span></label>
									<div class="form_input">
										<input name="price_value" id="price_value" type="text" tabindex="2" class="required small tipTop" title="Please enter the price value"/><span id="price_value_valid" style="color:#f00;display:none;">Only Numbers are allowed!</span>
									</div>
								</div>
								</li>
                                </ul>
                                <!--
                                <ul id="category" style="display:none;">
	 							
									
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_name">Select Category<span class="req">*</span><span class="label_intro">Select Multiple Category</span></label>
									<div class="form_input">
	                                    <div class="dashboard_box_large1 dashboard_focus">
		                                   <?php echo $CateogyView; ?>
										</div>									
									</div>
								</div>
								</li>
                                </ul>
                                
                                <ul id="product" style="display:none;">
	 							
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_name">Select Product<span class="req">*</span><span class="label_intro">Select Multiple Product</span></label>
									<div class="form_input">
                                      <div class="dashboard_box_large1 dashboard_focus">
										<?php echo $ProductView; ?>
                                        </div>
									</div>
								</div>
								</li>
                                </ul>
                                -->
                                <ul>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="email">Description</label>
									<div class="form_input">
										<textarea name="description" id="description" rows="5" cols="5" class="small tipTop" tabindex="4"  title="Please enter the description"></textarea>
										</br></br><small>Maximum 150 words</small>
										<br><span class="words-left" > </span>
									</div>
								</div>
								</li>
								
<!-- 								<li>
								<div class="form_grid_12">
									<label class="field_title" for="status">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								</li>



 -->						
 								<li>
									<div class="form_grid_12">
										<label class="field_title" for="property">Property </label>
										<div class="form_input">
											<?php 
											//print_r($hostDetails->result());

											

											if($hostDetails->num_rows()>0){

												?>
												<select name="product_id[]" multiple id="property">
												
												<?php
												
												foreach ($hostDetails->result() as $host) {
													$hostid	=$host->id;
													if($productDetails[$hostid]->num_rows()>0){
														//print_r($productDetails[$hostid]->result());
												?>
													
													<optgroup label="<?php echo $host->firstname.' '.$host->lastname; ?>">	
													<?php	

														foreach ($productDetails[$hostid]->result() as $product) {
															?>
													   		<option value="<?php echo $product->id; ?>"  ><?php echo $product->product_title.' '.$product->city.','.$product->state;?></option>
													        
												<?php
														}
														?>
													</optgroup>
													<?php
													}
												}
												?>
												</select>
												<?php

											}
											?>

											
										</div>
									</div>			
								</li>
		
 								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="8"><span>Submit</span></button>
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
	$('#adduser_form').validate();
	
</script>
<link href="<?php echo base_url();?>js/multipleSelect/jquery.multiselect.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>js/multipleSelect/jquery.multiselect.js"></script>
<script>

$('#property').multiselect({
    columns: 4,
    placeholder: 'Select Property',
    search: true,
    selectAll: true
});
</script>

<style>
body { font-family:'Open Sans' Arial, Helvetica, sans-serif}
ul,li { margin:0; padding:0; list-style:none;}
.label { color:#000; font-size:16px;}

.ms-options {
    position: relative !important;
}
</style>
<?php 
$this->load->view('admin/templates/footer.php');
?>

<script>
/* $("#coupon_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z.,|-\s()&/]/g)) {
	   document.getElementById("coupon_name_valid").style.display = "inline";
	   $("#coupon_name_valid").fadeOut(5000);
	   $("#coupon_name").focus();
       $(this).val(val.replace(/[^a-zA-Z.,|-\s()&/]/g, ''));
   }
}); */

$("#quantity").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^0-9\s]/g)) {
	   document.getElementById("quantity_valid").style.display = "inline";
	   $("#quantity").focus();
	   $("#quantity_valid").fadeOut(5000);
       $(this).val(val.replace(/[^0-9\s]/g, ''));
   }
});

$("#price_value").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^0-9.\s]/g)) {
	   document.getElementById("price_value_valid").style.display = "inline";
	   $("#price_value").focus();
	   $("#price_value_valid").fadeOut(5000);
       $(this).val(val.replace(/[^0-9.\s]/g, ''));
   }
});
</script>

<script type="text/javascript">
//function WordCount(){
var wordLen = 150,
		len; 
$('#description').keydown(function(event) {	
	len = $('#description').val().split(/[\s]+/);
	if (len.length > wordLen) { 
		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons
    } else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons
    	event.preventDefault();
    }
	}
	
	wordsLeft = (wordLen) - len.length;
	if(wordsLeft == 0) {
	
		$('.words-left').html('You Can not Type More then 150 Words...!');
	}
});

//}
</script>


		<script src="js/datepicker.js"></script>
		<script>
		var _unavailable = [];
		 var _onrequest = [];
		  _unavailable.push('2014-10-23');
		  _unavailable.push('2014-10-24');
		  _unavailable.push('2014-10-25');
		  _unavailable.push('2014-10-26');
		  _unavailable.push('2014-10-27');
		  _unavailable.push('2014-10-28');
		  _unavailable.push('2014-10-29');
		  _unavailable.push('2014-10-30');
		  _unavailable.push('2014-10-31');
		  _unavailable.push('2015-03-03');
		  _unavailable.push('2015-03-04');
		  _unavailable.push('2015-03-05');
		  _unavailable.push('2015-03-06');
		  _unavailable.push('2014-09-04');
		  _unavailable.push('2014-09-05');
		  _unavailable.push('2014-09-06');
		  _unavailable.push('2014-09-07');
		  _unavailable.push('2014-09-08');
		  _unavailable.push('2014-09-09');
		  _unavailable.push('2014-09-10');
		  _unavailable.push('2014-09-11');
		  _unavailable.push('2014-09-12');
		  _unavailable.push('2014-09-13');
		  _unavailable.push('2014-09-16');
		  _unavailable.push('2014-09-17');
		  _unavailable.push('2014-09-18');
		  _unavailable.push('2014-09-19');
		  _unavailable.push('2014-09-20');
		  _unavailable.push('2014-09-21');
		  _unavailable.push('2014-08-22');
		  _unavailable.push('2014-08-23');
		  _unavailable.push('2014-08-24');
		  _unavailable.push('2014-07-01');
		  _unavailable.push('2014-07-02');
		  _unavailable.push('2014-07-03');
		  _unavailable.push('2014-07-04');
		  _unavailable.push('2014-07-05');
		  _unavailable.push('2014-07-06');
		  _unavailable.push('2014-07-07');
		  _unavailable.push('2014-07-08');
		  _unavailable.push('2014-07-09');
		  _unavailable.push('2014-07-10');
		  _unavailable.push('2014-07-11');
		  _unavailable.push('2014-07-12');
		  _unavailable.push('2014-07-13');
		  _unavailable.push('2014-07-14');
		  _unavailable.push('2014-07-15');
		  _unavailable.push('2014-07-16');
		  _unavailable.push('2014-07-17');
		  _unavailable.push('2014-07-18');
		  _unavailable.push('2014-07-19');
		  _unavailable.push('2014-07-20');
		  _unavailable.push('2014-07-21');
		  _unavailable.push('2014-07-22');
		  _unavailable.push('2014-07-23');
		  _unavailable.push('2014-07-24');
		  _unavailable.push('2014-07-25');
		  _unavailable.push('2014-07-26');
		  _unavailable.push('2014-07-27');
		  _unavailable.push('2014-07-28');
		  _unavailable.push('2014-07-29');
		  _unavailable.push('2014-07-30');
		  _unavailable.push('2014-07-31');
		  _unavailable.push('2014-08-01');
		  _unavailable.push('2014-08-02');
		  _unavailable.push('2014-08-03');
		  _unavailable.push('2014-08-04');
		  _unavailable.push('2014-08-05');
		  _unavailable.push('2014-08-06');
		  _unavailable.push('2014-08-07');
		  _unavailable.push('2014-08-08');
		  _unavailable.push('2014-08-09');
		  _unavailable.push('2014-08-10');
		  _unavailable.push('2014-08-11');
		  _unavailable.push('2014-08-12');
		  _unavailable.push('2014-08-13');
		  _unavailable.push('2014-08-14');
		  _unavailable.push('2014-08-15');
		  _unavailable.push('2014-08-16');
		  _unavailable.push('2014-08-17');
		  _unavailable.push('2014-08-18');
		  _unavailable.push('2014-08-19');
		  _unavailable.push('2014-08-20');
		  _unavailable.push('2014-08-21');
		  _unavailable.push('2014-12-30');
		  _unavailable.push('2014-12-31');
		  _unavailable.push('2015-01-01');
		  _unavailable.push('2015-01-02');
		  _unavailable.push('2015-01-03');
		  _unavailable.push('2015-01-25');
		  _unavailable.push('2015-01-26');
		  _unavailable.push('2015-01-27');
		  _unavailable.push('2015-01-28');
		  _unavailable.push('2015-01-29');
		  _unavailable.push('2015-01-30');
		  _unavailable.push('2015-01-31');
		  _unavailable.push('2015-02-01');
		  _unavailable.push('2015-02-02');
		  _unavailable.push('2015-02-03');
		  _unavailable.push('2014-08-25');
		  _unavailable.push('2014-08-26');
		  _unavailable.push('2014-08-27');
		
		
		/*var dp = new VF_datepicker();
		dp.datepicker({
			'name': 'form1',
			'start': null,
			'end': null,
			'monthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			'dayNames': ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
			'startCtrl': $('#fromDisplay'),
			'endCtrl': $('#toDisplay'),
			'startDisplay': $('#fromDisplay'),
			'endDisplay': $('#toDisplay'),
			'startInput': $('#fromInput'),
			'endInput': $('#toInput'),
			'startDP': $('#startDP'),
			'endDP': $('#endDP'),
			'clearTxt': 'Clear dates',

			'unavailable': _unavailable,
			'onrequest': _onrequest,
			'displayFrom': function(from, to){
				console.log(['from display', from, to]);
			},
			'displayTo': function(from, to){
				console.log(['to display', from, to]);
			},
			'fromChosen': function(from, to){
				console.log(['from chosen', from, to]);
			},
			'toChosen': function(from, to){
				console.log(['to chosen', from, to]);
			},
			'hideFrom': function(from, to){
				console.log(['from hide', from, to]);
			},
			'hideTo': function(from, to){
				console.log(['to hide', from, to]);
			},
			'positions': ['left', 'right']
		});*/
		// var now = new Date();
		// var ny = now.getFullYear();
		// var nm = now.getMonth();
		// var dp2 = new VF_datepicker();
		// dp2.datepicker(ny, nm, {
		// 	'name': 'form2',
		// 	'start': null,
		// 	'end': null,
		// 	'minDate': new Date(),
		// 	'monthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		// 	'dayNames': ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
		// 	'startCtrl': $('#fromDisplay2'),
		// 	'endCtrl': $('#toDisplay2'),
		// 	'startDisplay': $('#fromDisplay2'),
		// 	'endDisplay': $('#toDisplay2'),
		// 	'startInput': $('#fromInput2'),
		// 	'endInput': $('#toInput2'),
		// 	'startDP': $('#startDP2'),
		// 	'endDP': $('#endDP2'),
		// 	'clearTxt': 'Clear dates',
			
		// 	'unavailable': _unavailable,
		// 	'onrequest': _onrequest,
		// 	'displayFrom': function(from, to){
		// 		console.log(['from display2', from, to]);
		// 	},
		// 	'displayTo': function(from, to){
		// 		console.log(['to display2', from, to]);
		// 	},
		// 	'fromChosen': function(from, to){
		// 		console.log(['from chosen', from, to]);
		// 	},
		// 	'toChosen': function(from, to){
		// 		console.log(['to chosen', from, to]);
		// 	},
		// 	'hideFrom': function(from, to){
		// 		console.log(['from hide2', from, to]);
		// 	},
		// 	'hideTo': function(from, to){
		// 		console.log(['to hide2', from, to]);
		// 	},
		// 	'positions': ['left', 'right']
		// });


		// var now = new Date();
		// var ny = now.getFullYear();
		// var nm = now.getMonth();
		// VF_datepicker.datepicker(ny, nm, {
		// 	'monthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		// 	'dayNames': ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
		// 	'from_chosen': function(from){
		// 		$('.inputFrom').val(from);
		// 	},
		// 	'to_chosen': function(from, to){
		// 		VF_datepicker.close();
		// 		$('.inputFrom').val(from);
		// 		$('.inputTo').val(to);
		// 	},
		// 	'startCtrl': $('#fromDisplay2'),
		// 	'endCtrl': $('#toDisplay2'),
		// 	'startDisplay': $('#fromDisplay'),
		// 	'endDisplay': $('#toDisplay'),
		// 	'startInput': $('#fromInput2'),
		// 	'endInput': $('#toInput2'),
		// 	'startDP': $('#startDP2'),
		// 	'endDP': $('#endDP2'),
		// 	'clearTxt': 'Clear dates',
		// }, function(from, to){
		// 	//alert([from, to]);
		// });
		// $('#inputFrom').focus(function(){
		// 	VF_datepicker.show();
		// });
		// $('#inputTo').focus(function(){
		// 	if (VF_datepicker.from) {
		// 		VF_datepicker.show();	
		// 	} else {
		// 		VF_datepicker.show();
		// 	}
		// 	VF_datepicker.removeTo();
		// });

		now = new Date();

		ny = now.getFullYear();

		nm = now.getMonth()+1;

		nD = now.getDate();
		var dp2 = new VF_datepicker();
		dp2.datepicker({
			minDate:0,
			'name': 'form2',
			'start': ny + '-' + nm + '-' + nD,
			'end': null,
			'monthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			'dayNames': ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
			'startCtrl': $('#fromDisplay2'),
			'endCtrl': $('#toDisplay2'),
			'startDisplay': $('#fromDisplay2'),
			'endDisplay': $('#toDisplay2'),
			'startInput': $('#fromInput2'),
			'endInput': $('#toInput2'),
			'startDP': $('#startDP2'),
			'endDP': $('#endDP2'),
			'clearTxt': 'Clear dates',
			'unavailable': _unavailable,
			'onrequest': _onrequest,
			'displayFrom': function(from, to){
				//console.log(['from display2', from, to]);
			},
			'displayTo': function(from, to){
				//console.log(['to display2', from, to]);
			},
			'fromChosen': function(from, to){
				//console.log(['from chosen2', from, to]);
			},
			'toChosen': function(from, to){
				//console.log(['to chosen2', from, to]);
			},
			'hideFrom': function(from, to){
				//console.log(['from hide2', from, to]);
			},
			'hideTo': function(from, to){
				//console.log(['to hide2', from, to]);
			},
			
		});
		</script>