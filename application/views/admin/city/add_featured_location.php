<?php
$this->load->view('admin/templates/header.php');
?>
<style>
.uploader{
	overflow:visible !important;
}
.uploader label.error{
	left: 200px;
    position: absolute;
    width: 150px;
}
</style>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New City</h6>
                        <div id="widget_tab">
              				<ul>
               					 <li><a href="#tab1" class="active_tab">Content</a></li>
               					 <li><a href="#tab2">SEO</a></li>
             				 </ul>
            			</div>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm','enctype' => 'multipart/form-data');
						echo form_open('admin/city/insertEditFeatureLocation',$attributes) 
					?> 		
                    	<div id="tab1">
	 						<ul>
	 						<li>
								<div class="form_grid_12">
									<label class="field_title" for="countryid">Country Name<span class="req">*</span></label>
									<div class="form_input">
                                    <select class="chzn-select required" name="countryid" tabindex="-1" style="width: 375px; display: none;" data-placeholder="Please select the country" onchange="javascript:load_states(this);">
                                            <option value=""></option>
                                            <?php foreach ($countryDisplay->result() as $row){?>
                                            <option value="<?php echo $row->id;?>"  ><?php echo $row->name;?></option>
                                            <?php }?>
                                      </select>
                                    
									</div>
								</div>
								</li> 
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="stateid">State Name<span class="req">*</span></label>
									<div class="form_input">
                                    <select class="chzn-select required" name="stateid" tabindex="-1" style="width: 375px; display: none;" data-placeholder="Please select the state name">
                                            <option value=""></option>
                                            <?php foreach ($stateDisplay as $row){?>
                                            <option value="<?php echo $row['id'];?>"  ><?php echo $row['name'];?></option>
                                            <?php }?>
                                      </select>
                                    
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="city">City Name<span class="req">*</span></label>
									<div class="form_input">
                                    <input name="city" style=" width:295px" id="city" value="" type="text" tabindex="1" class="required tipTop" title="Please enter the city"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="name">Location Name<span class="req">*</span></label>
									<div class="form_input">
                                    <input name="name" style=" width:295px" id="name" value="" type="text" tabindex="1" class="required tipTop" title="Please enter the location" onblur="javascript:showAddress(this);"/>
									</div>
								</div>
								</li>
								<li>
									<div class="form_grid_12">
										<input type="hidden" name="latitude" id="latitude" value=""/>
										<input type="hidden" name="longitude" id="longitude" value=""/>
										<div id="map" style="width:1050px; height:250px"></div>
										<script src='http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->config->item('google_map_api');?>'></script>
										<!-- <script type="text/javascript" src="js/map_google_load.js"></script> -->
										<script>
										  function load() {
											  oldlat = '';
											  oldlng = '';
											  if(oldlat == '') oldlat='37.77264';
											  if(oldlng == '') oldlng='-122.40992';
										      if (GBrowserIsCompatible()) {
										        var map = new GMap2(document.getElementById("map"));
										        map.addControl(new GSmallMapControl());
										        map.addControl(new GMapTypeControl());
										        var center = new GLatLng(oldlat,oldlng);
										        map.setCenter(center, 15);
										        geocoder = new GClientGeocoder();
										        var marker = new GMarker(center, {draggable: true});  
										        map.addOverlay(marker);
										         $("#latitude").val(center.lat().toFixed(5));
										        $("#longitude").val(center.lng().toFixed(5)); 
										
											  GEvent.addListener(marker, "dragend", function() {
										       var point = marker.getPoint();
											      map.panTo(point);
										        $("#latitude").val(point.lat().toFixed(5));
										       $("#longitude").val(point.lng().toFixed(5)); 
										
										        });
										
										      }
											}
											load();
											function showAddress(evt) {
												var country = $(evt).parents('li').prev().prev().prev().find('select option:selected').text();
												var state = $(evt).parents('li').prev().prev().find('select option:selected').text();
												var city = $(evt).parents('li').prev().find('input').val();
												var location = $(evt).val();
												if(location == '' || city == '' || state == '' || country == '')return false;
												address = location+','+city+','+state+','+country;
												var map = new GMap2(document.getElementById("map"));
										       map.addControl(new GSmallMapControl());
										       map.addControl(new GMapTypeControl());
										       if (geocoder) {
										        geocoder.getLatLng(
										          address,
										          function(point) {
										            if (!point) {
										              alert("Address "+address + " not found");
										              return false;
										            } else {
										            	$("#latitude").val(point.lat().toFixed(5));
										            	$("#longitude").val(point.lng().toFixed(5));
										            	 map.clearOverlays()
										     			map.setCenter(point, 14);
										        var marker = new GMarker(point, {draggable: true});  
										     		 map.addOverlay(marker);

										     		GEvent.addListener(marker, "dragend", function() {
										           var pt = marker.getPoint();
										     	     map.panTo(pt);
										     	    $("#latitude").val(pt.lat().toFixed(5));
									            	$("#longitude").val(pt.lng().toFixed(5));
										             });


										     	/*  GEvent.addListener(map, "moveend", function() {
										     		  map.clearOverlays();
										         var center = map.getCenter();
										     		  var marker = new GMarker(center, {draggable: true});
										     		  map.addOverlay(marker);
										     	  $("#latitude").val(center.lat().toFixed(5));
									            	$("#longitude").val(center.lng().toFixed(5));

										     	 GEvent.addListener(marker, "dragend", function() {
										          var pt = marker.getPoint();
										     	    map.panTo(pt);
										     	  $("#latitude").val(pt.lat().toFixed(5));
									            	$("#longitude").val(pt.lng().toFixed(5));
										             });
										      
										             }); */
										            }
										          }
										        );
										      }
										    }
											</script>
									</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="citythumb">image (Image Size 315px X 165px)<span class="req">*</span></label>
									<div class="form_input">
                                   <input name="citythumb" id="citythumb" type="file" tabindex="5" class="required large tipTop" title="Please select the thumb image"/>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="featured">Featured City </label>
									<div class="form_input">
										<div class="yes_no">
											<input type="checkbox" name="featured" id="1_0_1" class="yes_no"/>
										</div>
									</div>
								</div>
								</li>
                              	<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status </label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="8" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								</li>
								<input type="hidden" name="city_id" value=""/>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Submit</span></button>
									</div>
								</div>
								</li>
							</ul>
                        </div>
                        <div id="tab2">
              <ul>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_title">Meta Title</label>
                    <div class="form_input">
                      <input name="meta_title" id="meta_title" type="text" tabindex="1" class="large tipTop" title="Please enter the page meta title"/>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_tag">Meta Keyword</label>
                    <div class="form_input">
                      <textarea name="meta_keyword" id="meta_keyword"  tabindex="2" class="large tipTop" title="Please enter the page meta keyword"></textarea>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_description">Meta Description</label>
                    <div class="form_input">
                      <textarea name="meta_description" id="meta_description" tabindex="3" class="large tipTop" title="Please enter the meta description"></textarea>
                    </div>
                  </div>
                </li>
              </ul>
             <ul><li><div class="form_grid_12">
				<div class="form_input">
					<button type="submit" class="btn_small btn_blue" tabindex="4"><span>Submit</span></button>
				</div>
			</div></li></ul>
			</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<script type="text/javascript">
 $(".action").live("click", function(event) {

            event.preventDefault();

            var file_upload_id=$(this).prev().prev().attr('id');
			
			$('#'+file_upload_id).click();	

       });
</script>
<script type="text/javascript">
function load_states(evt){
	var cid = $(evt).val();
	if(cid!=''){
		$.ajax({
			type:'post',
			url:baseURL+'admin/city/load_states',
			data:{cid:cid},
			dataType:'json',
			success:function(json){
				if(json && json.success==1){
					$(evt).parents('li').next().find('.form_input').html(json.states_list);
					$(".chzn-select").chosen(); 
				}
			},
			error:function(a,b,c){
				alert(c);
			},
			complete:function(){}
		});
	}
}
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>