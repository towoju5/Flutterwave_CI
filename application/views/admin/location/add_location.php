<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New Location</h6>
                        <div id="widget_tab">
              				<ul>
               					 <li><a href="#tab1" class="active_tab">Content</a></li>
               					 <li><a href="#tab2">SEO</a></li>
             				 </ul>
            			</div>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm');
						echo form_open('admin/location/insertEditLocation',$attributes) 
					?> 		
                    	<div id="tab1">
	 						<ul>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="location_name">Country Name <span class="req">*</span></label>
									<div class="form_input">
                                    <input name="name" style=" width:295px" id="name" value="" type="text" tabindex="1" class="required tipTop" title="Please enter the location name"/><span id="name_valid" style="color:#f00;display:none;">Only Characters are allowed!</span>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="iso_code2">Country Code</label>
									<div class="form_input">
                                    <input name="country_code" style=" width:295px" id="country_code" value="" type="text" tabindex="1" class="tipTop" title="Please enter the iso_code2"/>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="iso_code3">Country Mobile Code </label>
									<div class="form_input">
                                    <input name="country_mobile_code" style=" width:295px" id="country_mobile_code" value="" type="text" tabindex="1" class=" tipTop" title="Please enter the iso_code3"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="language_code">Language</label>
									<div class="form_input">
                                    <select name="language_code">
                                    	<option value="">--Select--</option>
                                    <?php
									
									 
									  
										if($LanguageList->num_rows() > 0){
											foreach($LanguageList->result() as $Row){
												$SelVal='';
												 
												echo '<option value="'.$Row->lang_code.'" '.$SelVal.'>'.$Row->name.'</option>';
											}
										}
									
									
									 ?>
                                    </select>
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
								
                               <li style="display: none;">
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Default <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="8" name="status" id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								</li>
                               
								<input type="hidden" name="location_id" value=""/>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Submit</span></button>
									</div>
								</div>
								</li>
							</ul>
                        </div>
                        <div id="tab2">
              <ul>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_title">Meta Title</label>
                    <div class="form_input">
                      <input name="meta_title" id="meta_title" type="text" tabindex="1" class="large tipTop" title="Please enter the page meta title"/>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_tag">Meta Keyword</label>
                    <div class="form_input">
                      <textarea name="meta_keyword" id="meta_keyword"  tabindex="2" class="large tipTop" title="Please enter the page meta keyword"></textarea>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_description">Meta Description</label>
                    <div class="form_input">
                      <textarea name="meta_description" id="meta_description" tabindex="3" class="large tipTop" title="Please enter the meta description"></textarea>
                    </div>
                  </div>
                </li>
              </ul>
             <ul><li><div class="form_grid_12">
				<div class="form_input">
					<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Submit</span></button>
				</div>
			</div></li></ul>
			</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>

<script type="text/javascript">
	$('#commentForm').validate();
	
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>

<script>
/* $("#name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z.,|-\s()&/]/g)) {
	   document.getElementById("name_valid").style.display = "inline";
	   $("#name_valid").fadeOut(5000);
	   $("#name").focus();
       $(this).val(val.replace(/[^a-zA-Z.,|-\s()&/]/g, ''));
   }
}); */
</script>