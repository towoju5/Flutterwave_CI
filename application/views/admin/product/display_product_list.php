<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/product/change_product_status_global',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
				
						<?php if ($allPrev == '1' || in_array('2', $Properties)){?>
							<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Publish','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to publish records"><span class="icon accept_co"></span><span class="btn_link">Publish</span></a>
							</div>
							<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('UnPublish','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to unpublish records"><span class="icon delete_co"></span><span class="btn_link">UnPublish</span></a>
							</div>
						<?php 
						}
						if ($allPrev == '1' || in_array('3', $Properties)){
						?>
							<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to delete records"><span class="icon cross_co"></span><span class="btn_link">Delete</span></a>
							</div>
						<?php }?>
						<div class="btn_30_light" style="height: 29px;">
								<a href="admin/product/customerExcelExport"  class="tipTop" title="Click export all property list"><span class="icon cross_co"></span><span class="btn_link">Export All Property</span></a>
						</div>
						</div>
						
					</div>
					
					<div class="widget_content">
						<table class="display display_tbl" id="subadmin_tbl">
						<thead>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							
							<th class="tip_top" title="Click to sort">
								 Property Id
							</th>
							
							<th class="tip_top" title="Click to sort">
								 Property Name
							</th>
							
							<th class="tip_top" title="Click to sort">
								 Currency Type (Host)
							</th>
							<th class="tip_top" title="Click to sort">
								 Property Type
							</th>
							<th class="tip_top" title="Click to sort">
								Price (Host)
							</th>
							<th class="tip_top" title="Click to sort">
								Price (Admin)
							</th>
							<th class="tip_top" title="Click to sort">
								Added By
							</th>							
							<th class="tip_top" title="Click to sort">
								Status
							</th>
							<th class="tip_top" title="Click to sort">
								Property Created On
							</th>
							<th width="15%">
								 Action
							</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						if ($productList->num_rows() > 0){
							//print_r($productList->result());exit;
							foreach ($productList->result() as $row){
								$img = 'dummyProductImage.jpg';
								$imgArr = explode(',', $row->PImg);
								if (count($imgArr)>0){
									foreach ($imgArr as $imgRow){
										if ($imgRow != ''){
											$img = $imgRow;
											break;
										}
									}
								}
								
								
								
						?>
						<tr>
							<td class="center tr_select ">
								<input name="checkbox_id[]" type="checkbox" value="<?php echo $row->id;?>">
							</td>
							
							<td class="center">	
								 <?php echo $row->id;?>
							</td>
							
							
							<td class="center">
								<?php echo ucfirst($row->product_title); 
								?>
							</td>
							
							<td class="center">
						 		
								 <?php echo $row->currency;?>
								
							</td>
							
							<td>
							<?php $listings_hometype = $this->product_model->get_all_details('fc_listspace_values',array('id'=>$row->home_type)); 
								if($listings_hometype->row()->list_value == '' )  { echo '-'; } else {
								echo ucfirst($listings_hometype->row()->list_value); } ?>
							</td>
							<td class="center">
								 		
										 <?php echo $row->currency_symbols." ". $row->price;?>
										
									</td>
							<td class="center">
								<?php //echo $row->price;
								//echo $admin_currency_symbol ;
								if($admin_currency_code != $row->currency && ($row->currency!='' || $row->currency!='0'))
								{
									echo $admin_currency_symbol.' '.convertCurrency($row->currency,$admin_currency_code,$row->price);	
								}	
								else
								{	echo $admin_currency_symbol.' '.$row->price; }
								//echo $admin_currency_code;
								?>
							</td>
							
							<td class="center">
								<?php 
								if ($row->firstname != ''){
									echo '<b>'.$row->firstname.'</b> ('.$row->lastname.')';
								}else {
									echo 'Admin';
								}
								?>
							</td>
						
							<td class="center">
							<?php 
							if ($allPrev == '1' || in_array('2', $Properties)){
								$mode = ($row->status == 'Publish')?'0':'1';
								if ($mode == '0'){
							?>
								<a title="Click to unpublish" class="tip_top" href="javascript:confirm_status('admin/product/change_product_status/<?php echo $mode;?>/<?php echo $row->id;?>'); " onclick="email_unpublish('<?php echo $row->email; ?>','<?php echo $row->firstname; ?>','<?php echo $row->product_title; ?>')"><span class="badge_style b_done"><?php echo $row->status;?></span></a>
							<?php
								}else {	
							?>
								<a title="Click to publish" class="tip_top" href="javascript:confirm_status('admin/product/change_product_status/<?php echo $mode;?>/<?php echo $row->id;?>')" onclick="email_publish('<?php echo $row->email; ?>','<?php echo $row->firstname; ?>')"><span class="badge_style"><?php echo $row->status;?></span></a>
							<?php 
								}
							}else {
							?>
							<span class="badge_style b_done"><?php echo $row->status;?></span>
							<?php }?>
							</td>
							<td class="center">
								<?php echo $row->created;?>
							</td>
							<td class="center">
							<?php if ($allPrev == '1' || in_array('2', $Properties)){?>
								<span><a class="action-icons c-edit" href="admin/product/add_product_form/<?php echo $row->id;?>" title="Edit">Edit</a></span>
                                <!--<span><a class="action-icons1 c1-edit1" href="javascript:confirm_delete('admin/product/delete_product/<?php echo $row->id;?>')" title="Calender">Delete</a></span>-->
                                
       <span><a class='iframe' href="<?php echo base_url();?>admin/product/view_calendar/<?php echo $row->id;?>/<?php echo $row->price;?>/<?php echo $row->currency;?>"><span style="margin-bottom:-10px;" class="action-icons1 c1-edit1 tipTop" title="Calender"></span></a></span>                         
                                
							<?php }?>
								<span><a class="action-icons c-suspend" href="admin/product/view_product/<?php echo $row->id;?>" title="View">View</a></span>
                                <span>
                                <a class="iframe cboxElement action-icons c-search" href="https://maps.google.com/?q=<?php echo $row->latitude;?>,<?php echo $row->longitude;?>&amp;ie=UTF8&amp;t=m&amp;z=14&amp;ll=<?php echo $row->latitude;?>,<?php echo $row->longitude;?>&amp;output=embed" title="Map">Map</a>
                                </span>
							<?php if ($allPrev == '1' || in_array('3', $Properties)){
									$booked_status = $this->db->select('*')->from('fc_rentalsenquiry')->where('prd_id',$row->id)->where('approval','Accept')->get();
								if($booked_status->num_rows() == 0){
								?>	
								<span><a class="action-icons c-delete" href="javascript:confirm_delete('admin/product/delete_product/<?php echo $row->id;?>')" title="Delete">Delete</a></span>
							<?php } }?>
                             <?php if ($allPrev == '1' || in_array('2', $Properties)){?>
                            <?php if($row->featured=='UnFeatured'){ ?>
                            <span id="feature_<?php echo $row->id;?>"><a class="c-unfeatured" href="javascript:ChangeFeatured('Featured','<?php echo $row->id;?>')" title="Click To Featured">Un-Featured</a></span>
                            <?php }else{ ?>
                            <span id="feature_<?php echo $row->id;?>"><a class="c-featured" href="javascript:ChangeFeatured('UnFeatured','<?php echo $row->id;?>')" title="Click To Un-Featured" >Featured</a></span>
                            <?php } ?>
                           
                            <?php }?>
							</td>
						</tr>
						<?php 
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							
							<th><span class="tip_top">Property Id</span></th>
							
							<th>
								  Property Name
							</th>
							
							
							<th><span class="tip_top">
							 Currency Type (Host) </span></th>
							
							<th class="tip_top" >
								Property Type
							</th>
							
							<th>
								Price (Host)
							</th>
							<th class="tip_top" >
								Price (Admin)
							</th>
							<th>
								Added By
							</th>
<!--							<th>
								Order
							</th>
 							<th>
								Comments
							</th>
 -->							<th>
								Status
							</th>
							<th>
								Property Created On
							</th>
							<th>
								Action
							</th>
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

<script type="text/javascript">     
function search_category()
{
	
	var city = $('#search_city').val();
	var status = $('#search_status').val();
	var checkin = $('#search_checkin').val();
	var checkout = $('#search_checkout').val();
	var id = $('#search_renters').val();
	window.location.href = "<?php echo base_url();?>admin/product/display_product_list?status="+status+"&city="+city+"&checkin="+checkin+"&checkout="+checkout+"&id="+id;
	$_GET['status'],$_GET['city'],$_GET['checkin'],$_GET['checkout'],$_GET['id']
}
</script>
<script type="text/javascript">
function email_publish(email,firstname,product_title) 
{	
var email =email;	
var firstname = firstname;
var product_title = product_title;
			
$.ajax(		
{			
type: 'POST',			
url: "<?php echo base_url();?>admin/product/publish_mail",			
data: {'email':email,'firstname':firstname,'product_title':product_title},						
success: function(data) 			
{					
			
}		
});
}
function email_unpublish(email,firstname,product_title)
{	
var email =email;	
var firstname = firstname;
var product_title = product_title;
				
$.ajax(		
{			
type: 'POST',			
url: "<?php echo base_url();?>admin/product/unpublish_mail",			
data: {'email':email,'firstname':firstname,'product_title':product_title},						
success: function(data) 			
{
	
}		
});
}              
 </script>
<?php 
$this->load->view('admin/templates/footer.php');
?>




