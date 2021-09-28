<?php
$this->load->view('admin/templates/header.php');
 if (is_file('./fc_smtp_settings.php'))
{
	include('fc_smtp_settings.php');
}
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
						$attributes = array('class' => 'form_container left_label', 'id' => 'regitstraion_form','accept-charset'=>'UTF-8');
						echo form_open('admin/adminlogin/save_smtp_settings',$attributes) 
					?>
	 						<ul>
                <li>
                                      <div class="form_grid_12">
                                        <label class="field_title" for="smtp_protocol">Protocol</label>
                                        <div class="form_input">
                                          <input name="smtp_protocol" value="<?php echo $config['smtp_protocol'];?>" id="smtp_protocol" type="text" tabindex="1" class="large tipTop" title="Please enter the smtp host"/> <label id="smtp_protocol_error" style="display:none;" class="error"> Special Characters are not allowed!</label>
                                        </div>
                                      </div>
                                    </li>
								<li>
                                      <div class="form_grid_12">
                                        <label class="field_title" for="smtp_host">SMTP Host</label>
                                        <div class="form_input">
                                          <input name="smtp_host" value="<?php echo $config['smtp_host'];?>" id="smtp_host" type="text" tabindex="1" class="large tipTop" title="Please enter the smtp host"/> <label id="smtp_host_error" style="display:none;" class="error"> Special Characters are not allowed!</label>
                                        </div>
                                      </div>
                                    </li>
                                    
                                    <li>
                                      <div class="form_grid_12">
                                        <label class="field_title" for="smtp_port">SMTP Port</label>
                                        <div class="form_input">
                                          <input name="smtp_port" value="<?php echo $config['smtp_port'];?>" id="smtp_port" type="text" tabindex="1" class="large tipTop" title="Please enter the smtp port"/> <label id="smtp_port_error" style="display:none;" class="error"> Special Characters are not allowed!</label>
                                        </div>
                                      </div>
                                    </li>
                                    
                                    <li>
                                      <div class="form_grid_12">
                                        <label class="field_title" for="smtp_user">SMTP Email</label>
                                        <div class="form_input">
                                          <input name="smtp_user" value="<?php echo $config['smtp_user'];?>" id="smtp_user" type="email" tabindex="1" class="large tipTop" title="Please enter the smtp email id "/>
                                        </div>
                                      </div>
                                    </li>
                                    
                                    <li>
                                      <div class="form_grid_12">
                                        <label class="field_title" for="smtp_pass">SMTP Password</label>
                                        <div class="form_input">
                                          <input name="smtp_pass" value="<?php echo $config['smtp_pass'];?>" id="smtp_pass" type="password" tabindex="1" class="large tipTop" title="Please enter the smtp password"/>
                                        </div>
                                      </div>
                                    </li>
								
								
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue"><span>Save</span></button>
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
<?php 
$this->load->view('admin/templates/footer.php');
?>

<script>

$("#smtp_protocol").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z.:,-\s/]/g)) {
     document.getElementById("smtp_protocol_error").style.display = "inline";
     $("#smtp_protocol_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z.:,-\s/]/g, ''));
   }
});

$("#smtp_host").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z.:,-\s/]/g)) {
	   document.getElementById("smtp_host_error").style.display = "inline";
	   $("#smtp_host_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z.:,-\s/]/g, ''));
   }
});

$("#smtp_port").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^0-9-.\s]/g)) {
	   document.getElementById("smtp_port_error").style.display = "inline";
	   $("#smtp_port_error").fadeOut(5000);
       $(this).val(val.replace(/[^0-9-.\s]/g, ''));
   }
});

</script>