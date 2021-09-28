<?php
$this->load->view('admin/templates/header.php');
?>

<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add List Space Value</h6>
                        
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addlistvalue_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/listattribute/insertEditListSpaceValue',$attributes) 
					?>
                   
						<ul>
	 							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="list_name">Select List<span class="req">*</span></label>
							<div class="form_input">
		                      <select class="chzn-select required" name="list_name" tabindex="-1" style="width: 375px; display: none;" data-placeholder="Select List" >
		                      		<option value="">--Select--</option>
		                      		<?php 
									
		                      		foreach ($listspace_details->result() as $row){
		                      			if ($row->attribute_name!=''){
		                      		?>
		                      		<option value="<?php echo $row->id;?>"><?php echo $row->attribute_name;?></option>
		                      		<?php }}?>
		                      </select>
		                    </div>
							</div>
							</li>
	 							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="list_value">List Value<span class="req">*</span></label>
							<div class="form_input">
								<input name="list_value" id="list_value" type="text" tabindex="1" class="required large tipTop" title="Please enter the list space value"/><span id="list_value_valid" style="color:#f00;display:none;"> Only Characters are allowed!</span>
							</div>
							</div>
							</li>
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="list_description">List Description<span class="req">*</span></label>
							<div class="form_input">
								<input name="list_description" id="list_description" type="text" tabindex="1" class="required large tipTop" title="Please enter the list space value description"/>
							</div>
							</div>
							</li>
						
							<li>
							<div class="form_grid_12 form_chsfile">
							<label class="field_title" for="image">List Icon  <span class="req">*</span>  <span class="req">(Below 35*40) (H*W) </span></label>
							<div class="form_input">
							<input name="image" id="image" onchange="Upload(this.id);" type="file" tabindex="7" class=" required large tipTop" title="Please select image"/>
                            </div>
                            <label id="image_valid_error" style="margin-right: 17.5%;float: right;font-size:12px;display:none;" class="error"> Height and Width must be below 35PX X 40PX.</label>
							<label id="image_type_error" style="margin-right: 17.5%;float: right;font-size:12px;display:none;" class="error"> Please select a valid Image file</label>
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
                    if (height > 35 || width > 40) {
						document.getElementById("image_valid_error").style.display = "inline";
						$("#image_valid_error").fadeOut(9000);
						$("#image").val('');
						//document.getElementById(files).value = "";
						//document.getElementById("image").value = "";
						$("#image").focus();
						$(".filename").text('No file selected');
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
		$("#image_type_error").fadeOut(9000);
		$("#image").val('');
		$("#image").focus();
        return false;
    }
}
</script>