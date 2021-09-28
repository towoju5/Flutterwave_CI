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
						//$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm','enctype' => 'multipart/form-data','accept-charset'=>'UTF-8','onsubmit'=>'return validate();');
						
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm','enctype' => 'multipart/form-data','accept-charset'=>'UTF-8','onsubmit'=>'return checkValue();');

						echo form_open('admin/city/insertEditcity',$attributes) 
					?> 		
                    	<div id="tab1">
	 						<ul>
	 						<li>
								<div class="form_grid_12">
									<label class="field_title" for="countryid">Country Name<span class="req">*</span></label>
									<div class="form_input">
                                    <select class="chzn-select " id="countryid" name="countryid" tabindex="-1" style="width: 375px; display: none;" data-placeholder="Please select the country" onchange="javascript:load_states(this);">
                                            <option value="">--Select--</option>
                                            <?php foreach ($countryDisplay->result() as $row){?>
                                            <option value="<?php echo $row->id;?>"  ><?php echo $row->name;?></option>
                                            <?php }?>
                                      </select>
                                    <span id="countryid_valid" style="color:#f00;display:none;">Please select the country name</span>
									</div>
								</div>
								</li> 
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="stateid">State Name<span class="req">*</span></label>
									<div class="form_input">
                                    <select class="chzn-select required" id="stateid" name="stateid" tabindex="-1" style="width: 375px; display: none;" data-placeholder="Please select the state name">
                                            <option value="">--Select--</option>
                                            <?php foreach ($stateDisplay as $row){?>
                                            <option value="<?php echo $row['id'];?>"  ><?php echo $row['name'];?></option>
                                            <?php }?>
                                      </select>
                                     <span id="stateid_valid" style="color:#f00;display:none;">Please select the State name</span>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<label class="field_title" for="name">City Name<span class="req">*</span></label>
									<div class="form_input">
                                    <input name="name" style=" width:295px" id="name" value="" type="text" tabindex="1" class=" tipTop" title="Please enter the city" onblur="javascript:showAddress(this);"/><span id="name_valid" style="color:#f00;display:none;">Only Characters allowed</span>
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
												var country = $(evt).parents('li').prev().prev().find('select option:selected').text();
												var state = $(evt).parents('li').prev().find('select option:selected').text();
												var city = $(evt).val();
												address = city+','+state+','+country;
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
									<label class="field_title" for="citythumb">image <small>(Maximum width 2000px)</small><span class="req">*</span></label>
									<div class="form_input">
                                   <input name="citythumb" onchange="Upload(this.id);" id="citythumb"  type="file" tabindex="5" class=" large tipTop" title="Please select the thumb image"/>
									</div>
									
									<label id="image_valid_error" style="font-size:12px;display:none;" class="error"> Maximum width 2000Px.</label>
							<label id="image_type_error" style="font-size:12px;display:none; margin-left:345px" class="error"> Please select a valid Image file</label>
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
										
										<!--<button type="button"  onclick="checkValue()" class="btn_small btn_blue" tabindex="4"> Submit</button>-->
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
			data:{cid:cid,action:2},
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
function Upload(files) {
    var fileUpload = document.getElementById("citythumb");
 
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.jpeg|.gif)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
 
        if (typeof (fileUpload.files) != "undefined") {
            
            var reader = new FileReader();

            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
               
                var image = new Image();
                image.src = e.target.result;
                       
                image.onload = function () {
					
                    var height = this.height;
                    var width = this.width;

                    if (parseInt(width) > 2000) {
						document.getElementById("image_valid_error").style.display = "inline";
						$("#image_valid_error").fadeOut(9000);
						$("#citythumb").val('');
						$(".filename").text('No file selected');
						
						//document.getElementById(files).value = "";
						//document.getElementById("image").value = "";
						$("#citythumb").focus();
                        return false;
                    } 
                    return true;
                };
            }
        } else {
            alert("This browser does not support HTML5.");
			$("#citythumb").val('');
            return false;
        }
    } else {
       // alert("Please select a valid Image file.");
		document.getElementById("image_type_error").style.display = "inline";
		$("#image_type_error").fadeOut(9000);
		$("#citythumb").val('');
		$("#citythumb").focus();
        return false;
    }
}
</script>

<script type="text/javascript">
	$('#commentForm').validate();
	
</script>

<?php 
$this->load->view('admin/templates/footer.php');
?>

<script>
/* $("#name").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z&-\s()&]/g)) {
	   document.getElementById("name_valid").style.display = "inline";
	   $("#name_valid").fadeOut(5000);
	   $("#name").focus();
       $(this).val(val.replace(/[^a-zA-Z&-\s()&]/g, ''));
   }
}); */
</script>
<script>
/* function validate(){
	
		if($('#stateid option:selected').val()=='' ){
	   document.getElementById("stateid_valid").style.display = "inline";
	   $("#stateid").focus();
	   $("#stateid_valid").fadeOut(5000); 
	   //alert("Please Select Country Name");
		return false;
		}

	if($('#countryid option:selected').val()=='' ){
	  document.getElementById("countryid_valid").style.display = "inline";
	   $("#countryid").focus();
	   $("#countryid_valid").fadeOut(5000); 
	   //alert("Please Select Country Name");
		return false;
		}
	
} */
</script>

<script>
function checkValue(){
	var country=$("#countryid").val();
	var state=$('select[name="stateid"]').val();
	var city=$("#name").val();
	var img=$('input[type="file"]').val();
	if (country=="" || state=="undefined" || state=="" || state==null || city=='' || img=='') {
		alert("Please Fill All Mandatory Fields");
		return false;
	}else{
		//alert("else");
	}	
}
</script>