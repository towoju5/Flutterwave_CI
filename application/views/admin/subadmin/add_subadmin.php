<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add Sub-admin</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addsubadmin_form','accept-charset'=>'UTF-8');
						echo form_open('admin/subadmin/insertEditSubadmin',$attributes) 
					?>
	 						<ul>
							
							<input type="hidden" name="rep_type" id="rep_type_normal" value="Normal" required checked="checked"/>
                                   

							<?php
							$gt='REP';
							if($gt='REP')
							{
							?>
							<li id='repcode' style="display:none;">
								<div class="form_grid_12">
									<label class="field_title" for="Code">Code <span class="req">*</span></label>
									<div class="form_input">
					<input name="rep_Code" id="rep_Code" type="text" tabindex="3" class="required large tipTop"
value="<?php $gt='REP'; $ns=date('s'); $nn=rand(00009,00001);  $n=$nn+$ns; $gtcode=str_pad($n+1, 5, "0", STR_PAD_LEFT);
 echo $gt.$gtcode; ?>" readonly />
									</div>
									
								</div>
							</li>
							<?php } else{
								?>
								<li id='repcode'>
								<div class="form_grid_12">
									<label class="field_title" for="Code">Code <span class="req">*</span></label>
									<div class="form_input">
					<input name="rep_Code" id="rep_Code" type="text" tabindex="3" class="required large tipTop"
value="<?php $gt='REP'; $ns=date('s'); $nn=rand(00009,00001);  $n=$nn+$ns; $gtcode=str_pad($n+1, 5, "0", STR_PAD_LEFT);
 echo $gt.$gtcode; ?>" readonly />
									</div>
									
								</div>
							</li>
							<?php }?>
							
							
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="email">Email Address <span class="req">*</span></label>
									<div class="form_input">
										<input name="email" id="email" type="text" tabindex="1" class="required large tipTop" title="Please enter the sub admin email address"  placeholder="Please enter the sub admin email address" onChange="check_subadmin_email(this.value);"/>
										<label id="email_exist_error" class="error" style="display:none;">This Email Id Already Exist</label>
									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="name">Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="name" id="name" type="text" tabindex="2" maxlength="50" class="required large tipTop" title="Please enter the sub admin username" placeholder="Please enter the sub admin username"/> <label id="name_error_len" class="error" style="display:none;">Only 50 Characters allowed</label>
									</div>
								</div>
								</li>
								
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Login Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="admin_name" id="admin_name" type="text" tabindex="3" class="required large tipTop" title="Please enter the sub admin username" placeholder="Please enter the sub admin username" onChange="check_subadmin_loginname(this.value);"/> <label id="admin_name_error_len" style="display:none;" class="error"> Special Characters are not allowed</label>
										<label id="loginname_exist_error" class="error" style="display:none;">This Login Name Already Exist</label>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="site_contact_mail">Password <span class="req">*</span></label>
									<div class="form_input">
										<input name="admin_password" id="admin_password" type="password" placeholder="Please enter the password" tabindex="4" class="required large tipTop" title="Please enter the password" maxlength="10" />
									</div>
								</div>
								</li>
								
								
								
								

								<li>
								<div class="form_grid_12">
									<label class="field_title" for="confirm_password">Confirm Password <span class="req">*</span></label>
									<div class="form_input">
										<input name="confirm_password" id="confirm_password" type="password" tabindex="5" class="required large tipTop" title="Please re-type the above password" placeholder="Please re-type the above password" maxlength="10"/>
									</div>
								</div>
								</li>
								
								
								
								
								
								
								<?php 
								sizeof($adminPrevArr);
								$subAdmins = $adminPrevArr[1];
								//echo $subAdmins;
									?>
								
								
								
								<?php
								if($gt='REP')
							    { ?>
								<!--<li id="privileges" style="display:none;">-->
								<li id="privileges">
								<div style="color:red" id="chechmsg"></div>
								<div class="form_grid_12">
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
								#echo "<pre>"; print_r($adminPrevArr); die;
								 for($i=0;$i<sizeof($adminPrevArr); $i++) {
							  	 $subAdmin = $adminPrevArr[$i];  ?>
								 
								 
								 
								 <?php 
								/*  sizeof($adminPrevArr);
								 $subAdmin = $adminPrevArr[1]; */
								  ?>
								
								<div class="form_grid_12">
									<label class="field_title"><?php echo ucfirst($subAdmin) ?></label>
									<table border="0" cellspacing="0" cellpadding="0" width="400">
								     	<tr>
										
										
										
								        	<?php for($j=0;$j<4; $j++) { ?>
								        	<td align="center" width="15%">
								        		<span class="checkboxCon">
		<input class="caseSeeker" id="checkbox" type="checkbox" name="<?php echo $subAdmin.'[]';?>" id="<?php echo $subAdmin.'[]';?>" 
		value="<?php echo $j; ?>" />
								        		</span>
								        	</td>
											<?php } ?>
								        </tr>
								    </table>
								</div>
								<?php } ?>
								</li>
								<?php } else { ?>
								<li id="privileges">
								<div style="color:red" id="chechmsg"></div>
								<div class="form_grid_12">
								
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
								#echo "<pre>"; print_r($adminPrevArr); die;
								 for($i=0;$i<sizeof($adminPrevArr); $i++) {
							  	 $subAdmin = $adminPrevArr[$i]; ?>
								 
								 
								 
								 <?php 
								 /* sizeof($adminPrevArr);
								 $subAdmin = $adminPrevArr[1]; */								 
								  ?>
								
								<div class="form_grid_12">
									<label class="field_title"><?php echo ucfirst($subAdmin) ?></label>
									<table border="0" cellspacing="0" cellpadding="0" width="400">
								     	<tr>
										
										
										
								        	<?php for($j=0;$j<4; $j++) { ?>
								        	<td align="center" width="15%">
								        		<span class="checkboxCon">
		<input class="caseSeeker" id="checkbox" type="checkbox" name="<?php echo $subAdmin.'[]';?>" id="<?php echo $subAdmin.'[]';?>" 
		value="<?php echo $subAdmin;?>" />
								        		</span>
								        	</td>
											<?php } ?>
								        </tr>
								    </table>
								</div>
								<?php } ?>
								</li>
								<?php } ?>
								
									
									
									<!--<li id="privileges2">
								<div class="form_grid_12">
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
								#echo "<pre>"; print_r($adminPrevArr); die;
								for($i=0;$i<sizeof($adminPrevArr); $i++) {
							  	 $subAdmin = $adminPrevArr[$i]; ?>
								<div class="form_grid_12">
									<label class="field_title"><?php echo ucfirst($subAdmin) ?></label>
									<table border="0" cellspacing="0" cellpadding="0" width="400">
								     	<tr>
										
										
										
								        	<?php for($j=0;$j<4; $j++) { ?>
								        	<td align="center" width="15%">
								        		<span class="checkboxCon">
		<input class="caseSeeker" type="checkbox" name="<?php echo $subAdmin.'[]';?>" id="<?php echo $subAdmin.'[]';?>" 
		value="<?php echo $j;?>" />
								        		</span>
								        	</td>
											<?php } ?>
								        </tr>
								    </table>
								</div>
								<?php } ?>
								</li>-->
									
								
								
								
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" onclick="Checkbox();" tabindex="15"><span>Submit</span></button>
									</div>
								</div>
								</li>
							</ul>
						</form>
						
						
					<!-- Start  Representative Text box-->	
<script type="text/javascript">
    $(function () {
        /*$("input[name='rep_type']").click(function () {
            if ($("#rep_type_representative").is(":checked")) {
                $("#repcode").show();
                $("#privileges").show();
				
            } else {
				
                $("#repcode").hide();
                $("#privileges").hide();
				
				 
            }
        });*/
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
<script type="text/javascript">
    function Checkbox() {
        var isChecked = $("#checkbox").is(":checked");
			if (isChecked) 
			{
				$('#chechmsg').html("");
                //alert("CheckBox checked.");
            } else {
				$('#chechmsg').html("Check any one field");
                //alert("CheckBox not checked.");
            }
    };
</script>		
			
<script>
$("#name").on('keypress', function(e) {
    var val = $(this).val();
   if(val.length == 50){
	   document.getElementById("name_error_len").style.display = "inline";
	   $("#name_error_len").fadeOut(5000);
   }
});

/* $("#admin_name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z.\s()]/g)) {
	   document.getElementById("admin_name_error").style.display = "inline";
	   $("#admin_name_error").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z.\s()]/g, ''));
   }
}); */
</script>			
			
			
			
			<script type="text/javascript">
    /* $(function () {
        $("input[name='rep_type']").click(function () {
			
            if ($("#rep_type_representative").is(":checked")) {
				
				var radioValue = $("input[name='rep_type']:checked").val();
                  if(radioValue){
                alert("Your are a - " + radioValue);
            }
                $("#repcode").show();
            } else {
				
				var radioValue = $("input[name='rep_type']:checked").val();
                  if(radioValue){
                alert("Your are a - " + radioValue);
                 }
                $("#repcode").hide();
				
				
            }
        });
    }); */
</script>
			
			<!-- End  Representative Text box-->	
					<!--start subadmin email id check-->
					<script type="text/javascript">
						/*this function is to check Email Id already exist are not*/
						function check_subadmin_email(emailid){
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
						/*this function is to check login name already exist are not*/
						function check_subadmin_loginname(admin_name){
							$.ajax({
								type: 'POST',
								data: 'admin_name='+admin_name,
								url: 'admin/subadmin/check_subadmin_loginname_exist',
								success: function(responseText){  
								
									if(responseText==1){
										document.getElementById("loginname_exist_error").style.display = "inline";
									}else{
										document.getElementById("loginname_exist_error").style.display = "none";
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
<?php 
$this->load->view('admin/templates/footer.php');
?>