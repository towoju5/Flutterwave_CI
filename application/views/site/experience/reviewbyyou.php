<?php 
$this->load->view('site/templates/header');
?>

<link rel="stylesheet" type="text/css" href="css/colorbox.css" media="all" />
<link href="css/page_inner.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/my-account.css" type="text/css" media="all"/>
<script type="text/javascript" src="js/site/SpryTabbedPanels.js"></script>


<script type="text/javascript" src="js/site/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="js/site/jquery.galleryview-3.0-dev.js"></script>
<!-- script added 14/05/2014 -->

<!-- script end -->

<!---DASHBOARD-->
<div class="dashboard  yourlisting bgcolor profle_rvwpg">

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
            <div class="listiong-areas" >
              <div class="box">
                  <div class="middle">




       <div class="tabbable-panel">
      <div class="tabbable-line">
      <ul class="nav nav-tabs ">
      <li>
      <a href="<?php echo base_url();?>experience-review"><?php if($this->lang->line('ReviewsAboutYou') != '') { echo stripslashes($this->lang->line('ReviewsAboutYou')); } else echo "Reviews About You";?></a>
      </li>
      <li class="active">
      <a href="<?php echo base_url();?>experience-review1"><?php if($this->lang->line('ReviewsbyYou') != '') { echo stripslashes($this->lang->line('ReviewsbyYou')); } else echo "Reviews by You";?></a>
      </li>
      
      </ul>
      <div class="tab-content">
      <div id="tab_default_1" class="tab-pane active">
       
              <div class="section notification_section">
              <div class="notification_area">
			  <?php 
			  $count=$ReviewDetails->num_rows();
			  if($count >0)
			  {
			  ?>
                <ul class="reviw-loop">
				<?php 
				
				//print_r($ReviewDetails->result());
				
				foreach($ReviewDetails->result() as $review){
				if($review->loginUserType == 'google')$useImg = $review->image;								else if($review->image == '') $useImg=base_url().'images/site/profile.png';				else $useImg=base_url().'images/users/'.$review->image;				?>				
				
				<li>
				
				<div class="img-lefts" style="width:20%;text-align:left;">
				<img src="<?php echo $useImg; ?>" width="100" />
				
				<br>
				<span class="by-area">
				
				<?php if($this->lang->line('by') != '') { echo stripslashes($this->lang->line('by')); } else echo "by";?> 

					<h4>  <?php echo $review->firstname.' '.$review->lastname;	?>(<?php echo $review->email; ?>)
					<br><small>On <?php echo date('d F Y',strtotime($review->dateAdded));?></small></h4>
				
				</span>
				
				</div>
				
				<div class="rigtf-lefts" style="width:80%;text-align:justify;">
				<div>
				<span class="review_img" ><img class="review_st" style=" padding:10px 0px; width:<?php echo $review->total_review * 20?>%"></span>
				
				<span class="right"><small>
				<span style="font-style: normal;color: #817d7d;float:right;">
					<?php if($this->lang->line('at') != '') {  echo stripslashes($this->lang->line('at')); }else echo "at";?>
					
					<?php echo "<a href='".base_url()."view_experience/".$review->product_id."'>".$review->product_title."</a>";?>
					
					<?php if($this->lang->line('for') != '') {  echo stripslashes($this->lang->line('for')); }else echo "for";?>
					
					<?php if($this->lang->line('Booking No') != '') { echo stripslashes($this->lang->line('Booking No')); } else echo "Booking No"?>: <?php echo "<b>".$review->bookingno."</b>"; ?>
					</span>
					</small></span>
					</div>
				<br>
				<br>
				<p style="text-align: justify;float: left;">
				<span class="more"><?php echo $review->review; ?></span>
				</p>

				
				</div>
				
				</li>
				<?php } ?>
				</ul>
				<?php 
			  }
			  else{
				  echo '<i>No reviews posted by you!</i>';
			  }
			  ?>
              </div>
              </div>
              

             
      
      
      </div>
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
      <div id="tab_default_2" class="tab-pane">
    <h2><?php if($this->lang->line('ReviewstoWrite') != '') { echo stripslashes($this->lang->line('ReviewstoWrite')); } else echo "Reviews to Write";?> </h2>
              <div class="section notification_section">
              <div class="notification_area">
                <p class="text-lead"> <?php if($this->lang->line('Nobodytoreview') != '') { echo stripslashes($this->lang->line('Nobodytoreview')); } else echo "Nobody to review right now. Looks like it's time for another trip!";?> </p>
             
              </div>
              </div>
              

             
      
      
      </div>
      </div>
      <div id="footer_pagination"><?php echo $paginationLink; ?></div>











         		<div style="float:left; width:100%; display:none">

             <h1> <?php if($this->lang->line('ReviewsByYou') != '') { echo stripslashes($this->lang->line('ReviewsByYou')); } else echo "Reviews By You";?> </h1>
             <div class="section notification_section" style="width:100%;">
				      <div class="reviews">		 
  	      
                         
                 				   <?php
								   
								 if($ReviewDetails->num_rows() >0){
								    foreach($ReviewDetails->result() as $row)
									    	{ ?>
                                    
                                        
                                <div class="media">
                                    <div class="pull-left">
                                      <a class="media-photo media-link row-space-1" href="rental/<?php echo $row->product_id; ?>"><img width="68" height="68" title="<?php echo $row->product_title; ?>" src="<?php if(strpos($row->product_image, 's3.amazonaws.com') > 1)echo $row->product_image;else echo base_url()."server/php/rental/".$row->product_image; ?>" class="lazy" alt="<?php echo $row->product_title; ?>" style="display: inline;"></a>
                                        <div class="text-center profile-name">
                                          <a href="rental/<?php echo $row->product_id; ?>"><?php echo substr($row->product_title, 0, 10); ?></a>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                      <div class="panel panel-quote panel-dark row-space-2">
                                        <div class="panel-body clearfix">
                                          <div class="comment-container truncate row-space-2">
                                            <p>
                                             <?php echo $row->review; ?>
                                            </p>
                                            <div class="more-trigger text-center">
                                              <i class="icon icon-chevron-down h3"></i>
                                            </div>
                                          </div>
                                            
                                          <div class="text-muted date"><?php echo $row->dateAdded; ?></div>
                                        </div>
                                      </div>

                                    </div>
                                  </div>
                                        	<?php	}}else{ ?>
                                            <?php if($this->lang->line('Noonehasreviewed') != '') { echo stripslashes($this->lang->line('Noonehasreviewed')); } else echo "No one has reviewed you yet.";?>
                                            <?php } ?>
                                       </div>
          </div>
          		<h1><?php if($this->lang->line('ReviewsAboutYou') != '') { echo stripslashes($this->lang->line('ReviewsAboutYou')); } else echo "Reviews About You";?></h1>
                
				<div class="section notification_section" style="width:100%;">
				<div class="reviews">		 
  	      
                         
                 				   <?php
								   if(isset($UReviewDetails)){
								 if($UReviewDetails->num_rows() >0){
								    foreach($UReviewDetails->result() as $row)
									    	{ ?>
                                    
                                        
                                <div class="media">
                                    <div class="pull-left">
                                      <a class="media-photo media-link row-space-1" href="rental/<?php echo $row->product_id; ?>"><img width="68" height="68" title="<?php echo $row->product_title; ?>" src="<?php if(strpos($row->product_image, 's3.amazonaws.com') > 1)echo $row->product_image;else echo base_url()."server/php/rental/".$row->product_image; ?>" class="lazy" alt="<?php echo $row->product_title; ?>" style="display: inline;"></a>
                                        <div class="text-center profile-name">
                                          <a href="rental/<?php echo $row->product_id; ?>"><?php echo substr($row->product_title, 0, 10); ?></a>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                      <div class="panel panel-quote panel-dark row-space-2">
                                        <div class="panel-body clearfix">
                                          <div class="comment-container truncate row-space-2">
                                            <p>
                                             <?php echo $row->review; ?>
                                            </p>
                                            <div class="more-trigger text-center">
                                              <i class="icon icon-chevron-down h3"></i>
                                            </div>
                                          </div>
                                            
                                          <div class="text-muted date"><?php echo $row->dateAdded; ?></div>
                                        </div>
                                      </div>

                                    </div>
                                  </div>
                                        	<?php	}}else{ ?>
                                            <?php if($this->lang->line('Nobodytoreview') != '') { echo stripslashes($this->lang->line('Nobodytoreview')); } else echo "Nobody to review right now. Looks like it's time for another trip!";?> 
								   <?php } } ?>
                                       </div>
          </div>
    <div class="clearfix"></div>
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
show_more_and_less(200);
</script>



<?php 
$this->load->view('site/templates/footer');
?>