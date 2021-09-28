<?php
$this->load->view('admin/templates/header.php');
?>

<script type="text/javascript">
	function remove_img() {
		var list_value_id = $("#list_value_id").val();
		var img_name = $("#img_name").val();
		//alert(list_value_id+'--'+img_name);

		$.ajax({

	        type: 'POST',   

	        url:baseURL+'admin/attribute/remove_list_value_img',

	        data:{'list_value_id':list_value_id,'img_name':img_name},

	        success:function(response){
	        	//alert(response);
				window.location.reload();
	        }

	    });
	}
</script>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit List Value</h6>
                        
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
		                      		<option <?php if ($list_value_details->row()->list_id == $row->id){echo 'selected=""';}?> value="<?php echo $row->id;?>"><?php echo $row->attribute_name;?></option>
		                      		<?php }}?>
		                      </select>
		                    </div>
							</div>
							</li>
	 							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="list_value">List Value<span class="req">*</span></label>
							<div class="form_input">
								<input name="list_value" value="<?php echo $list_value_details->row()->list_value;?>" id="list_value" type="text" tabindex="1" class="required large tipTop" title="Please enter the list value"/><span id="list_value_valid" style="color:#f00;display:none;"> Only Characters are allowed!</span>
							</div>
							</div>
							</li>
							
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="image">List Icon <span class="req"> Below 50*50</span></label>
							<div class="form_input">
							<input name="image" id="image" type="file" tabindex="7" class="large tipTop" title="Please select list icon"/>
							</div>
							<div class="form_input text-center"><img src="<?php if($list_value_details->row()->image==''){ echo base_url().'images/users/user-thumb1.png';}else{ echo base_url();?>images/attribute/<?php echo $list_value_details->row()->image;}?>" width="100px"/><br>
							<?php if($list_value_details->row()->image!='')  {?>
							<input type='hidden' id='list_value_id'  name='list_value_id' value="<?php echo $this->uri->segment(4);?>">
							<input type="hidden" id="img_name" name='img_name' value="<?php echo $list_value_details->row()->image; ?>">
							 <span style='margin-left: 35px' class="action-icons c-delete " onclick="remove_img();" original-title="Delete">Delete</span></div>
							 <?php } ?>
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
                    <input type="hidden" name="lvID" value="<?php echo $list_value_details->row()->id;?>"/>
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

<script>
/* $("#list_value").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z-,\s]/g)) {
	   document.getElementById("list_value_valid").style.display = "inline";
	   $("#list_value").focus();
	   $("#list_value_valid").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z-,\s]/g, ''));
   }
}); */

</script>