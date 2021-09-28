<?php //die;?>

<?php if($steps_disable==1){ 

$dis_class='disabled_exp';



}else{

	$dis_class='';
	
}	

?>

<style type="text/css">

.active .disabled_exp{

	/*cursor:not-allowed;*/

	opacity: 1;

}

 .disabled_exp{

	/*cursor:not-allowed;*/

	opacity: 0.5;

}



.disabled_exp:hover{

	opacity: 0.5;

	color: #ffffff !important;

	background: #752b7e !important;

	cursor: default !important;

}

.disabled_exp span:hover{

	color: #ffffff !important;

	background:none;

}

.select select {

    width: 100%;

    padding: 10px;

    height: 45px;

    font-size: 18px;

	color: #787474;

}



.input input{

	width: 100%;

    padding: 10px;

    height: 45px;

    font-size: 18px;

}

.margin_bottom_20{

	margin-bottom: 20px;

}

.margin_top_20{

	margin-top: 20px;

}

.overview_title h4{

	color:#5d5a5a;

}

.basic-next button {

    float: right;

	width: 163px;

	font-weight: 500;

	font-size:16px;

}

.error{

	display:none;

	color:red;

}

.btn_blur{

	opacity: .3;

	cursor: not-allowed;

}

.dashboard_price_left h3 {

    text-decoration:none;

	text-transform: initial;

}

.inner_language li{

	border-radius: 3px;

	background: #eee;

}

.dashboard_price_main a{

    border-radius: 3px;

    width: 100%;

    text-align: center;

    background-color: #9f9f9f;

	margin:0px;

}

span.no-numbr{

	margin-left:0px;

}

.dashboard_price_left {

    text-transform: initial;

}

.exp-outerpanel {

    background: #f9f9f9;

}



.dashboard_price_main div{

	background:none;

}

.left_side_1{

	max-height: 500px;

	overflow-y: auto;

}

.left_side_1 li.active a span{

	color: #752b7e;

	font-weight: bold;

}

.dashboard_price_main a{

	/*background:none;*/

}

.dashboard_price_main .square_box{

	padding: 20px;

	border: 1px solid rgba(249, 238, 238, 0.5) !important;

}

textarea[disabled]{

	background:none !important;

}

.cursor_pointer{

	cursor:pointer;

}

.input_class{

	height:auto !important;

	padding:3px !important;

}

.small_label{

	color: #acacac;

	font-size: 12px;

	width:100%;

}

#form_action_msg_common{

	color:#f2750b;

	font-size: 14px;

}

.error_msg{

	color:#f2750b;

	font-size: 14px;

	margin-bottom: 10px;

	text-align: center;

}

.date_actions .delet_time{

	background:none;

}

.date_actions .status{

	background-color:#752b7e;

	color:#fff;

}

.calender_comment_text p {

    text-transform: inherit;

}

</style>

<script src="js/site/core.js" type="text/javascript"></script>

<script type="text/javascript">



$("static dynamic-children a.menu-item").click(function(event){

    event.preventDefault();

});



function homeView(val){

	//alert(val);

	if($('#homelist'+val).css('display')=='block'){

		$('#homelist'+val).hide('');	

	}else{

		$('#homelist'+val).show('');

	}

}





function roomView(val){

	//alert(val);

	if($('#roomlist'+val).css('display')=='block'){

		$('#roomlist'+val).hide('');	

	}else{

		$('#roomlist'+val).show('');

	}

}



function cityView(val){

	//alert(val);

	if($('#citylist'+val).css('display')=='block'){

		$('#citylist'+val).hide('');	

	}else{

		$('#citylist'+val).show('');

	}

}



function otherView(val){

	//alert(val);

	if($('#otherlist'+val).css('display')=='block'){

		$('#otherlist'+val).hide('');	

	}else{

		$('#otherlist'+val).show('');

	}

}



function accommodatesView(val){

	//alert(val);

	if($('#accommodateslist'+val).css('display')=='block'){

		$('#accommodateslist'+val).hide('');	

	}else{

		$('#accommodateslist'+val).show('');

	}

}



function calenderView(val){

	//alert(val);

	if($('#calenderlist'+val).css('display')=='block'){

		$('#calenderlist'+val).hide('');	

	}else{

		$('#calenderlist'+val).show('');

	}

}



$(document).ready(function() {

    $(".number_field").keydown(function (e) {

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





<?php 



$url = $this->uri->segment(1);

//$exp_id_check = $this->uri->segment(2);



//if($page_exp!='initial'){

	

?>



<div class="sub_header">



	<ul class="sub_header_left">

    

    	<li><a class="view_listingarw" href="<?php echo base_url()."experience/all";?>"><img src="images/arw.png" style="width: 66px; padding: 8px 20px 0px 27px;"></a><div class="tools"><i class="arsd-ico"></i><span><?php if($this->lang->line('list_experiencebyAdmin') != '') { echo stripslashes($this->lang->line('list_experiencebyAdmin')); } else echo "The experience will be previewed by admin before activating it."; ?></span>

</div></li>

        

        <li class="write_title"><?php if($listDetail->row()->experience_title == '') {

        	echo $listDetail->row()->date_count;

        	if( $listDetail->row()->date_count>1)

        		echo ' days';

        	else

        		echo ' day';

        	echo '  in '.$listDetail->row()->city; }

        	else echo $listDetail->row()->experience_title;?></li>

        

       <li class="prevwli" style="display:none"><a class="pre-li" href="#"><?php if($this->lang->line('Preview') != '') { echo stripslashes($this->lang->line('Preview')); } else echo "Preview";?></a><div class="tools"><i class="arsd-ico"></i><span><?php if($this->lang->line('list_experiencebyAdmin') != '') { echo stripslashes($this->lang->line('list_experiencebyAdmin')); } else echo "The experience will be previewed by admin before activating it."; ?></span></div></li>

    

    </ul>



</div>



<?php //} ?>



<!---DASHBOARD-->





<?php 

//$listDetail =$listDetail->result_array();

 /* echo '<pre>'; print_r($listDetail);

 die; */ //echo $Steps_count2; ?>



	<div class="main_2">

    	

        <div class="manage_listing">

        

		

		

        	<div class="left_side">

            

            	<div class="left_side_top">

            

	

          <?php /*  <div class="left_side_bottom_content"><?php echo $Steps_tot;?> Steps Pending </div> */?>

		  

			<div class="left_side_bottom_content"><?php //echo $Steps_tot;?>  </div>

            	<h2><?php if($this->lang->line('list_Basics') != '') { echo stripslashes($this->lang->line('list_Basics')); } else echo "Basics"; ?></h2>

                

                <?php /*

				

				<ul class="left_side_1">

                

                	<li <?php if($url == 'manage_experience') echo 'class="active"';?>><a href="<?php echo base_url()."manage_experience/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-1"></i><span><?php if($this->lang->line('manage_experience') != '') { echo stripslashes($this->lang->line('manage_experience')); } else echo "Basics"; ?></span><div class="new-section-icon"><i <?php if($listDetail->row()->date_count=='' || ($listDetail->row()->type_id=='0' || $listDetail->row()->type_id=='' )){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                	<li <?php if($url == 'schedule_experience') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."schedule_experience/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-1"></i><span><?php if($this->lang->line('schedule_experience') != '') { echo stripslashes($this->lang->line('schedule_experience')); } else echo "Experience Schedule"; ?></span><div class="new-section-icon"><i <?php if($Steps_count2=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                	 <li <?php if($url == 'experience_image') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."experience_image/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('experience_image') != '') { echo stripslashes($this->lang->line('experience_image')); } else echo "Experience Image"; ?></span><div class="new-section-icon"><i <?php if($Steps_count3=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>

                    

                    <li <?php if($url == 'experience_details') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."experience_details/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('experience_details') != '') { echo stripslashes($this->lang->line('experience_details')); } else echo "Experience Details"; ?></span><div class="new-section-icon"><i <?php if($Steps_count4=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                     <li <?php if($url == 'additional_details') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."additional_details/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('additional_details') != '') { echo stripslashes($this->lang->line('additional_details')); } else echo "Additional Details"; ?></span><div class="new-section-icon"><i <?php if($Steps_count5=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                     <li <?php if($url == 'location_details') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."location_details/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('location_details') != '') { echo stripslashes($this->lang->line('location_details')); } else echo "Location"; ?></span><div class="new-section-icon"><i <?php if($Steps_count6=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                      <li <?php if($url == 'group_details') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."group_details/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('group_details') != '') { echo stripslashes($this->lang->line('group_details')); } else echo "Group Details"; ?></span><div class="new-section-icon"><i <?php if($Steps_count7=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                      <li <?php if($url == 'guest_requirement') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."guest_requirement/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('guest_requirement') != '') { echo stripslashes($this->lang->line('guest_requirement')); } else echo "Guest Requirements"; ?></span><div class="new-section-icon"><i <?php if($Steps_count8=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                      <li class="<?php if($url == 'experience_cancel_policy') echo "active";?>" ><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."experience_cancel_policy/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('experience_cancel_policy') != '') { echo stripslashes($this->lang->line('experience_cancel_policy')); } else echo "Cancellation Policy"; ?></span><div class="new-section-icon"><i <?php if($Steps_count9=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>

                

                </ul>

                

                <?php

				

				$Steps_count9=1;

				$Steps_count8=1;



				?>

				*/ ?>

				

				

				<ul class="left_side_1">

                

                	<li <?php if($url == 'manage_experience') echo 'class="active"';?>>

						<a href="<?php echo base_url()."manage_experience/".$listDetail->row()->id;?>">

							<i class="left_side_icon left_icon-1"></i>

							<span><?php if($this->lang->line('list_Basics') != '') { echo stripslashes($this->lang->line('list_Basics')); } else echo "Basics"; ?>

							</span>

							<div class="new-section-icon">

								<?php echo ($basics==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

							</div>

						</a>

					</li>

					

					<li <?php if($url == 'experience_language_details') echo 'class="active"';?>>

						<a <?php  echo ($language==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."experience_language_details/".$listDetail->row()->id;?>">

							<i class="left_side_icon left_icon-1"></i>

							<span><?php if($this->lang->line('experience_language_details') != '') { echo stripslashes($this->lang->line('experience_language_details')); } else echo "Language"; ?>

							</span>

							<div class="new-section-icon">

								<?php echo ($language==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

							</div>

						</a>

					</li>

					

					<li <?php if($url == 'experience_organization_details') echo 'class="active"';?>>

						<a <?php  echo ($organization==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."experience_organization_details/".$listDetail->row()->id;?>">

							<i class="left_side_icon left_icon-1"></i>

							<span><?php if($this->lang->line('experience_organization_details') != '') { echo stripslashes($this->lang->line('experience_organization_details')); } else echo "Organization"; ?>

							</span>

							<div class="new-section-icon">

								<?php echo ($organization==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

							</div>

						</a>

					</li>

					<li <?php if($url == 'experience_details') echo 'class="active"';?>>

						<a <?php  echo ($exp_title==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."experience_details/".$listDetail->row()->id;?>">

							<i class="left_side_icon left_icon-1"></i>

							<span><?php if($this->lang->line('experience_title') != '') { echo stripslashes($this->lang->line('experience_title')); } else echo "Property Title"; ?>

							</span>

							<div class="new-section-icon">

								<?php echo ($exp_title==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

							</div>

						</a>

					</li>

					<li <?php if($url == 'schedule_experience') echo 'class="active"';?>>

						<a <?php  echo ($timing==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."schedule_experience/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-1"></i>

						<span><?php if($this->lang->line('schedule_experience') != '') { echo stripslashes($this->lang->line('schedule_experience')); } else echo "Timing"; ?></span>

					

						<div class="new-section-icon">

								<?php echo ($timing==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					<li <?php if($url == 'tagline_experience') echo 'class="active"';?>>

						<a <?php  echo ($tagline==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."tagline_experience/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-1"></i>

						<span><?php if($this->lang->line('tagline_experience') != '') { echo stripslashes($this->lang->line('tagline_experience')); } else echo "Tagline"; ?></span>

					

						<div class="new-section-icon">

								<?php echo ($tagline==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					<li <?php if($url == 'experience_image') echo 'class="active"';?>>

						<a <?php  echo ($photos==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."experience_image/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i>

						<span><?php if($this->lang->line('photos') != '') { echo stripslashes($this->lang->line('photos')); } else echo "Photos"; ?></span>

						<div class="new-section-icon">

								<?php echo ($photos==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					

					<li <?php if($url == 'what_we_do') echo 'class="active"';?>>

						<a <?php  echo ($what_we_do==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."what_we_do/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('exp_what_you_will') != '') { echo stripslashes($this->lang->line('exp_what_you_will')); } else echo "What you will do"; ?></span>

						<div class="new-section-icon">

								<?php echo ($what_we_do==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					<li <?php if($url == 'where_we_will_be') echo 'class="active"';?>>

						<a <?php  echo ($where_will_be==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."where_we_will_be/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span>Property Size</span>

						<div class="new-section-icon">

								<?php echo ($where_will_be==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					<li <?php if($url == 'location_details') echo 'class="active"';?>>

						<a <?php  echo ($where_will_meet==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."location_details/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('where_wil_meet') != '') { echo stripslashes($this->lang->line('where_wil_meet')); } else echo "Where we'll meet"; ?></span>

						<div class="new-section-icon">

								<?php echo ($where_will_meet==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					<li <?php if($url == 'what_you_will_provide') echo 'class="active"';?>>

						<a <?php  echo ($what_will_provide==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."what_you_will_provide/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('what_you_will_provide') != '') { echo stripslashes($this->lang->line('what_you_will_provide')); } else echo "What you will provide"; ?></span>

						<div class="new-section-icon">

								<?php echo ($what_will_provide==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

					</li>

					<li <?php if($url == 'notes_to_guest') echo 'class="active"';?>>

						<a <?php  echo ($notes==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."notes_to_guest/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('notes_to_guest') != '') { echo stripslashes($this->lang->line('notes_to_guest')); } else echo "Notes"; ?></span>

						<div class="new-section-icon">

								<?php echo ($notes==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					<li <?php if($url == 'about_exp_host') echo 'class="active"';?>>

						<a <?php  echo ($about_you==0) ? 'class="disabled_exp"' : ''; ?> class="<?php echo $dis_class; ?>" href="<?php echo base_url()."about_exp_host/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('about_exp_host') != '') { echo stripslashes($this->lang->line('about_exp_host')); } else echo "About you"; ?></span>

						<div class="new-section-icon">

								<?php echo ($about_you==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					<li <?php if($url == 'guest_requirement') echo 'class="active"';?>>

						<a <?php  echo ($guest_req==0) ? 'class="disabled_exp"' : ''; ?>  href="<?php echo base_url()."guest_requirement/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('guest_requirement') != '') { echo stripslashes($this->lang->line('guest_requirement')); } else echo "Guest Requirements"; ?></span>

						<div class="new-section-icon">

								<?php echo ($guest_req==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					<li <?php if($url == 'group_size') echo 'class="active"';?>>

						<a <?php  echo ($group_size==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."group_size/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('group_size') != '') { echo stripslashes($this->lang->line('group_size')); } else echo "Group size"; ?></span>

						<div class="new-section-icon">

								<?php echo ($group_size==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					<li <?php if($url == 'price') echo 'class="active"';?>>

						<a <?php  echo ($price==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."price/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('Price') != '') { echo stripslashes($this->lang->line('Price')); } else echo "Price"; ?></span>

						<div class="new-section-icon">

								<?php echo ($price==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					

					<li class="<?php if($url == 'experience_cancel_policy') echo "active";?>" id="cancel_policy">

						<a <?php  echo ($cancel_policy==0) ? 'class="disabled_exp"' : ''; ?> href="<?php echo base_url()."experience_cancel_policy/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i>

						<span><?php if($this->lang->line('list_Cancellation') != '') { echo stripslashes($this->lang->line('list_Cancellation')); } else echo "Cancellation Policy"; ?></span>

						<div class="new-section-icon">

								<?php echo ($cancel_policy==1) ? '<i class="icon_plus_active"></i>' : ''; ?>

						</div>

						</a>

					</li>

					

					



<?php /*					

					<li><hr></li>

					<li><hr></li>

					

                	<li <?php if($url == 'schedule_experience') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."schedule_experience/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-1"></i><span><?php if($this->lang->line('schedule_experience') != '') { echo stripslashes($this->lang->line('schedule_experience')); } else echo "Experience Schedule"; ?></span><div class="new-section-icon"><i <?php if($Steps_count2=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                	 <li <?php if($url == 'experience_image') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."experience_image/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('experience_image') != '') { echo stripslashes($this->lang->line('experience_image')); } else echo "Experience Image"; ?></span><div class="new-section-icon"><i <?php if($Steps_count3=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>

                    

                    <li <?php if($url == 'experience_details') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."experience_details/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('experience_details') != '') { echo stripslashes($this->lang->line('experience_details')); } else echo "Experience Details"; ?></span><div class="new-section-icon"><i <?php if($Steps_count4=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                     <li <?php if($url == 'additional_details') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."additional_details/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('additional_details') != '') { echo stripslashes($this->lang->line('additional_details')); } else echo "Additional Details"; ?></span><div class="new-section-icon"><i <?php if($Steps_count5=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                     <li <?php if($url == 'location_details') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."location_details/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('location_details') != '') { echo stripslashes($this->lang->line('location_details')); } else echo "Location"; ?></span><div class="new-section-icon"><i <?php if($Steps_count6=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                      <li <?php if($url == 'group_details') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."group_details/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('group_details') != '') { echo stripslashes($this->lang->line('group_details')); } else echo "Group Details"; ?></span><div class="new-section-icon"><i <?php if($Steps_count7=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                      <li <?php if($url == 'guest_requirement') echo 'class="active"';?>><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."guest_requirement/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('guest_requirement') != '') { echo stripslashes($this->lang->line('guest_requirement')); } else echo "Guest Requirements"; ?></span><div class="new-section-icon"><i <?php if($Steps_count8=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>



                      <li class="<?php if($url == 'experience_cancel_policy') echo "active";?>" ><a class="<?php echo $dis_class; ?>" href="<?php echo base_url()."experience_cancel_policy/".$listDetail->row()->id;?>"><i class="left_side_icon left_icon-2"></i><span><?php if($this->lang->line('experience_cancel_policy') != '') { echo stripslashes($this->lang->line('experience_cancel_policy')); } else echo "Cancellation Policy"; ?></span><div class="new-section-icon"><i <?php if($Steps_count9=='1'){ echo 'class="icon_plus"'; }else{ echo 'class="icon_plus_active"';}?>></i></div></a></li>

					

					*/ ?>

				

                </ul>

				

				

				

            </div>

            





       	</div>

		



<script type="text/javascript">

$(document).ready(function(){

		$('.disabled_exp').blur();

		$(".disabled_exp").click(function(event){

			 preventClick = true

			event.preventDefault();

		});

})



function  char_count(obj){

	value_str=obj.value.trim();

	var length = value_str.length;

	var maxlength = $(obj).attr('maxlength');

	var id = obj.id;

	var length = maxlength-length;

	//alert(maxlength);

	//alert(id);

	$('#'+id+'_char_count').text(length);

}

function continue_button_manage(status){

	if(status=="show"){

		$('.continue').removeClass('disabled_exp');

	}else{

		$('.continue').addClass('disabled_exp');

	}

}

</script>

