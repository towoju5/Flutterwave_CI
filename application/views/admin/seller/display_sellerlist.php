<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/seller/change_seller_status_global',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						<?php 
						if ($allPrev == '1' || in_array('3', $Host)){
						?>
						<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Active','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to active records"><span class="icon accept_co"></span><span class="btn_link">Active</span></a>
							</div>
							<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Inactive','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to inactive records"><span class="icon delete_co"></span><span class="btn_link">Inactive</span></a>
							</div>
							<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to delete records"><span class="icon cross_co"></span><span class="btn_link">Delete</span></a>
							</div>
							<div class="btn_30_light" style="height: 29px;">
								<a href="admin/seller/customerExcelExport"  class="tipTop" title="Click Export All Host Details"><span class="icon cross_co"></span><span class="btn_link">Export All User</span></a>
							</div>
						<?php }?>
						</div>
						
					</div>
					<div class="widget_content">
						<table class="display" id="renter_tbl">
						<thead>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">							</th>
							<th class="tip_top" title="Click to sort">
								 First Name							</th>
							<th class="tip_top" title="Click to sort Last name">Last Name</th>
							 <th class="tip_top" title="Click to sort">
								 Email-ID							</th>
							<th>
								Image							</th>
							<!--<th class="tip_top" title="Click to sort">
								Phone Number							</th> -->
							<th class="tip_top" title="Click to sort" style="display:none"> <!--Temporary Hide..if we need we can unhide later -->
								Verify							
							</th>
							
							<th class="tip_top" title="Click to sort">
								Login User Type		
							</th>
							
							<th class="tip_top" title="Click to sort"> Host Created Date </th>
							<th class="tip_top" title="Click to sort"> Last Login Date </th>
							<th class="tip_top" title="Click to sort"> Last Login IP </th>
							<th class="tip_top" title="Click to sort"> ID Proof Status </th>
							<th class="tip_top" title="Click to sort">Status</th>
							<!--<th class="tip_top" title="Click to sort">Rep Code	</th>
								
							<th class="tip_top" title="Click to sort">Added By</th>-->
							<th width="12%"> Action	</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						//echo "<pre>"; print_r($sellersList->result_array());
						if ($sellersList->num_rows() > 0){
							foreach ($sellersList->result() as $row){
								//if($row->host_status!=1)
								if(1)
								{									
						?>
						<tr>
							<td class="center tr_select ">
								<input name="checkbox_id[]" type="checkbox" value="<?php echo $row->id;?>">							</td>
							<td class="center">
								<?php echo ucfirst($row->firstname);?>							</td>
							<td class="center"><?php echo ucfirst($row->lastname);?></td>
							  <td class="center">
								<?php echo $row->email;?>							</td>
							<td class="center">
							<div class="widget_thumb">
							<?php if($row->loginUserType == 'google' && strpos($row->image, 'http') !== false){ ?>								<img class="rollovereff" width="40px" height="40px" src="<?php echo $row->image;?>" /><?php } else if ($row->image != '' && file_exists('images/users/'.$row->image)){?>								 <img class="rollovereff" width="40px" height="40px" src="<?php echo base_url();?>images/users/<?php echo $row->image;?>" />							<?php }else{?>								 <img class="rollovereff" width="40px" height="40px" src="<?php echo base_url();?>images/users/user-thumb1.png" />							<?php }?>							</div></td>
							<!--<td class="center">
								 <?php echo $row->phone_no;?>							</td>-->
							
							<td class="center" style="display:none"><!-- Temporary Hide..if we need we can unhide later -->
							
								<!--<?php echo $row->name;?>-->
								<?php 
								$modeid = ($row->is_verified == 'Yes')?'0':'1';
								if ($modeid == '0'){
								?>
								<a title="Click to inactive" class="tip_top" href="javascript:confirm_status('admin/seller/verify_user_status/<?php echo $modeid;?>/<?php echo $row->id;?>');"><span class="badge_style b_done"><?php echo $row->is_verified;?></span></a>
								<?php
								}else {	
							?>
								<a title="Click to active" class="tip_top" href="javascript:confirm_status('admin/seller/verify_user_status/<?php echo $modeid;?>/<?php echo $row->id;?>')"><span class="badge_style"><?php echo $row->is_verified;?></span></a>
							<?php 
								}
							?>
							
							

								</td>
								
							<td class="center">
								 <?php
									if($row->loginUserType=='normal'){
										echo "E-mail";
									}else {
										echo ucfirst($row->loginUserType);
									}
									?>
							</td>
							<td class="center"><?php echo $row->created;?> </td>
							<td class="center"><?php echo $row->last_login_date;?> </td>
							<td class="center"><?php echo $row->last_login_ip;?> </td>
							
							<td class="center">
							<?php
								if ($row->id_proof_status==''){
									echo "Proof Not Sent"; ?>
							<?php }else{ 
									echo '<b>'.$row->id_proof_status . '</b>';	
								}
							 ?>							 
							</td>
							
							
						

						
							<td class="center">
							<?php 
							if ($allPrev == '1' || in_array('2', $Host)){
								$mode = ($row->status == 'Active')?'0':'1';
								if ($mode == '0'){
							?>
								<a title="Click to inactive" class="tip_top" href="javascript:confirm_status('admin/seller/change_user_status/<?php echo $mode;?>/<?php echo $row->id;?>');"><span class="badge_style b_done"><?php echo $row->status;?></span></a>
							<?php
								}else {	
							?>
								<a title="Click to active" class="tip_top" href="javascript:confirm_status('admin/seller/change_user_status/<?php echo $mode;?>/<?php echo $row->id;?>')"><span class="badge_style"><?php echo $row->status;?></span></a>
							<?php 
								}
							}else {
							?>
							<span class="badge_style b_done"><?php echo $row->status;?></span>
							<?php }?>							</td>
							<?php
							            $this->db->reconnect();
				                        $this->db->select('*');
				                        $this->db->from(SUBADMIN);
				                        $this->db->where('admin_rep_code',$row->rep_code);
										$result_u = $this->db->get();
							?>
							<!--
							<td class="center"><?php /*
							if($row->rep_code!='')
							{
								echo $row->rep_code;
								echo '<br>';
								echo '(';
								echo $result_u->row()->name;
								echo ')';
							}
							else
							{
								echo 'Not available';
							} */
							?> </td>
							
							
							<td class="center"><?php /*
							if($row->rep_code!='')
							{
								echo 'Representative';
								
							}
							else
							{
								echo 'Website';
							}*/
							?> </td> -->
							
<!-- 							<td class="center">
							<?php 
							if ($allPrev == '1' || in_array('2', $Host)){
								$mode = ($row->request_status == 'Approved')?'0':'1';
								if ($mode == '0'){
							?>
								<a title="Click to reject" class="tip_top" href="javascript:confirm_status('admin/seller/change_seller_status/<?php echo $mode;?>/<?php echo $row->id;?>');"><span class="badge_style b_done"><?php echo $row->request_status;?></span></a>
							<?php
								}else {	
							?>
								<a title="Click to approve" class="tip_top" href="javascript:confirm_status('admin/seller/change_seller_status/<?php echo $mode;?>/<?php echo $row->id;?>')"><span class="badge_style"><?php echo $row->request_status;?></span></a>
							<?php 
								}
							}else {
							?>
							<span class="badge_style b_done"><?php echo $row->status;?></span>
							<?php }?>
							</td>
 -->							<td class="center">
							<?php if ($allPrev == '1' || in_array('2', $Host)){?>
								<span><a class="action-icons c-edit" href="admin/seller/edit_seller_form/<?php echo $row->id;?>" title="Edit">Edit</a></span>
							<?php } if ($allPrev == '1' || in_array('1', $Host)){?>
								<span><a class="action-icons c-suspend" href="admin/seller/view_seller/<?php echo $row->id;?>" title="View">View</a></span>
							<?php }if ($allPrev == '1' || in_array('3', $Host)){?>	
								<span><a class="action-icons c-delete" href="javascript:confirm_delete('admin/seller/delete_seller/<?php echo $row->id;?>')" title="Delete">Delete</a></span>
							<?php }?>

							
							
							
							<span><a class="action-icons c-approve c_tick"  href="<?php echo base_url() . 'admin/seller/edit_seller_form/'.$row->id . '/Id_verify' ?>" title="Verify Proof"></a></span>	
							
							
							<!--  malar 12/07/2017 verify proof Old one -->
								<!--<span><a class="action-icons c-approve" href="admin/seller/verify_seller/<?php //echo $row->id;?>" title="Verify Proof"> Verify Proof</a></span>-->
							<!--  malar 12/07/2017 verify proof -->	
							
							</td>
						</tr>
						<?php 
							}
						}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">							</th>
							<th>
								 First Name							</th>
							<th>Last Name</th>
							 <th>
								 Email-ID						</th>
							<th>
								Image							</th>
							<!-- <th>
								Phone Number							</th>-->
							<th style="display:none">
							<!-- Temporary Hide..if we need we can unhide later -->
								Verify						
							</th>
							
							<th>
								Login User Type		
							</th>
							
							
							<th>Host Created Date </th>
							<th> Last Login Date </th>
							<th> Last Login IP </th>
							<th>  ID Proof Status </th>
							<th>Status	</th>
							<!--<th>Rep Code</th>
								
							<th>Added By</th>-->
							<th>Action	</th>
						</tr>
						</tfoot>
						</table>
				  </div>
				</div>
			</div>
			<input type="hidden" name="statusMode" id="statusMode"/>
			<input type="hidden" name="SubAdminEmail" id="SubAdminEmail"/>
		</form>	
			
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>