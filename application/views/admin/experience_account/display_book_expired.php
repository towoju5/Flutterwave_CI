<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
//echo "<pre>"; print_r($newbookingList->result()); die;
?>



<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/order/change_order_status_global',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						
					</div>
					<div class="widget_content">
						<table class="display display_tbl" id="subadmin_tbl">
						<thead>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
                            <th class="tip_top" title="Click to sort">
								 S No
							</th>
							<th class="tip_top" title="Click to sort">
								Booking No
							</th>
							<th class="tip_top" title="Click to sort">
								Date Added
							</th>
                           <th class="tip_top" title="Click to sort">
								Currency Type (Host)
							</th>
							<th class="tip_top" title="Click to sort">
								Amount (Host)
							</th>
							<th class="tip_top" title="Click to sort">
								Amount (Admin)
							</th>
							
							<th>
								Guest Email
							</th>
                           
							
							<th>
                            	Host Email 
                            </th>
							
							
                            
   							<th class="tip_top" title="Click to sort">
								Booking Status
							</th>

							<!-- <th>
								 Action
							</th> -->
						</tr>
						</thead>
						<tbody>
						<?php 
						if ($newbookingList->num_rows() > 0){
						$i=1;
							foreach ($newbookingList->result() as $row){
						?>
						<tr>
							<td class="center tr_select ">
								<input name="checkbox_id[]" type="checkbox" value="<?php echo $row->id;?>">
							</td>
                            <td class="center">
								<?php echo $i;?>
							</td>
							<td class="center">
								<?php echo $row->Bookingno;?>
							</td>
   							<td class="center">
								<?php echo date('d-m-Y',strtotime($row->dateAdded));?>
							</td>

							<td class="center">
								 		
										 <?php echo $row->currencycode;?>
										
									</td>
									<td class="center">
								 		
										 <?php echo $row->totalAmt;?>
										
									</td>
									<td class="center">
										<?php //echo $row->price;
										$unitPerCurrencySeller=$row->currencyPerUnitSeller;
									
										
										if($admin_currency_code!=$row->currencycode){
											//echo convertCurrency($row->currency_code,$admin_currency_code,$row->total);
											echo $admin_currency_symbol.' '.customised_currency_conversion($unitPerCurrencySeller,$row->totalAmt);
										}else
											echo $admin_currency_symbol.' '.$row->totalAmt;
									 

										?>
									</td>
							<td class="center">
								 <?php echo $row->email;?>
							</td>
						
							<td class="center">
								 <?php
								 $hostemail = $this->experience_account_model->get_all_details(USERS,array('id'=>$row->renter_id));
								  echo $hostemail->row()->email;
								 //echo $row->phone_no;
								 ?>
							</td>
							
							
							
							<td class="center">
							<span class="badge_style b_done">
								<?php
								
								$today =  date('Y-m-d',strtotime(date('Y-m-d', strtotime("-2 days"))));
								$today = $today.' 00:00:00';

								 $paymentstatus = $this->experience_account_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT,array('Enquiryid'=>$row->cid)); 

								$status = $paymentstatus->row()->status;
								
								
							
							 if($row->dateAdded < $today) { 
							 if($status=="Paid"){
								 echo "Booked"; 
							}else{
								echo "Expired"; 
							 }
							} 
							else {
								if($status=="Paid"){
								 echo "Booked";
								 }else{
									 echo "Pending";
									 }
							}  
					
							/* 	if($row->booking_status=='Pending')
								 echo "Pending & Expired"; //echo $row->booking_status;
								elseif($row->booking_status=='Booked')
								 echo "Booked & Expired"; //echo $row->booking_status;
								else
								 echo "Expired"; //echo $row->booking_status; */
								?>
									
								</span>
							</td>
							
						</tr>
                        
						<?php 
							$i++; }
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
                            <th class="tip_top" title="Click to sort">
								 S No
							</th>
							<th class="tip_top" title="Click to sort">
								Booking No
							</th>
                            <th class="tip_top" title="Click to sort">
								 Date Added	
							</th>
							<th class="tip_top" title="Click to sort">
								Currency Type (Host)
							</th>
							<th class="tip_top" title="Click to sort">
								Amount (Host)
							</th>
							<th class="tip_top" title="Click to sort">
								Amount (Admin)
							</th>
							<th>
								Guest Email
							</th>
                           
							
							<th>
                            	Host Email 
                            </th>
							
							
                            
   							<th class="tip_top" title="Click to sort">
								Booking Status
							</th>

						<!--	<th>
								 Action
							</th> -->
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