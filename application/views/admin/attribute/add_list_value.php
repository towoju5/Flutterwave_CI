<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add List Value</h6>
                        
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addlistvalue_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/attribute/insertEditListValue',$attributes) 
					?>
                    
						<ul>
	 							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="list_name">Select List<span class="req">*</span></label>
							<div class="form_input">
		                      <select class="chzn-select required" name="list_name" tabindex="-1" style="width: 375px; display: none;" data-placeholder="Select List">
		                      		<option value="">--Select--</option>
		                      		<?php 
		                      		foreach ($list_details->result() as $row){
		                      			if ($row->attribute_name!='price'){
		                      		?>
		                      		<option value="<?php echo $row->id;?>"><?php echo $row->attribute_name;?></option>
		                      		<?php }}?>
		                      </select>
		                    </div>
							</div>
							</li>
	 						
						
							
					
							
							<li >
							<div class="form_grid_12">
							<label class="field_title" for="list_value">List Value<span class="req">*</span></label>
							<div class="form_input">
								<input name="list_value" id="list_value" type="text" tabindex="1" class="required large tipTop" title="Please enter the list value"/><span id="list_value_valid" style="color:#f00;display:none;">Only Characters are allowed!</span>
							</div>
							</div>
							</li>
							
							
							
							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="image">List Icon  <span class="req"> Below 50*50</span></label>
							<div class="form_input">
							<input name="image" id="image" onchange="Upload(this.id);" type="file" tabindex="7" class="large tipTop" title="Please select list icon"/>
							<label id="image_valid_error" style="font-size:12px;display:none;" class="error"> Height and Width must be below 50PX X 50PX.</label>
							<label id="image_type_error" style="font-size:12px;display:none;" class="error"> Please select a valid Image file</label>
							</div>
                            </div>
							</li>
						
                        	
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="2"><span>Submit</span></button>
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
$('#addlistvalue_form').validate();
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>
<script type="text/javascript">
function Upload(files) {
    var fileUpload = document.getElementById("image");
 
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
 
        if (typeof (fileUpload.files) != "undefined") {
            
            var reader = new FileReader();

            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
               
                var image = new Image();
                image.src = e.target.result;
                       
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if (height > 50 || width > 50) {
						document.getElementById("image_valid_error").style.display = "inline";
						$("#image_valid_error").fadeOut(7000);
						$("#image").val('');
						$(".filename").text('No file selected');
						$("#image").focus();
                        return false;
                    } 
                    return true;
                };
            }
        } else {
            alert("This browser does not support HTML5.");
			$("#image").val('');
            return false;
        }
    } else {
       // alert("Please select a valid Image file.");
		document.getElementById("image_type_error").style.display = "inline";
		$("#image_type_error").fadeOut(7000);
		$("#image").val('');
		$("#image").focus();
        return false;
    }
}
</script>