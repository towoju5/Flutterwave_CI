<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading;?></h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin',$attributes) 
					?>
	 						<ul>
                            	
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="City">City Name</label>
									<div class="form_input">
                                    <?php 
									if (!empty($city_details->row()->name)){
										echo $city_details->row()->name;
									}else{
										echo "----";
									}
									
									
									?>
									</div>
								</div>
								</li>
                               <!-- <li>
								<div class="form_grid_12">
									<label class="field_title" for="neighborhoods">Primary Neighborhood Name<span class="req">*</span></label>
									<div class="form_input">
                                        	<?php //foreach ($PrimaryNhDisplay as $row){?>
                                            <?php //if($city_details->row()->neighborhoods==$row['id']){echo $row['name'];} ?>
                                        	<?php //}?>
                                    </div>
								</div>
								</li>-->
								
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="stateid">State Name</label>
									<div class="form_input">
                                    
                                            <?php 
											if(!empty($city_details->row()->stateid)){
											foreach ($stateDisplay as $row){ 
													if($city_details->row()->stateid==$row['id']){
														echo $row['name'];
													}
												}
											}else{
												echo "----";
											}
												
												?>
                                    
                                    
									</div>
								</div>
								</li>
								
								
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="country">Country Name</label>
									<div class="form_input">
                                    
                                            <?php
											if (!empty($city_details->row()->countryid)){
											foreach ($conutryDisplay->result() as $row){ 
													if($city_details->row()->countryid==$row->id){
														echo $row->name;
													}
												}
											}else{
												echo "----";
											}
												
												?>
                                    
                                    
									</div>
								</div>
								</li>
								
								
                                
                                <li>
								<div class="form_grid_12">
									<label class="field_title">Image </label>
									<div class="form_input">					
								 <?php 
								$base =base_url();
								$url=getimagesize($base.'images/city/'.$city_details->row()->citythumb);
								if(!is_array($url))
								{
								  $img="1"; //no
								}
								else {
								  $img="0";  //yes
								}
								//To Check whether the image is exist in Local Directory..
								?>  
						
								<?php if ($city_details->row()->citythumb  != '' && $img=='0') { ?>
								 	<img src="images/city/<?php echo $city_details->row()->citythumb;?>" width="50px" height="50px" />
								<?php }else { 
									echo "No Image";
								} ?>	

									
									</div>
								</div>
								</li>
                                <li>
                                  <div class="form_grid_12">
                                    <label class="field_title" for="description">Featured City</label>
                                    <div class="form_input">
                                      <?php if($city_details->row()->featured=='1'){echo '  <img src="images/checked.png" class="tip_top" title="Featured Neighborhood" />';} else {
										  echo "No";
									  }?>
                                    </div>
                                  </div>
                                </li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="status">Status</label>
									<div class="form_input">
                                    <?php echo $city_details->row()->status;?>
									</div>
								</div>
								</li>
                                
	 							<li>
                                  <div class="form_grid_12">
                                    <label class="field_title" for="meta_title">Meta Title</label>
                                    <div class="form_input">
                                      <?php 
									  if (!empty($city_details->row()->meta_title)){
											echo $city_details->row()->meta_title; 
									  }else{
										  echo "----";
									  }?>
                                    </div>
                                  </div>
                                </li>
                                <li>
                                  <div class="form_grid_12">
                                    <label class="field_title" for="meta_tag">Meta Keyword</label>
                                    <div class="form_input">
                                      <?php 
									  if (!empty($city_details->row()->meta_keyword)){
										  echo $city_details->row()->meta_keyword;
									  }else{
										  echo "----";
									  } ?>
                                    </div>
                                  </div>
                                </li>
                                <li>
                                  <div class="form_grid_12">
                                    <label class="field_title" for="meta_description">Meta Description</label>
                                    <div class="form_input">
                                      <?php
									  if (!empty($city_details->row()->meta_description)){
										   echo $city_details->row()->meta_description;
									  }else{
										  echo "----";
									  }
									  
									  ?>
                                    </div>
                                  </div>
                                </li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="#" onclick="history.go(-1);return false;" class="tipLeft" title="Go to city list"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>