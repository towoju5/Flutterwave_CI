<?php 
$this->load->view('site/templates/header');
   // $accommodates="";
   // $roombedVal=json_decode($listValues->row()->listing_values);
   // $accommodates=$roombedVal->accommodates;
?>
<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-1.5.1.min"></script>
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
   // setInterval( "slideSwitch()", 5000 );
    // Store

// Retrieve
var local_room_type = localStorage.getItem("room_type");
var local_home_type = localStorage.getItem("home_type");
var local_accommodates = localStorage.getItem("accommodates");

var local_location = localStorage.getItem("location");

if($.trim(local_location) != ''){

    ViewSubmitbutton(1);
    $("#autocompleteNewExperience").val(local_location);
    
}

});


function ViewSubmitbutton(val){
    
    localStorage.setItem("location",$("#autocompleteNewExperience").val());
    
 $(".continue_hide").css("opacity", "1");
}


</script>

<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery.colorbox.js"></script>
<script type="text/javascript">
$(document).ready(function(){

        initializeMapExperience();
        
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
  
</script><script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript">
   
</script>
<div class="dashboard listyourspace renturspce">

    <div class="main">
        
        <div class="list_space">
        
            <div class="list_title center">
                <h1 class="border_line hr"><span><?php if($this->lang->line('add_experience_heading') != '') { echo stripslashes($this->lang->line('add_experience_heading')); } else echo "Add Your Experience";?></span> <hr /></h1>
           </div>
        
        
        </div>
        
    </div>
      
    <div class="list_background">
    
        <div class="main">
        
            <?php echo form_open('site/experience/add_experience',array('id'=>'contact_form'), array('currency' => $this->session->userdata('currency_type'))); ?>
            
            <div>
            <div class="list_field">
        
               <div class="home_type">
                
        
               
                    <label class="behost-list">Exprience Type<span class="req">*</span></label>
                    <div class="desin-loop">
                        <div class="home_type_field">
                            <ul class="home_type_field_btn">


                            
                            <span>

                            <select style="height:65px;" class="other-opt" onblur="affectDateCount(this.value)" onchange="affectDateCount(this.value)" id="home_type_new" name="experience_category" required>

                            <option value="">--<?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "select";?>--</option>


                            <option value="1">Immersions</option>
                            <option value="2">Experiences</option>

                            </select></span>

                            </ul>

                        </div>
                    </div>
                
                </div> 

                <div class="home_type">
                
        
               
                    <label class="behost-list">Exprience Category<span class="req">*</span></label>
                    <div class="desin-loop">
                        <div class="home_type_field">
                            <ul class="home_type_field_btn">

                            <span>

                            <select style="height:65px;" class="other-opt" id="home_type_new" name="experience_type" required>

                            <option value="">--<?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "select";?>--</option>
                            <?php 
                            foreach($experience_typeList->result() as $type) {?>

                            <option value="<?php echo $type->id;?>"><?php echo $type->experience_title;?></option>
                            <?php } ?>

                            </select></span>

                            </ul>

                        </div>
                    </div>
                
                </div> 
                
            
                
                <label class="behost-list"><?php if($this->lang->line('experience_date_count') != '') { echo stripslashes($this->lang->line('experience_date_count')); } else echo "Date Count";?><span class="req">*</span></label>
                    
                <div class="accommodates_type">
                
                  
                    <div class="accommodates_type_field" >
                    
                        <ul class="accommodates_type_field_btn">
                        
                           <li style="width:180px">
                                <input class="select-bor" style="width:100%" type="number" min="1" name='date_count' id='date_count' placeholder="Enter Date Count" />
                              
                                
                            </li>
                            
                        
                        </ul>
                    
                    </div>
                
                </div>

                 <label class="behost-list"><?php if($this->lang->line('experience_title') != '') { echo stripslashes($this->lang->line('experience_title')); } else echo "Experience Title";?><span class="req">*</span></label>
                    
                <div class="accommodates_type">
                
                  
                    <div class="accommodates_type_field" >
                    
                        <ul class="accommodates_type_field_btn">
                        
                           <li >
                                <input class="select-bor" style="width:100%" type="text" min="1" name='experience_title' id='experience_title' placeholder="Enter Experience Title" />
                              
                                
                            </li>
                            
                        
                        </ul>
                    
                    </div>
                
                </div>
                
                
                <label class="behost-list" id="listspace_typecitylbl" style="margin-bottom:20px;"><?php if($this->lang->line('City') != '') { echo stripslashes($this->lang->line('City')); } else echo "City";?><span class="req">*</span></label>
                    
                <div class="city_type" id="listspace_typecity">
                
                    <div class="city_type_field">
                    
                        <ul class="city_type_field_btn">
                        
                            <li>
                            
                                <i class="appa_icon icon-10"></i>
                                
                                <span>
                                    <input name="city" id="autocompleteNewExperience" placeholder="<?php if($this->lang->line('City') != '') { echo stripslashes($this->lang->line('City')); } else echo "City";?>,<?php if($this->lang->line('State') != '') { echo stripslashes($this->lang->line('State')); } else echo "State";?>,<?php if($this->lang->line('Country') != '') { echo stripslashes($this->lang->line('Country')); } else echo "Country";?>" type="text" autocomplete="off" style="width: 100%;" onselect="selectFunction(this)" onKeyPress="javascript:ViewSubmitbutton('1');" required>
                                    
                                    <div id="cityser_warn" style="font-size:12px; color:#FF0000; float:right;" ></div>
                                </span>
                                
                            </li>
                            
                                                   
                        </ul>
                        
                    <div class="for_auto_ser"></div>
                    
                    </div>
                
                </div>
                
                
                <div class="city_type">
                
                    <label></label>
                    
                    <input type="submit"  <?php if($this->session->userdata('fc_session_user_id')==''){?>class="login-popup continue_hide tick_icon"<?php } else {?>id="list_submit"  class="continue_hide tick_icon"<?php }?> value="<?php if($this->lang->line('Continue') != '') { echo stripslashes($this->lang->line('Continue')); } else echo "Continue";?>"/>
                    
                
                </div>
                
                
                
            </div>
             <?php echo form_close(); ?>
        
        </div>
    </div>
    
    </div>
    
   
</div>
<!---DASHBOARD-->

<style>
@media only screen and (max-width: 1024px){

.container2.renter22 .col-md-6.leftlog{width: 48%;}
.container2.renter22 .col-md-6.rightlog{width: 52%;}

    
}

@media only screen and (max-width: 800px){
.inpt-head-place input.auto-tet[type="text"]{margin-left: 8px !important;}

}

@media only screen and (max-width: 736px){
.navbar-inner{ box-shadow: none;}
.inpt-head-place input.auto-tet[type="text"]{margin-left: 0px !important;}
}

@media only screen and (max-width: 375px){

.inpt-head-place input.auto-tet[type="text"] {
    margin-top: 40px !important;
    margin-left: 81px !important;}
    

}



</style>



<!---FOOTER-->
<script type="">
function affectDateCount(category){
    if(category=='2')
    {
        $("#date_count").val('1');
        $("#date_count").attr('readonly','readonly');

    }else if(category=='1'){
       // $("#date_count").val('2');
        $("#date_count").removeAttr('readonly');
    }
}
</script>
<?php 
$this->load->view('site/templates/footer');
?>
<!---FOOTER-->
</body>
</html>