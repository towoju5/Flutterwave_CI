<?php 
$this->load->view('site/templates/header');
?>
<script type="text/javascript">
function setPagination(id) {
  $('#paginationId').val(id);
  $('#search_result_form').submit();
}
</script>

<link rel="stylesheet" type="text/css" href="css/colorbox.css" media="all" />
<link href="css/page_inner.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/my-account.css" type="text/css" media="all"/>
<script type="text/javascript" src="js/site/SpryTabbedPanels.js"></script>
<script type="text/javascript" src="js/site/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="js/site/jquery.galleryview-3.0-dev.js"></script>
<!-- script added 14/05/2014 -->

		  <form action="<?php echo base_url().'site/product/cancel_booking_dispute';?>" method='POST' id='search_result_form'>
      <input type="hidden" name="paginationId" id="paginationId" value="<?php if($paginationId!='')echo $paginationId;else echo '0';?>" />
      </form>

<!-- script end -->
<style>
.review_img
{
background: url(images/no-rating_star.png) repeat-x;
float: left;
height: 17px;

}
.review_st {
background: url(images/rating_star.png) repeat-x;
float: left;
height: 17px;
position: relative;
}
</style>
<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor profle_rvwpg">

  <div class="top-listing-head">
 <div class="main">  
		<?php 
             $this->load->view('site/user/main_nav_header');  
            ?> 
           
		   </div></div>
	<div class="dash_brd">
    	<div id="command_center">
    <div class="lispg_top">	
	<div class="dashboard-sidemenu">
            
            <ul class="subnav">
                <li><a href="<?php echo base_url();?>settings"><?php if($this->lang->line('EditProfile') != '') { echo stripslashes($this->lang->line('EditProfile')); } else echo "Edit Profile";?></a></li>
				<li><a href="<?php echo base_url();?>photo-video"><?php if($this->lang->line('photos') != '') { echo stripslashes($this->lang->line('photos')); } else echo "Photos";?></a></li>
				<li><a href="<?php echo base_url();?>verification"><?php if($this->lang->line('TrustandVerification') != '') { echo stripslashes($this->lang->line('TrustandVerification')); } else echo "Trust and Verification";?></a></li>
                <li><a href="<?php echo base_url();?>display-review"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews";?></a></li>

                <li class="active"><a href="<?php echo base_url();?>display-dispute"><?php if($this->lang->line('Dispute') != '') { echo stripslashes($this->lang->line('Dispute')); } else echo "Dispute";?></a></li>
	
                <li ><a href="users/show/<?php echo $uId;?>"><?php if($this->lang->line('ViewProfile') != '') { echo stripslashes($this->lang->line('ViewProfile')); } else echo "View Profile";?></a></li>
            </ul></div>
            	<div class="listiong-areas" >
    <div class="box">
      <div class="middle">


<?php //echo "<pre>"; print_r($ReviewDetails->result_array()); die;?>

       <div class="tabbable-panel">
      <div class="tabbable-line">
      <ul class="nav nav-tabs ">
      <li>
      <a href="<?php echo base_url();?>display-dispute"><?php if($this->lang->line('Dispute_About_You') != '') { echo stripslashes($this->lang->line('Dispute_About_You')); } else echo "Dispute About You";?></a>
      </li>
      <li>
      <a href="<?php echo base_url();?>display-dispute1"><?php if($this->lang->line('Dispute_By_You') != '') { echo stripslashes($this->lang->line('Dispute_By_You')); } else echo "Dispute By You";?></a>
      </li>
      
	  <li class="active">
      <a href="<?php echo base_url();?>cancel-booking-dispute"><?php if($this->lang->line('cancel_booking_by_you') != '') { echo stripslashes($this->lang->line('cancel_booking_by_you')); } else echo "Cancel booking by you";?></a>
      </li>
	  
	  <li>
      <a href="<?php echo base_url();?>display-dispute2"><?php if($this->lang->line('cancel_booking') != '') { echo stripslashes($this->lang->line('cancel_booking')); } else echo "Cancel booking";?></a>
      </li>
	  
      </ul>
      <div class="tab-content">
      <div id="tab_default_1" class="tab-pane active">
      <?php /*
	  <h2><?php if($this->lang->line('Past_Dispute') != '') { echo stripslashes($this->lang->line('Past_Dispute')); } else echo "Past Dispute";?></h2>
	  */ ?>
	  
	  <h3><?php //if($this->lang->line('Past_Dispute') != '') { echo stripslashes($this->lang->line('Past_Dispute')); } else echo "Past Dispute";?>
	  
	   Cancelled booking by you.
	  </h3>
	  
	  
              <div class="section notification_section">
              <div class="notification_area">
			   <?php 
			  //$count=$DisputeDetails->num_rows();
         $count = count($DisputeDetails);
        if($count >0)
			  {
			  ?>
               <ul class="reviw-loop"> <?php
		  
				foreach($DisputeDetails->result() as $review){
				if($review->loginUserType == 'google')$useImg = $review->image;				
				else if($review->image == '') $useImg=base_url().'images/site/profile.png';
				else $useImg=base_url().'images/users/'.$review->image;
				?>
				<li><div class="img-lefts"><img src="<?php echo $useImg; ?>" width="100" /></div>
				<div class="rigtf-lefts"><span class="revw-area"><?php echo $review->message; ?></span>
				<span class="bookingno-review"><?php echo $review->booking_no; ?></span>
				<span class="by-area"><?php if($this->lang->line('by') != '') { echo stripslashes($this->lang->line('by')); } else echo "by";?> <?php echo $review->email; ?>
				<br><span class=""><?php echo date ('d M y',strtotime($review->created_date)); ?></span>
        <!--<div class="dispute-btns">
        <?php
          /* if($review->status=='Pending'){?>
            <button type="button" onclick="cancelbookingdispute(<?php echo $review->id; ?>,'<?php echo  $review->booking_no; ?>','<?php echo  $review->cancel_status; ?>' );" ><?php if($this->lang->line('Accept') != '') { echo stripslashes($this->lang->line('Accept')); } else echo "Accept";?></button>
                  
            <button type="button" onclick="rejectBooking(<?php echo  $review->id ; ?>,'<?php echo  $review->booking_no; ?>','<?php echo  $review->cancel_status; ?>');"><?php if($this->lang->line('reject') != '') { echo stripslashes($this->lang->line('reject')); } else echo "Reject";?></button>
        <?php  }elseif($review->status=='Accept'){ ?>
		
          <button type="button"><?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel";?></button>
         <?php
        }else
		{?>
			<button type="button"><?php if($this->lang->line('rejected') != '') { echo stripslashes($this->lang->line('rejected')); } else echo "Rejected";?></button>
		<?php } */
        ?></div>-->
        </span>
				</div>
				</li>
				<?php } ?>
				</ul>
				
				<div id="footer_pagination"><?php echo $paginationLink; ?></div>
				
				<?php
				}
			  else{
				  
				   if($this->lang->line('anything_to_cancel') != '')
							{ 
								$anything_to = stripslashes($this->lang->line('anything_to_cancel')); 
							} 
							else
							{
								$anything_to = "You did not book anything to cancel!";
							}
				  
				  
				  echo "<i>$anything_to</i>";
			  }
			  ?>
              </div>
              </div>
 </div>

      <div id="tab_default_2" class="tab-pane">
      <h2><?php if($this->lang->line('ReviewstoWrite') != '') { echo stripslashes($this->lang->line('ReviewstoWrite')); } else echo "Reviews to Write";?> </h2>
              <div class="section notification_section">
              <div class="notification_area">
                <p class="text-lead"><?php if($this->lang->line('Nobodytoreview') != '') { echo stripslashes($this->lang->line('Nobodytoreview')); } else echo "Nobody to review right now. Looks like it's time for another trip!";?>  </p>
             
              </div>
              </div>
              

             
      
      
      </div>
      </div>













    </div>
	 </div> </div></div>
  </div>
         
  </div>
    </div>
</div>
<!---DASHBOARD-->
<!---FOOTER-->

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.css" />
<script type="text/javascript">
	/*jQuery(document).ready( function () {
		$(".datepicker").datepicker({ minDate:0, dateFormat: 'yy-mm-dd'});
	});*/
	
	
	

$(function() {
$( "#datefrom" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
minDate:0,
onClose: function( selectedDate ) {
$( "#expiredate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#expiredate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
minDate:0,
onClose: function( selectedDate ) {
$( "#datefrom" ).datepicker( "option", "maxDate", selectedDate );
}
});
});

/* $(function() {
$( "#datepicker" ).datepicker();
});*/
</script>

<script type="text/javascript">
 /* malar 10/07/2017 for dispute accept & reject */ 
/* function cancelbookingdispute(id,booking_no,cancel_id){


    $.ajax({

        type: 'POST',   

        url:baseURL+'site/product/Cancel_Book',

        data:{'disputeId':id,'booking_no':booking_no,'cancel_id':cancel_id},

        success:function(response){
		
			
          if(response.trim()=='success')
           {
            alert("<?php if($this->lang->line('cancel_booking_accepted') != '') { echo stripslashes($this->lang->line('cancel_booking_accepted')); } else echo "Cancel booking accepted";?>");
            
           } else{
            alert("<?php if($this->lang->line('cancel_booking_failed') != '') { echo stripslashes($this->lang->line('cancel_booking_failed')); } else echo "Accept on cancel booking failed";?>");
            
           }
           window.location.href = baseURL+'site/product/cancel_booking_dispute';
        }

    });

} */
/* function rejectBooking(id,booking_no,cancel_id){
  //alert('rej');
   $.ajax({

        type: 'POST',   

        url:baseURL+'site/product/rejectBooking',

        data:{'disputeId':id,'booking_no':booking_no,'cancel_id':cancel_id},

        success:function(response){
           if(response.trim()=='success')
           {
            alert("<?php if($this->lang->line('cancelation_is_rejected') != '') { echo stripslashes($this->lang->line('cancelation_is_rejected')); } else echo "Cancellation is rejected";?>");
            
           } else{
            alert("<?php if($this->lang->line('cancelation_is_rejected_failed') != '') { echo stripslashes($this->lang->line('cancelation_is_rejected_failed')); } else echo "Reject on Cancellation failed";?>");
            
           }
           window.location.href = baseURL+'site/product/cancel_booking_dispute';
        }

    });
} */
</script>


<?php 
$this->load->view('site/templates/footer');
?>