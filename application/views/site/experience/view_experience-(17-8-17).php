<?php 
error_reporting(1);
$this->load->view('site/templates/header');
//print_r($productDetails->row());die;
$product = $productDetails->row();
?>
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

									 

									 <!--<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">

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
							<!--<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev" >

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


<section class="fized-hei-area">

<div class="container">


	<div class="row experienceBlock"  style="padding-top: 20px" >
	<div class="pull-left">
		<div class="col-sm-8">

			<table width="100%" border="0" cellspacing="1" cellpadding="0" align="justify" class="topBlock">              
				<tbody>
					<tr> 
						<td >
							<h2 class="caps"><?php echo $product->experience_title; ?></h2>
						</td> 
					</tr>
					<tr> 
						<td >
							<p><?php echo $product->city.' -'.$product->short_description ; ?></p>
						</td> 
					</tr>
					<tr>
						<td><hr></td>
					</tr>
					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-8">
									<h4><?php echo $product->type_title; ?></h4>
									<p>Hosted By, <span class="caps"><?php echo ($product->user_id > 0 && $product->user_id !='')?$product->firstname :'Administrator';?></span></p>
								</div>
								<div class="col-sm-4 pull-right">
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
												echo ($product->total_hours>1)?'Hours':'Hour';
											}
									?>	
								</li>
								<li><i class="fa fa-outdent" aria-hidden="true"></i>
									<?php 
										if($kit_content->num_rows()>0) {
											
				                     		foreach ($kit_content->result() as $kit) {
				                     		
				                     			if( $kit->kit_count>0)
					                     			echo $kit->kit_count.' '; 
					                     		echo $kit->kit_title;
					                     	
					                     	} 
					                     
				                     	}  ?>

								</li>
								
								<li><i class="fa fa-comments" aria-hidden="true"></i>
									Languages :
									<?php 
									if($product->language_list!=''){
									?>
									<?php 
										$i=1;
										if($language_list->num_rows()>0) {
											
				                     		foreach ($language_list->result() as $language) {
				                     			
				                     			
					                     		echo $language->language_name;
					                     		
					                     		if($i!=$language_list->num_rows())
					                     			echo ',';
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
							<p>People are eyeing this experience. Over <?php echo $product->page_view_count;?> people have viewed it.</p>
									
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
									<h4>About your host, <span class="caps"><?php echo ($product->user_id > 0 && $product->user_id !='')?$product->firstname :'Administrator';?></span><h4>
									
								</div>
								<div class="col-sm-8 ">
									<p><?php if($product->description1!='') echo  $product->description1; else echo 'Not Yet Added'; ?>
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
									<h4>What we’ll do <h4>
									
								</div>
								<div class="col-sm-8 ">
									<p><?php if($product->experience_description!='') echo  $product->experience_description; else echo 'Not Yet Added'; ?></p>
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
									<h4>What I’ll provide <h4>
									
								</div>
								<div class="col-sm-8 ">
									<?php if($kit_content->num_rows()>0) {
					                     		foreach ($kit_content->result() as $kit) {

					                     			if( $kit->kit_count>0)
					                     				echo "<p>";
						                     			echo $kit->kit_count.' - '; 
						                     			echo $kit->kit_detailed_title.' -'; 
						                     			echo $kit->kit_description.'</p>';
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
									<h4>Where we’ll be<h4>
									
								</div>
								<div class="col-sm-8 ">
									<p><?php if($product->location_description!='') echo  $product->location_description; else echo 'Not Yet Added'; ?></p>
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
									<h4>Notes<h4>
									
								</div>
								<div class="col-sm-8 ">
									<p><?php if($product->note_to_guest!='') echo  $product->note_to_guest; else echo 'Not Yet Added'; ?></p>
								</div>
							</div>
							
						</td> 
					</tr>

					<tr>
						<td><br></td>
					</tr>

					<tr>          

						<td  valign="top" style="color:#000;  font-size:13px;" data-size="body-text" data-min="10" data-max="25" data-color="footer-text">
						<img  id="map-image" border="0" alt="<?php echo $productDetails->row()->address; ?>" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $productDetails->row()->address;?>&zoom=13&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?php echo $productDetails->row()->address; ?>" width="100%">	

						
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>
					<?php if($currentUser!='' && $product->user_id>0 && $currentUser!= $product->user_id) { ?>
					<tr>
						<!-- <td><a   data-toggle="modal" class="request-trip" href="#myModal-host">Contact Host</a></td> -->
						<!--<td><a data-toggle="modal" data-target="#contactHost">Contact Host</a></td>-->
						<td><a href="<?php echo base_url().'users/show/'.$product->user_id;?>" target='_blank'>Contact Host</a></td>
					</tr>
					<tr>
						<td><hr></td>
					</tr>
					<?php } ?>
					

					<tr> 
						<td>
							<!-- <h5>Upcoming availability</h5> -->
							<a href="javascript:void(0)" class="customBtn" data-toggle="modal" data-target="#availableDates">See all available dates</a>
						</td> 
					</tr>

					<tr>
						<td><hr></td>
					</tr>

					<tr>
						<td>
							<h3>Reviews</h3>
							<?php 
							if(!empty($user_reviewData))
							{
								if($user_reviewData->num_rows()>0){
									$i=1;
									foreach ($user_reviewData->result() as $review) {
										if($i<5){
								?>
										<div class="reviewBlock clear">
											<div class="left">
												<?php   if(($review->image!='') &&(file_exists(base_url().'images/users'.$review->image)))
					                            {?>
					                               
					                            <img src="<?php echo base_url();?>images/users<?php echo $review->image;?>">
					                           
					                            <?php }else {?>
					                              
					                                 <img src="<?php echo  base_url();?>images/site/profile.png">
					                              
					                            <?php } ?>
											</div>
											<div class="right">
												<h4><?php echo $review->firstname.' '.$review->lastname;	?></h4>
												<small><?php echo date('d F Y',strtotime($review->dateAdded));?></small>
											</div>
											<p class="reviewContent"><?php echo $review->review;?></p>
										</div>
										<hr>

								<?php 	
										}else{ break;};
									}
								}else{
									echo "Not yet Reviewed.<hr>";
								}

								?>

							<?php if($user_reviewData->num_rows()>1){ ?>
							<span class="customButton1" data-toggle="modal" data-target="#moreReviews" >
							Read all <?php echo $user_reviewData->num_rows();
							echo ($user_reviewData->num_rows()>1)?'Reviews':'Review'; ?></span>
							<hr>
							<?php } 

							}
							?>
							
						</td>
					</tr>



					<tr> 
						<td >
							<div class="row">
								<div class="col-sm-4">
									<h4>Group size<h4>
									
								</div>
								<div class="col-sm-8 ">
									<p><?php if($product->group_size!='') echo  $product->group_size; else echo 'Not Yet Added'; ?></p>
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
									<h4>Guest requirements<h4>
									
								</div>
								<div class="col-sm-8 ">
									<p><?php if($product->guest_requirement!='') echo  $product->guest_requirement; else echo 'Not Yet Added'; ?></p>
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
									<p><?php if($product->cancel_policy!='') echo  "Any trip or experience can be canceled and fully refunded within 24 hours of purchase. See  <a href='".base_url()."pages/cancellation-policy'>cancellation policy</a>."; else echo 'Not Yet Added'; ?></p>
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
						<?php  if($product->video_url != ''){ /*?>
							<iframe width="100%" height="350px" src="<?php echo $product->video_url;?>">
							</iframe>  */ ?>
							<video loop=""  width="100%"  autoplay="" muted="" class="video_vtz4ro" data-reactid="18" playsinline="true"><source type="video/mp4" src="<?php echo $product->video_url;?>" data-reactid="19"></video>


							<?php }else{

								$product_images = $productImages->result_array();
								$product_image = $product_images[0];
								?>

								<?php   if(($product_image['product_image']!='') &&(file_exists('./server/php/experience/'.$product_image['product_image'])))
			                            {?>
			                               
			                            <img src="<?php echo base_url();?>server/php/experience/<?php echo $product_image['product_image'];?>">
			                            
			                            <?php }else if($product_image['product_image']!='' && strpos($product_image['product_image'], 's3.amazonaws.com') > 1){?> 
			                              
			                                 <img src="<?php echo  $product_image['product_image'];?>">
			                              
			                              <?php } else {?>
			                              
			                                 <img src="<?php echo  base_url();?>server/php/experience/dummyProductImage.jpg">
			                             
			                            <?php } ?>

								<?php

								}?>	

						<div class="imgBottom clear">
							<div class="left">
								<h4><?php  echo $currencySymbol; ?><?php
									if($productDetails->row()->currency != $this->session->userdata('currency_type'))
									{
										echo convertCurrency($productDetails->row()->currency,$this->session->userdata('currency_type'),$productDetails->row()->price);
									}
									else{
										echo $productDetails->row()->price;
									}
									?>
									<?php echo $this->session->userdata('currency_type');?> per person</h4>
								<?php if($user_reviewData->num_rows()>0){ 
								?>

								<div class="pointer" data-toggle="modal" data-target="#moreReviews">
								<span class="review_img"><span class="review_st" style="width: <?php echo $user_reviewData->num_rows()*20; ?>% "></span></span> <span class="reviewTxt"><?php if($user_reviewData->num_rows()>0){ echo $user_reviewData->num_rows(); echo ($user_reviewData->num_rows()>1)?' reviews':' review'; ?> </span> <?php } ?></div>
								<?php   }?>


							</div>
							<div class="right">
								<span data-toggle="modal" data-target="#availableDates">See dates</span>
							</div>	
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

							<div class="col-xs-6">
			                <div class="heart-list text-right">
			                    <?php if($loginCheck!=''){?>

			                    <a class="ajax cboxElement" href="site/experience/AddWishListForm/<?php echo $product->experience_id;?>" style="pointer:cursor"><?php if($this->lang->line('header_add_list') != '') { echo stripslashes($this->lang->line('header_add_list')); } else echo "Save to Wish List"; ?></a>

			                    <?php } else {?>

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
		<div class="col-sm-12 clear">
			<?php
			if( $product->city!='') { 
				$count=0;
				if($ExperienceCityBasedList->num_rows()>0)
				{

			 ?>
				<h3>Similar experiences in <?php echo $product->city;?></h3>


				<div>
				<ul class="popular-listing no-padding">
					<?php  //echo("<pre>");print_r($product->result());die; ?>
					<?php
						foreach($ExperienceCityBasedList->result_array() as $product_image )
						{ $count++;
							if(($count%5)==0)
							{ 
								$li_class_name='big-poplr';
							}else {
								$li_class_name='';
							}
							?>
							 <li class="<?php echo $li_class_name; ?>">
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

			                          <label class="pric-tag"><?php echo $this->session->userdata('currency_s');
			                                $cur_Date = date('Y-m-d');
			                                $sel_price = "select min(price) as min_price,currency from ".EXPERIENCE_DATES." where experience_id ='".$product_image['experience_id']."' and status='1' and from_date>'".$cur_Date."'";
			                                $priceData = $this->experience_model->ExecuteQuery($sel_price);


			                                // if($priceData->num_rows()>0){
											
			                                   // $experience_price = $priceData->row()->min_price;
	
			                                // }else  if ($priceData->row()->min_price==''){
			                                  
			                                    // $experience_price = 0.00;
			                                // }
											
											if($priceData->num_rows()>0){
											
											if($priceData->currency != $this->session->userdata('currency_type'))
											{
												 $experience_price= convertCurrency($priceData->row()->currency,$this->session->userdata('currency_type'),$priceData->row()->min_price);
											}
											else{
												 $experience_price= $priceData->row()->min_price;
											}
											
											}else{
											
													$experience_price = 0.00;
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
		                        $result = 0;
		                        if($product_image['id'] != '') {
			                        $this->db->select('*');
			                        $this->db->from(EXPERIENCE_REVIEW);
			                        $this->db->where('product_id',$product_image['id']);
			                        //$this->db->group_by('product_id');
			                        $result = $this->db->get()->num_rows();


		                        }

		                        $result1 = 0;
		                        if($product_image['id'] != '') {
		                        $this->db->select('*');
		                        $this->db->from(EXPERIENCE_REVIEW);
		                        $this->db->where('product_id',$product_image['id']);
		                        //$this->db->group_by('product_id');
		                        $result1 = $this->db->get()->num_rows();
		                        //$result1->row();

		                        }

		                        if($result>0){
		                        ?>
		                        <label class="star11"><span class="review_img"><span class="review_st" style="width:<?php echo $result * 20?>%"></span></span><span class="rew"><?php echo $result1; ?>  <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews"; ?></span></label><?php }
		                        else {?><span class="review_img"><span class="review_st" style="width:<?php echo $result * 20?>%"></span></span><span class="rew"><?php echo $result1; ?>  <?php if($this->lang->line('Reviews') != '') { echo stripslashes($this->lang->line('Reviews')); } else echo "Reviews"; ?></span><?php } ?>


		                        <p class="describ"><?php  echo $product_image['city'];?></p>
		                        </div>

		                        </li>

							<?php  	
						}
					 ?>
				</ul>
			
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
		        <h3 class="modal-title">Reviews</h3>
	      	</div>
			<div class="modal-body">

				<?php
				foreach ($user_reviewData->result() as $review) {
					
			?>
					<div class="reviewBlock clear">
						<div class="left">
							<?php   if(($review->image!='') &&(file_exists(base_url().'images/users'.$review->image)))
	                        {?>
	                           
	                        <img src="<?php echo base_url();?>images/users<?php echo $review->image;?>">
	                       
	                        <?php }else {?>
	                          
	                             <img src="<?php echo  base_url();?>images/site/profile.png">
	                          
	                        <?php } ?>
						</div>
						<div class="right">
							<h4><?php echo $review->firstname.' '.$review->lastname;	?></h4>
							<small><?php echo date('d F Y',strtotime($review->dateAdded));?></small>
						</div>
						<p class="reviewContent"><?php echo $review->review;?></p>
					</div>
					<hr>

				<?php 	
						
					}	
				?>	


			</div>
	    </div>

	  </div>		
	</div>

<div id="contactHost" class="modal fade customModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close" data-dismiss="modal">&times;</span>
        <h3 class="modal-title">Need more info about <?php echo ($product->user_id > 0 && $product->user_id !='')?$product->firstname :'Administrator';?>?</h3>
        
      </div>
      <div class="modal-body">
      <p>If you have general questions about how experiences work, <a >visit our FAQ</a></p>
        <form method="POST" action ="site/experience/add_conctact_msg">

        	<input type="hidden" id="rental_id" name="rental_id" value="<?php echo $product->experience_id; ?>" />
        	<input type="hidden" id="experience_title" name="experience_title" value="<?php echo $product->experience_title; ?>" />
			<input type="hidden" id="sender_id" name="sender_id" value="<?php echo $currentUser; ?>" />
			<input type="hidden" id="receiver_id" name="receiver_id" value="<?php echo $product->user_id; ?>" />
			<input type="hidden" id="posted_by" name="posted_by" value="customer" />
			<input type="hidden" id="redirect" name="redirect" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>" />	

        	<textarea class="form-control" rows="5" placeholder="Make sure to introduce yourself!"></textarea>
        	<input type="submit" name="" class="customButton" value="Send Message">
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
        <h3 class="modal-title">When do you want to go?</h3>
        
      </div>
      <div class="modal-body">
      <p>If you can’t find the dates you want, try contacting the host</p>
        <?php if($datesList->num_rows()>0){

			foreach ($datesList->result() as $date) {
				$dateId  = $date->id;
			 ?>
				<div class="row">
					
					<div class="col-sm-8">
						

						<h4>
							<?php 
							if($product->date_count>1)	
							{
								echo date('D,dS Y', strtotime($date->from_date)).'- '.date('D,dS Y',strtotime( $date->to_date));
							}else{
								echo date('D,dS Y',strtotime($date->from_date));
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
							 per person
						</span> 
						<?php  } ?>

						<!-- date experience schedule  -->	
						<?php 
						$schedule = $datesSchedule[$dateId]; 
						
						//echo "scc";print_r($schedule->result());  
						if($schedule->num_rows()>0){
							echo "<p class='toggleSchedule'>Read Schedules</p><div class='scheduleDetails'>";
							foreach ($schedule->result() as $sched) {
								
						?>
								<div>
									<?php 
									echo '<b>'.$sched->title.'</b><br>'; 
									
									echo date('D,dS Y',strtotime($sched->schedule_date));
									echo '<div class="timings">'.date('H:i',strtotime($sched->start_time)).' -'. date('H:i',strtotime($sched->end_time)).'</div>' ;
									?>
									<!--
									Rooftop Sunset DTLA
									Thu, 10th Aug · 18:30 − 20:30 -->

								</div>
						<?php }
						echo "</div>";
						} ?>
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
		if(user_id==renter_id)
		{	
			alert("Booking not allowed.");
		}
		else		
		{ 
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
	$(document).on("click",".toggleSchedule",function(){
		$(this).next(".scheduleDetails").slideToggle();
	});
</script>


 <script>
$(document).ready(function() {
    $("#news-slider3").owlCarousel({
        items : 5,
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