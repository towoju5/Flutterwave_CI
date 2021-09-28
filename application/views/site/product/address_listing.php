<?php

$this->load->view('site/templates/header');

$this->load->view('site/templates/listing_head_side');
//print_r($rental_address->row());
$address = $rental_address->row()->address;

$street = '';

$street1 = '';

$area = '';

$location = '';

$city = '';

$state = '';

$country = '';

$lat = '';

$long = '';

$zip = '';



/* echo $street = $rental_address->row()->street;
echo $street1 = $rental_address->row()->area; */

$zip = $rental_address->row()->zip;

$address = str_replace(" ", "+", $address);

$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$google_map_api");

$json = json_decode($json);



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

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>addProperty.js"></script>



<div style='display:none'>



  <div id='inline_mapaddress' style='background:#fff;'>

  

  		<div class="popup_page" id="addr_pop">

  

  			<div class="popup_header"><?php if($this->lang->line('EnterAddress') != '') { echo stripslashes($this->lang->line('EnterAddress')); } else echo "Enter Address"; ?>

            	

                <div class="popup_sub_header"><?php if($this->lang->line('Whatisyour') != '') { echo stripslashes($this->lang->line('"Whatisyour')); } else echo "What is your listing's address?"; ?></div>

            

            </div>

            

            

            <div class="popup_detail">

            

            	<form name="rental_address" id="rental_address" method="post" action="site/product/insert_address" accept-charset="UTF-8">

            	<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>

            	<input type="hidden" name="actual_link" value="<?php echo $actual_link; ?>">

            	<div class="banner_signup">

                

                		<ul class="popup_address">

                        

                        	<li>

                            	

                         

                         	<label><?php if($this->lang->line('Location') != '') { echo stripslashes($this->lang->line('Location')); } else echo "Location"; ?> <span class="req"> *</span></label>

                            

                            <div class="select">

                            

                                <input required title="<?php if($this->lang->line('Location') != '') { echo stripslashes($this->lang->line('Location')); } else echo "Location"; ?>" type="text" class="title_overview" onblur="getAddressDetails();" name="address_location" placeholder="<?php if($this->lang->line('Please Enter the Location') != '') { echo stripslashes($this->lang->line('Please Enter the Location')); } else echo "Please Enter the Location";?>" id="address_location" value="<?php echo $rental_address->row()->address;?>" onFocus="geolocate()">

								<span id="location_error" style="color:#f00;display:none;">
							*<?php 	
	if($this->lang->line('charecters_only') != '')
			{ 
				echo  stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}	
	?>!</span>
								
                            </div>

                         

                         

                         	</li>

							<li>

                            	

                         

                         	<label><?php if($this->lang->line('Country') != '') { echo stripslashes($this->lang->line('Country')); } else echo "Country"; ?> <span class="req"> *</span></label>

                            

                            <div class="select">

                            

                                <input required type="text" title="<?php if($this->lang->line('Country') != '') { echo stripslashes($this->lang->line('Country')); } else echo "Country"; ?>" class="title_overview" name="country" placeholder="<?php if($this->lang->line('Please Enter the County') != '') { echo stripslashes($this->lang->line('Please Enter the County')); } else echo "Please Enter the County";?>" id="country" value="<?php echo $country;?>">

								
<span id="country_error" style="color:#f00;display:none;">*<?php 	
	if($this->lang->line('charecters_only') != '')
			{ 
				echo  stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}	
	?>!</span>

                            </div>

                         

                         

                         	</li>

                            <li>

                         

                         	<label><?php if($this->lang->line('State') != '') { echo stripslashes($this->lang->line('State')); } else echo "State"; ?> <span class="req"> *</span></label>

                            <div class="select" id="listCountryCnt">

								<input required type="text" title="<?php if($this->lang->line('State') != '') { echo stripslashes($this->lang->line('State')); } else echo "State"; ?>" class="title_overview" name="state" placeholder="<?php if($this->lang->line('Please Enter the State') != '') { echo stripslashes($this->lang->line('Please Enter the State')); } else echo "Please Enter the State";?>" id="state" value="<?php echo $state;?>">
								
								<span id="state_error" style="color:#f00;display:none;">*<?php 	
	if($this->lang->line('charecters_only') != '')
			{ 
				echo  stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}	
	?>!</span>

                          </div>

                         </li>

                         

                          <li>

                         

                         	<label><?php if($this->lang->line('City') != '') { echo stripslashes($this->lang->line('City')); } else echo "City"; ?> <span class="req"> *</span></label>

                            <div class="select" id="listStateCnt">

								<input required type="text" title="<?php if($this->lang->line('City') != '') { echo stripslashes($this->lang->line('City')); } else echo "City"; ?>" class="title_overview" name="city" placeholder="<?php if($this->lang->line('Please Enter the City') != '') { echo stripslashes($this->lang->line('Please Enter the City')); } else echo "Please Enter the City";?>" id="city" value="<?php echo $city;?>">
								
								<span id="city_error" style="color:#f00;display:none;">*<?php 	
	if($this->lang->line('charecters_only') != '')
			{ 
				echo  stripslashes($this->lang->line('charecters_only')); 
			} 
			else
			{
				echo "Characters Only";
			}	
	?>!</span>

                          </div>

                         </li>    

                         

                          <li>

                         

                         	<label><?php if($this->lang->line('StreetAddress') != '') { echo stripslashes($this->lang->line('StreetAddress')); } else echo "Street Address"; ?></label>
							
                            <input name="address" id="address" title="<?php if($this->lang->line('StreetAddress') != '') { echo stripslashes($this->lang->line('StreetAddress')); } else echo "Street Address"; ?>" type="text" placeholder="<?php if($this->lang->line('StreetAddress') != '') { echo stripslashes($this->lang->line('StreetAddress')); } else echo "Street Address"; ?>" value="<?php echo trim($street.' '.$street1);?>" class="title_overview" style="width: 100%;"/>

                         <span id="address_error" style="color:#f00;display:none;">*<?php if($this->lang->line('charecters_and_numbers_only') != '') { echo stripslashes($this->lang->line('charecters_and_numbers_only')); } else echo "Characters and Numbers Only"; ?>!</span>

                         </li>

                         

                         <li>

                         

                         	<label><?php if($this->lang->line('ZIPCode') != '') { echo stripslashes($this->lang->line('ZIPCode')); } else echo "ZIP Code"; ?></label>

                            

                         <!-- pattern="([A-z0-9À-ž\s]){6}"  onkeypress="return isNumberKey(event);"-->   
						 <input type="text" onkeypress="return isNumberKey(event);" title="<?php if($this->lang->line('ZIPCode') != '') { echo stripslashes($this->lang->line('ZIPCode')); } else echo "ZIP Code"; ?>" name="post_code"   maxlength="11" pattern="[A-Za-z1-9\s0-9/g-]{3,11}"  id="post_code" value="<?php echo $zip;?>" style="width: 100%;"  placeholder="<?php if($this->lang->line('e.g.') != '') { echo stripslashes($this->lang->line('e.g.')); } else echo "e.g.";?> 941 35DD - 3 <?php if($this->lang->line('to') != '') { echo stripslashes($this->lang->line('to')); } else echo "to"; ?> 10 <?php if($this->lang->line('digit_only') != '') { echo stripslashes($this->lang->line('digit_only')); } else echo "Digit Only"; ?>" class="title_overview" style="float:left;"/>
						 
<span id="post_code_error" style="color:#f00;display:none;">*<?php if($this->lang->line('charecters_and_numbers_only') != '') { echo stripslashes($this->lang->line('charecters_and_numbers_only')); } else echo "Characters and Numbers Only"; ?>!</span>
                         

                         </li>

                         

                         </ul>

                         

                         <div class="popup_address_bottom">

                         

                         	<input type="hidden" name="product_id" value="<?php echo $listDetail->row()->id; ?>" />

                         	<input type="hidden" name="latitude" id="latitude" value="<?php echo $rental_address->row()->lat; ?>" />

                         	<input type="hidden" name="longitude" id="longitude" value="<?php echo $rental_address->row()->lang; ?>" />

                         

                            <input type="submit" value="<?php if($this->lang->line('Submit') != '') { echo stripslashes($this->lang->line('Submit')); } else echo "Submit"; ?>" class="next_btn" onclick="return Address_Validation(this);" />

                            

                            <input type="reset" value="<?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?>" class="cancel_btn" onclick="window.location.reload();"/>

                         <!--onclick="window.history.go();" -->

                         </div>

                         

                                 

                     </div>

                    

                    </form>	

                   

            </div>

        

        </div>

        

  </div>

  

</div>





            <div class="right_side address-left">

            

            <div class="dashboard_price_main" style="border-bottom:none;">

            

            	<div class="dashboard_price">

            

                    <div class="dashboard_price_left">

                    

                    	<h3><?php if($this->lang->line('Address') != '') { echo stripslashes($this->lang->line('Address')); } else echo "Address"; ?></h3>

                        

                        <p><?php if($this->lang->line('Yourexactaddress') != '') { echo stripslashes($this->lang->line('Yourexactaddress')); } else echo "Your exact address is private and only shared with guests after a reservation is confirmed.However the host are responsible to provide the exact road name of the accommodations in order for guest to be able to plan for their trip smoothly."; ?></p>

                    
                        
                    </div>

                    

                    <div class="dashboard_price_right">

                    

						<div class="address_map_main">

                        <?php if($rental_address->row()->lat !='0.00' && $rental_address->row()->lang !='0.00'){?>

						

					

						<div id="map" style="width:323px; height:482px"></div>

  

						

						<?php }else{ ?>

						 <div id="map" style="display:none;width:323px; height:482px"></div>

                        	<div class="address_map"><img src="images/empty-map.png" width="375px" /></div>

                        	<div class="address_pointer"><img src="images/map-pin.png" /></div>

                         <?php } ?>  



						 <script>
							var myLatlng = new google.maps.LatLng(<?php echo $rental_address->row()->lat;?>,<?php echo $rental_address->row()->lang;?>);

							function load_NewMap() { 
							// Create the map.
							var mapOptions = {
							zoom: 15,
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.ROADMAP
							};

							var map = new google.maps.Map(document.getElementById('map'),
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
								console.log(newLatitude);
								console.log(newLongitude);
								var pos=marker.getPosition();		
								//console.log(pos.A);
								//console.log(pos.F);
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
												var location = json.location;
												$("#address").val(street+' '+area);
												var city = json.city;
												$("#city").val(city);
												var state = json.state;
												$("#state").val(state);
												var country = json.country;
												$("#country").val(country);
												$.ajax({
													type:'POST',
													url:'<?php echo base_url()?>site/product/save_lat_lng',
													data:{latitude:newLatitude,longitude:newLongitude,area:area,street:street,location:location,address:address,city:city,state:state,country:country,product_id:'<?php echo $listDetail->row()->id; ?>'},
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
							

}

							
							</script>

	

	

	

                            <div class="address_add">

                            <?php if($rental_address->row()->lat =='' || $rental_address->row()->lang ==''){?>

                            <span class="this-list"><?php if($this->lang->line('Thislistinghas') != '') { echo stripslashes($this->lang->line('Thislistinghas')); } else echo "This listing has no address."; ?></span>

                                 <?php } ?>                           	

                            	

                                <div class="add_address_main"><a class="add_address_btn add-address" href="#"><?php if($this->lang->line('AddAddress') != '') { echo stripslashes($this->lang->line('AddAddress')); } else echo "Add Address"; ?></a></div>

                            

                            </div>

                        

                        

                        </div>

                    

                    </div>

                <a href="<?php echo base_url()."cancel_policy/".$listDetail->row()->id;?>"><button class="next_button"><?php if($this->lang->line('Next') != '') { echo stripslashes($this->lang->line('Next')); } else echo "Next";?></button></a>

                </div>

            

            </div>

            

            </div>

            

            <div class="calender_comments">

            

            	<div class="calender_comment_content">

                
<div class="left-calender_comment">
                	<i class="calender_comment_content_icon"><img src="images/calender_available_icon.jpg" /></i>

                    </div>
<div class="right-calender_comment">
                    <div class="calender_comment_text">

                    

                    	<h2><?php if($this->lang->line('YourAddressisPrivate') != '') { echo stripslashes($this->lang->line('YourAddressisPrivate')); } else echo "Your Address is Private"; ?></h2>

                    

                    	<p><?php if($this->lang->line('Itwillonly') != '') { echo stripslashes($this->lang->line('Itwillonly')); } else echo "It will only be shared with guests after a reservation is confirmed."; ?></p>

                        

                    

                    </div></div>

                    

                </div>

            

            </div>

        

        </div>

        

    </div>

    

 <script type="text/javascript">

 function Address_Validation(evt){
	
	if(jQuery.trim($('#address_location').val())== ''){

		$('#address_location').focus();

		return false;

	}
 	else if(jQuery.trim($('#country').val())== ''){

		$('#country').focus();

		return false;

	}else if(jQuery.trim($('#state').val())== ''){

		$('#state').focus();

		return false;	

	}else if(jQuery.trim($('#city').val())== ''){

		$('#city').focus();

		return false;

	}else{

		showAddress(evt);

		return false;

		//$('#rental_address').submit();

		//return true;

	}

 

 }

 

 

function getAddressDetails()

	{

		var address = $('#address_location').val();

		$.ajax({

			type: 'POST',

			url: baseURL+'site/product/get_location',

			data: {"address":address},

			dataType:'json',

			success: function(json){

				$('#country').val(json.country);

				$('#state').val(json.state);

				$('#city').val(json.city);

				$('#address').val(json.street);

				$('#post_code').val(json.zip);

				$('#latitude').val(json.lat);

				$('#longitude').val(json.lang);

			}

		});

		

	}

$(function(){

	load_NewMap();

});

</script>  
<script type="text/javascript">
 	function isNumberKey(post_code)
{




var k;
document.all ? k = e.keyCode : k = e.which;
return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));


/*   var charCode = (evt.which) ? evt.which : event.keyCode;
 console.log(charCode);
    if (charCode != 46 && charCode != 45 && charCode > 31
    && (charCode < 48 || charCode > 57))
     return false;

  return true; */

  
} 
</script> 



<script>

$("#address_location").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("location_error").style.display = "inline";
  $("#address_location").focus();
  $("#location_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});


$("#country").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("country_error").style.display = "inline";
  $("#country").focus();
  $("#country_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});


$("#state").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("state_error").style.display = "inline";
  $("#state").focus();
  $("#state_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});


$("#city").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s]/g)) {
  document.getElementById("city_error").style.display = "inline";
  $("#city").focus();
  $("#city_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
  }
});


$("#address").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.\s0-9]/g)) {
  document.getElementById("address_error").style.display = "inline";
  $("#address").focus();
  $("#address_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s0-9]/g, ''));
  }
});

$("#post_code").on('keyup', function(e) {
   var val = $(this).val();
  if (val.match(/[^a-zA-Z.-\s0-9]/g)) {
  document.getElementById("post_code_error").style.display = "inline";
  $("#post_code").focus();
  $("#post_code_error").fadeOut(5000);
      $(this).val(val.replace(/[^a-zA-Z\s0-9]/g, ''));
  }
});

</script>

<!---DASHBOARD-->

<?php

$this->load->view('site/templates/footer');

?>

<style>

#colorbox, #cboxOverlay, #cboxWrapper{

	z-index:999 !important;
	position:fixed;
	

}
#cboxContent {   
    top: 0;
}


</style>