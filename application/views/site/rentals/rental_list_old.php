<?php 
$this->load->view('site/templates/header'); ?>

<section id='ajax-search'></section>
<section id='normal-search'>


  <link rel="stylesheet" href="css/site/themes-smoothness-jquery-ui.css"  type="text/css"/>
  <link rel="stylesheet" href="css/site/jquery.datePicker.css"/>

  <link rel="stylesheet" media="all" href="css/site/style-responsive-only.css" type="text/css" />
  <style>
  @media only screen and (max-width: 768px) {
    .jqueryDatePicker{z-index: 9;}
    
  }


  @media only screen and (max-width: 480px) {
    .jqueryDatePicker {  width: 97%;  left: 2% !important;}
  }

  @media only screen and (max-width: 414px) {
    .jqueryDatePicker { width: 100%;  left: -2% !important;}
  }


  @media only screen and (max-width: 412px) {	
    .jqueryDatePicker {  left: -3% !important;}
    
  }


</style>

<script type="text/javascript">
  var i = 0;
  var markers = [];
  function showView(val){
    $('.showlist'+val).toggle('');  
    $('.similar-listing').toggle('');  
  }
</script>

<script>
  var currencyrate=$('#currencyrate').val(); 
  var GMaxPrice=$('#GMaxPrice').val() * currencyrate;
  var GMinPrice=$('#GMinPrice').val() * currencyrate;
  
  var SMaxPrice=$('#SMaxPrice').val() * currencyrate;
  var SMinPrice=$('#SMinPrice').val() * currencyrate;
  
  var currencysym=$('#currencysym').val();
  
  
</script>
<!-- End price range-->
<?php
$bedrooms="";
$beds="";
$bedtype="";
$bathrooms="";
$noofbathrooms="";
$min_stay="";
if($listDetail->num_rows()==1){
  $roombedVal=json_decode($listDetail->row()->rooms_bed);
  $bedrooms=$roombedVal->bedrooms;
  $beds=$roombedVal->beds;
  $bedtype=$roombedVal->bedtype;
  $bathrooms=$roombedVal->bathrooms;
  $noofbathrooms=$roombedVal->noofbathrooms;
  $min_stay=$roombedVal->min_stay;
}
?>
<?php
if(1 > 0){
 //echo $PriceMaxMin->row()->MaxPrice; die;
 /* if($PriceMaxMin->row()->MaxPrice==$PriceMaxMin->row()->MinPrice){
  $MinPrice='0.00';
  }else{
  $MinPrice=$PriceMaxMin->row()->MinPrice;
  }

  if($_GET['minPrice']=='' && $_GET['maxPrice']==''){
    if($PriceMaxMin->row()->MaxPrice==$PriceMaxMin->row()->MinPrice){
      $SMinPrice='0.00';
    }else{
      $SMinPrice=$PriceMaxMin->row()->MinPrice;
    }
    $SMaxPrice=$PriceMaxMin->row()->MaxPrice;
  }else{
    $SMinPrice=$_GET['minPrice']/$this->session->userdata('currency_r');
    $SMaxPrice=$_GET['maxPrice']/$this->session->userdata('currency_r');
  }
  */
  if($PriceMax ==$PriceMin){
    $MinPrice='0.00';
  }else{
    $MinPrice=$PriceMin;
  }

  if($_GET['minPrice']=='' && $_GET['maxPrice']==''){
    if($PriceMax==$PriceMin){
      $SMinPrice='0.00';
    }else{
      $SMinPrice=$PriceMin;
    }
    $SMaxPrice=$PriceMax;
  }else{
    $SMinPrice=$_GET['minPrice']/$this->session->userdata('currency_r');
    $SMaxPrice=$_GET['maxPrice']/$this->session->userdata('currency_r');
  }

  ?>

  <input type="hidden" value="<?php echo intval($PriceMax); ?>" id="GMaxPrice" />
  <input type="hidden" value="<?php echo intval($MinPrice); ?>" id="GMinPrice" />

  <input type="hidden" value="<?php echo intval($SMaxPrice); ?>" id="SMaxPrice" />
  <input type="hidden" value="<?php echo intval($SMinPrice); ?>" id="SMinPrice" />

  <?php }else{?>
  <input type="hidden" value="50000" id="GMaxPrice" />
  <input type="hidden" value="0" id="GMinPrice" />

  <input type="hidden" value="50000" id="SMaxPrice" />
  <input type="hidden" value="0" id="SMinPrice" />

  <?php } ?>
  <input type="hidden" value="<?php echo $currencySymbol; ?>" id="currencysym" />
  <input type="hidden" value="<?php echo $this->session->userdata('currency_r'); ?>" id="currencyrate" />

<!--<script type="text/javascript" src="js/site/list_page.js"></script>
 show View more-->
 <script type="text/javascript" src="js/site/downloadxml.js"></script>
 

 <script type="text/javascript">

  function initialize(){ 
   <?php
   if(($lat != '') && ($long != '')) {
    $lat = $lat;
    $long = $long;
  } else {
   $lat = '40.7127837';
   $long = '-74.0059413';
 } ?>
 var myOptions = {
   scrollwheel: false,
   zoom: <?php if($zoom != '')echo $zoom; else echo '13'; ?>,
   zoomControl:true,
   zoomControlOptions: {
    style:google.maps.ZoomControlStyle.SMALL,
    position: google.maps.ControlPosition.RIGHT_TOP
  },
  center: new google.maps.LatLng(<?php if($zoom != '')echo $cLat;else echo $lat; ?>,<?php if($zoom != '')echo $cLong;else echo $long; ?>),
  mapTypeControl: true,
  mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
  navigationControl: true,
  mapTypeId: google.maps.MapTypeId.ROADMAP
}
map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);

google.maps.event.addListener(map, 'click', function() {
  infowindow.close();

});
google.maps.event.addListener(map, 'dragend', function() { doAjax(); } );
google.maps.event.addListener(map, 'zoom_changed', function() {  
    doAjax(); 
  });
if($('#map-div').css('display') != 'none')
{
  <?php if(isset($minLat)) { ?>
      //alert('test');
      google.maps.event.addListener(map, "idle", function() {
       var sw = new google.maps.LatLng('<?php echo $minLat;?>', '<?php echo $minLong;?>');
       var ne = new google.maps.LatLng('<?php echo $maxLat;?>', '<?php echo $maxLong;?>');
       var bounds = new google.maps.LatLngBounds(sw, ne);
       if(i < 2)map.fitBounds(bounds);
       i++;
     });
      <?php } else { ?>
    //alert('example');

    google.maps.event.addListener(map, "idle", function() {
     var sw = new google.maps.LatLng('40.7127837', '-74.0059413');
     var ne = new google.maps.LatLng('40.7127837', '-74.0059413');
     var bounds = new google.maps.LatLngBounds(sw, ne);
     if(i < 2)map.fitBounds(bounds);
     i++;
   });

    <?php } ?>   
  }
  else 
  {  

    downloadUrl();
  }
}


//<![CDATA[
      // this variable will collect the html which will eventually be placed in the side_bar 
      var side_bar_html = ""; 
      var img='images/mapIcons/marker_red.png'; 
      var yimg='images/mapIcons/marker_yellow.png';
      // arrays to hold copies of the markers and html used by the side_bar 
      // because the function closure trick doesnt work there 
      var gmarkers = []; 
      var gicons = [];
     // global "map" variable
     var map = null;
     gicons["red"] = new google.maps.MarkerImage(img,
      // This marker is 20 pixels wide by 34 pixels tall.
      new google.maps.Size(20, 34),
      // The origin for this image is 0,0.
      new google.maps.Point(0,0),
      // The anchor for this image is at 9,34.
      new google.maps.Point(9, 34));
  // Marker sizes are expressed as a Size of X,Y
  // where the origin of the image (0,0) is located
  // in the top left of the image.
  
  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.

  var iconImage = new google.maps.MarkerImage(img,
      // This marker is 20 pixels wide by 34 pixels tall.
      new google.maps.Size(20, 34),
      // The origin for this image is 0,0.
      new google.maps.Point(0,0),
      // The anchor for this image is at 9,34.
      new google.maps.Point(9, 34));
  var iconShadow = new google.maps.MarkerImage('images/mapIcons/shadow50.png',
      // The shadow image is larger in the horizontal dimension
      // while the position and offset are the same as for the main image.
      new google.maps.Size(37, 34),
      new google.maps.Point(0,0),
      new google.maps.Point(9, 34));
      // Shapes define the clickable region of the icon.
      // The type defines an HTML &lt;area&gt; element 'poly' which
      // traces out a polygon as a series of X,Y points. The final
      // coordinate closes the poly by connecting to the first
      // coordinate.
      var iconShape = {
        coord: [9,0,6,1,4,2,2,4,0,8,0,12,1,14,2,16,5,19,7,23,8,26,9,30,9,34,11,34,11,30,12,26,13,24,14,21,16,18,18,16,20,12,20,8,18,4,16,2,15,1,13,0],
        type: 'poly'
      };

      function getMarkerImage(iconColor) {
       if ((typeof(iconColor)=="undefined") || (iconColor==null)) { 
        iconColor = "red"; 
      }
      if (!gicons[iconColor]) {

        gicons[iconColor] = new google.maps.MarkerImage("images/mapIcons/marker_"+iconColor+".png",
      // This marker is 20 pixels wide by 34 pixels tall.
      new google.maps.Size(27, 32),
      // The origin for this image is 0,0.
      new google.maps.Point(0,0),
      // The anchor for this image is at 6,20.
      new google.maps.Point(9, 34));
      } 
      return gicons[iconColor];

    }

    gicons["blue"] = getMarkerImage("blue");
    gicons["green"] = getMarkerImage("green");
    gicons["yelow"] = getMarkerImage("yellow");
// A function to create the marker and set up the event window function 

/****** Yamuna Updated - 23-11-2016 ***********************/
function createMarker(latlng,name,html,color,details,rid,price,siz1,siz2,setzindex) {
	
  var labels=price;
  var contentString = html;
  var marker = new google.maps.Marker({
    position: latlng,
    label: {
     text: labels,
     color: 'white',
     fontWeight:'bold',
			/* fontSize:'',
			fontFamily:'', */
		},
		labelcolor : 'FFFFFF',
		icon:{
     url:    '<?php echo base_url();?>images/mapIcons/price-label.png',
     anchor: new google.maps.Point(20,30),
     scaledSize: new google.maps.Size(siz1, siz2)
   },
   shadow: iconShadow,
   map: map,
   title: name,
		//animation: google.maps.Animation.DROP,
    zIndex: setzindex,
  }); 
  
  google.maps.event.addListener(map, 'idle', function(event) {

    //alert('asdasd'); return false;
    //updMap(0);
    
  });
  
  
  
  /*
 * The google.maps.event.addListener() event waits for
 * the creation of the infowindow HTML structure 'domready'
 * and before the opening of the infowindow defined styles
 * are applied.
 */
 google.maps.event.addListener(infowindow, 'domready', function() {

   // Reference to the DIV which receives the contents of the infowindow using jQuery
   var iwOuter = $('.gm-style-iw');

   /* The DIV we want to change is above the .gm-style-iw DIV.
    * So, we use jQuery and create a iwBackground variable,
    * and took advantage of the existing reference to .gm-style-iw for the previous DIV with .prev().
    */
    var iwBackground = iwOuter.prev();

   // Remove the background shadow DIV
   iwBackground.children(':nth-child(2)').css({'display' : 'none'});

   // Remove the white background DIV
   iwBackground.children(':nth-child(4)').css({'display' : 'none'});
   var iwCloseBtn = iwOuter.next();

   $(iwOuter.next()).addClass("mapclsbtn");

// Apply the desired effect to the close button
iwCloseBtn.css({
  opacity: '1', // by default the close button has an opacity of 0.7
  left: '323px', top: '2px', // button repositioning
  width:'16px',
  height:'16px',
  border: '2px solid #ff4047', // increasing button border and new color
  'border-radius': '13px', // circular effect
  /*'box-shadow': '0 0 5px #3990B9' // 3D effect to highlight the button */
});

// The API automatically applies 0.7 opacity to the button after the mouseout event.
// This function reverses this event to the desired value.
iwCloseBtn.mouseout(function(){
  $(this).css({opacity: '1'});
}); 
});
 
 
 /*function createMarker(latlng,name,html,color,details,rid) {
    var contentString = html;
    var marker = new google.maps.Marker({
        position: latlng,
        icon: gicons[color],
        shadow: iconShadow,
        map: map,
        title: name,
		animation: google.maps.Animation.DROP,
        zIndex: 1
        });
  
  google.maps.event.addListener(map, 'idle', function(event) {
  
    //alert('asdasd'); return false;
    //updMap(0);
    
  });*/
  
  
  /****** Yamuna Updated - 23-11-2016 ***********************/
  google.maps.event.addListener(marker, 'click', function() {
		  //console.log(marker);
      var image = {
            url: '<?php echo base_url();?>images/mapIcons/price-label-click.png', // image is 512 x 512
            scaledSize : new google.maps.Size(marker.icon.scaledSize.width, marker.icon.scaledSize.height),
          };
          infowindow.setContent(contentString); 
          infowindow.open(map,marker);
          //Change the marker icon
          marker.setPosition(marker.position);
          marker.setIcon(image);
          marker.setZIndex(marker.zIndex);
        });
        // Switch icon on marker mouseover and mouseout
        /****** Yamuna Updated - 23-11-2016 ***********************/
        /* google.maps.event.addListener(marker, "mouseover", function() {
          marker.setIcon(gicons["yellow"]);
		  marker.setZIndex(100);
        });
        google.maps.event.addListener(marker, "mouseout", function() {
          marker.setIcon(gicons["blue"]);
        }); */
        /****** Yamuna Updated - 23-11-2016 ***********************/
        markers.push(marker);
        gmarkers.push(marker);
    // add a line to the side_bar html
    var marker_num = gmarkers.length-1;
   //side_bar_html='<div class="map-areas"><ul class="similar-listing">'+side_bar_html;
   //side_bar_html=side_bar_html+'</ul></div> onmouseover="gmarkers['+marker_num+'].setIcon(gicons.yellow)" onmouseout="gmarkers['+marker_num+'].setIcon(gicons.blue)"';
   side_bar_html +=details ;
 }
 
 
// This function picks up the click and opens the corresponding info window
function myclick(i) {
  google.maps.event.trigger(gmarkers[i], "click");
}

</script>
<?php

?>

<div id="ajax_map">
  <script type="text/javascript">

    function setAllMap(map) {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
      }
    }
  </script> 
</div>
<script type="text/javascript">

  var infowindow = new google.maps.InfoWindow(
  { 
    size: new google.maps.Size(150,150)
  });
  

    // This Javascript is based on code provided by the
    // Community Church Javascript Team
    // http://www.bisphamchurch.org.uk/   
    // http://econym.org.uk/gmap/
    // from the v2 tutorial page at:
    // http://econym.org.uk/gmap/basic3.htm 
//]]>
</script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment-with-locales.min.js"></script>
<script type="text/javascript" src="js/jquery.datePicker.js"></script>
<script>
  $(function() {
   $( "#datepicker" ).datepicker({
    minDate: 0,
    changeMonth: true,
    numberOfMonths: 1,
    onClose: function( selectedDate ) {
     $( "#datepicker1" ).datepicker( "option", "minDate", selectedDate );
     if($("#datepicker").val()!="") {
      if($("#datepicker1").val()=="") {
       $("#datepicker1").focus();
     }
   }
 }
});
   $( "#datepicker1" ).datepicker({
    changeMonth: true,
    numberOfMonths: 1,
    onClose: function( selectedDate ) {
     $( "#datepicker" ).datepicker( "option", "maxDate", selectedDate );
   }
 });

   $("#datepicker1").click(function(){
    if($("#datepicker").val()=="")
      $("#datepicker").focus();
  });
 });

  function setPagination(id) {

   $('#paginationId').val(id);
   $('#search_result_form').submit();
 }

 function doAjax(){

   $(".similar-listing").css("opacity", "0.2");
   var paginationId = $("#paginationId").val();
   var pricemin = $("#minPrice").val();
   var pricemax = $("#maxPrice").val();
   
	//var dateFrom = $("#datepicker").val();
	//var dateTo = $("#datepicker1").val();
	
	var dateFrom=$('#textRangeFrom').val();
	var  dateTo=$('#textRangeTo').val();

  //alert(dateFrom);

	var gueatsCount = $("#guests").val();
	var newRoom_type = [];
  $('.room_type:checked').each(function(i){
    newRoom_type[i] = $(this).val();
  });
  var newProperty_type = [];
  $('.property_type:checked').each(function(i){
    newProperty_type[i] = $(this).val();
  });
  var newListvalue = [];
  $('.list_value:checked').each(function(i){
    newListvalue[i] = $(this).val();
  });

  var zoom = map.getZoom();
  var bounds = map.getBounds();
  var minLat = bounds.getSouthWest().lat();
  var minLong = bounds.getSouthWest().lng();
  var maxLat = bounds.getNorthEast().lat();
  var maxLong = bounds.getNorthEast().lng();
  var cLat = bounds.getCenter().lat(); 
  var cLong = bounds.getCenter().lng(); 

  $("#zoom").val(zoom);
  $("#minLat").val(minLat);
  $("#minLong").val(minLong);
  $("#maxLat").val(maxLat);
  $("#maxLong").val(maxLong);
  $("#cLat").val(cLat);
  $("#cLong").val(cLong);

  $.ajax({
    url: '<?php echo base_url();?>site/rentals/mapViewAjax',
    type:"POST",
    data:{"paginationId":paginationId,"pricemin":pricemin,"pricemax":pricemax,"checkin":dateFrom,"checkout":dateTo,"guests":gueatsCount,"room_type":newRoom_type,"property_type":newProperty_type,"listvalue":newListvalue,"minLat":minLat,"minLong":minLong,"maxLat":maxLat,"maxLong":maxLong,"cLat":cLat,"cLong":cLong,'zoom':zoom},
    beforeSend: function() {
      $("#loading1").show();
    },
    success:function(data){
     //alert(data);
      //console.log(data);
      $("#ajax_map").html(data);     
      setAllMap(null);
      markers = [];
      downloadUrl();
      $(".similar-listing").css("opacity", "none !important");
      $("#loading1").hide();

    }
  });
}
</script>


<div class="map-search rentallisting-map">
  <div>
    <div class="sidebar listingbar">
      <div class="filters filters-collapse">
        <form class="form-horizontal trip-form" action="property?city=<?php echo $_GET['city']; ?>" method="POST" id="search_result_form" accept-charset="UTF-8">
         <ul class="filter-list unstyled">
          <li data-tooltip-position="left" rel="tooltip" title="<?php if($this->lang->line('Trip') != '') { echo stripslashes($this->lang->line('Trip')); } else echo "Trip";?>"><div class="list-titlehead"><?php if($this->lang->line('dates') != '') { echo stripslashes($this->lang->line('dates')); } else echo "Dates";?></div>
            <div class="control-group right-arel">
              <input type="hidden" name="paginationId" id="paginationId" value="<?php if($this->uri->segment(2)!='') echo $this->uri->segment(2); else echo '0';?>" />
              <!-- <input type="hidden" name="paginationId" id="paginationId" value="<?php //if($paginationId!='')echo $paginationId;else echo '0';?>" /> -->
              <input type="hidden" name="pricemin"  value="<?php echo $_POST['pricemin'];?>" id="minPrice" />
              <input type="hidden" name="pricemax" value="<?php echo $_POST['pricemax'];?>" id="maxPrice" />
              <input type="hidden" name="zoom"  value="<?php echo $zoom; ?>" id="zoom" />
              <input type="hidden" name="minLat"  value="<?php echo $minLat; ?>" id="minLat" />
              <input type="hidden" name="minLong"  value="<?php echo $minLong; ?>" id="minLong" />
              <input type="hidden" name="maxLat"  value="<?php echo $maxLat; ?>" id="maxLat" />
              <input type="hidden" name="maxLong"  value="<?php echo $maxLong; ?>" id="maxLong" />
              <input type="hidden" name="cLat"  value="<?php echo $cLat; ?>" id="cLat" />
              <input type="hidden" name="cLong"  value="<?php echo $cLong; ?>" id="cLong" />
              
              <input type="text" placeholder="<?php if($this->lang->line('check_in') != '') { echo stripslashes($this->lang->line('check_in')); } else echo "Check in";?>" value="<?php if($_GET['datefrom']!='')echo $_GET['datefrom'];else if($_POST['checkin'])echo $_POST['checkin']; ?>"  name="checkin"  id="textRangeFrom"  class="dateSearch"  readonly style="cursor:pointer;">
              
              <input type="text" placeholder="<?php if($this->lang->line('check_out') != '') { echo stripslashes($this->lang->line('check_out')); } else echo "Check out";?>"  id="textRangeTo" value="<?php if($_GET['dateto']!='')echo $_GET['dateto'];else if($_POST['checkout'])echo $_POST['checkout']; ?>" name="checkout"  class="dateSearch" readonly style="cursor:pointer;">
              <!-- id="textRangeFrom"-->
              
              
              
              
              <select data-prefill="" class="guest-select input-medium" name="guests" id="guests" 	onchange = "doAjax()">
                <?php foreach($accommodates as $accommodate) { if($accommodate==1){?>
                <option value="<?php echo $accommodate;?>" <?php if($_GET['guests']==$accommodate){?>selected="selected"<?php }?>><?php echo $accommodate;?><?php if($this->lang->line('guest_s') != '') { 
                  echo stripslashes($this->lang->line('guest_s')); } 
                  else echo "Guest"; ?></option>
                  
                  <?php } else {?>
                  <option value="<?php echo $accommodate;?>" <?php if($_GET['guests']==$accommodate || $_POST['guests']==$accommodate){?>selected="selected"<?php }?>>
                    <?php echo $accommodate;?><?php if($this->lang->line('guest') != '') { 
                      echo stripslashes($this->lang->line('guest')); } 
                      else echo "Guests"; ?></option>
                      
                      <?php }?>
                      <?php }?>
                    </select>
                  </div>
                </li>
                <?php $propertyTypes = $this->product_model->get_all_details(LISTSPACE_VALUES,array('listspace_id'=>9), array(array('field'=>'other', 'type'=>'asc'))); 
                $listRoomSpaceCondition['attribute_seourl']	=	'roomtype';
                $listRoomSpaceCondition['status']	=	'Active';
                
                $roomListSpace = $this->product_model->get_all_details(LISTSPACE,$listRoomSpaceCondition);
                
                if($roomListSpace->num_rows() != 0)
                {
                  $roomTypeListSpace	=	$roomListSpace->row()->id;
                  
                  $roomType = $this->product_model->get_all_details(LISTSPACE_VALUES,array('listspace_id'=>$roomTypeListSpace), array(array('field'=>'other', 'type'=>'asc'))); 
                  ?>
                  <li data-tooltip-position="left" rel="tooltip"  title="<?php if($this->lang->line('room_type') != '') { echo stripslashes($this->lang->line('room_type')); } else echo "Room Type";?>" >
                    <div class="list-titlehead"><?php if($this->lang->line('Room Type') != '') { echo stripslashes($this->lang->line('Room Type')); } else echo "Room Type";?></div>
                    <div class="right-arel onclk-hide roomtype-hide">
                      <?php $room_count=0;
                      foreach($roomType->result() as $room_data)
                      {
                        if($room_count < 3 ){?>
                        <label class="type_labl">

                          <input type="checkbox" name="room_type[]" class='room_type' value="<?php echo $room_data->id;?>" <?php foreach($_POST['room_type'] as $property_type) { if($property_type == $room_data->list_value){ ?> checked="checked" <?php } } ?> onchange="doAjax()"/>
                          <span class="type_room"><?php if($room_data->image != '') { ?><img style="width: 17px;height: 19px;" src="<?php echo base_url();?>/images/attribute/<?php echo $room_data->image;?>"><?php } else { ?><i class="fa fa-home" aria-hidden="true">&nbsp;</i><?php } echo $room_data->list_value;?></span>
                        </label>
                        <?php if($room_count == 2){ ?></div><?php }?>
                        <?php } else { ?>
                        <?php if($room_count == 3){ if($room_count > 2){ ?>		
                        
                        
                        <div class="drop4btn" style="width: 0%;"><i class="caret"></i></div>
                        <?php } }?>
                        <?php if($room_count == 3){  ?>
                        <label style="width:16%; float:left; border: none; background: none; display:block; margin-bottom:0;"></label>
                        <?php } ?>
                        <?php if($room_count == 3){ ?>
                        <div class="right-arel room-hidden-arel">
                          <?php } ?>
                          <label class="dropdwn_lbl type_labl">
                            <span><i class="fa fa-home" aria-hidden="true"></i>
                              <?php echo $room_data->list_value;?></span>
                              <input type="checkbox" name="room_type[]" class='room_type' value="<?php echo $room_data->id;?>" <?php foreach($_POST['room_type'] as $property_type) { if($property_type ==trim($room_data->list_value)){ ?> checked="checked" <?php } } ?> onchange="doAjax()"/>
                              
                            </label>
                            <?php } $room_count++;} ?>
                            <?php if($room_count > 3){ ?>
                          </div>
                          <?php }?>

                        </li>
                        <?php } if($Row_Rental->host_status!=1)
                        {
			/* foreach($productList->result() as $Row_Rental)
			{
				$prd_currency = $Row_Rental->currency;
				$prd_price = $Row_Rental->price;
echo count($prd_price);
echo '&nbsp;';
				echo $prd_currency;echo '&nbsp;';echo $prd_price;
				echo '&nbsp;';
				echo '</br>';echo '</br>';


			}
			
$PriceMin_c = $prd_price;
$results_min = 0;
if($Row_Rental->id != '') {
$this->db->select('*');
$this->db->from(PRODUCT);
$this->db->where('price',$PriceMin_c);
$this->db->group_by('price');
$results_min = $this->db->get()->num_rows();
echo $results_min;
} 
$PriceMin_cs = ceil($PriceMax);
$results_max = 0;
if($Row_Rental->id != '') {
$this->db->select('*');
$this->db->from(PRODUCT);
$this->db->where('price',$PriceMin_cs);
$this->db->group_by('price');
$results_max = $this->db->get()->num_rows();
echo $results_max;
}
*/
		//print_r($_SESSION['currency_type']);	




//echo $PriceMin_c;
//echo '</br>';
//echo $PriceMin_cs;
//echo '</br>';

//echo $price_col;
//echo $tot_product;
//echo $this->data['price_col'];
//foreach($price_c as $p) {
	//echo $p;
	//echo '</br>';
//}
//$price_col = 2;
//$price_col = 520;
?>

<!--<div class="graph">
<span class="bar"></span>
<?php //foreach($price_c as $p) { //$a = $p/$tot_product; echo $p." - ".$tot_product;
?>

<span class="bar" style="height:<?php //echo $p; ?>px;" data-reactid="$<?php //echo $PriceMax; ?>"></span>


<?php //} ?>

</div>-->
<div class="graph" style="display:none;">
  <?php 
/*
//print_r($price_c);
for($i=floor($PriceMin);$i<=ceil($PriceMax);$i++) {
	//echo $i;
	//echo '</br>';
	$key = array_search($price_c[$i], $price_c);

	 if($i==$key)
	{?>
		<span class="bar" style="height:<?php echo $price_c[$i]; ?>px;width:14px!important; position:absolute;" data-attr="<?php echo $i;?>"></span>
	<?php }
	else
	{?>
		<span class="bar" style="height:0px;width:0.1px!important; " data-attr="<?php echo $i;?>"></span>
	<?php }
	 
}
*/
/*foreach($price_c as $p) { 

?>
<span class="bar" style="height:<?php echo $p; ?>px;"></span>
<?php } */?>



<!-- more bars here :) -->
</div>


<li data-tooltip-position="left" rel="tooltip" title="<?php if($this->lang->line('Price') != '') { echo stripslashes($this->lang->line('Price')); } else echo "Price";?>">
  <div class="list-titlehead"><?php if($this->lang->line('price_range') != '') { echo stripslashes($this->lang->line('price_range')); } else echo "Price Range";?></div>
  <div class="price_slider right-arel">
    <div  id="slider-range"	<?php if($tot_product < 2) { ?> class="disable_slider" <?php } ?> > </div>
  </div>
  <input value="<?php echo $currencySymbol;echo floor($PriceMin);?>" style="color: rgb(94, 85, 90); text-align:right; font-weight: normal; background:none; border: medium none; box-shadow: none; margin: 	0px;position: relative;top: 20px;width: 34%;  text-align: left;float: right;width: 75%;" id="amount_pricefilter1" readonly="" type="text">
  <input value="<?php echo $currencySymbol;echo ceil($PriceMax);?>" style="color: rgb(94, 85, 90);  font-weight: normal; background:none; border: medium none; box-shadow: none; margin: -31px 0;position: static; text-align: right;float: right;width: 21.5%;margin-right: 65px;" id="amount_pricefilter2" readonly="" type="text">
</li>
<?php } ?>


<li><div class="filter-reald">
 <a href="javascript:showView('6');" class="filter-btn" ><?php if($this->lang->line('more_filters') != '') { echo stripslashes($this->lang->line('more_filters')); } else echo "More Filters";?></a>
</div></li>
<?php 
$listSpaceCondition['attribute_seourl']	=	'propertytype';
$listSpaceCondition['status']	=	'Active';

$carListSpace = $this->product_model->get_all_details(LISTSPACE,$listSpaceCondition);

if($carListSpace->num_rows() != 0)
{
 $carTypeListSpace	=	$carListSpace->row()->id;
 $propertyTypes = $this->product_model->get_all_details(LISTSPACE_VALUES,array('listspace_id'=>$carTypeListSpace), array(array('field'=>'other', 'type'=>'asc'))); 
 
 ?>
 <li title="" data-tooltip-position="left" rel="tooltip" class="showlist5 showlist6">
  <div class="list-titlehead">
    <?php echo $carListSpace->row()->attribute_name;?></div>
    <div class="right-arel onclk-hide">
      <?php
      $i=0;
				//echo "<pre>"; print_r($_POST['property_type']);
      foreach($propertyTypes->result() as $tmp)
      {

        if($i < 3 ){?>
        <label class="type_lab2">
          <input type="checkbox" name="property_type[]" class='property_type'  value="<?php echo trim($tmp->id);?>" <?php foreach($_POST['property_type'] as $property_type) { if(trim($property_type) == trim($tmp->id)){ ?> checked="checked" <?php } } ?> style="float:left;"/>
          <span class="type_room1"><?php echo $tmp->list_value;?></span>
        </label>
        <?php if($i == 2){?></div><?php }?>
        <?php } else {?>
        <?php if($i == 3){   if($i > 3){ ?><div class="drop4btn"><i class="caret"></i></div><?php } } ?>
        
        <?php if($i==3){ ?>
        <label style="width:16%; float:left; border: none; background: none; display:block; margin-bottom:0;"></label>
        <?php } ?>
        <?php if($i == 3){?>
        <div class="right-arel">
          <?php } ?>
          <label class="type_lab2">
           <input type="checkbox" name="property_type[]" class='property_type' value="<?php echo trim($tmp->id);?>" <?php foreach($_POST['property_type'] as $property_type) { if(trim($property_type) == trim($tmp->id)){ ?> checked="checked" <?php } } ?> style="float:left;"/>
           <span><?php echo $tmp->list_value;?></span>
           
           
         </label>
         <?php } $i++;} ?>
         <?php if($i > 3){ ?>
       </div>
       <?php }?>
     </li>
     <?php } 
     $list_value_loop=1;
     foreach($main_cat as $category) {
       $sec_categ_loop_count=count($sec_category[$category->id]);
       if($sec_categ_loop_count!=0 && $category->id != 12){
        ?>
        <li title="<?php echo $category->attribute_name;?>" data-tooltip-position="left" rel="tooltip" class="showlist5 showlist6" >

          <div class="list-titlehead"><?php echo $category->attribute_name;?></div>
          
          <?php
          for($i=0;$i<3;$i++){
           if($i==0){
             echo '<div class="right-arel onclk-hide">';
           }
           if($sec_category[$category->id][$i]['list_value'] != '') {
            ?>
            <label class="type_lab2">
             <input type="checkbox" name="listvalue[]" class='list_value'  value="<?php echo $sec_category[$category->id][$i]['id'];?>" <?php foreach($_POST['listvalue'] as $listid) { if($listid ==$sec_category[$category->id][$i]['id']){ ?> checked="checked" <?php } } ?> style="float:left;"/>
             <span> <?php echo $sec_category[$category->id][$i]['list_value'];?></span>
           </label>
           <?php } else break;
           $list_value_loop++;
           if($i==2){ if($sec_categ_loop_count>2){
            echo '</div><div class="drop4btn"><i class="caret"></i></div>';
          }}
          ?>
          
          <?php
        }
        for($j=3;$j<$sec_categ_loop_count;$j++){
          if($j==3){ ?>
          <label style="width:16%; float:left; border: none; background: none; display:block; margin-bottom:0;"></label>
          <?php } 
          if($j==3){
            echo '<div class="right-arel">';
          }
          ?>
          <label class="type_lab2">
            <?php //print_r($_POST['listvalue']); die; ?>
            <input type="checkbox" name="listvalue[]" class='list_value'  value="<?php echo $sec_category[$category->id][$j]['id'];?>" <?php foreach($_POST['listvalue'] as $listid) { if($listid ==$sec_category[$category->id][$j]['id']){ echo 'checked="checked"'; } } ?> style="float:left;"/>
            <span> <?php echo $sec_category[$category->id][$j]['list_value'];?></span>
          </label>
          <?php
          $list_value_loop++;
          if($j==$sec_categ_loop_count){
            echo '</div>';
          }
        }
        ?>
        
      </li>
      <?php 
    }
  }
  
  ?> 

  
	  <!---
	  <div class="showlisting clearfix showlist5 showlist6">
        <a class="show-btn23"><input class="" type="submit" value="<?php if($this->lang->line('show_listing') != '') { echo stripslashes($this->lang->line('show_listing')); } else echo "Show Listing";?>" /> </a>
      </div>
    -->
    
    <li class="showlisting showlist5 showlist6" id="show_lisid">
      <a><input class="show-btn23" type="submit" value="<?php if($this->lang->line('show_listing') != '') { echo stripslashes($this->lang->line('show_listing')); } else echo "Show Listing";?>" /> </a>
      
    </li>
  </ul>
</form>

</div>

<?php /*
<br></br>




<!---new search bar---->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
.map-search {
    border-top: 0px solid #d0d0d0;
}
.dropdown.dropdown-lg .dropdown-menu {
    margin-top: -1px;
    padding: 6px 20px;
}
.input-group-btn .btn-group {
    display: flex !important;
}
.btn-group .btn {
    border-radius: 0;
    margin-left: -1px;
}
.btn-group .btn:last-child {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}
.btn-group .form-horizontal .btn[type="submit"] {
  border-top-left-radius: 4px;
  border-bottom-left-radius: 4px;
}
.form-horizontal .form-group {
    margin-left: 0;
    margin-right: 0;
}
.form-group .form-control:last-child {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}
.btn:hover{
	border:1px solid #752b7e;
}
@media screen and (min-width: 768px) {
    #adv-search {
        width: 500px;
        margin: 0 auto;
    }
    .dropdown.dropdown-lg {
        position: static !important;
    }
    .dropdown.dropdown-lg .dropdown-menu {
        min-width: 500px;
    }
}
</style>

<div class="">
	<div class="row">
		<div class="">
            <div class="input-group" id="adv-search">
				
				 
                <input type="text" class="form-control" placeholder="Search for snippets" id="autocompleteNew" name="city" placeholder="<?php if($this->lang->line('search_where') != '') { echo stripslashes($this->lang->line('search_where')); } else echo "Where do you want to go?"; ?>" onFocus="geolocate()" type="text" onkeyup="findLocation(event);" value="<?php echo $gogole_address;?>"/>
				
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="padding: 14px 13px;"><span class="caret" style="margin-top: 0px;"></span></button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
								<h4>Explore HomestayDNN</h4>
								<form class="form-horizontal" role="form">
									<div class="btn-group" role="group" aria-label="First group">
										<button type="button" class="btn btn-success" onclick="set_search_main_category('all');">All</button>
										<button type="button" class="btn btn-default" onclick="set_search_main_category('homes')">Homes</button>
										<button type="button" class="btn btn-default" onclick="set_search_main_category('experience')">Experience</button>
									</div>
									<input type="hidden" name="searched_main_category" id="search_main_category" value="all">
								
                             
								<br>
								</form>
                            </div>
                        </div>
                       
                    </div>
                </div>
				
            </div>
          </div>
        </div>
	</div>

<script>
function set_search_main_category(s_val){
	$('#searched_main_category').val(s_val);
}
</script>
<!---new search bar end--->

<!---new search bar---->

	
*/ ?>

<div style="text-align:center;"> <img id="loading1" src="<?php echo base_url(); ?>images/loading1.gif" style="display:none;"/> </div>  
<div class="sidebar-header-placeholder"></div>
<!--<div id="header_pagination"><?php echo $newpaginationLink; ?></div>-->

<div class="search-results">
  <div class="listings-loading">
    <p> <?php if($this->lang->line('Searched Location') != '') { echo stripslashes($this->lang->line('Searched Location')); } else echo "Searched Location";?>: <strong><?php echo $gogole_address; ?></strong>  </p>
    <div id="side_bar">

    </div>
    
  </div>
  
  <div id="footer_pagination"><?php //if($config->num_rows>0){ 
    echo $paginationLink;  ?></div>
</div>

</div>

<div class="map" id="map-div" >
 <div id="map_canvas" style="width: 100%; height: 100%;"></div>
</div>


</div>
<?php if(isset($PriceMax)){ ?>
<input type="hidden" id="min_price_start" value="<?php if($PriceMin != $PriceMax)echo $PriceMin; else echo '0.00';?>">
<?php } ?>
<input type="hidden" id="GetCity" value="<?php echo addslashes(str_replace(' ','+',$_GET['city'])); ?>"  />

<script type="text/javascript">


  $(function() { 

    $( "#datepicker" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      minDate:0,
      onClose: function( selectedDate ) {
        if($( "#datepicker1" ).val()==''){
          $( "#datepicker1" ).datepicker( "option", "maxDate", selectedDate ).focus();
        }else{
          $( "#datepicker1" ).datepicker( "option", "maxDate", selectedDate );
        }
      }
    });
    $( "#datepicker1" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      minDate:0,
      onClose: function( selectedDate ) {

        if($( "#datepicker" ).val()==''){
          $( "#datepicker" ).datepicker( "option", "maxDate", selectedDate ).focus();
        }else{
          $( "#datepicker" ).datepicker( "option", "maxDate", selectedDate );
        }
      }
    });

  });

  $(".filter-primary-item i").click(function(){
   $(this).prev().attr('checked',true);
   
 });

  $(function()
  {
    $('.drop4btn').click(function()
    {
//$(this).next().slideToggle();
$(this).next().next().slideToggle();

});

    $('.drop4btn').each(function()
    {
//$(this).next().css('display','none');
$(this).next().next().css('display','none');

});

  });





  <?php 
  if(isset($PriceMax)){
    ?>
    $(function() {
      var min_price_start = $("#min_price_start").val() * 1;
      <?php if($_POST['pricemin'] != '' && $_POST['pricemax'] != '') {?>
       $("#amount_pricefilter1").val("<?php echo $this->session->userdata('currency_s');?> <?php echo $_POST['pricemin']*$this->session->userdata('currency_r');?>");
       $("#amount_pricefilter2").val("<?php echo $this->session->userdata('currency_s');?> <?php echo $_POST['pricemax']*$this->session->userdata('currency_r');?>");
       <?php } ?>
       var options = {
        range: true,
        min: Math.floor(min_price_start),
        max: Math.ceil('<?php echo $PriceMax;?>'),
        values: ['<?php if($_POST['pricemin'] != '')echo $_POST['pricemin'];else echo 0;?>', '<?php if($_POST['pricemax'] != '')echo $_POST['pricemax'];else echo $PriceMax;?>'],
        slide: function(event, ui) {
          var min = ui.values[0],
          max = ui.values[1];

          $("#amount_pricefilter1").val("<?php echo $this->session->userdata('currency_s');?>" + min);
          $("#amount_pricefilter2").val("<?php echo $this->session->userdata('currency_s');?>" + max);
           // showProducts(min, max);
         },
         change: function(event, ui) { 
           var min = ui.values[0],
           max = ui.values[1];
           $("#amount_pricefilter1").val("<?php echo $this->session->userdata('currency_s');?>" + min);
           $("#amount_pricefilter2").val("<?php echo $this->session->userdata('currency_s');?>" + max);
           showProducts(min, max);
         },
       }, min, max;
       
       $("#slider-range").slider(options);
       
       <?php if($tot_product < 2) { ?>
	//$('.ui-slider').slider('disable');
	//$(".sidebar .ui-slider-horizontal .ui-slider-range").css("background-color", "#eeeeee","left","0%","width","100%");
	//$(".ui-corner-all:nth-child(3)").css({"left":"100%"});
	<?php } ?>
  min = $("#slider-range").slider("values", 0);
  max = $("#slider-range").slider("values", 1);


  $('#autocomplete').val('<?php echo addslashes($_GET['city']);?>');
  
});
    <?php }?>
  </script>
  <script>

    function showProducts(minPrice, maxPrice) {
     <?php if($this->session->userdata('currency_r') != ''){?>
      var currency_r = <?php echo $this->session->userdata('currency_r');?>;
      <?php } ?>
	//var newMin = Math.ceil(minPrice/currency_r);
	//var newMax = Math.ceil(maxPrice/currency_r);
	var newMin = Math.ceil(minPrice);
	var newMax = Math.ceil(maxPrice);
	$("#minPrice").val(newMin);
	$("#maxPrice").val(newMax);
	doAjax();
}
</script>

</section>


<button class="hide-sm btn footer-toggle open">
  <span class="open-content">
    <i class="fa fa-globe"></i>
    <?php if($this->lang->line('Language_and_Currency') != '') { echo stripslashes($this->lang->line('Language_and_Currency')); } else echo "Language and Currency";?>
  </span>
  <span class="close-content">
    <i class="fa fa-times"></i>
    <?php if($this->lang->line('Close') != '') { echo stripslashes($this->lang->line('Close')); } else echo "Close";?>
  </span>
</button>










<!---FOOTER-->
<footer class="map-footer">
  <div class="footer-bg">
    <div class="container">

      <div class="col-md-3 inputfoot">
        <div class="country-lop">
          <script>
            function changeLanguage(e)
            {
              var strUser = e.options[e.selectedIndex].value;
              window.location.href = strUser;
            }
          </script>
          <select onChange="changeLanguage(this);">
            <?php 
            $selectedLangCode = $this->session->userdata('language_code');
            if ($selectedLangCode == ''){
              $selectedLangCode = $defaultLg[0]['lang_code'];
            }
            if (count($activeLgs)>0){
              foreach ($activeLgs as $activeLgsRow){?>              
              <option value="<?php echo base_url(); ?>lang/<?php echo $activeLgsRow['lang_code'];?>" <?php if ($selectedLangCode == $activeLgsRow['lang_code']){echo 'selected="selected"';}?> class="lang_col_rental"><?php echo $activeLgsRow['name'];?></option>
              <?php } } ?>
            </select>
<!--<input class="country" id="selected_country" placeholder="English" type="text" style="text-transform:capitalize;">
<ul class="dropdn">
             <?php 
        $selectedLangCode = $this->session->userdata('language_code');
                if ($selectedLangCode == ''){
                  $selectedLangCode = $defaultLg[0]['lang_code'];
                }
                if (count($activeLgs)>0){
                  foreach ($activeLgs as $activeLgsRow){
                ?>              
                    <li><a href="lang/<?php echo $activeLgsRow['lang_code'];?>" <?php if ($selectedLangCode == $activeLgsRow['lang_code']){echo 'class="active"';}?>><?php echo $activeLgsRow['name'];?></a></li>
                <?php } } ?>

              </ul>-->

            </div>

            <div class="country-lop">
              <script>
                function changeCurrency(e)
                {
                  var strUser = e.options[e.selectedIndex].value;
                  window.location.href = strUser;
                }
              </script>
              <select onChange="changeCurrency(this);">
                <?php 
                if($currency_setup->num_rows() >0){ 
                  foreach($currency_setup->result() as $currency_s){
                    if($currency_s->currency_type==$this->session->userdata('currency_type')){
                      $SelecTed='selected="selected"';
                    }
                    else{
                      $SelecTed='';
                    }?>             
                    <option value="<?php echo base_url(); ?>change-currency/<?php echo $currency_s->id; ?>" <?php echo $SelecTed; ?>><?php echo $currency_s->currency_type; ?></option>
                    <?php } } ?>
                  </select>
<!--<ul class="dropdn">



                 <?php 
          if($currency_setup->num_rows() >0){ 
            foreach($currency_setup->result() as $currency_s){
            if($currency_s->currency_type==$this->session->userdata('currency_type')){
            $SelecTed='selected="selected"';
            }else{
            $SelecTed='';
            }
            ?>
                      <li <?php echo $SelecTed; ?>><a href="change-currency/<?php echo $currency_s->id; ?>"><?php echo $currency_s->currency_type; ?></a></li>
                   <?php }
           }?> 
         </ul>-->
         <!-- $this->session->userdata('currency_type') -->
       </div>
     </div>


     <div class="col-md-3">
      <ul class="footer-list" id="map_fl">

        <li><span><?php if($this->lang->line('Company') != '') { echo stripslashes($this->lang->line('Company')); } else echo "Company"; ?></span></li>
        <?php 
        if ($cmsList->num_rows() > 0){
          foreach ($cmsList->result() as $row){
            if ($row->seourl == 'help') {?> 
            <li><a href="pages/<?php echo $row->seourl; ?>"><?php echo $row->page_name;?></a></li> 
            <?php } else {?>
            <li><a href="pages/<?php echo $row->seourl; ?>"><?php echo $row->page_name;?></a></li> 
            <?php } } }  ?>
          </ul>

        </div>


        <div class="col-md-3">
          <ul class="footer-list" id="map_fl">
            <li><span><?php if($this->lang->line('Service') != '') { echo stripslashes($this->lang->line('Service')); } else echo "Service";?></span></li><li><a href=""><?php if($this->lang->line('Miami') != '') { echo stripslashes($this->lang->line('Miami')); } else echo "Miami";?></a></li><li><a href=""><?php if($this->lang->line('London') != '') { echo stripslashes($this->lang->line('London')); } else echo "London";?></a></li>
          </ul>
        </div>


        <div class="col-md-3" id="map_soc" style="padding-left:0px !important; padding-right:0px !important;">

          <div class="copy-txt footer-bottom hid" style="padding:0px !important;margin-top:0px !important;border-top:none !important;background:none !important;">

           <ul class="footer-list">
             <li></li>

             <li style="<?php if ($this->config->item('facebook_link')!='') { echo "display:block"; } else { echo "display:none"; } ?>" ><a target="_blank" href="<?php echo $this->config->item('facebook_link'); ?>" alt="Facebook"><i class="fa fa-facebook"></i></a></li>

             <li style="<?php if ($this->config->item('twitter_link')!='') { echo "display:block"; } else { echo "display:none"; } ?>"><a target="_blank" href="<?php echo $this->config->item('twitter_link');?>" alt="Twitter"><i class="fa fa-twitter"></i></a></li>

             <li style="<?php if ($this->config->item('googleplus_link')!='') { echo "display:block"; } else { echo "display:none"; } ?>"><a target="_blank" href="<?php echo $this->config->item('googleplus_link');?>" alt="Sign up with Google"><i class="fa fa-google-plus"></i></a></li>


             <li style="<?php if ($this->config->item('youtube_link')!='') { echo "display:block"; } else { echo "display:none"; } ?>"><a target="_blank" href="<?php echo $this->config->item('youtube_link');?>" alt="Youtube"><i class="fa fa-youtube-play"></i></a></li>


             <li style="<?php  if ($this->config->item('pinterest') !='') { echo "display:block" ;} else { echo "display:none"; }?>"><a target="_blank" href="<?php echo $this->config->item('pinterest');?>" alt="<?php if($this->lang->line('pinterest') != '') { echo stripslashes($this->lang->line('pinterest')); } else echo "Pinterest";?>"><i class="fa fa-pinterest"></i></a></li>

           </ul>
         </div>
       </div>









     </div>
     <div class="copy-txt col-md-12 footer-bottom">




      <p style="margin-bottom: 13px;"><?php echo stripslashes($this->config->item('footer_content'));?></p>

    </div>
  </div>


</footer>
<!---FOOTER-->

<script type="text/javascript">
  $('.footer-toggle').click(function(e){
    $(this).toggleClass('open');

    $('.map-footer').toggleClass('footerup');
  });
/*$(document).click(function(e){
      //if(!e.target.closest("ul") && $(".menu a").hasClass("active")){
         $(".menu ul").toggleClass("close-content");
         $(".toggle-nav").toggleClass("active");
      }
    })*/
  </script>

  <script type="text/javascript">
   $('#textRangeFrom').datePicker({
     minDate: 0, monthCount: 2, range: '#textRangeTo'		
     
   });  
   
   
   
   $('#textRange1').datePicker({
    minDate: 0,
    monthCount: 3,
    range: ['#textRange2', '#textRange3', '#textRange4'],
    disabled: function(moment) {
      return moment.date() % 8 == 0;
    }
    

    
  });
   $('#textRangeDisabled1').datePicker({
    minDate: 0,
    monthCount: 3,
    range: ['#textRangeDisabled2', '#textRangeDisabled3'],
    disabled: [
    function(moment) {
      return 10 < moment.date();
    },
    function(moment) {
      return moment.date() < 10 || 20 < moment.date();
    },
    function(moment) {
      return moment.date() < 20;
    }
    ]
  });
</script>

<script>

  $(function() {
/*     $("#textRangeFrom").datepicker();
     $("#textRangeFrom").on("change",function(){
        var selected = $(this).val();
        alert(selected);
      });  */
      
      
	   /*   $("#textRangeFrom").on("change",function(){
			var selected = $(this).val();
				alert(selected);
     }); */
     
     
	/* 
		 $(".dateSearch").on("change",function(){
			//var selected = $(this).val();
				alert("chang");
		 }); 
    */



  });



</script>

