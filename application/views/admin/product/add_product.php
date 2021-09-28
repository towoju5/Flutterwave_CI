<?php
   $imageUpload = $this->uri->segment(5,0);
   $this->load->view('admin/templates/header.php');
    
   foreach ($listDetail->result() as $product_listing){
   
    $product_list_values = $product_listing->listings;
    }
    foreach ($listValues->result() as $result){
   
    $values = $result->listing_values;
    }
   foreach ($listchildValues->result() as $result){
   	
    $values1 = $result->id;
    }
   // echo "<pre>";print_r($listchildValues->result()); die;
   ?>
<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
<?php 
   if(!empty($product_details)){ 
   $address = trim(stripslashes($product_details->row()->address));
   $lat = $product_details->row()->latitude;
   $long = $product_details->row()->longitude;
   
   } else { 
   $address = "";
   $lat = '';
   $long = '';
   }
   $street = '';
   $street1 = '';
   $area = '';
   $location = '';
   $city = '';
   $state = '';
   $country = '';
   
   $zip = '';
   $address = str_replace(" ", "+", $address);
   $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$google_map_api");
   $json = json_decode($json);
   //echo '<pre>';print_r($json);die;
   $newAddress = $json->{'results'}[0]->{'address_components'};
   foreach($newAddress as $nA)
   {
   	if($nA->{'types'}[0] == 'route')$street = $nA->{'long_name'};
   	if($nA->{'types'}[0] == 'sublocality_level_2')$street1 = $nA->{'long_name'};
   	if($nA->{'types'}[0] == 'sublocality_level_1')$area = $nA->{'long_name'};
   	if($nA->{'types'}[0] == 'locality')$location = $nA->{'long_name'};
   	if($nA->{'types'}[0] == 'administrative_area_level_2')$city = $nA->{'long_name'};
   	if($nA->{'types'}[0] == 'administrative_area_level_1')$state = $nA->{'long_name'};
   	if($nA->{'types'}[0] == 'country')$country = $nA->{'long_name'};
   	if($nA->{'types'}[0] == 'postal_code')$zip = $nA->{'long_name'};
   }
   if($city == '')
   $city = $location;
   
   $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
   $lang = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
   
   ?>
<?php
   $bedrooms="";
   $beds="";
   $bedtype="";
   $bathrooms="";
   $noofbathrooms="";
   $min_stay="";
   $accommodates="";
   $can_policy="";
   if($listValues->num_rows()==1){
   $roombedVal=json_decode($listValues->row()->rooms_bed);
   $bedrooms=$roombedVal->bedrooms;
   $beds=$roombedVal->beds;
   $bedtype=$roombedVal->bedtype;
   $bathrooms=$roombedVal->bathrooms;
   $noofbathrooms=$roombedVal->noofbathrooms;
   $min_stay=$roombedVal->min_stay;
   $accommodates=$roombedVal->accommodates;
   $can_policy=$roombedVal->can_policy;
   } 
   
   								  
   ?>
<!-- <script type="text/javascript" src="js/map_google_load.js"></script>  
   <script src='http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php //echo $this->config->item('google_map_api');?>'></script> -->   
<?php if( $lat != '' && $lang != '') { ?> 
<script>
   var myLatlng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $long;?>);
   // var myLatlng;
   
   var citymap = {};
   
   function initializeMapCircle() {
   
   // Create the map.
   var cityCircle;
   
   var mapOptions = {
   zoom: 12,
   center: myLatlng,
   mapTypeId: google.maps.MapTypeId.TERRAIN
   };
   
   // var mapOptions = {
   // 	center: new google.maps.LatLng(38, -78),
   //        zoom: 10,
   //        mapTypeId: google.maps.MapTypeId.ROADMAP
   // };
   
   var map = new google.maps.Map(document.getElementById('map-new'),
   mapOptions);
   
   var marker = new google.maps.Marker({
   							position: myLatlng,
   							draggable:true,
   							map: map
   						});
   
   google.maps.event.addListener(marker, 'dragend', function() 
   						{
   							var newLatitude = this.position.lat();
   							var newLongitude = this.position.lng();
   							
   							var pos=marker.getPosition();
   							
   							geocoder = new google.maps.Geocoder();
   								geocoder = new google.maps.Geocoder();
   							geocoder.geocode
   							({
   								latLng: pos
   							},
   							function(results, status) 
   								{
   									if (status == google.maps.GeocoderStatus.OK) 
   										{	
   											var address=results[0].formatted_address;
   											$("#address_location").val(address);
   										$.ajax({
   										type:'post',
   										url	: baseURL+'site/product/get_location',
   										dataType: 'json',
   										data:{address: address},
   										success: function(json){
   
   											var street = json.street;
   											var area = json.area;
   											
   											
   											$("#apt").val(street+' '+area);
   											var location = json.location;
   											$("#autocomplete-admin").val(location);
   											var city = json.city;
   											$("#city").val(city);
   											var state = json.state;
   											$("#state").val(state);
   											var country = json.country;
   											$("#country").val(country);
   											$.ajax({
   												type:'POST',
   												url:'<?php echo base_url()?>site/product/save_lat_lng',
   												data:{latitude:newLatitude,longitude:newLongitude,area:area,street:street,location:location,address:address,city:city,state:state,country:country},
   												success:function(response)
   												{
   												},
   												error: function (request, status, error) {
   												}
   											});
   										},
   										complete:function(){
   											
   										}
   									});
   
   
   											
   										} 
   									else 
   										{
   											console.log('Cannot determine address at this location.');
   										}
   								}
   							);
   						});
   
   // Construct the circle for each value in citymap.
   // Note: We scale the area of the circle based on the population.
   for (var city in citymap) {
   var populationOptions = {
   strokeColor: '#FF0000',
   strokeOpacity: 0.8,
   strokeWeight: 2,
   fillColor: '#FF0000',
   fillOpacity: 0.35,
   map: map,
   center: citymap[city].center,
   radius: Math.sqrt(citymap[city].population) * 100
   };
   // Add the circle for this city to the map.
   cityCircle = new google.maps.Circle(populationOptions);
   }
   }
   
</script>
<?php } else{  ?>
<script>
   var myLatlng = new google.maps.LatLng(32,72);
   // var myLatlng;
   
   var citymap = {};
   
   function initializeMapCircle() {
   
   // Create the map.
   var cityCircle;
   
   var mapOptions = {
   zoom: 12,
   center: myLatlng,
   mapTypeId: google.maps.MapTypeId.TERRAIN
   };
   
   // var mapOptions = {
   // 	center: new google.maps.LatLng(38, -78),
   //        zoom: 10,
   //        mapTypeId: google.maps.MapTypeId.ROADMAP
   // };
   
   var map = new google.maps.Map(document.getElementById('map-new'),
   mapOptions);
   
   var marker = new google.maps.Marker({
   							position: myLatlng,
   							draggable:true,
   							map: map
   						});
   
   google.maps.event.addListener(marker, 'dragend', function() 
   						{
   							var newLatitude = this.position.lat();
   							var newLongitude = this.position.lng();
   							
   							var pos=marker.getPosition();
   							
   							geocoder = new google.maps.Geocoder();
   								geocoder = new google.maps.Geocoder();
   							geocoder.geocode
   							({
   								latLng: pos
   							},
   							function(results, status) 
   								{
   									if (status == google.maps.GeocoderStatus.OK) 
   										{	
   											var address=results[0].formatted_address;
   											$("#address_location").val(address);
   										$.ajax({
   										type:'post',
   										url	: baseURL+'site/product/get_location',
   										dataType: 'json',
   										data:{address: address},
   										success: function(json){
   											
   											var street = json.street;
   											var area = json.area;
   											$("#apt").val(street+' '+area);
   											var location = json.location;
   											$("#autocomplete-admin").val(location);
   											var city = json.city;
   											$("#city").val(city);
   											var state = json.state;
   											$("#state").val(state);
   											var country = json.country;
   											$("#country").val(country);
   											$.ajax({
   												type:'POST',
   												url:'<?php echo base_url()?>site/product/save_lat_lng',
   												data:{latitude:newLatitude,longitude:newLongitude,area:area,street:street,location:location,address:address,city:city,state:state,country:country},
   												success:function(response)
   												{
   												},
   												error: function (request, status, error) {
   												}
   											});
   										},
   										complete:function(){
   											
   										}
   									});
   
   
   											
   										} 
   									else 
   										{
   											console.log('Cannot determine address at this location.');
   										}
   								}
   							);
   						});
   
   // Construct the circle for each value in citymap.
   // Note: We scale the area of the circle based on the population.
   for (var city in citymap) {
   var populationOptions = {
   strokeColor: '#FF0000',
   strokeOpacity: 0.8,
   strokeWeight: 2,
   fillColor: '#FF0000',
   fillOpacity: 0.35,
   map: map,
   center: citymap[city].center,
   radius: Math.sqrt(citymap[city].population) * 100
   };
   // Add the circle for this city to the map.
   cityCircle = new google.maps.Circle(populationOptions);
   }
   }
   
</script>
<?php } ?>
<!-- <script type="text/javascript" src="js/map_google_load.js"></script> -->  
<script type="text/javascript">
   function list_amenities(evt)
   {
   if($(evt).is(":checked")){
   	var am = $(evt).val();
   	//alert(am);
   	//$(".dashboard_price_right ul li").append('<li><a>Message Center</a></li>');
   	$.ajax({
           type: 'POST',
           url: baseURL+'admin/product/get_sublist_values',
           data: {"list_value_id":am},
           dataType:'json',
           success: function(response)
   		{
          	 	//alert("cccccc");
          		$(evt).parents('li').append(response.amenities);
   		}
           });
   }
   else 
   {
   //	alert("UNchecked");
   	$(evt).parents('li').find('ul').remove();
   }
   }
   
   
   function ImageAddClick(){
   var idval =$('#prdiii').val();
   //alert(idval);
   $(".dragndrop1").colorbox({width:"1000px", height:"500px", href:baseURL+"admin/product/dragimageuploadinsert/?id="+idval});
   }
</script>
<script type="text/javascript">
   function delimage(val){
   $('#row'+val).remove();
   }
   
    $(function() {
   	
   
   /* product Add images dynamically */
   var i = 1;
   
   
   $('#add').click(function() {
   
   	$('<div id="row'+i+'" class="control-group field"><input type="text" class="small tipTop" name="imgtitle[]"  maxlength="25"  placeholder="Caption" /> <input class="small tipTop"  placeholder="Priority" name="imgPriority[]" type="text"><div class="uploader" id="uniform-productImage" style=""><input type="file" class="large tipTop" name="product_image[]" id="product_image" onchange="Test.UpdatePreview(this,'+i+')" style="opacity: 0;"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div><img style="display: inline-block; margin: 0 10px; position: relative;top: 13px;" class="img'+i+'" width="150" height="150" alt="" src="images/noimage.jpg"><a href="javascript:void(0);" onclick="return delimage('+i+');"><div class="rmv_btn">Remove</div></a></div></div><br />').fadeIn('slow').appendTo('.imageAdd');
   	i++;
   });
   
   	Test = {
         UpdatePreview: function(obj,ival){
           // if IE < 10 doesn't support FileReader
           if(!window.FileReader){
              // don't know how to proceed to assign src to image tag
           } else {
              var reader = new FileReader();
              var target = null;
              
              reader.onload = function(e) {
               target =  e.target || e.srcElement;
   	 
                $(".img"+ival).prop("src", target.result);
              };
               reader.readAsDataURL(obj.files[0]);
           }
         }
     };					 
   
   $('#remove').click(function() {
   							
   if(i > 0) {
   	$('.field:last').remove();
   	i--; 
   }
   });
   
   $('#reset').click(function() {
   
   	$('.field').remove();
   	$('.field').remove();
   	$('#add').show();
   	i=0;
   
   
   });
   
   $('#add').click(function() {
   if(i > 15) {
   	$('#add').hide();
   
   }
   });
   });
   /* end */
   
   
   
</script>
<script type="text/javascript">
   function updateDatabase(newLat, newLng)
   {//alert(newLat+'-----'+newLng);
   
   $('#latitude').val(newLat);
   $('#longitude').val(newLng);
   	// make an ajax request to a PHP file
   	// on our site that will update the database
   	// pass in our lat/lng as parameters
   	
   }
</script>
<?php  //echo $map['js']; ?>
</head>
<style>
   .form_container ul li {
   position: static;
   }
   #map_canvas{
   width:50% !important;}
</style>
<script>
   $(document).ready(function(){
   	$('.nxtTab').click(function(){
   		
   		var cur = $(this).parent().parent().parent().parent().parent();
   		cur.hide();
   		cur.next().show();
   		var tab = cur.parent().parent().prev();
   		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
   	});
   	$('.prvTab').click(function(){
   		var cur = $(this).parent().parent().parent().parent().parent();
   		cur.hide();
   		cur.prev().show();
   		var tab = cur.parent().parent().prev();
   		tab.find('a.active_tab').removeClass('active_tab').parent().prev().find('a').addClass('active_tab');
   	});
   	$('#tab2 input[type="checkbox"]').click(function(){
   		var cat = $(this).parent().attr('class');
   		var curCat = cat;
   		var catPos = '';
   		var added = '';
   		var curPos = curCat.substring(3);
   		var newspan = $(this).parent().prev();
   		if($(this).is(':checked')){
   			while(cat != 'cat1'){
   				cat = newspan.attr('class');
   				catPos = cat.substring(3);
   				if(cat != curCat && catPos<curPos){
   					if (jQuery.inArray(catPos, added.replace(/,\s+/g, ',').split(',')) >= 0) {
   					    //Found it!
   					}else{
   						newspan.find('input[type="checkbox"]').attr('checked','checked');
   						added += catPos+',';
   					}
   				}
   				newspan = newspan.prev(); 
   			}
   		}else{
   			var newspan = $(this).parent().next();
   			if(newspan.get(0)){
   				var cat = newspan.attr('class');
   				var catPos = cat.substring(3);
   			}
   			while(newspan.get(0) && cat != curCat && catPos>curPos){
   				newspan.find('input[type="checkbox"]').attr('checked',this.checked);	
   				newspan = newspan.next(); 	
   				cat = newspan.attr('class');
   				catPos = cat.substring(3);
   			}
   		}
   	});
   	<?php if($imageUpload != '0' && $imageUpload == 'image'){?>
   	$('#nextImage').click();	
   	<?php } ?>
   });
</script>
<script language="javascript">
   function viewAttributes(Val){
   
   	if(Val == 'show'){
   		document.getElementById('AttributeView').style.display = 'block';
   	}else{
   		document.getElementById('AttributeView').style.display = 'none';
   	}
   
   }
</script>
<script>
   $(document).ready(function(){
   
   	//loadMap();
   	var i = 1;
   	
   	
   	$('#add').click(function() { 
   //<!--		$('<div style="float: left; margin: 12px 10px 10px; width:85%;" class="field"><div class="image_text" style="float: left;margin: 5px;margin-right:50px;"><span>Attribute:</span><select name="attribute_name[]" style="width:200px;color:gray;width:206px;" class="chzn-select"><?php //foreach ($atrributeValue->result() as $attrRow){ ?><option value="<?php //echo $attrRow->attribute_name;; ?>"><?php //echo $attrRow->attribute_name; ?></option> <?php //} ?></select></div><div class="attribute_box attrInput" style="float: left;margin: 5px;width: 20%;" ><span>Value :</span><input type="text" style="width:100px;"  name="attribute_val[]" ></div><div class="image_price attrInput" style="float: left;margin: 5px;width: 20%;"><span>Weight :</span><input type="text" style="width:100px;" name="attribute_weight[]" ></div><div class="image_price attrInput" style="float: left;margin: 5px;width: 20%;"><span>Price :</span><input type="text" style="width:100px;" name="attribute_price[]" ></div></div>').fadeIn('slow').appendTo('.inputs');-->
   		$('<div style="float: left; margin: 12px 10px 10px; width:85%;" class="field">'+
   				'<div class="image_text" style="float: left;margin: 5px;margin-right:50px;">'+
   					'<span>List Name:</span>&nbsp;'+
   					'<select name="attribute_name[]" onchange="javascript:loadListValues(this)" style="width:200px;color:gray;width:206px;" class="chzn-select">'+
   						'<option value="">--Select--</option>'+
   						<?php foreach ($atrributeValue->result() as $attrRow){ 
      if (strtolower($attrRow->attribute_name) != 'price'){
      ?>
   						'<option value="<?php echo $attrRow->id; ?>"><?php echo $attrRow->attribute_name; ?></option>'+
   						<?php }} ?>
   					 '</select>'+
   				'</div>'+
   				'<div class="attribute_box attrInput" style="float: left;margin: 5px;" >'+
   					 '<span>List Value :</span>&nbsp;'+
   					 '<select name="attribute_val[]" style="width:200px;color:gray;width:206px;" class="chzn-select">'+
   					 '<option value="">--Select--</option>'+
   					 '</select>'+
   				'</div>'+
   		'</div>').fadeIn('slow').appendTo('.inputs');
   		i++;
   	});
   	
   	$('#remove').click(function() {
   		$('.field:last').remove();
   	});
   	
   	$('#reset').click(function() {
   		$('.field').remove();
   		$('#add').show();
   		i=0;
   	
   	
   	});
   	
   	
   	var j = 1;
   	$('#addAttr').click(function() { 
   		$('<div style="float: left; margin: 12px 10px 10px; width:85%;" class="field">'+
   				'<div class="image_text" style="float: left;margin: 5px;margin-right:50px;">'+
   					'<span>Attribute Name:</span>&nbsp;'+
   					'<select name="product_attribute_name[]" style="width:200px;color:gray;width:206px;" class="chzn-select">'+
   						'<option value="">--Select--</option>'+
   						<?php foreach ($PrdattrVal->result() as $prdattrRow){ ?>
   						'<option value="<?php echo $prdattrRow->id; ?>"><?php echo $prdattrRow->attr_name; ?></option>'+
   						<?php } ?>
   					 '</select>'+
   				'</div>'+
   				'<div class="attribute_box attrInput" style="float: left;margin: 5px;" >'+
   					 '<span>Attribute Price :</span>&nbsp;'+
   					 '<input type="text" name="product_attribute_val[]" style="width:75px;color:gray;" class="chzn-select" />'+
   				'</div>'+
   		'</div>').fadeIn('slow').appendTo('.inputss');
   		j++;
   	});
   	
   	$('#removeAttr').click(function() {
   		$('.field:last').remove();
   	});
   	
   	
   	
   
   });
</script>
<script>
   function runScript(event) {
       if (event.keyCode == 13) {
           var tb = document.getElementById("product_title");
           eval(tb.value);
           return false;
       }
   	
   	if(!((event.keyCode >= 65) && (event.keyCode <= 90) || (event.keyCode >= 97) && (event.keyCode <= 122) || (event.keyCode >= 48) && (event.keyCode <= 57))){
   		   event.returnValue = false;	
   		   return;
   		}
   		event.returnValue = true;
   	
   }
   
   
   	 
   
   
   
</script>
<script src="js/site/addProperty.js"></script>
<div id="content">
   <div class="grid_container">
      <div class="grid_12">
         <div class="widget_wrap">
            <div class="widget_top">
               <span class="h_icon list"></span>
               <?php echo $this->config->item('google_map_api');?>
               <?php if(!empty($product_details)) {?>
               <h6>Edit Property</h6>
               <?php } else{ ?>
               <h6>Add New Property</h6>
               <?php } ?>
               <!--<a class="inline cboxElement" href="#inline_content">Inline HTML</a>-->
               <div id="widget_tab">
                  <ul>
                     <li><a href="#tab1" class="active_tab">Property General Information</a></li>
                     <li><a href="#tab2">Images</a></li>
                     <li><a href="#tab3">Amenities</a></li>
                     <li><a href="#tab4">Address & Availability Information</a></li>
                     <li><a href="#tab5">Listing</a></li>
                     <li><a href="#tab6">Detailed description</a></li>
                     <li><a href="#tab7">SEO</a></li>
                  </ul>
               </div>
            </div>
            <div class="widget_content">
               <form class = 'form_container left_label listingInfo' id = 'addproduct_form1111' enctype = 'multipart/form-data'  onkeypress="return event.keyCode != 13;" action="admin/product/UpdateProduct"  method="POST" accept-charset="UTF-8">
  

                  <?php /* <input type='hidden' name="currency" id='currency' value='<?php if(!empty($product_details)) echo $product_details->row()->currency; else echo $admin_currency_code; ?>'> */ ?>
                  <input type="hidden" name="latitude" id="latitude" value="<?php if($productOldAddress->row()->latitude != '')echo $productOldAddress->row()->latitude; else echo $lat;?>" />
                  <input type="hidden" name="longitude" id="longitude" value="<?php if($productOldAddress->row()->longitude != '')echo $productOldAddress->row()->longitude; echo $lang;?>" />
                  <!-- <input type="text" name="prdiii" id="prdiii" value="<?php //echo $id=$this->uri->segment(4,0); ?>" /> -->
                  <input type="hidden" name="prdiii" id="prdiii" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->id)); } else { echo "0";}?>" />
				  
				  <?php  if(!empty($product_details)){ 
				  $status=$product_details->row()->status;
				  if($status=='UnPublish'){ ?>
				  
					    <h4 style="color:red"> By default The Property Is UnPublished. Until You Make it as Publish...! <br>Please Make It Publish once You Completed All The Forms...!</h4> <br>
					  
				 <?php }
				  }?>
				 
				
				  
                  <div id="tab1">
                     <ul class="tab-areas1">
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="user_id">Property Owner Name <span class="req">*</span></label>
                              <div class="form_input wdth_slct">
                                 <?php 
                                    if(!empty($userdetails)){ echo '<select name="user_id" id="current_user_id">';
                                    ?>
                                 <option value="" >--Select--</option>
                                 <?php
                                    foreach($userdetails->result() as $user_details){
                                    
                                    
                                    ?>
                                 <option value="<?php echo $user_details->id;?>" <?php if(!empty($product_details)){ if($user_details->id==$product_details->row()->OwnerId){echo 'selected="selected"';} } ?>><?php echo ucfirst($user_details->firstname).' '.ucfirst($user_details->lastname).'----'.$user_details->email;?></option>
                                 <?php  
                                    } echo '</select>';
                                    } ?>
                              </div>
                           </div>
						   
						   
                        </li>
						
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="product_title">Title<span class="req">*</span></label>
                              <div class="form_input">
                                 <?php if(!empty($product_details)){  $Valid = trim(stripslashes($product_details->row()->id)); } else {  $Valid=0;}?>
                                 <input name="product_title" id="product_title" type="text" tabindex="1" class="required large tipTop" title="Please enter the Property name" onchange="javascript:AdminDetailview(this,document.getElementById('prdiii').value,'title');" onkeydown = "return (event.keyCode!=13);"
                                    value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->product_title)); }?>"/><label id="product_title_error" style="display:none;" class="error">  Only Characters are not allowed</label>
                                 <span id="title_error" style="color:red;font-size:12px;" class="error"></span>
                              </div>
                           </div>
                        </li>
						
						
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="description">Summary <span class="req">*</span></label>
                              <div class="form_input">
                                 <!--  <textarea class="tipTop mceEditor"-->
                                 <textarea name="description" id="description" tabindex="2" class="large tipTop dscptn_wdth" title="Please enter the property description"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->description)); }?></textarea>
                                 <span id="summary_error" style="color:red;font-size:12px;" class="error"></span>
                                 <label id="description_length_error" style="display:none;" class="error">  Only 150 words are allowed</label>
                                 </br></br> <small>Maximum 150 words</small>
                                 <br><span class="words-left"> </span>
                              </div>
                           </div>
                        </li>
						
						
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="currency">Currency <span class="req">*</span></label>
                              <div class="form_input wdth_slct">
                                 <?php 
                                    if(!empty($currencyList)){ echo '<select name="currency" id="currency">';
                                    ?>
                                 <option value="" >--Select--</option>
                                 <?php
                                    foreach($currencyList->result() as $currencies){
                                    ?>
                                 <option value="<?php echo $currencies->currency_type;?>" <?php if(!empty($product_details)){ if($currencies->currency_type==$product_details->row()->currency){echo 'selected="selected"';} } ?>><?php echo $currencies->currency_type;?></option>
                                 <?php  
                                    } echo '</select>';
                                    } ?>
                              </div>
                           </div>
                        </li>
						
						
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="price">Price per night<span class="req">*</span></label>
                              <div class="form_input">
                                 <label class="" for="price"><span class="req"></span></label>
                                 <input type="text" onkeypress="return validateFloatKeyPress(this,event);" name="price" id="price" tabindex="3" class="required large tipTop" title="Please enter the property price" value="<?php if(!empty($product_details)){
                                    echo trim(stripslashes($product_details->row()->price)); 
                                    } ?>"  onchange="//javascript:PriceInsert(this.value,document.getElementById('prdiii').value,'price');"/><label id="price_error_valid" style="font-size:12px;display:none;" class="error">Only Numbers are not allowed</label>
                                 <input type="hidden"  id="hidden_price" tabindex="" class="required large tipTop" title="Please enter the property price" value="<?php if(!empty($product_details)){
                                    echo trim(stripslashes($product_details->row()->price));
                                    } ?>"  onchange="//javascript:PriceInsert(this.value,document.getElementById('prdiii').value,'price');"/>
                                 <span id="price_error" style="color:red;font-size:12px;" class="error"></span>
                                 </br></br><small>Set The Default Nightly Price Guests Will See For Your Listing</small>
                              </div>
                           </div>
                        </li>
                        <li style="display:none;">
                           <div class="form_grid_12">
                              <label class="field_title" for="price_perweek">Long-Term Prices </label>
                              <div class="form_input">
                                 <input name="price_perweek" id="price_perweek" type="hidden" tabindex="10" class="large tipTop" title="Please enter the property Price Per Week" placeholder="Per Week" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->price_perweek)); }?>" onchange="javascript:PriceInsert(this.value,document.getElementById('prdiii').value,'price_perweek');"/>
                                 <input name="price_permonth" id="price_permonth" type="hidden" tabindex="11" class="large tipTop" title="Please enter the property Price Per Month" placeholder="Per Month" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->price_permonth)); }?>" onchange="javascript:PriceInsert(this.value,document.getElementById('prdiii').value,'price_permonth');"/>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="user_id">Deposit Amount</label>
                              <div class="form_input">
                                 <label class="" for="price"><span class="req"></span></label>
                                 <input type="text" class="required large tipTop" name="security_deposit" tabindex="4" title="Please enter the deposit amount" id="security_deposit" style="  width: 379px;" value="<?php if(!empty($product_details)){ 
                                    if($product_details->row()->security_deposit!= ''){
                                    	
                                    
                                    echo trim(stripslashes($product_details->row()->security_deposit));  
                                    	//echo $product_details->row()->security_deposit;
                                    } 
                                    } ?>"><label id="security_deposit_error" style="font-size:12px;display:none;" class="error">Only Numbers are allowed</label>
                                 <span id="security_deposit_error" style="color:red;font-size:12px;" class="error"></span>
                              </div>
                           </div>
                        </li>
                         <li>
                         <div class="form_grid_12">
                              <label class="field_title" for="user_id">Cleaning fees</label>
                              <div class="form_input">
                                 <label class="" for="price"><span class="req"></span></label>
                                 <input type="text" class="required large tipTop" name="Cleaning fees" tabindex="4" title="Please enter the Cleaning fees amount" id="Cleaning_fees" style="  width: 379px;" value="<?php if(!empty($product_details)){ 
                                    if($product_details->row()->Cleaning_fees!= ''){
                                       
                                    
                                    echo trim(stripslashes($product_details->row()->Cleaning_fees));  
                                       //echo $product_details->row()->security_deposit;
                                    } 
                                    } ?>"><label id="cleaning_fees_error" style="font-size:12px;display:none;" class="error">Only Numbers are allowed</label>
                                 <span id="cleaning_fees_error" style="color:red;font-size:12px;" class="error"></span>
                              </div>
                           </div>

                        </li>
						
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="user_id">Cancellation Policy <span class="req">*</span></label>
                              <div class="form_input wdth_slct">
                                 <select class="gends" id="cancellation_policy" name="cancellation_policy" onchange="show_val(this);">
                                    <option value="" >--Select--</option>
                                    <option value="Flexible" <?php if(!empty($product_details)){ if($product_details->row()->cancellation_policy=='Flexible'){echo 'selected="selected"';}}?>>Flexible</option>
                                    <option value="Moderate" <?php if(!empty($product_details)){ if($product_details->row()->cancellation_policy=='Moderate'){echo 'selected="selected"';}}?>>Moderate</option>
                                    <option value="Strict" <?php if(!empty($product_details)){ if($product_details->row()->cancellation_policy=='Strict'){echo 'selected="selected"';}}?>>Strict</option>
									 <option value="No Refund" <?php if(!empty($product_details)){ if($product_details->row()->cancellation_policy=='No Refund'){echo 'selected="selected"';}}?>>No Refund</option>
                                 </select>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div id="return_amount_percentage" <?php if(!empty($product_details)){if($product_details->row()->cancellation_policy == 'Strict'){?>style="display:none" <?php }} ?>>
                              <div class="form_grid_12" >
                                 <label class="field_title" for="user_id">Return Amount<span class="req">*</span></label>

                                 <input  style="width:35% !important;" type="text" maxlength="2" value="<?php echo $listDetail->row()->cancel_percentage; ?>" class="number_field2 required large tipTop" onkeypress="return check_for_num(event)" id="return_amount" name="cancel_percentage" placeholder="Enter your return amount" title="Enter your return amount"  onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'cancel_percentage');" /> %
                                 <span id="return_amount_error" style="color:red;font-size:12px;" class="error"></span>
                              </div>
                           </div>
                        <li>
                           <div id="cancel_description" >
                              <div class="form_grid_12">
                                 <label class="field_title" for="user_id">Description<span class="req">*</span></label>
                                 <textarea  tabindex="2" style="width:35%;" class="large tipTop" placeholder="Enter your description" id="can_description" title="Enter your description" name="cancel_description" onchange="javascript:Detailview(this,<?php echo $listDetail->row()->id; ?>,'cancel_description');" required/><?php echo $listDetail->row()->cancel_description;?></textarea>
                                 <span id="can_description_error" style="color:red;font-size:12px;" class="error"></span>
                              </div>
                           </div>
                        </li>
                        </li> 
                        <li style="display:none">
                           <div class="form_grid_12">
                              <label class="field_title" for="description">Deal Amount</label>
                              <div class="form_input">
                                 <input type="text" name="deal_amount" id="deal_amount" tabindex="9" class="required large tipTop" title="Please enter deal amount" value="<?php if(!empty($ProductDealPrice)){ echo trim(stripslashes($ProductDealPrice->row()->deal_amount)); }?>"  
                                    onchange="DealPriceInsert(this.value,'deal_amount');"/>
                              </div>
                           </div>
                        </li>
                        <li style="display:none">
                           <div class="form_grid_12">
                              <label class="field_title" for="description">Deal Start Date</label>
                              <div class="form_input">
                                 <input type="text" name="deal_start_date" id="deal_start_date" tabindex="9" class="required large tipTop datepicker" title="Please select deal start date" value="<?php if(!empty($ProductDealPrice)){ echo trim(stripslashes($ProductDealPrice->row()->deal_start_date)); }?>"  
                                    onchange="DealPriceInsert(this.value,'deal_start_date');"/>
                              </div>
                           </div>
                        </li>
                        <li style="display:none">
                           <div class="form_grid_12">
                              <label class="field_title" for="description">Deal End Date</label>
                              <div class="form_input">
                                 <input type="text" name="deal_end_date" id="deal_end_date" tabindex="9" class="required large tipTop datepicker" title="Please select deal end date" value="<?php if(!empty($ProductDealPrice)){ echo trim(stripslashes($ProductDealPrice->row()->deal_end_date)); }?>"  onchange="DealPriceInsert(this.value,'deal_end_date');"/>
                              </div>
                           </div>
                        </li>
						

						
						
						
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="admin_name">Video URL</label>
                              <div class="form_input">
                                 <label class="" for="price"><span class="req"></span></label>
                                 <input type="url" class="large tipTop vdo_hght" name="video_url" title="Please enter the Video URL" tabindex="5" id="video_url"  value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->video_url)); }?>" >
                                 <br><br><label class="">Example: https://www.youtube.com/watch?v=u0PKS0nr63k </label><br><br>
                    
                     <label>Go to Youtube video</label><br><br>
                     <label>Now Copy URL Link</label><br><br>
                     <label>Paste above Video Input</label>
                              </div>
                           </div>
                        </li>
                        <?php 
                           $prd_id=$this->uri->segment(4);
                           if ($prd_id==''){  ?>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="admin_name">Request to Book <span class="req">*</span></label>
                              <div class="form_input">                  
                                 <input type="radio" tabindex="11" name="request_to_book" id="req_id_y" checked onChange="CheckStatus()" value="Yes"/>Yes
                                 <input type="radio" tabindex="11" name="request_to_book"  id="req_id_n"  onChange="CheckStatus()" <?php if(!empty($product_details)){ if($product_details->row()->request_to_book=='No'){echo 'checked="checked"';}}?> value="No"/>No
                              </div>
                           </div>
                        </li>
                        <?php   } else { ?>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="admin_name">Request to Book <span class="req">*</span></label>
                              <div class="form_input">                 
                                 <input type="radio" tabindex="11" name="request_to_book" id="req_id_y"  onChange="CheckStatus()" <?php if(!empty($product_details)){ if($product_details->row()->request_to_book=='Yes'){echo 'checked="checked"';}}?> value="Yes"/>Yes
                                 <input type="radio" tabindex="11" name="request_to_book"  id="req_id_n"  onChange="CheckStatus()"  <?php if(!empty($product_details)){ if($product_details->row()->request_to_book=='No'){echo 'checked="checked"';}}?>value="No"/>No
                              </div>
                           </div>
                        </li>
                        <?php } ?> 
                        <label id="req_error" style="font-size:12px;display:none;" class="error">Please Choose The Field</label>
                        <!--<li>
                           <div class="form_grid_12">
                           	<label class="field_title" for="admin_name">Request to Book <span class="req">*</span></label>
                           	<div class="form_input">
                           		<input type="radio" tabindex="11" name="request_to_book" id="req_id_y" checked onChange="CheckStatus()" value="Yes"/>Yes
                           		<input type="radio" tabindex="11" name="request_to_book"  id="req_id_n"  onChange="CheckStatus()" value="No"/>No
                           	</div>
                           </div>
                           </li>-->
                        <?php if ($instant_pay->row()->status=='1') { ?>
                        <?php 
                           $prd_id=$this->uri->segment(4);
                           if ($prd_id==''){  ?>  
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="admin_name">Instant Pay <span class="req">*</span></label>
                              <div class="form_input">                  
                                 <input type="radio" tabindex="11" name="instant_pay" id="instant_y" onChange="CheckStatusTwo()"  <?php if(!empty($product_details)){ if($product_details->row()->instant_pay=='Yes'){echo 'checked="checked"';}}?> value="Yes"/>Yes
                                 <input type="radio" tabindex="11" name="instant_pay" checked  id="instant_n"  onChange="CheckStatusTwo()" value="No"/>No 
                              </div>
                           </div>
                        </li>
                        <?php   } else { ?>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="admin_name">Instant Pay <span class="req">*</span></label>
                              <div class="form_input">                 	  
                                 <input type="radio" tabindex="11" name="instant_pay" id="instant_y" onChange="CheckStatusTwo()" <?php if(!empty($product_details)){ if($product_details->row()->instant_pay=='Yes'){echo 'checked="checked"';}}?> value="Yes"/>Yes
                                 <input type="radio" tabindex="11" name="instant_pay"   id="instant_n"  onChange="CheckStatusTwo()"  <?php if(!empty($product_details)){ if($product_details->row()->instant_pay=='No'){echo 'checked="checked"';}}?> value="No"/>No
                              </div>
                           </div>
                        </li>
                        <?php } ?> 				
                        <!-- <li>
                           <div class="form_grid_12">
                           	<label class="field_title" for="admin_name">Instant Pay <span class="req">*</span></label>
                           	<div class="form_input">
                           		<input type="radio" tabindex="11" name="instant_pay" id="instant_y" onChange="CheckStatusTwo()" value="Yes"/>Yes
                           		<input type="radio" tabindex="11" name="instant_pay" checked  id="instant_n"  onChange="CheckStatusTwo()" value="No"/>No
                           	</div>
                           </div>
                           </li>-->
                        <?php } ?> 
                        <label id="instatnt_error" style="font-size:12px;display:none;" class="error">Please Choose The Field</label>	  
                        <li>
                           <div class="form_grid_12">
                              <div class="form_input">
                                 <input type="button" class="btn_small btn_blue" id="nextImage" tabindex="9" onclick="save_tab1();" value="Save and Next"/>
                                 <!--<input type="button" class="btn_small btn_blue nxtTab" id="nextImage" tabindex="9" value="Next"/>
                                    <input type="button" class="btn_small btn_blue" value="Save" onclick="save_tab1();" />-->
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <div id="tab2">
                     <ul class="tab-areas2">
                        <li>
                           <?php //include('img_upload.php'); ?>
                           <div class="form_grid_12">
                              <center>
                                 <br><br><b>&nbsp Add a photo or two!</b>
                                 <p>Or three, or more! Guests love photos that highlight the features of your space.</p>
                                 <p style="color:red">Image size must be above (700 x 467) pixel</p>
                              </center>
                              <label class="field_title" for="product_image">Rental Image <span class="req">*</span></label><br>
                              <div class="dragndrop1"><a href="javascript:void(0);" onclick="ImageAddClick();">Choose Image</a></div>
                           </div>
                        </li>
                        <li>
                           <div class="widget_content">
                              <table class="display display_tbl" id="image_tbl">
                                 <thead>
                                    <tr align="center">
                                       <th > Sno </th>
                                       <th> Image </th>
                                       <!--<th> Position </th>-->
                                       <th> Action </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                       // echo "<pre>";print_r($imgDetail->result_array());
                                       if (!empty($imgDetail) && !empty($product_details)){
                                       $i=0;$j=1;
                                       $this->session->set_userdata(array('product_image_'.$product_details->row()->id => $product_details->row()->image));
                                       foreach ($imgDetail->result() as $img){
                                       if ($img != ''){
                                       ?>
                                    <tr id="img_<?php echo $img->id ?>">
                                       <td class="center tr_select "><input type="hidden" name="imaged[]" value="<?php echo $img->product_image; ?>"/>
                                          <?php echo $j;?> 
                                       </td>
                                       <td class="center "><img src="<?php if(strpos($img->product_image, 's3.amazonaws.com') > 1)echo $img->product_image;else echo base_url()."server/php/rental/".$img->product_image; ?>"  height="80px" width="80px" /> </td>
                                       <td class="center tr_select">
                                          <ul class="action_list" style="background:none;border-top:none;">
                                             <li style="width:100%;"><a class="p_del tipTop" href="javascript:void(0)" onClick="javascript:DeleteProductImage(<?php echo $img->id; ?>,<?php echo $product_details->row()->id; ?>);" title="Delete this image">Remove</a></li>
                                          </ul>
                                       </td>
                                    </tr>
                                    <?php 
                                       $j++;
                                       		}
                                       		$i++;
                                       	}
                                       }
                                       ?>
                                 </tbody>
                                 <tfoot>
                                    <tr align="center">
                                       <th> Sno </th>
                                       <th> Image </th>
                                       <!--<th> Position </th>-->
                                       <th> Action </th>
                                    </tr>
                                 </tfoot>
                              </table>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <div class="form_input">
                                 <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Previous"/>
                                 <input type="button" class="btn_small btn_blue" tabindex="9" id="nextImage_up" onclick="img();" value="Save and Next"/>
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
				  
                  <div id="tab3">
                     <?php  
                        if(!empty($product_details)) {
                                            $list_name = $product_details->row()->list_name;						  
                        	 $facility = (explode(",", $list_name));  
                        }    
                        ?> 
                     <?php if($listNameCnt->num_rows()>0){ ?>
                     <ul  class="tab-areas3">
                        <?php 
                           foreach($listNameCnt->result() as $listVals){
                           $listValues = $this->product_model->get_all_details(LIST_VALUES,array('list_id'=>$listVals->id));
                           ?>
                        <?php if( $listValues->row()->list_value!="") { ?>
                        <h3 style="text-transform: uppercase;"><?php echo $listVals->attribute_name; ?></h3>
                        <?php } ?>
                        <?php  
                           if($listValues->num_rows()>0){	
                           	foreach($listValues->result() as $details){
                           ?>
                        <li>
                           <input type="checkbox" class="checkbox_check" name="list_name[]" id="mostcommon<?php echo $details->id; ?>"  <?php if(in_array($details->id,$facility)) { ?> checked="checked" <?php } ?> value="<?php echo $details->id; ?>"/>
                           <span><?php echo $details->list_value; ?></span>
                        </li>
                        <?php 
                           }
                           }
                           }					
                                        ?>  
                        <input type="hidden" name="" id="edit_pro_id" value="<?php echo $this->uri->segment(4);?>">		
                        <li class="btnsa">
                           <div class="form_grid_12">
                              <div class="form_input" style="margin:0px;width:100%;">
                                 <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Previous"/>
                                 <input type="button" class="btn_small btn_blue nxtTab" tabindex="9" onclick="save_tab3();" value="Save and Next"/>
                                 <!--<input type="button" class="btn_small btn_blue" value="Save" onclick="save_tab3();" />-->
                              </div>
                           </div>
                        </li>
                     </ul>
                     <?php } ?>
                  </div>
                  <div id="tab4">
                     <ul id="AttributeView">
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="address">Location <span class="req">*</span></label>
                              <div class="form_input">
                                 <input id="autocomplete-admin" name="address" onblur="getAddressDetails();" placeholder="" onFocus="geolocate()" type="text" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->address)); }?>" style="width:370px;" class="large tipTop" title="Enter Your Location"><label id="location_error_valid" style="display:none;" class="error"> Only Alphabets are allowed</label>
                                 <span id="location_error" style="color:red;font-size:12px;" class="error">
                                 </span>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="country">Country<span class="req">*</span></label>
                              <div class="form_input">
                                 <input placeholder=""  id="country" name="country" type="text" value="<?php if($productAddressData->row()->country != '')echo $productAddressData->row()->country; //echo $country;?>" style="width:370px;" class="large tipTop" title="Enter Country Name"><label id="country_error_valid" style="display:none;" class="error"> Only Alphabets are allowed</label>
                                 <span id="country_error" style="color:red;font-size:12px;" class="error">
                                 </span>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="state">State<span class="req">*</span></label>
                              <div class="form_input" id="listCountryCnt">
                                 <input placeholder="" id="state" name="state" type="text" value="<?php if($productAddressData->row()->state != '')echo $productAddressData->row()->state; //echo $state;?>" style="width:370px;" class="large tipTop" title="Enter State Name"><label id="state_error_valid" style="display:none;" class="error"> Only Alphabets are allowed</label>
                                 <span id="state_error" style="color:red;font-size:12px;" class="error">
                                 </span>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="city">City<span class="req">*</span></label>
                              <div class="form_input" id="listStateCnt">
                                 <input  id="city" name="city" type="text" value="<?php if($productAddressData->row()->city != '')echo $productAddressData->row()->city; 
                                    //echo $city;?>" style="width:370px;" class="large tipTop" title="Enter City Name"><label id="city_error_valid" style="display:none;" class="error"> Only Alphabets are allowed</label>
                                 <span id="city_error" style="color:red;font-size:12px;" class="error">
                                 </span>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="apt">Street Address</label>
                              <div class="form_input">
                                 <input type="text" name="apt" id="apt"  tabindex="3" style="width:370px;" class="large tipTop" title="Enter Street Address" value="<?php if($productAddressData->row()->street != '')echo $productAddressData->row()->street; ?>"/>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="post_code">Zip Code<span class="req"></span></label>
                              <div class="form_input">
                                
                                 <input type="text" name="post_code" maxlength="11" pattern="[A-Za-z1-9\s-]{3,11}" id="post_code" tabindex="8" class="large tipTop" title="Enter the Zip code" value="<?php  if($productAddressData->row()->zip != '') echo $productAddressData->row()->zip; // echo $zip;?>" /><label id="post_code_error_valid" style="color:#f00;display:none;font-size:12px;" class="error">Only Numbers are allowed</label><span id="post_code_length_error" style="color:red;"></span>
                              </div>
                              <div style="margin-left:30%;margin-top:10px;">
                                 <?php if(!empty($product_details)){ $in_address = trim(stripslashes($product_details->row()->address)); ?>
                                 <img id='map-image' border="0" alt="Greenwich, England" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $in_address; ?>&zoom=13&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?php echo $in_address; ?>">
                                 <!--<img id='map-image' border="0" alt="Greenwich, England" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $in_address; ?>&zoom=13&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?php echo $in_address; ?>"> 
                                    <img id='map-image' border="0" alt="Greenwich, England" src="http://maps.googleapis.com/maps/api/staticmap?center=Albany,+NY&zoom=13&scale=false&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7CAlbany,+NY" alt="Google Map of Albany, NY">-->
                                 <?php }?>
                                 <div  align="center" id="map-new" style="width: 600px; height: 300px; display:none">
                                    <p id='map-text' style="margin-top:150px;">Map will be displayed here</p>
                                 </div>
                              </div>
                           </div>
                        </li>
                     </ul>
                     <ul>
                        <li>
                           <div class="form_grid_12">
                              <div class="form_input" style="margin:0px;width:100%;">
                                 <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Previous"/>
                                 <input type="button" class="btn_small btn_blue" tabindex="9" id="nextlist" onclick="save_tab4(); email_publish();" value="Save and Next"/>
                                 <!--<input type="button" class="btn_small btn_blue" value="Save"  />-->
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <div id="tab5">
                     <ul>
                        <h4>Listing Info:</h4>
                        <?php
         
                           		 foreach ($listSpace->result() as $listresult)
                           			{
                           			
                     
                           		        $name = $listresult->attribute_name;
                           		         $id = $listresult->id;
                           			 ?>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="confirm_email"><?php echo $name; ?>
                              <span class="req">*</span></label> 
                              <div class="form_input">
                                 <?php if($product_details->num_rows != 0 ){ 
								 
										$sql = 'SELECT * FROM fc_listspace_values WHERE listspace_id = '.$id;
                                        $inner = $this->db->query($sql);
										
									   if ($inner->num_rows() > 0) {
									   
								 ?>
								 
								 
								 
                                 <select  name="<?php if($listresult->attribute_seourl == 'propertytype')echo 'home_type';else if($listresult->attribute_seourl == 'roomtype') echo 'room_type';?>"  id="home_type1" onchange="javascript:Detailview_admin(this,<?php echo $product_details->row()->id; ?>,'<?php if($listresult->attribute_seourl == 'propertytype')echo 'home_type';else if($listresult->attribute_seourl == 'roomtype') echo 'room_type';?>');" autocomplete="off">
                                    <option value="">--Select--</option>
                                    <?php
                                      
                                       foreach($inner->result() as $listvalues)
                                       { 
                                       
                                       if($pcount == 0){
                                       
                                       ?>  
                                    <option value="<?php echo $listvalues->id; ?>" <?php if($listresult->attribute_seourl == 'propertytype'){ if(trim($listvalues->id) == trim($product_details->row()->home_type)) {echo 'selected="selected"';} }else if($listresult->attribute_seourl == 'roomtype'){ if(trim($listvalues->id) == trim($product_details->row()->room_type)){ echo 'selected="selected"';} } ?> ><?php echo $listvalues->list_value; ?></option>
                                    <?php } else{  ?>
                                    <option value="<?php echo $listvalues->id; ?>" <?php if($listvalues->id == $product_details->row()->room_type) echo 'selected="selected"'; ?> ><?php echo $listvalues->list_value; ?></option>
                                    <?php
                                       }
                                         
									    } ?>
                                 </select>
								 
								 
									   <?php } } else {
									 
									   $sql = 'SELECT * FROM fc_listspace_values WHERE listspace_id = '.$id;
                                       $inner = $this->db->query($sql);
                                       //echo "<pre>"; print_r($inner->result()); 
									 if ( $inner->num_rows() > 0) {
									 
                                    ?>
                                 <select name="<?php if($listresult->attribute_seourl == 'propertytype')echo 'home_type';else if($listresult->attribute_seourl == 'roomtype') echo 'room_type';?>" id="home_type2" onchange="javascript:Detailview_admin(this,document.getElementById('prdiii').value,'<?php if($listresult->attribute_seourl == 'propertytype')echo 'home_type';else if($listresult->attribute_seourl == 'roomtype') echo 'room_type';?>');" autocomplete="off">
                                    <option value="">Select</option>
                                    <?php
                                    
                                       foreach($inner->result() as $listvalues)
                                       { 
                                       if($pcount == 0){
                                       ?>  
                                    <option value="<?php echo $listvalues->id; ?>"><?php echo $listvalues->list_value; ?></option>
                                    <?php }else{  ?>
                                    <option value="<?php echo $listvalues->id; ?>"><?php echo $listvalues->list_value; ?></option>
                                    <?php
                                       }
                                         
                                       } ?>
                                 </select>
									 <?php } ?>
                                 <?php } ?>
                              </div>
                           </div>
                        </li>
                        <?php } ?>
						
                        <?php 
                           $product_list_decode = json_decode($listDetail->row()->listings);
                           foreach($product_list_decode as $product_list_name => $product_list_values)
                           {
                            $product_list_data[$product_list_name] = $product_list_values;
                           }
                           
                           
                           	//	print_r($product_list_decode); 
                           
                           
                           $roombedVal=$values1;
                           
						 
                           
                             foreach ($roombedVal as $key => $value){ 			
                           $listing_keys[$key] = $key;
                           $listing_values[$key] = $value;
                           }
                           //print_r($listTypeValues->result());
                           $i = 1;
                            foreach ($listTypeValues->result() as $keys => $finals)
                           {
                           	 $name = $finals->name;
                           
                           	 $field_id =  $finals->id;
                           	 
                           
						   $getChildValues=$this->product_model->get_all_details(LISTING_CHILD,array('parent_id'=>$field_id)); 
                           	 
                          // if($name != 'accommodates' && $name != 'can_policy'){
                           if($name != 'can_policy'){ 
                           			$list_type = $finals->type;  
                           ?>
						   
						   
						 <?php 
						  if ($list_type=='option'){			 
						?>
							<li  style="<?php if ($getChildValues->num_rows() > 0) { echo "display:block"; } else { echo "display:none"; }?>">
						<?php } else { ?>
							<li>
						<?php } ?>
		
                           <div class="form_grid_12">
						   
						   
						   
                              <label class="field_title" for="confirm_email"><?php   

							//*Preetha - Start - display if childvalues exist 
							if ($list_type=='option'){
								if ($getChildValues->num_rows() > 0 ){									
									//echo str_replace('_',' ',$finals->name); 
									echo str_replace('_',' ',$finals->labelname); 
								}														
							}else{
									//echo str_replace('_',' ',$finals->name);
									echo str_replace('_',' ',$finals->labelname);
							}		
						//*Preetha - End - display if childvalues exist 
							  
							  
							  
							  
                                 if($name == 'minimum_stay') { ?>
                              <span class="req"> *</span><?php } ?></label>
                              <div class="form_input">
                                 <?php 
                                    if($list_type == 'option' ) { 
										if ($getChildValues->num_rows() > 0 ){	
                                    
                                    ?>
									
                            <!-- <select name="<?php //echo  $name; ?>" id="home_type3" class="valid <?php// echo $name; ?>" onchange="javascript:DetaillistAdmin(this,document.getElementById('prdiii').value,'<?php //echo $name; ?>');">saves as name-->
							
							<!--saves as ID -->	 
								  <select name="<?php //echo  $name; ?>" id="home_type3" class="valid <?php echo $name; ?>" onchange="javascript:DetaillistAdmin(this,document.getElementById('prdiii').value,'<?php echo $field_id; ?>');">
							<!--saves as ID -->	
								 
                                    <option value="">Select</option>
                                    <?php 
                                       foreach($listchildValues->result() as $val){ 
                                       
                                       	//$my_id = $val->id;
                                       	if($field_id == $val->parent_id){
                                       
                                       	?>
                                    <option value="<?php echo $val->id; ?>"  <?php if (in_array($val->id, $product_list_data)) {  echo 'selected="selected"'; }   ?> ><?php echo $val->child_name; ?></option>
                                    <?php } }  ?>                         
                                 </select>
									<?php   } } else { ?>
                                 <div class="textClass">
								 
                                 <!--   <input type="text"  value="<?php// echo  $product_list_data[$name]; ?>" class="text_size tipTop" title="Enter <?php //echo str_replace('_',' ',$name); ?>" onchange="javascript:DetaillistAdmin(this,document.getElementById('prdiii').value,'<?php //echo $name; ?>');">saves as name-->
								 
									<!--saves as ID -->	
									 <input type="text"  value="<?php echo  $product_list_data[$field_id]; ?>" class="text_size tipTop" title="Enter <?php echo str_replace('_',' ',$name); ?>" onchange="javascript:DetaillistAdmin(this,document.getElementById('prdiii').value,'<?php echo $field_id; ?>');">
									 
									 <!--saves as ID -->
									 
                                 </div>
                                 <?php
                                    /*
                                    $j=1;
                                    
                                    foreach($product_list_decode as $product_list_name => $product_list_values)
                                    {
                                    
                                    echo $product_list_name;
                                    $product_list_data[$product_list_name] = $product_list_values;
                                    
                                    
                                    
                                    
                                    $check_text_value = $this->db->select('*')->from('fc_listing_types')->where('id',$product_list_name)->get();
                                    
                                    echo $check_text_value->row()->type.'<br>';
                                    
                                    if($check_text_value->row()->type == 'text'){
                                    
                                    
                                    ?>
                                 <input type="text" value="<?php echo $product_list_values; ?> " class="text_size" onchange="javascript:Detaillist(this,document.getElementById('prdiii').value,'<?php echo $name; ?>');" >
                                 <?php 
                                    }
                                    $j++;  
                                    
                                    }
                                    */
                                    } ?>
                              </div>
                           </div>
                        </li>
                        <?php }   $i++; } ?>
                        <!-- Old -->
                        <?php		
                           // $product_list_decode = json_decode($listDetail->row()->listings);
                           
                           // 	foreach($product_list_decode as $product_list_name => $product_list_values)
                           // 	{
                           // 	 $product_list_data[$product_list_name] = $product_list_values;
                           // 	}
                           
                           // 	//print_r($values);
                           // 	$roombedVal=json_decode($values);
                           
                           
                           // 	  foreach ($roombedVal as $key => $value){ 			
                           // 	$listing_keys[$key] = $key;
                           // 	$listing_values[$key] = $value;
                           // 	}
                           	
                           // 	 foreach ($listTypeValues->result() as $keys => $finals)
                           // 	{
                           // 		 $name = $finals->name; 
                           // 		 $field_id = $finals->id;
                           // 	if($name != 'accommodates' && $name != 'can_policy'){
                           // 				$list_type = $finals->type;  
                           ?>
                        <!-- <li> -->
                        <!--  <div class="form_grid_12">
                           <label class="field_title" for="confirm_email"><?php echo str_replace('_',' ',$name); ?></label>
                                         <div class="form_input"> -->
                        <?php 
                           //if($list_type == 'option' ) { 
                           
                           ?>
                        <!--                    <select name="" id="home_type" class="valid" onchange="javascript:DetaillistValues(this,document.getElementById('prdiii').value,'<?php echo $name; ?>');">
                           <option value="">Select</option>
                              <?php 
                              $valuesArr=@explode(',',$listing_values[$name]);
                              		
                              			  foreach($valuesArr as $value){
                              			?>
                           		
                              <option value="<?php echo $value; ?>" <?php   if($name == 'minimum_stay'){ if($listDetail->row()->minimum_stay == $value){echo 'selected="selected"'; }} else if($product_list_data[$name] == $value){ echo 'selected="selected"'; }   ?> >
                           				<?php echo $value; ?>
                           			</option>
                               
                             <?php }?>
                                                      
                                         </select> -->
                        <?php     //} else {  ?>
                        <!--  <input type="text"  value="<?php echo  $product_list_data[$name]; ?>" class="text_size" onchange="javascript:DetaillistValues(this,document.getElementById('prdiii').value,'<?php echo $name; ?>');"> -->
                        <?php //} ?>
                        <!-- </div>
                           </div> -->
                        <!-- </li> -->
                        <?php //}    } ?>
                        <li>
                           <div class="form_grid_12">
                              <div class="form_input" style="margin:0px;width:100%;">
                                 <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Previous"/>
                                 <input type="button" class="btn_small btn_blue" tabindex="9" id="nextdes" value="Save and Next" onclick="save_tab5();"/>
                                 <!--<input type="button" class="btn_small btn_blue" value="Save" onclick="save_tab5();" />-->
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <div id="tab6">
                     <ul>
                        <h3>Details</h3>
                        <p>A description of your space displayed on your public listing page. </p>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="space">The Space</label>
                              <div class="form_input">
                                 <textarea name="space" id="space" tabindex="13" placeholder="What makes your listing unique?" style="width:370px;height:100px;" class="large tipTop" title="what makes  your listing unique ?"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->space)); }?></textarea>
                              </div>
                           </div>
                        </li>
                        <h3>Extra Details</h3>
                        <p>Other information you wish to share on your public  page. </p>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="other_thingnote">Other Things to Note</label>
                              <div class="form_input">
                                 <textarea name="other_thingnote" id="other_thingnote" placeholder="Are there any other details you’d like to share ?" tabindex="13" style="width:370px;height:100px;" class="large tipTop" title="Are there any other details you’d like to share ?"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->other_thingnote)); }?></textarea>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="house_rules">House Rules</label>
                              <div class="form_input">
                                 <textarea name="house_rules" id="house_rules" placeholder="How do you expect your guests to behave ?" tabindex="13" style="width:370px;height:100px;" class="large tipTop" title="How do you expect your guests to behave ?"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->house_rules)); }?></textarea>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="house_rules">Guest Access</label>
                              <div class="form_input">
                                 <textarea name="guest_access" id="guest_access" placeholder="How do you expect your Guest Access ?" tabindex="13" style="width:370px;height:100px;" class="large tipTop" title="How do you expect your Guest Access?"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->guest_access)); }?></textarea>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="house_rules">Interaction with Guest</label>
                              <div class="form_input">
                                 <textarea name="interact_guest" id="interact_guest" placeholder="Interaction with guest" tabindex="13" style="width:370px;height:100px;" class="large tipTop" title="Interaction with guest"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->interact_guest)); }?></textarea>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="house_rules">Neighborhood</label>
                              <div class="form_input">
                                 <textarea name="neighbor_overview" id="neighbor_overview" placeholder="Neighborhood" tabindex="13" style="width:370px;height:100px;" class="large tipTop" title="Neighborhood"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->neighbor_overview)); }?></textarea>
                              </div>
                           </div>
                        </li>
                     </ul>
                     <ul>
                        <li>
                           <div class="form_grid_12">
                              <div class="form_input" style="margin:0px;width:100%;">
                                 <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Previous"/>
                                 <input type="button" class="btn_small btn_blue" tabindex="9" id="nextseo" onclick="save_tab6();" value="Save and Next"/>
                                 <!--<input type="button" class="btn_small btn_blue" value="Save" onclick="save_tab6();" />-->
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <div id="tab7">
                     <ul>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="meta_title">Meta Title</label> <!-- <span class="req">*</span>-->
                              <div class="form_input">
                                 <input name="meta_title" id="meta_title" type="text" tabindex="1" class="large tipTop" title="Enter the page meta title" value="<?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->meta_title)); }?>"/>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="description">Keywords</label> <!-- <span class="req">*</span>-->
                              <div class="form_input">
                                 <textarea name="meta_keyword" id="meta_keywords" tabindex="13" style="width:370px;height:150px;" class="large tipTop" title="Enter the keywords"><?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->meta_keyword)); }?></textarea>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="form_grid_12">
                              <label class="field_title" for="description">Meta Description</label> <!-- <span class="req">*</span>-->
                              <div class="form_input">
                                 <textarea name="meta_description" id="meta_description" tabindex="13" style="width:370px;height:150px;" class="large tipTop" title="Enter the meta description"> <?php if(!empty($product_details)){ echo trim(stripslashes($product_details->row()->meta_description)); }?></textarea>
                              </div>
                           </div>
                        </li>
                     </ul>
                     <ul>
                        <li>
                           <div class="form_grid_12">
                              <div class="form_input">
                                 <input type="button" class="btn_small btn_blue prvTab" tabindex="9" value="Previous"/>
                                 <button type="submit" class="btn_small btn_blue" tabindex="4"><span>Save</span></button>
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <input type="hidden" name="userID" value="<?php if ($loginID != ''){echo $loginID;}else {echo '0';}?>"/>
               </form>
            </div>
         </div>
      </div>
   </div>
   <span class="clear"></span> 
</div>
</div>

<style>
   .text_size
   {
   width: 188px !important;
   }
</style>
<script type="text/javascript">
   function DealPriceInsert(value,title)
   {
   var pid=document.getElementById('prdiii').value;
   
    $.ajax({
   type:'POST',
   url:'<?php echo base_url()?>admin/product/DealPriceInsert',
   data:{val:value,product_id:pid,title:title},
   success:function(msg)
   {
   }
   })
   }
</script>
<script>
   // This example displays an address form, using the autocomplete feature
   // of the Google Places API to help users fill in the information.
   
   var placeSearch, autocomplete;
   var componentForm = {
     street_number: 'short_name',
     route: 'long_name',
     locality: 'long_name',
     administrative_area_level_1: 'short_name',
     country: 'long_name',
     postal_code: 'short_name'
   };
   
   
   function initializeMap() { 
     // Create the autocomplete object, restricting the search
     // to geographical location types.
     
     autocomplete = new google.maps.places.Autocomplete(
   	  /** @type {HTMLInputElement} */(document.getElementById('autocomplete-admin')),
   	  { types: ['geocode'] });
     // When the user selects an address from the dropdown,
     // populate the address fields in the form.
     google.maps.event.addListener(autocomplete, 'place_changed', function() {
   	fillInAddress();
     });
   }
   
   // [START region_fillform]
   function fillInAddress() {
     // Get the place details from the autocomplete object.
     var place = autocomplete.getPlace();
   
     for (var component in componentForm) {
   	document.getElementById(component).value = '';
   	document.getElementById(component).disabled = false;
     }
   
     // Get each component of the address from the place details
     // and fill the corresponding field on the form.
     for (var i = 0; i < place.address_components.length; i++) {
   	var addressType = place.address_components[i].types[0];
   	if (componentForm[addressType]) {
   	  var val = place.address_components[i][componentForm[addressType]];
   	  document.getElementById(addressType).value = val;
   	}
     }
   }
   // [END region_fillform]
   
   // [START region_geolocation]
   // Bias the autocomplete object to the user's geographical location,
   // as supplied by the browser's 'navigator.geolocation' object.
   function geolocate() {
     if (navigator.geolocation) {
   	navigator.geolocation.getCurrentPosition(function(position) {
   	  var geolocation = new google.maps.LatLng(
   		  position.coords.latitude, position.coords.longitude);
   	  var circle = new google.maps.Circle({
   		center: geolocation,
   		radius: position.coords.accuracy
   	  });
   	  autocomplete.setBounds(circle.getBounds());
   	});
     }
   }
   
   // [END region_geolocation]
   
   
   function getAddressDetails()
   {
   	var address = $('#autocomplete-admin').val();
   	
   	$.ajax({
   		type: 'POST',
   		url: baseURL+'site/product/get_location',
   		data: {"address":address},
   		dataType:'json',
   		success: function(json){
   			$('#country').val(json.country);
   			$('#state').val(json.state);
   			$('#city').val(json.city);
   			$('#post_code').val(json.zip);
   			$('#apt').val(json.area);
   			$('#latitude').val(json.lat);
   			$('#longitude').val(json.lang);
   			
   			myLatlng = new google.maps.LatLng(json.lat,json.lang);
   			
   			citymap['chicago'] = {
   				center: myLatlng,
   				population: 200
   				};
   				$("#map-image").hide();
   				$("#map-new").show();
   			initializeMapCircle();
   
   		}
   	});
   	
   }
   
   
</script>
<script type="text/javascript">
   function CheckStatus(){
   var req=$('input[name="request_to_book"]:checked').val();
   if (req=='No'){
   $('#instant_y').attr('checked', true);
   }
   }
   function CheckStatusTwo(){
   var instant=$('input[name="instant_pay"]:checked').val();
   if (instant=='No'){
   $('#req_id_y').attr('checked', true);
   }
   }
   
   
   /* function CheckStatus(){
   var req=$('input[name="request_to_book"]:checked').val();
   if (req=='No'){
   $('#req_id_n').attr('checked', true);
   }
   if (req=='Yes'){
   $('#req_id_y').attr('checked', true);
   }
   }
   function CheckStatusTwo(){
   var instant=$('input[name="instant_pay"]:checked').val();
   if (instant=='No'){
   $('#instant_n').attr('checked', true);
   }
   if (instant=='Yes'){
   $('#instant_y').attr('checked', true);
   }
   } */
</script>
<script type="text/javascript">
   $('#addproduct_form1111').validate();
   
   $('input#price').blur(function(){
       var num = parseFloat($(this).val());
       var cleanNum = num.toFixed(2);
      // $(this).val(cleanNum);
       if(num/cleanNum < 1){
           $('#price_error').text('Please enter only 2 decimal places, we have truncated extra points');
       }
   });
</script>
<script type="text/javascript">
   function save_tab1(){
   
   	var user_id = $('#current_user_id :selected').val();
   
   
   	///var pro_id = window.location.hash.substr(1);
   	var pro_id = $('#prdiii').val(); 
   	var price = $('#price').val();
   	var security_deposit = $('#security_deposit').val();
   	var Cleaning_fees	= $('#Cleaning_fees').val();
   	var currency = $('#currency').val();
   	var video_url = $('#video_url').val();
   
   	//alert(currency);
   
   	var cancellation_policy = $('#cancellation_policy :selected').val();
   if(cancellation_policy == 'Strict')
   {
   var return_amount = '0';
   }else
   {
   var return_amount = $('#return_amount').val();
   }
   
   var can_description = $('#can_description').val();
   var product_title = $('#product_title').val();
   var product_summary = $('#description').val(); 
   var req=$('input[name="request_to_book"]:checked').val(); 
   var instant=$('input[name="instant_pay"]:checked').val();
   	var status = 'Publish';
   
   
   if($.trim(cancellation_policy)!="" && $.trim(product_title)!="" && $.trim(product_summary)!="" && $.trim(req)!=""  && $.trim(price)!="" && $.trim(can_description)!="" )
   {
   $("#nextImage").addClass("nxtTab_img");
   validateFormSection();
   }
   else
   {
   
   alert("Save by filling all mandatory fields and proceed to Next"); 
   }
   
   if(cancellation_policy == 'Flexible')
   {
   if(return_amount =='')
   {
   $("#return_amount_error").text("Enter the return amount");
   return false;
   }else if(can_description ==''){
   $("#can_description_error").text("Enter the cancel description");
   return false;
   }else
   {
   $("#return_amount_error").text("");
   $("#can_description_error").text("");
   }
   }
   if(cancellation_policy == 'Moderate')
   {
   if(return_amount =='')
   {
   $("#return_amount_error").text("Enter the return amount");
   return false;
   }else if(can_description ==''){
   $("#can_description_error").text("Enter the cancel description");
   return false;
   }else
   {
   $("#return_amount_error").text("");
   $("#can_description_error").text("");
   }
   }
   if(cancellation_policy == 'Strict')
   {
   if(can_description ==''){
   $("#can_description_error").text("Enter the cancel description");
   return false;
   }else
   {
   $("#can_description_error").text("");
   }
   }
   
   if(product_title == '')
   {
   $("#title_error").text("Enter your property title");
   $("#product_title").focus();
   
   return false;
   }else{
   $("#title_error").text("");
   }
   if(product_summary == '')
   {
   $("#summary_error").text("Enter your property summary");
   $("#description").focus();
   return false;
   }else{
   $("#summary_error").text("");
   }
   
   if(req !='No' && req !='Yes')
   {
   $("#req_error").text("Choose Your Option");
   $("#request_to_book").focus();
   return false;
   }else{
   $("#req_error").text("");
   }
   /*if(instant !='No' && instant !='Yes')
   {
   $("#instant_error").text("Choose Your Option");
   $("#instant_pay").focus();
   return false;
   }else{
   $("#instant_error").text("");
   }*/
   	if(price == '')
   {
   $("#price_error").text("Enter your property price");
   $("#price").focus();
   return false;
   }else
   {
   var cleanNum = (parseFloat(price)).toFixed(2);
   // alert(parseFloat(price)/cleanNum);
   if(parseFloat(price)/cleanNum != 1){
    $('#price_error').text('Please enter only 2 decimal places, we have truncated extra points');
    return false;
   }else{
   $("#price_error").text("");
   }
   }
   if(security_deposit != '')
   
   {
   var cleanNum = (parseFloat(security_deposit)).toFixed(2);
   // alert(parseFloat(security_deposit)/cleanNum);
   if(parseFloat(security_deposit)/cleanNum != 1){
    $('#security_deposit_error').text('Please enter only 2 decimal places, we have truncated extra points');
   $("#price").focus();
    return false;
   }else{
   $("#security_deposit_error").text("");
   }
   }
   
 
if(price == '')
   {
   $("#price_error").text("Enter your property price");
   $("#price").focus();
   return false;
   }else
   {
   
 var cleanNum = (parseFloat(price)).toFixed(2);
   // alert(parseFloat(price)/cleanNum);
   if(parseFloat(price)/cleanNum != 1){
    $('#price_error').text('Please enter only 2 decimal places, we have truncated extra points');
    return false;
   }else{
   $("#price_error").text("");
   }
   }
   if(Cleaning_fees != '')
   
   {
   var cleanNum = (parseFloat(Cleaning_fees)).toFixed(2);
   // alert(parseFloat(security_deposit)/cleanNum);
   if(parseFloat(Cleaning_fees)/cleanNum != 1){
    $('#cleaning_fees_error').text('Please enter only 2 decimal places, we have truncated extra points');
   $("#price").focus();
    return false;
   }else{
   $("#cleaning_fees_error").text("");
   }
   }
       
   if(pro_id!='' && pro_id!='0'){
   			$.ajax({
   type:'post',
   url:baseURL+'admin/product/savetab1',
   data:{'user_id':user_id,'pro_id':pro_id,'price':price,'security_deposit':security_deposit,'Cleaning_fees':Cleaning_fees,'cancellation_policy':cancellation_policy,'cancel_description':can_description,'cancel_percentage':return_amount,'status':status,'currency':currency,'product_summary':product_summary,'req':req,'instant':instant,'video_url':video_url},
   dataType:'json',
   success:function(json)
   {
   
   /* if(json.resultval == 'Updated')
   {
	alert('Added Successfully');
   } */
   
   if($.trim(cancellation_policy)!="" && $.trim(product_title)!="" && $.trim(product_summary)!="" && $.trim(req)!=""  && $.trim(price)!="" && $.trim(can_description)!="" ){
	   alert('Added Successfully');
   }
     // window.location.href = "admin/product/add_product_form/"+json.resultval;
        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '/' +json.resultval;
          window.history.pushState({path:newurl},'',newurl);
       
   }
   });
   	}else{
   		alert('Property not valid');
   	}
      //  document.getElementById("tab1").style.display = "none";
      // document.getElementById("tab2").style.display = "block";
   }
</script>
<script type="text/javascript">
   function save_tab3(){
   	//var pro_id = window.location.hash.substr(1);
   	var pro_id = $('#prdiii').val();
   	var edit_pro_id = $('#edit_pro_id').val();
   	var list_values = $("input[name='list_name[]']:checked")
    					.map(function(){return $(this).val();}).get();
   
    					if(pro_id!='' && pro_id!='0'){	
    						$.ajax({
   type:'post',
   url:baseURL+'admin/product/savetab3',
   data:{'list_values':list_values,'pro_id':pro_id,'edit_pro_id':edit_pro_id},
   dataType:'json',
   success:function(json){
   
   
   // $('#prdiii').val(json.resultval);
   // $('#imgmsg_'+catID).hide();
   // $('#imgmsg_'+catID).show().text('Done').delay(800).text('');
   //window.location.href = "admin/product/edit_product_form/"+json.resultval;
   //alert(json.resultval);
   //window.location.hash=json.resultval;
   if(json.resultval == 'Updated'){
	alert('Added Successfully');
   }else if (json.resultval=='NoVal'){
	   
   }
   
   }
   });
   }else{
    			alert('Property not valid');
    		}	
   
   }
</script>
<script type="text/javascript">
   function save_tab4(){
   	//var pro_id = window.location.hash.substr(1);
   	var pro_id = $('#prdiii').val();
   var edit_pro_id = $('#edit_pro_id').val();
   	var location = $('#autocomplete-admin').val();
   	var country = $('#country').val();
   	var state = $('#state').val();
   	var city = $('#city').val();
   	var apt = $('#apt').val();
   	var post_code = $('#post_code').val();
   	var latitude = $('#latitude').val();
   	var longitude = $('#longitude').val();
   	var location_data = $('#autocomplete-admin').val();	
   
   
   if(location_data == '')
   {
   $("#location_error").text("Enter your location");
   $("#autocomplete-admin").focus();
   return false;
   }else{
   $("#location_error").text("");
   }
   if(country == '')
   {
   $("#country_error").text("Enter your country");
   $("#country").focus();
   return false;
   }else{
   $("#country_error").text("");
   }
   if(state == '')
   {
   $("#state_error").text("Enter your state");
   $("#state").focus();
   return false;
   }else
   {
   $("#state_error").text("");
   }
   if(city == '')
   {
   $("#city_error").text("Enter your city");
   $("#city").focus();
   return false;
   }else
   {
   $("#city_error").text("");
   }
   if(post_code != '') {
   //if(post_code.length < 6)
   if(post_code.length < 3)
   {
   $("#post_code_length_error").text("Enter Valid Zipcode");
   return false;
   } }else
   {
   $("#post_code_length_error").text("");
   }
   if(pro_id!='' && pro_id!='0'){
   		$.ajax({
   type:'post',
   url:baseURL+'admin/product/savetab4',
   data:{'pro_id':pro_id,'edit_pro_id':edit_pro_id,'location':location,'country':country,'state':state,'city':city,'apt':apt,'post_code':post_code,'latitude':latitude,'longitude':longitude},
   dataType:'json',
   success:function(json){
   
   
   // $('#prdiii').val(json.resultval);
   // $('#imgmsg_'+catID).hide();
   // $('#imgmsg_'+catID).show().text('Done').delay(800).text('');
   //window.location.href = "admin/product/edit_product_form/"+json.resultval;
   //alert(json.resultval);
   //window.location.hash=json.resultval;
   if(json.resultval == 'Updated'){
   alert('Added Successfully');
   $("#tab4").load(location.href + " #tab4");
   }
   
   }
   });
   	}else{
   		alert('Property not valid');
   	}
   
   if($.trim(location_data)!="" && $.trim(country)!="" && $.trim(state)!="" && $.trim(city)!=""){
   $("#nextlist").addClass("nxtTab_list");
   validateFormSection_listing();
   }else{ alert("Save by filling all mandatory fields and proceed to Next");  }
   
   
   }
</script>
<script type="text/javascript">
   function save_tab5(){
   var error=0;
   var error1=0;
   var pro_id = $('.minimum_stay').val(); 
  
   
   $( ".listingInfo select" ).each(function( index ) 
   {
   if($(this).val()=='' && $(this).attr("name")=="home_type")
   {
   error++;
   }
   else if($(this).val()=='' && $(this).attr("name")=="room_type")
   {
   error++;
   }
  /*  else if($(this).val()=='' && $(this).attr("name")=="minimum_stay")
   {
   error++;
   } */
   
   else if(pro_id==''){
	 error++;  
   }
   
   });
   
   /* $( ".textClass input" ).each(function( index ) 
   {
   if($(this).val()=='')
   {
   error1++;
   }
   
   }); */
   
   /* if($(".minimum_stay").val()=='')
   {
   error1++;
   } */
   
   
   //alert(error);
   //return false;
   
   if(error > 0 || error1 > 0)
   {
   alert("Please fill all the mandatory fields");
   }
   else
   {
   alert("Added Successfully");
   $("#nextdes").addClass("nxtTab_descrip");
   validateFormSection_des();
   }
   
   
   
   }
</script>
<script type="text/javascript">
   function save_tab6(){
   		//var pro_id = window.location.hash.substr(1);
   		var pro_id = $('#prdiii').val();
   	var edit_pro_id = $('#edit_pro_id').val();
   		var space = $('#space').val();
   		var other_thingnote = $('#other_thingnote').val();
   		var house_rules = $('#house_rules').val();
   		var neighbor_overview = $('#neighbor_overview').val();
   		var interact_guest = $('#interact_guest').val();
   		var guest_access = $('#guest_access').val();
   		if(pro_id!='' && pro_id!='0'){
   			$.ajax({
   type:'post',
   url:baseURL+'admin/product/savetab6',
   data:{'pro_id':pro_id,'edit_pro_id':edit_pro_id,'space':space,'other_thingnote':other_thingnote,'house_rules':house_rules,'neighbor_overview':neighbor_overview,'interact_guest':interact_guest,'guest_access':guest_access},
   dataType:'json',
   success:function(json){
   
   
   // $('#prdiii').val(json.resultval);
   // $('#imgmsg_'+catID).hide();
   // $('#imgmsg_'+catID).show().text('Done').delay(800).text('');
   //window.location.href = "admin/product/edit_product_form/"+json.resultval;
   //alert(json.resultval);
   //window.location.hash=json.resultval;
   if(json.resultval == 'Updated'){
   alert('Added Successfully');
   $("#nextseo").addClass("nxtTab_seo");
   validateFormSection_seo();
   
   }
   
   }
   });
   
   	   	}else{
   			alert('Property not valid');
   		} 	
   }
   
   
   
   
</script>
<script type="text/javascript">
   //function WordCount(){
   var wordLen = 150,
   		len; 
   		var wordLen1 = 0;
   		
   $('#description').change(function(event) {	
   //var description=$("#description").val();
    //var wordCount = description.replace( /[^\w ]/g, "" ).split( /\s+/ ).length; 
    
    
    
    
   	 len = $('#description').val().split(/[\s]+/);
   	if (len.length > wordLen) { 
   		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons
       } else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons
       	event.preventDefault();
       }
   	}
   	
   	wordsLeft = (wordLen) - len.length;
   	//alert(wordsLeft);
   	if(wordsLeft == 0) {
   	
   		$('.words-left').html('You Can not Type More then 150 Words...!');
   	} 
   });
   
   
   
   //}
    
</script>
<script>
   var maxWords = 150;
   /* jQuery('#description').keypress(function() {
       var $this, wordcount;
       $this = $(this); */
      // wordcount = $this.val().split(/\b[\s,\.-:;]*/).length;
       /* if (wordcount > maxWords) {
           jQuery(".word_count span").text("" + maxWords);
           alert("You've reached the maximum allowed words.");
           return false;
       } else {
           return jQuery(".word_count span").text(wordcount);
       }
   });  */
   
   jQuery('#description').change(function() {
       var words = $(this).val().split(/\b[\s,\.-:;]*/);
       // console.log(words.length);
       if (words.length > maxWords) {
           words.splice(maxWords);
           $(this).val(words.join(""));
           alert("You've reached the maximum allowed words. Extra words removed.");
       }
       // console.log(words.length);
   });
</script>
<script>
   /* $("#product_title").on('keyup', function(e) {
       var val = $(this).val();
      if (val.match(/[^a-zA-Z-&\s()]/g)) {
   	   document.getElementById("product_title_error").style.display = "inline";
   	   $("#product_title_error").fadeOut(5000);
   	   $("#product_title").focus();
          $(this).val(val.replace(/[^a-zA-Z-&\s()]/g, ''));
      }
   }); */
   
   $("#price").on('keyup', function(e) {
       var val = $(this).val();
      if (val.match(/[^0-9.\s]/g)) {
   	   document.getElementById("price_error_valid").style.display = "inline";
   	   $("#price_error_valid").fadeOut(5000);
   	   $("#price").focus();
          $(this).val(val.replace(/[^0-9.\s]/g, ''));
      }
   });
   
   
   $("#security_deposit").on('keyup', function(e) {
       var val = $(this).val();
      if (val.match(/[^0-9.\s]/g)) {
   	   document.getElementById("security_deposit_error").style.display = "inline";
   	   $("#security_deposit_error").fadeOut(5000);
   	   $("#security_deposit").focus();
          $(this).val(val.replace(/[^0-9.\s]/g, ''));
      }
   });

        $("#Cleaning_fees").on('keyup', function(e) {
       var val = $(this).val();
      if (val.match(/[^0-9.\s]/g)) {
         document.getElementById("cleaning_fees_error").style.display = "inline";
         $("#cleaning_fees_error").fadeOut(5000);
         $("#Cleaning_fees").focus();
          $(this).val(val.replace(/[^0-9.\s]/g, ''));
      }
   });
   
   /* $("#autocomplete-admin").on('keyup', function(e) {
       var val = $(this).val();
      if (val.match(/[^a-zA-Z-,\s]/g)) {
   	   document.getElementById("location_error_valid").style.display = "inline";
   	   $("#autocomplete-admin").focus();
   	   $("#location_error_valid").fadeOut(5000);
          $(this).val(val.replace(/[^a-zA-Z-,\s]/g, ''));
      }
   });
    */
   /* $("#country").on('keyup', function(e) {
       var val = $(this).val();
      if (val.match(/[^a-zA-Z,\s]/g)) {
   	   document.getElementById("country_error_valid").style.display = "inline";
   	   $("#country").focus();
   	   $("#country_error_valid").fadeOut(5000);
          $(this).val(val.replace(/[^a-zA-Z,\s]/g, ''));
      }
   });
   
   
   $("#state").on('keyup', function(e) {
       var val = $(this).val();
      if (val.match(/[^a-zA-Z\s]/g)) {
   	   document.getElementById("state_error_valid").style.display = "inline";
   	   $("#state").focus();
   	   $("#state_error_valid").fadeOut(5000);
          $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
      }
   });
   
   $("#city").on('keyup', function(e) {
       var val = $(this).val();
      if (val.match(/[^a-zA-Z\s]/g)) {
   	   document.getElementById("city_error_valid").style.display = "inline";
   	   $("#city").focus();
   	   $("#city_error_valid").fadeOut(5000);
          $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
      }
   }); */
   
   $("#post_code").on('keyup', function(e) {
       var val = $(this).val();
      if (val.match(/[^a-zA-Z.-\s1-9]/g)) {
   	   document.getElementById("post_code_error_valid").style.display = "inline";
   	   $("#post_code").focus();
   	   $("#post_code_error_valid").fadeOut(5000);
          $(this).val(val.replace(/[^0-9\s]/g, ''));
      }
   });
   
   
</script>
<script>
   function img(){
   <?php if (!empty($imgDetail) && !empty($product_details)){
      $this->session->set_userdata(array('product_image_'.$product_details->row()->id => $product_details->row()->image));
      foreach ($imgDetail->result() as $img){ } } 
      			$countimg = count($img->product_image);				
      						?>
   
   
   var count= <?php echo $countimg; ?>;
    if(count == 0)
                {
               alert("Please Upload Image");
                } else {
   				 $("#nextImage_up").addClass("nxtTab_amenities");
   				 validateFormSection_amenities();
   			 }
   			 
   }
</script>
<script>
   function validateFormSection() {
   	var cur = $('.nxtTab_img').parent().parent().parent().parent().parent();
   		cur.hide();
   		cur.next().show();
   		var tab = cur.parent().parent().prev();
   		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
   }
   function validateFormSection_amenities() {
   	var cur = $('.nxtTab_amenities').parent().parent().parent().parent().parent();
   		cur.hide();
   		cur.next().show();
   		var tab = cur.parent().parent().prev();
   		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
   }
   function validateFormSection_listing() {
   	var cur = $('.nxtTab_list').parent().parent().parent().parent().parent();
   		cur.hide();
   		cur.next().show();
   		var tab = cur.parent().parent().prev();
   		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
   }
   function validateFormSection_des() {
   	var cur = $('.nxtTab_descrip').parent().parent().parent().parent().parent();
   		cur.hide();
   		cur.next().show();
   		var tab = cur.parent().parent().prev();
   		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
   }
   function validateFormSection_seo() {
   	var cur = $('.nxtTab_seo').parent().parent().parent().parent().parent();
   		cur.hide();
   		cur.next().show();
   		var tab = cur.parent().parent().prev();
   		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
   }
</script>
<script type="text/javascript">
   function validateFloatKeyPress(el, evt) {
   
       var charCode = (evt.which) ? evt.which : event.keyCode;
       var number = el.value.split('.');
       if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
           return false;
       }
       //just one dot
       if(number.length>1 && charCode == 46){
            return false;
       }
       //get the carat position
       var caratPos = getSelectionStart(el);
       var dotPos = el.value.indexOf(".");
       if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
   		alert("Afer decimel two digits only allowed!");
           return false;
       }
       return true;
   }
   
   function getSelectionStart(o) {
   	if (o.createTextRange) {
   		var r = document.selection.createRange().duplicate()
   		r.moveEnd('character', o.value.length)
   		if (r.text == '') return o.value.length
   		return o.value.lastIndexOf(r.text)
   	} else return o.selectionStart
   }
</script>
<script>
   function email_publishh()
   {	
   var pro_id = $('#prdiii').val();	
   $.ajax(		
   {			
   type: 'POST',			
   url: "<?php echo base_url();?>admin/product/checkproperty_finish",			
   data: {'pro_id':pro_id},						
   success: function(data) 			
   {
   	//alert("success");
   }		
   });
   }
</script>
<script>
   function show_val(cancel_value)
   {
   	if(cancel_value.value == 'Flexible')  // (n)% amount to guest
   	{
   		//$('#return_amount').val('0');
   		$('#return_amount').attr('readonly', false);
   		$('#return_amount_percentage').show(); 
   		$('#cancel_description').show(); 
   	}
   	else if(cancel_value.value == 'Moderate') //Only 50% amount to guest 
   	{
   		$('#return_amount').val('50');
   		$('#return_amount').attr('readonly', 'true');
   		$('#return_amount_percentage').show(); 
   		$('#cancel_description').show();
   	}
   	else if(cancel_value.value == 'Strict') //Except Guest fee amount to Guest
   	{
   		$('#return_amount').val('100');
   		$('#return_amount').attr('readonly', 'true');
   		$('#return_amount_percentage').show(); 
   		$('#cancel_description').show();
   
   	}else if(cancel_value.value == 'No Refund'){ //No CashBack to Guest
		$('#return_amount').val('0');
   		$('#return_amount').attr('readonly', 'true');
   		$('#return_amount_percentage').show(); 
   		$('#cancel_description').show();
		
	}else
   	{
   		$('#return_amount_percentage').hide(); 
   		$('#cancel_description').hide();
   	}
   }
</script>
<script>
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
<?php 
   $this->load->view('admin/templates/footer.php');
   ?>