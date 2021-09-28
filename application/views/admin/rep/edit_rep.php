<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading?></h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addsubadmin_form','accept-charset'=>'UTF-8');
						echo form_open('admin/rep/insertEditRep',$attributes) 
					?>
	 						<ul>
							
							
							<?php 
							/*
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="type">Type<span class="req">*</span></label>
									<div class="form_input">
									
                                   <?php echo $admin_details->row()->admin_rep_type;?> 
								   
									</div> 
								</div>
							</li>
							*/?>
							
							<li id='repcode'>
								<div class="form_grid_12">
									<label class="field_title" for="Code">Rep. Code <span class="req">*</span></label>
									<div class="form_input">
									
									
				                 	<?php echo $admin_details->row()->admin_rep_code; ?>
									</div>
									
								</div>
							</li>
							
							
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="email">Email Address</label>
									<div class="form_input">
										<?php //echo $admin_details->row()->email;?>
										<input type="text" name="email" class="required large tipTop" placeholder="Please enter the email address" value="<?php echo $admin_details->row()->email;?>"  onChange="check_rep_email(this.value);"/>
										<label id="email_exist_error" class="error" style="display:none;">This Email Id Already Exist</label>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Name</label>
									<div class="form_input">
										<input type="text" name="name" id="name" class="required large tipTop" placeholder="Please enter the user name" value="<?php echo $admin_details->row()->name;?>"/> <label id="name_error" style="font-size:12px;display:none;" class="error">Numbers are not allowed</label>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Login Name</label>
									<div class="form_input">
										<?php echo $admin_details->row()->admin_name;?>
										<input type="hidden" name="admin_name" id="admin_name" value="<?php echo $admin_details->row()->admin_name;?>">
									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Registeration Date</label>
									<div class="form_input">
										<?php echo $admin_details->row()->created;?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Password Reset Count</label>
									<div class="form_input">
										<?php echo $admin_details->row()->password_reset_count;?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
								<div style="color:red" id="chechmsg"></div>
									<label class="field_title" for="site_contact_mail"></label>
									<div id="uniform-undefined" class="form_input checker focus">
										<span class="" style="float:left;"><input type="checkbox" class="checkbox" id="selectallseeker" /></span><label style="float:left;margin:5px;">Select all</label>
									</div>
								</div>
								<div style="margin-top: 20px;"></div>
								<div class="form_grid_12">
									<label class="field_title">Mangement Name</label>
									<table border="0" cellspacing="0" cellpadding="0" width="400">
								     	<tr>
								            <td align="center" width="15%">View</td>
								             <td align="center" width="15%">Add</td>
								              <td align="center" width="15%">Edit</td>
								               <td align="center" width="15%">Delete</td>
								        </tr>
								    </table>
								</div>
								<?php 
								/*  sizeof($adminPrevArr);
								 $subAdmin = $adminPrevArr[1]; 
								 echo '<pre>';
								 print_r($privArr);
								 echo '</pre>';*/
								  ?>
								<input type="hidden" value="<?php echo $admin_details->row()->id;?>" name="subadminid"/>
								<?php  //print_r($admin_details);
								 for($i=0;$i<sizeof($adminPrevArr); $i++) {
							  	 $subAdmin = $adminPrevArr[$i];  
							  	 $priv = array();
							  	 if (isset($privArr[$subAdmin])){
								  	 $priv = $privArr[$subAdmin];
							  	 }
							  	 /* if (!is_array($priv)){
							  	 	$priv = array();
							  	 } 
								
								 echo '<pre>';
								 print_r($priv);
								 echo '</pre>' */
							  	 ?>
								<div class="form_grid_12">
									<label class="field_title"><?php echo ucfirst($subAdmin) ?></label>
									<table border="0" cellspacing="0" cellpadding="0" width="400">
								     	<tr>
								        	<?php for($j=0;$j<4; $j++) { ?>
								        	<td align="center" width="15%">
								        	<span class="checkboxCon">
								<input class="caseSeeker" <?php if (in_array($j,$priv))/*if(isset($priv[$j]))*/{ echo 'checked="checked"';}?> 
		type="checkbox" id="checkbox" name="<?php echo $subAdmin.'[]';?>" id="<?php echo $subAdmin.'[]';?>"  value="<?php echo $j;?>" />
								        	</span>
								        	</td>
											<?php } ?>
								        </tr>
								    </table>
								</div>
								<?php } ?>
								</li>
								
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" onclick="return Checkbox();" tabindex="15"><span>Update</span></button>
									</div>
								</div>
								</li>
							</ul>
						</form>
						
						
						
						
						
						
											<!-- Start  Representative Text box-->	
<script type="text/javascript">
    $(function () {
        $("input[name='rep_type']").click(function () {
            if ($("#rep_type_representative").is(":checked")) {
                $("#repcode").show();
                $("#privileges").show();
				
            } else {
				
                $("#repcode").hide();
                $("#privileges").hide();
				
				 
            }
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $("input[name='rep_type']").click(function () {
            if ($("#rep_type_normal").is(":checked")) {
                
                $("#privileges2").show();
				
            } else {
				
                
                $("#privileges2").hide();
				
				 
            }
        });
    });
</script>

<script>
 /* $("#name").on('keyup', function(e) {
     var numers = /[0-9]+$/;
     var val = $(this).val();
	   if(numers.test(val)){
	   document.getElementById("name_error").style.display = "inline";
	   $("#name_error").fadeOut(5000);
       $(this).val(val.replace(/[0-9]+$/, ''));
   }
}); */

</script>
					<!--start subadmin email id check-->
					<script type="text/javascript">
						function check_rep_email(emailid){
							$.ajax({
								type: 'POST',
								data: 'email_id='+emailid,
								url: 'admin/subadmin/check_subadmin_email_exist',
								success: function(responseText){  
									if(responseText==1){
										document.getElementById("email_exist_error").style.display = "inline";
										
									}else{
										document.getElementById("email_exist_error").style.display = "none";
									}
								}
							});
						}
					</script>	
					<!--end subadmin email id check-->	

					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<script type="text/javascript">
checkboxInit();
</script>
<script type="text/javascript">
    function Checkbox() {
		
        var isChecked = $("#checkbox").is(":checked");
			if (isChecked) 
			{
				$('#chechmsg').html("");
				
               // alert("CheckBox checked.");
            } else {
				$('#chechmsg').html("Check any one field");
				return false;
                //alert("CheckBox not checked.");
            }
    };
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>