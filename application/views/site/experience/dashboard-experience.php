<?php 
//echo '<pre>';print_r($ExperienceDetail->result());die;
$this->load->view('site/templates/header');
?>
<!---DASHBOARD-->
<div class="dashboard yourlisting yourlistinghome dasblistgnwthm">

    <div class="top-listing-head">
        <div class="main">   
            <!--main nav header -->
            <?php 
             $this->load->view('site/user/main_nav_header');  
            ?>
        </div>
    </div>
    <div class="dash_brd">
      <div id="command_center">
        <div class="lispg_top">
          <div class="dashboard-sidemenu">
		  
            <!--main nav header -->
            <?php 
             $this->load->view('site/user/main_nav_header');  
            ?>
            <!--experience sub nav header -->
            <?php 
             $this->load->view('site/experience/subnav_of_experiences');  
            ?>
             
          </div>
            

            <div class="listiong-areas">
            <div class="box">
      <div class="middle">
    <?php if(count($ExperienceDetail->result())>0){ ?>
        <div class="sort-header clearfix">
          <span id="listings-filter" class="btn-group btn-dropdown all">
            <a href="javascript:void(0);">
            <button class="btn gray mini dropdown-toggle display-filter" id="gray_bt">
              <span class="none always"><?php if($this->lang->line('Show') != '') { echo stripslashes($this->lang->line('Show')); } else echo "Show";?>:</span>
              <span class="none">
               <?php if($this->lang->line('alllistings') != '') { echo stripslashes($this->lang->line('alllistings')); } else echo "all listings";?> 
               
              </span>
              <span class="active">
                <span class="dot dot-green"></span>
                <?php if($this->lang->line('activelistings') != '') { echo stripslashes($this->lang->line('activelistings')); } else echo "active listings";?>
              </span>
              <span class="inactive">
                <span class="dot dot-red"></span>
               <?php if($this->lang->line('hiddenlistings') != '') { echo stripslashes($this->lang->line('hiddenlistings')); } else echo "hidden listings";?> 
              </span>
              <i class="fa fa-caret-down" aria-hidden="true"></i>
            </button></a>
            <ul class="dropdown-menu toggle-filter showlist4">
              <li>
                <a href="<?php echo base_url();?>experience/all">
                 <?php if($this->lang->line('Showalllistings') != '') { echo stripslashes($this->lang->line('Showalllistings')); } else echo "Show all listings";?> 
</a>              </li>
              <li>
                <a href="<?php echo base_url();?>experience/Publish">
                  <span class="dot dot-green"></span>
                 <?php if($this->lang->line('Showactive') != '') { echo stripslashes($this->lang->line('Showactive')); } else echo "Show active";?> 
</a>              </li>
              <li>
                <a href="<?php echo base_url();?>experience/UnPublish">
                  <span class="dot dot-red"></span>
                  <?php if($this->lang->line('Showhidden') != '') { echo stripslashes($this->lang->line('Showhidden')); } else echo "Show hidden";?>
</a>              </li>
            </ul>
          </span>
        </div>
        <?php foreach($ExperienceDetail->result() as $row){ 
        
    ?>
        <div id="listings-container">
          <ul class="listings unstyled">
            <li data-hosting-id="1898630" class="listing clearfix">
              <div class="image"><a href="<?php echo base_url()."view_experience/".$row->id;?>" target='_blank'><img src=<?php if($row->product_image == ''){?>"<?php echo base_url(). EXPERIENCEPATH.'dummyProductImage.jpg'; ?>"<?php } else {?>"<?php echo EXPERIENCEPATH; ?><?php echo $row->product_image;}?>" alt="No Image"></a></div>
                  <div class="listing-criteria-header activation-notification">
  <div class="listing-criteria-header-message">
<?php
/*
$total_steps=9;

if($row->date_count !="" && $row->experience_title!='' && $row->price !="0.00" && $row->price!='')
{
  $total_steps--;
}
if(isset($row->date_id))
{
  $total_steps--;
}
if($row->product_image !="")
{
  $total_steps--;
}
if($row->kit_content !="" &&  $row->experience_description!='' && $row->language_list!='' )
{
  $total_steps--;
}

if($row->note_to_guest !="" && $row->location_description!='')
{
  $total_steps--;
}
if($row->latitude!='0.0')
{
  $total_steps--;
}
if($row->group_size !="")
{
  $total_steps--;
}
if($row->guest_requirement !="")
{
  $total_steps--;
}
if($row->cancel_policy !="")
{
  $total_steps--;
} 
*/
 $total_steps=$controller->get_remaining_count($row->id);
 
  if($total_steps != 0 ){ ?>
  <a class="btn blue" href="<?php echo base_url()."manage_experience/".$row->id;?>"><?php echo $total_steps;?> <?php if($this->lang->line('stepstolist') != '') { echo stripslashes($this->lang->line('stepstolist')); } else echo "steps to list";?></a>
  <?php } else { /* echo $row->status.$total_steps;?>
    <?php if($row->status == '1' && $total_steps == 0){?>
    <a class="btn blue" href="javascript:void(0);"><?php if($this->lang->line('Listed') != '') { echo stripslashes($this->lang->line('Listed')); } else echo "Listed";?></a>
	 <?php */ if($total_steps == 0 && $row->status == '1'){ ?>
    <a class="btn blue" href="javascript:void(0);"><?php if($this->lang->line('Listed') != '') { echo stripslashes($this->lang->line('Listed')); } else echo "Listed";?></a>
	
	
	
    <?php } elseif($row->status == '0' && $total_steps == 0){?>
    <a class="btn blue" href="javascript:void(0);"><?php if($this->lang->line('Pending') != '') { echo stripslashes($this->lang->line('Pending')); } else echo "Pending";?></a>
    <?php } /*elseif($row->status == '0' && $total_steps == 0 && $hosting_commission_status->row()->status == 'Inactive'){?>
    <a class="btn blue" href="javascript:void(0);"><?php if($this->lang->line('Pending') != '') { echo stripslashes($this->lang->line('Pending')); } else echo "Pending";?></a>
    <?php } elseif($row->status == '0' && $total_steps == 0 && $hosting_commission_status->row()->status == 'Active' && $row->payment_status == 'paid'){?>
    <a class="btn blue" href="javascript:void(0);"><?php if($this->lang->line('Pending') != '') { echo stripslashes($this->lang->line('Pending')); } else echo "Pending";?></a>
    <?php } elseif($row->status == '0' && $total_steps == 0 && $hosting_commission_status->row()->status == 'Active') { ?>
    <a class="btn blue" href="site/experience/redirect_base/payment/<?php echo $row->id;?>"><?php if($this->lang->line('Pay') != '') { echo stripslashes($this->lang->line('Pay')); } else echo "Pay";?></a>
	
	
	
    <?php }*/ ?>
  <?php }?>
   
   
  </div>
</div>

 
                <div class="listing-info">
               



            <div class="manage-center-detail">
              <span class="managing-list"><a href="<?php echo base_url()."manage_experience/".$row->id;?>"><?php echo $row->experience_title!=''?$row->experience_title:'Untitled';?></a></span>
              <span class="views-list"><a href="<?php echo base_url()."manage_experience/".$row->id;?>"><?php if($this->lang->line('ManageExperiences') != '') { echo stripslashes($this->lang->line('ManageExperiences')); } else echo "Manage Experience";?> </a></span>
            </div>



                  <div class="actions">
                    <a class="btn gray mini" href="<?php echo base_url()."manage_experience/".$row->id;?>">

                      <i class="icon-pencil"></i>
                      <?php if($this->lang->line('ManageExperiences') != '') { echo stripslashes($this->lang->line('ManageExperiences')); } else echo "Manage Experience";?>
</a>
                    <a class="btn gray mini" href="<?php echo base_url()."view_experience/".$row->id;?>"  target='_blank'>
                      <i class="icon icon-eye-open"></i>
                      <?php if($this->lang->line('ViewExperience') != '') { echo stripslashes($this->lang->line('ViewExperience')); } else echo "View Experience";?>
</a>
                   <?php /*
                    <a name="calendar" style="cursor:pointer;" class="btn gray mini example16" data-pid="<?php echo $row->id; ?>" data-price="<?php echo $row->price; ?>" href="javascript:void(0);">
                      <i class="icon icon-calendar"></i>
                      <?php if($this->lang->line('Viewcalendar') != '') { echo stripslashes($this->lang->line('Viewcalendar')); } else echo "View calendar";?>
</a>   
  */ ?>

                                
                  </div>
                 
				<!----not to host whether email is verified or not---->
				<?php 
				if($row->id_verified=="No"){	
					echo '<h4><small>Please <u><a href="'.base_url().'verification">verify  your email id </a></u> and allow guest to book your Experience.</small></h4>';
				}
					?>
				 
                </div>
                
              </li>
          </ul>
        </div>
        <?php }  } else {?>

        <div class="no-listing">
    <h2><?php if($this->lang->line('Noexperience') != '') { echo stripslashes($this->lang->line('Noexperience')); } else echo "You don't have any property!";?></h2>
    <p>   <?php if($this->lang->line('Listingyourexperience') != '') { echo stripslashes($this->lang->line('Listingyourexperience')); } else echo "Listing your property on Occupyproperties is an easy way to expose any property you have.";?></p>
    <p> <?php if($this->lang->line('Youllalso') != '') { echo stripslashes($this->lang->line('Youllalso')); } else echo "You will also get to meet interesting buyers around Nigeria!";?></p>
    <a class="list_spaceds" href="manage_experience"><?php if($this->lang->line('PostanewExperience') != '') { echo stripslashes($this->lang->line('PostanewExperience')); } else echo "Post a new Home or Land";?></a>
    <?php }?>
    <div id="footer_pagination"><?php echo $paginationLink; ?></div>
      </div></div>
    </div> </div>
    </div>       
  </div>
    </div>
</div>
<!---DASHBOARD-->
<!---FOOTER-->

<script type="text/javascript">
$('.example16').click(function(){

  $('#inline_example11 .popup_page').html('<div class="cnt_load"><img src="images/ajax-loader.gif"/></div>');
  
  var pid = $(this).data('pid');
  var price = $(this).data('price');
  var pname = $(this).text();
  var purl = baseURL+$(this).attr('href');
  $.ajax({
    type:'get',
//    url:baseURL+'site/product/viewMemberCalendar/'+pid,
    url:baseURL+'site/product/edit_calendar/'+pid,

    data:{'pid':pid,'price':price},
    dataType:'html',
    success:function(data){ 
    alert(data);
//      window.history.pushState({"html":data,"pageTitle":pname},"", purl);
      $('#inline_example11 .popup_page').html(data);
    }
  });
});
</script>


<!-----------popup for listing------>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
jQuery.noConflict();
jQuery(function() {
//alert('<?php echo $Steps_count6;?>');
<?php if($this->session->userdata('enable_complete_popup') == 'yes') { ?>
jQuery( "#dialog-message" ).dialog({
modal: true,
buttons: {

click: function() {
//text: "Finish My Listing",
jQuery( this ).dialog( "close" );
}
}
});
<?php }else {?>
//alert();
jQuery('#dialog-message').css('display','none');
<?php }?>
});

jQuery(function()
{
jQuery('.ui-button-text').text('Ok');
});
</script>

<div id="dialog-message" title="<?php if($this->lang->line('Download_complete') != '') { echo stripslashes($this->lang->line('Download_complete')); } else echo "Download complete";?>">
<p class="listing-down-creat"><?php if($this->lang->line('Thankyoufor') != '') { echo stripslashes($this->lang->line('Thankyoufor')); } else echo "Thank you for listing your property with us. Listing will go live .";?></p>
</p>
</div>
<!-----------End popup for listing------>
<?php if($this->session->userdata('enable_complete_popup'))
{
$this->session->unset_userdata('enable_complete_popup');
}
$this->load->view('site/product/front_calendar',$this->data);
$this->load->view('site/templates/footer');
?>