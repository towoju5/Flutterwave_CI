<?php
$this->load->view('site/templates/header');
$this->load->view('site/templates/listing_head_side');
?>
<script type="text/javascript">
function list_amenities(evt)
{
if($(evt).is(":checked")){
	var am = $(evt).val();
	//$(".dashboard_price_right ul li").append('<li><a>Message Center</a></li>');
	$.ajax({
        type: 'POST',
        url: baseURL+'site/product/get_sublist_values',
        data: {"list_value_id":am},
        dataType:'json',
        success: function(response)
		{
       	 	//alert("cccccc");
       		$(evt).parents('li').append(response.amenities);
		}
        });
}
else 
{
//	alert("UNchecked");
	$(evt).parents('li').find('ul').remove();
}
}
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('input[name="all"]').bind('click', function(){
			var status = $(this).is(':checked');
			$('input[type="checkbox"]', $(this).parent('li')).attr('checked', status);
		});
	});
</script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<div class="right_side">

	<form name="amenities" method="post" onsubmit="return validate_form()" action="<?php echo base_url()."space_listing/".$listDetail->row()->id; ?>">
	
	
	
	<!-- site/product/saveAmenitieslist -->

		<?php 
		
		
		if($listItems->num_rows()>0) {
			
			$i=1;
			foreach($listItems->result() as $list){
		?>   
				<?php 
						$listValuesDisplayHead = $this->product_model->get_all_details(LIST_VALUES,array('list_id'=>$list->id));
						
					 if($listValuesDisplayHead->num_rows() > 0){ 

						
					?>
					
					
            <div class="dashboard_price_main amenities-main" style="<?php if($listValuesDisplayHead->num_rows()>0) { echo "display:block"; } else { echo "display:none"; } ?>">
            	<div class="dashboard_price">
					<?php if($listValuesDisplayHead->num_rows()>0){	 ?>
						<div class="dashboard_price_left">
							<h3><?php echo  $list->attribute_name; ?></h3>
							<p><?php echo $list->attribute_title; ?> </p>			
						</div>
					<?php } ?>


                    <div class="dashboard_price_right amitie-right">
                        <ul class="facility_listed">
						<?php /* <input type="checkbox" name="all" id="all" /> <label for='all'>All</label> */ ?>
                        <?php
                        $list_name = $listDetail->row()->list_name;
                        $facility = (explode(",", $list_name));
						$listValues = $this->product_model->get_all_details(LIST_VALUES,array('list_id'=>$list->id));
						if($listValues->num_rows()>0){	
							foreach($listValues->result() as $details){
						?>
                        <li>
								<label class="list-cur"><input type="checkbox" class="checkbox_check"  name="list_name[]" onclick="saveAmenitieslist();" id="amenities-<?php echo $details->id; ?>"   <?php if(in_array($details->id,$facility)) { ?> checked="checked" <?php } ?>value="<?php echo $details->id; ?>"/>
							<?php echo $details->list_value; ?></label>
						</li>
                        <?php
							}
						}
                        ?>
                     </ul>
                    </div>
                </div>
			<input type="hidden" name="countOfListVal" id="countOfListVal" value="Yes">
            </div>
			
			<?php } else {  echo "No Amenities in This List....!"; ?>
			<input type="hidden" name="countOfListVal" id="countOfListVal" value="No">
			<?php } ?>
		<?php 
		$i++;
			}?>
			
	
<?php		} else { 
				echo "The listing will be previewed after activating it in the admin...!"; ?>
			<input type="hidden" name="countOfListVal" id="countOfListVal" value="No">
		<?php }  	
		?>
		
		
		
			<div class="amnt_btn_nxt">
				<div class="col-sm-2"></div>
				<div class="col-sm-2"></div>
				<div class="col-sm-3" style="width:100%;" id="nxtbtnarea"><button type="submit"  class="next_button" ><?php if($this->lang->line('Next') != '') { echo stripslashes($this->lang->line('Next')); } else echo "Next";?></button></div>
			</div>
		

		
		<input type="hidden" name="id" id="property_id" value="<?php echo $listDetail->row()->id;?>" />
		
        <!--<input type="submit" value="<?php if($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save"; ?>" class="newline-btn" />-->

	</form>
</div>

<div class="calender_comments">
            
            	<div class="calender_comment_content">
                <div class="left-calender_comment">
                	<i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
                    </div>
					<div class="right-calender_comment">
                    <div class="calender_comment_text">
                    
                    	<h2><?php if($this->lang->line('Your Amenities') != '') { echo stripslashes($this->lang->line('Your Amenities')); } else echo "Your Amenities";?></h2>
                    
                    	<p><?php if($this->lang->line('This is for guest notice about the special features provided by you') != '') { echo stripslashes($this->lang->line('This is for guest notice about the special features provided by you')); } else echo "This is for guest notice about the special features provided by you";?>.</p>
                        <!--
                        <p><strong>It will only be shared with guests after a reservation is confirmed.</strong></p>
                        -->
                    
                    </div> </div>
                    
                    
                
                </div>
            
            </div>



<?php
$this->load->view('site/templates/footer');
?>
<script>
function validate_form()
{
	var countOfList=$("#countOfListVal").val();
	
	if (countOfList=='Yes'){
		var count=0;
		var a = document.getElementsByName("list_name[]");
		for(var i=0; i<a.length; i++)
		{
			if(a[i].checked == true)
				count++;
		}
		
		
		
		if(count==0)
		{
			alert("<?php 	if($this->lang->line('err_check_atleast_one') != '')
								{ 
									echo  stripslashes($this->lang->line('err_check_atleast_one')); 
								} 
								else
								{
									echo  "Please check atleast one amenities";
								} ?>");
			return false;
		}
	
}
			
}


function saveAmenitieslist()
{
	var str='';
	var id=$('#property_id').val();
	$("input[type=checkbox]").each(function() {
		if($(this).is(':checked')) {
			if($(this).val() != 'on')
			{
				str = str+','+$(this).val();
			}
		}
	});
	$.ajax(
	{
		type: 'POST',
		url: baseURL+'site/product/saveAmenitieslist_ajax',
		data:{'string':str,'id':id},
		success: function(data) 
		{
			
		}
		
	});
}
</script>