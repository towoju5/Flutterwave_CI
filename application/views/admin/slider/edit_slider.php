<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Slider</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'editslider_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/slider/insertEditSlider',$attributes) 
					?>
	 						<ul>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_name">Slider Name <span class="req">*</span> </label>
									<div class="form_input">
										<input name="slider_name" style=" width:295px" id="slider_name" value="<?php echo $slider_details->row()->slider_name;?>" type="text" tabindex="1" class="required tipTop" title="Please enter the slider name"/>
									    <span id="slider_name_valid" style="color:#f00;display:none;">Only Alphabets Allowed</span>

									</div>
								</div>
								</li>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="full_name">Slider Title <span class="req">*</span></label>
									<div class="form_input">
										<input name="slider_title" style=" width:295px" id="slider_title" value="<?php echo $slider_details->row()->slider_title;?>" type="text" tabindex="1" class="required tipTop" title="Please enter the slider title"/>
										<span id="slider_title_valid" style="color:#f00;display:none;">Special Characters Not Alllowed</span>

									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="image">Slider Image<span class="req">*</span></label>
									<div class="form_input">
										<input name="image" id="image" onchange="Upload(this.id);"  type="file" tabindex="7" class="required large tipTop" title="Please select slider image"/>
									</div>
									<div class="form_input"><img src="<?php echo base_url();?>images/slider/<?php echo $slider_details->row()->image;?>" width="100px"/><br>
									<span style="color:red;">Upload the Image Size 1349 X 484 or Above</span></div>
									
									
									<label id="image_valid_error" style="font-size:12px;display:none;" class="error"> Height and Width must be above 1349PX X 484PX.</label>
							<label id="image_type_error" style="font-size:12px;display:none;" class="error"> Please select a valid Image file</label>	
								
								</div>
								
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="slider_link">Slider Link <span class="req">*</span></label>
									<div class="form_input">
										<input name="slider_link" id="slider_link" type="url" value="<?php echo $slider_details->row()->slider_link;?>" tabindex="2" class="required large tipTop" title="Please enter the slider link"/>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="slider_desc">Slider Description </label>
									<div class="form_input">
										<textarea name="slider_desc" id="slider_desc" class=" large tipTop" title="Please enter the slider link"><?php echo $slider_details->row()->slider_desc;?></textarea>
									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" name="status" <?php if ($slider_details->row()->status == 'Active'){echo 'checked="checked"';}?> id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								<input type="hidden" name="slider_id" value="<?php echo $slider_details->row()->id;?>"/>
								</li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Update</span></button>

										<a href="<?php echo base_url()."admin/slider/display_slider_list"; ?>"><button type="button" class="btn_small btn_blue" tabindex="4"><span>Back</span></button></a>

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
	$('#editslider_form').validate();
</script>

<script type="text/javascript">
function Upload(files) {
    var fileUpload = document.getElementById("image");
 
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg)$");
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
					
                   if (height  < 484 || width < 1349) {
						document.getElementById("image_valid_error").style.display = "inline";
						$("#image_valid_error").fadeOut(9000);
						$("#image").val('');
						//document.getElementById(files).value = "";
						//document.getElementById("image").value = "";
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
		$("#image_type_error").fadeOut(9000);
		$("#image").val('');
		$("#image").focus();
        return false;
    }
}
</script>

<?php 
$this->load->view('admin/templates/footer.php');
?>
<script>
/* $("#slider_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z\s()&]/g)) {
	   document.getElementById("slider_name_valid").style.display = "inline";
	   $("#slider_name_valid").fadeOut(5000);
	   $("#slider_name").focus();
       $(this).val(val.replace(/[^a-zA-Z\s()&]/g, ''));
   }
});

$("#slider_title").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z0-9-\s&()/]/g)) {
	   document.getElementById("slider_title_valid").style.display = "inline";
	   $("#slider_title_valid").fadeOut(5000);
	   $("#slider_title").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9-\s&()/]/g, ''));
   }
}); */
</script>