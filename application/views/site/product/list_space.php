<?php 
$this->load->view('site/templates/header');
	$accommodates="";
	//$roombedVal=json_decode($listValues->row()->listing_values);
	$roombedVal=json_decode($listValues->row()->rooms_bed);
	
	$accommodates=$roombedVal->accommodates;
?>

<script type="text/javascript">
function showView(val){

    if($('.showlist'+val).css('display')=='block'){
        $('.showlist'+val).hide('');    
    }else{
        $('.showlist'+val).show('');
    }   
}

</script>
<script type="text/javascript">
$("form").submit(function (e) {
//	alert('test super');
localStorage.setItem("room_type",'null');
localStorage.setItem("home_type",'null');
localStorage.setItem("accommodates",'null');

localStorage.setItem("location",'');
})
function click_accom(){
     $("#citylist1").css("display", "none");
}
function homeViewNew(sel){
var tmp = sel.value;
//alert(tmp);
   var tmpArr = tmp.split('-');
   var val = tmpArr[1];
   var home_type_val = tmpArr[0];
   if(val>0){
        //$('#home_type_1').val(home_type_val); // for save home type as name
        $('#home_type_1').val(val); // for save home type as id
    }else{
        $('.temp_home_type').remove();
    }
    if($('#homelist'+val).css('display')=='block'){
	
        $('#homelist'+val).hide('');    
    }else{
	
	//$('#homelist6').show('');
        $('#homelist'+val).show('');
		
    }
}
function roomViewNew(){
var tmp = $('#room_type_new').val();
   var tmpArr = tmp.split('-');
   var val = tmpArr[1];
   var home_type_val = tmpArr[0];
   if(val>0){
        //$('#room_type_1').val(home_type_val); // for save room type as name
        $('#room_type_1').val(val); // for save room type as id
    }else{
        $('.temp_home_type').remove();
    }
    if($('#homelist'+val).css('display')=='block'){
	
        $('#homelist'+val).hide('');    
    }else{
	
	//$('#homelist6').show('');
        $('#homelist'+val).show('');
		
    }
}

function homeView(val){
	 localStorage.setItem("home_type", val);
    if($('#homelist'+val).css('display')=='block'){
        $('#homelist'+val).hide();    
		$('#home_type_1').val();
    }else{
		document.getElementById("home_type"+val).checked = true;
        var home_type_val = $('#home_type'+val).val();
		$('#home_type_1').val(home_type_val);
        $('#homelist'+val).show();
    }
}

function homeVie(val){
   localStorage.setItem("room_type", val);
    if(val>0){
        document.getElementById("home_type"+val).checked = true;
        var home_type_val = $('#home_type'+val).val();
		$('#room_type_1').val(home_type_val);
    }else{
        $('.temp_home_type').remove();
    }
    if($('#homelist'+val).css('display')=='block'){
	
        $('#homelist'+val).hide('');    
    }else{
	//alert(val);
	//$('#homelist6').show('');
        $('#homelist'+val).show('');
		
    }
}



function homeView1(val){
   
        var home_type_val = $('#home_type4').val();
		//alert(home_type_val);
        $('#home1list').html(home_type_val);
		$('#roomListId').val(home_type_val);
    
    if($('#homelist1').css('display')=='block'){
	
        $('#homelist1').hide('');    
    }else{
	//alert(val);
	//$('#homelist6').show('');
        $('#homelist1').show('');
		
    }
}


function roomView(val){
    //alert(val);
    document.getElementById("room_type"+val).checked = true;
    if($('#roomlist'+val).css('display')=='block'){
        $('#roomlist'+val).hide('');    
    }else{
        $('#roomlist'+val).show('');
    }
}

function cityView(val){
    
    $('#citylist'+val).show('');
    /*if($('#citylist'+val).css('display')=='block'){
        $('#citylist'+val).hide('');    
    }else{
        $('#citylist'+val).show('');
    }*/
}

function otherView(val,val1){
    //alert(val);
    if($('#otherlist'+val).css('display')=='block'){
        $('#otherlist'+val).hide('');   
        $("#othervalue").val(val)
    }else{
        $('#otherlist'+val).show('');
    }
}

function accommodatesView(evt){
	
	localStorage.setItem("accommodates", $(evt).val());
	
    $('.accommodates_type_field_btn #citylist1').css('display','block');
    $(evt).parent().next().find('em').text($(evt).val());
	$('#accommodates').val($(evt).val());
}
function accommodateLocal(val){

	//document.getElementById("accommodateslist1").value = val;
	$('.accommodates_type_field_btn #citylist1').css('display','block');
    $(".em_selected").text(val);
	
	$('#accommodates').val(val);
}
function ViewSubmitbutton(val){
	
	localStorage.setItem("location",$("#autocompleteNewList").val());
	
 $(".continue_hide").css("opacity", "1");
}

</script>

<script type="text/javascript">

/*** 
    Simple jQuery Slideshow Script
    Released by Jon Raasch (jonraasch.com) under FreeBSD license: free to use or modify, not responsible for anything, etc.  Please link out to me if you like it :)
***/

function slideSwitch() {
    var $active = $('#slidebanner IMG.active');

    if ( $active.length == 0 ) $active = $('#slidebanner IMG:last');

    // use this to pull the images in the order they appear in the markup
    var $next =  $active.next().length ? $active.next()
        : $('#slidebanner IMG:first');

    // uncomment the 3 lines below to pull the images in random order
    
    // var $sibs  = $active.siblings();
    // var rndNum = Math.floor(Math.random() * $sibs.length );
    // var $next  = $( $sibs[ rndNum ] );


    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval( "slideSwitch()", 5000 );
	// Store

// Retrieve
var local_room_type = localStorage.getItem("room_type");
var local_home_type = localStorage.getItem("home_type");
var local_accommodates = localStorage.getItem("accommodates");

var local_location = localStorage.getItem("location");

if(local_room_type != 'null'){
	homeVie(local_room_type);
}
if(local_home_type != 'null'){
	homeView(local_home_type);
}
if($.trim(local_accommodates) != 'null'){
	accommodateLocal(local_accommodates);
}
if($.trim(local_location) != ''){

	ViewSubmitbutton(1);
	$("#autocompleteNewList").val(local_location);
	
}

});

</script>

<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery.colorbox.js"></script>
<script type="text/javascript">
$(document).ready(function(){
		initializeMapList();
		
        $(".cboxClose1").click(function(){
            $("#cboxOverlay,#colorbox").hide();
            });
        
            $(".login-popup").colorbox({width:"365px", height:"480px", inline:true, href:"#inline_login"});
            
            $(".reg-popup").colorbox({width:"365px", height:"380px", inline:true, href:"#inline_reg"});
            
            $(".forgot-popup").colorbox({width:"365px", height:"310px", inline:true, href:"#inline_forgot"});
            
            $(".register-popup").colorbox({width:"365px", height:"630px", inline:true, href:"#inline_register"});
            
        
        //Example of preserving a JavaScript event for inline calls.
            $("#onLoad").click(function(){ 
                $('#onLoad').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                return false;
            });

});
</script>


<!-- script added -->
<script type="text/javascript">
$(document).ready(function() {

    $("#location").autocomplete({
         mustMatch: true,
        source: function(request, response) {
        $("#location_warn").html('');
            $('#imageLoader').css('display','block');
            $.ajax({
                url: 'site/landing/home_search_auto',
                dataType: "json",
                data: {
                    term : request.term,
                    tableName : "city"
                },
                success: function(data) {
                
                    response(data);
                $('#imageLoader').css('display','none');    
                }
            });
        },
        change: function (event, ui) {
            if (!ui.item) {
                this.value = '';
            }
        },
        min_length: 10,
        delay: 100      
    });
});
</script>



<!-- script added 15/05/2014 -->




<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>core.js" type="text/javascript"></script>
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>new2.js"></script>
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.min.js"></script>
<?php 
    $this->load->view('site/templates/css_files',$this->data); 
    $this->load->view('site/templates/script_files',$this->data);
    ?>

<!--[if lt IE 9]>
<script src="js/html5shiv/dist/html5shiv.js"></script>
<![endif]-->
</head>
<body>

<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready( function () {
        $(".datepicker").datepicker({ minDate:0, dateFormat: 'yy-mm-dd'});
    });
    $(function() {
            $("#list_submit").click(function(){
				
				
				
				
                $("#cityser_warn").html('');
                    if(jQuery.trim($("#autocompleteNewList").val()) == '')
                    {
                        
                       // $("#cityser_warn").html('<?php if($this->lang->line('This_field_is_required') != '') { echo stripslashes($this->lang->line('This_field_is_required')); } else echo "This field is required";?>');
                       // $("#autocompleteNewList").focus();
                        //return false;
                    }
					
					else{
					localStorage.setItem("room_type",'null');
localStorage.setItem("home_type",'null');
localStorage.setItem("accommodates",'null');

localStorage.setItem("location",'');
                        $("#list_submit").submit();
                    }
                    
                    //return false; 
                });
        });
</script><script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready( function () {
        $(".datepicker").datepicker({ minDate:0, dateFormat: 'yy-mm-dd'});
    });
    $(function() {
            $("#homesearchSubmit").click(function(){
                $("#location_warn").html('');
                    if(jQuery.trim($("#location").val()) == '')
                    {
                        
                        $("#location_warn").html('<?php if($this->lang->line('This_field_is_required') != '') { echo stripslashes($this->lang->line('This_field_is_required')); } else echo "This field is required";?>');
                        $("#location").focus();
                        return false;
                    }else{
                        $("#homesearchSubmit").submit();
                    }
                    
                    //return false; 
                });
        });
</script>
<div class="dashboard listyourspace renturspce">

    
        
        <div class="list_space">
        
            <div class="list_title center rnturspc_head">
                <h1 class="border_line hr"><span><?php if($this->lang->line('list_your') != '') { echo stripslashes($this->lang->line('list_your')); } else echo "List Your Space";?></span> <hr /></h1>
           </div>
        
        
        </div>
        
    
      
    <div class="list_background">
    
        
        
            <?php echo form_open('site/product/add_space',array('id'=>'contact_form')); ?>
			<input type="hidden" name="accommodates" id="accommodates"  value="1">
			<input type="hidden" name="home_type_1" id="home_type_1"  value="1">
			<input type="hidden" name="room_type_1" id="room_type_1"  value="1">
			<div>
            <div class="list_field">
        
               <div class="home_type">
				
		
				<?php
					foreach($listspace->result() as $value){
					    $id=$value->toId;

                        if($this->session->userdata('language_code') == '')
                            $sql = 'SELECT * FROM fc_listspace_values WHERE listspace_id = '.$id.' AND and other="yes"';
                        else 
                            $sql = 'SELECT * FROM fc_listspace_values WHERE listspace_id = '.$id.' AND other="yes"';
                        $inner = $this->db->query($sql);
                        if($inner->num_rows>0)
                        {
					 ?>
					 <label class="behost-list"><?php  //echo $value->attribute_name;
					 if($value->attribute_seourl==strtolower("PropertyType")) {
						if($this->lang->line('property_type') != '') { echo stripslashes($this->lang->line('property_type')); } else echo ucfirst($value->attribute_name); 
					 } else {
						if($this->lang->line('room_type') != '') { echo stripslashes($this->lang->line('room_type')); } else echo ucfirst($value->attribute_name);  
					 }						 
					 ?><span class="req">*</span></label>
					 <div class="desin-loop">
					   <div class="home_type_field">
                       <ul class="home_type_field_btn">
                       
					 <?php
					
					 foreach($inner->result() as $listvalue)
						 { if($listvalue->other != 'Yes'){ ?>			
							
							<li>
							<?php if($value->attribute_seourl == 'roomtype'){ ?>
								<a  href="javascript:homeVie('<?php echo $listvalue->id; ?>');">
								<?php }else{ ?>
								<a  href="javascript:homeView('<?php echo $listvalue->id; ?>');">
								<?php }  ?>
									<?php /* <i class="appa_icon icon-5"></i> */ ?>

								<?php 
									$base =base_url();
									$url=getimagesize($base.'images/attribute/'.$listvalue->image);
									if(!is_array($url))
									{
									  $img="1"; //no
									}
									else {
									  $img="0";  //yes
									}
									//To Check whether the image is exist in Local Directory..
								?>  		
									
									<?php 
			
									if($listvalue->image!="" && $img=="0"){
										$imgPath=base_url().'images/attribute/'.$listvalue->image;
									}else{
										$imgPath=base_url().'images/attribute/default-list-img.png';
									}
									?>
									<img src="<?php echo $imgPath; ?>" alt="<?php echo $listvalue->list_value; ?>" class="list-img" />
									
									
									<span>
										<input type="radio" name="room_type" id="home_type<?php echo $listvalue->id; ?>" value="<?php //echo $listvalue->list_value; ?>" />
										<?php echo $listvalue->list_value; ?>
									</span>
								</a>
							</li>
					 
					 <?php
					   } }?>
					 
					 <div class="apart_hide" id="homelist1">
                            
                                <a href="javascript:homeView1('4');">
                                
                                    <div class="aparthide_left">
                                    
                                    <i class="appa_icon icon-11"></i>
                                    
                                    <span id="home1list"></span>
                                    </div>
                                    
                                    <div class="aparthide_right">
                                    
                                    <i class="aparthide_left_arrow"></i>
                                    
                                        <strong><?php if($this->lang->line('gust_love_availability') != '') { echo stripslashes($this->lang->line('gust_love_availability')); } else echo "Guests love the variety of home types availables.";?></strong>
                                    
                                    </div>
                                
                                </a>
                            
                            </div>
		<?php	
		
		
		
		foreach($inner->result() as $listvalue){ //echo $listvalue->id; echo $listvalue->list_value;?>
					<?php if($value->attribute_seourl == 'roomtype'){ ?>
					 <div class="apart_hide" id="homelist<?php echo $listvalue->id; ?>">
                            
                                <a href="javascript:homeView('<?php echo $listvalue->id; ?>');">
                        <?php }else{ ?> 
						
						<div class="apart_hide" id="homelist<?php echo $listvalue->id; ?>">
                            
                                <a href="javascript:homeView('<?php echo $listvalue->id; ?>');">

						<?php } ?>
						
                                    <div class="aparthide_left">
                                    
                                    <!--<i class="appa_icon icon-11" style="background-image:url('<?php if($listvalue->image!=""){ echo base_url().'images/attribute/'.$listvalue->image; }else{ echo base_url().'images/attribute/default-list-img.png';} ?>');background-position:0 0;"></i>-->
                                   
								<?php 
									$base =base_url();
									$url=getimagesize($base.'images/attribute/'.$listvalue->image);
									if(!is_array($url))
									{
									  $img="1"; //no
									}
									else {
									  $img="0";  //yes
									}
									//To Check whether the image is exist in Local Directory..
								?> 

								   <?php 
									if($listvalue->image!="" && $img=="0"){
										$imgPath=base_url().'images/attribute/'.$listvalue->image;
									}else{
										$imgPath=base_url().'images/attribute/default-list-img.png';
									}
									?>
									<img src="<?php echo $imgPath; ?>" alt="<?php echo $listvalue->list_value; ?>" class="list-img" />
                                    <span><?php echo $listvalue->list_value; ?></span>
                                    </div>
                                    
                                    <div class="aparthide_right">
                                    
                                    <i class="aparthide_left_arrow"></i>
                                    
                                        <strong><?php if($listvalue->list_description !='')echo $listvalue->list_description; else echo $listvalue->list_value; ?></strong>
                                    
                                    </div>
                                
                                </a>
                            
                            </div>
					<?php }if($listvalue->other == 'Yes'){?>  
					   <span>
					   <?php if($value->attribute_seourl == 'roomtype') { ?>
					   <select style="height:65px;"  onchange="javascript:roomViewNew();" class="other-opt" id="room_type_new" name="other" required>
					   <?php } else { $lst=1;?>
					   
					   <!-- <?php	 //foreach($inner->result() as $listvalue){
						//if($lst<3) {
						//if($listvalue->other == 'Yes'){
						?>
							 <select style="height:65px;"  onclick="javascript:homeViewNew(this);" class="other-opt" id="home_type_new" name="other">
							 <option value="<?php //echo $listvalue->list_value;?>-<?php //echo $listvalue->id;?>"><?php //echo ucfirst($listvalue->list_value);?></option>
							 </select>
						<?php	//}	}  $lst=$lst+1;}?> -->
						
					   <select style="height:65px;"  onchange="javascript:homeViewNew(this);" class="other-opt" id="home_type_new" name="other" required>
					   <?php } ?>
					   
					   <option value="">--<?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "select";?>--</option>
					   <?php } ?>
				<?php	$lst1=1; foreach($inner->result() as $listvalue){
					//if($lst1>=3) {
				if($listvalue->other == 'Yes'){
				?>
					 
					 <option value="<?php echo $listvalue->list_value;?>-<?php echo $listvalue->id;?>"><?php echo ucfirst($listvalue->list_value);?></option>
					 
					<?php	}	//} 
                    $lst1=$lst1+1; }?>
			</select></span>
					
					 
					
					
					 </ul>

                    </div>
				<?php	}
                }
					?>
					
    
                            
                            
                           
                        
                       
                
                </div> 
                
            
                
               <!-- <div class="rome_type">
                
                    <label>Room Type</label>
                   
                    <div class="rome_type_field">
                    
                        <ul class="rome_type_field_btn">
                        
                            <li>
                            
                                <a href="javascript:roomView('1');"><i class="appa_icon icon-5"></i>
                                
                                <span><input type="radio" name="room_type" id="room_type1" value="entire home/apt">Entire home/apt</span></a>
                            

                              <div class="tools"><i class="arsd-ico"></i>
                           <span>You're renting out an entire home</span>


                               </div>
                            </li>
                            
                            <li>
                            
                                <a href="javascript:roomView('2');"><i class="appa_icon icon-6"></i>
                                
                                <span><input type="radio" name="room_type" id="room_type2" value="private room" >Private room</span></a>
                             <div class="tools"><i class="arsd-ico"></i>
                           <span>You're renting out a private room with a home</span>


                               </div>
                            </li>
                            
                            <li>
                            
                                <a href="javascript:roomView('3');"><i class="appa_icon icon-7"></i>
                                
                                <span><input type="radio" name="room_type" id="room_type3" value="shared room" >Shared room</span></a>
                              <div class="tools"><i class="arsd-ico"></i>
                           <span>You're renting out a Common area, such as airbed in a living home</span>


                               </div>
                            </li>
                            
                            <div class="apart_hide" id="roomlist1">
                            
                                <a href="javascript:roomView('1');">
                                
                                    <div class="aparthide_left">
                                    
                                    <i class="appa_icon icon-14"></i>
                                    
                                    <span>Entire home/apt</span>
                                    
                                    </div>
                                    
                                    <div class="aparthide_right">
                                    
                                    <i class="aparthide_left_arrow"></i>
                                    
                                        <strong>Room type is one of the most important criteria for Guests.</strong>
                                    
                                    </div>
                                
                                </a>
                            
                            </div>
                            
                            <div class="apart_hide" id="roomlist2">
                            
                                <a href="javascript:roomView('2');">
                                
                                    <div class="aparthide_left">
                                    
                                    <i class="appa_icon icon-15"></i>
                                    
                                    <span>Private room</span>
                                    
                                    </div>
                                    
                                    <div class="aparthide_right">
                                    
                                    <i class="aparthide_left_arrow"></i>
                                    
                                        <strong>Room type is one of the most important criteria for Guests.</strong>
                                    
                                    </div>
                                
                                </a>
                            
                            </div>
                            
                            
                            <div class="apart_hide" id="roomlist3">
                            
                                <a href="javascript:roomView('3');">
                                
                                    <div class="aparthide_left">
                                    
                                    <i class="appa_icon icon-16"></i>
                                    
                                    <span>Shared room</span>
                                    
                                    </div>
                                    
                                    <div class="aparthide_right">
                                    
                                    <i class="aparthide_left_arrow"></i>
                                    
                                    <strong>Room type is one of the most important criteria for Guests.</strong>
                                    
                                    </div>
                                
                                </a>
                            
                            </div>
                            
                        
                        </ul>
                    
                    </div>
                
                </div>-->
                
				
			
<!-- accommodates Starts-->			
				
      <!--   <label class="behost-list"><?php //if($this->lang->line('Accommodates') != '') { echo stripslashes($this->lang->line('Accommodates')); } else echo "Accommodates";?><span class="req">*</span></label>
	
                <div class="accommodates_type">
                    <div class="accommodates_type_field" >
                    
                        <ul class="accommodates_type_field_btn">
                        
                           <li>
                                <i class="appa_icon icon-8"></i>
                                <select class="select-bor" id="accommodateslist1" onChange="accommodatesView(this)" required >
                                    <option value="">--<?php //if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "select";?>--</option>
                                      
										<?php 
								  /*  if($accommodates!=""){ 
										$accommodatesArr=@explode(',',$accommodates);
										foreach($accommodatesArr as $rows){  */
									  ?>
									 <option value="<?php //echo $rows; ?>">
											<?php// echo $rows; ?>
										</option>
									  <?php 
									 /* 	}
									  }   */
									?>
                                 
                                </select>


                            </li> 

                            <div class="apart_hide" id="citylist1" onClick="click_accom();">
                            
                              
                                    <div class="aparthide_left ">
                                    
                                    <em class="em_selected"></em>
                                    
                                    </div>
                                    
                                    <div class="aparthide_right1">
                                    
                                        <span><?php //if($this->lang->line('Whether you are hosting a lone traveler or a large group, it is important for your guests to feel comfortable.') != '') { echo stripslashes($this->lang->line('Whether you are hosting a lone traveler or a large group, it is important for your guests to feel comfortable.')); } else echo "Whether you are hosting a lone traveler or a large group, it is important for your guests to feel comfortable.";?></span>
                                    
                                    </div>

                            
                            </div>
                            
                        
                        </ul>
                    
                    </div>
                
                </div> -->
				 
				<!-- accommodates Starts Ends-->			
				
				
				
                
                
				<label class="behost-list" id="listspace_typecitylbl" style="margin-bottom:20px;"><?php if($this->lang->line('City') != '') { echo stripslashes($this->lang->line('City')); } else echo "City";?><span class="req">*</span></label>
                    
                <div class="city_type" id="listspace_typecity">
                
                    <div class="city_type_field">
                    
                        <ul class="city_type_field_btn">
                        
                            <li>
                            
                                <i class="appa_icon icon-10"></i>
                                
                                <span>
								
								<input name="city" id="autocompleteNewList" placeholder="<?php if($this->lang->line('City') != '') { echo stripslashes($this->lang->line('City')); } else echo "City";?>,<?php if($this->lang->line('State') != '') { echo stripslashes($this->lang->line('State')); } else echo "State";?>,<?php if($this->lang->line('Country') != '') { echo stripslashes($this->lang->line('Country')); } else echo "Country";?>" type="text" autocomplete="off" style="width: 100%;" onSelect="selectFunction(this)" onKeyPress="javascript:ViewSubmitbutton('1');" required>
								
                                <div id="cityser_warn" style="font-size:12px; color:#FF0000; float:right;" ></div>
                            </span>
                            
                            </li>
                            
                                                   
                        </ul>
                        
                    <div class="for_auto_ser"></div>
                    
                    </div>
                
                </div>
                
                
                <div class="city_type">
                
                    <label></label>
                    
                    <input type="submit" onClick="checkSelect()"; <?php if($this->session->userdata('fc_session_user_id')==''){?>class="login-popup continue_hide tick_icon"<?php } else {?>id="list_submit"  class="continue_hide tick_icon"<?php }?> value="<?php if($this->lang->line('Continue') != '') { echo stripslashes($this->lang->line('Continue')); } else echo "Continue";?>"/>
                    
                
                </div>
                
                
                
            </div>
             <?php echo form_close(); ?>
        
        </div>
    </div>
    
    </div>
    
   
</div></div>
<!---DASHBOARD-->

<script type="text/javascript">
function ResetFields(){
document.getElementById("contact_form").reset();
}
window.onload=ResetFields();
</script>

<script type="text/javascript">
 function checkSelect(){
   selects= document.getElementsByTagName('select');
   var city=$("#autocompleteNewList").val();
    for(i=0;i<selects.length;i++){
        x=selects[i].value;
	 if (x==null || x=="" || x=="--Select--" || city=="")
		 
	   {
		   alert("<?php if($this->lang->line('exp_fill_all') != '') { echo stripslashes($this->lang->line('exp_fill_all')); } else echo "Please fill all fields"; ?>");
		   return false;
	   }
    }
	
} 
</script>

<!---FOOTER-->
<script type="">
$(function()
{
$('#accommodateslist1').change(function(){
//alert();
//$('.accommodates_type_field_btn #citylist1').css('display','block');
//alert($(this).closest('li').text());
//$(this).closest('li').next('.citylist1').css('display','block');
//$('.accommodates_type_field_btn #citylist1').css('display','block');
});
});
</script>
<?php 
$this->load->view('site/templates/footer');
?>
<!---FOOTER-->
