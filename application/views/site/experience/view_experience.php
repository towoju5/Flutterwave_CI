<?php 
error_reporting(1);
$this->load->view('site/templates/header');
//print_r($productDetails->row());die;
$product = $productDetails->row();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
 

<section>
	<div class="banner-container detail-pgaes">

	    <div class="row">

	        <div class="col-md-12" id="s2">

	            <div id="carousel-example-generic" class="slide">              
	                <ul class="carousel-inner">
						<?php 								
						//var_dump($productImages->result_array());die;
						//echo $productlist->product_image;
						$imgArr = $productImages->result_array(); 
						//echo (count($productImages->result_array()));
						if(count($imgArr)==0)

	    				{?> 
	    					<div class="coverimg">

					          	<li class="item active">

			                   
							     <a href="javascript:void(0);"><img src="<?php if(strpos($imgArr[$i]['product_image'], 's3.amazonaws.com') > 1)echo $imgArr[$i]['product_image'];else echo base_url()."server/php/experience/".$imgArr[$i]['product_image']; ?>" data-gallery="first-gallery" alt=""/></a>

									 

									 <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">

									<span class="left-ars"></span>

								</a>



			                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">

									<span class="right-ars"></span>

								</a>-->

			                        

			                    </li>

				<?php }else {

						for($i=0;$i<count($imgArr);$i++) {
				
						?>

							<li  class="item <?php if($i==0){?>active<?php }?>">

							<a href="javascript:void(0);"><img src="<?php if(strpos($imgArr[$i]['product_image'], 's3.amazonaws.com') > 1)echo $imgArr[$i]['product_image'];else echo base_url()."server/php/experience/".$imgArr[$i]['product_image']; ?>" data-gallery="first-gallery" alt="" id="image-gal-<?php echo $imgArr[$i]['id'];?>"/></a>


							<?php 
							//print_r($imgArr);

							if(count($productImages->result_array())==1)
							//(count($productList->result()) > 0)
							{

							?>
							<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev" >

							<span class="left-ars"></span>

							</a>



							<a class="right carousel-control" href="#carousel-example-generic" data-slide="next" >

							<span class="right-ars"></span>

							</a>-->

							<?php } else{?>
							<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">

							<span class="left-ars"></span>

							</a>



							<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">

							<span class="right-ars"></span>

							</a>
							<?php } ?>


							</li>

					<?php } }?>

			
	                </div>

	                

	            	</ul>

	        	</div>
	        </div>
	    </div>
	</div>
</section>



 
<br>
<br>
<br>
<style>
.cboxLoadedContent{ width:235px !important;}
</style>
<section class="fized-hei-area">

<div class="container">


	<div class="row experienceBlock"  style="padding-top: 20px" >
	<div class="">
		<div class="col-sm-8">

			<table width="" border="0" cellspacing="1" cellpadding="0" align="justify" class="topBlock">              
				<tbody>
					<tr> 
						<td >
							<h2 class="caps"><?php echo $product->experience_title; ?></h2>
							
						</td> 
					</tr>
					<tr> 
						<td >
							<p><?php
								echo $product->city;
								if($product->exp_tagline!='')
								echo ' -'.$product->exp_tagline ; ?>
							</p>
						</td> 
					</tr>
					<tr>
						<td><hr></td>
					</tr>
					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-6">
									<h4><?php echo $product->type_title; ?></h4>
									<p>Sold/Advertised By, <span class=""><?php echo ($product->user_id > 0 && $product->user_id !='')?$product->firstname :'Administrator';?></span></p>
								</div>
								<div class="col-sm-4 pull-right" id="view_prfl_img">
									<img src="<?php if($product->loginUserType == 'google')echo $product->thumbnail;else if($product->thumbnail == '')echo base_url().'images/site/profile.png'; else echo 'images/users/'.$product->thumbnail; ?>" style="height:50px">
				  
								</div>
							</div>
						</td> 
					</tr>

					<tr>
						<td><br></td>
					</tr>

					<tr> 
						<td >
							<ul class="exp-lists">

								<li><i class="fa fa-calendar" aria-hidden="true"></i>     
									<?php 	if($product->date_count>1) echo $product->date_count.' days'; 
											else { 
												/*
												$hr = date('h',strtotime($total_hour));
												$min = date('i',strtotime($total_hour));
												$totHr = $hr+($min/60);
												echo $totHr;
												echo ($totHr>1)?'Hours':'Hour';
												*/
												echo $product->total_hours;	
												echo ($product->total_hours>1)?' Hours':' Hour (Property Inspection)';
											}
									?>	
								</li>
								<?php if($kit_content->num_rows()>0) { ?>
								<li><i class="fa fa-outdent" aria-hidden="true"></i>
									<?php 
										if($kit_content->num_rows()>0) {
											
				                     		foreach ($kit_content->result() as $kit) {
				                     		
				                     			if( $kit->kit_count>0)
					                     			echo $kit->kit_count.'-'; 
					                     		echo $kit->kit_title;
					                     			echo ', ';
					                     		$i++;
					                     	
					                     	} 
					                     
				                     	}  ?>

								</li>
								<?php } ?>
								
								<li><i class="fa fa-comments" aria-hidden="true"></i>
									<b>Property Inspection Offered in : </b>
									<?php 
									if($product->language_list!=''){
									?>
									<?php 
										$i=1;
										if($language_list->num_rows()>0) {
											
				                     		foreach ($language_list->result() as $language) {
				                     			
				                     			
					                     		echo $language->language_name;
					                     		
					                     		if($i!=$language_list->num_rows())
					                     			echo ', ';
					                     		$i++;

					                     	} 
					                     	
				                     	}  ?>
				                     	<?php }else echo "Not done"; ?>
								</li>


							</ul>
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>

					

					<?php if($product->page_view_count>0){ ?> 
					<tr> 
						<td >
							<p>People are eyeing this property. Over <?php echo $product->page_view_count;?> people have viewed it.</p>
									
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>

					<?php } ?>

					

					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-4">
									<h4>Number of Bedrooms: </h4><h4><span class=""><?php echo ($product->user_id > 0 && $product->user_id !='')? $product->F :'Administrator';?></span></h4>
									
								</div>
								<div class="col-sm-8 ">
									<p class="more"><?php if($product->about_host!='') echo  $product->about_host; else echo 'Not Yet Added'; ?>
									</p>
								</div>
							</div>
							
						</td> 
					</tr>

					<tr> 
						<td><hr></td>
					</tr>

					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-4">
									<h4>Number of Bathrooms <h4>
									
								</div>
								<div class="col-sm-8">
									<p class="more"><?php if($product->experience_description!='') echo  $product->experience_description; else echo 'Not Yet Added'; ?></p>
								</div>
							</div>
							
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>

					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-4">
									<h4>Features: <h4>
									
								</div>
								<div class="col-sm-8 ">
									<?php if($kit_content->num_rows()>0) {
					                     		foreach ($kit_content->result() as $kit) {

					                     			if( $kit->kit_count>0)
					                     				echo "<p>";
						                     			echo $kit->kit_count.' - '; 
						                     			echo $kit->kit_detailed_title.' <br>'; 
						                     			echo '<p class="more">'.$kit->kit_description.'</p></p>';
						                     	} 
					                     	}else { echo "Not Applicable"; }  ?>
								</div>
							</div>
							
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>

					<?php /*
						<tr> 
							<td >
								<div class="row">
									<div class="col-sm-4">
										<h4>Notes<h4>
										
									</div>
									<div class="col-sm-8 ">
										<?php if($product->note_to_guest!='') echo  $product->note_to_guest; else echo 'Not Yet Added'; ?>
									</div>
								</div>
								
							</td> 
						</tr>

						<tr>
							<td><hr></td>
						</tr>
					*/?>

					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-4">
									<h4>Property Description:<h4>
									
								</div>
								<div class="col-sm-8 ">
									<p class="more"><?php if($product->note_to_guest!='') echo  $product->note_to_guest; else echo 'Not Yet Added'; ?></p>
								</div>
							</div>
							
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>
					
					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-4">
									<h4>Property Size:<h4>
									
								</div>
								<div class="col-sm-8 ">
									<p class="more"><?php if($product->location_description!='') echo  $product->location_description; else echo 'Not Yet Added'; ?></p>
								</div>
							</div>
							
						
							
						</td> 
					</tr>
					<tr>
						<td><hr></td>
					</tr>

					<tr>  
					

						<td  valign="top" style="color:#000;  font-size:13px;" data-size="body-text" data-min="10" data-max="25" data-color="footer-text">
						<?php /* <img  id="map-image" border="0" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $productDetails->row()->address;?>&zoom=13&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?php echo $productDetails->row()->address; ?>" width="100%">	*/?>
						
						<?php 	$google_map_address=$productDetails->row()->address;
								//echo $google_map_address;
								$google=str_replace(' ','+',$google_map_address);
								$google1=str_replace(',+',',',$google);
								
								//echo $google1;
								//exit;?>
						
						
						<img  id="map-image" border="0" alt="<?php echo $google1;?>" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $google1;?>&zoom=13&size=600x300&maptype=roadmap&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?php echo $google1;?>&key=AIzaSyBxTcwp4mXnhBxXpfPjXp2RkVxLZyeYIwU" width="100%">	

						

						
						
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>
					<?php if($currentUser!='' && $product->user_id>0 && $currentUser!= $product->user_id) { ?>
					<tr>
						 <td><a   data-toggle="modal" class="request-trip" href="#myModal-host">Contact Host</a></td> -->
						<td><a data-toggle="modal" data-target="#contactHost">Contact Host</a></td>-->
						<td><a href="<?php echo base_url().'users/show/'.$product->user_id;?>" target='_blank'>Contact Host</a></td>
					</tr>
					<tr>
						<td><hr></td>
					</tr>
					<?php } ?>
					

					<tr> 
						<td>
							<!-- <h5>Upcoming availability</h5> -->
							<?php 
								if($productDetails->row()->id_verified=="No"){
									?>
									<a href="#" class="customBtn" data-toggle="modal" style="opacity:0.5;display:none;">See all available dates</a>
								<?php }else{ ?>
									<a href="javascript:void(0)" class="customBtn" data-toggle="modal" data-target="#availableDates">See all available property inspection dates</a>
								<?php } ?>
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>

					

					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-4">
									<h4>Number of Toilets:<h4>
									
								</div>
								<div class="col-sm-8 ">
									<p>
									
									<?php 

									$total_slot = $product->group_size  - $booked_experience->num_rows();
									echo $product->group_size."";
									/*if($total_slot >  0){
										
										echo "There are <b>".$total_slot."</b> spots available on this experience.
You don’t have to fill all of them. Experiences are meant to be social, so other travelers could join too.";

 }else echo 'No Spots Available'; */
 ?></p>
 
								</div>
							</div>
							
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>

					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-4">
									<h4>Contact Phone Number(s):<h4>
									
								</div>
								<div class="col-sm-8 ">
									<p class="more"><?php if($product->guest_requirement!='') echo  $product->guest_requirement; else echo 'Not Yet Added'; ?></p>
								</div>
							</div>
							
							
							
							</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>
										<tr> 
						<td >
							<div class="row">
								<div class="col-sm-4">
									<h4>Cancellation Percentage<h4>
									
								</div>
								<div class="col-sm-8 ">
									<p class="more"><?php if($product->cancel_percentage!='') echo  $product->cancel_percentage; else echo '0'; ?>%</p>
								</div>
							</div>
							
							
							
							
							
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>

					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-4">
									<h4> <?php echo $product->cancel_policy; ?>  Cancellation Policy<h4>
									
								</div>
								<div class="col-sm-8 ">
									<p><?php if($product->cancel_policy!='') echo  "Any property inspection can be canceled and fully refunded within 24 hours of booking. See  <a href='".base_url()."pages/cancellation-policy'>cancellation policy</a>."; else echo 'Not Yet Added'; ?></p>
								</div>
							</div>
							
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>


				</tbody>
			</table>  
		</div>










		<div class="col-sm-4 stickyBlock">

			<table width="100%" border="0" cellspacing="1" cellpadding="0" align="justify" style="padding:0px 10px;">              
				<tbody>
					<tr>          

						<td align="center" valign="top" style="color:#000;  font-size:13px;" data-size="body-text" data-min="10" data-max="25" data-color="footer-text">
						<?php  if($product->video_url != ''){  

							$url = $product->video_url;
							preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
		    				//preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
		    				$id = $matches[1];
		    				if($id != ''){
							?>
							<iframe width="100%" height="350px" src="https://www.youtube.com/embed/<?php echo $id ?>?autoplay=1">
							</iframe>
							<?php }else{ ?> 
							<iframe width="100%" height="350px" src="<?php echo $product->video_url."?autoplay=1";?>">
							</iframe> 
							
							<!--<video loop=""  width="100%"  autoplay="" muted="" class="video_vtz4ro" data-reactid="18" playsinline="true"><source type="video/mp4" src="<?php //echo $product->video_url;?>" data-reactid="19"></video>-->


							<?php } }else{

								$product_images = $productImages->result_array();
$r=0;
								if(count($productImages->result_array())>0){ ?>
								<div id="myCarousel" class="carousel slide viewPage" data-ride="carousel">
	<?php
	$count_img=count($productImages->result_array());

	//$carousal_indicator=' <ol class="carousel-indicators">';
		$carousal_inner='<div class="carousel-inner">';

								foreach ($productImages->result_array() as $product_image) {
									
								
									//$product_image = $product_images[0];
								?>

								<?php   if(($product_image['product_image']!='') &&(file_exists('./server/php/experience/'.$product_image['product_image']))){
	
	if($r==0) $atv="active"	;else $atv='';
	$carousal_indicator.=' <li data-target="#myCarousel" data-slide-to="'.$r.'" class="'.$atv.'"></li>';									
			                                    
      $carousal_inner.='<div class="item';
	  if($r==0) $carousal_inner.=" active";
	  $carousal_inner.='">';
	  
         $carousal_inner.='<img src="'.base_url().'server/php/experience/'.$product_image['product_image'].'" style="width:100%;">';
		 
		 
      $carousal_inner.='</div>';
	 
    
			                            
			                            	}
											
											$r=$r+1;
			                        		
											} 
											$carousal_inner.='</div>';
											//$carousal_indicator.=' </ol>';
	
	if($count_img>1){
		echo $carousal_indicator;
	}
		echo $carousal_inner;
		
		if($count_img>1){
			
	?>
	
											

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
	
	<?php
	
		
	}	
											?>
  </div>	
											
											<?php
			                        	}
			                            else if(count($productImages->result_array())==1 ){ 
			                            	$product_image = $product_images[0];

			                            	if(($product_image['product_image']!='') &&(file_exists('./server/php/experience/'.$product_image['product_image']))){ 
											 ?>
			                            		<img src="<?php echo  $product_image['product_image'];?>">
			                            		<?php 
			                            	}
			                            	else if($product_image['product_image']!='' && strpos($product_image['product_image'], 's3.amazonaws.com') > 1){?> 
			                              
			                                 <img src="<?php echo  $product_image['product_image'];?>">
			                              
			                              <?php } else {?>
			                              
                                 <img src="<?php echo  base_url();?>server/php/experience/dummyProductImage.jpg">
			                             
			                            <?php }  } ?>

								<?php

								} ?>	

						<div class="imgBottom clear">
							<div class="left">
								<h4><?php  echo $currencySymbol; ?><?php
									if($productDetails->row()->currency != $this->session->userdata('currency_type')){
										echo convertCurrency($productDetails->row()->currency,$this->session->userdata('currency_type'),$productDetails->row()->price);
									}else{
										echo $productDetails->row()->price;
									}
									?>
									<?php echo $this->session->userdata('currency_type');?> (Property Inspection Dates)</h4>
								
								<?php 
									if(!empty($review_avg_res)){ 
										$avg_val=round($review_avg_res->avg_val);	
										$num_reviewers=$review_avg_res->num_reviewers;	
								?>

								<div class="pointer" data-toggle="modal" data-target="#moreReviews">
								<span class="review_img">
								<span class="review_st" style="width: <?php echo ($avg_val*20); ?>% "></span>
								</span> 
								<span class="reviewTxt">
								<?php if($num_reviewers>0){ echo $num_reviewers; echo ($num_reviewers>1)?' reviews':' review'; ?>
								</span>
								<?php } ?>
								</div>
								
								
								<?php   }?>


							</div>
							<?php 
						
								if($productDetails->row()->id_verified=="No"){
									
									?>
							<div class="right">
								<span data-toggle="modal" style="opacity:0.5;display:none;">See dates</span>
								<p style="color:red;">Host not verified for booking</p>
							</div>
									<?php 
								}else{
							?>
							<div class="right">
								<span data-toggle="modal" data-target="#availableDates">See Property Inspection Dates</span>
							</div>	
							
								<?php 
								} ?>
						</div>
						
						<hr>
						<div class="row marginBottom">

						<div class="col-xs-6">
	                    <div class="">

							<div class="fb-sect">

								<?php /*
									<span class="pull-left"><?php if($this->lang->line('share') != '') { echo stripslashes($this->lang->line('share')); } else echo "share"; ?> : </span>
								*/?>



								<ul class="fbids socialMicons">

									<?php 

									$description=$product->experience_description;

									$url=base_url().'view_experience/'.$product->experience_id;



									$url=urlencode($url);

									//echo $url;die;

									$facebook_share='http://www.facebook.com/sharer.php?u='.$url;

									//$google_plus_share='https://accounts.google.com/share?url='.$url;

									$twitter_share='https://twitter.com/share?url="'.$url.'"';?>

									<li><a class="fba1" target="_blank" href="<?php echo $facebook_share;?>"><i class="fa fa-facebook"></i></a></li>

									<!--<li><a class="fba2" target="_blank" href="<?php echo $google_plus_share;?>"></a></li>-->

									<!--<li><a class="fba3" target="_blank" href="<?php echo $this->config->item('pinterest');?>"></a></li>-->

									<li>	
										<a class="fba4" target="_blank" href="<?php echo $twitter_share;?>"><i class="fa fa-twitter"></i></a>
									</li>

									<li>
										<a class="fba2" href="https://plus.google.com/share?url={<?php echo $url; ?>}" onclick="javascript:window.open(this.href,

										'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a>
									</li>

								</ul>



							</div>


							</div>	
							</div>

						<?php  if (! in_array($product->experience_id, $newArr)){    ?>

							<div class="col-xs-6 txt_aln_agn">
			                <div class="heart-list text-right ">
			                    <?php if($loginCheck!=''){
									
									if($loginCheck!=$product->user_id){
										
									?>

			                    <a class="ajax cboxElement" href="site/experience/AddWishListForm/<?php echo $product->experience_id;?>" style="pointer:cursor"><?php if($this->lang->line('header_add_list') != '') { echo stripslashes($this->lang->line('header_add_list')); } else echo "Save to Wish List"; ?></a>

			                    <?php 
								
									}
								} else {?>

			                    <a  class="login-popup ajax cboxElement" href="site/experience/AddWishListForm/<?php echo $product->experience_id;?>" style="pointer:cursor"><i class="fa fa-heart-o colsds"></i><?php if($this->lang->line('header_add_list') != '') { echo stripslashes($this->lang->line('header_add_list')); } else echo "Save to Wish List"; ?></a>

			                    <?php }?>
			                </div>
			                </div>
			            <?php   } ?>		

			            
							</div>
						</td> 
					</tr>
				
				</tbody>
			</table>  
		</div>
		</div>
		<div class="col-sm-12 clear" id="similar_exp">
		
		
			<?php
			
			//print_r($ExperienceCatBasedList->result_array());
			
			if($product->city!='') { 
				$count=0;
				//ExperienceCityBasedList
				
				if($ExperienceCatBasedList->num_rows()>0){

			 ?>
			 
			<h3>Similar Properties in <?php echo $product->type_title;?></h3>

            <div class="row">
         		<div class="col-md-12" id="col_marg">
		            <div id="news-slider3" class="owl-carousel popular-listing">
		            	
					<?php  //echo("<pre>");print_r($product->result());die; ?>
					<?php
						foreach($ExperienceCatBasedList->result_array() as $product_image )
						{ $count++;
							if(($count%5)==0)
							{ 
								$li_class_name='big-poplr';
							}else {
								$li_class_name='';
							}
							?>

							<div class="post-slide popular-listing">
							 <div class="<?php echo $li_class_name; ?> ">
		                        <div class="img-top">
			                        <div class="figures-cobnt">
			                           <?php   if(($product_image['product_image']!='') &&(file_exists('./server/php/experience/'.$product_image['product_image'])))
			                            {?>
			                               <a href="<?php echo base_url();?>view_experience/<?php echo $product_image['experience_id']; ?>">
			                            <img src="<?php echo base_url();?>server/php/experience/<?php echo $product_image['product_image'];?>">
			                            </a>
			                            <?php }else if($product_image['product_image']!='' && strpos($product_image['product_image'], 's3.amazonaws.com') > 1){?> 
			                              <a href="<?php echo base_url();?>view_experience/<?php echo $product_image['experience_id']; ?>">
			                                 <img src="<?php echo  $product_image['product_image'];?>">
			                              </a>
			                              <?php } else {?>
			                              <a href="<?php echo base_url();?>view_experience/<?php echo $product_image['experience_id']; ?>">
			                                 <img src="<?php echo  base_url();?>server/php/experience/dummyProductImage.jpg">
			                              </a>
			                            <?php } ?>
			                        </div>
			                        <div class="posi-abs" id="popular_star">
			                          <!-- <a href="<?php echo base_url();?>rental/<?php echo $product_image['id']; ?>"  class="heart"> </a>-->
			                          <?php /* if($loginCheck==''){?>
			                          <a class="ajax cboxElement heart reg-popup" href="site/rentals/AddWishListForm/<?php echo $product_image['id'];?>"></a>

			                          <?php } else { ?>
			                          <a class="ajax cboxElement <?php if(in_array($product_image['id'],$newArr))echo 'heart-exist'; else echo 'heart';?>" href="site/rentals/AddWishListForm/<?php echo $product_image['id'];?>"></a>
			                          <?php } */ ?>
                                     
                                     
                                      <label 
 
             class="pric-tag"><?php echo $this->session->userdata('currency_s');

										if($product_image['currency'] != $this->session->userdata('currency_type')){
											 $experience_price= convertCurrency($product_image['currency'],$this->session->userdata('currency_type'),$product_image['price']);
										}else{
											 $experience_price= $product_image['price'];
										}

			                          echo $experience_price; ?>
			                         
			                            

			                          </label>

			                          <?php 
			                          $base =base_url();
			                          $url=getimagesize($base.'images/users/'.$product_image['user_image']);
			                          if(!is_array($url))
			                          {
			                            $img="1"; //no
			                          }
			                          else {
			                            $img="0";  //yes
			                          }

			                          //To Check whether the image is exist in Local Directory..
			                          ?>  



			                          <a class="aurtors num2" href="<?php echo base_url();?>users/show/<?php echo $product_image['user_id'];?>">
			                             <img src="<?php echo base_url();?><?php

			                              if($product_image['user_image']!='' && $img=='0'){
			                              echo 'images/users/'.$product_image['user_image'];
			                              }else if ($img=='1'){
			                              echo 'images/user_unknown.jpg';
			                              }


			                              ?>" style="border-radius: 50%;">
			                              </a>
			                          <label class="headlined23"><a href="view_experience/<?php echo $product_image['experience_id']; ?>"><?php  echo $product_image['experience_title'];?></a></label>

			                        </div>
		                        </div>
		                        <div class="img-bottom">

								  <?php 
									if(!empty($product_image)){ 
										$avg_val=round($product_image['avg_val']);	
										$num_reviewers=$product_image['num_reviewers'];	
								?>

								<div class="pointer" data-toggle="modal" data-target="#moreReviews_Similar_<?php echo $product_image['experience_id']; ?>">
								<span class="review_img">
								<span class="review_st" style="width: <?php echo ($avg_val*20); ?>% "></span>
								</span> 
								<span class="rew">
								
								<?php 
								
								if($num_reviewers>0){
								if($this->lang->line('Reviews') != '') { $reviewTxt=stripslashes($this->lang->line('Reviews')); } else $reviewTxt="Reviews"; 
								
								}else{
									if($this->lang->line('Review') != '') { $reviewTxt=stripslashes($this->lang->line('Review')); } else $reviewTxt="Review"; 
								}
								
								?>
								
								<?php if($num_reviewers>0){ echo $num_reviewers." ".$reviewTxt; ?>
								</span>
								<?php } ?>
								</div>
								
								
								<?php   }?>
								
		                        <p class="describ"><?php  echo $product_image['city'];?></p>
		                        </div>

		                        </div>
		                        </div>
							<?php  	
						}
					 ?>

		            </div>
            	</div>
            </div>



				<div>
				
			
			</div>
			<?php }
			} ?>
		</div>
		

		   
	</div>	


</div>
</section>


<!-- Modal -->
	<div id="moreReviews" class="modal fade customModal" role="dialog">
  	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <span  class="close" data-dismiss="modal">&times;</span>
		        <h3 class="modal-title"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews"; ?></h3>
	      	</div>
			<div class="modal-body">

				<?php
				foreach ($user_reviewData->result() as $review) {
					
			?>
					<div class="reviewBlock clear">
						<div class="left">
							<?php   //if(($review->image!='') &&(file_exists(base_url().'images/users'.$review->image)))
	                        if($review->image!=''){?>
	                           
	                        <img src="<?php echo base_url();?>images/users/<?php echo $review->image;?>" style="width:50px;height:50px;">
	                       
	                        <?php }else {?>
	                          
	                             <img src="<?php echo  base_url();?>images/site/profile.png">
	                          
	                        <?php } ?>
						</div>
						<div class="right">
							<h4><?php echo $review->firstname.' '.$review->lastname;	?>
							</br><small><?php echo date('d F Y',strtotime($review->dateAdded));?></small></h4>
							<span class="review_img">
							<span class="review_st" style="width: <?php echo ($review->total_review*20); ?>% "></span>
							</span>
						</div>
						<p class="reviewContent more"><?php echo $review->review;?></p>
					</div>
					<hr>

				<?php 	
						
					}	
				?>	


			</div>
	    </div>

	  </div>		
	</div>
	
	
	
<!-- Modal Similar Listing Review-->
<?php foreach($ExperienceCatBasedList->result_array() as $product_imageS ) {
 ?>
	<div id="moreReviews_Similar_<?php echo $product_imageS['experience_id']; ?>" class="modal fade customModal" role="dialog">
  	<div class="modal-dialog">
	<?php $exp_id=$product_imageS['experience_id']; 	?>
	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <span  class="close" data-dismiss="modal">&times;</span>
		        <h3 class="modal-title"><?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews"; ?></h3>
	      	</div>
			<div class="modal-body">

				<?php
				foreach ($user_reviewData_similar[$exp_id]->result() as $review) {
	
			?>
					<div class="reviewBlock clear">
						<div class="left">
							<?php   
	                        if($review->image!=''){?>
	                           
	                        <img src="<?php echo base_url();?>images/users/<?php echo $review->image;?>" style="width:50px;height:50px;">
	                       
	                        <?php }else {?>
	                          
	                             <img src="<?php echo  base_url();?>images/site/profile.png">
	                          
	                        <?php } ?>
						</div>
						<div class="right">
							<h4><?php echo $review->firstname.' '.$review->lastname;	?>
							</br><small><?php echo date('d F Y',strtotime($review->dateAdded));?></small></h4>
							<span class="review_img">
							<span class="review_st" style="width: <?php echo ($review->total_review*20); ?>% "></span>
							</span>
						</div>
						<p class="reviewContent more"><?php echo $review->review;?></p>
					</div>
					<hr>

				<?php 	
						
					}	
				?>	


			</div>
	    </div>

	  </div>		
	</div>
<?php } ?>

<div id="contactHost" class="modal fade customModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close" data-dismiss="modal">&times;</span>
        <h3 class="modal-title"><?php if($this->lang->line('Need_more_info_about') != '') { echo stripslashes($this->lang->line('Need_more_info_about')); } else echo "Need more info about"; ?> <?php echo ($product->user_id > 0 && $product->user_id !='')?$product->firstname :'Administrator';?>?</h3>
        
      </div>
      <div class="modal-body">
      <p><?php if($this->lang->line('general_experience') != '') { echo stripslashes($this->lang->line('general_experience')); } else echo "If you have general questions about how experiences work"; ?>, <a >
	  <?php if($this->lang->line('visit_our_FAQ') != '') { echo stripslashes($this->lang->line('visit_our_FAQ')); } else echo "visit our FAQ"; ?>
	  </a></p>
        <form method="POST" action ="site/experience/add_conctact_msg">

        	<input type="hidden" id="rental_id" name="rental_id" value="<?php echo $product->experience_id; ?>" />
        	<input type="hidden" id="experience_title" name="experience_title" value="<?php echo $product->experience_title; ?>" />
			<input type="hidden" id="sender_id" name="sender_id" value="<?php echo $currentUser; ?>" />
			<input type="hidden" id="receiver_id" name="receiver_id" value="<?php echo $product->user_id; ?>" />
			<input type="hidden" id="posted_by" name="posted_by" value="customer" />
			<input type="hidden" id="redirect" name="redirect" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>" />	

        	<textarea class="form-control" rows="5" placeholder="<?php if($this->lang->line('Make_sure_to_introduce_yourself') != '') { echo stripslashes($this->lang->line('Make_sure_to_introduce_yourself')); } else echo "Make sure to introduce yourself!"; ?>"></textarea>
        	<input type="submit" name="" class="customButton" value="<?php if($this->lang->line('Send_Message') != '') { echo stripslashes($this->lang->line('Send_Message')); } else echo "Send Message"; ?>">
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="availableDates" class="modal fade customModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close" data-dismiss="modal">&times;</span>
        <h3 class="modal-title"><?php if($this->lang->line('When_do_you_go') != '') { echo stripslashes($this->lang->line('When_do_you_go')); } else echo "When do you want to go?"; ?></h3>
        
      </div>
      <div class="modal-body">
      <p><?php if($this->lang->line('if_cant_find_cnt_host') != '') { echo stripslashes($this->lang->line('if_cant_find_cnt_host')); } else echo "If you can’t find the dates you want, try contacting the host"; ?></p>
        <?php if($datesList->num_rows()>0){

			foreach ($datesList->result() as $date) {
				$dateId  = $date->id;
				$schedule = $datesSchedule[$dateId]; 
				$available_slots=($date->group_size-$date->date_booked_count);
				if($schedule->num_rows()>0 && $available_slots>0){
			 ?>
				<div class="row">
					
					<div class="col-sm-8">
						

						<h4>
							<?php 
							if($product->date_count>1)	
							{
								echo date('M, dS Y', strtotime($date->from_date)). ' - ' .date('M, dS Y',strtotime( $date->to_date));
							}else{
								echo date('M, dS Y',strtotime($date->from_date));
							}	
							?>
						</h4>

						<?php if($date->price!=''){ ?>
						<span class="title"> <?php  echo $currencySymbol; ?><?php
							if($productDetails->row()->currency != $this->session->userdata('currency_type'))
							{
								echo convertCurrency($productDetails->row()->currency,$this->session->userdata('currency_type'),$productDetails->row()->price);
							}
							else{
								echo $productDetails->row()->price;
							}
							?>
							<?php echo $this->session->userdata('currency_type');?>
							 <?php if($this->lang->line('perperson') != '') { echo stripslashes($this->lang->line('')); } else echo ""; ?>
						</span> 
						<?php  } ?>

						<!-- date experience schedule  -->	
						<?php 

							echo "<p class='toggleSchedule_p'><span class='toggleSchedule'>Read Schedules</span> <small>- ".$available_slots." "; if($this->lang->line('slots_available') != '') { echo stripslashes($this->lang->line('slots_available')); } else echo "slots available"; echo "</small> </p><div class='scheduleDetails'>";
							foreach ($schedule->result() as $sched) {
								
						?>
								<div>
									<?php 
									echo '<b>'.$sched->title.'</b><br>'; 
									
									echo date('D, dS Y',strtotime($sched->schedule_date));
									echo '<div class="timings">'.date('h:i a ',strtotime($sched->start_time)).' - '. date('h:i a',strtotime($sched->end_time)).'</div>' ;
									?>
									<!--
									Rooftop Sunset DTLA
									Thu, 10th Aug · 18:30 − 20:30 -->

								</div>
						<?php }
						echo "</div>";
						//} ?>
						<!-- date experience schedule ends  -->	

						
						
					</div>
					<div class="col-sm-4 ">
					
					
						<input type="hidden" id="user_id" value="<?php echo $loginCheck; ?>">	
						<input type="hidden" id="renter_id" value="<?php echo $productDetails->row()->user_id; ?>">	
						<a <?php   if($loginCheck==''){ ?> class="login-popup booking-btn" <?php } else { ?>  class="booking-btn"  onclick="bookNow(<?php echo $dateId; ?>);" href="javascript:void(0);" <?php } ?> ><?php  echo "choose Date"; ?></a>

					
						
					</div>
				</div>
				<hr>
		<?php 
				}//no time schedule
			}
		} else echo "No Dates .";?>
      </div>
    </div>

  </div>
</div>

	<div id="myModal-host" class="modal fade in myModal-host-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:400px;width:500px">
		<div class="modal-dialog">
			<div class="modal-content" id="pre_approve_reject">
				<div class="modal-header" id="address-modal">

					<a class="btn btn-default close-btn" data-dismiss="modal" onclick="click_test()" id="pre-approve-close"><span class="">x</span></a>


					<div class="msg-header-left">
						<?php if($this->lang->line('contact_host') != '') { echo stripslashes($this->lang->line('contact_host')); } else{ echo "Contact Host"; }?>
					</div>


					<div class="msg-header-right">

					</div>


				</div>
				<div class="modal-body msg-host-form">


					<div id="pre_approve_accept" style="display:block">


						<div class="top-title" style="display:none">

						</div>							 

						<ul class="chekin-list" style="border:none">

							<li>

								<label><?php if($this->lang->line('check_in') != '') { echo stripslashes($this->lang->line('check_in')); } else echo "check in"; ?></label>
							<input type="text" placeholder="<?php if($this->lang->line('dd-mm-yyyy') != '') { echo stripslashes($this->lang->line('dd-mm-yyyy')); } else echo "dd-mm-yyyy";?>" id="datefromContact" class="checkout ui-datepicker-target" autocomplete="off"/> 
							<!-- <input type="text" placeholder="dd-mm-yyyy" autocomplete="off" name="datefrom" readonly="readonly" id="datefromContact" class="checkin ui-datepicker-target" /> -->

							</li>
							<li>
								<label><?php if($this->lang->line('check_out') != '') { echo stripslashes($this->lang->line('check_out')); } else echo "check out"; ?></label>

								<input type="text" placeholder="<?php if($this->lang->line('dd-mm-yyyy') != '') { echo stripslashes($this->lang->line('dd-mm-yyyy')); } else echo "dd-mm-yyyy";?>" name="expiredate" autocomplete="off"  id="expiredateContact" onchange="return DateBetweenContact();" class="checkout ui-datepicker-target">
							</li>
							<li>

								<label><?php if($this->lang->line('Guest') != '') { echo stripslashes($this->lang->line('Guest')); } else echo "Guest"; ?></label>

								<select id="number_of_guests_contact" name="number_of_guests_contact" style="width:50px; margin: 0 !important;"onchange="myfunctionContact(this.value);">

								<?php for($i=1;$i<=$product->accommodates;$i++){ echo '<option value="'.$i.'">'.$i.'</option>';}?>

								</select>
								<div id="contact_host_hidden">
								</div>
							</li>

							<li style="width:100%;"><textarea  name="review" id="offer_message_contact" class="scroll_newdes" style="height:90px;" onkeypress="return IsEmpty('title');"></textarea>

							</li>

							<a class="booking-btn" id="contactMsg" style="width:96% !important;"><?php if($this->lang->line('Send Message') != '') { echo stripslashes($this->lang->line('Send Message')); } else echo "Send Message"; ?></a>

						</ul>
					</div>


				</div>



			</div>		
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dalog -->


<script type="text/javascript">
	function bookNow(date_id) {
			
		var user_id = $('#user_id').val();
		var renter_id = $('#renter_id').val();
		if(user_id==renter_id){	
			alert("Booking not allowed.");
			return false;
		}else{ 
			//window.location="<?php //echo base_url().'site/experience/experience_booking_instant/'?>"+date_id;
			window.location="<?php echo base_url().'site/experience/experience_booking_enquiry/'?>"+date_id;

		}
	}

</script>
<?php

$this->load->view('site/templates/footer');?>

<div style="display:none">

<?php $this->load->view('site/popup/list');?>

</div>

<!---popup banner jquery-->
<script>
	$(document).on("click",".toggleSchedule_p",function(){
		$(this).next(".scheduleDetails").slideToggle();
	});
</script>


 <script>
 /*
 function show_more_and_less(char_count=200){
	alert(char_count);
	var showChar = char_count;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = " more";
    var lesstext = " less";
    

    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
	
	
}*/

show_more_and_less(200);

$(document).ready(function() {
    $("#news-slider3").owlCarousel({
        items : 3,
        itemsDesktop:[1199,3],
        itemsDesktopSmall:[980,2],
        itemsMobile : [600,1],
        navigation:true,
        navigationText:["",""],
        pagination:true,
        autoPlay:false
    });
	
});
 </script>