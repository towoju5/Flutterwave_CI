
<script type="text/javascript">
    //Add new kit
function add_kit(){

    var main_title       = $("#main_title").val();
    var detailed_title   = $("#detailed_title").val();
    var kit_description  = $("#kit_description").val();
    var kit_count        = $("#kit_count").val();
    var experience_id    = $("#experience_id").val();

    if(main_title!='' && detailed_title!='' && kit_description!=''){
        $.ajax({
        type:'POST',
        url:'<?php echo base_url()?>site/experience/saveKit',
        data:{main_title:main_title,kit_count:kit_count,detailed_title:detailed_title,kit_description:kit_description,experience_id:experience_id},
        dataType:'json',
        success:function(data)
        {
            if(data.case == 1){
                //$("div.added").fadeIn(300).delay(1500).fadeOut(400);
                //$("#package_table").load(location.href + " #package_table");
				alert('Item is added successfully');
                window.location.reload();
             }
             else if(data.case == 2){
                //$("div.updated").fadeIn(300).delay(1500).fadeOut(400);
                //$("#package_table").load(location.href + " #package_table");
				alert('Item is added successfully');
                window.location.reload();
             }
             else if(data.case == 3){
                alert('Already Exists');
             }
              else if(data.case == 4){
                alert('Not Valid Times');
                $('#main_title').val('');
                $('#detailed_title').val('');
                $('#kit_description').val('');
             }
        }
        });
    }
    else{
         $('#error_what_you_will_provide').fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow');
		 });
		 return false;
    }
}

/* edit existing kit content  starts */
function get_activity_data(kit_id,kit_title,kit_detailed_title,kit_count,kit_description) {
           
$('.add_new_item').show();
continue_button_manage('hide');

    $('#kit_id').val(kit_id);
    $('#main_title').val(kit_title);
    $('#detailed_title').val(kit_detailed_title);
    $('#kit_count').val(kit_count);
    $('#kit_description').val(kit_description);

    //$('#child_price').val(child_price);
    
    $('#add_btn_1').hide();
    $('#update_btn_1').show();
    $('#reset_btn').show();
return false;
}

function update_tab2()
{
    var kit_id = $('#kit_id').val();
    var main_title = $('#main_title').val();
    var detailed_title = $('#detailed_title').val();
    var kit_count = $('#kit_count').val();
    var kit_description = $('#kit_description').val();
    var experience_id = $('#experience_id').val();
    
    if(main_title == '' || detailed_title == ''  || kit_count == '' || kit_description == '' ){
          $('#error_what_you_will_provide').fadeIn('slow', function () {
			$(this).delay(5000).fadeOut('slow');
		 });
		 return false;
    }

    else{
            $.ajax
            ({
            url: '<?php echo base_url(); ?>site/experience/update_kit',
            type: 'POST',
            data: {kit_id:kit_id,main_title:main_title,detailed_title:detailed_title,kit_count:kit_count,experience_id:experience_id,kit_description:kit_description},
            dataType:'json',
            success: function(data) {
                //alert(data.case);
                 if(data.case == 1){
                    $("div.added").fadeIn(300).delay(5500).fadeOut(400);
                    $("#package_table").load(location.href + " #package_table");
                    window.location.reload();
                 }
                 else if(data.case == 2){
                    $("div.updated").fadeIn(300).delay(2500).fadeOut(400);
                    $("#package_table").load(location.href + " #package_table");
                    window.location.reload();
                 }
                 else if(data.case == 3){
                    alert('Already Exists');
					 /*$('#error_what_you_will_provide').fadeIn('slow', function () {
						$(this).delay(5000).fadeOut('slow');
					 });*/
                 }
                  
            }
         });
    }

}

function reset_reload(){
	$('.add_new_item').hide();
	continue_button_manage('show');
 //window.location.reload();
}
function add_new_item(){
	$('.add_new_item').show();
	continue_button_manage('hide');
	document.getElementById("overviewlist").reset();
}

</script>

			<div class="right_side overview schedule-experience">
				<div class="dashboard_price_main" style="border-bottom:none;">
                <div class="dashboard_price">
            
                    <div class="dashboard_price_left">
                    
                        <h3><?php if($this->lang->line('experience_details') != '') { echo stripslashes($this->lang->line('experience_details')); } else echo "Confirm what you'll provide";?></h3>
                        
                        <p><?php if($this->lang->line('Aexperiencetitleandsummary') != '') { echo stripslashes($this->lang->line('Aexperiencetitleandsummary')); } else echo "On this page, you can ass additional details about what you are providing. For example, you can let your guests know that you accomodate vegetarians..";?> </p>
                    
                    </div>
                   <form id="overviewlist" name="overviewlist"  method="post"  accept-charset="UTF-8"  class="form_container left_label listingInfo">

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                    
				<ul class="tab-areas2">

				<li>					
                    <div class="dashboard_price_right">
					
					<div class="webform" method="post" id="hourly">
                    <div class="managlist_tabl" id="package_table">
                        <table id="example" cellspacing="0" width="100%" border="1" class="table table-striped display">
                            <thead>
                               
                                <th>Item</th>
                                <th>Details</th>
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Action</th>
   
                            </thead>
                            <tbody>
                            <?php 
                                // print_r($listchildvalues->result());
                                // exit();
                                if ($guide_provides->num_rows() > 0){
                                    $i = 1;
                                    foreach ($guide_provides->result() as $row){          
                                ?>
                            <tr>
                                
                                <td><?php echo $row->kit_title;?></td>
                                <td><?php echo $row->kit_detailed_title;?></td>
                                
                                <td><?php echo   $row->kit_count; ?> </td>
                                <td><?php echo $row->kit_description; ?></td>   
                                <td>
                                    
                                    <?php // if($listDetail->row()->status == '0') { ?>    
                                        <span class="action-icons c-edit" onclick="javascript:get_activity_data('<?php echo $row->id; ?>','<?php echo $row->kit_title; ?>','<?php echo $row->kit_detailed_title; ?>','<?php echo $row->kit_count; ?>','<?php echo $row->kit_description; ?>');" title="Edit" style="cursor: pointer;"><?php if($this->lang->line('back_Edit') != '') { echo stripslashes($this->lang->line('back_Edit')); } else echo "<i class='fa fa-pencil-square-o' aria-hidden='true'></i>"; ?></span> |
                                        
                                        
                                         <span><a class="action-icons c-delete" href="admin/experience/delete_kit_package/<?php echo $row->id;?>/<?php echo $row->experience_id;?>" title="Delete"><i class="fa fa-trash-o delete-icon fa-lg" aria-hidden="true"></i> </a></span>

                                </td>
                            </tr>
                            <?php 
                                $i++;   
                                    }
                                }else{
                                ?>
                                <tr>
                                    <td colspan="6">No Items added..</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            
                        </table>


                    </div>
                    
					<div class="basic-next">
                         <button type="button" href="" class="btn btn-info" id='add_btn_new' onclick="add_new_item()">+ Add new item</button>
					</div>
					
                 </div>
				 

                    <div class="exp_det_right add_new_item" style="display:none;">
						

						<div class="overview_title margin_top_20 margin_bottom_20 input ">

						<span class="error text-center" id="error_what_you_will_provide">
						<small> * Please fill all mandatory fields</small>
						</span>
						
                        <div class="overview_title margin_top_20 margin_bottom_20">

                            <input type="hidden" class=" col-sm-2"  id="kit_id" name="kit_id" />
                           
            <ul class="tab-areas2"><!---inside--->

				<li>    
					<div class="form_grid_12">			
						
						<label class="field_title service_det_edit" for="main_title">Item <span class="req">*</span></label>
						<div class="form_input">
						<input type="text" maxlength="25" onkeyup="char_count(this)" class=" col-sm-2"  id="main_title"  name="main_title" />
						<span class="small_label"><span id="main_title_char_count">25</span> characters remaining</span>
						</div>
					</div>
				</li>
				<li>  
					<div class="form_grid_12">
						<label class="field_title service_det_edit" for="detailed_title">About Item <span class="req">*</span></label>
						<div class="form_input">
						<input maxlength="25" onkeyup="char_count(this)" type="text" class="col-sm-2"  id="detailed_title" name="detailed_title" value=""/>
						<span class="small_label"><span id="detailed_title_char_count">25</span> characters remaining</span>
						</div>
					</div>
				</li>
				<li>  
					<div class="form_grid_12">
                                
						<label class="field_title service_det_edit" for="kit_count">Quantity <span class="req">*</span></label>
						<div class="form_input">
							<input class="number_field" type="text" min='1' maxlength="5" id="kit_count"  name="kit_count" value="" />
						</div>	
					</div>
				</li>
                <li>  
					<div class="form_grid_12">               
						<label class="field_title service_det_edit" for="kit_description">description <span class="req">*</span></label>
						<div class="form_input">    
							<textarea  maxlength="250" onkeyup="char_count(this)" class="title_overview" id="kit_description" placeholder="Description about the item what you provide" rows="8"  name="kit_description" id="kit_description"></textarea>
							<span class="small_label"><span id="kit_description_char_count">150</span> characters remaining</span>
						</div>	
					</div>
				</li>                   
								
				 <li>  
					<div class="form_grid_12">  				
								
                                <div class="button-len">
								
								<div class="basic-next">
                                <button type="button" class="btn btn-success" id='add_btn_1' onclick="add_kit()">submit</button>
                                
								<button class="btn btn-success" type="button" class="filter-btn" id="update_btn_1" style="display: none;" name=""  onclick="update_tab2()"> Update</button>
                                <button class="btn btn-default" type="reset" class="filter-btn" id="reset_btn" name="" onclick="reset_reload()"> Cancel</button>
								</div>
								
                                </div>

                        </div>
				</li>
				</ul>

                 <!-- Kit content selection Ends  -->

							
                        </div>
						
						
                    </div>
              	
                    </div>
					
				</li>
				
				<li>
					<?php 
					$blur='';
					if($what_will_provide==0){
						$blur="disabled_exp";
					}
					?>
                     <div class="basic-next">
					 <button class="btn btn-success continue <?php echo $blur; ?>" type="button" onclick="validate_form_what_will_provide(event)"><?php if($this->lang->line('Continue') != '') { echo stripslashes($this->lang->line('Continue')); } else echo "Continue";?></button>
					 </div>
				</li>
				
				<ul>

                </form>


                </div>
            
            </div>
            
            </div>


<script>

function validate_form_what_will_provide(e){
	$('#notes_tab').removeClass('disabled_exp');	
	document.getElementById("notes_tab").click();
}
</script>