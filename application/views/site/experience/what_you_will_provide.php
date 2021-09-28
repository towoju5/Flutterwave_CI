<?php $this->load->view('site/templates/header'); 


$this->load->view('site/experience/experience_head_side');?>
<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addExperience.js"></script>


<script type="text/javascript">
    //Add new kit
function add_kit(){

    var main_title       = $("#main_title").val();
    var detailed_title   = $("#detailed_title").val();
    var kit_description  = $("#kit_description").val();
    var kit_count        = $("#kit_count").val();
    var experience_id    = $("#experience_id").val();

    if(main_title!='' && detailed_title!=''){
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
                window.location.reload();
             }
             else if(data.case == 2){
                //$("div.updated").fadeIn(300).delay(1500).fadeOut(400);
                //$("#package_table").load(location.href + " #package_table");
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
         $('.error').fadeIn('slow', function () {
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
    
    $('#add_btn').hide();
    $('#update_btn').show();
    $('#reset_btn').show();

}

function update_tab2()
{
    var kit_id = $('#kit_id').val();
    var main_title = $('#main_title').val();
    var detailed_title = $('#detailed_title').val();
    var kit_count = $('#kit_count').val();
    var kit_description = $('#kit_description').val();
    var experience_id = $('#experience_id').val();
    
    if(main_title == '' || detailed_title == ''){
          $('.error').fadeIn('slow', function () {
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
            
                    <div class="dashboard_price_left ">
                    
                        <h3><?php if($this->lang->line('comfirm_what_will_provide') != '') { echo stripslashes($this->lang->line('comfirm_what_will_provide')); } else echo "Confirm what you'll provide";?></h3>
                        
                        <p><?php if($this->lang->line('comfirm_what_will_provide_summary') != '') { echo stripslashes($this->lang->line('comfirm_what_will_provide_summary')); } else echo "On this page, you can ass additional details about what you are providing. For example, you can let your guests know that you accomodate vegetarians..";?> </p>
                    
                    </div>
                   <form onsubmit="return validate_form_new(event)" id="overviewlist" name="overviewlist"  method="post"  accept-charset="UTF-8">

                   <input type="hidden" class=" col-sm-2"  id="experience_id" name="experience_id" value="<?php echo $listDetail->row()->experience_id ; ?>"/>
                       
                    <div class="dashboard_price_right pvd_dpr">
					
					<div class="webform" method="post" id="hourly">
                    <div class="managlist_tabl" id="package_table">
                        <table id="example" cellspacing="0" width="100%" border="1" class="table table-striped display">
                            <thead>
                               
                                <th><?php if($this->lang->line('exp_item') != '') { echo stripslashes($this->lang->line('exp_item')); } else echo "Item"; ?></th>
                                <th><?php if($this->lang->line('detail_list') != '') { echo stripslashes($this->lang->line('detail_list')); } else echo "Details"; ?></th>
                                <th><?php if($this->lang->line('exp_quantity') != '') { echo stripslashes($this->lang->line('exp_quantity')); } else echo "Quantity"; ?></th>
                                <th><?php if($this->lang->line('list_Description') != '') { echo stripslashes($this->lang->line('list_Description')); } else echo "Description"; ?></th>
                                <th><?php if($this->lang->line('Action') != '') { echo stripslashes($this->lang->line('Action')); } else echo "Action"; ?></th>
                              
                                
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
                                        
                                        
                                         <span><a class="action-icons c-delete" href="site/experience/delete_kit_package/<?php echo $row->id;?>/<?php echo $row->experience_id;?>" title="Delete"><i class="fa fa-trash-o delete-icon fa-lg" aria-hidden="true"></i> </a></span>
                                     <?php // } ?>
                                       <!--  <span><a class="action-icons c-delete" onclick="javascript:delete_season_data('<?php //echo $row->season_id;?>','<?php //echo $row->product_id;?>','<?php //echo $row->date_from; ?>','<?php //echo $row->date_to; ?>');" title="Delete">Delete</a></span> -->

                                    
                                </td>
                            </tr>
                            <?php 
                                $i++;   
                                    }
                                }else{
                                ?>
                                <tr>
                                    <td colspan="6"><?php if($this->lang->line('exp_no_items_added') != '') { echo stripslashes($this->lang->line('exp_no_items_added')); } else echo "No Items added.."; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            
                        </table>


                    </div>
                    
					<div class="basic-next">
                         <button type="button" href="" class="next_button" id='add_btn_new' onclick="add_new_item()">+ <?php if($this->lang->line('exp_add_new_item') != '') { echo stripslashes($this->lang->line('exp_add_new_item')); } else echo "Add new item"; ?></button>
					</div>
					
                 </div>
				 
					
					
					
                    <div class="exp_det_right add_new_item" style="display:none;">
						
						
						
						<div class="overview_title margin_top_20 margin_bottom_20 input ">

						<span class="error text-center">
						<small class="pvd_err"> * <?php if($this->lang->line('exp_fill_all_fields') != '') { echo stripslashes($this->lang->line('exp_fill_all_fields')); } else echo "Please fill all mandatory fields"; ?></small>
						</span>
						
                        <div class="overview_title margin_top_20 margin_bottom_20 pvd-btm">

                            <input type="hidden" class=" col-sm-2"  id="kit_id" name="kit_id" />
                           
                                
								<div class="exp-outerpanel">
                                <div class="col-md-3 col-xs-12 no-padding">
                                    <label class="field_title service_det_edit" for="main_title"><?php if($this->lang->line('exp_item') != '') { echo stripslashes($this->lang->line('exp_item')); } else echo "Item"; ?> </label>
                                    <input type="text" maxlength="60" onkeyup="char_count(this)" class=" col-sm-2"  id="main_title"  name="main_title" />
									<span class="small_label prvd_span"><span id="main_title_char_count">60</span> <?php if($this->lang->line('exp_characters_remaining') != '') { echo stripslashes($this->lang->line('exp_characters_remaining')); } else echo "characters remaining"; ?></span>
                                </div>

                                <div class=" col-md-3 col-xs-12 no-padding">
                                    <label class="field_title service_det_edit" for="detailed_title"><?php if($this->lang->line('exp_about_item') != '') { echo stripslashes($this->lang->line('exp_about_item')); } else echo "About Item"; ?> </label>
                                    <input maxlength="60" onkeyup="char_count(this)" type="text" class=" col-sm-2"  id="detailed_title" name="detailed_title" value=""/>
									<span class="small_label prvd_span"><span id="detailed_title_char_count">60</span> <?php if($this->lang->line('exp_characters_remaining') != '') { echo stripslashes($this->lang->line('exp_characters_remaining')); } else echo "characters remaining"; ?></span>
                                </div>

                                <div class=" col-md-3 col-xs-12 no-padding">
                                    <label class="field_title service_det_edit" for="kit_count"><?php if($this->lang->line('exp_quantity') != '') { echo stripslashes($this->lang->line('exp_quantity')); } else echo "Quantity"; ?> </label>
                                    <input type="text" class="col-sm-2" maxlength="5" id="kit_count"  name="kit_count" value="" />
                                </div>

                                <div class="col-md-3 col-xs-12 no-padding exp-text-desc">
                                    <label class="field_title service_det_edit" for="kit_description"><?php if($this->lang->line('list_Description') != '') { echo stripslashes($this->lang->line('list_Description')); } else echo "Description"; ?></label>
                                    
                                    <textarea  maxlength="250" onkeyup="char_count(this)" class="title_overview" id="kit_description" placeholder="<?php if($this->lang->line('exp_description_about_the_item') != '') { echo stripslashes($this->lang->line('exp_description_about_the_item')); } else echo "Description about the item what you provide"; ?>" rows="8"  name="kit_description" id="kit_description"></textarea>
									<span class="small_label prvd_span"><span id="kit_description_char_count">150</span> <?php if($this->lang->line('exp_characters_remaining') != '') { echo stripslashes($this->lang->line('exp_characters_remaining')); } else echo "characters remaining"; ?></span>
                                </div>
								</div>
								
								
                                <div class="button-len">
								
								<div class="basic-next pvd_btn">
                                <button type="button" class="next_button" id='add_btn' onclick="add_kit()"><?php if($this->lang->line('Submit') != '') { echo stripslashes($this->lang->line('Submit')); } else echo "Submit"; ?></button>
                                
								<button type="button" class="filter-btn" id="update_btn" style="display: none;" name=""  onclick="update_tab2()"> <?php if($this->lang->line('exp_update') != '') { echo stripslashes($this->lang->line('exp_update')); } else echo "Update"; ?></button>
                                <button type="reset" class="filter-btn" id="reset_btn" name="" onclick="reset_reload()"> <?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?></button>
								</div>
								
                                </div>

                        </div>

                 <!-- Kit content selection Ends  -->

							
                        </div>
						
						
                    </div>
              	
                    </div>
					<?php 
					$blur='';
					if($what_will_provide==0){
						$blur="disabled_exp";
					}
					?>
                     <div class="basic-next">
					 <button class="pvd_btn next_button continue <?php echo $blur; ?>" id="next-btn" type="button"><?php if($this->lang->line('Continue') != '') { echo stripslashes($this->lang->line('Continue')); } else echo "Continue";?></button>
					 </div>

                </form>


                </div>
            
            </div>
            
            </div>
            
            
            <div class="calender_comments">
            
                <div class="calender_comment_content">
                
                    <i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>
                    
                    <div class="calender_comment_text">
                    
                        <h2><?php if($this->lang->line('experience_details_hospitality') != '') { echo stripslashes($this->lang->line('experience_details_hospitality')); } else echo "What kind of hospitality you offer?";?></h2>
                    
                        <p><?php if($this->lang->line('exp_great_summary_hospitality') != '') { echo stripslashes($this->lang->line('exp_great_summary_hospitality')); } else echo "Let your guests know if you’ll be including anything for this experience. To make your experience a memorable one, you can provide meal, drink, transportation, accommodations etc for your guest as a part of refreshment.";?></p>
						
						<p><strong><?php if($this->lang->line('exp_examples') != '') { echo stripslashes($this->lang->line('exp_examples')); } else echo "Example:";?></strong><?php if($this->lang->line('Itwillonly_hospitality') != '') { echo stripslashes($this->lang->line('Itwillonly_hospitality')); } else echo "Snack, Paragliding equipment ";?>   </p>

                    </div>
                    
                    
                
                </div>
            
            </div>
            
        
        </div>
        
    </div>

<style>
.content{
height:44px !important;
}
</style>






<script>

function validate_form_new(e){
	
	 window.location.href = '<?php echo base_url()."notes_to_guest/".$id; ?>';
	 
		/*url='<?php echo base_url()."site/experience/add_location_description/".$id;?>';
		$('#overviewlist').attr('method', 'post');
		$('#overviewlist').attr('action', url).submit();*/

}
$(document).ready(function() {
    $('#next-btn').click(function(e) {
		has=$(this).hasClass("disabled_exp");
		if(has==false){
			window.location.href = '<?php echo base_url()."notes_to_guest/".$id; ?>';
		}
    });
});

$(document).ready(function() {
    $(".number_field2").keydown(function (e) {
		//alert('cc');
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
</script>



<?php $this->load->view('site/templates/footer'); ?>