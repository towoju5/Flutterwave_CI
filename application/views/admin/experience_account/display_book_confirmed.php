<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
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
								Guest Email ID
							</th>
                          
							<th>
                            	Host Email ID
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
										$expID = $row->experience_id;
									/*	$experience_price = $row->totalAmt;
										echo $admin_currency_symbol ;
										
										if($admin_currency_code != $row->currencycode && ($row->currencycode!='' || $row->currencycode!='0')){
											echo convertCurrency($row->currencycode,$admin_currency_code,$experience_price);	
										}else{
										echo $experience_price; }
*/
										?>
										
										<?php 
										
										$unitPerCurrencyUser=$row->currencyPerUnitSeller;
										
										
										if($admin_currency_code!=$row->currencycode){
											
											//echo convertCurrency($row->currency_code,$admin_currency_code,$row->total);
											echo $admin_currency_symbol.' '.customised_currency_conversion($unitPerCurrencyUser,$row->totalAmt);
										}else
											
											echo $admin_currency_symbol.' '.$row->totalAmt;
									 
										
										?>
										
									</td>
							<td class="center">
								 <?php echo $row->email;?>
							</td>
							<?php /*
							<td class="center">
								 <?php echo ($row->phone_no==0)?" ":$row->phone_no;?>
							</td>
							*/?>
							
							<td class="center">
								 <?php
								 $hostemail = $this->experience_account_model->get_all_details(USERS,array('id'=>$row->renter_id));
								  echo $hostemail->row()->email;
								 //echo $row->phone_no;
								 ?>
							</td>
							<?php /*
							<td class="center">
								 <?php
								 $hostemail = $this->experience_account_model->get_all_details(USERS,array('id'=>$row->renter_id));
								  echo ($hostemail->row()->phone_no==0)?" ":$hostemail->row()->phone_no;
								 //echo $row->phone_no;
								 ?>
							</td>
							*/?>
							
							<td class="center">
							<span class="badge_style b_done"><?php echo ($row->status=="Paid")?"Booked":"Pending"; //echo $row->status; //$row->booking_status;?></span>
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