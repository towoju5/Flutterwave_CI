<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Prefooter</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'editslider_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');
						echo form_open_multipart('admin/prefooter/insertEditprefooter',$attributes) 
					?>
	 						<ul>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="footer_title">prefooter Title <span class="req">*</span></label>
									<div class="form_input">
										<input name="footer_title" id="footer_title" type="text" tabindex="1" required class="required large tipTop" title="Please enter the prefooter name" value="<?php echo $prefooter_details->row()->footer_title;?>"/>
										<span id="footer_title_error" style="color:#f00;display:none;">Special Characters Not Allowed</span>

									</div>
								</div>
								</li>
								<!--li>
								<div class="form_grid_12">
									<label class="field_title" for="short_desc_count">Prefooter Excerpt Count </label>
									<div class="form_input">
										<input name="short_desc_count" id="short_desc_count" type="text" tabindex="2" class="large tipTop" title="Please excerpt count" value="<?php //echo $prefooter_details->row()->short_desc_count;?>" disabled="disabled">
										<input name="short_desc_count" id="short_desc_count" type="hidden" tabindex="2" class="large tipTop" title="Please excerpt count" value="<?php //echo $prefooter_details->row()->short_desc_count;?>">
									</div>
								</div>
								</li-->
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="prefooter_link">prefooter Link </label>
									<div class="form_input">
										<input name="footer_link" id="footer_link"  type="url" tabindex="2" class="required large tipTop" title="Please enter the prefooter link" value="<?php echo $prefooter_details->row()->footer_link;?>">
										<label class="error">Example: http://www.domain.com </label>
									</div>
								</div>
								</li>
								<li>
								<!--div class="form_grid_12">
									<label class="field_title" for="prefooter_link">Prefooter Short Description <span class="req">*</span></label>
									<?php //$short_descs=explode('//',$prefooter_details->row()->short_description);
									//for($i=1;$i<=count($short_descs);$i++){?>
									<div class="form_input">
										<input name="short_desc_count<?php //echo $i;?>"  type="text" tabindex="2" class="required large tipTop" title="Please enter the prefooter link" value="<?php //echo $short_descs[$i-1];?>">
									</div>
									<?php //}?>
								</div-->
								<div class="form_grid_12">
									<label class="field_title" for="prefooter_link">prefooter Description <span class="req">*</span></label>
									<div class="form_input">
										<textarea required  maxlength="250"  id="prefooter_description" onkeyup="char_countPreFooter(this)" name="description"><?php echo $prefooter_details->row()->description;?></textarea>
									</div>
									
							<?php
							$string = str_replace(' ', '', $prefooter_details->row()->description);
							$len=mb_strlen($string, 'utf8');
							$remaining=(250-$len);
							?>
							<br><span class="small_label we_do_sl" style="margin-left: 345px"><span id="prefooter_description_char_count"><?php echo $remaining; ?></span>characters remaining</span>
									
									
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="image">prefooter Icon <br><br> <span class="req"> * Below 130*130 and JPG,PNG,JPEG  </span><br></label>
									<div class="form_input">
										<input name="image" id="image" onchange="Upload(this.id);" type="file" tabindex="7" class="large tipTop" title="Please select prefooter image"/>
									</div>
									<div class="form_input"><img src="<?php echo base_url();?>images/prefooter/<?php echo $prefooter_details->row()->image;?>" width="100px"/></div>
									
									<label id="image_valid_error" style="font-size:12px;display:none;" class="error"> Height and Width must be below 130PX X 130PX.</label>
							<label id="image_type_error" style="font-size:12px;display:none; margin-left:345px" class="error"> Please select a valid Image file</label>
									
								</div>
								</li>
					            <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" name="status" <?php if ($prefooter_details->row()->status == 'Active'){echo 'checked="checked"';}?> id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								<input type="hidden" name="prefooter_id" value="<?php echo $prefooter_details->row()->id;?>"/>
								</li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" onclick="return checkUrl();" tabindex="4"><span>Update</span></button>

										<a href="<?php echo base_url()."admin/prefooter/display_prefooter_list"; ?>"><button type="button" class="btn_small btn_blue" tabindex="4"><span>Back</span></button></a>
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
function checkUrl()
{
	var str = $("#footer_link").val();
	if(str.indexOf('"') == -1)
	{
		return true;
	}
	else
	{
		alert('Kindly check the URL!');
		return false;
	}
}
</script>


<script type="text/javascript">
function Upload(files) {
    var fileUpload = document.getElementById("image");
 
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.jpeg)$");
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
                    if (height > 130 || width > 130) {
						document.getElementById("image_valid_error").style.display = "inline";
						$("#image_valid_error").fadeOut(9000);
						$("#image").val('');
						$(".filename").text('No file selected');
						
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
<script>
function char_countPreFooter(obj){
	value_str=obj.value.trim();
	var length = value_str.length;
	var maxlength = $(obj).attr('maxlength');
	var id = obj.id;
	var length = maxlength-length;
	$('#prefooter_description_char_count').text(length);
}
</script>

<?php 
$this->load->view('admin/templates/footer.php');
?>
<script>
/* $("#footer_title").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z0-9-\s&()]/g)) {
	   document.getElementById("footer_title_error").style.display = "inline";
	   $("#footer_title_error").fadeOut(5000);
	   $("#footer_title").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9-\s&()]/g, ''));
   }
}); */
</script>